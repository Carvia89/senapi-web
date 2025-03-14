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
                                    <h5>Enregistrements des Recettes</h5>
                                    <a href="{{ route('admin.recettes-caisse.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.recettes-caisse.store') }}"
                                        method="POST">

                                        @csrf
                                        @method('POST')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="date_recette" class="form-label">* Date </label>
                                                <input type="date" name="date_recette"
                                                    class="form-control form-control-round
                                                        @error('date_recette') is-invalid @enderror"
                                                        id="date_recette" value="{{ session('date_recette', old('date_recette')) }}">
                                                @error('date_recette')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="montant_recu" class="form-label">* Montant Réçu</label>
                                                <input type="text" name="montant_recu"
                                                    class="form-control form-control-round
                                                        @error('montant_recu') is-invalid @enderror"
                                                        style="font-weight: bold; text-align: right"
                                                        id="montant_recu" value="{{ old('montant_recu') }}">
                                                @error('montant_recu')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-12 col-sm-12">
                                                <label for="libelle" class="form-label">* Libelle </label>
                                                <input type="text" name="libelle"
                                                    class="form-control form-control-round
                                                        @error('libelle') is-invalid @enderror"
                                                    id="libelle" value="{{ old('libelle') }}">
                                                @error('libelle')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="reference_imputation_id" class="form-label">* Mot clé </label>
                                                <select name="reference_imputation_id" class="form-control form-control-round
                                                    @error('reference_imputation_id') is-invalid @enderror" id="reference_imputation_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($referImputs as $referImput)
                                                    <option value="{{ $referImput->id }}" {{ old('reference_imputation_id') == $referImput->id ? 'selected' : '' }}>
                                                        {{ $referImput->designation }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                @error('reference_imputation_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="dossier_id" class="form-label">Dossier </label>
                                                <select name="dossier_id" class="form-control form-control-round
                                                    @error('dossier_id') is-invalid @enderror" id="dossier_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($dossiers as $dossier)
                                                    <option value="{{ $dossier->id }}" {{ old('dossier_id') == $dossier->id ? 'selected' : '' }}>
                                                        {{ $dossier->designation }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                @error('dossier_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-save"></i> Enregistrer
                                            </button>
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
