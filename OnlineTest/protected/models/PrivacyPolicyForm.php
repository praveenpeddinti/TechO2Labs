<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class PrivacyPolicyForm extends CFormModel {

    public $UserId;
       
    public $TestPaperId;
    
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('UserId,TestPaperId', 'safe'),
            //array('Description', 'required', 'message' => Yii::t("translation", "Ex_Description_Err")),
            //array(NoofQuestions,CategoryTime,'Question', 'validateDynamicFields', 'fieldname' => 'Question', 'message' => 'Question '),
             );
    }

   
    }

    


