var fs = require('fs')
    , http = require('http')
    , socketio = require('socket.io');

var mysql     =     require("mysql");

/* Creating POOL MySQL connection.*/

var pool    =    mysql.createPool({
      connectionLimit   :   100,
      host              :   '10.10.73.111',
      user              :   'root',
      password          :   'techo2',
      database          :   'techo2hrm',
      debug             :   false
});

pool.getConnection(function(err,connection){
	if(err){
		console.log(err);
	}
	if(connection){
		console.log("connected");
	}
});
/* Create server */
var server = http.createServer(function(req, res) {
    res.writeHead(200, { 'Content-type': 'text/html'});
    res.end(fs.readFileSync(__dirname + '/index.html'));
}).listen(8080, function() {
    console.log('Listening at: http://10.10.73.60:8080/');
});

socketio.listen(server).on('connection', function (socket) {

	socket.on('get count',function(data){
//            socket.emit('count', { hello:"hi" });
	   pool.getConnection(function(err,connection){
		if (err) {
		  connection.release();
		  //callback(false);
		  return;
		}
    		connection.query("select count(*) Cnt from `techo2_employee`",function(err,rows){
		    connection.release();
		    if(!err) {
		      //callback(true);
			socket.emit('count', { count:rows[0].Cnt });
		    }
        	});
     		connection.on('error', function(err) {
		      //callback(false);
		      return;
        	});
    	   });
	});

});

/*

var app = require('http').createServer(handler)
var io = require('socket.io')(app);
var fs = require('fs');

app.listen(80);

function handler (req, res) {
  fs.readFile(__dirname + '/index.html',
  function (err, data) {
    if (err) {
      res.writeHead(500);
      return res.end('Error loading index.html');
    }

    res.writeHead(200);
    res.end(data);
  });
}

io.on('connection', function (socket) {
  socket.emit('news', { hello: 'world' });
  socket.on('my other event', function (data) {
    console.log(data);
  });
});
*/
