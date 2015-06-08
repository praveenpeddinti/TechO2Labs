<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserHierarchy extends CActiveRecord{
    public $Division;
    public $District;
    public $Region;
    public $Store;
    
    public static function model($className=__CLASS__)
    { 
        return parent::model($className);
    }
 
    public function tableName()
    { 
        return 'UserHierarchy';
    }
    public function getUserHierarchyByUserId($userId) {
        try {
            
            $result = 'failure';
            $userHierarchy = UserHierarchy::model()->findByAttributes(array("UserId" => $userId));
            if (isset($userHierarchy)) {
                $result = $userHierarchy;
            } 
            return $result;
        } catch (Exception $ex) {
            Yii::log("UserHierarchy:getUserHierarchyByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
    public function SaveUserHierarchy($userId) {
        try{
        $updateQuery=" INSERT INTO UserHierarchy (UserId,Division,Region,District,Store,Type) VALUES "."($userId,0,0,0,0,'User')";
        YII::app()->db->createCommand($updateQuery)->execute();
        } catch (Exception $ex) {
            Yii::log("UserHierarchy:SaveUserHierarchy::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       
    }

}