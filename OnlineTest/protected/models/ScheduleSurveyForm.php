<?php

/*
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */

class ScheduleSurveyForm extends CFormModel {

   public $SurveyTitle;
   public $StartDate;
   public $EndDate;
   public $ShowDisclaimer;
   public $ShowThankYou;
   public $ThankYouMessage;
   public $ThankYouArtifact;
   public $IsPromoted;
   public $SurveyId;
   public $QuestionView;
   public $RenewSchedules;
   public $ConvertInStreamAdd;
   public $SurveyRelatedGroupName;
   public $InstreamAdArtifact;
   public $SurveyDescription;
   public $SelectMaxSpot;
   public $MaxSpots;
   //public $SessionTime;
    public function rules() {
        return array(
            array('ShowThankYou', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('ShowThankYou', 'compare', 'compareValue'=>"1"),
                        ),
                        'then' => array(
                            array('ThankYouMessage', 'required'),
                        ),
                 ),
         
            array('StartDate,QuestionView', 'required'),           
            array('EndDate', 'required'),
            array('ConvertInStreamAdd','validateSOFields', 'fieldname' => 'ConvertInStreamAdd' ,'message' => 'Other Value '),
             array('SelectMaxSpot','validateSOFields', 'fieldname' => 'SelectMaxSpot' ,'message' => 'Other Value '),
            array('SurveyDescription,InstreamAdArtifact,SurveyRelatedGroupName,ConvertInStreamAdd,SurveyId,SurveyTitle,RenewSchedules,StartDate,EndDate,ShowThankYou,ThankYouMessage,ThankYouArtifact,MaxSpots', 'safe'),
            
        );
    }
    public function validateSOFields($attribute, $params){ 
        try{
        if($attribute =="ConvertInStreamAdd" && $this->ConvertInStreamAdd == "1"){                    
                    if($this->InstreamAdArtifact== ""){
                        $message=" Please upload Instream Ad Image.";                        
                        $this->addError('InstreamAdArtifact', $message);
                    }
                    
                }   
                 if($attribute =="SelectMaxSpot" && $this->SelectMaxSpot == "1"){                    
                    if($this->MaxSpots== ""){
                        $message="Max Spots is Required";                        
                        $this->addError('MaxSpots', $message);
                    }
                    else if(!preg_match("/^\d+$/", $this->MaxSpots)){
                        $message="Interger value is required";                        
                        $this->addError('MaxSpots', $message);
                    }
                    else if($this->MaxSpots<=0){
                        $message="Max Spot must be greater than zero";                        
                        $this->addError('MaxSpots', $message);
                    }
                    
                }
                } catch (Exception $ex) {
            Yii::log("ScheduleSurveyForm:validateSOFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}
