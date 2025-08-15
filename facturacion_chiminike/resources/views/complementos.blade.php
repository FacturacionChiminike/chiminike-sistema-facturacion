<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recorridos Escolares - Sistema de Gestión</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/cai.css') }}" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .icon-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .icon-card {
            width: 30%;
            min-width: 250px;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .icon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            background-color: #e9ecef;
        }

        .icon-card i {
            font-size: 4rem;
            margin-bottom: 15px;
            color: #0d6efd;
        }

        .icon-card h3 {
            margin-top: 10px;
            color: #212529;
        }

        .modal-fullscreen {
            max-width: 90%;
            width: 90%;
            margin: 1.75rem auto;
        }

        .modal-content {
            height: 90vh;
        }

        .modal-body {
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .icon-card {
                width: 100%;
            }

            .modal-fullscreen {
                max-width: 95%;
                width: 95%;
            }
        }

        /* Estilos para modales más compactos */
        .modal-compact .modal-dialog {
            max-width: 500px;
        }

        .modal-compact .modal-content {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-compact .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 1.5rem;
        }

        .modal-compact .modal-body {
            padding: 1.5rem;
        }

        .modal-compact .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 1rem 1.5rem;
        }

        .modal-compact .form-control {
            border-radius: 5px;
            padding: 0.5rem 0.75rem;
        }

        .modal-compact textarea.form-control {
            min-height: 100px;
        }

        /* Animación suave para los modales */
        .modal.fade .modal-dialog {
            transform: translateY(-20px);
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: none;
        }

        /* Estilos para tablas en modales */
        .modal-body .table {
            font-size: 0.9rem;
        }

        .modal-body .table thead th {
            border-bottom-width: 1px;
            font-weight: 600;
        }

        .modal-body .table td,
        .modal-body .table th {
            padding: 0.75rem;
            vertical-align: middle;
        }

        .modal-body .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .modal-body .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        /* Efectos hover para botones */
        .btn-outline-warning:hover,
        .btn-outline-danger:hover {
            color: white !important;
        }

        .btn-sm i {
            font-size: 0.9rem;
        }

        /* Transiciones suaves */
        .btn,
        .form-control,
        .modal-content {
            transition: all 0.2s ease;
        }
    </style>
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
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-people-fill me-2"></i> Recorridos Escolares</h2>
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Dashboard
                </a>
            </div>

            <!-- Iconos grandes para cada sección -->
            <div class="icon-container">
                <!-- Icono Adicionales -->
                <div class="icon-card" onclick="mostrarSeccion('adicionales')">
                    <i class="bi bi-plus-circle"></i>
                    <h3>Adicionales</h3>
                    <p>Gestión de servicios adicionales</p>
                </div>

                <!-- Icono Paquetes -->
                <div class="icon-card" onclick="mostrarSeccion('paquetes')">
                    <i class="bi bi-box-seam"></i>
                    <h3>Paquetes</h3>
                    <p>Gestión de paquetes</p>
                </div>

                <!-- Icono Entradas -->
                <div class="icon-card" onclick="mostrarSeccion('entradas')">
                    <i class="bi bi-ticket-perforated"></i>
                    <h3>Entradas</h3>
                    <p>Gestión de entradas</p>
                </div>
            </div>

            <div class="icon-card" onclick="mostrarSeccion('libros')">
    <i class="bi bi-book"></i>
    <h3>Libros</h3>
    <p>Gestión de libros</p>
