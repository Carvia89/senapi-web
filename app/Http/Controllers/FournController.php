<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\FournRequest;
use App\Models\Article;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fournisseurs = Fournisseur::orderBy('created_at', 'desc')->paginate(4);
        return view('dappro.admin.fournisseurs.index',
                compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::all();
        return view('dappro.admin.fournisseurs.form',
                compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FournRequest $request)
    {
        //$fournisseur = Fournisseur::create($request->only('nom', 'description'));
        $fournisseur = Fournisseur::create($request->all());
        $fournisseur->articles()->attach($request->input('articles'));

        return to_route('admin.fournisseur.index')
                ->with('success', 'Fournisseur enregistré avec succès !');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fournisseur $fournisseur)
    {
        $articles = Article::all();
        return view('dappro.admin.fournisseurs.edit',
                compact('fournisseur', 'articles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FournRequest $request, Fournisseur $fournisseur)
    {
        $fournisseur->update($request->all());
        $fournisseur->articles()->sync($request->input('articles'));

        return to_route('admin.fournisseur.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return to_route('admin.fournisseur.index');
    }

    public function showFournisseur()
    {
        $fournisseurs = Fournisseur::orderBy('created_at', 'desc')->paginate(5);
        return view('dappro.bur-fournitures.fournisseurs.index',
            compact(
                'fournisseurs'
            )
        );
    }
}
