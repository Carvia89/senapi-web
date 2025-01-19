<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport PDF</title>
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
            justify-content: space-between; /* Espace entre l'image et le texte */
            align-items: flex-start; /* Aligne les éléments en haut */
            margin-bottom: 20px;
        }
        .header-text {
            text-align: left; /* Texte aligné à gauche */
        }
        .header-text h2 {
            margin: 0;
            font-size: 16px;
        }
        .header-text h3 {
            margin: 0;
            font-size: 14px;
            display: flex; /* Utiliser flex pour aligner le texte et le numéro de commande */
            justify-content: space-between; /* Espace entre le texte et le numéro de commande */
            align-items: center; /* Aligne verticalement */
        }
        .header-text .order-number {
            margin-left: auto; /* Pousse le numéro de commande à droite */
            font-weight: bold; /* Met le numéro de commande en gras */
        }
        .header-image {
            margin-left: auto; /* Pousse l'image à droite */
        }
        .header-image img {
            width: 100px; /* Ajustez la taille de l'image ici */
            height: auto; /* Conserve le ratio d'aspect */
            max-height: 80px; /* Ajustez la hauteur maximale si nécessaire */
        }
        .title {
            text-align: center; /* Centre le titre */
            margin: 20px 0; /* Marges autour du titre */
            font-size: 18px; /* Taille du texte */
            text-decoration: underline; /* Souligne le titre */
        }
        .motif {
            text-align: left; /* Alignement à gauche */
            margin-top: 10px; /* Marges au-dessus */
            font-size: 14px; /* Taille du texte */
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
            text-align: center; /* Centre le texte */
        }
        .right {
            text-align: right; /* Aligne le texte à droite */
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
            <h3 style="display: flex; justify-content: space-between; align-items: center;">
                <span>POINT DE VENTE SIEGE</span>
                <span class="order-number" style="margin-left: 320px; font-weight: bold;">N° Commande : {{ $numeroCommande }}</span>
            </h3>
        </div>
    </div>
    <br>

    <div class="title"><strong>ETAT DE BESOIN</strong></div> <!-- Titre souligné centré -->

    <div class="motif">MOTIF : {{ $commandeLibelle }}</div>

    <table>
        <thead>
            <tr>
                <th class="center">N°</th>
                <th>Option</th>
                <th>Classe</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td> <!-- Centré -->
                    <td>{{ $item->methodOption->designation }}</td>
                    <td class="center">{{ $item->classe->designation }}</td>
                    <td class="right">{{ number_format($item->qte_cmdee, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: left; font-weight: bold;">TOTAL </td>
                <td class="right" style="font-weight: bold;">{{ number_format($totalQteCmdee, 0, ',', ' ') }}</td> <!-- Affiche le total -->
            </tr>
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 20px;">
        <div>Fait à Kinshasa, le {{ $dateDuJour }}</div> <!-- Date du jour -->
        <div style="margin-top: 10px;"> <!-- Ajoute un espace au-dessus -->
            <strong>Chef de Bureau</strong> <!-- Titre -->
        </div>
        <div style="margin-top: 10px;"> <!-- Ajoute un espace au-dessus -->
            <strong>MANYOLE KIANZENZA Désiré</strong> <!-- Nom -->
        </div>
    </div>
</body>
</html>
