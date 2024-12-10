<?php

namespace App\Observers;

use App\Models\GestionArticle;
use App\Models\InStock;
use App\Models\Inventaire;
use App\Models\OutStock;

class GestionArticleObserver
{
    /**
     * Handle the GestionArticle "created" event.
     */
    public function created(GestionArticle $gestionArticle)
    {
        $this->updateInventaire($gestionArticle);
    }

    /**
     * Handle the GestionArticle "updated" event.
     */
    public function updated(GestionArticle $gestionArticle)
    {
        $this->updateInventaire($gestionArticle);
    }

    /**
     * Handle the GestionArticle "deleted" event.
     */
    public function deleted(GestionArticle $gestionArticle)
    {
        $this->updateInventaire($gestionArticle);
    }

    /**
     * Handle the GestionArticle "restored" event.
     */
    public function restored(GestionArticle $gestionArticle): void
    {
        //
    }

    /**
     * Handle the GestionArticle "force deleted" event.
     */
    public function forceDeleted(GestionArticle $gestionArticle): void
    {
        //
    }

    protected function updateInventaire(GestionArticle $gestionArticle)
    {
        // Récupérer les données nécessaires depuis la table "gestion_articles"
        $articleName = $gestionArticle->designation_id;
        $uniteArt = $gestionArticle->unite_id;
        $stockInitial = $gestionArticle->stock_initial;

        // Récupérer les données des tables "in_stocks" et "out_stocks"
        $stockEntree = $this->getStockEntree($articleName);
        $stockSortie = $this->getStockSortie($articleName);

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
}
