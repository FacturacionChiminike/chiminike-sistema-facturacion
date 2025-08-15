document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const inputBusqueda = document.getElementById("busquedaEmpleado");
    let timeoutBusqueda = null;

    inputBusqueda.addEventListener("input", function () {
        clearTimeout(timeoutBusqueda);
        timeoutBusqueda = setTimeout(buscarEmpleados, 300);
    });

    document
        .getElementById("btn-limpiar")
        .addEventListener("click", function () {
            inputBusqueda.value = "";
            buscarEmpleados();
        });

    document
        .getElementById("btnNuevoEmpleado")
        .addEventListener("click", function () {
            const modal = new bootstrap.Modal(
                document.getElementById("modalNuevoEmpleado")
            );
            modal.show();
        });

    document
        .getElementById("exportarPDF")
        .addEventListener("click", function () {
            Swal.fire({
                title: "Exportar a PDF",
                text: "¿Desea exportar el listado de empleados a PDF?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Exportar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Éxito",
                        text: "El PDF se está generando...",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            });
        });

    document
        .getElementById("exportarExcel")
        .addEventListener("click", function () {
            Swal.fire({
                title: "Exportar a Excel",
                text: "¿Desea exportar el listado de empleados a Excel?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Exportar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Éxito",
                        text: "El archivo Excel se está generando...",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            });
        });

    const formNuevo = document.getElementById("formNuevoEmpleado");
    formNuevo.addEventListener("submit", async function (e) {
        e.preventDefault();

        if (!formNuevo.checkValidity()) {
            e.stopPropagation();
            formNuevo.classList.add("was-validated");
            return;
        }

        const formData = new FormData(formNuevo);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch("/empleados", {
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
                    title: "Éxito",
                    text: result.mensaje,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => {
                    window.location.reload();
                });
            } else {
                throw new Error(
                    result.mensaje || "Error al registrar empleado"
                );
            }
        } catch (error) {
            Swal.fire({
                title: "Error",
                text: error.message,
                icon: "error",
            });
        }
    });
});

function buscarEmpleados() {
    const valor = document
        .getElementById("busquedaEmpleado")
        .value.toLowerCase();
    const filas = document.querySelectorAll("#tablaEmpleados tbody tr");

    filas.forEach((fila) => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(valor) ? "" : "none";
    });
}

