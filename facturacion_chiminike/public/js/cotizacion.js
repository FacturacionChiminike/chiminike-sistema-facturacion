let horasExtrasSalonActual = null;
document.addEventListener("DOMContentLoaded", function () {
    //  Mostrar detalles de la cotización aja
    window.mostrarDetalle = function (cod_cotizacion) {
        function formatearFechaEspañol(fechaISO) {
            if (!fechaISO) return "---";

            const meses = [
                "enero",
                "febrero",
                "marzo",
                "abril",
                "mayo",
                "junio",
                "julio",
                "agosto",
                "septiembre",
                "octubre",
                "noviembre",
                "diciembre",
            ];

            const fechaObj = new Date(fechaISO);
            const dia = fechaObj.getDate();
            const mes = meses[fechaObj.getMonth()];
            const año = fechaObj.getFullYear();

            return `${dia} de ${mes} de ${año}`;
        }

        const modal = new bootstrap.Modal(
            document.getElementById("detalleModal")
        );
        console.log("COD:", cod_cotizacion);

        fetch(`/cotizacion/${cod_cotizacion}/detalle`)
            .then((res) => {
                if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);
                return res.json();
            })
            .then((data) => {
                console.log("DATA COTIZACION:", data);
                Swal.close();

                if (!data || !data.cod_cotizacion || !data.productos) {
                    Swal.fire(
                        "Error",
                        "No se encontraron detalles válidos de la cotización.",
                        "error"
                    );
                    return;
                }

                document.getElementById("cotizacion-nombre").innerText =
                    data.nombre_evento ?? "---";
                document.getElementById("cotizacion-cliente").innerText =
                    data.nombre_cliente ?? "---";
                document.getElementById("cotizacion-fecha-evento").innerText =
                    formatearFechaEspañol(data.fecha_programa);
                document.getElementById("cotizacion-hora").innerText =
                    data.hora_programada ?? "---";
                document.getElementById("cotizacion-horas").innerText =
                    data.horas_evento ?? "---";
                document.getElementById("cotizacion-estado").innerText =
                    data.estado ?? "---";

                const tbody = document.getElementById("productos-body");
                tbody.innerHTML = "";
                let totalGeneral = 0;

                if (data.productos.length > 0) {
                    data.productos.forEach((prod) => {
                        const cantidad = parseFloat(prod.cantidad ?? 0);
                        const precioUnitario = parseFloat(
                            prod.precio_unitario ?? 0
                        );
                        const subtotal = cantidad * precioUnitario;
                        const impuesto = subtotal * 0.15;
                        const totalConImpuesto = subtotal + impuesto;

                        totalGeneral += totalConImpuesto;

                        const fila = document.createElement("tr");
                        fila.innerHTML = `
                    <td>${cantidad}</td>
                    <td>${prod.descripcion}</td>
                    <td>L ${precioUnitario.toFixed(2)}</td>
                    <td>L ${impuesto.toFixed(2)}</td>
                    <td>L ${totalConImpuesto.toFixed(2)}</td>
                `;
                        tbody.appendChild(fila);
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="5">Sin productos</td></tr>`;
                }

                document.getElementById(
                    "total-general"
                ).innerText = `L ${totalGeneral.toFixed(2)}`;
                document.getElementById(
                    "btn-generar-pdf"
                ).href = `/cotizaciones/pdf/${data.cod_cotizacion}`;
                document.getElementById("btn-enviar-correo").onclick = () =>
                    enviarCorreoCotizacion(data.cod_cotizacion);

                window.cod_cotizacion_actual = data.cod_cotizacion;
                modal.show();
            })
            .catch((err) => {
                console.error(err);
                Swal.close();
                Swal.fire(
                    "Error",
                    "No se pudo cargar la cotización. Revisa la consola.",
                    "error"
                );
            });
    };

    //  Abrir modal de edición de cotización
    window.abrirModalEditar = function (cod_cotizacion) {
        const modal = new bootstrap.Modal(
            document.getElementById("editarModal")
        );

        fetch(`/cotizacion/${cod_cotizacion}/detalle`)
            .then((res) => {
                if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);
                return res.json();
            })
            .then((data) => {
                Swal.close();

                if (!data || !data.cod_cotizacion) {
                    Swal.fire(
                        "Error",
                        "No se encontraron detalles de la cotización.",
                        "error"
                    );
                    return;
                }

                document.getElementById("edit-cod-cotizacion").value =
                    data.cod_cotizacion;
                document.getElementById("edit-nombre-evento").value =
                    data.nombre_evento ?? "";
                document.getElementById("edit-fecha-programa").value =
                    data.fecha_programa
                        ? data.fecha_programa.substring(0, 10)
                        : "";
                document.getElementById("edit-hora-programada").value =
                    data.hora_programada ?? "";
                document.getElementById("edit-horas-evento").value =
                    data.horas_evento ?? "";
                document.getElementById("edit-cliente").value =
                    data.nombre_cliente ?? "";

                const estadoSelect = document.getElementById("edit-estado");
                estadoSelect.value = data.estado ?? "";
                if (
                    !Array.from(estadoSelect.options).some(
                        (opt) => opt.value === data.estado
                    )
                ) {
                    const option = document.createElement("option");
                    option.value = data.estado;
                    option.textContent =
                        data.estado.charAt(0).toUpperCase() +
                        data.estado.slice(1);
                    option.selected = true;
                    estadoSelect.appendChild(option);
                }

                const tbody = document.getElementById("edit-productos-body");
                tbody.innerHTML = "";
                let productos = data.productos ?? [];

                if (productos.length > 0) {
                    productos.forEach((p) => agregarProductoFila(p));
                } else {
                    tbody.innerHTML = `<tr><td colspan="5">Sin productos</td></tr>`;
                }
                const productoSalon = data.productos.find((p) =>
                    p.descripcion?.toUpperCase().startsWith("SALON ")
                );

                if (productoSalon) {
                    const nombre_salon = productoSalon.descripcion.trim();

                    fetch(
                        `http://localhost:3000/horas-extra-salon/${encodeURIComponent(
                            nombre_salon
                        )}`
                    )
                        .then((res) => res.json())
                        .then((horasExtra) => {
                            horasExtrasSalonActual = horasExtra;
                            console.log(
                                "Horas extra cargadas (edición):",
                                horasExtrasSalonActual
                            );
                        })
                        .catch((err) => {
                            console.error(
                                "Error al obtener horas extra en edición:",
                                err
                            );
                            horasExtrasSalonActual = null;
                        });
                } else {
                    Swal.fire(
                        "Advertencia",
                        "No se encontró el producto tipo salón.",
                        "warning"
                    );
                    horasExtrasSalonActual = null;
                }
                modal.show();
                setTimeout(() => actualizarTotales(), 100);
            })
            .catch((err) => {
                console.error(err);
                Swal.close();
                Swal.fire(
                    "Error",
                    "No se pudo cargar la cotización para edición.",
                    "error"
                );
            });
    };

    //  Agregar fila de producto al modal de ediciónes
    window.agregarProductoFila = function (
        p = { cantidad: "", descripcion: "", precio_unitario: "" }
    ) {
        const tbody = document.getElementById("edit-productos-body");
        if (
            tbody.querySelector("td") &&
            tbody.querySelector("td").colSpan === 5
        ) {
            tbody.innerHTML = "";
        }

        const fila = document.createElement("tr");

        // Construir opciones con selección automática
        let options = '<option value="">Seleccione un producto</option>';
        catalogos.entradas.forEach((item) => {
            options += `<option value="${item.nombre}" data-precio="${
                item.precio
            }" ${item.nombre === p.descripcion ? "selected" : ""}>${
                item.nombre
            }</option>`;
        });
        catalogos.paquetes.forEach((item) => {
            options += `<option value="${item.nombre}" data-precio="${
                item.precio
            }" ${item.nombre === p.descripcion ? "selected" : ""}>${
                item.nombre
            }</option>`;
        });
        catalogos.adicionales.forEach((item) => {
            options += `<option value="${item.nombre}" data-precio="${
                item.precio
            }" ${item.nombre === p.descripcion ? "selected" : ""}>${
                item.nombre
            }</option>`;
        });
        catalogos.inventario.forEach((item) => {
            options += `<option value="${item.nombre}" data-precio="${
                item.precio_unitario
            }" ${item.nombre === p.descripcion ? "selected" : ""}>${
                item.nombre
            }</option>`;
        });
        catalogos.salones.forEach((item) => {
            options += `<option value="${item.nombre}" data-precio-dia="${
                item.precio_dia
            }" data-precio-noche="${item.precio_noche}" ${
                item.nombre === p.descripcion ? "selected" : ""
            }>${item.nombre}</option>`;
        });

        //esto añadi siponiendo que va aqui (cargar datos)
        const esHoraExtra = p.descripcion?.toLowerCase().includes("hora extra");

        if (esHoraExtra) {
            options += `<option value="${p.descripcion}" data-precio="${p.precio_unitario}" selected>${p.descripcion}</option>`;
        }

        fila.innerHTML = `
        <td><input type="number" class="form-control form-control-sm cantidad-input" value="${
            p.cantidad ?? ""
        }" min="1"></td>
        <td>
            <select class="form-select form-select-sm descripcion-select">
                ${options}
            </select>
        </td>
        <td><input type="number" class="form-control form-control-sm precio-input" value="${
            p.precio_unitario ?? ""
        }" readonly></td>
        <td class="total-celda">L 0.00</td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); actualizarTotales();">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;

        tbody.appendChild(fila);

        const cantidadInput = fila.querySelector(".cantidad-input");
        const descripcionSelect = fila.querySelector(".descripcion-select");
        const precioInput = fila.querySelector(".precio-input");

        cantidadInput.addEventListener("input", actualizarTotales);

      descripcionSelect.addEventListener("change", function () {
    const selectedOption =
        descripcionSelect.options[descripcionSelect.selectedIndex];

    if (selectedOption.dataset.precioDia) {
        const nombre_salon = selectedOption.value;

        //  Aquí se carga horas extra para el salón seleccionado
        fetch(
            `http://localhost:3000/horas-extra-salon/${encodeURIComponent(
                nombre_salon
            )}`
        )
            .then((res) => res.json())
            .then((horasExtra) => {
                horasExtrasSalonActual = horasExtra;
            })
            .catch((err) => {
                console.error(
                    "Error al obtener horas extra en edición:",
                    err
                );
                horasExtrasSalonActual = null;
            });

        // Asignar precio sin validar disponibilidad
        Swal.fire({
            title: "Horario del salón",
            text: "Seleccione si es de día o de noche",
            icon: "question",
            showDenyButton: true,
            confirmButtonText: "Día",
            denyButtonText: "Noche",
        }).then((result) => {
            let precio = 0;
            if (result.isConfirmed) {
                precio = parseFloat(selectedOption.dataset.precioDia);
            } else if (result.isDenied) {
                precio = parseFloat(selectedOption.dataset.precioNoche);
            }
            precioInput.value = precio.toFixed(2);
            actualizarTotales();
        });
    } else {
        const precio = parseFloat(selectedOption.dataset.precio) || 0;
        precioInput.value = precio.toFixed(2);
        actualizarTotales();
    }
});


        actualizarTotales();
    };

    window.actualizarTotales = function () {
        const filas = document.querySelectorAll("#edit-productos-body tr");
        const horasEvento =
            parseFloat(document.getElementById("edit-horas-evento")?.value) ||
            0;

        let totalGeneral = 0;

        filas.forEach((fila) => {
            const cantidadInput = fila.querySelector(".cantidad-input");
            const precioInput = fila.querySelector(".precio-input");
            const descSelect = fila.querySelector(".descripcion-select");
            const descInput = fila.querySelector(".descripcion-input");

            const cantidad = parseFloat(cantidadInput?.value) || 0;
            const precioUnitario = parseFloat(precioInput?.value) || 0;
            const descripcion = (descSelect?.value || descInput?.value || "")
                .toLowerCase()
                .trim();

            // Detectar si es un salón base (no hora extra)
            const esSalonBase =
                (descripcion.startsWith("salon") ||
                    descripcion.startsWith("salón")) &&
                !descripcion.includes("hora extra");

            let cantidadFinal = cantidad;
            let subtotal = 0;

            if (esSalonBase) {
                cantidadFinal = 1;
                subtotal = cantidadFinal * precioUnitario;

                // Reflejar visualmente la cantidad
                if (cantidadInput) {
                    cantidadInput.value = cantidadFinal;
                }
            } else {
                subtotal = cantidadFinal * precioUnitario;
            }

            totalGeneral += subtotal;

            // Mostrar total por producto
            const celdaTotal = fila.querySelector(".total-celda");
            if (celdaTotal) {
                celdaTotal.innerText = `L ${subtotal.toFixed(2)}`;
            }
        });

        // Mostrar total general
        const totalGeneralSpan = document.getElementById("edit-total-general");
        if (totalGeneralSpan) {
            totalGeneralSpan.innerText = `L ${totalGeneral.toFixed(2)}`;
        }
    };

    const formEditar = document.getElementById("formEditarCotizacion");

    document
        .getElementById("edit-horas-evento")
        .addEventListener("input", actualizarTotales);

    if (formEditar) {
        formEditar.addEventListener("submit", function (e) {
            e.preventDefault();

            const cod_cotizacion = document.getElementById(
                "edit-cod-cotizacion"
            ).value;
            const nombre_evento =
                document.getElementById("edit-nombre-evento").value;
            const fecha_programa = document.getElementById(
                "edit-fecha-programa"
            ).value;
            const hora_programada = document.getElementById(
                "edit-hora-programada"
            ).value;
            const horas_evento =
                parseInt(document.getElementById("edit-horas-evento").value) ||
                0;
            const estado = document.getElementById("edit-estado").value;

            const productos = [];

            document
                .querySelectorAll("#edit-productos-body tr")
                .forEach((fila) => {
                    const cantidadInput =
                        parseInt(
                            fila.querySelector(".cantidad-input")?.value
                        ) || 0;
                    const descripcionInput =
                        fila.querySelector(".descripcion-select") ||
                        fila.querySelector(".descripcion-input");

                    const descripcion = descripcionInput?.value || "";

                    const precio_unitario =
                        parseFloat(
                            fila.querySelector(".precio-input")?.value
                        ) || 0;

                    let cantidad_final = cantidadInput;
                    let total = 0;

                    const descLower = descripcion.toLowerCase();

                    const esSalonBase =
                        (descLower.startsWith("salon") ||
                            descLower.startsWith("salón")) &&
                        !descLower.includes("hora extra");

                    if (esSalonBase) {
                        cantidad_final = horas_evento;
                        total = horas_evento * precio_unitario;
                    } else {
                        total = cantidadInput * precio_unitario;
                    }

                    if (
                        cantidad_final > 0 &&
                        descripcion.trim() !== "" &&
                        precio_unitario >= 0
                    ) {
                        productos.push({
                            cantidad: cantidad_final,
                            descripcion,
                            precio_unitario,
                            total,
                        });
                    }
                });

            //  Aquí se define el payload correctamente
            const payload = {
                cod_cotizacion,
                nombre_evento,
                fecha_programa,
                hora_programada,
                horas_evento,
                estado,
                productos,
            };

            Swal.fire({
                title: "Actualizando...",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
            });

            fetch(`/cotizacion/${cod_cotizacion}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((data) => {
                    Swal.close();
                    if (data.error) {
                        Swal.fire("Error", data.error, "error");
                    } else {
                        Swal.fire(
                            "¡Éxito!",
                            data.mensaje ??
                                "Cotización actualizada correctamente.",
                            "success"
                        ).then(() => location.reload());
                    }
                })
                .catch((err) => {
                    console.error(err);
                    Swal.close();
                    Swal.fire(
                        "Error",
                        "Ocurrió un error al actualizar la cotización.",
                        "error"
                    );
                });
        });
    } else {
        console.error("No se encontró #formEditarCotizacion en el DOM.");
    }

    //crear bien
    document
        .getElementById("formCrearCotizacion")
        .addEventListener("submit", function (e) {
            e.preventDefault();

            const cod_cliente =
                document.getElementById("cod_cliente").value || null;

            const data = {
                cod_cliente: cod_cliente ? parseInt(cod_cliente) : null,
                nombre: cod_cliente
                    ? null
                    : document.getElementById("nombre").value,
                fecha_nacimiento: cod_cliente
                    ? null
                    : document.getElementById("fecha_nacimiento").value || null,
                sexo: cod_cliente
                    ? null
                    : document.getElementById("sexo").value,
                dni: cod_cliente ? null : document.getElementById("dni").value,
                correo: cod_cliente
                    ? null
                    : document.getElementById("correo").value,
                telefono: cod_cliente
                    ? null
                    : document.getElementById("telefono").value,
                direccion: cod_cliente
                    ? null
                    : document.getElementById("direccion").value,
                cod_municipio: cod_cliente
                    ? null
                    : parseInt(document.getElementById("cod_municipio").value),
                rtn: cod_cliente
                    ? null
                    : document.getElementById("rtn").value || null,
                tipo_cliente: cod_cliente
                    ? null
                    : document.getElementById("tipo_cliente").value,
                evento_nombre: document.getElementById("evento_nombre").value,
                fecha_evento: document.getElementById("fecha_evento").value,
                hora_evento: document.getElementById("hora_evento").value,
                horas_evento: parseInt(
                    document.getElementById("horas_evento").value
                ),
                productos: [],
            };

            // Recoger productos
            document
                .querySelectorAll("#productos-body-crear tr")
                .forEach((fila) => {
                    const cantidadInput = fila.querySelector(".cantidad-input");
                    const descripcionInput =
                        fila.querySelector(".descripcion-select") ||
                        fila.querySelector(".descripcion-input");
                    const precioInput = fila.querySelector(".precio-input");

                    const cantidad = parseInt(cantidadInput?.value) || 0;
                    const descripcion = descripcionInput?.value || "";
                    const precio_unitario = parseFloat(precioInput?.value) || 0;

                    if (
                        cantidad > 0 &&
                        descripcion.trim() !== "" &&
                        precio_unitario >= 0
                    ) {
                        let cantidad_final = cantidad;

                        const descLower = descripcion.toLowerCase();

                        // Solo si es salón base, NO hora extra
                        const esSalonBase =
                            (descLower.startsWith("salon") ||
                                descLower.startsWith("salón")) &&
                            !descLower.includes("hora extra");

                        if (esSalonBase) {
                            const horas =
                                parseInt(
                                    document.getElementById("horas_evento")
                                        .value
                                ) || 0;
                            cantidad_final = horas;

                            // También sincronizar el input visual de cantidad
                            if (cantidadInput) {
                                cantidadInput.value = horas;
                            }
                        }

                        data.productos.push({
                            cantidad: cantidad_final,
                            descripcion,
                            precio_unitario,
                        });
                    }
                });

            Swal.fire({
                title: "Guardando...",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
            });

            fetch("/cotizaciones", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify(data),
            })
                .then((res) => res.json())
                .then((data) => {
                    Swal.close();
                    if (data.error) {
                        Swal.fire("Error", data.error, "error");
                    } else {
                        Swal.fire(
                            "¡Éxito!",
                            data.mensaje ?? "Cotización creada correctamente.",
                            "success"
                        ).then(() => location.reload());
                    }
                })
                .catch((err) => {
                    console.error(err);
                    Swal.close();
                    Swal.fire(
                        "Error",
                        "Error al guardar la cotización.",
                        "error"
                    );
                });
        });
});

function agregarProductoFilaCrear() {
    const tbody = document.getElementById("productos-body-crear");
    if (tbody.querySelector("td") && tbody.querySelector("td").colSpan === 5) {
        tbody.innerHTML = "";
    }

    const fila = document.createElement("tr");

    let options = '<option value="">Seleccione un producto</option>';

    catalogos.entradas.forEach((item) => {
        options += `<option value="${item.nombre}" data-precio="${item.precio}">${item.nombre}</option>`;
    });
    catalogos.paquetes.forEach((item) => {
        options += `<option value="${item.nombre}" data-precio="${item.precio}">${item.nombre}</option>`;
    });
    catalogos.adicionales.forEach((item) => {
        options += `<option value="${item.nombre}" data-precio="${item.precio}">${item.nombre}</option>`;
    });
    catalogos.inventario.forEach((item) => {
        options += `<option value="${item.nombre}" data-precio="${item.precio_unitario}">${item.nombre}</option>`;
    });
    catalogos.salones.forEach((item) => {
        options += `<option value="${item.nombre}" data-precio-dia="${item.precio_dia}" data-precio-noche="${item.precio_noche}">${item.nombre}</option>`;
    });

    fila.innerHTML = `
        <td><input type="number" class="form-control form-control-sm cantidad-input" min="1"></td>
        <td>
            <select class="form-select form-select-sm descripcion-select">
                ${options}
            </select>
        </td>
        <td><input type="number" class="form-control form-control-sm precio-input" readonly></td>
        <td class="total-celda">L 0.00</td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); actualizarTotalesCrear();">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;

    tbody.appendChild(fila);

    const cantidadInput = fila.querySelector(".cantidad-input");
    const descripcionSelect = fila.querySelector(".descripcion-select");
    const precioInput = fila.querySelector(".precio-input");

    cantidadInput.addEventListener("input", actualizarTotalesCrear);

   descripcionSelect.addEventListener("change", function () {
    const selectedOption =
        descripcionSelect.options[descripcionSelect.selectedIndex];

    if (selectedOption.dataset.precioDia) {
        const nombre_salon = selectedOption.value;

        // Cargar horas extra del salón
        fetch(
            `http://localhost:3000/horas-extra-salon/${encodeURIComponent(
                nombre_salon
            )}`
        )
            .then((res) => res.json())
            .then((horasExtra) => {
                console.log(
                    "Horas extra disponibles para",
                    nombre_salon,
                    horasExtra
                );
                horasExtraSalonActual = horasExtra;
            })
            .catch((err) => {
                console.error(
                    "Error al obtener horas extra del salón:",
                    err
                );
            });

        // Asignar precio sin validar disponibilidad
        Swal.fire({
            title: "Horario del salón",
            text: "Seleccione si es de día o de noche",
            icon: "question",
            showDenyButton: true,
            confirmButtonText: "Día",
            denyButtonText: "Noche",
        }).then((result) => {
            let precio = 0;
            if (result.isConfirmed) {
                precio = parseFloat(selectedOption.dataset.precioDia);
            } else if (result.isDenied) {
                precio = parseFloat(selectedOption.dataset.precioNoche);
            }
            precioInput.value = precio.toFixed(2);
            actualizarTotalesCrear();
        });
    } else {
        const precio = parseFloat(selectedOption.dataset.precio) || 0;
        precioInput.value = precio.toFixed(2);
        actualizarTotalesCrear();
    }
});


    actualizarTotalesCrear();
}

function actualizarTotalesCrear() {
    const filas = document.querySelectorAll("#productos-body-crear tr");
    const horasEvento =
        parseFloat(document.getElementById("horas_evento")?.value) || 0;

    let totalGeneral = 0;

    filas.forEach((fila) => {
        const cantidadInput = fila.querySelector(".cantidad-input");
        const precioInput = fila.querySelector(".precio-input");
        const descripcionSelect = fila.querySelector(".descripcion-select");

        const cantidad = parseFloat(cantidadInput?.value) || 0;
        const precio = parseFloat(precioInput?.value) || 0;
        const descripcion = (descripcionSelect?.value || "")
            .toLowerCase()
            .trim();

        const esSalonBase =
            (descripcion.startsWith("salon") ||
                descripcion.startsWith("salón")) &&
            !descripcion.includes("hora extra");

        let cantidadFinal = cantidad;
        let total = 0;

        if (esSalonBase) {
            cantidadFinal = 1;
            total = cantidadFinal * precio;

            if (cantidadInput) {
                cantidadInput.value = cantidadFinal;
            }
        } else {
            total = cantidadFinal * precio;
        }

        totalGeneral += total;

        // Mostrar total por fila
        const celdaTotal = fila.querySelector(".total-celda");
        if (celdaTotal) {
            celdaTotal.innerText = `L ${total.toFixed(2)}`;
        }
    });

    // Mostrar total general
    const totalGeneralSpan = document.getElementById("total-general-crear");
    if (totalGeneralSpan) {
        totalGeneralSpan.innerText = `L ${totalGeneral.toFixed(2)}`;
    }
}

//prueba y erro

function eliminarCotizacion(id) {
    Swal.fire({
        title: "¿Está seguro?",
        text: "Esta acción eliminará la cotización de forma permanente.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/cotizaciones/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Error al eliminar la cotización.");
                    }
                    return response.json();
                })
                .then((data) => {
                    Swal.fire({
                        icon: "success",
                        title: "¡Eliminado!",
                        text: data.mensaje,
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch((error) => {
                    console.error(error);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text:
                            error.message ||
                            "Ocurrió un error al eliminar la cotización.",
                    });
                });
        }
    });
}
const crearCotizacionModal = document.getElementById("crearCotizacionModal");

