document.addEventListener("DOMContentLoaded", () => {
    const nuevoPermisoBtn = document.getElementById("nuevoPermisoBtn");
    const modalNuevoPermiso = new bootstrap.Modal(
        document.getElementById("modalNuevoPermiso")
    );
    const formNuevoPermiso = document.getElementById("formNuevoPermiso");

    nuevoPermisoBtn.addEventListener("click", () => {
        formNuevoPermiso.reset();
        modalNuevoPermiso.show();
    });

    formNuevoPermiso.addEventListener("submit", async (e) => {
        e.preventDefault();

        const datos = {
            cod_rol: document.getElementById("cod_rol").value,
            cod_objeto: document.getElementById("cod_objeto").value,
            nombre: document.getElementById("nombre").value.trim(),
            crear: parseInt(document.getElementById("crear").value),
            modificar: parseInt(document.getElementById("modificar").value),
            mostrar: parseInt(document.getElementById("mostrar").value),
            eliminar: parseInt(document.getElementById("eliminar").value),
        };

        try {
            const response = await fetch("/permisos", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify(datos),
            });

            const resultado = await response.json();

            if (resultado.success) {
                await Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: resultado.message,
                    timer: 2000,
                    showConfirmButton: false,
                });
                modalNuevoPermiso.hide();
                location.reload();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: resultado.message || "No se pudo crear el permiso",
                });
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Ocurrió un error al procesar la solicitud",
            });
        }
    });

    const modalEditarPermiso = new bootstrap.Modal(
        document.getElementById("modalEditarPermiso")
    );

    function parseBooleanString(valor) {
        return (valor || "").toLowerCase().startsWith("s") ? "1" : "0";
    }

    document.querySelectorAll(".editarBtn").forEach((btn) => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;

            try {
                const response = await fetch(`/permisos/${id}`);
                const resultado = await response.json();

                if (resultado.success) {
                    const permiso = resultado.data;

                    document.getElementById("id_permiso").value =
                        permiso.cod_permiso;
                    document.getElementById("edit_cod_rol").value =
                        getRolIdByNombre(permiso.nombre_rol);
                    document.getElementById("edit_cod_objeto").value =
                        getObjetoIdByNombre(permiso.nombre_objeto);
                    document.getElementById("edit_nombre").value =
                        permiso.nombre;
                    document.getElementById("edit_crear").value =
                        parseBooleanString(permiso.crear);
                    document.getElementById("edit_modificar").value =
                        parseBooleanString(permiso.modificar);
                    document.getElementById("edit_mostrar").value =
                        parseBooleanString(permiso.mostrar);
                    document.getElementById("edit_eliminar").value =
                        parseBooleanString(permiso.eliminar);

                    modalEditarPermiso.show();
                } else {
                    Swal.fire("Error", resultado.message, "error");
                }
            } catch (error) {
                Swal.fire("Error", "No se pudo obtener el permiso", "error");
            }
        });
    });

    document
        .getElementById("formEditarPermiso")
        .addEventListener("submit", async (e) => {
            e.preventDefault();

            const id = document.getElementById("id_permiso").value;

            const datos = {
                cod_rol: document.getElementById("edit_cod_rol").value,
                cod_objeto: document.getElementById("edit_cod_objeto").value,
                nombre: document.getElementById("edit_nombre").value.trim(),
                crear: parseInt(document.getElementById("edit_crear").value),
                modificar: parseInt(
                    document.getElementById("edit_modificar").value
                ),
                mostrar: parseInt(
                    document.getElementById("edit_mostrar").value
                ),
                eliminar: parseInt(
                    document.getElementById("edit_eliminar").value
                ),
            };

            try {
                const response = await fetch(`/permisos/${id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify(datos),
                });

                const resultado = await response.json();

                if (resultado.success) {
                    await Swal.fire({
                        icon: "success",
                        title: "Actualizado",
                        text: resultado.message,
                        timer: 2000,
                        showConfirmButton: false,
                    });
                    modalEditarPermiso.hide();
                    location.reload();
                } else {
                    Swal.fire("Error", resultado.message, "error");
                }
            } catch (error) {
                Swal.fire("Error", "No se pudo actualizar el permiso", "error");
            }
        });

    document.querySelectorAll(".eliminarBtn").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;

            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción no se puede deshacer",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/permisos/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content,
                            },
                        });

                        const resultado = await response.json();

                        if (resultado.success) {
                            await Swal.fire({
                                icon: "success",
                                title: "Eliminado",
                                text: resultado.message,
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            location.reload();
                        } else {
                            Swal.fire("Error", resultado.message, "error");
                        }
                    } catch (error) {
                        Swal.fire(
                            "Error",
                            "No se pudo eliminar el permiso",
                            "error"
                        );
                    }
                }
            });
        });
    });
});
function getRolIdByNombre(nombreRol) {
    const rol = window.rolesData.find((r) => r.nombre === nombreRol);
    return rol ? rol.cod_rol : "";
}

function getObjetoIdByNombre(nombreObjeto) {
    const obj = window.objetosData.find((o) => o.tipo_objeto === nombreObjeto);
    return obj ? obj.cod_objeto : "";
}
