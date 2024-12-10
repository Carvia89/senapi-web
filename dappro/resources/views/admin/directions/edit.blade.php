@extends('layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Directions</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item">Administration</li>
          <li class="breadcrumb-item active">Directions</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Modification Directions</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-2" action="{{ route('admin.direction.update', $direction->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="col-md-12">
                        <label for="designation" class="form-label">Désignation</label>
                        <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" id="designation" value="{{ old('designation', $direction->designation) }}" required>
                        @error('designation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                  <div class="text-left">
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