function mostrarDetallesEmpleado(empleado) {
    const contenido = `
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="d-flex justify-content-center">
                    <div class="avatar-details">
                        ${empleado.nombre
                            .split(" ")
                            .map((n) => n[0])
                            .join("")
                            .substring(0, 2)
                            .toUpperCase()}
                    </div>
                </div>
                <h5 class="text-center mt-2">${empleado.nombre}</h5>
                <p class="text-center text-muted mb-0">${
                    empleado.tipo_usuario
                }</p>
                <div class="text-center mt-2">
                    <span class="badge ${
                        empleado.estado == 1 ? "bg-success" : "bg-secondary"
                    }">
                        ${empleado.estado == 1 ? "Activo" : "Inactivo"}
                    </span>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-person-badge me-2"></i>DNI:</strong></p>
                        <p>${empleado.dni || "N/A"}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-gender-ambiguous me-2"></i>Sexo:</strong></p>
                        <p>${empleado.sexo || "N/A"}</p>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-envelope me-2"></i>Correo:</strong></p>
                        <p>${empleado.correo || "N/A"}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-telephone me-2"></i>Teléfono:</strong></p>
                        <p>${empleado.telefono || "N/A"}</p>
                    </div>
                    
                    <div class="col-12 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-geo-alt me-2"></i>Dirección:</strong></p>
                        <p>${empleado.direccion || "N/A"}</p>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-briefcase me-2"></i>Cargo:</strong></p>
                        <p>${empleado.cargo || "N/A"}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-building me-2"></i>Departamento:</strong></p>
                        <p>${empleado.departamento_empresa || "N/A"}</p>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-person-rolodex me-2"></i>Rol:</strong></p>
                        <p>${empleado.rol || "N/A"}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-calendar-event me-2"></i>Fecha Contratación:</strong></p>
                        <p>${
                            formatDate(empleado.fecha_contratacion) || "N/A"
                        }</p>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-currency-dollar me-2"></i>Salario:</strong></p>
                        <p>L. ${
                            empleado.salario
                                ? Number(empleado.salario).toFixed(2)
                                : "N/A"
                        }</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong><i class="bi bi-calendar-date me-2"></i>Fecha Nacimiento:</strong></p>
                        <p>${formatDate(empleado.fecha_nacimiento) || "N/A"}</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.getElementById("contenidoEmpleado").innerHTML = contenido;
    const modal = new bootstrap.Modal(document.getElementById("modalEmpleado"));
    modal.show();
}

function mostrarFormularioEdicion(emp) {
    document.getElementById("edit_cod_empleado").value = emp.cod_empleado;
    document.getElementById("edit_nombre_persona").value = emp.nombre;
    document.getElementById("edit_fecha_nacimiento").value = formatDateForInput(
        emp.fecha_nacimiento
    );
    document.getElementById("edit_sexo").value = emp.sexo;
    document.getElementById("edit_dni").value = emp.dni;
    document.getElementById("edit_correo").value = emp.correo;
    document.getElementById("edit_telefono").value = emp.telefono;
    document.getElementById("edit_direccion").value = emp.direccion;
    document.getElementById("edit_cargo").value = emp.cargo;
    document.getElementById("edit_salario").value = emp.salario;
    document.getElementById("edit_fecha_contratacion").value =
        formatDateForInput(emp.fecha_contratacion);

    const municipioSelect = document.getElementById("edit_cod_municipio");
    for (let option of municipioSelect.options) {
        if (
            option.text.trim().toLowerCase() ===
            emp.municipio?.trim().toLowerCase()
        ) {
            municipioSelect.value = option.value;
            break;
        }
    }

    const deptoSelect = document.getElementById(
        "edit_cod_departamento_empresa"
    );
    for (let option of deptoSelect.options) {
        if (
            option.text.trim().toLowerCase() ===
            emp.departamento_empresa?.trim().toLowerCase()
        ) {
            deptoSelect.value = option.value;
            break;
        }
    }

    const rolSelect = document.getElementById("edit_cod_rol");
    for (let option of rolSelect.options) {
        if (
            option.text.trim().toLowerCase() === emp.rol?.trim().toLowerCase()
        ) {
            rolSelect.value = option.value;
            break;
        }
    }

    const tipoUsuarioSelect = document.getElementById("edit_cod_tipo_usuario");
    const tipoNombre = emp.tipo_usuario?.trim().toLowerCase();

    for (let option of tipoUsuarioSelect.options) {
        if (option.text.trim().toLowerCase() === tipoNombre) {
            tipoUsuarioSelect.value = option.value;
            break;
        }
    }

    document.getElementById("edit_estado").value = emp.estado;

    const modal = new bootstrap.Modal(
        document.getElementById("modalEditarEmpleado")
    );
    modal.show();
}

function formatDate(dateString) {
    if (!dateString) return "";
    const date = new Date(dateString);
    return date.toLocaleDateString("es-HN");
}

function formatDateForInput(dateString) {
    if (!dateString) return "";
    const date = new Date(dateString);
    return date.toISOString().split("T")[0];
}

document.addEventListener("DOMContentLoaded", () => {
    const formEditar = document.getElementById("formEditarEmpleado");

    formEditar.addEventListener("submit", async function (e) {
        e.preventDefault();

        formEditar
            .querySelectorAll(".is-invalid")
            .forEach((el) => el.classList.remove("is-invalid"));

        const nombre = document.getElementById("edit_nombre_persona");
        const fechaNac = document.getElementById("edit_fecha_nacimiento");
        const sexo = document.getElementById("edit_sexo");
        const dni = document.getElementById("edit_dni");
        const correo = document.getElementById("edit_correo");
        const telefono = document.getElementById("edit_telefono");
        const direccion = document.getElementById("edit_direccion");
        const municipio = document.getElementById("edit_cod_municipio");
        const depEmpresa = document.getElementById(
            "edit_cod_departamento_empresa"
        );
        const rol = document.getElementById("edit_cod_rol");
        const tipoUsuario = document.getElementById("edit_cod_tipo_usuario");
        const estado = document.getElementById("edit_estado");
        const cargo = document.getElementById("edit_cargo");
        const fechaContratacion = document.getElementById(
            "edit_fecha_contratacion"
        );
        const salario = document.getElementById("edit_salario");

        if (
            !/^(?!.*([A-Za-zÁÉÍÓÚáéíóúÑñ])\1{2})[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}$/.test(
                nombre.value
            )
        ) {
            return mostrarError(
                "Nombre inválido",
                "Debe contener solo letras y espacios, máximo 50 caracteres y sin repetir más de 3 veces.",
                nombre
            );
        }

        const fechaLimite = new Date();
        fechaLimite.setFullYear(fechaLimite.getFullYear() - 18);
        if (new Date(fechaNac.value) > fechaLimite || !fechaNac.value) {
            return mostrarError(
                "Fecha inválida",
                "El empleado debe ser mayor de 18 años.",
                fechaNac
            );
        }

        if (!sexo.value) {
            return mostrarError(
                "Sexo requerido",
                "Seleccione una opción.",
                sexo
            );
        }

        if (!/^0801\d{9}$/.test(dni.value)) {
            return mostrarError(
                "DNI inválido",
                "Debe iniciar con 0801 y tener 13 dígitos.",
                dni
            );
        }

        if (
            !/^[a-zA-Z0-9._+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/.test(
                correo.value
            )
        ) {
            return mostrarError(
                "Correo inválido",
                "Ingrese un correo electrónico válido.",
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

        if (!depEmpresa.value) {
            return mostrarError(
                "Departamento requerido",
                "Seleccione un departamento.",
                depEmpresa
            );
        }

        if (!rol.value) {
            return mostrarError("Rol requerido", "Seleccione un rol.", rol);
        }

        if (!tipoUsuario.value) {
            return mostrarError(
                "Tipo de usuario requerido",
                "Seleccione un tipo de usuario.",
                tipoUsuario
            );
        }

        if (!estado.value) {
            return mostrarError(
                "Estado requerido",
                "Seleccione un estado.",
                estado
            );
        }

        if (
            !/^(?!.*([A-Za-zÁÉÍÓÚáéíóúÑñ])\1{2})[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}$/.test(
                cargo.value
            )
        ) {
            return mostrarError(
                "Cargo inválido",
                "Debe contener solo letras y espacios, máximo 50 caracteres y sin repetir más de 3 veces.",
                cargo
            );
        }

        if (!fechaContratacion.value) {
            return mostrarError(
                "Fecha contratación requerida",
                "Seleccione una fecha válida.",
                fechaContratacion
            );
        }

        if (
            parseFloat(salario.value) < 1 ||
            parseFloat(salario.value) > 9999999.99
        ) {
            return mostrarError(
                "Salario inválido",
                "Debe ser mayor o igual a L. 1.00 y menor de L. 9,999,999.99.",
                salario
            );
        }

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        const codEmpleado = data.cod_empleado;

        try {
            const response = await fetch(`/empleados/${codEmpleado}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
                body: formData,
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    title: "Éxito",
                    text: result.mensaje,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => window.location.reload());
            } else {
                throw new Error(
                    result.mensaje || "Error al actualizar empleado"
                );
            }
        } catch (error) {
            Swal.fire({
                title: "Error",
                text: error.message,
                icon: "error",
            });
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

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formNuevoEmpleado");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        limpiarErrores();

        const nombre = document.getElementById("nuevo_nombre_persona");
        const dni = document.getElementById("nuevo_dni");
        const cargo = document.getElementById("nuevo_cargo");
        const telefono = document.getElementById("nuevo_telefono");
        const salario = document.getElementById("nuevo_salario");
        const fechaNac = document.getElementById("fecha_nacimiento");

        if (
            !/^(?!.*([A-Za-zÁÉÍÓÚáéíóúÑñ])\1{3,})([A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:\s+[A-Za-zÁÉÍÓÚáéíóúÑñ]+)+)$/.test(
                nombre.value.trim()
            )
        ) {
            return mostrarError(
                "Nombre inválido",
                "Debe contener al menos nombre y apellido, sin más de 3 letras repetidas seguidas.",
                nombre
            );
        }

        if (!/^0\d{3}-\d{4}-\d{5}$/.test(dni.value)) {
            return mostrarError(
                "DNI inválido",
                "Debe iniciar con 0 y tener el formato 0000-0000-00000.",
                dni
            );
        }

        if (!/^[983](?!.*(\d)\1{3})\d{7}$/.test(telefono.value)) {
            return mostrarError(
                "Teléfono inválido",
                "Debe tener 8 dígitos, iniciar con 9, 8 o 3, y no repetir un número más de 3 veces seguidas.",
                telefono
            );
        }

        if (
            !/^(?!.*([A-Za-zÁÉÍÓÚáéíóúÑñ])\1{2})[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}$/.test(
                cargo.value
            )
        ) {
            return mostrarError(
                "Cargo inválido",
                "Debe contener solo letras y espacios, sin repetir la misma letra más de 3 veces consecutivas.",
                cargo
            );
        }

        const fechaLimite = new Date();
        fechaLimite.setFullYear(fechaLimite.getFullYear() - 18);
        if (new Date(fechaNac.value) > fechaLimite || !fechaNac.value) {
            return mostrarError(
                "Fecha inválida",
                "El empleado debe ser mayor de 18 años.",
                fechaNac
            );
        }

        if (!salario.value || parseFloat(salario.value) < 12539.68) {
            return mostrarError(
                "Salario inválido",
                "Debe ser mayor o igual al salario mínimo de Honduras (L. 12,539.68).",
                salario
            );
        }

        dni.value = dni.value.replace(/-/g, '');
        const datos = new FormData(form);
        const data = Object.fromEntries(datos.entries());

        try {
            const response = await fetch("/empleados", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (result.success) {
                document.getElementById("nuevo_nombre_usuario").value =
                    result.usuario_generado;
                document.getElementById("nuevo_contrasena").value =
                    result.contrasena_generada;

                Swal.fire({
                    icon: "success",
                    title: "Empleado registrado",
                    text: "El nuevo empleado ha sido registrado correctamente.",
                    confirmButtonText: "OK",
                }).then(() => {
                    location.reload();
                });
            } else {
                throw new Error(result.mensaje || "Error al registrar");
            }
        } catch (err) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: err.message,
            });
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

    function limpiarErrores() {
        form.querySelectorAll(".is-invalid").forEach((el) =>
            el.classList.remove("is-invalid")
        );
    }
});

