<?php

class ActivityCollection extends EMongoDocument{
    public function getCollectionName() {
        
    }
   public function attributeNames() {
        return array(
            'NormalPost' => 'NormalPost',
            'SurveyPost' => 'SurveyPost',
            'EventPost' => 'EventPost',
            'AdvertisementPost' => 'AdvertisementPost',
           
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}