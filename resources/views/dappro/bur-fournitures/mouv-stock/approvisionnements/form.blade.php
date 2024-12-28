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
                                    <h5>Réapprovisionnement en Stock Bulletins</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.entree-Fourniture.store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                            @if(session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        <div class="row">
                                            <!-- Section 1: Identifiants de la Commande -->
                                            <div class="col-md-6">
                                                <h4 class="sub-title">Informations Générales</h4>
                                                <div class="form-group row mt-3">
                                                    <div class="col-md-12 col-sm-12">
                                                        <label for="fournisseur_id" class="form-label">Fournisseur *</label>
                                                        <select name="fournisseur_id" class="form-control form-control-round
                                                            @error('fournisseur_id') is-invalid @enderror" id="fournisseur_id">
                                                            <option value="">Sélectionnez...</option>
                                                            @foreach ($fournisseurs as $fournisseur)
                                                                <option value="{{ $fournisseur->id }}"
                                                                    {{ old('fournisseur_id', session('fournisseur_id', '')) == $fournisseur->id ? 'selected' : '' }}>
                                                                    {{ $fournisseur->nom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('fournisseur_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <label for="date_entree" class="form-label">Date Entrée *</label>
                                                        <input type="date" name="date_entree" class="form-control form-control-round
                                                            @error('date_entree') is-invalid @enderror" id="date_entree"
                                                            value="{{ old('date_entree', session('date_entree', '')) }}" >
                                                        @error('date_entree')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <label for="description" class="form-label">Description </label>
                                                        <input type="text" name="description" class="form-control form-control-round
                                                            @error('description') is-invalid @enderror" id="description"
                                                            value="{{ old('description', session('description', '')) }}" >
                                                        @error('description')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <label for="reception" class="form-label">Réceptionné Par </label>
                                                        <input type="text" name="reception" class="form-control form-control-round
                                                            @error('reception') is-invalid @enderror" id="reception"
                                                            value="{{ old('reception', session('reception', '')) }}" >
                                                        @error('reception')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Section 2: Détails sur les Articles -->
                                            <div class="col-md-6">
                                                <h4 class="sub-title">Informations Spécifiques</h4>
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
                                                    <label for="quantiteRecu" class="form-label">Quantité Réçue *</label>
                                                    <input type="number" name="quantiteRecu" class="form-control form-control-round
                                                        @error('quantiteRecu') is-invalid @enderror" id="quantiteRecu"
                                                        value="{{ old('quantiteRecu') }}">
                                                    @error('quantiteRecu')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-check"></i> Enregistrer
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
                                    <h5>Tableau de réapprovisionnement en stock</h5>
                                </div>
                                <div class="card-block">
                                        <!-- Section 3: Tableau des Enregistrements -->
                                    <div class="table-responsive mt-4">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Fournisseur</th>
                                                    <th>Option</th>
                                                    <th>Classe</th>
                                                    <th>Qté réçue</th>
                                                    <th>Date Entrée</th>
                                                    <th class="d-flex justify-content-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($entreeFournitures as $enregistrement)
                                                    <tr>
                                                        <td>{{ $enregistrement->fournisseur->nom }}</td>
                                                        <td>{{ $enregistrement->methodOption->designation ?? 'Aucun' }}</td>
                                                        <td>{{ $enregistrement->classe->designation ?? 'Aucun' }}</td>
                                                        <td>{{ number_format($enregistrement->quantiteRecu, 0, ',', ' ') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($enregistrement->date_entree)->format('d-m-Y') }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-end mb-3">
                                                                <a href="{{ route('admin.entree-Fourniture.edit', $enregistrement) }}"
                                                                    title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('admin.entree-Fourniture.destroy', $enregistrement) }}"
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
                                    <!-- Pagination -->
                                    {{ $entreeFournitures->links() }}
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
