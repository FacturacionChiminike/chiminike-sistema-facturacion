<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista Reportes</title>
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
            background-color: #d8f3dc !important; /* Verde pastel suave */
            color: #000 !important; /* Texto negro */
            font-weight: bold;
            border-bottom: 1px solid #b7e4c7;
        }
        
        .sidebar-header .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000 !important; /* Texto negro */
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

        /* Nuevos estilos para las tablas solicitadas */
        .compact-table {
            font-size: 0.85rem;
        }
        
        .compact-table th, .compact-table td {
            padding: 0.3rem 0.5rem;
        }
        
        .no-gap {
            margin-bottom: 0;
        }
        
        .employee-table-container {
            overflow-x: auto;
            margin-top: 0;
        }
    </style>
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <div class="sidebar-header">
        <h3 class="logo">
            <i class="bi bi-building"></i>
            <span>Sistema Gestión</span>
        </h3>
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
            <h1 class="mb-1"><i class="fas fa-file-alt me-2"></i>Vista Reportes</h1>
        </div>

        <!-- Resumen General -->
        <div class="row mb-4 g-4" id="bloque-resumen">
            <div class="col-md-4">
                <div class="card summary-card total-facturado">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-money-bill-wave me-2"></i>Total Facturado</h5>
                                <p class="card-value" id="totalFacturado">Lps 0.00</p>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total de Clientes -->
            <div class="col-md-4">
                <div class="card summary-card total-clientes">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-users me-2"></i>Total de Clientes</h5>
                                <p class="card-value" id="totalClientes">0</p>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-user-friends"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

            <div class="col-md-4">
                <div class="card summary-card total-facturas">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-file-invoice me-2"></i>Facturas Emitidas</h5>
                                <p class="card-value" id="totalFacturas">0</p>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card summary-card ingresos-tipo">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-list-ol me-2"></i>Resumen por Tipo</h5>
                                <ul id="listaPorTipo" class="mb-0">
                                    <!-- Se llena desde JS -->
                                </ul>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card summary-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-users-cog me-2"></i>Total de Empleados</h5>
                                <p class="card-value" id="total-empleados">0</p>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-user-tie"></i>
                            </div>
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

      <div class="d-flex justify-content-end align-items-center mb-3">
  <div class="btn-group me-2">
    <button 
      type="button" 
      class="btn btn-danger dropdown-toggle" 
      data-bs-toggle="dropdown" 
      aria-expanded="false">
      <i class="fas fa-file-pdf"></i> Descargar PDF
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
      <!-- Nueva opción Resumen General -->
      <li>
        <a class="dropdown-item" href="{{ url('/reporte/resumen/pdf') }}">
          <i class="fas fa-layer-group"></i> Resumen General
        </a>
      </li>
      <li><hr class="dropdown-divider"></li>

      <li>
        <a class="dropdown-item" href="{{ route('reportes.facturas.pdf') }}">
          <i class="fas fa-file-invoice"></i> Facturas Emitidas
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('reportes.cotizaciones.pdf') }}">
          <i class="fas fa-file-invoice-dollar"></i> Cotizaciones
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('reportes.entradas.pdf') }}">
          <i class="fas fa-ticket-alt"></i> Entradas
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('reportes.inventario.pdf') }}">
          <i class="fas fa-boxes"></i> Inventario
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('reportes.reservaciones.pdf') }}">
          <i class="fas fa-calendar-check"></i> Reservaciones
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('reportes.empleados.pdf') }}">
          <i class="fas fa-user-tie"></i> Empleados
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('reportes.salones.pdf') }}">
          <i class="fas fa-door-open"></i> Estado de Salones
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('reportes.eventos.pdf') }}">
          <i class="fas fa-calendar-alt"></i> Eventos
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('reportes.clientes.pdf') }}">
          <i class="fas fa-users"></i> Clientes
        </a>
      </li>
    </ul>
  </div>

  <a href="{{ route('reportes.excel') }}" class="btn btn-success">
    <i class="fas fa-file-excel"></i> Exportar a Excel
  </a>
