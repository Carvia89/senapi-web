@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Gestion Articles</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
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
                <h5 class="card-title">Stock Nouvel Article</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('mouvement.gestion.store') }}" method="POST">

                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-6 col-sm-6">
                                <label for="designation_id" class="form-label">Article *</label>
                                <select id="designation_id" class="form-select @error('designation_id') is-invalid @enderror" name="designation_id">
                                <option selected>Sélectionnez...</option>
                                @foreach ($articles as $article)
                                    <option value="{{ $article->id }}" {{ old('designation_id') == $article->id ? 'selected' : '' }}>{{ $article->designation }}</option>
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
                                <option selected>Sélectionnez...</option>
                                @foreach ($unites as $unite)
                                    <option value="{{ $unite->id }}" {{ old('unite_id') == $unite->id ? 'selected' : '' }}>{{ $unite->unite }}</option>
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
                            <div class="col-md-4 col-sm-4">
                                <label for="stock_initial" class="form-label">Stock Initial</label>
                                <input type="float" name="stock_initial" class="form-control @error('stock_initial') is-invalid @enderror" id="stock_initial" value="{{ old('stock_initial') }}">
                                @error('stock_initial')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <label for="stock_minimal" class="form-label">Stock Minimal</label>
                                <input type="float" name="stock_minimal" class="form-control @error('stock_minimal') is-invalid @enderror" id="stock_minimal" value="{{ old('stock_minimal') }}">
                                @error('stock_minimal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <label for="price" class="form-label">Prix "USD"</label>
                                <input type="text" name="price" class="form-control bg-light" id="price" readonly>
                                @error('price')
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

                <script>
                    $(document).ready(function() {
                        $('#designation_id').on('change', function() {
                            var numArt = $(this).val();

                            if (numArt) {
                                $.ajax({
                                    url: '{{ route("getPrice") }}',
                                    type: 'GET',
                                    data: { numArt: numArt },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(response) {
                                        if (response.error) {
                                            // Afficher un message d'erreur
                                            alert(response.error);
                                            $('#price').val('');
                                        } else {
                                            // Afficher le prix de l'article
                                            $('#price').val(response.prix);
                                        }
                                    },
                                    error: function(xhr) {
                                        // Gérer les erreurs de la requête
                                        console.log('Une erreur est survenue :', xhr);
                                        $('#price').val('');
                                    }
                                });
                            } else {
                                // Vider le champ prix si aucun article n'est sélectionné
                                $('#price').val('');
                            }
                        });
                    });
                </script>

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
          &copy; Copyright 2025, <strong><span>DANTIC-SENAPI</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->
@endsection


