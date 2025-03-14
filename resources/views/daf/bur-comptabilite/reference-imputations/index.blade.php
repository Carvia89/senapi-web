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
                                    <h5>Liste de Mot de Référence d'imputation</h5>
                                    <a href="{{ route('admin.mot-cle-imputation.create') }}" class="btn btn-primary btn-round">
                                        <i class="fas fa-plus"></i>
                                        Ajouter
                                    </a>
                                </div>

                                <div class="card-block">
                                    <form class="vstack gap-3" id="filter-form">
                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="imputation_id" class="form-label">Imputation </label>
                                                <select name="imputation_id" class="form-control form-control-round" id="imputation_id">
                                                    <option value="">Sélectionnez...</option>
                                                    @foreach ($imputations as $imputation)
                                                        <option value="{{ $imputation->id }}" {{ old('imputation_id') == $imputation->id ? 'selected' : '' }}>
                                                            {{ $imputation->imputation }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="ref_recherche" class="form-label">Mot clé de recherche </label>
                                                <input type="text" name="ref_recherche" class="form-control form-control-round" id="ref_recherche" value="{{ old('ref_recherche') }}">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-block table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="references-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Imputation</th>
                                                    <th>Référence</th>
                                                    <th class="d-flex justify-content-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($references as $reference)
                                                <tr>
                                                    <td scope="row">{{ $reference->id }}</td>
                                                    <td>{{ $reference->imputation->imputation ?? 'Aucune' }}</td>
                                                    <td>{{ $reference->designation }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-end mb-3">
                                                            <a href="{{ route('admin.mot-cle-imputation.edit', $reference) }}" title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $references->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filter-form');

            filterForm.addEventListener('change', function() {
                const formData = new FormData(filterForm);

                fetch('/admin/mot-cle-imputation/filter?' + new URLSearchParams(formData), {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#references-table tbody');
                    tbody.innerHTML = ''; // Réinitialiser le corps du tableau

                    data.forEach(reference => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${reference.id}</td>
                            <td>${reference.imputation ? reference.imputation.imputation : 'Aucune'}</td>
                            <td>${reference.designation}</td>
                            <td>
                                <div class="d-flex justify-content-end mb-3">
                                    <a href="/admin/mot-cle-imputation/${reference.id}/edit" title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            });
        });
    </script>

    <!-- ======= Footer ======= -->
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
    </footer><!-- End Footer -->

    <style>
        .whatsapp-link i {
            color: #25D366; /* Couleur verte de WhatsApp */
            font-size: 1.2em; /* Augmente la taille de l'icône */
        }
    </style>
@endsection
