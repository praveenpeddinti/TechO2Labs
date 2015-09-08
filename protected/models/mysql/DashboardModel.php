<?php
/* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Class       : DashboardModel
 * Function    : This function deals with all database operations 
 */
Class DashboardModel extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

      /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : loggedInEmpData
 * Function    : Get employee details 
 * Params      : employee id
 * Return Type : It will return an array resposne [ row ]
 */
    public function loggedInEmpData($employee_id) {
        try {

            $response = array();
            $employeeArr = array();
            $limit = 1;
            $employeeArr = Yii::app()->db->createCommand()
                    ->select('te.employee_id,concat(te.employee_firstname," ",te.employee_middlename," ",te.employee_lastname) as fullname,ted.name as designation_name,te.employee_tag_code as employee_code,tee.email as employee_email,tep.phonenumber as employee_phone,te.employee_status')
                    ->from('techo2_employee te')
                    ->join('techo2_employee_email tee', 'tee.employee_idemployee = te.employee_id and tee.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->join('techo2_employee_phone tep', 'tep.employee_idemployee = te.employee_id and tep.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->join('techo2_employee_designation ted', 'ted.employee_designation_id = te.designation_iddesignation and ted.status=:status', array(':status' => $limit))
                    ->where('te.employee_id=:idemployee and te.employee_status =:status', array(':idemployee' => $employee_id, ':status' => $limit))
                    ->limit($limit)
                    ->queryRow();
            if (isset($employeeArr) && is_array($employeeArr) && count($employeeArr) > 0) {
                $response = $employeeArr;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:loggedInEmpData::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

     /* 
 * Author      : Meda Vinod Kumar
 * Date        : 05-Sep-2015
 * Method      : getAllEmpData
 * Function    : Get all employee details 
 * Return Type : It will return an array resposne
 */
    public function getAllEmpData() {
        try {

            $response = array();
            $allEmployeesData = array();
            $active = 1;
            $allEmployeesData = Yii::app()->db->createCommand()
                    ->select("te.employee_id as employee_id,te.employee_firstname as firstname,te.employee_middlename as middlename,te.employee_lastname as lastname,te.employee_username as username,te.employee_tag_code as employee_code,te.employee_dob,te.employee_status,tg.type as employee_gender,tea.address as employee_address,ts.name as employee_state,tc.name as country_name,ted.name as employee_designation,tee.email as employee_email,tep.phonenumber as employee_phonenumber,")
                    ->from('techo2_employee te')
                    ->join('techo2_gender tg', 'tg.sign = te.employee_gender and tg.status=:status', array(':status' => $active))
                    ->join('techo2_employee_email tee', 'tee.employee_idemployee = te.employee_id and tee.isdefault=:isdefault', array(':isdefault' => $active))
                    ->join('techo2_employee_phone tep', 'tep.employee_idemployee = te.employee_id and tep.isdefault=:isdefault', array(':isdefault' => $active))
                    ->join('techo2_employee_designation ted', 'ted.employee_designation_id = te.designation_iddesignation and ted.status =:status', array(':status' => $active))
                    ->join('techo2_employee_address tea', 'tea.employee_idemployee = te.employee_id and tea.isdefault=:isdefault', array(':isdefault' => $active))
                    ->join('techo2_state ts', 'ts.idstate = tea.state_idstate and ts.status=:status', array(':status' => $active))
                    ->join('techo2_country tc', 'tc.idcountry = ts.country_idcountry and tc.status=:status', array(':status' => $active))
                    ->order(array('te.employee_firstname', 'ted.employee_designation_id desc'))
                    ->queryAll();
            if (isset($allEmployeesData) && count($allEmployeesData) > 0) {
                $response = $allEmployeesData;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:getAllEmpData::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    
     /* 
 * Author      : Meda Vinod Kumar
 * Date        : 05-Sep-2015
 * Method      : getEmpProfileDet
 * Function    : Get employee details 
 * Params      : Employee Id
 * Return Type : It will return an array resposne [ row ]
 */
    public function getEmpProfileDet($employee_id) {
        try {
            $response = array();
            $employeeArr = array();
            $limit = 1;
            $employeeArr = Yii::app()->db->createCommand()
                    ->select('te.employee_id,te.employee_firstname,te.employee_middlename,te.employee_lastname,te.employee_tag_code as employee_code,tee.email as employee_email,tep.phonenumber as employee_phone,te.employee_status,te.designation_iddesignation as designation_id,te.employee_gender as gender_type,te.employee_dob,tea.address as employee_address,tea.state_idstate as employee_state,ts.country_idcountry as  employee_country')
                    ->from('techo2_employee te')
                    ->join('techo2_employee_email tee', 'tee.employee_idemployee = te.employee_id and tee.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->join('techo2_employee_phone tep', 'tep.employee_idemployee = te.employee_id and tep.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->join('techo2_employee_address tea', 'tea.employee_idemployee = te.employee_id and tea.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->join('techo2_state ts', 'ts.idstate = tea.state_idstate and ts.status=:status', array(':status' => $limit))
                    ->where('te.employee_id=:idemployee and te.employee_status =:status', array(':idemployee' => $employee_id, ':status' => $limit))
                    ->limit($limit)
                    ->queryRow();
            if (isset($employeeArr) && is_array($employeeArr) && count($employeeArr) > 0) {
                $response = $employeeArr;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:getEmpProfileDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

      /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : updateEmployeeBasicDet
 * Function    : Update employee  details [ like firstname, middlename, lastname ]
 * Params      : Updated columns, Employee Id
 * Return Type : It will return an integer resposne as 1.[ affected rows ]
 */
    public function updateEmployeeBasicDet($updated_employee_arr, $employee_id) {
        try {
            $response = 0;
            $update = 0;
            $update = Yii::app()->db->createCommand()
                    ->update('techo2_employee', $updated_employee_arr, 'employee_id=:idemployee', array(':idemployee' => $employee_id)
            );
            if ($update > 0) {
                $response = $update;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:updateEmployeeBasicDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

       /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : updateEmployeeAddressDet
 * Function    : Update employee address details [ address, state ]
 * Params      : Updated columns, Employee Id
 * Return Type : It will return an integer resposne as 1.[ affected rows ]
 */
    public function updateEmployeeAddressDet($updated_address_arr, $employee_id) {
        try {
            $response = 0;
            $update = 0;
            $update = Yii::app()->db->createCommand()
                    ->update('techo2_employee_address', $updated_address_arr, 'employee_idemployee=:idemployee', array(':idemployee' => $employee_id)
            );
            if ($update > 0) {
                $response = $update;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:updateEmployeeAddressDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

        /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : updateEmployeeEmailDet
 * Function    : Update employee email details [ email address ]
 * Params      : Updated columns, Employee Id
 * Return Type : It will return an integer resposne as 1.[ affected rows ]
 */
    public function updateEmployeeEmailDet($updated_employee_email_arr, $employee_id) {
        try {
            $response = 0;
            $update = 0;
            $update = Yii::app()->db->createCommand()
                    ->update('techo2_employee_email', $updated_employee_email_arr, 'employee_idemployee=:idemployee', array(':idemployee' => $employee_id)
            );
            if ($update > 0) {
                $response = 1;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:updateEmployeeEmailDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

       /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : updateEmployeePhoneDet
 * Function    : Update employee phone details [ phonenumber ]
 * Params      : Updated columns, Employee Id
 * Return Type : It will return an integer resposne as 1.[ affected rows ]
 */
    public function updateEmployeePhoneDet($updated_employee_phone_arr, $employee_id) {
        try {
            $response = 0;
            $update = 0;
            $update = Yii::app()->db->createCommand()
                    ->update('techo2_employee_phone', $updated_employee_phone_arr, 'employee_idemployee=:idemployee', array(':idemployee' => $employee_id)
            );
            if ($update > 0) {
                $response = 1;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:updateEmployeePhoneDet::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

}

?>