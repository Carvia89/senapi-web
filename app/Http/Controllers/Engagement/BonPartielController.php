<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use App\Models\Beneficiaire;
use App\Models\BonDepense;
use App\Models\Direction;
use App\Models\Dossier;
use App\Models\EtatBesoin;
use App\Models\PaiementAcompte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;


class BonPartielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupération des bons de dépense avec filtrage
        $query = BonDepense::with(['direction', 'dossier', 'utilisateur'])
                        ->where('type_bon', 'partiel');

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

        return view('daf.bur-engagement.etat-de-sorties.bon-depenses-partiel.index',
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

        return view('daf.bur-engagement.etat-de-sorties.bon-depenses-partiel.form',
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
            'montant_acompte' => 'required',
            'date_paiement' => 'required|date',
            'motif' => 'required|string|max:255',
            'beneficiaire' => 'required|string|max:255',
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
                'type_bon' => "partiel",
                'beneficiaire_id' => $request->beneficiaire_id,
                'date_emission' => $request->date_emission,
                'direction_id' => $request->direction_id,
                'etat_besoin_id' => $request->etat_besoin_id,
                'montant_bon' => $request->montant_bon,
                'motif' => $request->motif,
                'num_enreg' => $num_Enreg,
                'dossier_id' => $request->dossier_id,
                'etat' => 1,  // valeur par défaut (en cours de paiement)
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

            // Création ou mise à jour de l'enregistrement dans la table service_budget_visas
            $acompte = new PaiementAcompte();
            $acompte->date_paiement = $request->date_paiement;
            $acompte->montant_acompte = $request->montant_acompte;
            $acompte->beneficiaire = $request->beneficiaire;
            $acompte->bon_depense_id = $bonDepense->id;
            $acompte->save();

            return redirect()->route('admin.bon-de-dépense-partielle.index')->with('success', 'Bon de Dépense enregistré avec succès.');

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
        //$bonDepense = BonDepense::findOrFail($id);
        $bonDepense = BonDepense::with('paiementsAcomptes')->findOrFail($id);
        $paiements = PaiementAcompte::where('bon_depense_id', $id)->get(); // Récupérer les paiements associés

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

        $montantAcompte = $bonDepense->paiementsAcomptes->first()->montant_acompte ?? 0;
        $datePaiement1 = $bonDepense->paiementsAcomptes->first()->date_paiement ?? ' ';
        $benef = $bonDepense->paiementsAcomptes->first()->beneficiaire ?? ' ';

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
        $pdf = Pdf::loadView('daf.bur-engagement.etat-de-sorties.bon-depenses-partiel.bonPartielPdf',
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
                'montantAcompte',
                'datePaiement1',
                'benef',
                'paiements'
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
        $bon = BonDepense::with('paiementsAcomptes')->findOrFail($id);

        // Récupérer le montant de l'acompte (s'il existe)
        $montantAcompte = $bon->paiementsAcomptes->first()->montant_acompte ?? 0; // 0 si aucun acompte
        $datePaiement = $bon->paiementsAcomptes->first()->date_paiement ?? ' ';
        $nomBenef = $bon->paiementsAcomptes->first()->beneficiaire ?? ' ';

        // Récupération des options pour les sélecteurs
        $directions = Direction::all();
        $etatBesoins = EtatBesoin::all();
        $beneficiaires = Beneficiaire::all();
        $dossiers = Dossier::all();

        return view('daf.bur-engagement.etat-de-sorties.bon-depenses-partiel.edit', compact(
            'bon',
            'directions',
            'etatBesoins',
            'beneficiaires',
            'dossiers',
            'montantAcompte',
            'datePaiement',
            'nomBenef'
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
            'montant_acompte' => 'required',
            'date_paiement' => 'required|date',
            'motif' => 'required|string|max:255',
            'beneficiaire' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Récupération du bon de dépense
            $bonDepense = BonDepense::findOrFail($id);

            // Mise à jour des informations du bon de dépense
            $bonDepense->update([
                'beneficiaire_id' => $request->beneficiaire_id,
                'date_emission' => $request->date_emission,
                'direction_id' => $request->direction_id,
                'etat_besoin_id' => $request->etat_besoin_id,
                'montant_bon' => $request->montant_bon,
                'motif' => $request->motif,
                'dossier_id' => $request->dossier_id,
                'etat' => 1,  // reste "en cours de paiement"
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

            // Vérifier si un acompte existe déjà pour ce bon de dépense
            $acompte = PaiementAcompte::where('bon_depense_id', $bonDepense->id)->first();

            if ($acompte) {
                // Mise à jour de l'enregistrement existant
                $acompte->date_paiement = $request->date_paiement;
                $acompte->montant_acompte = $request->montant_acompte;
                $acompte->beneficiaire = $request->beneficiaire;
                $acompte->save();
            } else {
                // Création d'un nouvel acompte si aucun n'existe
                $acompte = new PaiementAcompte();
                $acompte->date_paiement = $request->date_paiement;
                $acompte->montant_acompte = $request->montant_acompte;
                $acompte->beneficiaire = $request->beneficiaire;
                $acompte->bon_depense_id = $bonDepense->id;
                $acompte->save();
            }

            return redirect()->route('admin.bon-de-dépense-partielle.index')->with('success', 'Bon de Dépense mis à jour avec succès.');

        } catch (Exception $e) {
            return back()->withErrors(['motif' => 'Erreur lors de la mise à jour : ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
