document.addEventListener("DOMContentLoaded", function () {
    // Llamada inicial al resumen general
    cargarResumenGeneral();
    cargarDatosIniciales(6);
    cargarResumenPorTipoFactura();
    cargarReporteCotizaciones();
    
    if (document.getElementById('tabla-entradas')) {
        cargarEntradas();
    }
    
    if (document.querySelector('#tabla-inventario tbody')) {
        cargarReporteInventario();
    }

    cargarTotalClientes(); 
    cargarReporteEventos();
    cargarTotalEventos();
    cargarReporteClientes();
    cargarReporteEmpleados();// llama al reporte de empleado :)
    cargarTotalEmpleados();// llama al total empleado
    cargarVentasLunesViernes();// llamaa a las facturas de lunes a viernes 
    cargarVentasWeekend();// ventas que se hicieron del sabado al domingo 
    cargarTotalCotizaciones(); // carga las cotizaciones en un total 
    cargarReporteReservaciones(); // carga el reporte reservaciones 
    cargarTotalReservaciones();// llama a solo las reservaciones 
    cargarFacturasPorDia();// facturas que sehicieron al dia 
    cargarReporteFacturasPorCliente(); // facturas hechas por cliene
     cargarReporteSalonesEstado();// llama a los salones 
    cargarGraficoTipoFactura();
    cargarGraficoCotizacionesEstado();
    cargarGraficoInventario();
    cargarGraficoEventos();
    cargarGraficoClientes();

    // Event listeners para los botones de rango de fechas
    document.querySelectorAll('.btn-date').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-date').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const meses = parseInt(this.dataset.meses);
            cargarDatosIniciales(meses);
        });
    });

    // Código para el botón de resumen por tipo
    const btnResumenTipo = document.getElementById('btn-resumen-tipo');
    if (btnResumenTipo) {
        btnResumenTipo.addEventListener('click', async () => {
            const tabla = document.getElementById('tabla-resumen-tipo');
            const tbody = document.getElementById('tbody-resumen-tipo');

            if (tabla.style.display === 'none') {
                tabla.style.display = 'block';

                try {
                    const res = await axios.get('/api/reportes/facturas/resumen-por-tipo-factura');
                    const resumen = Array.isArray(res.data) ? res.data : [];

                    tbody.innerHTML = '';

                    resumen.forEach(r => {
                        const tr = document.createElement('tr');

                        const tdTipo = document.createElement('td');
                        tdTipo.textContent = r.tipo_factura;

                        const tdCantidad = document.createElement('td');
                        tdCantidad.textContent = r.cantidad;

                        const tdTotal = document.createElement('td');
                        tdTotal.textContent = parseFloat(r.total).toLocaleString('es-HN', {
                            style: 'currency',
                            currency: 'HNL',
                            minimumFractionDigits: 2
                        });

                        tr.appendChild(tdTipo);
                        tr.appendChild(tdCantidad);
                        tr.appendChild(tdTotal);
                        tbody.appendChild(tr);
                    });

                } catch (err) {
                    console.error('Error al obtener resumen por tipo de factura:', err);
                    alert('No se pudo cargar el resumen.');
                }
            } else {
                tabla.style.display = 'none';
            }
        });
    }

    // Script para manejar la visualización de tablas en modal
    document.querySelectorAll('.expand-table-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tableId = this.getAttribute('data-table');
            const table = document.getElementById(tableId);
            
            if (table) {
                const modalTitle = document.getElementById('tableModalLabel');
                const modalBody = document.querySelector('#tableModal .modal-body .table-responsive');
                const modalChartContainer = document.querySelector('#tableModal .modal-body .chart-container');
                
                // Clonar la tabla para mostrarla en el modal
                const clonedTable = table.cloneNode(true);
                clonedTable.classList.add('table', 'table-striped', 'table-bordered');
                
                // Limpiar y actualizar el modal
                modalBody.innerHTML = '';
                modalBody.appendChild(clonedTable);
                
                // Actualizar el título del modal
                modalTitle.textContent = this.parentElement.textContent.trim().replace('Ver en grande', '');
                
                // Crear gráfico correspondiente
                createModalChart(tableId);
                
                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('tableModal'));
                modal.show();
            }
        });
    });
});

function cargarDatosIniciales(meses) {
    const fechaHoy = new Date();
    const fechaInicio = new Date();
    fechaInicio.setMonth(fechaHoy.getMonth() - meses);

    const desde = fechaInicio.toISOString().split('T')[0];
    const hasta = fechaHoy.toISOString().split('T')[0];

    cargarVentasMensuales(desde, hasta);
    cargarTopClientes();
    cargarServiciosPopulares();
    cargarIngresosPorTipo();
}

// Función para cargar el resumen general
function cargarResumenGeneral() {
    fetch('/api/reportes/resumen-general')
        .then(res => res.json())
        .then(data => {
            document.getElementById("totalFacturado").textContent = "Lps " + Number(data.total_facturado).toFixed(2);
            document.getElementById("totalFacturas").textContent = data.total_facturas;

            const lista = document.getElementById("listaPorTipo");
            if (lista) {
                lista.innerHTML = "";

                data.por_tipo.forEach(item => {
                    const li = document.createElement("li");
                    li.innerHTML = `<span>${item.tipo_factura}</span><span>Lps ${Number(item.total).toFixed(2)}</span>`;
                    lista.appendChild(li);
                });
            }
        })
        .catch(err => {
            console.error("Error en resumen general:", err);
        });
}

// Función para cargar total clientes
function cargarTotalClientes() {
    fetch('/api/reportes/total-clientes')
        .then(res => res.json())
        .then(data => {
            const elemento = document.getElementById('totalClientes');
            if (elemento && data?.total_clientes !== undefined) {
                elemento.textContent = data.total_clientes;
            }
        })
        .catch(err => {
            console.error('Error al cargar total de clientes:', err);
        });
}

// Función para cargar total eventos
async function cargarTotalEventos() {
    try {
        const res = await axios.get('/api/reportes/total-eventos');
        const total = res.data.total_eventos || 0;
        const totalEventosElem = document.getElementById('totalEventos');
        if (totalEventosElem) {
            totalEventosElem.textContent = total;
        }
    } catch (error) {
        console.error('Error cargando total de eventos:', error);
    }
}

//carga total reservaciones 
async function cargarTotalReservaciones() {
    try {
        const res = await axios.get('/api/reportes/total-reservaciones');
        const total = res.data.total_reservaciones || 0;
        document.getElementById('totalReservaciones').textContent = total;
    } catch (error) {
        console.error('Error al cargar total de reservaciones:', error);
        document.getElementById('totalReservaciones').textContent = 'Error';
    }
}




