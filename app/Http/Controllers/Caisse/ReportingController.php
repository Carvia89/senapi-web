<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Models\DepenseBon;
use App\Models\DepenseSansBon;
use App\Models\Imputation;
use App\Models\RecetteCaisse;
use App\Models\ReportAnnuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportingController extends Controller
{
    public function index()
    {
        return view('daf.bur-comptabilite.reporting.rapport-financier.index');
    }

    public function indexRapDep()
    {
        // Récupérer les dossiers distincts associés aux dépenses
        $dossiers = DepenseSansBon::select('dossier_id')
            ->distinct()
            ->with('dossier') // Charger la relation vers la table "dossiers"
            ->get()
            ->pluck('dossier') // Extraire les objets "dossier"
            ->filter() // Filtrer les valeurs nulles (au cas où certaines relations n'existent pas)
            ->unique('id'); // Supprimer les doublons basés sur l'ID du dossier

        // Récupérer les références imputations distinctes associées aux dépenses
        $references = DepenseSansBon::select('reference_imputation_id')
            ->distinct()
            ->with('referImput')
            ->get()
            ->pluck('referImput') // Extraire les objets "referImput"
            ->filter() // Filtrer les valeurs nulles
            ->unique('id') // Supprimer les doublons basés sur l'ID
            ->sortBy(function ($reference) {
                return strtolower($reference->designation); // Trier par désignation en ordre alphabétique
            });

        // Récupérer toutes les imputations associées aux dépenses
        $referenceImputationIds = DepenseSansBon::pluck('reference_imputation_id')->unique();

        // Récupérer les imputations qui ont des références dans la table depense_sans_bons
        $imputations = Imputation::whereIn('id', function($query) use ($referenceImputationIds) {
            $query->select('imputation_id')
                ->from('reference_imputations')
                ->whereIn('id', $referenceImputationIds);
        })->get();

        return view('daf.bur-comptabilite.reporting.rapport-depenses.index',
            compact(
                'dossiers',
                'references',
                'imputations'
            )
        );
    }

    public function generateRapDepPdf(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'dossier_id' => 'nullable|exists:dossiers,id',
            'imputation_id' => 'nullable|exists:imputations,id',
            'reference_imputation_id' => 'nullable|exists:reference_imputations,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);
    
        // Récupérer les filtres
        $dossierId = $request->input('dossier_id');
        $imputationId = $request->input('imputation_id');
        $referenceImputationId = $request->input('reference_imputation_id');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
    
        // Construire la requête de filtrage
        $query = DepenseSansBon::query()
            ->whereBetween('date_depense', [$dateDebut, $dateFin]);
    
        // Appliquer les filtres supplémentaires
        if ($dossierId) {
            $query->where('dossier_id', $dossierId);
        }
        if ($imputationId) {
            $query->whereHas('referImput', function ($q) use ($imputationId) {
                $q->where('imputation_id', $imputationId);
            });
        }
        if ($referenceImputationId) {
            $query->where('reference_imputation_id', $referenceImputationId);
        }
    
        // Récupérer les dépenses filtrées
        $depenses = $query->get();
    
        // Calculer le total des dépenses
        $totalDepenses = $depenses->sum('montant_depense');
    
        // Récupérer la date du jour
        $dateDuJour = now();

        // Données à passer à la vue PDF
        $data = [
            'depenses' => $depenses,
            'totalDepenses' => $totalDepenses,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'dossier' => $dossierId ? $query->first()->dossier : null,
            'imputation' => $imputationId ? $query->first()->referImput->imputation : null,
            'referenceImputation' => $referenceImputationId ? $query->first()->referImput : null,
            'dateDuJour' => $dateDuJour,
        ];
    
        // Générer le PDF
        $pdf = Pdf::loadView('daf.bur-comptabilite.reporting.rapport-depenses.rapDepensePdf', $data);
    
        // Télécharger ou afficher le PDF
        return $pdf->stream('');
    }

    public function indexRapRecette()
    {
        // Récupérer les dossiers distincts associés aux recettes
        $dossiers = RecetteCaisse::select('dossier_id')
            ->distinct()
            ->with('dossier') // Charger la relation vers la table "dossiers"
            ->get()
            ->pluck('dossier') // Extraire les objets "dossier"
            ->filter() // Filtrer les valeurs nulles (au cas où certaines relations n'existent pas)
            ->unique('id'); // Supprimer les doublons basés sur l'ID du dossier

        // Récupérer toutes les imputations associées aux recettes
        $referenceImputationIds = RecetteCaisse::pluck('reference_imputation_id')->unique();

        // Récupérer les imputations qui ont des références dans la table depense_sans_bons
        $imputations = Imputation::whereIn('id', function($query) use ($referenceImputationIds) {
            $query->select('imputation_id')
                ->from('reference_imputations')
                ->whereIn('id', $referenceImputationIds);
        })->get();

        return view('daf.bur-comptabilite.reporting.rapport-recettes.index',
            compact(
                'dossiers',
                'imputations'
            )
        );
    }

    public function generateRapRecettPdf(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'dossier_id' => 'nullable|exists:dossiers,id',
            'imputation_id' => 'nullable|exists:imputations,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);
    
        // Récupérer les filtres
        $dossierId = $request->input('dossier_id');
        $imputationId = $request->input('imputation_id');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
    
        // Construire la requête de filtrage
        $query = RecetteCaisse::query()
            ->whereBetween('date_recette', [$dateDebut, $dateFin]);
    
        // Appliquer les filtres supplémentaires
        if ($dossierId) {
            $query->where('dossier_id', $dossierId);
        }
        if ($imputationId) {
            $query->whereHas('refeImputation', function ($q) use ($imputationId) {
                $q->where('imputation_id', $imputationId);
            });
        }
    
        // Récupérer les recettes filtrées
        $recettes = $query->get();
    
        // Calculer le total des dépenses
        $totalRecettes = $recettes->sum('montant_recu');
    
        // Récupérer la date du jour
        $dateDuJour = now();

        // Données à passer à la vue PDF
        $data = [
            'recettes' => $recettes,
            'totalRecettes' => $totalRecettes,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'dossier' => $dossierId ? $query->first()->dossier : null,
            'imputation' => $imputationId ? $query->first()->refeImputation->imputation : null,
            'dateDuJour' => $dateDuJour,
        ];
    
        // Générer le PDF
        $pdf = Pdf::loadView('daf.bur-comptabilite.reporting.rapport-recettes.rapRecettePdf', $data);
    
        // Télécharger ou afficher le PDF
        return $pdf->stream('');
    }

    public function depenseReportPdf(Request $request)
    {

        // Récupérer les dates
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');

        // Logique pour récupérer les données du rapport financier pour cette date
        //$reportData = $this->getDailyReportData($date);

        // Charger la vue dans le PDF
        $pdf = Pdf::loadView('daf.bur-comptabilite.reporting.rapport-depenses.rapDepensePdf',
            compact(
                'dateDebut',
                'dateFin'
            )
        );

        // Configurer le format du papier et l'orientation
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('');
    }


    public function generatePdf(Request $request)
    {
        // Validation de la date
        $request->validate([
            'date_jour' => 'required|date',
        ]);

        // Récupérer la date du jour
        $date = $request->input('date_jour');

        // Logique pour récupérer les données du rapport financier pour cette date
        $reportData = $this->getDailyReportData($date);

        // Charger la vue dans le PDF
        $pdf = Pdf::loadView('daf.bur-comptabilite.reporting.rapport-financier.rapportPdf',
            compact(
                'date',
                'reportData'
            )
        );

        // Configurer le format du papier et l'orientation
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('');
    }

    public function generatePeriodicReport(Request $request)
    {
        // Valider les dates
        $request->validate([
            'date_debut' => 'required|date|before_or_equal:date_fin',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        // Récupérer les dates
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');

        // Récupérer la date du jour
        $dateDuJour = now();

        // Calculer les données
        $reportData = $this->calculateReportData($dateDebut, $dateFin);

        // Charger la vue dans le PDF
        $pdf = Pdf::loadView('daf.bur-comptabilite.reporting.rapport-financier.rapPeriodikPdf',
            compact(
                'dateDebut',
                'dateFin',
                'reportData',
                'dateDuJour'
            )
        );

        // Configurer le format du papier et l'orientation
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('');
    }


    private function getDailyReportData($date)
    {
        // Convertir la date en format compatible pour les requêtes
        $dateStart = \Carbon\Carbon::parse($date)->startOfDay();
        $dateEnd = \Carbon\Carbon::parse($date)->endOfDay();

        // Récupérer les dépenses des "depense_bons" en passant par la relation
        $depensesBons = DepenseBon::with(['bonDepense'])
            ->whereHas('bonDepense', function ($query) use ($dateStart, $dateEnd) {
                $query->whereBetween('date_depense', [$dateStart, $dateEnd]);
            })
            ->get(['bon_depense_id']); // Récupérez uniquement l'ID de bon_depense

        // Transformer les données pour inclure les champs souhaités
        $depensesBonsData = $depensesBons->map(function ($depense) {
            return [
                'motif' => $depense->bonDepense->motif,
                'montant_bon' => $depense->bonDepense->montant_bon,
                'bon_depense_id' => $depense->bon_depense_id,
            ];
        });

        // Récupérer les dépenses des "depense_sans_bons"
        //$depensesSansBons = DepenseSansBon::whereBetween('date_depense', [$dateStart, $dateEnd])
        //    ->get(['libelle', 'montant_depense', 'reference_imputation_id']);
        $depensesSansBons = DepenseSansBon::whereBetween('date_depense', [$dateStart, $dateEnd])
        ->join('reference_imputations', 'depense_sans_bons.reference_imputation_id', '=', 'reference_imputations.id')
        ->join('imputations', 'reference_imputations.imputation_id', '=', 'imputations.id')
        ->get(['depense_sans_bons.libelle', 'depense_sans_bons.montant_depense', 'imputations.imputation']);


        // Récupérer les recettes des "recette_caisses"
        $recettes = RecetteCaisse::whereBetween('date_recette', [$dateStart, $dateEnd])
            ->get(['libelle', 'montant_recu']);

        // Calculer les montants pour la ligne "REPORT"
        $recettesAnterieures = RecetteCaisse::where('date_recette', '<', $dateStart)
            ->sum('montant_recu');

        $montantReport = DB::table('report_annuels')->sum('montant_report');

        // Calculer le montant total du report
        $depensesAnterieuresBons = DepenseBon::with(['bonDepense'])
            ->whereHas('bonDepense', function ($query) use ($dateStart) {
                $query->where('date_depense', '<', $dateStart);
            })
            ->get();

        $totalMontantBons = $depensesAnterieuresBons->sum(function ($depense) {
            return $depense->bonDepense->montant_bon ?? 0; // Sécuriser l'accès
        });

        $depensesAnterieuresSansBons = DepenseSansBon::where('date_depense', '<', $dateStart)
            ->sum('montant_depense');

        // Calculer le montant total du report
        $reportMontant = $recettesAnterieures + $montantReport - ($totalMontantBons + $depensesAnterieuresSansBons);

        // Calculer les montants pour la ligne "REPORT"
        $recettesToday = RecetteCaisse::where('date_recette', $dateStart)
            ->sum('montant_recu');

        // Organiser les données en un tableau
        $reportData = [
            'report' => [
                'libelle' => 'REPORT',
                'montant_report' => $reportMontant,
                'solde' => $reportMontant, // Le solde est égal au montant du report
            ],
            'depenses_bons' => $depensesBonsData,
            'depenses_sans_bons' => $depensesSansBons,
            'recettes' => $recettes,
            'recettesToday' => $recettesToday,
        ];

        return $reportData;
    }


    protected function calculateReportData($dateDebut, $dateFin)
    {
        // Récupérer les imputations liées aux dépenses sans bons
        $imputations = Imputation::select('imputations.id', 'imputations.imputation', 'imputations.designation')
        ->join('reference_imputations', 'imputations.id', '=', 'reference_imputations.imputation_id')
        ->join('depense_sans_bons', 'reference_imputations.id', '=', 'depense_sans_bons.reference_imputation_id')
        ->distinct()
        ->get();

        // Récupérer les recettes dans la période spécifiée
        $recettes = RecetteCaisse::select('reference_imputation_id', DB::raw('SUM(montant_recu) as total_recu'))
        ->whereBetween('date_recette', [$dateDebut, $dateFin])
        ->groupBy('reference_imputation_id')
        ->with(['refeImputation' => function ($query) {
            $query->orderBy('designation', 'asc'); // Tri par ordre alphabétique
        }])
        ->get()
        ->unique('reference_imputation_id')
        ->map(function ($recette) {
            return [
                'designation' => $recette->refeImputation->designation,
                'total_recu' => $recette->total_recu,
            ];
        })
        ->sortBy('designation'); // Tri supplémentaire pour s'assurer que les résultats sont bien ordonnés

        // Récupérer les dépenses avec bons
        $depensesBons = DepenseBon::select('reference_imputation_id', DB::raw('SUM(bon_depenses.montant_bon) as total_bon'))
            ->join('bon_depenses', 'depense_bons.bon_depense_id', '=', 'bon_depenses.id')
            ->whereHas('bonDepense', function ($query) use ($dateDebut, $dateFin) {
                $query->whereBetween('date_depense', [$dateDebut, $dateFin]);
            })
            ->groupBy('reference_imputation_id')
            ->with(['referImput' => function ($query) {
                $query->with('imputation'); // Charger la relation vers imputations
            }])
            ->get()
            ->unique('reference_imputation_id')
            ->map(function ($depense) {
                return [
                    'designation' => $depense->referImput->designation,
                    'total_bon' => $depense->total_bon,
                    'imputation' => $depense->referImput->imputation, // Récupérer l'imputation
                ];
            });

        /* Récupérer les dépenses sans bons selon leurs imputations */
        $depensesParImputation = DepenseSansBon::select('reference_imputation_id', DB::raw('SUM(montant_depense) as total_depense'))
        ->whereBetween('date_depense', [$dateDebut, $dateFin])
        ->groupBy('reference_imputation_id')
        ->with(['referImput' => function ($query) {
            $query->with('imputation'); // Charger la relation vers imputations
        }])
        ->get()
        ->groupBy(function ($depense) {
            return $depense->referImput->imputation->id; // Grouper par ID d'imputation
        })
        ->map(function ($group) {
            return [
                'imputation' => $group->first()->referImput->imputation, // Récupérer l'imputation
                'depenses' => $group->map(function ($depense) {
                    return [
                        'designation' => $depense->referImput->designation,
                        'total_depense' => $depense->total_depense,
                    ];
                }),
            ];
        })
        ->sortBy(function ($item) {
            return $item['imputation']->id; // Trier par ID d'imputation
        });


        // Calculer le report
        $recettesAnterieures = RecetteCaisse::where('date_recette', '<', $dateDebut)
            ->sum('montant_recu');

        $montantReport = DB::table('report_annuels')->sum('montant_report');

        $totalMontantBons = DepenseBon::join('bon_depenses', 'depense_bons.bon_depense_id', '=', 'bon_depenses.id')
            ->where('depense_bons.date_depense', '<', $dateDebut)
            ->sum('bon_depenses.montant_bon');

        $depensesAnterieuresSansBons = DepenseSansBon::where('date_depense', '<', $dateDebut)
            ->sum('montant_depense');

        // Calculer le montant total du report
        $reportMontant = $recettesAnterieures + $montantReport - ($totalMontantBons + $depensesAnterieuresSansBons);

        // Préparer les données pour la vue PDF
        return [
            'report' => [
                'libelle' => 'REPORT',
                'montant_report' => $reportMontant,
                'solde' => $reportMontant,
            ],
            'depensesParImputation' => $depensesParImputation,
            'imputations' => $imputations,
            'recettes' => $recettes,
            'depenses_bons' => $depensesBons,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
        ];
    }
}
