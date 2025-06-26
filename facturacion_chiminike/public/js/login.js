document.addEventListener('DOMContentLoaded', () => {
    // Elementos del DOM
    const formLogin = document.getElementById('loginForm');
    const formRecuperar = document.getElementById('form-recuperar');
    const linkMostrarRecuperar = document.getElementById('mostrar-recuperar');
    const linkVolverLogin = document.getElementById('volver-login');
    const usuarioInput = document.getElementById('usuario');
    const contrasenaInput = document.getElementById('contrasena');
    const correoInput = document.getElementById('correo');

    // Efectos de transición entre formularios
    function toggleForms(showRecover) {
        if (showRecover) {
            formLogin.classList.add('form-transition', 'opacity-0', 'd-none');
            formRecuperar.classList.remove('d-none');
            setTimeout(() => {
                formRecuperar.classList.add('form-transition', 'opacity-100');
                correoInput.focus();
            }, 10);
        } else {
            formRecuperar.classList.remove('form-transition', 'opacity-100');
            formLogin.classList.remove('d-none');
            setTimeout(() => {
                formLogin.classList.add('form-transition', 'opacity-100');
                usuarioInput.focus();
            }, 10);
        }
    }

    // Validación mejorada del login
    formLogin.addEventListener('submit', function(e) {
        const usuario = usuarioInput.value.trim();
        const contrasena = contrasenaInput.value.trim();
        let isValid = true;

        // Reset estilos de error
        usuarioInput.classList.remove('is-invalid');
        contrasenaInput.classList.remove('is-invalid');

        if (usuario === '') {
            usuarioInput.classList.add('is-invalid');
            isValid = false;
        }

        if (contrasena === '') {
            contrasenaInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor complete todos los campos requeridos',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    });

    // Validación del formulario de recuperación
    formRecuperar.addEventListener('submit', function(e) {
        const correo = correoInput.value.trim();
        let isValid = true;

        // Reset estilo de error
        correoInput.classList.remove('is-invalid');

        if (correo === '' || !correo.includes('@')) {
            correoInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Correo inválido',
                text: 'Por favor ingrese una dirección de correo válida',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    });

    // Cambiar entre login y recuperar con transiciones
    linkMostrarRecuperar.addEventListener('click', function(e) {
        e.preventDefault();
        toggleForms(true);
    });

    linkVolverLogin.addEventListener('click', function(e) {
        e.preventDefault();
        toggleForms(false);
    });

    // Mostrar mensajes de éxito o error (enviados desde Blade)
    const status = document.body.dataset.status;
    const error = document.body.dataset.error;

    if (status) {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: status,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#f8f9fa',
            backdrop: `
                rgba(0,0,0,0.4)
                left top
                no-repeat
            `
        });
    }

    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error,
            confirmButtonColor: '#28a745',
            background: '#f8f9fa'
        });
    }

    // Focus al primer campo al cambiar de formulario
    usuarioInput.focus();
});