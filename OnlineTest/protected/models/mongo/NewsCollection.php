<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsCollection extends EMongoDocument{
    public $_id;
    public $Type;
    public $UserId;   
    public $CreatedOn;
    public $Description;            
    public $Resource;    
    public $IsFeatured=0;
    public $FeaturedUserId;
    public $FeaturedOn;
    public $CategoryType;
    public $PostId;
    public $IsAbused=0;
    public $IsDeleted=0;
    public $IsBlockedWordExist = 0;
    public $CreatedDate;
    public $HtmlFragment='';
    public $Title="";
    public $IsMultipleArtifact;
    public $LoveCount=0;
    public $CommentCount=0;
    public $FollowCount=0;
    public $ShareCount=0;
    public $InviteCount=0;
    public $IsAnonymous;
  public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';
    public function getCollectionName() {
        return 'NewsCollection';
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
            'index_PostId' => array(
                'key' => array(
                    'PostId' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_IsAbused' => array(
                'key' => array(
                    'IsAbused' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_IsBlockedWordExist' => array(
                'key' => array(
                    'IsBlockedWordExist' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_IsDeleted' => array(
                'key' => array(
                    'IsDeleted' => EMongoCriteria::SORT_ASC
                ),
            ),
        );
    }
     public function attributeNames() {
        return array(
            '_id'=>'_id',
            'Type' => 'Type',
            'UserId' => 'UserId',            
            'CreatedOn' => 'CreatedOn',
            'Description' => 'Description',            
            'Resource' => 'Resource',
            'IsFeatured'=>'IsFeatured',
            'FeaturedUserId'=>'FeaturedUserId',
            'FeaturedOn'=>'FeaturedOn',
            'CategoryType'=>'CategoryType',
            'PostId'=>'PostId',
            'IsAbused'=>'IsAbused',
            'IsDeleted'=>'IsDeleted',
            'IsBlockedWordExist'=>'IsBlockedWordExist',
            'CreatedDate'=>'CreatedDate',
            'HtmlFragment'=>'HtmlFragment',
            'Title'=>'Title',
            'IsMultipleArtifact'=>'IsMultipleArtifact',
            'LoveCount' => 'LoveCount',
            'CommentCount'=>'CommentCount',
            'FollowCount'=>'FollowCount',
            'ShareCount'=>'ShareCount',
            'InviteCount'=>'InviteCount',
            'IsAnonymous'=>'IsAnonymous',

  
                              
     'NetworkId'=>'NetworkId',
     'SegmentId'=>'SegmentId',
     'Language'=>'Language',
            



        );
    }
    
    
   public function saveNewsCollection($postObj){
   try {
       $returnValue ='failure'; 
          // throw new Exception('Division by zero.');
            $newsCollection=new NewsCollection();
            $newsCollection->Type=(int)$postObj->Type;
            $newsCollection->Title=$postObj->Title;
            $newsCollection->UserId=(int)$postObj->UserId;
            $newsCollection->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            /*
             * uncomment the below line and comment the above line if we call this method for datamigration purpose
             */
            //$postObj->CreatedOn=new MongoDate(strtotime($postObj->CreatedOn));
            $newsCollection->Description=$postObj->Description;                       
            $newsCollection->Resource =$postObj->Resource;
            $newsCollection->NetworkId=(int)$postObj->NetworkId;   
            $newsCollection->SegmentId=(int)$postObj->SegmentId;  
            $newsCollection->Language=$postObj->Language;  
            $newsCollection->FeaturedUserId=(int)$postObj->FeaturedUserId;  
            $newsCollection->FeaturedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));             
            $newsCollection->IsFeatured=(int)$postObj->IsFeatured;
            $newsCollection->PostId=new MongoId($postObj->PostId);
            $newsCollection->CategoryType=(int)$postObj->CategoryType;
            $newsCollection->IsBlockedWordExist=(int)$postObj->IsBlockedWordExist;
            $newsCollection->IsMultipleArtifact=$postObj->IsMultipleArtifact;
            $newsCollection->CreatedDate=date('Y-m-d');  
            $newsCollection->CreatedDate=date('Y-m-d');
            $newsCollection->SegmentId = (int)(isset($postObj->SegmentId)?$postObj->SegmentId:0);
            $newsCollection->LoveCount = (int) $postObj->LoveCount;
            $newsCollection->CommentCount = (int) $postObj->CommentCount;
            $newsCollection->FollowCount = (int) $postObj->FollowCount;
            $newsCollection->InviteCount = (int) $postObj->InviteCount;
            $newsCollection->ShareCount = (int) $postObj->ShareCount;
            if($postObj->CategoryType==8)
            {
            $newsCollection->HtmlFragment=$postObj->HtmlFragment;
            }
            if($newsCollection->save()){
                $returnValue=$newsCollection->_id;

            }
       return $returnValue;
   } catch (Exception $ex) {              
      Yii::log("NewsCollection:saveNewsCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      error_log("Exception Occurred in NewsCollection->saveNewsCollection==".$ex->getMessage());
      return 'failure';
   }
   } 
   public function updateNewsCollection($postId,$categoryId,$actionType){
       $returnValue='failure';
       try {
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;          
           if($actionType=='Abuse'){
            $mongoModifier->addModifier('IsAbused', 'set', (int)1);     
           }
           if($actionType=='Delete'){
            $mongoModifier->addModifier('IsDeleted', 'set', (int)1);        
           }
           if($actionType=='UnFeatured'){
            $mongoModifier->addModifier('IsFeatured', 'set', (int)0);        
           }
           if($actionType=='Release'){
            $mongoModifier->addModifier('IsAbused', 'set', (int)0);             
           }
              if($actionType=='SuspendGame'){
            $mongoModifier->addModifier('IsDeleted', 'set', (int)1);        
           }
           if($actionType=='ReleaseGame'){
            $mongoModifier->addModifier('IsDeleted', 'set', (int)0);        
           }
           $mongoCriteria->addCond('CategoryType', '==', (int)$categoryId); 
           $mongoCriteria->addCond('PostId', '==', new MongoId($postId));  
           NewsCollection::model()->updateAll($mongoModifier,$mongoCriteria);
       } catch (Exception $ex) {
           Yii::log("NewsCollection:updateNewsCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      return $returnValue;
       }
      }
    public function getTotalFeaturedItems($segmentId=0){
         $returnValue='failure';
        try {
            $mongoCriteria = new EMongoCriteria;
              
           $mongoCriteria->addCond('IsFeatured', '==', (int)1); 
           $mongoCriteria->addCond('IsAbused', '==',(int)0); 
           $mongoCriteria->addCond('IsDeleted', '==',(int)0); 
           if($segmentId!=0){
                $mongoCriteria->addCond('SegmentId', 'in',array(0,$segmentId)); 
           }else{
                $mongoCriteria->addCond('SegmentId', '==',0); 
           }
           $featuredItemsCount=NewsCollection::model()->count($mongoCriteria);
           $returnValue=$featuredItemsCount;
           return $returnValue;
        } catch (Exception $ex) {
             Yii::log("NewsCollection:getTotalFeaturedItems::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        }
        
   public function getTotalFeaturedItemsList(){
         $returnValue='failure';
        try {
            $mongoCriteria = new EMongoCriteria;
              
           $mongoCriteria->addCond('IsFeatured', '==', (int)1); 
           $mongoCriteria->addCond('IsAbused', '==',(int)0); 
           $mongoCriteria->addCond('IsDeleted', '==',(int)0); 
           $mongoCriteria->setSort(array('FeaturedOn' => EMongoCriteria::SORT_DESC));
           $featuredItems=NewsCollection::model()->findAll($mongoCriteria);
           $returnValue=$featuredItems;
           return $returnValue;
        } catch (Exception $ex) {
             Yii::log("NewsCollection:getTotalFeaturedItemsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        }
      /*
       * @author Vamsi Krishna
       * @Description This is get featured Item for Daily Digest
       */ 
    public function getFeaturedItemForDigest($startDate,$endDate){
          $returnValue='failure';
        try {
           $mongoCriteria = new EMongoCriteria;              
           //$mongoCriteria->addCond('IsFeatured', '==', (int)1); 
          // $mongoCriteria->addCond('IsAbused', '==',(int)0); 
          // $mongoCriteria->addCond('IsDeleted', '==',(int)0); 
          // $mongoCriteria->limit(1);         
         // $mongoCriteria->addCond('CreatedOn', '>',new MongoDate(strtotime($startDate)));
          //$mongoCriteria->addCond('CreatedOn', '<',new MongoDate(strtotime($endDate)));
          // $mongoCriteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
           $array = array(
            'conditions' => array(                
                 'IsDeleted'=>array('!=' => 1),
                'IsFeatured'=>array('==' => 1),
                'IsBlockedWordExist'=>array('notIn' => array(1,2)),
                'IsAbused'=>array('notIn' => array(1,2)),
               // 'CreatedOn'=>array('>' => array(new MongoDate(strtotime($startDate)))),
               // 'CreatedOn'=>array('<' => array(new MongoDate(strtotime($endDate)))),
            ),
            'limit' => 1,
            
        );

           $featuredItems=NewsCollection::model()->find($array);
           if(isset($featuredItems) ||  is_object($featuredItems) ){
               $returnValue =$featuredItems;
           }
           return $returnValue; 
        } catch (Exception $ex) {
            Yii::log("NewsCollection:getFeaturedItemForDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    public function abusePost($postId, $actionType, $userId="", $isBlockedPost=0){
        try { 
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;     
             
             if($actionType=='Abuse'){
                 $mongoModifier->addModifier('IsAbused', 'set', 1);
                 $mongoModifier->addModifier('AbusedUserId', 'set', (int)$userId);
                 $mongoModifier->addModifier('AbusedOn','set',new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
              }elseif ($actionType=="Block") {
                 if($isBlockedPost==0){
                    $mongoModifier->addModifier('IsAbused', 'set', 2);
                 }else{
                     $mongoModifier->addModifier('IsBlockedWordExist', 'set', 2);
                 }
             }elseif ($actionType="Release") {
                 if($isBlockedPost==0){
                     $mongoModifier->addModifier('IsAbused', 'set', 0);
                 }else{
                     $mongoModifier->addModifier('IsBlockedWordExist', 'set', 0);
                 }
             }
             $mongoCriteria->addCond('PostId', '==', new MongoId($postId));  
             $returnValue=  NewsCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("NewsCollection:abusePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
 public function updateStreamSocialActions($obj) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
         
//            if (isset($obj->LoveUserId) && $obj->LoveUserId != "" && $obj->LoveUserId != 0) {
//             
//                $mongoModifier->addModifier('LoveUserId', 'push', $obj->LoveUserId);
//            }
//            if ($obj->ActionType == "FbShare") {
//                if (isset($obj->FbShare) && $obj->FbShare != "" && $obj->FbShare != 0) {
//                    $mongoModifier->addModifier('FbShare', 'push', $obj->FbShare);
//                }
//            }
//            if ($obj->ActionType == "TwitterShare") {
//                if (isset($obj->TwitterShare) && $obj->TwitterShare != "" && $obj->TwitterShare != 0) {
//                    $mongoModifier->addModifier('TwitterShare', 'push', $obj->TwitterShare);
//                }
//            }
//            if ($obj->ActionType == "Comment") {              
//                if (isset($obj->UserId) && $obj->UserId != 0) {                    
//                    $mongoModifier->addModifier('CommentUserId', 'push', $obj->UserId);
//                }
//            }
//            
//               if ($obj->ActionType == "Play") {              
//                                   
//                    $mongoModifier->addModifier('CurrentScheduledPlayers', 'push', $obj->CurrentScheduledPlayers);
//              
//            }
//              if ($obj->ActionType == "Playing") {              
//                                   
//                    $mongoModifier->addModifier('PlayersCount', 'set', $obj->PlayersCount);
//                      $mongoModifier->addModifier('CurrentScheduleResumePlayers', 'push',(int)$obj->UserId);
//              
//            }
          
            $mongoCriteria->addCond('PostId', '==', new MongoID($obj->PostId));
            $mongoCriteria->addCond('CategoryType', '==', (int) $obj->CategoryType);
            $mongoModifier->addModifier('LoveCount', 'set', $obj->LoveCount);
            $mongoModifier->addModifier('InviteCount', 'set', $obj->InviteCount);
            $mongoModifier->addModifier('ShareCount', 'set', $obj->ShareCount);
            $mongoModifier->addModifier('FollowCount', 'set', $obj->FollowCount);            

            $mongoModifier->addModifier('CommentCount', 'set', $obj->CommentCount);
            NewsCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("NewsCollection:updateStreamSocialActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

    }
   public function updateOrReleaseNewsCollectionForSuspendedUser($userId,$type){
       try {
         $mongoCriteria = new EMongoCriteria;
         $mongoModifier = new EMongoModifier;
         if($type=='Delete'){
          $mongoModifier->addModifier('IsDeleted', 'set', (int)2);    
          $mongoCriteria->addCond('IsDeleted', '==', (int)0);
         }else if($type=='Release'){
          $mongoModifier->addModifier('IsDeleted', 'set', (int)0);    
          $mongoCriteria->addCond('IsDeleted', '==', (int)2);
         }
         
         $mongoCriteria->addCond('UserId', '==', (int)$userId);         
         NewsCollection::model()->updateAll($mongoModifier, $mongoCriteria);
       } catch (Exception $ex) {
           Yii::log("NewsCollection:updateOrReleaseNewsCollectionForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      } 
}