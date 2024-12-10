<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\uArtRequest;
use App\Models\UnitArticle;
use Illuminate\Http\Request;

class UArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dappro.admin.unitArticles.index', [
            'uArticles' => UnitArticle::orderBy('created_at', 'desc')->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $uArticle = new UnitArticle();
        return view('dappro.admin.unitArticles.form', [
            'uArticle' => new UnitArticle()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(uArtRequest $request)
    {
        try {
            $uArticle = UnitArticle::create($request->validated());
            return to_route('admin.uniteArticle.index')
                    ->with('success', 'L\'enregistrement est effectué avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['unite' => 'Cette unité existe déjà.']);

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
        $uArticle = UnitArticle::findOrFail($id);

        // Passer l'enregistrement à la vue
        return view('dappro.admin.unitArticles.edit', compact('uArticle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(uArtRequest $request, $id)
    {
        try {
                // Récupérer l'enregistrement à mettre à jour
                $uArticle = UnitArticle::findOrFail($id);

                // Valider les données du formulaire
                $validatedData = $request->validate([
                'unite' => 'required|string|max:25' . $uArticle->id,
                ]);

                // Mettre à jour l'enregistrement dans la base de données
                $uArticle->update($validatedData);

                // Rediriger vers la page de détail ou de liste
                return to_route('admin.uniteArticle.index', $uArticle->id)
                        ->with('success', 'L\'enregistrement a été modifié avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['unite' => 'Cette unité existe déjà.']);

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
        $uArticle = UnitArticle::findOrFail($id);

        // Supprimer l'enregistrement de la base de données
        $uArticle->delete();

        // Rediriger vers la page de liste
        return redirect()->route('admin.uniteArticle.index')
                        ->with('success', 'L\'élément a été supprimé avec succès.');
    }
}
