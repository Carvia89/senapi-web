<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NiveauRequest;
use App\Models\Niveau;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niveaux = Niveau::orderBy('created_at', 'desc')->paginate(5);
        return view('dappro.admin.niveaux.index', compact('niveaux'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dappro.admin.niveaux.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NiveauRequest $request)
    {
        try {
            $bureaus = Niveau::create($request->validated());
            return to_route('admin.Niveau.index')
                ->with('success', 'Niveau enregistré avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Ce Niveau existe déjà.']);

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
        $niveau = Niveau::findOrFail($id);
        return view('dappro.admin.niveaux.edit', compact('niveau'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NiveauRequest $request, $id)
    {
        try {
            $bureau = Niveau::findOrFail($id);

            $bureau->update($request->validated());
            return to_route('admin.Niveau.index')
                    ->with('success', 'Niveau modifié avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Ce niveau existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Niveau $niveau)
    {
        $niveau->delete();
        return to_route('admin.Niveau.index')
                ->with('success', 'Le Niveau a été supprimé avec succès !');
    }

    public function showNiveau()
    {
        $niveaux = Niveau::orderBy('created_at', 'desc')->paginate(5);
        return view('dappro.bur-fournitures.niveaux.index', compact('niveaux'));
    }
}
