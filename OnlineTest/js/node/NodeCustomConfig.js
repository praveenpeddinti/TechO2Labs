


exports.proxyPort = "9091";
exports.streamPort = "8086";
exports.chatPort = "8087";
exports.notificationPort = "8088";
exports.searchPort = "8089";

exports.search = "http://sandbox.urologynation.com:"+exports.searchPort;
exports.chat = "http://sandbox.urologynation.com:"+exports.chatPort;
exports.stream = "http://sandbox.urologynation.com:"+exports.streamPort;
exports.notification = "http://sandbox.urologynation.com:"+exports.notificationPort;
exports.dir = "/usr/share/nginx/www/SkiptaNeo/protected";
exports.loglevel = "error";
/*
 * Production setttings 
 *  
exports.search = "http://www.skiptaneo.com:8089";
exports.chat = "http://www.skiptaneo.com:8087";
exports.stream = "http://www.skiptaneo.com:8086";
exports.notification = "http://www.skiptaneo.com:8088";
*/
