<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones- Sistema de Gestión</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/cai.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reservaciones.css') }}" rel="stylesheet">
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
                <h2 class="mb-0"><i class="bi bi-calendar-check me-2"></i> Reservaciones </h2>
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Dashboard
                </a>
            </div>

            <!-- Alertas -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Card de Reservaciones -->
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-list-check me-2"></i> Listado de Reservaciones</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre del Evento</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Cliente</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @forelse ($reservaciones as $res)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $res['nombre_evento'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($res['fecha_programa'])->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($res['hora_programada'])->format('H:i') }}</td>
                                        <td>{{ $res['cliente'] }}</td>
                                        <td>
                                            <span class="badge bg-success">Confirmada</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-info"
                                                    onclick="mostrarDetalle({{ $res['cod_evento'] }})" title="Detalle">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @if(tienePermiso('Gestión de reservaciones', 'actualizar'))
                                                    <button class="btn btn-sm btn-outline-warning"
                                                        onclick="abrirModalEditar({{ $res['cod_evento'] }})" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">No hay reservaciones confirmadas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de detalle -->
    <div class="modal fade" id="detalleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-text me-2"></i> Detalle de la Reservación</h5>
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
                                    <p class="mb-0 fw-semibold">Reservación de Evento</p>
                                </div>
                                <img src="{{ asset('img/manologochiminike.jpeg') }}" alt="Logo Chiminike"
                                    class="logo-modal" style="width: 80px;">
                            </div>

                            <!-- DATOS DEL EVENTO -->
                            <div class="datos-evento-modal mb-3">
                                <p><strong>Evento:</strong> <span id="evento-nombre">---</span></p>
                                <p><strong>Cliente:</strong> <span id="evento-cliente">---</span></p>
                                <p><strong>Hora de inicio:</strong> <span id="evento-hora">---</span></p>
                                <p><strong>Horas de evento:</strong> <span id="evento-horas">---</span></p>
                                <p><strong>Estado:</strong> <span id="evento-estado">---</span></p>
                            </div>

                            <!-- TABLA DE PRODUCTOS -->
                            <table class="table table-bordered table-sm text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Precio Unitario</th>
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
                                        <th colspan="3">Total</th>
                                        <th id="total-general">L 0.00</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- MENSAJE -->
                            <p class="mensaje-modal mt-2">y aquí un mensaje que bonito</p>

                            <!-- BOTONES -->
                            <div class="botones-modal d-flex justify-content-center gap-2 mt-3">
                                <a id="btn-generar-pdf" href="#" class="btn btn-danger btn-sm" target="_blank">
                                    <i class="bi bi-file-pdf"></i> Generar PDF
                                </a>
                                <button id="btn-enviar-correo">Enviar por correo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de edición -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i> Editar Reservación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditarReservacion">
                    <div class="modal-body">
                        <input type="hidden" id="edit-cod-cotizacion">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Evento</label>
                                <input type="text" id="edit-nombre-evento" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Fecha del Evento</label>
                                <input type="date" id="edit-fecha-programa" class="form-control" required>
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
                                <input type="text" id="edit-estado" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Productos de la Reservación</label>
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
                                <i class="bi bi-plus-circle me-1"></i> Agregar Producto
                            </button>
                            <small class="text-muted d-block mt-1">
                                Puedes modificar, agregar o eliminar productos directamente aquí antes de actualizar.
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/reservaciones.js') }}"></script>

    <script>
        const catalogos = @json($catalogos);
    </script>

  
    <script>
        document.getElementById("btn-enviar-correo").addEventListener("click", function () {
            if (!window.cod_reservacion_actual) {
                Swal.fire("Error", "No se encontró la reservación para enviar.", "error");
                return;
            }

            Swal.fire({
                title: "Enviando correo...",
                text: "Espere mientras se envía la reservación al cliente.",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
            });

            fetch(`/reservaciones/${window.cod_reservacion_actual}/enviar-correo`, {
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
   

</body>

</html>