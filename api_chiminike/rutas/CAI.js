const express = require("express");
const router = express.Router();
const db = require("../index");
const { registrarBitacora } = require("../helpers/bitacora");
const obtenerIP = require("../helpers/ip");
const verificarToken = require("../middlewares/verificarToken");
const bitacora = require("../middlewares/bitacora");

///CAI

// Mostrar todos los CAI
router.get("/cai.get", (req, res) => {
  db.query(
    "CALL sp_gestion_cai(?, ?, ?, ?, ?, ?, ?)",
    ['mostrar', null, null, null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar CAI:", err);
        return res.status(500).json({ mensaje: "Error al mostrar CAI" });
      }
      res.status(200).json(results[0]);
    }
  );
});

// Mostrar un CAI por ID
router.get("/cai/:id", (req, res) => {
  const cod_cai = parseInt(req.params.id);

  db.query(
    "CALL sp_gestion_cai(?, ?, ?, ?, ?, ?, ?)",
    ['mostrar_por_id', cod_cai, null, null, null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al buscar CAI:", err);
        return res.status(500).json({ mensaje: "Error al buscar CAI" });
      }
      res.status(200).json(results[0][0]); // solo 1 registro
    }
  );
});

// Insertar nuevo CAI
router.post("/cai", verificarToken, async (req, res) => {
  const { cai, rango_desde, rango_hasta, fecha_limite } = req.body;

  // 🔍 Validación básica opcional
  if (!cai || !rango_desde || !rango_hasta || !fecha_limite) {
    return res.status(400).json({ mensaje: "Faltan campos obligatorios." });
  }

  try {
    db.query(
      "CALL sp_gestion_cai(?, ?, ?, ?, ?, ?, ?)",
      ['insertar', null, cai, rango_desde, rango_hasta, fecha_limite, null],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al insertar CAI:", err);
          return res.status(500).json({ mensaje: "Error al insertar CAI" });
        }

        const mensaje = results?.[0]?.[0]?.mensaje || "CAI insertado correctamente";

        // 📒 Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);
          const datos = { cai, rango_desde, rango_hasta, fecha_limite };

          await registrarBitacora(
            cod_usuario,
            "CAI",
            "Crear",
            ip,
            null,
            datos
          );

          console.log("📘 Bitácora de inserción de CAI registrada.");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
          // No hacemos return para no romper la inserción
        }

        res.status(200).json({ mensaje });
      }
    );
  } catch (e) {
    console.error("🔥 Error inesperado en /cai:", e.message);
    res.status(500).json({ mensaje: "Error interno", error: e.message });
  }
});



// Actualizar CAI con estado
router.put("/cai/:id", verificarToken, async (req, res) => {
  const cod_cai = parseInt(req.params.id);
  const { cai, rango_desde, rango_hasta, fecha_limite, estado } = req.body;

  if (!cai || !rango_desde || !rango_hasta || !fecha_limite || !estado) {
    return res.status(400).json({ mensaje: "Faltan campos obligatorios." });
  }

  try {
    // ✅ 1. Traer datos actuales antes de la actualización
    const datosAntesRaw = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_gestion_cai('mostrar_id', ?, NULL, NULL, NULL, NULL, NULL)",
        [cod_cai],
        (err, result) => {
          if (err) return reject(err);
          resolve(result);
        }
      );
    });

    const datosAntes = datosAntesRaw?.[0]?.[0] || null;

    // ✅ 2. Ejecutar actualización
    db.query(
      "CALL sp_gestion_cai(?, ?, ?, ?, ?, ?, ?)",
      ['actualizar', cod_cai, cai, rango_desde, rango_hasta, fecha_limite, estado],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al actualizar CAI:", err);
          return res.status(500).json({ mensaje: "Error al actualizar CAI" });
        }

        const mensaje = results?.[0]?.[0]?.mensaje || "CAI actualizado correctamente";

        // ✅ 3. Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          const datosDespues = {
            cai,
            rango_desde,
            rango_hasta,
            fecha_limite,
            estado,
          };

          await registrarBitacora(
            cod_usuario,
            "CAI",
            "Actualizar",
            ip,
            datosAntes,
            datosDespues
          );

          console.log("📒 Bitácora de actualización de CAI registrada.");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.status(200).json({ mensaje });
      }
    );
  } catch (e) {
    console.error("🔥 Error general al actualizar CAI:", e.message);
    res.status(500).json({ mensaje: "Error interno", error: e.message });
  }
});



// Eliminar CAI
router.delete("/cai/:id", verificarToken, async (req, res) => {
  const cod_cai = parseInt(req.params.id);

  try {
    // 🔍 1. Traer datos antes de eliminar
    const datosAntes = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_gestion_cai(?, ?, ?, ?, ?, ?, ?)",
        ['mostrar_por_id', cod_cai, null, null, null, null, null],
        (err, results) => {
          if (err) return reject(err);
          resolve(results[0]?.[0] || null);
        }
      );
    });

    // 🗑️ 2. Ejecutar eliminación
    db.query(
      "CALL sp_gestion_cai(?, ?, ?, ?, ?, ?, ?)",
      ['eliminar', cod_cai, null, null, null, null, null],
      async (err, results) => {
        if (err) {
          console.error("Error al eliminar CAI:", err);
          return res.status(500).json({ mensaje: "Error al eliminar CAI" });
        }

        const mensaje = results[0]?.[0]?.mensaje || "CAI eliminado correctamente";

        // 📝 3. Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          await registrarBitacora(
            cod_usuario,
            "CAI",
            "Eliminar",
            ip,
            datosAntes,
            null
          );

          console.log("📒 Bitácora de eliminación de CAI registrada.");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar bitácora:", bitErr);
        }

        return res.status(200).json({ mensaje });
      }
    );
  } catch (e) {
    console.error("🔥 Error general en eliminación de CAI:", e);
    return res.status(500).json({ mensaje: "Error interno al eliminar CAI" });
  }
});



module.exports = router;