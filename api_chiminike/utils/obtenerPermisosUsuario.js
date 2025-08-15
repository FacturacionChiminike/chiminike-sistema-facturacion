const db = require('../index');

function obtenerPermisosUsuario(cod_usuario) {
    return new Promise((resolve, reject) => {
        db.query('CALL sp_permisos_usuario(?)', [cod_usuario], (err, results) => {
            if (err) {
                console.error('Error al obtener permisos:', err);
                return reject(err);
            }

            const permisos = results[0].map(p => p.objeto); 
            resolve(permisos);
        });
    });
}

module.exports = obtenerPermisosUsuario;
