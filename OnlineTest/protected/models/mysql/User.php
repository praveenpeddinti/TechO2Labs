<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends CActiveRecord {

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
    public $Address1;
    public $Address2;
    public $Zip;
    public $Latitude;
    public $Longitude;
    public $Status;
    public $UpdatedPassword;
    public $Company;
    public $PasswordResetToken;
    public $CustomFieldId;
    public $NetworkId;
    public $PreviousLastLoginDate;
    public $cookieRandomKey;
    public $UserTypeId=2;
    public $UserType;
    public $Level;
    public $JobCode;
    public $APIAccessKey;
    public $CuratorAccessToken;
    public $ReferenceUserId;
    public $migratedUserId;
    public $userSessionsCount=0;
    public $disableJoyRide=0;
    public $referralLinkId;
    public $referralUserEmail;
    public $AccessToken;
    public $FromNetwork;
    public $UserIdentityType=0;
    public $SegmentId=0;
    public $SegmentName="";
    public $ChangedCountry;
    public $CountryRequest=0;
    public $UserClassification=1;
    public $GeoDirty=0;
    public $ChangedState;
    public $ChangedCity;
    public $ChangedZip;
    //   public $Designation ;
    public $NPINumber;
    public $HavingNPINumber=1;
    public $IsSpecialist;
    public $IsStudentOrResident;
    public $StudentOrResidentEmail;
    public $AboutMe;
    public $StudentAccessToken;    

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'User';
    }

    public function saveUser($profileModel) {
        try {
            $returnValue = false;
            $userObj = new User();

            $userObj->FirstName = $profileModel['firstName'];
            $userObj->LastName = $profileModel['lastName'];
            $userObj->DisplayName = $profileModel['firstName'] . $profileModel['lastName'];
            /*
             * find md5 string 
             */
            $encryption_salt = Yii::app()->params['ENCRYPTION_SALT'];
            if (CommonUtility::isValidMd5($profileModel['pass'])) {//*********for data migration
                $userObj->Password = strtolower($profileModel['pass']);
                $userObj->RegistredDate = $profileModel['registredDate'];
                $userObj->LastLoginDate = $profileModel['lastLoginDate'];
            } else {//****************for new user registration
                $userObj->Password = md5($encryption_salt . $profileModel['pass']);
                $userObj->RegistredDate = date('Y-m-d H:i:s', time());
                $userObj->LastLoginDate = '';
            }

            $userObj->OldPassowrd1 = '';
            $userObj->OldPassowrd2 = '';
            $userObj->Email = $profileModel['email'];
            $userObj->Country = $profileModel['country'];
            $userObj->State = $profileModel['state'];
            $userObj->City = $profileModel['city'];
            $userObj->Zip = $profileModel['zip'];
            $userObj->Status = isset($profileModel['status'])?$profileModel['status']:0;
            $userObj->Company = $profileModel['companyName'];
            $userObj->PasswordResetToken = '';
            $userObj->CustomFieldId = '';
            $userObj->NetworkId = $profileModel['network'];
            $userObj->SegmentId = $profileModel['segmentId'];
        
              $userObj->UserClassification = (int)1;
            $userObj->UserIdentityType = 0;
             $userObj->APIAccessKey=  $this->generateAPIKeyForUser();
             $userObj->ReferenceUserId = $profileModel['referenceUserId'];
             $userObj->migratedUserId = isset($profileModel['migratedUserId'])?$profileModel['migratedUserId']:"";
             $userObj->referralLinkId = $profileModel['referralLinkId'];
             $userObj->referralUserEmail = $profileModel['referralUserEmail'];
             if (isset($profileModel['referenceUserId']) && $profileModel['referenceUserId'] == 0) {
                $ReferedUserDetails = UserLinks::model()->CheckRecipienthasReferrer($profileModel['email']);
                $userObj->ReferenceUserId = $ReferedUserDetails['ReferrerUserId'];
                $userObj->referralLinkId = $ReferedUserDetails['LinkId'];
                $userObj->referralUserEmail = $ReferedUserDetails['RecipientEmail'];
            }
             if(isset($profileModel['accessToken']))
            {
             $userObj->AccessToken=$profileModel['accessToken'];
             $userObj->FromNetwork=$profileModel['fromNetwork'];
            }
             $userObj->GeoDirty = 1;
            
             if($profileModel['IsSpecialist'] == 2){
                  $userObj->IsSpecialist = 0;
                   if($profileModel['IsStudentOrResident'] == 2){
                  $userObj->IsStudentOrResident = 0;
                  $userObj->AboutMe = $profileModel['aboutMe'];
                  }else{
                  $userObj->IsStudentOrResident = $profileModel['IsStudentOrResident'];
                  $userObj->StudentOrResidentEmail = $profileModel['StudentOrResidentEmail'];
                  }
             }else{
                  $userObj->IsSpecialist = $profileModel['IsSpecialist'];
                  $userObj->HavingNPINumber = $profileModel['HavingNPINumber'];
                   if($profileModel['HavingNPINumber'] == 1){
                         $userObj->NPINumber = $profileModel['NPINumber'];
                    }
             }
             
              
            if ($userObj->save()) {

                 if($profileModel['IsSpecialist'] == 1){
                     User::model()->updateStateLicenseNumber($profileModel,$userObj->UserId); 
                 }
               
                  Yii::app()->amqp->stream(json_encode(array("Obj"=>$userObj,"ActionType"=>"GeoLocation","Type"=>"User")));  

                $returnValue = $userObj->UserId;
            }
       //The below code is used to update the referral details     
            if($userObj->referralLinkId!="" && $userObj->referralUserEmail!=""){
               
                 $UserDetails = UserLinks::model()->checkRecipientEmailExist($userObj->referralUserEmail,$userObj->referralLinkId);
                 
            }
      //-----End-----------------      
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:saveUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
    
    /*
     * GetUserProfile: which takes 4 arguments and 
     * by default 2 arguments are initialized with default values those are startLimit = 0 and pageLength = 10;
     * and this function returns Users Object.
     */

    public function getUserProfile($filterValue, $searchText, $startLimit = 0, $pageLength = 10, $segmentId=0) {
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
            }else if (trim($filterValue) == "countryChange") {
                $criteria->addSearchCondition('CountryRequest', 1);
            }else if (trim($filterValue) == "studentpending") {
                $criteria->addSearchCondition('Status', '4');
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
            if($segmentId!=0){
                $criteria->addSearchCondition('SegmentId', (int)$segmentId);
            }
            $criteria->order = 'RegistredDate DESC, LastName,FirstName';
            $criteria->offset = $startLimit;
            $criteria->limit = $pageLength;
            $result = User::model()->findAll($criteria);
            for ($i = 0; $i < sizeof($result); $i++) {
                $result[$i]->RegistredDate = date("m/d/Y", strtotime($result[$i]->RegistredDate));
                $userTypeObject = UserType::model()->getUserTypeObjectById($result[$i]->UserTypeId);
                $result[$i]->UserType = $userTypeObject->Name;
                $attributeArray = array("SegmentId" => (int)$result[$i]->SegmentId);
                $segmentObj = Segment::model()->getSegmentByAttributes($attributeArray);
                $result[$i]->SegmentName = $segmentObj->SegmentName;
            }
        } catch (Exception $ex) {
            Yii::log("User:getUserProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }

    /*
     * GetUserProfileCount: which takes 2 arguments and 
     * returns the total no. of users.
     */

    public function getUserProfileCount($filterValue, $searchText, $segmentId=0) {
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
            }else if (trim($filterValue) == "countryChange") {
                $criteria->addSearchCondition('CountryRequest', 1);
            }else if (trim($filterValue) == "studentpending") {
                $criteria->addSearchCondition('Status', '4');
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
            if($segmentId!=0){
                $criteria->addSearchCondition('SegmentId', (int)$segmentId);
            }
            $result = User::model()->count($criteria);
        } catch (Exception $ex) {
            Yii::log("User:getUserProfileCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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

            $subcondition=""; 
            $subspecialty="";
            if(isset(Yii::app()->params['GroupMappingField']) && !empty(Yii::app()->params['GroupMappingField'])){
              $GroupMappingField = Yii::app()->params['GroupMappingField'];
              $subcondition="cf.".$GroupMappingField."=sub.id";
              $subspecialty='Subspecialty sub';
             }

            $userProfileObject = Yii::app()->db->createCommand()
                    ->select('*,u.UserId')
                    ->from('User u')
                    ->LEFTJoin('CustomField cf',' u.UserId = cf.UserId')
                    ->LEFTJoin('LicensedStatesAndNumbers ls',' u.UserId = ls.UserId')
                    ->LEFTJoin('Countries cn',' u.Country = cn.Id')
                   // ->LeftJoin('Countries cn',' cn.Id = u.Country')                    
                    ->where('u.UserId=' . $userid);
                  if($subcondition!=""){ 
                      $userProfileObject= $userProfileObject->select('*,u.UserId,sub.Value')->LEFTJoin($subspecialty,$subcondition);
                  }
                  $userProfileObject=  $userProfileObject->queryRow();
        } catch (Exception $ex) {
            Yii::log("User:getUserProfileByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:updateUserStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:checkUserEmailExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:updateUserByFieldByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:resetPassword::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:userAuthentication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
      Yii::log("User:getUserByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
          Yii::log("User:checkIfUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      error_log("Exception Occurred in User->checkIfUserExist### ".$ex->getMessage());
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
         // $user->disableJoyRide=1; 
      }
      else
            $user->disableJoyRide=0; 
      if ($user->update()) {
      $return = "success";
      }
      }
      } catch (Exception $ex) {
      Yii::log("User:updateUserForLoginTime::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
      return $return;
      }

      public function checkUserExist($email) {
      try {
      $user = User::model()->findByAttributes(array('Email' => $email));
      return $user;
      } catch (Exception $ex) {
          Yii::log("User:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      error_log("Exception Occurred in User->checkUserExist### ".$ex->getMessage());
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
        return $message;
        } catch (Exception $ex) {
          Yii::log("User:passwordValidationWhileResetting::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
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
            Yii::log("User:updateUserType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:checkUserIsActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                 return "failure";
        }
    }

    public function getUserDetailsByUserId($UserId) {
         $user='NoUser';
      try {
      $user = User::model()->findByAttributes(array('UserId' => $UserId));
      return $user;
      } catch (Exception $ex) {
          Yii::log("User:getUserDetailsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      error_log("Exception Occurred in User->getUserDetailsByUserId### ".$ex->getMessage());
      }
      }
         /**
       * @author Karteek V
       * This is used to fetch the total no. of Users registered in the system..
       * @return type
       */
      public function getRegisteredUsersCount($segmentId=0) {
        try {
            $criteria = array();
            if($segmentId!=0){
                $criteria = array('SegmentId' => $segmentId);
            }
            $usersCount = User::model()->count($criteria);
            return $usersCount;
        } catch (Exception $ex) {
            Yii::log("User:getRegisteredUsersCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in User->getRegisteredUsersCount### ".$ex->getMessage());
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
            Yii::log("User:generateAPIKeyForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
                    ->where('u.APIAccessKey=' . "'".$apiAccessKey."'")
                    ->queryRow();
             return $userProfileObject;
        } catch (Exception $ex) {
            Yii::log("User:checkAPIAccessKeyExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:updateAPIAccessKeyForExistingUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
        
    }
    

      public function getAllRegistrationsBetweenDates($startDate,$endDate,$NetworkId,$datemode, $segmentId=0) {
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
           $query = "SELECT count(UserId)as count, $datemode(RegistredDate) as CreatedDate FROM User WHERE NetworkId=$NetworkId and RegistredDate BETWEEN('$startDate')AND('$endDate') group by $datemode(RegistredDate) " ;
           if($segmentId!=0){
               $query = "SELECT count(UserId)as count, $datemode(RegistredDate) as CreatedDate FROM User WHERE NetworkId=$NetworkId and SegmentId=$segmentId and RegistredDate BETWEEN('$startDate')AND('$endDate') group by $datemode(RegistredDate) " ;
           }
           //$query = "SELECT count(UserId)as user FROM User WHERE NetworkId='$NetworkId' and DATE_FORMAT(RegistredDate, '%Y-%m-%d')  BETWEEN('$startDate')AND('$endDate')";
          //  $query = "SELECT count(UserId)as user FROM User WHERE DATE_FORMAT(RegistredDate, '%Y-%m-%d')= '$startDate'";
            $results = Yii::app()->db->createCommand($query)->queryAll();

//            if (is_array($results)) {
//                $returnvalue = (int)$results['0']['user'];
//            }

            return $results;
        } catch (Exception $ex) {
            Yii::log("User:getAllRegistrationsBetweenDates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function saveCuratorAccessToken($userId,$accessToken) {
       try{
        $query = "update User set CuratorAccessToken = '".$accessToken."' where UserId=".$userId;
       $results = Yii::app()->db->createCommand($query)->execute();
       } catch (Exception $ex) {
            Yii::log("User:saveCuratorAccessToken::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getCuratorAccessToken($url) {
       try{
       $query = "Select * from NetWork where NetworkURL='".$url."'";
       $data = Yii::app()->db->createCommand($query)->queryRow();
       return $data;
       } catch (Exception $ex) {
            Yii::log("User:getCuratorAccessToken::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:getActiveUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:getUserByMigratedUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in User->getUserByMigratedUserId### ".$ex->getMessage());
        }
        }  
        
        public function enableOrDisableJoyRide($action,$userId)
        {
            
             try {
               $query = "update User set disableJoyRide = ".$action." where UserId=".$userId;
               $results = Yii::app()->db->createCommand($query)->execute();
            } catch (Exception $ex) {
                Yii::log("User:enableOrDisableJoyRide::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
               error_log("Exception Occurred in User->enableOrDisableJoyRide### ".$ex->getMessage());
            }
            
            return $results;
        }

        
         public function getAllActiveUsers(){
        try {
            $returnValue='failure';
            $query="select UserId,RegistredDate from User where  Status=1";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getAllActiveUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:getAllActiveUsersByNetworkName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("User:getAllActiveUserInfoByNetworkName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }

        public function isNetworkUser($userId)
        {
            try {
            $query="select count(UserId) from User where UserId =".$userId." and Email like'".YII::app()->params['NetworkAdminEmail']."'";            
            $users = Yii::app()->db->createCommand($query)->queryRow();
            return $users;
        } catch (Exception $ex) {
            Yii::log("User:isNetworkUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in User->isNetworkUser### ".$ex->getMessage());
        }
            
        }
       /*
     * UpdateUserStatus: which takes 2 arguments 1: userId and 2: value.
     * This is used to update the status of an user.
     */

   public function updateUser($profileModel,$userId) {
        try {
            $userObj = $this->getUserDetailsByUserId($userId);
            $returnValue = false;
            $userObj->UserId=$userId;
            $userObj->FirstName = $profileModel['firstName'];
            $userObj->LastName = $profileModel['lastName'];
            $userObj->DisplayName = $profileModel['firstName'] . $profileModel['lastName'];
            $userObj->Email = $profileModel['email'];
           // $userObj->Country = $profileModel['country'];;
            if($userObj->Country==$profileModel['country']){
               $userObj->State = $profileModel['state'];
               $userObj->City = $profileModel['city'];
               $userObj->Zip = $profileModel['zip']; 
               
                $locationObj = new UserLocationZionBean();
                $locationObj->AccessKey = Yii::app()->params['AccessKey'];
                $locationObj->CommunityId = Yii::app()->params['NetWorkId'];
                $locationObj->UserId = $userId;
                $locationObj->City = $userObj->City;
                $locationObj->State = $userObj->State;
                $locationObj->Country = $userObj->Country;
                $locationObj->Zip = $userObj->Zip;
                $locationAPI = Yii::app()->params['LocationAPI'];
                CommonUtility::sendDataToZionRestCall($locationAPI,$locationObj);
            }
            
            $userObj->Company = $profileModel['companyName'];
            $userObj->GeoDirty = 1;
                      
             if($profileModel['IsSpecialist'] == 2){
                  $userObj->IsSpecialist = 0;
                   if($profileModel['IsStudentOrResident'] == 2){
                  $userObj->IsStudentOrResident = 0;
                  $userObj->AboutMe = $profileModel['aboutMe'];
                  }else{
                  $userObj->IsStudentOrResident = $profileModel['IsStudentOrResident'];
                  $userObj->StudentOrResidentEmail = $profileModel['StudentOrResidentEmail'];
                  }
             }else{
                  $userObj->IsSpecialist = $profileModel['IsSpecialist'];
                  $userObj->HavingNPINumber = $profileModel['HavingNPINumber'];
                   if($profileModel['HavingNPINumber'] == 1){
                         $userObj->NPINumber = $profileModel['NPINumber'];
                    }
             }
             
             
             
             
            if ($userObj->update()) {

                User::model()->updateStateLicenseNumber($profileModel,$userObj->UserId);
                
                $professionObj = new UserProfessionZionBean();
                $professionObj->AccessKey = Yii::app()->params['AccessKey'];
                $professionObj->CommunityId = Yii::app()->params['NetWorkId'];
                $professionObj->UserId = $userId;
                if($profileModel['HavingNPINumber'] == 1){
                    $professionObj->NPINumber = $profileModel['NPINumber'];
                }else{
                    $licensedStates="";
                    if(isset($profileModel['state'])){
                      $licensedStates =$profileModel['state'];
                   }else{
                       $licensedStates =$profileModel['State'];  
                   }
                   $professionObj->License = array($profileModel['StateLicenseNumber']=>$licensedStates);
                }
                $url = Yii::app()->params['ProfessionAPI'];
                Yii::app()->amqp->stream(json_encode(array("Obj"=>array("UserId"=>$userId,"Country"=>$userObj->Country,"State"=>$userObj->State,"City"=>$userObj->City,"Zip" =>$userObj->Zip,"Address1"=>"","Address2"=>""),"ActionType"=>"GeoLocation","Type"=>"User")));  

                CommonUtility::sendDataToZionRestCall($url,$professionObj);
                
               $returnValue="success"; 
            }   
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:updateUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in User->updateUser### ".$ex->getMessage());
        }
    } 
    
    public function updateUserPassword1($userId,$password){
        try {
             $encryption_salt = Yii::app()->params['ENCRYPTION_SALT'];
             $password = md5($encryption_salt . $password);
               $query = "update User set disableJoyRide = ".$action." where UserId=".$userId;
               $results = Yii::app()->db->createCommand($query)->execute();
            } catch (Exception $ex) {
                Yii::log("User:updateUserPassword1::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
               error_log("Exception Occurred in User->updateUserPassword1### ".$ex->getMessage());
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
            Yii::log("User:updateUserPassword::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $PasswordPolicyFailMessage = '1';
        }
        return $PasswordPolicyFailMessage;
    }
    
     public function updateCountryandNetworkByUserId($userId, $countryId, $networkId,$lang,$segmentId) {
        try {
            $return = "failed";

            $user = User::model()->findByAttributes(array("UserId" => $userId));
            if (isset($user)) {

                $user->Country = $countryId;
                $user->ChangedCountry = 0;
                $user->CountryRequest = 0;
                $user->State = $user->ChangedState ;
                $user->City = $user->ChangedCity;
                $user->Zip = $user->ChangedZip;
                $user->ChangedZip = null;
                $user->ChangedCity = null;
                $user->ChangedState = null;
                $user->NetworkId = $networkId;
                $user->SegmentId = $segmentId;
                if ($user->update()) {
                    $return = "success";
                    UserCollection::model()->updateNetworkByUserId($userId,$networkId,$lang,$segmentId,$countryId);
                    UserCollection::model()->updateUserTinyCollection($user);
                    }
                
            }
        } catch (Exception $ex) {
            Yii::log("User:updateCountryandNetworkByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $return;
    }
    public function requestForChangeCountry($userId, $countryId,$state,$city,$zip) {
        try {
            $return = "failed";
            $user = User::model()->findByAttributes(array("UserId" => $userId));
            if (isset($user)) {
                if($user->Country==$countryId){
                    $return = "same";
                }else{
                    $user->ChangedCountry = $countryId;
                    $user->CountryRequest = 1;
                    $user->ChangedState = $state;
                    $user->ChangedCity = $city;
                    $user->ChangedZip = $zip;
                    if ($user->update()) {
                        $return = "success";
                    }
                }
            }
        } catch (Exception $ex) {
            Yii::log("User:requestForChangeCountry::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $return;
    }
     public function rejectChangeCountry($userId) {
        try {
            $return = "failed";
            $user = User::model()->findByAttributes(array("UserId" => $userId));
            if (isset($user)) {
                $user->CountryRequest = 2;
                if ($user->update()) {
                    $return = "success";
                }
            }
        } catch (Exception $ex) {
            Yii::log("User:rejectChangeCountry::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $return;
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
            Yii::log("User:updateUserIdentityType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
        
    }
    
    public function updateUserById($model,$pid) {
        try {
            $return = "failed";
            $userObj = User::model()->findByAttributes(array("UserId" => $model->UserId));            
            if (isset($userObj)) {
                $userObj->FirstName = $model->FirstName;
                $userObj->LastName = $model->LastName;            
                $userObj->State = $model->State;
                $userObj->City = $model->City;
                $userObj->Zip = $model->Zip; 
                $userObj->Address1 = $model->Address1; 
                $userObj->Address2 = $model->Address2; 
                $userObj->GeoDirty = 1;
                $userObj->HavingNPINumber = $model->HavingNPINumber;
             if($model->HavingNPINumber == 1){
                  $userObj->NPINumber = $model->NPINumber;
             }
                if ($userObj->update()) {

                    User::model()->updateStateLicenseNumber($model,$userObj->UserId,$pid);
                    Yii::app()->amqp->stream(json_encode(array("Obj"=>$userObj,"ActionType"=>"GeoLocation","Type"=>"User")));
                    $return = "success";
}
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("User:updateUserById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in User->updateUserById### ".$ex->getMessage());
            return "failure";
        }
        
    }
    /* 
     * Below 2 methods are used to update or fetch something from Custom Field 
     * 
     */
    public function getCustomFieldsByUserId($userId){
        try{
            $customObj = CustomField::model()->findByAttributes(array("UserId"=>$userId));  
            return $customObj;
        }catch(Exception $ex){
            Yii::log("User:getCustomFieldsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in User->getCustomFieldsByUserId### ".$ex->getMessage());
        }
        
    }
    
    public function updateCustomFieldsByUserId($licNumber,$model){
            try{
                $status = 0;
                $customObj = CustomField::model()->findByAttributes(array("UserId"=>$model->UserId));
                if(isset($customObj) && sizeof($customObj)>0){
                    if(isset($customObj->StateLicenseNumber)){
                        $customObj->StateLicenseNumber = $licNumber;
                        $status = 1;
                    }
                    if(isset($customObj->NPINumber)){
                        $customObj->NPINumber = $model->NPINumber;
                        $status = 1;
                    }
                    if($status == 1){
                        $customObj->update();
                    }
                }
            }catch(Exception $ex){
                Yii::log("User:updateCustomFieldsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                error_log("Exception Occurred in User->updateCustomFieldsByUserId### ".$ex->getMessage());
            }
        }
        /*End Custom methods         */
        
        public function getDetailsByUserIds($userIds){
            try{
                $returnValue = "failure";
                $results = array();
                for($i=0;$i<sizeof($userIds);$i++){
                    $query = "Select UserId,Email,FirstName,LastName, '' as MedicalSpecialty,'' as Address1, '' as Address2,City,State,Zip,'' as Phone,'' as `NPI State-NPI Number`,'' as `Licensed State-Licensed Number`,'' as `Federal TaxId Or SSN` from User where UserId = ".$userIds[$i];
                    
                    $result = Yii::app()->db->createCommand($query)->queryRow();                    
                    array_push($results,$result);
                    
                }
                if(count($results)>0){
                 $returnValue= $results;
             }
             return $returnValue;
            } catch (Exception $ex) {
                Yii::log("User:getDetailsByUserIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                 error_log("Exception Occurred in User->getDetailsByUserIds### ".$ex->getMessage());
            }
        }
        
   public function getAllNotLoggedInUsersFromPastFourdays(){
        try {
            $returnValue='failure';
            $query="select *  from User where LastLoginDate!=0 and LastLoginDate <= (NOW() - INTERVAL 4 DAY)";        
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getAllNotLoggedInUsersFromPastFourdays::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
  /*@Author Haribabu
   * This method is updated by haribabu
   * added Status and in query check user is in Acitve or not.
   * check user in NewUser_SurveyEmailList for user already got 14 day survey email or not
   * 
   * 
   */
        public function getAllNewUsersEligableForNewUserSurvey($noOfDays=15) {
        try {
            $returnValue = array();
            $query = "select *  from User where UserClassification=1 and Status=1 and UserId not in(select UserId from NewUser_SurveyEmailList ) and date(RegistredDate) = date((NOW() - INTERVAL $noOfDays DAY))";
            $users = Yii::app()->db->createCommand($query)->queryAll();
            if (count($users) > 0) {
                $returnValue = $users;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getAllNewUsersEligableForNewUserSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


        
         public function getAllUsers(){
        try {
            $returnValue='failure';
            $query="select * from User";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getAllUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        /**
         * @usage update user classfication id on userid
         * @param type $userId
         * @param type $classfication
         * @return is boolean
         */
           public function updateUserClassfication($userId, $classfication) {
        try {
            $return =false;

            $user = User::model()->findByAttributes(array("UserId" => $userId));
            if (isset($user)) {

                $user->UserClassification = $classfication;
                if ($user->update()) {
                    $return = true;
                }
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("User:updateUserClassfication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $return =false;
        }
    }


     public function getAllUsersLocation(){
         try{
            $returnValue= array();
             $query="SELECT UserId,(select Code from Countries where Id=U.Country) Country,City,State,Zip,Address1,Address2 FROM User U where U.Latitude is  null or U.Latitude='' or U.GeoDirty = 1";   
             $users = Yii::app()->db->createCommand($query)->queryAll();
              if(count($users)>0){
                 $returnValue= $users;
             }
              return $returnValue; 
         } catch (Exception $ex) {
             Yii::log("User:getAllUsersLocation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
     }
     public function updateUserGeoCoordinates($latitude,$longitude,$userId){
          try {
            $return = "failed";
            $userObj = User::model()->findByAttributes(array("UserId" => $userId));            
            if (isset($userObj)) {
                $userObj->Latitude = $latitude;
                $userObj->Longitude = $longitude;            
                $userObj->GeoDirty = 0;
                if ($userObj->update()) {
                    $return = "success";
                    $locationObj = new UserLocationZionBean();
                    $locationObj->AccessKey = Yii::app()->params['AccessKey'];
                    $locationObj->CommunityId = Yii::app()->params['NetWorkId'];
                    $locationObj->UserId = $userId;
                    $locationObj->Longitude = $userObj->Latitude;
                    $locationObj->Latitude = $userObj->Longitude;
                    $locationAPI = Yii::app()->params['LocationAPI'];
                    CommonUtility::sendDataToZionRestCall($locationAPI,$locationObj);
                }
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("User:updateUserGeoCoordinates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           
        }
}


          public function getAllActiveUserObjects(){
        try {
            $returnValue = array();
            $query="select * from User where  Status=1";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getAllActiveUserObjects::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
        
 public function getMyLocationRecommendations($userId,$latitude,$longitude,$radius){
    try {
        $returnValue = array();
        if(isset($latitude) && !empty($latitude) && isset($longitude) && !empty($longitude)){
            $query="SELECT UserId,City,Latitude,Longitude,(3959 * acos (cos ( radians($latitude) )* cos( radians( Latitude ) ) * cos( radians( Longitude ) - radians($longitude) )
      + sin ( radians($latitude) )* sin( radians( Latitude ) ))) AS distance FROM User where UserId !=".$userId." and Status=1 having distance <= $radius
ORDER BY distance asc";
         $users = Yii::app()->db->createCommand($query)->queryAll();
            if(sizeof($users)>0){
                $returnValue=$users;
            } 
        }
       
            return $returnValue;


    } catch (Exception $ex) {
       Yii::log("User:getMyLocationRecommendations::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
 }
public function getUserClassfication($userId){
    try {
        $returnValue = "NoUser";
         if(isset(Yii::app()->params['GroupMappingField']) && !empty(Yii::app()->params['GroupMappingField'])){
              $GroupMappingField = Yii::app()->params['GroupMappingField'];
        
            $query="SELECT U.UserId,U.UserClassification,C.".  trim($GroupMappingField)." as PrimaryAffiliation,C.OtherAffiliation FROM User U Join CustomField C on U.UserId=C.Id where U.UserId = ".$userId;            
            $user = Yii::app()->db->createCommand($query)->queryRow();
            if(is_array($user)){
               $returnValue= $user;  
            }
         }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getUserClassfication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}

public function getAllUserClassfication(){
    try {
         $returnValue = array();
         if(isset(Yii::app()->params['GroupMappingField']) && !empty(Yii::app()->params['GroupMappingField'])){
            $GroupMappingField = Yii::app()->params['GroupMappingField'];
            $query="SELECT U.UserId,U.UserClassification,C.".  trim($GroupMappingField)." as PrimaryAffiliation,C.OtherAffiliation FROM User U Join CustomField C on U.UserId=C.Id";            
            $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
         }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getAllUserClassfication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}


public function getMyClassficationRecommendations($userId,$userClassification,$primaryAffiliation,$otherAffiliation){
        try {
        if(isset(Yii::app()->params['GroupMappingField']) && !empty(Yii::app()->params['GroupMappingField'])){
              $GroupMappingField = Yii::app()->params['GroupMappingField'];
         }else{
             $GroupMappingField = "PrimaryAffiliation";
         }
            
      $returnValue = array();
     $query="SELECT U.UserId,U.UserClassification,C.".  trim($GroupMappingField)." as PrimaryAffiliation,C.OtherAffiliation FROM User U Join CustomField C on U.UserId=C.Id where U.UserClassification = ".$userClassification." and C.PrimaryAffiliation='".$primaryAffiliation."' and U.Status=1 and U.UserId !=".$userId;  

            if(isset($otherAffiliation) && $otherAffiliation!=""){
                $query= $query." and C.OtherAffiliation='".$otherAffiliation."'";

            }
         $users = Yii::app()->db->createCommand($query)->queryAll();
            if(sizeof($users)>0){
                $returnValue=$users;
            }
            return $returnValue;


    } catch (Exception $ex) {
       Yii::log("User:getMyClassficationRecommendations::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}
public function getAllUserInterests(){
    try {
            $returnValue = array();
            $query="SELECT UI.UserId,group_concat(UI.Tags) Interests FROM User_Interests UI Join User U on UI.UserId=U.UserId where U.Status=1 group by UI.UserId";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getAllUserInterests::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}
public function getUserInterests($userId){
    try {
            $returnValue = "NoUser";
            $query="SELECT UserId,group_concat(Tags) Interests FROM User_Interests where UserId=$userId group by UserId";            
            $user = Yii::app()->db->createCommand($query)->queryRow();
             if(is_array($user)){
                 $returnValue= $user;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getUserInterests::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}

public function getMyInterestRecommendations($userId,$interest){
        try {
            
        $returnValue = array();
        $query="SELECT UI.UserId FROM User_Interests UI Join User U on UI.UserId=U.UserId where UI.Tags like '%".$interest."%' and UI.UserId!=".$userId." and U.Status=1";
        $users = Yii::app()->db->createCommand($query)->queryAll();
            if(sizeof($users)>0){
                $returnValue=$users;
            }
            return $returnValue;


    } catch (Exception $ex) {
       Yii::log("User:getMyInterestRecommendations::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}

        
/**
*  @author Haribabu
*  @Description This method is used to update user by user Id and by field
*  @params $userId
*  @params $userId
*/

    public function updateUserDetails($UserModel) {
        try {
            $returnValue = "failure";
            $userObj = $this->getUserDetailsByUserId($UserModel['UserId']);
            if(is_object($userObj)){
                
                $userObj->UserId = $UserModel['UserId'];
                $userObj->DisplayName = $UserModel['DisplayName'];
                $userObj->State = $UserModel['State'];
                $userObj->City = $UserModel['City'];
                 $userObj->HavingNPINumber = $UserModel['HavingNPINumber'];
                if($UserModel['HavingNPINumber'] == 1){
                     $userObj->NPINumber = $UserModel['NPINumber'];
                }
                if ($userObj->update()) {

                    User::model()->updateStateLicenseNumber($UserModel,$userObj->UserId);
                    $professionObj = new UserProfessionZionBean();
                    $professionObj->AccessKey = Yii::app()->params['AccessKey'];
                    $professionObj->CommunityId = Yii::app()->params['NetWorkId'];
                    $professionObj->UserId = $UserModel['UserId'];
                    if($UserModel['HavingNPINumber'] == 1){
                        $professionObj->NPINumber = $UserModel['NPINumber'];
                    }else{
                        $licensedStates="";
                        if(isset($UserModel['state'])){
                          $licensedStates =$UserModel['state'];
                       }else{
                           $licensedStates =$UserModel['State'];  
                       }
                       $professionObj->License = array($UserModel['StateLicenseNumber']=>$licensedStates);
                    }
                    $url = Yii::app()->params['ProfessionAPI'];
                    CommonUtility::sendDataToZionRestCall($url,$professionObj);
                    Yii::app()->amqp->stream(json_encode(array("Obj"=>array("UserId"=>$userObj->UserId,"Country"=>$userObj->Country,"State"=>$userObj->State,"City"=>$userObj->City,"Zip" =>"","Address1"=>"","Address2"=>""),"ActionType"=>"GeoLocation","Type"=>"User")));    

                    $returnValue = "success";
                }
            }
             
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:updateUserDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
        public function getAllActiveUsersWithReturns($returnFields="UserId"){
            try {
                $returnValue='failure';
                $query="select $returnFields from User where  Status=1";            
                 $users = Yii::app()->db->createCommand($query)->queryAll();
                 if(count($users)>0){
                     $returnValue= $users;
                 }
                 return $returnValue;
            } catch (Exception $ex) {
                Yii::log("User:getAllActiveUsersWithReturns::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
        }
        
    public function getAllSurveyEligableActiveUsers($surveydays=14){
        try {
            $surveydays=$surveydays==''?14:$surveydays;
            $returnValue='failure';
            $query="select UserId,RegistredDate from User where UserClassification=1 and  Status=1 and RegistredDate<date((NOW() - INTERVAL $surveydays DAY))";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getAllSurveyEligableActiveUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
public function getUserIdsByEmails($emailList){
        try {
            $returnValue = array();
            $emails=  '"'.implode('","', $emailList).'"';
            $query="select UserId from User where  Email in ($emails)";  
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getUserIdsByEmails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }


/*Author Haribabu
 * This method is used to save the users who had get 14 day survey email
 *  
 */
public function SaveUserInNewUserSurveyEmailList($userId,$SurveyTitle){
    try {
        $query="INSERT INTO NewUser_SurveyEmailList(`UserId`,`SUrveyTitle`)VALUES('$userId','$SurveyTitle')";
           $results = Yii::app()->db->createCommand($query)->execute();
        } catch (Exception $ex) {
            Yii::log("User:SaveUserInNewUserSurveyEmailList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          
        }
}



        /*

    @developer Suresh G
    @param type $profileModel
    @param type $userId

*/
    function updateStateLicenseNumber($profileModel,$userId,$pid=0){
    try{
        error_log(print_r($profileModel,1));
        if($profileModel['HavingNPINumber'] == 1){
           $MarketResearchFollowUpForm = new MarketResearchFollowUpForm();
           if(isset($profileModel['state'])){
               $MarketResearchFollowUpForm->NPIState =$profileModel['state']; 
           }else{
               $MarketResearchFollowUpForm->NPIState =$profileModel['State'];  
           }
          
           $MarketResearchFollowUpForm->NPINumber =$profileModel['NPINumber'];
           NPIStatesAndNumber::model()->saveData($pid,$MarketResearchFollowUpForm,$userId);  
        }else{
           $MarketResearchFollowUpForm = new MarketResearchFollowUpForm();
           
            if($pid !=0){
               $MarketResearchFollowUpForm->LicensedNumbers =$profileModel['LicensedNumbers'];
              $MarketResearchFollowUpForm->LicensedStates =$profileModel['LicensedStates'];
           }else{
               $MarketResearchFollowUpForm->LicensedNumbers =$profileModel['StateLicenseNumber'];
          
            if(isset($profileModel['state'])){
              $MarketResearchFollowUpForm->LicensedStates =$profileModel['state'];
           }else{
               $MarketResearchFollowUpForm->LicensedStates =$profileModel['State'];  
           }
           }
           
           
           
           
           LicensedStatesAndNumbers::model()->saveData($pid,$MarketResearchFollowUpForm,$userId);   
        }
        
    
   
    } catch (Exception $ex) {
    Yii::log("User:updateStateLicenseNumber::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    error_log("Exception Occurred in CustomField->updateStateLicenseNumber### ".$ex->getMessage());
    }

}


    public function getUserObjectForZion($userId){
        try {
            $returnValue = "NoUser";
            $query="select FirstName,LastName,Company,City,State,Country,Zip,Email,Latitude,Longitude,NetworkId as CommunityId,NPINumber from User where UserId=$userId";            
            $user = Yii::app()->db->createCommand($query)->queryRow();
             if(is_array($user)){
                 $returnValue= $user;
             }
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:getUserInterests::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function checkStudentExist($email,$linkcode ) {
      try {
        $user = User::model()->findByAttributes(array('StudentOrResidentEmail' => $email,"StudentAccessToken"=>$linkcode));
        return $user;
      } catch (Exception $ex) {
          Yii::log("User:checkStudentExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        error_log("Exception Occurred in User->checkStudentExist### ".$ex->getMessage());
      }
    }
    public function updateStudentStatus($userid) {
      try {
        $return = "failure";
        $user = User::model()->findByAttributes(array('UserId' => $userid));        
        if(isset($user)){
            $user->Status = 1;
            //$user->StudentAccessToken = "";
            if($user->update()){
                $return = "success";
            }
        }
        return $return;
      } catch (Exception $ex) {
          Yii::log("User:checkStudentExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        error_log("Exception Occurred in User->checkStudentExist### ".$ex->getMessage());
        return $return;
      }
    }
}



