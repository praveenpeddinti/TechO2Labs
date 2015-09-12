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
                    ->select('te.employee_id,te.employee_firstname,te.employee_middlename,te.employee_lastname,te.employee_tag_code as employee_code,tee.email as employee_email,tep.phonenumber as employee_phone,te.employee_status,te.designation_iddesignation as designation_id,te.employee_gender as gender_type,te.employee_dob,tea.address as employee_address,tea.state_idstate as employee_state,ts.country_idcountry as  employee_country,tc.name as country_name,ts.name as state_name,ted.name as designation_name')
                    ->from('techo2_employee te')
                    ->join('techo2_employee_designation ted', 'ted.employee_designation_id = te.designation_iddesignation and ted.status =:status', array(':status' => $limit))
                    ->join('techo2_employee_email tee', 'tee.employee_idemployee = te.employee_id and tee.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->join('techo2_employee_phone tep', 'tep.employee_idemployee = te.employee_id and tep.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->join('techo2_employee_address tea', 'tea.employee_idemployee = te.employee_id and tea.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->join('techo2_state ts', 'ts.idstate = tea.state_idstate and ts.status=:status', array(':status' => $limit))
                    ->join('techo2_country tc', 'tc.idcountry = ts.country_idcountry and tc.status=:status', array(':status' => $limit))
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
     * Date        : 09-Sep-2015
     * Method      : updateRatingOnImageId
     * Function    : Update Rating On Image
     * Params      : employee_rating_id, rate
     * Return Type : It will return an integer resposne as 1.[ affected rows ]
     */

    public function updateRatingOnImageId($existed_employee_rating_id, $rate) {
        try {
            $response = 0;
            $update = 0;
            $update = Yii::app()->db->createCommand()
                    ->update('techo2_employee_rating', array('rating' => $rate), 'employee_rating_id=:employee_rating_id', array(':employee_rating_id' => $existed_employee_rating_id)
            );
            if ($update > 0) {
                $response = $update;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:updateRatingOnImageId::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author      : Meda Vinod Kumar
     * Date        : 07-Sep-2015
     * Method      : addRating
     * Function    : Add Rating On Image
     * Params      : Array [It contains rate,imageid,customer,status,createddate]
     * Return Type : It will return an integer resposne as 1.[ inserted rows ]
     */

    public function addRating($updated_rating_on_image) {
        try {

            $response = 0;
            $insert = 0;
            $insert = Yii::app()->db->createCommand()
                    ->insert('techo2_employee_rating', $updated_rating_on_image);
            if ($insert > 0) {
                $response = $insert;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:addRating::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author      : Meda Vinod Kumar
     * Date        : 07-Sep-2015
     * Method      : createNewCategory
     * Function    : Create new cateogry
     * Params      : Array [It contains category name,category status,category created date,category created by]
     * Return Type : It will return an integer resposne as 1.[ inserted rows ]
     */

    public function createNewCategory($new_category_det) {
        try {

            $response = 0;
            $insert = 0;
            $insert = Yii::app()->db->createCommand()
                    ->insert('techo2_categories', $new_category_det);
            if ($insert > 0) {
                $response = Yii::app()->db->getLastInsertId();
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:createNewCategory::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
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

    /*
     * Author      : Meda Vinod Kumar
     * Date        : 07-Sep-2015
     * Method      : suspendEmployee
     * Function    : Suspend employee 
     * Params      : Employee Id
     * Return Type : It will return an integer resposne as 1.[ affected rows ]
     */

    public function suspendEmployee($employee_id) {
        try {
            $response = 0;
            $update = 0;
            $update = Yii::app()->db->createCommand()
                    ->update('techo2_employee', array('employee_status' => 0), 'employee_id=:idemployee', array(':idemployee' => $employee_id)
            );
            if ($update > 0) {
                $response = 1;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:suspendEmployee::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function activateEmployee($employee_id) {
        try {
            $response = 0;
            $update = 0;
            $update = Yii::app()->db->createCommand()
                    ->update('techo2_employee', array('employee_status' => 1), 'employee_id=:idemployee', array(':idemployee' => $employee_id)
            );
            if ($update > 0) {
                $response = 1;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:activateEmployee::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author   : Renigunta Kavya 
     * Date     : 09-09-2015
     * Method   : getAllRatingData
     * Function : Get all the data of ratings  and employees    
     * Return type : array
    */
   
    public function getAllRatingData() {
        try {
            $response = array();
            $allRatingsData = array();
            $active = 1;
            $allRatingsData = Yii::app()->db->createCommand()
                    ->select('te.employee_id,concat(te.employee_firstname," ",te.employee_middlename," ",te.employee_lastname) as employee_name,te.employee_tag_code as employee_code,tee.email as employee_email,tep.phonenumber as employee_phone')
                    ->from('techo2_employee te')
                    ->join('techo2_employee_email tee', 'tee.employee_idemployee = te.employee_id and tee.isdefault=:isdefault', array(':isdefault' => $active))
                    ->join('techo2_employee_phone tep', 'tep.employee_idemployee = te.employee_id and tep.isdefault=:isdefault', array(':isdefault' => $active))
                    ->order(array('te.employee_id asc'))
                    ->queryAll();
            if (isset($allRatingsData) && count($allRatingsData) > 0) {
                $response = $allRatingsData;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:getAllRatingData::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author   : Renigunta Kavya 
     * Date     : 09-09-2015
     * Method   : specificUserRating
     * Function : Get the data of select row of ratings 
     * Return type : array [row] 
     */

    public function specificUserRating($employee_id) {
        try {
            $response = array();
            $employeeArr = array();
            $limit = 1;
            $employeeArr = Yii::app()->db->createCommand()
                    ->select('te.employee_id,concat(te.employee_firstname," ",te.employee_middlename," ",te.employee_lastname) as employee_name,te.employee_tag_code as employee_code,tee.email as employee_email,tep.phonenumber as employee_phone')
                    ->from('techo2_employee te')
                    ->join('techo2_employee_email tee', 'tee.employee_idemployee = te.employee_id and tee.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->join('techo2_employee_phone tep', 'tep.employee_idemployee = te.employee_id and tep.isdefault=:isdefault', array(':isdefault' => $limit))
                    ->where('te.employee_id=:idemployee and te.employee_status =:status', array(':idemployee' => $employee_id, ':status' => $limit))
                    ->limit($limit)
                    ->queryRow();
            if (isset($employeeArr) && is_array($employeeArr) && count($employeeArr) > 0) {
                $response = $employeeArr;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:specificUserRating::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author      : Meda Vinod Kumar
     * Date        : 09-Sep-2015
     * Method      : getAllImagesList
     * Function    : Get all images data
     * Return Type : It will return an array resposne
     */

    public function getAllImagesList($start_count, $limit) {
        try {

            $response = array();
            $all_images_list = array();
            $all_images_list = Yii::app()->db->createCommand()
                    ->select('tri.rating_images_id as image_id,tri.image_name')
                    ->from('techo2_rating_images tri')
                    ->limit($limit, $start_count)
                    ->queryAll();
            if (isset($all_images_list) && is_array($all_images_list) && count($all_images_list) > 0) {
                $response = $all_images_list;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:getAllImagesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author      : Meda Vinod Kumar
     * Date        : 09-Sep-2015
     * Method      : totalCounOnImages
     * Function    : We will get count on how many images we have uploaded
     * Return Type : It will return an array resposne [ It contains the count ]
     */

    public function totalCounOnImages() {
        try {

            $response = array();
            $count = array();
            $count = Yii::app()->db->createCommand()
                    ->select("count(*) as totalImages")
                    ->from("techo2_rating_images tri")
                    ->queryRow();
            if (isset($count) && is_array($count) && count($count) > 0) {
                $response = $count;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:totalCounOnImages::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author      : Meda Vinod Kumar
     * Date        : 09-Sep-2015
     * Method      : checkPreviousRating
     * Function    : Check is user contains rating on image
     * Return Type : It will return an array resposne [ It contains the count ]
     */

    public function checkPreviousRating($imageId, $employee_id) {
        try {

            $response = array();
            $count = array();
            $limit = 1;
            $count = Yii::app()->db->createCommand()
                    ->select("employee_rating_id")
                    ->from("techo2_employee_rating ter")
                    ->where('ter.ratingimage_idratingimage=:idimage and ter.employee_idemployee =:idemployee and ter.status =:status', array(':idimage' => $imageId, ':idemployee' => $employee_id, ':status' => $limit))
                    ->queryRow();
            if (isset($count) && is_array($count) && count($count) > 0) {
                $response = $count;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:checkPreviousRating::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author      : Meda Vinod Kumar
     * Date        : 09-Sep-2015
     * Method      : getPersonRatingOnImages
     * Function    : Get all previous rating on images of user
     * Return Type : It will return an array resposne
     */

    public function getPersonRatingOnImages($employee_id) {
        try {

            $response = array();
            $total_images_arr = array();
            $limit = 1;
            $total_images_arr = Yii::app()->db->createCommand()
                    ->select("employee_rating_id,rating,ratingimage_idratingimage as image_id,employee_idemployee as employee_id")
                    ->from("techo2_employee_rating ter")
                    ->where('ter.employee_idemployee =:idemployee and ter.status =:status', array(':idemployee' => $employee_id, ':status' => $limit))
                    ->queryAll();
            if (isset($total_images_arr) && count($total_images_arr) > 0) {
                $response = $total_images_arr;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:getPersonRatingOnImages::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
  
    /*
     * Author   : Renigunta Kavya 
     * Date     : 10-09-2015
     * Method   : getAllImagesRatings
     * Function : Get all the images with ratings
     * Return type : Array
     */
    public function getAllImagesRatings($employee_id){
        try {
            $response = array();
            $employeeArr = array();
            $employeeArr = Yii::app()->db->createCommand()
                    ->select('ter.rating as emp_rating,ter.ratingimage_idratingimage as rated_imageid,ter.employee_idemployee as emp_id,tri.image_name as rated_imagename')
                    ->where('ter.employee_idemployee=:idemployee',array(':idemployee' => $employee_id))
                    ->from('techo2_employee_rating ter')
                    ->join('techo2_rating_images tri', 'tri.rating_images_id = ter.ratingimage_idratingimage')
                    ->queryAll();
            if (isset($employeeArr) && is_array($employeeArr) && count($employeeArr) > 0) {
                $response = $employeeArr;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:getAllImagesRatings::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author      : Meda Vinod Kumar
     * Date        : 11-Sep-2015
     * Method      : getStatusList
     * Function    : Get all active status list
     * Return Type : It will return an array resposne
     */

    public function getStatusList() {
        try {

            $response = array();
            $all_status_list = array();
            $active = 1;
            $all_status_list = Yii::app()->db->createCommand()
                    ->select("ts.status_id,ts.status_name")
                    ->from("techo2_status ts")
                    ->where('ts.status_status =:status', array(':status' => $active))
                    ->queryAll();
            if (isset($all_status_list) && count($all_status_list) > 0) {
                $response = $all_status_list;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:getStatusList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
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
            if (isset($categoryList) && is_array($categoryList) && count($categoryList) > 0) {
                $response = $categoryList;
            }

            return $response;
        } catch (Exception $ex) {
            Yii::log("AuthenticationModel:getCategoriesList::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * Author      : Meda Vinod Kumar
     * Date        : 11-Sep-2015
     * Method      : chkCategoryName
     * Function    : To maintain unique category
     * Params      : Category name
     * Return Type : It will return integer response
     */
    public function chkCategoryName($category_name) {
        try {
            $response = 0;
            $count = array();
            $count = Yii::app()->db->createCommand()
                    ->select("tc.category_id")
                    ->from("techo2_categories tc")
                    ->where('tc.category_name=:categoryname', array(':categoryname' => $category_name))
                    ->queryRow();
            if (isset($count) && is_array($count) && count($count) > 0) {
                $response = 1;
            }
            return $response;
        } catch (Exception $ex) {
            Yii::log("DashboardModel:chkCategoryName::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

}

?>