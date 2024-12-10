<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use App\Models\CatgArticle;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(25);
        $categories = CatgArticle::all();

        return view('dappro.admin.articles.index', compact('articles', 'categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CatgArticle::all();
        return view('dappro.admin.articles.form', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        try {
                $articles = Article::create($request->validated());
                return to_route('admin.Article.index')
                        ->with('success', 'Article enregistré avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Cet article existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = CatgArticle::all();
        return view('dappro.admin.articles.edit', compact('article', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, $id)
    {
        try {
                $article = Article::findOrFail($id);


                $article->update($request->validated());
                return to_route('admin.Article.index')
                        ->with('success', 'Article modifié avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Cet article existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return to_route('admin.Article.index')
                ->with('success', 'L\'Article a été supprimé avec succès !');

    }
}
