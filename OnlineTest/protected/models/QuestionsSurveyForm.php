<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class QuestionsSurveyForm extends CFormModel {

    public $UserId;
    public $RadioOption;
    public $CheckboxOption;
    public $Questions;
    public $Question;
    public $QuestionId;
    public $SurveyId;
    public $SurveyTitle;
    public $SurveyDescription;
    public $Other;
    public $OtherValue;
    public $WidgetType;
    public $CreatedBy;
    public $QuestionsCount;
    public $SurveyLogo;
    public $NoofOptions;
    public $NoofRatings;
    public $LabelName;
    public $OptionName;
    public $MatrixType;
    public $TotalValue;
    public $NoofChars;
    public $SurveyOtherValue;
    public $SurveyRelatedGroupName;
    public $Status;
    public $UnitType;
    public $ScheduleId;
    public $OptionsSelected;
    public $UserAnswers;
    public $DistValue;
    public $UsergeneratedRanking;
    public $UserAnswer;
    public $TotalCalValue;
    public $OptionValue;  
    public $OptionCommnetValue;
    public $IsMadatory;
    public $AnyOtherValue;
    public $AnyOtherComment;
    public $TextOptionValues;
    public $OptionTextValue;
    public $OptionValueOther;
    public $OtherJustification;
    //public $OtherTextValue;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('SurveyTitle,SurveyDescription,SurveyLogo,SurveyRelatedGroupName','required'),
            array('OptionsSelected', 'validateDynamicFields', 'fieldname' => 'OptionsSelected','message' => 'Please fill this question'),
            array('UserAnswer', 'validateDynamicFields', 'fieldname' => 'UserAnswer','message' => 'Please fill this question'),
            array('TotalCalValue', 'validateTotalValues', 'fieldname' => 'TotalCalValue','message' => 'Sorry, Distributed values are not matched with the total.'),
            array('Other','validateOtherFields', 'fieldname' => 'Other' ,'message' => 'Other Value '),
            array('OptionValue', 'validateDynamicFields', 'fieldname' => 'OptionValue','message' => 'Please fill this question'),
            array('TextOptionValues', 'validateDynamicFields', 'fieldname' => 'TextOptionValues','message' => 'Please fill this question'),
            
            array('SurveyRelatedGroupName','validateSOFields', 'fieldname' => 'SurveyRelatedGroupName' ,'message' => 'Other Value '),            
            array('OptionValueOther', 'validateOtherFields', 'fieldname' => 'OptionValueOther','message' => 'Please fill this question'),
            array('OtherJustification','validateOtherFields', 'fieldname' => 'OtherJustification' ,'message' => 'Other Value '),
            array('OptionTextValue', 'validateDynamicFields1', 'fieldname' => 'OptionTextValue','message' => 'Please fill this question'),
            array('UserId,UsergeneratedRanking,DistValue,UserAnswers,ScheduleId,SurveyId,Question,SurveyTitle,SurveyDescription,SurveyLogo,SurveyRelatedGroupName,WidgetType,Questions,OtherValue,Status,QuestionId,UnitType,OptionsSelected,OptionCommnetValue,IsMadatory,AnyOtherComment,AnyOtherValue,TextOptionValues,OptionTextValue','safe'),
        );
    }

    public function validateDynamicFields($attribute, $params) {        
        try{
        if(sizeof($this->$params['fieldname'])>0){
           foreach ($this->$params['fieldname'] as $key => $order) {
               
            if (empty($order)) {
                if(isset($params['message']) && $params['message']!=""){
                    $message=$params['message'];
                }else{
                    $message=$params['fieldname'];
                }                
                    if($this->Other[$key] != 1){
                        $this->addError($params['fieldname'] . '_' . $key, "Please answer the question $key");
                    }else {
                        $this->addError($params['fieldname'] . '_' . $key, $message);
                    }
                // break;
            }
        }  
        }
        } catch (Exception $ex) {
            Yii::log("QuestionsSurveyForm:validateDynamicFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       
    }
    
    public function validateOtherFields($attribute, $params){
        try{
        if(sizeof($this->$params['fieldname'])>0){
            foreach ($this->$params['fieldname'] as $key => $order) {                
                if($order == 1){                    
                    if($params['fieldname'] == "Other" && $this->OtherValue[$key]== "" ){
                        $message=" Other Value  cannot be blank";
                        $this->addError('OtherValue_' . $key, $message);
                    }
                    if($params['fieldname'] == "OtherJustification" && $this->OtherValue[$key] == ""){
                        $message=" Justification cannot be blank";
                        $this->addError('OtherValue_' . $key, $message);
                    }                    
                }
                
                if($order > 0){                   
                    if($params['fieldname'] == "OptionValueOther" && $this->OptionTextValue[$key] == ""){   
                        $message=" Other Value  cannot be blank";
                        $this->addError('OptionTextValue_' . $key, $message);
                    }
                }                
                
            }
        }
        } catch (Exception $ex) {
            Yii::log("QuestionsSurveyForm:validateOtherFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function validateTypeFields($attribute, $params){
        try{ 
        if(sizeof($this->$params['fieldname'])>0){
            foreach ($this->$params['fieldname'] as $key => $order) { 
                if($order == 2){                          
                    if($this->NoofRatings[$key] == ""){
                        $message="Please Select No of Ratings";
                        $this->addError('NoofRatings_' . $key, $message);
                    }
                    
                }
            }
        }
        } catch (Exception $ex) {
            Yii::log("QuestionsSurveyForm:validateTypeFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function validateSOFields($attribute, $params){       
        try{
            if($this->SurveyRelatedGroupName == "other"){                    
                    if($this->SurveyOtherValue== ""){
                        $message=" Survey Other Value cannot be blank";                        
                        $this->addError('SurveyOtherValue', $message);
                    }
                    
                }
                } catch (Exception $ex) {
            Yii::log("QuestionsSurveyForm:validateSOFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function validateTotalValues($attribute, $params){
        try{
        if(sizeof($this->$params['fieldname'])>0){
            foreach ($this->$params['fieldname'] as $key => $order) { 
                if (empty($order)) {
                if(isset($params['message']) && $params['message']!=""){
                    $message=$params['message'];
                }else{
                    $message=$params['fieldname'];
                }
                if($this->OptionsSelected[$key] != "" && $this->OptionsSelected[$key] != 0)
                    $this->addError($params['fieldname'] . '_' . $key, $message);
                
                // break;
            }
            }
        }
        } catch (Exception $ex) {
            Yii::log("QuestionsSurveyForm:validateTotalValues::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function validateDynamicFields1($attribute, $params) {
        if (sizeof($this->$params['fieldname']) > 0) {
            foreach ($this->$params['fieldname'] as $key => $order) {
                if ($params['fieldname'] == "OptionTextValue" && $this->OptionTextValue[$key] != "" && $this->OptionValueOther[$key] == "") {
                    $keeyexp = explode("_", $key);
                    $this->addError('OptionsSelected_' . $keeyexp[1], "Please fill all the fields");
                }
            }
        }
    }

}
