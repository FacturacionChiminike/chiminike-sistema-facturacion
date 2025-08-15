const express = require("express");
const router = express.Router();
const db = require("../index");
const bcrypt = require("bcryptjs");
const crypto = require("crypto");
const { registrarBitacora } = require("../helpers/bitacora");
const obtenerIP = require("../helpers/ip");
const bitacora = require("../middlewares/bitacora");

const enviarCorreo = require("../utils/mailer");
const enviarCodigo2FA = require("../utils/enviarCodigo2FA");
const { generarToken } = require("../JWT/jwt");

const verificarToken = require("../middlewares/verificarToken");
const verificarPermiso = require("../middlewares/verificarPermiso");
const obtenerPermisosUsuario = require("../utils/obtenerPermisosUsuario");
const enviarCorreoRecuperacion = require("../utils/emailRecuperacion");



// ----------------------------------------
// LOGIN CON ENVÍO DE CÓDIGO 2FA
// ----------------------------------------

router.post("/login", (req, res) => {
  const { usuario, password } = req.body;
  const ipConexion =
    req.headers["x-forwarded-for"] || req.connection.remoteAddress;

  db.query(
    "CALL sp_login_usuario(?, ?, ?)",
    ["mostrar", usuario, null],
    (err, results) => {
      console.error("Error al consultar sp_login_usuario:", err);
      if (err) return res.status(500).json({ mensaje: "Error en el servidor" });

      const usuarioData = results[0][0];
      if (!usuarioData)
        return res.status(404).json({ mensaje: "Usuario no encontrado" });
      if (!usuarioData.estado)
        return res.status(403).json({ mensaje: "Usuario bloqueado" });

      const esValida = bcrypt.compareSync(password, usuarioData.contrasena);
      if (!esValida) {
        db.query(
          "CALL sp_login_usuario(?, ?, ?)",
          ["sumar_intento", usuario, null],
          (err) => {
            if (err)
              return res
                .status(500)
                .json({ mensaje: "Error al actualizar intentos" });
            return res.status(401).json({ mensaje: "Contraseña incorrecta" });
          }
        );
        return;
      }

      db.query(
        "CALL sp_login_usuario(?, ?, ?)",
        ["login_exitoso", usuario, ipConexion],
        (err) => {
          if (err)
            return res
              .status(500)
              .json({ mensaje: "Error al registrar login" });

          db.query(
            "CALL sp_permisos_usuario(?)",
            [usuarioData.cod_rol],
            (err, permisosResult) => {
              if (err)
                return res
                  .status(500)
                  .json({ mensaje: "Error al cargar permisos" });

              const permisos = permisosResult[0];
              const permisosConvertidos = permisos.map((p) => ({
                objeto: p.objeto,
                crear: !!p.crear,
                modificar: !!p.modificar,
                mostrar: !!p.mostrar,
                eliminar: !!p.eliminar,
              }));

              const token = generarToken({
                cod_usuario: usuarioData.cod_usuario,
                rol: usuarioData.rol,
                permisos: permisosConvertidos,
              });

              // Enviar código 2FA
              const codigo2FA = Math.floor(
                100000 + Math.random() * 900000
              ).toString();
              const expira = new Date(Date.now() + 5 * 60 * 1000);

              db.query(
                "CALL sp_guardar_codigo_2fa(?, ?, ?)",
                [usuarioData.cod_usuario, codigo2FA, expira],
                (err2) => {
                  if (err2)
                    console.error(" Error al guardar código 2FA:", err2);
                  enviarCodigo2FA(usuarioData.correo, codigo2FA);
                }
              );

              registrarBitacora(
                usuarioData.cod_usuario,
                "Login",
                "Acceso",
                ipConexion
              ).catch((err) => {
                console.error("Error al registrar bitácora de login:", err);
              });

              res.status(200).json({
                token,
                usuario: {
                  cod_usuario: usuarioData.cod_usuario,
                  nombre_usuario: usuarioData.nombre_usuario,
                  primer_acceso: usuarioData.primer_acceso,
                  rol: usuarioData.rol,
                  permisos: permisosConvertidos,
                },
                primer_acceso: usuarioData.primer_acceso,
                requiere2FA: true,
                mensaje:
                  "Login exitoso, se envió código de verificación al correo",
              });
            }
          );
        }
      );
    }
  );
});

