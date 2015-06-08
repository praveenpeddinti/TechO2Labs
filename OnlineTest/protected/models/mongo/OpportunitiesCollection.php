<?php
/**
 * @author Sagar
 * @copyright 2013 skipta.com
 * @version 3.0
 * @category Stream
 * @package Stream
 */

class OpportunitiesCollection extends EMongoDocument {
  
    public $_id;
    public $UserClassification=1;
    public $Opportunities = array();
    
    public function getCollectionName() {

        return 'OpportunitiesCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_UserClassification' => array(
                'key' => array(
                    'UserClassification' => EMongoCriteria::SORT_ASC
                ),
            )
        );
    }

    public function attributeNames() {
        return array(
            '_id'=>'_id',
            'UserClassification' => 'UserClassification',
            'Opportunities' => 'Opportunities'
        );
    }
  
    public function getOpportunitiesByUserClassification( $userClassification) {
        try {
            $criteria = new EMongoCriteria;
            $criteria->UserClassification = (int)$userClassification;
            $opportunitiesObj = OpportunitiesCollection::model()->find($criteria);
            return $opportunitiesObj;
        }  catch (Exception $ex){
            Yii::log("OpportunitiesCollection:getOpportunitiesByUserClassification::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
      public function getOpportunitiesByOpportunityType( $userClassification,$opportunityType) {
        try {
            $criteria = new EMongoCriteria;
            $c = OpportunitiesCollection::model()->getCollection();
             $opportunitiesObj = $c->aggregate(array('$match' => array('UserClassification' =>(int)$userClassification)),array('$unwind' =>'$Opportunities'),array('$match' => array('Opportunities.OpportunityType' =>"$opportunityType")),array('$group' => array("_id" => '$_id',"Opportunities" => array('$push' => '$Opportunities'))));   
             //  $result = $c->aggregate(array('$match' => array('UserClassification' =>(int)1)),array('$unwind' =>'$Opportunities'),array('$match' => array('Opportunities.EngagementDrivers.Type' =>"Follow_Users")),array('$group' => array("_id" => '$_id',"EngagementDrivers" => array('$push' => '$Opportunities.EngagementDrivers'))));  
           
            return $opportunitiesObj;
        }  catch (Exception $ex){
            Yii::log("OpportunitiesCollection:getOpportunitiesByOpportunityType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}


       
?>
