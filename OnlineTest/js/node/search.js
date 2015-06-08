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
//logger.trace("I m worker----------"+cluster.worker.id);

var fs = require('fs');



var app = require('http').createServer(function(req, res){    
     process.send({ info : 'ReqServMaster' });
})
  , io = require('socket.io').listen(app);

app.listen(config.searchPort);

var spawn = require('child_process').spawn;
var exec = require('child_process').exec;
var child;
var dir=config.dir;

process.on('uncaughtException', function (err) { // handling exceptions here...
//  logger.trace("=====Exception occurred====="+err);
  logger.error("=====Exception occurred====="+err);  
});
io.sockets.on('connection', function(client)
{  
     process.send({ info : 'ReqServMaster' });
    client.on('uncaughtException', function(err) {
        console.log('Caught exception: ' + err);
    });
    
     client.on('projectSearch', function(searchText,offset,pageLength,userSearch,groupsSearch,subGroupsSearch,hastagsSearch,postSearch,loginUserId,curbsideCategory,gameSearch,socketId)
    {  
       child = spawn(dir+"/yiic", ['ncom', 'projectSearch', '--searchText=' + searchText,'--offset=' + offset,'--pageLength=' + pageLength,'--userSearch=' + userSearch,'--groupsSearch=' + groupsSearch,'--subGroupsSearch=' + subGroupsSearch,'--hastagsSearch=' + hastagsSearch,'--postSearch=' + postSearch,'--loginUserId=' + loginUserId, '--curbsideCategory='+curbsideCategory,'--gameSearch='+gameSearch]);
       child.stdout.setEncoding('utf-8');
       child.stdout.on('data', function(data) {
           //console.log(data);
        client.emit('projectSearchResponse', data,socketId);
       });
       child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
       });
    });
 client.on('mobileSearch', function(searchdata,socketId)
    {  //console.log("xxxxxxxxasdasttttttttttttttdasxxxxxx"+searchdata.timezoneName);
       child = spawn(dir+"/yiic", ['ncom', 'mobileSearch', '--searchText=' + searchdata.search,'--offset=' + searchdata.mobileOffset,'--pageLength=' + searchdata.mobilePageLength,'--userSearch=' + searchdata.userSearch,'--loginUserId=' + searchdata.loginUserId, '--isPostExist=' + searchdata.isPostExist,'--isNewsExist=' + searchdata.isNewsExist,'--isGroupsExist=' + searchdata.isGroupsExist,
'--isCurbsideCategoryExist=' + searchdata.isCurbsideCategoryExist,'--timezoneName='+searchdata.timezoneName]);

       child.stdout.setEncoding('utf-8');
       child.stdout.on('data', function(data) {
          // console.log("111111111"); 	
        client.emit('mobileSearchResponse', data,socketId);
       });
       child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
       });
    });
  client.on('getUsersForSearch', function(searchdata,socketId)
    {  //console.log("xxxxgetUsersForSearchxxxxxxxxxx"+searchdata.search+"1111111111"+searchdata.mobileOffset+"2222222222r"+searchdata.mobilePageLength+"33333333r");
       child = spawn(dir+"/yiic", ['ncom', 'getUsersForSearch', '--searchText=' + searchdata.search,'--offset=' + searchdata.mobileOffset,'--pageLength=' + searchdata.mobilePageLength]);
       child.stdout.setEncoding('utf-8');
       child.stdout.on('data', function(data) {
         //  console.log("111111111========sagar========="+data); 	
        client.emit('getUsersForSearchResponse', data,socketId);
       });
       child.stderr.on('data', function(data) {
//           logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
       });
    });
   client.on('saveBrowseDetails', function(sessionObject,address) {
    //    child = spawn(dir+"/yiic", ['track', 'saveBrowseDetails', '--sessionObj=' + sessionObject]);
         child = spawn(dir+"/yiic", ['track', 'saveBrowseDetails', '--sessionObj=' + sessionObject,'--clientIP=' + address]);
       
        child.stderr.on('data', function(data) {
//            logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
        });

    });
      client.on('connectToSurvey', function(loginUserId,scheduleId,socketId,jObject)
    {  
       child = spawn(dir+"/yiic", ['ncom', 'connectToSurvey','--loginUserId=' + loginUserId,'--scheduleId='+scheduleId]);
       child.stdout.setEncoding('utf-8');
        child.stdout.on('data', function(data) {
            if(data!="" && data!=0 && data!=null){
             client.emit('connectToSurveyResponse', data,socketId,jObject);
  
            }
       
       });
       child.stderr.on('data', function(data) {
//        logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
       });
    });
       client.on('unsetSpot', function(loginUserId,scheduleId,socketId)
    {  
       child = spawn(dir+"/yiic", ['ncom', 'unsetSpot','--loginUserId=' + loginUserId,'--scheduleId='+scheduleId]);
       child.stdout.setEncoding('utf-8');
       child.stdout.on('data', function(data) {
         //  console.log('connectToSurveyResponse-----'+data);
       // client.emit('connectToSurveyResponse', data,socketId);
       });
       child.stderr.on('data', function(data) {
//        logger.trace('stderr: ' + data);
            logger.error('stderr: ' + data);
       });
    });
    client.on('trackSearchAchievements', function(obj,socketId)
    {  
       child = spawn(dir+"/yiic", ['track', 'trackSearchAchievements','--obj=' + obj]);
       child.stdout.setEncoding('utf-8');
       child.stdout.on('data', function(data) {
         //  console.log('connectToSurveyResponse-----'+data);
       // client.emit('connectToSurveyResponse', data,socketId);
       });
       child.stderr.on('data', function(data) {
        console.log('stderr: ' + data);
       });
    });
    client.on('disconnect', function(userId)
    {
//        logger.trace('Client disconnected');
        logger.error('Client disconnected ');
        
    });
});
}

