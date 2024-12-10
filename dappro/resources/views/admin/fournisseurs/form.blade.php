@extends('layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Fournisseurs</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item">Administration</li>
          <li class="breadcrumb-item active">Fournisseurs</li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('admin.fournisseur.index') }}">Voir la liste</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Enregistrement Fournisseur</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('admin.fournisseur.store') }}" method="post">

                    @csrf
                    @method('post')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nom" class="form-label">Nom *</label>
                                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" id="nom" value="{{ old('nom') }}">
                                    @error('nom')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Description" name="description" id="description" style="height: 100px;" value="{{ old('description') }}" required></textarea>
                                    <label for="description">Description</label>
                                  </div>
                                <div style="color: red;">
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="articles">Articles</label>
                                <select class="form-control" id="articles" name="articles[]" multiple required>
                                    @foreach ($articles as $article)
                                        <option value="{{ $article->id }}">{{ $article->designation }}</option>
                                    @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('articles[]')
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
