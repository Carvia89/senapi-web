@extends('layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Liste</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item">Entrée Stock </li>
          <li class="breadcrumb-item active">Liste </li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('mouvement.EntreeStock.create') }}">Ajouter</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-12">

            @if (Session('success'))
            <div class="alert alert-success d-flex align-items-center">
                <i class="bi bi-hand-thumbs-up-fill me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Tableau d'Approvisionnement </h5>

                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Désignation</th>
                        <th scope="col">Unité</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Date Entrée</th>
                        <th scope="col" class="text-end">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($entreestocks as $entreestock)
                            <tr>
                                <td scope="row">{{ $entreestock->id }}</td>
                                <td>{{ $entreestock->article->designation }}</td>
                                <td>{{ $entreestock->unity->unite }}</td>
                                <td>{{ number_format($entreestock->quantite, 0, ',', ' ') }}</td>
                                <td>{{ \Carbon\Carbon::parse($entreestock->date_entree)->format('d-m-Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2 w-100 justify-content-end">
                                        <a href="{{ route('mouvement.EntreeStock.edit', $entreestock) }}" title="Editer" class="btn btn-primary"><i class="bi bi-pencil color-muted m-r-5"></i></a>
                                        <form action="{{ route('mouvement.EntreeStock.destroy', $entreestock) }}" method="post">
                                            @csrf
                                            @method("delete")
                                            <button class="btn btn-danger" title="Supprimer">
                                                <i class="bi bi-trash-fill color-muted m-r-5"></i>
                                            </button>
                                        </form>
                                        <!-- <a href="{{ route('mouvement.EntreeStock.show', $entreestock) }}" title="Voir" class="btn btn-primary"><i class="bi bi-eye color-muted m-r-5"></i></a> -->
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <!-- End Table with hoverable rows -->

             <!-- Pagination with icons -->
                  {{ $entreestocks->links() }}

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
