<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservación de Evento - Museo Chiminike</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 12px;
            margin: 30px;
        }
        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .logo {
            width: 60px;
            height: auto;
        }
        .titulo {
            text-align: center;
        }
        .titulo h2 {
            margin: 0;
            font-size: 16px;
        }
        .titulo p {
            margin: 0;
            font-size: 13px;
            font-weight: 500;
        }
        .datos {
            margin: 20px 0;
            font-size: 12px;
        }
        .datos p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        table th {
            background-color: #e5e5e5;
        }
        .total-row {
            font-weight: bold;
        }
        .mensaje {
            text-align: center;
            margin-top: 20px;
            font-style: italic;
        }
        .footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="encabezado">
        <img src="{{ public_path('img/manologochiminike.jpeg') }}" alt="Logo Chiminike" class="logo">
        <div class="titulo">
            <h2>Museo Chiminike</h2>
            <p>Reservación de Evento</p>
        </div>
        <img src="{{ public_path('img/manologochiminike.jpeg') }}" alt="Logo Chiminike" class="logo">
    </div>

    <div class="datos">
        <p><strong>Evento:</strong> {{ $evento['nombre_evento'] }}</p>
        <p><strong>Cliente:</strong> {{ $evento['cliente'] }}</p>
        <p><strong>Hora de inicio:</strong> {{ $evento['hora_programada'] }}</p>
        <p><strong>Horas de evento:</strong> {{ $evento['horas_evento'] }}</p>
        <p><strong>Estado:</strong> {{ $evento['estado'] }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($productos as $p)
                <tr>
                    <td>{{ $p['cantidad'] }}</td>
                    <td>{{ $p['descripcion'] }}</td>
                    <td>L {{ number_format($p['precio_unitario'], 2) }}</td>
                    <td>L {{ number_format($p['total'], 2) }}</td>
                </tr>
                @php $total += $p['total']; @endphp
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td>L {{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <p class="mensaje">y aquí un mensaje que bonito</p>

    <div class="footer">
        Fundación Chiminike &bull; Reservación generada el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
