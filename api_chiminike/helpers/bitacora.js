const db = require("../index");

async function registrarBitacora(cod_usuario, objeto, accion, ip, datosAntes = null, datosDespues = null) {
    const datos_antes = datosAntes ? JSON.stringify(datosAntes) : null;
    const datos_despues = datosDespues
        ? JSON.stringify(datosDespues)
        : JSON.stringify({ mensaje: generarDescripcion(objeto, accion, ip), ip });

    const sql = `CALL sp_insert_bitacora(?, ?, ?, ?, ?)`;

    return new Promise((resolve, reject) => {
        db.query(sql, [cod_usuario, objeto, accion, datos_antes, datos_despues], (err, results) => {
            if (err) {
                console.error("Error al registrar en bitácora:", err);
                reject(err);
            } else {
                resolve(results);
            }
        });
    });
}

function generarDescripcion(objeto, accion, ip) {
    const acciones = {
        "Acceso": `Inicio de sesión exitoso desde IP ${ip}`,
        "Crear": `Creación de ${objeto} desde IP ${ip}`,
        "Actualizar": `Actualización de ${objeto} desde IP ${ip}`,
        "Eliminar": `Eliminación de ${objeto} desde IP ${ip}`,
        "Consultar": `Consulta de ${objeto} desde IP ${ip}`
    };

    return acciones[accion] || `Acción ${accion} realizada en ${objeto} desde IP ${ip}`;
}

module.exports = { registrarBitacora };
