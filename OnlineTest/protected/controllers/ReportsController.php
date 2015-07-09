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
                    $startDate='';
                    $endDate='';
                    $getTestReports = ServiceFactory::getSkiptaExSurveyServiceInstance()->getTestReportsForIndex('TestId', $TestPaperId);
                    $inviteForm = new InviteUserForm();
                    //$TestPaperForm->Title = "test;;;;";
                    $this->render('index',array("inviteForm" => $inviteForm,"testPaperId"=>$TestPaperId,"reportDataIndex"=>$getTestReports));
                } else {
                    $this->redirect('/');
                }
            } else {
                $this->redirect('/');
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in ReportsController->actionIndex==" . $ex->getMessage());
            Yii::log("ReportsController:actionIndex::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderReports(){
        try{
           $urlArray = explode("/", Yii::app()->request->url);
           $testPaperId = $_POST["testPaperId"];
           $startDate = $_POST["startDate"];
           $endDate = $_POST["endDate"];
           $searchCategoryScore = $_POST["searchText"];
           $startLimit = $_POST["startLimit"];
           $pageLength = $_POST["pageLength"];
           $getTestReports = ServiceFactory::getSkiptaExSurveyServiceInstance()->getTestReports('TestId', $testPaperId,$startDate,$endDate,$searchCategoryScore,$startLimit,$pageLength);
           $this->renderPartial("report",array("testPaperId"=>$testPaperId,"reportData"=>$getTestReports['data'],"total" => $getTestReports['totalTakenUsers'] ));
        } catch (Exception $ex) {
            error_log("Exception Occurred in ReportsController->actionRenderReports==" . $ex->getMessage());
            Yii::log("ReportsController:actionRenderReports::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

      public function actionGetReviewQuestions(){
        try{
            error_log("--actionGetReviewQuestions----");
           $testPaperId = $_POST["testPaperId"];
           $userId = $_POST["userId"];

            $reviewReportsData = ServiceFactory::getSkiptaExSurveyServiceInstance()->getReviewQuestions($testPaperId,$userId);
 
            $this->renderPartial("reviewQuestions",array("surveyObjArray"=>$reviewReportsData,"bufferAnswers"=>array()));
        } catch (Exception $ex) {
            error_log("Exception Occurred in ReportsController->actionRenderReports==" . $ex->getMessage());
            Yii::log("ReportsController:actionRenderReports::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
    
        public function actionSaveReviewQuestions(){
        try{
            error_log("--actionSaveReviewQuestions----");
            $reviewQuestions = json_decode($_POST["data"], true);

            foreach ($reviewQuestions as $reviewQuestion){
               // error_log(print_r($reviewQuestion,1));
                $testPaperId = $reviewQuestion["testPaperId"];
                //$userId = $this->tinyObject->UserId;
                 $userId = 179;
                $questionId = $reviewQuestion["questionId"];
                $uniqueId = $reviewQuestion["uniqueId"];
                $categoryId = $reviewQuestion["categoryId"];
                $score = $reviewQuestion["score"];
                $saveReviewResult = ServiceFactory::getSkiptaExSurveyServiceInstance()->saveReviewQuestions($testPaperId,$userId,$questionId,$categoryId,$uniqueId,$score);
             break;
                
            }
             $obj = array('status' => "success", 'data' => '', 'error' => "");
             $renderScript = $this->rendering($obj);
             echo $renderScript;
        } catch (Exception $ex) {
 error_log("Exception Occurred in ReportsController->actionRenderReports==" . $ex->getMessage());
            Yii::log("ReportsController:actionSaveReviewQuestions::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
}
