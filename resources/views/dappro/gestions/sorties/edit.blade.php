@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Sortie Stocks</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
          <li class="breadcrumb-item">Mouvement Stock</li>
          <li class="breadcrumb-item active">Sortie Stocks</li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('mouvement.SortieStock.index') }}">Voir la liste</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Livraison</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('mouvement.SortieStock.update', $sortiestock->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-6 col-sm-6">
                                <label for="bureau_id" class="form-label">Service Demandeur *</label>
                                <select id="bureau_id" class="form-select @error('bureau_id') is-invalid @enderror" name="bureau_id">
                                <option selected>Sélectionnez...</option>
                                @foreach ($bureaus as $bureau)
                                    <option value="{{ $bureau->id }}" {{ old('bureau_id', $sortiestock->bureau_id) == $bureau->id ? 'selected' : '' }}>{{ $bureau->designation }}</option>
                                @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('bureau_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <label for="article_id" class="form-label">Article *</label>
                                <select id="article_id" class="form-select @error('article_id') is-invalid @enderror" name="article_id" onchange="updateStockDispo(this.value)">
                                <option selected>Sélectionnez...</option>
                                @foreach ($articles as $article)
                                <option value="{{ $article->id }}" {{ old('article_id', $sortiestock->article_id) == $article->id ? 'selected' : '' }}>{{ $article->designation }}</option>
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
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-4">
                                <label for="quantiteLivree" class="form-label">Quantité Livrée *</label>
                                <input type="float" name="quantiteLivree" class="form-control @error('quantiteLivree') is-invalid @enderror" id="quantiteLivree" value="{{ $sortiestock->quantiteLivree }}">
                                @error('quantiteLivree')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <label for="reception" class="form-label">Réceptionné par *</label>
                                <input type="text" name="reception" class="form-control @error('reception') is-invalid @enderror" id="reception" value="{{ $sortiestock->reception }}">
                                @error('reception')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <label for="date_sortie" class="form-label">Date Entrée *</label>
                                <input type="date" name="date_sortie" class="form-control @error('date_sortie') is-invalid @enderror" id="date_sortie" value="{{ $sortiestock->date_sortie }}">
                                @error('date_sortie')
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
          &copy; Copyright 2024, <strong><span>DANTIC-SENAPI</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->
@endsection
