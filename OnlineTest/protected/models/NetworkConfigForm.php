<?php

/* 
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */
class NetworkConfigForm extends CFormModel
{
    public $Id;
    public $Key;
    public $Value;
    public $Enable;
    
    public function rules() {
        return array(
            array('Key,Value', 'required'),
            array('Id,Key,Value,Enable', 'safe'),
            
            );
    }
    
}