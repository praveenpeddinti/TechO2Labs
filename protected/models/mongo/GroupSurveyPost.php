<?php

class GroupSurveyPost extends EMongoDocument {
   
    
     public $Type;
    public $UserId;
    public $Description;
    public $OptionOne;
    public $OptionTwo;
    public $OptionThree;
    public $OptionFour;
    public $CreatedOn;
    public $CreatedDate;
    public $Status=1;
    public $Priority;
    public $ExpiryDate;
    public $SurveyTaken=array();
    public $Followers=array();
    public $Share=array();
    public $Love=array();
    public $Comments=array();
    public $OptionOneCount;
    public $OptionTwoCount;
    public $OptionThreeCount;
    public $OptionFourCount;
    public $WebUrls;
    public $GroupId;
    public $IsPublic;
    public $DisableComments=0;
    public $Resource;
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
    public $HashTags;
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
            'Followers' => 'Followers',
            'OptionOne'=>'OptionOne',            
            'OptionTwo'=>'OptionTwo',            
            'OptionThree'=>'OptionThree',            
            'OptionFour'=>'OptionFour',            
            'ExpiryDate' => 'ExpiryDate',            
            'SurveyTaken' => 'SurveyTaken',
            'Status' => 'Status',                       
            'Share'=>'Share',
            'Love'=>'Love',
            'Comments'=>'Comments',
            'OptionOneCount'=>'OptionOneCount',
            'OptionTwoCount'=>'OptionTwoCount',
              'OptionThreeCount'=>'OptionThreeCount',
             'OptionFourCount'=>'OptionFourCount',
            'WebUrls'=>'WebUrls',
            'Status'=>'Status',
            'IsPublic'=>'IsPublic',
            'DisableComments'=>'DisableComments',
            'Resource'=>'Resource',
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
            'HashTags' => 'HashTags',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
            'Miscellaneous' => 'Miscellaneous',
        );
    }
    /**
     * author Vamsi Krishna updated by suresh reddy change expirty date string to mongod date
     * @param type $surveyObj
     * @return type
     * This method id used to save the Survey Post 
     */
    
    public function saveGroupSurveyPost($surveyObj,$hashTagIdArray,$userHirarchy){
        try {
            $returnValue='failure';            
         
            $surveyPostObj=new GroupSurveyPost();
            $surveyPostObj->Type=(int)$surveyObj->Type;
            $surveyPostObj->UserId=(int)$surveyObj->UserId;
            $surveyPostObj->PostedBy=(int)$surveyObj->PostedBy;
            $surveyPostObj->GroupId=new MongoID($surveyObj->GroupId);
            if(isset($surveyObj->CreatedOn) && !empty($surveyObj->CreatedOn)){
                 $surveyPostObj->CreatedOn=new MongoDate(strtotime(date($surveyObj->CreatedOn, time())));
             }else{
                 $surveyPostObj->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
            $createdOn = $surveyPostObj->CreatedOn;
            $surveyPostObj->CreatedDate=date('Y-m-d', $createdOn->sec);
            $surveyPostObj->Description= $surveyObj->Description;
            $surveyPostObj->Description=stripslashes($surveyObj->Description);
            $surveyPostObj->Priority=0;
            $surveyPostObj->OptionOne=stripslashes($surveyObj->OptionOne);
            $surveyPostObj->OptionTwo=stripslashes($surveyObj->OptionTwo);
            $surveyPostObj->OptionThree=stripslashes($surveyObj->OptionThree);
            $surveyPostObj->OptionFour=stripslashes($surveyObj->OptionFour);
            $surveyPostObj->ExpiryDate=new MongoDate(strtotime($surveyObj->ExpiryDate));   
            $surveyPostObj->Status=$surveyObj->Status;
            $surveyPostObj->SurveyTaken=array();
            $surveyPostObj->Share=array();
            $surveyPostObj->Love=array(); 
            $surveyPostObj->Followers=array();
            $surveyPostObj->HashTags=$hashTagIdArray;
            array_push($surveyPostObj->Followers, $surveyPostObj->UserId);
            $surveyPostObj->OptionOneCount=0;
            $surveyPostObj->OptionTwoCount=0;
            $surveyPostObj->OptionThreeCount=0;
            $surveyPostObj->OptionFourCount=0;
            $surveyPostObj->WebUrls=$surveyObj->WebUrls;
            $surveyPostObj->Status=(int)$surveyObj->Status;
            $surveyPostObj->IsPublic=(int)$surveyObj->IsPublic;
            $surveyPostObj->NetworkId = (int) $surveyObj->NetworkId;
            $surveyPostObj->SegmentId = (int) $surveyObj->SegmentId;
            $surveyPostObj->Language = $surveyObj->Language;
            $surveyPostObj->DisableComments=$surveyObj->DisableComments;
            $surveyPostObj->Resource=array();
            $surveyPostObj->IsBlockedWordExist=(int)$surveyObj->IsBlockedWordExist;
            $surveyPostObj->IsWebSnippetExist=(int)$surveyObj->IsWebSnippetExist;
            $surveyPostObj->MigratedPostId = isset($surveyObj->MigratedPostId)?$surveyObj->MigratedPostId:'';
               if(isset($userHirarchy)){
                  $surveyPostObj->District=(int)$userHirarchy->District;
                  $surveyPostObj->Division=(int)$userHirarchy->Division;
                  $surveyPostObj->Region=(int)$userHirarchy->Region;
                  $surveyPostObj->Store=(int)$userHirarchy->Store;
              }
               $surveyPostObj->Title=stripslashes($surveyObj->Title);
                 if($surveyObj->SubGroupId!=0){
                 $surveyPostObj->SubGroupId=new MongoID($surveyObj->SubGroupId);
             } 
             $surveyPostObj->Miscellaneous=(int)$surveyObj->Miscellaneous;
            if($surveyPostObj->save()){
                $returnValue=$surveyPostObj->_id;

            }
            return $returnValue;
        } catch (Exception $ex) {        
            Yii::log("GroupSurveyPost:saveGroupSurveyPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }

}
