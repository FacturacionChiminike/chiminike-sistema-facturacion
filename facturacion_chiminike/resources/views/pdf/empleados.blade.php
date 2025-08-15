<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 11px;
    color: #333;
    margin: 10px 18px 10px 18px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 9px;
    table-layout: fixed;
    word-break: break-word;
    margin-bottom: 18px;
  }
  th, td {
    border: 1px solid #e0e0e0;
    padding: 2.2px 3px;
    vertical-align: top;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  th {
    background-color: #057a48;
    color: #fff;
    font-weight: bold;
    text-align: center;
  }
  tr:nth-child(even) { background-color: #f8f9fa; }
  .currency { text-align: right; font-family: 'Courier New', monospace; color: #057a48; }
  .footer {
    font-size: 10px;
    color: #888;
    text-align: center;
    margin-top: 14px;
  }
  h1, h2 {
    color: #057a48;
    text-align: center;
    margin-bottom: 0.2em;
    margin-top: 0;
  }
  .logo-chiminike {
    width: 60px;
    margin: 0 10px 0 10px;
  }
  .header-bar {
    border-bottom: 2px solid #057a48;
    margin-bottom: 10px;
    padding-bottom: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .total-resumen {
    margin-bottom: 14px;
    margin-top: 8px;
    font-size: 12px;
    color: #057a48;
    font-weight: bold;
    text-align: left;
  }

  .fila-inactiva {
  background-color: #ffdadb !important;
}

</style>

@extends('pdf.layout')

@section('title', 'Reporte de Personas')
@section('header', 'Reporte de Personas')

@section('content')
<div class="total-resumen">
    Total de empleados: {{ count($empleados) }}<br>
    Total de clientes: {{ count($clientes) }}
  </div>
<div class="seccion">
    <h4>Reporte de Empleados</h4>
    <table>
        <thead>
            <tr>
                <th>Código</th><th>Nombre</th><th>DNI</th><th>Cargo</th><th>Salario</th>
                <th>Contratación</th><th>Departamento</th><th>Región</th>
                <th>Teléfono</th><th>Correo</th><th>Usuario</th><th>Rol</th><th>Estado</th>
            </tr>
        </thead>
        <tbody>
           @foreach($empleados as $e)
<tr>
    <td>{{ $e['cod_empleado'] }}</td>
    <td>{{ $e['nombre_empleado'] }}</td>
    <td>{{ $e['dni'] }}</td>
    <td>{{ $e['cargo'] }}</td>
    <td class="currency">{{ number_format($e['salario'],2) }}</td>
    <td>{{ \Carbon\Carbon::parse($e['fecha_contratacion'])->format('d/m/Y') }}</td>
    <td>{{ $e['departamento_empresa'] }}</td>
    <td>{{ $e['region_departamento'] }}</td>
    <td>{{ $e['telefono'] }}</td>
    <td>{{ $e['correo'] }}</td>
    <td>{{ $e['usuario'] }}</td>
    <td>{{ $e['rol'] }}</td>
   <td>
      @php
        $estadoTexto = $e['estado_usuario']==1 ? 'Activo' : 'Inactivo';
        $color = $e['estado_usuario']==1 ? '#2e7d32' : '#c62828';
      @endphp
      <span style="color: {{ $color }}">●</span> {{ $estadoTexto }}
    </td>
</tr>
@endforeach

        </tbody>
    </table>
</div>

<div class="seccion page-break">
    <h4>Reporte de Clientes</h4>
    <table>
        <thead>
            <tr>
                <th>Cliente</th><th>RTN</th><th>Tipo</th><th>DNI</th><th>Sexo</th><th>Nacimiento</th>
            </tr>
        </thead>
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
