@extends('dappro.layouts.fournitures.template')

@section('content')
    <div id="pcoded" class="pcoded">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Modifier l'Approvisionnement en Stock</h5>
                                    <a href="{{ route('admin.entree-Fourniture.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.entree-Fourniture.update', $entreeFourniture->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="date_entree" class="form-label">Date Entrée *</label>
                                                <input type="date" name="date_entree"
                                                    class="form-control form-control-round
                                                        @error('date_entree') is-invalid @enderror"
                                                            id="date_entree" value="{{ old('date_entree', $entreeFourniture->date_entree) }}">
                                                @error('date_entree')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="fournisseur_id" class="form-label">Fournisseur *</label>
                                                <select name="fournisseur_id" class="form-control form-control-round
                                                    @error('fournisseur_id') is-invalid @enderror" id="fournisseur_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($fournisseurs as $fournisseur)
                                                    <option value="{{ $fournisseur->id }}" {{ $entreeFourniture->fournisseur_id == $fournisseur->id ? 'selected' : '' }}>
                                                        {{ $fournisseur->nom }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                @error('fournisseur_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="option_id" class="form-label">Option *</label>
                                                <select name="option_id" class="form-control form-control-round
                                                    @error('option_id') is-invalid @enderror" id="option_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($options as $option)
                                                    <option value="{{ $option->id }}" {{ $entreeFourniture->option_id == $option->id ? 'selected' : '' }}>
                                                        {{ $option->designation }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                @error('option_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="classe_id" class="form-label">Classe *</label>
                                                <select name="classe_id" class="form-control form-control-round
                                                    @error('classe_id') is-invalid @enderror" id="classe_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($classes as $classe)
                                                    <option value="{{ $classe->id }}" {{ $entreeFourniture->classe_id == $classe->id ? 'selected' : '' }}>
                                                        {{ $classe->designation }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                @error('classe_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="quantiteRecu" class="form-label">Quantité *</label>
                                                <input type="number" name="quantiteRecu"
                                                    class="form-control form-control-round
                                                        @error('quantiteRecu') is-invalid @enderror"
                                                            id="quantiteRecu" value="{{ old('quantiteRecu', $entreeFourniture->quantiteRecu) }}">
                                                @error('quantiteRecu')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="reception" class="form-label">Réceptionné par *</label>
                                                <input type="text" name="reception"
                                                    class="form-control form-control-round
                                                        @error('reception') is-invalid @enderror"
                                                            id="reception" value="{{ old('reception', $entreeFourniture->reception) }}">
                                                @error('reception')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-12 col-sm-12">
                                                <label for="description" class="form-label">Description *</label>
                                                <textarea name="description" class="form-control form-control-round
                                                    @error('description') is-invalid @enderror" id="description" rows="3">
                                                    {{ old('description', $entreeFourniture->description) }}
                                                </textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-check"></i> Mettre à jour
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
