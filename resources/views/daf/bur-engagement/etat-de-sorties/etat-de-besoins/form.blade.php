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
                                    <h5>Enregistrements des états de besoins</h5>
                                    <a href="{{ route('admin.numérisation-etat-de-besoin.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.numérisation-etat-de-besoin.store') }}"
                                        method="POST" enctype="multipart/form-data">

                                        @csrf
                                        @method('POST')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="bureau_id" class="form-label">Service Demandeur *</label>
                                                <select name="bureau_id" class="form-control form-control-round
                                                    @error('bureau_id') is-invalid @enderror" id="bureau_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($bureaus as $bureau)
                                                    <option value="{{ $bureau->id }}" {{ old('bureau_id') == $bureau->id ? 'selected' : '' }}>
                                                        {{ $bureau->designation }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                @error('bureau_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="dossier_id" class="form-label">Dossier d'impression </label>
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
                                        <div class="form-group row mt-3">
                                            <div class="col-md-4 col-sm-4">
                                                <label for="date_reception" class="form-label">Date Réception </label>
                                                <input type="date" name="date_reception"
                                                    class="form-control form-control-round
                                                        @error('date_reception') is-invalid @enderror"
                                                    id="date_reception" value="{{ old('date_reception') }}">
                                                @error('date_reception')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="montant" class="form-label">* Montant </label>
                                                <input type="float" name="montant"
                                                    class="form-control form-control-round
                                                        @error('montant') is-invalid @enderror"
                                                        style="text-align: right; font-weight: bold;"
                                                    id="montant" value="{{ old('montant') }}">
                                                @error('montant')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="fichier" class="form-label">Fichier PDF *</label>
                                                <input type="file" name="fichier"
                                                    class="form-control form-control-round
                                                        @error('fichier') is-invalid @enderror"
                                                    id="fichier" value="{{ old('fichier') }}">
                                                @error('fichier')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-12 col-sm-12">
                                                <label for="description" class="form-label">Description </label>
                                                <input type="text" name="description"
                                                    class="form-control form-control-round
                                                        @error('description') is-invalid @enderror"
                                                    id="description" value="{{ old('description') }}">
                                                @error('description')
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
