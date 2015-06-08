<?php 
class LogDb extends CDbLogRoute
{
 
    protected function createLogTable($db,$tableName)
    {
        $db->createCommand()->createTable($tableName, array(
            'id'=>'pk',
            'level'=>'varchar(128)',
            'category'=>'varchar(128)',
            'logtime'=>'timestamp', 
            'IP_User'=>'varchar(50)', //For IP 
            'user_name'=>'varchar(50)',
            'request_URL'=>'text',
            'title'=>'text',
            'message'=>'text',
        ));
    }
    protected function processLogs($logs)
    {
       try{
        $command=$this->getDbConnection()->createCommand();
        $logTime=date('Y-m-d H:i:s'); //Get Current Date
        $networkName = Yii::app()->params['NetworkName'];
        foreach($logs as $log)
        {
            // error_log($log[2]."--process lgos-------------".$log[0]);
            if($log[2] == "php"){
            $url =  Yii::app()->request->url;
            $actionArray = explode("?", $url);
            $actionString = $actionArray[0];
            $actionStringArray = explode("/", $actionString);
            $controller = $actionStringArray[1]."Controller";
            $action = "action".ucfirst($actionStringArray[2]);
            $messageArray = explode("Stack trace", $log[0]);
            $title = "Exception in ".$controller.":".$action;
            $message = $log[0];   
            }else if($log[2] == "application"){
            $messageArray = explode("::", $log[0]);;
            $title = "Exception in ".$messageArray[0];
            $message = $log[0]; 
            }else{
               //http exception here
               $url =  Yii::app()->request->url;
               error_log($url);
               if(preg_match("/Unable to resolve the request/",$log[0] )){
                  $message = $url; 
               }else{
                  $message = $log[0];   
               }
               $title = "Exception Unable to resolve the request";
                
            }
            $command->insert($this->logTableName,array(
                'level'=>$log[1],
                'category'=>$log[2],
                'logtime'=>$logTime,
                'IP_User'=> Yii::app()->request->userHostAddress, //Get Ip 
                'user_name'=>Yii::app()->user->name , //Get name
                'request_URL'=>Yii::app()->request->url, // Get Url
                'title'=>trim(preg_replace('/\s+/', ' ', $title)),
                'message'=>$networkName."->".trim(preg_replace('/\s+/', ' ', $message)),
            ));
        }   
       } catch (Exception $ex) {
           error_log("Exception in processLogs---------".$ex->getMessage());
       }
  
    }
 
}
?>