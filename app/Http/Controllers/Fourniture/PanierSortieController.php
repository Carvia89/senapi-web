<?php

namespace App\Http\Controllers\Fourniture;

use App\Http\Controllers\Controller;
use App\Models\CommandeVente;
use App\Models\EntreeFourniture;
use App\Models\Kelasi;
use App\Models\Option;
use App\Models\PanierSortieFourniture;
use App\Models\SortieFourniture;
use App\Models\StockDebut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PanierSortieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer les numéros de commande distincts où etat_cmd est 1 et category_cmd est "Interne"
        $nums = CommandeVente::select('num_cmd')
            ->where('etat_cmd', 2)
            ->where('category_cmd', 'Interne')
            ->distinct()
            ->get();

        // Calcul de la somme totale de 'qte_cmdee'
        $totalBulletins = PanierSortieFourniture::sum('qte_livree');

        // Récupérer les commandes à afficher dans le tableau
        $enregistrements = PanierSortieFourniture::orderBy('created_at', 'asc')->paginate(15);

        return view('dappro.bur-fournitures.mouv-stock.livraisons.form',
            compact(
                'nums',
                'enregistrements',
                'totalBulletins'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'num_cmd' => 'required',
        ]);

        // Récupérer toutes les commandes correspondant au num_cmd
        $commandes = CommandeVente::where('num_cmd', $request->num_cmd)->get();

        // Vérifiez si des commandes ont été trouvées
        if ($commandes->isEmpty()) {
            return redirect()->back()->withErrors(['num_cmd' => 'Aucune commande trouvée pour ce numéro.']);
        }

        // Vérifier si la table est vide
        if (PanierSortieFourniture::count() > 0) {
            // Si la table n'est pas vide, vider la table
            PanierSortieFourniture::truncate();
        }

        // Insérer dans la table panier_sortie_fournitures
        foreach ($commandes as $commande) {
            PanierSortieFourniture::create([
                'commande_vente_id' => $commande->id,
                'libelle' => $commande->libelle,
                'client_id' => $commande->client_id,
                'option_id' => $commande->option_id,
                'classe_id' => $commande->classe_id,
                'qte_cmdee' => $commande->qte_cmdee,
                'date_cmd' => $commande->date_cmd,
                'type_cmd' => $commande->type_cmd,
                'category_cmd' => $commande->category_cmd,
                'qte_livree' => 0, // Valeur par défaut
                'date_sortie' => now(), // Valeur par défaut
            ]);
        }

        return redirect()->back()->withInput()->with('success', 'Les fournitures ont été ajoutées avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function livraison(Request $request)
    {
        // Calculer la somme totale de qte_livree dans le panier
        $totalQteLivree = PanierSortieFourniture::sum('qte_livree');

        // Vérifier si la somme est supérieure à 0
        if ($totalQteLivree <= 0) {
            return redirect()->back()->with('error', 'Vous n\'avez encore inséré aucune quantité à livrer!');
        }

        // Récupérer les données à partir de la table panier_sortie
        $data = PanierSortieFourniture::with('commandeVente')
            ->select('commande_vente_id', 'qte_livree', 'qte_cmdee', 'date_sortie')
            ->get();

        // Vérifiez si des données sont disponibles
        if ($data->isEmpty()) {
            return response()->json(['message' => 'Aucune donnée disponible'], 404);
        }

        // Boucle pour insérer les données dans sortie_fournitures
        foreach ($data as $panier) {
            // Insérer dans sortie_fournitures
            SortieFourniture::create([
                'commande_vente_id' => $panier->commande_vente_id,
                'qte_livree' => $panier->qte_livree,
                'date_sortie' => now(), // Ajoutez la date actuelle
            ]);

            // Mettre à jour l'état de la commande dans commande_ventes
            CommandeVente::where('id', $panier->commande_vente_id)
                ->update(['etat_cmd' => 3]);
        }

        // Vider la table panier_sortie_fournitures
        PanierSortieFourniture::truncate();

        // Générer le PDF

        $pdfData = [
            'data' => $data,
            'totalQteCommandee' => $data->sum('qte_cmdee'),
            'totalQteLivree' => $totalQteLivree,
        ];

        // Récupérer la date de livraison
        $dateLivraison = \Carbon\Carbon::parse($data->first()->date_sortie)->format('d/m/Y');

        // Générer le numéro de livraison
        $numCmd = $data->first()->commandeVente->num_cmd;

        // Extraire le suffixe du numéro de commande
        $suffixe = substr($numCmd, 3); // Supposons que le format est CMDXXXX
        $numeroLivraison = 'LVR' . str_pad($suffixe, 3, '0', STR_PAD_LEFT) . '/' . date('y');

        // Passer la date et le numéro de livraison aux données du PDF
        $pdfData['dateLivraison'] = $dateLivraison;
        $pdfData['numeroLivraison'] = $numeroLivraison;

        $pdf = PDF::loadView('dappro.bur-fournitures.Reporting.BonLivraison', $pdfData);

        // Définir le nom du fichier PDF
        $pdfFileName = 'BonLivraison_' . 45 . '.pdf';

        // Télécharger le PDF
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $pdfFileName . '"',
        ])->send();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $panier = PanierSortieFourniture::findOrFail($id);

        // Récupérer les informations nécessaires
        $optionId = $panier->option_id;
        $classeId = $panier->classe_id;

        // Calculer les sommes nécessaires pour le solde
        $stockDebut = StockDebut::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('stock_debut');

        $quantiteRecu = EntreeFourniture::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('quantiteRecu');

        $sortieFournitures = SortieFourniture::where('commande_vente_id', $panier->commande_vente_id)
            ->sum('qte_livree');

        $panierSortieFournitures = PanierSortieFourniture::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('qte_livree');

        // Calculer le solde
        $solde = $stockDebut + $quantiteRecu - $sortieFournitures;

        // Calcul de la somme totale de 'qte_cmdee'
        $totalBulletins = PanierSortieFourniture::sum('qte_livree');

        // Récupérer les commandes à afficher dans le tableau
        $enregistrements = PanierSortieFourniture::orderBy('created_at', 'asc')->paginate(15);

        return view('dappro.bur-fournitures.mouv-stock.livraisons.edit', compact(
            'panier',
            'solde',
            'totalBulletins',
            'enregistrements'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validatedData = $request->validate([
            'qte_livree' => 'required|numeric|min:0',
            'date_sortie' => 'required|date',
        ]);

        // Récupérer l'entrée à mettre à jour
        $panier = PanierSortieFourniture::findOrFail($id);

        // Récupérer les informations nécessaires
        $optionId = $panier->option_id;
        $classeId = $panier->classe_id;
        $qteCmdee = $request->input('qte_cmdee');
        $qteLivree = $request->input('qte_livree');

        // Calculer les sommes nécessaires
        $stockDebut = StockDebut::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('stock_debut');

        $quantiteRecu = EntreeFourniture::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('quantiteRecu');

        $sortieFournitures = SortieFourniture::where('commande_vente_id', $panier->commande_vente_id)
            ->sum('qte_livree');

        $panierSortieFournitures = PanierSortieFourniture::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('qte_livree');

        // Calculer le solde
        $solde = $stockDebut + $quantiteRecu - $sortieFournitures;

        // Vérification des conditions
        if ($qteLivree <= $solde && $qteLivree <= $qteCmdee) {
            // Mise à jour des champs
            $panier->qte_livree = $qteLivree;
            $panier->date_sortie = $request->input('date_sortie');
            $panier->save();

            // Stocker les identifiants de commande dans la session pour les réutiliser
            session([
                'date_sortie' => $validatedData['date_sortie'],
            ]);

            return redirect()->route('admin.sortie-Fourniture.create')->with('success', 'Quantité livrée mise à jour avec succès.');
        } else {
            return redirect()->back()->withErrors(['qte_livree' => 'Le solde est insuffisant ou la quantité livrée dépasse la quantité commandée.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function inventaire()
    {
        $options = Option::all();
        $kelasis = Kelasi::all();

    // Sous-requête pour les quantités reçues
    $quantiteRecue = DB::table('entree_fournitures')
        ->select('option_id', 'classe_id', DB::raw('SUM(quantiteRecu) AS total_recue'))
        ->groupBy('option_id', 'classe_id');

    // Sous-requête pour les quantités livrées
    $qteLivree = DB::table('sortie_fournitures as sf')
        ->join('commande_ventes as cv', 'sf.commande_vente_id', '=', 'cv.id')
        ->select('cv.option_id', 'cv.classe_id', DB::raw('SUM(sf.qte_livree) AS total_livree'))
        ->groupBy('cv.option_id', 'cv.classe_id');

    // Requête principale avec pagination et tri
    $enregistrements = DB::table('stock_debuts AS sd')
        ->select('sd.option_id', 'sd.classe_id', 'sd.stock_debut',
                 DB::raw('COALESCE(qr.total_recue, 0) AS quantite_recue'),
                 DB::raw('COALESCE(ql.total_livree, 0) AS qte_livree'))
        ->leftJoin(DB::raw("({$quantiteRecue->toSql()}) as qr"),
                   function ($join) {
                       $join->on('sd.option_id', '=', 'qr.option_id')
                            ->on('sd.classe_id', '=', 'qr.classe_id');
                   })
        ->leftJoin(DB::raw("({$qteLivree->toSql()}) as ql"),
                   function ($join) {
                       $join->on('sd.option_id', '=', 'ql.option_id')
                            ->on('sd.classe_id', '=', 'ql.classe_id');
                   })
        ->mergeBindings($quantiteRecue) // Ajouter les bindings de la sous-requête
        ->mergeBindings($qteLivree) // Ajouter les bindings de la sous-requête
        ->groupBy('sd.option_id', 'sd.classe_id', 'sd.stock_debut', 'qr.total_recue', 'ql.total_livree') // Ajoutez les colonnes agrégées
        ->orderBy('sd.option_id', 'asc') // Tri par option_id en ordre croissant
        ->paginate(25); // Pagination à 25 éléments par page

        return view('dappro.bur-fournitures.mouv-stock.inventaires.index',
            compact(
                'enregistrements',
                'options',
                'kelasis'
            )
        );
    }

    public function situationGenerale()
    {
        // Récupérer les options avec niveau_id = 6
        $options = Option::where('niveau_id', 6)->pluck('id');

        $data = [];
        $totalQte1ère = 0;
        $totalQte2è = 0;
        $totalQte3è = 0;
        $totalQte4è = 0;

        foreach ($options as $optionId) {
            // Initialiser les soldes par classe à 0
            $soldeClasses = [
                '1ère' => 0,
                '2è' => 0,
                '3è' => 0,
                '4è' => 0,
            ];

            // 1. StockDebut
            $stockDebutRecords = StockDebut::where('option_id', $optionId)->get();
            foreach ($stockDebutRecords as $record) {
                switch ($record->classe_id) {
                    case 1:
                        $soldeClasses['1ère'] += $record->stock_debut;
                        break;
                    case 2:
                        $soldeClasses['2è'] += $record->stock_debut;
                        break;
                    case 3:
                        $soldeClasses['3è'] += $record->stock_debut;
                        break;
                    case 4:
                        $soldeClasses['4è'] += $record->stock_debut;
                        break;
                }
            }

            // 2. EntreeFourniture
            $entreeRecords = EntreeFourniture::where('option_id', $optionId)->get();
            foreach ($entreeRecords as $record) {
                switch ($record->classe_id) {
                    case 1:
                        $soldeClasses['1ère'] += $record->quantiteRecu;
                        break;
                    case 2:
                        $soldeClasses['2è'] += $record->quantiteRecu;
                        break;
                    case 3:
                        $soldeClasses['3è'] += $record->quantiteRecu;
                        break;
                    case 4:
                        $soldeClasses['4è'] += $record->quantiteRecu;
                        break;
                }
            }

            // 3. SortieFourniture
            $sortieRecords = SortieFourniture::join('commande_ventes', 'sortie_fournitures.commande_vente_id', '=', 'commande_ventes.id')
                ->where('commande_ventes.option_id', $optionId)
                ->get();

            foreach ($sortieRecords as $record) {
                switch ($record->classe_id) {
                    case 1:
                        $soldeClasses['1ère'] -= $record->qte_livree;
                        break;
                    case 2:
                        $soldeClasses['2è'] -= $record->qte_livree;
                        break;
                    case 3:
                        $soldeClasses['3è'] -= $record->qte_livree;
                        break;
                    case 4:
                        $soldeClasses['4è'] -= $record->qte_livree;
                        break;
                }
            }

            // Ajouter les soldes au tableau de données
            $data[] = [
                'option' => Option::find($optionId)->designation,
                'qte1ère' => max(0, $soldeClasses['1ère']),
                'qte2è' => max(0, $soldeClasses['2è']),
                'qte3è' => max(0, $soldeClasses['3è']),
                'qte4è' => max(0, $soldeClasses['4è']),
            ];

            // Mettre à jour les totaux
            $totalQte1ère += $soldeClasses['1ère'];
            $totalQte2è += $soldeClasses['2è'];
            $totalQte3è += $soldeClasses['3è'];
            $totalQte4è += $soldeClasses['4è'];
        }

        $pdf = PDF::loadView('dappro.bur-fournitures.Reporting.sitGenHum',
                    compact('data', 'totalQte1ère', 'totalQte2è', 'totalQte3è', 'totalQte4è'));

        return $pdf->stream('');
    }

    public function situationGeneraleBulScol()
    {
        $soldes = [
            'maternelle' => [
                'niveau_1' => 0,
                'niveau_1_class_10' => 0,
               // 'niveau_6_cycle_2' => 0,
            ],
            'primaire' => [
                'niveau_2' => 0,
                'niveau_3' => 0,
                'niveau_4' => 0,
                'niveau_5' => 0,
            ],
            'secondaire' => [
                'niveau_7' => 0,
                'niveau_8' => 0,
            ],
            'humanite_cycle_long' => [
                'niveau_1' => 0,
                'niveau_2' => 0,
                'niveau_3' => 0,
                'niveau_4' => 0,
            ],
            'humanite_cycle_court' => [
                'niveau_1' => 0,
                'niveau_2' => 0,
                'niveau_3' => 0,
            ],
        ];

        $totaux = [
            'maternelle' => 0,
            'primaire' => 0,
            'secondaire' => 0,
            'humanite_cycle_long' => 0,
            'humanite_cycle_court' => 0,
        ];

        // Boucle à travers chaque niveau de 1 à 6
        for ($niveauId = 1; $niveauId <= 6; $niveauId++) {
            $options = Option::where('niveau_id', $niveauId)->pluck('id');

            // Calculer les soldes pour chaque classe en fonction du niveau
            if ($niveauId == 1) {
                $soldes['maternelle']['niveau_1'] = $this->calculerSolde(1, $options); // 1è Maternelle
                $soldes['maternelle']['niveau_1_class_10'] = $this->calculerSolde(10, $options); // 2è et 3è Maternelle
            } elseif ($niveauId == 2) {
                $soldes['primaire']['niveau_2'] = $this->calculerSolde(9, $options); // 1è et 2è Primaire
            } elseif ($niveauId == 3) {
                $soldes['primaire']['niveau_3'] = $this->calculerSolde(11, $options); // 3è et 4è Primaire
            } elseif ($niveauId == 4) {
                $soldes['primaire']['niveau_4'] = $this->calculerSolde(5, $options); // 5è Primaire
                $soldes['primaire']['niveau_5'] = $this->calculerSolde(6, $options); // 6è Primaire
            } elseif ($niveauId == 5) {
                $soldes['secondaire']['niveau_7'] = $this->calculerSolde(7, $options); // 7è Secondaire
                $soldes['secondaire']['niveau_8'] = $this->calculerSolde(8, $options); // 8è Secondaire
            } elseif ($niveauId == 6) {
                $soldes['humanite_cycle_long']['niveau_1'] = $this->calculerSolde(1, $options); // 1ère Humanité Cycle Long
                $soldes['humanite_cycle_long']['niveau_2'] = $this->calculerSolde(2, $options); // 2ème Humanité Cycle Long
                $soldes['humanite_cycle_long']['niveau_3'] = $this->calculerSolde(3, $options); // 3ème Humanité Cycle Long
                $soldes['humanite_cycle_long']['niveau_4'] = $this->calculerSolde(4, $options); // 4ème Humanité Cycle Long
            } elseif ($niveauId == 6) {
                $soldes['humanite_cycle_court']['niveau_1'] = $this->calculerSolde(1, $options); // 1ère Humanité Cycle Court
                $soldes['humanite_cycle_court']['niveau_2'] = $this->calculerSolde(2, $options); // 2ème Humanité Cycle Court
                $soldes['humanite_cycle_court']['niveau_3'] = $this->calculerSolde(3, $options); // 3ème Humanité Cycle Court
            }
        }

        // Calculer les totaux par section
        $totaux = $this->calculerTotaux($soldes);

        // Calculer le total général à partir des sous-totaux
        $totalGeneral = array_sum($totaux);

        // Générer le PDF
        $pdf = PDF::loadView('dappro.bur-fournitures.Reporting.sitGenBulScol',
                    compact('soldes', 'totaux', 'totalGeneral'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('');
    }

    private function calculerSolde($classeId, $options)
    {
        // Récupérer le stock de début
        $stockDebut = StockDebut::whereIn('option_id', $options)
            ->where('classe_id', $classeId)
            ->sum('stock_debut');

        // Récupérer la quantité reçue
        $quantiteRecu = EntreeFourniture::whereIn('option_id', $options)
            ->where('classe_id', $classeId)
            ->sum('quantiteRecu');

        // Récupérer la quantité livrée
        $qteLivree = SortieFourniture::join('commande_ventes', 'sortie_fournitures.commande_vente_id', '=', 'commande_ventes.id')
            ->whereIn('commande_ventes.option_id', $options)
            ->where('commande_ventes.classe_id', $classeId)
            ->sum('qte_livree');

        return $stockDebut + $quantiteRecu - $qteLivree;
    }

    private function calculerTotaux($soldes)
    {
        $totaux = [
            'maternelle' => 0,
            'primaire' => 0,
            'secondaire' => 0,
            'humanite_cycle_long' => 0,
            'humanite_cycle_court' => 0,
        ];

        // Calculer les totaux par section
        foreach ($soldes as $section => $classes) {
            foreach ($classes as $solde) {
                $totaux[$section] += $solde;
            }
        }

        return $totaux;
    }
}
