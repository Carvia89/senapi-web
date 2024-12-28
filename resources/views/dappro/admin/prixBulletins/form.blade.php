@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Gestion Bulletins Scolaires</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
          <li class="breadcrumb-item">Division Vente</li>
          <li class="breadcrumb-item active">Prix Bulletins</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Prix Bulletins</h5>

                    <!-- Horizontal Form -->
                    <form class="vstack gap-3" action="{{ route('admin.PrixBulletin.store') }}" method="POST">
                        @if (Session('success'))
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="bi bi-hand-thumbs-up-fill me-2"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        @endif

                        @csrf
                        @method('POST')

                        <div class="row">
                            <div class="row mt-3">
                                <div class="col-md-6 col-sm-6">
                                    <label for="prix" class="form-label">Prix "CDF" *</label>
                                    <input type="number" name="prix" class="form-control
                                        @error('prix') is-invalid @enderror" id="prix" value="{{ old('prix') }}">
                                    @error('prix')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label for="description" class="form-label">Description </label>
                                    <input type="text" name="description" class="form-control
                                        @error('description') is-invalid @enderror" id="description" value="{{ old('description') }}">
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">
                                Enregistrer
                            </button>
                        </div>
                    </form><!-- End Multi Columns Form -->
                </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Tableau de Prix</h5>

                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Description</th>
                        <th scope="col" class="text-end">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($prices as $price)
                            <tr>
                                <td scope="row">{{ $price->id }}</td>
                                <td>{{ number_format($price->prix, 2, ',', ' ') }} CDF</td>
                                <td>{{ $price->description ?? 'Aucune description' }}</td>
                                <td>
                                    <div class="d-flex gap-2 w-100 justify-content-end">
                                        <a href="{{ route('admin.PrixBulletin.edit', $price) }}"
                                        title="Editer" class="btn btn-primary"><i class="bi bi-pencil color-muted m-r-5"></i></a>
                                        <form action="{{ route('admin.PrixBulletin.destroy', $price) }}" method="post">
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
                  {{ $prices->links() }}

              </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<br>
<br>
<br>
<br>
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
          &copy; Copyright 2024, <strong><span>DANTIC-SENAPI</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->
@endsection


