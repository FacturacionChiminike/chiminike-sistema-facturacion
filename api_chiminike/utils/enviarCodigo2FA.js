
const enviarCorreo = require('./mailer');

const enviarCodigo2FA = async (correoDestino, codigo) => {
  const asunto = 'Tu código de verificación - Museo Chiminike';

  const html = `
  <div style="font-family:Arial, sans-serif; max-width:560px; margin:0 auto; background:#ffffff; border:1px solid #eee; border-radius:10px; overflow:hidden;">
    <!-- Header -->
    <div style="background:#D9272E; padding:16px 20px; text-align:center;">
      <div style="font-size:22px; font-weight:700; color:#fff; letter-spacing:.5px;">
        <span style="color:#41c532;">MUSEO</span> CHIMINIKE
      </div>
      <div style="color:#F1F0EA; opacity:.9; font-size:12px; margin-top:2px;">
        Explorando, aprendiendo, creciendo
      </div>
    </div>

    <!-- Body -->
    <div style="padding:22px;">
      <h2 style="margin:0 0 8px; color:#222;">Verificación en dos pasos</h2>
      <p style="margin:8px 0 14px; color:#333;">Hola,</p>
      <p style="margin:0 0 16px; color:#333;">
        Tu código de verificación es:
      </p>

      <div style="border-left:6px solid #D9272E; border-radius:8px; padding:14px; background:#F9FAF9; text-align:center;">
        <div style="font-size:30px; font-weight:800; letter-spacing:3px; color:#006633; margin:4px 0;">
          ${codigo}
        </div>
      </div>

      <p style="margin:16px 0 0; color:#333;">
        Este código expira en <b>5 minutos</b>.
      </p>
      <p style="margin:8px 0 0; color:#78777A; font-size:12px;">
        Si no solicitaste este código, puedes ignorar este mensaje.
      </p>

      <!-- Botón -->
      <div style="text-align:center; margin-top:22px;">
        <a href="https://www.chiminike.org" 
           style="display:inline-block; background:#006633; color:#fff; text-decoration:none; padding:10px 18px; border-radius:8px; font-weight:700;">
          Visítanos
        </a>
      </div>
    </div>

    <!-- Footer -->
    <div style="background:#F1F0EA; padding:14px 18px; text-align:center; font-size:11px; color:#78777A;">
      © ${new Date().getFullYear()} Museo Chiminike. Mensaje automático.
    </div>
  </div>`;

  const text = `Verificación en dos pasos
Hola,
Tu código de verificación es: ${codigo}
Expira en 5 minutos. Si no lo solicitaste, ignora este mensaje.
Museo Chiminike - http://68.168.222.45/logn`;

  try {
    await enviarCorreo(correoDestino, asunto, html, text);
    console.log('Código 2FA enviado correctamente');
  } catch (err) {
    console.error('Error al enviar código 2FA:', err);
  }
};

module.exports = enviarCodigo2FA;
