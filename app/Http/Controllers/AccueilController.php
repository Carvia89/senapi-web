<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\Direction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccueilController extends Controller
{
    public function accueil()
    {
        // Récupérer toutes les directions et les bureaux
        //$directions = Direction::all();
        //Récupéredr tous les bureaux
        $bureaux = Bureau::all();
        // Charger toutes les directions
        $directions = Direction::with('divisions.bureaux')->get(); // Charger les divisions et leurs bureaux

        return view('welcome', compact('directions', 'bureaux'));
    }

    public function showLoginForm($direction_id)
    {
        // Récupération de la direction par ID
        $direction = Direction::find($direction_id);

        // Vérifiez si la direction existe
        if (!$direction) {
            abort(404); // Ou redirigez vers une page d'erreur
        }
        // Passez la variable à la vue
        return view('auth.login', compact('direction'));
    }

    public function login(Request $request, $direction_id)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Récupérer les identifiants
        $credentials = $request->only('email', 'password');

        // Tenter de connecter l'utilisateur
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
/*
            // Débogage : afficher les infos de l'utilisateur
            Log::info('Comparaison des directions:', [
                'user_direction_id' => $user->division->direction->id,
                'expected_direction_id' => $direction_id,
                'comparison_result' => (int) $user->division->direction->id === (int) $direction_id,
            ]);
*/
            // Vérifiez si l'utilisateur a une division et une direction
            if ($user->division && $user->division->direction) {
                if ((int) $user->division->direction->id !== (int) $direction_id) {
                    Auth::logout(); // Déconnexion de l'utilisateur
                    return redirect()->route('login.show', ['direction_id' => $direction_id])
                        ->withErrors(['access' => 'Accès refusé à cette direction.']);
                }

                // Stockez direction_id dans la session
                $request->session()->put('direction_id', $user->division->direction->id);

                // Redirigez vers le tableau de bord
                return redirect()->route('dashboard.direction' . $direction_id);
            } else {
                Auth::logout(); // Déconnexion de l'utilisateur
                return redirect()->route('login.show', ['direction_id' => $direction_id])
                    ->withErrors(['access' => 'L\'utilisateur n\'est pas associé à une division ou une direction.']);
            }
        }

        // Authentification échouée
        return redirect()->back()
            ->withErrors(['email' => 'Identifiants incorrects.'])
            ->withInput();
    }

    public function getBureaux($direction_id)
    {
        $bureaux = Bureau::whereHas('division', function($query) use ($direction_id) {
            $query->where('direction_id', $direction_id);
        })->get();

        return response()->json($bureaux);
    }

    public function loginUser(Request $request)
    {

            // Validation des données
            $request->validate([
                'direction_id' => 'required|exists:directions,id',
                'bureau_id' => 'required|exists:bureaus,id',
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Vérifiez si le bureau appartient à la direction
            $bureau = Bureau::with('division')->find($request->bureau_id);
            if ($bureau->division->direction_id != $request->direction_id) {
                return back()->withErrors(['bureau_id' => 'Ce bureau n\'appartient pas à la direction sélectionnée.']);
            }

            // Authentification de l'utilisateur
            $user = User::where('email', $request->email)->first();

            if ($user && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentification réussie

                // Vérifiez que l'utilisateur appartient au bureau sélectionné
                if ($user->bureau_id != $bureau->id) {
                    return back()->withErrors(['bureau_id' => 'Vous n\'appartenez pas à ce bureau.']);
                }

                // Redirection en fonction du bureau et du rôle de l'utilisateur
                if ($user->bureau_id == 3 && $user->role == 'User') {
                    return redirect()->route('dashboard.bureau')->with('success', 'Bienvenue sur votre tableau de bord');
                } elseif ($user->bureau_id == 2 && $user->role == 'Admin') {
                    return redirect()->route('dashboard.admin')->with('success', 'Bienvenue Admin');
                }
                // Ajoutez d'autres conditions ici selon vos besoins
                // Exemple supplémentaire
                elseif ($user->bureau_id == 3 && $user->role == 'user') {
                    return redirect()->route('dashboard3')->with('success', 'Bienvenue sur votre tableau de bord 3');
                }

                // Redirection par défaut si aucune condition ne correspond
                return redirect()->route('dashboard')->with('success', 'Bienvenue sur votre tableau de bord');
            }

            // Si l'authentification échoue
            return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }
}
