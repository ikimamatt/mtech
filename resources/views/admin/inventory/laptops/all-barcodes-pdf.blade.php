<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Barcode Semua Laptop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: white;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .barcode-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .barcode-item {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            background-color: white;
            width: 200px;
            margin-bottom: 20px;
        }
        .barcode-image {
            margin-bottom: 10px;
        }
        .barcode-text {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #333;
            margin-bottom: 8px;
        }
        .laptop-name {
            font-weight: bold;
            font-size: 11px;
            color: #333;
            margin-bottom: 5px;
        }
        .laptop-details {
            font-size: 10px;
            color: #666;
            line-height: 1.3;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BARCODE SEMUA LAPTOP</h1>
        <p>PLN Nusa Daya</p>
        <p>Generated on: {{ date('d/m/Y H:i:s') }}</p>
        <p>Total Laptop: {{ count($laptops) }}</p>
    </div>

    <div class="barcode-grid">
        @foreach($laptops as $index => $item)
            @if($index > 0 && $index % 12 == 0)
                <div class="page-break"></div>
            @endif
            
            <div class="barcode-item">
                <div class="barcode-image">
                    <img src="{{ $item['barcodeImage'] }}" alt="Barcode {{ $item['barcodeData'] }}" style="max-width: 100%; height: auto;">
                </div>
                <div class="barcode-text">{{ $item['barcodeData'] }}</div>
                <div class="laptop-name">{{ Str::limit($item['laptop']->name ?? 'N/A', 20) }}</div>
                <div class="laptop-details">
                    <div>{{ $item['laptop']->user_name ?? 'N/A' }}</div>
                    <div>{{ $item['laptop']->region->nama_region ?? 'N/A' }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem PLN Nusa Daya</p>
        <p>© {{ date('Y') }} PLN Nusa Daya. All rights reserved.</p>
    </div>
</body>
</html>
