<?php

namespace App\Http\Controllers;

use App\Http\Requests\gArtRequest;
use App\Models\Article;
use App\Models\CatgArticle;
use App\Models\GestionArticle;
use App\Models\UnitArticle;
use Illuminate\Http\Request;

class gestionArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gestions = GestionArticle::orderBy('created_at', 'desc')->paginate(25);
        $articles = Article::all();
        $unites = UnitArticle::all();
        $categories = CatgArticle::all();

        return view('dappro.gestions.index',
            compact(
                'gestions',
                'articles',
                'unites',
                'categories'
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
        $categories = CatgArticle::all();
        return view('dappro.gestions.form',
            compact(
                'articles',
                'unites',
                'categories'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(gArtRequest $request)
    {
        try {
            $gestions = GestionArticle::create($request->validated());
            return to_route('mouvement.gestion.index')
                ->with('success', 'Article enregistré avec succès !');

            } catch (\Illuminate\Database\QueryException $e) {
                // Vérifier si l'erreur est liée à une contrainte d'intégrité
                if ($e->getCode() == '23000') {
                    // Rediriger avec un message d'erreur
                    return back()->withInput()->withErrors(['designation_id' => 'Cet article existe déjà.']);

                } else {
                    // Traiter d'autres types d'exceptions
                    throw $e;
                }
            }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GestionArticle $gestion)
    {
        $gestions = GestionArticle::all();
        $articles = Article::all();
        $unites = UnitArticle::all();
        //$categories = CatgArticle::all();
        return view('dappro.gestions.edit',
            compact(
                'gestion',
                'articles',
                'unites',
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(gArtRequest $request, GestionArticle $gestion)
    {
        try {
                $gestion->update($request->validated());

                return to_route('mouvement.gestion.index')
                        ->with('success', 'Article modifié avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation_id' => 'Cet article existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GestionArticle $gestion)
    {
        $gestion->delete();
        return to_route('mouvement.gestion.index')
                ->with('success', 'L\'Article a été supprimé avec succès !');
    }
}
