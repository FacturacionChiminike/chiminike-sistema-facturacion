function verificarPermiso(objeto, accion) {
    return (req, res, next) => {
        const usuario = req.usuario;

        if (!usuario || !usuario.permisos) {
            return res.status(401).json({ mensaje: 'No autenticado o sin permisos cargados' });
        }

        
        const permiso = usuario.permisos.find(p => p.objeto === objeto);

        if (!permiso || !permiso[accion]) {
            return res.status(403).json({
                mensaje: `No tienes permiso para ${accion} en ${objeto}`
            });
        }

        next();
    };
}

module.exports = verificarPermiso;
