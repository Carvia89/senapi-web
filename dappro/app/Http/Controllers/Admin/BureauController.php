<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BureauRequest;
use App\Models\Bureau;
use App\Models\Direction;
use App\Models\Division;
use Illuminate\Http\Request;

class BureauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bureaus = Bureau::orderBy('created_at', 'desc')->paginate(4);
        $divisions = Division::all();

        return view('admin.bureaux.index', compact('bureaus', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::all();
        return view('admin.bureaux.form', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BureauRequest $request)
    {
        try {
            $bureaus = Bureau::create($request->validated());
            return to_route('admin.bureau.index')
                ->with('success', 'Bureau enregistré avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Ce bureau existe déjà.']);

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
        $bureau = Bureau::findOrFail($id);
        $divisions = Division::all();
        return view('admin.bureaux.edit', compact('bureau', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BureauRequest $request, $id)
    {
        try {
            $bureau = Bureau::findOrFail($id);

            $bureau->update($request->validated());
            return to_route('admin.bureau.index')
                    ->with('success', 'Bureau modifié avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Ce nom de bureau existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bureau $bureau)
    {
        $bureau->delete();
        return to_route('admin.bureau.index')
                ->with('success', 'Le Bureau a été supprimé avec succès !');
    }
}
