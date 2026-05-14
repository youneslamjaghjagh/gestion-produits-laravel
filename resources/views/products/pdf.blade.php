<!DOCTYPE html>
<html>
<head>
    <title>Rapport d'Inventaire</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { bg-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
<div class="header">
    <h1>Rapport d'Inventaire des Produits</h1>
    <p>Généré le : {{ date('d/m/Y H:i') }}</p>
    <p><em>(Aperçu des 100 derniers produits ajoutés)</em></p> </div>
</div>

<div>
    <strong>Total Produits :</strong> {{ $stats['total_products'] }} |
    <strong>Valeur du Stock :</strong> {{ number_format($stats['total_value'], 2) }} €
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Catégorie</th>
        <th>Prix</th>
        <th>Stock</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name ?? 'N/A' }}</td>
            <td>{{ number_format($product->price, 2) }} €</td>
            <td>{{ $product->stock }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
