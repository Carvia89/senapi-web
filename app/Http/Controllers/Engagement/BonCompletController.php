<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EtatBesoin;
use App\Models\Direction;
use App\Models\Beneficiaire;
use App\Models\BonDepense;
use App\Models\Dossier;
use App\Models\PaiementAcompte;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class BonCompletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupération des bons de dépense avec filtrage
        $query = BonDepense::with(['direction', 'dossier', 'utilisateur'])
                        ->where('type_bon', 'complet');

        // Filtrage par direction_id
        if ($request->filled('direction_id')) {
            $query->where('direction_id', $request->direction_id);
        }

        // Filtrage par dossier_id
        if ($request->filled('dossier_id')) {
            $query->where('dossier_id', $request->dossier_id);
        }

        // Filtrage par date_emission
        if ($request->filled('date_emission')) {
            $query->whereDate('date_emission', $request->date_emission);
        }

        // Filtrage par montant_bon
        if ($request->filled('montant_bon')) {
            $query->where('montant_bon', $request->montant_bon);
        }

        // Filtrage par motif
        if ($request->filled('motif')) {
            $query->where('motif', $request->motif);
        }

        // Filtrage par nom ou prénom de l'utilisateur
        if ($request->filled('user_id')) {
            $query->whereHas('utilisateur', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->user_id . '%')
                  ->orWhere('prenom', 'LIKE', '%' . $request->user_id . '%');
            });
        }

        // Tri des résultats par date d'émission en ordre descendant
        $query->orderBy('created_at', 'desc');

        // Pagination des résultats
        $bonDepenses = $query->paginate(10);

        // Récupération des directions et dossiers uniques dans bons de dépenses
        $directions = BonDepense::select('direction_id')->distinct()->with('direction')->get();
        $dossiers = BonDepense::select('dossier_id')->distinct()->with('dossier')->get();
        $users = BonDepense::select('user_id')->distinct()->with('utilisateur')->get();

        return view('daf.bur-engagement.etat-de-sorties.bon-depenses-cplt.index',
            compact(
                'bonDepenses',
                'directions',
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
        $directions = Direction::all();
        $etatBesoins = EtatBesoin::all();
        $beneficiaires = Beneficiaire::all();
        $dossiers = Dossier::all();

        // Récupération du dernier numéro de bon
        $lastBon = BonDepense::orderBy('num_bon', 'desc')->first();
        $num_bon = "DAF000001"; // Valeur par défaut si aucun Bon n'existe

        if ($lastBon) {
            // Extraction du numéro après le préfixe "DAF"
            $lastNum = (int) substr($lastBon->num_bon, 3); // Enlève "DAF" et convertit en entier
            $newNum = $lastNum + 1; // Incrémente le numéro
            $num_bon = "DAF" . str_pad($newNum, 6, '0', STR_PAD_LEFT); // Formate le nouveau numéro
        }

        // Récupération du dernier numéro Enregistrement
        $lastEnreg = BonDepense::orderBy('num_enreg', 'desc')->first();
        $num_Enreg = "ENR00001"; // Valeur par défaut si aucun Enreg n'existe

        if ($lastEnreg) {
            // Extraction du numéro après le préfixe "ENR"
            $lastNumEnreg = (int) substr($lastEnreg->num_enreg, 3); // Enlève "ENR" et convertit en entier
            $newNumEnreg = $lastNumEnreg + 1; // Incrémente le numéro
            $num_Enreg = "ENR" . str_pad($newNumEnreg, 5, '0', STR_PAD_LEFT); // Formate le nouveau numéro
        }

        return view('daf.bur-engagement.etat-de-sorties.bon-depenses-cplt.form',
            compact(
                'etatBesoins',
                'directions',
                'beneficiaires',
                'dossiers',
                'num_bon',
                'num_Enreg'
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
            'direction_id' => 'required|exists:directions,id',
            'dossier_id' => 'nullable|exists:dossiers,id',
            'etat_besoin_id' => 'nullable|exists:etat_besoins,id',
            'beneficiaire_id' => 'required|exists:beneficiaires,id',
            'date_emission' => 'required|date',
            'montant_bon' => 'required',
            'motif' => 'required|string|max:255',
            'pour_acquit' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Récupération ou initialisation des données de la commande
            $num_bon = $request->input('num_bon');
            $num_Enreg = $request->input('num_enreg');

            // Création du bon de dépenses
            $bonDepense = BonDepense::create([
                'num_bon' => $num_bon,
                'type_bon' => "complet",
                'beneficiaire_id' => $request->beneficiaire_id,
                'date_emission' => $request->date_emission,
                'direction_id' => $request->direction_id,
                'etat_besoin_id' => $request->etat_besoin_id,
                'montant_bon' => $request->montant_bon,
                'motif' => $request->motif,
                'num_enreg' => $num_Enreg,
                'pour_acquit' => $request->pour_acquit,
                'dossier_id' => $request->dossier_id,
                'etat' => 1,  // valeur par défaut (en attente de traitement)
                'date_acquit' => $request->date_acquit,
                'user_id' => auth()->id(), // ID de l'utilisateur connecté
            ]);

            // Mise à jour de l'état de besoin associé
            if ($request->etat_besoin_id) {
                $etatBesoin = EtatBesoin::find($request->etat_besoin_id);
                if ($etatBesoin) {
                    $etatBesoin->etat = 2; // Mise à jour de l'état
                    $etatBesoin->save();
                }
            }

            // Stocker les informations dans la session pour les réutiliser
            session([
                'beneficiaire_id' => $request->beneficiaire_id,
                'direction_id' => $request->direction_id,
                'motif' => $request->motif,
                'pour_acquit' => $request->pour_acquit,
                'montant_bon' => $request->montant_bon,
            ]);

            return redirect()->route('admin.bon-de-dépense-complète.index')->with('success', 'Bon de Dépense enregistré avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['motif' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Récupérer le bon de dépense par ID
        $bonDepense = BonDepense::findOrFail($id);

        // Récupérer les valeurs spécifiques
        $numBon = $bonDepense->num_bon;
        $dateEmission = $bonDepense->date_emission;
        $direction = $bonDepense->direction->designation;
        $beneficiare = $bonDepense->beneficiaire->nom;
        $montantBon = $bonDepense->montant_bon;
        $etatBesoin = $bonDepense->etatBesoin->id ?? ' ';
        $motif = $bonDepense->motif;
        $NumEnreg = $bonDepense->num_enreg;
        $dateAcquit = $bonDepense->date_acquit ?? ' ';
        $pourAcquit = $bonDepense->pour_acquit ?? ' ';
        $imputation = $bonDepense->imputCode->imputation ?? ' ';

        // Vérification de l'existence de l'imputation
        $imputationExists = !empty($imputation);

        // Vérifier si le champ "etat" est supérieur à 1
        $etat = $bonDepense->etat; // Assurez-vous que ce champ existe
        $showSignature = $etat > 1; // Condition pour afficher la signature

        // Chemin de la signature
        $signaturePath = $showSignature ? public_path('daf/assets/images/signatures/signature.jpg') : null;
        $dateImput = $showSignature ? $bonDepense->updated_at : null;

        // Convertir le montant en lettres
        $montantEnLettres = $this->convertirMontantEnLettres($montantBon);

        // Générer le PDF à partir de la vue
        $pdf = Pdf::loadView('daf.bur-engagement.etat-de-sorties.bon-depenses-cplt.bonPdf',
            compact(
                'bonDepense',
                'numBon',
                'dateEmission',
                'direction',
                'beneficiare',
                'montantBon',
                'montantEnLettres',
                'etatBesoin',
                'motif',
                'NumEnreg',
                'dateAcquit',
                'pourAcquit',
                'imputation',
                'dateImput',
                'imputationExists',
                'signaturePath',
                'showSignature', // Passer le chemin de la signature à la vue
            )
        );

        // Retourner le PDF en téléchargement
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Récupération du bon de dépense par son ID
        $bon = BonDepense::findOrFail($id);

        // Récupération des options pour les sélecteurs
        $directions = Direction::all();
        $etatBesoins = EtatBesoin::all();
        $beneficiaires = Beneficiaire::all();
        $dossiers = Dossier::all();

        return view('daf.bur-engagement.etat-de-sorties.bon-depenses-cplt.edit', compact(
            'bon',
            'directions',
            'etatBesoins',
            'beneficiaires',
            'dossiers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'direction_id' => 'required|exists:directions,id',
            'dossier_id' => 'nullable|exists:dossiers,id',
            'etat_besoin_id' => 'nullable|exists:etat_besoins,id',
            'beneficiaire_id' => 'required|exists:beneficiaires,id',
            'date_emission' => 'required|date',
            'montant_bon' => 'required',
            'motif' => 'required|string|max:255',
            'pour_acquit' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Récupération du bon de dépense à mettre à jour
            $bon = BonDepense::findOrFail($id);

            // Mise à jour des données du bon de dépenses
            $bon->update([
                'beneficiaire_id' => $request->beneficiaire_id,
                'date_emission' => $request->date_emission,
                'direction_id' => $request->direction_id,
                'etat_besoin_id' => $request->etat_besoin_id,
                'montant_bon' => $request->montant_bon,
                'motif' => $request->motif,
                'pour_acquit' => $request->pour_acquit,
                'dossier_id' => $request->dossier_id,
                'date_acquit' => $request->date_acquit,
                'imputation_id' => null,
                'etat' => 1,
                'user_id' => auth()->id(),
            ]);

            // Mise à jour de l'état de besoin associé
            if ($request->etat_besoin_id) {
                $etatBesoin = EtatBesoin::find($request->etat_besoin_id);
                if ($etatBesoin) {
                    $etatBesoin->etat = 2; // Mise à jour de l'état
                    $etatBesoin->save();
                }
            }

            // Stocker les informations dans la session pour les réutiliser
            session([
                'beneficiaire_id' => $request->beneficiaire_id,
                'direction_id' => $request->direction_id,
                'motif' => $request->motif,
                'pour_acquit' => $request->pour_acquit,
                'montant_bon' => $request->montant_bon,
            ]);

            return redirect()->route('admin.bon-de-dépense-complète.index')->with('success', 'Bon de Dépense mis à jour avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['motif' => 'Erreur lors de la mise à jour : ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Récupération du bon de dépense à supprimer
            $bonDepense = BonDepense::findOrFail($id);

        // Récupération de l'état de besoin associé
        $etatBesoinId = $bonDepense->etatBesoin->id ?? null; // Accès via la relation

        // Suppression du bon de dépense
        $bonDepense->delete();

        // Mise à jour de l'état de besoin associé
        if ($etatBesoinId) {
            $etatBesoin = EtatBesoin::find($etatBesoinId);
            if ($etatBesoin) {
                $etatBesoin->etat = 1; // Mise à jour de l'état
                $etatBesoin->save();
            }
        }

            return redirect()->route('admin.bon-de-dépense-complète.index')->with('success', 'Bon de Dépense supprimé avec succès.');
        } catch (Exception $e) {
            return back()->withErrors(['motif' => 'Erreur lors de la suppression : ' . $e->getMessage()]);
        }
    }

    public function downloadEB($id)
    {
        // Récupérer l'état de besoin par ID
        $etatBesoin = EtatBesoin::findOrFail($id);

        // Vérifier si le fichier existe
        if (Storage::exists($etatBesoin->fichier)) {
            // Retourner le fichier pour téléchargement
            return Storage::download($etatBesoin->fichier);
        } else {
            return redirect()->route('admin.bon-de-dépense-complète.index')
                ->withErrors(['montant_bon' => 'Le fichier n\'existe pas.']);
        }
    }

    public function convertirMontantEnLettres($montant)
    {
        $unites = [
            0 => '', 1 => 'Un', 2 => 'Deux', 3 => 'Trois', 4 => 'Quatre',
            5 => 'Cinq', 6 => 'Six', 7 => 'Sept', 8 => 'Huit', 9 => 'Neuf',
            10 => 'Dix', 11 => 'Onze', 12 => 'Douze', 13 => 'Treize',
            14 => 'Quatorze', 15 => 'Quinze', 16 => 'Seize', 17 => 'Dix-Sept',
            18 => 'Dix-Huit', 19 => 'Dix-Neuf',
        ];

        $dizaines = [
            2 => 'Vingt', 3 => 'Trente', 4 => 'Quarante', 5 => 'Cinquante',
            6 => 'Soixante', 7 => 'Septante', 8 => 'Quatre-Vingts',
            9 => 'Nonante',
        ];

        // Sépare le montant en euros et centimes
        $montantEntier = floor($montant);
        $centimes = round(($montant - $montantEntier) * 100);

        // Conversion pour le montant entier
        $lettres = '';

        if ($montantEntier == 0) {
            $lettres = 'zéro';
        } elseif ($montantEntier < 20) {
            $lettres = $unites[$montantEntier];
        } elseif ($montantEntier < 100) {
            $dizaine = floor($montantEntier / 10);
            $reste = $montantEntier % 10;
            $lettres = $dizaines[$dizaine] . ($reste ? '-' . $unites[$reste] : '');
        } elseif ($montantEntier < 1000) {
            $centaines = floor($montantEntier / 100);
            $reste = $montantEntier % 100;
            $lettres = $unites[$centaines] . ' Cent' . ($centaines > 1 ? 's' : '');
            if ($reste > 0) {
                $lettres .= ' ' . $this->convertirMontantEnLettres($reste);
            }
        } elseif ($montantEntier < 1000000) {
            $milliers = floor($montantEntier / 1000);
            $reste = $montantEntier % 1000;
            $lettres = $this->convertirMontantEnLettres($milliers) . ' Mille';
            if ($reste > 0) {
                $lettres .= ' ' . $this->convertirMontantEnLettres($reste);
            }
        } else {
            $millions = floor($montantEntier / 1000000);
            $reste = $montantEntier % 1000000;
            $lettres = $this->convertirMontantEnLettres($millions) . ' Million' . ($millions > 1 ? 's' : '');
            if ($reste > 0) {
                $lettres .= ' ' . $this->convertirMontantEnLettres($reste);
            }
        }

        // Ajoutez la partie décimale
        if ($centimes > 0) {
            $lettres .= ' et ' . $this->convertirMontantEnLettres($centimes) . ' Centime' . ($centimes > 1 ? 's' : '');
        }

        return trim($lettres);
    }
}
