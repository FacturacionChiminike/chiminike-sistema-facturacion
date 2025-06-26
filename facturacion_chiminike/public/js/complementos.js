document.addEventListener('DOMContentLoaded', () => {

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ========== ADICIONALES ==========

    document.getElementById('guardarAdicional').addEventListener('click', () => {
        const id = document.getElementById('cod_adicional').value;
        const nombre = document.getElementById('nombre_adicional').value;
        const descripcion = document.getElementById('descripcion_adicional').value;
        const precio = document.getElementById('precio_adicional').value;

        const data = { nombre, descripcion, precio };

        let url = '/complementos/adicionales';
        let method = 'POST';

        if (id) {
            url += `/${id}`;
            method = 'PUT';
        }

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            Swal.fire('Éxito', res.mensaje, 'success').then(() => location.reload());
        });
    });

    document.querySelectorAll('.editarAdicionalBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.closest('tr').dataset.id;
            fetch(`/complementos/adicionales/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cod_adicional').value = data.cod_adicional;
                    document.getElementById('nombre_adicional').value = data.nombre;
                    document.getElementById('descripcion_adicional').value = data.descripcion;
                    document.getElementById('precio_adicional').value = data.precio;
                    new bootstrap.Modal(document.getElementById('modalAdicional')).show();
                });
        });
    });

    document.querySelectorAll('.eliminarAdicionalBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.closest('tr').dataset.id;
            Swal.fire({
                title: '¿Eliminar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar'
            }).then(res => {
                if (res.isConfirmed) {
                    fetch(`/complementos/adicionales/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': token }
                    }).then(() => {
                        Swal.fire('Eliminado', '', 'success').then(() => location.reload());
                    });
                }
            });
        });
    });

    // ========== PAQUETES ==========

    document.getElementById('guardarPaquete').addEventListener('click', () => {
        const id = document.getElementById('cod_paquete').value;
        const nombre = document.getElementById('nombre_paquete').value;
        const descripcion = document.getElementById('descripcion_paquete').value;
        const precio = document.getElementById('precio_paquete').value;

        const data = { nombre, descripcion, precio };

        let url = '/complementos/paquetes';
        let method = 'POST';

        if (id) {
            url += `/${id}`;
            method = 'PUT';
        }

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            Swal.fire('Éxito', res.mensaje, 'success').then(() => location.reload());
        });
    });

    document.querySelectorAll('.editarPaqueteBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.closest('tr').dataset.id;
            fetch(`/complementos/paquetes/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cod_paquete').value = data.cod_paquete;
                    document.getElementById('nombre_paquete').value = data.nombre;
                    document.getElementById('descripcion_paquete').value = data.descripcion;
                    document.getElementById('precio_paquete').value = data.precio;
                    new bootstrap.Modal(document.getElementById('modalPaquete')).show();
                });
        });
    });

    document.querySelectorAll('.eliminarPaqueteBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.closest('tr').dataset.id;
            Swal.fire({
                title: '¿Eliminar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar'
            }).then(res => {
                if (res.isConfirmed) {
                    fetch(`/complementos/paquetes/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': token }
                    }).then(() => {
                        Swal.fire('Eliminado', '', 'success').then(() => location.reload());
                    });
                }
            });
        });
    });

    // ========== ENTRADAS ==========

    document.getElementById('guardarEntrada').addEventListener('click', () => {
        const id = document.getElementById('cod_entrada').value;
        const nombre = document.getElementById('nombre_entrada').value;
        const precio = document.getElementById('precio_entrada').value;

        const data = { nombre, precio };

        let url = '/complementos/entradas';
        let method = 'POST';

        if (id) {
            url += `/${id}`;
            method = 'PUT';
        }

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            Swal.fire('Éxito', res.mensaje, 'success').then(() => location.reload());
        });
    });

    document.querySelectorAll('.editarEntradaBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.closest('tr').dataset.id;
            fetch(`/complementos/entradas/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cod_entrada').value = data.cod_entrada;
                    document.getElementById('nombre_entrada').value = data.nombre;
                    document.getElementById('precio_entrada').value = data.precio;
                    new bootstrap.Modal(document.getElementById('modalEntrada')).show();
                });
        });
    });

    document.querySelectorAll('.eliminarEntradaBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.closest('tr').dataset.id;
            Swal.fire({
                title: '¿Eliminar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar'
            }).then(res => {
                if (res.isConfirmed) {
                    fetch(`/complementos/entradas/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': token }
                    }).then(() => {
                        Swal.fire('Eliminado', '', 'success').then(() => location.reload());
                    });
                }
            });
        });
    });

});