function cargarResumenPorTipoFactura() {
    const tbody = document.getElementById("tablaResumenTipoFactura");
    if (!tbody) return;

     fetch("/api/reportes/facturas/resumen-por-tipo-factura")
        .then(res => res.json())
        .then(data => {
            tbody.innerHTML = "";

            if (Array.isArray(data)) {
                data.forEach(row => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${row.tipo_factura || 'N/A'}</td>
                        <td>${row.cantidad || 0}</td>
                        <td class="fw-bold" style="color: var(--rosa-neon)">Lps ${Number(row.total || 0).toFixed(2)}</td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        })
        .catch(err => console.error("Error resumen tipo factura:", err));
}

// carga el total empleado :)
async function cargarTotalEmpleados() {
    try {
        const response = await fetch('/api/reportes/total-empleados');
        const data = await response.json();

        if (data && data.length > 0) {
            document.getElementById('total-empleados').textContent = data[0].total_empleados;
        } else {
            document.getElementById('total-empleados').textContent = '0';
        }
    } catch (error) {
        console.error('Error al cargar total de empleados:', error);
        document.getElementById('total-empleados').textContent = 'Error';
    }
}

//carga todos las cotizaciones 
function cargarTotalCotizaciones() {
    fetch('/api/reportes/total-cotizaciones')
        .then(res => res.json())
        .then(data => {
            if (!data || !data.total_cotizado || !data.cantidad_cotizaciones) {
                console.error("Datos inválidos:", data);
                return;
            }

            const totalCotizaciones = parseFloat(data.total_cotizado).toLocaleString('es-HN', {
                style: 'currency',
                currency: 'HNL',
                minimumFractionDigits: 2
            });

            const cantidad = data.cantidad_cotizaciones;

            const contenedor = document.getElementById('total-cotizaciones');
            if (contenedor) {
                contenedor.innerHTML = `
                    <h5 class="text-center fw-bold text-primary">Total Cotizado</h5>
                    <p class="text-center display-6 fw-bold text-success">${totalCotizaciones}</p>
                    <p class="text-center text-muted">Cantidad de Cotizaciones: ${cantidad}</p>
                `;
            }
        })
        .catch(error => {
            console.error("Error al cargar total de cotizaciones:", error);
        });
}


// Función: ventas mensuales 
function cargarVentasMensuales(desde, hasta) {
    const canvas = document.getElementById("graficaVentasMensuales");
    if (!canvas) return;

    // Configuración del canvas
    canvas.style.width = '100%';
    canvas.style.height = '500px';
    
    const ctx = canvas.getContext("2d");

    // Destruir gráfico existente si existe
    if (window.chartVentas) {
        window.chartVentas.destroy();
    }

    fetch(`/api/reportes/ventas-mensuales?desde=${desde}&hasta=${hasta}`)
        .then(res => res.json())
        .then(data => {
            if (!Array.isArray(data)) {
                console.error("Datos de ventas mensuales no son un array:", data);
                return;
            }

            // Procesar datos
            const labels = data.map(e => {
                const partes = e.mes?.split('-') || [];
                const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return partes.length === 2 ? meses[parseInt(partes[1]) - 1] + ' ' + partes[0] : 'N/A';
            });

            const valores = data.map(e => Number(e.total_ventas || 0));

            // Paleta de colores para las barras
            const colores = [
                '#4CAF50', '#8BC34A', '#CDDC39', '#FFC107', '#FF9800', 
                '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#2196F3'
            ];

            window.chartVentas = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Ventas Mensuales",
                        data: valores,
                        backgroundColor: labels.map((_, i) => colores[i % colores.length]),
                        borderColor: '#000000',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Ocultamos la leyenda estándar
                        },
                        title: {
                            display: true,
                            text: 'Ventas Mensuales',
                            color: '#000000',
                            font: {
                                size: 18,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#000000',
                            bodyColor: '#000000',
                            borderColor: '#000000',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y.toLocaleString('es-HN', {
                                        style: 'currency',
                                        currency: 'HNL',
                                        minimumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { 
                                display: false 
                            },
                            ticks: {
                                color: '#000000',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                color: '#000000',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                },
                                callback: value => value.toLocaleString('es-HN', {
                                    style: 'currency',
                                    currency: 'HNL',
                                    minimumFractionDigits: 0
                                })
                            },
                            title: {
                                display: true,
                                text: 'Total de Ventas (Lps)',
                                color: '#000000',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1500
                    }
                }
            });

            // Crear leyenda personalizada con texto en negro
            const leyendaContainer = document.createElement('div');
            leyendaContainer.className = 'chart-legend';
            leyendaContainer.style.display = 'flex';
            leyendaContainer.style.justifyContent = 'center';
            leyendaContainer.style.marginTop = '20px';
            leyendaContainer.style.color = '#000000';
            
            const legendItem = document.createElement('div');
            legendItem.style.display = 'flex';
            legendItem.style.alignItems = 'center';
            legendItem.style.margin = '0 15px';
            
            const colorBox = document.createElement('div');
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.backgroundColor = '#4CAF50';
            colorBox.style.borderRadius = '4px';
            colorBox.style.marginRight = '8px';
            colorBox.style.border = '1px solid #000000';
            
            const label = document.createElement('span');
            label.textContent = 'Ventas Mensuales';
            label.style.fontWeight = 'bold';
            
            legendItem.appendChild(colorBox);
            legendItem.appendChild(label);
            leyendaContainer.appendChild(legendItem);
            
            // Limpiar leyenda anterior si existe
            const oldLegend = canvas.parentElement.querySelector('.chart-legend');
            if (oldLegend) oldLegend.remove();
            
            canvas.parentElement.appendChild(leyendaContainer);
        })
        .catch(err => {
            console.error("Error ventas mensuales:", err);
        });
}

// Función: top clientes (tabla)
async function cargarTopClientes() {
    try {
        const res = await axios.get('/api/reportes/top-clientes');
        const clientes = Array.isArray(res.data) ? res.data : [];

        // Tabla
        const tbody = document.getElementById('tablaTopClientes');
        if (tbody) {
            tbody.innerHTML = '';
            clientes.forEach((c, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}. ${c.cliente || 'N/A'}</td>
                    <td>${c.rtn || 'N/A'}</td>
                    <td>Lps ${parseFloat(c.total_facturado || 0).toFixed(2)}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Gráfico
        const canvas = document.getElementById('graficaTopClientes');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');

        // Destruir gráfico anterior si existe
        if (Chart.getChart(canvas)) {
            Chart.getChart(canvas).destroy();
        }

        window.graficaTopClientes = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: clientes.map(c => c.cliente || 'Cliente'),
                datasets: [{
                    label: 'Total Facturado',
                    data: clientes.map(c => parseFloat(c.total_facturado || 0)),
                    backgroundColor: 'rgba(37, 79, 37, 0.6)',
                    borderColor: 'rgba(37, 79, 37, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { 
                        display: true,
                        labels: {
                            color: '#000000' // Texto en negro
                        }
                    },
                    title: {
                        display: true,
                        text: 'Top Clientes por Facturación',
                        color: '#000000' // Texto en negro
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#000000', // Texto en negro
                        bodyColor: '#000000', // Texto en negro
                        borderColor: '#000000',
                        callbacks: {
                            label: function(context) {
                                return ` ${context.label}: Lps ${context.raw.toFixed(2)}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#000000' // Texto en negro
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#000000', // Texto en negro
                            callback: value => 'Lps ' + value.toLocaleString('es-HN')
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                }
            }
        });

        // Crear leyenda con texto en negro
        const leyendaContainer = document.createElement('div');
        leyendaContainer.className = 'chart-legend';
        leyendaContainer.style.display = 'flex';
        leyendaContainer.style.justifyContent = 'center';
        leyendaContainer.style.marginTop = '15px';
        leyendaContainer.style.color = '#000000'; // Texto en negro
        
        const legendItem = document.createElement('div');
        legendItem.style.display = 'flex';
        legendItem.style.alignItems = 'center';
        legendItem.style.margin = '0 15px';
        
        const colorBox = document.createElement('div');
        colorBox.style.width = '20px';
        colorBox.style.height = '20px';
        colorBox.style.backgroundColor = '#254f25';
        colorBox.style.borderRadius = '4px';
        colorBox.style.marginRight = '8px';
        colorBox.style.border = '1px solid #000000'; // Borde negro
        
        const label = document.createElement('span');
        label.textContent = 'Total Facturado';
        label.style.color = '#000000'; // Texto en negro
        
        legendItem.appendChild(colorBox);
        legendItem.appendChild(label);
        leyendaContainer.appendChild(legendItem);
        
        canvas.parentElement.appendChild(leyendaContainer);

    } catch (err) {
        console.error('Error al cargar top clientes:', err);
        const tbody = document.getElementById('tablaTopClientes');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-danger">Error al cargar datos</td></tr>';
        }
    }
}

//carga los servicios  mas populares 
function cargarServiciosPopulares() {
    const cuerpo = document.getElementById("tablaServiciosPopulares");
    const canvas = document.getElementById("graficaServiciosPopulares");

    if (!cuerpo || !canvas) return;

    fetch("/api/reportes/servicios-populares")
        .then(res => res.json())
        .then(data => {
            cuerpo.innerHTML = "";

            const descripciones = [];
            const cantidades = [];
            const ingresos = [];

            if (Array.isArray(data)) {
                data.forEach(servicio => {
                    descripciones.push(servicio.descripcion || 'Servicio');
                    cantidades.push(parseInt(servicio.total_vendidos || 0));
                    ingresos.push(Number(servicio.ingresos || 0));

                    const fila = `
                        <tr>
                            <td>${servicio.descripcion || 'Servicio'}</td>
                            <td>${servicio.total_vendidos || 0}</td>
                            <td class="fw-bold" style="color: #000000">Lps ${Number(servicio.ingresos || 0).toLocaleString('es-HN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })}</td>
                        </tr>`;
                    cuerpo.innerHTML += fila;
                });
            }

            // Destruir gráfico anterior si existe
            if (Chart.getChart(canvas)) {
                Chart.getChart(canvas).destroy();
            }

            const ctx = canvas.getContext("2d");

            window.graficaServiciosPopulares = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: descripciones,
                    datasets: [{
                        label: 'Ingresos por Servicio',
                        data: ingresos,
                        backgroundColor: '#254f25',
                        borderColor: '#000000',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { 
                            display: true,
                            labels: {
                                color: '#000000', // Texto en negro
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Servicios Más Vendidos',
                            color: '#000000', // Texto en negro
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#000000', // Texto en negro
                            bodyColor: '#000000', // Texto en negro
                            borderColor: '#000000',
                            borderWidth: 1,
                            callbacks: {
                                label: function (context) {
                                    return 'Lps ' + context.raw.toLocaleString('es-HN', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { 
                                color: '#000000', // Texto en negro
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#000000', // Texto en negro
                                callback: value => 'Lps ' + value.toLocaleString('es-HN', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }),
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            title: {
                                display: true,
                                text: 'Total Facturado (Lps)',
                                color: '#000000', // Texto en negro
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });

            // Crear leyenda con texto en negro
            const leyendaContainer = document.createElement('div');
            leyendaContainer.className = 'chart-legend';
            leyendaContainer.style.display = 'flex';
            leyendaContainer.style.justifyContent = 'center';
            leyendaContainer.style.marginTop = '15px';
            leyendaContainer.style.color = '#000000'; // Texto en negro
            
            const legendItem = document.createElement('div');
            legendItem.style.display = 'flex';
            legendItem.style.alignItems = 'center';
            legendItem.style.margin = '0 15px';
            
            const colorBox = document.createElement('div');
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.backgroundColor = '#254f25';
            colorBox.style.borderRadius = '4px';
            colorBox.style.marginRight = '8px';
            colorBox.style.border = '1px solid #000000';
            
            const label = document.createElement('span');
            label.textContent = 'Ingresos por Servicio';
            label.style.fontWeight = 'bold';
            
            legendItem.appendChild(colorBox);
            legendItem.appendChild(label);
            leyendaContainer.appendChild(legendItem);
            
            // Limpiar leyenda anterior si existe
            const oldLegend = canvas.parentElement.querySelector('.chart-legend');
            if (oldLegend) oldLegend.remove();
            
            canvas.parentElement.appendChild(leyendaContainer);
        })
        .catch(err => {
            console.error("Error servicios populares:", err);
            cuerpo.innerHTML = '<tr><td colspan="3" class="text-danger">Error al cargar los datos</td></tr>';
        });
}
z
// Función: ingresos por tipo 
function cargarIngresosPorTipo() {
    fetch("/api/reportes/ingresos-por-tipo")
        .then(res => {
            if (!res.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return res.json();
        })
        .then(data => {
            const labels = Array.isArray(data) ? data.map(item => item.tipo || 'Tipo') : [];
            const valores = Array.isArray(data) ? data.map(item => Number(item.ingresos || 0)) : [];

            if (window.chartTipos && typeof window.chartTipos.destroy === 'function') {
                window.chartTipos.destroy();
            }

            const ctx = document.getElementById("graficaIngresosPorTipo");
            if (!ctx) return;

            const chartCtx = ctx.getContext("2d");

            window.chartTipos = new Chart(chartCtx, {
                type: "doughnut",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Ingresos por Tipo",
                        data: valores,
                        backgroundColor: [
                            "#254f25", "#2f00ffff", "#ff0000ff", "#64cf64", "#00d5ffff"
                        ],
                        borderColor: "rgba(241, 240, 234, 0.2)",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { 
                            position: "bottom", 
                            labels: { 
                                color: "#f1f0ea",
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            } 
                        },
                        tooltip: {
                            backgroundColor: 'rgba(26, 26, 26, 0.95)',
                            bodyFont: {
                                size: 14,
                                color: '#f1f0ea'
                            },
                            titleColor: '#f1f0ea',
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: Lps ${value.toFixed(2)} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Crear leyenda personalizada
            const leyendaContainer = document.createElement('div');
            leyendaContainer.className = 'chart-legend';
            leyendaContainer.style.display = 'flex';
            leyendaContainer.style.flexWrap = 'wrap';
            leyendaContainer.style.justifyContent = 'center';
            leyendaContainer.style.marginTop = '15px';
            leyendaContainer.style.gap = '15px';
            leyendaContainer.style.color = '#f1f0ea';

            labels.forEach((label, index) => {
                const legendItem = document.createElement('div');
                legendItem.style.display = 'flex';
                legendItem.style.alignItems = 'center';
                legendItem.style.margin = '5px 10px';
                
                const colorBox = document.createElement('div');
                colorBox.style.width = '15px';
                colorBox.style.height = '15px';
                colorBox.style.backgroundColor = ["#254f25", "#3a7a3a", "#4fa44f", "#64cf64", "#79f979"][index % 5];
                colorBox.style.borderRadius = '50%';
                colorBox.style.marginRight = '8px';
                colorBox.style.border = '1px solid #f1f0ea';
                
                const labelText = document.createElement('span');
                labelText.textContent = label;
                labelText.style.fontSize = '14px';
                
                legendItem.appendChild(colorBox);
                legendItem.appendChild(labelText);
                leyendaContainer.appendChild(legendItem);
            });

            ctx.parentElement.appendChild(leyendaContainer);
        })
        .catch(err => {
            console.error("Error ingresos por tipo:", err);
            const ctx = document.getElementById("graficaIngresosPorTipo");
            if (ctx) {
                ctx.innerHTML = '<p class="text-danger">Error al cargar los datos</p>';
            }
        });
}

//carga las ventas de lunes a viernes 
function cargarVentasLunesViernes() {
    const canvas = document.getElementById("graficaVentasLunesViernes");
    if (!canvas) return;

    canvas.style.width = '100%';
    canvas.style.height = '500px';

    const ctx = canvas.getContext("2d");

    // Destruir gráfico anterior si existe
    if (window.chartLunesViernes) {
        window.chartLunesViernes.destroy();
    }

    fetch('/api/reportes/ventas-lunes-viernes')
        .then(res => res.json())
        .then(data => {
            if (!Array.isArray(data)) {
                console.error("Datos no válidos:", data);
                return;
            }

            const dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

            // Agrupar por día de semana
            const agrupado = {};
            dias.forEach(d => agrupado[d] = 0);

            data.forEach(e => {
                const diaTraducido = {
                    Monday: 'Lunes',
                    Tuesday: 'Martes',
                    Wednesday: 'Miércoles',
                    Thursday: 'Jueves',
                    Friday: 'Viernes'
                }[e.dia_semana];

                if (agrupado[diaTraducido] !== undefined) {
                    agrupado[diaTraducido] += parseFloat(e.total_pago || 0);
                }
            });

            const labels = Object.keys(agrupado);
            const valores = Object.values(agrupado);

            const colores = ['#4CAF50', '#FFC107', '#03A9F4', '#E91E63', '#9C27B0'];

            window.chartLunesViernes = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Vendido",
                        data: valores,
                        backgroundColor: colores,
                        borderColor: '#000000',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: 'Ventas de Lunes a Viernes',
                            color: '#000000',
                            font: { size: 18, weight: 'bold' },
                            padding: { top: 10, bottom: 20 }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255,255,255,0.95)',
                            titleColor: '#000',
                            bodyColor: '#000',
                            borderColor: '#000',
                            borderWidth: 1,
                            callbacks: {
                                label: ctx => ` Lps ${ctx.parsed.y.toFixed(2)}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#000',
                                font: { size: 12, weight: 'bold' }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.1)' },
                            ticks: {
                                color: '#000',
                                font: { size: 12, weight: 'bold' },
                                callback: v => v.toLocaleString('es-HN', {
                                    style: 'currency',
                                    currency: 'HNL'
                                })
                            },
                            title: {
                                display: true,
                                text: 'Ventas Totales (Lps)',
                                color: '#000',
                                font: { weight: 'bold' }
                            }
                        }
                    },
                    animation: { duration: 1500 }
                }
            });

            // Leyenda personalizada
            const leyendaContainer = document.createElement('div');
            leyendaContainer.className = 'chart-legend';
            leyendaContainer.style.display = 'flex';
            leyendaContainer.style.justifyContent = 'center';
            leyendaContainer.style.marginTop = '20px';
            leyendaContainer.style.color = '#000';

            const legendItem = document.createElement('div');
            legendItem.style.display = 'flex';
            legendItem.style.alignItems = 'center';
            legendItem.style.margin = '0 15px';

            const colorBox = document.createElement('div');
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.backgroundColor = '#4CAF50';
            colorBox.style.borderRadius = '4px';
            colorBox.style.marginRight = '8px';
            colorBox.style.border = '1px solid #000';

            const label = document.createElement('span');
            label.textContent = 'Ventas por Día (L-V)';
            label.style.fontWeight = 'bold';

            legendItem.appendChild(colorBox);
            legendItem.appendChild(label);
            leyendaContainer.appendChild(legendItem);

            const oldLegend = canvas.parentElement.querySelector('.chart-legend');
            if (oldLegend) oldLegend.remove();
            canvas.parentElement.appendChild(leyendaContainer);
        })
        .catch(err => {
            console.error("Error cargando ventas lunes a viernes:", err);
        });
}

  
// ventas que se hicieron de sabado a domingo:3
function cargarVentasWeekend() {
    const canvas = document.getElementById("graficaVentasWeekend");
    if (!canvas) return;

    canvas.style.width = '100%';
    canvas.style.height = '500px';

    const ctx = canvas.getContext("2d");

    // Destruir gráfico anterior si existe
    if (window.chartWeekend) {
        window.chartWeekend.destroy();
    }

    fetch('api/reportes/ventas-weekend')
        .then(res => res.json())
        .then(data => {
            if (!Array.isArray(data)) {
                console.error("Datos inválidos:", data);
                return;
            }

            const dias = ['Sábado', 'Domingo'];
            const agrupado = { 'Sábado': 0, 'Domingo': 0 };

            data.forEach(e => {
                const diaTraducido = {
                    Saturday: 'Sábado',
                    Sunday: 'Domingo',
                    Sábado: 'Sábado',
                    Domingo: 'Domingo'
                }[e.dia_semana];

                if (agrupado[diaTraducido] !== undefined) {
                    agrupado[diaTraducido] += parseFloat(e.total_pago || 0);
                }
            });

            const labels = Object.keys(agrupado);
            const valores = Object.values(agrupado);
            const colores = ['#FF9800', '#4CAF50'];

            window.chartWeekend = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Vendido",
                        data: valores,
                        backgroundColor: colores,
                        borderColor: '#000000',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: 'Ventas Chiminike Weekend',
                            color: '#000000',
                            font: { size: 18, weight: 'bold' },
                            padding: { top: 10, bottom: 20 }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255,255,255,0.95)',
                            titleColor: '#000',
                            bodyColor: '#000',
                            borderColor: '#000',
                            borderWidth: 1,
                            callbacks: {
                                label: ctx => ` Lps ${ctx.parsed.y.toFixed(2)}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#000',
                                font: { size: 12, weight: 'bold' }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.1)' },
                            ticks: {
                                color: '#000',
                                font: { size: 12, weight: 'bold' },
                                callback: v => v.toLocaleString('es-HN', {
                                    style: 'currency',
                                    currency: 'HNL'
                                })
                            },
                            title: {
                                display: true,
                                text: 'Ventas Totales (Lps)',
                                color: '#000',
                                font: { weight: 'bold' }
                            }
                        }
                    },
                    animation: { duration: 1500 }
                }
            });

            // Leyenda personalizada
            const leyendaContainer = document.createElement('div');
            leyendaContainer.className = 'chart-legend';
            leyendaContainer.style.display = 'flex';
            leyendaContainer.style.justifyContent = 'center';
            leyendaContainer.style.marginTop = '20px';
            leyendaContainer.style.color = '#000';

            const legendItem = document.createElement('div');
            legendItem.style.display = 'flex';
            legendItem.style.alignItems = 'center';
            legendItem.style.margin = '0 15px';

            const colorBox = document.createElement('div');
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.backgroundColor = '#FF9800';
            colorBox.style.borderRadius = '4px';
            colorBox.style.marginRight = '8px';
            colorBox.style.border = '1px solid #000';

            const label = document.createElement('span');
            label.textContent = 'Ventas de Sábado y Domingo';
            label.style.fontWeight = 'bold';

            legendItem.appendChild(colorBox);
            legendItem.appendChild(label);
            leyendaContainer.appendChild(legendItem);

            const oldLegend = canvas.parentElement.querySelector('.chart-legend');
            if (oldLegend) oldLegend.remove();
            canvas.parentElement.appendChild(leyendaContainer);
        })
        .catch(err => {
            console.error("Error cargando ventas del fin de semana:", err);
        });
}




// Función para cargar el reporte de cotizaciones
async function cargarReporteCotizaciones() {
    try {
        const res = await axios.get('/api/reportes/cotizaciones');
        const cotizaciones = Array.isArray(res.data) ? res.data : [];

        console.log('Cotizaciones cargadas:', cotizaciones);

        const tbody = document.querySelector('#tabla-cotizaciones tbody');
        if (!tbody) return;

        tbody.innerHTML = '';

        cotizaciones.forEach(c => {
            // Formatear las fechas con JavaScript (usando el objeto Date)
            const fechaFormateada = new Date(c.fecha).toLocaleDateString('es-HN');
            const validezFormateada = new Date(c.fecha_validez).toLocaleDateString('es-HN');
            
            const fila = `
                <tr>
                    <td>${c.cod_cotizacion || 'N/A'}</td>
                    <td>${c.cliente || 'Cliente no registrado'}</td>
                    <td>${c.rtn || 'N/A'}</td>
                    <td>${fechaFormateada || 'N/A'}</td> <!-- Fecha formateada -->
                    <td>${validezFormateada || 'N/A'}</td> <!-- Fecha de validez formateada -->
                    <td>${c.estado || 'N/A'}</td>
                    <td>
                        ${!isNaN(parseFloat(c.total_cotizacion)) 
                            ? `Lps ${parseFloat(c.total_cotizacion).toFixed(2)}`
                            : '<span class="text-danger">N/A</span>'}
                    </td>
                </tr>
            `;
            tbody.innerHTML += fila;
        });

    } catch (error) {
        console.error('Error al cargar cotizaciones:', error);
        const tabla = document.getElementById('tabla-cotizaciones');
        if (tabla) {
            tabla.innerHTML = '<tr><td colspan="7" class="text-danger">Error al cargar las cotizaciones</td></tr>';
        }
    }
}



// Función para cargar el reporte de entradas
async function cargarEntradas() {
    try {
        const res = await fetch('/api/reportes/entradas');
        if (!res.ok) throw new Error('Error en la respuesta del servidor');
        
        const data = await res.json();
        const tbody = document.querySelector('#tabla-entradas tbody');
        
        if (!tbody) return;
        
        tbody.innerHTML = '';

        if (!data || !Array.isArray(data)) {
            tbody.innerHTML = `<tr><td colspan="3" class="text-center">No se encontraron resultados</td></tr>`;
            return;
        }

        data.forEach(e => {
            const fila = `
                <tr>
                    <td>${e.cod_entrada || 'N/A'}</td>
                    <td>${e.descripcion || 'N/A'}</td>
                    <td>Lps ${parseFloat(e.total || 0).toFixed(2)}</td>
                </tr>`;
            tbody.innerHTML += fila;
        });

    } catch (error) {
        console.error('Error al cargar el reporte de entradas:', error);
        const tbody = document.querySelector('#tabla-entradas tbody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-danger">Error al cargar los datos</td></tr>';
        }
    }
}

// Función para cargar gráfico de inventario
async function cargarGraficoInventario() {
    try {
        const res = await axios.get('/api/reportes/inventario');
        const inventario = Array.isArray(res.data) ? res.data : (res.data?.data || []);

        const canvas = document.getElementById('graficaInventario');
        if (!canvas) return;

        // Configurar el canvas para que tome el ancho de la tabla
        canvas.style.width = '100%';
        canvas.style.height = '400px';
        
        const ctx = canvas.getContext('2d');

        // Destruir gráfico anterior si existe
        if (window.graficaInventario) {
            window.graficaInventario.destroy();
        }

        // Extraer y procesar los datos (top 10 items)
        const topItems = inventario
            .filter(item => item.cantidad_disponible !== undefined)
            .sort((a, b) => parseInt(b.cantidad_disponible) - parseInt(a.cantidad_disponible))
            .slice(0, 10);

        const labels = topItems.map(item => item.nombre || 'Sin nombre');
        const cantidades = topItems.map(item => parseInt(item.cantidad_disponible));

        // Paleta de colores vibrantes
        const colores = [
            '#4CAF50', '#2196F3', '#FFC107', '#9C27B0', '#00BCD4',
            '#FF5722', '#607D8B', '#E91E63', '#8BC34A', '#3F51B5'
        ];

        window.graficaInventario = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cantidad en Inventario',
                    data: cantidades,
                    backgroundColor: labels.map((_, i) => colores[i % colores.length]),
                    borderColor: '#000000',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Ocultamos la leyenda estándar
                    },
                    title: {
                        display: true,
                        text: 'Top 10 Productos en Inventario',
                        color: '#000000',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#000000',
                        bodyColor: '#000000',
                        borderColor: '#000000',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return ` ${context.label}: ${context.raw} unidades`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#000000',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#000000',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        title: {
                            display: true,
                            text: 'Cantidad Disponible',
                            color: '#000000',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        // Crear leyenda personalizada con texto en negro
        const leyendaContainer = document.createElement('div');
        leyendaContainer.className = 'chart-legend';
        leyendaContainer.style.display = 'flex';
        leyendaContainer.style.flexWrap = 'wrap';
        leyendaContainer.style.justifyContent = 'center';
        leyendaContainer.style.marginTop = '15px';
        leyendaContainer.style.gap = '15px';
        leyendaContainer.style.color = '#000000';

        // Mostrar leyenda para los primeros 5 items
        const itemsLeyenda = topItems.slice(0, 5);
        itemsLeyenda.forEach((item, index) => {
            const legendItem = document.createElement('div');
            legendItem.style.display = 'flex';
            legendItem.style.alignItems = 'center';
            legendItem.style.margin = '5px 10px';
            
            const colorBox = document.createElement('div');
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.backgroundColor = colores[index % colores.length];
            colorBox.style.borderRadius = '4px';
            colorBox.style.marginRight = '8px';
            colorBox.style.border = '1px solid #000000';
            
            const labelText = document.createElement('span');
            labelText.textContent = item.nombre || 'Producto';
            labelText.style.fontWeight = 'bold';
            
            legendItem.appendChild(colorBox);
            legendItem.appendChild(labelText);
            leyendaContainer.appendChild(legendItem);
        });

        // Limpiar leyenda anterior si existe
        const oldLegend = canvas.parentElement.querySelector('.chart-legend');
        if (oldLegend) oldLegend.remove();
        
        canvas.parentElement.appendChild(leyendaContainer);

    } catch (err) {
        console.error("Error en gráfico de inventario:", err);
        const container = document.querySelector('#graficaInventario')?.parentElement;
        if (container) {
            container.innerHTML = `
                <div class="alert alert-danger py-2">
                    <small>Error al mostrar inventario: ${err.message}</small>
                </div>
            `;
        }
    }
}

// Función para cargar el reporte de inventario (tabla)
async function cargarReporteInventario() {
    try {
        const res = await fetch('/api/reportes/inventario');
        if (!res.ok) throw new Error('Error en la respuesta del servidor');
        
        const responseData = await res.json();
        const data = Array.isArray(responseData) ? responseData : (responseData.data || []);

        const tbody = document.querySelector('#tabla-inventario tbody');
        if (!tbody) return;

        tbody.innerHTML = '';

        if (!data || data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">No hay datos de inventario.</td></tr>`;
            return;
        }

        data.forEach(item => {
            const fila = `
                <tr>
                    <td>${item.cod_inventario || 'N/A'}</td>
                    <td>${item.nombre || 'N/A'}</td>
                    <td>${item.descripcion || 'N/A'}</td>
                    <td>Lps ${parseFloat(item.precio_unitario || 0).toLocaleString('es-HN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })}</td>
                    <td>${parseInt(item.cantidad_disponible || 0).toLocaleString('es-HN')}</td>
                    <td>${item.estado || 'N/A'}</td>
                </tr>`;
            tbody.innerHTML += fila;
        });

        // Asegurarse que el gráfico tenga el mismo ancho que la tabla
        const tabla = document.querySelector('#tabla-inventario');
        const graficoContainer = document.querySelector('#graficaInventario-container');
        if (tabla && graficoContainer) {
            graficoContainer.style.width = tabla.offsetWidth + 'px';
        }

    } catch (error) {
        console.error('Error al cargar el inventario:', error);
        const tbody = document.querySelector('#tabla-inventario tbody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-danger">Error al cargar el inventario</td></tr>';
        }
    }
}

// Llamar ambas funciones cuando se cargue la página
document.addEventListener("DOMContentLoaded", function() {
    cargarReporteInventario();
    cargarGraficoInventario();
});

// Función para cargar reporte de eventos
async function cargarReporteEventos() {
    try {
        const response = await axios.get('/api/reportes/eventos');
        const eventos = Array.isArray(response.data) ? response.data : [];

        const tbody = document.getElementById('tabla-eventos');
        if (!tbody) return;
        
        tbody.innerHTML = '';

        eventos.forEach(e => {
            // Formatear las fechas con JavaScript (usando el objeto Date)
            const fechaFormateada = new Date(e.fecha_programa).toLocaleDateString('es-HN');
            const horaFormateada = e.hora_programada ? e.hora_programada : 'N/A';
            
            const fila = `
                <tr>
                    <td>${e.cod_evento || 'N/A'}</td>
                    <td>${e.nombre || 'N/A'}</td>
                    <td>${fechaFormateada || 'N/A'}</td> <!-- Fecha formateada -->
                    <td>${horaFormateada || 'N/A'}</td> <!-- Hora programada -->
                    <td>${e.cod_cotizacion || 'N/A'}</td>
                    <td>${e.horas_evento || 'N/A'}</td>
                </tr>
            `;
            tbody.innerHTML += fila;
        });

    } catch (error) {
        console.error('Error cargando eventos:', error);
        const tbody = document.getElementById('tabla-eventos');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-danger">Error al cargar eventos</td></tr>';
        }
    }
}


// reporte de reservaciones 
async function cargarReporteReservaciones() {
    try {
        const res = await axios.get('/api/reportes/reservaciones');
        const data = Array.isArray(res.data) ? res.data : [];

        // ─── Renderizar tabla ─────────────────────────────
        const tbody = document.querySelector('#tabla-reservaciones tbody');
        tbody.innerHTML = '';

        data.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td title="${item.nombre_evento}">${item.nombre_evento}</td>
                <td title="${item.fecha_programa.split('T')[0]}">${item.fecha_programa.split('T')[0]}</td>
                <td title="${item.hora_programada}">${item.hora_programada}</td>
                <td title="${item.horas_evento}">${item.horas_evento}</td>
                <td title="${item.cliente}">${item.cliente}</td>
                <td title="${item.rtn || 'N/A'}">${item.rtn || 'N/A'}</td>
            `;
            tbody.appendChild(tr);
        });

        // ─── Renderizar gráfica ──────────────────────────
        const container = document.getElementById("graficaReservacionesContainer");
        container.innerHTML = `
            <div style="width: 100%; height: 100%;">
                <canvas id="graficaReservaciones" style="width: 100% !important; height: 350px !important;"></canvas>
            </div>
        `;
        const canvas = document.getElementById("graficaReservaciones");
        const ctx = canvas.getContext("2d");

        if (window.chartReservaciones) window.chartReservaciones.destroy();

        // Agrupar por fecha
        const agrupado = {};
        data.forEach(e => {
            const fecha = e.fecha_programa.split('T')[0];
            agrupado[fecha] = (agrupado[fecha] || 0) + 1;
        });

        const labels = Object.keys(agrupado).sort();
        const valores = labels.map(fecha => agrupado[fecha]);
        const colores = labels.map((_, i) => `hsl(${(i * 360) / labels.length}, 65%, 55%)`);

        window.chartReservaciones = new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Reservaciones",
                    data: valores,
                    backgroundColor: colores,
                    borderColor: '#000000',
                    borderWidth: 1,
                    borderRadius: 8,
                    barThickness: 28
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Reservaciones por Fecha',
                        color: '#000',
                        font: { size: 18, weight: 'bold' },
                        padding: { top: 10, bottom: 20 }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#000',
                        bodyColor: '#000',
                        borderColor: '#000',
                        borderWidth: 1,
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} reservación(es)`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#000',
                            font: { size: 12, weight: 'bold' },
                            maxRotation: 30,
                            minRotation: 30
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.1)' },
                        ticks: {
                            color: '#000',
                            font: { size: 12, weight: 'bold' },
                            stepSize: 1,
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: 'Cantidad de Reservaciones',
                            color: '#000',
                            font: { weight: 'bold' }
                        }
                    }
                },
                animation: {
                    duration: 800
                },
                layout: {
                    padding: { top: 10, bottom: 10, left: 0, right: 0 }
                }
            }
        });

    } catch (error) {
        console.error('Error al cargar datos de reservaciones:', error);

        const tbody = document.querySelector('#tabla-reservaciones tbody');
        if (tbody) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center">Error al cargar datos de reservaciones</td></tr>`;
        }

        const canvasContainer = document.getElementById("graficaReservacionesContainer");
        if (canvasContainer) {
            canvasContainer.innerHTML = '<p class="text-danger text-center">Error al cargar el gráfico</p>';
        }
    }
}


