document.addEventListener("DOMContentLoaded", () => {
    const formNuevo = document.getElementById("formNuevo");

    // Escuchar el submit del formulario Nuevo Salón
    formNuevo.addEventListener("submit", function (e) {
        e.preventDefault();

        // Obtenemos los datos del formulario
        const formData = new FormData(formNuevo);

        // Preparamos el objeto para enviar
        const data = {
            nombre: formData.get("nombre"),
            descripcion: formData.get("descripcion"),
            capacidad: parseInt(formData.get("capacidad")),
            estado: formData.get("estado"),
            precio_dia: parseFloat(formData.get("precio_dia")),
            precio_noche: parseFloat(formData.get("precio_noche")),
            precio_hora_extra_dia: parseFloat(
                formData.get("precio_hora_extra_dia")
            ),
            precio_hora_extra_noche: parseFloat(
                formData.get("precio_hora_extra_noche")
            ),
        };

        fetch("/salones", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                    .value,
            },
            body: JSON.stringify(data),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error en la petición");
                }
                return response.json();
            })
            .then((result) => {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "Salón creado correctamente",
                }).then(() => {
                    location.reload();
                });
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Ocurrió un error al crear el salón",
                });
            });
    });
});
//editar
document.addEventListener("DOMContentLoaded", () => {
    const tabla = document.getElementById("tablaSalones");
    const modalEditar = new bootstrap.Modal(
        document.getElementById("modalEditar")
    );
    const formEditar = document.getElementById("formEditar");

    tabla.addEventListener("click", async (e) => {
        if (e.target.closest(".editarBtn")) {
            const fila = e.target.closest("tr");
            const salonId = fila.getAttribute("data-id");

            try {
                // Consumimos directamente el controlador de Laravel
                const response = await fetch(`/salones/${salonId}/edit`);

                if (!response.ok) throw new Error("Error al obtener datos");

                const salon = await response.json();

                document.getElementById("editarId").value = salon.cod_salon;
                document.getElementById("editarNombre").value = salon.nombre;
                document.getElementById("editarDescripcion").value =
                    salon.descripcion;
                document.getElementById("editarCapacidad").value =
                    salon.capacidad;
                document.querySelector(
                    "#formEditar select[name='estado']"
                ).value = salon.estado == "Activo" ? 1 : 0;
                document.getElementById("editarPrecioDia").value =
                    salon.precio_dia;
                document.getElementById("editarPrecioHoraExtraDia").value =
                    salon.precio_hora_extra_dia;
                document.getElementById("editarPrecioNoche").value =
                    salon.precio_noche;
                document.getElementById("editarPrecioHoraExtraNoche").value =
                    salon.precio_hora_extra_noche;

                modalEditar.show();
            } catch (error) {
                console.error(error);
                Swal.fire("Error", "No se pudo cargar el salón", "error");
            }
        }
    });

    // Enviar el formulario de actualización
    formEditar.addEventListener("submit", async (e) => {
        e.preventDefault();

        const id = document.getElementById("editarId").value;

        const data = {
            nombre: document.getElementById("editarNombre").value,
            descripcion: document.getElementById("editarDescripcion").value,
            capacidad: document.getElementById("editarCapacidad").value,
            estado: document.querySelector("#formEditar select[name='estado']")
                .value,
            precio_dia: document.getElementById("editarPrecioDia").value,
            precio_hora_extra_dia: document.getElementById(
                "editarPrecioHoraExtraDia"
            ).value,
            precio_noche: document.getElementById("editarPrecioNoche").value,
            precio_hora_extra_noche: document.getElementById(
                "editarPrecioHoraExtraNoche"
            ).value,
        };

        try {
            const response = await fetch(`/salones/${id}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'input[name="_token"]'
                    ).value,
                    "X-HTTP-Method-Override": "PUT"
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) throw new Error("Error al actualizar");

            const resultado = await response.json();

            Swal.fire({
                icon: "success",
                title: "Actualizado",
                text: resultado.mensaje,
                timer: 2000,
                showConfirmButton: false,
            });

            modalEditar.hide();
            setTimeout(() => location.reload(), 2100);
        } catch (error) {
            console.error(error);
            Swal.fire("Error", "No se pudo actualizar el salón", "error");
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const tabla = document.getElementById("tablaSalones");

    tabla.addEventListener("click", async (e) => {
        if (e.target.closest(".eliminarBtn")) {
            const fila = e.target.closest("tr");
            const salonId = fila.getAttribute("data-id");

            
            const confirmacion = await Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción eliminará el salón permanentemente",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            });

            if (confirmacion.isConfirmed) {
                try {
                   
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const response = await fetch(`/salones/${salonId}`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        }
                    });

                    if (!response.ok) throw new Error("Error al eliminar");

                    const resultado = await response.json();

                    Swal.fire({
                        icon: "success",
                        title: "Eliminado",
                        text: resultado.mensaje,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(() => location.reload(), 2100);

                } catch (error) {
                    console.error(error);
                    Swal.fire("Error", "No se pudo eliminar el salón", "error");
                }
            }
        }
    });
});
