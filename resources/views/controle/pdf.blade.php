<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Arrivage #{{ $arrivage->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { color: #2563eb; font-size: 18px; margin-bottom: 20px; }
        h2 { color: #1e40af; font-size: 14px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; font-weight: bold; }
        .info-grid { display: table; width: 100%; margin-bottom: 20px; }
        .info-row { display: table-row; }
        .info-label { display: table-cell; font-weight: bold; width: 150px; padding: 5px; }
        .info-value { display: table-cell; padding: 5px; }
    </style>
</head>
<body>
    <h1>Arrivage #{{ $arrivage->id }} - {{ $arrivage->date_arrivage->format('d/m/Y') }}</h1>

    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Fournisseur:</div>
            <div class="info-value">{{ $arrivage->fournisseur->nom }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ $arrivage->date_arrivage->format('d/m/Y') }}</div>
        </div>
        @if ($arrivage->bl_path)
        <div class="info-row">
            <div class="info-label">Bon de livraison:</div>
            <div class="info-value">Disponible</div>
        </div>
        @endif
        @if ($arrivage->commentaire)
        <div class="info-row">
            <div class="info-label">Commentaire:</div>
            <div class="info-value">{{ $arrivage->commentaire }}</div>
        </div>
        @endif
    </div>

    <h2>Produits reçus ({{ $arrivage->lignes->count() }})</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th>Famille</th>
                <th>N° Lot</th>
                <th>Photo</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($arrivage->lignes as $index => $ligne)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ligne->produit->nom }}</td>
                    <td>{{ $ligne->produit->famille }}</td>
                    <td>{{ $ligne->numero_lot ?: '-' }}</td>
                    <td>{{ $ligne->photo_path ? 'Oui' : 'Non' }}</td>
                    <td>{{ $ligne->commentaire ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 10px; color: #666;">
        Document généré le {{ now()->format('d/m/Y à H:i') }}
    </p>
</body>
</html>
