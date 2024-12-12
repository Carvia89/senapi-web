<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CycleRequest;
use App\Models\Cycle;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cycles = Cycle::orderBy('created_at', 'desc')->paginate(4);
        return view('dappro.admin.cycles.index', compact('cycles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dappro.admin.cycles.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CycleRequest $request)
    {
        try {
            $bureaus = Cycle::create($request->validated());
            return to_route('admin.Cycle.index')
                ->with('success', 'Cycle enregistré avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Ce Cycle existe déjà.']);

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
        $cycle = Cycle::findOrFail($id);
        return view('dappro.admin.cycles.edit', compact('cycle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CycleRequest $request, $id)
    {
        try {
            $bureau = Cycle::findOrFail($id);

            $bureau->update($request->validated());
            return to_route('admin.Cycle.index')
                    ->with('success', 'Cycle modifié avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Ce cycle existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cycle $cycle)
    {
        $cycle->delete();
        return to_route('admin.Cycle.index')
                ->with('success', 'Le Cycle a été supprimé avec succès !');
    }

    public function showCycle()
    {
        $cycles = Cycle::orderBy('created_at', 'desc')->paginate(5);
        return view('dappro.bur-fournitures.cycles.index', compact('cycles'));
    }
}
