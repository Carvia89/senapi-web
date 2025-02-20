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
                                    <h5>Rapport sur les Dépenses</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.rap.recette.pdf') }}"
                                        method="GET">

                                        @csrf

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="dossier_id" class="form-label">Dossier </label>
                                                <select name="dossier_id" class="form-control form-control-round
                                                    @error('dossier_id') is-invalid @enderror" id="dossier_id">
                                                <option value="">Sélectionnez le dossier</option>
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
                                            <div class="col-md-6 col-sm-6">
                                                <label for="imputation_id" class="form-label">Code d'imputation </label>
                                                <select name="imputation_id" class="form-control form-control-round
                                                    @error('imputation_id') is-invalid @enderror" id="imputation_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($imputations as $imputation)
                                                    <option value="{{ $imputation->id }}" {{ old('imputation_id') == $imputation->id ? 'selected' : '' }}>
                                                        {{ $imputation->imputation }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                @error('imputation_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row mt-3">
                                            <div class="col-md-3 col-sm-3">
                                                <label for="date_debut" class="form-label">* Date début </label>
                                                <input type="date" name="date_debut"
                                                    class="form-control form-control-round
                                                        @error('date_debut') is-invalid @enderror"
                                                        id="date_debut" value="{{ old('date_debut') }}">
                                                @error('date_debut')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <label for="date_fin" class="form-label">* Date fin </label>
                                                <input type="date" name="date_fin"
                                                    class="form-control form-control-round
                                                        @error('date_fin') is-invalid @enderror"
                                                        id="date_fin" value="{{ old('date_fin') }}">
                                                @error('date_fin')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-check"></i> Valider
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector"></div>
    </div>
@endsection