async function cargarGraficoEventos() {
    try {
        const res = await axios.get('/api/reportes/eventos');
        const eventos = Array.isArray(res.data) ? res.data : [];

        const conteo = {};
        eventos.forEach(e => {
            const tipo = e.nombre?.trim() || 'Sin nombre';
            conteo[tipo] = (conteo[tipo] || 0) + 1;
        });

        const labels = Object.keys(conteo);
        const valores = Object.values(conteo);

        const canvas = document.getElementById("graficaEventos");
        if (!canvas) return;

        const ctx = canvas.getContext("2d");

        if (window.chartEventos) {
            window.chartEventos.destroy();
        }

        // Generar muchos colores automáticamente
        const colores = labels.map((_, i) => `hsl(${(i * 360 / labels.length)}, 70%, 55%)`);

        window.chartEventos = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cantidad de eventos',
                    data: valores,
                    backgroundColor: colores,
                    borderColor: '#000',
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Distribución de Eventos por Tipo',
                        color: '#000',
                        font: {
                            size: 18,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#000',
                        bodyColor: '#000',
                        borderColor: '#000',
                        borderWidth: 1,
                        callbacks: {
                            label: function(ctx) {
                                return `${ctx.label}: ${ctx.raw} evento(s)`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#000',
                            font: {
                                size: 10, // 🔽 fuente más pequeña
                                weight: 'bold'
                            },
                            maxRotation: 45, // 🔽 menos rotación
                            minRotation: 45
                        },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#000',
                            stepSize: 1,
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                },
                layout: {
                    padding: 10
                },
                animation: {
                    duration: 1000
                }
            }
        });

        // Eliminar leyenda personalizada (ya no se necesita con tantos tipos)
        const oldLegend = canvas.parentElement.querySelector('.chart-legend');
        if (oldLegend) oldLegend.remove();

    } catch (error) {
        console.error('Error cargando gráfico de eventos:', error);
    }
}


