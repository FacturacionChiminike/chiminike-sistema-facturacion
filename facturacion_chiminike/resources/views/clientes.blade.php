<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Fundación Chiminike</title>
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
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0"><i class="bi bi-people-fill me-2"></i> Lista de Clientes - Chiminike</h2>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Regresar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        @if(tienePermiso('Gestión de clientes', 'insertar'))
                            <a href="#" class="btn btn-success me-2" id="btnNuevoCliente">
                                <i class="bi bi-plus-circle me-1"></i> Nuevo Cliente
                            </a>
                        @endif

                        <div class="btn-group">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-file-earmark-arrow-down me-1"></i> Exportar
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#" id="exportarExcel"><i
                                            class="bi bi-file-excel text-success me-2"></i> Excel</a></li>
                                <li><a class="dropdown-item" href="#" id="exportarPDF"><i
                                            class="bi bi-file-pdf text-danger me-2"></i> PDF</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>DNI</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Municipio</th>
                                    <th>Departamento</th>
                                    <th>RTN</th>
                                    <th>Tipo Cliente</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente['cod_cliente'] }}</td>
                                        <td>{{ $cliente['nombre'] }}</td>
                                        <td>{{ $cliente['dni'] }}</td>
                                        <td>{{ $cliente['correo'] }}</td>
                                        <td>{{ $cliente['telefono'] }}</td>
                                        <td>{{ $cliente['direccion'] }}</td>
                                        <td>{{ $cliente['municipio'] }}</td>
                                        <td>{{ $cliente['departamento'] }}</td>
                                        <td>{{ $cliente['rtn'] }}</td>
                                        <td>{{ $cliente['tipo_cliente'] }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if(tienePermiso('Gestión de clientes', 'actualizar'))
                                                    <button class="btn btn-warning btn-sm btn-editar-cliente"
                                                        data-id="{{ $cliente['cod_cliente'] }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                @endif

                                                @if(tienePermiso('Gestión de clientes', 'eliminar'))
                                                    <button class="btn btn-danger btn-sm btn-eliminar-cliente"
                                                        data-id="{{ $cliente['cod_cliente'] }}">
                                                        <i class="bi bi-trash"></i>
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

    <!-- Modal de Edición de Cliente   -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formEditarCliente" class="modal-content">
                @csrf
                <input type="hidden" id="id_cliente">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditarClienteLabel">Editar Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre_persona" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre_persona" name="nombre_persona" required
                                maxlength="100" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                                title="Solo se permiten letras y espacios, máximo 100 caracteres.">
                        </div>


                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                required>
                        </div>

                        <div class="col-md-4">
                            <label for="sexo" class="form-label">Sexo</label>
                            <select class="form-select" id="sexo" name="sexo" required>
                                <option value="">Seleccione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" required inputmode="numeric"
                                maxlength="13" pattern="^08\d{11}$" placeholder="08XXXXXXXXXXX"
                                title="Debe iniciar con 08 y tener exactamente 13 dígitos numéricos.">
                        </div>


                        <div class="col-md-4">
                            <label for="rtn" class="form-label">RTN</label>
                            <input type="text" class="form-control" id="rtn" name="rtn" required inputmode="numeric"
                                maxlength="14" pattern="^08\d{12}$" placeholder="08XXXXXXXXXXXX"
                                title="El RTN debe iniciar con 08 y tener exactamente 14 dígitos numéricos.">
                        </div>


                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" required maxlength="100"
                                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                title="Ingresa un correo válido sin caracteres especiales raros, máximo 100 caracteres.">
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required
                                inputmode="numeric" maxlength="8" pattern="^[1-9]\d{7}$" placeholder="Ej. 98765432"
                                title="Debe ingresar exactamente 8 dígitos numéricos y no iniciar con 0.">
                        </div>

                        <div class="col-md-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required
                                maxlength="100" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]+$"
                                placeholder="Ej. Barrio El Centro 123"
                                title="Solo se permiten letras, números y espacios. Máximo 100 caracteres.">
                        </div>


                        <div class="col-md-6">
                            <label for="cod_municipio_edit" class="form-label">Municipio</label>
                            <select class="form-select" id="cod_municipio_edit" name="cod_municipio" required>
                                <option value="">Seleccione</option>
                                @foreach($municipios as $municipio)
                                    <option value="{{ $municipio['cod_municipio'] }}">
                                        {{ $municipio['municipio'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6">
                            <label for="tipo_cliente" class="form-label">Tipo Cliente</label>
                            <select class="form-select" id="tipo_cliente" name="tipo_cliente" required>
                                <option value="">Seleccione</option>
                                <option value="Individual">Individual</option>
                                <option value="Empresa">Empresa</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Guardar Cambios
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Nuevo   Cliente -->
    <div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-labelledby="modalNuevoClienteLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formNuevoCliente" class="modal-content">
                @csrf

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalNuevoClienteLabel">
                        <i class="bi bi-person-plus me-2"></i> Registrar Nuevo Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre_persona" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre_persona" name="nombre_persona" required
                                maxlength="100" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                                title="Solo se permiten letras y espacios.">
                            <div class="invalid-feedback">
                                Ingrese un nombre válido (solo letras y espacios).
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                required>
                            <div class="invalid-feedback">
                                Debe ser mayor de 18 años.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="sexo" class="form-label">Sexo</label>
                            <select class="form-select" id="sexo" name="sexo" required>
                                <option value="">Seleccione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" required maxlength="13"
                                pattern="^08\d{11}$" title="Debe iniciar con 08 y tener 13 dígitos"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,13)">
                            <div class="invalid-feedback">
                                El DNI debe iniciar con 08 y tener exactamente 13 dígitos.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="rtn" class="form-label">RTN</label>
                            <input type="text" class="form-control" id="rtn" name="rtn" required maxlength="14"
                                pattern="^08\d{12}$" title="Debe iniciar con 08 y tener 14 dígitos"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,14)">
                            <div class="invalid-feedback">
                                El RTN debe iniciar con 08 y tener exactamente 14 dígitos.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" required maxlength="100"
                                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$"
                                title="Debe ser un correo válido, sin caracteres especiales no permitidos (máximo 100 caracteres)"
                                oninput="this.value = this.value.replace(/[^a-zA-Z0-9@._+-]/g, '').slice(0,100)">
                            <div class="invalid-feedback">
                                Ingrese un correo válido (máximo 100 caracteres, sin caracteres especiales no
                                permitidos).
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required maxlength="8"
                                pattern="^(?!0)(?!([0-9])\1{7})[0-9]{8}$"
                                title="Debe tener 8 dígitos, no iniciar con 0 ni repetir el mismo número"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,8)">
                            <div class="invalid-feedback">
                                Ingrese un número válido: 8 dígitos, no iniciar con 0 ni repetir el mismo número.
                            </div>
                        </div>


                        <div class="col-md-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required
                                minlength="5" maxlength="150" title="La dirección debe tener entre 5 y 150 caracteres"
                                oninput="this.value = this.value.slice(0,150)">
                            <div class="invalid-feedback">
                                Ingrese una dirección válida (mínimo 5 y máximo 150 caracteres).
                            </div>
                        </div>


                        <div class="col-md-6">
                            <label for="cod_municipio" class="form-label">Municipio</label>
                            <select class="form-select" id="cod_municipio" name="cod_municipio" required>
                                <option value="">Seleccione</option>
                                @foreach($municipios as $municipio)
                                    <option value="{{ $municipio['cod_municipio'] }}">
                                        {{ $municipio['municipio'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="tipo_cliente" class="form-label">Tipo Cliente</label>
                            <select class="form-select" id="tipo_cliente" name="tipo_cliente" required>
                                <option value="">Seleccione</option>
                                <option value="Individual">Individual</option>
                                <option value="Empresa">Empresa</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS personalizado -->
    <script src="{{ asset('js/clientes.js') }}"></script>

    <script>
        const dni = document.getElementById('dni');
        dni.addEventListener('input', (e) => {
            // Elimina caracteres no numéricos y corta a 13 dígitos
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 13);

            // Validación personalizada
            if (!e.target.value.startsWith('08')) {
                e.target.setCustomValidity('El DNI debe comenzar con 08.');
            } else if (e.target.value.length !== 13) {
                e.target.setCustomValidity('El DNI debe tener exactamente 13 dígitos.');
            } else {
                e.target.setCustomValidity('');
            }
        });
    </script>
    
    <script>
        const rtn = document.getElementById('rtn');
        rtn.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 14);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const correo = document.getElementById('correo');

            if (!correo) return;

            correo.addEventListener('input', (e) => {
                const original = e.target.value;
                const limpio = original.replace(/[^a-zA-Z0-9@._+-]/g, '');

                if (original !== limpio) {
                    console.warn('Caracteres no permitidos eliminados:', original);
                }

                e.target.value = limpio.slice(0, 100);
            });
        });
    </script>





</body>

</html>