<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use App\Models\Beneficiaire;
use App\Models\Bureau;
use Illuminate\Http\Request;
use Exception;


class BeneficiaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enregistrements = Beneficiaire::orderBy('created_at', 'desc')->paginate(5);
        return view('daf.bur-engagement.beneficiaires.index', compact('enregistrements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bureaus = Bureau::all();
        return view('daf.bur-engagement.beneficiaires.form', compact('bureaus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:beneficiaires,nom|max:50',
            'bureau_id' => 'nullable|exists:bureaus,id',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            Beneficiaire::create($request->all());
            return redirect()->route('admin.beneficiaire.index')->with('success', 'Bénéficiaire enregistré avec succès.');
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
            $bureaus = Bureau::all();
            $beneficiaire = Beneficiaire::findOrFail($id);
            return view('daf.bur-engagement.beneficiaires.edit', compact('beneficiaire', 'bureaus'));
        } catch (Exception $e) {
            return redirect()->route('admin.beneficiaire.index')
                ->withErrors(['nom' => 'Erreur lors de la récupération du bénéficiaire : ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'bureau_id' => 'nullable|exists:bureaus,id',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            $beneficiaire = Beneficiaire::findOrFail($id);
            $beneficiaire->update($request->all());
            return redirect()->route('admin.beneficiaire.index')->with('success', 'Bénéficiaire mis à jour avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['nom' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $beneficiaire = Beneficiaire::findOrFail($id);
            $beneficiaire->delete();
            return redirect()->route('admin.beneficiaire.index')->with('success', 'Bénéficiaire supprimé avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['nom' => 'Erreur lors de la suppression : ' . $e->getMessage()]);
        }
    }
}
