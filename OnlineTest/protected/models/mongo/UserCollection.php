<?php

/** This is the collection for tiny user where we get the user data to use user data 

 */

class UserCollection extends EMongoDocument {

    public $UserId;
    public $DisplayName;
    public $uniqueHandle;
    public $ProfilePicture;
    public $AboutMe="";
   
    public $Status=0;
    public $UserIdentityType=0;
 
  

  
   

    public function getCollectionName() {
        try{
        return 'TinyUserCollection';
        } catch (Exception $ex) {
            Yii::log("Exception Occurred in Mongo UserCollection->getCollectionName==".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function indexes() {
        try{
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_DisplayName' => array(
                'key' => array(
                    'DisplayName' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_uniqueHandle' => array(
                'key' => array(
                    'uniqueHandle' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_NetworkId' => array(
                'key' => array(
                    'NetworkId' => EMongoCriteria::SORT_ASC,
                ),
            ),
        );
        } catch (Exception $ex) {
            Yii::log("UserCollection:indexes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function attributeNames() {
        try{
        return array(
            'UserId' => 'UserId',
            'DisplayName' => 'DisplayName',
            'uniqueHandle' => 'uniqueHandle',
            'ProfilePicture' => 'ProfilePicture',
           
            'AboutMe' => 'AboutMe',
      
          
            'Status'=>'Status',
            'UserIdentityType'=>'UserIdentityType',
        
           

            
        );
        } catch (Exception $ex) {
            Yii::log("UserCollection:attributeNames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function model($className = __CLASS__) {
        try{
        return parent::model($className);
        } catch (Exception $ex) {
            Yii::log("UserCollection:model::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   
    /** 
     
     * this method is used to save the user colletion (tiny user) it accepts the user collection object 
      * if saves to the userCollection it returns the userID 
          */
    public function saveUserCollection($userModel) {error_log("----mongouser------1----");
        try {
            $returnValue = 'false';
            $userCollection = new UserCollection();
            $userCollection->UserId=(int)$userModel->UserId;
          
            $userCollection->ProfilePicture = Yii::app()->params['ServerURL'] . "/upload/profile/".$userModel->ProfilePicture;
         
       
            $userCollection->Status =0;
       
            $userCollection->insert();
            if (isset($userCollection->_id)) {
                $returnValue = 'true';
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCollection:saveUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserCollection->saveUserCollection==".$ex->getMessage());
        }
    }
   /** This method gets tinyUser collection object from mongo 
    It accepts userId as a paramter and returns faliure string if it didnot find the record and returns 
    * tiny user obj if it finds    */
   public function getTinyUserCollection($userId){
       try {
          $returnValue='failure';
          
            $mongoCriteria = new EMongoCriteria;            
            $mongoCriteria->addCond('UserId', '==', (int)$userId);
            $tinyUserObj = UserCollection::model()->find($mongoCriteria);
            return  $tinyUserObj;
                
       } catch (Exception $ex) {
           Yii::log("UserCollection:getTinyUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }

    /**
    * @Author Sagar Pathapelli
    * This method is used get FollowingFollowerUsers
    * @param type $searchKey
    * @param type $followersArray
    * @return type following follower user list
    */
    public function getFollowingFollowerUsers($searchKey,$followersArray) {
        $result = 'failure';
        try {
            $criteria = new EMongoCriteria();
            $criteria->UserId('in',$followersArray);
            $criteria->addCond('Status', '==', (int)1);
                $criteria->DisplayName = new MongoRegex('/'.$searchKey.'.*/i');                
                $tinyUserObj = UserCollection::model()->findAll($criteria);
                if (isset($tinyUserObj)) {
                    $result = $tinyUserObj;
                }
        } catch (Exception $ex) {
            Yii::log("UserCollection:getFollowingFollowerUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    
   /**
    * @Author Sagar Pathapelli
    * This method is used get TinyUserCollectionForNetworkBySearchKey
    * @param type $networkId
    * @param type $searchKey
    * @return type tiny user collection object
    */
   public function getTinyUserCollectionForNetworkBySearchKey($networkId,$searchKey='', $mentionArray=array()){
       try {
          $returnValue='failure';
          
            $mongoCriteria = new EMongoCriteria;    
            //$mongoCriteria->DisplayName = new MongoRegex("/^$searchKey/i");
            if($searchKey!=''){
              $mongoCriteria->addCond('DisplayName', '==', new MongoRegex('/'.$searchKey.'.*/i'));
            }
            $mongoCriteria->addCond('Status','==',(int)1);
            $mongoCriteria->addCond('UserId','notin',$mentionArray);
            $mongoCriteria->addCond('NetworkId', '==',  $networkId);           
            $tinyUserObj = UserCollection::model()->findAll($mongoCriteria);
            $returnValue=$tinyUserObj;
            return  $returnValue;            
       } catch (Exception $ex) {
           Yii::log("UserCollection:getTinyUserCollectionForNetworkBySearchKey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
      
   public function getTinyUserObjByNetwork($userId){
       try {
            $returnValue='failure';
          
            $mongoCriteria = new EMongoCriteria;            
            $mongoCriteria->addCond('UserId', '==', (int)$userId);
            //$mongoCriteria->addCond('NetworkId', '==', (int)$networkId);
            $tinyUserObj = UserCollection::model()->find($mongoCriteria);
            if(is_object($tinyUserObj)){
                $returnValue= $tinyUserObj;
            }
            return  $returnValue;
            
           
       } catch (Exception $ex) {
           Yii::log("UserCollection:getTinyUserObjByNetwork::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
      
      
      /**
     * @author Praneeth
     * Description: Method to get users list who is following the loggeg user since last login
     * @param type $userFollowersId
     * @return followed users details
     */

    public function getFollowedUserDetailsList($userFollowersId)
    {
        try
        {
            $criteria = new EMongoCriteria();
            $userFollowers=  array_map('intval', $userFollowersId);
            $criteria->UserId('in',$userFollowers);
            $userFollowingObj = UserCollection::model()->findAll($criteria);
            if (isset($userFollowingObj)) {                
                    $returnValue =$userFollowingObj;
                }
        } catch (Exception $ex) {
            Yii::log("UserCollection:getFollowedUserDetailsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
        /**
     * @author Vamsi Krishna
     * @Description This method is for saving user profile collection by type
     * @params $userId,$type,$value
     * @return  success =>Array failure =>string 
     */
    public function updateProfileDetailsbyType($userId, $type, $value, $imageName='', $absolutePath='') {
        $returnValue = "failure";
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $userId);            
            $mongoModifier->addModifier($type, 'set', $value);
            if($type=='ProfilePicture'){
               $mongoModifier->addModifier('profile250x250', 'set', $absolutePath.'/upload/profile/250x250/'.$imageName);
            $mongoModifier->addModifier('profile70x70', 'set', $absolutePath.'/upload/profile/70x70/'.$imageName);
            $mongoModifier->addModifier('profile45x45', 'set', $absolutePath.'/upload/profile/45x45/'.$imageName); 
            }
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue ="success";
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCollection:updateProfileDetailsbyType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
      /** 
       * @autho suresh reddy
       * This method gets update users with profile pic     */
   public function updateallUsers(){
       try {
          $returnValue='failure';
          
             $mongoCriteria = new EMongoCriteria;  
               $mongoCriteria->addCond('userId', '==', (int) 1);        
          //   $mongoCriteria->sort(array('userId' => EMongoCriteria::SORT_ASC));
          
            $tinyUserObj = UserCollection::model()->findAll();
            
            foreach ($tinyUserObj as $obj){
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $obj->UserId);    
           
            $pic1= str_replace("/profile\/","/profile\/70x70\/",$obj->ProfilePicture);
            $mongoModifier->addModifier('ProfilePicture', 'set', $pic1);
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);  
            }
            
            return  $tinyUserObj;
            
       } catch (Exception $ex) {
           Yii::log("UserCollection:updateallUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
    
            /** 
       * @autho suresh reddy
       * This method gets update users with profile pic     */
   public function removeGroupsFollowing(){
       try {
          $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
           
            //  $mongoCriteria->sort(array('userId' => EMongoCriteria::SORT_DESC)); 
           $mongoCriteria->addCond('userId', '==', (int) 6);    
            $tinyUserObj = UserProfileCollection::model()->findAll($mongoCriteria);
          
            foreach ($tinyUserObj as $obj){
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('userId', '==', (int) $obj->userId);    
           
              
            $mongoModifier->addModifier('userVisitedGroupIds', 'set', array());
         $mongoModifier->addModifier('groupsFollowing', 'set', array());
       //     $mongoModifier->addModifier('ProfilePicture', 'set', $pic1);
            UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);  
            
            }
            
            return  $tinyUserObj;
            
    
          
       } catch (Exception $ex) {
           Yii::log("UserCollection:removeGroupsFollowing::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
     
  public function getUserIdbyName($uniqueHandle){
       try {
            $returnValue='failure';
            $uniqueHandlerName = str_replace("%20", ".", $uniqueHandle);
            $mongoCriteria = new EMongoCriteria; 
            $mongoCriteria->setSelect(array('UserId'=>true));
            $mongoCriteria->addCond('uniqueHandle', '==', $uniqueHandlerName);
            //$mongoCriteria->addCond('NetworkId', '==', (int)$networkId);
            $tinyUserObj = UserCollection::model()->find($mongoCriteria);
            if(is_object($tinyUserObj)){
                $returnValue= $tinyUserObj->UserId;
            }
            return  $returnValue;
            
           
       } catch (Exception $ex) {
           Yii::log("UserCollection:getUserIdbyName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
   public function getAllUsers(){
        $returnValue='failure';
       try {
            $mongoCriteria = new EMongoCriteria;                        
            $tinyUserObj = UserCollection::model()->findAll($mongoCriteria);
            if(is_object($tinyUserObj) || is_array($tinyUserObj)){
                $returnValue =$tinyUserObj;
            }
            
            return  $tinyUserObj;
       } catch (Exception $ex) {
            Yii::log("UserCollection:getAllUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return $returnValue;
       }
      }  
      /*
       * @author Vamsi Krishna
       * This method is used to get all the User Ids for Group Auto Follow
       * 
       */
  public function getAllUsersIds(){
  $returnValue='failure';
  try {
  $mongoCriteria = new EMongoCriteria;    
  $mongoCriteria->setSelect(array('UserId'=>true));
 // $mongoCriteria->addCond('UserId','!=', $userId);
  //$mongoCriteria->limit(20);
  $tinyUserObj = UserCollection::model()->findAll($mongoCriteria);
  if(is_object($tinyUserObj) || is_array($tinyUserObj)){
  $returnValue =$tinyUserObj;
  }

            
  return  $tinyUserObj;
  } catch (Exception $ex) {
  Yii::log("UserCollection:getAllUsersIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
  return $returnValue;
  }
  } 
  
  public function updateUserStatus($userId,$value){
      $returnValue='failure';
      try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $userId);            
            $mongoModifier->addModifier('Status', 'set', (int)$value);
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue ="success";
            return $returnValue;
      } catch (Exception $ex) {
          Yii::log("UserCollection:updateUserStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return $returnValue;
      }
    }
    public function getAllUsersExceptNetworkAdmin($userId)
  {
        $returnValue='failure';
  try {
  $mongoCriteria = new EMongoCriteria;    
  $mongoCriteria->addCond('UserId','!=', $userId);
  $tinyUserObj = UserCollection::model()->findAll($mongoCriteria);
  if(is_object($tinyUserObj) || is_array($tinyUserObj)){
  $returnValue =$tinyUserObj;
  }

            
  return  $tinyUserObj;
  } catch (Exception $ex) {
  Yii::log("UserCollection:getAllUsersExceptNetworkAdmin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
  return $returnValue;
  }
      
  }
  
  public function getTinyUserCollectionWithStatusActive($userId){
       try {
          $returnValue='failure';
          
            $mongoCriteria = new EMongoCriteria;            
            $mongoCriteria->addCond('UserId', '==', (int)$userId);
            $mongoCriteria->addCond('Status', '==', (int)1);
            $mongoCriteria->sort('DisplayName',EMongoCriteria::SORT_ASC);
            //$mongoCriteria->sort('UserId',EMongoCriteria::SORT_DESC);
            $tinyUserObj = UserCollection::model()->find($mongoCriteria);
            return  $tinyUserObj;
                
       } catch (Exception $ex) {
           Yii::log("UserCollection:getTinyUserCollectionWithStatusActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
 public function updateUserCollection($userCollection){
      $returnValue='failure';
      try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $userCollection->UserId);            
            $mongoModifier->addModifier('DisplayName', 'set', $userCollection->DisplayName);
             $mongoModifier->addModifier('AboutMe', 'set', $userCollection->AboutMe);
//            $mongoCriteria->addCond('State', '==', (int) $userCollection->State);            
//            $mongoModifier->addModifier('CountryId', 'set', $userCollection->CountryId);
           // $mongoModifier->addModifier('NetworkId', 'set', $userCollection->NetworkId);
          //  $mongoModifier->addModifier('uniqueHandle', 'set', $userCollection->uniqueHandle);
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue ="success";
            return $returnValue;
      } catch (Exception $ex) {
          Yii::log("UserCollection:updateUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in UserCollection->updateUserCollection==".$ex->getMessage());
          return $returnValue;
         
      }
    }
 public function getTinyUserCollectionWithUserIdList($userIdList){
       try {
          $returnValue='failure';
          
            $mongoCriteria = new EMongoCriteria;  
            $mongoCriteria->addCond('UserId', 'in',$userIdList );
            $tinyUserObjList = UserCollection::model()->findAll($mongoCriteria);
            return  $tinyUserObjList;
                
       } catch (Exception $ex) {
           Yii::log("UserCollection:getTinyUserCollectionWithUserIdList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      } 
      public function getyUserCollectionCount(){
       try {
          $returnValue='failure';

            $tinyUserCount = UserCollection::model()->count();
            return  $tinyUserCount;
                
       } catch (Exception $ex) {
           Yii::log("UserCollection:getyUserCollectionCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
          public function getAllUsersByLimit($limitValue){
        $returnValue='failure';
       try {
            $mongoCriteria = new EMongoCriteria; 
            $limitValue=explode(',', $limitValue);
            $offset1=$limitValue[0];
            $mongoCriteria->addCond("UserId", ">=", (int)$offset1);
            if(!empty($limitValue[1])){
                $offset2=$limitValue[1];
                $mongoCriteria->addCond("UserId", "<=", (int)$offset2);
            }
            $tinyUserObj = UserCollection::model()->findAll($mongoCriteria);
            if(is_object($tinyUserObj) || is_array($tinyUserObj)){
                $returnValue =$tinyUserObj;
            }
            
            return  $tinyUserObj;
       } catch (Exception $ex) {
            Yii::log("UserCollection:getAllUsersByLimit::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return $returnValue;
       }
      } 
      public function getUserName($userId){
       try {
          $returnValue='failure';
          
            $mongoCriteria = new EMongoCriteria;    
             $mongoCriteria->setSelect(array('DisplayName'=>true));
            $mongoCriteria->addCond('UserId', '==', (int)$userId);
            $tinyUserObj = UserCollection::model()->find($mongoCriteria);
            if(isset($tinyUserObj)){
                return  $tinyUserObj->DisplayName; 
            }else{
                return "";
            }
           
                
       } catch (Exception $ex) {
           Yii::log("UserCollection:getUserName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
      
        public function updateUserIdentityStatus($userId, $value) {
        $returnValue = 'failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $userId);
            $mongoModifier->addModifier('UserIdentityType', 'set', (int) $value);
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCollection:updateUserIdentityStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
            
        }
    }

    /*
     * @author Vamsi Krishna
     * This method is used to get all the User Ids for Group Auto Follow
     * 
     */

    public function getTechAndBusinesUserIds() {
        $returnValue = 'failure';
        try {
            $NormalUsers = array();
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('UserIdentityType', 'in', array(1,2));
            $mongoCriteria->setSelect(array('UserId' => true));
            //$mongoCriteria->limit(20);
            $tinyUserObj = UserCollection::model()->findAll($mongoCriteria);
            if (is_object($tinyUserObj) || is_array($tinyUserObj)) {
                foreach ($tinyUserObj as $key => $value) {
                    array_push($NormalUsers, $value['UserId']);
                }
                $returnValue = $NormalUsers;
            }


            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCollection:getTechAndBusinesUserIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
public function getAllNotLoggedInUsersFromPastFourdays(){
        $returnValue='failure';
       try {
            $mongoCriteria = new EMongoCriteria; 
            $mongoCriteria->addCond('UserIdentityType', '!=', (int) 0);
            $tinyUserObj = UserCollection::model()->findAll($mongoCriteria);
            if(is_object($tinyUserObj) || is_array($tinyUserObj)){
                $returnValue =$tinyUserObj;
            }
            
            return  $tinyUserObj;
       } catch (Exception $ex) {
           Yii::log("UserCollection:getAllNotLoggedInUsersFromPastFourdays::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
       }
      }


      
      /**
       * 
       * @usage update NetworkBy UserId
       * @param type $userId
       * @param type $networkId
       * @param type $lang
       * @param type $segmentId
       * @return string
       */
        public function updateNetworkByUserId($userId, $networkId, $lang, $segmentId,$countryId) {
        $returnValue = 'failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $userId);
            $mongoModifier->addModifier('NetworkId', 'set', (int) $networkId);
            $mongoModifier->addModifier('Language', 'set', $lang);
            $mongoModifier->addModifier('SegmentId', 'set', (int) $segmentId);
            $mongoModifier->addModifier('CountryId', 'set', (int) $countryId);
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            return $returnValue;
            Yii::log("Exception Occurred in Mongo UserCollection->updateUserIdentityStatus==".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function updateSegmentByUserId($userId, $segmentId) {
        $returnValue = 'failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $userId);
            $mongoModifier->addModifier('SegmentId', 'set', (int) $segmentId);
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            return $returnValue;
            Yii::log("Exception Occurred in Mongo UserCollection->updateUserIdentityStatus==".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function updateLanguageByUserId($userId, $language) {
        $returnValue = 'failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $userId);
            $mongoModifier->addModifier('Language', 'set', $language);
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            return $returnValue;
            Yii::log("Exception Occurred in Mongo UserCollection->updateUserIdentityStatus==".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function updateUserLatLongByUserId($lat, $long,$userId) {
        $returnValue = 'failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $userId);
            $mongoModifier->addModifier('Latitude', 'set', $lat);
            $mongoModifier->addModifier('Longitude', 'set', $long);
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            return $returnValue;
            Yii::log("Exception Occurred in Mongo UserCollection->updateUserIdentityStatus==".$ex->getTraceAsString(), 'error', 'application');
        }
    }

            /**
     * @author Haribabu
     * @Description This method is for saving user profile collection 
     * @params $userId
     * @return  success =>Array failure =>string 
     */
    public function updateProfileDetails($UserprofileModel) {
        $returnValue = "failure";
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int)$UserprofileModel['UserId']);            
            $mongoModifier->addModifier('DisplayName', 'set', $UserprofileModel['DisplayName']);
            $mongoModifier->addModifier('AboutMe', 'set', $UserprofileModel['AboutMe']);
            
            if(UserCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue ="success";
            }
         
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("Exception Occurred in Mongo UserCollection->updateUserIdentityStatus==".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        
    }
    /*
       * @author Reddy
       * This method is used to get all the User Ids for not in our list. 
       * 
       */
  public function getSelectedUsersIds($array=array()){
  $returnValue='failure';
  try {
  $mongoCriteria = new EMongoCriteria;    
  $mongoCriteria->setSelect(array('UserId'=>true));
  $mongoCriteria->addCond('UserId','notin', $array);
  $mongoCriteria->addCond('Status','==', 1);
  //$mongoCriteria->limit(20);
  $tinyUserObj = UserCollection::model()->findAll($mongoCriteria);
  if(is_object($tinyUserObj) || is_array($tinyUserObj)){
  $returnValue =$tinyUserObj;
  }

 
  return  $tinyUserObj;
  } catch (Exception $ex) {
  Yii::log("UserCollection:getAllUsersIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
  return $returnValue;
  }
  } 

  /**
   * @developer kishore
   * @param type $user
   * @return string
   */
  public function updateUserTinyCollection($user){
      $returnValue='failure';
      try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $user->UserId);                       
     
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue ="success";
            return $returnValue;
      } catch (Exception $ex) {
          Yii::log("UserCollection:updateUserTinyCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return $returnValue;
         
      }
    }

    
      public function updateTestTakerImagePath($object,$userid){
      $returnValue='failure';
      try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $userid);                       
            $mongoModifier->addModifier('ProfilePicture', 'set', Yii::app()->params['ServerURL'].$object->Imagesrc);
        
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue ="success";
            return $returnValue;
      } catch (Exception $ex) {
          Yii::log("UserCollection:updateUserTinyCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return $returnValue;
         
      }
    }
}

