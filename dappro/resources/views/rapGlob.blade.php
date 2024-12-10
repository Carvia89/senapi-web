<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>gestodive</title>
  <link rel="icon" href="favicon.png">
  <link rel="apple-touch-icon" href="{{ asset('dash_assets/assets/img/apple-touch-icon.png') }}">
  <style>
    body {
      font-family: sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 800px;
        padding: 20px;
    }
    .text-container {
        flex: 2;
        display: flex;
        flex-direction: column;
        font-size: 16px;
        line-height: 1.2;
    }
    .image-container {
        flex: 1;
        text-align: right;
    }
    .image-container img {
        width: 80px;
        height: 80px;
        bottom: 0px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
    h4 {
      text-align: center;
      color: skyblue;
      font-size: 26px;
    }
    p {
      text-align: right;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="text-container">
      <div style="color: skyblue; font-family: Monotype Corsiva">République Démocratique du Congo</div>
      <div style="color: red">SENAPI</div>
      <div>DIRECTION DES APPROVISIONNEMENTS</div>
      <div>BUREAU MATIERE PREMIERE</div>
    </div>
    <div class="image-container">
      <img src="" alt="Image">
    </div>
  </div>
  <br><br>
  <h4>RAPPORT GLOBAL SUR LE MOUVEMENT DE STOCK DES ARTICLES</h4>
  <table>
    <thead>
      <tr>
        <th>Désignation</th>
        <th>Unités</th>
        <th>Stock Initial</th>
        <th>Stock Entrée</th>
        <th>Stock Sortie</th>
        <th>Solde</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($inventaires as $inventaire)
      <tr>
        <td>{{ $inventaire->article->designation }}</td>
        <td>{{ $inventaire->unity->unite }}</td>
        <td>{{ number_format($inventaire->stock_initial, 2, ',', ' ') }}</td>
        <td>{{ number_format($inventaire->stock_entree, 2, ',', ' ') }}</td>
        <td>{{ number_format($inventaire->stock_sortie, 2, ',', ' ') }}</td>
        <td>{{ number_format($inventaire->stock_actuel, 2, ',', ' ') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <br><br><br><br>
  <p>Fait à Kinshasa, le <span id="date">{{ date('d/m/Y') }}</span></p>
  <script>
    document.getElementById('date').textContent = new Date().toLocaleDateString();
  </script>
</body>
</html>