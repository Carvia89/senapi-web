@extends('dappro.layouts.fournitures.template')

@section('content')
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Basic Form Inputs card start -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Enregistrement du stock de départ</h5>
                                    <a href="{{ route('admin.stockDebut-Vente.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.stockDebut-Vente.store') }}"
                                        method="POST">

                                        @csrf
                                        @method('POST')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-12 col-sm-12">
                                                <label for="option_id" class="form-label">Option *</label>
                                                <select name="option_id" class="form-control form-control-round
                                                    @error('option_id') is-invalid @enderror" id="option_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($options as $option)
                                                    <option value="{{ $option->id }}" {{ old('option_id') == $option->id ? 'selected' : '' }}>
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
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="classe_id" class="form-label">Classe *</label>
                                                <select name="classe_id" class="form-control form-control-round
                                                    @error('classe_id') is-invalid @enderror" id="classe_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($classes as $classe)
                                                    <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
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
                                            <div class="col-md-6 col-sm-6">
                                                <label for="stock_debut" class="form-label">Stock Début *</label>
                                                <input type="number" name="stock_debut"
                                                    class="form-control form-control-round
                                                        @error('stock_debut') is-invalid @enderror"
                                                            id="stock_debut" value="{{ old('stock_debut') }}">
                                                @error('stock_debut')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-check"></i> Enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Basic Form Inputs card end -->
                        </div>
                    </div>
                </div>
                <!-- Page body end -->
            </div>
        </div>
        <!-- Main-body end -->
        <div id="styleSelector">
        </div>
    </div>
@endsection
