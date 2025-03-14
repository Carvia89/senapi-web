<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bureau;
use App\Models\Fournisseur;
use App\Models\GestionArticle;
use App\Models\InStock;
use App\Models\Inventaire;
use App\Models\OutStock;
use App\Models\UnitArticle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;


class PDFController extends Controller
{
    public function rapGlobal()
    {
        $inventaires = Inventaire::with(['article', 'unity'])
            ->join('articles', 'inventaires.article_id', '=', 'articles.id') // Joindre la table des articles
            ->orderBy('articles.designation') // Trier par le champ "designation" de la table des articles
            ->select('inventaires.*') // Sélectionner uniquement les colonnes des inventaires
            ->get();

        $pdf = Pdf::loadView('dappro.rapGlob', compact('inventaires'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function rapEntree()
    {
        $entreestocks = InStock::with(['article', 'unity', 'fournisseurs'])
            ->orderBy('date_entree')
            ->get();

        $pdf = Pdf::loadView('dappro.rapEntree', compact('entreestocks'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function rapSortie()
    {
        // Récupérer les sorties triées par date_sortie
        $sortiestocks = OutStock::with(['bureau', 'article'])
            ->orderBy('date_sortie') // Tri par date_sortie
            ->get();

        // Charger la vue PDF avec les données triées
        $pdf = Pdf::loadView('dappro.rapSortie', compact('sortiestocks'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream();
    }


    public function fiche(Request $request)
    {
        // Récupérer les données nécessaires pour la vue
        $articleId = $request->input('article_id');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $article = Article::findOrFail($articleId);
        $data = $this->getFicheStockData($articleId, $dateDebut, $dateFin);

        return view('dappro.ficheStock', compact('data', 'article'));
    }

    public function generatePdf(Request $request)
    {
        // Validation des champs requis
        $validatedData = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $article_id = $validatedData['article_id'];
        $date_debut = $validatedData['date_debut'];
        $date_fin = $validatedData['date_fin'];

        // Récupérer l'ID de l'article
        $article = DB::table('articles')->where('id', $article_id)->first();

        // Vérifier si l'article existe
        if (!$article) {
            abort(404, 'Article non trouvé');
        }

        // Récupérer le stock de début
        $stockDebut = DB::table('gestion_articles')
            ->where('designation_id', $article_id)
            ->value('stock_initial');

        // Récupérer les entrées
        $entrees = DB::table('in_stocks')
            ->where('article_id', $article_id)
            ->whereBetween('date_entree', [$date_debut, $date_fin])
            ->orderBy('date_entree')
            ->get();

        // Récupérer les sorties
        $sorties = DB::table('out_stocks')
            ->where('article_id', $article_id)
            ->whereBetween('date_sortie', [$date_debut, $date_fin])
            ->orderBy('date_sortie')
            ->get();

        // Passer les données à la vue PDF
        $pdf = Pdf::loadView('dappro.ficheStkPdf',
                    compact(
                        'entrees',
                        'stockDebut',
                        'sorties',
                        'date_debut',
                        'date_fin',
                        'article_id'
                    )
                );

        // Configurer le format du papier et l'orientation
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('');
    }

}
