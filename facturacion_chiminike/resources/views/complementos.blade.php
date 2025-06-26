<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Complementos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <div class="dashboard-container">
        @include('layouts.sidebar')
  

  <div class="container mt-4">

    <!-- Botón de regreso -->
    <div class="d-flex justify-content-between mb-4">
      <h2>Recorridos Escolares CHIMINIKE</h2>
      <a href="/dashboard" class="btn btn-secondary">Regresar al Dashboard</a>
    </div>

    <!-- ======================= ADICIONALES ======================= -->
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <h4>Adicionales</h4>
        @if(tienePermiso('Gestión de recorridos escolares', 'insertar'))
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicional">
        Nuevo Adicional
      </button>
    @endif


      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Precio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tablaAdicionales">
            @foreach ($adicionales as $a)
          <tr data-id="{{ $a['cod_adicional'] }}">
            <td>{{ $a['nombre'] }}</td>
            <td>{{ $a['descripcion'] }}</td>
            <td>{{ $a['precio'] }}</td>
            <td>
            @if(tienePermiso('Gestión de recorridos escolares', 'actualizar'))
          <button class="btn btn-warning btn-sm editarAdicionalBtn">Editar</button>
        @endif

            @if(tienePermiso('Gestión de recorridos escolares', 'eliminar'))
          <button class="btn btn-danger btn-sm eliminarAdicionalBtn">Eliminar</button>
        @endif

            </td>
          </tr>
      @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- ======================= PAQUETES ======================= -->
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <h4>Paquetes</h4>
        @if(tienePermiso('Gestión de recorridos escolares', 'insertar'))
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPaquete">
        Nuevo Paquete
      </button>
    @endif

      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Precio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tablaPaquetes">
            @foreach ($paquetes as $p)
          <tr data-id="{{ $p['cod_paquete'] }}">
            <td>{{ $p['nombre'] }}</td>
            <td>{{ $p['descripcion'] }}</td>
            <td>{{ $p['precio'] }}</td>
            <td>
            @if(tienePermiso('Gestión de recorridos escolares', 'actualizar'))
          <button class="btn btn-warning btn-sm editarPaqueteBtn">Editar</button>
        @endif

            @if(tienePermiso('Gestión de recorridos escolares', 'eliminar'))
          <button class="btn btn-danger btn-sm eliminarPaqueteBtn">Eliminar</button>
        @endif

            </td>
          </tr>
      @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- ======================= ENTRADAS ======================= -->
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <h4>Entradas</h4>
        @if(tienePermiso('Gestión de productos', 'insertar'))
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEntrada">
        Nueva Entrada
      </button>
    @endif

      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Precio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tablaEntradas">
            @foreach ($entradas as $e)
          <tr data-id="{{ $e['cod_entrada'] }}">
            <td>{{ $e['nombre'] }}</td>
            <td>{{ $e['precio'] }}</td>
            <td>
            @if(tienePermiso('Gestión de productos', 'actualizar'))
          <button class="btn btn-warning btn-sm editarEntradaBtn">Editar</button>
        @endif

            @if(tienePermiso('Gestión de productos', 'eliminar'))
          <button class="btn btn-danger btn-sm eliminarEntradaBtn">Eliminar</button>
        @endif

            </td>
          </tr>
      @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- ======================= MODAL ADICIONAL ======================= -->
  <div class="modal fade" id="modalAdicional" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nuevo/Editar Adicional</h5>
        </div>
        <div class="modal-body">
          <form id="formAdicional">
            <input type="hidden" id="cod_adicional">
            <div class="mb-3">
              <label>Nombre:</label>
              <input type="text" id="nombre_adicional" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Descripción:</label>
              <textarea id="descripcion_adicional" class="form-control"></textarea>
            </div>
            <div class="mb-3">
              <label>Precio:</label>
              <input type="number" id="precio_adicional" class="form-control" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="guardarAdicional" class="btn btn-success">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================= MODAL PAQUETE ======================= -->
  <div class="modal fade" id="modalPaquete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nuevo/Editar Paquete</h5>
        </div>
        <div class="modal-body">
          <form id="formPaquete">
            <input type="hidden" id="cod_paquete">
            <div class="mb-3">
              <label>Nombre:</label>
              <input type="text" id="nombre_paquete" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Descripción:</label>
              <textarea id="descripcion_paquete" class="form-control"></textarea>
            </div>
            <div class="mb-3">
              <label>Precio:</label>
              <input type="number" id="precio_paquete" class="form-control" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="guardarPaquete" class="btn btn-success">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================= MODAL ENTRADA ======================= -->
  <div class="modal fade" id="modalEntrada" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nueva/Editar Entrada</h5>
        </div>
        <div class="modal-body">
          <form id="formEntrada">
            <input type="hidden" id="cod_entrada">
            <div class="mb-3">
              <label>Nombre:</label>
              <input type="text" id="nombre_entrada" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Precio:</label>
              <input type="number" id="precio_entrada" class="form-control" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="guardarEntrada" class="btn btn-success">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="/js/complementos.js"></script>

</body>

</html>