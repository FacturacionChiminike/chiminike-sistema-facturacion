<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Inventario</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/inventario.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>

    <div class="dashboard-container">
        
        {{-- Menú lateral izquierdo --}}
        @include('layouts.sidebar')

    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Inventario</h2>
            <div>
                <a href="/dashboard" class="btn btn-secondary me-2">Regresar al Dashboard</a>
                @if(tienePermiso('Gestión de productos', 'insertar'))
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevo">
                        Nuevo Inventario
                    </button>
                @endif

            </div>
        </div>

        <div class="mb-3">
            <input type="text" id="buscarInventario" class="form-control" placeholder="Buscar producto...">
        </div>

        <table class="table table-striped table-bordered" id="tablaInventario">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventario as $item)
                    <tr data-id="{{ $item['cod_inventario'] }}">
                        <td>{{ $item['nombre'] }}</td>
                        <td>{{ $item['descripcion'] }}</td>
                        <td>{{ $item['precio_unitario'] }}</td>
                        <td>{{ $item['cantidad_disponible'] }}</td>
                        <td>{{ $item['estado'] }}</td>
                        <td>
                            @if(tienePermiso('Gestión de productos', 'actualizar'))
                                <button class="btn btn-warning btn-sm editarBtn">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            @endif

                            @if(tienePermiso('Gestión de productos', 'eliminar'))
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

    <!-- Modal Nuevo Inventario -->
    <div class="modal fade" id="modalNuevo" tabindex="-1">
        <div class="modal-dialog">
            <form id="formNuevo" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Inventario</h5>
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
                        <label>Precio Unitario</label>
                        <input type="number" step="0.01" class="form-control" name="precio_unitario" required>
                    </div>
                    <div class="mb-2">
                        <label>Cantidad Disponible</label>
                        <input type="number" class="form-control" name="cantidad_disponible" required>
                    </div>
                    <div class="mb-2">
                        <label>Estado</label>
                        <select class="form-control" name="estado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Inventario -->
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog">
            <form id="formEditar" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Inventario</h5>
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
                        <label>Precio Unitario</label>
                        <input type="number" step="0.01" class="form-control" id="editarPrecioUnitario" required>
                    </div>
                    <div class="mb-2">
                        <label>Cantidad Disponible</label>
                        <input type="number" class="form-control" id="editarCantidadDisponible" required>
                    </div>
                    <div class="mb-2">
                        <label>Estado</label>
                        <select class="form-control" id="editarEstado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
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
    <script src="{{ asset('js/inventario.js') }}"></script>
</body>

</html>