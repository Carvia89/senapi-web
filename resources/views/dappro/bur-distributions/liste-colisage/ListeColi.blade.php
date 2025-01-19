<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de colisage</title>
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
            align-items: center;
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
        .header-image img {
            width: 100px;
            height: auto;
            max-height: 80px;
        }
        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
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
            display: flex;
            justify-content: space-between; /* Espace entre les mentions */
            font-size: 12px;
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
        <div class="header-text">
            <h2>DIRECTION DES APPROVISIONNEMENTS</h2>
            <h3>BUREAU DISTRIBUTION</h3>
        </div>
    </div>

    <div class="title">LISTE DE COLISAGE</div>

    <!-- Informations supplémentaires -->
    <div class="additional-info">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <div style="text-align: right;">
                <strong>Date :</strong> {{ $dateLivraison }}
            </div>
            <div style="text-align: right;">
                <strong>Numéro :</strong> {{ $numeroLivraison }}
            </div>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div style="text-align: right;">
                <strong>Bénéficiaire :</strong> DISTRIBUTION/POINT DE VENTE
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="center">N°</th>
                <th>Désignation</th>
                <th>Quantité Livrée</th>
                <th>Observation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($enregistrements as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $item->classe_designation ?? '-' }} {{ $item->option_designation ?? '-' }}</td>
                <td class="right">{{ number_format($item->qte_livree, 0, ',', ' ') }}</td>
                <td></td>
            </tr>
        @endforeach
            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL</td>
                <td class="right" style="font-weight: bold;">{{ number_format($totalQteLivree, 0, ',', ' ') }}</td>
                <td class="right"></td>
            </tr>
        </tbody>
    </table>

    <!-- Mentions en bas du tableau -->
    <div class="footer">
        <div>
            <strong>Pour Livraison</strong><br>
            <strong>Chef de Bureau Stock</strong>
        </div>
        <div style="text-align: right;">
            <strong>Pour Réception</strong><br>
            <strong>Chef de Bureau Distribution</strong>
        </div>
    </div>
</body>
</html>
