<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Bureau;
use App\Models\CatgArticle;
use App\Models\ClientVente;
use App\Models\CommandeVente;
use App\Models\Direction;
use App\Models\Division;
use App\Models\Fournisseur;
use App\Models\InStock;
use App\Models\Inventaire;
use App\Models\Kelasi;
use App\Models\Niveau;
use App\Models\Option;
use App\Models\OutStock;
use App\Models\UnitArticle;
use App\Models\User;

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
        $directionsCount = Direction::count();          //Compter le nombre de direction
        $usersCount = User::count();                    //Compter le nombre d'utlisateurs
        $divisionsCount = Division::count();            //Compter le nombre de divisions
        $bureauxCount = Bureau::count();                //Compter le nombre de bureaux
        $niveauxCount = Niveau::count();                //Compter le nombre de niveaux
        $kelasiCount = Kelasi::count();                 //Compter le nombre de classes
        $fournisseurCount = Fournisseur::count();       //Compter le nombre de fournisseurs
        $optionCount = Option::count();                 //Compter le nombre d'options

        return view('dashboard.fourniture',
            compact(
                'directionsCount',
                'usersCount',
                'divisionsCount',
                'bureauxCount',
                'niveauxCount',
                'kelasiCount',
                'fournisseurCount',
                'optionCount'
            )
        );
    }

    public function indexVente()
    {
        $directionsCount = Direction::count();          //Compter le nombre de direction
        $usersCount = User::count();                    //Compter le nombre d'utlisateurs
        $divisionsCount = Division::count();            //Compter le nombre de divisions
        $bureauxCount = Bureau::count();                //Compter le nombre de bureaux
        $niveauxCount = Niveau::count();                //Compter le nombre de niveaux
        $kelasiCount = Kelasi::count();                 //Compter le nombre de classes
        $fournisseurCount = Fournisseur::count();       //Compter le nombre de fournisseurs
        $optionCount = Option::count();                 //Compter le nombre d'options
        $clientCount = ClientVente::count();
        // Compter le nombre de commandes distinctes avec category_cmd = "Interne"
        $interneCount = CommandeVente::where('category_cmd', 'Interne')
                                    ->distinct('num_cmd') // Compter uniquement les commandes distinctes
                                    ->count('num_cmd'); // Compter les num_cmd distincts

        // Compter le nombre de commandes distinctes avec category_cmd = "Externe"
        $externeCount = CommandeVente::where('category_cmd', 'Externe')
                                    ->distinct('num_cmd') // Compter uniquement les commandes distinctes
                                    ->count('num_cmd'); // Compter les num_cmd distincts

        return view('dashboard.vente',
            compact(
                'directionsCount',
                'usersCount',
                'divisionsCount',
                'bureauxCount',
                'niveauxCount',
                'kelasiCount',
                'fournisseurCount',
                'optionCount',
                'clientCount',
                'interneCount',
                'externeCount'
            )
        );
    }


}
