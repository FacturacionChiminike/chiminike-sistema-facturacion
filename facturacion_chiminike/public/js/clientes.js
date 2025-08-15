document.addEventListener("DOMContentLoaded", () => {
    // ================= EDITAR CLIENTE =================
    document.querySelectorAll(".btn-editar-cliente").forEach((btn) => {
        btn.addEventListener("click", async function () {
            const clienteId = this.dataset.id;

            try {
                const response = await fetch(`/clientes/${clienteId}/get`);
                const result = await response.json();

                if (!result.success)
                    throw new Error(
                        result.mensaje || "Error al obtener cliente"
                    );

                const cliente = result.data;

                // Rellenar modal
                document.getElementById("id_cliente").value =
                    cliente.cod_cliente;
                document.getElementById("nombre_persona").value =
                    cliente.nombre;
                document.getElementById("fecha_nacimiento").value =
                    cliente.fecha_nacimiento.split("T")[0];
                document.getElementById("sexo").value = cliente.sexo;
                document.getElementById("dni").value = cliente.dni;
                document.getElementById("correo").value = cliente.correo;
                document.getElementById("telefono").value = cliente.telefono;
                document.getElementById("direccion").value = cliente.direccion;
                document.getElementById("rtn").value = cliente.rtn;
                document.getElementById("tipo_cliente").value =
                    cliente.tipo_cliente;

                // 👉 Aquí reemplazas la línea de cod_municipio por esto
                const selectMunicipio =
                    document.getElementById("cod_municipio_edit");
                const municipioNombre = cliente.municipio.trim();

                [...selectMunicipio.options].forEach((option) => {
                    if (option.text.trim() === municipioNombre) {
                        option.selected = true;
                    }
                });

                new bootstrap.Modal(
                    document.getElementById("modalEditarCliente")
                ).show();
            } catch (error) {
                Swal.fire("Error", error.message, "error");
            }
        });
    });

    // Submit editar cliente
    document
        .getElementById("formEditarCliente")
        .addEventListener("submit", async function (e) {
            e.preventDefault();

            const form = this;
            form.querySelectorAll(".is-invalid").forEach((el) =>
                el.classList.remove("is-invalid")
            );

            // Campos
            const nombre = document.getElementById("nombre_persona");
            const fechaNac = document.getElementById("fecha_nacimiento");
            const sexo = document.getElementById("sexo");
            const dni = document.getElementById("dni");
            const rtn = document.getElementById("rtn");
            const correo = document.getElementById("correo");
            const telefono = document.getElementById("telefono");
            const direccion = document.getElementById("direccion");
            const municipio = document.getElementById("cod_municipio_edit");
            const tipoCliente = document.getElementById("tipo_cliente");

            // 🔹 Validaciones (igual que en insertar)
            const valorNombre = (nombre.value || "").trim();
            if (valorNombre.length < 2) {
                return mostrarError(
                    "Nombre inválido",
                    "Debe tener al menos 2 caracteres.",
                    nombre
                );
            }

            const fechaLimite = new Date();
            fechaLimite.setFullYear(fechaLimite.getFullYear() - 18);
            if (new Date(fechaNac.value) > fechaLimite || !fechaNac.value) {
                return mostrarError(
                    "Fecha inválida",
                    "Debe ser mayor de 18 años.",
                    fechaNac
                );
            }

            if (!sexo.value) {
                return mostrarError(
                    "Sexo requerido",
                    "Seleccione el sexo.",
                    sexo
                );
            }

            if (!/^08\d{11}$/.test(dni.value)) {
                return mostrarError(
                    "DNI inválido",
                    "Debe iniciar con 08 y tener 13 dígitos.",
                    dni
                );
            }

            if (!/^08\d{12}$/.test(rtn.value)) {
                return mostrarError(
                    "RTN inválido",
                    "Debe iniciar con 08 y tener 14 dígitos.",
                    rtn
                );
            }

            if (
                !/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[A-Za-z]{2,}$/.test(
                    correo.value
                ) ||
                correo.value.length > 100
            ) {
                return mostrarError(
                    "Correo inválido",
                    "Correo no válido (máx. 100 caracteres).",
                    correo
                );
            }

            if (!/^(?!0)(?!([0-9])\1{7})[0-9]{8}$/.test(telefono.value)) {
                return mostrarError(
                    "Teléfono inválido",
                    "Debe tener 8 dígitos, no iniciar con 0 ni repetir el mismo número.",
                    telefono
                );
            }

            if (direccion.value.length < 5 || direccion.value.length > 150) {
                return mostrarError(
                    "Dirección inválida",
                    "Debe tener entre 5 y 150 caracteres.",
                    direccion
                );
            }

            if (!municipio.value) {
                return mostrarError(
                    "Municipio requerido",
                    "Seleccione un municipio.",
                    municipio
                );
            }

            if (!tipoCliente.value) {
                return mostrarError(
                    "Tipo de cliente requerido",
                    "Seleccione un tipo de cliente.",
                    tipoCliente
                );
            }

            // 🔹 Si todo está bien, enviamos
            const clienteId = document.getElementById("id_cliente").value;
            const formData = new FormData(form);

            try {
                const response = await fetch(`/clientes/${clienteId}`, {
                    method: "POST", // 👈 POST directo según tu ruta web.php
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: formData,
                });

                const result = await response.json();
                if (result.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Cliente actualizado correctamente",
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => location.reload());
                } else {
                    Swal.fire(
                        "Error",
                        result.mensaje || "Error al actualizar",
                        "error"
                    );
                }
            } catch (error) {
                Swal.fire("Error", "Error de conexión al actualizar", "error");
            }
        });

    function mostrarError(titulo, mensaje, input) {
        input.classList.add("is-invalid");
        Swal.fire({
            icon: "error",
            title: titulo,
            text: mensaje,
            confirmButtonText: "Entendido",
        }).then(() => input.focus());
        return false;
    }

    // ================= ELIMINAR CLIENTE =================
    document.querySelectorAll(".btn-eliminar-cliente").forEach((btn) => {
        btn.addEventListener("click", function () {
            const clienteId = this.dataset.id;

            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción eliminará el cliente permanentemente",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/clientes/${clienteId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content,
                            },
                        });

                        const result = await response.json();
                        if (result.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Cliente eliminado",
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => location.reload());
                        } else {
                            Swal.fire("Error", result.mensaje, "error");
                        }
                    } catch (error) {
                        Swal.fire(
                            "Error",
                            "Error de conexión al eliminar",
                            "error"
                        );
                    }
                }
            });
        });
    });

    // ================= NUEVO CLIENTE =================
    // Abrir modal
    document.getElementById("btnNuevoCliente").addEventListener("click", () => {
        new bootstrap.Modal(
            document.getElementById("modalNuevoCliente")
        ).show();
    });

    // Fecha máximo (18 años)
    const fechaInput = document.getElementById("fecha_nacimiento");
    const hoy = new Date();
    hoy.setFullYear(hoy.getFullYear() - 18);
    fechaInput.max = hoy.toISOString().split("T")[0];

    // Submit nuevo cliente con validaciones
    document
        .getElementById("formNuevoCliente")
        .addEventListener("submit", async function (e) {
            e.preventDefault();

            const form = this;
            form.querySelectorAll(".is-invalid").forEach((el) =>
                el.classList.remove("is-invalid")
            );

            //  Toma los campos por su *name* dentro del formulario que envía
            const nombre = form.elements["nombre_persona"];
            const fechaNac = form.elements["fecha_nacimiento"];
            const sexo = form.elements["sexo"];
            const dni = form.elements["dni"];
            const rtn = form.elements["rtn"];
            const correo = form.elements["correo"];
            const telefono = form.elements["telefono"];
            const direccion = form.elements["direccion"];
            const municipio = form.elements["cod_municipio"];
            const tipoCliente = form.elements["tipo_cliente"];

            const valorNombre = (nombre?.value || "").trim();
            console.log("Valor leído del nombre (nuevo):", `"${valorNombre}"`);

            if (valorNombre.length < 2) {
                return mostrarError(
                    "Nombre inválido",
                    "Debe tener al menos 2 caracteres.",
                    nombre
                );
            }

            const fechaLimite = new Date();
            fechaLimite.setFullYear(fechaLimite.getFullYear() - 18);
            if (new Date(fechaNac.value) > fechaLimite || !fechaNac.value)
                return mostrarError(
                    "Fecha inválida",
                    "Debe ser mayor de 18 años.",
                    fechaNac
                );

            if (!sexo.value)
                return mostrarError(
                    "Sexo requerido",
                    "Seleccione el sexo.",
                    sexo
                );

            if (!/^08\d{11}$/.test(dni.value))
                return mostrarError(
                    "DNI inválido",
                    "Debe iniciar con 08 y tener 13 dígitos.",
                    dni
                );

            if (!/^08\d{12}$/.test(rtn.value))
                return mostrarError(
                    "RTN inválido",
                    "Debe iniciar con 08 y tener 14 dígitos.",
                    rtn
                );

            if (
                !/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[A-Za-z]{2,}$/.test(
                    correo.value
                ) ||
                correo.value.length > 100
            )
                return mostrarError(
                    "Correo inválido",
                    "Correo no válido (máx. 100 caracteres).",
                    correo
                );

            if (!/^(?!0)(?!([0-9])\1{7})[0-9]{8}$/.test(telefono.value))
                return mostrarError(
                    "Teléfono inválido",
                    "Debe tener 8 dígitos, no iniciar con 0 ni repetir el mismo número.",
                    telefono
                );

            if (direccion.value.length < 5 || direccion.value.length > 150)
                return mostrarError(
                    "Dirección inválida",
                    "Debe tener entre 5 y 150 caracteres.",
                    direccion
                );

            if (!municipio.value)
                return mostrarError(
                    "Municipio requerido",
                    "Seleccione un municipio.",
                    municipio
                );

            if (!tipoCliente.value)
                return mostrarError(
                    "Tipo de cliente requerido",
                    "Seleccione un tipo de cliente.",
                    tipoCliente
                );

            // Si todo bien -> enviar
            try {
    const data = {
        nombre_persona: nombre.value.trim(),
        fecha_nacimiento: fechaNac.value,
        sexo: sexo.value,
        dni: dni.value.trim(),
        rtn: rtn.value.trim(),
        correo: correo.value.trim(),
        telefono: telefono.value.trim(),
        direccion: direccion.value.trim(),
        cod_municipio: municipio.value,
        tipo_cliente: tipoCliente.value
    };

    const response = await fetch(`/clientes`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector(
                'meta[name="csrf-token"]'
            ).content,
        },
        body: JSON.stringify(data),
    });

    const result = await response.json();
    if (result.success) {
        Swal.fire({
            icon: "success",
            title: result.mensaje,
            timer: 1500,
            showConfirmButton: false,
        }).then(() => location.reload());
    } else {
        Swal.fire("Error", result.mensaje, "error");
    }
} catch (error) {
    Swal.fire("Error", "Error de conexión al registrar", "error");
}
        });

    function mostrarError(titulo, mensaje, input) {
        input.classList.add("is-invalid");
        Swal.fire({
            icon: "error",
            title: titulo,
            text: mensaje,
            confirmButtonText: "Entendido",
        }).then(() => input.focus());
        return false;
    }
});
