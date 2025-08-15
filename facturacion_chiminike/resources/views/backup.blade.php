<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Backups</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backup.css') }}">

</head>

<body>

    <div class="dashboard-container">
        @include('layouts.sidebar')

    <div class="container mt-4">

        <div class="mb-3">
            <a href="{{ url('/dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Regresar al Dashboard
            </a>
        </div>

        <h1 class="mb-4">Gestión de Backups</h1>

        <!-- Crear Backup -->
        @if(tienePermiso('Gestión de Backup', 'insertar'))
            <div class="mb-3">
                <button class="btn btn-primary" id="btnCrearBackup">
                    <i class="bi bi-download"></i> Crear Backup
                </button>
            </div>
        @endif

        <!-- Restaurar Backup -->
        @if(tienePermiso('Gestión de Backup', 'actualizar'))
            <div class="card p-3 mb-4">
                <h5>Restaurar Backup</h5>
                <form id="formRestaurarBackup" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="archivo" id="archivoBackup" class="form-control" required>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-upload"></i> Restaurar Backup
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Listado de Backups -->
        @if(tienePermiso('Gestión de Backup', 'mostrar'))
            <div class="card p-3">
                <h5>Backups existentes:</h5>
                <ul class="list-group mt-3" id="listaBackups">
                    @foreach($backups as $backup)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $backup }}
                            <a href="{{ route('backup.descargar', $backup) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-cloud-download"></i> Descargar
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tu JS -->
    <script src="{{ asset('js/backup.js') }}"></script>

</body>

</html>