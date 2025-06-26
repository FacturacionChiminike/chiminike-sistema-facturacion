<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Salones</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/salones.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>

    <div class="dashboard-container">
        @include('layouts.sidebar')

    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Salones</h2>
            <div>
                <a href="/dashboard" class="btn btn-secondary me-2">Regresar al Dashboard</a>
                @if(tienePermiso('Gestión de salones', 'insertar'))
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevo">
                        Nuevo Salón
                    </button>
                @endif

            </div>
        </div>

        <div class="mb-3">
            <input type="text" id="buscarSalon" class="form-control" placeholder="Buscar salón...">
        </div>

        <table class="table table-striped table-bordered" id="tablaSalones">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                    <th>Precio Día</th>
                    <th>Hora Extra Día</th>
                    <th>Precio Noche</th>
                    <th>Hora Extra Noche</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salones as $salon)
                    <tr data-id="{{ $salon['cod_salon'] }}">
                        <td>{{ $salon['nombre'] }}</td>
                        <td>{{ $salon['descripcion'] }}</td>
                        <td>{{ $salon['capacidad'] }}</td>
                        <td>{{ $salon['estado'] }}</td>
                        <td>{{ $salon['precio_dia'] }}</td>
                        <td>{{ $salon['precio_hora_extra_dia'] }}</td>
                        <td>{{ $salon['precio_noche'] }}</td>
                        <td>{{ $salon['precio_hora_extra_noche'] }}</td>
                        <td>
                            @if(tienePermiso('Gestión de salones', 'actualizar'))
                                <button class="btn btn-warning btn-sm editarBtn">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            @endif

                            @if(tienePermiso('Gestión de salones', 'eliminar'))
                                <button class="btn btn-danger btn-sm eliminarBtn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Modal Nuevo Salón -->
    <div class="modal fade" id="modalNuevo" tabindex="-1">
        <div class="modal-dialog">
            <form id="formNuevo" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Salón</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="mb-2">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="mb-2">
                        <label>Descripción</label>
                        <textarea class="form-control" name="descripcion"></textarea>
                    </div>
                    <div class="mb-2">
                        <label>Capacidad</label>
                        <input type="number" class="form-control" name="capacidad" required>
                    </div>
                    <div class="mb-2">
                        <label>Estado</label>
                        <select class="form-control" name="estado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Precio Día</label>
                        <input type="number" step="0.01" class="form-control" name="precio_dia" required>
                    </div>
                    <div class="mb-2">
                        <label>Hora Extra Día</label>
                        <input type="number" step="0.01" class="form-control" name="precio_hora_extra_dia" required>
                    </div>
                    <div class="mb-2">
                        <label>Precio Noche</label>
                        <input type="number" step="0.01" class="form-control" name="precio_noche" required>
                    </div>
                    <div class="mb-2">
                        <label>Hora Extra Noche</label>
                        <input type="number" step="0.01" class="form-control" name="precio_hora_extra_noche" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Salón -->
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog">
            <form id="formEditar" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Salón</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="editarId">
                    <div class="mb-2">
                        <label>Nombre</label>
                        <input type="text" class="form-control" id="editarNombre" required>
                    </div>
                    <div class="mb-2">
                        <label>Descripción</label>
                        <textarea class="form-control" id="editarDescripcion"></textarea>
                    </div>
                    <div class="mb-2">
                        <label>Capacidad</label>
                        <input type="number" class="form-control" id="editarCapacidad" required>
                    </div>
                    <div class="mb-2">
                        <label>Estado</label>
                        <select class="form-control" name="estado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Precio Día</label>
                        <input type="number" step="0.01" class="form-control" id="editarPrecioDia" required>
                    </div>
                    <div class="mb-2">
                        <label>Hora Extra Día</label>
                        <input type="number" step="0.01" class="form-control" id="editarPrecioHoraExtraDia" required>
                    </div>
                    <div class="mb-2">
                        <label>Precio Noche</label>
                        <input type="number" step="0.01" class="form-control" id="editarPrecioNoche" required>
                    </div>
                    <div class="mb-2">
                        <label>Hora Extra Noche</label>
                        <input type="number" step="0.01" class="form-control" id="editarPrecioHoraExtraNoche" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/salones.js') }}"></script>
</body>

</html>