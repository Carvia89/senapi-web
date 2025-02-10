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
                                    <h5>Rapport Financier Journalier</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.rap.financier.pdf') }}"
                                        method="GET">

                                        @csrf

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="date_jour" class="form-label">* Date du Jour </label>
                                                <input type="date" name="date_jour"
                                                    class="form-control form-control-round
                                                        @error('date_jour') is-invalid @enderror"
                                                        id="date_jour" value="{{ old('date_jour') }}">
                                                @error('date_jour')
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

                        <!-- Rapport Périodique -->

                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Rapport Financier Périodique</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.rap.periodique.pdf') }}"
                                        method="GET">

                                        @csrf

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
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
                                            <div class="col-md-6 col-sm-6">
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
                            <!-- Basic Form Inputs card end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector"></div>
    </div>
@endsection
