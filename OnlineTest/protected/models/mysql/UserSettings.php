<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * @author Vamsi Krishna
 * This is model class for User Settings
 * 
 */
class UserSettings extends CActiveRecord {
    public $Id;
    public $UserId;
    public $Commented;
    public $Loved;
    public $ActivityFollowed;
    public $UserFollowers;
    public $Mentioned;
    public $Invited;
    public $NetworkId;
     public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'UserSettings';
    }
    
     public function saveUserSettings($userId,$networkId) {
    
        $userSettings = new UserSettings();
        $userSettings->UserId = (int)$userId;
        $userSettings->Commented = 1;
        $userSettings->Loved =0;
        $userSettings->ActivityFollowed =0;
        $userSettings->Mentioned = 1;
        $userSettings->Invited = 1;
        $userSettings->UserFollowers = 0;
        $userSettings->NetworkId =(int)$networkId ;



        if ($userSettings->save()) {
           echo "saved";
        }
    }
    
 /**
 * @author Vamsi Krishna
 * This method is used to get user settings 
 * @param $userId
 * @return $obj
 */
   public function getUserSettings($userId) {
        $returnValue = 'failure';
        try {
            echo " in user settings".$userId;
            $userSettings=UserSettings::model()->findByAttributes(array("UserId" => $userId));
            
                  
            if(isset($userSettings)){
                $returnValue=$userSettings;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserSettings:getUserSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    /**
     * @author Karteek V
     * @param type $userId
     * @param type $settingIds
     * @return string
     */
    public function updateUserSettings($userId,$settingIds){
        try {
            $returnValue = "failed";            
            $userSettings=UserSettings::model()->findByAttributes(array("UserId" => $userId));
            $userSettings->Loved = 0;
            $userSettings->Commented = 0;
            $userSettings->ActivityFollowed = 0;
            $userSettings->UserFollowers = 0;
            $userSettings->Mentioned = 0;
            $userSettings->Invited = 0;
            $userSettings->update();
            if(isset($userSettings)){               
                $columnNameArray = explode(",",$settingIds);
                if(isset($columnNameArray)){
                    for($i=0;$i<sizeof($columnNameArray);$i++){
                        if($columnNameArray[$i] == "Loved"){
                            $userSettings->Loved = 1;
                        }else if($columnNameArray[$i] == "Commented"){
                            $userSettings->Commented = 1;
                        }else if($columnNameArray[$i] == "ActivityFollowed"){
                            $userSettings->ActivityFollowed = 1;
                        }else if($columnNameArray[$i] == "UserFollowers"){
                            $userSettings->UserFollowers = 1;
                        }else if($columnNameArray[$i] == "Mentioned"){
                            $userSettings->Mentioned = 1;
                        }else if($columnNameArray[$i] == "Invited"){
                            $userSettings->Invited = 1;
                        }
                        if($userSettings->update()){
                            $returnValue = "success";
                        }
                    }
                }
                
            }            
        } catch (Exception $ex) {
            Yii::log("UserSettings:updateUserSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');          
        }
        return $returnValue;
    }

}