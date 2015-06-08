<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CuratedNewsCollection extends EMongoDocument{
     public $_id;
     public $PostId=0;
     public $Title='';
     public $ImageUrl='';
     public $HtmlFragment='';
     public $Description='';
     public $PublicationDate='';
     public $PublisherSource='';
     public $PublisherSourceUrl='';
     public $Editorial='';
     public $Released=0;
     public $CategoryType=8;
     public $TopicId=0;
     public $TopicName='';
     public $UserId=0;
     public $NetworkId=0;
     public $Alignment='';
     public $PublicationTime='';
     public $Followers=array();
     public $Mentions=array();
     public $Comments=array();
     public $Resource=array();
     public $Love=array();
     public $HashTags=array();
     public $Invite=array();
    public $Type=11;
    public $Priority;
    public $CreatedOn;
    public $DisableComments = 0;
    public $IsAbused = 0; //0 - Default/Release, 1 - Abused, 2 - Blocked
    public $AbusedUserId;
    public $IsDeleted = 0;
    public $IsPromoted = 0;
    public $PromotedUserId;
    public $AbusedOn;
    public $IsBlockedWordExist = 0;
    public $IsFeatured = 0;
    public $FeaturedUserId;
    public $FeaturedOn;
    public $IsBlockedWordExistInComment = 0;
    public $IsWebSnippetExist = 0;
    public $WebUrls;
    public $Division = 0;
    public $District = 0;
    public $Region = 0;
    public $Store = 0;
    public $FbShare = array();
    public $TwitterShare = array();
    public $TopicImage='';
    public $Subject='';
    public $IsNotifiable=0;
    public $CreatedDate;
    public $Curable=1;
     public $IsVideo=0;
     public $IsCommentAbused=0;
    public $SegmentId=0;
    public $Language='en';
    public $saveItForLaterUserIds=array();

      public $IsUseForDigest=0;
    public function getCollectionName() {
        return 'CuratedNewsCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC
                ),
            ),
            'index_Released' => array(
                'key' => array(
                    'Released' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_TopicId' => array(
                'key' => array(
                    'TopicId' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_IsAbused' => array(
                'key' => array(
                    'IsAbused' => EMongoCriteria::SORT_ASC
                ),
            ),
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
            'Subject'=>'Subject',
            'CategoryType'=>'CategoryType',
            'DisableComments'=>'DisableComments',
            'IsAbused'=>'IsAbused',
            'AbusedUserId'=>'AbusedUserId',
            'IsDeleted'=>'IsDeleted',
            'IsPromoted'=>'IsPromoted',
            'PromotedUserId'=>'PromotedUserId',
            'NetworkId'=>'NetworkId',
            'AbusedOn'=>'AbusedOn',
            'IsBlockedWordExist'=>'IsBlockedWordExist',
            'IsFeatured'=>'IsFeatured',
            'FeaturedUserId'=>'FeaturedUserId',
            'FeaturedOn'=>'FeaturedOn',
            'IsBlockedWordExistInComment'=>'IsBlockedWordExistInComment',
            'IsWebSnippetExist'=>'IsWebSnippetExist',
            'WebUrls'=>'WebUrls',
            'Division'=>'Division',
            'District'=>'District',
            'Region'=>'Region',
            'Store'=>'Store',
            'FbShare'=>'FbShare',
            'TwitterShare'=>'TwitterShare',
            'PostId'=>'PostId',
            'Title' => 'Title',
            'ImageUrl' => 'ImageUrl',
            'HtmlFragment' => 'HtmlFragment',
            'PublicationDate'=>'PublicationDate',
            'PublisherSource'=>'PublisherSource',
            'PublisherSourceUrl'=>'PublisherSourceUrl',
            'Editorial'=>'Editorial',
            'Released'=>'Released',
            'TopicId'=>'TopicId',
            'TopicName'=>'TopicName',
            'Alignment'=>'Alignment',
            'PublicationTime'=>'PublicationTime',
            'TopicImage'=>'TopicImage',
            'IsNotifiable'=>'IsNotifiable',
            'CreatedDate'=>'CreatedDate',
            'Curable'=>'Curable',
            'IsCommentAbused'=>'IsCommentAbused',
             'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
            'saveItForLaterUserIds'=>'saveItForLaterUserIds',
            'IsUseForDigest'=>'IsUseForDigest'
          );
    }
    
    public function getSearchCriteriaForCuratedPosts($TopicId,$curable)
    {
         try {          
           $array = array(
            'conditions' => array(
                'TopicId' => array('==' => (Int)$TopicId),
                'Curable'=>array('==' => (Int)$curable)
            ),
             
            'limit' => 1,
            'sort' => array('PublicationTime' => EMongoCriteria::SORT_DESC),
           );
        $posts = CuratedNewsCollection::model()->find($array);
        return $posts;
      } catch (Exception $ex) {
         Yii::log("CuratedNewsCollection:getSearchCriteriaForCuratedPosts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         return FALSE;
      }
    }
     public function getPostById($postId)
    {
         $posts='';
         try {          
           $array = array(
            'conditions' => array(
                '_id' => array('==' => new MongoId($postId)),
            ),
            
           );
        $posts = CuratedNewsCollection::model()->find($array);
        return $posts;
      } catch (Exception $ex) {
         Yii::log("CuratedNewsCollection:getPostById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         return FALSE;
      }
    }
    
    public function saveEditorial($postId,$text,$hashTagIdArray)
    {
        $returnValue=440;
        try
        {
        $mongoCriteria=new EMongoCriteria();
        $mongoModifier=new EMongoModifier();
        $mongoCriteria->addCond('_id', '==', new MongoId($postId));
        $mongoModifier->addModifier('Editorial', 'set',$text);
        if(count($hashTagIdArray)>0){
        $mongoModifier->addModifier('HashTags', 'set',$hashTagIdArray);        
        }
        if(CuratedNewsCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
        $returnValue = 200;
        }
        }  catch (Exception $ex)
        {
            Yii::log("CuratedNewsCollection:saveEditorial::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
    public function manageCuratedPost($postId,$release,$userId=0)
    {
        $returnValue=440;
        try
        {
        $date=date('Y-m-d H:i:s');
        $mongoCriteria=new EMongoCriteria();
        $mongoModifier=new EMongoModifier();
        $mongoCriteria->addCond('_id', '==', new MongoId($postId));
        $mongoModifier->addModifier('Released', 'set',(Int)$release);
        $mongoModifier->addModifier('CreatedOn', 'set',new MongoDate(strtotime($date)));
        $mongoModifier->addModifier('UserId', 'set',(Int)$userId);   
        if($release==1)
        {
        $mongoModifier->addModifier('Followers', 'push',(Int)$userId);    
        }
        if($release==2)
        {
        //$mongoModifier->addModifier('Followers', 'push',(Int)$userId);    
        }
        if(CuratedNewsCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
        $returnValue = 200;
        }
        return $returnValue;
        }  catch (Exception $ex)
        {
            Yii::log("CuratedNewsCollection:manageCuratedPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
     public function saveitforlaterPost($postId, $userId){
        try {          
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
              $mongoModifier->addModifier('saveItForLaterUserIds', 'push', (int)$userId);
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=CuratedNewsCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("CuratedNewsCollection:saveitforlaterPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * 
     * @param type $postId it's mongo Id
     * @return type
     */
    public function getNewsObjectById($newsId) {
        try {
         
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($newsId));
              $criteria->addCond('IsDeleted', '!=', 1);
            $postObj = CuratedNewsCollection::model()->find($criteria);
            if (is_object($postObj)) {
                $returnValue = $postObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:getNewsObjectById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function GetEditorial($postId)
    {
        try {
         
            $returnValue = 440;
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = CuratedNewsCollection::model()->find($criteria);
            if (is_object($postObj)) {
                $returnValue = $postObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:GetEditorial::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }

    /**
     * @author karteek v
     * @param type $newsId
     * @return type
     */
    
    public function getRecentCommentsforNews($newsId){
        try{
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($newsId));
            $newsobj = CuratedNewsCollection::model()->find($criteria);
            if (isset($newsobj->Comments)) {
                $returnValue =$newsobj->Comments;
                }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:getRecentCommentsforNews::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CuratedNewsCollection->getRecentCommentsforNews==".$ex->getMessage());
        }
    }
    /**
     * @author karteek v
     * @param type $newsId
     * @param type $userId
     * @param type $actionType
     * @return string
     */
    public function followOrUnfollowNewsPost($newsId, $userId, $actionType) {
        try {
            $returnValue = 'failure';
            // throw new Exception('Unable to follow or unfollow');
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow') {
                $mongoModifier->addModifier('Followers', 'push', (int)$userId);
                $mongoCriteria->addCond('Followers', '!=', (int)$userId);
            } else if($actionType == 'UnFollow'){
                $mongoModifier->addModifier('Followers', 'pop', (int)$userId);
            }

            $mongoCriteria->addCond('_id', '==', new MongoId($newsId));
            if(CuratedNewsCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                if ($actionType == 'Follow') {
                    UserStreamCollection::model()->activeOrInactiveOldNewsObjects(array(new MongoID($newsId)), 0);
                }
                $returnValue = 'success';
            }
            
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:followOrUnfollowNewsPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    /**
     * @author Karteek.V
     * @param type $newsId
     * @param type $userId
     * @return boolean
     */
    public function loveNormalPost($newsId,$userId){
      try {          
           $returnValue=FALSE;
           //throw new Exception('Unable to save love');
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;           
           $mongoModifier->addModifier('Love', 'push', (int)$userId);
           $mongoCriteria->addCond('_id', '==', new MongoId($newsId));
           $mongoCriteria->addCond('Love', '!=', (int)$userId);         
           if(CuratedNewsCollection::model()->updateAll($mongoModifier,$mongoCriteria)){
               UserStreamCollection::model()->activeOrInactiveOldNewsObjects(array(new MongoID($newsId)), 0);
               $returnValue=TRUE;
           }
           
           return $returnValue;
      } catch (Exception $ex) {
         Yii::log("CuratedNewsCollection:loveNormalPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in CuratedNewsCollection->loveNormalPost==".$ex->getMessage());
         return FALSE;
      }
      
    }
    /**
     * @author Karteek.v
     * @param type $postId
     * @param type $comments
     * @return boolean
     */
  public function saveComment($postId,$comments){
      try {
           $returnValue = FALSE;
          //throw new Exception('Division by zero.');
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;  
           $mongoModifier->addModifier('Comments', 'push', $comments);
           $mongoCriteria->addCond('_id', '==', new MongoId($postId));
           if(CuratedNewsCollection::model()->updateAll($mongoModifier,$mongoCriteria)){
               UserStreamCollection::model()->activeOrInactiveOldNewsObjects(array(new MongoID($postId)), 0);
               $returnValue = TRUE;
           }else{
           }
             return $returnValue;
      } catch (Exception $ex) {         
        Yii::log("CuratedNewsCollection:saveComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        return FALSE;
      }
     
    }
    /**
     * @author Karteek.v
     * @param type $UserId
     * @param type $PostId
     * @param type $InviteText
     * @param type $Mentions
     * @return string
     */
         public function saveInvites($UserId, $PostId, $InviteText, $Mentions) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $inviteArray = array();
            array_push($inviteArray, (int)$UserId);
            array_push($inviteArray, array_unique($Mentions));
            array_push($inviteArray, $InviteText);
            $mongoModifier->addModifier('Invite', 'push', $inviteArray);
            $mongoCriteria->addCond('_id', '==', new MongoID($PostId));
            if(CuratedNewsCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                UserStreamCollection::model()->activeOrInactiveOldNewsObjects(array(new MongoID($PostId)), 0);
            }
            return 'success';
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:saveInvites::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

    }
    
    /**
     * @author Karteek.V
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
             $returnValue=  CuratedNewsCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("CuratedNewsCollection:updatePostWhenCommentAbused::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getPostObjectFollowers($postId){
             
            $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Followers'=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = CuratedNewsCollection::model()->find($criteria);
            if (isset($objFollowers->Followers)) {
                $returnValue =$objFollowers->Followers;
                          }
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:getPostObjectFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
       
        }
        
      public function getObjectSaveItForLaterUsers($postId){
             
            $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('saveItForLaterUserIds'=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = CuratedNewsCollection::model()->find($criteria);
            if (isset($objFollowers->saveItForLaterUserIds)) {
                $returnValue =$objFollowers->saveItForLaterUserIds;
                          }
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:getObjectSaveItForLaterUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
       
        }   
        /**
         * @author Karteek.V
         * @param type $postId
         * @return type
         */
        public function getPostCommentsByPostId($postId){
    try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
          //  $criteria->setSelect(array('Comments='=>true));
            $criteria->addCond('_id', '==', new MongoId($postId));
            $postObj = CuratedNewsCollection::model()->find($criteria);   
            if (isset($postObj->Comments)) {
                $returnValue =$postObj->Comments;
                }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:getPostCommentsByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }  
  }  
  /**
   * @author karteek.v
   * @param type $postId
   * @return string
   */
  public function getInvitedUsersForPost($postId) {

        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Invite' => true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = CuratedNewsCollection::model()->find($criteria);
            if (isset($objFollowers->Invite)) {
                $returnValue = $objFollowers->Invite;
            }
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:getInvitedUsersForPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        return $returnValue;
    }

    public function getPostByIdConsole($postId)
    {
         $posts='';
         try {          
           $array = array(
            'conditions' => array(
                'PostId' => array('==' => (float)($postId)),
            ),
            
           );
        $posts = CuratedNewsCollection::model()->find($array);
        return $posts;
      } catch (Exception $ex) {
         Yii::log("CuratedNewsCollection:getPostByIdConsole::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         return FALSE;
      }
    }
   public function markPostAsFeatured($postId, $userId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;            
            $mongoModifier->addModifier('IsFeatured', 'set', 1);
            $mongoModifier->addModifier('FeaturedUserId', 'set', (int) $userId);
            $mongoModifier->addModifier('FeturedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $return = CuratedNewsCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:markPostAsFeatured::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function UnmarkPostAsFeatured($postId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;            
            $mongoModifier->addModifier('IsFeatured', 'set', (int)0);            
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $return = CuratedNewsCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:UnmarkPostAsFeatured::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function NotifyStreamOfPostedNews($IsNotifiable,$postId)
    {
       try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;            
            $mongoModifier->addModifier('IsNotifiable', 'set', (int)$IsNotifiable);   
            $mongoModifier->addModifier('CreatedOn', 'set',new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            if(CuratedNewsCollection::model()->updateAll($mongoModifier, $mongoCriteria))
           return 1;
            else
           return; 0;
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:NotifyStreamOfPostedNews::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        } 
    }
    
    /**
     * @author karteek.v
     * @param type $postIdsArray
     * @return array
     */
    public function getPreparedDataByNewsId($postIdsArray) {
        try {
            $postIdsArray = array_unique($postIdsArray);
            $returnValue = array();// only one time it will be flushed
            $i =0;
            foreach ($postIdsArray as $rw) {
                
                $returnArr = array(); // each and every iteration it will be flushed
                $criteria = new EMongoCriteria;
                $criteria->addCond('_id', '==', new MongoID($rw));
                $postObj = CuratedNewsCollection::model()->find($criteria);
                if (is_object($postObj)) {

                        foreach ($postObj->_id as $rw) {
                            $returnArr['PostId'] = $rw;
                        }
                        $returnArr['LoveUserId'] = $postObj->UserId;
                        $returnArr['Description'] = $postObj->Description;
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
//                        $returnArr['FollowCount'] = count($postObj->Followers);
                        array_push($returnValue, $returnArr);
//                    }
                }
            }// updating stream collection
            $this->updateStreamPostCountsFromNodeRequest($returnValue);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:getPreparedDataByNewsId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:updateStreamPostCountsFromNodeRequest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CuratedNewsCollection->updateStreamPostCountsFromNodeRequest==".$ex->getMessage());
        }
    }
    public function PullBackNews($IsAbused,$postId)
    {
       try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;            
            $mongoModifier->addModifier('IsAbused', 'set', (int)$IsAbused);   
            $mongoModifier->addModifier('AbusedOn', 'set',new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            if(CuratedNewsCollection::model()->updateAll($mongoModifier, $mongoCriteria))
           return 1;
            else
           return; 0;
        } catch (Exception $ex) {
            Yii::log("CuratedNewsCollection:PullBackNews::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        } 
    }
  public function getNewsForSearch($searchText, $offset, $pageLength) {
   try {
       
         $array = array(
            'conditions' => array(
//                'Title' => array('eq' => new MongoRegex('/' . $searchText . '.*/i')),
                 'Title' => array('or' => new MongoRegex('/' . $searchText . '.*/i')),
                 'Description' => array('or' => new MongoRegex('/' . $searchText . '.*/i')),
                'Comments.CommentText' => array('or' => new MongoRegex('/' . $searchText . '.*/i')),
                'IsDeleted'=>array('!=' => (int)1),
                'Released'=>array('==' => (int)1),
               // 'IsBlockedWordExist'=>array('notIn' => array(1,2)),
               // 'IsAbused'=>array('notIn' => array(1,2)),
            ),
             
            'limit' => $pageLength,
            'offset' => $offset,
            'sort' => array('_id' => EMongoCriteria::SORT_DESC),
        );
        
        
        $posts = CuratedNewsCollection::model()->findAll($array);
          
        $postsArray = array();
        foreach ($posts as $post) {
            
             $tagsFreeDescription= strip_tags(($post->Description));
             $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
             $postLength =  strlen($tagsFreeDescription);
            
            if($postLength>240){
                 $post->Description =  CommonUtility::truncateHtml($post->Description, 240,'Read more',true,true,' <i class="fa moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i>'); 
                 $post->Description = $post->Description;
            }
            
            if(isset($post->UserId)){
            $user = UserCollection::model()->getTinyUserCollection($post->UserId);
            array_push($postsArray, array($post, $user->DisplayName, "1"));
            }
        }
  }catch (Exception $ex) {
      Yii::log("CuratedNewsCollection:getNewsForSearch::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $postsArray;
        }
        
        return $postsArray;
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
             $returnValue=CuratedNewsCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             if($actionType=='AbuseComment'){
                 $returnValue = 'CommentAbused';
             }elseif($returnValue){
                $criteria = new EMongoCriteria;
                $criteria->addCond('_id', '==', new MongoId($postId));
                $criteria->Comments->IsAbused("==" ,1); 
                $obj = CuratedNewsCollection::model()->find($criteria);
                if (!is_object($obj)) {//If posts have no abused comments
                    $criteria = new EMongoCriteria;
                    $criteria->addCond('_id', '==', new MongoId($postId));
                    $mongoModifier = new EMongoModifier;  
                    $mongoModifier->addModifier('IsCommentAbused', 'set', 0);
                    $returnValue=CuratedNewsCollection::model()->updateAll($mongoModifier,$criteria);
                    if($returnValue){
                        $returnValue = 'PostReleased';
                    }
                }else{
                    $returnValue = 'CommentReleased';
                }
             }
             return $returnValue;

        } catch (Exception $ex) {
           Yii::log("CuratedNewsCollection:commentManagement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
       public function markThisPostForAwayDigest($postId, $isUseForDigest){
        try { 
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           

             $mongoModifier->addModifier('IsUseForDigest', 'set', $isUseForDigest);
            
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=CuratedNewsCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("CuratedNewsCollection:markThisPostForAwayDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}


