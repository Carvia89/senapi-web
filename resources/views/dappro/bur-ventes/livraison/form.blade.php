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
                                    <h5>Livraison des bulletins scolaires</h5>
                                    <a href="{{ route('admin.livraison-Vente.index') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-eye mr-2"></i>
                                        Voir la liste
                                    </a>
                                </div>
                                <div class="card-block">
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form class="vstack gap-3" action="{{ route('admin.livraison-Vente.store') }}" method="POST">
                                        @csrf
                                        <h4 class="sub-title">Identifiants de la Commande</h4>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-4 col-sm-4">
                                                <label for="num_cmd" class="form-label">Numéro de la Commande *</label>
                                                <select name="num_cmd" class="form-control form-control-round
                                                    @error('num_cmd') is-invalid @enderror" id="num_cmd">
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
                                                <label for="qte_cmdee" class="form-label">Quantité Totale Commandée</label>
                                                <input type="number" name="qte_cmdee" class="form-control form-control-round
                                                    @error('qte_cmdee') is-invalid @enderror" id="qte_cmdee"
                                                    style="font-weight: bold; font-size: 1.2em; text-align: right;"
                                                    value="{{ old('qte_cmdee') }}" readonly>
                                                @error('qte_cmdee')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="category_cmd" class="form-label">Catégorie Commande</label>
                                                <input type="text" name="category_cmd" class="form-control form-control-round
                                                    @error('category_cmd') is-invalid @enderror" id="category_cmd"
                                                    style="font-weight: bold; font-size: 1.2em; text-align: right;"
                                                    value="{{ old('category_cmd') }}" readonly>
                                                @error('category_cmd')
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
                                                fetch(`/get-command-details/${selectedNumCmd}`)
                                                    .then(response => {
                                                        if (!response.ok) {
                                                            throw new Error('Network response was not ok');
                                                        }
                                                        return response.json();
                                                    })
                                                    .then(data => {
                                                        // Formater la somme de qte_cmdee avec séparateur de milliers
                                                        const formattedTotalQte = data.totalQte.toLocaleString('fr-FR'); // Utiliser 'fr-FR' pour le format français
                                                        document.getElementById('qte_cmdee').value = formattedTotalQte; // Afficher la somme formatée
                                                        document.getElementById('category_cmd').value = data.category_cmd; // Afficher la catégorie de la commande
                                                    })
                                                    .catch(error => console.error('Error:', error));
                                            } else {
                                                document.getElementById('qte_cmdee').value = '';
                                                document.getElementById('category_cmd').value = '';
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
                                                    <th>Client</th>
                                                    <th>Option</th>
                                                    <th>Classe</th>
                                                    <th>Qté Cmdée</th>
                                                    <th>Qté livrée</th>
                                                    <th class="d-flex justify-content-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($enregistrements as $enregistrement)
                                                    <tr>
                                                        <td>{{ $enregistrement->client->designation ?? 'Aucun' }}</td>
                                                        <td>{{ $enregistrement->methodOption->designation ?? 'Aucun' }}</td>
                                                        <td>{{ $enregistrement->classe->designation ?? 'Aucun' }}</td>
                                                        <td>{{ number_format($enregistrement->qte_cmdee, 0, ',', ' ') }}</td>
                                                        <td>{{ number_format($enregistrement->qte_livree, 0, ',', ' ') }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-end mb-3">
                                                                <a href="{{ route('admin.livraison-Vente.edit', $enregistrement) }}"
                                                                    title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <form action="{{ route('admin.valide.livraison.vente') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-round">
                                                    <i class="fas fa-save"></i> Enregistrer
                                                </button>
                                            </form>

                                            <div class="form-group">
                                                <label for="total_bulletins" class="form-label">Qté Totale Livrée *</label>
                                                <span class="form-control form-control-round text-end" style="font-weight: bold; font-size: 1.2em; text-align: right;">
                                                    {{ number_format($totalBulletins ?? 0, 0, ',', ' ') }}
                                                </span>
                                            </div>
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
    </div>
@endsection
