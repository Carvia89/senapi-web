<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\FournRequest;
use App\Models\Article;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fournisseurs = Fournisseur::orderBy('created_at', 'desc')->paginate(4);
        return view('admin.fournisseurs.index',
                compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::all();
        return view('admin.fournisseurs.form',
                compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FournRequest $request)
    {
        try {
                //$fournisseur = Fournisseur::create($request->only('nom', 'description'));
                $fournisseur = Fournisseur::create($request->all());
                $fournisseur->articles()->attach($request->input('articles'));

                return to_route('admin.fournisseur.index')
                        ->with('success', 'Fournisseur enregistré avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Cet élément existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fournisseur $fournisseur)
    {
        $articles = Article::all();
        return view('admin.fournisseurs.edit',
                compact('fournisseur', 'articles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FournRequest $request, Fournisseur $fournisseur)
    {
        try {
            $fournisseur->update($request->all());
            $fournisseur->articles()->sync($request->input('articles'));

            return to_route('admin.fournisseur.index');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Cet élément existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return to_route('admin.fournisseur.index');
    }
}
