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
                                    <h5>Tableau de commandes en attente de livraison</h5>
                                </div>
                                <div class="card-block">
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
                                                <th>Etat</th>
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
                                                        @if ($enregistrement->etat_cmd)
                                                            <span class="badge bg-success">en traitement</span>
                                                        @else
                                                            <span class="badge bg-danger">Close</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
