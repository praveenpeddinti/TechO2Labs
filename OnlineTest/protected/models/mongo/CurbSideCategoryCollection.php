<?php
/**
 * This collection is used to save  and upadate and get categories in curbsidecategoreis collection
 * 
 *  @author Haribabu
 */
class CurbSideCategoryCollection extends EMongoDocument {
    public $_id;
    public $CategoryId;
    public $CategoryName;
    public $Post;
    public $CreatedOn;
    public $NumberOfPosts;
    public $Status;
    public $Followers;
    public $ProfileImage;
    public $LowerCategoryName;
    public $SegmentId=0;
    
    public function getCollectionName() {
        return 'CurbSideCategoryCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_CategoryId' => array(
                'key' => array(
                    'CategoryId' => EMongoCriteria::SORT_ASC,
                    'CategoryName' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_CategoryName' => array(
                'key' => array(
                    'CategoryName' => EMongoCriteria::SORT_ASC
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            '_id' => '_id',
            'CategoryId' => 'CategoryId',
            'CategoryName' => 'CategoryName',
            'Post' => 'Post',
            'NumberOfPosts' => 'NumberOfPosts',
            'CreatedOn'=>'CreatedOn',
            'Status' => 'Status',
            'Followers'=>'Followers',
            'ProfileImage'=>'ProfileImage',
            'LowerCategoryName'=>'LowerCategoryName',
            'SegmentId'=>'SegmentId'
        );
    }
/**
 * This method is used to  save the curbside categories in curbsidecategories collection
 * @param type $categoryId
 * @param type $model
 * @return type object type id
 *  @author Haribabu
 */
    public function saveCategories($categoryId,$model) {
        try {
            $returnValue = 'failure';
            $CurdsideCategoryObj = new CurbSideCategoryCollection();
            $CurdsideCategoryObj->CategoryId = (int)$categoryId;
            $CurdsideCategoryObj->CategoryName=$model['category'];
            $CurdsideCategoryObj->Post = array();
            $CurdsideCategoryObj->NumberOfPosts = 0;
            $CurdsideCategoryObj->Status = 1;
            $CurdsideCategoryObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $CurdsideCategoryObj->Followers = array();
            $CurdsideCategoryObj->ProfileImage = $model['TopicprofileImage'];
            $CurdsideCategoryObj->LowerCategoryName = strtolower($model['category']);
            $CurdsideCategoryObj->SegmentId = $model->SegmentId;
            if ($CurdsideCategoryObj->insert()) {
                $returnValue = $CurdsideCategoryObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:saveCategories::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
/**
 * This method is used to get all curbside categories
 * @return type categories object
 *  @author Haribabu
 */
    public function getCategories() {
        
        try {
             $array = array(
              //  'limit' => 6,
                'sort' => array('NumberOfPosts' => EMongoCriteria::SORT_DESC),
            );
             
            $criteria = new EMongoCriteria($array);
            $criteria->setSelect(array('CategoryId'=>true,'CategoryName'=>true,'NumberOfPosts'=>true,'Followers'=>true,'ProfileImage'=>true));
            $CategoriesDocument = CurbSideCategoryCollection::model()->findAll($criteria);
            return $CategoriesDocument;
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:getCategories::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getCategoriesBySegmentId($userId, $segmentId=0) {
        try {
            $returnValue = 'failure';
            $curbsideFollowing = array();
            $selectArray=array('curbsideFollowing'=>true);
            $userProfileCollection = UserProfileCollection::model()->getUserProfileCollectionByType($userId,$selectArray,0);
            if(isset($userProfileCollection->curbsideFollowing) && is_array($userProfileCollection->curbsideFollowing)){
                $curbsideFollowing = array_unique($userProfileCollection->curbsideFollowing);
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
                        'CategoryId' => array('$in' => $curbsideFollowing)
                    )
                ],
               // '$sort'=>array('SegmentId'=>array('$meta'=>3,4,2,1,0))
            );

//            $mongoCriteria = new EMongoCriteria;
//            $mongoCriteria->setConditions($orCondition);
//            $returnValue = CurbSideCategoryCollection::model()->findAll($mongoCriteria);
           // $mongoCriteria->sort("SegmentId", array('$meta'=>3,4,2,1,0));
            
//             "weight": { "$cond": [
//           { "$eq": ["_id": 1] },
//           3, 
//           { "$cond": [
//               { "$eq": ["_id": 6] },
//               2,
//               { "$cond": [
//                   { "$eq": ["_id": 3] },
//                   1,
//                   0
//               ]},
//           ]}, 
//       ]}
            
            
            $c = CurbSideCategoryCollection::model()->getCollection();
            $results = $c->aggregate(
                    array('$match' => $orCondition
                    ),
                    array('$project' => array(
//                    'Segment' => array('$cond' => array(
//                            array('$eq' => array("SegmentId" => $segmentId)),
//                            2,
//                            array('$cond' => array(
//                                    array('$eq' => array("SegmentId" => 0)),
//                                    1,0
//                                ))
//                        )),
                        'SegmentId'=>1,
                    'CategoryId'=> 1, 'CategoryName' => 1 , 'NumberOfPosts' => 1 , 'Followers' => 1 , 'ProfileImage' => 1 
                        )
                    
                    ),
                    array('$sort'=>array('SegmentId'=>-1))
            );

        return $results['result'];
            //return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:getCategoriesBySegmentId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
      /**
 * This method is used to get all curbside categories
 * @return type categories object
 *  @author swathi
 */
    public function getCategoriesByIds($ids) {
        
        try {
             $array = array(
              //  'limit' => 6,
     
   
              
            );
          $idsArray=array();
          $idsSplit=split(",",$ids);
        
        for($i=0;$i<count($idsSplit);$i++)
        {
            array_push($idsArray,(int)$idsSplit[$i]);
        }
        
            $criteria = new EMongoCriteria();
            $criteria->addCond('CategoryId', 'in', $idsArray);
            $criteria->setSelect(array('CategoryId'=>true,'CategoryName'=>true,'NumberOfPosts'=>true,'Followers'=>true,'ProfileImage'=>true));
            $CategoriesDocument = CurbSideCategoryCollection::model()->findAll($criteria);
        
            return $CategoriesDocument;
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:getCategoriesByIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
 /**
  * This method is used to update  the curbside categories post count and posts
  * @param type $postId
  * @param type $categoryId
  *  @author Haribabu
  */
    public function updateCurbsideCategoriesWithCategoryId($postId,$categoryId){
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            
             $categoryObj = $this->getCurbsideCategoriesByCategoryId($categoryId);             
                $curbsidpostcount=count($categoryObj->Post);
                $updatedcount=$curbsidpostcount+1;
                $mongoModifier->addModifier('NumberOfPosts', 'set',(int)$updatedcount);
            $mongoModifier->addModifier('Post', 'push', $postId);
            $mongoCriteria->addCond('CategoryId', '==', (int)$categoryId);
            $CategoriesTagCollection = CurbSideCategoryCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
         Yii::log("CurbSideCategoryCollection:updateCurbsideCategoriesWithCategoryId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $categoryObj;
    }
    
/**
 * This method is used to update the curbside category name when update in mysql
 * @param type $model
 *  @author Haribabu
 */    
     public function updateCurbsideCategoriesDetails($model){
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('CategoryName', 'set', $model['category']);
            $mongoCriteria->addCond('CategoryId', '==', (int)$model->id);
            $segmentId = isset($model->SegmentId)?$model->SegmentId:0;
            $mongoCriteria->addCond('SegmentId', '==', (int)$segmentId);
            $mongoModifier->addModifier('LowerCategoryName', 'set', strtolower($model['category']));
            $CategoriesTagCollection = CurbSideCategoryCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:updateCurbsideCategoriesDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * This method is used to get the curbside categories details by using categoryId
     * @param type $categoryId
     * @return type object
     *  @author Haribabu
     */
     public function getCurbsideCategoriesByCategoryId($categoryId) {
        try {
            $returnValue = 'noCategory';
            $mongoCriteria = new EMongoCriteria;
            
            $mongoCriteria->addCond('CategoryId', '==',(int)$categoryId);
            $categoryObj = CurbSideCategoryCollection::model()->find($mongoCriteria);
             $returnValue =$categoryObj;
            return $returnValue;
        } catch (Exception $ex) { 
            Yii::log("CurbSideCategoryCollection:getCurbsideCategoriesByCategoryId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CurbSideCategoryCollection->getCurbsideCategoriesByCategoryId==".$ex->getMessage());
        }
    }
    
    /**
     * This method is used to follow and un follow of curbside posts
     * @param type $categoryId
     * @return type object
     *  @author suresh reddy
     */
     public function followOrUnfollowCurbsideCategory($categoryId,$userId,$actionType) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'follow' || $actionType == 'Follow') {
                $mongoModifier->addModifier('Followers', 'push', (int)$userId);
                $mongoCriteria->addCond('Followers', '!=',$userId);
            } else {
                $mongoModifier->addModifier('Followers', 'pop', $userId);
            }
            $mongoCriteria->addCond('CategoryId', '==',(int)$categoryId);
            $returnValue = CurbSideCategoryCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:followOrUnfollowCurbsideCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
        
    }
    
      /*
     * GetCurbsideCategoryCount: which takes 2 arguments and 
     * returns the total no. of categories.
     */
     public function getPostCountForCategory($categoryId) {
        try {
            $categoryObj = "";
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('CategoryId', '==',(int)$categoryId);
            $categoryObj = CurbSideCategoryCollection::model()->find($mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:getPostCountForCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $categoryObj;
    }

   
    /*
     * @author: Praneeth
     * updateCurbsideCategoryStatus: which takes 2 arguments 1: userId and 2: value.
     * This is used to update the status of a category in mongo.
     */
    public function updateCurbsideCategoryStatusInMongo($categoryid, $categoryvalue) {
        try {
            $return = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if($categoryvalue == 0){
                $mongoModifier->addModifier('Status', 'set', (int)0);//for marking inactive
            }
            else{
                $mongoModifier->addModifier('Status', 'set', (int)1);//for marking active
            }
            $mongoCriteria->addCond('CategoryId', '==', (int)$categoryid);
            $CategorieStatusUpdate = CurbSideCategoryCollection::model()->updateAll($mongoModifier, $mongoCriteria);
           
            if (isset($CategorieStatusUpdate)) {
                    $return = "success";
            }
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:updateCurbsideCategoryStatusInMongo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $return;
    }
    
   /**
     * @uthor VamsiKrishna
     * This method is used to update the Curbside Category for delete
     */
    
    public function updateCurbSideCategoryCollectionForDelete($obj,$categoryId) {
          $returnValue = 'failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;              
           if($obj->ActionType=='Block' || $obj->ActionType=='Abuse' || $obj->ActionType=='Delete' ){

                $mongoModifier->addModifier('NumberOfPosts', 'inc',-1);
           $mongoModifier->addModifier('Post', 'pop', new MongoId($obj->PostId));
           
           }else if($obj->ActionType=='Release'){
                $mongoModifier->addModifier('NumberOfPosts', 'inc',1);
             $mongoModifier->addModifier('Post', 'push', new MongoId($obj->PostId));      
           }
           
            $mongoCriteria->addCond('CategoryId', '==',  (int)$categoryId);            
            CurbSideCategoryCollection::model()->updateAll($mongoModifier,$mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:updateCurbSideCategoryCollectionForDelete::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
      public function getCurbsideCategoriesByCategoryName($name) {
        try {
            $returnValue = 'noCategory';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('CategoryName', '==',$name);
            $categoryObj = CurbSideCategoryCollection::model()->find($mongoCriteria);
             $returnValue =$categoryObj;
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:getCurbsideCategoriesByCategoryName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

      /**
 * This method is used to get all curbside categories
 * @return type categories object
 *  @author Haribabu
 */
    public function getCategoriesForStream($limit,$offset) {
        
        try {
            
            $array = array(
               
            'limit' => $limit,
            'offset' => $offset,
                'sort' => array('LowerCategoryName' => EMongoCriteria::SORT_ASC),
            );

            $criteria = new EMongoCriteria($array);
           // $criteria->setSelect(array('CategoryId'=>true,'CategoryName'=>true,'NumberOfPosts'=>true));
            $CategoriesDocument = CurbSideCategoryCollection::model()->findAll($criteria);
            
            return $CategoriesDocument;
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:getCategoriesForStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
        /**
 * This method is used to update the CategorylowercaseName
 * @return type categories object
 *  @author Haribabu
 */
    public function UpdateCategoriesLowerCategoryName(){
        try{
        $mongoCriteria = new EMongoCriteria;
        $mongoModifier = new EMongoModifier;
        $categories = $this->getCategories();
        foreach ($categories as $key => $value) {
            $categoryId = $value['CategoryId'];
            $categoryname = strtolower($value['CategoryName']);
            $mongoModifier->addModifier('LowerCategoryName', 'set', $categoryname);
            $mongoCriteria->addCond('CategoryId', '==', (int) $categoryId);
            $CategoriesTagCollection = CurbSideCategoryCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        }
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:UpdateCategoriesLowerCategoryName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
       public function getPostById($postId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('CategoryId', '==', (int)$postId);
            $postObj = CurbSideCategoryCollection::model()->find($criteria);
            if (is_object($postObj)) {
                $returnValue = $postObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:getPostById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
       /**
 * This method is used to get all curbside categories
 * @return type categories object
 *  @author Haribabu
 */
    public function getNewlyCreatedCategories($limit,$offset,$startDate,$endDate) {
        
        try {
             
            $array = array(
            // 'conditions' =>array("CreatedOn" => array('' => new MongoDate(strtotime($startDate)), 'lte' => new MongoDate(strtotime($endDate)))),  
            'limit' => 1,
            'offset' => 0,
                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
            );

            $criteria = new EMongoCriteria($array);
            $criteria->addCond("CreatedOn", ">=", new MongoDate(strtotime($startDate)));
            $criteria->addCond("CreatedOn", "<=", new MongoDate(strtotime($endDate)));
          
           // $criteria->setSelect(array('CategoryId'=>true,'CategoryName'=>true,'NumberOfPosts'=>true));
            $CategoriesDocument = CurbSideCategoryCollection::model()->findAll($criteria);
          
            return $CategoriesDocument;
        } catch (Exception $ex) {
            Yii::log("CurbSideCategoryCollection:getNewlyCreatedCategories::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
  
    

}
