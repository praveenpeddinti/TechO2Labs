<?php

class EventPost extends EMongoDocument {
    public $_id;
    public $Type;
    public $UserId;
    public $Priority;
    public $CreatedOn;
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
    public $DisableComments=0;
    public $IsBlockedWordExist=0;
    public $IsFeatured=0;
     public $IsAnonymous=0;
    public $FeaturedUserId;
    public $FeaturedOn; 
    public $IsWebSnippetExist = 0;
    public $Division=0;
    public $District=0;
    public $Region=0;
    public $Store=0;
    public $Title;
    public $MigratedPostId='';
    //$postedBy is added by Sagar for PostAsNetwork
    public $PostedBy=0;
       
  public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';
    public function getCollectionName() {
        return 'PostCollection';
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
        );
    }
    public function attributeNames() {
        return array(
            'Type' => 'Type',
            'UserId' => 'UserId',
            'Priority' => 'Priority',
            'CreatedOn' => 'CreatedOn',
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
          
            'IsBlockedWordExist'=>'IsBlockedWordExist',
            'DisableComments'=>'DisableComments',
            'IsFeatured'=>'IsFeatured',
             'IsAnonymous'=>'IsAnonymous',
            'FeaturedUserId'=>'FeaturedUserId',
            'FeaturedOn'=>'FeaturedOn',
            'IsWebSnippetExist'=>'IsWebSnippetExist',
             'Division'=>'Division',
            'District'=>'District',
            'Region'=>'Region',
            'Store'=>'Store',
             'Title'=>'Title',
            'MigratedPostId'=>'MigratedPostId',
            'PostedBy'=>'PostedBy',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
        );
    }
    
    public function SaveEventPost($postObj,$hashTagIdArray,$userHirarchy){
        try {
            $returnValue='failure';
            $eventPostObj=new EventPost();
            $startDateTime =  $postObj->StartDate." ".$postObj->StartTime;
            $endDateTime =  $postObj->EndDate." ".$postObj->EndTime;
          
            $eventPostObj->Type=(int)$postObj->Type;
            $eventPostObj->UserId=$postObj->UserId;
            $eventPostObj->PostedBy=(int)$postObj->PostedBy;
            if(isset($postObj->CreatedOn) && !empty($postObj->CreatedOn)){
                 $eventPostObj->CreatedOn=new MongoDate(strtotime(date($postObj->CreatedOn, time())));
             }else{
                 $eventPostObj->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
             
            
             $startDateTime = CommonUtility::convert_time_zone(strtotime($startDateTime),date_default_timezone_get(),Yii::app()->session['timezone']);
       $endDateTime =  CommonUtility::convert_time_zone(strtotime($endDateTime),date_default_timezone_get(),Yii::app()->session['timezone']);
             
             
            $eventPostObj->Description=stripslashes($postObj->Description);
            $eventPostObj->StartDate=new MongoDate(strtotime($startDateTime));
            $eventPostObj->EndDate=new MongoDate(strtotime($endDateTime));
            $eventPostObj->StartTime=$postObj->StartTime;
            $eventPostObj->EndTime=$postObj->EndTime; 
            $eventPostObj->EventAttendes=array($postObj->UserId);
            $eventPostObj->Followers=array();
            array_push($eventPostObj->Followers, $eventPostObj->UserId);
            $eventPostObj->Mentions=$postObj->Mentions;
            $eventPostObj->Comments=array();
            $eventPostObj->Love=array();
            /** changed by suresh reddy as  part code review*/
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
            $eventPostObj->IsBlockedWordExist=(int)$postObj->IsBlockedWordExist;
            $eventPostObj->IsWebSnippetExist=(int)$postObj->IsWebSnippetExist;
            $eventPostObj->MigratedPostId = isset($postObj->MigratedPostId)?$postObj->MigratedPostId:'';
            if($postObj->IsFeatured==1){
              $eventPostObj->FeaturedUserId=(int)$postObj->UserId;  
              $eventPostObj->FeaturedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
             $eventPostObj->IsFeatured=(int)$postObj->IsFeatured;
                 $eventPostObj->IsAnonymous=(int)$postObj->IsAnonymous;
              if(isset($userHirarchy)){
                  $eventPostObj->District=(int)$userHirarchy->District;
                  $eventPostObj->Division=(int)$userHirarchy->Division;
                  $eventPostObj->Region=(int)$userHirarchy->Region;
                  $eventPostObj->Store=(int)$userHirarchy->Store;
              }
               $eventPostObj->Title=stripslashes($postObj->Title);
            if($eventPostObj->save()){
                $returnValue=$eventPostObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
          Yii::log("EventPost:SaveEventPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
}
