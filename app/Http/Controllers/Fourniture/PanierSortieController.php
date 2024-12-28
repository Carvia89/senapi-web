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
        $data = PanierSortieFourniture::with('commandeVente') // Assurez-vous que la relation est définie dans le modèle
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
            'totalQteCommandee' => $data->sum('qte_cmdee'), // Assurez-vous que ce champ existe
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
}
