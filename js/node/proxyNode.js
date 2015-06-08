var https = require('https'),
    http = require('http'),
    util = require('util'),
    path = require('path'),
    fs = require('fs'),
    config = require('SkiptaNeo'),
    g_postIds = 0,
    g_postDT = 0,    
    newPostTime=0,
    clientRequestInterval = [],
    clientSurveyInterval = [],
    clientPostInterval = [],
    clientNotificationInterval = [],

    clientBadgeInterval = [],
    clientTopicsInterval = [],
    clientPictocvInterval = [],
      clientSurveyArray = [],
      clientRequest;
 var mjmChatUserSockets = [];
 var timezoneName = "";
 var maxconnections = 200000;
 var connections = 0;
 var userId;
 var log4js = require('log4js'); 
// var dateFormat = require('dateformat');
 var spawn = require('child_process').spawn;
// log4js.configure({
//  appenders: [
//    { type: 'console' },
//    { type: 'file', filename: config.logfilepath+"/test.log", category: 'test' }
//  ]
//});

var now = new Date();


var logger = log4js.getLogger();
 //logger.setLevel('trace'); // for development 
logger.setLevel(config.loglevel);  //for prodcution


try{
var options = {
 key: fs.readFileSync('/etc/nginx/certs/Provision/Provision.key'),
   //  cert: fs.readFileSync('/etc/nginx/certs/NodeCustomConfig/NodeCustomConfig.crt'),
   cert: fs.readFileSync('/etc/nginx/certs/Provision/Provision.pem'),

   };
var app = require('https').createServer(options, handler)
  , io = require('socket.io').listen(app);
  app.listen(config.proxyPort);
  
//var io = require('socket.io').listen(config.proxyPort);
//  io.set('transport', [
// 'flashsocket'
//  , 'htmlfile'
//  , 'xhr-polling'
//  , 'jsonp-polling'
//  ]);
  /*search start*/


var io_client = require('socket.io-client');
var socket2 = io_client.connect(config.search);
socket2.on('connect_failed', function(){
    //console.log('Connection Failed');
});
socket2.on('connect', function(){
    logger.trace('search Connected');
    logger.error('search Connected');
    projectSearch = function(search, projectOffset, projectPageLength, userSearch, groupsSearch,subGroupsSearch,hastagsSearch, postSearch,loginUserId,curbsideCategory,gameSearch,socketId){
         socket2.emit('projectSearch', search, projectOffset, projectPageLength, userSearch, groupsSearch,subGroupsSearch,hastagsSearch, postSearch,loginUserId,curbsideCategory,gameSearch,socketId) ;

    }
    trackSearchAchievements = function(obj,socketId){
         socket2.emit('trackSearchAchievements', obj,socketId) ;

    }
	 mobileSearch = function(searchdata,socketId){
         socket2.emit('mobileSearch',searchdata,socketId) ;

    }

 getUsersForSearch = function(searchdata,socketId){
         socket2.emit('getUsersForSearch',searchdata,socketId) ;

    }
    saveBrowseDetails = function(sessionObject){
    socket2.emit('saveBrowseDetails', sessionObject) ;
 
    }
    connectToSurvey = function(userId,scheduleId,socketId,jObject){
    socket2.emit('connectToSurvey', userId,scheduleId,socketId,jObject) ;
 
    }
    unsetSpot = function(userId,scheduleId,socketId){
    socket2.emit('unsetSpot', userId,scheduleId,socketId) ;
 
    }
});
socket2.on('disconnect', function () {
  //console.log('Disconnected');
});
 socket2.on('projectSearchResponse', function(data,socketId) {
 projectSearchResponse(data,socketId);
 });
 socket2.on('connectToSurveyResponse', function(data,socketId,jObject) {
 connectToSurveyResponse(data,socketId,jObject);
 });
  socket2.on('getUsersForSearchResponse', function(data,socketId) {

 getUsersForSearchResponse(data,socketId);
 });

  socket2.on('mobileSearchResponse', function(data,socketId) {

 mobileSearchResponse(data,socketId);
 });
 
 /*search end*/
 /*stream start*/
 var io_client3 = require('socket.io-client');
var socket3 = io_client3.connect(config.stream);
socket3.on('connect_failed', function(){
    //console.log('Connection Failed');
});
socket3.on('connect', function(){
    logger.trace('Stream Connected');
    logger.error('Stream Connected');
    clientRequest = function(postids, postdt,socketId,jObject){
         socket3.emit('clientRequest', postids, postdt,socketId,jObject) ;

    }
    getNewPostsRequest = function(postdt, userId, userTypeId,postAsNetwork,clientId,jObject){
         socket3.emit('getNewPostsRequest', postdt, userId, userTypeId,postAsNetwork,clientId,timezoneName,jObject) ;

    }
     getMobileNewStoriesRequest = function(postdt, userId, userTypeId,postAsNetwork,clientId,jObject){
        
         socket3.emit('getMobileNewStoriesRequest', postdt, userId, userTypeId,postAsNetwork,clientId,timezoneName,jObject) ;

    }
    getLatestPostsRequest = function(userId,userTypeId,postAsNetwork,clientId){
       
         socket3.emit('getLatestPostsRequest', userId,userTypeId,postAsNetwork,clientId,timezoneName);

    }
    
     clientRequest4CurbsidePosts = function(postids,socketId,jsonObject){
         socket3.emit('clientRequest4CurbsidePosts', postids,socketId,jsonObject) ;

    }
     getNewCurbsidePostsRequest = function(postdt, userId, userTypeId,socketId,jsonObject){
         socket3.emit('getNewCurbsidePostsRequest', postdt, userId, userTypeId,socketId,timezoneName,jsonObject) ;

    }
     getLatestCurbsidePostRequest = function(userId,userTypeId,postAsNetwork,socketId){
         socket3.emit('getLatestCurbsidePostRequest', userId,userTypeId,postAsNetwork,socketId,timezoneName) ;

    }
    clientRequest4GroupPost = function(postids,socketId,jsonObject){
         socket3.emit('clientRequest4GroupPost', postids,socketId,jsonObject) ;

    }
     GetNewGroupPostsRequest = function(postdt, userId, userTypeId,type,groupId,socketId,jsonObject){
         socket3.emit('GetNewGroupPostsRequest', postdt, userId, userTypeId,type,groupId,socketId,timezoneName,jsonObject) ;

    }
     getLatestGroupPostRequest = function(userId,groupId, userTypeId,type,postAsNetwork,socketId){
         socket3.emit('getLatestGroupPostRequest', userId,groupId, userTypeId,type,postAsNetwork,socketId,timezoneName) ;

    }
     getUpdatedStreamPostRequest = function(userId,streamId,userTypeId,pageType,socketId){
         socket3.emit('getUpdatedStreamPostRequest', userId,streamId,userTypeId,pageType,socketId,timezoneName) ;

    }
    clientRequest4news = function(postids, socketId,jsonObject){
         socket3.emit('clientRequest4news', postids, socketId,jsonObject) ;

    }
        
    clientRequest4games = function(postids, socketId,jsonObject){
         socket3.emit('clientRequest4Game', postids, socketId,jsonObject) ;

    }
    
    clearConnectedClientInterval = function(socketId,hostname){            
         socket3.emit('clearIntervals', socketId,hostname) ;

    }
    
    getMobileLatestPost = function(postdt, userId, userTypeId,postAsNetwork,socketId){                
        socket3.emit('getMobileLatestPost', postdt, userId, userTypeId,postAsNetwork,timezoneName,socketId) ;
    }
     getMobileLatestGroupPost = function(postdt, userId,groupId,userTypeId,postAsNetwork,socketId){        
        socket3.emit('getMobileLatestGroupPost', postdt, userId,groupId,userTypeId,postAsNetwork,timezoneName,socketId) ;
    }
     getMobileLatestCurbPost = function(postdt, userId, userTypeId,postAsNetwork,socketId){
        socket3.emit('getMobileLatestCurbPost', postdt, userId, userTypeId,postAsNetwork,timezoneName,socketId) ;
    }
     getMobileLatestNews = function(postdt, userId, userTypeId,postAsNetwork,socketId){
        socket3.emit('getMobileLatestNews', postdt, userId, userTypeId,postAsNetwork,timezoneName,socketId) ;
    }
     getTopicsRequest = function(topicIds,loginUserId,socketId,jsonObject){
      
         socket3.emit('getTopicsRequest', topicIds,loginUserId,socketId,jsonObject);

    }
//    clientRequest = function(postids, postdt,socketId,jObject){
//         socket3.emit('clientRequest', postids, postdt,socketId,jObject) ;
//
//    }
});
socket3.on('getMobileLatestPostResponse', function(data,socketId) {
 getMobileLatestPostResponse(data,socketId);
 });
 socket3.on('getMobileLatestGroupPostResponse', function(data,socketId) {
 getMobileLatestGroupPostResponse(data,socketId);
 });
socket3.on('getMobileLatestCurbPostResponse', function(data,socketId) {
 getMobileLatestCurbPostResponse(data,socketId);
 });
  socket3.on('getMobileLatestNewsResponse', function(data,socketId) {
 getMobileLatestNewsResponse(data,socketId);
 });
  socket3.on('getMobileNewStoriesResponse', function(data,socketId,jsonObject) {
      //console.log("@@@@@@@@@@@@@@@@@@@@@@@@@@@@---");
 getMobileNewStoriesResponse(data,socketId,jsonObject);
 });
 socket3.on('serverResponse', function(data,socketId,jsonObject) {
      
 serverResponse(data,socketId,jsonObject);
 });
 socket3.on('getNewPostsResponse', function(data,socketId,jsonObject) {
       
 getNewPostsResponse(data,socketId,jsonObject);
 });
 socket3.on('getLatestPostsRes', function(data,socketId) {
 getLatestPostsRes(data,socketId);
 });
 
 socket3.on('CurbsidePostsResponse', function(data,socketId,jsonObject) {
 CurbsidePostsResponse(data,socketId,jsonObject);
 });
 socket3.on('getNewCurbsidePostsResponse', function(data,socketId) {
 getNewCurbsidePostsResponse(data,socketId);
 });
 socket3.on('getLatestCurbsidePostRes', function(data,socketId) {
 getLatestCurbsidePostRes(data,socketId);
 });
 socket3.on('serverResponse4GroupPost', function(data,socketId,jsonObject) {
 serverResponse4GroupPost(data,socketId,jsonObject);
 });
 socket3.on('getNewGroupPostsResponse', function(data,socketId) {
 getNewGroupPostsResponse(data,socketId);
 });
  socket3.on('getLatestGroupPostResponse', function(data,socketId) {
 getLatestGroupPostResponse(data,socketId);
 });
  socket3.on('getUpdatedStreamPostResponse', function(data,socketId) {
 getUpdatedStreamPostResponse(data,socketId);
 });
 socket3.on('getUpdatedStreamNewsResponse', function(data,socketId) {
 getUpdatedStreamNewsResponse(data,socketId);
 });
 socket3.on('serverResponse4news', function(data,socketId,jsonObject) {
 serverResponse4news(data,socketId,jsonObject);
 });
 socket3.on('serverResponse4Game', function(data,socketId,jsonObject) {
 serverResponse4games(data,socketId,jsonObject);
 });
  socket3.on('getTopicsRes', function(data,socketId,jsonObject) {
 getTopicsRes(data,socketId,jsonObject);
 });
 socket3.on('disconnect', function () {
  //console.log('Disconnected');
});
  /*stream end*/
   /*Notification Start*/
     var io_client5 = require('socket.io-client');
var socket5 = io_client5.connect(config.notification);
socket5.on('connect_failed', function(){
    //console.log('Connection Failed');
});
socket5.on('connect', function(){
    logger.trace('Notification Connected');
logger.error('Notification Connected');
    getUnreadNotifications = function(userId,socketId,jsonObject){
         socket5.emit('getUnreadNotifications', userId,socketId,jsonObject) ;

    }
    getAllNotificationByUserId = function(userId,page,socketId){
         socket5.emit('getAllNotificationByUserId', userId,page,socketId) ;

    }
    
     getBadgesUnlocked = function(obj,jsonObject,socketId){
        // console.log("============*************================");
         socket5.emit('getBadgesUnlocked', obj,jsonObject,socketId) ;

    }
    saveImpressionsRequest = function(userId,obj,type,clientId){
         socket5.emit('saveImpressionsRequest', userId,obj,type,clientId);
    }
    getPictocvImages = function(userId,socketId,jsonObject){
         socket5.emit('getPictocvImages', userId,socketId,jsonObject) ;
    }
    getPictocvObjectByOppertunity = function(userId, opportunityType ,partialViewPath, socketId,jsonObject){
         socket5.emit('getPictocvObjectByOppertunity', userId, opportunityType ,partialViewPath, socketId,jsonObject) ;
    }
});

 socket5.on('getUnreadNotificationsRes', function(data,socketId,jsonObject) {
 getUnreadNotificationsRes(data,socketId,jsonObject);
 });
 socket5.on('getAllNotificationByUserIdResponse', function(data,socketId) {
 getAllNotificationByUserIdResponse(data,socketId);
 });
  socket5.on('getBadgesUnlockedRes', function(data,jsonObject,socketId) {
 getBadgesUnlockedRes(data,jsonObject,socketId);
 });
 socket5.on('getPictocvImagesRes', function(data,socketId,jsonObject) {
    getPictocvImagesRes(data,socketId,jsonObject);
 });
 socket5.on('getPictocvObjectByOppertunityRes', function(data, socketId,jsonObject) {
    getPictocvObjectByOppertunityRes(data, socketId,jsonObject);
 });
 socket5.on('disconnect', function () {
  //console.log('Disconnected');
});
    /*Notification End*/
    
  /*chat start*/
   var io_client4 = require('socket.io-client');
var socket4 = io_client4.connect(config.chat);
socket4.on('connect_failed', function(){
    //console.log('Connection Failed');
});
socket4.on('connect', function(){
    logger.trace('chat Connected');
    logger.error('chat Connected');
    getUserId = function(userId){
         socket4.emit('getUserId', userId) ;

    }
    mjmChatAddUser = function(userId, recieverId, room, profilePicture, callback){
         socket4.emit('mjmChatAddUser', userId, recieverId, room, profilePicture, callback) ;

    }
    getUserFriends = function(userId, searchText,startLimit,pageLength,callback,socketId){
         var userIdsArray = Object.keys(mjmChatUserSockets);
        socket4.emit('getUserFriends', userId, searchText,startLimit,pageLength,callback,userIdsArray,socketId) ; 
    }
    searchUsers = function(userId, searchText,startLimit,pageLength,callback,socketId){
         var userIdsArray = Object.keys(mjmChatUserSockets);
        socket4.emit('searchUsers', userId, searchText,startLimit,pageLength,callback,userIdsArray,socketId) ; 
    }
    mjmChatMessage = function(data, room){
          socket4.emit('mjmChatMessage',data, room) ; 
    }
    typingStatus = function(roomName, displayName,messageReceiverId, flag){
          socket4.emit('typingStatus',roomName, displayName,messageReceiverId, flag) ; 
    }
    checkStatusOfUser = function(userId,socketId){
         var userIdsArray = Object.keys(mjmChatUserSockets);
         socket4.emit('checkStatusOfUser',userId,userIdsArray,socketId) ; 
    }
    logout = function(userId){
         socket4.emit('logout',userId) ; 
    }
    getOfflineMessages = function(loginUserId, callback,socketId){
         socket4.emit('getOfflineMessages',loginUserId, callback,socketId) ;
    }
    loadMoreChatUsers = function(startLimit,userId, searchText,socketId){
        var userIdsArray = Object.keys(mjmChatUserSockets);
        socket4.emit('loadMoreChatUsers', startLimit,userId, searchText,userIdsArray,socketId) ; 
    }
    
});

 socket4.on('serverResponse', function(data) {
    
 serverResponse(data);
 });
 socket4.on('mjmChatAddUserResponse', function(status, offlineUserId) {
 mjmChatAddUserResponse(status, offlineUserId);
 });
 socket4.on('getUserFriendsResponse', function(data,socketId) {
 getUserFriendsResponse(data,socketId);
 });
 socket4.on('searchUsersResponse', function(data,socketId) {
 searchUsersResponse(data,socketId);
 });
  socket4.on('checkStatusOfUserResponse', function(response,socketId) {
 checkStatusOfUserResponse(response,socketId);
 });
  socket4.on('getOfflineMessagesResponse', function(data,socketId) {
 getOfflineMessagesResponse(data,socketId);
 });
  socket4.on('loadMoreChatUsersResponse',function(data,socketId){
     loadMoreChatUsersResponse(data,socketId);
 });
 socket4.on('disconnect', function () {
  //console.log('Disconnected');
});
  /*chat end*/
 
    
    function handler (req, res) {
    //console.log("handler--------------------");
      res.writeHead(200);
    res.end("welcome to Skiptaneo search service started-----\n");
   
}
process.on('uncaughtException', function (err) { // handling exceptions here... 
  logger.error('=====Exception occurred====='+err);
  
});
io.set('authorization', function (handshakeData, cb) {
  
    timezoneName = handshakeData._query.timezoneName;
      userId = handshakeData._query.userId;
    //logger.trace('aurothirzeion:---------------- '+timezoneName+"---"+userId);
    //logger.error('aurothirzeion:---------------- '+timezoneName+"---"+userId);
//    for(var  p in handshakeData){
//         console.log('Auth:---------------- '+  p);
//    }
    cb(null, true);
});
io.sockets.on('connection', function(client)
{    
     /*Search Start*/
        client.userId = userId;
       if (mjmChatUserSockets[userId] != null || mjmChatUserSockets[userId] != undefined) {           
            var array = mjmChatUserSockets[userId];
            array.push(client);
             mjmChatUserSockets[userId] = array;
        }else{                          
              mjmChatUserSockets[userId] = new Array(client);
        }

         client.broadcast.emit('imOnLine', userId);

   client.on('projectSearch', function(searchText,offset,pageLength,userSearch,groupsSearch,subGroupsSearch,hastagsSearch,postSearch,loginUserId,curbsideCategory,gameSearch)
    { 
             projectSearch(searchText, offset, pageLength, userSearch, groupsSearch,subGroupsSearch,hastagsSearch, postSearch,loginUserId,curbsideCategory,gameSearch,client.id);

    });
    client.on('trackSearchAchievements', function(obj)
    { 
             trackSearchAchievements(obj,client.id);

    });
 client.on('mobileSearch', function(searchdata)
    { 
       
       mobileSearch(searchdata,client.id);

    });
client.on('getUsersForSearch', function(searchdata)
    { 
        
       getUsersForSearch(searchdata,client.id);

    });
     client.on('saveBrowseDetails', function(sessionObject)
    { 
     // console.log("saveBrowseDetails******************"); 
       
       saveBrowseDetails(sessionObject);

    });
    
      client.on('connectToSurvey', function(userId,scheduleId,jsonObject)
    { 
        
       
         if (clientSurveyArray[userId] != null || clientSurveyArray[userId] != undefined) {
            
            var array = clientSurveyArray[userId];
            array.push(client);
             clientSurveyArray[userId] = array;
        }else{
             
              clientSurveyArray[userId] = new Array(client);
        }
        var clients = clientSurveyArray[userId];
       
        for (var i = 0; i < clients.length; i++) {
             
              if(clients[i].id != client.id){
                  
                  var data = {"scheduleId":scheduleId,"userId":userId};
                 clients[i].emit("SurveyPageLoadResponse",data);
              }
            }
            
        
        var job = JSON.parse(jsonObject);
        var gPage = job.uniquekey;
       // console.log("============############IN CLIENTREQUEST#########PostIds=======hitted  from host==="+job.uniquekey+"===json=="+jsonObject+"=====page==PF1===="+job.PF1);
        var intervalTime = parseInt(job.sCountTime);
       // console.log("@@@@@@@@@@@@@@@@$$$$$$$$$$$$$$ IN CLIENTREQUEST#########intervalTime=======hitted  from host==="+intervalTime);
        if(job.PF1 == 1){
       
            // console.log("connections===="+connections+"===maxConnection==="+maxconnections+"@@@@@@@@@@@@@@@@$$$$$$$$$$$$$$ IN clientRequestInterval#########intervalTime=======hitted  from host==="+intervalTime);
             if(connections <= maxconnections){       
                 connections++;
                // console.log("==1111111111111111111111=====connections <= maxconnections======clientRequest---in interval-----------------===pageFlag==*******==="); 
                 clearInterval(clientSurveyInterval[gPage]);
                 clientSurveyInterval[gPage] = setInterval(function(){  
    //                getPostIdsFromClient(postids,postdt,client.id,jsonObject);
               // console.log("=======clientId======clientRequest---in interval-----------------===pageFlag==*******==="); 
                 connectToSurvey(userId,scheduleId,client.id,jsonObject)

                   //clientRequest(g_postIds, postdt,client.id,jsonObject);
               },intervalTime);
             }
       }
      ;

    });
    client.on('unsetSpotforSchedule', function(userId,scheduleId)
    { 
       
       unsetSpot(userId,scheduleId,client.id);
    
    });
    projectSearchResponse = function(data,socketId){
       // console.log("projectSearchResponse--------------------"+socketId); 
                   var socketObj;
         var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
            // console.log("------------------"+clients[i].id);
              if(clients[i].id == socketId){
                socketObj =  clients[i]; 
              }
            }
            try{
                socketObj.emit("projectSearchResponse",data);
            }catch(er){                
                //logger.trace("Exception Occurred=== in projectSearchResponse emit====="+er);
                logger.error("Exception Occurred=== in projectSearchResponse emit====="+er);
            }
//           client.emit("projectSearchResponse",data);
 
    }
      connectToSurveyResponse = function(data,socketId,jsonObject){
     // console.log("connectToSurveyResponse--------------------"+socketId); 
     //  console.log("data--------------------"+data); 
     // console.log("jsonObject--------------------"+jsonObject); 
                   var socketObj;
         var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
            // console.log("------------------"+clients[i].id);
              if(clients[i].id == socketId){
                socketObj =  clients[i]; 
              }
            }
            try{
                 var job = JSON.parse(jsonObject);
                if(data!="" && data!=0 && data!=null){
                  //  console.log("socketid-----------------"+socketObj);
                socketObj.emit("connectToSurveyResponse",data);
                }
              
            }catch(er){
                clearInterval(clientSurveyInterval[job.uniquekey]);
//                console.log("%%%%%%%%%%%%%---no client found for survey");
//                 if(data!="" && data!=0 && data!=null){
//                     data = eval("("+data+")");
//                      console.log("userid----"+data.loginUserId);
//               unsetSpot(data.loginUserId,data.scheduleId,socketId);
//                clearInterval(clientSurveyInterval[job.uniquekey]);
//                 }
                
            }
//           client.emit("projectSearchResponse",data);
 
    }
 mobileSearchResponse = function(data,socketId){
       // console.log("mobileSearchResponse--------------------"+socketId); 
                   var socketObj;
         var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
           //  console.log("---mobileSearchResponse----InProxyNode-----------"+clients[i].id);
              if(clients[i].id == socketId){
                socketObj =  clients[i]; 
              }
            }
            try{ 
		//console.log("---mobileSearchResponse----InNode----------000000000-");
		//console.log("---mobileSearchResponse----InNode----data-------"+data);
  		if(data!="" && data!=0 && data!=null){
//console.log("---mobileSearchResponse----"+data);
                socketObj.emit("mobileSearchResponse",data);}
            }catch(er){                
                //logger.trace("Exception Occurred=== in mobileSearchResponse emit====="+er);
                logger.error("Exception Occurred=== in mobileSearchResponse emit====="+er);
            }
//           client.emit("projectSearchResponse",data);
 
    }
        getUsersForSearchResponse = function(data, socketId) {
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
            try {
                if (data != "" && data != 0 && data != null) {
                    socketObj.emit("getUsersForSearchResponse", data);
                }
            } catch (er) {                
                //logger.trace("Exception Occurred=== in while emit====="+er);
                logger.error("Exception Occurred=== in while emit====="+er);
            }
//           client.emit("projectSearchResponse",data);

        }
    /*Search End*/
    /*Stream Start*/
    client.on('clientRequest', function(postids, postdt,flag,jsonObject)
    { 
        //g_postIds = postids;  
        var job = JSON.parse(jsonObject);
        var gPage = job.uniquekey;
       // console.log("============############IN CLIENTREQUEST#########PostIds=======hitted  from host==="+job.uniquekey+"===json=="+jsonObject+"=====page==PF1===="+job.PF1);
        var intervalTime = parseInt(job.sCountTime);
       // console.log("@@@@@@@@@@@@@@@@$$$$$$$$$$$$$$ IN CLIENTREQUEST#########intervalTime=======hitted  from host==="+intervalTime);
        if(job.PF1 == 1){
                     
            // console.log("connections===="+connections+"===maxConnection==="+maxconnections+"@@@@@@@@@@@@@@@@$$$$$$$$$$$$$$ IN clientRequestInterval#########intervalTime=======hitted  from host==="+intervalTime);
             if(connections <= maxconnections){       
                 connections++;
                // console.log("==1111111111111111111111=====connections <= maxconnections======clientRequest---in interval-----------------===pageFlag==*******==="); 
                 clearInterval(clientRequestInterval[gPage]);
                 clientRequestInterval[gPage] = setInterval(function(){  
    //                getPostIdsFromClient(postids,postdt,client.id,jsonObject);
               // console.log("=======clientId======clientRequest---in interval-----------------===pageFlag==*******==="); 
                client.emit('getPostIdsFromClient',jsonObject,client.id);

                   //clientRequest(g_postIds, postdt,client.id,jsonObject);
               },intervalTime);
             }
       }
       

    });
    
     serverResponse = function(data,socketId,jsonObject){
         var job = JSON.parse(jsonObject);
                   var socketObj;
         var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
//             console.log("------------------"+clients[i].id);
              if(clients[i].id == socketId){
                socketObj =  clients[i]; 
              }
            }
            try{
                if(data != "" && data != 0 && data != 1)
                 socketObj.emit("serverResponse",data);
            }catch(er){                
                
                //logger.trace("=EXCEPTION ############%%%%%%%%%%%%%%%%=serverResponse===Exception Occurred=== in emit====="+er);
                logger.error("=EXCEPTION ############%%%%%%%%%%%%%%%%=serverResponse===Exception Occurred=== in emit====="+er);
                killAllIntervals(job.uniquekey);
                 //logger.trace("==serverResponse===Exception Occurred=== in emit====="+er);
                 logger.error("==serverResponse===Exception Occurred=== in emit====="+er);
                
            }
 
    }
      client.on('getNewPostsRequest', function(postdt, userId, userTypeId,postAsNetwork,jObject)
    { 
       // g_postDT = postdt
       // console.log("getNewPostsRequest----------------"+postdt+"----"+client.id+"===postDt=======json object==="+jObject); 
        
        var jobj = JSON.parse(jObject);
        var gPage = jobj.uniquekey;
       // console.log("getNewPostsRequest-=interval---------------"+jobj.storiesTime+"===hostname==="+jobj.uniquekey); 
        
        if(jobj.PF2 == 1){
            if(connections <= maxconnections){
                clearInterval(clientPostInterval[gPage]);
                clientPostInterval[gPage] = setInterval(function(){                
                    client.emit("getPostDtsFromClient",userId, userTypeId,postAsNetwork,jObject,client.id);
                    //getNewPostsRequest(g_postDT, userId, userTypeId,postAsNetwork,client.id,jObject);
                },jobj.storiesTime);
            }
        }
       

    });
    
     getNewPostsResponse = function(data,socketId,jsonObject){
       //   console.log("getNewPostsResponse--------------------"+socketId); 
//           console.log("getNewPostsResponse=====Data=!!!!!!!!!!!!!!!!!!!========"+data);
         var job = JSON.parse(jsonObject);
         var socketObj;
         var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
            // console.log("------------------"+clients[i].id);
              if(clients[i].id == socketId){
                socketObj =  clients[i]; 
              }
            }
        // console.log("getNewPostsResponse--------------------"+ io.sockets.sockets[socketId]); 
        try{
            if(data != "" && data != 0 && data != 1)
               socketObj.emit("getNewPostsResponse",data);
        }catch(er){
                killAllIntervals(job.uniquekey);
                //logger.trace("==getNewPostsResponse===Exception Occurred=== in emit====="+er);
                logger.error("==getNewPostsResponse===Exception Occurred=== in emit====="+er);
        }
 
    }
     client.on('getLatestPostsRequest', function(userId,userTypeId,postAsNetwork,hostname)
    { 
       //console.log("getLatestPostsRequest--------------------"+client.id+"======"+hostname); 
        clearInterval(clientPostInterval[hostname+"HomeStream"]);
       // console.log("afterr killed--------------------======"+hostname); 
       getLatestPostsRequest(userId,userTypeId,postAsNetwork,client.id);

    });
        getLatestPostsRes = function(data, socketId) {
            //console.log("getLatestPostsRes--------------------"+socketId); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
               // console.log("------------------" + clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
            try{
                if(data != "" && data != 0 && data != 1)
                socketObj.emit("getLatestPostsRes", data);
            }catch(err){
                //logger.trace("Exception occurred while emit=="+err);
                logger.error("Exception occurred while emit=="+err);
            }

        }
         
        client.on('clientRequest4CurbsidePosts', function(postids, jsonObject)
        {

            //g_postIds = postids;
           // console.log("\n\n=====clientRequest4CurbsidePosts--------------------" );
            var job = JSON.parse(jsonObject);
            var gPage;            
            
           // console.log("############IN clientRequest4CurbsidePosts#########PostIds=======hitted  from host===" + job.uniquekey + "===json==" + jsonObject);
            var intervalTime = parseInt(job.sCountTime);
            if (job.PF1 == 1) { 
                connections++;
                gPage = job.uniquekey;
                
                if(connections < maxconnections){
                    clearInterval(clientRequestInterval[gPage]);
                    clientRequestInterval[gPage] = setInterval(function() {

                       // console.log("\n\n\n\n\n\n\n12212222222222 22 2 ############IN interval of clientRequest4CurbsidePosts#########interval===postIds="+gPage);
                        client.emit('getPostIdsFromClient',jsonObject,client.id);
                        //clientRequest4CurbsidePosts(g_postIds, client.id, jsonObject);
                    }, intervalTime);
                }
            }

        });
        
        CurbsidePostsResponse = function(data, socketId,jsonObject) {
           // console.log("CurbsidePostsResponse--------------------"); 
            var job = JSON.parse(jsonObject);
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                    break;
                }
            }
            try{
                if(data != "" && data != 0 && data != 1)
                    socketObj.emit("CurbsidePostsResponse", data);
                }catch(er){
                    killAllIntervals(job.uniquekey);
                    //logger.trace("==CurbsidePostsResponse===Exception Occurred=== in emit====="+er);
                    logger.error("==CurbsidePostsResponse===Exception Occurred=== in emit====="+er);
                }

        }
        client.on('getNewCurbsidePostsRequest', function(postdt, userId, userTypeId, jsonObject)
        {
            //g_postDT = postdt
            var job = JSON.parse(jsonObject);
           // console.log("#########$$$$$$$$$$$  ===getNewCurbsidePostsRequest----------------" + postdt + "----" + client.id + "===postDt======json object===" + jsonObject);
            var gPage;
            newPostTime = parseInt(job.storiesTime);
            //console.log("======newPostTime interval====="+newPostTime);
            if (job.PF2 === 1) {
                gPage = job.uniquekey;                
                if(connections < maxconnections){
                    clearInterval(clientPostInterval[gPage]);
                    clientPostInterval[gPage] = setInterval(function() {
                        //console.log("########getNewCurbsidePostsRequest####interval#########PostDT====");
                        client.emit("getPostDtsFromClient",userId, userTypeId,'',jsonObject,client.id);                    
                    },newPostTime);
                }
            }



        });
        getNewCurbsidePostsResponse = function(data, socketId) {
           // console.log("getNewCurbsidePostsResponse--------------------"); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                    break;
                }
            }
            try{
                if(data != "" && data != 0 && data != 1)
                    socketObj.emit("getNewCurbsidePostsResponse", data);
            }catch(err){
                //logger.trace("Exception occurred in getNewCurbsidePostsResponse=="+err);
                logger.error("Exception occurred in getNewCurbsidePostsResponse=="+err);
            }
        }
     client.on('getLatestCurbsidePostRequest', function(userId,userTypeId,postAsNetwork,key)
    { 
      // console.log("getLatestCurbsidePostRequest-----333333333333333333333333333333333333333333333333-----------lasdjfljd----"); 
       clearInterval(clientPostInterval[key]);
       getLatestCurbsidePostRequest(userId,userTypeId,postAsNetwork,client.id);

    });
        getLatestCurbsidePostRes = function(data, socketId) {
            //console.log("getLatestCurbsidePostRes--------------------"); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                    break;
                }
            }
            try{
                if(data != "" && data != 0 && data != 1)
                    socketObj.emit("getLatestCurbsidePostRes", data);
            }catch(err){
                //logger.trace("Exception occurred in getLatestCurbsidePostRes=="+err);
                logger.error("Exception occurred in getLatestCurbsidePostRes=="+err);
            }
        }
     client.on('clientRequest4GroupPost', function(postids,jsonObject)
    { 
           // console.log("clientRequest4GroupPost--------------------"); 
            //g_postIds = postids;
           // console.log("clientRequest4GroupPost--------------------");            
            var job = JSON.parse(jsonObject);
            var gPage;
           // console.log("\n\n\n############IN clientRequest4GroupPost#########PostIds=======hitted  from host===" + job.uniquekey + "===json==" + jsonObject);
            var intervalTime = parseInt(job.sCountTime);
            if (job.PF1 == 1) {  
                gPage = job.uniquekey;
                connections++;
                if(connections <= maxconnections){
                    clearInterval(clientRequestInterval[gPage]);
                    clientRequestInterval[gPage] = setInterval(function() {                    
                      //  console.log("====############IN interval clientRequest4GroupPost#########PostIds====" );
                        client.emit('getPostIdsFromClient',jsonObject,client.id);

                    },intervalTime);
                }
            }
       

    });
        serverResponse4GroupPost = function(data, socketId,jsonObject) {
            //console.log("serverResponse4GroupPost--------------------"+socketId);
            var job = JSON.parse(jsonObject);
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                    break;
                }
            }
            try{
                if(data != "" && data != 0 && data != 1)
                    socketObj.emit("serverResponse4GroupPost", data);
                }catch(er){
                    killAllIntervals(job.uniquekey);                    
                    //logger.trace("==serverResponse4GroupPost===Exception Occurred=== in emit====="+er);
                    logger.error("==serverResponse4GroupPost===Exception Occurred=== in emit====="+er);
                }
        }
       client.on('GetNewGroupPostsRequest', function(postdt, userId, userTypeId,type,groupId,jsonObject)
        { 
      // console.log("GetNewGroupPostsRequest--------------groupId------"+groupId); 
       
            //g_postDT = postdt
            var job = JSON.parse(jsonObject);
           // console.log(clientRequestInterval.length+"==#########$$$$$$$$$$$  ===GetNewGroupPostsRequest----------------" + postdt + "----" + client.id + "===postDt===" + postdt + "====json object===" + jsonObject);
            var gPage = job.uniquekey;
            newPostTime = parseInt(job.storiesTime);            
            if (job.PF2 === 1) {                
                clearInterval(clientPostInterval[gPage]);
                clientPostInterval[gPage] = setInterval(function() {
                   // console.log("#########$$$$$$$$$$$ In interval ===GetNewGroupPostsRequest----------------" + client.id + "===postDt===" + postdt);
                    //GetNewGroupPostsRequest(g_postDT, userId, userTypeId,type,groupId,client.id,jsonObject);
                    client.emit("getPostDtsFromClient",userId, userTypeId,'',jsonObject,client.id,type,groupId);  
                },newPostTime);
            }
       

    });
        getNewGroupPostsResponse = function(data, socketId) {
            //console.log("getNewGroupPostsResponse--------------------"+socketId); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                    break;
                }
            }
            try{
                if(data != "" && data != 0 && data != 1)
                    socketObj.emit("getNewGroupPostsResponse", data);
            }catch(err){
                //logger.trace("Exception occurred in getNewGroupPostsResponse = "+err);
                logger.error("Exception occurred in getNewGroupPostsResponse = "+err);
            }
        }
      client.on('getLatestGroupPostRequest', function(userId,groupId, userTypeId,type,postAsNetwork,remoteAddress)
    { 
       //console.log("getLatestGroupPostRequest---------------groupId-----"+groupId); 
       clearInterval(clientPostInterval[remoteAddress]);
       getLatestGroupPostRequest(userId,groupId, userTypeId,type,postAsNetwork,client.id);

    });
     getLatestGroupPostResponse = function(data,socketId){          
         var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                    break;
                }
            } 
            try{
                if(data != "" && data != 0 && data != 1)
                    socketObj.emit("getLatestGroupPostResponse",data);
            }catch(err){
                //logger.trace("Exception occurred in getLatestGroupPostResponse = "+err);
                logger.error("Exception occurred in getLatestGroupPostResponse = "+err);
            }
    }
      client.on('getUpdatedStreamPostRequest', function(userId,streamId,userTypeId,pageType)
    { 
       //console.log("getUpdatedStreamPostRequest--------------------"); 
       getUpdatedStreamPostRequest(userId,streamId,userTypeId,pageType,client.id);

    });
        getUpdatedStreamPostResponse = function(data, socketId) {
            //console.log("getUpdatedStreamPostResponse--------------------"); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
               // console.log("------------------" + clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                    break;
                }
            }
            try{
                socketObj.emit("getUpdatedStreamPostResponse", data);
            }catch(err){
                //logger.trace("Exception occurred in getUpdatedStreamPostResponse = "+err);
                logger.error("Exception occurred in getUpdatedStreamPostResponse = "+err);
            }
        }
        
        getUpdatedStreamNewsResponse = function(data, socketId) {
            //console.log("getUpdatedStreamPostResponse--------------------"); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------" + clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                    break;
                }
            }
            try{
                socketObj.emit("getUpdatedStreamNewsResponse", data);
            }catch(err){
                //logger.trace("Exception occurred in getUpdatedStreamNewsResponse = "+err);
                logger.error("Exception occurred in getUpdatedStreamNewsResponse = "+err);
            }
            
        }
        
        client.on('clientRequest4news', function(postids, jsonObject)
        {
            //g_postIds = postids;
            var job = JSON.parse(jsonObject);
            var gPage;
            //console.log(clientRequestInterval.length+"===\n\n############IN clientRequest4news#########PostIds=======hitted  from host===" + job.uniquekey + "===json==" + jsonObject);
            var intervalTime = parseInt(job.sCountTime);
            if (job.PF1 == 1) {
                gPage = job.uniquekey;
                connections++;
                if(connections <= maxconnections){
                    clearInterval(clientRequestInterval[gPage]);
                    clientRequestInterval[gPage] = setInterval(function() {
                       // console.log("\n\n\n\n############IN interval clientRequest4news#########PostIds====");
    //                    clientRequest4news(g_postIds, client.id, jsonObject);
                         client.emit('getPostIdsFromClient',jsonObject,client.id);

                    }, intervalTime);
                }
            }


        });
        serverResponse4news = function(data, socketId,jsonObject) {
          //  console.log("serverResponse4news--------------------");
            // console.log("projectSearchResponse--------------------"+socketId); 
            var job = JSON.parse(jsonObject);
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
//             console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
            try{
                if(data != "" && data != 0 && data != 1)
                socketObj.emit("serverResponse4news", data);
            }catch(er){
                killAllIntervals(job.uniquekey);
                 //logger.trace("==serverResponse4news===Exception Occurred=== in emit====="+er);
                 logger.error("==serverResponse4news===Exception Occurred=== in emit====="+er);
            }

        }
    
     client.on('clientRequest4Game', function(postids,jsonObject)
     { 
        //g_postIds = postids;
       // console.log("\n\nclientRequest4Game--------------------");

        if(jsonObject != "undefined" && jsonObject != ""){
            var job = JSON.parse(jsonObject);
            var gPage = job.uniquekey;
         
            var intervalTime = parseInt(job.sCountTime);
            if (job.PF1 == 1) {
                connections++;
                if(connections <= maxconnections){
                    clearInterval(clientRequestInterval[gPage]);
                    clientRequestInterval[gPage] = setInterval(function() {
                        client.emit('getPostIdsFromClient',jsonObject,client.id);                
        //                clientRequest4games(postIds, socketId,jsonObject);
                    },intervalTime);
                }
             }
        }

        
    });
    serverResponse4games = function(data,socketId,jsonObject){
        //  console.log("serverResponse4games--------------------"); 
          // console.log("projectSearchResponse--------------------"+socketId); 
         var  job = JSON.parse(jsonObject);
          var socketObj;
          var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
//             console.log("------------------"+clients[i].id);
              if(clients[i].id == socketId){
                socketObj =  clients[i]; 
              }
            }
            try{
                if(data != "" && data != 0 && data != 1 && data != 'null')
                socketObj.emit("serverResponse4Game",data);
            }catch(er){
                killAllIntervals(job.uniquekey);
                 //logger.trace("==serverResponse4games===Exception Occurred=== in emit====="+er);
                 logger.error("==serverResponse4games===Exception Occurred=== in emit====="+er);
            }
 
    }
     getTopicsRes = function(data,socketId,jsonObject){
        
           
           var  job = JSON.parse(jsonObject);
          var socketObj;
          var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
           
              if(clients[i].id == socketId){
                socketObj =  clients[i]; 
              }
            }
            try{
                if(data != "" && data != 0 && data != 1 && data != 'null')
		{
  
                    socketObj.emit("getTopicsRes",data);
		}
            }catch(er){
                killAllIntervals(job.uniquekey);
               //logger.trace("====Exception occurred in topicresponse====="+er);
               logger.error("====Exception occurred in topicresponse====="+er);
               
            }
 
    }
    client.on('clearInterval',function(uniquekey){ 
       // console.log("===1111111111111111111111=========clearInterval===called========="+uniquekey);
        killAllIntervals(uniquekey);
        
    });
    /*Stream End*/
    /*Notification Start*/
     client.on('getUnreadNotifications', function(userId,jsonObject,requestType)
    { 
//        getUnreadNotifications(userId,client.id);
       
       if(jsonObject != "" &&jsonObject != "undefined" && requestType == "sSetInterval"){
       var job = JSON.parse(jsonObject);
        var gPage = job.uniquekey;
        var intervalTime = parseInt(job.notTime);
       
        if (job.PF4 == 1) {
            connections++;
                if(connections <= maxconnections){
                clearInterval(clientNotificationInterval[gPage]);
                clientNotificationInterval[gPage] = setInterval(function() {
                    getUnreadNotifications(userId,client.id,jsonObject);
                    
                },intervalTime);
            }
        }
    }else if(requestType == "clearInterval"){
        var job = JSON.parse(jsonObject);
        var gPage = job.uniquekey;
        clearInterval(clientNotificationInterval[gPage]);
    }else{
      
          getUnreadNotifications(userId,client.id,jsonObject);
    }
       

    });
        getUnreadNotificationsRes = function(data, socketId,jsonObject) {
            //console.log("getUnreadNotificationsRes--------------------"); 
            var  job = "";
            if(jsonObject != "" &&jsonObject != "undefined"){
                job = JSON.parse(jsonObject);
            }
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
               // console.log("------------------" + clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
            try{
                socketObj.emit("getUnreadNotificationsRes", data);
            }catch(err){
                if(job != "")
                    killAllIntervals(job.uniquekey);
                 //logger.trace("===Exception occurred while sending response to a client===="+err);
                 logger.error("===Exception occurred while sending response to a client===="+err);
            }

        }
     client.on('getAllNotificationByUserId', function(userId,page)
    { 
       //console.log("getAllNotificationByUserId--------------------"); 
       getAllNotificationByUserId(userId,page,client.id);

    });
    
     
        getAllNotificationByUserIdResponse = function(data, socketId) {
            //console.log("getAllNotificationByUserIdResponse--------------------"); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
               // console.log("------------------" + clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
            try{
                socketObj.emit("getAllNotificationByUserIdResponse", data);
            }catch(err){                
                 //logger.trace("Exception occurred getAllNotificationByUserIdResponse="+err);
                 logger.error("Exception occurred getAllNotificationByUserIdResponse="+err);
            }

        }
        
        
        
        
        
        client.on('notificationsInterval',function(remoteAddress){
            clearInterval(clientNotificationInterval[remoteAddress+"Notifications"]);
        });
        
        
        
      client.on('getTopicsRequest', function(topicIds,userId,jsonObject)
    { 
      
//       getTopicsRequest(topicIds,userId,client.id);
       
        if(jsonObject != "" &&jsonObject != "undefined"){
            var job = JSON.parse(jsonObject);
            var gPage = job.uniquekey;
            var intervalTime = parseInt(job.notTime);
            if(connections <= maxconnections){                
                 if (job.PF5 == 1) {                     
                     clearInterval(clientTopicsInterval[gPage]);
                     clientTopicsInterval[gPage] = setInterval(function() {                         
//                         getUnreadNotifications(userId,client.id,jsonObject);
                         getTopicsRequest(topicIds,userId,client.id,jsonObject);

                     },intervalTime);
                 }
             }
        }

    });
     
        
        client.on('getBadgesUnlocked', function(obj,jsonObject)
     { 
        //g_postIds = postids;
        var job = JSON.parse(jsonObject);
        var gPage = job.uniquekey;

        var intervalTime = parseInt(job.sCountTime);
        if (job.PF3 == 1) {
            if(connections <= maxconnections){
                clearInterval(clientBadgeInterval[gPage]);
                clientBadgeInterval[gPage] = setInterval(function() {
                 //   client.emit('getPostIdsFromClient',jsonObject,client.id); 
                    getBadgesUnlocked(obj,jsonObject,client.id);
    //                clientRequest4games(postIds, socketId,jsonObject);
                },intervalTime);
            }
         }
        
    });
    
    getBadgesUnlockedRes = function(data, jsonObject, socketId) {
           // console.log("getBadgesUnlockedRes------final--------------"); 
            var  job = JSON.parse(jsonObject);
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
               // console.log("------------------" + clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
            try{
                if(data != "" && data != 0 && data != 1)
                    socketObj.emit("getBadgesUnlockedRes", data);
                }catch(er){
                    killAllIntervals(job.uniquekey);                    
                    //logger.trace("Exception Occurred=== getBadgesUnlockedRes==="+er);
                    logger.error("Exception Occurred=== getBadgesUnlockedRes==="+er);
                }
            

        }
        
    /*Notification End*/
    
    
    /*Chat Start*/
    
     client.on('getUserId', function(userId)
    { 
     //  console.log("getUserId--------------------**"+userId+"---"+mjmChatUserSockets[userId]); 
      // getUserId(userId);
      //mjmChatUserSockets[userId] = client;

        if (mjmChatUserSockets[userId] != null || mjmChatUserSockets[userId] != undefined) {
           
            var array = mjmChatUserSockets[userId];
            array.push(client);
             mjmChatUserSockets[userId] = array;
        }else{
             
              mjmChatUserSockets[userId] = new Array(client);
        }
  
       // console.log("afeter getUserId--------------------**"+ mjmChatUserSockets[userId].toString()); 
         client.broadcast.emit('imOnLine', userId);
    });
   
        client.on('mjmChatAddUser', function(userId, recieverId, room, profilePicture, callback)
        {
            
            // mjmChatAddUser(userId, recieverId, room, profilePicture, callback);
            //console.log("add user userid-------------" + userId + "--" + recieverId + "---" + room);
            var clientReciever = mjmChatUserSockets[recieverId];
              if (clientReciever != null || clientReciever != undefined) {
                              console.log(clientReciever.length+"--ccc--------------------"+clientReciever.id); 

              }
            // Convert special characters to HTML entities
            userId = htmlEntities(userId);
            recieverId = htmlEntities(recieverId);
            room = htmlEntities(room);

            client.userId = userId;
            client.profilePicture = profilePicture;
            client.room = room;

            client.join(room);
            if (clientReciever != null || clientReciever != undefined) {
                 //logger.trace("clientreciever---------------"+clientReciever.length);
                 try{
              for (var i in clientReciever) {
                 
                 console.log(clientReciever[i]+"--for---"+clientReciever[i].id);
                clientReciever[i].userId = recieverId;
                clientReciever[i].room = room;
            //logger.trace("clientReciever join room");
               clientReciever[i].join(room);
                 }
             }catch(err){
                 //logger.trace("error---"+err);
                 logger.error("error---"+err);
             }
                // callback("online", recieverId);
                client.emit('mjmChatAddUserResponse', "online", recieverId);
                
            } else {
                // callback("offline", recieverId);
                client.emit('mjmChatAddUserResponse', "offline", recieverId);
            }

        });
