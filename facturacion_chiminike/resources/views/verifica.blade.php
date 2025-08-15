<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Verificación 2FA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/verifica.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow rounded-4">
                    <div class="card-header bg-success text-white text-center rounded-top-4">
                        <h4>Verificación en dos pasos</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('verificar.codigo') }}">
                            @csrf
                            <input type="hidden" name="cod_usuario" value="{{ $cod_usuario }}">

                            <div class="mb-3">
                                <label for="codigo" class="form-label">Código de verificación</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" maxlength="6" required
                                    autofocus oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>


                            <button type="submit" class="btn btn-success w-100">Verificar</button>
                        </form>

                        <div class="mt-3 text-center">
                            <small class="text-muted">El código expira en 5 minutos</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/verificar.js') }}"></script>





</body>

</html>

