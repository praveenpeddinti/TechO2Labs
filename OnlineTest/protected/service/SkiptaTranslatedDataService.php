<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SkiptaTranslatedDataService {

    public function isTranslated($translatedBean) {
        $result = 'failure';
        try {
            $result = TranslatedDataCollection::model()->isTranslated($translatedBean);
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:isTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    public function saveTranslatedData($translatedBean) {
        $result = 'failure';
        try {
            if($translatedBean->PostType==3){
                $result = TranslatedSurveyData::model()->saveTranslatedData($translatedBean);
            }else if($translatedBean->PostType==2){
                $result = TranslatedEventData::model()->saveTranslatedData($translatedBean);
            }else if($translatedBean->PostType==12){
                $result = TranslatedGameData::model()->saveTranslatedData($translatedBean);
            }else{
                $result = TranslatedDataCollection::model()->saveTranslatedData($translatedBean);
            }
            
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:saveTranslatedData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    public function isCommentTranslated($translatedBean) {
        $result = 'failure';
        try {
            $result = TranslatedDataCollection::model()->isCommentTranslated($translatedBean);
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:isCommentTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    public function saveTranslatedCommentData($translatedBean) {
        $result = 'failure';
        try {
            $result = TranslatedDataCollection::model()->saveTranslatedCommentData($translatedBean);
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:saveTranslatedCommentData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }

    
       public function isStreamNoteTranslated($text, $toLanguage) {
        $result = 'failure';
        try {
            $result = StreamNoteCollection::model()->isStreamNoteTranslated($text, $toLanguage);
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:isStreamNoteTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    
       public function saveStreamNoteTranslatedData($text, $fromLanguage, $toLanguage, $translatedText) {
        $result = 'failure';
        try {
            $result = StreamNoteCollection::model()->saveTranslatedStreamNote($text, $fromLanguage, $toLanguage, $translatedText);
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:saveStreamNoteTranslatedData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    public function isGameTranslated($translatedBean) {
        $result = 'failure';
        try {
            $result = TranslatedGameData::model()->isGameTranslated($translatedBean);
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:isGameTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    public function saveTranslatedGameQuestions($translatedBean) {
        $result = 'failure';
        try {
            $result = TranslatedGameData::model()->saveTranslatedGameQuestions($translatedBean);
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:saveTranslatedGameQuestions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
     public function saveTranslatedFeaturedPost($translatedBean) {
        $result = 'failure';
        try {
            if($translatedBean->PostType==3){
                $result = TranslatedSurveyData::model()->saveTranslatedFeaturedPost($translatedBean);
            }else if($translatedBean->PostType==2){
                $result = TranslatedEventData::model()->saveTranslatedFeaturedPost($translatedBean);
            }else if($translatedBean->PostType==12){
                $result = TranslatedGameData::model()->saveTranslatedFeaturedPost($translatedBean);
            }else{
                $result = TranslatedDataCollection::model()->saveTranslatedFeaturedPost($translatedBean);
            }
            
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:saveTranslatedFeaturedPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    public function isFeaturedPostTranslated($translatedBean) {
        $result = 'failure';
        try {
            $result = TranslatedDataCollection::model()->isFeaturedPostTranslated($translatedBean);
        } catch (Exception $ex) {
            Yii::log("SkiptaTranslatedDataService:isFeaturedPostTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
}
