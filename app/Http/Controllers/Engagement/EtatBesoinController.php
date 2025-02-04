<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use App\Models\Bureau;
use App\Models\Dossier;
use App\Models\EtatBesoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;


class EtatBesoinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupération des états de besoins avec filtrage
        $query = EtatBesoin::with(['bureau', 'dossier', 'utilisateur']);

        // Filtrage par bureau_id
        if ($request->filled('bureau_id')) {
            $query->where('bureau_id', $request->bureau_id);
        }

        // Filtrage par dossier_id
        if ($request->filled('dossier_id')) {
            $query->where('dossier_id', $request->dossier_id);
        }

        // Filtrage par date_reception
        if ($request->filled('date_reception')) {
            $query->whereDate('date_reception', $request->date_reception);
        }

        // Filtrage par nom ou prénom de l'utilisateur
        if ($request->filled('user_id')) {
            $query->whereHas('utilisateur', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->user_id . '%')
                  ->orWhere('prenom', 'LIKE', '%' . $request->user_id . '%');
            });
        }

        // Pagination des résultats
        $etatBesoins = $query->paginate(5);

        // Récupération des bureaux et dossiers uniques dans les états de besoins
        $bureaus = EtatBesoin::select('bureau_id')->distinct()->with('bureau')->get();
        $dossiers = EtatBesoin::select('dossier_id')->distinct()->with('dossier')->get();
        $users = EtatBesoin::select('user_id')->distinct()->with('utilisateur')->get();

        return view('daf.bur-engagement.etat-de-sorties.etat-de-besoins.index',
            compact(
                'etatBesoins',
                'bureaus',
                'dossiers',
                'users'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bureaus = Bureau::all();
        $dossiers = Dossier::all();

        return view('daf.bur-engagement.etat-de-sorties.etat-de-besoins.form',
            compact(
                'bureaus',
                'dossiers'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'bureau_id' => 'required|exists:bureaus,id',
            'dossier_id' => 'nullable|exists:dossiers,id',
            'date_reception' => 'required|date',
            'montant' => 'required',
            'fichier' => 'required|file|mimes:pdf|max:2048', // Format PDF et taille max (2MB)
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Vérification du nom de fichier
            $fileName = $request->file('fichier')->getClientOriginalName();
            $existingFile = EtatBesoin::where('fichier', $fileName)->first();

            if ($existingFile) {
                return back()->withErrors(['fichier' => 'Un fichier avec le même nom existe déjà.'])->withInput();
            }

            // Sauvegarde du fichier
            $path = $request->file('fichier')->store('etat_besoins');

            // Création de l'état de besoin
            EtatBesoin::create([
                'bureau_id' => $request->bureau_id,
                'dossier_id' => $request->dossier_id,
                'date_reception' => $request->date_reception,
                'description' => $request->description,
                'montant' => $request->montant,
                'etat' => 1, // valeur par défaut
                'fichier' => $path, // Chemin du fichier sauvegardé
                'user_id' => auth()->id(), // ID de l'utilisateur connecté
            ]);

            return redirect()->route('admin.numérisation-etat-de-besoin.index')->with('success', 'État de besoin enregistré avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['description' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Récupérer l'état de besoin par ID
        $etatBesoin = EtatBesoin::findOrFail($id);

        // Vérifier si le fichier existe
        if (Storage::exists($etatBesoin->fichier)) {
            // Retourner le fichier pour téléchargement
            return Storage::download($etatBesoin->fichier);
        } else {
            return redirect()->route('admin.numérisation-etat-de-besoin.index')
                ->withErrors(['file' => 'Le fichier n\'existe pas.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $etatBesoin = EtatBesoin::findOrFail($id);
        $bureaus = Bureau::all();
        $dossiers = Dossier::all();

        return view('daf.bur-engagement.etat-de-sorties.etat-de-besoins.edit',
            compact(
                'etatBesoin',
                'bureaus',
                'dossiers'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'bureau_id' => 'required|exists:bureaus,id',
            'dossier_id' => 'nullable|exists:dossiers,id',
            'date_reception' => 'required|date',
            'fichier' => 'required|file|mimes:pdf|max:2048', // Format PDF et taille max (2MB)
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Récupération de l'état de besoin à mettre à jour
            $etatBesoin = EtatBesoin::findOrFail($id);

            // Vérification si un nouveau fichier est fourni
            if ($request->hasFile('fichier')) {
                $fileName = $request->file('fichier')->getClientOriginalName();
                $existingFile = EtatBesoin::where('fichier', $fileName)
                    ->where('id', '!=', $id) // Ignore l'enregistrement actuel
                    ->first();

                // Si un fichier du même nom existe déjà, le supprimer
                if ($existingFile) {
                    // Supprimez le fichier de stockage
                    Storage::delete($existingFile->fichier);
                }

                // Sauvegarde du nouveau fichier
                $path = $request->file('fichier')->store('etat_besoins');
                $etatBesoin->fichier = $path; // Mettre à jour le chemin du fichier
            }

            // Mise à jour des champs
            $etatBesoin->bureau_id = $request->bureau_id;
            $etatBesoin->dossier_id = $request->dossier_id;
            $etatBesoin->date_reception = $request->date_reception;
            $etatBesoin->description = $request->description;
            $etatBesoin->user_id = auth()->id();

            // Sauvegarde des modifications
            $etatBesoin->save();

            return redirect()->route('admin.numérisation-etat-de-besoin.index')->with('success', 'État de besoin mis à jour avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['description' => 'Erreur lors de la mise à jour : ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $etatBesoin = EtatBesoin::findOrFail($id);
        $etatBesoin->delete();

        return redirect()->route('admin.numérisation-etat-de-besoin.index')
                ->with('success', 'État de besoin supprimé avec succès.');
    }

}
