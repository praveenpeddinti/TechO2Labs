<?php

class GroupEventPost extends EMongoDocument {
    public $_id;
    public $Type;
    public $UserId;
    public $Priority;
    public $CreatedOn;
    public $CreatedDate;
    public $Description;    
    public $StartDate;
    public $EndDate;
    public $EventAttendes;
    public $Followers;
    public $Mentions;
    public $Comments;
    public $Resource;
    public $Love;
    public $HashTags;
    public $Invite;
    public $Share;
    public $Location;
    public $StartTime;
    public $EndTime;
    public $WebUrls;

    public $GroupId;
    public $Status;
    public $IsPublic;
    public $DisableComments=0;
    public $IsBlockedWordExist=0;
    public $IsWebSnippetExist = 0;
    public $Division=0;
    public $District=0;
    public $Region=0;
    public $Store=0;
    public $Title;
    public $SubGroupId=0;
    public $MigratedPostId='';
    //$postedBy is added by Sagar for PostAsNetwork
    public $PostedBy=0;
      public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';
  public $Miscellaneous = 0;
    public function getCollectionName() {
        return 'GroupPostCollection';
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
            ),
            'index_GroupId' => array(
                'key' => array(
                    'GroupId' => EMongoCriteria::SORT_ASC
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            'Type' => 'Type',
            'UserId' => 'UserId',
            'GroupId'=>'GroupId',
            'Priority' => 'Priority',
            'CreatedOn' => 'CreatedOn',
            'CreatedDate' => 'CreatedDate',
            'Description' => 'Description',
            'StartDate' => 'StartDate',
            'EndDate' => 'EndDate',
            'EventAttendes' => 'EventAttendes',
            'Followers' => 'Followers',
            'Mentions'=>'Mentions',
            'Comments' => 'Comments',            
            'Love' => 'Love',
            'Resource' => 'Resource',
            'HashTags' => 'HashTags',
            'Invite'=>'Invite',
            'Share'=>'Share',
            'Location'=>'Location',
            'StartTime'=>'StartTime',
            'EndTime'=>'EndTime',
            'WebUrls'=>'WebUrls',
       
            'Status'=>'Status',
            'IsPublic'=>'IsPublic',
            'DisableComments'=>'DisableComments',
            'IsBlockedWordExist'=>'IsBlockedWordExist',
 
            'IsWebSnippetExist'=>'IsWebSnippetExist',
             'Division'=>'Division',
            'District'=>'District',
            'Region'=>'Region',
             'Store'=>'Store',
            'Title'=>'Title',
             'SubGroupId'=>'SubGroupId',
            'MigratedPostId'=>'MigratedPostId',
            'PostedBy'=>'PostedBy',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
            'Miscellaneous' => 'Miscellaneous',
        );
    }
    
    /**
     * updated by suresh reddy as part of group event artifact uploaded as single element. initally we insert empty array then we update with resource objects
     * @param type $postObj
     * @param type $hashTagIdArray
     * @return type
     */
    public function SaveGroupEventPost($postObj,$hashTagIdArray,$userHirarchy){
        try {
            $returnValue='failure';
            $eventPostObj=new GroupEventPost();
            $startDateTime =  $postObj->StartDate." ".$postObj->StartTime;
            $endDateTime =  $postObj->EndDate." ".$postObj->EndTime;
            $eventPostObj->Type=(int)$postObj->Type;
            $eventPostObj->UserId=(int)$postObj->UserId;
            $eventPostObj->PostedBy=(int)$postObj->PostedBy;
            $eventPostObj->GroupId=new MongoID($postObj->GroupId);
            if(isset($postObj->CreatedOn) && !empty($postObj->CreatedOn)){
                 $eventPostObj->CreatedOn=new MongoDate(strtotime(date($postObj->CreatedOn, time())));
             }else{
                 $eventPostObj->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
            $startDateTime = CommonUtility::convert_time_zone(strtotime($startDateTime),date_default_timezone_get(),Yii::app()->session['timezone']);
            $endDateTime =  CommonUtility::convert_time_zone(strtotime($endDateTime),date_default_timezone_get(),Yii::app()->session['timezone']);
            $createdOn = $eventPostObj->CreatedOn;
            $eventPostObj->CreatedDate=date('Y-m-d', $createdOn->sec);
            $eventPostObj->Description=stripslashes($postObj->Description);
            $eventPostObj->StartDate=new MongoDate(strtotime($startDateTime));
            $eventPostObj->EndDate=new MongoDate(strtotime($endDateTime));
            $eventPostObj->StartTime=$postObj->StartTime;
            $eventPostObj->EndTime=$postObj->EndTime; 
            $eventPostObj->EventAttendes=array((int)$postObj->UserId);
            $eventPostObj->Followers=array();
            array_push($eventPostObj->Followers, (int)$eventPostObj->UserId);
            $eventPostObj->Mentions=$postObj->Mentions;
            $eventPostObj->Comments=array();
            $eventPostObj->Love=array();
            $eventPostObj->Resource=array();
            $eventPostObj->HashTags=$hashTagIdArray;
            $eventPostObj->Invite=array();
            $eventPostObj->Share=array();
            $eventPostObj->Location=stripslashes($postObj->Location);
            $eventPostObj->WebUrls=$postObj->WebUrls;
            $eventPostObj->NetworkId=(int)$postObj->NetworkId;
            $eventPostObj->SegmentId=(int)$postObj->SegmentId;
            $eventPostObj->Language=$postObj->Language;
            $eventPostObj->DisableComments=$postObj->DisableComments;
            $eventPostObj->Status=(int)$postObj->Status;
            $eventPostObj->IsPublic=(int)$postObj->IsPublic;
            $eventPostObj->IsBlockedWordExist=(int)$postObj->IsBlockedWordExist;
            $eventPostObj->IsWebSnippetExist=(int)$postObj->IsWebSnippetExist;
            $eventPostObj->MigratedPostId = isset($postObj->MigratedPostId)?$postObj->MigratedPostId:'';
           if (isset($userHirarchy)) {
                $eventPostObj->District = (int)$userHirarchy->District;
                $eventPostObj->Division = (int)$userHirarchy->Division;
                $eventPostObj->Region = (int)$userHirarchy->Region;
                $eventPostObj->Store = (int)$userHirarchy->Store;
            }
             $eventPostObj->Title=stripslashes($postObj->Title);
              if($postObj->SubGroupId!=0){
                 $eventPostObj->SubGroupId=new MongoID($postObj->SubGroupId);
             } 
             $eventPostObj->Miscellaneous=(int)$postObj->Miscellaneous;
            if($eventPostObj->save()){
                $returnValue=$eventPostObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
          Yii::log("GroupEventPost:SaveGroupEventPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return 'failure';
        }
        }
}
