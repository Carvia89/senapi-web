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
                                    <h5>Modifier la Dépense</h5>
                                    <a href="{{ route('admin.dépenses-avec-bons.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.dépenses-avec-bons.update', $depense->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')
                                        <h4 class="sub-title">Informations à remplir</h4>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-4 col-sm-4">
                                                <label for="date_depense" class="form-label">* Date </label>
                                                <input type="date" name="date_depense"
                                                    class="form-control form-control-round
                                                        @error('date_depense') is-invalid @enderror"
                                                    id="date_depense" value="{{ old('date_depense', $depense->date_depense) }}">
                                                @error('date_depense')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="bon_depense_id" class="form-label">* Numéro de Bon </label>
                                                <select name="bon_depense_id" class="form-control form-control-round
                                                    @error('bon_depense_id') is-invalid @enderror" id="bon_depense_id">
                                                    <option value="">Sélectionnez...</option>
                                                    @foreach ($bons as $bon)
                                                        <option value="{{ $bon->id }}" {{ $depense->bon_depense_id == $bon->id ? 'selected' : '' }}>
                                                            {{ $bon->num_bon }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('bon_depense_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="reference_imputation_id" class="form-label">* Mot clé </label>
                                                <select name="reference_imputation_id" class="form-control form-control-round
                                                    @error('reference_imputation_id') is-invalid @enderror" id="reference_imputation_id">
                                                    <option value="">Sélectionnez...</option>
                                                    @foreach ($referImputs as $referImput)
                                                        <option value="{{ $referImput->id }}" {{ $depense->reference_imputation_id == $referImput->id ? 'selected' : '' }}>
                                                            {{ $referImput->designation }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('reference_imputation_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <h4 class="sub-title">Informations liées aux bons</h4>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="imputation" class="form-label">Imputation</label>
                                                <input type="text" name="imputation"
                                                    class="form-control form-control-round
                                                        @error('imputation') is-invalid @enderror"
                                                    id="imputation" value=" " readonly>
                                                @error('imputation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="designation" class="form-label">Nature</label>
                                                <input type="text" name="designation"
                                                    class="form-control form-control-round
                                                        @error('designation') is-invalid @enderror"
                                                    id="designation" value=" " readonly>
                                                @error('designation')
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
                                                    id="motif" value=" " readonly>
                                                @error('motif')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-4 col-sm-4">
                                                <label for="montant_bon" class="form-label">Montant Bon </label>
                                                <input type="text" name="montant_bon"
                                                    class="form-control form-control-round @error('montant_bon') is-invalid @enderror"
                                                    id="montant_bon" value=" " readonly style="font-weight: bold; text-align: right;">
                                                @error('montant_bon')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="beneficiaire" class="form-label">Bénéficiaire </label>
                                                <input type="text" name="beneficiaire"
                                                    class="form-control form-control-round
                                                        @error('beneficiaire') is-invalid @enderror"
                                                    id="beneficiaire" value=" " readonly>
                                                @error('beneficiaire')
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
                                                    id="date_emission" value=" " readonly>
                                                @error('date_emission')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-save"></i> Mettre à Jour
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
            const bonDepenseSelect = document.getElementById('bon_depense_id');

            bonDepenseSelect.addEventListener('change', function() {
                const bonId = this.value;

                if (bonId) {
                    fetch(`/bons-de-depenses/${bonId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Formatage du montant_bon
                            const montantBon = parseFloat(data.montant_bon).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                            document.getElementById('montant_bon').value = montantBon;

                            document.getElementById('imputation').value = data.imputation;
                            document.getElementById('designation').value = data.designation;
                            document.getElementById('motif').value = data.motif;
                            document.getElementById('beneficiaire').value = data.beneficiaire;
                            document.getElementById('date_emission').value = data.date_emission;
                        })
                        .catch(error => console.error('Erreur:', error));
                } else {
                    // Réinitialiser les champs si aucune sélection
                    document.getElementById('imputation').value = '';
                    document.getElementById('designation').value = '';
                    document.getElementById('motif').value = '';
                    document.getElementById('montant_bon').value = '';
                    document.getElementById('beneficiaire').value = '';
                    document.getElementById('date_emission').value = '';
                }
            });
        });
    </script>
@endsection
