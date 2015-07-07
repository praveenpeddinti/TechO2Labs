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
                    $getTestReports = ServiceFactory::getSkiptaExSurveyServiceInstance()->getTestReports('TestId', $TestPaperId);
            
                    $inviteForm = new InviteUserForm();
                    //$TestPaperForm->Title = "test;;;;";
                    $this->render('index',array("inviteForm" => $inviteForm,"testPaperId"=>$TestPaperId,"reportData"=>$getTestReports));
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
            $getTestReports = ServiceFactory::getSkiptaExSurveyServiceInstance()->getTestReports('TestId', $testPaperId);
           // error_log("-------final data---".print_r($getTestReports,1));
            
            $this->renderPartial("report",array("reportData"=>$getTestReports));
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
           // error_log("-------getReviewReports data---".print_r($reviewReportsData,1));
            
            $this->renderPartial("reviewQuestions",array("surveyObjArray"=>$reviewReportsData,"bufferAnswers"=>array()));
        } catch (Exception $ex) {
 error_log("Exception Occurred in ReportsController->actionRenderReports==" . $ex->getMessage());
            Yii::log("ReportsController:actionRenderReports::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
}
