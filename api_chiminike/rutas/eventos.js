const express = require("express");
const router = express.Router();
const db = require("../index");
const { registrarBitacora } = require("../helpers/bitacora");
const obtenerIP = require("../helpers/ip");
const verificarToken = require("../middlewares/verificarToken");
const bitacora = require("../middlewares/bitacora");


// actualizar evento
router.put("/cotizaciones.upd/:id", verificarToken, async (req, res) => {
  const { id } = req.params;
  const {
    nombre_evento,
    fecha_programa,
    hora_programada,
    horas_evento,
    productos,
    estado,
  } = req.body;

 
  if (
    !nombre_evento ||
    !fecha_programa ||
    !hora_programada ||
    horas_evento === undefined ||
    !estado
  ) {
    return res.status(400).json({ mensaje: "Faltan campos obligatorios." });
  }

  const estadosValidos = ["pendiente", "confirmada", "expirada", "completada"];
  if (!estadosValidos.includes(estado)) {
    return res.status(400).json({ mensaje: "Estado no válido." });
  }

  let jsonProductos = "";
  if (productos && Array.isArray(productos) && productos.length > 0) {
    jsonProductos = JSON.stringify(productos);
  }

  try {
    // 1. Traer datos actuales antes de la actualización
    const datosAntesCrudos = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_cotizaciones('mostrar_id', ?, NULL, NULL, NULL, NULL)",
        [id],
        (err, result) => {
          if (err) return reject(err);
          resolve(result);
        }
      );
    });

    const filas = datosAntesCrudos?.[0] || [];

    let datosAntes = null;

    if (filas.length > 0) {
      datosAntes = {
        cod_cotizacion: filas[0].cod_cotizacion,
        fecha: filas[0].fecha,
        fecha_validez: filas[0].fecha_validez,
        estado: filas[0].estado,
        nombre_evento: filas[0].nombre_evento,
        fecha_programa: filas[0].fecha_programa,
        hora_programada: filas[0].hora_programada,
        horas_evento: filas[0].horas_evento,
        cliente: filas[0].cliente,
        productos: filas.map((p) => ({
          cantidad: p.cantidad,
          descripcion: p.descripcion,
          precio_unitario: parseFloat(p.precio_unitario),
          total: parseFloat(p.total),
        })),
      };
    }

    // 2. Ejecutar actualización
    const sql = "CALL sp_actualizar_cotizacion_completa(?, ?, ?, ?, ?, ?, ?)";

    db.query(
      sql,
      [
        id,
        nombre_evento,
        fecha_programa,
        hora_programada,
        horas_evento,
        jsonProductos,
        estado,
      ],
      async (err, results) => {
        if (err) {
          console.error(" Error al actualizar la cotización:", err);
          return res.status(500).json({
            mensaje: "Error al actualizar la cotización.",
            error: err.message,
          });
        }

        const mensaje = results[0][0]?.mensaje;

        if (mensaje && mensaje.startsWith("Error SQL")) {
          return res.status(400).json({ error: mensaje });
        }

        //  3. Registrar en bitácora después de actualizar
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          const datosDespues = {
            nombre_evento,
            fecha_programa,
            hora_programada,
            horas_evento,
            estado,
            productos,
          };

          await registrarBitacora(
            cod_usuario,
            "Cotización",
            "Actualizar",
            ip,
            datosAntes,
            datosDespues
          );

          console.log("📒 Bitácora registrada exitosamente.");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.status(200).json({
          mensaje:
            mensaje || "Cotización, estado y productos actualizados correctamente",
        });
      }
    );
  } catch (e) {
    console.error(" Error general en actualización de cotización:", e.message);
    return res.status(500).json({ mensaje: "Error interno", error: e.message });
  }
});



router.get("/cotizaciones", (req, res) => {
  const sql =
    "CALL sp_cotizaciones('mostrar_todo', NULL, NULL, NULL, NULL, NULL)";

  db.query(sql, (err, results) => {
    if (err) {
      console.error("Error al obtener cotizaciones:", err);
      return res
        .status(500)
        .json({ mensaje: "Error al obtener cotizaciones", error: err.message });
    }

    const cotizaciones = results[0] || [];
    res.status(200).json(cotizaciones);
  });
});

