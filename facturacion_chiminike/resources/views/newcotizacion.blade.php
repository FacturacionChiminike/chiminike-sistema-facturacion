<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Cotización - Museo Chiminike</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/newcotizacion.css') }}">
</head>

<body class="bg-light">

   
    <div class="container py-5">
        {{-- Alertas de éxito o error --}}
        <div class="mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Regresar al Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-lg overflow-hidden mx-auto" style="max-width: 1200px;">
            <!-- Encabezado con logo y título -->
            <div class="card-header bg-gradient-primary text-white py-4">
                <div class="d-flex align-items-center">

                    <div>
                        <h4 class="mb-1"><i class="fas fa-file-invoice-dollar me-2"></i>Nueva Cotización</h4>
                        <small class="opacity-85">Complete todos los campos requeridos (*)</small>
                    </div>
                </div>
            </div>

            <form id="cotizacionForm">
                @csrf
                <div class="card-body p-4 position-relative">
                    <!-- Spinner de carga -->
                    <div id="loadingSpinner" class="loading-overlay">
                        <div class="spinner-container">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-3 fs-5 fw-semibold">Procesando su cotización...</p>
                        </div>
                    </div>

                    <!-- Contenido del formulario -->
                    <div id="formContent">
                        <!-- Sección de información del cliente -->
                        <div class="mb-5">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-primary me-3">
                                    <i class="fas fa-user-tie text-white"></i>
                                </div>
                                <h5 class="mb-0">Información del Cliente</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            placeholder="Nombre Completo" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                            title="Solo letras y espacios"
                                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')">
                                        <label for="nombre">Nombre Completo *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="tipo_cliente" name="tipo_cliente" required>
                                            <option value="" selected disabled>Seleccione tipo...</option>
                                            <option value="Individual">Individual</option>
                                            <option value="Empresa">Empresa</option>
                                        </select>
                                        <label for="tipo_cliente">Tipo de Cliente *</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="dni" name="dni"
                                            placeholder="DNI/Identidad" required pattern="\d+" inputmode="numeric"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            title="Solo números">
                                        <label for="dni">DNI/Identidad *</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="rtn" name="rtn" placeholder="RTN"
                                            pattern="\d*" inputmode="numeric"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            title="Solo números">
                                        <label for="rtn">RTN (opcional)</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="sexo" name="sexo" required>
                                            <option value="" selected disabled>Seleccione sexo...</option>
                                            <option value="masculino">Masculino</option>
                                            <option value="femenino">Femenino</option>
                                        </select>
                                        <label for="sexo">Sexo *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="fecha_nacimiento"
                                            name="fecha_nacimiento" placeholder="Fecha Nacimiento" required>
                                        <label for="fecha_nacimiento">Fecha Nacimiento *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="telefono" name="telefono"
                                            placeholder="Teléfono" required pattern="\d{8}" maxlength="8"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            title="Debe contener 8 dígitos">
                                        <label for="telefono">Teléfono *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="correo" name="correo"
                                            placeholder="Correo Electrónico" required
                                            pattern="^[a-zA-Z0-9]+([._-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                            title="Ingrese un correo válido sin símbolos especiales raros.">
                                        <label for="correo">Correo Electrónico *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="cod_municipio" name="cod_municipio" required>
                                            <option value="" selected disabled>Seleccione municipio...</option>
                                            <option value="1">Tegucigalpa</option>
                                            <option value="2">San Pedro Sula</option>
                                            <option value="3">La Ceiba</option>
                                            <option value="4">Comayagua</option>
                                        </select>
                                        <label for="cod_municipio">Municipio *</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="direccion" name="direccion"
                                            placeholder="Dirección" style="height: 80px" required></textarea>
                                        <label for="direccion">Dirección *</label>
                                    </div>
                                </div>
                            </div>


                            <!-- Sección de información del evento -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-calendar-check text-white"></i>
                                    </div>
                                    <h5 class="mb-0">Información del Evento</h5>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="evento_nombre"
                                                name="evento_nombre" placeholder="Nombre del Evento" required
                                                pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s.,-]+"
                                                title="Solo letras, números y signos básicos (.,-) permitidos"
                                                oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s.,-]/g, '')">
                                            <label for="evento_nombre">Nombre del Evento *</label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="fecha_evento"
                                                name="fecha_evento" placeholder="Fecha" required>
                                            <label for="fecha_evento">Fecha *</label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="time" class="form-control" id="hora_evento" name="hora_evento"
                                                placeholder="Hora" required>
                                            <label for="hora_evento">Hora *</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección de productos/servicios -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-box-open text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Productos/Servicios</h5>
                                        <small class="text-muted">Agregue los items para cotizar</small>
                                    </div>
                                </div>

                                <div id="productosContainer">
                                    <div class="product-item card mb-3" data-index="0">
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-5">
                                                    <div class="form-floating">
                                                        <select class="form-select" name="productos[0][id]" required>
                                                            <option value="" selected disabled>Seleccione producto...
                                                            </option>
                                                            <option value="1">Entrada General - Adulto</option>
                                                            <option value="2">Entrada General - Niño</option>
                                                            <option value="3">Tour Guiado</option>
                                                            <option value="4">Paquete Familiar</option>
                                                            <option value="5">Alquiler de Espacio</option>
                                                        </select>
                                                        <label>Producto/Servicio *</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control"
                                                            name="productos[0][cantidad]" min="1" value="1" required>
                                                        <label>Cantidad *</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="productos[0][precio]" min="0" required>
                                                        <label>Precio Unitario *</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-center">
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm remove-product"
                                                        style="display: none;">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="productos[0][notas]"
                                                            placeholder="Notas" style="height: 80px"></textarea>
                                                        <label>Notas (opcional)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="addProductBtn" class="btn btn-outline-primary w-100 py-2">
                                    <i class="fas fa-plus-circle me-2"></i>Agregar Producto
                                </button>
                            </div>

                            <!-- Resumen y confirmación -->
                            <div class="mt-5 pt-3 border-top">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="confirmacion" required>
                                            <label class="form-check-label" for="confirmacion">
                                                Confirmo que la información proporcionada es correcta y acepto los
                                                términos
                                                *
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light border-primary">
                                            <div class="card-body py-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold text-dark">Total Estimado:</span>
                                                    <span class="fs-4 fw-bold text-primary" id="totalEstimado">L.
                                                        0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pie de página con botones -->
                    <div class="card-footer bg-light py-3 d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-secondary px-4 py-2">
                            <i class="fas fa-eraser me-2"></i> Limpiar
                        </button>
                        <button type="button" class="btn btn-primary px-4 py-2" id="btnEnviarCotizacion">
                            <i class="fas fa-paper-plane me-2"></i> Enviar Cotización
                        </button>
                    </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/newcotizacion.js') }}"></script>
</body>

</html>