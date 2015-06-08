<?php

/**
 * @author sureshreddy
 * @copyright 2013 techo2.com
 * @version 3.0
 * @category Stream
 * @package Stream
 */

/**
 * UserActivityCollection
 *
 * Activity object of user, that behaves user activity of system,
 * 
 */

class UserActivityCollection extends EMongoDocument {

 
    public $UserId;
    public $CreatedOn;
    public $_id;    
    public $StreamNote;
    //1- comment , 2-followers, 3-mentions
    public $RecentActivity;
    public $ActionType;
    public $CategoryType;
    public $PostType;
    public $FollowEntity;
    public $NetworkId;
    public $CommentUserId=array();
    public $Comments=array();
    public $FollowUserId=array();
    public $MentionUserId;
    public $PostId;
    public $PostText;
    public $Resource;
    public $IsMultiPleResources;
    public $OriginalUserId;
    public $OriginalPostTime;    
    public $LoveCount=0;
    public $CommentCount=0;
    public $FollowCount=0;
    public $ShareCount=0;
    public $InviteCount=0;
    public $UserFollowers;
    public $StartDate;
    public $EndDate;
    public $EventAttendes = array();
    public $Location;
    public $LoveUserId=array();
    public $StreamNote1;
    public $HashTagPostUserId;
    public $PostFollowers=array();
    public $InviteUsers=array();
    public $InviteMessage;
    public $OptionOne;
    public $OptionTwo;
    public $OptionThree;
    public $OptionFour;
    public $OptionOneCount;
    public $OptionTwoCount;
    public $OptionThreeCount;
    public $OptionFourCount;
    public $ExpiryDate;
    public $SurveyTaken=array();
    public $StartTime;
    public $EndTime;
    public $CurbsideConsultTitle;
    public $CurbsideConsultCategory;
    public $Priority;
    public $IsAbused=0;//0 - Default/Release, 1 - Abused, 2 - Blocked
    public $AbusedUserId;
    public $IsDeleted=0;
    public $IsPromoted=0;
    public $PromotedUserId;
    public $AbusedOn;
    public $GroupId='';
    public $FollowOn;
    public $HashTagId;
    public $HashTagName;
    public $HashTagPostCount;
    public $CurbsideCategoryId;
    public $PostTextLength;
    public $CurbsidePostCount=0;
     public $IsBlockedWordExist=0;//0 - Default/Release, 1 - Abused, 2 - Blocked
    public $IsBlockedWordExistInComment=0;
    public $DisableComments=0;
    public $Division=0;
    public $District=0;
    public $Region=0;
    public $Store=0;
    public $Title;
    public $FbShare=array();
    public $TwitterShare=array();
    public $SubGroupId=0;
    
    
    
    // public $priority;

    //  public $ppt;
    //  public $docs;
    // public $audio;
    // public $video;
       /**
     *
     * @var type news stream related vars
     */
    public $HtmlFragment;
    public $PublisherSource = '';
    public $PublisherSourceUrl = '';
    public $Editorial = '';
    public $Released = 0;
    public $TopicId = 0;
    public $TopicName = '';
    public $Alignment = '';
    public $PublicationTime;
   public $PublicationDate = '';
   public $TopicImage='';
   public $IsNotifiable=1;

    public $GameName;
    public $GameDescription;
    public $GameBannerImage;
    public $CurrentGameScheduleId = 0;
    public $PlayersCount;
    public $QuestionsCount = 0;
    public $PreviousGameScheduleId = 0;
    public $CurrentScheduledPlayers = array();
    public $CurrentScheduleResumePlayers = array();
    public $PreviousSchedulePlayers = array();
    public $PreviousScheduleResumePlayers = array();
    
    //Badging
    
   
public $BadgeName;
public $BadgeLevelValue;
public $BadgeHasLevel;
public $IsAnonymous = 0;
public $Language;
public $SegmentId = 0;
public $saveItForLaterUserIds=array();
public $IsSaveItForLater=0;
public $Miscellaneous;

