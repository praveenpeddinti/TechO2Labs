<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class TestPaperForm extends CFormModel {

    public $UserId;
       
    public $Questions;
    public $Question;
    public $QuestionId;
    public $WidgetType;
    public $CreatedBy;
    public $QuestionsCount; 
    public $Status;
    
    public $Title;
    public $Description;
    public $SurveyRelatedGroupName;
    public $NoofQuestions;
    public $CategoryTime;
    public $NoofPoints;
    public $ReviewQuestion;
    public $CategoryName;
    public $ScheduleId;
    public $CategoryId;
    
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            //array('Title', 'required', 'message' => Yii::t("translation", "Ex_Title_Err")),
            //array('Description', 'required', 'message' => Yii::t("translation", "Ex_Description_Err")),
            //array(NoofQuestions,CategoryTime,'Question', 'validateDynamicFields', 'fieldname' => 'Question', 'message' => 'Question '),
            array('NoofQuestions', 'validateQuestionsFields', 'fieldname' => 'NoofQuestions', 'message' => 'Other Value '),
            array('CategoryTime', 'validateTimeFields', 'fieldname' => 'CategoryTime', 'message' => 'Other Value '),
            array('NoofPoints', 'validateScoreFields', 'fieldname' => 'NoofPoints', 'message' => 'Other Value '),
            array('CategoryId,ScheduleId,UserId,CategoryName,Questions,Question,QuestionId,WidgetType,CreatedBy,QuestionsCount,Status,Title,Description,SurveyRelatedGroupName,NoofQuestions,CategoryTime,NoofPoints,ReviewQuestion', 'safe'),
        );
    }

    public function validateQuestionsFields($attribute, $params) {
        try{
        if ($this->NoofQuestions == "") {
            
                $message = "Select # Questions";
                $this->addError('NoofQuestions', $message);
            
        }
        
        
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyForm:validateSOFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function validateTimeFields($attribute, $params) {
        try{
        if ($this->CategoryTime == "") {
            
                $message = "Select Time";
                $this->addError('CategoryTime', $message);
            
        }
        
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyForm:validateSOFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function validateScoreFields($attribute, $params) {
        try{
        
        if ($this->NoofPoints == "") {
            
                $message = "Select Score";
                $this->addError('NoofPoints', $message);
            
        }
        
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyForm:validateSOFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    

}
