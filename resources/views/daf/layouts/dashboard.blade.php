@extends('daf.layouts.template')

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
                                            <i class="fas fa-bank text-c-purple f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $nbreBanques }}</h5>
                                            <p class="text-muted m-b-0">Banques</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-users text-c-green f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $nbreBenef }}</h5>
                                            <p class="text-muted m-b-0">Bénéficiaires</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-user text-c-red f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $nombreUtilisateurs }}</h5>
                                            <p class="text-muted m-b-0">Users</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-folder text-c-blue f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $nbreDoss}}</h5>
                                            <p class="text-muted m-b-0">Dossiers</p>
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
                                            <i class="fas fa-download text-c-purple f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $nbreEBdownload }}</h5>
                                            <p class="text-muted m-b-0">Total EB</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-file-alt text-c-green f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $EBtraités }}</h5>
                                            <p class="text-muted m-b-0">EB liquidés</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-file-alt text-c-red f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $nbreBonDepenses }}</h5>
                                            <p class="text-muted m-b-0">Bon de Dépenses</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 p-b-20 p-t-20">
                                    <div class="row align-items-center text-center">
                                        <div class="col-4 p-r-0">
                                            <i class="fas fa-file-alt text-c-blue f-24"></i>
                                        </div>
                                        <div class="col-8 p-l-0">
                                            <h5>{{ $nbreBonPayés }}</h5>
                                            <p class="text-muted m-b-0">Bons Payés</p>
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
                                    <h5 style="text-align: right">{{ number_format($sommeBonPayés, 2, ',', ' ') }} CDF</h5>
                                    <p class="m-b-0">Montant global de bons payés</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mat-clr-stat-card text-white blue">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-3 text-center bg-c-blue">
                                    <i class="fas fa-star mat-icon f-24"></i>
                                </div>
                                <div class="col-9 cst-cont">
                                    <h5 style="text-align: right">{{ number_format($sommeBonàPayer, 2, ',', ' ') }} CDF</h5>
                                    <p class="m-b-0">Montant global de bons en attente de paiement</p>
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
                            <h5>Bons de dépenses récemment élaborés</h5>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa-wrench open-card-option"></i></li>
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
                                        @foreach($bonsDepenses as $bon)
                                        <tr>
                                            <td>
                                                <div class="d-inline-block align-middle">
                                                    <img src="{{ asset('dappro_dash_assets/assets/images/user-profile_.jpg') }}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                    <div class="d-inline-block">
                                                        <h6>{{ $bon->num_bon }}</h6>
                                                        <p class="text-muted m-b-0">{{ implode(' ', array_slice(explode(' ', $bon->motif), 0, 7)) }}...</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <h6 class="f-w-700">{{ number_format($bon->montant_bon, 2, ',', ' ') }}
                                                    @if($bon->created_at == $bon->updated_at) <!-- Vérification si l'enregistrement est nouveau -->
                                                        <i class="fas fa-level-up-alt text-c-green m-l-10"></i> <!-- Icône pour enregistrement -->
                                                    @else
                                                        <i class="fas fa-level-down-alt text-c-red m-l-10"></i> <!-- Icône pour modification -->
                                                    @endif
                                                </h6>
                                            </td>
                                        </tr>
                                        @endforeach
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
                                    <h6 class="m-b-0">Bons</h6>
                                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>00</h4>
                                    <p class="m-b-0">classés</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center order-visitor-card">
                                <div class="card-block">
                                    <h6 class="m-b-0">Bons</h6>
                                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>00</h4>
                                    <p class="m-b-0">classés</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-c-red total-card">
                                <div class="card-block">
                                    <div class="text-left">
                                        <h4 style="text-align: right">{{ number_format($sommeBonàPayer, 2, ',', ' ') }} CDF</h4>
                                        <p class="m-0">Montant de bons en attente</p>
                                    </div>
                                    <span class="label bg-c-red value-badges"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-c-green total-card">
                                <div class="card-block">
                                    <div class="text-left">
                                        <h4 style="text-align: right">{{ number_format($sommeBonPayés, 2, ',', ' ') }} CDF</h4>
                                        <p class="m-0">Montant de bons payés</p>
                                    </div>
                                    <span class="label bg-c-green value-badges"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center order-visitor-card">
                                <div class="card-block">
                                    <h6 class="m-b-0">Bons</h6>
                                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-red"></i>00</h4>
                                    <p class="m-b-0">non classés</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center order-visitor-card">
                                <div class="card-block">
                                    <h6 class="m-b-0">Bons</h6>
                                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-red"></i>5963</h4>
                                    <p class="m-b-0">non classés</p>
                                </div>
                            </div>
                        </div>
                        <!-- sale card end -->
                    </div>
                </div>

                <!--  sale analytics end -->
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
