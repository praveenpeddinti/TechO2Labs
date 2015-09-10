<?php

Class ServiceFactory {
    
    private static $inst_validate_employee_login = NULL;
    private static $inst_get_country_list = NULL;
    private static $inst_get_state_list = NULL;
    private static $inst_get_genders_list = NULL;
    private static $inst_get_designation_list = NULL;
    private static $inst_chk_email = NULL;
    private static $inst_chk_mobile = NULL;
    private static $inst_create_new_memeber = NULL;
    private static $inst_dashboard_service = NULL;

    private function __construct() {
        
    }

    //Get Login Credentials Data
    public static function dashboardServiceProvider() {
        try {
            if (!self::$inst_dashboard_service) {
                self::$inst_dashboard_service = new InstantDashboardService();
            }
            return self::$inst_dashboard_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:dashboardServiceProvider::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    //Inserting multi files data
    public static function multifiles() {
        try {
            if (!self::$inst_multifiles) {
                self::$inst_multifiles = new InstantEmpStorage();
            }
            return self::$inst_multifiles;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:multifiles::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    
    //Get Login Credentials Data
    public static function validateLogin() {
        try {
            if (!self::$inst_validate_employee_login) {
                self::$inst_validate_employee_login = new InstantEmployeeService();
            }
            return self::$inst_validate_employee_login;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:validateLogin::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Get All Countries List
    public static function getAllActiveCountriesList() {
        try {
            if (!self::$inst_get_country_list) {
                self::$inst_get_country_list = new InstantEmployeeService();
            }
            return self::$inst_get_country_list;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getAllActiveCountriesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Get All States List
    public static function getAllActiveStatesList() {
        try {
            if (!self::$inst_get_state_list) {
                self::$inst_get_state_list = new InstantEmployeeService();
            }
            return self::$inst_get_state_list;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getAllActiveStatesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Get All Genders List
    public static function getAllActiveGendersList() {
        try {
            if (!self::$inst_get_genders_list) {
                self::$inst_get_genders_list = new InstantEmployeeService();
            }
            return self::$inst_get_genders_list;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getAllActiveGendersList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Get All Designations List
    public static function getAllActiveDesignatinosList() {
        try {
            if (!self::$inst_get_designation_list) {
                self::$inst_get_designation_list = new InstantEmployeeService();
            }
            return self::$inst_get_designation_list;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getAllActiveDesignatinosList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Email Checking To Maintain Unique Email Address
    public static function checkIsEmailExist() {
        try {
            if (!self::$inst_chk_email) {
                self::$inst_chk_email = new InstantEmployeeService();
            }
            return self::$inst_chk_email;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:checkIsEmailExist::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Mobile Number Checking To Maintain Unique Mobile Number
    public static function checkIsMobileNoExist() {
        try {
            if (!self::$inst_chk_mobile) {
                self::$inst_chk_mobile = new InstantEmployeeService();
            }
            return self::$inst_chk_mobile;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:checkIsMobileNoExist::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Create New Member In Techo2 Family
    public static function joinToTecho2Family() {
        try {
            if (!self::$inst_create_new_memeber) {
                self::$inst_create_new_memeber = new InstantEmployeeService();
            }
            return self::$inst_create_new_memeber;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:joinToTecho2Family::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

}

?>