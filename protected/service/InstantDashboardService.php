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

    /*
     * Author   : Renigunta Kavya 
     * Date     : 09-09-2015
     * Method   : getAllRatingData
     * Function : Get all the data of ratings      
     */

    public function getAllRatingData() {
        try {
            $response = array();
            $allRatingData = array();
            $allRatingData = DashboardModel::model()->getAllRatingData();
            if (isset($allRatingData) && count($allRatingData) > 0) {
                $response = $allRatingData;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:getAllRatingData::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author   : Renigunta Kavya 
     * Date     : 09-09-2015
     * Method   : specificUserRating
     * Function : Get the data of select row of ratings    
     */

    public function specificUserRating($emp_id) {
        try {
            $response = array();
            $ratingData = array();
            $employee_id = 0;
            if (isset($emp_id) && !empty($emp_id) && $emp_id > 0) {
                $employee_id = $emp_id;
            }
            if ($employee_id > 0) {
                $ratingData = DashboardModel::model()->specificUserRating($employee_id);
                if (isset($ratingData) && count($ratingData) > 0) {
                    $response = $ratingData;
                }
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:specificUserRating::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //[Need To Review]
    public function getAllUploadedImages($start_count, $limit) {
        try {
            $response = array();
            $all_images_data = array();
            $all_images_data = DashboardModel::model()->getAllImagesList($start_count, $limit);
            if (isset($all_images_data) && count($all_images_data) > 0) {
                $response = $all_images_data;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:getAllUploadedImages::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //[Need To Review]
    public function totalCounOnImages() {
        try {
            $response = array();
            $all_images_count = array();
            $all_images_count = DashboardModel::model()->totalCounOnImages();
            if (isset($all_images_count) && count($all_images_count) > 0) {
                $response = $all_images_count;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:totalCounOnImages::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //[Need To Review]
    public function addRating($updated_rating_on_image) {
        try {
            $response = 0;
            $response_rating = 0;
            if (isset($updated_rating_on_image) && count($updated_rating_on_image) > 0) {
                $response_rating = DashboardModel::model()->addRating($updated_rating_on_image);
                if ($response_rating > 0) {
                    $response = $response_rating;
                }
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:addRating::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Check Previous Rating Of User [ Need To Review ] 
    public function checkPreviousRating($imageId,$employee_id){
         try {
            $response = 0;
            $response_chk_rating = 0;
            if (isset($imageId) && $imageId > 0 && isset($employee_id) && $employee_id > 0) {
                $response_chk_rating = DashboardModel::model()->checkPreviousRating($imageId,$employee_id);
                if ($response_chk_rating > 0) {
                    $response = $response_chk_rating;
                }
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:checkPreviousRating::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    //Get Ratings On Images Of User [ Need To Review ] 
    public function getPersonRatingOnImages($employee_id){
         try {
            $response = array();
            $person_images_rate = array();
            if (isset($employee_id) && $employee_id > 0) {
                $person_images_rate = DashboardModel::model()->getPersonRatingOnImages($employee_id);
                if (isset($person_images_rate) && count($person_images_rate) > 0) {
                    $response = $person_images_rate;
                }
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:getPersonRatingOnImages::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    //Update Ratings On Image Of User[ Need To Review ] 
    public function updateRatingOnImageId($existed_employee_rating_id,$rate){
         try {
            $response = 0;
            $updated_image_rate_res = 0;
            if (isset($existed_employee_rating_id) && $existed_employee_rating_id > 0) {
                $updated_image_rate_res = DashboardModel::model()->updateRatingOnImageId($existed_employee_rating_id,$rate);
                if ($updated_image_rate_res >  0) {
                    $response = $updated_image_rate_res;
                }
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("InstantDashboardService:updateRatingOnImageId::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
}

?>