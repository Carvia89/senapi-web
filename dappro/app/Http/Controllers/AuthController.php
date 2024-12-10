<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;


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

}
