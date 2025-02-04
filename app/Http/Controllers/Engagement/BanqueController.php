<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use App\Models\Banque;
use Illuminate\Http\Request;
use Exception;


class BanqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enregistrements = Banque::orderBy('created_at', 'desc')->paginate(5);
        return view('daf.bur-engagement.banques.index',
            compact(
                'enregistrements'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('daf.bur-engagement.banques.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|string|max:50',
            'devise_compte' => 'required|string|max:3',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            Banque::create($request->all());
            return redirect()->route('admin.banque-senapi.index')->with('success', 'Banque enregistrée avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['designation' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $enregistrement = Banque::findOrFail($id);
            return view('daf.bur-engagement.banques.edit', compact('enregistrement'));
        } catch (Exception $e) {
            return redirect()->route('admin.banque-senapi.index')
                ->withErrors(['designation' => 'Erreur lors de la récupération de la banque : ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required|string|max:50',
            'devise_compte' => 'required|string|max:3',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $enregistrement = Banque::findOrFail($id);
            $enregistrement->update($request->all());
            return redirect()->route('admin.banque-senapi.index')->with('success', 'Banque mise à jour avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['designation' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $enregistrement = Banque::findOrFail($id);
            $enregistrement->delete();
            return redirect()->route('admin.banque-senapi.index')->with('success', 'Banque supprimée avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['designation' => 'Erreur lors de la suppression : ' . $e->getMessage()]);
        }
    }
}
