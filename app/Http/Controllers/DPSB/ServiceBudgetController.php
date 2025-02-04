<?php

namespace App\Http\Controllers\DPSB;

use App\Http\Controllers\Controller;
use App\Models\BonDepense;
use App\Models\EtatBesoin;
use App\Models\Imputation;
use App\Models\PaiementAcompte;
use App\Models\ServiceBudgetVisa;
use Illuminate\Http\Request;
use Exception;


class ServiceBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupération des bons de dépense avec filtrage pour l'état
        $query = BonDepense::with(['direction', 'dossier', 'utilisateur'])
                           ->where('etat', 1);

        // Tri des résultats par date d'émission en ordre descendant
        $query->orderBy('created_at', 'desc');

        // Pagination des résultats
        $bonDepenses = $query->paginate(10);

        // Récupération des directions et dossiers uniques dans bons de dépenses
        $directions = BonDepense::select('direction_id')->distinct()->with('direction')->get();
        $dossiers = BonDepense::select('dossier_id')->distinct()->with('dossier')->get();
        $users = BonDepense::select('user_id')->distinct()->with('utilisateur')->get();

        return view('daf.dpsb.imputation-bons.index',
            compact(
                'bonDepenses',
                'directions',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        // Récupération du bon de dépense par son ID
        $bon = BonDepense::findOrFail($id);

        // Récupération des options pour les sélecteurs
        $imputations = Imputation::all();

        return view('daf.dpsb.imputation-bons.edit', compact(
            'bon',
            'imputations'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données du formulaire
        $request->validate([
            'imputation_id' => 'required|exists:imputations,id',
        ]);

        try {
            // Récupération du bon de dépense à mettre à jour
            $bonDepense = BonDepense::findOrFail($id);

            // Mise à jour du champ 'etat' à 2
            $bonDepense->etat = 2;

            // Sauvegarde de l'ID de l'imputation à partir du formulaire
            $bonDepense->imputation_id = $request->imputation_id;

            // Sauvegarde des modifications du bon de dépense
            $bonDepense->save();

            // Vérification de l'état de besoin est associé
            if ($bonDepense->etat_besoin_id !== null) {
                $etatBesoin = EtatBesoin::find($bonDepense->etat_besoin_id);
                if ($etatBesoin) {
                    $etatBesoin->etat = 3; // Mise à jour de l'état à 3
                    $etatBesoin->save();
                }
            }

            // Création ou mise à jour de l'enregistrement dans la table service_budget_visas
            $serviceBudgetVisa = new ServiceBudgetVisa();
            $serviceBudgetVisa->bon_depense_id = $bonDepense->id; // ID du bon de dépense
            //$serviceBudgetVisa->imputation_id = $request->imputation_id; // ID de l'imputation
            $serviceBudgetVisa->user_id = auth()->id(); // ID de l'utilisateur connecté
            $serviceBudgetVisa->save();

            return redirect()->route('admin.imputation-bon-depense.index')->with('success', 'Bon de Dépense imputé avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['motif' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
