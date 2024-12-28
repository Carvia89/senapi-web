<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Bureau;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(4);
        $bureaus = Bureau::all();

        return view('dappro.admin.utilisateurs.index',
                compact('users', 'bureaus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $bureaus = Bureau::all();
        return view('dappro.admin.utilisateurs.form',
                compact('bureaus'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            // Ajouter la valeur par défaut pour account_status
            $data = $request->validated();
            $data['account_status'] = 1; // Définir account_status à 1

            $users = User::create($data);

            return to_route('admin.Utilisateur.index')
                    ->with('success', 'Utilisateur créé avec succès.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['email' => 'Cette adresse est déjà utilisée.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $user = User::findOrFail($id);
        $bureaus = Bureau::all();
        return view('dappro.admin.utilisateurs.edit', compact('user', 'bureaus'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            return to_route('admin.Utilisateur.index')
                    ->with('success', 'L\'utilisateur a été mis à jour avec succès.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['email' => 'Cette adresse est déjà utilisée.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.Utilisateur.index')
                        ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
