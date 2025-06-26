document.addEventListener('DOMContentLoaded', function () {
    // Toggle password visibility
    const togglePasswordButtons = document.querySelectorAll('.oneinicio-toggle-password');

    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function () {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Form validation + envío con fetch
    const form = document.getElementById('oneinicioForm');

    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const nuevaContrasena = document.getElementById('nueva_contrasena');
            const confirmarContrasena = document.getElementById('confirmar_contrasena');
            const codUsuario = document.querySelector('input[name="cod_usuario"]').value;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            let isValid = true;

            confirmarContrasena.setCustomValidity('');

            if (nuevaContrasena.value !== confirmarContrasena.value) {
                confirmarContrasena.setCustomValidity('Las contraseñas no coinciden');
                isValid = false;
            }

            if (nuevaContrasena.value.length < 8) {
                nuevaContrasena.setCustomValidity('La contraseña debe tener al menos 8 caracteres');
                isValid = false;
            }

            if (!isValid) {
                confirmarContrasena.reportValidity();
                nuevaContrasena.reportValidity();
                return;
            }

            // Enviar datos con fetch (POST JSON)
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    cod_usuario: codUsuario,
                    nueva_contrasena: nuevaContrasena.value,
                    confirmar_contrasena: confirmarContrasena.value
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Contraseña actualizada',
                            text: 'Serás redirigido al login...',
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/login';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.mensaje || 'No se pudo actualizar la contraseña'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error del servidor',
                        text: 'Intenta más tarde'
                    });
                });
        });
    }

    // Validación en tiempo real
    const confirmarContrasena = document.getElementById('confirmar_contrasena');
    if (confirmarContrasena) {
        confirmarContrasena.addEventListener('input', function () {
            const nuevaContrasena = document.getElementById('nueva_contrasena');

            if (this.value !== nuevaContrasena.value) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});
