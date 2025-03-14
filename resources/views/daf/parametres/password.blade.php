@extends('daf.layouts.template')

@section('content')
    <div id="pcoded" class="pcoded">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if (Session('success'))
                                <div class="alert alert-success d-flex align-items-center">
                                    <i class="fas fa-hand-thumbs-up-fill me-2"></i>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Paramètre de modification du mot de passe</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.password.changed') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6 position-relative">
                                                <label for="current_password" class="form-label">* Mot de passe actuel </label>
                                                <input type="password" name="current_password"
                                                    class="form-control form-control-round @error('current_password') is-invalid @enderror"
                                                    id="current_password" value="{{ old('current_password') }}"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                                <i class="fas fa-eye-slash toggle-password" onclick="togglePasswordVisibility('current_password')"></i>
                                                @error('current_password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6 position-relative">
                                                <label for="new_password" class="form-label">* Nouveau mot de passe </label>
                                                <input type="password" name="new_password"
                                                    class="form-control form-control-round @error('new_password') is-invalid @enderror"
                                                    id="new_password" value="{{ old('new_password') }}"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                                <i class="fas fa-eye-slash toggle-password" onclick="togglePasswordVisibility('new_password')"></i>
                                                @error('new_password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6 position-relative">
                                                <label for="confirm_password" class="form-label">* Confirmer nouveau mot de passe </label>
                                                <input type="password" name="new_password_confirmation"
                                                    class="form-control form-control-round @error('new_password_confirmation') is-invalid @enderror"
                                                    id="confirm_password" value="{{ old('new_password_confirmation') }}"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                                <i class="fas fa-eye-slash toggle-password" onclick="togglePasswordVisibility('confirm_password')"></i>
                                                @error('new_password_confirmation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <h6 class="text-body">Mot de passe recommandé :</h6>
                                        <ul class="ps-4 mb-3">
                                            <li><i class="fas fa-circle me-2 small-circle"></i> Minimum 8 caractères - plus, c'est mieux</li>
                                            <li><i class="fas fa-circle me-2 small-circle"></i> Au moins un caractère minuscule</li>
                                            <li><i class="fas fa-circle me-2 small-circle"></i> Au moins un chiffre, symbole ou caractère blanc</li>
                                        </ul>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-save"></i> Sauvegarder
                                            </button>
                                        </div>
                                    </form>

                                    <script>
                                        function togglePasswordVisibility(inputId) {
                                            const input = document.getElementById(inputId);
                                            const icon = event.currentTarget;
                                            if (input.type === "password") {
                                                input.type = "text";
                                                icon.classList.remove("fa-eye-slash");
                                                icon.classList.add("fa-eye");
                                            } else {
                                                input.type = "password";
                                                icon.classList.remove("fa-eye");
                                                icon.classList.add("fa-eye-slash");
                                            }
                                        }
                                    </script>

                                    <style>
                                        .toggle-password {
                                            position: absolute;
                                            right: 30px; /* Ajustez cette valeur pour le positionnement */
                                            top: 70%; /* Centrer verticalement */
                                            transform: translateY(-50%); /* Ajuste pour centrer parfaitement */
                                            cursor: pointer;
                                            color: #666; /* Couleur de l'icône */
                                        }
                                        .small-circle {
                                            font-size: 0.6em; /* Ajustez la taille ici */
                                            line-height: 1; /* Aligne verticalement avec le texte */
                                        }
                                    </style>
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