router.get("/cotizaciones.get/:id", (req, res) => {
  const { id } = req.params;
  const sql = "CALL sp_cotizaciones('mostrar_id', ?, NULL, NULL, NULL, NULL)";

  db.query(sql, [id], (err, results) => {
    if (err) {
      console.error("Error al obtener cotización:", err);
      return res.status(500).json({ mensaje: "Error", error: err.message });
    }

    const data = results[0] || [];

    if (data.length === 0) {
      return res
        .status(404)
        .json({ mensaje: "Cotización no encontrada o no confirmada" });
    }

    const cotizacion = {
      cod_cotizacion: data[0].cod_cotizacion,
      fecha: data[0].fecha,
      fecha_validez: data[0].fecha_validez,
      estado: data[0].estado,
      nombre_evento: data[0].nombre_evento,
      fecha_programa: data[0].fecha_programa,
      hora_programada: data[0].hora_programada,
      horas_evento: data[0].horas_evento,
      nombre_cliente: data[0].nombre_cliente,
      telefono_cliente: data[0].telefono_cliente,
      correo_cliente: data[0].correo_cliente,
    };

    const productos = data.map((item) => ({
      cantidad: item.cantidad,
      descripcion: item.descripcion,
      precio_unitario: item.precio_unitario,
      total: item.total,
    }));

    res.status(200).json({ cotizacion, productos });
  });
});

const enviarCotizacionPDF = require("../utils/enviarCotizacionPDF");

router.post("/email/enviar", async (req, res) => {
  const { correo, nombre, codCotizacion } = req.body;

  try {
    await enviarCotizacionPDF(correo, nombre, codCotizacion);
    res.status(200).json({ success: true, mensaje: "Correo enviado" });
  } catch (error) {
    res.status(500).json({
      success: false,
      mensaje: "Error al enviar correo",
      error: error.message,
    });
  }
});

router.delete("/cotizacion/:id", verificarToken, async (req, res) => {
  const id = parseInt(req.params.id);

  if (isNaN(id)) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  try {
    // ✅ 1. Traer datos antes de marcar como expirada
    const datosAntesCrudos = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_cotizaciones('mostrar_id', ?, NULL, NULL, NULL, NULL)",
        [id],
        (err, result) => {
          if (err) return reject(err);
          resolve(result);
        }
      );
    });

    const filas = datosAntesCrudos?.[0] || [];

    let datosAntes = null;

    if (filas.length > 0) {
      datosAntes = {
        cod_cotizacion: filas[0].cod_cotizacion,
        fecha: filas[0].fecha,
        fecha_validez: filas[0].fecha_validez,
        estado: filas[0].estado,
        nombre_evento: filas[0].nombre_evento,
        fecha_programa: filas[0].fecha_programa,
        hora_programada: filas[0].hora_programada,
        horas_evento: filas[0].horas_evento,
        cliente: filas[0].cliente,
        productos: filas.map((p) => ({
          cantidad: p.cantidad,
          descripcion: p.descripcion,
          precio_unitario: parseFloat(p.precio_unitario),
          total: parseFloat(p.total),
        })),
      };
    }

    // ✅ 2. Ejecutar expiración
    db.query("CALL sp_expirar_cotizacion(?)", [id], async (err, results) => {
      if (err) {
        console.error("❌ Error al expirar cotización:", err);
        return res
          .status(500)
          .json({ mensaje: "Error al expirar cotización" });
      }

      const mensaje =
        results?.[0]?.[0]?.mensaje ||
        "Cotización marcada como expirada correctamente.";

      // ✅ 3. Registrar en bitácora
      try {
        const cod_usuario = req.usuario?.cod_usuario;
        const ip = obtenerIP(req);

        await registrarBitacora(
          cod_usuario,
          "Cotización",
          "Eliminar", // o "Expirar" si querés registrar más específico
          ip,
          datosAntes,
          { mensaje }
        );

        console.log("📒 Bitácora de expiración registrada.");
      } catch (bitErr) {
        console.error("⚠️ Error al registrar en bitácora:", bitErr);
      }

      res.json({ mensaje });
    });
  } catch (e) {
    console.error("🔥 Error general al eliminar:", e.message);
    return res
      .status(500)
      .json({ mensaje: "Error interno", error: e.message });
  }
});

