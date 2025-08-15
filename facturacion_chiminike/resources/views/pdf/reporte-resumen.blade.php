<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Reportes</title>
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
        .grafico-container {
            margin-top: 20px;
            border: 1px solid #e0e0e0;
            padding: 12px;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .total-row {
            background-color: #e8f4fc !important;
            font-weight: bold;
            border-top: 2px solid #3498db;
        }
        .total-row td {
            color: #2c3e50;
        }
        .page-break {
            page-break-after: always;
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
    <h2>Resumen General de Reportes</h2>

    <div class="header-info">
        <strong>Fecha de generación:</strong> <span class="highlight">{{ now()->format('d/m/Y H:i') }}</span>
    </div>

    {{-- Sección 1: Ventas por mes --}}
    <div class="seccion">
        <h4>Ventas Mensuales</h4>
        <table>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Total Lps</th>
                </tr>
            </thead>
            <tbody>
                @php $totalVentas = 0; @endphp
                @foreach($ventasMensuales as $fila)
                    @php $totalVentas += $fila['total_ventas'] ?? 0; @endphp
                    <tr>
                        <td>{{ $fila['mes'] ?? 'N/A' }}</td>
                        <td class="currency">Lps {{ number_format($fila['total_ventas'] ?? 0, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total General</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($totalVentas, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 2: Top Clientes --}}
    <div class="seccion">
        <h4>Top Clientes</h4>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>RTN</th>
                    <th>Total Facturado</th>
                </tr>
            </thead>
            <tbody>
                @php $totalClientes = 0; @endphp
                @foreach($topClientes as $cliente)
                    @php $totalClientes += $cliente['total_facturado'] ?? 0; @endphp
                    <tr>
                        <td>{{ $cliente['cliente'] ?? 'N/A' }}</td>
                        <td>{{ $cliente['rtn'] ?? 'N/A' }}</td>
                        <td class="currency">Lps {{ number_format($cliente['total_facturado'] ?? 0, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2"><strong>Total General</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($totalClientes, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 3: Servicios Populares --}}
    <div class="seccion">
        <h4>Servicios Más Vendidos</h4>
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Ingresos</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $totalCantidad = 0;
                    $totalIngresos = 0;
                @endphp
                @foreach($serviciosPopulares as $item)
                    @php 
                        $totalCantidad += $item['cantidad'] ?? 0;
                        $totalIngresos += $item['ingresos'] ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $item['descripcion'] ?? 'N/A' }}</td>
                        <td>{{ number_format($item['cantidad'] ?? 0, 0) }}</td>
                        <td class="currency">Lps {{ number_format($item['ingresos'] ?? 0, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total General</strong></td>
                    <td><strong>{{ number_format($totalCantidad, 0) }}</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($totalIngresos, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 4: Ingresos por tipo --}}
    <div class="seccion">
        <h4>Ingresos por Tipo</h4>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Total Ingresos</th>
                </tr>
            </thead>
            <tbody>
                @php $totalIngresosTipo = 0; @endphp
                @foreach($ingresosPorTipo as $tipo)
                    @php $totalIngresosTipo += $tipo['ingresos'] ?? 0; @endphp
                    <tr>
                        <td>{{ $tipo['tipo'] ?? 'N/A' }}</td>
                        <td class="currency">Lps {{ number_format($tipo['ingresos'] ?? 0, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total General</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($totalIngresosTipo, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 5: Resumen por tipo de factura --}}
    <div class="seccion">
        <h4>Resumen por Tipo de Factura</h4>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $totalFacturas = 0;
                    $totalFacturasMonto = 0;
                @endphp
                @foreach($resumenPorTipo as $fila)
                    @php 
                        $totalFacturas += $fila['cantidad'] ?? 0;
                        $totalFacturasMonto += $fila['total'] ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $fila['tipo_factura'] ?? 'N/A' }}</td>
                        <td>{{ number_format($fila['cantidad'] ?? 0, 0) }}</td>
                        <td class="currency">Lps {{ number_format($fila['total'] ?? 0, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total General</strong></td>
                    <td><strong>{{ number_format($totalFacturas, 0) }}</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($totalFacturasMonto, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 6: Cotizaciones --}}
    <div class="seccion">
        <h4>Cotizaciones Realizadas</h4>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>RTN</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
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

    {{-- Sección 7: Entradas --}}
    <div class="seccion">
        <h4>Entradas Vendidas</h4>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                </tr>
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
                <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Duración</th>
                    <th>Cliente</th>
                    <th>RTN</th>
                </tr>
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

    {{-- Sección 9: Inventario --}}
    <div class="seccion">
        <h4>Inventario</h4>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $totalInventario = 0;
                    $totalCantidad = 0;
                @endphp
                @foreach($inventario as $item)
                    @php 
                        $totalInventario += ($item['precio_unitario'] ?? 0) * ($item['cantidad_disponible'] ?? 0);
                        $totalCantidad += $item['cantidad_disponible'] ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $item['cod_inventario'] ?? 'N/A' }}</td>
                        <td>{{ $item['nombre'] ?? 'N/A' }}</td>
                        <td>{{ $item['descripcion'] ?? 'N/A' }}</td>
                        <td class="currency">Lps {{ number_format($item['precio_unitario'] ?? 0, 2) }}</td>
                        <td>{{ number_format($item['cantidad_disponible'] ?? 0, 0) }}</td>
                        <td>{{ $item['estado'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3"><strong>Total General</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($totalInventario, 2) }}</strong></td>
                    <td><strong>{{ number_format($totalCantidad, 0) }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 10: Empleados --}}
    <div class="seccion">
        <h4>Reporte de Empleados</h4>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Cargo</th>
                    <th>Departamento</th>
                    <th>Región</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $e)
                    <tr>
                        <td>{{ $e['cod_empleado'] ?? 'N/A' }}</td>
                        <td>{{ $e['nombre_empleado'] ?? 'N/A' }}</td>
                        <td>{{ $e['dni'] ?? 'N/A' }}</td>
                        <td>{{ $e['cargo'] ?? 'N/A' }}</td>
                        <td>{{ $e['departamento_empresa'] ?? 'N/A' }}</td>
                        <td>{{ $e['region_departamento'] ?? 'N/A' }}</td>
                        <td>{{ $e['usuario'] ?? 'N/A' }}</td>
                        <td>{{ $e['rol'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($graficoBase64)
    <div class="seccion grafico-container">
        <h4>Gráfico Resumen</h4>
        <img src="{{ $graficoBase64 }}" style="width:100%; max-height:350px; display: block; margin: 0 auto;">
    </div>
    @endif

    {{-- Sección: Facturas Emitidas por Día --}}
<div class="seccion">
    <h4>Facturación por Día</h4>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cantidad de Facturas</th>
                <th>Total Facturado</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; $totalFacturas = 0; @endphp
            @foreach($facturasPorDia as $fila)
                @php 
                    $total += floatval($fila['total_facturado']);
                    $totalFacturas += $fila['cantidad_facturas'];
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($fila['dia'])->format('d/m/Y') }}</td>
                    <td>{{ $fila['cantidad_facturas'] }}</td>
                    <td class="currency">Lps {{ number_format($fila['total_facturado'], 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td><strong>Total</strong></td>
                <td><strong>{{ $totalFacturas }}</strong></td>
                <td class="currency"><strong>Lps {{ number_format($total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>


<h4 style="margin-top:30px;">Facturas por Cliente</h4>
<table style="width:100%; border-collapse: collapse;" border="1" cellpadding="5">
    <thead style="background-color: #f2f2f2;">
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>RTN</th>
            <th>Cant. Facturas</th>
            <th>Total Facturado (L)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($facturasPorCliente as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item['cliente'] }}</td>
            <td>{{ $item['rtn'] ?? 'N/A' }}</td>
            <td>{{ $item['cantidad_facturas'] }}</td>
            <td>{{ number_format($item['total_facturado'], 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Sección: Estado de Salones --}}
<div class="seccion">
    <h4>Estado de los Salones</h4>
    <table>
        <thead>
            <tr>
                <th>Estado</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSalones = 0; @endphp
            @foreach($salonesPorEstado as $item)
                @php 
                    $estadoTexto = $item['estado'] == 1 ? 'Disponible' : 'No Disponible';
                    $totalSalones += $item['cantidad'] ?? 0;
                @endphp
                <tr>
                    <td>{{ $estadoTexto }}</td>
                    <td>{{ $item['cantidad'] ?? 0 }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td><strong>Total General</strong></td>
                <td><strong>{{ $totalSalones }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>


    <div class="footer">
        Museo Chiminike &mdash; Sistema de Gestión | {{ now()->format('Y') }}
    </div>

</body>
</html>