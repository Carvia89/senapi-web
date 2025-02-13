<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Models\BonDepense;
use Illuminate\Support\Facades\Auth;
use App\Models\Niveau;
use App\Models\Option;
use App\Models\Fournisseur;
use App\Models\ClientVente;
use App\Models\CommandeVente;
use App\Models\DepenseBon;
use App\Models\DepenseSansBon;
use App\Models\EntreeFourniture;
use App\Models\EtatBesoin;
use App\Models\PaiementAcompte;
use App\Models\RecetteCaisse;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function handleLogin(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect()->route('dashboard');

        } else {

            return redirect()->back()->with('error_msg', 'Utilisateur ou le mot de passe incorrect');
        }
    }

    public function logout()
    {
        //Déconnecter l'utilisateur
        Auth::logout();

        //Le rédiriger vers la page login
        return redirect('/');
    }

    public function loginDG()
    {
        return view('dg.auth.login');
    }

    public function handleLoginDG(Request $request)
    {
        // Validation des données d'entrée
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Authentification de l'utilisateur
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Récupérer l'utilisateur authentifié
            $user = Auth::user();

            // Vérifier le rôle et la direction via les relations
            if (($user->role === 'DG' || $user->role === 'Agent') &&
                $user->bureau &&
                $user->bureau->division &&
                $user->bureau->division->direction_id === 2) {
                // Redirection vers le tableau de bord
                return redirect()->route('dashboard.direction2');
            } else {
                // Déconnexion de l'utilisateur si les conditions ne sont pas remplies
                Auth::logout();
                return redirect()->back()->withErrors(['error' => 'Accès non autorisé.']);
            }
        }

        // Si les informations d'identification ne sont pas valides
        return redirect()->back()->withErrors(['error' => 'Identifiants invalides.']);
    }

    public function index2()
    {
        $niveauxCount = Niveau::count();                //Compter le nombre de niveaux
        $optionCount = Option::count();                 //Compter le nombre d'options
        $fournisseurCount = Fournisseur::count();       //Compter le nombre de fournisseurs
        $clientCount = ClientVente::count();
        // Compter le nombre de commandes distinctes avec category_cmd = "Interne"
        $interneCount = CommandeVente::where('category_cmd', 'Interne')
                                    ->distinct('num_cmd') // Compter uniquement les commandes distinctes
                                    ->count('num_cmd'); // Compter les num_cmd distincts

        // Compter le nombre de commandes distinctes avec category_cmd = "Externe"
        $externeCount = CommandeVente::where('category_cmd', 'Externe')
                                    ->distinct('num_cmd') // Compter uniquement les commandes distinctes
                                    ->count('num_cmd'); // Compter les num_cmd distincts

        $commande = $interneCount + $externeCount;

        $QteBulRecu = EntreeFourniture::sum('quantiteRecu');

        return view('dg.dashboard.dashboard',
            compact(
                'niveauxCount',
                'optionCount',
                'fournisseurCount',
                'clientCount',
                'commande',
                'QteBulRecu'
            )
        );
    }


    public function indexDAF()
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

        return view('daf.daf.dashboard.dashboardDAF',
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

    public function dashDAFpourDG()
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

        return view('dg.dashboard.dafDashboard',
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
