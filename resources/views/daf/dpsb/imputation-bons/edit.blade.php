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
                                    <h5>Imputation du Bon de Dépense</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.imputation-bon-depense.update', $bon->id) }}"
                                        method="POST" enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-4 col-sm-4">
                                                <label for="num_bon" class="form-label">Numéro Bon </label>
                                                <input type="text" name="num_bon"
                                                    class="form-control form-control-round
                                                        @error('num_bon') is-invalid @enderror"
                                                    id="num_bon" value="{{ $bon->num_bon }}" readonly>
                                                @error('num_bon')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="date_emission" class="form-label">Date Emission </label>
                                                <input type="date" name="date_emission"
                                                    class="form-control form-control-round
                                                        @error('date_emission') is-invalid @enderror"
                                                    id="date_emission" value="{{ $bon->date_emission }}" readonly>
                                                @error('date_emission')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="montant_bon" class="form-label">Montant </label>
                                                <input type="text" name="montant_bon"
                                                    class="form-control form-control-round
                                                        @error('montant_bon') is-invalid @enderror"
                                                    style="font-weight: bold; text-align: right"
                                                    id="montant_bon" value="{{ number_format($bon->montant_bon, 2, ',', ' ') }} CDF" readonly>
                                                @error('montant_bon')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-12 col-sm-12">
                                                <label for="motif" class="form-label">Libelle </label>
                                                <input type="text" name="motif"
                                                    class="form-control form-control-round
                                                        @error('motif') is-invalid @enderror"
                                                    id="motif" value="{{ $bon->motif }}" readonly>
                                                @error('motif')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="imputation_id" class="form-label">Code d'imputation </label>
                                                <select name="imputation_id" class="form-control form-control-round
                                                    @error('imputation_id') is-invalid @enderror" id="imputation_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($imputations as $imput)
                                                    <option value="{{ $imput->id }}" {{ $bon->imputation_id == $imput->id ? 'selected' : '' }}>
                                                        {{ $imput->imputation }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                @error('imputation_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="nature" class="form-label">Nature </label>
                                                <input type="text" name="nature"
                                                    class="form-control form-control-round
                                                        @error('nature') is-invalid @enderror"
                                                    id="nature" value=" " readonly>
                                                @error('nature')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-check"></i> Imputer
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const imputationSelect = document.getElementById('imputation_id');
        const natureInput = document.getElementById('nature');

        imputationSelect.addEventListener('change', function() {
            const imputationId = this.value;

            if (imputationId) {
                // Faire une requête AJAX pour récupérer la nature
                fetch(`/imputation/nature/${imputationId}`)
                    .then(response => response.json())
                    .then(data => {
                        natureInput.value = data.nature; // Mettre à jour le champ nature
                    })
                    .catch(error => console.error('Erreur:', error));
            } else {
                natureInput.value = ''; // Réinitialiser si aucune imputation n'est sélectionnée
            }
        });
    });
    </script>
@endsection
