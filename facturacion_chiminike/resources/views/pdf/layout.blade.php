<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            margin: 15px;
            color: #333;
            line-height: 1.3;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px;
            font-size: 20px;
        }
        .header-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }
        .seccion {
            margin-top: 25px;
            page-break-inside: avoid;
        }
        h4 {
            color: #2980b9;
            margin-bottom: 8px;
            font-size: 14px;
            background-color: #f8f9fa;
            padding: 6px 10px;
            border-radius: 4px;
            border-left: 4px solid #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            font-size: 11px;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            padding: 6px 8px;
            text-align: left;
        }
        td {
            border: 1px solid #e0e0e0;
            padding: 6px 8px;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            padding-top: 12px;
            text-align: right;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ecf0f1;
        }
        .currency {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #27ae60;
        }
        .highlight {
            font-weight: bold;
            color: #2c3e50;
        }
        .total-row {
            background-color: #e8f4fc !important;
            font-weight: bold;
            border-top: 2px solid #3498db;
        }
        .total-row td {
            color: #2c3e50;
        }
    </style>
</head>
<body>
  {{-- LOGO --}}
        <div style="margin-bottom:8px;">
          <img 
            src="{{ public_path('img/manologochiminike.jpeg') }}" 
            alt="Logo Chiminike" 
            style="width:120px; height:auto;">
        </div>
    <h2>@yield('header')</h2>
    <div class="header-info">
        <strong>Fecha de generación:</strong>
        <span class="highlight">{{ now()->format('d/m/Y H:i') }}</span>
    </div>

    @yield('content')

    <div class="footer">
        Museo Chiminike &mdash; Sistema de Gestión | {{ now()->format('Y') }}
    </div>

</body>
</html>
