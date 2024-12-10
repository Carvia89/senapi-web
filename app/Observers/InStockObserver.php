<?php

namespace App\Observers;

use App\Models\GestionArticle;
use App\Models\InStock;
use App\Models\Inventaire;
use App\Models\OutStock;

class InStockObserver
{
    /**
     * Handle the InStock "created" event.
     */
    public function created(InStock $inStock)
    {
        $this->updateInventaire($inStock);
    }

    /**
     * Handle the InStock "updated" event.
     */
    public function updated(InStock $inStock)
    {
        $this->updateInventaire($inStock);
    }

    /**
     * Handle the InStock "deleted" event.
     */
    public function deleted(InStock $inStock)
    {
        $this->updateInventaire($inStock);
    }

    /**
     * Handle the InStock "restored" event.
     */
    public function restored(InStock $inStock)
    {
        //
    }

    /**
     * Handle the InStock "force deleted" event.
     */
    public function forceDeleted(InStock $inStock)
    {
        //
    }

    protected function updateInventaire(InStock $inStock)
    {
        // Récupérer les données nécessaires depuis la table "in_stocks"
        $articleName = $inStock->article_id;
        $uniteArt = $inStock->unite_id;
        $stockEntree = $this->getStockEntree($articleName);

        // Récupérer les données des tables "out_stocks" et "gestion_articles"
        $stockSortie = $this->getStockSortie($articleName);
        $stockInitial = $this->getStockInitial($articleName);

        // Vérifier si l'article existe déjà dans la table "inventaires"
        $inventaire = Inventaire::where('article_id', $articleName)->first();

        if ($inventaire) {
            // L'article existe déjà, mettre à jour les champs
            $inventaire->unite_id = $uniteArt;
            $inventaire->stock_initial = $stockInitial;
            $inventaire->stock_entree = $stockEntree;
            $inventaire->stock_sortie = $stockSortie;
            $inventaire->stock_actuel = $stockInitial + $stockEntree - $stockSortie;
            $inventaire->save();
        } else {
            // L'article n'existe pas encore, créer un nouvel enregistrement
            $inventaire = new Inventaire();
            $inventaire->article_id = $articleName;
            $inventaire->unite_id = $uniteArt;
            $inventaire->stock_initial = $stockInitial;
            $inventaire->stock_entree = $stockEntree;
            $inventaire->stock_sortie = $stockSortie;
            $inventaire->stock_actuel = $stockInitial + $stockEntree - $stockSortie;
            $inventaire->save();
        }
    }

    protected function getStockEntree($articleId)
    {
        return InStock::where('article_id', $articleId)->sum('quantite');
    }

    protected function getStockSortie($articleId)
    {
        return OutStock::where('article_id', $articleId)->sum('quantiteLivree');
    }

    protected function getStockInitial($articleId)
    {
        return GestionArticle::where('designation_id', $articleId)->sum('stock_initial');
    }
}
