<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Models\ReportAnnuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;


class ReportAnnuelController extends Controller
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
        $reports = ReportAnnuel::orderBy('created_at', 'desc')->paginate(3);
        return view('daf.bur-comptabilite.report-annuel.form', compact('reports'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'annee' => 'required|date',
            'montant_report' => 'required',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {

            // Création
            ReportAnnuel::create([
                'annee' => $request->annee,
                'montant_report' => $request->montant_report,
                'description' => $request->description
            ]);

            return redirect()->route('admin.report-annuel.create')->with('success', 'Report défini avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['montant_report' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()])->withInput();
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
        $report = ReportAnnuel::findOrFail($id);
        $reports = ReportAnnuel::orderBy('created_at', 'desc')->paginate(3);
        return view('daf.bur-comptabilite.report-annuel.edit',
            compact(
                'reports',
                'report'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'annee' => 'required|date',
            'montant_report' => 'required',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $report = ReportAnnuel::findOrFail($id);
            $report->update($request->all());
            return redirect()->route('admin.report-annuel.create')->with('success', 'Report annuel mis à jour avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['description' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
