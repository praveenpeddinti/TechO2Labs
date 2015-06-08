<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserRegistrationForm extends CustomForm
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
        public $pass;
        public $confirmpass;
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

	public function rules()
	{
		return array(
			    array('StateLicenseNumber,NPINumber,IsSpecialist,IsStudentOrResident,StudentOrResidentEmail', 'safe'),
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
                            
                             array(
                            'NPINumber',
                            'match', 'pattern' => '/^[1-9][0-9]{9}$/',
                            'message'=>Yii::t('translation','NPINumber_Invalid_Pattern')
                      ),
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
                            array('StudentOrResidentEmail', 'email','checkMX'=>FALSE),
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
                    array('email', 'email','checkMX'=>false),
                     array('termsandconditions', 'compare', 'compareValue' => 1, 'message' => Yii::t('translation','accept_terms_of_use')),
                   // array('password', 'ext.SPasswordValidator.SPasswordValidator', 'strength'=>'strong'),
                      array('firstName,lastName,salutation,displayName,country,zip,city,state,companyName,profilePicture,email,pass,aboutMe,contactNumber,interests,referenceUserId,referralLinkId,referralUserEmail,HavingNPINumber', 'safe'),
                      array('firstName,lastName,email,country,zip,city,state,companyName', 'required'),
                    // array('firstName,lastName,address1,address2,zip,city,state,gender,email,password,contactNumber', 'required'),
                     array('zip', 'match', 'pattern'=>'/^[0-9]{5}(-[0-9]{4})?$/i'),
                    array('confirmpass','compare','compareAttribute'=>'pass','message'=>Yii::t('translation','attribute_must_be_repeated_exactly')),
                   array('pass','required', 'message'=>'Password cannot be blank'),
                    array('confirmpass','required', 'message'=>Yii::t('translation','attribute_cannot_be_blank')),

                   // array('contactNumber','numerical','integerOnly'=>true,'min'=>12)
                     array(
                            'firstName',
                            'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                            'message'=>Yii::t('translation','attribute_Invalid_characters'),
                      ),
                    array(
                            'lastName',
                            'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                            'message'=>Yii::t('translation','attribute_Invalid_characters')
                      ),
                                   
                    //array('IsSpecialist', 'required','message'=>Yii::t('subspecialty','Is_Specialist_Blank')),
                    
                    
		);
           
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
                  //  'firstName'=>'User Name',
			//'rememberMe'=>'Remember me next time',
                 //    'dob'=>'Date of Birth'
		);
	}

        
}
