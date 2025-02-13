<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use App\Models\Imputation;
use Illuminate\Http\Request;
use Exception;


class ImputationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imputations = Imputation::orderBy('created_at', 'desc')->paginate(10);
        return view('daf.bur-engagement.imputations.index',
            compact(
                'imputations'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('daf.bur-engagement.imputations.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'imputation' => 'required|string|unique:imputations,imputation|max:6',
            'designation' => 'required|string|max:255',
        ]);

        try {
            Imputation::create($request->all());
            return redirect()->route('admin.imputation.index')->with('success', 'Imputation enregistrée avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['imputation' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $imput = Imputation::findOrFail($id);
            return view('daf.bur-engagement.imputations.edit', compact('imput'));
        } catch (Exception $e) {
            return redirect()->route('admin.imputation.index')
                ->withErrors(['imputation' => 'Erreur lors de la récupération de l\'imputation : ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'imputation' => 'required|string|max:6|unique:imputations,imputation,' . $id,
            'designation' => 'required|string|max:255',
        ]);

        try {
            $imput = Imputation::findOrFail($id);
            $imput->update($request->all());
            return redirect()->route('admin.imputation.index')->with('success', 'Imputation mise à jour avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['imputation' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $imputation = Imputation::findOrFail($id);
            $imputation->delete();
            return redirect()->route('admin.imputation.index')->with('success', 'Imputation supprimée avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['imputation' => 'Erreur lors de la suppression : ' . $e->getMessage()]);
        }
    }

    public function getNature($id)
    {
        $imputation = Imputation::find($id);
        return response()->json(['nature' => $imputation->designation]);
    }
}
