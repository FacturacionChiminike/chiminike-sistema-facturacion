<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Facturas</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/css/registro-facturas.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
      <div class="page-header">
        <h2><i class="bi bi-receipt me-2"></i> Registro de Facturas</h2>
      </div>
      <div class="filters-section">
        <label>Fecha Desde: <input type="date" id="fechaDesde"></label>
        <label>Fecha Hasta: <input type="date" id="fechaHasta"></label>
        <label>Tipo:
          <select id="tipoFactura">
            <option value="">Todos</option>
            <option value="Evento">Evento</option>
            <option value="Recorrido Escolar">Recorrido Escolar</option>
            <option value="Taquilla General">Taquilla General</option>
            <option value="Libros">Libros</option>
          </select>
        </label>
        <input type="text" id="busqueda" placeholder="Buscar cliente, factura...">
        <button id="filtrarBtn" class="btn-primary">Filtrar</button>
      </div>

      <div class="table-container">
        <table id="facturasTable" class="data-table">
          <thead>
            <tr>
              <th>N° Factura</th>
              <th>Fecha</th>
              <th>Tipo</th>
              <th>Cliente</th>
              <th>RTN</th>
              <th>Subtotal (L.)</th>
              <th>Total (L.)</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <!-- Modal Ver -->
      <div class="modal" id="verFacturaModal">
        <div class="modal-content">
          <span class="close" data-close="verFacturaModal">&times;</span>
          <div id="facturaVistaContent"></div>
          <a id="downloadInvoicePdf" class="btn-pdf" href="#" target="_blank">
            <i class="fas fa-file-pdf"></i> Descargar PDF
          </a>
          <button id="btnEnviarCorreo" class="btn-primary">Enviar por Correo</button>
        </div>
      </div>
      
      <!-- Modal Editar -->
      <div class="modal" id="editarFacturaModal">
        <div class="modal-content">
          <span class="close" data-close="editarFacturaModal">&times;</span>
          <h3>Editar Factura</h3>
          <div id="formEditarFactura"></div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/js/registro-facturas.js"></script>
</body>
</html>