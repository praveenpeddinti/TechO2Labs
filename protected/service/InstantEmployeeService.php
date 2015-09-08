<?php

Class InstantEmployeeService {

    //Verify User Login Credentials
    public function verifyLogin($usrName, $pwd) {
        try {

            $response = array();
            $loggedInAccDet = array();
            $username = NULL;
            $password = NULL;
            if (isset($usrName) && !empty($usrName)) {
                $username = $usrName;
            }

            if (isset($pwd) && !empty($pwd)) {
                $password = $pwd;
            }
            if (NULL != $username && NULL != $password) {
                $response = AuthenticationModel::model()->verifyLogin($username, $password);
                if (isset($response) && count($response) > 0) {
                    $loggedInAccDet = $response;
                }
            }

            return $loggedInAccDet;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:verifyLogin::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Get All Active Countries List
    public function getCountriesList() {
        try {
            $response = array();
            $countryList = array();
            $countryList = AuthenticationModel::model()->getCountriesList();
            if (isset($countryList) && count($countryList) > 0) {
                $response = $countryList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:getCountriesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * 
     * @return type
     */
    public function getAllStatesList() {
        try {
            $response = array();
            $statesList = array();
            $statesList = AuthenticationModel::model()->getAllStatesList();
            if (isset($statesList) && count($statesList) > 0) {
                $response = $statesList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:getAllStatesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Get All Active States List
    public function getStatesList($id_country) {
        try {
            $response = array();
            $country_id = 0;
            if (isset($id_country) && !empty($id_country) && $id_country > 0) {
                $country_id = $id_country;
            }
            $statesList = array();
            $statesList = AuthenticationModel::model()->getStatesList($country_id);
            if (isset($statesList) && count($statesList) > 0) {
                $response = $statesList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:getStatesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Get All Active Designations List
    public function getDesignationsList() {
        try {


            $response = array();
            $designationList = array();
            $designationList = AuthenticationModel::model()->getDesignationsList();
            if (isset($designationList) && count($designationList) > 0) {
                $response = $designationList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:getDesignationsList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Get All Active Genders List
    public function getGendersList() {
        try {


            $response = array();
            $gendersList = array();
            $gendersList = AuthenticationModel::model()->getGendersList();
            if (isset($gendersList) && count($gendersList) > 0) {
                $response = $gendersList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:getGendersList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Check Is Email Address Exist
    public function isEmailAddressExist($email) {
        try {
            $response = array();
            $email_address = NULL;
            if (isset($email) && !empty($email)) {
                $email_address = $email;
            }
            $emailChkResponse = array();
            $emailChkResponse = AuthenticationModel::model()->isEmailAddressExist($email_address);
            if (isset($emailChkResponse) && count($emailChkResponse) > 0) {
                $response = $emailChkResponse;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:isEmailAddressExist::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Check Is Mobile Number Exist
    public function isMobileNumberExist($phone) {
        try {
            $response = array();
            $phone_number = NULL;
            if (isset($phone) && !empty($phone) > 0) {
                $phone_number = $phone;
            }
            $mobileChkResponse = array();
            $mobileChkResponse = AuthenticationModel::model()->isMobileNumberExist($phone_number);
            if (isset($mobileChkResponse) && count($mobileChkResponse) > 0) {
                $response = $mobileChkResponse;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:isMobileNumberExist::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Add A New Member To Techo2 Family
    public function createNewTecho2Employee($new_emp_reg_data) {
        try {
            $reg_response = 0;
            $currentDataNTime = NULL;
            $password = NULL;
            $md5Password = NULL;
            $techo2_employee_table_data = array();
            $techo2_employee_code_data = array();
            $techo2_employee_email_data = array();
            $techo2_employee_phone_data = array();
            $techo2_employee_address_data = array();
            $techo2_emp_codeArr = NULL;
            $techo2_emp_code = NULL;
            $serial_number = 0;
            $techo2_employee_id = NULL;
            $add_emp_codeRes = NULL;


            $password = isset($new_emp_reg_data->techo2_Emp_Password) ? $new_emp_reg_data->techo2_Emp_Password : 'NA';
            $md5Password = md5($password);
            $currentDataNTime = date('Y-m-d H:i:s');
            $techo2_emp_codeArr = $this->actionGetTecho2EmployeeCode();
            if (isset($techo2_emp_codeArr) && count($techo2_emp_codeArr) > 0) {
                $techo2_emp_code = isset($techo2_emp_codeArr['code']) ? $techo2_emp_codeArr['code'] : 'NA';
                $serial_number = isset($techo2_emp_codeArr['serial_number']) ? $techo2_emp_codeArr['serial_number'] : $serial_number;
            }
            $techo2_employee_table_data = array(
                'employee_firstname' => isset($new_emp_reg_data->techo2_Emp_Firstname) ? $new_emp_reg_data->techo2_Emp_Firstname : 'NA',
                'employee_middlename' => isset($new_emp_reg_data->techo2_Emp_Middlename) ? $new_emp_reg_data->techo2_Emp_Middlename : 'NA',
                'employee_lastname' => isset($new_emp_reg_data->techo2_Emp_Lastname) ? $new_emp_reg_data->techo2_Emp_Lastname : 'NA',
                'employee_username' => isset($new_emp_reg_data->techo2_Emp_Email) ? $new_emp_reg_data->techo2_Emp_Email : 'NA',
                'employee_password' => $md5Password,
                'employee_tag_code' => $techo2_emp_code,
                'designation_iddesignation' => isset($new_emp_reg_data->techo2_Emp_Designation) ? $new_emp_reg_data->techo2_Emp_Designation : '0',
                'employee_gender' => isset($new_emp_reg_data->techo2_Emp_Gender) ? $new_emp_reg_data->techo2_Emp_Gender : '-',
                'employee_dob' => isset($new_emp_reg_data->techo2_Emp_Dob) ? $new_emp_reg_data->techo2_Emp_Dob : '-',
                'employee_status' => 1,
                'employee_createddate' => $currentDataNTime,
                'employee_createdby' => 1
            );



            $techo2_employee_id = AuthenticationModel::model()->createNewTecho2Employee($techo2_employee_table_data);
            if ($techo2_employee_id > 0) {

                $techo2_employee_code_data = array(
                    'code' => $serial_number,
                    'employee_idemployee' => $techo2_employee_id,
                );


                $techo2_employee_email_data = array(
                    'email' => isset($new_emp_reg_data->techo2_Emp_Email) ? $new_emp_reg_data->techo2_Emp_Email : 'NA',
                    'employee_idemployee' => $techo2_employee_id,
                    'isdefault' => 1
                );

                $techo2_employee_phone_data = array(
                    'phonenumber' => isset($new_emp_reg_data->techo2_Emp_Phone) ? $new_emp_reg_data->techo2_Emp_Phone : 'NA',
                    'employee_idemployee' => $techo2_employee_id,
                    'isdefault' => 1
                );

                $techo2_employee_address_data = array(
                    'address' => isset($new_emp_reg_data->techo2_Emp_Address) ? $new_emp_reg_data->techo2_Emp_Address : 'NA',
                    'state_idstate' => isset($new_emp_reg_data->techo2_Emp_State) ? $new_emp_reg_data->techo2_Emp_State : '0',
                    'employee_idemployee' => $techo2_employee_id,
                    'isdefault' => 1
                );

                $add_emp_codeRes = AuthenticationModel::model()->addEmpCode($techo2_employee_code_data);
                $reg_response = AuthenticationModel::model()->addEmail($techo2_employee_email_data, $techo2_employee_phone_data, $techo2_employee_address_data);
            }
            return $reg_response;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:createNewTecho2Employee::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetTecho2EmployeeCode() {
        try {
            $codeArr = NULL;
            $code = NULL;
            $serial_number = NULL;
            $techo2Sign = NULL;
            $max_res_arr = array();
            $get_max_code = NULL;


            $techo2Sign = "Techo2";
            $serial_number = 101;
            $serial_number = sprintf("%'.04d\n", $serial_number);

            /* Serial Number Logic Section Start */
            $max_res_arr = AuthenticationModel::model()->getMaxCode();
            if (isset($max_res_arr) && count($max_res_arr) > 0) {
                if (NULL == $max_res_arr['max_code']) {
                    $serial_number = $serial_number;
                } else if (NULL != $max_res_arr['max_code'] && $max_res_arr['max_code'] > 0) {
                    $serial_number = $max_res_arr['max_code'] + 1;
                }
            }
            /* Serial Number Logic Section End */

            $code = $techo2Sign . '-' . $serial_number;
            $codeArr = array('code' => $code, 'serial_number' => $serial_number);
            return $codeArr;
        } catch (Exception $ex) {
            Yii::log("InstantEmployeeService:actionGetTecho2EmployeeCode::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

}

?>