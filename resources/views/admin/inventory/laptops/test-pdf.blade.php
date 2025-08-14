<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            color: #333;
        }
        .content {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Test PDF DomPDF</h1>
        <p>Generated on: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="content">
        <h2>Ini adalah test PDF sederhana</h2>
        <p>Jika Anda bisa melihat PDF ini, berarti DomPDF berfungsi dengan baik.</p>
        <p>Timestamp: {{ now() }}</p>
    </div>
</body>
</html>
