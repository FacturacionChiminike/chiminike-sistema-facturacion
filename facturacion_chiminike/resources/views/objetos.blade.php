<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Objetos - Sistema de Gestión</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <h2 class="mb-0"><i class="bi bi-box-seam me-2"></i> Gestión de Objetos</h2>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Dashboard
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="input-group search-container" style="max-width: 400px;">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control" placeholder="Buscar objetos...">
                        </div>
                        @if(tienePermiso('Panel de administración', 'insertar'))
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevo">
                                <i class="bi bi-plus-circle me-1"></i> Nuevo Objeto
                            </button>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Tipo Objeto</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($objetos as $obj)
                                    <tr data-id="{{ $obj['cod_objeto'] }}">
                                        <td class="text-center">{{ $obj['cod_objeto'] }}</td>
                                        <td>{{ $obj['tipo_objeto'] }}</td>
                                        <td>{{ $obj['descripcion'] }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if(tienePermiso('Panel de administración', 'actualizar'))
                                                    <button class="btn btn-sm btn-outline-warning btnEditar" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                @endif
                                                @if(tienePermiso('Panel de administración', 'eliminar'))
                                                    <button class="btn btn-sm btn-outline-danger btnEliminar" title="Eliminar">
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

    <!-- Modal Nuevo Objeto -->
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i> Nuevo Objeto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nuevo_tipo_objeto" class="form-label">Tipo Objeto</label>
                        <input type="text" id="nuevo_tipo_objeto" class="form-control" maxlength="30"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]+" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_descripcion" class="form-label">Descripción</label>
                        <select id="nuevo_descripcion" class="form-select" required>
                            <option value="">-- Selecciona una descripción --</option>
                            <option value="Gestión de empleados">Gestión de empleados</option>
                            <option value="Gestión de productos">Gestión de productos</option>
                            <option value="Gestión de salones">Gestión de salones</option>
                            <option value="Gestión de cotizaciones">Gestión de cotizaciones</option>
                            <option value="Gestión de reservaciones">Gestión de reservaciones</option>
                            <option value="Panel de administración">Panel de administración</option>
                            <option value="Gestión de CAI">Gestión de CAI</option>
                            <option value="Bitácora del sistema">Bitácora del sistema</option>
                            <option value="Gestión de clientes">Gestión de clientes</option>
                            <option value="Gestión de Backup">Gestión de Backup</option>
                              <option value="Gestión Facturacion Recorridos Escolares">Gestión Facturacion Recorridos Escolares</option>
                            <option value="Gestión Facturacion Taquilla">Gestión Facturacion Taquilla</option>
                            <option value="Gestión Facturacion Eventos">Gestión Facturacion Eventos</option>
                            <option value="Gestión Facturacion Roccketlab">Gestión Facturacion Roccketlab</option>
                            <option value="Gestión Facturacion Obras">Gestión Facturacion Obras</option>
                            <option value="Gestión Descuentos">Gestión Descuentos</option>
                              <option value="Reportes">Reportes</option>
                        </select>
                        </select>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                    <button id="btnGuardarNuevo" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Objeto -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i> Editar Objeto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editar_cod_objeto">
                    <div class="mb-3">
                        <label for="editar_tipo_objeto" class="form-label">Tipo Objeto</label>
                        <input type="text" id="editar_tipo_objeto" class="form-control" maxlength="30"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]+" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_descripcion" class="form-label">Descripción</label>
                        <select id="editar_descripcion" class="form-select" required>
                            <option value="">-- Selecciona una descripción --</option>
                            <option value="Gestión de empleados">Gestión de empleados</option>
                            <option value="Gestión de productos">Gestión de productos</option>
                            <option value="Gestión de salones">Gestión de salones</option>
                            <option value="Gestión de cotizaciones">Gestión de cotizaciones</option>
                            <option value="Gestión de reservaciones">Gestión de reservaciones</option>
                            <option value="Panel de administración">Panel de administración</option>
                            <option value="Gestión de CAI">Gestión de CAI</option>
                            <option value="Bitácora del sistema">Bitácora del sistema</option>
                            <option value="Gestión de clientes">Gestión de clientes</option>
                            <option value="Gestión de Backup">Gestión de Backup</option>
                            <option value="Gestión Facturacion Recorridos Escolares">Gestión Facturacion Recorridos Escolares</option>
                            <option value="Gestión Facturacion Taquilla">Gestión Facturacion Taquilla</option>
                            <option value="Gestión Facturacion Eventos">Gestión Facturacion Eventos</option>
                            <option value="Gestión Facturacion Roccketlab">Gestión Facturacion Roccketlab</option>
                            <option value="Gestión Facturacion Obras">Gestión Facturacion Obras</option>
                            <option value="Gestión Descuentos">Gestión Descuentos</option>
                              <option value="Reportes">Reportes</option>
                        </select>
                        </select>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                    <button id="btnGuardarEdicion" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/objetos.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('nuevo_tipo_objeto');
            if (!el) return;
            el.addEventListener('input', function () {
                this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '').slice(0, this.maxLength);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('editar_tipo_objeto');
            if (!el) return;
            el.addEventListener('input', function () {
                this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '').slice(0, this.maxLength);
            });
        });
    </script>


</body>

</html>