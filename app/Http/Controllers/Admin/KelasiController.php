<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KelasiRequest;
use App\Models\Kelasi;
use Illuminate\Http\Request;

class KelasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelasis = Kelasi::orderBy('created_at', 'desc')->paginate(5);
        return view('dappro.admin.kelasis.index', compact('kelasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dappro.admin.kelasis.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KelasiRequest $request)
    {
        try {
            $kelasis = Kelasi::create($request->validated());
            return to_route('admin.Kelasi.index')
                ->with('success', 'Classe enregistrée avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Cette Classe existe déjà.']);

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
        $kelasi = Kelasi::findOrFail($id);
        return view('dappro.admin.kelasis.edit', compact('kelasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KelasiRequest $request, $id)
    {
        try {
            $kelasi = Kelasi::findOrFail($id);

            $kelasi->update($request->validated());
            return to_route('admin.Kelasi.index')
                    ->with('success', 'Classe modifiée avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Cette classe existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelasi $kelasi)
    {
        $kelasi->delete();
        return to_route('admin.Kelasi.index')
                ->with('success', 'La Classe a été supprimée avec succès !');
    }

    public function showKelasi()
    {
        $kelasis = Kelasi::orderBy('created_at', 'desc')->paginate(5);
        return view('dappro.bur-fournitures.kelasis.index', compact('kelasis'));
    }
}
