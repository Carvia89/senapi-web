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
                                <h5>Répertoire de bons des dépenses partielles</h5>
                                <a href="{{ route('admin.bon-de-dépense-partielle.create') }}" class="btn btn-primary btn-round">
                                    <i class="fas fa-plus"></i> Nouveau
                                </a>
                            </div>
                            <div class="card-block">
                                <form action="{{ route('admin.bon-de-dépense-partielle.index') }}" method="GET">
                                    <div class="form-group row mt-3">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="direction_id" class="form-label">Direction *</label>
                                            <select name="direction_id" class="form-control form-control-round" id="direction_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($directions as $direction)
                                                    <option value="{{ $direction->direction->id }}">{{ $direction->direction->designation }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dossier_id" class="form-label">Dossier d'impression</label>
                                            <select name="dossier_id" class="form-control form-control-round" id="dossier_id">
                                                <option value="">Sélectionnez...</option>
                                                @foreach ($dossiers as $dossier)
                                                    <option value="{{ $dossier->dossier->id ?? 'Aucun' }}">{{ $dossier->dossier->designation ?? 'Aucun' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="date_reception" class="form-label">Date Réception</label>
                                            <input type="date" name="date_reception" class="form-control form-control-round" id="date_reception">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="motif" class="form-label">Libelle</label>
                                            <input type="text" name="motif" class="form-control form-control-round" id="motif">
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="montant_bon" class="form-label">Montant</label>
                                            <input type="text" name="montant_bon" class="form-control form-control-round" id="montant_bon">
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
                                                <th>Numéro Bon</th>
                                                <th>Libelle</th>
                                                <th>Montant (CDF)</th>
                                                <th>Date Emission</th>
                                                <th>Etat</th>
                                                <th class="d-flex justify-content-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bonDepenses as $bon)
                                                <tr>
                                                    <td> {{ $bon->num_bon }}</td>
                                                    <td>{{ $bon->motif }}</td>
                                                    <td>{{ number_format($bon->montant_bon, 2, ',', ' ') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($bon->date_emission)->format('d-m-Y') }}</td>
                                                    <!-- <td>{{ $bon->utilisateur->prenom ?? '-' }} {{ $bon->utilisateur->name ?? '-' }}</td> -->
                                                    <td>
                                                        @if ($bon->etat == 1)
                                                            <span class="badge bg-success">En cours de paiement</span>
                                                        @elseif ($bon->etat == 2)
                                                            <span class="badge bg-success">Bon imputé</span>
                                                        @elseif ($bon->etat == 3)
                                                            <span class="badge bg-success">Payé</span>
                                                        @elseif ($bon->etat == 0)
                                                            <span class="badge bg-danger">Apuré</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-end mb-3">
                                                            <a href="{{ route('admin.bon-de-dépense-partielle.edit', $bon) }}"
                                                                title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            @if ($bon->etat_besoin_id && $bon->etatBesoin && $bon->etatBesoin->fichier)
                                                                <a href="{{ route('admin.bdp.telecharger-etat-besoin', $bon->etat_besoin_id) }}"
                                                                title="Télécharger EB" class="btn btn-secondary btn-circle btn-sm me-4">
                                                                <i class="fas fa-download"></i>
                                                                </a>
                                                            @endif
                                                            <a href="{{ route('admin.bon-de-dépense-partielle.show', $bon->id) }}"
                                                               title="Imprimer" class="btn btn-primary btn-circle btn-sm me-4">
                                                               <i class="fas fa-print"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Pagination -->
                                    {{ $bonDepenses->links() }}
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
