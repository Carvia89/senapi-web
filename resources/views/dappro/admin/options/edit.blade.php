@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Gestion Bulletins Scolaires</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
          <li class="breadcrumb-item">Bureau Fourniture</li>
          <li class="breadcrumb-item active">Options </li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('admin.Option.index') }}">Voir la liste</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Modification Option</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('admin.Option.update', $option->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="designation" class="form-label">Désignation *</label>
                                    <input type="text" name="designation" class="form-control
                                        @error('designation') is-invalid @enderror" id="designation"
                                        value="{{ $option->designation }}">
                                    @error('designation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="niveau_id" class="form-label">Niveau *</label>
                                <select id="niveau_id" class="form-select @error('niveau_id') is-invalid @enderror" name="niveau_id">
                                <option value="">Sélectionnez...</option>
                                @foreach ($niveaux as $niveau)
                                    <option value="{{ $niveau->id }}" {{ old('niveau_id', $option->niveau_id) == $niveau->id ? 'selected' : '' }}>{{ $niveau->designation }}</option>
                                @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('niveau_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="cycle_id" class="form-label">Cycle *</label>
                                <select id="cycle_id" class="form-select @error('cycle_id') is-invalid @enderror" name="cycle_id">
                                <option value="">Sélectionnez...</option>
                                @foreach ($cycles as $cycle)
                                    <option value="{{ $cycle->id }}" {{ old('cycle_id', $option->cycle_id) == $cycle->id ? 'selected' : '' }}>{{ $cycle->designation }}</option>
                                @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('cycle_id')
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
