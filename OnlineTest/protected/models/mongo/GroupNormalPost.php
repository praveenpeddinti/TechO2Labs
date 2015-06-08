<?php

class GroupNormalPost extends EMongoDocument {
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
    public $WebUrls;
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
            'GroupId' => 'GroupId',
            'Priority' => 'Priority',
            'CreatedOn' => 'CreatedOn',
            'CreatedDate' => 'CreatedDate',
            'Description' => 'Description',
            'Followers' => 'Followers',
            'Mentions'=>'Mentions',            
            'Comments' => 'Comments',            
            'Love' => 'Love',
            'Resource' => 'Resource',
            'HashTags' => 'HashTags',
            'Invite'=>'Invite',
            'Share'=>'Share',
            'WebUrls'=>'WebUrls',
            'NetworkId' => 'NetworkId',
            'Status'=>'Status',
            'IsPublic'=>'IsPublic',
            'DisableComments'=>'DisableComments',
            'IsBlockedWordExist'=>'IsBlockedWordExist',
            'NetworkId'=>'NetworkId',
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
       public function SaveGroupNormalPost($postObj,$hashTagIdArray,$userHirarchy){
        try {           
            $returnValue='failure';            
            $GroupnormalPostObj=new GroupNormalPost();
            $GroupnormalPostObj->Type=(int)$postObj->Type;
            $GroupnormalPostObj->UserId=(int)$postObj->UserId;
            $GroupnormalPostObj->PostedBy=(int)$postObj->PostedBy;
            $GroupnormalPostObj->GroupId=new MongoID($postObj->GroupId);
            if(isset($postObj->CreatedOn) && !empty($postObj->CreatedOn)){
                 $GroupnormalPostObj->CreatedOn=new MongoDate(strtotime(date($postObj->CreatedOn, time())));
             }else{
                 $GroupnormalPostObj->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
            $createdOn = $GroupnormalPostObj->CreatedOn;
            $GroupnormalPostObj->CreatedDate=date('Y-m-d', $createdOn->sec);
            $GroupnormalPostObj->Description=stripslashes($postObj->Description);
            $GroupnormalPostObj->Comments=array();            
            $GroupnormalPostObj->Love=array();                       
            $GroupnormalPostObj->Followers=array();
            array_push($GroupnormalPostObj->Followers, $GroupnormalPostObj->UserId);
            $GroupnormalPostObj->Resource =array();
            $GroupnormalPostObj->Mentions=$postObj->Mentions;
            $GroupnormalPostObj->HashTags=$hashTagIdArray;
            $GroupnormalPostObj->Invite=array();
            $GroupnormalPostObj->Share=array();
            $GroupnormalPostObj->WebUrls=$postObj->WebUrls;
            $GroupnormalPostObj->Status=(int)$postObj->Status;
            $GroupnormalPostObj->IsPublic=(int)$postObj->IsPublic;
            $GroupnormalPostObj->NetworkId = (int) $postObj->NetworkId;
            $GroupnormalPostObj->SegmentId = (int) $postObj->SegmentId;
            $GroupnormalPostObj->Language =  $postObj->Language;
            $GroupnormalPostObj->DisableComments=$postObj->DisableComments;
            $GroupnormalPostObj->IsBlockedWordExist=(int)$postObj->IsBlockedWordExist;
            $GroupnormalPostObj->IsWebSnippetExist=(int)$postObj->IsWebSnippetExist;
            $GroupnormalPostObj->MigratedPostId = isset($postObj->MigratedPostId)?$postObj->MigratedPostId:'';
             
               if(isset($userHirarchy)){
                  $GroupnormalPostObj->District=(int)$userHirarchy->District;
                  $GroupnormalPostObj->Division=(int)$userHirarchy->Division;
                  $GroupnormalPostObj->Region=(int)$userHirarchy->Region;
                  $GroupnormalPostObj->Store=(int)$userHirarchy->Store;
              }
             if($postObj->SubGroupId!=0){
                 $GroupnormalPostObj->SubGroupId=new MongoID($postObj->SubGroupId);
             } 
             $GroupnormalPostObj->Miscellaneous=(int)$postObj->Miscellaneous;
            if($GroupnormalPostObj->save()){
                $returnValue=$GroupnormalPostObj->_id;

            }
            
            return $returnValue;
        } catch (Exception $ex) {  
            Yii::log("GroupNormalPost:SaveGroupNormalPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
}
