const express = require("express");
const router = express.Router();
const db = require("../index");
const { registrarBitacora } = require("../helpers/bitacora");
const obtenerIP = require("../helpers/ip");
const verificarToken = require("../middlewares/verificarToken");
const bitacora = require("../middlewares/bitacora");

// MOSTRAR TODOS
router.get("/adicionales", (req, res) => {
  db.query(
    "CALL sp_gestion_adicional(?, ?, ?, ?, ?)",
    ["MOSTRAR", null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar adicionales:", err);
        return res
          .status(500)
          .json({ mensaje: "Error al obtener adicionales" });
      }
      res.json(results[0]);
    }
  );
});

// MOSTRAR POR ID
router.get("/adicionales/:id", (req, res) => {
  const id = parseInt(req.params.id);
  db.query(
    "CALL sp_gestion_adicional(?, ?, ?, ?, ?)",
    ["MOSTRAR_ID", id, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al obtener adicional:", err);
        return res.status(500).json({ mensaje: "Error al obtener adicional" });
      }
      if (results[0].length === 0) {
        return res.status(404).json({ mensaje: "Adicional no encontrado" });
      }
      res.json(results[0][0]);
    }
  );
});

// INSERTAR
router.post(
  "/adicionales",
  verificarToken,
  async (req, res) => {
    const { nombre, descripcion, precio } = req.body;

    db.query(
      "CALL sp_gestion_adicional(?, ?, ?, ?, ?)",
      ["INSERTAR", null, nombre, descripcion, precio],
      async (err, results) => {
        if (err) {
          console.error("Error al insertar adicional:", err);
          return res.status(500).json({ mensaje: "Error al insertar adicional" });
        }

        // ✅ REGISTRAR BITÁCORA
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = req.ip;

          await registrarBitacora(
            cod_usuario,
            "Adicional",
            "Crear",
            ip,
            null, 
            { nombre, descripcion, precio } 
          );

          console.log("📒 Bitácora registrada exitosamente");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.status(200).json({ mensaje: "Adicional insertado correctamente" });
      }
    );
  }
);


// ACTUALIZAR
router.put(
  "/adicionales/:id",
  verificarToken,
  async (req, res) => {
    const id = parseInt(req.params.id);
    const { nombre, descripcion, precio } = req.body;

    try {
      // 1️⃣ Traer datos antes
      const datosAntes = await new Promise((resolve, reject) => {
        db.query(
          "CALL sp_gestion_adicional(?, ?, ?, ?, ?)",
          ["MOSTRAR_ID", id, null, null, null],
          (err, results) => {
            if (err) return reject(err);
            if (!results[0]?.length) return reject(new Error("Adicional no encontrado"));
            resolve(results[0][0]);
          }
        );
      });

      // 2️⃣ Ejecutar la actualización
      db.query(
        "CALL sp_gestion_adicional(?, ?, ?, ?, ?)",
        ["ACTUALIZAR", id, nombre, descripcion, precio],
        async (err, results) => {
          if (err) {
            console.error("Error al actualizar adicional:", err);
            return res.status(500).json({ mensaje: "Error al actualizar adicional" });
          }

          const mensaje = results[0][0]?.mensaje || "Adicional actualizado correctamente";

          // 3️⃣ Registrar en bitácora
          try {
            const cod_usuario = req.usuario?.cod_usuario;
            const ip = obtenerIP(req);
            const datosDespues = { nombre, descripcion, precio };

            await registrarBitacora(
              cod_usuario,
              "Adicional",
              "Actualizar",
              ip,
              datosAntes,
              datosDespues
            );

            console.log("📒 Bitácora de adicional actualizada.");
          } catch (bitErr) {
            console.error("⚠️ Error al registrar en bitácora:", bitErr);
          }

          res.status(200).json({ mensaje });
        }
      );
    } catch (error) {
      console.error("🔥 Error general en actualización de adicional:", error);
      res.status(500).json({ mensaje: "Error general al actualizar adicional" });
    }
  }
);