document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("btnExportarExcel")
        ?.addEventListener("click", function (e) {
            e.preventDefault();
            window.location.href = "/empleados/exportar/excel";
        });

    document
        .getElementById("btnExportarPDF")
        ?.addEventListener("click", function (e) {
            e.preventDefault();
            window.open("/empleados/exportar/pdf", "_blank");
        });
});

document.addEventListener("click", function (e) {
    if (
        e.target.classList.contains("btn-detalles") ||
        e.target.closest(".btn-detalles")
    ) {
        const btn = e.target.classList.contains("btn-detalles")
            ? e.target
            : e.target.closest(".btn-detalles");
        const row = btn.closest("tr");
        const empleadoData = JSON.parse(
            row.querySelector(".data-empleado").dataset.empleado
        );
        mostrarDetallesEmpleado(empleadoData);
    }

    if (
        e.target.classList.contains("btn-editar") ||
        e.target.closest(".btn-editar")
    ) {
        const btn = e.target.classList.contains("btn-editar")
            ? e.target
            : e.target.closest(".btn-editar");
        const row = btn.closest("tr");
        const empleadoData = JSON.parse(
            row.querySelector(".data-empleado").dataset.empleado
        );
        mostrarFormularioEdicion(empleadoData);
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formEditarEmpleado");
    const correo = document.getElementById("edit_correo");

    correo.addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-Z0-9@._-]/g, "");
    });

    form.addEventListener("submit", function (e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add("was-validated");
    });
});

