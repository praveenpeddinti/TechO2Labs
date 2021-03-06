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
        if(isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj']) && $outerFlag == false){
            parent::init();
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            $_REQUEST['UserId'] = $this->tinyObject->UserId;
        }else{    
            if($outerFlag == true || $outerFlag == "true"){
                $this->layout = 'externalLayout';
            }else{
                $urlPath = $_SERVER['REQUEST_URI'];
                $urlArr = explode("/", $urlPath);
                $surveyGroupName = $urlArr[3]; 
               //  Yii::app()->session['returnUrl'] = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
                 // Yii::app()->request->cookies['r_u'] = new CHttpCookie('r_u',  parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH));
                $this->redirect(array("/common/postDetail","bundle"=>$surveyGroupName));
            }
        }
        } catch (Exception $ex) {
            Yii::log("OutsideController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex() {
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
    
    public function actionRenderQuestionView(){
        try{
            $surveyGroupName = $_REQUEST['GroupName'];
            $UserId = isset($_REQUEST['UserId'])?$_REQUEST['UserId']:1; // userId... 
            $surveyObj = "";
            $errMessage = "";
            $scheduleId = "";
            $viewType = $_REQUEST['viewType'];
            $QuestionsSurveyForm = new QuestionsSurveyForm;
            if(!empty($UserId) && !empty($surveyGroupName)){
                if($surveyGroupName == "public"){
                    $surveyGroupName = "0";
                }
                $schedulePattern = ServiceFactory::getSkiptaExSurveyServiceInstance()->isAlreadyDoneByUser($UserId,$surveyGroupName);     
                
                $schedulePatternArr = explode("_",$schedulePattern);
                $scheduleId = $schedulePatternArr[1];
                
                if($schedulePatternArr[0] == "notdone" && !empty($scheduleId) && $scheduleId != "notscheduled"){
                    //first check if a user already surveyed or not
//                    $scheduleId = "5462f372b96c3de22a8b4567";
                   
                    $surveyId = $schedulePatternArr[2];
                    
                     // $page = SurveyUsersSessionCollection::model()->getLastAnsweredPage($UserId,$scheduleId,$surveyId);
                    $page = SurveyUsersSessionCollection::model()->getUserAnsweredPage($UserId,$scheduleId,$surveyId);
                   
                    
                    if($page == 0){
                            $page=1;
                        }
                         CommonUtility::trackSurvey($UserId,$scheduleId,$surveyId,$page,"refresh");
                    $surveyObjArray = ServiceFactory::getSkiptaExSurveyServiceInstance()->getCustomSurveyDetailsById('Id',$surveyId,$scheduleId,$page);            
                     $surveyObj = $surveyObjArray["extObj"];
                     $surveyFullObj = $surveyObjArray["extFullObj"];
                }else{
                    if($schedulePatternArr[0] != "notscheduled"){
                        $surveyId = $schedulePatternArr[2];
                        $surveyObjArray = ServiceFactory::getSkiptaExSurveyServiceInstance()->getCustomSurveyDetailsById('Id',$surveyId,$scheduleId,1);                                
                       $surveyObj = $surveyObjArray["extObj"];
                        $surveyFullObj = $surveyObjArray["extFullObj"];
                        
                    }
                }
                
            }else{
                if(empty($UserId)){
//                    $errMessage = "Sorry, User not exist with this UserId.";
                    $errMessage = 1;
                }else if(empty($surveyGroupName)){
//                    $errMessage = "Sorry, Group Name not exist.";
                    $errMessage = 2;
                }
            }            
            if(empty($errMessage)){
                //anayltics view clicked
                    if($viewType == 2){
                        if(!empty($scheduleId)){
                            $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$scheduleId);
                        }
                        if(sizeof($obj->UserAnswers) > 0){
                            //analytics view
                            $this->renderPartial('surveyView',array("surveyObj"=>$surveyFullObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"errMessage"=>$errMessage,"userId"=>$UserId,"viewType"=>$viewType));
                        }else{
                            $this->renderPartial('resultsView');//no analytics found
                        }
                    }else if($schedulePatternArr[0] == "notdone" && !empty($scheduleId) && $scheduleId != "notscheduled"){
                         $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$scheduleId); 
                      //  $sessionTime = ScheduleSurveyCollection::model()->manageSurveyUserSessionNew($surveyId,$scheduleId,$UserId);
                         $sessionTime = SurveyUsersSessionCollection::model()->manageSurveyUserSession($surveyId,$UserId,$obj);
                    if($obj->MaxSpots > 0){
                         $spotsCount = SurveyUsersSessionCollection::model()->getSpotsAvailabeForScheduledSurvey($obj,$surveyId);
                     if($sessionTime == "nospots"){
                          if( $surveyObj->IsAnalyticsShown == 0 || sizeof($obj->UserAnswers) == 0){
                               $this->renderPartial('resultsView',array("type"=>"spots")); //no analytics found
                          }else{
                              $this->renderPartial('surveyView',array("surveyObj"=>$surveyFullObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"errMessage"=>$errMessage,"userId"=>$UserId,"viewType"=>$viewType));
   
                          }
                          return;
                       }else{
                          if($spotsCount>=0){
                             $spotMessage =  CommonUtility::getSpotMessage($spotsCount,$obj->MaxSpots);
                        
                        } 
                         }
                        }
                        $totalPages =  0;
                        if($obj->QuestionView > 0){
                         $totalPages = round($surveyObj->QuestionsCount/$obj->QuestionView);
                        }
//                         if($obj->QuestionView == 0){
//                           ScheduleSurveyCollection::model()->addtoResumeUsers($surveyId,$obj->_id,$UserId);
//                           $this->renderPartial('userView',array("surveyObj"=>$surveyObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"errMessage"=>$errMessage,"userId"=>$UserId,"sessionTime"=>$sessionTime,"spotMessage"=>$spotMessage));
//  
//                         } else{
                              ScheduleSurveyCollection::model()->addtoResumeUsers($surveyId,$obj->_id,$UserId);
                              $bufferAnswers =  SurveyUsersSessionCollection::model()->getAnswersForSurvey($UserId,$scheduleId);
                              $this->renderPartial('userCustomView',array("surveyObj"=>$surveyObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"errMessage"=>$errMessage,"userId"=>$UserId,"sessionTime"=>$sessionTime,"spotMessage"=>$spotMessage,"flag"=>$surveyObjArray["flag"],"iValue"=>$surveyObjArray["i"],"page"=>$page,"bufferAnswers"=>$bufferAnswers,"totalpages"=>$totalPages));
  
                        // } 
     
    
                    }else if($schedulePatternArr[0] == "done" && $scheduleId != "notscheduled"){   
                        $UserId =$this->tinyObject->UserId;
                        $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$scheduleId);
                         $reValue = ServiceFactory::getSkiptaExSurveyServiceInstance()->getProfileDetails($UserId,$scheduleId,$surveyId);
                         
                         if($surveyObj->IsAcceptUserInfo == 1 && $reValue == 0){
                             $this->renderUserAcceptionInfo($surveyObj->_id,$scheduleId,$surveyObj->SurveyTitle);
                         }else{
                             //!in_array($UserId,$obj->VisitedThankYou)
                             
                             if($surveyObj->IsAnalyticsShown == 0 || ($obj->ShowThankYou == 1 && !in_array($UserId,$obj->VisitedThankYou))){
                                if(isset($obj->_id))
                                      ScheduleSurveyCollection::model()->updateVisitedThankYouUsers($UserId,$obj->_id);
                                 $this->renderPartial('thankyou',array('result'=>$obj,"ScheduleId"=>$scheduleId,"IsAnalyticsShown"=>$surveyObj->IsAnalyticsShown));
                              }else{
                                  $this->renderPartial('surveyView',array("surveyObj"=>$surveyFullObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"errMessage"=>$errMessage,"userId"=>$UserId,"viewType"=>$viewType));
                              }
                         }                         
                      
                    }else{
                        echo "NotScheduled_";
                    }
            }
            else {
                echo $errMessage;
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in OutsideController->actionRenderQuestionView==".$ex->getMessage());
            Yii::log("OutsideController:actionRenderQuestionView::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            $scheduleId = $_POST['scheduleId'];
            $surveyId = $_POST['surveyId'];
            $page = $_POST['page'];
             $action = $_POST['action'];
              $userId = $this->tinyObject['UserId'];
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
             $this->renderPartial('userCustomView',array("surveyObj"=>$surveyObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$scheduleId,"userId"=>$userId,"sessionTime"=>"","spotMessage"=>$spotMessage,"flag"=>$surveyObjArray["flag"],"iValue"=>$surveyObjArray["i"],"page"=>$page,"bufferAnswers"=>$bufferAnswers,"totalpages"=>$totalPages));
             
        } catch (Exception $ex) {
            error_log("Exception Occurred in OutsideController->actionSureyQuestionPagination==".$ex->getMessage());
            Yii::log("OutsideController:actionSureyQuestionPagination::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 
     }

    public function actionValidateSurveyAnswersQuestion(){
        try{         
//            ini_set('memory_limit', '2048M');
            $QuestionsSurveyForm = new QuestionsSurveyForm();
            if(isset($_POST['QuestionsSurveyForm'])){
                   $QuestionsSurveyForm->attributes = $_POST['QuestionsSurveyForm'];  
                   $UserId = $QuestionsSurveyForm->UserId;
                   $f =  json_decode($QuestionsSurveyForm->Questions);
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

                                        }
                                    }
                                }
                           
                            
                            if($key == "OptionsSelected"){
                                $k=0;
                                if(sizeof($value)>0){
                                foreach($value as $m){       
                                    if($questionType == 1 || $questionType == 2){ 
                                        if(!empty($m)){
                                            $OptionsSelected = TRUE;
                                        }
                                            $widget12->SelectedOption = explode(",",$m); 
                                    }
                                    else if($questionType == 3 || $questionType == 4){
                                        if(!empty($m)){
                                            $OptionsSelected = TRUE;
                                        }
                                            $optionsArray = explode(",",$m);                                        
                                            $widget34->Options = $optionsArray;
                                            $optioncnt = sizeof($widget34->Options);
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
                                    else if($questionType == 5 )                                          
                                        $widget5->Other = (int) $m;
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
                            
//                            if($key == "AnyOtherValue"){
//                                $k=0;
//                                if(sizeof($value)>0){                                   
//                                foreach($value as $m){ 
//                                     if($questionType == 3 || $questionType == 4){  
//                                         if($m != ""){                                            
////                                            $widget34->AnyOtherValue = $m;
//                                            array_push($widget34->Options,$m);
//                                         }
//                                    }
//                                    $k++;
//
//                                }
//                                }
//                            }
                            
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
                     $surveyObject = ServiceFactory::getSkiptaExSurveyServiceInstance()->saveSurveyAnswer($QuestionsSurveyForm,$NetworkId,$UserId,$fromPagination,$fromAutoSave,$fromPage);
                     
                     if($fromAutoSave==0){
                     $exsurveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id',$surveyObject->SurveyId);  
                     $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$QuestionsSurveyForm->ScheduleId);                     
                     $advertiseObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyAdvertisementByScheduleId($QuestionsSurveyForm->ScheduleId);
                     if(isset($advertiseObj) && !empty($advertiseObj) && $advertiseObj != "failure"){                         
                         UserStreamCollection::model()->updateSurveyTakenUsersList($UserId,$advertiseObj['id']);
                        if(isset(Yii::app()->params['NewRegisteredUserSurveyBundle']) && Yii::app()->params['NewRegisteredUserSurveyBundle'] == $obj->SurveyRelatedGroupName){
                           UserStreamCollection::model()->updateIsDeletedForSurveryCompletedUserByUserIdAdId($UserId,$advertiseObj['id']);                         
                        }
                     }
                     $reValue = ServiceFactory::getSkiptaExSurveyServiceInstance()->getProfileDetails($UserId,$QuestionsSurveyForm->ScheduleId,$surveyObject->SurveyId);
                     
                     if($exsurveyObj->IsAcceptUserInfo == 1 && $reValue == 0){
                        $this->renderUserAcceptionInfo($surveyObject->SurveyId, $QuestionsSurveyForm->ScheduleId, $exsurveyObj->SurveyTitle);
                     }else{
                         if($obj->ShowThankYou == 1 || $exsurveyObj->IsAnalyticsShown == 0){                             
                             if($fromAutoSave == 0)
                                ScheduleSurveyCollection::model()->updateVisitedThankYouUsers($UserId,$QuestionsSurveyForm->ScheduleId);
                            $this->renderPartial('thankyou',array('result'=>$obj,"ScheduleId"=>$QuestionsSurveyForm->ScheduleId,"IsAnalyticsShown"=>$exsurveyObj->IsAnalyticsShown));
                        }else{
                            $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById('Id',$surveyObject->SurveyId); 

                            $this->renderPartial('surveyView',array("surveyObj"=>$surveyObj,"QuestionsSurveyForm"=>$QuestionsSurveyForm,"scheduleId"=>$QuestionsSurveyForm->ScheduleId,"errMessage"=>"","userId"=>$UserId));
                        }
                     }
                     }
                    
                
                }
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in OutsideController->actionValidateSurveyAnswersQuestion==".$ex->getTraceAsString());
            Yii::log("OutsideController:actionValidateSurveyAnswersQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
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

}
