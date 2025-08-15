<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
            background-color: #f8f9fc;
            padding: 30px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 25px 30px;
            max-width: 650px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #D9272E;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 20px;
        }

        strong {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <p><strong>Estimado {{ $cotizacion['cliente'] ?? 'Cliente' }},</strong></p>

        <p>
            Agradeciendo su preferencia y deseándole un feliz día, esperamos se encuentre en el pleno goce de sus funciones.
        </p>

        <p>
            Adjunto a este mensaje encontrará la cotización con los requerimientos de adaptación horaria solicitados para la celebración del evento <strong>{{ $cotizacion['nombre_evento'] ?? '---' }}</strong>,
            programado para llevarse a cabo en nuestras instalaciones del <strong>Salón Arte</strong>, el día
            <strong>{{ \Carbon\Carbon::parse($cotizacion['fecha_programa'])->locale('es')->translatedFormat('d \d\e F \d\e Y') }}</strong>
            a la hora <strong>{{ \Carbon\Carbon::parse($cotizacion['hora_programada'])->format('g:i A') }}</strong>.
        </p>

        @if(isset($cotizacion['estado']))
            <p><strong>Estado de la Cotización:</strong> {{ ucfirst($cotizacion['estado']) }}</p>
        @endif

        @if(isset($cotizacion['total']))
            <p><strong>Total Estimado:</strong> L {{ number_format($cotizacion['total'], 2) }}</p>
        @endif

        <p>
            En caso de tener alguna consulta o requerir mayor información, será un gusto poder agendar una llamada y conversar sobre los detalles del evento.
        </p>

        <p>
            Además, le invitamos cordialmente a <strong>leer detenidamente las políticas generales</strong> adjuntas en el documento PDF.
            Le recordamos especialmente que, por normativas internas, <strong style="color: black;">no se permite pegar, colgar ni fijar objetos</strong>
            en paredes, techos, pisos o ventanas. Agradecemos de antemano su comprensión y colaboración.
        </p>

        <p>Sin otro particular, quedamos atentos a su pronta respuesta.</p>

        <p><strong>Saludos cordiales,<br>Fundación Chiminike</strong></p>

       
    </div>
</body>
</html>