</div>

            <!-- Secciones ocultas (se mostrarán en modales) -->
            <div style="display:none;">
                <!-- ======================= ADICIONALES ======================= -->
                <div id="seccion-adicionales">
                    <div class="card shadow border-0 mb-4">
                        <div
                            class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i> Adicionales</h4>
                            @if(tienePermiso('Gestión de recorridos escolares', 'insertar'))
                                <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalAdicional">
                                    <i class="bi bi-plus-lg me-1"></i> Nuevo
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaAdicionales">
                                        @foreach ($adicionales as $a)
                                            <tr data-id="{{ $a['cod_adicional'] }}">
                                                <td>{{ $a['nombre'] }}</td>
                                                <td>{{ $a['descripcion'] }}</td>
                                                <td class="text-end">L. {{ number_format($a['precio'], 2) }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        @if(tienePermiso('Gestión de recorridos escolares', 'actualizar'))
                                                            <button class="btn btn-sm btn-outline-warning editarAdicionalBtn"
                                                                title="Editar">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                        @endif
                                                        @if(tienePermiso('Gestión de recorridos escolares', 'eliminar'))
                                                            <button class="btn btn-sm btn-outline-danger eliminarAdicionalBtn"
                                                                title="Eliminar">
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
                <div id="seccion-libros">
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-book me-2"></i> Libros</h4>
            @if(tienePermiso('Gestión de productos', 'insertar'))
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalLibro">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo
                </button>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th class="text-end">Precio</th>
                            <th class="text-end">Stock</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaLibros">
                        @foreach ($libros as $l)
                            <tr data-id="{{ $l['cod_libro'] }}">
                                <td>{{ $l['titulo'] }}</td>
                                <td>{{ $l['autor'] ?? 'N/A' }}</td>
                                <td class="text-end">L. {{ number_format($l['precio'], 2) }}</td>
                                <td class="text-end">{{ $l['stock'] }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        @if(tienePermiso('Gestión de productos', 'actualizar'))
                                            <button class="btn btn-sm btn-outline-warning editarLibroBtn" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        @endif
                                        @if(tienePermiso('Gestión de productos', 'eliminar'))
                                            <button class="btn btn-sm btn-outline-danger eliminarLibroBtn" title="Eliminar">
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


                <!-- ======================= PAQUETES ======================= -->
                <div id="seccion-paquetes">
                    <div class="card shadow border-0 mb-4">
                        <div
                            class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i> Paquetes</h4>
                            @if(tienePermiso('Gestión de recorridos escolares', 'insertar'))
                                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalPaquete">
                                    <i class="bi bi-plus-lg me-1"></i> Nuevo
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaPaquetes">
                                        @foreach ($paquetes as $p)
                                            <tr data-id="{{ $p['cod_paquete'] }}">
                                                <td>{{ $p['nombre'] }}</td>
                                                <td>{{ $p['descripcion'] }}</td>
                                                <td class="text-end">L. {{ number_format($p['precio'], 2) }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        @if(tienePermiso('Gestión de recorridos escolares', 'actualizar'))
                                                            <button class="btn btn-sm btn-outline-warning editarPaqueteBtn"
                                                                title="Editar">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                        @endif
                                                        @if(tienePermiso('Gestión de recorridos escolares', 'eliminar'))
                                                            <button class="btn btn-sm btn-outline-danger eliminarPaqueteBtn"
                                                                title="Eliminar">
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

                <!-- ======================= ENTRADAS ======================= -->
                <div id="seccion-entradas">
                    <div class="card shadow border-0">
                        <div
                            class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="bi bi-ticket-perforated me-2"></i> Entradas</h4>
                            @if(tienePermiso('Gestión de productos', 'insertar'))
                                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalEntrada">
                                    <i class="bi bi-plus-lg me-1"></i> Nueva
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaEntradas">
                                        @foreach ($entradas as $e)
                                            <tr data-id="{{ $e['cod_entrada'] }}">
                                                <td>{{ $e['nombre'] }}</td>
                                                <td class="text-end">L. {{ number_format($e['precio'], 2) }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        @if(tienePermiso('Gestión de productos', 'actualizar'))
                                                            <button class="btn btn-sm btn-outline-warning editarEntradaBtn"
                                                                title="Editar">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                        @endif
                                                        @if(tienePermiso('Gestión de productos', 'eliminar'))
                                                            <button class="btn btn-sm btn-outline-danger eliminarEntradaBtn"
                                                                title="Eliminar">
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
        </div>
    </div>

    <!-- ======================= MODAL ADICIONAL ======================= -->
    <div class="modal fade modal-compact" id="modalAdicional" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i> Adicional</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAdicional">
                        <input type="hidden" id="cod_adicional">
                        <div class="mb-3">
                            <label class="form-label">Nombre:</label>
                            <input type="text" id="nombre_adicional" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea id="descripcion_adicional" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio:</label>
                            <input type="number" step="0.01" min="0" id="precio_adicional" class="form-control"
                                required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                    <button type="button" id="guardarAdicional" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================= MODAL PAQUETE ======================= -->
    <div class="modal fade modal-compact" id="modalPaquete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i> Paquete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPaquete">
                        <input type="hidden" id="cod_paquete">
                        <div class="mb-3">
                            <label class="form-label">Nombre:</label>
                            <input type="text" id="nombre_paquete" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea id="descripcion_paquete" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio:</label>
                            <input type="number" step="0.01" min="0" id="precio_paquete" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                    <button type="button" id="guardarPaquete" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================= MODAL ENTRADA ======================= -->
    <div class="modal fade modal-compact" id="modalEntrada" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-ticket-perforated me-2"></i> Entrada</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEntrada">
                        <input type="hidden" id="cod_entrada">
                        <div class="mb-3">
                            <label class="form-label">Nombre:</label>
                            <input type="text" id="nombre_entrada" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio:</label>
                            <input type="number" step="0.01" min="0" id="precio_entrada" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                    <button type="button" id="guardarEntrada" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================= MODAL Libros ======================= -->
    <div class="modal fade modal-compact" id="modalLibro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-book me-2"></i> Libro</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formLibro">
                    <input type="hidden" id="cod_libro">
                    <div class="mb-3">
                        <label class="form-label">Título:</label>
                        <input type="text" id="titulo_libro" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Autor:</label>
                        <input type="text" id="autor_libro" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio:</label>
                        <input type="number" step="0.01" min="0" id="precio_libro" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock:</label>
                        <input type="number" min="0" id="stock_libro" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancelar
                </button>
                <button type="button" id="guardarLibro" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal para mostrar las secciones -->
    <div class="modal fade" id="modalSeccion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalSeccionTitulo"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalSeccionContenido">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/complementos.js') }}"></script>
    <script>
        function mostrarSeccion(seccion) {
            // Obtener el título según la sección
            let titulo = '';
            let contenido = document.getElementById('seccion-' + seccion).innerHTML;

            switch (seccion) {
                case 'adicionales':
                    titulo = '<i class="bi bi-plus-circle me-2"></i> Adicionales';
                    break;
                case 'paquetes':
                    titulo = '<i class="bi bi-box-seam me-2"></i> Paquetes';
                    break;
                case 'entradas':
                    titulo = '<i class="bi bi-ticket-perforated me-2"></i> Entradas';
                    break;
                    case 'libros':
    titulo = '<i class="bi bi-book me-2"></i> Libros';
    break;
            }

            // Establecer el título y contenido en el modal
            document.getElementById('modalSeccionTitulo').innerHTML = titulo;
            document.getElementById('modalSeccionContenido').innerHTML = contenido;

            // Mostrar el modal
            var modal = new bootstrap.Modal(document.getElementById('modalSeccion'));
            modal.show();

            // Reasignar los eventos después de cargar el contenido dinámico
            reasignarEventos();
        }

        function reasignarEventos() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Reasignar eventos para adicionales
            document.querySelectorAll('#modalSeccionContenido .editarAdicionalBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.closest('tr').dataset.id;
                    fetch(`/complementos/adicionales/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('cod_adicional').value = data.cod_adicional;
                            document.getElementById('nombre_adicional').value = data.nombre;
                            document.getElementById('descripcion_adicional').value = data.descripcion;
                            document.getElementById('precio_adicional').value = data.precio;
                            bootstrap.Modal.getInstance(document.getElementById('modalSeccion')).hide();
                            new bootstrap.Modal(document.getElementById('modalAdicional')).show();
                        });
                });
            });

            // Reasignar eventos para paquetes
            document.querySelectorAll('#modalSeccionContenido .editarPaqueteBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.closest('tr').dataset.id;
                    fetch(`/complementos/paquetes/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('cod_paquete').value = data.cod_paquete;
                            document.getElementById('nombre_paquete').value = data.nombre;
                            document.getElementById('descripcion_paquete').value = data.descripcion;
                            document.getElementById('precio_paquete').value = data.precio;
                            bootstrap.Modal.getInstance(document.getElementById('modalSeccion')).hide();
                            new bootstrap.Modal(document.getElementById('modalPaquete')).show();
                        });
                });
            });

            // Reasignar eventos para entradas
            document.querySelectorAll('#modalSeccionContenido .editarEntradaBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.closest('tr').dataset.id;
                    fetch(`/complementos/entradas/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('cod_entrada').value = data.cod_entrada;
                            document.getElementById('nombre_entrada').value = data.nombre;
                            document.getElementById('precio_entrada').value = data.precio;
                            bootstrap.Modal.getInstance(document.getElementById('modalSeccion')).hide();
                            new bootstrap.Modal(document.getElementById('modalEntrada')).show();
                        });
                });
            });
// Reasignar eventos para libros (en la función reasignarEventos)
document.querySelectorAll('#modalSeccionContenido .editarLibroBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.closest('tr').dataset.id;
        fetch(`/complementos/libros/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('cod_libro').value = data.cod_libro;
                document.getElementById('titulo_libro').value = data.titulo;
                document.getElementById('autor_libro').value = data.autor || '';
                document.getElementById('precio_libro').value = data.precio;
                document.getElementById('stock_libro').value = data.stock;
                bootstrap.Modal.getInstance(document.getElementById('modalSeccion')).hide();
                new bootstrap.Modal(document.getElementById('modalLibro')).show();
            });
    });
});
            // También puedes reasignar los eventos de eliminación aquí si es necesario
            document.querySelectorAll('#modalSeccionContenido .eliminarAdicionalBtn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.closest('tr').dataset.id;
                    Swal.fire({
                        title: '¿Eliminar?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar'
                    }).then(res => {
                        if (res.isConfirmed) {
                            fetch(`/complementos/adicionales/${id}`, {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': token }
                            }).then(() => {
                                Swal.fire('Eliminado', '', 'success').then(() => location.reload());
                            });
                        }
                    });
                });
            });

            document.querySelectorAll('#modalSeccionContenido .eliminarPaqueteBtn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.closest('tr').dataset.id;
                    Swal.fire({
                        title: '¿Eliminar?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar'
                    }).then(res => {
                        if (res.isConfirmed) {
                            fetch(`/complementos/paquetes/${id}`, {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': token }
                            }).then(() => {
                                Swal.fire('Eliminado', '', 'success').then(() => location.reload());
                            });
                        }
                    });
                });
            });

            document.querySelectorAll('#modalSeccionContenido .eliminarEntradaBtn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.closest('tr').dataset.id;
                    Swal.fire({
                        title: '¿Eliminar?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar'
                    }).then(res => {
                        if (res.isConfirmed) {
                            fetch(`/complementos/entradas/${id}`, {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': token }
                            }).then(() => {
                                Swal.fire('Eliminado', '', 'success').then(() => location.reload());
                            });
                        }
                    });
                });
            });

            document.querySelectorAll('#modalSeccionContenido .eliminarLibroBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.closest('tr').dataset.id;
        Swal.fire({
            title: '¿Eliminar?',
            text: '¿Estás seguro de eliminar este libro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(res => {
            if (res.isConfirmed) {
                fetch(`/complementos/libros/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': token }
                })
                .then(res => res.json())
                .then(() => {
                    Swal.fire('Eliminado', 'El libro ha sido eliminado', 'success').then(() => location.reload());
                });
            }
        });
    });
});

        }
    </script>
</body>

</html>