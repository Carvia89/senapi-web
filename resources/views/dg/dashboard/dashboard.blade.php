@extends('dg.dashboard.layouts.template')

@section('content')
    <div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
    <div class="page-wrapper">
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <!-- Material statustic card start -->
                <div class="col-xl-4 col-md-12">
                    <div class="card mat-stat-card">
                        <div class="card-block">
                            <div class="row align-items-center b-b-default">
                                <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-graduation-cap text-c-purple f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $niveauxCount }}</h5>
                                            <p class="text-muted m-b-0">Niveaux</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-cogs text-c-green f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $optionCount }}</h5>
                                            <p class="text-muted m-b-0">Options</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-users text-c-red f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $clientCount }}</h5>
                                            <p class="text-muted m-b-0">Clients</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-truck text-c-blue f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $fournisseurCount }}</h5>
                                            <p class="text-muted m-b-0">Fournisseurs</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12">
                    <div class="card mat-stat-card">
                        <div class="card-block">
                            <div class="row align-items-center b-b-default">
                                <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-cart-plus text-c-purple f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $commande }}</h5>
                                            <p class="text-muted m-b-0">Commandes</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-sitemap text-c-green f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>600</h5>
                                            <p class="text-muted m-b-0">Network</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-signal text-c-red f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>350</h5>
                                            <p class="text-muted m-b-0">Signal</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-wifi text-c-blue f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>100%</h5>
                                            <p class="text-muted m-b-0">Connections</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12">
                    <div class="card mat-clr-stat-card text-white green ">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-3 text-center bg-c-green">
                                    <i class="fas fa-star mat-icon f-24"></i>
                                </div>
                                <div class="col-9 cst-cont">
                                    <h5 style="text-align: right">174 000</h5>
                                    <p class="m-b-0">Recettes Bulletins Scolaires (CDF)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mat-clr-stat-card text-white blue">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-3 text-center bg-c-blue">
                                    <i class="fas fa-file-alt mat-icon f-24"></i>
                                </div>
                                <div class="col-9 cst-cont">
                                    <h5>{{ number_format($QteBulRecu, 0, ',', ' ') }} Bulletins</h5>
                                    <p class="m-b-0">Nbre Total Bulletins réçus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Material statustic card end -->

                <!--  sale analytics start -->
                <div class="col-xl-6 col-md-12">
                    <div class="card table-card">
                        <div class="card-header">
                            <h5>Ventes récemment effectuées</h5>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                    <li><i class="fa fa-trash close-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-hover m-b-0 without-header">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-inline-block align-middle">
                                                    <img src="{{asset('dappro_dash_assets/assets/images/user-profile_.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                    <div class="d-inline-block">
                                                        <h6>CMD0006</h6>
                                                        <p class="text-muted m-b-0">Institut MAVUNGU</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <h6 class="f-w-700">210.000<i class="fas fa-level-down-alt text-c-red m-l-10"></i></h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-inline-block align-middle">
                                                    <img src="{{asset('dappro_dash_assets/assets/images/user-profile_.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                    <div class="d-inline-block">
                                                        <h6>CMD0004</h6>
                                                        <p class="text-muted m-b-0">Institut MINKONDO</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <h6 class="f-w-700">141.200<i class="fas fa-level-up-alt text-c-green m-l-10"></i></h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-inline-block align-middle">
                                                    <img src="{{asset('dappro_dash_assets/assets/images/user-profile_.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                    <div class="d-inline-block">
                                                        <h6>CMD0003</h6>
                                                        <p class="text-muted m-b-0">CS LES ANGES</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <h6 class="f-w-700">89.100<i class="fas fa-level-up-alt text-c-green m-l-10"></i></h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-inline-block align-middle">
                                                    <img src="{{asset('dappro_dash_assets/assets/images/user-profile_.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                    <div class="d-inline-block">
                                                        <h6>CMD0002</h6>
                                                        <p class="text-muted m-b-0">Collège BOBOTO</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <h6 class="f-w-700">450.000<i class="fas fa-level-up-alt text-c-green m-l-10"></i></h6>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12">
                    <div class="row">
                        <!-- sale card start -->

                        <div class="col-md-6">
                            <div class="card text-center order-visitor-card">
                                <div class="card-block">
                                    <h6 class="m-b-0">Stock Bulletins</h6>
                                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>00</h4>
                                    <p class="m-b-0">Livrés gratuitement</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center order-visitor-card">
                                <div class="card-block">
                                    <h6 class="m-b-0">Stock Bulletins</h6>
                                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>00</h4>
                                    <p class="m-b-0">Livrés à crédit</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-c-red total-card">
                                <div class="card-block">
                                    <div class="text-left">
                                        <h4>489</h4>
                                        <p class="m-0">Nbre Bulletins Vendus</p>
                                    </div>
                                    <span class="label bg-c-red value-badges">15%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-c-green total-card">
                                <div class="card-block">
                                    <div class="text-left">
                                        <h4 style="text-align: right">567 782</h4>
                                        <p class="m-0">Stock Actuel Bulletins</p>
                                    </div>
                                    <span class="label bg-c-green value-badges"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center order-visitor-card">
                                <div class="card-block">
                                    <h6 class="m-b-0">Dépenses</h6>
                                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-red"></i>00</h4>
                                    <p class="m-b-0">Achat MP & Consommables</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center order-visitor-card">
                                <div class="card-block">
                                    <h6 class="m-b-0">Dépenses</h6>
                                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-red"></i>5963</h4>
                                    <p class="m-b-0">Fournitures de bureau</p>
                                </div>
                            </div>
                        </div>
                        <!-- sale card end -->
                    </div>
                </div>

                <!--  sale analytics end -->

                <!-- Project statustic start -->
                <div class="col-xl-12">
                    <div class="card proj-progress-card">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <h6>Vente Préliminaire</h6>
                                    <h5 class="m-b-30 f-w-700">532<span class="text-c-green m-l-10">+1.69%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar bg-c-red" style="width:25%"></div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <h6>Vente Elémentaire</h6>
                                    <h5 class="m-b-30 f-w-700">4,569<span class="text-c-red m-l-10">-0.5%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar bg-c-blue" style="width:65%"></div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <h6>Vente Terminal</h6>
                                    <h5 class="m-b-30 f-w-700">89%<span class="text-c-green m-l-10">+0.99%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar bg-c-green" style="width:85%"></div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <h6>Vente Humanités</h6>
                                    <h5 class="m-b-30 f-w-700">365<span class="text-c-green m-l-10">+0.35%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar bg-c-yellow" style="width:45%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Project statustic end -->
            </div>
        </div>
        <!-- Page-body end -->
    </div>
    <div id="styleSelector"> </div>
    </div>
    </div>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
        &copy;2025, <a style="font-weight: bold"><span>DANTIC-SENAPI</span></a>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a style="font-weight: bold">Charles THAMBA & Alexis LUBOYA</a> <br>
            <a class="whatsapp-link" style="font-weight: bold"><i class="fab fa-whatsapp" aria-hidden="true"></i>
                +243 81 09 31 640 / +243 82 05 47 788
            </a>
        </div>
    </footer><!-- End Footer -->

    <style>
        .whatsapp-link i {
            color: #25D366; /* Couleur verte de WhatsApp */
            font-size: 1.2em; /* Augmente la taille de l'icône */
        }
    </style>
@endsection
