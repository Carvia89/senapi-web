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
                                    <h5>Ajout des articles au panier</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.commande-Externe.store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')

                                        <div class="row">
                                            <!-- Section 1: Identifiants de la Commande -->
                                            <div class="col-md-6">
                                                <h4 class="sub-title">Identifiants de la Commande</h4>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="num_cmd" class="form-label">Num. Commande *</label>
                                                        <input type="text" name="num_cmd" class="form-control form-control-round
                                                            @error('num_cmd') is-invalid @enderror" id="num_cmd"
                                                            value="{{ $num_cmd }}" readonly>
                                                        @error('num_cmd')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="category_cmd" class="form-label">Catégorie *</label>
                                                        <input type="text" name="category_cmd" class="form-control form-control-round
                                                            @error('category_cmd') is-invalid @enderror" id="category_cmd"
                                                            value="{{ $category_cmd }}" readonly>
                                                        @error('category_cmd')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="type_cmd" class="form-label">Type Commande *</label>
                                                        <select name="type_cmd" class="form-control form-control-round
                                                            @error('type_cmd') is-invalid @enderror" id="type_cmd">
                                                            <option value="">Sélectionnez...</option>
                                                            <option value="P" {{ old('type_cmd', session('type_cmd', '')) == 'P' ? 'selected' : '' }}>
                                                                Payant
                                                            </option>
                                                            <option value="G" {{ old('type_cmd', session('type_cmd', '')) == 'G' ? 'selected' : '' }}>
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
                                                                <option value="{{ $client->id }}"
                                                                    {{ old('client_id', session('client_id', '')) == $client->id ? 'selected' : '' }}>
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
                                                            value="{{ old('date_cmd', session('date_cmd', '')) }}">
                                                        @error('date_cmd')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label for="libelle" class="form-label">Libelle Commande *</label>
                                                        <input type="text" name="libelle" class="form-control form-control-round
                                                            @error('libelle') is-invalid @enderror" id="libelle"
                                                            value="{{ old('libelle', session('libelle', '')) }}">
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
                                                            <option value="{{ $option->id }}" {{ old('option_id') == $option->id ? 'selected' : '' }}>
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
                                                            <option value="{{ $kelasi->id }}" {{ old('classe_id') == $kelasi->id ? 'selected' : '' }}>
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
                                                        @error('qte_cmdee') is-invalid @enderror" id="qte_cmdee"
                                                        value="{{ old('qte_cmdee') }}">
                                                    @error('qte_cmdee')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Champ caché pour gérer le pdf -->
                                        <input type="hidden" name="pdf_generated" id="pdf_generated" value="0">

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-cart-plus"></i> Ajouter au Panier
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Basic Form Inputs card end -->
                        </div>

                        <div class="col-sm-12">
                            <!-- Basic Form Inputs card start -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Panier des articles</h5>
                                </div>
                                <div class="card-block">

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.querySelector('button[type="submit"]').addEventListener('click', function() {
                                            document.getElementById('pdf_generated').value = "1";
                                        });
                                    });
                                </script>
                                        <!-- Section 3: Tableau des Enregistrements -->
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
                                                            <td>{{ $enregistrement->client->designation ?? 'Aucun' }}</td>
                                                            <td>{{ $enregistrement->methodOption->designation ?? 'Aucun' }}</td>
                                                            <td>{{ $enregistrement->classe->designation ?? 'Aucun' }}</td>
                                                            <td>{{ number_format($enregistrement->qte_cmdee, 0, ',', ' ') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($enregistrement->date_cmd)->format('d-m-Y') }}</td>
                                                            <td>
                                                                <div class="d-flex justify-content-end mb-3">
                                                                    <a href="{{ route('admin.commande-Externe.edit', $enregistrement) }}"
                                                                        title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('admin.commande-Externe.destroy', $enregistrement) }}"
                                                                        method="post">
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

                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <form action="{{ route('admin.commande.externe') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-round">
                                                        <i class="fas fa-check"></i> Valider le Panier
                                                    </button>
                                                </form>

                                                <div class="form-group">
                                                    <label for="total_bulletins" class="form-label">Qté Totale Cmdée *</label>

                                                    <span class="form-control form-control-round text-end" style="font-weight: bold; font-size: 1.2em; text-align: right;">
                                                        {{ number_format($totalBulletins ?? 0, 0, ',', ' ') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <!-- Basic Form Inputs card end -->
                        </div>
                    </div>
                </div>
                <!-- Page body end -->
            </div>
        </div>
        <!-- Main-body end -->
        <div id="styleSelector"></div>
    </div>
@endsection
