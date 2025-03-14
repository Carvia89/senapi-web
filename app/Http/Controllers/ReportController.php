<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bureau;
use App\Models\FicheStock;
use App\Models\GestionArticle;
use App\Models\Inventaire;
use App\Models\UnitArticle;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $inventaires = Inventaire::with(['article', 'unity'])
            ->join('articles', 'inventaires.article_id', '=', 'articles.id') // Joindre la table des articles
            ->orderBy('articles.designation') // Trier par le champ "designation" de la table des articles
            ->select('inventaires.*') // Sélectionner uniquement les colonnes des inventaires
            ->get();

        return view('dappro.gestions.reporting.index', compact('inventaires'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::all()->sortBy('designation');
        $unites = UnitArticle::all();
        return view('dappro.gestions.reporting.form', compact('articles', 'unites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les champs du formulaire
        $validatedData = $request->validate([
            'article_id' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        // Récupérer les données de l'article sélectionné
        $article = Article::findOrFail($request->input('article_id'));

        // Récupérer les enregistrements d'entrée et de sortie de stock pendant la période
        $stockEntrees = $article->getStockEntreDuringPeriod(
            $request->input('date_debut'),
            $request->input('date_fin')
        );
        $stockSorties = $article->getStockSortieDuringPeriod(
            $request->input('date_debut'),
            $request->input('date_fin')
        );

        // Calculer le stock initial
        $stockInitial = $article->stock_initial;

        // Supprimer les lignes existantes pour l'article sélectionné
        FicheStock::where('article_id', $request->input('article_id'))->delete();

        // Enregistrer les nouvelles lignes d'entrée de stock
        foreach ($stockEntrees as $entree) {
            FicheStock::create([
                'article_id' => $request->input('article_id'),
                'date_entree' => $entree->date_entree,
                'stock_initial' => $stockInitial,
                'stock_entree' => $entree->stock_entree,
                'stock_total' => $stockInitial + $entree->stock_entree,
                'date_sortie' => null,
                'stock_sortie' => 0,
                'stock_actuel' => $stockInitial + $entree->stock_entree,
                'fournisseur_id' => $article->fournisseur_id,
                'bureau_id' => $article->bureau_id,
            ]);

            // Mettre à jour le stock initial pour la prochaine ligne
            $stockInitial += $entree->stock_entree;
        }

        // Enregistrer les nouvelles lignes de sortie de stock
        foreach ($stockSorties as $sortie) {
            FicheStock::create([
                'article_id' => $request->input('article_id'),
                'date_entree' => null,
                'stock_initial' => $stockInitial,
                'stock_entree' => 0,
                'stock_total' => $stockInitial,
                'date_sortie' => $sortie->date_sortie,
                'stock_sortie' => $sortie->stock_sortie,
                'stock_actuel' => $stockInitial - $sortie->stock_sortie,
                'fournisseur_id' => $article->fournisseur_id,
                'bureau_id' => $article->bureau_id,
            ]);

            // Mettre à jour le stock initial pour la prochaine ligne
            $stockInitial -= $sortie->stock_sortie;
        }

        // Rediriger ou retourner une réponse appropriée

        $ficheStoks = FicheStock::with(['article', 'bureau', 'fournisseur'])->get();
        return view('dappro.gestions.reporting.fichestock.index', compact('ficheStoks'));
        //return redirect()->route('gest')->with('success', 'Enregistrements de stock créés avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $ficheStoks = FicheStock::with(['article', 'bureau', 'fournisseur'])->get();
        return view('dappro.gestions.reporting.fichestock.index', compact('ficheStoks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function fiche()
    {
        $ficheStoks = FicheStock::with(['article', 'bureau', 'fournisseur'])->get();
        return view('dappro.gestions.reporting.fichestock.index', compact('ficheStoks'));
    }

    protected function getStockInitial($articleId)
    {
        return GestionArticle::where('designation_id', $articleId)->sum('stock_initial');
    }
}
