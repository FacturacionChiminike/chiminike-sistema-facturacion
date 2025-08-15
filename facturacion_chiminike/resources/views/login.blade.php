<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body data-status="{{ session('status') }}" data-error="{{ session('error') }}">

    {{-- Fondo de imagen con filtros --}}
    <div class="bg-overlay"></div>

    {{-- Capa superior con login a la izquierda y mensaje institucional a la derecha --}}
    <div class="glass-overlay d-flex justify-content-between align-items-center px-5">

        {{-- LOGIN: lado izquierdo --}}
        <div class="login-card-container">
            <div class="card glassmorph border-0">
                <div class="card-header bg-success text-white text-center fw-bold">
                    Iniciar Sesión
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- FORMULARIO LOGIN --}}
                    <form method="POST" action="{{ route('login.enviar') }}" id="loginForm">
                        @csrf
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="contrasena" id="contrasena" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Entrar</button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#" id="mostrar-recuperar" class="text-decoration-none text-success">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    </form>

                    {{-- SELECTOR DE RECUPERACIÓN --}}
                    <div id="recuperar-selector" class="text-center d-none mt-3">
                        <h5 class="mb-3">¿Cómo deseas recuperar tu contraseña?</h5>
                        <button id="btn-recuperar-correo" class="btn btn-primary mb-2">Por Correo</button>
                        <button id="btn-recuperar-preguntas" class="btn btn-success mb-2">Con Preguntas de
                            Seguridad</button>
                        <div class="text-center mt-2">
                            <a href="#" id="volver-login" class="text-decoration-none text-muted">
                                ← Volver al inicio de sesión
                            </a>
                        </div>
                    </div>

                    {{-- FORMULARIO RECUPERACIÓN POR CORREO --}}
                    <form method="POST" action="{{ route('password.email') }}" id="form-recuperar-correo"
                        class="d-none mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="email" id="correo" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">Enviar enlace</button>
                        </div>
                    </form>

                    {{-- FORMULARIO PARA INGRESAR USUARIO Y CONSULTAR PREGUNTAS --}}
                    <form method="POST" id="form-preguntas-usuario" class="d-none mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="usuario-preguntas" class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" name="usuario" id="usuario-preguntas" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Validar usuario</button>
                        </div>
                    </form>
                </div>


                <div class="card-footer text-center text-muted">
                    &copy; {{ date('Y') }} Chiminike
                </div>
            </div>
        </div>

        {{-- MENSAJE INSTITUCIONAL: lado derecho --}}
        <div class="mensaje-institucional glassmorph text-white p-4 ms-4">
            <h4 class="fw-bold mb-3">✨ Bienvenido a Chiminike</h4>
            <p class="mb-2">🌱 Aquí fomentamos la curiosidad, el respeto y el aprendizaje a través del juego.</p>
            <p class="mb-2">🧠 Creemos en una educación inclusiva, divertida y con propósito.</p>
            <p class="mb-2">🎨 Cada rincón del museo es una oportunidad para soñar y descubrir.</p>
            <p class="mb-0"><em>“Aprender jugando es la forma más poderosa de crecer.”</em></p>
        </div>

    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>




    {{-- MODAL PARA RESPONDER PREGUNTAS  --}}
    <div class="modal fade" id="modalPreguntas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-responder-preguntas" method="POST">
                @csrf
                <input type="hidden" name="cod_usuario" id="modal-cod-usuario">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Responde las preguntas de seguridad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    {{-- Sección donde se inyectan las preguntas dinámicamente --}}
                    <div class="modal-body" id="preguntas-container">
                        <!-- Aquí se insertan las preguntas con inputs por JS -->
                    </div>

                    {{-- Sección que se muestra solo si las respuestas son válidas --}}
                    <div id="nueva-contrasena-section" class="modal-body d-none">
                        <div class="mb-3">
                            <label for="nueva-contrasena" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" id="nueva-contrasena" name="nueva_contrasena"
                                placeholder="Mínimo 8 caracteres">
                        </div>
                        <div class="mb-3">
                            <label for="confirmar-contrasena" class="form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="confirmar-contrasena"
                                name="confirmar_contrasena">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Validar respuestas</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (session('debug_response'))
        <script>
            console.log("🔍 RESPUESTA DEL BACKEND:");
            console.log({!! json_encode(session('debug_response')) !!});
        </script>
    @endif

</body>

</html>