<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
/**
 * @author VamsiKrishna
 * This class is use save and get Professional Information of the user
 */
class ProfessionalInformation extends CActiveRecord{
    public $UserId;
    public $Speciality;
    public $Position;
    public $School;
    public $Degree;
    public $Years_Experience;
    public $Highest_Education;
    public $Credentials;
    public $PracticeName;
    public $Title;
    
            
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'ProfessionalInformation';
    }
    
    
 /**
     * @author VamsiKrishna
     * This Method is use to save professional information of the user 
     * @params ProfessionalInformation model
     * 
     */
    public function saveProfessionalInformation($model,$userId) {
           $returnValue='failure';
        try {         
            $PIObj=new ProfessionalInformation();
            $PIObj->UserId=$userId;
            $PIObj->Degree=$model['Degree'];
            $PIObj->Highest_Education=$model['Highest_Education'];
            if(isset($model->Position)){
             $PIObj->Position=$model->Position;    
            }
            
            if(isset($model->Speciality))
            {                
                $PIObj->Speciality=$model->Speciality;
            }
            $PIObj->School=$model['School'];
            $PIObj->Years_Experience=$model['Years_Experience'];
            
             if ($PIObj->save()) {
                 $returnValue ='success';
             }
          
            
        } catch (Exception $ex) {
            Yii::log("ProfessionalInformation:saveProfessionalInformation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
 /**
     * @author VamsiKrishna
     * This Method is use to get professional information of the user 
     * @params $userId
     * 
     **/
    public function getProfessionalInformationByUserId($userId){
        $result = 'failure';
    try { 
            $userPersonalInformation = ProfessionalInformation::model()->findByAttributes(array("UserId" => $userId));
            if (isset($userPersonalInformation)) {
                $result = $userPersonalInformation;
            } 
            return $result;
        
    } catch (Exception $ex) {
        Yii::log("ProfessionalInformation:getProfessionalInformationByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        return $result;
    }
    }
    
     /**
     * @author VamsiKrishna
     * This Method is use to save professional information of the user 
     * @params ProfessionalInformation model
     * 
     */
    
     public function updateProfessionalInformation($model,$professionalInformation) {
           $returnValue='failure';
        try {
            $professionalInformation->Degree=$model['Degree'];
            $professionalInformation->Highest_Education=$model['Highest_Education'];
            $professionalInformation->Position=$model['Position'];
            $professionalInformation->School=$model['School'];
            $professionalInformation->Years_Experience=$model['Years_Experience'];
            $professionalInformation->Speciality=$model['Speciality']; 
            if($professionalInformation->update()){
                 $returnValue='success';
            }
          return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ProfessionalInformation:updateProfessionalInformation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
    
    
    public function updatePersonalInformationByType($value,$type,$userId){
    try {
          
        $query = "Update ProfessionalInformation set $type = '" . $value . "' where UserId = $userId";

            return YII::app()->db->createCommand($query)->execute();
            
    } catch (Exception $ex) {
         Yii::log("ProfessionalInformation:updatePersonalInformationByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
    }
    }
    
  /**
     * @author Haribabu
     * This Method is use to save professional information of the user 
     * @params ProfessionalInformation model
     * 
     */
    public function UpdateUserProfessionalInformation($UserProfileModel) {
           $returnValue='failure';
        try {  
            $returnValue = "failure";
            $userObj = $this->getProfessionalInformationByUserId($UserProfileModel['UserId']);
            if($userObj!='failure'){ 
                $userObj->Credentials=$UserProfileModel['Credentials'];
                $userObj->PracticeName=$UserProfileModel['PracticeName'];
                $userObj->Title=$UserProfileModel['Title'];
               
                if ($userObj->update()) {
                    $returnValue = "success";
                }
            }else{
                $PIObj = new ProfessionalInformation();
                $PIObj->UserId = $UserProfileModel['UserId'];
                $PIObj->PracticeName = $UserProfileModel['PracticeName'];
                $PIObj->Title = $UserProfileModel['Title'];
                if ($PIObj->save()) {
                    $returnValue = 'success';
                }
            }
             
            return $returnValue;

        } catch (Exception $ex) {
            Yii::log("ProfessionalInformation:UpdateUserProfessionalInformation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
    }
     /**
     * @author Haribabu
     * This Method is use to save Hds User professional information of the user 
     * @params ProfessionalInformation model
     * 
     */
    public function saveHdsUserProfessionalInformation($UserProfileModel,$userId) {
           $returnValue='failure';
        try {         
            
            $PIObj=new ProfessionalInformation();
            $PIObj->UserId=$userId;
            $PIObj->PracticeName = $UserProfileModel['PracticeName'];
            $PIObj->Credentials = $UserProfileModel['Title'];
            
             if ($PIObj->save()) {
                 
                 $returnValue ='success';
             }
            
        } catch (Exception $ex) {
            Yii::log("ProfessionalInformation:saveProfessionalInformation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
    

}