document.addEventListener('DOMContentLoaded', () => {
    const success = document.body.dataset.success;
    const error = document.body.dataset.error;

    if (success) {
        Swal.fire({
            icon: 'success',
            title: '¡Código correcto!',
            text: success,
            confirmButtonColor: '#41c532',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "/dashboard";
        });
    }

    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Código inválido o expirado',
            text: error,
            confirmButtonColor: '#D9272E'
        });
    }
});

