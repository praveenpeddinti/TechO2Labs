<?php

class SurveyPost extends EMongoDocument {
    
    public $Type;
    public $UserId;
    public $Description;
    public $OptionOne;
    public $OptionTwo;
    public $OptionThree;
    public $OptionFour;
    public $CreatedOn;
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
       
               'DisableComments'=>'DisableComments',
            'IsBlockedWordExist'=>'IsBlockedWordExist',
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
     'NetworkId'=>'NetworkId',
     'SegmentId'=>'SegmentId',
     'Language'=>'Language',
         
        );
    }
    /**
     * author Vamsi Krishna
     * @param type $surveyObj
     * @return type
     * This method id used to save the Survey Post 
     */
    
    public function saveSurveyPost($surveyObj,$userHirarchy){
        try {
            $returnValue='failure';            
         //throw new Exception('Division by zero.');
            $surveyPostObj=new SurveyPost();
            $surveyPostObj->Type=(int)$surveyObj->Type;
            $surveyPostObj->UserId=(int)$surveyObj->UserId;
            $surveyPostObj->PostedBy=(int)$surveyObj->PostedBy;
            if(isset($surveyObj->CreatedOn) && !empty($surveyObj->CreatedOn)){
                 $surveyPostObj->CreatedOn=new MongoDate(strtotime(date($surveyObj->CreatedOn, time())));
             }else{
                 $surveyPostObj->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
            $surveyObj->Description= $surveyObj->Description;
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
            array_push($surveyPostObj->Followers, $surveyPostObj->UserId);
            $surveyPostObj->OptionOneCount=0;
            $surveyPostObj->OptionTwoCount=0;
            $surveyPostObj->OptionThreeCount=0;
            $surveyPostObj->OptionFourCount=0;
            $surveyPostObj->WebUrls=$surveyObj->WebUrls;
            $surveyPostObj->NetworkId = (int) $surveyObj->NetworkId;
            $surveyPostObj->SegmentId = (int) $surveyObj->SegmentId;
            $surveyPostObj->Language= $surveyObj->Language;
            $surveyPostObj->DisableComments=$surveyObj->DisableComments;
            $surveyPostObj->IsBlockedWordExist=(int)$surveyObj->IsBlockedWordExist;
             $surveyPostObj->IsWebSnippetExist=(int)$surveyObj->IsWebSnippetExist;
             $surveyPostObj->MigratedPostId = isset($surveyObj->MigratedPostId)?$surveyObj->MigratedPostId:'';
             if($surveyObj->IsFeatured==1){
              $surveyPostObj->FeaturedUserId=(int)$surveyObj->UserId;  
              $surveyPostObj->FeaturedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
             $surveyPostObj->IsFeatured=(int)$surveyObj->IsFeatured;
               $surveyPostObj->IsAnonymous=(int)$surveyObj->IsAnonymous;
            if (isset($userHirarchy)) {
                $surveyPostObj->District = (int)$userHirarchy->District;
                $surveyPostObj->Division = (int)$userHirarchy->Division;
                $surveyPostObj->Region = (int)$userHirarchy->Region;
                $surveyPostObj->Store = (int)$userHirarchy->Store;
            }
              $surveyPostObj->Title=stripslashes($surveyObj->Title);
            if($surveyPostObj->save()){
                $returnValue=$surveyPostObj->_id;

            }
            return $returnValue;
        } catch (Exception $ex) {        
            Yii::log("SurveyPost:saveSurveyPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return "failure";
        }
        }

}
