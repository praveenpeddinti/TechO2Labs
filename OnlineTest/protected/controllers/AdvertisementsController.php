<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AdvertisementsController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function init() {
        try{
            parent::init();
            if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
                $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
                $this->userPrivileges = Yii::app()->session['UserPrivileges'];
                $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
                $this->whichmenuactive = 8;
                $this->sidelayout = 'no';
            } else {
                $this->redirect('/');
            }
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex() {
        try{
            $advertisementForm = new AdvertisementForm();
            $adTypes = array();
            $adTypesResult = ServiceFactory::getSkiptaAdServiceInstance()->getAdTypes();
            if (is_array($adTypesResult)) {
                $adTypes = $adTypesResult;
            }
            $adRequestedFields = array();
            $adRequestedFieldsResult = ServiceFactory::getSkiptaAdServiceInstance()->getAdRequestedFields();
            if (is_array($adRequestedFieldsResult)) {
                $adRequestedFields = $adRequestedFieldsResult;
            }
              $languages = ServiceFactory::getSkiptaUserServiceInstance()->getAllLanguages();
            $groupDetals = ServiceFactory::getSkiptaGroupServiceInstance()->loadOnlyGroupNames();
            $this->render('index', array('advertisementForm' => $advertisementForm, 'groupNames' => $groupDetals, 'adTypes' => $adTypes, 'adRequestedFields' => $adRequestedFields,'languages'=>$languages));
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionnewAdvertisement() {
        try {
            $advertisementForm = new AdvertisementForm();
            if (isset($_POST['AdvertisementForm'])) {
                $advertisementForm->attributes = $_POST['AdvertisementForm'];
                $userId = $this->tinyObject['UserId'];
                $errors = CActiveForm::validate($advertisementForm);
               
                if ($errors == '[]') {
                    if ($advertisementForm->AdTypeId == 1 && $advertisementForm->DoesthisAdrotateHidden != "ok") {
                        $segmentId=(int)(isset($this->tinyObject['SegmentId'])?$this->tinyObject['SegmentId']:0);
                        $result = ServiceFactory::getSkiptaAdServiceInstance()->isAnyAdsConfiguredWithThisDisplayPosition($advertisementForm->DisplayPosition, $advertisementForm->AdTypeId, $advertisementForm->DisplayPage, $advertisementForm->StartDate, $advertisementForm->ExpiryDate, $advertisementForm->IsThisAdRotate, $advertisementForm->id, $advertisementForm->Status, $segmentId);
                        if ($result) {
                            $errors = array();
                            $errors["popupMessage"][] = "In This Display Page with this Dislay Position, between this Start Date And Expiry Date  other Ad are configured. Plese set Time Interval for this Ad else this Ad will be create with inactive status";
                        }
                    }
                    if($advertisementForm->AdTypeId != 1 && $advertisementForm->FileName!="") {
                            $webroot = Yii::app()->params['WebrootPath'];
                            $filePath = $webroot . "temp/$advertisementForm->FileName";
                            $emailArrays = array();
                            if (($handle = fopen($filePath, "r")) !== FALSE) {
                                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                    $num = count($data);
                                    $row++;
                                    for ($c = 0; $c < $num; $c++) {
                                        $email = $data[$c];
                                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                array_push($emailArrays, $email);
                                        }else {
                                            $errors = array();
                                            $errors["AdvertisementForm_emailserros"][] = "Please check some of the emails are not valid";
                                        }
                                    }
                                }
                                fclose($handle);
                               $advertisementForm->FileName=$emailArrays;
                            }
                        }
                        if ($advertisementForm->AdTypeId == 2 && $advertisementForm->IsPremiumAd == 1 && $advertisementForm->DoesthisAdrotateHidden != "ok" && $advertisementForm->Status == 1) { 
                            $result = ServiceFactory::getSkiptaAdServiceInstance()->isPremiumAdSlotFilled(Yii::app()->params['PremiumAdSlots'], $advertisementForm->AdTypeId, $advertisementForm->DisplayPage, $advertisementForm->StartDate, $advertisementForm->ExpiryDate, $advertisementForm->id, $advertisementForm->Status, $segmentId);
                            if ($result) {
                            $errors = array();
                            $errors["popupMessage"][] = "In This Display Page with this Dislay Position, between this Start Date And Expiry Date  other Ad are configured. Plese set Time Interval for this Ad else this Ad will be create with inactive status";
                        }
                        }
                } 
                //return;
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $adname = $advertisementForm->DisplayPosition;
                    if ($advertisementForm->AdTypeId != 1) {
                        if (!empty($advertisementForm->Url)) {
                            $filepath = Yii::getPathOfAlias('webroot') . $advertisementForm->Url;
                     if(file_exists($filepath)){
                          $img = Yii::app()->simpleImage->load($filepath);   
                            list($width, $height) = getimagesize($filepath);
                            if ($width > '600') {
                                $img->resizeToWidth(600);
                                $img->save($filepath);
                            }
                        }
                           
                        }
                        if ($advertisementForm->IsThisExternalParty == 1) {
                            $logofilepath = Yii::getPathOfAlias('webroot') . $advertisementForm->ExternalPartyUrl;
                            $img = Yii::app()->simpleImage->load($logofilepath);
                            list($width, $height) = getimagesize($logofilepath);
                            if ($width > '250') {
                                $img->resizeToWidth(250);
                                $img->save($logofilepath);
                            }
                        }
                    }



                    if (isset($advertisementForm->id) && $advertisementForm->id!="") {
                        if (($advertisementForm->AdTypeId == 1 || $advertisementForm->AdTypeId == 2) && $advertisementForm->DoesthisAdrotateHidden == "ok") {

                            $advertisementForm->Status = 0;
                        }
                        $result = ServiceFactory::getSkiptaAdServiceInstance()->saveNewAdService($advertisementForm, $userId, "edit");

                        $obj = array('status' => 'success', 'data' => 'Advertisement updated scuccessfully', 'error' => '', 'page' => 'edit');
                    } else {
                        $advertisementForm->Status = 1;
                        
                        if (($advertisementForm->AdTypeId == 1 || $advertisementForm->AdTypeId == 2) && $advertisementForm->DoesthisAdrotateHidden == "ok") {


                            $advertisementForm->Status = 0;
                        }
                        if($advertisementForm->AdTypeId == 4){
                           $advertisementForm->Title=$advertisementForm->Title." has introduced a new Market Research Survey"; 
                        }
                        
                        $result = ServiceFactory::getSkiptaAdServiceInstance()->saveNewAdService($advertisementForm, $userId, "new");
                        if ($result == 'success') {
                            $obj = array('status' => 'success', 'data' => 'Advertisement Created Successfully', 'error' => '', 'page' => 'new');
                        } else {
                            $obj = array('status' => 'failure', 'data' => 'Some thing went wrong please try again later', 'error' => '');
                        }
                    }
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in Advertisements Controller actionnewAdvertisement==".$ex->getMessage());
            Yii::log("AdvertisementsController:actionnewAdvertisement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUploadAdvertisementImage() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder = Yii::getPathOfAlias('webroot') . '/upload/'; // folder for uploaded files
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "png", "tiff", "swf", "mov", "mp4","TIF","tif"); //array("jpg","jpeg","gif","exe","mov" and etc...
            // $sizeLimit = 30 * 1024 * 1024;// maximum file size in bytes
            $sizeLimit = Yii::app()->params['UploadMaxFilSize'];
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            
            $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
            $fileName = $result['filename']; //GETTING FILE NAME
            $extension = $result['extension'];

            $ext = "advertisements/";
            $destnationfolder = $folder . $ext;
            if (!file_exists($destnationfolder)) {
                mkdir($destnationfolder, 0755, true);
            }

            $info = pathinfo($result['filename']);
            $image_name = basename($result['filename'], '.' . $info['extension']);
            $finalImage = $image_name . '_' . $result['imagetime']. '.' . $info['extension'];
            $fileNameTosave = $folder . $image_name;
            
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
            Yii::log("AdvertisementsController:actionUploadAdvertisementImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionloadAds() {
        try {
            $position = $_REQUEST['position'];
            $page = $_REQUEST['page'];
            $groupId = '';
            $groupName = '';
              $segmentId=(int)(isset($this->tinyObject['SegmentId'])?$this->tinyObject['SegmentId']:0);
            if ($page == "group") {
                $urlArray = explode("/", $_SERVER['HTTP_REFERER']);
                $groupName = $urlArray[3];
                $groupName = trim(urldecode($groupName));
                $groupIdFromName = ServiceFactory::getSkiptaPostServiceInstance()->getGroupIdByName($groupName);
                if (isset($groupIdFromName)) {
                    $groupId = $groupIdFromName;
                }
            } else {
                $groupId = '';
            }

            $loadAds = ServiceFactory::getSkiptaAdServiceInstance()->loadAds($position, $page, $groupId,$segmentId, Yii::app()->session['language']);

            $htmlData = $this->renderPartial('loadAds', array("loadAds" => $loadAds, "position" => $position,"page"=>$page, "ad" => 0), true);
            $obj = array("htmlData" => $htmlData, "loadAds" => $loadAds, "position" => $position, "page" => $page);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            error_log("Exception Occurred in Advertisements Controller actionloadAds==". $ex->getMessage());
            Yii::log("AdvertisementsController:actionloadAds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetAllAdvertisementsForAdmin() {
        try {

            $recordCount = 0;
            $searchText = trim($_REQUEST['searchText']);
            $startLimit = $_REQUEST['startLimit'];
            $pageLength = $_REQUEST['pageLength'];
            $filterValue = $_REQUEST['filterValue'];
            if (!isset($startLimit) || empty($startLimit)) {
                $startLimit = 0;
            }
            if (!isset($pageLength) || empty($pageLength)) {
                $pageLength = 10;
            }
            if (!isset($searchText) || empty($searchText) || $searchText == "undefined") {
                $searchText = '';
            }
            if (!isset($filterValue) || empty($filterValue) || $searchText == "undefined") {
                $filterValue = "all";
            }
            $segmentId=(int)(isset($this->tinyObject['SegmentId'])?$this->tinyObject['SegmentId']:0);
            $advertisements = ServiceFactory::getSkiptaAdServiceInstance()->getAllAdvertisementsForAdmin($searchText, $startLimit, $pageLength, $filterValue, $segmentId);
            $adTypes = ServiceFactory::getSkiptaAdServiceInstance()->getAdTypes();
            $totalCount = ServiceFactory::getSkiptaAdServiceInstance()->getTotalCountForAdvertisements($searchText, $filterValue, $segmentId);
            $htmlData = $this->renderPartial('advertisementsWall', array("advertisements" => $advertisements, "adTypes" => $adTypes,'filterValue'=>$filterValue,'totlacount'=>$totalCount), "html");
            if (is_array($advertisements)) {
                $recordCount = count($advertisements);
            }
            $obj = array("htmlData" => $htmlData, "totalCount" => $totalCount, "searchText" => $searchText, "recordCount" => $recordCount);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actionGetAllAdvertisementsForAdmin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionEditAdvertisement() {
        try {
            $id = $_REQUEST['id'];
            $SourceType = 'Upload';
            $adTypes = array();
            $groupDetals = ServiceFactory::getSkiptaGroupServiceInstance()->loadOnlyGroupNames();
            $adTypesResult = ServiceFactory::getSkiptaAdServiceInstance()->getAdTypes();
            if (is_array($adTypesResult)) {
                $adTypes = $adTypesResult;
            }
            $adRequestedFields = array();
            $adRequestedFieldsResult = ServiceFactory::getSkiptaAdServiceInstance()->getAdRequestedFields();
            if (is_array($adRequestedFieldsResult)) {
                $adRequestedFields = $adRequestedFieldsResult;
            }
            $languages = ServiceFactory::getSkiptaUserServiceInstance()->getAllLanguages();
            $dynamicContent = array();
            $banners = array();
            $subSpecialitys = ServiceFactory::getSkiptaGroupServiceInstance()->getSubSpeciality();
            $userClassifications=ServiceFactory::getSkiptaAdServiceInstance()->getUserClassifications();
            $surveyGroupNamesList = ExSurveyResearchGroup::model()->getLinkGroups();
            $surveyGroupNames=array();
             if (is_array($surveyGroupNamesList)) {
                 foreach($surveyGroupNamesList as $groupname){
                   $surveyGroupNames[$groupname->GroupName]= $groupname->GroupName; 
                 }
                 
            }
           
            $surveyNames=array();
            $Schedules=array();
            if (isset($id) || !empty($id)) {
                $advertisementForm = new AdvertisementForm();
                $advertisements = ServiceFactory::getSkiptaAdServiceInstance()->getAdvertisementByType("id", $id);
                $advertisementForm->AdTypeId = $advertisements['AdTypeId'];
                $exdate = new DateTime($advertisements['ExpiryDate']);
                $sdate = new DateTime($advertisements['StartDate']);
                if($advertisements['IsMarketRearchAd']==1){
                   $advertisementForm->AdTypeId = 4; 
                   $advertisementForm->SurveyGroupName = $advertisements['SurveyGroupName']; 
                   $advertisementForm->SurveyName = $advertisements['SurveyName'];
                   $advertisementForm->IsMarketRearchAd = 1;  
                   $advertisementForm->ScheduleId=$advertisements['ScheduleId'];
                   $advertisementForm->SurveyIdHidden = $advertisements['SurveyName'];
                   $surveyNamesList = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyListByGroupName($advertisements['SurveyGroupName']);
                  
                   if (is_array($surveyNamesList)) {
                   foreach($surveyNamesList as $survy){
                       $surveyNames["$survy->_id"] = $survy->SurveyTitle; 
                    }
                   
                   }
                    $scheduleList = ScheduleSurveyCollection::model()->GetSurveySchedulesBySurveyId($advertisements['SurveyName']);
                    if(is_array($scheduleList)){
                        foreach($scheduleList as $schedule){
                             $enddate=$schedule->EndDate;
                             $startdate=$schedule->StartDate;
                             $Schedules["$schedule->_id"] = date("m/d/Y",$startdate->sec)." to ".date("m/d/Y",$enddate->sec);
                    }
                        
                    }
                   }
                $advertisementForm->Name = $advertisements['Name'];
                $advertisementForm->RedirectUrl = $advertisements['RedirectUrl'];
                $advertisementForm->DisplayPage = $advertisements['DisplayPage'];

                
                $advertisementForm->ExpiryDate = $exdate->format('m/d/Y');
                $advertisementForm->Type = $advertisements['Type'];
                $advertisementForm->Status = $advertisements['Status'];

                $advertisementForm->id = $advertisements['id'];
                $advertisementForm->OutsideUrl = $advertisements['OutsideUrl'];
                $advertisementForm->SourceType = $advertisements['SourceType'];

                if ($advertisements['SourceType'] != 'StreamBundleAds') {
                    $advertisementForm->Url = $advertisements['Url'];
                }
                if ($advertisements['DisplayPage'] == "Group") {
                    $advertisementForm->GroupId = explode(', ', $advertisements['GroupId']);
                }
                if ($advertisements['RequestedParams'] != "" && $advertisements['RequestedParams'] != null) {
                    $reqParms = explode(',', $advertisements['RequestedParams']);
                    foreach ($reqParms as $param) {
                        $paramList = explode(':', $param);
                        if ($paramList[0] == "UserId") {
                            $advertisementForm->Requestedparam1 = $paramList[1];
                            $advertisements['Requestedparam1'] = $paramList[1];
                        }
                        if (trim($paramList[0]) == "Display Name") {
                            $advertisementForm->Requestedparam2 = $paramList[1];
                            $advertisements['Requestedparam2'] = $paramList[1];
                        }
                    }
                }

                if ($advertisements['AdTypeId'] == "1") {
                    $advertisementForm->DisplayPosition = $advertisements['DisplayPosition'];
                    $advertisementForm->TimeInterval = $advertisements['TimeInterval'];
                    

                    $advertisementForm->IsThisAdRotate = $advertisements['IsAdRotate'];
                }
                if ($advertisements['SourceType'] == "StreamBundleAds") {
                        $advertisementForm->StreamBundleAds = $advertisements['StreamBundle'];
                    }
                if ($advertisements['SourceType'] == "AddServerAds") {
                    $advertisementForm->ImpressionTags = $advertisements['ImpressionTag'];
                    $advertisementForm->ClickTag = $advertisements['ClickTag'];
                }
                
                $advertisementForm->StartDate = $sdate->format('m/d/Y');
                if ($advertisements['AdTypeId'] != "1") {
                    $advertisementForm->Title = $advertisements['Title'];
                    $advertisementForm->BannerTemplate = $advertisements['BannerTemplate'];
                    $advertisementForm->BannerContent = $advertisements['BannerContent'];
                    $advertisementForm->BannerTitle = $advertisements['BannerTitle'];
                    $advertisementForm->BannerOptions = $advertisements['BannerOptions'];
                    $advertisementForm->SubSpeciality = $advertisements['SubSpeciality'];
                    $advertisementForm->Country = $advertisements['Country'];
                    $advertisementForm->State = $advertisements['State'];
                    $advertisementForm->Classification = $advertisements['Classification'];
                    $advertisementForm->IsUserSpecific=$advertisements['IsUserSpecific'];
                    if ($advertisements['BannerOptions'] == "OnlyText") {
                        $advertisementForm->BannerContentForTextOnly = $advertisements['BannerContent'];
                        $advertisementForm->BannerTitleForTextOnly = $advertisements['BannerTitle'];
                    }
                    $advertisementForm->IsThisExternalParty = $advertisements['IsThisExternalParty'];
                    $advertisementForm->IsThisExternalPartyhidden = $advertisements['IsThisExternalParty'];
                    $advertisementForm->ExternalPartyName = $advertisements['ExternalPartyName'];
                    $advertisementForm->ExternalPartyUrl = $advertisements['ExternalPartyUrl'];
                }
                if ($advertisements['AdTypeId'] == "3") {
                    $advertisementForm->RequestedFields = explode(', ', $advertisements['RequestedFields']);
                }
                $adSourceData = array();
                $conditions = array('AdId'=>$advertisements['id']);
                $adSourceData = ServiceFactory::getSkiptaAdServiceInstance()->getAdSourceTypeData($conditions);
                  

                   $uploadDivs = "" ;
                $selectedArray = array();

                $SourceType = $advertisements['SourceType'];
                if($advertisements['BannerOptions']!="ImageWithText"){
                    $uploadul = "";
                    $previewLi = "";
                    $url = "";
                    $fileInitializer = "";
                    
                    foreach ($adSourceData as $value) {

                        $filepath = $value["Url"];
                        if($value["Type"]=="swf"){
                            $filepath='/images/system/swf.png';
                        }else if($value["Type"]=="mp4" || $value["Type"]=="mov"){
                            $filepath='/images/system/video_img.png';
                        }
                        $previewLi .= '<li class="language_prv_li" id="language_upload_'.$value["Language"].'">'
                                            .'<div class="positionrelative language_img">'
                                                .'<span class="span_language" style="padding-left: 12px; color: rgb(153, 153, 153);">'.$value["Language"].'</span>'
                                                .'<div class=" positionabsolutediv" id="uploadIcons_'.$value["Language"].'" style="right:3px; top:3px" >'
                                                .'<div id="GroupLogo_'.$value["Language"].'" class="uploadicon"><img src="/images/system/spacer.png"></div>'
                                                .'</div>'
                                                . '<img src="'.$filepath.'" alt="" style="border:0;" />'
                                                .'<input type="hidden" class="Advertisement_Url" value="'.$value["Url"].'" data-lang="'.$value["Language"].'" data-ext="'.$value["Type"].'" id="Advertisement_Url_'.$value["Language"].'" \>'
                                            .'</div>'
                                        .'</li>';

                        $uploadul .= '<ul class="qq-upload-list" id="uploadlistSchedule_'.$value["Language"].'"></ul>';
                        $url.=",".$value["Language"].'@@'.$value["Type"].'@@' . $value["Url"];
                        $fileInitializer .= "initializeFileUploader('GroupLogo_".$value["Language"]."', '/advertisements/UploadAdvertisementImage', '10*1024*1024', extensions,1, '".$value["Language"]."' ,'',AdvertisementPreviewImage,displayErrorForBannerAndLogo,'uploadlistSchedule_".$value["Language"]."');";
                        $selectedArray[$value['Language']]=array('selected'=>true);
                    }
                       if($url!=""){
                        $advertisementForm->Url=substr($url,1);;
                    }
                    $dynamicContent['uploadul'] =  $uploadul;
                    $dynamicContent['previewLi'] =  $previewLi;
                    $dynamicContent['fileInitializer'] =  $fileInitializer;
                    $dynamicContent['selectedArray'] =  $selectedArray;
                }else{
                    foreach ($adSourceData as $value) {
                        $selectedArray[$value['Language']]=array('selected'=>true);
                    }
                    $dynamicContent['selectedArray'] =  $selectedArray;
                    $banners = $adSourceData;
                }
                if ($advertisements['AdTypeId'] == 2) {
                    $advertisementForm->IsPremiumAd = $advertisements['IsPremiumAd'];
                    $advertisementForm->PremiumTypeId = $advertisements['PremiumTypeId'];
                    $advertisementForm->PTimeInterval = $advertisements['PTimeInterval'];
                }
                $htmlData = $this->renderPartial('editAdvertisement', array("advertisements" => $advertisements, 'advertisementForm' => $advertisementForm, 'groupNames' => $groupDetals, 'sourceType' => $SourceType, 'adTypes' => $adTypes, 'adRequestedFields' => $adRequestedFields,"languages"=>$languages,'dynamicContent'=>$dynamicContent,'banners'=>$banners,'subSpecialitys'=>$subSpecialitys,'UserClassifications'=>$userClassifications,"SurveyGroupNames"=>$surveyGroupNames,"SurveyNames"=>$surveyNames,'Schedules'=>$Schedules), "html");
                $obj = array("htmlData" => $htmlData);
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }else{
                $advertisements = array();
                $advertisementForm = new AdvertisementForm();
                $htmlData = $this->renderPartial('editAdvertisement', array("advertisements" => $advertisements, 'advertisementForm' => $advertisementForm, 'groupNames' => $groupDetals, 'sourceType' => $SourceType, 'adTypes' => $adTypes, 'adRequestedFields' => $adRequestedFields,"languages"=>$languages,'dynamicContent'=>$dynamicContent,'banners'=>$banners,'subSpecialitys'=>$subSpecialitys,'UserClassifications'=>$userClassifications,"SurveyGroupNames"=>$surveyGroupNames,"SurveyNames"=>$surveyNames,'Schedules'=>$Schedules), "html");
                $obj = array("htmlData" => $htmlData);
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actionEditAdvertisement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionshowPreview() {
        try {
            $id = $id = $_REQUEST['id'];
            $url = $_REQUEST['url'];
            $type = $_REQUEST['type'];
            $position = $_REQUEST['position'];
            $displayPage = $_REQUEST['displayPage'];
            if ($displayPage == "Group") {
                $src = "/images/system/adsgroupspreview.jpg";
            } else if ($displayPage == "Home") {
                $src = "/images/system/adsstreampeview.jpg";
            } else if ($displayPage == "Curbside") {
                $src = "/images/system/addscurbsidepreview.jpg";
            }
            $htmlData = $this->renderPartial('adPreview', array("url" => $url, 'type' => $type, 'src' => $src, 'position' => $position, 'displayPage' => $displayPage), "html");
            $obj = array("htmlData" => $htmlData, 'type' => $type, 'position' => $position, 'url' => $url,'translate_AdvertisementPreview'=>Yii::t('translation','Advertisement_Preview'));
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actionshowPreview::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionTrackAdvertisement() {
        try {
            $adId = $id = $_REQUEST['adId'];
            $userId = $this->tinyObject['UserId'];
            if (isset($adId)) {
                ServiceFactory::getSkiptaAdServiceInstance()->trackAdClick($adId, $userId);
            }
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actionTrackAdvertisement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actiontreackAdUser() {
        try {
            $postId = $_REQUEST['PostId'];
            $userId = $this->tinyObject['UserId'];
            if (isset($postId)) {
                ServiceFactory::getSkiptaAdServiceInstance()->saveUserAdTrack($userId, $postId);
            }
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actiontreackAdUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetAddView() {
//incontroller
        try {
            $adId = $_REQUEST['id'];
            $adCollectioObject = ServiceFactory::getSkiptaAdServiceInstance()->getStreamForAdvertisementPreivewByAdvertisementId($adId);

            $htmlData = $this->renderPartial('advertisement_preview', array("data" => $adCollectioObject), true);

            $obj = array("htmlData" => $htmlData);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            error_log("Exception Occurred in Advertisements Controller actionGetAddView==".$ex->getMessage());
            Yii::log("AdvertisementsController:actionGetAddView::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionRenderScriptAd() {
        try {
            if(!is_numeric($_GET['id'])){
               $criteria = new EMongoCriteria;
               $criteria->addCond('_id', '==', new MongoId($_GET['id']));
               $streamObj = UserStreamCollection::model()->find($criteria); 
            }
            else{
               
               $streamObj = ServiceFactory::getSkiptaAdServiceInstance()->getAdvertisementsById($_GET['id']); 
            }
            
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actionRenderScriptAd::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        $this->renderPartial('renderscriptad', array("stream" => $streamObj));
    }
    public function actionLoadBannerTemplate() {
        $returnValue = 'failure';
        try {
            if (isset($_REQUEST['language'])) {

                $language = $_REQUEST['language'];
                
                $id = $_REQUEST['bannerId'];
                $advertisements = array();
                $advertisement['Id'] = $id;
                $advertisement['BannerTemplate'] = "";
                $advertisement["BannerOptions"] = "ImageWithText";
                $advertisement["Url"] = "";
                $advertisement["Language"] = $language;
                $advertisement["BannerTitle"] = "Banner Title";
                $advertisement["BannerContent"] = "Banner Description";
                array_push($advertisements, $advertisement);
                $advertisementForm = new AdvertisementForm();
                $this->renderPartial('bannerPreview', array('banners' => $advertisements,'advertisementForm'=>$advertisementForm));
            }
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actionLoadBannerTemplate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
    public function actionGetSurveysByGroupName() {
        try {
            $data = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyListByGroupName($_POST['groupname']);
            
            $specialityArray = array();
            if (count($data) > 0) {
                array_push($specialityArray, CHtml::tag('option', array('value' => ''), CHtml::encode('Please select survey'), true));
                foreach ($data as $survy) {
                    array_push($specialityArray, CHtml::tag('option', array('value' => $survy->_id), CHtml::encode($survy->SurveyTitle), true));
                }
            }else{
               $specialityArray='No surveys exixts with this Bundle'; 
            }
            echo $this->rendering(array('data' => $specialityArray));
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actionGetSurveysByGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function actionGetSchedules() {
        try {
            $data = ScheduleSurveyCollection::model()->GetSurveySchedulesBySurveyId($_POST['surveyId']);
            $data1 = ServiceFactory::getSkiptaExSurveyServiceInstance()->getSurveyDetailsById("Id",$_POST['surveyId'] );
            $specialityArray = array();
            if (count($data) > 0) {
                array_push($specialityArray, CHtml::tag('option', array('value' => ''), CHtml::encode('Please select schedule'), true));
                foreach ($data as $schedule) {
                    $enddate=$schedule->EndDate;
                    $startdate=$schedule->StartDate;
                    array_push($specialityArray, CHtml::tag('option', array('value' => $schedule->_id), CHtml::encode(date("m/d/Y",$startdate->sec)." to ".date("m/d/Y",$enddate->sec)), true));
                }
            }else{
               $specialityArray='No current or future schedules exist.'; 
            }
            echo $this->rendering(array('data' => $specialityArray,'IsBranded'=>$data1->IsBranded,'BrandName'=>$data1->BrandName,'BrandLogo'=>$data1->BrandLogo,'SurveyTitle'=>$data1->SurveyTitle));
        } catch (Exception $ex) {
            Yii::log("AdvertisementsController:actionGetSchedules::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}
