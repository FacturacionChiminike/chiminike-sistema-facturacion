document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

   let codUsuario = document.querySelector('meta[name="cod-usuario"]').content || null;

// Fallback: si no está en meta, busca en sessionStorage
if (!codUsuario) {
    codUsuario = sessionStorage.getItem("cod_usuario");
}

// Fallback extra: querystring
if (!codUsuario) {
    const params = new URLSearchParams(window.location.search);
    codUsuario = params.get("cod_usuario");
    if (codUsuario) {
        sessionStorage.setItem("cod_usuario", codUsuario);
    }
}


    if (!codUsuario) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudo identificar al usuario. Inicia sesión nuevamente.",
        }).then(() => {
            window.location.href = "/logn";
        });
        return;
    }

   
    document
        .querySelectorAll(".oneinicio-toggle-password")
        .forEach((button) => {
            button.addEventListener("click", function () {
                const input = this.parentElement.querySelector("input");
                const icon = this.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.replace("fa-eye", "fa-eye-slash");
                } else {
                    input.type = "password";
                    icon.classList.replace("fa-eye-slash", "fa-eye");
                }
            });
        });

    const form = document.getElementById("oneinicioForm");

    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const nuevaContrasena = document.getElementById("nueva_contrasena");
            const confirmarContrasena = document.getElementById(
                "confirmar_contrasena"
            );

            const codPregunta1 = document.getElementById("cod_pregunta1").value;
            const respuesta1 = document
                .getElementById("respuesta1")
                .value.trim();
            const codPregunta2 = document.getElementById("cod_pregunta2").value;
            const respuesta2 = document
                .getElementById("respuesta2")
                .value.trim();
            const csrfToken = document.querySelector(
                'input[name="_token"]'
            ).value;

            let isValid = true;

            // Validación contraseñas
            confirmarContrasena.setCustomValidity("");
            nuevaContrasena.setCustomValidity("");

            if (nuevaContrasena.value !== confirmarContrasena.value) {
                confirmarContrasena.setCustomValidity(
                    "Las contraseñas no coinciden"
                );
                isValid = false;
            }

            if (nuevaContrasena.value.length < 8) {
                nuevaContrasena.setCustomValidity(
                    "La contraseña debe tener al menos 8 caracteres"
                );
                isValid = false;
            }

            // Validación preguntas
            if (!codPregunta1 || !codPregunta2) {
                Swal.fire({
                    icon: "warning",
                    title: "Faltan campos",
                    text: "Debe seleccionar ambas preguntas de recuperación",
                });
                return;
            }

            if (codPregunta1 === codPregunta2) {
                Swal.fire({
                    icon: "warning",
                    title: "Preguntas duplicadas",
                    text: "Las preguntas de recuperación no pueden ser iguales",
                });
                return;
            }

            if (!respuesta1 || !respuesta2) {
                Swal.fire({
                    icon: "warning",
                    title: "Faltan campos",
                    text: "Debe ingresar ambas respuestas de recuperación",
                });
                return;
            }

            if (!isValid) {
                confirmarContrasena.reportValidity();
                nuevaContrasena.reportValidity();
                return;
            }

            // Enviar datos al backend
            fetch(form.action, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({
                    cod_usuario: codUsuario, // samos el sessionStorage aquí
                    nueva_contrasena: nuevaContrasena.value,
                    confirmar_contrasena: confirmarContrasena.value,
                    cod_pregunta1: codPregunta1,
                    respuesta1: respuesta1,
                    cod_pregunta2: codPregunta2,
                    respuesta2: respuesta2,
                }),
            })
                .then(async (response) => {
                    if (!response.ok) {
                        const text = await response.text();
                        console.error("Status:", response.status);
                        console.error("Respuesta cruda:", text);

                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "El servidor devolvió un error, revisa la consola para más detalles.",
                        });

                        throw new Error("Error en la respuesta del servidor");
                    }

                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Actualización exitosa",
                            text: "Serás redirigido al login...",
                            timer: 2500,
                            showConfirmButton: false,
                        }).then(() => {
                            sessionStorage.removeItem("cod_usuario"); // Limpieza
                            window.location.href = "/logn";
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text:
                                data.mensaje ||
                                "No se pudo actualizar la información",
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error en el fetch:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Error de red",
                        text: "No se pudo conectar con el servidor, revisa la consola para más detalles.",
                    });
                });
        });
    }

    // Validación en tiempo real de coincidencia de contraseñas
    const confirmarContrasena = document.getElementById("confirmar_contrasena");
    if (confirmarContrasena) {
        confirmarContrasena.addEventListener("input", function () {
            const nuevaContrasena = document.getElementById("nueva_contrasena");
            if (this.value !== nuevaContrasena.value) {
                this.setCustomValidity("Las contraseñas no coinciden");
            } else {
                this.setCustomValidity("");
            }
        });
    }
});