// ELIMINAR
router.delete("/adicionales/:id", verificarToken, async (req, res) => {
  const id = parseInt(req.params.id);

  try {
    // 🕵️‍♂️ Obtener datos antes de eliminar
    const datosAntes = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_gestion_adicional(?, ?, ?, ?, ?)",
        ["MOSTRAR_ID", id, null, null, null],
        (err, result) => {
          if (err) return reject(err);
          resolve(result[0][0]); // solo un registro
        }
      );
    });

    if (!datosAntes) {
      return res.status(404).json({ mensaje: "Adicional no encontrado" });
    }

    // 🗑 Eliminar adicional
    db.query(
      "CALL sp_gestion_adicional(?, ?, ?, ?, ?)",
      ["ELIMINAR", id, null, null, null],
      async (err, results) => {
        if (err) {
          console.error("Error al eliminar adicional:", err);
          return res.status(500).json({ mensaje: "Error al eliminar adicional" });
        }

        // 📝 Registrar bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          await registrarBitacora(
            cod_usuario,
            "Adicional",
            "Eliminar",
            ip,
            datosAntes,
            null
          );

          console.log("📒 Bitácora registrada con éxito.");
        } catch (bitErr) {
          console.warn("⚠️ No se pudo guardar bitácora:", bitErr);
        }

        res.status(200).json({ mensaje: "Adicional eliminado correctamente" });
      }
    );
  } catch (e) {
    console.error("🔥 Error general al eliminar adicional:", e);
    res.status(500).json({ mensaje: "Error al procesar la eliminación" });
  }
});


// Mostrar todos los paquetes
router.get("/paquetes", (req, res) => {
  db.query(
    "CALL sp_gestion_paquete(?, ?, ?, ?, ?)",
    ["mostrar", null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar paquetes:", err);
        return res.status(500).json({ mensaje: "Error al obtener paquetes" });
      }
      res.json(results[0]);
    }
  );
});

// Mostrar paquete por ID
router.get("/paquetes/:id", (req, res) => {
  const cod_paquete = parseInt(req.params.id);
  db.query(
    "CALL sp_gestion_paquete(?, ?, ?, ?, ?)",
    ["mostrar_por_id", cod_paquete, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar paquete por ID:", err);
        return res.status(500).json({ mensaje: "Error al obtener paquete" });
      }
      res.json(results[0][0] || {});
    }
  );
});

// Insertar paquete
router.post(
  "/paquetes",
  verificarToken,
  async (req, res) => {
    const { nombre, descripcion, precio } = req.body;

    db.query(
      "CALL sp_gestion_paquete(?, ?, ?, ?, ?)",
      ["insertar", null, nombre, descripcion, precio],
      async (err, results) => {
        if (err) {
          console.error("Error al insertar paquete:", err);
          return res.status(500).json({
            mensaje: "Error al insertar paquete",
            error: err.message,
          });
        }

        // ✅ REGISTRAR BITÁCORA MANUALMENTE
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = req.ip;

          await registrarBitacora(
            cod_usuario,
            "Paquete",
            "Crear",
            ip,
            null, // no hay datos anteriores
            { nombre, descripcion, precio } // datos nuevos
          );

          console.log("📒 Bitácora registrada exitosamente");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.status(200).json({ mensaje: "Paquete insertado correctamente" });
      }
    );
  }
);

// Actualizar paquete
router.put(
  "/paquetes/:id",
  verificarToken,
  async (req, res) => {
    const cod_paquete = parseInt(req.params.id);
    const { nombre, descripcion, precio } = req.body;

    try {
      // 🚨 Traer datos antes de actualizar
      const datosAntesCrudos = await new Promise((resolve, reject) => {
        db.query(
          "CALL sp_gestion_paquete(?, ?, ?, ?, ?)",
          ["mostrar_por_id", cod_paquete, null, null, null],
          (err, result) => {
            if (err) return reject(err);
            resolve(result[0]?.[0] || null);
          }
        );
      });

      // 🚀 Ejecutar actualización
      db.query(
        "CALL sp_gestion_paquete(?, ?, ?, ?, ?)",
        ["actualizar", cod_paquete, nombre, descripcion, precio],
        async (err, results) => {
          if (err) {
            console.error("Error al actualizar paquete:", err);
            return res
              .status(500)
              .json({ mensaje: "Error al actualizar paquete" });
          }

          const mensaje = results?.[0]?.[0]?.mensaje || "Paquete actualizado correctamente";

          // 📘 Registrar bitácora
          try {
            const cod_usuario = req.usuario?.cod_usuario;
            const ip = req.ip || req.connection.remoteAddress;

            const datosDespues = { nombre, descripcion, precio };

            await registrarBitacora(
              cod_usuario,
              "Paquete",
              "Actualizar",
              ip,
              datosAntesCrudos,
              datosDespues
            );

            console.log("📘 Bitácora de paquete registrada.");
          } catch (bitErr) {
            console.warn("⚠️ Error al registrar bitácora de paquete:", bitErr);
          }

          res.status(200).json({ mensaje });
        }
      );
    } catch (e) {
      console.error("🔥 Error general al actualizar paquete:", e.message);
      return res.status(500).json({ mensaje: "Error interno", error: e.message });
    }
  }
);


