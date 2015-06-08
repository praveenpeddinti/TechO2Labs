<?php
/**
 * @author Sagar
 * @copyright 2013 skipta.com
 * @version 3.0
 * @category Stream
 * @package Stream
 */

class PictocvCollection extends EMongoDocument {
  
    public $_id;
    public $UserId;
    public $Opportunities = array();
    public $RequestStatus=0;//array(0=>"RequestSent", 1=>"InProcess", 2=>"Success", 3=>"Error")
    public $CreatedOn;
    public $UpdatedOn;
    public $UserClassification;
    public $NetworkId;
    public $SegmentId;


    public function getCollectionName() {

        return 'PictocvCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC
                ),
            )
        );
    }

    public function attributeNames() {
        return array(
            '_id'=>'_id',
            'UserId' => 'UserId',
            'Opportunities' => 'Opportunities',
            'RequestStatus' => 'RequestStatus',
            'CreatedOn'=>'CreatedOn',
            'UserClassification'=>'UserClassification',
            'NetworkId'=>'NetworkId',
            'SegmentId'=>'SegmentId',
            'UpdatedOn'=>'UpdatedOn'
        );
    }
  
    public function getPictocvCollectionByRequest($requestId) {
        try {
            $criteria = new EMongoCriteria;
            $criteria->_id = new MongoId($requestId);
            $pictoCvObj = PictocvCollection::model()->find($criteria);
            return $pictoCvObj;
        }  catch (Exception $ex){
            Yii::log("PictocvCollection:getPictocvCollectionByRequest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    
    public function updatePictoCVCollectionByRequest($requestId,$field,$value,$opportunityType)
    {
        try
        {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('_id', '==', new MongoID($requestId));
            if($field=="ImageUrl")
            {
            $mongoCriteria->Opportunities->OpportunityType("==" ,$opportunityType);
              $mongoModifier->addModifier('Opportunities.$.ImageUrl', 'set', $value);
            }
            else if($field=="RequestStatus")
            {
                $mongoModifier->addModifier('RequestStatus','set', (int)$value); 
            }
            
             $returnValue = PictocvCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            
        } catch (Exception $ex) {
             Yii::log("PictocvCollection:updatePictoCVCollectionByRequest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    /**
     * @author Sagar
     * @usage It is User to save new pictocv object
     * @param type $pictocvObject     * 
     */
    public function savePictoCVObject($pictocvInput) {
        try {
            $result = "failure";
            $pictocvObject = new PictocvCollection();
            $pictocvObject->_id = new MongoId();
            $pictocvObject->UserId = (int)$pictocvInput->UserId;
            $pictocvObject->Opportunities = $pictocvInput->Opportunities;
            $pictocvObject->RequestStatus = 0;
            $pictocvObject->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time()))); 
            $pictocvObject->UpdatedOn="";
            $pictocvObject->UserClassification = (int)$pictocvObject->UserClassification;
            $pictocvObject->NetworkId = (int)$pictocvObject->NetworkId;
            $pictocvObject->SegmentId = (int)$pictocvObject->SegmentId;
            
            if($pictocvObject->save()){
                $result = (string)$pictocvObject->_id;
            }
            return $result;
        }  catch (Exception $ex){
            Yii::log("PictocvCollection:savePictoCVObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
     /**
     * @author Sagar
     * @usage It is User to getPictocvObjectByUserId
     * @param type $userId
     */
    public function getPictocvObjectByUserId($userId) {
        try {
            $criteria = new EMongoCriteria;
            $criteria->UserId = (int)$userId;
            $criteria->RequestStatus = 2;
            //$criteria->UpdatedOn != "";
            $criteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
            $criteria->limit(1);
            
            $pictoCvObj = PictocvCollection::model()->find($criteria);
            
         
            return $pictoCvObj;
        }  catch (Exception $ex){
            Yii::log("PictocvCollection:getPictocvObjectByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    public function getPictocvObjectByOppertunity($userId, $opportunityType) {
        try {
            $returnVal = "failure";
            $criteria = new EMongoCriteria;
            $c = PictocvCollection::model()->getCollection();
            $opportunitiesObj = $c->aggregate(
                array('$match' => array('UserId' =>(int)$userId,'RequestStatus'=>2)),
                array('$unwind' =>'$Opportunities'),
                array('$match' => array('Opportunities.OpportunityType' =>$opportunityType)),
                array('$sort' => array('CreatedOn'=>-1)),
                array('$limit' => 1),
                array('$group' => array("_id" => '$UserId',"Opportunities" => array('$push' => '$Opportunities')))
            ); 
           
            if(isset($opportunitiesObj["result"]) && isset($opportunitiesObj["result"]["0"])){
                $returnVal = $opportunitiesObj["result"]["0"];
            }
            return $returnVal;
        }  catch (Exception $exc){
            Yii::log("=====OpportunitiesCollection/getOpportunitiesByUserClassification=====".$exc->getMessage(), 'error', 'application');
        }
    }

    
     
    

    public function updatePictoCVStatusByRequestId($requestId,$status)
    {
        try
        {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('_id', '==', new MongoID($requestId));
            $value = 3;//Error
            if($status=="Success"){
                $value = 1;//Inprogress
            }
            $mongoModifier->addModifier('RequestStatus','set', (int)$value); 
            PictocvCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
             Yii::log("PictocvCollection:updatePictoCVCollectionByRequest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }

}


       
?>
