const express = require('express');
const router = express.Router();
const db = require('../index');

// Resumen general
router.get('/resumen-general', async (req, res) => {
    try {
        const [resultSets] = await db.promise().query('CALL sp_reporte_resumen_general()');

        const resumen = {
            total_facturas: resultSets[0][0]?.total_facturas || 0,
            total_facturado: parseFloat(resultSets[0][0]?.total_facturado || 0),
            por_tipo: resultSets[1] || []
        };

        res.json(resumen);
    } catch (err) {
        console.error('Error en resumen-general:', err);
        res.status(500).json({ error: err.message });
    }
});

// Resumen por tipo de factura - CORREGIDO
router.get('/facturas/resumen-por-tipo-factura', async (req, res) => {
  try {
    const [rows] = await db
      .promise()
      .query('CALL sp_reporte_resumen_por_tipo_factura()');
    return res.json(rows[0] || []);
  } catch (err) {
    console.error('Error en /api/reportes/facturas/resumen-por-tipo-factura:', err);
    return res.status(500).json({ error: err.message });
  }
});

// Ventas mensuales - CORREGIDO
router.get('/ventas-mensuales', async (req, res) => {
    try {
        const { desde, hasta } = req.query;
        
        if (!desde || !hasta) {
            return res.status(400).json({ error: 'Fechas requeridas: desde y hasta' });
        }

        const [rows] = await db.promise().query('CALL sp_reporte_ventas_mensuales(?, ?)', [desde, hasta]);
        res.json(rows[0] || []);
    } catch (err) {
        console.error('Error en ventas-mensuales:', err);
        res.status(500).json({ error: err.message });
    }
});

// Top Clientes
router.get('/top-clientes', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_reporte_top_clientes()');
        res.json(rows[0] || []);
    } catch (error) {
        console.error('Error al obtener top clientes:', error);
        res.status(500).json({ error: 'Error en el servidor' });
    }
});

// Servicios más vendidos - CORREGIDO
router.get('/servicios-populares', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_reporte_servicios_populares()');
        res.json(rows[0] || []);
    } catch (err) {
        console.error('Error en servicios-populares:', err);
        res.status(500).json({ error: err.message });
    }
});

// Distribución de ingresos por tipo - CORREGIDO
router.get('/ingresos-por-tipo', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_reporte_ingresos_por_tipo()');
        res.json(rows[0] || []);
    } catch (err) {
        console.error('Error en ingresos-por-tipo:', err);
        res.status(500).json({ error: err.message });
    }
});

// Reporte de cotizaciones
router.get('/cotizaciones', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_reporte_cotizaciones()');
        res.json(rows[0] || []);
    } catch (err) {
        console.error('Error al obtener reporte de cotizaciones:', err);
        res.status(500).json({ error: 'Error al obtener el reporte de cotizaciones' });
    }
});

// Reporte de entradas
router.get('/entradas', async (req, res) => {
    try {
        const [results] = await db.promise().query('CALL sp_reporte_entradas()');
        res.json(results[0] || []);
    } catch (err) {
        console.error('Error en reporte entradas:', err);
        res.status(500).json({ error: err.message });
    }
});

// Reporte de inventario
router.get('/inventario', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_reporte_inventario()');
        res.json({ data: rows[0] || [] });
    } catch (error) {
        console.error('Error en reporte inventario:', error);
        res.status(500).json({ error: 'Error al generar el reporte de inventario' });
    }
});

// Reporte de eventos
router.get('/eventos', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_reporte_eventos()');
        res.json(rows[0] || []);
    } catch (error) {
        console.error('Error al obtener eventos:', error);
        res.status(500).json({ error: 'Error al obtener eventos' });
    }
});

// Total eventos
router.get('/total-eventos', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_total_eventos()');
        res.json(rows[0][0] || { total_eventos: 0 });
    } catch (error) {
        console.error('Error en /total-eventos:', error);
        res.status(500).json({ error: 'Error al obtener total de eventos' });
    }
});

// Reporte de clientes
router.get('/clientes', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_reporte_clientes()');
        res.json(rows[0] || []);
    } catch (error) {
        console.error('Error al obtener reporte de clientes:', error);
        res.status(500).json({ error: 'Error al obtener el reporte de clientes' });
    }
});