document.querySelectorAll("#tablaEmpleados tbody tr").forEach(function (fila) {
    const dataEmpleadoInput = fila.querySelector(".data-empleado");
    if (dataEmpleadoInput) {
        const empleado = JSON.parse(dataEmpleadoInput.dataset.empleado);
        if (empleado.estado == 0) {
            fila.classList.add("fila-inactiva");
        }
    }
});

document.getElementById("btnAplicarFiltros").addEventListener("click", () => {
    const rol = document.getElementById("filtroRol").value.toLowerCase();
    const departamento = document
        .getElementById("filtroDepartamento")
        .value.toLowerCase();
    const estado = document.getElementById("filtroEstado").value.toLowerCase();

    const filas = document.querySelectorAll("#tablaEmpleados tbody tr");

    filas.forEach((fila) => {
        const data = JSON.parse(
            fila.querySelector(".data-empleado").dataset.empleado
        );

        const cumpleRol = !rol || data.rol.toLowerCase() === rol;
        const cumpleDepartamento =
            !departamento ||
            data.departamento_empresa.toLowerCase() === departamento;
        const cumpleEstado =
            !estado || (data.estado == 1 ? "activo" : "inactivo") === estado;

        fila.style.display =
            cumpleRol && cumpleDepartamento && cumpleEstado ? "" : "none";
    });
});

