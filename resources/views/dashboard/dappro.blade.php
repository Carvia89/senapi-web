@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Tableau de Bord</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filtre</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Actuel</a></li>
                    </ul>
                  </div>
                <div class="card-body">
                  <h5 class="card-title">Nbre Articles </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $allArticles }}</h6>
                      <span class="text-success small pt-1 fw-bold">Nbre d'articles</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sold Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtre</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Actuelle</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Catégories <span>| A ce jour</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-tags"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $allCategories }}</h6>
                      <span class="text-success small pt-1 fw-bold">Catégories d'articles</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Depenses Card -->
            <div class="col-xxl-4 col-md-6">

              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtre</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Actuel</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Fournisseurs <span>| A ce jour</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-building"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $allFournisseurs }}</h6>
                      <span class="text-success small pt-1 fw-bold">Nbre de fournisseurs</span>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Dépenses Card -->

            <div class="col-xxl-4 col-md-6">

                <div class="card info-card customers-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filtre</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Actuelle</a></li>
                      <li><a class="dropdown-item" href="#">Mensuelle</a></li>
                      <li><a class="dropdown-item" href="#">Annuelle</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Stock Couché 300g <span>| </span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-text"></i>
                      </div>
                      <div class="ps-3">
                        <h6>111</h6>
                        <span class="text-danger small pt-1 fw-bold">Nbre de rame</span>

                      </div>
                    </div>
                  </div>
                </div>

              </div><!-- End Solde Card -->

              <div class="col-xxl-4 col-md-6">

                <div class="card info-card customers-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filtre</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Actuel</a></li>
                      <li><a class="dropdown-item" href="#">Mensuel</a></li>
                      <li><a class="dropdown-item" href="#">Annuel</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Stock Duplicateurs <span>| Aujourd'hui</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-text"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{ number_format($solde, 0, ',', ' ')  }}</h6>
                        <span class="text-danger small pt-1 fw-bold">Nbre de Ramettes </span>

                      </div>
                    </div>
                  </div>
                </div>

              </div><!-- End Solde Card -->

              <div class="col-xxl-4 col-md-6">

                <div class="card info-card customers-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filtre</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Actuelle</a></li>
                      <li><a class="dropdown-item" href="#">Mensuelle</a></li>
                      <li><a class="dropdown-item" href="#">Annuelle</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Stock Colle froide <span>| </span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-brush"></i>
                      </div>
                      <div class="ps-3">
                        <h6>52</h6>
                        <span class="text-danger small pt-1 fw-bold">Nbre de flacons </span>

                      </div>
                    </div>
                  </div>
                </div>

              </div><!-- End Solde Card -->

            <!-- Graphe -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtre</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="#">Mensuel</a></li>
                    <li><a class="dropdown-item" href="#">Annuel</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Graphe des Achats <span>/Aujourd'hui</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [
                        {
                          name: 'Fournitures',
                          data: [31, 40, 28, 51, 42, 82, 56, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Matière consommable',
                          data: [11, 32, 45, 32, 34, 52, 41, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Matière première',
                          data: [15, 11, 32, 18, 9, 24, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'date',
                          categories: ["Jan", "Féb", "Mars", "Avr", "Mai", "Juin", "Juil", "Août", "Sept", "Oct", "Nov", "Déc"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Graph -->

            <!-- Recent Prêt/Remboursement -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtre</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="#">Mensuel</a></li>
                    <li><a class="dropdown-item" href="#">Annuel</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Achats récemment effectués <span>| Aujourd'hui</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Désignation</th>
                        <th scope="col">Unité</th>
                        <th scope="col">Qté</th>
                        <th scope="col">Num. Facture</th>
                        <th scope="col">Date Entrée</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($entreestocks as $entreestock)
                            <tr>
                                <td scope="row">{{ $entreestock->id }}</td>
                                <td>{{ $entreestock->article->designation }}</td>
                                <td>{{ $entreestock->unity->unite }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ number_format($entreestock->quantite, 0, ',', ' ') }}
                                    </span>
                                </td>
                                <td>{{ $entreestock->num_facture }}</td>
                                <td>{{ \Carbon\Carbon::parse($entreestock->date_entree)->format('d-m-Y') }}</td>
                                <td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>

                  {{ $entreestocks->links() }}
                </div>
              </div>
            </div><!-- End Recent Sales -->
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Budget Report -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtre</h6>
                </li>

                <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                <li><a class="dropdown-item" href="#">Mensuel</a></li>
                <li><a class="dropdown-item" href="#">Annuel</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Consommation Articles <span>| </span></h5>

              <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                    legend: {
                      data: ['Qté consommée', 'Qté existante']
                    },
                    radar: {
                      // shape: 'circle',
                      indicator: [{
                          name: 'Duplicateur A4',
                          max: 6500
                        },
                        {
                          name: 'Bond jaune 80g',
                          max: 16000
                        },
                        {
                          name: 'Scotch transp. pt',
                          max: 30000
                        },
                        {
                          name: 'Emballage',
                          max: 38000
                        },
                        {
                          name: 'Papier transfert',
                          max: 52000
                        },
                        {
                          name: 'Colle patex',
                          max: 25000
                        }
                      ]
                    },
                    series: [{
                      name: 'Budget vs spending',
                      type: 'radar',
                      data: [{
                          value: [4200, 3000, 20000, 35000, 50000, 18000],
                          name: 'Qté consommée'
                        },
                        {
                          value: [5000, 14000, 28000, 26000, 42000, 21000],
                          name: 'Qté existante'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div><!-- End Budget Report -->

          <!-- Website Traffic -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                <li><a class="dropdown-item" href="#">Mensuelle</a></li>
                <li><a class="dropdown-item" href="#">Annuelle</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Services Demandeurs <span>| </span></h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Access From',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: 1048,
                          name: 'Presse Num.'
                        },
                        {
                          value: 735,
                          name: 'Pré-Presse'
                        },
                        {
                          value: 580,
                          name: 'Eng. & Liquidation'
                        },
                        {
                          value: 484,
                          name: 'Devis & Fact.'
                        },
                        {
                          value: 300,
                          name: 'Sérigraphie'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div><!-- End Website Traffic -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
          &copy; 2025, <strong><span>DANTIC-SENAPI</span></strong>. All Rights Reserved
        </div>
            <div class="credits">
            Designed by <a href="{{route('dashboard.direction3')}}">Bienvenu_THAMBA</a>
            </div>
      </footer><!-- End Footer -->
@endsection
