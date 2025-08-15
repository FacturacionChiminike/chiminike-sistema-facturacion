@component('mail::message')
# Estimado cliente,

Adjuntamos la reservación confirmada para su evento en el Museo Chiminike:

- **Evento:** {{ $reservacion['nombre_evento'] ?? '---' }}
- **Fecha del Evento:** {{ $reservacion['fecha_programa'] ?? '---' }}
- **Hora del Evento:** {{ $reservacion['hora_programada'] ?? '---' }}

@if(isset($reservacion['estado']))
- **Estado de Reservación:** {{ ucfirst($reservacion['estado']) }}
@endif

@if(isset($reservacion['cliente']))
- **Cliente:** {{ $reservacion['cliente'] }}
@endif

@if(isset($reservacion['total']))
- **Total Confirmado:** L {{ number_format($reservacion['total'], 2) }}
@endif

Si necesita realizar modificaciones o consultar disponibilidad adicional, estamos a su disposición.

@component('mail::button', ['url' => 'https://chiminike.org/contacto'])
Contactar a Chiminike
@endcomponent

Gracias por confiar en **Chiminike** para su evento.

Saludos cordiales,  
**Fundación Chiminike**
@endcomponent
