<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LicensedStatesAndNumbers extends CActiveRecord {
    public $Id;
    public $UserTaxAndRegulatoryInfoId;
    public $LicensedState;
    public $LicensedNumber;
    public $CreatedDate;
    public $UserId=0;
    
    
     public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'LicensedStatesAndNumbers';
    }
   /**
    * Suresh Reddy
    * @param type $utId
    * @param type $model
    * @param type $userId
    * @return string
    */
    public function saveData($utId,$model,$userId=0){
        try{
            $return = "failed";
             if($utId == 0){
                $rescnt = $this->deleteDataByUserId($userId);  
             }else{
                $userId = 0; //for market research
             }
               
            $statesArr = explode(",",$model->LicensedStates);
            $numbersArr = explode(",",$model->LicensedNumbers);
            for($i=0;$i<sizeof($numbersArr);$i++){
                $licObj = new LicensedStatesAndNumbers;
                $licObj->UserTaxAndRegulatoryInfoId = $utId;
              $returnvalue =  State::model()->GetStateCode($statesArr[$i]);
               if($returnvalue == "failure"){
                     $licObj->LicensedState = $statesArr[$i];
               }else{
                     $licObj->LicensedState = $returnvalue['StateCode'];
               }
              
                $licObj->LicensedNumber = $numbersArr[$i];
                $licObj->UserId = $userId;
                if($licObj->save()){
                    $j++;
                }
            }
           // if(isset($numbersArr[0]))
               // User::model()->updateCustomFieldsByUserId($numbersArr[0],$model);
            if($i == $j){
               $return = "success";
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("LicensedStatesAndNumbers:saveData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in LicensedStatesAndNumbers->saveData### ".$ex->getMessage());
        }
    }
    /**
     * @author Moin Hussain
     * @param type $userId
     */
      public function deleteDataByUserId($userId){
        try{
           $query = "delete from LicensedStatesAndNumbers where UserId = $userId";
           Yii::app()->db->createCommand($query)->execute();
        } catch (Exception $ex) {
            Yii::log("LicensedStatesAndNumbers:deleteDataByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in LicensedStatesAndNumbers->deleteDataByUserId### ".$ex->getMessage());
        }
    }
    
     /**
     * @author Moin Hussain
     * @param type $userId
     */
      public function getStateLicenseNumberByUserId($userId){
        try{
           $query = "select LicensedNumber from LicensedStatesAndNumbers where UserId = $userId";
           $data = Yii::app()->db->createCommand($query)->queryRow();
           return $data["LicensedNumber"];
        } catch (Exception $ex) {
            Yii::log("LicensedStatesAndNumbers:deleteDataByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in LicensedStatesAndNumbers->deleteDataByUserId### ".$ex->getMessage());
        }
    }
    /**
     * @author Sagar
     * @param type $userId
     * @return array
     */
    public function getAllStateLicenseNumbersByUserId($userId){
        try{
           $returnValue = array();
           $query = "select LicensedNumber, LicensedState from LicensedStatesAndNumbers where UserId = $userId";
           $data = Yii::app()->db->createCommand($query)->queryAll();
           if(is_array($data)){
                $returnValue= $data;
            }
           return $returnValue;
        } catch (Exception $ex) {
            Yii::log("LicensedStatesAndNumbers:getAllStateLicenseNumbersByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in LicensedStatesAndNumbers->getAllStateLicenseNumbersByUserId### ".$ex->getMessage());
        }
    }
}