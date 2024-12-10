@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Unités Articles</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
          <li class="breadcrumb-item">Administration</li>
          <li class="breadcrumb-item active">Unités Articles</li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('admin.uniteArticle.index') }}">Voir la liste</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Enregistrement Unités</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-2" action="{{ route('admin.uniteArticle.store') }}" method="post">

                    @csrf
                    @method('post')

                    <div class="col-md-12">
                        <label for="unite" class="form-label">Unité</label>
                        <input type="text" name="unite" class="form-control @error('unite') is-invalid @enderror" id="unite" value="{{ old('unite') }}">
                        @error('unite')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                  <div class="text-left">
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