// MOSTRAR
router.get("/salones", (req, res) => {
  db.query(
    "CALL sp_gestion_salon(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
    ["MOSTRAR", null, null, null, null, null, null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar salones: ", err);
        return res.status(500).json({ mensaje: "Error al obtener salones" });
      }
      res.json(results[0]);
    }
  );
});

//MOSTRAR SALON POR ID
router.get("/salones/:id", (req, res) => {
  const id = parseInt(req.params.id);

  db.query(
    "CALL sp_gestion_salon(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
    ["MOSTRAR_ID", id, null, null, null, null, null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar salón por ID: ", err);
        return res.status(500).json({ mensaje: "Error al obtener salón" });
      }

      if (results[0].length === 0) {
        return res.status(404).json({ mensaje: "Salón no encontrado" });
      }

      res.json(results[0][0]);
    }
  );
});

// INSERTAR
router.post("/salones", verificarToken, async (req, res) => {
  const {
    nombre,
    descripcion,
    capacidad,
    estado,
    precio_dia,
    precio_noche,
    precio_hora_extra_dia,
    precio_hora_extra_noche,
  } = req.body;

  console.log("📥 Datos recibidos para insertar salón:");
  console.log({
    nombre,
    descripcion,
    capacidad,
    estado,
    precio_dia,
    precio_noche,
    precio_hora_extra_dia,
    precio_hora_extra_noche,
  });

  // Ahora sí, seguís con el query
  const parametros = [
    "INSERTAR",
    null,
    nombre,
    descripcion,
    capacidad,
    estado,
    precio_dia,
    precio_noche,
    precio_hora_extra_dia,
    precio_hora_extra_noche,
  ];

  db.query("CALL sp_gestion_salon(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", parametros, async (err, results) => {
    // ...
  });
});

// ACTUALIZAR
router.put("/salones/:id", verificarToken, async (req, res) => {
  const cod_salon = parseInt(req.params.id);
  const {
    nombre,
    descripcion,
    capacidad,
    estado,
    precio_dia,
    precio_noche,
    precio_hora_extra_dia,
    precio_hora_extra_noche,
  } = req.body;

  if (
    !nombre ||
    !descripcion ||
    capacidad === undefined ||
    !estado ||
    precio_dia === undefined ||
    precio_noche === undefined ||
    precio_hora_extra_dia === undefined ||
    precio_hora_extra_noche === undefined
  ) {
    return res.status(400).json({ mensaje: "Faltan campos obligatorios." });
  }

  try {
    // ✅ 1. Obtener datos actuales antes de actualizar
    const datosAntesRaw = await new Promise((resolve, reject) => {
      db.query("CALL sp_gestion_salon('MOSTRAR_ID', ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", [cod_salon], (err, result) => {
        if (err) return reject(err);
        resolve(result);
      });
    });

    const datosAntes = datosAntesRaw?.[0]?.[0] || null;

    // ✅ 2. Ejecutar la actualización
    db.query(
      "CALL sp_gestion_salon(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
      [
        "ACTUALIZAR",
        cod_salon,
        nombre,
        descripcion,
        capacidad,
        estado,
        precio_dia,
        precio_noche,
        precio_hora_extra_dia,
        precio_hora_extra_noche,
      ],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al actualizar salón:", err);
          return res.status(500).json({ mensaje: "Error al actualizar salón" });
        }

        const mensaje = results?.[0]?.[0]?.mensaje || "Salón actualizado correctamente";

        // ✅ 3. Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          const datosDespues = {
            nombre,
            descripcion,
            capacidad,
            estado,
            precio_dia,
            precio_noche,
            precio_hora_extra_dia,
            precio_hora_extra_noche,
          };

          await registrarBitacora(
            cod_usuario,
            "Salón",
            "Actualizar",
            ip,
            datosAntes,
            datosDespues
          );

          console.log("📒 Bitácora de actualización de salón registrada.");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.status(200).json({ mensaje });
      }
    );
  } catch (e) {
    console.error("🔥 Error general en actualización de salón:", e.message);
    res.status(500).json({ mensaje: "Error interno", error: e.message });
  }
});
// ELIMINAR
router.delete("/salones/:id", verificarToken, async (req, res) => {
  const cod_salon = parseInt(req.params.id);

  if (isNaN(cod_salon)) {
    return res.status(400).json({ mensaje: "ID inválido." });
  }

  try {
    // ✅ 1. Obtener datos antes de eliminar
    const datosAntesRaw = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_gestion_salon('MOSTRAR_ID', ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)",
        [cod_salon],
        (err, result) => {
          if (err) return reject(err);
          resolve(result);
        }
      );
    });

    const datosAntes = datosAntesRaw?.[0]?.[0] || null;

    // ✅ 2. Eliminar el salón
    db.query(
      "CALL sp_gestion_salon(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
      ["ELIMINAR", cod_salon, null, null, null, null, null, null, null, null],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al eliminar salón:", err);
          return res.status(500).json({ mensaje: "Error al eliminar salón" });
        }

        const mensaje = results?.[0]?.[0]?.mensaje || "Salón eliminado correctamente.";

        // ✅ 3. Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          await registrarBitacora(
            cod_usuario,
            "Salón",
            "Eliminar",
            ip,
            datosAntes,
            { mensaje }
          );

          console.log("📒 Bitácora de eliminación de salón registrada.");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.json({ mensaje });
      }
    );
  } catch (e) {
    console.error("🔥 Error general al eliminar salón:", e.message);
    res.status(500).json({ mensaje: "Error interno", error: e.message });
  }
});

