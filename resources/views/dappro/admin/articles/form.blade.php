@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Articles</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
          <li class="breadcrumb-item">Administration</li>
          <li class="breadcrumb-item active">Articles</li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('admin.Article.index') }}">Voir la liste</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Enregistrement Article</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('admin.Article.store') }}" method="post">

                    @csrf
                    @method('post')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="designation" class="form-label">Désignation *</label>
                                    <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" id="designation" value="{{ old('designation') }}">
                                    @error('designation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="categorie_id" class="form-label">Catégorie *</label>
                                <select id="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror" name="categorie_id">
                                <option selected>Sélectionnez...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('categorie_id') == $category->id ? 'selected' : '' }}>{{ $category->designation }}</option>
                                @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('categorie_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="price" class="form-label">Prix "USD" *</label>
                                    <input type="float" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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
