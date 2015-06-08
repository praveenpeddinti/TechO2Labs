<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PostCollection extends EMongoDocument {
    public $_id;
    public $Type;
    public $UserId;
    public $Priority;
    public $CreatedOn;
    public $Description;
    public $Followers;
    public $Mentions;
    public $Comments;
    public $Resource;
    public $Love;
    public $HashTags;
    public $Invite;
    public $Share;
    public $StartDate;
    public $EndDate;
    public $Location;
    public $EventAttendes;
    
    public $StartTime;
    public $EndTime;
    public $WebUrls;
    public $OptionOneCount;
    public $OptionTwoCount;
    public $OptionThreeCount;
    public $OptionFourCount;
    public $OptionOne;
    public $OptionTwo;
    public $OptionThree;
    public $OptionFour;
    public $IsAbused=0;//0 - Default/Release, 1 - Abused, 2 - Blocked
    public $AbusedUserId;
    public $IsDeleted=0;
    public $IsPromoted=0;
    public $PromotedUserId;
    public $AbusedOn;
    public $SurveyTaken; 
    public $ExpiryDate;
    public $DisableComments=0;
    public $IsBlockedWordExist=0;
    public $IsFeatured = 0;
    public $IsAnonymous = 0;
    public $FeaturedUserId;
    public $FeaturedOn;
    public $IsBlockedWordExistInComment=0;
    public $IsWebSnippetExist = 0;
    public $Division=0;
    public $District=0;
    public $Region=0;
    public $Store=0;
    public $FbShare;
    public $TwitterShare;
    public $Title;
    public $MigratedPostId='';
    //$postedBy is added by Sagar for PostAsNetwork
    public $PostedBy = 0;
    public $PromotedDate;
    public $IsCommentAbused = 0;
    public $NetworkId = 1;
    public $SegmentId = 0;
    public $Language = 'en';
    public $saveItForLaterUserIds = array();

     public $IsUseForDigest=0;
    public function getCollectionName() {
        return 'PostCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    
    public function rules()
    {
        return array(
         

    
            array('EventAttendes', 'unique', 'attributeName'=> 'EventAttendes', 'caseSensitive' => 'false'),

          
        );
    }

     public function attributeNames() {
        return array(
            '_id'=>'_id',
            'Type' => 'Type',
            'UserId' => 'UserId',
            'Priority' => 'Priority',
            'CreatedOn' => 'CreatedOn',
            'Description' => 'Description',
            'Followers' => 'Followers',
            'Mentions'=>'Mentions',            
            'Comments' => 'Comments',            
            'Love' => 'Love',
            'Resource' => 'Resource',
            'HashTags' => 'HashTags',
            'Invite'=>'Invite',
            'Share'=>'Share',
            'StartDate' => 'StartDate',
            'EndDate' => 'EndDate',
            'Location'=>'Location',
            'EventAttendes'=>'EventAttendes',
              'OptionOneCount'=>'OptionOneCount',
            'OptionTwoCount'=>'OptionTwoCount',
              'OptionThreeCount'=>'OptionThreeCount',
             'OptionFourCount'=>'OptionFourCount',
              'WebUrls'=>'WebUrls',
            'StartTime'=>'StartTime',
            'EndTime'=>'EndTime',
            'IsAbused'=>'IsAbused',
            'AbusedUserId'=>'AbusedUserId',
            'IsDeleted'=>'IsDeleted',
            'IsPromoted'=>'IsPromoted',
            'PromotedUserId'=>'PromotedUserId',
            'AbusedOn'=>'AbusedOn',
            'SurveyTaken'=>'SurveyTaken',
            'OptionOne'=>'OptionOne',
            'OptionTwo'=>'OptionTwo',
            'OptionThree'=>'OptionThree',
            'OptionFour'=>'OptionFour',
            'ExpiryDate'=>'ExpiryDate',
            'DisableComments'=>'DisableComments',
            'IsBlockedWordExist'=>'IsBlockedWordExist',
            'IsFeatured' => 'IsFeatured',
             'IsAnonymous' => 'IsAnonymous',
            'FeaturedUserId' => 'FeaturedUserId',
            'FeaturedOn' => 'FeaturedOn',
            'IsBlockedWordExistInComment'=>'IsBlockedWordExistInComment',
            'IsWebSnippetExist'=>'IsWebSnippetExist',
            'Division'=>'Division',
            'District'=>'District',
            'Region'=>'Region',
            'Store'=>'Store',
            'FbShare'=>'FbShare',
            'TwitterShare'=>'TwitterShare',
            'Title'=>'Title',
            'MigratedPostId'=>'MigratedPostId',
            'PostedBy'=>'PostedBy',
            'PromotedDate'=>'PromotedDate',
            'IsCommentAbused'=>'IsCommentAbused',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
             'saveItForLaterUserIds'=>'saveItForLaterUserIds',
            'IsUseForDigest'=>'IsUseForDigest'
        );
    }
  public function followOrUnfollowPost($postId, $userId, $actionType) {
        try {
            $returnValue = 'failure';
            // throw new Exception('Unable to follow or unfollow');
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow') {
                $mongoModifier->addModifier('Followers', 'push', (int)$userId);
                $mongoCriteria->addCond('Followers', '!=', (int)$userId);
            } else if($actionType == 'UnFollow'){
                $mongoModifier->addModifier('Followers', 'pull', (int)$userId);
            }

            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            if(PostCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue = 'success';
            }
            
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("PostCollection:followOrUnfollowPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    public function loveNormalPost($postId,$userId){
      try {          
           $returnValue=FALSE;
           //throw new Exception('Unable to save love');
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;           
           $mongoModifier->addModifier('Love', 'push', (int)$userId);
           $mongoCriteria->addCond('_id', '==', new MongoId($postId));
           $mongoCriteria->addCond('Love', '!=', (int)$userId);         
           if(PostCollection::model()->updateAll($mongoModifier,$mongoCriteria)){
               $returnValue=TRUE;
           }
           
           return $returnValue;
      } catch (Exception $ex) {
         Yii::log("PostCollection:loveNormalPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in PostCollection->loveNormalPost==".$ex->getMessage());
         return FALSE;
      }
      
    }
  public function saveComment($postId,$comments){
      try {
           $returnValue = FALSE;
          //throw new Exception('Division by zero.');
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;  
           $mongoModifier->addModifier('Comments', 'push', $comments);
           $mongoCriteria->addCond('_id', '==', new MongoId($postId));
           if(PostCollection::model()->updateAll($mongoModifier,$mongoCriteria)){
               $returnValue = TRUE;
           }else{
           }
             return $returnValue;
      } catch (Exception $ex) {         
        Yii::log("PostCollection:saveComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        return FALSE;
      }
     
    }
    /**
     * 
     * @param type $postId
     * @param type $resourceArray
     */
  public function updatePostWithArtifacts($postId,$resourceArray){
      try {
         
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;              
           $mongoModifier->addModifier('Resource', 'push', $resourceArray); 
           $mongoCriteria->addCond('_id', '==', new MongoID($postId));           
           PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
      } catch (Exception $ex) {
          Yii::log("PostCollection:updatePostWithArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
  public function saveOrRemoveEventAttende($postId,$userId,$actionType){
      try {
          $returnValue='failure';
          $mongoCriteria = new EMongoCriteria;
          $mongoModifier = new EMongoModifier; 
          if($actionType=='Attend'){
           $mongoModifier->addModifier('EventAttendes', 'push', (int)$userId); 
           $mongoCriteria->addCond('EventAttendes', '!=', (int)$userId);
          }else{
              $mongoCriteria->addCond('EventAttendes', '==', (int)$userId); 
           $mongoModifier->addModifier('EventAttendes', 'pop', (int)$userId);    
          }          
          $mongoCriteria->addCond('_id', '==', new MongoID($postId)); 
          $return=PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
           return 'success';
          
      } catch (Exception $ex) {
         Yii::log("PostCollection:saveOrRemoveEventAttende::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
   public function getPostObjectFollowers($postId){
             
            $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Followers'=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = PostCollection::model()->find($criteria);
            if (isset($objFollowers->Followers)) {
                $returnValue =$objFollowers->Followers;
                          }
        } catch (Exception $ex) {
            Yii::log("PostCollection:getPostObjectFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
       
        }
        
   public function getObjectSaveItForLaterUsers($postId){
             
            $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('saveItForLaterUserIds'=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = PostCollection::model()->find($criteria);
            if (isset($objFollowers->saveItForLaterUserIds)) {
                $returnValue =$objFollowers->saveItForLaterUserIds;
                          }
        } catch (Exception $ex) {
            Yii::log("PostCollection:getObjectSaveItForLaterUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
       
        }      
    public function getPostById($postId,$checkisdeleted=0) {
        try {
            
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            if($checkisdeleted==1){
            $criteria->addCond('IsDeleted', '!=', 1);
            }
            $postObj = PostCollection::model()->find($criteria);
            if (is_object($postObj)) {
                $returnValue = $postObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("PostCollection:getPostById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getLoveUserIdsByPostId($postId){
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Love'=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $loveObjForPost = PostCollection::model()->find($criteria);
            if (isset($loveObjForPost->Love)) {                
                $returnValue =$loveObjForPost->Love;
                          }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("PostCollection:getLoveUserIdsByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function saveInvites($UserId, $PostId, $InviteText, $Mentions) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $inviteArray = array();
           // throw new Exception('Division by zero.');
            array_push($inviteArray, (int)$UserId);
            array_push($inviteArray, array_unique($Mentions));
            array_push($inviteArray, $InviteText);
            $mongoModifier->addModifier('Invite', 'push', $inviteArray);
            $mongoCriteria->addCond('_id', '==', new MongoID($PostId));
            if(PostCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
            return 'success';
            }
            else{
                return 'failure'; 
            }
        } catch (Exception $ex) {
            Yii::log("PostCollection:saveInvites::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in PostCollection->saveInvites==".$ex->getMessage());
            return 'failure';
            
        }

    }
            
    /**
     * @author karteek.v
     * @param type $postIdsArray
     * @return array
     */
    public function getPostByIds($postId) {
        try {
//            $postIdsArray = array_unique($postIdsArray);
            $returnValue = array();// only one time it will be flushed
            $returnArr = array();
            $i =0;
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = PostCollection::model()->find($criteria);
            if (is_object($postObj)) {
//                    if (isset($postObj->_id) && !empty($postObj->_id)) {
                        foreach ($postObj->_id as $rw) {
                            $returnArr['PostId'] = $rw;
                        }
                        $returnArr['LoveUserId'] = $postObj->UserId;
                        //$returnArr['Description'] = $postObj->Description;
                        $returnArr['LoveCount'] = count($postObj->Love);
                        $count = 0;
                        foreach ($postObj->Comments as $key=>$value) {
                            $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
                            $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
                            if(!$IsBlockedWordExist && !$IsAbused){
                                $count++;
                            }
                        }
                        $returnArr['CommentCount'] =$count;
                        $returnArr['FollowCount'] = count($postObj->Followers);
                       
                        
                 $lovefollowArray =  CommonUtility::getLoveAndFollowUsers($this->tinyObject['UserId'],$postObj->Love,$postObj->Followers);         
              
                $returnArr["loveUsersArray"] =$lovefollowArray["loveUsersArray"];
                 $returnArr["followUsersArray"] = $lovefollowArray["followUsersArray"];    
                        
                        
//                        array_push($returnValue, $returnArr);
//                    }
              }
//            foreach ($postIdsArray as $rw) {
//                
//                $returnArr = array(); // each and every iteration it will be flushed
//                $criteria = new EMongoCriteria;
//                $criteria->addCond('_id', '==', new MongoID($rw));
//                $postObj = PostCollection::model()->find($criteria);
//                if (is_object($postObj)) {
////                    if (isset($postObj->_id) && !empty($postObj->_id)) {
//                        foreach ($postObj->_id as $rw) {
//                            $returnArr['PostId'] = $rw;
//                        }
//                        $returnArr['LoveUserId'] = $postObj->UserId;
//                        $returnArr['Description'] = $postObj->Description;
//                        $returnArr['LoveCount'] = count($postObj->Love);
//                        $count = 0;
//                        foreach ($postObj->Comments as $key=>$value) {
//                            if (!(isset($value ['IsBlockedWordExist']) && $value ['IsBlockedWordExist']==1)) {
//                                $count++;
//                            }
//                        }
//                        $returnArr['CommentCount'] =$count;
////                        $returnArr['FollowCount'] = count($postObj->Followers);
//                        array_push($returnValue, $returnArr);
////                    }
//                }
//            }// updating stream collection
              if(!empty($returnArr))
                $this->updateStreamPostCountsFromNodeRequest($returnArr);
            return $returnArr;
        } catch (Exception $ex) {
            Yii::log("PostCollection:getPostByIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Karteek.V
     * @param type $streamCountArray
     * Method is used to update the social actions
     * @return void
     */
    public function updateStreamPostCountsFromNodeRequest($streamCountArray){
        try{
            if(isset($streamCountArray[0])){
                foreach($streamCountArray as $mrow){
                    $userStreamObj = new UserStreamBean();
                    $userStreamObj->LoveUserId = $mrow['LoveUserId'];
                    $userStreamObj->PostId = $mrow['PostId'];
                    $userStreamObj->LoveCount = $mrow['LoveCount'];
                    $userStreamObj->CommentCount = $mrow['CommentCount'];
                    $result = UserStreamCollection::model()->isThereByUserId($userStreamObj);
                    echo $result;
                    if(!$result){                    
                        UserStreamCollection::model()->updateStreamSocialActions($userStreamObj);
                    }                
                }
            }else{
                $userStreamObj = new UserStreamBean();
                $userStreamObj->LoveUserId = $streamCountArray['LoveUserId'];
                $userStreamObj->PostId = $streamCountArray['PostId'];
                $userStreamObj->LoveCount = $streamCountArray['LoveCount'];
                $userStreamObj->CommentCount = $streamCountArray['CommentCount'];
                $result = UserStreamCollection::model()->isThereByUserId($userStreamObj);
                echo $result;
                if(!$result){                    
                    UserStreamCollection::model()->updateStreamSocialActions($userStreamObj);
                }                
            }
            
        } catch (Exception $ex) {
            Yii::log("PostCollection:updateStreamPostCountsFromNodeRequest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in PostCollection->updateStreamPostCountsFromNodeRequest==".$ex->getMessage());
        }
    }
    public function submitSurvey($UserId, $PostId, $Option) {
        try {  
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $surveyArray = array();
            $surveyArray['UserId'] = (int)$UserId;
            $surveyArray['UserOption'] = $Option;
            $mongoModifier->addModifier('SurveyTaken', 'push', $surveyArray);
            if($Option=='OptionOne'){
                $mongoModifier->addModifier('OptionOneCount', 'inc', 1);
            }elseif($Option=='OptionTwo'){
                $mongoModifier->addModifier('OptionTwoCount', 'inc', 1);
            }elseif($Option=='OptionThree'){
                $mongoModifier->addModifier('OptionThreeCount', 'inc', 1);
            }elseif($Option=='OptionFour'){
                $mongoModifier->addModifier('OptionFourCount', 'inc', 1);
            }
            $mongoCriteria->addCond('_id', '==', new MongoID($PostId));
            if(PostCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
            return 'success';
            }else{
                 return 'failure';
            }
        } catch (Exception $ex) {
            Yii::log("PostCollection:submitSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
    }
    /**
     * @author Sagar Pathapelli
     * @Description Abuse a post
     * @param type $postId
     * @param string $actionType
     * @param type $userId
     * @return string
     */
    public function abusePost($postId, $actionType, $userId="", $isBlockedPost=0){
        try { 
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
             if($actionType=='Abuse'){
                 $mongoModifier->addModifier('IsAbused', 'set', 1);
                 $mongoModifier->addModifier('AbusedUserId', 'set', (int)$userId);
                 $mongoModifier->addModifier('AbusedOn','set',new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
              }elseif ($actionType=="Block") {
                 if($isBlockedPost==0){
                    $mongoModifier->addModifier('IsAbused', 'set', 2);
                 }else{
                     $mongoModifier->addModifier('IsBlockedWordExist', 'set', 2);
                 }
             }elseif ($actionType="Release") {
                 if($isBlockedPost==0){
                     $mongoModifier->addModifier('IsAbused', 'set', 0);
                 }else{
                     $mongoModifier->addModifier('IsBlockedWordExist', 'set', 0);
                 }
             }
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("PostCollection:abusePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author Sagar Pathapelli
     * @Description promote the post
     * @param type $postId
     * @param type $userId
     * @param type $promoteDate
     * @param type $categoryId
     * @param type $networkId
     * @return string
     */
    public function promotePost($postId, $userId, $promoteDate){
        try {       
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
             $mongoModifier->addModifier('IsPromoted', 'set', 1);
             $mongoModifier->addModifier('PromotedUserId', 'set', (int)$userId);
             $mongoModifier->addModifier('PromotedDate','set',new MongoDate(strtotime($promoteDate)));
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("PostCollection:promotePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function saveitforlaterPost($postId, $userId){
        try {          
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
              $mongoModifier->addModifier('saveItForLaterUserIds', 'push', (int)$userId);
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("PostCollection:saveitforlaterPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * @author Sagar Pathapelli
     * @Description deleting a post
     * @param type $postId
     * @param type $categoryId
     * @param type $networkId
     * @return string
     */
    public function deletePost($postId){
        try {          
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
             $mongoModifier->addModifier('IsDeleted', 'set', 1);
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));
             $returnValue=PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';
        } catch (Exception $ex) {
           Yii::log("PostCollection:deletePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     
     /**
     * @author Vamsi Krishna
     * @Description this method is to get the comments for post
     * @param type $postId
     * @return success=> array failure=>String
     */
    
  public function getPostCommentsByPostId($postId){
    try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
          //  $criteria->setSelect(array('Comments='=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = PostCollection::model()->find($criteria);   
            if (isset($postObj->Comments)) {
                $returnValue =$postObj->Comments;
                }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("PostCollection:getPostCommentsByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }  
  }  
  /**
   * @author Sagar Pathapelli
   * @param type $postId
   * @return 
   */
  public function getInvitedUsersForPost($postId) {

        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Invite' => true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = PostCollection::model()->find($criteria);
            if (isset($objFollowers->Invite)) {
                $returnValue = $objFollowers->Invite;
            }
        } catch (Exception $ex) {
            Yii::log("PostCollection:getInvitedUsersForPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        return $returnValue;
    }
    
     /**
   * @author Praneeth
   * Description: getUserSignedUpEventDetails to get the user attending the events
   * @param type $userEventSignedUpActivities, current login
   * @return 
   */
  public function getUserSignedUpEventDetails($userEventSignedUpActivities,$CurrentLoginDate) {

        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Invite' => true));
            $criteria->addCond('_id', '==', new MongoID($userEventSignedUpActivities));
            $objFollowers = PostCollection::model()->find($criteria);
            if (isset($objFollowers->Invite)) {
                $returnValue = $objFollowers->Invite;
            }
        } catch (Exception $ex) {
            Yii::log("PostCollection:getUserSignedUpEventDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        return $returnValue;
    }
 /**
     * @author Moin Hussain
     * @param $searchText,$offset,$pageLength
     * @return 
     */
    public function getPostsForSearch($searchText, $offset, $pageLength) {
   try {
         $array = array(
            'conditions' => array(
                'Description' => array('or' => new MongoRegex('/' . $searchText . '.*/i')),
                'Comments.CommentText' => array('or' => new MongoRegex('/' . $searchText . '.*/i')),
                'IsDeleted'=>array('!=' => 1),
                'IsBlockedWordExist'=>array('notIn' => array(1,2)),
                'IsAbused'=>array('notIn' => array(1,2)),
            ),
             
            'limit' => $pageLength,
            'offset' => $offset,
            'sort' => array('_id' => EMongoCriteria::SORT_DESC),
        );
        
        
        $posts = PostCollection::model()->findAll($array);
        $postsArray = array();
        foreach ($posts as $post) {
             
             $tagsFreeDescription= strip_tags(($post->Description));
             $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
             $postLength =  strlen($tagsFreeDescription);
            
            if($postLength>240){
                 $post->Description =  CommonUtility::truncateHtml($post->Description, 240,'Read more',true,true,' <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i>'); 
                 $post->Description = $post->Description;
            }
           
            if(isset($post->UserId)){
            $user = UserCollection::model()->getTinyUserCollection($post->UserId);
            if($post->IsAnonymous == 1){
                 $title = "Anonymous Post";
            }else{
                $title = $user->DisplayName;
            }
            array_push($postsArray, array($post,$title, "1"));
            }
        }
  }catch (Exception $ex) {
      Yii::log("PostCollection:getPostsForSearch::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $postsArray;
        }
        return $postsArray;
    }
     /**
     * @author Moin Hussain
     * @param $hashtagId, $offset, $pageLength
     * @return 
     */
    public function getPostsForHashtag($hashtagId, $offset, $pageLength) {
        try{
        $array = array(
            'conditions' => array(
                'HashTags' => array('in' => array(new MongoId($hashtagId))),
                 'IsDeleted'=>array('!=' => 1),
                'IsBlockedWordExist'=>array('notIn' => array(1,2)),
                'IsAbused'=>array('notIn' => array(1,2)),
            ),
            'limit' => $pageLength,
            'offset' => $offset,
            'sort' => array('_id' => EMongoCriteria::SORT_DESC),
        );

        $posts = PostCollection::model()->findAll($array);
        $postsArray = array();
        foreach ($posts as $post) {
            
             $tagsFreeDescription= strip_tags(($post->Description));
             $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
             $postLength =  strlen($tagsFreeDescription);
            
            if($postLength>240){
                 $post->Description =  CommonUtility::truncateHtml($post->Description, 240); 
                 $post->Description = $post->Description.' <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i>';
            }
            
            $user = UserCollection::model()->getTinyUserCollection($post->UserId);
            array_push($postsArray, array($post, $user->DisplayName, "1"));
        }
        return $postsArray;
        }catch (Exception $ex) {
            Yii::log("PostCollection:getPostsForHashtag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
      /**
     * @author Vamsi Krishna
     * @param type $userId
     * @param type $postId
     * @return string
     */
    public function markPostAsFeatured($postId, $userId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;            
            $mongoModifier->addModifier('IsFeatured', 'set', 1);
            $mongoModifier->addModifier('FeaturedUserId', 'set', (int) $userId);
            $mongoModifier->addModifier('FeturedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $return = PostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("PostCollection:markPostAsFeatured::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author Moin Hussain
     * @param $hashtagId, $offset, $pageLength
     * @return 
     */
    public function getPostsCountForHashtag($hashtagId) {
        try{
        $array = array(
            'conditions' => array(
                'HashTags' => array('in' => array(new MongoId($hashtagId))),
                 'IsDeleted'=>array('!=' => 1),
                'IsBlockedWordExist'=>array('notIn' => array(1,2)),
                'IsAbused'=>array('notIn' => array(1,2)),
            ),
          
        );

        $posts = PostCollection::model()->findAll($array);
       return count($posts);
       } catch (Exception $ex) {
            Yii::log("PostCollection:getPostsCountForHashtag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

       /**
     * @author Vamsi Krishna
     * @param type $userId
     * @param type $postId
     * @return string
     */
    public function UnmarkPostAsFeatured($postId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;            
            $mongoModifier->addModifier('IsFeatured', 'set', (int)0);            
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $return = PostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("PostCollection:UnmarkPostAsFeatured::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author Sagar Pathapelli
     * This method is used to  update Post When Comment is Abused/Blocked/Released
     * @param type $postId
     * @param string $actionType
     * @return string
     */
    public function updatePostWhenCommentAbused($postId, $actionType){
        try { 
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
             if($actionType=='Abuse'){
                 $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 1);
             }elseif ($actionType=="Block") {
                $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 2);
             }elseif ($actionType="Release") {
                $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 0);
             }
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("PostCollection:updatePostWhenCommentAbused::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author Sagar Pathapelli
     * This method is used to Block/Release the post based on action type
     * @param type $postId
     * @param type $commentId
     * @param string $actionType (Block/Release)
     * @return string
     */
    public function blockOrReleaseComment($postId, $commentId, $actionType){
        try {
            $returnValue="failure";
             $mongoCriteria = new EMongoCriteria;
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $mongoCriteria->Comments->CommentId("==" ,new MongoID($commentId)); 
             $mongoModifier = new EMongoModifier;  
           
             if ($actionType=="Block") {
                $mongoModifier->addModifier('Comments.$.IsBlockedWordExist', 'set', 2);
             }elseif ($actionType="Release") {
                $mongoModifier->addModifier('Comments.$.IsBlockedWordExist', 'set', 0);
             }
           
             $returnValue=PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             if($returnValue){
                 
                $criteria = new EMongoCriteria;
                $criteria->addCond('_id', '==', new MongoId($postId));
                $criteria->Comments->IsBlockedWordExist("==" ,1); 
                $obj = PostCollection::model()->find($criteria);
                if (!is_object($obj)) {
                    
                    $criteria = new EMongoCriteria;
                    $criteria->addCond('_id', '==', new MongoId($postId));
                    $mongoModifier = new EMongoModifier;  
                    $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 0);
                    $returnValue=PostCollection::model()->updateAll($mongoModifier,$criteria);
                    if($returnValue){
                        $returnValue = 'PostReleased';
                    }
                }else{
                    $returnValue = 'CommentReleased';
                }
             }
             
             return $returnValue;
        } catch (Exception $ex) {
           Yii::log("PostCollection:blockOrReleaseComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in PostCollection->blockOrReleaseComment==".$ex->getMessage());
           return $returnValue;
        }
    }
    /**
     * @author Sagar
     * @Usage get comment object using post id and comment id
     * @param type $postId
     * @param type $commentId
     * @return type
     */
    public function getCommentById($postId, $commentId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            $criteria->Comments->CommentId("==" ,new MongoId($commentId)); 
            $criteria->setSelect(array('Comments.$'=>true));
            $postObj = PostCollection::model()->find($criteria);
            
            if (is_object($postObj)) {
                $returnValue = $postObj->Comments[0];
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("PostCollection:getCommentById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in PostCollection->getCommentById==".$ex->getMessage());
        }
    }
    public function getAllPostsHaveBlockedComments() {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('IsBlockedWordExistInComment', '==', 1);
            $postObj = PostCollection::model()->findAll($criteria);
            $returnValue = $postObj;
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("PostCollection:getAllPostsHaveBlockedComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getAllBlockedPosts() {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('IsBlockedWordExist', '==', 1);
            $postObj = PostCollection::model()->findAll($criteria);
            $returnValue = $postObj;
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("PostCollection:getAllBlockedPosts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function releasePostHaveBlockedComments($postId){
        try{
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoId($postId));
            $mongoModifier = new EMongoModifier;  
            $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 0);
            $returnValue=PostCollection::model()->updateAll($mongoModifier,$criteria);
            if($returnValue){
                $returnValue = 'success';
            }
            return $returnValue;
        }catch(Exception $ex){
            Yii::log("PostCollection:releasePostHaveBlockedComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    
    

    public function saveSharedList($postId, $userId, $shareType){
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if($shareType=='FbShare'){
                $mongoModifier->addModifier('FbShare', 'push', (int)$userId);
                $mongoCriteria->addCond('FbShare', '!=', (int)$userId);
            }elseif ($shareType="TwitterShare") {
                $mongoModifier->addModifier('TwitterShare', 'push', (int)$userId);
                $mongoCriteria->addCond('TwitterShare', '!=', (int)$userId);
            }
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            if(PostCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue = 'success';
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("PostCollection:saveSharedList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    /**
     * @author Karteek V
     * This is used to fetch the conversations count in the Post for analytics...
     * @return type
     */
    public function getConversationCount($segmentId=0){
        try{
            $criteria = new EMongoCriteria;
            if($segmentId!=0){
                $criteria->addCond('SegmentId', '==', $segmentId);
            }
            return PostCollection::model()->count($criteria);        
        } catch (Exception $ex) {
            Yii::log("PostCollection:getConversationCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in PostCollection->getConversationCount==".$ex->getMessage());
        }
    }
        
   public function GetPostsBetweenDates($startDate,$endDate,$postType,$IsFeatured,$Ispromoted,$NetworkId){
        try {       
             $returnValue='failure';
            $criteria = new EMongoCriteria;
            $startDate=date('Y-m-d',strtotime($startDate));
            $endDate=date('Y-m-d',strtotime($endDate));
            $endDate =trim($endDate)." 23:59:59";
            $startDate =trim($startDate)." 00:00:00";

           $startDate=date('Y-m-d H:i:s',strtotime($startDate));
           $endDate=date('Y-m-d H:i:s',strtotime($endDate));
            
            $criteria->addCond('NetworkId', '==', (int)$NetworkId);
            if($IsFeatured== '0' && $Ispromoted=='0'){
                $criteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
                if($postType!=0){
                     $criteria->addCond('Type', '==', (int)$postType);
                }
            }
            if($IsFeatured !='0'){
                $criteria->addCond('IsFeatured', '==', (int)$IsFeatured);
                $criteria->FeaturedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
                
            }
            if($Ispromoted!='0'){
                $criteria->addCond('IsPromoted', '==', (int)$IsFeatured);
                $criteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
            }
            $allposts = PostCollection::model()->findAll($criteria);  
            
            if(is_array($allposts)){
                 $returnValue=count($allposts);
            }

            return $returnValue;

        } catch (Exception $ex) {
           Yii::log("PostCollection:GetPostsBetweenDates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
     public function getPostIdByMigratedPostId($PostId) {
        try {
            $postObj = PostCollection::model()->findByAttributes(array('MigratedPostId' => $PostId));
            return $postObj;
        } catch (Exception $ex) {
            Yii::log("PostCollection:getPostIdByMigratedPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in PostCollection->getPostIdByMigratedPostId==".$ex->getMessage());
        }
    }
      public function GetAllPosts(){
        try {       
            $returnValue='failure';
            
            
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('CreatedOn'=>true));
            $allposts = PostCollection::model()->findAll($criteria); 
            
            return $allposts;

        } catch (Exception $ex) {
           Yii::log("PostCollection:GetAllPosts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
      public function UpdateAllPostsCreatedDate($postId,$createdDate){
        try {       
           $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoId($postId));
            $mongoModifier = new EMongoModifier;  
            $mongoModifier->addModifier('CreatedDate', 'set', $createdDate);
            $returnValue=PostCollection::model()->updateAll($mongoModifier,$criteria);

        } catch (Exception $ex) {
           Yii::log("PostCollection:UpdateAllPostsCreatedDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
     
     
      public function getPostHashtagsById($postIdArray) {
        try {
            
            
            $returnValue = 'failure';
            $postsArray=array();
          
            for($i=0;$i<sizeof($postIdArray);$i++){
               
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postIdArray[$i]));
            $postObj = PostCollection::model()->findAll($criteria);
  if (sizeof($postObj) > 0) {
         
        foreach ($postObj as $post) {
            
             $tagsFreeDescription= strip_tags(($post->Description));
             $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
             $postLength =  strlen($tagsFreeDescription);
            
            if($postLength>240){
                 $post->Description =  CommonUtility::truncateHtml($post->Description, 240); 
                 $post->Description = $post->Description.' <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i>';
            }
            
            $user = UserCollection::model()->getTinyUserCollection($post->UserId);
            array_push($postsArray, array($post, $user->DisplayName, "1"));
        }
  }
        }
        
        return $postsArray;
            
            
            
            
            
        } catch (Exception $ex) {
            Yii::log("PostCollection:getPostHashtagsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     /**
     * @author Swathi
     * This is used to fetch the posts of type 1,2 and 3 except anonymous type(Post Type=4) of posts
     * @return type
     */
     public function getAllStreamTypePostsByUserId($userId){
        try {       
            $returnValue='failure';
            
            
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('HashTags' => true));
            $criteria->addCond('Type', '!=', (int) 4);
            $criteria->addCond('UserId', '==', (int) $userId);
            $criteria->addCond('IsDeleted','!=',(int)1);
            $criteria->addCond('IsBlockedWordExist','notin',array(1, 2));
            $criteria->addCond('IsAbused','notin',array(1, 2));
            $allposts = PostCollection::model()->findAll($criteria); 
            
            return $allposts;

        } catch (Exception $ex) {
           Yii::log("PostCollection:getAllStreamTypePostsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
     
           public function getActionUsers($id,$actionType){
         try{
             $criteria = new EMongoCriteria;
             if($actionType == "Followers"){
                  $criteria->setSelect(array("Followers" => true)); 
             }else{
                  $criteria->setSelect(array("Love" => true));
             }
            
              $criteria->addCond('_id', '==', new MongoId($id));
              $post = PostCollection::model()->find($criteria);
             
              if($actionType == "Followers"){
                  $actionUsers = $post->Followers; 
             }else{
                  $actionUsers = $post->Love;
             }
            return $actionUsers;
         } catch (Exception $ex) {
             Yii::log("PostCollection:getActionUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             error_log("Exception Occurred in PostCollection->getActionUsers==".$ex->getMessage());
         }
     }
     public function commentManagement($commentId, $postId, $actionType, $userId=""){
        try { 
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $mongoCriteria->Comments->CommentId("==" ,new MongoID($commentId)); 
             
             $mongoModifier = new EMongoModifier;           
             if($actionType=='AbuseComment'){
                 $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 1);
                 $mongoModifier->addModifier('Comments.$.AbusedUserId', 'set', (int)$userId);
                 $mongoModifier->addModifier('AbusedOn','set',new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
                 $mongoModifier->addModifier('IsCommentAbused', 'set', 1);
              }elseif ($actionType=="BlockAbusedComment") {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 2);
             }elseif ($actionType=="ReleaseAbusedComment") {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 0);
             }
             elseif ($actionType=="AbuseCommentForSuspendedUser") {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 3);
             }
             $returnValue=PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             if($actionType=='AbuseComment'){
                 $returnValue = 'CommentAbused';
             }elseif($returnValue){
                $criteria = new EMongoCriteria;
                $criteria->addCond('_id', '==', new MongoId($postId));
                $criteria->Comments->IsAbused("==" ,1); 
                $obj = PostCollection::model()->find($criteria);
                if (!is_object($obj)) {//If posts have no abused comments
                    $criteria = new EMongoCriteria;
                    $criteria->addCond('_id', '==', new MongoId($postId));
                    $mongoModifier = new EMongoModifier;  
                    $mongoModifier->addModifier('IsCommentAbused', 'set', 0);
                    $returnValue=PostCollection::model()->updateAll($mongoModifier,$criteria);
                    if($returnValue){
                        $returnValue = 'PostReleased';
                    }
                }else{
                    $returnValue = 'CommentReleased';
                }
             }
             return $returnValue;

        } catch (Exception $ex) {
           Yii::log("PostCollection:commentManagement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     
      /**
     * @author Reddy #1500
     * This is used to update SegmentId and NetworkId By UserId (details), when user change segment then, we need to change his posts. 
     * @return type
     */
    public function updateSegmentIdNetworkIdByUserId($userId, $networkId, $segmentId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $criteria->addCond('UserId', '==', (int) $userId);
            $mongoModifier->addModifier('SegmentId', 'set', (int)$segmentId);
            $mongoModifier->addModifier('NetworkId', 'set', (int)$networkId);
            $returnValue = PostCollection::model()->updateAll($mongoModifier, $criteria);
        } catch (Exception $ex) {
            Yii::log("PostCollection:updateSegmentIdNetworkIdByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }


    
     public function markThisPostForAwayDigest($postId, $isUseForDigest){
        try { 
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           

             $mongoModifier->addModifier('IsUseForDigest', 'set', $isUseForDigest);
            
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=PostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("PostCollection:markThisPostForAwayDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
     /**
     * This method is used to update the stream with IsDeleted=2 
     * All the suspended user activities will be deleted 
     * @param type $userId
     */
    
 public function updatePostsForSuspendedUser($userId,$type){
     try {
         $mongoCriteria = new EMongoCriteria;
         $mongoModifier = new EMongoModifier;
          if($type=="Delete"){
           $mongoModifier->addModifier('IsDeleted', 'set', (int)2);   
           $mongoCriteria->addCond('IsDeleted', '!=', (int)1);
         }else if($type=="Release"){
           $mongoModifier->addModifier('IsDeleted', 'set', (int)0);   
           $mongoCriteria->addCond('IsDeleted', '==', (int)2);
         }
         
         $mongoCriteria->addCond('UserId', '==', (int)$userId);
         
         PostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
     } catch (Exception $ex) {
         Yii::log("PostCollection:updatePostsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
}