// MOSTRAR TODOS
router.get("/inventario", (req, res) => {
  db.query(
    "CALL sp_gestion_inventario(?, ?, ?, ?, ?, ?, ?)",
    ["MOSTRAR", null, null, null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar inventario:", err);
        return res.status(500).json({ mensaje: "Error al obtener inventario" });
      }
      res.json(results[0]);
    }
  );
});

// MOSTRAR POR ID
router.get("/inventario/:id", (req, res) => {
  const id = parseInt(req.params.id);
  db.query(
    "CALL sp_gestion_inventario(?, ?, ?, ?, ?, ?, ?)",
    ["MOSTRAR_ID", id, null, null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al obtener inventario por ID:", err);
        return res.status(500).json({ mensaje: "Error al obtener inventario" });
      }
      if (results[0].length === 0) {
        return res.status(404).json({ mensaje: "Inventario no encontrado" });
      }
      res.json(results[0][0]);
    }
  );
});

// INSERTAR
router.post("/inventario", verificarToken, async (req, res) => {
  const { nombre, descripcion, precio_unitario, cantidad_disponible, estado } = req.body;

  if (!nombre || precio_unitario === undefined || cantidad_disponible === undefined || !estado) {
    return res.status(400).json({ mensaje: "Faltan campos obligatorios." });
  }

  try {
    db.query(
      "CALL sp_gestion_inventario(?, ?, ?, ?, ?, ?, ?)",
      ["INSERTAR", null, nombre, descripcion, precio_unitario, cantidad_disponible, estado],
      async (err, results) => {
        if (err) {
          console.error(" Error al insertar inventario:", err);
          return res.status(500).json({ mensaje: "Error al insertar inventario" });
        }

        //  Intentamos registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);
          const datos = { nombre, descripcion, precio_unitario, cantidad_disponible, estado };

          await registrarBitacora(
            cod_usuario,
            "Inventario",
            "Crear",
            ip,
            null,
            datos
          );

          console.log("📒 Bitácora registrada correctamente.");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar bitácora:", bitErr);
          // ⚠️ OJO: No hacemos return aquí, porque no queremos romper la API si solo falló la bitácora
        }

        res.status(201).json({ mensaje: "Inventario insertado correctamente" });
      }
    );
  } catch (e) {
    console.error("🔥 Error inesperado en /inventario:", e.message);
    res.status(500).json({ mensaje: "Error interno en el servidor", error: e.message });
  }
});


