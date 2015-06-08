<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class CustomForm extends CFormModel
{
	public $isPharmacist;
        public $StateLicenseNumber;
        public $PrimaryAffiliation;
        public $OtherAffiliation;
       
       
        
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function Mainrules()
	{
		return array(
			
               
                      array('isPharmacist,PrimaryAffiliation,StateLicenseNumber,OtherAffiliation', 'safe'),
                      array('isPharmacist,PrimaryAffiliation', 'required'),
                    array('isPharmacist', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('isPharmacist', 'compare', 'compareValue'=>"1"),
                        ),
                        'then' => array(
                            array('StateLicenseNumber', 'required'),
                        ),
                 ),
                    array('PrimaryAffiliation', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('PrimaryAffiliation', 'compare', 'compareValue'=>"Other"),
                        ),
                        'then' => array(
                            array('OtherAffiliation', 'required'),
                        ),
                 ),
                   
                    
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function MainattributeLabels()
	{
		return array(
                    'field1'=>'User Name',
			//'rememberMe'=>'Remember me next time',
                 //    'dob'=>'Date of Birth'
		);
	}
        
        
}
