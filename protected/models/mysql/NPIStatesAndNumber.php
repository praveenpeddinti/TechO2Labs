<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NPIStatesAndNumber extends CActiveRecord {
    public $Id;
    public $UserTaxAndRegulatoryInfoId;
    public $NPIState;
    public $NPINumber;
    public $CreatedDate;
    public $UserId=0;
    
    
     public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'NPIStatesAndNumber';
    }
    /**
     * @developer Suresh G
     * @param type $utId
     * @param type $model
     * @param type $userId
     * @return string
     */
    public function saveData($utId,$model,$userId=0){
        try{
            $return = "failed";
            $statesArr = array();
            $statesArr = explode(",",$model->NPIState);
           
            $i = 0;
            $rescnt = 0;
            if($utId == 0){
               $rescnt = $this->deleteDataByUserId($userId); 
            }
            else{
               $userId = 0; //for market research
            }
                
                foreach($statesArr as $rw){ 
                    $npiObj = new NPIStatesAndNumber;
                    $npiObj->UserTaxAndRegulatoryInfoId = $utId;
                    $returnvalue =  State::model()->GetStateCode($rw);
                    if($returnvalue == "failure"){
                         $npiObj->NPIState = $rw;
                    }else{
                          $npiObj->NPIState = $returnvalue['StateCode'];
                    }
                  
                    $npiObj->NPINumber = $model->NPINumber;
                    $npiObj->UserId = $userId;
                    $i++;
                    if($npiObj->save()){
                        $j++;
                    }
                }
            
           //if(isset($model->NPINumber))
               // User::model()->updateCustomFieldsByUserId("",$model);
            if($i == $j){
               $return = "success";
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("NPIStatesAndNumber:saveData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in NPIStatesAndNumber->saveData### ".$ex->getMessage());
        }
    }
    
    public function deleteDataByUserId($userId){
        try{
           $query = "delete from NPIStatesAndNumber where UserId = $userId";
           Yii::app()->db->createCommand($query)->execute();
        } catch (Exception $ex) {
            Yii::log("NPIStatesAndNumber:deleteDataByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in NPIStatesAndNumber->deleteDataByUserId### ".$ex->getMessage());
        }
    }
}