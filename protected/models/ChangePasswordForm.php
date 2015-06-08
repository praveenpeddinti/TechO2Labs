<?php

/**
 * ResetForm class.
 * ResetForm is the data structure for resetting
 * user password data. It is used by the 'reset' action of 'UserController'.
 */
class ChangePasswordForm extends CFormModel
{
    public $password;
    public $newPassword;
    public $confirmNewPassword;

    /**
	 * Declares the validation rules.
	 * The rules state that password and retype-password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
        return array(
            array('password,newPassword,confirmNewPassword','safe'),
            array('password', 'required','message'=>'Current Password cannot be blank.'),
            array('newPassword', 'required','message'=>'New Password cannot be blank.'),
            array('confirmNewPassword', 'required','message'=>'Confirm New Password cannot be blank.'),
            array('newPassword, confirmNewPassword', 'length', 'min' => 8, 'max' => 25),
            array('confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword','message'=>'New Password and Confirm New Password did not match.'),
        );
    }


 
}
