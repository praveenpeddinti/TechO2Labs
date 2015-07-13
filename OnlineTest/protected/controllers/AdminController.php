<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminController extends Controller{
    
    public function init() {
        try {
            parent::init();
            if (isset(Yii::app()->session['TinyUserCollectionObj'])) {
                $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
                if (Yii::app()->session['IsAdmin'] == '1') {
                    $this->layout="adminLayout";
                    //$this->redirect('/');
                } else {
                    $this->redirect('/site');
                }
            } else {
                $this->redirect('/');
            }
            CommonUtility::registerClientScript('simplePagination/', 'jquery.simplePagination.js');
            CommonUtility::registerClientScript('adminOperations.js');
            CommonUtility::registerClientCss();
        } catch (Exception $ex) {
            Yii::log("AdminController:init::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex(){
        
    }
    
    /**
     * ActionUserManagement: 
     * called for the time and get with Users Object and then render to a view.
     */
    // first time it will called...
    public function actionUsermanagement(){
        try{      
            // Initializing variables with default values...
            if(Yii::app()->session['IsAdmin']=='1'){
               $result = array();
            $filterValue = "all";
            $searchText = "";
            $startLimit = 0;
            $pageLength = 10;
    
            // calling a service method using a service object...
            $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfile($filterValue,$searchText,$startLimit, $pageLength);
            $totalUsers["totalCount"] = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileCount($filterValue,$searchText);
            //$userTypes=ServiceFactory::getSkiptaUserServiceInstance()->getRoles();
            // preparing the resultant array for rendering purpose...
            $result = array("data" => $data, "total" => $totalUsers, "status" => 'success');              
            }else{
                 $this->redirect('/');
            }
        } catch (Exception $ex) {
            Yii::log("AdminController:actionUsermanagement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        $this->render('usermanagement',array("data"=>json_encode($result)));
    }
    /*
     * actionGetUserManagementDetails is similar as actionUsermanagement but here this is for ajax calls. 
     */
    // used for ajaxcalls...
    public function actionGetUserManagementDetails() {
        try {     error_log("---data--88");          
            // Initializing variables with default values...
            $result = array();
            $filterValue = $_REQUEST['filterValue'];
            $searchText = $_REQUEST['searchText'];
            $startLimit = $_REQUEST['startLimit'];
            $pageLength = $_REQUEST['pageLength'];

            $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfile($filterValue,$searchText,$startLimit, $pageLength);
           
            $totalUsers["totalCount"] = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileCount($filterValue,$searchText);
            //$userTypes=ServiceFactory::getSkiptaUserServiceInstance()->getRoles();
        //    $userIndentityType=$this->tinyObject->UserIdentityType;;

            // preparing the resultant array for rendering purpose...
            
            $result = array("data" => $data, "total" => $totalUsers, "status" => 'success',"searchText"=>$searchText, 'userTypes'=>'');
            
            echo json_encode($result);
        } catch (Exception $ex) {
            Yii::log("AdminController:actionGetUserManagementDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * actionViewAUserDetailsById: 
     * requesting for the user details.
     */
    public function actionViewAUserDetailsById(){
        try{
            $userid = $_REQUEST['userId'];
            $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userid);
            $tinyUserCollectionData = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userid);
            //$attributeArray = array("SegmentId" => (int)$tinyUserCollectionData->SegmentId);
            //$segmentObj = ServiceFactory::getSkiptaUserServiceInstance()->getSegmentByAttributes($attributeArray);
            $result = array("data" => $data, "tinyUserCollectionData" => $tinyUserCollectionData, "status" => 'success');             
        } catch (Exception $ex) {
            Yii::log("AdminController:actionViewAUserDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        echo CJSON::encode($result);
    }
    
    
  /*
     * @Praveen edit user functionality start Here
     */
    public function actionEditUserDetailsById() {
        try {
            $userId = $_REQUEST['userId'];
            $takerForm = new TestTakerForm();
            $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userId);
            
            $this->renderPartial('editUser', array('takerForm' => $takerForm,'data'=>$data));
        } catch (Exception $ex) {
            error_log("Exception Occurred in AdminController->actionEditUserDetailsById==". $ex->getMessage());
            Yii::log("AdminController:actionEditUserDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    

    
    public function actionEditUserForId() {
        $testTakerForm = new TestTakerForm();
        if (isset($_POST['TestTakerForm'])) {
            $testTakerForm->attributes = $_POST['TestTakerForm'];
            $errors = CActiveForm::validate($testTakerForm);
            if ($errors != '[]') {
                $obj = array('status' => 'error', 'data' => '', 'error' => $errors, "emailError" => $common);
            } else {
                $updatedDetails = ServiceFactory::getSkiptaUserServiceInstance()->editUserDetailsForUserMgmnt($_REQUEST['eId'],$testTakerForm);
                $obj = array('status' => $updatedDetails, 'data' => '', 'error' => ""); 
                    //$Save_userInUserCollection = ServiceFactory::getSkiptaUserServiceInstance()->UpdateUserCollection($UserSettingsForm,$oldUserObj);
                
            }
            echo CJSON::encode($obj);
        }
    }
    //

}