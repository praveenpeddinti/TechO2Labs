<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CustomField extends CActiveRecord {

    public $UserId;
    public $IsPharmacist;
    public $StateLicenseNumber;
    public $PrimaryAffiliation;
    public $OtherAffiliation;
    public $NPINumber;


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'CustomField';
    }

    public function saveCustomField($profileModel,$userId){



        try {
            $returnValue = false;
            $customObj = new CustomField();

            $customObj->IsPharmacist = $profileModel['isPharmacist'];
            $customObj->StateLicenseNumber = $profileModel['StateLicenseNumber'];                       
            $customObj->PrimaryAffiliation = $profileModel['PrimaryAffiliation'];
            $customObj->OtherAffiliation = $profileModel['OtherAffiliation'];
            $customObj->UserId=$userId;
            if($customObj->save()){
                $returnValue=$customObj->Id;

            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CustomField:saveCustomField::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }   
      public function getUserCustomFieldMappingUsers($mappingSubSpeFields,$MappingCustomField){
        $returnValue='failure';
        try {
            
            $query="select UserId from CustomField where $MappingCustomField in   ('".implode('\',\'',$mappingSubSpeFields)."') ";       
            $userIds = Yii::app()->db->createCommand($query)->queryAll();
           if(is_array($userIds)){
               $returnValue=$userIds;
           }
           return $returnValue;
        } catch (Exception $ex) {            
            Yii::log("CustomField:getUserCustomFieldMappingUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        }
        
   public function getUserCustomFieldValues($userId){
        $returnValue='failure';
        try {
            
            $query="select * from CustomField where UserId=".$userId;            
            $userDetails = Yii::app()->db->createCommand($query)->queryRow();
           if(is_array($userDetails) || is_object($userDetails)){
               $returnValue=$userDetails;
           }
           return $returnValue;
        } catch (Exception $ex) {            
            Yii::log("CustomField:getUserCustomFieldValues::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        }   
        
  public function getCustomFieldsByUserId($UserId) {
         $customFields='NoUser';
      try {
      $customFields = CustomField::model()->findByAttributes(array('UserId' => $UserId));
      
      return $customFields;
      } catch (Exception $ex) {
          Yii::log("CustomField:getCustomFieldsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in CustomField->getCustomFieldsByUserId### ".$ex->getMessage());
      }
      } 
    
   public function getCustomFormByUserId($UserId) {
         $customForm='failure';
      try {
      $customObject = CustomField::model()->findByAttributes(array('UserId' => $UserId));
      if(isset($customObject) && !empty($customObject)){
         $customForm = new CustomForm; 
            $customForm->isPharmacist = $customObject['IsPharmacist'];
            $customForm->StateLicenseNumber = $customObject['StateLicenseNumber'];                       
            $customForm->PrimaryAffiliation = $customObject['PrimaryAffiliation'];
            $customForm->OtherAffiliation = $customObject['OtherAffiliation'];
            
         
      }
      
      return $customForm;
      } catch (Exception $ex) {
          Yii::log("CustomField:getCustomFormByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in CustomField->getCustomFormByUserId### ".$ex->getMessage());
      }
      } 
   public function updateCustomFields($userId,$customModel) {
        try {
            $returnValue = "Failure";
            $customObj = $this->getCustomFieldsByUserId($userId);
            $customObj->IsPharmacist = $customModel['isPharmacist'];
            if($customObj->IsPharmacist!=0){
               $customObj->StateLicenseNumber = $customModel['StateLicenseNumber']; 
            }else{
               $customObj->StateLicenseNumber =null; 
            }
            $customObj->PrimaryAffiliation = $customModel['PrimaryAffiliation'];
            if($customObj->PrimaryAffiliation=="Other")  {
               $customObj->OtherAffiliation = $customModel['OtherAffiliation'];   
            }
            else{
               $customObj->OtherAffiliation = null;
            } 
            
           
            if ($customObj->update()) {
               $returnValue="success"; 
            }   
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CustomField:updateCustomFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CustomField->updateCustomFields### ".$ex->getMessage());
        }
    }
    public function isSubspecialityChanged($UserId,$CustomForm) {
        $result = false;
        try {
            $customFields = CustomField::model()->findByAttributes(array('UserId' => $UserId));
            if($CustomForm->PrimaryAffiliation!="Other" && $CustomForm->PrimaryAffiliation!=$customFields->PrimaryAffiliation){
               $result=$CustomForm->PrimaryAffiliation; 
            }
            return $result;
        } catch (Exception $ex) {
            Yii::log("CustomField:isSubspecialityChanged::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CustomField->isSubspecialityChanged### ".$ex->getMessage());
        }
    }
    
    public function updatePrimaryAffiliationWithId() {
        try {
            $query = "select * from CustomField";
            $dataList = Yii::app()->db->createCommand($query)->queryAll();
            $subspecialityList = SubSpecialty::model()->findAll();
            $subkeyList = array();
            if (sizeof($subspecialityList) > 0) {
                foreach ($subspecialityList as $subobj) {
                    $subkeyList[$subobj->Value] = $subobj->id;
                }
                if (sizeof($dataList) > 0) {
                    foreach ($dataList as $customfield) {
                        if (!empty($customfield['PrimaryAffiliation'])&& !intval($customfield['PrimaryAffiliation'])) {
                            if(isset($subkeyList[$customfield['PrimaryAffiliation']])){
                                $subspecialityId = $subkeyList[$customfield['PrimaryAffiliation']];
    
                                $updatequery = "update CustomField set PrimaryAffiliation=$subspecialityId where Id=" . $customfield["Id"];
                                Yii::app()->db->createCommand($updatequery)->execute(); 
                            }
                           
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            Yii::log("CustomField:updatePrimaryAffiliationWithId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
/*@Author Haribabu
* This method is used save the custom fields for HDS user
* @Retrun User CustomField Id.
*  
*/
  
    public function saveHdsUserCustomField($profileModel,$userId){
        try {
            $returnValue = false;
            $customObj = new CustomField();
            $Subspecialty=SubSpecialty::model()->getSubSpecialityByName('Value',$profileModel['Speciality']);
            $customObj->IsPharmacist = 1;
            $customObj->StateLicenseNumber = "";   
            $customObj->NPINumber = $profileModel['NPI_NUM'];   
            
            $customObj->PrimaryAffiliation =($Subspecialty!='failure')?$Subspecialty:"";
            $customObj->OtherAffiliation = "";
            $customObj->UserId=$userId;
            if($customObj->save()){
                $returnValue=$customObj->Id;
            }
            return $returnValue;
        } catch (Exception $ex) {
           Yii::log("CustomField:saveHdsUserCustomField::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }



 

public function getSubSpecialityFromCustomField($customField,$customMappingField)  {
      $subspeciality=array();
      try {
          $query="select * from CustomField CF inner join Subspecialty SS on SS.id=CF.$customMappingField where CF.UserId=".$customField;          
        
          $subspeciality = Yii::app()->db->createCommand($query)->queryRow();           
            if(sizeof($subspeciality)>0){
                $returnValue=$subspeciality;
            }
            return $returnValue;
      } catch (Exception $ex) {
          Yii::log("CustomField:getSubSpecialityFromCustomField::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in CustomField->getSubSpecialityFromCustomField### ".$ex->getMessage());
      }
    }
  public function updateUserCustomFields($customModel) {
        try {
            $returnValue = "failure";
            $customObj = $this->getCustomFieldsByUserId($customModel['UserId']);
            if (is_object($customObj)) {
               // $customObj->IsPharmacist = $customModel['isPharmacist'];
                if ($customModel['StateLicenceNumber'] != "") {
                    $customObj->StateLicenseNumber = $customModel['StateLicenceNumber'];
                } else {
                    $customObj->StateLicenseNumber = null;
                }
                $customObj->PrimaryAffiliation = $customModel['Speciality'];
                if ($customObj->PrimaryAffiliation == "Other") {
                    $customObj->OtherAffiliation = $customModel['OtherAffiliation'];
                } else {
                    $customObj->OtherAffiliation = null;
                }

                if ($customObj->update()) {
                    $returnValue = "success";
                }
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CustomField:updateUserCustomFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CustomField->updateUserCustomFields### ".$ex->getMessage());
        }
    }
     public function getUserCustomFieldsForProfileByUserId($UserId) {
         $customFields='NoUser';
        try {

             $query = "select StateLicenseNumber as LicenceNumber,PrimaryAffiliation as PrimaryAffiliation,OtherAffiliation as OtherAffiliation from CustomField where UserId=" . $UserId;
             $userDetails = Yii::app()->db->createCommand($query)->queryRow();
            if (is_array($userDetails) || is_object($userDetails)) {
                $customFields = $userDetails;
            }
            return $customFields;
        } catch (Exception $ex) {
            Yii::log("CustomField:getUserCustomFieldsForProfileByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CustomField->getUserCustomFieldsForProfileByUserId### ".$ex->getMessage());
        }
    }
    public function getAllCustomFieldsByUserId($UserId) {
         $customFields='NoUser';
        try {

             $query = "select * from CustomField where UserId=" . $UserId;
             $userDetails = Yii::app()->db->createCommand($query)->queryRow(true);
            if (is_array($userDetails) || is_object($userDetails)) {
                $customFields = $userDetails;
            }
            return $customFields;
        } catch (Exception $ex) {
            Yii::log("CustomField:getAllCustomFieldsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}
