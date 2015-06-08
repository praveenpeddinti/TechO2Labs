<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class RoleBasedAction extends CActiveRecord {
    public $Id;
    public $UserTypeId;
    public $UserActionId;
    public $Status;
    
     public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'RoleBasedAction';
    }
    
    public function getRoleBasedActions($selectedRole) {
         $returnValue = 'failure';
        try {
          // $roleBasedActions= RoleBasedAction::model()->findByAttributes(array("UserTypeId" => $selectedRole));
            $query = "SELECT UA.*, RBA.Status FROM UserActions UA  left join RoleBasedAction RBA  on UA.Id=RBA.UserActionId and RBA.UserTypeId=".$selectedRole." where  UA.Active=1";

             $roleBasedActions = Yii::app()->db->createCommand($query)->queryAll();             
           
           if(isset($roleBasedActions) && !empty($roleBasedActions)){
                $returnValue=$roleBasedActions;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("RoleBasedAction:getRoleBasedActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
   
  public function updateRoleBasedActions($selectedRole,$actionIds){
      $returnValue = 'failure';
      try {         
           $checkedArr = explode(",", $actionIds);
           
           $arrayForSelectedRole=array();
           
           $roleBasedArray=RoleBasedAction::model()->findAllByAttributes(array("UserTypeId"=>$selectedRole));
           foreach($roleBasedArray as $role){
               array_push($arrayForSelectedRole,$role['UserActionId']);
           }
           $uncheckArray=array_diff($arrayForSelectedRole,$checkedArr);
           $notInsertedArray = array_diff($checkedArr, $arrayForSelectedRole);
           if(sizeof($notInsertedArray)>0){
               foreach($notInsertedArray as $actionId){
                $query = "insert into RoleBasedAction (UserTypeId, UserActionId, Status) values ($selectedRole, $actionId, 0);";
                YII::app()->db->createCommand($query)->execute();
               }
           }
         // for($i=0;$i<sizeof($checkedArr);$i++){              
            $query = "update RoleBasedAction set Status=1 where UserTypeId=".$selectedRole." and UserActionId in (". implode(',',$checkedArr) .")";
            YII::app()->db->createCommand($query)->execute();
         // }
         // for($j=0;$i<sizeof($uncheckArray);$j++){     
            if(sizeof($uncheckArray)>0){
                $query = "update RoleBasedAction set Status=0 where UserTypeId=".$selectedRole." and UserActionId in (". implode(',',$uncheckArray) .")";
                YII::app()->db->createCommand($query)->execute();
            }
             $returnValue="success";
             return $returnValue;
          //}
      } catch (Exception $ex) {
          Yii::log("RoleBasedAction:updateRoleBasedActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             return $returnValue;
      }
    }  
    /**
     * @author Sagar Pathapelli
     * This is used to get User Actions By UserType / RoleId (for Rite Aid)
     * @param type $userId
     * @param type $userTypeId
     * @return string
     */
    public function getUserActionsByUserType($userId, $userTypeId) {
         $returnValue = 'failure';
        try {
          // $roleBasedActions= RoleBasedAction::model()->findByAttributes(array("UserTypeId" => $selectedRole));
            $query = "select A.Id, A.Action, A.DisplayLabel,A.Status defaultRole,(case when B.Status IS NOT NULL then B.Status else A.Status end) as Status from (select UA.Id, UA.Action, UA.DisplayLabel, IFNULL(RBA.Status, 0) as Status  from UserActions UA LEFT JOIN RoleBasedAction RBA on UA.Id=RBA.UserActionId and RBA.UserTypeId=$userTypeId where UA.Active=1) A left join
                        (SELECT UAP.UserActionId as Id, UAP.Status FROM UserActionPrivileges UAP where UserId=$userId) as B on A.Id=B.Id";

            $userActions = Yii::app()->db->createCommand($query)->queryAll();             
           
           if(isset($userActions) && !empty($userActions)){
                $returnValue=$userActions;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("RoleBasedAction:getUserActionsByUserType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
}
