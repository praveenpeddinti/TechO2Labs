/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var config = require('NodeCustomConfig');
var cluster = require('cluster');
var numCPUs = require('os').cpus().length;
var log4js = require('log4js'); 
 var logger = log4js.getLogger();
 //logger.setLevel('trace'); // for development 
logger.setLevel(config.loglevel);  //for prodcution
if (cluster.isMaster) {
  // Fork workers.
  require('os').cpus().forEach(function(){
    cluster.fork();
  });
  // In case the worker dies!
  cluster.on('exit', function(worker, code, signal) {
    logger.error('worker ' + worker.process.pid + ' died');
  });
  // As workers come up.
  cluster.on('listening', function(worker, address) {
    logger.error("A worker with #"+worker.id+" is now connected to " +address.address + ":" + address.port);
  });
  cluster.on('online', function(worker) {
  logger.error("Yay, the worker responded after it was forked");
});
  // When the master gets a msg from the worker increment the request count.
  var reqCount = 0;
  Object.keys(cluster.workers).forEach(function(id) {
    cluster.workers[id].on('message',function(msg){
      if(msg.info && msg.info == 'ReqServMaster'){
        reqCount += 1;
      }
    });
  });
  // Track the number of request served.
  setInterval(function() {
    //console.log("Number of request served = ",reqCount);
  }, 1000);
 
} else {

var fs = require('fs');



var app = require('http').createServer()
  , io = require('socket.io').listen(app);

app.listen(config.notificationPort);

//for testing
function handler (req, res) {
      res.writeHead(200);
    res.end("welcome to RiteAid notification service\n");
}
var spawn = require('child_process').spawn;
var exec = require('child_process').exec;
var servedhostname = 'localhost';
var socketType = '';
var dir=config.dir;
process.on('uncaughtException', function (err) { // handling exceptions here...
  //logger.trace("=====Exception occurred====="+err);
  logger.error("=====Exception occurred====="+err); 
});
//io.configure(function() {
//    io.set('log level', 3);
//});
var child;
io.sockets.on('connection', function(socket) {  
    socket.on('getUnreadNotifications', function(userId,socketId,jsonObject) {
        child = spawn(dir+"/yiic", ['ncom', 'getUnreadNotifications', '--userId=' + userId]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getUnreadNotificationsRes', data,socketId,jsonObject);
        });
        child.stderr.on('data', function(data) {
            //logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
        socket.on('getAllNotificationByUserId', function(userId,page,socketId) {
        child = spawn(dir+"/yiic", ['ncom', 'getAllNotificationByUserId', '--userId=' + userId,'--startLimit='+page]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getAllNotificationByUserIdResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
            //logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
    
  socket.on('getBadgesUnlocked', function(data,jsonObject,socketId) {
         //logger.trace("*************Get badges unlocked called");
        child = spawn(dir+"/yiic", ['ncom', 'getBadgesUnlocked', '--userId=' + data.userId, '--isMobile=' + data.isMobile]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            //logger.trace("*******child.stdout.on******Get badges unlocked called");
            socket.emit('getBadgesUnlockedRes', data,jsonObject,socketId);
        });
        child.stderr.on('data', function(data) {
            //logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });

    socket.on('disconnectcp', function() {
        //logger.trace('stderr: please terminate child');
        child.kill('SIGTERM');
    });
    socket.on('disconnectcpdb', function() {
        log.trace('stderr: please terminate childd');
        childd.kill('SIGTERM');
    });
    socket.on('saveImpressionsRequest', function(userId,obj,type, socketId) {
        child = spawn(dir+"/yiic", ['track', 'saveUserImpressions', '--userId=' + userId, '--views=' + obj, '--type=' + type]);
        child.stdout.setEncoding('utf-8');
        //child.stdout.on('data');
        child.stderr.on('data', function(data) {
            //logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
    });
    socket.on('getPictocvImages', function(userId,socketId,jsonObject) {
        child = spawn(dir+"/yiic", ['ncom', 'getPictocvImages', '--userId=' + userId]);
        child.stdout.setEncoding('utf-8');
        var resData = "";
        child.stdout.on('data', function(chunk) {
            resData += chunk;
        });
        child.stdout.on('end', function() {
            socket.emit('getPictocvImagesRes', resData,socketId,jsonObject);
        });
        child.stderr.on('data', function(data) {
            //logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
    socket.on('getPictocvObjectByOppertunity', function(userId, opportunityType ,partialViewPath, socketId,jsonObject) {
        child = spawn(dir+"/yiic", ['ncom', 'getPictocvObjectByOppertunity', '--userId=' + userId, '--opportunityType='+opportunityType, '--partialViewPath='+partialViewPath]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getPictocvObjectByOppertunityRes', data,socketId,jsonObject);
        });
        child.stderr.on('data', function(data) {
            //logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
});
}