crearCotizacionModal.addEventListener("shown.bs.modal", () => {
    const btnNuevoCliente = document.getElementById("btnNuevoCliente");
    const camposClienteNuevo = document.getElementById("camposClienteNuevo");
    const selectCodCliente = document.getElementById("cod_cliente");

    // Limpiar selección y ocultar campos al abrir
    camposClienteNuevo.style.display = "none";
    selectCodCliente.value = "";

    btnNuevoCliente.addEventListener("click", () => {
        camposClienteNuevo.style.display = "block";
        selectCodCliente.value = "";
    });

    selectCodCliente.addEventListener("change", () => {
        if (selectCodCliente.value) {
            camposClienteNuevo.style.display = "none";
        }
    });
});

document.addEventListener("change", function (e) {
    if (e.target && e.target.classList.contains("descripcion-select")) {
        const select = e.target;
        const selectedOption = select.options[select.selectedIndex];
        const descripcion = select.value;
        const fila = select.closest("tr");
        const precioInput = fila.querySelector(".precio-input");

        const esHoraExtra = selectedOption.dataset.esHoraExtra === "true";
        const salonNombre = selectedOption.dataset.salon;

        if (esHoraExtra && salonNombre && horasExtrasSalon[salonNombre]) {
            Swal.fire({
                title: "Horario del salón",
                text: "Seleccione si es de día o de noche",
                icon: "question",
                showDenyButton: true,
                confirmButtonText: "Día",
                denyButtonText: "Noche",
            }).then((result) => {
                const data = horasExtrasSalon[salonNombre];
                let precio = 0;

                if (result.isConfirmed) {
                    const dia = data.find(
                        (d) => d.tipo_horario.toLowerCase() === "día"
                    );
                    if (dia) precio = parseFloat(dia.precio_hora_extra);
                } else if (result.isDenied) {
                    const noche = data.find(
                        (n) => n.tipo_horario.toLowerCase() === "noche"
                    );
                    if (noche) precio = parseFloat(noche.precio_hora_extra);
                }

                precioInput.value = precio.toFixed(2);
                actualizarTotalesCrear();
            });
        }
    }
});

