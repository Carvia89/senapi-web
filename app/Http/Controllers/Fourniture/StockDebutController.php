<?php

namespace App\Http\Controllers\Fourniture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fourniture\StockDebutRequest;
use App\Models\Kelasi;
use App\Models\Option;
use App\Models\StockDebut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class StockDebutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = Option::all();
        $classes = Kelasi::all();

        $stockDebuts = StockDebut::orderBy('created_at', 'desc')->paginate(4);
        return view('dappro.bur-fournitures.stockDebut.index',
            compact(
                'options',
                'classes',
                'stockDebuts'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = Option::all();
        $classes = Kelasi::all();

        return view('dappro.bur-fournitures.stockDebut.form',
            compact(
                'options',
                'classes'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockDebutRequest $request)
    {
        try {
            // Vérifier si l'article existe déjà
            $exists = StockDebut::where('option_id', $request->option_id)
                                 ->where('classe_id', $request->classe_id)
                                 ->exists();

            if ($exists) {
                return back()->withInput()->withErrors(['option_id' => 'Cet article existe déjà.']);
            }

            // Créer l'enregistrement
            $stockDebut = StockDebut::create($request->validated());

            return to_route('admin.stockDebut-Fourniture.index')
                ->with('success', 'Article enregistré avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['option_id' => 'Cet article existe déjà.']);
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
        $stockDebut = StockDebut::findOrFail($id);
        $options = Option::all();
        $classes = Kelasi::all();
        return view('dappro.bur-fournitures.stockDebut.edit',
            compact(
                'options',
                'classes',
                'stockDebut'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockDebutRequest $request, $id)
    {
        try {
            // Trouver l'enregistrement à mettre à jour
            $stockDebut = StockDebut::findOrFail($id);

            // Vérifier si un autre article avec les mêmes option_id et classe_id existe
            $exists = StockDebut::where('option_id', $request->option_id)
                                 ->where('classe_id', $request->classe_id)
                                 ->where('id', '!=', $stockDebut->id) // Exclure l'enregistrement actuel
                                 ->exists();

            if ($exists) {
                return back()->withInput()->withErrors(['option_id' => 'Cet article existe déjà.']);
            }

            // Mettre à jour l'enregistrement
            $stockDebut->update($request->validated());

            return to_route('admin.stockDebut-Fourniture.index')
                ->with('success', 'Article mis à jour avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifier si l'erreur est liée à une contrainte d'intégrité
            if ($e->getCode() == '23000') {
                // Rediriger avec un message d'erreur
                return back()->withInput()->withErrors(['option_id' => 'Cet article existe déjà.']);
            } else {
                // Traiter d'autres types d'exceptions
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockDebut $stockDebut)
    {
        try {
            // Supprimer l'enregistrement
            $stockDebut->delete();

            return to_route('admin.stockDebut-Fourniture.index')
                ->with('success', 'L\'article a été supprimé avec succès !');
        } catch (\Illuminate\Database\QueryException $e) {
            // Gérer les erreurs liées à la base de données
            return back()->withErrors(['message' => 'Erreur lors de la suppression de l\'article.']);
        }
    }

    public function showForm()
    {
        $kelasis = Kelasi::all();
        $options = option::all();

        // Sous-requête pour les quantités reçues
        $quantiteRecue = DB::table('entree_fournitures')
            ->select('option_id', 'classe_id', DB::raw('SUM(quantiteRecu) AS total_recue'))
            ->groupBy('option_id', 'classe_id');

        // Sous-requête pour les quantités livrées
        $qteLivree = DB::table('sortie_fournitures as sf')
            ->join('commande_ventes as cv', 'sf.commande_vente_id', '=', 'cv.id')
            ->select('cv.option_id', 'cv.classe_id', DB::raw('SUM(sf.qte_livree) AS total_livree'))
            ->groupBy('cv.option_id', 'cv.classe_id');

        // Requête principale avec pagination et tri
        $enregistrements = DB::table('stock_debuts AS sd')
            ->select('sd.option_id', 'sd.classe_id', 'sd.stock_debut',
                    DB::raw('COALESCE(qr.total_recue, 0) AS quantite_recue'),
                    DB::raw('COALESCE(ql.total_livree, 0) AS qte_livree'))
            ->leftJoin(DB::raw("({$quantiteRecue->toSql()}) as qr"),
                    function ($join) {
                        $join->on('sd.option_id', '=', 'qr.option_id')
                                ->on('sd.classe_id', '=', 'qr.classe_id');
                    })
            ->leftJoin(DB::raw("({$qteLivree->toSql()}) as ql"),
                    function ($join) {
                        $join->on('sd.option_id', '=', 'ql.option_id')
                                ->on('sd.classe_id', '=', 'ql.classe_id');
                    })
            ->mergeBindings($quantiteRecue) // Ajouter les bindings de la sous-requête
            ->mergeBindings($qteLivree) // Ajouter les bindings de la sous-requête
            ->groupBy('sd.option_id', 'sd.classe_id', 'sd.stock_debut', 'qr.total_recue', 'ql.total_livree') // Ajoutez les colonnes agrégées
            ->orderBy('sd.option_id', 'asc') // Tri par option_id en ordre croissant
            ->paginate(25); // Pagination à 25 éléments par page


        return view('dappro.bur-fournitures.Reporting.ficheStock.form',
            compact(
                'kelasis',
                'options',
                'enregistrements'
            )
        );
    }

    public function generateStockPDF(Request $request)
    {
        // Validation des champs requis
        $validatedData = $request->validate([
            'option_id' => 'required|exists:options,id',
            'classe_id' => 'required|exists:kelasis,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $classe_id = $validatedData['classe_id'];
        $option_id = $validatedData['option_id'];
        $date_debut = $validatedData['date_debut'];
        $date_fin = $validatedData['date_fin'];

        // Récupérer l'option et son niveau
        $option = DB::table('options')->where('id', $option_id)->first();
        $niveau = DB::table('niveaux')->where('id', $option->niveau_id)->first();
        $classe = DB::table('kelasis')->where('id', $classe_id)->first();

        // Récupérer le stock de début
        $stockDebut = DB::table('stock_debuts')
            ->where('classe_id', $classe_id)
            ->where('option_id', $option_id)
            ->first();

        // Récupérer les entrées
        $entrees = DB::table('entree_fournitures')
            ->where('classe_id', $classe_id)
            ->where('option_id', $option_id)
            ->whereBetween('date_entree', [$date_debut, $date_fin])
            ->orderBy('date_entree')
            ->get();

        // Récupérer les sorties
        $sorties = DB::table('sortie_fournitures')
            ->join('commande_ventes', 'sortie_fournitures.commande_vente_id', '=', 'commande_ventes.id')
            ->where('commande_ventes.classe_id', $classe_id)
            ->where('commande_ventes.option_id', $option_id)
            ->whereBetween('sortie_fournitures.date_sortie', [$date_debut, $date_fin])
            ->select('sortie_fournitures.date_sortie', 'sortie_fournitures.qte_livree')
            ->orderBy('date_sortie')
            ->get();

        // Passer les données à la vue PDF
        $pdf = Pdf::loadView('dappro.bur-fournitures.Reporting.ficheStock.fiche',
                    compact(
                        'entrees',
                        'stockDebut',
                        'sorties',
                        'date_debut',
                        'date_fin',
                        'option',
                        'niveau',
                        'classe'
                    )
                );

        // Configurer le format du papier et l'orientation
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('');
    }
}
