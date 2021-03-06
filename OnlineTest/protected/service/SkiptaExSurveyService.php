
<?php 
class SkiptaExSurveyService {
    
    public function saveSurvey($FormModel,$NetworkId,$UserId){
        try{
            $return = "failed";
            $FormModel->SurveyLogo = $this->savePublicationArtifacts($FormModel->SurveyLogo,'/upload/ExSurvey/');
//            $FormModel->QuestionImage = $this->savePublicationArtifacts($FormModel->QuestionImage,'/upload/ExSurvey/');
            if($FormModel->IsBranded == 1)
           
                $FormModel->BrandLogo = $this->savePublicationArtifacts($FormModel->BrandLogo,'/upload/ExSurvey/Branded/');
            if(!empty($FormModel->SurveyId)){
                $return = $this->updateSurveyObject($FormModel);
            }else{
                $return = ExtendedSurveyCollection::model()->saveSurvey($FormModel,$NetworkId,$UserId);
            }
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:saveSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->saveSurvey### ".$ex->getMessage());
        }
    }
    
    function savePublicationArtifacts($Artifacts,$folderPath) {

     try {
          
         $returnValue = 'failure';
            $Resource = array();
            $folder = Yii::app()->params['WebrootPath'];
            $returnarry = array();
            if ($Artifacts != "") {
                $ExistArtifact = $folder . $Artifacts;
                if (!file_exists($ExistArtifact)) {
                    $imgArr = explode(".", $Artifacts);
                    $date = strtotime("now");
                    $finalImg_name = $imgArr[0] . '.' . end($imgArr);
                    $finalImage = trim($imgArr[0]) . '.' . end($imgArr);

                    $fileNameTosave = $folder . '/temp/' . $imgArr[0] . '.' . end($imgArr);
                    $sourceArtifact = $folder . '/temp/' . $Artifacts;
                    if(file_exists($fileNameTosave))
                     rename($sourceArtifact, $fileNameTosave);
                    //  $filename=$result['filename'];
                    $extension = substr(strrchr($Artifacts, '.'), 1);
                    $extension = strtolower($extension);

                   // $path = 'Profile';

                    $path = $folderPath . $path;                    
                    if (!file_exists($folder . '/' . $path)) {

                        mkdir($folder . '/' . $path, 0755, true);
                    }
                    $sourcepath = $fileNameTosave;
                    $destination = $folder . $path . '/' . $finalImage;
                    if (file_exists($sourcepath)) {
                                list($width, $height) = getimagesize($sourcepath);
                              
                                if ($width >= 250) {
                                    $img = Yii::app()->simpleImage->load($sourcepath);
                                    $img->resizeToWidth(250);
                                    $img->save($destination);
                                   
                                } else {
                                   $destination = $folder . $path . '/' . $finalImage;
                                    copy($sourcepath, $destination);
                                }
                       
                       
                       // if (copy($sourcepath, $destination)) {
                            $newfile = trim($imgArr[0]) . '_' . $date . '.' . end($imgArr);
                            //  $newfile=trim($imgArr[0]) .'.' . $imgArr[1];
                            $finalSaveImage = $folder . $path . '/' . $newfile;
                            rename($destination, $finalSaveImage);
                            $UploadedImage = $path . $newfile;
                            $Resource['ResourceName'] = $artifact;
                            $Resource['Uri'] = $UploadedImage;
                            $Resource['Extension'] = $extension;
                            $Resource['ThumbNailImage'] = $UploadedImage;

                            // unlink($sourcepath);
                            $returnValue = "success";
                        //}
                    } else {                        
                        $UploadedImage = $path .$Artifacts;
                    }
                } else {
                    $UploadedImage = $Artifacts;
                    $Resource['ResourceName'] = "";
                    $Resource['Uri'] = "";
                    $Resource['Extension'] = "";
                    $Resource['ThumbNailImage'] = $UploadedImage;
                }
            }
                 return $UploadedImage;
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:savePublicationArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 

   }
   
   function saveVideoArtifacts($Artifacts,$folderPath) {

     try {
          
         $returnValue = 'failure';
            $Resource = array();
            $folder = Yii::app()->params['WebrootPath'];
            $returnarry = array();
            if ($Artifacts != "") {
                $ExistArtifact = $folder . $Artifacts;
                if (!file_exists($ExistArtifact)) {
                    $imgArr = explode(".", $Artifacts);
                    $date = strtotime("now");
                    $finalImg_name = $imgArr[0] . '.' . end($imgArr);
                    $finalImage = trim($imgArr[0]) . '.' . end($imgArr);

                    $fileNameTosave = $folder . '/temp/' . $imgArr[0] . '.' . end($imgArr);
                    $sourceArtifact = $folder . '/temp/' . $Artifacts;
                    if(file_exists($fileNameTosave))
                     rename($sourceArtifact, $fileNameTosave);
                    //  $filename=$result['filename'];
                    $extension = substr(strrchr($Artifacts, '.'), 1);
                    $extension = strtolower($extension);

                   // $path = 'Profile';
                    $path = $folderPath . $path;                    
                    if (!file_exists($folder . '/' . $path)) {
                        mkdir($folder . '/' . $path, 0755, true);
                    }
                    $sourcepath = $fileNameTosave;
                    $destination = $folder . $path . '/' . $finalImage;
                    if (file_exists($sourcepath) && $extension != "mp3" && $extension != "mp4") {
                                list($width, $height) = getimagesize($sourcepath);
                              
                                if ($width >= 250) {
                                    $img = Yii::app()->simpleImage->load($sourcepath);
                                    $img->resizeToWidth(250);
                                    $img->save($destination);
                                   
                                } else {
                                   $destination = $folder . $path . '/' . $finalImage;
                                    copy($sourcepath, $destination);
                                }
                       
                       
                       // if (copy($sourcepath, $destination)) {
                            $newfile = trim($imgArr[0]) . '_' . $date . '.' . end($imgArr);
                            //  $newfile=trim($imgArr[0]) .'.' . $imgArr[1];
                            $finalSaveImage = $folder . $path . '/' . $newfile;
                            rename($destination, $finalSaveImage);
                            $UploadedImage = $path . $newfile;
                            $Resource['ResourceName'] = $artifact;
                            $Resource['Uri'] = $UploadedImage;
                            $Resource['Extension'] = $extension;
                            $Resource['ThumbNailImage'] = $UploadedImage;

                            // unlink($sourcepath);
                            $returnValue = "success";
                        //}
                    } else {                        
                        $destination = $folder . $path . '/' . $finalImage;                       
                        copy($sourcepath, $destination);                        
                        $newfile = trim($imgArr[0]) . '_' . $date . '.' . end($imgArr);
                        $finalSaveImage = $folder . $path . '/' . $newfile;
                        rename($destination, $finalSaveImage);
                        $UploadedImage = $path . $newfile;
                        $Resource['ResourceName'] = $artifact;
                        $Resource['Uri'] = $UploadedImage;
                        $Resource['Extension'] = $extension;
                        $Resource['ThumbNailImage'] = $UploadedImage;
                        $UploadedImage = $path .$Artifacts;
                    }
                } else {
                    $extension = substr(strrchr($Artifacts, '.'), 1);
                    $extension = strtolower($extension);
                    $UploadedImage = $Artifacts;
                    $Resource['ResourceName'] = $UploadedImage;
                    $Resource['Uri'] = $UploadedImage;
                    $Resource['Extension'] = $extension;
                    $Resource['ThumbNailImage'] = $UploadedImage;
                }
            }
                 return $Resource;
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:savePublicationArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 

   }
   
   public function getSurveyDetailsById($columnName,$_id){
       try{
           return ExtendedSurveyCollection::model()->getSurveyDetailsById($columnName,$_id);
        
           } catch (Exception $ex) {
               Yii::log("SkiptaExSurveyService:getSurveyDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in SkiptaExSurveyService->getSurveyDetailsById### ".$ex->getMessage());
       }
   }
    public function getCustomSurveyDetailsById($columnName,$_id,$scheduleId,$page,$categoryId,$action="next"){
       try{
  

          $questionsArray =  UserQuestionsCollection::model()->getQuestionFromCollectionForPagination($_id,$categoryId,$page,$action);
          $questionId = $questionsArray['questionId'];
          $categoryId = $questionsArray['categoryId'];
           $nocategories = $questionsArray['nocategories'];
           $scheduleId = $questionsArray['scheduleId'];
           $cateogryIds = $questionsArray['catIdsArray'];
           $catPosition = $questionsArray['categoryPosition'];
        
          $page = $questionsArray['page'];
          $totalpages = $questionsArray['totalpages'];
          
          $result = ExtendedSurveyCollection::model()->getQuestionById($categoryId,$questionId);
           $resultArray = array("data"=>$result,"categoryId"=>$categoryId,"page"=>$page,"nocategories"=>$nocategories,"totalpages"=>$totalpages,"scheduleId"=>$scheduleId,"catIdsArray"=>$cateogryIds,"catPosition"=>$catPosition);
        

           return $resultArray;
           } catch (Exception $ex) {
               Yii::log("SkiptaExSurveyService:getCustomSurveyDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in SkiptaExSurveyService->getCustomSurveyDetailsById### ".$ex->getMessage());
       }
   }
   
   
   public function updateSurveyObject($model){
       try{
           $questions = $model->Questions;
//           foreach ($questions as $key => $value) {
               
            $QuestinExist = ExtendedSurveyCollection::model()->CheckQuestionExist($model->SurveyId, $value->QuestionId);
            ExSurveyResearchGroup::model()->findAndUpdate($model->SurveyRelatedGroupName,$model->SurveyLogo);
            
            if ($QuestinExist == true) {           
                $scheduleObj = ScheduleSurveyCollection::model()->getActiveSchedule($model->SurveyId);
//                if(isset($scheduleObj->_id)){
//                    Advertisements::model()->updateAdValuesByScheduleId($scheduleObj->_id,$model);
//                }
                $QuestinExist = ExtendedSurveyCollection::model()->UpdateSurvey($model->SurveyId, $model);
            } 
       } catch (Exception $ex) {
           Yii::log("SkiptaExSurveyService:updateSurveyObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
   }
   
   public function checkForScheduleSurvey($startDate,$endDate,$surveyId,$groupName) {
        try {
            return ScheduleSurveyCollection::model()->checkSurveyScheduleForDates($startDate,$endDate,$surveyId,$groupName);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:checkForScheduleSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    

    public function saveScheduleSurvey($scheduleSurveyForm,$userId,$NetworkName="",$language="en") {

        try {
            $returnValue='failure';
            $previousSchedule = 0;
            $previousScheduleDetails = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject('SurveyId', $scheduleSurveyForm->SurveyId);
            if (!is_string($previousScheduleDetails)) {
                $previousSchedule = $previousScheduleDetails;
            }
            $currentScheduleSurvey = 0;
            $sDate = strtotime($scheduleSurveyForm->StartDate);
            $cDate = strtotime(date('m/d/y H:i:s'));
            $IsNotifiable=0;
            
            if ($sDate < $cDate) {
                $checkAndUpdatePreviousSchedules = ScheduleSurveyCollection::model()->updatePreviousSchedulesToZero($scheduleSurveyForm->StartDate,$scheduleSurveyForm->SurveyId);
                ExtendedSurveyCollection::model()->updateSurveyForIsCurrentSchedule("IsCurrentSchedule", (int) 1, $scheduleSurveyForm->SurveyId);
                $currentScheduleSurvey = (int) 1;
                $IsNotifiable=1;
            }
            $scheduleDetails = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject('IsCurrentSchedule', (int) 1);
            $createdDate = "";
            
            /*
             * This code is creating a InStream Ad...
             * 
             */
            $result = ScheduleSurveyCollection::model()->saveScheduleSurvey($scheduleSurveyForm, $currentScheduleSurvey,$userId,$createdDate);
//            if($scheduleSurveyForm->ConvertInStreamAdd == 1){
//            
//
//                $obj=  $this->createStreamAdObjectForSurvery($scheduleSurveyForm,$userId,$result,$NetworkName,$language);  
//            }
            $returnValue = ExtendedSurveyCollection::model()->updateSurveyForIsCurrentSchedule("CurrentScheduleId", $result, $scheduleSurveyForm->SurveyId);           
            return $returnValue;
        } catch (Exception $ex) {            
            Yii::log("SkiptaExSurveyService:saveScheduleSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->saveScheduleSurvey### ".$ex->getMessage());
            return $returnValue;
        }
    }
    public function suspendSurvey($surveyId, $actionType = "Suspend") {
        try {
            $return = "failure";            
            if ($actionType == "Suspend") {
                $return = ScheduleSurveyCollection::model()->removeFutureSurveySchedule($surveyId, date("Y-m-d H:i:s", CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())), '', "future");
                $currentScheduleSurvey = ExtendedSurveyCollection::model()->isCurrentScheduleSurvey($surveyId);
                ExtendedSurveyCollection::model()->suspendORReleaseSurvey($surveyId, 1);
                if (isset($currentScheduleSurvey) && is_object($currentScheduleSurvey)) {
                    $currentScheduleSurvey = ScheduleSurveyCollection::model()->updateCurrentScheduleSurveyByToday($surveyId, date("Y-m-d H:i:s", CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())));
                }
                $pastSchedule = ScheduleSurveyCollection::model()->getPreviousOrFutureSurveySchedule($surveyId, date("Y-m-d H:i:s", CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())), "", "past");
                if (isset($pastSchedule) && is_object($pastSchedule)) {
                    $pastScheduleId =  $pastSchedule->_id;
                } else {
                    ExtendedSurveyCollection::model()->suspendORReleaseSurvey($surveyId, 1);
                    $pastScheduleId = "";
                }
                $schobj = ScheduleSurveyCollection::model()->getActiveSchedule($surveyId);
                ExtendedSurveyCollection::model()->updateSurveyForIsCurrentSchedule("CurrentScheduleId", $pastScheduleId, $surveyId);
                // Suspend the In stream add related to the Survey....
//                   if(isset($schobj) && $schobj != 0)
//                    $res = Advertisements::model()->externalAddCloseByCurrentDate($surveyId,$schobj->_id);
                   if($res!="failure"){                       
                      UserStreamCollection::model()->updateStreamForSurveyAdvertisement($res["id"]);
                   }
            } else {
                
                ExtendedSurveyCollection::model()->suspendORReleaseSurvey($surveyId, 0);               
            }
            
            return "success";
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:suspendSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function cancelScheduleSurvey($surveyId, $scheduleId) {
        try {
            $return = "failure";
         

                $iscurrentSchedule = ScheduleSurveyCollection::model()->isCurrentScheduleByScheduleId($surveyId, $scheduleId);
                $checkAndUpdatePreviousSchedules = ScheduleSurveyCollection::model()->updatePreviousSchedulesToZero(date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())),$surveyId);
                if ($iscurrentSchedule == true) {
                    /**
                     * if schedule is current schedule , then we need to update that schedule today date
                     */
                    $currentScheduleSurvey = ScheduleSurveyCollection::model()->updateCurrentScheduleSurveyByToday($scheduleId,$surveyId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())));
                } else {
                    $currentScheduleSurvey = ScheduleSurveyCollection::model()->removeScheduleByScheduleId($scheduleId);
                }
               //  return;
                $obj = ScheduleSurveyCollection::model()->getPreviousOrFutureSurveySchedule($surveyId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())), "", "past");
                $iscontainSchedule = false;
                if (isset($obj) && is_object($obj)) {
                    $iscontainSchedule = true;
                } else {
                    $obj = ScheduleSurveyCollection::model()->getPreviousOrFutureSurveySchedule($surveyId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())), "", "future");

