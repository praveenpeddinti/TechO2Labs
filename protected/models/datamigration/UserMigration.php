<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserMigration extends CActiveRecord {

    public $UserId;
    public $FirstName;
    public $LastName;
    public $DisplayName;
    public $Password;
    public $OldPassowrd1;
    public $OldPassowrd2;
    public $Email;
    public $RegistredDate;
    public $LastLoginDate;
    public $Country;
    public $State;
    public $City;
    public $Zip;
    public $Status;
    public $UpdatedPassword;
    public $Company;
    public $PasswordResetToken;
    public $CustomFieldId;
    public $NetworkId;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'User';
    }


    
     public function  checkUserExist($email){       
        try {
           $user = User::model()->findByAttributes(array('Email'=>$email));
           return $user; 
           
        } catch (Exception $exc) {
            error_log("checkUserExist ".$exc->getTraceAsString());
        }
    }

    public function saveUser($profileModel,$customfields){
        try {
            $returnValue = false;
            $userObj = new UserMigration();

            $firstName = isset($profileModel['firstName'])?$profileModel['firstName']:"";
            $lastName = isset($profileModel['lastName'])?$profileModel['lastName']:"";
            $userObj->FirstName = $firstName;
            $userObj->LastName = $lastName;                       
            $userObj->DisplayName = $firstName.$lastName;
            $userObj->Password =  isset($profileModel['password'])?$profileModel['password']:"";

            $userObj->OldPassowrd1 = '';
            $userObj->OldPassowrd2 = '';
            $userObj->Email = isset($profileModel['email'])?$profileModel['email']:"";

            $userObj->RegistredDate = date('Y-m-d H:i:s', time());         
            $userObj->LastLoginDate ='';   
            $userObj->Country =isset($profileModel['country'])?$profileModel['country']:"";
            $userObj->State = isset($profileModel['state'])?$profileModel['state']:"";
            $userObj->City = isset($profileModel['city'])?$profileModel['city']:"";
            $userObj->Zip = isset($profileModel['zip'])?$profileModel['zip']:"";
            $userObj->Status = 0;
            $userObj->Company = isset($profileModel['companyName'])?$profileModel['companyName']:"";
            $userObj->PasswordResetToken ='';     
            $userObj->CustomFieldId=$customfields;
            $userObj->NetworkId=$profileModel['network'];
            if($userObj->save()){
                $returnValue=$userObj->UserId;
            }
            return $returnValue;
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error', 'application');
        }
    }
}
