<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport Périodique</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            position: relative; /* Nécessaire pour le positionnement absolu des enfants */
        }
        .watermark {
            position: fixed; /* Fixe l'image sur toutes les pages */
            top: 50%;
            left: 45%;
            transform: translate(-50%, -50%); /* Centre l'image */
            width: 90%;
            height: auto;
            opacity: 0.1; /* Transparence du filigrane */
            z-index: -1; /* Place l'image en arrière-plan */
            pointer-events: none; /* Empêche l'image d'interférer avec les clics */
        }
        .text {
            text-align: center;
            line-height: 0.2;
            font-size: 15px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .entete {
            text-align: left;
            line-height: 0.2;
            font-size: 15px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .tableau-donnee {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
            margin-top: 15px;
        }
        .tableau-donnee th {
            border: 1px solid black;
            padding: 8px;
            background-color: skyblue;
            color: white;
            text-align: center;
            vertical-align: middle;
            font-family: Arial, sans-serif;
        }
        .tableau-donnee td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .footer {
            line-height: 1.2;
            font-size: 15px;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <!-- Filigrane -->
    <img src="{{ public_path('assets/img/logo-snp.png') }}" alt="Watermark" class="watermark">

    <!-- Contenu principal -->
    <div class="text">
        <p>REPUBLIQUE DEMOCRATIQUE DU CONGO</p>
        <p style="color: skyblue">MINISTERE DU BUDGET</p>
        <p>Service National des Approvisionnements et de l'Imprimerie</p>
        <p style="color: red">SENAPI</p>
        <p>DIRECTION ADMINISTRATIVE ET FINANCIERE</p>
    </div>
    <div class="title" style="text-align: center; font-size: 15px; font-weight: bold; font-family: Arial, sans-serif;">
        <p>RAPPORT DE TRESORERIE DU {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} AU {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</p>
    </div><br>

    <div class="entete">
        <p style="font-family: Arial, sans-serif;">EN CDF</p>
        <p style="font-family: Arial, sans-serif;">CAISSE / SIEGE</p>
    </div>
    <table class="tableau-donnee">
        <thead>
            <tr>
                <th class="center" style="width: 5%;">NATURE</th>
                <th style="min-width: 150px; width: auto;">LIBELLE</th>
                <th style="min-width: 80px; text-align: right;">MONTANT DETAILLE</th>
                <th style="min-width: 80px; text-align: right;">MONTANT TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalRecettes = $reportData['report']['montant_report'];
                $totalDepenses = 0;
                $previousSolde = $totalRecettes;

                $imputations = $reportData['imputations'] ?? [];
                $depensesParImputation = $reportData['depensesParImputation'] ?? [];

                foreach ($depensesParImputation as $imputationData) {
                    $totalDepenses += $imputationData['depenses']->sum('total_depense');
                }
            @endphp

            <!-- Ligne REPORT -->
            <tr>
                <td></td>
                <td style="text-align: left; font-weight: bold;">{{ $reportData['report']['libelle'] }}</td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($reportData['report']['montant_report'], 2, ',', ' ') }}</td>
                <td></td>
            </tr>

            <!-- Ligne RECETTES -->
            <tr>
                <td></td>
                <td style="text-align: left; font-weight: bold;">RECETTES</td>
                <td></td>
                <td></td>
            </tr>

            <!-- Remplissage de recettes -->
            @foreach ($reportData['recettes'] as $recette)
                <tr>
                    <td></td>
                    <td style="text-align: left;">{{ $recette['designation'] }}</td>
                    <td style="text-align: right;">{{ number_format($recette['total_recu'], 2, ',', ' ') }}</td>
                    <td style="text-align: right;"></td>
                    @php $totalRecettes += $recette['total_recu']; @endphp
                </tr>
            @endforeach

            <!-- calcul somme de recettes + report -->
            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL (I)</td>
                <td style="font-weight: bold; text-align:right;">{{ number_format($totalRecettes, 2, ',', ' ') }}</td>
                <td style="font-weight: bold; text-align:right;"></td>
            </tr>

            <!-- Ligne DEPENSES -->
            <tr>
                <td></td>
                <td style="text-align: left; font-weight: bold;">DÉPENSES</td>
                <td></td>
                <td></td>
            </tr>

            <!-- Remplissage de dépenses (triées par ID d'imputation) -->
            @foreach ($depensesParImputation as $imputationData)
                <!-- Ligne de l'imputation -->
                <tr>
                    <td style="font-weight: bold;">{{ $imputationData['imputation']->imputation }}</td>
                    <td style="font-weight: bold;">{{ $imputationData['imputation']->designation }}</td>
                    <td></td>
                    <td style="font-weight: bold; text-align: right;">
                        {{ number_format($imputationData['depenses']->sum('total_depense'), 2, ',', ' ') }}
                    </td>
                </tr>

                <!-- Lignes des reference_imputation_id sous cette imputation -->
                @foreach ($imputationData['depenses'] as $depense)
                    <tr>
                        <td></td>
                        <td style="text-align: left;">{{ $depense['designation'] }}</td>
                        <td style="text-align: right;">{{ number_format($depense['total_depense'], 2, ',', ' ') }}</td>
                        <td></td>
                    </tr>
                @endforeach
            @endforeach

            <!-- calcul de TOTAL -->
            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL (II)</td>
                <td style="font-weight: bold; text-align:right;">{{ number_format($totalDepenses, 2, ',', ' ') }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL (I) - (II)</td>
                <td style="font-weight: bold; text-align:right;">{{ number_format($totalRecettes - $totalDepenses, 2, ',', ' ') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p style="text-align: right;">Fait à Kinshasa, le {{ \Carbon\Carbon::parse($dateDuJour)->format('d/m/Y') }}</p>
        <p style="text-align: center; font-weight: bold;">Octave IYAKA BONKONGOLA</p>
        <p style="text-align: center; font-weight: bold;">Directeur</p>
    </div>
</body>
</html>