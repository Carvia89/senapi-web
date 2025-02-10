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
                                    <h5>Enregistrement du Report Annuel</h5>
                                </div>
                                <div class="card-block">
                                    <form class="vstack gap-3" action="{{ route('admin.report-annuel.store') }}"
                                        method="POST">

                                        @csrf
                                        @method('POST')

                                        <div class="form-group row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label for="annee" class="form-label">* Année </label>
                                                <input type="date" name="annee"
                                                    class="form-control form-control-round
                                                        @error('annee') is-invalid @enderror"
                                                        id="annee" value="{{ old('annee') }}">
                                                @error('annee')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label for="montant_report" class="form-label">* Montant </label>
                                                <input type="text" name="montant_report"
                                                    class="form-control form-control-round
                                                        @error('montant_report') is-invalid @enderror"
                                                        style="font-weight: bold; text-align: right"
                                                        id="montant_report" value="{{ old('montant_report') }}">
                                                @error('montant_report')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-md-12 col-sm-12">
                                                <label for="description" class="form-label">Description </label>
                                                <input type="text" name="description"
                                                    class="form-control form-control-round
                                                        @error('description') is-invalid @enderror"
                                                    id="description" value="{{ old('description') }}">
                                                @error('description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary btn-round">
                                                <i class="fas fa-save"></i> Enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Basic Form Inputs card end -->
                        </div>

                        <!-- Partie Tableau -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Report Annuel</h5>
                            </div>
                            <div class="card-block">
                                <div id="etatBesoinsTable">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Année</th>
                                                <th>Montant (CDF)</th>
                                                <th>Description</th>
                                                <th class="d-flex justify-content-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reports as $report)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($report->annee)->format('Y') }}</td>
                                                    <td>{{ number_format($report->montant_report, 2, ',', ' ') }}</td>
                                                    <td>{{ $report->description ?? 'Aucun' }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-end mb-3">
                                                            <a href="{{ route('admin.report-annuel.edit', $report) }}"
                                                                title="Editer" class="btn btn-warning btn-circle btn-sm me-4">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.report-annuel.destroy', $report) }}"
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
                                    {{ $reports->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector"></div>
    </div>
@endsection
