<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Factura #{{ $factura['numero_factura'] }}</title>
  <style>
    /* A4 con márgenes mínimos */
    @page { size: A4 portrait; margin: 3.5mm 8mm; }
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;font-size:8.6px;color:#333;background:#fff}

    /* Dos copias en UNA página (más compacto) */
    :root{
      /* Si aún quieres más compacto, baja COPY_H a 139mm. */
      --COPY_H: 140mm;   /* altura asignada a cada copia completa */
      --GAP:     2.5mm;  /* separación entre copias */
      --LINE_Y:  calc(var(--COPY_H) + 1.2mm);
      --COPY2_Y: calc(var(--COPY_H) + var(--GAP));
    }
    .sheet{
      width: 194mm;                 /* 210 - 8 - 8  */
      height: 290mm;                /* 297 - 3.5 - 3.5 */
      margin: 0 auto; position: relative; overflow: hidden;
    }
    .copy{
      position:absolute; left:0; right:0; height:var(--COPY_H);
      overflow:hidden; page-break-inside:avoid;
    }
    .copy.emisor{ top:0 }
    .copy.cliente{ top:var(--COPY2_Y) }
    .cutline{ position:absolute; left:0; right:0; top:var(--LINE_Y); border-top:1px dashed #888 }

    /* Visual (todo reducido) */
    .page{width:100%}
    .top{width:100%;display:table;margin-bottom:4px}
    .top .col{display:table-cell;vertical-align:top}
    .top .left{width:65%}
    .top .right{width:35%;text-align:right}
    .org-title{font-weight:600;font-size:11px;color:#222;margin-bottom:1px}
    .factura-title{font-size:14px;font-weight:700;color:#222;margin-bottom:1px}
    .muted{color:#555;line-height:1.18}
    .divider{border-top:2px solid #555;margin:4px 0}

    table.clean{width:100%;border-collapse:collapse;margin-bottom:3px}
    table.clean td{border:1px solid #777;padding:2px 3px;background:#f4f4f4;font-size:8.5px}
    table.clean .label{font-weight:600;color:#222;width:22%}

    table.items{width:100%;border-collapse:collapse;margin-bottom:3px}
    table.items th,table.items td{border:1px solid #cfcfcf;padding:2px 3px;font-size:8.5px}
    table.items th{background:#eaeaea;text-transform:uppercase;font-weight:700}
    .txr{text-align:right}.txc{text-align:center}.txl{text-align:left}

    .totales{width:60%;margin-left:auto;border-collapse:collapse;margin-top:3px;margin-bottom:3px}
    .totales td{border:1px solid #cfcfcf;padding:2px 3px;font-size:8.5px}
    .totales td.label{width:60%;background:#f7f7f7}
    .totales td.moneda{width:6%;text-align:center;background:#fafafa}
    .totales td.valor{width:34%;text-align:right;background:#fafafa}

    .meta{font-size:8.2px;line-height:1.12;color:#555;margin-top:3px}
    .meta .row{margin:0.4px 0}
    .meta.columns{display:grid;grid-template-columns:1fr 1fr;column-gap:6mm}
    .footer{margin-top:4px;text-align:center;font-weight:700;font-size:8.6px}
  </style>
</head>
<body>
@php
  use Carbon\Carbon;
  Carbon::setLocale('es');

  // Fecha en letras
  $fecha = isset($factura['fecha_emision']) ? Carbon::parse($factura['fecha_emision']) : Carbon::now();
  $fechaLetras = $fecha->translatedFormat('d \\de F \\de Y');

  // Monto en letras (fallback)
  $montoLetras = $factura['total_pago_letras'] ?? null;
  if(!$montoLetras){
    $entero = floor($factura['total_pago'] ?? 0);
    $dec = round((($factura['total_pago'] ?? 0) - $entero) * 100);
    $montoLetras = number_format($entero,0,'.',',').' lempiras '.str_pad($dec,2,'0',STR_PAD_LEFT).'/100';
  }

  // Filas fijas en Ítems
  $tipoBoleteria = trim($factura['tipo_factura'] ?? '');
  $nombreCliente = trim($cliente['nombre'] ?? '');
  $descBoleteria = 'Boletería' . ($tipoBoleteria ? ' de '.$tipoBoleteria : '') . ($nombreCliente ? ' - '.$nombreCliente : '');
  $descMuseo = 'Museo de Chiminike';

  // Si es "Evento/Eventos": NO agregar la fila de Boletería
  $isEvento = preg_match('/^evento/i', $tipoBoleteria) === 1;

  // Fecha límite (del CAI activo si llega)
  $fechaLimiteVal = $fechaLimite ?? ($factura['fecha_limite'] ?? null);

  // Relleno de filas (compacto)
  $fixedRows = $isEvento ? 1 : 2;
  $minRows   = 4;
@endphp

<div class="sheet">
  <!-- ===== COPIA 1: Emisor ===== -->
  <div class="copy emisor">
    <div class="page">
      <div class="top">
        <div class="col left">
          <div style="margin-bottom:2px">
            <img src="{{ public_path('img/manologochiminike.jpeg') }}" alt="Logo" style="width:82px;height:auto">
          </div>
          <div class="org-title">Fundación profuturo</div>
          <div class="muted">RTN: {{ $factura['rtn_emisor'] ?? 'xxxxxxxxxxxxxx' }}</div>
          <div class="muted">Boulevard Fuerzas Armadas, Contiguo a corte suprema de Justicia, edificio Chiminike</div>
        </div>
        <div class="col right">
          <div class="factura-title">FACTURA</div>
          <div>{{ $factura['numero_factura'] ?? 'XXX-XXX-XX-XXXXXXX' }}</div>
          <div>Fecha: {{ $fechaLetras }}</div>
        </div>
      </div>

      <div class="divider"></div>

      <table class="clean">
        <tr>
          <td class="label">Nombre del cliente</td>
          <td>{{ $cliente['nombre'] ?? '—' }}</td>
          <td class="label">Boletería</td>
          <td>{{ $factura['tipo_factura'] ?? '—' }}</td>
        </tr>
        <tr>
          <td class="label">RTN/ID</td>
          <td>{{ $cliente['rtn'] ?? '—' }}</td>
          <td class="label">Dirección</td>
          <td>{{ $cliente['direccion'] ?? '—' }}</td>
        </tr>
      </table>

      <table class="items">
        <thead>
          <tr>
            <th class="txc" style="width:10%">Cantidad</th>
            <th class="txc" style="width:12%">código</th>
            <th class="txl">Descripción</th>
            <th class="txr" style="width:15%">Precio unit</th>
            <th class="txr" style="width:15%">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($detalles as $d)
          <tr>
            <td class="txc">{{ $d['cantidad'] }}</td>
            <td class="txc">{{ $d['codigo'] ?? '' }}</td>
            <td class="txl">{{ $d['descripcion'] }}</td>
            <td class="txr">L. {{ number_format($d['precio_unitario'],2) }}</td>
            <td class="txr">L. {{ number_format($d['total'],2) }}</td>
          </tr>
          @endforeach

          @if(!$isEvento)
          <tr>
            <td class="txc">0</td><td class="txc"></td>
            <td class="txl">{{ $descBoleteria }}</td>
            <td class="txr">L. 0.00</td><td class="txr">L. 0.00</td>
          </tr>
          @endif
          <tr>
            <td class="txc">0</td><td class="txc"></td>
            <td class="txl">{{ $descMuseo }}</td>
            <td class="txr">L. 0.00</td><td class="txr">L. 0.00</td>
          </tr>

          @for($i = count($detalles) + ($isEvento ? 1 : 2); $i < $minRows; $i++)
            <tr><td class="txc">&nbsp;</td><td class="txc"></td><td class="txl"></td><td class="txr"></td><td class="txr"></td></tr>
          @endfor
        </tbody>
      </table>

      <table class="totales">
        <tr><td class="label">Descuento Otorgado</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['descuento_otorgado'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Rebajas Otorgadas</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['rebajas_otorgadas'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Sub total</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['subtotal'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Importe Exento</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['importe_exento'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Importe Gravado 18%</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['importe_gravado_18'] ?? 0,2) }}</td></tr>
        <tr><td class="label">18% Imp. s/v</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['impuesto_18'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Importe Gravado 15%</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['importe_gravado_15'] ?? 0,2) }}</td></tr>
        <tr><td class="label">15% Imp. s/v</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['impuesto_15'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Importe Exonerado</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['importe_exonerado'] ?? 0,2) }}</td></tr>
        <tr><td class="label"><strong>Total a pagar</strong></td><td class="moneda"><strong>L</strong></td><td class="valor"><strong>{{ number_format($factura['total_pago'] ?? 0,2) }}</strong></td></tr>
      </table>

      <!-- Bloques inferiores -->
      <div class="meta">
        <div class="row">No. Correlativo de la Orden de Compra Exenta</div>
        <div class="row">No. Correlativo de la Const. del Reg. De Exonerado</div>
        <div class="row">No. Identif. del Reg. de la SAG</div>
      </div>
      <div class="meta columns" style="margin-top:2px">
        <div>
          <div class="row">Son: {{ ucfirst($montoLetras) }}</div>
          <div class="row">CAI: {{ $factura['cai_numero'] ?? 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' }}</div>
        </div>
        <div>
          <div class="row">Rango: {{ $factura['rango_desde'] ?? 'xxx-xx-xx-xxxxxxx' }} &nbsp; Hasta: {{ $factura['rango_hasta'] ?? 'xxx-xx-xx-xxxxxxx' }}</div>
          <div class="row">Fecha límite de emisión: {{ $fechaLimiteVal ? \Carbon\Carbon::parse($fechaLimiteVal)->format('d/m/Y') : '' }}</div>
        </div>
      </div>

      <div class="divider"></div>
      <div class="footer">Copia- Obligado Tributario Emisor</div>
    </div>
  </div>

  <div class="cutline"></div>

  <!-- ===== COPIA 2: Cliente ===== -->
  <div class="copy cliente">
    <div class="page">
      <div class="top">
        <div class="col left">
          <div style="margin-bottom:2px">
            <img src="{{ public_path('img/manologochiminike.jpeg') }}" alt="Logo" style="width:82px;height:auto">
          </div>
          <div class="org-title">Fundación profuturo</div>
          <div class="muted">RTN: {{ $factura['rtn_emisor'] ?? 'xxxxxxxxxxxxxx' }}</div>
          <div class="muted">Boulevard Fuerzas Armadas, Contiguo a corte suprema de Justicia, edificio Chiminike</div>
        </div>
        <div class="col right">
          <div class="factura-title">FACTURA</div>
          <div>{{ $factura['numero_factura'] ?? 'XXX-XXX-XX-XXXXXXX' }}</div>
          <div>Fecha: {{ $fechaLetras }}</div>
        </div>
      </div>

      <div class="divider"></div>

      <table class="clean">
        <tr>
          <td class="label">Nombre del cliente</td>
          <td>{{ $cliente['nombre'] ?? '—' }}</td>
          <td class="label">Boletería</td>
          <td>{{ $factura['tipo_factura'] ?? '—' }}</td>
        </tr>
        <tr>
          <td class="label">RTN/ID</td>
          <td>{{ $cliente['rtn'] ?? '—' }}</td>
          <td class="label">Dirección</td>
          <td>{{ $cliente['direccion'] ?? '—' }}</td>
        </tr>
      </table>

      <table class="items">
        <thead>
          <tr>
            <th class="txc" style="width:10%">Cantidad</th>
            <th class="txc" style="width:12%">código</th>
            <th class="txl">Descripción</th>
            <th class="txr" style="width:15%">Precio unit</th>
            <th class="txr" style="width:15%">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($detalles as $d)
          <tr>
            <td class="txc">{{ $d['cantidad'] }}</td>
            <td class="txc">{{ $d['codigo'] ?? '' }}</td>
            <td class="txl">{{ $d['descripcion'] }}</td>
            <td class="txr">L. {{ number_format($d['precio_unitario'],2) }}</td>
            <td class="txr">L. {{ number_format($d['total'],2) }}</td>
          </tr>
          @endforeach

          @if(!$isEvento)
          <tr>
            <td class="txc">0</td><td class="txc"></td>
            <td class="txl">{{ $descBoleteria }}</td>
            <td class="txr">L. 0.00</td><td class="txr">L. 0.00</td>
          </tr>
          @endif
          <tr>
            <td class="txc">0</td><td class="txc"></td>
            <td class="txl">{{ $descMuseo }}</td>
            <td class="txr">L. 0.00</td><td class="txr">L. 0.00</td>
          </tr>

          @for($i = count($detalles) + ($isEvento ? 1 : 2); $i < $minRows; $i++)
            <tr><td class="txc">&nbsp;</td><td class="txc"></td><td class="txl"></td><td class="txr"></td><td class="txr"></td></tr>
          @endfor
        </tbody>
      </table>

      <table class="totales">
        <tr><td class="label">Descuento Otorgado</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['descuento_otorgado'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Rebajas Otorgadas</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['rebajas_otorgadas'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Sub total</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['subtotal'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Importe Exento</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['importe_exento'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Importe Gravado 18%</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['importe_gravado_18'] ?? 0,2) }}</td></tr>
        <tr><td class="label">18% Imp. s/v</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['impuesto_18'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Importe Gravado 15%</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['importe_gravado_15'] ?? 0,2) }}</td></tr>
        <tr><td class="label">15% Imp. s/v</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['impuesto_15'] ?? 0,2) }}</td></tr>
        <tr><td class="label">Importe Exonerado</td><td class="moneda">L</td><td class="valor">{{ number_format($factura['importe_exonerado'] ?? 0,2) }}</td></tr>
        <tr><td class="label"><strong>Total a pagar</strong></td><td class="moneda"><strong>L</strong></td><td class="valor"><strong>{{ number_format($factura['total_pago'] ?? 0,2) }}</strong></td></tr>
      </table>

      <div class="meta">
        <div class="row">No. Correlativo de la Orden de Compra Exenta</div>
        <div class="row">No. Correlativo de la Const. del Reg. De Exonerado</div>
        <div class="row">No. Identif. del Reg. de la SAG</div>
      </div>
      <div class="meta columns" style="margin-top:2px">
        <div>
          <div class="row">Son: {{ ucfirst($montoLetras) }}</div>
          <div class="row">CAI: {{ $factura['cai_numero'] ?? 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' }}</div>
        </div>
        <div>
          <div class="row">Rango: {{ $factura['rango_desde'] ?? 'xxx-xx-xx-xxxxxxx' }} &nbsp; Hasta: {{ $factura['rango_hasta'] ?? 'xxx-xx-xx-xxxxxxx' }}</div>
          <div class="row">Fecha límite de emisión: {{ $fechaLimiteVal ? \Carbon\Carbon::parse($fechaLimiteVal)->format('d/m/Y') : '' }}</div>
        </div>
      </div>

      <div class="divider"></div>
      <div class="footer">Copia del Cliente</div>
    </div>
  </div>

  <div class="cutline"></div>
</div>
</body>
</html>
