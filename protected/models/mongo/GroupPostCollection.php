<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GroupPostCollection extends EMongoDocument {
    public $_id;
    public $Type;
    public $UserId;
    public $GroupId;
    public $Priority;
    public $CreatedOn;
     public $CreatedDate;
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
    public $Status;
    public $IsPublic;
    public $DisableComments = 0;
    public $IsAbused = 0; //0 - Default/Release, 1 - Abused, 2 - Blocked
    public $AbusedUserId;
    public $IsDeleted = 0;
    public $IsPromoted = 0;
    public $PromotedUserId;
    public $AbusedOn;
    public $OptionOneCount;
    public $OptionTwoCount;
    public $OptionThreeCount;
    public $OptionFourCount;
    public $OptionOne;
    public $OptionTwo;
    public $OptionThree;
    public $OptionFour;
    public $SurveyTaken;
    public $ExpiryDate;
    public $IsFeatured=0;
    public $FeaturedUserId;
    public $FeaturedOn;
    public $StartTime;
    public $EndTime;
    public $IsBlockedWordExist=0;
    public $IsBlockedWordExistInComment=0;
    public $IsWebSnippetExist = 0;
    public $WebUrls;
    public $Division=0;
    public $District=0;
    public $Region=0;
    public $Store=0;
    public $Title;
    public $SubGroupId;
    public $MigratedPostId='';
    public $PromotedDate;
    public $IsAnonymous = 0;
    public $IsCommentAbused=0;
   public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';
  public $saveItForLaterUserIds=array();
  public $Miscellaneous = 0;
    public function getCollectionName() {
        return 'GroupPostCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('EventAttendes', 'unique', 'attributeName' => 'EventAttendes', 'caseSensitive' => 'false'),
        );
    }
    public function indexes() {
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            ),
            'index_GroupId' => array(
                'key' => array(
                    'GroupId' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            ),
        );
    }
    /**
     * updated by suresh reddy
     * add expirty date at atribute.
     */
    public function attributeNames() {
        return array(
            '_id' => '_id',
            'Type' => 'Type',
            'UserId' => 'UserId',
            'GroupId' => 'GroupId',
            'Priority' => 'Priority',
            'CreatedOn' => 'CreatedOn',
            'CreatedDate' => 'CreatedDate',
            'Description' => 'Description',
            'Followers' => 'Followers',
            'Mentions' => 'Mentions',
            'Comments' => 'Comments',
            'Love' => 'Love',
            'Resource' => 'Resource',
            'HashTags' => 'HashTags',
            'Invite' => 'Invite',
            'Share' => 'Share',
            'StartDate' => 'StartDate',
            'EndDate' => 'EndDate',
            'Location' => 'Location',
            'EventAttendes' => 'EventAttendes',
            'Status'=>'Status',
            'IsPublic'=>'IsPublic',
            'DisableComments'=>'DisableComments',
            'IsAbused'=>'IsAbused',
            'AbusedUserId'=>'AbusedUserId',
            'IsDeleted'=>'IsDeleted',
            'IsPromoted'=>'IsPromoted',
            'PromotedUserId'=>'PromotedUserId',
            'AbusedOn'=>'AbusedOn',
            'OptionOneCount'=>'OptionOneCount',
            'OptionTwoCount'=>'OptionTwoCount',
            'OptionThreeCount'=>'OptionThreeCount',
            'OptionFourCount'=>'OptionFourCount',
            'SurveyTaken'=>'SurveyTaken',
            'OptionOne'=>'OptionOne',
            'OptionTwo'=>'OptionTwo',
            'OptionThree'=>'OptionThree',
            'OptionFour'=>'OptionFour',
            'StartTime'=>'StartTime',
            'EndTime'=>'EndTime',
            'ExpiryDate'=>'ExpiryDate',
            'IsFeatured'=>'IsFeatured',
            'FeaturedUserId'=>'FeaturedUserId',
            'FeaturedOn'=>'FeaturedOn',
            'Status' => 'Status',
            'IsPublic' => 'IsPublic',
            'DisableComments' => 'DisableComments',
            'IsAbused' => 'IsAbused',
            'AbusedUserId' => 'AbusedUserId',
            'IsDeleted' => 'IsDeleted',
            'IsPromoted' => 'IsPromoted',
            'PromotedUserId' => 'PromotedUserId',
            'AbusedOn' => 'AbusedOn',
            'IsBlockedWordExist' => 'IsBlockedWordExist',
            'IsBlockedWordExistInComment'=>'IsBlockedWordExistInComment',
            'IsWebSnippetExist'=>'IsWebSnippetExist',
             'WebUrls'=>'WebUrls',
            'Division'=>'Division',
            'District'=>'District',
            'Region'=>'Region',
             'Store'=>'Store',
            'Title'=>'Title',
            'SubGroupId'=>'SubGroupId',
            'MigratedPostId'=>'MigratedPostId',
             'PromotedDate'=>'PromotedDate',
            'IsCommentAbused'=>'IsCommentAbused',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
            'saveItForLaterUserIds'=>'saveItForLaterUserIds',
            'Miscellaneous' => 'Miscellaneous'

        );
    }

    public function updatePostWithArtifacts($postId, $resourceArray) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Resource', 'push', $resourceArray);
            $mongoCriteria->addCond('_id', '==', new MongoID($postId));
            GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:updatePostWithArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getGroupPostById($postId,$checkisdeleted=0) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            if($checkisdeleted==1){
            $criteria->addCond('IsDeleted', '!=', 1);
            }
            $postObj = GroupPostCollection::model()->find($criteria);
            
            if (is_object($postObj)) {
                $returnValue = $postObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getGroupPostById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author suresh reddy
     * @param $postId postid of curbside post
     * @comments comments of post  which done by user
     */
    public function saveComment($postId, $comments) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Comments', 'push', $comments);
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:saveComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Vamsi Krishna
     * @param type $postId
     * @param type $userId
     * @return string
     */
    public function loveGroupPost($postId, $userId) {
        try {            
            $returnValue=FALSE;
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Love', 'push', (int) $userId);
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $mongoCriteria->addCond('Love', '!=', (int) $userId);
            if(GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue=TRUE;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:loveGroupPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return FALSE;
        }
    }

    /**
     * @autho surehsh reddy & Vamsi 
     * 
     */
    public function followOrUnfollowPost($postId, $userId, $actionType) {
        try {
            $returnValue = 'failure';
           // throw new Exception('Unable to save love');
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow') {
                $mongoModifier->addModifier('Followers', 'push', (int) $userId);
                $mongoCriteria->addCond('Followers', '!=', (int) $userId);
            } else if ($actionType == 'UnFollow') {
                $mongoModifier->addModifier('Followers', 'pop', (int) $userId);
            }

            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            if(GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
               $returnValue = 'success'; 
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:followOrUnfollowPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             return $returnValue;
        }
    }

    /**
     * this method is used for save invites for group psot
     * @autho suresh reddy
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
            array_push($inviteArray, (int) $UserId);
            array_push($inviteArray, array_unique($Mentions));
            array_push($inviteArray, $InviteText);
            $mongoModifier->addModifier('Invite', 'push', $inviteArray);
            $mongoCriteria->addCond('_id', '==', new MongoID($PostId));
            $return = GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:saveInvites::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Vamsi Krishna
     * @Description this method is to get the comments for post
     * @param type $postId
     * @return success=> array failure=>String
     */
    public function getPostCommentsByPostId($postId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            //    $criteria->setSelect(array('Comments='=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = GroupPostCollection::model()->find($criteria);
            if (isset($postObj->Comments)) {
                $returnValue = $postObj->Comments;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getPostCommentsByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getUserRecentGroupActivity($groupId, $previousLastLogin) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('CreatedOn', '>', new MongoDate($previousLastLogin));
            $criteria->addCond('GroupId', '==', new MongoID($groupId));
            $result = GroupPostCollection::model()->find($criteria);
            if (is_object($result)) {
                $returnValue = 'success';
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getUserRecentGroupActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar Pathapelli
     * @param type $postId
     * @return string
     */
    public function deletePost($postId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('IsDeleted', 'set', 1);
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $returnValue = GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:deletePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            $returnValue = 'failure';
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
             $returnValue=GroupPostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:abusePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
    public function promotePost($postId, $userId, $promoteDate) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('IsPromoted', 'set', 1);
            $mongoModifier->addModifier('PromotedUserId', 'set', (int) $userId);
            $mongoModifier->addModifier('PromotedDate', 'set', new MongoDate(strtotime($promoteDate)));
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $returnValue = GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:promotePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
      public function saveitforlaterPost($postId, $userId){
        try {          
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
              $mongoModifier->addModifier('saveItForLaterUserIds', 'push', (int)$userId);
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=GroupPostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("GroupPostCollection:saveitforlaterPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function submitSurvey($UserId, $PostId, $Option) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $surveyArray = array();
            $surveyArray['UserId'] = (int) $UserId;
            $surveyArray['UserOption'] = $Option;
            $mongoModifier->addModifier('SurveyTaken', 'push', $surveyArray);
            if ($Option == 'OptionOne') {
                $mongoModifier->addModifier('OptionOneCount', 'inc', 1);
            } elseif ($Option == 'OptionTwo') {
                $mongoModifier->addModifier('OptionTwoCount', 'inc', 1);
            } elseif ($Option == 'OptionThree') {
                $mongoModifier->addModifier('OptionThreeCount', 'inc', 1);
            } elseif ($Option == 'OptionFour') {
                $mongoModifier->addModifier('OptionFourCount', 'inc', 1);
            }
            $mongoCriteria->addCond('_id', '==', new MongoID($PostId));
            if(GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                 return "success";
            }else{
               return 'failure'; 
            }
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:submitSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
    }

    /**
     * updated by suresh reddy, return type in excepiton area
     * @param type $postId
     * @param type $userId
     * @param type $actionType
     * @return string
     */
   
    public function saveOrRemoveEventAttende($postId, $userId, $actionType) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Attend') {
                $mongoModifier->addModifier('EventAttendes', 'push', $userId);
                $mongoCriteria->addCond('EventAttendes', '!=', (int) $userId);
            } else {
                $mongoCriteria->addCond('EventAttendes', '==', (int) $userId);
                $mongoModifier->addModifier('EventAttendes', 'pop', $userId);
            }
            $mongoCriteria->addCond('_id', '==', new MongoID($postId));
            $return = GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:saveOrRemoveEventAttende::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             return 'failure';
        }
    }

    /**
     * @author suresh reddy
     * @param type $postId
     * @return type
     */
    public function getGroupPostObjectFollowers($postId) {

        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Followers' => true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = GroupPostCollection::model()->find($criteria);
            if (isset($objFollowers->Followers)) {
                $returnValue = $objFollowers->Followers;
            }
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getGroupPostObjectFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
    
     public function getObjectSaveItForLaterUsers($postId){
             
            $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('saveItForLaterUserIds'=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = GroupPostCollection::model()->find($criteria);
            if (isset($objFollowers->saveItForLaterUserIds)) {
                $returnValue =$objFollowers->saveItForLaterUserIds;
                          }
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getObjectSaveItForLaterUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
       
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
            $objFollowers = GroupPostCollection::model()->find($criteria);
            if (isset($objFollowers->Invite)) {
                $returnValue = $objFollowers->Invite;
            }
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getInvitedUsersForPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        return $returnValue;
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
             $returnValue=GroupPostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("GroupPostCollection:updatePostWhenCommentAbused::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
             $returnValue=GroupPostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             if($returnValue){
                $criteria = new EMongoCriteria;
                $criteria->addCond('_id', '==', new MongoId($postId));
                $criteria->Comments->IsBlockedWordExist("==" ,1); 
                $obj = GroupPostCollection::model()->find($criteria);
                if (!is_object($obj)) {
                    $criteria = new EMongoCriteria;
                    $criteria->addCond('_id', '==', new MongoId($postId));
                    $mongoModifier = new EMongoModifier;  
                    $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 0);
                    $returnValue=GroupPostCollection::model()->updateAll($mongoModifier,$criteria);
                    if($returnValue){
                        $returnValue = 'PostReleased';
                    }
                }else{
                    $returnValue = 'CommentReleased';
                }
             }
             return $returnValue;
        } catch (Exception $ex) {
           Yii::log("GroupPostCollection:blockOrReleaseComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            $postObj = GroupPostCollection::model()->find($criteria);
            if (is_object($postObj)) {
                $returnValue = $postObj->Comments[0];
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getCommentById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getAllPostsHaveBlockedComments() {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('IsBlockedWordExistInComment', '==', 1);
            $postObj = GroupPostCollection::model()->findAll($criteria);
            $returnValue = $postObj;
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getAllPostsHaveBlockedComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getPostById($postId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = GroupPostCollection::model()->find($criteria);
            if (is_object($postObj)) {
                $returnValue = $postObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getPostById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getAllBlockedPosts() {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('IsBlockedWordExist', '==', 1);
            $postObj = GroupPostCollection::model()->findAll($criteria);
            $returnValue = $postObj;
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getAllBlockedPosts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function releasePostHaveBlockedComments($postId){
        try{
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoId($postId));
            $mongoModifier = new EMongoModifier;  
            $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 0);
            $returnValue=GroupPostCollection::model()->updateAll($mongoModifier,$criteria);
            if($returnValue){
                $returnValue = 'success';
            }
            return $returnValue;
        }catch(Exception $ex){
            Yii::log("GroupPostCollection:releasePostHaveBlockedComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    /**
     * @author karteek.v
     * @param type $postIdsArray
     * @return array
     */
    public function getPostByIds($postIdsArray) {
        try {
            $postIdsArray = array_unique($postIdsArray);
            $returnValue = array();// only one time it will be flushed
            $i =0;
            foreach ($postIdsArray as $rw) {
                
                $returnArr = array(); // each and every iteration it will be flushed
                $criteria = new EMongoCriteria;
                $criteria->addCond('_id', '==', new MongoID($rw));
//                                $postObj = GroupPostCollection::model()->count();
                $postObj = GroupPostCollection::model()->find($criteria);
                if (is_object($postObj)) {
//                    if (isset($postObj->_id) && !empty($postObj->_id)) {
                        foreach ($postObj->_id as $rw) {
                            $returnArr['PostId'] = $rw;
                        }
                        $returnArr['LoveUserId'] = $postObj->UserId;
                        $returnArr['Description'] = $postObj->Description;
                        $returnArr['LoveCount'] = count($postObj->Love);
                        $count = 0;
                        foreach ($postObj->Comments as $key=>$value) {
                            if (!(isset($value ['IsBlockedWordExist']) && $value ['IsBlockedWordExist']==1)) {
                                $count++;
                            }
                        }
                        $returnArr['CommentCount'] =$count;
                        $returnArr['FollowCount'] = count($postObj->Followers);
                        array_push($returnValue, $returnArr);
//                    }
                }
            }// updating stream collection
            PostCollection::model()->updateStreamPostCountsFromNodeRequest($returnValue);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getPostByIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author Karteek V
     * This is used to fetch the conversations count in the groupPost for analytics...
     * @return type
     */
     public function getConversationCount($segmentId=0){
        try{
            $criteria = new EMongoCriteria;
            if($segmentId!=0){
                $criteria->addCond('SegmentId', '==', $segmentId);
            }
            return GroupPostCollection::model()->count($criteria);        
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getConversationCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in GroupPostCollection->getConversationCount==".$ex->getMessage());
        }
    }
        
    public function GetGroupPostsBetweenDates($startDate,$endDate,$postType,$IsFeatured,$Ispromoted,$NetworkId){
        try {       
             $returnValue='failure';
             $startDate=date('Y-m-d',strtotime($startDate));
            $endDate=date('Y-m-d',strtotime($endDate));
            $criteria = new EMongoCriteria;
             $endDate =$endDate." 23:59:59";
            $startDate =$startDate." 00:00:00";
           
            
            $startDate=date('Y-m-d H:i:s',strtotime($startDate));
            $endDate=date('Y-m-d H:i:s',strtotime($endDate));
            $criteria->addCond('NetworkId', '==', (int)$NetworkId);
            if($IsFeatured=='0' && $Ispromoted=='0'){
                $criteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
                if($postType!=""){
                     $criteria->addCond('Type', '==', (int)$postType);
                }
            }
            if($IsFeatured !=0){
                
                $criteria->addCond('IsFeatured', '==', (int)$IsFeatured);
                $criteria->FeaturedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
                
            }
            if($Ispromoted!=0){
               
                $criteria->addCond('IsPromoted', '==', (int)$Ispromoted);
                $criteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
            }
            $allposts = GroupPostCollection::model()->findAll($criteria);  
            if(is_array($allposts)){
                $returnValue=count($allposts);
            }
            
            return $returnValue;

        } catch (Exception $ex) {
           Yii::log("GroupPostCollection:GetGroupPostsBetweenDates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
     
     public function GetGroupActivityPostsBetweenDatesByGroupId($groupId, $startDate,$endDate,$NetworkId){
        try { 
            $finalArray = array();
            $startDate=date('Y-m-d',strtotime($startDate));
            $endDate=date('Y-m-d',strtotime($endDate));
            $c =  GroupPostCollection::model()->getCollection();
            $keys = array("CreatedDate" => 1);
            $initial = array("count" => 0);
            $reduce = "function (obj, prev) { prev.count++; }";
            
            $condition = array('condition' => array("GroupId"=>new MongoId($groupId),"Type"=>array('$in' => array(1)),"CreatedDate"=>array('$gte' => $startDate,'$lte' => $endDate)));
            $g = $c->group($keys, $initial, $reduce,$condition);
            $arr = $g['retval'];
            foreach ($arr as $value) {
                $value['CreatedDate'] = date('m/d/Y', strtotime($value['CreatedDate']));
                if (array_key_exists($value['CreatedDate'], $finalArray)) {
                    
                    $value['CreatedDate'] = date('m/d/Y', strtotime($value['CreatedDate']));
                    // $value['CreatedDate'] = str_replace("-","/",$value['CreatedDate']);
                    $finalArray[$value['CreatedDate']] = array($value['count'], 0, 0);


//                    $existingArray = $finalArray[$value['CreatedDate']];
//                    $existingArray[0] = $value['count'];
//                    $finalArray[$value['CreatedDate']] = $existingArray;
                } else {
                    $finalArray[$value['CreatedDate']] = array($value['count'], 0, 0);
                }
            }
            
            $keys = array("CreatedDate" => 1);
            $initial = array("count" => 0);
            $reduce = "function (obj, prev) { prev.count++; }";

            $condition = array('condition' => array("GroupId" => new MongoId($groupId),"Type" => array('$in' => array(2)), "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)));
            $g = $c->group($keys, $initial, $reduce, $condition);
            $arr = $g['retval'];
            foreach ($arr as $value) {
                $value['CreatedDate'] = date('m/d/Y', strtotime($value['CreatedDate']));
                if (array_key_exists($value['CreatedDate'], $finalArray)) {
                    $existingArray = $finalArray[$value['CreatedDate']];
                    $existingArray[1] = $value['count'];
                    $finalArray[$value['CreatedDate']] = $existingArray;
                } else {
                    $finalArray[$value['CreatedDate']] = array(0, $value['count'], 0);
                }
            }
            $keys = array("CreatedDate" => 1);
            $initial = array("count" => 0);
            $reduce = "function (obj, prev) { prev.count++; }";

            $condition = array('condition' => array("GroupId" => new MongoId($groupId),"Type" => array('$in' => array(3)), "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)));
            $g = $c->group($keys, $initial, $reduce, $condition);
            $arr = $g['retval'];
            foreach ($arr as $value) {
                
                $value['CreatedDate'] = date('m/d/Y', strtotime($value['CreatedDate']));
                if (array_key_exists($value['CreatedDate'], $finalArray)) {
                    $existingArray = $finalArray[$value['CreatedDate']];
                    $existingArray[2] = $value['count'];
                    $finalArray[$value['CreatedDate']] = $existingArray;
                } else {
                    $finalArray[$value['CreatedDate']] = array(0, 0, 0, 0, $value['count'], 0, 0);
                }
            }
          ksort($finalArray);
         
          if (count($finalArray) == 0) {
                $startDate = date('m/d/Y', strtotime($startDate));
                $endDate = date('m/d/Y', strtotime($endDate));
                $finalArray[$startDate] = array(0, 0, 0);
                $finalArray[$endDate] = array(0, 0, 0);
            }
            foreach ($finalArray as $key => $value) {
            }
            return $finalArray;
        } catch (Exception $ex) {
           Yii::log("GroupPostCollection:GetGroupActivityPostsBetweenDatesByGroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }

     public function isUserFollowsAGroup($userId,$groupId,$categoryType){
         try{
             $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoId($groupId));
            $postObj = GroupPostCollection::model()->find($criteria);
           
            if (is_object($postObj) || is_array($postObj)) {                  
                if($categoryType == 7){
                    $returnValue = SubGroupCollection::model()->checkUserFollowAgroup($userId,$postObj);
                }else if($categoryType == 3){
                    $returnValue = GroupCollection::model()->checkUserFollowAgroup($userId,$postObj);
                }
            }
            return $returnValue;
         }catch(Exception $ex){
             Yii::log("GroupPostCollection:isUserFollowsAGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             error_log("Exception Occurred in GroupPostCollection->isUserFollowsAGroup==".$ex->getMessage());
         }
     }
      public function getPostIdByMigratedPostId($PostId) {
        try {
            $postObj = GroupPostCollection::model()->findByAttributes(array('MigratedPostId' => $PostId));
            return $postObj;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getPostIdByMigratedPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in GroupPostCollection->getPostIdByMigratedPostId==".$ex->getMessage());
        }
    }
    
     
     /**
     * @author Haribabu
     * @param type $userId
     * @param type $postId
     * @return string
     */
      
     public function getGroupPostsCountForHashtag($hashtagId) {
        try{
        $array = array(
            'conditions' => array(
                'HashTags' => array('in' => array(new MongoId($hashtagId))),
                'IsDeleted'=>array('!=' => 1),
               // 'IsBlockedWordExist'=>array('notIn' => array(1,2)),
               // 'IsAbused'=>array('notIn' => array(1,2)),
            ),
           
        );
        $posts = GroupPostCollection::model()->findAll($array);
        
        return count($posts);
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getGroupPostsCountForHashtag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
    
     /**
     * @author Haribabu
     * @param $hashtagId, $offset, $pageLength
     * @return 
     */
    public function getGroupPostsForHashtag($hashtagId, $offset, $pageLength,$userId) {
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

        $posts = GroupPostCollection::model()->findAll($array);
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
            $groupDetails=GroupCollection::model()->getGroupDetailsById($post->GroupId);
            if(in_array($userId, $groupDetails->GroupMembers)){
                array_push($postsArray, array($post, $user->DisplayName, "1"));
            }
            
        }
        return $postsArray;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getGroupPostsForHashtag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
//        public function getPostByIds($postId) {
//        try {
//            $returnValue = array();// only one time it will be flushed
//            $returnArr = array();
//            $i =0;
//            $criteria = new EMongoCriteria;
//            $criteria->addCond('_id', '==', new MongoID($postId));
//            $postObj = GroupPostCollection::model()->find($criteria);
//            if (is_object($postObj)) {
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
//                        $returnArr['FollowCount'] = count($postObj->Followers);
////                        array_push($returnValue, $returnArr);
////                    }
//              }
//              if(!empty($returnArr))
//                PostCollection::model()->updateStreamPostCountsFromNodeRequest($returnArr);
//            return $returnArr;
//        } catch (Exception $ex) {
//            Yii::log($ex->getMessage(), 'error', 'application');
//        }
//    }
    
 public function getGroupPostsForHashtagSearch($postIdArray) {
        try{
        $returnValue = 'failure';
            $postsArray=array();
          
            for ($i = 0; $i < sizeof($postIdArray); $i++) {

            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postIdArray[$i]));
            $postObj = GroupPostCollection::model()->findAll($criteria);


            foreach ($postObj as $post) {

                $tagsFreeDescription = strip_tags(($post->Description));
                $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
                $postLength = strlen($tagsFreeDescription);

                if ($postLength > 240) {
                    $post->Description = CommonUtility::truncateHtml($post->Description, 240);
                    $post->Description = $post->Description . ' <i class="fa moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i>';
                }

                $user = UserCollection::model()->getTinyUserCollection($post->UserId);
                $groupDetails = GroupCollection::model()->getGroupDetailsById($post->GroupId);
                if (in_array($post->UserId, $groupDetails->GroupMembers)) {
                    array_push($postsArray, array($post, $user->DisplayName, "1"));
                }
            }
        }
        return $postsArray;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getGroupPostsForHashtagSearch::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }   
    
 
     /**
     * @author Swathi
     * This is used to fetch all the posts by UserId
     * @param int $userId Description 
     * @return type
     */
     public function getAllGroupPostsByUserId($userId){
        try {       
            $returnValue='failure';
            
            
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('HashTags'=>true));
            $criteria->addCond('UserId', '==', (int)$userId);
            $criteria->addCond('IsDeleted','!=',(int)1);
            $criteria->addCond('IsBlockedWordExist','notin',array(1, 2));
            $criteria->addCond('IsAbused','notin',array(1, 2));
            $allposts = GroupPostCollection::model()->findAll($criteria); 
            
            return $allposts;

        } catch (Exception $ex) {
           Yii::log("GroupPostCollection:getAllGroupPostsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
             }elseif ($actionType="ReleaseAbusedComment") {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 0);
             }elseif ($actionType="AbuseCommentForSuspendedUser") {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 3);
             }
             $returnValue=GroupPostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             if($actionType=='AbuseComment'){
                 $returnValue = 'CommentAbused';
             }elseif($returnValue){
                $criteria = new EMongoCriteria;
                $criteria->addCond('_id', '==', new MongoId($postId));
                $criteria->Comments->IsCommentAbused("==" ,1); 
                $obj = GroupPostCollection::model()->find($criteria);
                if (!is_object($obj)) {//If posts have no abused comments
                    $criteria = new EMongoCriteria;
                    $criteria->addCond('_id', '==', new MongoId($postId));
                    $mongoModifier = new EMongoModifier;  
                    $mongoModifier->addModifier('IsCommentAbused', 'set', 0);
                    $returnValue=GroupPostCollection::model()->updateAll($mongoModifier,$criteria);
                    if($returnValue){
                        $returnValue = 'PostReleased';
                    }
                }else{
                    $returnValue = 'CommentReleased';
                }
             }
             return $returnValue;

        } catch (Exception $ex) {
           Yii::log("GroupPostCollection:commentManagement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
         
         GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria);
     } catch (Exception $ex) {
         Yii::log("GroupPostCollection:updatePostsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }

         
    
     public function getPostsByGroupId($groupId) {
        $returnValue='failure';
       try {
           $mongoCriteria = new EMongoCriteria;          
           $mongoCriteria->addCond('GroupId', '==', new MongoId($groupId));
           $groupObj = GroupPostCollection::model()->findAll($mongoCriteria);
           if(is_object($groupObj) ||  is_array($groupObj)){
               $returnValue =$groupObj;
           }
           
           return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupPostCollection:getPostsByGroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in GroupPostCollection->getPostsByGroupId==".$ex->getMessage());
        }
    }

}