// Función para cargar reporte de clientes
async function cargarReporteClientes() {
    try {
        const res = await axios.get('/api/reportes/clientes');
        const clientes = Array.isArray(res.data) ? res.data : [];

        const tbody = document.getElementById('tabla-clientes');
        if (!tbody) return;

        tbody.innerHTML = '';

        clientes.forEach(cliente => {
            // Formatear la fecha de nacimiento
            const fechaNacimientoFormateada = cliente.fecha_nacimiento ? new Date(cliente.fecha_nacimiento).toLocaleDateString('es-HN') : 'N/A';

            const fila = `
                <tr>
                    <td>${cliente.cliente || 'N/A'}</td>
                    <td>${cliente.rtn || 'N/A'}</td>
                    <td>${cliente.tipo_cliente || 'N/A'}</td>
                    <td>${cliente.dni || 'N/A'}</td>
                    <td>${cliente.sexo || 'N/A'}</td>
                    <td>${fechaNacimientoFormateada || 'N/A'}</td> <!-- Fecha de nacimiento formateada -->
                </tr>
            `;
            tbody.innerHTML += fila;
        });

    } catch (error) {
        console.error('Error al cargar reporte de clientes:', error);
        const tbody = document.getElementById('tabla-clientes');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-danger">Error al cargar los clientes</td></tr>';
        }
    }
}


