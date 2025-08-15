<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Primer Ingreso - Actualizar Contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="cod-usuario" content="{{ session('usuario.cod_usuario') }}">

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
                    <p>Establezca una nueva contraseña y seleccione sus preguntas de recuperación</p>
                </div>
            </div>

            <div class="oneinicio-body">
                <form method="POST" action="{{ route('actualizar.password') }}" class="oneinicio-form"
                    id="oneinicioForm">
                    @csrf
                    <input type="hidden" name="cod_usuario" value="{{ session('usuario.cod_usuario') }}">

                    <!-- NUEVA CONTRASEÑA -->
                    <div class="oneinicio-form-group">
                        <label for="nueva_contrasena"><i class="fas fa-key"></i> Nueva Contraseña</label>
                        <div class="oneinicio-input-group">
                            <input type="password" name="nueva_contrasena" id="nueva_contrasena"
                                class="oneinicio-form-control" required minlength="8" placeholder="Mínimo 8 caracteres">
                            <button class="oneinicio-toggle-password" type="button"><i class="fas fa-eye"></i></button>
                        </div>
                        <div class="oneinicio-help-text">Debe incluir mayúsculas, minúsculas y números.</div>
                    </div>

                    <!-- CONFIRMAR CONTRASEÑA -->
                    <div class="oneinicio-form-group">
                        <label for="confirmar_contrasena"><i class="fas fa-check-circle"></i> Confirmar
                            Contraseña</label>
                        <div class="oneinicio-input-group">
                            <input type="password" name="confirmar_contrasena" id="confirmar_contrasena"
                                class="oneinicio-form-control" required minlength="8"
                                placeholder="Repita su nueva contraseña">
                            <button class="oneinicio-toggle-password" type="button"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>

                    <!-- PREGUNTA 1 -->
                    <div class="oneinicio-form-group">
                        <label for="cod_pregunta1"><i class="fas fa-question-circle"></i> Pregunta de recuperación
                            1</label>
                        <select name="cod_pregunta1" id="cod_pregunta1" class="oneinicio-form-control" required>
                            <option value="">Seleccione una pregunta</option>
                            @foreach($preguntas as $pregunta)
                                <option value="{{ $pregunta['cod_pregunta'] }}">{{ $pregunta['pregunta'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="oneinicio-form-group">
                        <label for="respuesta1"><i class="fas fa-reply"></i> Respuesta a la pregunta 1</label>
                        <input type="text" name="respuesta1" id="respuesta1" class="oneinicio-form-control" required
                            placeholder="Escriba su respuesta">
                    </div>

                    <!-- PREGUNTA 2 -->
                    <div class="oneinicio-form-group">
                        <label for="cod_pregunta2"><i class="fas fa-question-circle"></i> Pregunta de recuperación
                            2</label>
                        <select name="cod_pregunta2" id="cod_pregunta2" class="oneinicio-form-control" required>
                            <option value="">Seleccione una pregunta diferente</option>
                            @foreach($preguntas as $pregunta)
                                <option value="{{ $pregunta['cod_pregunta'] }}">{{ $pregunta['pregunta'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="oneinicio-form-group">
                        <label for="respuesta2"><i class="fas fa-reply"></i> Respuesta a la pregunta 2</label>
                        <input type="text" name="respuesta2" id="respuesta2" class="oneinicio-form-control" required
                            placeholder="Escriba su respuesta">
                    </div>

                    <div class="oneinicio-form-actions">
                        <button type="submit" class="oneinicio-submit-btn">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>

            <div class="oneinicio-footer">
                <p><i class="fas fa-info-circle"></i> Por su seguridad, no comparta sus credenciales con nadie.</p>
            </div>
        </div>
    </div>

    <!-- JS personalizado -->
    <script src="{{ asset('js/oneinicio.js') }}"></script>

   

</body>

</html>