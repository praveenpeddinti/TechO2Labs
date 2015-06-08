<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CustomFieldMigration extends CActiveRecord {

    public $UserId;
    public $IsPharmacist;
    public $StateLicenseNumber;
    public $PrimaryAffiliation;
    public $OtherAffiliation;


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'CustomField';
    }

    public function saveCustomField($profileModel,$userId){



        try {
            $returnValue = false;
            $customObj = new CustomFieldMigration();

            $customObj->IsPharmacist = isset($profileModel['isPharmacist'])?$profileModel['isPharmacist']:0;
            $customObj->StateLicenseNumber = isset($profileModel['StateLicenseNumber'])?$profileModel['StateLicenseNumber']:"";                       
            $customObj->PrimaryAffiliation = isset($profileModel['PrimaryAffiliation'])?$profileModel['PrimaryAffiliation']:"";
            $customObj->OtherAffiliation = isset($profileModel['OtherAffiliation'])?$profileModel['OtherAffiliation']:"";
            $customObj->UserId=$userId;
            if($customObj->save()){
                $returnValue=$customObj->Id;

            }
            return $returnValue;
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error', 'application');
        }
    }   
    
  

}
