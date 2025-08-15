<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones Expiradas - Sistema de Gestión</title>
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
                <h2 class="mb-0"><i class="bi bi-clock-history me-2"></i> Cotizaciones Expiradas</h2>
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

            <!-- Card de Cotizaciones -->
            <div class="card shadow border-0">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0"><i class="bi bi-list-check me-2"></i> Listado de Cotizaciones</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Evento</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Horas</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($cotizaciones) && count($cotizaciones) > 0)
                                    @foreach($cotizaciones as $index => $c)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $c['cliente'] }}</td>
                                            <td>{{ $c['nombre_evento'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($c['fecha_programa'])->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($c['hora_programada'])->format('H:i') }}</td>
                                            <td>{{ $c['horas_evento'] }}</td>
                                            <td>
                                                <span class="badge bg-danger text-uppercase">{{ $c['estado'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-warning btn-detalle" 
                                                    data-id="{{ $c['cod_cotizacion'] }}" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No hay cotizaciones expiradas</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalle de Cotización -->
    <div class="modal fade" id="detalleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-text me-2"></i> Detalle de Cotización</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="detalleContenido" class="text-center">
                        <div class="contenedor-modal">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <img src="{{ asset('img/manologochiminike.jpeg') }}" alt="Logo Chiminike" style="width: 80px;">
                                <div class="text-center">
                                    <h4 class="mb-0">Museo Chiminike</h4>
                                    <p class="mb-0 fw-semibold">Cotización Expirada</p>
                                </div>
                                <img src="{{ asset('img/manologochiminike.jpeg') }}" alt="Logo Chiminike" style="width: 80px;">
                            </div>

                            <div class="mb-3">
                                <p><strong>Evento:</strong> <span id="cotizacion-nombre">---</span></p>
                                <p><strong>Cliente:</strong> <span id="cotizacion-cliente">---</span></p>
                                <p><strong>Fecha del evento:</strong> <span id="cotizacion-fecha-evento">---</span></p>
                                <p><strong>Hora de inicio:</strong> <span id="cotizacion-hora">---</span></p>
                                <p><strong>Horas de evento:</strong> <span id="cotizacion-horas">---</span></p>
                                <p><strong>Estado:</strong> <span id="cotizacion-estado">---</span></p>
                            </div>

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
                                    <tr><td colspan="4">Sin productos</td></tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th id="total-general">L 0.00</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a id="btn-generar-pdf" href="#" class="btn btn-danger btn-sm" target="_blank">
                                    <i class="bi bi-file-pdf"></i> Generar PDF
                                </a>
                                <button class="btn btn-success btn-sm" id="btn-enviar-correo">
                                    <i class="bi bi-send"></i> Enviar por correo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-detalle').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                fetch(`http://localhost:3000/cotizaciones/expiradas/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const detalle = data[0];

                            document.getElementById('cotizacion-nombre').innerText = detalle.nombre_evento || '---';
                            document.getElementById('cotizacion-cliente').innerText = detalle.cliente || '---';
                            document.getElementById('cotizacion-fecha-evento').innerText = detalle.fecha_programa ? new Date(detalle.fecha_programa).toLocaleDateString() : '---';
                            document.getElementById('cotizacion-hora').innerText = detalle.hora_programada || '---';
                            document.getElementById('cotizacion-horas').innerText = detalle.horas_evento || '---';
                            document.getElementById('cotizacion-estado').innerText = detalle.estado || '---';

                            const productosBody = document.getElementById('productos-body');
                            productosBody.innerHTML = '';
                            let totalGeneral = 0;

                            data.forEach(p => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${p.cantidad}</td>
                                    <td>${p.descripcion}</td>
                                    <td>L ${parseFloat(p.precio_unitario).toFixed(2)}</td>
                                    <td>L ${parseFloat(p.total).toFixed(2)}</td>
                                `;
                                productosBody.appendChild(row);
                                totalGeneral += parseFloat(p.total);
                            });

                            document.getElementById('total-general').innerText = `L ${totalGeneral.toFixed(2)}`;

                            document.getElementById('btn-generar-pdf').href = `/pdf/cotizacion/${id}`;
                            document.getElementById('btn-enviar-correo').onclick = () => {
                                Swal.fire({
                                    title: 'Enviar correo',
                                    text: '¿Desea enviar esta cotización por correo?',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Enviar',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Lógica para enviar correo
                                    }
                                });
                            };

                            const modal = new bootstrap.Modal(document.getElementById('detalleModal'));
                            modal.show();
                        } else {
                            Swal.fire('Error', 'No se encontraron detalles para esta cotización', 'error');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire('Error', 'Error al obtener los detalles de la cotización', 'error');
                    });
            });
        });
    </script>
</body>
</html>