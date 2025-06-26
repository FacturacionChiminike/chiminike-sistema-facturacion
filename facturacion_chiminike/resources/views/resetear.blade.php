<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-warning text-white text-center fw-bold">
                        Restablecer Contraseña
                    </div>

                    <div class="card-body">

                        <form id="form-resetear">
                            @csrf
                            <input type="hidden" id="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label for="password" class="form-label">Nueva contraseña</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">Actualizar Contraseña</button>
                            </div>
                        </form>

                    </div>

                    <div class="card-footer text-center text-muted">
                        &copy; {{ date('Y') }} Chiminike
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 y script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/resetear.js') }}"></script>

</body>

</html>
