document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-resetear");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const token = document.getElementById("token").value;
        const nueva = document.getElementById("password").value;
        const nueva_confirm = document.getElementById("password_confirmation").value;
        const csrf = document.querySelector('input[name="_token"]').value;

        if (nueva !== nueva_confirm) {
            Swal.fire({
                icon: "error",
                title: "Las contraseñas no coinciden",
                text: "Por favor, verifícalas e intenta de nuevo.",
            });
            return;
        }

        const formData = new FormData();
        formData.append("_token", csrf);
        formData.append("token", token);
        formData.append("nueva", nueva);
        formData.append("nueva_confirmation", nueva_confirm);

        try {
            const response = await fetch("/resetear", {
                method: "POST",
                body: formData,
            });

            if (response.ok) {
                const result = await response.text(); 
                Swal.fire({
                    icon: "success",
                    title: "¡Contraseña actualizada!",
                    text: "Ya podés iniciar sesión con tu nueva contraseña.",
                }).then(() => {
                    window.location.href = "/logn";
                });
            } else {
                const errorData = await response.json();
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: errorData.message || "No se pudo cambiar la contraseña.",
                });
            }
        } catch (err) {
            console.error("ERROR:", err);
            Swal.fire({
                icon: "error",
                title: "Error del servidor",
                text: err.message || "Inténtalo más tarde.",
            });
        }
    });
});
