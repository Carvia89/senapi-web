@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Gestion Bulletins Scolaires</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
          <li class="breadcrumb-item">Bureau Fournitures</li>
          <li class="breadcrumb-item active">Classes Bulletins</li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('admin.Kelasi.index') }}">Voir la liste</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Classes Bulletins</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('admin.Kelasi.store') }}" method="POST">

                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-6 col-sm-6">
                                <label for="designation" class="form-label">Désignation</label>
                                <input type="text" name="designation" class="form-control
                                    @error('designation') is-invalid @enderror" id="designation" value="{{ old('designation') }}">
                                @error('designation')
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


