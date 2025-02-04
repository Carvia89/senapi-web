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
                                <h5>Identifiants de l'article</h5>
                            </div>
                            <div class="card-block">
                                <form class="vstack gap-3" action="#" method="GET">
                                    @csrf
                                    @method('GET')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="classe_id" class="form-label">Classe *</label>
                                                <select name="classe_id" class="form-control form-control-round
                                                    @error('classe_id') is-invalid @enderror" id="classe_id">
                                                    <option value="">Sélectionnez...</option>
                                                    @foreach ($kelasis as $kelasi)
                                                        <option value="{{ $kelasi->id }}" {{ old('classe_id') == $kelasi->id ? 'selected' : '' }}>
                                                            {{ $kelasi->designation }}
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
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Situation Générale en stock</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive mt-4">
                                    <table class="table table-hover" id="stockTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Classe</th>
                                                <th>Option</th>
                                                <th>Stock Début</th>
                                                <th>Entrée</th>
                                                <th>Sortie</th>
                                                <th style="font-weight: bold; font-size: 1.2em; text-align: right;">Solde</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($enregistrements as $enregistrement)
                                                <tr data-classe="{{ $enregistrement->classe_id }}" data-option="{{ $enregistrement->option_id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $kelasis->find($enregistrement->classe_id)->designation ?? 'N/A' }}</td>
                                                    <td>{{ $options->find($enregistrement->option_id)->designation ?? 'N/A' }}</td>
                                                    <td>{{ number_format($enregistrement->stock_debut, 0, ',', ' ') }}</td>
                                                    <td>{{ number_format($enregistrement->quantite_recue, 0, ',', ' ') }}</td>
                                                    <td>{{ number_format($enregistrement->qte_livree, 0, ',', ' ') }}</td>
                                                    <td style="font-weight: bold; font-size: 1.2em; text-align: right;">
                                                        {{ number_format($enregistrement->stock_debut + $enregistrement->quantite_recue - $enregistrement->qte_livree, 0, ',', ' ') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div>
                                        {{ $enregistrements->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer les sélecteurs
            const classeSelect = document.getElementById('classe_id');
            const optionSelect = document.getElementById('option_id');
            const stockTable = document.getElementById('stockTable');

            // Fonction pour filtrer les lignes
            function filterTable() {
                const selectedClasse = classeSelect.value;
                const selectedOption = optionSelect.value;

                // Boucle à travers toutes les lignes du tableau
                for (const row of stockTable.querySelectorAll('tbody tr')) {
                    const classeId = row.getAttribute('data-classe');
                    const optionId = row.getAttribute('data-option');

                    // Vérifie si la ligne doit être affichée
                    const showRow = (selectedClasse === '' || classeId === selectedClasse) &&
                                    (selectedOption === '' || optionId === selectedOption);

                    // Affiche ou masque la ligne
                    row.style.display = showRow ? '' : 'none';
                }
            }

            // Écoutez les changements dans les sélecteurs
            classeSelect.addEventListener('change', filterTable);
            optionSelect.addEventListener('change', filterTable);
        });
    </script>
@endsection
