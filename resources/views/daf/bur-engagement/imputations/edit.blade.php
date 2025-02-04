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
                                    <h5>Modification de l'imputation</h5>
                                    <a href="{{ route('admin.imputation.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.imputation.update', $imput->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="imputation" class="form-label">Code d'imputation *</label>
                                                <input type="text" name="imputation"
                                                    class="form-control form-control-round
                                                        @error('imputation') is-invalid @enderror"
                                                        id="imputation" value="{{ old('imputation', $imput->imputation) }}">
                                                @error('imputation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-12 col-sm-12">
                                                <label for="designation" class="form-label">Libelle </label>
                                                <input type="text" name="designation"
                                                    class="form-control form-control-round
                                                        @error('designation') is-invalid @enderror"
                                                    id="designation" value="{{ old('designation', $imput->designation) }}">
                                                @error('designation')
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
