<?php

/** This is the collection for saving Chat Conversations

 */

class OfflineChatCollection extends EMongoDocument {
    public $offlineUserId;
    public $senderId; //array of senders
  
    
   
   

    public function getCollectionName() {
        return 'OfflineChatCollection';
    }
    public function indexes() {
        return array(
            'index_offlineUserId' => array(
                'key' => array(
                    'offlineUserId' => EMongoCriteria::SORT_ASC,
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
             'offlineUserId' => 'offlineUserId',
             'senderId' => 'senderId',
          
           
           
            
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function saveOfflineChatStatus($senderId,$offlineUserId) {
            try{
            $returnValue = 'false';
            $criteria = new EMongoCriteria;
            $criteria->addCond('offlineUserId', '==',(int)$offlineUserId);
            $offlineObj = OfflineChatCollection::model()->find($criteria);
             if (is_object($offlineObj)) {
                 $mongoModifier = new EMongoModifier;           
                 $mongoModifier->addModifier('senderId', 'addToSet', (int)$senderId);
                 $offlineObj->updateAll($mongoModifier);
                 $returnValue = 'true';
                 
             }else{
            $offlineChatCollection = new OfflineChatCollection();
          //  $offlineChatCollection->roomName=$roomName;
            $offlineChatCollection->offlineUserId = (int)$offlineUserId;
             $offlineChatCollection->senderId = array((int)$senderId);
         
            $offlineChatCollection->insert();
              if (isset($offlineChatCollection->_id)) {
                $returnValue = 'true';
            }
             }
         return $returnValue;
         } catch (Exception $ex) {
          Yii::log("OfflineChatCollection:saveOfflineChatStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    public function getOfflineMessages($loginUserId) {
        try{   
        $criteria = new EMongoCriteria;
            $criteria->addCond('offlineUserId', '==',(int)$loginUserId);
            $offlineObj = OfflineChatCollection::model()->find($criteria);
             if (is_object($offlineObj)) {
                 return $offlineObj;
             }else{
                  return "NoData";
             }
             } catch (Exception $ex) {
          Yii::log("OfflineChatCollection:getOfflineMessages::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
            
    }
    public function popoutOfflineStatus($loginUserId,$offlineSenderUserId){
        try{
        $mongoModifier = new EMongoModifier;  
           $criteria = new EMongoCriteria;
            $criteria->addCond('offlineUserId', '==',(int)$loginUserId);
           $mongoModifier->addModifier('senderId', 'pull', (int)$offlineSenderUserId);
           if(OfflineChatCollection::model()->updateAll($mongoModifier,$criteria)){
               return $offlineSenderUserId;
           }
           } catch (Exception $ex) {
          Yii::log("OfflineChatCollection:popoutOfflineStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
   
  
    
}
