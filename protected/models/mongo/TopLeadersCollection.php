<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TopLeadersCollection extends EMongoDocument {
    public $_id;
    public $ReportDate;
    public $TopUsers=array();
    public $TopSearchItems=array();
    public $TopHashtags=array();
    public $TopNews=array();
    public $CreatedOn;
    public $CreatedDate;
    public $GroupId;
    public $Is_Group=0;
    public $SegmentId=0;
    public $NetworkId=1;
    public function getCollectionName() {
        return 'TopLeadersCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

   public function indexes() {
        return array(
            'index_CreatedOn' => array(
                'key' => array(
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            )
        );
    }

    public function attributeNames() {
        return array(
            '_id' => '_id',
            'ReportDate' => 'EndDate',
            'TopUsers'=>'TopUsers',
            'TopSearchItems'=>'TopSearchItems',
            'TopHashtags'=>'TopHashtags',
            'CreatedDate'=>'CreatedDate',
            'CreatedOn' => 'CreatedOn',
            'GroupId'=>'GroupId',
            'Is_Group'=>'Is_Group',
            'TopNews'=>'TopNews',
            'SegmentId'=>'SegmentId',
            'NetworkId'=>'NetworkId'
        );
    }


    public function saveTopLeadersData($reportDate,$TopUsers,$TopHashtags,$TopSearchitems,$TopNews, $segmentId=0) {
        try {
         
            $returnValue = 'failure';
            $TopLeadersObj = new TopLeadersCollection();
            $TopLeadersObj->TopUsers = $TopUsers;
            $TopLeadersObj->TopSearchItems=$TopSearchitems;
            $TopLeadersObj->TopHashtags = $TopHashtags;
            $TopLeadersObj->TopNews = $TopNews;
            $TopLeadersObj->ReportDate = $reportDate;
            $TopLeadersObj->CreatedDate = date('Y-m-d');
            $TopLeadersObj->Is_Group = (int)0;
            $TopLeadersObj->GroupId = "";
            $TopLeadersObj->SegmentId = (int)$segmentId;
            $TopLeadersObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time()))); 
             $TopLeadersObj->NetworkId = (int) Yii::app()->params['NetWorkId'];
                error_log("@@@@@@@@@@@@@@@22I am saving anal");
            if ($TopLeadersObj->insert()) {
                
                  $TopLeadersObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(json_encode($TopLeadersObj));
                   error_log("@@@@@@@333333333333333333333333");
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val,"TopLeaders");
                
                $returnValue = $TopLeadersObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("TopLeadersCollection:saveTopLeadersData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function getTopLeadersData($reportDate, $segmentId=0) {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;
            $criteria->addCond('CreatedDate', '==', $reportDate);
            $criteria->addCond('Is_Group', '==', (int)0);
          
                $criteria->addCond('SegmentId', '==', (int)$segmentId);
          
            $TopleadersArray = TopLeadersCollection::model()->findAll($criteria);

            if (is_array($TopleadersArray)) {
                $returnValue = $TopleadersArray;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("TopLeadersCollection:getTopLeadersData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function getGroupTopLeadersData($groupId,$reportDate) {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;
            $criteria->addCond('CreatedDate', '==', $reportDate);
            $criteria->addCond('GroupId', '==',  new MongoID($groupId));
            $criteria->addCond('Is_Group', '==', (int)1);
            $GroupTopleadersArray = TopLeadersCollection::model()->findAll($criteria);

            if (is_array($GroupTopleadersArray)) {
                $returnValue = $GroupTopleadersArray;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("TopLeadersCollection:getGroupTopLeadersData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function saveGroupTopLeadersData($groupId,$reportDate,$TopUsers,$TopHashtags,$TopSearchitems) {
        try {
            $returnValue = 'failure';
            $GroupTopLeadersObj = new TopLeadersCollection();
            $GroupTopLeadersObj->TopUsers = $TopUsers;
            $GroupTopLeadersObj->TopSearchItems=$TopSearchitems;
            $GroupTopLeadersObj->TopHashtags = $TopHashtags;
            $GroupTopLeadersObj->ReportDate = $reportDate;
            $GroupTopLeadersObj->GroupId =  new MongoID($groupId);
            $GroupTopLeadersObj->CreatedDate = date('Y-m-d');
            $GroupTopLeadersObj->Is_Group =(int)1;
            $GroupTopLeadersObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time()))); 
            if ($GroupTopLeadersObj->insert()) {
                $returnValue = $GroupTopLeadersObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("TopLeadersCollection:saveGroupTopLeadersData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
     
    
  

}
