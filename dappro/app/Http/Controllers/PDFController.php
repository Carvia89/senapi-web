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

class PDFController extends Controller
{
    public function rapGlobal()
    {
        $inventaires = Inventaire::with(['article', 'unity'])->get();

        $pdf = Pdf::loadView('rapGlob', compact('inventaires'))->setPaper('a4', 'landscape');
        return $pdf->stream();
        /*
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1> Hello World </h1>');
        return $pdf->stream();
*/

        /*
        $inventaires = $this->getInventaireData(); // Récupérez les données des inventaires à partir de votre script Laravel

        $pdf = Pdf::loadView('pdf.rapport_global', compact('inventaires'));
        return $pdf->download('rapport_global.pdf');
        */
    }

    public function rapEntree()
    {
        $entreestocks = InStock::with(['article', 'unity', 'fournisseurs'])->get();

        $pdf = Pdf::loadView('rapEntree', compact('entreestocks'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function rapSortie()
    {
        $sortiestocks = OutStock::with(['bureau', 'article'])->get();

        $pdf = Pdf::loadView('rapSortie', compact('sortiestocks'))->setPaper('a4', 'portrait');
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

        return view('ficheStock', compact('data', 'article'));
    }

    private function getFicheStockData($articleId, $dateDebut, $dateFin)
    {


              $stockInitial = GestionArticle::where('designation_id', $articleId)->first()->stock_initial;

              // Récupérer les entrées et sorties
              $inStocks = InStock::where('article_id', $articleId)
                  ->whereBetween('date_entree', [$dateDebut, $dateFin])
                  ->orderBy('date_entree')
                  ->get();

              $outStocks = OutStock::where('article_id', $articleId)
                  ->whereBetween('date_sortie', [$dateDebut, $dateFin])
                  ->orderBy('date_sortie')
                  ->get();

              $data = [];
              $stockTotal = $stockInitial;
              $previousSolde = $stockInitial;

              // Fusionner les entrées et les sorties dans un seul tableau ordonné par date
              $allTransactions = collect([$inStocks, $outStocks])
                  ->collapse()
                  ->sortBy(function ($transaction) {
                      return $transaction->date_entree ?? $transaction->date_sortie;
                  });

              foreach ($allTransactions as $transaction) {
                  if ($transaction instanceof InStock) {
                      $row = [
                          'dateEntree' => $transaction->date_entree,
                          'quantite' => $transaction->quantite,
                          'StockInitial' => $stockTotal,
                          'StockTotal' => $stockTotal + $transaction->quantite,
                          'dateSortie' => null,
                          'quantiteLivree' => 0,
                          'Solde' => $stockTotal + $transaction->quantite,
                      ];

                      $data[] = $row;
                      $stockTotal += $transaction->quantite;
                  } elseif ($transaction instanceof OutStock) {
                      $row = [
                          'dateEntree' => null,
                          'quantite' => 0,
                          'StockInitial' => $stockTotal,
                          'StockTotal' => $stockTotal - $transaction->quantiteLivree,
                          'dateSortie' => $transaction->date_sortie,
                          'quantiteLivree' => $transaction->quantiteLivree,
                          'Solde' => $previousSolde - $transaction->quantiteLivree,
                      ];

                      $data[] = $row;
                      $stockTotal -= $transaction->quantiteLivree;
                  }

                  $previousSolde = $row['Solde'];
              }

        return $data;
    }


}
