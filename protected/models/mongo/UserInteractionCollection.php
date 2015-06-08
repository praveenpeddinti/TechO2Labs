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

class UserInteractionCollection extends EMongoDocument {
    public $UserId;
    public $CreatedOn;
    public $CreatedDate;
    public $_id;    
    public $RecentActivity;
    public $ActionType;
    public $CategoryType;
    public $PostType;
    public $NetworkId;
    public $CommentUserId=array();
    public $Comments=array();
    public $FollowUserId=array();
    public $MentionUserId;
    public $PostId;
    public $OriginalUserId;
    public $OriginalPostTime;
    public $CommentCount=0;
    public $FollowCount=0;
    public $UserFollowers;
    public $StartDate;
    public $EndDate;
    public $LoveUserId=array();
    public $HashTagPostUserId;
    public $StartTime;
    public $EndTime;
    public $IsAbused=0;//0 - Default/Release, 1 - Abused, 2 - Blocked
    public $AbusedUserId;
    public $IsDeleted=0;
    public $IsPromoted=0;
    public $PromotedUserId;
    public $AbusedOn;
    public $GroupId='';
    public $HashTagId;
    public $HashTagName;
    public $CurbsideCategoryId;
    public $IsBlockedWordExist=0;//0 - Default/Release, 1 - Abused, 2 - Blocked
    public $IsBlockedWordExistInComment=0;
    public $SubGroupId=0;
    public $ProfileId;
    public $projectSearchText;
    public $projectSearchType;
    public $userActivityIndex;
    public $userActivityContext;
    public $pageIndex;
    public $IsComebackUser=0;
    public $TopicImage='';
    public $IsNotifiable=1;
    public $CurrentGameScheduleId;
    public $CareerId;
    public $Language;
    public $SegmentId = 0;
    public $saveItForLaterUserIds = array();
    public $IsSaveItForLater = 0;
/*Analytics End*/
    
    public $WebLinkId;
    public $LinkGroupId;
    public $WebUrl;
    
    public $JobId;
    public $AdId;
    public $Position;
    public $Page;
    public $QuickLinkId;
    public $NotificationId;
    public $Email;

