<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bitácora del Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="{{ asset('css/cai.css') }}" rel="stylesheet">
    <style>
        :root {
            --login-color: #4e73df;
            --create-color: #1cc88a;
            --update-color: #f6c23e;
            --delete-color: #e74a3b;
            --other-color: #858796;
        }

        .log-card {
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            border-left: 4px solid;
        }

        .log-card.login {
            border-left-color: var(--login-color);
        }

        .log-card.create {
            border-left-color: var(--create-color);
        }

        .log-card.update {
            border-left-color: var(--update-color);
        }

        .log-card.delete {
            border-left-color: var(--delete-color);
        }

        .log-card.other {
            border-left-color: var(--other-color);
        }

        .log-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .log-body {
            padding: 1.25rem;
        }

        .log-icon {
            font-size: 1.25rem;
            margin-right: 0.5rem;
        }

        .log-timestamp {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .log-user {
            font-weight: 600;
        }

        .log-object {
            background-color: #f8f9fa;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.85rem;
            display: inline-block;
        }

        .diff-container {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.85rem;
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            padding: 0.75rem;
            margin-top: 0.75rem;
        }

        .badge-action {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            font-weight: 600;
        }

        .badge-login {
            background-color: var(--login-color);
        }

        .badge-create {
            background-color: var(--create-color);
        }

        .badge-update {
            background-color: var(--update-color);
        }

        .badge-delete {
            background-color: var(--delete-color);
        }

        .badge-other {
            background-color: var(--other-color);
        }

        .filter-card {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }

        .view-toggle {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
        }

        .view-toggle .btn {
            padding: 0.375rem 0.75rem;
        }

        .json-viewer {
            max-height: 200px;
            overflow-y: auto;
            background-color: #f8f9fa;
            padding: 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .log-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .log-header div:last-child {
                margin-top: 0.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
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

        <div class="container mt-4">

            <!-- Botón de regreso y exportación -->
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Regresar al Dashboard
                </a>

                <div>
                    <a href="{{ route('bitacora.exportar', request()->all()) }}" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
                    </a>
                </div>
            </div>

            <h1 class="mb-4">Bitácora del Sistema</h1>

            <!-- Formulario de filtros -->
            <div class="filter-card">
                <form method="GET" action="{{ route('bitacora') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="cod_usuario" class="form-label">Usuario</label>
                            <input type="text" name="cod_usuario" id="cod_usuario" value="{{ request('cod_usuario') }}"
                                class="form-control" placeholder="Todos">
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                value="{{ request('fecha_inicio') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}"
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="objeto" class="form-label">Objeto</label>
                            <select name="objeto" id="objeto" class="form-select">
                                <option value="">Todos</option>
                                <option value="Login" {{ request('objeto') == 'Login' ? 'selected' : '' }}>Login</option>
                                <option value="Cotización" {{ request('objeto') == 'Cotización' ? 'selected' : '' }}>
                                    Cotización</option>
                                <!-- Agrega más opciones según tus objetos -->
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-funnel-fill"></i> Filtrar
                        </button>
                        <a href="{{ route('bitacora') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Mensaje de error -->
            @if(isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif

            <!-- Selector de vista -->
            <div class="view-toggle">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" id="cardViewBtn">
                        <i class="bi bi-card-text"></i> Vista de tarjetas
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="tableViewBtn">
                        <i class="bi bi-table"></i> Vista de tabla
                    </button>
                </div>
            </div>

            <!-- Vista de tarjetas -->
            <div id="cardView">
                @if(is_array($bitacora) && count($bitacora) > 0)
                    @foreach($bitacora as $log)
                        @php
                            $actionClass = strtolower($log['accion'] ?? '');
                            $actionIcon = '';
                            $badgeClass = 'badge-other';

                            if (str_contains($actionClass, 'login') || str_contains($actionClass, 'acceso')) {
                                $actionClass = 'login';
                                $actionIcon = '<i class="fas fa-sign-in-alt log-icon"></i>';
                                $badgeClass = 'badge-login';
                            } elseif (str_contains($actionClass, 'crear') || str_contains($actionClass, 'insertar')) {
                                $actionClass = 'create';
                                $actionIcon = '<i class="fas fa-plus-circle log-icon"></i>';
                                $badgeClass = 'badge-create';
                            } elseif (str_contains($actionClass, 'actualizar') || str_contains($actionClass, 'modificar')) {
                                $actionClass = 'update';
                                $actionIcon = '<i class="fas fa-pencil-alt log-icon"></i>';
                                $badgeClass = 'badge-update';
                            } elseif (str_contains($actionClass, 'eliminar') || str_contains($actionClass, 'borrar')) {
                                $actionClass = 'delete';
                                $actionIcon = '<i class="fas fa-trash-alt log-icon"></i>';
                                $badgeClass = 'badge-delete';
                            } else {
                                $actionClass = 'other';
                                $actionIcon = '<i class="fas fa-info-circle log-icon"></i>';
                            }
                        @endphp

                        <div class="card log-card {{ $actionClass }}">
                            <div class="log-header">
                                <div>
                                    {!! $actionIcon !!}
                                    <span class="log-user">{{ $log['nombre_usuario'] ?? 'Desconocido' }}</span>
                                    <span
                                        class="badge badge-action {{ $badgeClass }}">{{ ucfirst($log['accion'] ?? 'Acción') }}</span>
                                    <span class="log-object">{{ $log['objeto'] ?? 'Objeto' }}</span>
                                </div>
                                <div class="log-timestamp">
                                    {{ isset($log['fecha']) ? \Carbon\Carbon::parse($log['fecha'])->format('d/m/Y h:i A') : 'Fecha desconocida' }}
                                </div>
                            </div>

                            <div class="log-body">
                                @if(!empty($log['resumen_legible']))
                                    <div class="json-viewer">{!! $log['resumen_legible'] !!}</div>
                                @else
                                    <div class="text-muted">
                                        <i class="bi bi-info-circle"></i> No hay datos registrados para este evento
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-journal-x"></i>
                        <h3>No hay registros para mostrar</h3>
                        <p class="text-muted">Intenta ajustar los filtros o realizar alguna acción en el sistema</p>
                    </div>
                @endif
            </div>

            <!-- Vista de tabla (oculta inicialmente) -->
            <div id="tableView" class="d-none">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Objeto</th>
                                <th>Acción</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(is_array($bitacora) && count($bitacora) > 0)
                                @foreach($bitacora as $index => $log)
                                    <tr>
                                        <td>{{ isset($log['fecha']) ? \Carbon\Carbon::parse($log['fecha'])->format('d/m/Y h:i A') : 'Fecha desconocida' }}
                                        </td>
                                        <td>{{ $log['nombre_usuario'] ?? 'Desconocido' }}</td>
                                        <td>{{ $log['objeto'] ?? 'Objeto' }}</td>
                                        <td>
                                            @php
                                                $badgeClass = 'badge-other';
                                                $action = strtolower($log['accion'] ?? '');
                                                if (str_contains($action, 'login') || str_contains($action, 'acceso')) {
                                                    $badgeClass = 'badge-login';
                                                } elseif (str_contains($action, 'crear') || str_contains($action, 'insertar')) {
                                                    $badgeClass = 'badge-create';
                                                } elseif (str_contains($action, 'actualizar') || str_contains($action, 'modificar')) {
                                                    $badgeClass = 'badge-update';
                                                } elseif (str_contains($action, 'eliminar') || str_contains($action, 'borrar')) {
                                                    $badgeClass = 'badge-delete';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $log['accion'] ?? 'Acción' }}</span>
                                        </td>
                                        <td>
                                            @if(isset($log['datos_antes']) || isset($log['datos_despues']))
                                                <button class="btn btn-sm btn-outline-primary" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#logDetails{{ $index }}">
                                                    <i class="bi bi-eye"></i> Ver detalles
                                                </button>
                                                <div class="collapse mt-2" id="logDetails{{ $index }}">
                                                    @if(isset($log['datos_antes']))
                                                        <h6>Datos anteriores:</h6>
                                                        <div class="json-viewer">
                                                            <pre>{{ json_encode($log['datos_antes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                        </div>
                                                    @endif
                                                    @if(isset($log['datos_despues']))
                                                        <h6>Datos nuevos:</h6>
                                                        <div class="json-viewer">
                                                            <pre>{{ json_encode($log['datos_despues'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <em class="text-muted">Sin datos</em>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No hay registros para mostrar</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            @if(is_array($bitacora) && count($bitacora) > 0 && isset($page) && $page > 0)
                <nav>
                    <ul class="pagination justify-content-center mt-4">
                        @for ($i = 1; $i <= 10; $i++)
                            <li class="page-item {{ $page == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ route('bitacora', array_merge(request()->all(), ['page' => $i])) }}">{{ $i }}</a>
                            </li>
                        @endfor
                    </ul>
                </nav>
            @endif

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para alternar vistas -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cardViewBtn = document.getElementById('cardViewBtn');
            const tableViewBtn = document.getElementById('tableViewBtn');
            const cardView = document.getElementById('cardView');
            const tableView = document.getElementById('tableView');

            cardViewBtn.addEventListener('click', function () {
                cardView.classList.remove('d-none');
                tableView.classList.add('d-none');
                cardViewBtn.classList.add('active');
                tableViewBtn.classList.remove('active');
            });

            tableViewBtn.addEventListener('click', function () {
                cardView.classList.add('d-none');
                tableView.classList.remove('d-none');
                cardViewBtn.classList.remove('active');
                tableViewBtn.classList.add('active');
            });
        });
    </script>

</body>

</html>