// ----------------------------------------
// VERIFICAR CÓDIGO 2FA
// ----------------------------------------
router.post("/verificar-2fa", (req, res) => {
  const { cod_usuario, codigo, nombre_usuario } = req.body;

  db.query(
    "CALL sp_verificar_codigo_2fa(?, ?)",
    [cod_usuario, codigo],
    (err, result) => {
      if (err)
        return res.status(500).json({ mensaje: "Error al verificar código" });

      const valido = result[0][0]?.es_valido;
      if (!valido)
        return res
          .status(401)
          .json({ mensaje: "Código incorrecto o expirado" });

      db.query(
        "CALL sp_permisos_usuario(?)",
        [cod_usuario],
        (err2, permisosResult) => {
          if (err2)
            return res
              .status(500)
              .json({ mensaje: "Error al cargar permisos" });

          const permisosConvertidos = permisosResult[0].map((p) => ({
            objeto: p.objeto,
            crear: !!p.crear,
            modificar: !!p.modificar,
            mostrar: !!p.mostrar,
            eliminar: !!p.eliminar,
          }));

          const token = generarToken({
            cod_usuario,
            nombre_usuario,
            permisos: permisosConvertidos,
          });

          res.json({
            token,
            mensaje: "Login exitoso con verificación 2FA",
          });
        }
      );
    }
  );
});

// ----------------------------------------
// RECUPERAR CONTRASEÑA
// ----------------------------------------
router.post("/api/recuperar-contrasena", (req, res) => {
  const { correo } = req.body;
  if (!correo || !correo.includes("@")) {
    return res.status(400).json({ mensaje: "Correo inválido o faltante" });
  }

  const correoLimpio = correo.trim().toLowerCase();
  const token = crypto.randomBytes(32).toString("hex");
  const expira = new Date(Date.now() + 60 * 60 * 1000);

  db.query(
    "CALL sp_generar_token_recuperacion(?, ?, ?)",
    [correoLimpio, token, expira],
    (err, results) => {
      if (err) {
        console.error("Error BD:", err);
        return res.status(500).json({ mensaje: "Error al generar token" });
      }

      const resultado = results?.[0]?.[0];
      if (resultado?.error) {
        return res.status(404).json({ mensaje: resultado.error });
      }

      const usuario = resultado.usuario;

      enviarCorreoRecuperacion(correoLimpio, usuario, token)
        .then(() => {
          res.json({
            exito: true,
            mensaje: ` Correo enviado a ${correoLimpio}, asociado al usuario ${usuario}`,
          });
        })
        .catch((error) => {
          console.error("Error al enviar correo:", error);
          res
            .status(500)
            .json({ mensaje: "No se pudo enviar el correo electrónico" });
        });
    }
  );
});

// ----------------------------------------
// RESETEAR CONTRASEÑA
// ----------------------------------------
router.put("/api/resetear-contrasena", async (req, res) => {
  const { token, nueva } = req.body;
  if (!token || !nueva)
    return res.status(400).json({ mensaje: "Faltan datos obligatorios" });

  try {
    const hash = await bcrypt.hash(nueva, 10);

    db.query(
      "CALL sp_resetear_contrasena_token(?, ?)",
      [token, hash],
      (err, result) => {
        if (err)
          return res
            .status(500)
            .json({ mensaje: "Error al actualizar contraseña" });

        const mensaje = result?.[0]?.[0]?.mensaje;
        if (mensaje === "Contraseña actualizada correctamente") {
          return res.json({ exito: true, mensaje });
        } else {
          return res
            .status(400)
            .json({ mensaje: mensaje || "Token inválido o expirado" });
        }
      }
    );
  } catch (error) {
    return res.status(500).json({ mensaje: "Error interno del servidor" });
  }
});

// ----------------------------------------
// ACTUALIZAR CONTRASEÑA PRIMER INICIO
// ----------------------------------------
router.put("/actualizar-contrasena", async (req, res) => {
  const {
    cod_usuario,
    nueva_contrasena,
    cod_pregunta1,
    respuesta1,
    cod_pregunta2,
    respuesta2,
  } = req.body;

  if (
    !cod_usuario ||
    !nueva_contrasena ||
    !cod_pregunta1 ||
    !respuesta1 ||
    !cod_pregunta2 ||
    !respuesta2
  ) {
    return res.status(400).json({
      success: false,
      mensaje:
        "Faltan datos requeridos para actualizar la contraseña y preguntas",
    });
  }

  try {
    const hashedPassword = await bcrypt.hash(nueva_contrasena, 10);
    const hashedRespuesta1 = await bcrypt.hash(respuesta1, 10);
    const hashedRespuesta2 = await bcrypt.hash(respuesta2, 10);

    db.query(
      "CALL sp_primer_acceso(?, ?, ?, ?, ?, ?)",
      [
        cod_usuario,
        hashedPassword,
        cod_pregunta1,
        hashedRespuesta1,
        cod_pregunta2,
        hashedRespuesta2,
      ],
      (err, results) => {
        if (err) {
          console.error("Error al actualizar contraseña y preguntas:", err);
          return res.status(500).json({
            success: false,
            mensaje: "Error al actualizar contraseña y preguntas",
            error: err,
          });
        }

        return res.json({
          success: true,
          mensaje:
            "Contraseña y preguntas de recuperación actualizadas correctamente",
        });
      }
    );
  } catch (error) {
    console.error("Error en el servidor:", error);
    return res.status(500).json({
      success: false,
      mensaje: "Error en el servidor",
      error,
    });
  }
});
// -------------------------------------------------
// Mostrar Usuairos con sus permisos de los objetos
// -------------------------------------------------

