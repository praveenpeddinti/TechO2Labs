<?php

class Techo2EmployeeController extends Controller {

    public $defaultAction = 'EmployeeRegNLogin';

               /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : Error
 * Function    : To overcome miscellaneous actions
 */
    public function actionError() {

        $this->render('/Employee/error');
    }

              /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : EmployeeRegNLogin
 * Function    : Handle registration and login functionalities
 */
    public function actionEmployeeRegNLogin() {
        try {
            $data = array();
            $data['pageTitle'] = Yii::t('PageTitles', 'home');
            $loginErrors = array();
            $regErrors = array();
            $designationRes = array();
            $designationArr = array();
            $genderRes = array();
            $genderArr = array();
            $countryRes = array();
            $countryArr = array();
            $loggedInAccArr = array();
            $loggedInAccDet = NULL;
            $username = NULL;
            $password = NULL;
            $responseOnCreation = NULL;
            $logged_email = NULL;
            $logged_pwd = NULL;
            $employeeLoginForm = new EmployeeLoginModelForm();
            $employeeRegForm = new EmployeeRegModelForm();
            $data['employeeLoginModelForm'] = $employeeLoginForm;
            $data['employeeRegModelForm'] = $employeeRegForm;

            //Get All Genders Start
            $genderRes = ServiceFactory::getAllActiveGendersList()->getGendersList();
            if (isset($genderRes) && count($genderRes) > 0) {
                $genderArr = $genderRes;
            }
            $data['gendersList'] = $genderArr;
            //Get All Genders End
            //Get All Designations Start
            $designationRes = ServiceFactory::getAllActiveDesignatinosList()->getDesignationsList();

            if (isset($designationRes) && count($designationRes) > 0) {
                $designationArr = $designationRes;
            }
            $data['designationsList'] = $designationArr;
            //Get All Designations End
            //Get All Country List Start
            $countryRes = ServiceFactory::getAllActiveCountriesList()->getCountriesList();
            if (isset($countryRes) && count($countryRes) > 0) {
                $countryArr = $countryRes;
            }
            $data['countriesList'] = $countryArr;

            //Get All Country List End
            //Login Form Business Logic Section Start
            if (isset($_POST['EmployeeLoginModelForm'])) {
                $loginErrors = CActiveForm::validate($employeeLoginForm);
                if ("[]" != $loginErrors) {
                    
                } else {
                    $logged_email = isset($employeeLoginForm->techo2_Emp_Username) ? $employeeLoginForm->techo2_Emp_Username : NULL;
                    $logged_pwd = isset($employeeLoginForm->techo2_Emp_Password) ? $employeeLoginForm->techo2_Emp_Password : NULL;
                    $logged_pwd = md5($logged_pwd);

                    $loggedInAccArr = ServiceFactory::validateLogin()->verifyLogin($logged_email, $logged_pwd);
                    if (isset($loggedInAccArr) && count($loggedInAccArr) > 0) {
                        $this->actionSetLoginDetails($loggedInAccArr);
                        $this->redirect(array('Techo2Employee/Dashboard'));
                    } else {
                        Yii::app()->user->setFlash('loginFail', Yii::t('ErrorMessages', 'loginFail'));
                        $this->redirect(array('Techo2Employee/EmployeeRegNLogin'));
                    }
                }
            }
            //Login Form Business Logic Section End
            //Registration Form Business Logic Section Start
            if (isset($_POST['EmployeeRegModelForm'])) {
                $regErrors = CActiveForm::validate($employeeRegForm);
                if ("[]" != $regErrors) {
                    
                } else {
                    $responseOnCreation = ServiceFactory::joinToTecho2Family()->createNewTecho2Employee($employeeRegForm);
                    if ($responseOnCreation > 0) {
                        Yii::app()->user->setFlash('registrationSuccess', Yii::t('SuccessMessages', 'registrationSuccess'));
                        $this->redirect(array('Techo2Employee/EmployeeRegNLogin'));
                    } else {
                        Yii::app()->user->setFlash('registrationFail', Yii::t('ErrorMessages', 'registrationFail'));
                        $this->redirect(array('Techo2Employee/EmployeeRegNLogin'));
                    }
                }
            }
            //Registration Form Business Logic Section End

            $this->render('/Employee/home', $data);
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionEmployeeRegNLogin::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

             /* 
 * Author      : Meda Vinod Kumar
 * Date        : 04-Sep-2015
 * Method      : GetStateList
 * Function    : Get all active states list 
 * Params      : Country Id 
 */
    public function actionGetStateList() {
        try {


            $country_id = 0;
            $stateRes = array();
            $stateArr = array();
            $selectState = Yii::t('LabelMessages', 'selectState');
            if (isset($_POST['techo2_Emp_Country'])) {
                $country_id = $_POST['techo2_Emp_Country'];
            }
            if ($country_id > 0) {
                $stateRes = ServiceFactory:: getAllActiveStatesList()->getStatesList($country_id);
                echo CHtml::tag('option', array('value' => '-1'), CHtml::encode($selectState), TRUE);
                foreach ($stateRes as $sr) {
                    echo CHtml::tag('option', array('value' => $sr['state_id']), CHtml::encode($sr['state_name']), TRUE);
                }
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionGetStateList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

            /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : SetLoginDetails
 * Function    : Set session data
 */
    public function actionSetLoginDetails($loggedInAccData) {
        try {


            $session = Yii::app()->session;
            $session['employee_data'] = [
                'employee_id' => $loggedInAccData['employee_id'],
                'employee_name' => $loggedInAccData['fullname'],
                'employee_designation_id' => $loggedInAccData['designation_id'],
                'employee_designation' => $loggedInAccData['designation_name'],
            ];
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionSetLoginDetails::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

           /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : Dashboard
 * Function    : Redirect to dashboard [ logged in employee ] 
 */
    public function actionDashboard() {
        try {


            $session = array();
            $session = Yii::app()->session['employee_data'];
            if (0 == count($session)) {
                $this->redirect(array('Techo2Employee/LoggedOut'));
            } else if (isset($session) && count($session) > 0) {
                $data = array();
                $data['pageTitle'] = Yii::t('PageTitles', 'dashboard');
                //$logged_in_profile_arr = array();
                $all_employee_profiles = array();
                $designation_id = 0;
                $employee_id = 0;
                $designation_id = isset($session['employee_designation_id']) ? $session['employee_designation_id'] : $designation_id;
                $employee_id = isset($session['employee_id']) ? $session['employee_id'] : $employee_id;
                $data['employee_id'] = $employee_id;
                //If he is Managing Director
                if (isset($designation_id) && 1 == $designation_id) {
                    $all_employee_profiles = $this->actionGetAllEmpData();
                    if (isset($all_employee_profiles) && count($all_employee_profiles) > 0) {
                        $data['all_employee_profiles'] = $all_employee_profiles;
                    }
                }
                $this->render('/Dashboard/home', $data);
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionDashboard::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

          /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : EmployeeProfile
 * Function    : Get Logged In  Employee Basic Details [  Profile ]
 */
    public function actionEmployeeProfile() {
        try {


            $data = array();
            $data['pageTitle'] = Yii::t('PageTitles', 'employeeProfile');
            $employee_id = 0;
            if (NULL == $_GET['employee_id'] || $_GET['employee_id'] <= 0) {
                $this->redirect(array('Techo2Employee/LoggedOut'));
            } else {
                $employee_id = $_GET['employee_id'];
                $logged_in_profile_arr = array();
                $logged_in_profile_arr = ServiceFactory::dashboardServiceProvider()->loggedInEmpData($employee_id);
                if (isset($logged_in_profile_arr) && count($logged_in_profile_arr) > 0) {
                    $data['logged_in_emp_data'] = $logged_in_profile_arr;
                }
                $this->render('/Dashboard/home', $data);
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionEmployeeProfile::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    
         /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : EditEmployeeProfile
 * Function    : Edit Employee Details Or Profile Data
 */
    public function actionEditEmployeeProfile() {
        try {


            $employee_id = 0;
            if (NULL == $_GET['employee_id'] || $_GET['employee_id'] <= 0) {
                $this->redirect(array('Techo2Employee/LoggedOut'));
            } else {

                $data = array();
                $data['pageTitle'] = Yii::t('PageTitles', 'editProfile');
                $editEmployeeProfileVal = new EditEmployeeProfileForm();
                $data['editEmpProfile'] = $editEmployeeProfileVal;
                $employee_id = $_GET['employee_id'];
                $employeeProfileDet = array();
                $profileUpdateErrors = array();
                $genderRes = array();
                $genderArr = array();
                $designationRes = array();
                $designationArr = array();
                $countryRes = array();
                $countryArr = array();
                $stateRes = array();
                $stateArr = array();
                $country_id = -1;
                $state_id = -1;
                $res_on_unique_email_phone = array();
                //Get All Genders Start
                $employeeProfileDet = ServiceFactory::dashboardServiceProvider()->getEmpProfileDet($employee_id);
                if (isset($employeeProfileDet) && count($employeeProfileDet) > 0) {
                    $data['profileData'] = $employeeProfileDet;
                }

                //Designation Id
                $designation_id = isset($employeeProfileDet['designation_id']) ? $employeeProfileDet['designation_id'] : '0';
                $editEmployeeProfileVal->techo2_Emp_Designation = $designation_id;

                //Gender Id
                $gender_type = isset($employeeProfileDet['gender_type']) ? $employeeProfileDet['gender_type'] : '-1';
                $editEmployeeProfileVal->techo2_Emp_Gender = $gender_type;

                //CountryId
                $country_id = isset($employeeProfileDet['employee_country']) ? $employeeProfileDet['employee_country'] : $country_id;
                $editEmployeeProfileVal->techo2_Emp_Country = $country_id;

                //StateId
                $state_id = isset($employeeProfileDet['employee_state']) ? $employeeProfileDet['employee_state'] : $state_id;
                $editEmployeeProfileVal->techo2_Emp_State = $state_id;

                //Date Of Birth
                $date_of_birth = isset($employeeProfileDet['employee_dob']) ? $employeeProfileDet['employee_dob'] : NULL;
                $editEmployeeProfileVal->techo2_Emp_Dob = $date_of_birth;
                
                //Get All Genders Start
                $genderRes = ServiceFactory::getAllActiveGendersList()->getGendersList();
                if (isset($genderRes) && count($genderRes) > 0) {
                    $genderArr = $genderRes;
                }
                $data['gendersList'] = $genderArr;
                //Get All Genders End
                //Get All Designations Start
                $designationRes = ServiceFactory::getAllActiveDesignatinosList()->getDesignationsList();

                if (isset($designationRes) && count($designationRes) > 0) {
                    $designationArr = $designationRes;
                }
                $data['designationsList'] = $designationArr;
                //Get All Designations End
                //Get All Country List Start
                $countryRes = ServiceFactory::getAllActiveCountriesList()->getCountriesList();
                if (isset($countryRes) && count($countryRes) > 0) {
                    $countryArr = $countryRes;
                }
                $data['countriesList'] = $countryArr;
                //Get All Country List End
                //Get All State List Start
                $stateRes = ServiceFactory:: getAllActiveStatesList()->getStatesList($country_id);
                if (isset($stateRes) && count($stateRes) > 0) {
                    $stateArr = $stateRes;
                }
                $data['statesList'] = $stateArr;



                //Get All State List End
                if (isset($_POST['EditEmployeeProfileForm'])) {

                    $profileUpdateErrors = CActiveForm::validate($editEmployeeProfileVal);
                    if ("[]" != $profileUpdateErrors) {
                        
                    } else {
                        $hidden_emp_email = isset($_POST['hidden_email']) ? $_POST['hidden_email'] : NULL;
                        $hidden_emp_phone = isset($_POST['hidden_phone']) ? $_POST['hidden_phone'] : NULL;

                        $employee_post_email = isset($editEmployeeProfileVal->techo2_Emp_Email) ? $editEmployeeProfileVal->techo2_Emp_Email : NULL;

                        $employee_post_phone = isset($editEmployeeProfileVal->techo2_Emp_Phone) ? $editEmployeeProfileVal->techo2_Emp_Phone : NULL;


                        $res_on_unique_email_phone = $this->chkForUnique($employee_post_email, $employee_post_phone, $hidden_emp_email, $hidden_emp_phone);

                        $res_on_empemail_comp = strcmp($hidden_emp_email, $employee_post_email);
                        $res_on_empphone_comp = strcmp($hidden_emp_phone, $employee_post_phone);

                        if (isset($res_on_unique_email_phone) && count($res_on_unique_email_phone) > 0) {
                            Yii::app()->user->setFlash('invalidEmail', $res_on_unique_email_phone['invalidEmail']);
                            Yii::app()->user->setFlash('invalidPhone', $res_on_unique_email_phone['invalidPhone']);
                            $this->redirect(array('Techo2Employee/EditEmployeeProfile', 'employee_id' => $employee_id));
                        }

                        $first_name = NULL;
                        $hidden_first_name = NULL;
                        $firstname_res = array();

                        $middle_name = NULL;
                        $hidden_middle_name = NULL;
                        $middlename_res = array();

                        $last_name = NULL;
                        $hidden_last_name = NULL;
                        $lastname_res = array();

                        $address = NULL;
                        $hidden_address = NULL;
                        $address_res = array();

                        $designation = NULL;
                        $hidden_designation = NULL;
                        $designation_res = NULL;

                        $emp_gender_type = NULL;
                        $hidden_gender_type = NULL;
                        $gender_res = NULL;

                        $emp_state = -1;
                        $hidden_emp_state = -1;
                        $state_res = NULL;

                        $emp_dob = NULL;
                        $hidden_emp_dob = NULL;
                        $res_on_dob = NULL;

                        $updated_employee_arr = array();
                        $updated_address_arr = array();
                        $updated_employee_email_arr = array();
                        $updated_employee_phone_arr = array();

                        $res_on_employee = 0;
                        $res_on_address = 0;
                        $res_on_email = NULL;
                        $res_on_phone = NULL;
                        $sign = 0;




                        //Firstname
                        $first_name = isset($editEmployeeProfileVal->techo2_Emp_Firstname) ? $editEmployeeProfileVal->techo2_Emp_Firstname : $first_name;
                        $hidden_first_name = isset($_POST['hidden_first_name']) ? $_POST['hidden_first_name'] : $hidden_first_name;
                        $firstname_res = strcmp($first_name, $hidden_first_name);
                        if (0 != $firstname_res) {
                            $updated_employee_arr = array_merge($updated_employee_arr, array('employee_firstname' => $first_name));
                        }


                        //Middlename
                        $middle_name = isset($editEmployeeProfileVal->techo2_Emp_Middlename) ? $editEmployeeProfileVal->techo2_Emp_Middlename : $middle_name;
                        $hidden_middle_name = isset($_POST['hidden_middle_name']) ? $_POST['hidden_middle_name'] : $hidden_middle_name;
                        $middlename_res = strcmp($middle_name, $hidden_middle_name);
                        if (0 != $middlename_res) {
                            $updated_employee_arr = array_merge($updated_employee_arr, array('employee_middlename' => $middle_name));
                        }

                        //Lastname
                        $last_name = isset($editEmployeeProfileVal->techo2_Emp_Lastname) ? $editEmployeeProfileVal->techo2_Emp_Lastname : $last_name;
                        $hidden_last_name = isset($_POST['hidden_last_name']) ? $_POST['hidden_last_name'] : $hidden_last_name;
                        $lastname_res = strcmp($last_name, $hidden_last_name);
                        if (0 != $lastname_res) {
                            $updated_employee_arr = array_merge($updated_employee_arr, array('employee_lastname' => $last_name));
                        }

                        //Designation
                        $designation = isset($editEmployeeProfileVal->techo2_Emp_Designation) ? $editEmployeeProfileVal->techo2_Emp_Designation : $designation;
                        $hidden_designation = isset($_POST['hidden_designation']) ? $_POST['hidden_designation'] : $hidden_designation;
                        $designation_res = strcmp($designation, $hidden_designation);

                        if (0 != $designation_res) {
                            $updated_employee_arr = array_merge($updated_employee_arr, array('designation_iddesignation' => $designation));
                        }

                        //Gender
                        $emp_gender_type = isset($editEmployeeProfileVal->techo2_Emp_Gender) ? $editEmployeeProfileVal->techo2_Emp_Gender : $gender_type;
                        $hidden_gender_type = isset($_POST['hidden_gender']) ? $_POST['hidden_gender'] : $hidden_gender_type;
                        $gender_res = strcmp($emp_gender_type, $hidden_gender_type);
                        if (0 != $gender_res) {
                            $updated_employee_arr = array_merge($updated_employee_arr, array('employee_gender' => $emp_gender_type));
                        }


                        //Date Of Birth
                        $emp_dob = isset($editEmployeeProfileVal->techo2_Emp_Dob) ? $editEmployeeProfileVal->techo2_Emp_Dob : $emp_dob;
                        $hidden_emp_dob = isset($_POST['hidden_dob']) ? $_POST['hidden_dob'] : $hidden_emp_dob;
                        $res_on_dob = strcmp($emp_dob, $hidden_emp_dob);
                        if (0 != $res_on_dob) {
                            $updated_employee_arr = array_merge($updated_employee_arr, array('employee_dob' => $emp_dob));
                        }


                        //Email Address
                        if (isset($employee_post_email) && !empty($employee_post_email)) {
                            $updated_employee_email_arr = array_merge($updated_employee_email_arr, array('email' => $employee_post_email));
                        }


                        //Contact Number
                        if (isset($employee_post_phone) && !empty($employee_post_phone)) {
                            $updated_employee_phone_arr = array_merge($updated_employee_phone_arr, array('phonenumber' => $employee_post_phone));
                        }


                        //Address
                        $address = isset($editEmployeeProfileVal->techo2_Emp_Address) ? $editEmployeeProfileVal->techo2_Emp_Address : $address;
                        $hidden_address = isset($_POST['hidden_address']) ? $_POST['hidden_address'] : $hidden_address;
                        $address_res = strcmp($address, $hidden_address);
                        if (0 != $lastname_res) {
                            $updated_address_arr = array_merge($updated_address_arr, array('address' => $address));
                        }

                        //State
                        $emp_state = isset($editEmployeeProfileVal->techo2_Emp_State) ? $editEmployeeProfileVal->techo2_Emp_State : $emp_state;
                        $hidden_emp_state = isset($_POST['hidden_state']) ? $_POST['hidden_state'] : $hidden_emp_state;
                        $state_res = strcmp($emp_state, $hidden_emp_state);
                        if (0 != $state_res) {
                            $updated_address_arr = array_merge($updated_address_arr, array('state_idstate' => $emp_state));
                        }


                        //Employee Table Update Section
                        if (isset($updated_employee_arr) && count($updated_employee_arr) > 0) {
                            $res_on_employee = ServiceFactory::dashboardServiceProvider()->updateEmployeeBasicDet($updated_employee_arr, $employee_id);
                            $sign = $sign + 1;
                        }

                        //Address Table Update Section
                        if (isset($updated_address_arr) && count($updated_address_arr) > 0) {
                            $res_on_address = ServiceFactory::dashboardServiceProvider()->updateEmployeeAddressDet($updated_address_arr, $employee_id);
                            $sign = $sign + 1;
                        }



                        //Employee Email Table Update Section
                        if (isset($updated_employee_email_arr) && count($updated_employee_email_arr) > 0 && 0 != $res_on_empemail_comp) {

                            $res_on_email = ServiceFactory::dashboardServiceProvider()->updateEmployeeEmailDet($updated_employee_email_arr, $employee_id);
                            $sign = $sign + 1;
                        }

                        //Emplooyee Phone Table Update Section
                        if (isset($updated_employee_phone_arr) && count($updated_employee_phone_arr) > 0 && 0 != $res_on_empphone_comp) {
                            $res_on_phone = ServiceFactory::dashboardServiceProvider()->updateEmployeePhoneDet($updated_employee_phone_arr, $employee_id);

                            $sign = $sign + 1;
                        }



                        if (1 == $res_on_employee || 1 == $res_on_address || 1 == $res_on_email || 1 == $res_on_phone) {
                            Yii::app()->user->setFlash('updateSuccess', Yii::t('SuccessMessages', 'updateSuccess'));
                            $this->redirect(array('Techo2Employee/EditEmployeeProfile', 'employee_id' => $employee_id));
                        } else if (0 == $sign) {
                            Yii::app()->user->setFlash('noChange', Yii::t('InfoMessages', 'noChange'));
                            $this->redirect(array('Techo2Employee/EditEmployeeProfile', 'employee_id' => $employee_id));
                        } else {
                            Yii::app()->user->setFlash('Oops', Yii::t('ErrorMessages', 'Oops'));
                            $this->redirect(array('Techo2Employee/EditEmployeeProfile', 'employee_id' => $employee_id));
                        }
                    }
                }

                $this->render('/Dashboard/EditEmployeeProfile', $data);
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionEditEmployeeProfile::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

         /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : GetAllEmpData
 * Function    : Get all employee data
 */
    public function actionGetAllEmpData() {
        try {


            $all_employee_profiles = array();
            $all_profiles_response = array();
            $all_profiles_response = ServiceFactory::dashboardServiceProvider()->getAllEmpData();
            if (isset($all_profiles_response) && count($all_profiles_response) > 0) {
                $all_employee_profiles = $all_profiles_response;
            }
            return $all_employee_profiles;
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionGetAllEmpData::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

        /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : LoggedOut
 * Function    : Destory all the session data
 */
    public function actionLoggedOut() {
        try {

            Yii::app()->session->destroy();
            $this->redirect(array('Techo2Employee/EmployeeRegNLogin'));
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionLoggedOut::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

       /* 
 * Author      : Meda Vinod Kumar
 * Date        : 07-Sep-2015
 * Method      : chkForUnique
 * Function    : Check email address and phone number to maintain unique details
 * Params      : email address, phone number, hidden email address, hidden phone number
 */
    public function chkForUnique($emp_email, $emp_phone, $hid_email, $hid_phone) {
        try {
            $employee_email = isset($emp_email) ? $emp_email : NULL;
            $employee_phone = isset($emp_phone) ? $emp_phone : NULL;

            $hidden_email = isset($hid_email) ? $hid_email : NULL;
            $hidden_phone = isset($hid_phone) ? $hid_phone : NULL;

            $res_on_email_comp = NULL;
            $res_on_phone_comp = NULL;

            $email_response = array();
            $phone_response = array();

            $response = array();


            /* Validating Email Address Section Start */
            $res_on_email_comp = strcmp($employee_email, $hidden_email);

            if (0 != $res_on_email_comp) {
                $email_response = ServiceFactory::checkIsEmailExist()->isEmailAddressExist($employee_email);
                if (isset($email_response) && count($email_response) > 0) {
                    $response['invalidEmail'] = "$employee_email already exists. Please try with another one.";
                }
            }

            /* Validating Email Address Section End */

            /* Validating Mobile Number Section Start */
            $res_on_phone_comp = strcmp($employee_phone, $hidden_phone);
            if (0 != $res_on_phone_comp) {
                $phone_response = ServiceFactory::checkIsMobileNoExist()->isMobileNumberExist($employee_phone);
                if (isset($phone_response) && count($phone_response) > 0) {
                    //$response['invalidPhone'] = "$employee_phone already exists. Please try with another one.";
                    $response['invalidPhone'] = "$employee_phone already exists. Please try with another one.";
                }
            }


            /* Validating Email Address Section End */
            return $response;
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:chkForUnique::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author   : Meda Vinod Kumar 
     * Date     : 08-09-2015
     * Method   : ViewEmployeeDetails
     * Function : Show all employee details in popup
     * Params   : Employee Id
     *      
     */
    public function actionViewEmployeeDetails(){
        echo "hhhhhhhhhhhhhhhhhhhhh";
    }
}

?>