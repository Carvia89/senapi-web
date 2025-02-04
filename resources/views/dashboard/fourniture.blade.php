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
                                                    <h5 id="userCountValue">{{ $usersCount }}</h5>
                                                    <p class="text-muted m-b-0">Utilisateurs</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-building text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>{{ $directionsCount }}</h5>
                                                    <p class="text-muted m-b-0"> Directions</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-building text-c-blue f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>{{ $divisionsCount }}</h5>
                                                    <p class="text-muted m-b-0">Division</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-building text-c-red f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>{{ $bureauxCount }}</h5>
                                                    <p class="text-muted m-b-0"> Bureaux</p>
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
                                                    <i class="fas fa-graduation-cap text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>{{ $niveauxCount }}</h5>
                                                    <p class="text-muted m-b-0"> Niveaux</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-cogs text-c-blue f-24"></i>
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
                                                    <i class="fas fa-building text-c-red f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5>{{ $kelasiCount }}</h5>
                                                    <p class="text-muted m-b-0">Classes</p>
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
                            <div class="card mat-clr-stat-card text-white green ">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-3 text-center bg-c-green">
                                            <i class="fas fa-file-alt mat-icon f-24"></i>
                                        </div>
                                        <div class="col-9 cst-cont">
                                            <h5>{{ number_format($soldeActuel, 0, ',', ' ') }} bulletins</h5>
                                            <p class="m-b-0">Solde Actuel des Bulletins Scolaires</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mat-clr-stat-card text-white red">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-3 text-center bg-c-red">
                                            <i class="fas fa-file-alt mat-icon f-24"></i>
                                        </div>
                                        <div class="col-9 cst-cont">
                                            <h5>{{ number_format($qteLivreeTotal, 0, ',', ' ') }} bulletins</h5>
                                            <p class="m-b-0">Stock des Bulltetins Livrés</p>
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
                                    <h5>Situation Actuelle des Bulletins Scolaires</h5>
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
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Classe</th>
                                                    <th>Option</th>
                                                    <th>Stock Début</th>
                                                    <th>Entrée</th>
                                                    <th>Sortie</th>
                                                    <th style="font-weight: bold; font-size: 1.2em; text-align: right;">Solde</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($enregistrements as $enregistrement)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $kelasis->find($enregistrement->classe_id)->designation ?? 'N/A' }}</td>
                                                        <td>{{ $options->find($enregistrement->option_id)->designation ?? 'N/A' }}</td>
                                                        <td>{{ number_format($enregistrement->stock_debut, 0, ',', ' ') }}</td>
                                                        <td>{{ number_format($enregistrement->quantite_recue, 0, ',', ' ') }}</td>
                                                        <td>{{ number_format($enregistrement->qte_livree, 0, ',', ' ') }}</td>
                                                        <td style="font-weight: bold; font-size: 1em; text-align: right;">
                                                            {{ number_format($enregistrement->stock_debut + $enregistrement->quantite_recue - $enregistrement->qte_livree, 0, ',', ' ') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div>
                                            <div>
                                                {{ $enregistrements->links() }}
                                            </div>
                                        </div>
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
                                            <h6 class="m-b-0">Total Préliminaire</h6>
                                            <h4 class="m-t-15 m-b-15">
                                                <i class="fa fa-arrow-down m-r-15 text-c-red"></i>
                                                    00
                                            </h4>
                                            <p class="m-b-0">Solde actuel</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">Total Elémentaire</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>
                                                00
                                            </h4>
                                            <p class="m-b-0">Solde actuel</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-c-red total-card">
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4>{{ number_format($qteLivreeTotal, 0, ',', ' ') }}</h4>
                                                <p class="m-0">Bulletins Livrés</p>
                                            </div>
                                            <span class="label bg-c-red value-badges">{{ number_format($pourcentageLivres, 2, ',', ' ') }}%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-c-green total-card">
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4>{{ number_format($quantiteRecuTotal, 0, ',', ' ') }}</h4>
                                                <p class="m-0">Bulletins Reçus</p>
                                            </div>
                                            <span class="label bg-c-green value-badges">{{ number_format($pourcentageRecu, 2, ',', ' ') }}%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">Total Bulletins 7è</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>
                                                00
                                            </h4>
                                            <p class="m-b-0">00% du solde actuel</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">Total Bulletins 8è</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>
                                                00
                                            </h4>
                                            <p class="m-b-0">00% du solde actuel</p>
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
                                        @foreach ($resultats as $niveauId => $resultat)
                                        <div class="col-xl-3 col-md-6">
                                            <h6>Total {{ $resultat['nom'] }}</h6>
                                            <h5 class="m-b-30 f-w-700">{{ number_format($resultat['solde'], 0, ',', ' ') }}, Soit <span class="text-c-green m-l-10">
                                                {{ number_format($resultat['pourcentage'], 2) }}%</span></h5>
                                            <div class="progress">
                                                <div class="progress-bar {{ $resultat['couleur'] }}" style="width: {{ number_format($resultat['pourcentage'], 2) }}%"></div>
                                            </div>
                                        </div>
                                        @endforeach
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
