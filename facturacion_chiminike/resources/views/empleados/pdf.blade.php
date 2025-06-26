<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de empleados actuales - Fundación Chiminike</title>
    <style>
        {!! file_get_contents(public_path('css/pdf.css')) !!}
    </style>
</head>

<body>
    <header>
        <div class="logo-container">
            <img src="{{ public_path('img/LogoChiminike.png') }}" class="logo izquierda" alt="Logo Chiminike">
            <img src="{{ public_path('img/LogoChiminike.png') }}" class="logo derecha" alt="Logo Chiminike">
        </div>
        <div class="encabezado">
            <h1>Fundación Chiminike</h1>
            <h2>Directorio de Colaboradores</h2>
            <p class="fecha">Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        </div>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombre Completo</th>
                    <th>Posición</th>
                    <th>Área</th>
                    <th>Salario (L.)</th>
                    <th>Estado</th>
                    <th>Contacto</th>
                    <th>Correo Electrónico</th>
                    <th>Ingreso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $emp)
                    <tr>
                        <td>{{ $emp['dni'] }}</td>
                        <td>{{ $emp['nombre'] }}</td>
                        <td>{{ $emp['cargo'] }}</td>
                        <td>{{ $emp['departamento_empresa'] }}</td>
                        <td>L. {{ number_format($emp['salario'], 2) }}</td>
                        <td data-estado="{{ $emp['estado'] }}">
                            @php
                                $estadoTexto = $emp['estado'] == 1 ? 'Activo' : 'Inactivo';
                                $color = $emp['estado'] == 1 ? '#2e7d32' : '#c62828';
                            @endphp
                            <span style="color: {{ $color }}">●</span> {{ $estadoTexto }}
                        </td>
                        <td>{{ $emp['telefono'] }}</td>
                        <td style="word-break: break-all;">{{ $emp['correo'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($emp['fecha_contratacion'])->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9">Total de colaboradores: {{ count($empleados) }} | © {{ date('Y') }} Fundación
                        Chiminike</td>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>