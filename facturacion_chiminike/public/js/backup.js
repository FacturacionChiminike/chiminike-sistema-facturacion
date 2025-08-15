document.addEventListener('DOMContentLoaded', () => {
    const crearBackupBtn = document.getElementById('btnCrearBackup');
    const formRestaurar = document.getElementById('formRestaurarBackup');

    if (crearBackupBtn) {
        crearBackupBtn.addEventListener('click', () => {
            Swal.fire({
                title: '¿Crear nuevo backup?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, crear',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch('/backup/crear', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf()
                        }
                    }).then(() => {
                        Swal.fire('Backup creado', '', 'success')
                        .then(() => location.reload());
                    }).catch(() => {
                        Swal.fire('Error al crear backup', '', 'error');
                    });
                }
            });
        });
    }

    if (formRestaurar) {
        formRestaurar.addEventListener('submit', e => {
            e.preventDefault();
            const formData = new FormData(formRestaurar);

            Swal.fire({
                title: '¿Restaurar backup?',
                text: 'Esto reemplazará los datos actuales',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Restaurar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch('/backup/restaurar', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf()
                        },
                        body: formData
                    }).then(() => {
                        Swal.fire('Backup restaurado', '', 'success')
                        .then(() => location.reload());
                    }).catch(() => {
                        Swal.fire('Error al restaurar backup', '', 'error');
                    });
                }
            });
        });
    }

    function csrf() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }
});
