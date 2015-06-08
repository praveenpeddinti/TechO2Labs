<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class  TranslatedSurveyData extends TranslatedDataCollection
{
    public $OptionOne;
    public $OptionTwo;
    public $OptionThree;
    public $OptionFour;
    
    public function defaultScope()
    {
        return array(
            'conditions'=>array('POST_TYPE'=>array('==' => self::SURVEY_POST)),
        );
    }
 
    public function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->POST_TYPE = self::SURVEY_POST;
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
                $resObj->OptionOne = $translatedBean->OptionOne;
                $resObj->OptionTwo = $translatedBean->OptionTwo;
                $resObj->OptionThree = $translatedBean->OptionThree;
                $resObj->OptionFour = $translatedBean->OptionFour;
                $resObj->update();
            }else{
                //if record not exist then insert new record 
                $translatedObj = new TranslatedSurveyData();
                $translatedObj->PostId = new MongoId($translatedBean->PostId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->PostType = $translatedBean->PostType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->PostText = $translatedBean->PostText;
                $translatedObj->Title = $translatedBean->Title;
                $translatedObj->OptionOne = $translatedBean->OptionOne;
                $translatedObj->OptionTwo = $translatedBean->OptionTwo;
                $translatedObj->OptionThree = $translatedBean->OptionThree;
                $translatedObj->OptionFour = $translatedBean->OptionFour;
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedSurveyData:saveTranslatedData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TranslatedSurveyData->saveTranslatedData==".$ex->getMessage());
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
                $translatedObj = new TranslatedSurveyData();
                $translatedObj->PostId = new MongoId($translatedBean->PostId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->PostType = $translatedBean->PostType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->FeaturedPostText = $translatedBean->FeaturedPostText;
                $translatedObj->FeaturedTitle = $translatedBean->FeaturedTitle;
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedSurveyData:saveTranslatedFeaturedPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TranslatedSurveyData->saveTranslatedFeaturedPost==".$ex->getMessage());
        }
    }
}