<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserSettingsForm extends CFormModel
{
        public $userId;
	public $username;
        public $firstName;
        public $lastName;
        public $salutation;
        public $displayName;
        public $country;
        public $state;
        public $city;
        public $zip;
        public $companyName;
        public $aboutMe;
        public $interests;
	public $profilePicture;
        public $password;
        public $oldPassword;
        public $confirmpassword;
        public $status;
	public $email;
        public $contactNumber;
        public $network;
        public $termsandconditions;
        public $referenceUserId;
        public $referralLinkId;
        public $referralUserEmail;
        public $NPINumber;
        public $HavingNPINumber;
        public $StateLicenseNumber;
        public $IsSpecialist;
        public $IsStudentOrResident;
        public $StudentOrResidentEmail;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
                    public function Mainrules()
	{
              return array(
            array('StateLicenseNumber,NPINumber,IsSpecialist,IsStudentOrResident,StudentOrResidentEmail,aboutMe', 'safe'),
        array('IsSpecialist', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('IsSpecialist', 'compare', 'compareValue'=>0),
                        ),
                        'then' => array(
                            array('IsSpecialist', 'required','message'=>Yii::t('subspecialty','Is_Specialist_Blank')),
                        ),
                       
                 ),
                   array('IsSpecialist,HavingNPINumber', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                            array('IsSpecialist', 'compare', 'compareValue'=>1),
                             array('HavingNPINumber', 'compare', 'compareValue'=>0),
                        ),
                        'then' => array(
                            array('StateLicenseNumber', 'required'),
                        ),
                 ),
                    array('IsSpecialist,HavingNPINumber', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('IsSpecialist', 'compare', 'compareValue'=>1),
                             array('HavingNPINumber', 'compare', 'compareValue'=>1),
                        ),
                        'then' => array(
                            array('NPINumber', 'required','message'=>Yii::t('translation','NPINumber_blank')),
                            array('NPINumber',
                            'match', 'pattern' => '/^[1-9][0-9]{9}$/',
                            'message'=>Yii::t('translation','NPINumber_Invalid_Pattern'))
                        ),
                 ),
                   array('IsSpecialist', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('IsSpecialist', 'compare', 'compareValue'=>2),
                          
                        ),
                       'then' => array(
                            array('IsStudentOrResident', 'required','message'=>Yii::t('translation','Please_Select_Student_Resident')),
                        ),
                 ),
                     array('IsSpecialist,IsStudentOrResident', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('IsSpecialist', 'compare', 'compareValue'=>2),
                             array('IsStudentOrResident', 'compare', 'compareValue'=>1),
                            
                        ),
                       'then' => array(
                            array('StudentOrResidentEmail', 'required','message'=>Yii::t('translation','attribute_cannot_be_blank')),
                            array('StudentOrResidentEmail', 'email','checkMX'=>true),
                        ),
                 ),
                     array('IsSpecialist,IsStudentOrResident', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('IsSpecialist', 'compare', 'compareValue'=>2),
                             array('IsStudentOrResident', 'compare', 'compareValue'=>2),
                            
                        ),
                        
                       'then' => array(
                            array('aboutMe', 'required','message'=>Yii::t('subspecialty','aboutMe_cannot_be_blank')),
                        ),
                 ),
                  );
        }
	public function rules()
	{
		return array(
			
                    array('email', 'email','checkMX'=>true),
                   
                      array('firstName,lastName,country,zip,city,state,companyName,email,password,oldPassword                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   ', 'safe'),
                      array('firstName,lastName,email,country,zip,state,city,companyName', 'required'),
                    
                     array('zip', 'match', 'pattern'=>'/^[0-9]{5}(-[0-9]{4})?$/i'),

                     array(
                            'firstName',
                            'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                            'message' => 'Invalid characters in firstName.',
                      ),
                    array(
                            'lastName',
                            'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                            'message' => 'Invalid characters in lastName.',
                      )
                    
                    
		);
           
	}

	
}