router.get("/usuarios.permisos", (req, res) => {
  db.query("CALL sp_usuarios_con_permisos()", (err, results) => {
    if (err) {
      console.error("Error al ejecutar procedimiento:", err);
      return res.status(500).json({ mensaje: "Error al obtener permisos" });
    }

    const filas = results[0];
    const respuesta = {};
    const objetosSet = new Set();

    filas.forEach((row) => {
      const usuario = row.nombre_usuario;

      // Crear entrada si no existe aún
      if (!respuesta[usuario]) {
        respuesta[usuario] = {
          nombre_usuario: row.nombre_usuario,
          cod_rol: row.cod_rol,
          rol: row.rol,
          estado: row.estado,
          permisos: {},
        };
      }

      respuesta[usuario].permisos[row.objeto] = {
        crear: row.crear === "Sí" ? 1 : 0,
        mostrar: row.mostrar === "Sí" ? 1 : 0,
        modificar: row.modificar === "Sí" ? 1 : 0,
        eliminar: row.eliminar === "Sí" ? 1 : 0,
      };

      objetosSet.add(row.objeto);
    });

    res.json({
      usuarios: Object.values(respuesta),
      objetos: Array.from(objetosSet),
    });
  });
});

// ----------------------------------------
// ACTUALIZAR PERMISOS EN USUARIOS
// ----------------------------------------

router.put("/permisos.actualizar", (req, res) => {
  const { cod_rol, cod_objeto, permiso, valor } = req.body;

  if (!["crear", "modificar", "mostrar", "eliminar"].includes(permiso)) {
    return res.status(400).json({ mensaje: "Permiso inválido" });
  }

  db.query(
    "CALL sp_actualizar_permiso(?, ?, ?, ?)",
    [cod_rol, cod_objeto, permiso, valor],
    (err) => {
      if (err) {
        console.error("Error al actualizar permiso:", err);
        return res.status(500).json({ mensaje: "Error al actualizar permiso" });
      }

      res.json({ mensaje: "Permiso actualizado correctamente" });
    }
  );
});

///crear un rol nuevo


router.post(
  "/roles",
  verificarToken,
  async (req, res) => {
    const { nombre_rol, descripcion_rol } = req.body;
    const cod_usuario = req.usuario?.cod_usuario;
    const ip = req.ip;

    db.query(
      "CALL sp_insertar_personas(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
      [
        null, // PV_NOMBRE
        null, // PV_FECHA_NACIMIENTO
        null, // PV_SEXO
        null, // PV_DNI
        null, // PV_CORREO
        null, // PV_TELEFONO
        null, // PV_DIRECCION
        null, // PV_COD_MUNICIPIO
        null, // PV_RTN
        null, // PV_TIPO_CLIENTE
        null, // PV_CARGO
        null, // PV_SALARIO
        null, // PV_FECHA_CONTRATACION
        null, // PV_COD_DEP_EMPRESA
        null, // PV_NOMBRE_USUARIO
        null, // PV_CONTRASENA
        null, // PV_COD_ROL
        nombre_rol,
        descripcion_rol,
        cod_usuario, // creado por
        "ROL"
      ],
      async (err, results) => {
        if (err) {
          console.error("Error al insertar rol:", err);
          return res.status(500).json({
            mensaje: "Error al insertar rol",
            error: err,
          });
        }

        try {
          await registrarBitacora(
            cod_usuario,
            "Rol",
            "Crear",
            ip,
            null,
            { nombre_rol, descripcion_rol }
          );
        } catch (bitErr) {
          console.warn("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.json({
          success: true,
          mensaje: "Rol registrado correctamente",
          resultado: results[0]?.[0] || {},
        });
      }
    );
  }
);

