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
                                    <h5>Modifier l'Article du Panier</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.commande-Externe.update', $panier->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <!-- Section 1: Identifiants de la Commande -->
                                            <div class="col-md-6">
                                                <h4 class="sub-title">Identifiants de la Commande</h4>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="num_cmd" class="form-label">Num. Commande *</label>
                                                        <input type="text" name="num_cmd" class="form-control form-control-round"
                                                            id="num_cmd" value="{{ $panier->num_cmd }}" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="category_cmd" class="form-label">Catégorie *</label>
                                                        <input type="text" name="category_cmd" class="form-control form-control-round"
                                                            id="category_cmd" value="{{ $category_cmd }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="type_cmd" class="form-label">Type Commande *</label>
                                                        <select name="type_cmd" class="form-control form-control-round
                                                            @error('type_cmd') is-invalid @enderror" id="type_cmd">
                                                            <option value="">Sélectionnez...</option>
                                                            <option value="P" {{ $panier->type_cmd == 'P' ? 'selected' : '' }}>
                                                                Payant
                                                            </option>
                                                            <option value="G" {{ $panier->type_cmd == 'G' ? 'selected' : '' }}>
                                                                Gratuit
                                                            </option>
                                                        </select>
                                                        @error('type_cmd')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="client_id" class="form-label">Client *</label>
                                                        <select name="client_id" class="form-control form-control-round
                                                            @error('client_id') is-invalid @enderror" id="client_id">
                                                            <option value="">Sélectionnez...</option>
                                                            @foreach ($clients as $client)
                                                                <option value="{{ $client->id }}" {{ $panier->client_id == $client->id ? 'selected' : '' }}>
                                                                    {{ $client->designation }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('client_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="date_cmd" class="form-label">Date Commande *</label>
                                                        <input type="date" name="date_cmd" class="form-control form-control-round
                                                            @error('date_cmd') is-invalid @enderror" id="date_cmd"
                                                            value="{{ $panier->date_cmd }}">
                                                        @error('date_cmd')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="libelle" class="form-label">Libelle Commande *</label>
                                                        <input type="text" name="libelle" class="form-control form-control-round
                                                            @error('libelle') is-invalid @enderror" id="libelle" value="{{ $panier->libelle }}">
                                                        @error('libelle')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Section 2: Détails sur les Articles -->
                                            <div class="col-md-6">
                                                <h4 class="sub-title">Détails sur les Articles</h4>
                                                <div class="form-group">
                                                    <label for="option_id" class="form-label">Option *</label>
                                                    <select name="option_id" class="form-control form-control-round
                                                        @error('option_id') is-invalid @enderror" id="option_id">
                                                        <option value="">Sélectionnez...</option>
                                                        @foreach ($options as $option)
                                                            <option value="{{ $option->id }}" {{ $panier->option_id == $option->id ? 'selected' : '' }}>
                                                                {{ $option->designation }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('option_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="classe_id" class="form-label">Classe *</label>
                                                    <select name="classe_id" class="form-control form-control-round
                                                        @error('classe_id') is-invalid @enderror" id="classe_id">
                                                        <option value="">Sélectionnez...</option>
                                                        @foreach ($kelasis as $kelasi)
                                                            <option value="{{ $kelasi->id }}" {{ $panier->classe_id == $kelasi->id ? 'selected' : '' }}>
                                                                {{ $kelasi->designation }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('classe_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="qte_cmdee" class="form-label">Quantité Commandée *</label>
                                                    <input type="number" name="qte_cmdee" class="form-control form-control-round
                                                        @error('qte_cmdee') is-invalid @enderror" id="qte_cmdee" value="{{ $panier->qte_cmdee }}">
                                                    @error('qte_cmdee')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
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
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Panier des articles</h5>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive mt-4">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Num. Cmd</th>
                                                    <th>Client</th>
                                                    <th>Option</th>
                                                    <th>Classe</th>
                                                    <th>Qté Cmdée</th>
                                                    <th>Date Commande</th>
                                                    <th class="d-flex justify-content-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($enregistrements as $enregistrement)
                                                    <tr>
                                                        <td>{{ $enregistrement->num_cmd }}</td>
                                                        <td>{{ $enregistrement->client->designation }}</td>
                                                        <td>{{ $enregistrement->methodOption->designation }}</td>
                                                        <td>{{ $enregistrement->classe->designation }}</td>
                                                        <td>{{ $enregistrement->qte_cmdee }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($enregistrement->date_cmd)->format('d-m-Y') }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-end mb-3">
                                                                <a href="{{ route('admin.commande-Externe.edit', $enregistrement->id) }}" title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('admin.commande-Externe.destroy', $enregistrement->id) }}" method="post">
                                                                    @csrf
                                                                    @method("delete")
                                                                    <button class="btn btn-danger btn-circle btn-sm" title="Supprimer">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <button type="submit" class="btn btn-primary btn-round">
                                            <i class="fas fa-check"></i> Valider le Panier
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
