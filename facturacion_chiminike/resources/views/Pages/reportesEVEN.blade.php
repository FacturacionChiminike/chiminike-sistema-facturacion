<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista Reportes - Facturación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/reportes.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Estilo para el modal de tablas ampliadas */
        .table-modal .modal-dialog {
            max-width: 90%;
        }
        .table-modal .modal-body {
            overflow-x: auto;
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }
        
        /* Ajustes para el main-content con sidebar */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Estilos personalizados solicitados */
        .card-header {
            background-color: #d8f3dc !important;
            color: #000 !important;
            font-weight: bold;
            border-bottom: 1px solid #b7e4c7;
        }
        
        .sidebar-header .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000 !important;
            display: flex;
            align-items: center;
        }
        
        .sidebar-header .logo i {
            font-size: 2rem;
            margin-right: 10px;
            color: #2d6a4f;
        }
        
        /* Estilos para los botones de rango de fecha */
        .btn-date {
            background-color: #d8f3dc;
            color: #000;
            border: 1px solid #b7e4c7;
        }
        
        .btn-date.active {
            background-color: #b7e4c7;
            font-weight: bold;
        }
        
        /* Estilos para las tarjetas de resumen */
        .summary-card {
            border-left: 4px solid #b7e4c7;
        }
        
        .summary-card .card-title {
            color: #000;
            font-weight: bold;
        }
        
        .summary-card .card-value {
            color: #000;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Estilos para tablas - modificaciones solicitadas */
        .compact-table {
            font-size: 0.85rem;
            width: 100%;
            margin-bottom: 1.5rem; /* Separación entre tablas */
        }
        
        .compact-table th, .compact-table td {
            padding: 0.5rem 0.75rem; /* Más espacio interno */
        }
        
        .no-gap {
            margin-bottom: 0;
        }
        
        .employee-table-container {
            overflow-x: auto;
            margin-top: 0;
        }

        /* Asegurar misma anchura para todas las tablas */
        .table-responsive {
            width: 100%;
            margin-bottom: 1.5rem; /* Separación adicional */
        }

        /* Estilo para SweetAlert */
        .swal2-popup {
            font-family: inherit;
        }
        /* Layout del sidebar (sin cambiar colores) */
.sidebar{
  position: fixed;
  top: 0; left: 0;
  width: 250px;
  height: 100vh;
  display: flex;
  flex-direction: column;
  z-index: 1030;            /* suficiente para estar encima del main si hace falta */
}

/* Solo el menú hace scroll y deja espacio para el footer */
.sidebar-menu{
  flex: 1 1 auto;
  overflow-y: auto;
  padding-bottom: 72px;      /* reserva espacio para el botón de cerrar sesión */
}

/* Footer siempre visible y clickeable */
.sidebar-footer{
  position: sticky;
  bottom: 0;
  padding: 12px;
  z-index: 1;                /* por encima del contenedor scroll */
}

/* Botón ancho completo (no cambia color) */
.logout-btn{
  width: 100%;
  display: flex;
  align-items: center;
  gap: 8px;
}

/* El contenido no se monta debajo del sidebar */
.main-content{
  margin-left: 250px;
  position: relative;
  z-index: 0;
}
@media (max-width: 992px){
  .main-content{ margin-left: 0; }
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
    <div class="container mt-4" id="contenedor-reportes">

        <div class="header-section">
            <h1 class="mb-1"><i class="fas fa-calendar-alt me-2"></i>Vista Reportes - Eventos</h1>
        </div>

        <!-- Resumen General -->
        <div class="row mb-4 g-4" id="bloque-resumen">
            <div class="col-md-4">
                <div class="card summary-card total-eventos">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-calendar-alt me-2"></i>Total de Eventos</h5>
                                <p class="card-value" id="totalEventos">0</p>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total de Reservaciones -->
            <div class="col-md-4">
                <div class="card summary-card total-reservaciones">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-calendar-alt me-2"></i>Total de Reservaciones</h5>
                                <p class="card-value" id="totalReservaciones">0</p>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="card chart-card no-gap">
                    <div class="card-header">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Total Cotizaciones
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-sm compact-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                               <tbody id="tablaTotalCotizaciones">    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card chart-card no-gap">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-2"></i>Distribución Cotizaciones
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-sm compact-table">
                                <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Cantidad</th>
                                    </tr>
                            
       <tbody id="tablaDistribucionCotizaciones">
    
  </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="text-end mb-3">
            <a href="{{ route('reportes.cotizaciones.pdf') }}"class="btn btn-danger me-2" id="btn-pdf">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </a>

            <a href="{{ route('reportes.excel') }}" class="btn btn-success" id="btn-excel" target="_blank">
                <i class="fas fa-file-excel"></i> Exportar a Excel
            </a>
        </div>

        <!-- Sección de Reporte de Cotizaciones -->
        <div class="card chart-card mb-4">
            <div class="card-header">
                <i class="fas fa-file-invoice-dollar me-2"></i>Reporte de Cotizaciones
            </div>
            <div class="card-body">
                <!-- Gráfico de Cotizaciones -->
                <div class="chart-container" style="min-height: 400px;">
                    <canvas id="graficaCotizacionesEstado"></canvas>
                </div>

                <!-- Tabla de Cotizaciones -->
                <div class="table-responsive mt-4">
                    <table class="table table-striped" id="tabla-cotizaciones">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Cliente</th>
                                <th>RTN</th>
                                <th>Fecha</th>
                                <th>Validez</th>
                                <th>Estado</th>
                                <th>Total Cotizado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se insertan las filas -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Gráfico de Eventos -->
        <div class="card chart-card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-2"></i>Gráfico de Eventos
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; width: 100%;">
                    <canvas id="graficaEventos"></canvas>
                </div>
            </div>
        </div>

        <!-- Reporte de Eventos -->
        <div class="card chart-card mb-4">
            <div class="card-header">
                <i class="fas fa-calendar-alt me-2"></i>Reporte de Eventos
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tabla-eventos">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Cotización</th>
                                <th>Horas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- JS inserta aquí -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- reporte de reservaciones -->
        <section class="mt-4">
            <h5 class="text-center fw-bold">Reporte de Reservaciones</h5>

            <!-- Gráfica centrada y ajustada -->
            <div class="d-flex justify-content-center">
                <div id="graficaReservacionesContainer" style="width: 95%; min-height: 350px;">
                    <!-- El canvas será insertado dinámicamente con JS -->
                </div>
            </div>

            <!-- Tabla centrada -->
            <div class="d-flex justify-content-center mt-4">
                <div class="table-responsive" style="width: 95%;">
                    <table class="table table-bordered table-striped text-center" id="tabla-reservaciones">
                        <thead class="table-success">
                            <tr>
                                <th style="min-width: 180px;">Evento</th>
                                <th style="min-width: 100px;">Fecha</th>
                                <th style="min-width: 100px;">Hora</th>
                                <th style="min-width: 120px;">Duración (hrs)</th>
                                <th style="min-width: 160px;">Cliente</th>
                                <th style="min-width: 160px;">RTN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Se llena con JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- JS del módulo de reportes -->
<script src="{{ asset('js/reportes.js') }}"></script>

<script>
    // Script idéntico al original para manejar la visualización
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar gráficos principales
        initializeCharts();

        // Configurar SweetAlert para botones de exportación
        document.getElementById('btn-pdf').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Generando PDF',
                text: 'Por favor espere mientras se genera el reporte en PDF...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    window.location.href = this.href;
                }
            });
        });

        document.getElementById('btn-excel').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Generando Excel',
                text: 'Por favor espere mientras se genera el reporte en Excel...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    window.open(this.href, '_blank');
                    Swal.close();
                }
            });
        });

        // Mostrar alerta cuando se carguen los datos
        window.addEventListener('datosCargados', function() {
            Swal.fire({
                title: '¡Listo!',
                text: 'Todos los reportes han sido cargados correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        });
    });
</script>

</body>
</html>