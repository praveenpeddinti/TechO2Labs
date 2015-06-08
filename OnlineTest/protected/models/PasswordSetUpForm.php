<?php

/* 
 * @Author Haribabu
 * PasswordSetForm class.
 * PasswordSetForm is the data structure for requesting a new password
 * It is used by the 'setupPassword' action of 'SiteController'.
 */
class PasswordSetUpForm extends CFormModel
{
    public $password;
    public $UserName;
    public $ConfirmPassword;
    public $AccessKey;
    
    
    public function rules() {
        return array(
            array('password,ConfirmPassword,AccessKey,UserName', 'safe'),
            array('password', 'required', 'message' => 'CreatePassword cannot be blank.'),
            array('ConfirmPassword', 'validateConfirmPassword', 'fieldname' => 'ConfirmPassword'),
        );
    }
      public function validateConfirmPassword($attribute, $params) {
        try{
          if ($this->ConfirmPassword != "") {
            if ($this->password != "" && ($this->ConfirmPassword != $this->password)) {
                $this->addError($attribute, $attribute . " " . Yii::t('translation', 'ConfirmPassword_attribute_must_be_repeated_exactly'));
            }
        } else {
            $this->addError($attribute, $attribute . " " . ' cannot be blank.');
        }
        } catch (Exception $ex) {
	Yii::log("PasswordSetUpForm:validateConfirmPassword::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
}
    }
    
}


 
