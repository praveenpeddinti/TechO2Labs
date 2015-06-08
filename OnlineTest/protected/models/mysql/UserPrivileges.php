<?php

/**
 * UserPrivileges is model file
 * Fields: $Id,$UserId,$UserActionId,$Status
 * user table name: UserActionPrivileges
 * author karteek.vemula 
 * copyright 2008-2014 Techo2 India Pvt Ltd.
 * license http://techo2.com  
 * 
 */

class UserPrivileges extends CActiveRecord {

    public $Id;
    public $UserId;
    public $UserActionId;
    public $Status;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'UserActionPrivileges';
    }

    /**
     * 
     * @param type $userid
     * @return type
     */
    public function getUserPrivileges($userid) {
        try {            
            $user = Yii::app()->db->createCommand("select u.Id, u.Action, u.DisplayLabel,up.Status,up.Id privilegeId from UserActions u left join UserActionPrivileges up on u.Id=up.UserActionId AND up.UserId = $userid and up.Status=1")->queryAll();
        } catch (Exception $ex) {
            Yii::log("UserPrivileges:getUserPrivileges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $user;
    }
    
    /**
     * @author karteek.vemula
     * @param type $privilegesids
     * @return string
     */
    public function updateUserPrivileges($userId,$privilegesids) {
        try {
            $returnValue = "failed";
            $privilegesidsArr = explode(",", $privilegesids);
             $result = 0;
             $privilegesObj = UserPrivileges::model()->findAllByAttributes(array("UserId"=>$userId));
             if(sizeof($privilegesObj) > 0){// updating...                 
                 foreach($privilegesObj as $privilegesObjRow){
                    $privilegesObjRow->Status = 0;
                    $privilegesObjRow->update();                    
                }
                for ($i = 0; $i < count($privilegesidsArr); $i++) {  
                    $privilegesObj = UserPrivileges::model()->findByAttributes(array("UserId" => $userId,"UserActionId"=>$privilegesidsArr[$i]));
                    if(isset($privilegesObj)){
                        $privilegesObj->Status = 1;
                        if($privilegesObj->update()){
                            $result++;
                        }
                    }else{
                        $userPrivileges = new UserPrivileges();
                        $userPrivileges->Status = 1;
                        $userPrivileges->UserActionId = $privilegesidsArr[$i];
                        $userPrivileges->UserId = $userId;
                        if($userPrivileges->save()){
                            $result++;
                        }
                    }               
                }
             }else{ // for saving...                 
                 $this->saveUserPrivileges($userId);
                 for ($i = 0; $i < count($privilegesidsArr); $i++) {  
                    $privilegesObj = UserPrivileges::model()->findByAttributes(array("UserId" => $userId,"UserActionId"=>$privilegesidsArr[$i]));
                    if(isset($privilegesObj)){                        
                            $privilegesObj->Status = 1;
                        if($privilegesObj->update()){
                            $result++;
                        }
                    }               
                }
                
             }
             
            if($result > 0){
                $returnValue = "success";
            }
        } catch (Exception $ex) {
            Yii::log("UserPrivileges:updateUserPrivileges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
    public function saveUserPrivileges($userId){
        try{
            $returnValue = "failed";
            $useractions = Yii::app()->db->createCommand("select * from UserActions")->queryAll();            
            foreach($useractions as $rw){                
                $userPrivileges = new UserPrivileges();
                $userPrivileges->Status = 0;
                $userPrivileges->UserActionId = $rw['Id'];
                $userPrivileges->UserId = $userId;
                if($userPrivileges->save()){
                    $returnValue = "success";
                }
            }
                    
            
        } catch (Exception $ex) {
            Yii::log("UserPrivileges:saveUserPrivileges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    /**
     * @author Sagar Pathapelli
     * This method is used to update the UserPrivileges and it is for RiteAid
     * @param type $userId
     * @param type $actionIds
     * @return string
     */
    public function updateRoleBasedUserPrivileges($userId,$checkedActionIds, $allActionIds) {
        $returnValue = 'failure';
        try {
            $checkedArr = explode(",", $checkedActionIds);
            $allActionsArr = explode(",", $allActionIds);
            $arrayForSelectedRole = array();
            $userActionArray = UserPrivileges::model()->findAllByAttributes(array("UserId" => $userId));
            foreach ($userActionArray as $userAction) {
                array_push($arrayForSelectedRole, $userAction['UserActionId']);
            }
            $uncheckArray = array_diff($arrayForSelectedRole, $checkedArr);
            $notInsertedArray = array_diff($allActionsArr, $arrayForSelectedRole);
            if (sizeof($notInsertedArray) > 0) {
                foreach ($notInsertedArray as $actionId) {
                    $query = "insert into UserActionPrivileges (UserId, UserActionId, Status) values ($userId, $actionId, 0);";
                    YII::app()->db->createCommand($query)->execute();
                }
            }
            if (sizeof($checkedArr) > 0) {
                $query = "update UserActionPrivileges set Status=1 where UserId=" . $userId . " and UserActionId in (" . implode(',', $checkedArr) . ")";
                YII::app()->db->createCommand($query)->execute();
            }
            if (sizeof($uncheckArray) > 0) {
                $query = "update UserActionPrivileges set Status=0 where UserId=" . $userId . " and UserActionId in (" . implode(',', $uncheckArray) . ")";
                YII::app()->db->createCommand($query)->execute();
            }
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserPrivileges:updateRoleBasedUserPrivileges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    public function resetUserPrivileges($userId) {
        $returnValue = 'failure';
        try {
            $query = "update UserActionPrivileges set Status=0 where UserId=" . $userId;
            YII::app()->db->createCommand($query)->execute();
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserPrivileges:resetUserPrivileges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
}
