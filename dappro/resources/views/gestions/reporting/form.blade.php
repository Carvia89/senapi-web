@extends('layouts.template')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Fiche de stock</h1>
        <nav class="d-flex justify-content-between align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Fiche de stock</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fiche de stock</h5>

                        <!-- Horizontal Form -->
                        <form class="vstack gap-3" action="{{ route('ficheStock') }}" method="GET">

                            <div class="row mt-3">
                                <div class="col-md-4 col-sm-4">
                                    <label for="article_id" class="form-label">Désignation *</label>
                                    <select id="article_id" class="form-select @error('article_id') is-invalid @enderror" name="article_id" required>
                                    <option selected>Sélectionnez...</option>
                                    @foreach ($articles as $article)
                                        <option value="{{ $article->id }}" {{ old('article_id') == $article->id ? 'selected' : '' }}>{{ $article->designation }}</option>
                                    @endforeach
                                    </select>
                                    <div style="color: red;">
                                        @error('article_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="date_debut" class="form-label">Date_debut</label>
                                        <input type="date" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror" id="date_debut" value="{{ old('date_debut') }}" required>
                                        @error('date_debut')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="date_fin" class="form-label">Date_fin</label>
                                        <input type="date" name="date_fin" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" value="{{ old('date_fin') }}" required>
                                        @error('date_fin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    Valider
                                </button>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('rapportSortie') }}" class="btn btn-secondary">
                                        <i class="bi bi-download">
                                            Rapport sur les Sorties
                                        </i>
                                    </a>
                                    <a href="{{ route('rapportEntree') }}" class="btn btn-secondary">
                                        <i class="bi bi-download">
                                             Rapport sur les entrées
                                        </i>
                                    </a>
                                    <a href="{{ route('mouvement.reporting.index') }}" class="btn btn-secondary">
                                        Rapport global
                                    </a>
                                </div>
                            </div>
                        </form><!-- End Multi Columns Form -->
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <img src="{{asset('dash_assets/assets/img/qr-code-aufbau.png')}}"
            class="img-fluid" style="width: 100px; height: auto;" alt="Image">
        </div>
    </section>
    <!-- QR CODE -->
</main><!-- End #main -->

<br>

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>DANTIC-SENAPI</span></strong>. All Rights Reserved
    </div>
</footer><!-- End Footer -->
@endsection
