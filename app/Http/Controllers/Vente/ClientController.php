<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vente\ClientRequest;
use App\Models\ClientVente;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = ClientVente::orderBy('created_at', 'desc')->paginate(5);
        return view('dappro.bur-ventes.clients.index',
            compact(
                'clients'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dappro.bur-ventes.clients.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        try {
            $client = ClientVente::create($request->validated());
            return to_route('admin.client-Vente.index')
                ->with('success', 'L\'enregistrement est effectué avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Ce Client existe déjà.']);

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
        $client = ClientVente::findOrFail($id);
        return view('dappro.bur-ventes.clients.edit',
            compact(
                'client'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, $id)
    {
        try {
            // Trouver l'enregistrement à mettre à jour
            $client = ClientVente::findOrFail($id);

            // Mettre à jour l'enregistrement
            $client->update($request->validated());

            return to_route('admin.client-Vente.index')
                ->with('success', 'Enregistrement mis à jour avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Ce client existe déjà.']);
            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientVente $client)
    {
        try {
            // Supprimer l'enregistrement
            $client->delete();

            return to_route('admin.client-Vente.index')
                ->with('success', 'Le Client a été supprimé avec succès !');
        } catch (\Illuminate\Database\QueryException $e) {
            // Gérer les erreurs liées à la base de données
            return back()->withErrors(['message' => 'Erreur lors de la suppression de l\'article.']);
        }
    }
}
