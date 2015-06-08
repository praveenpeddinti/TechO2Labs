<?php

/*
 * This Collection Contains all the networks created by the admin
 */

class NetworkCollection extends EMongoDocument {

    public $networkId;
    public $networkName;
    public $status;
    public $createdOn;

    public function getCollectionName() {
        return 'NetworkCollection';
    }
    public function indexes() {
        return array(
            'index_networkId' => array(
                'key' => array(
                    'networkId' => EMongoCriteria::SORT_ASC,
                    'networkName' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_networkName' => array(
                'key' => array(
                    'networkName' => EMongoCriteria::SORT_ASC,
                    'networkId' => EMongoCriteria::SORT_ASC,
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            'networkId' => 'networkId',
            'networkName' => 'networkName',
            'status' => 'status',
            'createdOn' => 'createdOn',
        );
    }
            public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function saveNetwork(){
        try {
            
        } catch (Exception $ex) {
            Yii::log("NetworkCollection:saveNetwork::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in NetworkCollection->saveNetwork==".$ex->getMessage());
        }
        }

}
