<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Dépense</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -90%);
            width: 90%; /* Ajustez la taille de l'image ici */
            height: auto;
            opacity: 0.1; /* Rendre l'image floue */
            z-index: -1; /* Placer l'image derrière le contenu */
        }
        .text {
            text-align: center;
            line-height: 0.2; /* Ajustez l'interligne ici */
            font-size: 15px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .subtitle {
            text-align: left; /* Alignement à gauche */
            width: 100%; /* S'étend sur toute la largeur */
            padding-left: 20px; /* Espacement à gauche */
            margin-top: 5px; /* Espace au-dessus de la ligne */
            font-size: 15px; /* Taille de police cohérente */
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .numero {
            text-align: center;
            margin-top: 1px; /* Espace au-dessus de la ligne */
            font-size: 15px; /* Taille de police cohérente */
            font-weight: bold;
            font-family: Arial, sans-serif;
            margin-right: 10px;
        }
        .service {
            font-family: Arial, sans-serif;
            line-height: 0.3; /* Ajustez l'interligne ici */
        }
        .motif {
            font-family: Arial, sans-serif;
            line-height: 1.5; /* Ajustez l'interligne ici */
        }
        .amount-table {
            width: 130%; /* Prend toute la largeur */
            border-collapse: collapse; /* Supprime les espaces entre les cellules */
            margin-top: 1px; /* Espace au-dessus du tableau */
            padding-left: 1px; /* Espacement à gauche */
            line-height: 0.2;
            margin-left: 0px;
        }
        .amount-table td {
            padding: 5px; /* Espacement dans les cellules */
            vertical-align: middle; /* Centre le contenu verticalement */
        }
        .amount-label {
            font-size: 12px;
            font-weight: bold;
            font-family: Arial, sans-serif;
            padding-left: 10px; /* Espacement à gauche */
        }
        .amount-value {
            font-weight: bold;
            font-family: Arial, sans-serif;
            font-size: 15px;
            display: inline-block;
            border: 2px solid rgb(37, 37, 37);
            width: 100px; /* Ajustez la largeur ici */
            height: 10px; /* Ajustez la hauteur ici */
            width: 220px; /* Ajustez la largeur ici selon vos besoins */
            text-align: right;
            vertical-align: middle;
        }
        .amount-letter {
            padding-left: 20px; /* Espacement à gauche */
        }
        .tableau-visa {
            width: 100%;
            border-collapse: collapse;
            margin: auto; /* Centre le tableau */
            margin-top: 30px;
        }
        .tableau-visa td, th {
            border: 1px solid black;
            padding: 8px;
            background-color: white; /* Fond blanc pour les cellules */
            text-align: center; /* Centre le texte */
            vertical-align: middle; /* Centre verticalement */
            font-family: Arial, sans-serif;
        }
        .tableau-visa th {
            background-color: #f2f2f2; /* Fond gris pour l'en-tête */
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        .paiement {
            font-size: 12px;
            font-weight: bold;
            font-family: Arial, sans-serif;
            line-height: 1.5; /* Ajustez l'interligne ici */
        }
        .tableau-acquit {
            border-collapse: collapse;
            margin-left: 360px;
            margin-top: 2px;

        }
        .tableau-acquit td, th {
            border: 1px solid black;
            padding: 8px;
            background-color: white; /* Fond blanc pour les cellules */
            text-align: center; /* Centre le texte */
            vertical-align: middle; /* Centre verticalement */
        }
        .tableau-acquit th {
            background-color: #f2f2f2; /* Fond gris pour l'en-tête */
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <!-- Image en filigrane -->
    <img src="{{ public_path('assets/img/logo-snp.png') }}" alt="Watermark" class="watermark">

    <div class="text">
        <p>REPUBLIQUE DEMOCRATIQUE DU CONGO</p>
        <p style="color: skyblue">MINISTERE DU BUDGET</p>
        <p>Service National des Approvisionnements et de l'Imprimerie</p>
        <p style="color: red">SENAPI</p>
        <p>DIRECTION ADMINISTRATIVE ET FINANCIERE</p>
    </div>
    <div class="subtitle">
        <p><span style="margin-right: 330px;"> SIEGE : KINSHASA </span> <span>SERIE : 000001 ---> 000500</span></p>
    </div>
    <div class="title" style="text-align: center; font-size: 15px; font-weight: bold; font-family: Arial, sans-serif;">
        <p>BON DE DEPENSE COMPLETE</p>
    </div>

    <div class="numero">
        <strong>N° &nbsp; {{ $numBon }} &nbsp; DU &nbsp; {{ \Carbon\Carbon::parse($dateEmission)->format('d/m/Y') }}</strong>
        <span style="margin-right: 30px;"></span>
    </div>
    <div class="etat-besoin" style="text-align: right; font-size: 15px; font-weight: bold; font-family: Arial, sans-serif;">
        <strong>Num. EB : EB000{{ $etatBesoin ?? '-' }} </strong>
    </div><br><br>
    <div class="service">
        <p><strong style="font-size: 12px;">DIRECTION : </strong> <span style="font-size: 14px;">{{ $direction }}</span></p>
        <p><strong style="font-size: 12px;">PAYEZ A &nbsp; &nbsp; : </strong> <span font-size: 14px;>{{ $beneficiare }}</span></p>
    </div>

    <table class="amount-table">
        <tr style="padding-left: 1px;">
            <td class="amount-label">LA SOMME DE : (En chiffre) CDF</td>
            <td class="amount-value">
                {{ number_format($montantBon, 2, ',', ' ') }}
            </td>
        </tr>
    </table>

    <div style="line-height: 1.7;">
        <strong style="font-size: 12px; font-family: Arial, sans-serif;">En lettre : </strong> <span style="font-size: 14px; font-family: Arial, sans-serif;"> {{ $montantEnLettres }}
        </span>
    </div>
    <div class="motif" style="font-size: 12px;">
        <strong>MOTIF : </strong>
        <span style="font-size: 14px; margin-left: 15px;">{{ $motif }}</span>
    </div>

    <!-- Tableau VISA -->
    <table class="tableau-visa">
        <thead>
            <tr>
                <th rowspan="2">SIGNATURE DU DEMANDEUR</th>
                <th colspan="3">VISA DPSB</th>
                <th rowspan="2">VISA DAF</th>
                @if ($montantBon > 100000) <!-- Condition pour afficher VISA DG -->
                <th rowspan="2">VISA DG</th>
            @endif
            </tr>
            <tr>
                <th>DATE</th>
                <th>IMPUT</th>
                <th>VISA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 110px; height: 80px;"> </td>  <!-- 1ère colonne -->
                <td style="width: 10px;">
                    @if ($showSignature)  <!-- Vérification si l'état est supérieur à 1 -->
                        {{ \Carbon\Carbon::parse($dateImput)->format('d/m/Y') }}
                    @else
                        <span> </span>  <!-- Message alternatif si l'état n'est pas supérieur à 1 -->
                    @endif
                </td>
                <td> {{ $imputation }} </td>
                <td>
                    @if ($showSignature)  <!-- Vérification si l'état est supérieur à 1 -->
                        <img src="{{ public_path('daf/assets/images/signatures/signature.jpg') }}" alt="Signature" style="width: 100px; height: auto;">
                    @else
                        <span> </span>  <!-- Message alternatif si l'état n'est pas supérieur à 1 -->
                    @endif
                </td>
                <td>  </td>
                @if ($montantBon > 100000) <!-- Condition pour la valeur de VISA DG -->
                <td>  </td>
                @else
                    <td style="display: none;"> </td> <!-- Cellule cachée si la condition n'est pas remplie -->
                @endif
            </tr>
        </tbody>
    </table><br>

    <div class="paiement">
        <p style="padding-left: 110px">Espèce N°ENR : {{ $NumEnreg }} &nbsp; DU &nbsp; {{ \Carbon\Carbon::parse($dateEmission)->format('d/m/Y') }}</p>
        <p style="padding-left: 20px; line-height: 0.2;">PAIEMENT : </p>
        <p style="padding-left: 110px; line-height: 0.1;"><span style="margin-right: 20px">Chèque N° : </span> ................... &nbsp; DU  ...................
        <p style="padding-left: 235px; line-height: 0.9;">BANQUE : ...................</p>
    </div>

    <!-- Tableau ACQUIT -->
    <table class="tableau-acquit">
        <thead>
            <tr>
                <th colspan="3">POUR ACQUIT</th>
            </tr>
            <tr>
                <th>DATE</th>
                <th>NOM</th>
                <th>SIGNATURE</th>
            </tr>
        </thead>
        <tbody>
            <tr style="font-family: Arial, sans-serif; font-size: 12px;">
                <td style="width:40px; height: 110px;">{{ \Carbon\Carbon::parse($dateAcquit)->format('d/m/Y') }}</td>  <!-- 1ère colonne -->
                <td style="width:100px; ">{{ $pourAcquit ?? ' '}}</td>
                <td style="width:130px;"> </td>
            </tr>
        </tbody>
    </table><br><br>

    <div class="footer" style="font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">
        <strong style="margin-right: 570px; margin-top: 10px;">JUSTIFIE : &nbsp; OUI</strong><strong style="font-size: 7px;">{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</strong>
        <p style="line-height: 0.2; margin-left: 58px;">NON</p>
        </span>
    </div>
</body>
</html>
