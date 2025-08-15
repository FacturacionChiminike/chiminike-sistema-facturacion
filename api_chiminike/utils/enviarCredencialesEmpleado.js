
const enviarCorreo = require('./mailer');

const enviarCredencialesEmpleado = async (correo, nombre, usuario, contrasena) => {
  const asunto = 'Tus credenciales de acceso - Fundación Chiminike'; 

  const html = `
  <div style="font-family:Arial, sans-serif; max-width:560px; margin:0 auto; background:#fff; border:1px solid #eee; border-radius:10px; overflow:hidden;">
    <!-- Header rojo principal -->
    <div style="background:#D9272E; padding:18px 20px; text-align:center;">
      <div style="font-size:22px; font-weight:700; color:#fff; letter-spacing:.3px;">
        <span style="color:#41c532;">FUNDACIÓN</span> CHIMINIKE
      </div>
      <div style="color:#F1F0EA; opacity:.95; font-size:12px; margin-top:2px;">
        Educación y diversión para un mejor futuro
      </div>
    </div>

    <!-- Body -->
    <div style="padding:22px;">
      <h2 style="margin:0 0 10px; color:#222;">¡Bienvenido/a, ${nombre}!</h2>
      <p style="margin:8px 0 14px; color:#333;">
        Aquí están tus credenciales para acceder al sistema interno:
      </p>

      <!-- Tarjeta de credenciales -->
      <div style="background:#F9FAF9; border-left:6px solid #006633; border-radius:8px; padding:16px; margin:14px 0;">
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
          <tr>
            <td style="padding:6px 0; width:120px; color:#555; font-weight:700;">Usuario:</td>
            <td style="padding:6px 0;"><span style="background:#F1F0EA; padding:6px 10px; border-radius:4px; font-family:monospace;">${usuario}</span></td>
          </tr>
          <tr>
            <td style="padding:6px 0; color:#555; font-weight:700;">Contraseña:</td>
            <td style="padding:6px 0;"><span style="background:#F1F0EA; padding:6px 10px; border-radius:4px; font-family:monospace;">${contrasena}</span></td>
          </tr>
        </table>
      </div>

      <div style="background:#FFF8E6; border-left:4px solid #41c532; padding:12px; border-radius:6px; margin:14px 0;">
        <p style="margin:0; color:#5b4a00; font-size:13px;">
          <b>Importante:</b> cambia tu contraseña en tu primer inicio de sesión.
        </p>
      </div>

      <!-- Un solo botón/enlace -->
      <div style="text-align:center; margin-top:18px;">
        <a href="https://www.chiminike.org" 
           style="display:inline-block; background:#006633; color:#fff; text-decoration:none; padding:10px 18px; border-radius:8px; font-weight:700;">
          Acceder al sistema
        </a>
      </div>
    </div>

    <!-- Footer -->
    <div style="background:#F1F0EA; padding:12px 18px; text-align:center; font-size:11px; color:#78777A;">
      © ${new Date().getFullYear()} Fundación Chiminike. Mensaje automático.
    </div>
  </div>`;

 
  const text = `Hola ${nombre},
Estas son tus credenciales de acceso:

Usuario: ${usuario}
Contraseña: ${contrasena}

Por seguridad, cambia tu contraseña en el primer inicio de sesión.
Fundación Chiminike - http://68.168.222.45/logn`;

  try {
    await enviarCorreo(correo, asunto, html, text); 
    console.log('Credenciales enviadas correctamente');
  } catch (err) {
    console.error('Error al enviar credenciales:', err);
    throw err;
  }
};

module.exports = enviarCredencialesEmpleado;
