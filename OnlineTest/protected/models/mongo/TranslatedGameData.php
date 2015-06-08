<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TranslatedGameData extends TranslatedDataCollection
{
    public $GameName;
    public $GameDescription;
    public $Questions=array();

    
    public function defaultScope()
    {
        return array(
            'conditions'=>array('POST_TYPE'=>array('==' => self::GAME)),
        );
    }
 
    public function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->POST_TYPE = self::GAME;
            return true;
        }
        else return false;
    }
 
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    //find the game is translated 
    public function isGameTranslated($translatedBean){
        $returnValue = array();
        try{
            $criteria = new EMongoCriteria;
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $criteria->PostId = new MongoID($translatedBean->GameId);
            $resObj = TranslatedGameData::model()->find($criteria);
            if(is_array($resObj) || is_object($resObj)){
                $returnValue = (array)$resObj;
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedGameData:isGameTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TranslatedGameData->isGameTranslated==".$ex->getMessage());
        }
	return $returnValue;	
    }
    //if game object not available the insert new record else update the existing one
    public function saveTranslatedData($translatedBean) {
        try {
            //checking if the record is already exist
            $criteria = new EMongoCriteria;
            $criteria->PostId = new MongoID($translatedBean->GameId);
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $resObj = TranslatedGameData::model()->find($criteria);
            if(is_array($resObj) || is_object($resObj)){
                //if already record exist update the data
                $resObj->PostType = $translatedBean->PostType;
                $resObj->GameName = $translatedBean->GameName;
                $resObj->GameDescription = $translatedBean->GameDescription;
                $resObj->update();
            }else{
                //if record not exist then insert new record 
                $translatedObj = new TranslatedGameData();
                $translatedObj->PostId = new MongoId($translatedBean->GameId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->PostType = $translatedBean->PostType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->GameName = $translatedBean->GameName;
                $translatedObj->GameDescription = $translatedBean->GameDescription;
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedGameData:saveTranslatedData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TranslatedGameData->saveTranslatedData==".$ex->getMessage());
        }
    }
    public function saveTranslatedGameQuestions($translatedBean) {
        try {
            //checking if the record is already exist
            $criteria = new EMongoCriteria;
            $criteria->PostId = new MongoID($translatedBean->GameId);
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $resObj = TranslatedGameData::model()->find($criteria);
            if(is_array($resObj) || is_object($resObj)){
                //if already record exist update the data
                $resObj->Questions = $translatedBean->Questions;
                $resObj->update();
            }else{
                //if record not exist then insert new record 
                $translatedObj = new TranslatedGameData();
                $translatedObj->PostId = new MongoId($translatedBean->GameId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->Questions = $translatedBean->Questions;
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedGameData:saveTranslatedGameQuestions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TranslatedGameData->saveTranslatedGameQuestions==".$ex->getMessage());
        }
    }
    public function saveTranslatedFeaturedPost($translatedBean) {
        try {
            //checking if the record is already exist
            $criteria = new EMongoCriteria;
            $criteria->PostId = new MongoID($translatedBean->PostId);
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $resObj = TranslatedGameData::model()->find($criteria);
            if(is_array($resObj) || is_object($resObj)){
                //if already record exist update the data
                $resObj->PostType = $translatedBean->PostType;
                $resObj->FeaturedPostText = $translatedBean->FeaturedPostText;
                $resObj->FeaturedTitle = $translatedBean->FeaturedTitle;
                $resObj->update();
            }else{
                //if record not exist then insert new record 
                $translatedObj = new TranslatedGameData();
                $translatedObj->PostId = new MongoId($translatedBean->PostId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->PostType = $translatedBean->PostType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->FeaturedPostText = $translatedBean->FeaturedPostText;
                $translatedObj->FeaturedTitle = $translatedBean->FeaturedTitle;
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedGameData:saveTranslatedFeaturedPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TranslatedGameData->saveTranslatedFeaturedPost==".$ex->getMessage());
        }
    }
}