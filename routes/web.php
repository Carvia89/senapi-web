<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\Admin\
{
    ArticleController,
    BureauController,
    CatArticleController,
    DirectionController,
    DivisionController,
    UArticleController,
    UserController,
};
use App\Http\Controllers\
{
    AuthController,
    DashController,
    FournController,
    gestionArticleController,
    GetElementController,
    globalReportController,
    InStockController,
    OutStockController,
    PDFController,
    ReportController,
};
use Illuminate\Support\Facades\Route;


Route::get('/', [AccueilController::class, 'accueil'])->name('page.accueil');
Route::post('/', [AccueilController::class, 'loginUser'])->name('page.accueil');
Route::get('dir-appro', [AccueilController::class, 'appro'])->name('dappro');
Route::get('/login/{direction_id}', [AccueilController::class, 'showLoginForm'])->name('login.show');
Route::post('/login/{direction_id}', [AccueilController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/bureaux/{direction_id}', [AccueilController::class, 'getBureaux'])->name('bureaux.get');

Route::middleware(['auth'])->group(function() {
// Route pour la DAPPRO
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('Utilisateur', UserController::class)->except(['show']);
        Route::resource('uniteArticle', UArticleController::class)->except(['show']);
        Route::resource('categorieArticle', CatArticleController::class)->except(['show']);
        Route::resource('Article', ArticleController::class)->except(['show']);
        Route::resource('fournisseur', FournController::class)->except(['show']);
        Route::resource('direction', DirectionController::class)->except(['show']);
        Route::resource('bureau', BureauController::class)->except(['show']);
        Route::resource('division', DivisionController::class)->except(['show']);
    });

    //Tableau de Bord pour la DANTIC
    Route::get('/dashboard/dantic', [DashController::class, 'index'])->name('dashboard.direction1');
    //Tableau de Bord pour la DIR-GENERALE
    Route::get('/dashboard/dir-générale', [DashController::class, 'index2'])->name('dashboard.direction2');
    //Tableau de Bord pour la DAPPRO
    Route::get('/dashboard/dappro', [DashController::class, 'indexDappro'])->name('dashboard.direction3');
    //Tableau de Bord pour la DEP
    Route::get('/dashboard/dep', [DashController::class, 'index4'])->name('dashboard.direction4');
    //Tableau de Bord pour la DAF
    Route::get('/dashboard/daf', [DashController::class, 'index5'])->name('dashboard.direction5');
    //Tableau de Bord pour la PROD
    Route::get('/dashboard/production', [DashController::class, 'indexProd'])->name('dashboard.direction6');
    //Tableau de Bord pour la DRH
    Route::get('/dashboard/drh', [DashController::class, 'indexDRH'])->name('dashboard.direction7');


    //Les routes pour les tableaux de bord suivant les bureaux
    Route::get('/dashboard/fourniture', [DashController::class, 'indexFourniture'])->name('dashboard.bureau');

/*
    Route::get('dashboard', [DashController::class, 'index'])->name('dashboard');
*/

    Route::prefix('stock')->name('mouvement.')->group(function () {
        Route::resource('gestion', gestionArticleController::class)->except(['show']);
        Route::resource('EntreeStock', InStockController::class);
        Route::resource('SortieStock', OutStockController::class);
        Route::resource('reporting', ReportController::class);

        //Route pour afficher le stock dispo de l'article sélectionné
        //Route::post('stock/SortieStock/get-stock-disponible', [OutStockController::class, 'getStockDispo'])->name('outstock.get-stock-disponible');
    });

    Route::get('rapport-global_stock', [PDFController::class, 'rapGlobal'])->name('rapportGlobal');
    Route::get('rapport-entree_stock', [PDFController::class, 'rapEntree'])->name('rapportEntree');
    Route::get('rapport-sortie_stock', [PDFController::class, 'rapSortie'])->name('rapportSortie');
    Route::get('/ficheStock', [PDFController::class, 'fiche'])->name('ficheStockPDF');

    Route::get('prixArticle', [GetElementController::class, 'getPrice'])->name('getPrice');
    Route::get('ficheStocks', [GetElementController::class, 'fiche'])->name('ficheStock');
});
