document.addEventListener("DOMContentLoaded", () => {
    const buscarInput = document.getElementById("buscarInventario");
    const tablaBody = document.querySelector("#tablaInventario tbody");

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Filtro de búsqueda
    buscarInput.addEventListener("input", () => {
        const filtro = buscarInput.value.toLowerCase();
        document.querySelectorAll("#tablaInventario tbody tr").forEach(fila => {
            fila.style.display = fila.innerText.toLowerCase().includes(filtro) ? "" : "none";
        });
    });

    // Abrir modal editar
    tablaBody.addEventListener("click", async (e) => {
        if (e.target.closest(".editarBtn")) {
            const fila = e.target.closest("tr");
            const id = fila.dataset.id;

            const response = await fetch(`/inventario/${id}/edit`);
            const item = await response.json();

            document.getElementById("editarId").value = item.cod_inventario;
            document.getElementById("editarNombre").value = item.nombre;
            document.getElementById("editarDescripcion").value = item.descripcion;
            document.getElementById("editarPrecioUnitario").value = item.precio_unitario;
            document.getElementById("editarCantidadDisponible").value = item.cantidad_disponible;
            document.getElementById("editarEstado").value = (item.estado === "Activo" ? 1 : 0);

            new bootstrap.Modal(document.getElementById("modalEditar")).show();
        }
    });

    // Enviar actualización
    document.getElementById("formEditar").addEventListener("submit", async (e) => {
        e.preventDefault();
        const id = document.getElementById("editarId").value;
        const data = {
            nombre: document.getElementById("editarNombre").value,
            descripcion: document.getElementById("editarDescripcion").value,
            precio_unitario: document.getElementById("editarPrecioUnitario").value,
            cantidad_disponible: document.getElementById("editarCantidadDisponible").value,
            estado: document.getElementById("editarEstado").value
        };

        const response = await fetch(`/inventario/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify(data)
        });

        const resultado = await response.json();

        Swal.fire("Actualizado!", resultado.mensaje, "success").then(() => location.reload());
    });

    // Eliminar inventario
    tablaBody.addEventListener("click", async (e) => {
        if (e.target.closest(".eliminarBtn")) {
            const fila = e.target.closest("tr");
            const id = fila.dataset.id;

            const confirmacion = await Swal.fire({
                title: "¿Eliminar?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            });

            if (confirmacion.isConfirmed) {
                const response = await fetch(`/inventario/${id}`, {
                    method: "DELETE",
                    headers: { "X-CSRF-TOKEN": csrfToken }
                });

                const resultado = await response.json();
                Swal.fire("Eliminado!", resultado.mensaje, "success").then(() => location.reload());
            }
        }
    });

    // Guardar nuevo inventario
    document.getElementById("formNuevo").addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        const response = await fetch(`/inventario`, {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify(data)
        });

        const resultado = await response.json();

        Swal.fire("Guardado!", resultado.mensaje, "success").then(() => location.reload());
    });
});
