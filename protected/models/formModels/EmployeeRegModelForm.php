
<?php

class EmployeeRegModelForm extends CFormModel {

    public $techo2_Emp_Firstname;
    public $techo2_Emp_Middlename;
    public $techo2_Emp_Lastname;
    public $techo2_Emp_Email;
    public $techo2_Emp_Phone;
    public $techo2_Emp_Password;
    public $techo2_Emp_ConfirmPassword;
    public $techo2_Emp_Designation;
    public $techo2_Emp_Gender;
    public $techo2_Emp_Dob;
    public $techo2_Emp_Country;
    public $techo2_Emp_State;
    public $techo2_Emp_Address;
    public $techo2_Terms_Conditions;

    public function rules() {

        return array(
            array('techo2_Emp_Firstname,techo2_Emp_Middlename,techo2_Emp_Lastname,techo2_Emp_Email,techo2_Emp_Phone,techo2_Emp_Password,techo2_Emp_ConfirmPassword,techo2_Emp_Designation,techo2_Emp_Country,techo2_Emp_Dob,techo2_Emp_Address', 'required', 'message' => 'Please enter a valid  {attribute}.'),
            array('techo2_Emp_Firstname,techo2_Emp_Middlename,techo2_Emp_Lastname', 'length', 'min' => 2, 'max' => 40),
            array('techo2_Emp_Firstname,techo2_Emp_Middlename,techo2_Emp_Lastname', 'match', 'pattern' => '/^[A-Za-z_ \']+$/u', 'message' => "Please enter a valid {attribute}."),
            array('techo2_Emp_Email', 'length', 'max' => 45),
            array('techo2_Emp_Email', 'email'),
            array('techo2_Emp_Email', 'unique_email'),
            array('techo2_Emp_Phone', 'length', 'min' => 10, 'max' => 15),
            array('techo2_Emp_Phone', 'numerical', 'integerOnly' => true),
            array('techo2_Emp_Phone', 'unique_phone'),
            array('techo2_Emp_Password, techo2_Emp_ConfirmPassword', 'length', 'min' => 5, 'max' => 8),
            array('techo2_Emp_ConfirmPassword', 'compare', 'compareAttribute' => 'techo2_Emp_Password'),
            array('techo2_Emp_Designation', 'designation_validation'),
            array('techo2_Emp_Country', 'country_validation'),
            array('techo2_Emp_State', 'state_validation'),
            array('techo2_Emp_Gender', 'gender_validation'),
            array('techo2_Terms_Conditions', 'tNc_validation'),
        );
    }

    public function attributeLabels() {
        return array(
            'techo2_Emp_Firstname' => 'Firstname',
            'techo2_Emp_Middlename' => 'Middlename',
            'techo2_Emp_Lastname' => 'Lastname',
            'techo2_Emp_Email' => 'Email Address',
            'techo2_Emp_Phone' => 'Mobile Number',
            'techo2_Emp_Password' => 'Password',
            'techo2_Emp_ConfirmPassword' => 'Confirm Password',
            'techo2_Emp_Designation' => 'Designation',
            'techo2_Emp_Gender' => 'Gender',
            'techo2_Emp_Dob' => 'Date Of Birth',
            'techo2_Emp_Country' => 'Country',
            'techo2_Emp_State' => 'State',
            'techo2_Emp_Address' => 'Address',
            'techo2_Terms_Conditions' => 'I Agree Terms and conditions.',
        );
    }

    //Gender Validation
    public function gender_validation($attribute) {
        if (NULL == $this->techo2_Emp_Gender) {
            $this->addError($attribute, "Please select the gender.");
            return false;
        } else {
            return true;
        }
    }

    //Designation Validation
    public function designation_validation($attribute) {
        if (-1 == $this->techo2_Emp_Designation) {
            $this->addError($attribute, "Please select the designation.");
            return false;
        } else {
            return true;
        }
    }

    //Country Validation
    public function country_validation($attribute) {
        if (-1 == $this->techo2_Emp_Country) {
            $this->addError($attribute, "Please select the country.");
            return false;
        } else {
            return true;
        }
    }
    
    //State Validation
    public function state_validation($attribute){
        if (NULL == $this->techo2_Emp_State || -1 == $this->techo2_Emp_State) {
            $this->addError($attribute, "Please select the state.");
            return false;
        } else {
            return true;
        }
    }

    //Check is email address exist or not
    public function unique_email($attribute) {
        $response = array();
        $email_response = array();
        $email_address = NULL;
        if(isset($this->techo2_Emp_Email) && !empty($this->techo2_Emp_Email)){
            $email_address = $this->techo2_Emp_Email;
        }
        $email_response = ServiceFactory::checkIsEmailExist()->isEmailAddressExist($email_address);
        if(isset($email_response) && count($email_response) > 0){
            $response = $email_response;
        }
        if(isset($response) && count($response) > 0){
            $this->addError($attribute, "$this->techo2_Emp_Email already exists. Try with another one.");
            return false;
        }else if(0 == count($response)){
            return true;
        }
    }

    //Check is phone number exist or not
    public function unique_phone($attribute) {
        $response = array();
        $phone_response = array();
        $phone_number = NULL;
        if(isset($this->techo2_Emp_Phone) && !empty($this->techo2_Emp_Phone)){
            $phone_number = $this->techo2_Emp_Phone;
        }
        $phone_response = ServiceFactory::checkIsMobileNoExist()->isMobileNumberExist($phone_number);
        if(isset($phone_response) && count($phone_response) > 0){
            $response = $phone_response;
        }
        
        if(isset($response) && count($response) > 0){
            $this->addError($attribute, "$this->techo2_Emp_Phone already exists. Try with another one.");
            return false;
        }else if(0 == count($response)){
            return true;
        }
    }
    
    //Terms And Conditions Validation
    public function tNc_validation($attribute){
        if(NULL == $this->techo2_Terms_Conditions || 0 == $this->techo2_Terms_Conditions){
            $this->addError($attribute, "Please accept the terms and conditions.");
            return false;
        }else{
            return true;
        }
    }

}

?>
