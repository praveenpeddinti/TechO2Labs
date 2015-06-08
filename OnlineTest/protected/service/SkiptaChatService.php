<?php

class SkiptaChatService {

    
    public function saveChatConversations($loginUserId,$roomName,$chatMessage,$profilePicture){
        try{
        return ChatRoomCollection::model()->saveChatConversation($loginUserId,$roomName,$chatMessage,$profilePicture); 
        } catch (Exception $ex) {
              Yii::log("SkiptaChatService:saveChatConversations::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getChatConversations($roomName){
        try{
        return ChatRoomCollection::model()->getChatConversations($roomName); 
        } catch (Exception $ex) {
              Yii::log("SkiptaChatService:getChatConversations::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function saveOfflineChatStatus($loginUserId,$offlineUserId){
        try{
         return OfflineChatCollection::model()->saveOfflineChatStatus($loginUserId,$offlineUserId); 
         } catch (Exception $ex) {
              Yii::log("SkiptaChatService:saveOfflineChatStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function popoutOfflineStatus($loginUserId,$offlineSenderUserId){
        try{ 
        return OfflineChatCollection::model()->popoutOfflineStatus($loginUserId,$offlineSenderUserId);
        } catch (Exception $ex) {
              Yii::log("SkiptaChatService:popoutOfflineStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
 
}

?>
