<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Chiminike - Dividido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #006633;
            /* Verde principal */
            --secondary-color: #00A859;
            /* Verde más claro */
            --accent-color: #FFC72C;
            /* Amarillo para acentos */
            --light-bg: #F8F9FA;
            /* Fondo claro */
            --dark-text: #343A40;
            /* Texto oscuro */
            --soft-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --image-margin: 15px;
            /* Margen más pequeño para imágenes */
            --border-radius: 12px;
            /* Bordes más suaves */
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
            /* Fondo transparente */
            backdrop-filter: blur(12px);
            /* Efecto vidrio */
            border: 1px solid rgba(255, 255, 255, 0.2);
            /* Borde sutil */
            padding: 2.5rem;
            border-radius: var(--border-radius);
            width: 85%;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            z-index: 1;
            color: white;
            /* Texto blanco */
        }

        .login-form .form-control {
            background: rgba(255, 255, 255, 0.2);
            /* Inputs transparentes */
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            /* Texto blanco */
        }

        .login-form .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
            /* Placeholder claro */
        }

        .login-form .text-muted,
        .login-form .form-check-label,
        .login-form a {
            color: rgba(255, 255, 255, 0.9) !important;
            /* Textos claros */
        }

        .login-form .text-success {
            color: var(--accent-color) !important;
            /* Título en amarillo */
        }

        /* Efecto hover para inputs */
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
            /* Semi-transparente con el color principal */
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
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Lado izquierdo: Login -->
        <div class="left-side">
            {{-- FORMULARIO LOGIN --}}
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
                    <span id="togglePassword" class="position-absolute top-50 end-0 translate-middle-y me-3"
                        style="cursor: pointer;">
                        <i class="fas fa-eye-slash text-muted"></i>
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

            {{-- FORMULARIO RECUPERACIÓN --}}
            <form method="POST" action="{{ route('password.email') }}" id="form-recuperar" class="d-none mt-3">
                @csrf

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" id="correo" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-warning">Enviar enlace</button>
                </div>

                <div class="text-center mt-2">
                    <a href="#" id="volver-login" class="text-decoration-none text-muted">
                        ← Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>

        <!-- Script para alternar contraseña y formularios -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const loginForm = document.getElementById('loginForm');
                const formRecuperar = document.getElementById('form-recuperar');

                document.getElementById('mostrar-recuperar').addEventListener('click', (e) => {
                    e.preventDefault();
                    loginForm.classList.add('d-none');
                    formRecuperar.classList.remove('d-none');
                });

                document.getElementById('volver-login').addEventListener('click', (e) => {
                    e.preventDefault();
                    formRecuperar.classList.add('d-none');
                    loginForm.classList.remove('d-none');
                });

                const togglePassword = document.getElementById('togglePassword');
                const passwordInput = document.getElementById('contrasena');
                const icon = togglePassword.querySelector('i');

                togglePassword.addEventListener('click', () => {
                    const tipo = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = tipo;

                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            });
        </script>



        <!-- Lado derecho: Carrusel -->
        <div class="right-side">
            <div id="carouselExampleIndicators" class="carousel slide h-100" data-bs-ride="carousel">
                <div class="carousel-inner h-100">
                    <div class="carousel-item active h-100">
                        <img src="/img/foto1carrusel.jpg" class="d-block w-100" alt="Imagen 1" />
                        <div class="carousel-caption">
                            Bienvenido a Chiminike. Un espacio para el aprendizaje y la creatividad.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/foto2carrusel.jpg" class="d-block w-100" alt="Imagen 2" />
                        <div class="carousel-caption">
                            Explorá, descubrí, aprendé.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/foto3carrusel.jpg" class="d-block w-100" alt="Imagen 3" />
                        <div class="carousel-caption">
                            Una experiencia para toda la familia.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/foto4carrusel.jpg" class="d-block w-100" alt="Imagen 4" />
                        <div class="carousel-caption">
                            Educación con alegría y propósito.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/foto5carrusel.jpg" class="d-block w-100" alt="Imagen 5" />
                        <div class="carousel-caption">
                            Ciencia, arte y cultura para crecer.
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="/img/foto6carrusel.jpg" class="d-block w-100" alt="Imagen 6" />
                        <div class="carousel-caption">
                            ¡Te esperamos en Chiminike!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>