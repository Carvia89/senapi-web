<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Models\Imputation;
use App\Models\ReferenceImputation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;


class MotCleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupération des états de besoins avec filtrage
        $query = ReferenceImputation::with('imputation')->orderBy('created_at', 'desc');

        // Filtrage par bureau_id
        if ($request->filled('imputation_id')) {
            $query->where('imputation_id', $request->imputation_id);
        }

        // Pagination des résultats
        $references = $query->paginate(25);

        // Récupération des imputations
        $imputations = ReferenceImputation::select('imputation_id')->distinct()->with('imputation')->get();

        return view('daf.bur-comptabilite.reference-imputations.index',
            compact(
                'imputations',
                'references'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $imputations = Imputation::all();

        return view('daf.bur-comptabilite.reference-imputations.form',
            compact(
                'imputations'
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
            'imputation_id' => 'required|exists:imputations,id',
            'designation' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {

            // Création du mot
            ReferenceImputation::create([
                'imputation_id' => $request->imputation_id,
                'designation' => $request->designation
            ]);

            return redirect()->route('admin.mot-cle-imputation.index')->with('success', 'Mot de référence ajouté avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['designation' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()])->withInput();
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
        $reference = ReferenceImputation::findOrFail($id);
        $imputations = Imputation::all();

        return view('daf.bur-comptabilite.reference-imputations.edit',
            compact(
                'reference',
                'imputations'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'imputation_id' => 'required|exists:imputations,id',
            'designation' => 'required|string|max:255'
        ]);

        try {
            $reference = ReferenceImputation::findOrFail($id);
            $reference->update($request->all());
            return redirect()->route('admin.mot-cle-imputation.index')->with('success', 'Mot de référence mis à jour avec succès.');
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
            $reference = ReferenceImputation::findOrFail($id);
            $reference->delete();
            return redirect()->route('admin.mot-cle-imputation.index')->with('success', 'Mot supprimé avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['designation' => 'Erreur lors de la suppression : ' . $e->getMessage()]);
        }
    }
}
