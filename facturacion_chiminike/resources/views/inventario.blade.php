<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario - Sistema de Gestión</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/cai.css') }}" rel="stylesheet">
    <link href="{{ asset('css/inventario.css') }}" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="logo">Sistema <span>Gestión</span></h3>
            <div class="user-info">
                <div class="user-avatar">
                    <i class="bi bi-person-circle"></i>
                </div>
                @php $usuario = session('usuario'); @endphp
                <div class="user-details">
                    <span class="user-name">{{ $usuario['nombre_usuario'] ?? 'Usuario' }}</span>
                    <span class="user-role">{{ $usuario['rol'] ?? 'Rol' }}</span>
                </div>
            </div>
        </div>

        <nav class="sidebar-menu">
            <ul class="list-unstyled">
                @php $menu = menuItems(); @endphp

                <li class="mb-2">
                    <a href="{{ url('/dashboard') }}" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-door-fill me-2"></i> 
                        <span>Inicio</span>
                    </a>
                </li>

                @foreach($menu as $grupo => $item)
                    <li class="mb-2">
                        @if(isset($item['submenus']))
                            <a class="menu-item d-flex justify-content-between align-items-center collapsed"
                                data-bs-toggle="collapse" href="#submenu-{{ Str::slug($grupo) }}" role="button"
                                aria-expanded="false">
                                <div>
                                    <i class="{{ $item['icono'] }} me-2"></i> 
                                    <span>{{ $grupo }}</span>
                                </div>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse submenu" id="submenu-{{ Str::slug($grupo) }}">
                                <ul class="list-unstyled mt-2">
                                    @foreach($item['submenus'] as $subnombre => $subitem)
                                        <li>
                                            <a href="{{ $subitem['ruta'] }}" class="menu-item {{ request()->is(trim($subitem['ruta'], '/')) ? 'active' : '' }}">
                                                <i class="{{ $subitem['icono'] }} me-2"></i> 
                                                <span>{{ $subnombre }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a href="{{ $item['ruta'] }}" class="menu-item {{ request()->is(trim($item['ruta'], '/')) ? 'active' : '' }}">
                                <i class="{{ $item['icono'] }} me-2"></i> 
                                <span>{{ $grupo }}</span>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-box-seam me-2"></i> Gestión de Inventario</h2>
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm me-2">
                        <i class="bi bi-arrow-left me-1"></i> Dashboard
                    </a>
                    @if(tienePermiso('Gestión de productos', 'insertar'))
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevo">
                            <i class="bi bi-plus-lg me-1"></i> Nuevo
                        </button>
                    @endif
                </div>
            </div>

            <!-- Card de Inventario -->
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-list-check me-2"></i> Listado de Productos</h4>
                    <div class="w-25">
                        <input type="text" id="buscarInventario" class="form-control form-control-sm" placeholder="Buscar producto...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tablaInventario">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th class="text-end">Precio Unitario</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventario as $item)
                                    <tr data-id="{{ $item['cod_inventario'] }}">
                                        <td>{{ $item['nombre'] }}</td>
                                        <td>{{ $item['descripcion'] }}</td>
                                        <td class="text-end">L. {{ number_format($item['precio_unitario'], 2) }}</td>
                                        <td class="text-center">{{ $item['cantidad_disponible'] }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $item['estado'] ? 'success' : 'secondary' }}">
                                                {{ $item['estado'] ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if(tienePermiso('Gestión de productos', 'actualizar'))
                                                    <button class="btn btn-sm btn-outline-warning editarBtn" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                @endif
                                                @if(tienePermiso('Gestión de productos', 'eliminar'))
                                                    <button class="btn btn-sm btn-outline-danger eliminarBtn" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo Inventario -->
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i> Nuevo Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNuevo" class="modal-content">
                    <div class="modal-body">
                        @csrf
                         <div class="mb-3">
                            <label class="form-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="75" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="3" maxlength="75"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio Unitario:</label>
                            <input type="number" step="0.01" class="form-control" name="precio_unitario" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cantidad Disponible:</label>
                            <input type="number" class="form-control" name="cantidad_disponible" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado:</label>
                            <select class="form-control" name="estado" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Inventario -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i> Editar Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditar" class="modal-content">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="editarId">
                         <div class="mb-3">
                            <label class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="editarNombre" maxlength="75" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea class="form-control" id="editarDescripcion" rows="3" maxlength="75"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio Unitario:</label>
                            <input type="number" step="0.01" class="form-control" id="editarPrecioUnitario" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cantidad Disponible:</label>
                            <input type="number" class="form-control" id="editarCantidadDisponible" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado:</label>
                            <select class="form-control" id="editarEstado" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/inventario.js') }}"></script>
    <script>
        document.getElementById('nombre').addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
        });
    </script>
    <script>
        document.getElementById('descripcion').addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚÜÑñáéíóúü0-9 ]/g, '');
        });
    </script>
    <script>
        document.getElementById('editarNombre').addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚÜÑñáéíóúü0-9 ]/g, '');
        });
    </script>
    <script>
        document.getElementById('editarDescripcion').addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚÜÑñáéíóúü0-9 ]/g, '');
        });
    </script>
</body>
</html>