// Eliminar paquete
router.delete(
  "/paquetes/:id",
  verificarToken,
  async (req, res) => {
    const cod_paquete = parseInt(req.params.id);

    try {
      // 📦 Traer datos antes de eliminar
      const datosAntesCrudos = await new Promise((resolve, reject) => {
        db.query(
          "CALL sp_gestion_paquete(?, ?, ?, ?, ?)",
          ["mostrar_por_id", cod_paquete, null, null, null],
          (err, result) => {
            if (err) return reject(err);
            resolve(result[0]?.[0] || null);
          }
        );
      });

      if (!datosAntesCrudos) {
        return res.status(404).json({ mensaje: "Paquete no encontrado" });
      }

      // ❌ Eliminar paquete
      db.query(
        "CALL sp_gestion_paquete(?, ?, ?, ?, ?)",
        ["eliminar", cod_paquete, null, null, null],
        async (err, results) => {
          if (err) {
            console.error("Error al eliminar paquete:", err);
            return res.status(500).json({ mensaje: "Error al eliminar paquete" });
          }

          // 🧠 Bitácora
          try {
            const cod_usuario = req.usuario?.cod_usuario;
            const ip = req.ip || req.connection.remoteAddress;

            await registrarBitacora(
              cod_usuario,
              "Paquete",
              "Eliminar",
              ip,
              datosAntesCrudos,
              null
            );

            console.log("🗑️ Bitácora de eliminación registrada.");
          } catch (bitErr) {
            console.warn("⚠️ Error al registrar bitácora:", bitErr);
          }

          res.status(200).json({ mensaje: "Paquete eliminado correctamente" });
        }
      );
    } catch (error) {
      console.error("🔥 Error general al eliminar paquete:", error.message);
      res.status(500).json({ mensaje: "Error interno", error: error.message });
    }
  }
);


// Mostrar todas las entradas
router.get("/entradas", (req, res) => {
  db.query(
    "CALL sp_gestion_entrada(?, ?, ?, ?)",
    ["mostrar", null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar entradas:", err);
        return res.status(500).json({ mensaje: "Error al obtener entradas" });
      }
      res.json(results[0]);
    }
  );
});

// Mostrar entrada por ID
router.get("/entradas/:id", (req, res) => {
  const cod_entrada = parseInt(req.params.id);
  db.query(
    "CALL sp_gestion_entrada(?, ?, ?, ?)",
    ["mostrar_por_id", cod_entrada, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar entrada por ID:", err);
        return res.status(500).json({ mensaje: "Error al obtener entrada" });
      }
      res.json(results[0][0] || {});
    }
  );
});

// Insertar entrada
router.post(
  "/entradas",
  verificarToken,
  async (req, res) => {
    const { nombre, precio } = req.body;

    db.query(
      "CALL sp_gestion_entrada(?, ?, ?, ?)",
      ["insertar", null, nombre, precio],
      async (err, results) => {
        if (err) {
          console.error("Error al insertar entrada:", err);
          return res.status(500).json({ mensaje: "Error al insertar entrada" });
        }

        // ✅ REGISTRAR BITÁCORA
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = req.ip;

          await registrarBitacora(
            cod_usuario,
            "Entrada",
            "Crear",
            ip,
            null, 
            { nombre, precio } 
          );

          console.log("📒 Bitácora de entrada registrada con éxito");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.status(200).json({ mensaje: "Entrada insertada correctamente" });
      }
    );
  }
);


// Actualizar entrada
router.put(
  "/entradas/:id",
  verificarToken,
  async (req, res) => {
    const cod_entrada = parseInt(req.params.id);
    const { nombre, precio } = req.body;

    try {
      // 🕵️ Obtener datos anteriores
      const [anterior] = await new Promise((resolve, reject) => {
        db.query(
          "CALL sp_gestion_entrada(?, ?, ?, ?)",
          ["mostrar_por_id", cod_entrada, null, null],
          (err, results) => {
            if (err) return reject(err);
            resolve(results[0]);
          }
        );
      });

      // 🔄 Actualizar entrada
      db.query(
        "CALL sp_gestion_entrada(?, ?, ?, ?)",
        ["actualizar", cod_entrada, nombre, precio],
        async (err) => {
          if (err) {
            console.error("❌ Error al actualizar entrada:", err);
            return res.status(500).json({ mensaje: "Error al actualizar entrada" });
          }

          // 📝 Registrar en bitácora
          try {
            const cod_usuario = req.usuario?.cod_usuario;
            const ip = req.ip;

            await registrarBitacora(
              cod_usuario,
              "Entrada",
              "Actualizar",
              ip,
              anterior,
              { nombre, precio }
            );

            console.log("📘 Bitácora registrada correctamente");
          } catch (bitErr) {
            console.error("⚠️ Error al registrar bitácora:", bitErr);
          }

          res.status(200).json({ mensaje: "Entrada actualizada correctamente" });
        }
      );
    } catch (error) {
      console.error("🔥 Error general:", error);
      res.status(500).json({ mensaje: "Error al procesar la actualización" });
    }
  }
);


