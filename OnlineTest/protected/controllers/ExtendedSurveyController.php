<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ExtendedSurveyController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function init() {
        try{

            $this->layout = "adminLayout";

        if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
            parent::init();
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
        }else{
             parent::init();
               $this->redirect('/');
        }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex() {
        try {          
            //ExtendedSurveyCollection::model()->saveSurvey();
            if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
                if (Yii::app()->session['IsAdmin'] == 1) {
                    $ExtendedSurveyForm = new ExtendedSurveyForm();
                    $surveyGroupNames = ExSurveyResearchGroup::model()->getLinkGroups();
                    $this->render('index', array("ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyGroupNames" => $surveyGroupNames));
                } else {
                    $this->redirect('/');
                }
            } else {
                $this->redirect('/');
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionIndex==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderQuestionWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $surveyId = isset($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "Radio";
            $this->renderPartial('questionWidget', array("widgetCount" => $widCnt, "radioLength" => 4, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyId" => $surveyId,"acitveIcon"=>$acitveIcon));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderQuestionWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderRadioWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $optionsCnt = 4;
            $_id = "";
            $surveyObj = array();
            if (isset($_REQUEST['optionsCnt']) && $_REQUEST['optionsCnt'] != 0) {
                $optionsCnt = $_REQUEST['optionsCnt'];
            }
            if (isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId'])) {
                $_id = $_REQUEST['surveyId'];
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $_id);
            }
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "Radio";
            $this->renderPartial('radioWidget', array("widgetCount" => $widCnt, "radioLength" => $optionsCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyObj" => $surveyObj,"acitveIcon"=>$acitveIcon));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderRadioWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderCheckboxWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $optionsCnt = 4;
            $_id = "";
            $surveyObj = array();
            if (isset($_REQUEST['optionsCnt']) && $_REQUEST['optionsCnt'] != 0) {
                $optionsCnt = $_REQUEST['optionsCnt'];
            }
            if (isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId'])) {
                $_id = $_REQUEST['surveyId'];
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $_id);
            }
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "Checkbox";
            $this->renderPartial('checkboxWidget', array("widgetCount" => $widCnt, "radioLength" => $optionsCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyObj" => $surveyObj,"acitveIcon"=>$acitveIcon));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderCheckboxWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionAddCheckboxOptionWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $this->renderPartial('checkboxOption', array("widgetCount" => $widCnt));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionAddCheckboxOptionWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionAddRadioOptionWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $optionType = "radio";
            $this->renderPartial('radioOption', array("widgetCount" => $widCnt,"optionType"=>$optionType));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionAddRadioOptionWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderRRWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $surveyId = isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";

            $qType = isset($_REQUEST['QType']) && !empty($_REQUEST['QType']) ? $_REQUEST['QType'] : 0;
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "RR";
            $this->renderPartial('RRWidget', array("widgetCount" => $widCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyId" => $surveyId, "qType" => $qType,"acitveIcon"=>$acitveIcon));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderRRWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderRankingWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $other = isset($_REQUEST['other'])?$_REQUEST['other']:"";
            $surveyObj = array();
            $surveyId = isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";
            if (empty($surveyId)) {
                $optionCnt = $_REQUEST['optionsCount'];
                $radioOpCnt = $_REQUEST['radioOptions'];
                 $optionsType = $_REQUEST['optionType'];
            } else {
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $surveyId);
                foreach ($surveyObj->Questions as $question) {
                    if ($question['QuestionType'] == 3) {
                        $optionCnt = $question['NoofOptions'];
                        $radioOpCnt = $question['NoofOptions'];
                        $optionsType = $question['optionType'];
                    }
                }
            }
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "RR";
            $this->renderPartial('RankingWidget', array("widgetCount" => $widCnt, "thcount" => $optionCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "radioOpCnt" => $radioOpCnt, "surveyObj" => $surveyObj, "surveyId" => $surveyId,"optionsType"=>$optionsType,"acitveIcon"=>$acitveIcon,"other"=>$other));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderRankingWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderRatingWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $other = isset($_REQUEST['other'])?$_REQUEST['other']:"";
            $surveyObj = array();
            $surveyId = isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";
            if (empty($surveyId)) {
                $optionCnt = $_REQUEST['optionsCount'];
                $ratingsCnt = $_REQUEST['ratingsCount'];
                $optionsType = $_REQUEST['optionType'];
            } else {
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $surveyId);
                foreach ($surveyObj->Questions as $question) {
                    if ($question['QuestionType'] == 4) {
                        $optionCnt = $question['NoofOptions'];
                        $ratingsCnt = $question['NoofRatings'];
                        $optionsType = $question['TextOptions'];
                    }
                }
            }
            
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "RR";
            $this->renderPartial('RatingWidget', array("widgetCount" => $widCnt, "thcount" => $optionCnt, "ratingsCnt" => $ratingsCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyObj" => $surveyObj, "surveyId" => $surveyId,"optionsType"=>$optionsType,"acitveIcon"=>$acitveIcon,"other"=>$other));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderRatingWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderPercentageDist() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $surveyId = isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";

            $qType = isset($_REQUEST['QType']) && !empty($_REQUEST['QType']) ? $_REQUEST['QType'] : 0;
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "Percent";
            $this->renderPartial('PercentageWidget', array("widgetCount" => $widCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyId" => $surveyId, "qType" => $qType,"acitveIcon"=>$acitveIcon));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderPercentageDist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderPercentageOptions() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $optionCnt = $_REQUEST['optionsCount'];
            $surveyObj = array();
            $noofoptions = 0;
            $surveyId = isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";
            $qType = isset($_REQUEST['QType']) && !empty($_REQUEST['QType']) ? $_REQUEST['QType'] : 0;
            if (empty($surveyId)) {
                $unitType = $_REQUEST['unitType'];
            } else {
                $unitType = 1;
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $surveyId);
                foreach ($surveyObj->Questions as $question) {
                    if ($question['QuestionType'] == 5) {
                        $unitType = $question['MatrixType'];
                        $optionCnt = $question['NoofOptions'];
                    }
                }
            }

            $type = "%";
            if ($unitType == 2) {
                $type = '$';
            }
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $this->renderPartial('PercentageDistOptions', array("widgetCount" => $widCnt, "optionsCnt" => $optionCnt, "unitType" => $type, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyId" => $surveyId, "surveyObj" => $surveyObj, "noofoptions" => $noofoptions));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderPercentageOptions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderQuestionAndAnswerWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $surveyId = isset($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";
            $noofchars = isset($_REQUEST['noofchars']) ? $_REQUEST['noofchars'] : 0;
            $surveyObj = array();
            if (!empty($surveyId)) {
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $surveyId);
            }
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "QandA";
            $this->renderPartial('QuestionAndAnswerWidget', array("widgetCount" => $widCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "noofchars" => $noofchars, "surveyId" => $surveyId, "surveyObj" => $surveyObj,"acitveIcon"=>$acitveIcon));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderQuestionAndAnswerWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderUserGeneratedWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $surveyId = isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";

            $surveyObj = array();
            if (!empty($surveyId)) {
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $surveyId);
                foreach ($surveyObj->Questions as $question) {
                    if ($question['QuestionType'] == 7) {
                        $unitType = $question['MatrixType'];
                        $optionCnt = $question['NoofOptions'];
                    }
                }
            } else {
                $optionCnt = $_REQUEST['optionsCount'];
            }
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "UserGenerated";
            $this->renderPartial('UserGeneratedOptions', array("widgetCount" => $widCnt, "thcount" => $optionCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyObj" => $surveyObj, "surveyId" => $surveyId,"acitveIcon"=>$acitveIcon));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderUserGeneratedWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUserGeneratedRankingWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $surveyId = isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";

            $qType = isset($_REQUEST['QType']) && !empty($_REQUEST['QType']) ? $_REQUEST['QType'] : 0;
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "UserGenerated";
            $this->renderPartial('UserGeneratedRankingWidget', array("widgetCount" => $widCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyId" => $surveyId,"acitveIcon"=>$acitveIcon));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionUserGeneratedRankingWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionSaveSurveyQuestion() {
        try {
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $UserId = $this->tinyObject->UserId;
            if (isset($_POST['ExtendedSurveyForm'])) {
                             
                $ExtendedSurveyForm->attributes = $_POST['ExtendedSurveyForm'];
                $ExtendedSurveyForm->SurveyTitle = $_GET['surveyTitle'];
                $ExtendedSurveyForm->SurveyDescription = $_GET['SurveyDescription'];
                $ExtendedSurveyForm->QuestionsCount = $_GET['questionsCount'];
                $ExtendedSurveyForm->SurveyRelatedGroupName = $_GET['SurveyGroupName'];
                $ExtendedSurveyForm->SurveyOtherValue = $_GET['SurveyOtherValue'];
                $ExtendedSurveyForm->SurveyLogo = $_GET['SurveyLogo'];

                $ExtendedSurveyForm->IsBranded = $_GET['IsBranded'];                                

                $errors = array();
                $ExtendedSurveyForm->CreatedBy = $this->tinyObject->UserId;
                error_log("====1111111111111");
                $searcharray = array();
                $f = json_decode($ExtendedSurveyForm->Questions);
                $questionArray = array();
                for ($i = 0; $i < sizeof($f); $i++) {
                    $searcharray = array();
                    parse_str($f[$i], $searcharray);
                    //error_log("*****message****".print_r($searcharray,true)); exit;
                    $ExSurveyBean = new ExSurveyBean();
                    foreach ($searcharray["ExtendedSurveyForm"] as $key => $value) {
                        if (is_array($value) && sizeof($value)) {

                           if ($ExtendedSurveyForm->SurveyId != "") {
                                if ($key == "QuestionId") {
                                    foreach ($value as $m) {
                                        if(!empty($m))
                                            $ExSurveyBean->QuestionId = new MongoId($m);
                                        else
                                            $ExSurveyBean->QuestionId = new MongoId();
                                    }
                                }
                            }
                            if ($key == "Question") {
                                foreach ($value as $m) {
                                    if ($ExtendedSurveyForm->SurveyId == "") {
                                        $ExSurveyBean->QuestionId = new MongoId();
                                    }
                                    $ExSurveyBean->Question = $m;
                                }
                            }
                            if ($key == "RadioOption") {
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->Options[$k++] = $m;
                                    $ExSurveyBean->QuestionType = (int) 1; //radio...
                                }
                            }
                            if ($key == "CheckboxOption") {
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->Options[$k++] = $m;
                                    $ExSurveyBean->QuestionType = (int) 2; //checkbox...
                                }
                            }
                             if ($key == "AnswerSelected") {
                                 $k = 0;
                                foreach ($value as $m) {
                                    error_log("************AnswerSelected555*****$m");
                                    $ExSurveyBean->Answers =  explode(",",$m);
                                    
                                }
                               
                            }
                            if ($key == "AnswerSelectedEdit") {
                                 $k = 0;
                                foreach ($value as $m) {
                                    error_log("************AnswerSelected*****");
                                    $ExSurveyBean->Answers =  explode(",",$m);
                                    
                                }
                            }
                              if ($key == "PercentageAnswer") {
                                 $l = 0;
                                foreach ($value as $n) {
                                    $ExSurveyBean->Answers[$l++] =  $n;
                                    
                                }
                            }
                            if($key == "QuestionImage"){
                                $l = 0;
                                foreach ($value as $n) {
                                   
                                    $ExSurveyBean->QuestionArtifact[$l] =  ServiceFactory::getSkiptaExSurveyServiceInstance()->saveVideoArtifacts($n,'/upload/ExSurvey/');
                                    
                                }
                            }
                            
                            /* if ($key == "QuestionAnswerSelected") {
                                 $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->Answers[0] =  $m;
                                    
                                }
                            }*/
                            
                            /*if($key == 'NoofChars'){
                                $k = 0;
                                foreach($value as $m){
                                    error_log("************NoofChars**********$m");
                                    if($m==100){
                                      $ExSurveyBean->Answers[0]=$ExtendedSurveyForm->QuestionAnswerTextSelected; 
                                    }else if($m==500){
                                        error_log("************1111NoofChars**********$m****$ExtendedSurveyForm->QuestionAnswerSelected");
                                      $ExSurveyBean->Answers[0] = $ExtendedSurveyForm->QuestionAnswerSelected;  
                                    }else if($m==1000){
                                        error_log("************22222NoofChars**********$m");
                                      $ExSurveyBean->Answers[0] = $ExtendedSurveyForm->QuestionAnswerSelected;    
                                    }
                                }
                            }
                            if ($key == "QuestionAnswerTextSelected") {
                                 $k = 0;
                                foreach ($value as $m) {
                                    error_log("********QuestionAnswerTextSelected****$m");
                                    $ExSurveyBean->Answers[0] =  $m;
                                    
                                }
                            }*/
                            
                             if ($key == "UserAnswerSelected") {
                                 $k = 0;
                                foreach ($value as $m) {
                                    
                                    error_log("*******************UserAnswerSelected**$m");
                                      $ExSurveyBean->Answers[] =  $m;
                                     }
                                     $ExSurveyBean->IsReviewed = 1;
                            }
                            if ($key == "MatrixAnswer") {
                                
                                 $k = 0;
                                 
                                foreach ($value as $m) {
                                    
                                    error_log("*******************MatrixAnswer**$m");
                                      $ExSurveyBean->Answers[$k++] =  $m;
                                     }
                                     
                            }
                            if ($key == "IsSuspend") {
                                 $k = 0;
                                foreach ($value as $m) {
                                                                      
                                      $ExSurveyBean->IsSuspended = (int) $m;
                                     }
                            }
                             if ($key == "MatrixType") {
                                $k = 0;
                                foreach ($value as $m) {
                                    if ($m == 1)
                                        $ExSurveyBean->QuestionType = (int) 3; //Ranking...
                                    else
                                        $ExSurveyBean->QuestionType = (int) 4; //Rating...
                                    $ExSurveyBean->MatrixType = (int) $m;
                                }
                            }
                            if ($key == "NoofOptions") {
                                foreach ($value as $m) {
                                    $ExSurveyBean->NoofOptions = (int) $m;
                                }
                            }
                            if ($key == "NoofRatings") {
                                foreach ($value as $m) {
                                    $ExSurveyBean->NoofRatings = (int) $m;
                                }
                            }

                            if ($key == "LabelName") {
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->LabelName[$k++] = $m;
                                }
                            }
                            if ($key == "OptionName") {
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->OptionName[$k++] = $m;
                                }
//                                $ExSurveyBean->OptionName[$k] = "Any Other";
                            }
                            if ($key == "Other") {
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->Other = (int) $m;
                                    $ExSurveyBean->IsReviewed = (int) $m;
//                                    if($m == 1){
//                                    $ExSurveyBean->IsReviewed = 1;
//                                    }else{
//                                      $ExSurveyBean->IsReviewed = 0;  
//                                    }
                                }
                            }
                            if ($key == "OtherValue") {
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->OtherValue = $m;
                                }
                            }
                            if ($key == "TotalValue") {
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->TotalValue = $m;
                                    $ExSurveyBean->QuestionType = (int) 5; //Percentage Dist...
                                }
                            }
                            if ($key == "NoofChars") {
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->NoofChars = (int) $m;
                                    $ExSurveyBean->QuestionType = (int) 6; //Percentage Dist...
                                }
                            }
                            if ($key == "TextOptions") {
                                foreach ($value as $m) {
                                    $ExSurveyBean->TextOptions = (int) $m;
                                }
                            }
                            if ($key == "TextMaxlength") {
                                foreach ($value as $m) {
                                    $ExSurveyBean->TextMaxlength = (int) $m;
                                }
                            }
                            if ($key == "IsMadatory") {
                                foreach ($value as $m) {
                                    $ExSurveyBean->IsMadatory = (int) $m;
                                }
                            }
                            if ($key == "IsAnalyticsShown") {
                                foreach ($value as $m) {
                                    $ExSurveyBean->IsAnalyticsShown = (int) $m;                                    
                                }
                            }
                            
                            if ($key == "AnyOther") {
                                $k = 0;
                                foreach ($value as $m) {
                                    if($m == 1){
                                    $ExSurveyBean->AnyOther = (int) $m;
                                     $ExSurveyBean->IsReviewed = (int) $m;
                                    //$ExSurveyBean->OptionName[sizeof($ExSurveyBean->OptionName)] = "Any Other";
                                }
//                                   array_push($ExSurveyBean->OptionName,"Any Other");
                                }
                            }
                            
                            if($key == "BooleanRadioOption"){
                                $k = 0;                               
                                foreach ($value as $m) {
                                    $ExSurveyBean->Options[$k++] = $m;
                                    $ExSurveyBean->QuestionType = (int) 8; //boolean with followup...                                    
                                }
                            }
                            if($key == "BooleanValues"){
                                $k = 0;   
                                foreach ($value as $m) {
                                    $ExSurveyBean->Justification = explode(",",$m);                                                                       
                                }                               
                            }
                            
                            if($key == "BooleanPlaceholderValues"){
                                $k = 0;                                
                                foreach ($value as $m) {
                                    $ExSurveyBean->OtherValue =  $m;                                                                       
                                }
                            }
                            if($key == "JustificationPlaceholders"){
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->JustificationPlaceholders[$k++] = $m;
                                    $ExSurveyBean->IsReviewed = 1;
                                }
                            }
                            if($key == "LabelDesc"){ //Label description for Ranking/Rating/Matrix...
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->LabelDescription[$k++] = $m;
                                }
                            }
                            if($key == "SelectionType"){ //Type of Boolean Widget...
                                $k = 0;
                                foreach ($value as $m) {
                                    error_log("*****************SelectionType".$m);
                                    $ExSurveyBean->SelectionType = (int) $m;
                                    if($m == 2){
                                        $ExSurveyBean->IsReviewed = 1;
                                    }
                                }
                            }
//                            if ($key == "IsAcceptUserInfo") {
//                                foreach ($value as $m) {
//                                    $ExSurveyBean->IsAcceptUserInfo = (int) $m;                                    
//                                }
//                            }
                            if($key == "JustificationApplied"){
                                foreach ($value as $m) {
                                    $ExSurveyBean->JustificationAppliedToAll = (int) $m;                                    
                                }
                            }
                            if($key == "DisplayType"){ //Type of Boolean Widget...
                                $k = 0;
                                foreach ($value as $m) {
                                    $ExSurveyBean->DisplayType = (int) $m;
                                }
                            }
                            if ($key == "StylingOption") {
                                foreach ($value as $m) {
                                    $ExSurveyBean->StylingOption = (int) $m;
                                }
                            }
                            if ($ExSurveyBean->TotalValue == 0 && $ExSurveyBean->NoofOptions != 0 && $ExSurveyBean->QuestionType == 0) {
                                $ExSurveyBean->QuestionType = (int) 7; //User generated ratings...
                            }
                            if($ExSurveyBean->NoofChars == 100){
                                if($key == 'QuestionAnswerTextSelected'){
                                    foreach($value as $m){
                                        $ExSurveyBean->Answers[0]=$m;
                                        $ExSurveyBean->IsReviewed = 1;
                                    }
                                }
                            }else if($ExSurveyBean->NoofChars != 0){
                                if($key == 'QuestionAnswerSelected'){
                                    foreach($value as $m){
                                        $ExSurveyBean->Answers[0]=$m;
                                        $ExSurveyBean->IsReviewed = 1;
                                    }
                                }
                            }
//                            if($key == 'QuestionAnswerTextSelected'){
//                                
//                                error_log("******22222222222222***Noof QuestionAnswerTextSelected*****$ExSurveyBean->NoofChars");
//                            }
//                            if($key == "QuestionAnswerSelected"){
//                                 error_log("*****33333333333333****Noof QuestionAnswerSelected*****$ExSurveyBean->NoofChars");
//                            }

                            $ExSurveyBean->QuestionPosition = (int) ($i + 1);
                        }
                        //error_log("*********Noof chars$$$$*****$ExSurveyBean->NoofChars");
                        
//                        if($ExSurveyBean->NoofChars==100){
//                            if($key = 'QuestionAnswerTextSelected'){
//                                error_log("*****100$$$$$$");
//                                foreach($value as $m){
//                                    $ExSurveyBean->Answers[0]=$m;
//                                }
//                            }
//                        }else if($ExSurveyBean->NoofChars==500 || $ExSurveyBean->NoofChars == 1000){
//                            if($key = 'QuestionAnswerSelected'){
//                                error_log("*****500$$$$$$");
//                                foreach($value as $m){
//                                    $ExSurveyBean->Answers[0]=$m;
//                                }
//                            }
//                        }
                    }
                    array_push($questionArray, $ExSurveyBean);
                }
                $ExtendedSurveyForm->Questions = $questionArray;
                //$marketResearchFollowUp = new MarketResearchFollowUp();
               // $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($UserId);
//                $marketResearchFollowUp->FirstName = $userObj->FirstName;
                $NetworkId=Yii::app()->params['NetWorkId'];
                error_log("====22222222222222");
                $surveyR = ServiceFactory::getSkiptaExSurveyServiceInstance()->saveSurvey($ExtendedSurveyForm, $NetworkId, $UserId);
                $obj = array("status" => "success");
                //}

                $renderScript = $this->rendering($obj);
                echo $renderScript;
            } 
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionSaveSurveyQuestion==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionSaveSurveyQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionValidateSurveyQuestion() {
        try{
        $ExtendedSurveyForm = new ExtendedSurveyForm();
        $UserId = $this->tinyObject->UserId;
         
        if (isset($_POST['ExtendedSurveyForm'])) {         
            
            $ExtendedSurveyForm->attributes = $_POST['ExtendedSurveyForm'];
            $ExtendedSurveyForm->SurveyTitle = $_GET['surveyTitle'];
            $ExtendedSurveyForm->SurveyDescription = $_GET['SurveyDescription'];
            
            $ExtendedSurveyForm->QuestionsCount = $_GET['questionsCount'];;
            $ExtendedSurveyForm->SurveyRelatedGroupName = $_GET['SurveyGroupName'];
            $ExtendedSurveyForm->SurveyOtherValue = $_GET['SurveyOtherValue'];
            $ExtendedSurveyForm->SurveyLogo = $_GET['SurveyLogo'];
            $ExtendedSurveyForm->IsBranded = $_GET['IsBranded'];    
            $ExtendedSurveyForm->BrandName = $_GET['BrandName'];
            $ExtendedSurveyForm->BrandLogo = $_GET['BrandLogo'];
//                $ExtendedSurveyForm->NoofRatings = $_GET['noofratings'];
            error_log("========3333333333333333333333333333333333===");
            if ($ExtendedSurveyForm->SurveyLogo == "") {
                $common['ExtendedSurveyForm_SurveyLogo'] = "Please upload a logo";
            } else if ($ExtendedSurveyForm->SurveyRelatedGroupName == "other" && $ExtendedSurveyForm->SurveyOtherValue == "") {
                $common['ExtendedSurveyForm_SurveyOtherValue'] = "Other value cannot be blank";
            }
            else {
                $common['ExtendedSurveyForm_SurveyOtherValue'] = "";
//                    $common['ExtendedSurveyForm_SurveyRelatedGroupName'] =  "";
                $common['ExtendedSurveyForm_SurveyLogo'] = "";
            }
            error_log("========11111111111111111===");
            $errors = CActiveForm::validate($ExtendedSurveyForm);
            if ($errors != '[]' || !empty($common['ExtendedSurveyForm_SurveyOtherValue']) || !empty($common['ExtendedSurveyForm_SurveyLogo'])) {
                $obj = array('status' => 'error', 'data' => '', 'error' => $errors, 'oerror' => $common);
            } else {
                $surveyGroupExist = ExSurveyResearchGroup::model()->getLinkGroup($_GET['surveyTitle']);
                if($surveyGroupExist > 0 && $isEditable = FALSE){
                    $common1['ExtendedSurveyForm_SurveyTitle'] = "Category Already Exist Please try with Other";
                $obj = array('status' => 'error', 'data' => '', 'error' => $errors, 'oerror' => $common1);
            }else{
               $obj = array('status' => 'success', 'data' => '', 'error' => "");
            }}
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionValidateSurveyQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUploadImage() {
        try {
            //shell_exec("convert /root/errormessages.tiff ".Yii::app()->params['WebrootPath']."/output_err_1.png");
//            $outputImgPath = Yii::app()->params['WebrootPath']."test123.png";
////            system("php  ".Yii::app()->params['WebrootPath']."yiic allutility convertAnyToAny --iimg='/root/errormessages.tiff' --oimage='$outputImgPath'");
//            system("php /usr/share/nginx/www/SkiptaNeo/protected/yiic allutility convertAnyToAny --iimg='/root/errormessages.tiff' --oimage='/test123.png'");
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            //  $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'] . '/upload/Group/Profile/';
            $questionid = $_REQUEST['qId'];
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "png", "tiff","TIF","tif","mp3","mp4","MP3","MP4"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //  $sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
            $sizeLimit = Yii::app()->params['UploadMaxFilSize'];
//            system("convert /root/errormessages.tiff ".Yii::app()->params['WebrootPath']."/output_err.png");
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            $tempPath = Yii::app()->getBaseUrl(true).'/temp/';
            if(isset($result['filename'])){
            $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
            $fileName=$result['filename'];//GETTING FILE NAME
            $extension = $this->getFileExtension($fileName);            
            if($extension == "tif" || $extension == "tiff"){
                $fileName = "";
                $tempPath = Yii::app()->getBaseUrl(true)."/".$result['tempFolder'];
                $folder = $webroot.$result['tempFolder'];
                $result['filename'] = $result['mfilename'];
                $result['savedfilename'] = $result['tsavedfilename'];                
            }
            if($extension == "mp3" || $extension == "mp4"){
                $result["extension"] = $extension;
            }
             $result["filepath"]= $tempPath.$fileName;
             $result["fileremovedpath"]= $folder.$fileName;
             $result['qid'] = $questionid;
            } else {
                $result['success'] = false;
            }

            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionUploadImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetSurveyGroups() {
        try{
            $data = ExSurveyResearchGroup::model()->getLinkGroups();
            $result1 = array("data" => $data, "status" => 'success');
            echo $this->rendering($result1);
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionGetSurveyGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionManageSurvey() {
        try{
        if (Yii::app()->session['IsAdmin'] == 1) {
            $urlArray = explode("/", Yii::app()->request->url);
            $surveyId = "";
            if (isset($urlArray[3]) && !empty($urlArray[3])) {
                $surveyId = $urlArray[3];
                $columnName = "Id";
            }
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $UserId = $this->tinyObject['UserId'];
            $Surveydata = array();
            if (isset($surveyId) && !empty($surveyId)) {
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById($columnName, $surveyId);
                $ExtendedSurveyForm->SurveyId = $surveyObj->_id;
                $ExtendedSurveyForm->SurveyTitle = $surveyObj->SurveyTitle;
                $ExtendedSurveyForm->SurveyDescription = $surveyObj->SurveyDescription;
                $ExtendedSurveyForm->Status = $surveyObj->Status;
                $ExtendedSurveyForm->SurveyLogo = $surveyObj->SurveyLogo;
                $ExtendedSurveyForm->SurveyRelatedGroupName = $surveyObj->SurveyRelatedGroupName;
                $ExtendedSurveyForm->QuestionsCount = $surveyObj->QuestionsCount;
                $ExtendedSurveyForm->BrandLogo = $surveyObj->BrandLogo;                
                $ExtendedSurveyForm->BrandName = $surveyObj->BrandName;
                $ExtendedSurveyForm->IsBranded = $surveyObj->IsBranded;
            } else {
                $surveyId = "";
                $surveyObj = array();
            }
            $surveyGroupNames = ExSurveyResearchGroup::model()->getLinkGroups();
            $isAlreadySchedule = ServiceFactory::getSkiptaExSurveyServiceInstance()->IsSurveyAlreadySchedule($surveyObj);
            $this->render('index', array('ExtendedSurveyForm' => $ExtendedSurveyForm, 'surveyId' => $surveyId, 'surveyObj' => $surveyObj, "surveyGroupNames" => $surveyGroupNames,"logo"=>$ExtendedSurveyForm->SurveyLogo,"isAlreadySchedule"=>$isAlreadySchedule));
        }else{
            $this->redirect('/');
        }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionManageSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRenderEditForm() {
        try {
            $isAlreadySchedule = 0;
            $surveyId = isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId']) ? $_REQUEST['surveyId'] : "";
            if (isset($surveyId) && !empty($surveyId)) {
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $surveyId);
                $isAlreadySchedule = ServiceFactory::getSkiptaExSurveyServiceInstance()->IsSurveyAlreadySchedule($surveyObj);
            }
            $this->renderPartial('surveyEditPage', array('surveyObj' => $surveyObj,"isAlreadySchedule"=>$isAlreadySchedule));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderEditForm::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
                $flag = "Survey";
                if (isset($_REQUEST['filterString'])) {
                    $cDate = date('m/d/y');                    
                    if ($_REQUEST['filterString'] == 'FutureSchedule') {
                        $condition = array(
                            'StartDate' => array('>' => new MongoDate(strtotime(date('Y-m-d H:i:s', time())))),
                        );
                        $_GET['ScheduleSurveyCollection_page'] = $_GET['ExtendedSurveyBean_page'];
                        $provider = new EMongoDocumentDataProvider('ScheduleSurveyCollection', array(
                            'pagination' => array('pageSize' => $pageSize),
                            'criteria' => array(
                                'conditions' => $condition,
                                'sort' => array('_id' => EMongoCriteria::SORT_DESC)
                            )
                        ));
                        $flag = "Schedule";
                    } else if ($_REQUEST['filterString'] == 'SuspendedSurveys') {
                        $condition = array(
                            'IsDeleted' => array('==' => 1),
                        );
                        $_GET['ExtendedSurveyCollection_page'] = $_GET['ExtendedSurveyBean_page'];
                        $provider = new EMongoDocumentDataProvider('ExtendedSurveyCollection', array(
                            'pagination' => array('pageSize' => $pageSize),
                            'criteria' => array(
                                'conditions' => $condition,
                                'sort' => array('_id' => EMongoCriteria::SORT_DESC)
                            )
                        ));
                    } else {
                        $condition = array(
                            'IsDeleted' => array('!=' => 1),
                        );
                        $_GET['ExtendedSurveyCollection_page'] = $_GET['ExtendedSurveyBean_page'];
                        $provider = new EMongoDocumentDataProvider('ExtendedSurveyCollection', array(
                            'pagination' => array('pageSize' => $pageSize),
                            'criteria' => array(
                                'conditions' => $condition,
                                'sort' => array('_id' => EMongoCriteria::SORT_DESC)
                            )
                        ));
                    }
                } else {

                    $condition = array(
                        'IsDeleted' => array('!=' => 1),
                    );
                    $_GET['ExtendedSurveyCollection_page'] = $_GET['ExtendedSurveyBean_page'];
                    $provider = new EMongoDocumentDataProvider('ExtendedSurveyCollection', array(
                        'pagination' => array('pageSize' => $pageSize),
                        'criteria' => array(
                            'conditions' => $condition,
                            'sort' => array('_id' => EMongoCriteria::SORT_DESC)
                        )
                    ));
                }
                $preparedObject = array();
                $providerArray = array();
                if ($provider->getTotalItemCount() == 0) {
                    $preparedObject = 0; //No posts
                } else if ($_GET['ExtendedSurveyBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    if($flag == "Survey")
                        $preparedObject = (CommonUtility::prepareSurveyDashboradData($UserId, $provider->getData()));
                    else{
                        $datao = $provider->getData();
                        foreach($datao as $data){                            
                            $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id',$data->SurveyId);             
                            array_push($providerArray,$surveyObj);
                        }
                        $preparedObject = (CommonUtility::prepareSurveyDashboradData($UserId, $providerArray));
                    }
                } else {

                    $preparedObject = -1; //No more posts

                }       
                $testprepareobj = TestPreparationCollection::model()->getTestPreparationCollection();
                $catArray = array();
                foreach($testprepareobj as $cat){                    
                    foreach($cat->Category as $cat1){
                       if($catArray[$cat1['CategoryName']] == ""){
                          $catArray[$cat1['CategoryName']] = 1;
                       }else{
                           $catArray[$cat1['CategoryName']] = $catArray[$cat1['CategoryName']]+1;                           
                       }                      
                    }                   
                }                

                $this->renderPartial('dashboardWall', array('surveyObject' => $preparedObject,"categoriesCount"=>$catArray));
            }else{
                $this->redirect("/");
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionLoadSurveyWall==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionLoadSurveyWall::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionLoadSurveySchedule() {
        try {
            $surveyId = $_REQUEST['surveyId'];
            $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $surveyId);
            $scheduleForm = new ScheduleSurveyForm();
            $scheduleForm->SurveyId = $surveyId;
            $scheduleForm->SurveyRelatedGroupName = $surveyObj->SurveyRelatedGroupName;
            $this->renderPartial('scheduleSurvey', array('scheduleForm' => $scheduleForm, "surveyId" => $surveyId, "surveyObj" => $surveyObj));
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionLoadSurveySchedule==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionLoadSurveySchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionScheduleASurvey() {
        try {
            if (isset($_POST['ScheduleSurveyForm'])) {
                $scheduleSurveyForm = new ScheduleSurveyForm;
                $scheduleSurveyForm->attributes = $_POST['ScheduleSurveyForm'];
                $userId = $this->tinyObject['UserId'];
                $errors = CActiveForm::validate($scheduleSurveyForm);
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $surveyId = $scheduleSurveyForm->SurveyId;
                    $startDate = $scheduleSurveyForm->StartDate;
                    $endDate = $scheduleSurveyForm->EndDate . " 23:59:59";
                    $groupName = $scheduleSurveyForm->SurveyRelatedGroupName;
                    $startDate = CommonUtility::convert_time_zone(strtotime($startDate), date_default_timezone_get(), Yii::app()->session['timezone']);
                    $endDate = CommonUtility::convert_time_zone(strtotime($endDate), date_default_timezone_get(), Yii::app()->session['timezone']);
                    $isExists = ServiceFactory::getSkiptaExSurveyServiceInstance()->checkForScheduleSurvey($startDate, $endDate, $surveyId, $groupName);
                    //return;

                    $scheduleSurveyForm->StartDate = $startDate;
                    $scheduleSurveyForm->EndDate = $endDate;
                    if (is_object($isExists) || is_array($isExists)) {
                        $surveyTitle = $isExists->SurveyTitle;
                        $errorMessage = '<b>' . $surveyTitle . '</b> is already scheduled between   ' . date(Yii::app()->params['PHPDateFormat'], CommonUtility::convert_date_zone($isExists->StartDate->sec, Yii::app()->session['timezone'], date_default_timezone_get())) . " to " . date(Yii::app()->params['PHPDateFormat'], CommonUtility::convert_date_zone($isExists->EndDate->sec, Yii::app()->session['timezone'], date_default_timezone_get()));
                        $obj = array('status' => 'Exists', 'data' => $errorMessage, 'error' => $errors);
                    } else {
                          $language = Yii::app()->session['TinyUserCollectionObj']['Language'];
                        $NetworkName = Yii::app()->params['NetworkName'];

                        $language = isset(Yii::app()->session['TinyUserCollectionObj']['Language'])?Yii::app()->session['TinyUserCollectionObj']['Language']:"en";
                        $result = ServiceFactory::getSkiptaExSurveyServiceInstance()->saveScheduleSurvey($scheduleSurveyForm, $userId,$NetworkName,$language);
                        if ($result == "success") {
                            $obj = array('status' => 'success', 'data' => 'Market Research Scheduled Successfully', 'error' => '', 'surveyId' => $surveyId);
                        } else {
                            $obj = array('status' => 'error', 'data' => '', 'error' => '');
                        }
                    }

//                    $obj = array("status"=>"success");
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionScheduleASurvey==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionScheduleASurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionSaveScheduleGame() {
        try {
            $newScheduleGame = new ScheduleGameForm();
            if (isset($_POST['ScheduleGameForm'])) {
                $newScheduleGame->attributes = $_POST['ScheduleGameForm'];
                $userId = $this->tinyObject['UserId'];
                $errors = CActiveForm::validate($newScheduleGame);
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $gameId = $newScheduleGame->GameName;

                    $streamId = $newScheduleGame->StreamId;
                    $startDate = $newScheduleGame->StartDate;
                    $endDate = $newScheduleGame->EndDate . " 23:59:59";
                    ;
                    $startDate = CommonUtility::convert_time_zone(strtotime($startDate), date_default_timezone_get(), Yii::app()->session['timezone']);
                    $endDate = CommonUtility::convert_time_zone(strtotime($endDate), date_default_timezone_get(), Yii::app()->session['timezone']);

                    $isExists = ServiceFactory::getSkiptaGameServiceInstance()->checkForScheduleGame($startDate, $endDate);
                    //return;
                    $newScheduleGame->StartDate = $startDate;
                    $newScheduleGame->EndDate = $endDate;
                    if (is_object($isExists) || is_array($isExists)) {
                        $gameName = $isExists->GameName;
                        //$errorMessage='<b>'.$gameName .'</b> is already scheduled between   ' .date(Yii::app()->params['PHPDateFormat'],$isExists->StartDate->sec) ." to ". date(Yii::app()->params['PHPDateFormat'],$isExists->EndDate->sec);
                        $errorMessage = '<b>' . $gameName . '</b> is already scheduled between   ' . date(Yii::app()->params['PHPDateFormat'], CommonUtility::convert_date_zone($isExists->StartDate->sec, Yii::app()->session['timezone'], date_default_timezone_get())) . " to " . date(Yii::app()->params['PHPDateFormat'], CommonUtility::convert_date_zone($isExists->EndDate->sec, Yii::app()->session['timezone'], date_default_timezone_get()));

                        $obj = array('status' => 'Exists', 'data' => $errorMessage, 'error' => $errors);
                    } else {

                        $result = ServiceFactory::getSkiptaGameServiceInstance()->saveScheduleGame($newScheduleGame, $userId);
                        $result = 'success';
                        if ($result == 'success') {
                            $obj = array('status' => 'success', 'data' => 'Game Scheduled Successfully', 'error' => '', 'gameId' => $gameId, 'streamId' => $streamId);
                        } else {
                            $obj = array('status' => 'error', 'data' => '', 'error' => '');
                        }
                    }
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionSaveScheduleGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUploadThankYouImage() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder = Yii::getPathOfAlias('webroot') . '/upload/'; // folder for uploaded files
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "png", "tiff","tif","TIF"); //array("jpg","jpeg","gif","exe","mov" and etc...
            // $sizeLimit = 30 * 1024 * 1024;// maximum file size in bytes
            $sizeLimit = Yii::app()->params['UploadMaxFilSize'];
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
//            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
            $fileName = $result['filename']; //GETTING FILE NAME
            $extension = $result['extension'];

            $ext = "ExSurvey/Thankyou";
            $destnationfolder = $folder . $ext;
            if (!file_exists($destnationfolder)) {
                mkdir($destnationfolder, 0755, true);
            }

            $imgArr = explode(".", $result['filename']);
            $date = strtotime("now");
            $finalImg_name = $imgArr[0] . '.' . $imgArr[1];
            $finalImage = $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
            $fileNameTosave = $folder . $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
            $path = $folder . $result['filename'];
            $extension_t = $this->getFileExtension($fileName);    
            if($extension_t == "tif" || $extension_t == "tiff"){                
                $imgArr = explode(".", $result['mfilename']);
                $fileNameTosave = $folder . $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
                $finalImage = $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
                $path = $folder . $result['mfilename'];
                $result['savedfilename'] = $result['tsavedfilename'];                
            }
            rename($path, $fileNameTosave);

            //  $filename=$result['filename'];
            $sourcepath = $fileNameTosave;
            $destination = $folder . $ext . "/" . $finalImage;
            if ($ext != "") {
                if (file_exists($sourcepath)) {
                    if (copy($sourcepath, $destination)) {
                        unlink($sourcepath);
                    }
                }
            }
            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionUploadThankYouImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionSuspendSurvey() {
        try {
            $surveyId = $_REQUEST['surveyId'];
            $actionType = $_REQUEST['actionType'];
            $networkId = $_REQUEST['networkId'];
            $return = ServiceFactory::getSkiptaExSurveyServiceInstance()->suspendSurvey($surveyId, $actionType);

            if ($return != "failure") {
                $obj = array("status" => 'success');
            } else {
                $obj = array("status" => 'failure');
            }
            $obj = $this->rendering($obj);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionSuspendSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyController->actionSuspendSurvey==". $ex->getMessage());
            $obj = array("status" => 'failure');
            echo CJSON::encode($obj);
        }
    }

    public function actionCancelSurveySchedule() {
        try {
            $surveyId = $_REQUEST['surveyId'];
            $scheduleId = $_REQUEST['scheduleId'];
            $return = ServiceFactory::getSkiptaExSurveyServiceInstance()->cancelScheduleSurvey($surveyId, $scheduleId);
            if ($return != "failure") {
                
                $obj = array("status" => 'success');
            } else {
                $obj = array("status" => 'failure');
            }
            $obj = $this->rendering($obj);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionCancelSurveySchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $obj = array("status" => 'failure');
            echo CJSON::encode($obj);
        }
    }

    public function actionSurveyAnalytics() {
        try {
            $scheduleId = isset($_REQUEST['ScheduleId']) ? $_REQUEST['ScheduleId'] : "";
            if (isset($_REQUEST['userId']) && !empty($_REQUEST['userId'])) {
                if (isset($this->tinyObject)) {
                    $userId = $this->tinyObject->UserId;
                } else {
                    $userId = $_REQUEST['userId'];
                }
            } else {
                $userId = "";
            }

            $object = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyAnalytics($userId, $scheduleId);

            $surveyedTakenUsersCount = 0;
            $ResumeUsersCount = 0;
            $pagesAnalyticsData = "";
            if ($userId == "") {
                $scheduleObject = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject("Id", $scheduleId);
                $surveyedTakenUsersCount = sizeof($scheduleObject->SurveyTakenUsers);
                $ResumeUsersCount = sizeof($scheduleObject->ResumeUsers);

                $pagesAnalyticsData = CommonUtility::getSurveyPageAnalytics($scheduleId, "");
                $PagesAnalyticsData = $pagesAnalyticsData["PagesAnalyticsData"];
                $totalTimeSpent = $pagesAnalyticsData["totalTimeSpent"];

                if ($totalTimeSpent > 0) {
                    $avgTimeSpentOnSurvey = $totalTimeSpent / ( $surveyedTakenUsersCount + $ResumeUsersCount);
                } else {
                    $avgTimeSpentOnSurvey = 0;
                }
                $avgTimeSpentOnSurvey = gmdate("H:i:s", $avgTimeSpentOnSurvey);
                $pagesAnalyticsData["avgTimeSpent"] = $avgTimeSpentOnSurvey;



                foreach ($PagesAnalyticsData as $key => $value) {
                    $PageTimeSpentInSeconds = $value["PageTimeSpentInSeconds"];


                    $percentage = ($PageTimeSpentInSeconds / $totalTimeSpent) * 100;
                    $percentage = round($percentage, 2);
                    $value["Percentage"] = $percentage;
                    $PagesAnalyticsData[$key] = $value;
                }

                $pagesAnalyticsData["PagesAnalyticsData"] = $PagesAnalyticsData;
            }


            echo json_encode(array("data" => $object, "totalAnsweredUsersCount" => $surveyedTakenUsersCount, "abandonedUsersCount" => $ResumeUsersCount, "PagesAnalyticsData" => $pagesAnalyticsData));

        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionSurveyAnalytics==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionSurveyAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionGetSurveyAnalyticsData(){
        try{
            $result = array();
            $filterValue = $_REQUEST['filterValue'];
            $searchText = $_REQUEST['searchText'];
            $startLimit = $_REQUEST['startLimit'];
            $pageLength = $_REQUEST['pageLength'];
            $data = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyAnalyticsData($pageLength,$startLimit,$searchText,$filterValue,Yii::app()->session['timezone']);
            $totalUsers["totalCount"] = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyAnalyticsDataCount($filterValue,$searchText);
            $result = array("data" => $data, "total" => $totalUsers, "status" => 'success');    
            echo json_encode($result);
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionGetSurveyAnalyticsData==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionGetSurveyAnalyticsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionViewAdminSurveyAnalytics(){
        try{
            $surveyId = $_REQUEST['surveyId'];
            $scheduleId = $_REQUEST['ScheduleId'];
            $QuestionsSurveyForm = new QuestionsSurveyForm;
            $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id',$surveyId);
            $userId = "";
            $scheduleObject = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject("Id", $scheduleId);
            // $totalTimeSpentOnSurvey = CommonUtility::calculateTimeSpentOnSurvey($scheduleId,$surveyId);
            $pagesAnalyticsData = CommonUtility::getSurveyPageAnalytics($scheduleId,$surveyId);
            $totalTimeSpentOnSurvey = $pagesAnalyticsData["totalTimeSpent"];
            $surveyedTakenUsersCount = sizeof($scheduleObject->SurveyTakenUsers);
            $ResumeUsersCount = sizeof($scheduleObject->ResumeUsers);
            if($totalTimeSpentOnSurvey > 0 ){
                $avgTimeSpentOnSurvey = $totalTimeSpentOnSurvey/($surveyedTakenUsersCount+$ResumeUsersCount);
            }else{
                $avgTimeSpentOnSurvey = 0;
            }
            $totalTimeSpentOnSurvey =  gmdate("H:i:s", $totalTimeSpentOnSurvey); 
            $avgTimeSpentOnSurvey =  gmdate("H:i:s", $avgTimeSpentOnSurvey);  
            
            $dateFormat = CommonUtility::getDateFormat();
            $timezone = Yii::app()->session['timezone'];
            $startDate = date($dateFormat,CommonUtility::convert_date_zone($scheduleObject['StartDate']->sec,$timezone,  date_default_timezone_get())) ;
            $endDate = date($dateFormat,CommonUtility::convert_date_zone($scheduleObject['EndDate']->sec,$timezone,  date_default_timezone_get())) ;                 
            $date = $startDate." to ".$endDate;
            $text = $this->renderPartial('adminAnalytics',array("surveyObj"=>$surveyObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"userId"=>$userId,"scheduleObject"=>$scheduleObject,"sdate"=>$date,"totalTimeSpent"=>$totalTimeSpentOnSurvey,"avgtimeSpent"=>$avgTimeSpentOnSurvey,"PagesAnalyticsData"=>  json_encode($pagesAnalyticsData),"PagesAnalyticsNativeData"=>  $pagesAnalyticsData),true);
            echo $text;
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionViewAdminSurveyAnalytics==".$ex->getMessage());
            Yii::log("ExtendedSurveyController:actionViewAdminSurveyAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionPdf(){
    
//        $date = $_REQUEST['date'];
//        $analyticType = $_REQUEST['analyticType'];
        try
        {
            $questionText = "";

            if(!empty($_REQUEST['questionText'])){
                $questionText = $_REQUEST['questionText'];
            }
            
            if($_REQUEST['type']=="all"){
                $questionText ="Survey Users Chart_Page Analytics_";
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id',$_REQUEST['surveyId']);    
                foreach($surveyObj->Questions as $question){
                    $questionText = $questionText . $question['Question']."_";
                }                
            }
            
            $ii =  $_REQUEST['ii'];
            $question = $_REQUEST['question'];
            $date = date("Y-M-D");
            $name = "OM";            
        $this->renderPartial('html2pdf',array('date'=>$date,"name"=>$name,'configParams'=>Yii::app()->params,"question"=>$question,"questionText"=>$questionText,"ii"=>$ii));
        }catch(Exception $ex) {
        error_log("Exception Occurred in ExtendedSurveyController->actionPdf==".$e->getMessage());
        Yii::log("ExtendedSurveyController:actionPdf::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }

    }
    
    public function actionAnalyticsSaveImageFromBase64(){
        try{       
            $id = "";
            if($_REQUEST['id']!=""){
                $id = "_".$_REQUEST['id'];
            }
            $userId = $this->tinyObject->UserId;
            $path = $this->findUploadedPath();
            $data = $_REQUEST['imgData'];
            if($data != "undefined"){
            $img = str_replace('data:image/png;base64,', '', $data);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);           
            
             $fileName = $path."/images/".$userId.$id."_analyticsPDF.png";
            //save image from base64_string ...
            $success = file_put_contents($fileName, $data);
            
            }else{                
                copy($path."/images/system/noanalyticsfound.png", $path."/images/".$userId.$id."_analyticsPDF.png");
                $success = "success";
            }
                    
            $obj = array("data"=>"","status"=>$success);
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionAnalyticsSaveImageFromBase64==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionAnalyticsSaveImageFromBase64::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }           
        echo CJSON::encode($obj);
    }
    
    function findUploadedPath() {
     
        try {
          $originalPath="";
            $path = dirname(__FILE__);
            $pathArray = explode('/', $path);
            $appendPath = "";
            for ($i = count($pathArray) - 3; $i > 0; $i--) {
                $appendPath = "/" . $pathArray[$i] . $appendPath;
            }
            
            $originalPath = $appendPath;
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->findUploadedPath==".$ex->getMessage());
            Yii::log("ExtendedSurveyController:findUploadedPath::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $originalPath;
 } 

 public function actionSurveyAnalyticsByGroupName() {
        try {
            $groupName = isset($_REQUEST['groupName']) ? $_REQUEST['groupName'] : "";            
//            $userId = 1;            
            $surveyId = $_REQUEST['surveyId'];
            $timezone = Yii::app()->session['timezone'];                           
            $object = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyAnalyticsByGroupName($userId, $groupName,$surveyId,$timezone);
            
            $totObj = array("data"=>$object[0],"sdates"=>$object[1],"totalAnsweredUsersCount" => $object[2],"abandonedUsersCount" => $object[3],"PagesAnalyticsData" => $object[4]);
            echo json_encode($totObj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionSurveyAnalyticsByGroupName==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionSurveyAnalyticsByGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    
    public function actionGenerateSurveyAnalyticsXLS() {
        try {
            if ($_REQUEST['type'] == "all") {
                
                $surveyId = $_REQUEST['surveyId'];
                $scheduleId = $_REQUEST['scheduleId'];
               
                $surveyObj = ExtendedSurveyCollection::model()->getSurveyDetailsById('Id', $surveyId);                
                $qIdValues1 = "";
                $groupNameValues = "";
                $questionType="";                
                foreach($surveyObj->Questions as $questionobj){
                    $qType = $questionobj['QuestionType'];
                    if($qIdValues1==''){
                    $qIdValues1 =  $questionobj['QuestionId'];
                      $groupNameValues =  $surveyObj->SurveyRelatedGroupName;
                        $questionType =   $questionobj['QuestionType'];
                    }else{
                        
                    $qIdValues1 = $qIdValues1."_".$questionobj['QuestionId'];
                     $groupNameValues = $groupNameValues ."_". $surveyObj->SurveyRelatedGroupName;
                       $questionType =   $questionType."_".$questionobj['QuestionType'];
                    }                   
               
                }
                
                $qIdValues = explode("_", "_".$qIdValues1);
                $groupNameValues = explode("_", "_".$groupNameValues);                
                
                $cnt = count($qIdValues);               
                $startVal = 1;
            
            }else if ($_REQUEST['type'] == "SurveyUsersPieChat" || $_REQUEST['type'] == "SurveyPagesBarChat") {
                $surveyId = $_REQUEST['surveyId'];
                $scheduleId = $_REQUEST['scheduleId'];
                
                $groupName = $_REQUEST['groupName'];
                $QNumber = $_REQUEST['ii'];
                
                $cnt = 1;
                $startVal = 0;
            
            } else {
                $surveyId = $_REQUEST['surveyId'];
                $scheduleId = $_REQUEST['scheduleId'];
                $qType = $_REQUEST['qType'];
                $qId = $_REQUEST['qId'];
                $groupName = $_REQUEST['groupName'];
                $QNumber = $_REQUEST['ii'];

                $cnt = 1;
                $startVal = 0;
            }

            $r = new YiiReport(array('template' => 'surveyAnalytics_new.xls'));
            $logo = Yii::app()->params['WebrootPath'] . "images/system/logo.png";

            for ($z = $startVal; $z < $cnt; $z++) {
                $dateFormat = CommonUtility::getDateFormat();
                $ActivityColumnsArray = array();
                $data = array();
                $i = 0;
                $graphType = "Radio widget";
                $userId = "";                
              
                if ($_REQUEST['type'] == "all") {
                    //Some data
                  //$surveyId = $surveyIdValues[$z];
                  //$scheduleId = $scheduleIdValues[$z];
                  $qType = $_REQUEST['qType'];
                    $qId = $qIdValues[$z];
                  $qType = $questionType[$z];
                  //$groupName = $_REQUEST['groupName'];
                    
                    $groupName = "";
                    if ($_REQUEST['analyticsswitch'] == "ScheduleLevel") {
                        $groupName = $groupNameValues[$z];
                    }                    
                    $QNumber = $z;
                }                
                
                if ($groupName == "") {
                    $dataobj = CommonUtility::prepateSurveyAnalyticsData($userId, $scheduleId, "");
                } else {
                    $timezone = Yii::app()->session['timezone'];
                    $dataobj1 = CommonUtility::prepateSurveyAnalyticsDataByGroup($userId, $groupName, $surveyId, $timezone);
                    $dataobj = $dataobj1[0];
                }                

                foreach ($dataobj->Questions as $key => $value) {
                    if (($value['QuestionType'] == 1 || $value['QuestionType'] == 2 || $value['QuestionType'] == 5 || $value['QuestionType'] == 8) && $qId == $value['QuestionId']) {
                      $specialchar="";
                        if($value['IsMadatory']==1){
                           $specialchar="*";
                                   
                       }
                        $data[0][0] = $value['Question'].$specialchar;
                        $data[1][0] = "";
                        $data[2][0] = "Option Name";
                        $data[2][1] = "Answered Count";
                        $data[2][2] = "Percentage";
                        $i = 3;
                        $j = 0;
                        $totVal = 0;
                        foreach ($value['OptionsPercentageArray'] as $key1 => $value1) {
                            $data[$i][0] = $key1;
                            $data[$i][1] = $value['OptionsNewArray'][$key1];
                            $data[$i][2] = $value1 . "%";
                            $totVal += $value['OptionsNewArray'][$key1];
                            $i++;
                        }
                        $data[$i][0] = "Total";
                        $data[$i][1] = $totVal;
                    } else if (($value['QuestionType'] == 3 || $value['QuestionType'] == 4) && $qId == $value['QuestionId']) {
                        $data[0][0] = $value['Question'];
                        $data[1][0] = "";
                        $i = 0;
                        $j = 1;
                        $data[2][0] = "Option Name";
                        
                        $labelD = $value['LabelDescription']; 
                        
                        foreach ($value['LabelName'] as $key1 => $value1) {
                            
                            if(strlen(trim($value1)) == 0)
                                $value1 = $labelD[$key1];
                            
                            $data[2][$j] = $value1;
                            $j++;
                        }
                        $data[2][$j] = "Total";
                        //$data[2][$j + 1] = "Average";
                         if(sizeof($value['OptionsCommentsPercentageArray'])>0){
                        $data[2][$j + 1] = "Justfication";
                         }
                        $i = 3;
                        $j = 1;
                        foreach ($value['OptionsPercentageArray'] as $key1 => $value1) {
                            $data[$i][0] = $key1;
                            $j = 1;
                            $totalValue = 0;
                            foreach ($value1 as $k => $v) {
                                $totalValue += $value['OptionsNewArray'][$key1][$k];
                                $data[$i][$j] = $value['OptionsNewArray'][$key1][$k]."%";
                                $j++;
                            }
                            $avg = round(($totalValue / ($j - 1)), 2);
                            $data[$i][$j] = $totalValue;
                            //$data[$i][$j + 1] = $avg;
                            
                            if(sizeof($value['OptionsCommentsPercentageArray'])>0){
                                $justificationPercentage =  $value['OptionsCommentsPercentageArray'][$i-3];
                                 $justificationValue =  $value['OptionsCommentsNewArray'][$i-3];
                               // htmltrovalue += '<div class="customcolumns" style="text-align:center;">'+justificationValue+"  ("+justificationPercentage+'%)</div>';
                                $data[$i][$j + 1] = $justificationValue."  (".$justificationPercentage."%)";                                
                                 
                           }
                            
                            $i++;
                        }
                    } else if ( $value['QuestionType'] == 7 && $qId == $value['QuestionId']) {
                        $totVal = 0;
                        $data[0][0] = $value['Question'];
                        $data[1][0] = "";
                        $data[2][0] = "Option Name";
                        $data[2][1] = "Answered Count";
//                        $data[2][2] = "Percentage";                        
                        $i = 3;
                        $j = 0;
                        foreach ($value['OptionsNewArray'] as $key1 => $value1) {
                            $data[$i][0] = $key1;
                            $data[$i][1] = $value1;
//                            $data[$i][2] = $value1."%";
                            $totVal += $value1;
                            $i++;
                        }
                        $data[$i][0] = "Total";
                        $data[$i][1] = $totVal;
                    }
                     else if ($value['QuestionType'] == 6  && $qId == $value['QuestionId']) {
                         $totVal = 0;
                        $data[0][0] = $value['Question'];
                        $data[1][0] = "";
                        $data[2][0] = "Users";
                        $data[2][1] = "Count";
                        $data[2][2] = "Percentage";                        
                        $i = 3;
                        $j = 0;
                        foreach ($value['OptionsNewArray'] as $key1 => $value1) {
                            $data[$i][0] = $key1;
                            $data[$i][1] = $value1;
                            $data[$i][2] = $value['OptionsPercentageArray'][$key1]."%";
                            $totVal += $value1;
                            $i++;
                        }
                        $data[$i][0] = "Total";
                        $data[$i][1] = $totVal;
                    }

                    $data["SurveyTitle"] = $dataobj->SurveyTitle;
                    $data["activeSheet"] = $z;
                    $data["QNumber"] = $QNumber;                    
                    
                }
                       
         
                $f = preg_replace("/<\/?div[^>]*\>/i", "", Yii::app()->params['COPYRIGHTS']);
                $r->load(array(
                    array(
                        'id' => 'ong',
                        'data' => array(
                            'name' => 'Activity Report',
                            'footer' => str_replace('&copy;', "", $f),
                        )
                    ),
                        )
                );
                
                CommonUtility::insertDataDynamicallyInExcelSheetForSurvey($r->objPHPExcel, 4, $ActivityColumnsArray, $data);
                
                CommonUtility::insertImageInExcelSheet($r->objPHPExcel, $z, $logo, 'A1', 10, 10);
            }
            
            if ($_REQUEST['type'] == "all" || $_REQUEST['type'] == "SurveyUsersPieChat" || $_REQUEST['type'] == "SurveyPagesBarChat") {
                
                if($_REQUEST['type'] == "SurveyUsersPieChat" || $_REQUEST['type'] == "SurveyPagesBarChat"){
                    if ($groupName == "") {
                        $dataobj = CommonUtility::prepateSurveyAnalyticsData($userId, $scheduleId, "");
                    } else {
                        $timezone = Yii::app()->session['timezone'];
                        $dataobj1 = CommonUtility::prepateSurveyAnalyticsDataByGroup($userId, $groupName, $surveyId, $timezone);
                        $dataobj = $dataobj1[0];
                    }
                }
                //error_log("group name---------------------------".$groupName);
                if($groupName != ""){
                    $scheduleId = "";
                }
                $data = $this->generateSurveyPagesAnalyticsXLS($surveyId, $scheduleId, $_REQUEST['type'], $groupName);
                $data["SurveyTitle"] = $dataobj->SurveyTitle;
                
                $f = preg_replace("/<\/?div[^>]*\>/i", "", Yii::app()->params['COPYRIGHTS']);
                    $r->load(array(
                        array(
                            'id' => 'ong',
                            'data' => array(
                                'name' => 'Activity Report',
                                'footer' => str_replace('&copy;', "", $f),
                            )
                        ),
                            )
                );

                CommonUtility::insertDataDynamicallyInExcelSheetForSurvey($r->objPHPExcel, 4, $ActivityColumnsArray, $data);    
                CommonUtility::insertImageInExcelSheet($r->objPHPExcel, 0, $logo, 'A1', 10, 10);
            }            
            echo $r->render('excel5', 'SurveyAnalytics-' . str_replace(" ", "", $dataobj->SurveyTitle));
            
            Yii::app()->end();            
            
            
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionGenerateSurveyAnalyticsXLS==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionGenerateSurveyAnalyticsXLS::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function generateSurveyPagesAnalyticsXLS($surveyId, $scheduleId, $type, $groupName){
        $data = array();
        $ActivityColumnsArray = array();
        try{
            
            if($type=="all" || $type == "SurveyUsersPieChat"){
                if($groupName != ""){
                   
                    $scheduleObject = ScheduleSurveyCollection::model()->getSurveyDetailsBySurveyId('SurveyId',$surveyId);
                    
                    $SurveyTakenUsers = sizeof($scheduleObject['SurveyTakenUsers']);
                    $ResumeUsers = sizeof($scheduleObject['ResumeUsers']);
                    $TotalUsers = sizeof($scheduleObject['SurveyTakenUsers'])+sizeof($scheduleObject['ResumeUsers']);                
                   
                }else{
                    $scheduleObject = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject("Id", $scheduleId);
                    $SurveyTakenUsers = sizeof($scheduleObject->SurveyTakenUsers);
                    $ResumeUsers = sizeof($scheduleObject->ResumeUsers);
                    $TotalUsers = sizeof($scheduleObject->SurveyTakenUsers)+sizeof($scheduleObject->ResumeUsers);
                }
                
                $data[0][0] = "Survey Users Chart";
                $data[1][0] = "";
                $data[2][0] = "Users";
                $data[2][1] = "Count";
                $data[3][0] = "Users Who Completed Survey";
                $data[3][1] = $SurveyTakenUsers;
                $data[4][0] = "Users Who Abandoned Survey";
                $data[4][1] = $ResumeUsers;
                $data[5][0] = "Total";
                $data[5][1] = $TotalUsers;

                $data[6][0] = "";
                $data[7][0] = "";
            
            }
            
            if($type=="all" || $type == "SurveyPagesBarChat"){
                
                if($type == "SurveyPagesBarChat")
                    $c=0;
                else
                    $c=8;
                    
                $pagesAnalyticsData = CommonUtility::getSurveyPageAnalytics($scheduleId,$surveyId);
                
                $data[$c][0] = "Page Analytics";

                $data[$c+1][0] = "";

                $data[$c+2][0] = "Page Number";
                $data[$c+2][1] = " Time Spent ";
                $data[$c+2][2] = " Percentage ";

                $p = $c+3;
                foreach ($pagesAnalyticsData["PagesAnalyticsData"] as $value) {
                    $percentage = ($value["PageTimeSpentInSeconds"]/$pagesAnalyticsData["totalTimeSpent"])*100;

                    $data[$p][0] = $value["PageNumber"];
                     $data[$p][1] = $value["timeSpentString"];
                    $data[$p][2] = round($percentage,2)."%";
                   
                    $p++;
                }
                $data[$p][0] = "Total";
                $data[$p][1] = $pagesAnalyticsData["totalTimeSpentString"];
                
            }              
                      
            $data["activeSheet"] = 0;
            $data["QNumber"] = 0;
                        
            return $data;        
                
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:generateSurveyPagesAnalyticsXLS::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetUserAnyOtherValuesForAnalytics(){
        try{
            $surveyId = $_REQUEST['srvyId'];
            $questionId = $_REQUEST['questionId'];
            $startLimit = $_REQUEST['startlimit'];
            $pageLength = $_REQUEST['maxLength'];
            $question = $_REQUEST['question'];
            $data = (array)CommonUtility::prepareSurveyAnalyticsAnyOtherValues($surveyId, $questionId,$startLimit,$pageLength);
//            $userAnswers = ServiceFactory::getSkiptaExSurveyServiceInstance()->getUserOtherValues($surveyId, $questionId,$startLimit,$pageLength);
            $this->renderPartial('/outside/others_text',array("userAnswers"=>$data,"question"=>$question));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionGetUserAnyOtherValuesForAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyController->actionGetUserAnyOtherValuesForAnalytics==". $ex->getMessage());
        }
    }
    
    public function actionRenderBooleanFollowup() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $optionsCnt = 2;
            $_id = "";
            $surveyObj = array();
            if (isset($_REQUEST['optionsCnt']) && $_REQUEST['optionsCnt'] != 0) {
                $optionsCnt = $_REQUEST['optionsCnt'];
            }
            if (isset($_REQUEST['surveyId']) && !empty($_REQUEST['surveyId'])) {
                $_id = $_REQUEST['surveyId'];
                $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id', $_id);
            }
            $ExtendedSurveyForm = new ExtendedSurveyForm();
            $acitveIcon = "BooleanFollowup";
            $this->renderPartial('BooleanFollowup', array("widgetCount" => $widCnt, "radioLength" => $optionsCnt, "ExtendedSurveyForm" => $ExtendedSurveyForm, "surveyObj" => $surveyObj,"acitveIcon"=>$acitveIcon));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionRenderBooleanFollowup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionAddBooleanOptionWidget() {
        try {
            $widCnt = $_REQUEST['questionNo'];
            $sType = $_REQUEST['sType'];
            $optionType = "boolean";
            $this->renderPartial('radioOption', array("widgetCount" => $widCnt,"optionType"=>$optionType,"sType"=>$sType));
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:actionAddBooleanOptionWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyController->actionAddBooleanOptionWidget==". $ex->getMessage());
        }
    }
    public function actionRenderBooleanRadioCheckbox(){
        try{
            $widCnt = $_REQUEST['questionNo'];
            $type = $_REQUEST['type'];
            $optionsCnt = isset($_REQUEST['optscnt'])?$_REQUEST['optscnt']:2;
            $optionType = "boolean";
            //$optionsCnt = 2;
            $this->renderPartial('BooleanOptions', array("widgetCount" => $widCnt,"optionType"=>$optionType,"type"=>$type, "radioLength" => $optionsCnt));
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionRenderBooleanRadioCheckbox==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionRenderBooleanRadioCheckbox::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }   
    
      public function actionGenerateSurveyTakenUsersInfoAnalyticsXLS() {
        try {
            $surveyId = $_REQUEST['surveyId'];
            $scheduleId = $_REQUEST['scheduleId'];
            $dateFormat = CommonUtility::getDateFormat();
            $ActivityColumnsArray = array();

            $data = array();
            $i = 0;
            $resultArray = CommonUtility::prepateSurveyTakenUsersInfoData($surveyId, $scheduleId);
            $surveyTakenUsersInfo = $resultArray["surveyTakenUsersInfo"];
            $scheduleObject = $resultArray["scheduleObject"];

            $startDate = date($dateFormat, CommonUtility::convert_date_zone($scheduleObject->StartDate->sec, Yii::app()->session['timezone'], date_default_timezone_get()));
            $endDate = date($dateFormat, CommonUtility::convert_date_zone($scheduleObject->EndDate->sec, Yii::app()->session['timezone'], date_default_timezone_get()));
        if(is_array($surveyTakenUsersInfo)){
            $ActivityColumnsArray = array_slice(array_keys($surveyTakenUsersInfo[0]),1);
       
         
                    $i = 0;
                    foreach ($surveyTakenUsersInfo as $value) {
                        $inner = 0;
                        foreach ($value as $k => $v) {
                            if($k != "UserId"){
                        if($k == "Federal TaxId Or SSN"){
                           $value[$k] =  base64_decode($value[$k]);
                        }
                        if($k == "State"){
                          // $stateInfo =  State::model()->GetStateById($value[$k]);
                           $value[$k] = $value[$k];
                        }
                            $data[$i][$inner] = $value[$k];
                            $inner++;
                        }
                        }
          
                        $i++;
                    }
        }else{
             $data[0][0] = "No Data Found";
        }
            $r = new YiiReport(array('template' => 'surveyAnalytics_users.xls'));
          //  $f = preg_replace("/<\/?div[^>]*\>/i", "", Yii::app()->params['COPYRIGHTS']);
            $r->load(array(
                array(
                    'id' => 'ong',
                    'data' => array(
                       // 'name' => 'Survey Taken Users Report',
                       // 'surveyName' => $scheduleObject->SurveyTitle,
                       // 'date' => $startDate . ' to ' . $endDate,
                      //  'footer' => str_replace('&copy;', "", $f),
                    )
                ),
                    )
            );

            CommonUtility::insertDataDynamicallyInExcelSheet($r->objPHPExcel, 1, $ActivityColumnsArray, $data);
           // $logo = Yii::app()->params['WebrootPath'] . "images/system/logo.png";
           // CommonUtility::insertImageInExcelSheet($r->objPHPExcel, 0, $logo, 'A1', 10, 10);
           echo $r->render('excel5', $scheduleObject->SurveyTitle."_SurveyTakenUsers");

            Yii::app()->end();
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionGenerateSurveyTakenUsersInfoAnalyticsXLS==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionGenerateSurveyTakenUsersInfoAnalyticsXLS::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionAddMoreOptions() {
        try {
            $qNo = $_REQUEST['questionNo'];
            $type = $_REQUEST['sType'];
            $nop = $_REQUEST['oc']; // oc: Options Count
            $totalOptions = $_REQUEST['totalOptions'];
            $optionType = $type;
            $booleanTypeS = $_REQUEST['booleanTypeS'];
            error_log("**************88AddMoreOptions$optionType*****");
            $this->renderPartial('renderingOptions', array("widgetCount" => $qNo,"optionType"=>$optionType,"noofoptions"=>$nop,"totalOptions"=>$totalOptions,"type"=>$booleanTypeS));
        } catch (Exception $ex) {
             error_log("Exception Occurred in ExtendedSurveyController->actionAddMoreOptions==". $ex->getMessage());
             Yii::log("ExtendedSurveyController:actionAddMoreOptions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
        public function actionGetOtherDataForQuestion() {
        try {
            $questionId = $_REQUEST['questionId'];
            $questionType = $_REQUEST['questionType'];
            $scheduleId = $_REQUEST['ScheduleId'];
            $userId = $_REQUEST['userId']; // oc: Options Count
            $otherData = ServiceFactory::getSkiptaExSurveyServiceInstance()->getOtherDataForQuestion($scheduleId,$questionId,$questionType);  
           // $otherData = ["Moin"=>2,"aaaaa"=>5,"deddd"=>6,"abc"=>9,"indai"=>1,"techo2"=>20,"Moin Hussain"=>7,"add dfasdfas asdf asdf asdf asdfas asdfasdf asdf asdf asdf asdf asf asd"=>3,"sf sfsf"=>2,"aa sfa"=>5,"dddsffs"=>4,"dddsfssffs"=>4,"dddsfdfsfs"=>4,"ddsfsfdsffs"=>4,];
//    $otherData = [
//    ["AbuseWord"=>"Moin Hussain ","Weightage"=>10],
//    ["AbuseWord"=>"Hussain","Weightage"=>2],
//        ["AbuseWord"=>"Kiran","Weightage"=>1],
//        ["AbuseWord"=>"techo2","Weightage"=>9],
//         ["AbuseWord"=>"tec6ho2","Weightage"=>7],
//         ["AbuseWord"=>"sfsf","Weightage"=>2],
//         ["AbuseWord"=>"tecaaaaho2","Weightage"=>2],
//         ["AbuseWord"=>"tecdfdfdho2","Weightage"=>3],
//         ["AbuseWord"=>"tecsssho2","Weightage"=>2],
//         ["AbuseWord"=>"techsso2","Weightage"=>7],
//         ["AbuseWord"=>"techddo2dfadfasdfasdasfa sdfasdfasfasfasdfasd","Weightage"=>2],
//         ["AbuseWord"=>"techoff2","Weightage"=>5]
//    ]; 
            $this->renderPartial('otherValueTagCloud', array("data" => $otherData));
        } catch (Exception $ex) {
             error_log("Exception Occurred in ExtendedSurveyController->actionGetOtherDataForQuestion==". $ex->getMessage());
             Yii::log("ExtendedSurveyController:actionGetOtherDataForQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
            public function actionGetJustificationDataForQuestion() {
        try {
            $questionId = $_REQUEST['questionId'];
            $questionType = $_REQUEST['questionType'];
            $scheduleId = $_REQUEST['ScheduleId'];
              $surveyId = $_REQUEST['SurveyId'];
            $justificationPage = $_REQUEST['Page'];
            $userId = $_REQUEST['userId']; // oc: Options Count
            $pageLimit = 10;
            $offset = $justificationPage*$pageLimit;
            $justficationData = ServiceFactory::getSkiptaExSurveyServiceInstance()->getJustificationDataForQuestion($surveyId,$scheduleId,$questionId,$questionType,$offset,$pageLimit);  
//    $otherData = [
//    ["AbuseWord"=>"Moin Hussain ","Weightage"=>100],
//    ["AbuseWord"=>"Hussain","Weightage"=>2],
//        ["AbuseWord"=>"Kiran","Weightage"=>1],
//        ["AbuseWord"=>"techo2","Weightage"=>21]
//    ]; 
          
            $this->renderPartial('justificationView', array("justficationData" => $justficationData,"QuestionType"=> $questionType));
        } catch (Exception $ex) {
             error_log("Exception Occurred in ExtendedSurveyController->actionGetJustificationDataForQuestion==". $ex->getMessage());
             Yii::log("ExtendedSurveyController:actionGetJustificationDataForQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function actionGetAnswersDataForQuestion() {
        try {
            $questionId = $_REQUEST['questionId'];
            $questionType = $_REQUEST['questionType'];
            $scheduleId = $_REQUEST['ScheduleId'];
            $surveyId = $_REQUEST['SurveyId'];
            $seeAnswersPage = $_REQUEST['Page'];
            //$userId = $_REQUEST['userId']; // oc: Options Count
            $pageLimit = 10;
            $offset = $seeAnswersPage * $pageLimit;            
            $seeAnswersData = ServiceFactory::getSkiptaExSurveyServiceInstance()->getAnswersDataForQuestion($surveyId, $scheduleId, $questionId, $questionType, $offset, $pageLimit);

            $this->renderPartial('seeAnswersView', array("seeAnswersData" => $seeAnswersData, "QuestionType" => $questionType));
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionGetAnswersDataForQuestion==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionGetAnswersDataForQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionGetSurveyUsers() {
        try {

            $surveyUsersData = array();
            $surveyUsers = array();
            $surveyUsersPage = $_REQUEST['Page'];

            $pageLimit = 12;

            $offset = $surveyUsersPage * $pageLimit;
            
            $scheduleObject['StartDate'] = "";
            $scheduleObject['EndDate'] = "";
            
            if($_REQUEST['surveyType'] == 1){
                $startDate = "";
                $endDate = "";
                 $scheduleObject = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById('Id',$_REQUEST['userScheduleId']);
                 if($_REQUEST['userType'] == "Completed"){
                    $surveyUsers =  $scheduleObject->SurveyTakenUsers;
                 }elseif($_REQUEST['userType']="Abandoned"){
                    $surveyUsers =  $scheduleObject->ResumeUsers;
                 }  
            } else{                
                 $scheduleObject = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsBySurveyId('SurveyId',$_REQUEST['usersSurveyId']);
                 if($_REQUEST['userType'] == "Completed"){
                    $surveyUsers =  $scheduleObject['SurveyTakenUsers'];
                 }elseif($_REQUEST['userType']="Abandoned"){
                    $surveyUsers =  $scheduleObject['ResumeUsers'];
                 }
                 
                  $startDate = $scheduleObject['StartDate'];
                  $endDate = $scheduleObject['EndDate'];
                 
            }
               
            $surveyUsersData = CommonUtility::prepareSurveyUsersData($surveyUsers, $surveyUsersPage, $pageLimit);
            $surveyUsersData['StartDate'] = $startDate;
            $surveyUsersData['EndDate'] = $endDate;
           
            $this->renderPartial('surveyUsersView', array("surveyUsersData" => $surveyUsersData));
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionGetSurveyCompletedUsers==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionGetSurveyCompletedUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGenerateSurveyTakenUsersInfoToXLS() {
        try {
            $surveyId = isset($_REQUEST['surveyid']) ? $_REQUEST['surveyid'] : "";
            $scheduleId = isset($_REQUEST['scheduleid']) ? $_REQUEST['scheduleid'] : "";
            $dateFormat = CommonUtility::getDateFormat();
            $ActivityColumnsArray = array();
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
            $resumeUsersArray = array();
            $scheduleObject = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject("Id", $scheduleId);
            $abondonedUserAnswers = SurveyUsersSessionCollection::model()->getSurveyAnswersByScheduleId($scheduleId);
            $userAnswers_s = $scheduleObject->UserAnswers;
            $userAnswers_s = array_merge($userAnswers_s,$abondonedUserAnswers);
            $resumeUsersArray = $scheduleObject->ResumeUsers;
            $surveyObject = ExtendedSurveyCollection::model()->getSurveyDetailsObject("Id", $scheduleObject->SurveyId);

            $r = new YiiReport(array('template' => 'surveyAnalytics_users.xls'));

            $questions = $surveyObject->Questions;
            
            for ($qi = 0; $qi < sizeof($questions); $qi++) {
                $totalArray = array();

                foreach ($userAnswers_s as $userAnswer) {
                    if ($userAnswer['QuestionId'] == (string) $questions[$qi]['QuestionId']) {
                        array_push($totalArray, $userAnswer);
                    }
                }
                $tempuserAnswersArray = array_chunk($totalArray, 500);
                $data = array();
                $data[0][0] = "User Name";
                $data[0][1] = "Question";
                $data[0][2] = "User Survey Status";
                $data[0][3] = "Question Type";                
                $data[0][4] = "Other Values";   
                $data[0][5] = "Seleted Options";
                $i = 1;
                if(isset($tempuserAnswersArray[$page])){
                foreach ($tempuserAnswersArray[$page] as $value) {
                    $k = 0;
                    $question = $this->array_search_inner($questions, 'QuestionId', $value["QuestionId"]);
                    
                    if (!empty($question['QuestionId'])) {                       
                        $userObj = User::model()->getUserByType($value['UserId'], "UserId");
                        $data[$i][$k] = isset($userObj->Email) ? $userObj->Email : $value['UserId'];
                        $data[$i][++$k] = $question['Question'];
                        if ($question['QuestionType'] == 1) {
                            $qType = Yii::t("translation", "Ex_Widget_Radio");
                        } else if ($question['QuestionType'] == 2) {
                            $qType = Yii::t("translation", "Ex_Widget_Checkbox");
                        } else if ($question['QuestionType'] == 3) {
                            $qType = "Ranking";
                        } else if ($question['QuestionType'] == 4) {
                            if ($question['MatrixType'] == 2)
                                $qType = "Rating";
                            else
                                $qType = "Matrix";
                        } else if ($question['QuestionType'] == 5) {
                            $qType = Yii::t("translation", "Ex_Widget_Percentage");
                        } else if ($question['QuestionType'] == 6) {
                            $qType = Yii::t("translation", "Ex_Widget_QAndA");
                        } else if ($question['QuestionType'] == 7) {
                            $qType = Yii::t("translation", "Ex_Widget_Generated");
                        } else if ($question['QuestionType'] == 8) {
                            $qType = Yii::t("translation", "Ex_Widget_Boolean");
                        }
                        
                        if(in_array($value['UserId'],$resumeUsersArray)){                            
                            $data[$i][++$k] = "Abandoned";
                        }else{
                            $data[$i][++$k] = "Completed";
                        }
                        $data[$i][++$k] = $qType;
                        if($question['QuestionType'] == 3 || $question['QuestionType'] == 4){
                            if (isset($value['OptionOtherTextValue']) && !empty($value['OptionOtherTextValue']))
                                $data[$i][++$k] = $value['OptionOtherTextValue'];
                            else {
                                $data[$i][++$k] = "";
                            }
                        }else{
                            if (isset($value['OtherValue']) && $question['QuestionType'] != 8)
                                $data[$i][++$k] = $value['OtherValue'];
                            else {
                                $data[$i][++$k] = "";
                            } 
                        }
                        //$data[$i][++$k] = "";
                        if ($question['QuestionType'] == 1 || $question['QuestionType'] == 2 ) {
                           if($question['QuestionType'] == 2){
                            foreach($question['Options'] as $val){
                                $data[0][++$k] = $val;
                            }
                           }
                            
                            foreach ($value['SelectedOption'] as $key => $v) {
                                $str = $question['Options'];
                                if ($v > 0 && $v != "other")
                                    $value['SelectedOption'][$key] = $str[$v - 1];
                                else
                                    $value['SelectedOption'][$key] = $str[$key];
                                // if(isset($str[$v - 1]) && !empty(trim($str[$v - 1]) )){
                                if(isset($str[$v - 1]) && $str[$v - 1] != "other"){
                                    if($question['QuestionType'] == 1){
                                        $data[0][++$k] = "Selected Option";
                                        $data[$i][$k] = $str[$v - 1];
                                    }else if($question['QuestionType'] == 2){
                                        if($v > 0 && in_array($str[$v-1],$data[0]) && $v != "other"){
                                            $indexv = array_search($str[$v-1], $data[0]); 
                                            $data[$i][$indexv] = "TRUE";                                            
                                        }
                                    }
                             
                                }
                            }
                            //$data[$i][++$k] = implode(",", $value['SelectedOption']);
                        }
                               else if($question['QuestionType'] == 8){                                   
                                    
                                       foreach($question['Options'] as $val){
                                            $data[0][++$k] = $val;
                                        }
//                                           foreach($str as $dtrow){
//                                if(!empty($dtrow)){
//                                    $dtrow = strtolower($dtrow);
//                                    if(!in_array(trim($dtrow),$data[0])){
//                                        $sizedata = sizeof($data[0]);
//                                        $data[0][$sizedata] = trim($dtrow);                                    
//                                       
//                                    }
//                                }
//                            } 
                            
                            
                            
                            foreach ($value['SelectedOption'] as $key => $v) {
                                $str = $question['Options'];                                
                                if(isset($str[$v - 1]) && $str[$v - 1] != "other"){
                                    if($v > 0 && in_array($str[$v-1],$data[0]) && $v != "other"){
                                        $indexv = array_search($str[$v-1], $data[0]); 
                                        $data[$i][$indexv] = "TRUE";                                            
                                    }                             
                                }
                            }
                            
//                             foreach ($value['SelectedOption'] as $key => $v) {
//                                    $str = $question['Options'];
//                                    if ($v > 0 && $v != "other")
//                                        $value['SelectedOption'][$key] = $str[$v - 1];
//                                    else
//                                        $value['SelectedOption'][$key] = $str[$key];
//                                    if (isset($str[$v - 1])) {
////                                        $sizedata = sizeof($data[0]);
////                                        $data[0][$sizedata] = $str[$v - 1];                                    
////                                        $data[$i][$sizedata] = "TRUE";
//                                        
//                                        
//                                        
//                                    if(!in_array(trim($str[$v - 1]),$data[0])){
//                                        $sizedata = sizeof($data[0]);
//                                        $data[0][$sizedata] = $str[$v - 1];                                    
//                                        $data[$i][$sizedata] = "TRUE";
//                                    }else{
//                                       $indexv = array_search($str[$v - 1], $data[0]); 
//                                       $data[$i][$indexv] = "TRUE";
//                                    }
////                                         $data[$i][$k] = $str[$v - 1];  
////                                          $indexv = array_search($str,$data[0]); 
////                                       $data[$i][$indexv] = "TRUE";
//                                       
//                                    }
//                                }
                            }
                        
                        else if ($question['QuestionType'] == 3 || $question['QuestionType'] == 4) {
                            if ($question['MatrixType'] == 2) { // Rating...
                                foreach ($value['Options'] as $key => $v) {
                                    $str = $question['OptionName'];

                                    if (!empty($question['LabelDescription'][$v - 1]) && strlen(trim($question['LabelDescription'][$v - 1])) > 0) {
                                        $temp = $question['LabelDescription'][$v - 1];
                                    } else {
                                        $temp = $question['LabelName'][$v - 1];
                                    }
                                    $just = !empty($value['OptionCommnets'][$key])?"_".$value['OptionCommnets'][$key]:"";
                                    $value['Options'][$key] = $str[$key] . "_" . $temp . "_$v $just";
                                    
                                }
                                //++$k;
//                                   $data[$i][++$k] = implode(",",$value['Options']); 
                                foreach ($value['Options'] as $opr) {                                    
                                    $rat_explode = explode("_",$opr);
                                    $data[0][++$k] = $rat_explode[0];
                                    $trat = !empty($rat_explode[3])?"_".$rat_explode[3]:"";
//                                    $data[$i][$k] = $rat_explode[2]." (".trim($rat_explode[1]).") $trat";
                                    $data[$i][$k] = $rat_explode[1];
                                    $data[0][++$k] = ucfirst($rat_explode[0]). "_Justification";                                    
                                    $data[$i][$k] = $trat;
                                }
                            } else if ($question['MatrixType'] == 3) { //Matrix 
                                $string = "";
                                $kk = 0;
                                $string2 = "";
                                $farray = array();
                                $ikey = 0;
                                $ck = 0;
                                foreach ($value['Options'] as $rr) {

                                    if (is_array($rr)) {

                                        if (empty($string)) {
                                            $string = implode("_", $rr);
                                        } else {
                                            $string = "$string," . implode("_", $rr) . "";
//                                                $string = implode(",",$rr);
                                        }
                                        $string1 = "";
                                        foreach ($rr as $key => $v) {
                                            $str = $question['OptionName'];

                                            if (!empty($question['LabelDescription'][$key]) && strlen(trim($question['LabelDescription'][$key])) > 0) {
                                                $temp = $question['LabelDescription'][$key];
                                            } else {
                                                $temp = $question['LabelName'][$key];
                                            }

                                            
                                            //$data[$i][$ck] = $str[$kk]."_".$temp."($v)";
                                            if (empty($string1)) {
                                                $string1 = $str[$kk] . "_" . $temp . "($v)";
                                            } else {
//                                        $string1 = $str[$kk]."_".$temp."($v)";
                                                $string1 = $string1 . "," . $str[$kk] . "_" . $temp . "(".$v.")";
                                            }
                                            
                                            $data[0][++$k] = $str[$kk] . "_" . $temp;
                                            $data[$i][$k] = trim($v);                                            
                                            
                                        }
                                        $just = !empty($value['OptionCommnets'][$kk])?$value['OptionCommnets'][$key]:"";
                                        $data[0][++$k] = ucfirst($str[$kk]) . "_Justification" ;
                                        $data[$i][$k] = $just;

                                        if (empty($string2)) {
                                            $string2 = "[$string1]";
                                        } else {
                                            $string2 = $string2 . ",[$string1]";
                                        }
//                                         $data[$i][++$k] = $string1;  
                                    } else {
                                        $string1 = "$string, $rr";
                                    }


                                    $kk++;
                                }
                                //$data[$i][++$k] = $string2;                                    
                            } else { //ranking..
                                //++$k;
                                foreach ($value['Options'] as $key => $v) {
                                    $str = $question['OptionName'];

                                    if (!empty($question['LabelDescription'][$v - 1]) && strlen(trim($question['LabelDescription'][$v - 1])) > 0) {
                                        $temp = $question['LabelDescription'][$v - 1];
                                    } else {
                                        $temp = $question['LabelName'][$v - 1];
                                    }
                                    $just = !empty($value['OptionCommnets'][$key])?"_".$value['OptionCommnets'][$key]:"";
                                    $value['Options'][$key] = $str[$key] . "_" . $temp . "_$v $just";
                                    //$value['Options'][$key] = $str[$key] . "_" . $temp . "_$v"."_".$value['OptionCommnets'][$key];
//                                    $data[0][++$k] = $str[$key] . "_" . $temp;
//                                    $data[$i][$k] = $v;
                                }
                                foreach ($value['Options'] as $opr) {                                    
                                    $rat_explode = explode("_",$opr);
                                    $data[0][++$k] = $rat_explode[0];
                                    $trat = $rat_explode[3];
//                                    $data[$i][$k] = $rat_explode[2]." (".trim($rat_explode[1]).") $trat";
                                    $data[$i][$k] = $rat_explode[1];
                                    $data[0][++$k] = ucfirst($rat_explode[0]). "_Justification";                                    
                                    $data[$i][$k] = $trat;
                                }
                                //$data[$i][++$k] = implode(",", $value['Options']);
                            }
                        } else if ($question['QuestionType'] == 5) {
                            
                            foreach($value['DistributionValues'] as $key=>$dtrow){
                                if(!empty($dtrow)){
                                    $data[0][++$k] = $question['OptionName'][$key];
                                    $data[$i][$k] = $dtrow;
                                }
                            }   
                            $data[0][++$k] = "Unit Type";
                            $data[$i][$k] = ($question['MatrixType'] == 1)?"%":"$";
                        } else if ($question['QuestionType'] == 6) {
                             $data[0][++$k] = "Seleted Options";                             
                            $data[$i][$k] = $value['UserAnswer'];
                            
                        } else if ($question['QuestionType'] == 7) {
                            foreach($value['UsergeneratedRankingOptions'] as $dtrow){
                                if(!empty($dtrow)){
                                    $dtrow = strtolower($dtrow);
                                    if(!in_array(trim($dtrow),$data[0])){
                                        $sizedata = sizeof($data[0]);
                                        $data[0][$sizedata] = trim($dtrow);                                    
                                        $data[$i][$sizedata] = "TRUE";
                                    }else{
                                       $indexv = array_search($dtrow, $data[0]); 
                                       $data[$i][$indexv] = "TRUE";
                                    }
                                    $k++;
                                }
                            } 
                            
                        }
                        if ($question['QuestionType'] != 3 && $question['QuestionType'] != 4) {
                            if($question['QuestionType'] == 8){
                                $data[0][++$k] = "Justifications";
                                $data[$i][$k] = $value['OtherValue'];
                            }
                                                       
                        } 
//                        else {                            
//                            
//                            $data[0][++$k] = "Justifications";
//                            if (isset($value['OptionCommnets']))
//                                $data[$i][$k] = implode(",", $value['OptionCommnets']);
//                            else {
//                                $data[$i][$k] = "";
//                            }
//                        }
                        
                    }
                    $i++;
                }
            }
                $data["activeSheet"] = $qi;


                $r->load(array(
                    array(
                        'id' => 'ong',
                        'data' => array(
                        // 'name' => 'Survey Taken Users Report',
                        // 'surveyName' => $scheduleObject->SurveyTitle,
                        // 'date' => $startDate . ' to ' . $endDate,
                        //  'footer' => str_replace('&copy;', "", $f),
                        )
                    ),
                        )
                );
                

                CommonUtility::insertDataDynamicallyInExcelSheetForRaw($r->objPHPExcel, 1, $ActivityColumnsArray, $data);
                $i = 1;
            }
            echo $r->render('excel5', $scheduleObject->SurveyTitle."_RawData");

            Yii::app()->end();
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionGenerateSurveyTakenUsersInfoToXLS==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionGenerateSurveyTakenUsersInfoToXLS::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    function array_search_inner($array, $attr, $val, $strict = FALSE) {
        try{
        // Error is input array is not an array
        if (!is_array($array))
            return FALSE;
        // Loop the array
        foreach ($array as $key => $inner) {
            // Error if inner item is not an array (you may want to remove this line)
            if (!is_array($inner))
                return FALSE;
            // Skip entries where search key is not present
            if (!isset($inner[$attr]))
                continue;
            if ($strict) {
                // Strict typing
                if ($inner[$attr] === $val)
                    return $inner;
            } else {
                // Loose typing
                if ($inner[$attr] == $val)
                    return $inner;
            }
        }
        // We didn't find it
        return NULL;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyController:array_search_inner::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}
