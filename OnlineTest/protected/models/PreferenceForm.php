<?php

/* 
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */
class PreferenceForm extends CFormModel
{
    public $CountryId;
    public $UserId;
  
    
    public function rules() {
        return array(
            array('CountryId', 'safe'),
          array('UserId', 'safe'),
            );
    }
    
}