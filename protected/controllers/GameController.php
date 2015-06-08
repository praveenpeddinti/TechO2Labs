<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GameController extends Controller {
  

public function __construct($id, $module = null) {
        parent::__construct($id, $module);
}
    
public function init() {
    try{
    parent::init();
    if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj']) && (Yii::app()->session['IsAdmin'])) {
        $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
        $this->userPrivileges = Yii::app()->session['UserPrivileges'];
        $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
        $this->whichmenuactive=4;
        $this->sidelayout = 'no';
    } else {
        $this->redirect('/');
    }
    }catch(Exception $ex){
     Yii::log("GameController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}
public function actionIndex(){
    try {
        $gamesToSchedule=  ServiceFactory::getSkiptaGameServiceInstance()->getGamesToSchedule();    
        $userId=$this->tinyObject['UserId'];
        $currentScheduleGame=ServiceFactory::getSkiptaGameServiceInstance()->getCurrentGameSchedule($this->userPrivileges,$userId);

        $gameName;
        $gameDescription;
        if(!is_string($gamesToSchedule)){
            $gameId=$gamesToSchedule[0]['_id'];               
            $gameDetails=ServiceFactory::getSkiptaGameServiceInstance()->getGameDetailsByIdObject($gameId);
            $gameName=$gameDetails->GameName;
            $gameDescription=$gameDetails->GameDescription;
            $lovefollowArray =  CommonUtility::getLoveAndFollowUsers($this->tinyObject['UserId'],$gameDetails->Love, $gameDetails->Followers); 
        }
        //GameAds onload
        $stream=$this->loadAdsOnload();
        $this->render('index' ,array('gamesToSchedule'=>$gamesToSchedule,'GameName'=>$gameName,'GameDescription'=>$gameDescription,'currentScheduleGame'=>$currentScheduleGame,"lovefollowArray"=>$lovefollowArray,'stream'=>$stream,'userLanguage'=>Yii::app()->session['language']));

   } catch (Exception $ex) {
       Yii::log("GameController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
   }      
 }
public function loadAdsOnload(){
    try{         
        $pageSize = 10;
        $stream=array();
        $previousStreamIdArray = array();
        $mongoCriteria = new EMongoCriteria;

        $orCondition=array(
                           'CategoryType' => 13,
                            'DisplayPage' => 'Games'
                       );

        $mongoCriteria->setConditions($orCondition);
        $mongoCriteria->UserId('in', array(0,$this->tinyObject->UserId));
        $mongoCriteria->IsDeleted('==', 0);
        $mongoCriteria->IsAbused('==', 0);
        $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
        $mongoCriteria->sort('UserId', EMongoCriteria::SORT_DESC);
        $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
              'pagination' => array('pageSize' => $pageSize),
              'criteria' => $mongoCriteria
        ));
        if ($provider->getTotalItemCount() >0) {
            $UserId =  $this->tinyObject['UserId'];
            $streamRes = (object) (CommonUtility::prepareStreamData($UserId, $provider->getData(), $this->userPrivileges, 0, Yii::app()->session['PostAsNetwork'],'',$previousStreamIdArray));
            $stream=(object)($streamRes->streamPostData);
        }
        return $stream;
    }catch(Exception $ex){
        Yii::log("GameController:loadAdsOnload::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}  

public function actionGameWall(){
    try {
         $scheduleForm = new ScheduleGameForm();
         $gamesToSchedule = ServiceFactory::getSkiptaGameServiceInstance()->getGamesToSchedule();
         $scheduleForm->GameName = $gamesToSchedule;
         $this->render('gameWall', array('scheduleForm' => $scheduleForm, 'gamesToSchedule' => $gamesToSchedule));
     } catch (Exception $ex) {
         Yii::log("GameController:actionGameWall::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
     }
}

public function actionUploadThankYouImage(){
    try {         
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $folder=Yii::getPathOfAlias('webroot').'/upload/';// folder for uploaded files
        if ( !file_exists($folder) ) {
            mkdir ($folder, 0755,true);
           }
        $allowedExtensions = array("jpg","jpeg","gif","png","tiff","tif","TIF");//array("jpg","jpeg","gif","exe","mov" and etc...
        // $sizeLimit = 30 * 1024 * 1024;// maximum file size in bytes
         $sizeLimit= Yii::app()->params['UploadMaxFilSize'];
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);

                $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
                $fileName=$result['filename'];//GETTING FILE NAME
        $extension=$result['extension'];

        $ext="game/thankyou";
        $destnationfolder=$folder.$ext;
        if ( !file_exists($destnationfolder) ) {
           mkdir ($destnationfolder, 0755,true);
        }

        $imgArr = explode(".", $result['filename']);
        $date=strtotime("now");
                $finalImg_name = $imgArr[0] . '.' . $imgArr[1];
                $finalImage=$imgArr[0]  . '_' . $result['imagetime']. '.' . $imgArr[1];
                $fileNameTosave = $folder.$imgArr[0]  . '_' . $result['imagetime']. '.' . $imgArr[1];
         $path=$folder.$result['filename'];
          $extension_t = $this->getFileExtension($fileName);    
        if($extension_t == "tif" || $extension_t == "tiff"){                
            $imgArr = explode(".", $result['mfilename']);
            $fileNameTosave = $folder . $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
            $finalImage = $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
            $path = $folder . $result['mfilename'];
            $result['savedfilename'] = $result['tsavedfilename'];
        }
        rename($path,$fileNameTosave);

      //  $filename=$result['filename'];
       $sourcepath=$fileNameTosave;
        $destination=$folder.$ext."/".$finalImage;
        if($ext!=""){
          if(file_exists($sourcepath)){
               if(copy($sourcepath, $destination)){
                   unlink($sourcepath);
               }
           }
        }
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $return;// it's array
    } catch (Exception $ex) {
        Yii::log("GameController:actionUploadThankYouImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
} 
    
    public function actionGetGameDetailsById(){
        try {
            if(isset($_REQUEST['selectedGameId'])){
               $gameId=$_REQUEST['selectedGameId'];              
               $gameDetails=ServiceFactory::getSkiptaGameServiceInstance()->getGameDetailsByIdObject($gameId);                
             $obj = array('status' => 'success', 'data' => $gameDetails->CurrentScheduleId, 'error' => '', 'GameDescription'=>$gameDetails->GameDescription,'GameName'=>$gameDetails->GameName);
             $renderScript = $this->rendering($obj);
            echo $renderScript;
            }
           
        } catch (Exception $ex) {
            Yii::log("GameController:actionGetGameDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     public function actionGameDetails(){
        try {
            $urlArray =  explode("/", Yii::app()->request->url);
            $gameName=$urlArray[1];
            $gameScheduleId=$urlArray[2];
                  $mode=$urlArray[3];
           $MoreCommentsArray = array();
           $tinyUserProfileObject = array();
            $object = array();
            $gameDetailsArray=ServiceFactory::getSkiptaGameServiceInstance()->getGameDetailsByName($this->tinyObject->UserId,$gameName,$gameScheduleId);
            //This code is for get post all comment and prepare comments data with web snippets  
//            if($gameDetailsArray=="failure"){
//                 $this->render('/user/error');
//            }
            $categoryType = 9;
            $postId = $gameDetailsArray[0]->_id;
            $MinpageSize = 2;
            $page=0;
            $pageSize = ($MinpageSize * $page);
            $numberOfComments = 5;
            $MoreCommentsArray = CommonUtility::prepareComments($pageSize, $MinpageSize, $gameDetailsArray[0]->_id, $categoryType, "",$numberOfComments);
             $commentedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getCommentedUsersForPost($postId, (int)($this->tinyObject['UserId']));
        $IsUserCommented = in_array((int)($this->tinyObject['UserId']), $commentedUsers);
         $lovefollowArray =  CommonUtility::getLoveAndFollowUsers($this->tinyObject['UserId'],$gameDetailsArray[0]->Love, $gameDetailsArray[0]->Followers); 
        $canMarkAsAbuse = 0;
         $UserPrivileges = $this->userPrivileges;
        if (is_array($UserPrivileges)) {
            foreach ($UserPrivileges as $value) {
                if ($value['Status'] == 1) {
                    if ($value['Action'] == 'Mark_As_Abuse') {
                        $canMarkAsAbuse = 1;
                    }
                }
                }
                }
         
         $this->render('gameDetail',array("gameDetails"=>$gameDetailsArray[0],"gameBean"=>$gameDetailsArray[1],"mode"=>$mode,'commentsdata'=>$MoreCommentsArray,'IsCommented'=>$IsUserCommented,"lovefollowArray"=>$lovefollowArray,"canMarkAsAbuse"=>$canMarkAsAbuse,'userLanguage'=>Yii::app()->session['language']));

        } catch (Exception $ex) {
            Yii::log("GameController:actionGameDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


  public function actionNewgame(){
            try{
       $urlArray =  explode("/", Yii::app()->request->url);
            $GameId="";
            $type=$urlArray[2];
            if($type=="edit"){
                $GameId=$urlArray[3];
            }
            
            
       $newGameModel = new GameCreationForm();
        $UserId = $this->tinyObject['UserId'];
        $Gamedata=array();
        
         if (isset($GameId) && $GameId!="") {
            $gameDetails=ServiceFactory::getSkiptaGameServiceInstance()->getGameDetailsById($GameId);
            foreach ($gameDetails as $key => $value) {
              
                    $Gamedata = $value;
                }         
                if(sizeof($Gamedata) > 0){
                    $newGameModel->IsSponsors = $Gamedata->IsSponsored;
                    $newGameModel->BrandLogo = $Gamedata->BrandLogo;
                    $newGameModel->BrandName = $Gamedata->BrandName;
                    $newGameModel->IsEnableSocialActions = $Gamedata->IsEnableSocialActions;
                }
         }else{
             $gameId="";
              $Gamedata=array();
         }
        $gameSponsors = GameSponsors::model()->getGameSponsors();
        $this->render('creategame', array('newGameModel' => $newGameModel,'gameId' => $GameId,'gameDetails'=>$Gamedata,"gameSponsors"=>$gameSponsors));
        
        }catch(Exception $ex){
         Yii::log("GameController:actionNewgame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }

    }
    
 public function actionsortArrayOfArray($array, $on, $order=SORT_ASC) {
   try{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
    }catch(Exception $ex){
         Yii::log("GameController:actionsortArrayOfArray::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }        
    
}
    
    
    
    
     public function actionNewgameCreation(){
            try{
       $newGameModel = new GameCreationForm();
        //$UserId = $this->tinyObject['UserId'];
        $UserId = $this->tinyObject->UserId;
         $NetworkId=$this->tinyObject['NetworkId'];
        if (isset($_POST['GameCreationForm'])) {
            
            $newGameModel->attributes = $_POST['GameCreationForm'];
            $newGameModel->CreatedBy = $this->tinyObject->UserId;
            $gameDetails=ServiceFactory::getSkiptaGameServiceInstance()->saveNewGame($newGameModel,$NetworkId,$UserId);
             
            if($gameDetails!="failure" && $gameDetails!='Duplicate' && $gameDetails!='update'){
                
                 $obj = array("status"=>'success',"message"=>'');
            }else if($gameDetails=="Duplicate" ){
                
                $message=$newGameModel->GameName." Already exist";
                 $obj = array("status"=>'failure',"error"=>$message);
            }else if($gameDetails=="update" ){
                
                
                 $obj = array("status"=>'success',"message"=>'update');
            }else{
                $obj = array("status"=>'failure',"error"=>$gameDetails);
            }
           
            
             echo CJSON::encode($obj);
            
        }
        }catch(Exception $ex){
         Yii::log("GameController:actionNewgameCreation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
       
    }
    
    
    public function actionEditgame(){
        try{
        $newGameModel = new GameCreationForm();
        $UserId = $this->tinyObject['UserId'];
        $gameId='5398364bb96c3d320e8b457c';
        if (isset($_REQUEST['GameId'])) {
            $gameId=$_REQUEST['GameId'];
           // $gameId='5398364bb96c3d320e8b457c';
            $newGameModel->attributes = $_POST['GameCreationForm'];
            $gameDetails=ServiceFactory::getSkiptaGameServiceInstance()->getGameDetailsById($gameId);
        }
        $Gamedata=array();
        foreach ($gameDetails as $key => $value) {
            //echo $key;
            $Gamedata=$value;
        }
        
        $Questions=$this->actionsortArrayOfArray($Gamedata['Questions'],'Position',SORT_ASC);
        if($gameDetails!="failure"){
                 //$obj = array("status"=>'success','gameDetails'=>$Gamedata);
                  $Id = $_REQUEST['QuestionId'];
                  $Id=0;
                  $this->renderPartial("editgame", array('QuestionId' => $Id,'gameDetails'=>$Questions));
                 
        }else{
              $obj = array("status"=>'failure');
        }
        }catch(Exception $ex){
         Yii::log("GameController:actionEditgame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
            
    }
    
    
     public function actionUploadGameBannerImage() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            //  $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'].'/upload/Group/Profile/';
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "exe", "mov", "mp4", "mp3", "txt", "doc", "docx", "pptx", "xlsx", "pdf", "ppt", "xls", "3gp", "php", "ini", "avi", "rar", "zip", "png", "tiff","tif","TIF"); //array("jpg","jpeg","gif","exe","mov" and etc...
          //  $sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
             $sizeLimit= Yii::app()->params['UploadMaxFilSize'];          

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
             $result["filepath"]= $tempPath.$fileName;
             $result["fileremovedpath"]= $folder.$fileName; 
            }else{
              $result['success']=false;  
            }

            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
        } catch (Exception $ex) {
            Yii::log("GameController:actionUploadGameBannerImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }  
    
  public function actionAddNewQuestion(){
     try{
      $Id = $_REQUEST['Id'];
       $this->renderPartial("newQuestion", array('QuestionId' => $Id));
     }catch(Exception $ex){
         Yii::log("GameController:actionAddNewQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     } 
  }  

    
  public function actionsaveScheduleGame(){
      try {
          $newScheduleGame=new ScheduleGameForm();
          if(isset($_POST['ScheduleGameForm'])){
                $newScheduleGame->attributes = $_POST['ScheduleGameForm'];
                $userId=$this->tinyObject['UserId'];
                $errors = CActiveForm::validate($newScheduleGame);
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                }else{
                  $gameId=$newScheduleGame->GameName;
                  
                  $streamId=$newScheduleGame->StreamId;
                       $startDate=$newScheduleGame->StartDate;
                    $endDate=$newScheduleGame->EndDate." 23:59:59";
                    $startDate =  CommonUtility::convert_time_zone(strtotime($startDate), date_default_timezone_get(),Yii::app()->session['timezone']);
                    $endDate =  CommonUtility::convert_time_zone(strtotime($endDate),date_default_timezone_get(),Yii::app()->session['timezone']);
             
                    $isExists=ServiceFactory::getSkiptaGameServiceInstance()->checkForScheduleGame($startDate,$endDate,$this->tinyObject['SegmentId']);
                     //return;
                     $newScheduleGame->StartDate = $startDate;
                    $newScheduleGame->EndDate = $endDate;
                    if(is_object($isExists) || is_array($isExists)){
                       $gameName=$isExists->GameName;
                    //$errorMessage='<b>'.$gameName .'</b> is already scheduled between   ' .date(Yii::app()->params['PHPDateFormat'],$isExists->StartDate->sec) ." to ". date(Yii::app()->params['PHPDateFormat'],$isExists->EndDate->sec);
                    $errorMessage='<b>'.$gameName .'</b> is already scheduled between   ' .date(Yii::app()->params['PHPDateFormat'],CommonUtility::convert_date_zone($isExists->StartDate->sec,Yii::app()->session['timezone'],  date_default_timezone_get())) ." to ". date(Yii::app()->params['PHPDateFormat'],CommonUtility::convert_date_zone($isExists->EndDate->sec,Yii::app()->session['timezone'],  date_default_timezone_get()));

                    $obj = array('status' => 'Exists', 'data' => $errorMessage, 'error' => $errors);   
                    }else{
                          
                      $result=ServiceFactory::getSkiptaGameServiceInstance()->saveScheduleGame($newScheduleGame,$userId);
                        $result='success';
                        if($result=='success'){
                         $obj = array('status' => 'success', 'data' => Yii::t('translation','Game_Scheduled_Successfully'), 'error' => '','gameId'=>$gameId,'streamId'=>$streamId);      
                        }else{
                         $obj = array('status' => 'error', 'data' => '', 'error' => '');         
                        }
                        
                    } 
                  
                    
                }
                 $renderScript = $this->rendering($obj);
                echo $renderScript;
          }
          
      } catch (Exception $ex) {
          Yii::log("GameController:actionsaveScheduleGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    public function actionShowGame(){
        try {
        $type = $_POST['type'];
        $gameId = $_POST['gameId'];
        $gameScheduleId = $_POST['gameScheduleId'];
        $gameDetails=ServiceFactory::getSkiptaGameServiceInstance()->getGameDetailsByIdObject($gameId);
        $translateNeed = array();
        $translateNeed['type'] = $type;
        $translateNeed['gameId'] = $gameId;
        $translateNeed['gameScheduleId'] = $gameScheduleId;
        
        ServiceFactory::getSkiptaGameServiceInstance()->showGame($this->tinyObject->UserId,$type,$gameId,$gameScheduleId);
        $questionsArray=ServiceFactory::getSkiptaGameServiceInstance()->getQuestionsForGame($this->tinyObject->UserId,$type,$gameId,$gameScheduleId);
        if(isset($_POST['toLanguage']) && isset($_POST['fromLanguage'])){
            $fromLanguage = $_POST['fromLanguage'];
            $toLanguage = $_POST['toLanguage'];
            $translateNeed['gameLanguage'] = $toLanguage;
            $translateNeed['userLanguage'] = $fromLanguage;
            if($gameDetails->Language!=$toLanguage){
                $translatedBean = new TranslatedDataBean();
                $translatedBean->GameId = $gameId;
                $translatedBean->PostType = 12;
                $translatedBean->CategoryType = 9;
                $translatedBean->Language = $toLanguage;
                $translatedObj = ServiceFactory::getSkiptaTranslatedDataService()->isGameTranslated($translatedBean);
                $translatedQuestions = array();
                if(isset($translatedObj["Questions"]) && count($translatedObj["Questions"])>0){//Questions already exist
                    $translatedQuestions = $translatedObj["Questions"];
                    if(count($questionsArray[0])>0){
                        for($i=0;$i<count($questionsArray[0]);$i++) {
                            if(isset($questionsArray[0][$i]["question"])){
                                $questionId = $questionsArray[0][$i]['question']['QuestionId'];
                                $questionsArray[0][$i]["question"]['Question'] = $translatedQuestions["$questionId"]['Question'];
                                $questionsArray[0][$i]["question"]['QuestionDisclaimer'] = $translatedQuestions["$questionId"]['QuestionDisclaimer'];
                                $questionsArray[0][$i]["question"]['OptionA'] = $translatedQuestions["$questionId"]['OptionA'];
                                $questionsArray[0][$i]["question"]['OptionADisclaimer'] = $translatedQuestions["$questionId"]['OptionADisclaimer'];
                                $questionsArray[0][$i]["question"]['OptionB'] = $translatedQuestions["$questionId"]['OptionB'];
                                $questionsArray[0][$i]["question"]['OptionBDisclaimer'] = $translatedQuestions["$questionId"]['OptionBDisclaimer'];
                                $questionsArray[0][$i]["question"]['OptionC'] = $translatedQuestions["$questionId"]['OptionC'];
                                $questionsArray[0][$i]["question"]['OptionCDisclaimer'] = $translatedQuestions["$questionId"]['OptionCDisclaimer'];
                                $questionsArray[0][$i]["question"]['OptionD'] = $translatedQuestions["$questionId"]['OptionD'];
                                $questionsArray[0][$i]["question"]['OptionDDisclaimer'] = $translatedQuestions["$questionId"]['OptionDDisclaimer'];
                            }else{
                                $questionId = $questionsArray[0][$i]['QuestionId'];
                                $questionsArray[0][$i]['Question'] = $translatedQuestions["$questionId"]['Question'];
                                $questionsArray[0][$i]['QuestionDisclaimer'] = $translatedQuestions["$questionId"]['QuestionDisclaimer'];
                                $questionsArray[0][$i]['OptionA'] = $translatedQuestions["$questionId"]['OptionA'];
                                $questionsArray[0][$i]['OptionADisclaimer'] = $translatedQuestions["$questionId"]['OptionADisclaimer'];
                                $questionsArray[0][$i]['OptionB'] = $translatedQuestions["$questionId"]['OptionB'];
                                $questionsArray[0][$i]['OptionBDisclaimer'] = $translatedQuestions["$questionId"]['OptionBDisclaimer'];
                                $questionsArray[0][$i]['OptionC'] = $translatedQuestions["$questionId"]['OptionC'];
                                $questionsArray[0][$i]['OptionCDisclaimer'] = $translatedQuestions["$questionId"]['OptionCDisclaimer'];
                                $questionsArray[0][$i]['OptionD'] = $translatedQuestions["$questionId"]['OptionD'];
                                $questionsArray[0][$i]['OptionDDisclaimer'] = $translatedQuestions["$questionId"]['OptionDDisclaimer'];
                            }
                        }
                    }
                }else{
                    if(count($questionsArray[0])>0){
                        for($i=0;$i<count($questionsArray[0]);$i++) {
                            if(isset($questionsArray[0][$i]["question"])){
                                $question = $questionsArray[0][$i]["question"];
                            }else{
                                $question =  $questionsArray[0][$i];
                            }
                            $questionBean = new TranslateQuestionBean();
                            $questionBean->QuestionId = $question['QuestionId'];
                            $questionBean->Question = CommonUtility::translateData($question['Question'], $fromLanguage, $toLanguage);

                            $questionBean->QuestionDisclaimer = $question['QuestionDisclaimer']!=""? CommonUtility::translateData($question['QuestionDisclaimer'], $fromLanguage, $toLanguage):$question['QuestionDisclaimer'];
                            $questionBean->OptionA = CommonUtility::translateData($question['OptionA'], $fromLanguage, $toLanguage);
                            $questionBean->OptionADisclaimer = $question['OptionADisclaimer']!=""?CommonUtility::translateData($question['OptionADisclaimer'], $fromLanguage, $toLanguage):$question['OptionADisclaimer'];
                            $questionBean->OptionB = CommonUtility::translateData($question['OptionB'], $fromLanguage, $toLanguage);
                            $questionBean->OptionBDisclaimer = $question['OptionBDisclaimer']!=""?CommonUtility::translateData($question['OptionBDisclaimer'], $fromLanguage, $toLanguage):$question['OptionBDisclaimer'];
                            $questionBean->OptionC = $question['OptionC']!=""?CommonUtility::translateData($question['OptionC'], $fromLanguage, $toLanguage):$question['OptionC'];
                            $questionBean->OptionCDisclaimer = $question['OptionCDisclaimer']!=""?CommonUtility::translateData($question['OptionCDisclaimer'], $fromLanguage, $toLanguage):$question['OptionCDisclaimer'];
                            $questionBean->OptionD = $question['OptionD']!=""?CommonUtility::translateData($question['OptionD'], $fromLanguage, $toLanguage):$question['OptionD'];
                            $questionBean->OptionDDisclaimer = $question['OptionDDisclaimer']!=""?CommonUtility::translateData($question['OptionDDisclaimer'], $fromLanguage, $toLanguage):$question['OptionDDisclaimer'];
                            $translatedQuestions["$questionBean->QuestionId"] = $questionBean;
                            if(isset($questionsArray[0][$i]["question"])){
                                $questionsArray[0][$i]["question"]['Question'] = $questionBean->Question;
                                $questionsArray[0][$i]["question"]['QuestionDisclaimer'] = $questionBean->QuestionDisclaimer;
                                $questionsArray[0][$i]["question"]['OptionA'] = $questionBean->OptionA;
                                $questionsArray[0][$i]["question"]['OptionADisclaimer'] = $questionBean->OptionADisclaimer;
                                $questionsArray[0][$i]["question"]['OptionB'] = $questionBean->OptionB;
                                $questionsArray[0][$i]["question"]['OptionBDisclaimer'] = $questionBean->OptionBDisclaimer;
                                $questionsArray[0][$i]["question"]['OptionC'] = $questionBean->OptionC;
                                $questionsArray[0][$i]["question"]['OptionCDisclaimer'] = $questionBean->OptionCDisclaimer;
                                $questionsArray[0][$i]["question"]['OptionD'] = $questionBean->OptionD;
                                $questionsArray[0][$i]["question"]['OptionDDisclaimer'] = $questionBean->OptionDDisclaimer;
                            }else{
                                $questionsArray[0][$i]['Question'] = $questionBean->Question;
                                $questionsArray[0][$i]['QuestionDisclaimer'] = $questionBean->QuestionDisclaimer;
                                $questionsArray[0][$i]['OptionA'] = $questionBean->OptionA;
                                $questionsArray[0][$i]['OptionADisclaimer'] = $questionBean->OptionADisclaimer;
                                $questionsArray[0][$i]['OptionB'] = $questionBean->OptionB;
                                $questionsArray[0][$i]['OptionBDisclaimer'] = $questionBean->OptionBDisclaimer;
                                $questionsArray[0][$i]['OptionC'] = $questionBean->OptionC;
                                $questionsArray[0][$i]['OptionCDisclaimer'] = $questionBean->OptionCDisclaimer;
                                $questionsArray[0][$i]['OptionD'] = $questionBean->OptionD;
                                $questionsArray[0][$i]['OptionDDisclaimer'] = $questionBean->OptionDDisclaimer;
                            }
                        }
                    }
                    $translatedBean->Questions = $translatedQuestions;
                    ServiceFactory::getSkiptaTranslatedDataService()->saveTranslatedGameQuestions($translatedBean);
                }
            }
        }else{
            $translateNeed['gameLanguage'] = $gameDetails->Language;
            $translateNeed['userLanguage'] = Yii::app()->session['language'];
        }
        if($type == "view" || $type == "viewAdmin"){
         $this->renderPartial('questionsView',array("questions"=>$questionsArray[0],"disclaimer"=>$questionsArray[1],'translateNeed'=>$translateNeed));
    
        }else{
       $this->renderPartial('questionsPlay',array("questions"=>$questionsArray[0],"disclaimer"=>$questionsArray[1],'translateNeed'=>$translateNeed,"type"=>$type));
    
            }

        }
    catch (Exception $ex) {
          Yii::log("GameController:actionShowGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    } 
    public function actionSaveAnswer(){
        try {
        $gameId = $_POST['gameId'];
        $gameScheduleId = $_POST['scheduleId'];
        $questionId = $_POST['questionId'];
        $answer = $_POST['answer'];
        $questionsArray=ServiceFactory::getSkiptaGameServiceInstance()->saveAnswer($this->tinyObject->UserId,$gameId,$gameScheduleId,$questionId,$answer);

    }
    catch (Exception $ex) {
          Yii::log("GameController:actionSaveAnswer::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    } 
    public function actionSubmitGame(){
        try {
        $gameId = $_POST['gameId'];
        $gameScheduleId = $_POST['scheduleId'];
        $result = ServiceFactory::getSkiptaGameServiceInstance()->submitGame($this->tinyObject->UserId,$gameId,$gameScheduleId);
        $this->renderPartial('thankyou',array("result"=>$result));
    }
    catch (Exception $ex) {
          Yii::log("GameController:actionSubmitGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    } 
  public function actionloadGameWall(){
            try
        {   
              if(isset($_GET['StreamPostDisplayBean_page']))
        {
            $streamIdArray = array();
            $previousStreamIdArray = array();
            $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
            if(!empty($previousStreamIdString)){
                $previousStreamIdArray = explode(",", $previousStreamIdString);
            }
            $userId=$this->tinyObject['UserId'];
            $pageSize = 6;
           // $scheduleGames = ServiceFactory::getSkiptaGameServiceInstance()->getScheduleGamesForGameWall();
          $isNotifiable=1;  
          if(Yii::app()->session['IsAdmin']!=1){
           $isNotifiable=0; 
          }
             $mongoCriteria=new EMongoCriteria();
             if (isset($_GET['filterString'])) {
                   
                 $cDate=date('m/d/y');
                 if($_GET['filterString']=='FutureSchedule'){
                 
                       $orCondition=array('$or' =>[array('UserId' => 0,'SegmentId' =>  array('$in'=>array((int) $this->tinyObject['SegmentId'],0)), ),array('UserId' => (int)$this->tinyObject['UserId'])],
                );
                  if(trim($this->tinyObject['Language'])!="en"){
                 array_push($orCondition['$or'], array("Language"=>$this->tinyObject['Language']));
                  }
                $mongoCriteria->setConditions($orCondition);
                $mongoCriteria->IsDeleted('!=', 1);
                $mongoCriteria->IsBlockedWordExist('notIn', array(1, 2));
                $mongoCriteria->IsAbused('notIn', array(1, 2));
                $mongoCriteria->CategoryType('==', 9);
                $mongoCriteria->IsNotifiable('==', 1);
                $mongoCriteria->StartDate('>', date('Y-m-d'));
                $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
                     
              
                }
                 else if($_GET['filterString']=='SuspendedGames'){
                  
               $mongoCriteria->UserId('==', 0);
                $mongoCriteria->SegmentId('==', (int) $this->tinyObject['SegmentId']);
                $mongoCriteria->IsDeleted('==', 1);
                $mongoCriteria->CategoryType('==', 9);
                     
                }
                
                else {
                            $orCondition=array('$or' =>[array('UserId' => 0,'SegmentId' =>  array('$in'=>array((int) $this->tinyObject['SegmentId'],0)), ),array('UserId' => (int)$this->tinyObject['UserId'])],
                );
                  if(trim($this->tinyObject['Language'])!="en"){
                 array_push($orCondition['$or'], array("Language"=>$this->tinyObject['Language']));
                  }
                $mongoCriteria->setConditions($orCondition);
                $mongoCriteria->IsDeleted('!=', 1);
                $mongoCriteria->IsBlockedWordExist('notIn', array(1, 2));
                $mongoCriteria->IsAbused('notIn', array(1, 2));
                $mongoCriteria->CategoryType('==', 9);
                //$mongoCriteria->IsNotifiable('==', 1);
                $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
                }
        
             }else{
                 
                     $orCondition=array('$or' =>[array('UserId' => 0,'SegmentId' =>  array('$in'=>array((int) $this->tinyObject['SegmentId'],0)), ),array('UserId' => (int)$this->tinyObject['UserId'])],
                );
                  if(trim($this->tinyObject['Language'])!="en"){
                 array_push($orCondition['$or'], array("Language"=>$this->tinyObject['Language']));
                  }
                $mongoCriteria->setConditions($orCondition);
                $mongoCriteria->IsDeleted('!=', 1);
                $mongoCriteria->IsBlockedWordExist('notIn', array(1, 2));
                $mongoCriteria->IsAbused('notIn', array(1, 2));
                $mongoCriteria->CategoryType('==', 9);
              
                $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
                if(Yii::app()->session['IsAdmin']!=1){
                     $mongoCriteria->IsNotifiable('==', 1); 
                
                }          

                    
                 
             }
       $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => $mongoCriteria
                ));
           
            if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $UserId =  $this->tinyObject['UserId'];
                   $streamRes = (object) (CommonUtility::prepareStreamData($UserId, $provider->getData(), $this->userPrivileges, 0,Yii::app()->session['PostAsNetwork'],'', $previousStreamIdArray));
                   $streamIdArray=$streamRes->streamIdArray;
                   $totalStreamIdArray=$streamRes->totalStreamIdArray;
                   $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                   $streamIdArray = array_values(array_unique($streamIdArray));                   
                   $stream=(object)($streamRes->streamPostData);
                   if (sizeof($streamRes->streamPostData) == 0) {
                        $stream = -2;
                    }
                } else {
                    
                    $stream = -1; //No more posts
                }

                $streamData = $this->renderPartial('gameWall', array('stream' => $stream,'userLanguage'=>Yii::app()->session['language']), true);
                $streamIdString = implode(',', $streamIdArray);
                echo $streamData."[[{{BREAK}}]]".$streamIdString;
        }  
        
       
      } catch (Exception $ex) {
          error_log("Exception Occurred in GameController->actionloadGameWall==".$ex->getMessage());
          Yii::log("GameController:actionloadGameWall::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    
  public function actionUpdateGameFields(){
      try{
        $gameId=$_REQUEST['gameId'];
        $gameField=$_REQUEST['gameFiled'];
        $Fieldvalue=$_REQUEST['Filedvalue'];
        $gameUpdatedFieldvalue=ServiceFactory::getSkiptaGameServiceInstance()->UpdateGameFields($gameId,$gameField,$Fieldvalue);

        if($gameUpdatedFieldvalue!="failure"){
            $obj = array("status"=>'success','FieldDescription'=>$gameUpdatedFieldvalue);
        }else{
            $obj = array("status"=>'failure');
        }
        echo CJSON::encode($obj);
     }catch(Exception $ex){
         Yii::log("GameController:actionUpdateGameFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }     
  }
  public function actionGameAnalytics(){
     try{
        $type = $_REQUEST['type'];
        $segmentId = $this->tinyObject['SegmentId'];
        if($type == "getGames"){
            $games = ServiceFactory::getSkiptaGameServiceInstance()->getGamesForAnalytics($segmentId);
            $this->renderPartial('gameAnalytics',array("type"=>$type,"games"=>$games));
        //  $data = $this->renderPartial('gameAnalytics',array("type"=>$type,"games"=>$games), true);
        //  $obj = array("status" => 'success', 'html' => $data, 'count'=>count($games));
        //   echo CJSON::encode($obj);
        }else  if($type == "getCumilative" && isset($_REQUEST['selectedGameId'])){
            $selectedGameId = $_REQUEST['selectedGameId'];
            $gameAnalytics = ServiceFactory::getSkiptaGameServiceInstance()->getGameAnalytics($selectedGameId, $segmentId);
            $this->renderPartial('gameAnalytics',array("type"=>$type,"gameCumulativeAnalytics" => $gameAnalytics)); 
        }else if($type == "getDetail"){
            $selectedGameId = $_REQUEST['selectedGameId'];
            $startLimit = $_REQUEST['startLimit'];
            $pageLength = $_REQUEST['pageLength'];
            $gameDetailAnalytics = ServiceFactory::getSkiptaGameServiceInstance()->getGameDetailAnalytics($selectedGameId,$startLimit,$pageLength);
            $this->renderPartial('gameAnalytics',array("type"=>$type,"gameDetailAnalytics" => $gameDetailAnalytics[0],"totalCount" => $gameDetailAnalytics[1],"gameId"=>$selectedGameId,"gameName"=>$gameDetailAnalytics[2])); 

        }
     }catch(Exception $ex){
         Yii::log("GameController:actionGameAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
 }
  
  

public function actionloadGameSchedule(){
    try {
        if(isset($_REQUEST['gameId'])){          
          $scheduleForm=new ScheduleGameForm();  
          $scheduleForm->GameName=$_REQUEST['gameId'];  
          $scheduleForm->StreamId=$_REQUEST['streamId'];  
//          Yii::app()->clientScript->scriptMap=array('jquery.yiiactiveform.js'=>true,'jquery.js'=>false);
          $data =  $this->renderPartial('scheduleGame', array('scheduleForm'=>$scheduleForm),true);
          echo $data;
        }
         
    } catch (Exception $ex) {
        error_log("Exception Occurred in GameController->actionloadGameSchedule==".$ex->getMessage());
        Yii::log("GameController:actionloadGameSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}  

      public function actionCancelSchedule() {
      try{
          $gameId = $_REQUEST['postId'];
          $scheduleId = $_REQUEST['scheduleId'];
        $return =  ServiceFactory::getSkiptaGameServiceInstance()->cancelSchedule($gameId,$scheduleId);
     
         if ($return != "failure") {
            $obj = array("status" => 'success');
        } else {
            $obj = array("status" => 'failure');
        }
         $obj = $this->rendering($obj);
            echo $obj;
      }catch(Exception $ex){
            Yii::log("GameController:actionCancelSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $obj = array("status" => 'failure');
              echo CJSON::encode($obj);
      }
    }
   public function actionSuspendGame() {
      try{$gameId = $_REQUEST['postId'];      
        $return =  ServiceFactory::getSkiptaGameServiceInstance()->suspendGame($gameId,$_REQUEST['actionType']);
     
         if ($return != "failure") {
            $obj = array("status" => 'success');
        } else {
            $obj = array("status" => 'failure');
        }
         $obj = $this->rendering($obj);
            echo $obj;
      }catch(Exception $ex){
            Yii::log("GameController:actionSuspendGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $obj = array("status" => 'failure');
              echo CJSON::encode($obj);
      }
    }
    public function actionloadSchduleGameWidget(){
        try {
            if(isset($_REQUEST['streamId'])){
                $streamId=$_REQUEST['streamId'];
                $gameId=$_REQUEST['gameId'];
                $condition = array(
                        'PostId' =>  array('==' => new MongoId($gameId)),
                        '_id' =>  array('==' => new MongoId($streamId)),                        
                        'CategoryType' => array('==' => 9),
                    );
                
             $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean',
            array(
                 
                 'criteria' => array( 
                    'conditions'=> $condition,
                    'sort'=>array('StartDate'=>EMongoCriteria::SORT_ASC)
                  )
                )); 
             if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else  {
                    $UserId =  $this->tinyObject['UserId'];
                   $streamRes = (object) (CommonUtility::prepareStreamData($UserId, $provider->getData(), $this->userPrivileges, 0, Yii::app()->session['PostAsNetwork']));
                   $stream=(object)($streamRes->streamPostData);
                } 
            
                $this->renderPartial('gameWall', array('stream' =>  $stream)); 
            }
            
        } catch (Exception $ex) {
            error_log("Exception Occurred in GameController->actionloadSchduleGameWidget==".$ex->getMessage());
            Yii::log("GameController:actionloadSchduleGameWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
        
        public function actionrendergGameDetailed(){
            $returnValue='failure';
            try {
               $gameId=$_REQUEST['postId'];               
               $gameDetails=ServiceFactory::getSkiptaGameServiceInstance()->getGameDetailsByIdObject($gameId);    
               if(is_object($gameDetails)){                   
                   $obj = array("status" => 'success',"gameName"=>$gameDetails->GameName,"currentScheduleId"=>(String)$gameDetails->CurrentScheduleId);
               }else{
                   $obj = array("status" => 'failure');
               }
               
               $obj = $this->rendering($obj);
            echo $obj;
               
            } catch (Exception $ex) {
                Yii::log("GameController:actionrendergGameDetailed::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
               $obj = array("status" => 'failure');
               $obj = $this->rendering($obj);
            echo $obj;
            }
                }
    public function actiongamedetail(){
     try{
         $postId = $_REQUEST['postId'];
        $categoryType = $_REQUEST['categoryType'];
        $postType = $_REQUEST['postType'];
        $out = $_REQUEST['outer'];
         $this->render('/post/postdetail',array('postId'=>$postId,'categoryType'=>$categoryType,'postType'=>$postType,'outer'=>$out));
     } catch (Exception $ex) {
          Yii::log("GameController:actiongamedetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
 }
 
 public function actionGamedetailed(){
      try {
            $gameName = $_REQUEST['postType'];
            $gameScheduleId = $_REQUEST['postId'];
            $mode = 'detail';

            $MoreCommentsArray = array();
            $tinyUserProfileObject = array();
            $object = array();
            $gameDetailsArray = ServiceFactory::getSkiptaGameServiceInstance()->getGameDetailsByName($this->tinyObject->UserId, $gameName, $gameScheduleId);

            $postId = $gameDetailsArray[0]->_id;
            $MinpageSize = 2;
            // $page = $_REQUEST['Page'];
            $page = 0;
            $pageSize = ($MinpageSize * $page);
            $categoryType = 9;
            $numberOfComments=5;
            $MoreCommentsArray = CommonUtility::prepareComments($pageSize, $MinpageSize, $gameDetailsArray[0]->_id, $categoryType, "",$MinpageSize);
            $commentedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getCommentedUsersForPost($postId, (int) ($this->tinyObject['UserId']));
            $IsUserCommented = in_array((int) ($this->tinyObject['UserId']), $commentedUsers);
            $canMarkAsAbuse = 0;
            $UserPrivileges = $this->userPrivileges;
           if (is_array($UserPrivileges)) {
               foreach ($UserPrivileges as $value) {
                   if ($value['Status'] == 1) {
                       if ($value['Action'] == 'Mark_As_Abuse') {
                           $canMarkAsAbuse = 1;
                       }
                   }
               }
           }
            $this->renderPartial('gameDetail', array("gameDetails" => $gameDetailsArray[0], "gameBean" => $gameDetailsArray[1], "mode" => $mode, 'commentsdata' => $MoreCommentsArray, 'IsCommented' => $IsUserCommented,"canMarkAsAbuse"=>$canMarkAsAbuse));
        } catch (Exception $ex) {
            Yii::log("GameController:actionGamedetailed::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        
 }
 
 public function actionGetGamesForSearch() {
     try{
        $searchText = $_POST['search'];
        $offset = $_POST['offset'];
        $pageLength = $_POST['pageLength'];
        $postSearchResult = ServiceFactory::getSkiptaPostServiceInstance()->getGamesForSearch($searchText, $offset, $pageLength);
        $this->renderPartial('/post/post_search', array('postSearchResult' => $postSearchResult));
     }catch(Exception $ex){
         Yii::log("GameController:actionGetGamesForSearch::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
        
    }
 
 
 
}