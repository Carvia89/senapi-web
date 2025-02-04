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
                                <h5>Vente des bulletins scolaires</h5>
                            </div>
                            <div class="card-block">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form class="vstack gap-3" action="{{ route('admin.livraison-Vente.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row mt-3 align-items-center">
                                        <div class="col-md-6">
                                            <h4 class="sub-title">Identifiants de la Commande</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="prix_bulletin" class="col-sm-4 col-form-label">Prix du Bulletin</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="prix_bulletin" class="form-control form-control-round" id="prix_bulletin"
                                                           style="font-weight: bold; font-size: 1.2em; text-align: right;"
                                                           value="{{ number_format($dernierPrix, 2, ',', ' ') }} CDF"  readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="num_cmd" class="form-label">Numéro de la Commande *</label>
                                            <select name="num_cmd" class="form-control form-control-round @error('num_cmd') is-invalid @enderror" id="num_cmd">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($nums as $num)
                                                    <option value="{{ $num->num_cmd }}" {{ old('num_cmd') == $num->num_cmd ? 'selected' : '' }}>
                                                        {{ $num->num_cmd }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('num_cmd')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="montant_fact" class="form-label">Montant de la Facture</label>
                                            <input type="number" name="montant_fact" class="form-control form-control-round @error('montant_fact') is-invalid @enderror" id="montant_fact"
                                                style="font-weight: bold; font-size: 1.2em; text-align: right;" value="{{ old('montant_fact') }}" readonly>
                                            @error('montant_fact')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="type_cmd" class="form-label">Type Commande</label>
                                            <input type="text" name="type_cmd" class="form-control form-control-round @error('type_cmd') is-invalid @enderror" id="type_cmd"
                                                style="font-weight: bold; font-size: 1.2em; text-align: right;" value="{{ old('type_cmd') }}" readonly>
                                            @error('type_cmd')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-6 col-sm-6">
                                            <label for="montant_paye" class="form-label">Montant Payé (CDF)</label>
                                            <input type="number" name="montant_paye" class="form-control form-control-round @error('montant_paye') is-invalid @enderror" id="montant_paye"
                                                style="font-weight: bold; font-size: 1.2em; text-align: right;" value="{{ old('montant_paye') }}">
                                            @error('montant_paye')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label for="caissier_id" class="form-label">Nom du Caissier</label>
                                            <input type="text" name="caissier_id" class="form-control form-control-round @error('caissier_id') is-invalid @enderror" id="caissier_id"
                                                style="font-size: 1.2em; text-align: center;" value="{{ $user->prenom }} {{ $user->name }}" readonly>
                                            @error('caissier_id')
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

                                <script>
                                    document.getElementById('num_cmd').addEventListener('change', function() {
                                        const selectedNumCmd = this.value;

                                        if (selectedNumCmd) {
                                            fetch(`/get-details-command/${selectedNumCmd}`)
                                                .then(response => {
                                                    if (!response.ok) {
                                                        throw new Error('Network response was not ok');
                                                    }
                                                    return response.json();
                                                })
                                                .then(data => {
                                                    const formattedTotalQteSortie = data.totalQteSortie.toLocaleString('fr-FR');
                                                    const montantFact = {{ $dernierPrix }} * data.totalQteSortie; // Utiliser le dernier prix passé à la vue
                                                    const formattedMontantFact = montantFact.toLocaleString('fr-FR');
                                                    
                                                    document.getElementById('montant_fact').value = formattedMontantFact;
                                                    document.getElementById('type_cmd').value = data.type_cmd;
                                                })
                                                .catch(error => console.error('Error:', error));
                                        } else {
                                            document.getElementById('montant_fact').value = '';
                                            document.getElementById('type_cmd').value = '';
                                        }
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Détails de la Commande</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive mt-4">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Num. Cmd</th>
                                                <th>Client</th>
                                                <th>Qté Cmdée</th>
                                                <th>Qté Livrée</th>
                                                <th>Date Livraison</th>
                                                <th>Etat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($enregistrements as $index => $enregistrement)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $enregistrement->num_cmd }}</td>
                                                    <td>{{ $enregistrement->client->designation ?? 'Aucun' }}</td>
                                                    <td>
                                                        <span class="badge bg-danger">
                                                            {{ number_format($enregistrement->total_qte_cmdee, 0, ',', ' ') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success">
                                                            {{ number_format($enregistrement->total_qte_sortie, 0, ',', ' ') }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $enregistrement->first_date_sortie ? \Carbon\Carbon::parse($enregistrement->first_date_sortie)->format('d-m-Y') : 'N/A' }}</td>
                                                    <td>
                                                        @if ($enregistrement->etat_cmd)
                                                            <span class="badge bg-danger">en traitement</span>
                                                        @else
                                                            <span class="badge bg-danger">Fermée</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $enregistrements->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="styleSelector"></div>
        </div>
    </div>
</div>
@endsection