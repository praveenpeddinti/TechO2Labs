<?php

class AdminController extends Controller {

    public function actionCreateCategories() {
        try {
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

                    //Cateogry Name
                    if (isset($categoryValidations->category_name) && !empty($categoryValidations->category_name)) {
                        $category_name = $categoryValidations->category_name;
                    }

                    //Category Status
                    if (isset($categoryValidations->category_status) && $categoryValidations->category_status > 0) {
                        $category_status = $categoryValidations->category_status;
                    }

                    $add_category_values = array(
                        'category_name' => $category_name,
                        'category_status' => $category_status,
                    );

                    if (isset($add_category_values) && count($add_category_values) > 0) {
                        $add_category_values = array_merge($add_category_values, array(
                            'category_createddate' => date('Y-m-d H:i:s'),
                            'category_created_by' => 1,
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

}

?>