// Función para cargar gráfico de clientes
async function cargarGraficoClientes() {
    try {
        const res = await axios.get('/api/reportes/clientes');
        const clientes = Array.isArray(res.data) ? res.data : [];

        const conteoSexo = {};
        clientes.forEach(c => {
            const sexo = c.sexo || 'No definido';
            conteoSexo[sexo] = (conteoSexo[sexo] || 0) + 1;
        });

        const labels = Object.keys(conteoSexo);
        const valores = Object.values(conteoSexo);

        const canvas = document.getElementById("graficaClientes");
        if (!canvas) return;

        const ctx = canvas.getContext("2d");

        if (window.chartClientes) {
            window.chartClientes.destroy();
        }

        window.chartClientes = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Clientes por sexo',
                    data: valores,
                    backgroundColor: [
                        "#15ff15ff", "#00d9ffff", "#dc0000ff", "#fffb00ff", "#ff00b7ff"
                    ],
                    borderColor: "rgba(0, 0, 0, 0.2)", // Cambiado a negro
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Esto permite que el gráfico ocupe todo el ancho
                plugins: {
                    legend: {
                        position: "bottom", 
                        labels: {
                            color: "#000000",  // Cambiado a negro
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Distribución de Clientes por Sexo',
                        color: '#000000' // Cambiado a negro
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)', // Fondo blanco
                        titleColor: '#000000', // Texto negro
                        bodyColor: '#000000', // Texto negro
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#000000' // Cambiado a negro
                        },
                        grid: {
                            display: false // Opcional: eliminar líneas de grid
                        }
                    },
                    y: {
                        ticks: {
                            color: '#000000' // Cambiado a negro
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)' // Líneas de grid más sutiles
                        }
                    }
                }
            }
        });

        // Crear leyenda personalizada debajo del gráfico
        const leyendaContainer = document.createElement('div');
        leyendaContainer.className = 'chart-legend';
        leyendaContainer.style.display = 'flex';
        leyendaContainer.style.flexWrap = 'wrap';
        leyendaContainer.style.justifyContent = 'center';
        leyendaContainer.style.marginTop = '15px';
        leyendaContainer.style.gap = '15px';
        leyendaContainer.style.color = '#000000';

        labels.forEach((label, index) => {
            const legendItem = document.createElement('div');
            legendItem.style.display = 'flex';
            legendItem.style.alignItems = 'center';
            legendItem.style.margin = '5px 10px';
            
            const colorBox = document.createElement('div');
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.backgroundColor = ["#1eff00ff", "#ac0a1fff", "#ff0000ff", "#00d9ffff", "#ff09e6ff"][index % 5];
            colorBox.style.borderRadius = '50%';
            colorBox.style.marginRight = '8px';
            colorBox.style.border = '1px solid #000000ff';
            
            const labelText = document.createElement('span');
            labelText.textContent = label;
            labelText.style.fontSize = '14px';
            labelText.style.color = '#000000'; // Asegurar texto negro
            
            legendItem.appendChild(colorBox);
            legendItem.appendChild(labelText);
            leyendaContainer.appendChild(legendItem);
        });

        // Asegurarse de que el contenedor del canvas tenga el ancho completo
        canvas.parentElement.style.width = '100%';
        canvas.style.width = '100%';
        
        ctx.parentElement.appendChild(leyendaContainer);

    } catch (error) {
        console.error('Error cargando gráfico de clientes:', error);
    }
}