</div>

        

        <!-- Sección modificada para las tablas solicitadas -->
        <div class="row mb-4 g-4">
            <!-- Primera fila con 3 tablas -->
            <div class="col-md-4">
                <div class="card chart-card no-gap">
                    <div class="card-header">
                        <i class="fas fa-layer-group me-2"></i>Facturación por Tipo
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-sm compact-table">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>Evento</td><td>Lps 180288.79</td></tr>
                                    <tr><td>Libros</td><td>Lps 1113.54</td></tr>
                                    <tr><td>Recorrido Escolar</td><td>Lps 1578.98</td></tr>
                                    <tr><td>Taquilla General</td><td>Lps 228.93</td></tr>
                                </tbody>
                            </table>
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
                                <tbody>
                                    <tr><td>Total Cotizado</td><td>L 1,060,645.00</td></tr>
                                    <tr><td>Cantidad</td><td>29</td></tr>
                                </tbody>
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
                                </thead>
                                <tbody>
                                    <tr><td>Completada</td><td>10</td></tr>
                                    <tr><td>Pendiente</td><td>8</td></tr>
                                    <tr><td>Confirmada</td><td>7</td></tr>
                                    <tr><td>Expirada</td><td>4</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
    <div class="card chart-card no-gap">
        <div class="card-header">
            <i class="fas fa-door-open me-2"></i>Estado de Salones
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-sm compact-table">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-salones-estado">
                        <!-- Se llena por JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





        <!-- Reporte de Empleados -->
        <div class="card chart-card mb-4 no-gap">
            <div class="card-header">
                <i class="fas fa-user-tie me-2"></i>Reporte de Empleados
            </div>
            <div class="card-body p-0">
                <div class="employee-table-container">
                    <table class="table table-sm compact-table table-bordered table-striped mb-0">
                        <thead class="table-success">
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Cargo</th>
                                <th>Salario</th>
                                <th>Contratación</th>
                                <th>Departamento</th>
                                <th>Región</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>27</td>
                                <td>Kellyn Castillo</td>
                                <td>0801200305623</td>
                                <td>Supervisor</td>
                                <td>L. 42000.00</td>
                                <td>1/5/2025</td>
                                <td>Dirección General</td>
                                <td>Atlántida</td>
                                <td>95921947</td>
                                <td>kellyncastillo1203@gmail.com</td>
                                <td>kellyn.castillo623</td>
                                <td>Dirección</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td>28</td>
                                <td>Miguel Garcia</td>
                                <td>080120000063</td>
                                <td>Gerente</td>
                                <td>L. 50000.00</td>
                                <td>20/7/2022</td>
                                <td>Dirección General</td>
                                <td>Atlántida</td>
                                <td>33815554</td>
                                <td>miguelgarcia9647@gmail.com</td>
                                <td>miguel.garcia063</td>
                                <td>Dirección</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td>29</td>
                                <td>Moises Ucles</td>
                                <td>6523653256325</td>
                                <td>Informatico</td>
                                <td>L. 43222.00</td>
                                <td>3/7/2025</td>
                                <td>Facturación</td>
                                <td>Choluteca</td>
                                <td>34233432</td>
                                <td>msucles3288@gmail.com</td>
                                <td>mucles.325</td>
                                <td>Dirección</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td>30</td>
                                <td>Luis Molina</td>
                                <td>080120050479</td>
                                <td>test</td>
                                <td>L. 11.00</td>
                                <td>9/7/2025</td>
                                <td>Dirección General</td>
                                <td>Atlántida</td>
                                <td>99325427</td>
                                <td>lmolinam3000@gmail.com</td>
                                <td>lmolina.479</td>
                                <td>Dirección</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td>31</td>
                                <td>Jeremy Mejia</td>
                                <td>0801200202766</td>
                                <td>hola</td>
                                <td>L. 1.00</td>
                                <td>9/7/2025</td>
                                <td>Dirección General</td>
                                <td>Atlántida</td>
                                <td>96696217</td>
                                <td>jeremymejia890@gmail.com</td>
                                <td>jmejia.766</td>
                                <td>Dirección</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td>32</td>
                                <td>Josue Said</td>
                                <td>0801200600000</td>
                                <td>josue</td>
                                <td>L. 1.00</td>
                                <td>9/7/2025</td>
                                <td>Dirección General</td>
                                <td>Atlántida</td>
                                <td>89906208</td>
                                <td>eljosuemeraz@gmail.com</td>
                                <td>jsaid.000</td>
                                <td>Dirección</td>
                                <td>Activo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Resto del contenido original (no modificado) -->
        <!-- Resumen por Tipo de Factura -->
        <div class="card chart-card mb-4">
            <div class="card-header">
                <i class="fas fa-layer-group me-2"></i>Facturación por Tipo de Factura
            </div>
            <div class="card-body facturacion-tipo-container">
                <div class="chart-container tipo-factura">
                    <canvas id="graficaTipoFactura"></canvas>
                </div>
                
                <!-- Leyenda de colores -->
                <div class="chart-legend" id="leyendaTipoFactura">
                    <!-- Se llena dinámicamente con JavaScript -->
                </div>
                
                <div class="table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tipo de Factura</th>
                                <th>Cantidad Emitidas</th>
                                <th>Total Facturado</th>
                            </tr>
                        </thead>
                        <tbody id="tablaResumenTipoFactura">
                            <!-- Datos se llenan con JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Gráfica Ventas Mensuales -->
        <div class="card mb-4 chart-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-line me-2"></i>Ventas Mensuales</span>
                <div class="date-range">
                    <button class="btn btn-sm btn-date active" data-meses="6">6 Meses</button>
                    <button class="btn btn-sm btn-date" data-meses="12">1 Año</button>
                    <button class="btn btn-sm btn-date" data-meses="24">2 Años</button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="graficaVentasMensuales"></canvas>
                </div>
            </div>
        </div>

        <!-- Tablas en fila -->
        <div class="row mb-4 g-4">
            <!-- Tabla: Top Clientes -->
            <div class="col-lg-6">
                <div class="card chart-card">
                    <div class="card-header">
                        <i class="fas fa-users me-2"></i>Top Clientes
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="graficaTopClientes"></canvas>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>RTN</th>
                                        <th>Total Facturado</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaTopClientes">
                                    <!-- Se llena por JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla: Servicios Populares -->
            <div class="col-lg-6">
                <div class="card chart-card">
                    <div class="card-header">
                        <i class="fas fa-cubes me-2"></i>Servicios Más Vendidos
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="graficaServiciosPopulares"></canvas>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Ingresos</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaServiciosPopulares">
                                    <!-- Se llena por JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico: Ventas de Lunes a Viernes -->
        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold text-primary mb-3">
                    📊 Ventas de Lunes a Viernes
                </h5>
                <div style="position: relative; width: 100%; height: 500px;">
                    <canvas id="graficaVentasLunesViernes"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico: Ventas Chiminike Weekend -->
        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold text-primary mb-3">
                    📅 Ventas Chiminike Weekend
                </h5>
                <div style="position: relative; width: 100%; height: 500px;">
                    <canvas id="graficaVentasWeekend"></canvas>
                </div>
            </div>
        </div>


        <!-- Sección de Reporte de Cotizaciones -->
        <div class="card chart-card mb-4">
            <div class="card-header">
                <i class="fas fa-file-invoice-dollar me-2"></i>Reporte de Cotizaciones
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="graficaCotizacionesEstado"></canvas>
                </div>

                <div class="chart-container">
                    <canvas id="graficaCotizaciones"></canvas>
                </div>
                
                <div class="table-responsive">
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

        <!-- Reporte de Inventario -->
        <div class="card chart-card mb-4">
            <div class="card-header">
                <i class="fas fa-boxes me-2"></i>Reporte de Inventario
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="graficaInventario"></canvas>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="tabla-inventario">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <section class="mt-4">
    <h5 class="text-center fw-bold">Reporte de Salones por Estado</h5>
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th>Estado</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody id="tabla-salones-estado">
                <!-- Se llena por JS -->
            </tbody>
        </table>
    </div>
