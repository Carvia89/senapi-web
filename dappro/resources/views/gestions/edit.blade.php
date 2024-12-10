@extends('layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Gestion Articles</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item">Mouvement Stock</li>
          <li class="breadcrumb-item active">Gestion Articles</li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('mouvement.gestion.index') }}">Voir la liste</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Modification Stock Nouvel Article</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('mouvement.gestion.update', $gestion) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-6 col-sm-6">
                                <label for="designation_id" class="form-label">Désignation *</label>
                                <select id="designation_id" class="form-select @error('designation_id') is-invalid @enderror" name="designation_id">
                                <option value="">Sélectionnez...</option>
                                @foreach ($articles as $article)
                                    <option value="{{ $article->id }}" {{ old('designation_id', $gestion->designation_id) == $article->id ? 'selected' : '' }}>{{ $article->designation }}</option>
                                @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('designation_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <label for="unite_id" class="form-label">Unité *</label>
                                <select id="unite_id" class="form-select @error('unite_id') is-invalid @enderror" name="unite_id">
                                <option value="">Sélectionnez...</option>
                                @foreach ($unites as $unite)
                                    <option value="{{ $unite->id }}" {{ old('unite_id', $gestion->unite_id) == $unite->id ? 'selected' : '' }}>{{ $unite->unite }}</option>
                                @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('unite_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">



                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 col-sm-6">
                                <label for="stock_initial" class="form-label">Stock Initial</label>
                                <input type="float" name="stock_initial" class="form-control @error('stock_initial') is-invalid @enderror" id="stock_initial" value="{{ $gestion->stock_initial }}">
                                @error('stock_initial')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <label for="stock_minimal" class="form-label">Stock Minimal</label>
                                <input type="float" name="stock_minimal" class="form-control @error('stock_minimal') is-invalid @enderror" id="stock_minimal" value="{{ $gestion->stock_minimal }}">
                                @error('stock_minimal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">
                            Modifier
                        </button>
                    </div>
                </form><!-- End Multi Columns Form -->
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
          &copy; Copyright <strong><span>DANTIC-SENAPI</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->
@endsection
