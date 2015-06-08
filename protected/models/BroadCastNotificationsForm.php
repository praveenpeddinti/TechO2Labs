<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class BroadCastNotificationsForm extends CFormModel
{
        public $Message;
	public $RedirectUrl;
        public $ExpiryDate;
       
        
        
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
	
                      array('Message,RedirectUrl,ExpiryDate', 'safe'),
                      array('Message', 'required'),
   
		);
           
	}

	
}