////////////////////////////////
// Mostrar todos los roles
router.get("/roles.get", (req, res) => {
  db.query(
    "CALL sp_gestion_roles(?, ?, ?, ?, ?)",
    ["mostrar", null, null, null, null],
    (err, results) => {
      if (err)
        return res.status(500).json({ mensaje: "Error al obtener roles" });
      res.json(results[0]);
    }
  );
});

// Actualizar un rol
router.put(
  "/roles/:id",
  verificarToken,
  async (req, res) => {
    const cod_rol = parseInt(req.params.id);
    const { nombre, descripcion, estado } = req.body;
    const cod_usuario = req.usuario?.cod_usuario;
    const ip = req.ip;

    try {
      // 🔍 Obtener datos anteriores desde SP
      const [antesResult] = await db
        .promise()
        .query("CALL sp_gestion_roles(?, ?, ?, ?, ?)", [
          "mostrar_id",
          cod_rol,
          null,
          null,
          null,
        ]);
      const datosAnteriores = antesResult?.[0]?.[0] || {};

      // 🛠️ Ejecutar el SP de actualización
      db.query(
        "CALL sp_gestion_roles(?, ?, ?, ?, ?)",
        ["actualizar", cod_rol, nombre, descripcion, estado],
        async (err, results) => {
          if (err) {
            console.error("❌ Error al actualizar el rol:", err);
            return res
              .status(500)
              .json({ mensaje: "Error al actualizar el rol" });
          }

          // 📝 Registrar en bitácora
          try {
            await registrarBitacora(
              cod_usuario,
              "Rol",
              "Actualizar",
              ip,
              datosAnteriores,
              { nombre, descripcion, estado }
            );
            console.log("📒 Bitácora registrada");
          } catch (bitErr) {
            console.warn("⚠️ Error al registrar en bitácora:", bitErr);
          }

          res.json({ mensaje: "Rol actualizado correctamente" });
        }
      );
    } catch (error) {
      console.error("💥 Error inesperado:", error);
      res.status(500).json({ mensaje: "Error interno al actualizar el rol" });
    }
  }
);


// Eliminar un rol
router.delete(
  "/roles/:id",
  verificarToken,
  async (req, res) => {
    const cod_rol = parseInt(req.params.id);
    const cod_usuario = req.usuario?.cod_usuario;
    const ip = req.ip;

    try {
      // 🔍 Obtener datos antes de eliminar
      const [antesResult] = await db
        .promise()
        .query("CALL sp_gestion_roles(?, ?, ?, ?, ?)", [
          "mostrar_id",
          cod_rol,
          null,
          null,
          null,
        ]);
      const datosAnteriores = antesResult?.[0]?.[0];

      if (!datosAnteriores) {
        return res.status(404).json({ mensaje: "Rol no encontrado" });
      }

      // 🗑️ Eliminar el rol
      db.query(
        "CALL sp_gestion_roles(?, ?, ?, ?, ?)",
        ["eliminar", cod_rol, null, null, null],
        async (err, results) => {
          if (err) {
            console.error("❌ Error al eliminar el rol:", err);
            return res
              .status(500)
              .json({ mensaje: "Error al eliminar el rol" });
          }

          // 📝 Registrar en bitácora
          try {
            await registrarBitacora(
              cod_usuario,
              "Rol",
              "Eliminar",
              ip,
              datosAnteriores,
              null
            );
            console.log("📒 Bitácora de eliminación registrada");
          } catch (bitErr) {
            console.warn("⚠️ Error al registrar en bitácora:", bitErr);
          }

          res.json({ mensaje: "Rol eliminado correctamente" });
        }
      );
    } catch (error) {
      console.error("💥 Error inesperado:", error);
      res.status(500).json({ mensaje: "Error interno al eliminar el rol" });
    }
  }
);


//usuarios
router.get("/usuarios", (req, res) => {
  db.query(
    "CALL sp_gestion_usuario(?, ?, ?, ?, ?, ?, ?)",
    ["mostrar", null, null, null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar usuarios: ", err);
        return res.status(500).json({ mensaje: "Error al obtener usuarios" });
      }

      res.json(results[0]);
    }
  );
});

