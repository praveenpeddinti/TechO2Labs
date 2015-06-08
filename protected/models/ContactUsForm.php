<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactUsForm extends CFormModel
{
	public $FirstName;
	public $LastName;
	public $Address;
	public $Occupation;
	public $UserComment;
        public $ContactUserEmail;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('FirstName, LastName', 'required'),
                    array('ContactUserEmail', 'required','message'=>Yii::t('translation','cannot_be_blank')),
                    array('ContactUserEmail', 'email','message'=>Yii::t('translation','Enter_valid_email')),
                    array('UserComment', 'required','message'=>Yii::t('translation','attribute_cannot_be_blank')),
                    array('FirstName, LastName,UserComment,Address,Occupation,ContactUserEmail', 'safe'),
                  
			// email has to be a valid email address
			
			// verifyCode needs to be entered correctly
			
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			
		);
	}
}