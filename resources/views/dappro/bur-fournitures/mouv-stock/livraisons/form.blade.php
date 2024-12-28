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
                                    <h5>Identifiants de la Commande</h5>
                                </div>
                                <div class="card-block">

                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form class="vstack gap-3" action="{{ route('admin.sortie-Fourniture.store') }}"
                                        method="POST">

                                        @csrf
                                        @method('POST')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
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
                                            <div class="col-md-6 col-sm-6">
                                                <label for="qte_cmdee" class="form-label">Quantité Totale Commandée </label>
                                                <input type="text" name="qte_cmdee" class="form-control form-control-round
                                                @error('qte_cmdee') is-invalid @enderror" id="qte_cmdee"
                                                style="font-weight: bold; font-size: 1.2em; text-align: right;"
                                                value="{{ old('qte_cmdee') }}" readonly>
                                                @error('qte_cmdee')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <script>
                                            document.getElementById('num_cmd').addEventListener('change', function() {
                                                const selectedNumCmd = this.value;

                                                if (selectedNumCmd) {
                                                    fetch(`/get-quantity/${selectedNumCmd}`)
                                                        .then(response => {
                                                            if (!response.ok) {
                                                                throw new Error('Network response was not ok');
                                                            }
                                                            return response.json();
                                                        })
                                                        .then(data => {
                                                            // Formater le nombre avec séparateur de milliers
                                                            const formattedQuantity = new Intl.NumberFormat('fr-FR', {
                                                                minimumFractionDigits: 0,
                                                                maximumFractionDigits: 0
                                                            }).format(data.total_qte_cmdee);

                                                            document.getElementById('qte_cmdee').value = formattedQuantity; // Mettre à jour le champ avec le nombre formaté
                                                        })
                                                        .catch(error => console.error('Error:', error));
                                                } else {
                                                    document.getElementById('qte_cmdee').value = ''; // Réinitialiser si aucune commande sélectionnée
                                                }
                                            });
                                        </script>
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

                        <div class="col-sm-12">
                            <!-- Section tableau de commandes -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Détails de la Commande</h5>
                                </div>
                                <div class="card-block">
                                    <!-- Section 3: Tableau des Enregistrements -->
                                    <div class="table-responsive mt-4">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Client</th>
                                                    <th>Option</th>
                                                    <th>Classe</th>
                                                    <th>Qté Cmdée</th>
                                                    <th>Qté livrée</th>
                                                    <th>Date livraison</th>
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
                                                        <td>{{ \Carbon\Carbon::parse($enregistrement->date_sortie)->format('d-m-Y') }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-end mb-3">
                                                                <a href="{{ route('admin.sortie-Fourniture.edit', $enregistrement) }}"
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
                                            <form action="{{ route('admin.panier.sortie') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-round">
                                                    <i class="fas fa-paper-plane"></i> Livrer
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
                                <!-- Basic Form Inputs card end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main-body end -->
        <div id="styleSelector">
        </div>
    </div>
@endsection
