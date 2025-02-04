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
                                    <h5>Enregistrements Mot de Référence d'imputation</h5>
                                    <a href="{{ route('admin.mot-cle-imputation.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.mot-cle-imputation.store') }}"
                                        method="POST" enctype="multipart/form-data">

                                        @csrf
                                        @method('POST')

                                        <div class="form-group row mt-3">
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
                                        <div class="form-group row mt-3">
                                            <div class="col-md-12 col-sm-12">
                                                <label for="designation" class="form-label">* Mot de Référence </label>
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
