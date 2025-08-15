<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Factura Recorrido Escolar - Sistema de Gestión</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="/css/generador-facturas.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <style>
   /* Aseguramos que el main-content quede al lado del sidebar */
.main-content {
  margin-left: 250px;
  padding: 20px;
}

/* Contenedor general */
.container-factura {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
}

/* Título */
.titulo-factura {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 2rem;
  color: #333;
  text-align: center;
}

/* Formulario de facturación */
.factura-form {
  background: #fff;
  border-radius: 0.75rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  padding: 2rem;
  margin-top: 2rem;
}

.form-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #eee;
}

.form-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #333;
  margin: 0;
  text-align: center;
  width: 100%;
}

/* Estilos para los elementos del formulario */
.grid-form {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.grid-form div {
  margin-bottom: 0.5rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #555;
}

input, select, textarea {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.btn-add, .btn-guardar {
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  margin-top: 1rem;
}

.btn-guardar {
  background-color: #2196F3;
  padding: 0.75rem 1.5rem;
  font-size: 1.1rem;
}

.btn-add:hover, .btn-guardar:hover {
  opacity: 0.9;
}

/* Tabla de boletos */
.tabla-detalle {
  width: 100%;
  border-collapse: collapse;
  margin: 1rem 0;
}

.tabla-detalle th, .tabla-detalle td {
  padding: 0.75rem;
  border: 1px solid #ddd;
  text-align: left;
}

.tabla-detalle th {
  background-color: #b4282d;
  font-weight: 600;
}

/* Sección de totales */
.totales-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.5rem;
  margin: 1.5rem 0;
  padding: 1rem;
  background-color: #f9f9f9;
  border-radius: 4px;
}

.totales-grid div:nth-child(odd) {
  font-weight: 500;
}

.totales-grid div:nth-child(even) {
  text-align: right;
}

/* Formulario nuevo cliente */
.nuevo-cliente-form {
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 4px;
  margin-top: 1rem;
  border: 1px solid #eee;
}

.nuevo-cliente-form button {
  margin-right: 0.5rem;
}

/* Sección título */
.seccion-titulo {
  font-size: 1.2rem;
  font-weight: 600;
  margin: 1.5rem 0 0.5rem;
  color: #333;
}

/* ============================= */
/* === RESPONSIVE MOBILE FIX === */
/* ============================= */
@media (max-width: 768px) {
  .main-content {
    margin-left: 0;
    padding: 1rem;
  }

  .container-factura {
    padding: 0 1rem;
  }

  .form-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .form-title {
    text-align: center;
    width: 100%;
  }

  .grid-form {
    grid-template-columns: 1fr !important; /* apila los campos */
  }

  .tabla-detalle {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }

  .totales-grid {
    grid-template-columns: 1fr;
  }

  .btn-add,
  .btn-guardar {
    width: 100%;
  }
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
    <div class="container-factura">
      <h1 class="titulo-factura">Facturación - Recorrido Escolar</h1>
      <a href="{{ route('dashboard') }}" id="btn-dashboard" class="btn me-2">
    <i class="bi bi-arrow-left me-1"></i> Dashboard
</a>
      <div class="factura-form" id="form-factura-recorrido">
        <div class="form-header">
          <h2 class="form-title">Detalles de Factura</h2>
        </div>
        
        <input type="hidden" id="tipo-recorrido" value="recorrido">
        
        <div class="grid-form">
          <div>
            <label>Número de Factura:</label>
            <input type="text" class="numero-factura" readonly placeholder="Cargando...">
          </div>
          <div>
            <label>CAI:</label>
            <input type="text" class="cai-field" readonly placeholder="Cargando...">
          </div>
          <div>
            <label>Cliente:</label>
            <select id="cliente-recorrido" required>
              <option value="">Cargando...</option>
            </select>
            <button type="button" id="btn-nuevo-cliente-recorrido" class="btn-add" style="margin-top: 0.5rem;">Nuevo Cliente</button>
            <div id="form-nuevo-cliente-recorrido" class="nuevo-cliente-form" style="display:none;">
              <div class="grid-form">
                <div>
                  <label>Nombre del Cliente <span style="color:#e53e3e;">(obligatorio)</span></label>
                  <input type="text" id="new-nombre-recorrido" required>
                </div>
                <div>
                  <label>Fecha de Nacimiento <span style="color:#718096;">(opcional)</span></label>
                  <input type="date" id="new-fecha-recorrido">
                </div>
                <div>
                  <label>Sexo <span style="color:#718096;">(opcional)</span></label>
                  <select id="new-sexo-recorrido">
                    <option value="">Seleccione...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                  </select>
                </div>
                <div>
                  <label>DNI <span style="color:#718096;">(opcional)</span></label>
                  <input type="text" id="new-dni-recorrido">
                </div>
                <div>
                  <label>Correo <span style="color:#718096;">(opcional)</span></label>
                  <input type="email" id="new-correo-recorrido">
                </div>
                <div>
                  <label>Teléfono <span style="color:#718096;">(opcional)</span></label>
                  <input type="text" id="new-telefono-recorrido">
                </div>
                <div>
                  <label>Dirección <span style="color:#718096;">(opcional)</span></label>
                  <input type="text" id="new-direccion-recorrido">
                </div>
                <div>
                  <label>Municipio <span style="color:#718096;">(opcional)</span></label>
                  <select id="new-municipio-recorrido">
                    <option value="">Cargando…</option>
                  </select>
                </div>
                <div>
                  <label>RTN <span style="color:#718096;">(opcional)</span></label>
                  <input type="text" id="new-rtn-recorrido">
                </div>
                <div>
                  <label>Tipo Cliente <span style="color:#718096;">(opcional)</span></label>
                  <select id="new-tipo-recorrido">
                    <option value="">Seleccione...</option>
                    <option value="Individual">Individual</option>
                    <option value="Empresa">Empresa</option>
                  </select>
                </div>
              </div>
              <div style="margin-top:10px;">
                <button type="button" id="guardar-nuevo-cliente-recorrido" class="btn-guardar">Guardar Cliente</button>
                <button type="button" id="cancelar-nuevo-cliente-recorrido" class="btn-add" style="background-color: #f44336;">Cancelar</button>
              </div>
            </div>
          </div>
          <div>
            <label>Empleado:</label>
            <input type="hidden" id="empleado-recorrido" name="cod_empleado" value="{{ $usuario['cod_usuario'] ?? '' }}">
            <input type="text" class="form-control" readonly value="{{ $usuario['nombre_usuario'] ?? 'Usuario' }}">
          </div>
        </div>

        <div class="seccion-titulo">Detalle de Ítems</div>
        <table class="tabla-detalle">
          <thead>
            <tr>
              <th>Item</th>
              <th>Cantidad</th>
              <th>Precio Unitario</th>
              <th>Total</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="boletos-container-recorrido"></tbody>
          <tbody id="productos-container-recorrido"></tbody>
        </table>
        <div class="action-buttons">
          <button type="button" class="btn-add" id="agregar-boleto-recorrido">+ Añadir Boleto</button>
          <button type="button" class="btn-add" id="agregar-producto-recorrido">+ Añadir Paquetes</button>
           <button type="button" class="btn-add" id="agregar-adicional-recorrido">+ Añadir Adicionales</button>
        </div>

        <div class="seccion-titulo">Totales</div>
        <div class="totales-grid">
          <div>Descuento otorgado (<span id="descuento-pct-recorrido">0</span>%):</div>
          <div>
            <button type="button" onclick="aplicar('descuento','recorrido')" class="btn-add">Aplicar</button>
            <span id="descuento-valor-recorrido">L. 0.00</span>
          </div>

          <div>Rebajas otorgadas (<span id="rebaja-pct-recorrido">0</span>%):</div>
          <div>
            <button type="button" onclick="aplicar('rebaja','recorrido')" class="btn-add">Aplicar</button>
            <span id="rebaja-valor-recorrido">L. 0.00</span>
          </div>

          <div>Importe exento (<span id="exento-pct-recorrido">0</span>%):</div>
          <div>
            <button type="button" onclick="aplicar('exento','recorrido')" class="btn-add">Aplicar</button>
            <span id="exento-valor-recorrido">L. 0.00</span>
          </div>

          <div>Importe grabado 18%:</div>
          <div>
            <button type="button" onclick="aplicar('grabado18','recorrido')" class="btn-add">Aplicar</button>
            <span id="grabado18-recorrido">L. 0.00</span>
          </div>

          <div>Importe grabado 15%:</div>
          <div>
            <button type="button" onclick="aplicar('grabado15','recorrido')" class="btn-add">Aplicar</button>
            <span id="grabado15-recorrido">L. 0.00</span>
          </div>

          <div>Impuesto 18%:</div>
          <div>
            <button type="button" onclick="aplicar('impuesto18','recorrido')" class="btn-add">Aplicar</button>
            <span id="impuesto18-recorrido">L. 0.00</span>
          </div>

          <div>Impuesto 15%:</div>
          <div>
            <button type="button" onclick="aplicar('impuesto15','recorrido')" class="btn-add">Aplicar</button>
            <span id="impuesto15-recorrido">L. 0.00</span>
          </div>

          <div>Importe exonerado:</div>
          <div>
            <button type="button" onclick="aplicar('exonerado','recorrido')" class="btn-add">Aplicar</button>
            <span id="exonerado-recorrido">L. 0.00</span>
          </div>

          <div>Subtotal:</div>
          <div id="subtotal-recorrido">L. 0.00</div>

          <div>Total:</div>
          <div id="total-recorrido">L. 0.00</div>
        </div>

        <div>
          <label>Notas:</label><div style="font-size: 0.9rem; color: gray; margin-top: 5px;">(Opcional)</div>
          <textarea id="nota-recorrido" style="width: 100%; min-height: 100px;"></textarea>
        </div>
        <button type="button" class="btn-guardar" id="guardar-factura-recorrido">Generar Factura</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/js/generador-facturas.js"></script>
</body>
</html>