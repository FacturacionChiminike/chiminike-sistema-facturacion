const express = require("express");
const router = express.Router();
const bcrypt = require("bcryptjs");
const db = require("../index");
const obtenerIP = require("../helpers/ip");

const enviarCredencialesEmpleado = require("../utils/enviarCredencialesEmpleado");
const verificarToken = require("../middlewares/verificarToken");
const bitacora = require("../middlewares/bitacora");
const { registrarBitacora } = require("../helpers/bitacora");

//mostrar empleados
router.get("/empleados", (req, res) => {
  db.query(
    "CALL sp_mostrar_persona(?, ?)",
    [null, "TODOS_EMPLEADOS"],
    (err, results) => {
      if (err)
        return res.status(500).json({ mensaje: "Error al obtener empleados" });
      res.json(results[0]);
    }
  );
});

// Mostrar un empleado por ID (cod_empleado)
router.get("/empleados/:id", (req, res) => {
  const id = parseInt(req.params.id);
  db.query(
    "CALL sp_mostrar_persona(?, ?)",
    [id, "EMPLEADO"],
    (err, results) => {
      if (err)
        return res
          .status(500)
          .json({ mensaje: "Error al obtener el empleado" });
      if (results[0].length === 0)
        return res.status(404).json({ mensaje: "Empleado no encontrado" });
      res.json(results[0][0]);
    }
  );
});

// Mostrar todos los clientes
router.get("/clientes", (req, res) => {
  db.query(
    "CALL sp_mostrar_persona(?, ?)",
    [null, "TODOS_CLIENTES"],
    (err, results) => {
      if (err)
        return res.status(500).json({ mensaje: "Error al obtener clientes" });
      res.json(results[0]);
    }
  );
});

// Mostrar un cliente por ID (cod_cliente)
router.get("/clientes/:id", (req, res) => {
  const id = parseInt(req.params.id);
  db.query("CALL sp_mostrar_persona(?, ?)", [id, "CLIENTE"], (err, results) => {
    if (err)
      return res.status(500).json({ mensaje: "Error al obtener el cliente" });
    if (results[0].length === 0)
      return res.status(404).json({ mensaje: "Cliente no encontrado" });
    res.json(results[0][0]);
  });
});

// Actualizar empleado
router.put("/empleados/:id", verificarToken, async (req, res) => {
  const cod_empleado = parseInt(req.params.id);
  const {
    nombre_persona,
    fecha_nacimiento,
    sexo,
    dni,
    correo,
    telefono,
    direccion,
    cod_municipio,
    cargo,
    salario,
    fecha_contratacion,
    cod_departamento_empresa,
    cod_rol,
    estado,
  } = req.body;

  try {
    // 1️⃣ Obtener datos antes
    const datosAntes = await new Promise((resolve, reject) => {
      db.query("CALL sp_mostrar_persona(?, ?)", [cod_empleado, "EMPLEADO"], (err, results) => {
        if (err) reject(err);
        else if (!results[0] || results[0].length === 0) reject("Empleado no encontrado");
        else resolve(results[0][0]);
      });
    });

    // 2️⃣ Ejecutar actualización
    db.query(
      "CALL sp_actualizar_personas(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
      [
        cod_empleado,
        nombre_persona,
        fecha_nacimiento,
        sexo,
        dni,
        correo,
        telefono,
        direccion,
        cod_municipio,
        null, // RTN
        null, // TIPO CLIENTE
        cargo,
        salario,
        fecha_contratacion,
        cod_departamento_empresa,
        cod_rol,
        estado,
        null,
        null,
        "EMPLEADO"
      ],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al actualizar empleado:", err);
          return res.status(500).json({
            success: false,
            mensaje: "Error en base de datos",
            error: err,
          });
        }

        const respuesta = results[0]?.[0];

        if (respuesta?.mensaje?.includes("rollback")) {
          return res.status(400).json({
            success: false,
            mensaje: "Error interno al actualizar el empleado",
            detalle: respuesta.mensaje,
          });
        }

        // 3️⃣ Registrar en bitácora
        try {
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          const datosDespues = {
            cod_empleado,
            nombre_persona,
            fecha_nacimiento,
            sexo,
            dni,
            correo,
            telefono,
            direccion,
            cod_municipio,
            cargo,
            salario,
            fecha_contratacion,
            cod_departamento_empresa,
            cod_rol,
            estado,
          };

          await registrarBitacora(cod_usuario, "Empleado", "Actualizar", ip, datosAntes, datosDespues);
          console.log("📝 Bitácora de actualización de empleado registrada");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar bitácora:", bitErr);
        }

        res.json({
          success: true,
          mensaje: "Empleado actualizado correctamente",
          datos: respuesta || {},
        });
      }
    );
  } catch (error) {
    console.error("❌ Error al obtener datos del empleado:", error);
    return res.status(500).json({ mensaje: "Error antes de actualizar: " + error });
  }
});

//usuarios detalles

