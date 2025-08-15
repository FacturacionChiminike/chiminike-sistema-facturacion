const express = require('express');
const router = express.Router();
const db = require('../index');

// ——— CRUD FACTURAS ———

// Listar todas las facturas
router.get('/facturas', (req, res) => {
  db.query('CALL sp_listar_facturas()', (err, results) => {
    if (err) {
      console.error('Error al listar facturas:', err);
      return res.status(500).json({ error: err.message });
    }
    // results[0] es el array devuelto por el SP
    res.json(results[0]);
  });
});

// Obtener detalle de una factura
router.get('/facturas/:id/detalle', (req, res) => {
  const codFactura = req.params.id;
  db.query('CALL sp_obtener_detalle_factura(?)', [codFactura], (err, results) => {
    if (err) {
      console.error('Error al obtener detalle de factura:', err);
      return res.status(500).json({ error: err.message });
    }
    res.json(results[0]);
  });
});

// Obtener una factura
router.get('/facturas/:id', (req, res) => {
  const codFactura = req.params.id;
  db.query('CALL sp_obtener_factura(?)', [codFactura], (err, results) => {
    if (err) {
      console.error('Error al obtener factura:', err);
      return res.status(500).json({ error: err.message });
    }
    const row = results[0][0];
    if (!row) return res.status(404).json({ message: 'Factura no encontrada' });
    res.json(row);
  });
});

// Crear factura
router.post('/facturas', (req, res) => {
  const {
    fecha_emision, cod_cliente, direccion, rtn, tipo_factura,
    descuento_otorgado, rebajas_otorgadas, importe_exento,
    importe_gravado_18, importe_gravado_15, impuesto_18, impuesto_15,
    importe_exonerado, subtotal, total_pago, observaciones
  } = req.body;

  const params = [
    fecha_emision, cod_cliente, direccion, rtn, tipo_factura,
    descuento_otorgado, rebajas_otorgadas, importe_exento,
    importe_gravado_18, importe_gravado_15, impuesto_18, impuesto_15,
    importe_exonerado, subtotal, total_pago, observaciones
  ];

  db.beginTransaction(err => {
    if (err) {
      console.error('Error al iniciar transacción:', err);
      return res.status(500).json({ error: err.message });
    }
    db.query('CALL sp_insertar_factura(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', params, err => {
      if (err) {
        console.error('Error al insertar factura:', err);
        return db.rollback(() =>
          res.status(500).json({ error: err.message })
        );
      }
      db.query('SELECT LAST_INSERT_ID() AS cod_factura', (err, rows) => {
        if (err) {
          console.error('Error al obtener último ID:', err);
          return db.rollback(() =>
            res.status(500).json({ error: err.message })
          );
        }
        const cod_factura = rows[0].cod_factura;
        db.commit(err => {
          if (err) {
            console.error('Error al confirmar transacción:', err);
            return db.rollback(() =>
              res.status(500).json({ error: err.message })
            );
          }
          res.status(201).json({ message: 'Factura creada', cod_factura });
        });
      });
    });
  });
});

// Actualizar factura
router.put('/facturas/:id', (req, res) => {
  const {
    fecha_emision, cod_cliente, direccion, rtn, tipo_factura,
    descuento_otorgado, rebajas_otorgadas, importe_exento,
    importe_gravado_18, importe_gravado_15, impuesto_18, impuesto_15,
    importe_exonerado, subtotal, total_pago, observaciones
  } = req.body;

  const params = [
    req.params.id,
    fecha_emision, cod_cliente, direccion, rtn, tipo_factura,
    descuento_otorgado, rebajas_otorgadas, importe_exento,
    importe_gravado_18, importe_gravado_15, impuesto_18, impuesto_15,
    importe_exonerado, subtotal, total_pago, observaciones
  ];

  db.query('CALL sp_actualizar_factura(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', params, err => {
    if (err) {
      console.error('Error al actualizar factura:', err);
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Factura actualizada' });
  });
});

// Eliminar factura
router.delete('/facturas/:id', (req, res) => {
  const codFactura = req.params.id;
  db.query('CALL sp_eliminar_factura(?)', [codFactura], err => {
    if (err) {
      console.error('Error al eliminar factura:', err);
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Factura eliminada' });
  });
});

// ——— CRUD DETALLE_FACTURA ———

// Agregar detalle
router.post('/facturas/detalle', (req, res) => {
  const d = req.body;
  const params = [
    d.cod_factura,
    d.cantidad,
    d.descripcion,
    d.precio_unitario,
    d.total,
    d.tipo
  ];
  db.query('CALL sp_insertar_detalle_factura(?,?,?,?,?,?)', params, err => {
    if (err) {
      console.error('Error al agregar detalle de factura:', err);
      return res.status(500).json({ error: err.message });
    }
    res.status(201).json({ message: 'Detalle agregado' });
  });
});

// Actualizar detalle
router.put('/facturas/detalle-factura/:id', (req, res) => {
  const cod_detalle = req.params.id;
  const { cantidad, descripcion, precio_unitario, total, tipo } = req.body;

  if (
    cantidad === undefined ||
    descripcion === undefined ||
    precio_unitario === undefined ||
    total === undefined ||
    tipo === undefined
  ) {
    return res.status(400).json({ error: 'Faltan campos requeridos.' });
  }

  db.query(
    'CALL sp_actualizar_detalle_factura(?,?,?,?,?,?)',
    [cod_detalle, cantidad, descripcion, precio_unitario, total, tipo],
    err => {
      if (err) {
        console.error('Error al actualizar detalle de factura:', err);
        return res.status(500).json({ error: err.message });
      }
      res.json({ message: 'Detalle de factura actualizado correctamente.' });
    }
  );
});

// Eliminar detalle
router.delete('/facturas/detalle-factura/:id', (req, res) => {
  const cod_detalle = req.params.id;
  db.query('CALL sp_eliminar_detalle_factura(?)', [cod_detalle], err => {
    if (err) {
      console.error('Error al eliminar detalle de factura:', err);
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Detalle eliminado' });
  });
});

module.exports = router;
