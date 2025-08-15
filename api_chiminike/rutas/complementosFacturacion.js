// api/facturacion/complementosFacturacion.js
const express = require('express');
const router  = express.Router();
const db      = require('../index'); // conexión exportada en index.js

// ——— RUTAS AUXILIARES PARA FACTURACIÓN ———

// Municipios
router.get('/municipios', async (req, res) => {
  try {
    const [rows] = await db.promise().query(
      'SELECT cod_municipio, municipio FROM municipios ORDER BY municipio'
    );
    res.json(rows);
  } catch (err) {
    console.error('Error al listar municipios:', err);
    res.status(500).json({ error: err.message });
  }
});

// Clientes
router.get('/clientes', async (req, res) => {
  try {
    const [results] = await db.promise().query(
      `CALL sp_mostrar_persona(0, 'TODOS_CLIENTES')`
    );
    const personas = results[0];
    res.json(personas.map(row => ({
      cod_cliente:       row.cod_cliente,
      nombre:            row.nombre,
      fecha_nacimiento:  row.fecha_nacimiento,
      sexo:              row.sexo,
      dni:               row.dni,
      correo:            row.correo,
      telefono:          row.telefono,
      direccion:         row.direccion,
      municipio:         row.municipio,
      departamento:      row.departamento,
      rtn:               row.rtn,
      tipo_cliente:      row.tipo_cliente
    })));
  } catch (err) {
    console.error('Error al listar clientes:', err);
    res.status(500).json({ error: err.message });
  }
});

// Crear cliente
router.post('/clientes', async (req, res) => {
  const {
    nombre, fecha_nacimiento, sexo, dni,
    correo, telefono, direccion, cod_municipio,
    rtn, tipo_cliente
  } = req.body;
  try {
    const [results] = await db.promise().query(
      'CALL sp_insertar_cliente(?,?,?,?,?,?,?,?,?,?)',
      [ nombre, fecha_nacimiento, sexo, dni,
        correo, telefono, direccion, cod_municipio,
        rtn, tipo_cliente
      ]
    );
    // sp_insertar_cliente debe devolver SELECT LAST_INSERT_ID() AS cod_cliente
    const cod_cliente = results[0][0].cod_cliente;
    res.status(201).json({
      cod_cliente, nombre, fecha_nacimiento, sexo, dni,
      correo, telefono, direccion, cod_municipio,
      rtn, tipo_cliente
    });
  } catch (err) {
    console.error('Error al crear cliente:', err);
    res.status(500).json({ error: err.message });
  }
});

// Empleados
router.get('/empleados', async (req, res) => {
  try {
    const [rows] = await db.promise().query(
      `SELECT e.cod_empleado, p.nombre_persona AS nombre, e.cargo
         FROM empleados e
         JOIN personas p ON e.cod_persona = p.cod_persona`
    );
    res.json(rows);
  } catch (err) {
    console.error('Error al listar empleados:', err);
    res.status(500).json({ error: err.message });
  }
});

// CAI activo
router.get('/cai/activo', async (req, res) => {
  try {
    const [results] = await db.promise().query(`CALL sp_get_cai_activo()`);
    const rows = results[0];
    if (!rows.length) return res.status(404).json({ error: 'No hay CAI activo' });
    res.json(rows[0]);
  } catch (err) {
    console.error('Error al obtener CAI activo:', err);
    res.status(500).json({ error: err.message });
  }
});

// Correlativo activo
// Correlativo activo
// Correlativo activo
// Correlativo activo
router.get('/correlativo/activo', async (req, res) => {
  try {
    // 1) Obtener el CAI activo
    const [caiResult] = await db.promise().query(`CALL sp_get_cai_activo()`);
    const cais = caiResult[0];
    if (!cais.length) return res.status(404).json({ error: 'No hay CAI activo' });

    const { cod_cai } = cais[0];

    // 2) Verificar si el CAI activo tiene correlativo
    const [correlativoResult] = await db.promise().query(
      'SELECT * FROM correlativos_factura WHERE cod_cai = ?',
      [cod_cai]
    );

    if (correlativoResult.length) {
      // Si el correlativo ya existe, lo devolvemos
      return res.json(correlativoResult[0]);
    }

    // 3) Si no existe correlativo, verificar el rango del CAI y crear uno nuevo
    const [caiDetails] = await db.promise().query(
      'SELECT * FROM cai WHERE cod_cai = ?',
      [cod_cai]
    );
    const { rango_desde, rango_hasta } = caiDetails[0];

    // Crear un nuevo correlativo basándonos en el rango del CAI
    const nuevoCorrelativo = `${rango_desde}`;
    await db.promise().query(
      'INSERT INTO correlativos_factura (cod_cai, siguiente_numero) VALUES (?, ?)',
      [cod_cai, nuevoCorrelativo]
    );

    // Obtener y devolver el correlativo recién creado
    const [newCorrelativoResult] = await db.promise().query(
      'SELECT * FROM correlativos_factura WHERE cod_cai = ?',
      [cod_cai]
    );

    return res.json(newCorrelativoResult[0]);

  } catch (err) {
    console.error('Error al manejar el correlativo:', err);
    return res.status(500).json({ error: err.message });
  }
});




