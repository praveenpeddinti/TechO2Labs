<?php

/* @author Sagar
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Segment extends CActiveRecord {

    public $SegmentId;
    public $SegmentName;
    public $SegmentURL;
    public $Status;
    public $CreatedOn;
    public $NetworkId;
    public $Language;
    public $SegmentFlag;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Segment';
    }

    public function getAllSegmentsByNetwork($networkId) {
        $returnValue = array();
        try {
            $segmentData = Segment::model()->findAllByAttributes(array("NetworkId" => (int)$networkId));
            if(isset($segmentData) && !empty($segmentData)){
                $returnValue=$segmentData;
            }
        } catch (Exception $ex) {
            Yii::log("Segment:getAllSegmentsByNetwork::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $returnValue = 'failure';
        }
        return $returnValue;
    }
    public function getSegmentByAttributes($attributeArray) {
        $returnValue = 'failure';
        try {
            $segmentObj = Segment::model()->findByAttributes($attributeArray);
            if (isset($segmentObj)) {
                $returnValue = $segmentObj;
            }
        } catch (Exception $ex) {
            Yii::log("Segment:getSegmentByAttributes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $returnValue = 'failure';
        }
        return $returnValue;
    }
}
