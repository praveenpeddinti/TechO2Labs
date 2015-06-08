<?php

/*
 * Developer Suresh Reddy
 * on 8 th Jan 2014
 * all users actions need to add here
 */

class RestuserController extends Controller {

      public function init() {
      
      }
 
/**
 * author: suresh Reddy .G
 * actionGetMiniPorfile is used to get user mini profile
 * request an userId
 * returns an user object
 */
public function actionGetMiniProfile(){
    try{
        
        
        if(isset($_REQUEST['userid'])){
            $userid = $_REQUEST['userid'];
            $result = ServiceFactory::getSkiptaUserServiceInstance()->getUserMiniProfile($userid,$_REQUEST['loggedUserId']);
        }
        
        $obj = array('status' => 'success', 'data' => $result, 'error' => '');        
        echo json_encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("RestuserController:actionGetMiniProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
}


/**
 * @author Suresh Reddy.v
 * actionUserFollowUnfollowActions is used for either follow or unfollow actions
 * @param $userid,$type
 * @return type json object
 */
public function actionUserFollowUnfollowActions(){
    try{
        if(isset($_REQUEST['type']) && isset($_REQUEST['userid'])){
            $type = $_REQUEST['type'];
            $followId = $_REQUEST['userid'];
            $userId = $_REQUEST['loggedUserId'];
            if(strtolower(trim($type)) == "follow"){
                $result = ServiceFactory::getSkiptaUserServiceInstance()->followAUser($userId,$followId);
            }else if(strtolower(trim($type)) == "unfollow"){
                $result = ServiceFactory::getSkiptaUserServiceInstance()->unFollowAUser($userId,$followId);
            }
        }else{
//            Yii::log("==actionUserFollowUnfollowActions=else not set=","error","application");
        }
        $obj = array("status"=>$result,"data"=>"","error"=>"");
    } catch (Exception $ex) {
        Yii::log("RestuserController:actionUserFollowUnfollowActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    echo CJSON::encode($obj);
}



 public function actionMobileUnreadNotifications(){   
     try{
      $userId = $_POST['userId'];
        $provider = new EMongoDocumentDataProvider('Notifications',                   
           array(
                'pagination' => FALSE,
                'criteria' => array( 
                   'conditions'=>array(                       
                       'UserId'=>array('==' => (int) $userId),                       
                       'isRead' => array('==' => (int) 0)
                       ),
                   'sort'=>array('CreatedOn'=>EMongoCriteria::SORT_DESC)
                 )
               ));    
            $data = $provider->getData();             
            if($provider->getItemCount() > 0){
                $result = CommonUtility::prepareStringToNotification($data,$userId,1,"mobile");
                $obj = array("data"=>$result,"notificationCount"=>  sizeof( $provider->getData()));                              
            }else{
                $obj = array('status' => 'success', 'data' => 0, 'error' => "");
                }
            echo $this->rendering($obj);
        } catch (Exception $ex) {
        Yii::log("RestuserController:actionMobileUnreadNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    } 
    
    public function actionGetAllNotificationByUserId() {
         try {
            $userId = (int)$_REQUEST['userId'];
            $startLimit = (int)$_REQUEST['startLimit'];
            $pageSize = (int)$_REQUEST['pageSize'];
            $offset = ($startLimit*$pageSize);
//            $provider = new EMongoDocumentDataProvider('Notifications', array(
//                'pagination' => FALSE,
//                'criteria' => array(
//                    'conditions' => array(
//                        'UserId' => array('==' => (int) $userId),   
//                       
//                    ),
//                    'offset'=> $offset,
//                    'limit' => $pageSize,
//                    'sort' => array('isRead'=>EMongoCriteria::SORT_ASC, 'CreatedOn' => EMongoCriteria::SORT_DESC)
//                )
//            ));
            
            
                    
           $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection((int) $userId);
           $date_C = new MongoDate(strtotime(date('Y-m-d')));

            $orCondition = array('$or' => [
                array('UserId' => $tinyUserCollectionObj->UserId, 'SegmentId' => $tinyUserCollectionObj->SegmentId, 'CategoryType' => 3),
                array('UserId' => (int) $tinyUserCollectionObj->UserId, 'CategoryType' => array('$in' => array(1, 2, 4, 5, 6, 8, 9, 10))), 
//                array(
//                        '$and'=>[
//                            array('UserId' => (int) 0, 'CategoryType' => array('$in' => array(20))),
//                            array('$or' => [
//                                array('ExpiryDate' => null),
//                                array('ExpiryDate' => array('$gte' => $date_C))])
//                         ]
//                    )

                ]
            );

            $mongoCriteria = new EMongoCriteria;                      
            $mongoCriteria->isRead('==', 0);
            $mongoCriteria->CategoryType('in', array(1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12));
            $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
            $mongoCriteria->offset($offset);
            $mongoCriteria->limit($pageSize);
            $mongoCriteria->setConditions($orCondition);

            $provider = new EMongoDocumentDataProvider('Notifications', array(
                'pagination' => FALSE,
                'criteria' => $mongoCriteria,
            ));
            $data = $provider->getData();
            
            
            
          
            $obj="";
            $totalCount = $provider->getTotalItemCount();
            if($provider->getTotalItemCount()==0 && $startLimit == 0){
               $stream=0;//No posts
               $obj = array("status"=>"success","data"=>$result,"notificationCount"=>  sizeof($data), "totalCount"=>$totalCount); 
           }else if(sizeof($data) > 0){
                $result = CommonUtility::prepareStringToNotification($data,$userId,1,"mobile");
                $obj = array("status"=>"success","data"=>$result,"notificationCount"=> sizeof($data), "totalCount"=>$totalCount); 
            }else
            {
                $stream=-1;//No more posts
                $obj = array("status"=>"success","data"=>$result,"notificationCount"=> sizeof($data), "totalCount"=>$totalCount); 
            }
            echo $this->rendering($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestuserController->actionGetAllNotificationByUserId==".$ex->getMessage());
            Yii::log("RestuserController:actionGetAllNotificationByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGetUnreadNotifications(){
        try{
            $userId = (int)$_REQUEST['userId'];
//            $provider = new EMongoDocumentDataProvider('Notifications',                   
//           array(
//                'pagination' => FALSE,
//                'criteria' => array( 
//                   'conditions'=>array(                       
//                       'UserId'=>array('==' => (int) $userId),                       
//                       'isRead' => array('==' => (int) 0),
//                      // 'CategoryType' => array('notin' => array(16,20))
//                       ),
//                   'sort'=>array('CreatedOn'=>EMongoCriteria::SORT_DESC)
//                 )
//               ));   
           $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection((int) $userId);
                $date_C = new MongoDate(strtotime(date('Y-m-d')));
      
               
               $orCondition = array(
                '$or' => [
                    array('UserId' => $tinyUserCollectionObj->UserId, 'SegmentId' => array('$in' => array($tinyUserCollectionObj->SegmentId, 0), 'isRead' => 0), 'CategoryType' => array('$in' => array(3, 7))),
                    array('UserId' => (int) $tinyUserCollectionObj->UserId, 'CategoryType' => array('$nin' => array(3, 7, 12,16,20)), 'isRead' => 0),
//                    array(
//                        '$and' => [
//                            array('UserId' => (int) 0, 'CategoryType' => array('$in' => array(20)), 'ReadUsers' => array('$nin' => array((int) $tinyUserCollectionObj->UserId))),
//                            array('$or' => [
//                                    array('ExpiryDate' => null),
//                                    array('ExpiryDate' => array('$gte' => $date_C))])
//                        ]
//                    )
                ],
            );






            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->setConditions($orCondition);
            $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
            $provider = new EMongoDocumentDataProvider('Notifications', array(
                'pagination' => FALSE,
                'criteria' => $mongoCriteria,
               ));   
            $data = $provider->getData();
            
            $unreadCount = $provider->getItemCount();
            $readDataProvider = new EMongoDocumentDataProvider('Notifications',                   
           array(
                'pagination' => FALSE,
                'criteria' => array( 
                   'conditions'=>array(                       
                       'UserId'=>array('==' => (int) $userId),                       
                       'isRead' => array('==' => (int) 0),
                      // 'CategoryType' => array('notin' => array(3,7,16,20))
                       ),
                   'sort'=>array('CreatedOn'=>EMongoCriteria::SORT_DESC)
                 )
               ));  
            $moreCount = $readDataProvider->getTotalItemCount()-$unreadCount;
            $obj = "";
            if( $unreadCount> 0){
                $result = CommonUtility::prepareStringToNotification($data,$userId,1,"mobile");
                $obj = array("status"=>"success","data"=>$result,"unreadNotificationCount"=>  $unreadCount,"moreCount"=>$moreCount); 
            }else{
                $obj = array("status"=>"success","data"=>$result,"unreadNotificationCount"=>  $unreadCount,"moreCount"=>$moreCount); 
            }
            echo $this->rendering($obj);
               
        } catch (Exception $ex) {
             error_log("Exception Occurred in RestuserController->actionGetUnreadNotifications==".$ex->getMessage());
             Yii::log("RestuserController:actionGetUnreadNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUpdateNotificationAsRead() {
        try {
            $result = "failed";
            if (isset($_REQUEST['notificationId']) && strtolower($_REQUEST['notificationId']) != "undefined") {
                $notificationId = $_REQUEST['notificationId'];
                $userId = (int)$_REQUEST['userId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->updateNotificationAsRead($notificationId,$userId);
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
            $obj = $this->rendering($obj);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("RestuserController:actionUpdateNotificationAsRead::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $obj = array("status" => "exception", "data" => $ex->getMessage(), "error" => "");
            echo $this->rendering($obj);
        }
         
    }
    /* This method is used for Custom groups */
    /*
     * Custom methods start...
     */
    public function actionContactUsMailSend(){
        try{
            $name = $_REQUEST['Name'];
            $phone = $_REQUEST['Phone'];
            $email = $_REQUEST['Email'];
            $contactMethod = $_REQUEST['ContactMethod'];
            $from = $_REQUEST['From'];
            $message = "";
//            $subject = $displayname . " has invited you to join " . Yii::app()->params['NetworkName'];
//            $employerName = "Skipta Admin";
//            //$employerEmail = "info@skipta.com"; 
            $subject = $from.' '.Yii::app()->session['TinyUserCollectionObj']->DisplayName;
            $to = $_REQUEST['To'];
            $messageview = "CustomContactUsMailTemplate";
            $params = array('name' => $name,'phone' => $phone , 'email' => $email ,'contactMethod' => $contactMethod , 'message' => $message);
            $sendMailToUser = new CommonUtility;
            $mailSentStatus = $sendMailToUser->actionSendmail($messageview, $params, $subject, $to);
            $obj = array();
            if($mailSentStatus){
                $obj = array("status"=>"success");
            }else{
                $obj = array("status"=>"failed");
            }
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestuserController->actionContactUsMailSend==".$ex->getMessage());
            Yii::log("RestuserController:actionContactUsMailSend::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionGetOpinionSurveyDetails(){
        try{
            $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
            $opinionDetails = ServiceFactory::getSkiptaUserServiceInstance()->getOpinionDetails($userId);
            $obj = array();
            $obj = array("data"=>$opinionDetails,"status"=>"success","LoggedUserId"=>$userId);
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestuserController->actionGetOpinionSurveyDetails==".$ex->getMessage());
            Yii::log("RestuserController:actionGetOpinionSurveyDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionSaveUserOpinion(){
        try{
            $opinionId = $_REQUEST['opinionId'];
            $optionValue = $_REQUEST['optionValue'];
            $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
            $surveryResults = ServiceFactory::getSkiptaUserServiceInstance()->saveOpinionDetails($userId,$opinionId,$optionValue);
            $obj = array("data"=>$surveryResults,"status"=>"success");
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestuserController->actionSaveUserOpinion==".$ex->getMessage());
            Yii::log("RestuserController:actionSaveUserOpinion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionGetSurveyResults(){
        try{
            $opinionId = $_REQUEST['opinionId'];
            $surveryResults = ServiceFactory::getSkiptaUserServiceInstance()->getSurveyResults($opinionId);
            $obj = array("data"=>$surveryResults,"status"=>"success");
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestuserController->actionGetSurveyResults==".$ex->getMessage());
            Yii::log("RestuserController:actionGetSurveyResults::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionCheckPTCMember(){
        try{
            $results = ServiceFactory::getSkiptaUserServiceInstance()->checkPTCMember(Yii::app()->session['Email']);
            $obj = array("size"=>sizeof($results));
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestuserController->actionCheckPTCMember==".$ex->getMessage());
            Yii::log("RestuserController:actionCheckPTCMember::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    

    public function actionGetSurveyMonkeyQuestions(){
        try{            
            $results = ServiceFactory::getSkiptaUserServiceInstance()->getSurveyQuestions();            
            $obj = array("data"=>$results,"status"=>"success");
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestuserController->actionGetSurveyMonkeyQuestions==".$ex->getMessage());
            Yii::log("RestuserController:actionGetSurveyMonkeyQuestions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
 
    public function actionSaveSurveyOpinions(){
        try{   
            
            $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
            $optionId = $_REQUEST['optionValue'];
            $questionId = $_REQUEST['qId'];
            $others = $_REQUEST['otherValue'];
            $rating = $_REQUEST['rating'];
            ServiceFactory::getSkiptaUserServiceInstance()->saveSurveyOpinions($userId,$optionId,$questionId,$others,$rating);            
            $obj = array("data"=>"","status"=>"success");
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestuserController->actionSaveSurveyOpinions==".$ex->getMessage());
            Yii::log("RestuserController:actionSaveSurveyOpinions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionGetMonkeySurveyResults(){
        try{
            $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
            $result = ServiceFactory::getSkiptaUserServiceInstance()->getSurveyOpinionsRes($userId);            
            $obj = array("count"=>$result,"status"=>"success");
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestuserController->actionGetMonkeySurveyResults==".$ex->getMessage());
            Yii::log("RestuserController:actionGetMonkeySurveyResults::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    


   public function actionGetBadgesNotShownToUser() {
        try {          
            $userId = $_REQUEST['userId'];
            $badgeCollection = CommonUtility::getBadgesNotShownToUser($userId, 1);
            $obj = "";
            if (count($badgeCollection) > 0) {
                $badgeInfo = ServiceFactory::getSkiptaUserServiceInstance()->getBadgeInfoById($badgeCollection->BadgeId);
                $obj = array("status" => "success", 'badgingInfo' => $badgeInfo, 'badgeCollectionInfo' => $badgeCollection);
            } else {
                $obj = array("status" => "failure", "data" => "", "error" => "");
            }
            echo CJSON::encode($obj);
             
        } catch (Exception $ex) {
            Yii::log("RestuserController:actionGetBadgesNotShownToUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUpdateBadgeShownToUser() {
        try {
            if (isset($_POST['badgeCollectionId'])) {
                $result = array();
                $result = ServiceFactory::getSkiptaUserServiceInstance()->updateBadgeShownToUser($_POST['badgeCollectionId']);
            }
        } catch (Exception $ex) {
           Yii::log("RestuserController:actionUpdateBadgeShownToUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionSaveStreamSettings() {
        try {
            $userId = $_REQUEST['UserId'];
            $settingIds = $_REQUEST['settingIds'];
            $result = ServiceFactory::getSkiptaUserServiceInstance()->updateUserSettings($userId, $settingIds,1);
//            $result = ServiceFactory::getSkiptaUserServiceInstance()->updateUserSettings($userId, $settingIds);
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("RestuserController:actionSaveStreamSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        echo CJSON::encode($obj);
    } 
    public function actionGetUserStreamSettings() {
        try {
            $userId = $_REQUEST['UserId'];
            $result = ServiceFactory::getSkiptaUserServiceInstance()->getUserSettings($userId);
            $obj = array("data"=>$result,"status"=>"success");
            $obj = $this->rendering($obj);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("RestuserController:actionGetUserStreamSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in RestuserController->actionGetUserStreamSettings==".$ex->getMessage());
        }
    }
  public function actionUpdatePushNotifications(){
      try{
       $result = ServiceFactory::getSkiptaUserServiceInstance()->updatePushNotification($userId);
       if($result == "success"){
          $obj = array("status"=>"success");  
       }else{
            $obj = array("status"=>"failure");
       }
       echo $this->rendering($obj);
       } catch (Exception $ex) {
        Yii::log("RestuserController:actionUpdatePushNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
  }
  public function actionUpdatePushNotificationToken(){
    try{
      $userId = $_REQUEST['userId'];
        $pushToken = $_REQUEST['pushToken'];

        $deviceInfo = $_POST['deviceInfo'];
        $sessionId = ServiceFactory::getSkiptaUserServiceInstance()->saveMobileSession_V6($userId, $deviceInfo, $pushToken);
        $obj = array("status" => "success", "sessionId" => $sessionId);

        echo $this->rendering($obj);
        } catch (Exception $ex) {
        Yii::log("RestuserController:actionUpdatePushNotificationToken::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
public function actionGetAuthProviders(){
    try{
           $returnProvidersData= ServiceFactory::getSkiptaUserServiceInstance()->getAllOauthProviderDetails();
           if($returnProvidersData!="failure" && count($returnProvidersData)>0){
           
            $obj = array("status" => "success", "authProviders" => $returnProvidersData,"serverURL"=>YII::app()->params['ServerURL']);
           }else{
            $obj = array("status" => "error", "authProviders" => "");   
}


        echo $this->rendering($obj);

    } catch (Exception $ex) {
       error_log("Exception Occurred in RestuserController->actionGetAuthProviders==".$ex->getMessage());
        Yii::log("RestuserController:actionGetAuthProviders::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}
}

?>