<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados - Sistema de Gestión</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="{{ asset('css/cai.css') }}" rel="stylesheet">
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
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0"><i class="bi bi-people-fill me-2"></i> Gestión de Empleados</h2>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Regresar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                        <div class="input-group search-container" style="max-width: 400px;">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control" id="busquedaEmpleado"
                                placeholder="Buscar empleado...">
                            <button class="btn btn-outline-secondary" type="button" id="btn-limpiar">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="btnFiltroEmpleado" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-funnel me-1"></i> Filtros
                                </button>
                                <div class="dropdown-menu dropdown-menu-end p-3 shadow" style="min-width: 250px;">
                                    <div class="mb-3">
                                        <label for="filtroRol" class="form-label">Rol</label>
                                        <select class="form-select" id="filtroRol">
                                            <option value="">Todos</option>
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol['nombre'] }}">{{ $rol['nombre'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="filtroDepartamento" class="form-label">Departamento</label>
                                        <select class="form-select" id="filtroDepartamento">
                                            <option value="">Todos</option>
                                            @foreach ($departamentos as $dep)
                                                <option value="{{ $dep['nombre'] }}">{{ $dep['nombre'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="filtroEstado" class="form-label">Estado</label>
                                        <select class="form-select" id="filtroEstado">
                                            <option value="">Todos</option>
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary flex-grow-1" id="btnAplicarFiltros">
                                            <i class="bi bi-check-circle me-1"></i> Aplicar
                                        </button>
                                        <button id="btnLimpiarFiltros" class="btn btn-outline-danger">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="dropdownExportar" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-download me-1"></i> Exportar
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownExportar">
                                    <li><a class="dropdown-item" href="#" id="btnExportarExcel"><i
                                                class="bi bi-file-earmark-excel text-success me-2"></i>Excel</a></li>
                                    <li><a class="dropdown-item" href="#" id="btnExportarPDF"><i
                                                class="bi bi-file-earmark-pdf text-danger me-2"></i>PDF</a></li>
                                </ul>
                            </div>

                            @if(tienePermiso('Gestión de empleados', 'insertar'))
                                <button class="btn btn-primary" id="btnNuevoEmpleado">
                                    <i class="bi bi-person-plus me-1"></i> Nuevo
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tablaEmpleados">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nombre</th>
                                    <th>Contacto</th>
                                    <th>Cargo y Rol</th>
                                    <th>Departamento</th>
                                    <th>Fecha Contratación</th>
                                    <th class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($empleados as $emp)
                                    <tr class="{{ $emp['estado'] == 0 ? 'table-danger' : '' }}">
                                        <input type="hidden" class="data-empleado" data-empleado='@json($emp)'>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar me-3 {{ $emp['estado'] == 0 ? 'bg-danger bg-opacity-10 text-danger' : 'bg-primary bg-opacity-10 text-primary' }}">
                                                    {{ substr($emp['nombre'], 0, 1) }}
                                                </div>
                                                <div>
                                                    <strong class="d-block">{{ $emp['nombre'] }}</strong>
                                                    <small class="text-muted">{{ $emp['tipo_usuario'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;">
                                                <i class="bi bi-envelope me-1 text-muted"></i>{{ $emp['correo'] }}
                                            </div>
                                            <div><i class="bi bi-telephone me-1 text-muted"></i>{{ $emp['telefono'] }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $emp['cargo'] }}</div>
                                            <small class="text-muted">{{ $emp['rol'] }}</small>
                                        </td>
                                        <td>{{ $emp['departamento_empresa'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($emp['fecha_contratacion'])->format('d/m/Y') }}</td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                @if(tienePermiso('Gestión de empleados', 'mostrar'))
                                                    <button class="btn btn-sm btn-outline-primary btn-detalles"
                                                        data-id="{{ $emp['cod_empleado'] }}" title="Detalles">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                @endif

                                                @if(tienePermiso('Gestión de empleados', 'actualizar'))
                                                    <button class="btn btn-sm btn-outline-warning btn-editar"
                                                        data-id="{{ $emp['cod_empleado'] }}" title="Editar">
                                                        <i class="bi bi-pencil"></i>
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

    <!-- Modal Detalles -->
    <div class="modal fade" id="modalEmpleado" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-person-lines-fill me-2"></i>Detalles del Empleado</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="contenidoEmpleado">
                    <!-- Contenido dinámico -->
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo Empleado -->
    <div class="modal fade" id="modalNuevoEmpleado" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Nuevo Empleado</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="formNuevoEmpleado" novalidate>
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nuevo_nombre_persona" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nuevo_nombre_persona" name="nombre_persona"
                                    required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" maxlength="50"
                                    title="Solo letras y espacios"
                                    oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')">
                                <div class="invalid-feedback">Por favor ingrese un nombre válido (solo letras).
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="nuevo_fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="nuevo_fecha_nacimiento"
                                    name="fecha_nacimiento" required>
                                <div class="invalid-feedback">Seleccione una fecha válida.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="nuevo_sexo" class="form-label">Sexo</label>
                                <select class="form-select" id="nuevo_sexo" name="sexo" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>

                                </select>
                                <div class="invalid-feedback">Seleccione el sexo.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="nuevo_dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="nuevo_dni" name="dni" required pattern="\d+"
                                    title="Solo números" inputmode="numeric" maxlength="13"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <div class="invalid-feedback">Ingrese un DNI válido (solo números).</div>
                            </div>

                            <div class="col-md-6">
                                <label for="nuevo_correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="nuevo_correo" name="correo" required
                                    pattern="[a-zA-Z0-9._+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" maxlength="100"
                                    title="Solo letras, números, puntos, guiones. Nada de caracteres raros como /(){}[]">
                                <div class="invalid-feedback">Correo inválido. No uses símbolos raros.</div>

                            </div>

                            <div class="col-md-6">
                                <label for="nuevo_telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="nuevo_telefono" name="telefono" required
                                    pattern="\d{8}" title="Debe tener 8 dígitos" maxlength="8"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <div class="invalid-feedback">Ingrese un número de teléfono de 8 dígitos.</div>
                            </div>

                            <div class="col-12">
                                <label for="nuevo_direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="nuevo_direccion" name="direccion" required
                                    maxlength="150" minlength="5">

                                <div class="invalid-feedback">Ingrese la dirección.</div>
                            </div>

                            <div class="col-md-4">
                                <label for="nuevo_cod_municipio" class="form-label">Municipio</label>
                                <select class="form-select" id="nuevo_cod_municipio" name="cod_municipio" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($municipios as $municipio)
                                        <option value="{{ $municipio['cod_municipio'] }}">{{ $municipio['municipio'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione el municipio.</div>
                            </div>


                            <div class="col-md-4">
                                <label for="nuevo_cod_departamento_empresa" class="form-label">Departamento
                                    Empresa</label>
                                <select class="form-select" id="nuevo_cod_departamento_empresa"
                                    name="cod_departamento_empresa" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($departamentos as $dep)
                                        <option value="{{ $dep['cod_departamento_empresa'] }}">{{ $dep['nombre'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione un departamento.</div>
                            </div>


                            <div class="col-md-4">
                                <label for="nuevo_cod_rol" class="form-label">Rol</label>
                                <select class="form-select" id="nuevo_cod_rol" name="cod_rol" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol['cod_rol'] }}">{{ $rol['nombre'] }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione un rol.</div>
                            </div>


                            <div class="col-md-6">
                                <label for="nuevo_cod_tipo_usuario" class="form-label">Tipo Usuario</label>
                                <select class="form-select" id="nuevo_cod_tipo_usuario" name="cod_tipo_usuario"
                                    required>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($tiposUsuario as $tipo)
                                        <option value="{{ $tipo['cod_tipo_usuario'] }}">{{ $tipo['nombre'] }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione un tipo de usuario.</div>
                            </div>


                            <div class="col-md-6">
                                <label for="nuevo_cargo" class="form-label">Cargo</label>
                                <input type="text" class="form-control" id="nuevo_cargo" name="cargo" required
                                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" maxlength="50" minlength="2"
                                    title="Solo letras y espacios"
                                    oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')">
                                <div class="invalid-feedback">Ingrese un cargo válido.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="nuevo_fecha_contratacion" class="form-label">Fecha Contratación</label>
                                <input type="date" class="form-control" id="nuevo_fecha_contratacion"
                                    name="fecha_contratacion" required>
                                <div class="invalid-feedback">Seleccione una fecha válida.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="nuevo_salario" class="form-label">Salario (L.)</label>
                                <input type="number" step="0.01" min="0.01" max="9999999.99" class="form-control"
                                    id="nuevo_salario" name="salario" required
                                    oninput="if(this.value.length > 10) this.value = this.value.slice(0,10);"
                                    title="Ingrese un salario mayor a 0">
                                <div class="invalid-feedback">Ingrese un salario válido (mayor a L. 0.00).</div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="col-md-6 d-none">
                            <label for="nuevo_nombre_usuario" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="nuevo_nombre_usuario" name="nombre_usuario"
                                readonly>
                        </div>

                        <div class="col-md-6 d-none">
                            <label for="nuevo_contrasena" class="form-label">Contraseña</label>
                            <input type="text" class="form-control" id="nuevo_contrasena" name="contrasena" readonly>
                        </div>

                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Empleado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Empleado -->
    <div class="modal fade" id="modalEditarEmpleado" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar Empleado</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="formEditarEmpleado" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_cod_empleado" name="cod_empleado">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_nombre_persona" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="edit_nombre_persona" name="nombre_persona"
                                    required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Solo letras y espacios"
                                    oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')">
                                <div class="invalid-feedback">Ingrese un nombre válido (solo letras).</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="edit_fecha_nacimiento"
                                    name="fecha_nacimiento" required>
                                <div class="invalid-feedback">Seleccione una fecha válida.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_sexo" class="form-label">Sexo</label>
                                <select class="form-select" id="edit_sexo" name="sexo" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>

                                </select>
                                <div class="invalid-feedback">Seleccione el sexo.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="edit_dni" name="dni" required pattern="\d+"
                                    title="Solo números" inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <div class="invalid-feedback">Ingrese un DNI válido (solo números).</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="edit_correo" name="correo" required
                                    pattern="^[a-zA-Z0-9]+([._-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                    title="Ingrese un correo válido sin símbolos raros.">
                                <div class="invalid-feedback">Ingrese un correo electrónico válido.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="edit_telefono" name="telefono" required
                                    pattern="\d{8}" maxlength="8" title="Debe contener 8 dígitos"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <div class="invalid-feedback">Ingrese un teléfono válido (8 dígitos).</div>
                            </div>

                            <div class="col-md-12">
                                <label for="edit_direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="edit_direccion" name="direccion" required>
                                <div class="invalid-feedback">Ingrese la dirección.</div>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_cod_municipio" class="form-label">Municipio</label>
                                <select class="form-select" id="edit_cod_municipio" name="cod_municipio" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($municipios as $m)
                                        <option value="{{ $m['cod_municipio'] }}">{{ $m['municipio'] }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione el municipio.</div>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_cod_departamento_empresa" class="form-label">Departamento
                                    Empresa</label>
                                <select class="form-select" id="edit_cod_departamento_empresa"
                                    name="cod_departamento_empresa" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($departamentos as $dep)
                                        <option value="{{ $dep['cod_departamento_empresa'] }}">{{ $dep['nombre'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione el departamento.</div>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_cod_rol" class="form-label">Rol</label>
                                <select class="form-select" id="edit_cod_rol" name="cod_rol" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol['cod_rol'] }}">{{ $rol['nombre'] }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione un rol.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_cod_tipo_usuario" class="form-label">Tipo Usuario</label>
                                <select class="form-select" id="edit_cod_tipo_usuario" name="cod_tipo_usuario" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($tiposUsuario as $tipo)
                                        <option value="{{ $tipo['cod_tipo_usuario'] }}">{{ $tipo['nombre'] }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione el tipo de usuario.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_estado" class="form-label">Estado</label>
                                <select class="form-select" id="edit_estado" name="estado" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                <div class="invalid-feedback">Seleccione el estado.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_cargo" class="form-label">Cargo</label>
                                <input type="text" class="form-control" id="edit_cargo" name="cargo" required
                                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Solo letras y espacios"
                                    oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')">
                                <div class="invalid-feedback">Ingrese un cargo válido.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_fecha_contratacion" class="form-label">Fecha Contratación</label>
                                <input type="date" class="form-control" id="edit_fecha_contratacion"
                                    name="fecha_contratacion" required>
                                <div class="invalid-feedback">Seleccione una fecha válida.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_salario" class="form-label">Salario (L.)</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="edit_salario"
                                    name="salario" required>
                                <div class="invalid-feedback">Ingrese un salario válido.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/empleado.js') }}"></script>
</body>

</html>