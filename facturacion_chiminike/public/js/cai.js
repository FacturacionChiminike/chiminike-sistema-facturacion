document.addEventListener("DOMContentLoaded", () => {
    // Elements
    const tabla = document.getElementById("tablaCai");
    const buscarInput = document.getElementById("buscarCai");
    const formCai = document.getElementById("formCai");
    const modal = new bootstrap.Modal(document.getElementById("caiModal"));
    const submitBtn = document.getElementById("submitBtn");
    const url = "/cai";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Form validation
    function validateForm() {
        let isValid = true;
        const inputs = formCai.querySelectorAll('input[required], select[required]');
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        // Validate date
        const fechaInput = document.getElementById("fecha_limite");
        if (fechaInput.value) {
            const fechaLimite = new Date(fechaInput.value);
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            
            if (fechaLimite < hoy) {
                fechaInput.classList.add('is-invalid');
                fechaInput.nextElementSibling.textContent = "La fecha no puede ser anterior a hoy";
                isValid = false;
            } else {
                fechaInput.classList.remove('is-invalid');
            }
        }

        return isValid;
    }

    // Reset form validation
    function resetValidation() {
        formCai.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }

    // Search filter
    buscarInput.addEventListener("input", () => {
        const filtro = buscarInput.value.toLowerCase();
        Array.from(tabla.rows).forEach(row => {
            const texto = row.textContent.toLowerCase();
            row.style.display = texto.includes(filtro) ? '' : 'none';
        });
    });

    // New CAI button
    document.getElementById("nuevoCaiBtn").addEventListener("click", () => {
        formCai.reset();
        resetValidation();
        document.getElementById("cod_cai").value = "";
        document.getElementById("caiModalLabel").innerHTML = '<i class="bi bi-plus-circle"></i> Nuevo CAI';
        document.getElementById("estado").value = 1;
        modal.show();
    });

    // Form submit
    formCai.addEventListener("submit", async (e) => {
        e.preventDefault();
        
        if (!validateForm()) return;

        const datos = {
            cai: document.getElementById("cai").value.trim(),
            rango_desde: document.getElementById("rango_desde").value.trim(),
            rango_hasta: document.getElementById("rango_hasta").value.trim(),
            fecha_limite: document.getElementById("fecha_limite").value,
            estado: parseInt(document.getElementById("estado").value)
        };

        const cod_cai = document.getElementById("cod_cai").value;
        const metodo = cod_cai ? "PUT" : "POST";
        const ruta = cod_cai ? `${url}/${cod_cai}` : url;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';

        try {
            const response = await fetch(ruta, {
                method: metodo,
                headers: { 
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            if (!response.ok) {
                throw new Error(resultado.mensaje || 'Error en la solicitud');
            }

            await Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: resultado.mensaje,
                timer: 2000,
                showConfirmButton: false
            });

            modal.hide();
            location.reload();
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Ocurrió un error al procesar la solicitud',
                confirmButtonText: 'Entendido'
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-save"></i> Guardar';
        }
    });

    // Edit button
    document.querySelectorAll(".editarBtn").forEach(btn => {
        btn.addEventListener("click", () => {
            formCai.reset();
            resetValidation();
            
            document.getElementById("cod_cai").value = btn.dataset.id;
            document.getElementById("cai").value = btn.dataset.cai;
            document.getElementById("rango_desde").value = btn.dataset.desde;
            document.getElementById("rango_hasta").value = btn.dataset.hasta;
            document.getElementById("fecha_limite").value = btn.dataset.fecha;
            document.getElementById("estado").value = btn.dataset.estado.toString();
            
            document.getElementById("caiModalLabel").innerHTML = '<i class="bi bi-pencil"></i> Editar CAI';
            modal.show();
        });
    });

    // Delete button
    document.querySelectorAll(".eliminarBtn").forEach(btn => {
        btn.addEventListener("click", async () => {
            const cai = btn.dataset.cai;
            
            const { isConfirmed } = await Swal.fire({
                title: `¿Eliminar CAI ${cai}?`,
                text: "Esta acción no se puede deshacer",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            });

            if (!isConfirmed) return;

            try {
                const response = await fetch(`${url}/${btn.dataset.id}`, { 
                    method: "DELETE",
                    headers: { 
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    } 
                });

                const resultado = await response.json();

                if (!response.ok) {
                    throw new Error(resultado.mensaje || 'Error al eliminar');
                }

                await Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
                    text: resultado.mensaje,
                    timer: 2000,
                    showConfirmButton: false
                });

                location.reload();
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Ocurrió un error al eliminar',
                    confirmButtonText: 'Entendido'
                });
            }
        });
    });

    // Hide modal reset
    document.getElementById('caiModal').addEventListener('hidden.bs.modal', () => {
        formCai.reset();
        resetValidation();
    });
});