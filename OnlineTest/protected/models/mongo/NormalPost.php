<?php

class NormalPost extends EMongoDocument {
    public $_id;
    public $Type;
    public $UserId;
    public $Priority;
    public $CreatedOn;
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
            )
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
            'Mentions'=>'Mentions',            
            'Comments' => 'Comments',            
            'Love' => 'Love',
            'Resource' => 'Resource',
            'HashTags' => 'HashTags',
            'Invite'=>'Invite',
            'Share'=>'Share',
            'WebUrls'=>'WebUrls',
            'NetworkId'=>'NetworkId',
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
            'MigratedPostId'=>'MigratedPostId',
            'PostedBy'=>'PostedBy',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
        );
    }
       public function SaveNormalPost($postObj,$hashTagIdArray,$userHirarchy){
        try {
            $returnValue='failure';            
//throw new Exception('Division by zero.');
            $normalPostObj=new NormalPost();
            $normalPostObj->Type=(int)$postObj->Type;
             $normalPostObj->Type=(int)$postObj->Type;
            $normalPostObj->UserId=(int)$postObj->UserId;
            $normalPostObj->PostedBy=(int)$postObj->PostedBy;
            if(isset($postObj->CreatedOn) && !empty($postObj->CreatedOn)){
                 $normalPostObj->CreatedOn=new MongoDate(strtotime(date($postObj->CreatedOn, time())));
             }else{
                 $normalPostObj->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
            
            /*
             * uncomment the below line and comment the above line if we call this method for datamigration purpose
             */
            //$normalPostObj->CreatedOn=new MongoDate(strtotime($postObj->CreatedOn));
            $normalPostObj->Description=stripslashes($postObj->Description);
            $normalPostObj->Comments=array();            
            $normalPostObj->Love=array();                       
            $normalPostObj->Followers=array();
            array_push($normalPostObj->Followers, $normalPostObj->UserId);
            $normalPostObj->Resource =array();
            $normalPostObj->Mentions=$postObj->Mentions;
            $normalPostObj->HashTags=$hashTagIdArray;
            $normalPostObj->Invite=array();
            $normalPostObj->Share=array();
            $normalPostObj->WebUrls=$postObj->WebUrls;
            $normalPostObj->NetworkId=(int)$postObj->NetworkId;
            $normalPostObj->SegmentId=(int)$postObj->SegmentId;
            $normalPostObj->Language=$postObj->Language;
            
            $normalPostObj->DisableComments=$postObj->DisableComments;
            $normalPostObj->IsBlockedWordExist=(int)$postObj->IsBlockedWordExist;
            $normalPostObj->IsWebSnippetExist=(int)$postObj->IsWebSnippetExist;
            $normalPostObj->MigratedPostId = isset($postObj->MigratedPostId)?$postObj->MigratedPostId:'';
             if($postObj->IsFeatured==1){
              $normalPostObj->FeaturedUserId=(int)$postObj->UserId;  
              $normalPostObj->FeaturedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
              $normalPostObj->IsAnonymous=(int)$postObj->IsAnonymous;
              $normalPostObj->IsFeatured=(int)$postObj->IsFeatured;
              if(isset($userHirarchy)){                  
                  $normalPostObj->District=(int)$userHirarchy->District;
                  $normalPostObj->Division=(int)$userHirarchy->Division;
                  $normalPostObj->Region=(int)$userHirarchy->Region;
                  $normalPostObj->Store=(int)$userHirarchy->Store;
              }
            if($normalPostObj->save()){
                $returnValue=$normalPostObj->_id;

            }
            return $returnValue;
        } catch (Exception $ex) {              
            Yii::log("NormalPost:SaveNormalPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             return "failure";
        }
        }
        /**
         * @author karteek.v
         * @param type $userid
         * @method getPostsCount
         * @return integer type count value
         */
        public function getPostsCount($userid){
            try{
                $postCnt = NormalPost::model()->countByAttributes(array("UserId"=>(int)$userid));
            } catch (Exception $ex) {
                Yii::log("NormalPost:getPostsCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
            return $postCnt;
        }
        
                /**
         * @author suresh.v
         * @param type $userid
         * @method getpost followers
         * @return integer 
         */
        public function getObjectFollowers($postId){
            try{
             
                 $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Followers'=>true));
            $criteria->addCond('_id', '==', $postId);
            $objFollowers = UserProfileCollection::model()->find($criteria);
            if (isset($objFollowers->Followers)) {
                $returnValue =$objFollowers->Followers;
              
            }
        } catch (Exception $ex) {
            Yii::log("NormalPost:getObjectFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
                
            } catch (Exception $ex) {
                Yii::log("NormalPost:getObjectFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
            return $postCnt;
        }
}
