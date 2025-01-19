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
                                    <h5>Enregistrement Quantité Livraison</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.livraison-Vente.update', $panier->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <!-- Section 1: Identifiants de la Commande -->
                                            <div class="col-md-6">
                                                <h4 class="sub-title">Identifiants de la Commande</h4>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="num_cmd" class="form-label">Num. Commande </label>
                                                        <input type="text" name="num_cmd" class="form-control form-control-round"
                                                            id="num_cmd" value="{{ $panier->commandeVente->num_cmd }}" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="category_cmd" class="form-label">Catégorie </label>
                                                        <input type="text" name="category_cmd" class="form-control form-control-round"
                                                            id="category_cmd" value="{{ $panier->category_cmd }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-12 col-sm-12">
                                                        <label for="client_id" class="form-label">Client </label>
                                                        <input type="text" name="client_id" class="form-control form-control-round"
                                                            id="client_id" value="{{ $panier->client->designation }}" readonly>
                                                        @error('client_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="option_id" class="form-label">Option </label>
                                                        <input type="text" name="option_id" class="form-control form-control-round"
                                                            id="option_id" value="{{ $panier->methodOption->designation }}" readonly>
                                                        @error('option_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="classe_id" class="form-label">Classe </label>
                                                        <input type="text" name="classe_id" class="form-control form-control-round"
                                                            id="classe_id" value="{{ $panier->classe->designation }}" readonly>
                                                        @error('classe_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Section 2: Détails sur les Articles -->
                                            <div class="col-md-6">
                                                <h4 class="sub-title">Détails sur l'article</h4>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-12 col-sm-12">
                                                        <label for="qte_cmdee" class="form-label">Quantité Commandée </label>
                                                        <input type="number" name="qte_cmdee" class="form-control form-control-round"
                                                            id="qte_cmdee" value="{{ number_format($panier->qte_cmdee, 0, ',', ' ') }}"
                                                            style="text-align: right" readonly>
                                                        @error('qte_cmdee')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="qte_sortie" class="form-label">Quantité à livrer *</label>
                                                        <input type="number" name="qte_sortie" class="form-control form-control-round
                                                            @error('qte_sortie') is-invalid @enderror"
                                                            id="qte_sortie" value="{{ old('qte_sortie', $panier->qte_livree) }}"
                                                            style="border: 2px solid green;">
                                                        @error('qte_sortie')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="solde" class="form-label">Stock disponible à la livraison</label>
                                                        <input type="number" class="form-control form-control-round" id="solde"
                                                            value="{{ number_format($solde, 0, ',', ' ') }}"
                                                            style="font-weight: bold; font-size: 1.2em; text-align: right;" readonly>
                                                        @error('solde')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-12 col-sm-12">
                                                        <label for="date_sortie" class="form-label">Date livraison *</label>
                                                        <input type="date" name="date_sortie" class="form-control form-control-round
                                                            @error('date_sortie') is-invalid @enderror" id="date_sortie"
                                                            value="{{ old('date_sortie', session('date_sortie', '')) }}"
                                                            style="border: 2px solid green;">
                                                        @error('date_sortie')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-save"></i> Mettre à Jour
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        </div>
    </div>
@endsection
