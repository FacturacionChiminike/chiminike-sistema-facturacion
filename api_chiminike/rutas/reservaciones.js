const express = require("express");
const router = express.Router();
const db = require("../index");


router.get("/reservaciones", (req, res) => {
  const sql = "CALL sp_reservaciones('mostrar_todo', NULL, NULL, NULL, NULL, NULL)";

  db.query(sql, (err, results) => {
    if (err) {
      console.error("Error al obtener reservaciones:", err);
      return res
        .status(500)
        .json({ mensaje: "Error al obtener reservaciones", error: err.message });
    }

    const reservaciones = results[0] || [];
    res.status(200).json(reservaciones);
  });
});

router.get("/reservaciones/:id", (req, res) => {
  const { id } = req.params;
  const sql = "CALL sp_reservaciones('mostrar_id', ?, NULL, NULL, NULL, NULL)";

  db.query(sql, [id], (err, results) => {
    if (err) {
      console.error("Error al obtener la reservación:", err);
      return res
        .status(500)
        .json({ mensaje: "Error al obtener la reservación", error: err.message });
    }

    const reservaciones = results[0] || [];
    res.status(200).json(reservaciones);
  });
});



//error y prueba 
router.put("/reservaciones.upd/:id", (req, res) => {
  const { id } = req.params;
  const {
    nombre_evento,
    fecha_programa,
    hora_programada,
    horas_evento,
    productos 
  } = req.body;

  if (!nombre_evento || !fecha_programa || !hora_programada || !horas_evento) {
    return res.status(400).json({ mensaje: "Faltan campos obligatorios." });
  }

  // Convertir productos a JSON string si existen
  let jsonProductos = "";
  if (productos && Array.isArray(productos) && productos.length > 0) {
    jsonProductos = JSON.stringify(productos);
  }

  const sql = "CALL sp_actualizar_reservacion_completa(?, ?, ?, ?, ?, ?)";

  db.query(
    sql,
    [id, nombre_evento, fecha_programa, hora_programada, horas_evento, jsonProductos],
    (err, results) => {
      if (err) {
        console.error(" Error al actualizar la reservación:", err);
        return res
          .status(500)
          .json({ mensaje: "Error al actualizar la reservación", error: err.message });
      }

      const mensaje = results[0][0]?.mensaje || "Reservación y productos actualizados correctamente";
      res.status(200).json({ mensaje });
    }
  );
});



//prueba y error
router.get("/reservaciones.get/:id", (req, res) => {
  const { id } = req.params;
  const sql = "CALL sp_reservaciones('mostrar_id', ?, NULL, NULL, NULL, NULL)";

  db.query(sql, [id], (err, results) => {
    if (err) {
      console.error("Error al obtener reservación:", err);
      return res.status(500).json({ mensaje: "Error", error: err.message });
    }

    const data = results[0] || [];

    if (data.length === 0) {
      return res.status(404).json({ mensaje: "Reservación no encontrada" });
    }

    // 🪄 TRANSFORMACIÓN limpia:
    const evento = {
      cod_evento: data[0].cod_evento,
      nombre_evento: data[0].nombre_evento,
      fecha_programa: data[0].fecha_programa,
      hora_programada: data[0].hora_programada,
      horas_evento: data[0].horas_evento,
      cliente: data[0].cliente,
      estado: data[0].estado
    };

    const productos = data.map(item => ({
      cantidad: item.cantidad,
      descripcion: item.descripcion,
      precio_unitario: item.precio_unitario,
      total: item.total
    }));

    res.status(200).json({ evento, productos });
  });
});

const enviarCotizacionPDF = require("../utils/enviarCotizacionPDF"); 


router.post("/email/cotizacion", async (req, res) => {
    try {
        const { path, nombre_archivo, correo, asunto, mensaje } = req.body;

        if (!path || !nombre_archivo || !correo) {
            return res.status(400).json({
                mensaje: "Faltan campos obligatorios",
                detalles: { path, nombre_archivo, correo }
            });
        }

        await enviarCorreo({
            to: correo,
            subject: asunto || "Cotización de Evento - Museo Chiminike",
            text: mensaje || "Adjunto encontrarás la cotización solicitada.",
            attachments: [
                {
                    filename: nombre_archivo,
                    path: path
                }
            ]
        });

        return res.status(200).json({ mensaje: "Correo enviado correctamente con el PDF adjunto." });
    } catch (e) {
        console.error("Error al enviar correo de cotización:", e.message);
        res.status(500).json({ mensaje: "Error al enviar el correo.", error: e.message });
    }
});




module.exports = router;