                    $iscontainSchedule = true;
                }
                 
                if ($iscontainSchedule == true) {
                    $currentScheduleId =  $obj->_id;
                } else {
                    $currentScheduleId =  "";
                }
                // Suspend the In stream add related to the Survey....
                //$res = Advertisements::model()->externalAddCloseByCurrentDate($surveyId,$scheduleId);
                  if($res!="failure"){
                      UserStreamCollection::model()->updateStreamForSurveyAdvertisement($res["id"]);
                }
              
                ExtendedSurveyCollection::model()->updateSurveyForIsCurrentSchedule("CurrentScheduleId",$currentScheduleId,$surveyId);
                
            return "success";
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:cancelScheduleSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->cancelScheduleSurvey### ".$ex->getMessage());
        }
    }
    
    public function saveSurveyAnswer($model, $NetworkId, $UserId, $fromPagination, $fromAutoSave, $fromPage,$questionTempId=0,$eachquestionscore=0,$finalDone) {
        try {

            if ($fromPagination == 1 || $fromAutoSave == 1) {
                //if($finalDone!=1){
                       
                        
                return SurveyUsersSessionCollection::model()->updateSurveyAnswer2($model, $NetworkId, $UserId, "", $fromAutoSave, $fromPage,$questionTempId,$eachquestionscore,$finalDone);
                // return ScheduleSurveyCollection::model()->updateSurveyAnswer($model,$NetworkId,$UserId,"");
            } else {
                  error_log("-----final done-----");
                //check spots
               
                    $fromPage = $fromPage > 1 ? $fromPage - 1 : 1;
                    SurveyInteractionCollection::model()->trackSurveyLogout("", $UserId, $model->ScheduleId, $model->SurveyId, $fromPage, "notRefresh");

                    $result = SurveyUsersSessionCollection::model()->updateSurveyAnswer2($model, $NetworkId, $UserId, 'Done', $fromAutoSave, $fromPage,$questionTempId,$eachquestionscore,$finalDone);

                    $surveyDetails = ExtendedSurveyCollection::model()->getSurveyDetailsById('Id', $model->SurveyId);
                 
                    return $result;

                    //return ScheduleSurveyCollection::model()->updateSurveyAnswer($model,$NetworkId,$UserId,"Done");
                
            }
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:saveSurveyAnswer::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->saveSurveyAnswer### ".$ex->getMessage());
        }
    }

    public function getSurveyAnalytics($userId,$scheduleId){
        try{
            return CommonUtility::prepateSurveyAnalyticsData($userId,$scheduleId);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getSurveyAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->getSurveyAnalytics### ".$ex->getMessage());
        }
    }
        
    public function isAlreadyDoneByUser($UserId,$GroupName){
        try{
            $result = ExtendedSurveyCollection::model()->getSurveyDetailsByGroupName('GroupName',$GroupName);
            return ScheduleSurveyCollection::model()->isAlreadyDoneByUser($UserId,$GroupName,$result);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:isAlreadyDoneByUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getSurveyAnalyticsData($pageLength,$startLimit,$searchText,$filterValue,$timezone){
        try{
            return ScheduleSurveyCollection::model()->getSurveyAnalyticsData($pageLength,$startLimit,$searchText,$filterValue,$timezone);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getSurveyAnalyticsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->getSurveyAnalyticsData### ".$ex->getMessage());
        }
    }
    
    public function getSurveyAnalyticsDataCount($filterValue,$searchText){
        try{
            return ScheduleSurveyCollection::model()->getSurveyAnalyticsDataCount($filterValue,$searchText);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getSurveyAnalyticsDataCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->getSurveyAnalyticsDataCount### ".$ex->getMessage());
        }
    }
    

     public function createStreamAdObjectForSurvery($scheduleObj,$userId,$scheduleId,$NetworkName,$language='en'){
        try{
            $advertisementForm=new AdvertisementForm();
            
                  $advertisementForm->ScheduleId = $scheduleId;
           
            $advertisementForm->AdTypeId = 4;
            $advertisementForm->DisplayPage = "Home";
            if(trim(Yii::app()->params['NetworkName'])=="Skipta Diabetes"){
            $advertisementForm->DisplayPage = "Curbside";
            }
            $advertisementForm->Status = 1;
            $advertisementForm->SourceType = "Upload";
            $advertisementForm->RedirectUrl = Yii::app()->params['ServerURL']."/marketresearchview/1/$scheduleObj->SurveyRelatedGroupName";
            $advertisementForm->StartDate =  CommonUtility::convert_time_zone(strtotime($scheduleObj->StartDate), Yii::app()->session['timezone'],date_default_timezone_get() );
            $advertisementForm->ExpiryDate = CommonUtility::convert_time_zone(strtotime($scheduleObj->EndDate), Yii::app()->session['timezone'],date_default_timezone_get() );
            $advertisementForm->Name = "Survey Ad";
            
            $advertisementForm->BannerTitle = ' <div id="AdBannerTitle"  class="addbannaertitle  addbannerhighlight aligncenter"  style="color: rgb(30, 29, 27);">'.$scheduleObj->SurveyTitle.'</div> ';
            $advertisementForm->BannerContent = '<div id="AdBannerContent" class="addbannerdescription addbannerhighlight aligncenter"  style="color: rgb(30, 29, 27);">'.$scheduleObj->SurveyDescription.'</div> ';
            $advertisementForm->BannerOptions = "OnlyImage";
            $advertisementForm->BannerTemplate = 0;
            $fgroupName = "";
            if($scheduleObj->SurveyRelatedGroupName == "Public" || $scheduleObj->SurveyRelatedGroupName == "0"){
                $fgroupName = Yii::app()->params['NetworkName'];
            }else{
                $fgroupName = $scheduleObj->SurveyRelatedGroupName;
            }
            $surveyObj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById("Id", $scheduleObj->SurveyId);
            $title = $NetworkName;
            if(isset($surveyObj) && $surveyObj->IsBranded == 1){
                $title = "";
                $advertisementForm->ExternalPartyUrl = $surveyObj->BrandLogo;
                $advertisementForm->IsThisExternalParty = 1;
                $advertisementForm->ExternalPartyName = $surveyObj->BrandName;
                
            }
            $advertisementForm->Title = $title." has introduced a new Market Research Survey";

            $extension = substr(strrchr($scheduleObj->InstreamAdArtifact, '.'), 1);
                    $extension = strtolower($extension);
            $adImguploadArray = array(
                "Language" => $language,
                "Type" => $extension,
                "Url" => $scheduleObj->InstreamAdArtifact
                );
            $advertisementForm->Uploads = CJSON::encode(array($adImguploadArray));
            $advertisementForm->ExternalReferenceId = $scheduleObj->SurveyId;
            if(!empty($scheduleObj->InstreamAdArtifact)){
                $filepath = Yii::getPathOfAlias('webroot').$scheduleObj->InstreamAdArtifact;
                CommonUtility::resizeImage($filepath,"width",600);               
                
            }
            $advertisementForm->IsMarketRearchAd = 1;
            $advertisementForm->SurveyGroupName = $scheduleObj->SurveyRelatedGroupName;
            $advertisementForm->SurveyName = $scheduleObj->SurveyId;
            $result = ServiceFactory::getSkiptaAdServiceInstance()->saveNewAdService($advertisementForm, $userId,"new");
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:createStreamAdObjectForSurvery::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->createStreamAdObjectForSurvery### ".$ex->getMessage());
        }
    }
    
     public function getSurveyAnalyticsByGroupName($userId,$groupName,$surveyId,$timezone){
        try{            
            return CommonUtility::prepateSurveyAnalyticsDataByGroup($userId,$groupName,$surveyId,$timezone);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getSurveyAnalyticsByGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->getSurveyAnalyticsByGroupName### ".$ex->getMessage());
        }
    }
    
    public function getScheduleSurveyById($columnName,$value){
        try{
            return ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject($columnName,$value);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getScheduleSurveyById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->getScheduleSurveyById### ".$ex->getMessage());
        }
    }
    
    public function getUserOtherValues($surveyId, $questionId,$startLimit,$pageLength){
        try{
            return ScheduleSurveyCollection::model()->getUserOtherValues($surveyId, $questionId,$startLimit,$pageLength);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getUserOtherValues::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->getUserOtherValues### ".$ex->getMessage());
        }
    }
    
    public function IsSurveyAlreadySchedule($surveyObj){
        try{
            return ScheduleSurveyCollection::model()->IsSurveyAlreadySchedule($surveyObj);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:IsSurveyAlreadySchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function saveUserTaxInfoDetails($model){
        try{
            $returnvalue = "failure";
            $obj = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject("Id",$model->ScheduleId);
            if(isset($obj) && !empty($obj)){
                $returnvalue = UserTaxAndRegulatoryInfo::model()->saveUserInfo($model);
            }
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:saveUserTaxInfoDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->saveUserTaxInfoDetails### ".$ex->getMessage());
        }
    }
    
    public function getProfileDetails($userId,$scheduleId,$surveyId){
        try{
            $returnvalue = UserTaxAndRegulatoryInfo::model()->getProfileDetails($userId,$scheduleId,$surveyId);
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getProfileDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->getProfileDetails### ".$ex->getMessage());
        }
    }
    public function getUserTaxInfoDetails($userId){
        try{
            $returnvalue = "failure";
            $returnvalue = UserTaxAndRegulatoryInfo::model()->getUserInfo($userId);
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getUserTaxInfoDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->getUserTaxInfoDetails### ".$ex->getMessage());
        }
    }
    
    public function updateThanksFlagId($schdId){
        try{
            ScheduleSurveyCollection::model()->updateThanksFlagId($schdId);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:updateThanksFlagId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function logoutSurveyPage($userId,$scheduleId,$surveyId,$page){
        try{
            SurveyInteractionCollection::model()->trackSurveyLogout("",$userId,$scheduleId,$surveyId,$page,"notRefresh");
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:logoutSurveyPage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getOtherDataForQuestion($scheduleId,$questionId,$questionType){
        try{
            return ScheduleSurveyCollection::model()->getOtherDataForQuestion($scheduleId,$questionId,$questionType);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getOtherDataForQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function getJustificationDataForQuestion($surveyId,$scheduleId,$questionId,$questionType,$offset,$pageLimit){
        try{
            $justificatonData = ScheduleSurveyCollection::model()->getJustificationDataForQuestion($scheduleId,$questionId,$questionType,$offset,$pageLimit);
           return CommonUtility::prepareJustificationData($surveyId,$questionId,$justificatonData,$questionType);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getJustificationDataForQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getAnswersDataForQuestion($surveyId, $scheduleId, $questionId, $questionType, $offset, $pageLimit){
        try{
            $seeAnswersData = ScheduleSurveyCollection::model()->getAnswersDataForQuestion($scheduleId,$questionId,$questionType,$offset,$pageLimit);
            return CommonUtility::prepareSeeAnswersData($surveyId,$questionId,$seeAnswersData,$questionType);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getAnswersDataForQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getSurveyAdvertisementByScheduleId($scheduleId){
        try{
            return "failure";
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getSurveyAdvertisementByScheduleId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    

    public function getSurveyDetailsBySurveyId($columnName, $surveyId){
       try{           
          
           $returnValue = ScheduleSurveyCollection::model()->getSurveyDetailsBySurveyId($columnName, $surveyId);
           
           return $returnValue;           
        
           } catch (Exception $ex) {
        Yii::log("SkiptaExSurveyService:getSurveyDetailsBySurveyId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
   }
    
   /**
    * 
    * @developer kishroe
    * @param type $groupName
    * @return type
    */

    public function getSurveyListByGroupName($groupName){
        try{
            return ExtendedSurveyCollection::model()->getSurveyListByGroupName($groupName);
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:getSurveyListByGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function saveScheduleSurveydump($scheduleSurveyForm,$userId) {

        try {
            $returnValue='failure';
            
            $result = ScheduleSurveyCollection::model()->saveScheduleSurveydump($scheduleSurveyForm, "",$userId,$createdDate);
//            if($scheduleSurveyForm->ConvertInStreamAdd == 1){
//            
//
//                $obj=  $this->createStreamAdObjectForSurvery($scheduleSurveyForm,$userId,$result,$NetworkName,$language);  
//            }
            $returnValue = $result;
            return $returnValue;
        } catch (Exception $ex) {            
            Yii::log("SkiptaExSurveyService:saveScheduleSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->saveScheduleSurvey### ".$ex->getMessage());
            return $returnValue;
        }
    }
    /*
     * @praveen get Total questions for category start
    */
    public function getTotalQuestionsForCategory($value){
        try{
            return ExtendedSurveyCollection::model()->getTotalQuestions($value);
             
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:isAlreadyDoneByUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /*
     * @Praveen P check the TestPaper exist or not in TestPreparationCollection
     */
    public function getTestDetailsById($columnName,$value){
       try{
           return TestPreparationCollection::model()->getTestDetailsById($columnName,$value);
        
           } catch (Exception $ex) {
               Yii::log("SkiptaExSurveyService:getTestDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in SkiptaExSurveyService->getTestDetailsById### ".$ex->getMessage());
       }
   }
   
   /*
     * @Praveen P get the TestPaper Reports ScheduleSurveyCollection
     */
    public function getTestReportsForIndex($columnName,$value){
       try{
           return ScheduleSurveyCollection::model()->getTestReportsForIndex($columnName,$value);
        
           } catch (Exception $ex) {
               Yii::log("SkiptaExSurveyService:getTestDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in SkiptaExSurveyService->getTestDetailsById### ".$ex->getMessage());
       }
   }
    public function getTestReports($columnName,$value,$startDate,$endDate,$searchCategoryScore,$startLimit,$pageLength){
       try{
           return ScheduleSurveyCollection::model()->getTestReports($columnName,$value,$startDate,$endDate,$searchCategoryScore,$startLimit,$pageLength);
        
           } catch (Exception $ex) {
               Yii::log("SkiptaExSurveyService:getTestDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in SkiptaExSurveyService->getTestDetailsById### ".$ex->getMessage());
       }
   }
   
     public function getReviewQuestions($testPaperId,$userId){
       try{
           $resultValue =  ScheduleSurveyCollection::model()->getReviewQuestions($testPaperId,$userId);
            $questionObjArray = array();
           if($resultValue != "failure" ){
                foreach($resultValue as $value){
                 // error_log("---".print_r($value,1));
                  $categoryId = $value["_id"];
                  $categoryNames = $value["CategoryNames"];
                  $reviewQuestionIds = $value["ReviewQuestionIds"];
                   $reviewQuestionUniqueIds = $value["ReviewQuestionUniqueIds"];
                   $reviewQuestionAnswers = $value["ReviewQuestionAnswers"];
                 
                  foreach ($reviewQuestionIds as $key=>$questionId) {
                     $questionObj = ExtendedSurveyCollection::model()->getQuestionById($categoryId,$questionId); 
                     $answer = $reviewQuestionAnswers[$key];
                     $uniqueId = $reviewQuestionUniqueIds[$key];
                     $categoryName = $categoryNames[$key];
                     array_push($questionObjArray,array("question"=>$questionObj,"answer"=>$answer,"categoryId"=>$categoryId,"categoryName"=>$categoryName,"testId"=>$testPaperId,"uniqueId"=>$uniqueId));
                           error_log($categoryName."@@@@@@@@@123@@@@@@@@@@#######".  $questionId);
                  }
                   

                  
//                   $finalArray[$value["_id"]]=$value["Score_Sum"];
//                   $finalArray[$value["_id"].'_IsReview']=$value["IsReviewed"];
                   
              }
         }  
         
           return $questionObjArray;
           } catch (Exception $ex) {
               Yii::log("SkiptaExSurveyService:getTestDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in SkiptaExSurveyService->getTestDetailsById### ".$ex->getMessage());
       }
   }
   
       public function saveReviewQuestions($testPaperId,$userId,$questionId,$categoryId,$uniqueId,$score){
       try{
           $resultValue =  ScheduleSurveyCollection::model()->saveReviewQuestions($testPaperId,$userId,$questionId,$categoryId,$uniqueId,$score);
           return $resultValue;
           } catch (Exception $ex) {
               Yii::log("SkiptaExSurveyService:saveReviewQuestions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in SkiptaExSurveyService->saveReviewQuestions### ".$ex->getMessage());
       }
   }
   
}