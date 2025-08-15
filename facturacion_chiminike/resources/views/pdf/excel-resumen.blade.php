<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen General de Reportes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;  
            margin-bottom: 20px;
        }
        th {
            background-color: #d9e1f2;
            border: 1px solid #999;
            padding: 5px;
            text-align: left;
            font-weight: bold;
        }
        td {
            border: 1px solid #ccc;
            padding: 5px;
        }
        img {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
        }
        .report-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .section-title {
            background-color: #f2f2f2;
            padding: 8px;
            margin-top: 30px;
            border-left: 4px solid #4CAF50;
            font-weight: bold;
            font-size: 14px;
        }
        .total-row {
            background-color: #e8f4fc;
            font-weight: bold;
        }
        .currency {
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="report-title">
        <h2>Resumen General de Reportes</h2>
        <p><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Gráfico de ingresos -->
    @if(isset($graficoBase64))
        <div class="section-title">
            <h3>Gráfico de Ingresos</h3>
        </div>
        <img src="{{ $graficoBase64 }}" alt="Gráfico de Ingresos">
    @endif

    {{-- Ventas Mensuales --}}
    <div class="section-title">
        <h3>Ventas Mensuales</h3>
    </div>
    <table>
        <thead>
            <tr><th>Mes</th><th>Total Lps</th></tr>
        </thead>
        <tbody>
            @php $totalVentas = 0; @endphp
            @foreach($ventasMensuales as $fila)
                @php $totalVentas += $fila->total_ventas; @endphp
                <tr>
                    <td>{{ $fila->mes }}</td>
                    <td class="currency">{{ number_format($fila->total_ventas, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td><strong>Total</strong></td>
                <td class="currency"><strong>{{ number_format($totalVentas, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Top Clientes --}}
    <div class="section-title">
        <h3>Top Clientes</h3>
    </div>
    <table>
        <thead>
            <tr><th>Cliente</th><th>RTN</th><th>Total Facturado</th></tr>
        </thead>
        <tbody>
            @php $totalClientes = 0; @endphp
            @foreach($topClientes as $cliente)
                @php $totalClientes += $cliente->total_facturado; @endphp
                <tr>
                    <td>{{ $cliente->cliente }}</td>
                    <td>{{ $cliente->rtn }}</td>
                    <td class="currency">{{ number_format($cliente->total_facturado, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2"><strong>Total</strong></td>
                <td class="currency"><strong>{{ number_format($totalClientes, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Servicios Populares --}}
    <div class="section-title">
        <h3>Servicios Más Vendidos</h3>
    </div>
    <table>
        <thead>
            <tr><th>Descripción</th><th>Cantidad</th><th>Ingresos</th></tr>
        </thead>
        <tbody>
            @php $totalCant = 0; $totalIng = 0; @endphp
            @foreach($serviciosPopulares as $serv)
                @php 
                    $totalCant += $serv->cantidad; 
                    $totalIng += $serv->ingresos; 
                @endphp
                <tr>
                    <td>{{ $serv->descripcion }}</td>
                    <td>{{ $serv->cantidad }}</td>
                    <td class="currency">{{ number_format($serv->ingresos, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td><strong>Total</strong></td>
                <td><strong>{{ $totalCant }}</strong></td>
                <td class="currency"><strong>{{ number_format($totalIng, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Ingresos por tipo --}}
    <div class="section-title">
        <h3>Ingresos por Tipo</h3>
    </div>
    <table>
        <thead>
            <tr><th>Tipo</th><th>Total</th></tr>
        </thead>
        <tbody>
            @php $totalTipo = 0; @endphp
            @foreach($ingresosPorTipo as $tipo)
                @php $totalTipo += $tipo->ingresos; @endphp
                <tr>
                    <td>{{ $tipo->tipo }}</td>
                    <td class="currency">{{ number_format($tipo->ingresos, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td><strong>Total</strong></td>
                <td class="currency"><strong>{{ number_format($totalTipo, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Resumen por tipo de factura --}}
    <div class="section-title">
        <h3>Resumen por Tipo de Factura</h3>
    </div>
    <table>
        <thead>
            <tr><th>Tipo</th><th>Cantidad</th><th>Total</th></tr>
        </thead>
        <tbody>
            @php $cant = 0; $monto = 0; @endphp
            @foreach($resumenPorTipo as $tipo)
                @php 
                    $cant += $tipo->cantidad; 
                    $monto += $tipo->total; 
                @endphp
                <tr>
                    <td>{{ $tipo->tipo_factura }}</td>
                    <td>{{ $tipo->cantidad }}</td>
                    <td class="currency">{{ number_format($tipo->total, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td><strong>Total</strong></td>
                <td><strong>{{ $cant }}</strong></td>
                <td class="currency"><strong>{{ number_format($monto, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Cotizaciones --}}
    <div class="section-title">
        <h3>Cotizaciones Realizadas</h3>
    </div>
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
                @php $totalCotizaciones += $item->total_cotizacion; @endphp
                <tr>
                    <td>{{ $item->cod_cotizacion }}</td>
                    <td>{{ $item->fecha }}</td>
                    <td>{{ $item->cliente }}</td>
                    <td>{{ $item->rtn }}</td>
                    <td class="currency">{{ number_format($item->total_cotizacion, 2) }}</td>
                    <td>{{ $item->estado }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4"><strong>Total</strong></td>
                <td class="currency"><strong>{{ number_format($totalCotizaciones, 2) }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    {{-- Entradas --}}
    <div class="section-title">
        <h3>Entradas Vendidas</h3>
    </div>
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
                @php $totalEntradas += $item->total; @endphp
                <tr>
                    <td>{{ $item->cod_entrada }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td class="currency">{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2"><strong>Total</strong></td>
                <td class="currency"><strong>{{ number_format($totalEntradas, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Reservaciones --}}
    <div class="section-title">
        <h3>Reservaciones</h3>
    </div>
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
                    <td>{{ $item->nombre_evento }}</td>
                    <td>{{ $item->fecha_programa }}</td>
                    <td>{{ $item->hora_programada }}</td>
                    <td>{{ $item->horas_evento }} horas</td>
                    <td>{{ $item->cliente }}</td>
                    <td>{{ $item->rtn }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Inventario --}}
    <div class="section-title">
        <h3>Inventario</h3>
    </div>
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
                    $totalInventario += ($item->precio_unitario * $item->cantidad_disponible);
                    $totalCantidad += $item->cantidad_disponible;
                @endphp
                <tr>
                    <td>{{ $item->cod_inventario }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td class="currency">{{ number_format($item->precio_unitario, 2) }}</td>
                    <td>{{ $item->cantidad_disponible }}</td>
                    <td>{{ $item->estado }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3"><strong>Total</strong></td>
                <td class="currency"><strong>{{ number_format($totalInventario, 2) }}</strong></td>
                <td><strong>{{ $totalCantidad }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    {{-- Empleados --}}
    <div class="section-title">
        <h3>Reporte de Empleados</h3>
    </div>
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
                    <td>{{ $e->cod_empleado }}</td>
                    <td>{{ $e->nombre_empleado }}</td>
                    <td>{{ $e->dni }}</td>
                    <td>{{ $e->cargo }}</td>
                    <td>{{ $e->departamento_empresa }}</td>
                    <td>{{ $e->region_departamento }}</td>
                    <td>{{ $e->usuario }}</td>
                    <td>{{ $e->rol }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>