<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserTaxAndRegulatoryInfo extends CActiveRecord {

    public $Id;
    public $UserId;
    public $FirstName;
    public $LastName;
    public $State;
    public $City;
    public $Zip;
    public $Credential;
    public $MedicalSpecialty;
    public $Address1;
    public $Address2;
    public $Phone;
    public $NPINumber = 0;
//    public $LicensedStates ;
//    public $LicensedNumber;
    public $NPIStatus = 0;
    public $FederalTaxIdOrSSN=0;
    public $SurveyId;
    public $ScheduleId;
    public $CreatedDate; 
    public $NPIState;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'UserTaxAndRegulatoryInfo';
    }

    public function saveInfo($modelObj){
        try{
            
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:saveInfo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserTaxAndRegulatoryInfo->saveInfo==".$ex->getMessage());
        }
    }
    
    public function saveUserInfo($model) {
        try {
            $returnValue = false;            
            $userObj = new UserTaxAndRegulatoryInfo();
            $userObj->FirstName = $model->FirstName;
            $userObj->LastName = $model->LastName;            
            $userObj->State = $model->State;
            $userObj->City = $model->City;
            $userObj->Zip = $model->Zip;
            $userObj->NPIStatus = $model->HavingNPINumber;
            $string = $model->FederalTaxIdOrSSN;
            $secret_key = "This is my FederalTaxIdOrSSN";
           
          //  $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
           // $userObj->FederalTaxIdOrSSN = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $string, MCRYPT_MODE_CBC, $iv);
            $userObj->FederalTaxIdOrSSN =  base64_encode($model->FederalTaxIdOrSSN);
            $userObj->UserId = $model->UserId;
            $userObj->Credential = $model->Credential;
            $userObj->MedicalSpecialty = $model->MedicalSpecialty;
            $userObj->Address1 = $model->Address1;
            $userObj->Address2 = $model->Address2;
            $userObj->Phone = $model->Phone;
            $userObj->NPINumber = $model->NPINumber;
            $userObj->SurveyId = $model->SurveyId;
            $userObj->ScheduleId = $model->ScheduleId;
            $userObj->NPIState = $model->State;
            $model->NPIState = $model->State; // state will be NPI state
            if($userObj->save()){
//                $userObj->getPrimaryKey();
//                $return = LicensedStatesAndNumbers::model->saveObject();
                $pid = $userObj->getPrimaryKey();
//                if($userObj->NPIStatus ==1)
//                    LicensedStatesAndNumbers::model()->saveData($pid,$model);
//                if(!empty($model->State) && sizeof($model->State)>0){
//                     NPIStatesAndNumber::model()->saveData($pid,$model);
//                }
                $returnValue = User::model()->updateUserById($model,$pid);
                
            }
            
            
      //-----End-----------------      
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:saveUserInfo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserTaxAndRegulatoryInfo->saveUserInfo==".$ex->getMessage());
        }
    }

    
    public function getProfileDetails($userId,$scheduleId,$surveyId){
        try{
             $return = 0;
            $userObj = UserTaxAndRegulatoryInfo::model()->findByAttributes(array("UserId" => $userId,"ScheduleId"=>$scheduleId,"SurveyId"=>$surveyId));
            if(!empty($userObj)){
                $return = 1;
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getProfileDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserTaxAndRegulatoryInfo->getProfileDetails==".$ex->getMessage());
        }
    }
    
    
    /*
     * GetUserProfile: which takes 4 arguments and 
     * by default 2 arguments are initialized with default values those are startLimit = 0 and pageLength = 10;
     * and this function returns Users Object.
     */

    public function getUserProfile($filterValue, $searchText, $startLimit = 0, $pageLength = 10) {
        try {
            $searchText = trim($searchText);
            $role='';
            $criteria = new CDbCriteria();
            if (trim($filterValue) == "all") {
                $criteria = $criteria;
            } else if (trim($filterValue) == "inprogress") {
                $criteria->addSearchCondition('Status', '0');
            } else if (trim($filterValue) == "active") {
                $criteria->addSearchCondition('Status', '1');
            } else if (trim($filterValue) == "suspended") {
                $criteria->addSearchCondition('Status', '2');
            }else if (trim($filterValue) == "reject") {
                $criteria->addSearchCondition('Status', '3');
            }
            if (!empty($searchText) && $searchText != "undefined" && $searchText != "null") {
                $namesArray = explode(" ",$searchText);
               
                if(!empty($namesArray[0])){
                    $firstName = trim($namesArray[0]);  
                }
                if((isset($namesArray[1]) && !empty($namesArray[1]))){
                    $lastName = trim($namesArray[1]);
                }
                
              
                
                $criteria->addSearchCondition('Email', trim($searchText));
                
                $criteria->addSearchCondition('FirstName', $firstName , true, "OR", "LIKE");                
                if(isset($lastName) && !empty($lastName)){                    
                    $criteria->addSearchCondition('FirstName', $firstName , true, "AND", "LIKE");
                    $criteria->addSearchCondition('LastName', $lastName , true, "AND", "LIKE");
                }else{
                   $criteria->addSearchCondition('LastName', $firstName , true, "OR", "LIKE");       
                }
                
                $roleId= UserType::model()->getRoleByName($searchText);               
                if($roleId !='false'){                   
                   $role=$roleId ;
                   $criteria->addSearchCondition('UserTypeId',$role,true,'OR','LIKE');
                  
                }
                   
            }
          
            $criteria->order = 'RegistredDate DESC, LastName,FirstName';
            $criteria->offset = $startLimit;
            $criteria->limit = $pageLength;
            $result = User::model()->findAll($criteria);
            for ($i = 0; $i < sizeof($result); $i++) {
                $result[$i]->RegistredDate = date("m/d/Y", strtotime($result[$i]->RegistredDate));
                $userTypeObject = UserType::model()->getUserTypeObjectById($result[$i]->UserTypeId);
                $result[$i]->UserType = $userTypeObject->Name;
            }
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getUserProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }

    /*
     * GetUserProfileCount: which takes 2 arguments and 
     * returns the total no. of users.
     */

    public function getUserProfileCount($filterValue, $searchText) {
        try {
            $criteria = new CDbCriteria();
            if (trim($filterValue) == "all") {
                $criteria = $criteria;
            } else if (trim($filterValue) == "inprogress") {
                $criteria->addSearchCondition('Status', '0');
            } else if (trim($filterValue) == "active") {
                $criteria->addSearchCondition('Status', '1');
            } else if (trim($filterValue) == "suspended") {
                $criteria->addSearchCondition('Status', '2');
            }else if (trim($filterValue) == "reject") {
                $criteria->addSearchCondition('Status', '3');
            }
            if (!empty($searchText) && $searchText != "undefined" && $searchText != "null") {
                
                $namesArray = explode(" ",$searchText);                
                if(!empty($namesArray[0])){
                    if(!empty($namesArray[0])){
                        $firstName = trim($namesArray[0]);                        
                    }
                }
                if((isset($namesArray[1]) && !empty($namesArray[1]))){
                    $lastName = trim($namesArray[1]);
                }  
               
                $criteria->addSearchCondition('Email', trim($searchText));
                $criteria->addSearchCondition('FirstName', $firstName , true, "OR", "LIKE");                
                if(isset($lastName) && !empty($lastName)){                    
                    $criteria->addSearchCondition('FirstName', $firstName , true, "AND", "LIKE");
                    $criteria->addSearchCondition('LastName', $lastName , true, "AND", "LIKE");
                }else{
                   $criteria->addSearchCondition('LastName', $firstName , true, "OR", "LIKE");       
                }
                $criteria->addSearchCondition('FirstName', $searchText , true, "OR", "LIKE");
                $criteria->addSearchCondition('LastName', $searchText, true, "OR", "LIKE");
                 $roleId= UserType::model()->getRoleByName($searchText);               
                if($roleId !='false'){                   
                   $role=$roleId ;
                   $criteria->addSearchCondition('UserTypeId',$role,true,'OR','LIKE');
                  
                }
                
            }
            $result = User::model()->count($criteria);
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getUserProfileCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }

    /*
     * GetUserProfileByUserId: which takes 1 argument i.e userid
     * and returns an User Object.
     */

    public function getUserProfileByUserId($userid) {
        try {
            // $userProfileObject = User::model()->findByAttributes(array("UserId" => $userid));
            $userProfileObject = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('User u')
                    ->Join('CustomField cf',' u.UserId = cf.UserId')
                    ->Join('Countries cn',' u.Country = cn.Id')
                   // ->LeftJoin('Countries cn',' cn.Id = u.Country')                    
                    ->where('u.UserId=' . $userid)
                    ->queryRow();
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getUserProfileByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $userProfileObject;
    }

    /*
     * UpdateUserStatus: which takes 2 arguments 1: userId and 2: value.
     * This is used to update the status of an user.
     */

    public function updateUserStatus($userId, $value) {
        try {
            $return = "failed";

            $user = User::model()->findByAttributes(array("UserId" => $userId));
            if (isset($user)) {

                $user->Status = $value;
                if ($user->update()) {
                    $return = "success";
                }
            }
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:updateUserStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $return;
    }

    /*
     * This method checks whether the user with that email exist or not
     */

    public function checkUserEmailExist($model) {
        try {
            $result = 'failure';
            $user = User::model()->findByAttributes(array("Email" => $model->email));
            if (isset($user)) {
                $result = $user;
            } else {
                
            }
            return $result;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:checkUserEmailExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     *  @author VamsiKrishna
     *  @Description This method is used to update user by user Id and by field
     *  @params $userId
     *  @params $userId
     */

    public function updateUserByFieldByUserId($userId, $updateValue, $updateField) {
        try {

//            $userObj = User::model()->findByAttributes(array("UserId"=>$userId));
//            if(isset($userObj)){
//                $userObj->$updateField = $updateValue;
//                $userObj->update();
//            }
            $query = "Update User set $updateField = '" . $updateValue . "' where UserId = $userId";

            return YII::app()->db->createCommand($query)->execute();
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:updateUserByFieldByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * This method is to reset the password 
     * Here,new password is saved in Password and old password is moved to UpdatedPassword
     * Validates old passwords with newly entered passwod
     * Once user update password,PasswordResetToken column is set to 'reset'
     */

    public function resetPassword($model) {
        try {
            $user = User::model()->findByAttributes(array("Email" => $model->email, 'PasswordResetToken' => $model->md5UserId));

            if (isset($user)) {
                $PasswordPolicyFailMessage = '';
                $PasswordPolicyFailMessage = $this->passwordValidationWhileResetting($model->resetPass, $user);
                if ($PasswordPolicyFailMessage == '') {
                    $encrypted_salt = Yii::app()->params['ENCRYPTION_SALT'];
                    $password = md5($encrypted_salt . $model->resetPass);
                    $oldPassword1 = $user->Password;
                    $oldPassword2 = $user->UpdatedPassword;
                    if (($oldPassword1 != $password) && ($oldPassword2 != $password)) {
                        $user->UpdatedPassword = $user->Password;
                        $user->Password = $password;
                        $user->PasswordResetToken = 'reset';
                        if ($user->update()) {
                            MobileSessions::model()->resetPassword($user->UserId);
                            $PasswordPolicyFailMessage = '0'; // 0:if success
                        } else {
                            $PasswordPolicyFailMessage = '1'; // 1: if unable to update
                        }
                    } else {
                        $PasswordPolicyFailMessage = '2'; // 2: if old password matched with new matched
                    }
                } else {
                    $PasswordPolicyFailMessage;
                }
                return $PasswordPolicyFailMessage;
            }
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:resetPassword::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $PasswordPolicyFailMessage = '1';
        }
    }

    public function userAuthentication($email, $password) {
        try {
            $returnValue = 'noData';
            $isUserExists = $this->getUserByType($email, 'Email');
            
            if ($isUserExists!='noUser') {
                $userData = User::model()->findByAttributes(array('Email' => $email, 'Password' => $password));
             
                if (count($userData) == 1) {
                    if ($userData['Status'] == 1) {
                        $returnValue = 'success';
                    } else {
                        if ($userData['Status'] == 2)
                            $returnValue = 'suspend';
                        if ($userData['Status'] == 0)
                            $returnValue = 'register';
                        if ($userData['Status'] == 3)
                            $returnValue = 'contactAdmin';
                        
                        }
                        
                }else {
                    $returnValue = 'passwordIncorrect';
                }
            } else {
                $returnValue = 'wrongEmail';
            }


           return $returnValue; 
       } catch (Exception $ex) {           
            Yii::log("UserTaxAndRegulatoryInfo:userAuthentication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
      /** Author Vamsi Krishna
       * This method is used to get the User by Type
       * @param type $value 
       * @param type $type
       * @return type
       */

      public function  getUserByType($value,$type){   
      try {
      $returnValue='noUser';
      $userObj = User::model()->findByAttributes(array($type=>$value));           

          
      if(isset ($userObj)){   
      $returnValue=$userObj;
      }
      return $returnValue;
      } catch (Exception $ex) {
      Yii::log("UserTaxAndRegulatoryInfo:getUserByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
      }


      public function checkIfUserExist($email, $type) {
      try {
      $user = User::model()->findByAttributes(array($type => $email));
      if (isset($user)) {
      return true;
      } else {
      return false;
      }
      } catch (Exception $ex) {
          Yii::log("UserTaxAndRegulatoryInfo:checkIfUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in UserTaxAndRegulatoryInfo->checkIfUserExist==".$ex->getMessage());
      }
      }
  /**
   * this method is used to update the login time after the user logged in successfully 
   * @param type $email
   * @return string
   */
      public function updateUserForLoginTime($email) {
      try {
      $return = "failed";
      $user = User::model()->findByAttributes(array("Email" => $email));
      if (isset($user)) {
      $user->PreviousLastLoginDate = $user->LastLoginDate;
      $user->LastLoginDate = date('Y-m-d H:i:s', time());
      $user->userSessionsCount= ($user->userSessionsCount+1);
      if($user->userSessionsCount>=10)
      {
          $user->disableJoyRide=1; 
      }
      if ($user->update()) {
      $return = "success";
      }
      }
      } catch (Exception $ex) {
      Yii::log("UserTaxAndRegulatoryInfo:updateUserForLoginTime::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
      return $return;
      }

      public function checkUserExist($email) {
      try {
      $user = User::model()->findByAttributes(array('Email' => $email));
      return $user;
      } catch (Exception $ex) {
          Yii::log("UserTaxAndRegulatoryInfo:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in UserTaxAndRegulatoryInfo->checkUserExist==".$ex->getMessage());
      }
      }

      /*
     * Method used validate the password while resetting
     * Takes password as argument and compares with and db values and regular expression
     * based on the condition returns the validation message
     */

    public function passwordValidationWhileResetting($password, $object) {
        try{
        $message = '';
        /* check the password having user first name */
        if ($object->FirstName != "" && $object->LastName != "") {
            if ((strpos($password, $object->FirstName) !== false) || (strpos($password, $object->LastName) !== false)) {
                $message = Yii::t('translation', 'Password_Check_With_UserName');
                //$message="password can not be user name";
            }
        }


        /* check the password is an email */

        if (preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i", $password, $matches)) {
            $message = Yii::t('translation', 'Password_Check_With_Email');
            //$message="password can not be email";
        }

        /* check the password having domain name */

        if (strpos(strtolower($password), 'skipta') !== false) {
            $message = Yii::t('translation', 'Password_Check_With_Domain');
            // $message="password can not be domain name";
        }
        /* check the password having one special charater and one small letter and one numeric and one capital letter */
        if (!preg_match("/^.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*+_-]).*$/", $password, $matches)) {
            $message = Yii::t('translation', 'Password_Check_With_Password_Rules');
            //$message="Your password is too weak please enter strong password!";
        }
        } catch (Exception $ex) {
          Yii::log("UserTaxAndRegulatoryInfo:passwordValidationWhileResetting::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          }
        return $message;
    }
    public function updateUserType($userId, $userTypeId) {
        try {
            $return = "failed";
            $user = User::model()->findByAttributes(array("UserId" => $userId));
            if (isset($user)) {
                $user->UserTypeId = $userTypeId;
                if ($user->update()) {
                    $return = "success";
                }
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:updateUserType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
        
    }

    public  function checkUserIsActive($userId){
        try{ 
             $criteria = new CDbCriteria();
             $criteria->addSearchCondition('Status', '1');
             $criteria->addSearchCondition('UserId', $userId);
             $result = User::model()->find($criteria);
             if(is_object($result)){
                 return TRUE;
             }else{
                  return FALSE;
             }
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:checkUserIsActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                 return "failure";
        }
    }

    public function getUserDetailsByUserId($UserId) {
         $user='NoUser';
      try {
      $user = User::model()->findByAttributes(array('UserId' => $UserId));
      return $user;
      } catch (Exception $ex) {
          Yii::log("UserTaxAndRegulatoryInfo:getUserDetailsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in UserTaxAndRegulatoryInfo->getUserDetailsByUserId==".$ex->getMessage());
      }
      }
         /**
       * @author Karteek V
       * This is used to fetch the total no. of Users registered in the system..
       * @return type
       */
      public function getRegisteredUsersCount() {
        try {
            $usersCount = User::model()->count();
            return $usersCount;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getRegisteredUsersCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserTaxAndRegulatoryInfo->getRegisteredUsersCount==".$ex->getMessage());
        }
    }
    
      /**
     * @author suresh reddy
     * generate API AccessKey
     * @return type
     */
    public function generateAPIKeyForUser() {
        try {
            $randomNumber = mt_rand(1, 999999);
            $handle = md5($randomNumber . "" . time());
            while ($this->checkAPIAccessKeyExist($handle)) {
                $handle = md5($randomNumber . "" . time());
            }
            return $handle;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:generateAPIKeyForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author suresh reddy
     * generate API AccessKey
     * @return type
     */
    public function checkAPIAccessKeyExist($apiAccessKey) {
        try {
            // $userProfileObject = User::model()->findByAttributes(array("UserId" => $userid));
            $userProfileObject = Yii::app()->db->createCommand()
                    ->select('u.*')
                    ->from('User u')
                    //->Join('CustomField cf',' u.UserId = cf.UserId')
                    // ->LeftJoin('Countries cn',' cn.Id = u.Country')                    
                    ->where('u.APIAccessKey=' . "$apiAccessKey")
                    ->queryRow();
             return $userProfileObject;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:checkAPIAccessKeyExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       
    }
    
    /**
     * update user API access key for existing users.
     * @author suresh reddy
     * @param type $userId
     * @param type $userTypeId
     * @return string
     */
    
       public function updateAPIAccessKeyForExistingUsers($userId) {
        try {
            $return = "failed";
            $user = User::model()->findByAttributes(array("UserId" => $userId));
            if (isset($user)) {
            $user->APIAccessKey=  $this->generateAPIKeyForUser();
                if ($user->update()) {
                    $return = "success";
                }
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:updateAPIAccessKeyForExistingUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
        
    }
    

      public function getAllRegistrationsBetweenDates($startDate,$endDate,$NetworkId,$datemode) {
        try {
            $returnvalue = "failure";
            $startDate=date('Y-m-d',strtotime($startDate));
            $endDate=date('Y-m-d',strtotime($endDate));
            $criteria = new EMongoCriteria;
//            $endDate =$endDate." 23:59:59";
//            $startDate =$startDate." 00:00:00";
//            
//            
//            $startDate=date('Y-m-d H:i:s',strtotime($startDate));
//            $endDate=date('Y-m-d H:i:s',strtotime($endDate));
//           
           $query = "SELECT count(UserId)as count, $datemode(RegistredDate) as CreatedDate FROM User WHERE NetworkId='$NetworkId' and RegistredDate BETWEEN('$startDate')AND('$endDate') group by $datemode(RegistredDate) " ;
           //$query = "SELECT count(UserId)as user FROM User WHERE NetworkId='$NetworkId' and DATE_FORMAT(RegistredDate, '%Y-%m-%d')  BETWEEN('$startDate')AND('$endDate')";
          //  $query = "SELECT count(UserId)as user FROM User WHERE DATE_FORMAT(RegistredDate, '%Y-%m-%d')= '$startDate'";
            $results = Yii::app()->db->createCommand($query)->queryAll();

//            if (is_array($results)) {
//                $returnvalue = (int)$results['0']['user'];
//            }

            return $results;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getAllRegistrationsBetweenDates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function saveCuratorAccessToken($userId,$accessToken)  {
       try{
        $query = "update User set CuratorAccessToken = '".$accessToken."' where UserId=".$userId;
       $results = Yii::app()->db->createCommand($query)->execute();
       } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getAllRegistrationsBetweenDates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getCuratorAccessToken($url) {
       try{
       $query = "Select * from NetWork where NetworkURL='".$url."'";
       $data = Yii::app()->db->createCommand($query)->queryRow();
       return $data;
       } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getCuratorAccessToken::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getActiveUsers($users){
        try {
            $returnValue='failure';
            $query="select UserId from User where UserId in  (".implode(',',$users).") and Status=1";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getActiveUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
    public function getUserByMigratedUserId($migratedUserId){
        try {
            $returnValue='failure';
            $query="select UserId from User where MigratedUserId ='".$migratedUserId."'";            
             $users = Yii::app()->db->createCommand($query)->queryRow();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getUserByMigratedUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserTaxAndRegulatoryInfo->getUserByMigratedUserId==".$ex->getMessage());
        }
        }  
        
        public function enableOrDisableJoyRide($action,$userId)
        {
            
             try {
               $query = "update User set disableJoyRide = ".$action." where UserId=".$userId;
               $results = Yii::app()->db->createCommand($query)->execute();
            } catch (Exception $ex) {
                Yii::log("UserTaxAndRegulatoryInfo:enableOrDisableJoyRide::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                error_log("Exception Occurred in UserTaxAndRegulatoryInfo->enableOrDisableJoyRide==".$ex->getMessage());
            }
            
            return $results;
        }

        
         public function getAllActiveUsers(){
        try {
            $returnValue='failure';
            $query="select UserId from User where  Status=1";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getAllActiveUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
        public function getAllActiveUsersByNetworkName($networkName){
        try {
            $returnValue='failure';
            $query="select UserId from User where  Status=1 and FromNetwork='$networkName'";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(sizeof($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getAllActiveUsersByNetworkName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
         public function getAllActiveUserInfoByNetworkName($networkName){
        try {
            $returnValue='failure';
            $query="select Email from User where  Status=1 and FromNetwork='$networkName'";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(sizeof($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getAllActiveUserInfoByNetworkName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }

        public function isNetworkUser($userId)
        {
            try {
            $query="select count(UserId) from User where UserId =".$userId." and Email like'".YII::app()->params['NetworkAdminEmail']."'";            
            $users = Yii::app()->db->createCommand($query)->queryRow();
            return $users;
        } catch (Exception $ex) {
           Yii::log("UserTaxAndRegulatoryInfo:isNetworkUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
           error_log("Exception Occurred in UserTaxAndRegulatoryInfo->isNetworkUser==".$ex->getMessage());
        }
            
        }

   public function updateUser($profileModel,$userId) {
        try {
            $userObj = $this->getUserDetailsByUserId($userId);
            $returnValue = false;
            $userObj->UserId=$userId;
            $userObj->FirstName = $profileModel['firstName'];
            $userObj->LastName = $profileModel['lastName'];
            $userObj->DisplayName = $profileModel['firstName'] . $profileModel['lastName'];
            $userObj->Email = $profileModel['email'];
            $userObj->Country = $profileModel['country'];;
            $userObj->State = $profileModel['state'];
            $userObj->City = $profileModel['city'];
            $userObj->Zip = $profileModel['zip'];
            $userObj->Company = $profileModel['companyName'];
            
            if ($userObj->update()) {
               $returnValue="success"; 
            }   
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:updateUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserTaxAndRegulatoryInfo->updateUser==".$ex->getMessage());
        }
    } 
    
    public function updateUserPassword1($userId,$password){
        try {
             $encryption_salt = Yii::app()->params['ENCRYPTION_SALT'];
             $password = md5($encryption_salt . $password);
               $query = "update User set disableJoyRide = ".$action." where UserId=".$userId;
               $results = Yii::app()->db->createCommand($query)->execute();
            } catch (Exception $ex) {
               Yii::log("UserTaxAndRegulatoryInfo:updateUserPassword1::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
               error_log("Exception Occurred in UserTaxAndRegulatoryInfo->updateUserPassword1==".$ex->getMessage());
            }
            
            return $results;  
        
    }
    
        public function updateUserPassword($userId,$model) {
        try {
            $user = User::model()->findByAttributes(array("UserId" =>$userId ));
            $encrypted_salt = Yii::app()->params['ENCRYPTION_SALT'];
            if($user->Password==md5($encrypted_salt . $model->password)){
               if (isset($user)) {
                $PasswordPolicyFailMessage = '';
                $PasswordPolicyFailMessage = $this->passwordValidationWhileResetting($model->newPassword, $user);
                
                if ($PasswordPolicyFailMessage == '') {
                    
                    $password = md5($encrypted_salt . $model->newPassword);
                    $oldPassword1 = $user->Password;
                    $oldPassword2 = $user->UpdatedPassword;
                    if (($oldPassword1 != $password) && ($oldPassword2 != $password)) {
                        $user->UpdatedPassword = $user->Password;
                        $user->Password = $password;
//                        $user->PasswordResetToken = 'reset';
                        if ($user->update()) {
                            MobileSessions::model()->resetPassword($user->UserId);
                            $PasswordPolicyFailMessage = '0'; // 0:if success
                        } else {
                            $PasswordPolicyFailMessage = '1'; // 1: if unable to update
                        }
                    } else {
                        $PasswordPolicyFailMessage = '2'; // 2: if old password matched with new matched
                    }
                } else {
                    $PasswordPolicyFailMessage;
                }
                return $PasswordPolicyFailMessage;
            }  
            }
            else{
                $PasswordPolicyFailMessage = '3'; // 2: if entered password does't matched with existing password  
            }

           
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:updateUserPassword::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $PasswordPolicyFailMessage = '1';
        }
        return $PasswordPolicyFailMessage;
    }
    
    
     public function updateUserIdentityType($userId, $userTypeId) {
        try {
            $return = "failed";
            $user = User::model()->findByAttributes(array("UserId" => $userId));
            if (isset($user)) {
                $user->UserIdentityType = $userTypeId;
                if ($user->update()) {
                    $return = "success";
}
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:updateUserIdentityType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
        
    }
    public function getSurveyTakenUsersInfoData($surveyId,$scheduleId){
        try{
            $returnValue = "failure";
            $query = "SELECT U.UserId,U.Email,utr.FirstName,utr.LastName ,MedicalSpecialty as `Medical Specialty`,utr.Address1,utr.Address2,utr.City,utr.State,utr.Zip,utr.Phone,concat(nsn.NPINumber,'-',group_concat(Distinct st.StateCode)) as `NPI State-NPI Number`,group_concat(Distinct concat(s.StateCode,'-',LicensedNumber)) as `Licensed State-Licensed Number`,FederalTaxIdOrSSN as `Federal TaxId Or SSN`  FROM UserTaxAndRegulatoryInfo utr "
                        ." LEFT Join User U on U.UserId = utr.UserId"
                        ." LEFT Join LicensedStatesAndNumbers lsn on utr.id = lsn.UserTaxAndRegulatoryInfoId " 
                        ." Left Join State s on lsn.LicensedState = s.id left Join NPIStatesAndNumber nsn on utr.id = nsn.UserTaxAndRegulatoryInfoId "
                        ." Left Join State st on nsn.NPIState = st.id "                    
                    . " where SurveyId='".$surveyId."' and ScheduleId='".$scheduleId."' group by utr.UserId";
            $results = Yii::app()->db->createCommand($query)->queryAll(); 
            if(count($results)>0){
                 $returnValue= $results;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getSurveyTakenUsersInfoData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserTaxAndRegulatoryInfo->getSurveyTakenUsersInfoData==".$ex->getMessage());
        }
    }
    
    public function getUserInfo($userId){
        try{
            $returnValue = "failure";            
            $Criteria = new CDbCriteria();
            $Criteria->condition = "UserId=$userId";
            $Criteria->limit = 1;
            $returnValue = UserTaxAndRegulatoryInfo::model()->findAll($Criteria);
            if(isset($returnValue[0]))
                $returnValue = $returnValue[0];
            return $returnValue;
//            $user = UserTaxAndRegulatoryInfo::model()->findByAttributes(array("UserId" => $userId));
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getUserInfo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserTaxAndRegulatoryInfo->getUserInfo==".$ex->getMessage());
        }
    }
    public function getSurveyTakenUserIds($surveyId,$scheduleId){
        try{
            $returnValue = array();  
            $query = "Select UserId from UserTaxAndRegulatoryInfo where SurveyId='$surveyId' and ScheduleId = '$scheduleId'";
            $results = Yii::app()->db->createCommand($query)->queryAll();
            $results_userIds = array();
            $i = 0;
            foreach($results as $rw){
                $results_userIds[$i++] = $rw['UserId'];
            }
            if(count($results_userIds)>0){
                 $returnValue= $results_userIds;
             }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserTaxAndRegulatoryInfo:getSurveyTakenUserIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}