// Función para cargar gráfico de facturación por tipo de factura
async function cargarGraficoTipoFactura() {
    try {
        const res = await axios.get('/api/reportes/facturas/resumen-por-tipo-factura');
        const data = Array.isArray(res.data) ? res.data : [];

        const canvas = document.getElementById("graficaTipoFactura");
        if (!canvas) return;

        // Configuración del canvas
        canvas.style.width = '100%';
        canvas.style.height = 'auto';
        
        const ctx = canvas.getContext("2d");

        // Destruir gráfico anterior si existe
        if (window.chartTipoFactura) {
            window.chartTipoFactura.destroy();
        }

        // Preparar datos
        const labels = data.map(item => item.tipo_factura || 'Sin tipo');
        const valores = data.map(item => Number(item.total || 0));
        const cantidades = data.map(item => Number(item.cantidad || 0));

        // Paleta de colores vibrantes
        const colores = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#8AC24A', '#607D8B', '#E91E63', '#00BCD4'
        ];

        window.chartTipoFactura = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Facturado (Lps)',
                        data: valores,
                        backgroundColor: labels.map((_, i) => colores[i % colores.length]),
                        borderColor: labels.map((_, i) => colores[i % colores.length]),
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Cantidad Emitidas',
                        data: cantidades,
                        backgroundColor: 'rgba(0, 0, 0, 0.1)',
                        borderColor: 'rgba(0, 0, 0, 0.3)',
                        borderWidth: 1,
                        type: 'line',
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#000000',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Facturación por Tipo de Factura',
                        color: '#000000',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#000000',
                        bodyColor: '#000000',
                        borderColor: '#000000',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    if (context.datasetIndex === 0) {
                                        label += 'Lps ' + context.parsed.y.toFixed(2);
                                    } else {
                                        label += context.parsed.y;
                                    }
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#000000',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Total Facturado (Lps)',
                            color: '#000000'
                        },
                        ticks: {
                            color: '#000000',
                            callback: function(value) {
                                return 'Lps ' + value.toLocaleString('es-HN');
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Cantidad Emitidas',
                            color: '#000000'
                        },
                        ticks: {
                            color: '#000000'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });

        // Crear leyenda personalizada
        const leyendaContainer = document.createElement('div');
        leyendaContainer.className = 'chart-legend';
        leyendaContainer.style.display = 'flex';
        leyendaContainer.style.flexWrap = 'wrap';
        leyendaContainer.style.justifyContent = 'center';
        leyendaContainer.style.marginTop = '15px';
        leyendaContainer.style.gap = '15px';
        leyendaContainer.style.color = '#000000';

        labels.forEach((label, index) => {
            const legendItem = document.createElement('div');
            legendItem.style.display = 'flex';
            legendItem.style.alignItems = 'center';
            legendItem.style.margin = '5px 10px';
            
            const colorBox = document.createElement('div');
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.backgroundColor = colores[index % colores.length];
            colorBox.style.borderRadius = '4px';
            colorBox.style.marginRight = '8px';
            colorBox.style.border = '1px solid #000000';
            
            const labelText = document.createElement('span');
            labelText.textContent = label;
            labelText.style.fontSize = '14px';
            labelText.style.fontWeight = 'bold';
            
            legendItem.appendChild(colorBox);
            legendItem.appendChild(labelText);
            leyendaContainer.appendChild(legendItem);
        });

        // Limpiar leyenda anterior si existe
        const oldLegend = canvas.parentElement.querySelector('.chart-legend');
        if (oldLegend) oldLegend.remove();
        
        canvas.parentElement.appendChild(leyendaContainer);

    } catch (error) {
        console.error('Error cargando gráfico de tipo de factura:', error);
        const canvas = document.getElementById("graficaTipoFactura");
        if (canvas) {
            canvas.innerHTML = '<p class="text-danger">Error al cargar el gráfico</p>';
        }
    }
}


