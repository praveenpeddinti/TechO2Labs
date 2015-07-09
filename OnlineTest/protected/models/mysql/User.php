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
    public $Qualification;
    public $Phone;
    public $Email;
    public $RegistredDate;
    public $Status=1;
    public $LastLoginDate;
    public $IsAdmin=0;
    public $IdentityProof;
    public $ImagePath;
    

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'User1';
    }

    
    
    public function saveUser($testTakerModel) {
        try {
            $returnValue = false;
            $userObj = new User();

            /*$userObj->FirstName = $profileModel['FirstName'];
            $userObj->LastName = $profileModel['LastName'];
            $userObj->Email = $profileModel['Email'];*/
            $userObj->FirstName = $testTakerModel->FirstName;
            $userObj->LastName = $testTakerModel->LastName;
            $userObj->Email = $testTakerModel->Email;
            $userObj->Phone = $testTakerModel->Phone;
            $userObj->Qualification = $testTakerModel->Qualification;
            $userObj->RegistredDate = date('Y-m-d H:i:s', time());
            $userObj->LastLoginDate = '';
            
            
             
              
            if ($userObj->save()) {
                
                 error_log("----dddddddssdsddd");
                $returnValue = $userObj->UserId;
            }
          
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("User:saveUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
     public function checkUserExist($email) {error_log("-----check---".$email);
      try {
      $user = User::model()->findByAttributes(array('Email' => $email));
      return $user;
      } catch (Exception $ex) {
          Yii::log("User:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      error_log("Exception Occurred in User->checkUserExist### ".$ex->getMessage());
      }
      }

    public function checkUserExistWithPhone($phone) {error_log("--phone---check---".$phone);
      try {
      $user = User::model()->findByAttributes(array('Phone' => $phone));    
      //$user = User::model()->findByAttributes(array('Email' => $email,'Phone' => $phone,));
      return $user;
      } catch (Exception $ex) {
          Yii::log("User:checkUserExistWithPhone::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      error_log("Exception Occurred in User->checkUserExistWithPhone### ".$ex->getMessage());
      }
      }
      
    /*
    * Update the IdentityProof for test taker when the registration time.
    */

    public function updateTestTakerDetails($testTakerForm) {
        try {
            $return = "failed";

            $user = User::model()->findByAttributes(array("Email" => $testTakerForm->Email));
            if (isset($user)) {
                $user->IdentityProof = $testTakerForm->Pancard;
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
    * Update the IdentityProof for test taker when the registration time.
    */

    public function updateTestTakerImagePath($testTakerForm) {
        try {
            $return = "failed";
            $user = User::model()->findByAttributes(array("Email" => $testTakerForm->Email));
            if (isset($user)) {
                $user->ImagePath = $testTakerForm->Imagesrc;
                if ($user->update()) {
                    $return = "success";
                }
            }
        } catch (Exception $ex) {
            error_log("Asddddddddddddddd".$ex->getTraceAsString());
            Yii::log("User:updateUserStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $return;
    }
    
      
      

     /*
     * GetUserProfile: which takes 4 arguments and 
     * by default 2 arguments are initialized with default values those are startLimit = 0 and pageLength = 10;
     * and this function returns Users Object.
     */

    public function getUserProfile($filterValue, $searchText, $startLimit = 0, $pageLength = 10) {
        try {error_log("----model----invite");
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
                
            
                   
            }
         
            $criteria->order = 'RegistredDate DESC, FirstName, LastName';
            $criteria->offset = $startLimit;
            $criteria->limit = $pageLength;
            $result = User::model()->findAll($criteria);
           
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


            $userProfileObject = Yii::app()->db->createCommand()
                    ->select('*,u.UserId')
                    ->from('User1 u')

                    // ->LeftJoin('Countries cn',' cn.Id = u.Country')                    
                    ->where('u.UserId=' . $userid);

            $userProfileObject = $userProfileObject->queryRow();
        } catch (Exception $ex) {
            Yii::log("User:getUserProfileByUserId::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
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
     
      $user->LastLoginDate = date('Y-m-d H:i:s', time());
    
      if ($user->update()) {
      $return = "success";
      }
      }
      } catch (Exception $ex) {
      Yii::log("User:updateUserForLoginTime::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
      return $return;
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
        

    
    
    
    public function updateUserById($model,$pid) {
        try {
            $return = "failed";
            $userObj = User::model()->findByAttributes(array("UserId" => $model->UserId));            
            if (isset($userObj)) {
                $userObj->FirstName = $model->FirstName;
                $userObj->LastName = $model->LastName;            
              
               
             
          
                if ($userObj->update()) {

                 
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

    
   
        /*End Custom methods         */
        
        public function getDetailsByUserIds($userIds){
            try{
                $returnValue = "failure";
                $results = array();
                for($i=0;$i<sizeof($userIds);$i++){
                    $query = "Select UserId,Email,FirstName,LastName from User where UserId = ".$userIds[$i];
                    
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
      
      public function getUsers(){
        try{
            $allUsers = User::model()->findByAttributes(array('IsAdmin' => 0));
            
            return $allUsers;
        } catch (Exception $ex) {
            Yii::log("ExSurveyResearchGroup:getLinkGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExSurveyResearchGroup->getLinkGroups### ".$ex->getMessage());
        }
    }
    
    
    
    
    
}



