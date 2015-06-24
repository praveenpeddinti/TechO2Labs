<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserRegistrationForm extends CFormModel
{
        
	public $FirstName;
        public $LastName;
        public $Email;
       public $Phone;
       public $Pancard;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */

	public function rules()
	{
		return array(
			array('FirstName,LastName,Email,Phone,Pancard', 'required' ),
                        array(
                            'FirstName',
                            'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                            'message'=>Yii::t('translation','attribute_Invalid_characters'),
                      ),
                    array(
                            'LastName',
                            'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                            'message'=>Yii::t('translation','attribute_Invalid_characters')
                      ),
                    array('Email', 'email','checkMX'=>false),
//                    array('Phone', 'match', 'pattern'=>'/^[0-9]/i'),
                    array(
                            'Pancard',
                            'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9]/',
                            'message'=>Yii::t('translation','attribute_Invalid_characters')
                      ),
                        array('FirstName,LastName,Email,Phone,Pancard', 'safe'),
                      );
           
	}

       
}
