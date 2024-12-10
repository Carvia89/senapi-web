@extends('layouts.template')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Utilisateurs</h1>
      <nav class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item">Administration</li>
          <li class="breadcrumb-item active">Utilisateurs</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Mise à jour Utilisateurs</h5>

                <!-- Horizontal Form -->
                <form class="vstack gap-3" action="{{ route('admin.Utilisateur.update', $user->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nom</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $user->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" id="prenom" value="{{ $user->prenom }}">
                                    @error('prenom')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="bureau_id" class="form-label">Bureau</label>
                                <select id="bureau_id" class="form-select @error('bureau_id') is-invalid @enderror" name="bureau_id">
                                <option selected>Sélectionnez...</option>
                                @foreach ($bureaus as $bureau)
                                    <option value="{{ $bureau->id }}" {{ old('bureau_id', $user->bureau_id) == $bureau->id ? 'selected' : '' }}>{{ $bureau->designation }}</option>
                                @endforeach
                                </select>
                                <div style="color: red;">
                                    @error('bureau_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $user->email }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password" class="form-label">Mot de Passe</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" value="{{ $user->password }}">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="role" class="form-group">Rôle attribué</label>
                                <select id="role" class="form-select @error('role') is-invalid @enderror" name="role">
                                <option selected>Sélectionnez...</option>
                                <option>Admin</option>
                                <option>User</option>
                                <option>Super-Utilisateur</option>
                                </select>
                                @error('role')
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
