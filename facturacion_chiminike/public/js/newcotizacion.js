document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("cotizacionForm");
    const productosContainer = document.getElementById("productosContainer");
    const addProductBtn = document.getElementById("addProductBtn");
    const totalLabel = document.getElementById("totalEstimado");
    const loadingSpinner = document.getElementById("loadingSpinner");

    let productIndex = 1;

    // Calcular el total de la cotización
    const calculateTotal = () => {
        let total = 0;
        document.querySelectorAll(".product-item").forEach((item) => {
            const cantidad =
                parseFloat(
                    item.querySelector('input[name*="[cantidad]"]').value
                ) || 0;
            const precio =
                parseFloat(
                    item.querySelector('input[name*="[precio]"]').value
                ) || 0;
            total += cantidad * precio;
        });
        totalLabel.textContent = `L. ${total.toFixed(2)}`;
    };

    // Agregar un nuevo producto
    const addProductItem = () => {
        const newItem = document.createElement("div");
        newItem.className = "product-item card mb-3";
        newItem.dataset.index = productIndex;
        newItem.innerHTML = `
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="form-floating">
                            <select class="form-select" name="productos[${productIndex}][id]" required>
                                <option value="" selected disabled>Seleccione...</option>
                                <option value="1">Entrada General - Adulto</option>
                                <option value="2">Entrada General - Niño</option>
                                <option value="3">Tour Guiado</option>
                                <option value="4">Paquete Familiar</option>
                            </select>
                            <label>Producto/Servicio *</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="productos[${productIndex}][cantidad]" min="1" value="1" required>
                            <label>Cantidad *</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="number" step="0.01" class="form-control" name="productos[${productIndex}][precio]" min="0" required>
                            <label>Precio Unitario *</label>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-product">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" name="productos[${productIndex}][notas]" placeholder="Notas" style="height: 80px"></textarea>
                            <label>Notas (opcional)</label>
                        </div>
                    </div>
                </div>
            </div>
        `;

        productosContainer.appendChild(newItem);
        productIndex++;

        // Mostrar botón de eliminar en todos los items excepto el primero
        updateRemoveButtons();
        calculateTotal();
    };

    // Actualizar visibilidad de botones de eliminar
    const updateRemoveButtons = () => {
        const items = document.querySelectorAll(".product-item");
        items.forEach((item, index) => {
            const removeBtn = item.querySelector(".remove-product");
            if (items.length > 1) {
                removeBtn.style.display = "block";
            } else {
                removeBtn.style.display = "none";
            }
        });
    };

    // Eliminar un producto
    productosContainer.addEventListener("click", (e) => {
        if (e.target.closest(".remove-product")) {
            const item = e.target.closest(".product-item");
            item.remove();
            calculateTotal();
            updateRemoveButtons();
        }
    });

    // Evento para agregar producto
    addProductBtn.addEventListener("click", addProductItem);

    // Evento para calcular total cuando cambian los valores
    productosContainer.addEventListener("input", (e) => {
        if (
            e.target.matches(
                'input[name*="[cantidad]"], input[name*="[precio]"]'
            )
        ) {
            calculateTotal();
        }
    });

    // Envío del formulario
    form.addEventListener("submit", () => {
        loadingSpinner.classList.add("active");
    });

    // Función para mostrar alertas
    const showAlert = (type, title, message) => {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 1100; max-width: 400px;">
                <strong>${title}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        document.body.insertAdjacentHTML("beforeend", alertHtml);

        // Auto-eliminar después de 5 segundos
        setTimeout(() => {
            const alert = document.querySelector(".alert");
            if (alert) alert.remove();
        }, 5000);
    };

    // Inicializar un producto al cargar
    addProductItem();
});

const productos = [];

document.querySelectorAll(".product-item").forEach((item) => {
    const cantidad = item.querySelector('input[name*="[cantidad]"]').value;
    const precio = item.querySelector('input[name*="[precio]"]').value;
    const descripcion =
        item.querySelector('textarea[name*="[notas]"]').value ||
        "Sin descripción";

    productos.push({
        cantidad: parseInt(cantidad),
        descripcion: descripcion,
        precio_unitario: parseFloat(precio),
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("cotizacionForm");
    const btnEnviar = document.getElementById("btnEnviarCotizacion");
    const spinner = document.getElementById("loadingSpinner");

    btnEnviar.addEventListener("click", async () => {
        spinner.classList.add("active");

        const formData = new FormData(form);

        try {
            const response = await fetch("/cotizaciones/guardar", {
                method: "POST",
                headers: {
                    //"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                Swal.fire({
                    icon: "success",
                    title: "Cotización registrada",
                    text:
                        result.mensaje ||
                        "¡La cotización se guardó correctamente!",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                }).then(() => {
                    window.location.href = "/cotizaciones";
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text:
                        result.message ||
                        "Hubo un problema al guardar la cotización",
                });
            }
        } catch (error) {
            console.error("Error al enviar:", error);
            Swal.fire({
                icon: "error",
                title: "Error de conexión",
                text: "No se pudo conectar con el servidor.",
            });
        } finally {
            spinner.classList.remove("active");
        }
    });
});
