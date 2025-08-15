
require('dotenv').config();
const nodemailer = require('nodemailer');

['SMTP_HOST','SMTP_PORT','SMTP_USER','SMTP_PASS','MAIL_FROM_ADDR'].forEach(k=>{
  if(!process.env[k]) throw new Error(`Falta ${k} en .env`);
});

const transporter = nodemailer.createTransport({
  host: process.env.SMTP_HOST,
  port: Number(process.env.SMTP_PORT),
  secure: process.env.SMTP_SECURE === 'true',
  name: 'museochiminike.org', 
  auth: {
    user: process.env.SMTP_USER,
    pass: process.env.SMTP_PASS
  }
});

async function enviarCorreo(destinatario, asunto, html, text) {
  const info = await transporter.sendMail({
    from: `"${process.env.MAIL_FROM_NAME || 'Museo Chiminike - Sistema'}" <${process.env.MAIL_FROM_ADDR}>`,
    to: destinatario,
    subject: asunto,
    html,
    text, 
    envelope: { from: process.env.MAIL_FROM_ADDR, to: destinatario },
    messageId: `${Date.now()}.${Math.random().toString(36).slice(2)}@museochiminike.org`,
    headers: {
      'X-Entity-Ref-ID': '2FA',
     
    }
  });

  console.log('📨 Resultado envío:', {
    messageId: info.messageId,
    accepted: info.accepted,
    rejected: info.rejected,
    response: info.response
  });

  return info.messageId;
}

module.exports = enviarCorreo;