// craga el grafico de cotizaciones 
function cargarGraficoCotizacionesEstado() {
    fetch('/api/reportes/cotizaciones')
        .then(res => res.json())
        .then(cotizaciones => {
            const conteo = {};
            const data = Array.isArray(cotizaciones) ? cotizaciones : [];

            data.forEach(c => {
                const estado = c.estado || 'desconocido';
                conteo[estado] = (conteo[estado] || 0) + 1;
            });

            const labels = Object.keys(conteo);
            const valores = Object.values(conteo);

            const canvas = document.getElementById("graficaCotizacionesEstado");
            if (!canvas) return;

            canvas.style.width = '100%';
            canvas.style.height = 'auto';
            const ctx = canvas.getContext("2d");

            if (window.chartCotizacionesEstado) {
                window.chartCotizacionesEstado.destroy();
            }

            const colores = [
                "#4CAF50", "#F44336", "#2196F3", "#FFC107", "#9C27B0",
                "#00BCD4", "#FF5722", "#607D8B", "#8BC34A", "#E91E63"
            ].slice(0, labels.length);

            window.chartCotizacionesEstado = new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: labels,
                    datasets: [{
                        data: valores,
                        backgroundColor: colores,
                        borderColor: "#ffffff",
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            display: false // Desactivamos leyenda nativa
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#000',
                            bodyColor: '#000',
                            borderColor: '#000',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const porcentaje = Math.round((context.raw / total) * 100);
                                    return `${context.label}: ${context.raw} (${porcentaje}%)`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: "Distribución de Cotizaciones por Estado",
                            color: "#000",
                            font: {
                                size: 18,
                                weight: 'bold'
                            },
                            padding: {
                                top: 20,
                                bottom: 10
                            }
                        }
                    }
                }
            });

            // Leyenda personalizada debajo del gráfico
            let contenedor = canvas.parentElement;
            let leyendaAnterior = contenedor.querySelector('.leyenda-cotizaciones');
            if (leyendaAnterior) leyendaAnterior.remove();

            const leyendaContainer = document.createElement('div');
            leyendaContainer.className = 'leyenda-cotizaciones';
            leyendaContainer.style.display = 'flex';
            leyendaContainer.style.flexWrap = 'wrap';
            leyendaContainer.style.justifyContent = 'center';
            leyendaContainer.style.marginTop = '20px';
            leyendaContainer.style.gap = '20px';

            labels.forEach((label, index) => {
                const item = document.createElement('div');
                item.style.display = 'flex';
                item.style.alignItems = 'center';

                const colorBox = document.createElement('div');
                colorBox.style.width = '16px';
                colorBox.style.height = '16px';
                colorBox.style.backgroundColor = colores[index];
                colorBox.style.borderRadius = '4px';
                colorBox.style.marginRight = '8px';
                colorBox.style.border = '1px solid #000';

                const text = document.createElement('span');
                text.textContent = label;
                text.style.fontSize = '14px';
                text.style.color = '#000';
                text.style.fontWeight = 'bold';

                item.appendChild(colorBox);
                item.appendChild(text);
                leyendaContainer.appendChild(item);
            });

            contenedor.appendChild(leyendaContainer);

        })
        .catch(err => {
            console.error("Error al generar gráfica de cotizaciones:", err);
        });
}


// Función para cargar gráfico de inventario
async function cargarGraficoInventario() {
    try {
        const res = await axios.get('/api/reportes/inventario');
        const inventario = Array.isArray(res.data) ? res.data : (res.data?.data || []);

        const canvas = document.getElementById("graficaInventario");
        if (!canvas) return;

        // Ajustar tamaño del canvas
        canvas.style.width = '100%';
        canvas.style.height = 'auto';

        const ctx = canvas.getContext("2d");

        // Destruir gráfico anterior si existe
        if (window.chartInventario) {
            window.chartInventario.destroy();
        }

        // Filtrar y ordenar los ítems con cantidad
        const topItems = inventario
            .filter(item => item.cantidad_disponible !== undefined)
            .sort((a, b) => parseInt(b.cantidad_disponible) - parseInt(a.cantidad_disponible))
            .slice(0, 10);

        const labels = topItems.map(item => item.nombre || 'Sin nombre');
        const cantidades = topItems.map(item => parseInt(item.cantidad_disponible));

        // Colores vibrantes
        const colores = [
            '#4CAF50', '#2196F3', '#FF9800', '#9C27B0', '#F44336',
            '#00BCD4', '#E91E63', '#795548', '#3F51B5', '#009688'
        ];

        // Crear gráfico
        window.chartInventario = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cantidad en Inventario',
                    data: cantidades,
                    backgroundColor: labels.map((_, i) => colores[i % colores.length]),
                    borderColor: labels.map((_, i) => colores[i % colores.length]),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#000000',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Reporte de Inventario',
                        color: '#000000',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#000000',
                        bodyColor: '#000000',
                        borderColor: '#000000',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return `Cantidad: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#000000',
                            font: { weight: 'bold' }
                        },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#000000'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        title: {
                            display: true,
                            text: 'Cantidad',
                            color: '#000000'
                        }
                    }
                }
            }
        });

        // Crear leyenda personalizada
        const leyendaContainer = document.createElement('div');
        leyendaContainer.className = 'chart-legend';
        leyendaContainer.style.display = 'flex';
        leyendaContainer.style.flexWrap = 'wrap';
        leyendaContainer.style.justifyContent = 'center';
        leyendaContainer.style.marginTop = '15px';
        leyendaContainer.style.gap = '15px';
        leyendaContainer.style.color = '#000000';

        labels.forEach((label, index) => {
            const legendItem = document.createElement('div');
            legendItem.style.display = 'flex';
            legendItem.style.alignItems = 'center';
            legendItem.style.margin = '5px 10px';

            const colorBox = document.createElement('div');
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.backgroundColor = colores[index % colores.length];
            colorBox.style.borderRadius = '4px';
            colorBox.style.marginRight = '8px';
            colorBox.style.border = '1px solid #000000';

            const labelText = document.createElement('span');
            labelText.textContent = label;
            labelText.style.fontSize = '14px';
            labelText.style.fontWeight = 'bold';

            legendItem.appendChild(colorBox);
            legendItem.appendChild(labelText);
            leyendaContainer.appendChild(legendItem);
        });

        // Limpiar leyenda anterior si existe
        const oldLegend = canvas.parentElement.querySelector('.chart-legend');
        if (oldLegend) oldLegend.remove();

        canvas.parentElement.appendChild(leyendaContainer);

    } catch (err) {
        console.error("Error en gráfico de inventario:", err);
        const container = document.querySelector('#graficaInventario')?.parentElement;
        if (container) {
            container.innerHTML = `
                <div class="alert alert-danger py-2">
                    <small>Error al mostrar inventario: ${err.message}</small>
                </div>
            `;
        }
    }
}


// Funcion para carga el reporte de empleado 
async function cargarReporteEmpleados() {
    try {
        const response = await fetch('/api/reportes/empleados');
        const empleados = await response.json();

        const tbody = document.getElementById('tabla-reporte-empleados');
        tbody.innerHTML = '';

        empleados.forEach(emp => {
            const fila = `
                <tr>
                    <td>${emp.cod_empleado}</td>
                    <td>${emp.nombre_empleado}</td>
                    <td>${emp.dni}</td>
                    <td>${emp.cargo}</td>
                    <td>L. ${parseFloat(emp.salario).toFixed(2)}</td>
                    <td>${new Date(emp.fecha_contratacion).toLocaleDateString()}</td>
                    <td>${emp.departamento_empresa}</td>
                    <td>${emp.region_departamento}</td>
                    <td>${emp.telefono}</td>
                    <td>${emp.correo}</td>
                    <td>${emp.usuario}</td>
                    <td>${emp.rol}</td>
                    <td>${emp.estado_usuario == 1 ? 'Activo' : 'Inactivo'}</td>
                </tr>
            `;
            tbody.innerHTML += fila;
        });

    } catch (error) {
        console.error('Error al cargar reporte de empleados:', error);
    }
}

//  facruras que se hicieron al mes 
async function cargarFacturasPorDia() {
  try {
    const desde = '2025-07-01';
    const hasta = '2025-07-31';

    const res = await fetch(`/api/reportes/facturas-por-dia?desde=${desde}&hasta=${hasta}`);
    const data = await res.json();

    const tbody = document.getElementById('tabla-facturas-dia');
    tbody.innerHTML = '';

    data.forEach(item => {
      const fecha = new Date(item.dia).toLocaleDateString('es-HN', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
      });

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${fecha}</td>
        <td>${item.cantidad_facturas}</td>
        <td class="text-end">Lps ${parseFloat(item.total_facturado).toFixed(2)}</td>
      `;
      tbody.appendChild(tr);
    });
  } catch (err) {
    console.error('Error al cargar facturas por día:', err);
  }
}