// ACTUALIZAR
router.put("/inventario/:id", verificarToken, async (req, res) => {
  const id = parseInt(req.params.id);

  const { nombre, descripcion, precio_unitario, cantidad_disponible, estado } = req.body;

  if (
    !nombre ||
    precio_unitario === undefined ||
    cantidad_disponible === undefined ||
    !estado
  ) {
    return res.status(400).json({ mensaje: "Faltan campos obligatorios." });
  }

  try {
    // ✅ 1. Obtener datos antes
    const datosAntesRaw = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_gestion_inventario('MOSTRAR_ID', ?, NULL, NULL, NULL, NULL, NULL)",
        [id],
        (err, result) => {
          if (err) return reject(err);
          resolve(result);
        }
      );
    });

    const datosAntes = datosAntesRaw?.[0]?.[0] || null;

    // ✅ 2. Ejecutar actualización
    db.query(
      "CALL sp_gestion_inventario(?, ?, ?, ?, ?, ?, ?)",
      [
        "ACTUALIZAR",
        id,
        nombre,
        descripcion,
        precio_unitario,
        cantidad_disponible,
        estado,
      ],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al actualizar inventario:", err);
          return res.status(500).json({ mensaje: "Error al actualizar inventario" });
        }

        const mensaje = results?.[0]?.[0]?.mensaje || "Inventario actualizado correctamente";

        // ✅ 3. Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          const datosDespues = {
            nombre,
            descripcion,
            precio_unitario,
            cantidad_disponible,
            estado,
          };

          await registrarBitacora(
            cod_usuario,
            "Inventario",
            "Actualizar",
            ip,
            datosAntes,
            datosDespues
          );

          console.log("📒 Bitácora de actualización registrada.");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar bitácora:", bitErr);
        }

        res.json({ mensaje });
      }
    );
  } catch (e) {
    console.error("🔥 Error general:", e.message);
    res.status(500).json({ mensaje: "Error interno", error: e.message });
  }
});

// ELIMINAR
router.delete("/inventario/:id", verificarToken, async (req, res) => {
  const id = parseInt(req.params.id);

  if (isNaN(id)) {
    return res.status(400).json({ mensaje: "ID inválido" });
  }

  try {
    // ✅ 1. Obtener datos antes de eliminar
    const datosAntesRaw = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_gestion_inventario('MOSTRAR_ID', ?, NULL, NULL, NULL, NULL, NULL)",
        [id],
        (err, result) => {
          if (err) return reject(err);
          resolve(result);
        }
      );
    });

    const datosAntes = datosAntesRaw?.[0]?.[0] || null;

    // ✅ 2. Ejecutar eliminación
    db.query(
      "CALL sp_gestion_inventario(?, ?, ?, ?, ?, ?, ?)",
      ["ELIMINAR", id, null, null, null, null, null],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al eliminar inventario:", err);
          return res.status(500).json({ mensaje: "Error al eliminar inventario" });
        }

        const mensaje = results?.[0]?.[0]?.mensaje || "Inventario eliminado correctamente";

        // ✅ 3. Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          await registrarBitacora(
            cod_usuario,
            "Inventario",
            "Eliminar",
            ip,
            datosAntes,
            { mensaje }
          );

          console.log("📒 Bitácora de eliminación registrada.");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.json({ mensaje });
      }
    );
  } catch (e) {
    console.error("🔥 Error general al eliminar inventario:", e.message);
    res.status(500).json({ mensaje: "Error interno", error: e.message });
  }
});

router.get("/catalogos-cotizacion", (req, res) => {
  db.query("CALL sp_obtener_catalogos_cotizacion()", (err, results) => {
    if (err) {
      return res.status(500).json({
        success: false,
        mensaje: "Error al obtener catálogos de cotización",
        error: err.message,
      });
    }

    const [entradas, paquetes, adicionales, inventario, salones] = results;

    res.json({
      success: true,
      data: {
        entradas,
        paquetes,
        adicionales,
        inventario,
        salones,
      },
    });
  });
});

//con cliente existente jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj

