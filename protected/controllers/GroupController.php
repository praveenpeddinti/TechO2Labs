<?php

/**
 * Developer Name: Suresh Reddy
 * Post Controller  class,  all post module realted actions here 
 * 
 */
class GroupController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function init() {
        try{
        parent::init();
        if (isset(Yii::app()->session['TinyUserCollectionObj'])) {
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            $this->userPrivileges = Yii::app()->session['UserPrivileges'];
            $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
            $this->whichmenuactive = 3;
        } else {
            $this->redirect('/');
        }
        CommonUtility::registerClientScript('groupPost.js');
        $this->sidelayout = 'no';
        } catch (Exception $ex) {
            Yii::log("GroupController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * suresh reddy  for gloabl erro page
     */
    public function actionError() {
        try{
        $cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->baseUrl;
        $cs->registerCssFile($baseUrl . '/css/error.css');
        if ($error = Yii::app()->errorHandler->error)
            $this->render('error', $error);
        } catch (Exception $ex) {
            Yii::log("GroupController:actionError::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex() {

        try {
            // $this->actiongetGroupDetailsForAnalytics();

            $newGroupModel = new GroupCreationForm();
            $UserId = $this->tinyObject['UserId'];
            $userGroupsFollowing = ServiceFactory::getSkiptaUserServiceInstance()->groupsUserFollowing($UserId);
            $userFollowingGroupsCount = ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingGroups($UserId);
            $subSpe=ServiceFactory::getSkiptaGroupServiceInstance()->getSubSpeciality();            
            $this->render('index', array('newGroupModel' => $newGroupModel, 'userGroupsFollowing' => CJSON::encode($userGroupsFollowing), 'userGroupsFollowingCount' => CJSON::encode(count($userFollowingGroupsCount)), 'canCreateGroup' => $this->userPrivilegeObject->canCreateGroup,'subSpe'=>$subSpe));
        } catch (Exception $ex) {
            Yii::log("GroupController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * Author @vamsikrishna
     * This method is to render the group detail page 
     */
    public function actionGroupDetail() {
        try {
               $rp='';
                  if(isset($_REQUEST['G'])){
                    $rp='?G='.$_REQUEST['G'];                  
                  }               
            
            $urlArray = explode("/", Yii::app()->request->url);
            $newGroupModel = new SubGroupCreationForm();
            
            if(isset($urlArray[1]))
            {
                if(isset($_REQUEST['G'])){
                    $groupUrl=explode("?", $urlArray[1]);
                    $groupName=$groupUrl[0];
                }else{
                  $groupName = $urlArray[1];        
                }
            
            $groupId = '';
            $groupName = trim(urldecode($groupName));
            $groupId = ServiceFactory::getSkiptaPostServiceInstance()->getGroupIdByName($groupName);
 
            
            if ($groupId != 'failure') {
                
                $groupObject = ServiceFactory::getSkiptaPostServiceInstance()->getGroupObjectByName($groupName);
                $IsIFrameMode = isset($groupObject->IsIFrameMode) ? $groupObject->IsIFrameMode : 0;

                if(($IsIFrameMode==1 || $groupObject->CustomGroup == 1 ) &&  !isset($urlArray[2]))
                {
                    $servername= Yii::app()->params['ServerURL'];

                    if($groupObject->IFrameURL!='' || $groupObject->IFrameURL!=null)
                    {
                        $httpsGroup = stristr($groupObject->IFrameURL,'https');
                    if(!$httpsGroup)
                        $servername= str_replace("https", "http", $servername);
                  }
                 else
                    {
                        $servername= str_replace("https", "http", $servername);
                    }

                    $this->redirect($servername."/".$groupName."/cgz".$rp);  

                }
                 $protocolScheme = Yii::app()->getRequest()->getIsSecureConnection();
                if(isset($urlArray[2]) && $protocolScheme){
                  $servername= Yii::app()->params['ServerURL'];
                  $servername= str_replace("https", "http", $servername);  
                   $this->redirect($servername."/".$groupName."/cgz".$rp);  
                }
               if($IsIFrameMode!=1 && $groupObject->CustomGroup != 1 )
                {
                  $protocolScheme = Yii::app()->getRequest()->getIsSecureConnection();
                  if(!($protocolScheme))
                  {
                    $servername= Yii::app()->params['ServerURL'];

                    $this->redirect($servername."/".$groupName);
                  }

                }

                $groupPostModel = new GroupPostForm();
                $groupId = $groupObject->_id;
                $groupPostModel->GroupId = $groupId;
                $userId = $this->tinyObject['UserId'];
                $groupStatistics = ServiceFactory::getSkiptaPostServiceInstance()->getGroupStatistics($groupId, $userId);

                $newGroupCreationModel = new GroupCreationForm();
                $groupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupDetailsById($groupId);
              $advertisementsCount= ServiceFactory::getSkiptaAdServiceInstance()->getAdsCountForGroup($groupId);
              $subSpe=ServiceFactory::getSkiptaGroupServiceInstance()->getSubSpeciality();       
              $adCount=0;             
              $farray = array();
              if($advertisementsCount['AdCount']>0){
               $adCount=$advertisementsCount['AdCount'];
              }              
                if ($groupDetails != 'failure') {
                    $newGroupCreationModel->GroupName = $groupDetails->GroupName;
                    $newGroupCreationModel->Description = $groupDetails->GroupDescription;
                    $newGroupCreationModel->IFrameMode = $groupDetails->IsIFrameMode;
                    $newGroupCreationModel->IFrameURL = $groupDetails->IFrameURL;
                    $newGroupCreationModel->AutoFollow = $groupDetails->AutoFollow;
                    $newGroupCreationModel->IsPrivate = $groupDetails->IsPrivate;
                    $newGroupCreationModel->id=$groupId;
                    $newGroupCreationModel->AddSocialActions = $groupDetails->AddSocialActions;
                    $newGroupCreationModel->DisableWebPreview = $groupDetails->DisableWebPreview;
                    $newGroupCreationModel->DisableStreamConversation = $groupDetails->DisableStreamConversation;
                    $newGroupCreationModel->RestrictedAccess = $groupDetails->RestrictedAccess;
                    if($groupDetails->Status==1){
                     $newGroupCreationModel->Status=0;    
                    }else{
                     $newGroupCreationModel->Status=1;       
                    }
                    $groupMembers = $groupDetails->GroupMembers;
                    $newGroupCreationModel->SubSpeciality=$groupDetails->Speciality;
                    $emailsarray = array("0"=>Yii::app()->session['Email']);
                    $userAllowable = 0;
                    $IsnotAgroupMember = 0;
                    if($newGroupCreationModel->RestrictedAccess == 1){
                        $userAllowable = CommonUtility::getGroupAccessibleUserStatusByGroupId($groupId,Yii::app()->session['Email']);
                        $farray = ServiceFactory::getSkiptaGroupServiceInstance()->getFilesList($userId, $groupId);
                        //$userAllowable = in_array(Yii::app()->session['Email'],$emailsarray);
                        $IsnotAgroupMember = in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->GroupMembers)? 0:1;
                        
                    }  
                    
                    if (in_array($userId, $groupMembers)) {  
                        ServiceFactory::getSkiptaUserServiceInstance()->updateUserProfileForGroupActivity($userId, $groupId);
                    }
                }
                if (($IsIFrameMode == 0 && $groupObject->CustomGroup == 0) || ($groupObject->IsHybrid == 1)) {
                    $showPostOption = ($this->userPrivilegeObject->canSurvey == 1 || $this->userPrivilegeObject->canEvent == 1) ? 1 : 0;
                    $this->render('groupDetail', array("IsIFrameMode" => $IsIFrameMode, "preferencesModel" => $newGroupCreationModel, "groupStatistics" => $groupStatistics, 'groupPostModel' => $groupPostModel, 'showPostOption' => $showPostOption, 'newGroupModel' => $newGroupModel,"hybrid"=>$groupObject->IsHybrid,"customGroup"=>$groupObject->CustomGroup,"customGroupName"=>$groupObject->CustomGroupName,'advertisementsCount'=>$adCount,"conversationVisibilitySettings"=>$groupObject->ConversationVisibility,"filesArray"=>$farray,"userAllowable"=>$userAllowable,'subSpe'=>$subSpe,"IsnotAgroupMember"=>$IsnotAgroupMember));
                } else if($IsIFrameMode == 1 && $groupObject->CustomGroup == 0){
                    $this->render('customGroupDetail', array("IsIFrameMode" => $IsIFrameMode, "preferencesModel" => $newGroupCreationModel, "groupStatistics" => $groupStatistics, 'groupPostModel' => $groupPostModel, 'newGroupModel' => $newGroupModel, "iframeURL" => $groupObject->IFrameURL, "groupId" => $groupId,"customGroup"=>$groupObject->CustomGroup,"conversationVisibilitySettings"=>$groupObject->ConversationVisibility,'subSpe'=>$subSpe,"filesArray"=>$farray));
                } else if($groupObject->CustomGroup == 1){
//                    $this->render('customGroupDetail', array("IsIFrameMode" => $IsIFrameMode, "preferencesModel" => $newGroupCreationModel, "groupStatistics" => $groupStatistics, 'groupPostModel' => $groupPostModel, 'newGroupModel' => $newGroupModel, "iframeURL" => $groupObject->IFrameURL, "groupId" => $groupId));
                    Yii::app()->session['GroupId'] = $groupStatistics->GroupId;
                    $showPostOption = ($this->userPrivilegeObject->canSurvey == 1 || $this->userPrivilegeObject->canEvent == 1) ? 1 : 0;
                    $this->render('outsideCustomGroupDetail', array("IsIFrameMode" => $IsIFrameMode, "preferencesModel" => $newGroupCreationModel, "groupStatistics" => $groupStatistics, 'groupPostModel' => $groupPostModel, 'showPostOption' => $showPostOption, 'newGroupModel' => $newGroupModel,"URL" => $groupObject->IFrameURL, "groupId" => $groupId,"customGroup"=>$groupObject->CustomGroup,"customGroupName"=>$groupObject->CustomGroupName,"conversationVisibilitySettings"=>$groupObject->ConversationVisibility,"hybrid"=>$groupObject->IsHybrid,"filesArray"=>$farray));              
                }
            }
            }
            else{
               $this->redirect(Yii::app()->params['ServerURL']);
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in Group Controller actionGroupDetail==".$ex->getMessage());
            Yii::log("GroupController:actionGroupDetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @Author:Praneeth
     * @method public method Name(type $groupname, $shortdescription, $description) 
     * Description: To create a new group
     */
    public function actionCreateNewGroup() {
        try {
            $UserId = $this->tinyObject['UserId'];
            $obj = array();
            $this->layout = 'groupLayout';
            $newGroupModel = new GroupCreationForm();
            if (isset($_POST['GroupCreationForm'])) {
                $newGroupModel->attributes = $_POST['GroupCreationForm'];
                $errors = CActiveForm::validate($newGroupModel);
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $newGroupModel->UserId = $this->tinyObject['UserId'];
                    $newGroupModel->SegmentId = (int)(isset($this->tinyObject['SegmentId']) ? $this->tinyObject['SegmentId'] : 0);
                    $newGroupModel->NetworkId = (int)(isset($this->tinyObject['NetworkId']) ? $this->tinyObject['NetworkId'] : 1);
                    $UserId = $newGroupModel->UserId;
                    $networkId = $this->tinyObject['NetworkId'];
                    $networkAdminUserId = Yii::app()->session['NetworkAdminUserId'];                    
                    $groupId = ServiceFactory::getSkiptaPostServiceInstance()->createNewGroup($newGroupModel, $UserId, $networkId,$networkAdminUserId);
                    if ($groupId != 'failure' && $groupId != 'groupexists') {
                        //$message = Yii::t('translation', 'GroupCreation_Saving_Success');
                        $message = Yii::t('translation', 'Group_created_successfully');
                        $obj = array('status' => 'success', 'data' => $message);
                    } elseif ($groupId == 'groupexists') {
                        $message = Yii::t('translation', 'Group_already_exists');
                        $errorMessage = array('GroupCreationForm' => $message);
                        $obj = array("status" => 'error', 'data' => $message, "error" => $errorMessage);
                    } else {
                        //$message = Yii::t('translation', 'GroupCreation_Saving_Fail');
                        $message = $message = Yii::t('translation', 'Group_creation_failed');;
                        $errorMessage = array('GroupCreationForm' => $message);
                        $obj = array("status" => 'error', 'data' => $message, "error" => $errorMessage);
                    }
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            } else {

                $this->render('index', array('newGroupModel' => $newGroupModel));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionCreateNewGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @Author:Praneeth
     * Description: Method to get more groups the user is following
     * @returntype: groups array
     */
    public function actiongetMoreFollowingGroups() {
        try {
            $startLimit = $_REQUEST['startLimit'];
            $pageLength = $_REQUEST['pageLength'];
            $UserId = $this->tinyObject['UserId'];
            $userGroupsFollowing = ServiceFactory::getSkiptaUserServiceInstance()->getMoreFollowingGroups($UserId, $startLimit, $pageLength);
            $obj = array('status' => 'success', 'data' => $userGroupsFollowing);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("GroupController:actiongetMoreFollowingGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');        }
    }

    /**
     * @Author:Praneeth
     * Description: Method to get more groups the user is not following
     * @returntype: groups array
     */
    public function actionGetJoinMoreGroups() {
        try {
            if (isset($_GET['GroupCollection_page'])) {

                $userId = $this->tinyObject['UserId'];
                $pageSize = 4;
                $segmentId = (int)(isset($this->tinyObject['SegmentId']) ? $this->tinyObject['SegmentId'] : 0);
                $userGroupsFollowing = ServiceFactory::getSkiptaUserServiceInstance()->groupsUserNotFollowing($userId);
                $segmentIdArray = array(0);
                if($segmentId!=0){
                    $segmentIdArray = array($segmentId,0);
                }
                $provider = new EMongoDocumentDataProvider('GroupCollection', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => array(
                            '_id' => array('notin' => $userGroupsFollowing),
                            'IsPrivate' => array('!=' => 1),
                            'SegmentId' => array('in' => $segmentIdArray),
                             'Status' => array('==' => 1),
                        ),
                        //'conditions'=>array('UserId'=>array('in' => array($this->tinyObject['UserId'],0))),
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));
                if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else if ($_GET['GroupCollection_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $stream = (Object) $provider->getData();
                } else {

                    $stream = -1; //No more posts
                }
                $emailsarray = ServiceFactory::getSkiptaGroupServiceInstance()->getAllGroupAccessibleUsers();                
                $this->renderPartial('groups_view', array('stream' => $stream,"emailslist"=>$emailsarray,"lEmail"=>Yii::app()->session['Email']));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionGetJoinMoreGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*     * Author Vamsi Krishna
     * THis method is used to edit group details 
     */

    public function actioneditGroupDetails() {
        try {

            $returnValue = 'failure';
            $userId = $this->tinyObject['UserId'];
            $type = '';
            $value = '';
            $groupId = '';
            $category = $_REQUEST['category'];
            if ($_REQUEST['type'] == 'GroupDescription') {
                $value = $_REQUEST['groupDescription'];
                $groupId = $_REQUEST['groupId'];
                $type = 'GroupDescription';
            }
            if ($_REQUEST['type'] == 'GroupProfileImage') {
                $value = $_REQUEST['bannerImage'];
                $groupId = $_REQUEST['groupId'];
                $type = $_REQUEST['type'];
            }
            if ($_REQUEST['type'] == 'GroupBannerImage') {
                $value = $_REQUEST['bannerImage'];
                $groupId = $_REQUEST['groupId'];
                $type = $_REQUEST['type'];
            }
            if ($_REQUEST['type'] == 'IsIFrameMode') {
                $value = (int) $_REQUEST['IFrameMode'];
                $groupId = $_REQUEST['groupId'];
                $type = $_REQUEST['type'];
            }
            if ($_REQUEST['type'] == 'IFrameURL') {
                $value = $_REQUEST['IFrameURL'];
                $groupId = $_REQUEST['groupId'];
                $type = $_REQUEST['type'];
            }
            $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, $value, $type, $groupId, $category);

            $obj = array('status' => $returnValue, 'type' => $type);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("GroupController:actioneditGroupDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @Author:Praneeth
     * Description: Method to follow groups 
     * @returntype: json object
     */
    public function actionUserFollowGroup() {
        try {
            $result = "failure";
            $isFollowingGroup = '';
            if (isset($_REQUEST['groupId']) && isset($_REQUEST['actionType'])) {
                $userId = $this->tinyObject->UserId;
                $userClassification = $this->tinyObject->UserClassification;
                $lEmail = Yii::app()->session['Email'];
               $groupDetails = GroupCollection::model()->getGroupDetailsById($_REQUEST['groupId']);
              $emailsarray=array();
               if(isset($groupDetails->RestrictedAccess) && $groupDetails->RestrictedAccess==1 ){
               $emailsarray = ServiceFactory::getSkiptaGroupServiceInstance()->getAllGroupAccessibleUsers();
               }               
         //      if(in_array($lEmail,$emailsarray)){
                if ($_REQUEST['actionType'] == 'Follow') {
                    $groupFollowers = $groupDetails->GroupMembers;
                    $isFollowingGroup = in_array($userId, $groupFollowers);
                    $isGroupAdmin = in_array($userId, $groupDetails->GroupAdminUsers);
                    if ($isFollowingGroup == 1) {
                        $result = 'success';
                    } else {
                        $result = ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToGroup($_REQUEST['groupId'], $userId, $_REQUEST['actionType'],$lEmail, $userClassification);
                    }
                } else {
                    $result = ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToGroup($_REQUEST['groupId'], $userId, $_REQUEST['actionType'],$lEmail, $userClassification);
                }
//                } else{
//                    $result = 'notexist';
//                }




                if ($result == "failure") {
                    throw new Exception('Unable to follow or unfollow');
                } else if($result == "notexist"){
                    throw new Exception('This group area is private');
                }

                $userFollowingGroups = ServiceFactory::getSkiptaUserServiceInstance()->groupsUserFollowing($userId);
                Yii::app()->session['UserFollowingGroups'] = $userFollowingGroups;
            }

            $obj = array("status" => $result, "data" => "", "error" => "", "actionType" => $_REQUEST['actionType'], "userId" => $userId, "IsGroupAdmin" => $isGroupAdmin,'translate_follow'=>Yii::t('translation','Follow'),'translate_unFollow'=>Yii::t('translation','UnFollow'));
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            Yii::log("GroupController:actionUserFollowGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $id = "socialactionsError_" . $_REQUEST['groupId'];
            $actionType = $_REQUEST['actionType'];
            if ($actionType == "Follow") {
                $translation = "Follow_Action_Fail";
            } else if($actionType == "UnFollow" && $result != "notexist"){
                $translation = "UnFollow_Action_Fail";
            } else{
                $translation = "Restrict_Group";
            }

            $this->throwErrorMessage($id, $translation);
        }
    }

    public function actionUpload() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            // $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'];
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "exe", "mov", "mp4", "mp3", "txt", "doc", "docx", "pptx", "xlsx", "pdf", "ppt", "xls", "3gp", "php", "ini", "avi", "rar", "zip", "png", "tiff","TIF","tif"); //array("jpg","jpeg","gif","exe","mov" and etc...
            // $sizeLimit = 30 * 1024 * 1024;// maximum file size in bytes
            $sizeLimit = Yii::app()->params['UploadMaxFilSize'];

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
             $result["fileremovedpath"] = $folder . $fileName;
            } else {
                $result['success'] = false;
            }
            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
        } catch (Exception $ex) {
            Yii::log("GroupController:actionUpload::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRemoveGroupArtifacts() {

        try {
            if (isset($_POST['filepath'])) {
                $filepath = $_POST['filepath'];
            } else {
                $filepath = "";
            }

            $f = "'" . $filepath . "'";
            if (file_exists($filepath)) {

                if (unlink($filepath)) {
                    $obj = array('status' => 'success', 'data' => '', 'error' => '', 'filename' => $_POST['file'], 'image' => $_POST['image']);
                } else {
                    $obj = array('status' => 'failed', 'data' => '', 'error' => '', 'filename' => $_POST['file'], 'image' => $_POST['image']);
                }
            } else {
                
            }
            $renderScript = $this->rendering($obj);
            echo $renderScript;
            Yii::app()->end();
        } catch (Exception $ex) {
            Yii::log("GroupController:actionRemoveGroupArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @Author Haribabu
     * This  method is used for  save the new post with artifacts in array format and save the artifacts in resouces object.
     */
    public function actionCreateGroupPost() {
        $groupPostModel = new GroupPostForm();
        $errormessage = "";
        try {

            $obj = array();
            $hashTagArray = array();
            $atMentionArray = array();
            $SurveyQuestionOptions = array();
            if (isset($_POST['GroupPostForm'])) {

                $groupPostModel->attributes = $_POST['GroupPostForm'];
                $errors = CActiveForm::validate($groupPostModel);                
                $Message = array();                
                if($groupPostModel->Miscellaneous == 1 && $groupPostModel->KOLUser == ""){
                        $errormessage = Yii::t("translation", "Err_KOLUser");
                        $Message = array('GroupPostForm_KOLUser' => $errormessage);                        
                    }
                    if($groupPostModel->Miscellaneous == 1 && !empty($groupPostModel->KOLUser) && $groupPostModel->UserId == ""){
                        $errormessage = $groupPostModel->KOLUser. " ".Yii::t("translation", "unknownUser");
                        $Message = array('GroupPostForm_KOLUser' => $errormessage);                        
                    }
                if ($errors != '[]' || sizeof($Message)>0) {
                    
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors,'msgerr'=>$Message);
                } else {
                    if($groupPostModel->Miscellaneous == 1 && $groupPostModel->KOLUser == ""){
                        $errormessage = Yii::t("translation", "Err_KOLUser");
                        $Message = array('GroupPostForm_KOLUser' => $errormessage);
                        $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                    }
                    if ($groupPostModel->Type == "") {
                        $groupPostModel->Type = "Normal";
                    } else {
                        $groupPostModel->Type = $groupPostModel->Type;
                    }
                    if ($groupPostModel->Type == "Event") {
                        if ($groupPostModel->StartDate == "" || $groupPostModel->EndDate == "") {
                            $errormessage = Yii::t('translation', 'EventPost_Error_Message');
                        } else {
                            $groupPostModel->StartDate = $groupPostModel->StartDate;
                            $groupPostModel->EndDate = $groupPostModel->EndDate;
                            $groupPostModel->StartTime = $groupPostModel->StartTime;
                            $groupPostModel->EndTime = $groupPostModel->EndTime;
                            $groupPostModel->Location = $groupPostModel->Location;

                            $eventstarttime = explode(" ", $groupPostModel->StartTime);
                            $eventendtime = explode(" ", $groupPostModel->EndTime);
                            if (trim($groupPostModel->StartTime) != "") {
                                $starttime = trim(strtotime($groupPostModel->StartTime));
                            } else {
                                $starttime = "";
                            }
                            if (trim($groupPostModel->EndTime) != "") {
                                $endtime = trim(strtotime($groupPostModel->EndTime));
                            } else {
                                $endtime = "";
                            }
                            $startdate = trim(strtotime($groupPostModel->StartDate));
                            $enddate = trim(strtotime($groupPostModel->EndDate));

                            $startDateTime = $groupPostModel->StartDate . " " . $groupPostModel->StartTime;
                            $endDateTime = $groupPostModel->EndDate . " " . $groupPostModel->EndTime;
                            $startEndTime = $groupPostModel->StartDate . " " . $groupPostModel->EndTime;
                            $startDateTime = CommonUtility::convert_time_zone(strtotime($startDateTime), date_default_timezone_get(), Yii::app()->session['timezone']);
                            $endDateTime = CommonUtility::convert_time_zone(strtotime($endDateTime), date_default_timezone_get(), Yii::app()->session['timezone']);
                            $startEndTime = CommonUtility::convert_time_zone(strtotime($startEndTime), date_default_timezone_get(), Yii::app()->session['timezone']);


                            $currentTime = CommonUtility::currentSpecifictime_timezone(date_default_timezone_get());
                            
                            //$currentTime=time();
                            if ($starttime == "" && $endtime != "") {
                                $errormessage = Yii::t('translation', 'EventPost_Starttime_Error_Message');
                            } else if ($starttime != "" && $endtime == "") {
                                $errormessage = Yii::t('translation', 'EventPost_Endtime_Error_Message');
                            } else if ($starttime != "" && $endtime != "" && strtotime($startDateTime) >= strtotime($startEndTime)) {
                                $errormessage = Yii::t('translation', 'EventPost_time_Error_Message');
                            } else if ($starttime != "" && $endtime != "" && strtotime($startDateTime) < $currentTime) {
                                $errormessage = Yii::t('translation', 'EventPost_Start_time_Error_Message');
                            }
                        }
                    }
                    if ($groupPostModel->Type == "Survey") {

                        $groupPostModel->OptionOne = $groupPostModel->OptionOne;
                        $groupPostModel->OptionTwo = $groupPostModel->OptionTwo;
                        $groupPostModel->OptionThree = $groupPostModel->OptionThree;
                        $groupPostModel->OptionFour = $groupPostModel->OptionFour;
                        $groupPostModel->ExpiryDate = $groupPostModel->ExpiryDate;
                        $groupPostModel->Status = 1;

                        $Optionsarray = array(trim($groupPostModel->OptionOne), trim($groupPostModel->OptionTwo), trim($groupPostModel->OptionThree), trim($groupPostModel->OptionFour));

                        $counts = array_count_values($Optionsarray);
                        foreach ($counts as $name => $count) {
                            if ($count > 1) {
                                $errormessage = Yii::t('translation', 'SurveyPost_Options_Error_Message');
                            }
                        }
                    }
                    $groupPostModel->Type = $groupPostModel->Type;
                    $groupPostModel->PostedBy = $this->tinyObject['UserId'];
                    
                    if($groupPostModel->Miscellaneous == 0){
                        $groupPostModel->UserId = $this->tinyObject['UserId'];
                        $groupPostModel->PostedBy = $this->tinyObject['UserId'];                        
                    }else{
                        $groupPostModel->PostedBy = $groupPostModel->UserId; 
                    }
                   
                    $hashTagArray = CommonUtility::prepareHashTagsArray($groupPostModel->HashTags);
                    $atMentionArray = CommonUtility::prepareAtMentionsArray($groupPostModel->Mentions);
                    $groupPostModel->Mentions = $atMentionArray;
                    $groupPostModel->Location = $groupPostModel->Location;
                    $artifacts = $groupPostModel->Artifacts;
                    $Artifactslengh = strlen($groupPostModel->Artifacts);
                    if ($Artifactslengh > 0) {

                        $groupPostModel->Artifacts = explode(",", $groupPostModel->Artifacts);
                    } else {
                        $groupPostModel->Artifacts = array();
                    }
                    $groupPostModel->NetworkId = $this->tinyObject['NetworkId'];

                    $groupPostModel->GroupId = $groupPostModel->GroupId;
                    $groupPostModel->Status = '1';
                    $groupPostModel->IsPublic = '1';
                    if ($errormessage != "") {
                        $Message = array('GroupPostForm_StartTime' => $errormessage);
                        if ($groupPostModel->Type == "Event") {
                            $Message = array('GroupPostForm_StartTime' => $errormessage);
                        }
                        if ($groupPostModel->Type == "Survey") {
                            $Message = array('GroupPostForm_Survey_Options' => $errormessage);
                        }
                        $obj = array("status" => 'error', 'data' => '', "error" => $Message);
                    } else {
                        //error_log("====groupPostModel obj ===".print_r($groupPostModel,1));
                        $postObj = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupPost($groupPostModel, $hashTagArray);

                        if ($postObj != 'failure') {
                            $message = Yii::t('translation', 'NormalPost_Saving_Success');
                            if ((int)$groupPostModel->Type == 2) {
                                $message = Yii::t('translation', 'EventPost_Saving_Success');
                            }else if ((int)$groupPostModel->Type == 3) {
                                $message = Yii::t('translation', 'SurveyPost_Saving_Success');
                            }
                            $obj = array('status' => 'success', 'data' => $message, 'success' => '', 'groupId' => $groupPostModel->GroupId, 'subgroupId' => $groupPostModel->SubGroupId);
                        } else {
                            $message = Yii::t('translation', 'NormalPost_Saving_Fail');
                            $errorMessage = array('GroupPostForm_Description' => $message);
                            $obj = array("status" => 'error', 'data' => $message, "error" => $errorMessage);
                        }
                    }
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            } else {
                $this->render('index', array('groupPostModel' => $groupPostModel));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionCreateGroupPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * This  method is used for  get the web snippet preview.
     */
    public function actionSnippetpriviewPage() {
        try {
            $text = $_POST['data'];
            $url = "https://api.embed.ly/1/oembed?key=96677167dd4e4dd494564433fe259ff9&url=" . $text;

            $details = file_get_contents($url);
            $decode = CJSON::decode($details);
            $obj = array('status' => 'success', 'snippetdata' => $decode);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("GroupController:actionSnippetpriviewPage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUploadBanner() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder = Yii::getPathOfAlias('webroot') . '/upload/'; // folder for uploaded files
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "png", "tiff","tif","TIF"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //$sizeLimit = 30 * 1024 * 1024;// maximum file size in bytes
            $sizeLimit = Yii::app()->params['UploadMaxFilSize'];
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            
            $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
            $fileName = $result['filename']; //GETTING FILE NAME
            $extension = $result['extension'];

            $ext = "group/profile";
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
            Yii::log("GroupController:actionUploadBanner::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetGroupFollowers() {
        try {
            $groupId = $_GET['groupId'];
            $page = $_GET['GroupCollection_page'];
            $category = $_GET['category'];
            $pageSize = 18;


            $startLimit = ($pageSize * ($page - 1));

            $groupFollowersCount = ServiceFactory::getSkiptaPostServiceInstance()->getGroupMembersCount($groupId, $category);
            if ($groupFollowersCount == 0) {
                $groupFollowers = 0; //No Data
            } else if ($_GET['GroupCollection_page'] <= ceil($groupFollowersCount / $pageSize)) {
                $groupFollowers = (object) (ServiceFactory::getSkiptaPostServiceInstance()->getGroupFollowers($groupId, $startLimit, $pageSize, $category));
            } else {
                $groupFollowers = -1; //No more data
            }
            $this->renderPartial('groupFollowers', array('groupFollowers' => $groupFollowers, 'offset' => $startLimit));
        } catch (Exception $ex) {
            Yii::log("GroupController:actionGetGroupFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetGroupImages() {
        try {

            $groupId = $_REQUEST['groupId'];
            $offset = $_REQUEST['ResourceCollection_page'];
            $category = $_REQUEST['category'];
            $pageSize = 18;
            //   $groupImagesAndVideos=ServiceFactory::getSkiptaPostServiceInstance()->getImageAndVideoForGroups($groupId,$limit,$offset);

            $groupImagesAndVideos = ServiceFactory::getSkiptaPostServiceInstance()->getImagesAndArtifacts($groupId, $pageSize, $offset, 'Image', $category);

            $this->renderPartial('groupImagesAndVideos', array('groupArtifacts' => $groupImagesAndVideos, 'offset' => $offset, 'page' => 'Image'));
        } catch (Exception $ex) {
            Yii::log("GroupController:actionGetGroupImages::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetGroupDocs() {
        try {

            $groupId = $_REQUEST['groupId'];
            $offset = $_REQUEST['ResourceCollection_page'];
            $category = $_REQUEST['category'];
            $pageSize = 18;
            //   $groupImagesAndVideos=ServiceFactory::getSkiptaPostServiceInstance()->getImageAndVideoForGroups($groupId,$limit,$offset);          
            $groupImagesAndVideos = ServiceFactory::getSkiptaPostServiceInstance()->getImagesAndArtifacts($groupId, $pageSize, $offset, 'Docs', $category);

            $this->renderPartial('groupImagesAndVideos', array('groupArtifacts' => $groupImagesAndVideos, 'offset' => $offset, 'page' => 'Docs'));
        } catch (Exception $ex) {
            Yii::log("GroupController:actionGetGroupDocs::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetArtifactDetail() {
        try {

            $postId = $_REQUEST['postId'];
            $resource = $_REQUEST['resource'];
            $userId = $this->tinyObject->UserId;
            //$userId=$this->tinyObject['UserId'];          
            $postDetails = ServiceFactory::getSkiptaPostServiceInstance()->getArtifactDetails($postId, $resource, $userId);
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
            $this->renderPartial('artifactsDetail', array('postDetails' => $postDetails,"canMarkAsAbuse"=>$canMarkAsAbuse,'userLanguage'=>Yii::app()->session['language']));
        } catch (Exception $ex) {
            Yii::log("GroupController:actionGetArtifactDetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author suresh reddy
     * @mehtod used for get the groupStream
     * This method is to get the stream details
     */
    public function actionGroupStream() {
        try{
        $streamIdArray = array();
        $previousStreamIdArray = array();
        $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
        if(!empty($previousStreamIdString)){
            $previousStreamIdArray = explode(",", $previousStreamIdString);
        }
        if (isset($_GET['StreamPostDisplayBean_page'])) {
            $pageSize = 10;
            $groupId = $_GET['groupId'];
            $category = $_GET['category'];
            $timezone = $_REQUEST['timezone'];
            if ($category == 'SubGroup') {
                $conditions=array(
                            'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                            'IsDeleted' => array('notIn' =>  array(1, 2)),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'CategoryType' => array('==' => 7),
                            'SubGroupId' => array('==' => new MongoId($groupId)),
                        );
                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => $conditions,
                         'sort' => array('IsSaveItForLater' => EMongoCriteria::SORT_DESC),
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));
            } else {
                $conditions=array(
                            'UserId' => array('in' => array( 0,$this->tinyObject['UserId'])),
                            'IsDeleted' => array('notIn' =>  array(1, 2)),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                           
                            'ShowPostInMainStream' => array('==' => (int) 1),
                         
                        
                          //  'CategoryType' =>  array('or' => 13),
                            'CategoryType' =>  array('or' =>13),
                            'GroupId' => array('or' => new MongoId($groupId)),
                        );
                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => $conditions,
                        
                         'sort' => array('IsPromoted'=>EMongoCriteria::SORT_DESC,'IsSaveItForLater'=>EMongoCriteria::SORT_DESC,'CreatedOn' => EMongoCriteria::SORT_DESC),
                  
                    )
                ));
            }
            $UserId = $this->tinyObject['UserId'];
            if ($provider->getTotalItemCount() == 0) {
                $stream = 0; //No posts
            } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                $streamRes="";
                if ($category == 'SubGroup') {
                     $dataArray = array_merge($provider->getData(), array());
                    $streamRes = (object) (CommonUtility::prepareStreamData($UserId, $dataArray, $this->userPrivileges, 2, Yii::app()->session['PostAsNetwork'], $timezone,$previousStreamIdArray));
                } else {
                    $dataArray = array_merge($provider->getData(), $this->getDerivateObjectsStream($UserId, $groupId));
                    //$dataArray = array_merge($this->getUserSaveItForLaterStream($this->tinyObject['UserId'],array(3,7)),$dataArray);
                    $streamRes = (object) (CommonUtility::prepareStreamData($UserId, $dataArray, $this->userPrivileges, 2, Yii::app()->session['PostAsNetwork'], $timezone,$previousStreamIdArray));
                }
                $streamIdArray=$streamRes->streamIdArray;
                $totalStreamIdArray=$streamRes->totalStreamIdArray;
                $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                $streamIdArray = array_values(array_unique($streamIdArray));
                $stream=(object)($streamRes->streamPostData);
                if (sizeof($streamRes->streamPostData) == 0) {
                        $stream = -2;
                    }
                    if (sizeof($provider->getData()) == 0) {
                        $stream = -1;
                    }
                
                
            } else {
                $stream = -1; //No more posts
            }
            $streamData = "";

            if ($category == 'SubGroup') { 
                $disableWebPreview = ServiceFactory::getSkiptaPostServiceInstance()->getGroupDisableWebPreviewByGroupId($groupId, "SubGroup");
                $streamData = $this->renderPartial('subgroup_posts_view', array('stream' => $stream, 'pageType' => $category,"disableWebPreview"=>$disableWebPreview,'userLanguage'=>Yii::app()->session['language']), true);

            } else {
                 $userId = $this->tinyObject['UserId'];
                $disableWebPreview = ServiceFactory::getSkiptaPostServiceInstance()->getGroupDisableWebPreviewByGroupId($groupId, "Group");
                $streamData = $this->renderPartial('group_posts_view', array('stream' => $stream, 'pageType' => $category,"disableWebPreview"=>$disableWebPreview,'userLanguage'=>Yii::app()->session['language']), true);

            }
            $streamIdString = implode(',', $streamIdArray);
            echo $streamData."[[{{BREAK}}]]".$streamIdString;
        }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionGroupStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actiongetUserFollowingGroups() {
        $returnValue = 'failure';
        try {
            $UserId = $this->tinyObject['UserId'];
            $userGroupsFollowing = ServiceFactory::getSkiptaUserServiceInstance()->groupsUserFollowing($UserId);
            $userFollowingGroupsCount = ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingGroups($UserId);
            $obj = array("status" => 'error', 'data' => $userGroupsFollowing, "count" => count($userFollowingGroupsCount), "error" => '');
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("GroupController:actiongetUserFollowingGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    public function actiongetGroupIntroPopUp() {
        $returnValue = 'failure';
        $groupId = '';
        $UserId = $this->tinyObject['UserId'];
        try {
            if (isset($_REQUEST['groupId'])) {

                $groupId = $_REQUEST['groupId'];
                $groupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupIntroPopUp($groupId, $UserId);
                if ($groupDetails != 'failure') {
                    $returnValue = $groupDetails;
                     if($groupDetails->RestrictedAccess == 1){
                        $userAllowable = CommonUtility::getGroupAccessibleUserStatusByGroupId($groupId,Yii::app()->session['Email']);
                     $groupDetails->IsAccessGroup = $userAllowable == 1?0:1;
                      
                    }  
                }
                $this->renderPartial('groupIntroPopUp', array('groupDetails' => $returnValue));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actiongetGroupIntroPopUp::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    /**
     * @author Vamsi Krishna
     * params GroupId
     * 
     */

    /**
     * @Author:Vamsi Krishna
     * @method public methodName(type SubGroupName, Description) 
     * Description: To create a new group
     */
    public function actioncreateSubGroup() {
        try {

            $UserId = $this->tinyObject['UserId'];
            $obj = array();
            $this->layout = 'groupLayout';
            $newGroupModel = new SubGroupCreationForm();

            if (isset($_POST['SubGroupCreationForm'])) {
                $newGroupModel->attributes = $_POST['SubGroupCreationForm'];
                $errors = CActiveForm::validate($newGroupModel);
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $newGroupModel->UserId = $this->tinyObject['UserId'];
                    $UserId = $newGroupModel->UserId;
                    // $newGroupModel->UserId=$this->tinyObject['UserId'];       
                    $networkId = $this->tinyObject['NetworkId'];
                    $networkAdminUserId = Yii::app()->session['NetworkAdminUserId'];
                    $subGroupId = ServiceFactory::getSkiptaGroupServiceInstance()->createNewSubGroup($newGroupModel, $UserId,$networkId,$networkAdminUserId);
                    if ($subGroupId != 'failure' && $subGroupId != 'groupexists') {
                        //$message = Yii::t('translation', 'GroupCreation_Saving_Success');
                        $message = "Sub Group created successfully.";
                        $obj = array('status' => 'success', 'data' => $message);
                    } elseif ($subGroupId == 'groupexists') {
                        $message = "Sub Group already exists.";
                        $errorMessage = array('SubGroupCreationForm' => $message);
                        $obj = array("status" => 'error', 'data' => $message, "error" => $errorMessage);
                    } else {
                        //$message = Yii::t('translation', 'GroupCreation_Saving_Fail');
                        $message = "created failed";
                        $errorMessage = array('SubGroupCreationForm' => $message);
                        $obj = array("status" => 'error', 'data' => $message, "error" => $errorMessage);
                    }
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            } else {

                $this->render('index', array('newGroupModel' => $newGroupModel));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actioncreateSubGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetSubGroups() {
        try {
            $newSubGroupModel = new SubGroupCreationForm();
            $groupId = $_REQUEST['groupId'];
            $groupDetails = GroupCollection::model()->getGroupDetailsById($groupId);
            $this->renderPartial('subGroups', array('newGroupModel' => $newSubGroupModel, 'groupId' => $groupId, 'groupName' => $groupDetails->GroupUniqueName));
        } catch (Exception $ex) {
            Yii::log("GroupController:actionGetSubGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actiongetUserFollowingSubGroups() {
        $returnValue = 'failure';
        try {
            $UserId = $this->tinyObject['UserId'];
            $groupId = $_REQUEST['groupId'];

            
            $userGroupsFollowing = ServiceFactory::getSkiptaUserServiceInstance()->SubGroupsUserFollowing($UserId, $groupId);
            if ($userGroupsFollowing == 'failure') {
                $userGroupsFollowing = 'failure';
            }
            $userFollowingGroupsCount = ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingSubGroups($UserId, $groupId);
            if ($userFollowingGroupsCount == 'failure') {
                $userFollowingGroupsCount = 0;
            } else {
                $userFollowingGroupsCount = count($userFollowingGroupsCount);
            }
            $obj = array("status" => 'error', 'data' => $userGroupsFollowing, "count" => $userFollowingGroupsCount, "error" => '');
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("GroupController:actiongetUserFollowingSubGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    public function actiongetMoreFollowingSubGroups() {
        try {
            $startLimit = $_REQUEST['startLimit'];
            $pageLength = $_REQUEST['pageLength'];
            $groupId = $_REQUEST['groupId'];
            $UserId = $this->tinyObject['UserId'];
            $userGroupsFollowing = ServiceFactory::getSkiptaUserServiceInstance()->getMoreFollowingSubGroups($UserId, $startLimit, $pageLength, $groupId);
            $obj = array('status' => 'success', 'data' => $userGroupsFollowing);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {

            Yii::log("GroupController:actiongetMoreFollowingSubGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetJoinMoreSubGroups() {
        try {
            if (isset($_GET['SubGroupCollection_page'])) {
                $groupId = $_GET['groupId'];
                $groupDetails = GroupCollection::model()->getGroupDetailsById($groupId);
                $userId = $this->tinyObject['UserId'];
                $pageSize = 3;
                $userGroupsFollowing = ServiceFactory::getSkiptaUserServiceInstance()->SubGroupsUserNotFollowing($userId, $groupId);

                $provider = new EMongoDocumentDataProvider('SubGroupCollection', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => array(
                            'GroupId' => array('==' => new MongoId($groupId)),
                            '_id' => array('notin' => $userGroupsFollowing)),
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));

                if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else if ($_GET['SubGroupCollection_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $stream = (Object) $provider->getData();
                } else {

                    $stream = -1; //No more posts
                }
                $this->renderPartial('subGroups_view', array('stream' => $stream, 'groupName' => $groupDetails->GroupUniqueName));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionGetJoinMoreSubGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @Author:Vamsi 
     * Description: Method to follow sub groups 
     * @returntype: json object
     */
    public function actionUserFollowSubGroup() {
        try {
            $result = "failure";
            if (isset($_REQUEST['groupId']) && isset($_REQUEST['actionType'])) {

                $userId = $this->tinyObject->UserId;
                $groupId = $_REQUEST['groupId'];
                $subGroupId = $_REQUEST['subGroupId'];
                $result = ServiceFactory::getSkiptaGroupServiceInstance()->saveFollowOrUnfollowToSubGroup($_REQUEST['groupId'], $userId, $_REQUEST['actionType'], $subGroupId);
                $subgroupDetails = SubGroupCollection::model()->getSubGroupDetailsById($subGroupId);
                $isSubGroupAdmin = in_array($userId, $subgroupDetails->SubGroupAdminUsers);
                if ($result == "failure") {
                    throw new Exception('Unable to follow or unfollow');
                }
                //$userFollowingGroups=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingSubGroups($userId);
                //Yii::app()->session['UserFollowingGroups']=$userFollowingGroups;
            }

            $obj = array("status" => $result, "data" => "", "error" => "", "actionType" => $_REQUEST['actionType'], "userId" => $userId, "isSubGroupAdmin" => $isSubGroupAdmin);
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            Yii::log("GroupController:actionUserFollowSubGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $id = "socialactionsError_" . $_REQUEST['groupId'];
            $actionType = $_REQUEST['actionType'];
            if ($actionType == "Follow") {
                $translation = "Follow_Action_Fail";
            } else {
                $translation = "UnFollow_Action_Fail";
            }

            $this->throwErrorMessage($id, $translation);
        }
    }

    /**
     * @author Praneeth
     * @mehtod used for get the subgroup details in intropopup
     */
    public function actiongetSubGroupIntroPopUp() {
        $returnValue = 'failure';
        $subgroupId = '';
        $UserId = $this->tinyObject['UserId'];
        try {
            if (isset($_REQUEST['subgroupId'])) {

                $subgroupId = $_REQUEST['subgroupId'];
                $subgroupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getSubGroupIntroPopUp($subgroupId, $UserId);
                $maingroupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupDetailsById($subgroupDetails->ParentGroupId);
                if ($subgroupDetails != 'failure') {
                    $returnValue = $subgroupDetails;
                }
                $this->renderPartial('subgroupIntroPopUp', array('subgroupDetails' => $returnValue, 'maingroupDetails' => $maingroupDetails));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actiongetSubGroupIntroPopUp::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    /**
     * Author @vamsikrishna
     * This method is to render the group detail page 
     */
    public function actionSubGroupDetail() {
        try {

            $urlArray = explode("/", Yii::app()->request->url);

            $newGroupModel = new SubGroupCreationForm();
            $groupName = $urlArray[1];
            $subGroupName = $urlArray[3];
            $groupId = '';
            $groupName = trim(urldecode($groupName));
            $subGroupName = trim(urldecode($subGroupName));
            $groupId = ServiceFactory::getSkiptaPostServiceInstance()->getGroupIdByName($groupName);
            $groupStatusResult=ServiceFactory::getSkiptaGroupServiceInstance()->getGroupStatus($groupId);
            $groupStatus=$groupStatusResult->Status;
            
            $subgroupId = ServiceFactory::getSkiptaGroupServiceInstance()->getSubGroupIdByName($subGroupName, $groupId);
            $userId = $this->tinyObject['UserId'];
            if ($subgroupId != "failure") {
                $groupPostModel = new GroupPostForm();
                $groupPostModel->GroupId = $groupId;
                $groupPostModel->SubGroupId = $subgroupId;

                $groupStatistics = ServiceFactory::getSkiptaGroupServiceInstance()->getSubGroupStatistics($groupId, $userId, $subgroupId);
                $subGroupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getSubGroupDetailsById($subgroupId);
                if (!is_string($subGroupDetails)) {
                    $newGroupModel->id = $subGroupDetails->_id;
                    $newGroupModel->SubGroupName = $subGroupDetails->SubGroupName;
                    $newGroupModel->SubGroupDescription = $subGroupDetails->SubGroupDescription;
                    $newGroupModel->ShowPostInMainStream = $subGroupDetails->ShowPostInMainStream;
                    $newGroupModel->GroupId = $subGroupDetails->GroupId;
                    $newGroupModel->AddSocialActions = $subGroupDetails->AddSocialActions;
                    $newGroupModel->DisableWebPreview = $subGroupDetails->DisableWebPreview;
                    $newGroupModel->DisableStreamConversation = $subGroupDetails->DisableStreamConversation;
                     if($subGroupDetails->Status==1){
                     $newGroupModel->Status=0;    
                    }else{
                     $newGroupModel->Status=1;       
                    }
                    
                }
                //          $groupMembers=$groupDetails->GroupMembers;


                $showPostOption = ($this->userPrivilegeObject->canSurvey == 1 || $this->userPrivilegeObject->canEvent == 1) ? 1 : 0;
                $this->render('subgroupDetail', array("groupStatistics" => $groupStatistics, 'newGroupModel' => $newGroupModel, 'groupPostModel' => $groupPostModel, 'showPostOption' => $showPostOption,'groupStatus'=>$groupStatus));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionSubGroupDetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author vamsi krishna
     * get derivate objects get
     * 
     */
    public function getDerivateObjectsStream($userId, $groupId) {
        try {

            $pageSize = 1;
            $provider = new EMongoDocumentDataProvider('DerivativeObjectDisplayBean', array(
                'pagination' => array('pageSize' => 2),
                'criteria' => array(
                    'conditions' => array(
                        'UserId' => array('==' => $userId),
                        'IsDeleted' => array('!=' => 1),
                        'IsAbused' => array('notIn' => array(1, 2)),
                        'IsEngage' => array('==' => 0),
                        'Priority' => array('>' => 1),
                        'SubGroupId' => array('>' => new MongoId($groupId)),
                        'CategoryType' => array('==' => 7)
                    ),
                    'sort' => array('Priority' => EMongoCriteria::SORT_DESC)
                )
            ));

            $dataArray = $provider->getData();
            foreach ($dataArray as $key => $data) {
                $postId = "$data->PostId";
                $userId = $data->UserId;
                $id = $data->_id;
                ServiceFactory::getSkiptaPostServiceInstance()->updateDerivateObjectPriority($id, $postId, $userId);
            }
            return $dataArray;
        } catch (Exception $ex) {
            Yii::log("GroupController:getDerivateObjectsStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getUserSaveItForLaterStream($userId,$groupId)
    {
         try {

            $pageSize = 10;
            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                'pagination' => array('pageSize' => 10),
                'criteria' => array(
                    'conditions' => array(
                        'UserId' => array('==' => (int)$userId),
                        'IsDeleted' => array('!=' => 1),
                        'IsAbused' => array('notIn' => array(1, 2)),
                        "saveItForLaterUserIds" => array('In'=>array($userId)),
                     //   'SubGroupId' => array('>' => new MongoId($groupId)),
                        'CategoryType' => array('In' => $groupId),
                        'IsSaveItForLater'=>array('==' => 1),
                    ),
                     'sort' => array('IsSaveItForLater' => EMongoCriteria::SORT_DESC)
                )
            ));

            $dataArray = $provider->getData();
            
            return $dataArray;
        } catch (Exception $ex) {
            Yii::log("GroupController:getUserSaveItForLaterStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * This method is used load t he Group Widget
     */
    public function actiongetGroupPostWidget() {
        try {
            if (isset($_REQUEST['groupId'])) {

                $groupPostModel = new GroupPostForm();
                $isGroupPrivate = 0;
                $groupId = $_REQUEST['groupId'];
                $groupPostModel->GroupId = $groupId;
                $groupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupDetailsById($groupId);
                if (!is_string($groupDetails)) {
                    $isGroupPrivate = $groupDetails->IsPrivate;
                }
                $showPostOption = ($this->userPrivilegeObject->canSurvey == 1 || $this->userPrivilegeObject->canEvent == 1) ? 1 : 0;
                $this->renderPartial('iframeGroupPost', array('groupPostModel' => $groupPostModel, 'showPostOption' => $showPostOption, 'IsPrivateGroup' => $isGroupPrivate,'groupId'=>$groupId,'DisableWebPreview'=>$groupDetails->DisableWebPreview,'DisableStreamConversation'=>$groupDetails->DisableStreamConversation));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actiongetGroupPostWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGroupAnalytics() {
        try {

            $returnValue = 'failure';
            // $groupId = '536861e19f7c88f1048b4567';
            //$groupId = '5370db3f9f7c882f7e8b4571';
            $urlArray = explode("/", Yii::app()->request->url);
            $groupName = $urlArray[1];

            $groupId = '';
            $groupId = ServiceFactory::getSkiptaPostServiceInstance()->getGroupIdByName($groupName);
            $groupObject = ServiceFactory::getSkiptaPostServiceInstance()->getGroupObjectByName($groupName);
            $groupPostModel = new GroupPostForm();
            $groupId = $groupObject->_id;
            $IsIFrameMode = isset($groupObject->IsIFrameMode) ? $groupObject->IsIFrameMode : 0;
            $groupPostModel->GroupId = $groupId;
            $userId = $this->tinyObject['UserId'];
            $groupStatistics = ServiceFactory::getSkiptaPostServiceInstance()->getGroupStatistics($groupId, $userId);

            $newGroupCreationModel = new GroupCreationForm();
            $groupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupDetailsById($groupId);
            if ($groupDetails != 'failure') {
                $newGroupCreationModel->GroupName = $groupDetails->GroupName;
                $newGroupCreationModel->Description = $groupDetails->GroupDescription;
                $newGroupCreationModel->IFrameMode = $groupDetails->IsIFrameMode;
                $newGroupCreationModel->IFrameURL = $groupDetails->IFrameURL;
                $newGroupCreationModel->AutoFollow = $groupDetails->AutoFollow;
                $newGroupCreationModel->IsPrivate = $groupDetails->IsPrivate;
                $newGroupCreationModel->AddSocialActions = $groupDetails->AddSocialActions;
                $newGroupCreationModel->DisableWebPreview = $groupDetails->DisableWebPreview;
                $newGroupCreationModel->DisableStreamConversation = $groupDetails->DisableStreamConversation;
                $groupMembers = $groupDetails->GroupMembers;
                if (in_array($userId, $groupMembers)) {
                    ServiceFactory::getSkiptaUserServiceInstance()->updateUserProfileForGroupActivity($userId, $groupId);
                }
            }
            //$groupId=$_REQUEST['id'];
//            $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->SaveGroupTopLeadersOfTheDay($groupId);exit;
            $groupStatisticsData = ServiceFactory::getSkiptaPostServiceInstance()->getGroupObjectByName($groupName);

            //  $IsIFrameMode = isset($groupStatistics->IsIFrameMode) ? $groupStatistics->IsIFrameMode : 0;
            $userId = $this->tinyObject['UserId'];
            $GroupAnalytics = ServiceFactory::getSkiptaPostServiceInstance()->getGroupDetailForAnalytics($groupStatisticsData->_id);
            $this->render('groupAnalytics', array("IsIFrameMode" => $IsIFrameMode, "groupStatistics" => $groupStatistics, "groupStatisticsData" => $groupStatisticsData, "groupAnalytics" => $GroupAnalytics, "preferencesModel" => $newGroupCreationModel, 'groupPostModel' => $groupPostModel, 'newGroupModel' => $newGroupModel, "iframeURL" => $groupObject->IFrameURL, "groupId" => $groupId));
        } catch (Exception $ex) {
            Yii::log("GroupController:actionGroupAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionAutoFollowGroup() {
        try {
            $returnValue = 'failure';
            if (isset($_REQUEST['groupId'])) {
                $groupId = $_REQUEST['groupId'];
                $isChecked = $_REQUEST['isChecked'];
                $userId = $this->tinyObject['UserId'];

                if ($isChecked == 1) {
                    $value = (int) 1;
                    $type = 'AutoFollow';
                    $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, $value, $type, $groupId, 'Group');
                    ServiceFactory::getSkiptaGroupServiceInstance()->AutoFollowGroupFromPreference($groupId);
                } else {
                    $value = (int) 0;
                    $type = 'AutoFollow';
                    $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, $value, $type, $groupId, 'Group');
                }
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionAutoFollowGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIsUserFollowAGroup() {
        try {
            $groupId = $_REQUEST['postId'];
            $userId = $_REQUEST['userId'];
            $categoryType = $_REQUEST['categoryType'];
            $returnValue = ServiceFactory::getSkiptaGroupServiceInstance()->isUserFollowsAGroup($userId, $groupId, $categoryType);

            if ($returnValue != true) {
                $groupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupDetailsWithoutGroupMembersByGroupId($groupId, $categoryType);
                if ($categoryType == 3) {
                    $obj = array("data" => $returnValue, 'groupName' => $groupDetails['GroupName']);
                } else if ($categoryType == 7) {
                    $obj = array("data" => $returnValue, 'groupName' => $groupDetails['GroupName'], 'subgroupName' => $groupDetails['SubGroupName']);
                }
            } else {
                $obj = array("data" => $returnValue);
            }

            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in Group Controller->actionIsUserFollowAGroup==". $ex->getMessage());
            Yii::log("GroupController:actionIsUserFollowAGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionChangeSubGroupShowInStream() {
        try {
            $returnValue = 'failure';
            if (isset($_REQUEST['subGroupId'])) {
                $subGroupId = $_REQUEST['subGroupId'];
                $isChecked = $_REQUEST['isChecked'];
                $userId = $this->tinyObject['UserId'];

                $type = 'ShowPostInMainStream';
                $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, (int) $isChecked, $type, $subGroupId, 'SubGroup');
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionChangeSubGroupShowInStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionFollowAllGroups() {
        try {
            $userId = (int) (Yii::app()->session['NetworkAdminUserId']);
            $groupDetailObj = GroupCollection::model()->getAllGroupIds();
            $groupIdList = array();
            $i = 0;
            $userClassification = $this->tinyObject->UserClassification;
            foreach ($groupDetailObj as $key => $group) {
                $i++;
                $groupId = (string) $group->_id;
                $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToGroup($groupId, $userId, 'Follow',"",$userClassification);
            }
            echo $i . " Groups followed";
        } catch (Exception $ex) {
            Yii::log("GroupController:actionFollowAllGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionFollowAllSubGroups() {
        try {
            $userId = (int) (Yii::app()->session['NetworkAdminUserId']);
            $groupDetailObj = SubGroupCollection::model()->getAllSubGroupIds();
            $i = 0;
            foreach ($groupDetailObj as $key => $group) {
                $i++;
                $subGroupId = (string) $group->_id;
                $groupId = (string) $group->GroupId;
                $returnValue = ServiceFactory::getSkiptaGroupServiceInstance()->saveFollowOrUnfollowToSubGroup($groupId, $userId, 'Follow', $subGroupId);
            }
            echo $i . " Sub-Groups followed";
        } catch (Exception $ex) {
            Yii::log("GroupController:actionFollowAllSubGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionRedirectToGroupDetail() {
        try {
            $groupId = $_REQUEST["OrganizationGID"];
            $groupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupDetailsByMigratedId($groupId);
            if ($groupDetails != 'failure') {
                $groupName = $groupDetails->GroupName;
                $this->redirect("/$groupName");
            }
        } catch (Exception $ex) {
            error_log($ex->getTraceAsString() . "==Exception Occurred in Group Controller actionRedirectToGroupDetail====" . $ex->getMessage());
            Yii::log("GroupController:actionRedirectToGroupDetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionUpdateGroupConversationsSettings() {
        try {
            $returnValue = 'failure';
            if (isset($_REQUEST['groupId'])) {
                $groupId = $_REQUEST['groupId'];
                $isChecked = $_REQUEST['isChecked'];
                $userId = $this->tinyObject['UserId'];
                $type = 'ConversationVisibility';
                if ($isChecked == 1) {
                    $value = (int) 1;
                }else{
                    $value = (int) 0;
                }
                $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, $value, $type, $groupId, 'Group');
                echo CJSON::encode(array("status"=>$returnValue));
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionUpdateGroupConversationsSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
public function actionAddSocialActions() {
        try {
            $returnValue = 'failure';
            if (isset($_REQUEST['groupId'])) {
                $groupId = $_REQUEST['groupId'];
                $isChecked = $_REQUEST['isChecked'];
                $userId = $this->tinyObject['UserId'];
            if ($isChecked == 1) {
                    $value = (int) 1;
                    $type = 'AddSocialActions';
                    $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, $value, $type, $groupId, 'Group');
                    ServiceFactory::getSkiptaGroupServiceInstance()->AutoFollowGroupFromPreference($groupId);
                } else {
                    $value = (int) 0;
                    $type = 'AddSocialActions';
                    $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, $value, $type, $groupId, 'Group');
                }
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionAddSocialActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
  public function actionChangeSubGroupAddSocialActions() {
        try {
            $returnValue = 'failure';
            if (isset($_REQUEST['subGroupId'])) {
                $subGroupId = $_REQUEST['subGroupId'];
                $isChecked = $_REQUEST['isChecked'];
                $userId = $this->tinyObject['UserId'];

                $type = 'AddSocialActions';
                $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, (int) $isChecked, $type, $subGroupId, 'SubGroup');
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionChangeSubGroupAddSocialActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionDisableWebPreview() {
        try {
            $returnValue = 'failure';
            if (isset($_REQUEST['groupId'])) {
                $groupId = $_REQUEST['groupId'];
                $isChecked = $_REQUEST['isChecked'];
                $userId = $this->tinyObject['UserId'];

                if ($isChecked == 1) {
                    $value = (int) 1;
                    $type = 'DisableWebPreview';
                    $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, $value, $type, $groupId, 'Group');
                    ServiceFactory::getSkiptaGroupServiceInstance()->AutoFollowGroupFromPreference($groupId);
                } else {
                    $value = (int) 0;
                    $type = 'DisableWebPreview';
                    $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, $value, $type, $groupId, 'Group');
                }
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionDisableWebPreview::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
  
  public function actionChangeSubGroupDisableWebPreview() {
        try {
            $returnValue = 'failure';
            if (isset($_REQUEST['subGroupId'])) {
                $subGroupId = $_REQUEST['subGroupId'];
                $isChecked = $_REQUEST['isChecked'];
                $userId = $this->tinyObject['UserId'];

                $type = 'DisableWebPreview';
                $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupDetails($userId, (int) $isChecked, $type, $subGroupId, 'SubGroup');
            }
        } catch (Exception $ex) {
            Yii::log("GroupController:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionUpdateGroupSettings() {
        try {
            $UserId = $this->tinyObject['UserId'];
            $obj = array();
            $this->layout = 'groupLayout';
            $newGroupModel = new GroupCreationForm();
            $obj = array();
            if (isset($_POST['GroupCreationForm'])) {
                
                $newGroupModel->attributes = $_POST['GroupCreationForm'];
                $errors = CActiveForm::validate($newGroupModel);

                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                  
                    $result = ServiceFactory::getSkiptaPostServiceInstance()->updateGroupObject($newGroupModel);
                    
                    if(!empty($newGroupModel->FileName))
                        $obj = $this->saveUploadedFile($newGroupModel->FileName,$newGroupModel->id,$newGroupModel->GroupName);
                    if ($result != 'failure') {
                        $message = "Group updated successfully.";
                        if(!empty($obj) && ($obj['status'] == "error" || $obj['data'] == "error") ){
                            $message = $obj['msg'];
//                            $errorMessage = array('GroupCreationForm_FileName' => $message);
                            $obj = array('status' => 'error', 'data' => $message);
                        }else{
                        $obj = array('status' => 'success', 'data' => $message);
                        }
                        
                    } else {
                        $message = "updation failed";
//                        $errorMessage = array('GroupCreationForm_FileName' => $message);
                        $obj = array("status" => 'error', 'data' => $message);
                    }
                }
               
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            } 
        } catch (Exception $ex) {
            Yii::log("GroupController:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   
     public function actionFileUpload() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            // $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'];
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("csv"); // allowed extension while uploading...
            // $sizeLimit = 30 * 1024 * 1024;// maximum file size in bytes
            $sizeLimit = Yii::app()->params['UploadMaxFilSize'];// maximum file size in bytes, reading from the configuration

            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);

            if (isset($result['filename'])) {
                $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
                $fileName = $result['filename']; //GETTING FILE NAME
                $result["filepath"] = Yii::app()->getBaseUrl(true) . '/temp/' . $fileName;
                $result["fileremovedpath"] = $folder . $fileName;
            } else {
                $result['success'] = false;
            }
            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
        } catch (Exception $ex) {
            Yii::log("GroupController:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function saveUploadedFile($filename,$groupId,$groupName){
        try{
            $row = 1;
            $webroot = Yii::app()->params['WebrootPath'];
            $userId = $this->tinyObject['UserId'];
            $filePath = $webroot."temp/$filename";          
            $emailArrays = array();
            $obj = array("status"=>"");
            $msg = "";
            $status = "success";
            
            $emailsarray = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupAccessibleUsers($userId, $groupId);
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    for ($c=0; $c < $num; $c++) {
                        $email = $data[$c];
                        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                            if(!in_array($email,$emailsarray))
                                array_push($emailArrays,$email);                            
                        }else{
                            $msg = "Please check some of the emails are not valid";
                            $status = "error";
                        }
                    }
                }
                fclose($handle);
                $fileArr = explode(".",$filename);
                $newFileName = $fileArr[0].date("Y-m-d H:i:s").".".$fileArr[1];
                $filePath1 = $webroot."temp/$newFileName";    
                rename($filePath,$filePath1);
                
                $returnValue = "success";
                if(sizeof($emailArrays) > 0){
                    $folder = $webroot."upload/groupUserFiles/";
                    if (!file_exists($folder)) {
                        mkdir($folder, 0755, true);
                    }
                    $destination = $folder.$newFileName;
                    //copying source file to destination file...
                    if(copy($filePath1,$destination)){                    
                        unlink($filePath1);
                    }
                    $returnValue_ = ServiceFactory::getSkiptaGroupServiceInstance()->saveGroupAccessibleUsersEmailsList($userId, $groupId, $groupName,$emailArrays);
                    $returnValue = ServiceFactory::getSkiptaGroupServiceInstance()->saveGroupFiles($userId,$filename, $groupId, $groupName,$newFileName);
                }else{                    
                    $returnValue  = "error";
                    $msg = "$filename - File/Data already Exist!";
                }
                $obj = array("status"=>$returnValue,"data"=>$status,"msg"=>$msg);
            }
            return $obj;
        } catch (Exception $ex) {
            error_log("Exception Occurred in Group Controller actionIndex==".$ex->getMessage());
            Yii::log("GroupController:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionDeleteFromList(){
        try{
            $fileId = $_REQUEST['fileId'];
            $userId = $this->tinyObject['UserId'];
            $returnValue = ServiceFactory::getSkiptaGroupServiceInstance()->deleteAFileById($userId,$fileId);
            $obj = array("status"=>$returnValue);
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            Yii::log("GroupController:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   
    public function actionUpdateSubGroupSettings() {
        try {
            $UserId = $this->tinyObject['UserId'];
            $obj = array();
            $this->layout = 'groupLayout';
            $newGroupModel = new SubGroupCreationForm();

            if (isset($_POST['SubGroupCreationForm'])) {
                
                $newGroupModel->attributes = $_POST['SubGroupCreationForm'];
                $errors = CActiveForm::validate($newGroupModel);

                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $result = ServiceFactory::getSkiptaGroupServiceInstance()->updateSubGroupObject($newGroupModel);
                  
                    if ($result != 'failure') {
                        $message = "SubGroup updated successfully.";
                        $obj = array('status' => 'success', 'data' => $message);
                    } else {
                        $message = "updation failed";
                        $errorMessage = array('SubGroupCreationForm' => $message);
                        $obj = array("status" => 'error', 'data' => $message, "error" => $errorMessage);
                    }
                }
               
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            } 
        } catch (Exception $ex) {
            Yii::log("GroupController:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 
    }
    public function actionDownloadFile() {
            try{
                $folder = "upload/groupUserFiles/";
                $filename = $_REQUEST['filename'];        
                CommonUtility::downloadAFile($filename,$folder);
            } catch (Exception $ex) {
                Yii::log("GroupController:actionDownloadFile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }

    }
}