const express = require('express');
const cors = require('cors');
const mysql = require('mysql2');
const bcrypt = require('bcryptjs');
require('dotenv').config();

const app = express();
app.use(cors());
app.use(express.json());

let mysqlConnection;

function conectarDB() {
  mysqlConnection = mysql.createConnection({
    host: 'localhost',
    user: 'chiminike',
    password: 'hola12',
    database: 'chiminike_db',
    multipleStatements: true
  });

  mysqlConnection.connect((err) => {
    if (err) {
      console.error('❌ Error conectando a la base de datos:', err);
      setTimeout(conectarDB, 2000); // Intenta de nuevo en 2 segundos
    } else {
      console.log('✅ Servidor bailando exitosamente');
    }
  });

  // En caso de que la conexión se cierre
  mysqlConnection.on('error', (err) => {
    console.error('⚠️ MySQL Error:', err);
    if (err.code === 'PROTOCOL_CONNECTION_LOST' || err.code === 'ECONNRESET') {
      conectarDB(); // Reintenta conectar
    } else {
      throw err;
    }
  });
}

// Inicia conexión al arrancar
conectarDB();

module.exports = mysqlConnection;

app.get('/status', (req, res) => {
  res.json({ ok: true, status: 'API viva 🟢', hora: new Date() });
});

// Rutas
app.use(require('./rutas/personas'));
app.use(require('./rutas/seguridad'));
app.use(require('./rutas/eventos'));
app.use(require('./rutas/CAI'));
app.use(require('./rutas/recorridos'));
app.use(require('./rutas/datos'));
app.use(require('./rutas/reservaciones'));
app.use('/api', require('./rutas/facturas'));
app.use('/api', require('./rutas/complementosFacturacion'));
app.use('/api', require('./rutas/eventosFacturacion'));
app.use('/api/reportes', require('./rutas/reportes'));

// Arranca el servidor
const PORT = 3000;
app.listen(PORT, '0.0.0.0', () => {
  console.log(`🚀 Servidor corriendo en el puerto ${PORT}`);
});
