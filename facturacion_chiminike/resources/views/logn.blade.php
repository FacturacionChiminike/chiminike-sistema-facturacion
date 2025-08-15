<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Chiminike - Dividido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <style>
        :root {
            --primary-color: #006633;
            --secondary-color: #00A859;
            --accent-color: #FFC72C;
            --light-bg: #F8F9FA;
            --dark-text: #343A40;
            --soft-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --image-margin: 15px;
            --border-radius: 12px;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
        }

        .container-fluid {
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .left-side {
            flex: 0 0 40%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .left-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/img/ranitalogin.jpg') center/cover;
            opacity: 0.15;
        }

        .login-form {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            width: 85%;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            z-index: 1;
            color: white;
        }

        .login-form .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .login-form .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .login-form .text-muted,
        .login-form .form-check-label,
        .login-form a {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .login-form .text-success {
            color: var(--accent-color) !important;
        }

        .login-form .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: white;
        }

        .login-form:hover {
            transform: translateY(-5px);
        }

        .right-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: var(--light-bg);
        }

        .carousel-item img {
            width: calc(100% - 2 * var(--image-margin));
            height: calc(100% - 2 * var(--image-margin));
            object-fit: cover;
            border-radius: var(--border-radius);
            margin: var(--image-margin);
            box-shadow: var(--soft-shadow);
            transition: transform 0.3s ease;
        }

        .carousel-item:hover img {
            transform: scale(1.01);
        }

        .carousel-caption {
            background: rgba(0, 104, 55, 0.85);
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 500;
            text-align: center;
            border-radius: var(--border-radius);
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            backdrop-filter: blur(5px);
        }

        .logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: var(--soft-shadow);
        }

        .btn-success {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 168, 89, 0.3);
        }

        .form-control {
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 168, 89, 0.25);
        }

        .text-success {
            color: var(--primary-color) !important;
        }

        @media (max-width: 768px) {
            .container-fluid {
                flex-direction: column;
            }

            .left-side,
            .right-side {
                flex: 1 1 50%;
                width: 100%;
                height: 50vh;
            }

            .login-form {
                width: 90%;
                padding: 1.5rem;
            }

            :root {
                --image-margin: 10px;
            }
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255, 255, 255, 0.85);
            /* si el fondo es oscuro */
            z-index: 10;
        }
    </style>
</head>

