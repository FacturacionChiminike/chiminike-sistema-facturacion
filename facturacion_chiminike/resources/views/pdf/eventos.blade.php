@extends('pdf.layout')

@section('title', 'Reporte de Eventos')
@section('header', 'Reporte de Eventos')

@section('content')
<div class="seccion">
    <table>
        <thead><tr><th>Código</th><th>Nombre</th><th>Fecha</th>
            <th>Hora</th><th>Cotización</th><th>Horas</th></tr></thead>
        <tbody>
            @foreach($eventos as $e)
            <tr>
                <td>{{ $e->cod_evento }}</td>
                <td>{{ $e->nombre }}</td>
                <td>{{ \Carbon\Carbon::parse($e->fecha_programa)->format('d/m/Y') }}</td>
                <td>{{ $e->hora_programada }}</td>
                <td>{{ $e->cod_cotizacion }}</td>
                <td>{{ $e->horas_evento }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
