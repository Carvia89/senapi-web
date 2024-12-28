<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fourniture\StockDebutRequest;
use App\Http\Requests\Vente\StkDebutRequest;
use App\Models\Kelasi;
use App\Models\Option;
use App\Models\StockDebutVente;
use Illuminate\Http\Request;

class StkDebutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = Option::all();
        $classes = Kelasi::all();

        $stockDebuts = StockDebutVente::orderBy('created_at', 'desc')->paginate(4);
        return view('dappro.bur-ventes.stockDebut.index',
            compact(
                'options',
                'classes',
                'stockDebuts'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = Option::all();
        $classes = Kelasi::all();

        return view('dappro.bur-ventes.stockDebut.form',
            compact(
                'options',
                'classes'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockDebutRequest $request)
    {
        try {
            // Vérifier si l'article existe déjà
            $exists = StockDebutVente::where('option_id', $request->option_id)
                                 ->where('classe_id', $request->classe_id)
                                 ->exists();

            if ($exists) {
                return back()->withInput()->withErrors(['option_id' => 'Cet article existe déjà.']);
            }

            // Créer l'enregistrement
            $stockDebut = StockDebutVente::create($request->validated());

            return to_route('admin.stockDebut-Vente.index')
                ->with('success', 'Article enregistré avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['option_id' => 'Cet article existe déjà.']);
            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
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
        $stockDebut = StockDebutVente::findOrFail($id);
        $options = Option::all();
        $classes = Kelasi::all();
        return view('dappro.bur-ventes.stockDebut.edit',
            compact(
                'options',
                'classes',
                'stockDebut'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StkDebutRequest $request, $id)
    {
        try {
            // Trouver l'enregistrement à mettre à jour
            $stockDebut = StockDebutVente::findOrFail($id);

            // Vérifier si un autre article avec les mêmes option_id et classe_id existe
            $exists = StockDebutVente::where('option_id', $request->option_id)
                                 ->where('classe_id', $request->classe_id)
                                 ->where('id', '!=', $stockDebut->id) // Exclure l'enregistrement actuel
                                 ->exists();

            if ($exists) {
                return back()->withInput()->withErrors(['option_id' => 'Cet article existe déjà.']);
            }

            // Mettre à jour l'enregistrement
            $stockDebut->update($request->validated());

            return to_route('admin.stockDebut-Vente.index')
                ->with('success', 'Article mis à jour avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['option_id' => 'Cet article existe déjà.']);
            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockDebutVente $stockDebut)
    {
        try {
            // Supprimer l'enregistrement
            $stockDebut->delete();

            return to_route('admin.stockDebut-Vente.index')
                ->with('success', 'L\'article a été supprimé avec succès !');
        } catch (\Illuminate\Database\QueryException $e) {
            // Gérer les erreurs liées à la base de données
            return back()->withErrors(['message' => 'Erreur lors de la suppression de l\'article.']);
        }
    }
}