router.put("/usuarios/:id", verificarToken, async (req, res) => {
  const cod_usuario = parseInt(req.params.id);
  const { cod_tipo_usuario, estado } = req.body;

  try {
    // 🔍 Obtener datos anteriores
    const [prevData] = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_gestion_usuario(?, ?, ?, ?, ?, ?, ?)",
        ["mostrar_id", cod_usuario, null, null, null, null, null],
        (err, results) => {
          if (err) return reject(err);
          resolve(results[0]);
        }
      );
    });

    // 🛠 Ejecutar actualización
    db.query(
      "CALL sp_gestion_usuario(?, ?, ?, ?, ?, ?, ?)",
      ["actualizar", cod_usuario, null, null, estado, cod_tipo_usuario, null],
      async (err, results) => {
        if (err) {
          console.error("Error al actualizar usuario: ", err);
          return res
            .status(500)
            .json({ mensaje: "Error al actualizar usuario" });
        }

        // 📝 Registrar bitácora
        try {
          const usuarioToken = req.usuario?.cod_usuario;
          const ip = req.ip;

          await registrarBitacora(
            usuarioToken,
            "Usuario",
            "Actualizar",
            ip,
            prevData || null,
            { estado, cod_tipo_usuario }
          );

          console.log("📒 Bitácora actualizada correctamente");
        } catch (bitErr) {
          console.error("❌ Error al guardar en bitácora:", bitErr);
        }

        res.json({ mensaje: "Usuario actualizado correctamente" });
      }
    );
  } catch (error) {
    console.error("❌ Error general:", error);
    res
      .status(500)
      .json({ mensaje: "Error al obtener datos anteriores del usuario" });
  }
});


// Mostrar todos los permisos
router.get("/permisos", (req, res) => {
  db.query(
    "CALL sp_gestion_permisos(?, ?, ?, ?, ?, ?, ?, ?, ?)",
    ["mostrar", null, null, null, null, null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar permisos: ", err);
        return res.status(500).json({ mensaje: "Error al obtener permisos" });
      }
      res.json(results[0]);
    }
  );
});

// Mostrar un permiso por ID
router.get("/permisos/:id", (req, res) => {
  const id = parseInt(req.params.id);
  db.query(
    "CALL sp_gestion_permisos(?, ?, ?, ?, ?, ?, ?, ?, ?)",
    ["mostrar_uno", id, null, null, null, null, null, null, null],
    (err, results) => {
      if (err) {
        console.error("Error al mostrar permiso por ID: ", err);
        return res.status(500).json({ mensaje: "Error al obtener el permiso" });
      }
      res.json(results[0]);
    }
  );
});

// Insertar nuevo permiso
router.post("/permisos", verificarToken, async (req, res) => {
  const {
    cod_rol,
    cod_objeto,
    nombre,
    crear,
    modificar,
    mostrar,
    eliminar
  } = req.body;

  db.query(
    "CALL sp_gestion_permisos(?, ?, ?, ?, ?, ?, ?, ?, ?)",
    [
      "insertar",
      null,
      cod_rol,
      cod_objeto,
      nombre,
      crear,
      modificar,
      mostrar,
      eliminar
    ],
    async (err, results) => {
      if (err) {
        console.error("❌ Error al insertar permiso:", err);
        return res.status(500).json({ mensaje: "Error al crear permiso" });
      }

      // ✅ REGISTRO EN BITÁCORA
      try {
        const cod_usuario = req.usuario?.cod_usuario;
        const ip = req.ip;

        await registrarBitacora(
          cod_usuario,
          "Permiso",
          "Crear",
          ip,
          null,
          {
            cod_rol,
            cod_objeto,
            nombre,
            crear,
            modificar,
            mostrar,
            eliminar
          }
        );

        console.log("📒 Bitácora registrada correctamente");
      } catch (bitErr) {
        console.error("⚠️ Error al guardar en bitácora:", bitErr);
      }

      res.status(200).json({ mensaje: "Permiso creado correctamente" });
    }
  );
});


