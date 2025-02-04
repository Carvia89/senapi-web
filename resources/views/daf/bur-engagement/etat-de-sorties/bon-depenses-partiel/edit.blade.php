@extends('daf.layouts.template')

@section('content')
<div id="pcoded" class="pcoded">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Modifier le Bon de Dépense Partielle</h5>
                                <a href="{{ route('admin.bon-de-dépense-partielle.index') }}" class="btn btn-primary btn-round">
                                    <i class="fas fa-eye mr-2"></i>
                                    Voir la liste
                                </a>
                            </div>
                            <div class="card-block">
                                <!-- En-tête avec images et texte -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <img src="{{ asset('assets/img/logo-snp.png') }}" alt="Image Gauche" class="img-fluid" style="max-width: 150px; flex: 0 0 auto;">
                                    <div class="mx-3 text-center line-spacing" style="flex: 1; text-align: center;">
                                        <p>REPUBLIQUE DEMOCRATIQUE DU CONGO</p>
                                        <p style="color: skyblue">MINISTERE DU BUDGET</p>
                                        <p>Service National des Approvisionnements et de l'Imprimerie</p>
                                        <p style="color: red">SENAPI</p>
                                        <p>DIRECTION ADMINISTRATIVE ET FINANCIERE</p>
                                    </div>
                                    <img src="{{ asset('daf/assets/images/drapeau_rdc.png') }}" alt="Image Droite" class="img-fluid" style="max-width: 125px; flex: 0 0 auto;">
                                </div>

                                <!-- Ligne avec SIEGE et SERIE -->
                                <div class="d-flex justify-content-between align-items-center" style="font-size: 15px; font-weight: bold; font-family: Arial, sans-serif;">
                                    <span>SIEGE : KINSHASA</span>
                                    <span>SERIE : 0000001 ---> 000500</span>
                                </div><br>

                                <!-- INTITULE -->
                                <div style="font-size: 15px; font-weight: bold; font-family: Arial, sans-serif; text-align: center">
                                    <span>BON DE DEPENSE COMPLETE</span>
                                </div><br>

                                <form class="vstack gap-3" action="{{ route('admin.bon-de-dépense-partielle.update', $bon->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row mt-2">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="num_bon" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* Numéro Bon </label>
                                            <input type="text" name="num_bon"
                                                class="form-control form-control-round
                                                    @error('num_bon') is-invalid @enderror"
                                                style="font-size: 15px; font-family: Arial, sans-serif;
                                                text-align: left; font-weight: bold;"
                                                id="num_bon" value="{{ $bon->num_bon }}" readonly>
                                            @error('num_bon')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="num_enreg" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* Numéro d'Enregistrement </label>
                                            <input type="text" name="num_enreg"
                                                class="form-control form-control-round
                                                    @error('num_enreg') is-invalid @enderror"
                                                style="font-size: 15px; font-weight: bold;"
                                                id="num_enreg" value="{{ $bon->num_enreg }}" readonly>
                                            @error('num_enreg')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="date_emission" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* Date Emission </label>
                                            <input type="date" name="date_emission"
                                                class="form-control form-control-round
                                                    @error('date_emission') is-invalid @enderror"
                                                style="font-size: 15px; font-family: Arial, sans-serif;
                                                text-align: left;"
                                                id="date_emission" value="{{ old('date_emission', $bon->date_emission) }}">
                                            @error('date_emission')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="direction_id" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* DIRECTION </label>
                                            <select name="direction_id" class="form-control form-control-round
                                                @error('direction_id') is-invalid @enderror" id="direction_id">
                                            <option value="">Sélectionnez...</option>
                                            @foreach ($directions as $direction)
                                                <option value="{{ $direction->id }}" {{ $bon->direction_id == $direction->id ? 'selected' : '' }}>
                                                    {{ $direction->designation }}
                                                </option>
                                            @endforeach
                                            </select>
                                            @error('direction_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4"></div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="etat_besoin_id" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">Réf. EB : </label>
                                            <select name="etat_besoin_id" class="form-control form-control-round
                                                @error('etat_besoin_id') is-invalid @enderror" id="etat_besoin_id">
                                            <option value="">Sélectionnez l'état de besoin</option>
                                            @foreach ($etatBesoins as $etatBesoin)
                                                <option value="{{ $etatBesoin->id }}" {{ $bon->etat_besoin_id == $etatBesoin->id ? 'selected' : '' }}>
                                                    {{ $etatBesoin->description }}
                                                </option>
                                            @endforeach
                                            </select>
                                            @error('etat_besoin_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="beneficiaire_id" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* PAYEZ A </label>
                                            <select name="beneficiaire_id" class="form-control form-control-round
                                                @error('beneficiaire_id') is-invalid @enderror" id="beneficiaire_id">
                                            <option value="">Sélectionnez...</option>
                                            @foreach ($beneficiaires as $benef)
                                                <option value="{{ $benef->id }}" {{ $bon->beneficiaire_id == $benef->id ? 'selected' : '' }}>
                                                    {{ $benef->nom }}
                                                </option>
                                            @endforeach
                                            </select>
                                            @error('beneficiaire_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="montant_bon" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* MONTANT (CDF) </label>
                                            <input type="text" name="montant_bon"
                                                class="form-control form-control-round
                                                    @error('montant_bon') is-invalid @enderror"
                                                style="font-size: 15px; font-weight: bold; text-align: right"
                                                id="montant_bon" value="{{ old('montant_bon', $bon->montant_bon) }}">
                                            @error('montant_bon')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="montant_acompte" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* ACOMPTE 1 (CDF) </label>
                                            <input type="text" name="montant_acompte"
                                                class="form-control form-control-round
                                                    @error('montant_acompte') is-invalid @enderror"
                                                style="font-size: 15px; font-weight: bold; text-align: right"
                                                id="montant_acompte" value="{{ old('montant_acompte', $montantAcompte) }}">
                                            @error('montant_acompte')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="motif" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* MOTIF </label>
                                            <input type="text" name="motif"
                                                class="form-control form-control-round
                                                    @error('motif') is-invalid @enderror"
                                                id="motif" value="{{ old('motif', $bon->motif) }}">
                                            @error('motif')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="date_paiement" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* Date 1er Paiement  </label>
                                            <input type="date" name="date_paiement"
                                                class="form-control form-control-round
                                                    @error('date_paiement') is-invalid @enderror"
                                                id="date_paiement" value="{{ old('date_paiement', $datePaiement) }}">
                                            @error('date_paiement')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="beneficiaire" class="form-label"
                                            style="font-size: 15px; font-weight: bold;">* Nom Bénéficiaire </label>
                                            <input type="text" name="beneficiaire"
                                                class="form-control form-control-round
                                                    @error('beneficiaire') is-invalid @enderror"
                                                id="beneficiaire" value="{{ old('beneficiaire', $nomBenef) }}">
                                            @error('beneficiaire')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dossier_id" class="form-label">Dossier d'impression </label>
                                            <select name="dossier_id" class="form-control form-control-round
                                                @error('dossier_id') is-invalid @enderror" id="dossier_id">
                                            <option value="">Sélectionnez...</option>
                                            @foreach ($dossiers as $dossier)
                                                <option value="{{ $dossier->id }}" {{ $bon->dossier_id == $dossier->id ? 'selected' : '' }}>
                                                    {{ $dossier->designation }}
                                                </option>
                                            @endforeach
                                            </select>
                                            @error('dossier_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="submit" class="btn btn-primary btn-round">
                                            <i class="fas fa-check"></i> Mettre à Jour
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Basic Form Inputs card end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="styleSelector"></div>
</div>

<style>
.line-spacing p {
    margin: 0; /* Supprime la marge par défaut des paragraphes */
    line-height: 1.5; /* Ajustez cette valeur pour personnaliser l'espacement */
    font-size: 15px;
    font-weight: bold;
    font-family: Arial, sans-serif;
}
</style>
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
@endsection