// Eliminar entrada
router.delete(
  "/entradas/:id",
  verificarToken,
  async (req, res) => {
    const cod_entrada = parseInt(req.params.id);

    try {
      // 🕵️ Obtener datos antes de eliminar
      const [anterior] = await new Promise((resolve, reject) => {
        db.query(
          "CALL sp_gestion_entrada(?, ?, ?, ?)",
          ["mostrar_por_id", cod_entrada, null, null],
          (err, results) => {
            if (err) return reject(err);
            resolve(results[0]);
          }
        );
      });

      // 💣 Eliminar entrada
      db.query(
        "CALL sp_gestion_entrada(?, ?, ?, ?)",
        ["eliminar", cod_entrada, null, null],
        async (err) => {
          if (err) {
            console.error("❌ Error al eliminar entrada:", err);
            return res.status(500).json({ mensaje: "Error al eliminar entrada" });
          }

          // 📝 Registrar en bitácora
          try {
            const cod_usuario = req.usuario?.cod_usuario;
            const ip = req.ip;

            await registrarBitacora(
              cod_usuario,
              "Entrada",
              "Eliminar",
              ip,
              anterior,
              null
            );

            console.log("📕 Bitácora registrada correctamente");
          } catch (bitErr) {
            console.error("⚠️ Error al registrar bitácora:", bitErr);
          }

          res.status(200).json({ mensaje: "Entrada eliminada correctamente" });
        }
      );
    } catch (error) {
      console.error("🔥 Error general:", error);
      res.status(500).json({ mensaje: "Error al procesar la eliminación" });
    }
  }
);




// Libros - CRUD completo
router.get('/libros', async (req, res) => {
  try {
    const [results] = await db.promise().query(
      `CALL sp_gestion_libro('MOSTRAR', NULL, NULL, NULL, NULL, NULL)`
    );
    res.json(results[0].map(r => ({
      cod_libro: r.cod_libro,
      titulo:    r.titulo,
      autor:     r.autor,
      precio:    r.precio,
      stock:     r.stock,
      creado_en: r.creado_en
    })));
  } catch (err) {
    console.error('Error al listar libros:', err);
    res.status(500).json({ error: err.message });
  }
});

router.get('/libros/:id', async (req, res) => {
  try {
    const [results] = await db.promise().query(
      `CALL sp_gestion_libro('MOSTRAR_ID', ?, NULL, NULL, NULL, NULL)`,
      [req.params.id]
    );
    if (results[0].length) {
      res.json(results[0][0]);
    } else {
      res.status(404).json({ error: 'Libro no encontrado' });
    }
  } catch (err) {
    console.error('Error al obtener libro:', err);
    res.status(500).json({ error: err.message });
  }
});

router.post('/libros', async (req, res) => {
  const { titulo, autor, precio, stock } = req.body;
  try {
    const [results] = await db.promise().query(
      `CALL sp_gestion_libro('INSERTAR', NULL, ?, ?, ?, ?)`,
      [titulo, autor, precio, stock]
    );
    res.status(201).json({ 
      message: results[0][0].mensaje,
      cod_libro: results.insertId 
    });
  } catch (err) {
    console.error('Error al crear libro:', err);
    res.status(500).json({ error: err.message });
  }
});

router.put('/libros/:id', async (req, res) => {
  const { titulo, autor, precio, stock } = req.body;
  try {
    const [results] = await db.promise().query(
      `CALL sp_gestion_libro('ACTUALIZAR', ?, ?, ?, ?, ?)`,
      [req.params.id, titulo, autor, precio, stock]
    );
    res.json({ message: results[0][0].mensaje });
  } catch (err) {
    console.error('Error al actualizar libro:', err);
    res.status(500).json({ error: err.message });
  }
});

router.delete('/libros/:id', async (req, res) => {
  try {
    const [results] = await db.promise().query(
      `CALL sp_gestion_libro('ELIMINAR', ?, NULL, NULL, NULL, NULL)`,
      [req.params.id]
    );
    res.json({ message: results[0][0].mensaje });
  } catch (err) {
    console.error('Error al eliminar libro:', err);
    res.status(500).json({ error: err.message });
  }
});


module.exports = router;
