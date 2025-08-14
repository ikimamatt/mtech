<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Barcode Laptop - {{ $laptop->name }}</title>
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
        .barcode-section {
            text-align: center;
            margin: 30px 0;
        }
        .barcode-image {
            border: 1px solid #ddd;
            padding: 20px;
            background-color: white;
            display: inline-block;
        }
        .barcode-text {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            margin-top: 10px;
            color: #333;
        }
        .laptop-info {
            margin: 30px 0;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #333;
        }
        .info-value {
            color: #666;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BARCODE LAPTOP</h1>
        <p>PLN Nusa Daya</p>
        <p>Generated on: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="barcode-section">
        <div class="barcode-image">
            <img src="{{ $barcodeImage }}" alt="Barcode {{ $barcodeData }}" style="max-width: 100%; height: auto;">
            <div class="barcode-text">{{ $barcodeData }}</div>
        </div>
    </div>

    <div class="laptop-info">
        <h3>Informasi Laptop</h3>
        <div class="info-row">
            <div class="info-label">Nama Laptop:</div>
            <div class="info-value">{{ $laptop->name ?? 'Tidak ada' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Brand:</div>
            <div class="info-value">{{ $laptop->getDeviceBrands?->name ?? 'Tidak ada' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Serial Number:</div>
            <div class="info-value">{{ $laptop->serial_number ?? 'Tidak ada' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">User:</div>
            <div class="info-value">{{ $laptop->user_name ?? 'Tidak ada' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kantor Induk:</div>
            <div class="info-value">{{ $laptop->region->nama_region ?? 'Tidak ada' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status Asset:</div>
            <div class="info-value">{{ $laptop->ownership_status ?? 'Tidak ada' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Vendor:</div>
            <div class="info-value">{{ $laptop->vendor ?? 'Tidak ada' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tahun:</div>
            <div class="info-value">{{ $laptop->year ?? 'Tidak ada' }}</div>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem PLN Nusa Daya</p>
        <p>© {{ date('Y') }} PLN Nusa Daya. All rights reserved.</p>
    </div>
</body>
</html>
