
<?php

class EditEmployeeProfileForm extends CFormModel {

    public $techo2_Emp_Firstname;
    public $techo2_Emp_Middlename;
    public $techo2_Emp_Lastname;
    public $techo2_Emp_Email;
    public $techo2_Emp_Phone;
    public $techo2_Emp_Code;
    public $techo2_Emp_Designation;
    public $techo2_Emp_Gender;
    public $techo2_Emp_Country;
    public $techo2_Emp_State;
    public $techo2_Emp_Dob;
    public $techo2_Emp_Address;
    

    public function rules() {

        return array(
            array('techo2_Emp_Firstname,techo2_Emp_Middlename,techo2_Emp_Lastname,techo2_Emp_Dob,techo2_Emp_Address', 'required', 'message' => 'Please enter a valid  {attribute}.'),
            array('techo2_Emp_Firstname,techo2_Emp_Middlename,techo2_Emp_Lastname', 'length', 'min' => 2, 'max' => 40),
            array('techo2_Emp_Firstname,techo2_Emp_Middlename,techo2_Emp_Lastname', 'match', 'pattern' => '/^[A-Za-z_ \']+$/u', 'message' => "Please enter a valid {attribute}."),
            
            array('techo2_Emp_Email', 'length', 'max' => 45),
            array('techo2_Emp_Email', 'email'),
            
            
            array('techo2_Emp_Phone', 'length', 'min' => 10, 'max' => 15),
            array('techo2_Emp_Phone', 'numerical', 'integerOnly' => true),
            
            
            array('techo2_Emp_Designation', 'designation_validation'),
            array('techo2_Emp_Gender', 'gender_validation'),
            array('techo2_Emp_Country', 'country_validation'),
            array('techo2_Emp_State', 'state_validation'),
        );
    }

    public function attributeLabels() {
        return array(
            'techo2_Emp_Firstname' => 'Firstname',
            'techo2_Emp_Middlename' => 'Middlename',
            'techo2_Emp_Lastname' => 'Lastname',
            'techo2_Emp_Email' => 'Email Address',
            'techo2_Emp_Phone' => 'Mobile Number',
            'techo2_Emp_Code' => 'Employee Code',
            'techo2_Emp_Designation' => 'Designation',
            'techo2_Emp_Gender' => 'Gender',
            'techo2_Emp_Country' => 'Country',
            'techo2_Emp_State' => 'State',
            'techo2_Emp_Dob' => 'Date Of Birth',
            'techo2_Emp_Address' => 'Address',
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
    
    

    
}

?>
