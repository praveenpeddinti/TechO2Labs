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
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('Title', 'required', 'message' => Yii::t("translation", "Ex_Title_Err")),
            array('Description', 'required', 'message' => Yii::t("translation", "Ex_Description_Err")),
            //array('Question', 'validateDynamicFields', 'fieldname' => 'Question', 'message' => 'Question '),
            array('SurveyRelatedGroupName', 'validateSOFields', 'fieldname' => 'SurveyRelatedGroupName', 'message' => 'Other Value '),
            array('CategoryName,Questions,Question,QuestionId,WidgetType,CreatedBy,QuestionsCount,Status,Title,Description,SurveyRelatedGroupName,NoofQuestions,CategoryTime,NoofPoints,ReviewQuestion', 'safe'),
        );
    }

    /*public function validateDynamicFields($attribute, $params) {
        try{
        if (sizeof($this->$params['fieldname']) > 0) {
            foreach ($this->$params['fieldname'] as $key => $order) {

                if (empty($order)) {
                    if (isset($params['message']) && $params['message'] != "") {
                        $message = $params['message'];
                    } else {
                        $message = $params['fieldname'];
                    }
                    if ($params['fieldname'] != "NoofOptions" && $params['fieldname'] != "NoofChars") {
                        $this->addError($params['fieldname'] . '_' . $key, $message . ' cannot be blank');
                    } else {
                        $this->addError($params['fieldname'] . '_' . $key, $message);
                    }
                    // break;
                }
            }
        }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyForm:validateDynamicFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }*/

    public function validateSOFields($attribute, $params) {
        try{error_log("------SO--".$this->SurveyRelatedGroupName);
        if ($this->SurveyRelatedGroupName == "") {
            
                $message = "Please select Category";
                $this->addError('SurveyRelatedGroupName', $message);
            
        }
        
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyForm:validateSOFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    

}
