<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Permisos - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/cai.css') }}" rel="stylesheet">
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
                    <a href="{{ url('/dashboard') }}"
                        class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
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
                                            <a href="{{ $subitem['ruta'] }}"
                                                class="menu-item {{ request()->is(trim($subitem['ruta'], '/')) ? 'active' : '' }}">
                                                <i class="{{ $subitem['icono'] }} me-2"></i>
                                                <span>{{ $subnombre }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a href="{{ $item['ruta'] }}"
                                class="menu-item {{ request()->is(trim($item['ruta'], '/')) ? 'active' : '' }}">
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
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0"><i class="bi bi-shield-lock me-2"></i> Gestión de Permisos</h2>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Dashboard
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4 flex-wrap gap-3">
                        <div class="input-group search-container" style="max-width: 400px;">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="buscarPermiso" class="form-control" placeholder="Buscar permiso...">
                            <button class="btn btn-outline-secondary" type="button" id="btn-limpiar">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        @if(tienePermiso('Panel de administración', 'insertar'))
                            <button class="btn btn-primary" id="nuevoPermisoBtn">
                                <i class="bi bi-plus-circle me-1"></i> Nuevo Permiso
                            </button>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tablaPermisos">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Rol</th>
                                    <th>Objeto</th>
                                    <th>Nombre</th>
                                    <th class="text-center">Crear</th>
                                    <th class="text-center">Modificar</th>
                                    <th class="text-center">Mostrar</th>
                                    <th class="text-center">Eliminar</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permisos as $permiso)
                                    <tr>
                                        <td class="text-center">{{ $permiso['cod_permiso'] }}</td>
                                        <td>{{ $permiso['nombre_rol'] }}</td>
                                        <td>{{ $permiso['nombre_objeto'] }}</td>
                                        <td>{{ $permiso['nombre'] }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $permiso['crear'] === 'Sí' ? 'success' : 'secondary' }}">
                                                {{ $permiso['crear'] === 'Sí' ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $permiso['modificar'] === 'Sí' ? 'success' : 'secondary' }}">
                                                {{ $permiso['modificar'] === 'Sí' ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $permiso['mostrar'] === 'Sí' ? 'success' : 'secondary' }}">
                                                {{ $permiso['mostrar'] === 'Sí' ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $permiso['eliminar'] === 'Sí' ? 'success' : 'secondary' }}">
                                                {{ $permiso['eliminar'] === 'Sí' ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if(tienePermiso('Panel de administración', 'actualizar'))
                                                    <button class="btn btn-sm btn-outline-warning editarBtn"
                                                        data-id="{{ $permiso['cod_permiso'] }}" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                @endif
                                                @if(tienePermiso('Panel de administración', 'eliminar'))
                                                    <button class="btn btn-sm btn-outline-danger eliminarBtn"
                                                        data-id="{{ $permiso['cod_permiso'] }}" title="Eliminar">
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

    <!-- Modal Nuevo Permiso -->
    <div class="modal fade" id="modalNuevoPermiso" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form id="formNuevoPermiso">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i> Nuevo Permiso</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select id="cod_rol" name="cod_rol" class="form-select" required>
                                <option value="">Seleccione un rol</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol['cod_rol'] }}">{{ $rol['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Objeto</label>
                            <select id="cod_objeto" name="cod_objeto" class="form-select" required>
                                <option value="">Seleccione un objeto</option>
                                @foreach($objetos as $obj)
                                    <option value="{{ $obj['cod_objeto'] }}">{{ $obj['tipo_objeto'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre del permiso</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required maxlength="75">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Crear</label>
                                <select id="crear" name="crear" class="form-select" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Modificar</label>
                                <select id="modificar" name="modificar" class="form-select" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Mostrar</label>
                                <select id="mostrar" name="mostrar" class="form-select" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Eliminar</label>
                                <select id="eliminar" name="eliminar" class="form-select" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
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

    <!-- Modal Editar Permiso -->
    <div class="modal fade" id="modalEditarPermiso" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form id="formEditarPermiso">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i> Editar Permiso</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_permiso">

                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select id="edit_cod_rol" name="cod_rol" class="form-select" required>
                                <option value="">Seleccione un rol</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol['cod_rol'] }}">{{ $rol['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Objeto</label>
                            <select id="edit_cod_objeto" name="cod_objeto" class="form-select" required>
                                <option value="">Seleccione un objeto</option>
                                @foreach($objetos as $objeto)
                                    <option value="{{ $objeto['cod_objeto'] }}">{{ $objeto['tipo_objeto'] }}</option>
                                @endforeach
                            </select>
                        </div>

                       <div class="mb-3">
                            <label class="form-label">Nombre del permiso</label>
                            <input type="text" id="edit_nombre" name="nombre" class="form-control" required
                                maxlength="75" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                                title="Solo se permiten letras y espacios.">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Crear</label>
                                <select id="edit_crear" class="form-select" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Modificar</label>
                                <select id="edit_modificar" class="form-select" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Mostrar</label>
                                <select id="edit_mostrar" class="form-select" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Eliminar</label>
                                <select id="edit_eliminar" class="form-select" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
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

    <script>
        window.rolesData = @json($roles);
        window.objetosData = @json($objetos);
    </script>

    <script src="{{ asset('js/permisos.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script>
        document.getElementById('nombre').addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
        });
    </script>
    <script>
        document.getElementById('edit_nombre').addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
        });
    </script>
</body>

</html>