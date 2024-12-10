<?php

namespace App\Http\Controllers;

use App\Http\Requests\InStockRequest;
use App\Models\Article;
use App\Models\Fournisseur;
use App\Models\InStock;
use App\Models\UnitArticle;
use Illuminate\Http\Request;

class InStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entreestocks = InStock::orderBy('created_at', 'desc')->paginate(4);
        $articles = Article::all();
        $unites = UnitArticle::all();
        $fournisseurs = Fournisseur::all();

        return view('gestions.entrees.index',
            compact(
                'entreestocks',
                'articles',
                'unites',
                'fournisseurs'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::all();
        $unites = UnitArticle::all();
        $fournisseurs = Fournisseur::all();

        return view('gestions.entrees.form',
            compact(
                'articles',
                'unites',
                'fournisseurs'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InStockRequest $request)
    {
        $entreestocks = InStock::create($request->validated());

        // Ordonner les enregistrements par date_entree de la plus ancienne à la plus récente
        $entreestocks->orderBy('date_entree', 'desc')->get();

        return to_route('mouvement.EntreeStock.index')
                ->with('success', 'Article enregistré avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $entreestock = InStock::findOrFail($id);
        $articles = Article::all();
        $unites = UnitArticle::all();
        $fournisseurs = Fournisseur::all();

        return view('gestions.entrees.edit',
            compact(
                'entreestock',
                'articles',
                'unites',
                'fournisseurs'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InStockRequest $request, $id)
    {
        $entreestock = InStock::findOrFail($id);

        $entreestock->update($request->validated());
        return to_route('mouvement.EntreeStock.index')
                ->with('success', 'Article modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InStock $entreestock)
    {
        $entreestock->delete();
        return to_route('mouvement.EntreeStock.index')
                ->with('success', 'L\'Article a été supprimé avec succès !');
    }
}