// Actualizar permiso
router.put("/permisos/:id", verificarToken, async (req, res) => {
  const id = parseInt(req.params.id);
  const { cod_rol, cod_objeto, nombre, crear, modificar, mostrar, eliminar } = req.body;

  try {
    // 🔍 Obtener datos antes del cambio
    const [antes] = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_gestion_permisos(?, ?, ?, ?, ?, ?, ?, ?, ?)",
        ["mostrar_uno", id, null, null, null, null, null, null, null],
        (err, results) => {
          if (err) return reject(err);
          resolve(results[0]);
        }
      );
    });

    // 🛠️ Hacer la actualización
    db.query(
      "CALL sp_gestion_permisos(?, ?, ?, ?, ?, ?, ?, ?, ?)",
      [
        "actualizar",
        id,
        cod_rol,
        cod_objeto,
        nombre,
        crear,
        modificar,
        mostrar,
        eliminar
      ],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al actualizar permiso:", err);
          return res.status(500).json({ mensaje: "Error al actualizar permiso" });
        }

        // ✅ Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = req.ip;

          const despues = {
            cod_rol,
            cod_objeto,
            nombre,
            crear,
            modificar,
            mostrar,
            eliminar
          };

          await registrarBitacora(
            cod_usuario,
            "Permiso",
            "Actualizar",
            ip,
            antes[0] || null,  // Datos anteriores
            despues            // Nuevos datos
          );

          console.log("📒 Bitácora registrada correctamente");
        } catch (bitErr) {
          console.error("⚠️ Error al guardar en bitácora:", bitErr);
        }

        res.json({ mensaje: "Permiso actualizado correctamente" });
      }
    );
  } catch (error) {
    console.error("💥 Error al consultar datos anteriores:", error);
    return res.status(500).json({ mensaje: "Error al obtener datos previos para bitácora" });
  }
});

// Eliminar permiso
router.delete("/permisos/:id", verificarToken, async (req, res) => {
  const id = parseInt(req.params.id);

  try {
    // 🔍 Obtener datos antes de eliminar
    const [antes] = await new Promise((resolve, reject) => {
      db.query(
        "CALL sp_gestion_permisos(?, ?, ?, ?, ?, ?, ?, ?, ?)",
        ["mostrar_uno", id, null, null, null, null, null, null, null],
        (err, results) => {
          if (err) return reject(err);
          resolve(results[0]);
        }
      );
    });

    // 🗑️ Eliminar el permiso
    db.query(
      "CALL sp_gestion_permisos(?, ?, ?, ?, ?, ?, ?, ?, ?)",
      ["eliminar", id, null, null, null, null, null, null, null],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al eliminar permiso:", err);
          return res.status(500).json({ mensaje: "Error al eliminar permiso" });
        }

        // 📒 Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = req.ip;

          await registrarBitacora(
            cod_usuario,
            "Permiso",
            "Eliminar",
            ip,
            antes[0] || null,  // 🔁 datos previos
            null               // ❌ no hay nuevos datos
          );

          console.log("📒 Bitácora registrada correctamente");
        } catch (bitErr) {
          console.error("⚠️ Error al guardar en bitácora:", bitErr);
        }

        res.json({ mensaje: "Permiso eliminado correctamente" });
      }
    );
  } catch (error) {
    console.error("💥 Error al obtener datos antes de eliminar:", error);
    return res.status(500).json({ mensaje: "Error al consultar datos anteriores" });
  }
});


//bitacora
router.get("/bitacora", (req, res) => {
  // Puedes recibir filtros por query params
  const cod_usuario = req.query.cod_usuario || 0;
  const fecha_inicio = req.query.fecha_inicio || null;
  const fecha_fin = req.query.fecha_fin || null;
  const objeto = req.query.objeto || "";

  db.query(
    "CALL sp_consultar_bitacora(?, ?, ?, ?)",
    [cod_usuario, fecha_inicio, fecha_fin, objeto],
    (err, results) => {
      if (err)
        return res.status(500).json({ mensaje: "Error al obtener bitácora" });

      res.json(results[0]);
    }
  );
});

router.get("/bitacora", (req, res) => {
  const cod_usuario = req.query.cod_usuario || 0;
  const fecha_inicio = req.query.fecha_inicio || null;
  const fecha_fin = req.query.fecha_fin || null;
  const objeto = req.query.objeto || "";
  const page = parseInt(req.query.page) || 1;
  const limit = 10;
  const offset = (page - 1) * limit;

  db.query(
    "CALL sp_consultar_bitacora_paginado(?, ?, ?, ?, ?, ?)",
    [cod_usuario, fecha_inicio, fecha_fin, objeto, limit, offset],
    (err, results) => {
      if (err)
        return res.status(500).json({ mensaje: "Error al obtener bitácora" });

      res.json(results[0]);
    }
  );
});

//Objetos

router.get("/objetos", (req, res) => {
  db.query(
    "CALL sp_gestion_objetos(?, ?, ?, ?)",
    ["mostrar", 0, null, null],
    (err, results) => {
      if (err)
        return res
          .status(500)
          .json({ mensaje: "Error al obtener los objetos" });

      res.json(results[0]);
    }
  );
});

// Mostrar objeto por ID
router.get("/objetos/:id", (req, res) => {
  const id = req.params.id;

  db.query(
    "CALL sp_gestion_objetos(?, ?, ?, ?)",
    ["mostrar_id", id, null, null],
    (err, results) => {
      if (err)
        return res
          .status(500)
          .json({ mensaje: "Error al obtener el objeto por ID" });

      res.json(results[0]);
    }
  );
});

