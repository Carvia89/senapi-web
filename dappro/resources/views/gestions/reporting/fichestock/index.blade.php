@extends('layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Fiche de Stock</h1>
        <nav class="d-flex justify-content-between align-items-center">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item">Reporting </li>
            <li class="breadcrumb-item active">Fiche de Stock</li>
          </ol>
          <div class="d-flex">
            <a type="text" class="btn btn-primary me-2" href="{{ route('ficheStockPDF') }}" role="button" title="Charger">
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
                <h5 class="card-title">Fiche de Stock de l'article : {{ $article->designation }}</h5>

                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>dateEntree</th>
                        <th>quantite</th>
                        <th>StockInitial</th>
                        <th>StockTotal</th>
                        <th>dateSortie</th>
                        <th>quantiteLivree</th>
                        <th>Solde</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td>{{ $row['dateEntree'] }}</td>
                            <td>{{ $row['quantite'] }}</td>
                            <td>{{ $row['StockInitial'] }}</td>
                            <td>{{ $row['StockTotal'] }}</td>
                            <td>{{ $row['dateSortie'] }}</td>
                            <td>{{ $row['quantiteLivree'] }}</td>
                            <td>{{ $row['Solde'] }}</td>
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
