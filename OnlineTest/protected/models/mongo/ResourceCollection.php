<?php

class ResourceCollection extends EMongoDocument{
    public $_id;
    public $PostId;
    public $ResourceName;
    public $Uri;
    public $Extension;
    public $Width;
    public $Height;
    public $Context;
    public $ContextId;
    public $CreatedOn;
    public $PostType;
    public $GroupId;
    public $StyleClass;
    public $IsDeleted=0;
    public $ThumbNailImage;
    public $SubGroupId;
    
    public function getCollectionName() {
        return 'ResourceCollection';
        
    }
     public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_PostId' => array(
                'key' => array(
                    'PostId' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_CreatedOn' => array(
                'key' => array(
                    'CreatedOn' => EMongoCriteria::SORT_DESC
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            '_id'=>'_id',
            'PostId'=>'PostId',
            'ResourceName' => 'ResourceName',            
            'Uri' => 'Uri',
            'Extension' => 'Extension',
            'Context' => 'Context',
            'ContextId' => 'ContextId',            
            'CreatedOn' => 'CreatedOn',
            'PostType' => 'PostType',
            'GroupId'=>'GroupId',
            'StyleClass'=>'StyleClass',
            'IsDeleted'=>'IsDeleted',
            'ThumbNailImage'=>'ThumbNailImage',
            'SubGroupId'=>'SubGroupId',
             'Width'=>'Width',
             'Height'=>'Height',
            
        );
    }
    
