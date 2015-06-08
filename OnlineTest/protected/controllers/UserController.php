<?php


/*
 * Developer Suresh Reddy
 * on 8 th Jan 2014
 * all users actions need to add here
 */

class UserController extends Controller {
  

public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }
public function init() {
    try{
    parent::init();
     if(!isset($_REQUEST['mobile'])){
       if(isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])){
                 $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];
                $this->userPrivileges=Yii::app()->session['UserPrivileges'];
             
             }else{
                  $this->redirect('/');
                 }  
     }
     } catch (Exception $ex) {
        Yii::log("UserController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
       
 }
 public function actionError(){
     try{
 $cs = Yii::app()->getClientScript();
$baseUrl=Yii::app()->baseUrl; 
$cs->registerCssFile($baseUrl.'/css/error.css');
    if($error=Yii::app()->errorHandler->error)
        $this->render('error', $error);
    } catch (Exception $ex) {
        Yii::log("UserController:actionError::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}

/**
 * author: karteek.v
 * actionGetMiniPorfile is used to get user mini profile
 * request an userId
 * returns an user object
 */
public function actionGetMiniProfile(){
    try{
        if(isset($_REQUEST['userid'])){
            $userid = $_REQUEST['userid'];
            $result = ServiceFactory::getSkiptaUserServiceInstance()->getUserMiniProfile($userid,Yii::app()->session['TinyUserCollectionObj']->UserId);
        }
        
        $obj = array('status' => 'success', 'data' => $result, 'error' => '', 'networkAdmin'=>(int)Yii::app()->session['NetworkAdminUserId'],'networkmode'=>(int)Yii::app()->session['PostAsNetwork']);        
        echo CJSON::encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("UserController:actionGetMiniProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
}
  /**
     * @Author Moin Hussain
     * This method is used actionTrackMinHashTagWindowOpen summary
     * @return type  
     */
    public function actionTrackMinMentionWindowOpen() {
         try{
        if(isset($_REQUEST['userid'])){
            $userId = $_REQUEST['userid'];
             $networkId = $this->tinyObject['NetworkId'];
            ServiceFactory::getSkiptaUserServiceInstance()->trackMinMentionWindowOpen(Yii::app()->session['TinyUserCollectionObj']->UserId,$userId,$networkId);
        }
        
        $obj = array('status' => 'success', 'data' => "", 'error' => '');        
        echo CJSON::encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("UserController:actionTrackMinMentionWindowOpen::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
/**
 * @author karteek.v
 * actionUserFollowUnfollowActions is used for either follow or unfollow actions
 * @param $userid,$type
 * @return type json object
 */
public function actionUserFollowUnfollowActions(){
    try{
        if(isset($_REQUEST['type']) && isset($_REQUEST['userid'])){
            $type = $_REQUEST['type'];
            $followId = $_REQUEST['userid'];
            $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
            if(strtolower(trim($type)) == "follow"){
                $result = ServiceFactory::getSkiptaUserServiceInstance()->followAUser($userId,$followId);
            }else if(strtolower(trim($type)) == "unfollow"){
                $result = ServiceFactory::getSkiptaUserServiceInstance()->unFollowAUser($userId,$followId);
            }
        }else{
            Yii::log("==actionUserFollowUnfollowActions=else not set=","error","application");
        }
        $obj = array("status"=>$result,"data"=>"","error"=>"",'translate_follow'=>Yii::t('translation','Follow'),'translate_unFollow'=>Yii::t('translation','UnFollow'));
    } catch (Exception $ex) {
        Yii::log("UserController:actionUserFollowUnfollowActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    echo CJSON::encode($obj);
}

public function actionLogout(){
    try {
        Yii::app()->user->logout();
        Yii::app()->session->destroy();
         if(!isset($_REQUEST['mobile'])){
             $randomString = Yii::app()->user->getState('s_k');
          $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
     ServiceFactory::getSkiptaUserServiceInstance()->deleteCookieRandomKeyForUser($userId,$randomString);
      Yii::app()->request->cookies->clear();
       
         $this->redirect('/site'); 
         }else{
              $sessionId = $_POST["sessionId"];
            $userId = $_POST["userId"];
            $response = ServiceFactory::getSkiptaUserServiceInstance()->logout($sessionId,$userId);  
           if($response){
             $obj = array("status"=>"success","data"=>"","error"=>"");    
           }else{
                 $obj = array("status"=>"failure","data"=>"","error"=>"");
           }
            echo $this->rendering($obj);
            
         }
        
         
    } catch (Exception $ex) {
        Yii::log("UserController:actionLogout::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}


/**
 * @author Praneeth
 * actionGetNewFollowersList is used to get users who have followed the logged in user since the last login
 * @return type json object
 * /
 */
public function actionGetNewFollowersList() {
        try {
            $newFollowersList = "";
            $userid = Yii::app()->session['TinyUserCollectionObj']->UserId;
            $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userid);
            $PreviousLastLoginDate = strtotime(date($data['PreviousLastLoginDate']));
            $newFollowersList = ServiceFactory::getSkiptaUserServiceInstance()->getNewFollowersListByDate($userid, $PreviousLastLoginDate);
            $followersCount = count($newFollowersList);
            if ($newFollowersList != 'failure') {
                $this->renderPartial('newFollowers_view', array('newFollowersList' => $newFollowersList, 'followersCount' => $followersCount,'loggedUserId'=>$userid));
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetNewFollowersList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    
 /**
 * @author Lakshman
 * actionGetNewFollowersList is used to get users who have followed the logged in user since the last login
 * @return type json object
 **/ 
public function actionGetUserRecommendationsList() {
    try {
        $userRecommendationsList = "";
        $userid = Yii::app()->session['TinyUserCollectionObj']->UserId;
        $limit = 8; //limit to get the users
        $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userid);
        $userRecommendationsList = ServiceFactory::getSkiptaUserServiceInstance()->getUserRecommendationsList($userid, $limit);
        $userRecommendationsCount = count($userRecommendationsList);
        
        if ($userRecommendationsList != 'failure') {
            $this->renderPartial('userRecommendations_view', array('userRecommendationsList' => $userRecommendationsList, 'userRecommendationsCount' => $userRecommendationsCount, 'loggedUserId' => $userid));
        }
    } catch (Exception $ex) {
        Yii::log("UserController:actionGetUserRecommendationsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}

    public function actionProfileDetails(){
    try {
    $urlArray =  explode("/", Yii::app()->request->url);
     
//     return;
        
        
        $isUser=0;
        $userProfileId='';
        $profileModel = new ProfileDetailsForm();
        $this->layout='userLayout';
        $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];        
        $loggedInUserId=$this->tinyObject->UserId;
        $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];

//        if(isset($_REQUEST['data-id'])){
//            $userProfileId=$_REQUEST['data-id'];     
//        }else{
//            $userProfileId=$loggedInUserId;
//        }
       $userProfileId =  ServiceFactory::getSkiptaUserServiceInstance()->getUserIdbyName($urlArray[2]);

       
       if($loggedInUserId==$userProfileId){
          $isUser = 1;    
        }
        $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileDetails($userProfileId,$loggedInUserId); 

        
        $displayName=$this->tinyObject->DisplayName;
        $userProfileDetails=ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userProfileId);       
      //  $displayName=$userProfileDetails->DisplayName;
        $userBadges=ServiceFactory::getSkiptaUserServiceInstance()->getUserBadgesData($userProfileId);
        $userFollowingHashtags=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingHashtagsDataForProfile($userProfileId);
        $userFollowingGroups=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingGroupsDataForProfile($userProfileId,$loggedInUserId);
       // $userFollowingSubGroups=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingSubGroupsData($userProfileId,$loggedInUserId);        
        $userFollowingCategories=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingCurbsideCategoriesDataForProfile($userProfileId);
        $userFollowing=  ServiceFactory::getSkiptaUserServiceInstance()->getFollowersAndFollowing($userProfileId,'userFollowing');
        $userFollowers=  ServiceFactory::getSkiptaUserServiceInstance()->getFollowersAndFollowing($userProfileId,'userFollowers');        
        
      
        $userCVDetails=ServiceFactory::getSkiptaUserServiceInstance()->getUserCVDetails($userProfileId);
       
        $userInteractionsCount=  ServiceFactory::getSkiptaUserServiceInstance()->getUserInteractionsCount($userProfileId);
        $userDisplayCVDetails=array();
        $pDis=1;
        if(is_array($userCVDetails['publications']) && $pDis<=3){
            $pDis=$pDis+1;
            $userDisplayCVDetails['publications']=$userCVDetails['publications'][0];
            if($userCVDetails['publications']['Files'] != ""){
                $urlArr = explode("/",$userCVDetails['publications']['Files']);
                $userDisplayCVDetails['publications']['Files'] = $urlArr[3];
            }
        }
        if(is_array($userCVDetails['experience']) && $pDis<=2){
            $pDis=$pDis+1;
            $userDisplayCVDetails['experience']=$userCVDetails['experience'][0];
        }
        
        if(is_array($userCVDetails['interests']) && $pDis<=2){
            $pDis=$pDis+1;
            $userDisplayCVDetails['interests']=$userCVDetails['interests'];
        }
        
        if(is_array($userCVDetails['education']) && $pDis<=2 ){
            $pDis=$pDis+1;
            $userDisplayCVDetails['education']=$userCVDetails['education'][0];
        }

        if(is_array($userCVDetails['achievements']) && $pDis<=2 ){
            $pDis=$pDis+1;
            $userDisplayCVDetails['achievements']=$userCVDetails['achievements'];
        }

        $this->render('userProfileDetails',array('profileDetails'=>  $data,'profileModel'=>$profileModel,'IsUser'=>$isUser,'loginUserId'=>  $this->tinyObject->UserId,'userFollowingHashtags'=>$userFollowingHashtags , 'userFollowingGroups'=>$userFollowingGroups, 'userFollowingCategories'=>$userFollowingCategories, 'userFollowingSubGroups'=>$userFollowingSubGroups, 'networkAdmin'=>(int)Yii::app()->session['NetworkAdminUserId'],'userFollowers'=>$userFollowers,'userFollowing'=>$userFollowing,'displayName'=>$displayName,"userBadges"=>$userBadges,"userCVDetails"=>$userDisplayCVDetails,"userInteractionsCount"=>$userInteractionsCount));
    } catch (Exception $ex) {  

        Yii::log("UserController:actionProfileDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}


public function actionSaveProfileInfo() {
        try {
            $this->layout='userLayout';
            $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];
           $userId=$this->tinyObject->UserId;
            $obj = array();
            $profileModel = new ProfileDetailsForm();
            if (isset($_POST['ProfileDetailsForm'])) {
                $profileModel->attributes = $_POST['ProfileDetailsForm'];
                $errors = CActiveForm::validate($profileModel);

                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {                    
                     if(isset($profileModel['DisplayName'])){
                       $displayNameObj =  ServiceFactory::getSkiptaUserServiceInstance()->updateUserProfileDetails($userId,'DisplayName',$profileModel['DisplayName']);
                     }
                     if(isset($profileModel['Company'])){
                        $displayCompanyObj = ServiceFactory::getSkiptaUserServiceInstance()-> updateUserProfileDetails($userId,'Company',$profileModel['Company']);
                     }
                    $userObj = ServiceFactory::getSkiptaUserServiceInstance()->saveOrUpdateUserProfessionalInformation($userId,$profileModel);
                    if ($userObj != 'failure') {

                        $message = Yii::t('translation', 'ProfileUpdateSuccess');
                        //$successMessage=array('ForgotForm_email'=>$message);
                        $obj = array('status' => 'success', 'data' => $message, 'success' => '');
                    } else {
                        $message = Yii::t('translation', 'ProfileUpdateFail');
                        $errorMessage = array('ForgotForm_email' => $message);

                        $obj = array("status" => 'error', 'data' => '', "error" => $errorMessage);
                    }
                }

                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionSaveProfileInfo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


 public function actionEditProfileNameDetails() {
        try {
            $returnValue = 'failure';
            $type = '';
            $value = '';
            $UserId = '';
            if ($_REQUEST['type'] == 'FirstName') {
                $value = $_REQUEST['profileFirstName'];
                $UserId = $_REQUEST['UserId'];
                $type = 'FirstName';
            }
             if ($_REQUEST['type'] == 'LastName') {
                $value = $_REQUEST['profileLastName'];
                $UserId = $_REQUEST['UserId'];
                $type = 'LastName';
            }
            $returnValue = ServiceFactory::getSkiptaUserServiceInstance()->saveProfileNameDetails($UserId, $value, $type);

            $obj = array('status' => $returnValue,'type'=>$type);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("UserController:actionEditProfileNameDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     public function actionEditProfileAboutmeDetails() {
        try {
            $absolutePath='';
            $returnValue = 'failure';
            $type = '';
            $value = '';
            $UserId = '';
            $imageName='';
            if ($_REQUEST['type'] == 'AboutMe') {
                $value = $_REQUEST['profileAboutMe'];
                $UserId = $_REQUEST['UserId'];
                $type = 'AboutMe';
            }

            $returnValue = ServiceFactory::getSkiptaUserServiceInstance()->saveProfileDetailsUserCollection($UserId, $type, $value,$imageName, $absolutePath );

            $obj = array('status' => $returnValue,'type'=>$type);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
           Yii::log("UserController:actionEditProfileAboutmeDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    
    public function actionUploadProfileImage() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder = Yii::getPathOfAlias('webroot') . '/upload/'; // folder for uploaded files
            if (!file_exists($folder)) {
                mkdir ($folder, 0755,true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "png", "tiff","tif","TIF"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //$sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
            $sizeLimit= Yii::app()->params['UploadMaxFilSize'];
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            
            $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
            $fileName = $result['filename']; //GETTING FILE NAME
            $extension = $result['extension'];

            $ext = "profile";
            $extTemp = "profile/temp";
            $destnationfolder = $folder . $extTemp;
            
            if (!file_exists($destnationfolder)) {
               mkdir ($destnationfolder, 0755,true);
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
            $destinationTemp = $folder . $extTemp . "/" . $finalImage;            
            if ($extTemp != "") {
                if (file_exists($sourcepath)) {
                    if (copy($sourcepath, $destinationTemp)) {
                        unlink($sourcepath);
                    }
                }
            }
             $img = Yii::app()->simpleImage->load($destinationTemp);
             $width = $img->getWidth();
             if($width>=250){
                $img-> resizeToWidth(250);
             }
             $img->save($destination); 
             $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
        } catch (Exception $ex) {
            Yii::log("UserController:actionUploadProfileImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    
      
   public function actionsaveProfileImage() {
        try {
            $absolutePath = Yii::app()->params['ServerURL'];
            $returnValue = 'failure';
            $type = '';
            $value = '';
            $UserId = '';
            $imageName='';
            if ($_REQUEST['type'] == 'ProfilePicture') {
                $value = $_REQUEST['profileImage'];
                $UserId = $_REQUEST['UserId'];
                $type = 'ProfilePicture';
                $imageName = $_REQUEST['profileImageName'];
            }
            $returnValue = ServiceFactory::getSkiptaUserServiceInstance()->saveProfileDetailsUserCollection($UserId, $type,$value, $imageName, $absolutePath );
            Yii::app()->session['TinyUserCollectionObj']['profile250x250'] = $absolutePath.Yii::app()->params['IMAGEPATH250'].$returnValue;
            Yii::app()->session['TinyUserCollectionObj']['profile70x70'] = $absolutePath.Yii::app()->params['IMAGEPATH70'].$returnValue;
            Yii::app()->session['TinyUserCollectionObj']['profile45x45'] = $absolutePath.Yii::app()->params['IMAGEPATH45'].$returnValue;
            
            $obj = array('imageName' => $returnValue,'type'=>$type,'imagePath70'=>$absolutePath.Yii::app()->params['IMAGEPATH70'],'imagePath250'=>$absolutePath.Yii::app()->params['IMAGEPATH250']);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("UserController:actionsaveProfileImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
 * @author Praneeth
 * actionGetRecentGroupActivities is used to get group activity for which the user has visted the group since the last login
 * @return type json object
 * /
 */
  public function actionGetRecentGroupActivities()
{
    try
    {
        $groupActivityList="";
            $userid = Yii::app()->session['TinyUserCollectionObj']->UserId;
                        
            $groupActivityList = ServiceFactory::getSkiptaUserServiceInstance()->getUserGroupActivityForRightWidget($userid);
            $groupActivityListCount = count($groupActivityList);
            if($groupActivityList !='failure')
            {
                $this->renderPartial('recentGroupActivity_view',array('groupActivityList'=>$groupActivityList,'groupActivityListCount'=>$groupActivityListCount));   
            }

    } catch (Exception $ex) {
            Yii::log("UserController:actionGetRecentGroupActivities::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}

    /**
     * @author Karteek V
     * this method is used to get user settings...
     * @return type html
     */
    public function actionGetUserStreamSettings() {
        try {
            $userId = $_REQUEST['UserId'];
            $result = ServiceFactory::getSkiptaUserServiceInstance()->getUserSettings($userId);
            $this->renderPartial("userStreamSettings", array("data" => $result));
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetUserStreamSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserController->actionGetUserStreamSettings==".$ex->getMessage());
        }
    }

    /**
     * @author Karteek.V
     * This method is used to save the user settings
     * @return type JSON
     */
    public function actionSaveStreamSettings() {
        try {
            $userId = $_REQUEST['UserId'];
            $settingIds = $_REQUEST['settingIds'];
            $result = ServiceFactory::getSkiptaUserServiceInstance()->updateUserSettings($userId, $settingIds);
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("UserController:actionSaveStreamSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        echo CJSON::encode($obj);
    }
    
      
    /**
 * @author Praneeth
 * actionGetUserSignedUpEvents is used to get events for which the user is attending
 * @return type json object
 * /
 */
  public function actionGetUserSignedUpEvents()
{
    try
    {
            $userEventsActivityList="";
            $userid = Yii::app()->session['TinyUserCollectionObj']->UserId;
            $CurrentLoginDate = strtotime(date('Y-m-d', time()));            
            $language = Yii::app()->session['language'];
            $segmentId = (int)$this->tinyObject['SegmentId'];
             $groupsfollowing = ServiceFactory::getSkiptaPostServiceInstance()->getUserFollowingGroupsIDs((int)$userid);
             array_push($groupsfollowing,'');
             $userEventsActivityList = ServiceFactory::getSkiptaUserServiceInstance()->getUserAttendingEventsForRightWidget($userid,$CurrentLoginDate,$segmentId,$groupsfollowing);
           $EventsArray=array();
            if($userEventsActivityList !='failure'){
                foreach ($userEventsActivityList as $key => $value) {
                    $value->Language = isset($value->Language)?$value->Language:"en";
                    $title = "";
                    $firstUserDisplayName = "";
                    if($value->Language!=$language){
                        $translatedBean = new TranslatedDataBean();
                        $translatedBean->PostId = $value->PostId;
                        $translatedBean->PostType = $value->PostType;
                        $translatedBean->CategoryType = $value->CategoryType;
                        $translatedBean->Language = $language;
                        $translatedObj = ServiceFactory::getSkiptaTranslatedDataService()->isTranslated($translatedBean);
                        if(!(isset($translatedObj["Title"]))){
                            $fromLanguage = $value->Language; 
                            $toLanguage = $language;
                            $translatedBean->Title = CommonUtility::translateData($value->Title, $fromLanguage, $toLanguage);
                            ServiceFactory::getSkiptaTranslatedDataService()->saveTranslatedData($translatedBean);
                        }else{
                            $translatedBean->Title = $translatedObj["Title"];
                        }
                        $title = $translatedBean->Title;
                    }
                     $EventBean = new UserEventAttendBean();
                      $EventBean->EndDate = $value->EndDate;
                      $EventBean->StartDate =  $value->StartDate;
                      $EventBean->PostId = $value->PostId;
                      $EventBean->PostType =  $value->PostType;
                      $EventBean->CategoryType = $value->CategoryType;
                      if(is_array($value->EventAttendes) && sizeof($value->EventAttendes)>0){
                           if(in_array($userid, $value->EventAttendes)){
                                $EventBean->IsUserAttend=1;
                            }else{
                                 $EventBean->IsUserAttend=0;
                            }
                      }else{
                           $EventBean->IsUserAttend=0;
                      }
                     
                    //  $EventBean->IsUserAttend = $value->IsUserAttend;
                      $EventBean->Title = $title!=""?$title:$value->Title;
                      array_push($EventsArray, $EventBean);

                }
          }  
            
              $userEventsActivityListCount = count($EventsArray);
            
            if($userEventsActivityList !='failure'){
               if($userEventsActivityListCount >0)
                {
                    $this->renderPartial('userEventsAttending_view',array('userEventsActivityList'=>$EventsArray,'userEventsActivityListCount'=>$userEventsActivityListCount));   
                } 
            }
            

    } catch (Exception $ex) {
            Yii::log("UserController:actionGetUserSignedUpEvents::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}
/**
     * @author Sagar
     * This method is to get the Profile Intractions
     */
    public function actionGetprofileintractions(){
        try{
        if(isset($_GET['ProfileIntractionDisplayBean_page']))
        {            
           $pageSize=10;
           $userId = isset($_GET['UserId'])?$_GET['UserId']:Yii::app()->session['TinyUserCollectionObj']['UserId'];
            $provider = new EMongoDocumentDataProvider('ProfileIntractionDisplayBean',
                   
           array(

                'pagination' => array('pageSize' => $pageSize),
                'criteria' => array( 
                   'conditions'=>array(
                            'UserId'=>array('==' => (int)$userId),
                            'IsDeleted'=>array('notIn' => array(1,2)),
                            'IsAbused'=>array('notIn' => array(1,2)),
                               'IsBlockedWordExist'=>array('notIn' => array(1,2)),
                            'IsNotifiable'=>array('==' => 1),
                             'CategoryType'=>array('!=' => 7),
//                            'PostType'=>array('>' => 0),
                            // 'PostType'=>array('!=' => null),
                  
                            'PostType'=>array('notIn' => array(6,7,8,9,10,0,null,'null')),
                            
                       ),
                   'sort'=>array('CreatedOn'=>EMongoCriteria::SORT_DESC)
                 )
               ));
           if($provider->getTotalItemCount()==0){
               
               $stream=0;//No data
           }else if($_GET['ProfileIntractionDisplayBean_page'] <= ceil($provider->getTotalItemCount()/$pageSize)){               
              $dataArray= $provider->getData();
              $userId = Yii::app()->session['TinyUserCollectionObj']['UserId'];
               $stream = (CommonUtility::prepareProfileIntractionData($userId, $provider->getData()));
               if(sizeof($stream)>0){
                   $stream=(object)$stream;
               }else{
                 $stream=sizeof($stream);
               }
               
              // Yii::log("***************************".$stream, 'error','application');
            }else
            {
                $stream=-1;//No more data
            }            
            
           $this->renderPartial('profile_intractions_view',array('stream'=>$stream,'totalCount'=>$provider->getTotalItemCount()-8,'page'=>'profile'));
        }
        }catch(Exception $ex){
         Yii::log("UserController:actionGetprofileintractions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }
    
      /**
 * @author Praneeth
 * actionGetHelpDescription is to view the help description 
 * @return type json object
 * /
 */
      public function actionGetHelpDescription()
    {
        try {
            if (isset($_REQUEST['helpIconId'])) {
                $helpIconId = $_REQUEST['helpIconId'];
                $result = ServiceFactory::getSkiptaUserServiceInstance()->getHelpDescription($helpIconId);
                if(is_array($result) || is_object($result)){
                    
                    $name = Yii::t('help', 'name_'.$result['DivIdTitle']);
                    $result['Name'] = $name=='name_'.$result['DivIdTitle']?$result['Name']:$name;
                    $description = Yii::t('help', 'description_'.$result['DivIdTitle']);
                    $result['Description'] = $description=='description_'.$result['DivIdTitle']?$result['Description']:$description;
                }
                $obj = array('status' => 'success', 'data' => $result, 'error' => '');
                echo CJSON::encode($obj);
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetHelpDescription::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionCheckSession(){
        try{
         
       if (Yii::app()->user->isGuest) {
               $this->guest = "true";
               if (Yii::app()->request->isAjaxRequest) {
                   $result = array("code" => 440, "status" => "sessionTimeout");
               }
           } else {
            $result = array("code"=>200,"status"=>"");
       }
        echo $this->rendering($result);
        } catch (Exception $ex) {
            Yii::log("UserController:actionCheckSession::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   public function actionGetUserFollowers(){
       try {  
           $loginUserId =  Yii::app()->session['TinyUserCollectionObj']['UserId'];
       $userProfileId='';       
       if(isset($_REQUEST['userId'])){
        $userProfileId=$_REQUEST['userId'];    
       }
       
       $pageLength = 15;
        $page = $_REQUEST['page'];
        
        $pageSize = ($pageLength * $page);        
       $userFollowers=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowersForProfile($userProfileId,$loginUserId,$pageSize,$pageLength);
           if ($userFollowers != 'failure') {
                $this->renderPartial('userFollowersAndFollowing', array('userFollowers' => $userFollowers,'loginUserId'=>$loginUserId,'page'=>$page));
            }
       } catch (Exception $ex) {
           Yii::log("UserController:actionGetUserFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      } 
    public function actionGetUserFollowing() {
        try {
             $loginUserId =  Yii::app()->session['TinyUserCollectionObj']['UserId'];
            $userProfileId='';
           if(isset($_REQUEST['userId'])){
             $userProfileId=$_REQUEST['userId'];    
           }
        $pageLength = 15;
        
          $page = $_REQUEST['page'];
            $pageSize = ($pageLength * $page);
            $userFollowers = ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingForProfile($userProfileId,$loginUserId,$pageSize,$pageLength);
            if ($userFollowers != 'failure') {
                $this->renderPartial('userFollowersAndFollowing', array('userFollowers' => $userFollowers,'loginUserId'=>$loginUserId,'page'=>$page,'networkAdmin'=>(int)Yii::app()->session['NetworkAdminUserId']));
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetUserFollowing::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

        public function actionSaveSettings() {
        try {
           $object = User::model()->findAll();
            foreach($object as $rw){
              
                $userSettings = new UserNotificationSettingsCollection();
                $userSettings->UserId = $rw->UserId;
                $userSettings->Commented = 1;
                $userSettings->Loved = 0;
                $userSettings->ActivityFollowed = 0;
                $userSettings->Mentioned = 1;
                $userSettings->Invited = 1;
                $userSettings->UserFollowers = 0;
                $userSettings->NetworkId = $rw->NetworkId;
                UserNotificationSettingsCollection::model()->saveUserSettings($rw->UserId,(int)$rw->NetworkId);
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionSaveSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionSaveDisplayName() {
        try {
           $object = User::model()->findAll();
            foreach($object as $rw){
              
          
                 $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('UserId', '==', (int) $rw->UserId);            
            $mongoModifier->addModifier('DisplayName', 'set',  $rw->FirstName." ".$rw->LastName);
            UserCollection::model()->updateAll($mongoModifier, $mongoCriteria);
      
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionSaveDisplayName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionTest(){
        $this->render('test');
    }
    
    
    /**
 * @author Praneeth
 * actionGetNewFollowersList is used to get users who have followed the logged in user since the last login
 * @return type json object
 * /
 */
public function actionGetCurrentScheduleGameForRightsideWidget() {
        try {
            $currentScheduleGame = "";
            $userid = Yii::app()->session['TinyUserCollectionObj']->UserId;

            $currentScheduleGame = ServiceFactory::getSkiptaGameServiceInstance()->getCurrentScheduleGameForRightsideWidget($userid);            
            if ($currentScheduleGame != 'failure') {
                $currentScheduleGameCount = count($currentScheduleGame);
                $this->renderPartial('userCurrentScheduleGame_view', array('currentScheduleGame' => $currentScheduleGame,'currentScheduleGameCount'=>$currentScheduleGameCount,'loggedUserId'=>$userid));
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetCurrentScheduleGameForRightsideWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionManageNetworkAdmin() {
            try {
                 Yii::app()->session['PostAsNetwork'] = (int)$_REQUEST['isAdmin'];
                 $loginUserId = $this->tinyObject->UserId;
                 $postAsNetwork = Yii::app()->session['PostAsNetwork'];
                 if(Yii::app()->session['PostAsNetwork']==1){
                    CommonUtility::setUserSession(YII::app()->params['NetworkAdminEmail']);
                    $netwokAdminObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType( YII::app()->params['NetworkAdminEmail'], 'Email');
                    Yii::app()->session['NetworkAdminUserId'] = (int)$netwokAdminObj->UserId;
                    Yii::app()->session['NetworkAdminUserName'] = $netwokAdminObj->FirstName." ".$netwokAdminObj->LastName;
                    Yii::app()->session['Network_IsAdmin'] = Yii::app()->session['IsAdmin'];
                    Yii::app()->session['Network_CanViewAnalytics'] = $this->userPrivilegeObject->canViewAnalytics;
                    Yii::app()->session['IsAdmin'] = 1;
                    $this->userPrivilegeObject["canViewAnalytics"] = 1;
                    
                $segmentId = (int)$this->tinyObject['SegmentId'];
                //update segmentId in TinyUserCollection
                $result = ServiceFactory::getSkiptaUserServiceInstance()->updateSegmentByUserId($loginUserId, $segmentId);
                    
                    
                 }else{
                    CommonUtility::setUserSession(Yii::app()->session['LoginUserEmail']);
                    $this->userPrivilegeObject["canViewAnalytics"] = isset(Yii::app()->session['Network_CanViewAnalytics'])?Yii::app()->session['Network_CanViewAnalytics']:$this->userPrivilegeObject->canViewAnalytics;
                 }
                 $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];
                 $result = array("code"=>200,"status"=>"success","loginUserId"=>$this->tinyObject->UserId,"postAsNetwork"=>$postAsNetwork);
                 echo $this->rendering($result);
            } catch (Exception $ex) {
                Yii::log("UserController:actionManageNetworkAdmin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
    }
    
  public function actionUserDetail() {
        try {
            $migratedUserId = $_REQUEST["userGID"];
            $userDetails=ServiceFactory::getSkiptaUserServiceInstance()->getUserByType( $migratedUserId, 'MigratedUserId');
            if($userDetails!='failure'){
                $userId = $userDetails->UserId;
                $result = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
                $this->redirect("/profile/".$result->uniqueHandle);
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in UserController->actionUserDetail==".$ex->getMessage());
            Yii::log("UserController:actionUserDetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
    
      
      public function actionGetBadgesNotShownToUser() {
        try {
            $badgeCollection = CommonUtility::getBadgesNotShownToUser(Yii::app()->session['UserStaticData']->UserId, 1);

            if (count($badgeCollection) > 0) {
                $badgeInfo = ServiceFactory::getSkiptaUserServiceInstance()->getBadgeInfoById($badgeCollection->BadgeId);
                $this->renderPartial('badging', array('badgingInfo' => $badgeInfo, 'badgeCollectionInfo' => $badgeCollection));
            } else {
                $obj = array("status" => "failure", "data" => "", "error" => "");
                echo $this->rendering(0);
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetBadgesNotShownToUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUpdateBadgeShownToUser() {
        try {
            if (isset($_POST['badgeCollectionId'])) {
                $result = array();
                $result = ServiceFactory::getSkiptaUserServiceInstance()->updateBadgeShownToUser($_POST['badgeCollectionId']);
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionUpdateBadgeShownToUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


    
    
 /**
 * @author Haribabu
 * This  method is used to render the referral form
 */   
  function actionReferral(){
    
     try {

          $this->renderPartial('referral');
      } catch (Exception $ex) {
         Yii::log("UserController:actionReferral::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
}
 /**
 * @author Haribabu
 * This  method is used to send invitation to refered users
 */
public function actionSendreferralEmail(){
    
     try {
         
         $emailsArray = array();
            $message = "";
            $sucmsg = "";
            $errmsg = "";
            $siteurl = YII::app()->getBaseUrl('true');
            $result = "fail";
            $em="";
            $failmailsCount=0;
            $sucmailsCount=0;
            if (isset($_REQUEST["Emails"])) {
                $emailsArray = explode(',', $_REQUEST["Emails"]);
            }
            if (isset($_REQUEST["Message"])) {
                $message = $_REQUEST["Message"];
            }

            $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
           
            //save data in Referral link table

            $linkId = ServiceFactory::getSkiptaUserServiceInstance()->SaveReferralLink($userId, $message);

            //save data in link_user table
            foreach ($emailsArray as $key => $email) {

                //Form link
                $eData = $userId . "_" . $linkId . "_" . $email;
                $encrypteddata = CommonUtility::encrypt($eData);
                $link = $siteurl . '/site/invitation?q=' . $encrypteddata;
                //send email
                $to = trim($email);
                if(Yii::app()->session['PostAsNetwork']==1){
                    $displayname= Yii::app()->params['NetworkName'];
                }else{
                     $displayname=Yii::app()->session['TinyUserCollectionObj']->DisplayName;
                }
//                $validemail=$this->validate($to);
//                if($validemail){
                  
                $subject = $displayname . " has referred you to join " . Yii::app()->params['NetworkName'];
                $employerName = "Skipta Admin";
                //$employerEmail = "info@skipta.com"; 
                $messageview = "UserReferralMail";
                $params = array('myMail' => Yii::app()->session['TinyUserCollectionObj']->DisplayName, 'message' => $message, 'link' => $link,"userName"=>$displayname);
                $sendMailToUser = new CommonUtility;
                $mailSentStatus = $sendMailToUser->actionSendmail($messageview, $params, $subject, $to);
               
                if ($mailSentStatus) {
                    $sucmailsCount=$sucmailsCount+1;
                    $ReferralLinkId = ServiceFactory::getSkiptaUserServiceInstance()->SaveReferralLinkDetails($linkId, $userId, $email);

                    if ($ReferralLinkId == 'success') {
                        $result = "success";
                        if ($sucmailsCount > 1) {
                            $usersmessage = " colleagues! ";
                        } else {
                            $usersmessage = " colleague! ";
                        }
                        // $sucmsg = "Invitation has been send to " . count($emailsArray) . $usersmessage . "  successfully";
                        $sucmsg = "Your referral invite has been successfully sent to your  " . $usersmessage;
                    } else {
                        $errmsg = "Invitation send fail";
                        $result = "fail";
                    }
                }else{
                     $errmsg = "Invitation send fail";
                     $result = "fail";
                     $failmailsCount=$failmailsCount+1;
                }
            
//            }else{
//                 $failmailsCount=$failmailsCount+1;
//            }
            
            if($failmailsCount>0){ 
             if($failmailsCount>1){
                    $msg=" are invalid emails";
                    if($emailsArray=($key+1)){
                         $em=$em.$email;
                    }else{
                        $em=$em.$email.',';
                    }
                }else{
                      $msg=" is invalid email";
                      $em=$email;
                }
                $errmsg = $em.$msg;
                $result = "fail";
            }
            
            }
            
            $results = array("status" => $result, "sucmsg" => $sucmsg, 'errmsg' => $errmsg);
            echo $this->rendering($results);
        } catch (Exception $ex) {
            error_log("Exception Occurred in UserController->actionSendreferralEmail==".$ex->getMessage());
            Yii::log("UserController:actionSendreferralEmail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
  }

 
 /**
 * @author Haribabu
 * This  method is used to render the referral form
 */   
  function actionPublications(){
    
     try {
            $urlArray = explode("/", Yii::app()->request->url);
//     return;
            $CvPriorityArray=array();
            $isUser = 0;
            $userProfileId = '';
            $userProfileId = ServiceFactory::getSkiptaUserServiceInstance()->getUserIdbyName($urlArray[2]);
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            $loggedInUserId = $this->tinyObject->UserId;
            if ($loggedInUserId == $userProfileId) {
                $isUser = 1;
            }
            $ExperiencePriority = "";
            $EducationPriority = "";
            $InterestPriority = "";
            $AchievementPriority = "";
            $PublicationPriority = "";
            $profileModel = new UserCVForm();
            $data = array();
            $UserRegistrationForm = new UserRegistrationForm;
            $UserPublicationsForm = new UserPublicationsForm;
            $ExperienceId = 1;
            $EducationId = 0;
            $InterestId = 1;
            $AchievementId = 1;
            $education = ServiceFactory::getSkiptaUserServiceInstance()->getEducations();
            $interests = ServiceFactory::getSkiptaUserServiceInstance()->getInterests();
            $experience = ServiceFactory::getSkiptaUserServiceInstance()->getExperience();
            $achievements = ServiceFactory::getSkiptaUserServiceInstance()->getAchievements();
            $data['education'] = $education;
            $data['interests'] = $interests;
            $data['experience'] = $experience;
            $data['achievements'] = $achievements;
            $result = ServiceFactory::getSkiptaUserServiceInstance()->getUserCVDetails($loggedInUserId);
            $userDisplayCVDetails = $this->checkForUserCV($result);
            $UserId = Yii::app()->session['TinyUserCollectionObj']->UserId;
            $UserCVEducationDetails = ServiceFactory::getSkiptaUserServiceInstance()->getUserCVDetails($UserId);
// echo sizeof($UserCVEducationDetails['education']);exit;

            $profile = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileDetails($userProfileId, $loggedInUserId);
            if ((sizeof($UserCVEducationDetails['education']) > 0 && $UserCVEducationDetails['education'] != "failure")|| (sizeof($UserCVEducationDetails['interests']) > 0 && $UserCVEducationDetails['interests'] != "failure")) {
                $educationIds = array();
                if (isset($UserCVEducationDetails['education']) && is_array($UserCVEducationDetails['education'])) {
                    foreach ($UserCVEducationDetails['education'] as $key => $value) {
                        $educationIds[$key] = $value['EducationId'];
                        $EducationPriority=$value['Education_Priority'];
                    }
                }
                $achievementIds = array();
                if (isset($UserCVEducationDetails['achievements']) && is_array($UserCVEducationDetails['achievements'])) {
                    foreach ($UserCVEducationDetails['achievements'] as $key => $value) {
                        $achievementIds[$key] = $value['AchievementId'];
                        $AchievementPriority=$value['Achievement_Priority'];
                    }
                }
                $experienceIds = array();
                if (isset($UserCVEducationDetails['experience']) && is_array($UserCVEducationDetails['experience'])) {
                    foreach ($UserCVEducationDetails['experience'] as $key => $value) {
                        $experienceIds[$key] = $value['ExperienceId'];
                        $ExperiencePriority=$value['Experience_Priority'];
                    }
                }
                $interestIds = array();
                if (isset($UserCVEducationDetails['interests']) && is_array($UserCVEducationDetails['interests'])) {
                    foreach ($UserCVEducationDetails['interests'] as $key => $value) {
                        $interestIds[$key] = $value['InterestId'];
                        $InterestPriority=$value['Interest_Priority'];
                    }
                }
                $publicatioIds = array();
                if (isset($UserCVEducationDetails['publications']) && is_array($UserCVEducationDetails['publications'])) {
                    foreach ($UserCVEducationDetails['publications'] as $key => $value) {
                        $publicationIds[$key] = $value['Id'];
                        $PublicationPriority=$value['Publication_Priority'];
                    }
                }
                $dropdownDetails = ServiceFactory::getSkiptaUserServiceInstance()->getUserCVDropdownDetails($educationIds, $interestIds, $experienceIds, $achievementIds);

                $ExperienceId = 0;
                $EducationId = 0;
                $InterestId = 0;
                $AchievementId = 0;
                $data['education'] = is_array($dropdownDetails['education']) ? $dropdownDetails['education'] : array();
                $data['interests'] = is_array($dropdownDetails['interests']) ? $dropdownDetails['interests'] : array();
                $data['experience'] = is_array($dropdownDetails['experience']) ? $dropdownDetails['experience'] : array();
                $data['achievements'] = is_array($dropdownDetails['achievements']) ? $dropdownDetails['achievements'] : array();
                $CvIdDetails['education'] = $educationIds;
                $CvIdDetails['interests'] = $interestIds;
                $CvIdDetails['experience'] = $experienceIds;
                $CvIdDetails['achievements'] = $achievementIds;
                $CvIdDetails['publications'] = $publicationIds;
                $priorityArray = array();
                $EducationPriority = ($EducationPriority == null) ? '0' : $EducationPriority;
                $InterestPriority = ($InterestPriority == null) ? '2' : $InterestPriority;
                $ExperiencePriority = ($ExperiencePriority == null) ? '1' : $ExperiencePriority;
                $AchievementPriority = ($AchievementPriority == null) ? '4' : $AchievementPriority;
                $PublicationPriority = ($PublicationPriority == null) ? '3' : $PublicationPriority;
                $priorityArray[$AchievementPriority] = 'e_achievementsdiv';
                $priorityArray[$InterestPriority] = 'e_interestsdiv';
                $priorityArray[$EducationPriority] = 'e_educationdiv';
                $priorityArray[$ExperiencePriority] = 'e_experiencediv';
                $priorityArray[$PublicationPriority] = 'e_publicationsdiv';
               
                ksort($priorityArray);
                $CvPriorityArray['education'] = $EducationPriority;
                $CvPriorityArray['interests'] = $InterestPriority;
                $CvPriorityArray['experience'] = $ExperiencePriority;
                $CvPriorityArray['achievements'] = $AchievementPriority;
                $CvPriorityArray['publications'] = $PublicationPriority;
                // print_r($CvIdDetails['publications']);exit;
                $this->render('editPublications', array('UserCVForm' => $profileModel, 'UserPublicationsform' => $UserPublicationsForm, 'ExperienceId' => $ExperienceId, 'EducationId' => $EducationId, 'InterestId' => $InterestId, 'AchievementId' => $AchievementId, 'data' => $data, 'UsercvDetails' => $UserCVEducationDetails, 'CvIdDetails' => $CvIdDetails, "profileDetails" => $profile, "IsUser" => $isUser, "userCVDetails" => $userDisplayCVDetails, "OrderArray" => $priorityArray,'CvPriorityArray'=>$CvPriorityArray));
            } else {

                $this->render('publications', array('UserCVForm' => $profileModel, 'UserPublicationsform' => $UserPublicationsForm, 'ExperienceId' => $ExperienceId, 'EducationId' => $EducationId, 'InterestId' => $InterestId, 'AchievementId' => $AchievementId, 'data' => $data, "profileDetails" => $profile, "IsUser" => $isUser, "userCVDetails" => $userDisplayCVDetails,));
            }
        } catch (Exception $ex) {
         Yii::log("UserController:actionPublications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }

  }
 /**
 * @author Haribabu
 * This  method is used to send invitation to refered users
 */
public function actionPublicationsSave(){
    
    try {
          
            $CVForm = new UserCVForm;
            if (isset($_POST['UserCVForm'])) {
                $CVForm_errors = "[]";
                $CVForm->attributes = $_POST['UserCVForm'];
//                 foreach ($CVForm->attributes as $key => $value) {
//                           if($key=="UserAchievements")
//                           {
//                           }
//                        }
                $CVForm_errors = CActiveForm::validate($CVForm);
                if ($CVForm_errors != "[]") {
                   
                    $obj = array('status' => 'fail', 'data' => '', 'error' => $CVForm_errors);
                } else {
                    
                    
                    $CVPostData = $_POST['UserCVForm'];
                          
                    $UserId = Yii::app()->session['TinyUserCollectionObj']->UserId;
                    $UserCVEducationDetails = ServiceFactory::getSkiptaUserServiceInstance()->getUserCVDetails($UserId);
                    if((sizeof( $_POST['UserCVForm']['Interests'])>0 &&  $_POST['UserCVForm']['Interests']!='failure')||(sizeof($UserCVEducationDetails['education'])>0 && $UserCVEducationDetails['education']!='failure')){
                        $CV = ServiceFactory::getSkiptaUserServiceInstance()->updateUserCV($CVForm->attributes, $UserId,$CVForm->RecentupdateSection);
                        
                        if($CV){
                           
                            $message= Yii::t('translation', 'User_Cv_Updatemessage');
                            
                        }
                        
                    }else{
                        $CV = ServiceFactory::getSkiptaUserServiceInstance()->saveUserCV($CVForm->attributes, $UserId,$CVForm->RecentupdateSection);
                        if($CV){
                           
                            $message=  Yii::t('translation', 'User_Cv_Savemessage');
                        }
                        
                    }
                   
                    $obj = array('status' => 'success','message' => $message, 'data' => '', 'error' => $CVForm_errors);
                }
            } 

            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            error_log("Exception Occurred in UserController->actionPublicationsSave==".$ex->getMessage());
            Yii::log("UserController:actionPublicationsSave::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    } 
  
public function actionAddNewPublication(){
    try{
    $Id = $_REQUEST['Id'];
     $profileModel = new UserCVForm();
    
      // $this->renderPartial("newPublication", array('PublicationId' => $Id,'UserCVForm'=>$profileModel,'form'=>$form));
       $this->renderPartial("newPublication", array('PublicationId' => $Id,'UserCVForm'=>$profileModel));
       } catch (Exception $ex) {
            Yii::log("UserController:actionAddNewPublication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}

public function actionAddNewEducation(){
    try{
        $Id = $_REQUEST['Id'];
        $Name = $_REQUEST['name'];
        $EducationId = $_REQUEST['educationId'];
        $this->renderPartial("education", array('EducationId' => $Id, 'EducationName' => $Name,'Id' => $EducationId));
        } catch (Exception $ex) {
            Yii::log("UserController:actionAddNewEducation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}
public function actionUpdateDropdown() {
   try{
        $Id = $_REQUEST['Id'];
        $Category = $_REQUEST['category'];
      //  ServiceFactory::getSkiptaUserServiceInstance()->updateUserCVStatusBySection($Category,$Id,$this->tinyObject->UserId);
        
        
        $dropdownList = ServiceFactory::getSkiptaUserServiceInstance()->getDropdownsListForCVEdit($Id,$Category);
        if($Category=="Education"){
                $this->renderPartial("dropdown", array('DropdownList' => $dropdownList));
            }else if($Category=="Experience"){
                  $this->renderPartial("experience_dropdown", array('DropdownList' => $dropdownList));
            }else if($Category=="Interests"){
                  $this->renderPartial("interests_dropdown", array('DropdownList' => $dropdownList));
            }else if($Category=="Achievements"){
                  $this->renderPartial("achievements_dropdown", array('DropdownList' => $dropdownList));
            }
       } catch (Exception $ex) {
            Yii::log("UserController:actionUpdateDropdown::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
}

public function actionAddNewExperience(){
    try{
        $Id = $_REQUEST['Id'];
        $Name = $_REQUEST['name'];
        $this->renderPartial("experience", array('ExperienceId' => $Id, 'Experience' => $Name));
        } catch (Exception $ex) {
            Yii::log("UserController:actionAddNewExperience::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}
public function actionAddNewInterest(){
    try{
        $Id = $_REQUEST['Id'];
        $Name = $_REQUEST['name'];
        
        $this->renderPartial("interests", array('InterestId' => $Id, 'Intersts' => $Name));
        } catch (Exception $ex) {
            Yii::log("UserController:actionAddNewInterest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}
public function actionAddNewAchievement(){
     try{
        $Id = $_REQUEST['Id'];
        $Name = $_REQUEST['name'];
        
        $this->renderPartial("achievements", array('AchievementId' => $Id, 'Achievement' => $Name));
        } catch (Exception $ex) {
            Yii::log("UserController:actionAddNewAchievement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}

    public function actionUploadPublicationImage() {
        try {
            
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            //  $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'].'/upload/Cv/Profile/';
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "exe", "mov", "mp4", "mp3", "txt", "doc", "docx", "pptx", "xlsx", "pdf", "ppt", "xls", "3gp", "php", "ini", "avi", "rar", "zip", "png", "tiff"); //array("jpg","jpeg","gif","exe","mov" and etc...
          //  $sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
             $sizeLimit= Yii::app()->params['UploadMaxFilSize'];          

            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            
            if(isset($result['filename'])){
            $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
            $fileName=$result['filename'];//GETTING FILE NAME
             $result["filepath"]= Yii::app()->getBaseUrl(true).'/temp/'.$fileName;
             $result["fileremovedpath"]= $folder.$fileName; 
            }else{
              $result['success']=false;  
            }
            $result['extension']=  strtolower($result['extension']);
            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
        } catch (Exception $ex) {
            Yii::log("UserController:actionUploadPublicationImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


 public function actionProfileInteractions(){
      try{
          $urlArray =  explode("/", Yii::app()->request->url);
          $profileModel = new ProfileDetailsForm();
          $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];        
          $loggedInUserId=$this->tinyObject->UserId;
          $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
          $userProfileId =  ServiceFactory::getSkiptaUserServiceInstance()->getUserIdbyName($urlArray[2]);
//
       if($loggedInUserId==$userProfileId){
          $isUser = 1;    
        }
         $result=  ServiceFactory::getSkiptaUserServiceInstance()->getUserCVDetails( $userProfileId);
        $userDisplayCVDetails=  $this->checkForUserCV($result);
        $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileDetails($userProfileId,$loggedInUserId); 
        $userFollowingHashtags=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingHashtagsData($userProfileId);
        $userFollowingGroups=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingGroupsData($userProfileId,$loggedInUserId);
        $userFollowingSubGroups=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingSubGroupsData($userProfileId,$loggedInUserId);        
        $userFollowingCategories=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingCurbsideCategoriesData($userProfileId);
        $this->render('profileInteractions',array('profileDetails'=>  $data,'profileModel'=>$profileModel,'IsUser'=>$isUser,'loginUserId'=>  $this->tinyObject->UserId,'userFollowingHashtags'=>$userFollowingHashtags , 'userFollowingGroups'=>$userFollowingGroups, 'userFollowingCategories'=>$userFollowingCategories, 'userFollowingSubGroups'=>$userFollowingSubGroups,"userCVDetails"=>$userDisplayCVDetails, 'networkAdmin'=>(int)Yii::app()->session['NetworkAdminUserId'])); 
      } catch (Exception $ex) {
          Yii::log("UserController:actionProfileInteractions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in UserController->actionProfileInteractions==".$ex->getMessage());
      }
  }
  
  public function actionuserCV()
  {
      try
      {
          
           $urlArray =  explode("/", Yii::app()->request->url);
          $profileModel = new ProfileDetailsForm();
          $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];        
          $loggedInUserId=$this->tinyObject->UserId;
          $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
     
          $userProfileId =  ServiceFactory::getSkiptaUserServiceInstance()->getUserIdbyName($urlArray[2]);
       if($loggedInUserId==$userProfileId){
          $isUser = 1;    
        }
        
        $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileDetails($userProfileId,$loggedInUserId); 
        $userFollowingHashtags=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingHashtagsData($userProfileId);
        $userFollowingGroups=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingGroupsData($userProfileId,$loggedInUserId);
        $userFollowingSubGroups=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingSubGroupsData($userProfileId,$loggedInUserId);        
        $userFollowingCategories=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingCurbsideCategoriesData($userProfileId);
        $displayName="CV";
        $ExperiencePriority = "";
            $EducationPriority = "";
            $InterestPriority = "";
            $AchievementPriority = "";
            $PublicationPriority = "";
            $result = ServiceFactory::getSkiptaUserServiceInstance()->getUserCVDetails($userProfileId);
            if (isset($result['education']) && is_array($result['education'])) {
                foreach ($result['education'] as $key => $value) {
                    $EducationPriority = $value['Education_Priority'];
                }
            }
            if (isset($result['achievements']) && is_array($result['achievements'])) {
                foreach ($result['achievements'] as $key => $value) {

                    $AchievementPriority = $value['Achievement_Priority'];
                }
            }
            $experienceIds = array();
            if (isset($result['experience']) && is_array($result['experience'])) {
                foreach ($result['experience'] as $key => $value) {

                    $ExperiencePriority = $value['Experience_Priority'];
                }
            }
            $interestIds = array();
            if (isset($result['interests']) && is_array($result['interests'])) {
                foreach ($result['interests'] as $key => $value) {

                    $InterestPriority = $value['Interest_Priority'];
                }
            }
            $publicatioIds = array();
            if (isset($result['publications']) && is_array($result['publications'])) {
                foreach ($result['publications'] as $key => $value) {

                    $PublicationPriority = $value['Publication_Priority'];
                }
            }
            $priorityArray = array();
            $EducationPriority = ($EducationPriority == null) ? '0' : $EducationPriority;
            $InterestPriority = ($InterestPriority == null) ? '2' : $InterestPriority;
            $ExperiencePriority = ($ExperiencePriority == null) ? '1' : $ExperiencePriority;
            $AchievementPriority = ($AchievementPriority == null) ? '4' : $AchievementPriority;
            $PublicationPriority = ($PublicationPriority == null) ? '3' : $PublicationPriority;
            $priorityArray[$AchievementPriority] = 'e_achievementsdiv';
            $priorityArray[$InterestPriority] = 'e_interestsdiv';
            $priorityArray[$EducationPriority] = 'e_educationdiv';
            $priorityArray[$ExperiencePriority] = 'e_experiencediv';
            $priorityArray[$PublicationPriority] = 'e_publicationsdiv';

            ksort($priorityArray);
            $userDisplayCVDetails = $this->checkForUserCV($result);
            $this->render('userCV',array("result"=>$result,'profileDetails'=>  $data,'profileModel'=>$profileModel,'IsUser'=>$isUser,'loginUserId'=>  $this->tinyObject->UserId,'userFollowingHashtags'=>$userFollowingHashtags , 'userFollowingGroups'=>$userFollowingGroups, 'userFollowingCategories'=>$userFollowingCategories, 'userFollowingSubGroups'=>$userFollowingSubGroups, 'networkAdmin'=>(int)Yii::app()->session['NetworkAdminUserId'],'displayName'=>$displayName,"userCVDetails"=>$userDisplayCVDetails,'OrderArray'=>$priorityArray));
      }
      catch(Exception $ex)
      {
          Yii::log("UserController:actionuserCV::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in UserController->actionuserCV==".$ex->getMessage());
          
      }
  }
  
  public  function checkForUserCV($userCVDetails)  {
      try{
       $userDisplayCVDetails=array();
        $pDis=1;
        if(is_array($userCVDetails['publications']) && $pDis<=2){
            $pDis=$pDis++;
            $userDisplayCVDetails['publications']=$userCVDetails['publications'][0];
            if($userCVDetails['publications']['Files'] != ""){
                $urlArr = explode("/",$userCVDetails['publications']['Files']);
                $userDisplayCVDetails['publications']['Files'] = $urlArr[3];
            }
        }
        if(is_array($userCVDetails['experience']) && $pDis<=2){
            $pDis=$pDis++;
            $userDisplayCVDetails['experience']=$userCVDetails['experience'][0];
        }
        if(is_array($userCVDetails['interests']) && $pDis<=2){
            $pDis=$pDis++;
            $userDisplayCVDetails['interests']=$userCVDetails['interests'][0];
        }
        if(is_array($userCVDetails['education'])){
            $pDis=$pDis++;
            $userDisplayCVDetails['education']=$userCVDetails['education'][0];
        }
        
        return $userDisplayCVDetails;
        } catch (Exception $ex) {
            Yii::log("UserController:checkForUserCV::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
  }

  
 public function actionupdatePersonalInformationByType(){
     try {
         if(isset($_REQUEST['value'])){
             $value=$_REQUEST['value'];
             $type=$_REQUEST['field'];             
             $userId = $this->tinyObject['UserId'];
             if($type=='Company' || $type=='DisplayName'){                 
                 $result=ServiceFactory::getSkiptaUserServiceInstance()->updateUserProfileDetails($userId, $type, $value);
                 if($type=='DisplayName'){                     
                                $this->tinyObject['DisplayName']=$value;
                }
             }else{
               $result=ServiceFactory::getSkiptaUserServiceInstance()->updatePersonalInformationByType($value,$type,$userId);     
             }             
//            if($result=='success'){
//                if($type=='DisplayName'){
//                unset($this->tinyObject->DisplayName);
//                $this->tinyObject->DisplayName=$value;
//                }
//            }
         
             $results = array("status" => $result,'type'=>$type,'value'=>$value);
            echo $this->rendering($results);
             
         }
     } catch (Exception $ex) {
         Yii::log("UserController:actionupdatePersonalInformationByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in UserController->actionupdatePersonalInformationByType==".$ex->getMessage());
     }
  } 
  
  public function actionRemoveSectionFromCV() {
  try{
       $Id = $_REQUEST['Id'];
        $Category = $_REQUEST['category'];
          $orgId = $_REQUEST['orgId'];

       ServiceFactory::getSkiptaUserServiceInstance()->updateUserCVStatusBySection($Category,$Id,$this->tinyObject->UserId,$orgId);
      
  } catch (Exception $ex) {
Yii::log("UserController:actionRemoveSectionFromCV::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
  }
       
         
  }
  /**
   * @developer : reddy #1500
   * change country or segment 
   */
  
  
  public function actionSettings(){
        $error = "";
        $message = "";
try{
        $UserSettingsForm = new UserSettingsForm;
        $userid = Yii::app()->session['TinyUserCollectionObj']->UserId;
        $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userid);
        $UserSettingsForm->firstName=$data["FirstName"];
        $UserSettingsForm->lastName=$data["LastName"];
        $UserSettingsForm->country=$data["Country"];
        $UserSettingsForm->state=$data["State"];
        $UserSettingsForm->city=$data["City"];
        $UserSettingsForm->zip=$data["Zip"];
        $UserSettingsForm->email=$data["Email"];
        $UserSettingsForm->companyName=$data["Company"];
        $UserSettingsForm->NPINumber=$data["NPINumber"];
        $UserSettingsForm->HavingNPINumber=$data["HavingNPINumber"];
        $UserSettingsForm->StateLicenseNumber=$data["LicensedNumber"];
        if(isset($data["IsSpecialist"]) && $data["IsSpecialist"] == 0){
            $UserSettingsForm->IsSpecialist = 2; 
        }else{
           $UserSettingsForm->IsSpecialist=$data["IsSpecialist"]; 
        }
         if($data["IsStudentOrResident"] == 0){
            $UserSettingsForm->IsStudentOrResident = 2; 
        }else{
           $UserSettingsForm->IsStudentOrResident=$data["IsStudentOrResident"]; 
        }
       
        $UserSettingsForm->StudentOrResidentEmail=$data["StudentOrResidentEmail"];
         $UserSettingsForm->aboutMe=$data["AboutMe"];
        $countryId=$data["Country"];
         $preference = new PreferenceForm();

          $countries = ServiceFactory::getSkiptaUserServiceInstance()->GetCountries();
           $preference->CountryId=$this->tinyObject['CountryId'];
           $userId = (int)$this->tinyObject['UserId'];
           $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType($userId,"UserId");
           $CountryRequest = $userObj->CountryRequest;
           $message = "";
           if($CountryRequest==1){
                $countryObj= Countries::model()->getCountryById($userObj->Country);
                $OldCountryName = $countryObj->Name;
                $changedCountryObj= Countries::model()->getCountryById($userObj->ChangedCountry);
                $NewCountryName = $changedCountryObj->Name;
                $message = "Your country change request from <strong>".$OldCountryName."</strong> to <strong>".$NewCountryName."</strong> is waiting for approval";
           }else if($CountryRequest==2){
                $countryObj= Countries::model()->getCountryById($userObj->Country);
                $OldCountryName = $countryObj->Name;
                $changedCountryObj= Countries::model()->getCountryById($userObj->ChangedCountry);
                $NewCountryName = $changedCountryObj->Name;
                $message = "Your country change request from <strong>".$OldCountryName."</strong> to <strong>".$NewCountryName."</strong> is rejected";
           }
         //  $this->render('preference', array('model' => $preference,'countries'=>$countries,'countryRequest'=>$CountryRequest, "message"=>$message));
        
        
        
        try {

        } catch (Exception $ex) {
            Yii::log("UserController:actionSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     $changePasswordForm = new ChangePasswordForm;
     $customForm=$this->setCustomFields($userid);
     $customObject = ServiceFactory::getSkiptaUserServiceInstance()->getCustomFieldsByUserId($userid); 
     $subSpe=ServiceFactory::getSkiptaUserServiceInstance()->getCustomSubSpeciality();
     $this->render('settings',array('UserRegistrationForm'=> $UserSettingsForm,'ChangePasswordForm'=> $changePasswordForm,'countryRequest'=>$CountryRequest, "message"=>$message,'CustomForm'=>$customForm,'CustomObject'=>$customObject,'countryId'=>$countryId,"stateId"=>$data["State"],'subSpe'=>$subSpe));
 
    // $this->render('settings',array('UserRegistrationForm'=> $UserSettingsForm,'ChangePasswordForm'=> $changePasswordForm,'CustomForm'=>$customForm,'CustomObject'=>$customObject,$countryId=>$countryId,"stateId"=>$data["State"],'subSpe'=>$subSpe));       
  }  catch (Exception $ex){
       Yii::log("UserController:actionSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
  }

  }
  
  public function setCustomFields($userid){
      try{
    $customForm = new CustomForm;
     $result = ServiceFactory::getSkiptaUserServiceInstance()->getCustomFormByUserId($userid); 
     if($result!="failure"){
         $customForm=$result;
     }
     return $customForm;
     } catch (Exception $ex) {
            Yii::log("UserController:setCustomFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
  }
  
  public function actionUpdateUserSettings(){
       $error = "";
        $message = "";
        $message1="";
        try {
            if (isset($_POST['UserSettingsForm'])) {
                $UserSettingsForm ="[]";
                $UserSettingsForm= new UserSettingsForm;
                $errorUserSettingsForm = CActiveForm::validate($UserSettingsForm); 
                if ($errorUserSettingsForm != "[]") {
                    $obj = array('status' => 'fail', 'data' => '', 'error' => $errorUserSettingsForm);
                } else {
                    $userid = Yii::app()->session['TinyUserCollectionObj']->UserId;
                    $oldUserObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userid);
                   $UserSettingsForm['email']=trim($UserSettingsForm['email']); 
                   $email = $UserSettingsForm['email'];
                    $userexist =array();
                    if(trim($oldUserObj['Email'])!=trim($UserSettingsForm['email'])){

                        $userexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($UserSettingsForm['email']);  
                    }

                    if (count($userexist) > 0) {
                        if(isset($userexist->FromNetwork) && isset($userexist->AccessToken) && !empty($userexist->FromNetwork) && !empty($userexist->AccessToken) && Yii::app()->params['IsDSN']=='ON' )
                            {
                               $message = Yii::t('translation', 'User_Already_Exist_Network');
                               $message= str_replace("network",$userexist->FromNetwork." Network",$message);
                            }
                         else 
                             $message = Yii::t('translation', 'User_Already_Exist');
                        // $message ="User already exist with this Email Please  try with another  Email Address";
                        $obj = array('status' => 'fail', 'data' => $message, 'error' => $UserSettingsForm);
                    } else {
                        $Save_userInUserCollection = ServiceFactory::getSkiptaUserServiceInstance()->UpdateUserCollection($UserSettingsForm,$oldUserObj);       
                        if ($Save_userInUserCollection != 'error') {
                            if ($oldUserObj['Country'] != $UserSettingsForm['country']) {
                                $prefenceform = new PreferenceForm();
                                $prefenceform->CountryId=$UserSettingsForm['country'];
                                $prefenceform->UserId=$userid;
                                $status = ServiceFactory::getSkiptaUserServiceInstance()->requestForChangeCountry($prefenceform->attributes, $this->tinyObject->UserId,$UserSettingsForm['state'],$UserSettingsForm['city'],$UserSettingsForm['zip']);
                                if ($status == "success") {
                               $message1 = Yii::t('translation', 'User_Country_Change_Sucess');
                                   }
                            }

                            $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userid);
                            $oldUserObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userid);
                            Yii::app()->session['TinyUserCollectionObj'] = $tinyUserCollectionObj;
                            $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType($UserSettingsForm['email'], 'Email');
                            Yii::app()->session['UserStaticData'] = $userObj;
                            Yii::app()->session['Email'] = $UserSettingsForm['email'];
                            $message = Yii::t('translation', 'User_Updation_Success');

                            $obj = array('status' => 'success', 'data' => $message.$message1, 'error' => '');
                        } else {
                            $errormsg = Yii::t('translation', 'User_Updation_Fail');
                            // $errormsg="User registration failed";
                            $obj = array('status' => 'fail', 'data' => $errormsg, 'error' => '');
                        }
                    }
                }
                 echo $this->rendering($obj);
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionUpdateUserSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

  }
  
  
      public function actionDynamicstates() {
        try{
        $data = State::model()->findAll('CountryID=:id', array(':id' => (int) $_POST['country']));
        if(isset($_POST['mobile']) && !empty($_POST['mobile'])){
             $obj = array('status' => 'success', 'states' => $data, 'count' => count($data));
             $renderScript = $this->rendering($obj);
             echo $renderScript;
        }else{
            if (count($data) > 0) {
                $data = CHtml::listData($data, 'id', 'State');
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('Please Select state'), true);
                foreach ($data as $value => $name) {
                    echo CHtml::tag('option', array('value' => $name), CHtml::encode($name), true);
                }
            } else {
                $fromString="UserRegistrationForm[state]";
                if(isset($_POST['requestFrom'])){
                    $fromString="UserSettingsForm[state]";
                }
                echo CHtml::textField($fromString, '', array('id' => $fromString,
                    'class' => 'span12 textfield',
                    'placeholder' => Yii::t('translation', 'User_Register_State'),
                    'maxlength' => 30));
            }
        }
        } catch (Exception $ex) {
            Yii::log("UserController:actionDynamicstates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionChangePassword(){
         try {
            $model = new ChangePasswordForm;
            if (isset($_POST['ChangePasswordForm'])) {
                $model->attributes = $_POST['ChangePasswordForm'];
                $errors = CActiveForm::validate($model);
                $obj = array();
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $userid = Yii::app()->session['TinyUserCollectionObj']->UserId;
                    $result = ServiceFactory::getSkiptaUserServiceInstance()->userUpdatePasswodService($userid,$model);
                    if ($result == '0') {
                        $message = Yii::t('translation', 'ResetPasswordSuccess');
                        $obj = array('status' => 'success', 'data' => $message, 'success' => '');
                    } elseif ($result == '1') {
                        $message = Yii::t('translation', 'ResetPasswordUnSuccess');
                        $obj = array('status' => 'error', 'data' => $message, 'error' => '');
                    } else if ($result == '2') {
                        $message = Yii::t('translation', 'OldPasswordMatchesNewPassword');
                        $obj = array('status' => 'error', 'data' => $message, 'error' => '');
                    } else if ($result == '3') {
                        $message = Yii::t('translation', 'passwordIncorrect');
                        $obj = array('status' => 'error', 'data' => $message, 'error' => '');
                    }else {
                        $obj = array('status' => 'error', 'data' => $result, 'error' => '');
                    }
                }
            }
        } catch (Exception $ex) {
           Yii::log("UserController:actionChangePassword::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        $renderScript = $this->rendering($obj);
        echo $renderScript;
    }
    public function actionGetActionUsers(){
        try{
            $postId = $_POST["postId"];
             $id = $_POST["id"];
            $actionType = $_POST["actionType"];
             $flag = $_POST["flag"];
              $categoryId = $_POST["categoryId"];
            $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
            $pageLength = 15;
           $page = $_REQUEST['page'];
           $pageSize = ($pageLength * $page); 
            $actionUsersList = ServiceFactory::getSkiptaUserServiceInstance()->getActionUsers($categoryId,$flag,$id,$actionType,$userId,$pageSize,$pageLength);
            if ($actionUsersList != 'failure') {
                $this->renderPartial('actionUsersList_view', array('actionUsersList' => $actionUsersList,'loginUserId'=>$userId));
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetActionUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserController->actionGetActionUsers==".$ex->getMessage());
        }
    }
 public function actionUpdateCustomSettings(){
       $error = "";
        $message = "";
        try {
            if (isset($_POST['CustomForm'])) {
                $CustomForm ="[]";
                $CustomForm= new CustomForm;
                $errorCustomForm = CActiveForm::validate($CustomForm); 
                if ($errorCustomForm != "[]") {
                    $obj = array('status' => 'fail', 'data' => '', 'error' => $errorCustomForm);
                } else {
                        $userid = Yii::app()->session['TinyUserCollectionObj']->UserId; 
                        $result = ServiceFactory::getSkiptaUserServiceInstance()->updateCustomSettings($userid,$CustomForm);
                        
                        
                        if ($result != 'error') { 
                            
                            $message = Yii::t('translation', 'CustomSettings_Updation_Success');

                            $obj = array('status' => 'success', 'data' => $message, 'error' => '');
                        } else {
                            $errormsg = Yii::t('translation', 'CustomSettings_Updation_Fail');
                            $obj = array('status' => 'fail', 'data' => $errormsg, 'error' => '');
                        }
       
                }
                 echo $this->rendering($obj);
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionUpdateCustomSettings::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

  }

  

  public function actionPreference() {
        try {

            $preference = new PreferenceForm();

          $countries = ServiceFactory::getSkiptaUserServiceInstance()->GetCountries();
           $preference->CountryId=$this->tinyObject['CountryId'];
           $userId = (int)$this->tinyObject['UserId'];
           $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType($userId,"UserId");
           $CountryRequest = $userObj->CountryRequest;
           $message = "";
           if($CountryRequest==1){
                $countryObj= Countries::model()->getCountryById($userObj->Country);
                $OldCountryName = $countryObj->Name;
                $changedCountryObj= Countries::model()->getCountryById($userObj->ChangedCountry);
                $NewCountryName = $changedCountryObj->Name;
                $message = "Your country change request from <strong>".$OldCountryName."</strong> to <strong>".$NewCountryName."</strong> is waiting for approval";
           }else if($CountryRequest==2){
                $countryObj= Countries::model()->getCountryById($userObj->Country);
                $OldCountryName = $countryObj->Name;
                $changedCountryObj= Countries::model()->getCountryById($userObj->ChangedCountry);
                $NewCountryName = $changedCountryObj->Name;
                $message = "Your country change request from <strong>".$OldCountryName."</strong> to <strong>".$NewCountryName."</strong> is rejected";
           }
           $this->render('preference', array('model' => $preference,'countries'=>$countries,'countryRequest'=>$CountryRequest, "message"=>$message));
        } catch (Exception $ex) {
            Yii::log("UserController:actionPreference::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionChangeSegment() {
        try {
            $obj = array();
            $status = "";
            $message = "";
            if (isset($_POST['PreferenceForm'])) {
                $prefenceform = new PreferenceForm();
                $prefenceform->attributes = $_POST['PreferenceForm'];
                $errors = CActiveForm::validate($prefenceform);

                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $status = ServiceFactory::getSkiptaUserServiceInstance()->updateUserPreferences($prefenceform, $this->tinyObject->UserId);
                    if ($status == "success") {
                        $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($this->tinyObject->UserId);
                        Yii::app()->session['TinyUserCollectionObj'] = $tinyUserCollectionObj;
                        
     
            $attributeArray = array("SegmentId" => Yii::app()->session['TinyUserCollectionObj']->SegmentId);
          Yii::app()->session['CurrentSegment'] = ServiceFactory::getSkiptaUserServiceInstance()->getSegmentByAttributes($attributeArray);
   

                        ServiceFactory::getSkiptaSegmentChangeService()->changeSegmentProcessByUserId($tinyUserCollectionObj);
                        
                         $userFollowingGroups = ServiceFactory::getSkiptaUserServiceInstance()->groupsUserFollowing($this->tinyObject->UserId, $segmentId);
                        Yii::app()->session['UserFollowingGroups'] = $userFollowingGroups;
                        
                        $attributeArray = array("SegmentId" => $tinyUserCollectionObj->SegmentId);
                        //get the segment default language
                        $segmentObj = ServiceFactory::getSkiptaUserServiceInstance()->getSegmentByAttributes($attributeArray);
                        $language = $segmentObj['Language'];
                        ServiceFactory::getSkiptaUserServiceInstance()->updateLanguageByUserId($tinyUserCollectionObj->UserId, $language);
                        //get the language and source language
                        $attributeArray = array("Language" => $language);
                        $languageObj = ServiceFactory::getSkiptaUserServiceInstance()->getLanguageByAttributes($attributeArray);
//update the language and source language in session
                        if (is_array($languageObj) || is_object($languageObj)) {
                            CommonUtility::changeLanguage($language, $languageObj["SourceLanguage"]);
                        } else {
                            Yii::app()->session['language'] = "en";
                            //Yii::app()->session['sourceLanguage'] = "en";
                        }
                    }
                }
            }
            $message = "country has been changed successfully";
            $obj = array("status" => $status, 'data' => $message, "error" => '');
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("UserController:actionChangeSegment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionChangeSegmentPageLoad() {
        try {
            $obj = array();
            $networkId = (int)$this->tinyObject['NetworkId'];
            //$networkId = 1;
            $segments = ServiceFactory::getSkiptaUserServiceInstance()->getAllSegmentsByNetwork($networkId);
            $userSegmentId = isset(Yii::app()->session['TinyUserCollectionObj']['SegmentId'])?Yii::app()->session['TinyUserCollectionObj']['SegmentId']:0;
            $segmentData = $this->renderPartial('changeSegment', array('segments' => $segments, "userSegmentId"=>$userSegmentId), true);
            $obj = array("status" => "success", 'content' => $segmentData, "title" => Yii::t('translation','Change_Segment'),"okButtonText"=>Yii::t('translation','Submit'));
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("UserController:actionChangeSegmentPageLoad::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionChangeAdminSegment() {
        try {
            $obj = array("status" => "failure");
            if(isset($_REQUEST['segmentId'])){
                $userId = (int)$this->tinyObject['UserId'];
                $segmentId = (int)$_REQUEST['segmentId'];
                //update segmentId in TinyUserCollection
                $result = ServiceFactory::getSkiptaUserServiceInstance()->updateSegmentByUserId($userId, $segmentId);
                if($result=="success"){
                    Yii::app()->session['TinyUserCollectionObj']['SegmentId'] = (int)$segmentId;
                    $attributeArray = array("SegmentId" => $segmentId);
                    //get the segment default language
                    $segmentObj = ServiceFactory::getSkiptaUserServiceInstance()->getSegmentByAttributes($attributeArray);
                    Yii::app()->session['CurrentSegment'] = $segmentObj;
                    $language = $segmentObj['Language'];
                    ServiceFactory::getSkiptaUserServiceInstance()->updateLanguageByUserId($userId, $language);
                    //get the language and source language
                    $attributeArray = array("Language" => $language);
                    $languageObj = ServiceFactory::getSkiptaUserServiceInstance()->getLanguageByAttributes($attributeArray);
//update the language and source language in session
                    if(is_array($languageObj) || is_object($languageObj)){
                        CommonUtility::changeLanguage($language,$languageObj["SourceLanguage"]);
                    }else{
                        Yii::app()->session['language'] = "en";
                        //Yii::app()->session['sourceLanguage'] = "en";
                    }
                    $obj = array("status" => "success");
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionChangeAdminSegment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGetLanguages() {
        try {
            $languages = ServiceFactory::getSkiptaUserServiceInstance()->GetAllLanguages();
            $userLanguage = isset(Yii::app()->session['language'])?Yii::app()->session['language']:"en_us";
            $this->renderPartial('changeLanguage', array('languages'=>$languages,"userLanguage"=>$userLanguage));
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetLanguages::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionChangeLanguage() {
        try {
            $obj = array("status" => "failure");
            if(isset($_REQUEST['language'])){
                $userId = (int)$this->tinyObject['UserId'];
                $language = $_REQUEST['language'];
                //update segmentId in TinyUserCollection
                $result = ServiceFactory::getSkiptaUserServiceInstance()->updateLanguageByUserId($userId, $language);
                if($result=="success"){
                    $attributeArray = array("Language" => $language);
                    $languageObj = ServiceFactory::getSkiptaUserServiceInstance()->getLanguageByAttributes($attributeArray);
                    if(is_array($languageObj) || is_object($languageObj)){
                        CommonUtility::changeLanguage($language,$languageObj["SourceLanguage"]);
                    }else{
                        Yii::app()->session['language'] = "en";
                        //Yii::app()->session['sourceLanguage'] = "en";
                    }
                    $obj = array("status" => "success");
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionChangeLanguage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }  
    public function actionRequestForChangeCountry() {
        try {
            $obj = array();
            $status = "";
            $message = "";
            if (isset($_POST['PreferenceForm'])) {
                $prefenceform = new PreferenceForm();
                $prefenceform->attributes = $_POST['PreferenceForm'];
                $errors = CActiveForm::validate($prefenceform);

                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $status = ServiceFactory::getSkiptaUserServiceInstance()->requestForChangeCountry($prefenceform, $this->tinyObject->UserId);
                    if ($status == "success") {
                        $message = "country change is inprogress, admin will aprove for changing country shortly";
                    }elseif ($status=="same") {
                        $message = "currently you are in selected country";
                    }
                }
            }
            $obj = array("status" => $status, 'data' => $message, "error" => '');
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("UserController:actionRequestForChangeCountry::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionSaveUserProfileDetails() {
        try {
            
            $this->layout='userLayout';
            $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];
           $userId=$this->tinyObject->UserId;
            $obj = array();
            $userSpecility="";
            $userstate="";
            $profileModel = new UserProfileDetailsForm();
            if (isset($_POST['UserProfileDetailsForm'])) {
                
                $profileModel->attributes = $_POST['UserProfileDetailsForm'];
                $errors = CActiveForm::validate($profileModel);
               
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else { 
                   
                    $profileModel['UserId']=$userId;
                    $userObj = ServiceFactory::getSkiptaUserServiceInstance()->updateUserProfileDetailsByUsingUserId($profileModel);
                    if ($userObj != 'failure') {
                         $subspeciality=SubSpecialty::model()->getSubSpecialityByType('id',$profileModel['Speciality']);
                         $userSpecility=$subspeciality->Value;
                         //$states=State::model()->GetStateById($profileModel['State']);
                       
                         if($profileModel['State']!=""){
                            $userstateDetails=State::model()->GetStateByUsingStateName($profileModel['State']);
                         if($userstateDetails!='failure') {  
                            if($userstateDetails['StateCode']!=""){
                                  $userstate=$userstateDetails['StateCode'];
                              }else{
                                  $userstate=$userstateDetails['State'];
                              }
                         }
                         }else{
                              $userstate= $profileModel['State'];
                         }
                        $message = Yii::t('translation', 'ProfileUpdateSuccess');
                        //$successMessage=array('ForgotForm_email'=>$message);
                        $obj = array('status' => 'success', 'message' => $message, 'success' => '','data'=>$profileModel,'userSpecility'=>$userSpecility,'userstate'=>$userstate);
                    } else {
                        $message = Yii::t('translation', 'ProfileUpdateFail');
                        $errorMessage = array('ForgotForm_email' => $message);

                        $obj = array("status" => 'error', 'message' => '', "error" => $errorMessage,'data'=>'');
                    }
                }

                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionSaveUserProfileDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
 public function actiongetUserProfileDetailsForProfileEdit(){
     try{
         $urlArray =  explode("/", Yii::app()->request->url);
         
        $isUser=0;
        $userProfileId='';
        $loggedInUserId=null;
        $profileModel = new ProfileDetailsForm();
        $UserProfileModel=new UserProfileDetailsForm();
        $userInterests=array();
        $CustomFields= ServiceFactory::getSkiptaUserServiceInstance()->getCustomSubSpeciality(); 
        $States= ServiceFactory::getSkiptaUserServiceInstance()->getCustomSubSpeciality(); 
        $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];  
        if(isset($this->tinyObject)){
              $loggedInUserId=$this->tinyObject->UserId;
              $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
              
        }
        $UserId=$_REQUEST['UserId'];
     //  $userProfileId =  ServiceFactory::getSkiptaUserServiceInstance()->getUserIdbyName($UserId);
       $userProfileId=$UserId;
       
       if($loggedInUserId==$userProfileId){
          $isUser = 1;    
        }
        $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileDetails($userProfileId,$loggedInUserId); 
        $displayName=$this->tinyObject->DisplayName;
        $userProfileDetails=ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userProfileId); 
        $UserData = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userProfileId);
        $States=State::model()->GetStateByUsingCountryId($UserData['Country']);
        $displayName=$userProfileDetails->DisplayName;
       
       $this->renderPartial('userProfileForm',array('profileDetails'=>  $data,'profileModel'=>$profileModel,'IsUser'=>$isUser,'loginUserId'=>  $this->tinyObject->UserId, 'networkAdmin'=>(int)Yii::app()->session['NetworkAdminUserId'],'displayName'=>$displayName,'UserProfileModel'=>$UserProfileModel,'CustomFields'=>$CustomFields,'States'=>$States,'UserData'=>$UserData));
       } catch (Exception $ex) {
            Yii::log("UserController:actiongetUserProfileDetailsForProfileEdit::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
 }  
    
 public function actionGetStatesByCountry() {
        try {
            $data = State::model()->findAll('CountryID=:id', array(':id' => (int) $_POST['country']));
            $specialityArray = array();
            if (count($data) > 0) {
                $data = CHtml::listData($data, 'id', 'State');
                array_push($specialityArray, CHtml::tag('option', array('value' => ''), CHtml::encode('Please Select state'), true));
                foreach ($data as $value => $name) {
                    array_push($specialityArray, CHtml::tag('option', array('value' => $name), CHtml::encode($name), true));
                }
            } else {
                array_push($specialityArray, CHtml::textField('AdvertisementForm[State]', '', array('id' => 'AdvertisementForm_State',
                            'class' => 'span12 textfield',
                            'placeholder' => Yii::t('translation', 'User_Register_State'),
                            'maxlength' => 30)));
            }
            echo $this->rendering(array('data' => $specialityArray));
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetStatesByCountry::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
    
}

?>

