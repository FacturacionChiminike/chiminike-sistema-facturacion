// api/facturacion/eventosFacturacion.js
const express = require('express');
const router  = express.Router();
const db      = require('../index');  // tu conexión MySQL

// 1) Listar todos los eventos confirmados con sus productos
router.get('/eventos', (req, res) => {
  db.query('CALL sp_listar_eventos_factura()', (err, results) => {
    if (err) {
      console.error('Error al listar eventos:', err);
      return res.status(500).json({ mensaje: 'Error al listar eventos' });
    }
    const eventos = results[0] || [];
    // si no hay ninguno, devolvemos el array vacío y listo
    if (eventos.length === 0) {
      return res.json(eventos);
    }

    let pendientes = eventos.length;
    eventos.forEach(ev => {
      db.query(
        'CALL sp_obtener_productos_evento_factura(?)',
        [ev.cod_evento],
        (err2, prodRes) => {
          ev.productos = err2 ? [] : (prodRes[0] || []);
          if (--pendientes === 0) {
            // cuando todos terminen, devolvemos el array
            res.json(eventos);
          }
        }
      );
    });
  });
});

// 2) Obtener un evento específico por ID
router.get('/eventos/:id', (req, res) => {
  const id = req.params.id;
  db.query(
    'CALL sp_obtener_evento_factura(?)',
    [id],
    (err, results) => {
      if (err) {
        console.error('Error al obtener evento:', err);
        return res.status(500).json({ mensaje: 'Error al obtener evento' });
      }
      const evento = (results[0] || [])[0];
      if (!evento) {
        return res.status(404).json({ mensaje: 'Evento no encontrado' });
      }
      // cargamos sus productos
      db.query(
        'CALL sp_obtener_productos_evento_factura(?)',
        [id],
        (err2, prodRes) => {
          evento.productos = err2 ? [] : (prodRes[0] || []);
          res.json(evento);
        }
      );
    }
  );
});

// 3) Confirmar evento completo (cotización + detalle_cotización + evento)
router.post('/eventos-completo', (req, res) => {
  const {
    cod_cliente,
    nombre,
    fecha_programa,
    hora_programada,
    horas_evento,
    productos  // [{ cantidad, descripcion, precio_unitario }]
  } = req.body;

  db.beginTransaction(err => {
    if (err) {
      console.error('Error al iniciar transacción:', err);
      return res.status(500).json({ mensaje: 'No se pudo iniciar transacción' });
    }

    const hoy = new Date().toISOString().slice(0,10);

    // 3.1) Insertar cotización
    db.query(
      'CALL sp_insertar_cotizacion_factura(?,?,?,?)',
      [cod_cliente, hoy, hoy, 'confirmada'],
      (err1, cotizRes) => {
        if (err1) {
          console.error('Error al insertar cotización:', err1);
          return db.rollback(() =>
            res.status(500).json({ mensaje: 'Error al insertar cotización' })
          );
        }
        const cod_cotizacion = cotizRes[0][0].cod_cotizacion;

        // 3.2) Insertar cada detalle de cotización
        let i = 0;
        function insertaDetalle() {
          if (i === productos.length) {
            // 3.3) Insertar evento
            return db.query(
              'CALL sp_insertar_evento_factura(?,?,?,?,?)',
              [nombre, fecha_programa, hora_programada, cod_cotizacion, horas_evento],
              (err4, evRes) => {
                if (err4) {
                  console.error('Error al insertar evento:', err4);
                  return db.rollback(() =>
                    res.status(500).json({ mensaje: 'Error al insertar evento' })
                  );
                }
                const cod_evento = evRes[0][0].cod_evento;
                // 3.4) Confirmar todo
                db.commit(commitErr => {
                  if (commitErr) {
                    console.error('Error al confirmar transacción:', commitErr);
                    return db.rollback(() =>
                      res.status(500).json({ mensaje: 'Error al confirmar datos' })
                    );
                  }
                  res.status(201).json({
                    mensaje: 'Evento confirmado correctamente',
                    cod_evento,
                    cod_cotizacion
                  });
                });
              }
            );
          }

          const p = productos[i++];
          db.query(
            'CALL sp_insertar_detalle_cotizacion_factura(?,?,?,?,?)',
            [
              cod_cotizacion,
              p.cantidad,
              p.descripcion,
              p.precio_unitario,
              (p.cantidad||0)*(p.precio_unitario||0)
            ],
            err2 => {
              if (err2) {
                console.error('Error al insertar detalle de cotización:', err2);
                return db.rollback(() =>
                  res.status(500).json({ mensaje: 'Error al insertar detalle' })
                );
              }
              insertaDetalle();
            }
          );
        }
        insertaDetalle();
      }
    );
  });
});

// ——— MARCAR COTIZACIÓN COMO COMPLETADA AL FACTURAR UN EVENTO ———
router.put('/eventos/:id/completar', (req, res) => {
  const codEvento = req.params.id;
  const sql = `
    UPDATE cotizacion c
    JOIN evento e ON e.cod_cotizacion = c.cod_cotizacion
    SET c.estado = 'completada'
    WHERE e.cod_evento = ?
  `;
  db.query(sql, [codEvento], (err, result) => {
    if (err) {
      console.error('Error al completar cotización:', err);
      return res.status(500).json({ mensaje: 'Error al completar cotización' });
    }
    res.json({ success: true, mensaje: 'Cotización marcada como completada' });
  });
});

module.exports = router;
