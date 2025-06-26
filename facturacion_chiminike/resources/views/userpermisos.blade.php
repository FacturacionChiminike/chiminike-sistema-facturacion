<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Permisos - Fundación Chiminike</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/userpermisos.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary-gradient">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 text-white"><i class="fas fa-user-shield me-2"></i>Gestión de Permisos de Usuario</h2>
                    <button class="btn btn-light btn-sm" id="btn-export">
                        <i class="fas fa-file-export me-1"></i> Exportar
                    </button>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="search-input" placeholder="Buscar usuario...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success" id="btn-refresh">
                                    <i class="fas fa-sync-alt me-1"></i> Actualizar
                                </button>
                                <button type="button" class="btn btn-info" id="btn-help" data-bs-toggle="modal" data-bs-target="#helpModal">
                                    <i class="fas fa-question-circle me-1"></i> Ayuda
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="tabla-permisos">
                        <thead class="thead-permisos"></thead>
                        <tbody class="tbody-permisos"></tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <div class="legend-container">
                            <span class="legend-title me-2">Leyenda:</span>
                            <span class="badge bg-c me-2"><i class="fas fa-plus"></i> Crear</span>
                            <span class="badge bg-r me-2"><i class="fas fa-eye"></i> Leer</span>
                            <span class="badge bg-u me-2"><i class="fas fa-edit"></i> Actualizar</span>
                            <span class="badge bg-d me-2"><i class="fas fa-trash"></i> Eliminar</span>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <span class="text-muted">Mostrando <span id="user-count">0</span> usuarios</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Ayuda -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="helpModalLabel"><i class="fas fa-question-circle me-2"></i>Ayuda</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6><i class="fas fa-info-circle text-primary me-2"></i>Instrucciones:</h6>
                    <ul>
                        <li>Esta tabla muestra los permisos de cada usuario en el sistema.</li>
                        <li>Los permisos están representados por casillas de verificación (habilitados/deshabilitados).</li>
                        <li>Use la barra de búsqueda para filtrar usuarios por nombre.</li>
                    </ul>
                    <h6><i class="fas fa-key text-warning me-2"></i>Permisos:</h6>
                    <ul>
                        <li><strong>C</strong> - Crear nuevos registros</li>
                        <li><strong>R</strong> - Leer/Ver registros</li>
                        <li><strong>U</strong> - Actualizar registros</li>
                        <li><strong>D</strong> - Eliminar registros</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JS personalizado -->
    <script src="{{ asset('js/userpermiso.js') }}"></script>
</body>
</html>