<?php

namespace App\Observers;

use App\Models\GestionArticle;
use App\Models\InStock;
use App\Models\Inventaire;
use App\Models\OutStock;

class OutStockObserver
{
    /**
     * Handle the OutStock "created" event.
     */
    public function created(OutStock $outStock): void
    {
        $this->updateInventaire($outStock);
    }

    /**
     * Handle the OutStock "updated" event.
     */
    public function updated(OutStock $outStock): void
    {
        $this->updateInventaire($outStock);
    }

    /**
     * Handle the OutStock "deleted" event.
     */
    public function deleted(OutStock $outStock): void
    {
        $this->updateInventaire($outStock);
    }

    /**
     * Handle the OutStock "restored" event.
     */
    public function restored(OutStock $outStock): void
    {
        $this->updateInventaire($outStock);
    }

    /**
     * Handle the OutStock "force deleted" event.
     */
    public function forceDeleted(OutStock $outStock): void
    {
        $this->updateInventaire($outStock);
    }

    protected function updateInventaire(OutStock $outStock)
    {
        // Récupérer les données nécessaires depuis la table "out_stocks"
        $articleName = $outStock->article_id;
        $stockSortie = $this->getStockSortie($articleName);

        // Récupérer les données des tables "in_stocks" et "gestion_articles"
        $stockEntree = $this->getStockEntree($articleName);
        $stockInitial = $this->getStockInitial($articleName);

        // Vérifier si l'article existe déjà dans la table "inventaires"
        $inventaire = Inventaire::where('article_id', $articleName)->first();

        if ($inventaire) {
            // L'article existe déjà, mettre à jour les champs
            $inventaire->stock_initial = $stockInitial;
            $inventaire->stock_entree = $stockEntree;
            $inventaire->stock_sortie = $stockSortie;
            $inventaire->stock_actuel = $stockInitial + $stockEntree - $stockSortie;
            $inventaire->save();
        } else {
            // L'article n'existe pas encore, créer un nouvel enregistrement
            $inventaire = new Inventaire();
            $inventaire->article_id = $articleName;
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
