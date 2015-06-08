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

app.listen(config.chatPort);

//for testing
function handler (req, res) {
      res.writeHead(200);
    res.end("welcome to RiteAid chat service\n");
}

var spawn = require('child_process').spawn;
var exec = require('child_process').exec;
var child;
var dir=config.dir;
//var mjmChatUsernames = [];
var mjmChatUserSockets = [];

process.on('uncaughtException', function (err) { // handling exceptions here...
  //logger.trace("=====Exception occurred====="+err);
  logger.error("=====Exception occurred====="+err); 
});

io.sockets.on('connection', function(client)
{  //console.log("cleintid-------------"+client.id);

    client.on('getUserId', function(userId)
    {
       // console.log("userId-------------" + userId + "-----clinid---" + client.id);

        mjmChatUserSockets[userId] = client;
         client.broadcast.emit('imOnLine', userId);

    });
    client.on('uncaughtException', function(err) {
        //logger.erorr('Caught exception: ' + err);
        logger.error('Caught exception: ' + err);
    });
    client.on('mjmChatAddUser', function(userId, recieverId, room, profilePicture, callback)
    {
       // console.log("add user userid-------------" + userId + "--" + recieverId + "---" + room);
        var clientReciever = mjmChatUserSockets[recieverId];
        // Convert special characters to HTML entities
        userId = htmlEntities(userId);
        recieverId = htmlEntities(recieverId);
        room = htmlEntities(room);

        client.userId = userId;
        client.profilePicture = profilePicture;
        client.room = room;

        client.join(room);
        if (clientReciever != null || clientReciever != undefined) {
            clientReciever.userId = recieverId;
            clientReciever.room = room;

            clientReciever.join(room);
           // callback("online", recieverId);
              client.emit('mjmChatAddUserResponse', "online",recieverId);
        } else {
           // callback("offline", recieverId);
              client.emit('mjmChatAddUserResponse', "offline",recieverId);
        }
    });

//    client.on('mjmChatEnterRoom', function(newRoom)
//    {
//        // Convert special characters to HTML entities
//        newRoom = htmlEntities(newRoom);
//
//        var oldRoom = client.room;
//
//        client.leave(client.room);
//        client.join(newRoom);
//        client.room = newRoom;
//
//        //io.sockets.to(oldRoom).emit('mjmChatUsers', mjmChatGetUsersRoom(oldRoom));
//        //io.sockets.to(newRoom).emit('mjmChatUsers', mjmChatGetUsersRoom(newRoom));
//    });

    client.on('mjmChatMessage', function(data, room)
    {
       // console.log("mjmChatMessage--------" + data);
        // Convert special characters to HTML entities
        data = nl2br(htmlEntities(data));

        var roomArray = room.split("-");
        if (roomArray[1] == client.userId) {
            var socket = mjmChatUserSockets[roomArray[2]];
        } else {
            var socket = mjmChatUserSockets[roomArray[1]];
        }
        
        if(socket!=null && socket!=undefined){
            socket.room = room;
            socket.join(room);
        }
           
       // io.sockets.socket(socket.id).emit('mjmChatMessage', client.userId, client.profilePicture, data);
        client.broadcast.to(room).emit('mjmChatMessage', client.userId, client.profilePicture, data);
    });

    client.on('getUserFriends', function(userId, searchText,startLimit,pageLength,callback,userIdsArray,socketId)
    {  
        //getUsersFriends(userId, searchText, callback);
        
        //var userIdsArray = Object.keys(mjmChatUserSockets);
        child = spawn(dir+'/yiic', ['chat', 'getFriends', '--userId=' + userId, '--logginedUsers=' + userIdsArray, '--searchText=' + searchText,'--startLimit=' + startLimit,'--pageLength=' + pageLength]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
          
            client.emit('getUserFriendsResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
            //logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
        
        
        
    });
     client.on('searchUsers', function(userId, searchText,startLimit,pageLength,callback,userIdsArray,socketId)
    {  //logger.tracer("searchUsers---------------------------"+userId+"--"+userIdsArray);
        //getUsersFriends(userId, searchText, callback);
        
        //var userIdsArray = Object.keys(mjmChatUserSockets);
        child = spawn(dir+'/yiic', ['chat', 'searchUsers', '--userId=' + userId, '--logginedUsers=' + userIdsArray, '--searchText=' + searchText,'--startLimit=' + startLimit,'--pageLength=' + pageLength]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
          
            client.emit('searchUsersResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
            //logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
        
        
        
    });
    client.on('loadMoreChatUsers', function(startLimit,userId, searchText,userIdsArray,socketId)
    {  
        child = spawn(dir+'/yiic', ['chat', 'loadMoreChatUsers', '--startLimit=' + startLimit, '--userId=' + userId, '--logginedUsers=' + userIdsArray, '--searchText=' + searchText]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
          
            client.emit('loadMoreChatUsersResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
            //logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
        
        
        
    });
    client.on('searchUserFriends', function(userId, callback)
    {  //console.log("getUserFriends---------------------------"+userId);
        searchUsersFriends(userId, callback);
    });
    client.on('typingStatus', function(roomName, displayName,messageReceiverId, flag)
    {  //console.log("typingStatus-------------"+roomName+"--------------"+flag+"----"+displayName+"--"+messageReceiverId);
        client.broadcast.to(roomName).emit('typingStatus', displayName,messageReceiverId, flag);

    });
    client.on('getOfflineMessages', function(loginUserId, callback,socketId)
    { // console.log("getOfflineMessages---------------------------"+loginUserId);
        //getOfflineMessages(loginUserId, callback);
            child = spawn(dir+"/yiic", ['chat', 'getOfflineMessages', '--loginUserId=' + loginUserId]);
        child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
             client.emit('getOfflineMessagesResponse', data,socketId);
        });
        child.stderr.on('data', function(data) {
           // logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });
     
        
    });
    client.on('checkStatusOfUser', function(userId,userIdsArray,socketId)
    {
         // var userIdsArray = Object.keys(mjmChatUserSockets);
       var response = new Array(userId,userIdsArray.indexOf(userId));
         client.emit('checkStatusOfUserResponse',response,socketId);
    });
    client.on('logout', function(userId)
    {
        delete mjmChatUserSockets[userId];
         client.broadcast.emit('imOffLine', userId);
    });

    client.on('disconnect', function()
    {
        //var oldRoom = client.room;
        //mjmChatUsernames.splice(mjmChatUsernames.indexOf(client.username), 1);
        //client.broadcast.emit('mjmChatStatusUser', client.username + ' has left this room');
        //client.leave(client.room);
//console.log("disconnect--------------------------"+client.userId);
 delete mjmChatUserSockets[client.userId];
        //io.sockets.to(oldRoom).emit('mjmChatUsers', mjmChatGetUsersRoom(oldRoom));
    });
});

function mjmChatCreateGuestName()
{
    var i = 0;
    do {
        i++;
        var checkExist = mjmChatUsernames.indexOf('Guest' + i.toString());
    }
    while (checkExist != -1);

    return 'Guest' + i.toString();
}

function mjmChatChangeUserIfExist(user)
{
    var i = 1;
    do {
        i++;
        var checkExist = mjmChatUsernames.indexOf(user + i.toString());
    }
    while (checkExist != -1);

    return 'Guest' + i.toString();
}

function mjmChatGetUsersRoom(room)
{
    var users = [];
    io.sockets.clients(room).forEach(function(user) {
        users.push(user.username);
    });
    return users;
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

// phpjs.org/functions/nl2br
function nl2br(str, is_xhtml)
{
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
}