function agregarHoraExtra() {
    if (!horasExtraSalonActual || horasExtraSalonActual.length === 0) {
        Swal.fire(
            "Error",
            "Debes seleccionar primero un salón para ver sus horas extra.",
            "warning"
        );
        return;
    }

    const nombre_salon = horasExtraSalonActual[0].nombre_salon;

    Swal.fire({
        title: "Selecciona una hora extra",
        html: `
            <select id="select-hora-extra" class="form-select mb-3">
                <option value="">Selecciona una opción</option>
                ${horasExtraSalonActual
                    .map(
                        (extra) =>
                            `<option value="${
                                extra.tipo_horario
                            }" data-precio="${extra.precio_hora_extra}">
                                Hora Extra - ${
                                    extra.tipo_horario
                                } (${nombre_salon}) - L ${parseFloat(
                                extra.precio_hora_extra
                            ).toFixed(2)}
                            </option>`
                    )
                    .join("")}
            </select>
            <input type="number" id="cantidad-hora-extra" class="form-control" min="1" placeholder="Cantidad de horas">`,
        showCancelButton: true,
        confirmButtonText: "Agregar",
        cancelButtonText: "Cancelar",
        preConfirm: () => {
            const select = document.getElementById("select-hora-extra");
            const cantidad = parseInt(
                document.getElementById("cantidad-hora-extra").value
            );
            const tipo = select.value;
            const precio = parseFloat(
                select.options[select.selectedIndex].dataset.precio
            );

            if (!tipo || isNaN(cantidad) || cantidad <= 0) {
                Swal.showValidationMessage(
                    "Debes seleccionar una hora extra y una cantidad válida"
                );
                return false;
            }

            return { tipo, precio, cantidad };
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const { tipo, precio, cantidad } = result.value;

            // Agregar la fila como producto
            const tbody = document.getElementById("productos-body-crear");
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td><input type="number" class="form-control form-control-sm cantidad-input" min="1" value="${cantidad}"></td>
                <td><input type="text" class="form-control form-control-sm descripcion-input" readonly value="Hora Extra - ${tipo} (${nombre_salon})"></td>
                <td><input type="number" class="form-control form-control-sm precio-input" readonly value="${precio.toFixed(
                    2
                )}"></td>
                <td class="total-celda">L ${(precio * cantidad).toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); actualizarTotalesCrear();">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(fila);
            actualizarTotalesCrear();
        }
    });
}

