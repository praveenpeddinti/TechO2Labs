<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CommonController extends Controller{
    
     public function init() {
        try{
        $this->initializeforms();
        if(isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])){            
            parent::init();
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            $urlPath = $_SERVER['REQUEST_URI'];
            $urlArr = explode("/", $urlPath);
            if (isset($urlArr[2])) {
                $queryStringURl = explode("?", $urlArr[2]);
            }
            if(isset($queryStringURl[0]) && strtolower($queryStringURl[0]) == "postdetail"){
              $querySubStringArray = explode("=", $queryStringURl[1]);
              if($querySubStringArray[0] == "bundle"){
                    $this->redirect("/marketresearchview/1/".$querySubStringArray[1]);  
               }
               if($_REQUEST['categoryType'] == 9){
                   $this->redirect("/".$_REQUEST['postType']."/".$_REQUEST['postId']."/detail/game");   
               }
               else{
                    $referenceUserId = $_REQUEST['trfid'];
             if($_REQUEST['postType']==11){
                 $this->redirect(array('/news/postdetail', 'postId'=>$_REQUEST['postId'], 'categoryType'=>$_REQUEST['categoryType'],'postType'=>$_REQUEST['postType'],'outer'=>'true')); 
                
             }else if($_REQUEST['postType']==12){
                 $this->redirect(array('/game/gamedetail', 'postId'=>$_REQUEST['postId'], 'categoryType'=>$_REQUEST['categoryType'],'postType'=>$_REQUEST['postType'],'outer'=>'true'));
             }else{
                  $this->redirect(array('/post/postdetail', 'postId'=>$_REQUEST['postId'], 'categoryType'=>$_REQUEST['categoryType'],'postType'=>$_REQUEST['postType'],'outer'=>'true'));
               // $this->redirect(array('/news/postdetail', 'postId'=>$_REQUEST['postId'], 'categoryType'=>$_REQUEST['categoryType'],'postType'=>$_REQUEST['postType'],'outer'=>'true')); 
             } 
                }
            }elseif(isset($urlArr[1]) && strtolower($urlArr[1]) != "profile"){               
                $this->redirect("/");
            }
          
        }else{
            
            $this->sidelayout = 'no';
        }
        } catch (Exception $ex) {
            Yii::log("CommonController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function actionError()
{
 $cs = Yii::app()->getClientScript();
$baseUrl=Yii::app()->baseUrl; 
$cs->registerCssFile($baseUrl.'/css/error.css');
    if($error=Yii::app()->errorHandler->error)
        $this->render('error', $error);
}
    public function actionPrivacyPolicy(){
         if(!isset($_REQUEST['mobile'])){
            $this->renderPartial('mobilePrivacyPolicy'); 
        }
         else if(!Yii::app()->request->isAjaxRequest){
              $this->render('privacyPolicy');
         }else{
              $this->renderPartial('privacyPolicy');
         }
    }
    public function actionTermsOfServices(){
         if(!isset($_REQUEST['mobile'])){
            $this->renderPartial('mobileTermsOfServices'); 
        }
         else if(!Yii::app()->request->isAjaxRequest){
              $this->render('termsOfServices');
         }else{
              $this->renderPartial('termsOfServices');
         }
        
    }
    public function actionAboutUs(){
         if(!Yii::app()->request->isAjaxRequest){
              $this->render('aboutus');
         }else{
              $this->renderPartial('aboutus');
         }
    }
     public function actionMobile(){
        if(!Yii::app()->request->isAjaxRequest){
              $this->render('mobile');
         }else{
              $this->renderPartial('mobile');
         }
    }
    public function actionContactUs(){
        if(!Yii::app()->request->isAjaxRequest){
              $this->render('contactus');
         }else{
              $this->renderPartial('contactus');
         }
    }
    
    /**
     * @author Karteek.V
     */
     public function actionPostDetail() {
        $forgotModel = new ForgotForm();
         $contactForm=new ContactUsForm();
        try{    
             $model = new LoginForm;
             $UserRegistrationForm = new UserRegistrationForm;
             $countries = ServiceFactory::getSkiptaUserServiceInstance()->GetCountries(); 
             if(isset($_REQUEST['trfid']) && !empty($_REQUEST['trfid'])){
                $postId = $_REQUEST['postId'];
                $categoryType = $_REQUEST['categoryType'];
                $postType = $_REQUEST['postType'];
                $referenceUserId = $_REQUEST['trfid'];
             }elseif(isset($_REQUEST['post']) && !empty($_REQUEST['post'])){
                 $categoryType=1;
                 $b = (int)$_REQUEST['b'];
                 $p = (int)$_REQUEST['p'];
                 if($b==0 && $p==0){
                     $categoryType=3;
                 }
                 $categoryType = (int)$_REQUEST['categoryType'];
                 $postObj = ServiceFactory::getSkiptaPostServiceInstance()->getPostIdByMigratedPostId($categoryType, $_REQUEST['post']);
                 $postId = (string)($postObj->_id);
                 $postType = $postObj->Type;
                 $referenceUserId = '1';
             }else{
                 $categoryType=1;
                 $b = (int)$_REQUEST['b'];
                 $a = (int)$_REQUEST['a'];
                 if($a==0 && $b==0){
                     $categoryType=2;
                 }
                 $categoryType = (int)$_REQUEST['categoryType'];
                 $postObj = ServiceFactory::getSkiptaPostServiceInstance()->getPostIdByMigratedPostId($categoryType, $_REQUEST['postid']);
                 $postId = (string)($postObj->_id);
                 $postType = $postObj->Type;
                 $referenceUserId = '1';
             }
             
        if(!isset(Yii::app()->session['TinyUserCollectionObj'])){   
            $this->render('/site/postdetail', array('model' => $model,'UserRegistrationModel' => $UserRegistrationForm,'countries' => $countries,"forgotModel"=>$forgotModel,'postId'=>$postId,'categoryType'=>$categoryType,'postType'=>$postType,'referenceUserId'=>$referenceUserId,'contactForm' => $contactForm));
        }else{
            $this->render('/post/postdetail', array('postId'=>$postId,'categoryType'=>$categoryType,'postType'=>$postType));
        }
        } catch (Exception $exc) {
            Yii::log("++++++++++++++++++++++++++++++++".$exc->getMessage(), 'error', 'userController');
        }
        
            

    }
    
    public function actionRenderPostDetailed() {
        try {  
            if (isset($_REQUEST['load'])) {
                $data = explode('_', $_REQUEST['load']);
                $categoryType = $data[0];
                $postId = $data[1];
                $postType = $data[2];
            } else {                
                $postId = $_REQUEST['postId'];
                $categoryType = $_REQUEST['categoryType'];
                $postType = $_REQUEST['postType'];
            }  
            $curbsideCategory = array();
            $object = array();
            $tinyUserProfileObject = array();
            $MoreCommentsArray = array();
            if ($categoryType == 1 && $postType != 5) {
                $object = ServiceFactory::getSkiptaPostServiceInstance()->getPostObjectById($postId);
            } else if ($postType == 5) {
                $object = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsidePostObjectById($postId);
                $curbsideCategory = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId($object->CategoryId);
                
            } else if ($postType == 2 || $categoryType == 3 || $categoryType == 7) {
                $object = ServiceFactory::getSkiptaPostServiceInstance()->getGroupPostObjectById($postId);
                $groupStatus=ServiceFactory::getSkiptaGroupServiceInstance()->getGroupStatus($object->GroupId);
            if(!is_string($groupStatus)){
                $object['Status']=$groupStatus->Status;
            }
            }
            if(isset($object) && !empty($object)){
            $UserId = $object->UserId;
            $tinyUserProfileObject = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($UserId);
            if(isset($object->WebUrls)){
             if(isset($object->IsWebSnippetExist)&& $object->IsWebSnippetExist=='1'){            
                     $snippetdata = WebSnippetCollection::model()->CheckWebUrlExist($object->WebUrls[0]);
                     $object->WebUrls=$snippetdata;
                }else{
                     $object->WebUrls="";
                }
            }
         //This code is for get post all comment and prepare comments data with web snippets  
            
             $MinpageSize = 2;
       // $page = $_REQUEST['Page'];
        $page=0;
        $pageSize = ($MinpageSize * $page);
        $categoryType = (int) $categoryType;
        
        $numberOfComments=5;
        $MoreCommentsArray = CommonUtility::prepareComments($pageSize, $MinpageSize, $postId, $categoryType, "",$numberOfComments);
         
        $status = 1;
            
            }else{
                $object = 0;
                $status = 0;
            }
            
          // END ----------------------------------------------------------  
            if (isset($_REQUEST['load'])) {
                $this->render("/post/postDetailedPage", array("data" => $object, "tinyObject" => $tinyUserProfileObject, "categoryType" => $categoryType, "curbsideCategory" => $curbsideCategory,'commentsdata'=>$MoreCommentsArray));
            } else {
                $this->renderPartial("postDetailedPage", array("data" => $object, "tinyObject" => $tinyUserProfileObject, "categoryType" => $categoryType, "curbsideCategory" => $curbsideCategory,'commentsdata'=>$MoreCommentsArray,"status"=>$status,'timezone'=>$_REQUEST['timezone']));
            }
        } catch (Exception $ex) {
            Yii::log($ex->getMessage(), "error", "application");
        }
    }
 
    public function actionGetFooterTabsData() {
        try{            
            if(isset($_REQUEST['type'])){
                
                $pageType=$_REQUEST['type'];
            }
             //   $this->renderPartial('termsOfServices');
                 $this->renderPartial($pageType);
     
    }  catch (Exception $ex) {
        error_log("^^^&Exception&&&&".$ex->getMessage());
            Yii::log($ex->getMessage(), "error", "application");
        }
    }
    
      
    /**
     * @Author swathi
     * This method is used to get the joyrideInfo by module name
     * @param: 'searchkey' is the string.
     */
    public function actionGetJoyrideDetails() {
        try {
              if (isset($_POST['moduleName'])) {

                $moduleName = $_REQUEST['moduleName'];
                $result = array(); 
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getJoyrideDetailsByModule($moduleName);
                $this->renderPartial('joyride', array('joyrideInfo' => $result));
              }
        } catch (Exception $e) {
            Yii::log("Exception Occurred in actionGetJoyrideDetails==" . $ex->getMessage(), "error", "application");
        }
    }
    
    public function actionEnableOrDisableJoyRide()
    {
        try {
               if (isset($_POST['action'])) {
                  
                      $response = ServiceFactory::getSkiptaPostServiceInstance()->enableOrDisableJoyRide($_POST['action'],Yii::app()->session['UserStaticData']->UserId);
                       if($response){
                         
                           Yii::app()->session['UserStaticData']->disableJoyRide=$_POST['action'];
                                                    
                        $obj = array("status"=>"success","data"=>"","error"=>"");    
                      }else{
                            $obj = array("status"=>"failure","data"=>"","error"=>"");
                      }
                       echo $this->rendering($obj);

                          }
            
            
        } catch (Exception $exc) {
            Yii::log("Exception Occurred in actionEnableOrDisableJoyRide==" . $ex->getMessage(), "error", "application");
        }
        }

        public function actionRenderPostDetailForCareer() {
        try {
            $jobId = $_REQUEST['id']; 
                $jobDetails = ServiceFactory::getSkiptaCareerServiceInstance()->getJobdetails($jobId);             
            if (!is_string($jobDetails)) {
                $this->renderPartial('careerdetailedpage', array('jobDetails' => $jobDetails));
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
    }
      public function actionRenderNewsDetailedPage(){
        try {  
            if (isset($_REQUEST['load'])) {
                $data = explode('_', $_REQUEST['load']);
                $categoryType = $data[0];
                $postId = $data[1];
                $postType = $data[2];
            } else {                
                $postId = $_REQUEST['postId'];
                $categoryType = $_REQUEST['categoryType'];
                $postType = $_REQUEST['postType'];
            }
//            $postId = $_REQUEST['postId'];
//            $categoryType = $_REQUEST['categoryType'];
//            $postType = $_REQUEST['postType'];    
           // $id = $_REQUEST['id'];
            $mainGroupCollection="";
            $MoreCommentsArray = array();
            $tinyUserProfileObject = array();
            $object = array();
            $object = ServiceFactory::getSkiptaPostServiceInstance()->getNewsObjectById($postId);
            if(isset($object) && !empty($object)){
            $UserId = $object->UserId;
            $tinyUserProfileObject = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($UserId);
            if(isset($object->WebUrls)){
             if(isset($object->IsWebSnippetExist)&& $object->IsWebSnippetExist=='1'){            
                     $snippetdata = WebSnippetCollection::model()->CheckWebUrlExist($object->WebUrls[0]);
                     $object->WebUrls=$snippetdata;
                }else{
                     $object->WebUrls="";
                }
            }
         //This code is for get post all comment and prepare comments data with web snippets  
            
             $MinpageSize = 2;
        $page=0;
        $pageSize = ($MinpageSize * $page);
        $categoryType = (int) $categoryType;
        $result = ServiceFactory::getSkiptaPostServiceInstance()->getRecentCommentsforNews($postId);
         $commentDisplayCount = 0;
         if(isset($result) && sizeof($result)>0){
              $rs=array_reverse($result);
        foreach ($rs as $key => $value) {
            if(!(isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']==1)){
                $commentUserBean = new CommentUserBean();
                $userDetails = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($value['UserId']);
                $createdOn = $value['CreatedOn'];
                $commentUserBean->UserId = $userDetails['UserId'];

                $postId = (isset($value["PostId"])) ? $value["PostId"] : '';
                $CategoryType = (isset($value["CategoryType"])) ? $value["CategoryType"] : '';
                $PostType = (isset($value["PostType"])) ? $value["PostType"] : '';
                    $value["CommentText"] = $value["CommentText"];
                $commentUserBean->CommentText = $value['CommentText'];
                if(is_int($createdOn))
                {
                    $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn);
                }
                else if(is_numeric($createdOn))
                {
                    $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn);
                }
                else
                {
                    
                    $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn->sec);
                }

                $commentUserBean->DisplayName = $userDetails['DisplayName'];
                $commentUserBean->ProfilePic = $userDetails['profile70x70'];
                $commentUserBean->CateogryType = $CategoryType;
                $commentUserBean->PostId = $postId;
                $commentUserBean->Type = $PostType;
                $commentUserBean->Resource=$value['Artifacts'];
                $commentUserBean->ResourceLength = count($value['Artifacts']);
                //$commenturls=$value['WebUrls'];
                if (array_key_exists('WebUrls', $value)) {
                 if(isset($value['WebUrls']) && is_array($value['WebUrls']) && count($value['WebUrls'])>0){
                     
                      $commenturls=$value['WebUrls'];
                         $WeburlObj = ServiceFactory::getSkiptaPostServiceInstance()->CheckWebUrlExist($commenturls[0]);
                     
                         if($WeburlObj!='failure'){
                               $snippetData=$WeburlObj;
                          }else{
                              
                              $snippetData="";
                          }
                        }else{
                            
                            $snippetData="";
                        }
                    $commentUserBean->snippetdata = $snippetData;
                     if(isset($value['IsWebSnippetExist'])){
                         $commentUserBean->IsWebSnippetExist = $value['IsWebSnippetExist'];
                    }else{
                         $commentUserBean->IsWebSnippetExist = "";
                    }
                  }

                array_push($MoreCommentsArray, $commentUserBean);
                 $commentDisplayCount++;
                  if($commentDisplayCount==5){
                                break;
                     }
                
            }

        }
         }
        }else{
            $object = 0;            
        }
        $commentedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getCommentedUsersForPost($postId, (int)($this->tinyObject['UserId']));
        $IsUserCommented = in_array((int)($this->tinyObject['UserId']), $commentedUsers);
        
         if (isset($_REQUEST['load'])) {
              $this->renderPartial("/news/newsDetailedPage", array("data" => $object, "tinyObject" => $tinyUserProfileObject, "categoryType" => $categoryType,'commentsdata'=>$MoreCommentsArray,'IsCommented'=>$IsUserCommented));
            } else {
               $this->renderPartial("newsDetailedPage", array("data" => $object, "tinyObject" => $tinyUserProfileObject, "categoryType" => $categoryType,'commentsdata'=>$MoreCommentsArray,'IsCommented'=>$IsUserCommented));
            }
        
       // $this->renderPartial("newsDetailedPage", array("data" => $object, "tinyObject" => $tinyUserProfileObject, "categoryType" => $categoryType,'commentsdata'=>$MoreCommentsArray,'IsCommented'=>$IsUserCommented));
       // $userId = $this->tinyObject['UserId'];  
        //ServiceFactory::getSkiptaPostServiceInstance()->trackEngagementAction($userId,"Post","PostDetailOpen",$postId,$categoryType,$postType);

        } catch (Exception $ex) {
            Yii::log($ex->getMessage(), "error", "application");
        }
    }
     public function actionRenderGameDetails(){
        try {

            if (isset($_REQUEST['load'])) {
                $urlArray = explode('_', $_REQUEST['load']);
                $gameName = $urlArray[1];
                $gameScheduleId = $urlArray[2];
                $mode = $urlArray[3];
            } else {
                $gameName = $_REQUEST['postType'];
                $gameScheduleId = $_REQUEST['postId'];
                $mode = 'detail';
            }

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
            $MoreCommentsArray = CommonUtility::prepareComments($pageSize, $MinpageSize, $postId, $categoryType, "",$numberOfComments);

            $commentedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getCommentedUsersForPost($postId, (int) ($this->tinyObject['UserId']));
            $IsUserCommented = in_array((int) ($this->tinyObject['UserId']), $commentedUsers);
            $this->renderPartial('gameDetail', array("gameDetails" => $gameDetailsArray[0], "gameBean" => $gameDetailsArray[1], "mode" => $mode, 'commentsdata' => $MoreCommentsArray, 'IsCommented' => $IsUserCommented));
        } catch (Exception $exc) {
            Yii::log('In Excpetion Game Wall'.$exc->getMessage(),'error','application');
        }

        
    }
 
      public function actionGetOauthNetworks()
  {
      try
      {
           $providersData= ServiceFactory::getSkiptaUserServiceInstance()->getAllOauthProviderDetails();
           if($providersData!="failure" && count($providersData)>0)
                $this->renderPartial('oauthNetworks', array('oAuthNetworksInfo' => $providersData));
           else
               echo 0;
      } catch (Exception $ex) {
          Yii::log("Exception Occurred in actionGetOauthNetworks==" . $ex->getMessage(), "error", "application");
      }
  }
 public function actionProfileDetails(){
    try {
         
    $urlArray =  explode("/", Yii::app()->request->url);

        $isUser=0;
        $userProfileId='';
        $loggedInUserId=null;
        $profileModel = new ProfileDetailsForm();
        $this->layout='userLayout';
        $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];  
        if(isset($this->tinyObject)){
              $loggedInUserId=$this->tinyObject->UserId;
              $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
              
        }
       $userProfileId =  ServiceFactory::getSkiptaUserServiceInstance()->getUserIdbyName($urlArray[2]);

       
       if($loggedInUserId==$userProfileId){
          $isUser = 1;    
        }
        
        $data = ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileDetails($userProfileId,$loggedInUserId); 

        
        $displayName=$this->tinyObject->DisplayName;
        $userProfileDetails=ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userProfileId); 
        $displayName=$userProfileDetails->DisplayName;
        $userBadges=ServiceFactory::getSkiptaUserServiceInstance()->getUserBadgesData($userProfileId);
        $userFollowingHashtags=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingHashtagsDataForProfile($userProfileId);
        $userFollowingGroups=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingGroupsDataForProfile($userProfileId,$loggedInUserId);
       // $userFollowingSubGroups=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingSubGroupsData($userProfileId,$loggedInUserId);        
        $userFollowingCategories=ServiceFactory::getSkiptaUserServiceInstance()->getUserFollowingCurbsideCategoriesDataForProfile($userProfileId);
        $userFollowing=  ServiceFactory::getSkiptaUserServiceInstance()->getFollowersAndFollowing($userProfileId,'userFollowing');
        $userFollowers=  ServiceFactory::getSkiptaUserServiceInstance()->getFollowersAndFollowing($userProfileId,'userFollowers');        
        
      
        $userCVDetails=ServiceFactory::getSkiptaUserServiceInstance()->getUserCVDetails($userProfileId);
       
        $ExperiencePriority = "";
            $EducationPriority = "";
            $InterestPriority = "";
            $AchievementPriority = "";
            $PublicationPriority = "";
          
            if (isset($userCVDetails['education']) && is_array($userCVDetails['education'])) {
                foreach ($userCVDetails['education'] as $key => $value) {
                    $EducationPriority = $value['Education_Priority'];
                }
            }
            if (isset($userCVDetails['achievements']) && is_array($userCVDetails['achievements'])) {
                foreach ($userCVDetails['achievements'] as $key => $value) {

                    $AchievementPriority = $value['Achievement_Priority'];
                }
            }
            $experienceIds = array();
            if (isset($userCVDetails['experience']) && is_array($userCVDetails['experience'])) {
                foreach ($userCVDetails['experience'] as $key => $value) {

                    $ExperiencePriority = $value['Experience_Priority'];
                }
            }
            $interestIds = array();
            if (isset($userCVDetails['interests']) && is_array($userCVDetails['interests'])) {
                foreach ($userCVDetails['interests'] as $key => $value) {

                    $InterestPriority = $value['Interest_Priority'];
                }
            }
            $publicatioIds = array();
            if (isset($userCVDetails['publications']) && is_array($userCVDetails['publications'])) {
                foreach ($userCVDetails['publications'] as $key => $value) {

                    $PublicationPriority = $value['Publication_Priority'];
                }
            }
            $priorityArray = array();
            $EducationPriority = ($EducationPriority == null) ? '0' : $EducationPriority;
            $InterestPriority = ($InterestPriority == null) ? '2' : $InterestPriority;
            $ExperiencePriority = ($ExperiencePriority == null) ? '1' : $ExperiencePriority;
            $AchievementPriority = ($AchievementPriority == null) ? '4' : $AchievementPriority;
            $PublicationPriority = ($PublicationPriority == null) ? '3' : $PublicationPriority;
            $priorityArray[$AchievementPriority] = 'achievements';
            $priorityArray[$InterestPriority] = 'interests';
            $priorityArray[$EducationPriority] = 'education';
            $priorityArray[$ExperiencePriority] = 'experience';
            $priorityArray[$PublicationPriority] = 'publications';

            ksort($priorityArray);
        
        
        $userInteractionsCount=  ServiceFactory::getSkiptaUserServiceInstance()->getUserInteractionsCount($userProfileId);
        $userDisplayCVDetails=array();
        $pDis=1;
        
       // print_r($priorityArray);
         for ($r = 0; $r < sizeof($priorityArray); $r++) {
              if(isset($userCVDetails[$priorityArray[$r]]) && is_array($userCVDetails[$priorityArray[$r]]) && $pDis<=2){
                $pDis=$pDis+1;
                if($priorityArray[$r]=='interests' || $priorityArray[$r]=='achievements'){
                    $userDisplayCVDetails[$priorityArray[$r]]=$userCVDetails[$priorityArray[$r]];
                }else{
                    $userDisplayCVDetails[$priorityArray[$r]]=$userCVDetails[$priorityArray[$r]][0];
                }
                
                
                if($priorityArray[$r]=='publications'){
                    $urlArr = explode("/",$userCVDetails['publications']['Files']);
                    $userDisplayCVDetails['publications']['Files'] = $urlArr[3];
                }
                
             }
             
        
         }
        
        
//        if(isset($userCVDetails['publications']) && is_array($userCVDetails['publications']) && $pDis<=2){
//            $pDis=$pDis+1;
//            $userDisplayCVDetails['publications']=$userCVDetails['publications'][0];
//            if($userCVDetails['publications']['Files'] != ""){
//                $urlArr = explode("/",$userCVDetails['publications']['Files']);
//                $userDisplayCVDetails['publications']['Files'] = $urlArr[3];
//            }
//        }
//        if(isset($userCVDetails['experience']) && is_array($userCVDetails['experience']) && $pDis<=2){
//            $pDis=$pDis+1;
//            $userDisplayCVDetails['experience']=$userCVDetails['experience'][0];
//        }
//        
//        if(isset($userCVDetails['interests']) &&is_array($userCVDetails['interests']) && $pDis<=2){
//            $pDis=$pDis+1;
//            $userDisplayCVDetails['interests']=$userCVDetails['interests'];
//        }
//        
//        if(isset($userCVDetails['education']) && is_array($userCVDetails['education']) && $pDis<=2 ){
//            $pDis=$pDis+1;
//            $userDisplayCVDetails['education']=$userCVDetails['education'][0];
//        }
//
//        if(isset($userCVDetails['achievements']) && is_array($userCVDetails['achievements']) && $pDis<=2 ){
//            $pDis=$pDis+1;
//            $userDisplayCVDetails['achievements']=$userCVDetails['achievements'];
//        }
       $redirectview=isset(Yii::app()->session['TinyUserCollectionObj']['UserId'])?"/user/userProfileDetails" :"userProfileDetails";
        $this->render($redirectview,array('profileDetails'=>  $data,'profileModel'=>$profileModel,'IsUser'=>$isUser,'loginUserId'=>  $this->tinyObject->UserId,'userFollowingHashtags'=>$userFollowingHashtags , 'userFollowingGroups'=>$userFollowingGroups, 'userFollowingCategories'=>$userFollowingCategories, 'userFollowingSubGroups'=>$userFollowingSubGroups, 'networkAdmin'=>(int)Yii::app()->session['NetworkAdminUserId'],'userFollowers'=>$userFollowers,'userFollowing'=>$userFollowing,'displayName'=>$displayName,"userBadges"=>$userBadges,"userCVDetails"=>$userDisplayCVDetails,"userInteractionsCount"=>$userInteractionsCount,'OrderArray'=>$priorityArray));
    } catch (Exception $exc) {  

        Yii::log($exc->getMessage(),'error','application');
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
                            'IsDeleted'=>array('!=' => 1),
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
              $userId = isset(Yii::app()->session['TinyUserCollectionObj']['UserId'])?Yii::app()->session['TinyUserCollectionObj']['UserId']:0;
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
            $redirectview=isset(Yii::app()->session['TinyUserCollectionObj']['UserId'])?"/user/profile_intractions_view" :"profile_intractions_view";
           $this->renderPartial($redirectview,array('stream'=>$stream,'totalCount'=>$provider->getTotalItemCount()-8,'page'=>'profile'));
        }
        }catch(Exception $ex){
         Yii::log("************EXCEPTION at actionGetProfileIntractions*****************".$ex->getMessage(),'error','application');   
        }
        
    }
    
      public function actionMobileRedirect(){
          
          error_log($_REQUEST['Type']."");
        $this->layout = 'mobilelayout';  
        $this->render('mobileRedirect', array('type' => $_REQUEST['Type']));
    }
    
    /**
       * 
       * @param type $hecArray
       */
      
       public function actionProcessHecJob() {
        try {
error_log( "INSERTING==== NEWJOBID=====HEC JOB=================");
            $val = urldecode($_REQUEST['hecArray']);
            $data = json_decode($val);
            $return = Careers::model()->saveHecJobs($data);
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
/**
* Author Haribabu
* @param type $hecArray
 * This method is used to update the Hec jobs Status.
*/
      
 public function actionUpdateHecJobStatus() {
        try {

            $return = Careers::model()->updateHecJobsStatus();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function actionVerifyStudentAccount(){
        try{
            $linkcode = isset($_REQUEST['linkcode'])?$_REQUEST['linkcode']:"";
            $email = isset($_REQUEST['em'])?$_REQUEST['em']:"";
            if(!empty($linkcode) && !empty($email)){
                $resetForm = new ResetForm();
                $forgotModel = new ForgotForm();  
                $contactForm=new ContactUsForm();
                $model = new LoginForm;
                $UserRegistrationForm = new UserRegistrationForm;
                $resetForm->md5UserId = $_REQUEST['linkcode'];
                $resetForm->email = $email;
                $userObj = ServiceFactory::getSkiptaUserServiceInstance()->checkStudentExist($email,$linkcode);
                $studentAccessToken = $userObj['StudentAccessToken'];
                $isVerified = 0;    
                if (trim($studentAccessToken) == trim($linkcode)) {
                    if($userObj['Status'] == 4){
                        $isVerified = 1;
                        $studentMessage = Yii::t("translation","StudentVerification_success");
                        $result = ServiceFactory::getSkiptaUserServiceInstance()->updateStudentStatus($userObj['UserId']);                        
                    }else{
                        $studentMessage = Yii::t("translation","StudentVerification_already");
                    }
                }else{                        
                    $studentMessage = Yii::t("translation","StudentVerification_error");
                }
                
                $countries = ServiceFactory::getSkiptaUserServiceInstance()->GetCountries();
                $this->render('/site/postdetail', array('model' => $model,'UserRegistrationModel' => $UserRegistrationForm,'countries' => $countries,"forgotModel"=>$forgotModel,'postId'=>"",'categoryType'=>"",'postType'=>"",'referenceUserId'=>"",'contactForm' => $contactForm,"studentVerification"=>"true","isVerified"=>$isVerified,"studentMessage"=>$studentMessage));
            }
        } catch (Exception $ex) {
            error_log("CommonController:actionVerifyStudentAccount::".$ex->getMessage());
            Yii::log("CommonController:actionVerifyStudentAccount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    
    public function actionprocessPictocv() {
        try {
            echo "In process picto cv";
            echo '<pre>' . print_r(json_decode(file_get_contents("php://input")), 1) . '</pre>';

            $folder = Yii::app()->params['WebrootPath'] . Yii::app()->params['PictoCVImageSavePath'];
            error_log($folder . "**********Folder");
            echo $folder;

            //         print_r($_REQUEST['Response'],true);
//            $pictoCVResponse = array(
//                "Opportunities" => array(
//                    array("OpportunityType" => "News",
//                        "ImageURL" => "https://skiptadiabetes.com/images/system/logo.png"),
//                    array("OpportunityType" => "Search",
//                        "ImageURL" => "https://skiptadiabetes.com/images/system/slide_1.jpg"),
//                ),
//                "Id" => "5538c947c95dbbd80b8b4569",
//                "UserId" => 1,
//            );

            //echo print_r($_POST,true);
            echo "Before Picto Respnse data******************";
            error_log(file_get_contents("php://input"));
            $data = json_decode(file_get_contents("php://input"));

           // error_log(print_r($data, true));
            PictocvCollection::model()->savePictoCVObjectTest($data);
            
            if (isset($data->pictoResponse) && $data->pictoResponse != "") {
             
                $pictoCVResponse = $data->pictoResponse;
                  error_log( "Request******* Id" . $pictoCVResponse->RequestId);
                   if (isset($pictoCVResponse->RequestId) && $pictoCVResponse->RequestId != "") {
                $pictoOb = PictocvCollection::model()->getPictocvCollectionByRequest($pictoCVResponse->RequestId);
                // echo print_r($pictoOb,true);
                $pictoCVOpportunities = $pictoCVResponse->Opportunities;
                foreach ($pictoCVOpportunities as $opportunity) {

                    $imagePath = $opportunity->ImageURL;
                    $pictoImage = split("/", $imagePath);
                    $folder = Yii::app()->params['WebrootPath'] . Yii::app()->params['PictoCVImageSavePath'];

                    $webroot = Yii::app()->params['WebrootPath'];
                    if (!file_exists($folder)) {
                        mkdir($folder, 0755, true);
                    }
                    //echo "Test for ".print_r($pictoOb,true);  
                    error_log( $pictoImage[sizeof($pictoImage) - 1]);
                    $spiltImage=split("_",$pictoImage[sizeof($pictoImage) - 1]);
                   
                   
                    $image=trim($spiltImage[1]);
                   
                    $destPath=Yii::app()->params['PictoCVImageSavePath'] . "" . $pictoOb->UserId . "_" .$image;
                    error_log("________Destination Path".$destPath);
                    CommonUtility::getImageFromURL($imagePath, $destPath);
                    PictocvCollection::model()->updatePictoCVCollectionByRequest($pictoCVResponse->RequestId, "ImageUrl", Yii::app()->params['PictoCVImageSavePath'] . "/" . $pictoOb->UserId . "_" . $spiltImage[1], $opportunity->OpportunityType);
                    PictocvCollection::model()->updatePictoCVCollectionByRequest($pictoCVResponse->RequestId, "RequestStatus", 2, $opportunity->OpportunityType);

                    //Here need to write the code of updating the status based on  the requestId and UserId in the PictoCV collection
                    $obj = array("status" => "success", 'Message' => "Response Recieved");
                }
               
                }
                 else {
                     $obj = array('status' => 'failure', 'data' => array("Response" => array()), 'error' => '', 'Message' => 'No response');
                }
            } else {
                $obj = array('status' => 'failure', 'data' => array("Response" => array()), 'error' => '', 'Message' => 'No response');
            }


            echo json_encode($obj);
        } catch (Exception $ex) {
            error_log("______^^^^^^^^^^^^^^______________exception changees" . $ex->getMessage());
        }
    }

    public function actionGetPictocvImagesByOppertunityType() {
         try{
             $opportunityType = $_REQUEST["oppertunityType"];
             $partialViewPath = $_REQUEST["partialViewPath"];
             $userId = (int)$this->tinyObject['UserId'];
             $pictocvArray = PictocvCollection::model()->getPictocvObjectByOppertunity($userId, $opportunityType);
             if($pictocvArray!="failure"){
                $tinyUser = UserCollection::model()->getTinyUserCollection((int) $userId);
                $controller = new CController('post');
                $resultantPreparedHtml = $controller->renderInternal(Yii::app()->basePath .$partialViewPath,  array("pictocvArray" => $pictocvArray,"userId"=>$userId), 1);
                echo $resultantPreparedHtml;
             }else{
                echo "";
             }
         } catch (Exception $ex) {
            Yii::log("NComCommand:getPictocvImages::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
         }
     }
     
     public function actionProcessskipta()
     {
         try {
             echo "Test in process skipta";
             echo print_r($_POST,true);
             
         } catch (Exception $ex) {
             
         }
     }
    
}
