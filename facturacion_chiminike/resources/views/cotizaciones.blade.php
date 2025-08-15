<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones - Sistema de Gestión</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/cai.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cotizacion.css') }}" rel="stylesheet">
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
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i> Cotizaciones </h2>
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm me-2">
                        <i class="bi bi-arrow-left me-1"></i> Dashboard
                    </a>
                    @if(tienePermiso('Gestión de cotizaciones', 'insertar'))
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#crearCotizacionModal">
                            <i class="bi bi-plus-lg me-1"></i> Nueva
                        </button>
                    @endif
                </div>
            </div>

            <!-- Alertas -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Card de Cotizaciones -->
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-list-check me-2"></i> Listado de Cotizaciones</h4>
                    <div class="w-25">
                        <input type="text" id="buscarInventario" class="form-control form-control-sm"
                            placeholder="Buscar cotización...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Evento</th>
                                    <th>Fecha Evento</th>
                                    <th>Hora</th>
                                    <th>Horas</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cotizaciones as $cot)
                                    <tr>
                                        <td>{{ $cot['cod_cotizacion'] }}</td>
                                        <td>{{ $cot['cliente'] }}</td>
                                        <td>{{ $cot['nombre_evento'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cot['fecha_programa'])->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cot['hora_programada'])->format('H:i') }}</td>
                                        <td>{{ $cot['horas_evento'] }}</td>
                                        <td>
                                            @if ($cot['estado'] === 'pendiente')
                                                <span class="badge bg-warning text-dark">Pendiente</span>
                                            @else
                                                <span class="badge bg-success">Confirmada</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-info"
                                                    onclick="mostrarDetalle({{ $cot['cod_cotizacion'] }})" title="Ver">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @if(tienePermiso('Gestión de cotizaciones', 'actualizar'))
                                                    <button class="btn btn-sm btn-outline-warning"
                                                        onclick="abrirModalEditar({{ $cot['cod_cotizacion'] }})" title="Editar">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                @endif
                                                @if(tienePermiso('Gestión de cotizaciones', 'eliminar'))
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="eliminarCotizacion({{ $cot['cod_cotizacion'] }})"
                                                        title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No hay cotizaciones pendientes.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de detalle de cotización pyo-->
    <div class="modal fade" id="detalleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-text me-2"></i> Detalle de la Cotización</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="detalleContenido" class="text-center">
                        <div class="contenedor-modal">
                            <!-- ENCABEZADO CON LOGOS -->
                            <div class="encabezado-modal d-flex justify-content-between align-items-center mb-3">
                                <img src="{{ asset('img/manologochiminike.jpeg') }}" alt="Logo Chiminike"
                                    class="logo-modal" style="width: 80px;">
                                <div class="titulo-modal text-center">
                                    <h4 class="mb-0">Museo Chiminike</h4>
                                    <p class="mb-0 fw-semibold">Cotización de Evento</p>
                                </div>
                                <img src="{{ asset('img/manologochiminike.jpeg') }}" alt="Logo Chiminike"
                                    class="logo-modal" style="width: 80px;">
                            </div>

                            <!-- DATOS DE LA COTIZACIÓN -->
                            <div class="datos-evento-modal mb-3">
                                <p><strong>Evento:</strong> <span id="cotizacion-nombre">---</span></p>
                                <p><strong>Cliente:</strong> <span id="cotizacion-cliente">---</span></p>
                                <p><strong>Fecha del evento:</strong> <span id="cotizacion-fecha-evento">---</span></p>
                                <p><strong>Hora de inicio:</strong> <span id="cotizacion-hora">---</span></p>
                                <p><strong>Horas de evento:</strong> <span id="cotizacion-horas">---</span></p>
                                <p><strong>Estado:</strong> <span id="cotizacion-estado">---</span></p>
                            </div>

                            <!-- TABLA DE PRODUCTOS -->
                            <table class="table table-bordered table-sm text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Precio Unitario</th>
                                        <th>Impuesto (15%)</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="productos-body">
                                    <tr>
                                        <td colspan="4">Sin productos</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th id="total-general">L 0.00</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- MENSAJE -->
                            <!-- <p class="mensaje-modal mt-2">y aquí un mensaje que bonito</p> -->

                            <!-- BOTONES -->
                            <div class="botones-modal d-flex justify-content-center gap-2 mt-3">
                                <a id="btn-generar-pdf" href="#" class="btn btn-danger btn-sm" target="_blank">
                                    <i class="bi bi-file-pdf"></i> Generar PDF
                                </a>
                                <button id="btn-enviar-correo" class="btn btn-success btn-sm">
                                    <i class="bi bi-send"></i> Enviar por correo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de edición de Cotización -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i> Editar Cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditarCotizacion">
                    <div class="modal-body">
                        <input type="hidden" id="edit-cod-cotizacion">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Evento</label>
                                <input type="text" id="edit-nombre-evento" class="form-control" maxlength="150" required
                                    placeholder="Ingrese el nombre del evento">
                                <div class="invalid-feedback" id="feedback-edit-evento">
                                    Solo se permiten letras y números. No repitas ningún carácter más de 4 veces
                                    seguidas.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Fecha del Evento</label>
                                <input type="date" id="edit-fecha-programa" class="form-control" required>
                                <div class="invalid-feedback" id="feedback-edit-fecha">
                                    No se puede seleccionar una fecha pasada.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Hora del Evento</label>
                                <input type="time" id="edit-hora-programada" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Horas de Duración</label>
                                <input type="number" id="edit-horas-evento" class="form-control" min="0" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Cliente</label>
                                <input type="text" id="edit-cliente" class="form-control" disabled>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Estado</label>
                                <select id="edit-estado" class="form-select" required>
                                    <option value="">Seleccione estado</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="confirmada">Confirmada</option>
                                    <option value="expirada">Cancelada</option>
                                    <option value="completada">Completada</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Productos de la Cotización</label>
                            <table class="table table-sm table-bordered text-center align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Precio Unitario</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="edit-productos-body">
                                    <tr>
                                        <td colspan="5">Sin productos</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success btn-sm" onclick="agregarProductoFila()">
                                <i class="bi bi-plus-circle"></i> Agregar Producto
                            </button>
                             <button type="button" class="btn btn-warning" onclick="agregarHoraExtraEditar()">
                                <i class="bi bi-plus-circle"></i> Agregar Hora Extra
                            </button>
                            <small class="text-muted d-block mt-1">
                                Puedes modificar, agregar o eliminar productos aquí antes de actualizar.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="bi bi-save me-1"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Nueva Cotización -->
    <div class="modal fade" id="crearCotizacionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i> Nueva Cotización</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCrearCotizacion">
                    <div class="modal-body">
                        <!-- Selección de Cliente -->
                        <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-person me-2"></i>Cliente</h6>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Seleccionar Cliente Existente</label>
                                <select id="cod_cliente" name="cod_cliente" class="form-select">
                                    <option value="">-- Selecciona un cliente existente --</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente['cod_cliente'] }}">{{ $cliente['nombre_persona'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end mb-3">
                                <button type="button" id="btnNuevoCliente" class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-person-plus me-1"></i> Nuevo Cliente
                                </button>
                            </div>
                        </div>

                        <!-- Datos del cliente nuevo -->
                        <div id="camposClienteNuevo" style="display: none;">
                            <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-person-plus me-2"></i>Datos del
                                Cliente Nuevo</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" id="nombre" class="form-control" maxlength="100"
                                        placeholder="Ingrese el nombre (solo letras)">
                                    <div class="invalid-feedback" id="feedback-nombre">
                                        Ingrese un nombre válido. No se permiten más de tres letras iguales seguidas, y
                                        debe tener al menos nombre y apellido.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" id="fecha_nacimiento" class="form-control">
                                    <div class="invalid-feedback" id="feedback-fecha">
                                        Debe ser mayor de edad (mínimo 18 años).
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sexo</label>
                                    <select id="sexo" class="form-select">
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">DNI</label>
                                    <input type="text" id="dni" class="form-control" maxlength="13"
                                        placeholder="Ingrese el DNI (solo números)">
                                    <div class="invalid-feedback" id="feedback-dni">
                                        El DNI debe comenzar con 0, tener máximo 13 dígitos y no repetir un número más
                                        de 3 veces seguidas.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Correo</label>
                                    <input type="email" id="correo" class="form-control" maxlength="100"
                                        placeholder="usuario@dominio.com">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" id="telefono" class="form-control" maxlength="8"
                                        placeholder="Ingrese el teléfono (8 dígitos)">
                                    <div class="invalid-feedback" id="feedback-telefono">
                                        El teléfono debe tener 8 dígitos y comenzar con 9, 8 o 3.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" id="direccion" class="form-control" maxlength="150"
                                        placeholder="Ingrese la dirección (letras y números)">
                                    <div class="invalid-feedback" id="feedback-direccion">
                                        Solo se permiten letras, números y espacios. No repita más de 3 veces el mismo
                                        carácter.
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Municipio</label>
                                    <select id="cod_municipio" name="cod_municipio" class="form-select">
                                        <option value="">Seleccione un municipio</option>
                                        @foreach ($municipios as $municipio)
                                            <option value="{{ $municipio['cod_municipio'] }}">{{ $municipio['municipio'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">RTN</label>
                                    <input type="text" id="rtn" class="form-control" maxlength="14"
                                        placeholder="Ingrese el RTN (14 dígitos)">
                                    <div class="invalid-feedback" id="feedback-rtn">
                                        El RTN debe comenzar con 0, tener máximo 14 dígitos y no repetir un mismo número
                                        más de 3 veces seguidas.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo Cliente</label>
                                    <select id="tipo_cliente" class="form-select">
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="Individual">Individual</option>
                                        <option value="Empresa">Empresa</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <!-- Datos del Evento -->
                        <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-calendar-event me-2"></i>Datos del
                            Evento</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Evento</label>
                                <input type="text" id="evento_nombre" class="form-control" maxlength="150" required
                                    placeholder="Ingrese el nombre del evento (letras y números)">
                                <div class="invalid-feedback" id="feedback-evento">
                                    Solo se permiten letras y números. No repitas ningún carácter más de 4 veces
                                    seguidas.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Fecha del Evento</label>
                                <input type="date" id="fecha_evento" class="form-control" required>
                                <div class="invalid-feedback" id="feedback-fecha-evento">
                                    La fecha del evento no puede ser anterior a hoy.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Hora del Evento</label>
                                <input type="time" id="hora_evento" class="form-control" required>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Horas de Duración</label>
                                <input type="number" id="horas_evento" class="form-control" value="5" readonly>
                            </div>
                        </div>

                        <hr>

                        <!-- Productos -->
                        <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-box-seam me-2"></i>Productos</h6>
                        <table class="table table-sm table-bordered text-center align-middle">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Descripción</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="productos-body-crear">
                                <tr>
                                    <td colspan="5">Sin productos</td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success btn-sm" onclick="agregarProductoFilaCrear()">
                            <i class="bi bi-plus-circle me-1"></i> Agregar Producto
                        </button>
                        <button type="button" class="btn btn-warning" onclick="agregarHoraExtra()">
                            <i class="bi bi-plus-circle"></i> Agregar Hora Extra
                        </button>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-save me-1"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/cotizacion.js') }}"></script>

    <script>
        const catalogos = @json($catalogos);
    </script>

    <script>
        document.getElementById("btn-enviar-correo").addEventListener("click", function () {
            if (!window.cod_cotizacion_actual) {
                Swal.fire("Error", "No se encontró la cotización para enviar.", "error");
                return;
            }

            Swal.fire({
                title: "Enviando correo...",
                text: "Espere mientras se envía la cotización al cliente.",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
            });
            console.log(`/cotizaciones/${window.cod_cotizacion_actual}/enviar-correo`);

            fetch(`/cotizaciones/${window.cod_cotizacion_actual}/enviar-correo`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json",
                },
            })
                .then(res => res.json())
                .then(data => {
                    Swal.close();
                    if (data.error) {
                        Swal.fire("Error", data.error, "error");
                    } else {
                        Swal.fire("Éxito", data.mensaje ?? "Correo enviado correctamente.", "success");
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.close();
                    Swal.fire("Error", "Ocurrió un error al enviar el correo.", "error");
                });
        });
    </script>

    <script>
        const inputNombre = document.getElementById("nombre");
        const feedback = document.getElementById("feedback-nombre");

        inputNombre.addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            const repetidas = /(.)\1{3,}/i.test(this.value);
            const palabras = this.value.trim().split(/\s+/);
            const tieneDosPalabras = palabras.length >= 2;
            if (repetidas || !tieneDosPalabras) {
                this.classList.add("is-invalid");
                feedback.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedback.style.display = 'none';
            }
        });
    </script>
    <script>
        const inputFecha = document.getElementById("fecha_nacimiento");
        const feedbackFecha = document.getElementById("feedback-fecha");

        inputFecha.addEventListener("change", function () {
            const fechaNacimiento = new Date(this.value);
            const hoy = new Date();
            const edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            const mes = hoy.getMonth() - fechaNacimiento.getMonth();
            const dia = hoy.getDate() - fechaNacimiento.getDate();

            const mayorDeEdad =
                edad > 18 || (edad === 18 && (mes > 0 || (mes === 0 && dia >= 0)));

            if (!mayorDeEdad) {
                this.classList.add("is-invalid");
                feedbackFecha.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedbackFecha.style.display = 'none';
            }
        });
    </script>
    <script>
        const inputDNI = document.getElementById("dni");
        const feedbackDNI = document.getElementById("feedback-dni");

        inputDNI.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '');

            const valor = this.value;

            const empiezaConCero = valor.startsWith("0");
            const noRepiteMasDeTres = !/(.)\1{3,}/.test(valor);

            if (!empiezaConCero || !noRepiteMasDeTres) {
                this.classList.add("is-invalid");
                feedbackDNI.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedbackDNI.style.display = 'none';
            }
        });
    </script>
    <script>
        document.getElementById("correo").addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-Z0-9@._-]/g, '');
        });
    </script>
    <script>
        const inputTelefono = document.getElementById("telefono");
        const feedbackTelefono = document.getElementById("feedback-telefono");

        inputTelefono.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '');

            const valor = this.value;
            const longitudCorrecta = valor.length <= 8;
            const comienzaBien = /^[983]/.test(valor);

            if (!comienzaBien || !longitudCorrecta) {
                this.classList.add("is-invalid");
                feedbackTelefono.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedbackTelefono.style.display = 'none';
            }
        });
    </script>
    <script>
        const inputDireccion = document.getElementById("direccion");
        const feedbackDireccion = document.getElementById("feedback-direccion");

        inputDireccion.addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]/g, '');
            this.value = this.value.replace(/(.)\1{3,}/g, '$1$1$1');
            const tieneRepetidas = /(.)\1{3,}/.test(this.value);

            if (tieneRepetidas) {
                this.classList.add("is-invalid");
                feedbackDireccion.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedbackDireccion.style.display = 'none';
            }
        });
    </script>
    <script>
        const inputRTN = document.getElementById("rtn");
        const feedbackRTN = document.getElementById("feedback-rtn");

        inputRTN.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '');

            this.value = this.value.replace(/(\d)\1{3,}/g, '$1$1$1');

            const valor = this.value;
            const empiezaConCero = valor.startsWith("0");
            const sinRepetidos = !/(\d)\1{3,}/.test(valor);

            if (!empiezaConCero || !sinRepetidos) {
                this.classList.add("is-invalid");
                feedbackRTN.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedbackRTN.style.display = 'none';
            }
        });
    </script>
    <script>
        const inputEvento = document.getElementById("evento_nombre");
        const feedbackEvento = document.getElementById("feedback-evento");

        inputEvento.addEventListener("input", function () {

            this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]/g, '');

            this.value = this.value.replace(/(\w)\1{4,}/g, '$1$1$1$1');

            const tieneRepetidos = /(\w)\1{4,}/.test(this.value);

            if (tieneRepetidos) {
                this.classList.add("is-invalid");
                feedbackEvento.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedbackEvento.style.display = 'none';
            }
        });
    </script>
    <script>
        const inputFechaEvento = document.getElementById("fecha_evento");
        const feedbackFechaEvento = document.getElementById("feedback-fecha-evento");

        const hoy = new Date();
        const yyyy = hoy.getFullYear();
        const mm = String(hoy.getMonth() + 1).padStart(2, '0');
        const dd = String(hoy.getDate()).padStart(2, '0');
        const hoyStr = `${yyyy}-${mm}-${dd}`;
        inputFechaEvento.setAttribute("min", hoyStr);

        inputFechaEvento.addEventListener("change", function () {
            const seleccionada = new Date(this.value);
            const fechaHoy = new Date(hoyStr);

            if (seleccionada < fechaHoy) {
                this.classList.add("is-invalid");
                feedbackFechaEvento.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedbackFechaEvento.style.display = 'none';
            }
        });
    </script>

    <script>
        const inputEdit = document.getElementById("edit-nombre-evento");
        const feedbackEdit = document.getElementById("feedback-edit-evento");

        inputEdit.addEventListener("input", function () {

            this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]/g, '');

            this.value = this.value.replace(/(\w)\1{4,}/g, '$1$1$1$1');

            const tieneRepetidos = /(\w)\1{4,}/.test(this.value);

            if (tieneRepetidos) {
                this.classList.add("is-invalid");
                feedbackEdit.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedbackEdit.style.display = 'none';
            }
        });
    </script>
    <script>
        const inputFechaEdit = document.getElementById("edit-fecha-programa");
        const feedbackFechaEdit = document.getElementById("feedback-edit-fecha");

        const hoy = new Date();
        const yyyy = hoy.getFullYear();
        const mm = String(hoy.getMonth() + 1).padStart(2, '0');
        const dd = String(hoy.getDate()).padStart(2, '0');
        const fechaHoyStr = `${yyyy}-${mm}-${dd}`;
        inputFechaEdit.setAttribute("min", fechaHoyStr);


        inputFechaEdit.addEventListener("change", function () {
            const seleccionada = new Date(this.value);
            const fechaHoy = new Date(fechaHoyStr);

            if (seleccionada < fechaHoy) {
                this.classList.add("is-invalid");
                feedbackFechaEdit.style.display = 'block';
            } else {
                this.classList.remove("is-invalid");
                feedbackFechaEdit.style.display = 'none';
            }
        });
    </script>

    <script>
        const horasExtrasSalon = @json($horasExtrasSalon);
    </script>

</body>

</html>