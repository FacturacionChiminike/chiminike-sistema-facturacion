<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Gestión</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
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
                    @php
                        $menu = menuItems();
                    @endphp

                    @foreach($menu as $grupo => $item)
                        <li class="mb-2">
                            @if(isset($item['submenus']))
                                <a class="d-flex justify-content-between align-items-center text-decoration-none"
                                    data-bs-toggle="collapse" href="#submenu-{{ Str::slug($grupo) }}" role="button"
                                    aria-expanded="false">
                                    <div><i class="{{ $item['icono'] }} me-2"></i> {{ $grupo }}</div>
                                    <i class="bi bi-chevron-down"></i>
                                </a>
                                <div class="collapse submenu ps-3" id="submenu-{{ Str::slug($grupo) }}">
                                    <ul class="list-unstyled mt-2">
                                        @foreach($item['submenus'] as $subnombre => $subitem)
                                            <li>
                                                <a href="{{ $subitem['ruta'] }}" class="menu-item text-decoration-none">
                                                    <i class="{{ $subitem['icono'] }} me-2"></i> {{ $subnombre }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="{{ $item['ruta'] }}" class="menu-item text-decoration-none">
                                    <i class="{{ $item['icono'] }} me-2"></i> {{ $grupo }}
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
            <header class="main-header">
                <div class="header-left">
                    <button class="sidebar-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="page-title" id="dynamicTitle">Dashboard</h4>
                </div>
                <div class="header-right">

                    <div class="user-menu">
                        <button class="btn btn-link p-0 border-0 fs-3 text-dark" onclick="mostrarPerfilUsuario()"
                            title="Ver perfil">
                            <i class="bi bi-person-circle"></i>
                        </button>
                    </div>



                </div>
            </header>

            <div class="content-wrapper">
                @yield('content')

                <div class="dashboard-default">
                    @php $usuario = session('usuario'); @endphp
                    <div class="welcome-card">
                        <h2>Bienvenido, {{ $usuario['nombre_usuario'] ?? 'Usuario' }}</h2>
                        <p>Seleccione una opción del menú para comenzar</p>
                    </div>


                    <div class="stats-cards">
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: #4e73df;">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $resumen['total_empleados'] }}</h3>
                                <p>Empleados</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: #1cc88a;">
                                <i class="bi bi-person-vcard-fill"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $resumen['total_clientes'] }}</h3>
                                <p>Clientes</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: #1cc88a;">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $dashboard['reservaciones_mes_actual'] }}</h3>
                                <p>Reservaciones del mes actual</p>
                            </div>

                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: #36b9cc;">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="stat-info">
                                <h3>L {{ number_format($dashboard['total_generado'], 2) }}</h3>
                                <p>Total generado (cotizaciones completadas)</p>
                            </div>

                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: #f6c23e;">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $dashboard['cliente_frecuente'] }}</h3>
                                <p>Cliente más frecuente</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header fw-bold text-primary">
                    Distribución general del sistema
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div style="width: 600px; height: 400px;">
                        <canvas id="graficoResumen"></canvas>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header fw-bold text-success">
                    Resumen de cotizaciones y eventos
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div style="width: 600px; height: 400px;">
                        <canvas id="graficoCotizaciones"></canvas>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <!-- Modal Perfil de Usuario -->
    <!-- Modal Perfil de Usuario -->
    <div class="modal fade" id="modalPerfilUsuario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-badge me-2"></i> PERFIL DE USUARIO</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light p-4 d-flex flex-column align-items-center">
                            <div class="avatar-profile mb-3">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <h5 class="text-center mb-1 fw-bold" id="perfil-nombre">...</h5>
                            <span class="badge bg-primary mb-3" id="perfil-cargo">...</span>
                            <div class="w-100">
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Estado:</span>
                                    <span class="fw-bold" id="perfil-estado">...</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Tipo Usuario:</span>
                                    <span class="fw-bold" id="perfil-tipo-usuario">...</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Departamento:</span>
                                    <span class="fw-bold" id="perfil-departamento">...</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 p-4">
                            <h6 class="fw-bold text-uppercase text-primary mb-3">Información Personal</h6>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">DNI</label>
                                    <div class="form-control bg-light border-0" id="perfil-dni">...</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Edad</label>
                                    <div class="form-control bg-light border-0" id="perfil-edad">...</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Teléfono</label>
                                    <div class="form-control bg-light border-0" id="perfil-telefono">...</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Correo</label>
                                    <div class="form-control bg-light border-0 text-truncate" id="perfil-correo">...
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold text-uppercase text-primary mb-3">Información Laboral</h6>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Usuario</label>
                                    <div class="form-control bg-light border-0" id="perfil-usuario">...</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Contraseña</label>
                                    <div class="form-control bg-light border-0" id="perfil-contrasena">••••••••</div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Salario</label>
                                    <div class="form-control bg-light border-0">L. <span id="perfil-salario">...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cerrar
                    </button>
                  
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos personalizados para el modal de perfil */
        #modalPerfilUsuario .modal-content {
            border-radius: 10px;
            overflow: hidden;
        }

        #modalPerfilUsuario .bg-gradient-primary {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
        }

        #modalPerfilUsuario .avatar-profile {
            width: 100px;
            height: 100px;
            background-color: #e9f2ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #3a7bd5;
            border: 3px solid #3a7bd5;
        }

        #modalPerfilUsuario .form-control {
            padding: 0.5rem 1rem;
            min-height: 38px;
            border-radius: 6px;
            box-shadow: none;
        }

        #modalPerfilUsuario .modal-body h6 {
            letter-spacing: 1px;
            font-size: 0.8rem;
        }

        #modalPerfilUsuario .modal-footer {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        #modalPerfilUsuario .btn {
            border-radius: 6px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }

        #modalPerfilUsuario .btn-outline-secondary {
            border: 1px solid #dee2e6;
        }

        #modalPerfilUsuario .btn-outline-secondary:hover {
            background-color: #f8f9fa;
        }
    </style>

    <script>
        function mostrarPerfilUsuario() {
            // Obtiene automáticamente el nombre_usuario de la sesión de Laravel
            const usuario = "{{ $usuario['nombre_usuario'] ?? '' }}";

            if (!usuario) {
                Swal.fire("Error", "No se encontró el usuario en la sesión.", "error");
                return;
            }


            fetch(`http://68.168.222.45:3000/empleado.detalle/${usuario}`)

                .then(res => {
                    if (!res.ok) throw new Error("Error al obtener los datos");
                    return res.json();
                })
                .then(data => {
                    Swal.close();

                    // Llena los campos del modal
                    document.getElementById("perfil-nombre").innerText = data.nombre_persona ?? "---";
                    document.getElementById("perfil-dni").innerText = data.dni ?? "---";
                    document.getElementById("perfil-telefono").innerText = data.telefono ?? "---";
                    document.getElementById("perfil-correo").innerText = data.correo ?? "---";
                    document.getElementById("perfil-edad").innerText = data.edad ?? "---";
                    document.getElementById("perfil-usuario").innerText = data.nombre_usuario ?? "---";
                    document.getElementById("perfil-contrasena").innerText = data.contrasena ?? "*******";
                    document.getElementById("perfil-estado").innerText = data.estado ?? "---";
                    document.getElementById("perfil-tipo-usuario").innerText = data.tipo_usuario ?? "---";
                    document.getElementById("perfil-cargo").innerText = data.cargo ?? "---";
                    document.getElementById("perfil-salario").innerText = parseFloat(data.salario ?? 0).toFixed(2);
                    document.getElementById("perfil-departamento").innerText = data.departamento_empresa ?? "---";

                    // Abre el modal de perfil
                    const modal = new bootstrap.Modal(document.getElementById("modalPerfilUsuario"));
                    modal.show();
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire("Error", "No se pudo cargar la información del perfil.", "error");
                });
        }
    </script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.sidebar-toggle').addEventListener('click', function () {
            document.querySelector('.dashboard-container').classList.toggle('sidebar-collapsed');
        });

        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function () {
                document.getElementById('dynamicTitle').textContent = this.querySelector('span')?.textContent ?? '';
            });
        });

        setInterval(() => {
            fetch("{{ route('check.session') }}")
                .then(res => res.json())
                .then(data => {
                    if (!data.activa) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
        }, 60000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        const ctx = document.getElementById('graficoResumen').getContext('2d');

        const graficoResumen = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Personas registradas',
                    'Empleados activos',
                    'Empleados inactivos',
                    'Clientes'
                ],
                datasets: [{
                    label: 'Cantidad',
                    data: [
                    {{ $resumen['total_personas'] }},
                    {{ $resumen['empleados_activos'] }},
                    {{ $resumen['empleados_inactivos'] }},
                        {{ $resumen['total_clientes'] }}
                    ],
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#e74a3b',
                        '#f6c23e'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#000',
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>

    <script>
        const ctxCotizaciones = document.getElementById('graficoCotizaciones').getContext('2d');

        const graficoCotizaciones = new Chart(ctxCotizaciones, {
            type: 'bar',
            data: {
                labels: [
                    'Cotizaciones pendientes',
                    'Reservaciones confirmadas',
                    'Eventos completados'
                ],
                datasets: [{
                    label: 'Cantidad',
                    data: [
                    {{ $dashboard['total_cotizaciones'] }},
                    {{ $dashboard['total_reservaciones'] }},
                        {{ $dashboard['total_eventos'] }}
                    ],
                    backgroundColor: [
                        '#36b9cc',  // Cotizaciones pendientes
                        '#f6c23e',  // Reservaciones confirmadas
                        '#1cc88a'   // Eventos completados
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#000',
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>