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
                            <!-- Affichage Message de Succès -->
                            @if (Session('success'))
                            <div class="alert alert-success d-flex align-items-center">
                                <i class="fas fa-hand-thumbs-up-fill me-2"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                            @endif

                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Liste des niveaux scolaires Bulletins</h5>
                                <!--
                                    <a href="#" class="btn btn-primary btn-round">
                                        <i class="fas fa-plus"></i>
                                        Ajouter
                                    </a>
                                -->
                                </div>
                                <div class="card-block table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Désignation</th>
                                                    <th class="d-flex justify-content-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($niveaux as $niveau)
                                                <tr>
                                                    <td scope="row">{{ $niveau->id }}</td>
                                                    <td>{{ $niveau->designation }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-end mb-3">
                                                            <a href="#"
                                                                title="Voir" class="btn btn-primary btn-circle btn-sm me-4">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!-- Pagination -->
                                        {{ $niveaux->links() }}
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
        <div id="styleSelector">
        </div>
    </div>
@endsection
