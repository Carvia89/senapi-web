<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation Générale Bulletins Scolaires</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            position: relative;
            overflow: hidden;
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
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .header-text {
            text-align: left;
        }
        .header-text h2 {
            margin: 0;
            font-size: 16px;
        }
        .header-text h3 {
            margin: 0;
            font-size: 12px;
        }
        .header-image {
            margin-left: auto;
        }
        .header-image img {
            width: 100px;
            height: auto;
            max-height: 80px;
        }
        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
        }
        .date {
            text-align: right; /* Alignement à droite */
            font-weight: bold; /* Texte en gras */
            margin-top: -10px; /* Ajustement pour rapprocher de la title */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .footer {
            margin-top: 40px; /* Espace avant les mentions */
            text-align: right; /* Alignement à droite */
        }
        .additional-info {
            margin-top: 20px; /* Espace avant les infos supplémentaires */
        }
    </style>
</head>
<body>
    <!-- Image en filigrane -->
    <img src="{{ public_path('assets/img/logo-snp.png') }}" alt="Watermark" class="watermark">

    <div class="header">
        <div class="header-image">
            <img src="{{ public_path('assets/img/logo-snp.png') }}" alt="Logo">
        </div>
        <div class="header-text" style="flex-grow: 1;">
            <h2>DIRECTION DES APPROVISIONNEMENTS</h2>
            <h3>DIVISON FOURNITURES SCOLAIRES & MATERIELS GENERAUX</h3>
            <h3>BUREAU MAGASINAGE FOURNITURES SCOLAIRES</h3>
        </div>
    </div>
    <br>

    <div class="title"><strong>SITUATION GENERALE DE STOCK DE BULLETINS SCOLAIRES</strong></div>

    <div class="date">Date : {{ date('d-m-Y') }}</div> <!-- Affichage de la date -->

    <table>
        <thead>
            <tr>
                <th colspan="2">MATERNELLE</th>
                <th colspan="4">PRIMAIRE</th>
                <th colspan="2">SECONDAIRE</th>
                <th colspan="4">HUMANITE CYCLE LONG</th>
                <th colspan="3">HUMANITE CYCLE COURT</th>
            </tr>
            <tr>
                <th>1è</th>
                <th>2è, 3è</th>
                <th>1è, 2è</th>
                <th>3è, 4è</th>
                <th>5è</th>
                <th>6è</th>
                <th>7è</th>
                <th>8è</th>
                <th>1è</th>
                <th>2è</th>
                <th>3è</th>
                <th>4è</th>
                <th>1è</th>
                <th>2è</th>
                <th>3è</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="right">{{ number_format($soldes['maternelle']['niveau_1'], 0, ',', ' ') }}</td>  <!-- 1è colonne -->
                <td class="right">{{ number_format($soldes['maternelle']['niveau_1_class_10'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['primaire']['niveau_2'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['primaire']['niveau_3'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['primaire']['niveau_4'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['primaire']['niveau_5'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['secondaire']['niveau_7'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['secondaire']['niveau_8'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['humanite_cycle_long']['niveau_1'], 0, ',', ' ') }}</td>  <!-- 9è colonne -->
                <td class="right">{{ number_format($soldes['humanite_cycle_long']['niveau_2'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['humanite_cycle_long']['niveau_3'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['humanite_cycle_long']['niveau_4'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['humanite_cycle_court']['niveau_1'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['humanite_cycle_court']['niveau_2'], 0, ',', ' ') }}</td>
                <td class="right">{{ number_format($soldes['humanite_cycle_court']['niveau_3'], 0, ',', ' ') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="right" style="font-weight: bold;">{{ number_format($totaux['maternelle'], 0, ',', ' ') }}</td>
                <td colspan="4" class="right" style="font-weight: bold;">{{ number_format($totaux['primaire'], 0, ',', ' ') }}</td>
                <td colspan="2" class="right" style="font-weight: bold;">{{ number_format($totaux['secondaire'], 0, ',', ' ') }}</td>
                <td colspan="4" class="right" style="font-weight: bold;">{{ number_format($totaux['humanite_cycle_long'], 0, ',', ' ') }}</td>
                <td colspan="3" class="right" style="font-weight: bold;">{{ number_format($totaux['humanite_cycle_court'], 0, ',', ' ') }}</td>
            </tr>
            <tr>
                <td colspan="14" style="text-align: left; font-weight: bold;">TOTAL GENERAL DE STOCK DANS L'ENTREPOT</td>
                <td class="right" style="font-weight: bold;">{{ number_format($totalGeneral, 0, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>CHEF DE BUREAU</div>
        <div style="font-weight: bold;">NDEKAYEMA JOSEPH</div>
    </div>
</body>
</html>
