<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservación - {{ $reservacion['nombre_evento'] ?? 'Evento' }} | Museo Chiminike</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 15px;
            border: 1px solid #e1e1e1;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .header img {
            width: 100px;
            margin-bottom: 8px;
        }

        h1, h2, h3 {
            color: #2c3e50;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 4px;
        }

        h2 {
            font-size: 16px;
            color: #7f8c8d;
            font-weight: normal;
        }

        .event-info {
            background-color: #f9f9f9;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 11px;
        }

        .info-row {
            display: flex;
            margin-bottom: 6px;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            color: #34495e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #e0e0e0;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
            text-align: center;
            font-size: 11px;
            padding: 6px 8px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .total-row {
            font-weight: bold;
            background-color: #ecf0f1 !important;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
            color: #7f8c8d;
            font-size: 10px;
        }

        .watermark {
            opacity: 0.08;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 60px;
            color: #3498db;
            pointer-events: none;
            z-index: -1;
            font-weight: bold;
        }

        .currency {
            text-align: right;
            white-space: nowrap;
        }

        .notes {
            margin-top: 15px;
            font-size: 11px;
            padding: 8px;
            background-color: #f5f5f5;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="watermark">CHIMINIKE</div>

    <div class="header">
        <img src="{{ public_path('img/manologochiminike.jpeg') }}" alt="Logo Museo Chiminike">
        <h1>Museo Interactivo Chiminike</h1>
        <h2>RESERVACIÓN DE EVENTO</h2>
    </div>

    <div class="event-info">
        <div class="info-row"><span class="info-label">Evento:</span> <span>{{ $reservacion['nombre_evento'] ?? '---' }}</span></div>
        <div class="info-row"><span class="info-label">Cliente:</span> <span>{{ $reservacion['cliente'] ?? '---' }}</span></div>
        <div class="info-row"><span class="info-label">Fecha del Evento:</span> <span>{{ isset($reservacion['fecha_programa']) ? \Carbon\Carbon::parse($reservacion['fecha_programa'])->format('d/m/Y') : '---' }}</span></div>
        <div class="info-row"><span class="info-label">Hora del Evento:</span> <span>{{ $reservacion['hora_programada'] ?? '---' }}</span></div>
        <div class="info-row"><span class="info-label">Duración:</span> <span>{{ $reservacion['horas_evento'] ?? '---' }} horas</span></div>
        <div class="info-row"><span class="info-label">Estado:</span> <span style="text-transform: capitalize;">{{ $reservacion['estado'] ?? '---' }}</span></div>
    </div>

    <table>
        <thead>
        <tr>
            <th style="width: 10%;">Cantidad</th>
            <th style="width: 40%;">Descripción</th>
            <th style="width: 15%;">Precio Unitario</th>
            <th style="width: 15%;">Impuesto (15%)</th>
            <th style="width: 20%;">Total</th>
        </tr>
        </thead>
        <tbody>
        @php $totalGeneral = 0; @endphp
        @foreach($productos as $producto)
            @php
                $precioUnitario = $producto['precio_unitario'] ?? 0;
                $cantidad = $producto['cantidad'] ?? 0;
                $subtotal = $cantidad * $precioUnitario;
                $impuesto = $subtotal * 0.15;
                $total = $subtotal + $impuesto;
                $totalGeneral += $total;
            @endphp
            <tr>
                <td style="text-align: center;">{{ $cantidad }}</td>
                <td>{{ $producto['descripcion'] ?? '' }}</td>
                <td class="currency">L {{ number_format($precioUnitario, 2) }}</td>
                <td class="currency">L {{ number_format($impuesto, 2) }}</td>
                <td class="currency">L {{ number_format($total, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr class="total-row">
            <td colspan="4" style="text-align: right;">TOTAL GENERAL</td>
            <td class="currency">L {{ number_format($totalGeneral, 2) }}</td>
        </tr>
        </tfoot>
    </table>

    @if(!empty($reservacion['notas']))
    <div class="notes">
        <strong>Notas:</strong> {{ $reservacion['notas'] }}
    </div>
    @endif

    <div class="footer">
        <p>Gracias por confiar en <strong>Museo Interactivo Chiminike</strong></p>
        <p>Para más información visite <a href="https://chiminike.org" style="color: #3498db;">chiminike.org</a> | Teléfono: (+504) 2232-1212</p>
        <p>Documento generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>
</div>
</body>
</html>
