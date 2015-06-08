<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserPublicationsForm extends CFormModel
{
    public $userId;
    public $Titles;
    

 public function Mainrules()
 {
  return array(
        array('Titles', 'required'),

  );
 }
 
        


        
}
