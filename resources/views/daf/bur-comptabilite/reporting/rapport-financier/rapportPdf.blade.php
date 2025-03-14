<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport Journalier</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
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
            line-height: 0.2; /* Ajustez l'interligne */
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
            background-color: skyblue; /* Couleur de fond personnalisée */
            color: white; /* Couleur du texte pour le contraste */
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
            line-height: 1.7; /* Ajustez l'interligne ici */
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
        <p>RAPPORT JOURNALIER DU {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
    </div><br>

    <p style="font-family: Arial, sans-serif;">EN CDF</p>
    <table class="tableau-donnee">
        <thead>
            <tr>
                <th class="center" style="width: 5%;">CODE</th>
                <th style="min-width: 150px; width: auto;">LIBELLE</th>
                <th style="min-width: 80px; text-align: right;">ENTREES</th>
                <th style="min-width: 80px; text-align: right;">SORTIES</th>
                <th style="min-width: 80px; text-align: right;">SOLDE</th>
            </tr>
        </thead>
        <tbody>
            @php
                $recettesToday = $reportData['recettesToday'];
                $totalRecettes = $reportData['report']['montant_report'] + $recettesToday; // Initialiser avec le montant du report
                $totalDepenses = 0;
                $previousSolde = $totalRecettes; // Utiliser le montant du report comme solde initial
            @endphp

            <!-- Ligne REPORT -->
            <tr>
                <td></td>
                <td style="text-align: left; font-weight: bold;">{{ $reportData['report']['libelle'] }}</td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($reportData['report']['montant_report'], 2, ',', ' ') }}</td>
                <td></td>
                <td></td>
            </tr>
            <!-- Ligne RECETTES -->
            <tr>
                <td></td>
                <td style="text-align: left; font-weight: bold;">RECETTES</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            @foreach ($reportData['recettes'] as $recette)
                <tr>
                    <td></td> <!-- CODE si disponible -->
                    <td style="text-align: left; white-space: normal;">{{ $recette->libelle }}</td>
                    <td style="text-align: right;">{{ number_format($recette->montant_recu, 2, ',', ' ') }}</td>
                    <td></td> <!-- DEPENSE si non disponible -->
                    <td style="text-align: right;"></td> <!-- SOLDE calculé -->
                </tr>
                @php
                    $totalRecettes += $recette->montant_recu; // Ajouter aux recettes
                @endphp
            @endforeach
            <!-- Ligne DEPENSES -->
            <tr>
                <td></td>
                <td style="text-align: left; font-weight: bold;">DEPENSES</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach ($reportData['depenses_bons'] as $index => $depense)
                @php
                    $montantBon = $depense['montant_bon'];

                    // Calculer le solde pour la ligne
                    if ($index === 0) {
                        // Pour la première ligne, calculer avec la somme des recettes
                        $solde = ($totalRecettes) - $montantBon; // (RECETTES + REPORT) - DEPENSE
                    } else {
                        // Pour les lignes suivantes
                        $solde = $previousSolde - $montantBon;
                    }
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $depense['bon_depense_id'] }}</td> <!-- CODE ou identifiant du bon -->
                    <td style="text-align: left; white-space: normal;">{{ $depense['motif'] }}</td>
                    <td></td> <!-- RECETTE si non disponible -->
                    <td style="text-align: right;">{{ number_format($montantBon, 2, ',', ' ') }}</td>
                    <td style="text-align: right;">{{ number_format($solde, 2, ',', ' ') }}</td> <!-- SOLDE calculé -->
                </tr>
                @php
                    $totalDepenses += $montantBon; // Ajouter aux dépenses
                    $previousSolde = $solde; // Mettre à jour le solde précédent
                @endphp
            @endforeach

            @foreach ($reportData['depenses_sans_bons'] as $depense)
                @php
                    $montantDepense = $depense->montant_depense;
                    $solde = $previousSolde - $montantDepense; // Calculer le solde pour la ligne
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $depense->imputation }}</td> <!-- CODE ou identifiant de l'imputation -->
                    <td style="text-align: left; white-space: normal;">{{ $depense->libelle }}</td>
                    <td></td> <!-- RECETTE si non disponible -->
                    <td style="text-align: right;">{{ number_format($montantDepense, 2, ',', ' ') }}</td>
                    <td style="text-align: right;">{{ number_format($solde, 2, ',', ' ') }}</td> <!-- SOLDE calculé -->
                </tr>
                @php
                    $totalDepenses += $montantDepense; // Ajouter aux dépenses
                    $previousSolde = $solde; // Mettre à jour le solde précédent
                @endphp
            @endforeach

            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL</td>
                <td style="font-weight: bold; text-align:right;">{{ number_format(($reportData['report']['montant_report'] + $recettesToday), 2, ',', ' ') }}</td>
                <td style="font-weight: bold; text-align:right;">{{ number_format($totalDepenses, 2, ',', ' ') }}</td>
                <td style="font-weight: bold; text-align:right;">{{ number_format(($reportData['report']['montant_report'] + $recettesToday) - $totalDepenses, 2, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p style="text-align: right;">Fait à Kinshasa, le {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
        <strong style="margin-right: 296px">C.B. Ord & Cpté</strong><strong>C.D. EXECUTION DU BUDGET-PROGRAMME</strong>
        <strong style="margin-right: 390px">LIKIMBA AGWENDE</strong><strong>IMPONGE Peter</strong>
        <p style="text-align: center; font-weight: bold;">VISA du Directeur Administratif et Financier</p>
    </div>
</body>
</html>
