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
       public $IdentityProof;
       public $CardNumber;
         public $Imagesrc;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */

	public function rules()
	{
		return array(
			array('FirstName,LastName,Email,Phone', 'required' ),
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
                    //array('IdProof', 'required','message'=>'Select IdProof'),
                    //array('IdentityProof','compare','compareAttribute'=>'Select IdProof', 'operator'=>'=','allowEmpty'=>false,'message'=>'hghfhfhfg'),
                    array(
                            'CardNumber',
                            'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9]/',
                            'message'=>Yii::t('translation','attribute_Invalid_characters')
                      ),
                    array('Phone','numerical','integerOnly'=>true,'min'=>1111111111,'tooSmall'=>'{attribute} is too short(minimum 10 numbers)',),
                    array('IdentityProof', 'required', 'message' => 'Please select Id Proof'),
                    array('IdentityProof', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                       'if' => array(
                           array('IdentityProof', 'in', 'range'=>array('Pancard','Passport','Driving Licence'), 'allowEmpty'=>false)
                           //array('IdentityProof', 'compare', 'compareAttribute'=>'IdentityProof', 'allowEmpty'=>true),
                       ),
                       'then' => array(
                           array('CardNumber', 'required','message'=>'Please enter a value for Card Number'),
                           array(
                            'CardNumber',
                            'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9]/',
                            'message'=>Yii::t('translation','attribute_Invalid_characters')
                      ),
                       ),),
                    
                    array('FirstName,LastName,Email,Phone,IdentityProof,CardNumber,Imagesrc', 'safe'),

                      );
           
	}
        
   

       
}
