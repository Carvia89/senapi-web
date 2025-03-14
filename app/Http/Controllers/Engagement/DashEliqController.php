<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use App\Models\Banque;
use App\Models\Beneficiaire;
use App\Models\BonDepense;
use App\Models\DepenseBon;
use App\Models\DepenseSansBon;
use App\Models\Dossier;
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
        $nbreBanques = Banque::count();
        // Récupérer le nombre d'utilisateurs du bureau
        $nombreUtilisateurs = User::whereHas('bureau', function ($query) {
            $query->where('id', 2);
        })->count();

        $nbreBenef = Beneficiaire::count();         //Récupérer le nombre de bénéficiaires
        $nbreDoss = Dossier::count();               //Récupérer le nombre de dossiers
        $nbreEBdownload = EtatBesoin::count();      //Récupérer le nombre total des état de besoin numérisés
        $EBtraités = EtatBesoin::where('etat', 4)->count();                         //Récupérer les états de besoin liquidés
        $nbreBonDepenses = BonDepense::count();                                     //Récupérer le nbre de bon de dépenses
        $nbreBonPayés = BonDepense::where('etat', 3)->count();                      //Récupérer les bons payés
        $sommeBonPayés = BonDepense::where('etat', 3)->sum('montant_bon');          //Somme de bons payés
        $sommeBonàPayer = BonDepense::where('etat', "<", '3')->sum('montant_bon');  //Somme de bons en attente de paiement

        // Récupérer les 4 derniers bons de dépenses
        $bonsDepenses = BonDepense::orderBy('created_at', 'desc')->take(4)->get();

        return view('daf.layouts.dashboard',
            compact(
                'nbreBanques',
                'nombreUtilisateurs',
                'nbreBenef',
                'nbreDoss',
                'nbreEBdownload',
                'EBtraités',
                'nbreBonDepenses',
                'nbreBonPayés',
                'sommeBonPayés',
                'sommeBonàPayer',
                'bonsDepenses'
            )
        );
    }

    public function indexCaisse()
    {
        // Récupérer le nombre d'utilisateurs du bureau
        $nombreUtilisateurs = User::whereHas('bureau', function ($query) {
            $query->where('id', 13);
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

        // Récupérer les 4 derniers bons de dépenses
        $bonsDepenses = BonDepense::orderBy('created_at', 'desc')->take(4)->get();

        // Récupérer la plus grande date
        $maxDate = DepenseSansBon::max('date_depense');

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
                'depenseJournaliere',
                'bonsDepenses',
                'maxDate'
            )
        );
    }

}