    public $FromLang="";
    public $ToLang="";
    public $CommentId;
    public $HelpIconId;
    public $CustomGroupTab;
    public $RdsUserStatus;
    public $Miscellaneous = 0;

    
    public function getCollectionName() {

        return 'UserInteractionCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
     public function indexes() {
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
            ),
            'index_userActivityIndex' => array(
                'key' => array(
                    'userActivityIndex' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_userActivityContext' => array(
                'key' => array(
                    'userActivityContext' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_pageIndex' => array(
                'key' => array(
                    'pageIndex' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_IsComebackUser' => array(
                'key' => array(
                    'IsComebackUser' => EMongoCriteria::SORT_ASC
                ),
            )
        );
    }
    public function attributeNames() {
        return array(
            '_id' => '_id',
            'UserId' => 'UserId',
            'CreatedOn' => 'CreatedOn',
            'CreatedDate' => 'CreatedDate',
            'PostType' => 'PostType',
            'CategoryType' => 'CategoryType',
            'ActionType' => 'ActionType',
            'RecentActivity' => 'RecentActivity',
            'CommentUserId' => 'CommentUserId',
            'Comments' => 'Comments',
            'FollowUserId' => 'FollowUserId',
            'MentionUserId' => 'MentionUserId',
            'LoveUserId' => 'LoveUserId',
            'OriginalUserId' => 'OriginalUserId',
            'OriginalPostTime' => 'OriginalPostTime',
            'FollowUserId' => 'FollowUserId',
            'PostId' => 'PostId',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'CreatedOn' => 'CreatedOn',
            'UserFollowers' => 'UserFollowers',
            'StartDate' => 'StartDate',
            'EndDate' => 'EndDate',
            'HashTagPostUserId' => 'HashTagPostUserId',
            'CommentCount' => 'CommentCount',
            'StartTime' => 'StartTime',
            'EndTime' => 'EndTime',
            'IsAbused' => 'IsAbused',
            'AbusedUserId' => 'AbusedUserId',
            'IsDeleted' => 'IsDeleted',
            'IsPromoted' => 'IsPromoted',
            'PromotedUserId' => 'PromotedUserId',
            'AbusedOn' => 'AbusedOn',
            'GroupId' => 'GroupId', 
            'CurbsideCategoryId'=>'CurbsideCategoryId',
            'IsBlockedWordExist'=>'IsBlockedWordExist',
            'IsBlockedWordExistInComment'=>'IsBlockedWordExistInComment',
             'ProfileId' => 'ProfileId',
             'SubGroupId'=>'SubGroupId',
            'userActivityIndex'=>'userActivityIndex',

            'userActivityContext'=>'userActivityContext',
             'pageIndex'=>'pageIndex',
             'IsComebackUser'=>'IsComebackUser',
            'IsNotifiable'=>'IsNotifiable',
            'CurrentGameScheduleId' =>'CurrentGameScheduleId',
         'Language' => 'Language',
         'saveItForLaterUserIds' => 'saveItForLaterUserIds',
            'AdId'=>'AdId',
            'Position'=>'Position',
            'Page'=>'Page',
            'QuickLinkId'=>'QuickLinkId',
            'NotificationId'=>'NotificationId',
            'Email'=>'Email',
            'FromLang'=>'FromLang',
            'ToLang'=>'ToLang',
            'CommentId'=>'CommentId',
            'HelpIconId'=>'HelpIconId',
            'CustomGroupTab'=>'CustomGroupTab',
            'RdsUserStatus'=>'RdsUserStatus',
            'Miscellaneous' => 'Miscellaneous',
            'JobId'=>'JobId',
            'IsSaveItForLater'=>'IsSaveItForLater',
             'projectSearchType'=>'projectSearchType',
            'projectSearchText'=>'projectSearchText',
            'QuickLinkId'=>'QuickLinkId',
            'CareerId'=>'CareerId',
             'HashTagName'=>'HashTagName'
);
    }
    /**
     * 
     * @param type $obj
     */
    
    public function saveUserActivityForPost($obj) {
        try {            
            $streamObj = new UserInteractionCollection();
            $streamObj->UserId = (int)$obj->UserId;
            $streamObj->CreatedOn =  $obj->CreatedOn;
            $createdOn = $obj->CreatedOn;
            $streamObj->CreatedDate = date('Y-m-d', $createdOn->sec); 
            $streamObj->ActionType = $obj->ActionType;
            $streamObj->NetworkId = (int)$obj->NetworkId;
            $streamObj->SegmentId = (int)$obj->SegmentId;
            $streamObj->Language = $obj->Language;
            $obj->PostType=(int)$obj->PostType;
            $streamObj->PostType = (int)$obj->PostType;
             $streamObj->CategoryType = (int)$obj->CategoryType;

            $streamObj->RecentActivity = $obj->RecentActivity;
            if($obj->CategoryType==3){
                $streamObj->GroupId =  new MongoId($obj->GroupId);
            }
            if($obj->CategoryType==7){
                $streamObj->GroupId =  new MongoId($obj->GroupId);
                $streamObj->SubGroupId =  new MongoId($obj->SubGroupId);
            }
            if (isset($obj->Comments['CommentId'])) {
                $obj->Comments['CommentId'] = new MongoId($obj->Comments['CommentId']);
                //$streamObj->Comments = array($obj->Comments);
                $streamObj->CommentId=new MongoId($obj->Comments['CommentId']);
                $streamObj->CommentUserId = array((int) $obj->CommentUserId);
            } else {
                $streamObj->Comments = array();
                $streamObj->CommentUserId = array();
            }


            $streamObj->FollowUserId = array();

            if ($obj->MentionUserId != "" && $obj->MentionUserId != null) {
                $streamObj->MentionUserId = (int) $obj->UserId;
            }

            $streamObj->FollowUserId = array();
           if ($obj->LoveUserId != "" && $obj->LoveUserId != null) {
                $streamObj->LoveUserId = array((int) $obj->UserId);
            } else {

                $streamObj->LoveUserId = array();
            }


            $streamObj->PostId = new MongoId($obj->PostId);
            $streamObj->OriginalUserId = $obj->OriginalUserId;
            $streamObj->OriginalPostTime = new MongoDate($obj->OriginalPostTime);


           

            if ($obj->UserFollowers != "" && $obj->UserFollowers != null) {
                $streamObj->UserFollowers = array($obj->UserFollowers);
            } else {
                $streamObj->UserFollowers = array();
            }
            $streamObj->HashTagPostUserId = $obj->HashTagPostUserId;
            $streamObj->CommentCount = (int) $obj->CommentCount;

            if ($streamObj->PostType == 2) {
                
                $streamObj->StartDate = new MongoDate($obj->StartDate);
                $streamObj->EndDate = new MongoDate($obj->EndDate);
                $streamObj->StartTime = $obj->StartTime;
                $streamObj->EndTime = $obj->EndTime;
            }
            if ($streamObj->PostType == 5) {
                $streamObj->CurbsideCategoryId = (int)$obj->CurbsideCategoryId;
            }
            //     $utc_str = gmdate("Y-m-d H:i:s", time());
            $streamObj->IsBlockedWordExist = (int) $obj->IsBlockedWordExist;
            if(isset($obj->IsBlockedWordExistInComment) && !empty($obj->IsBlockedWordExistInComment)){
                $streamObj->IsBlockedWordExistInComment = $obj->IsBlockedWordExistInComment;
            }
            if($obj->ActionType=="Post"){
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("PostCreated");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("PostCreated");
                $streamObj->pageIndex = CommonUtility::getPageIndex("Post");
            }
            if($obj->ActionType=="EventAttend"){
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("EventAttend");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("EventAttend");
               $streamObj->pageIndex = CommonUtility::getPageIndex("Post");
            }
            if($obj->ActionType=="Survey"){
                 
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("SurveySubmit");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("SurveySubmit");
                $streamObj->pageIndex = CommonUtility::getPageIndex("Post");
            }
             if($obj->ActionType=="Love"){
                 
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Love");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("Love");
               $streamObj->pageIndex = CommonUtility::getPageIndex("Post");

            }
             if($obj->ActionType=="HashTagUsage"){
                 
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("HashTagUsage");
                $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("HashTagUsage");
               $streamObj->pageIndex = CommonUtility::getPageIndex("Post");

            }
              if($obj->ActionType=="Comment"){
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Comment");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("Comment");
               $streamObj->pageIndex = CommonUtility::getPageIndex("Post");
              }
             if($obj->ActionType=="Follow"){
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Follow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("Follow");
               $streamObj->pageIndex = CommonUtility::getPageIndex("Post");
            }
            if($obj->ActionType=="UnFollow"){
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("UnFollow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("UnFollow");
             $streamObj->pageIndex = CommonUtility::getPageIndex("Post");
            }
            if($obj->ActionType=="GroupFollow"){
               
                $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Follow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("GroupFollow");
                $streamObj->pageIndex = CommonUtility::getPageIndex("Group");
            }
            if($obj->ActionType=="GroupUnFollow"){
                
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("UnFollow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("GroupUnFollow");
                 $streamObj->pageIndex = CommonUtility::getPageIndex("Group");
            } if($obj->ActionType=="SubGroupFollow"){
               
                $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Follow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("SubGroupFollow");
               $streamObj->pageIndex = CommonUtility::getPageIndex("SubGroup");
            }
            if($obj->ActionType=="SubGroupUnFollow"){
                
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("UnFollow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("SubGroupUnFollow");
    $streamObj->pageIndex = CommonUtility::getPageIndex("SubGroup");
            }
            if($obj->ActionType=="CurbsideCategoryFollow"){
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Follow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("CurbsideCategoryFollow");
$streamObj->pageIndex = CommonUtility::getPageIndex("CurbStream");
            }
            if($obj->ActionType=="CurbsideCategoryUnFollow"){
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("UnFollow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("CurbsideCategoryUnFollow");
$streamObj->pageIndex = CommonUtility::getPageIndex("CurbStream");
            }
             if($obj->ActionType=="HashTagFollow"){
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Follow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("HashTagFollow");
                $streamObj->pageIndex = (int) 0;
            }
            if($obj->ActionType=="HashTagUnFollow"){
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("UnFollow");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("HashTagUnFollow");
            $streamObj->pageIndex = (int) 0;
            }
            if($obj->ActionType=="UserFollow"){
                $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Follow");
                $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("UserFollow");
                $streamObj->pageIndex = (int) 0;
            }
            if($obj->ActionType=="UserUnFollow"){
                $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("UnFollow");
                $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("UserUnFollow");
                $streamObj->pageIndex = (int) 0;
            }
             if($obj->ActionType=="FbShare"){
               $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Share");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("FBShare");
               $streamObj->pageIndex = CommonUtility::getPageIndex("Post");
            }
             if($obj->ActionType=="TwitterShare"){
               $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Share");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("TwitterShare");
               $streamObj->pageIndex = CommonUtility::getPageIndex("Post");
            }
            
            if($obj->ActionType=="Invite"){              
               $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Invite");
               $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("Invite");
               $streamObj->pageIndex = CommonUtility::getPageIndex("Post");

            }
            
              if ($obj->CategoryType == 8) {
                $streamObj->IsNotifiable = $obj->IsNotifiable;
            }

              if($obj->CategoryType==9){
                $streamObj->pageIndex = CommonUtility::getPageIndex("Game");
                $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("Game");
                $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Share");

                $streamObj->StartDate=$obj->StartDate;
                $streamObj->EndDate=$obj->EndDate;
            }
             if ($obj->CategoryType == 3) {
                 $streamObj->Miscellaneous = (int)$obj->Miscellaneous;
             }
                   if ($streamObj->save()) {
                echo "@@@@@@@@@@@@@@@2222222222222@@@@@@@@@";
                 $streamObj->NetworkId=(int)Yii::app()->params['NetWorkId'];
                    echo "@@@@@@@@@@@@@@@2222222222222@@@@@@@@@";
                 $val = urlencode(CJSON::encode($streamObj));
                    echo "@@@@@@@@@@@@@@@2222222222222@@@@@@@@@";
                 CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            }
            

        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:saveUserActivityForPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            $criteria->addCond('CategoryType', '!=', 7);
            $criteria->addCond('IsBlockedWordExistInComment', 'notin', array(1,2));
            $criteria->addCond('IsBlockedWordExist', 'notin', array(1,2));
            $criteria->addCond('IsDeleted', '!=', 1);
            $criteria->addCond('IsAbused', 'notin', array(1,2));
            $objFollowers=  UserInteractionCollection::model()->findAll($criteria);
            return $objFollowers;
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getUserEventsAttendingActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author sagar
     * @usage update  post management action like delete, abuse 
     * 
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
                $mongoModifier->addModifier('CreatedOn', 'set',  new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
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
           
            UserInteractionCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:updatePostManagementActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            $returnValue = UserInteractionCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            if($obj->ActionType != 'AbuseComment' && $returnValue){
                $criteria = new EMongoCriteria;
                $criteria->addCond('PostId', '==', new MongoId($obj->PostId));
                if ($obj->ActionType == "CommentBlock" || $obj->ActionType == "CommentRelease") {
                    $criteria->Comments->IsBlockedWordExist("==" ,1); 
                }else{
                    $criteria->Comments->IsAbused("==" ,1); 
                }
                $resobj = UserInteractionCollection::model()->findAll($criteria);
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
                    $returnValue=UserInteractionCollection::model()->updateAll($mongoModifier,$criteria);
                    if($returnValue){
                        $returnValue = 'PostReleased';
                    }
                }else{
                    if ($obj->ActionType == "CommentRelease" || $obj->ActionType == "ReleaseAbusedComment") {
                        $criteria = new EMongoCriteria;
                        $criteria->addCond('PostId', '==', new MongoId($obj->PostId));
                        $mongoModifier = new EMongoModifier;
                        $mongoModifier->addModifier('CommentCount', 'inc',  1);
                        UserInteractionCollection::model()->updateAll($mongoModifier,$criteria);
                    }
                    $returnValue = 'CommentReleased';
                }
             }
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:updateCommentManagementActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
    public function saveUserLoginActivity($userId, $activityIndex, $activityContextIndex, $segmentId=0, $action="", $createdDate = "", $NetworkId = ""){
        try{
              $activityObj = new UserInteractionCollection();
            if($this->checkForComebackUser($userId)){
                $activityObj->IsComebackUser = (int)1; 
            }
            if($action == "Register"){
                $activityObj->ActionType = $action;
                $activityObj->CategoryType = (int)0;
                $activityObj->pageIndex = (int)0;
            }
            
            if($NetworkId!="")
                $activityObj->NetworkId = $NetworkId;
                
          $activityObj->UserId = (int)$userId;
          $activityObj->userActivityIndex = (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
          if($createdDate!=""){
              $activityObj->CreatedOn = new MongoDate(strtotime($createdDate));
          }else{
              $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
          }
          
          $activityObj->CreatedDate =date("Y-m-d");
          $activityObj->SegmentId =(int)$segmentId;          
         if($activityObj->save()){
             
               $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);

                return "success"; 
         }else{
            return "failure";  
         }  
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:saveUserLoginActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         return "failure"; 
        }
        
    }
    public function checkForComebackUser($userId){
          try{
              $criteria = new EMongoCriteria;
             $today =  date('Y-m-d H:i:s');
             $beforeDate =  date('Y-m-d', strtotime('-21 days'));
             $beforeDate = $beforeDate." 00:00:00";
             $criteria->UserId = (int)$userId;
             $criteria->CreatedOn = array('$gte' => new MongoDate(strtotime($beforeDate)),'$lte' => new MongoDate(strtotime($today)));
             $row = UserInteractionCollection::model()->find($criteria); 
             
             if($row==null){
               return true;
                
             }else{
                return false;  
             }
          } catch (Exception $ex) {
              Yii::log("UserInteractionCollection:checkForComebackUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          }
    }
    public function saveHashTagCreationActivity($from,$categoryId,$postType,$userId,$hashTagId,$hashTag,$activityIndex,$activityContextIndex,$id,$createddate='', $segmentId=0, $type=""){
        try{
           $activityObj = new UserInteractionCollection();
           if($type==1)
            $activityObj->ActionType = "HashTagUsage";
           else
               $activityObj->ActionType = "HashTagCreation";
           
         $activityObj->UserId = (int)$userId;
           $activityObj->CategoryType = (int)$categoryId;
           $activityObj->PostType = (int)$postType;
          $activityObj->HashTagId = new MongoId($hashTagId);
           $activityObj->HashTagName = $hashTag;
         $activityObj->userActivityIndex = (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
          $activityObj->SegmentId = (int)$segmentId;
           $pageIndex = CommonUtility::getPageIndex("HashTag");
 if($from=="Group"){
      $activityObj->GroupId = new MongoId($id);
 }
 if($from=="SubGroup"){
      $activityObj->SubGroupId = new MongoId($id);
 }
          $activityObj->pageIndex =(int)$pageIndex;
            if(isset($createddate) && !empty($createddate)){
                $activityObj->CreatedOn = new MongoDate(strtotime(date($createddate, time())));
                $activityObj->CreatedDate =date('Y-m-d', strtotime(date($createddate, time())));
            }else{
                $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                $activityObj->CreatedDate =date('Y-m-d');
            }
           
         if($activityObj->save()){
               $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
            return "failure";  
         }  
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:saveHashTagCreationActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->saveHashTagCreationActivity==".$ex->getMessage());
         return "failure"; 
        } 
    }
    function saveMentionUsageActivity($categoryId,$type,$userId,$mentionUserId,$activityIndex,$activityContextIndex){
        try{
           $activityObj = new UserInteractionCollection();
           $activityObj->ActionType = "MentionUsage";
         $activityObj->UserId = (int)$userId;
          $activityObj->CategoryType = (int)$categoryId;
           $activityObj->PostType = (int)$type;
            $activityObj->MentionUserId = (int)$mentionUserId;
           
         $activityObj->userActivityIndex = (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
          $pageIndex = CommonUtility::getPageIndex("Mention");
            $activityObj->pageIndex = (int)$pageIndex;
           
          $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $activityObj->CreatedDate =date('Y-m-d');
           
         if($activityObj->save()){
              $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
          
            return "failure";  
         }  
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:saveMentionUsageActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->saveMentionUsageActivity==".$ex->getMessage());
         return "failure"; 
        }  
    }
    function savePostActionActivity($categoryId,$type,$userId,$activityIndex,$activityContextIndex, $segmentId = 0){
       try{
           $activityObj = new UserInteractionCollection();
         $activityObj->UserId = (int)$userId;
          $activityObj->CategoryType = (int)$categoryId;
           $activityObj->PostType = (int)$type;
         $activityObj->userActivityIndex = (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
          $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $activityObj->CreatedDate =date('Y-m-d');
            $activityObj->SegmentId = (int) $segmentId;
         if($activityObj->save()){
            return "success"; 
         }else{
            return "failure";  
         }  
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:savePostActionActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->savePostActionActivity==".$ex->getMessage());
         return "failure"; 
        }    
    }
    function saveSearchActivity($searchText,$loginUserId,$activityIndex,$activityContextIndex,$NetworkId, $segmentId = 0){
        try{
          
           $activityObj = new UserInteractionCollection();
          $activityObj->UserId = (int)$loginUserId;
       
          $activityObj->projectSearchText = $searchText;
         $activityObj->userActivityIndex = (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
           
          $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
           $activityObj->CreatedDate =date('Y-m-d');
            $activityObj->NetworkId =(int)$NetworkId;
            $activityObj->SegmentId = (int) $segmentId;
         
         if($activityObj->save()){
                $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
            return "failure";  
         }    
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:saveSearchActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in UserInteractionCollection->saveSearchActivity==".$ex->getMessage());
         return "failure"; 
        }
    }
    function trackMinHashTagWindowOpen($userId,$hashtagId,$hashTagName,$activityIndex,$activityContextIndex,$NetworkId, $segmentId = 0){
         try{
           $activityObj = new UserInteractionCollection();
          $activityObj->UserId = (int)$userId;
          $activityObj->HashTagId = new MongoId($hashtagId);
         $activityObj->HashTagName = $hashTagName;
          $pageIndex = CommonUtility::getPageIndex("CurbStream");
          $activityObj->userActivityIndex = (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
           $activityObj->pageIndex = (int)$pageIndex;
          $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $activityObj->CreatedDate =date('Y-m-d');
             $activityObj->NetworkId =(int)$NetworkId;
          $activityObj->SegmentId = (int) $segmentId;
         if($activityObj->save()){
               $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
            return "failure";  
         }    
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:trackMinHashTagWindowOpen::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in UserInteractionCollection->trackMinHashTagWindowOpen==".$ex->getMessage());
         return "failure"; 
        }
    }
    function trackMinMentionWindowOpen($loginUserId,$mentionUserId,$activityIndex,$activityContextIndex,$NetworkId, $segmentId = 0){
         try{
           $activityObj = new UserInteractionCollection();
          $activityObj->UserId = (int)$loginUserId;
          $activityObj->MentionUserId = (int)$mentionUserId;
          $activityObj->userActivityIndex = (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
          $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $activityObj->CreatedDate =date('Y-m-d');
             $activityObj->NetworkId = (int) $NetworkId;
             $activityObj->SegmentId = (int) $segmentId;
         if($activityObj->save()){
                $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
            return "failure";  
         }    
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:trackMinMentionWindowOpen::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in UserInteractionCollection->trackMinMentionWindowOpen==".$ex->getMessage());
         return "failure"; 
        }
    }
    function trackFilterByCategory($userId,$categoryId,$categoryName,$activityIndex,$activityContextIndex,$NetworkId, $segmentId = 0){
        try{
            $activityObj = new UserInteractionCollection();
            $activityObj->UserId = (int) $userId;
            $activityObj->CurbsideCategoryId = (int) $categoryId;
            $activityObj->userActivityIndex = (int) $activityIndex;
            $activityObj->userActivityContext = (int) $activityContextIndex;
            $pageIndex = CommonUtility::getPageIndex("CurbStream");
            $activityObj->pageIndex = (int) $pageIndex;
            $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $activityObj->CreatedDate = date('Y-m-d');
            $activityObj->NetworkId = (int) $NetworkId;
            $activityObj->SegmentId = (int) $segmentId;
            if($activityObj->save()){
                $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
            return "failure";  
         }    
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:trackFilterByCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in UserInteractionCollection->trackFilterByCategory==".$ex->getMessage());
         return "failure"; 
        } 
    }
    function trackPostDetailsOpenActivity($userId,$categoryType,$postType,$postId,$activityIndex,$activityContextIndex,$NetworkId, $segmentId=0){
        try{
          $activityObj = new UserInteractionCollection();
          $activityObj->UserId = (int)$userId;
          $activityObj->CategoryType = (int)$categoryType;
          $activityObj->PostType = (int)$postType;
          $activityObj->PostId = (int)$postId;
          $activityObj->userActivityIndex= (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
          $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $activityObj->CreatedDate =date('Y-m-d');
             $activityObj->NetworkId = (int) $NetworkId;
             $activityObj->SegmentId = (int)$segmentId;
	 if($from=='SetUpPassword'){
                $activityObj->RdsUserStatus =$dataId;
                 $activityObj->UserId = $userId;
           }
         if($activityObj->save()){
             $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
            return "failure";  
         }    
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:trackPostDetailsOpenActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in UserInteractionCollection->trackPostDetailsOpenActivity==".$ex->getMessage());
         return "failure"; 
        }  
    }
  function trackPageLoad($from,$dataId,$userId,$activityIndex,$activityContextIndex, $NetworkId, $segmentId=0){
    try{
       
          $activityObj = new UserInteractionCollection();
          $activityObj->UserId = (int)$userId;
          $activityObj->userActivityIndex= (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
          $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $activityObj->CreatedDate =date('Y-m-d');
             $activityObj->NetworkId = (int) $NetworkId;
          $activityObj->SegmentId = (int)$segmentId;
           if($from == "GroupDetail" || $from == "GroupMinPopup"){
            $activityObj->GroupId = new MongoId($dataId);
           }
            if($from == "SubGroupDetail" || $from == "SubGroupMinPopup"){
            $activityObj->SubGroupId =new MongoId($dataId);
           }
            if($from=='SetUpPassword'){
                $activityObj->RdsUserStatus =$dataId;
                 $activityObj->UserId = $userId;
           }
         if($activityObj->save()){
               $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
            return "failure";  
         }    
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:trackPageLoad::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in UserInteractionCollection->trackPageLoad==".$ex->getMessage());
         return "failure"; 
        }  
  }
  function trackNewGroupCreation($UserId, $groupId, $activityIndex, $activityContextIndex, $NetworkId, $segmentId = 0) {
        try {
            $activityObj = new UserInteractionCollection();
            $activityObj->ActionType = "GroupCreation";
            $activityObj->CategoryType = (int) 3;
            $activityObj->UserId = (int) $UserId;
            $activityObj->GroupId = new MongoId($groupId);
            $activityObj->userActivityIndex = (int) $activityIndex;
            $activityObj->userActivityContext = (int) $activityContextIndex;
            $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $activityObj->CreatedDate = date('Y-m-d');
            $activityObj->NetworkId = (int) $NetworkId;
            $activityObj->pageIndex = (int) CommonUtility::getPageIndex("Group");
            $activityObj->SegmentId = (int) $segmentId;
            if ($activityObj->save()) {
                $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
                return "success";
            } else {
                return "failure";
            }
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:trackNewGroupCreation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->trackNewGroupCreation==".$ex->getMessage());
            return "failure";
        }
    }

    
    
    public function getActiveUsersBetweenDates($startDate,$endDate,$NetworkId)
    {       
        try
        {   
            $returnvalue="failure";
            $startDate=date('Y-m-d',strtotime($startDate));
            $endDate=date('Y-m-d',strtotime($endDate));
            $criteria = new EMongoCriteria;  
            $endDate =$endDate." 23:59:59";
             $startDate =$startDate." 00:00:00";
            
            
            $startDate=date('Y-m-d H:i:s',strtotime($startDate));
            $endDate=date('Y-m-d H:i:s',strtotime($endDate));
            $criteria->addCond('NetworkId', '==', (int)$NetworkId);
            $criteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
            //$criteria->CreatedOn = array('$lt' => new MongoDate(strtotime($endDate)));
            
            $ActiveUsers=  UserInteractionCollection::model()->findAll($criteria);
            if(is_array($ActiveUsers)){
               $returnvalue=count($ActiveUsers); 
            }
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getActiveUsersBetweenDates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
      public function getCombackUsersBetweenDates($startDate,$endDate,$NetworkId)
    {       
        try
        {   
            $returnvalue="failure";
            $startDate=date('Y-m-d',strtotime($startDate));
            $endDate=date('Y-m-d',strtotime($endDate));
            $criteria = new EMongoCriteria;  
            $endDate =$startDate." 23:59:59";
            $startDate =$startDate." 00:00:00";
            $startDate=date('Y-m-d H:i:s',strtotime($startDate));
            $endDate=date('Y-m-d H:i:s',strtotime($endDate));
            
            $criteria->addCond('IsComebackUser', '==', (int) 1);
            $criteria->addCond('UserId', '==', (int) $value->UserId);
            $criteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
            $ComebackUsers=  UserInteractionCollection::model()->findAll($criteria);
            $comebackuserCount=count($ComebackUsers);
//             $comebackUserstartDate= gmdate('Y-m-d', strtotime ("-21 days",strtotime ($startDate)));
//            $comebackUserstartDate= date('Y-m-d H:i:s',strtotime($comebackUserstartDate));
//           $comebackUserEndDate= $comebackUserstartDate." 23:59:59";
//            $comebackUserEndDate=date('Y-m-d H:i:s',strtotime($startDate));
//            $comebackuserCount=0;
//            $activeUsers=array();
//            foreach ($ActiveUsers as $key => $value) {
//               
//               // 
//                if(!in_array($value->UserId, $activeUsers)){
//
//                    $criteria->addCond('UserId', '==', (int) $value->UserId);
//                    $criteria->CreatedOn = array('$gt' => new MongoDate(strtotime($comebackUserstartDate)));
//                    $criteria->CreatedOn = array('$lt' => new MongoDate(strtotime($comebackUserEndDate)));
//                    $ComebackUsers=  UserInteractionCollection::model()->findAll($criteria);
//                    if(is_array($ComebackUsers)){
//                        if(count($ComebackUsers)>0){
//                            $comebackuserCount=$comebackuserCount;
//                        }else{
//                            $comebackuserCount=$comebackuserCount+1;
//                        }
//
//                    }
//                    array_push($activeUsers, $value->UserId);
//                }
//                
//
//            }
           
            return $comebackuserCount;
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getCombackUsersBetweenDates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    

function trackEngagementAction($userId,$page,$action,$dataId,$categoryType,$postType,$id='',$NetworkId, $segmentId=0, $fromLang="", $toLang="",$customPageTab=''){

    try{
          $activityObj = new UserInteractionCollection();
          $pageIndex = CommonUtility::getPageIndex($page);
          if($pageIndex==0){
              //return "success";
          }else{
          $activityIndex = CommonUtility::getUserActivityIndexByActionType($action);
          $activityContextIndex = CommonUtility::getUserActivityContextIndexByActionType($action);
          //if($page=="GroupStream" && ($action == "GroupDetail" || $action == "Loaded" || $action == "Scroll")){
          if($page=="GroupStream"){
            if($id!=''){
              $activityObj->GroupId = new MongoId($id);   
            }else{         
                $activityObj->GroupId = new MongoId($dataId); 
            }
              
          }
          if($page=="SubGroup" || $page=="SubGroupStream"){
             // $activityObj->SubGroupId = new MongoId($dataId); 
              
               if($id!=''){
                  $activityObj->GroupId =  GroupCollection::model()->findGroupBySubgroupId($id);
              $activityObj->SubGroupId = new MongoId($id);   
            }else if($dataId!=''){                                
                  $activityObj->GroupId =  GroupCollection::model()->findGroupBySubgroupId($dataId);
                $activityObj->SubGroupId = new MongoId($dataId); 
            }
          }
          if($page=="ProfileStream"){
              $activityObj->ProfileId = (int)$dataId; 
          }
           if($action=="GroupMinPopup"){
              $activityObj->GroupId = new MongoId($dataId); 
          }
           if($action=="SubGroupMinPopup"){
                 $activityObj->GroupId =  GroupCollection::model()->findGroupBySubgroupId($dataId);
              $activityObj->SubGroupId = new MongoId($dataId);  
          }
          if($page == "PostDetail" || $action == "PostDetailOpen" || $action == "PostDetailOpen" || $action == "PostFeatured" || $action=="SurveySubmit" || $action=="EventAttend" || $action == "PostDelete" || $action == "PostPromote" || $action == "PostFlagAbuse" || $page == "News"){
             if($action != "Loaded" && $action != "Scroll"){
                $activityObj->PostId = new MongoId($dataId); 
             }
              
              
          }
       
          if($action == "CareerDetailOpen"){
             
               $activityObj->CareerId = (int)$dataId; 
          }
          if($action == "QuickLinkClick"){
            
               $activityObj->QuickLinkId = (int)$dataId; 
          }
           if($action == "JobsLinkOpen"){
               $activityObj->JobId = (int)$dataId; 
          }else if($action == "LoginFail" || $action == "ForgotPassword"){
               $activityObj->Email = $dataId; 
          }else if($action == "NotificationClick" || $action == "NotificationMarkAsRead"){
               $activityObj->NotificationId = new MongoId($dataId); 
          }else if($action == "OpenFollowers" || $action == "OpenFollowings" || $action == "InteractionsClick" || $action == "ProfileClick" || $action == "CVClick"){
              $activityObj->ProfileId =(int)$dataId;
          }else if($action=="JobsLinkOpen"){
              $activityObj->PostId = (int)$dataId; 
          }
        
     
          if($action == "HashTagMinPopup" || $action == "HashTagSearch"){
             $hashtagObj = HashTagCollection::model()->getHashTags($dataId); 
              foreach ($hashtagObj as $hash) {
              $activityObj->HashTagId = new MongoId($hash->_id);
             $activityObj->HashTagName = $hash->HashTagName;
           }
           }
            if($action == "MentionMinPopup"){
              $activityObj->MentionUserId =(int)$dataId;
           }
            if($action == "ProfileMinPopup"){
              $activityObj->ProfileId =(int)$dataId;
           }
            if($action == "CurbCategoryMinPopup"){
              $activityObj->CurbsideCategoryId =(int)$dataId;
           }
            if($action == "ProjectSearch"){
              $activityObj->projectSearchText =$dataId;
           }
            if($action == "CustomGroupTab"){
                 $activityObj->GroupId = new MongoId($dataId); 
              $activityObj->CustomGroupTab =$customPageTab;
           }
             

           if($action=="Translation"){
               $activityObj->FromLang = $fromLang;
               $activityObj->ToLang = $toLang;
               if($id!=""){
                $activityObj->GameId = new MongoId($id);
               }
               $activityObj->PostId = new MongoId($dataId);
           }else if($action=="CommentTranslation"){
               $activityObj->FromLang = $fromLang;
               $activityObj->ToLang = $toLang;
               $activityObj->CommentId = new MongoId($id);
               $activityObj->PostId = new MongoId($dataId);
           }
           
           if($action=="HelpManagement"){
               $activityObj->HelpIconId = (int)$dataId;
           }
          
          $activityObj->UserId = (int)$userId;
          $activityObj->pageIndex = (int)$pageIndex;
          if($categoryType!=""){
               $activityObj->CategoryType = (int)$categoryType;
          }
         if($postType != ""){
           $activityObj->PostType = (int)$postType;  
         }
          
          
          $activityObj->userActivityIndex= (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
          $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
          // $activityObj->CreatedDate =date('Y-m-d', time());
           $activityObj->CreatedDate=date('Y-m-d');
           
           $activityObj->NetworkId=(int)$NetworkId;
           $activityObj->ActionType=$action;
           $activityObj->SegmentId = $segmentId;
           
//           if($from == "GroupDetail" || $from == "GroupMinPopup"){
//            $activityObj->GroupId = (int)$dataId;
//           }
//            if($from == "SubGroupDetail" || $from == "SubGroupMinPopup"){
//            $activityObj->SubGroupId = (int)$dataId;
//           }
         if($activityObj->save()){
               $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
            return "failure";  
         } 
          }
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:trackEngagementAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in UserInteractionCollection->trackEngagementAction==".$ex->getMessage());
         return "failure"; 
        }  
  }
  
  
  function trackSearchEngagementAction($userId,$page,$action,$dataId,$searchText,$searchType,$NetworkId, $segmentId=0){
    try{
          $activityObj = new UserInteractionCollection();
          
          $pageIndex = CommonUtility::getPageIndex($page);
          $activityIndex = CommonUtility::getUserActivityIndexByActionType($action);
          $activityContextIndex = CommonUtility::getUserActivityContextIndexByActionType($action);
          if($searchType=="group"){
              $activityObj->GroupId = new MongoId($dataId); 
          }
          if($searchType=="subgroup"){
             
              $activityObj->SubGroupId = new MongoId($dataId); 
          }
          if($searchType=="profile"){
              $activityObj->ProfileId = (int)$dataId; 
          }
          if($searchType == "hashtag"){
              $activityObj->HashTagId = new MongoId($dataId);
              
          }
          if($action == "ProjectSearch"){
              $activityObj->projectSearchText =$searchText;
              $activityObj->projectSearchType = (int)CommonUtility::getProjectSearchTypeIndex($searchType);
              $activityObj->CategoryType = (int) 0;
           }
             
          
          $activityObj->UserId = (int)$userId;
          $activityObj->pageIndex = (int)$pageIndex;
                  
           $activityObj->ActionType = $action;
          $activityObj->userActivityIndex= (int)$activityIndex;
          $activityObj->userActivityContext = (int)$activityContextIndex;
          $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
          // $activityObj->CreatedDate =date('Y-m-d', time());
            $activityObj->CreatedDate=date('Y-m-d');
             $activityObj->NetworkId=(int)$NetworkId;
             $activityObj->SegmentId=(int)$segmentId;
//           if($from == "GroupDetail" || $from == "GroupMinPopup"){
//            $activityObj->GroupId = (int)$dataId;
//           }
//            if($from == "SubGroupDetail" || $from == "SubGroupMinPopup"){
//            $activityObj->SubGroupId = (int)$dataId;
//           }
         if($activityObj->save()){
              $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            return "success"; 
         }else{
            return "failure";  
         }    
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:trackSearchEngagementAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in UserInteractionCollection->trackSearchEngagementAction==".$ex->getMessage());
         return "failure";
        }  
  }


  public function getStreamEngagement($startDate,$endDate,$type,$NetworkId,$GameAvailable,$NewsAvailable,$NormalUsers=array(),$segmentId=0){
      try { 
          $dateFormat = CommonUtility::getDateFormat();
          
            $finalArray = array();
            $timezone = Yii::app()->session['timezone'];
//            $startDate = CommonUtility::convert_time_zone(strtotime($startDate), "UTC", $timezone);
//            $endDate = CommonUtility::convert_time_zone(strtotime($endDate), "UTC", $timezone);
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            $dateFrom = new DateTime($startDate);
            $dateTo = new DateTime($endDate);
            $interval = date_diff($dateFrom, $dateTo);
            $diff = $interval->format('%R%a');
            // $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate, $endDate);


            $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate, $endDate);

            if ($diff > 365) {

                $modeType = '$year';
                $datemode = 'YEAR';
            } elseif ($diff > 92 && $diff <= 365) {

                $modeType = '$month';
                $datemode = 'MONTH';
            } elseif ($diff > 31 && $diff <= 92) {
                $modeType = '$week';
                $datemode = 'WEEK';
            } elseif ($diff <= 31) {

                $modeType = '$dayOfMonth';
                $datemode = 'DATE';
            }
            $Resultsid = array(
                'week' => array("$modeType" => '$CreatedOn'),
            );

            
//------------------- Stream----------------------------------------------------------------------------------------------

            $match = array("pageIndex" => array('$in' => array(1, 2, 3, 4, 5)),
                "NetworkId" => (int) $NetworkId,
                 "UserId" => array('$nin' => $NormalUsers),
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("pageIndex" => array('$in' => array(1, 2, 3, 4, 5)),
                    "SegmentId" => array('$in' => array($segmentId)),
                    "NetworkId" => (int) $NetworkId,
                    "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
                );
            }
            $collection = "UserInteractionCollection";
            $nresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);

            if(!empty($nresults) && $nresults!=""){
            foreach ($nresults as $value) {
             
               if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {

                    $existingArray[0] = $value['count'];
                    $finalArray[$value['_id']['week']][0] = $value['count'];
                }
            }
                    }

//---------------------------------------Posts-------------------------------------------------------------------------------------------------


            $match = array("pageIndex" => array('$in' => array(6)),
                "NetworkId" => (int) $NetworkId,
                "CategoryType" => array('$in' => array(1)),
                "PostType" => array('$in' => array(1)),
                "UserId" => array('$nin' => $NormalUsers),
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("pageIndex" => array('$in' => array(6)),
                    "SegmentId" => array('$in' => array($segmentId)),
                    "NetworkId" => (int) $NetworkId,
                    "CategoryType" => array('$in' => array(1)),
                    "PostType" => array('$in' => array(1)),
                    "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
                );
            }
            $collection = "UserInteractionCollection";
            $presults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);
 if(!empty($presults) && $presults!=""){
            foreach ($presults as $value) {
                   if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][1] = $value['count'];

                }
            }
 }
//---------------------------------Curbside Posts------------------------------------------------------------------------------

            $match = array("pageIndex" => array('$in' => array(6)),
                "CategoryType" => array('$in' => array(2)),
                "NetworkId" => (int) $NetworkId,
                 "UserId" => array('$nin' => $NormalUsers),
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("pageIndex" => array('$in' => array(6)),
                    "SegmentId" => array('$in' => array($segmentId)),
                    "CategoryType" => array('$in' => array(2)),
                    "NetworkId" => (int) $NetworkId,
                    "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
                );
            }
            $collection = "UserInteractionCollection";
            $Cresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);

    if(!empty($Cresults) && $Cresults!=""){
            foreach ($Cresults as $value) {
                  if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][2] = $value['count'];
                }
            }
    }
//----------------------------Event posts------------------------------------------------------------------------------------         

            $match = array("pageIndex" => array('$in' => array(6)),
                "CategoryType" => array('$in' => array(1, 3, 7)),
                "PostType" => array('$in' => array(2)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("pageIndex" => array('$in' => array(6)),
                    "SegmentId" => array('$in' => array($segmentId)),
                    "CategoryType" => array('$in' => array(1, 3, 7)),
                    "PostType" => array('$in' => array(2)),
                    "NetworkId" => (int) $NetworkId,
                    "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
                );
            }
            $collection = "UserInteractionCollection";
            $Eresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);

  if(!empty($Eresults) && $Eresults!=""){
            foreach ($Eresults as $value) {
                  if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][3] = $value['count'];
                }
            }
  }
//----------------Survey Posts--------------------------------------------------------------------------------------------------------------

            $match = array("pageIndex" => array('$in' => array(6)),
                "CategoryType" => array('$in' => array(1, 3, 7)),
                "PostType" => array('$in' => array(3)),
                "NetworkId" => (int) $NetworkId,
                "UserId" => array('$nin' => $NormalUsers),
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("pageIndex" => array('$in' => array(6)),
                    "SegmentId" => array('$in' => array($segmentId)),
                    "CategoryType" => array('$in' => array(1, 3, 7)),
                    "PostType" => array('$in' => array(3)),
                    "NetworkId" => (int) $NetworkId,
                    "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
                );
            }
            $collection = "UserInteractionCollection";
            $Sresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


    if(!empty($Sresults) && $Sresults!=""){
            foreach ($Sresults as $value) {
                   if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][4] = $value['count'];
                }
            }
    }

            //---------------------------------------------------------------Groups--------------------------------------------------------- 

            $match = array("pageIndex" => array('$in' => array(10, 11)),
                "UserId" => array('$nin' => $NormalUsers),
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            if($segmentId!=0){
                $match = array("pageIndex" => array('$in' => array(10, 11)),
                    "SegmentId" => array('$in' => array($segmentId)),
                    "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
                );
            }
            $Sresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);

 if(!empty($Sresults) && $Sresults!=""){
            foreach ($Sresults as $value) {
                if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][5] = $value['count'];
                }
            }
 }
            //-----------------------------Hashtags---------------------------------------------------------------------------------  

            $match = array("pageIndex" => array('$in' => array(7)),
                "UserId" => array('$nin' => $NormalUsers),
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("pageIndex" => array('$in' => array(7)),
                    "SegmentId" => array('$in' => array($segmentId)),
                    "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
                );
            }
            $collection = "UserInteractionCollection";
            $Sresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);

    if(!empty($Sresults) && $Sresults!=""){
            foreach ($Sresults as $value) {
                 if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][6] = $value['count'];
                }
            }
    }
            //------------------------------News--------------------------------------------------------------------------

            $match = array("pageIndex" => (int) 14,
                "CategoryType" => (int) 8,
                "UserId" => array('$nin' => $NormalUsers),
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("pageIndex" => (int) 14,
                    "SegmentId" => array('$in' => array($segmentId)),
                    "CategoryType" => (int) 8,
                    "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
                );
            }
            $collection = "UserInteractionCollection";
            $Sresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


if(!empty($Sresults) && $Sresults!=""){
            foreach ($Sresults as $value) {
                  if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][7] = $value['count'];
                }
            }
}
//---------------------------------Games---------------------------------------------------------------------------------------

            $match = array("pageIndex" => (int) 15,
                "UserId" => array('$nin' => $NormalUsers),
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("pageIndex" => (int) 15,
                    "SegmentId" => array('$in' => array($segmentId)),
                    "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
                );
            }
            $collection = "UserInteractionCollection";
            $Sresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);

   if(!empty($Sresults) && $Sresults!=""){
            foreach ($Sresults as $value) {
                   if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][8] = $value['count'];
                }
            }
   }

//---------------------------------Jobs---------------------------------------------------------------------------------------
            $match = array("pageIndex" => array('$in' => array(18,19,21,22)),
                "userActivityContext" => array('$in' => array(63,73,75,76)),
                "NetworkId" => (int) $NetworkId,
                 "UserId" => array('$nin' => $NormalUsers),
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $nresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);
if(!empty($nresults) && $nresults!=""){
            
            foreach ($nresults as $value) {
             
              if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][9] = $value['count'];
                }
            }
}
            


            if ($GameAvailable == 'ON' && $NewsAvailable == 'ON') {
                $removeKeys = array();
            } else if ($GameAvailable == 'ON' && $NewsAvailable == 'OFF') {
                $removeKeys = array('8');
            } else if ($GameAvailable == 'OFF' && $NewsAvailable == 'ON') {
                $removeKeys = array('7');
            } else if ($GameAvailable == 'OFF' && $NewsAvailable == 'OFF') {
                $removeKeys = array('7', '8');
            }

            foreach ($valid_times as $key => $value) {
                $startDate = date('Y-m-d', strtotime($valid_times["$key"]));
                $startDate_tz = CommonUtility::convert_date_zone(strtotime($startDate . " 18:29:00"), date_default_timezone_get(), "UTC");
                $dateArray = array();
                if (is_array($finalArray[$key])) {

                    for ($k = 0; $k < 10; $k++) {
                        if (!array_key_exists($k, $finalArray[$key])) {

                            $finalArray[$key][$k] = 0;
                        }
                    }
                } else {

                    for ($k = 0; $k < 10; $k++) {

                        $finalArray[$key][$k] = 0;
                    }
                }
 
                ksort($finalArray[$key]);


                if (count($removeKeys) > 0) {
                    foreach ($removeKeys as $ke) {

                        unset($finalArray[$key][$ke]);
                    }
                }


                if ($type == 'xls') {

                    //  $resArr[date($dateFormat, $startDate_tz)] = $dateArray;
                    if ($diff > 365) {
                        $resArray["" . $key . ""] = $finalArray[$key];
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArray["" . date('M Y', $startDate_tz) . ""] = $finalArray[$key];
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArray["" . date('m/d/Y', $startDate_tz) . ""] = $finalArray[$key];
                    } elseif ($diff <= 31) {
                        $resArray["" . date('m/d/Y', $startDate_tz) . ""] = $finalArray[$key];
                    }
                } else {

                    if ($diff > 365) {
                        $resArray["'" . $key . "'"] = $finalArray[$key];
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArray["'" . date('M Y', $startDate_tz) . "'"] = $finalArray[$key];
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArray["'" . date('m/d/Y', $startDate_tz) . "'"] = $finalArray[$key];
                    } elseif ($diff <= 31) {
                        $resArray["'" . date('m/d/Y', $startDate_tz) . "'"] = $finalArray[$key];
                    }
                }
            }
            if ($diff < 31) {
                ksort($resArray);
            }

            return $resArray;
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getStreamEngagement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->getStreamEngagement==".$ex->getMessage());
        }
      
  }
 
 

   public function getGroupEngagement($groupId,$startDate,$endDate,$type,$NetworkId,$NormalUsers=array()){
      try {    
           $dateFormat = CommonUtility::getDateFormat();
            $finalArray = array();
            $groupObj = GroupCollection::model()->getGroupDetailsById($groupId);
            $timezone = Yii::app()->session['timezone'];
//            $startDate = CommonUtility::convert_time_zone(strtotime($startDate), "UTC", $timezone);
//            $endDate = CommonUtility::convert_time_zone(strtotime($endDate), "UTC", $timezone);
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            $dateFrom = new DateTime($startDate);
            $dateTo = new DateTime($endDate);
            $interval = date_diff($dateFrom, $dateTo);
            $diff = $interval->format('%R%a');


            $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate, $endDate);

            if ($diff > 365) {

                $modeType = '$year';
                $datemode = 'YEAR';
            } elseif ($diff > 92 && $diff <= 365) {

                $modeType = '$month';
                $datemode = 'MONTH';
            } elseif ($diff > 31 && $diff <= 92) {
                $modeType = '$week';
                $datemode = 'WEEK';
            } elseif ($diff <= 31) {

                $modeType = '$dayOfMonth';
                $datemode = 'DATE';
            }

            $Resultsid = array(
                'week' => array("$modeType" => '$CreatedOn'),
            );

//-------------------------------------Group Stream--------------------------------------------------------------------------           

            $match = array("GroupId" => new MongoId($groupId),
                "pageIndex" => array('$in' => array(3)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $GSresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


            foreach ($GSresults as $value) {
                 if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][0] = $value['count'];
                }
            }


//-------------------------------Group Normal Posts------------------------------------------------------------------------------------        

            $match = array("GroupId" => new MongoId($groupId),
                "pageIndex" => array('$in' => array(6)),
                "CategoryType" => array('$in' => array(3)),
                "PostType" => array('$in' => array(1)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $GNPresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


            foreach ($GNPresults as $value) {
                 if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][1] = $value['count'];
                }
            }


//---------------------------SubGroups-------------------------------------------------------------------------------------               


            $match = array("SubGroupId" => array('$in' => $groupObj->SubGroups),
                "pageIndex" => array('$in' => array(6)),
                "CategoryType" => array('$in' => array(7)),
                "PostType" => array('$in' => array(1, 2, 3)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $SGresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


            foreach ($SGresults as $value) {
                 if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][2] = $value['count'];
                }
            }

//----------------------------------Event Posts-----------------------------------------------------------------------------

            $match = array("GroupId" => new MongoId($groupId),
                "pageIndex" => array('$in' => array(6)),
                "CategoryType" => array('$in' => array(3)),
                "PostType" => array('$in' => array(2)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $Eresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


            foreach ($Eresults as $value) {
                 if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][3] = $value['count'];
                }
            }

//---------------------------------------Survey Posts-------------------------------------------------------------------------------                


            $match = array("GroupId" => new MongoId($groupId),
                "pageIndex" => array('$in' => array(6)),
                "CategoryType" => array('$in' => array(3)),
                "PostType" => array('$in' => array(3)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $SPresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


            foreach ($SPresults as $value) {
                 if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][4] = $value['count'];
                }
            }

//---------------------------------Serach Items-----------------------------------------------------------------------------------------

            $match = array("GroupId" => new MongoId($groupId),
                "pageIndex" => array('$in' => array(9)),
                "projectSearchType" => array('$in' => array(2, 3)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $Sresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


            foreach ($Sresults as $value) {
                 if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][5] = $value['count'];
                }
            }

//--------------------------------------Hashtags--------------------------------------------------------------------------                

            $match = array("GroupId" => new MongoId($groupId),
                "pageIndex" => array('$in' => array(3, 4)),
                "userActivityContext" => array('$in' => array(5, 9, 24, 26, 37, 38, 71)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $results1 = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


            $match = array("GroupId" => new MongoId($groupId),
                "pageIndex" => array('$in' => array(7)),
                "CategoryType" => array('$in' => array(3)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $results2 = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


            $match = array("SubGroupId" => array('$in' => $groupObj->SubGroups),
                "pageIndex" => array('$in' => array(7)),
                "CategoryType" => array('$in' => array(7)),
                "UserId" => array('$nin' => $NormalUsers),
                "NetworkId" => (int) $NetworkId,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate));
            $collection = "UserInteractionCollection";
            $results3 = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);

            $arr = array_merge($results1, $results2, $results3);

            foreach ($arr as $value) {
                 if($value['_id']['week']<=9 && $modeType == '$week'){
                   $value['_id']['week']='0'.$value['_id']['week'];
               }
                if (array_key_exists($value['_id']['week'], $valid_times)) {
                    $finalArray[$value['_id']['week']][6] = $value['count'];
                }
            }

            foreach ($valid_times as $key => $value) {
                $startDate = date('Y-m-d', strtotime($valid_times["$key"]));
                $startDate_tz = CommonUtility::convert_date_zone(strtotime($startDate . " 18:29:00"), date_default_timezone_get(), "UTC");
                $dateArray = array();
                if (is_array($finalArray[$key])) {

                    for ($k = 0; $k < 7; $k++) {
                        if (!array_key_exists($k, $finalArray[$key])) {

                            $finalArray[$key][$k] = 0;
                        }
                    }
                } else {

                    for ($k = 0; $k < 7; $k++) {

                        $finalArray[$key][$k] = 0;
                    }
                }

                ksort($finalArray[$key]);

                if ($type == 'xls') {

                    //  $resArr[date($dateFormat, $startDate_tz)] = $dateArray;
                    if ($diff > 365) {
                        $resArray["" . $key . ""] = $finalArray[$key];
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArray["" . date('M Y', $startDate_tz) . ""] = $finalArray[$key];
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArray["" . date('m/d/Y', $startDate_tz) . ""] = $finalArray[$key];
                    } elseif ($diff <= 31) {
                        $resArray["" . date('m/d/Y', $startDate_tz) . ""] = $finalArray[$key];
                    }
                } else {

                    if ($diff > 365) {
                        $resArray["'" . $key . "'"] = $finalArray[$key];
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArray["'" . date('M Y', $startDate_tz) . "'"] = $finalArray[$key];
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArray["'" . date('m/d/Y', $startDate_tz) . "'"] = $finalArray[$key];
                    } elseif ($diff <= 31) {
                        $resArray["'" . date('m/d/Y', $startDate_tz) . "'"] = $finalArray[$key];
                    }
                }
            }
            if ($diff < 31) {
                ksort($resArray);
            }

            return $resArray;
        } catch (Exception $ex) {
           Yii::log("UserInteractionCollection:getGroupEngagement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in UserInteractionCollection->getGroupEngagement==".$ex->getMessage());
        }
      
  }


    public function getTopUserOfDay($startDate, $NormalUsers,$segmentId=0){

      try {    
          
          $finalArray = array();
            $TopusersOftheDay = array();
            $c = UserInteractionCollection::model()->getCollection();
//            $keys = array("UserId" => 1);
//            $initial = array("count" => 0);
//            $reduce = "function (obj, prev) { prev.count++; }";
//            $condition = array('condition' => array("CreatedDate"=>array('$lte' => $startDate)));

           // $g = $c->group($keys, $initial, $reduce, $condition);
          

            $matchArray = array("CreatedDate" => array('$lte' => $startDate),"UserId" => array('$nin' => $NormalUsers));
            if($segmentId!=0){
                $matchArray = array("SegmentId"=>array('$in' => array($segmentId)), "CreatedDate" => array('$lte' => $startDate),"UserId" => array('$nin' => $NormalUsers));
            }
           $results = $c->aggregate(
                    array('$match' => $matchArray
                        ), array('$group' => array(
                    '_id' => '$UserId',
                    "number" => array('$sum' => 1),
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
            );
           if(isset($results['result'])){
                $results['result']=  isset($results['result'])?$results['result']:array();
          
                foreach ($results['result'] as $key => $value) {

                     if(!in_array($value['_id'], $finalArray)){
                        array_push($finalArray, $value['_id']); 
                    }
                }
           }
            return $finalArray;
        } catch (Exception $ex) {
           Yii::log("UserInteractionCollection:getTopUserOfDay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
      
  }
  
    public function getTopHashtagsOfDay($startDate,$NormalUsers,$segmentId=0){

      try {    
          
          $finalArray = array();
            $TopHashtagsOftheDay = array();

            $c = UserInteractionCollection::model()->getCollection();
//            $keys = array("HashTagName" => 1);
//            $initial = array("count" => 0);
//            $reduce = "function (obj, prev) { prev.count++; }";
//            $condition = array('condition' => array("userActivityContext" => array('$in' => array(3, 4, 5, 6, 7, 8, 9, 10, 24, 26, 37, 38, 71))));
//
//            $g = $c->group($keys, $initial, $reduce, $condition);
//            
//            
            $matchArray = array("HashTagName" => array('$ne' =>null),"UserId" => array('$nin' => $NormalUsers),"userActivityContext" => array('$in' => array(3, 4, 5, 6, 7, 8, 9, 10, 24, 26, 37, 38, 71)),"CreatedDate" => array('$lte' => $startDate));
            if($segmentId!=0){
                $matchArray = array("SegmentId"=>array('$in' => array($segmentId)), "HashTagName" => array('$ne' =>null),"UserId" => array('$nin' => $NormalUsers),"userActivityContext" => array('$in' => array(3, 4, 5, 6, 7, 8, 9, 10, 24, 26, 37, 38, 71)),"CreatedDate" => array('$lte' => $startDate));
            }
             $results = $c->aggregate(
                    array('$match' => $matchArray
                        ), array('$group' => array(
                    '_id' => '$HashTagName',
                    "number" => array('$sum' => 1),
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
            );

             if(isset($results['result'])){
                foreach ($results['result'] as $key => $value) {

                    if(!in_array($value['_id'], $finalArray)){
                        array_push($finalArray, $value['_id']); 
                    }
                }
             }

            return $finalArray;
        } catch (Exception $ex) {
           Yii::log("UserInteractionCollection:getTopHashtagsOfDay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
      
  }
     public function getTopSearchItemsOfDay($startDate,$NormalUsers,$segmentId=0){
      try {    
          
          $finalArray = array();
            $TopSearchItemsOftheDay = array();
            $c = UserInteractionCollection::model()->getCollection();
//            $keys = array("projectSearchText" => 1);
//            $initial = array("count" => 0);
//            $reduce = "function (obj, prev) { prev.count++; }";
//            $condition = array('condition' => array("projectSearchText" => array('$ne' => null)));
//            $g = $c->group($keys, $initial, $reduce, $condition);
//            $searchArray = $g['retval'];
//            foreach ($searchArray as $key => $value) {
//                $TopSearchItemsOftheDay[$value['projectSearchText']] = $value['count'];
//            }
//
//            arsort($TopSearchItemsOftheDay);
//            foreach ($TopSearchItemsOftheDay as $key => $value) {
//
//                array_push($finalArray, $key);
//            }
//            
            $matchArray = array("projectSearchText" => array('$ne' =>null),"UserId" => array('$nin' => $NormalUsers),"CreatedDate" => array('$lte' => $startDate));
            if($segmentId!=0){
                $matchArray = array("SegmentId"=>array('$in' => array($segmentId)), "projectSearchText" => array('$ne' =>null),"UserId" => array('$nin' => $NormalUsers),"CreatedDate" => array('$lte' => $startDate));
            }
             $results = $c->aggregate(
                    array('$match' => $matchArray
                        ), array('$group' => array(
                    '_id' => '$projectSearchText',
                    "number" => array('$sum' => 1),
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
            );

             if(isset($results['result'])){
                foreach ($results['result'] as $key => $value) {

                   if(!in_array($value['_id'], $finalArray)){
                        array_push($finalArray, $value['_id']); 
                    }
                }
             }
            return $finalArray;
        } catch (Exception $ex) {
           Yii::log("UserInteractionCollection:getTopSearchItemsOfDay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
      
  }
  
  
  public function getGroupTopUserOfDay($groupId,$subgroups,$startDate,$NormalUsers){
      try {    
          
          $finalArray = array();
            $TopusersOftheDay = array();
            $c = UserInteractionCollection::model()->getCollection();
            
            $groupmatchArray = array("GroupId" => new MongoID($groupId),"UserId" => array('$nin' => $NormalUsers),"CreatedDate" => array('$lte' => $startDate));
            
            
             $results = $c->aggregate(
                    array('$match' => $groupmatchArray), array('$group' => array(
                    '_id' => '$UserId',
                    "number" => array('$sum' => 1),
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
            );
            if(isset($results['result'])&& sizeof($results['result'])>0){
            $usersArray =$results['result'];
            
            foreach ($usersArray as $key => $value) {
      
                 if(!in_array($value['_id'],$TopusersOftheDay)){
                    $TopusersOftheDay[$key] = $value['_id'];
                    
                }
              
            }
          
            } 
          
            if (count($subgroups) > 0) {
                  $SubgroupmatchArray = array("UserId" => array('$nin' => $NormalUsers),"CreatedDate" => array('$lte' => $startDate));

                $c = UserInteractionCollection::model()->getCollection();
                  $Subgroupresults = $c->aggregate(
                    array('$match' => $SubgroupmatchArray), array('$group' => array(
                    '_id' => '$UserId',
                    "number" => array('$sum' => 1),
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
                );
                
                
                $SubusersArray = $Subgroupresults['result'];


                if (count($SubusersArray) > 0) {
                    foreach ($SubusersArray as $key => $value) {
                        if(!in_array($value['_id'],$TopusersOftheDay)){
                             array_push($TopusersOftheDay,$value['_id']);
                        }
                       
                    }
                }
            }
            
            if(count($TopusersOftheDay)>10){
               $finalArray= array_slice($TopusersOftheDay,0,10);   
            }else{
                  $finalArray= $TopusersOftheDay;
            }
            
            return $finalArray;
        } catch (Exception $ex) {
           Yii::log("UserInteractionCollection:getGroupTopUserOfDay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
      
  }
  
      public function getGroupTopHashtagsOfDay($groupId,$subgroups,$startDate,$NormalUsers){
      try {    
          
          $finalArray = array();
            $TopHashtagsOftheDay = array();
            
             $c = UserInteractionCollection::model()->getCollection();
            $groupmatchArray = array("GroupId" => new MongoID($groupId),"HashTagName" => array('$ne' =>null),"UserId" => array('$nin' => $NormalUsers),"userActivityContext" => array('$in' => array(3, 4, 5, 6, 7, 8, 9, 10, 24, 26, 37, 38, 71)),"CreatedDate" => array('$lte' => $startDate));

             $results = $c->aggregate(
                      array('$match' =>$groupmatchArray), array('$group' => array(
                    '_id' => '$HashTagName',
                    "number" => array('$sum' => 1),
                   
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
            );
            $hashtagArray =$results['result'];

            foreach ($hashtagArray as $key => $value) {
                if(!in_array($value['_id'],$TopHashtagsOftheDay)){
                    $TopHashtagsOftheDay[$key] = $value['_id'];
                }
               
            }
            
            if (count($subgroups) > 0) {
                 $SubgroupmatchArray = array("SubGroupId" => new MongoID($groupId),"HashTagName" => array('$ne' =>null),"UserId" => array('$nin' => $NormalUsers),"userActivityContext" => array('$in' => array(3, 4, 5, 6, 7, 8, 9, 10, 24, 26, 37, 38, 71)),"CreatedDate" => array('$lte' => $startDate));

                $c = UserInteractionCollection::model()->getCollection();
                  $Subgroupresults = $c->aggregate(
                           array('$match' => array($SubgroupmatchArray)), array('$group' => array(
                    '_id' => '$HashTagName',
                    "number" => array('$sum' => 1),
                   
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
                );
               if(isset($Subgroupresults['result'])&& sizeof($Subgroupresults['result'])>0){
                
                
                $SubGrouphashTagArray = $Subgroupresults['result'];


                if (count($SubGrouphashTagArray) > 0) {
                    foreach ($SubGrouphashTagArray as $key => $value) {
                        if(!in_array($value['_id'],$TopHashtagsOftheDay)){
                             array_push($TopHashtagsOftheDay,$value['_id']);
                        }
                       
                    }
                }
              }
            }
            
            
            if(count($TopHashtagsOftheDay)>10){
               $finalArray= array_slice($TopHashtagsOftheDay,0,10);   
            }else{
                  $finalArray= $TopHashtagsOftheDay;
            }
           
            return $TopHashtagsOftheDay;
        } catch (Exception $ex) {
           Yii::log("UserInteractionCollection:getGroupTopHashtagsOfDay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
      
  }
    public function getGroupTopSearchItemsOfDay($groupId,$subgroups,$startDate,$NormalUsers){
      try {    
          
          $finalArray = array();
            $TopSearchItemsOftheDay = array();
            $c = UserInteractionCollection::model()->getCollection();
             $groupmatchArray = array("GroupId" => new MongoID($groupId),"projectSearchText" => array('$ne' =>null),"UserId" => array('$nin' => $NormalUsers),"CreatedDate" => array('$lte' => $startDate));
             $results = $c->aggregate(
                    array('$match' => array($groupmatchArray)), array('$group' => array(
                    '_id' => '$projectSearchText',
                    "number" => array('$sum' => 1),
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
            );
            if(isset($results['result'])&& sizeof($results['result'])>0){
                    $searchArray =$results['result'];

                    foreach ($searchArray as $key => $value) {
                        if(!in_array($value['_id'],$TopSearchItemsOftheDay)){
                            $TopSearchItemsOftheDay[$key] = $value['_id'];
                        }

                    }
           }
            
            
             if (count($subgroups) > 0) {
                  $subgroupmatchArray = array("SubGroupId" => new MongoID($groupId),"projectSearchText" => array('$ne' =>null),"UserId" => array('$nin' => $NormalUsers),"CreatedDate" => array('$lte' => $startDate));

               $c = UserInteractionCollection::model()->getCollection();
               $SubgroupSearchresults = $c->aggregate(
                    array('$match' => array($subgroupmatchArray)), array('$group' => array(
                    '_id' => '$projectSearchText',
                    "number" => array('$sum' => 1),
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
            );
             if(isset($Subgroupresults['result'])&& sizeof($Subgroupresults['result'])>0){  
                $SubGroupsearchArray = $SubgroupSearchresults['result'];
               
               if (count($SubGroupsearchArray) > 0) {

                   foreach ($SubGroupsearchArray as $key => $value) {
                       if(!in_array($value['_id'],$TopSearchItemsOftheDay)){
                             array_push($TopSearchItemsOftheDay,$value['_id']);
                        }
                    }
                }
             }
           }
           
           if(count($TopSearchItemsOftheDay)>10){
               $finalArray= array_slice($TopSearchItemsOftheDay,0,10);   
            }else{
                  $finalArray= $TopSearchItemsOftheDay;
            }
           
            return $finalArray;
        } catch (Exception $ex) {
           Yii::log("UserInteractionCollection:getGroupTopSearchItemsOfDay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
      
  }
  
  
   public function getTopNewsOfDay($startDate,$NormalUsers,$segmentId=0){
      try {    
          
          $finalArray = array();
            $TopHashtagsOftheDay = array();
            $newsArray=array();
            $resultArray=array();

            $c = UserInteractionCollection::model()->getCollection();
//            $keys = array("PostId" => 1);
//            $initial = array("count" => 0);
//            $reduce = "function (obj, prev) { prev.count++; }";
//            $condition = array('condition' => array("CategoryType" => (int)8, "pageIndex"=>(int)14));
//
//            $g = $c->group($keys, $initial, $reduce, $condition);
//
//            $newsArray = $g['retval'];
//            foreach ($newsArray as $key => $value) {
//
//                array_push($finalArray, $value['PostId']);
//            }
//
//            if(count($finalArray)>10){
//                $resultArray=array_slice($finalArray,0,10);
//            }else{
//                $resultArray=array_slice($finalArray,0,count($finalArray));
//            }
            $matchArray = array("CategoryType" => (int)8, "pageIndex"=>(int)14, "UserId" => array('$nin' => $NormalUsers),"CreatedDate" => array('$lte' => $startDate));
            if($segmentId!=0){
                $matchArray = array("SegmentId"=>array('$in' => array($segmentId)), "CategoryType" => (int)8, "pageIndex"=>(int)14, "UserId" => array('$nin' => $NormalUsers),"CreatedDate" => array('$lte' => $startDate));
            }
            $results = $c->aggregate(
                    array('$match' => $matchArray
                        ), array('$group' => array(
                    '_id' => '$PostId',
                    "number" => array('$sum' => 1),
                )), array(
                '$sort' => array('number' => -1)
                    ), array('$limit' => 10)
            );

            if(isset($results['result'])){
                foreach ($results['result'] as $key => $value) {

                   if(!in_array($value['_id'], $finalArray)){
                        array_push($finalArray, $value['_id']); 
                    }
                }
            }

            return $finalArray;
        } catch (Exception $ex) {
           Yii::log("UserInteractionCollection:getTopNewsOfDay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
      
  }
  
   /**
     * @author Swathi
     * This is used to fetch the user interactions by userId
     * @param  $userId,$type(Type refers to action type)
     * @return type
     */
  
   public function getUserActionsByUserId($userId,$type) {
      
        $returnValue = 'failure';
        try {            
            $criteria = new EMongoCriteria;
            $criteria->addCond('UserId', '==', (int)$userId);
             $criteria->addCond('ActionType', '==', $type);
             $criteria->addCond('pageIndex', '==', 6);
            $userActions = UserInteractionCollection::model()->findAll($criteria);
            if (isset($userActions)) {
              $returnValue= $userActions;
            }
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getUserActionsByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->getUserActionsByUserId==".$ex->getMessage());
        }
        return $returnValue;
    }
   
   public function updateUserInteractionForGameDetails($Gameobj){
       $returnValue = 'success'; 
      try {          
         
            $criteria = new EMongoCriteria;
            $modifier = new EMongoModifier();
            $criteria->addCond('PostId', '==', new MongoID($Gameobj->GameId));
            
           
        if(UserInteractionCollection::model()->updateAll($modifier,$criteria)){
           
             $returnValue = 'success'; 
        }else{
            $returnValue = 'failure'; 
        }
       
        return $returnValue;
        
      } catch (Exception $ex) {  
          Yii::log("UserInteractionCollection:updateUserInteractionForGameDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return $returnValue;
      }
    }
   
   public function getUserInteractionsCount($userId){
       $returnValue='failure';
       try {
          $provider = new EMongoDocumentDataProvider('ProfileIntractionDisplayBean',
                   
           array(
               
                'criteria' => array( 
                   'conditions'=>array(
                            'UserId'=>array('==' => (int)$userId),
                            'IsDeleted'=>array('!=' => 1),
                            'IsAbused'=>array('notIn' => array(1,2)),
                            'IsBlockedWordExist'=>array('notIn' => array(1,2)),
                            'IsNotifiable'=>array('==' => 1),
                             'CategoryType'=>array('!=' => 7),
//                            'PostType'=>array('>' => 0),
                            // 'PostType'=>array('!=' => null),
                  
                            'PostType'=>array('notIn' => array(6,7,8,9,10,15,0,null,'null')),
                            
                       ),
                   'sort'=>array('CreatedOn'=>EMongoCriteria::SORT_DESC)
                 )
               ));
          
          return $provider->getTotalItemCount();
       } catch (Exception $ex) {           
         Yii::log("UserInteractionCollection:getUserInteractionsCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        
       }
      } 
                  
   public function getAggregateCommonListByCategoryType($categoryTypeArray, $segmentId=0) {
        try {
            $finalArray = array();
            $c = UserInteractionCollection::model()->getCollection();
            $conditions = array("SegmentId"=>array('$in' => array(0,$segmentId)),"CategoryType" => array('$in' => $categoryTypeArray), 'IsDeleted' => (int) 0, 'CreatedOn' => array('$gt' => new MongoDate(strtotime('-1 day'))));
            $c = UserInteractionCollection::model()->getCollection();

            $results = $c->aggregate(
                    array('$match' => $conditions
                    ), array('$group' => array(
                    '_id' => array('PostId' => '$PostId'),
                    "count" => array('$sum' => 1),
                )), array(
                '$sort' => array('count' => -1)
                    )
            );


            $finalArray = isset($results['result']) ? $results['result'] : $finalArray;
            return $finalArray;
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getAggregateCommonListByCategoryType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
 public function getDistinctUserFollowersListByCategoryType($userId) {
        try {
            $finalArray = array();
            $c = UserInteractionCollection::model()->getCollection();

           $conditions = array(
               'UserFollowers'=>array('$in'=>array($userId)),"ActionType" => "UserFollow","CategoryType" => 4, 'IsDeleted' => 0, 'CreatedOn' => array('$gt' => new MongoDate(strtotime('-1 day')))
               
            );
            $crr = $c->distinct("UserId", $conditions);
       
            return sizeof($crr)>0?$crr:$finalArray;
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getDistinctUserFollowersListByCategoryType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->getDistinctUserFollowersListByCategoryType==".$ex->getMessage());
        }
    }
    
     public function getDistinctUserIdListByPostId($postId,$OrginalUserId,$userId) {
        try {
            $finalArray = array();
            $c = UserInteractionCollection::model()->getCollection();
            $conditions = array('PostId'=> new MongoId($postId),'UserId'=>array('$nin'=>array($OrginalUserId,$userId)));
            $crr = $c->distinct("UserId", $conditions);   
            
            return sizeof($crr)>0?$crr:$finalArray;
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getDistinctUserIdListByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->getDistinctUserIdListByPostId==".$ex->getMessage());
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
            $criteria->addCond('OriginalUserId', '==', (int) $userId);
            $mongoModifier->addModifier('SegmentId', 'set', (int)$segmentId);
            $mongoModifier->addModifier('NetworkId', 'set', (int)$networkId);
            $returnValue = UserInteractionCollection::model()->updateAll($mongoModifier, $criteria);
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:updateSegmentIdNetworkIdByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }

    /**@author Vamsi
     * This method is used to update the Interaction when group in active and inactive  
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
            UserInteractionCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:updateStreamForGroupInactiveAndActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            UserInteractionCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:updateStreamForSubGroupInactiveAndActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

 public function getAggregateCommonListByCategoryTypeForAwayDigest($categoryTypeArray,$noOfDays,$awayDigestIdList) {
        try {
            $finalArray = array();
            $c = UserInteractionCollection::model()->getCollection();
            $conditions = array("PostId" => array('$nin' => $awayDigestIdList),"CategoryType" => array('$in' => $categoryTypeArray), 'IsDeleted' => (int) 0, 'CreatedOn' => array('$gt' => new MongoDate(strtotime('-'.$noOfDays.' day'))));
            $c = UserInteractionCollection::model()->getCollection();

            $results = $c->aggregate(
                    array('$match' => $conditions
                    ), array('$group' => array(
                    '_id' => array('CategoryType'=>'$CategoryType','PostType'=>'$PostType','PostId' => '$PostId'),
                    "count" => array('$sum' => 1),
                )), array(
                '$sort' => array('count' => -1)
                    )
            );

            $finalArray = isset($results['result']) ? $results['result'] : $finalArray;
            return $finalArray;
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getAggregateCommonListByCategoryTypeForAwayDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }    
    public function saveObjForPostManagementActions($obj)
    {
         try {
            $streamObj = new UserInteractionCollection();
            $streamObj->UserId = (int)$obj->UserId;
            $streamObj->StreamNote = $obj->StreamNote;
            $streamObj->StreamNote1 = $obj->StreamNote1;
            $streamObj->CreatedOn =  $obj->CreatedOn;
            $createdOn = $obj->CreatedOn;
            $streamObj->CreatedDate = date('Y-m-d', $createdOn->sec); 
            $streamObj->ActionType = $obj->ActionType;
            $streamObj->NetworkId = (int)$obj->NetworkId;
            $obj->PostType=(int)$obj->PostType;
            $streamObj->PostType = (int)$obj->PostType;
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
            $streamObj->Comments = array();
            $streamObj->CommentUserId = array();
         
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
               // $streamObj->CurbsidePostCount = $obj->CurbsidePostCount;
            }
            $streamObj->Priority = $obj->Priority;
            //     $utc_str = gmdate("Y-m-d H:i:s", time());
            $streamObj->IsBlockedWordExist = (int) $obj->IsBlockedWordExist;
            if(isset($obj->IsBlockedWordExistInComment) && !empty($obj->IsBlockedWordExistInComment)){
                $streamObj->IsBlockedWordExistInComment = $obj->IsBlockedWordExistInComment;
            }
            $streamObj->DisableComments = $obj->DisableComments;
            $streamObj->Division=(int) $obj->Division;
            $streamObj->District= (int)$obj->District;
            $streamObj->Region= (int)$obj->Region;
            $streamObj->Store= (int)$obj->Store;
            $streamObj->Title= $obj->Title;
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

              if($obj->CategoryType==9){
                $streamObj->pageIndex = CommonUtility::getPageIndex("Game");
                $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("Share");
                $streamObj->GameName =  $obj->GameName;
                $streamObj->GameDescription =  $obj->GameDescription;
                $streamObj->PostFollowers =  $obj->PostFollowers;
                $streamObj->PlayersCount =  $obj->PlayersCount;
                $streamObj->GameBannerImage=$obj->GameBannerImage;
                $streamObj->StartDate=$obj->StartDate;
                $streamObj->EndDate=$obj->EndDate;
                if($obj->ActionType == "Play"){
                    $streamObj->PlayedUsers=array($obj->CurrentScheduledPlayers);
                }

                
            }
              if ($obj->CategoryType == 10) {

                $streamObj->PostText = $obj->PostText;
                $streamObj->BadgeName = $obj->BadgeName;
                $streamObj->Title = $obj->Title;
                $streamObj->BadgeLevelValue = $obj->BadgeLevelValue;
                $streamObj->BadgeHasLevel = $obj->BadgeHasLevel;
            }
            
            if($obj->ActionType='SaveItForLater')
              {
                 $streamObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType("SaveItForLater");
                 $streamObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType("PostSaveItForLater");
                 $streamObj->pageIndex = CommonUtility::getPageIndex("Post");
                 $streamObj->IsSaveItForLater=$obj->IsSaveItForLater;
              }


            if ($streamObj->save()) {
                
            }
            

        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:saveObjForPostManagementActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
        
        
             
    }
   

 /**@author Haribabu
 * This method is used to update the UserId after completion of the hds user registration
 * @param type $obj
 */
  public function updateHdsUserAccesskeyWithUserId($Accesskey,$Userid) {
        try {
            $returnValue = 'failure'; 
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond("UserId", "==",$Accesskey);
            
            $mongoModifier->addModifier('UserId', 'set',(int)$Userid);

            if(UserInteractionCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                 $returnValue = 'success'; 
            }else{
                 $returnValue = 'failure'; 
            }
            
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:updateHdsUserAccesskeyWithUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
      
      /**
       * @developer vamsi
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
         UserInteractionCollection::model()->updateAll($mongoModifier, $mongoCriteria);
     } catch (Exception $ex) {
         Yii::log("UserInteractionCollection:updatePostsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
     /**
     * This method is used to update the stream with IsDeleted=0
     * All the suspended user activities will be replaced once he is active again 
     * @param type $userId
     */
    

    public function saveUserImpressions($objects){
        try {
            foreach ($objects as $obj) {
                $obj = (object)$obj;
                $activityObj = new UserInteractionCollection();

                $activityObj->UserId = (int) $obj->UserId;

                $activityObj->userActivityIndex = CommonUtility::getUserActivityIndexByActionType($obj->ActionType);
                $activityObj->userActivityContext = CommonUtility::getUserActivityContextIndexByActionType($obj->RecentActivity);
                $activityObj->pageIndex =  (int) 0;
                $activityObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                $activityObj->CreatedDate = date("Y-m-d");
                $activityObj->ActionType = $obj->ActionType;
                $activityObj->RecentActivity = $obj->RecentActivity;

                $activityObj->NetworkId = (int)$obj->NetworkId;
                $activityObj->SegmentId = (int)$obj->SegmentId;
                $activityObj->Language = $obj->Language;
                
                $activityObj->CategoryType = (int)$obj->CategoryType;
                if(isset($obj->PostType)){
                    $activityObj->PostId = new MongoId($obj->PostId);
                    $activityObj->PostType = (int)$obj->PostType;    
                }else if(isset($obj->WebLinkId)){
                    $activityObj->WebLinkId = (int)$obj->WebLinkId;
                    $activityObj->LinkGroupId = (int)$obj->LinkGroupId;
                    $activityObj->WebUrl = $obj->WebUrl;                    
                }else if(isset($obj->JobId)){
                    $activityObj->JobId = (int)$obj->JobId;
                }else if(isset($obj->AdId)){
                    $activityObj->AdId = (int)$obj->AdId;
                    $activityObj->Position = $obj->Position;
                    $activityObj->Page = $obj->Page;
                }else if(isset($obj->GroupId)){
                    $activityObj->GroupId = new MongoId($obj->GroupId);
                    if(isset($obj->PostId))
                        $activityObj->PostId = new MongoId($obj->PostId);
                    if($obj->SubGroupId)
                        $activityObj->SubGroupId = new MongoId($obj->SubGroupId);
                    
                }
                
                $activityObj->save();
                $activityObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($activityObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val);
            }
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:saveUserImpressions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
    }
    public function getViewCount($userId, $recentActivity){
        try{
                $userId = (int)$userId;
                $count = 0;
                $c = UserInteractionCollection::model()->getCollection();
                $results = $c->aggregate(
                    array('$match' => array("UserId" =>$userId, "RecentActivity" =>$recentActivity)
                            ),
                        array(
                            '$group' => array(
                                '_id' => '$PostId'
                            )
                        )
                    );
                if(isset($results["result"]) && isset($results["result"][0])){
                    $count = count($results["result"]);
                }
                return $count;
        }  catch (Exception $ex){
            Yii::log("UserInteractionCollection:getViewCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->getViewCount==".$ex->getMessage());
        }
    }
    public function getCareerViewCount($userId, $recentActivity){
        try{
                $userId = (int)$userId;
                $count = 0;
                $c = UserInteractionCollection::model()->getCollection();
                $results = $c->aggregate(
                    array('$match' => array("UserId" =>$userId, "RecentActivity" =>$recentActivity)
                            ),
                        array(
                            '$group' => array(
                                '_id' => '$JobId'
                            )
                        )
                    );
                if(isset($results["result"]) && isset($results["result"][0])){
                    $count = count($results["result"]);
                }
                return $count;
        }  catch (Exception $ex){
            Yii::log("UserInteractionCollection:getCareerViewCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->getCareerViewCount==".$ex->getMessage());
        }
    }
    public function careerRespondedViewCount($userId){
        try{
                $userId = (int)$userId;
                $count = 0;
                $c = UserInteractionCollection::model()->getCollection();
                $results = $c->aggregate(
                    array('$match' => array("UserId" =>$userId, "ActionType" =>"JobsLinkOpen")
                            ),
                        array(
                            '$group' => array(
                                '_id' => '$JobId'
                            )
                        )
                    );
                if(isset($results["result"]) && isset($results["result"][0])){
                    $count = count($results["result"]);
                }
                return $count;
        }  catch (Exception $ex){
            Yii::log("UserInteractionCollection:careerRespondedViewCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->careerRespondedViewCount==".$ex->getMessage());
        }
    }
    public function getConversationsCount($userId, $CategoryType){
        try{
                $userId = (int)$userId;
                $CategoryType = (int)$CategoryType;
                $count = 0;
                $c = UserInteractionCollection::model()->getCollection();
                $results = $c->aggregate(
                    array('$match' => array("UserId" =>$userId, "CategoryType" =>$CategoryType, "ActionType"=>"Comment",)
                            ),
                        array(
                            '$group' => array(
                                '_id' => '$CommentId'
                            )
                        )
                    );
                if(isset($results["result"]) && isset($results["result"][0])){
                    $count = count($results["result"]);
                }
                return $count;
        }  catch (Exception $ex){
            Yii::log("UserInteractionCollection:getConversationsCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->getConversationsCount==".$ex->getMessage());
        }
    }

 public function releasePostsForSuspendedUser($userId){
     try {
         $mongoCriteria = new EMongoCriteria;
         $mongoModifier = new EMongoModifier;
         $mongoModifier->addModifier('IsDeleted', 'set', (int)0);
         $mongoCriteria->addCond('OriginalUserId', '==', (int)$userId);
         $mongoCriteria->addCond('IsDeleted', '==', (int)2);
         UserInteractionCollection::model()->updateAll($mongoModifier, $mongoCriteria);
     } catch (Exception $ex) {
         Yii::log("UserInteractionCollection:releasePostsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
                 
                 
                 UserInteractionCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:removeCommentsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->removeCommentsForSuspendedUser==".$ex->getMessage());
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
                 
                 
                 UserInteractionCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:releaseCommentsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->releaseCommentsForSuspendedUser==".$ex->getMessage());
        }
    }
    


/**@author Haribabu
 * This method is used to update the UserId after completion of the hds user registration
 * @param type $obj
 */
  public function getHdsRegisteredmembers($StartDate,$EndDate) {
      $returnValue = 'failure';
        try {            
            $criteria = new EMongoCriteria;
            $criteria->addCond('UserId', '==', (int)$userId);
             $criteria->addCond('ActionType', '==', $type);
             $criteria->addCond('pageIndex', '==', 6);
            $userActions = UserInteractionCollection::model()->findAll($criteria);
            if (isset($userActions)) {
              $returnValue= $userActions;
            }
        } catch (Exception $ex) {
            Yii::log("UserInteractionCollection:getHdsRegisteredmembers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserInteractionCollection->getHdsRegisteredmembers==".$ex->getMessage());
        }
        return $returnValue;
    }
    

}

?>