// Total de Clientes
router.get('/total-clientes', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_total_clientes()');
        res.json(rows[0][0] || { total_clientes: 0 });
    } catch (error) {
        console.error('Error al obtener total de clientes:', error);
        res.status(500).json({ error: 'Error al obtener el total de clientes' });
    }
});


// Llama a los empleados 
router.get('/empleados', async (req, res) => {
  try {
    const [rows] = await db.promise().query('CALL sp_reporte_empleados_detallado()');
    res.json(rows[0]); // el resultado viene como [ [resultado], [metadata] ]
  } catch (error) {
    console.error('Error al obtener reporte de empleados:', error);
    res.status(500).json({ mensaje: 'Error interno del servidor' });
  }
});


//  Total de empleados activos
router.get('/total-empleados', async (req, res) => {
  try {
    const [rows] = await db.promise().query("CALL sp_total_empleados()");
    res.json(rows[0]); // el resultado está en rows[0]
  } catch (error) {
    console.error('Error al obtener total de empleados:', error);
    res.status(500).json({ error: 'Error al obtener total de empleados' });
  }
});


// llama a la factura de lunes a viernes 
router.get('/ventas-lunes-viernes', async (req, res) => {
    try {
        const [rows] = await db.promise().query('CALL sp_ventas_lunes_a_viernes()');
        res.json(rows[0]);
    } catch (error) {
        console.error('Error al obtener ventas lunes a viernes:', error);
        res.status(500).json({ error: 'Error al obtener ventas lunes a viernes' });
    }
});


// ventas que se hicieron de sabado a domingo 
router.get('/ventas-weekend', async (req, res) => {
    try {
        const [result] = await db.promise().query("CALL sp_ventas_chiminike_weekend()");
        res.json(result[0]);
    } catch (error) {
        console.error("Error al obtener ventas de fin de semana:", error);
        res.status(500).json({ mensaje: 'Error interno del servidor' });
    }
});

 // llamaa total cotizaciones 
router.get('/total-cotizaciones', async (req, res) => {
    try {
        const [result] = await db.promise().query("CALL sp_total_cotizaciones()");
        res.json(result[0]); // Devolvemos solo el primer conjunto de resultados
    } catch (error) {
        console.error('Error al obtener total de cotizaciones:', error);
        res.status(500).json({ error: 'Error al obtener total de cotizaciones' });
    }
});

// lama al reporte reservaciones 
router.get('/reporte-reservaciones', async (req, res) => {
    try {
        const [result] = await db.promise().query("CALL sp_reporte_reservaciones()");
        res.json(result[0]); // Devuelve los datos
    } catch (error) {
        console.error("Error al obtener reporte de reservaciones:", error);
        res.status(500).json({ mensaje: 'Error interno del servidor' });
    }
});


// GET /api/reportes/total-reservaciones
router.get('/total-reservaciones', async (req, res) => {
  try {
    const [rows] = await db.promise().query('CALL sp_total_reservaciones()');
    const total = rows[0][0].total_reservaciones || 0;
    res.json({ total_reservaciones: total });
  } catch (error) {
    console.error('Error al obtener total de reservaciones:', error);
    res.status(500).json({ error: 'Error al obtener total de reservaciones' });
  }
});


// llama a las facruras que se hicieron 
router.get('/facturas-por-dia', async (req, res) => {
  try {
    const { desde, hasta } = req.query;

    if (!desde || !hasta) {
      return res.status(400).json({ error: 'Debe proporcionar desde y hasta como fechas.' });
    }

    const [rows] = await db.promise().query("CALL sp_reporte_facturas_por_dia(?, ?)", [desde, hasta]);
    res.json(rows[0]); // El resultado está en rows[0] por ser un SP
  } catch (error) {
    console.error('Error al obtener facturas por día:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});


// facruras hecgas por el cliente 
router.get('/facturas-por-cliente', async (req, res) => {
  try {
    const [rows] = await db.promise().query('CALL sp_reporte_facturas_por_cliente()');
    res.json(rows[0]);
  } catch (error) {
    console.error('Error al obtener facturas por cliente:', error);
    res.status(500).json({ error: 'Error en el servidor' });
  }
});

// llama a los salones 
router.get('/salones-estado', async (req, res) => {
  try {
    const [rows] = await db.promise().query("CALL sp_reporte_salones_estado()");
    res.json(rows[0]);
  } catch (error) {
    console.error('Error al obtener reporte de salones:', error);
    res.status(500).json({ error: 'Error interno al generar reporte de salones' });
  }
});



module.exports = router;