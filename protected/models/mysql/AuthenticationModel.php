<?php
 /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Class       : AuthenticationModel
 * Function    : This function deals with all database operations 
 */
Class AuthenticationModel extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

       /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : verifyLogin
 * Function    : verify user login data
 * Params      : username, password
 * Return Type : It will return an array resposne [ row ]
 */
    public function verifyLogin($username, $password) {
        try {
            $response = array();
            $employee = array();
            $limit = 1;
            $employee = Yii::app()->db->createCommand()
                    ->select('te.employee_id,concat(te.employee_firstname," ",te.employee_middlename," ",te.employee_lastname) as fullname,ted.name as designation_name,ted.employee_designation_id as designation_id')
                    ->from('techo2_employee te')
                    ->join('techo2_employee_designation ted', 'ted.employee_designation_id = te.designation_iddesignation and ted.status=:status', array(':status' => $limit))
                    ->where('te.employee_username=:username and te.employee_password=:password and te.employee_status =:status', array(':username' => $username, ':password' => $password, ':status' => $limit))
                    ->limit($limit)
                    ->queryRow();
            if (isset($employee) && is_array($employee) && count($employee) > 0) {
                $response = $employee;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:verifyLogin::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

        /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : getCountriesList
 * Function    : Get all countries list from the table
 * Return Type : It will return an array resposne
 */
    public function getCountriesList() {
        try {
            $response = array();
            $countryList = array();
            $active = 1;
            $countryList = Yii::app()->db->createCommand()
                    ->select("tc.idcountry as country_id,tc.name as country_name")
                    ->from("techo2_country tc")
                    ->where("tc.status=:status", array(':status' => $active))
                    ->queryAll();
            if (isset($countryList) && count($countryList) > 0) {
                $response = $countryList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:getCountriesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

       /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : getAllStatesList
 * Function    : Get all states list from the table
 * Return Type : It will return an array resposne
 */
    public function getAllStatesList() {
        try {
            $response = array();
            $statesList = array();
            $active = 1;
            $statesList = Yii::app()->db->createCommand()
                    ->select("ts.idstate as state_id,ts.name as state_name,ts.country_idcountry as country_id,")
                    ->from("techo2_state ts")
                    ->where("ts.status=:status", array(':status' => $active))
                    ->queryAll();
            if (isset($statesList) && count($statesList) > 0) {
                $response = $statesList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:getAllStatesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

      /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : getStatesList
 * Function    : Get all states list from the table
 * Params      : country id
 * Return Type : It will return an array resposne [ row ]
 */
    public function getStatesList($country_id) {
        try {
            $response = array();
            $statesList = array();
            $active = 1;
            $statesList = Yii::app()->db->createCommand()
                    ->select("ts.idstate as state_id,ts.name as state_name")
                    ->from("techo2_state ts")
                    ->where("ts.country_idcountry=:idcountry and ts.status=:status", array(':idcountry' => $country_id, ':status' => $active))
                    ->queryAll();
            if (isset($statesList) && count($statesList) > 0) {
                $response = $statesList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:getStatesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

     /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : getDesignationsList
 * Function    : Get all designtion types from the table
 * Return Type : It will return an array resposne
 */
    public function getDesignationsList() {
        try {
            $response = array();
            $designationList = array();
            $active = 1;
            $designationList = Yii::app()->db->createCommand()
                    ->select("ted.employee_designation_id as designation_id,ted.name as designation_name")
                    ->from("techo2_employee_designation ted")
                    ->where("ted.status=:status", array(':status' => $active))
                    ->queryAll();
            if (isset($designationList) && count($designationList) > 0) {
                $response = $designationList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:getDesignationsList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : getGendersList
 * Function    : Get all gender types from the table
 * Return Type : It will return an array resposne
 */
    public function getGendersList() {
        try {
            $response = array();
            $gendersList = array();
            $active = 1;
            $gendersList = Yii::app()->db->createCommand()
                    ->select("tg.idgender as gender_id,tg.type as gender_type,tg.sign as gender_sign")
                    ->from("techo2_gender tg")
                    ->where("tg.status=:status", array(':status' => $active))
                    ->queryAll();
            if (isset($gendersList) && count($gendersList) > 0) {
                $response = $gendersList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:getGendersList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : isEmailAddressExist
 * Function    : It will check the email address in table.
 * Params      : email address
 * Return Type : It will return an array resposne [ row ]
 */
    public function isEmailAddressExist($email_address) {
        try {
            $response = array();
            $emailChkResponse = array();
            $emailChkResponse = Yii::app()->db->createCommand()
                    ->select('tee.employee_idemployee as employee_id,tee.email as email_address')
                    ->from('techo2_employee_email tee')
                    ->where('tee.email=:emailaddress', array('emailaddress' => $email_address))
                    ->queryRow();
            if (isset($emailChkResponse) && is_array($emailChkResponse) && count($emailChkResponse) > 0) {
                $response = $emailChkResponse;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:isEmailAddressExist::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : isMobileNumberExist
 * Function    : It will check the mobile number in table.
 * Params      : phone number    
 * Return Type : It will return an array resposne [ row ]
 */
    public function isMobileNumberExist($phone_number) {
        try {
            $response = array();
            $mobileChkResponse = array();
            $mobileChkResponse = Yii::app()->db->createCommand()
                    ->select('tep.employee_idemployee as employee_id,tep.phonenumber as phone_number')
                    ->from('techo2_employee_phone tep')
                    ->where('tep.phonenumber=:phonenumber', array('phonenumber' => $phone_number))
                    ->queryRow();
            if (isset($mobileChkResponse) && is_array($mobileChkResponse) && count($mobileChkResponse) > 0) {
                $response = $mobileChkResponse;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:isMobileNumberExist::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : createNewTecho2Employee
 * Function    : Add new employee to techo2 family 
 * Params      : employee registration details [ firstname, middlename, lastname, tag code, username, password, designation, gender, status, createddate, created by ]
 * Return Type : It will return integer [ last record inserted id]
 */
    public function createNewTecho2Employee($techo2_employee_table_data) {
        try {
            $response = 0;
            $employee_id = 0;
            $command = Yii::app()->db->createCommand();
            $employee_id = $command->insert('techo2_employee', $techo2_employee_table_data);
            if ($employee_id > 0) {
                $response = Yii::app()->db->getLastInsertId();
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:createNewTecho2Employee::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : addEmail
 * Function    : It will add email address to the table and if response is ok, then we will also add phone and address to concern tables.
 * Params      : email employee data [ email address, employee id ] , employee phone data, employe address data
 * Return Type : It will return integer [ last record inserted id of address ]
 */
    public function addEmail($techo2_employee_email_data, $techo2_employee_phone_data, $techo2_employee_address_data) {
        try {
            $response = 0;
            $last_inserted_address_id = 0;
            $last_inserted_phone_id = 0;
            $last_inserted_email_id = 0;
            $command = Yii::app()->db->createCommand();
            $last_inserted_email_id = $command->insert('techo2_employee_email', $techo2_employee_email_data);
            $last_inserted_email_id = Yii::app()->db->getLastInsertId();
            if ($last_inserted_email_id > 0) {
                $last_inserted_phone_id = $this->addPhone($techo2_employee_phone_data);
                if ($last_inserted_phone_id > 0) {
                    $last_inserted_address_id = $this->addAddress($techo2_employee_address_data);
                    if ($last_inserted_address_id > 0) {
                        $response = $last_inserted_address_id;
                    }
                }
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:addEmail::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

     /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : addEmpCode
 * Function    : It will add new employee code to the table
 * Params      : employee tag code data [ code, employee id ]
 * Return Type : It will return integer [ last record inserted id ]
 */
    public function addEmpCode($techo2_employee_code_data) {
        try {
            $response = 0;
            $last_inserted_code_id = 0;
            $command = Yii::app()->db->createCommand();
            $last_inserted_code_id = $command->insert('techo2_employee_code', $techo2_employee_code_data);
            if ($last_inserted_code_id > 0) {
                $response = Yii::app()->db->getLastInsertId();
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:addEmpCode::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

     /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : addPhone
 * Function    : Add contact number to the table
 * Params      : phone data [ phone number, employee id ]
 * Return Type : It will return integer [ last record inserted id ]
 */
    public function addPhone($techo2_employee_phone_data) {
        try {
            $response = 0;
            $last_inserted_phone_id = 0;
            $command = Yii::app()->db->createCommand();
            $last_inserted_phone_id = $command->insert('techo2_employee_phone', $techo2_employee_phone_data);
            if ($last_inserted_phone_id > 0) {
                $response = Yii::app()->db->getLastInsertId();
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:addPhone::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    
    /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : addAddress
 * Function    : Add customer address, state to the table
 * Params      : address data [ address, state, employee id ]
 * Return Type : It will return integer [ last record inserted id ]
 */
    public function addAddress($techo2_employee_address_data) {
        try {
            $response = 0;
            $last_inserted_address_id = 0;
            $command = Yii::app()->db->createCommand();
            $last_inserted_address_id = $command->insert('techo2_employee_address', $techo2_employee_address_data);
            if ($last_inserted_address_id > 0) {
                $response = Yii::app()->db->getLastInsertId();
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:addAddress::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

 /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : getMaxCode
 * Function    : Get the maximum code from the table
 * Return Type : It will return an array response
 */
    public function getMaxCode() {
        try {
            $response = array();
            $maxCodeArr = array();
            $maxCodeArr = Yii::app()->db->createCommand()
                    ->select("max(tec.code) as max_code")
                    ->from("techo2_employee_code tec")
                    ->queryRow();
            if (isset($maxCodeArr) && count($maxCodeArr) > 0) {
                $response = $maxCodeArr;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:getMaxCode::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

     /* 
 * Author      : Meda Vinod Kumar
 * Date        : 11-Sep-2015
 * Method      : getCategoriesList
 * Function    : Get all categories list from the table
 * Return Type : It will return an array resposne
 */
    public function getCategoriesList() {
        try {
            $response = array();
            $categoryList = array();
            $categoryList = Yii::app()->db->createCommand()
                    ->select("tc.category_id,tc.category_name,tc.category_status")
                    ->from("techo2_categories tc")
                    ->queryAll();
            if (isset($categoryList) && count($categoryList) > 0) {
                $response = $categoryList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:getCategoriesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
}

?>