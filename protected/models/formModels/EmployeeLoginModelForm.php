
<?php

class EmployeeLoginModelForm extends CFormModel {

    public $techo2_Emp_Username;
    public $techo2_Emp_Password;

    public function rules() {

        return array(
            array('techo2_Emp_Username,techo2_Emp_Password', 'required', 'message' => 'Please enter a valid  {attribute}.'),
            array('techo2_Emp_Username', 'length', 'max' => 45),
            array('techo2_Emp_Username', 'email'),
            array('techo2_Emp_Password', 'length', 'max' => 25),
            array('techo2_Emp_Password', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'techo2_Emp_Username' => 'Username',
            'techo2_Emp_Password' => 'Password',
        );
    }

}

?>
