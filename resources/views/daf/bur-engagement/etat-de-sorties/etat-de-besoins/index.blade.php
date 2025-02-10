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
                                <h5>Liste des états de besoins</h5>
                                <a href="{{ route('admin.numérisation-etat-de-besoin.create') }}" class="btn btn-primary btn-round">
                                    <i class="fas fa-plus"></i> Ajouter
                                </a>
                            </div>
                            <div class="card-block">
                                <form action="{{ route('admin.numérisation-etat-de-besoin.index') }}" method="GET">
                                    <div class="form-group row mt-3">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="bureau_id" class="form-label">Service Demandeur *</label>
                                            <select name="bureau_id" class="form-control form-control-round" id="bureau_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($bureaus as $bureau)
                                                    <option value="{{ $bureau->bureau->id ?? '' }}">{{ $bureau->bureau->designation ?? 'Aucun' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="dossier_id" class="form-label">Dossier d'impression</label>
                                            <select name="dossier_id" class="form-control form-control-round" id="dossier_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($dossiers as $dossier)
                                                    <option value="{{ $dossier->dossier->id ?? '' }}">{{ $dossier->dossier->designation ?? 'Aucun' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="date_reception" class="form-label">Date Réception</label>
                                            <input type="date" name="date_reception" class="form-control form-control-round" id="date_reception">
                                        </div>
                                        <div class="col-md-3 col-sm-3">
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
                                                <th>Bureau</th>
                                                <th>Dossier</th>
                                                <th>Date Réception</th>
                                                <th>Montant (CDF)</th>
                                                <th>Enregistré par</th>
                                                <th>Etat</th>
                                                <th class="d-flex justify-content-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($etatBesoins as $etat)
                                                <tr>
                                                    <td>{{ $etat->bureau->designation ?? 'Aucun' }}</td>
                                                    <td>{{ $etat->dossier->designation ?? 'Aucun' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($etat->date_reception)->format('d-m-Y') }}</td>
                                                    <td>{{ number_format($etat->montant, 2, ',', ' ') }}</td>
                                                    <td>{{ $etat->utilisateur->prenom ?? '-' }} {{ $etat->utilisateur->name ?? '-' }}</td>
                                                    <td>
                                                        @if ($etat->etat == 1)
                                                            <span class="badge bg-success">En attente de traitement</span>
                                                        @elseif ($etat->etat == 2)
                                                            <span class="badge bg-success">Bon élaboré</span>
                                                        @elseif ($etat->etat == 3)
                                                            <span class="badge bg-success">Bon Imputé</span>
                                                        @elseif ($etat->etat == 4)
                                                            <span class="badge bg-danger">Bon Payé</span>
                                                        @elseif ($etat->etat == 0)
                                                            <span class="badge bg-danger">Apuré</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-end mb-3">
                                                            <a href="{{ route('admin.numérisation-etat-de-besoin.edit', $etat) }}"
                                                                title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('admin.numérisation-etat-de-besoin.show', $etat) }}"
                                                               title="Télécharger" class="btn btn-primary btn-circle btn-sm me-4">
                                                               <i class="fas fa-download"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Pagination -->
                                    {{ $etatBesoins->links() }}
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
    </style>
</div>
@endsection
