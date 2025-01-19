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
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Liste de Colisage disponible dans le système</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.colisage.download') }}" method="GET">
                                        @csrf
                                        @method('GET')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="num_cmd" class="form-label">Numéro de la Commande *</label>
                                                <select name="num_cmd" class="form-control form-control-round
                                                    @error('num_cmd') is-invalid @enderror" id="num_cmd">
                                                    <option value="">Sélectionnez...</option>
                                                    @foreach ($nums as $num)
                                                        <option value="{{ $num->num_cmd }}" {{ old('num_cmd') == $num->num_cmd ? 'selected' : '' }}>
                                                            {{ $num->num_cmd }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('num_cmd')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-download"></i> Télécharger
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
                                    <h5>Liste de Commandes déjà traitées</h5>
                                </div>
                                <div class="card-block">
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
                                                            {{ number_format($enregistrement->total_qte_livree, 0, ',', ' ') }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $enregistrement->first_date_sortie ? \Carbon\Carbon::parse($enregistrement->first_date_sortie)->format('d-m-Y') : 'N/A' }}</td>
                                                    <td>
                                                        @if ($enregistrement->etat_cmd)
                                                            <span class="badge bg-danger">en traitement</span>
                                                        @else
                                                            <span class="badge bg-success">traitée</span>
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
