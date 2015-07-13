<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SkiptaUserService{
    /** this method is used to save the user collection 
     */
    public function saveToUserCollection() {
        try {
            $userCollectionModel = new UserCollection();
            $userCollectionModel->DisplayName = 'Skipta';
            $userCollectionModel->Network = 'India';
            $userCollectionModel->ProfilePicture = '';
            $userId = UserCollection::model()->saveUserCollection($userCollectionModel);
            if (isset($userId) && $userId != 'error') {

                $this->saveUserProfile($userId);
               $groups=ServiceFactory::getSkiptaGroupServiceInstance()->getAllAutoFollowGroups();   
               $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
               $userClassification = $tinyUserCollectionObj->UserClassification;
               if(!is_string($groups)){
                   foreach($groups as $group){
                    ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToGroup($group->_id,$userId,'Follow', '',$userClassification);           
                   }
                
               }
               
            }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveToUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
  /* This Method is used for check the user exist or not */    
     public function checkUserExist($email) {
         try {
              $result = User::model()->checkUserExist($email);
        return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
    /* This Method is used for check the user exist or not */    
     public function checkUserExistWithPhone($phone) {
         try {
              $result = User::model()->checkUserExistWithPhone($phone);
        return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
    

    
 /* This Method is used for Save the user profile in both mysql and mongo 
      it accepts userprofileForm obj and customForm Obj
  *   */     
    public function SaveUserCollection($userProfileform){error_log($userProfileform->LastName."----mongouser------2----".$userProfileform['FirstName']);
     try {
         $userCollectionModel=new UserCollection();         
                 
         $userId=User::model()->saveUser($userProfileform);  
        if(isset($userId) && $userId!='error'){
            error_log("------------------------------1-----------------".$userId);
         $userCollectionModel->UserId=$userId;
         $uniqueHandle = $this->generateUniqueHandleForUser($userProfileform['FirstName'],$userProfileform['LastName']);
         error_log($uniqueHandle."------------------------------1-----------------".$userId);
         $userCollectionModel->uniqueHandle=$uniqueHandle;
       
         //$userCollectionModel->NetworkId=(int)1;
       
             $userCollectionModel->ProfilePicture='user_noimage.png';
             
         
                    UserCollection::model()->saveUserCollection($userCollectionModel);  

         
         }
      
         
     } catch (Exception $ex) {
         error_log("SkiptaUserService:SaveUserCollection::".$ex->getMessage());
         Yii::log("SkiptaUserService:SaveUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
    
    
    
    /* This Method is used for get the countries */ 
    
     public function GetCountries(){
      try {
      
         // $country=new Countries();
          $countries=Countries::model()->GetCountries();
          return $countries;
                    
      } catch (Exception $ex) {
           Yii::log("SkiptaUserService:GetCountries::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }



    /* This Method is used for User Authentication before login
     *    it returns string as a result
     *  */

    public function userAuthentication($model) {
        
        try {   
            $returnValue='false';
            if (get_class($model) == 'LoginForm') {                
                $email=$model->email;
                $password=$model->pword;      
                $encrypted_salt = Yii::app()->params['ENCRYPTION_SALT'];
                $userMessage = User::model()->userAuthentication($email,md5($encrypted_salt.$password));                
                if($userMessage=='success'){
                      $userObj= User::model()->getUserByType($model->email, "Email");
                      
                   
                   User::model()->updateUserForLoginTime($email);
                }
                
                $returnValue=$userMessage;
                
          
            } else {
                $returnValue = 'false';
            }
            return $returnValue;
        } catch (Exception $ex) {            
            Yii::log("SkiptaUserService:userAuthentication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

 

    /*
     * GetUserProfile: which takes 4 arguments and 
     * by default 2 arguments are initialized with default values those are startLimit = 0 and pageLength = 10;
     * and this function returns Users Object.
     */
    public function getUserProfile($filterValue, $searchText, $startLimit, $pageLength) {
        try {// method calling...                 
            $userProfileCollectionJSONObject = User::model()->getUserProfile($filterValue, $searchText, $startLimit, $pageLength);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $userProfileCollectionJSONObject;
    }

     /*
     * GetUserProfileCount: which takes 2 arguments and 
     * returns the total no. of users.
     */
    public function getUserProfileCount($filterValue, $searchText) {
        try {// method calling...            
            $userProfileCount = User::model()->getUserProfileCount($filterValue, $searchText);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserProfileCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $userProfileCount;
    }

    /*
     * userForgotService: which takes 1 argument and 
     * returns whether the user with that email exist or not
     * and if exists then will updated the column PasswordResetToken with userID(converted to md5)
     * and current password request date(encrypted) which are appended with '_'
     * and will send a password recovery mail to user
     */
    public function userForgotService($model) {       
        try {            
            $returnValue='failure';
            
            $userObj = $this->checkIfUserExist($model);            
            if ($userObj == 'failure' ) {
//                UserProfileCollection::model()->updatePassword
               
            } else {
                if($userObj['Status']==1){
                   $resetPasswordString=$userObj['UserId'];
                $encodeCurrentDate = base64_encode(date('Y-m-d h:i:s'));
                $resetPasswordToken=md5($resetPasswordString).'_'.$encodeCurrentDate;    
               User::model()->updateUserByFieldByUserId($userObj['UserId'],$resetPasswordToken,'PasswordResetToken');
               //$emailCredentials = $this->getEmailCredentialsByTitle('ForgotPassword');//add this line to get the eemail cong details to send mail(Praneeth)
                        $to = $userObj['Email'];
                        $name = $userObj['FirstName'] . ' ' . $userObj['LastName'];
                        $userId = $userObj['UserId'];
                        $userEmail = $userObj['Email'];
                        $subject = "Reset Your ".Yii::app()->params['NetworkName']." Account Password ";
                        $templateType = "forgotmail";
                        $companyLogo = "";
                        $employerName = "Skipta Admin";
                        //$employerEmail = "info@skipta.com"; 
                        $messageview="ForgotPasswordMail";
                        $params = array('myMail' => $name, 'userId' => $userId, 'code' => $resetPasswordToken,'email'=>$userEmail);
                        $sendMailToUser=new CommonUtility;
                        $mailSentStatus=$sendMailToUser->actionSendmail($messageview,$params, $subject, $to);  
                        if($mailSentStatus == false)
                        {
                          $userObj == 'mailsentfailure'; 
                        } 
                }else{
                    if($userObj['Status']==2){
                        $userObj = 'suspended'; 
                    }else if($userObj['Status']==0){
                        $userObj = 'inactive'; 
                    }
                }
                
            }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:userForgotService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }        
        return $userObj;
    }

    /*
     * checks whether the user exist or not
     */
    public function checkIfUserExist($model) {       
        try {
            $result = User::model()->checkUserEmailExist($model);
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkIfUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
   
    /*
     * userResetPasswodService:used to update the new password with old password 
     */
    public function userResetPasswodService($model)
    {
        try{
            $result = User::model()->resetPassword($model);
      
        }catch(Exception $ex){
             Yii::log("SkiptaUserService:userResetPasswodService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          }
        return $result;
    }


    /*
     * GetUserProfileByUserId: which takes 1 argument i.e userid
     * and returns an User Object.
     */
    public function getUserProfileByUserId($userid) {
        try {
            $userProfileObject = User::model()->getUserProfileByUserId($userid);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserProfileByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $userProfileObject;
    }

    /*
     * UpdateUserStatus: which takes 2 arguments 1: userId and 2: value.
     * This is used to update the status of an user.
     */

    public function updateUserStatus($userid, $value) {
        try {
            $result = User::model()->updateUserStatus($userid, $value);
            UserCollection::model()->updateUserStatus($userid, $value);
            if($value == 4){
                $this->updateStudentCodeAndSendMailTo($userid,$value);                              
            }
    if($value==1){
                $userDetails=CustomField::model()->getUserCustomFieldValues($userid);   
                $MappingCustomField=Yii::app()->params['GroupMappingField'];   
                $subSpeciality=(int)$userDetails[$MappingCustomField];
                $subSpecialityDetails=SubSpecialty::model()->getSubSpecialityByType('id',$subSpeciality); 
            
                   $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userid);
                $userClassification = $tinyUserCollectionObj->UserClassification;
            
                if(is_object($subSpecialityDetails) && is_int($subSpeciality) ){                    
                    $subSpecialityId=$subSpecialityDetails->id;   
                    
                    
                    
                    $groupIds=GroupCollection::model()->getGroupIdsBasedOnSpeciality($subSpecialityId);                    
                    if(count($groupIds)>0){
                    foreach($groupIds as $group){
                        $groupId=$group->_id;
                    
                          ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToGroup($groupId, $userid, 'Follow', '',$userClassification);

                         
            }
                }}
               $groups = ServiceFactory::getSkiptaGroupServiceInstance()->getAllAutoFollowGroups($tinyUserCollectionObj->NetworkId, $tinyUserCollectionObj->SegmentId);
                if (!is_string($groups)) {
                    foreach ($groups as $group) {
                        ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToGroup($group->_id, $userid, 'Follow', '',$userClassification);

                    }
                }
                    }
                

        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->updateUserStatus### ".$ex->getMessage());
        }
        return $result;
    }

    /*
     * FollowAction: takes 2 arguments; 1:$followerId and 2:$followingId
     *  and it performs the follow to a user
     */
    public function followAUser($userId,$followId, $createdDate=''){
        try{
            $result = UserProfileCollection::model()->followAction($userId,$followId);
       
                   $CategoryType = CommonUtility::getIndexBySystemCategoryType('User');
                   
                   $FollowEntity = CommonUtility::getIndexBySystemFollowingThing('User');    
                 CommonUtility::prepareStreamObjectForFollowEntity($userId,"UserFollow",$followId,(int)$CategoryType,$FollowEntity, $createdDate);
                   
                $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
                $userClassification = $tinyUserCollectionObj->UserClassification;
                $userAchievementsInputBean = new UserAchievementsInputBean();
                $userAchievementsInputBean->UserId = $userId;
                $userAchievementsInputBean->UserClassification = $userClassification;
                $userAchievementsInputBean->OpportunityType = "Follow";
                $userAchievementsInputBean->SegmentId = $tinyUserCollectionObj->SegmentId;
                $userAchievementsInputBean->NetworkId = $tinyUserCollectionObj->NetworkId;
                $userAchievementsInputBean->EngagementDriverType = "Follow_Users";
                $userAchievementsInputBean->IsUpdate = 0;
                $userAchievementsInputBean->Value = 1;

                Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));
            
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:followAUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
     /*
     * suresh reddy
     * getUserIdByEmail: takes 1 arguments; 1:Email address of user
     *   it's use geting a userid of user by Email
     */

    public function getUserIdByEmail($email){
        try{
            $result = User::model()->checkIfUserExist($email,'Email');
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserIdByEmail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    /*
     * UnFollowAction: takes 2 arguments; 1:userId and 2:followId
     *  and it performs the unfollow a user
     */
    public function unFollowAUser($userId,$followId){
        try{
            $result = UserProfileCollection::model()->unFollowAction($userId,$followId);
       
            
            
            $CategoryType = CommonUtility::getIndexBySystemCategoryType('User');
            $FollowEntity = CommonUtility::getIndexBySystemFollowingThing('User');
            CommonUtility::prepareStreamObjectForFollowEntity($userId, "UserUnFollow", $followId, (int) $CategoryType, $FollowEntity);
            
            $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
            $userClassification = $tinyUserCollectionObj->UserClassification;
            $userAchievementsInputBean = new UserAchievementsInputBean();
            $userAchievementsInputBean->UserId = $userId;
            $userAchievementsInputBean->UserClassification = $userClassification;
            $userAchievementsInputBean->OpportunityType = "Follow";
            $userAchievementsInputBean->SegmentId = $tinyUserCollectionObj->SegmentId;
            $userAchievementsInputBean->NetworkId = $tinyUserCollectionObj->NetworkId;
            $userAchievementsInputBean->EngagementDriverType = "Follow_Users";
            $userAchievementsInputBean->IsUpdate = 0;
            $userAchievementsInputBean->IncreasedValue = -1;

            Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:unFollowAUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    /**
     * 
     * @param type $userid
     * @return type
     */
    public function getUserPrivileges($userid){
        try{
            
            $userObj = UserPrivileges::model()->getUserPrivileges($userid);
           
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserPrivileges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $userObj;
            
    }
    
    /**
     * 
     * @param type $privilegesids
     * @return type
     */
    public function updateUserPrivileges($userId,$privilegesids){
        try{
            $result = UserPrivileges::model()->updateUserPrivileges($userId,$privilegesids);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserPrivileges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
/** 
 * 
 * @param type $value : this is the value of type
 * @param type $type this parameter is the column name to get
 * @return type
 */
    public function getUserByType($value,$type){
        try {
            $returnValue='failure';
           $userObj= User::model()->getUserByType($value, $type);
           if(isset($userObj)){
               $returnValue= $userObj;
           }
           return $returnValue;
        } catch (Exception $ex) {
           Yii::log("SkiptaUserService:getUserByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
     /** 
      * This method is used get the tiny user collection 
      * @param type $userId
      * @return type
      */
     public function getTinyUserCollection($userId){
         try {
        
             $tinyUserCollection=UserCollection::model()->getTinyUserCollection((int)$userId);             
             return $tinyUserCollection;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:getTinyUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
          }

          
    /**
     * @author: karteek
     * @functionName:getUserMiniProfile
     * @param type $userid
     * @returnType: user object
     */      
    public function getUserMiniProfile($userid,$loggedUserId){
        try{
            $miniProfileObjectsArray = array();            
            $userProfileCollectionObj = UserProfileCollection::model()->getUserCollectionByUserId($userid,$loggedUserId);            
            $tinyUserCollectionObj = UserCollection::model()->getTinyUserCollection($userid);            
            $postCollectionObj = UserStreamCollection::model()->getPostsCount($userid);            
            $badgeCollectionObj = UserBadgeCollection::model()->getUserBadgeCollectionByUserId($userid);
            $badgeObjsForDisplay=array();
            if(count($badgeCollectionObj)>0)
            {  
                 $badgeCollectionObj=(array)$badgeCollectionObj;
                 foreach ($badgeCollectionObj as $badgeCObj )
                 {  
                    $badgeArray=array();
                    $badgeArray['_id']=(string) $badgeCObj['_id'];
                    $badgesObj=Badges::model()->getBadgeById($badgeCObj['BadgeId']);
                    $badgeArray['badgeName']=  $badgesObj->badgeName;
                    $badgeArray['hoverText']=  $badgesObj->hover_text;
                    array_push($badgeObjsForDisplay,$badgeArray);
                 }
            }            
            $miniProfileObjectsArray['userProfileCollection'] = $userProfileCollectionObj;
            $miniProfileObjectsArray['tinyUserCollection'] = $tinyUserCollectionObj;
            $miniProfileObjectsArray['postCollectionCount'] = $postCollectionObj;
            $miniProfileObjectsArray['userBadgeCollection'] = $badgeObjsForDisplay;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserMiniProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $miniProfileObjectsArray;
    }      
   



           /*
     * GetCurbsideCategoriesList: which takes 4 arguments and 
     * by default 2 arguments are initialized with default values those are startLimit = 0 and pageLength = 10;
     * and this function returns curbsideCategoryCollectionJSONObject.
     */
    public function getCurbsideCategoriesList($filterValue, $searchText, $startLimit, $pageLength, $segmentId=0) {
        try {// method calling...                 
            $curbsideCategoryCollectionJSONObject = CurbsideCategoriesList::model()->getCurbsideCategoriesList($filterValue, $searchText, $startLimit, $pageLength, $segmentId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getCurbsideCategoriesList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $curbsideCategoryCollectionJSONObject;
    }
    
    /*
     * GetCurbsideCategoriesCount: which takes 2 arguments and 
     * returns the total no. of Categories.
     */
    public function getCurbsideCategoriesCount($filterValue, $searchText, $segmentId=0) {
        try {// method calling...            
            $curbsideCategoryCount = CurbsideCategoriesList::model()->getCurbsideCategoryCount($filterValue, $searchText, $segmentId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getCurbsideCategoriesCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $curbsideCategoryCount;
    }
          
    /*
     * adminCategoryCreationService: which takes 1 argument and 
     * returns whether the Category  exist or not
     * and if exists acknowledge already exists
     * and if  does not exists will create a new category
     */
    public function adminCategoryCreationService($model) {
        try {
            $returnValue = 'failure';
                $userObj = $this->checkIfCategoryExist($model);
            if ($userObj != 'failure')
                {
                 $SaveArtifacts = $this->saveTopicArtifacts($model['TopicprofileImage']);
                $model['TopicprofileImage']=$SaveArtifacts['ThumbNailImage'];
                
                
                $categoryId = CurbsideCategoriesList::model()->saveNewCurbsidecategory($model);
                if($categoryId !='false' && $categoryId !='updatetrue' )
                {
                        /**
                         * The below code is used to save the category in mongo curbsidecategories collection
                         * Haribabu
                         */
                      $result = CurbSideCategoryCollection::model()->saveCategories($categoryId,$model);
                      if($result!='failure'){
                            $returnValue = 'success';
                        }
                   
                    }
                elseif ($categoryId =='updatetrue') {
                    /**
                     * The below code is used to update the category in mongo curbsidecategories collection
                     * Haribabu
                     */
                    $result = CurbSideCategoryCollection::model()->updateCurbsideCategoriesDetails($model);
                    $returnValue = 'updatesuccess';  
                }
                else
                {
                    $returnValue = 'failure';
                }
            }
            else
            {}
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:adminCategoryCreationService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          
        }
        return  $returnValue;
    }

    /**
     * 
     * @author:Praneeth
     * @param type $model
     * @return $result
     * Checks whether the category exists or not
     */
    public function checkIfCategoryExist($model) {       
        try {
            
            $result = CurbsideCategoriesList::model()->checkCurbsieCategoryExist($model);
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkIfCategoryExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       
        return $result;
    }

    /**
     * @author:Praneeth
     * @param type $categoryid, $categoryvalue
     * @return $result
     * This is used to update the status of a category.
     */
    public function updateCurbsideCategoryStatus($categoryid, $categoryvalue) {
        try {
            $result = CurbsideCategoriesList::model()->updateCurbsideCategoryStatus($categoryid, $categoryvalue);
            $resultMongo = CurbSideCategoryCollection::model()->updateCurbsideCategoryStatusInMongo($categoryid, $categoryvalue);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateCurbsideCategoryStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    
    /**
     * @author:Praneeth
     * @param type $categoryid
     * @return $result
     * This is used to edit the category based on the category id
    */
     public function editCurbsideCategoryById($categoryId) {
         try{
             return CurbsideCategoriesList::model()->editCurbsideCategoryById($categoryId);
         } catch (Exception $ex) {
              Yii::log("SkiptaUserService:editCurbsideCategoryById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
     /**
      * @Author Sagar Pathapelli
      * This method is used get the tiny user collection for network
      * @param type $networkId
      * @return type
      */
     public function getTinyUserCollectionForNetworkBySearchKey($networkId,$searchKey, $mentionArray=array()){
         try {
             if(sizeof($mentionArray)>0){
                $mentionArray = array_map('intval', $mentionArray);    
               }
             $tinyUserCollection=UserCollection::model()->getTinyUserCollectionForNetworkBySearchKey($networkId,$searchKey, $mentionArray);             
             return $tinyUserCollection;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:getTinyUserCollectionForNetworkBySearchKey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
     }

     /**
      * @Author Sagar Pathapelli
      * This method is used save the User OAuth details
      * @param type $userOAuthBean 
      * @return type
      */
     public function saveUserOAuth($userOAuthBean){
         try {
             $returnValue="failure";
             $returnValue= UserOAuth::model()->saveUserOAuth($userOAuthBean);             
             return $returnValue;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:saveUserOAuth::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
     }
        
      /**
      * @author Praneeth
      * Description: Method used to get the groups for which the user is a member
      * @param type $UserId
      * @return $groupsCollectionUserFollowing
      */
     public function groupsUserFollowing($UserId)
     {
         try         
         { 
              $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($UserId);
             $groupsCollectionUserFollowing='failure';
             $userFollowingGroups = UserProfileCollection::model()->getUserFollowingGroups($UserId);             
             $groupsCollectionUserFollowing = GroupCollection::model()->userFollowingGroupsListWithOutFollowers($userFollowingGroups,$tinyUserCollectionObj->SegmentId);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:groupsUserFollowing::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         
         return $groupsCollectionUserFollowing;
     }
     
        public function getUserFollowingGroups($UserId)
     {
         try
         {
             $userGroups = array();
             $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($UserId);
             $groupsCollectionUserFollowing='failure';
             $userFollowingGroups = UserProfileCollection::model()->getUserFollowingGroups($UserId);  
             $userGroups = GroupCollection::model()->userFollowingAllGroups($userFollowingGroups,$tinyUserCollectionObj->SegmentId);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserFollowingGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         
         return $userGroups;
     }
     
     /**
      * @author Praneeth
      * Description: Method used to get the groups for which the user is not a member
      * @param type $UserId
      * @return $groupsCollectionUserNotFollowing
      */
     public function groupsUserNotFollowing($UserId)
     {
         try
         {
             $groupsCollectionUserNotFollowing='failure';
             $userFollowingInGroups = UserProfileCollection::model()->getUserFollowingGroups($UserId);
            //$groupsCollectionUserNotFollowing = GroupCollection::model()->userNotFollowingGroupsList($userFollowingInGroups);
         } catch (Exception $ex) {
                Yii::log("SkiptaUserService:groupsUserNotFollowing::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         return $userFollowingInGroups;
     }
     
     
     public function getMoreFollowingGroups($UserId, $startLimit, $pageLength) {
        try {
            $moreGroupsCollectionUserFollowing = 'failure';
            $userFollowingGroups = UserProfileCollection::model()->getUserFollowingGroups($UserId);
            $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($UserId);
            $segmentId = $tinyUserCollectionObj->SegmentId;
            $moreGroupsCollectionUserFollowing = GroupCollection::model()->userMoreFollowingGroupsList($userFollowingGroups, $startLimit, $pageLength, $segmentId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getMoreFollowingGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $moreGroupsCollectionUserFollowing;
    }

    /**
      * @author Sagar Pathapelli
      * @Description getting abused users from post collection
      * @return 
      */
    public function getAbusedPosts() {
        try {
             $returnValue="failure";
             $returnValue=  PostCollection::model()->getAbusedposts();
             return $returnValue;             
        } catch (Exception $ex) {
           Yii::log("SkiptaUserService:getAbusedPosts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     
            /*
     * getHelpIconsList: which takes 4 arguments and 
     * by default 2 arguments are initialized with default values those are startLimit = 0 and pageLength = 10;
     * and this function returns curbsideCategoryCollectionJSONObject.
     */
    public function getHelpIconsDescriptionList($filterValue, $searchText, $startLimit, $pageLength) {
        try {// method calling...                 
            $helpIconCollectionJSONObject = UserHelpManagement::model()->getHelpIconsDescriptionList($filterValue, $searchText, $startLimit, $pageLength);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getHelpIconsDescriptionList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $helpIconCollectionJSONObject;
    }
    
       /*
     * getHelpIconsDescriptionListCount: which takes 2 arguments and 
     * returns the total no. of help icon.
     */
    public function getHelpIconsDescriptionListCount($filterValue, $searchText) {
        try {// method calling...            
            $helpIconsDescriptionListCount = UserHelpManagement::model()->getHelpIconsDescriptionListCount($filterValue, $searchText);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getHelpIconsDescriptionListCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $helpIconsDescriptionListCount;
    }
    
     /*
     * adminCreateHelpIconService: which takes 1 argument and 
     * returns whether the help icon  exist or not
     * and if exists acknowledge already exists
     * and if  does not exists will create a new help icon
     */
    public function adminCreateHelpIconService($model) {
        try {
            $returnValue = 'failure';
                $userObj = $this->checkIfHelpIconExist($model);
                if(isset($userObj))
                {
                     if(isset($model->id) && !empty($model->id) )
                        {
                            //update
                            if($userObj->Id == $model->id)
                            {
                                //allow
                               $helpIconId = UserHelpManagement::model()->updateHelpIcon($model); 
                               if ($helpIconId =='updatetrue') {
                                       $returnValue = 'updatesuccess';
                               }
                            }
                            else
                            {
                               //not allow
                               $returnValue = 'helpexists';
                            }
                        }
                            else
                            {
                                //not allow
                                 $returnValue = 'helpexists';
                            }
                }
                else
                {
                    //insert
                    $helpIconId = UserHelpManagement::model()->saveNewHelpIcon($model);
                    if($helpIconId !='false' && $helpIconId !='updatetrue' )
                    {
                         $returnValue = 'success'; 
                    }
                }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:adminCreateHelpIconService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          
        }
        
        return  $returnValue;
    }
    
     /**
     * @author:Praneeth
     * @param type iconNameId
     * @return $result
     * This is used to edit the icon details based on the iconName id
    */
     public function editHelpIconDetails($iconNameId) {
         try{
             return UserHelpManagement::model()->editHelpIconDetails($iconNameId);
         } catch (Exception $ex) {
              Yii::log("SkiptaUserService:editHelpIconDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }
    
    public function getHelpDescription($helpIconId)
    {
        try
        {
             $helpDetailsObject=UserHelpManagement::model()->getHelpDescriptionById($helpIconId);
          return $helpDetailsObject;
                    
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getHelpDescription::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     /**
     * 
     * @author:Praneeth
     * @param type $model
     * @return $result
     * Checks whether the Icon exists or not
     */
    public function checkIfHelpIconExist($model) {       
        try {
            $result="";
            $result = UserHelpManagement::model()->checkIfHelpIconExist($model);
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkIfHelpIconExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    
     /**
     * @author:Praneeth
     * @param type $helpIconid, $helpIconStatus
     * @return $result
     * This is used to update the status of a helpIcon.
     */
    public function updateHelpIconStatus($helpIconid, $helpIconStatus) {
        try {
            $result = UserHelpManagement::model()->updateHelpIconStatus($helpIconid,$helpIconStatus);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateHelpIconStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }

     /**
     * @author:Praneeth
     * @param type $userid, $LastLoginDate
     * @return $result
     * This is used to list of user who have followed since the last login.
     */
    public function getNewFollowersListByDate($userid,$LastLoginDate)
    {
        try
        {  
            $returnValue='failure';
            $result = UserActivityCollection::model()->getNewUserFollowingMembers($userid, $LastLoginDate);
           
            $userFollowersId = array();
            if(isset($result)){
                 $userFollowingList = UserProfileCollection::model()->getUserFollowingById($userid);
              foreach ($result as $userFollower) {  
                  
                  $isavail = in_array($userFollower['UserId'],$userFollowingList);
                  if($isavail !=1)
                  {
                      array_push($userFollowersId, $userFollower['UserId']);
                  }
                
            }
            $returnValue =UserCollection::model()->getFollowedUserDetailsList($userFollowersId);
            }
        } catch (Exception $ex) {
                Yii::log("SkiptaUserService:getNewFollowersListByDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
    
     /**
     * @author:Lakshman
     * @param type $userid
     * @return $result
     * This is used to get the recommended users list by logged in user Id.
     */
    public function getUserRecommendationsList($userid, $limit)
    {
        try
        {  
            $returnValue='failure';
            $result = UserRecommendations::model()->getUserRecommendationsMembersList($userid, $limit);            
            $recommendedUserId = array();
            if(isset($result)){                
                $obj = isset($result['result'][0])?$result['result'][0]:array();
                if(isset($obj['UserArray']))
                    $returnValue =UserCollection::model()->getFollowedUserDetailsList($obj['UserArray']);
                
            }
        } catch (Exception $ex) {
                Yii::log("SkiptaUserService:getUserRecommendationsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
        return $returnValue;
    }
   
       
    /**
     * @author Vamsi Krishna
     * @Description This method is used to get the Group recent Activity for RightWidget
     * @param type userId           
     * @return  success =>Array failure =>string 
     * Modified by Praneeth for group activity on right side widget
     */    
    
    public function getUserGroupActivityForRightWidget($userId) {
        try {
            $returnValue='failure';
            $groupIdsWithActivities=array();
            $groupDetailsWithActivity=array();
            
            $userGroupActivities=UserProfileCollection::model()->getUserGroupActivity($userId);
            if(is_array($userGroupActivities)){
                $userProfile=$this->getUserProfileByUserId($userId);
                $PreviousLastLoginDate = strtotime(date($userProfile['PreviousLastLoginDate'], time()));
                $i=0;
                foreach($userGroupActivities as $groupId){
                    if($i<5){                                                                                                                      
                              $return=GroupPostCollection::model()->getUserRecentGroupActivity($groupId,$PreviousLastLoginDate);        
                    if($return=='success'){
                        array_push($groupIdsWithActivities,$groupId);
                       } 
                    }else{
                        break;
                    }
                   
                  $i++;
                }
                if(count($groupIdsWithActivities>0)){
                     
                    foreach($groupIdsWithActivities as $group){                        
                        $groupBean=new GroupBean();
                        $groupDetails=GroupCollection::model()->getGroupDetailsById($group);
                        if($groupDetails->Status==1){
                        $groupBean->GroupIcon=$groupDetails->GroupProfileImage;                        
                        $groupBean->GroupName=$groupDetails->GroupName;
                         $groupBean->GroupUniqueName=$groupDetails->GroupUniqueName;
                        $groupBean->GroupShortDescription=$groupDetails->GroupDescription;
                        $groupBean->GroupId=$groupDetails->_id;
                        array_push($groupDetailsWithActivity,$groupBean);
                        }
                    }
                    $returnValue=$groupDetailsWithActivity;
                }
            }
            return $returnValue;
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserGroupActivityForRightWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     /**
     * @author Vamsi Krishna
     * @Description This method is used to update the user profile for group activity 
     * @param type userId 
     * @param type groupId
     * @return  success =>Array failure =>string 
     */    
    
    public function updateUserProfileForGroupActivity($userId,$groupId) {
        try {
            UserProfileCollection::model()->updateUserProfileForGroupActivity($userId,$groupId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserProfileForGroupActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
  /**
     * @author Vamsi Krishna
     * @Description This method is used to get the user profile for profile page
     * @param type userId      
     * @return  success =>Array failure =>string 
     */    
    
  public function getUserProfileDetails($userId,$loggedInUserId){
      try {   
          $returnValue='failure';
          $userProfileCollection=UserProfileCollection::model()->getUserProfileCollection($userId);
          $tinyUserCollection=UserCollection::model()->getTinyUserCollection($userId);
          $userDetailsfromMysql=(array)User::model()->getUserProfileByUserId($userId);
          $userPersonalInformation=ProfessionalInformation::model()->getProfessionalInformationByUserId($userId);
          $userCustomFieldDetails=CustomField::model()->getUserCustomFieldsForProfileByUserId($userId);
          $userProfile=new UserProfileBean();    
          $userProfile->UserId=$userDetailsfromMysql['UserId'];
          $userProfile->FirstName=$userDetailsfromMysql['FirstName'];
          $userProfile->LastName=$userDetailsfromMysql['LastName'];
          $userProfile->Company=$userDetailsfromMysql['Company'];
          $userProfile->Network=$userDetailsfromMysql['NetworkId'];
          $userProfile->ContactNumber=$userDetailsfromMysql['Phone'];
          $userProfile->Zip=$userDetailsfromMysql['Zip'];          
          $userProfile->Status=$tinyUserCollection->Status;
          $userProfile->City=$userDetailsfromMysql['City'];
          $userProfile->State=$userDetailsfromMysql['State'];
          $userProfile->NPINumber=$userDetailsfromMysql['NPINumber'];
          $userProfile->HavingNPINumber=$userDetailsfromMysql['HavingNPINumber'];
          $userstate=State::model()->GetStateByUsingStateName($userDetailsfromMysql['State']);
          
          
          if($userstate!="failure")
          {
              if($userstate['StateCode']!=""){
                  $userProfile->UserState=$userstate['StateCode'];
              }else{
                  $userProfile->UserState=$userstate['State'];
              }
          }
          else
          {
              $userProfile->UserState='';
          }
          
          
          
          
          //$userProfile->Designation=$userDetailsfromMysql['Designation'];
         //-----------Added if condition because null is displayed for AboutMe as old data is migrated with null --------Praneeth
          if($tinyUserCollection->AboutMe == null || $tinyUserCollection->AboutMe =="null"){
            $userProfile->AboutMe="";
          }
          else{
               $userProfile->AboutMe=$tinyUserCollection->AboutMe;
          }
          $userProfile->DisplayName=$tinyUserCollection->DisplayName;
          $userProfile->ProfilePicture=$tinyUserCollection->ProfilePicture;
          $userProfile->profile250x250=$tinyUserCollection->profile250x250;
          $userProfile->profile70x70=$tinyUserCollection->profile70x70;
          $userProfile->profile45x45=$tinyUserCollection->profile45x45;
          
          $userFollowers = array();
          $userFollowers = $userProfileCollection->userFollowers;
          
       
          $pos = array_search(0, $userFollowers);
          if(is_int($pos) && $pos>=0){
            unset($userFollowers[$pos]);
          }
          $userFollowing = array();
          $userFollowing = $userProfileCollection->userFollowing;
          $pos = array_search(0, $userFollowing);
          if(is_int($pos) && $pos>=0){
            unset($userFollowing[$pos]);
          }
          $userProfile->UserFollowersCount=count(array_unique($userFollowers));
          $userProfile->UserFollowingCount=count(array_unique($userFollowing));
          $userProfile->UserFollowers=$userFollowers;
          $userProfile->UserFollowing=$userFollowing;
          
          $userProfile->GroupsFollowing=count($userProfileCollection->groupsFollowing);
          if(is_object($userPersonalInformation)){              
              $userProfile->School=$userPersonalInformation['School'];
              $userProfile->Speciality=$userPersonalInformation['Speciality'];
              $userProfile->Years_Experience=$userPersonalInformation['Years_Experience'];
              $userProfile->Degree=$userPersonalInformation['Degree'];
              $userProfile->Position=$userPersonalInformation['Position'];
              $userProfile->Highest_Education=$userPersonalInformation['Highest_Education'];  
              $userProfile->Credentials=$userPersonalInformation['Credentials'];  
              $userProfile->Title=$userPersonalInformation['Title'];
              $userProfile->PracticeName=$userPersonalInformation['PracticeName']; 
              
          }else{
              $userProfile->School='';
              $userProfile->Speciality='';
              $userProfile->Years_Experience='';
              $userProfile->Degree='';
              $userProfile->Position='';
              $userProfile->Highest_Education=''; 
              $userProfile->Credentials='';
              $userProfile->Title='';
              $userProfile->PracticeName=''; 
          }
          $userFollowed=in_array($loggedInUserId,$userProfileCollection->userFollowers);
          if($userFollowed==1){
              $userProfile->IsFollowed =1;
          }else{
              $userProfile->IsFollowed =0;
          }
          
          if($userCustomFieldDetails!="NoUser"){
//              if(isset($userCustomFieldDetails['LicenceNumber']) && $userCustomFieldDetails['LicenceNumber']!=""){
//                   $userProfile->LicenceNumber= $userCustomFieldDetails['LicenceNumber'] ;
//              }else{
//                   $userProfile->LicenceNumber="";
//              }
//               if(isset($userCustomFieldDetails['LicenceNumber'])){
//                    $userProfile->LicenceNumberExist=1;
//               }
           if(isset($userCustomFieldDetails['PrimaryAffiliation']) && $userCustomFieldDetails['PrimaryAffiliation']!="" ){   
               $subspeciality=SubSpecialty::model()->getSubSpecialityByType('id',$userCustomFieldDetails['PrimaryAffiliation']);
               if(is_object($subspeciality)){
                   $userProfile->UserSubSpeciality=$subspeciality->Value;
               }else{
                     $userProfile->UserSubSpeciality="";
               }
               if($userCustomFieldDetails['PrimaryAffiliation']!=""){
                    $userProfile->UserSpeciality=$userCustomFieldDetails['PrimaryAffiliation'];
               }
           
               if($userCustomFieldDetails['PrimaryAffiliation']=="Other"){
                   if(isset($userCustomFieldDetails['OtherAffiliation'])&& $userCustomFieldDetails['OtherAffiliation']!=""){
                        $userProfile->OtherSpeciality=$userCustomFieldDetails['OtherAffiliation'];
                   }else{
                        $userProfile->OtherSpeciality="";
                   }
                   
               }              
               else{
                    $userProfile->OtherSpeciality="";
               }
           }
          }else{
              $userProfile->LicenceNumber='';
              $userProfile->UserSpeciality='';
          }
           $userProfile->LicenceNumber= LicensedStatesAndNumbers::model()->getStateLicenseNumberByUserId($userId);
          
           
           $UserInterests=  UserInterests::model()->getUserCVInterestsDetailsForProfile($userId);
          if($UserInterests!="failure"){
              $userProfile->Userinterests=$UserInterests['Tags'];
          }else{
              $userProfile->Userinterests="";
          }
          //$userProfile->IsFollowed = in_array($loggedInUserId,$userProfileCollection->userFollowers);
       
        return  $userProfile;
      } catch (Exception $ex) {          
            Yii::log("SkiptaUserService:getUserProfileDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
      }
    }
  /**
     * @author Vamsi Krishna
     * @Description This method is used to update the profile 
     * @param type userId      
     * @return  success =>Array failure =>string 
     */   

    public function updateUserProfileDetails($userId, $type, $value) {
        try {
            if($type=='AboutMe' || $type=='ProfilePicture'){
                UserCollection::model()->updateProfileDetailsbyType($userId,$type,$value);                
            }
            if($type=='DisplayName'){
                UserCollection::model()->updateProfileDetailsbyType($userId,$type,$value); 
                User::model()->updateUserByFieldByUserId($userId, $value, "DisplayName");
            }if($type=='Designation' ||$type=='Company' ){
                 User::model()->updateUserByFieldByUserId($userId, $value,$type);
            }
            if($type=='ProfilePicture'){
                 UserCollection::model()->updateProfileDetailsbyType($userId,$type,$value); 
            }
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserProfileDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             return $returnValue;
        }
    }
    
    /**
     * @author Vamsi Krishna
     * @Description This method is used to Insert Personal Information for the user 
     * @param type userId      
     * @return  success =>Array failure =>string 
     */  
  
    public function saveOrUpdateUserProfessionalInformation($userId,$professionalInformationForm){
        try {
             $professionalInformation = ProfessionalInformation::model()->getProfessionalInformationByUserId($userId);            
            if($professionalInformation!='failure'){
                ProfessionalInformation::model()->updateProfessionalInformation($professionalInformationForm,$professionalInformation); 
            }else{               
               ProfessionalInformation::model()->saveProfessionalInformation($professionalInformationForm,$userId);    
            }
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveOrUpdateUserProfessionalInformation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
            
    }
    
      public function saveProfileNameDetails($UserId, $value, $type) {
        try {
            $returnValue = User::model()->updateUserByFieldByUserId($UserId, $value, $type);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveProfileNameDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function saveProfileDetailsUserCollection($UserId, $type, $value,$imageName, $absolutePath) {
        try {
            $returnValue = UserCollection::model()->updateProfileDetailsbyType($UserId, $type, $value, $imageName, $absolutePath);
            if( $type == 'ProfilePicture')
            {
                $ArtifactClassName=$this->getArtifactProfileImage($value,$imageName);
            }
            if($returnValue =="success")
            {
                $returnValue = $imageName;
                $userId = (int)$UserId;
                $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
                $userClassification = $tinyUserCollectionObj->UserClassification;
                $userAchievementsInputBean = new UserAchievementsInputBean();
                $userAchievementsInputBean->UserId = (int)$userId;
                $userAchievementsInputBean->UserClassification = $userClassification;
                $userAchievementsInputBean->OpportunityType = "Profile";
                $userAchievementsInputBean->EngagementDriverType = "Profile_Picture";
                $userAchievementsInputBean->SegmentId = $tinyUserCollectionObj->SegmentId;
                $userAchievementsInputBean->NetworkId = $tinyUserCollectionObj->NetworkId;
                $userAchievementsInputBean->IsUpdate = 1;
                $userAchievementsInputBean->Value = 1;
                Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveProfileDetailsUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function getArtifactProfileImage($artifact,$imageName) {
        try {
             // $className="";
              $img="";
              $className="img_small_250";
              $new_filepath="";
              $result=array();
              $path = $artifact;
              $thumbNailpath='/upload/profile/';
              $extension=explode(".", strtolower($artifact));
              $extension = end($extension);
              if($extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tiff'|| $extension=='png'){
                  $filepath=Yii::getPathOfAlias('webroot').$path;
                  $width = $height = 0;
                    if (file_exists($filepath)) {
                     list($width, $height) = getimagesize($filepath);
                    }
                     //For images with 250x250 size
                        $newfolderBig=Yii::getPathOfAlias('webroot').$thumbNailpath.'250x250/';// folder for uploaded files
                       if (!file_exists($newfolderBig) ) {
                              mkdir ($newfolderBig, 0755,true);
                             }
                            
                        $img = Yii::app()->simpleImage->load($filepath);
                        if($img->getWidth()>=250){
                           $img-> resizeToWidth(250);
                        }
                        $img->save($newfolderBig.$imageName); 
                        $className="img_big_250";
                        $new_filepath=$thumbNailpath.'250x250/' . $imageName;
                        //For images with 70x70 size
                       $newfolderMedium=Yii::getPathOfAlias('webroot').$thumbNailpath.'70x70/';// folder for uploaded files
                       if (!file_exists($newfolderMedium) ) {
                              mkdir ($newfolderMedium, 0755,true);;
                             }
                        $img1 = Yii::app()->simpleImage->load($filepath);
                        if($img1->getWidth()>=70){
                           $img1-> resizeToWidth(70);
                        }
                        $img1->save($newfolderMedium.$imageName); 
                        $className="img_big_250";
                        $new_filepath=$thumbNailpath.'70x70/' . $imageName;
                        //For images with 45x45 size
                       $newfolderSmall=Yii::getPathOfAlias('webroot').$thumbNailpath.'45x45/';// folder for uploaded files
                       if (!file_exists($newfolderSmall) ) {
                              mkdir ($newfolderSmall, 0755,true);;
                             }
                        $img2 = Yii::app()->simpleImage->load($filepath);
                        if($img2->getWidth()>=45){
                           $img2-> resizeToWidth(45);
                        }
                        $img2->save($newfolderSmall.$imageName); 
                        $className="img_big_250";
                        $new_filepath=$thumbNailpath.'45x45/' . $imageName;
                  
            }
//            $result['filepath']=$new_filepath;
//            $result['fileclass']=$className;
            
             return $result;
             
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getArtifactProfileImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
 
     public function saveAbuseWordService($model) {
        try {
            $returnValue = 'failure';
            $returnValue = AbuseKeywords::model()->saveAbuseWord($model);
            return  $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveAbuseWordService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return  $returnValue;
        }
    }
    /**
     * @author Sagar
     * @return type
     */
    public function getAllAbuseWords() {
        try {
            $returnValue = 'failure';
            $returnValue = AbuseKeywords::model()->getAllAbuseWords();
            return  $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllAbuseWords::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return  $returnValue;
        }
    }

    /**
     * @author Karteek.V
     * @param type $userId
     * @return type
     */
    
    public function getUserSettings($userId){
        try{
            $result = UserNotificationSettingsCollection::model()->getUserSettings($userId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    /**
     * @author Karteek.V
     * @param type $userId
     * @param type $settingIds
     * @return type
     */
    public function updateUserSettings($userId,$settingIds,$isDevice=0){
        try{
            $result = UserNotificationSettingsCollection::model()->updateUserSettings($userId,$settingIds,$isDevice);
        } catch (Exception $ex) {
           Yii::log("SkiptaUserService:updateUserSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    
            
    /**
     * @author Praneeth
     * @Description This method is used to get the user attending for RightWidget
     * @param type userId           
     * @return  success =>Array failure =>string 
     * 
     */    
    
    public function getUserEventsAttendingForRightWidget($userId,$CurrentLoginDate) {
        try {
            $returnValue = 'failure';       
            $userEventAttendingActivities=  UserInteractionCollection::model()->getUserEventsAttendingActivity($userId,$CurrentLoginDate);
                if(count($userEventAttendingActivities)>0){
                  $returnValue = $userEventAttendingActivities;   
                }
            return $returnValue; 
            
        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserEventsAttendingForRightWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

 public function saveCookieRandomKeyForUser($userId,$randomKey){
     try{
     UserCookie::model()->saveCookieRandomKeyForUser($userId,$randomKey);
     }catch (Exception $ex) {
        Yii::log("SkiptaUserService:saveCookieRandomKeyForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
 }
  public function checkCookieValidityForUser($userId,$randomKey){
     try{
      return UserCookie::model()->checkCookieValidityForUser($userId,$randomKey);
      }catch (Exception $ex) {
        Yii::log("SkiptaUserService:checkCookieValidityForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
 }
   public function deleteCookieRandomKeyForUser($userId,$randomKey){
      try{
       UserCookie::model()->deleteCookieRandomKeyForUser($userId,$randomKey);
       }catch (Exception $ex) {
        Yii::log("SkiptaUserService:deleteCookieRandomKeyForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
 }  

    public function getUserFollowingHashtagsData($userId){
        try{
            $hashTags=array();
            $userProfileCollection=UserProfileCollection::model()->getUserProfileCollection($userId);
            if(isset($userProfileCollection->hashtagsFollowing) && is_array($userProfileCollection->hashtagsFollowing)){
                $hashtagsFollowing = array_unique($userProfileCollection->hashtagsFollowing);
                foreach ($hashtagsFollowing as $hashtag) {
                    $hashTagData = HashTagCollection::model()->getHashTagsById($hashtag);
                    if(is_object($hashTagData) && sizeof($hashTagData)>0){
                        $hashTagArray = array();
                        $hashTagArray['id'] = $hashTagData->_id;
                        $hashTagArray['name'] = $hashTagData->HashTagName;
                        array_push($hashTags, $hashTagArray);
                    }
                }
            }
            return $hashTags;
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:getUserFollowingHashtagsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return array();
        }
    }
    public function getUserFollowingGroupsData($userId,$loggedInUserId){
        try{
            $groups=array();
            $userProfileCollection=UserProfileCollection::model()->getUserProfileCollection($userId);
            if(isset($userProfileCollection->groupsFollowing) && is_array($userProfileCollection->groupsFollowing)){
                $groupsFollowing = array_unique($userProfileCollection->groupsFollowing);
                foreach ($groupsFollowing as $groupId) {
                    $groupsData = GroupCollection::model()->getGroupDetailsById($groupId);
                    if(is_object($groupsData) && sizeof($groupsData)>0){
                        if($groupsData['Status']==1){
                        $groupsDataArray = array();
                        $groupsDataArray['id'] = $groupsData->_id;
                        $groupsDataArray['name'] = $groupsData->GroupName;
                        $groupsDataArray['groupProfileImage'] = $groupsData->GroupProfileImage;
                        
                        if($groupsData->IsPrivate==1){
                            $groupsDataArray['groupMembers']=$groupsData->GroupMembers;
                           $isFollowing=in_array($loggedInUserId,$groupsData->GroupMembers);                           
                           if($isFollowing==1){
                              $groupsDataArray['showIntroPopup']=1;  
                           }else{
                               $groupsDataArray['showIntroPopup']=0;  
                           }
                        }else{
                            $groupsDataArray['showIntroPopup']=1;  
                        }
                        array_push($groups, $groupsDataArray);
                        }
                    }
            }
            }
            return $groups;
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:getUserFollowingGroupsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');          
            return array();
        }
    }
    public function getUserFollowingCurbsideCategoriesData($userId){
        try{
            $categories=array();
            $userProfileCollection=UserProfileCollection::model()->getUserProfileCollection($userId);
            if(isset($userProfileCollection->curbsideFollowing) && is_array($userProfileCollection->curbsideFollowing)){
                $categoriesFollowing = array_unique($userProfileCollection->curbsideFollowing);
                foreach ($categoriesFollowing as $categoryId) {
                    $curbsideCategoryData = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId($categoryId);
                    if(is_object($curbsideCategoryData) && sizeof($curbsideCategoryData)>0){
                        $curbsideCategoryArray = array();
                        $curbsideCategoryArray['id'] = $curbsideCategoryData->CategoryId;
                        $curbsideCategoryArray['name'] = $curbsideCategoryData->CategoryName;
                        array_push($categories, $curbsideCategoryArray);
                    }
                }
            }
            return $categories;
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:getUserFollowingCurbsideCategoriesData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return array();
        }
    }
     public function getRoles(){
       $returnValue='failure';
       try {
           $userTypes=UserType::model()->getUserTypes();
           if($userTypes!='failure'){
              $returnValue=$userTypes; 
           }           
           return $returnValue;
       } catch (Exception $ex) {
          Yii::log("SkiptaUserService:getRoles::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return $returnValue;
       }
      }

   public function getRolesBySelectedUserType($selectedRole){
        $returnValue='failure';
       try {           
          $roleBasedActions= RoleBasedAction::model()->getRoleBasedActions($selectedRole);

          if($roleBasedActions!='failure'){
              $returnValue=$roleBasedActions; 
}
          return $returnValue;

       } catch (Exception $ex) {
          Yii::log("SkiptaUserService:getRolesBySelectedUserType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return $returnValue;
}
      }
      
   public function updateRoleBasedActions($selectedRole,$actionIds){
        $returnValue='failure';
       try {
           $returnValue=RoleBasedAction::model()->updateRoleBasedActions($selectedRole,$actionIds);
           return $returnValue;
       } catch (Exception $ex) {
          Yii::log("SkiptaUserService:updateRoleBasedActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return $returnValue;
       }
      }  

    /**
    * @author VamsiKrishna
    * @param type $userId
    * @return string if faliure and array if success
    */   
     public function getUserFollowersForProfile($userId,$loginUserId,$pageSize,$page) {
        $returnValue = 'failure';
        $userProfileBean=new UserProfileBean();
        $userFollowersArray=array();
         $isPresent=0;
        try {
            $userFollowers = UserProfileCollection::model()->getUserFollowersById($userId);
            if ($userFollowers != 'failure') {
                $userFollowers = array_unique($userFollowers);
                $userFollowers_chunck = array_slice($userFollowers,$pageSize,$page);
                if (count($userFollowers_chunck)>0) {
                     foreach ($userFollowers_chunck as $user){  
                    if($user!=0){
                         $userProfileBean=new UserProfileBean();
                   $userToUserFollowers=  UserProfileCollection::model()->getUserFollowersById($user);                  
                   if($userToUserFollowers!='failure'){
                       $isPresent=in_array($loginUserId, $userToUserFollowers);
                       if($isPresent==0){
                          $userProfileBean->IsFollowed=0;    
                       }else{
                          $userProfileBean->IsFollowed=1;     
                       }
                       
                   }else{
                       $userProfileBean->IsFollowed=0;
                   }
                   $tinyUserCollection=UserCollection::model()->getTinyUserCollection($user);
                   $userProfileBean->UserId=$tinyUserCollection->UserId;
                   $userProfileBean->ProfilePicture=$tinyUserCollection->profile70x70;
                   $userProfileBean->DisplayName=$tinyUserCollection->DisplayName;
                   $userProfileBean->uniqueHandle=$tinyUserCollection->uniqueHandle;
                     array_push($userFollowersArray,$userProfileBean);
                    }
                   
                  }
                $returnValue=$userFollowersArray;
                }
          
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserFollowersForProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
     /**
    * @author VamsiKrishna
    * @param type $userId
    * @return string if faliure and array if success
    */ 
    public function getUserFollowingForProfile($userId,$loginUserId,$pageSize,$page) {
        $returnValue = 'failure';
        $userProfileBean=new UserProfileBean();
        $userFollowingArray=array();
        $isPresent=0;
        try { 
            $userFollowing = UserProfileCollection::model()->getUserFollowingById($userId);
            $userFollowing_chunck = array_slice($userFollowing,$pageSize,$page);            
            if (count($userFollowing_chunck)>0) {
                foreach ($userFollowing_chunck as $user){
                    if($user!=0){
                        $userProfileBean=new UserProfileBean();
                   $userToUserFollowing=  UserProfileCollection::model()->getUserFollowersById($user);
                   if($userToUserFollowing!='failure'){                  
                       $isPresent=in_array($loginUserId, $userToUserFollowing);                  
                       if($isPresent==0){
                          $userProfileBean->IsFollowed=0;    
                       }else{
                          $userProfileBean->IsFollowed=1;     
                       }
                       
                   }else{
                       $userProfileBean->IsFollowed=0;
                   }
                   $tinyUserCollection=UserCollection::model()->getTinyUserCollection($user);
                   $userProfileBean->UserId=$tinyUserCollection->UserId;
                   $userProfileBean->ProfilePicture=$tinyUserCollection->profile70x70;
                   $userProfileBean->DisplayName=$tinyUserCollection->DisplayName;
                   $userProfileBean->uniqueHandle=$tinyUserCollection->uniqueHandle;
                     array_push($userFollowingArray,$userProfileBean);
                    }
                    
                }
              
                $returnValue=$userFollowingArray;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserFollowingForProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
 /**
     * @author Sagar Pathapelli
     * This is used to get User Actions By UserType / RoleId (for Rite Aid)
     * @param type $userId
     * @param type $userTypeId
     * @return string
     */
      public function getUserActionsByUserType($userId, $userTypeId) {
        $returnValue = 'failure';
        try {
            $returnValue = RoleBasedAction::model()->getUserActionsByUserType($userId, $userTypeId);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserActionsByUserType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    /**
     * @author Sagar Pathapelli
     * This method is used to update the UserPrivileges and it is for RiteAid
     * @param type $userId
     * @param type $actionIds
     * @return string
     */
     public function updateRoleBasedUserPrivileges($userId,$checkedActionIds, $allActionIds) {
        $returnValue = 'failure';
        try {
            $returnValue = UserPrivileges::model()->updateRoleBasedUserPrivileges($userId,$checkedActionIds, $allActionIds);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateRoleBasedUserPrivileges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    public function saveRole($role){
        try{
            $result = "failure";
            $isRoleExists = UserType::model()->isRoleExist($role);
            if($isRoleExists=='false'){
                $result = UserType::model()->saveRole($role);
            }else{
                $result = 'RoleExist';
            }
            return $result;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveRole::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }
    
          
      /*
     * getPostCountForCategory: which takes 1 arguments and 
     * returns the total no. of post.
     */
    public function getPostCountForCategory($categoryId) {
        try {
           
            $postCountsForCategory = "";
                // method calling...            
            $postCountsForCategory = CurbSideCategoryCollection::model()->getPostCountForCategory($categoryId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getPostCountForCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $postCountsForCategory;
    }
    public function resetUserPrivileges($userId) {
        try {
            $UserPrivileges = "failure";        
            $UserPrivileges = UserPrivileges::model()->resetUserPrivileges($userId);
            return $UserPrivileges;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:resetUserPrivileges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
        
    }
    public function updateUserType($userId, $userTypeId) {
        try {
            $UserType = "failure";        
            $UserType = User::model()->updateUserType($userId, $userTypeId);
            return $UserType;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
    }
    public function changeUserRole($userId,$roleId) {
        try {
            $returnVal = "failure";        
            $updateType = $this->updateUserType($userId, $roleId);
            if($updateType=="success"){
                $returnVal = $this->resetUserPrivileges($userId);
            }
            return $returnVal;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:changeUserRole::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
    }
//    
//    public function updateCategoryStatusinMongoCollection($categoryid, $categoryvalue)
//    {
//        try
//        {
//            $resultCurbsidePostCollection = CurbsidePostCollection::model()->updateCurbsideCategoryStatusInMongo($categoryid, $categoryvalue);
//            
//        } catch (Exception $ex) {
//            Yii::log("Exception in updateCategoryStatusinMongoCollection in SkiptaUserService layer=".$ex->getMessage(), "error", "application");
//        }
//    }
    
    public function getUserIdbyName($uniqueHandle){
       try{
        return UserCollection::model()->getUserIdbyName($uniqueHandle); 
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserIdbyName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   function generateUniqueHandleForUser($firstName, $lastName) {
       try{ error_log("-- generateUniqueHandleForUse--1handkle-----".$handle);
       $handle = $firstName . "." . $lastName;
        $handle = str_replace(" ", "", $handle);
        while ($this->checkHandleExist($handle)) {
            $randomNumber = mt_rand(1, 99999);
            $handle = $handle.$randomNumber;
        }
        error_log("-- generateUniqueHandleForUse-2-handkle-----".$handle);
        return $handle;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:generateUniqueHandleForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function checkHandleExist($handle){
        try{  error_log("-- checkHandleExist--1---".$handle);
        $criteria = new EMongoCriteria();
          $criteria->addCond('uniqueHandle', '==', $handle);
          $result = UserCollection::model()->find($criteria);
          error_log("-- checkHandleExist--1---".print_r($handle,1));
          if(is_object($result)){error_log("---if----");
              return true;
          }else{error_log("---else----");
              return false;
          }
          } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkHandleExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     public function getUserHierarchy($userId){
       try{
         return UserHierarchy::model()->getUserHierarchyByUserId($userId);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserHierarchy::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getUserDetailsByUserId($userId){
       try{
        return User::model()->getUserDetailsByUserId($userId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserDetailsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Praneeth
     * This method is used to get UserFollowingSubGroupsData
     * @param type $userId
     * @param type $actionIds
     * @return string
     */
    public function getUserFollowingSubGroupsData($userId,$loggedInUserId){
        try{
             $SubGroups=array();
            $userSubGroupsCollection=array();
            $userSubGroupsCollection =  SubGroupCollection::model()->getUserFollowingSubGroups($userId);
            if($userSubGroupsCollection !="failure"){
                foreach ($userSubGroupsCollection as $subGroups) {
                    
                    $groupsData = GroupCollection::model()->getGroupDetailsById($subGroups->GroupId);
                    if(is_object($groupsData) && sizeof($groupsData)>0){
                        $groupsDataArray = array();
                        $groupsDataArray['_id'] = $subGroups->_id;
                        $groupsDataArray['SubGroupName'] = $subGroups->SubGroupName;
                        $groupsDataArray['SubGroupProfileImage'] = $subGroups->SubGroupProfileImage;
                        
                        if($groupsData->IsPrivate==1){
                            $groupsDataArray['groupMembers']=$groupsData->GroupMembers;
                           $isFollowing=in_array($loggedInUserId,$groupsData->GroupMembers);                           
                           if($isFollowing==1){
                              $groupsDataArray['showSubIntroPopup']=1;  
                           }else{
                               $groupsDataArray['showSubIntroPopup']=0;  
                           }
                        }else{
                            $groupsDataArray['showSubIntroPopup']=1;  
                        }
                        array_push($SubGroups, $groupsDataArray);
                    }
            }
                return $SubGroups;
            }
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:getUserFollowingSubGroupsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');    
            return array();
        }
    }
     /**
      * @author Karteek V
      * This is used to fetch a Network configuration object based.
      * @return type
      */
     public function getConfigurationObject(){
         try{
             return NetworkConfiguration::model()->getNetworkConfiguration();
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getConfigurationObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');                       
         }
     }
     /**
      * @author Karteek V
      * @param type $model
      * @return type
      */
     public function addNewConfigParamter($model){
         try{
             return NetworkConfiguration::model()->saveModel($model);
         } catch (Exception $ex) {
           Yii::log("SkiptaUserService:addNewConfigParamter::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');       
            error_log("Exception Occurred in SkiptaUserService->addNewConfigParamter### ".$ex->getMessage());
         }
     }
     
     public function editNetworkParamter($id){
         try{
             return NetworkConfiguration::model()->getModelById($id);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:editNetworkParamter::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
            error_log("Exception Occurred in SkiptaUserService->editNetworkParamter### ".$ex->getMessage());
         }
     }

    
       /**
      * @author Praneeth
      * Description: Method used to get the groups for which the user is a member
      * @param type $UserId
      * @return $groupsCollectionUserFollowing
      */
     public function SubGroupsUserFollowing($UserId,$groupId)
     {
         try         
         { 
             $groupsCollectionUserFollowing='failure';
             $userFollowingGroups = UserProfileCollection::model()->getUserFollowingSubGroups($UserId,$groupId);             
             $subGroupIds=array();
             if($userFollowingGroups!="failure"){
                 foreach($userFollowingGroups as $subgroup){                         
                 if($groupId==$subgroup['GroupId']){
                   array_push($subGroupIds,$subgroup['SubGroupId']);       
                 }                 
                 
             }
             $groupsCollectionUserFollowing = SubGroupCollection::model()->userFollowingGroupsList($subGroupIds,$groupId);    
             }
             
             
             
         } catch (Exception $ex) { 
            Yii::log("SkiptaUserService:SubGroupsUserFollowing::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         
         return $groupsCollectionUserFollowing;
     }

     public function saveUserLoginActivity($userId){
         try{
             $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
            $segmentId = isset($tinyUserCollectionObj->SegmentId)?(int)$tinyUserCollectionObj->SegmentId:0;
             $activityIndex = CommonUtility::getUserActivityIndexByActionType("Login");
              $activityContextIndex = CommonUtility::getUserActivityContextIndexByActionType("Login");
              UserInteractionCollection::model()->saveUserLoginActivity($userId,$activityIndex,$activityContextIndex, $segmentId); 
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:saveUserLoginActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');          
            return array();
        } 
     }

      public function getUserFollowingSubGroups($UserId,$groupId)
     {
         try
         {
             $groupsCollectionUserFollowing='failure';
              $subGroupIds=array();
             $userGroups = UserProfileCollection::model()->getUserFollowingSubGroups($UserId,$groupId);   
             if($userGroups!="failure"){
                 foreach($userGroups as $subgroup){                         
                 if($groupId==$subgroup['GroupId']){
                   array_push($subGroupIds,$subgroup['SubGroupId']);       
                 } 
             }
             }
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserFollowingSubGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         
         return $subGroupIds;
     }
      public function getMoreFollowingSubGroups($UserId, $startLimit, $pageLength,$groupId)
     {
         try
         {
             $moreGroupsCollectionUserFollowing='failure';
             $subGroupIds=array();
             $userFollowingGroups = UserProfileCollection::model()->getUserFollowingSubGroups($UserId,$groupId); 
             if($userFollowingGroups!="failure"){
                 foreach($userFollowingGroups as $subgroup){                         
                 if($groupId==$subgroup['GroupId']){
                   array_push($subGroupIds,$subgroup['SubGroupId']);       
                 } 
             }
             
             $moreGroupsCollectionUserFollowing = SubGroupCollection::model()->userMoreFollowingGroupsList($subGroupIds, $startLimit, $pageLength);              
                 }
             
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getMoreFollowingSubGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         return $moreGroupsCollectionUserFollowing;
         
     }
      /**
      * @author Vamsi Krishna
      * Description: Method used to get the groups for which the user is not a member
      * @param type $UserId
      * @return $groupsCollectionUserNotFollowing
      */
     public function SubGroupsUserNotFollowing($UserId,$groupId)
     {
         try
         {
             $groupsCollectionUserNotFollowing='failure';
             $userFollowingInGroups = UserProfileCollection::model()->getUserFollowingSubGroups($UserId,$groupId);             
             $subGroupIds=array();
             if($userFollowingInGroups!='failure'){
              foreach($userFollowingInGroups as $subgroup){             
                  array_push($subGroupIds,$subgroup['SubGroupId']);                 
             }    
             }
             
           
            //$groupsCollectionUserNotFollowing = GroupCollection::model()->userNotFollowingGroupsList($userFollowingInGroups);
         } catch (Exception $ex) {
                Yii::log("SkiptaUserService:SubGroupsUserNotFollowing::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         return $subGroupIds;
     }

     public function trackMinMentionWindowOpen($loginUserId,$mentionUserId,$NetworkId){
         try {    
         
             $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($loginUserId);
            $segmentId = $tinyUserCollectionObj->SegmentId;
          $activityIndex = CommonUtility::getUserActivityIndexByActionType("MentionUsed");
          $activityContextIndex = CommonUtility::getUserActivityContextIndexByActionType("MentionMinPopup");
          UserInteractionCollection::model()->trackMinMentionWindowOpen($loginUserId,$mentionUserId,$activityIndex,$activityContextIndex,$NetworkId,$segmentId);
  
       
      } catch (Exception $ex) {
           Yii::log("SkiptaUserService:trackMinMentionWindowOpen::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return "failure";
      } 
     }

     /*
      * @author Praneeth
     * getAllEmailConfigurationDetails:
     * this function returns $emailConfigurationDetailsJSONObject.
     */
    public function getAllEmailConfigurationDetails() {
        try {// method calling...   
            $emailConfigurationDetailsJSONObject="";
            $emailConfigurationDetailsJSONObject = EmailCredentials::model()->getEmailConfigurationDetails();
            return $emailConfigurationDetailsJSONObject;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllEmailConfigurationDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     /*
      * @author Praneeth
     * getEmailConfigurationDetailsCount
     * returns the total no. of email configured.
     */
    public function getEmailConfigurationDetailsCount() {
        try {// method calling...            
            $emailConfigurationDetailsCount = EmailCredentials::model()->getEmailConfigurationDetailsCount();
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getEmailConfigurationDetailsCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $emailConfigurationDetailsCount;
    }
    
     /*
      * @author Praneeth
     * adminCreateEmailConfigurationService: which takes 1 argument and 
     * returns whether the email  exist or not
     * and if exists acknowledge already exists
     * and if  does not exists will create a new email config details
     */
    public function adminCreateEmailConfigurationService($model) {
        try {
            $returnValue = 'failure';
                $userObj = $this->checkIfConfigurationEmailExist($model);
                if(isset($userObj))
                {
                     if(isset($model->id) && !empty($model->id) )
                        {
                            //update
                            if($userObj->id == $model->id)
                            {
                                //allow
                               $emailConfigDetailsId = EmailCredentials::model()->updateEmailConfigurationDetails($model); 
                               if ($emailConfigDetailsId =='updatetrue') {
                                       $returnValue = 'updatesuccess';
                               }
                            }
                            else
                            {
                               //not allow
                               $returnValue = 'emailexists';
                            }
                        }
                            else
                            {
                                //not allow
                                 $returnValue = 'emailexists';
                            }
                }
                else
                {
                    //insert
                    $emailConfigDetailsId = EmailCredentials::model()->saveNewEmailConfigurationDetails($model);
                    if($emailConfigDetailsId !='false' && $emailConfigDetailsId !='updatetrue' )
                    {
                         $returnValue = 'success'; 
                    }
                }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:adminCreateEmailConfigurationService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          
        }
        return  $returnValue;
    }
    
    /**
     * 
     * @author:Praneeth
     * @param type $model
     * @return $result
     * Checks whether the Email configuration exists or not
     */
    public function checkIfConfigurationEmailExist($model) {       
        try {
            $result="";
            $result = EmailCredentials::model()->checkIfConfigurationEmailExist($model);
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkIfConfigurationEmailExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
     /**
     * @author:Praneeth
     * @param type configEmailId
     * @return $result
     * This is used to edit the icon details based on the iconName id
    */
     public function editEmailConfigurationDetails($configEmailId) {
         try{
             return EmailCredentials::model()->editEmailConfigurationDetails($configEmailId);
         } catch (Exception $ex) {
              Yii::log("SkiptaUserService:editEmailConfigurationDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }
    
        /*
     * getAllEmailConfigurationDetails: which takes 4 arguments and 
     * by default 2 arguments are initialized with default values those are startLimit = 0 and pageLength = 10;
     * and this function returns $emailConfigurationDetailsJSONObject.
     */
    public function getAllTemplateConfigurationDetails() {
        try {// method calling...   
            $templateConfigurationDetailsJSONObject=array();
            $templateConfigurationDetailsJSONObject = TemplateManagement::model()->getTemplateConfigurationDetails();
            return $templateConfigurationDetailsJSONObject;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllTemplateConfigurationDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     /*
     * getEmailConfigurationDetailsCount
     * returns the total no. of email configured.
     */
    public function getTemplateConfigurationDetailsCount() {
        $templateConfigurationDetailsCount=0;
        try {// method calling...            
            $templateConfigurationDetailsCount = TemplateManagement::model()->getTemplateConfigurationDetailsCount();
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getTemplateConfigurationDetailsCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $templateConfigurationDetailsCount;
    }
    
    /*
     * adminCreateTemplteConfigurationService: which takes 1 argument and 
     * returns whether the email  exist or not
     * and if exists acknowledge already exists
     * and if  does not exists will create a new email config details
     */
    public function adminCreateTemplateConfigurationService($model) {
        try {
            
            $returnValue = 'failure';
                $userObj = $this->checkIfTemplateTitleExist($model);
                if(isset($userObj))
                {
                     if(isset($model->id) && !empty($model->id) )
                        {
                            //update
                            if($userObj->id == $model->id)
                            {
                                //allow
                               $templateConfigDetailsId = TemplateManagement::model()->updateTemplateConfigurationDetails($model); 
                               if ($templateConfigDetailsId =='updatetrue') {
                                       $returnValue = 'updatesuccess';
                               }
                            }
                            else
                            {
                               //not allow
                               $returnValue = 'emailexists';
                            }
                        }
                            else
                            {
                                //not allow
                                 $returnValue = 'emailexists';
                            }
                }
                else
                {
                    //insert
                    $templateConfigDetailsId = TemplateManagement::model()->saveNewTemplateConfigurationDetails($model);
                    if($templateConfigDetailsId !='false' && $templateConfigDetailsId !='updatetrue' )
                    {
                         $returnValue = 'success'; 
                    }
                }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:adminCreateTemplateConfigurationService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          
        }
        return  $returnValue;
    }
    
      /**
     * 
     * @author:Praneeth
     * @param type $model
     * @return $result
     * Checks whether the Email configuration exists or not
     */
    public function checkIfTemplateTitleExist($model) {       
        try {
            $result="";
            $result = TemplateManagement::model()->checkIfTemplateTitleExist($model);
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkIfTemplateTitleExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    
         /**
     * @author:Praneeth
     * @param type $configTemplateId
     * @return $result
     * This is used to edit the icon details based on the template id
    */
     public function editTemplateConfigurationDetails($configTemplateId) {
         try{
             return TemplateManagement::model()->editTemplateConfigurationDetails($configTemplateId);
         } catch (Exception $ex) {
              Yii::log("SkiptaUserService:editTemplateConfigurationDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }
    
     /*
     * checks whether the title exist or not
     */
    public function getEmailCredentialsByTitle($titleType) {       
        try {
                $result = TemplateManagement::model()->getEmailBasesOnTitle($titleType);
                $emailCredentials = EmailCredentials::model()->getEmailCredentialsBasedOnEmail($result->EmailConfigured);
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getEmailCredentialsByTitle::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $emailCredentials;
    }
     /**
      * @author Karteek V
      * This method is used to fetch the analytics stats
      * @return type array
      */
     public function getAnalyticsStats($segmentId=0)
     {
         try
         {
             $totalObjectArray = array();
             $registeredUsers = User::model()->getRegisteredUsersCount($segmentId);
             $groups = GroupCollection::model()->getGroupsCount($segmentId);
             $totalCurbsideCount = CurbsidePostCollection::model()->getConversationCount($segmentId);
             $totalPostConvCount = PostCollection::model()->getConversationCount($segmentId);
             $totalGroupPostCount = GroupPostCollection::model()->getConversationCount($segmentId);
             $totalObjectArray['conversationsCount'] = $totalCurbsideCount+$totalPostConvCount+$totalGroupPostCount;
             $totalObjectArray['registeredUsers'] = $registeredUsers;
             $totalObjectArray['groups'] = $groups;
            
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAnalyticsStats::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         
         return $totalObjectArray;
     }
   
      /**
      * -----------------------Purpose: For Data Migration only--------------------
      * @author Praneeth
      * Description: Method used to get the group id based on group name
      * @param type $categoryName
      * @return $moreGroupsCollectionUserFollowing
      */
     public function getGroupIdByGroupName($groupName)
     {
         try
         {
              
             $result = GroupCollection::model()->getGroupIdByGroupName($groupName);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getGroupIdByGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         return $result;
     }
    
     public function saveCuratorAccessTokenService($userId, $accessToken) {
         try{
         User::model()->saveCuratorAccessToken($userId, $accessToken);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveCuratorAccessTokenService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
     }
      public function getCuratorAccessTokenService($userId)  {
         try{
          return User::model()->getCuratorAccessToken($userId);
          } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getCuratorAccessTokenService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
     }
     public function getNeworkDetailsService($urlORname) {
         try{
         return Network::model()->getNeworkDetails($urlORname);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getNeworkDetailsService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
     }
     
      
       /**
      * @author Praneeth
      * Description: Method used to get the analytics data
      * @param type start date , end date
      * @return $deviceUsabilityCollection
      */
     public function GetDeviceUsabilityBasedOnDateRangeAndType($startDate,$endDate,$type, $segmentId=0){
         try{
         return TrackBrowseDetailsCollection::model()->GetAnalyticsReportsBasedonDateRange($startDate,$endDate,$type, $segmentId);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:GetDeviceUsabilityBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }
    
      /**
      * @author Praneeth
      * Description: Method used to get the group id based on group name
      * @param type $categoryName
      * @return $moreGroupsCollectionUserFollowing
      */
    public function GetBrowserUsabilityBasedOnDateRangeAndType($startDate,$endDate,$type, $segmentId=0){
        try{
         return TrackBrowseDetailsCollection::model()->GetBrowserUsabilityBasedOnDateRangeAndType($startDate,$endDate,$type, $segmentId);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:GetBrowserUsabilityBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
                }
            
     public function GetDeviceUsabilityPieChartBasedOnDateRangeAndType($startDate,$endDate, $segmentId=0){
         try{
         return TrackBrowseDetailsCollection::model()->GetDevicePieChartUsabilityBasedOnDateRangeAndType($startDate,$endDate, $segmentId);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:GetDeviceUsabilityPieChartBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }
    
    public function GetBrowserUsabilityPieChartBasedOnDateRangeAndType($startDate,$endDate,$type, $segmentId=0){
        try{
         return TrackBrowseDetailsCollection::model()->GetBrowserUsabilityPieChartBasedOnDateRangeAndType($startDate,$endDate, $segmentId);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:GetBrowserUsabilityPieChartBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }
    
     public function GetLocationPieChartBasedOnDateRangeAndType($startDate,$endDate,$type, $segmentId=0){
         try{
         return TrackBrowseDetailsCollection::model()->GetLocationPieChartUsabilityBasedOnDateRangeAndType($startDate,$endDate,$segmentId);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:GetLocationPieChartBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }

    
        /**
      * @author Praneeth
      * Description: Method used to get the group id based on group name
      * @param type $categoryName
      * @return $moreGroupsCollectionUserFollowing
      */
     public function GetLocationUsabilityBasedOnDateRangeAndType($startDate,$endDate,$type, $segmentId=0){
        try{ 
         return TrackBrowseDetailsCollection::model()->GetLocationLineGraphReportsBasedonDateRange($startDate,$endDate,$type,$segmentId);
         } catch (Exception $ex) {
            Yii::log("SkiptaUserService:GetLocationUsabilityBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }
     
    
          
       /**
      * @author Praneeth
      * Description: Method used to get the group usability analytics
      * @param type $categoryName
      * @return $deviceUsabilityCollection
      */
     public function GetGroupUsabilityLineChartBasedOnDateRangeAndType($groupId,$startDate,$endDate,$usabilityType,$type){
         try{
            if($usabilityType == 'GroupDeviceUsability') 
            {
                return TrackBrowseDetailsCollection::model()->GetGroupDeviceUsabilityAnalyticsReportsBasedonDateRange($groupId,$startDate,$endDate,$type);
            }
            if($usabilityType =='GroupLocationUsability')
             {
                return TrackBrowseDetailsCollection::model()->GetGroupLocationUsabilityAnalyticsReportsBasedonDateRange($groupId,$startDate,$endDate,$type);
             }
             if($usabilityType =='GroupBrowserUsability')
             {
                return TrackBrowseDetailsCollection::model()->GetGroupBrowserUsabilityAnalyticsReportsBasedonDateRange($groupId,$startDate,$endDate,$type);
             }
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:GetGroupUsabilityLineChartBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         
    }
    
     public function GetGroupUsabilityPieChartBasedOnDateRangeAndType($groupId,$startDate,$endDate,$type){
         try {
             if($type =='GroupDeviceUsability')
             {
                return TrackBrowseDetailsCollection::model()->GetGroupDevicePieChartUsabilityBasedOnDateRangeAndType($groupId,$startDate,$endDate); 
             }
             if($type =='GroupLocationUsability')
             {
                return TrackBrowseDetailsCollection::model()->GetGroupLocationPieChartUsabilityBasedOnDateRangeAndType($groupId,$startDate,$endDate); 
             }
             if($type =='GroupBrowserUsability')
             {
                return TrackBrowseDetailsCollection::model()->GetGroupBrowserPieChartUsabilityBasedOnDateRangeAndType($groupId,$startDate,$endDate);  
             }
             
             
         } catch (Exception $ex) {
              Yii::log("SkiptaUserService:GetGroupUsabilityPieChartBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
  
         
    }


    public function getColumnNames(){
        try{
            return CustomField::model()->getColumnNames();
        }catch(Exception $ex){
           Yii::log("SkiptaUserService:getColumnNames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
     public function getAllUsers(){
        try {
            $users=UserCollection::model()->getAllUsersIds();
            return $users;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getAllUsers### ".$ex->getMessage());
        }
    }
 public function saveMobileSession($userId,$sessionId,$deviceInfo,$pushToken){
     try{
     return MobileSessions::model()->saveMobileSession($userId,$sessionId,$deviceInfo,$pushToken);
     }catch(Exception $ex){
           Yii::log("SkiptaUserService:saveMobileSession::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }    
 }
 public function saveMobileSession_V6($userId,$deviceInfo,$pushToken){
     try{
     return MobileSessions::model()->saveMobileSession_V6($userId,$deviceInfo,$pushToken);
     }catch(Exception $ex){
           Yii::log("SkiptaUserService:saveMobileSession_V6::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }    
 }
   
     public function checkAutoLogin($sessionId,$userId) {
         try {
              $result = MobileSessions::model()->checkAutoLogin($sessionId,$userId);
              return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:checkAutoLogin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
      public function logout($sessionId,$userId) {
         try {
              $result = MobileSessions::model()->logout($sessionId,$userId);
              return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:logout::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
 public function getAdvertisements(){
      try {
          $advertisements=Advertisements::model()->loadAllAdvertisements();
          return $advertisements;
      } catch (Exception $ex) {
          Yii::log("SkiptaUserService:getAdvertisements::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in SkiptaUserService->getAdvertisements### ".$ex->getMessage());
      }
    }
    
  public function saveAdvertisements(){
      try {
          $advertisementsObj=new AdvertisementsCollection();
             $advertisementsObj->Name=$obj->Name;
             $advertisementsObj->Type=$obj->Type;
             $advertisementsObj->Url=$obj->Url;
             $advertisementsObj->DisplayPage=$obj->DisplayPage;
             $advertisementsObj->DisplayPosition=$obj->DisplayPosition;
             $advertisementsObj->Status=$obj->Status;
             $advertisementsObj->CreatedUserId=$obj->CreatedUserId;
             $advertisementsObj->TimeInterval=$obj->TimeInterval;
             $advertisementsObj->ExpiryDate=$obj->ExpiryDate;
             $advertisementsObj->Priority=$obj->Priority;
             $advertisementsObj->GroupId=$obj->GroupId;
             $advertisementsObj->CreatedOn=$obj->CreatedOn;
          AdvertisementsCollection::model()->saveAdvertisements($advertisementsObj);
      } catch (Exception $ex) {
          Yii::log("SkiptaUserService:saveAdvertisements::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }  
    public function getAllUserExceptNetworkAdminService($userId)
    {
         try {
            $users=UserCollection::model()->getAllUsersExceptNetworkAdmin($userId);
            return $users;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllUserExceptNetworkAdminService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }

    
   public function getBadgeInfo()
    {
         try {
            $badges=Badges::model()->getBadgeDetails();
            return $badges;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getBadgeInfo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           
        }
        
    }
    
     public function getBadgeInfoById($BadgeId)
    {
         try {
            $badges=Badges::model()->getBadgeById($BadgeId);
            $badges->image_path = Yii::app()->params['ServerURL'].$badges->image_path;
            return $badges;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getBadgeInfoById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           
        }
        
    }
    
     public function getBadgeLevelInfoByBadgeId($badgeId,$levelValue)
    {
         try {
            $badges=BadgesLevel::model()->getBadgeDetailsByBadgeId($badgeId,$levelValue);
            return $badges;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getBadgeLevelInfoByBadgeId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
        
    }
    
    public function getBadgeInfoByContextAndBadgeName($context)
    {
         try {
            $badgeInfo=Badges::model()->getBadgeDetailsByCriteria($context);
            return $badgeInfo;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getBadgeInfoByContextAndBadgeName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           
        }
        
    }
    
   public function getUserBadgeCollectionByCriteria($userId,$badgeId,$limit)
    {
         try {
          
            $badgeInfo=  UserBadgeCollection::model()->getUserBadgeCollectionByCriteria($userId,$badgeId,$limit);
          
            return $badgeInfo;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserBadgeCollectionByCriteria::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
        
    }
    
    public function saveUserBadgeCollection($badgeCollectionObj)
    {
         try {
         
            $badgeInfo=  UserBadgeCollection::model()->saveUserBadgeCollection($badgeCollectionObj);
            return $badgeInfo;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveUserBadgeCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
        
    }
    
    public function checkMobileLogin($userId) {
          try {
            $isLogin= MobileSessions::model()->checkMobileLogin($userId);
            return $isLogin;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkMobileLogin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
        
    }
    
      public function getBadgesNotShownToUser($userId,$limit)
    {
         try {
            $badgeInfo=  UserBadgeCollection::model()->getBadgesNotShownToUser($userId,$limit);
            return $badgeInfo;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getBadgesNotShownToUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
        
    }
    
    public function updateBadgeShownToUser($badgeCollectionId)
    {
          try {
            $badgeCollectionResult=  UserBadgeCollection::model()->updateBadgeShownToUser($badgeCollectionId);
            return $badgeInfo;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateBadgeShownToUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           
        }
    }

    
     /**
      * @author Haribabu
      * Description: Method used to save the referral details
      * @param type $linkId
      * @return $linkId
      */
    public function SaveReferralLink($userId,$message){
         try {
            $returnValue = 'failure';
            $LinkId = ReferralLinks::model()->saveUserReferrerDetails($userId, $message);
            if ($LinkId != 'failure') {
                $returnValue = $LinkId;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:SaveReferralLink::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
      * @author Haribabu
      * Description: Method used to save the referral link details
      * @param type $linkId
      * @return $linkId
      */
    public function SaveReferralLinkDetails($linkId, $userId, $email){
         try {
             
            $returnValue = 'failure';
            $LinkDetails = UserLinks::model()->saveUserLinkDetails($linkId, $userId, $email);
            if ($LinkDetails) {
                $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:SaveReferralLinkDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
  /**
      * @author Haribabu
      * Description: Method used to check refered user exist or not 
      * @param type $userId
      * @return $user object
      */  
  public function checkRecipientEmailExist($email,$linkId){
     try {
      $returnValue = 'failure';
            $UserDetails = UserLinks::model()->checkRecipientEmailExist($email, $linkId);
            if ($UserDetails == 'success') {
                $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkRecipientEmailExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
  /**
    * @author Haribabu
    * Description: Method used to get the referrer details
    * @param type $userId
    * @return $user object
    */ 
  public function getReferralDetails($email,$linkId){
      try {
            $returnValue = 'failure';
            $UserDetails = UserLinks::model()->getUserReferralDetails($email, $linkId);
            if ($UserDetails) {
                $returnValue = $UserDetails;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getReferralDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
  /**
    * @author Haribabu
    * Description: Method used to check refered user is valid user or not
    * @param type $userId
    * @return $user object
    */ 
  public function GetReferralMessagedetails($linkId){
      
      try {
            $returnValue = 'failure';
            $LinkIdDetails = ReferralLinks::model()->getUserReferralDetails($linkId);
            if ($LinkId != 'failure') {
                $returnValue = $LinkIdDetails;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:GetReferralMessagedetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
   public function getUserProfileDetailsForReferral($userId){
      try {   
          $returnValue='failure';
          //$userProfileCollection=UserProfileCollection::model()->getUserProfileCollection($userId);
          $tinyUserCollection=UserCollection::model()->getTinyUserCollection($userId);
          $userDetailsfromMysql=User::model()->getUserProfileByUserId($userId);
          $userPersonalInformation=ProfessionalInformation::model()->getProfessionalInformationByUserId($userId);  
          $userProfile=new UserProfileBean();    
          $userProfile->UserId=$userDetailsfromMysql['UserId'];
          $userProfile->FirstName=$userDetailsfromMysql['FirstName'];
          $userProfile->LastName=$userDetailsfromMysql['LastName'];
          $userProfile->Company=$userDetailsfromMysql['Company'];
          $userProfile->Network=$userDetailsfromMysql['NetworkId'];
          $userProfile->ContactNumber=$userDetailsfromMysql['Phone'];
          $userProfile->Zip=$userDetailsfromMysql['Zip'];
          //$userProfile->Designation=$userDetailsfromMysql['Designation'];
         //-----------Added if condition because null is displayed for AboutMe as old data is migrated with null --------Praneeth
          if($tinyUserCollection->AboutMe == null || $tinyUserCollection->AboutMe =="null"){
            $userProfile->AboutMe="";
          }
          else{
               $userProfile->AboutMe=$tinyUserCollection->AboutMe;
          }
          $userProfile->DisplayName=$tinyUserCollection->DisplayName;
          $userProfile->ProfilePicture=$tinyUserCollection->ProfilePicture;
          $userProfile->profile250x250=$tinyUserCollection->profile250x250;
          $userProfile->profile70x70=$tinyUserCollection->profile70x70;
          $userProfile->profile45x45=$tinyUserCollection->profile45x45;
          
         
          //$userProfile->IsFollowed = in_array($loggedInUserId,$userProfileCollection->userFollowers);
       
        return  $userProfile;
      } catch (Exception $ex) {          
            Yii::log("SkiptaUserService:getUserProfileDetailsForReferral::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
      }
    }
    
    public function getOpinionDetails($userId){
        try{
            $result = UserOpinion::model()->isUserAlreadyDoneSurvey($userId);            
            return Opinion::model()->getOpinionDetails($userId);
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getOpinionDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getOpinionDetails### ".$ex->getMessage());
        }
    }
    public function saveOpinionDetails($userId,$opinionId,$optionValue){
        try{
            return UserOpinion::model()->saveOpinionDetails($userId,$opinionId,$optionValue);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveOpinionDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->saveOpinionDetails### ".$ex->getMessage());
        }
    }
    public function getSurveyResults($opId){
        try{
            return Opinion::model()->getSurveyResults($opId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getSurveyResults::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function checkPTCMember($email){
        try{
            return OtsukaPTCMembers::model()->checkPTCMember($email);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkPTCMember::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getSurveyQuestions(){
        try{
            return SurveyMonkeyOptions::model()->getSurveyQuestions();
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getSurveyQuestions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getSurveyQuestions### ".$ex->getMessage());
        }
    }
    
    public function saveSurveyOpinions($userId,$optionId,$questionId,$others,$rating){
        try{            
            SurveyMonkeyResults::model()->saveSurveyOpinions($userId,$optionId,$questionId,$others,$rating);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveSurveyOpinions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->saveSurveyOpinions### ".$ex->getMessage());
        }
    }
    public function getSurveyOpinionsRes($userId){
        try{
           return SurveyMonkeyResults::model()->getSurveyOpinionsRes($userId); 
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getSurveyOpinionsRes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    function saveTopicArtifacts($Artifacts) {

     try {
           
         $returnValue = 'failure';
            $Resource = array();
            $folder = Yii::app()->params['WebrootPath'];
            $returnarry = array();
            if ($Artifacts != "") {
                $ExistArtifact = $folder . $Artifacts;

                if (!file_exists($ExistArtifact)) {
                    $imgArr = explode(".", $Artifacts);
                    $date = strtotime("now");
                    $finalImg_name = $imgArr[0] . '.' . end($imgArr);
                    $finalImage = trim($imgArr[0]) . '.' . end($imgArr);

                    $fileNameTosave = $folder . '/temp/' . $imgArr[0] . '.' . end($imgArr);
                    $sourceArtifact = $folder . '/temp/' . $Artifacts;
                    rename($sourceArtifact, $fileNameTosave);
                    //  $filename=$result['filename'];
                    $extension = substr(strrchr($Artifacts, '.'), 1);
                    $extension = strtolower($extension);

                    $path = 'Profile';

                    $path = '/upload/Topic/' . $path;
                    if (!file_exists($folder . '/' . $path)) {

                        mkdir($folder . '/' . $path, 0755, true);
                    }
                    $sourcepath = $fileNameTosave;
                    $destination = $folder . $path . '/' . $finalImage;
                    if (file_exists($sourcepath)) {
                        if (copy($sourcepath, $destination)) {
                            $newfile = trim($imgArr[0]) . '_' . $date . '.' . end($imgArr);
                            //  $newfile=trim($imgArr[0]) .'.' . $imgArr[1];
                            $finalSaveImage = $folder . $path . '/' . $newfile;
                            rename($destination, $finalSaveImage);
                            $UploadedImage = $path . '/' . $newfile;
                            $img = Yii::app()->simpleImage->load($folder.$UploadedImage);
                            $img->resizeToWidth(50);
                            $img->save($folder.$UploadedImage);
                            $Resource['ResourceName'] = $artifact;
                            $Resource['Uri'] = $UploadedImage;
                            $Resource['Extension'] = $extension;
                            $Resource['ThumbNailImage'] = $UploadedImage;

                            // unlink($sourcepath);
                            $returnValue = "success";
                        }
                    } else {
                        $UploadedImage = $path . '/' . $Artifacts;
                    }
                } else {
                    $UploadedImage = $Artifacts;
                    $Resource['ResourceName'] = "";
                    $Resource['Uri'] = "";
                    $Resource['Extension'] = "";
                    $Resource['ThumbNailImage'] = $UploadedImage;
                }
            }
            return $Resource;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveTopicArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }  

    
    }
    
    /**
     * @author Karteek V
     * @useful This is used to get UserBadgesData by Profile Id.
     * @param type $userId = profileId
     * @return object
     */
    public function getUserBadgesData($userId){
        try{
            return UserBadgeCollection::model()->getUserBadges($userId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserBadgesData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getUserBadgesData### ".$ex->getMessage());
        }
    }

    public function getOauthProviderDetailsByType($type,$value)
    {
         try {
            $providersData=OauthProviderNetworks::model()->getOauthProviderDetailsByType($type,$value);
            return $providersData;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getOauthProviderDetailsByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
        
    } 
      public function getAllOauthProviderDetails()
    {
         try {
            $providersData=OauthProviderNetworks::model()->getAllOauthProviderDetails();
            return $providersData;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllOauthProviderDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
    }
    
    public function getUserDetailsByNetworkName($networkName)
    {
         try {
           $users = User::model()->getAllActiveUsersByNetworkName($networkName);
           
            return $users;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserDetailsByNetworkName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
    }
    
    public function getAllActiveUserInfoByNetworkName($networkName)
    {
         try {
           $users = User::model()->getAllActiveUserInfoByNetworkName($networkName);
           
            return $users;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllActiveUserInfoByNetworkName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
    }
    
    public function getDSNCommonNotificationCollectionByCriteria($networkName,$UserId)
    {
        try {
           $dsnNotifications = DSNNotificationCollection::model()->getDSNCommonNotificationCollectionByCriteria($networkName,$UserId);
           
            return $dsnNotifications;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getDSNCommonNotificationCollectionByCriteria::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
    }
    
 
     /**
     * @author swathi
     * @param type $postId
     * @return type
     */
    public function getUserBadgeObjectById($postId) {
        try {
           $postObj=UserBadgeCollection::model()->getUserBadgeCollectionById($postId);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserBadgeObjectById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $postObj;
    }


/**
 * all the below methods are used to get the data for new profile 
 */    

   public function getEducations() {
        try {
           
            $object = Education::model()->getAllEducations();
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getEducations::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getEducations### ".$ex->getMessage());
        }
        return $object;
    }
     public function getInterests() {
        try {
         
            $object = Interests::model()->getAllInterests();
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getInterests::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getInterests### ".$ex->getMessage());
        }
        return $object;
    }

    
  /* This Method is used for update the user profile in both mysql and mongo 
      it accepts userprofileForm obj and customForm Obj
  *   */     
    public function UpdateUserCollection($userProfileform,$oldUserObj){
     try {
         $userCollectionModel=new UserCollection();
//         if(isset($userProfileform['country']) && $oldUserObj['country']!=$userProfileform['country'])
//         {
//          $NetworkId= Network::model()->getNeworkId($userProfileform['country']);
//           (isset($NetworkId) && $NetworkId!='error')?'':$NetworkId=1;               
//           $userProfileform['network']=$NetworkId;
//         }
         $result=User::model()->updateUser($userProfileform,$oldUserObj["UserId"]);  
         if($result=='success'){ 
         $userId= (int)$oldUserObj["UserId"];
         $userCollectionModel->UserId=$userId;
         $userCollectionModel->DisplayName=$userProfileform['firstName']." ".$userProfileform['lastName'];
         $userCollectionModel->State=$userProfileform['state'];
         $userCollectionModel->CountryId=$userProfileform['country'];
          $userCollectionModel->AboutMe=$userProfileform['aboutMe'];
 //        $userCollectionModel->NetworkId=(int)$NetworkId;
         $displayName = trim($userCollectionModel->DisplayName);
         $uniqueHandle="";
         if(strlen($displayName)>0){
            $uniqueHandle = $this->generateUniqueHandleForUser($userProfileform['firstName'],$userProfileform['lastName']);
         }else{
             $emailPref = explode("@", $userProfileform['email']);
             $displayName = $emailPref[0];
             $uniqueHandle = $this->generateUniqueHandleForUser($displayName,"");
         }
         $userCollectionModel->uniqueHandle=$uniqueHandle;
     
           UserCollection::model()->updateUserCollection($userCollectionModel); 
         }
        /**********saving the availability in userAchievementsCollection************/
        $userDetails=UserCollection::model()->getTinyUserCollection($userId); 
        $userAchievementsInputBean = new UserAchievementsInputBean();
        $userAchievementsInputBean->UserId = $userId;
        $userAchievementsInputBean->UserClassification = $userDetails->UserClassification;
        $userAchievementsInputBean->OpportunityType = "";
        $userAchievementsInputBean->SegmentId = $userDetails->SegmentId;
        $userAchievementsInputBean->NetworkId = $userDetails->NetworkId;

        Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));
     } catch (Exception $ex) {
         Yii::log("SkiptaUserService:UpdateUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in SkiptaUserService->UpdateUserCollection### ".$ex->getMessage());
     }
  } 
  
  /*
     * userupdatePasswodService:used to update the new password with old password 
     */
    public function userUpdatePasswodService($userId,$model)
    { 
        $result ='1';
        
        try{
            $result = User::model()->updateUserPassword($userId,$model);
            if ($result == '0') {
                $user = User::model()->findByAttributes(array("UserId" => $userId));
                $to = $user->Email;
                $subject = $user->FirstName . ", your password was successfully reset.";

                $messageview = "UpdatePasswordMail";
                $params = array('myMail' => $user->FirstName);
                $sendMailToUser = new CommonUtility;
                $mailSentStatus = $sendMailToUser->actionSendmail($messageview, $params, $subject, $to);
            }
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:userUpdatePasswodService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }


     public function getExperience() {
        try {
           
            $object = Experience::model()->getAllExperiences();
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getExperience::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getExperience### ".$ex->getMessage());
        }
        return $object;
    }
    public function getAchievements(){
        try {
           
            $object = Achievements::model()->getAllAchievements();
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAchievements::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getAchievements### ".$ex->getMessage());
        }
        return $object;
    } 

    public function getDropdownsListForCVEdit($id,$category) {
        try {
            if($category=="Education"){
                $object = Education::model()->getEducationsForCVEdit($id);
            }else if($category=="Experience"){
                 $object = Experience::model()->getExperienceForCVEdit($id);
            }else if($category=="Interests"){
                 $object = Interests::model()->getExperienceForCVEdit($id);
            }else if($category=="Achievements"){
                 $object = Achievements::model()->getExperienceForCVEdit($id);
            }
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getDropdownsListForCVEdit::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getDropdownsListForCVEdit### ".$ex->getMessage());
        }
        return $object;
    }
  
  public function saveUserCV($CVPostData,$UserId,$recent){
      try{
      $educationDetails = UserEducation::model()->saveUserCVEducationDetails($CVPostData, $UserId);
       $experienceDetails = UserExperience::model()->saveUserCVExperienceDetails($CVPostData, $UserId);
        $InterestsDetails = UserInterests::model()->saveUserCVInterestsDetails($CVPostData, $UserId);
       $AchievementDetails= UserAchievements::model()->saveUserCVAchievementDetails($CVPostData, $UserId);
        $PublicationsDetails = UserPublications::model()->saveUserPublicationDetails($CVPostData, $UserId);

        $this->saveUserCVPublicationCollection($UserId,$recent);
        
       Yii::app()->amqp->stream(json_encode(array("Obj"=>array("UserId"=>$UserId),"ActionType"=>"UserRecommendation")));            
        return $educationDetails;
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:saveUserCV::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function UpdateUserCV($CVPostData,$UserId,$recent){
        try{
        $educationDetails = UserEducation::model()->updateUserCVEducationDetails($CVPostData, $UserId);
        $experienceDetails = UserExperience::model()->updateUserCVExperienceDetails($CVPostData, $UserId);
       $InterestsDetails = UserInterests::model()->updateUserCVInterestsDetails($CVPostData, $UserId);
        $AchievementDetails= UserAchievements::model()->updateUserCVAchievementDetails($CVPostData, $UserId);
       $this->saveUserCVPublicationCollection($UserId,$recent);
        $PublicationsDetails = UserPublications::model()->updateUserPublicationDetails($CVPostData, $UserId);
        Yii::app()->amqp->stream(json_encode(array("Obj"=>array("UserId"=>$UserId),"ActionType"=>"UserRecommendation")));           
        return $educationDetails;
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:UpdateUserCV::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getUserCVDetails($UserId){
                try{
             $returnvalue = 'failure';
            $resultArray=array();
            $educationDetails = UserEducation::model()->getUserCVEducationDetails($UserId);
            $experienceDetails = UserExperience::model()->getUserCVExperienceDetails($UserId);
            $InterestsDetails = UserInterests::model()->getUserCVInterestsDetails($UserId);
            $AchievementDetails= UserAchievements::model()->getUserCVAchievementsDetails($UserId);
            $PublicationsDetails = UserPublications::model()->getUserCVpublicationDetails($UserId);
        
            $resultArray['education']=$educationDetails;
            $resultArray['experience']=$experienceDetails;
            $resultArray['interests']=$InterestsDetails;
            $resultArray['achievements']=$AchievementDetails;
            $resultArray['publications']=$PublicationsDetails;
            $returnvalue=$resultArray;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserCVDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       return $returnvalue;
       
    }
    
    public function getUserCVDropdownDetails($educationIds,$interestIds,$experienceIds,$achievementIds){
                try{
             $returnvalue = 'failure';
            $resultArray=array();
           $educationId=  implode(',', $educationIds);
           $interestId=  implode(',', $interestIds);
            $experienceId=  implode(',', $experienceIds);
            $achievementId=  implode(',', $achievementIds);
            $educations= Education::model()->getEducationsForCVEdit($educationId);
            $experiences= Experience::model()->getExperienceForCVEdit($experienceId);
            $Interests = Interests::model()->getExperienceForCVEdit($interestId);
            $Achievements= Achievements::model()->getExperienceForCVEdit($achievementId);
          
            $resultArray['education']=$educations;
            $resultArray['experience']=$experiences;
            $resultArray['interests']=$Interests;
            $resultArray['achievements']=$Achievements;
           
            $returnvalue=$resultArray;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserCVDropdownDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       return $returnvalue;
       
    }  
    

    

    public function  getUserFollowingHashtagsDataForProfile($userId){
        try {
             $hashTags=array();
             $hashTagList=array();
             $totalHashTagCount=0;
             $type=array('hashtagsFollowing'=>true);
             $limit=5;
            $userProfileCollection=UserProfileCollection::model()->getUserProfileCollectionByType($userId,$type,$limit);
            if(isset($userProfileCollection->hashtagsFollowing) && is_array($userProfileCollection->hashtagsFollowing)){
                $hashtagsFollowing = array_unique($userProfileCollection->hashtagsFollowing);
                $totalHashTagCount=count($hashtagsFollowing);
                $i=0;
                foreach ($hashtagsFollowing as $hashtag) {
                    if($i<5){
                        $hashTagData = HashTagCollection::model()->getHashTagsById($hashtag);
                    if(is_object($hashTagData) && sizeof($hashTagData)>0){
                        $hashTagArray = array();
                        $hashTagArray['id'] = $hashTagData->_id;
                        $hashTagArray['name'] = $hashTagData->HashTagName;
                        array_push($hashTags, $hashTagArray);
                        $i++;
                    } 
                  
                }else{
                    break;
                }
                   
                }
            }
            $hashTagList['hashtags']=$hashTags;
            $hashTagList['totalHashTagCount']=$totalHashTagCount;
            return $hashTagList;
        } catch (Exception $ex) {
           Yii::log("SkiptaUserService:getUserFollowingHashtagsDataForProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
   public function getUserFollowingGroupsDataForProfile($userId){
       try {
            try{
            $groups=array();
            $groupsList=array();
            $totalGroupsCount=0;
             $type=array('groupsFollowing'=>true);
             
             $limit=5;
            $userProfileCollection=UserProfileCollection::model()->getUserProfileCollectionByType($userId,$type,$limit);
            
            if(isset($userProfileCollection->groupsFollowing) && is_array($userProfileCollection->groupsFollowing)){
                $groupsFollowing = array_unique($userProfileCollection->groupsFollowing);                
              $totalGroupsCount=count($groupsFollowing);
                $i=0;
                foreach ($groupsFollowing as $groupId) {
                    if($i<5){
                         $groupsData = GroupCollection::model()->getGroupDetailsById($groupId);
                    if(is_object($groupsData) && sizeof($groupsData)>0){
                        $groupsDataArray = array();
                        $groupsDataArray['id'] = $groupsData->_id;
                        $groupsDataArray['name'] = $groupsData->GroupName;
                        $groupsDataArray['groupProfileImage'] = $groupsData->GroupProfileImage;
                        
                        if($groupsData->IsPrivate==1){
                            $groupsDataArray['groupMembers']=$groupsData->GroupMembers;
                           $isFollowing=in_array($loggedInUserId,$groupsData->GroupMembers);                           
                           if($isFollowing==1){
                              $groupsDataArray['showIntroPopup']=1;  
                           }else{
                               $groupsDataArray['showIntroPopup']=0;  
                           }
                        }else{
                            $groupsDataArray['showIntroPopup']=1;  
                        }
                        array_push($groups, $groupsDataArray);
                       }
                       $i++;
                    }else{
                        break;
                    }
                   
            }
            
            $groupsList['groupsList']=$groups;
            $groupsList['totalGroupsCount']=$totalGroupsCount;
            
            }
            return $groupsList;
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:getUserFollowingGroupsDataForProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');         
            return array();
        }
       } catch (Exception $ex) {
           Yii::log("SkiptaUserService:getUserFollowingGroupsDataForProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
      
       public function getUserFollowingCurbsideCategoriesDataForProfile($userId){
         
         $categories=array();
         $totalCategoriesCount=0;
         $categoriesList=array();
           try{
            
             $type=array('curbsideFollowing'=>true);
             $limit=5;
            $userProfileCollection=UserProfileCollection::model()->getUserProfileCollectionByType($userId,$type,$limit);
            
            if(isset($userProfileCollection->curbsideFollowing) && is_array($userProfileCollection->curbsideFollowing)){
                $categoriesFollowing = array_unique($userProfileCollection->curbsideFollowing);
                $totalCategoriesCount=count($categoriesFollowing);
                $i=0;
                foreach ($categoriesFollowing as $categoryId) {
                    if($i<5){
                    $curbsideCategoryData = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId($categoryId);
                    if(is_object($curbsideCategoryData) && sizeof($curbsideCategoryData)>0){
                        $curbsideCategoryArray = array();
                        $curbsideCategoryArray['id'] = $curbsideCategoryData->CategoryId;
                        $curbsideCategoryArray['name'] = $curbsideCategoryData->CategoryName;
                        array_push($categories, $curbsideCategoryArray);
                      }
                      $i++;
                    }else{
                        break;
                    }
                   
                }
            }
            
            $categoriesList['categories']=$categories;
            $categoriesList['totalCategoriesCount']=$totalCategoriesCount;
            return $categoriesList;
        }catch(Exception $ex){
            Yii::log("SkiptaUserService:getUserFollowingCurbsideCategoriesDataForProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $categories;
        }
    }
  public function getFollowersAndFollowing($userId,$FAndF){
      try {
          $type=array($FAndF=>true);
             $limit=5;
             $userFollowingAndFollowers=array();
            $userProfileCollection=UserProfileCollection::model()->getUserProfileCollectionByType($userId,$type,$limit);
             $i=0;
           if(count($userProfileCollection->$FAndF)>0){
             foreach($userProfileCollection->$FAndF as $userF){
                    if($i<9){
                        $userDetails=UserCollection::model()->getTinyUserCollection($userF);
                 array_push($userFollowingAndFollowers,$userDetails->ProfilePicture);
                   $i++;
                    }else{
                        break;
                    }
                 
                 
             }             
           }           
           return $userFollowingAndFollowers;
      } catch (Exception $ex) {
          Yii::log("SkiptaUserService:getFollowersAndFollowing::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    
   public function updatePersonalInformationByType($value,$type,$userId){
       try {
           $pDetails=ProfessionalInformation::model()->getProfessionalInformationByUserId($userId);          
           if(is_object($pDetails)){           
            $returnValue=ProfessionalInformation::model()->updatePersonalInformationByType($value,$type,$userId);    
           }else{               
               $proInfo=new ProfessionalInformation();
               $proInfo->Degree='';
               $proInfo->Highest_Education='';
               $proInfo->School='';
               $proInfo->Years_Experience='';
               $proInfo->UserId=$userId;
               if($type=='Position'){
               $proInfo->Position=$value;                   
               }
               if($type=='Speciality'){
               $proInfo->Speciality=$value;                   
               }
               ProfessionalInformation::model()->saveProfessionalInformation($proInfo,$userId);
           }
           
           
           
           return 'success';
       } catch (Exception $ex) {
          Yii::log("SkiptaUserService:updatePersonalInformationByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }

      }

public function getUserInteractionsCount($userId){
    try {
        $returnValue=UserInteractionCollection::model()->getUserInteractionsCount($userId);
        return $returnValue;
    } catch (Exception $ex) {
      Yii::log("SkiptaUserService:getUserInteractionsCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}

    public function saveUserCVPublicationCollection($userId,$recent){
        try{
            $recentArr = array();
            $recentArr = explode(",",$recent);
            if(isset($recentArr[0]) && !empty($recentArr[0])){
                
                $CVPostData = ucfirst($recentArr[0]);    
                $categoryId = CommonUtility::getIndexBySystemCategoryType('CV');
                $postType=  CommonUtility::sendPostType('CV');
                $obj = $uobj = array();            
    //            $CVPostData->RecentUpdated="Publications";
                if($CVPostData == "Publications"){
                    $uobj = UserPublications::model()->getUserCVpublicationDetails($userId);
                }else if($CVPostData == "Education"){
                    $uobj = UserEducation::model()->getUserCVEducationDetails($userId);
                }else if($CVPostData == "Experience"){
                    $uobj = UserExperience::model()->getUserCVExperienceDetails($userId);
                }else if($CVPostData == "Interests"){
                    $uobj = UserInterests::model()->getUserCVInterestsDetails($userId);
                } if($CVPostData == "Achievements"){                
                    $uobj = UserAchievements::model()->getUserCVAchievementsDetails($userId);
                } 
                $obj['Title'] = $CVPostData;
                if($uobj!="failure"){
                if($CVPostData == "Publications"){
                    $obj['Description'] = "Publication Name as ".$uobj[0]['Name']." and Date of Published as ".$uobj[0]['PublicationDate'];
                }elseif($CVPostData == "Interests"){                    
                    $interestString = "Academic Interests";
                    if($uobj[0]['InterestId'] == 2){
                        $interestString = "Research Interests";
                    }else if($uobj[0]['InterestId'] == 3){
                        $interestString = "Personal Interests";
                    }
                    $obj['Description'] = "$interestString as ".$uobj[0]['Tags'];                    
                }elseif($CVPostData == "Experience"){
                    $string = "Research Experience";
                    if($uobj[0]['ExperienceId'] == 2){
                        $string = "Professional Experience";
                    }else if($uobj[0]['ExperienceId'] == 3){
                        $string = "Academic Experience";
                    }else if($uobj[0]['ExperienceId'] == 4){
                        $string = "Volunteer Experience";
                    }else if($uobj[0]['ExperienceId'] == 5){
                        $string = "Professional Development";
                    }
                    $obj['Description'] = "$string as ".$uobj[0]['Description'];
                }elseif($CVPostData == "Achievements"){
                    $string = "Presentations";
                    if($uobj[0]['AchievementId'] == 2){
                        $string = "Awards";
                    }else if($uobj[0]['AchievementId'] == 3){
                        $string = "Grants";
                    }else if($uobj[0]['AchievementId'] == 4){
                        $string = "Memberships";
                    }
                    $obj['Description'] = "$string as ".$uobj[0]['Description'];
                }elseif($CVPostData == "Education"){
                    $string = "Graduation";
                    if($uobj[0]['EducationId'] == 1){
                        $string = "Doctorate";
                    }else if($uobj[0]['EducationId'] == 2){
                        $string = "Under Graduation";
                    }else if($uobj[0]['EducationId'] == 3){
                        $string = "Graduation";
                    }else if($uobj[0]['EducationId'] == 4){
                        $string = "Post Graduation";
                    }else if($uobj[0]['EducationId'] == 5){
                        $string = "Other";
                    }
                    $obj['Description'] = "$string as ".$uobj[0]['Specialization']." and Graduation Year is ".$uobj[0]['YearOfPassing'];
                }            
                $obj['UserId']=$userId;           
                $obj['CategoryType'] = $categoryId;
                $obj['PostType'] = $postType;
                $returnValue= UserCVPublicationsCollection::model()->saveUserCVPublicationsCollection($obj);
                if($returnValue!='error')
                {
                     $ret = explode("_",$returnValue);
                     if(trim($ret[1]) == "saved"){
                             ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToPost($postType, $ret[0], $userId, 'Follow', (int) $categoryId);
                          }
                    if (!CommonUtility::prepareStreamObject($userId, 'Post', $ret[0], (int) $categoryId, '', '', $createdDate)) {

                    }
                }
            }
                //return $ret[0];
        
            }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveUserCVPublicationCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
        
        

    }
    
    
       public function updateUserCVStatusBySection($Category,$sectionId,$userId,$orgid) {
        try {
             if(trim($Category)=="Education"){
              UserEducation::model()->updateSectionStatus($orgid,$userId);
            }else if(trim($Category)=="Experience"){
                UserExperience::model()->updateSectionStatus($sectionId,$userId);
            }else if(trim($Category)=="Interests"){
                UserInterests::model()->updateSectionStatus($sectionId,$userId);
            }else if(trim($Category)=="Achievements"){
                UserAchievements::model()->updateSectionStatus($sectionId,$userId);
            }
            else if(trim($Category)=="Publications"){
                UserPublications::model()->updateSectionStatus($sectionId,$userId);
            }
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserCVStatusBySection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->updateUserCVStatusBySection### ".$ex->getMessage());
        }
        return "success";
    }
    
 
     public function updateUserPreferences($preferenceFormObj,$userId) {
        try {
        
            
              if(isset($preferenceFormObj['CountryId']))
         {
                          
               $countryObj= Countries::model()->getCountryById($preferenceFormObj['CountryId']);
                  
               if(isset($countryObj) && isset($countryObj->NetworkId))
               {
                $return= User::model()->updateCountryandNetworkByUserId($userId, $preferenceFormObj['CountryId'], $countryObj->NetworkId,$countryObj->Language,$countryObj->SegmentId);
                      return $return;
               }
          //$NetworkId= Network::model()->getByNetWorkCountryId($preferenceFormObj['CountryId']);
          
          
      
//           (isset($NetworkId) && $NetworkId!='error')?'':$NetworkId=1;               
//           $userProfileform['network']=$NetworkId;
         }
      
            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserPreferences::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->updateUserPreferences### ".$ex->getMessage());
        }
        return "success";
    }
    public function getAllSegmentsByNetwork($networkId){
        $returnValue = array();
        try {
            $returnValue=Segment::model()->getAllSegmentsByNetwork($networkId);
        } catch (Exception $ex) {
          Yii::log("SkiptaUserService:getAllSegmentsByNetwork::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    public function updateSegmentByUserId($userId, $segmentId){
        $returnValue = "failure";
        try {
            $returnValue=  UserCollection::model()->updateSegmentByUserId($userId, $segmentId);
        } catch (Exception $ex) {
          Yii::log("SkiptaUserService:updateSegmentByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    public function getAllLanguages(){
        $returnValue = array();
        try {
            $returnValue=Language::model()->getAllLanguages();
        } catch (Exception $ex) {
          Yii::log("SkiptaUserService:getAllLanguages::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    public function loadLanguagesNames(){
       $returnValue='failure';
       try {
           $languageArray=array();         
           $languages=Language::model()->getAllLanguages();         
         
           if(is_object($languages) || is_array($languages)){
               foreach($languages as $language){   
                   $key=(String)$language->Language;
                   $languageArray[$key]=$language->Name;                
               }
             $returnValue=$languageArray;  
           }
       
           return $returnValue;
       } catch (Exception $ex) {
           Yii::log("SkiptaUserService:loadLanguagesNames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
       }
      }
    public function updateLanguageByUserId($userId, $language){
        $returnValue = "failure";
        try {
            $returnValue=  UserCollection::model()->updateLanguageByUserId($userId, $language);
        } catch (Exception $ex) {
          Yii::log("SkiptaUserService:updateLanguageByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    public function getLanguageByAttributes($attributeArray){
        $returnValue = "failure";
        try {
            $returnValue=  Language::model()->getLanguageByAttributes($attributeArray);
        } catch (Exception $ex) {
          Yii::log("SkiptaUserService:getLanguageByAttributes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
     public function getSegmentByAttributes($attributeArray){
        $returnValue = "failure";
        try {
            $returnValue=  Segment::model()->getSegmentByAttributes($attributeArray);
        } catch (Exception $ex) {
          Yii::log("SkiptaUserService:getSegmentByAttributes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
     public function requestForChangeCountry($preferenceFormObj,$userId,$state,$city,$zip) {
        try {
            if(isset($preferenceFormObj['CountryId']))
            {
               $countryObj= Countries::model()->getCountryById($preferenceFormObj['CountryId']);
               if(isset($countryObj) && isset($countryObj->NetworkId))
               {
                    $return= User::model()->requestForChangeCountry($userId, $preferenceFormObj['CountryId'],$state,$city,$zip);
                    return $return;
               }
            }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:requestForChangeCountry::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->requestForChangeCountry### ".$ex->getMessage());
        }
        return "success";
    }
    public function rejectChangeCountry($userId) {
        try {
            $return= User::model()->rejectChangeCountry($userId);
            return $return;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:rejectChangeCountry::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->rejectChangeCountry### ".$ex->getMessage());
        }
        return "success";
    }


  public function updatePushNotification($userId){
        try{
       return PushNotificationCollection::model()->updatePushNotificationAsRead($userId);

      } catch (Exception $ex) {
     Yii::log("SkiptaUserService:updatePushNotification::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
      
  }
  
    public function getUserAttendingEventsForRightWidget($userId,$CurrentLoginDate, $segmentId=0,$groupfollowing=array()) {
         try {
            $returnValue = 'failure';       
            $userEventAttendingActivities=  UserStreamCollection::model()->getUserAttendingEventsActivity($userId,$CurrentLoginDate, $segmentId,$groupfollowing);
                if(count($userEventAttendingActivities)>0){
                  $returnValue = $userEventAttendingActivities;   
                }
            return $returnValue; 
            
        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserAttendingEventsForRightWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    

    public function getActionUsers($categoryId,$flag,$id,$actionType,$userId,$pageSize,$pageLength){
          try{
              $actionUsers = array();
              
              if($categoryId == 1){
                // $actionUsers = PostCollection::model()->getActionUsers($id,$actionType);
                  $postObj = PostCollection::model()->getPostById($id);
              }
              else if($categoryId == 2){
                  $postObj = CurbsidePostCollection::model()->getPostById($id);  
              }
              else if($categoryId == 3 || $categoryId == 7){
                  $postObj = GroupPostCollection::model()->getGroupPostById($id);  
              }
              else if($categoryId == 6){
                    $postObj = CurbSideCategoryCollection::model()->getPostById($id);
              }
              else if($categoryId == 8){
                    $postObj = CuratedNewsCollection::model()->getNewsObjectById($id);
              }
              else if($categoryId == 9){
                  $postObj = GameCollection::model()->getGameDetailsObject('Id', $id);  
              }
              else if($categoryId == 10){
                   $postObj=UserBadgeCollection::model()->getUserBadgeCollectionById($id); 
              }
              else if($categoryId == 11){
                 $postObj=UserNetworkInviteCollection::model()->getUserNetworkInviteCollectionById($id);
              }
              else if($categoryId == 12){
                  $postObj=UserCVPublicationsCollection::model()->getUserCVPCollectionByCriteria($userId);
              }
              else if($categoryId == 13){
                  $postObj=AdvertisementCollection::model()->getAdvertisementDetailsById($id);  
              }
              
          if($actionType == "Followers"){
                  $actionUsers = $postObj->Followers; 
             }else if($actionType == "Love"){
                  $actionUsers = $postObj->Love;
             }else if($actionType == "EventAttend") {
                $actionUsers = $postObj->EventAttendes; 
            }else{
                 $actionUsers = $postObj->SurveyTaken; 
                   $surveyUsersArray = array();
                foreach ($actionUsers as $obj) {
                     array_push($surveyUsersArray,$obj["UserId"]);
                }
                $actionUsers = $surveyUsersArray;
        }
             if($categoryId == 5){
                    $postObj = HashTagCollection::model()->getHashTagFollowers($id);
                    $actionUsers = $postObj->HashTagFollowers; 
              }
        $actionUsers = array_unique($actionUsers);

         $key = array_search($userId, $actionUsers);
                if($key != FALSE){
                unset($actionUsers[$key]);
                array_unshift($actionUsers, $userId);  
         }


       $actionUsers_chunck = array_slice($actionUsers,$pageSize,$pageLength);
               
        
        
        $loggedUserFollowingUsers = UserProfileCollection::model()->getUserFollowingById($userId);
        $finalArray = array();
       if (count($actionUsers_chunck)>0) {
        foreach ($actionUsers_chunck as $user) {
         if($user!=0){
           $bean = new UserProfileBean;
           $userObject = UserCollection::model()->getTinyUserCollection($user);
           $bean->DisplayName = $userObject->DisplayName;
           $bean->UserId = $userObject->UserId;
           $bean->ProfilePicture = $userObject->profile70x70;
            $bean->uniqueHandle = $userObject->uniqueHandle;
           $bean->IsFollowed = in_array($userObject->UserId, $loggedUserFollowingUsers)? 1:0;
           array_push($finalArray, $bean);
    }
   }
         }
        return $finalArray;
         } catch (Exception $ex) {
     Yii::log("SkiptaUserService:getActionUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    
  }
  
       public function checkNetworkLogin($authToken,$userId) {
         try {
             $query = "SELECT * FROM oauth2_tokens where oauth_token='".$authToken."' and user_id=".$userId;
             $result = Yii::app()->db->createCommand($query)->queryRow();
             if (sizeof($result) > 0) {
               return TRUE;
            }else{
                return FALSE;
   }

         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:checkNetworkLogin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }

    }
    
     /**
     * @author Haribabu
     * This method is used to update the UserType
     * @param type $userId
     * @param type $actionIds
     * @return string
     */
     public function updateUserIdentityType($userId,$IdentityStatus) {
        $returnValue = 'failure';
        try {
            $returnValue=UserCollection::model()->updateUserIdentityStatus($userId, $IdentityStatus);
            if($returnValue=='success'){
                $Uresult = User::model()->updateUserIdentityType($userId,$IdentityStatus);
                if($Uresult=='success'){
                    $returnValue=$Uresult;
                }
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserIdentityType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    public function getBadgeTranslation($id, $language)
    {
         try {
            $badges=BadgeTranslations::model()->getBadgeTranslation($id, $language);
            return $badges;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getBadgeTranslation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            echo $ex->getTraceAsString();
        }
        
    }
    public function saveBadgeTranslation($id, $language, $description)
    {
         try {
            $badges=BadgeTranslations::model()->saveBadgeTranslation($id, $language, $description);
            return $badges;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveBadgeTranslation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            echo $ex->getTraceAsString();
        }
        
    }

   public function getCustomFieldsByUserId($UserId) {
         try {
            $returnValue = 'failure';       
            $returnValue=  CustomField::model()->getCustomFieldsByUserId($UserId);

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getCustomFieldsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue; 
    }
    
     public function getCustomFormByUserId($UserId) {
         try {
            $returnValue = 'failure';       
            $returnValue=  CustomField::model()->getCustomFormByUserId($UserId);

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getCustomFormByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue; 
    }
     public function updateCustomSettings($userId,$CustomForm) {
        $returnValue = 'failure';
        try {
            
            $subSpecialityId=CustomField::model()->isSubspecialityChanged($userId,$CustomForm);
            $returnValue=CustomField::model()->updateCustomFields($userId,$CustomForm);
            
            if ($subSpecialityId!=false) {
            $groupIds = GroupCollection::model()->getGroupIdsBasedOnSpeciality($subSpecialityId);
            if (count($groupIds) > 0) {
                foreach ($groupIds as $group) {
                    $groupId = $group->_id;
                    GroupCollection::model()->followOrUnfollowGroup($groupId, $userId, "Follow");
                    UserProfileCollection::model()->followOrUnfollowGroup($groupId, $userId, "Follow");
                }
            }
            }
            /**********saving the availability in userAchievementsCollection************/
            $userDetails=UserCollection::model()->getTinyUserCollection($userId); 
            $userAchievementsInputBean = new UserAchievementsInputBean();
            $userAchievementsInputBean->UserId = $userId;
            $userAchievementsInputBean->UserClassification = $userDetails->UserClassification;
            $userAchievementsInputBean->OpportunityType = "";
            $userAchievementsInputBean->SegmentId = $userDetails->SegmentId;
            $userAchievementsInputBean->NetworkId = $userDetails->NetworkId;

            Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));

            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateCustomSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
public function getCustomSubSpeciality() {
        try {
            $subSpe=SubSpecialty::model()->getSubSpecialityDetails();
            $specialityArray=array();
            if(is_array($subSpe) || is_object($subSpe)){
               if((isset(Yii::app()->params['GroupMappingField '])) && (trim(Yii::app()->params['GroupMappingField '])!="")){
                $specialityArray['']="Choose One";           
              }
                
                foreach($subSpe as $spe){
                    $id=(int)$spe['id'];
                 $specialityArray[$id]=Yii::t('subspecialty', $spe['Key']);   
                }
                if(Yii::app()->params['NetworkName']!="Neurologist Connect" && (isset(Yii::app()->params['GroupMappingField '])) && (trim(Yii::app()->params['GroupMappingField '])!="")){
                $specialityArray['Other']="Other";                 
                }
            }
            return $specialityArray;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getCustomSubSpeciality::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->getCustomSubSpeciality### ".$ex->getMessage());
        }
    }
    
    public function getCustomFieldsByUserIdforSurveyReports($userId){
        try{
            $returnValue = "failure";
            $returnValue = User::model()->getCustomFieldsByUserId($userId);
            return $returnValue;            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getCustomFieldsByUserIdforSurveyReports::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    public function getAllNotLoggedInUsersFromPastFourdays() {
         try {
            $returnValue = 'failure';       
            $returnValue=  User::model()->getAllNotLoggedInUsersFromPastFourdays();

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllNotLoggedInUsersFromPastFourdays::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }
     public function getUserAwayDigest($userId) {
         try {
            $returnValue = 'failure';       
            $returnValue=  UserAwayDigest::model()->getUserAwayDigest($userId);

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserAwayDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }
     public function updateUserAwayDigest($userAwayDigestId) {
         try {
            $returnValue = 'failure';       
            $returnValue=  UserAwayDigest::model()->updateUserAwayDigest($userAwayDigestId);

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserAwayDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }
     public function getAwayDigestSentUserListFromPastFourDays() {
         try {
            $returnValue = 'failure';       
            $returnValue=  UserAwayDigest::model()->getAwayDigestSentUserListFromPastFourDays();

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAwayDigestSentUserListFromPastFourDays::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }
     public function saveOrUpdateAwayDigest($postId,$postType,$categroyType,$isUseforDigest) {
         try {
            $returnValue = 'failure';       
            $returnValue=  AwayDigest::model()->saveOrUpdateAwayDigest($postId,$postType,$categroyType,$isUseforDigest);

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveOrUpdateAwayDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }
     public function getAwayDigestListFromLstSevenDays($isMarkedByAdmin){
         try {
            $returnValue = 'failure';       
            $returnValue=  AwayDigest::model()->getAwayDigestListFromLstSevenDays($isMarkedByAdmin);

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAwayDigestListFromLstSevenDays::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }
    public function saveSentAwayDigest($awayDigestId,$userAwayDigestId) {
         try {
            $returnValue = 'failure';       
            $returnValue=  AwayDigestSentList::model()->saveSentAwayDigest($awayDigestId,$userAwayDigestId);

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveSentAwayDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }

      /**
     * @author Haribabu
     * @Description This method is used to update the profile 
     * @param type userId      
     * @return  success =>Array failure =>string 
     */   

    public function updateUserProfileDetailsByUsingUserId($UserProfileModel) {
        try {

            $returnValue='failure';
             $usercollectionDetails=UserCollection::model()->updateProfileDetails($UserProfileModel);  
            // update fields in User table
             $userdetails=User::model()->updateUserDetails($UserProfileModel);
            // update fields in Customfields
             $UserCustomFields=CustomField::model()->updateUserCustomFields($UserProfileModel); 
            // update fields in Professional information
             $UserProfessionalInformation=ProfessionalInformation::model()->UpdateUserProfessionalInformation($UserProfileModel); 
           //  if($UserProfileModel['UserInterests']!=""){
             $userInterests= UserInterests::model()->updateUserInterests($UserProfileModel);
            // }
             if($usercollectionDetails!='failure' && $userdetails!='failure' && $UserCustomFields!='failure' && $UserProfessionalInformation!='failure' && $userInterests!='failure'){
                 $returnValue='success';
                 
             }
             
            $locationObj = new UserLocationZionBean();
            $locationObj->AccessKey = Yii::app()->params['AccessKey'];
            $locationObj->CommunityId = Yii::app()->params['NetWorkId'];
            $locationObj->UserId = $UserProfileModel['UserId'];
            $locationObj->City = $UserProfileModel['City'];
            $locationObj->State = $UserProfileModel['State'];
            $locationAPI = Yii::app()->params['LocationAPI'];
            CommonUtility::sendDataToZionRestCall($locationAPI,$locationObj);

            $professionObj = new UserProfessionZionBean();
            $professionObj->AccessKey = Yii::app()->params['AccessKey'];
            $professionObj->CommunityId = Yii::app()->params['NetWorkId'];
            $professionObj->UserId = $UserProfileModel['UserId'];
            $professionObj->Credentials = $UserProfileModel['Credentials'];
            if($UserProfileModel['HavingNPINumber'] == 1){
                 $professionObj->NPINumber = $UserProfileModel['NPINumber'];
            }
            $professionObj->Specialty = $UserProfileModel['Specialty'];
            $professionObj->Title = $UserProfileModel['Title'];
            $professionObj->PracticeName = $UserProfileModel['PracticeName'];
            $ProfessionAPI = Yii::app()->params['ProfessionAPI'];
            CommonUtility::sendDataToZionRestCall($ProfessionAPI,$professionObj);
             
             $this->saveUserAchievements($UserProfileModel);
             return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserProfileDetailsByUsingUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            
        }
    }
/**
* @author Haribabu
* @Description This method is used to get the user acadameci interests details 
* @param type userId      
* @return  success =>Array failure =>string 
*/ 
     public function getUserInterestsDetails($UserId) {
        try {
            $returnvalue = 'failure';

            $InterestsDetails = UserInterests::model()->getUserCVInterestsDetailsForProfile($UserId);
            if (is_array($InterestsDetails)) {
                $returnvalue = $InterestsDetails;
            }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserInterestsDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnvalue;
    }

    public function saveUserAchievements($UserProfileModel) {
        try{
            $userId = (int)$UserProfileModel['UserId'];
            $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
            $userClassification = $tinyUserCollectionObj->UserClassification;
            $userAchievementsInputBean = new UserAchievementsInputBean();
            $userAchievementsInputBean->UserId = (int)$userId;
            $userAchievementsInputBean->UserClassification = $userClassification;
            $userAchievementsInputBean->OpportunityType = "Profile";
            $userAchievementsInputBean->SegmentId = $tinyUserCollectionObj->SegmentId;
            $userAchievementsInputBean->NetworkId = $tinyUserCollectionObj->NetworkId;
            $userAchievementsInputBean->IsUpdate = 1;
            $userAchievementsInputBean->Value = 0;
            
            //Profile_Professional_Information
            $value = 0;
            $userAchievementsInputBean->EngagementDriverType = "Profile_Professional_Information";
            if ($UserProfileModel['StateLicenceNumber'] != "") {
                $value=$value+0.5;
            }
            if ($UserProfileModel['Credentials'] != "") {
                $value=$value+0.5;
            }
            $userAchievementsInputBean->Value = $value;
            Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));

            //Profile_Practice_Information
            $value = 0;
            $userAchievementsInputBean->EngagementDriverType = "Profile_Practice_Information";
            if ($UserProfileModel['Speciality'] != "") {
                $value=$value+0.33;
            }
            if ($UserProfileModel['Title'] != "") {
                $value=$value+0.33;
            }
            if ($UserProfileModel['PracticeName'] != "") {
                $value=$value+0.34;
            }
           
            $userAchievementsInputBean->Value = $value;
            Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));

            //User_Location
            $value = 0;
            $userAchievementsInputBean->EngagementDriverType = "User_Location";
            if ($UserProfileModel['City'] != "") {
                $value=$value+0.5;
            }
            if ($UserProfileModel['State'] != "") {
                $value=$value+0.5;
            }
            $userAchievementsInputBean->Value = $value;
            Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));

            //User_Bio
            $value = 0;
            $userAchievementsInputBean->EngagementDriverType = "User_Bio";
            if ($UserProfileModel['AboutMe'] != "") {
                $value++;
            }
            $userAchievementsInputBean->Value = $value;
            Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));


            //User_Interest
            $value = 0;
            $userAchievementsInputBean->EngagementDriverType = "User_Interest";
            if ($UserProfileModel['UserInterests'] != "") {
                $value++;
            }
            $userAchievementsInputBean->Value = $value;
            Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));
            
            $userAchievementsInputBean->OpportunityType = "";//this is for saving the availability
            Yii::app()->amqp->achievements(json_encode($userAchievementsInputBean));
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:saveUserAchievements::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaUserService->saveUserAchievements### ".$ex->getMessage());
        }
            
    }
    public function getUserSubspecialityByCustomField($customFieldId,$customMappingField){
     try {
         $subSpeciality=CustomField::model()->getSubSpecialityFromCustomField($customFieldId,$customMappingField);
         return $subSpeciality;
     } catch (Exception $ex) {
         Yii::log("SkiptaUserService:getUserSubspecialityByCustomField::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }



    
    public function isAwayDigestSent($awayDigestId,$userAwayDigestId) {
         try {
            $returnValue = 'failure';       
            $returnValue=  AwayDigestSentList::model()->isAwayDigestSent($awayDigestId,$userAwayDigestId);

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:isAwayDigestSent::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }
    
   public function getAwayDigestId($postId,$categroyType,$postType){
         try {
            $returnValue = 'failure';       
            $returnValue=  AwayDigest::model()->getAwayDigestId($postId,$categroyType,$postType);

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAwayDigestId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }

    public function updateUserGeoCoordinates($latitude,$longitude,$userId){
        try{
        User::model()->updateUserGeoCoordinates($latitude,$longitude,$userId);
        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateUserGeoCoordinates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


/*@Author Haribabu
 * GetHDSUserBy AccessId: which takes 1 argument i.e userid
 * and returns an User Object.
 */
public function geHDSUserDetailsByUserId($AccessId) {
    try {
        $userProfileObject = PreRegistration::model()->getHdsuserDetails($AccessId);
    } catch (Exception $ex) {
        Yii::log("SkiptaUserService:geHDSUserDetailsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    return $userProfileObject;
}
/*@Author Haribabu
 * UpdateHDSUserByUserId: which takes 1 argument i.e Accessid
 * and returns an User Object.
 */
public function updateHDStUserDetailsByAccessId($AccessId,$field,$value) {
    try {
        $userProfileObject = PreRegistration::model()->updateUserStatus($AccessId,$field,$value);
    } catch (Exception $ex) {
        Yii::log("SkiptaUserService:updateHDStUserDetailsByAccessId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    return $userProfileObject;
}

   
 /* @Author Haribabu
  * This Method is used for Save the user profile in both mysql and mongo 
      it accepts Hds userprofile and customForm userdetails obj
  *   */     
    public function SaveHdsUserCollection($HdsUserprofileDetails,$UserDetails){
     try {
         $userCollectionModel=new UserCollection();
         $UserprofileDetails=array();
         $CountryId="";
        $UserprofileDetails['firstName'] = $UserDetails->First_Name;
        $UserprofileDetails['lastName'] = $UserDetails->Last_Name;
        $UserprofileDetails['DisplayName'] = $UserDetails->First_Name . $UserDetails->Last_Name;
        $UserprofileDetails['email'] = $UserDetails->Email;
        $countryObj= Countries::model()->getCountryByName($UserDetails->Country);
        if(isset($countryObj) &&  $countryObj!='failure' && isset($countryObj->Id))
        {
            $CountryId=(int)$countryObj->Id;
        }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
        $UserprofileDetails['country'] = $CountryId;
        $UserprofileDetails['state'] = $UserDetails->State;
        $UserprofileDetails['city'] = $UserDetails->City;
        $UserprofileDetails['zip'] = $UserDetails->Zip;
        $UserprofileDetails['status'] = 1;
        $UserprofileDetails['companyName'] = "";
        $UserprofileDetails['NetworkId'] = 1;
        $UserprofileDetails['UserIdentityType'] = 0;
        $UserprofileDetails['referenceUserId'] = "";
        $UserprofileDetails['referralLinkId'] = "";
        $UserprofileDetails['referralUserEmail'] = "";
        $UserprofileDetails['registredDate'] = "";
        $UserprofileDetails['lastLoginDate'] = "";
        $UserprofileDetails['pass']=$HdsUserprofileDetails['password'];
        $UserprofileDetails['Speciality']=$UserDetails->Speciality;
        $UserprofileDetails['IsSpecialist'] = 1;
        $UserprofileDetails['HavingNPINumber'] = 1;
        $UserprofileDetails['NPINumber']=$UserDetails->NPINumber;
        $UserprofileDetails['PracticeName']=$UserDetails->Practice_Name;
        $UserprofileDetails['Title']=$UserDetails->Title_Code;
         if(isset($UserprofileDetails['country']))
         {
          $NetworkId= Network::model()->getNeworkId($UserprofileDetails['country']);
           (isset($NetworkId) && $NetworkId!='error')?'':$NetworkId=1;               
           $UserprofileDetails['network']=1;
         }
        $userId=User::model()->saveUser($UserprofileDetails); 
        if(isset($userId) && $userId!='error'){ 
         $userCollectionModel->UserId=$userId;
          $userCollectionModel->Status=1;
         $userCollectionModel->DisplayName=$UserprofileDetails['firstName']." ".$UserprofileDetails['lastName'];
         $userCollectionModel->NetworkId=(int)$NetworkId;
         $userCollectionModel->State= $UserDetails->State;
         $userCollectionModel->CountryId=$CountryId;
         if (CommonUtility::isValidMd5($UserprofileDetails['pass'])) {
            $userCollectionModel->ProfilePicture=$UserprofileDetails['profilePicture'];
         }else{
             $userCollectionModel->ProfilePicture='user_noimage.png';
         }
         $displayName = trim($userCollectionModel->DisplayName);
         $uniqueHandle="";
         if(strlen($displayName)>0){
            $uniqueHandle = $this->generateUniqueHandleForUser($UserprofileDetails['firstName'],$UserprofileDetails['lastName']);
         }else{
             $emailPref = explode("@", $UserprofileDetails['email']);
             $displayName = $emailPref[0];
             $uniqueHandle = $this->generateUniqueHandleForUser($displayName,"");
         }
         $userCollectionModel->uniqueHandle=$uniqueHandle;
         if(isset($UserprofileDetails['aboutMe'])){
             $userCollectionModel->AboutMe=$UserprofileDetails['aboutMe'];
         }
           UserHierarchy::model()->SaveUserHierarchy($userId);
           UserCollection::model()->saveUserCollection($userCollectionModel);
            ProfessionalInformation::model()->saveHdsUserProfessionalInformation($UserprofileDetails,$userId);
           $customfieldId=CustomField::model()->saveHdsUserCustomField($UserprofileDetails,$userId);
           $userprofileid=UserProfileCollection::model()->saveUserProfileCollection($UserprofileDetails,$userId);
           UserNotificationSettingsCollection::model()->saveUserSettings($userId,(int)$NetworkId);
         }
         
         if(isset($userprofileid) && $userprofileid!='error'){
            if (!CommonUtility::isValidMd5($UserprofileDetails['pass'])) {
                $to = $UserprofileDetails['email'];
                $subject = "Your ".Yii::app()->params['NetworkName']." Registration";
                $employerName = "Skipta Admin";
                //$employerEmail = "info@skipta.com"; 
                $messageview="HdsUserRegistrationMail";
                $params = array('FirstName' => $UserprofileDetails['firstName'],'LastName'=>$UserprofileDetails['lastName']);
                $sendMailToUser=new CommonUtility;
                $mailSentStatus=$sendMailToUser->actionSendmail($messageview,$params, $subject, $to);
            }
            return $userId;
         }else{
             
             return 'error';
         }
         
     } catch (Exception $ex) {
         Yii::log("SkiptaUserService:SaveHdsUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in SkiptaUserService->SaveHdsUserCollection### ".$ex->getMessage());
     }
  }
/*@Author Haribabu
 * This method is used to get the UsersData based on Status for analytics
 *  returns an User Object.
 */
public function getHdsUsersDataByUsingStatus($Status) {
    try {
        $returnvalue="failure";
        $userProfileObject = PreRegistration::model()->getHdsUsersByUsingStatus($Status);
        if(count($userProfileObject)>0){
            $returnvalue=$userProfileObject;
        }
        return $returnvalue;
    } catch (Exception $ex) {
        Yii::log("SkiptaUserService:getHdsUsersDataByUsingStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    return $userProfileObject;
}

public function getAllNewUsersEligableForNewUserSurvey($noOfDays){
        try{
            $returnValue = array();
            $returnValue = User::model()->getAllNewUsersEligableForNewUserSurvey($noOfDays);
            return $returnValue;            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllNewUsersEligableForNewUserSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
    public function getAllActiveUsers(){
        try{
            $returnValue = array();
            $returnValue = User::model()->getAllActiveUsers();
            return $returnValue;            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllActiveUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }


    
     public function getAllUsersLat() {
         try {
            $returnValue = 'failure';       
            $returnValue=  User::model()->getAllUsers();

        }catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllUsersLat::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue; 
    }
    
    /**
     * @developer: Reddy
     * @usage update classfication based on classfication Id
     * @return boolean (success or failure)
     */
    public function updateClassfication($UserId, $classficationId) {
        try {
            $returnValue = false;
            $returnValue = User::model()->updateUserClassfication($UserId, $classficationId);
            if ($returnValue == true) {
                $returnValue = UserCollection::model()->updateUserClassfication($UserId, $classficationId);
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateClassfication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue;
    }
    public function getAllSurveyEligableActiveUsers($surveydays){
        try{
            $returnValue = array();
            $returnValue = User::model()->getAllSurveyEligableActiveUsers($surveydays);
            return $returnValue;            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getAllSurveyEligableActiveUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
/*@Author Haribabu
 * This method is used to get the UsersData based on Status for analytics
 *  returns an User Object.
 */
public function getAllHdsUsers() {
    try {
        $returnvalue="failure";
        $users = PreRegistration::model()->getAllHdsUsersWithStatus();
        if(count($users)>0){
            $returnvalue=$users;
        }
        return $returnvalue;
    } catch (Exception $ex) {
        Yii::log("SkiptaUserService:getHdsUsersDataByUsingStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    return $userProfileObject;
}
/**
 * @author Sagar
 * @usage used to disable daily digest and away digest (Consuming method for zion)
 *        unsubscribed do not get the daily digest and away digest.
 * @param type $userId
 * @return type
 */
    public function disableDigest($userId){
        try{
            $returnValue = "failure";
            $returnValue = UserNotificationSettingsCollection::model()->disableDigest($userId);
            return $returnValue;            
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:disableDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    
    public function sendUserDataToZion($userId){
        try{
            $userObj = User::model()->getUserObjectForZion($userId);
            if($userObj!="NoUser"){
                $userBean = new UserProfileZionBean();
                $userBean->AccessKey = Yii::app()->params['AccessKey'];
                $userBean->CommunityId = Yii::app()->params['NetWorkId'];
                $userBean->UserId = $userId;
                $userBean->FirstName = $userObj["FirstName"];
                $userBean->LastName = $userObj["LastName"];
                $userBean->Company = $userObj["Company"];
                $userBean->City = $userObj["City"];
                $userBean->State = $userObj["State"];
                
                $countryObj= Countries::model()->getCountryById((int)$userObj["Country"]);
                if(isset($countryObj) && isset($countryObj->Code))
                {
                 $userBean->Country = $countryObj->Code;
                }
                $userBean->Zip = $userObj["Zip"];
                $userBean->Email = $userObj["Email"];
                $userBean->Latitude = $userObj["Latitude"];
                $userBean->Longitude = $userObj["Longitude"];
                
                $userBean->NPINumber = $userObj["NPINumber"];
                
                $userBean->CustomFields = array();
                $customFields = CustomField::model()->getAllCustomFieldsByUserId($userId);
                if($customFields!='NoUser'){
                    unset($customFields['Id']);
                    unset($customFields['UserId']);
                    $licenseArray = LicensedStatesAndNumbers::model()->getAllStateLicenseNumbersByUserId($userId);
                    if(count($licenseArray)>0){
                        $licensedArray = array();
                        foreach ($licenseArray as $license) {
                            $licensedArray[$license["LicensedNumber"]] = $license["LicensedState"];
                        }
                        $userBean->License = $licensedArray;
                    }
                    
                    if(isset($customFields['PrimaryAffiliation']) && $customFields['PrimaryAffiliation']!=""){  
                        $subspeciality=SubSpecialty::model()->getSubSpecialityByType('id',$customFields['PrimaryAffiliation']);
                        if(is_object($subspeciality)){
                            $customFields['PrimaryAffiliation']=$subspeciality->Value;
                        }
                    }
                    if(isset($customFields['Subspeciality']) && $customFields['Subspeciality']!=""){  
                        $subspeciality=SubSpecialty::model()->getSubSpecialityByType('id',$customFields['PrimaryAffiliation']);
                        if(is_object($subspeciality)){
                            $customFields['Subspeciality']=$subspeciality->Value;
                        }
                    }
                    
                    
                    
                    $userBean->CustomFields = $customFields;
                }
                $url = Yii::app()->params['RegisterAPI'];
                
                //CommonUtility::sendDataToZionRestCall($url,$userBean);
            }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:sendUserDataToZion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    
    public function updateStudentCodeAndSendMailTo($userid,$value){
        try{
            $userString = $userid;
            $encodeCurrentDate = base64_encode(date('Y-m-d h:i:s'));
            $studentAccessToken=md5($userString).'_'.$encodeCurrentDate;    
            User::model()->updateUserByFieldByUserId($userid,$studentAccessToken,'StudentAccessToken');
            $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userid);
            if(isset($userObj) && sizeof($userObj)>0 && $userObj['IsStudentOrResident'] == 1){                
                $to = $userObj['StudentOrResidentEmail'];
                $name = $userObj['FirstName'] . ' ' . $userObj['LastName'];
                $userId = $userObj['UserId'];
                $studentEmail = $userObj['StudentOrResidentEmail'];
                $subject = "Verifiy Your ".Yii::app()->params['NetworkName']." Account ";
                $templateType = "forgotmail";
                $companyLogo = "";
                $employerName = "Skipta Admin";
                //$employerEmail = "info@skipta.com"; 
                $messageview="StudentApprovalTemplate";
                $params = array('myMail' => $name, 'userId' => $userId, 'code' => $studentAccessToken,'email'=>$studentEmail);
                $sendMailToUser=new CommonUtility;
                $mailSentStatus=$sendMailToUser->actionSendmail($messageview,$params, $subject, $to);  
                if($mailSentStatus == false)
                {
                  $userObj == 'mailsentfailure'; 
                }else{
                    error_log("######### Student Verification link sent successfully ###########");
                }
            }
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:updateStudentStatusAndSendMailTo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    
     public function checkStudentExist($email,$linkcode ) {
         try {
              $result = User::model()->checkStudentExist($email,$linkcode);
        return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
    
    public function updateStudentStatus($userid){
        try{            
            $result = User::model()->updateStudentStatus($userid);
        return $result;
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function saveUser($employeeForm) {
         try {
              $result = User::model()->saveUser($employeeForm);
        return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
    
    public function updateTestTakerImagePath($testTakerForm,$userId) {
         try {
              $result = User::model()->updateTestTakerImagePath($testTakerForm,$userId);
               $result = UserCollection::model()->updateTestTakerImagePath($testTakerForm,$userId);
        return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
        public function updateTestTakerDetails($testTakerForm) {
         try {
              $result = User::model()->updateTestTakerDetails($testTakerForm);
        return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
    /*
     * Invite Users Functionality start
     */
    public function getInviteUserProfile($TestId,$startDate,$endDate, $searchText, $startLimit, $pageLength) {
        try {// method calling...                 
            $userProfileCollectionJSONObject = TestRegister::model()->getInviteUserProfile($TestId,$startDate,$endDate, $searchText, $startLimit, $pageLength);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $userProfileCollectionJSONObject;
    }

    
    public function getInviteUserProfileCount($TestId,$startDate,$endDate, $searchText) {
        try {// method calling...            
            $userProfileCount = TestRegister::model()->getInviteUserProfileCount($TestId,$startDate,$endDate, $searchText);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserProfileCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $userProfileCount;
    }
    
    public function saveInviteUserForTest($TestId,$UserIds) {
        try {// method calling...            
            $inviteTest = TestRegister::model()->saveInviteUserForTest($TestId,$UserIds);
        } catch (Exception $ex) {
            Yii::log("SkiptaUserService:getUserProfileCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $inviteTest;
    }
    
    
    
    public function SaveInviteUserDetails($TestId,$af){
     try {
         $returnValue = TestPreparationCollection::model()->SaveInviteUserDetails($TestId,$af);
         return $returnValue;
         
     } catch (Exception $ex) {
         error_log("SkiptaUserService:SaveUserCollection::".$ex->getMessage());
         Yii::log("SkiptaUserService:SaveUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
    /*
     * Invite Users Functionality end
     */
  
  public function editUserDetailsForUserMgmnt($userId,$testTakerForm) {
         try {
              $result = User::model()->editUserDetailsForUserMgmnt($userId,$testTakerForm);
        return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaUserService:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
        
    }
}



