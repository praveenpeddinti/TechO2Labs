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
   // console.log("Number of request served = ",reqCount);
  }, 1000);
 
} else {
    var fs = require('fs');



var app = require('http').createServer()
  , io = require('socket.io').listen(app);

app.listen(config.streamPort);


//for testing
function handler (req, res) {
      res.writeHead(200);
    res.end("welcome to RiteAid post service\n");
}




var spawn = require('child_process').spawn;
var exec = require('child_process').exec;
var servedhostname = 'localhost';
var socketType = '';
var dir=config.dir;
process.on('uncaughtException', function (err) { // handling exceptions here...
//  logger.trace("=====Exception occurred====="+err);
  logger.error("=====Exception occurred====="+err);  
});
//io.configure(function() {
//    io.set('log level', 1);
//});
var child;
var g_postIds = g_postDT = 0;
var clientRequestInterval = [],
    clientPostInterval = [],
    clientNotificationInterval = [];
    

var myarray=new Array(3);



io.sockets.on('connection', function(socket) {
    
    socket.on('clientRequest', function(postids, postdt,socketId,jObject) {
        g_postIds = postids;
//        logger.trace("############IN CLIENTREQUEST#########PostIds===="+g_postIds+"===hitted  from host======json=="+jObject);
                child = spawn(dir+"/yiic", ['ncom', 'index', '--stream=' + g_postIds, '--date=' + postdt]);
                child.stdout.setEncoding('utf-8');
                child.stdout.on('data', function(data) {
                    socket.emit('serverResponse', data,socketId,jObject);
                });
                child.stderr.on('data', function(data) {
//                    logger.trace('stderr: ' + data);
                    logger.error('stderr: ' + data);
                });
    });

    socket.on('getNewPostsRequest', function(postdt, userId, userTypeId,postAsNetwork,socketId,timezoneName,jObject) {
        g_postDT = postdt;
//        logger.trace("===json object===="+jObject);
//        logger.trace("############IN getNewPostsRequest#########g_postDT===="+g_postDT);
         child = spawn(dir+"/yiic", ['ncom', 'getNewPosts', '--date=' + g_postDT, '--userId=' + userId, '--userTypeId=' + userTypeId,'--postAsNetwork='+postAsNetwork,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getNewPostsResponse', data,socketId,jObject);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
    

    });
    socket.on('getMobileNewStoriesRequest', function(postdt, userId, userTypeId,postAsNetwork,socketId,timezoneName,jObject) {
        g_postDT = postdt;
        jobject = JSON.parse(jObject)
        child = spawn(dir+"/yiic", ['ncom', 'getMobileNewStories', '--date=' + g_postDT,'--pageName='+jobject.pageName,'--userId=' + userId,'--groupId='+jobject.groupId, '--userTypeId=' + userTypeId,'--postAsNetwork='+postAsNetwork,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
//              logger.trace("&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&");
            socket.emit('getMobileNewStoriesResponse', data,socketId,jObject);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });


    });

    socket.on('getLatestPostsRequest', function(userId,userTypeId,postAsNetwork,socketId,timezoneName) {
        child = spawn(dir+"/yiic", ['ncom', 'getLatestPosts', '--userId=' + userId, '--userTypeId=' + userTypeId,'--postAsNetwork='+postAsNetwork,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getLatestPostsRes', data,socketId);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
    
    socket.on('clientRequest4CurbsidePosts', function(postids,socketId,jsonObject) {
        g_postIds = postids;        
         child = spawn(dir+"/yiic", ['ncom', 'curbsidePosts', '--stream=' + g_postIds]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('CurbsidePostsResponse', data,socketId,jsonObject);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
       

    });
    socket.on('getNewCurbsidePostsRequest', function(postdt, userId, userTypeId,socketId,timezoneName,jsonObject) {
        g_postDT = postdt;
        child = spawn(dir+"/yiic", ['ncom', 'getNewCurbsidePosts', '--date=' + postdt, '--userId=' + userId, '--userTypeId=' + userTypeId,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getNewCurbsidePostsResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
        

    });
    
    socket.on('getTopicsRequest', function(topicIds,loginUserId,socketId,jsonObject) {           
        child = spawn(dir+"/yiic", ['ncom', 'getTopics', '--topicIds=' + topicIds, '--loginUserId=' + loginUserId]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {

            socket.emit('getTopicsRes', data,socketId,jsonObject);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });

    socket.on('getLatestCurbsidePostRequest', function(userId,userTypeId,postAsNetwork,socketId,timezoneName) {
        child = spawn(dir+"/yiic", ['ncom', 'getLatestCurbsidePost', '--userId=' + userId, '--userTypeId=' + userTypeId,'--postAsNetwork='+postAsNetwork,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getLatestCurbsidePostRes', data,socketId);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });   
   
    
    socket.on('clientRequest4GroupPost', function(postids,socketId,jsonObject) {
        
        child = spawn(dir+"/yiic", ['ncom', 'groupPost', '--stream=' + postids]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('serverResponse4GroupPost', data,socketId,jsonObject);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
     socket.on('GetNewGroupPostsRequest', function(postdt, userId, userTypeId,type,groupId,socketId,timezoneName,jsonObject) {
        child = spawn(dir+"/yiic", ['ncom', 'getNewGroupPosts', '--date=' + postdt, '--userId=' + userId, '--userTypeId=' + userTypeId,'--type='+type,'--id='+groupId,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getNewGroupPostsResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
     
    
    socket.on('getLatestGroupPostRequest', function(userId,groupId, userTypeId,type,postAsNetwork,socketId,timezoneName) {
        child = spawn(dir+"/yiic", ['ncom', 'getGroupLatestPosts', '--userId=' + userId, '--groupId=' + groupId, '--userTypeId=' + userTypeId,'--type='+type,'--postAsNetwork='+postAsNetwork,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getLatestGroupPostResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
   
    
    socket.on('getUpdatedStreamPostRequest', function(userId,streamId,userTypeId,pageType,socketId,timezoneName) {
        child = spawn(dir+"/yiic", ['ncom', 'getUpdatedStreamPost', '--userId=' + userId,'--streamId=' + streamId, '--userTypeId=' + userTypeId,'--pageType='+pageType,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            if(pageType != "ProfileInteractionDivContent")
	         socket.emit('getUpdatedStreamPostResponse', data,socketId);
	    else
		socket.emit('getUpdatedStreamNewsResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
//           logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
    
    /* for Mobile */
    socket.on('getMobileLatestPost', function(postdt, userId, userTypeId,postAsNetwork,timezoneName,socketId) {        
        child = spawn(dir+"/yiic", ['ncom', 'getNewPostsForMobile', '--date=' + postdt, '--userId=' + userId, '--userTypeId=' + userTypeId,'--postAsNetwork='+postAsNetwork,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getMobileLatestPostResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
//           logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
    

    });
        socket.on('getMobileLatestCurbPost', function(postdt, userId, userTypeId,postAsNetwork,timezoneName,socketId) {        
        child = spawn(dir+"/yiic", ['ncom', 'getNewCurbPostsForMobile', '--date=' + postdt, '--userId=' + userId, '--userTypeId=' + userTypeId,'--postAsNetwork='+postAsNetwork,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getMobileLatestCurbPostResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
    

    });
     socket.on('getMobileLatestGroupPost', function(postdt, userId,groupId,userTypeId,postAsNetwork,timezoneName,socketId) {
        
        child = spawn(dir+"/yiic", ['ncom', 'getNewGroupPostsForMobile', '--date=' + postdt, '--userId=' + userId,'--groupId=' + groupId, '--userTypeId=' + userTypeId,'--postAsNetwork='+postAsNetwork,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getMobileLatestGroupPostResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
    

    });
    
/* news */
 socket.on('clientRequest4news', function(postids,socketId,jsonObject) {
        child = spawn(dir+"/yiic", ['ncom', 'newsRequest', '--postIds=' + postids]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('serverResponse4news', data,socketId,jsonObject);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
     socket.on('getMobileLatestNews', function(postdt, userId, userTypeId,postAsNetwork,timezoneName,socketId) {        
        child = spawn(dir+"/yiic", ['ncom', 'getMobileLatestNews', '--date=' + postdt, '--userId=' + userId, '--userTypeId=' + userTypeId,'--postAsNetwork='+postAsNetwork,'--timezoneName='+timezoneName]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('getMobileLatestNewsResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
    

    });
    /* end news */
    
        /* games */
 socket.on('clientRequest4Game', function(postids,socketId,jsonObject) {
        child = spawn(dir+"/yiic", ['ncom', 'gameRequest', '--postIds=' + postids]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            socket.emit('serverResponse4Game', data,socketId,jsonObject);
        });
        child.stderr.on('data', function(data) {
            console.log('stderr: ' + data);
        });

    });
    
    socket.on('clearIntervals',function(socketId,hostname){
//        logger.trace("888888888888888888#########clear interval###########"+hostname+"===");
//        if(clientRequestInterval[hostname] != undefined){
//            logger.error("111111111clear interval host===="+clientRequestInterval[hostname]);
//        }
            clearInterval(clientRequestInterval[hostname]);
    });
    /* end games */ 

    socket.on('disconnectcp', function() {        
//        logger.trace('stderr: please terminate child');
        logger.error('stderr: please terminate child');
        child.kill('SIGTERM');
    });
    
});
}

