@extends('daf.layouts.template')

@section('content')
    <div id="pcoded" class="pcoded">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Profil de l'utilisateur</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="#"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="name" class="form-label">Nom </label>
                                                <input type="text" name="name"
                                                    class="form-control form-control-round
                                                        @error('name') is-invalid @enderror"
                                                    id="name" value="{{ $nom }}" readonly>
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="prenom" class="form-label">Prénom </label>
                                                <input type="text" prenom="prenom"
                                                    class="form-control form-control-round
                                                        @error('prenom') is-invalid @enderror"
                                                    id="prenom" value="{{ $prenom }}" readonly>
                                                @error('prenom')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="email" class="form-label">Email </label>
                                                <input type="email" email="email"
                                                    class="form-control form-control-round
                                                        @error('email') is-invalid @enderror"
                                                    id="email" value="{{ $email }}" readonly>
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="role" class="form-label">Rôle </label>
                                                <input type="text" role="role"
                                                    class="form-control form-control-round
                                                        @error('role') is-invalid @enderror"
                                                    id="role" value="{{ $role }}" readonly>
                                                @error('role')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-4 col-sm-4">
                                                <label for="bureau_id" class="form-label">Bureau </label>
                                                <input type="text" bureau_id="bureau_id"
                                                    class="form-control form-control-round
                                                        @error('bureau_id') is-invalid @enderror"
                                                    id="bureau_id" value="{{ $bureau }}" readonly>
                                                @error('bureau_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="division_id" class="form-label">Division </label>
                                                <input type="text" division_id="division_id"
                                                    class="form-control form-control-round
                                                        @error('division_id') is-invalid @enderror"
                                                    id="division_id" value="{{ $division }}" readonly>
                                                @error('division_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="direction_id" class="form-label">Direction </label>
                                                <input type="text" direction_id="direction_id"
                                                    class="form-control form-control-round
                                                        @error('direction_id') is-invalid @enderror"
                                                    id="direction_id" value="{{ $direction }}" readonly>
                                                @error('direction_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Basic Form Inputs card end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector"></div>
    </div>
@endsection
