<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Colores personalizados */
        .card-custom {
            background-color: #006633; /* Fondo verde */
            color: white;
        }

        .card-header-custom {
            background-color: #D9272E; /* Rojo encabezado */
            color: white;
        }

        .btn-custom {
            background-color: #D9272E; /* Rojo botón */
            border: none;
            color: white;
        }

        .btn-custom:hover {
            background-color: #b71c23;
        }

        /* Mensajes visuales */
        .msg-error {
            color: #D9272E !important;
            background-color: rgba(217, 39, 46, 0.1);
            display: inline-block;
            padding: 4px 8px;
            border-radius: 5px;
            margin-top: 4px;
        }

        .msg-success {
            color: #fff !important;
            background-color: #006633;
            display: inline-block;
            padding: 4px 8px;
            border-radius: 5px;
            margin-top: 4px;
        }
    </style>
</head>

<body class="bg-light d-flex align-items-center" style="height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 card-custom">
                    <div class="card-header card-header-custom text-center fw-bold">
                        Restablecer Contraseña
                    </div>

                    <div class="card-body">
                        <form id="form-resetear">
                            @csrf
                            <input type="hidden" id="token" value="{{ $token }}">

                            <!-- Campo nueva contraseña -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Nueva contraseña</label>
                                <input type="password" class="form-control" id="password" required>
                                <small id="passwordHelp" class="form-text text-light">
                                    Debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.
                                </small>
                            </div>

                            <!-- Campo confirmar contraseña -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation" required>
                                <small id="confirmHelp" class="form-text text-light"></small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom" id="btn-submit" disabled>
                                    Actualizar Contraseña
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-center text-light">
                        &copy; {{ date('Y') }} Chiminike
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/resetear.js') }}"></script>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordHelp = document.getElementById('passwordHelp');
        const confirmInput = document.getElementById('password_confirmation');
        const confirmHelp = document.getElementById('confirmHelp');
        const submitBtn = document.getElementById('btn-submit');

        function validarFormulario() {
            const passValida = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/.test(passwordInput.value);
            const coincide = confirmInput.value === passwordInput.value && confirmInput.value !== "";
            submitBtn.disabled = !(passValida && coincide);
        }

        passwordInput.addEventListener('input', () => {
            const value = passwordInput.value;
            const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/;

            if (regex.test(value)) {
                passwordHelp.textContent = "✅ Contraseña válida";
                passwordHelp.className = "form-text msg-success";
            } else {
                passwordHelp.textContent = "❌ Debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.";
                passwordHelp.className = "form-text msg-error";
            }
            validarFormulario();
        });

        confirmInput.addEventListener('input', () => {
            if (confirmInput.value === passwordInput.value && confirmInput.value !== "") {
                confirmHelp.textContent = "✅ Las contraseñas coinciden";
                confirmHelp.className = "form-text msg-success";
            } else {
                confirmHelp.textContent = "❌ Las contraseñas no coinciden";
                confirmHelp.className = "form-text msg-error";
            }
            validarFormulario();
        });
    </script>

</body>
</html>