document.getElementById("btnLimpiarFiltros").addEventListener("click", () => {
    // Limpiar selec
    document.getElementById("filtroRol").value = "";
    document.getElementById("filtroDepartamento").value = "";
    document.getElementById("filtroEstado").value = "";

    document.getElementById("busquedaEmpleado").value = "";

    cargarEmpleados();
});

function cargarEmpleados() {
    fetch("/empleados")
        .then((res) => res.json())
        .then((data) => {
            mostrarEmpleados(data);
        })
        .catch((err) => {
            console.error("Error al cargar empleados", err);
        });
}

function limpiarNombre(input) {
    let valor = input.value;

    valor = valor.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, "");

    valor = valor.replace(/([A-Za-zÁÉÍÓÚáéíóúÑñ])\1{3,}/g, "$1$1$1");

    valor = valor.replace(/\s{2,}/g, " ").trimStart();

    input.value = valor;
}
function formatearDNI(input) {
    let valor = input.value.replace(/\D/g, ''); 

    valor = valor.slice(0, 13);

    if (valor.length > 4) valor = valor.slice(0, 4) + '-' + valor.slice(4);
    if (valor.length > 9) valor = valor.slice(0, 9) + '-' + valor.slice(9);

    input.value = valor;
}
function limpiarTelefono(input) {
    let valor = input.value.replace(/[^0-9]/g, "");

    valor = valor.replace(/(\d)\1{3,}/g, (match) => match.slice(0, 3));

    input.value = valor.slice(0, 8);
}
function validarLimiteSalario(input) {
    if (input.value.length > 10) input.value = input.value.slice(0, 10);
}
function limpiarCargo(input) {
    let valor = input.value;

    valor = valor.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');

    valor = valor.replace(/([A-Za-zÁÉÍÓÚáéíóúÑñ])\1{3,}/g, (match) => match.slice(0, 3));

    valor = valor.replace(/\s{2,}/g, ' ');

    valor = valor.slice(0, 50);

    input.value = valor;
}
