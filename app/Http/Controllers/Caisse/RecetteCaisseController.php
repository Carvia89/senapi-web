<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\RecetteCaisse;
use App\Models\ReferenceImputation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class RecetteCaisseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupération des bons de dépense avec filtrage
        $query = RecetteCaisse::with(['dossier', 'utilisateur', 'refeImputation']);

        // Filtrage par mot clé d'imputation
        if ($request->filled('reference_imputation_id')) {
            $query->where('reference_imputation_id', $request->reference_imputation_id);
        }

        // Filtrage par dossier_id
        if ($request->filled('dossier_id')) {
            $query->where('dossier_id', $request->dossier_id);
        }

        // Filtrage par date_emission
        if ($request->filled('date_recette')) {
            $query->whereDate('date_recette', 'LIKE', '%' . $request->date_recette . '%');
        }

        // Filtrage par montant_bon
        if ($request->filled('montant_recu')) {
            $query->where('montant_recu', 'LIKE', '%' . $request->montant_recu . '%');
        }

        // Filtrage par libelle (recherche partielle)
        if ($request->filled('libelle')) {
            $query->where('libelle', 'LIKE', '%' . $request->libelle . '%');
        }

        // Filtrage par nom ou prénom de l'utilisateur
        if ($request->filled('user_id')) {
            $query->whereHas('utilisateur', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->user_id . '%')
                  ->orWhere('prenom', 'LIKE', '%' . $request->user_id . '%');
            });
        }

        // Tri des résultats par date d'émission en ordre descendant
        $query->orderBy('date_recette', 'desc');

        // Pagination des résultats
        $recettes = $query->paginate(25);

        // Récupération des directions et dossiers uniques dans bons de dépenses
        $refImputs = RecetteCaisse::select('reference_imputation_id')->distinct()->with('refeImputation')->get();
        $dossiers = RecetteCaisse::select('dossier_id')->distinct()->with('dossier')->get();
        $users = RecetteCaisse::select('user_id')->distinct()->with('utilisateur')->get();

        return view('daf.bur-comptabilite.livret-caisse.recettes.index',
            compact(
                'recettes',
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

        return view('daf.bur-comptabilite.livret-caisse.recettes.form',
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
            'date_recette' => 'required|date',
            'montant_recu' => 'required',
            'libelle' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // enregistrement recette
            $recette = RecetteCaisse::create([
                'date_recette' => $request->date_recette,
                'reference_imputation_id' => $request->reference_imputation_id,
                'montant_recu' => $request->montant_recu,
                'libelle' => $request->libelle,
                'dossier_id' => $request->dossier_id,
                'user_id' => auth()->id(), // ID de l'utilisateur connecté
            ]);

            return redirect()->route('admin.recettes-caisse.index')->with('success', 'Recette enregistrée avec succès.');

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
        $recette = RecetteCaisse::findOrFail($id);

        // Récupération des options pour les sélecteurs
        $dossiers = Dossier::all();
        $referImputs = ReferenceImputation::all();

        return view('daf.bur-comptabilite.livret-caisse.recettes.edit', compact(
            'recette',
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
            'date_recette' => 'required|date',
            'montant_recu' => 'required',
            'libelle' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Recherche de la recette à mettre à jour
            $recette = RecetteCaisse::findOrFail($id);

            // Mise à jour des données
            $recette->update([
                'date_recette' => $request->date_recette,
                'reference_imputation_id' => $request->reference_imputation_id,
                'montant_recu' => $request->montant_recu,
                'libelle' => $request->libelle,
                'dossier_id' => $request->dossier_id,
                'user_id' => auth()->id(), // ID de l'utilisateur connecté (si nécessaire)
            ]);

            return redirect()->route('admin.recettes-caisse.index')->with('success', 'Recette mise à jour avec succès.');

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
            $recette = RecetteCaisse::findOrFail($id);

            // Suppression de l'enregistrement
            $recette->delete();

            return redirect()->route('admin.recettes-caisse.index')->with('success', 'Recette supprimée avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['libelle' => 'Erreur lors de la suppression : ' . $e->getMessage()])->withInput();
        }
    }
}
