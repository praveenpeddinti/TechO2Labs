<?php

require_once(__DIR__ . '/lib/php-amqplib/amqp.inc');

$connection = new AMQPConnection('10.10.73.103', 5672, 'guest', 'guest');
//$connection = new AMQPConnection('10.10.73.103', 5672, 'guest', 'guest');
$channel = $connection->channel();


$channel->queue_declare('hello', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";



$callback = function($msg) {
$obj=json_decode($msg->body,TRUE);

$feed=array();



if($obj['actionType']==(int)3){
   updateUserDocument(($obj));  
}

// $feed['userId']=$obj['userId'];
// $feed['objectType']=$obj['objectType'];
// $feed['livewellId']=$obj['livewellId'];

 saveUserStream($obj);
 
 distributStreamObj($obj);
 //$feed['object']=$obj['userId'];
  //echo " [x] Received ", $msg->body, "\n";

};

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}


function updateUserDocument($obj){
  $m = new Mongo('10.10.73.103:27018');
$db = $m->selectDB("LiveWell");
//$db->authenticate('admin', 'admin');

//$argv[1]='visit_elb';
$c = $db->selectCollection("UserDocument");
$c->update(array("userId"=>(int)$obj['userId']),array('$push' => array("followedObjects"=>$obj['livewellId']."_".$obj['objectType'])));
$c1 = $db->selectCollection("LiveWellSocialDocument");
$c1->update(array("livewellId"=>(int)$obj['livewellId'],"objectType"=>(int)$obj['objectType']),array('$push' => array("followedUserId"=>(int)$obj['userId'])));

}
function saveUserStream($obj){
$m = new Mongo('10.10.73.103:27018');
$db = $m->selectDB("LiveWell");
//$db->authenticate('admin', 'admin');

//$argv[1]='visit_elb';
$c = $db->selectCollection("UserActivity");


 $c->insert($obj);
}
function distributStreamObj($obj){
$m = new Mongo('10.10.73.103:27018');
$db = $m->selectDB("LiveWell");
$c = $db->selectCollection("UserDocument");

if($obj['actionType']==(int)4 && $obj['objectType']==(int)18 ){
  
  $records=$c->findOne(array("userId" => (int)$obj['livewellId']),array('followed'));    
}else{
$records=$c->findOne(array("userId" => (int)$obj['userId']),array('followed'));  
}
$c = $db->selectCollection("UserStream");
foreach ($records['followed'] as $doc) {
 
  //  echo "followd user id  ".$doc." livewellId ".$obj['livewellId']."  objectType  ".$obj['objectType']."  action type ".$obj['actionType'];

$recordsCount=$c->count(array("userId" => (int)$doc,'livewellId'=>(int)$obj['livewellId'],'objectType'=>(int)$obj['objectType'],'actionType'=>(int)$obj['actionType']));

//echo "______________________".$recordsCount."______________________";

if($recordsCount==0){
 $c->insert(array("userId" => (int)$doc,'livewellId'=>(int)$obj['livewellId'],'objectType'=>(int)$obj['objectType'],'actionType'=>(int)$obj['actionType'],'actors'=>array((int)$obj['userId']),'date'=>date('Y-m-d H:i:s')));
 }else{
 $newdata = array('$set' => array('date' => date('Y-m-d H:i:s')),'$push' => array("actors"=>(int)$obj['userId']));
 $c->update(array('userId' => (int)$doc, 'livewellId' => (int)$obj['livewellId'],objectType=>(int)$obj['objectType'],"actionType" =>(int) $obj['actionType']), $newdata);
 
 }
    

}
$c1 = $db->selectCollection("LiveWellSocialDocument");
$recordsTofollowObj=$c1->findOne(array("livewellId" => (int)$obj['livewellId'],"objectType" => (int)$obj['objectType']),array('followedUserId'));
//echo sizeof($recordsTofollowObj['followedUserId']);
foreach ($recordsTofollowObj['followedUserId'] as $doc) {
 
//echo $doc."******";
$recordsCount=$c->count(array("userId" => (int)$doc,'livewellId'=>$obj['livewellId'],'objectType'=>$obj['objectType'],'actionType'=>$obj['actionType']));


if($recordsCount==0){
 $c->insert(array("userId" => (int)$doc,'livewellId'=>(int)$obj['livewellId'],'objectType'=>(int)$obj['objectType'],'actionType'=>(int)$obj['actionType'],'actors'=>array((int)$obj['userId']),'date'=>date('Y-m-d H:i:s')));
 }else{
 $newdata = array('$set' => array('date' => date('Y-m-d H:i:s')),'$push' => array("actors"=>(int)$obj['userId']));
 $c->update(array('userId' => (int)$doc, 'livewellId' => (int)$obj['livewellId'],objectType=>(int)$obj['objectType'],"actionType" =>(int) $obj['actionType']), $newdata);
 
 }
    
}



}
$channel->close();
$connection->close();

?>
