<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones - Sistema de Gestión</title>
    <meta name="description" content="Sistema de gestión de cotizaciones">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
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
                        <h2 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i> Gestión de Cotizaciones</h2>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Dashboard
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4 flex-wrap gap-3">
                        <div class="input-group search-container" style="max-width: 400px;">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control" placeholder="Buscar cotizaciones...">
                        </div>

                        <div class="d-flex gap-2">
                            @if(tienePermiso('Gestión de cotizaciones', 'insertar'))
                                <a href="{{ route('cotizacion.index') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i> Nueva
                                </a>
                            @endif

                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-download me-1"></i> Exportar
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="exportDropdown">
                                    <li><a class="dropdown-item" href="#" id="exportPdf"><i
                                                class="bi bi-file-earmark-pdf text-danger me-2"></i>PDF</a></li>
                                    <li><a class="dropdown-item" href="#" id="exportExcel"><i
                                                class="bi bi-file-earmark-excel text-success me-2"></i>Excel</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if(isset($error))
                        <div class="alert alert-danger text-center m-4">{{ $error }}</div>
                    @elseif(count($cotizaciones) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="tablaCotizaciones">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">Código</th>
                                        <th>Cliente</th>
                                        <th>Evento</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cotizaciones as $c)
                                        <tr>
                                            <td class="text-center"><span
                                                    class="badge bg-primary">#{{ $c['cod_cotizacion'] }}</span></td>
                                            <td>{{ $c['nombre_cliente'] }}</td>
                                            <td>{{ $c['nombre_evento'] }}</td>
                                            <td class="text-center">{{ date('d/m/Y', strtotime($c['fecha_programa'])) }}</td>
                                            <td class="text-center">{{ date('H:i', strtotime($c['hora_programada'])) }}</td>
                                            <td class="text-center">
                                                @if($c['estado'] === 'confirmada')
                                                    <span class="badge bg-success">Confirmada</span>
                                                @elseif($c['estado'] === 'pendiente')
                                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                                @else
                                                    <span class="badge bg-secondary">Cancelada</span>
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold">L. {{ number_format($c['monto_total'], 2) }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-primary btn-ver-detalle"
                                                        data-id="{{ $c['cod_cotizacion'] }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalDetalle">
                                                        Ver detalle
                                                    </button>


                                                    @if(tienePermiso('Gestión de cotizaciones', 'actualizar'))
                                                        <button class="btn btn-sm btn-outline-warning" title="Editar">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <small class="text-muted">Mostrando {{ count($cotizaciones) }} de {{ count($cotizaciones) }}
                                registros</small>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    @else
                        <div class="p-5 text-center text-muted">
                            <i class="bi bi-file-earmark-text display-5 mb-3"></i>
                            <h4>No hay cotizaciones registradas</h4>
                            <p class="mb-4">Comienza creando una nueva cotización</p>
                            <a href="{{ route('cotizacion.index') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i> Crear Cotización
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/cotizacion.js') }}"></script>

    <!-- Modal Detalle Cotización -->
    <div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de Cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="detalleCotizacionContenido">
                    <!-- Aquí se mostrará el contenido dinámico -->
                </div>
            </div>
        </div>
    </div>


</body>

</html>