// Factura que hizo cadacliente 
async function cargarReporteFacturasPorCliente() {
    try {
        const res = await fetch('/api/reportes/facturas-por-cliente');
        const data = await res.json();

        const tbody = document.querySelector('#tabla-facturas-cliente');
        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center">No hay datos disponibles.</td></tr>`;
            return;
        }

        data.forEach((item, index) => {
            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.cliente}</td>
                    <td>${item.rtn || 'N/A'}</td>
                    <td>${item.cantidad_facturas}</td>
                    <td>L. ${parseFloat(item.total_facturado).toFixed(2)}</td>
                </tr>
            `;
            tbody.innerHTML += row;
        });

    } catch (error) {
        console.error('Error al cargar reporte de facturas por cliente:', error);
    }
}


//llama a los los saloenes 
async function cargarReporteSalonesEstado() {
    try {
        const res = await fetch('/api/reportes/salones-estado');
        const data = await res.json();

        const tbody = document.querySelector('#tabla-salones-estado');
        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="2" class="text-center">No hay datos disponibles</td></tr>`;
            return;
        }

        data.forEach(item => {
            let estadoTexto = '';
            switch (item.estado) {
                case 1: estadoTexto = 'Disponible'; break;
                case 0: estadoTexto = 'No Disponible'; break;
                default: estadoTexto = 'Otro'; break;
            }

            const fila = `
                <tr>
                    <td>${estadoTexto}</td>
                    <td>${item.cantidad}</td>
                </tr>
            `;
            tbody.innerHTML += fila;
        });
    } catch (error) {
        console.error('Error al cargar reporte de salones:', error);
    }
}
async function cargarReporteEmpleados() {
    try {
        const response = await fetch('/api/reportes/empleados')

        const empleados = await response.json();

        const tbody = document.getElementById('tabla-empleados');
        tbody.innerHTML = '';

        if (!Array.isArray(empleados) || empleados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="13" class="text-center">No hay empleados registrados</td></tr>';
            return;
        }

        empleados.forEach(emp => {
            const fecha = emp.fecha_contratacion
                ? new Date(emp.fecha_contratacion).toLocaleDateString('es-HN')
                : 'N/D';

            const estado = parseInt(emp.estado_usuario) === 1 ? 'Activo' : 'Inactivo';
            const claseEstado = estado === 'Activo' ? 'text-success fw-bold' : 'text-danger fw-bold';
            const claseFila = estado === 'Inactivo' ? 'fila-inactiva' : '';

            const tr = document.createElement('tr');
            tr.className = claseFila;

            tr.innerHTML = `
                <td>${emp.cod_empleado ?? 'N/D'}</td>
                <td>${emp.nombre_empleado ?? 'N/D'}</td>
                <td>${emp.dni ?? 'N/D'}</td>
                <td>${emp.cargo ?? 'N/D'}</td>
                <td>Lps ${parseFloat(emp.salario || 0).toFixed(2)}</td>
                <td>${fecha}</td>
                <td>${emp.departamento_empresa ?? 'N/D'}</td>
                <td>${emp.region_departamento ?? 'N/D'}</td>
                <td>${emp.telefono ?? 'N/D'}</td>
                <td>${emp.correo ?? 'N/D'}</td>
                <td>${emp.usuario ?? 'N/D'}</td>
                <td>${emp.rol ?? 'N/D'}</td>
                <td class="${claseEstado}">${estado}</td>
            `;
            tbody.appendChild(tr);
        });

    } catch (error) {
        console.error('Error al cargar empleados:', error);
        const tbody = document.getElementById('tabla-empleados');
        tbody.innerHTML = '<tr><td colspan="13" class="text-danger text-center">Error al cargar empleados</td></tr>';
    }
}


async function cargarTotalCotizaciones() {
  try {
    const res = await axios.get('/api/reportes/total-cotizaciones');
    const { total_cotizado = 0, cantidad_cotizaciones = 0 } = res.data;
    const tbody = document.getElementById('tablaTotalCotizaciones');
    tbody.innerHTML = `
      <tr>
        <td>Total Cotizado</td>
        <td>${parseFloat(total_cotizado).toLocaleString('es-HN', {
          style: 'currency', currency: 'HNL', minimumFractionDigits: 2
        })}</td>
      </tr>
      <tr>
        <td>Cantidad</td>
        <td>${cantidad_cotizaciones}</td>
      </tr>
    `;
  } catch (err) {
    console.error('Error al cargar cotizaciones:', err);
  }
}

document.addEventListener('DOMContentLoaded', cargarTotalCotizaciones);


function cargarGraficoCotizacionesEstado() {
  fetch('/api/reportes/cotizaciones')
    .then(res => res.json())
    .then(cotizaciones => {
      // 1) Calcular conteo
      const conteo = {};
      const data = Array.isArray(cotizaciones) ? cotizaciones : [];
      data.forEach(c => {
        const estado = c.estado || 'desconocido';
        conteo[estado] = (conteo[estado] || 0) + 1;
      });

      // 2) Extraer labels y valores
      const labels = Object.keys(conteo);
      const valores = Object.values(conteo);

      // 3) Dibujar el gráfico con Chart.js (tu código habitual)
      const canvas = document.getElementById("graficaCotizacionesEstado");
      const ctx = canvas.getContext("2d");
      if (window.chartCotizacionesEstado) {
        window.chartCotizacionesEstado.destroy();
      }
      window.chartCotizacionesEstado = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels,
          datasets: [{ data: valores /* …resto de tu config… */ }]
        },
        options: { /* … */ }
      });

      // 4) **Pintar la tabla** justo aquí, donde 'conteo' existe
      const tbody = document.getElementById('tablaDistribucionCotizaciones');
      if (tbody) {
        tbody.innerHTML = '';
        labels.forEach((estado, i) => {
          const tr = document.createElement('tr');
          tr.innerHTML = `<td>${estado}</td><td>${valores[i] || 0}</td>`;
          tbody.appendChild(tr);
        });
      }
      // — fin del bloque de la tabla —

    })
    .catch(err => console.error('Error cargando distribución de cotizaciones:', err));
}
