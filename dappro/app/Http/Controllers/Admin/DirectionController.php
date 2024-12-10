<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DirectionRequest;
use App\Models\Direction;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.directions.index', [
            'directions' => Direction::orderBy('created_at', 'desc')->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $direction = new Direction();
        return view('admin.directions.form', [
            'direction' => new Direction()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DirectionRequest $request)
    {
        try {
            $direction = Direction::create($request->validated());
            return to_route('admin.direction.index')
                ->with('success', 'L\'enregistrement est effectué avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Cet élément existe déjà.']);

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
        $direction = Direction::findOrFail($id);

        // Passer l'enregistrement à la vue
        return view('admin.directions.edit', compact('direction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DirectionRequest $request, $id)
    {
        try {
            // Récupérer l'enregistrement à mettre à jour
            $direction = Direction::findOrFail($id);

            // Valider les données du formulaire
            $validatedData = $request->validate([
                'designation' => 'required|string|max:255|unique:directions,designation,' . $direction->id,
            ]);

            // Mettre à jour l'enregistrement dans la base de données
            $direction->update($validatedData);

            // Rediriger vers la page de détail ou de liste
            return to_route('admin.direction.index', $direction->id)
                ->with('success', 'L\'enregistrement a été modifié avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Cet élément existe déjà.']);
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
        $direction = Direction::findOrFail($id);

        // Supprimer l'enregistrement de la base de données
        $direction->delete();

        // Rediriger vers la page de liste
        return redirect()->route('admin.direction.index')
                        ->with('success', 'L\'élément a été supprimé avec succès.');
    }
}
