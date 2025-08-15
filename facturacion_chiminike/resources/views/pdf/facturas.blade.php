<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Facturación</title>
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
        .total-row td {
            color: #2c3e50;
        }
        .page-break {
            page-break-after: always;
        }
        .grafico-container {
            margin-top: 20px;
            border: 1px solid #e0e0e0;
            padding: 12px;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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
    <div style="text-align:center; margin-bottom:20px;">
        <img src="{{ public_path('img/manologochiminike.jpeg') }}" alt="Logo Chiminike" style="width:120px; height:auto;">
    </div>

    <h2>Resumen de Facturación</h2>

    <div class="header-info">
        <strong>Fecha de generación:</strong>
        <span>{{ $fechaGeneracion }}</span>
    </div>

    {{-- Sección: Resumen General --}}
    <div class="seccion">
        <h4>Resumen General</h4>
        <table>
            <thead>
                <tr>
                    <th>Métrica</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalVentas     = array_sum(array_column($ventasMensuales, 'total_ventas'));
                    $totalFacturas   = array_sum(array_column($facturasPorDia, 'cantidad_facturas'));
                @endphp
                <tr>
                    <td>Total Facturado</td>
                    <td class="currency">Lps {{ number_format($totalVentas, 2) }}</td>
                </tr>
                <tr>
                    <td>Facturas Emitidas</td>
                    <td>{{ $totalFacturas }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 1: Ventas por mes --}}
    <div class="seccion">
        <h4>Ventas Mensuales</h4>
        <table>
            <thead>
                <tr><th>Mes</th><th>Total Lps</th></tr>
            </thead>
            <tbody>
                @php $sum = 0; @endphp
                @foreach($ventasMensuales as $fila)
                    @php $sum += $fila['total_ventas'] ?? 0; @endphp
                    <tr>
                        <td>{{ $fila['mes'] ?? 'N/A' }}</td>
                        <td class="currency">Lps {{ number_format($fila['total_ventas'] ?? 0, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total General</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($sum, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 2: Top Clientes --}}
    <div class="seccion">
        <h4>Top Clientes</h4>
        <table>
            <thead>
                <tr><th>Cliente</th><th>RTN</th><th>Total Facturado</th></tr>
            </thead>
            <tbody>
                @php $sumCli = 0; @endphp
                @foreach($topClientes as $c)
                    @php $sumCli += $c['total_facturado'] ?? 0; @endphp
                    <tr>
                        <td>{{ $c['cliente'] }}</td>
                        <td>{{ $c['rtn'] }}</td>
                        <td class="currency">Lps {{ number_format($c['total_facturado'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2"><strong>Total General</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($sumCli, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 3: Servicios Populares --}}
    <div class="seccion">
        <h4>Servicios Más Vendidos</h4>
        <table>
            <thead>
                <tr><th>Descripción</th><th>Cantidad</th><th>Ingresos</th></tr>
            </thead>
            <tbody>
                @php $sumCant = 0; $sumIng = 0; @endphp
                @foreach($serviciosPopulares as $s)
                    @php
                        $sumCant += $s['cantidad'] ?? 0;
                        $sumIng  += $s['ingresos'] ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $s['descripcion'] }}</td>
                        <td>{{ number_format($s['cantidad'], 0) }}</td>
                        <td class="currency">Lps {{ number_format($s['ingresos'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total General</strong></td>
                    <td><strong>{{ number_format($sumCant, 0) }}</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($sumIng, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 4: Ingresos por tipo --}}
    <div class="seccion">
        <h4>Ingresos por Tipo</h4>
        <table>
            <thead><tr><th>Tipo</th><th>Total Ingresos</th></tr></thead>
            <tbody>
                @php $sumTipo = 0; @endphp
                @foreach($ingresosPorTipo as $t)
                    @php $sumTipo += $t['ingresos'] ?? 0; @endphp
                    <tr>
                        <td>{{ $t['tipo'] }}</td>
                        <td class="currency">Lps {{ number_format($t['ingresos'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total General</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($sumTipo, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sección 5: Resumen por tipo de factura --}}
    <div class="seccion">
        <h4>Resumen por Tipo de Factura</h4>
        <table>
            <thead><tr><th>Tipo</th><th>Cantidad</th><th>Total</th></tr></thead>
            <tbody>
                @php $sumFac = 0; $sumFacTot = 0; @endphp
                @foreach($resumenPorTipo as $r)
                    @php
                        $sumFac    += $r['cantidad'] ?? 0;
                        $sumFacTot += $r['total'] ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $r['tipo_factura'] }}</td>
                        <td>{{ number_format($r['cantidad'], 0) }}</td>
                        <td class="currency">Lps {{ number_format($r['total'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total General</strong></td>
                    <td><strong>{{ number_format($sumFac, 0) }}</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($sumFacTot, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Gráfico opcional --}}
    @if(!empty($graficoBase64))
    <div class="seccion grafico-container">
        <h4>Gráfico Resumen</h4>
        <img src="{{ $graficoBase64 }}" style="width:100%; max-height:350px; display:block; margin:0 auto;">
    </div>
    @endif

    {{-- Sección: Facturación por Día --}}
    <div class="seccion page-break">
        <h4>Facturación por Día</h4>
        <table>
            <thead><tr><th>Fecha</th><th>Cant. Facturas</th><th>Total Facturado</th></tr></thead>
            <tbody>
                @php $sumDia = 0; $sumCntDia = 0; @endphp
                @foreach($facturasPorDia as $d)
                    @php
                        $sumDia    += $d['total_facturado'] ?? 0;
                        $sumCntDia += $d['cantidad_facturas'] ?? 0;
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($d['dia'])->format('d/m/Y') }}</td>
                        <td>{{ $d['cantidad_facturas'] }}</td>
                        <td class="currency">Lps {{ number_format($d['total_facturado'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $sumCntDia }}</strong></td>
                    <td class="currency"><strong>Lps {{ number_format($sumDia, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

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
    </div>

    <div class="footer">
        Museo Chiminike &mdash; Sistema de Gestión | {{ now()->format('Y') }}
    </div>
</body>
</html>
