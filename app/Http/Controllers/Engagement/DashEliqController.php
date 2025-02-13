<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use App\Models\BonDepense;
use App\Models\DepenseBon;
use App\Models\DepenseSansBon;
use App\Models\EtatBesoin;
use App\Models\PaiementAcompte;
use App\Models\RecetteCaisse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashEliqController extends Controller
{
    public function indexEliq()
    {
        return view('daf.layouts.dashboard');
    }

    public function indexCaisse()
    {
        // Récupérer le nombre d'utilisateurs dans la direction avec id = 5 DAF
        $nombreUtilisateurs = User::whereHas('bureau.division.direction', function ($query) {
            $query->where('id', 5);
        })->count();

        //Récupérer le nbre de bons élaborés
        $bonDepense = BonDepense::count();

        //Récupérer le nbre de bons payés
        $bonDepensePaye = BonDepense::where('etat', 3)->count();

        //Récupérer le nbre d'état de besoins
        $etatBesoin = EtatBesoin::count();

        //Récupérer le nbre d'état de besoins
        $bonPartiel = PaiementAcompte::count();

        //Calcul des Report, Recettes et Dépenses
        $montantReport = DB::table('report_annuels')->sum('montant_report');
        $recettesAnnuelle = RecetteCaisse::sum('montant_recu');
        $depensesSansBons = DepenseSansBon::sum('montant_depense');
        $depensesBonsTotal = DepenseBon::with('bonDepense')
                        ->join('bon_depenses', 'depense_bons.bon_depense_id', '=', 'bon_depenses.id')
                        ->sum('bon_depenses.montant_bon');
        $solde = $montantReport + $recettesAnnuelle - ($depensesSansBons + $depensesBonsTotal);
        $depenseAnnuelle = $depensesSansBons + $depensesBonsTotal;

        //calcul du report journalier
        $recettesToday = RecetteCaisse::whereDate('date_recette', today())->sum('montant_recu');
        $depensesSansBonsToday = DepenseSansBon::whereDate('date_depense', today())->sum('montant_depense');
        $depensesBonsTotalToday = DepenseBon::with('bonDepense')
                                ->join('bon_depenses', 'depense_bons.bon_depense_id', '=', 'bon_depenses.id')
                                ->whereDate('depense_bons.date_depense', today())
                                ->sum('bon_depenses.montant_bon');
        $reportJournalier = $solde - ($recettesToday + $depensesSansBonsToday + $depensesBonsTotalToday);
        $depenseJournaliere = $depensesSansBonsToday + $depensesBonsTotalToday;

        return view('daf.layouts.dashboardCaisse',
            compact(
                'nombreUtilisateurs',
                'bonDepense',
                'bonDepensePaye',
                'etatBesoin',
                'bonPartiel',
                'recettesAnnuelle',
                'solde',
                'depenseAnnuelle',
                'montantReport',
                'reportJournalier',
                'recettesToday',
                'depenseJournaliere'
            )
        );
    }
}
