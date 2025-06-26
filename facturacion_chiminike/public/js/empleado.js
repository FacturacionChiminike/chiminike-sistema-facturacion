document.addEventListener("DOMContentLoaded", function () {
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Manejar búsqueda con debounce
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

    // Botón nuevo empleado
    document
        .getElementById("btnNuevoEmpleado")
        .addEventListener("click", function () {
            const modal = new bootstrap.Modal(
                document.getElementById("modalNuevoEmpleado")
            );
            modal.show();
        });

    // Exportar a PDF
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
                    // Lógica para exportar a PDF
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

    // Exportar a Excel
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
                    // Lógica para exportar a Excel
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

    // Validación de formulario nuevo empleado
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

    // Delegación de eventos para botones de detalles y edición
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
    // Inputs de texto
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

    // Select: Municipio
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

    // Select: Departamento Empresa
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

    // Select: Rol
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

// Validación del formulario de edición
document
    .getElementById("formEditarEmpleado")
    .addEventListener("submit", async function (e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add("was-validated");
            return;
        }

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        const codEmpleado = data.cod_empleado;

        try {
            const response = await fetch(`/empleados/${codEmpleado}`, {
                method: "PUT",
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

document
    .getElementById("formNuevoEmpleado")
    .addEventListener("submit", async function (e) {
        e.preventDefault();

        const form = e.target;
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
                // Rellenar los campos de usuario y contraseña
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
    // Detectar clic en botón detalles
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

    // Detectar clic en botón editar
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

//filtros

document.getElementById("btnAplicarFiltros").addEventListener("click", () => {
    const rol = document.getElementById("filtroRol").value.toLowerCase();
    const departamento = document.getElementById("filtroDepartamento").value.toLowerCase();
    const estado = document.getElementById("filtroEstado").value.toLowerCase();

    const filas = document.querySelectorAll("#tablaEmpleados tbody tr");

    filas.forEach(fila => {
        const data = JSON.parse(fila.querySelector(".data-empleado").dataset.empleado);

        const cumpleRol = !rol || data.rol.toLowerCase() === rol;
        const cumpleDepartamento = !departamento || data.departamento_empresa.toLowerCase() === departamento;
        const cumpleEstado = !estado || (data.estado == 1 ? "activo" : "inactivo") === estado;

        fila.style.display = (cumpleRol && cumpleDepartamento && cumpleEstado) ? "" : "none";
    });
});


document.getElementById("btnLimpiarFiltros").addEventListener("click", () => {
    // Limpiar selects
    document.getElementById("filtroRol").value = "";
    document.getElementById("filtroDepartamento").value = "";
    document.getElementById("filtroEstado").value = "";

    // Si hay una búsqueda activa, limpiarla también (opcional)
    document.getElementById("busquedaEmpleado").value = "";

    // Volver a cargar todos los empleados
    cargarEmpleados(); // Asumiendo que esta función ya carga todos
});

function cargarEmpleados() {
    fetch("/empleados") // O tu ruta Laravel como API si la usás
        .then(res => res.json())
        .then(data => {
            mostrarEmpleados(data); // Esta sería tu función para renderizar la tabla
        })
        .catch(err => {
            console.error("Error al cargar empleados", err);
        });
}


