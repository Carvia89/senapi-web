<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use App\Models\CommandeVente;
use App\Models\PanierSortieFourniture;
use App\Models\SortieFourniture;
use App\Models\SortieVente;
use App\Models\StockDebutVente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivraisonVenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les commandes avec les critères spécifiés et ajouter la pagination
        $enregistrements = CommandeVente::select('commande_ventes.num_cmd', 'commande_ventes.client_id',
                DB::raw('SUM(commande_ventes.qte_cmdee) as total_qte_cmdee'),
                DB::raw('SUM(sortie_ventes.qte_sortie) as total_qte_sortie'),
                DB::raw('MIN(sortie_ventes.date_sortie) as first_date_sortie'))
            ->leftJoin('sortie_ventes', 'commande_ventes.id', '=', 'sortie_ventes.commande_vente_id')
            ->where('commande_ventes.etat_cmd', 0)
            //->where('commande_ventes.category_cmd', 'Interne')
            ->groupBy('commande_ventes.num_cmd', 'commande_ventes.client_id')
            ->paginate(5);

        // Retourner la vue avec les enregistrements
        return view('dappro.bur-ventes.livraison.index', compact('enregistrements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer les numéros de commande réceptionnée susceptible d'être livrées
        // et ceux de commande externe (petite commande livrable dans le stock du bureau vente)
        $nums = CommandeVente::where(function($query) {
            $query->where('etat_cmd', 4)->where('category_cmd', 'Interne')
                ->orWhere(function($query) {
                    $query->where('etat_cmd', 1)->where('category_cmd', 'Externe');
                });
        })->select('num_cmd')->distinct()->get();

        // Passer les détails de la commande sélectionnée dans panier
        $enregistrements = PanierSortieFourniture::orderBy('created_at', 'asc')->paginate(15);

        // Calcul de la somme totale de 'qte_livree'
        $totalBulletins = PanierSortieFourniture::sum('qte_livree');

        // Retourner la vue avec les numéros de commande
        return view('dappro.bur-ventes.livraison.form', compact('nums', 'enregistrements', 'totalBulletins'));
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

        // Récupérer les numéros de commande selon les critères spécifiés
        $nums = CommandeVente::where(function($query) {
            $query->where('etat_cmd', 4)->where('category_cmd', 'Interne')
                ->orWhere(function($query) {
                    $query->where('etat_cmd', 1)->where('category_cmd', 'Externe');
                });
        })->select('num_cmd')->distinct()->pluck('num_cmd');

        // Récupérer les commandes avec les sorties correspondantes
        $commandes = CommandeVente::select('commande_ventes.*', 'sortie_fournitures.qte_livree', 'sortie_fournitures.date_sortie')
            ->leftJoin('sortie_fournitures', 'commande_ventes.id', '=', 'sortie_fournitures.commande_vente_id')
            ->where('commande_ventes.num_cmd', $request->num_cmd)
            ->whereIn('commande_ventes.num_cmd', $nums) // Vérifier si le numéro de commande est dans ceux récupérés
            ->get();

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
            // Vérifier si la catégorie de la commande est Externe
            $qteLivree = ($commande->category_cmd === 'Externe') ? 0 : $commande->qte_livree;
            $dateSortie = ($commande->category_cmd === 'Externe') ? now() : $commande->date_sortie;

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
                'qte_livree' => $qteLivree, // Utiliser la valeur déterminée
                'date_sortie' => $dateSortie, // Utiliser la date déterminée
            ]);
        }

        return redirect()->back()->withInput()->with('success', 'Commande validée avec succès !');
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
        $stockDebut = StockDebutVente::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('stock_debut');

        // La somme de quantités livrées par le bureau Fournitures réceptionnées par le bureau Vente
        $quantiteRecu = SortieFourniture::where('commande_vente_id', $panier->commande_vente_id)
            ->where('description', 1)
            ->sum('qte_livree');

        $sortieVentes = SortieVente::where('commande_vente_id', $panier->commande_vente_id)
            ->sum('qte_sortie');

        $paniersortieVentes = PanierSortieFourniture::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('qte_livree');

        // Calculer le solde
        $solde = $stockDebut + $quantiteRecu - $sortieVentes;

        // Calcul de la somme totale de 'qte_cmdee'
        $totalBulletins = PanierSortieFourniture::sum('qte_livree');

        // Récupérer les commandes à afficher dans le tableau
        $enregistrements = PanierSortieFourniture::orderBy('created_at', 'asc')->paginate(15);

        return view('dappro.bur-ventes.livraison.edit', compact(
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
            'qte_sortie' => 'required|numeric|min:0',
            'date_sortie' => 'required|date',
        ]);

        // Récupérer l'entrée à mettre à jour
        $panier = PanierSortieFourniture::findOrFail($id);

        // Récupérer les informations nécessaires
        $optionId = $panier->option_id;
        $classeId = $panier->classe_id;
        $qteCmdee = $request->input('qte_cmdee');
        $qteLivree = $request->input('qte_sortie');

        // Calculer les sommes nécessaires pour le solde
        $stockDebut = StockDebutVente::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('stock_debut');

        // La somme de quantités livrées par le bureau Fournitures réceptionnées par le bureau Vente
        $quantiteRecu = SortieFourniture::where('commande_vente_id', $panier->commande_vente_id)
            ->where('description', 1)
            ->sum('qte_livree');

        $sortieVentes = SortieVente::where('commande_vente_id', $panier->commande_vente_id)
            ->sum('qte_sortie');

        $paniersortieVentes = PanierSortieFourniture::where('option_id', $optionId)
            ->where('classe_id', $classeId)
            ->sum('qte_livree');

        // Calculer le solde
        $solde = $stockDebut + $quantiteRecu - $sortieVentes;

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

            return redirect()->route('admin.livraison-Vente.create')->with('success', 'Quantité livrée mise à jour avec succès.');
        } else {
            return redirect()->back()->withErrors(['qte_sortie' => 'Le solde est insuffisant ou la quantité livrée dépasse la quantité commandée.']);
        }
    }

    public function getCommandDetails($num_cmd)
    {
        // Récupérer la somme des qte_cmdee pour le numéro de commande sélectionné
        $totalQte = CommandeVente::where('num_cmd', $num_cmd)
            ->sum('qte_cmdee');

        // Récupérer la catégorie de la commande
        $categoryCmd = CommandeVente::where('num_cmd', $num_cmd)->value('category_cmd');

        return response()->json(['totalQte' => $totalQte, 'category_cmd' => $categoryCmd]);
    }

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

        // Boucle pour insérer les données dans sortie_ventes
        foreach ($data as $panier) {
            // Insérer dans sortie_ventes
            SortieVente::create([
                'commande_vente_id' => $panier->commande_vente_id,
                'qte_sortie' => $panier->qte_livree,
                'date_sortie' => $panier->date_sortie,
                'etat' => 1,
            ]);

            // Mettre à jour l'état de la commande dans commande_ventes
            CommandeVente::where('id', $panier->commande_vente_id)
                ->update(['etat_cmd' => 0]);
        }

        // Vider la table panier_sortie_fournitures
        PanierSortieFourniture::truncate();

        return redirect()->back()->withInput()->with('success', 'Commande validée avec succès !');

    }


}