// Insertar objeto
router.post("/objetos", verificarToken, async (req, res) => {
  const { tipo_objeto, descripcion } = req.body;

  db.query(
    "CALL sp_gestion_objetos(?, ?, ?, ?)",
    ["insertar", 0, tipo_objeto, descripcion],
    async (err, results) => {
      if (err) {
        console.error("❌ Error al insertar el objeto:", err);
        return res.status(500).json({ mensaje: "Error al insertar el objeto" });
      }

      const resultado = results[0]?.[0];

      // ✅ Registrar en bitácora
      try {
        const cod_usuario = req.usuario?.cod_usuario;
        const ip = req.ip;

        await registrarBitacora(
          cod_usuario,
          "Objeto",
          "Crear",
          ip,
          null,
          { tipo_objeto, descripcion }
        );

        console.log("📒 Bitácora registrada correctamente");
      } catch (bitErr) {
        console.error("⚠️ Error al registrar en bitácora:", bitErr);
      }

      res.status(200).json(resultado);
    }
  );
});


// Actualizar objeto
router.put("/objetos/:id", verificarToken, async (req, res) => {
  const id = parseInt(req.params.id);
  const { tipo_objeto, descripcion } = req.body;

  try {
    // 🔍 1. Obtener datos anteriores
    const [oldResults] = await db.promise().query(
      "CALL sp_gestion_objetos(?, ?, ?, ?)",
      ["mostrar_id", id, null, null]
    );
    const datos_anteriores = oldResults[0]?.[0] || null;

    // 🛠️ 2. Actualizar objeto
    db.query(
      "CALL sp_gestion_objetos(?, ?, ?, ?)",
      ["actualizar", id, tipo_objeto, descripcion],
      async (err, results) => {
        if (err) {
          console.error("Error al actualizar el objeto:", err);
          return res.status(500).json({ mensaje: "Error al actualizar el objeto" });
        }

        const cod_usuario = req.usuario?.cod_usuario;
        const ip = req.ip;
        const datos_nuevos = { tipo_objeto, descripcion };

        // 📝 3. Registrar en bitácora
        try {
          await registrarBitacora(
            cod_usuario,
            "Objeto",
            "Actualizar",
            ip,
            datos_anteriores,
            datos_nuevos
          );
          console.log("📘 Bitácora registrada correctamente");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.json({ mensaje: "Objeto actualizado correctamente" });
      }
    );
  } catch (e) {
    console.error("Error general:", e);
    res.status(500).json({ mensaje: "Error inesperado" });
  }
});


// Eliminar objeto
router.delete("/objetos/:id", verificarToken, async (req, res) => {
  const id = parseInt(req.params.id);

  try {
    // 🔍 Obtener datos antes de eliminar
    const [oldResults] = await db.promise().query(
      "CALL sp_gestion_objetos(?, ?, ?, ?)",
      ["mostrar_id", id, null, null]
    );
    const datos_anteriores = oldResults[0]?.[0];

    if (!datos_anteriores) {
      return res.status(404).json({ mensaje: "Objeto no encontrado" });
    }

    // 🗑️ Eliminar objeto
    db.query(
      "CALL sp_gestion_objetos(?, ?, ?, ?)",
      ["eliminar", id, null, null],
      async (err, results) => {
        if (err) {
          console.error("Error al eliminar el objeto:", err);
          return res.status(500).json({ mensaje: "Error al eliminar el objeto" });
        }

        const cod_usuario = req.usuario?.cod_usuario;
        const ip = req.ip;

        // 📝 Registrar en bitácora
        try {
          await registrarBitacora(
            cod_usuario,
            "Objeto",
            "Eliminar",
            ip,
            datos_anteriores,
            null
          );
          console.log("📘 Bitácora registrada correctamente");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.json({ mensaje: "Objeto eliminado correctamente" });
      }
    );
  } catch (e) {
    console.error("Error general:", e);
    res.status(500).json({ mensaje: "Error inesperado al eliminar el objeto" });
  }
});


//usuarios

router.get("/usuarios.get", (req, res) => {
  db.query(
    "CALL sp_gestion_usuario(?, ?, ?, ?, ?, ?, ?, ?)",
    ["mostrar", null, null, null, null, null, null, null],
    (err, results) => {
      if (err)
        return res
          .status(500)
          .json({ mensaje: "Error al obtener usuarios", error: err });
      res.json(results[0]);
    }
  );
});

router.get("/usuarios.set/:id", (req, res) => {
  const id = parseInt(req.params.id);

  db.query(
    "CALL sp_gestion_usuario(?, ?, ?, ?, ?, ?, ?, ?)",
    ["mostrar_por_id", id, null, null, null, null, null, null],
    (err, results) => {
      if (err)
        return res
          .status(500)
          .json({ mensaje: "Error al obtener el usuario", error: err });
      res.json(results[0][0]);
    }
  );
});

router.put(
  "/usuarios.update/:id",
  verificarToken, // ⬅️ Obligatorio antes de registrar bitácora
  async (req, res) => {
    const id = parseInt(req.params.id);
    const { estado, cod_tipo_usuario, cod_rol } = req.body;

    // 🔎 Obtener datos ANTES
    let datosAntes = {};
    try {
      const [rows] = await db.promise().query(
        "CALL sp_gestion_usuario(?, ?, ?, ?, ?, ?, ?, ?)",
        ["mostrar_por_id", id, null, null, null, null, null, null]
      );
      datosAntes = rows[0][0];
    } catch (err) {
      console.error("⚠️ Error al obtener datos antes:", err);
    }

    // Ejecutar actualización
    db.query(
      "CALL sp_gestion_usuario(?, ?, ?, ?, ?, ?, ?, ?)",
      ["actualizar", id, null, null, estado, cod_tipo_usuario, cod_rol, null],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al actualizar usuario:", err);
          return res.status(500).json({ mensaje: "Error al actualizar el usuario" });
        }

        // 💾 REGISTRO EN BITÁCORA
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = req.ip;
          const datosDespues = { estado, cod_tipo_usuario, cod_rol };

          if (!cod_usuario) throw new Error("Usuario no autenticado");

          await registrarBitacora(
            cod_usuario,
            "Usuario",
            "Actualizar",
            ip,
            datosAntes,
            datosDespues
          );

          console.log("📒 Bitácora registrada");
        } catch (bitErr) {
          console.error("❌ Error al registrar en bitácora:", bitErr);
        }

        res.json({ mensaje: "Usuario actualizado correctamente" });
      }
    );
  }
);



