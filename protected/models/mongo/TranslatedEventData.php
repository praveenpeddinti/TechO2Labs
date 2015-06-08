<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class  TranslatedEventData extends TranslatedDataCollection
{
    public $Location;
    
    public function defaultScope()
    {
        return array(
            'conditions'=>array('POST_TYPE'=>array('==' => self::EVENT_POST)),
        );
    }
 
    public function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->POST_TYPE = self::EVENT_POST;
            return true;
        }
        else return false;
    }
 
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function saveTranslatedData($translatedBean) {
        try {
            //checking if the record is already exist
            $criteria = new EMongoCriteria;
            $criteria->PostId = new MongoID($translatedBean->PostId);
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $resObj = TranslatedDataCollection::model()->find($criteria);
            if(is_array($resObj) || is_object($resObj)){
                //if already record exist update the data
                $resObj->PostText = $translatedBean->PostText;
                $resObj->PostType = $translatedBean->PostType;
                        $resObj->Title = $translatedBean->Title;
                $resObj->Location = $translatedBean->Location;
                $resObj->update();
            }else{
                //if record not exist then insert new record 
                $translatedObj = new TranslatedEventData();
                $translatedObj->PostId = new MongoId($translatedBean->PostId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->PostType = $translatedBean->PostType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->PostText = $translatedBean->PostText;
                $translatedObj->Title = $translatedBean->Title;
                $translatedObj->Location = $translatedBean->Location;
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedEventData:saveTranslatedData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TranslatedEventData->saveTranslatedData==".$ex->getMessage());
        }
    }
    public function saveTranslatedFeaturedPost($translatedBean) {
        try {
            //checking if the record is already exist
            $criteria = new EMongoCriteria;
            $criteria->PostId = new MongoID($translatedBean->PostId);
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $resObj = TranslatedDataCollection::model()->find($criteria);
            if(is_array($resObj) || is_object($resObj)){
                //if already record exist update the data
                $resObj->PostType = $translatedBean->PostType;
                $resObj->FeaturedPostText = $translatedBean->FeaturedPostText;
                $resObj->FeaturedTitle = $translatedBean->FeaturedTitle;
                $resObj->update();
            }else{
                //if record not exist then insert new record 
                $translatedObj = new TranslatedEventData();
                $translatedObj->PostId = new MongoId($translatedBean->PostId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->PostType = $translatedBean->PostType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->FeaturedPostText = $translatedBean->FeaturedPostText;
                $translatedObj->FeaturedTitle = $translatedBean->FeaturedTitle;
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedEventData:saveTranslatedFeaturedPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TranslatedEventData->saveTranslatedFeaturedPost==".$ex->getMessage());
        }
    }
}