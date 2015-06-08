<?php

/* This Collection is Used to store all the profile details of the User
 * 
 * 
 * 
 */

class DSNNotificationCollection extends EMongoDocument {

   public $NetworkName;
   public $NotificationType;
    public $NotificationStreamNote;
    public $Description;
    public $LoveCount;
    public $FollowCount; 
    public $CommentCount; 
    public $UserDetails=array(); 
    public $Artifacts=array();
    public $TopicDetails=array();
    
   public $GameName;
    public $QuestionsCount;
    public $PlayersCount;
    
    public $_id;
    public $Type;
    public $UserId;
    public $Priority;
    public $CreatedOn;
  
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
    public $NetworkId;
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
    

    public function getCollectionName() {
        return 'DSNNotificationCollection';
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
            'NetworkId' => 'NetworkId',
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
           
            'NetworkName' => 'NetworkName',
            'NotificationType' => 'NotificationType',
            'NotificationStreamNote' => 'NotificationStreamNote',
            'Description' => 'Description',
            'LoveCount' => 'LoveCount',
            'FollowCount' => 'FollowCount',
            'LoveCount' => 'LoveCount',
            'CommentCount' => 'CommentCount',
            'UserDetails' => 'UserDetails',
            'Artifacts' => 'Artifacts',
            'TopicDetails' => 'TopicDetails',
            'UserDetails' => 'UserDetails',
            'GameName' => 'GameName',
            'QuestionsCount' => 'QuestionsCount',
            'PlayersCount' => 'PlayersCount',
           
           
        );
    }

    /* This method is used to save into the user badge collection  
     * it accepts the UserBadgeCollectionObject and returns true or false 
     */

    public function saveDSNNotificationCollection($obj) {

        try {
           
            $dsnNotificationCollection = new DSNNotificationCollection();
            $dsnNotificationCollection->NetworkName = $obj->NetworkName;
            $dsnNotificationCollection->NotificationType = $obj->NotificationType;
            $dsnNotificationCollection->NotificationStreamNote = $obj->NotificationStreamNote;
            $dsnNotificationCollection->Description = $obj->Description;
            $dsnNotificationCollection->LoveCount = $obj->LoveCount;
            $dsnNotificationCollection->FollowCount = $obj->FollowCount;
            $dsnNotificationCollection->CommentCount = $obj->CommentCount;
            $dsnNotificationCollection->UserDetails = $obj->UserDetails;
            $dsnNotificationCollection->TopicDetails = $obj->TopicDetails;
            $dsnNotificationCollection->Artifacts = $obj->Artifacts;
            $dsnNotificationCollection->UserId = $obj->UserId;
            
            $dsnNotificationCollection->GameName = $obj->GameName;
            $dsnNotificationCollection->QuestionsCount = $obj->QuestionsCount;
            $dsnNotificationCollection->PlayersCount = $obj->PlayersCount;
            
            $data = gmdate('m/d/Y', strtotime("+ 1 days"));
            $startDate = date('Y-m-d', strtotime($data)); 
            $startDate = trim($startDate) . " 00:00:00";
            
            $dsnNotificationCollection->CreatedOn = new MongoDate(strtotime($startDate));
            $dsnNotificationCollection->save();
            if (isset($dsnNotificationCollection->_id)) {
                $returnValue = $dsnNotificationCollection->_id;
            } else {

                return 'error';
            }
           
            return $returnValue;

//           
        } catch (Exception $ex) {
            Yii::log("DSNNotificationCollection:saveDSNNotificationCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Swathi
     * @Description This method is use to  get User Badges 
     * @return  success =>Array failure =>string 
     */
    public function getDSNCommonNotificationCollectionByCriteria($networkName,$UserId) {
        $returnValue = 'failure';
        try {
            
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
            $endDate = trim($endDate) . " 23:59:59";
            $startDate = trim($startDate) . " 00:00:00";
            
           
            $array = array(
                'conditions' => array(
                    'NetworkName' => array('==' => $networkName),
                    'NotificationType' => array('in' => array(1,2,4)),
                    // "CreatedOn" => array('>=' => new MongoDate(strtotime($startDate)), '<=' => new MongoDate(strtotime($endDate)))
                   
                ),
                
                'sort' => array('NotificationType' => EMongoCriteria::SORT_ASC),
            );
            
            
             if($UserId!="")
             {
                 
              $array = array(
                'conditions' => array(
                    'NetworkName' => array('==' => $networkName),
                    'NotificationType' => array('==' => (int)3),
                   'UserId' => array('==' => (int)$UserId),
                   //  "CreatedOn" => array('>=' => new MongoDate(strtotime($startDate)))
                   
                ),
                
                'sort' => array('NotificationType' => EMongoCriteria::SORT_ASC),
            );
             
             }
             else
             $mongoCriteria = new EMongoCriteria($array);
             

             $mongoCriteria->addCond("CreatedOn", ">=", new MongoDate(strtotime($startDate)));
           // $mongoCriteria->addCond("CreatedOn", "<=", new MongoDate(strtotime($endDate)));
            
            
           
       
            $result=  DSNNotificationCollection::model()->findAll($mongoCriteria);
            
             return $result;
        } catch (Exception $ex) {
            Yii::log("DSNNotificationCollection:getDSNCommonNotificationCollectionByCriteria::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in DSNNotificationCollection->getDSNCommonNotificationCollectionByCriteria==".$ex->getMessage());
            return $returnValue;
        }
    }
    
    
   
  

}
