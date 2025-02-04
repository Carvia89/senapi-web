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
                                    <h5>Modification des Bénéficiaires</h5>
                                    <a href="{{ route('admin.beneficiaire.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.beneficiaire.update', $beneficiaire->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="nom" class="form-label">Nom *</label>
                                                <input type="text" name="nom"
                                                    class="form-control form-control-round
                                                        @error('nom') is-invalid @enderror"
                                                        id="nom" value="{{ old('nom', $beneficiaire->nom) }}">
                                                @error('nom')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="bureau_id" class="form-label">Bureau d'appartenance </label>
                                                <select name="bureau_id" class="form-control form-control-round
                                                    @error('bureau_id') is-invalid @enderror" id="bureau_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($bureaus as $bureau)
                                                    <option value="{{ $bureau->id }}" {{ $beneficiaire->bureau_id == $bureau->id ? 'selected' : '' }}>
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
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-12 col-sm-12">
                                                <label for="description" class="form-label">Description </label>
                                                <input type="text" name="description"
                                                    class="form-control form-control-round
                                                        @error('description') is-invalid @enderror"
                                                    id="description" value="{{ old('description', $beneficiaire->description) }}">
                                                @error('description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-check"></i> Mettre à Jour
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
