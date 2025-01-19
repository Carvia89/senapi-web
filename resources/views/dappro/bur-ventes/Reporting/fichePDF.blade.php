<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche de Stock</title>
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
            transform: translate(-50%, -50%);
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
        .additional-info p {
            margin: 0; /* Supprime les marges */
            line-height: 1.2; /* Ajuste l'espacement entre les lignes */
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
            <h3>DIVISON VENTE</h3>
            <h3>BUREAU POINT DE VENTE</h3>
        </div>
    </div>
    <br>

    <div class="title"><strong>FICHE DE STOCK</strong></div>
    <div class="additional-info">
        <p> <strong>Niveau : {{ $niveau->designation ?? 'N/A' }}</strong> </p>
        <p> <strong>Option : {{ $option->designation ?? 'N/A' }}</strong> </p>
        <p> <strong>Classe : {{ $classe->designation ?? 'N/A' }}</strong> </p>
    </div>

    <table>
        <thead>
            <tr>
                <th colspan="4">ENTREE</th>
                <th colspan="4">SORTIE</th>
            </tr>
            <tr>
                <th>DATE</th>
                <th>QUANTITE</th>
                <th>STOCK DEBUT</th>
                <th>STOCK TOTAL</th>
                <th>DATE</th>
                <th>QUANTITE</th>
                <th>SOLDE</th>
                <th>OBSERVATION</th>
            </tr>
        </thead>
        <tbody>
            @php
                $stockTotal = $stockDebut->stock_debut ?? 0;
                $previousSolde = $stockTotal;
            @endphp

            @foreach ($entrees as $index => $entree)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($entree->date_sortie)->format('d-m-Y') }}</td>
                    <td style="text-align: right">{{ number_format($entree->qte_livree, 0, ',', ' ') }}</td>

                    @if ($index == 0)
                        <td style="text-align: right">{{ number_format($previousSolde, 0, ',', ' ') }}</td>
                    @else
                        <td style="text-align: right">{{ number_format($previousSolde, 0, ',', ' ') }}</td>
                    @endif

                    @php
                        // Calculer le stock total pour la ligne actuelle
                        if ($index == 0) {
                            $stockTotal += $entree->qte_livree; // Pour la première ligne
                        } else {
                            $stockTotal = $entree->qte_livree + $previousSolde; // Pour les lignes suivantes
                        }
                    @endphp
                    <td style="text-align: right">{{ number_format($stockTotal, 0, ',', ' ') }}</td>

                    @if (isset($sorties[$index]))
                        <td>{{ \Carbon\Carbon::parse($sorties[$index]->date_sortie)->format('d-m-Y') }}</td>
                        <td style="text-align: right">{{ number_format($sorties[$index]->qte_sortie, 0, ',', ' ') }}</td>
                        @php
                            $solde = $stockTotal - $sorties[$index]->qte_sortie;
                        @endphp
                        <td style="text-align: right">{{ number_format($solde, 0, ',', ' ') }}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td style="text-align: right">{{ number_format($stockTotal, 0, ',', ' ') }}</td>
                    @endif

                    <td></td> <!-- Observation -->
                </tr>

                @php
                    // Mise à jour du solde précédent
                    $previousSolde = isset($sorties[$index]) ? $solde : $stockTotal;
                @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
