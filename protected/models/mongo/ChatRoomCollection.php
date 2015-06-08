<?php

/** This is the collection for saving Chat Conversations

 */

class ChatRoomCollection extends EMongoDocument {

    public $roomName; //unique
    public $userId1; //unique
    public $userId2; //unique
    public $updatedTime; //unique
    public $conversations; //array of messages with User Id,message,profilePicture,createdTime
    
   

    public function getCollectionName() {
        return 'ChatRoomCollection';
    }
    public function indexes() {
        return array(
            'index_roomName' => array(
                'key' => array(
                    'roomName' => EMongoCriteria::SORT_ASC,
                    'userId1' => EMongoCriteria::SORT_ASC,
                    'userId2' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_userId1' => array(
                'key' => array(
                    'userId1' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_userId2' => array(
                'key' => array(
                    'userId2' => EMongoCriteria::SORT_ASC,
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            'roomName' => 'roomName',
            'userId1' => 'userId1',
            'userId2' => 'userId2',
            'updatedTime' => 'updatedTime',
            'conversations' => 'conversations',
            
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
   
    /** 
     
     * this method is used to save the user colletion (tiny user) it accepts the user collection object 
      * if saves to the userCollection it returns the userID 
          */
    public function saveChatConversation($loginUserId,$roomName,$chatMessage,$profilePicture) {
        try {
            $returnValue = 'false';
           
           if($chatMessage==""){
               $conversations = array("message"=>"");
           }else{
            $conversations = array("message"=>$chatMessage,"userId"=>(int)$loginUserId,"profilePicture"=>$profilePicture,"createdOn"=>new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
             $roomNameArray =  explode("-",$roomName);
           
             if($roomNameArray[1] == $loginUserId){
                   $notifyUserId= $roomNameArray[2];
             }else{
                   $notifyUserId= $roomNameArray[1];
             }
          
            $obj = (object) array('ActionType' => 'Chat', 'Message' => $chatMessage,'UserId'=>(int)$loginUserId,'OriginalUserId'=>(int)$notifyUserId);  
             CommonUtility::initiatePushNotification($obj,true);
             
           }
            $criteria = new EMongoCriteria;
            $criteria->addCond('roomName', '==',$roomName);
            $chatObj = ChatRoomCollection::model()->find($criteria);
             if (is_object($chatObj)) {
                 $mongoModifier = new EMongoModifier;           
                 $mongoModifier->addModifier('conversations', 'push', $conversations);
                  $mongoModifier->addModifier('updatedTime', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
                  $criteria = new EMongoCriteria;
                 $criteria->addCond('roomName', '==',$roomName);
                 $chatObj->updateAll($mongoModifier, $criteria);
                 $returnValue = 'true';
                 
             }else{
            $chatRoomCollection = new ChatRoomCollection();
            $roomNameArray =  explode("-",$roomName);
            $userId1 = $roomNameArray[1];
            $userId2 = $roomNameArray[2];
            $chatRoomCollection->roomName=$roomName;
            $chatRoomCollection->userId1=(int)$userId1;
            $chatRoomCollection->userId2=(int)$userId2;
            $chatRoomCollection->updatedTime=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
          
               $chatRoomCollection->conversations = array($conversations); 
           
            
         
            $chatRoomCollection->insert();
              if (isset($chatRoomCollection->_id)) {
                $returnValue = 'true';
            }
             }
         return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ChatRoomCollection:saveChatConversation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   /** This method gets tinyUser collection object from mongo 
    It accepts userId as a paramter and returns faliure string if it didnot find the record and returns 
    * tiny user obj if it finds    */
   public function getChatConversations($roomName){
       try {
      $returnValue='failure';
            $mongoCriteria = new EMongoCriteria;            
            $mongoCriteria->addCond('roomName', '==', $roomName);
            $chatObj = ChatRoomCollection::model()->find($mongoCriteria);
            if (is_object($chatObj)) {
                  $conversations = $chatObj->conversations;
                 // $conversations = array_slice($conversations,0,3);
                if($conversations != null){
              
                $formatedConversations = array();
                $firstRecord = $conversations[count($conversations)-1];
                
                  $text = date("d-m-Y h:i:s A", $firstRecord['createdOn']->sec);
         $difference = time() - $firstRecord['createdOn']->sec;
        
          $minutes = round($difference/60); 
                foreach ($conversations as $value) {
                 $createdOn = $value['createdOn'];
                 $userobj = UserCollection::model()->getTinyUserCollection((int)$value['userId']);
                // if($value['profilePicture'] != $userobj->profile70x70){
                     $value['profilePicture'] = $userobj->profile70x70;
                // }
              
                 $formatedDate =   CommonUtility::styleDateTime($createdOn->sec); 
                     $value['createdOn'] = $formatedDate;
                     array_push($formatedConversations, $value);
                }
                 $chatObj->conversations = $formatedConversations;
                   return  array($chatObj,$minutes);
                 }else{
                     return  null;  
                 }
              
            
            }
           else{
                return  null;
           }
            
       } catch (Exception $ex) {
           Yii::log("ChatRoomCollection:getChatConversations::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
       
      }
public function getAllChatUsersCount($userId){
            
   try{
    $collection = ChatRoomCollection::model()->getCollection();
    $cursor = $collection->find(array( '$or' => array( array('userId1' => (int)$userId), array('userId2' => (int)$userId) ) ));
    return $cursor->count();   
   } catch (Exception $ex) {
       Yii::log("ChatRoomCollection:getAllChatUsersCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       error_log("Exception Occurred in ChatRoomCollection->getAllChatUsersCount==".$ex->getMessage());
   }
    
            
 }
  public function getRecentChatUsers($userId,$offset,$limit){
  try{
      $collection = ChatRoomCollection::model()->getCollection();
//       $js = "function() {
//    return this.userId1 == '".$userId."' || this.userId2 == '".$userId."';
//}";
$cursor = $collection->find(array( '$or' => array( array('userId1' => (int)$userId), array('userId2' => (int)$userId) ) ))->skip($offset)->limit($limit);
$cursor->sort(array('updatedTime' => -1));
//$cursor->limit(1);
//$cursor->offset(1);
foreach ($cursor as $doc) {
            
}
//$cursor->toArray();
$mergedChatUsers = iterator_to_array($cursor);
//return;
//    
//         // Example criteria
//    $array = array(
//        'select'=>array('roomName'=>true,'updatedTime'=>true),
//        'conditions'=>array(
//            // field name => operator definition
//            'userId1'=>array('eq' => (int)$userId), // Or 'FieldName1'=>array('>=', 10)
//           // 'FieldName2'=>array('in' => array(1, 2, 3)),
//           // 'FieldName3'=>array('exists'),
//        ),
//        //'limit'=>10,
//       // 'offset'=>25,
//        'sort'=>array('updatedTime'=>EMongoCriteria::SORT_DESC),
//    );
//     
//    $criteria = new EMongoCriteria($array);
//    
//     $chatObjArray1 = ChatRoomCollection::model()->findAll($criteria); 
//      
//     
//      $array = array(
//        'select'=>array('roomName'=>true,'updatedTime'=>true),
//        'conditions'=>array(
//            // field name => operator definition
//            'userId2'=>array('eq' => (int)$userId), // Or 'FieldName1'=>array('>=', 10)
//           // 'FieldName2'=>array('in' => array(1, 2, 3)),
//           // 'FieldName3'=>array('exists'),
//        ),
//        //'limit'=>10,
//       // 'offset'=>25,
//        'sort'=>array('updatedTime'=>EMongoCriteria::SORT_DESC),
//    );
//     
//    $criteria = new EMongoCriteria($array);
//    
//     $chatObjArray2 = ChatRoomCollection::model()->findAll($criteria);
//     $mergedChatUsers = array_merge($chatObjArray1,$chatObjArray2);
    
//     usort($mergedChatUsers, function($item1, $item2) {
//    $ts1 = $item1['updatedTime']->sec;
//    $ts2 = $item2['updatedTime']->sec;
//    return $ts2 - $ts1;
//     }
//    );
    
     $recentChatUsers = array();
     foreach ($mergedChatUsers as $value) {
         $roomArray = explode("-", $value['roomName']);
         if($userId!=$roomArray[1] && $userId==$roomArray[2]){
             array_push($recentChatUsers, $roomArray[1]);
         }else if($userId!=$roomArray[2] && $userId==$roomArray[1]){
             array_push($recentChatUsers, $roomArray[2]); 
         }
     }
  
    return $recentChatUsers;
    } catch (Exception $ex) {
        Yii::log("ChatRoomCollection:getRecentChatUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }        
 } 
public function checkUserInInbox($userId,$searchUserId){
    try{
        $collection = ChatRoomCollection::model()->getCollection();
        $cursor = $collection->find(array( '$or' => array( array('userId1' => (int)$userId,"userId2"=>(int)$searchUserId), array('userId2' => (int)$userId,"userId1"=>(int)$searchUserId) ) )); 
        if($cursor->count()>0){
            return 1;
        }else{
            return 0;
        }
        
    } catch (Exception $ex) {
        Yii::log("ChatRoomCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        error_log("Exception Occurred in ChatRoomCollection->checkUserInInbox==".$ex->getMessage());
    }
}
}
