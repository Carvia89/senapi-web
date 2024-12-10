<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DivisionRequest;
use App\Models\Direction;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::orderBy('created_at', 'desc')->paginate(4);
        $directions = Direction::all();

        return view('dappro.admin.divisions.index', compact('divisions', 'directions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $directions = Direction::all();
        return view('dappro.admin.divisions.form', compact('directions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DivisionRequest $request)
    {
        try {
            $divisions = Division::create($request->validated());
            return to_route('admin.division.index')
                ->with('success', 'Division enregistrée avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Cette disivion existe déjà.']);

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
        $division = Division::findOrFail($id);
        $directions = Direction::all();
        return view('dappro.admin.divisions.edit', compact('division', 'directions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DivisionRequest $request, $id)
    {
        try {
            $division = Division::findOrFail($id);

            $division->update($request->validated());
            return to_route('admin.division.index')
                    ->with('success', 'Division modifiée avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Cette division existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $division->delete();
        return to_route('admin.division.index')
                ->with('success', 'La Division a été supprimée avec succès !');
    }
}
