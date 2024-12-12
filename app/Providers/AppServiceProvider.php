<?php

namespace App\Providers;

use App\Models\GestionArticle;
use App\Models\InStock;
use App\Models\OutStock;
use App\Observers\GestionArticleObserver;
use App\Observers\InStockObserver;
use App\Observers\OutStockObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Enregistrer les Observers
        GestionArticle::observe(GestionArticleObserver::class);
        InStock::observe(InStockObserver::class);
        OutStock::observe(OutStockObserver::class);

        //Gestion de la pagination utilisant Bootstrap
        Paginator::useBootstrapFour();
    }
}
