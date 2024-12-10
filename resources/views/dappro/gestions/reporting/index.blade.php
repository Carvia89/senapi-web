@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Rapport global</h1>
        <nav class="d-flex justify-content-between align-items-center">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
            <li class="breadcrumb-item">Reporting </li>
            <li class="breadcrumb-item active">Rapport global</li>
          </ol>
          <div class="d-flex">
            <a type="text" class="btn btn-primary me-2" href="{{ route('rapportGlobal') }}" role="button" title="Charger">
                <i class="bi bi-download"></i>
                <!-- <i class="bi bi-printer"></i>  -->
                <!-- Nom du bouton -->
            </a>
            <a type="text" class="btn btn-primary" href="{{ route('mouvement.reporting.create') }}">Retour</a>
          </div>
        </nav>
      </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Tableau général des mouvements </h5>

                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Désignation</th>
                        <th scope="col">Unités</th>
                        <th scope="col">Stock Initial</th>
                        <th scope="col">Stock Entrée</th>
                        <th scope="col">Stock Sortie</th>
                        <th scope="col">Solde</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaires as $inventaire)
                        <tr>
                            <td>{{ $inventaire->article->designation }}</td>
                            <td>{{ $inventaire->unity->unite }}</td>
                            <td>{{ number_format($inventaire->stock_initial, 0, ',', ' ') }}</td>
                            <td>{{ number_format($inventaire->stock_entree, 0, ',', ' ') }}</td>
                            <td>{{ number_format($inventaire->stock_sortie, 0, ',', ' ') }}</td>
                            <td>
                                <span class="badge {{ $inventaire->stock_actuel <= 5 ? 'bg-danger' : 'bg-success' }}">
                                    {{ number_format($inventaire->stock_actuel, 0, ',', ' ') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <!-- End Table with hoverable rows -->

             <!-- Pagination with icons -->


              </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
          &copy; Copyright <strong><span>DANTIC-SENAPI</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->
@endsection
