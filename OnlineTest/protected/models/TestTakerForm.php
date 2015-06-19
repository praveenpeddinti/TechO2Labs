<?php

/*
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */

class TestTakerForm extends CFormModel {

    public $UserId;
    public $FirstName;
    public $LastName;
    public $Email;
    public $Phone;
    public $Qualification;
    public function rules() {
        return array(
            
            
            
            array('FirstName,LastName,Email,Phone', 'required'),
            array('Qualification', 'required','message'=>'Select Qualification'),
            array(
                'FirstName',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                'message'=>Yii::t('translation','attribute_Invalid_characters'),
            ),
            array(
                'LastName',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                'message'=>Yii::t('translation','attribute_Invalid_characters'),
            ),
            array('Phone', 'match', 'pattern'=>'/^[0-9]/'),
            array('Email','email','checkMX'=>false),
            /*array('Qualification', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('Qualification', 'compare', 'compareValue'=>''),
                        ),
                        'then' => array(
                            array('Qualification', 'required','message'=>'Select Qualification'),
                        ),
                       
                 ),*/
            array('FirstName,LastName,Email,Phone,Qualification,UserId', 'safe'),
            
        );
    }
    

}
