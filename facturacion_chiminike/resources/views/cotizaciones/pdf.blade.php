<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cotización - {{ $cotizacion['nombre_evento'] ?? 'Evento' }} | Museo Chiminike</title>
    <style>
        @page {
            margin: 0;
            size: letter;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .main-content {
            padding: 2.5cm 2cm;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            box-sizing: border-box;

            font-family: 'DejaVu Sans', sans-serif;
        }

        .container {
            max-width: 690px;
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

        h1,
        h2,
        h3 {
            color: #2c3e50;
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', sans-serif;
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

        th,
        td {
            border: 1px solid #e0e0e0;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #D9272E;
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
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
            color: #333;
            line-height: 1.5;
        }


        .watermark {
            opacity: 0.08;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 60px;
            color: #D9272E;
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

        .page {
            width: 100%;
            height: 100%;
            page-break-before: always;
            position: relative;
            margin: 0;
            padding: 0;
        }

        .full-page-img {
            width: 100%;
            height: 792pt;
            object-fit: cover;
            display: block;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="watermark">CHIMINIKE</div>

        <!-- ENCABEZADO INSTITUCIONAL -->
        <div style="text-align: center; margin-bottom: 10px; font-family: 'DejaVu Sans', sans-serif;">
            <img src="{{ public_path('img/manologochiminike.jpeg') }}" alt="Logo Chiminike"
                style="height: 60px; margin-bottom: 5px;">
            <p style="margin: 0; font-weight: bold;">COTIZACIÓN PARA EVENTO</p>
            <p style="margin: 0; font-weight: bold;">FUNDACIÓN PROFUTURO</p>
            <p style="margin: 0;">R.T.N. 08019003250037</p>
            <p style="margin: 0;">TELÉFONO: 2228-8577</p>
        </div>

        <!-- INFORMACIÓN DEL CLIENTE Y FECHA DE COTIZACIÓN -->
        <table style="width: 100%; font-size: 11px; margin-bottom: 10px; font-family: 'DejaVu Sans', sans-serif;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <strong>NOMBRE DEL CLIENTE:</strong> {{ $cotizacion['nombre_cliente'] ?? '---' }}<br>
                    <strong>FECHA DE COTIZACIÓN:</strong>
                    {{ \Carbon\Carbon::parse($cotizacion['fecha'])->format('d/m/Y') ?? '---' }}<br>
                    <em><strong>ESTADO:</strong> {{ ucfirst($cotizacion['estado']) ?? '---' }}</em>
                </td>

                <td style="width: 50%; vertical-align: top;">
                    <strong>CORREO:</strong> {{ $cotizacion['correo_cliente'] ?? '---' }}<br>
                    <strong>TELÉFONO:</strong> {{ $cotizacion['telefono_cliente'] ?? '---' }}<br>
                </td>

            </tr>
        </table>

        <hr style="border: 0.5px solid #ccc; margin: 10px 0;">

        @php
            use Carbon\Carbon;

            $horaInicio = Carbon::createFromFormat('H:i:s', $cotizacion['hora_programada'] ?? '00:00:00');
            $horaFin = $horaInicio->copy()->addHours($cotizacion['horas_evento'] ?? 0);
        @endphp

        <!-- INFORMACIÓN DEL EVENTO -->
        <table style="width: 100%; font-size: 11.5px; font-weight: bold; font-family: 'DejaVu Sans', sans-serif;">
            <tr>
                <td style="width: 50%;">
                    <strong>EVENTO:</strong> {{ $cotizacion['nombre_evento'] ?? '---' }}<br>
                    <strong>DURACIÓN:</strong> {{ $cotizacion['horas_evento'] ?? '---' }} horas
                </td>
                <td style="width: 50%;">
                    <strong>FECHA DEL EVENTO:</strong>
                    {{ \Carbon\Carbon::parse($cotizacion['fecha_programa'])->isoFormat('D [de] MMMM [de] YYYY') }}<br>
                    <strong>HORA DEL EVENTO:</strong> de {{ $horaInicio->format('g:i A') }} a
                    {{ $horaFin->format('g:i A') }}
                </td>
            </tr>
        </table>




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
                        $cantidad = intval($producto['cantidad'] ?? 0);
                        $precioUnitario = floatval($producto['precio_unitario'] ?? 0);
                        $subtotal = $cantidad * $precioUnitario;
                        $impuesto = round($subtotal * 0.15, 2);
                        $totalProducto = round($subtotal + $impuesto, 2);
                        $totalGeneral += $totalProducto;
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $cantidad }}</td>
                        <td>{{ $producto['descripcion'] ?? '' }}</td>
                        <td class="currency">L {{ number_format($precioUnitario, 2) }}</td>
                        <td class="currency">L {{ number_format($impuesto, 2) }}</td>
                        <td class="currency">L {{ number_format($totalProducto, 2) }}</td>
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

        @if(!empty($cotizacion['notas']))
            <div class="notes">
                <strong>Notas:</strong> {{ $cotizacion['notas'] }}
            </div>
        @endif

        <div class="footer">
            <p style="font-size: 10px;">
                <strong>Nota:</strong> La presente cotización no garantiza la reserva del salón o área,
                se confirma mediante el pago del 50% del total. El restante debe cancelarse dos días antes de realizar
                su evento.
            </p>

            <p style="font-size: 10px; margin-top: 8px;">
                <strong>Métodos de pago:</strong><br>
                - Depósito o transferencia Banco Atlántida, Cuenta No. <strong>1100136751</strong> a nombre de
                <strong>Fundación Profuturo</strong><br>
                - En nuestras oficinas en efectivo<br>
                - Tarjeta de crédito o débito
            </p>

            <p style="font-size: 10px; margin-top: 8px; font-style: italic;">
                Museo Chiminike no se responsabiliza por objetos olvidados dentro de las instalaciones.<br>
                Cualquier daño a las instalaciones o elementos/equipo de Museo Chiminike o proveedores correrá por costo
                del cliente,<br>
                quien deberá cancelar en efectivo o tarjeta su totalidad al finalizar el evento.
            </p>

            <p style="font-size: 10px; margin-top: 10px; color: #D9272E; font-weight: bold;">
                FAVOR ASEGURARSE DE PEDIR COPIA DE POLÍTICAS Y CONDICIONES DE EVENTOS PARA EVITAR CUALQUIER TIPO DE
                INCONVENIENTES.
            </p>
        </div>

    </div>

    {{-- Imágenes de políticas como páginas completas --}}
    @php
        $imagenesPoliticas = [
            public_path('img/politica1.png'),
            public_path('img/politica2.png'),
            public_path('img/politica3.png'),
            public_path('img/politica4.png'),
            public_path('img/politica5.png'),
        ];
    @endphp

    @foreach ($imagenesPoliticas as $img)
        <div class="page">
            <img src="{{ $img }}" class="full-page-img">
        </div>
    @endforeach
</body>

</html>