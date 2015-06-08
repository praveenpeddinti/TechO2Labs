<?php

class HashTagCollection extends EMongoDocument {
    public $_id;
    public $HashTagName;
    public $Post;
    public $CreatedUserId;
    public $HashTagFollowers=array();
    public $CurbsidePostId=array();
    public $CurbsidePostCount;
    public $GroupPostId=array();
    public $Status;
    public $News=array();
    public $SegmentId=0;

    public function getCollectionName() {
        return 'HashTagCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_CreatedUserId' => array(
                'key' => array(
                    'CreatedUserId' => EMongoCriteria::SORT_ASC,
                    'HashTagName' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_HashTagName' => array(
                'key' => array(
                    'HashTagName' => EMongoCriteria::SORT_ASC
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            '_id' => '_id',
            'HashTagName' => 'HashTagName',
            'Post' => 'Post',
            'CreatedUserId'=>'CreatedUserId',
            'HashTagFollowers' => 'HashTagFollowers',
            'Status' => 'Status',
            'CurbsidePostId'=>'CurbsidePostId',
            'CurbsidePostCount'=>'CurbsidePostCount',
             'GroupPostId'=>'GroupPostId',
            'News'=>'News',
            'SegmentId'=>'SegmentId'
        );
    }

    public function saveHashTags($hashTag) {
        try {
            $returnValue = 'failure';
            $hashTagObj = new HashTagCollection();
            $hashTagObj->HashTagName = $hashTag->HashTagName;
            $hashTagObj->CreatedUserId=$hashTag->CreatedUserId;
            $hashTagObj->Post = array();

            $hashTagObj->CurbsidePostId = array();
            $hashTagObj->CurbsidePostCount =0;
            $hashTagObj->HashTagFollowers = array();
            $hashTagObj->News = array();
            $hashTagObj->SegmentId = isset($hashTag->SegmentId)?(int)$hashTag->SegmentId:0;

            array_push($hashTagObj->HashTagFollowers,(int)$hashTag->CreatedUserId);

            $hashTagObj->Status = 1;
            
            if ($hashTagObj->insert()) {
                $returnValue = $hashTagObj->_id;
                
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:saveHashTags::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getHashTags($hashTagName) {
        try {
            $returnValue = 'noHashTag';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('HashTagName', '==', $hashTagName);
            $hashTagObj = HashTagCollection::model()->findAll($mongoCriteria);
            
            if (isset($hashTagObj[0]->HashTagName)) {
                 $returnValue =$hashTagObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:getHashTags::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function updateHashTagCollectionWithPostId($postId,$hashTagId,$categoryId=''){
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            /**
             * the below code is changed because if the post type is curbside post then update the curbside post collection
             * Haribabu 
             */
            if($categoryId ==2){
                $hashTagObj = $this->getHashTagsById($hashTagId);
                $curbsidpostcount=count($hashTagObj->CurbsidePostId);
                $updatedcount=$curbsidpostcount+1;
                $mongoModifier->addModifier('CurbsidePostCount', 'set', $updatedcount);
                $mongoModifier->addModifier('CurbsidePostId', 'push', new MongoID($postId));
               
            }else if($categoryId==3){
                $mongoModifier->addModifier('GroupPostId', 'push',  new MongoID($postId));
            }else if($categoryId==8){
                $mongoModifier->addModifier('News', 'push',  new MongoID($postId));
            }else{
                $mongoModifier->addModifier('Post', 'push', new MongoID($postId)); 
            }
           // $mongoModifier->addModifier('Post', 'push', $postId);
            $mongoCriteria->addCond('_id', '==', new MongoID($hashTagId));
            $hashTagCollection = HashTagCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:updateHashTagCollectionWithPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
    * @Author Sagar Pathapelli
    * This method is used get getHashTagsBySearchKey
    * @param type $searchKey
    * @return type
    */
    public function getHashTagsBySearchKey($searchKey, $hashtagArray) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('HashTagName'=>true));
            $criteria->addCond('HashTagName', '==', new MongoRegex('/'.$searchKey.'.*/i'));
            $criteria->addCond('HashTagName','notin',$hashtagArray);
            $hashTagObj = HashTagCollection::model()->findAll($criteria);
            
            if (isset($hashTagObj)) {
                 $returnValue =$hashTagObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:getHashTagsBySearchKey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getHashTagFollowers($hashTagId){
        try {
            $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
           // echo $hashTagId;
              $mongoCriteria->addCond('_id', '==',new MongoId($hashTagId));
             $hashTagObj = HashTagCollection::model()->find($mongoCriteria);
            if(isset($hashTagObj)){                
                $returnValue=$hashTagObj;
            }
            return $hashTagObj;
        } catch (Exception $ex) {
           Yii::log("HashTagCollection:getHashTagFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
  
 /**
  * This method is used to get the hashtagobject by using hashtagId
  * @param type $hashTagId
  * @return type hashtag object
  *  @author Haribabu
  */
        
        
    public function getHashTagsById($hashTagId) {
        try {
            $returnValue = 'noHashTag';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('_id', '==', new MongoID($hashTagId));
            $hashTagObj = HashTagCollection::model()->find($mongoCriteria);
             $returnValue =$hashTagObj;

            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:getHashTagsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
  /**
   * This method is used get all hashtags in desc order
   * @return type 
   *  @author Haribabu
   */  
    public function getAllHashTags() {
        try {
            $returnValue = 'noHashTag';
            
            $array = array(
              //  'limit' => 10,
                'sort' => array('CurbsidePostCount' => EMongoCriteria::SORT_DESC),
            );

            $criteria = new EMongoCriteria($array);
            $Hasttagobject = HashTagCollection::model()->findAll($criteria);
           
            if($Hasttagobject){
                 $returnValue=$Hasttagobject;
            }
            
            return $returnValue;
          
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:getAllHashTags::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getAllHashTagsBySegmentId($userId, $segmentId=0) {
        try {
            $returnValue = 'failure';
            $hashtagFollowing = array();
            $selectArray=array('hashtagsFollowing'=>true);
            $userProfileCollection = UserProfileCollection::model()->getUserProfileCollectionByType($userId,$selectArray,0);
            if(isset($userProfileCollection->hashtagsFollowing) && is_array($userProfileCollection->hashtagsFollowing)){
                $hashtagFollowing = array_unique($userProfileCollection->hashtagsFollowing);
            }
          
            $segmentIdArray = array(0);
            if($segmentId!=0){
                $segmentIdArray = array($segmentId,0);
            }
            $orCondition = array('$or' => [
                    array(
                        'SegmentId' => array('$in' => $segmentIdArray)
                    ), 
                    array(  
                        'SegmentId' => array('$nin' => $segmentIdArray),
                        '_id' => array('$in' => $hashtagFollowing)
                    )
                ],
            );

            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->setConditions($orCondition);
            
            $provider = new EMongoDocumentDataProvider('HashTagCollection', array(
                'pagination' => FALSE,
                'criteria' => $mongoCriteria,
            ));
            return $provider->getData();
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:getAllHashTagsBySegmentId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
 /**
  * This method is used to update the user follow/unfollow on hashtag
  * @param type $actionType (Follow/Unfollow)
  * @param type $userId
  * @author Sagar Pathapelli updated by suresh reddy -remove some unwanted condtions.
  */      
    public function followOrUnfollowHashTag($hashTagId,$userId,$actionType) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'follow' || $actionType == 'Follow') {
                    $mongoModifier->addModifier('HashTagFollowers', 'push', (int)$userId);
                    $mongoCriteria->addCond('HashTagFollowers', '!=', (int)$userId);
            } else {
                $mongoModifier->addModifier('HashTagFollowers', 'pop', (int)$userId);
            }
            $mongoCriteria->addCond('_id', '==', new MongoID($hashTagId));
            $returnValue = HashTagCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:followOrUnfollowHashTag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
    }
    public function updateHashTagCollectionForDelete($obj,$hashTagId){
         $returnValue = 'failure';
        try {      
            
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
             if($obj->CatagoryId==1){
                 if($obj->ActionType=='Block' || $obj->ActionType=='Abuse' || $obj->ActionType=='Delete' ){
                  $mongoModifier->addModifier('Post', 'pull', New MongoId($obj->PostId));  
                 }else if($obj->ActionType=='Release'){
                  $mongoModifier->addModifier('Post', 'push', $obj->PostId);       
                 }
                 
             }
             if($obj->CatagoryId==2){
                   if($obj->ActionType=='Block' || $obj->ActionType=='Abuse' || $obj->ActionType=='Delete' ){
                    $mongoModifier->addModifier('CurbsidePostCount', 'inc',-1);
                    $mongoModifier->addModifier('CurbsidePostId', 'pull', New MongoId($obj->PostId));      
                   }else if($obj->ActionType=='Release'){
                    $mongoModifier->addModifier('CurbsidePostId', 'inc',1);
                    $mongoModifier->addModifier('CurbsidePostId', 'push', $obj->PostId);         
                   }
                 
             }
             if($obj->CatagoryId==3){
                 if($obj->ActionType=='Block' || $obj->ActionType=='Abuse' || $obj->ActionType=='Delete' ){
                  $mongoModifier->addModifier('GroupPostId', 'pull', New MongoId($obj->PostId));    
                 }else if($obj->ActionType=='Release'){
                     $mongoModifier->addModifier('GroupPostId', 'push', $obj->PostId);         
                 }
                 
             }
           $mongoCriteria->addCond('_id', '==', new MongoID($hashTagId));
              HashTagCollection::model()->updateAll($mongoModifier,$mongoCriteria);
           $returnValue ="success";
           return $returnValue; 
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:updateHashTagCollectionForDelete::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
            
    }

    
      /**
   * This method is used get all hashtags in desc order for Curbside filters
   * @return type 
   *  @author Haribabu
   */  
    public function getAllHashTagsForCurbsideFilters() {
        try {
            $returnValue = 'noHashTag';
            
            $array = array(
                'conditions' => array(
                    'CurbsidePostCount' => array('!=' => (int)0)),
                'sort' => array('CurbsidePostCount' => EMongoCriteria::SORT_DESC),
            );

            $criteria = new EMongoCriteria($array);
            $Hasttagobject = HashTagCollection::model()->findAll($criteria);
           
            if($Hasttagobject){
                 $returnValue=$Hasttagobject;
            }
           
            return $returnValue;
          
        } catch (Exception $ex) {
            Yii::log("HashTagCollection:getAllHashTagsForCurbsideFilters::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    

   public function updateHashTagCollectionForGroupActive($obj){
       try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $groupDetails=GroupCollection::model()->getGroupPostIds($obj->GroupId);
            if(!is_string($groupDetails)){
            foreach($groupDetails->PostIds as $postId){
                $mongoModifier->addModifier("GroupPostId", "pull", $postId);
                HashTagCollection::model()->updateAll($mongoModifier,$mongoCriteria);
                }           
            }
            
       } catch (Exception $ex) {
           Yii::log("HashTagCollection:updateHashTagCollectionForGroupActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
       }
      }
   public function updatePostsForHashTags($hashTagId,$groupPostId){
       try {
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;
           $mongoModifier->addModifier('GroupPostId', 'push', $groupPostId); 
           $mongoCriteria->addCond('_id', '==', new MongoID($hashTagId));
           HashTagCollection::model()->updateAll($mongoModifier,$mongoCriteria);
       } catch (Exception $ex) {
          Yii::log("HashTagCollection:updatePostsForHashTags::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
       }
      }   
}
