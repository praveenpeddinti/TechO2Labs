<?php

Class AuthenticationModel extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //Verify Employee Login
    public function verifyLogin($username, $password) {
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
    }

    //Get All Active Countries List
    public function getCountriesList() {
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
    }
    
    //Get All Active Countries List
    public function getAllStatesList() {
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
    }

    //Get All Active States List
    public function getStatesList($country_id) {
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
    }

    //Get All Active Designations List
    public function getDesignationsList() {
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
    }

    //Get All Active Genders List
    public function getGendersList() {
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
    }

    //Check Is Email Address Exist
    public function isEmailAddressExist($email_address) {
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
    }

    //Check Is Mobile Number Exist
    public function isMobileNumberExist($phone_number) {
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
    }

    //Add A New Member To Techo2 Family
    public function createNewTecho2Employee($techo2_employee_table_data) {
        $response = 0;
        $employee_id = 0;
        $command = Yii::app()->db->createCommand();
        $employee_id = $command->insert('techo2_employee', $techo2_employee_table_data);
        if ($employee_id > 0) {
            $response = Yii::app()->db->getLastInsertId();
        }
        return $response;
    }
    
    //Add Email
    public function addEmail($techo2_employee_email_data,$techo2_employee_phone_data,$techo2_employee_address_data) {
        $response = 0;
        $last_inserted_address_id = 0;
        $last_inserted_phone_id = 0;
        $last_inserted_email_id = 0;
        $command = Yii::app()->db->createCommand();
        $last_inserted_email_id = $command->insert('techo2_employee_email', $techo2_employee_email_data);
        $last_inserted_email_id = Yii::app()->db->getLastInsertId();
        if ($last_inserted_email_id > 0) {
            $last_inserted_phone_id = $this->addPhone($techo2_employee_phone_data);
            if($last_inserted_phone_id > 0){
                $last_inserted_address_id = $this->addAddress($techo2_employee_address_data);
                if($last_inserted_address_id > 0){
                    $response = $last_inserted_address_id;
                }
            }
        }
        return $response;
    }
    
    //Add Phone
    public function addEmpCode($techo2_employee_code_data) {
        $response = 0;
        $last_inserted_code_id = 0;
        $command = Yii::app()->db->createCommand();
        $last_inserted_code_id = $command->insert('techo2_employee_code', $techo2_employee_code_data);
        if ($last_inserted_code_id > 0) {
            $response = Yii::app()->db->getLastInsertId();
        }
        return $response;
    }
    
    //Add Phone
    public function addPhone($techo2_employee_phone_data) {
        $response = 0;
        $last_inserted_phone_id = 0;
        $command = Yii::app()->db->createCommand();
        $last_inserted_phone_id = $command->insert('techo2_employee_phone', $techo2_employee_phone_data);
        if ($last_inserted_phone_id > 0) {
            $response = Yii::app()->db->getLastInsertId();
        }
        return $response;
    }
    
    //Add Address
    public function addAddress($techo2_employee_address_data) {
        $response = 0;
        $last_inserted_address_id = 0;
        $command = Yii::app()->db->createCommand();
        $last_inserted_address_id = $command->insert('techo2_employee_address', $techo2_employee_address_data);
        if ($last_inserted_address_id > 0) {
            $response = Yii::app()->db->getLastInsertId();
        }
        return $response;
    }
    
   //Get Max Code
    public function getMaxCode(){
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
    }

    
}

?>