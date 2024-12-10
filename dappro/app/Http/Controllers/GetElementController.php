<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\GestionArticle;
use App\Models\InStock;
use App\Models\OutStock;
use Illuminate\Http\Request;

class GetElementController extends Controller
{
    public function getPrice(Request $request)
    {
        // Récupérer la valeur du paramètre 'numArt' dans la requête
        $numArt = $request->input('numArt');

        // Vérifier que le paramètre 'numArt' est bien transmis
        if (!$numArt) {
            return response()->json(['error' => 'Le paramètre "numArt" est requis.'], 400);
        }

        // Récupérer l'article correspondant à la désignation '$numArt' et extraire le prix
        $article = Article::where('designation', $numArt)->first();

        if ($article) {
            $prix = $article->price;
            return response()->json(['prix' => $prix]);
        } else {
            return response()->json(['error' => 'Aucun article trouvé avec cette désignation.'], 404);
        }
    }

    public function fiche(Request $request)
    {
        // Récupérer l'ID et les dates de l'article sélectionné
        $articleId = $request->input('article_id');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');

        // Récupérer l'objet Article correspondant à l'ID
        $article = Article::findOrFail($articleId);

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

        return view('gestions.reporting.fichestock.index', compact('data', 'article'));
    }

}
