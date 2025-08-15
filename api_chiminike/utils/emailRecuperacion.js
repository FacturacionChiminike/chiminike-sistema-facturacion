const enviarCorreo = require('./mailer');

const enviarCorreoRecuperacion = async (correo, usuario, token) => {
 const enlace = `http://68.168.222.45/resetear?token=${encodeURIComponent(token)}`;
    
    const asunto = '🔐 Restablece tu Contraseña - Fundación Chiminike';

    const html = `
    <div style="font-family: 'Arial', sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #eaeaea; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 15px rgba(0,0,0,0.08);">
        <!-- Encabezado institucional -->
        <div style="background-color: #006633; padding: 25px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 26px; letter-spacing: 1px;">
                <span style="color: #FFD700;">FUNDACIÓN</span> CHIMINIKE
            </h1>
            <p style="color: #F1F0EA; margin: 8px 0 0; font-size: 14px;">Educación y diversión para un mejor futuro</p>
        </div>
        
        <!-- Contenido principal -->
        <div style="padding: 30px; background-color: #ffffff;">
            <h2 style="color: #D9272E; margin-top: 0; font-size: 22px;">Recuperación de contraseña</h2>
            <p style="color: #333; line-height: 1.6;">Hola <strong>${usuario}</strong>,</p>
            <p style="color: #333; line-height: 1.6;">Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Haz clic en el siguiente botón para continuar con el proceso:</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="${enlace}" style="display: inline-block; background-color: #D9272E; color: white; padding: 14px 28px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    🔑 Restablecer Contraseña
                </a>
            </div>
            
            <div style="background-color: #F8F8F8; border-left: 4px solid #006633; padding: 15px; margin: 25px 0; border-radius: 4px;">
                <p style="margin: 0; color: #555; font-size: 14px; line-height: 1.5;">
                    <strong>⚠ Importante:</strong> Este enlace es válido por <strong>1 hora</strong>. Si no realizaste esta solicitud, por favor ignora este mensaje o contacta a nuestro equipo de soporte.
                </p>
            </div>
            
            <p style="color: #666; font-size: 14px; line-height: 1.6;">Si el botón no funciona, copia y pega esta URL en tu navegador:</p>
            <p style="color: #006633; font-size: 13px; word-break: break-all; background-color: #F1F0EA; padding: 10px; border-radius: 4px;">${enlace}</p>
        </div>
        
        <!-- Pie de página -->
        <div style="background-color: #F1F0EA; padding: 20px; text-align: center; font-size: 12px; color: #666666; border-top: 1px solid #e0e0e0;">
            <p style="margin: 5px 0;">© ${new Date().getFullYear()} Fundación Chiminike. Todos los derechos reservados.</p>
            <p style="margin: 5px 0; font-size: 11px;">
                <a href="https://www.chiminike.org" style="color: #006633; text-decoration: none;">Visita nuestro sitio web</a> | 
                <a href="mailto:soporte@chiminike.org" style="color: #006633; text-decoration: none;">Soporte técnico</a>
            </p>
            <p style="margin: 5px 0; font-size: 11px;">Este es un mensaje automático, por favor no respondas directamente a este correo.</p>
        </div>
    </div>
    `;

    try {
        await enviarCorreo(correo, asunto, html);
        console.log('Correo de recuperación enviado correctamente');
    } catch (err) {
        console.error('Error al enviar correo de recuperación:', err);
        throw err;
    }
};

module.exports = enviarCorreoRecuperacion;