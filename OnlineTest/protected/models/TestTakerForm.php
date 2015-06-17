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
            array('Email','email','checkMX'=>false),
            
            array('FirstName,LastName,Email,Phone,Qualification,UserId', 'safe'),
            
        );
    }
    

}
