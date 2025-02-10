<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Models\DepenseSansBon;
use App\Models\Dossier;
use App\Models\ReferenceImputation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;



class DepenseSansBonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupération des bons de dépense avec filtrage
        $query = DepenseSansBon::with(['dossier', 'utilisateur', 'referImput']);

        // Filtrage par mot clé d'imputation
        if ($request->filled('reference_imputation_id')) {
            $query->where('reference_imputation_id', $request->reference_imputation_id);
        }

        // Filtrage par bon de dépense
        if ($request->filled('dossier_id')) {
            $query->where('dossier_id', $request->dossier_id);
        }

        // Filtrage par date_emission
        if ($request->filled('date_depense')) {
            $query->whereDate('date_depense', $request->date_depense);
        }

        // Filtrage par montant_bon
        if ($request->filled('montant_depense')) {
            $query->where('montant_depense', $request->montant_depense);
        }

        // Filtrage par motif
        if ($request->filled('libelle')) {
            $query->where('libelle', $request->libelle);
        }

        // Filtrage par nom ou prénom de l'utilisateur
        if ($request->filled('user_id')) {
            $query->whereHas('utilisateur', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->user_id . '%')
                  ->orWhere('prenom', 'LIKE', '%' . $request->user_id . '%');
            });
        }

        // Tri des résultats par date d'émission en ordre descendant
        $query->orderBy('date_depense', 'desc');

        // Pagination des résultats
        $depenses = $query->paginate(10);

        // Récupération des directions et dossiers uniques dans bons de dépenses
        $refImputs = DepenseSansBon::select('reference_imputation_id')->distinct()->with('referImput')->get();
        $dossiers = DepenseSansBon::select('dossier_id')->distinct()->with('dossier')->get();
        $users = DepenseSansBon::select('user_id')->distinct()->with('utilisateur')->get();

        return view('daf.bur-comptabilite.livret-caisse.depense-sans-bons.index',
            compact(
                'depenses',
                'refImputs',
                'dossiers',
                'users'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dossiers = Dossier::all();
        $referImputs = ReferenceImputation::all();

        return view('daf.bur-comptabilite.livret-caisse.depense-sans-bons.form',
            compact(
                'dossiers',
                'referImputs'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'reference_imputation_id' => 'required|exists:reference_imputations,id',
            'dossier_id' => 'nullable|exists:dossiers,id',
            'date_depense' => 'required|date',
            'montant_depense' => 'required',
            'libelle' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // enregistrement depense
            $depense = DepenseSansBon::create([
                'date_depense' => $request->date_depense,
                'reference_imputation_id' => $request->reference_imputation_id,
                'montant_depense' => $request->montant_depense,
                'libelle' => $request->libelle,
                'dossier_id' => $request->dossier_id,
                'user_id' => auth()->id(), // ID de l'utilisateur connecté
            ]);

            return redirect()->route('admin.dépenses-sans-bons.index')->with('success', 'Dépense enregistrée avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['libelle' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()])->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Récupération du bon de dépense par son ID
        $depense = DepenseSansBon::findOrFail($id);

        // Récupération des options pour les sélecteurs
        $dossiers = Dossier::all();
        $referImputs = ReferenceImputation::all();

        return view('daf.bur-comptabilite.livret-caisse.depense-sans-bons.edit', compact(
            'depense',
            'dossiers',
            'referImputs'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'reference_imputation_id' => 'required|exists:reference_imputations,id',
            'dossier_id' => 'nullable|exists:dossiers,id',
            'date_depense' => 'required|date',
            'montant_depense' => 'required',
            'libelle' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Recherche de la depense à mettre à jour
            $depense = DepenseSansBon::findOrFail($id);

            // Mise à jour des données
            $depense->update([
                'date_depense' => $request->date_depense,
                'reference_imputation_id' => $request->reference_imputation_id,
                'montant_depense' => $request->montant_depense,
                'libelle' => $request->libelle,
                'dossier_id' => $request->dossier_id,
                'user_id' => auth()->id(), // ID de l'utilisateur connecté (si nécessaire)
            ]);

            return redirect()->route('admin.dépenses-sans-bons.index')->with('success', 'Dépense mise à jour avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['libelle' => 'Erreur lors de la mise à jour : ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Recherche de la recette à supprimer
            $depense = DepenseSansBon::findOrFail($id);

            // Suppression de l'enregistrement
            $depense->delete();

            return redirect()->route('admin.dépenses-sans-bons.index')->with('success', 'Dépense supprimée avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['libelle' => 'Erreur lors de la suppression : ' . $e->getMessage()])->withInput();
        }
    }
}
