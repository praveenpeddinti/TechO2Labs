<?php

/*
 * Developer Suresh Reddy
 * on 8 th Jan 2014
 * all users actions need to add here
 */

class RestDSNController extends Controller {

      public function init() {
      
      }
 
public function actionGetDSNUsers(){
    try{
        
        
        if(isset($_REQUEST['NetworkName'])){
            $NetworkName = $_REQUEST['NetworkName'];
            $usersList= ServiceFactory::getSkiptaUserServiceInstance()->getAllActiveUserInfoByNetworkName($NetworkName);
             if(sizeof($usersList)>0)
            { 
                $obj = array("status" => "success", "data" => array("Response"=>$usersList));
                    
            }
            else
            {
                $obj = array('status' => 'failure', 'data' => array("Response"=>array()), 'error' => ''); 
            }
        }
        
               
        echo json_encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("RestDSNController:actionGetDSNUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
}
public function actionGetDSNCommonNotifications(){
    try{
        
        
        if(isset($_REQUEST['NetworkName'])){
            $NetworkName = $_REQUEST['NetworkName'];
           $commonNotifications=  ServiceFactory::getSkiptaUserServiceInstance()->getDSNCommonNotificationCollectionByCriteria($NetworkName,'');
                    if(sizeof($commonNotifications)>0)
                    {
                         $obj = array("status" => "success", "data" => array("Response"=>$commonNotifications));
                    }
                     else
                    {
                        $obj = array('status' => 'failure', 'data' => array("Response"=>array()), 'error' => ''); 
                    }
             
        }
        
            
        echo json_encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("RestDSNController:actionGetDSNCommonNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
}

public function actionGetDSNUserNotifications()
{
    try{
        
        
        if(isset($_REQUEST['NetworkName'])){
            $NetworkName = $_REQUEST['NetworkName'];
           $Email=$_REQUEST['Email'];
           $userObj=  User::model()->getUserByType($Email, 'Email');
           if($userObj!='noUser')
           {
           $userNotifications=  ServiceFactory::getSkiptaUserServiceInstance()->getDSNCommonNotificationCollectionByCriteria($NetworkName,$userObj->UserId);
                    if(sizeof($userNotifications)>0)
                    {
                         $obj = array("status" => "success", "data" => array("Response"=>$userNotifications));
                    }
                     else
                    {
                        $obj = array('status' => 'failure', 'data' => array("Response"=>array()), 'error' => ''); 
                    }
           }
            else
                    {
                        $obj = array('status' => 'failure', 'data' => array("Response"=>array()), 'error' => ''); 
                    }
             
        }
        
            
        echo json_encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("RestDSNController:actionGetDSNUserNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}



}

?>