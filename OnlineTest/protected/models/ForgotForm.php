<?php

/* 
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */
class ForgotForm extends CFormModel
{
    public $email;
    public $error;
    public $success;
    
    public function rules() {
        return array(
            array('email', 'required'),
            array('email','email','checkMX'=>true)
            );
    }
    
}