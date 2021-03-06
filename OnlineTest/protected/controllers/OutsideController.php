<?php

class OutsideController extends Controller {
    
    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }
    public function init() {        
        try{
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');   
        $urlArray =  explode("/", Yii::app()->request->url);            
        $userId = isset($urlArray[2])?$urlArray[2]:"";
        $groupName = isset($urlArray[3])?$urlArray[3]:"";
        $outerFlag = isset($urlArray[4])?$urlArray[4]:false;
         //$this->layout = 'userLayout';
        if(isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj']) && $outerFlag == false){
            parent::init();
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            $_REQUEST['UserId'] = $this->tinyObject->UserId;
        }else{    
//            if($outerFlag == true || $outerFlag == "true"){
//                $this->layout = 'externalLayout';
//            }else{
//                $urlPath = $_SERVER['REQUEST_URI'];
//                $urlArr = explode("/", $urlPath);
//                $surveyGroupName = $urlArr[3]; 
//               //  Yii::app()->session['returnUrl'] = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
//                 // Yii::app()->request->cookies['r_u'] = new CHttpCookie('r_u',  parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH));
//                $this->redirect(array("/common/postDetail","bundle"=>$surveyGroupName));
//            }
        }
        } catch (Exception $ex) {
            Yii::log("OutsideController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex1() {
        try {
            $urlArray =  explode("/", Yii::app()->request->url);            
            $userId = isset($urlArray[2])?$urlArray[2]:"";
            $groupName = isset($urlArray[3])?$urlArray[3]:"";
            $outerFlag = isset($urlArray[4])?$urlArray[4]:false;
            $vType = isset($urlArray[5])?$urlArray[5]:"1";
            if($outerFlag){  
                $this->layout = 'externalLayout';
            } 
            //$this->layout = 'externalLayout';
//            $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('GroupName',"Amgen");            
            $QuestionsSurveyForm = new QuestionsSurveyForm;
            $this->render('index',array('QuestionsSurveyForm'=>$QuestionsSurveyForm,"userId" => $userId,"groupName"=>$groupName,"outerFlag" => $outerFlag,"vType"=>$vType));
        } catch (Exception $ex) {
            Yii::log("OutsideController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
       
    
    public function actionIndex() {
        try {
            error_log("---after index call----");
            $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;            
            $vType = "1";
            $testId = "";
            $state='';
           // echo session_id()."===".$userId;
            if($userId==''){
             $this->redirect('/site/register');
            }else{
            $testRegObj = ServiceFactory::getTO2TestPreparaService()->getTestIdByUserId($userId);
            if(isset($testRegObj) && sizeof($testRegObj)>0){
                $testId = $testRegObj->TestId;
            }     
            $this->layout = 'adminLayout';
               $questionprepareObj = TestPreparationCollection::model()->getTestDetails($testId);
//            $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('GroupName',"Amgen");   
            $UTestObj = ServiceFactory::getTO2TestPreparaService()->getUserTestObjectByUserIdTestId($userId,$testId);
            if(isset($UTestObj->UserId) && $UTestObj->Status == 0){
                $questionprepareObj = TestPreparationCollection::model()->getTestDetails($testId);                
                $QuestionsSurveyForm = new QuestionsSurveyForm;
                $this->render('index',array('QuestionsSurveyForm'=>$QuestionsSurveyForm,"userId" => $userId,"groupName"=>$groupName,"outerFlag" => $outerFlag,"vType"=>$vType,"TestId"=>$testId,"CatName"=>array()));
            }else{
                $this->render('submissionerror');
            }  
        }
            } catch (Exception $ex) {
            Yii::log("OutsideController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function PrepareQuestionObjectsByScore($questionsArray,$cat,$questionArray,$categoryId,$totalquestions,$totalMarks,$qn,$pushedQuestions,$remaingQuestions=array(),$offSet){
        try{            
            foreach ($questionsArray as $qstn) {     
                //for each question
                 $qdensity = 0;
                 $isExit = 0;
                 if($qstn['IsSuspended']!=1){
                   if($qstn['QuestionType'] == 1 || $qstn['QuestionType'] == 2 || $qstn['QuestionType'] == 5 || $qstn['QuestionType'] == 6 || $qstn['QuestionType'] == 7 || $qstn['QuestionType'] == 8){
                        $qsCnt = 0;
                       
                        $qsCnt = (1+$totalquestions);
                        if($qsCnt <= $cat['NoofQuestions'] ){ 
                            $qdensity = 1;
                            $totalquestions = $qsCnt;
                          
                        }else{
                            $isExit = 1;
                                    //continue;
                                }
                    }else{
                        if($qstn['QuestionType'] == 3){
                            $qsCnt = 0;
                            $qsCnt = ($qstn['NoofOptions']+$totalquestions);
                            $qdensity = $qstn['NoofOptions'];
                            if($qsCnt <= $cat['NoofQuestions'] ){ 
                                
                                $totalquestions = $qsCnt;                                
                            }else{
                                $isExit = 1;
                                    //continue;
                                }
                        }else if($qstn['QuestionType'] == 4){
                            $qsCnt = 0;                            
                            if($qstn['MatrixType'] == 2){
                                $qdensity = $qstn['NoofOptions'];
                                $qsCnt = ($qstn['NoofOptions']+$totalquestions);
                                if($qsCnt <= $cat['NoofQuestions'] ){ 
                                    $totalquestions = $qsCnt;
                                }else{
                                    $isExit = 1;
                                    //continue;
                                }
                            }else if($qstn['MatrixType'] == 3){
                                $qsCnt = ($qstn['NoofOptions'] * $qstn['NoofRatings'])+$totalquestions;
                                $qdensity = ($qstn['NoofOptions']* $qstn['NoofRatings']);
                                if($qsCnt <= $cat['NoofQuestions'] ){ 
                                    $totalquestions = $qsCnt;                                    
                                }else{
                                    $isExit = 1;
                                   // continue;
                                }
                            }
                        }
                    }
                    if(($totalquestions != 0 && $totalquestions <= $cat['NoofQuestions'] && $isExit == 0) ){
                        $pushedQuestions[(string)$qstn["QuestionId"]] = $qdensity;
                       
                        array_push($qn['CategoryQuestions'], (string)$qstn["QuestionId"]);                       
                       
                    }else{
                       
                        if($qdensity>=$totalquestions)
                        { 
                            continue;}
                        $removeddensity = ($qdensity+$totalquestions)-$cat['NoofQuestions']; 
                       $key = array_search($removeddensity,$pushedQuestions); 
                       if($key == ""){
                           $totalarray = array_values($pushedQuestions);
                           $sum = 0;
                            $ourvalue = $removeddensity;
                            $removedKeys = array();
                            foreach($totalarray as $key=>$value){
                                if($value < $ourvalue && $sum <= $ourvalue){
                                    if($sum+$value <= $ourvalue){
                                         $sum += $value;     
                                         $totalquestions -= $value;
                                         array_push($removedKeys, $value);
                                    }
                                }
                            }
                            
                            foreach($removedKeys as $k=>$v){            
                         //      unset($qn['CategoryQuestions'][$v]);
                                
                                $mkey = array_search($v,$pushedQuestions);
                               $lkey = array_search($mkey,$qn['CategoryQuestions']);

                                 unset($qn['CategoryQuestions'][$lkey]);
                                 unset($pushedQuestions[$mkey]);
                             }
                             $pushedQuestions[(string)$qstn["QuestionId"]] = $qdensity;
                            $totalquestions+=$qdensity;
                            array_push($qn['CategoryQuestions'], (string)$qstn["QuestionId"]);  
                           
                        }else{
                               $mkey = array_search($key,$qn['CategoryQuestions']);
                                unset($qn['CategoryQuestions'][$mkey]);
                            $totalquestions+=$qdensity;
                            $totalquestions-=$removeddensity;

                            
                            array_push($qn['CategoryQuestions'], (string)$qstn["QuestionId"]); 
                        }
                        break;
                      //  if($totalquestions==)
                        
                    }
                 }
                }     
               $qn['CategoryQuestions'] =array_values($qn['CategoryQuestions']);
                foreach($qn['CategoryQuestions']  as $k1=>$v1){
                    $qn['CategoryQuestions'][$k1]=new MongoId((String) $v1);
                    
                }
                                     array_push($questionArray, $qn);
   
                if( $totalquestions < $cat['NoofQuestions']){  
//                    $quesitonsset = $cat['NoofQuestions'];
//                    if(sizeof($remaingQuestions) == 0){
//                        $questionsobj = ExtendedSurveyCollection::model()->getCategoryDetails($cat['CategoryName'],$cat['NoofQuestions'],$offSet);
//                        $categoryId = (string)$questionsobj[0]['_id'];
//                        $remaingQuestions = $questionsobj[0]['Questions'];
//                    }
//                    $questionsRandomKeys = array();
//                    
//                    if(sizeof($remaingQuestions) > 1){
//                        $questionsRandomKeys = array_rand($remaingQuestions, $quesitonsset);
//                    }else{
//                        $questionsRandomKeys = array_keys($remaingQuestions);
//                    }
//                    
//                    $remaingQuestions = $this->get_values_for_keys($remaingQuestions, $questionsRandomKeys);
//
//                    $this->PrepareQuestionObjectsByScore($remaingQuestions, $cat, $questionArray, $categoryId, $totalquestions, $totalMarks, $qn, $pushedQuestions,$remaingQuestions,$offSet);
//                    
                }
                //                exit();
                
                return $questionArray;
        } catch (Exception $ex) {

        }
    }
    
    
    public function prepareTempQuestions($questionObject=array(),$userId,$testId){
        try{            
            $questionArray = array();
            foreach ($questionObject->Category as $cat) {               //for each category
             
                $res = ExtendedSurveyCollection::model()->getCategoryDetails($cat['CategoryName'],$cat['NoofQuestions'],0);
                $questionsobj = $res['result'];
                $offSet = $res['offset'];
                $categoryId = (string)$questionsobj[0]['_id'];
                $questionsArray = $questionsobj[0]['Questions'];
                $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$cat['ScheduleId']); 
                $sessionTime = SurveyUsersSessionCollection::model()->manageSurveyUserSession($cat['CategoryId'],$userId,$obj);
                $questionsRandomKeys = array();
                $quesitonsset = $cat['NoofQuestions'];                
                if(sizeof($questionsArray) > 1){
                    $questionsRandomKeys = array_rand($questionsArray, $quesitonsset);
                }else{
                    $questionsRandomKeys = array_keys($questionsArray);
                }
                $questionsArray = $this->get_values_for_keys($questionsArray, $questionsRandomKeys);
                $totalquestions = 0;
                $totalMarks = 0;
                $qn = array();
                $qn['CategoryName'] = $cat['CategoryName'];
                $qn['CategoryTime'] = $cat['CategoryTime']*60;
                $qn['CategoryId'] = new MongoId($categoryId); // _id => CatId...
                $qn['ScheduleId'] = ServiceFactory::getTO2TestPreparaService()->getScheduleIdByCatName($cat['CategoryName'],$testId);
                $qn['CategoryQuestions'] = array();
                $pushedQuestions = array();
                $tQuestionsArray  = $questionsobj[0]['Questions'];
                if(sizeof($questionsRandomKeys) > 0){
                    foreach($questionsRandomKeys as $k=>$va){
                        unset($tQuestionsArray[$va]);
                    }
                }
                $questionArray = $this->PrepareQuestionObjectsByScore($questionsArray,$cat,$questionArray,$categoryId,$totalquestions,$totalMarks,$qn,$pushedQuestions,$tQuestionsArray,$offSet);
            }
           try{
                $userQuestionsCollection = new UserQuestionsCollection();
                $userQuestionsCollection->UserId = (int)$userId;
                $userQuestionsCollection->Testid = new MongoId($testId);               
                $userQuestionsCollection->Questions = $questionArray;
                $userQuestionsCollection->CreatedOn = new MongoDate();
                $resultantobj = ServiceFactory::getTO2TestPreparaService()->saveQuestionsToCollection($userQuestionsCollection);
            }catch(Exception $qex){
            }
            return $resultantobj;
        } catch (Exception $ex) {

        }
    }
    
    public function actionRenderQuestionView(){
        try{
            $surveyGroupName = $_REQUEST['GroupName'];
            $UserId = isset($_REQUEST['UserId'])?$_REQUEST['UserId']:1; // userId... 
            $surveyObj = "";
            $errMessage = "";
            $scheduleId = "";
            $viewType = $_REQUEST['viewType'];
            $testId = $_REQUEST['TestId'];
            $questionprepareObj = TestPreparationCollection::model()->getTestDetails($testId);
//            //$questionprepareObj = TestPreparationCollection::model()->find($criteria);
            $testquestionObj = UserQuestionsCollection::model()->getTestAvailable($UserId,$testId);
            
            if($testquestionObj == "failure"){
              $testquestionObj = $this->prepareTempQuestions($questionprepareObj,$UserId,$testId); // saving temp. test for a user and fetching saved obj...           
              $testquestionObj = UserQuestionsCollection::model()->getTestAvailable($UserId,$testId);

             }
             
            $pageno = 0;
            $surveyObjArray = ServiceFactory::getTO2TestPreparaService()->getQuestionFromCollection($testquestionObj->Questions,$pageno);
            $surveyObj = $surveyObjArray["data"];
            $categoryId = $surveyObjArray["categoryId"];
            $scheduleId = $surveyObjArray["scheduleId"];
            $cmplteqstnArray = array();
            $totalPages = 1;
            $nocategories = "false";
            if(isset($testquestionObj) && $testquestionObj != "failure"){
                $totalPages =  sizeof($testquestionObj->Questions[0]['CategoryQuestions']);
                $nocategories = isset($testquestionObj->Questions[1])?"false":"true";
            }
            $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$scheduleId); 
                    
            $QuestionsSurveyForm = new QuestionsSurveyForm;
            $bufferAnswers =  SurveyUsersSessionCollection::model()->getAnswersForSurvey($UserId,$scheduleId);
                //$catHtml = $this->renderPartial("quesitoncategories",array("CatName"=>$testquestionObj->Questions),1);
                
                
            $this->renderPartial('userCustomView',array("UserTempId"=>$testquestionObj->_id,"surveyObj"=>$surveyObj,"categoryId"=>$categoryId,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"errMessage"=>"Test","userId"=>$UserId,"sessionTime"=>"","spotMessage"=>"","flag"=>"TRUE","iValue"=>0,"page"=>($pageno+1),"bufferAnswers"=>$bufferAnswers,"totalpages"=>$totalPages,"sno"=>($pageno+1),"catPosition"=>"first","nocategories"=>$nocategories));
        } catch (Exception $ex) {
            error_log("Exception Occurred in OutsideController->actionRenderQuestionView==".$ex->getMessage());
            Yii::log("OutsideController:actionRenderQuestionView::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
function get_values_for_keys($mapping, $keys) {
    try{
        foreach ($keys as $key) {            
            $output_arr[] = $mapping[$key];
        }
        return $output_arr;
    }catch(Exception $ex){
        error_log("#########Exception Occurred=get_values_for_keys==".$ex->getMessage());
    }
    }
    public function actionUnsetSpotForUser(){
        try{
         $userId = $_POST["userId"];
            $scheduleId = $_POST["scheduleId"];
         SurveyUsersSessionCollection::model()->unsetSpotForUser($userId,$scheduleId);
         } catch (Exception $ex) {
            Yii::log("OutsideController:actionUnsetSpotForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionSureyQuestionPagination(){
        try{ 
              $QuestionsSurveyForm = new QuestionsSurveyForm;
              
            $scheduleId = $_REQUEST['scheduleId'];
            $surveyId = $_REQUEST['surveyId'];
            $page = $_REQUEST['page'];
             $action = $_REQUEST['action'];
             $UserId = isset($_REQUEST['UserId'])?$_REQUEST['UserId']:1; // userId... 
              //$userId = $this->tinyObject['UserId'];
            CommonUtility::trackSurvey($userId,$scheduleId,$surveyId,$page,$action);
            $surveyObjArray = ServiceFactory::getSkiptaExSurveyServiceInstance()->getCustomSurveyDetailsById('Id',$surveyId,$scheduleId,$page);            
             $surveyObj = $surveyObjArray["extObj"];
             $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$scheduleId); 
            if($obj->MaxSpots > 0){
              $spotsCount = SurveyUsersSessionCollection::model()->getSpotsAvailabeForScheduledSurvey($obj,$surveyId);  
                if($spotsCount>=0){
                          $spotMessage =  CommonUtility::getSpotMessage($spotsCount,$obj->MaxSpots);
                } 
              }else{
                  $spotMessage = "";
              }
            $bufferAnswers =  SurveyUsersSessionCollection::model()->getAnswersForSurvey($userId,$scheduleId);
            //$obj->UserAnswers =  $bufferAnswers ;  
            $totalPages =  0;
            if($obj->QuestionView > 0){
             $totalPages = round($surveyObj->QuestionsCount/$obj->QuestionView);
            }
             $this->renderPartial('userCustomView',array("surveyObj"=>$surveyObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"userId"=>$userId,"sessionTime"=>"","spotMessage"=>$spotMessage,"flag"=>$surveyObjArray["flag"],"iValue"=>$surveyObjArray["i"],"page"=>$page+1,"bufferAnswers"=>$bufferAnswers,"totalpages"=>$totalPages));
             
        } catch (Exception $ex) {
            error_log("Exception Occurred in OutsideController->actionSureyQuestionPagination==".$ex->getMessage());
            Yii::log("OutsideController:actionSureyQuestionPagination::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 
     }
 public function actionSureyQuestionPagination1(){
        try{ 
              $QuestionsSurveyForm = new QuestionsSurveyForm;
              
            $scheduleId = $_REQUEST['scheduleId'];
            $userQuestionTempId = $_REQUEST['userQuestionTempId'];
            $page = $_REQUEST['page'];
             $categoryId = $_REQUEST['categoryId'];
             $action = $_REQUEST['action'];
             $UserId = isset($_REQUEST['UserId'])?$_REQUEST['UserId']:1; // userId... 
          //   CommonUtility::trackSurvey($UserId,$scheduleId,$categoryId,$page,"");
                $surveyObjArray = ServiceFactory::getSkiptaExSurveyServiceInstance()->getCustomSurveyDetailsById('Id',$userQuestionTempId,$scheduleId,$page,$categoryId,$action);            
                       
            $bufferAnswers = array();
             $surveyObj = $surveyObjArray["data"];
             $categoryId = $surveyObjArray["categoryId"];
             $nocategories = $surveyObjArray['nocategories'];
             $page = $surveyObjArray["page"];
             $totalPages = $surveyObjArray['totalpages'];
             $scheduleId = $surveyObjArray['scheduleId'];
             $catIdsArray = $surveyObjArray['catIdsArray'];
             $catPosition = $surveyObjArray['catPosition'];
             $bufferAnswers =  SurveyUsersSessionCollection::model()->getAnswersForSurvey($UserId,$scheduleId);
             $this->renderPartial('userCustomView',array("UserTempId"=>$userQuestionTempId,"surveyObj"=>$surveyObj,"categoryId"=>$categoryId,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"userId"=>$UserId,"sessionTime"=>"","spotMessage"=>"","flag"=>$surveyObjArray["flag"],"iValue"=>$surveyObjArray["i"],"page"=>$page+1,"bufferAnswers"=>$bufferAnswers,"totalpages"=>$totalPages,"nocategories"=>$nocategories,"sno"=>($page+1),"catPosition"=>$catPosition));
             
        } catch (Exception $ex) {
            error_log("Exception Occurred in OutsideController->actionSureyQuestionPagination==".$ex->getMessage());
            Yii::log("OutsideController:actionSureyQuestionPagination::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 
     }
    public function actionValidateSurveyAnswersQuestion(){
        try{       
              error_log("******SURESH**********I am match".$_REQUEST['finalDone']);
//            ini_set('memory_limit', '2048M');
            $QuestionsSurveyForm = new QuestionsSurveyForm();
            if(isset($_POST['QuestionsSurveyForm'])){
                   $QuestionsSurveyForm->attributes = $_POST['QuestionsSurveyForm'];  
                   $UserId = $QuestionsSurveyForm->UserId;
                   $categoryId = $QuestionsSurveyForm->SurveyId;
                    $time = $QuestionsSurveyForm->Time;
                   $f =  json_decode($QuestionsSurveyForm->Questions);
                   $questionTempId = 0;
                   if(isset($_REQUEST['QuestionTempId'])){
                        $questionTempId = $_REQUEST['QuestionTempId'];
                    }
                    $userQuestionObj = array();
                    if($questionTempId != 0){
                        $userQuestionObj = UserQuestionsCollection::model()->getPreparedTest($questionTempId);
                        UserQuestionsCollection::model()->updateTimeStamp($categoryId,$questionTempId,$time);
                        $questionprepareObj = TestPreparationCollection::model()->getTestDetails($userQuestionObj->Testid);
                        $eachQuestionScore=0;
                        foreach ($questionprepareObj->Category as $row){
                          if((String)$row['ScheduleId']==$QuestionsSurveyForm->ScheduleId)  {
                              $eachQuestionScore=$row['CategoryScore']/$row['NoofQuestions'];
                              break;
                          }
                        }
                    }
                    $questionArray = array();
                    $OptionsSelected = FALSE;
                    for($i=0;$i<sizeof($f);$i++){                           
                    $searcharray=array();                    
                    parse_str($f[$i],$searcharray);
                    $ExUserAnswerBean = new ExUserAnswersBeans();
                    $widget12 = new ExUserWidget12Bean();
                    $widget34 = new ExUserWidget34Bean();
                    $widget5 = new ExUserWidget5();
                    $widget6 = new ExUserWidget6();
                    $widget7 = new ExUserWidget7();
                    $optionsArray = array();
                    $questionType = 0;    
                    $questionId = "";
                    if(sizeof($searcharray["QuestionsSurveyForm"])){                        
                        foreach($searcharray["QuestionsSurveyForm"] as $key=>$value){
                            $optioncnt = 0;
                        if(is_array($value) && sizeof($value)){  
                            if($key == "WidgetType"){
                                if(sizeof($value)>0){
                                    foreach($value as $m){
                                        $questionType =  $m;
                                        if($m == 1 || $m == 2){
                                            $widget12->QuestionType = (int) $m;
                                        }else if($m == 3 || $m == 4){
                                            $widget34->QuestionType = (int) $m;
                                        }else if($m == 5){
                                            $widget5->QuestionType = (int) $m;
                                        }else if($m == 6){
                                            $widget6->QuestionType = (int) $m;
                                        }else if($m == 7){
                                            $widget7->QuestionType = (int) $m;
                                        }
                                        
                                    }
                                }
                                }
                                if($key == "IsReviewed"){
                                    if(sizeof($value)>0){                                        
                                        foreach($value as $m){  
                                            $widget12->IsReviewed = (int)$m;
                                            $widget34->IsReviewed = (int)$m;
                                            $widget5->IsReviewed = (int)$m;
                                            $widget6->IsReviewed = (int)$m;
                                            $widget7->IsReviewed = (int)$m;
                                        }
                                    }
                                }

                                            $widget12->IsCompleted = (int)$QuestionsSurveyForm->IsCompleted;
                                            $widget34->IsCompleted = (int)$QuestionsSurveyForm->IsCompleted;
                                            $widget5->IsCompleted = (int)$QuestionsSurveyForm->IsCompleted;
                                            $widget6->IsCompleted = (int)$QuestionsSurveyForm->IsCompleted;
                                            $widget7->IsCompleted = (int)$QuestionsSurveyForm->IsCompleted;
                                
                                if($key == "QuestionId"){
                                    if(sizeof($value)>0){
                                        foreach($value as $m){                                        
                                            if($questionType == 1 || $questionType == 2){
                                                $widget12->QuestionId = new MongoId($m);
                                            }else if($questionType == 3 || $questionType == 4){
                                                $widget34->QuestionId = new MongoId($m);
                                            }else if($questionType == 5){
                                                $widget5->QuestionId = new MongoId($m);
                                            }else if($questionType == 6){
                                                $widget6->QuestionId = new MongoId($m);
                                            }else if($questionType == 7){
                                                $widget7->QuestionId = new MongoId($m);
                                            }
                                            $questionId = new MongoId($m);
                                        }
                                    }
                                }
                           error_log("==122222222222222222222========questiontype======++++#$questionType");
                            
                            if($key == "OptionsSelected"){
                                $k=0;
                                if(sizeof($value)>0){
                                    
                                foreach($value as $m){       
                                    if($questionType == 1 || $questionType == 2){ 
                                        if(!empty($m)){
                                            $OptionsSelected = TRUE;
                                        }
                                            $widget12->SelectedOption = explode(",",$m); 
                                            if($widget12->IsReviewed == 0){ 
                                                $questionAns = CommonUtility::getAnswersByQuestionId($categoryId,$widget12->QuestionId);
                                                $result = array_intersect($questionAns, $widget12->SelectedOption);
                                                if(sizeof($widget12->SelectedOption) == sizeof($result)){
                                                     $widget12->Score = (int)$eachQuestionScore;   
                                                }
                                            }
                                    }
                                    else if($questionType == 3 || $questionType == 4){
                                        if(!empty($m)){
                                            $OptionsSelected = TRUE;
                                        }
                                        $optionsArray = explode(",",$m);                                        
                                        $widget34->Options = $optionsArray;
                                        
 
                                        
                                        $optioncnt = sizeof($widget34->Options);       
                                        if($widget34->IsReviewed == 0){
                                            $questionAns = CommonUtility::getAnswersByQuestionId($categoryId,$widget34->QuestionId);
                                            $result = array_intersect($questionAns, $widget34->Options);
                                            
                                                 
                                                 $widget34->Score = (int) sizeof($result)*$eachQuestionScore;
                                           
                                        }
                                        
                                            
                                    }
                                    $k++;

                                }
                                }
                                
                            }                            
                            if($key == "Other"){
                                $k=0;
                                if(sizeof($value)>0){
                                foreach($value as $m){
                                    if($questionType == 1 || $questionType == 2)                                          
                                        $widget12->Other = (int) $m;
                                    else if($questionType == 3 || $questionType == 4)                                          
                                        $widget34->Other = (int) $m;
                                    else if($questionType == 5 ){
                                        $widget5->Other = (int) $m;
                                        
                                        
                                    }
                                }
                                }

                            }
                            if($key == "OtherValue"){
                                $k=0;
                                if(sizeof($value)>0){
                                foreach($value as $m){
                                    if($questionType == 1 || $questionType == 2) 
                                        $widget12->OtherValue = $m;   
                                    else if($questionType == 5 )                                          
                                        $widget5->OtherValue =  $m;
                                }
                                }

                            }
                            if($key == "DistValue"){
                                $k=0;
                                if(sizeof($value)>0){
                                foreach($value as $m){
                                    if($questionType == 5){
                                        if(empty($m)){
                                            $m = "0";
                                        }
                                         if(!empty($m)){
                                            $OptionsSelected = TRUE;
                                        }
                                        $widget5->DistributionValues[$k++] = $m;                                        
                                    }
                                }
                                if($questionType == 5 && $widget5->IsReviewed == 0){                                    
                                        $questionAns = CommonUtility::getAnswersByQuestionId($categoryId,$widget5->QuestionId);
                                        $result = array_intersect($questionAns, $widget5->DistributionValues);
                                        if(sizeof($result) == sizeof($widget5->DistributionValues)){
                                             $widget5->Score = (int)$eachQuestionScore;
                                        }
                                    }
                                }
                            }
                            if($key == "UsergeneratedRanking"){
                                $k=0;  
                                if(sizeof($value)>0){
                                foreach($value as $m){
                                    if(!empty($m)){
                                            $OptionsSelected = TRUE;
                                        }
                                    if($questionType == 7){                                        
                                        $widget7->UsergeneratedRankingOptions[$k++] = $m;  
                                        //$widget7->Score = 0;
                                    }
                                }
                                 if($questionType == 7 && $widget7->IsReviewed == 0){     
                                     $questionAns = CommonUtility::getAnswersByQuestionId($categoryId,$widget7->QuestionId);
                                        $result = array_intersect($questionAns, $widget7->UsergeneratedRankingOptions);
                                        if(sizeof($result) == sizeof($widget7->UsergeneratedRankingOptions)){
                                             $widget5->Score = (int)$eachQuestionScore;
                                        }
                                 }
                                }
                            }
                            if($key == "UserAnswer"){
                                $k=0;
                                if(sizeof($value)>0){
                                foreach($value as $m){
                                    if(!empty($m)){
                                            $OptionsSelected = TRUE;
                                        }
                                    if($questionType == 6)
                                        $widget6->UserAnswer = $m;                                       
                                }
                                    if($questionType == 6 && $widget6->IsReviewed == 0){   
                                        $questionAns = CommonUtility::getAnswersByQuestionId($categoryId,$widget6->QuestionId);
                                        $result = array_intersect($questionAns, array($widget6->UserAnswer));
                                        if(sizeof($result) == sizeof(array($widget6->UserAnswer))){
                                             $widget6->Score = (int)$eachQuestionScore;
                                        }
                                    }
                                }
                            }
                            if($key == "OptionCommnetValue"){
                                $k=0;
                                if(sizeof($value)>0){                                   
                                foreach($value as $m){ 
                                     if($questionType == 3 || $questionType == 4){  
                                         if($m != ""){
                                            array_push($widget34->OptionCommnets,$m); 
                                         }else{
                                            array_push($widget34->OptionCommnets,$m); 
                                         }                                                                                        

                                    }
                                    $k++;

                                }
                                }
                            }

                            if($key == "AnyOtherComment"){
                                $k=1;
                                if(sizeof($value)>0){ 
                                    $otherOpt = array();
                                foreach($value as $m){ 
                                     if($questionType == 3 || $questionType == 4){  
                                         if($m != ""){                                                                                        
                                            array_push($widget34->AnyOtherComment,$m); 
                                            array_push($otherOpt,$k);                                            
                                         }
                                    }
                                    $k++;

                                }
                                $widget34->Options[sizeof($widget34->Options)] = $otherOpt;                                
                                }
                            }
                            
                            if($key == "OptionTextValue"){
                                $k=1;
                                if(sizeof($value)>0){ 
                                    $otherOpt = array();
                                    foreach($value as $m){ 
                                         if($questionType == 3 || $questionType == 4){  
                                             if($m != ""){                                                                                        
                                                $widget34->OptionOtherTextValue = $m; 

                                             }
                                        }
                                        $k++;

                                    }
                                                                
                                }
                            }
                            if($key == "TextOptionValues"){
                                $k=1;
                                if(sizeof($value)>0){ 
                                    $OptionOtherTextA = array();                                    
                                    $uKey = 0;
                                    $vstr = "";                                    
                                    foreach($value as $ky=>$v){
                                       $kArr = explode("_",$ky); 
                                        if($uKey == 0){
                                           $uKey = $kArr[0]; 
                                        }
                                        if($uKey != $kArr[0]){
                                            $uKey = $kArr[0];
                                            array_push($OptionOtherTextA,$vstr);
                                            $vstr = "";                                           
                                        }
                                        
                                        if($uKey == $kArr[0]){
                                            if($vstr == "")
                                                $vstr = $v;
                                            else{
                                                $vstr = "$vstr,$v";
                                            }
                                            
                                        }
                                        
                                    }
                                    array_push($OptionOtherTextA,$vstr);                                      
                                    $j = 0;
                                    foreach($OptionOtherTextA as $m){ 
                                         if($questionType == 3 || $questionType == 4){                                               
                                             if($m != ""){                                                                                        
////                                                $widget34->OptionOtherTextValue = $m;                                                  
                                                //array_push($OptionOtherTextA,$m);                                                 
                                                 $optionsArray = explode(",",$m);  
                                                 $widget34->Options[$j++] = $optionsArray;                                                 
                                             }else{
                                                 $widget34->Options[$j++] = 0;
                                            }
                                        }
                                        $k++;

                                        
                                    }
                                    if($widget34->IsReviewed == 0){
                                            $questionAns = CommonUtility::getAnswersByQuestionId($categoryId,$widget34->QuestionId);
                                            $result = $this->recursive_array_intersect_key($questionAns, is_array($widget34->Options)?$widget34->Options:array());
                                         //   if(sizeof($widget34->Options) == sizeof($result)){                                      
                                                 $widget34->Score = (int)$result*$eachQuestionScore;
                                          //  }
                                        }
                                    //$widget34->UserTextValue = $OptionOtherTextA;                                    
                                                                
                                }
                            }
                            if($key == "OptionMatrixValueOther"){
                                $k=1;
                                if(sizeof($value)>0){ 
                                    $OptionOtherTextA = array();                                    
                                    $uKey = 0;
                                    $vstr = "";                                    
                                    foreach($value as $ky=>$v){
                                       $kArr = explode("_",$ky); 
                                        if($uKey == 0){
                                           $uKey = $kArr[0]; 
                                        }
                                        if($uKey != $kArr[0]){
                                            $uKey = $kArr[0];
                                            array_push($OptionOtherTextA,$vstr);
                                            $vstr = "";                                           
                                        }
                                        
                                        if($uKey == $kArr[0]){
                                            if($vstr == "")
                                                $vstr = $v;
                                            else{
                                                $vstr = "$vstr,$v";
                                            }
                                            
                                        }
                                        
                                    }
                                    array_push($OptionOtherTextA,$vstr);  
                                    
                                    //$j = 0;
                                    foreach($OptionOtherTextA as $m){ 
                                         if($questionType == 3 || $questionType == 4){                                               
                                             if($m != ""){                                                                                        
////                                                $widget34->OptionOtherTextValue = $m;                                                  
                                                //array_push($OptionOtherTextA,$m);                                                 
                                                 $optionsArray = explode(",",$m);  
                                                 $widget34->Options[$j++] = $optionsArray;                                                 
                                             }else{
                                                 $widget34->Options[$j++] = 0;
                                            }
                                        }
                                        $k++;

                                    }
                                    //$widget34->UserTextValue = $OptionOtherTextA;                                    
                                                                
                                }
                            }
                            if($key == "OtherJustification"){
                                $widget12->QuestionType = (int) 8;
                            }
                            if($key == "SelectAll"){
                                 //$k=1;
                                 
                                foreach($value as $m){ 
                                     $widget12->SelectAll = (int)$m; 
                                    //$k++;

                                }                                   
                                                                
                                
                            }
                            
                            $OptionsSelected = TRUE;
                            if($questionType == 1 || $questionType == 2)
                                $widget12->UserId = (int) $UserId;
                            else if($questionType == 3 || $questionType == 4)
                                $widget34->UserId = (int) $UserId;
                            else if($questionType == 5)
                                $widget5->UserId = (int) $UserId;
                            else if($questionType == 6)
                                $widget6->UserId = (int) $UserId;
                            else if($questionType == 7)
                                $widget7->UserId = (int) $UserId;                            
                        }    

                    }
                    }
                    if($questionType == 1 || $questionType == 2)
                        array_push($questionArray,$widget12);
                    else if($questionType == 3 || $questionType == 4)
                        array_push($questionArray,$widget34);
                    else if($questionType == 5)
                        array_push($questionArray,$widget5);
                    else if($questionType == 6)
                        array_push($questionArray,$widget6);
                    else if($questionType == 7){
                        array_push($questionArray,$widget7);
                    }

                }
                $OptionsSelected = TRUE;
                $QuestionsSurveyForm->UserAnswers = $questionArray;
                if(!$OptionsSelected){
                    $obj = array("status"=>"error");
                    //echo "error";                    
                }else{
                    
                    
                    if(isset( $_REQUEST["fromPagination"])){
                          $fromPagination = $_REQUEST["fromPagination"];
                    }else{
                          $fromPagination = 0;
                    }                 
                    if(isset( $_REQUEST["fromAutoSave"])){
                          $fromAutoSave = $_REQUEST["fromAutoSave"];
                    }else{
                          $fromAutoSave = 0;
                    }
                     $fromPage = $_REQUEST["Page"];
                     $NetworkId=1;
                     $surveyObject = ServiceFactory::getSkiptaExSurveyServiceInstance()->saveSurveyAnswer($QuestionsSurveyForm,$NetworkId,$UserId,$fromPagination,$fromAutoSave,$fromPage,$questionTempId,$eachQuestionScore,$_REQUEST['finalDone']);


                     

                     if($fromAutoSave==0){
                     $exsurveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id',$surveyObject->SurveyId);  
                     $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$QuestionsSurveyForm->ScheduleId);                     
                     if ($fromPagination == 1 || $fromAutoSave == 1) {
                     }else{
                         $reg = TestRegister::model()->updateTestByUserId($UserId,2);
                         echo "success";
                     }
                     //$reValue = ServiceFactory::getSkiptaExSurveyServiceInstance()->getProfileDetails($UserId,$QuestionsSurveyForm->ScheduleId,$surveyObject->SurveyId);
                     
//                     if($exsurveyObj->IsAcceptUserInfo == 1 && $reValue == 0){
//                        $this->renderUserAcceptionInfo($surveyObject->SurveyId, $QuestionsSurveyForm->ScheduleId, $exsurveyObj->SurveyTitle);
//                     }else{
//                         if($obj->ShowThankYou == 1 || $exsurveyObj->IsAnalyticsShown == 0){                             
////                             if($fromAutoSave == 0)
////                                ScheduleSurveyCollection::model()->updateVisitedThankYouUsers($UserId,$QuestionsSurveyForm->ScheduleId);
//                            $this->renderPartial('thankyou',array('result'=>$obj,"ScheduleId"=>$QuestionsSurveyForm->ScheduleId,"IsAnalyticsShown"=>$exsurveyObj->IsAnalyticsShown));
//                        }else{
//                            $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id',$surveyObject->SurveyId); 
//
//                            $this->renderPartial('surveyView',array("surveyObj"=>$surveyObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$QuestionsSurveyForm->ScheduleId,"errMessage"=>"","userId"=>$UserId));
//                        }
//                     }
                        //$this->renderPartial('thankyou',array('result'=>$obj,"ScheduleId"=>$QuestionsSurveyForm->ScheduleId,"IsAnalyticsShown"=>$exsurveyObj->IsAnalyticsShown));
                     }
                    
                
                }
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in OutsideController->actionValidateSurveyAnswersQuestion==".$ex->getTraceAsString());
            Yii::log("OutsideController:actionValidateSurveyAnswersQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    function recursive_array_intersect_key($array1=array(), $array2=array()) {

    $matchedSize=0;
    for($i=0;$i<sizeof($array1);$i++){
        if(isset($array1[$i])  && isset($array2[$i] ) && (is_array($array1[$i])  && is_array($array2[$i]))){
         $matchedSize=$matchedSize+sizeof(array_intersect($array1[$i], $array2[$i]));
        }
    }
    return $matchedSize;
   
}
    public function decode_array($input) { 
        try{
                        $from_json =  json_decode($input, true);  
                        return $from_json ? $from_json : $input; 
                        } catch (Exception $ex) {
            Yii::log("OutsideController:decode_array::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
                    }
    public function actionValidateQuestions(){
        try{
            $QuestionsSurveyForm = new QuestionsSurveyForm();            
            $UserId = $this->tinyObject->UserId;
            if(isset($_POST['QuestionsSurveyForm'])){
                   $QuestionsSurveyForm->attributes = $_POST['QuestionsSurveyForm'];
                   $QuestionsSurveyForm->SurveyTitle = $_GET['surveyTitle'];
                   $QuestionsSurveyForm->SurveyDescription = $_GET['SurveyDescription'];
                   $QuestionsSurveyForm->QuestionsCount = questionsCount;
                   $QuestionsSurveyForm->SurveyRelatedGroupName = $_GET['SurveyGroupName'];
                   $QuestionsSurveyForm->SurveyLogo = $_GET['SurveyLogo'];
//                   if($ExtendedSurveyForm->SurveyLogo == ""){
//                       $common['ExtendedSurveyForm_SurveyLogo'] = "Please upload a survey logo";
//                   }else if($ExtendedSurveyForm->SurveyRelatedGroupName == "other" && $ExtendedSurveyForm->SurveyOtherValue == ""){
//                       $common['ExtendedSurveyForm_SurveyOtherValue'] = "Survey Other value cannot be blank";
//
//                   }else if($ExtendedSurveyForm->SurveyRelatedGroupName == ""){                    
//                       $common['ExtendedSurveyForm_SurveyRelatedGroupName'] = "Please choose Survey related group";
//                   }else{
//                       $common['ExtendedSurveyForm_SurveyOtherValue'] = "";
//                       $common['ExtendedSurveyForm_SurveyRelatedGroupName'] =  "";
//                       $common['ExtendedSurveyForm_SurveyLogo'] = "";
//                   }                

//                   $QuestionsSurveyForm->IsMadatory
//                   foreach($QuestionsSurveyForm->IsMadatory as $row){
//                   }
                   $errors = CActiveForm::validate($QuestionsSurveyForm);

                if($errors != '[]'){
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors,'oerror'=>$common);
                }else{
                    $obj = array('status' => 'success', 'data' => '', 'error' => "");
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
                   
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in OutsideController->actionValidateQuestions==".$ex->getMessage());
            Yii::log("OutsideController:actionValidateQuestions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionRenderSurveyView(){
        try{
            
            $this->renderPartial('surveyView',array("surveyObj"=>$surveyObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"errMessage"=>$errMessage,"userId"=>$UserId));
        } catch (Exception $ex) {
            Yii::log("OutsideController:actionRenderSurveyView::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionCaptureUserInfo(){
        try{
            $userInfo = new MarketResearchFollowUpForm();
            $UserId = $this->tinyObject->UserId;
            
            $reValue = ServiceFactory::getSkiptaExSurveyServiceInstance()->getProfileDetails($UserId,$userInfo->ScheduleId,$userInfo->SurveyId);
            if( $reValue == 0){
                
                if(!isset($_POST['MarketResearchFollowUpForm']) ){
//                    $surveyId = $_GET['sid'];
//                    $scheduleId  = $_GET['ssid'];
//                    $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserDetailsByUserId($UserId);
//                    $userInfo->FirstName = $userObj->FirstName;
//                    $userInfo->LastName = $userObj->LastName;
//                    $userInfo->City = $userObj->City;
//                    $userInfo->State = $userObj->State;
//                    $userInfo->Zip = $userObj->Zip;
//                    $userInfo->SurveyId = $surveyId;
//                    $userInfo->ScheduleId = $scheduleId;
//                    $userProfileDetails=ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($UserId);       
//                    $displayName = $userProfileDetails->DisplayName;
//                    $profilePic = $userProfileDetails->profile250x250 != "null"?$userProfileDetails->profile250x250:"/upload/profile/user_noimage.png";
//                    $this->render('captureUserInfo',array("UserInfo"=>$userInfo,"displayName"=>$displayName,"profilePic"=>$profilePic));
                }else{
                    $userInfo->attributes = $_POST['MarketResearchFollowUpForm'];
                    $errors = CActiveForm::validate($userInfo);                       

                    if($errors != '[]'){
                        $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                    }else{
                        $UserId = $this->tinyObject->UserId;
                        $userInfo->UserId = $UserId;
                        $status = "success";                        
                        if(!empty($userInfo->SurveyId) && !empty($userInfo->ScheduleId)){                           
                            $return = ServiceFactory::getSkiptaExSurveyServiceInstance()->saveUserTaxInfoDetails($userInfo);   
                            if($reutrn == "failure"){
                                $status = "error";
                            }
                        }else{
                            $status = "error";
                        }
                        $obj = array('status' => $status, 'data' => '', 'error' => "");
                    }
                    $renderScript = $this->rendering($obj);
                    echo $renderScript;
                }
                
            }else{                
                $this->redirect("/");
            }
            
        } catch (Exception $ex) {
            Yii::log("OutsideController:actionCaptureUserInfo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionRenderStates(){
        try{
            $tot = $_REQUEST['tot'];
            $states = State::model()->GetState();
            $this->renderPartial("multipleLicensedstates",array("vCnt"=>$tot,"states"=>$states));
        } catch (Exception $ex) {
            Yii::log("OutsideController:actionRenderStates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function renderUserAcceptionInfo($surveyId,$scheduleId,$surveyTitle){ 
        try{
            $userInfo = new MarketResearchFollowUpForm();
            $UserId = $this->tinyObject->UserId;
            $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserDetailsByUserId($UserId);
            $userInfo->FirstName = $userObj->FirstName;
            $userInfo->LastName = $userObj->LastName;
            $userInfo->City = $userObj->City;
            $userInfo->State = $userObj->State;
            $userInfo->Zip = $userObj->Zip;
            $userInfo->SurveyId = $surveyId;
            $userInfo->ScheduleId = $scheduleId;
            $userProfileDetails=ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($UserId);       
            $displayName = $userProfileDetails->DisplayName;
            $customObj = ServiceFactory::getSkiptaUserServiceInstance()->getCustomFieldsByUserIdforSurveyReports($UserId);       
            $cStateLicNumber = "";
            $NPINumber = "";
//            if(isset($customObj) && $customObj != "failure" && is_object($customObj)){
//                if(isset($customObj->StateLicenseNumber))
//                    $cStateLicNumber = $customObj->StateLicenseNumber;
//                if(isset($customObj->NPINumber))
//                    $userInfo->NPINumber = $customObj->NPINumber;
//            }
            $return = ServiceFactory::getSkiptaExSurveyServiceInstance()->getUserTaxInfoDetails($UserId);
            if($return != "failure" && sizeof($return)>0){                
                $userInfo->Address1 = $return->Address1;
                $userInfo->Address2 = $return->Address2;                
                $userInfo->MedicalSpecialty = $return->MedicalSpecialty;
                $userInfo->Credential = $return->Credential;
                $userInfo->Phone = $return->Phone;
                            
                $userInfo->FederalTaxIdOrSSN = base64_decode($return->FederalTaxIdOrSSN);                
            }
              $userInfo->NPINumber = $userObj->NPINumber;  
              $userInfo->HavingNPINumber = $userObj->HavingNPINumber;  
           if($userInfo->HavingNPINumber == 0 ){
            $userInfo->StateLicenseNumber =  LicensedStatesAndNumbers::model()->getStateLicenseNumberByUserId($UserId);
           }
            $profilePic = $userProfileDetails->profile250x250 != "null"?$userProfileDetails->profile250x250:"/upload/profile/user_noimage.png";
            $this->renderPartial('captureUserInfo',array("UserInfo"=>$userInfo,"displayName"=>$displayName,"profilePic"=>$profilePic,"licState"=>$userObj->State,"stateLicNumber"=>$cStateLicNumber,"surveyTitle"=>$surveyTitle));
        } catch (Exception $ex) {
            Yii::log("OutsideController:renderUserAcceptionInfo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionLogoutSurveyPage(){
        try{  
                $page = $_REQUEST['Page'];
              $userId = $_REQUEST['UserId'];
              $scheduleId = $_REQUEST['ScheduleId'];
              $surveyId = $_REQUEST['SurveyId'];
              $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->logoutSurveyPage($userId,$scheduleId,$surveyId,$page); 
          } catch (Exception $ex) {
            Yii::log("OutsideController:actionLogoutSurveyPage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
            
    }
      public function actionLoginSurveyPage(){
        try{
            $page = $_REQUEST['Page'];
            $userId = $_REQUEST['UserId'];
            $scheduleId = $_REQUEST['ScheduleId'];
            $surveyId = $_REQUEST['SurveyId'];
            CommonUtility::trackSurvey($userId,$scheduleId,$surveyId,$page,"refresh"); 
        } catch (Exception $ex) {
            Yii::log("OutsideController:actionLoginSurveyPage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
 /*
 * Moin Hussain
 * To show Survey Preview to Admin
 */
    public function actionGetAdminSurveyPreview(){
        try{
        $surveyId = $_POST['SurveyId'];
        $questionViewType = $_POST['QuestionViewType'];
        $page = $_POST['Page'];
        $extObj =  ExtendedSurveyCollection::model()->getSurveyDetailsById('Id',$surveyId); 
         $flag = "TRUE";
        if($questionViewType!=0){
            $questions =  $extObj->Questions;
            $totalQuestions = sizeof($questions);
            $startLimit = ($page-1) * $questionViewType;
            $endLimit = $startLimit+$questionViewType;
            $flag = "FALSE";
            if($endLimit >= $totalQuestions){
                $flag = "TRUE";
            }
            $questions = array_slice($questions, $startLimit, $questionViewType);
             $extObj->Questions = $questions;
        }
       
         
     
        $this->renderPartial('userView',array("surveyObj"=>$extObj,"errMessage"=>"","QuestionViewType"=>$questionViewType,"Page"=>$page,"Flag"=>$flag,"QNumber"=>$startLimit+1));   
        } catch (Exception $ex) {
         Yii::log("ExtendedSurveyController:actionGetAdminSurveyPreview::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }
    
   public function actionThankyouPage(){
        try{
            
            
            $response = $_REQUEST['done'];
            if($response == "done"){
                
                $this->render('thankyou');
            }else{
                $this->render("index");
            }
            
        } catch (Exception $ex) {

        }
    } 
    
    public function actionRenderCategories(){
        try{
            $testId = $_REQUEST['TestId'];
            $UserId = $_REQUEST['UserId'];
            $testquestionObj = UserQuestionsCollection::model()->getTestAvailable($UserId,$testId);
            $getTestObj = TestPreparationCollection::model()->getTestDetailsById("Id",(string)$testId);

            if($testquestionObj == "failure"){
              $testquestionObj = $this->prepareTempQuestions($getTestObj,$UserId,$testId); // saving temp. test for a user and fetching saved obj...           
              $testquestionObj = UserQuestionsCollection::model()->getTestAvailable($UserId,$testId);

             }
//            for($i=0;$i<sizeof($testquestionObj->Questions);$i++){
//                $testquestionObj->Questions[$i]['CategoryTime'] = $getTestObj->Category[$i]['CategoryTime'];
//            }
            $this->renderPartial("quesitoncategories",array("CatName"=>$testquestionObj->Questions));
        } catch (Exception $ex) {
            error_log("############Exception occurred########".$ex->getMessage());
        }
    }

}
####