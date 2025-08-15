<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Eventos</title>
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
        .currency {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #27ae60;
        }
        .total-row {
            background-color: #e8f4fc !important;
            font-weight: bold;
            border-top: 2px solid #3498db;
        }
        .footer {
            margin-top: 30px;
            padding-top: 12px;
            text-align: right;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ecf0f1;
        }
    </style>
</head>
<body>
    {{-- LOGO --}}
    <div style="margin-bottom:8px;">
        <img src="{{ public_path('img/manologochiminike.jpeg') }}" alt="Logo Chiminike" style="width:120px; height:auto;">
    </div>

    <h2>Reporte de Eventos</h2>
    <div class="header-info">
        <strong>Fecha de generación:</strong>
        <span class="highlight">{{ now()->format('d/m/Y H:i') }}</span>
    </div>

    {{-- Sección 6: Cotizaciones Realizadas --}}
    <div class="seccion">
        <h4>Cotizaciones Realizadas</h4>
        <table>
            <thead>
                <tr><th>Código</th><th>Fecha</th><th>Cliente</th><th>RTN</th><th>Total</th><th>Estado</th></tr>
            </thead>
            <tbody>
                @php $totalCotizaciones = 0; @endphp
                @foreach($cotizaciones as $item)
                    @php $totalCotizaciones += $item['total_cotizacion'] ?? 0; @endphp
                    <tr>
                        <td>{{ $item['cod_cotizacion'] ?? 'N/A' }}</td>
                        <td>{{ $item['fecha'] ?? 'N/A' }}</td>
                        <td>{{ $item['cliente'] ?? 'N/A' }}</td>
                        <td>{{ $item['rtn'] ?? 'N/A' }}</td>
                        <td class="currency">Lps {{ number_format($item['total_cotizacion'] ?? 0, 2) }}</td>
                        <td>{{ $item['estado'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4"><strong>Total General</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($totalCotizaciones, 2) }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 7: Entradas Vendidas --}}
    <div class="seccion">
        <h4>Entradas Vendidas</h4>
        <table>
            <thead>
                <tr><th>Código</th><th>Descripción</th><th>Precio</th></tr>
            </thead>
            <tbody>
                @php $totalEntradas = 0; @endphp
                @foreach($entradas as $item)
                    @php $totalEntradas += $item['total'] ?? 0; @endphp
                    <tr>
                        <td>{{ $item['cod_entrada'] ?? 'N/A' }}</td>
                        <td>{{ $item['descripcion'] ?? 'N/A' }}</td>
                        <td class="currency">Lps {{ number_format($item['total'] ?? 0, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2"><strong>Total General</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($totalEntradas, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 8: Reservaciones --}}
    <div class="seccion">
        <h4>Reservaciones</h4>
        <table>
            <thead>
                <tr><th>Evento</th><th>Fecha</th><th>Hora</th><th>Duración</th><th>Cliente</th><th>RTN</th></tr>
            </thead>
            <tbody>
                @foreach($reservaciones as $item)
                    <tr>
                        <td>{{ $item['nombre_evento'] ?? 'N/A' }}</td>
                        <td>{{ $item['fecha_programa'] ?? 'N/A' }}</td>
                        <td>{{ $item['hora_programada'] ?? 'N/A' }}</td>
                        <td>{{ $item['horas_evento'] ?? 'N/A' }} horas</td>
                        <td>{{ $item['cliente'] ?? 'N/A' }}</td>
                        <td>{{ $item['rtn'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

   

    <div class="footer">
        Museo Chiminike &mdash; Sistema de Gestión | {{ now()->format('Y') }}
    </div>
</body>
</html>
