<?php

/* This Collection is Used to store all the profile details of the User
 * 
 * 
 * 
 */

class UserCVPublicationsCollection extends EMongoDocument {

   
    public $_id;
    public $Type;
    public $UserId;
    public $Priority;
    public $CreatedOn;
    public $Description;
    public $Followers = array();
    public $Mentions = array();
    public $Comments = array();
    public $Resource = array();
    public $Love = array();
    public $Invite = array();
    public $Share = array();
    public $Subject;
    public $CategoryId = 12;
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
    public $WebUrls;
    public $Division = 0;
    public $District = 0;
    public $Region = 0;
    public $Store = 0;
    public $FbShare = array();
    public $TwitterShare = array();
    public $MigratedPostId = '';
    //$postedBy is added by Sagar for PostAsNetwork
    public $PostedBy = 0;
    public $PromotedDate;
    public $IsWebSnippetExist;
    public $HashTags;
    public $Title;
    public $PostType;
    
  public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';
  public $saveItForLaterUserIds=array();

    public function getCollectionName() {
        try{
        return 'UserCVPublicationsCollection';
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:getCollectionName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function model($className = __CLASS__) {
        try{
        return parent::model($className);
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:model::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function indexes() {
        try{
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            )
        );
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:indexes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function attributeNames() {
        try{
        return array(
            '_id' => '_id',
            'Type' => 'Type',
            'UserId' => 'UserId',
            'Priority' => 'Priority',
            'CreatedOn' => 'CreatedOn',
            'Description' => 'Description',
            'Followers' => 'Followers',
            'Mentions' => 'Mentions',
            'Comments' => 'Comments',
            'Love' => 'Love',
            'Resource' => 'Resource',
            'HashTags' => 'HashTags',
            'Invite' => 'Invite',
            'Share' => 'Share',
            'Subject' => 'Subject',
            'CategoryId' => 'CategoryId',
            'DisableComments' => 'DisableComments',
            'IsAbused' => 'IsAbused',
            'AbusedUserId' => 'AbusedUserId',
            'IsDeleted' => 'IsDeleted',
            'IsPromoted' => 'IsPromoted',
            'PromotedUserId' => 'PromotedUserId',
            'AbusedOn' => 'AbusedOn',
            'IsBlockedWordExist' => 'IsBlockedWordExist',
            'IsFeatured' => 'IsFeatured',
            'FeaturedUserId' => 'FeaturedUserId',
            'FeaturedOn' => 'FeaturedOn',
            'IsBlockedWordExistInComment' => 'IsBlockedWordExistInComment',
            'IsWebSnippetExist' => 'IsWebSnippetExist',
            'WebUrls' => 'WebUrls',
            'Division' => 'Division',
            'District' => 'District',
            'Region' => 'Region',
            'Store' => 'Store',
            'FbShare' => 'FbShare',
            'TwitterShare' => 'TwitterShare',
            'MigratedPostId' => 'MigratedPostId',
            'PostedBy' => 'PostedBy',
            'PromotedDate' => 'PromotedDate',
            'PostType' => 'PostType',
            'Title'=>'Title',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
             'saveItForLaterUserIds'=>'saveItForLaterUserIds'

        );
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:attributeNames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /* This method is used to save into the user badge collection  
     * it accepts the UserBadgeCollectionObject and returns true or false 
     */

    public function saveUserCVPublicationsCollection($saveObj) {

        try {
            $mongoCriteria = new EMongoCriteria;            
            $mongoCriteria->addCond('UserId', '==', (int)$saveObj['UserId']);
            $userCVPCollectionObj = UserCVPublicationsCollection::model()->find($mongoCriteria);
            if(isset($userCVPCollectionObj) && !empty($userCVPCollectionObj->UserId)){// update cond...
                $mongoModifier = new EMongoModifier;
                $mongoModifier->addModifier('Title', 'set', $saveObj['Title']);
                $mongoModifier->addModifier('Description', 'set', $saveObj['Description']);
                $mongoModifier->addModifier('CreatedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
                if(UserCVPublicationsCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                    $returnValue = $userCVPCollectionObj->_id."_update";
                }else{
                    $returnValue = 'error';
                }
            }else{ // save cond...
                $userCVPCollection = new UserCVPublicationsCollection();
                $userCVPCollection->UserId = (int) $saveObj['UserId'];
                $userCVPCollection->Description = $saveObj['Description'];
                $userCVPCollection->Title = $saveObj['Title'];
                $userCVPCollection->CategoryId = (int) $saveObj['CategoryType'];
                $userCVPCollection->Type = (int) $saveObj['PostType'];
                $userCVPCollection->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                $userCVPCollection->NetworkId= (int)Yii::app()->params['NetWorkId'];
                $userCVPCollection->save();
                if (isset($userCVPCollection->_id)) {
                    $returnValue = $userCVPCollection->_id."_saved";
                } else {
                    return 'error';
                }
            }
            
           
            return $returnValue;

//           
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:saveUserCVPublicationsCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserCVPublicationsCollection->saveUserCVPublicationsCollection==".$ex->getMessage());
        }
    }

    /**
     * @author Swathi
     * @Description This method is use to  get User Badges 
     * @return  success =>Array failure =>string 
     */
    public function getUserCVPCollectionByCriteria($userId) {
        $returnValue = 'failure';        
        try {
            
            $array = array(
                'conditions' => array(
                    'UserId' => array('==' => (int) $userId),
                    
                ),
               
            );
            $mongoCriteria = new EMongoCriteria;    
            $mongoCriteria->addCond('UserId', '==', (int) $userId);
            $dObj =  UserCVPublicationsCollection::model()->find($mongoCriteria);
            
            return $dObj;
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:getUserCVPCollectionByCriteria::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
    public function updateCollection($saveObj) {

        try {

            $returnValue = FALSE;
            //throw new Exception('Unable to save love');
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
       
            $mongoCriteria->addCond('UserId', '==', (int)($saveObj['UserId']));
            $mongoModifier->addModifier('Title', 'set', $saveObj['Title']);
               $mongoModifier->addModifier('Description', 'set', $saveObj['Description']);
                $mongoModifier->addModifier('CreatedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
          
            if (UserCVPublicationsCollection::model()->updateAll($mongoModifier, $mongoCriteria)) {
                $returnValue = TRUE;
            }
           
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:updateCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserCVPublicationsCollection->updateCollection==".$ex->getMessage());
            return FALSE;
        }
    }
    
    public function getCVObjectFollowers($postId) {
     
        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Followers' => true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = UserCVPublicationsCollection::model()->find($criteria);
            if (isset($objFollowers->Followers)) {
                $returnValue = $objFollowers->Followers;
            }
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:getCVObjectFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
    
      public function getObjectSaveItForLaterUsers($postId){
             
            $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('saveItForLaterUserIds'=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = UserCVPublicationsCollection::model()->find($criteria);
            if (isset($objFollowers->saveItForLaterUserIds)) {
                $returnValue =$objFollowers->saveItForLaterUserIds;
                          }
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:getObjectSaveItForLaterUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
       
        }

    public function loveCVPost($postId, $userId) {
        try {
            $returnValue = FALSE;
            //throw new Exception('Unable to save love');
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Love', 'push', (int) $userId);
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $mongoCriteria->addCond('Love', '!=', (int) $userId);
            if (UserCVPublicationsCollection::model()->updateAll($mongoModifier, $mongoCriteria)) {
                $returnValue = TRUE;
            }
         
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:loveCVPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserCVPublicationsCollection->loveCVPost==".$ex->getMessage());
            return FALSE;
        }
    }
    
    public function saveComment($postId, $comments) {
        try {
            $returnValue = FALSE;
            //throw new Exception('Division by zero.');
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Comments', 'push', $comments);
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            if (UserCVPublicationsCollection::model()->updateAll($mongoModifier, $mongoCriteria)) {
                $returnValue = TRUE;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:saveComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return FALSE;
        }
    }
    
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
            $return = UserCVPublicationsCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:saveInvites::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function getPostById($postId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = UserCVPublicationsCollection::model()->find($criteria);
            if (is_object($postObj)) {
                $returnValue = $postObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:getPostById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getPostCommentsByPostId($postId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
           
            //  $criteria->setSelect(array('Comments='=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = UserCVPublicationsCollection::model()->find($criteria);
            if (isset($postObj->Comments)) {
                $returnValue = $postObj->Comments;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:getPostCommentsByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getInvitedUsersForPost($postId) {

        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Invite' => true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = UserCVPublicationsCollection::model()->find($criteria);
            if (isset($objFollowers->Invite)) {
                $returnValue = $objFollowers->Invite;
            }
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:getInvitedUsersForPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        return $returnValue;
    }
    public function followOrUnfollow($postId, $userId, $actionType) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow') {
                $mongoModifier->addModifier('Followers', 'push', $userId);
                $mongoCriteria->addCond('Followers', '!=', (int) $userId);
            } else if ($actionType == 'UnFollow') {
                $mongoModifier->addModifier('Followers', 'pull', $userId);
            }
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $returnValue = UserCVPublicationsCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("UserCVPublicationsCollection:followOrUnfollow::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function saveitforlaterPost($postId, $userId){
        try {          
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
              $mongoModifier->addModifier('saveItForLaterUserIds', 'push', (int)$userId);
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=UserCVPublicationsCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("UserCVPublicationsCollection:saveitforlaterPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   
}