//     mjmChatAddUserResponse = function(status, offlineUserId){
//          //console.log("mjmChatAddUserResponse--------------------"+status+"---"+offlineUserId); 
//           client.emit("mjmChatAddUserResponse",status, offlineUserId);
// 
//    }
     client.on('getUserFriends', function(userId, searchText,startLimit,pageLength,callback)
    { 
       //console.log("getUserFriends--------------------"); 
       getUserFriends(userId, searchText,startLimit,pageLength,callback,client.id);

    });
        getUserFriendsResponse = function(data, socketId) {
            //console.log("getUserFriendsResponse--------------------"); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }

            socketObj.emit("getUserFriendsResponse", data);
        };
          client.on('searchUsers', function(userId, searchText,startLimit,pageLength,callback)
    { 
       //console.log("getUserFriends--------------------"); 
       searchUsers(userId, searchText,startLimit,pageLength,callback,client.id);

    });
        searchUsersResponse = function(data, socketId) {            
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }

                socketObj.emit("searchUsersResponse", data);
        };
        client.on('mjmChatMessage', function(data, room,displayName)
        {
          //  console.log("mjmChatMessage--------------------"+client.id); 
            //mjmChatMessage(data, room);
            data = nl2br(htmlEntities(data));
//           for (var i in mjmChatUserSockets[userId]) {
//              console.log("for---"+mjmChatUserSockets[userId][i].id);
//             }
            var roomArray = room.split("-");
            if (roomArray[1] == client.userId) {                
                var socketArray = mjmChatUserSockets[roomArray[2]];
            } else {                
                var socketArray = mjmChatUserSockets[roomArray[1]];
            } 
            if (socketArray != null && socketArray != undefined) {
                 for (var i in socketArray) {
               //  console.log("socktet array id----"+socketArray[i]);
                 socketArray[i].room = room;
                 socketArray[i].join(room);
            }

            }

            // io.sockets.socket(socket.id).emit('mjmChatMessage', client.userId, client.profilePicture, data);
            client.broadcast.to(room).emit('mjmChatMessage', client.userId, client.profilePicture, data,displayName,room);

        });
        client.on('typingStatus', function(roomName, displayName, messageReceiverId, flag)
        {
            
            //logger.trace(client.id+"====typingStatus-------------"+roomName+"--------------"+flag+"----"+displayName+"--"+messageReceiverId);
            //typingStatus(roomName, displayName,messageReceiverId, flag);
            client.broadcast.to(roomName).emit('typingStatus', displayName, messageReceiverId, flag);

        });
        client.on('checkStatusOfUser', function(userId)
        {
            //console.log("checkStatusOfUser--------------------"); 
            checkStatusOfUser(userId, client.id);

        });
        checkStatusOfUserResponse = function(response, socketId) {
            //console.log("checkStatusOfUserResponse--------------------"); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                //console.log("------------------"+clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
            socketObj.emit("checkStatusOfUserResponse", response);
        };
     client.on('logout', function(userId)
    {       
        var newArray = new Array();
             for (var i in mjmChatUserSockets[userId]) {
               if(client.id == mjmChatUserSockets[userId][i].id){;
                  //logger.trace("ifffffffffffffffff");
               }else{
                   newArray.push(mjmChatUserSockets[userId][i]);
                   
               }
              }
               mjmChatUserSockets[userId] = newArray;  
//               for (var i in mjmChatUserSockets[userId]) {
//                 console.log(userId+"----after log out---"+mjmChatUserSockets[userId][i].id);
//               }
              
                if(mjmChatUserSockets[userId].length == 0){
                    delete mjmChatUserSockets[userId];
         client.broadcast.emit('imOffLine', userId);
                }
    //   delete mjmChatUserSockets[userId];
      //   client.broadcast.emit('imOffLine', userId);

    });
     client.on('disconnect', function()
    {  
        //logger.trace("===disconnected id=------"+client.id);
        // console.log('before---'+Object.keys(mjmChatUserSockets));
         var surveyClients = clientSurveyArray[client.userId];
           var newArray = new Array();
          for (var i in surveyClients) {
            //  console.log("surveyClients--before----"+surveyClients[i].id);
              if(client.id == surveyClients[i].id){
                   // console.log("disconeet iffffff---"+surveyClients[i].id);  
                  }else if( surveyClients[i].id != undefined && surveyClients[i].id!=null){
                      //console.log("disconeet elseeeeeeeeeeeee---"+surveyClients[i].id);  
                     newArray.push(surveyClients[i]); 
                  }
                  clientSurveyArray[client.userId] = newArray;
          }
         
         for (var i in mjmChatUserSockets) {
              var newArray = new Array();
             for(var j in mjmChatUserSockets[i]){
                  if(client.id == mjmChatUserSockets[i][j].id){
                   // console.log("disconeet iffffff");  
                  }else if( mjmChatUserSockets[i][j].id != undefined && mjmChatUserSockets[i][j].id!=null){
                     // console.log("disconeet elseeeeeeeeeeeee");  
                     newArray.push(mjmChatUserSockets[i][j]); 
                  }
             }
             if(newArray.length==0){
                  delete mjmChatUserSockets[i];
             }else{
             mjmChatUserSockets[i] = newArray;
         }
         }
      
       //  console.log('after----'+Object.keys(mjmChatUserSockets));
     
        
    // delete mjmChatUserSockets[client.userId];
    });
      client.on('getOfflineMessages', function(loginUserId, callback)
    { 
       
       getOfflineMessages(loginUserId, callback,client.id);

    });
     getOfflineMessagesResponse = function(data,socketId){
         //console.log("getOfflineMessagesResponse--------------------"); 
          var socketObj;
         var clients = io.sockets.sockets;
for (var i = 0; i < clients.length; i++) {
 //console.log("------------------"+clients[i].id);
  if(clients[i].id == socketId){
    socketObj =  clients[i]; 
  }
}
         socketObj.emit("getOfflineMessagesResponse",data);
    };
    client.on('loadMoreChatUsers',function(startLimit,userId,searchText){
        
        loadMoreChatUsers(startLimit,userId, searchText,client.id);
    });
    loadMoreChatUsersResponse = function(data,socketId){
         
        var socketObj;
        var clients = io.sockets.sockets;
        for (var i = 0; i < clients.length; i++) {
         //console.log("------------------"+clients[i].id);
          if(clients[i].id == socketId){
            socketObj =  clients[i]; 
          }
        }
         socketObj.emit("loadMoreChatUsersResponse",data);
    };
      /*Chat End*/
      
   client.on('getPostIdsFromClientResponse',function(postIds,jsonObject,socketId,gPage){
       //console.log("11111111111111111111111111111111***=###################=getPostIdsFromClientResponse==in the interval=!!!!!!!!!========"+gPage)
          if(gPage == "HomeStream")
                clientRequest(postIds,'',socketId,jsonObject);
          else if(gPage == "CurbStream")
              clientRequest4CurbsidePosts(postIds, socketId, jsonObject);
          else if(gPage == "GroupStream" || gPage == "SubGroup"){
              clientRequest4GroupPost(postIds,socketId,jsonObject);
          }
           else if(gPage == "News")
               clientRequest4news(postIds, socketId, jsonObject);
           else if(gPage == "Game")
               clientRequest4games(postIds, socketId,jsonObject);
      }); 
      
      client.on("getPostDtsFromClientResponse",function(postDT,userId, userTypeId,postAsNetwork,jsonObject,socketId,gPage,type,groupId){
        //console.log("2222222222222222222222222222222222222#****#######getPostDtsFromClientResponse####interval#########postDT===="+postDT);
         if(gPage == "HomeStream")
                getNewPostsRequest(postDT, userId, userTypeId,postAsNetwork,socketId,jsonObject);            
          else if(gPage == "CurbStream")
              getNewCurbsidePostsRequest(postDT, userId, userTypeId, socketId, jsonObject);
          else if(gPage == "GroupStream" || gPage == "SubGroup"){
              //console.log("3333333333333333333333333333333333########getPostDtsFromClientResponse####interval#########in group/subgroup==type=="+type+"=groupId="+groupId);
              GetNewGroupPostsRequest(postDT, userId, userTypeId,type,groupId,client.id,jsonObject);
          }
          
    });
    /** for mobile **/
    
     client.on('getMobileLatestPost', function(postdt, userId, userTypeId,postAsNetwork)
    { 
        console.log("getMobileLatestPost");
       getMobileLatestPost(postdt, userId, userTypeId,postAsNetwork,client.id);

    });
     getMobileLatestPostResponse = function(data,socketId){
      //console.log("getMobileLatestPostResponse--------------------"+socketId); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
               // console.log("------------------" + clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
             if(data!="" && data!=0){
                socketObj.emit("getMobileLatestPostResponse", data); 
            }
          
 }
  client.on('getMobileLatestGroupPost', function(postdt, userId,groupId,userTypeId,postAsNetwork)
    { 
        
       getMobileLatestGroupPost(postdt, userId,groupId,userTypeId,postAsNetwork,client.id);

    });
     getMobileLatestGroupPostResponse = function(data,socketId){       
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                console.log("------------------" + clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
             if(data!="" && data!=0){
                socketObj.emit("getMobileLatestPostResponse", data); 
            }
          
 }
    
 client.on('getMobileLatestCurbPost', function(postdt, userId, userTypeId,postAsNetwork)
    { 
      //  console.log("getMobileLatestCurbPost");
       getMobileLatestCurbPost(postdt, userId, userTypeId,postAsNetwork,client.id);

    });
     getMobileLatestCurbPostResponse = function(data,socketId){
    //  console.log("getMobileLatestCurbPostResponse--------------------"+socketId); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                console.log("------------------" + clients[i].id);
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
            if(data!="" && data!=0){
               socketObj.emit("getMobileLatestPostResponse", data);  
            }
           
 }
   client.on('getMobileLatestNews', function(postdt, userId, userTypeId,postAsNetwork)
    { 
      //  console.log("getMobileLatestNews");
       getMobileLatestNews(postdt, userId, userTypeId,postAsNetwork,client.id);

    });
     getMobileLatestNewsResponse = function(data,socketId){
    //  console.log("getMobileLatestNewsResponse--------------------"+socketId); 
            var socketObj;
            var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
                
                if (clients[i].id == socketId) {
                    socketObj = clients[i];
                }
            }
            if(data!="" && data!=0){
               socketObj.emit("getMobileLatestPostResponse", data);  
            }
           
 }
    
    client.on('getMobileNewStoriesRequest', function(postdt, userId, userTypeId,postAsNetwork,jObject)
    { 
        var jobj = JSON.parse(jObject);
        var gPage = jobj.uniquekey;
        
      //  if(jobj.PF2 == 1){
           if(connections <= maxconnections){
                clearInterval(clientPostInterval[gPage]);
                clientPostInterval[gPage] = setInterval(function(){  
                    
                    client.emit("getMobileStoryDtsFromClient",userId, userTypeId,postAsNetwork,jObject,client.id);
                    //getNewPostsRequest(g_postDT, userId, userTypeId,postAsNetwork,client.id,jObject);
                },jobj.storiesTime);
            }
       // }
       

});
        client.on('saveImpressionsRequest', function(userId,obj, type)
        { 
           saveImpressionsRequest(userId,obj, type,client.id);

        });
     getNewPostsResponse = function(data,socketId,jsonObject){
        //  console.log("getNewPostsResponse--------------------"+socketId); 
//           console.log("getNewPostsResponse=====Data=!!!!!!!!!!!!!!!!!!!========"+data);
         var job = JSON.parse(jsonObject);
         var socketObj;
         var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
             
              if(clients[i].id == socketId){
                socketObj =  clients[i]; 
              }
            }
        // console.log("getNewPostsResponse--------------------"+ io.sockets.sockets[socketId]); 
        try{
            if(data != "" && data != 0 && data != 1)
               socketObj.emit("getNewPostsResponse",data);
        }catch(er){
                killAllIntervals(job.uniquekey);
                //logger.trace("==getNewPostsResponse===Exception Occurred=== in emit====="+er);
                logger.error("==getNewPostsResponse===Exception Occurred=== in emit====="+er);
        }

    }
          client.on("getMobilePostDtsFromClientResponse",function(postDT,userId, userTypeId,postAsNetwork,jsonObject,socketId,gPage,type,groupId){
        console.log("getMobilePostDtsFromClientResponse--"+gPage);
         //if(gPage == "stream")
                getMobileNewStoriesRequest(postDT, userId, userTypeId,postAsNetwork,socketId,jsonObject);            
//          else if(gPage == "curbside")
//              getNewCurbsidePostsRequest(postDT, userId, userTypeId, socketId, jsonObject);
//          else if(gPage == "GroupStream" || gPage == "SubGroup"){
//              //console.log("3333333333333333333333333333333333########getPostDtsFromClientResponse####interval#########in group/subgroup==type=="+type+"=groupId="+groupId);
//              GetNewGroupPostsRequest(postDT, userId, userTypeId,type,groupId,client.id,jsonObject);
//          }

    });
      
     getMobileNewStoriesResponse = function(data,socketId,jsonObject){
          //console.log("getMobileNewStoriesResponse--------------------"+socketId); 
//           console.log("getMobileNewStoriesResponse=====Data=!!!!!!!!!!!!!!!!!!!========"+data);
         var job = JSON.parse(jsonObject);
         var socketObj;
         var clients = io.sockets.sockets;
            for (var i = 0; i < clients.length; i++) {
             //console.log("------------------"+clients[i].id);
              if(clients[i].id == socketId){
                socketObj =  clients[i]; 
              }
            }
        // console.log("getNewPostsResponse--------------------"+ io.sockets.sockets[socketId]); 
        try{
            if(data != "" && data != 0 && data != 1){                   
                   socketObj.emit("getMobileNewStoriesResponse",data);
            }             
            
        }catch(er){
                killAllIntervals(job.uniquekey);
               //logger.trace("==getMobileNewStoriesResponse===Exception Occurred=== in emit====="+er);
               logger.error("==getMobileNewStoriesResponse===Exception Occurred=== in emit====="+er);
        }
 
    }
    client.on('getPictocvImages', function(userId,jsonObject,requestType)
    { logger.trace("==getPictocvImages==");
if(jsonObject != "" &&jsonObject != "undefined" && requestType == "sSetInterval"){
            var job = JSON.parse(jsonObject);
              var gPage = job.uniquekey;
             var intervalTime = parseInt(job.pictocvTime);
                 connections++;
                 if(connections <= maxconnections){
                     clearInterval(clientPictocvInterval[gPage]);
                     clientPictocvInterval[gPage] = setInterval(function() {
                         getPictocvImages(userId,client.id,jsonObject);

                     },intervalTime);
                 }
         }
    });
    getPictocvImagesRes = function(data, socketId,jsonObject) {
        var  job = "";
        if(jsonObject != "" &&jsonObject != "undefined"){
            job = JSON.parse(jsonObject);
        }
        var socketObj;
        var clients = io.sockets.sockets;
        for (var i = 0; i < clients.length; i++) {
           // console.log("------------------" + clients[i].id);
            if (clients[i].id == socketId) {
                socketObj = clients[i];
            }
        }
        try{
if(data != "" && data != 0){
            socketObj.emit("getPictocvImagesRes", data);
}
        }catch(err){
            if(job != "")
                killAllIntervals(job.uniquekey);
             //logger.trace("===Exception occurred while sending response to a client===="+err);
             logger.error("===Exception occurred getPictocvImagesRes===="+err);
        }

    }
        client.on('getPictocvObjectByOppertunity', function(userId, opportunityType,partialViewPath,jsonObject, requestType)
       {
        if(jsonObject != "" &&jsonObject != "undefined" && requestType == "sSetInterval"){
            var job = JSON.parse(jsonObject);
              var gPage = job.uniquekey;
             var intervalTime = parseInt(job.pictocvTime);
                 connections++;
                 if(connections <= maxconnections){
                     clearInterval(clientPictocvInterval[gPage]);
                     clientPictocvInterval[gPage] = setInterval(function() {
                        getPictocvObjectByOppertunity(userId, opportunityType ,partialViewPath, client.id,jsonObject);
                     },intervalTime);
                 }
         }
       
    });
    getPictocvObjectByOppertunityRes = function(data, socketId,jsonObject) {
     var  job = "";
        if(jsonObject != "" &&jsonObject != "undefined"){
            job = JSON.parse(jsonObject);
        }
        var socketObj;
        var clients = io.sockets.sockets;
        for (var i = 0; i < clients.length; i++) {
           // console.log("------------------" + clients[i].id);
            if (clients[i].id == socketId) {
                socketObj = clients[i];
            }
        }
        try{
if(data != "" && data != 0){
            socketObj.emit("getPictocvObjectByOppertunityRes", data);
}
        }catch(err){
            if(job != "")
                killAllIntervals(job.uniquekey);
             //logger.trace("===Exception occurred while sending response to a client===="+err);
             logger.error("===Exception occurred getPictocvImagesRes===="+err);
        }
    }
});



function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
function nl2br(str, is_xhtml)
{
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function killAllIntervals(uniquekey){
    
    if(connections > 1) connections--;
    logger.error("Kill all Intervals =====for the unique user==="+uniquekey+"===connections==="+connections);
    //logger.trace("====total connections ===="+connections);    
    //logger.error("====total connections ===="+connections);
  clearInterval(clientBadgeInterval[uniquekey]);
    clearInterval(clientRequestInterval[uniquekey]);
    clearInterval(clientPostInterval[uniquekey]);
    clearInterval(clientNotificationInterval[uniquekey]);
    clearInterval(clientTopicsInterval[uniquekey]);
    clearInterval(clientPictocvInterval[uniquekey]);
}
function removeFromArray(array,search_term){      

    for (var i=array.length-1; i>=0; i--) {   
   if (array[i] == search_term) {  //alert('if');       
       array.splice(i, 1);
    return array;
   }

 
}  
  return array; 
 }

}catch(err){
   //console.log("=====error ===="+err); 
}
