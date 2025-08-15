const { registrarBitacora } = require("../helpers/bitacora");
const obtenerIP = require("../helpers/ip");

function bitacora(objeto, accion) {
    return async (req, res, next) => {
        try {
            if (!req.usuario || !req.usuario.cod_usuario) {
                return res.status(401).json({ mensaje: "No autorizado para registrar bitácora" });
            }

            const cod_usuario = req.usuario.cod_usuario;
            const ipConexion = obtenerIP(req);

            const datosAntes = req.datosAntes || null;
            const datosDespues = req.datosDespues || null;

            await registrarBitacora(cod_usuario, objeto, accion, ipConexion, datosAntes, datosDespues);
            next(); 
        } catch (err) {
            console.error("Error al registrar en bitácora:", err);
            return res.status(500).json({ mensaje: "Error al registrar bitácora" });
        }
    };
}

module.exports = bitacora;
