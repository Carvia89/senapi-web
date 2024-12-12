<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OptionRequest;
use App\Models\Cycle;
use App\Models\Niveau;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = Option::orderBy('created_at', 'desc')->paginate(5);
        $niveaux = Niveau::all();
        $cycles = Cycle::all();
        return view('dappro.admin.options.index',
            compact(
                'options',
                'niveaux',
                'cycles'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $niveaux = Niveau::all();
        $cycles = Cycle::all();
        return view('dappro.admin.options.form',
            compact(
                'niveaux',
                'cycles'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OptionRequest $request)
    {
        try {
            $options = Option::create($request->validated());
            return to_route('admin.Option.index')
                ->with('success', 'Option enregistrée avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['designation' => 'Cette Option existe déjà.']);

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
        $option = Option::findOrFail($id);
        $niveaux = Niveau::all();
        $cycles = Cycle::all();
        return view('dappro.admin.options.edit',
            compact(
                'option',
                'niveaux',
                'cycles'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OptionRequest $request, $id)
    {
        try {
            $option = Option::findOrFail($id);

            $option->update($request->validated());
            return to_route('admin.Option.index')
                    ->with('success', 'Option modifiée avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['designation' => 'Cette Option existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option)
    {
        $option->delete();
        return to_route('admin.Option.index')
                ->with('success', 'Cette Option a été supprimé avec succès !');
    }

    public function showOption()
    {
        $options = Option::orderBy('created_at', 'desc')->paginate(5);
        $niveaux = Niveau::all();
        $cycles = Cycle::all();
        return view('dappro.bur-fournitures.options.index',
            compact(
                'options',
                'niveaux',
                'cycles'
            )
        );
    }
}
