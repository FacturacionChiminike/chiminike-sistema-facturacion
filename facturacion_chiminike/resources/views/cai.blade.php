<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de CAI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/cai.css') }}" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Sidebar Navigation  -->
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
        @php
            use Carbon\Carbon;
        @endphp

        <div class="container-fluid py-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0"><i class="bi bi-key me-2"></i> Gestión de CAI</h2>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Regresar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="input-group w-50">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" id="buscarCai" class="form-control" placeholder="Buscar CAI...">
                        </div>
                        @if(tienePermiso('Gestión de CAI', 'insertar'))
                            <button class="btn btn-success" id="nuevoCaiBtn">
                                <i class="bi bi-plus-circle me-1"></i> Nuevo CAI
                            </button>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>CAI</th>
                                    <th class="text-center">Rango Desde</th>
                                    <th class="text-center">Rango Hasta</th>
                                    <th class="text-center">Fecha Límite</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaCai">
                                @foreach ($cai as $item)
                                    <tr>
                                        <td class="text-center">{{ $item['cod_cai'] }}</td>
                                        <td><code>{{ $item['cai'] }}</code></td>
                                        <td class="text-center">{{ $item['rango_desde'] }}</td>
                                        <td class="text-center">{{ $item['rango_hasta'] }}</td>
                                        <td class="text-center">{{ Carbon::parse($item['fecha_limite'])->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-{{ $item['estado'] == 'Activo' ? 'success' : 'secondary' }}">
                                                {{ $item['estado'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if(tienePermiso('Gestión de CAI', 'actualizar'))
                                                    <button class="btn btn-warning btn-sm editarBtn"
                                                        data-id="{{ $item['cod_cai'] }}" data-cai="{{ $item['cai'] }}"
                                                        data-desde="{{ $item['rango_desde'] }}" data-hasta="{{ $item['rango_hasta'] }}"
                                                        data-fecha="{{ Carbon::parse($item['fecha_limite'])->format('Y-m-d') }}"
                                                        data-estado="{{ $item['estado'] == 'Activo' ? 1 : 0 }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                @endif

                                                @if(tienePermiso('Gestión de CAI', 'eliminar'))
                                                    <button class="btn btn-danger btn-sm eliminarBtn" data-id="{{ $item['cod_cai'] }}"
                                                        data-cai="{{ $item['cai'] }}">
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

    <!-- Modal -->
    <div class="modal fade" id="caiModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formCai">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="caiModalLabel"><i class="bi bi-key me-2"></i> Nuevo CAI</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="cod_cai">

                        <div class="mb-3">
                            <label class="form-label">CAI</label>
                            <input type="text" id="cai" class="form-control" required
                                placeholder="Ingrese el código CAI">
                            <div class="invalid-feedback">Por favor ingrese el CAI</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rango Desde</label>
                                <input type="text" id="rango_desde" class="form-control" required
                                    placeholder="Primer número">
                                <div class="invalid-feedback">Ingrese el rango inicial</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rango Hasta</label>
                                <input type="text" id="rango_hasta" class="form-control" required
                                    placeholder="Último número">
                                <div class="invalid-feedback">Ingrese el rango final</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha Límite</label>
                            <input type="date" id="fecha_limite" class="form-control" required>
                            <div class="invalid-feedback">Seleccione una fecha válida</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select id="estado" class="form-select" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-save me-1"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/cai.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>