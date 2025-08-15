document.addEventListener("DOMContentLoaded", () => {
    // 🎯 BLOQUE NUEVO
    const formNuevo = document.getElementById("formNuevo");
    const formEditar = document.getElementById("formEditar");
    const modalEditar = new bootstrap.Modal(document.getElementById("modalEditar"));
    const tabla = document.getElementById("tablaSalones");

    // CREAR SALÓN
    formNuevo?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(formNuevo);
        const data = {
            nombre: formData.get("nombre"),
            descripcion: formData.get("descripcion"),
            capacidad: parseInt(formData.get("capacidad")),
            estado: formData.get("estado"),
            precio_dia: parseFloat(formData.get("precio_dia")),
            precio_noche: parseFloat(formData.get("precio_noche")),
            precio_hora_extra_dia: parseFloat(formData.get("precio_hora_extra_dia")),
            precio_hora_extra_noche: parseFloat(formData.get("precio_hora_extra_noche")),
        };

        try {
            const response = await fetch("/salones", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) throw new Error("Error en la petición");

            await response.json();
            Swal.fire("Éxito", "Salón creado correctamente", "success").then(() => location.reload());

        } catch (error) {
            console.error(error);
            Swal.fire("Oops...", "Ocurrió un error al crear el salón", "error");
        }
    });

    // EDITAR SALÓN (abrir modal y cargar datos)
    tabla?.addEventListener("click", async (e) => {
        if (e.target.closest(".editarBtn")) {
            const fila = e.target.closest("tr");
            const salonId = fila.getAttribute("data-id");
            console.log("Intentando editar salón con ID:", salonId);

            try {
                const response = await fetch(`/salones/${salonId}/edit`);
                if (!response.ok) throw new Error("Error al obtener datos");
                const salon = await response.json();

                document.getElementById("editarId").value = salon.cod_salon;
                document.getElementById("editarNombre").value = salon.nombre;
                document.getElementById("editarDescripcion").value = salon.descripcion;
                document.getElementById("editarCapacidad").value = salon.capacidad;
                document.getElementById("editarEstado").value = salon.estado == "Activo" ? 1 : 0;

                document.getElementById("editarPrecioDia").value = salon.precio_dia;
                document.getElementById("editarPrecioHoraExtraDia").value = salon.precio_hora_extra_dia;
                document.getElementById("editarPrecioNoche").value = salon.precio_noche;
                document.getElementById("editarPrecioHoraExtraNoche").value = salon.precio_hora_extra_noche;

                modalEditar.show();
            } catch (error) {
                console.error(error);
                Swal.fire("Error", "No se pudo cargar el salón", "error");
            }
        }
    });

    // ACTUALIZAR SALÓN  
    formEditar?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const id = document.getElementById("editarId").value;
        const data = {
            nombre: document.getElementById("editarNombre").value,
            descripcion: document.getElementById("editarDescripcion").value,
            capacidad: document.getElementById("editarCapacidad").value,
            estado: document.getElementById("editarEstado").value,
            precio_dia: document.getElementById("editarPrecioDia").value,
            precio_hora_extra_dia: document.getElementById("editarPrecioHoraExtraDia").value,
            precio_noche: document.getElementById("editarPrecioNoche").value,
            precio_hora_extra_noche: document.getElementById("editarPrecioHoraExtraNoche").value,
        };

        try {
            const response = await fetch(`/salones/${id}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    "X-HTTP-Method-Override": "PUT"
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) throw new Error("Error al actualizar");

            const resultado = await response.json();

            Swal.fire("Actualizado", resultado.mensaje, "success");
            modalEditar.hide();
            setTimeout(() => location.reload(), 2100);

        } catch (error) {
            console.error(error);
            Swal.fire("Error", "No se pudo actualizar el salón", "error");
        }
    });

    // ELIMINAR SALÓN
    tabla?.addEventListener("click", async (e) => {
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

                    Swal.fire("Eliminado", resultado.mensaje, "success");
                    setTimeout(() => location.reload(), 2100);

                } catch (error) {
                    console.error(error);
                    Swal.fire("Error", "No se pudo eliminar el salón", "error");
                }
            }
        }
    });
});
