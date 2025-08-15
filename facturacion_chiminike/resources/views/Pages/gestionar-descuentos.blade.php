<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Descuentos - Fundación Chiminike</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- CSS personalizado -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="{{ asset('css/descuento.css') }}" rel="stylesheet">
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
    <div class="container mt-4">
      <h3 class="mb-4">Gestión de Descuentos</h3>
<a href="{{ route('dashboard') }}" id="btn-dashboard" class="btn me-2">
    <i class="bi bi-arrow-left me-1"></i> Dashboard
</a>

      <div class="card mb-4 p-3">
        <form id="form-descuento">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="descuento" class="form-label">Porcentaje Descuento (%)</label>
              <input
                type="number"
                id="descuento"
                class="form-control"
                min="0"
                step="0.01"
                required
              >
            </div>
            <div class="col-md-4">
              <label for="rebaja" class="form-label">Porcentaje Rebaja (%)</label>
              <input
                type="number"
                id="rebaja"
                class="form-control"
                min="0"
                step="0.01"
                required
              >
            </div>
            <div class="col-md-4">
              <label for="importe" class="form-label">Importe Exento(%)</label>
              <input
                type="number"
                id="importe"
                class="form-control"
                min="0"
                step="0.01"
                required
              >
            </div>
          </div>
          <div class="mt-3">
            <button type="submit" class="btn btn-success">Guardar</button>
          </div>
        </form>
      </div>

      <div class="card p-3">
        <h5>Descuentos Registrados</h5>
        <div class="table-responsive mt-3">
          <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
              <tr>
                <th>Descuento (%)</th>
                <th>Rebaja (%)</th>
                <th>Importe Exento(%)</th>
              </tr>
            </thead>
            <tbody id="tabla-descuentos">
              <!-- Aquí pinta el JS -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- JS personalizado de Gestión de Descuentos -->
  <script src="{{ asset('js/gestion-descuentos.js') }}"></script>
</body>
</html>
