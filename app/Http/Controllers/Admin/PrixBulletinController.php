<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PrixBulRequest;
use App\Models\PrixBulletin;
use Illuminate\Http\Request;

class PrixBulletinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prices = PrixBulletin::orderBy('created_at', 'desc')->paginate(5);
        return view('dappro.admin.prixBulletins.form', compact('prices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrixBulRequest $request)
    {
        try {
            $prices = PrixBulletin::create($request->validated());
            return redirect()->back()->with('success', 'Prix enregistré avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['prix' => 'Ce Prix existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
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
        $prices = PrixBulletin::orderBy('created_at', 'desc')->paginate(5);
        $price = PrixBulletin::findOrFail($id);

        return view('dappro.admin.prixBulletins.edit',
            compact(
                'price',
                'prices'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrixBulRequest $request, $id)
    {
        try {
            $price = PrixBulletin::findOrFail($id);

            $price->update($request->validated());
            return to_route('admin.PrixBulletin.create')->with('success', 'Prix modifié avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()
                            ->withErrors(['prix' => 'Ce Prix existe déjà.']);

            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrixBulletin $price)
    {
        $price->delete();
        return redirect()->back()->with('success', 'Le Prix a été supprimé avec succès !');
    }
}