router.get("/personas", (req, res) => {
  db.query("CALL sp_resumen_personas()", (err, results) => {
    if (err) {
      console.error("Error al ejecutar el procedimiento:", err);
      return res
        .status(500)
        .json({ mensaje: "Error al obtener resumen de personas" });
    }

    const resumen = results[0][0];
    res.json(resumen);
  });
});

// Validar respuestas y actualizar contraseña

router.post("/validar-respuestas", async (req, res) => {
  const {
    cod_usuario,
    cod_pregunta1,
    respuesta1,
    cod_pregunta2,
    respuesta2,
    nueva_contrasena
  } = req.body;

  if (!cod_usuario || !cod_pregunta1 || !respuesta1 || !cod_pregunta2 || !respuesta2 || !nueva_contrasena) {
    return res.status(400).json({ mensaje: "Faltan datos obligatorios" });
  }

  try {
    db.query(
      "CALL sp_obtener_respuestas_preguntas(?, ?, ?)",
      [cod_usuario, cod_pregunta1, cod_pregunta2],
      async (err, results) => {
        if (err) {
          console.error("Error al obtener respuestas:", err);
          return res.status(500).json({ mensaje: "Error en la base de datos" });
        }

        const data = results[0][0];
        if (!data) return res.status(404).json({ mensaje: "Preguntas no encontradas" });

        const bcrypt = require("bcryptjs");

        const respuestaValida1 = await bcrypt.compare(respuesta1, data.respuesta1);
        const respuestaValida2 = await bcrypt.compare(respuesta2, data.respuesta2);

        if (!respuestaValida1 || !respuestaValida2) {
          return res.status(401).json({ mensaje: "Respuestas incorrectas" });
        }

        const nuevaContrasenaHash = await bcrypt.hash(nueva_contrasena, 10);

        db.query(
          "CALL sp_actualizar_contrasena(?, ?)",
          [cod_usuario, nuevaContrasenaHash],
          (err2, result2) => {
            if (err2) {
              console.error("Error al actualizar contraseña:", err2);
              return res.status(500).json({ mensaje: "Error al actualizar contraseña" });
            }

            return res.json({ mensaje: "Contraseña actualizada correctamente" });
          }
        );
      }
    );
  } catch (error) {
    console.error("Error general:", error);
    return res.status(500).json({ mensaje: "Error interno del servidor" });
  }
});

module.exports = router;
