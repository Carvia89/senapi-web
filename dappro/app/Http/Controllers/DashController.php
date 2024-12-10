<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CatgArticle;
use App\Models\Fournisseur;
use App\Models\InStock;
use App\Models\Inventaire;
use App\Models\OutStock;
use App\Models\UnitArticle;
use Illuminate\Http\Request;

class DashController extends Controller
{
    public function index()
    {
        //$fournituresData = $this->getFournituresData();
        //$consommableInformatiqueData = $this->getConsommableInformatiqueData();
        //$carburantData = $this->getCarburantData();

        $entreestocks = InStock::orderBy('created_at', 'desc')->paginate(5);

        //Récupérer tout les items
        $articles = Article::all();
        $unites = UnitArticle::all();
        $fournisseurs = Fournisseur::all();

        //Compter le nombre
        $allArticles = Article::count();
        $allCategories = CatgArticle::count();
        $allFournisseurs = Fournisseur::count();

        // Récupérer l'article "Duplicateur A4"
        $article = Article::where('id', '1')->first();

        // Récupérer le solde de l'article
        $solde = isset($article->inventaire) ? $article->inventaire->stock_actuel : 0;

        return view('dashboard',
            compact(
                'allArticles',
                'allCategories',
                'allFournisseurs',
                'solde',
                'entreestocks'
            )
        );

    }
/*
        private function getFournituresData()
        {
            $fournitureData = InStock::selectRaw('DATE_FORMAT(created_at, "%b") as month, SUM(quantite) as total')
                                ->groupByRaw('DATE_FORMAT(created_at, "%b")')
                                ->get()
                                ->toArray();

            return $fournitureData;
        }
*/
/*
        private function getConsommableInformatiqueData()
        {
            $consommableInformatiqueData = ConsommableInformatique::selectRaw('DATE_FORMAT(created_at, "%b") as month, SUM(montant) as total')
                                            ->groupByRaw('DATE_FORMAT(created_at, "%b")')
                                            ->get()
                                            ->toArray();

            return $consommableInformatiqueData;
        }

        private function getCarburantData()
        {
            $carburantData = Carburant::selectRaw('DATE_FORMAT(created_at, "%b") as month, SUM(montant) as total')
                            ->groupByRaw('DATE_FORMAT(created_at, "%b")')
                            ->get()
                            ->toArray();

            return $carburantData;
        }
*/
}

