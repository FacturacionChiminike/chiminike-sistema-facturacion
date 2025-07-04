document.addEventListener("DOMContentLoaded", () => {
    const buscarInput = document.getElementById("buscarAdicional");
    const tablaBody = document.querySelector("#tablaAdicionales tbody");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Buscar
    buscarInput.addEventListener("input", () => {
        const filtro = buscarInput.value.toLowerCase();
        document.querySelectorAll("#tablaAdicionales tbody tr").forEach(fila => {
            fila.style.display = fila.innerText.toLowerCase().includes(filtro) ? "" : "none";
        });
    });

    // Insertar nuevo
    document.getElementById("formNuevo").addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        const response = await fetch("/adicionales", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify(data)
        });

        const resultado = await response.json();
        Swal.fire("Guardado", resultado.mensaje, "success").then(() => location.reload());
    });

    // Editar
    tablaBody.addEventListener("click", async (e) => {
        if (e.target.closest(".editarBtn")) {
            const fila = e.target.closest("tr");
            const id = fila.dataset.id;

            const response = await fetch(`/adicionales/${id}/edit`);
            const item = await response.json();

            document.getElementById("editarId").value = item.cod_adicional;
            document.getElementById("editarNombre").value = item.nombre;
            document.getElementById("editarDescripcion").value = item.descripcion;
            document.getElementById("editarPrecio").value = item.precio;

            new bootstrap.Modal(document.getElementById("modalEditar")).show();
        }
    });

    document.getElementById("formEditar").addEventListener("submit", async (e) => {
        e.preventDefault();
        const id = document.getElementById("editarId").value;
        const data = {
            nombre: document.getElementById("editarNombre").value,
            descripcion: document.getElementById("editarDescripcion").value,
            precio: document.getElementById("editarPrecio").value
        };

        const response = await fetch(`/adicionales/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify(data)
        });

        const resultado = await response.json();
        Swal.fire("Actualizado", resultado.mensaje, "success").then(() => location.reload());
    });

    // Eliminar
    tablaBody.addEventListener("click", async (e) => {
        if (e.target.closest(".eliminarBtn")) {
            const fila = e.target.closest("tr");
            const id = fila.dataset.id;

            const confirmacion = await Swal.fire({
                title: "¿Eliminar?",
                text: "Esta acción no se puede deshacer",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            });

            if (confirmacion.isConfirmed) {
                const response = await fetch(`/adicionales/${id}`, {
                    method: "DELETE",
                    headers: { "X-CSRF-TOKEN": csrfToken }
                });

                const resultado = await response.json();
                Swal.fire("Eliminado", resultado.mensaje, "success").then(() => location.reload());
            }
        }
    });
});
