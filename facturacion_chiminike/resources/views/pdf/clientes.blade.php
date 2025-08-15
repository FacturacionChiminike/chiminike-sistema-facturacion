@extends('pdf.layout')

@section('title', 'Reporte de Clientes')
@section('header', 'Reporte de Clientes')

@section('content')
<div class="seccion">
    <table>
        <thead><tr><th>Cliente</th><th>RTN</th><th>Tipo</th><th>DNI</th><th>Sexo</th><th>Nacimiento</th></tr></thead>
        <tbody>
            @foreach($clientes as $c)
            <tr>
                <td>{{ $c->cliente }}</td>
                <td>{{ $c->rtn }}</td>
                <td>{{ $c->tipo_cliente }}</td>
                <td>{{ $c->dni }}</td>
                <td>{{ $c->sexo }}</td>
                <td>{{ \Carbon\Carbon::parse($c->fecha_nacimiento)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
