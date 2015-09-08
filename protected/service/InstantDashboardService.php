<?php

Class InstantDashboardService {

    public function loggedInEmpData($emp_id) {
        try {



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
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:loggedInEmpData::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getAllEmpData() {
        try {
            $response = array();
            $allEmployeesData = array();
            $allEmployeesData = DashboardModel::model()->getAllEmpData();
            if (isset($allEmployeesData) && count($allEmployeesData) > 0) {
                $response = $allEmployeesData;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:getAllEmpData::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getEmpProfileDet($emp_id) {
        try {
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
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:getEmpProfileDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function updateEmployeeBasicDet($updated_employee_arr, $employee_id) {
        try {
            $response = 0;
            $response_on_emp_udpate = 0;
            $response_on_emp_udpate = DashboardModel::model()->updateEmployeeBasicDet($updated_employee_arr, $employee_id);
            if (1 == $response_on_emp_udpate) {
                $response = $response_on_emp_udpate;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:updateEmployeeBasicDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function updateEmployeeAddressDet($updated_address_arr, $employee_id) {
        try {
            $response = 0;
            $response_on_address_udpate = 0;
            $response_on_address_udpate = DashboardModel::model()->updateEmployeeAddressDet($updated_address_arr, $employee_id);
            if (1 == $response_on_address_udpate) {
                $response = $response_on_address_udpate;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:updateEmployeeAddressDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function updateEmployeeEmailDet($updated_employee_email_arr, $employee_id) {
        try {
            $response = 0;
            $response_on_email_udpate = 0;
            if (isset($updated_employee_email_arr) && count($updated_employee_email_arr) > 0 && $employee_id > 0) {
                $response_on_email_udpate = DashboardModel::model()->updateEmployeeEmailDet($updated_employee_email_arr, $employee_id);
                if (1 == $response_on_email_udpate) {
                    $response = $response_on_email_udpate;
                }
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:updateEmployeeEmailDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function updateEmployeePhoneDet($updated_employee_phone_arr, $employee_id) {
        try {
            $response = 0;
            $response_on_phone_udpate = 0;

            if (isset($updated_employee_phone_arr) && count($updated_employee_phone_arr) > 0 && $employee_id > 0) {

                $response_on_phone_udpate = DashboardModel::model()->updateEmployeePhoneDet($updated_employee_phone_arr, $employee_id);

                if (1 == $response_on_phone_udpate) {
                    $response = $response_on_phone_udpate;
                }
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:updateEmployeePhoneDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function suspendEmployee($emp_id) {
        try {
            $response = 0;
            $employee_id = 0;
            if (isset($emp_id) && $emp_id > 0) {
                $employee_id = $emp_id;
            }
            $response_on_suspend = 0;

            if ($employee_id > 0) {

                $response_on_suspend = DashboardModel::model()->suspendEmployee($employee_id);

                if (1 == $response_on_suspend) {
                    $response = $response_on_suspend;
                }
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:suspendEmployee::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function activateEmployee($emp_id) {
        try {
            $response = 0;
            $employee_id = 0;
            if (isset($emp_id) && $emp_id > 0) {
                $employee_id = $emp_id;
            }
            $response_on_activation = 0;

            if ($employee_id > 0) {

                $response_on_activation = DashboardModel::model()->activateEmployee($employee_id);

                if (1 == $response_on_activation) {
                    $response = $response_on_activation;
                }
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:activateEmployee::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

}

?>