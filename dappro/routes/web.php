<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('handleLogin', [AuthController::class, 'handleLogin'])->name('handleLogin');

Route::middleware(['auth'])->group(function() {

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

    Route::get('dashboard', [DashController::class, 'index'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

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
