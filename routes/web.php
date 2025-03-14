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
use App\Http\Controllers\Caisse\
{
    DepenseBonController,
    DepenseSansBonController,
    MotCleController,
    RecetteCaisseController,
    ReportAnnuelController,
    ReportingController
};
use App\Http\Controllers\Engagement\
{
    BanqueController,
    BeneficiaireController,
    BonCompletController,
    BonPartielController,
    DashEliqController,
    DossierController,
    EtatBesoinController,
    ImputationController,
};
use App\Http\Controllers\Vente\
{
    ApproController,
    CaissierVenteController,
    ClientController,
    LivraisonVenteController,
    PanierController,
    PanierExtController,
    StkDebutController
};
use App\Http\Controllers\Fourniture\
{
    EntreeFournController,
    PanierSortieController,
    StockDebutController
};
use App\Http\Controllers\Distribution\TransferController;
use App\Http\Controllers\DPSB\ServiceBudgetController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AccueilController::class, 'accueil'])->name('page.accueil');
Route::post('/', [AccueilController::class, 'loginUser'])->name('page.accueil');
Route::get('dir-appro', [AccueilController::class, 'appro'])->name('dappro');
Route::get('/login/{direction_id}', [AccueilController::class, 'showLoginForm'])->name('login.show');
Route::post('/login/{direction_id}', [AccueilController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/bureaux/{direction_id}', [AccueilController::class, 'getBureaux'])->name('bureaux.get');
Route::get('/get-quantity/{num_cmd}', [TransferController::class, 'getQuantity']);
Route::get('/get-command-details/{num_cmd}', [LivraisonVenteController::class, 'getCommandDetails']);
Route::get('/get-details-command/{num_cmd}', [CaissierVenteController::class, 'getDetailsCommand']);
Route::get('/imputation/nature/{id}', [ImputationController::class, 'getNature'])->name('imputation.nature');
Route::get('/bons-de-depenses/{id}', [DepenseBonController::class, 'getBonDepense'])->name('bons-de-depenses.show');
Route::get('/dashboard-caisse', [DashEliqController::class, 'getDashboardData']);
Route::get('/admin/mot-cle-imputation/filter', [MotCleController::class, 'filterReferences']);
Route::get('/stock-disponible/{id}', [ArticleController::class, 'getStockDisponible'])->name('stock.disponible');


//Route login DG
Route::get('/connexion-direction-generale', [AuthController::class, 'loginDG'])->name('login.DG');
Route::post('/connexion-dg', [AuthController::class, 'handleLoginDG'])->name('DG.login');

Route::middleware(['auth'])->group(function() {
    Route::prefix('admin')->name('admin.')->group(function () {
        //Bureau Matières Premières Admin
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
            //Reporting
            Route::get('/situation-gen-humanite', [PanierSortieController::class, 'situationGenerale'])->name('situation.generale');
            Route::get('/sit-gen-bul-scol', [PanierSortieController::class, 'situationGeneraleBulScol'])->name('sit.gen.bulScol');
            Route::get('/fiche', [StockDebutController::class, 'showForm'])->name('form.fiche.stock');
            route::get('/fiche-de-stock', [StockDebutController::class, 'generateStockPDF'])->name('print.fiche');

        //** Bureau Vente  **//
        Route::resource('client-Vente', ClientController::class);
        Route::resource('stockDebut-Vente', StkDebutController::class)->except(['show']);
        Route::resource('commande-Interne', PanierController::class)->except(['index']);
        Route::resource('commande-Externe', PanierExtController::class)->except(['index', 'show']);
        Route::post('/commande-externe-form', [PanierExtController::class, 'panierVide'])->name('commande.externe');
        Route::resource('appro-Vente', ApproController::class)->except(['show', 'destroy', 'update', 'edit']);
        Route::post('/valider-appro-vente', [ApproController::class, 'updateEtat'])->name('valide.appro.vente');
        Route::resource('livraison-Vente', LivraisonVenteController::class)->except(['destroy', 'show']);
        Route::post('/livraison-vente', [LivraisonVenteController::class, 'livraison'])->name('valide.livraison.vente');
            //Reporting
            Route::post('/generate-pdf', [PanierController::class, 'show'])->name('generate.pdf');
            Route::get('/fiche-form-vente', [StkDebutController::class, 'showForm'])->name('form.ficheStk.vente');
            route::get('/fiche-de-stock-vente', [StkDebutController::class, 'generateStockPDF'])->name('print.ficheStk.vente');

            //Caissier Vente
            Route::resource('caisse-vente-Bulletins', CaissierVenteController::class)->except(['index', 'show', 'destroy']);


        //**  Bureau Distribution  **//
        Route::resource('transfert-commande', TransferController::class)->except(['show', 'destroy']);
        Route::get('/liste-colisage', [TransferController::class, 'indexColisage'])->name('colisage.liste');
        Route::get('/note-envoie', [TransferController::class, 'indexNote'])->name('note.envoie');
            //Download liste de colisages et Note d'envoie
            Route::get('download-colis', [TransferController::class, 'downloadColis'])->name('colisage.download');
            Route::get('download-note', [TransferController::class, 'downloadNote'])->name('note.download');



        //**  Bureau ENGAGEMENT ET LIQUIDATION (Partie USER) */
        Route::resource('banque-senapi', BanqueController::class)->except(['show']);
        Route::resource('beneficiaire', BeneficiaireController::class)->except(['show']);
        Route::resource('dossier', DossierController::class)->except(['show', 'index']);
        Route::resource('numérisation-etat-de-besoin', EtatBesoinController::class);
        Route::resource('bon-de-dépense-complète', BonCompletController::class);
            //Télécharger EB dans Bon de Dépense
            Route::get('/etat-besoin/{id}', [BonCompletController::class, 'downloadEB'])->name('bdp.telecharger-etat-besoin');
        Route::resource('bon-de-dépense-partielle', BonPartielController::class);

        //** Bureau BUDGET PROGRAMME */
        Route::resource('imputation', ImputationController::class)->except(['show']);
        Route::resource('imputation-bon-depense', ServiceBudgetController::class)->except(['show', 'create', 'store', 'show', 'destroy']);

        //**  Bureau COMPTABILITE / CAISSE (Partie USER) */
        Route::resource('mot-cle-imputation', MotCleController::class)->except(['show']);
        Route::resource('recettes-caisse', RecetteCaisseController::class)->except(['show']);
        Route::resource('dépenses-avec-bons', DepenseBonController::class)->except(['show']);
        Route::resource('dépenses-sans-bons', DepenseSansBonController::class)->except(['show']);
        Route::resource('report-annuel', ReportAnnuelController::class)->except(['show', 'index']);
            //Reporting (Rapport Financier)
            Route::get('/rapport-financier-form', [ReportingController::class, 'index'])->name('rap.financier.form');
            Route::get('/rapport-journalier-pdf', [ReportingController::class, 'generatePdf'])->name('rap.financier.pdf');
            Route::get('/rapport-périodique-pdf', [ReportingController::class, 'generatePeriodicReport'])->name('rap.periodique.pdf');

            //Reporting (Rapport Dépenses)
            Route::get('/rapport-dépenses-form', [ReportingController::class, 'indexRapDep'])->name('rap.depense.form');
            Route::get('/rapport-dépenses-pdf', [ReportingController::class, 'generateRapDepPdf'])->name('rap.depense.pdf');

            //Reporting (Rapport Recettes)
            Route::get('/rapport-recettes-form', [ReportingController::class, 'indexRapRecette'])->name('rap.recette.form');
            Route::get('/rapport-recettes-pdf', [ReportingController::class, 'generateRapRecettPdf'])->name('rap.recette.pdf');

            // Paramètres de changement de mot de passe et Profile Utilisateur
            Route::get('/paramètre-mot-de-passe', [UserController::class, 'parametrePassword'])->name('change.password');
            Route::post('/password-changed', [UserController::class, 'updatePassword'])->name('password.changed');
            Route::get('/profile-utilisateur', [UserController::class, 'userProfile'])->name('profile');
    });

    //Tableau de Bord pour la DANTIC
    Route::get('/dashboard/dantic', [DashController::class, 'index'])->name('dashboard.direction1');

    //Tableau de Bord pour la DIR-GENERALE
    Route::get('/dashboard/direction-générale', [AuthController::class, 'index2'])->name('dashboard.direction2');
    Route::get('/dashboard/direction-admin-financière', [AuthController::class, 'dashDAFpourDG'])->name('dash.daf');
    Route::get('/rapport-financier-daf', [AuthController::class, 'formReportDAF'])->name('rap.financier.daf');

    //Tableau de Bord pour la DAPPRO
    Route::get('/dashboard/dappro', [DashController::class, 'indexDappro'])->name('dashboard.direction3');
    //Tableau de Bord pour la DEP
    Route::get('/dashboard/dep', [DashController::class, 'index4'])->name('dashboard.direction4');
    //Tableau de Bord pour la DAF
    Route::get('/dashboard/daf', [AuthController::class, 'indexDAF'])->name('dashboard.direction5');
    //Tableau de Bord pour la PROD
    Route::get('/dashboard/production', [DashController::class, 'indexProd'])->name('dashboard.direction6');
    //Tableau de Bord pour la DRH
    Route::get('/dashboard/drh', [DashController::class, 'indexDRH'])->name('dashboard.direction7');


    //Les routes pour les tableaux de bord suivant les bureaux
    Route::get('/dashboard/fourniture', [DashController::class, 'indexFourniture'])->name('dashboard.bureau');
    Route::get('/dashboard/vente', [DashController::class, 'indexVente'])->name('dashboard.bureau.vente');
    Route::get('/dashboard/mp', [DashController::class, 'indexDappro'])->name('dashboard.bureau.mp');
    Route::get('/dashboard/engagement/liquidation', [DashEliqController::class, 'indexEliq'])->name('dashboard.bureau.eliq');
    Route::get('/dashboard/comptabilité/caisse', [DashEliqController::class, 'indexCaisse'])->name('dashboard.bureau.caisse');

    // Bureau MATIERE PREMIERE pour User
    Route::prefix('stock')->name('mouvement.')->group(function () {
        Route::resource('gestion', gestionArticleController::class)->except(['show']);
        Route::resource('EntreeStock', InStockController::class);
        Route::resource('SortieStock', OutStockController::class);
        Route::resource('reporting', ReportController::class);

    });
    // Partie Reporting pour Bureau MATIERE PREMIERE (USER)
    Route::get('rapport-global_stock', [PDFController::class, 'rapGlobal'])->name('rapportGlobal');
    Route::get('rapport-entree_stock', [PDFController::class, 'rapEntree'])->name('rapportEntree');
    Route::get('rapport-sortie_stock', [PDFController::class, 'rapSortie'])->name('rapportSortie');
    Route::get('/ficheStock', [PDFController::class, 'fiche'])->name('ficheStockPDF');
    Route::get('/fiche-stock-mp', [PDFController::class, 'generatePdf'])->name('ficheStkPdf');

    Route::get('prixArticle', [GetElementController::class, 'getPrice'])->name('getPrice');
    Route::get('ficheStocks', [GetElementController::class, 'fiche'])->name('ficheStock');
});
