<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation Générale Humanités</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
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

    <div class="title"><strong>SITUATION GENERALE DE STOCK DE BULLETINS SCOLAIRES POUR LES CLASSES DES HUMANITES</strong></div>

    <div class="date">Date : {{ date('d-m-Y') }}</div> <!-- Affichage de la date -->

    <table>
        <thead>
            <tr>
                <th class="center">N°</th>
                <th>OPTIONS</th>
                <th>1ère</th>
                <th>2è</th>
                <th>3è</th>
                <th>4è</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $item['option'] }}</td>
                    <td class="right">{{ number_format($item['qte1ère'], 0, ',', ' ') }}</td>
                    <td class="right">{{ number_format($item['qte2è'], 0, ',', ' ') }}</td>
                    <td class="right">{{ number_format($item['qte3è'], 0, ',', ' ') }}</td>
                    <td class="right">{{ number_format($item['qte4è'], 0, ',', ' ') }}</td>
                    <td class="right">{{ number_format($item['qte1ère'] + $item['qte2è'] + $item['qte3è'] + $item['qte4è'], 0, ',', ' ') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL GENERAL</td>
                <td class="right" style="font-weight: bold;">{{ number_format($totalQte1ère, 0, ',', ' ') }}</td>
                <td class="right" style="font-weight: bold;">{{ number_format($totalQte2è, 0, ',', ' ') }}</td>
                <td class="right" style="font-weight: bold;">{{ number_format($totalQte3è, 0, ',', ' ') }}</td>
                <td class="right" style="font-weight: bold;">{{ number_format($totalQte4è, 0, ',', ' ') }}</td>
                <td class="right" style="font-weight: bold;">{{ number_format($totalQte1ère + $totalQte2è + $totalQte3è + $totalQte4è, 0, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>CHEF DE BUREAU</div>
        <div style="font-weight: bold;">NDEKAYEMA JOSEPH</div>
    </div>
</body>
</html>
