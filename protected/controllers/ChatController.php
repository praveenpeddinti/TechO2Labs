<?php


/*
 * Developer Moin Hussain
 * on 19 th Feb 2014
 * Chatting methods need to add here
 */

class ChatController extends Controller {
  

public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }
public function init() {
    try{
        parent::init();
        if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            $this->userPrivileges = Yii::app()->session['UserPrivileges'];
            $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
            if(Yii::app()->params['IsDSN']=='ON')
                $this->whichmenuactive=9;
            else
            $this->whichmenuactive=4;
             $this->sidelayout = 'no';
          } else {
                  $this->redirect('/');
             }
    } catch (Exception $ex) {
        Yii::log("ChatController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    } 
 }

 public function actionIndex(){
    try{
        $this->whichmenuactive=4;
        $this->sidelayout = 'no';
        $this->renderPartial('index');
    } catch (Exception $ex) {
        Yii::log("ChatController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    } 
 }

 /**
 * author: Moin Hussain
 * actionGetChatConversations is used to get chat conversations of users
 * request an userId,recipientId
 * returns an ChatConversation object
 */
public function actionGetChatConversations(){
    try{
        if(isset($_REQUEST['userId']) && isset($_REQUEST['recipientId'])){
            $userId = $_REQUEST['userId'];
            $recipientId = $_REQUEST['recipientId'];
             if((int)$userId<(int)$recipientId){ 
                     $roomName ="Room-".$userId."-".$recipientId;
              }else{ 
                     $roomName = "Room-".$recipientId."-".$userId;
             }
           $result =ServiceFactory::getSkiptaChatServiceInstance()->getChatConversations($roomName);
           $offlineUserId = ServiceFactory::getSkiptaChatServiceInstance()->popoutOfflineStatus($userId,$recipientId);
        }
        
        $obj = array('status' => 'success', 'data' =>$result[0],'recentChatTime' =>$result[1],'offlineUserId' =>$offlineUserId, 'error' => '');        
        echo CJSON::encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("ChatController:actionGetChatConversations::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
}
 
/**
 * author: Moin Hussain
 * actionGetMiniPorfile is used to get user mini profile
 * request an userId
 * returns an user object
 */
public function actionGetMiniProfile(){
    try{
        if(isset($_REQUEST['userid'])){
            $userid = $_REQUEST['userid'];
            $result = ServiceFactory::getSkiptaUserServiceInstance()->getUserMiniProfile($userid,Yii::app()->session['TinyUserCollectionObj']->UserId);
        }
        
        $obj = array('status' => 'success', 'data' => $result, 'error' => '');        
        echo CJSON::encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("ChatController:actionGetMiniProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
}

public function actionSaveChatConversations(){
    try{
        $loginUserId = $_REQUEST['loginUserId'];
        $roomName = $_REQUEST['roomName'];
        $chatMessage = $_REQUEST['chatMessage'];
        $profilePicture = Yii::app()->session['TinyUserCollectionObj']->profile70x70;
        $result = ServiceFactory::getSkiptaChatServiceInstance()->saveChatConversations($loginUserId,$roomName,$chatMessage,$profilePicture);
        $obj = array('status' => 'success', 'data' => $result, 'error' => ''); 
        echo $this->rendering($obj);
    } catch (Exception $ex) {
        Yii::log("ChatController:actionSaveChatConversations::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }    
}
public function actionSaveOfflineChatStatus(){
    try{
        $loginUserId = $_REQUEST['loginUserId'];
        //  $roomName = $_REQUEST['roomName'];
        $offlineUserId = $_REQUEST['offlineUserId'];
        $result = ServiceFactory::getSkiptaChatServiceInstance()->saveOfflineChatStatus($loginUserId,$offlineUserId);
        $obj = array('status' => 'success', 'data' => $result, 'error' => '');        
        echo $this->rendering($obj);
    } catch (Exception $ex) {
        Yii::log("ChatController:actionSaveOfflineChatStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    } 
}
}

?>

