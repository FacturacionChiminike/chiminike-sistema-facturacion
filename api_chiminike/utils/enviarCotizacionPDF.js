const transporter = require("./mailer");

/**
 * Enviar cotización PDF adjunta por correo al cliente.
 * 
 * @param {Object} options
 * @param {string} options.to - Correo destino
 * @param {string} options.subject - Asunto del correo
 * @param {string} options.text - Texto del correo
 * @param {string} options.attachmentPath - Ruta completa del archivo PDF
 * @param {string} options.attachmentName - Nombre del archivo PDF
 */
async function enviarCotizacionPDF({ to, subject, text, attachmentPath, attachmentName }) {
    try {
        const info = await transporter.sendMail({
            from: '"Museo Chiminike" <noreply@chiminike.org>',
            to,
            subject: subject || "Cotización de Evento - Museo Chiminike",
            text: text || "Adjunto encontrarás la cotización solicitada.",
            attachments: [
                {
                    filename: attachmentName || "cotizacion_evento.pdf",
                    path: attachmentPath
                }
            ]
        });

        console.log(`Cotización enviada correctamente a ${to}. ID: ${info.messageId}`);
        return true;
    } catch (error) {
        console.error(` Error al enviar cotización PDF a ${to}:`, error.message);
        throw error;
    }
}

module.exports = enviarCotizacionPDF;