router.post(
  "/cotizacion.new",
  verificarToken,
  bitacora("Cotización", "Crear"),
  async (req, res) => {
    try {
      const {
        cod_cliente,
        nombre,
        fecha_nacimiento,
        sexo,
        dni,
        correo,
        telefono,
        direccion,
        cod_municipio,
        rtn,
        tipo_cliente,
        evento_nombre,
        fecha_evento,
        hora_evento,
        horas_evento,
        productos,
      } = req.body;

      if (
        (!cod_cliente || parseInt(cod_cliente) <= 0) &&
        (!nombre || !sexo || !dni || !correo || !telefono || !direccion || !cod_municipio || !tipo_cliente)
      ) {
        return res.status(400).json({
          mensaje: "Faltan campos obligatorios para cliente nuevo o cliente inexistente",
        });
      }

      if (!evento_nombre || !fecha_evento || !hora_evento || horas_evento === undefined || !productos) {
        return res.status(400).json({
          mensaje: "Faltan campos obligatorios del evento",
        });
      }

      if (isNaN(horas_evento) || parseInt(horas_evento) < 0) {
        return res.status(400).json({
          mensaje: "El campo 'horas_evento' debe ser un número entero no negativo",
        });
      }

      let productosJSON;
      try {
        productosJSON = JSON.stringify(productos);
      } catch (jsonErr) {
        return res.status(400).json({
          mensaje: "Error al convertir productos a JSON",
          error: jsonErr.message,
        });
      }

      const parametros = [
        cod_cliente && parseInt(cod_cliente) > 0 ? parseInt(cod_cliente) : null,
        nombre || null,
        fecha_nacimiento || null,
        sexo || null,
        dni || null,
        correo || null,
        telefono || null,
        direccion || null,
        cod_municipio || null,
        rtn || null,
        tipo_cliente || null,
        evento_nombre,
        fecha_evento,
        hora_evento,
        parseInt(horas_evento),
        productosJSON,
      ];

      console.log("📤 Ejecutando SP con:", parametros);

      db.query("CALL sp_cotizacion_completa(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", parametros, async (err, results) => {
        if (err) {
          console.error("❌ Error al ejecutar el SP:", err.sqlMessage || err.message);
          return res.status(500).json({
            mensaje: "Error interno al insertar cotización",
            error: err.sqlMessage || err.message,
          });
        }

        const resultado = results?.[0]?.[0];
        const cod_cotizacion = resultado?.cod_cotizacion_generada;

        if (!cod_cotizacion) {
          return res.status(500).json({ mensaje: "No se recibió resultado del procedimiento" });
        }

        // 📝 Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          const datosDespues = {
            cod_cotizacion,
            cliente: {
              cod_cliente,
              nombre,
              fecha_nacimiento,
              sexo,
              dni,
              correo,
              telefono,
              direccion,
              cod_municipio,
              rtn,
              tipo_cliente,
            },
            evento: {
              evento_nombre,
              fecha_evento,
              hora_evento,
              horas_evento,
            },
            productos,
          };

          await registrarBitacora(cod_usuario, "Cotización", "Crear", ip, null, datosDespues);
          console.log("✅ Cotización registrada en bitácora");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar bitácora:", bitErr);
        }

        res.status(200).json({
          success: true,
          mensaje: "Cotización creada exitosamente",
          cod_cotizacion,
        });
      });
    } catch (e) {
      console.error("🔥 Error inesperado en /cotizacion.new:", e.message);
      res.status(500).json({ mensaje: "Error inesperado", error: e.message });
    }
  }
);


// Mostrar todas completadas
router.get("/cotizaciones/completadas", (req, res) => {
  db.query(
    "CALL sp_eventos_cotizaciones('mostrar_completadas', NULL)",
    (err, results) => {
      if (err) {
        console.error(err);
        return res
          .status(500)
          .json({ mensaje: "Error al obtener cotizaciones completadas." });
      }
      res.json(results[0]);
    }
  );
});

// Mostrar completada por ID
router.get("/cotizaciones/completadas/:id", (req, res) => {
  const id = parseInt(req.params.id);
  db.query(
    "CALL sp_eventos_cotizaciones('mostrar_completada_id', ?)",
    [id],
    (err, results) => {
      if (err) {
        console.error(err);
        return res
          .status(500)
          .json({ mensaje: "Error al obtener cotización completada." });
      }
      res.json(results[0]);
    }
  );
});

// Mostrar todas expiradas
router.get("/cotizaciones/expiradas", (req, res) => {
  db.query(
    "CALL sp_eventos_cotizaciones('mostrar_expiradas', NULL)",
    (err, results) => {
      if (err) {
        console.error(err);
        return res
          .status(500)
          .json({ mensaje: "Error al obtener cotizaciones expiradas." });
      }
      res.json(results[0]);
    }
  );
});

// Mostrar expirada por ID
router.get("/cotizaciones/expiradas/:id", (req, res) => {
  const id = parseInt(req.params.id);
  db.query(
    "CALL sp_eventos_cotizaciones('mostrar_expirada_id', ?)",
    [id],
    (err, results) => {
      if (err) {
        console.error(err);
        return res
          .status(500)
          .json({ mensaje: "Error al obtener cotización expirada." });
      }
      res.json(results[0]);
    }
  );
});

// Exportar algo del index para que funcione
module.exports = router;
