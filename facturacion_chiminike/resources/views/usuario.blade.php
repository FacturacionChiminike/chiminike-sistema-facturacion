<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/cai.css') }}">

    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- jQuery (si aún no lo usás) + Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0"><i class="bi bi-people-fill me-2"></i> Gestión de Usuarios</h2>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Regresar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="filtroEstado">Filtrar por estado:</label>
                            <select id="filtroEstado" class="form-control">
                                <option value="">Todos</option>
                                <option value="1">Activos</option>
                                <option value="0">Inactivos</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="filtroRol">Filtrar por rol:</label>
                            <select id="filtroRol" class="form-control">
                                <option value="">Todos</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol['nombre'] }}">{{ $rol['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablaUsuarios">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Tipo</th>
                                    <th>Empleado</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $index => $usuario)
                                    <tr data-estado="{{ $usuario['estado'] }}" data-rol="{{ $usuario['nombre_rol'] }}">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $usuario['nombre_usuario'] }}</td>

                                        <!-- Combo Rol -->
                                        <!-- Combo Rol -->
                                        <td>
                                            @if(tienePermiso('Panel de administración', 'actualizar'))
                                                <select class="form-select form-select-sm select-rol"
                                                    data-id="{{ $usuario['cod_usuario'] }}">
                                                    @foreach ($roles as $rol)
                                                        <option value="{{ $rol['cod_rol'] }}" {{ $usuario['cod_rol'] == $rol['cod_rol'] ? 'selected' : '' }}>
                                                            {{ $rol['nombre'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select class="form-select form-select-sm" disabled>
                                                    <option selected>{{ $usuario['nombre_rol'] ?? 'Sin rol' }}</option>
                                                </select>
                                            @endif
                                        </td>

                                        <!-- Combo Tipo Usuario -->
                                        <td>
                                            @if(tienePermiso('Panel de administración', 'actualizar'))
                                                <select class="form-select form-select-sm select-tipo"
                                                    data-id="{{ $usuario['cod_usuario'] }}">
                                                    @foreach ($tiposUsuario as $tipo)
                                                        <option value="{{ $tipo['cod_tipo_usuario'] }}" {{ $usuario['cod_tipo_usuario'] == $tipo['cod_tipo_usuario'] ? 'selected' : '' }}>
                                                            {{ $tipo['nombre'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select class="form-select form-select-sm" disabled>
                                                    <option selected>{{ $usuario['nombre_tipo_usuario'] ?? 'Sin tipo' }}
                                                    </option>
                                                </select>
                                            @endif
                                        </td>

                                        <!-- Empleado -->
                                        <td>{{ $usuario['nombre_empleado'] }}</td>

                                        <!-- Switch Estado -->
                                        <td class="text-center">
                                            @if(tienePermiso('Panel de administración', 'actualizar'))
                                                <div
                                                    class="form-check form-switch d-flex justify-content-center align-items-center">
                                                    <input class="form-check-input estado-switch" type="checkbox"
                                                        title="Cambiar estado del usuario"
                                                        data-id="{{ $usuario['cod_usuario'] }}" {{ $usuario['estado'] == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label ms-2">
                                                        {{ $usuario['estado'] == 1 ? 'Activo' : 'Inactivo' }}
                                                    </label>
                                                </div>
                                            @else
                                                <span
                                                    class="badge bg-secondary">{{ $usuario['estado'] == 1 ? 'Activo' : 'Inactivo' }}</span>
                                            @endif
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

    <!-- JS personalizado -->
    <script src="{{ asset('js/usuario.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>