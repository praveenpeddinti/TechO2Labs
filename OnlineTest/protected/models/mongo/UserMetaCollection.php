<?php

/* This Collection is Used to store all the profile details of the User
 * 
 * 
 * 
 */

class UserMetaCollection extends EMongoDocument {
    public $_id;
    public $Type;
    public $UserId;
    public $CreatedOn;
    public $Followers=0;//Crowd Puller
    public $UserFollowing=0;//Networker
    public $Loves=0;//Heart
//    public $Mentions=0;//ShoutOut
    public $Comments=0;//BreakTheIce and Insight
//  
    public $HashTags=0; //Smash
//    public $shares=0; //Viral
    public $Posts=0;//Getting Started
    public $CurbsidePosts=0;
//    public $ananymousPosts=0;//
//    public $newsInteraction=0;
//    Public $gamesPlayed=0;


    

    public function getCollectionName() {
        return 'UserMetaCollection';
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
            'index_Type' => array(
                'key' => array(
                    'Type' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
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
            'UserFollowing' => 'UserFollowing',
            'Followers' => 'Followers',
            'Loves' => 'Loves',
            'Comments' => 'Comments',
             'Posts' => 'Posts',
            'CurbsidePosts'=>'CurbsidePosts',
            'HashTags'=>'HashTags'
           
        );
    }


 
  /* This method is used to save into the user meta collection  
   * it accepts the UserMetaCollectionObject and returns true or false 
    */
    public function saveUserMetaCollection($metaCollectionObj){

        try {
            
            $userMetaCollection=new UserMetaCollection();
            $userMetaCollection->UserId=(int)$metaCollectionObj['UserId'];
            $userMetaCollection->UserFollowing=(int)$metaCollectionObj['UserFollowing'];
            $userMetaCollection->Followers=(int)$metaCollectionObj['Followers'];
            $userMetaCollection->Loves=(int)$metaCollectionObj['Loves'];
             $userMetaCollection->Comments=(int)$metaCollectionObj['Comments'];
              $userMetaCollection->Posts=(int)$metaCollectionObj['Posts'];
              $userMetaCollection->CurbsidePosts=(int)$metaCollectionObj['CurbsidePosts'];
               $userMetaCollection->HashTags=(int)$metaCollectionObj['HashTags'];
            $userMetaCollection->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $userMetaCollection->save();
            if (isset($userMetaCollection->_id)) {
                $returnValue = $userMetaCollection->_id;
            }else{
               
              return 'error';
            }
         
            return $returnValue;

           
        } catch (Exception $ex) {
            Yii::log("UserMetaCollection:saveUserMetaCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

   
    
     public function getUserMetaCollectionByUserId($UserId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
             $criteria->UserId= (int)$UserId;
            $ubObj = UserMetaCollection::model()->find($criteria);
            $returnValue = $ubObj;
      
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserMetaCollection:getUserMetaCollectionByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
      /**
     * author: swathi
     * @param type $postId
     * @param type $userId
     * @return type stream object
     */

    public function updateUserMetaCollection($obj,$preparedObj,$userId,$addValue) {

        try {
          
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('CreatedOn', 'set', $obj->CreatedOn); 
          
            if((string)$preparedObj['UserFollowing']=='Yes'){
                $mongoModifier->addModifier('UserFollowing', 'set',  (int)($obj->UserFollowing)+$addValue); 
            }
            if((string)$preparedObj['Followers']=='Yes')
              { 
               
              $mongoModifier->addModifier('Followers', 'set', (int)($obj->Followers)+$addValue); 
              }
              if((string)$preparedObj['Loves']=='Yes')
              { 
               
              $mongoModifier->addModifier('Loves', 'set', (int)($obj->Loves)+$addValue); 
              }
               if((string)$preparedObj['Comments']=='Yes')
              { 
              
              
              $mongoModifier->addModifier('Comments', 'set', (int)($obj->Comments)+$addValue); 
              }
               if((string)$preparedObj['Posts']=='Yes')
              { 
                $mongoModifier->addModifier('Posts', 'set', (int)($obj->Posts)+$addValue); 
              }
               if((string)$preparedObj['CurbsidePosts']=='Yes')
              { 
                $mongoModifier->addModifier('CurbsidePosts', 'set', (int)($obj->CurbsidePosts)+$addValue); 
              }
               if((string)$preparedObj['HashTags']=='Yes')
              { 
                $mongoModifier->addModifier('HashTags', 'set', (int)($obj->HashTags)+$addValue); 
              }
            $mongoCriteria->addCond('_id', '==', new MongoId($obj->_id));
            $mongoCriteria->addCond('UserId', '==', (int) $userId);
            $res = UserMetaCollection::model()->updateAll($mongoModifier, $mongoCriteria);


            return $res;
        } catch (Exception $ex) {
          Yii::log("UserMetaCollection:updateUserMetaCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
      /**
     * author: swathi
     * @param type $postId
     * @param type $userId
     * @return type stream object
     */

    public function updateUserMetaCollectionByProperty($obj,$countValue,$userId,$property) {

        try {
           
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('CreatedOn', 'set', $obj->CreatedOn); 
             $mongoModifier->addModifier($property, 'set', (int)($countValue)); 
             
            $mongoCriteria->addCond('_id', '==', new MongoId($obj->_id));
            $mongoCriteria->addCond('UserId', '==', (int) $userId);
            $res = UserMetaCollection::model()->updateAll($mongoModifier, $mongoCriteria);


            return $res;
        } catch (Exception $ex) {
          Yii::log("UserMetaCollection:updateUserMetaCollectionByProperty::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    }
