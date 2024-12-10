<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Vérifiez si la route actuelle nécessite une redirection
        if (!$request->expectsJson()) {
            // Vérifiez si nous avons un direction_id dans la session
            $direction_id = $request->session()->get('direction_id');

            // Redirigez avec direction_id s'il est disponible
            if ($direction_id) {
                return route('login', ['direction_id' => $direction_id]);
            }

            // Si direction_id n'est pas disponible, redirigez vers une route générique ou la page d'accueil
            //return route('login', ['direction_id' => 1]);
            return route('page.accueil');
        }

        return null; // Pour les requêtes JSON, aucune redirection
    }
}
