document.addEventListener("DOMContentLoaded", () => {

    // Mapa de municipios
    const municipiosMap = {
        "Distrito Central": 110,
        "La Ceiba": 1,
        "El Porvenir": 2,
        "Tela": 3,
        "San Francisco": 6,
        "Esparta": 7
    };

    document.querySelectorAll('.btn-editar-cliente').forEach(btn => {
        btn.addEventListener('click', async function () {
            const clienteId = this.dataset.id;

            try {
                const response = await fetch(`/clientes/${clienteId}/get`);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.mensaje || "Error al obtener cliente");
                }

                const cliente = result.data;

                document.getElementById('id_cliente').value = cliente.cod_cliente;
                document.getElementById('nombre_persona').value = cliente.nombre;
                document.getElementById('fecha_nacimiento').value = cliente.fecha_nacimiento.split('T')[0];
                document.getElementById('sexo').value = cliente.sexo;
                document.getElementById('dni').value = cliente.dni;
                document.getElementById('correo').value = cliente.correo;
                document.getElementById('telefono').value = cliente.telefono;
                document.getElementById('direccion').value = cliente.direccion;
                document.getElementById('rtn').value = cliente.rtn;
                document.getElementById('tipo_cliente').value = cliente.tipo_cliente;

                // Conversión del nombre de municipio al ID
                const municipioNombre = cliente.municipio;
                const codMunicipio = municipiosMap[municipioNombre] || "";

                document.getElementById('cod_municipio').value = codMunicipio;

                const modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
                modal.show();

            } catch (error) {
                console.error(error);
                Swal.fire('Error', error.message, 'error');
            }
        });
    });

    document.getElementById('formEditarCliente').addEventListener('submit', async function (e) {
        e.preventDefault();

        const clienteId = document.getElementById('id_cliente').value;
        const formData = new FormData(this);

        try {
            const response = await fetch(`/clientes/${clienteId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cliente actualizado correctamente',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', result.mensaje || "Error al actualizar", 'error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', "Error de conexión al actualizar", 'error');
        }
    });

});

// Escuchamos los botones de eliminar
document.querySelectorAll('.btn-eliminar-cliente').forEach(btn => {
    btn.addEventListener('click', function () {
        const clienteId = this.dataset.id;

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el cliente permanentemente",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/clientes/${clienteId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cliente eliminado',
                            text: result.mensaje,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', result.mensaje, 'error');
                    }
                } catch (error) {
                    console.error(error);
                    Swal.fire('Error', 'Error de conexión al eliminar', 'error');
                }
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {

    // Abrir el modal al dar clic en "Nuevo Cliente"
    document.getElementById('btnNuevoCliente').addEventListener('click', function () {
        const modal = new bootstrap.Modal(document.getElementById('modalNuevoCliente'));
        modal.show();
    });

    // Enviar el formulario de nuevo cliente
    document.getElementById('formNuevoCliente').addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch(`/clientes`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cliente registrado correctamente',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', result.mensaje || "Error al registrar", 'error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', "Error de conexión al registrar", 'error');
        }
    });

});
