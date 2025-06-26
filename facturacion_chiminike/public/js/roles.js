document.addEventListener("DOMContentLoaded", function () {
    const buscarInput = document.getElementById("buscarRol");
    const tabla = document.getElementById("tablaRoles").getElementsByTagName("tbody")[0];
    const btnNuevoRol = document.getElementById("btnNuevoRol");
    const modalNuevoRol = new bootstrap.Modal(document.getElementById("modalNuevoRol"));
    const modalEditarRol = new bootstrap.Modal(document.getElementById("modalEditarRol"));

    // BUSCADOR
    buscarInput.addEventListener("keyup", function () {
        const filtro = buscarInput.value.toLowerCase();
        const filas = tabla.getElementsByTagName("tr");
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const textoFila = fila.textContent.toLowerCase();
            fila.style.display = textoFila.includes(filtro) ? "" : "none";
        }
    });

    // NUEVO ROL
    btnNuevoRol.addEventListener("click", function () {
        document.getElementById("formNuevoRol").reset();
        modalNuevoRol.show();
    });

    document.getElementById("formNuevoRol").addEventListener("submit", function (e) {
        e.preventDefault();
        const nombreRol = document.getElementById("nombre_rol").value;
        const descripcionRol = document.getElementById("descripcion_rol").value;

        fetch("/roles/insertar", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                nombre_rol: nombreRol,
                descripcion_rol: descripcionRol
            })
        })
        .then(res => res.json())
        .then(data => {
            modalNuevoRol.hide();
            Swal.fire({
                icon: 'success',
                title: '¡Rol creado!',
                text: data.mensaje,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'No se pudo insertar el rol', 'error');
        });
    });

    // CARGA LOS DATOS AL MODAL DE EDICIÓN
    document.querySelectorAll(".btnEditar").forEach(boton => {
        boton.addEventListener("click", function () {
            const fila = this.closest("tr");
            const id = this.getAttribute("data-id");
            const nombre = fila.cells[1].innerText;
            const descripcion = fila.cells[2].innerText === 'Sin descripción' ? '' : fila.cells[2].innerText;
            const estadoTexto = fila.cells[3].innerText;
            const estado = estadoTexto === 'Activo' ? 1 : 0;

            document.getElementById("editar_cod_rol").value = id;
            document.getElementById("editar_nombre_rol").value = nombre;
            document.getElementById("editar_descripcion_rol").value = descripcion;
            document.getElementById("editar_estado_rol").value = estado;

            modalEditarRol.show();
        });
    });

    // ENVÍA EL UPDATE
    document.getElementById("formEditarRol").addEventListener("submit", function (e) {
        e.preventDefault();
        const id = document.getElementById("editar_cod_rol").value;
        const nombre = document.getElementById("editar_nombre_rol").value;
        const descripcion = document.getElementById("editar_descripcion_rol").value;
        const estado = parseInt(document.getElementById("editar_estado_rol").value);

        fetch(`/roles/actualizar/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                nombre: nombre,
                descripcion: descripcion,
                estado: estado
            })
        })
        .then(res => res.json())
        .then(data => {
            modalEditarRol.hide();
            Swal.fire({
                icon: 'success',
                title: '¡Rol actualizado!',
                text: data.mensaje,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'No se pudo actualizar el rol', 'error');
        });
    });

    
});

// ELIMINAR
document.querySelectorAll(".btnEliminar").forEach(boton => {
    boton.addEventListener("click", function () {
        const id = this.getAttribute("data-id");

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/roles/eliminar/${id}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        text: data.mensaje,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'No se pudo eliminar el rol', 'error');
                });
            }
        });
    });
});
