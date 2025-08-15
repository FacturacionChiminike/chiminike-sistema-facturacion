@extends('pdf.layout')

@section('title', 'Reporte de Reservaciones')
@section('header', 'Reporte de Reservaciones')

@section('content')
<div class="seccion">
    <table>
        <thead>
            <tr><th>Evento</th><th>Fecha</th><th>Hora</th>
                <th>Duración</th><th>Cliente</th><th>RTN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservaciones as $r)
            <tr>
                <td>{{ $r->nombre_evento }}</td>
                <td>{{ \Carbon\Carbon::parse($r->fecha_programa)->format('d/m/Y') }}</td>
                <td>{{ $r->hora_programada }}</td>
                <td>{{ $r->horas_evento }} hrs</td>
                <td>{{ $r->cliente }}</td>
                <td>{{ $r->rtn }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
