<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class QuestionpaperController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function init() {
        try {
             $cs = Yii::app()->getClientScript();
             $cs->registerCoreScript('jquery');
        } catch (Exception $ex) {
            Yii::log("QuestionpaperController:init::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex() {
//        try {
//            //ExtendedSurveyCollection::model()->saveSurvey();
//            if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
//                if (Yii::app()->session['IsAdmin'] == 1) {
//                    $TestPaperForm = new TestPaperForm();
//                    $surveyGroupNames = ExSurveyResearchGroup::model()->getLinkGroups();
//                    $this->render('index', array("TestPaperForm" => $TestPaperForm, "surveyGroupNames" => $surveyGroupNames));
//                } else {
//                    $this->redirect('/');
//                }
//            } else {
//                $this->redirect('/');
//            }
//        } catch (Exception $ex) {
//            error_log("Exception Occurred in TestPaperController->actionIndex==" . $ex->getMessage());
//            Yii::log("TestPaperController:actionIndex::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
//        }
    }
    
    public function actionQuestionPrepare(){
        
        error_log("**********QuestionPrepare*******");
        $userid = $_REQUEST['UserId'];
        $testid = $_REQUEST['TestId'];
        
        $obj = array('status' => 'error', 'data'=>$_REQUEST['UserId'], 'error' => 'Test taker already exist.');
         //$this->render('index', array("TestPaperForm" => $TestPaperForm, "surveyGroupNames" => $surveyGroupNames));      
           
            echo CJSON::encode($obj);
       
    }
    public function actionQuestionpaperview() {
        try {
            error_log("**********QuestionPrepare*******");

//          $userId = Yii::app()->session['TinyUserCollectionObj']['UserId'];
//          $testid = Yii::app()->session['TinyUserCollectionObj']['TestId'];
            $userId = 166;
            $testId = "558d477bbb8ccb42048b45d6";
            $questionprepareObj = TestPreparationCollection::model()->getTestDetails($testId);
            //$questionprepareObj = TestPreparationCollection::model()->find($criteria);
            $questionArray = array();
            foreach ($questionprepareObj->Category as $cat) {               //for each category
                error_log("**********each category" . $cat['CategoryName'] . "++++++++++++++" . $cat['NoofQuestions']);
                $questionsobj = ExtendedSurveyCollection::model()->getCategoryDetails($cat['CategoryName']);
                $questionsArray = $questionsobj->Questions;
                $questionsRandomKeys = array_rand($questionsArray, $cat['NoofQuestions']);
                //error_log(print_r($questionsArray,1));
                $questionsArray = $this->get_values_for_keys($questionsArray, $questionsRandomKeys);
                $qn = array();
                $qn['CategoryName'] = $cat['CategoryName'];
                $qn['CategoryQuestions'] = array();
                //$qn['CategoryTime'] =  $cat['CategoryTime'];
                //$qn['CategoryScore'] =  $cat['CategoryScore'];
                //$qn['ReviewQuestion'] =  $cat['ReviewQuestion'];
                foreach ($questionsArray as $qstn) {                          //for each question
                    array_push($qn['CategoryQuestions'], $qstn["QuestionId"]);
                }
                array_push($questionArray, $qn);
            }
                $userQuestionsCollection = new UserQuestionsCollection();
                $userQuestionsCollection->UserId = $userId;
                $userQuestionsCollection->Testid = $testId;
                $userQuestionsCollection->Questions = $questionArray;
                $userQuestionsCollection->CreatedOn = new MongoDate(strtotime(date('Y-m-d', time())));
                $userQuestionsCollection->insert();
                if (isset($userQuestionsCollection->_id)) {   //Question Retrieving logic
                error_log("***********success" . $userQuestionsCollection->_id);
                $testquestionObj = UserQuestionsCollection::model()->getPreparedTest($userQuestionsCollection->_id);
                //error_log("****************PreparedObject".print_r($testquestionObj,1));
                $cmplteqstnArray = array();
                foreach ($testquestionObj->Questions as $qsn) {
                    $questionobj = ExtendedSurveyCollection::model()->getQuestionById($qsn['CategoryName'], $qsn['CategoryQuestions']['0']);
                    $c = ExtendedSurveyCollection::model()->getCollection();
                    $result = $c->aggregate(array('$match' => array('SurveyTitle' => $qsn['CategoryName'])), array('$unwind' => '$Questions'), array('$match' => array('Questions.QuestionId' => new MongoID($qsn['CategoryQuestions']['0']))), array('$skip' => 0), array('$limit' => 1), array('$group' => array("_id" => '$Testid', "DefaultQuestion" => array('$push' => '$Questions'))));
                    $userAnswerArray = "";
                    if (is_array($result['result'][0]["DefaultQuestion"])) {
                        $userAnswerArray = $result['result'][0]["DefaultQuestion"][0];
                    }
                    //error_log("xxxx--" . print_r($userAnswerArray, 1));
                    break;
                }
                } else {
                    return "fail";
                }

                // $extObj->Questions =  $cmplteqstnArray;
              $this->render('questionpaperview', array("viewObj" => $testquestionObj, "defaultQuestion" => $userAnswerArray));
            } catch (Exception $ex) {
                Yii::log("QuestionpaperController:actionQuestionpaperview::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
            }
    }

    function get_values_for_keys($mapping, $keys) {
        foreach ($keys as $key) {
            $output_arr[] = $mapping[$key];
        }
        return $output_arr;
    }
    public function actionQuestion(){
        try{
        //error_log("^^^^^^^^^actionQuestion".$_REQUEST['qstnId']);
        $qid = $_REQUEST['qstnId'];
        $catname = $_REQUEST['catName'];
        // error_log("^888888888888actionQuestion".$_REQUEST['qstnId']);
        
        $questionobj = ExtendedSurveyCollection::model()->getQuestionById($catname, $qid);
        
        $obj = array('status' => 'success', 'data'=>$questionobj);
         //$obj = $this->render('questionview', array("data" => $questionobj));      
         error_log("%%%%%%%%");
             echo CJSON::encode($obj);
        //$this->renderPartial('questionpaperview', array('data' => 'success'));
        } catch (Exception $ex) {
                Yii::log("QuestionpaperController:actionQuestion::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
                error_log("Exception Occurred in  QuestionpaperController->actionQuestion==" . $ex->getMessage());
                
        }         
    }

}
