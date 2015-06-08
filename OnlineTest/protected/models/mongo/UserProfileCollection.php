<?php

/* This Collection is Used to store all the profile details of the User
 * 
 */

class UserProfileCollection extends EMongoDocument {

    public $userId;   
    public $userFollowing=array();
    public $userFollowers=array();
    public $suggestedUsers=array();
    public $curbsideFollowing=array();
    public $groupsFollowing=array();
    public $hashtagsFollowing=array();
    public $categoriesFollowing=array();
    public $userVisitedGroupIds=array();
    public $userFollowersWithTimeStamp;

    public $SubGroupsFollowing=array();

    

    

    public function getCollectionName() {
        return 'UserProfileCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_userId' => array(
                'key' => array(
                    'userId' => EMongoCriteria::SORT_ASC
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            'userId' => 'userId',
            'userFollowing' => 'userFollowing',
            'userFollowers' => 'userFollowers',
            'suggestedUsers' => 'suggestedUsers',
            'curbsideFollowing' => 'curbsideFollowing',
            'groupsFollowing' => 'groupsFollowing',
            'hashtagsFollowing' => 'hashtagsFollowing',
            'categoriesFollowing' => 'categoriesFollowing',
            'userVisitedGroupIds'=>'userVisitedGroupIds',
            'userFollowersWithTimeStamp'=>'userFollowersWithTimeStamp',
            'SubGroupsFollowing'=>'SubGroupsFollowing',

            
        );
    }


    public function  checkUserExist($email){       
        try {
            $user = UserProfileCollection::model()->findByAttributes(array('email' => $email));
            if (isset($user)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserProfileCollection->checkUserExist==".$ex->getMessage());
        }
    }
  /* This method is used to save into the user Profile collection  
   * it accepts the UserProfileObject and returns true or false 
    */
    public function saveUserProfileCollection($profileModel,$userId){

        try {
            $userProfile=new UserProfileCollection();
            $userProfile->userId=(int)$userId;
            $userProfile->userFollowing=array();
            $userProfile->userFollowers=array();
            $userProfile->curbsideFollowing=array();
            $userProfile->groupsFollowing=array();
            $userProfile->hashtagsFollowing=array();
            $userProfile->categoriesFollowing=array();
        
             if($userProfile->save(false)){
               $id=$userProfile->getPrimaryKey();
              return $id;    

            }else{
               
              return 'error';
            }

//           
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:saveUserProfileCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
  /* This method is used for User Authentication which accepts email and password given by the user 
    * it returns string  
      */
    public function userAuthentication($email, $password) {
        try {
            $returnValue = 'noData';
            $Criteria = new EMongoCriteria;
            $Criteria->email = $email;
            $userCollection = UserProfileCollection::model()->find($Criteria);
            if (count($userCollection) == 1) {
                $Criteria->email = $email;
                $Criteria->password = $password;
                $userData = UserProfileCollection::model()->find($Criteria);

                if (count($userData) == 1) {
                    if ($userData->status == 'active') {
                        $returnValue = 'success';
                    } else {
                        if ($userData->status == 'suspend')
                            $returnValue = 'suspend';
                        if ($userData->status == 'register')
                            $returnValue = 'register';
                    }
                }else {
                    $returnValue = 'passwordIncorrect';
                }
            } else {
                $returnValue = 'wrongEmail';
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:userAuthentication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /*
     * FollowAction: takes 2 arguments; 1:userId and 2:followId updated by suresh remove unnessary condtion on tis
     *  and it performs the follow to a user updated by suresh reddy on 2/3/14. put small condtion '!='
     */
    public function followAction($userId,$followId){
       try{
           $result = "failed";
           $i = 0;
           $modifier = new EMongoModifier();
           $criteria = new EMongoCriteria();
           $modifier->addModifier('userFollowing', 'push', (int)$followId);           
           $criteria->addCond('userId', '==', (int)$userId);
            $criteria->addCond('userFollowing', '!=', (int)$followId);
           UserProfileCollection::model()->updateAll($modifier, $criteria);
           $modifier = new EMongoModifier();
           $criteria = new EMongoCriteria();
           $modifier->addModifier('userFollowers', 'push', (int)$userId);
           $criteria->addCond('userFollowers', '!=', (int)$userId);
           $criteria->addCond('userId', '==', (int)$followId);
           UserProfileCollection::model()->updateAll($modifier, $criteria);
           
           
           UserRecommendations::model()->followStatusAction($userId,$followId, 1);
           $result = "success";
           
       }catch(Exception $ex){
           Yii::log("UserProfileCollection:followAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return "failure";
       }
       return $result;
   }
    /*
     * UnFollowAction: takes 2 arguments; 1:userId and 2:followId
     *  and it performs the unfollow a user
     */
   public function unFollowAction($userId,$followId){
       try{  
           $i = 0;
           $result = "failed";
           $modifier = new EMongoModifier();
           $criteria = new EMongoCriteria();
           $modifier->addModifier('userFollowing', 'pull', (int)$followId);
           $criteria->addCond('userId', '==', (int)$userId);
           if(UserProfileCollection::model()->updateAll($modifier, $criteria)){
               $i++;
           }
           $modifier = new EMongoModifier();
           $criteria = new EMongoCriteria(); 
           $modifier->addModifier('userFollowers', 'pull', (int)$userId);
           $criteria->addCond('userId', '==', (int)$followId);
           if(UserProfileCollection::model()->updateAll($modifier, $criteria)){
               $i++;
           }
           if($i == 2){
               UserRecommendations::model()->followStatusAction($userId,$followId, 0);
               $result = "success";
           }
           
       }catch(Exception $ex){
           Yii::log("UserProfileCollection:unFollowAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
       return $result;
   }
    /**
    * @Author Sagar Pathapelli
    * This method is used get UserFollowersAndFollowings
    * @param type $userId
    * @return type tiny user collection object
    */
    public function getUserFollowersAndFollowingsById($userId) {
        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('userFollowers'=>true,'userFollowing'=>true));
            $criteria->addCond('userId', '==', (int)$userId);
            $userFollowers = UserProfileCollection::model()->find($criteria);
            if (isset($userFollowers)) {
                $followers =$userFollowers->userFollowers;
                $following =$userFollowers->userFollowing;
                $returnValue=  array_merge($followers,$following);
                }
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserFollowersAndFollowingsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
    /**
     *@author karteek.v
    * This method will get the user follower and user following list by userId
    * @param: userId
    */
    public function getUserCollectionByUserId($userId,$loggedUserId) {
        try {
            $userCollArray = array();
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('userFollowers'=>true,'userFollowing'=>true,'userId'=>true,'_id'=>true));
            $criteria->addCond('userId', '==', (int)$userId);
            $userFollowers = UserProfileCollection::model()->find($criteria);
            $i=0;   
            $followers = $following = $followingstatus = 0;
            if(isset($userFollowers->userFollowers)){
                foreach($userFollowers->userFollowers as $rw){ 
                     if($loggedUserId == $rw){
                        $followingstatus = 1;
                    }
                    $followers++;                     
                }
            }            
            if(isset($userFollowers->userFollowing)){
                foreach($userFollowers->userFollowing as $rw){ 
                   
                    $following++;                     
                }
            }
            $userCollArray['userId'] = $userFollowers->userId;
            $userCollArray['followers'] = $followers;
            $userCollArray['following'] = $following;
            $userCollArray['Status'] = $followingstatus;   
            $userCollArray['loggedUserId'] = $loggedUserId;
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserCollectionByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $userCollArray;
    }
     /**
    * @Author suresh reddy
    * This method is used get user followers
    * @param type $userId
    * @return type tiny user collection object
    */
    public function getUserFollowersById($userId) {
        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('userFollowers'=>true));
            $criteria->addCond('userId', '==', (int)$userId);
            $userFollowers = UserProfileCollection::model()->find($criteria);
            if (isset($userFollowers)) {
                $returnValue =$userFollowers->userFollowers;
              
            }
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserFollowersById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
    
    public function getUserFollowingGroups($UserId)
    {
        $returnValue = 'failure';
        try
        {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('groupsFollowing'=>true));
            $criteria->addCond('userId', '==', (int)$UserId);
            $groupsFollowing = UserProfileCollection::model()->find($criteria);          
            if (isset($groupsFollowing)) {
                $returnValue =$groupsFollowing->groupsFollowing;
              
            }else{
                $returnValue=array();
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserFollowingGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }
    
     /**
    * @Author Praneeth
    * This method is used to follower and follow
    * @param type $userId
    * @return type tiny user collection object
    */
    public function followOrUnfollowGroup($groupId, $userId, $actionType)
    {
        try
        {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow') {
                $mongoModifier->addModifier('groupsFollowing', 'push', new MongoId($groupId));
                $mongoCriteria->addCond('groupsFollowing', '!=', new MongoId($groupId));
            } else if($actionType == 'UnFollow'){                
               $mongoModifier->addModifier('groupsFollowing', 'pull', new MongoId($groupId));
               $this->removeSubGroupArray($groupId,$userId);
            }
            $mongoCriteria->addCond('userId', '==', (int)$userId);
            $returnValue = UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:followOrUnfollowGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

   
    /**
     * @author Vamsi Krishna
     * @Description This method is use to  update the user Profile for groupRecent Activity 
     * @param type userId           
     * @return  success =>Array failure =>string 
     */  
   public function updateUserProfileForGroupActivity($userId,$groupId){
       try {
           $returnValue='failure';
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;
           $mongoModifier->addModifier('userVisitedGroupIds', 'pull', new MongoId($groupId));
           $mongoCriteria->addCond('userId', '==', (int)$userId);
            UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
           
           $mongoModifier->addModifier('userVisitedGroupIds', 'push', new MongoId($groupId));
            UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
       } catch (Exception $ex) {
           Yii::log("UserProfileCollection:updateUserProfileForGroupActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      } 
     /**
     * @author Vamsi Krishna
     * @Description This method is use to  groupRecent Activity 
     * @param type userId           
     * @return  success =>Array failure =>string 
     */  
   public function getUserGroupActivity($userId)   {
       try {
           $returnValue='failure';
           $criteria = new EMongoCriteria;
           $criteria->setSelect(array('userVisitedGroupIds'=>true));
           $criteria->addCond('userId', '==', (int)$userId);
           $userGroupActivity = UserProfileCollection::model()->find($criteria);
           if(isset($userGroupActivity->userVisitedGroupIds) && count($userGroupActivity->userVisitedGroupIds)>0 ){
               $returnValue=$userGroupActivity->userVisitedGroupIds;
           }
           return $returnValue;
       } catch (Exception $ex) {
          Yii::log("UserProfileCollection:getUserGroupActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }

     /**
     * @author Vamsi Krishna
     * @Description This method is use to  get User Profile 
     * @return  success =>Array failure =>string 
     */  
    public function getUserProfileCollection($userId) {
          $returnValue='failure';
        try {
            
            $criteria = new EMongoCriteria;
            $criteria->addCond('userId', '==', (int)$userId);
           $userProfileCollection = UserProfileCollection::model()->find($criteria);
           if(isset($userProfileCollection)){
               $returnValue =$userProfileCollection;
           }
           return $returnValue;
        } catch (Exception $ex) {            
            Yii::log("UserProfileCollection:getUserProfileCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             return $returnValue;
        }
    }
    
    
     /**
    * @Author suresh reddy
    * This method is used to put  hashtag   id in user profile collectons
    * @param type $userId
    * @return type tiny user collection object
    */
    public function followUnFollowHashTag($hashTag, $userId, $actionType)
    {
        try
        {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow' || $actionType == 'follow') {
                $mongoModifier->addModifier('hashtagsFollowing', 'push', new MongoId($hashTag));
            } else if($actionType == 'UnFollow' || $actionType == 'unfollow'){
                $mongoModifier->addModifier('hashtagsFollowing', 'pop', new MongoId($hashTag));
            }
            $mongoCriteria->addCond('userId', '==', $userId);
            $returnValue = UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:followUnFollowHashTag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       return 'failure';
             }
    }
    
    
     /**
      * @author suresh reddy
     * This method is used to follow and un follow of curbside posts
     * @param type $categoryId
     * @return type object
     *  @author suresh reddy
     */
     public function followOrUnfollowCurbsideCategory($categoryId,$userId,$actionType) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'follow' || $actionType == 'Follow') {
                $mongoModifier->addModifier('curbsideFollowing', 'push', (int)$categoryId);
                $mongoCriteria->addCond('curbsideFollowing', '!=',$categoryId);
            } else {
                $mongoModifier->addModifier('curbsideFollowing', 'pop', (int)$categoryId);
            }
            $mongoCriteria->addCond('userId', '==', $userId);
            $returnValue = UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:followOrUnfollowCurbsideCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
        
    }
    
      /**
    * @Author Vamsi Krishna
    * This method is used get user following
    * @param type $userId
    * @return type tiny user collection object
    */
    public function getUserFollowingById($userId) {
        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('userFollowing'=>true));
            $criteria->addCond('userId', '==', (int)$userId);
            $userFollowers = UserProfileCollection::model()->find($criteria);
            if (isset($userFollowers)) {
                $returnValue =$userFollowers->userFollowing;
              
            }
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserFollowingById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
     /**
    * @Author Vamsi 
    * This method is used to follower and follow
    * @param type $userId
    * @return type tiny user collection object
    */
    public function followOrUnfollowSubGroup($groupId, $userId, $actionType,$subGroupId)
    {
        try
        {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            
            if ($actionType == 'Follow') {
                $groupsArray=array();
                $subGroup=new SubGroup();
                $subGroup->GroupId=new MongoId($groupId);
                $subGroup->SubGroupId=new MongoId($subGroupId);
                $mongoModifier->addModifier('SubGroupsFollowing', 'push',$subGroup);
            } else if($actionType == 'UnFollow'){
                $subGroupObj=new SubGroup();
                $subGroupObj->GroupId=new MongoId($groupId);
                $subGroupObj->SubGroupId=new MongoId($subGroupId);                
                $mongoModifier->addModifier('SubGroupsFollowing', 'pull', $subGroupObj);
            }
            $mongoCriteria->addCond('userId', '==', $userId);
            $returnValue = UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:followOrUnfollowSubGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function getUserFollowingSubGroups($UserId,$groupId)
    {
        $returnValue = 'failure';
        try
        {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('SubGroupsFollowing'=>true));            
            $criteria->addCond('SubGroupsFollowing.GroupId', '==', new MongoId($groupId));
            $criteria->addCond('userId', '==', (int)$UserId);            
            $groupsFollowing = UserProfileCollection::model()->find($criteria);  
           
            if (isset($groupsFollowing)) {
                $returnValue =$groupsFollowing->SubGroupsFollowing;
              
            }           
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserFollowingSubGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserProfileCollection->getUserFollowingSubGroups==".$ex->getMessage());
         }
    }
    
    public function  removeSubGroupArray($groupId,$userId){
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
       $userFollowingGroups = UserProfileCollection::model()->getUserFollowingSubGroups($userId,$groupId);         
        $subGroupIds=array();       
        if ($userFollowingGroups != 'failure') {
                foreach ($userFollowingGroups as $subgroup) {        
                    array_push($subGroupIds, $subgroup['SubGroupId']);
                }
            }
          if(count($subGroupIds)>0){
       foreach($subGroupIds as $subGroup){

               $subGroupObj=new SubGroup();
                $subGroupObj->GroupId=new MongoId($groupId);
                $subGroupObj->SubGroupId=new MongoId($subGroup);                
                $mongoModifier->addModifier('SubGroupsFollowing', 'pull', $subGroupObj);
                $mongoCriteria->addCond('userId', '==', $userId);
            $returnValue = UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
           } 
          }
       
             
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:removeSubGroupArray::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in UserProfileCollection->removeSubGroupArray==".$ex->getMessage());
        }

       
    }
  /**
    * @Author Vamsi Krishna 
    * This method is used to follower and follow Group 
    * @param type $userId
    * @return type tiny user collection object
    */
    public function followOrUnfollowGroupForAllUsersInTheSystem($groupId, $userIds, $actionType)
    {
        try
        {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow') {
                $mongoModifier->addModifier('groupsFollowing', 'push', new MongoId($groupId));
                $mongoCriteria->addCond('groupsFollowing', '!=', new MongoId($groupId));
            } else if($actionType == 'UnFollow'){                
               $mongoModifier->addModifier('groupsFollowing', 'pull', new MongoId($groupId));
               $this->removeSubGroupArray($groupId,$userId);
            }
            $mongoCriteria->addCond('userId', 'in', $userIds);
            $returnValue = UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:followOrUnfollowGroupForAllUsersInTheSystem::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserProfileCollection->followOrUnfollowGroupForAllUsersInTheSystem==".$ex->getMessage());
        }
    }
    
    public function getUserFollowersFollowingsById($userId,$offset=0,$limit=0) {
        $returnValue = 'failure';
        try {            
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('userFollowers'=>true,'userFollowing'=>true));
            $criteria->addCond('userId', '==', (int)$userId);
            $userFollowers = UserProfileCollection::model()->find($criteria);
            $followers = $following = $returnValue = array();
            $j = 0;
            if (isset($userFollowers)) {
                for($i=$offset;$i<$offset+$limit;$i++){
                    if(isset($userFollowers->userFollowers[$i]))
                        $followers[$j] = $userFollowers->userFollowers[$i];
                    if(isset($userFollowers->userFollowing[$i]))
                        $following[$j] = $userFollowers->userFollowing[$i];
                    $j++;
                    
                }
                $returnValue =  array_merge($followers,$following);
            }
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserFollowersFollowingsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserProfileCollection->getUserFollowersFollowingsById==".$ex->getMessage());
        }
        return $returnValue;
    }
    
     public function getUserFollowersFollowingsByUserId($userId) {
        $returnValue = 'failure';
        try {            
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('userFollowers'=>true,'userFollowing'=>true));
            $criteria->addCond('userId', '==', (int)$userId);
            $userFollowers = UserProfileCollection::model()->find($criteria);
            $followers = $following = array();
            $j = 0;
            if (isset($userFollowers)) {
              $returnValue= $userFollowers;
            }
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserFollowersFollowingsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserProfileCollection->getUserFollowersFollowingsByUserId==".$ex->getMessage());
        }
        return $returnValue;
    }
  /**
 * all the below methods are used to get the data for new profile 
 */ 
    
    public function getUserProfileCollectionByType($userId,$selectArray="",$limit=""){
    $returnValue='failure';
        try {
            
            $criteria = new EMongoCriteria;
            $criteria->setSelect($selectArray);
            $criteria->addCond('userId', '==', (int)$userId);
            if($limit!=0 && isset($limit)){                
                $criteria->limit($limit); 
             
            }
            
            
           $userProfileCollection = UserProfileCollection::model()->find($criteria);
           if(isset($userProfileCollection)){
               $returnValue =$userProfileCollection;
           }
           return $returnValue;
        } catch (Exception $ex) {            
            Yii::log("UserProfileCollection:getUserProfileCollectionByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             return $returnValue;
        }
        }
        
          /**
    * @Author Vamsi Krishna
    * This method is used get user following by slice
    * @param type $userId
    * @return type tiny user collection object
    */
    public function getUserFollowingSliceById($userId,$pageLength,$pageSize) {
        $returnValue = 'failure';
        try {            
            $db= UserProfileCollection::model()->getCollection();
            $cursor = $db->find( array('userId'=>(int)$userId),array('userFollowing' => array( '$slice' => [$pageSize,$pageLength] ) ));
            $var=$cursor->getNext();     
            if(count($var['userFollowing'])>0)
            $returnValue =$var['userFollowing'];
            else
                 $returnValue =0;
            
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserFollowingSliceById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
       /**
    * @Author Vamsi Krishna
    * This method is used get user following by slice
    * @param type $userId
    * @return type tiny user collection object
    */
        public function getUserFollowersSliceById($userId,$pageLength,$pageSize) {
        $returnValue = 'failure';
        try {
            
            $db= UserProfileCollection::model()->getCollection();
            $cursor = $db->find( array('userId'=>(int)$userId),array('userFollowers' => array( '$slice' => [$pageSize,$pageLength] ) ));
            $var=$cursor->getNext();  
            
              if(count($var['userFollowers'])>0){
              $returnValue =$var['userFollowers'];                            
              }
             else{
                 $returnValue =0;
             }
                 
                     
        } catch (Exception $ex) {
            Yii::log("UserProfileCollection:getUserFollowersSliceById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
   public function updateUsersForGroupInactive($groupId){
       try {
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;
           $mongoModifier->addModifier('groupsFollowing', 'pull', new MongoId($groupId));
           $returnValue = UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
       } catch (Exception $ex) {
           Yii::log("UserProfileCollection:updateUsersForGroupInactive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in UserProfileCollection->updateUsersForGroupInactive==".$ex->getMessage());
       }
   }
   public function updateUsersForSubGroupInactive($subgroupId){
       try {
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;
           $mongoModifier->addModifier('SubGroupsFollowing', 'pull', new MongoId($subgroupId));
           $returnValue = UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
       } catch (Exception $ex) {
           Yii::log("UserProfileCollection:updateUsersForSubGroupInactive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in UserProfileCollection->updateUsersForSubGroupInactive==".$ex->getMessage());
       }
   }
       
    public function updateUsersForGroupActive($groupId){
       try {
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;
           
           $groupDetails=GroupCollection::model()->getGroupDetailsById($groupId);
           if(!is_string($groupDetails)){
               foreach($groupDetails->GroupMembers as $userId){                   
                   $mongoModifier->addModifier('groupsFollowing', 'push', new MongoId($groupId));
                   $mongoCriteria->addCond('userId', '==', (int)$userId);
                   UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);        
               }
           }
       } catch (Exception $ex) {
           Yii::log("UserProfileCollection:updateUsersForGroupActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in UserProfileCollection->updateUsersForGroupActive==".$ex->getMessage());
       }   
      } 
      
      public function updateUsersForSubGroupActive($subgroupId){
       try {
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;
           
           $subGroupDetails=SubGroupCollection::model()->getSubGroupDetailsById($subgroupId);
           if(!is_string($subGroupDetails)){
               foreach($subGroupDetails->SubGroupMembers as $userId){                   
                   $mongoModifier->addModifier('SubGroupsFollowing', 'push', new MongoId($subgroupId));
                   $mongoCriteria->addCond('userId', '==', (int)$userId);
                   UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);        
               }
           }
       } catch (Exception $ex) {
           Yii::log("UserProfileCollection:updateUsersForSubGroupActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in UserProfileCollection->updateUsersForSubGroupActive==".$ex->getMessage());
       }   
      }
}

