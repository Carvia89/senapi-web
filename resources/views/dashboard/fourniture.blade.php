@extends('dappro.layouts.fournitures.template')

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
                                                    <i class="fas fa-users text-c-purple f-24"></i>
                                                </div>
                                                <div id="userCount" class="col-8 p-l-0">
                                                    <h5 id="userCountValue">0</h5> <!-- Ajout d'un ID pour le h5 -->
                                                    <p class="text-muted m-b-0">Connectés</p>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            async function fetchConnectedUsers() {
                                                const response = await fetch('/connected_users');
                                                const data = await response.json();
                                                document.getElementById('userCountValue').textContent = data.count; // Mise à jour du h5
                                            }

                                            setInterval(fetchConnectedUsers, 5000); // Met à jour toutes les 5 secondes
                                            fetchConnectedUsers(); // Appel initial
                                        </script>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-graduation-cap text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>0</h5>
                                                    <p class="text-muted m-b-0"> Eff. Elèves</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-male text-c-red f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>0</h5>
                                                    <p class="text-muted m-b-0">Garçons</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-female text-c-blue f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>0</h5>
                                                    <p class="text-muted m-b-0">Filles</p>
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
                                                    <i class="fas fa-user text-c-purple f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>0</h5>
                                                    <p class="text-muted m-b-0">Enseignants</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-users text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>0</h5>
                                                    <p class="text-muted m-b-0">Parents</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-book text-c-red f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>0</h5>
                                                    <p class="text-muted m-b-0">Cours</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-building text-c-blue f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>0</h5>
                                                    <p class="text-muted m-b-0">Classes</p>
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
                                            <i class="fas fa-money-bill-alt mat-icon f-24"></i>
                                        </div>
                                        <div class="col-9 cst-cont">
                                            <h5>00 USD</h5>
                                            <p class="m-b-0">Cumul Frais Scolaires Payés</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mat-clr-stat-card text-white red">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-3 text-center bg-c-red">
                                            <i class="fas fa-money-bill-alt mat-icon f-24"></i>
                                        </div>
                                        <div class="col-9 cst-cont">
                                            <h5>00 USD</h5>
                                            <p class="m-b-0">Frais en attente de paiement</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Material statustic card end -->
                        <!-- order-visitor start -->


                        <!-- order-visitor end -->

                        <!--  sale analytics start -->
                        <div class="col-xl-6 col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>Frais scolaires récemment payés</h5>
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
                                            <!-- Tableau à insérer

                                        -->
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
                                            <h6 class="m-b-0">Paiement Frais</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>
                                                00
                                            </h4>
                                            <p class="m-b-0">Nbre d'élèves sans paiement</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">Paiement Frais</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>
                                                00
                                            </h4>
                                            <p class="m-b-0">Nbre d'élèves avec paiement</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-c-red total-card">
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4>00</h4>
                                                <p class="m-0">Elèves sans paiement</p>
                                            </div>
                                            <span class="label bg-c-red value-badges">00 %</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-c-green total-card">
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4>00</h4>
                                                <p class="m-0">Elèves ayant soldé</p>
                                            </div>
                                            <span class="label bg-c-green value-badges">00 %</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">Effectif finalistes /Humanités</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>
                                                00
                                            </h4>
                                            <p class="m-b-0">00% de toute l'école</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">Effectif finalistes /Primaires</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>
                                                00
                                            </h4>
                                            <p class="m-b-0">00% de toute l'école</p>
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
                                            <h6>Effectif Maternel</h6>
                                            <h5 class="m-b-30 f-w-700">00 élèves, Soit <span class="text-c-green m-l-10">
                                                00%</span></h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-red" style="width:00%"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <h6>Effectif Niveau Moyen</h6>
                                            <h5 class="m-b-30 f-w-700">00 élèves, Soit <span class="text-c-red m-l-10">
                                                00%</span></h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-blue" style="00%"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <h6>Effectif Ensg. de Base</h6>
                                            <h5 class="m-b-30 f-w-700">00 élèves, Soit <span class="text-c-green m-l-10">
                                                00%</span></h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-green" style="00%"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <h6>Effectif Humanités</h6>
                                            <h5 class="m-b-30 f-w-700">00 élèves, Soit <span class="text-c-green m-l-10">
                                                00%</span></h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-yellow" style="00%"></div>
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
                &copy;2024, <a style="font-weight: bold"><span>DANTIC-SENAPI</span></a>. All Rights Reserved
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