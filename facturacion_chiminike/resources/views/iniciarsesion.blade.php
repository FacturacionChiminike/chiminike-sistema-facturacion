<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - chiminike</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #0056B3;
            /* Azul ProFuturo */
            --color-secondary: #00A859;
            /* Verde */
            --color-accent: #FF6B35;
            /* Naranja para contrastes */
            --color-dark: #2E2E2E;
            --color-light: #FFFFFF;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #41c532 0%, #F1F0EA 100%);
            background-image:
                radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 80% 90%, rgba(217, 39, 46, 0.1) 0%, transparent 20%);
            background-size: 200% 200%;
            animation: gradientShift 10s ease-in-out infinite alternate;

            background-size: 200% 200%;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 0%;
            }

            100% {
                background-position: 100% 100%;
            }
        }

        .login-container {
            max-width: 420px;
            margin: 2% auto;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 18px;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.08),
                0 5px 10px rgba(0, 86, 179, 0.05);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow:
                0 15px 30px rgba(0, 0, 0, 0.12),
                0 8px 15px rgba(0, 86, 179, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 2.5rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .logo-img {
            max-width: 280px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.02);
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e6ed;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(0, 86, 179, 0.2);
        }

        .input-group-text {
            background-color: #f8fafc;
            border-right: none;
        }

        .btn-login {
            background: linear-gradient(to right, var(--color-primary), #0077CC);
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
            transition: all 0.4s;
            box-shadow: 0 4px 6px rgba(0, 86, 179, 0.2);
        }

        .btn-login:hover {
            background: linear-gradient(to right, #004499, #0066BB);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 86, 179, 0.3);
        }

        .social-btn {
            transition: all 0.3s;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .social-btn:hover {
            transform: scale(1.1) translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: #666;
            font-size: 0.9rem;
            position: relative;
        }

        .footer-text::before {
            content: "";
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 1px;
            background: linear-gradient(to right, transparent, #ddd, transparent);
        }

        /* Efecto de partículas decorativas (opcional) */
        .particle {
            position: absolute;
            background: rgba(0, 86, 179, 0.1);
            border-radius: 50%;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <!-- Partículas decorativas (opcional) -->
    <div id="particles"></div>

    <div class="container">
        <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="login-container">
                <!-- Logo -->
                <div class="logo">
                    <img src="{{ asset('img/manologochiminike.jpeg') }}" alt="Logo chiminike" class="logo-img">
                </div>

                <!-- Mensajes -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Formulario -->
                <form method="POST" action="">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label fw-medium text-dark">Correo electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="usuario@ejemplo.com" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-medium text-dark">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="••••••••" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label text-muted" for="remember">Recordar sesión</label>
                        </div>
                        <a href="" class="text-decoration-none" style="color: var(--color-primary);">¿Olvidaste tu
                            contraseña?</a>
                    </div>

                    <button type="submit" class="btn btn-login btn-primary w-100 mb-4 py-2">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar sesión
                    </button>

                    <div class="divider">
                        <span class="divider-text">o continúa con</span>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mb-4">
                        <button type="button" class="btn btn-outline-primary rounded-circle social-btn">
                            <i class="fab fa-google"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary rounded-circle social-btn">
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary rounded-circle social-btn">
                            <i class="fab fa-microsoft"></i>
                        </button>
                    </div>

                    <div class="footer-text">
                        ¿No tienes cuenta? <a href="" class="text-primary text-decoration-none fw-medium">Regístrate
                            aquí</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        // Toggle password
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Partículas decorativas (opcional)
        function createParticles() {
            const container = document.getElementById('particles') || document.body;
            const particleCount = 30;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Tamaño y posición aleatorios
                const size = Math.random() * 10 + 5;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const delay = Math.random() * 5;
                const duration = Math.random() * 15 + 10;

                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;
                particle.style.opacity = Math.random() * 0.4 + 0.1;
                particle.style.animation = `float ${duration}s ease-in-out ${delay}s infinite alternate`;

                container.appendChild(particle);
            }
        }

        // Iniciar partículas al cargar la página
        window.addEventListener('load', createParticles);
    </script>
</body>

</html>