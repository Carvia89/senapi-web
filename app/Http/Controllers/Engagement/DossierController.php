<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Exception;


class DossierController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dossiers = Dossier::orderBy('created_at', 'desc')->paginate(5);
        return view('daf.bur-engagement.dossiers.form', compact('dossiers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|string|unique:dossiers,designation|max:100',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            Dossier::create($request->all());
            return redirect()->route('admin.dossier.create')->with('success', 'Dossier enregistré avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['nom' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $dossiers = Dossier::orderBy('created_at', 'desc')->paginate(5);
            $dossier = Dossier::findOrFail($id);
            return view('daf.bur-engagement.dossiers.edit', compact('dossiers', 'dossier'));
        } catch (Exception $e) {
            return redirect()->route('admin.dossier.create')
                ->withErrors(['designation' => 'Erreur lors de la récupération du dossier : ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required|string|unique:dossiers,designation|max:100',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            $dossier = Dossier::findOrFail($id);
            $dossier->update($request->all());
            return redirect()->route('admin.dossier.create')->with('success', 'Dossier modifié avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['designation' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $dossier = Dossier::findOrFail($id);
            $dossier->delete();
            return redirect()->route('admin.dossier.create')->with('success', 'Dossier supprimé avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['designation' => 'Erreur lors de la suppression : ' . $e->getMessage()]);
        }
    }
}
