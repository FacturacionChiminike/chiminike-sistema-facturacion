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
                    <div class="notifications">
                        <i class="bi bi-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="user-menu">
                        <img src="https://via.placeholder.com/40" alt="User" class="user-img">
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                @yield('content')

                <div class="dashboard-default">
                    <div class="welcome-card">
                        <h2>Bienvenido, {{ Auth::user()->nombre_usuario ?? 'Usuario' }}</h2>
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
                                <h3>12</h3>
                                <p>Eventos hoy</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: #36b9cc;">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="stat-info">
                                <h3>$24,500</h3>
                                <p>Ventas hoy</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: #f6c23e;">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="stat-info">
                                <h3>78</h3>
                                <p>Productos</p>
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


        </div>
    </div>

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



</body>

</html>