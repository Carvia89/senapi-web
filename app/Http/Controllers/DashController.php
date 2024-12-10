<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Bureau;
use App\Models\CatgArticle;
use App\Models\Fournisseur;
use App\Models\InStock;
use App\Models\Inventaire;
use App\Models\OutStock;
use App\Models\UnitArticle;

class DashController extends Controller
{
    public function index()
    {
        return view('dashboard.dantic');
    }

    public function indexDappro()
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

        return view('dashboard.dappro',
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
    public function show($bureau_id)
    {
        // Récupérer le bureau pour afficher les informations nécessaires
        $bureau = Bureau::findOrFail($bureau_id);

        // Retourner la vue du tableau de bord avec les informations du bureau
        return view('dashboard.bureau', compact('bureau'));
    }
*/
    public function indexFourniture()
    {
        return view('dashboard.fourniture');
    }

}
