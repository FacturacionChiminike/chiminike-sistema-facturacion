document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // 🔄 Función central para actualizar usuario
    async function actualizarUsuario(codUsuario, estado, codRol, codTipo) {
        try {
            const response = await fetch(`/usuarios/${codUsuario}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    estado: estado,
                    cod_rol: codRol,
                    cod_tipo_usuario: codTipo,
                }),
            });

            const data = await response.json();

            if (response.ok) {
                Swal.fire({
                    title: "¡Actualizado!",
                    text: data.mensaje,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => {
                    
                    window.location.href = "/usuarios";
                });
            } else {
                Swal.fire(
                    "Error",
                    data.error || "Error al actualizar",
                    "error"
                );
            }
        } catch (error) {
            console.error(error);
            Swal.fire("Error", "No se pudo conectar con el servidor", "error");
        }
    }

    // ✅ Switch estado
    document.querySelectorAll(".estado-switch").forEach((switchInput) => {
        switchInput.addEventListener("change", () => {
            const codUsuario = switchInput.dataset.id;
            const fila = switchInput.closest("tr");

            const nuevoEstado = switchInput.checked ? 1 : 0;
            const codRol = fila.querySelector(".select-rol").value;
            const codTipo = fila.querySelector(".select-tipo").value;

            actualizarUsuario(codUsuario, nuevoEstado, codRol, codTipo);
        });
    });

    // ✅ Select rol
    document.querySelectorAll(".select-rol").forEach((selectRol) => {
        selectRol.addEventListener("change", () => {
            const codUsuario = selectRol.dataset.id;
            const fila = selectRol.closest("tr");

            const codRol = selectRol.value;
            const codTipo = fila.querySelector(".select-tipo").value;
            const estado = fila.querySelector(".estado-switch").checked ? 1 : 0;

            actualizarUsuario(codUsuario, estado, codRol, codTipo);
        });
    });

    // ✅ Select tipo usuario
    document.querySelectorAll(".select-tipo").forEach((selectTipo) => {
        selectTipo.addEventListener("change", () => {
            const codUsuario = selectTipo.dataset.id;
            const fila = selectTipo.closest("tr");

            const codTipo = selectTipo.value;
            const codRol = fila.querySelector(".select-rol").value;
            const estado = fila.querySelector(".estado-switch").checked ? 1 : 0;

            actualizarUsuario(codUsuario, estado, codRol, codTipo);
        });
    });

    // 🎯 Filtros
    const filtroEstado = document.getElementById("filtroEstado");
    const filtroRol = document.getElementById("filtroRol");

    [filtroEstado, filtroRol].forEach((filtro) => {
        filtro.addEventListener("change", filtrarTabla);
    });

    function filtrarTabla() {
        const estado = filtroEstado.value;
        const rol = filtroRol.value.toLowerCase();
        const filas = document.querySelectorAll("#tablaUsuarios tbody tr");

        filas.forEach((fila) => {
            const estadoFila = fila.dataset.estado;
            const rolFila = fila.dataset.rol.toLowerCase();
            const visible =
                (!estado || estadoFila === estado) && (!rol || rolFila === rol);
            fila.style.display = visible ? "" : "none";
        });
    }

    $(document).ready(function () {
        $(".select-rol").select2({
            placeholder: "Selecciona un rol",
            width: "100%",
        });

        $(".select-tipo").select2({
            placeholder: "Selecciona tipo de usuario",
            width: "100%",
        });
    });

    $(document).ready(function () {
        // Inicializar Select2
        $(".select-rol").select2({
            width: "100%",
        });

        // Manejar cambio con jQuery
        $(".select-rol").on("change", function () {
            const selectRol = this;
            const codUsuario = selectRol.dataset.id;
            const fila = selectRol.closest("tr");

            const codRol = selectRol.value;
            const codTipo = fila.querySelector(".select-tipo").value;
            const estado = fila.querySelector(".estado-switch").checked ? 1 : 0;

            actualizarUsuario(codUsuario, estado, codRol, codTipo);
        });
    });

    $(".select-tipo").on("change", function () {
        const selectTipo = this;
        const codUsuario = selectTipo.dataset.id;
        const fila = selectTipo.closest("tr");

        const codTipo = selectTipo.value;
        const codRol = fila.querySelector(".select-rol").value;
        const estado = fila.querySelector(".estado-switch").checked ? 1 : 0;

        actualizarUsuario(codUsuario, estado, codRol, codTipo);
    });
});
