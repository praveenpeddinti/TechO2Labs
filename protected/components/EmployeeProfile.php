<?php

class EmployeeProfile extends CWidget {

    public $employee_profile;

    public function run() {
        $data = array();
        $data['profile'] = $this->employee_profile;
        $this->render('EmployeeProfileView', $data);
    }

}

?>