</section>


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

        <!-- Reporte de Clientes -->
        <div class="card chart-card mb-4">
            <div class="card-header">
                <i class="fas fa-user me-2"></i>Reporte de Clientes
            </div>

            <!-- Gráfico de Clientes -->
            <div class="chart-container mb-4" style="position: relative; width: 100%; height: 300px;">
                <div class="chart-container mb-4">
                    <canvas id="graficaClientes"></canvas>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tabla-clientes">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>RTN</th>
                                <th>Tipo</th>
                                <th>DNI</th>
                                <th>Sexo</th>
                                <th>Nacimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- JS inserta aquí -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- reporte de reservaciones -->
<section class="mt-4">
    <h5 class="text-center fw-bold">Reporte de Reservaciones</h5>

    <!-- Gráfica -->
    <div class="mt-4 mb-5">
        <div id="graficaReservacionesContainer" style="position: relative; height: 400px;">
            <canvas id="graficaReservaciones"></canvas>
        </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Hora</th>   
                    <th>Duración (hrs)</th>
                    <th>Cliente</th>
                    <th>RTN</th>
                </tr>
            </thead>
            <tbody id="tabla-reservaciones">
                <!-- Se llena por JS -->
            </tbody>
        </table>
    </div>
</section>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JS del módulo de reportes -->
<script src="{{ asset('js/reportes.js') }}"></script>

<script>
    // Script para manejar la visualización de tablas en modal
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar gráficos principales
        initializeCharts();
    });
</script>

</body>
</html>