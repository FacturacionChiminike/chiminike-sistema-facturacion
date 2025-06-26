document.addEventListener("DOMContentLoaded", () => {
    const { jsPDF } = window.jspdf;

    initComponents();
    animateTableRows();

    // 🔍 Búsqueda en tiempo real
    document.getElementById("searchInput").addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll("#tablaCotizaciones tbody tr");
        rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? "" : "none";
        });
    });

    // 🎯 Filtrado avanzado
    document.getElementById("applyFilters").addEventListener("click", function () {
        const statusFilter = document.getElementById("statusFilter").value;
        const dateFilter = document.getElementById("dateFilter").value;
        const rows = document.querySelectorAll("#tablaCotizaciones tbody tr");

        rows.forEach((row) => {
            const status = row.querySelector("td:nth-child(6)").textContent.toLowerCase();
            const date = row.querySelector("td:nth-child(4)").textContent;
            let show = true;
            if (statusFilter && !status.includes(statusFilter)) show = false;
            if (dateFilter && date !== dateFilter) show = false;
            row.style.display = show ? "" : "none";
        });
    });

    // 📦 Exportar
    document.getElementById("exportPdf").addEventListener("click", exportToPDF);
    document.getElementById("exportExcel").addEventListener("click", exportToExcel);

    // ➕ Nueva cotización
    const nuevaBtn = document.querySelector(".btn-nueva-cotizacion");
    if (nuevaBtn) {
        nuevaBtn.addEventListener("click", function () {
            const modal = new bootstrap.Modal(document.getElementById("nuevaCotizacionModal"));
            modal.show();
        });
    }

    // 📄 Ver detalle usando delegación
    document.addEventListener("click", async function (e) {
        const btn = e.target.closest(".btn-ver-detalle");
        if (!btn) return;

        const id = btn.getAttribute("data-id");
        const contenedor = document.getElementById("detalleCotizacionContenido");

        contenedor.innerHTML = `<div class="text-center text-muted py-4">Cargando detalles...</div>`;

        try {
            console.log("🔍 Buscando detalle para ID:", id);
            const res = await fetch(`/cotizacion/${id}/detalle`);
            const data = await res.json();

            console.log("📥 Respuesta recibida:", data);

            if (res.ok && data.success && data.cotizacion) {
                const datos = {
                    ...data.cotizacion,
                    productos: data.productos
                };
                contenedor.innerHTML = generarContenidoDetalle(datos);
            } else {
                contenedor.innerHTML = `<div class="alert alert-danger">❌ ${data.error || "No se pudo cargar la cotización."}</div>`;
            }
        } catch (error) {
            contenedor.innerHTML = `<div class="alert alert-danger">❌ Error al cargar los detalles.</div>`;
            console.error("❌ Error en fetch:", error);
        }
    });

    function generarContenidoDetalle(data) {
        let html = `
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Cliente:</strong> ${data.nombre_cliente}</li>
                <li class="list-group-item"><strong>Evento:</strong> ${data.nombre_evento}</li>
                <li class="list-group-item"><strong>Fecha del evento:</strong> ${formatearFecha(data.fecha_programa)}</li>
                <li class="list-group-item"><strong>Hora:</strong> ${data.hora_programada}</li>
                <li class="list-group-item"><strong>Estado:</strong> ${capitalizar(data.estado)}</li>
                ${data.fecha_validez ? `<li class="list-group-item"><strong>Validez hasta:</strong> ${formatearFecha(data.fecha_validez)}</li>` : ""}
            </ul>
        `;

        if (data.productos && Array.isArray(data.productos) && data.productos.length > 0) {
            html += `
                <h6 class="mb-2"><i class="bi bi-box-seam me-1"></i>Productos / Servicios</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Descripción</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio Unitario</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            data.productos.forEach((item) => {
                html += `
                    <tr>
                        <td>${item.descripcion}</td>
                        <td class="text-center">${item.cantidad}</td>
                        <td class="text-end">L. ${parseFloat(item.precio_unitario).toFixed(2)}</td>
                        <td class="text-end">L. ${parseFloat(item.total).toFixed(2)}</td>
                    </tr>
                `;
            });

            const totalGeneral = data.productos.reduce((sum, p) => sum + parseFloat(p.total), 0);
            html += `
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-2 fw-bold">
                    Total General: L. ${totalGeneral.toFixed(2)}
                </div>
            `;
        } else {
            html += `<div class="alert alert-info">No hay productos asociados a esta cotización.</div>`;
        }

        return html;
    }

    function exportToPDF() {
        const doc = new jsPDF({ orientation: "landscape", unit: "mm" });
        doc.setFontSize(16);
        doc.setTextColor(40, 40, 40);
        doc.text("Reporte de Cotizaciones - Museo Chiminike", 145, 15, { align: "center" });
        doc.setFontSize(10);
        doc.text(`Generado el: ${new Date().toLocaleDateString()}`, 15, 15);

        const logo = new Image();
        logo.src = "https://via.placeholder.com/60x60?text=MCH";
        doc.addImage(logo, "JPEG", 270, 5, 20, 20);

        doc.autoTable({
            startY: 25,
            html: "#tablaCotizaciones",
            theme: "grid",
            styles: { fontSize: 8, cellPadding: 3, overflow: "linebreak" },
            headStyles: { fillColor: [58, 123, 213], textColor: 255, fontStyle: "bold" },
            alternateRowStyles: { fillColor: [245, 247, 251] },
            margin: { top: 25 }
        });

        doc.save(`Cotizaciones_MCH_${new Date().toISOString().slice(0, 10)}.pdf`);
    }

    function exportToExcel() {
        const table = document.getElementById("tablaCotizaciones");
        const wb = XLSX.utils.table_to_book(table, { sheet: "Cotizaciones" });
        XLSX.writeFile(wb, `Cotizaciones_MCH_${new Date().toISOString().slice(0, 10)}.xlsx`);
    }

    function animateTableRows() {
        const rows = document.querySelectorAll("#tablaCotizaciones tbody tr");
        rows.forEach((row, index) => {
            row.style.opacity = "0";
            row.style.transform = "translateY(10px)";
            setTimeout(() => {
                row.style.transition = "all 0.3s ease";
                row.style.opacity = "1";
                row.style.transform = "translateY(0)";
            }, index * 50);
        });
    }

    function formatearFecha(fecha) {
        if (!fecha) return "";
        return new Date(fecha).toLocaleDateString("es-ES");
    }

    function capitalizar(texto) {
        return texto.charAt(0).toUpperCase() + texto.slice(1);
    }
});