router.get("/empleado.detalle/:usuario", (req, res) => {
  const usuario = req.params.usuario;

  db.query("CALL sp_mostrar_empleado_detalle(?)", [usuario], (err, results) => {
    if (err) {
      console.error("Error al obtener el detalle del empleado:", err);
      return res
        .status(500)
        .json({ mensaje: "Error al obtener el detalle del empleado" });
    }

    if (!results[0] || results[0].length === 0) {
      return res.status(404).json({ mensaje: "Empleado no encontrado" });
    }

    res.json(results[0][0]);
  });
});

// POST /empleados
router.post("/empleados.insert", verificarToken, async (req, res) => {
  const {
    nombre_persona,
    fecha_nacimiento,
    sexo,
    dni,
    correo,
    telefono,
    direccion,
    cod_municipio,
    cargo,
    fecha_contratacion,
    nombre_usuario,
    contrasena,
    cod_rol,
    cod_tipo_usuario,
    salario,
    cod_departamento_empresa,
    creado_por,
  } = req.body;

  try {
    const hashedPassword = await bcrypt.hash(contrasena, 10);

    db.query(
      "CALL sp_insertar_personas(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
      [
        nombre_persona,
        fecha_nacimiento,
        sexo,
        dni.trim(),
        correo,
        telefono,
        direccion,
        cod_municipio,
        null, // PV_RTN
        null, // PV_TIPO_CLIENTE
        cargo,
        salario,
        fecha_contratacion,
        cod_departamento_empresa,
        nombre_usuario,
        hashedPassword,
        cod_rol,
        null,
        null,
        creado_por,
        "EMPLEADO"
      ],
      async (err, results) => {
        if (err) {
          console.error("❌ Error al insertar empleado:", err);
          return res.status(500).json({ mensaje: "Error al insertar empleado", error: err });
        }

        const resultado = results[0]?.[0];
        if (resultado?.mensaje?.startsWith("Error SQL:")) {
          console.error("⚠️ Error SP:", resultado.mensaje);
          return res.status(500).json({ success: false, mensaje: resultado.mensaje });
        }

        try {
          // 📨 Enviar correo con credenciales
          await enviarCredencialesEmpleado(correo, nombre_persona, nombre_usuario, contrasena);
        } catch (errorCorreo) {
          console.error("Error al enviar correo:", errorCorreo);
        }

        try {
          // ✅ Registrar en bitácora
          const cod_usuario = req.usuario?.cod_usuario;
          const ip = obtenerIP(req);

          const datosDespues = {
            nombre_persona,
            fecha_nacimiento,
            sexo,
            dni,
            correo,
            telefono,
            direccion,
            cod_municipio,
            cargo,
            fecha_contratacion,
            nombre_usuario,
            cod_rol,
            cod_tipo_usuario,
            salario,
            cod_departamento_empresa,
            creado_por
          };

          await registrarBitacora(cod_usuario, "Empleado", "Crear", ip, null, datosDespues);
          console.log("✔️ Bitácora de empleado registrada");
        } catch (bitErr) {
          console.error("⚠️ Error al registrar en bitácora:", bitErr);
        }

        res.json({
          success: true,
          mensaje: "Empleado registrado correctamente"
        });
      }
    );
  } catch (error) {
    console.error("❌ Error al encriptar contraseña:", error);
    return res.status(500).json({ mensaje: "Error interno", error: error.message });
  }
});
// POST /clientes
router.post("/clientes", (req, res) => {
  const {
    nombre_persona,
    fecha_nacimiento,
    sexo,
    dni,
    correo,
    telefono,
    direccion,
    cod_municipio,
    rtn,
    tipo_cliente,
  } = req.body;

  db.query(
    "CALL sp_insertar_personas(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)",
    [
      nombre_persona, // PV_NOMBRE
      fecha_nacimiento, // PV_FECHA_NACIMIENTO
      sexo, // PV_SEXO
      dni.toString().trim(), // PV_DNI
      correo, // PV_CORREO
      telefono, // PV_TELEFONO
      direccion, // PV_DIRECCION
      cod_municipio, // PV_COD_MUNICIPIO
      rtn, // PV_RTN
      tipo_cliente, // PV_TIPO_CLIENTE
      null, // PV_CARGO
      null, // PV_SALARIO
      null, // PV_FECHA_CONTRATACION
      null, // PV_COD_DEP_EMPRESA
      null, // PV_NOMBRE_USUARIO
      null, // PV_CONTRASENA
      null, // PV_COD_ROL
      null, // PV_NOMBRE_ROL
      null, // PV_DESC_ROL
      null, // PV_DESC_ROL
      "CLIENTE", // PV_ACTION --> este es el truco
    ],
    (err, results) => {
      if (err) {
        console.error("Error al insertar cliente:", err);
        return res
          .status(500)
          .json({ mensaje: "Error al insertar cliente", error: err });
      }

      res.json({
        success: true,
        mensaje: "Cliente registrado correctamente",
        resultado: results[0]?.[0] || {},
      });
    }
  );
});


