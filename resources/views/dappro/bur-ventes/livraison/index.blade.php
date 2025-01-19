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
                            <!-- Section tableau de commandes -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Liste de Commandes livrées</h5>
                                    <a href="{{ route('admin.livraison-Vente.create') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-plus mr-2"></i>
                                        Ajouter
                                    </a>
                                </div>
                                <div class="card-block">
                                    @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                <!-- Section 3: Tableau des Enregistrements -->
                                <div class="table-responsive mt-4">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Num. Cmd</th>
                                                <th>Client</th>
                                                <th>Qté Cmdée</th>
                                                <th>Qté Livrée</th>
                                                <th>Date Livraison</th>
                                                <th>Etat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($enregistrements as $index => $enregistrement)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $enregistrement->num_cmd }}</td>
                                                    <td>{{ $enregistrement->client->designation ?? 'Aucun' }}</td>
                                                    <td>
                                                        <span class="badge bg-danger">
                                                            {{ number_format($enregistrement->total_qte_cmdee, 0, ',', ' ') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success">
                                                            {{ number_format($enregistrement->total_qte_sortie, 0, ',', ' ') }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $enregistrement->first_date_sortie ? \Carbon\Carbon::parse($enregistrement->first_date_sortie)->format('d-m-Y') : 'N/A' }}</td>
                                                    <td>
                                                        @if ($enregistrement->etat_cmd)
                                                            <span class="badge bg-danger">en traitement</span>
                                                        @else
                                                            <span class="badge bg-danger">Fermée</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $enregistrements->links() }}
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
        <div id="styleSelector">
        </div>
    </div>
@endsection
