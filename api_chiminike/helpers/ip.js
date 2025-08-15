function obtenerIP(req) {
    let ip = req.headers['x-forwarded-for'] || req.socket.remoteAddress;

    if (!ip) return "IP no disponible";
    if (ip === '::1') return '127.0.0.1';
    if (ip.startsWith('::ffff:')) return ip.replace('::ffff:', '');

    return ip;
}

module.exports = obtenerIP;
