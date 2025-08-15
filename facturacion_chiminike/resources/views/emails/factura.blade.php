<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tu Factura Electrónica</title>
</head>
<body style="margin:0; padding:0; background:#ffffff;">

  <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <!-- Encabezado rojo -->
    <div style="background:#D32F2F; color:#ffffff; padding:20px; text-align:center;">
      <h2 style="margin:0;">
        <span style="color:#2E7D32;">MUSEO</span> CHIMINIKE
      </h2>
      <p style="margin:0;">¡Gracias por tu compra!</p>
    </div>

    <!-- Cuerpo blanco -->
    <div style="background:#ffffff; padding:24px; color:#2c3e50;">
      <p>Hola <b>{{ $facturaData['cliente'] ?? 'Cliente' }}</b>,</p>
      <p>Adjunto encontrarás tu factura electrónica:</p>
      <ul>
        <li><b>N° Factura:</b> {{ $facturaData['numero_factura'] ?? '' }}</li>
        <li><b>Fecha:</b>
  {{ isset($facturaData['fecha_emision'])
      ? \Carbon\Carbon::parse($facturaData['fecha_emision'])->format('d/m/Y')
      : '' }}
</li>

        <li><b>Total:</b> L. {{ number_format($facturaData['total_pago'] ?? 0, 2) }}</li>
      </ul>
      <p style="margin:16px 0 0;">
        Gracias por confiar en Museo Chiminike.<br>
        Para cualquier consulta responde este correo.
      </p>

      <hr style="border:0; border-top:1px solid #e6e6e6; margin:20px 0;">

      <!-- Botón verde -->
      <div style="text-align:center; margin:12px 0;">
        <a href="https://www.chiminike.org"
           style="background:#2E7D32; color:#ffffff; padding:8px 24px; border-radius:6px; text-decoration:none; display:inline-block;">
           Ir al sitio
        </a>
      </div>
    </div>

    <!-- Pie crema -->
    <div style="background:#F1F0EA; padding:12px; text-align:center; color:#666; font-size:12px;">
      © {{ date('Y') }} Museo Chiminike. Todos los derechos reservados.
    </div>
  </div>

</body>
</html>