   public function SaveResourceCollection($resourceObj,$postId, $createdDate=''){
       try {
           
            $returnValue='failure';
            $resourceCollection=new ResourceCollection();
            $resourceCollection->PostId=$postId;
            $resourceCollection->ResourceName=$resourceObj->ResourceName;
            $resourceCollection->Uri=$resourceObj->Uri;
            $resourceCollection->Extension=$resourceObj->Extension;
            $resourceCollection->Context="";
            $resourceCollection->ContextId="";   
            $resourceCollection->StyleClass=$resourceObj->StyleClass;       
            $resourceCollection->GroupId= new MongoID($resourceObj->GroupId);
            $resourceCollection->ThumbNailImage=$resourceObj->ThumbNailImage;
            if(isset($createdDate) && !empty($createdDate)){
                $resourceCollection->CreatedOn=new MongoDate(strtotime(date($createdDate, time())));
            }else{
                $resourceCollection->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            }
            if($resourceObj->SubGroupId!=0){
             $resourceCollection->SubGroupId=new MongoId($resourceObj->SubGroupId);    
            }else{
             $resourceCollection->SubGroupId=0;
            }
          
            $resourceCollection->Width=$resourceObj->Width;
            $resourceCollection->Height=$resourceObj->Height;
            if($resourceCollection->save()){
               $returnValue='success';
            }else{
                 $returnValue='failure';
            }
           
           return $returnValue;
                   
            
       } catch (Exception $ex) {
           Yii::log("ResourceCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
      
     /** author Vamsi krishna
      * @param mongoId $groupId 
      * @return success=>Obj Failure=>String
      */ 
    public function getGroupResources($groupId,$type){
        try {
            $returnValue='failure';
            $criteria = new EMongoCriteria;
           if($type=='Group'){
            $criteria->addCond('GroupId', '==', new MongoID($groupId));   
           }else{
            $criteria->addCond('SubGroupId', '==', new MongoID($groupId));      
           }
            
             $criteria->addCond('IsDeleted', '==',0);
            //$criteria->addCond('PostType', '==', 'Group');
            $groupResourceObj=ResourceCollection::model()->findAll($criteria);
            if(is_array($groupResourceObj)){
                $returnValue=$groupResourceObj;
            }
            
           
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ResourceCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
      /** author Vamsi krishna
      * @param mongoId $groupId 
      * @return success=>Obj Failure=>String
      */ 
    public function getGroupImagesAndVideo($groupId,$getCount,$type) {
        try {
           
            $returnValue = 'failure';
            if($getCount!='Count'){
            $array = array('limit' => 9);
            $criteria = new EMongoCriteria($array);
            }else{                
            $criteria = new EMongoCriteria;
            }
            $artifacts=array("jpg","jpeg","gif","mov","mp4","avi","flv","png","mp3","tiff");
            if($type=='Group'){
            $criteria->addCond('GroupId', '==', new MongoID($groupId));    
            $criteria->addCond('SubGroupId', '==', 0);
            }else{
             $criteria->addCond('SubGroupId', '==', new MongoID($groupId));        
            }
            
         
             $criteria->addCond('Extension', 'in',$artifacts);
             $criteria->addCond('IsDeleted', '==',0);


            $groupResourceObj = ResourceCollection::model()->findAll($criteria);
            
            if (is_array($groupResourceObj)) {
                $returnValue = $groupResourceObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ResourceCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
      /** author Vamsi krishna
      * @param mongoId $groupId 
      * @return success=>Obj Failure=>String
      */ 
    public function getGroupArtifacts($groupId,$getCount,$type) {
        try {
            $returnValue = 'failure';
           if($getCount!='Count'){
            $array = array('limit' => 9);
            $criteria = new EMongoCriteria($array);
            }else{                
            $criteria = new EMongoCriteria;
            }     
            $artifacts=array("txt","doc","pdf","ppt","xls","docx","pptx","xlsx","DOCX","PPTX","XLS","PDF","DOC","DOCX","PDF","TXT","XLSX");
            
            if($type=='Group'){
            $criteria->addCond('GroupId', '==', new MongoID($groupId));  
             $criteria->addCond('SubGroupId', '==', 0);
            }else{
                $criteria->addCond('SubGroupId', '==', new MongoID($groupId));
            }
            
           
              $criteria->addCond('Extension', 'in',$artifacts);
              $criteria->addCond('IsDeleted', '==',0);

          
          

            $groupResourceArray = ResourceCollection::model()->findAll($criteria);
            
             if(is_array($groupResourceArray)){
                 $returnValue= $groupResourceArray;
             }
           
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ResourceCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function getGroupImagesAndVideoForDetails($groupId) {
        try {

            $returnValue = 'failure';

            $criteria = new EMongoCriteria;

            $artifacts = array("jpg", "jpeg", "gif", "mov", "mp4", "avi", "flv","png","mp3");
            $criteria->addCond('GroupId', '==', new MongoID($groupId));
            //$criteria->_id('in',$artifacts);
            $criteria->addCond('Extension', 'in', $artifacts);
             $criteria->addCond('IsDeleted', '==',0);
           // $criteria->offset($offset);
           // $criteria->limit($limit);

            $groupResourceObj = ResourceCollection::model()->findAll($criteria);

            if (is_array($groupResourceObj)) {
                $returnValue = $groupResourceObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ResourceCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /** author Vamsi krishna
     * @param mongoId $groupId 
     * @return success=>Obj Failure=>String
     */
    public function getGroupArtifactsDocForDetail($groupId, $limit, $offset) {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;
            $artifacts = array("txt","doc","pdf","ppt","xls","docx","pptx","xlsx","DOCX","PPTX","XLS","PDF","DOC","DOCX","PDF","TXT","XLSX");
            $criteria->addCond('GroupId', '==', new MongoID($groupId));
             $criteria->addCond('IsDeleted', '==',0);
            $criteria->offset($offset);
            $criteria->limit($limit);
            //$criteria->addCond('Extension', '==', 'txt');
            $criteria->_id('in', $artifacts);
            $groupResourceArray = ResourceCollection::model()->findAll($criteria);

            if (is_array($groupResourceArray)) {
                $returnValue = $groupResourceArray;
            }

            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ResourceCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * @author Vamsi Krishna
     * @param type $obj
     * This method is used to update the Resource Collection by PostId
     */
    public function updateResourceCollectionForDelete($obj){
         $returnValue='failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
             if($obj->ActionType=='Block' || $obj->ActionType=='Abuse' || $obj->ActionType=='Delete' ){
            $mongoModifier->addModifier('IsDeleted', 'set',(int)1);
             }else{
            $mongoModifier->addModifier('IsDeleted', 'set', (int)0);     
             }
            $mongoCriteria->addCond('PostId', '==',  new MongoID($obj->PostId)); 
            ResourceCollection::model()->updateAll($mongoModifier,$mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("ResourceCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
            
    }
    

    
      
  public function getAllResources(){
        try {
            $returnValue='failure';
            $groupResourceObj=ResourceCollection::model()->findAll();
            if(is_array($groupResourceObj)){
                $returnValue=$groupResourceObj;
            }
            
           
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ResourceCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
   }
   
 public function UpdateResourceThumbNailImage($thumbNailImage,$Id){
     
      $returnValue='failure';
        try {
           
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('ThumbNailImage', 'set', $thumbNailImage);     
            $mongoCriteria->addCond('_id', '==',  new MongoID($Id)); 
            
           if(ResourceCollection::model()->updateAll($mongoModifier,$mongoCriteria)){
             $returnValue = 'success';
            }
            
        } catch (Exception $ex) {
            Yii::log("ResourceCollection:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
     
 }
    
    
    
    
}
            
           