function agregarHoraExtraEditar() {
    if (!horasExtrasSalonActual || horasExtrasSalonActual.length === 0) {
        Swal.fire(
            "Error",
            "Debes seleccionar primero un salón para ver sus horas extra.",
            "warning"
        );
        return;
    }

    const nombre_salon = horasExtrasSalonActual[0].nombre_salon;

    Swal.fire({
        title: "Selecciona una hora extra",
        html: `
            <select id="select-hora-extra-edit" class="form-select mb-3">
                <option value="">Selecciona una opción</option>
                ${horasExtrasSalonActual
                    .map(
                        (extra) =>
                            `<option value="${
                                extra.tipo_horario
                            }" data-precio="${extra.precio_hora_extra}">
                                Hora Extra - ${
                                    extra.tipo_horario
                                } (${nombre_salon}) - L ${parseFloat(
                                extra.precio_hora_extra
                            ).toFixed(2)}
                            </option>`
                    )
                    .join("")}
            </select>
            <input type="number" id="cantidad-hora-extra-edit" class="form-control" min="1" placeholder="Cantidad de horas">`,
        showCancelButton: true,
        confirmButtonText: "Agregar",
        cancelButtonText: "Cancelar",
        preConfirm: () => {
            const select = document.getElementById("select-hora-extra-edit");
            const cantidad = parseInt(
                document.getElementById("cantidad-hora-extra-edit").value
            );
            const tipo = select.value;
            const precio = parseFloat(
                select.options[select.selectedIndex].dataset.precio
            );

            if (!tipo || isNaN(cantidad) || cantidad <= 0) {
                Swal.showValidationMessage(
                    "Debes seleccionar una hora extra y una cantidad válida"
                );
                return false;
            }

            return { tipo, precio, cantidad };
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const { tipo, precio, cantidad } = result.value;

            const tbody = document.getElementById("edit-productos-body");
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td><input type="number" class="form-control form-control-sm cantidad-input" min="1" value="${cantidad}"></td>
                <td><input type="text" class="form-control form-control-sm descripcion-input" readonly value="Hora Extra - ${tipo} (${nombre_salon})"></td>
                <td><input type="number" class="form-control form-control-sm precio-input" readonly value="${precio.toFixed(
                    2
                )}"></td>
                <td class="total-celda">L ${(precio * cantidad).toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); actualizarTotales();">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(fila);
            actualizarTotales();
        }
    });
}
