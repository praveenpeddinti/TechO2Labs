<?php

Class InstantDashboardService {

    public function loggedInEmpData($emp_id) {
        $response = array();
        $employeeData = array();
        $employee_id = 0;
        if (isset($emp_id) && !empty($emp_id) && $emp_id > 0) {
            $employee_id = $emp_id;
        }
        if ($employee_id > 0) {
            $employeeData = DashboardModel::model()->loggedInEmpData($employee_id);
            if (isset($employeeData) && count($employeeData) > 0) {
                $response = $employeeData;
            }
        }

        return $response;
    }

    public function getAllEmpData() {
        $response = array();
        $allEmployeesData = array();
        $allEmployeesData = DashboardModel::model()->getAllEmpData();
        if (isset($allEmployeesData) && count($allEmployeesData) > 0) {
            $response = $allEmployeesData;
        }
        return $response;
    }

    public function getEmpProfileDet($emp_id) {
        $response = array();
        $empProfileData = array();
        $employee_id = 0;
        if (isset($emp_id) && !empty($emp_id) && $emp_id > 0) {
            $employee_id = $emp_id;
        }
        if ($employee_id > 0) {
            $empProfileData = DashboardModel::model()->getEmpProfileDet($employee_id);
            if (isset($empProfileData) && count($empProfileData) > 0) {
                $response = $empProfileData;
            }
        }
        return $response;
    }

    public function updateEmployeeBasicDet($updated_employee_arr, $employee_id) {
        $response = 0;
        $response_on_emp_udpate = 0;
        $response_on_emp_udpate = DashboardModel::model()->updateEmployeeBasicDet($updated_employee_arr, $employee_id);
        if (1 == $response_on_emp_udpate) {
            $response = $response_on_emp_udpate;
        }
        return $response;
    }

    public function updateEmployeeAddressDet($updated_address_arr, $employee_id) {
        $response = 0;
        $response_on_address_udpate = 0;
        $response_on_address_udpate = DashboardModel::model()->updateEmployeeAddressDet($updated_address_arr, $employee_id);
        if (1 == $response_on_address_udpate) {
            $response = $response_on_address_udpate;
        }
        return $response;
    }

    public function updateEmployeeEmailDet($updated_employee_email_arr, $employee_id) {
        $response = 0;
        $response_on_email_udpate = 0;
        if (isset($updated_employee_email_arr) && count($updated_employee_email_arr) > 0 && $employee_id > 0) {
            $response_on_email_udpate = DashboardModel::model()->updateEmployeeEmailDet($updated_employee_email_arr, $employee_id);
            if (1 == $response_on_email_udpate) {
                $response = $response_on_email_udpate;
            }
        }

        return $response;
    }
    
    public function updateEmployeePhoneDet($updated_employee_phone_arr, $employee_id){
        $response = 0;
        $response_on_phone_udpate = 0;
        
        if (isset($updated_employee_phone_arr) && count($updated_employee_phone_arr) > 0 && $employee_id > 0) {
            
            $response_on_phone_udpate = DashboardModel::model()->updateEmployeePhoneDet($updated_employee_phone_arr, $employee_id);
          
            if (1 == $response_on_phone_udpate) {
                $response = $response_on_phone_udpate;
            }
        }

        return $response;
    }

}

?>