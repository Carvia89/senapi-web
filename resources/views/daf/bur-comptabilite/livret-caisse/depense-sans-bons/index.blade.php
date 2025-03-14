@extends('daf.layouts.template')

@section('content')
<div id="pcoded" class="pcoded">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        @if (Session('success'))
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fas fa-hand-thumbs-up-fill me-2"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        @endif

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Journal des Dépenses (sans bons)</h5>
                                @if(auth()->user()->role !== 'Admin')
                                    <a href="{{ route('admin.dépenses-sans-bons.create') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-plus"></i> Nouvelle Dépense
                                    </a>
                                @endif
                            </div>
                            <div class="card-block">
                                <form action="{{ route('admin.dépenses-sans-bons.index') }}" method="GET">
                                    <div class="form-group row mt-3">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="reference_imputation_id" class="form-label">Mot clé *</label>
                                            <select name="reference_imputation_id" class="form-control form-control-round" id="reference_imputation_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($refImputs as $refImput)
                                                    <option value="{{ $refImput->referImput->id ?? '' }}">{{ $refImput->referImput->designation ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dossier_id" class="form-label">Dossier d'impression</label>
                                            <select name="dossier_id" class="form-control form-control-round" id="dossier_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($dossiers as $dossier)
                                                    <option value="{{ $dossier->dossier->id ?? '' }}">{{ $dossier->dossier->designation ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="date_depense" class="form-label">Date </label>
                                            <input type="date" name="date_depense" class="form-control form-control-round" id="date_depense"
                                            value="{{ request('date_depense') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="libelle" class="form-label">Libelle</label>
                                            <input type="text" name="libelle" class="form-control form-control-round" id="libelle"
                                            value="{{ request('libelle') }}" placeholder="Entrez un libellé">
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="montant_depense" class="form-label">Montant</label>
                                            <input type="text" name="montant_depense" class="form-control form-control-round" id="montant_depense"
                                            value="{{ request('montant_depense') }}">
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="user_id" class="form-label">Enregistré par</label>
                                            <input type="text" name="user_id" class="form-control form-control-round" id="user_id">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <button type="submit" class="btn btn-primary btn-round">Rechercher</button>
                                    </div>
                                </form><br>

                                <div id="etatBesoinsTable">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Libelle</th>
                                                <th>Montant (CDF)</th>
                                                <th>Mot clé</th>
                                                <!-- <th>Dossier</th> -->
                                                @if(auth()->user()->role !== 'Admin')
                                                    <th class="d-flex justify-content-end">Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($depenses as $depense)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($depense->date_depense)->format('d/m/Y') }}</td>
                                                    <td>{{ $depense->libelle }}</td>
                                                    <td class="no-wrap">{{ number_format($depense->montant_depense, 2, ',', ' ') }}</td>
                                                    <td>{{ $depense->referImput->designation ?? 'Aucun' }}</td>
                                                    <!-- <td>{{ $depense->dossier->designation ?? 'Aucun' }}</td> -->
                                                    <!-- Boutons d'actions conditionnels -->
                                                    @if(auth()->user()->role !== 'Admin')
                                                        <td>
                                                            <div class="d-flex justify-content-end mb-3">
                                                                <a href="{{ route('admin.dépenses-sans-bons.edit', $depense) }}"
                                                                    title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('admin.dépenses-sans-bons.destroy', $depense) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method("delete")
                                                                    <button class="btn btn-danger btn-circle btn-sm" title="Supprimer">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Pagination -->
                                    {{ $depenses->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector"></div>
    </div>

    <footer id="footer" class="footer">
        <div class="copyright">
            &copy;2025, <a style="font-weight: bold"><span>DANTIC-SENAPI</span></a>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a style="font-weight: bold">Charles THAMBA & Alexis LUBOYA</a> <br>
            <a class="whatsapp-link" style="font-weight: bold"><i class="fab fa-whatsapp" aria-hidden="true"></i>
                +243 81 09 31 640 / +243 82 05 47 788
            </a>
        </div>
    </footer>

    <style>
        .whatsapp-link i {
            color: #25D366; /* Couleur verte de WhatsApp */
            font-size: 1.2em; /* Augmente la taille de l'icône */
        }
        .no-wrap {
            white-space: nowrap; /* Empêche le retour à la ligne */
        }
    </style>
</div>
@endsection
