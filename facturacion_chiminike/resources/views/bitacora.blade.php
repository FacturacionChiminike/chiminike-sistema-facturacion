<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bitácora del Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bitacora.css') }}">
</head>

<body>

    <div class="dashboard-container">
        @include('layouts.sidebar')

    <div class="container mt-4">

        <!-- Botón de regreso y exportación -->
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ url('/dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Regresar al Dashboard
            </a>

            <a href="{{ route('bitacora.exportar', request()->all()) }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
            </a>
        </div>

        <h1 class="mb-4">Bitácora del Sistema</h1>

        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('bitacora') }}" class="mb-4">
            <div class="row g-3">

                <div class="col-md-3">
                    <label for="cod_usuario" class="form-label">Código de Usuario</label>
                    <input type="number" name="cod_usuario" id="cod_usuario" value="{{ request('cod_usuario') }}" class="form-control" placeholder="Todos">
                </div>

                <div class="col-md-3">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="objeto" class="form-label">Objeto</label>
                    <input type="text" name="objeto" id="objeto" value="{{ request('objeto') }}" class="form-control" placeholder="Todos">
                </div>

            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel-fill"></i> Filtrar
                </button>
            </div>
        </form>

        <!-- Tabla de resultados -->
        @if(isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Objeto</th>
                        <th>Acción</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bitacora as $log)
                        <tr>
                            <td>{{ $log['fecha'] }}</td>
                            <td>{{ $log['nombre_usuario'] }}</td>
                            <td>{{ $log['objeto'] }}</td>
                            <td>{{ $log['accion'] }}</td>
                            <td>{{ $log['descripcion'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <nav>
            <ul class="pagination justify-content-center">
                @for ($i = 1; $i <= 10; $i++)
                    <li class="page-item {{ $page == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('bitacora', array_merge(request()->all(), ['page' => $i])) }}">{{ $i }}</a>
                    </li>
                @endfor
            </ul>
        </nav>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
