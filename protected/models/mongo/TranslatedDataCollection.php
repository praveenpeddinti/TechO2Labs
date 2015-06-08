<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TranslatedDataCollection extends EMongoDocument {
    public $_id;
    public $PostId;
    public $PostType;
    public $CategoryType;
    public $Language;
    public $PostText;
    public $Title;
    public $FeaturedTitle;
    public $FeaturedPostText;
    public $Comments = array();
    
    public $POST_TYPE=1;
    const EVENT_POST = 2;
    const SURVEY_POST = 3;
    const GAME = 12;
    public function getCollectionName() {
        return 'TranslatedDataCollection';
    }
    /**
     * We can override the instantiate method to return correct models
     */
    protected function instantiate($attributes)  {
        try{
        if($attributes['POST_TYPE'] == self::EVENT_POST){
            $model = new TranslatedEventData(null); // We have to set scenario to null, it will be set, by populateRecord, later
        }else if($attributes['POST_TYPE'] == self::SURVEY_POST){
            $model = new TranslatedSurveyData(null);
        }else if($attributes['POST_TYPE'] == self::GAME){
            $model = new TranslatedGameData(null);
        }else{
            $model = new TranslatedDataCollection(null);
        }
 
        $model->initEmbeddedDocuments(); // We have to do it manually here!
        $model->setAttributes($attributes, false);
        return $model;
        } catch (Exception $ex) {
            Yii::log("TranslatedDataCollection:instantiate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
 
    //This method is used to check the given post/comment already translated

    public function isTranslated($translatedBean){
        $returnValue = array();
        try{
            $criteria = new EMongoCriteria;
            $criteria->PostId = new MongoID($translatedBean->PostId);
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $resObj;
            
            if($translatedBean->PostType==2){
                $resObj = TranslatedEventData::model()->find($criteria);
            }else if($translatedBean->PostType==3){
                $resObj = TranslatedSurveyData::model()->find($criteria);
            }else{
                $resObj = TranslatedDataCollection::model()->find($criteria);
            }
            if(is_array($resObj) || is_object($resObj)){
                if(isset($resObj->PostText) && !empty($resObj->PostText)){
                    $returnValue["PostText"] = $resObj->PostText;
                    $returnValue["Title"] = $resObj->Title;
                    if($translatedBean->PostType==2){
                        $returnValue["Location"] = $resObj->Location;
                    }else if($translatedBean->PostType==3){
                        $returnValue["OptionOne"] = $resObj->OptionOne;
                        $returnValue["OptionTwo"] = $resObj->OptionTwo;
                        $returnValue["OptionThree"] = $resObj->OptionThree;
                        $returnValue["OptionFour"] = $resObj->OptionFour;
                    }
                }else if(isset($resObj->Title) && !empty($resObj->Title)){
                    $returnValue["Title"] = $resObj->Title;
                }
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedDataCollection:isTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
	return $returnValue;	
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
                $resObj->update();
            }else{
                //if record not exist then insert new record 
                $translatedObj = new TranslatedDataCollection();
                $translatedObj->PostId = new MongoId($translatedBean->PostId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->PostType = $translatedBean->PostType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->PostText = $translatedBean->PostText;
                $translatedObj->Title = $translatedBean->Title;
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedDataCollection:saveTranslatedData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function isCommentTranslated($translatedBean){
        $returnValue = "false";
        try{
            $criteria = new EMongoCriteria;
            $criteria->PostId = new MongoID($translatedBean->PostId);
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $criteria->Comments->CommentId("==" ,new MongoID($translatedBean->CommentId));
            $criteria->setSelect(array('Comments.$'=>true));
            $resObj;
            if($translatedBean->PostType==2){
                $resObj = TranslatedEventData::model()->find($criteria);
            }else if($translatedBean->PostType==3){
                $resObj = TranslatedSurveyData::model()->find($criteria);
            }else{
                $resObj = TranslatedDataCollection::model()->find($criteria);
            }
            if(is_array($resObj) || is_object($resObj)){
               $returnValue = $resObj->Comments[0]['CommentText'];
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedDataCollection:isCommentTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
	return $returnValue;	
    }
    public function saveTranslatedCommentData($translatedBean) {
        try {
            $comments = array();
            $comments['CommentId']=new MongoID($translatedBean->CommentId);
            $comments['CommentText']=$translatedBean->CommentText;
            //checking if the record is already exist
            $criteria = new EMongoCriteria;
            $criteria->PostId = new MongoID($translatedBean->PostId);
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $resObj;
            if($translatedBean->PostType==2){
                $resObj = TranslatedEventData::model()->find($criteria);
            }else if($translatedBean->PostType==3){
                $resObj = TranslatedSurveyData::model()->find($criteria);
            }else{
                $resObj = TranslatedDataCollection::model()->find($criteria);
            }
            if(is_array($resObj) || is_object($resObj)){
               //if already record exist update the data
               array_push($resObj->Comments, $comments);
               $resObj->update();
            }else{
                //if record not exist then insert new record
                $translatedObj;
                if($translatedBean->PostType==2){
                    $translatedObj = new TranslatedEventData();
                }else if($translatedBean->PostType==3){
                    $translatedObj = new TranslatedSurveyData();
                }else{
                    $translatedObj = new TranslatedDataCollection();
                }
                $translatedObj->PostId = new MongoId($translatedBean->PostId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->PostType = (int)$translatedBean->PostType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->Comments = array($comments);
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedDataCollection:saveTranslatedCommentData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
                $translatedObj = new TranslatedDataCollection();
                $translatedObj->PostId = new MongoId($translatedBean->PostId);
                $translatedObj->CategoryType = (int)$translatedBean->CategoryType;
                $translatedObj->PostType = $translatedBean->PostType;
                $translatedObj->Language = $translatedBean->Language;
                $translatedObj->FeaturedPostText = $translatedBean->FeaturedPostText;
                $translatedObj->FeaturedTitle = $translatedBean->FeaturedTitle;
                $translatedObj->insert();
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedDataCollection:saveTranslatedFeaturedPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function isFeaturedPostTranslated($translatedBean){
        $returnValue = array();
        try{
            $criteria = new EMongoCriteria;
            $criteria->PostId = new MongoID($translatedBean->PostId);
            $criteria->CategoryType = (int)$translatedBean->CategoryType;
            $criteria->Language = $translatedBean->Language;
            $resObj;
            if($translatedBean->PostType==2){
                $resObj = TranslatedEventData::model()->find($criteria);
            }else if($translatedBean->PostType==3){
                $resObj = TranslatedSurveyData::model()->find($criteria);
            }else if($translatedBean->PostType==12){
                $resObj = TranslatedGameData::model()->find($criteria);
            }else{
                $resObj = TranslatedDataCollection::model()->find($criteria);
            }
            if(is_array($resObj) || is_object($resObj)){
                if(isset($resObj->FeaturedTitle) && !empty($resObj->FeaturedTitle)){
                    $returnValue["FeaturedTitle"] = $resObj->FeaturedTitle;
                    $returnValue["FeaturedPostText"] = $resObj->FeaturedPostText;
                }
            }
        } catch (Exception $ex) {
            Yii::log("TranslatedDataCollection:isFeaturedPostTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
	return $returnValue;	
    }
}

