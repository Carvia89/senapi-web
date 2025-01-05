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
use App\Models\EntreeFourniture;
use App\Models\Fournisseur;
use App\Models\InStock;
use App\Models\Inventaire;
use App\Models\Kelasi;
use App\Models\Niveau;
use App\Models\Option;
use App\Models\OutStock;
use App\Models\SortieFourniture;
use App\Models\StockDebut;
use App\Models\UnitArticle;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        // Calculer le solde actuel des bulletins
        $stockDebutTotal = StockDebut::sum('stock_debut');
        $quantiteRecuTotal = EntreeFourniture::sum('quantiteRecu');
        $qteLivreeTotal = SortieFourniture::sum('qte_livree');
        $totalGeneral = $stockDebutTotal + $quantiteRecuTotal + $qteLivreeTotal;
        $soldeActuel = $stockDebutTotal + $quantiteRecuTotal - $qteLivreeTotal;

        // Calculer le pourcentage de bulletins livrés
        $pourcentageLivres = 0; // Valeur par défaut
        if ($totalGeneral > 0) {
            $pourcentageLivres = ($qteLivreeTotal / $totalGeneral) * 100;
        }

        // Calculer le pourcentage de bulletins reçus
        $pourcentageRecu = 0; // Valeur par défaut
        if ($totalGeneral > 0) {
            $pourcentageRecu = ($quantiteRecuTotal / $totalGeneral) * 100;
        }

        //** CALCUL DE SOLDE SELON LES NIVEAUX */

        // Initialiser les variables pour chaque niveau
        $niveaux = [
            5 => ['nom' => 'Ensg. de Base', 'couleur' => 'bg-c-green'],
            3 => ['nom' => 'Niveau Moyen', 'couleur' => 'bg-c-blue'],
            4 => ['nom' => 'Terminal', 'couleur' => 'bg-c-red'],
            6 => ['nom' => 'Humanités', 'couleur' => 'bg-c-yellow'],
            /*
            1 => ['nom' => 'Autre Niveau 1', 'couleur' => 'bg-c-purple'],
            2 => ['nom' => 'Autre Niveau 2', 'couleur' => 'bg-c-orange'],
            */
        ];

        $resultats = []; // Tableau pour stocker les résultats

        foreach ($niveaux as $niveauId => $info) {
            // Calculer le solde actuel des bulletins pour chaque niveau
            $stockDebutTotalNiv = StockDebut::whereHas('methodOption', function($query) use ($niveauId) {
                $query->where('niveau_id', $niveauId);
            })->sum('stock_debut');

            $quantiteRecuTotalNiv = EntreeFourniture::whereHas('methodOption', function($query) use ($niveauId) {
                $query->where('niveau_id', $niveauId);
            })->sum('quantiteRecu');

            // Calculer la quantité livrée via commande_ventes
            $qteLivreeTotalNiv = SortieFourniture::whereHas('commandeVente.methodOption', function($query) use ($niveauId) {
                $query->where('niveau_id', $niveauId);
            })->sum('qte_livree');

            $soldeActuelNiv = $stockDebutTotalNiv + $quantiteRecuTotalNiv - $qteLivreeTotalNiv;

            // Calculer le pourcentage de solde de bulletins pour chaque niveau
            $pourcentageNiv = 0; // Valeur par défaut
            if ($soldeActuelNiv > 0) {
                $pourcentageNiv = ($soldeActuelNiv / $soldeActuel) * 100;
            }

            // Stocker les résultats pour chaque niveau
            $resultats[$niveauId] = [
                'solde' => $soldeActuelNiv,
                'pourcentage' => $pourcentageNiv,
                'nom' => $info['nom'],
                'couleur' => $info['couleur'],
            ];
        }

        //** CALCUL DE LA SITUATION ACTUELLE  */
        // Sous-requête pour les quantités reçues
        $options = Option::all();
        $kelasis = Kelasi::all();

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
            ->paginate(4); // Pagination à 25 éléments par page


        return view('dashboard.fourniture',
            compact(
                'directionsCount',
                'usersCount',
                'divisionsCount',
                'bureauxCount',
                'niveauxCount',
                'kelasiCount',
                'fournisseurCount',
                'optionCount',
                'soldeActuel',
                'qteLivreeTotal',
                'pourcentageLivres',
                'quantiteRecuTotal',
                'pourcentageRecu',
                'resultats',
                'enregistrements',
                'options',
                'kelasis'
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
