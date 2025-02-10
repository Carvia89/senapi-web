<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Models\BonDepense;
use App\Models\DepenseBon;
use App\Models\EtatBesoin;
use App\Models\ReferenceImputation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;


class DepenseBonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupération des bons de dépense avec filtrage
        $query = DepenseBon::with(['bonDepense', 'utilisateur', 'referImput']);

        // Filtrage par mot clé d'imputation
        if ($request->filled('reference_imputation_id')) {
            $query->where('reference_imputation_id', $request->reference_imputation_id);
        }

        // Filtrage par bon de dépense
        if ($request->filled('bon_depense_id')) {
            $query->where('bon_depense_id', $request->bon_depense_id);
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
        $refImputs = DepenseBon::select('reference_imputation_id')->distinct()->with('referImput')->get();
        $bons = DepenseBon::select('bon_depense_id')->distinct()->with('bonDepense')->get();
        $users = DepenseBon::select('user_id')->distinct()->with('utilisateur')->get();

        return view('daf.bur-comptabilite.depense-avec-bons.index',
            compact(
                'depenses',
                'refImputs',
                'bons',
                'users'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bons = BonDepense::where('etat', 2)->get();
        $referImputs = ReferenceImputation::all();

        return view('daf.bur-comptabilite.depense-avec-bons.form',
            compact(
                'bons',
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
            'bon_depense_id' => 'required|exists:bon_depenses,id',
            'date_depense' => 'required|date'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Enregistrement de la dépense
            $depense = DepenseBon::create([
                'date_depense' => $request->date_depense,
                'reference_imputation_id' => $request->reference_imputation_id,
                'bon_depense_id' => $request->bon_depense_id,
                'user_id' => auth()->id(), // ID de l'utilisateur connecté
            ]);

            // Mise à jour de l'état du bon de dépense
            $bonDepense = BonDepense::findOrFail($request->bon_depense_id);
            $bonDepense->etat = 3; // Mettre à jour l'état à 3
            $bonDepense->save();

            // Mise à jour de l'état de besoin associé, s'il existe
            if ($bonDepense->etat_besoin_id) {
                $etatBesoin = EtatBesoin::find($bonDepense->etat_besoin_id);
                if ($etatBesoin) {
                    $etatBesoin->etat = 4; // Mettre à jour l'état à 4 (Bon payé)
                    $etatBesoin->save();
                }
            }

            // Stocker les informations dans la session pour les réutiliser
            session([
                'date_depense' => $request->date_depense
            ]);

            return redirect()->route('admin.dépenses-avec-bons.index')->with('success', 'Dépense enregistrée avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['date_depense' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()])->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Récupérer la dépense à modifier
        $depense = DepenseBon::findOrFail($id);

        // Récupérer les bons de dépense et les imputations nécessaires
        $bons = BonDepense::whereIn('etat', [2, 3])->get();
        $referImputs = ReferenceImputation::all();

        // Passer les données à la vue
        return view('daf.bur-comptabilite.depense-avec-bons.edit',
            compact(
                'depense',
                'bons',
                'referImputs'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'reference_imputation_id' => 'required|exists:reference_imputations,id',
            'bon_depense_id' => 'required|exists:bon_depenses,id',
            'date_depense' => 'required|date'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Récupérer la dépense à modifier
            $depense = DepenseBon::findOrFail($id);

            // Mise à jour des informations de la dépense
            $depense->update([
                'date_depense' => $request->date_depense,
                'reference_imputation_id' => $request->reference_imputation_id,
                'bon_depense_id' => $request->bon_depense_id,
                'user_id' => auth()->id(), // ID de l'utilisateur connecté
            ]);

            // Mise à jour de l'état du bon de dépense
            $bonDepense = BonDepense::findOrFail($request->bon_depense_id);
            $bonDepense->etat = 3; // Mettre à jour l'état à 3
            $bonDepense->save();

            // Mise à jour de l'état de besoin associé, s'il existe
            if ($bonDepense->etat_besoin_id) {
                $etatBesoin = EtatBesoin::find($bonDepense->etat_besoin_id);
                if ($etatBesoin) {
                    $etatBesoin->etat = 4; // Mettre à jour l'état à 4 (Bon payé)
                    $etatBesoin->save();
                }
            }

            // Stocker les informations dans la session pour les réutiliser
            session([
                'date_depense' => $request->date_depense
            ]);

            return redirect()->route('admin.dépenses-avec-bons.index')->with('success', 'Dépense mise à jour avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['date_depense' => 'Erreur lors de la mise à jour : ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Récupérer la dépense à supprimer
            $depense = DepenseBon::findOrFail($id);

            // Récupérer le bon de dépense associé
            $bonDepense = BonDepense::findOrFail($depense->bon_depense_id);

            // Supprimer la dépense
            $depense->delete();

            // Mise à jour de l'état du bon de dépense
            $bonDepense = BonDepense::findOrFail($depense->bon_depense_id);
            $bonDepense->etat = 2; // Mettre à jour l'état à 2
            $bonDepense->save();

            // Mise à jour de l'état de besoin associé, s'il existe
            if ($bonDepense->etat_besoin_id) {
                $etatBesoin = EtatBesoin::find($bonDepense->etat_besoin_id);
                if ($etatBesoin) {
                    $etatBesoin->etat = 3; // Mettre à jour l'état à 3 (Bon Imputé)
                    $etatBesoin->save();
                }
            }

            return redirect()->route('admin.dépenses-avec-bons.index')
                            ->with('success', 'Dépense supprimée avec succès.');

        } catch (Exception $e) {
            return redirect()->route('admin.dépenses-avec-bons.index')
                        ->withErrors(['depense' => 'Erreur lors de la suppression : ' . $e->getMessage()]);
        }
    }



    public function getBonDepense($id)
    {
        $bon = BonDepense::with('imputCode', 'beneficiaire')
            ->findOrFail($id);

        return response()->json([
            'imputation' => $bon->imputCode->imputation,
            'designation' => $bon->imputCode->designation,
            'motif' => $bon->motif,
            'montant_bon' => $bon->montant_bon,
            'beneficiaire' => $bon->beneficiaire->nom,
            'date_emission' => $bon->date_emission,
        ]);
    }
}
