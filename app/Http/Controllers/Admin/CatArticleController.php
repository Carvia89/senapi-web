<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\catArtRequest;
use App\Models\CatgArticle;
use Illuminate\Http\Request;

class CatArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dappro.admin.catgArticles.index', [
            'catArticles' => CatgArticle::orderBy('created_at', 'desc')->paginate(4)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catArticle = new CatgArticle();
        return view('dappro.admin.catgArticles.form', [
            'catArticle' => new CatgArticle()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(catArtRequest $request)
    {
        try {
            $catArticle = CatgArticle::create($request->validated());
            return to_route('admin.categorieArticle.index')
                    ->with('success', 'L\'enregistrement est effectué avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Cette catégorie existe déjà.']);

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
        // Récupérer l'enregistrement à éditer
        $catArticle = CatgArticle::findOrFail($id);

        // Passer l'enregistrement à la vue
        return view('dappro.admin.catgArticles.edit', compact('catArticle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(catArtRequest $request, $id)
    {
        try {
            // Récupérer l'enregistrement à mettre à jour
            $catArticle = CatgArticle::findOrFail($id);

            // Valider les données du formulaire
            $validatedData = $request->validate([
            'designation' => 'required|string|max:25' . $catArticle->id,
            ]);

            // Mettre à jour l'enregistrement dans la base de données
            $catArticle->update($validatedData);

            // Rediriger vers la page de détail ou de liste
            return to_route('admin.categorieArticle.index', $catArticle->id)
                    ->with('success', 'L\'enregistrement a été modifié avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Cette catégorie existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Récupérer l'enregistrement à supprimer
        $catArticle = CatgArticle::findOrFail($id);

        // Supprimer l'enregistrement de la base de données
        $catArticle->delete();

        // Rediriger vers la page de liste
        return redirect()->route('admin.categorieArticle.index')
                        ->with('success', 'L\'élément a été supprimé avec succès.');
    }
}
