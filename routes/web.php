<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\Admin\
{
    ArticleController,
    BureauController,
    CatArticleController,
    CycleController,
    DirectionController,
    DivisionController,
    KelasiController,
    NiveauController,
    OptionController,
    PrixBulletinController,
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
    NotificationController,
    OutStockController,
    PDFController,
    ReportController,
};
use App\Http\Controllers\Distribution\TransferController;
use App\Http\Controllers\Fourniture\EntreeFournController;
use App\Http\Controllers\Fourniture\PanierSortieController;
use App\Http\Controllers\Fourniture\StockDebutController;
use App\Http\Controllers\Vente\ClientController;
use App\Http\Controllers\Vente\PanierController;
use App\Http\Controllers\Vente\PanierExtController;
use App\Http\Controllers\Vente\StkDebutController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AccueilController::class, 'accueil'])->name('page.accueil');
Route::post('/', [AccueilController::class, 'loginUser'])->name('page.accueil');
Route::get('dir-appro', [AccueilController::class, 'appro'])->name('dappro');
Route::get('/login/{direction_id}', [AccueilController::class, 'showLoginForm'])->name('login.show');
Route::post('/login/{direction_id}', [AccueilController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/bureaux/{direction_id}', [AccueilController::class, 'getBureaux'])->name('bureaux.get');
Route::get('/get-quantity/{num_cmd}', [TransferController::class, 'getQuantity']);


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

        //Bureau Fournitures PARTIE ADMIN
        Route::resource('Niveau', NiveauController::class)->except(['show']);
        Route::resource('Cycle', CycleController::class)->except(['show']);
        Route::resource('Kelasi', KelasiController::class)->except(['show']);
        Route::resource('Option', OptionController::class)->except(['show']);
        Route::resource('PrixBulletin', PrixBulletinController::class)->except(['show']);


        //Bureau Fournitures PARTIE USER
        Route::get('/fournisseur-fournitures', [FournController::class, 'showFournisseur'])->name('fourn-founisseurs');
        Route::get('/niveaux-scolaires', [NiveauController::class, 'showNiveau'])->name('niveauxScol');
        Route::get('/cycles-scolaires', [CycleController::class, 'showCycle'])->name('cycleScol');
        Route::get('/classes-bulletins', [KelasiController::class, 'showKelasi'])->name('kelasi');
        Route::get('/options-bulletins', [OptionController::class, 'showOption'])->name('optionBul');
        Route::resource('stockDebut-Fourniture', StockDebutController::class)->except(['show']);
        Route::resource('entree-Fourniture', EntreeFournController::class);
        Route::get('/notifications', [NotificationController::class, 'getNotifications']);
        Route::resource('sortie-Fourniture', PanierSortieController::class)->except(['index', 'destroy', 'show']);
        Route::post('/sortie-fourniture', [PanierSortieController::class, 'livraison'])->name('panier.sortie');
        Route::get('/inventaire', [PanierSortieController::class, 'inventaire'])->name('inventaire');
        Route::get('/situation-gen-humanite', [PanierSortieController::class, 'situationGenerale'])->name('situation.generale');


        //** Bureau Vente  **//
        Route::resource('client-Vente', ClientController::class);
        Route::resource('stockDebut-Vente', StkDebutController::class)->except(['show']);
        Route::resource('commande-Interne', PanierController::class)->except(['index']);
        Route::resource('commande-Externe', PanierExtController::class)->except(['index', 'show']);
        Route::post('/commande-externe-form', [PanierExtController::class, 'panierVide'])->name('commande.externe');

            //Reporting
            Route::post('/generate-pdf', [PanierController::class, 'show'])->name('generate.pdf');

        //**  Bureau Distribution  **//
        Route::resource('transfert-commande', TransferController::class)->except(['show', 'destroy']);
        Route::get('/liste-colisage', [PanierSortieController::class, 'indexColisage'])->name('colisage.liste');
        Route::get('/note-envoie', [PanierSortieController::class, 'indexNote'])->name('note.envoie');
            //Download liste de colisages et Note d'envoie
            Route::get('download-colis', [PanierSortieController::class, 'downloadColis'])->name('colisage.download');


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
    Route::get('/dashboard/vente', [DashController::class, 'indexVente'])->name('dashboard.bureau.vente');



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
