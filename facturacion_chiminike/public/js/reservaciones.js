window.cod_reservacion_actual = null;

// Mostrar detalles de la reservación
function mostrarDetalle(cod_evento) {
    const modal = new bootstrap.Modal(document.getElementById("detalleModal"));
    const contenido = document.getElementById("detalleContenido");

 window.cod_reservacion_actual = cod_evento;
    contenido.innerHTML = '<p class="text-center">Cargando detalles...</p>';
    console.log("Cargando reservación ID:", cod_evento);
    fetch(`/reservaciones/${cod_evento}`)
        .then(async (res) => {
            if (!res.ok) {
                const errorText = await res.text();
                throw new Error(`Error ${res.status}: ${errorText}`);
            }
            return res.json();
        })
        .then((data) => {
            if (data.mensaje) {
                contenido.innerHTML = `<div class="alert alert-danger">${data.mensaje}</div>`;
                return;
            }

            const evento = data.evento;
            const productos = data.productos || [];

            contenido.innerHTML = `
                <div class="contenedor-modal">
                    <div class="encabezado-modal d-flex justify-content-between align-items-center mb-3">
                        <img src="/img/manologochiminike.jpeg" alt="Logo Chiminike" class="logo-modal">
                        <div class="titulo-modal text-center">
                            <h4 class="mb-0">Museo Chiminike</h4>
                            <p class="mb-0 fw-semibold">Reservación de Evento</p>
                        </div>
                        <img src="/img/manologochiminike.jpeg" alt="Logo Chiminike" class="logo-modal">
                    </div>

                    <div class="datos-evento-modal mb-3">
                        <p><strong>Evento:</strong> ${evento.nombre_evento}</p>
                        <p><strong>Cliente:</strong> ${evento.cliente}</p>
                        <p><strong>Hora de inicio:</strong> ${evento.hora_programada}</p>
                        <p><strong>Horas de evento:</strong> ${evento.horas_evento}</p>
                        <p><strong>Estado:</strong> ${evento.estado}</p>
                    </div>

                    <table class="table table-bordered table-sm text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Cantidad</th>
                                <th>Descripción</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="productos-body"></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th id="total-general">L 0.00</th>
                            </tr>
                        </tfoot>
                    </table>

                    <p class="mensaje-modal mt-2">y aquí un mensaje que bonito</p>

                    <div class="botones-modal d-flex justify-content-center gap-2 mt-3">
                        <button class="btn btn-success btn-sm" onclick="descargarPDF()">Generar PDF</button>
                        <button class="btn btn-primary btn-sm" id="btn-enviar-correo">Enviar por correo</button>
                    </div>
                </div>
            `;

            const tbody = document.getElementById("productos-body");
            tbody.innerHTML = "";
            let total = 0;
            productos.forEach((p) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${p.cantidad}</td>
                    <td>${p.descripcion}</td>
                    <td>L ${parseFloat(p.precio_unitario).toFixed(2)}</td>
                    <td>L ${parseFloat(p.total).toFixed(2)}</td>
                `;
                tbody.appendChild(row);
                total += parseFloat(p.total);
            });
            document.getElementById("total-general").innerText = `L ${total.toFixed(2)}`;

            // ✅ Asignar evento al botón generado dinámicamente
            const btnCorreo = document.getElementById("btn-enviar-correo");
            if (btnCorreo) {
                btnCorreo.addEventListener("click", () => {
                    Swal.fire({
                        title: "Enviando correo...",
                        text: "Espere mientras se envía la reservación al cliente.",
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading(),
                    });

                    fetch(`/reservaciones/${window.cod_reservacion_actual}/enviar-correo`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Accept": "application/json",
                        },
                    })
                        .then(res => res.json())
                        .then(data => {
                            Swal.close();
                            if (data.error) {
                                Swal.fire("Error", data.error, "error");
                            } else {
                                Swal.fire("Éxito", data.mensaje ?? "Correo enviado correctamente.", "success");
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.close();
                            Swal.fire("Error", "Ocurrió un error al enviar el correo.", "error");
                        });
                });
            }

            modal.show();
        })
        .catch((err) => {
            console.error(err);
            contenido.innerHTML = `<div class="alert alert-danger">Error al cargar detalles de la reservación.</div>`;
            Swal.fire(
                "Error",
                "No se pudo cargar la reservación. Revisa la consola.",
                "error"
            );
        });
}


// Descargar PDF
function descargarPDF() {
    if (!codEventoActual) {
        Swal.fire("Atención", "No hay reservación seleccionada.", "warning");
        return;
    }

    fetch(`/reservaciones/pdf/${codEventoActual}`, {
        method: "GET",
        headers: { Accept: "application/pdf" },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("No se pudo generar el PDF.");
            }
            return response.blob();
        })
        .then((blob) => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = `reservacion_${codEventoActual}.pdf`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        })
        .catch((error) => {
            console.error(error);
            Swal.fire("Error", "No se pudo generar el PDF.", "error");
        });
}


// Agregar fila de producto
function agregarProductoFila(
    p = { cantidad: "", descripcion: "", precio_unitario: "" }
) {
    const tbody = document.getElementById("edit-productos-body");
    if (tbody.querySelector("td") && tbody.querySelector("td").colSpan === 5) {
        tbody.innerHTML = "";
    }

    const row = document.createElement("tr");

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

    row.innerHTML = `
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

    tbody.appendChild(row);

    const cantidadInput = row.querySelector(".cantidad-input");
    const descripcionSelect = row.querySelector(".descripcion-select");
    const precioInput = row.querySelector(".precio-input");

    cantidadInput.addEventListener("input", actualizarTotales);

    descripcionSelect.addEventListener("change", function () {
        const selectedOption =
            descripcionSelect.options[descripcionSelect.selectedIndex];

        if (selectedOption.dataset.precioDia) {
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
}

// Actualizar totales dinámicamente
function actualizarTotales() {
    const rows = document.querySelectorAll("#edit-productos-body tr");
    rows.forEach((row) => {
        const cantidad =
            parseFloat(row.querySelector(".cantidad-input").value) || 0;
        const precio =
            parseFloat(row.querySelector(".precio-input").value) || 0;
        const total = cantidad * precio;
        row.querySelector(".total-celda").innerText = `L ${total.toFixed(2)}`;
    });
}

// Listener para recalcular totales en tiempo real
document
    .getElementById("edit-productos-body")
    .addEventListener("input", actualizarTotales);

// Abrir modal de edición con campos llenos
function abrirModalEditar(cod_evento) {
    const modal = new bootstrap.Modal(document.getElementById("editarModal"));

    fetch(`/reservaciones/${cod_evento}`)
        .then(async (res) => {
            if (!res.ok) {
                const errorText = await res.text();
                throw new Error(`Error ${res.status}: ${errorText}`);
            }
            return res.json();
        })
        .then((data) => {
            if (data.mensaje) {
                Swal.fire("Error", data.mensaje, "error");
                return;
            }

            const evento = data.evento;
            const productos = data.productos || [];

            document.getElementById("edit-cod-cotizacion").value =
                evento.cod_evento;
            document.getElementById("edit-nombre-evento").value =
                evento.nombre_evento;
            document.getElementById("edit-fecha-programa").value =
                evento.fecha_programa.substring(0, 10);
            document.getElementById("edit-hora-programada").value =
                evento.hora_programada;
            document.getElementById("edit-horas-evento").value =
                evento.horas_evento;
            document.getElementById("edit-cliente").value = evento.cliente;
            document.getElementById("edit-estado").value = evento.estado;

            const tbody = document.getElementById("edit-productos-body");
            tbody.innerHTML = "";
            productos.forEach((p) => {
                agregarProductoFila({
                    cantidad: p.cantidad,
                    descripcion: p.descripcion,
                    precio_unitario: p.precio_unitario,
                });
            });
            if (productos.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5">Sin productos</td></tr>';
            }

            modal.show();
        })
        .catch((err) => {
            console.error(err);
            Swal.fire(
                "Error",
                "No se pudieron cargar los datos de la reservación.",
                "error"
            );
        });
}

// Actualizar reservación + productos
document
    .getElementById("formEditarReservacion")
    .addEventListener("submit", function (e) {
        e.preventDefault();

       const cod_cotizacion = document.getElementById("edit-cod-cotizacion").value;
        const nombre_evento =
            document.getElementById("edit-nombre-evento").value;
        const fecha_programa = document.getElementById(
            "edit-fecha-programa"
        ).value;
        const hora_programada = document.getElementById(
            "edit-hora-programada"
        ).value;
        const horas_evento = document.getElementById("edit-horas-evento").value;

        const productos = [];
        const rows = document.querySelectorAll("#edit-productos-body tr");
        rows.forEach((row) => {
            const cantidad =
                parseInt(row.querySelector(".cantidad-input").value) || 0;

            // Descripción desde  <select>
            const descripcionSelect = row.querySelector(".descripcion-select");
            const descripcion = descripcionSelect
                ? descripcionSelect.options[descripcionSelect.selectedIndex]
                      .value
                : "";

            // Precio
            const precio_unitario =
                parseFloat(row.querySelector(".precio-input").value) || 0;

            // Total desde celda
            const totalCelda = row.querySelector(".total-celda");
            const totalTexto = totalCelda.textContent.replace("L", "").trim();
            const total = parseFloat(totalTexto) || cantidad * precio_unitario;

            if (
                cantidad > 0 &&
                descripcion.trim() !== "" &&
                precio_unitario >= 0
            ) {
                productos.push({
                    cantidad,
                    descripcion,
                    precio_unitario,
                    total,
                });
            }
        });

        Swal.fire({
            title: "Actualizando...",
            text: "Por favor espera mientras se actualiza la reservación.",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        const estado = document.getElementById("edit-estado").value;

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
            body: JSON.stringify({
                nombre_evento,
                fecha_programa,
                hora_programada,
                horas_evento,
                estado,
                productos,
            }),
        })
            .then((res) => {
                if (!res.ok) throw res;
                return res.json();
            })
            .then((data) => {
                Swal.close();
                if (data.error) {
                    Swal.fire("Error", data.error, "error");
                } else {
                    Swal.fire(
                        "¡Éxito!",
                        data.mensaje ?? "Cotización actualizada correctamente.",
                        "success"
                    ).then(() => location.reload());
                }
            })
            .catch(async (err) => {
                Swal.close();
                let errorMsg = "Ocurrió un error al actualizar la cotización.";
                if (err.json) {
                    const errorData = await err.json();
                    if (errorData.mensaje) errorMsg = errorData.mensaje;
                    if (errorData.errors) {
                        errorMsg += "<ul>";
                        Object.values(errorData.errors).forEach((errArr) => {
                            errArr.forEach((msg) => {
                                errorMsg += `<li>${msg}</li>`;
                            });
                        });
                        errorMsg += "</ul>";
                    }
                }
                console.error(err);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    html: errorMsg,
                });
            });
    });
