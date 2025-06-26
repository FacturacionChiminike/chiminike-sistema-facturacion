<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Primer Ingreso - Actualizar Contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Estilo personalizado -->
    <link href="{{ asset('css/oneinicio.css') }}" rel="stylesheet">
</head>
<body>

    <div class="oneinicio-container">
        <div class="oneinicio-card">
            <div class="oneinicio-header">
                <div class="oneinicio-header-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="oneinicio-header-text">
                    <h1>Actualización de Seguridad</h1>
                    <p>Por favor, establezca una nueva contraseña segura</p>
                </div>
            </div>

            <div class="oneinicio-body">
                <form method="POST" action="{{ route('actualizar.password') }}" class="oneinicio-form" id="oneinicioForm">
                    @csrf
                    <input type="hidden" name="cod_usuario" value="{{ session('usuario.cod_usuario') }}">

                    <div class="oneinicio-form-group">
                        <label for="nueva_contrasena">
                            <i class="fas fa-key"></i> Nueva Contraseña
                        </label>
                        <div class="oneinicio-input-group">
                            <input type="password" name="nueva_contrasena" id="nueva_contrasena"
                                   class="oneinicio-form-control" required minlength="8"
                                   placeholder="Mínimo 8 caracteres">
                            <button class="oneinicio-toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="oneinicio-help-text">
                            La contraseña debe contener al menos 8 caracteres, incluyendo mayúsculas, minúsculas y números.
                        </div>
                    </div>

                    <div class="oneinicio-form-group">
                        <label for="confirmar_contrasena">
                            <i class="fas fa-check-circle"></i> Confirmar Contraseña
                        </label>
                        <div class="oneinicio-input-group">
                            <input type="password" name="confirmar_contrasena" id="confirmar_contrasena"
                                   class="oneinicio-form-control" required minlength="8"
                                   placeholder="Repita su nueva contraseña">
                            <button class="oneinicio-toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="oneinicio-form-actions">
                        <button type="submit" class="oneinicio-submit-btn">
                            <i class="fas fa-save"></i> Guardar Nueva Contraseña
                        </button>
                    </div>
                </form>
            </div>

            <div class="oneinicio-footer">
                <p>
                    <i class="fas fa-info-circle"></i>
                    Por su seguridad, no comparta su contraseña con nadie.
                </p>
            </div>
        </div>
    </div>

    <!-- JS personalizado -->
    <script src="{{ asset('js/oneinicio.js') }}"></script>

    <script>
        // SweetAlert2: mostrar mensajes si existen
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Contraseña actualizada!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#28a745'
            }).then(() => {
                window.location.href = '{{ route('login') }}';
            });
        @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc3545'
            });
        @endif
    </script>

</body>
</html>
