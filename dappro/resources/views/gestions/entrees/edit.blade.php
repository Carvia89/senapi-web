@extends('layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Entrée Stocks</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item">Mouvement Stock</li>
          <li class="breadcrumb-item active">Entrée Stocks</li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('mouvement.EntreeStock.index') }}">Voir la liste</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Approvisionnement</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('mouvement.EntreeStock.update', $entreestock->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-6 col-sm-6">
                                <label for="article_id" class="form-label">Désignation Article *</label>
                                <select id="article_id" class="form-select @error('article_id') is-invalid @enderror" name="article_id">
                                <option value="">Sélectionnez...</option>
                                @foreach ($articles as $article)
                                    <option value="{{ $article->id }}" {{ old('article_id', $entreestock->article_id) == $article->id ? 'selected' : '' }}>{{ $article->designation }}</option>
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

                            <div class="col-md-6 col-sm-6">
                                <label for="fournisseur_id" class="form-label">Fournisseur *</label>
                                <select id="fournisseur_id" class="form-select @error('fournisseur_id') is-invalid @enderror" name="fournisseur_id">
                                <option value="">Sélectionnez...</option>
                                @foreach ($fournisseurs as $fournisseur)
                                    <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id', $entreestock->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>{{ $fournisseur->nom }}</option>
                                @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('fournisseur_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 col-sm-6">
                                <label for="unite_id" class="form-label">Unité *</label>
                                <select id="unite_id" class="form-select @error('unite_id') is-invalid @enderror" name="unite_id">
                                <option value="">Sélectionnez...</option>
                                @foreach ($unites as $unite)
                                    <option value="{{ $unite->id }}" {{ old('unite_id', $entreestock->unite_id) == $unite->id ? 'selected' : '' }}>{{ $unite->unite }}</option>
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

                            <div class="col-md-6 col-sm-6">
                                <label for="quantite" class="form-label">Quantité *</label>
                                <input type="integer" name="quantite" class="form-control @error('quantite') is-invalid @enderror" id="quantite" value="{{ $entreestock->quantite }}">
                                @error('quantite')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-4">
                                <label for="num_facture" class="form-label">Numéro Facture *</label>
                                <input type="text" name="num_facture" class="form-control @error('num_facture') is-invalid @enderror" id="num_facture" value="{{ $entreestock->num_facture }}">
                                @error('num_facture')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <label for="ref_bon_CMD" class="form-label">Rérérence Bon CMD *</label>
                                <input type="text" name="ref_bon_CMD" class="form-control @error('ref_bon_CMD') is-invalid @enderror" id="ref_bon_CMD" value="{{ $entreestock->ref_bon_CMD }}">
                                @error('ref_bon_CMD')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <label for="date_entree" class="form-label">Date Entrée *</label>
                                <input type="date" name="date_entree" class="form-control @error('date_entree') is-invalid @enderror" id="date_entree" value="{{ $entreestock->date_entree }}">
                                @error('date_entree')
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
