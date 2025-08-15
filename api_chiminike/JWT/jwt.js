const jwt = require('jsonwebtoken');
require('dotenv').config();

const generarToken = (datosUsuario) => {
    return jwt.sign(datosUsuario, process.env.JWT_SECRET, {
        expiresIn: process.env.JWT_EXPIRES_IN
    });
};

const verificarToken = (token) => {
    return jwt.verify(token, process.env.JWT_SECRET);
};

module.exports = { generarToken, verificarToken };
