<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TestPaperController extends Controller {

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
                    $TestPaperForm = new TestPaperForm();
                    $surveyGroupNames = ExSurveyResearchGroup::model()->getLinkGroups();
                    $this->render('index', array("TestPaperForm" => $TestPaperForm, "surveyGroupNames" => $surveyGroupNames));
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
        try {error_log("enter testepaper=====".$_REQUEST['questionNo']);
            $widCnt = $_REQUEST['questionNo'];
            $CategoryName = $_REQUEST['CategoryName'];
            $CategoryId = $_REQUEST['CategoryId'];
            $TestPaperForm = new TestPaperForm();
            $totalQuestionsObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getTotalQuestionsForCategory($_REQUEST['CategoryName']);
            $QuestionsCount=$totalQuestionsObj[0]->QuestionsCount;
             error_log("-------1-----totalQuest----".$totalQuestionsObj[0]->_id);
            $SuspendedCount = ExtendedSurveyCollection::model()->getSuspendedQuestionsCount($totalQuestionsObj[0]->_id);
                error_log("2&&&&&&&&&&&&suspendcount".$SuspendedCount);
            $OtherCount = ExtendedSurveyCollection::model()->getOtherQuestionsCount($totalQuestionsObj[0]->_id);
                error_log("3&&&&&&&&&&&&othercount".$OtherCount);
                 
            error_log("-----4-------totalQuest----".$QuestionsCount);
            $total= $QuestionsCount-$SuspendedCount;
            $this->renderPartial('paperWidget', array("widgetCount" => $widCnt, "CategoryName" => $CategoryName, "CategoryId" => $CategoryId, "TestPaperForm" => $TestPaperForm,"QuestionsCount" => $QuestionsCount,"WithoutSupQuestions" => $total,"SuspendedQuestions" => $SuspendedCount,"OtherQuestions" => $OtherCount));
        } catch (Exception $ex) {
            Yii::log("TestPaperController:actionRenderQuestionWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function actionValidateSurveyQuestion() {error_log("-1--actionValidateSurveyQuestion");
        try{
        $TestPaperForm = new TestPaperForm();
        $UserId = $this->tinyObject->UserId;
        if (isset($_POST['TestPaperForm'])) {error_log("-2--actionValidateSurveyQuestion--".$_GET['SurveyGroupName']);
            $TestPaperForm->attributes = $_POST['TestPaperForm'];


            $errors = CActiveForm::validate($TestPaperForm);
            error_log("-----val------".print_r($errors,true));
            if ($errors != '[]') {
                error_log("---error----if----");
                $obj = array('status' => 'error', 'data' => '', 'error' => $errors, 'oerror' => $common);
            } else { error_log("---error----if----esfdf");
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
        try {error_log("---dfsdf-sdf--".$_GET['Description']);
            $TestPaperForm = new TestPaperForm();
            $UserId = $this->tinyObject->UserId;
            if (isset($_POST['TestPaperForm'])) {
                $TestPaperForm->attributes = $_POST['TestPaperForm'];
                $TestPaperForm->Title = $_GET['Title'];
                $TestPaperForm->Description = $_GET['Description'];
                $TestPaperForm->QuestionsCount = $_GET['questionsCount'];
                $TestPaperForm->SurveyRelatedGroupName = $_GET['SurveyGroupName'];
                $categories = explode(",",$_GET['SurveyGroupName']);                 
                $errors = array();
                $TestPaperForm->CreatedBy = $this->tinyObject->UserId;
                $searcharray = array();
                $f = json_decode($TestPaperForm->Questions);                
                $questionArray = array();                
                for ($i = 0; $i < sizeof($f); $i++) {
                    $searcharray = array();
                    parse_str($f[$i], $searcharray);
                    $TestPreparationBean = new TestPreparationBean();
                    $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('GroupName', $categories[$i]);
                    error_log("---------surveyDetails-----".print_r($surveyObj,true));
                    $scheduleSurveyForm= new ScheduleSurveyForm();
                    $scheduleSurveyForm->StartDate = date("Y-m-d");
                    $scheduleSurveyForm->EndDate = date("Y-m-d");
                    $scheduleSurveyForm->SurveyId = $surveyObj->_id;
                    $scheduleSurveyForm->SurveyTitle = $surveyObj->SurveyTitle;
                    $scheduleSurveyForm->SurveyDescription = $TestPaperForm->Description;
                    $scheduleSurveyForm->SurveyRelatedGroupName = $surveyObj->SurveyRelatedGroupName;
                    $result = ServiceFactory::getSkiptaExSurveyServiceInstance()->saveScheduleSurveydump($scheduleSurveyForm, $UserId);
                    $TestPreparationBean->ScheduleId = $result;
              
                    foreach ($searcharray["TestPaperForm"] as $key => $value) {
                           error_log($value."-----key------".$key); 
                           
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
                    }
                    error_log("----bean---".print_r($TestPreparationBean,true));
                    array_push($questionArray, $TestPreparationBean);
                }
                $TestPaperForm->Questions = $questionArray;  
                
                $surveyR = ServiceFactory::getTO2TestPreparaService()->saveTestPrepair($TestPaperForm, $UserId);
                $obj = array("status" => "success");
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
 error_log("@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@");
        try {
            if (isset($_GET['ExtendedSurveyBean_page']) && isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
                error_log("---ifffff------");
                $streamIdArray = array();
                $userId = $this->tinyObject['UserId'];
                $pageSize = 6;                
                $isNotifiable = 1;
                if (Yii::app()->session['IsAdmin'] != 1) {
                    $isNotifiable = 0;
                }
                error_log($UserId."---ifffff---2---".$_GET['ExtendedSurveyBean_page']);

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
                if ($provider->getTotalItemCount() == 0) {error_log("---ifffff---4-vv--");
                    $preparedObject = 0; //No posts
                } else if ($_GET['ExtendedSurveyBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $preparedObject = (CommonUtility::prepareTestPaperDashboradData($provider->getData()));
                    
                } else {

                    $preparedObject = -1; //No more posts
                }           
                error_log("@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@");
                $this->renderPartial('dashboardWall', array('surveyObject' => $preparedObject));
            }else{error_log("---elefffff------");
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
        try {error_log("---enter invitecontr----".$_REQUEST['surveyId']);
            $surveyId = $_REQUEST['surveyId'];
            $getAllUsers = User::model()->getUsers();
            error_log("eeeee--------".print_r($getAllUsers,1));
            $scheduleForm = new ScheduleSurveyForm();
            $this->renderPartial('inviteUsers', array('scheduleForm' => $scheduleForm,"surveyId" => $surveyId, "allUsers" => $getAllUsers));
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionLoadSurveySchedule==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionLoadSurveySchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}