<body data-status="{{ session('status') }}" data-error="{{ session('error') }}">
    <div class="container-fluid">
        <!-- Lado izquierdo: Login -->
        <div class="left-side">
            <!-- FORMULARIO LOGIN PRINCIPAL -->
            <form class="login-form" id="loginForm" method="POST" action="{{ route('login.enviar') }}">
                @csrf
                <div class="text-center mb-4">
                    <img src="/img/chiminike_logo.png" class="rounded-circle logo" alt="Logo Chiminike" />
                    <h4 class="fw-bold mt-3 text-success">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Facturación Chiminike
                    </h4>
                    <p class="text-muted">Sistema interno</p>
                </div>

                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required />
                </div>

                <div class="mb-3 position-relative">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control pe-5" id="contrasena" name="contrasena" required />
                    <span id="togglePassword" class="toggle-password">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" />
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>

                <button type="submit" class="btn btn-success w-100">Iniciar sesión</button>

                <div class="text-center mt-3">
                    <a href="#" id="mostrar-recuperar" class="text-decoration-none text-success">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </form>

            <!-- SELECTOR DE RECUPERACIÓN -->
            <div id="recuperar-selector" class="login-form d-none">
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-success">Recuperar contraseña</h4>
                    <p class="text-muted">Selecciona un método de recuperación</p>
                </div>

                <div class="text-center">
                    <h5 class="mb-3">¿Cómo deseas recuperar tu contraseña?</h5>
                    <button id="btn-recuperar-correo" class="btn btn-primary mb-2 w-100">Por Correo</button>
                    <button id="btn-recuperar-preguntas" class="btn btn-success mb-2 w-100">Con Preguntas de
                        Seguridad</button>
                    <div class="text-center mt-2">
                        <a href="#" id="volver-login" class="text-decoration-none text-muted">
                            ← Volver al inicio de sesión
                        </a>
                    </div>
                </div>
            </div>

            <!-- FORMULARIO RECUPERACIÓN POR CORREO -->
            <form method="POST" action="{{ route('password.email') }}" id="form-recuperar-correo"
                class="login-form d-none">
                @csrf
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-success">Recuperar por correo</h4>
                    <p class="text-muted">Ingresa tu correo electrónico</p>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" id="correo" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-warning">Enviar enlace</button>
                </div>
                <div class="text-center mt-2">
                    <a href="#" id="volver-selector" class="text-decoration-none text-muted">
                        ← Volver a opciones de recuperación
                    </a>
                </div>
            </form>

            <!-- FORMULARIO PARA INGRESAR USUARIO Y CONSULTAR PREGUNTAS -->
            <form method="POST" id="form-preguntas-usuario" class="login-form d-none">
                @csrf
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-success">Preguntas de seguridad</h4>
                    <p class="text-muted">Ingresa tu nombre de usuario</p>
                </div>

                <div class="mb-3">
                    <label for="usuario-preguntas" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" name="usuario" id="usuario-preguntas" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Validar usuario</button>
                </div>
                <div class="text-center mt-2">
                    <a href="#" id="volver-selector-preguntas" class="text-decoration-none text-muted">
                        ← Volver a opciones de recuperación
                    </a>
                </div>
            </form>
        </div>

        <!-- Lado derecho: Carrusel -->
      <div class="right-side">
            <div id="carouselExampleIndicators" class="carousel slide h-100" data-bs-ride="carousel">
                <div class="carousel-inner h-100">
                    <div class="carousel-item active h-100">
                        <img src="/img/nueva4.jpg" class="d-block w-100" alt="Imagen 1" />
                        <div class="carousel-caption">
                            Bienvenido a un mundo de descubrimiento, Entra, explora y vive la experiencia Chiminike.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/nueva3.jpg" class="d-block w-100" alt="Imagen 2" />
                        <div class="carousel-caption">
                            Donde la cultura cobra vida, Una experiencia para aprender, explorar y sentir nuestras
                            raíces.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/nueva2.jpg" class="d-block w-100" alt="Imagen 3" />
                        <div class="carousel-caption">
                            Aprender jugando, La ciencia y la diversión se encuentran en cada rincón.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/nueva1.jpg" class="d-block w-100" alt="Imagen 4" />
                        <div class="carousel-caption">
                            Un recorrido educativo y divertido para toda la familia.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/nueva5.jpg" class="d-block w-100" alt="Imagen 5" />
                        <div class="carousel-caption">
                            Diversión que inspira Ciencia, arte y cultura para crecer.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/nueva6.jpg" class="d-block w-100" alt="Imagen 6" />
                        <div class="carousel-caption">
                            Escala, explora y conquista, Un espacio para que la imaginación y la aventura se eleven
                            hasta lo más alto.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA RESPONDER PREGUNTAS -->
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

                    <div class="modal-body" id="preguntas-container">
                        <!-- Aquí se insertan las preguntas con inputs por JS -->
                    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Referencias a los formularios
        const loginForm = document.getElementById('loginForm');
        const recuperarSelector = document.getElementById('recuperar-selector');
        const formRecuperarCorreo = document.getElementById('form-recuperar-correo');
        const formPreguntasUsuario = document.getElementById('form-preguntas-usuario');

        // Toggle de contraseña
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('contrasena');
        const icon = togglePassword.querySelector('i');

        document.getElementById('volver-selector').addEventListener('click', (e) => {
            e.preventDefault();
            formRecuperarCorreo.classList.add('d-none');
            recuperarSelector.classList.remove('d-none');
        });

        document.getElementById('volver-selector-preguntas').addEventListener('click', (e) => {
            e.preventDefault();
            formPreguntasUsuario.classList.add('d-none');
            recuperarSelector.classList.remove('d-none');

        });
        // Volver al login desde selector
        document.getElementById('volver-login').addEventListener('click', (e) => {
            e.preventDefault();
            recuperarSelector.classList.add('d-none');
            formRecuperarCorreo.classList.add('d-none');
            formPreguntasUsuario.classList.add('d-none');
            loginForm.classList.remove('d-none');
        });

        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('contrasena');
            const icon = this.querySelector('i');
            const tipo = input.type === 'password' ? 'text' : 'password';
            input.type = tipo;
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const errorMsg = document.body.getAttribute("data-error");
            const statusMsg = document.body.getAttribute("data-status");

            if (errorMsg) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: errorMsg,
                    confirmButtonText: 'OK'
                });
            }

            if (statusMsg) {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: statusMsg,
                    toast: true,
                    position: "top-end",
                    timer: 3000,
                    showConfirmButton: false,
                });
            }
        });

        setTimeout(() => {
    Swal.fire({
        icon: 'info',
        title: 'SweetAlert2 está activo 🎉',
        text: 'Esta es una alerta de prueba',
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false,
    });
}, 2000);

    </script>

    <script src="https://unpkg.com/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>

    

</body>

</html>