////////////////////////////////////////////////////////////////
router.put(
  "/clientes.update/:id",
  verificarToken,
  async (req, res, next) => {
    const cod_cliente = parseInt(req.params.id);

    try {
      // Datos antes
      const datosAntes = await new Promise((resolve, reject) => {
        db.query("CALL sp_mostrar_persona(?, ?)", [cod_cliente, "CLIENTE"], (err, results) => {
          if (err) reject(err);
          else if (!results[0] || results[0].length === 0) reject("Cliente no encontrado");
          else resolve(results[0][0]);
        });
      });

     
      req.datosAntes = datosAntes;
      req.datosDespues = {
        cod_cliente,
        ...req.body
      };

      next(); 
    } catch (error) {
      console.error("Error al preparar bitácora:", error);
      return res.status(500).json({ mensaje: "Error al preparar bitácora", error });
    }
  },
  bitacora("Cliente", "Actualizar"), 
  (req, res) => {
    const {
      nombre_persona,
      fecha_nacimiento,
      sexo,
      dni,
      correo,
      telefono,
      direccion,
      cod_municipio,
      rtn,
      tipo_cliente,
    } = req.body;

    const cod_cliente = parseInt(req.params.id);

    db.query(
      "CALL sp_actualizar_personas(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
      [
        cod_cliente,
        nombre_persona,
        fecha_nacimiento,
        sexo,
        dni.toString().trim(),
        correo,
        telefono,
        direccion,
        cod_municipio,
        rtn,
        tipo_cliente,
        null, null, null, null, null, null, null, null,
        "CLIENTE"
      ],
      (err, results) => {
        if (err) {
          console.error("Error al actualizar cliente:", err);
          return res.status(500).json({ mensaje: "Error al actualizar cliente", error: err });
        }

        res.json({
          success: true,
          mensaje: "Cliente actualizado correctamente",
          resultado: results[0]?.[0] || {},
        });
      }
    );
  }
);

///////////////////////////////////
// Ruta para eliminar cliente con bitácora automática
router.delete(
  "/clientes/:id",
  verificarToken,
  async (req, res) => {
    const cod_cliente = req.params.id;

    try {
      // 1️⃣ Obtener los datos antes de eliminar
      const datosAntes = await new Promise((resolve, reject) => {
        db.query("CALL sp_mostrar_persona(?, ?)", [cod_cliente, "CLIENTE"], (err, results) => {
          if (err) reject(err);
          else if (!results[0] || results[0].length === 0) reject("Cliente no encontrado");
          else resolve(results[0][0]);
        });
      });

      // 2️⃣ Eliminar el cliente
      db.query(
        "CALL sp_eliminar_persona(?, ?)",
        [cod_cliente, "CLIENTE"],
        async (err, results) => {
          if (err) {
            console.error("❌ Error al eliminar cliente:", err);
            return res.status(500).json({ mensaje: "Error al eliminar cliente", error: err });
          }

          // 3️⃣ Registrar en bitácora
          try {
            const cod_usuario = req.usuario?.cod_usuario;
            const ip = obtenerIP(req);

            await registrarBitacora(cod_usuario, "Cliente", "Eliminar", ip, datosAntes, null);
            console.log("🗑️ Cliente eliminado registrado en bitácora");
          } catch (bitErr) {
            console.error("⚠️ Error al registrar bitácora de eliminación:", bitErr);
          }

          res.json({
            success: true,
            mensaje: results[0]?.[0]?.mensaje || "Cliente eliminado correctamente",
          });
        }
      );
    } catch (error) {
      console.error("❌ Error al obtener cliente antes de eliminar:", error);
      return res.status(500).json({ mensaje: "No se pudo eliminar: " + error });
    }
  }
);

//datos
router.get("/roles", (req, res) => {
  db.query("CALL sp_form_empleado(?)", ["ROLES"], (err, results) => {
    if (err)
      return res.status(500).json({
        success: false,
        mensaje: "Error al obtener roles",
        error: err.message,
      });
    res.json({ success: true, data: results[0] });
  });
});

// API: Obtener departamentos
router.get("/departamentos", (req, res) => {
  db.query("CALL sp_form_empleado(?)", ["DEPARTAMENTOS"], (err, results) => {
    if (err)
      return res.status(500).json({
        success: false,
        mensaje: "Error al obtener departamentos",
        error: err.message,
      });
    res.json({ success: true, data: results[0] });
  });
});

// API: Obtener municipios
router.get("/municipios", (req, res) => {
  db.query("CALL sp_form_empleado(?)", ["MUNICIPIOS"], (err, results) => {
    if (err)
      return res.status(500).json({
        success: false,
        mensaje: "Error al obtener municipios",
        error: err.message,
      });
    res.json({ success: true, data: results[0] });
  });
});

// Exportar algo del index para que funcione
module.exports = router;
