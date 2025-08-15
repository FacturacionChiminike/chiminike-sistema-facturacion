<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cotización #{{ $cotizacion['cod_cotizacion'] }}</title>
    <style>
    @page {
        margin: 120px 40px 40px 40px;
    }

    header {
        position: fixed;
        top: -100px;
        left: 0;
        right: 0;
        height: 100px;
        background: #d9272e;
        color: white;
        text-align: left;
        padding: 15px 30px;
        font-size: 20px;
        font-weight: bold;
    }

    .diagonal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100px;
        background: linear-gradient(120deg, #d9272e 60%, #77777a 60%);
        z-index: -1;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    h1, h2, h3 {
        margin: 0;
        padding: 5px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 6px;
        text-align: left;
    }

    .info {
        margin-bottom: 20px;
    }

    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 10px;
        color: #aaa;
    }
</style>

</head>

<body>
    <h1>Fundación Chiminike</h1>

    <!-- Botón para enviar por correo -->
    <a href="{{ route('cotizacion.enviar', ['id' => $cotizacion['cod_cotizacion']]) }}" class="btn-correo">
        <i class="fas fa-paper-plane"></i> Enviar por correo
    </a>

    <h2>Cotización #{{ $cotizacion['cod_cotizacion'] }}</h2>

    <div class="info">
        <p><strong>Cliente:</strong> {{ $cotizacion['nombre_cliente'] }}</p>
        <p><strong>Fecha de Cotización:</strong> {{ $cotizacion['fecha'] }}</p>
        <p><strong>Fecha de Validez:</strong> {{ $cotizacion['fecha_validez'] }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($cotizacion['estado']) }}</p>
        <p><strong>Evento:</strong> {{ $cotizacion['nombre_evento'] }}</p>
        <p><strong>Fecha del Evento:</strong> {{ $cotizacion['fecha_programa'] }}</p>
        <p><strong>Hora del Evento:</strong> {{ $cotizacion['hora_programada'] }}</p>
    </div>

    <h3>Detalle de Productos</h3>
    <table>
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Precio Unitario (sin imp.)</th>
                <th>Impuesto (15%)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $prod)
                @php
                    $precioSinImp = round($prod['precio_unitario'] / 1.15, 2);
                    $impuesto = round($prod['precio_unitario'] - $precioSinImp, 2);
                @endphp
                <tr>
                    <td>{{ $prod['cantidad'] }}</td>
                    <td>{{ $prod['descripcion'] }}</td>
                    <td>L {{ number_format($precioSinImp, 2) }}</td>
                    <td>L {{ number_format($impuesto, 2) }}</td>
                    <td>L {{ number_format($prod['total'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="text-align: right; margin-top: 10px;">
        <strong>TOTAL GENERAL: L {{ number_format(collect($productos)->sum('total'), 2) }}</strong>
    </p>

    <!-- CDN de Font Awesome (por si no está incluido en tu layout principal) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" defer></script>
</body>

</html>