<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutStockRequest;
use App\Models\Article;
use App\Models\Bureau;
use App\Models\OutStock;
use Illuminate\Http\Request;

class OutStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sortiestocks = OutStock::orderBy('created_at', 'desc')->paginate(25);
        $articles = Article::all();
        $bureaus = Bureau::all();

        return view('dappro.gestions.sorties.index',
            compact(
                'sortiestocks',
                'articles',
                'bureaus'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bureaus = Bureau::all();
        $articles = Article::with('gestionArticle', 'inStocks')->get();
        return view('dappro.gestions.sorties.form',
            compact(
                'bureaus',
                'articles'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'bureau_id' => 'required|exists:bureaus,id',
            'quantiteLivree' => 'required|numeric|min:1',
            'reception' => 'required|min:1',
            'date_sortie' => 'required|date',
        ]);

        $article = Article::findOrFail($validatedData['article_id']);
        $stockDisponible = $this->getStockDisponible($article);

        if ($validatedData['quantiteLivree'] > $stockDisponible) {
            return back()->withErrors(['quantiteLivree' => 'La quantité demandée dépasse le stock disponible.']);
        }

        // Enregistrer la sortie d'article
        $mouvement = new OutStock();
        $mouvement->article_id = $validatedData['article_id'];
        $mouvement->bureau_id = $validatedData['bureau_id'];
        $mouvement->quantiteLivree = $validatedData['quantiteLivree'];
        $mouvement->date_sortie = $validatedData['date_sortie'];
        $mouvement->reception = $validatedData['reception'];
        $mouvement->save();

        // Ordonner les enregistrements par date_sortie de la plus ancienne à la plus récente
        $mouvement->orderBy('date_sortie', 'desc')->get();

        return to_route('mouvement.SortieStock.index')
                ->with('success', 'La sortie a été effectuée avec succès.');
    }

    private function getStockDisponible(Article $article)
    {
        if ($article->gestionArticle) {
            $stockInitial = $article->gestionArticle->stock_initial;
            $stockEntrees = $article->inStocks()->sum('quantite');
            $stockSorties = $article->outStocks()->sum('quantiteLivree');
            $stockMinimal = $article->gestionArticle->stock_minimal;

            $stockDisponible = $stockInitial + $stockEntrees - $stockSorties - $stockMinimal;
            return max(0, $stockDisponible);
        } else {
            // Gérer le cas où $article->gestionArticle est null
            return redirect()->back()->with('error_msg', 'Stock non disponible');
            /*
            return [
                'stockDisponible' => 0,
                'errorMessage' => 'Le solde du stock est null.'
            ];
            */
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
        $sortiestock = OutStock::findOrFail($id);
        $bureaus = Bureau::all();
        $articles = Article::all();
        return view('dappro.gestions.sorties.edit',
            compact(
                'sortiestock',
                'bureaus',
                'articles'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Valider les données entrantes
        $validatedData = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'bureau_id' => 'required|exists:bureaus,id',
            'quantiteLivree' => 'required|numeric|min:1',
            'reception' => 'required|min:1',
            'date_sortie' => 'required|date',
        ]);

        // Trouver le mouvement existant par son ID
        $mouvement = OutStock::findOrFail($id);

        // Vérifier le stock disponible pour l'article mis à jour
        $article = Article::findOrFail($validatedData['article_id']);
        $stockDisponible = $this->getStockDisponible($article);

        // Vérifier si la nouvelle quantité livrée est supérieure au stock disponible
        if ($validatedData['quantiteLivree'] > $stockDisponible + $mouvement->quantiteLivree) {
            return back()->withErrors(['quantiteLivree' => 'La quantité demandée dépasse le stock disponible.']);
        }

        // Mettre à jour les champs du mouvement
        $mouvement->article_id = $validatedData['article_id'];
        $mouvement->bureau_id = $validatedData['bureau_id'];
        $mouvement->quantiteLivree = $validatedData['quantiteLivree'];
        $mouvement->date_sortie = $validatedData['date_sortie'];
        $mouvement->reception = $validatedData['reception'];
        $mouvement->save();

        // Ordonner les enregistrements par date_sortie de la plus ancienne à la plus récente
        $mouvement->orderBy('date_sortie', 'desc')->get();

        return to_route('mouvement.SortieStock.index')
                ->with('success', 'La sortie a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Trouver le mouvement existant par son ID
        $mouvement = OutStock::findOrFail($id);

        // Récupérer l'article associé au mouvement
        $article = Article::findOrFail($mouvement->article_id);


        // Supprimer le mouvement
        $mouvement->delete();

        return to_route('mouvement.SortieStock.index')
                ->with('success', 'La sortie a été supprimée et le stock a été mis à jour avec succès.');
    }
}
