<?php

class EditRatingsForm extends CFormModel{
    public $techo2_Emp_Name;
    public $techo2_Emp_Code;
    public $techo2_Emp_Email;
    public $techo2_Emp_Phone;
    
    public function attributeLabels() {
        return array(
            'techo2_Emp_Name' => 'Employee Name',
            'techo2_Emp_Code' => 'Employee Code',
            'techo2_Emp_Email' => 'Email Address',
            'techo2_Emp_Phone' => 'Mobile Number',
        );
    }
}

?>