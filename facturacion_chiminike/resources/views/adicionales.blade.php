<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Adicionales</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/adicionales.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>

    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Adicionales</h2>
            <div>
                <a href="/dashboard" class="btn btn-secondary me-2">Regresar al Dashboard</a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevo">Nuevo Adicional</button>
            </div>
        </div>

        <div class="mb-3">
            <input type="text" id="buscarAdicional" class="form-control" placeholder="Buscar adicional...">
        </div>

        <table class="table table-striped table-bordered" id="tablaAdicionales">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($adicionales as $item)
                    <tr data-id="{{ $item['cod_adicional'] }}">
                        <td>{{ $item['nombre'] }}</td>
                        <td>{{ $item['descripcion'] }}</td>
                        <td>{{ $item['precio'] }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editarBtn"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-danger btn-sm eliminarBtn"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Modal Nuevo -->
    <div class="modal fade" id="modalNuevo" tabindex="-1">
        <div class="modal-dialog">
            <form id="formNuevo" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Adicional</h5>
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
                        <label>Precio</label>
                        <input type="number" step="0.01" class="form-control" name="precio" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog">
            <form id="formEditar" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Adicional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="editarId">
                    <div class="mb-2">
                        <label>Nombre</label>
                        <input type="text" class="form-control" id="editarNombre" required>
                    </div>
                    <div class="mb-2">
                        <label>Descripción</label>
                        <textarea class="form-control" id="editarDescripcion"></textarea>
                    </div>
                    <div class="mb-2">
                        <label>Precio</label>
                        <input type="number" step="0.01" class="form-control" id="editarPrecio" required>
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
    <script src="{{ asset('js/adicionales.js') }}"></script>
</body>

</html>
