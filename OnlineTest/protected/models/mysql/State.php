<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class State extends CActiveRecord{
    
    public $State;
    public $CountryId;
    public $Status;
    public $StateCode;
    
    
      public static function model($className=__CLASS__)
    { 
        return parent::model($className);
    }
 
    public function tableName()
    { 
        return 'State';
    }
    public function GetState(){
        try {
                $resources=Yii::app()->db->createCommand("SELECT * FROM  State;")->queryAll();

            } catch (Exception $ex) {
                Yii::log("State:GetState::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                error_log("Exception Occurred in State->GetState### ".$ex->getMessage());
            }

              return $resources;
     }
      public function GetStateById($id){
        try {
                $state=Yii::app()->db->createCommand("SELECT * FROM  State where id=$id")->queryRow();

            } catch (Exception $ex) {
                Yii::log("State:GetStateById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                error_log("Exception Occurred in State->GetStateById### ".$ex->getMessage());
            }

            return $state;
     }
     /*@Author Haribabu
      * This method is used to get the states by using country id
      */
      public function GetStateByUsingCountryId($CountryId){
        try {
            $returnvalue="failure";
                $states=Yii::app()->db->createCommand("SELECT * FROM  State where CountryId=$CountryId")->queryAll();
                if(is_array($states) && sizeof($states)>0){
                  $returnvalue=$states;  
                }
            } catch (Exception $ex) {
                 Yii::log("State:GetStateByUsingCountryId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }

              return $returnvalue;
     }
     
     
    public function GetStateByUsingStateName($State){
        try {
            $returnvalue="failure";
                $stateType = (strlen(trim($State)>=2))?'StateCode':'State';
                $states=Yii::app()->db->createCommand("SELECT * FROM  State where $stateType='$State'")->queryRow();
                if(is_array($states) && sizeof($states)>0){
                  $returnvalue=$states;  
                }
            } catch (Exception $ex) {
                 Yii::log("State:GetStateByUsingStateName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }

              return $returnvalue;
     } 
     
      public function GetStateCode($StateId){
        try {
            $returnvalue="failure";
              $query = "select id,StateCode from State where id=".$StateId;
               
                $states=Yii::app()->db->createCommand($query)->queryRow();
                if(is_array($states) && sizeof($states)>0){
                  $returnvalue=$states;  
                }
            } catch (Exception $ex) {
                 Yii::log("State:GetStateCode::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }

              return $returnvalue;
     } 
    
     
     
     
     
}
