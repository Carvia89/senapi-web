@extends('dappro.layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Catégories Articles</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard.direction3')}}">Home</a></li>
          <li class="breadcrumb-item">Administration</li>
          <li class="breadcrumb-item active">Catégories Articles</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Modification Catégorie</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-2" action="{{ route('admin.categorieArticle.update', $catArticle->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="col-md-12">
                        <label for="designation" class="form-label">Unité</label>
                        <input type="text" name="designation" class="form-control" id="designation" value="{{ old('designation', $catArticle->designation) }}" required>
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