  public function getCollectionName() {
      try{
        return 'UserActivityCollection';
      }  catch (Exception $ex){
            Yii::log("UserActivityCollection:getCollectionName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }  
    }

    public static function model($className = __CLASS__) {
        try{
        return parent::model($className);
        }  catch (Exception $ex){
            Yii::log("UserActivityCollection:model::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function indexes() {
        try{
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_CategoryType' => array(
                'key' => array(
                    'CategoryType' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_PostType' => array(
                'key' => array(
                    'PostType' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_GroupId' => array(
                'key' => array(
                    'GroupId' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_IsDeleted' => array(
                'key' => array(
                    'IsDeleted' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_IsBlockedWordExist' => array(
                'key' => array(
                    'IsBlockedWordExist' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_IsAbused' => array(
                'key' => array(
                    'IsAbused' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_IsNotifiable' => array(
                'key' => array(
                    'IsNotifiable' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_PostId' => array(
                'key' => array(
                    'PostId' => EMongoCriteria::SORT_ASC
                ),
            )
        );
        }  catch (Exception $ex){
            Yii::log("UserActivityCollection:indexes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function attributeNames() {
        try{
        return array(
            '_id' => '_id',
            'UserId' => 'UserId',
            'StreamNote' => 'StreamNote',
            'CreatedOn' => 'CreatedOn',
            'FollowOn' =>'FollowOn',
            'PostType' => 'PostType',
            'CategoryType' => 'CategoryType',
            'ActionType' => 'ActionType',
            'RecentActivity' => 'RecentActivity',
            'CommentUserId' => 'CommentUserId',
            'Comments' => 'Comments',
            'FollowUserId' => 'FollowUserId',
            'MentionUserId' => 'MentionUserId',
            'LoveUserId' => 'LoveUserId',
            'PostText' => 'PostText',
            'Resource' => 'Resource',
            'IsMultiPleResources' => 'IsMultiPleResources',
            'OriginalUserId' => 'OriginalUserId',
            'OriginalPostTime' => 'OriginalPostTime',
            'LoveCount' => 'LoveCount',
            'FollowUserId' => 'FollowUserId',
            'PostId' => 'PostId',
            'NetworkId' => 'NetworkId',
            'SegmentId'=>'SegmentId',
            'CreatedOn' => 'CreatedOn',
            'UserFollowers' => 'UserFollowers',
            'StartDate' => 'StartDate',
            'EndDate' => 'EndDate',
            'EventAttendes' => 'EventAttendes',
            'Location' => 'Location',
            'StreamNote1' => 'StreamNote1',
            'HashTagPostUserId' => 'HashTagPostUserId',
            'PostFollowers' => 'PostFollowers',
            'CommentCount' => 'CommentCount',
            'InviteUsers' => 'InviteUsers',
            'InviteMessage' => 'InviteMessage',
            'OptionOneCount' => 'OptionOneCount',
            'OptionTwoCount' => 'OptionTwoCount',
            'OptionThreeCount' => 'OptionThreeCount',
            'OptionFourCount' => 'OptionFourCount',
            'OptionOne' => 'OptionOne',
            'OptionTwo' => 'OptionTwo',
            'OptionThree' => 'OptionThree',
            'OptionFour' => 'OptionFour',
            'ExpiryDate' => 'ExpiryDate',
            'SurveyTaken' => 'SurveyTaken',
            'StartTime' => 'StartTime',
            'EndTime' => 'EndTime',
            'CurbsideConsultTitle' => 'CurbsideConsultTitle',
            'CurbsideConsultCategory' => 'CurbsideConsultCategory',
            'Priority' => 'Priority',
            'IsAbused' => 'IsAbused',
            'AbusedUserId' => 'AbusedUserId',
            'IsDeleted' => 'IsDeleted',
            'IsPromoted' => 'IsPromoted',
            'PromotedUserId' => 'PromotedUserId',
            'AbusedOn' => 'AbusedOn',
            'GroupId' => 'GroupId',           
            'PostTextLength'=>'PostTextLength',
            'CurbsidePostCount'=>'CurbsidePostCount',
            'CurbsideCategoryId'=>'CurbsideCategoryId',
            'IsBlockedWordExist'=>'IsBlockedWordExist',
            'IsBlockedWordExistInComment'=>'IsBlockedWordExistInComment',
            'DisableComments'=>'DisableComments',
            'FollowCount'=>'FollowCount',
             'Division'=>'Division',
            'District'=>'District',
            'Region'=>'Region',
            'Store'=>'Store',
            'Title'=>'Title',
            'ShareCount'=>'ShareCount',
            'FbShare'=>'FbShare',
            'TwitterShare'=>'TwitterShare'    ,
            'SubGroupId'=>'SubGroupId',
             
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

            'IsNotifiable' => 'IsNotifiable',
            'GameName' => 'GameName',
            'GameDescription' => 'GameDescription',
            'GameBannerImage' => 'GameBannerImage',
            'CurrentGameScheduleId' => 'CurrentGameScheduleId',
            'PlayersCount' => 'PlayersCount',
            'QuestionsCount' => 'QuestionsCount',
            'PreviousGameScheduleId' => 'PreviousGameScheduleId',
            'CurrentScheduledPlayers' => 'CurrentScheduledPlayers',
            'CurrentScheduleResumePlayers' => 'CurrentScheduleResumePlayers',
            'PreviousSchedulePlayers' => 'PreviousSchedulePlayers',
            'PreviousScheduleResumePlayers' => 'PreviousScheduleResumePlayers',
            
           
            'BadgeName'=>'BadgeName',
             'BadgeLevelValue'=>'BadgeLevelValue',
            'BadgeHasLevel'=>'BadgeHasLevel',
             'IsAnonymous'=>'IsAnonymous',
             'Language'=>'Language',
             'saveItForLaterUserIds'=>'saveItForLaterUserIds',
             'IsSaveItForLater'=>'IsSaveItForLater',
            'Miscellaneous' => 'Miscellaneous'


        );
        }  catch (Exception $ex){
            Yii::log("UserActivityCollection:attributeNames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * 
     * @param type $obj
     */
    
    public function saveUserActivityForPost($obj) {
        try {
            
            $streamObj = new UserActivityCollection();
            $streamObj->UserId = (int)$obj->UserId;
            $streamObj->StreamNote = $obj->StreamNote;
            $streamObj->StreamNote1 = $obj->StreamNote1;
            $streamObj->CreatedOn = $obj->CreatedOn;
            $streamObj->ActionType = $obj->ActionType;
            $streamObj->NetworkId = (int)$obj->NetworkId;
            $streamObj->SegmentId = (int)$obj->SegmentId;
            $streamObj->Language = $obj->Language;
            $obj->PostType=(int)$obj->PostType;
            $streamObj->PostType = (int)$obj->PostType;
            if(isset($obj->IsAnonymous)){
                 $streamObj->IsAnonymous = (int)$obj->IsAnonymous;
            }
             
             $streamObj->CategoryType = (int)$obj->CategoryType;
            $streamObj->FollowEntity = (int)$obj->FollowEntity;

            $streamObj->RecentActivity = $obj->RecentActivity;
            if($obj->CategoryType==3){
                $streamObj->GroupId =  new MongoId($obj->GroupId);
            }
             if($obj->CategoryType==7){
                 $streamObj->GroupId =  new MongoId($obj->GroupId);
                $streamObj->SubGroupId =  new MongoId($obj->SubGroupId);
            }
            $streamObj->FollowOn = $obj->CreatedOn;
            if (isset($obj->Comments['CommentId'])) {
                $obj->Comments['CommentId'] = new MongoId((String)$obj->Comments['CommentId']);

                $streamObj->Comments = array($obj->Comments);
                $streamObj->CommentUserId = array((int) $obj->CommentUserId);
            } else {
                $streamObj->Comments = array();
                $streamObj->CommentUserId = array();
            }


            $streamObj->FollowUserId = array();

            if ($obj->MentionUserId != "" && $obj->MentionUserId != null) {
                $streamObj->MentionUserId = (int) $obj->UserId;
            }

            if ($obj->PostFollowers != "" && $obj->PostFollowers != null) {
                $streamObj->PostFollowers = array((int)$obj->UserId) ;
            } else {

                $streamObj->PostFollowers = array();
            }
            if (isset($obj->FbShare) && $obj->FbShare != "" && $obj->FbShare != null) {
                $streamObj->FbShare = array((int)$obj->UserId) ;
            } else {

                $streamObj->FbShare = array();
            }
            if (isset($obj->TwitterShare) && $obj->TwitterShare != "" && $obj->TwitterShare != null) {
                $streamObj->TwitterShare = array((int)$obj->UserId) ;
            } else {

                $streamObj->TwitterShare = array();
            }

            $streamObj->FollowUserId = array();
           if ($obj->LoveUserId != "" && $obj->LoveUserId != null) {
                $streamObj->LoveUserId = array((int) $obj->UserId);
            } else {

                $streamObj->LoveUserId = array();
            }


            $streamObj->PostId = new MongoId($obj->PostId);
            $streamObj->PostText = $obj->PostText;
            $streamObj->PostTextLength = $obj->PostTextLength;
            $streamObj->Resource = $obj->Resource;
            $streamObj->IsMultiPleResources = $obj->IsMultiPleResources;
            $streamObj->OriginalUserId = $obj->OriginalUserId;
            $streamObj->OriginalPostTime = new MongoDate($obj->OriginalPostTime);

            if ($obj->UserFollowers != "" && $obj->UserFollowers != null) {
                $streamObj->UserFollowers = array($obj->UserFollowers);
            } else {
                $streamObj->UserFollowers = array();
            }
            if ($obj->InviteUsers != "" && $obj->InviteUsers != null) {
                $streamObj->InviteUsers =$obj->InviteUsers;
                $streamObj->InviteMessage = $obj->InviteMessage;
            } else {
                $streamObj->InviteUsers = array();
                $streamObj->InviteMessage = "";
            }
            $streamObj->HashTagPostUserId = $obj->HashTagPostUserId;

            $streamObj->LoveCount = (int) $obj->LoveCount;
            $streamObj->CommentCount = (int) $obj->CommentCount;
            $streamObj->FollowCount = (int) $obj->FollowCount;
            $streamObj->InviteCount = (int) $obj->InviteCount;
            $streamObj->ShareCount = (int) $obj->ShareCount;

            if ($streamObj->PostType == 2) {
                
                $streamObj->StartDate = new MongoDate($obj->StartDate);
                $streamObj->EndDate = new MongoDate($obj->EndDate);
                $streamObj->EventAttendes = (int)$obj->UserId;
                $streamObj->Location = $obj->Location;
                $streamObj->StartTime = $obj->StartTime;
                $streamObj->EndTime = $obj->EndTime;
            }

            if ($streamObj->PostType == 3) {
                $streamObj->ExpiryDate = new MongoDate($obj->ExpiryDate);  

                if ($obj->SurveyTaken != "" && $obj->SurveyTaken != null) {
                    $streamObj->SurveyTaken = (int)$obj->UserId;
                } else {
                    $streamObj->SurveyTaken = array();
                }
                $streamObj->OptionOne = $obj->OptionOne;
                $streamObj->OptionTwo = $obj->OptionTwo;
                $streamObj->OptionThree = $obj->OptionThree;
                $streamObj->OptionFour = $obj->OptionFour;
                $streamObj->OptionOneCount = $obj->OptionOneCount;
                $streamObj->OptionTwoCount = $obj->OptionTwoCount;
                $streamObj->OptionThreeCount = $obj->OptionThreeCount;
                $streamObj->OptionFourCount = $obj->OptionFourCount;
            }
            if ($streamObj->PostType == 5) {
                $streamObj->CurbsideConsultTitle = $obj->CurbsideConsultTitle;
                $streamObj->CurbsideConsultCategory = $obj->CurbsideConsultCategory;
                $streamObj->CurbsideCategoryId = (int)$obj->CurbsideCategoryId;
                $streamObj->CurbsidePostCount = $obj->CurbsidePostCount;
            }
            $streamObj->Priority = $obj->Priority;
            //     $utc_str = gmdate("Y-m-d H:i:s", time());
            $streamObj->IsBlockedWordExist = (int) $obj->IsBlockedWordExist;
            if(isset($obj->IsBlockedWordExistInComment) && !empty($obj->IsBlockedWordExistInComment)){
                $streamObj->IsBlockedWordExistInComment = $obj->IsBlockedWordExistInComment;
            }
            $streamObj->CreatedOn = $obj->CreatedOn;
            $streamObj->DisableComments = $obj->DisableComments;
            $streamObj->Division= (int)$obj->Division;
            $streamObj->District= (int)$obj->District;
            $streamObj->Region= (int)$obj->Region;
            $streamObj->Store= (int)$obj->Store;
            $streamObj->Title= $obj->Title;
         //   $streamObj->Title= $obj->Title;
                  if ($obj->CategoryType == 8) {
                $streamObj->HtmlFragment = $obj->HtmlFragment;
                $streamObj->TopicId = $obj->TopicId;
                $streamObj->Released = $obj->Released;
                $streamObj->Editorial = $obj->Editorial;
                $streamObj->PublisherSource = $obj->PublisherSource;
                $streamObj->PublicationTime = $obj->PublicationTime;
                $streamObj->PublicationDate = $obj->PublicationDate;
                $streamObj->PublisherSourceUrl = $obj->PublisherSourceUrl;
                $streamObj->TopicName = $obj->TopicName;
                $streamObj->Alignment = $obj->Alignment;
                $streamObj->Title = $obj->Title;
                $streamObj->TopicImage = $obj->TopicImage;
                $streamObj->IsNotifiable = $obj->IsNotifiable;
            }

              if ($obj->CategoryType == 9) {
                $streamObj->GameName = $obj->GameName;
                $streamObj->GameDescription = $obj->GameDescription;
               // $streamObj->PostFollowers = $obj->PostFollowers;
                // $streamObj->QuestionsCount =  $obj->QuestionsCount;
                $streamObj->PlayersCount = $obj->PlayersCount;
                // $streamObj->CurrentGameScheduleId=new MongoId($obj->CurrentGameScheduleId);
                $streamObj->GameBannerImage = $obj->GameBannerImage;
                $streamObj->StartDate = $obj->StartDate;
                $streamObj->EndDate = $obj->EndDate;
                $streamObj->IsNotifiable = $obj->IsNotifiable;
                 $streamObj->IsSaveItForLater= $obj->IsSaveItForLater;

                if ($obj->ActionType == "Play") {
                    $streamObj->CurrentScheduledPlayers=array($obj->CurrentScheduledPlayers);
                }
            }
              if ($obj->CategoryType == 10) {
                
                  $streamObj->PostText=$obj->PostText; 
                  $streamObj->BadgeName=$obj->BadgeName; 
                   $streamObj->Title=$obj->Title; 
                   $streamObj->BadgeLevelValue=$obj->BadgeLevelValue;
                    $streamObj->BadgeHasLevel=$obj->BadgeHasLevel;
              }              
              $streamObj->Miscellaneous = (int)$obj->Miscellaneous;              

            if ($streamObj->save()) {
                
            }
            

        } catch (Exception $ex) {
            echo "#####Exception occurred######".$ex->getMessage();
            Yii::log("UserActivityCollection:saveUserActivityForPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author Vamsi Krishna
     * @description this method is used to save the user to user follow and unfollow activity
     * @param type $obj
     */
    public function userFollowUnFollowActivity($obj){
        try {          
          
                $streamObj = new UserActivityCollection();
                $streamObj->UserId = $obj->UserId;
                $streamObj->NetworkId = (int) $obj->NetworkId;
                if(isset($obj->FollowOn) && !empty($obj->FollowOn)){
                    $streamObj->CreatedOn = $obj->FollowOn;
                    $streamObj->FollowOn = $obj->FollowOn; 
                }else{
                    $streamObj->FollowOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                }
                $streamObj->FollowEntity=(int)$obj->FollowEntity;
                $streamObj->CategoryType=(int)$obj->CategoryType;
                $streamObj->FollowEntity=(int)$obj->FollowEntity;
                $streamObj->PostType=(int)$obj->PostType;
                 $streamObj->RecentActivity=$obj->RecentActivity;
                 $streamObj->PostId=new MongoId($obj->PostId);
                
           if ($obj->ActionType == "UserFollow" || $obj->ActionType == "UserUnFollow" ) {
                $streamObj->FollowUserId = (int) $obj->UserFollowers;
                $streamObj->StreamNote = CommonUtility::actionTextbyActionType($obj->ActionType);
            } else if ($obj->ActionType == "GroupFollow" || $obj->ActionType == "GroupUnfollow") {
                $streamObj->StreamNote = CommonUtility::actionTextbyActionType($obj->ActionType);
                $streamObj->GroupId = new MongoId($obj->GroupId);
                $streamObj->Miscellaneous = (int)$obj->Miscellaneous;
            } else if ($obj->ActionType == "HashTagFollow" || $obj->ActionType == "HashTagUnFollow") {
                $streamObj->StreamNote = CommonUtility::actionTextbyActionType($obj->ActionType);
                $streamObj->HashTagId = new MongoId($obj->HashTagId);
                $streamObj->HashTagName = $obj->HashTagName;
                $streamObj->HashTagPostCount = (int) $obj->HashTagPostCount;
               // UserActivityCollection::model()->useFollowActivity($obj);
            } else if ($obj->ActionType == "CurbsideCategoryFollow" || $obj->ActionType == "CurbsideCategoryUnFollow") {
                $streamObj->CurbsideConsultCategory = $obj->CurbsideConsultCategory;
                $streamObj->CurbsideCategoryId = (int)$obj->CurbsideCategoryId;
                $streamObj->StreamNote = CommonUtility::actionTextbyActionType($obj->ActionType);
                  $streamObj->CurbsidePostCount=$obj->CurbsidePostCount;
              //  UserActivityCollection::model()->useFollowActivity($obj);
            }
            if ($streamObj->save()) {
                //echo 'saved ---Hurray';
            }
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:userFollowUnFollowActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   
    /**
    * @Author Praneeth
    * This method is used to get user visited groups
    * @param type $userId,$date
    * @return type tiny user collection object
    */
    public function getNewUserFollowingMembers($userId,$date)
    {       
        try
        {   
            $current_datetime=new MongoDate(strtotime(date('Y-m-d H:i:s')));
             if(empty($date)){
                $previous_logintime = new MongoDate(strtotime(date('Y-m-d H:i:s')));
            }else{
                $previous_logintime = new MongoDate($date);
            }  

            $array = array(
                'sort' => array('FollowOn' => EMongoCriteria::SORT_DESC),
            );
            $criteria = new EMongoCriteria($array); 
            $criteria = new EMongoCriteria;  
            //$criteria->setSelect(array('UserId'=>true));
            $criteria->addCond('FollowUserId', '==', (int)$userId);
            $criteria->addCond('RecentActivity', '==', 'UserFollow');
            //$criteria->addCond('FollowOn', '>=', $previous_logintime);
            //$criteria->addCond('FollowOn', '<=', $current_datetime);
            $criteria->limit(5);
            $objFollowers=UserActivityCollection::model()->findAll($criteria);
            return $objFollowers;
        } catch (Exception $ex) {
                Yii::log("UserActivityCollection:getNewUserFollowingMembers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
    * @Author Praneeth
    * This method is used to get Events the user is attending
    * @param type $userId,$date
    * @return type tiny user collection object
    */
    public function getUserEventsAttendingActivity($userId,$CurrentLoginDate)
    {       
        try
        {   
             if(empty($CurrentLoginDate)){
                $date_C = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            }else{
                $date_C = new MongoDate($CurrentLoginDate);
            }           
            $criteria = new EMongoCriteria;  
            $criteria->addCond('UserId', '==', (int)$userId);
            $criteria->addCond('PostType', '==',(int)2);
            $criteria->addCond('EndDate', '>=', $date_C);
            $criteria->addCond('ActionType', '==', "EventAttend");
            $criteria->addCond('IsBlockedWordExistInComment', 'notin', array(1,2));
            $criteria->addCond('IsBlockedWordExist', 'notin', array(1,2));
            $criteria->addCond('IsDeleted', '!=', 1);
            $criteria->addCond('IsAbused', 'notin', array(1,2));
            $objFollowers=UserActivityCollection::model()->findAll($criteria);
            return $objFollowers;
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:getUserEventsAttendingActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    
        /**
     * author: Suresh Reddy
     * @param type $postId
     * @param type $userId
     * @return type actvity object
     */

    public function getActvityObjbyPostId($postId, $userId,$categoryType) {
        try {
            $criteria = new EMongoCriteria;
            $criteria->addCond('UserId', '==', (int) $userId);
            $criteria->addCond('PostId', '==', new MongoID($postId));
            $criteria->addCond('CategoryType', '==', (int)$categoryType);
            
            $streamObj = UserActivityCollection::model()->find($criteria);
            return $streamObj;
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:getActvityObjbyPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     /**
   * @author vamsi krishna 
   *  This method is used to get the user activity
   * @param type $id
   * @param type $recentActivity
   * @return string
   */ 
    public function getUserActivityByType($userId,$followUserId=0,$categoryFollow=0,$hashtagFollow=0,$groupFollow=0,$actionType,$postId=0,$categoryId=0) {
        $returnValue = 'failure';
        try {
           
            $mongoCriteria = new EMongoCriteria;
            
            
            if($followUserId!=0){
             $mongoCriteria->addCond('FollowUserId', '==', (int)$followUserId);    
            }
            if($categoryFollow!=0){
                if($actionType=='CurbsideCategoryFollow'){
                 $mongoCriteria->addCond('RecentActivity', '==', 'CurbsideCategoryUnFollow');         
                }else{
                 $mongoCriteria->addCond('RecentActivity', '==', 'CurbsideCategoryFollow');            
                }
             
             $mongoCriteria->addCond('CurbsideCategoryId', '==', (int)$categoryFollow);    
            }
            if($hashtagFollow!=0){
               if($actionType=='HashTagFollow'){
                 $mongoCriteria->addCond('RecentActivity', '==', 'HashTagUnFollow');         
                }else{
                 $mongoCriteria->addCond('RecentActivity', '==', 'HashTagFollow');            
                }
             $mongoCriteria->addCond('HashTagId', '==', new MongoId($hashtagFollow));    
            }
             if($groupFollow!=0){ 
                 
               if($actionType=='GroupFollow'){
                 $mongoCriteria->addCond('RecentActivity', '==', 'GroupUnFollow');         
                }else{
                 $mongoCriteria->addCond('RecentActivity', '==', 'GroupFollow');            
                }  
                 
             $mongoCriteria->addCond('GroupId', '==', new MongoId($groupFollow));    
            }
            
            if($postId!=0){ 
               if($actionType=='Follow'){
                 $mongoCriteria->addCond('RecentActivity', '==', 'UnFollow');         
                }else{
                 $mongoCriteria->addCond('RecentActivity', '==', 'Follow');            
                }
           
             $mongoCriteria->addCond('CategoryType', '==', (int)$categoryId);    
             $mongoCriteria->addCond('PostId', '==', new MongoId($postId));    
            }
            
            
            $mongoCriteria->addCond('UserId', '==', (int)$userId);
            $userActivity= UserActivityCollection::model()->find($mongoCriteria);
            if(is_array($userActivity) || is_object($userActivity)){
                $returnValue=$userActivity;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:getUserActivityByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
  /**
   * @author vamsi krishna 
   *  This method is used to update the user activity
   * @param type $id
   * @param type $recentActivity
   * @return string
   */  
    public function updateUserActivityForUserFollow($id,$recentActivity, $createdDate='') {
        $returnValue='failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $date='';
            if(isset($createdDate) && !empty($createdDate)){
                $date = $createdDate;
            }else{
                $date = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            }
            if($recentActivity == "UserFollow" || $recentActivity== "UserUnFollow"){
             $streamNote = CommonUtility::actionTextbyActionType($recentActivity);
             $mongoModifier->addModifier('StreamNote', 'set', $streamNote);
             $mongoModifier->addModifier('RecentActivity', 'set', $recentActivity);
             $mongoModifier->addModifier('ActionType', 'set', $recentActivity);
             $mongoModifier->addModifier('CreatedOn', 'set', $date);
             
            }
            if($recentActivity == "CurbsideCategoryFollow" || $recentActivity== "CurbsideCategoryUnFollow"){
             $streamNote = CommonUtility::actionTextbyActionType($recentActivity);
             $mongoModifier->addModifier('StreamNote', 'set', $streamNote);
             $mongoModifier->addModifier('RecentActivity', 'set', $recentActivity);
             $mongoModifier->addModifier('ActionType', 'set', $recentActivity);
             $mongoModifier->addModifier('CreatedOn', 'set', $date);
            }
            if($recentActivity == "HashTagFollow" || $recentActivity== "HashTagUnFollow"){
                $streamNote = CommonUtility::actionTextbyActionType($recentActivity);
             $mongoModifier->addModifier('StreamNote', 'set', $streamNote);
             $mongoModifier->addModifier('RecentActivity', 'set', $recentActivity);
             $mongoModifier->addModifier('ActionType', 'set', $recentActivity);
             $mongoModifier->addModifier('CreatedOn', 'set', $date);
            }
            if($recentActivity == "Groupfollow" || $recentActivity== "GroupUnfollow"){
             $streamNote = CommonUtility::actionTextbyActionType($recentActivity);
             $mongoModifier->addModifier('StreamNote', 'set', $streamNote);
             $mongoModifier->addModifier('RecentActivity', 'set', $recentActivity);
             $mongoModifier->addModifier('ActionType', 'set', $recentActivity);
             $mongoModifier->addModifier('CreatedOn', 'set', $date);
            }
             if($recentActivity == "Follow" || $recentActivity== "UnFollow"){
             $streamNote = CommonUtility::actionTextbyActionType($recentActivity);
             $mongoModifier->addModifier('StreamNote', 'set', $streamNote);
             $mongoModifier->addModifier('RecentActivity', 'set', $recentActivity);
             $mongoModifier->addModifier('ActionType', 'set', $recentActivity);
             $mongoModifier->addModifier('CreatedOn', 'set', $date);
            }
            
            
            $mongoCriteria->addCond('_id', '==', new MongoId($id)); 
            $returnValue = UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:updateUserActivityForUserFollow::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    
     public function updateActvitySocialActions($obj) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if (isset($obj->LoveUserId) && $obj->LoveUserId != "" && $obj->LoveUserId != 0) {
                $mongoModifier->addModifier('LoveUserId', 'push', $obj->LoveUserId);
            }
            if ($obj->ActionType == "FbShare") {
                if (isset($obj->FbShare) && $obj->FbShare != "" && $obj->FbShare != 0) {
                    $mongoModifier->addModifier('FbShare', 'push', $obj->FbShare);
                }
            }
            if ($obj->ActionType == "TwitterShare") {
                if (isset($obj->TwitterShare) && $obj->TwitterShare != "" && $obj->TwitterShare != 0) {
                    $mongoModifier->addModifier('TwitterShare', 'push', $obj->TwitterShare);
                }
            }
            $mongoCriteria->addCond('PostId', '==', new MongoID($obj->PostId));
            $mongoCriteria->addCond('CategoryType', '==', (int) $obj->CategoryType);
            $mongoModifier->addModifier('LoveCount', 'set', $obj->LoveCount);
            $mongoModifier->addModifier('InviteCount', 'set', $obj->InviteCount);
            $mongoModifier->addModifier('ShareCount', 'set', $obj->ShareCount);
            $mongoModifier->addModifier('FollowCount', 'set', $obj->FollowCount);

            $mongoModifier->addModifier('CommentCount', 'set', $obj->CommentCount);
            UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:updateActvitySocialActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

    }
    /**
     * @author suresh reddy
     * @param type $obj
     */
     public function followObject($obj) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('PostId', '==', new MongoID($obj->PostId));
            $mongoModifier->addModifier('PostFollowers', 'push', (int)$obj->UserId);
            
            $mongoModifier->addModifier('LoveCount', 'set', $obj->LoveCount);
            $mongoModifier->addModifier('InviteCount', 'set', $obj->InviteCount);
            $mongoModifier->addModifier('ShareCount', 'set', $obj->ShareCount);
            $mongoModifier->addModifier('FollowCount', 'set', $obj->FollowCount);
            $mongoModifier->addModifier('CommentCount', 'set', $obj->CommentCount);
            
            
          //  $mongoModifier->addModifier('CreatedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time())))); 
            UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:followObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

    }
    
    
        /**
     * @author suresh reddy
     * @param type $obj
     */
     public function unFollowObject($obj) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('PostId', '==', new MongoID($obj->PostId));
            $mongoModifier->addModifier('PostFollowers', 'pop', (int)$obj->UserId);
            
            $mongoModifier->addModifier('LoveCount', 'set', $obj->LoveCount);
            $mongoModifier->addModifier('InviteCount', 'set', $obj->InviteCount);
            $mongoModifier->addModifier('ShareCount', 'set', $obj->ShareCount);
            $mongoModifier->addModifier('FollowCount', 'set', $obj->FollowCount);
            $mongoModifier->addModifier('CommentCount', 'set', $obj->CommentCount);
            
            
          //  $mongoModifier->addModifier('CreatedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time())))); 
            UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:unFollowObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

    }
 
  
     /**
     * author: Suresh Reddy
     * @param type $postId
     * @param type $userId
     * @return type stream object
     */

    public function updatePostActvityObject($obj, $streamObjectId, $userId,$actionType='Post') {
     
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('CreatedOn', 'set', $obj->CreatedOn); 
            if($actionType=="UserFollow"){
              $mongoModifier->addModifier('UserFollowers', 'push', $obj->UserFollowers);    
            }
            
             if($actionType=="PostFollow"){
                 
              $mongoModifier->addModifier('PostFollowers', 'push', $obj->PostFollowers);    
            }
             
            if($actionType=="UserMention"){
              $mongoModifier->addModifier('MentionUserId', 'set',  (int)$obj->MentionUserId);    
            }
            
             if($actionType=="HashTagFollow"){
              $mongoModifier->addModifier('HashTagPostUserId', 'set', (int) $obj->HashTagPostUserId);    
                
            }
            
          if($actionType=="EventAttend"){
              $mongoModifier->addModifier('EventAttendes', 'set', (int) $obj->EventAttendes);    
                
            }
            if($actionType=="FbShare"){
              $mongoModifier->addModifier('FbShare', 'set', (int) $obj->FbShare);    
                
            }
            if($actionType=="TwitterShare"){
              $mongoModifier->addModifier('TwitterShare', 'set', (int) $obj->TwitterShare);    
                
            }
             if($actionType=="SaveItForLater"){
              $mongoModifier->addModifier('IsSaveItForLater', 'set', (int) $obj->IsSaveItForLater);    
                
            }
              if($actionType=="Invite"){
                  $inviteUser='';
                  foreach($obj->InviteUsers as $user){
                      $inviteUser=$user;
                      break;
                  }
              $mongoModifier->addModifier('InviteUsers', 'set',  $inviteUser);    
               $mongoModifier->addModifier('InviteMessage', 'set', $obj->InviteMessage);   
                
            }
                 if ($actionType == "Survey") {
                $mongoModifier->addModifier('SurveyTaken', 'set', (int) $obj->SurveyTaken);
                $mongoModifier->addModifier('OptionOneCount', 'set', (int) $obj->OptionOneCount);
                $mongoModifier->addModifier('OptionTwoCount', 'set', (int) $obj->OptionTwoCount);
                $mongoModifier->addModifier('OptionThreeCount', 'set', (int) $obj->OptionThreeCount);
                $mongoModifier->addModifier('OptionFourCount', 'set', (int) $obj->OptionFourCount);
            }

            if($actionType=="Comment"){
              $mongoModifier->addModifier('CommentUserId', 'push',  (int)$userId); 
               $obj->Comments['CommentId'] = new MongoId($obj->Comments['CommentId']);
               $mongoModifier->addModifier('Comments', 'push',  $obj->Comments); 
               if(isset($obj->IsBlockedWordExistInComment) && !empty($obj->IsBlockedWordExistInComment)){
                    $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', (int) $obj->IsBlockedWordExistInComment);
                }
             }
              if($actionType=="Love"){
              $mongoModifier->addModifier('LoveUserId', 'push',  (int)$obj->LoveUserId); 
             }
               if($actionType=="Playing"){
                $mongoModifier->addModifier('PlayersCount', 'set', $obj->PlayersCount);
                $mongoModifier->addModifier('ResumeUsers', 'push',(int)$obj->UserId);
             }
              if ($actionType == "Play") {              
                                   
                    $mongoModifier->addModifier('PlayedUsers', 'push', $obj->PlayedUsers);
              
            }
              
            $mongoModifier->addModifier('ActionType', 'set', $obj->ActionType);
            $mongoModifier->addModifier('StreamNote', 'set', $obj->StreamNote);
            $mongoModifier->addModifier('RecentActivity', 'set', $obj->RecentActivity);
            
            
             $mongoModifier->addModifier('LoveCount', 'set',  $obj->LoveCount); 
             $mongoModifier->addModifier('InviteCount', 'set',  $obj->InviteCount); 
             $mongoModifier->addModifier('ShareCount', 'set',  $obj->ShareCount); 
             $mongoModifier->addModifier('FollowCount', 'set',  $obj->FollowCount); 
             $mongoModifier->addModifier('CommentCount', 'set',  $obj->CommentCount);
           
             
            
            $mongoCriteria->addCond('_id', '==', new MongoId($streamObjectId));
            $mongoCriteria->addCond('UserId', '==', (int) $userId);
            $res = UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);


            return $res;
        } catch (Exception $ex) {
         Yii::log("UserActivityCollection:updatePostActvityObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    
         /**
     * author: Suresh Reddy
     * @param type $postId
     * @param type $userId
     * @return type actvity object
     */

    public function getEngageObjbyPostId($postId, $userId,$categoryType) {
        try {
            $criteria = new EMongoCriteria;
            $criteria->addCond('UserId', '==', (int) $userId);
            $criteria->addCond('PostId', '==', new MongoID($postId));
            $criteria->addCond('CategoryType', '==', (int)$categoryType);
               $criteria->addCond('RecentActivity', '!=', "Invite");
            $streamObj = UserActivityCollection::model()->find($criteria);
            return $streamObj;
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:getEngageObjbyPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * @author sagar
     * @usage update post management action like  delete, abuse, release  
     */
    
     public function updatePostManagementActions($obj) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('PostId', '==', new MongoID($obj->PostId));
            $mongoCriteria->addCond('CategoryType', '==', (int)$obj->CatagoryId);
            $mongoCriteria->addCond('NetworkId', '==', (int)$obj->NetworkId);
           if ($obj->ActionType == 'Abuse') {
                $mongoModifier->addModifier('IsAbused', 'set', 1);
                $mongoModifier->addModifier('AbusedUserId', 'set', (int) $obj->UserId);
                $mongoModifier->addModifier('AbusedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
            } elseif ($obj->ActionType == "Block") {
                if($obj->IsBlockedWordExist==0){
                    $mongoModifier->addModifier('IsAbused', 'set', 2);
                 }else{
                     $mongoModifier->addModifier('IsBlockedWordExist', 'set', 2);
                 }
            } elseif ($obj->ActionType == "Release") {
                if($obj->IsBlockedWordExist==0){
                    $mongoModifier->addModifier('IsAbused', 'set', 0);
                 }else{
                     $mongoModifier->addModifier('IsBlockedWordExist', 'set', 0);
                 }
            } elseif ($obj->ActionType == "Promote") {
                $mongoModifier->addModifier('IsPromoted', 'set', 1);
                $mongoModifier->addModifier('PromotedUserId', 'set', (int) $obj->UserId);
                $mongoModifier->addModifier('CreatedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
                $mongoCriteria->addCond('UserId', '==', 0);
            } elseif ($obj->ActionType == "Delete") {
                $mongoModifier->addModifier('IsDeleted', 'set', 1);
            }
             elseif ($obj->ActionType=="Featured") {
                $mongoModifier->addModifier('FeaturedUserId', 'set', (int)$obj->UserId);
                $mongoModifier->addModifier('IsFeatured', 'set', (int)1);
            }
            elseif ($obj->ActionType=="NewsNotify") {
                $mongoModifier->addModifier('IsNotifiable', 'set',(int)$obj->IsNotifiable);
               $mongoModifier->addModifier('CreatedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
            }
           
            UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:updatePostManagementActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author sagar
     * @usage update comment management action like  block / release  
     */
    
      public function updateCommentManagementActions($obj) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('PostId', '==', new MongoID($obj->PostId));
            $mongoCriteria->Comments->CommentId("==" ,new MongoID($obj->CommentId));
            $mongoCriteria->addCond('CategoryType', '==', (int)$obj->CatagoryId);
            
            if ($obj->ActionType == 'AbuseComment') {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 1);
                $mongoModifier->addModifier('Comments.$.AbusedUserId', 'set', (int) $obj->UserId);
                $mongoModifier->addModifier('AbusedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
                $mongoModifier->addModifier('CommentCount', 'inc',  -1);
            } elseif ($obj->ActionType == "BlockAbusedComment") {//for abuse
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 2);
            } elseif ($obj->ActionType == "ReleaseAbusedComment") {//for abuse
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 0);
            } elseif ($obj->ActionType == "CommentBlock") {//for block words
                $mongoModifier->addModifier('Comments.$.IsBlockedWordExist', 'set', 2);
            } elseif ($obj->ActionType == "CommentRelease") {//for block words
                $mongoModifier->addModifier('Comments.$.IsBlockedWordExist', 'set', 0);
            }elseif ($obj->ActionType =="AbuseCommentForSuspendedUser") {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 3);
             }
            $returnValue = UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            if($obj->ActionType != 'AbuseComment' && $returnValue){
                $criteria = new EMongoCriteria;
                $criteria->addCond('PostId', '==', new MongoId($obj->PostId));
                if ($obj->ActionType == "CommentBlock" || $obj->ActionType == "CommentRelease") {
                    $criteria->Comments->IsBlockedWordExist("==" ,1); 
                }else{
                    $criteria->Comments->IsAbused("==" ,1); 
                }
                $resobj = UserActivityCollection::model()->findAll($criteria);
                if (!(is_array($resobj) && sizeof($resobj)>0)) {
                    $criteria = new EMongoCriteria;
                    $criteria->addCond('PostId', '==', new MongoId($obj->PostId));
                    $mongoModifier = new EMongoModifier;  
                    if ($obj->ActionType == "CommentBlock" || $obj->ActionType == "CommentRelease") {
                        $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 0);
                    }else{
                        $mongoModifier->addModifier('IsCommentAbused', 'set', 0);
                    }
                    
                    if ($obj->ActionType == "CommentRelease" || $obj->ActionType == "ReleaseAbusedComment") {
                        $mongoModifier->addModifier('CommentCount', 'inc',  1);
                    }
                    $returnValue=UserActivityCollection::model()->updateAll($mongoModifier,$criteria);
                    if($returnValue){
                        $returnValue = 'PostReleased';
                    }
                }else{
                    if ($obj->ActionType == "CommentRelease" || $obj->ActionType == "ReleaseAbusedComment") {
                        $criteria = new EMongoCriteria;
                        $criteria->addCond('PostId', '==', new MongoId($obj->PostId));
                        $mongoModifier = new EMongoModifier;
                        $mongoModifier->addModifier('CommentCount', 'inc',  1);
                        UserActivityCollection::model()->updateAll($mongoModifier,$criteria);
                    }
                    $returnValue = 'CommentReleased';
                }
             }
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:updateCommentManagementActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
       /**
     * @author suresh reddy
     * @usage suspended game 
     * @param type $obj of game object
     */
  public function suspendorReleaseGame($obj) {
        try {
            $returnValue = array();
            $criteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($obj->ActionType == "SuspendGame") {
                
               
                if ($obj->RecentActivity == "PartialUpdate") {
                    if ($obj->CurrentGameScheduleId == "") {
                        $mongoModifier->addModifier('CurrentGameScheduleId', 'set', "");
                    } else {
                        $mongoModifier->addModifier('CurrentGameScheduleId', 'set', '');
                    }

                    $mongoModifier->addModifier('PreviousGameScheduleId', 'set', '');
                    $mongoModifier->addModifier('CurrentScheduledPlayers', 'set', array());
                    $mongoModifier->addModifier('CurrentScheduleResumePlayers', 'set', array());



                    $mongoModifier->addModifier('StartDate', 'set', '');
                    $mongoModifier->addModifier('EndDate', 'set', '');
                } else {

                    if ($obj->CurrentGameScheduleId == "") {
                        $mongoModifier->addModifier('CurrentGameScheduleId', 'set', "");
                    } else {
                        $mongoModifier->addModifier('CurrentGameScheduleId', 'set', new MongoId($obj->CurrentGameScheduleId));
                    }

                    $mongoModifier->addModifier('PreviousGameScheduleId', 'set', "");
                    $mongoModifier->addModifier('CurrentScheduledPlayers', 'set', $obj->CurrentScheduledPlayers);
                    $mongoModifier->addModifier('CurrentScheduleResumePlayers', 'set', $obj->CurrentScheduleResumePlayers);



                    $mongoModifier->addModifier('StartDate', 'set', new MongoDate($obj->StartDate));
                    $mongoModifier->addModifier('EndDate', 'set', new MongoDate($obj->EndDate));
                }


                $mongoModifier->addModifier('IsDeleted', 'set', 1);
            } else if ($obj->ActionType == "ReleaseGame") {
                $mongoModifier->addModifier('IsDeleted', 'set', 0);
            } else if ($obj->ActionType == "CancelScheduleGame") {
                
                   if ($obj->RecentActivity == "PartialUpdate") {
                       
                             if ($obj->CurrentGameScheduleId == "") {
                        $mongoModifier->addModifier('CurrentGameScheduleId', 'set', "");
                    } else {
                        $mongoModifier->addModifier('CurrentGameScheduleId', 'set', '');
                    }

                    $mongoModifier->addModifier('PreviousGameScheduleId', 'set', '');
                    $mongoModifier->addModifier('CurrentScheduledPlayers', 'set', array());
                    $mongoModifier->addModifier('CurrentScheduleResumePlayers', 'set', array());



                    $mongoModifier->addModifier('StartDate', 'set', '');
                    $mongoModifier->addModifier('EndDate', 'set', '');
                       
                   }
                   else{
                
                
                
                if ($obj->CurrentGameScheduleId == "") {
                    $mongoModifier->addModifier('CurrentGameScheduleId', 'set', "");
                } else {
                    $mongoModifier->addModifier('CurrentGameScheduleId', 'set', new MongoId($obj->CurrentGameScheduleId));
                }

                $mongoModifier->addModifier('PreviousGameScheduleId', 'set', "");
                $mongoModifier->addModifier('CurrentScheduledPlayers', 'set', $obj->CurrentScheduledPlayers);
                $mongoModifier->addModifier('CurrentScheduleResumePlayers', 'set', $obj->CurrentScheduleResumePlayers);

                $mongoModifier->addModifier('StartDate', 'set', new MongoDate($obj->StartDate));
                $mongoModifier->addModifier('EndDate', 'set', new MongoDate($obj->EndDate));
                $mongoModifier->addModifier('IsDeleted', 'set', 0);
            }
            }
            $mongoModifier->addModifier('IsNotifiable', 'set', (int) $obj->IsNotifiable);
            $criteria->addCond('PostId', '==', new MongoId($obj->PostId));
            UserActivityCollection::model()->updateAll($mongoModifier, $criteria);
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:suspendorReleaseGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   public function updatePartialUserStreamForGame($obj){
        $result='failure';
       try {     
         
         $criteria = new EMongoCriteria;
         $mongoModifier = new EMongoModifier;
        // $startDate = DateTime::createFromFormat(Yii::app()->params['PHPDateFormat'], $obj->StartDate)->format("Y-m-d");
        // $endDate = DateTime::createFromFormat(Yii::app()->params['PHPDateFormat'], $obj->EndDate)->format("Y-m-d");
         $mongoModifier->addModifier('StartDate','set',new MongoDate(strtotime($obj->StartDate)));
         $mongoModifier->addModifier('EndDate','set',new MongoDate(strtotime($obj->EndDate)));         
         $mongoModifier->addModifier('CurrentGameScheduleId', 'set', new MongoId($obj->CurrentGameScheduleId));
         $mongoModifier->addModifier('CreatedOn','set',$obj->CreatedOn);         
         $mongoModifier->addModifier('IsNotifiable', 'set', (int)1);         
         $criteria->addCond('PostId', '==', new MongoId($obj->PostId));         
         UserActivityCollection::model()->updateAll($mongoModifier,$criteria);
         $result='success';
         return $result;
     } catch (Exception $ex) {         
      Yii::log("UserActivityCollection:updatePartialUserStreamForGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        return $result;
     }
  }
  public function updateStreamForGameSchedule($obj){
       $returnValue = 'success'; 
      try {          
            $criteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('CurrentGameScheduleId', 'set', new MongoId($obj->CurrentGameScheduleId));
            $mongoModifier->addModifier('PreviousGameScheduleId', 'set', new MongoId($obj->PreviousGameScheduleId));
            $mongoModifier->addModifier('CurrentScheduledPlayers', 'set', $obj->CurrentScheduledPlayers);
            $mongoModifier->addModifier('CurrentScheduleResumePlayers', 'set', $obj->CurrentScheduleResumePlayers);
            $mongoModifier->addModifier('PreviousSchedulePlayers', 'set', $obj->PreviousSchedulePlayers);
            $mongoModifier->addModifier('PreviousScheduleResumePlayers', 'set', $obj->PreviousScheduleResumePlayers);
            $mongoModifier->addModifier('IsNotifiable', 'set', (int)1);
            $mongoModifier->addModifier('CreatedOn', 'set', $obj->CreatedOn);
            $criteria->addCond('PostId', '==', new MongoId($obj->PostId));
            
        UserActivityCollection::model()->updateAll($mongoModifier,$criteria);
        return $returnValue;
        
      } catch (Exception $ex) {          
          Yii::log("UserActivityCollection:updateStreamForGameSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return $returnValue;
      }
    }
     public function updateStreamForGameDetails($Gameobj){
       $returnValue = 'success'; 
      try {          
         
            $criteria = new EMongoCriteria;
            $modifier = new EMongoModifier();
            $criteria->addCond('PostId', '==', new MongoID($Gameobj->GameId));
            $modifier->addModifier('GameDescription', 'set', $Gameobj->GameDescription);
            $modifier->addModifier('GameName', 'set', $Gameobj->GameName);
            
           
        if(UserActivityCollection::model()->updateAll($modifier,$criteria)){
           
             $returnValue = 'success'; 
        }else{
            $returnValue = 'failure'; 
        }
       
        return $returnValue;
        
      } catch (Exception $ex) {          
          Yii::log("UserActivityCollection:updateStreamForGameDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return $returnValue;
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
            $returnValue = UserActivityCollection::model()->updateAll($mongoModifier, $criteria);
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:updateSegmentIdNetworkIdByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    /**@author Vamsi
     * This method is used to update the ACtivity stream when group in active and inactive  
     * @param type $obj
     */
  public function updateStreamForGroupInactiveAndActive($obj) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond("GroupId", "==", new MongoID($obj->GroupId));
            if($obj->ActionType=="GroupInactive"){
            $mongoModifier->addModifier('IsNotifiable', 'set', (int)0);
            }else{
            $mongoModifier->addModifier('IsNotifiable', 'set', (int)1);    
            }
            UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:updateStreamForGroupInactiveAndActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
          /**@author Vamsi
     * This method is used to update the stream when group in active and inactive  
     * @param type $obj
     */
  public function updateStreamForSubGroupInactiveAndActive($obj) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond("SubGroupId", "==", $obj->GroupId);
            if($obj->ActionType=="SubGroupInactive"){
            $mongoModifier->addModifier('IsNotifiable', 'set', (int)0);
            }else{
            $mongoModifier->addModifier('IsNotifiable', 'set', (int)1);    
            }
            UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:updateStreamForSubGroupInactiveAndActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
         /**
     * This method is used to update the stream with IsDeleted=2 
     * All the suspended user activities will be deleted 
     * @param type $userId
     */
    
 public function updatePostsForSuspendedUser($userId){
     try {
         $mongoCriteria = new EMongoCriteria;
         $mongoModifier = new EMongoModifier;
         $mongoModifier->addModifier('IsDeleted', 'set', (int)2);
         $mongoCriteria->addCond('OriginalUserId', '==', (int)$userId);
         $mongoCriteria->addCond('IsDeleted', '==', (int)0);
         UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
     } catch (Exception $ex) {
         Yii::log("UserActivityCollection:updatePostsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
    /**
     * This method is used to update the stream with IsDeleted=0
     * All the suspended user activities will be replaced once he is active again 
     * @param type $userId
     */
    
 public function releasePostsForSuspendedUser($userId){
     try {
         $mongoCriteria = new EMongoCriteria;
         $mongoModifier = new EMongoModifier;
         $mongoModifier->addModifier('IsDeleted', 'set', (int)0);
         $mongoCriteria->addCond('OriginalUserId', '==', (int)$userId);
         $mongoCriteria->addCond('IsDeleted', '==', (int)2);
         UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
     } catch (Exception $ex) {
         Yii::log("UserActivityCollection:releasePostsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  } 
  public function removeCommentsForSuspendedUser($userId) {
        try {
             $mongoCriteria = new EMongoCriteria;
              $mongoModifier = new EMongoModifier;
             $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 3);
                $mongoModifier->addModifier('Comments.$.AbusedUserId', 'set', (int) $userId);
                $mongoModifier->addModifier('AbusedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
                $mongoModifier->addModifier('CommentCount', 'inc',  -1);       
             $mongoCriteria->Comments->IsAbused("==" ,(int)0); 
                 $mongoCriteria->Comments->UserId("==" ,(int)$userId); 
                 
                 
                 UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:removeCommentsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserActivityCollection->removeCommentsForSuspendedUser==".$ex->getMessage());
            
        }
    }
    
    public function releaseCommentsForSuspendedUser($userId) {
        try {
             $mongoCriteria = new EMongoCriteria;
              $mongoModifier = new EMongoModifier;
             $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 0);                                
                $mongoModifier->addModifier('CommentCount', 'inc',  +1);       
             $mongoCriteria->Comments->IsAbused("==" ,(int)3); 
                 $mongoCriteria->Comments->UserId("==" ,(int)$userId); 
                 
                 
                 UserActivityCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("UserActivityCollection:releaseCommentsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserActivityCollection->releaseCommentsForSuspendedUser==".$ex->getMessage());
            
        }
    }
}

?>
