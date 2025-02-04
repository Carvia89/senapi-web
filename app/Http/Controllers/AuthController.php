<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Niveau;
use App\Models\Option;
use App\Models\Fournisseur;
use App\Models\ClientVente;
use App\Models\CommandeVente;
use App\Models\EntreeFourniture;


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

}
