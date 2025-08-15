document.addEventListener("DOMContentLoaded", () => {
    // Elementos del DOM
    const formLogin = document.getElementById("loginForm");
    const formRecuperarCorreo = document.getElementById("form-recuperar-correo");
    const formPreguntasUsuario = document.getElementById("form-preguntas-usuario");
    const formResponderPreguntas = document.getElementById("form-responder-preguntas");

    const linkMostrarRecuperar = document.getElementById("mostrar-recuperar");
    const linkVolverLogin = document.getElementById("volver-login");
    const btnRecuperarCorreo = document.getElementById("btn-recuperar-correo");
    const btnRecuperarPreguntas = document.getElementById("btn-recuperar-preguntas");

    const usuarioInput = document.getElementById("usuario");
    const contrasenaInput = document.getElementById("contrasena");
    const correoInput = document.getElementById("correo");
    const usuarioPreguntasInput = document.getElementById("usuario-preguntas");

    const modalPreguntas = new bootstrap.Modal(document.getElementById("modalPreguntas"));
    const preguntasContainer = document.getElementById("preguntas-container");
    const modalCodUsuario = document.getElementById("modal-cod-usuario");

    // Mostrar selector de recuperación
    linkMostrarRecuperar.addEventListener("click", (e) => {
        e.preventDefault();
        formLogin.classList.add("d-none");
        document.getElementById("recuperar-selector").classList.remove("d-none");
    });

    linkVolverLogin.addEventListener("click", (e) => {
        e.preventDefault();
        document.getElementById("recuperar-selector").classList.add("d-none");
        formRecuperarCorreo.classList.add("d-none");
        formPreguntasUsuario.classList.add("d-none");
        formLogin.classList.remove("d-none");
    });

    btnRecuperarCorreo.addEventListener("click", (e) => {
        e.preventDefault();
        document.getElementById("recuperar-selector").classList.add("d-none");
        formRecuperarCorreo.classList.remove("d-none");
        correoInput.focus();
    });

    btnRecuperarPreguntas.addEventListener("click", (e) => {
        e.preventDefault();
        document.getElementById("recuperar-selector").classList.add("d-none");
        formPreguntasUsuario.classList.remove("d-none");
        usuarioPreguntasInput.focus();
    });

    // LOGIN
    formLogin.addEventListener("submit", (e) => {
        e.preventDefault();

        const usuario = usuarioInput.value.trim();
        const contrasena = contrasenaInput.value.trim();

        usuarioInput.classList.remove("is-invalid");
        contrasenaInput.classList.remove("is-invalid");

        if (!usuario) usuarioInput.classList.add("is-invalid");
        if (!contrasena) contrasenaInput.classList.add("is-invalid");

        if (!usuario || !contrasena) {
            return Swal.fire({
                icon: "warning",
                title: "Campos incompletos",
                text: "Por favor complete todos los campos requeridos",
            });
        }

         fetch("/api/autenticar", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ usuario, contrasena }),
        })
        .then((res) => res.json())
        .then((data) => {
            const codUsuario = data.usuario?.cod_usuario || null;
            if (codUsuario) sessionStorage.setItem("cod_usuario", codUsuario);

            // Primer acceso
            if (data.success && data.primer_acceso == 1) {
                let codUsuarioFinal = codUsuario || sessionStorage.getItem("cod_usuario");
    if (codUsuarioFinal) {
        window.location.href = `${data.redirect}?cod_usuario=${codUsuarioFinal}`;
    } else {
        Swal.fire({ icon: "error", title: "Error", text: "No se pudo identificar al usuario." });
    }
    return;
            }

            // 2FA
            if (data.success && data.requiere2FA) {
                Swal.fire({
                    title: "Verificación en dos pasos",
                    html: `
                        <p>${data.mensaje}</p>
                        <input type="text" id="codigo-verificacion" class="swal2-input" maxlength="6" placeholder="Código de verificación">
                        <small class="text-muted">El código expira en 5 minutos</small>
                    `,
                    confirmButtonText: "Verificar",
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        const codigo = document.getElementById("codigo-verificacion").value.trim();
                        if (!codigo || codigo.length !== 6) {
                            Swal.showValidationMessage("El código debe tener 6 dígitos");
                            return false;
                        }
                        return fetch("/verificar-2fa", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                Accept: "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            },
                            body: JSON.stringify({ cod_usuario: codUsuario, codigo }),
                        })
                        .then((res) => {
                            if (!res.ok) throw new Error("Código incorrecto o expirado");
                            return res.json();
                        })
                        .then(() => ({ success: true, redirect: "/dashboard" }))
                        .catch((err) => Swal.showValidationMessage(err.message));
                    },
                }).then((result) => {
                    if (result.isConfirmed && result.value?.redirect) {
                        Swal.fire({ icon: "success", title: "¡Acceso autorizado!", showConfirmButton: false, timer: 1500 })
                        .then(() => window.location.href = result.value.redirect);
                    }
                });
                return;
            }

            // Login normal
            if (data.success) {
                Swal.fire({ icon: "success", title: "¡Bienvenido!", showConfirmButton: false, timer: 1500 })
                .then(() => window.location.href = "/dashboard");
            } else {
                Swal.fire({ icon: "error", title: "Error", text: data.mensaje || "Credenciales incorrectas" });
            }
        })
        .catch((err) => {
            console.error("💥 Error:", err);
            Swal.fire({ icon: "error", title: "Error de conexión", text: "No se pudo conectar al servidor" });
        });
    });


    formRecuperarCorreo.addEventListener("submit", function (e) {
        e.preventDefault();
        const correo = correoInput.value.trim();
        correoInput.classList.remove("is-invalid");

        if (correo === "" || !correo.includes("@")) {
            correoInput.classList.add("is-invalid");
            Swal.fire({
                icon: "error",
                title: "Correo inválido",
                text: "Por favor ingrese una dirección de correo válida",
                showConfirmButton: false,
                timer: 3000,
            });
            return;
        }

        const formData = new FormData();
        formData.append("email", correo);

        fetch(formRecuperarCorreo.action, {
            method: "POST",
            headers: {
                Accept: "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: formData,
        })
            .then(async (res) => {
                const contentType = res.headers.get("content-type") || "";
                const rawText = await res.text();

                console.log("📥 Respuesta cruda:", rawText);

                if (!res.ok) {
                    // Si la respuesta es HTML, no intentes parsearla como JSON
                    if (contentType.includes("text/html")) {
                        throw new Error(
                            "La respuesta no es JSON. Posible error de validación o redirección."
                        );
                    }

                    // Si es JSON pero hay error, parseamos
                    const json = JSON.parse(rawText);
                    console.warn("⚠️ Error recibido:", json);
                    throw new Error(json.message || "Error inesperado");
                }

                const data = JSON.parse(rawText);
                console.log(" Respuesta procesada:", data);

                Swal.fire({
                    icon: "success",
                    title: "Correo enviado",
                    text: data.mensaje || "Revisa tu correo para continuar.",
                    confirmButtonColor: "#28a745",
                }).then(() => {
                    window.location.href = "/logn";
                });
            })
            .catch((err) => {
                console.error(" Error en el fetch:", err);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text:
                        err.message ||
                        "No se pudo enviar el correo. Intenta más tarde.",
                    confirmButtonColor: "#d33",
                });
            });
    });

    formPreguntasUsuario.addEventListener("submit", function (e) {
        e.preventDefault();
        const nombreUsuario = usuarioPreguntasInput.value.trim();

        if (!nombreUsuario) {
            usuarioPreguntasInput.classList.add("is-invalid");
            Swal.fire({
                icon: "warning",
                title: "Campo requerido",
                text: "Debe ingresar el nombre de usuario",
                showConfirmButton: false,
                timer: 3000,
            });
            return;
        }

        fetch("/recuperar-preguntas-usuario", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ usuario: nombreUsuario }),
        })
            .then(async (res) => {
                const contentType = res.headers.get("Content-Type") || "";
                const rawText = await res.text();

                if (!res.ok) {
                    throw new Error("Error en la respuesta del servidor");
                }

                if (!contentType.includes("application/json")) {
                    console.error("Respuesta inesperada:", rawText);
                    throw new Error("La respuesta no es JSON válido");
                }

                return JSON.parse(rawText);
            })
            .then((data) => {
                if (data.success) {
                    preguntasContainer.innerHTML = "";
                    modalCodUsuario.value = data.cod_usuario;

                    data.preguntas.forEach((pregunta, index) => {
                        const formGroup = document.createElement("div");
                        formGroup.classList.add("mb-3");

                        formGroup.innerHTML = `
                    <label class="form-label">${pregunta.pregunta}</label>
                    <input type="hidden" name="cod_pregunta${
                        index + 1
                    }" value="${pregunta.cod_pregunta}">
                    <input type="text" class="form-control" name="respuesta${
                        index + 1
                    }" required>
                `;

                        preguntasContainer.appendChild(formGroup);
                    });

                    const extra = document.createElement("div");
                    extra.innerHTML = `
                <hr>
                <div class="mb-3">
                    <label for="nueva-contrasena" class="form-label">Nueva contraseña</label>
                    <input type="password" class="form-control" name="nueva_contrasena" required>
                </div>
                <div class="mb-3">
                    <label for="confirmar-contrasena" class="form-label">Confirmar contraseña</label>
                    <input type="password" class="form-control" name="confirmar_contrasena" required>
                </div>
            `;
                    preguntasContainer.appendChild(extra);

                    modalPreguntas.show();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.mensaje || "No se encontraron preguntas",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            })
            .catch((error) => {
                console.error("Error en validación:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema. Intenta más tarde.",
                    showConfirmButton: false,
                    timer: 3000,
                });
            });
    });

    formResponderPreguntas.addEventListener("submit", function (e) {
        e.preventDefault();

        const jsonData = {
            cod_usuario: document.getElementById("modal-cod-usuario").value,
            cod_pregunta1: document.querySelector('input[name="cod_pregunta1"]')
                .value,
            respuesta1: document.querySelector('input[name="respuesta1"]')
                .value,
            cod_pregunta2: document.querySelector('input[name="cod_pregunta2"]')
                .value,
            respuesta2: document.querySelector('input[name="respuesta2"]')
                .value,
            nueva_contrasena: document.querySelector(
                'input[name="nueva_contrasena"]'
            ).value,
            confirmar_contrasena: document.querySelector(
                'input[name="confirmar_contrasena"]'
            ).value,
        };

        fetch("/validar-respuestas", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(jsonData),
        })
            .then(async (res) => {
                const contentType = res.headers.get("content-type") || "";

                if (!res.ok || !contentType.includes("application/json")) {
                    const text = await res.text();

                    // Mostrar el HTML crudo si vino una redirección o error
                    console.warn("⚠️ Respuesta inesperada (no JSON):", text);
                    throw new Error("Respuesta inválida del servidor");
                }

                return res.json();
            })
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Contraseña actualizada",
                        text:
                            data.mensaje ||
                            "Ahora puedes iniciar sesión con tu nueva contraseña.",
                        confirmButtonColor: "#28a745",
                    }).then(() => {
                        window.location.href = "/logn";
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Respuestas incorrectas",
                        text:
                            data.mensaje ||
                            "Verifica tus respuestas o intenta nuevamente.",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            })
            .catch((err) => {
                console.error(" Error en validación:", err.message);
                Swal.fire({
                    icon: "error",
                    title: "Error inesperado",
                    text: err.message || "No se pudo procesar la solicitud.",
                    confirmButtonColor: "#d33",
                });
            });
    });
    usuarioInput.focus();
});
