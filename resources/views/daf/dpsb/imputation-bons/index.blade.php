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
                                <h5>Bons des dépenses en attente d'imputation</h5>
                            </div>
                            <div class="card-block">
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
                                                            <span class="badge bg-success">En attente d'imputation</span>
                                                        @elseif ($bon->etat == 2)
                                                            <span class="badge bg-success">Bon élaboré</span>
                                                        @elseif ($bon->etat == 3)
                                                            <span class="badge bg-success">En circuit signature</span>
                                                        @elseif ($bon->etat == 0)
                                                            <span class="badge bg-danger">Apuré</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-end mb-3">
                                                            <a href="{{ route('admin.imputation-bon-depense.edit', $bon) }}"
                                                                title="Imputer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            @if ($bon->etat_besoin_id && $bon->etatBesoin && $bon->etatBesoin->fichier)
                                                                <a href="{{ route('admin.bdp.telecharger-etat-besoin', $bon->etat_besoin_id) }}"
                                                                title="Télécharger EB" class="btn btn-secondary btn-circle btn-sm me-4">
                                                                <i class="fas fa-download"></i>
                                                                </a>
                                                            @endif
                                                            <a href="{{ route('admin.bon-de-dépense-complète.show', $bon->id) }}"
                                                               title="voir le bon" class="btn btn-primary btn-circle btn-sm me-4">
                                                               <i class="fas fa-eye"></i>
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
