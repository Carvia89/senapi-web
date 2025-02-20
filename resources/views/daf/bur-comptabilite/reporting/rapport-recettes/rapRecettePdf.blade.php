<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport Synthèse</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -90%);
            width: 90%;
            height: auto;
            opacity: 0.1;
            z-index: -1;
        }
        .text {
            text-align: center;
            line-height: 0.2; /* Ajustez l'interligne ici */
            font-size: 15px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .tableau-donnee {
            width: 100%;
            border-collapse: collapse;
            margin: auto; /* Centre le tableau */
            margin-top: 15px;
        }
        .tableau-donnee th {
            border: 1px solid black;
            padding: 8px;
            background-color: rgb(211, 207, 207);
            text-align: center;
            vertical-align: middle;
            font-family: Arial, sans-serif;
        }
        .tableau-donnee td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
            font-family: Arial, sans-serif;
        }
        .footer {
            line-height: 1.7; /* Ajustez l'interligne ici */
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        .under-title {
            line-height: 0.2; /* Ajustez l'interligne ici */
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('assets/img/logo-snp.png') }}" alt="Watermark" class="watermark">

    <div class="text">
        <p>REPUBLIQUE DEMOCRATIQUE DU CONGO</p>
        <p style="color: skyblue">MINISTERE DU BUDGET</p>
        <p>Service National des Approvisionnements et de l'Imprimerie</p>
        <p style="color: red">SENAPI</p>
        <p>DIRECTION ADMINISTRATIVE ET FINANCIERE</p>
    </div>
    <div class="title" style="text-align: center; font-size: 15px; font-weight: bold; font-family: Arial, sans-serif;">
        <p>RAPPORT SUR LES RECETTES</p>
    </div><br>

    <div class="under-title">
        <p>Dossier : {{ $dossier->designation ?? '-' }}</p>
        <p>Imputation : {{ $imputation->imputation ?? '-' }}</p>
        <p>Période : Du {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</p>
    </div>

    <p style="font-family: Arial, sans-serif;">EN CDF</p>
    <table class="tableau-donnee">
        <thead>
            <tr>
                <th class="center" style="width: 5%;">DATE</th>
                <th style="min-width: 250px; width: auto;">LIBELLE</th>
                <th style="min-width: 50px; text-align: right;">MONTANT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recettes as $recette)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($recette->date_recette)->format('d/m/Y') }}</td>
                    <td>{{ $recette->libelle }}</td>
                    <td style="text-align: right;">{{ number_format($recette->montant_recu, 2, ',', ' ') }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL</td>
                <td style="font-weight: bold; text-align:right;">{{ number_format($totalRecettes, 2, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p style="text-align: right;">Fait à Kinshasa, le {{ \Carbon\Carbon::parse($dateDuJour)->format('d/m/Y') }}</p>
        <strong style="margin-right: 296px">C.B. Ord & Cpté</strong><strong>C.D. EXECUTION DU BUDGET-PROGRAMME</strong>
        <strong style="margin-right: 390px">LIKIMBA AGWENDE</strong><strong>IMPONGE Peter</strong>
        <p style="text-align: center; font-weight: bold;">VISA du Directeur Administratif et Financier</p>
    </div>
</body>
</html>
