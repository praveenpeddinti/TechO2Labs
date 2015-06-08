<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * @author Vamsi Krishna
 * This class is defined for Notifications Collection .All the user notification's will be present in this collection.
 */
class Notifications extends EMongoDocument {
    public $_id;
    public $UserId;
    public $CreatedOn;    
    public $NotificationNote;
    public $RecentActivity;    
    public $CommentUserId=array();
    public $NewFollowers=array();
    public $PostId;
    public $PostFollowers=array();
    public $Love=array();
    public $PlayedUsers=array();
    public $MentionedUserId=array();
    public $InviteUserId;
    public $CategoryType;
    public $isRead;
    public $PostType;
    public $NotificationNoteTwo;
    public $OriginalUserId;
    public $SegmentId=0;
    public $NetworkId=1;
    public $Language="en";
    public $IsAnonymous=0;
    public $CurbsideCategory="";
    public $Hashtag="";
    public $NotificationType = "";
    public $ExpiryDate;
    public $ReadUsers=array();
        public $RedirectUrl = ""; // this will be used for Admin as well as System generated Notifications only...
    public function getCollectionName() {
        return 'Notifications';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            )
        );
    }
    public function attributeNames() {
        return array(
            '_id'=>'_id',
            'UserId'=>'UserId',
            'CreatedOn'=>'CreatedOn',            
            'NotificationNote'=>'NotificationNote',
            'RecentActivity'=>'RecentActivity',            
            'NetworkId'=>'NetworkId',
            'CommentUserId'=>'CommentUserId',
            'NewFollowers'=>'NewFollowers',
            'PostId'=>'PostId',
            'PostFollowers'=>'PostFollowers',
            'Love'=>'Love',
            'MentionedUserId'=>'MentionedUserId',
            'InviteUserId'=>'InviteUserId',
            'CategoryType'=>'CategoryType',
            'isRead'=>'isRead',
            'PostType'=>'PostType',
            'PlayedUsers'=>'PlayedUsers',
            'NotificationNoteTwo'=> 'NotificationNoteTwo',
            'OriginalUserId'=> 'OriginalUserId',
            'PlayedUsers'=>'PlayedUsers',
            'SegmentId'=>'SegmentId',
            'Language'=>'Language',

            'OriginalUserId'=> 'OriginalUserId',
            'IsAnonymous'=>'IsAnonymous',
            'CurbsideCategory'=>'CurbsideCategory',
            'Hashtag'=>'Hashtag',
            "NotificationType" => "NotificationType",
            "RedirectUrl" => "RedirectUrl",
            'ExpiryDate'=>'ExpiryDate',
            'ReadUsers'=>'ReadUsers',
            

        );
    }
    /**
     * @author Vamsi Krishna 
     * Description This Method is used to save notifications for the user 
     * @param type $notificationsObj
     * @return string
     */
    
  public function saveNotifications($notificationsObj){
      $returnValue='failure';
      try {       
          $notifications=new Notifications();
          $notifications->UserId=$notificationsObj->UserId;
          $notifications->CreatedOn=$notificationsObj->CreatedOn;           
          $notifications->NotificationNote=$notificationsObj->NotificationNote;
          $notifications->RecentActivity=$notificationsObj->RecentActivity;
          if(isset($notificationsObj->CommentUserId) && !empty($notificationsObj->CommentUserId)){
              array_push($notifications->CommentUserId,$notificationsObj->CommentUserId);
          }else{
              $notifications->CommentUserId=array();
          }
          if(isset($notificationsObj->NewFollowers) && !empty($notificationsObj->NewFollowers)){
              array_push($notifications->NewFollowers,$notificationsObj->NewFollowers);
          }else{
              $notifications->NewFollowers=array();
          }
         
          $notifications->PostId=new MongoId($notificationsObj->PostId);
         
           if(isset($notificationsObj->PostFollowers) && !empty($notificationsObj->PostFollowers)){
              array_push($notifications->PostFollowers,$notificationsObj->PostFollowers);
          }else{
              $notifications->PostFollowers=array();
          }
           if(isset($notificationsObj->Love) && !empty($notificationsObj->Love)){
                array_push($notifications->Love,$notificationsObj->Love);
          }else{
              $notifications->Love=array();
          }
       
          
            if ($notificationsObj->MentionedUserId != "" && $notificationsObj->MentionedUserId != null) {
                array_push($notifications->MentionedUserId,$notificationsObj->MentionedUserId);
                   //$notifications->MentionedUserId=$notificationsObj->MentionedUserId;
            }
      
             
                $notifications->InviteUserId = $notificationsObj->InviteUserId;
           
    
          $notifications->CategoryType=(int)$notificationsObj->CategoryType;
          $notifications->NetworkId=(int)$notificationsObj->NetworkId;
          $notifications->isRead=(int)$notificationsObj->isRead;
          $notifications->PostType = (int)$notificationsObj->PostType;
          $notifications->OriginalUserId=$notificationsObj->OriginalUserId;
          $notifications->NotificationNoteTwo=$notificationsObj->NotificationNoteTwo;
          $notifications->SegmentId=(int)$notificationsObj->SegmentId;
          $notifications->Language = $notificationsObj->Language;

           $notifications->IsAnonymous=$notificationsObj->IsAnonymous;
           $notifications->CurbsideCategory=$notificationsObj->CurbsideCategory;
           $notifications->Hashtag=$notificationsObj->Hashtag;
           $notifications->NotificationType = isset($notificationsObj->NotificationType)&&!empty($notificationsObj->NotificationType)?(int) $notificationsObj->NotificationType:(int)3;
           $notifications->RedirectUrl=$notificationsObj->RedirectUrl;
           $notifications->ReadUsers=$notificationsObj->ReadUsers;
           $notifications->ExpiryDate=$notificationsObj->ExpiryDate;
           

          if($notifications->save()){
          $returnValue='success';    
          }
          
        return $returnValue;   
      } catch (Exception $ex) {       
         Yii::log("Notifications:saveNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return $returnValue;
      }
    }
    
  public function getNotificationsForUserWithPost($userId,$postId,$networkId,$categoryType,$recentActivity){
      try {
          
          $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('UserId', '==', (int)$userId);
            $mongoCriteria->addCond('PostId', '==', new MongoId($postId));
//            $mongoCriteria->addCond('NetworkId', '==', (int)$networkId);
            $mongoCriteria->addCond('CategoryType', '==', (int)$categoryType); 
            $mongoCriteria->addCond('RecentActivity', '==', $recentActivity);
            $userNotifications=Notifications::model()->find($mongoCriteria);
            
            if(isset($userNotifications)){
                $returnValue=$userNotifications;
            }
          
            return $returnValue;
      } catch (Exception $ex) {
          Yii::log("Notifications:getNotificationsForUserWithPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    
     public function updateNotificationsForUser($notificationId,$actionType,$notificationObj){
      try { 
      
          $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;            
            $mongoCriteria->addCond('_id', '==', new MongoId($notificationId));
            if($actionType=='Comment'){
             $mongoModifier->addModifier('CommentUserId', 'push', $notificationObj->CommentUserId);    
             $mongoModifier->addModifier('NotificationNote', 'set', $notificationObj->NotificationNote);    
             $mongoModifier->addModifier('RecentActivity', 'set', $notificationObj->RecentActivity); 
             $mongoModifier->addModifier('NotificationNoteTwo', 'set', $notificationObj->NotificationNoteTwo);
            }
            if($actionType=='Love'){
             $mongoModifier->addModifier('Love', 'push', $notificationObj->Love);    
             $mongoModifier->addModifier('NotificationNote', 'set', $notificationObj->NotificationNote);    
             $mongoModifier->addModifier('RecentActivity', 'set', $notificationObj->RecentActivity);
             $mongoModifier->addModifier('NotificationNoteTwo', 'set', $notificationObj->NotificationNoteTwo);
            }
            if($actionType=='Follow'){
             $mongoCriteria->addCond('PostFollowers', '!=', (int) $notificationObj->PostFollowers);
             $mongoModifier->addModifier('PostFollowers', 'push', $notificationObj->PostFollowers);    
             $mongoModifier->addModifier('NotificationNote', 'set', $notificationObj->NotificationNote);    
             $mongoModifier->addModifier('RecentActivity', 'set', $notificationObj->RecentActivity); 
             $mongoModifier->addModifier('NotificationNoteTwo', 'set', $notificationObj->NotificationNoteTwo);
            }
            if($actionType=='UserFollow'){
             $mongoModifier->addModifier('NewFollowers', 'push',(int) $notificationObj->NewFollowers);    
             $mongoModifier->addModifier('NotificationNote', 'set', $notificationObj->NotificationNote);    
             $mongoModifier->addModifier('RecentActivity', 'set', $notificationObj->RecentActivity);
             $mongoModifier->addModifier('NotificationNoteTwo', 'set', $notificationObj->NotificationNoteTwo);
            }
            if($actionType=='mention'){                
            $mongoModifier->addModifier('MentionedUserId','push',(int)$notificationObj->MentionedUserId);
             $mongoModifier->addModifier('NotificationNote', 'set', $notificationObj->NotificationNote);    
             $mongoModifier->addModifier('RecentActivity', 'set', $notificationObj->RecentActivity);    
            }
            if($actionType=='Post'){                
             $mongoModifier->addModifier('OriginalUserId','push',(int)$notificationObj->OriginalUserId);
             $mongoModifier->addModifier('NotificationNote', 'set', $notificationObj->NotificationNote);    
             $mongoModifier->addModifier('RecentActivity', 'set', $notificationObj->RecentActivity); 
             $mongoModifier->addModifier('NotificationNoteTwo', 'set', $notificationObj->NotificationNoteTwo);
             $mongoModifier->addModifier('CurbsideCategory', 'set', $notificationObj->CurbsideCategory);
             $mongoModifier->addModifier('Hashtag', 'set', $notificationObj->Hashtag);
            }
            $mongoModifier->addModifier('CreatedOn', 'set', $notificationObj->CreatedOn);  
              $mongoModifier->addModifier('isRead', 'set', $notificationObj->isRead);
               $mongoModifier->addModifier('IsAnonymous', 'set', $notificationObj->IsAnonymous);
              
            $userNotifications=Notifications::model()->updateAll($mongoModifier, $mongoCriteria);
            if(isset($userNotifications)){
                $returnValue=$userNotifications;
            }
            return $returnValue;
      } catch (Exception $ex) {
         Yii::log("Notifications:updateNotificationsForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    
    public function getUserNotificationForFollower($userId,$recentActivity){
        try {
             $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('UserId', '==', (int)$userId);            
            $mongoCriteria->addCond('RecentActivity', '==', $recentActivity);
            $userNotifications=  Notifications::model()->find($mongoCriteria);
            if(isset($userNotifications)){
                $returnValue=$userNotifications;
            }
            return $returnValue;
        } catch (Exception $ex) {
           Yii::log("Notifications:getUserNotificationForFollower::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    
    }
    /**
     * @author Karteek V
     * @param type $notificationId
     * @return string
     */
    public function updateNotificationAsRead($notificationId,$userId) {
        try {
            $returnValue = 'failure';
            $mongoModifier = new EMongoModifier;
            $mongoCriteria = new EMongoCriteria;
            $notificationObj = $this->getNotificationById($notificationId);
            $mongoCriteria->addCond('_id', '==', new MongoId($notificationId));
            if(isset($notificationObj) && $notificationObj!="failure" && $notificationObj->NotificationType==(int)1){
                if(!in_array((int)$userId, $notificationObj->ReadUsers)){
                   $mongoModifier->addModifier('ReadUsers', 'push', (int)$userId);   
                }
            }
            else{
              $mongoModifier->addModifier('isRead', 'set', (int) 1);
            }
             if (Notifications::model()->updateAll($mongoModifier, $mongoCriteria)) {
                    $returnValue = "success";
                }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("Notifications:updateNotificationAsRead::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function updateAllNotificationsByUserId($userId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('UserId', '==', (int)$userId);
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('isRead', 'set', (int) 1);
            $this->updateAllAdminNotificationsByUserId($userId);
            if(Notifications::model()->updateAll($mongoModifier, $mongoCriteria)){
                 $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
             Yii::log("Notifications:updateAllNotificationsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    } 
    /**
     * 
     * @param type $userId
     * @return string
     */
    
   public function updateAllAdminNotificationsByUserId($userId){
       try{     
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('UserId', '==', (int)0);
            $mongoCriteria->addCond('NotificationType', '==', (int)1);
            $mongoCriteria->addCond('ReadUsers', '!=', (int)$userId);
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('ReadUsers', 'push', (int)$userId); 
            if(Notifications::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
             Yii::log("Notifications:updateAllAdminNotificationsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }    
   }
    
    public function updateNotificationsDelete($obj) {
        try {
             $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('PostId', '==',new MongoId($obj->PostId));
            $mongoCriteria->addCond('CategoryType', '==',(int)$obj->CategoryType);            
            $mongoModifier->addModifier('IsDeleted', 'set', (int)0);
            if(Notifications::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("Notifications:updateNotificationsDelete::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
      
     public function getUserNotificationsByRecentActivity($userId,$recentActivity,$startDate,$endDate){
          $returnValue = 'failure';
        try {
           
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('UserId', '==', (int)$userId);            
            $mongoCriteria->addCond('RecentActivity', '==', $recentActivity);
                $mongoCriteria->addCond('CreatedOn', '>', new MongoDate(strtotime($startDate)));
                $mongoCriteria->addCond('CreatedOn', '<', new MongoDate(strtotime($endDate)));
        //    $mongoCriteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
            $userNotifications=  Notifications::model()->findAll($mongoCriteria);            
            if(isset($userNotifications)){
                $returnValue=$userNotifications;
            }
            return $returnValue;
        } catch (Exception $ex) {  
            Yii::log("Notifications:getUserNotificationsByRecentActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $returnValue = 'failure';
        }
    
    }  
    
     public function getNotificationForPostByActionType($postId,$actionType){
          $returnValue = 'failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('PostId', '==', new MongoId($postId));            
            $mongoCriteria->addCond('RecentActivity', '==', $actionType);
            $object =  Notifications::model()->find($mongoCriteria);            
            if(isset($object)){
               return $object;
            }else{
               return "";  
            }
        } catch (Exception $ex) { 
            Yii::log("Notifications:getNotificationForPostByActionType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $returnValue = 'failure';
        }
    
    }  
    public function getAllNotificationsByRecentActivity($recentActivity){
          $returnValue = 'failure';
        try {
            $mongoCriteria = new EMongoCriteria;       
            $mongoCriteria->addCond('RecentActivity', '==', $recentActivity);
            $userNotifications=  Notifications::model()->findAll($mongoCriteria);            
            if(isset($userNotifications)){
                $returnValue=$userNotifications;
            }
            return $returnValue;
        } catch (Exception $ex) {   
            Yii::log("Notifications:getAllNotificationsByRecentActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $returnValue = 'failure';
        }
    }
    public function updateNotificationWithHashTagOrCurbsideCategory($notificationId, $hashtag="", $curbsideCategory="") {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('_id', '==', new MongoId($notificationId));
            $mongoModifier = new EMongoModifier;
            if($hashtag!=""){
                $mongoModifier->addModifier('Hashtag', 'set', $hashtag);
            }else if($curbsideCategory!=""){
                $mongoModifier->addModifier('CurbsideCategory', 'set', $curbsideCategory);
            }
            if (Notifications::model()->updateAll($mongoModifier, $mongoCriteria)) {
                $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("Notifications:updateNotificationWithHashTagOrCurbsideCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function updateNotificationAsUnRead($notificationId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('_id', '==', new MongoId($notificationId));
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('isRead', 'set', (int) 0);
             if (Notifications::model()->updateAll($mongoModifier, $mongoCriteria)) {
                    $returnValue = "success";
                }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("Notifications:updateNotificationAsUnRead::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function getAllBroadCastNotifications(){
          $returnValue = 'failure';
        try {
            $mongoCriteria = new EMongoCriteria;       
            $mongoCriteria->addCond('NotificationType', '==', (int)1);
            $userNotifications=  Notifications::model()->findAll($mongoCriteria);            
            if(isset($userNotifications)){
                $returnValue=$userNotifications;
            }
            return $returnValue;
        } catch (Exception $ex) {    
            Yii::log("Notifications:getAllBroadCastNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $returnValue = 'failure';
        }
    }
    
     public function getNotificationById($notificationId){
      try {
          
          $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('_id', '==', new MongoId($notificationId));
            $userNotifications=Notifications::model()->find($mongoCriteria);
            
            if(isset($userNotifications)){
                $returnValue=$userNotifications;
            }
          
            return $returnValue;
      } catch (Exception $ex) {
          Yii::log("Notifications:getNotificationById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    public function getAllSystemNotifications($columnName1,$columnName2,$value1,$value2){
      try {
          
          $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond($columnName1, '==', (int) $value1);
            $mongoCriteria->addCond($columnName2, '==', (int) $value2);
            $userNotifications = Notifications::model()->findAll($mongoCriteria);            
            if(isset($userNotifications)){
                $returnValue = $userNotifications;
            }          
            return $returnValue;
      } catch (Exception $ex) {
          Yii::log("Notifications:getAllSystemNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    public function deleteSystemNotificaitonById($_id){
      try {
          
          $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond("_id", '==', new MongoId($_id));            
            $userNotifications = Notifications::model()->find($mongoCriteria);            
            if(isset($userNotifications)){
                if($userNotifications->delete()){
                    $returnValue = "success";
                }
            }          
            return $returnValue;
      } catch (Exception $ex) {
          Yii::log("Notifications:deleteSystemNotificaitonById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    
}
