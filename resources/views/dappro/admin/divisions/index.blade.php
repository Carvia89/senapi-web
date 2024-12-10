@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Liste</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
          <li class="breadcrumb-item">Divisions </li>
          <li class="breadcrumb-item active">Liste </li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('admin.division.create') }}">Ajouter</a>
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
                <h5 class="card-title">Liste des Divisions</h5>

                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Désignation</th>
                        <th scope="col">Direction</th>
                        <th scope="col" class="text-end">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($divisions as $division)
                            <tr>
                                <td scope="row">{{ $division->id }}</td>
                                <td>{{ $division->designation }}</td>
                                <td>{{ $division->direction->designation }}</td>
                                <td>
                                    <div class="d-flex gap-2 w-100 justify-content-end">
                                        <a href="{{ route('admin.division.edit', $division) }}" title="Editer" class="btn btn-primary"><i class="bi bi-pencil color-muted m-r-5"></i></a>
                                        <form action="{{ route('admin.division.destroy', $division) }}" method="post">
                                            @csrf
                                            @method("delete")
                                            <button class="btn btn-danger" title="Supprimer">
                                                <i class="bi bi-trash-fill color-muted m-r-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <!-- End Table with hoverable rows -->

             <!-- Pagination with icons -->
                  {{ $divisions->links() }}

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
