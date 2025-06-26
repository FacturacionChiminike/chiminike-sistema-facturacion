document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const modalEditar = new bootstrap.Modal(
        document.getElementById("modalEditar")
    );
    const modalNuevo = new bootstrap.Modal(
        document.getElementById("modalNuevo")
    );

    document.getElementById("btnGuardarNuevo").onclick = () => {
        const tipo = document.getElementById("nuevo_tipo_objeto").value;
        const desc = document.getElementById("nuevo_descripcion").value;

        fetch("/objetos.save", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ tipo_objeto: tipo, descripcion: desc }),
        })
            .then((res) => {
                if (!res.ok) throw new Error("Error al insertar");
                return res.json();
            })
            .then((data) => {
                Swal.fire(
                    "Éxito",
                    data.mensaje ?? "Guardado correctamente",
                    "success"
                ).then(() => location.reload());
            })
            .catch((err) => {
                console.error(err);
                Swal.fire(
                    "Error",
                    "Ocurrió un error al guardar el objeto",
                    "error"
                );
            });
    };

    document.getElementById("btnGuardarEdicion").onclick = () => {
        const id = document.getElementById("editar_cod_objeto").value;
        const tipo = document.getElementById("editar_tipo_objeto").value;
        const desc = document.getElementById("editar_descripcion").value;

        fetch(`/objetos/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ tipo_objeto: tipo, descripcion: desc }),
        })
            .then((res) => res.json())
            .then((data) => {
                Swal.fire("Actualizado", data.mensaje, "success").then(() =>
                    location.reload()
                );
            })
            .catch(() => Swal.fire("Error", "Error al actualizar", "error"));
    };

    document.querySelectorAll(".btnEditar").forEach((btn) => {
        btn.addEventListener("click", () => {
            const fila = btn.closest("tr");
            const id = fila.dataset.id;
            const tipo = fila.children[1].innerText;
            const desc = fila.children[2].innerText;

            document.getElementById("editar_cod_objeto").value = id;
            document.getElementById("editar_tipo_objeto").value = tipo;
            document.getElementById("editar_descripcion").value = desc;
            modalEditar.show();
        });
    });

    document.querySelectorAll(".btnEliminar").forEach((btn) => {
        btn.addEventListener("click", () => {
            const fila = btn.closest("tr");
            const id = fila.dataset.id;

            Swal.fire({
                title: "¿Eliminar?",
                text: "Esta acción es irreversible.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/objetos/${id}`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                    })
                        .then((res) => res.json())
                        .then((data) => {
                            Swal.fire(
                                "Eliminado",
                                data.mensaje,
                                "success"
                            ).then(() => location.reload());
                        })
                        .catch(() =>
                            Swal.fire("Error", "Error al eliminar", "error")
                        );
                }
            });
        });
    });
});

