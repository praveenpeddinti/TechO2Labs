<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ReportsController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function init() {
        try {
            $this->layout = "adminLayout";
            $this->pageTitle="TestPaper";
            if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
                parent::init();
                $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            } else {
                parent::init();
                $this->redirect('/');
            }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:init::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex() {
        try {
            //ExtendedSurveyCollection::model()->saveSurvey();
            if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
                if (Yii::app()->session['IsAdmin'] == 1) {
                    $urlArray = explode("/", Yii::app()->request->url);
                    
                    $TestPaperId = $urlArray[3];
                    
                    $TestPaperForm = new TestPaperForm();
                    $surveyGroupNames = ExSurveyResearchGroup::model()->getLinkGroups();
                   
                    //$TestPaperForm->Title = "test;;;;";
                    $this->render('index', array("TestPaperForm" => $TestPaperForm, "surveyGroupNames" => $surveyGroupNames, "TestPaperId" => $TestPaperId));
                } else {
                    $this->redirect('/');
                }
            } else {
                $this->redirect('/');
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in TestPaperController->actionIndex==" . $ex->getMessage());
            Yii::log("TestPaperController:actionIndex::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderQuestionWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $CategoryName = $_REQUEST['CategoryName'];
            $CategoryId = $_REQUEST['CategoryId'];
            $TestPaperId = $_REQUEST['TestId'];
            $Flag = $_REQUEST['Flag'];
            $TestPaperForm = new TestPaperForm();
            if(($Flag=='Edit') || ($Flag=='View')){
            $getTestPaperDetails = ServiceFactory::getSkiptaExSurveyServiceInstance()->getTestDetailsById('Id', $TestPaperId);
             for($i=0;$i<sizeof($getTestPaperDetails->Category);$i++){
                    if($_REQUEST['CategoryName']==$getTestPaperDetails->Category[$i]['CategoryName']) {  
                        $TestPaperForm->NoofQuestions = $getTestPaperDetails->Category[$i]['NoofQuestions'];
                        $TestPaperForm->CategoryTime = $getTestPaperDetails->Category[$i]['CategoryTime'];
                        $TestPaperForm->NoofPoints = $getTestPaperDetails->Category[$i]['CategoryScore'];
                        $TestPaperForm->ReviewQuestion = $getTestPaperDetails->Category[$i]['ReviewQuestion'];
                        $TestPaperForm->ScheduleId = $getTestPaperDetails->Category[$i]['ScheduleId'];
                        $TestPaperForm->CategoryId = $getTestPaperDetails->Category[$i]['CategoryId'];
                    }
                       
                    }   
            }
            $totalQuestionsObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getTotalQuestionsForCategory($_REQUEST['CategoryName']);
            $QuestionsCount=$totalQuestionsObj[0]->QuestionsCount;
            $SuspendedCount = ExtendedSurveyCollection::model()->getSuspendedQuestionsCount($totalQuestionsObj[0]->_id);
            $OtherCount = ExtendedSurveyCollection::model()->getOtherQuestionsCount($totalQuestionsObj[0]->_id);
            $total= $QuestionsCount-$SuspendedCount;
            $this->renderPartial('paperWidget', array("widgetCount" => $widCnt, "CategoryName" => $CategoryName, "CategoryId" => $CategoryId, "TestPaperForm" => $TestPaperForm,"QuestionsCount" => $QuestionsCount,"WithoutSupQuestions" => $total,"SuspendedQuestions" => $SuspendedCount,"OtherQuestions" => $OtherCount ,"TestPaperId" => $TestPaperId ,"Flag"=>$Flag));
        } catch (Exception $ex) {
            Yii::log("TestPaperController:actionRenderQuestionWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function actionValidateSurveyQuestion() {
        try{
        $TestPaperForm = new TestPaperForm();
        $UserId = $this->tinyObject->UserId;
        if (isset($_POST['TestPaperForm'])) {
            $TestPaperForm->attributes = $_POST['TestPaperForm'];


            $errors = CActiveForm::validate($TestPaperForm);
            if ($errors != '[]') {
                $obj = array('status' => 'error', 'data' => '', 'error' => $errors, 'oerror' => $common);
            } else { 
                $obj = array('status' => 'success', 'data' => '', 'error' => "");
            }
            //$obj = array('status' => 'success', 'data' => '', 'error' => "");
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionValidateSurveyQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionSurveyDashboard() {
        try {
            if (Yii::app()->session['IsAdmin'] == 1) {
                $this->render('dashboard');
            }else{
                $this->redirect('/');
            }
                
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionSurveyDashboard==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionSurveyDashboard::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function actionSaveSurveyQuestion() {
        try {
            $TestPaperForm = new TestPaperForm();
            $UserId = $this->tinyObject->UserId;
            if (isset($_POST['TestPaperForm'])) {
                $TestPaperForm->attributes = $_POST['TestPaperForm'];
                $TestPaperForm->Title = $_GET['Title'];
                $TestPaperForm->Description = $_GET['Description'];
                $TestPaperForm->QuestionsCount = $_GET['questionsCount'];
                $TestPaperForm->SurveyRelatedGroupName = $_GET['SurveyGroupName'];
                $Flag = $_REQUEST['Flag'];
                $TestPaperId = $_REQUEST['TestId'];
                $categories = explode(",",$_GET['SurveyGroupName']);                 
                $errors = array();
                $TestPaperForm->CreatedBy = $this->tinyObject->UserId;
                $checkTestPaper = ServiceFactory::getSkiptaExSurveyServiceInstance()->getTestDetailsById('Title', $TestPaperForm->Title);
                if(($Flag!='Edit') && (count($checkTestPaper)>0)){
                //if($checkTestPaper>0){
                    $obj = array("status" => "fail");
                }else{
                    $searcharray = array();
                    $f = json_decode($TestPaperForm->Questions);                
                    $questionArray = array();                
                    for ($i = 0; $i < sizeof($f); $i++) {
                        $searcharray = array();
                        parse_str($f[$i], $searcharray);
                        $TestPreparationBean = new TestPreparationBean();
                        $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('GroupName', $categories[$i]);
                        
                        $scheduleSurveyForm= new ScheduleSurveyForm();
                        $scheduleSurveyForm->StartDate = date("Y-m-d");
                        $scheduleSurveyForm->EndDate = date("Y-m-d");
                        $scheduleSurveyForm->SurveyId = $surveyObj->_id;
                        $scheduleSurveyForm->SurveyTitle = $surveyObj->SurveyTitle;
                        $scheduleSurveyForm->SurveyDescription = $surveyObj->SurveyDescription;
                        //$TestPreparationBean->CategoryId =  new MongoId($scheduleSurveyForm->SurveyId);
                        //$scheduleSurveyForm->SurveyRelatedGroupName = $surveyObj->SurveyRelatedGroupName;
                       
                        if($Flag != 'Edit'){
                            $result = ServiceFactory::getSkiptaExSurveyServiceInstance()->saveScheduleSurveydump($scheduleSurveyForm, $UserId);
                            $TestPreparationBean->ScheduleId = $result->_id;
                            $TestPreparationBean->CategoryId =  new MongoId($result->SurveyId);
                        }
                        

                        foreach ($searcharray["TestPaperForm"] as $key => $value) {

                               if ($key == "CategoryName") {
                                    $TestPreparationBean->CategoryName = $value;
                                }
                                if ($key == "NoofQuestions") {
                                    $TestPreparationBean->NoofQuestions = (int) $value;
                                }
                                if ($key == "CategoryTime") {
                                    $TestPreparationBean->CategoryTime = (int) $value;
                                }
                                if ($key == "NoofPoints") {
                                    $TestPreparationBean->CategoryScore = (int) $value;
                                }
                                if ($key == "ReviewQuestion") {
                                    $TestPreparationBean->ReviewQuestion = (int) $value;
                                }
                                if ($Flag == 'Edit' && $key == "ScheduleId") {
                                    $TestPreparationBean->ScheduleId = new MongoId($value);
                                }
                                if ($Flag == 'Edit' && $key == "CategoryId") {
                                    $TestPreparationBean->CategoryId =  new MongoId($value);
                                }
                                
                        }
                        array_push($questionArray, $TestPreparationBean);
                    }
                    $TestPaperForm->Questions = $questionArray;  
                    if($Flag!='Edit'){
                    $saveTest = ServiceFactory::getTO2TestPreparaService()->saveTestPrepair($TestPaperForm, $UserId);
                    }else{
                    $updateTest = ServiceFactory::getTO2TestPreparaService()->updateTestPrepair($TestPaperForm, $TestPaperId);
                    }
                    $obj = array("status" => "success");
                    
                }
                $renderScript = $this->rendering($obj);
                    echo $renderScript;
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionSaveSurveyQuestion==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionSaveSurveyQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /*
      * @Praveen Test paper Dashboard start
      */
     public function actionLoadSurveyWall() {
        try {
            if (isset($_GET['ExtendedSurveyBean_page']) && isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
                $streamIdArray = array();
                $userId = $this->tinyObject['UserId'];
                $pageSize = 6;                
                $isNotifiable = 1;
                if (Yii::app()->session['IsAdmin'] != 1) {
                    $isNotifiable = 0;
                }
                
                    //$condition = array(
                    //    'IsDeleted' => array('!=' => 1),
                    //);
                    $_GET['ExtendedSurveyCollection_page'] = $_GET['ExtendedSurveyBean_page'];
                    $provider = new EMongoDocumentDataProvider('TestPreparationCollection', array(
                        'pagination' => array('pageSize' => $pageSize),
                        'criteria' => array(
                           // 'conditions' => $condition,
                            'sort' => array('_id' => EMongoCriteria::SORT_DESC)
                        )
                    ));
                
                //$cc= ($_GET['ExtendedSurveyBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize));
                //error_log($pageSize."----".$cc."---ifffff---3---".print_r($provider->getData(),true));
                $preparedObject = array();
                $providerArray = array();
                if ($provider->getTotalItemCount() == 0) {
                    $preparedObject = 0; //No posts
                } else if ($_GET['ExtendedSurveyBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $preparedObject = (CommonUtility::prepareTestPaperDashboradData($provider->getData()));
                    
                } else {

                    $preparedObject = -1; //No more posts
                }           
                $this->renderPartial('dashboardWall', array('surveyObject' => $preparedObject));
            }else{
                $this->redirect("/");
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionLoadSurveyWall==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionLoadSurveyWall::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     
  /*
      * @Praveen Test paper Dashboard end
      */
    
    
    public function actionLoadTestTakers() {
        try {
            $result = array();
            $startDate = '';
            $endDate = '';
            $searchText = "";
            $startLimit = 0;
            $pageLength = 10;
            $surveyId = $_REQUEST['surveyId'];
            $getAllUsers = ServiceFactory::getSkiptaUserServiceInstance()->getInviteUserProfile($startDate,$endDate,$searchText,$startLimit, $pageLength);
            $totalUsers = ServiceFactory::getSkiptaUserServiceInstance()->getInviteUserProfileCount($startDate,$endDate,$searchText);
            $inviteForm = new InviteUserForm();
            $this->renderPartial('inviteUsers', array("data" => $getAllUsers, "total" => $totalUsers["totalCount"],'inviteForm' => $inviteForm,"surveyId" => $surveyId));
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionLoadSurveySchedule==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionLoadSurveySchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    } 
    
    public function actionGetInviteUsersDetails(){
        try{
            $result = array();
            $startDate = $_REQUEST['startDate'];
            $endDate = $_REQUEST['endDate'];
            $searchText = $_REQUEST['searchText'];
            $startLimit = $_REQUEST['startLimit'];
            $pageLength = $_REQUEST['pageLength'];
            //$MyUserIds = $_REQUEST['MyUserIds'];
            //error_log("-----MyUserIds===".$MyUserIds);
            $data = ServiceFactory::getSkiptaUserServiceInstance()->getInviteUserProfile($startDate,$endDate,$searchText,$startLimit, $pageLength);
            $totalUsers = ServiceFactory::getSkiptaUserServiceInstance()->getInviteUserProfileCount($startDate,$endDate,$searchText);
            $inviteForm1 = new InviteUserForm();
            $result = array("inviteForm1" => $inviteForm,"data" => $data, "total" => $totalUsers["totalCount"], "status" => 'success');    
            echo json_encode($result);
        } catch (Exception $ex) {
            error_log("Exception Occurred in TestPaperController->actionGetInviteUsersDetails==". $ex->getMessage());
            Yii::log("TestPaperController:actionGetInviteUsersDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function actionSaveInviteUsersDetails(){
        try{
            $result = array();
            $TestId = $_REQUEST['TestId'];
            $UserIds = $_REQUEST['UserIds'];
            $a =array();
            $af = split(',', $UserIds);
            
            for($i=0;$i<sizeof($af);$i++){
                
            $data = ServiceFactory::getSkiptaUserServiceInstance()->saveInviteUserForTest($TestId,$af[$i]);
            
            }//$saveInviteUserDetails = ServiceFactory::getSkiptaUserServiceInstance()->SaveInviteUserDetails($TestId,$af);
            $result=array("status" => 'success');   
            //$result = array("inviteForm1" => $inviteForm,"data" => $data, "total" => $totalUsers, "status" => 'success');    
            echo json_encode($result);
        } catch (Exception $ex) {
            error_log("Exception Occurred in TestPaperController->actionGetInviteUsersDetails==". $ex->getMessage());
            Yii::log("TestPaperController:actionGetInviteUsersDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}
