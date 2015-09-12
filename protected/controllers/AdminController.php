<?php

class AdminController extends Controller {

//    public function __construct() {
//        parent::__construct();
//    }

    /*
     * Author   : Meda Vinod Kumar
     * Date     : 12-09-2015
     * Method   : CreateCategories
     * Function : Create new categories
     */
    public function actionCreateCategories() {
        try {
            $session = array();
            $session = Yii::app()->session['employee_data'];
            if (0 == count($session)) {
                $this->redirect(array('Techo2Employee/LoggedOut'));
            } else if (isset($session) && count($session) > 0) {
                $data = array();
                $data['pageTitle'] = Yii::t('PageTitles', 'category');
                $categoryErrors = array();
                $categoryValidations = new CategoryModelForm();
                $data['categoryValidatinos'] = $categoryValidations;

                //Status List Array Section Start
                $status_list = array();
                $status_list = ServiceFactory::dashboardServiceProvider()->getStatusList();
                if (isset($status_list) && count($status_list) > 0) {
                    $data['status_list'] = $status_list;
                }
                //Status List Array Section End

                if (isset($_POST['CategoryModelForm'])) {
                    $categoryErrors = CActiveForm::validate($categoryValidations);
                    if ("[]" != $categoryErrors) {
                        
                    } else {
                        $category_name = NULL;
                        $category_status = NULL;
                        $add_category_values = array();
                        $response_on_new_category = 0;
                        $logged_in_user_id = isset($session['employee_id']) ? $session['employee_id'] : '0';
                        //Cateogry Name
                        if (isset($categoryValidations->category_name) && !empty($categoryValidations->category_name)) {
                            $category_name = $categoryValidations->category_name;
                            $add_category_values = array_merge($add_category_values, array('category_name' => $category_name));
                        }

                        //Category Status
                        if (isset($categoryValidations->category_status) && $categoryValidations->category_status > 0) {
                            $category_status = $categoryValidations->category_status;
                            $add_category_values = array_merge($add_category_values, array('category_status' => $category_status));
                        }

                        if (isset($add_category_values) && count($add_category_values) > 0) {
                            $add_category_values = array_merge($add_category_values, array(
                                'category_createddate' => date('Y-m-d H:i:s'),
                                'category_created_by' => $logged_in_user_id,
                            ));
                            $response_on_new_category = ServiceFactory::dashboardServiceProvider()->createNewCategory($add_category_values);
                        }

                        if ($response_on_new_category > 0) {
                            Yii::app()->user->setFlash('categorySuccess', Yii::t('SuccessMessages', 'categorySuccess'));
                            $this->redirect(array('Admin/CreateCategories'));
                        } else {
                            Yii::app()->user->setFlash('categoryFail', Yii::t('ErrorMessages', 'categoryFail'));
                            $this->redirect(array('Admin/CreateCategories'));
                        }
                    }
                }
                $this->actionGetAllActiveCategories();
                $this->render('/Admin/CreateCategory', $data);
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionCreateCategories::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author   : Meda Vinod Kumar
     * Date     : 09-09-2015
     * Method   : GetAllActiveCategories
     * Function : Get all active categories
     */

    public function actionGetAllActiveCategories() {
        try {
            $session = array();
            $session = Yii::app()->session['employee_data'];
            if (0 == count($session)) {
                $this->redirect(array('Techo2Employee/LoggedOut'));
            } else if (isset($session) && count($session) > 0) {
                $data = array();
                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
                    unset($_GET['pageSize']);
                }

                $responseOnAllCategories = new AllActiveCategoriesModel('getAllActiveCategories');


                if (isset($_GET['getAllActiveCategories'])) {
                    $responseOnAllCategories->attributes = $_GET['getAllActiveCategories'];
                }

                if (isset($responseOnAllCategories) && count($responseOnAllCategories) > 0) {
                    $data = array(
                        'allActiveCategories' => $responseOnAllCategories,
                    );
                }

                if (!isset($_GET['ajax'])) {
                    $this->render('/Dashboard/viewAllActiveCategories', $data);
                } else {
                    $this->renderPartial('/Dashboard/viewAllActiveCategories', $data);
                }
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionGetAllActiveCategories::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author   : Meda Vinod Kumar
     * Date     : 12-09-2015
     * Method   : CreateStatus
     * Function : Create new status
     */
    public function actionCreateStatus() {
        try {
            $session = array();
            $session = Yii::app()->session['employee_data'];
            if (0 == count($session)) {
                $this->redirect(array('Techo2Employee/LoggedOut'));
            } else if (isset($session) && count($session) > 0) {
                $data = array();
                $statusErrors = array();
                $response_on_new_status = NULL;
                $validateStatusCreation = new CreateStatusForm();
                $data['validateStatusCreation'] = $validateStatusCreation;
                if (isset($_POST['CreateStatusForm'])) {
                    $statusErrors = CActiveForm::validate($validateStatusCreation);
                    if ("[]" != $statusErrors) {
                        
                    } else {
                        $logged_in_user_id = isset($session['employee_id']) ? $session['employee_id'] : '0';
                        $status_name = NULL;
                        $status_values_arr = array();
                        if (isset($validateStatusCreation->status_name) && !empty($validateStatusCreation->status_name)) {
                            $status_name = $validateStatusCreation->status_name;
                            $status_values_arr = array('status_name' => $status_name);
                        }

                        if (isset($status_values_arr) && count($status_values_arr) > 0) {
                            $status_values_arr = array_merge($status_values_arr, array('status_status' => 1, 'status_created_by' => $logged_in_user_id, 'status_createddate' => date('Y-m-d H:i:s')));
                            $response_on_new_status = ServiceFactory::dashboardServiceProvider()->createNewStatus($status_values_arr);
                            if ($response_on_new_status > 0) {
                                Yii::app()->user->setFlash('statusSuccess', Yii::t('SuccessMessages', 'statusSuccess'));
                                $this->redirect(array('Admin/CreateStatus'));
                            } else {
                                Yii::app()->user->setFlash('statusFail', Yii::t('ErrorMessages', 'statusFail'));
                                $this->redirect(array('Admin/CreateStatus'));
                            }
                        }
                    }
                }
                $this->actionGetAllStatuses();
                $this->render('/Admin/CreateStatus', $data);
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionCreateStatus::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /*
     * Author   : Meda Vinod Kumar
     * Date     : 09-09-2015
     * Method   : GetAllStatuses
     * Function : Get all statuses list
     */

    public function actionGetAllStatuses() {
        try {
            $session = array();
            $session = Yii::app()->session['employee_data'];
            if (0 == count($session)) {
                $this->redirect(array('Techo2Employee/LoggedOut'));
            } else if (isset($session) && count($session) > 0) {
                $data = array();
                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
                    unset($_GET['pageSize']);
                }

                $responseOnAllStatuses = new AllStatuses('getAllStatuses');


                if (isset($_GET['AllStatuses'])) {
                    $responseOnAllStatuses->attributes = $_GET['AllStatuses'];
                }

                if (isset($responseOnAllStatuses) && count($responseOnAllStatuses) > 0) {
                    $data = array(
                        'allStatuses' => $responseOnAllStatuses,
                    );
                }
                  
                if (!isset($_GET['ajax'])) {
                    $this->render('/Dashboard/viewAllStatuses', $data);
                } else {
                    $this->renderPartial('/Dashboard/viewAllStatuses', $data);
                }
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionGetAllStatuses::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    
  /*
     * Author   : Meda Vinod Kumar
     * Date     : 12-09-2015
     * Method   : CreateDesignation
     * Function : Create new designation
     */
    public function actionCreateDesignation(){
         try {
            $session = array();
            $session = Yii::app()->session['employee_data'];
            if (0 == count($session)) {
                $this->redirect(array('Techo2Employee/LoggedOut'));
            } else if (isset($session) && count($session) > 0) {
                $data = array();
                $roleErrors = array();
                $response_on_new_role = NULL;
                $validateRoleCreation = new CreateRoleForm();
                $data['validateRoleCreation'] = $validateRoleCreation;
                
                //Status List Array Section Start
                $status_list = array();
                $status_list = ServiceFactory::dashboardServiceProvider()->getStatusList();
                if (isset($status_list) && count($status_list) > 0) {
                    $data['status_list'] = $status_list;
                }
                //Status List Array Section End
                
                if (isset($_POST['CreateRoleForm'])) {
                    $roleErrors = CActiveForm::validate($validateRoleCreation);
                    if ("[]" != $roleErrors) {
                        
                    } else {
                        $logged_in_user_id = isset($session['employee_id']) ? $session['employee_id'] : '0';
                        $role_name = NULL;
                        $role_status = NULL;
                        $role_values_arr = array();
                        if (isset($validateRoleCreation->role_name) && !empty($validateRoleCreation->role_name)) {
                            $role_name = $validateRoleCreation->role_name;
                            $role_values_arr = array_merge($role_values_arr,array('name' => $role_name));
                        }
                        if (isset($validateRoleCreation->role_status) && !empty($validateRoleCreation->role_status)) {
                            $role_status = $validateRoleCreation->role_status;
                            $role_values_arr = array_merge($role_values_arr,array('status' => $role_status));
                        }

                        if (isset($role_values_arr) && count($role_values_arr) > 0) {
                            $role_values_arr = array_merge($role_values_arr, array('createdby' => $logged_in_user_id, 'createddate' => date('Y-m-d H:i:s')));
                            $response_on_new_role = ServiceFactory::dashboardServiceProvider()->createNewRole($role_values_arr);
                            if ($response_on_new_role > 0) {
                                Yii::app()->user->setFlash('roleSuccess', Yii::t('SuccessMessages', 'roleSuccess'));
                                $this->redirect(array('Admin/CreateDesignation'));
                            } else {
                                Yii::app()->user->setFlash('roleFail', Yii::t('ErrorMessages', 'roleFail'));
                                $this->redirect(array('Admin/CreateDesignation'));
                            }
                        }
                    }
                }
                
                $this->actionGetAllRoles();
                $this->render('/Admin/CreateDesignation', $data);
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionCreateDesignation::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /*
     * Author   : Meda Vinod Kumar
     * Date     : 12-09-2015
     * Method   : GetAllRoles
     * Function : Get all roles list
     */

    public function actionGetAllRoles() {
        try {
            $session = array();
            $session = Yii::app()->session['employee_data'];
            if (0 == count($session)) {
                $this->redirect(array('Techo2Employee/LoggedOut'));
            } else if (isset($session) && count($session) > 0) {
                $data = array();
                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
                    unset($_GET['pageSize']);
                }

                $responseOnAllRoles = new AllRoles('getAllRoles');


                if (isset($_GET['AllRoles'])) {
                    $responseOnAllRoles->attributes = $_GET['AllRoles'];
                }

                if (isset($responseOnAllRoles) && count($responseOnAllRoles) > 0) {
                    $data = array(
                        'allRoles' => $responseOnAllRoles,
                    );
                }
                  
                if (!isset($_GET['ajax'])) {
                    $this->render('/Dashboard/viewAllRoles', $data);
                } else {
                    $this->renderPartial('/Dashboard/viewAllRoles', $data);
                }
            }
        } catch (Exception $ex) {
            Yii::log("Techo2EmployeeController:actionGetAllRoles::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }


}

?>