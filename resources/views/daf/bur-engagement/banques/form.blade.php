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
                                    <h5>Enregistrement des Banques associées</h5>
                                    <a href="{{ route('admin.banque-senapi.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.banque-senapi.store') }}"
                                        method="POST">

                                        @csrf
                                        @method('POST')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="designation" class="form-label">Désignation *</label>
                                                <input type="text" name="designation"
                                                    class="form-control form-control-round
                                                        @error('designation') is-invalid @enderror"
                                                        id="designation" value="{{ old('designation') }}">
                                                @error('designation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="devise_compte" class="form-label">Dévise du Compte *</label>
                                                <select name="devise_compte" class="form-control form-control-round @error('devise_compte') is-invalid @enderror" id="devise_compte">
                                                    <option value="">Sélectionnez...</option>
                                                    <option value="USD">USD</option>
                                                    <option value="CDF">CDF</option>
                                                </select>
                                                @error('devise_compte')
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
