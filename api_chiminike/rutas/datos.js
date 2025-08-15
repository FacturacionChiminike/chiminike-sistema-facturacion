const express = require("express");
const router = express.Router();
const db = require("../index");

//ROLES
router.get("/role.date", (req, res) => {
    db.query("CALL sp_mostrar_roles_basico()", (err, results) => {
        if (err) {
            console.error("Error al obtener roles:", err);
            return res.status(500).json({ mensaje: "Error al obtener roles" });
        }

        const roles = results[0]; 
        res.json(roles);
    });
});

// GET /objetos
router.get("/object.date", (req, res) => {
    db.query("CALL sp_mostrar_objetos_basico()", (err, results) => {
        if (err) {
            console.error("Error al obtener objetos:", err);
            return res.status(500).json({ mensaje: "Error al obtener objetos" });
        }

        res.json(results[0]); 
    });
});


router.get('/municipio.date', async (req, res) => {
    try {
        const [result] = await db.promise().query('CALL sp_catalogo_empleado(?)', ['municipios']);
        res.status(200).json(result[0]);
    } catch (error) {
        console.error('Error municipios:', error);
        res.status(500).json({ error: true, message: 'Error al obtener municipios' });
    }
});

router.get('/dep.emp', async (req, res) => {
    try {
        const [result] = await db.promise().query('CALL sp_catalogo_empleado(?)', ['departamentos_empresa']);
        res.status(200).json(result[0]);
    } catch (error) {
        console.error('Error departamentos empresa:', error);
        res.status(500).json({ error: true, message: 'Error al obtener departamentos de empresa' });
    }
});

router.get('/tip.user', async (req, res) => {
    try {
        const [result] = await db.promise().query('CALL sp_catalogo_empleado(?)', ['tipo_usuario']);
        res.status(200).json(result[0]);
    } catch (error) {
        console.error('Error tipo usuario:', error);
        res.status(500).json({ error: true, message: 'Error al obtener tipos de usuario' });
    }
});

//clientes

router.get('/select.cliente', async (req, res) => {
    try {
        const [result] = await db.promise().query('CALL sp_obtener_clientes_select()');
        res.status(200).json(result[0]); 
    } catch (error) {
        console.error('Error al obtener clientes:', error);
        res.status(500).json({
            error: true,
            message: 'Error al obtener clientes'
        });
    }
});

//correos clientes
router.get('/correo-cliente/:cod_cotizacion', async (req, res) => {
    const { cod_cotizacion } = req.params;
    try {
        const [result] = await db.promise().query('CALL sp_obtener_correo_cliente(?)', [cod_cotizacion]);
        res.status(200).json(result[0]); // Devuelve el primer correo encontrado
    } catch (error) {
        console.error('Error al obtener correo del cliente:', error);
        res.status(500).json({
            error: true,
            message: 'Error al obtener correo del cliente'
        });
    }
});


router.post("/salon.disponibilidad", (req, res) => {
    const { nombre_salon, fecha_evento, hora_evento, horas_evento } = req.body;

    if (!nombre_salon || !fecha_evento || !hora_evento || !horas_evento) {
        return res.status(400).json({ mensaje: "Faltan datos requeridos para verificar disponibilidad." });
    }

    db.query(
        "CALL sp_verificar_disponibilidad_salon(?, ?, ?, ?)",
        [nombre_salon, fecha_evento, hora_evento, horas_evento],
        (err, results) => {
            if (err) {
                console.error("Error al verificar disponibilidad:", err);
                return res.status(500).json({ mensaje: "Error al verificar disponibilidad del salón." });
            }

            // results[0][0] trae { disponible: 1/0, mensaje: "..." }
            const disponibilidad = results[0][0];

            res.json({
                disponible: disponibilidad.disponible === 1,
                mensaje: disponibilidad.mensaje
            });
        }
    );
});

router.get('/dashboard/total-generado', (req, res) => {
    db.query("CALL sp_dashboard_cotizaciones_completadas(?)", ['total_generado'], (err, results) => {
        if (err) {
            console.error("Error al obtener total generado:", err);
            return res.status(500).json({ mensaje: "Error al obtener total generado" });
        }
        res.json(results[0][0]);
    });
});

router.get('/dashboard/cliente-frecuente', (req, res) => {
    db.query("CALL sp_dashboard_cotizaciones_completadas(?)", ['cliente_frecuente'], (err, results) => {
        if (err) {
            console.error("Error al obtener cliente frecuente:", err);
            return res.status(500).json({ mensaje: "Error al obtener cliente frecuente" });
        }
        res.json(results[0][0]);
    });
});

router.get('/dashboard/totales', (req, res) => {
    db.query("CALL sp_dashboard_cotizaciones_completadas(?)", ['dashboard_totales'], (err, results) => {
        if (err) {
            console.error("Error al obtener totales del dashboard:", err);
            return res.status(500).json({ mensaje: "Error al obtener totales del dashboard" });
        }
        res.json(results[0][0]);
    });
});

router.get("/preguntas-recuperacion", (req, res) => {
    db.query("CALL sp_mostrar_preguntas_recuperacion()", (err, results) => {
        if (err) {
            console.error("Error al obtener preguntas de recuperación:", err);
            return res.status(500).json({ mensaje: "Error al obtener preguntas de recuperación" });
        }

        const preguntas = results[0]; // el primer array es el resultado del SELECT
        res.json(preguntas);
    });
});

router.post("/preguntas-usuario", (req, res) => {
    const { nombre_usuario } = req.body;

    if (!nombre_usuario) {
        return res.status(400).json({
            success: false,
            mensaje: "El nombre de usuario es requerido."
        });
    }

    db.query(
        "CALL sp_obtener_preguntas_usuario(?)",
        [nombre_usuario],
        (err, results) => {
            if (err) {
                console.error("Error al obtener preguntas del usuario:", err);
                return res.status(500).json({
                    success: false,
                    mensaje: "Error al obtener preguntas del usuario.",
                    error: err
                });
            }

            const preguntas = results[0];

            if (preguntas.length === 0) {
                return res.status(404).json({
                    success: false,
                    mensaje: "El usuario no tiene preguntas de recuperación configuradas o no existe."
                });
            }

            return res.json({
                success: true,
                preguntas
            });
        }
    );
});

router.get('/horas-extra-salon/:nombre_salon', async (req, res) => {
    const { nombre_salon } = req.params;
    try {
        const [result] = await db.promise().query('CALL sp_mostrar_horas_extras_por_nombre_salon(?)', [nombre_salon]);
        res.status(200).json(result[0]); 
    } catch (error) {
        console.error('Error al obtener horas extra del salón:', error);
        res.status(500).json({
            error: true,
            message: 'Error al obtener las horas extra del salón'
        });
    }
});


// Exportar algo del index para que funcione
module.exports = router;