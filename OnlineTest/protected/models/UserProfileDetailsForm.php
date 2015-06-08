<?php

/* 
 * UserProfileDetailsForm class.
 * UserProfileDetailsForm  is the data structure for requesting user profileDetails
 * It is used by the 'SaveUserProfileDetails' action of 'UserController'.
 */
class UserProfileDetailsForm extends CFormModel
{
    public $DisplayName;
    public $Speciality;
    public $StateLicenseNumber;
    public $Title;
    public $Credentials;
    public $PracticeName;
    public $State;
    public $City;
    public $AboutMe;
    public $profilepic;
    public $UserId;
    public $Interests;
    public $UserInterests;
    public $AboutUser;
    public $OtherAffiliation;
    public $NPINumber;
    public $HavingNPINumber;

      public function Mainrules()
	{
              return array(
                   array('StateLicenseNumber,NPINumber,HavingNPINumber', 'safe'),
//                   array('HavingNPINumber', 'ext.YiiConditionalValidator.YiiConditionalValidator',
//                        'if' => array(
//                             array('HavingNPINumber', 'compare', 'compareValue'=>0),
//                        ),
//                        'then' => array(
//                            array('StateLicenseNumber', 'required'),
//                        ),
//                 ),
//                    array('HavingNPINumber', 'ext.YiiConditionalValidator.YiiConditionalValidator',
//                        'if' => array(
//                             array('HavingNPINumber', 'compare', 'compareValue'=>1),
//                        ),
//                        'then' => array(
//                            array('NPINumber', 'required','message'=>'NPI Number cannot be blank'),
//                        ),
//                 ),
                  );
        }
    public function rules() {
        return array(
            // username and password are required
            array('OtherAffiliation,AboutUser,UserInterests,profilepic,UserId,Interests,DisplayName,Speciality,Title,Credentials,PracticeName,State,City,AboutMe', 'safe'),
            array('DisplayName,City,State', 'required'),
             array('Speciality', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('Speciality', 'compare', 'compareValue'=>"Other"),
                        ),
                        'then' => array(
                            array('OtherAffiliation', 'required','message'=>'Other Speciality cannot be blank.'),
                        ),
                 ),
            );
    }
    
}