// Actualizar correlativo
router.put('/correlativo/:id', async (req, res) => {
  const { id } = req.params;
  try {
    // El SP sp_actualizar_correlativo(IN p_cod_correlativo) ya incrementa internamente
    await db.promise().query('CALL sp_actualizar_correlativo(?)', [id]);
   res.json({ message: 'Correlativo actualizado' });
  } catch (err) {
    console.error('Error al actualizar correlativo:', err);
  res.status(500).json({ error: err.message });
 }
});

// Boletos taquilla
router.get('/boletos-taquilla', async (req, res) => {
  try {
    const [rows] = await db.promise().query(
      'SELECT cod_entrada AS cod_boleto, nombre AS tipo, precio FROM entradas'
    );
    res.json(rows);
  } catch (err) {
    console.error('Error al listar boletos:', err);
    res.status(500).json({ error: err.message });
  }
});

// Paquetes
router.get('/paquetes', async (req, res) => {
  try {
    const [results] = await db.promise().query(
      `CALL sp_gestion_paquete('MOSTRAR', NULL, NULL, NULL, NULL)`
    );
    res.json(results[0].map(r => ({
      cod_paquete: r.cod_paquete,
      nombre:      r.nombre,
      descripcion: r.descripcion,
      precio:      r.precio
    })));
  } catch (err) {
    console.error('Error al listar paquetes:', err);
    res.status(500).json({ error: err.message });
  }
});

// Adicionales
router.get('/adicionales', async (req, res) => {
  try {
    const [results] = await db.promise().query(
      `CALL sp_gestion_adicional('MOSTRAR', NULL, NULL, NULL, NULL)`
    );
    res.json(results[0].map(r => ({
      cod_adicional: r.cod_adicional,
      nombre:        r.nombre,
      descripcion:   r.descripcion,
      precio:        r.precio
    })));
  } catch (err) {
    console.error('Error al listar adicionales:', err);
    res.status(500).json({ error: err.message });
  }
});

// Inventario
router.get('/inventario', async (req, res) => {
  try {
    const [results] = await db.promise().query(
      `CALL sp_gestion_inventario('MOSTRAR', NULL, NULL, NULL, NULL, NULL, NULL)`
    );
    res.json(results[0].map(r => ({
      cod_inventario:    r.cod_inventario,
      nombre:            r.nombre,
      descripcion:       r.descripcion,
      precio_unitario:   r.precio_unitario,
      cantidad_disponible: r.cantidad_disponible,
      estado:            r.estado
    })));
  } catch (err) {
    console.error('Error al listar inventario:', err);
    res.status(500).json({ error: err.message });
  }
});

// Salones
router.get('/salones', async (req, res) => {
  try {
    const [results] = await db.promise().query(
      `CALL sp_gestion_salon('MOSTRAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)`
    );
    res.json(results[0].map(r => ({
      cod_salon:                r.cod_salon,
      nombre:                   r.nombre,
      descripcion:              r.descripcion,
      capacidad:                r.capacidad,
      estado:                   r.estado,
      precio_dia:               r.precio_dia,
      precio_hora_extra_dia:    r.precio_hora_extra_dia,
      precio_noche:             r.precio_noche,
      precio_hora_extra_noche:  r.precio_hora_extra_noche
    })));
  } catch (err) {
    console.error('Error al listar salones:', err);
    res.status(500).json({ error: err.message });
  }
});

router.get('/descuentos', async (req, res) => {
  try {
    const [result] = await db.promise().query(
      `CALL sp_gestion_descuentos('MOSTRAR', NULL, NULL, NULL, NULL)`
    );
    res.json(result[0][0]); // solo un registro
  } catch (err) {
    console.error('Error al obtener descuento:', err);
    res.status(500).json({ error: err.message });
  }
});

// Actualizar descuento
router.put('/descuentos/:id', async (req, res) => {
  const { id } = req.params;
  const { descuento_otorgado, rebaja_otorgada, importe_exento } = req.body;

  try {
    await db.promise().query(
      `CALL sp_gestion_descuentos('ACTUALIZAR', ?, ?, ?, ?)`,
      [id, descuento_otorgado, rebaja_otorgada, importe_exento]
    );
    res.json({ message: 'Descuentos actualizados correctamente' });
  } catch (err) {
    console.error('Error al actualizar descuento:', err);
    res.status(500).json({ error: err.message });
  }
});


// Libros
router.get('/libros', async (req, res) => {
  try {
    const [rows] = await db.promise().query(
      'SELECT cod_libro, titulo AS nombre, precio FROM libros ORDER BY titulo'
    );
    res.json(rows);
  } catch (err) {
    console.error('Error al listar libros:', err);
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
