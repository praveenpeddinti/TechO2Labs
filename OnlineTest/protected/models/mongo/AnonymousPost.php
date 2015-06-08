<?php
/**
 * This collection is used save the anonymous post
 * @author Haribabu
 */
class AnonymousPost extends EMongoDocument {
    public $_id;
    public $Type;
    public $UserId;
    public $Priority;
    public $CreatedOn;
    public $Description;
    public $Followers=array();
    public $Mentions;
    public $Comments;
    public $Resource;
    public $Love;
    public $HashTags;
    public $Invite;
    public $Share;
    public $WebUrls;
    public $IsBlockedWordExist=0;
    public $Division=0;
    public $District=0;
    public $Region=0;
    public $Store=0;
    public $MigratedPostId='';
    public $IsFeatured=0;
    public $FeaturedUserId;
    public $FeaturedOn; 
     public $IsWebSnippetExist = 0;
     
     
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
            'Mentions'=>'Mentions',            
            'Comments' => 'Comments',            
            'Love' => 'Love',
            'Resource' => 'Resource',
            'HashTags' => 'HashTags',
            'Invite'=>'Invite',
            'Share'=>'Share',
            'WebUrls'=>'WebUrls',
               'NetworkId'=>'NetworkId',
     'SegmentId'=>'SegmentId',
     'Language'=>'Language',
            'IsBlockedWordExist'=>'IsBlockedWordExist',
             'Division'=>'Division',
            'District'=>'District',
            'Region'=>'Region',
             'Store'=>'Store',
            'MigratedPostId'=>'MigratedPostId',
            'IsFeatured'=>'IsFeatured',
             'FeaturedUserId'=>'FeaturedUserId',
            'FeaturedOn'=>'FeaturedOn',
             'IsWebSnippetExist'=>'IsWebSnippetExist',
        );
    }
    /**
     * @author Haribabu
     * @param type $postObj
     * @method save AnonymousPost
     * @return object type id value
     */
       public function SaveAnonymousPost($postObj,$hashTagIdArray,$userHirarchy){
        try {
           
            $returnValue='failure';            

            $anonymousPostObj=new AnonymousPost();
            $anonymousPostObj->Type=(int)$postObj->Type;
            $anonymousPostObj->UserId=(int)$postObj->UserId;
            if(isset($postObj->CreatedOn) && !empty($postObj->CreatedOn)){
                 $anonymousPostObj->CreatedOn=new MongoDate(strtotime(date($postObj->CreatedOn, time())));
             }else{
                 $anonymousPostObj->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
            $anonymousPostObj->Description=$postObj->Description;
            $anonymousPostObj->Comments=array();            
            $anonymousPostObj->Love=array();                       
            //$anonymousPostObj->Followers=array();
             array_push($anonymousPostObj->Followers, (int)$postObj->UserId);
            $anonymousPostObj->Resource =array();
            $anonymousPostObj->Mentions=$postObj->Mentions;
            $anonymousPostObj->HashTags=$hashTagIdArray;
            $anonymousPostObj->Invite=array();
            $anonymousPostObj->Share=array();
            $anonymousPostObj->IsWebSnippetExist=(int)$postObj->IsWebSnippetExist;
            $anonymousPostObj->WebUrls=$postObj->WebUrls;
            $anonymousPostObj->NetworkId=(int)$postObj->NetworkId;
            $anonymousPostObj->SegmentId=(int)$postObj->SegmentId;
            $anonymousPostObj->Language=$postObj->Language;
            $anonymousPostObj->IsBlockedWordExist=(int)$postObj->IsBlockedWordExist;
            $anonymousPostObj->MigratedPostId = isset($postObj->MigratedPostId)?$postObj->MigratedPostId:'';
            if($postObj->IsFeatured==1){
              $anonymousPostObj->FeaturedUserId=(int)$postObj->UserId;  
              $anonymousPostObj->FeaturedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
             }
             $anonymousPostObj->IsFeatured=(int)$postObj->IsFeatured;
              if (isset($userHirarchy)) {
                $anonymousPostObj->District = (int)$userHirarchy->District;
                $anonymousPostObj->Division = (int)$userHirarchy->Division;
                $anonymousPostObj->Region = (int)$userHirarchy->Region;
                $anonymousPostObj->Store = (int)$userHirarchy->Store;
            }
            if($anonymousPostObj->save()){
                $returnValue=$anonymousPostObj->_id;

            }
            return $returnValue;
        } catch (Exception $ex) {  
            Yii::log("AnonymousPost:SaveAnonymousPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
}
