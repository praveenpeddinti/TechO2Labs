<?php

/* This Collection is Used to store all the profile details of the User
 * 
 * 
 * 
 */

class UserNetworkInviteCollection extends EMongoDocument {

    public $NetworkInviteId;
    public $NetworkName;
    public $NetworkClientId;
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
    public $CategoryId = 10;
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
    
  public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';

    public function getCollectionName() {
        return 'UserBadgeCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            )
        );
    }
    public function attributeNames() {
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
            'NetworkInviteId' => 'NetworkInviteId',
            'NetworkName' => 'NetworkName',
            'NetworkClientId' => 'NetworkClientId',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
        );
    }

    /* This method is used to save into the user badge collection  
     * it accepts the UserBadgeCollectionObject and returns true or false 
     */

    public function saveUserNetworkInviteCollection($networkInviteCollectionObj) {

        try {
           
            $userNICollection = new UserNetworkInviteCollection();
            $userNICollection->UserId = (int) $networkInviteCollectionObj['UserId'];
            $userNICollection->NetworkInviteId = (int) $networkInviteCollectionObj['NetworkInviteId'];
            $userNICollection->NetworkName = $networkInviteCollectionObj['NetworkName'];
            $userNICollection->NetworkClientId = $networkInviteCollectionObj['NetworkClientId'];
            $userNICollection->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $userNICollection->save();
            if (isset($userNICollection->_id)) {
                $returnValue = $userNICollection->_id;
            } else {

                return 'error';
            }
           
            return $returnValue;

//           
        } catch (Exception $ex) {
            Yii::log("UserNetworkInviteCollection:saveUserNetworkInviteCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Swathi
     * @Description This method is use to  get User Badges 
     * @return  success =>Array failure =>string 
     */
    public function getUserNetworkInviteByCriteria($userId,$networkInviteId) {
        $returnValue = 'failure';
        try {

            $array = array(
                'conditions' => array(
                    'UserId' => array('==' => (int) $userId),
                     'NetworkInviteId' => array('==' => (int) $networkInviteId),
                    
                ),
               
                
            );
         
            return  UserNetworkInviteCollection::model()->find($array);
        } catch (Exception $ex) {
            Yii::log("UserNetworkInviteCollection:getUserNetworkInviteByCriteria::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
     public function getUserNetworkInviteCollectionById($id) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->_id = new MongoId($id);
            $ubObj = UserNetworkInviteCollection::model()->find($criteria);
           
            if (is_object($ubObj)) {
                $returnValue = $ubObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserNetworkInviteCollection:getUserNetworkInviteCollectionById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

   

   
}
