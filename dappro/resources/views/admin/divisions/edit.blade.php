@extends('layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Divisions</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item">Administration</li>
          <li class="breadcrumb-item active">Division</li>
        </ol>
        <a type="text" class="btn btn-primary" href="{{ route('admin.division.index') }}">Voir la liste</a>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Modification Division</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('admin.division.update', $division->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="designation" class="form-label">Désignation *</label>
                                    <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" id="designation" value="{{ $division->designation }}">
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
                                <label for="direction_id" class="form-label">Direction *</label>
                                <select id="direction_id" class="form-select @error('direction_id') is-invalid @enderror" name="direction_id">
                                <option value="">Sélectionnez...</option>
                                @foreach ($directions as $direction)
                                    <option value="{{ $direction->id }}" {{ old('direction_id', $division->direction_id) == $direction->id ? 'selected' : '' }}>{{ $direction->designation }}</option>
                                @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('direction_id')
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
          &copy; Copyright <strong><span>DANTIC-SENAPI</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->
@endsection
