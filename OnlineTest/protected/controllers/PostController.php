<?php

/**
 * Developer Name: Suresh Reddy
 * Post Controller  class,  all post module realted actions here 
 * 
 */
class PostController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function init() {
        try{
        if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
             parent::init();
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            CommonUtility::reloadUserPrivilegeAndData($this->tinyObject->UserId);
            $this->userPrivileges = Yii::app()->session['UserPrivileges'];
            $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
            $this->whichmenuactive = 1;
        } else { 
                $urlPath = $_SERVER['REQUEST_URI'];
               $urlArr = explode("/", $urlPath); 
               $foundText = strstr($urlArr[2], 'postdetail');
               if (isset($urlArr[2]) && !empty($foundText)) {
                   $queryStringURl = explode("?", $urlArr[2]);

                if(isset($queryStringURl[0]) && $queryStringURl[0] == "postdetail"){   
                 $this->redirect('/common/postdetail?postId='.$_REQUEST['postId'].'&categoryType='.$_REQUEST['categoryType'].'&postType='.$_REQUEST['postType'].'&trfid=1');
                 }
               }
               else{
                    parent::init();
               $this->redirect('/');
               }
        }
        $this->sidelayout = 'yes';
        } catch (Exception $ex) {
            Yii::log("PostController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
/**
 * suresh reddy here
 */
     public function actionError(){
         try{
           $cs = Yii::app()->getClientScript();
           $baseUrl=Yii::app()->baseUrl; 
           $cs->registerCssFile($baseUrl.'/css/error.css');
               if($error=Yii::app()->errorHandler->error)
               {        
                   $this->render('error', $error);
               }
    }catch(Exception $ex){
            Yii::log("PostController:actionError::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}
    public function actionIndex() {    
        try{ 
         // 'translate_follow'=>Yii::t('translation','Follow')  

            
//        ServiceFactory::getSkiptaPostServiceInstance()->saveUserCVPublicationCollection($this->tinyObject['UserId'],"Publications,Education");//save or update
        $normalPostModel = new NormalPostForm();
        $userPrivilege = $this->userPrivilegeObject;       
        $showPostOption = ($this->userPrivilegeObject->canSurvey == 1 || $this->userPrivilegeObject->canEvent == 1) ? 1 : 0;        
        $this->render('index', array('normalPostModel' => $normalPostModel, 'canManageFlaggedPost' => $userPrivilege->canManageFlaggedPost, 'featuredItems' => $featuredItems, 'canFeatured' => $userPrivilege->canFeature, 'showPostOption' => $showPostOption, 'userHierarchy'=>Yii::app()->session['UserHierarchy']));
        
        }catch(Exception $ex){
           Yii::log("PostController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Haribabu
     *  This  method is used for  upload the artifacts and save different folders based on type of file uploaded.
     */
    public function actionUpload() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            //  $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'];
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "exe", "mov", "mp4", "mp3", "txt", "doc", "docx", "pptx", "xlsx", "pdf", "ppt", "xls", "3gp", "php", "ini", "avi", "rar", "zip", "png", "tiff","TIF","tif"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //$sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
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
            Yii::log("PostController:actionUpload::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * This  method is used for  remove the upload the artifacts .
     */
    public function actionRemoveArtifacts() {

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
            Yii::log("PostController:actionRemoveArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @Author Haribabu
     * This  method is used for  save the new post with artifacts in array format and save the artifacts in resouces object.
     */
    public function actionCreatePost() {

        $normalPostModel = new NormalPostForm();
        $errormessage = "";
        try {
            $obj = array();
            $hashTagArray = array();
            $atMentionArray = array();
            $SurveyQuestionOptions = array();
            if (isset($_POST['NormalPostForm'])) {
                $normalPostModel->attributes = $_POST['NormalPostForm'];
                $errors = CActiveForm::validate($normalPostModel);
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    if ($normalPostModel->Type == "") {
                        $normalPostModel->Type = "Normal Post";
                    } else {
                        $normalPostModel->Type = $normalPostModel->Type;
                    }
                    if (trim($normalPostModel->Type) == "Event") {
                        if ($normalPostModel->StartDate == "" || $normalPostModel->EndDate == "") {
                            $errormessage = Yii::t('translation', 'EventPost_Error_Message');
                        } else {
                            $normalPostModel->StartDate = $normalPostModel->StartDate;
                            $normalPostModel->EndDate = $normalPostModel->EndDate;
                            $normalPostModel->StartTime = $normalPostModel->StartTime;
                            $normalPostModel->EndTime = $normalPostModel->EndTime;
                            $normalPostModel->Location = $normalPostModel->Location;

                            $eventstarttime = explode(" ", $normalPostModel->StartTime);
                            $eventendtime = explode(" ", $normalPostModel->EndTime);
                            $starttime = trim(strtotime($normalPostModel->StartTime));
                            $endtime = trim(strtotime($normalPostModel->EndTime));
                            $startdate = trim(strtotime($normalPostModel->StartDate));
                            $enddate = trim(strtotime($normalPostModel->EndDate));
                            $startDateTime =  $normalPostModel->StartDate." ".$normalPostModel->StartTime;
                            $endDateTime =  $normalPostModel->EndDate." ".$normalPostModel->EndTime;
                            $startEndTime =  $normalPostModel->StartDate." ".$normalPostModel->EndTime;
                            $startDateTime = CommonUtility::convert_time_zone(strtotime($startDateTime),date_default_timezone_get(),Yii::app()->session['timezone']);
                            $endDateTime =  CommonUtility::convert_time_zone(strtotime($endDateTime),date_default_timezone_get(),Yii::app()->session['timezone']);             
                            $startEndTime =  CommonUtility::convert_time_zone(strtotime($startEndTime),date_default_timezone_get(),Yii::app()->session['timezone']);             
                            $currentTime=  CommonUtility::currentSpecifictime_timezone(date_default_timezone_get());
                            if ($starttime == "" && $endtime != "") {
                                $errormessage = Yii::t('translation', 'EventPost_Starttime_Error_Message');
                            } else if ($starttime != "" && $endtime == "") {
                                $errormessage = Yii::t('translation', 'EventPost_Endtime_Error_Message');
                            } else if ($starttime!="" && $endtime!="" && strtotime ($startDateTime) >= strtotime ($startEndTime)) {
                                $errormessage = Yii::t('translation', 'EventPost_time_Error_Message');

//                            }else if (($startdate == $enddate) && ($starttime != "" && $endtime != "") && ($starttime < $currentTime)) {
//                                $errormessage = Yii::t('translation', 'EventPost_Start_time_Error_Message');
//                            }
                            }else if ($starttime!="" && $endtime!="" && strtotime ($startDateTime) < $currentTime) {

                                $errormessage = Yii::t('translation', 'EventPost_Start_time_Error_Message');
                            }
                        }
                    }
                    if ($normalPostModel->Type == "Survey") {
                        $normalPostModel->OptionOne = $normalPostModel->OptionOne;
                        $normalPostModel->OptionTwo = $normalPostModel->OptionTwo;
                        $normalPostModel->OptionThree = $normalPostModel->OptionThree;
                        $normalPostModel->OptionFour = $normalPostModel->OptionFour;
                        $normalPostModel->ExpiryDate = $normalPostModel->ExpiryDate;
                        $normalPostModel->Status = 1;

                        $Optionsarray = array(trim($normalPostModel->OptionOne), trim($normalPostModel->OptionTwo), trim($normalPostModel->OptionThree), trim($normalPostModel->OptionFour));

                        $counts = array_count_values($Optionsarray);
                        foreach ($counts as $name => $count) {
                            if ($count > 1) {
                                $errormessage = Yii::t('translation', 'SurveyPost_Options_Error_Message');
                            }
                        }
                    }
                    $normalPostModel->Type = $normalPostModel->Type;
                    $normalPostModel->PostedBy = $this->tinyObject['UserId'];
                    $normalPostModel->UserId = $this->tinyObject['UserId'];
                    $normalPostModel->NetworkId = $this->tinyObject['NetworkId'];
                    $hashTagArray = CommonUtility::prepareHashTagsArray($normalPostModel->HashTags);
                    $atMentionArray = CommonUtility::prepareAtMentionsArray($normalPostModel->Mentions);
                    $normalPostModel->Mentions = $atMentionArray;
                    $normalPostModel->Location = $normalPostModel->Location;
                    $artifacts = $normalPostModel->Artifacts;
                    $Artifactslengh = strlen($normalPostModel->Artifacts);
                    if ($Artifactslengh > 0) {

                        $normalPostModel->Artifacts = explode(",", $normalPostModel->Artifacts);
                    } else {
                        $normalPostModel->Artifacts = array();
                    }

                    if ($errormessage != "") {
                        $Message = array('NormalPostForm_Description' => $errormessage);
                        if ($normalPostModel->Type == "Event") {
                            if ($endtime == "") {
                                $Message = array('NormalPostForm_EndTime' => $errormessage);
                            } else {
                                $Message = array('NormalPostForm_StartTime' => $errormessage);
                            }
                        }
                        if ($normalPostModel->Type == "Survey") {
                            $Message = array('NormalPostForm_Survey_Options' => $errormessage);
                        }
                        $obj = array("status" => 'error', 'data' => '', "error" => $Message);
                    } else {
                        $postObj = ServiceFactory::getSkiptaPostServiceInstance()->savePost($normalPostModel, $hashTagArray);

                        if ($postObj != 'failure') {
                            $message = Yii::t('translation', 'NormalPost_Saving_Success');
                            if ((int)$normalPostModel->Type == 2) {
                                $message = Yii::t('translation', 'EventPost_Saving_Success');
                            }else if ((int)$normalPostModel->Type == 3) {
                                $message = Yii::t('translation', 'SurveyPost_Saving_Success');
                            }
                            $obj = array('status' => 'success', 'data' => $message, 'success' => '');
                        } else {
                            $message = Yii::t('translation', 'NormalPost_Saving_Fail');
                            $errorMessage = array('NormalPostForm_Description' => $message);
                            $obj = array("status" => 'error', 'data' => $message, "error" => $errorMessage);
                        }
                    }
                }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            } else {
                $this->render('index', array('normalPostModel' => $normalPostModel));
            }
        } catch (Exception $ex) {
            Yii::log("PostController:actionCreatePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $id = "NormalPostForm_Description";
            $translation = "NormalPost_Saving_Fail";
            $this->throwErrorMessage($id,$translation);

        }
    }

  public function actionSnippetpriviewPage() {
        try {
            $text = trim($_POST['data']);
            $type=$_POST['Type'];
            if(isset($_POST['CommentId']) && $_POST['CommentId']!=""){
                $commentId=$_POST['CommentId'];
            }else{
                $commentId="";
            }

            $parsed = parse_url($text);
            if (empty($parsed['scheme'])) {
                $text = 'http://' . ltrim($text, '/');
            }

            $WeburlObj = ServiceFactory::getSkiptaPostServiceInstance()->CheckWebUrlExist($text);

            if($WeburlObj!='failure'){
                 $obj = array('status' => 'success', 'snippetdata' => $WeburlObj,'type'=>$type,'CommentId'=>$commentId);
            }else{

                $decode=array();
                 $options = array( 
                    CURLOPT_RETURNTRANSFER => true,     // return web page 
                    CURLOPT_HEADER         => false,    // do not return headers 
                    CURLOPT_FOLLOWLOCATION => true,     // follow redirects 
                    CURLOPT_USERAGENT      => "spider", // who am i 
                    CURLOPT_AUTOREFERER    => true,     // set referer on redirect 
                    CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect 
                    CURLOPT_TIMEOUT        => 120,      // timeout on response 
                    CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects 
                ); 
                $ch      = curl_init( $text ); 
                curl_setopt_array( $ch, $options ); 
                $content = curl_exec( $ch ); 
                $err     = curl_errno( $ch ); 
                $errmsg  = curl_error( $ch ); 
                $header  = curl_getinfo( $ch ); 
                curl_close( $ch ); 
                
               if (strlen($content) == 0) {
                    $Linkcontent = file_get_contents($text);
                    if (strlen($Linkcontent) != 0) {
                        $Sdata = $this->file_get_contents_curl($Linkcontent, $text);
                        $decode = $Sdata;
                    } else {
                        $decode['provider_url'] = $parsed['host'];
                        $decode['description'] = "";
                        $decode['title'] = "";
                    }
                } else {
                    $weburl = urlencode($header['url']);
                    $url = "https://api.embed.ly/1/oembed?key=a8d760462b7c4e4cbfc9d6cb2b5c3418&url=" . $weburl;
                    $details = @file_get_contents($url);
                    $decode = CJSON::decode($details);
                    if (!is_array($decode) && !count($decode) > 0) {
                        $Sdata = $this->file_get_contents_curl($content, $text);
                        $decode = $Sdata;
                    } else {
                        if (!isset($decode['descritpion']) || !isset($decode['title'])) {
                            $Sdata = $this->file_get_contents_curl($content, $text);
                            $decode = $Sdata;
                        }
                    }
                }


                $SnippetObj = ServiceFactory::getSkiptaPostServiceInstance()->SaveWebSnippet($text, $decode);
                $SnippetObj->Weburl=trim($text);
                $pattern = '~(?><(p|span|div)\b[^>]*+>(?>\s++|&nbsp;)*</\1>|<br/?+>|&nbsp;|\s++)+$~i';
                $SnippetObj->WebTitle = preg_replace($pattern, '', $SnippetObj->WebTitle); 
                $SnippetObj->WebLink = preg_replace($pattern, '', $SnippetObj->WebLink);
                $obj = array('status' => 'success', 'snippetdata' => $SnippetObj,'type'=>$type,'CommentId'=>$commentId);
            }
            
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("PostController:actionSnippetpriviewPage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
 /**
     * @Author Haribabu
     * This  method is used get web preview details using CURL.
     */
function file_get_contents_curl($content,$text){ 
    try{
    $Snippetdata=array();
                    $doc = new DOMDocument();
                    @$doc->loadHTML($content);
                    $nodes = $doc->getElementsByTagName('title');
                    $base_url = substr($text,0, strpos($text, "/",8));
                    $relative_url = substr($text,0, strrpos($text, "/")+1);

                    $sourceUrl = parse_url($text);
                    $sourceUrl = $sourceUrl['host'];
                    //get and display what you need:
                    $Previewtitle = $nodes->item(0)->nodeValue;
                    $metas = $doc->getElementsByTagName('meta');
                    $paras = $doc->getElementsByTagName('p');
                    $PreviewDescription = $paras->item(0)->nodeValue;
                    for ($i = 0; $i < $metas->length; $i++)
                    {
                        
                        $meta = $metas->item($i);
                        if($meta->getAttribute('property')=='og:image'){
                            $previewImage=$meta->getAttribute('content');
                        }
                        if($meta->getAttribute('property')=='og:description'){
                            $previewDescription=$meta->getAttribute('content');
                        }

                        if($meta->getAttribute('name') == 'description')
                        $description = $meta->getAttribute('content');
                       
                    }
                     if($previewDescription==""){
                        $previewDescription=$description;
                    }
                      if($previewImage!=""){
                           $previewImageArray=  explode('/',$previewImage);
                                if (preg_match('/\.(jpg|png|gif|bmp|jpeg|tiff)$/i', end($previewImageArray))) {
                                    $previewImage=$previewImage;
                                }else{
                                    $previewImage="";
                                }
                      }
                    //fetch images
                   
                     if($previewImage==""){
                       $image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
                        preg_match_all($image_regex, $content, $img, PREG_PATTERN_ORDER);
                        $pimages=array();
                        $pAllimages=array();
                        foreach ($img[1] as $key => $value) {
                             $imageArray=  explode('/',$value);
                                if (preg_match('/\.(jpg|png|gif|bmp|jpeg|tiff)$/i', end($imageArray))) {
                                    if (preg_match("/logo/i", $value)) {
                                          if(!preg_match("~^(?:f|ht)tps?://~i", $value)){
                                              $value=!empty($base_url)?$base_url.$value:$text.$value;
                                                   //$value=$base_url.$value;
                                           }
                                        array_push($pimages, $value);
                                    }else if(preg_match("~^(?:f|ht)tps?://~i", $value)){
                                        array_push($pAllimages, $value);
                                    }
                                    
                                }
                        }
                        if(sizeof($pimages)>0){
                             $previewImage=  $pimages[0];
                        }else{
                             $previewImage=  $pAllimages[0];
                        }
                    }
                   $Snippetdata['provider_url']=$text;
                   if($previewDescription){
                      $Snippetdata['description']=$previewDescription;          
                   }else{
                       $Snippetdata['description']=$PreviewDescription; 
                   }
                    
                   $Snippetdata['title']=$Previewtitle; 
                   $Snippetdata['thumbnail_url']=$previewImage; 
                   return $Snippetdata;
                   } catch (Exception $ex) {
            Yii::log("PostController:file_get_contents_curl::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}

    /**
     * @Author Sagar Pathapelli
     * This method is used to get the hashtags, It will search by 'HashTagName'.
     * @param: 'searchkey' is the string.
     */
    public function actionGetHashTagsBySearchKey() {
        try {
            $result = array();
            if (isset($_REQUEST['searchkey'])) {
                $searchKey = $_REQUEST['searchkey'];
                $hashtagArray = isset($_REQUEST['existingHashtags']) ? json_decode($_REQUEST['existingHashtags']) : array();
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getHashTagsBySearchKey($searchKey, $hashtagArray);
            }
             $obj = $this->rendering($result);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetHashTagsBySearchKey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @Author Sagar Pathapelli
     * This method is used to get the user followers and following users list, It will search by 'Email'.
     * @param: 'searchkey' is the string.
     */
    public function actionGetUserFollowingAndFollowers() {
        try {
            $result = array();
            if (isset($_REQUEST['searchkey'])) {

                $searchKey = $_REQUEST['searchkey'];
                $mentionArray = isset($_REQUEST['existingUsers']) ? json_decode($_REQUEST['existingUsers']) : array();

                $userId = $this->tinyObject['UserId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getFollowingFollowerUsers($searchKey, $userId, $mentionArray);
            }
            $obj = $this->rendering($result);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetUserFollowingAndFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @Author Sagar Pathapelli
     * This method is used get the tiny user collection for network
     * @return type
     */
    public function actionGetNetworkUsers() {
       try {
           $result = array();
           if (isset($_REQUEST['searchKey'])) {
               $searchKey = $_REQUEST['searchKey'];
               $networkId = $this->tinyObject['NetworkId'];
               $userId = $this->tinyObject['UserId'];
               $mentionArray = isset($_REQUEST['existingUsers']) ? json_decode($_REQUEST['existingUsers']) : array();
               array_push($mentionArray, $userId);
               $result = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollectionForNetworkBySearchKey($networkId, $searchKey, $mentionArray);
           }
            $obj = $this->rendering($result);
           echo $obj;
       } catch (Exception $ex) {
           Yii::log("PostController:actionGetNetworkUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
   }

    /**
     * @author karteek.v
     * ActionUserFollowPost is used either follow or unfollow a post by a user
     * return type json object
     */
    public function actionUserFollowPost() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postType']) && isset($_REQUEST['postId']) && isset($_REQUEST['actionType'])) {
                $UserId =  $this->tinyObject->UserId;
                $UserClassification = 1;
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToPost($_REQUEST['postType'], $_REQUEST['postId'], $UserId, $_REQUEST['actionType'], $_REQUEST['categoryType']);
            }
            if($result == "failure"){
                throw new Exception('Unable to follow or unfollow');
            }
            $obj = array("status" => $result, "data" => "", "error" => "",'translate_follow'=>Yii::t('translation','Follow'),'translate_unFollow'=>Yii::t('translation','UnFollow'));
             echo $this->rendering($obj);
        } catch (Exception $ex) {
            Yii::log("PostController:actionUserFollowPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
              $id = "socialactionsError_".$_REQUEST['postId'];
             $actionType =  $_REQUEST['actionType'];
           if($actionType == "Follow"){
               $translation = "Follow_Action_Fail"; 
           }else{
                $translation = "UnFollow_Action_Fail";
        }
           
            $this->throwErrorMessage($id,$translation);
    }

    }

    /**
     * @author Karteek.v
     * actionUserLoveToPost is used to like a post by user
     * return type json object
     */
    public function actionUserLoveToPost() {
        try {
            //throw new Exception('Unable to save love');
            $result = FALSE;            
            if (isset($_REQUEST['postType']) && isset($_REQUEST['postId'])) {
                $UserId =  $this->tinyObject->UserId;
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveLoveToPost($_REQUEST['postType'], $_REQUEST['postId'], $UserId, $_REQUEST['categoryType']);
            }
            if($result==TRUE){
            $obj = array("status" => $result, "data" => "", "error" => "");
            }else{
                throw new Exception('Unable to save love');
            }
            echo $this->rendering($obj);
        } catch (Exception $ex) {
            Yii::log("PostController:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $id = "socialactionsError_".$_REQUEST['postId'];
           error_log("Exception Occurred in PostController->actionUserLoveToPost==".$ex->getMessage());
            $translation = "Love_Action_Fail";
            $this->throwErrorMessage($id,$translation);
            return;
        }
       
    }

    /**
     * @Author Karteek
     * This method is to save comment
     * @return type Json object
     */
    public function actionSavePostComment() {
        $obj=array();
      
        try {//throw new Exception('Division by zero.');
            if (isset($_REQUEST['postid'])) {
                $streamId = $_REQUEST['streamid'];
                $commentBean = new CommentBean();
                $commentBean->PostId = $_REQUEST['postid'];
                $commentBean->CommentText = $_REQUEST['comment'];
                $CategoryType = $_REQUEST['CategoryType'];                
                $PageType = $_REQUEST['pageType'];
                if (trim($_REQUEST['commentArtifacts']) == "") {

                    $commentBean->Artifacts = array();
                } else {
                    $commentBean->Artifacts = explode(",", $_REQUEST['commentArtifacts']);
                }
                $commentBean->PostType = $_REQUEST['type'];
                $commentBean->UserId = $this->tinyObject->UserId;
                //$commentBean->UserId = $this->tinyObject->UserId;
                $commenturls = array();
                $commenturls[0] = $_REQUEST['WebUrls'];
                $commentBean->WebUrls=$commenturls;
               // $commentBean->WebUrls = $_REQUEST['type'];
               if(isset($_REQUEST['IsWebSnippetExist'])){
                    $commentBean->IsWebSnippetExist = $_REQUEST['IsWebSnippetExist'];
               }
          
                $commentBean->HashTags = CommonUtility::prepareHashTagsArray($_REQUEST['hashTags']);
                $commentBean->Mentions = CommonUtility::prepareAtMentionsArray($_REQUEST['atMentions']);
                
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveComment($commentBean, (int) $_REQUEST['NetworkId'], (int)$CategoryType);
                
//                $comments = ServiceFactory::getSkiptaPostServiceInstance()->getCommentObject($commentBean->PostId,$CategoryType);                
               if($result=='Exception'){
                   throw new Exception('Unable to save commment');
               }
              else if(is_array($result)){
                    $commentUserBean = new CommentUserBean();
                    if (isset($result[0])) {
                        $commentUserBean->Resource = $result[0];
                    } else {
                        $commentUserBean->Resource = "";
                    }
                $userCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($commentBean->UserId);
                $commentUserBean->UserId = $userCollectionObj->UserId;
                $tagsFreeDescription= strip_tags(($commentBean->CommentText));
             $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
            $descriptionLength =  strlen($tagsFreeDescription);
                    if ($descriptionLength > 240) {

                        $postId = (isset($_REQUEST["postid"])) ? $_REQUEST["postid"] : '';
                        $PostType = (isset($_REQUEST["type"])) ? $_REQUEST["type"] : '';

                    $appendCommentData = ' <span class="postdetail"   data-id="'.$streamId.'" data-postid="' . $postId . '" data-categoryType="' . $CategoryType . '" data-postType="' . $PostType . '"> <i class="fa  moreicon moreiconcolor"> '.Yii::t('translation','Readmore').'</i></span>';
                     $stringArray = CommonUtility::truncateHtml($commentBean->CommentText, 240,'...',true,true,$appendCommentData);
                   // $stringArray = str_split($commentBean->CommentText, 240);
                        $text = $stringArray;
                        $commentBean->CommentText = $text;
                    } else {

                        $commentBean->CommentText = $commentBean->CommentText;
                    }
                    $commentUserBean->CommentText = $commentBean->CommentText;
                    // $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn->sec);
                     if(count($commenturls)>0){
                        $parsed = parse_url($commenturls[0]);
                        if (empty($parsed['scheme'])) {
                            $commenturls[0] = 'http://' . ltrim($commenturls[0], '/');
                        }
                        $weburls=explode('&nbsp',$commenturls[0]);
                        $commenturls[0]=$weburls[0];
                        
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
                    if(isset( $_REQUEST['IsWebSnippetExist'])){
                       $commentUserBean->IsWebSnippetExist = $_REQUEST['IsWebSnippetExist'];                        
                        $commentUserBean->CommentText = CommonUtility::findUrlInStringAndMakeLink($commentUserBean->CommentText);
                        
                    }else{
                         $commentUserBean->IsWebSnippetExist ="";
                    }
                   
                    $commentUserBean->DisplayName = $userCollectionObj->DisplayName;
                    $commentUserBean->ProfilePic = $userCollectionObj->profile70x70;
                    $commentUserBean->CategoryType = $CategoryType;
                    $commentUserBean->PostId = $_REQUEST["postid"];
                    $commentUserBean->Type = $_REQUEST["type"];
                    $commentUserBean->ResourceLength = sizeof($result)-1;                    
                    $commentUserBean->streamId = $streamId;
                    $profile = "/profile/".$userCollectionObj->uniqueHandle;
                    $commentUserBean->Profilename = $profile;
                    $obj = array("status" => "succes", "data" => $commentUserBean, "error" => "");
                } else if($result=='blocked'){
                    $obj = array("status" => "succes", "data" => "blocked", "error" => "");
                }
                
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in PostController->actionSavePostComment==".$ex->getMessage());
            Yii::log("PostController:actionSavePostComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           $id = "commenterror_".$_REQUEST['postid'];
          
            $translation = "Comment_Saving_Fail";
            $this->throwErrorMessage($id,$translation);
            return;
        }
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
//          $obj = $this->rendering($obj);
//            echo $obj;
//        if($PageType=="postDetailed" || $PageType=="GroupDetail"){
//            
//        }
            $this->renderPartial('groupcommentscript', array("comments" => $commentUserBean, "isBlocked" => $isblocked,"canMarkAsAbuse"=>$canMarkAsAbuse));
        }

    /**
     * @Author Sagar Pathapelli
     * This method is used GetHashTagProfile summary
     * @return type HashTagProfileBean 
     */
    public function actionGetHashTagProfile() {
        try {
            $result = array();
            if (isset($_REQUEST['hashTagName'])) {
                $hashTagName = $_REQUEST['hashTagName'];
                $userId = $this->tinyObject['UserId'];
                $hashtagSummery = ServiceFactory::getSkiptaPostServiceInstance()->getHashTagProfile($hashTagName, $userId);
                $result = $hashtagSummery;
            }
            $obj = array('status' => 'success', 'data' => $result, 'error' => '','translate_hashtagSummary'=>Yii::t('translation','HashtagSummary'));
            $obj = $this->rendering($obj);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetHashTagProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @Author Moin Hussain
     * This method is used actionTrackMinHashTagWindowOpen summary
     * @return type  
     */
    public function actionTrackMinHashTagWindowOpen() {
        try {
            $result = array();
            if (isset($_REQUEST['hashTagName'])) {
                $hashTagName = $_REQUEST['hashTagName'];
                $userId = $this->tinyObject['UserId'];
                $networkId = $this->tinyObject['NetworkId'];
                 ServiceFactory::getSkiptaPostServiceInstance()->trackMinHashTagWindowOpen($hashTagName, $userId,$networkId);
                
            }
            $obj = array('status' => 'success', 'data' => "", 'error' => '');
            $obj = $this->rendering($obj);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("PostController:actionTrackMinHashTagWindowOpen::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * This method is used to update the user follow/unfollow on hashtag
     * @param type $actionType (Follow/Unfollow)
     * @author Sagar Pathapelli
     */
    public function actionFollowOrUnfollowHashTag() {
        try {
            $result = "failure";
            if (isset($_REQUEST['actionType'])) {
                $actionType = $_REQUEST['actionType'];
                $hashTagId = $_REQUEST['hashTagId'];
                $userId = $this->tinyObject->UserId;
                //$userId = $this->tinyObject['UserId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->followOrUnfollowHashTag($hashTagId, $userId, $actionType);
            }
            if($result == "failure"){
                throw new Exception('Unable to follow or unfollow');
               }
            $obj = array('status' => 'success', 'data' => $result, 'error' => '','translate_follow'=>Yii::t('translation','Follow'),'translate_unFollow'=>Yii::t('translation','UnFollow'));
            echo $this->rendering($obj);
        } catch (Exception $ex) {
            Yii::log("PostController:actionFollowOrUnfollowHashTag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $id = "socialactionsError_".$_REQUEST['hashTagId'];
             $actionType =  $_REQUEST['actionType'];
           error_log("Exception Occurred in PostController->actionFollowOrUnfollowHashTag==".$ex->getMessage());
           if($actionType == "Follow"){
               $translation = "Follow_Action_Fail"; 
           }else{
                $translation = "UnFollow_Action_Fail";
        }
           
            $this->throwErrorMessage($id,$translation);
    }
    }

    /**
     * @author: sagar
     * actionAttendEvent is used to store the event attendees details
     * request an PostId
     * returns 
     */
    public function actionAttendEvent() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postId'])) {
                $postId = $_REQUEST['postId'];
                $actionType = $_REQUEST['actionType'];
                $userId = $this->tinyObject->UserId;
                //$userId = $this->tinyObject['UserId'];
                $categoryType = $_REQUEST['categoryType'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveOrRemoveEventAttende($postId, $userId, $actionType, $categoryType);
            }

            $obj = array('status' => 'success', 'data' => $result, 'error' => '');
              $obj = $this->rendering($obj);
            echo $obj;
        } catch (Exception $ex) {
           Yii::log("PostController:actionAttendEvent::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar
     * This method is to save invites
     * @return type Json object
     */
    public function actionSaveInvites() {
        try {
            if (isset($_REQUEST['postId'])) {
                $result = "failure";
                $PostId = $_REQUEST['postId'];
                $InviteText = $_REQUEST['inviteText'];
                $networkId = $_REQUEST['networkId'];
                $userId = $this->tinyObject->UserId;
                //$userId = $this->tinyObject['UserId'];
                $categoryType = $_REQUEST['categoryType'];
                $Mentions = CommonUtility::prepareAtMentionsArray($_REQUEST['atMentions']);
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveInvites($userId, $PostId, $InviteText, $Mentions, $networkId, $categoryType);
                if($result == "success"){
                $obj = array("status" => "success", "data" => $result, "error" => "");
 
               }else{
                
                    throw new Exception('Unable to Invite');
            }
            }
        echo $this->rendering($obj);
        } catch (Exception $ex) {
            Yii::log("PostController:actionSaveInvites::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
               $id = "inviteTextAreaError_".$_REQUEST['postId'];
               error_log("Exception Occurred in PostController->actionSaveInvites==".$ex->getMessage());
               $translation = "Invite_Action_Fail"; 
               $this->throwErrorMessage($id,$translation);
        }
      
    }

    /**
     * @author Sagar
     * This method is to submit survey
     * @param postId
     * @param networkId
     * @param categoryType
     */
    public function actionSubmitSurvey() {
        try {
            if (isset($_REQUEST['postId'])) {
                $result = "failure";
                $PostId = $_REQUEST['postId'];
                $Option = $_REQUEST['option'];
                $NetworkId = $_REQUEST['networkId'];
                $UserId = $this->tinyObject->UserId;
                //$UserId = $this->tinyObject['UserId'];
                $CategoryType = $_REQUEST['categoryType'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->submitSurvey($UserId, $PostId, $Option, $NetworkId, $CategoryType);
                if($result == "failure"){
                   throw new Exception('Unable to submit survey');
                }
                $obj = array("status" => "success", "data" => $result, "error" => "");
            }
             echo $this->rendering($obj);
        } catch (Exception $ex) {
            Yii::log("PostController:actionSubmitSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $id = "surveyError_".$_REQUEST['postId'];
               error_log("Exception Occurred in PostController->actionSubmitSurvey==".$ex->getMessage());
               $translation = "Survey_Submit_Fail"; 
               $this->throwErrorMessage($id,$translation);
        }
       
    }

     /**
     * @author Sagar
     * This method is to get the stream details
     */
    public function actionStream() {
        try {
            if (isset($_GET['StreamPostDisplayBean_page'])) {
                $networkId = (int) $this->tinyObject['NetworkId'];
                $networkIds = array($networkId);
                //$networkIds = array_map('intval', $networkIds);
                $groupsfollowing = array();
                $totalStreamIdArray = array();
                $streamIdArray = array();
                $previousStreamIdArray = array();
                $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
                if(!empty($previousStreamIdString)){
                    $previousStreamIdArray = explode(",", $previousStreamIdString);
                }
                $timezone = $_REQUEST['timezone'];
                if (isset($_GET['filterString'])) {
                    if($_GET['filterString']=='Division'){
                        $condition = array(
                            'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                            'IsDeleted' =>  array('notIn' => array(1, 2)),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Division' =>  array('==' => (int)(Yii::app()->session['UserHierarchy']['Division'])),
                            'IsNotifiable' => array('==' => (int)1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if($_GET['filterString']=='District'){
                        $condition = array(
                            'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                            'IsDeleted' =>  array('notIn' => array(1, 2)),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'District' => array('==' => (int)(Yii::app()->session['UserHierarchy']['District'])),
                            'IsNotifiable' => array('==' => (int)1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if($_GET['filterString']=='Region'){
                        $condition = array(
                            'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                           'IsDeleted' =>  array('notIn' => array(1, 2)),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Region' => array('==' => (int)(Yii::app()->session['UserHierarchy']['Region'])),
                            'IsNotifiable' => array('==' => (int)1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if($_GET['filterString']=='Store'){
                        $condition = array(
                            'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                            'IsDeleted' =>  array('notIn' => array(1, 2)),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Store' => array('==' => (int)(Yii::app()->session['UserHierarchy']['Store'])),
                            'IsNotifiable' => array('==' => (int)1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if($_GET['filterString']=='Corporate'){
                        $condition = array(
                            'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                            'IsDeleted' =>  array('notIn' => array(1, 2)),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Division' => array('==' => 0),
                            'District' => array('==' => 0),
                            'Region' => array('==' => 0),
                            'Store' => array('==' => 0),
                            'IsNotifiable' => array('==' => (int)1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }
                } else {
                   $groupsfollowing = ServiceFactory::getSkiptaPostServiceInstance()->getUserFollowingGroupsIDs((int)$this->tinyObject['UserId']);
                    array_push($groupsfollowing,'');
                    
                }
                
                $pageSize = 10;
                $mongoCriteria = new EMongoCriteria;
                $orCondition=array('$or' =>[array('UserId' => (int)$this->tinyObject['UserId']),array('UserId' => 0,'SegmentId' =>  array('$in'=>array((int) $this->tinyObject['SegmentId'],0)), )],
                    );
                if(trim($this->tinyObject['Language'])!="en"){
                    array_push($orCondition['$or'], array("Language"=>$this->tinyObject['Language']));
                }
                $mongoCriteria->setConditions($orCondition);
                
               
                
                $mongoCriteria->GroupId('in', $groupsfollowing);
                $mongoCriteria->IsDeleted('==', 0);
                $mongoCriteria->IsBlockedWordExist('notIn', array(1, 2));
                $mongoCriteria->IsAbused('notIn', array(1, 2));
                $mongoCriteria->CategoryType('notIn', array(7,13,14,15));
                $mongoCriteria->IsNotifiable('==', 1);
                 $mongoCriteria->sort('IsPromoted', EMongoCriteria::SORT_DESC);
                 $mongoCriteria->sort('IsSaveItForLater', EMongoCriteria::SORT_DESC);
                $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => $mongoCriteria,
                        
                ));
                
                if ($provider->getTotalItemCount() == 0) {                   
                    
                    $stream = 0; //No posts
                } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $pageNo = $_GET['StreamPostDisplayBean_page'];
                    $UserId =  $this->tinyObject['UserId'];
                    $dataArray = array_merge($provider->getData(), $this->getDerivateObjectsStream($UserId));
                    $adProvider = $this->getStreamAds($_GET['StreamPostDisplayBean_page'],$previousStreamIdArray);
                    $adData = $adProvider->getData();
                    $dataArray = array_merge($dataArray,$adData);
                    
                    if($pageNo == 1)
                       $dataArray = $this->constructPriorityWiseArray($dataArray);                       
                    $streamRes = (object) (CommonUtility::prepareStreamData($UserId,$dataArray, $this->userPrivileges, 1, Yii::app()->session['PostAsNetwork'],$timezone, $previousStreamIdArray));
                    $streamIdArray=$streamRes->streamIdArray;
                    $totalStreamIdArray=$streamRes->totalStreamIdArray;
                        $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                        $streamIdArray = array_values(array_unique($streamIdArray));
                        $stream = (object) ($streamRes->streamPostData);
                         if (sizeof($streamRes->streamPostData) == 0) {
                        $stream = -2;
                    }
                    if (sizeof($provider->getData()) == 0) {
                        $stream = -1;
                    }
                } else {
                    $stream = -1; //No more posts
                }
                $streamData = $this->renderPartial('stream_view', array('stream' => $stream, 'streamIdArray'=>$streamIdArray,'totalStreamIdArray'=>$totalStreamIdArray,'userLanguage'=>Yii::app()->session['language'],'pageNo'=>$_GET['StreamPostDisplayBean_page']), true);
                $streamIdString = implode(',', $streamIdArray);
                echo $streamData."[[{{BREAK}}]]".$streamIdString;
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in PostController->actionStream==". $ex->getMessage());
            Yii::log("PostController:actionStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function constructPriorityWiseArray($dataAr){
        try{
            $promoteAr = $saveItLaterAr = $premiumAdAr = $alldataAr = array();
            foreach($dataAr as $data){
                
                if(isset($data->IsPromoted) && $data->IsPromoted == 1){
                    array_push($promoteAr,$data);
                }else if(isset($data->IsSaveItForLater) && $data->IsSaveItForLater == 1){
                    array_push($saveItLaterAr,$data);
                }else if(isset($data->IsPremiumAd) && $data->IsPremiumAd == 1){                    
                    array_push($premiumAdAr,$data);
                }else{
                    array_push($alldataAr,$data);                    
                }
            }
            return array_merge($promoteAr,$saveItLaterAr,$premiumAdAr,$alldataAr);
        }catch(Exception $ex){
            error_log("Exception Occurred in PostController->constructPriorityWiseArray==". $ex->getMessage());
            Yii::log("PostController:constructPriorityWiseArray::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getStreamAds($pageNo,$previousStreamIdArray){
        try{
            
            if($pageNo==1){
            $provider= $this->getPremiumStreamAds();   
            }
            else{
                $_GET['StreamPostDisplayBean_page']--;
             
                 $pageSize = 1;
                $mongoCriteria = new EMongoCriteria;
                $orCondition=array('$or' =>[array('UserId' => (int)$this->tinyObject['UserId']),array('UserId' => 0,'SegmentId' =>  array('$in'=>array((int) $this->tinyObject['SegmentId'],0)), )],
                    );
                if(trim($this->tinyObject['Language'])!="en"){
                    array_push($orCondition['$or'], array("Language"=>$this->tinyObject['Language']));                }
                $mongoCriteria->setConditions($orCondition);                
                $pLastStreamId = $previousStreamIdArray[sizeof($previousStreamIdArray)-1];
                
                $mongoCriteria->IsDeleted('==', 0);
                $mongoCriteria->IsBlockedWordExist('notIn', array(1, 2));
                $mongoCriteria->CategoryType('==', (int) 13);
                $mongoCriteria->IsNotifiable('==', (int) 1);    
                 $mongoCriteria->IsPremiumAd('==', 0);
              
               
                $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => $mongoCriteria,
                        
                ));
            }
               
                error_log("pageNo = $pageNo =!!!!!!!!!!!!!!!!=Ads=get total size of items====".$provider->getTotalItemCount());
              
                // echo "<br/>===112222222222222222222221 sizeof Ads ===".$provider->getTotalItemCount()."<br/>";
                return $provider;
        } catch (Exception $ex) {
            error_log("Exception Occurred in PostController->getStreamAds==". $ex->getTraceAsString());
            Yii::log("PostController:getStreamAds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function getPremiumStreamAds(){
        try{
                $pageSize = 1;
                $mongoCriteria = new EMongoCriteria;
                $orCondition=array('$or' =>[array('UserId' => (int)$this->tinyObject['UserId']),array('UserId' => 0,'SegmentId' =>  array('$in'=>array((int) $this->tinyObject['SegmentId'],0)), )],
                    );
                if(trim($this->tinyObject['Language'])!="en"){
                    array_push($orCondition['$or'], array("Language"=>$this->tinyObject['Language']));                }
                $mongoCriteria->setConditions($orCondition);                
     
                
                $mongoCriteria->IsDeleted('==', 0);
                $mongoCriteria->IsBlockedWordExist('notIn', array(1, 2));
                $mongoCriteria->CategoryType('==', (int) 13);
                $mongoCriteria->addCond('StartDate', '<=',  new MongoDate());
                $mongoCriteria->IsPremiumAd('==', (int) 1);
              //  $mongoCriteria->addCond('ExpiryDate',">=", new MongoDate());
                $mongoCriteria->IsNotifiable('==', (int) 1);   
                $pageSize = 4;
                              
                $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => $mongoCriteria,
                        
                ));
           
                // echo "<br/>===112222222222222222222221 sizeof Ads ===".$provider->getTotalItemCount()."<br/>";
                return $provider;
        } catch (Exception $ex) {
            error_log("Exception Occurred in PostController->getStreamAds==". $ex->getTraceAsString());
            Yii::log("PostController:getStreamAds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar
     * This method is to abuse/block/release a post based on action type
     */
    public function actionAbusePost() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postId']) && isset($_REQUEST['actionType'])) {
                $postId = $_REQUEST['postId'];
                $actionType = $_REQUEST['actionType'];
                $networkId = $_REQUEST['networkId'];
                $userId = $this->tinyObject->UserId;
                //$userId = $this->tinyObject['UserId'];
                $categoryType = $_REQUEST['categoryType'];
                $isBlockedPost = isset($_REQUEST['isBlockedPost']) ? (int) $_REQUEST['isBlockedPost'] : 0;
                $result = ServiceFactory::getSkiptaPostServiceInstance()->abusePost($postId, $actionType, $categoryType, $networkId, $userId, $isBlockedPost);
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("PostController:actionAbusePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
          $obj = $this->rendering($obj);
            echo $obj;
    }

    /**
     * @author Sagar
     * This method is to promote a post
     */
    public function actionPromotePost() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postId'])) {
                $postId = $_REQUEST['postId'];
                $promoteDate = $_REQUEST['promoteDate'];
                $networkId = $_REQUEST['networkId'];
                $userId = $this->tinyObject->UserId;
                //$userId = $this->tinyObject['UserId'];
                $categoryType = $_REQUEST['categoryType'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->promotePost($postId, $userId, $promoteDate, $categoryType, $networkId);
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("PostController:actionPromotePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
         $obj = $this->rendering($obj);
            echo $obj;
    }
    
    
    public function actionCancelSaveItForLater()
    {
        try
        {              $result = "failure";
              if (isset($_REQUEST['postId'])) {
                $postId = $_REQUEST['postId'];
                $promoteDate = $_REQUEST['categoryType'];
                $postType = $_REQUEST['postType'];
                $userId = $this->tinyObject->UserId;
                //$userId = $this->tinyObject['UserId'];
                $categoryType = $_REQUEST['categoryType'];
                $result= ServiceFactory::getSkiptaPostServiceInstance()->cancelSaveitforlaterPost($postId, $userId,  $categoryType, 1,$postType);
            }
            $obj = array("status" => $result, "data" => "", "error" => ""); 
           
        } catch (Exception $ex) {
             Yii::log("PostController:actionCancelSaveItForLater::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
         $obj = $this->rendering($obj);
            echo $obj;
    }
    
    
    public function actionsaveitforlaterPost()
    {
        try {
            $result = "failure";
            if (isset($_REQUEST['postId'])) {
                $postId = $_REQUEST['postId'];
                $streamId = $_REQUEST['streamId'];
                 $networkId = $_REQUEST['networkId'];
                $userId = $this->tinyObject->UserId;
                //$userId = $this->tinyObject['UserId'];
                $categoryType = $_REQUEST['categoryType'];
                 $postType = $_REQUEST['postType'];
//                 $followers=ServiceFactory::getSkiptaPostServiceInstance()->getObjectFollowers($postId, $postType, $categoryType);
//                 if($followers!="failure" && !in_array($userId, $followers))
//                 {
//                    $result=ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToPost($postType, $postId, $userId, 'Follow', $categoryType, $createdDate = '');
//                 }
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveitforlaterPost($postId, $userId, $categoryType, $networkId,$postType);
                
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("PostController:actionsaveitforlaterPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
         $obj = $this->rendering($obj);
            echo $obj;
        
    }

    /**
     * @author Sagar
     * This method is to delete a post
     */
    public function actionDeletePost() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postId'])) {
                $postId = $_REQUEST['postId'];
                $networkId = $_REQUEST['networkId'];
                $userId = $this->tinyObject->UserId;
                //$userId = $this->tinyObject['UserId'];
                $categoryType = $_REQUEST['categoryType'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->deletePost($postId, $categoryType, $networkId);
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("PostController:actionDeletePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        $obj = $this->rendering($obj);
            echo $obj;
    }

    /**
     * @author Karteek V
     * This is the common render partial function for all detailed pages
     * @param $postId, $categoryType, $postType
     * @return type html
     */
     public function actionRenderPostDetailed() {
        try {

            $recentActivity = '';
            $inviteMessage = '';
            if (isset($_REQUEST['load'])) {
                $data = explode('_', $_REQUEST['load']);
                $categoryType = $data[0];
                $postId = $data[1];
                $postType = $data[2];
            } else {
                $postId = $_REQUEST['postId'];
                $categoryType = $_REQUEST['categoryType'];
                $postType = $_REQUEST['postType'];
                if (isset($_REQUEST['layout']))
                    $outer = $_REQUEST['layout'];
               
            }
             $translate = (isset($_REQUEST["translate"]) && (int) $_REQUEST["translate"] == 1) ? 1 : 0;
            if (isset($_REQUEST['recentActivity']) && $_REQUEST['recentActivity'] != "undefined") {
                $recentActivity = $_REQUEST['recentActivity'];
            }
            $IsLoadRequest = isset($_REQUEST['load']) ? 1 : 0;
            $loggedInUserId = $this->tinyObject['UserId'];
            $categoryType = (int) $categoryType;
            $timezone = Yii::app()->session['timezone'];
            $object = array();

            $loggedInUserId = $loggedInUserId;
            $UserPrivileges = $this->userPrivileges;
           
            $isPostManagement = 0;
         if (isset($_REQUEST['isPostManagement'])) {
                $isPostManagement = 1;
            }
        
            $object=array();
           // $result= ServiceFactory::getSkiptaPostServiceInstance()->cancelSaveitforlaterPost($postId, $loggedInUserId,  $categoryType, $networkId,$postType);
            $object = CommonUtility::preparePostDetailData($postId, $postType, $categoryType, $loggedInUserId, $IsLoadRequest,$UserPrivileges, $recentActivity, $timezone,$translate,$isPostManagement);

             $userId = $this->tinyObject['UserId'];
            $networkId = $this->tinyObject['NetworkId'];
            $segmentId = (int) $this->tinyObject['SegmentId'];
            ServiceFactory::getSkiptaPostServiceInstance()->trackEngagementAction($userId, "Post", "PostDetailOpen", $postId, $categoryType, $postType, $networkId, "", $segmentId);

            $canMarkAsAbuse = 0;
            if (is_array($UserPrivileges)) {
                foreach ($UserPrivileges as $value) {
                    if ($value['Status'] == 1) {
                        if ($value['Action'] == 'Mark_As_Abuse') {
                            $canMarkAsAbuse = 1;
                        }
                    }
                }
            }

            if (isset($_REQUEST['load'])) {
                $this->render("postDetailedPage", array("data" => $object,"canMarkAsAbuse"=>$canMarkAsAbuse,"isPostManagement" => $isPostManagement,));
            } else {
                $this->renderPartial("postDetailedPage", array("data" => $object, "isPostManagement" => $isPostManagement,"canMarkAsAbuse"=>$canMarkAsAbuse,"userLanguage" => Yii::app()->session['language']));
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in PostController->actionRenderPostDetailed==". $ex->getMessage());
            Yii::log("PostController:actionRenderPostDetailed::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author suresh reddy 
     * get derivate objects get
     * 
     */
    public function getDerivateObjectsStream($userId) {
        try {

            $pageSize = 1;
            $provider = new EMongoDocumentDataProvider('DerivativeObjectDisplayBean', array(
                'pagination' => array('pageSize' => 2),
                'criteria' => array(
                    'conditions' => array(
                        'UserId' => array('==' => $userId),
                        'CategoryType' => array('in' => array(1,2,16,5,6,3)),
                        'IsDeleted' => array('!=' => 1),
                        'IsAbused' => array('notIn' => array(1, 2)),
                        'IsEngage' => array('==' => 0),
                        'Priority' => array('>' => 0)
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
            Yii::log("PostController:getDerivateObjectsStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Haribabu
     * This method is to get a post comments
     */
    public function actionPostComments() {
        try {
        if (isset($_REQUEST['postId'])) {
            $postId = $_REQUEST['postId'];
        }
        $MinpageSize = 10;
        if (isset($_REQUEST['noOfComments'])) {
            $MinpageSize = $_REQUEST['noOfComments'];
        }
        $streamId=$_REQUEST['streamId'];
        $page = $_REQUEST['Page'];
        $PageType = $_REQUEST['PageType'];
        //$page=0;
        $pageSize = ($MinpageSize * $page);
        $categoryType = (int) $_REQUEST['CategoryType'];
        $result = ServiceFactory::getSkiptaPostServiceInstance()->getCommentsforPost($pageSize, $MinpageSize, $postId, (int) $categoryType);
        //  $Comments = ServiceFactory::getSkiptaPostServiceInstance()->getCommentObject($postId,(int)$categoryType); 
        // $TotalComments=count($Comments->Comments);
        $MoreCommentsArray = array();
        $blockedWords = array();
        if(isset($_REQUEST['isBlockedPost']) && (int)$_REQUEST['isBlockedPost']==1){
            $blockedWords = AbuseKeywords::model()->getAllAbuseWords();
        }
        foreach ($result as $key => $value) {
            $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
            $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
            $isPostManagement = 0;
            if (isset($_REQUEST['isPostManagement'])) {
                $isPostManagement = (int)$_REQUEST['isPostManagement'];
            }
            if(!$IsBlockedWordExist && !$IsAbused || (isset($_REQUEST['isBlockedPost']) && (int)$_REQUEST['isBlockedPost']==1) || $isPostManagement==1){
                $commentUserBean = new CommentUserBean();
                $createdOn = $value['CreatedOn'];
                $userDetails = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($value['UserId']);
                $commentUserBean->UserId = $userDetails['UserId'];
                $commentUserBean->Language = isset($value['Language'])?$value['Language']:'en';
                $commentUserBean->DisplayName = $userDetails['DisplayName'];
                $commentUserBean->ProfilePic = $userDetails['profile70x70'];
                $commentUserBean->CommentFullText = $value['CommentFullText'];
                $postId = (isset($value["PostId"])) ? $value["PostId"] : '';
                $CategoryType = (isset($value["CategoryType"])) ? $value["CategoryType"] : $categoryType;
                $PostType = (isset($value["PostType"])) ? $value["PostType"] : '';
                if (isset($value["CommentTextLength"]) && $value["CommentTextLength"] > 240) {
                    if(isset($_REQUEST['isBlockedPost']) && (int)$_REQUEST['isBlockedPost']==1){
                        if(isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']==1){
                            if (is_array($blockedWords) && sizeof($blockedWords) > 0) {
                                $value['CommentText'] = CommonUtility::FindElementAndReplace($value['CommentText'], $blockedWords);
                            }
                        }else{
                            $value["CommentText"] = $value["CommentText"];
                        }
                    }else{
                        $appendCommentData = ' <span class="postdetail"   data-id="'.$streamId.'" data-postid="' . $postId . '" data-categoryType="' . $CategoryType . '" data-postType="' . $PostType . '"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                       // $stringArray = str_split($value["CommentText"], 240);
                       //  $stringArray = CommonUtility::truncateHtml($value["CommentText"], 240);
                        $stringArray = CommonUtility::truncateHtml($value["CommentText"], 240,Yii::t('translation','Readmore'),true,true,$appendCommentData);
                        $text = $stringArray;
                        if($PageType!="postdetail"){
                            $value["CommentText"] = $text;
                        }else{
                            $value["CommentText"] =  $value["CommentText"];
                        }
                        
                    }
                } else {
                    if(isset($_REQUEST['isBlockedPost']) && (int)$_REQUEST['isBlockedPost']==1){
                        if(isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']==1){
                            if (is_array($blockedWords) && sizeof($blockedWords) > 0) {
                                $value['CommentText'] = CommonUtility::FindElementAndReplace($value['CommentText'], $blockedWords);
                            }
                        }else{
                            $value["CommentText"] = $value["CommentText"];
                        }
                    }else{
                        $value["CommentText"] = $value["CommentText"];
                    }
                }
                
                $commentUserBean->CommentText = $value['CommentText'];
                $commentUserBean->CommentId = $value['CommentId'];
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

                $commentUserBean->CategoryType = $CategoryType;
                $commentUserBean->PostId = $postId;
                $commentUserBean->Type = $PostType;
                if (array_key_exists('WebUrls', $value)) {
                 if(is_array($value['WebUrls']) && count($value['WebUrls'])>0 && isset($value['WebUrls'])){
                     $commenturls=$value['WebUrls'];
                     $commentUserBean->CommentText = CommonUtility::findUrlInStringAndMakeLink($commentUserBean->CommentText);
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
                    if(isset($commentUserBean->IsWebSnippetExist)){
                        $commentUserBean->IsWebSnippetExist = $value['IsWebSnippetExist'];
                    }else{
                        $commentUserBean->IsWebSnippetExist ="";
                    }
                }
                $commentUserBean->IsBlockedWordExist=isset($value['IsBlockedWordExist'])?$value['IsBlockedWordExist']:0;
                $commentUserBean->IsBlockedPost = isset($_REQUEST['isBlockedPost'])?$_REQUEST['isBlockedPost']:0;
                if (count($value['Artifacts']) > 0) {
                    if(isset($_REQUEST['PageType'])&& $_REQUEST['PageType']=='stream'){
                        $commentUserBean->Resource = $value['Artifacts'][0];
                        $commentUserBean->PageType = "stream";
                    }else if(isset($_REQUEST['PageType'])&& $_REQUEST['PageType']=='postdetail'){
                         $commentUserBean->Resource = $value['Artifacts'];
                         $commentUserBean->PageType = "postdetail";
                    }
                    
                    $commentUserBean->ResourceLength = count($value['Artifacts']);
                }
       array_push($MoreCommentsArray, $commentUserBean);
       }
            }

        $totalrecords = count($MoreCommentsArray);
        if ($result) {
             $profile = "/profile/".$userDetails['uniqueHandle'];
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
              $this->renderPartial('viewMoreComments', array("data" => $MoreCommentsArray, "categoryType"=>$CategoryType, "postId" => $postId, "postType" => $PostType, "totalRecords" => $totalrecords,'NetworkId'=>$userDetails['NetworkId'],'streamId'=>$streamId,"profile"=>$profile,"userLanguage"=>Yii::app()->session['language'],"canMarkAsAbuse"=>$canMarkAsAbuse));
        } else {

            $obj = array("status" => "fail", "data" => "", "postId" => $postId, "error" => "");
        }
        } catch (Exception $ex) {
            error_log("Exception Occurred in PostController->actionPostComments==".$ex->getMessage());
             Yii::log("PostController:actionPostComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }

       
    }

    /**
     * @Author Sagar Pathapelli
     * This method is used to get the user followers and following users list, It will search by 'Email'.
     * @param: 'searchkey' is the string.
     */
    public function actionGetUserFollowingAndFollowersForInvite() {
        try {
            $result = array();
            if (isset($_REQUEST['searchkey'])) {

                $searchKey = $_REQUEST['searchkey'];
                $categoryType = $_REQUEST['categoryType'];
                $postId = $_REQUEST['postId'];
                $mentionArray = isset($_REQUEST['existingUsers']) ? json_decode($_REQUEST['existingUsers']) : array();
                $userId = $this->tinyObject['UserId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getFollowingFollowerUsersForInvite($searchKey, $userId, $postId, $categoryType, $mentionArray);
            }
              $obj = $this->rendering($result);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetUserFollowingAndFollowersForInvite::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar
     * This method is to get the stream details
     */
    public function actionGetAbusedPosts() {
        try{
        if (isset($_GET['StreamPostDisplayBean_page'])) {
            $pageSize = 10;
            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                'pagination' => array('pageSize' => $pageSize),
                'criteria' => array(
                    'conditions' => array(
                        'UserId' => array('==' => 0),
                        'IsAbused' => array('==' => 1)
                    ),
                    'sort' => array('AbusedOn' => EMongoCriteria::SORT_DESC)
                )
            ));
            if ($provider->getTotalItemCount() == 0) {
                $stream = 0; //No posts
            } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                $streamRes = (object) (CommonUtility::prepareStreamData($this->tinyObject['UserId'], $provider->getData(), $this->userPrivileges));
                $stream=(object)($streamRes->streamPostData);
            } else {
                $stream = -1; //No more posts
            }
            $this->renderPartial('stream_view', array('stream' => $stream));
        }
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetUserFollowingAndFollowersForInvite::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUpdateNotificationAsRead() {
        try {
            $result = "failed";
            if (isset($_REQUEST['notificationId']) && strtolower($_REQUEST['notificationId']) != "undefined") {
                $notificationId = $_REQUEST['notificationId'];
                $userId = $this->tinyObject['UserId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->updateNotificationAsRead($notificationId,$userId);
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("PostController:actionUpdateNotificationAsRead::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
         $obj = $this->rendering($obj);
            echo $obj;
    }

    public function actionMarkallAsRead() {
        try {
            $result = "failed";
            $result = ServiceFactory::getSkiptaPostServiceInstance()->updateAllNotificationsByUserId($this->tinyObject->UserId);
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("PostController:actionMarkallAsRead::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
         $obj = $this->rendering($obj);
            echo $obj;
    }

    public function actionFileopen() {
        try{
        /*
          This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
         */
        $file = $_REQUEST['file'];
        $file = Yii::getPathOfAlias('webroot') . $file;
        $pathFragments = explode('/', $file);
        $name = end($pathFragments);
        //$name='91_10_1_TestingFundamentals.pptx';
        $mime_type = "";
        //Check the file premission
        if (!is_readable($file))
            die('File not found or inaccessible!');

        $size = filesize($file);
        $name = rawurldecode($name);
        /* Figure out the MIME type | Check in array */
        $known_mime_types = array(
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "pptx" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg" => "image/jpg",
            "jpg" => "image/jpg",
            "php" => "text/plain"
        );

        if ($mime_type == '') {
            $file_extension = strtolower(substr(strrchr($file, "."), 1));
            if (array_key_exists($file_extension, $known_mime_types)) {
                $mime_type = $known_mime_types[$file_extension];
            } else {
                $mime_type = "application/force-download";
            };
        };
        //turn off output buffering to decrease cpu usage
        @ob_end_clean();

        // required for IE, otherwise Content-Disposition may be ignored
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');

        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        /* The three lines below basically make the 
          download non-cacheable */
        header("Cache-control: private");
        header('Pragma: private');
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        // multipart-download and download resuming support
        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }
            /*
              ------------------------------------------------------------------------------------------------------
              //This application is developed by www.webinfopedia.com
              //visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
              ------------------------------------------------------------------------------------------------------
             */
            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        /* Will output the file itself */
        $chunksize = 1 * (1024 * 1024); //you may want to change this
        $bytes_send = 0;

        if ($file = fopen($file, 'r')) {

            if (isset($_SERVER['HTTP_RANGE']))
                fseek($file, $range);

            while (!feof($file) &&
            (!connection_aborted()) &&
            ($bytes_send < $new_length)
            ) {
                $buffer = fread($file, $chunksize);
                print($buffer); //echo($buffer); // can also possible
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
        } else
        //If no permissiion
            die('Error - can not open file.');
        //die
        die();
        } catch (Exception $ex) {
            Yii::log("PostController:actionFileopen::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Moin Hussain
     * This method is used to search posts
     */
    public function actionGetPostsForSearch() {
        try{
        $searchText = $_POST['search'];
        $offset = $_POST['offset'];
        $pageLength = $_POST['pageLength'];
        $postSearchResult = ServiceFactory::getSkiptaPostServiceInstance()->getPostsForSearch($searchText, $offset, $pageLength);
        $this->renderPartial('post_search', array('postSearchResult' => $postSearchResult));
        //echo CJSON::encode($result);
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetPostsForSearch::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Moin Hussain
     * This method is used to search curbside posts
     */
    public function actionGetCurbPostsForSearch() {
        try{
        $searchText = $_POST['search'];
        $offset = $_POST['offset'];
        $pageLength = $_POST['pageLength'];
        $curbPostSearchResult = ServiceFactory::getSkiptaPostServiceInstance()->getCurbPostsForSearch($searchText, $offset, $pageLength);
        $this->renderPartial('post_search', array('postSearchResult' => $curbPostSearchResult));
        //echo CJSON::encode($result);
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetCurbPostsForSearch::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Moin Hussain
     * This method is used to search curbside posts
     */
    public function actionGetPostsForHashtag() {
        try{
        $hashtagId = $_POST['hashtagId'];
        $offset = $_POST['offset'];
        $pageLength = $_POST['pageLength'];
        $curbPostSearchResult = ServiceFactory::getSkiptaPostServiceInstance()->getPostsForHashtag($hashtagId, $offset, $pageLength,$this->tinyObject->UserId);
        $this->renderPartial('post_search', array('postSearchResult' => $curbPostSearchResult));
        //echo CJSON::encode($result);
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetPostsForHashtag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author vamsikrishna 
     * This method is used to mark the post as featured  
     */
    public function actionMarkOrUnMarkPostAsFeatured() {
        try {
            $returnValue = 'failure';
            if (isset($_REQUEST['postId'])) {

                $postId = $_REQUEST['postId'];
                $networkId = $_REQUEST['networkId'];
                $title = $_REQUEST['Title'];

                $userId = $this->tinyObject['UserId'];

                $categoryType = $_REQUEST['categoryType'];
                $type=$_REQUEST['type'];
                    if($type=='Featured'){
                  $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->updatePostAsFeatured($userId, $postId, $categoryType, $networkId,$title);     
                 }else{
                  $returnValue = ServiceFactory::getSkiptaPostServiceInstance()->updatePostAsUnFeatured($userId, $postId, $categoryType, $networkId);        
                 }
                
                if ($returnValue != 'failure') {
                    $returnValue = 'success';
                }
            }
            $obj = array("status" => $returnValue, "data" => "", "error" => "");
              $obj = $this->rendering($obj);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("PostController:actionMarkOrUnMarkPostAsFeatured::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    public function actionGetFeaturedItemsToDisplay() {
        $returnValue = 'failure';
        try {            
            $segmentId = (int)$this->tinyObject['SegmentId'];
            $language = Yii::app()->session['language'];
            $featuredItems = ServiceFactory::getSkiptaPostServiceInstance()->getFeaturedPosts($segmentId, $language);

            if ($featuredItems != "failure") {
                $this->renderPartial('featuredItems', array("status" => 'success', 'featuredItems' => $featuredItems));
            }
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetFeaturedItemsToDisplay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    /**
     * @author Sagar Pathapelli
     * This method is used to get the invited user list for a post
     */
    public function actionGetInvitedUsers() {
        try {
            $postId = $_REQUEST['PostId'];
            $categoryType = $_REQUEST['CategoryType'];
            $invitedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getInvitedUsersObjectForPost($postId, $categoryType);
            if (is_array($invitedUsers)) {
                $obj = array("status" => 'success', "data" => $invitedUsers, "count" => sizeof($invitedUsers));
            } else {
                $obj = array("status" => "failure", "data" => "", "error" => "");
            }
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetInvitedUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $obj = array("status" => "error", "data" => "", "error" => "");
          $obj = $this->rendering($obj);
            echo $obj;
        }
         $obj = $this->rendering($obj);
            echo $obj;
    }
    
   public function actionGetpostRecentComments(){
  
       try{
       if (isset($_REQUEST['postId'])) {
            $postId = $_REQUEST['postId'];
        }
        if (isset($_REQUEST['StreamId'])) {
             $streamId = $_REQUEST['StreamId'];
        }else{
           $streamId="" ;
        }
        
        $MinpageSize = 2;
       // $page = $_REQUEST['Page'];
        $page=0;
        $pageSize = ($MinpageSize * $page);
        $categoryType = (int) $_REQUEST['CategoryType'];
        $result = ServiceFactory::getSkiptaPostServiceInstance()->getRecentCommentsforPost($pageSize, $MinpageSize, $postId, (int) $categoryType);
        
        //  $Comments = ServiceFactory::getSkiptaPostServiceInstance()->getCommentObject($postId,(int)$categoryType); 
        // $TotalComments=count($Comments->Comments);
        $MoreCommentsArray = array();
        if (isset($result) && is_array($result)) {
        foreach ($result as $key => $value) {
            $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
            $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
            if(!$IsBlockedWordExist && !$IsAbused){
                $commentUserBean = new CommentUserBean();
                $userDetails = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($value['UserId']);
                $createdOn = $value['CreatedOn'];
                $commentUserBean->UserId = $userDetails['UserId'];
                $commentUserBean->Language = isset($value['Language'])?$value['Language']:'en';
                $postId = (isset($value["PostId"])) ? $value["PostId"] : '';
                $CategoryType = (isset($value["CategoryType"])) ? $value["CategoryType"] : $categoryType;
                $PostType = (isset($value["PostType"])) ? $value["PostType"] : '';
                $commentUserBean->CommentFullText = $value["CommentFullText"];
                if (isset($value["CommentTextLength"]) && $value["CommentTextLength"] > 240) {

                    $appendCommentData = ' <span class="postdetail"  data-id="'.$streamId.'" data-postid="' . $postId . '" data-categoryType="' . $CategoryType . '" data-postType="' . $PostType . '"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                   // $stringArray = str_split($value["CommentText"], 240);
                   // $stringArray = CommonUtility::truncateHtml($value["CommentText"], 240);
                    $stringArray = CommonUtility::truncateHtml($value["CommentText"], 240,Yii::t('translation','Readmore'),true,true,$appendCommentData);
                    $text = $stringArray;
                    $value["CommentText"] = $text;
                } else {

                    $value["CommentText"] = $value["CommentText"];
                }
                $commentUserBean->CommentText = $value['CommentText'];
                $commentUserBean->CommentId = $value['CommentId'];
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
                $commentUserBean->CategoryType = $CategoryType;
                $commentUserBean->PostId = $postId;
                $commentUserBean->Type = $PostType;
                //$commenturls=$value['WebUrls'];
                 if (array_key_exists('WebUrls', $value)) {
                 if(is_array($value['WebUrls']) && count($value['WebUrls'])>0 && isset($value['WebUrls'])){
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
                         $commentUserBean->CommentText = CommonUtility::findUrlInStringAndMakeLink($commentUserBean->CommentText); 
                    }else{
                         $commentUserBean->IsWebSnippetExist = "";
                    }
                 }
                if (count($value['Artifacts']) > 0) {
                    if(isset($_REQUEST['PageType'])&& $_REQUEST['PageType']=='stream'){
                        $commentUserBean->Resource = $value['Artifacts'][0];
                        $commentUserBean->PageType = "stream";
                    }else if(isset($_REQUEST['PageType'])&& $_REQUEST['PageType']=='postdetail'){
                         $commentUserBean->Resource = $value['Artifacts'];
                         $commentUserBean->PageType = "postdetail";
                    }
                     $commentUserBean->ResourceLength = count($value['Artifacts']);
                }
               
                array_push($MoreCommentsArray, $commentUserBean);
            }
        }
        }

        $totalResultArrayCount=count($MoreCommentsArray);
        $numberofRecordsTofetch=$totalResultArrayCount-$MinpageSize;
        $output = array_slice($MoreCommentsArray, $numberofRecordsTofetch); 
        $totalrecords = count($MoreCommentsArray);
        if ($result) {
             $profile = "/profile/".$userDetails['uniqueHandle'];
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
            $this->renderPartial('viewMoreComments', array("data" => $output, "postId" => $postId,'NetworkId'=>$userDetails['NetworkId'], "totalRecords" => $totalrecords,'streamId'=>$streamId,"profile"=>$profile,"canMarkAsAbuse"=>$canMarkAsAbuse,"userLanguage"=>Yii::app()->session['language']));
        } else {

            $obj = array("status" => "fail", "data" => "", "postId" => $postId, "error" => "");
        }
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetpostRecentComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       
   } 
    public function actionSaveSharedList() {
        $obj = array();
        try {
            $returnVal = "failure";
            $userId = $this->tinyObject->UserId;
            //$userId = $this->tinyObject['UserId'];
            $postId = $_REQUEST['postId'];
            $categoryType = $_REQUEST['categoryType'];
            $shareType = $_REQUEST['shareType'];
            $returnVal = ServiceFactory::getSkiptaPostServiceInstance()->saveSharedList($postId, $userId, $categoryType, $shareType);
            if ($returnVal=='success') {
                $obj = array("status" => 'success', "data" => $returnVal);
            } else {
                $obj = array("status" => "failure", "data" => "", "error" => "");
            }
        } catch (Exception $ex) {
            Yii::log("PostController:actionSaveSharedList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $obj = array("status" => "error", "data" => "", "error" => "");
            $obj = $this->rendering($obj);
            echo $obj;
        }
         $obj = $this->rendering($obj);
          echo $obj;
    }
 public function actionTrackPostDetailAction(){
     try{  
     $userId = $this->tinyObject['UserId'];
        $from = $_REQUEST['from'];
       $postId = $_REQUEST['postId'];
       $categoryType = $_REQUEST['categoryType'];
       $postType = $_REQUEST['postType'];
       $networkId = $this->tinyObject['NetworkId'];
       ServiceFactory::getSkiptaPostServiceInstance()->trackPostDetailAction($from,$userId,$postId,$categoryType,$postType,$networkId);
       } catch (Exception $ex) {
            Yii::log("PostController:actionTrackPostDetailAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
 }    
 public function actionTrackPageLoad(){
     try{ 
     $from = $_REQUEST['from'];
      $userId = $this->tinyObject['UserId'];
       $dataId = "";
       $networkId = $this->tinyObject['NetworkId'];
       $segmentId = $this->tinyObject['SegmentId'];
       if(isset($_REQUEST['dataId'])){
           $dataId = $_REQUEST['dataId'];
       }
      ServiceFactory::getSkiptaPostServiceInstance()->trackPageLoad($userId,$from,$dataId,$networkId, $segmentId);
      $result = array("code"=>200,"status"=>"");
      echo $this->rendering($result);
      } catch (Exception $ex) {
            Yii::log("PostController:actionTrackPageLoad::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

 }
  public function actionTrackSearchCriteria(){
      try{  
      $loginUserId = $_REQUEST['userId'];
        $searchText = $_REQUEST['searchText'];
        $networkId = $this->tinyObject['NetworkId'];
        $segmentId = $this->tinyObject['SegmentId'];
        $activityIndex = CommonUtility::getUserActivityIndexByActionType("ProjectSearch");
        $activityContextIndex = CommonUtility::getUserActivityContextIndexByActionType("ProjectSearch");
        UserInteractionCollection::model()->saveSearchActivity($searchText,$loginUserId,$activityIndex,$activityContextIndex,$networkId,$segmentId);  
        } catch (Exception $ex) {
            Yii::log("PostController:actionTrackSearchCriteria::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
public function actionTrackEngagementAction(){
    try{  
    $page = $_REQUEST['page'];
      $action = $_REQUEST['action'];
      $userId = $this->tinyObject['UserId'];
      $segmentId = (int)$this->tinyObject->SegmentId;
      $dataId = "";
       $id = "";
       if(isset($_REQUEST['dataId'])){
          $dataId= $_REQUEST['dataId'];
       }
       if(isset($_REQUEST['id'])){
          $id= $_REQUEST['id'];
       }
    
        $networkId = $this->tinyObject['NetworkId'];
       $categoryType = $_REQUEST['categoryType'];
       $postType = $_REQUEST['postType'];
      ServiceFactory::getSkiptaPostServiceInstance()->trackEngagementAction($userId,$page,$action,$dataId,$categoryType,$postType,$networkId, $id, $segmentId);
     $result = array("code"=>200,"status"=>"");
      echo $this->rendering($result);
      } catch (Exception $ex) {
            Yii::log("PostController:actionTrackEngagementAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
  
 }  
 public function actionTrackSearchEngagementAction(){
     try{ 
     $page = $_REQUEST['page'];
      $action = $_REQUEST['action'];
       $searchType = $_REQUEST['searchType'];
        $searchText = $_REQUEST['searchText'];
      $userId = $this->tinyObject['UserId'];
      $segmentId = $this->tinyObject['SegmentId'];
      $dataId = "";
       if(isset($_REQUEST['dataId'])){
          $dataId= $_REQUEST['dataId'];
       }
       $networkId = $this->tinyObject['NetworkId'];
      ServiceFactory::getSkiptaPostServiceInstance()->trackSearchEngagementAction($userId,$page,$action,$dataId,$searchText,$searchType,$networkId, $segmentId);
     $result = array("code"=>200,"status"=>"");
      echo $this->rendering($result);
    } catch (Exception $ex) {
            Yii::log("PostController:actionTrackSearchEngagementAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
 } 
    
 public function actionPostdetail(){
     try{
         $postId = $_REQUEST['postId'];
        $categoryType = $_REQUEST['categoryType'];
        $postType = $_REQUEST['postType'];
        $out = $_REQUEST['outer'];
         $this->render('postdetail',array('postId'=>$postId,'categoryType'=>$categoryType,'postType'=>$postType,'outer'=>$out));
     } catch (Exception $ex) {
         Yii::log("PostController:actionPostdetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
 }
 
  /**
     * @Author Vamsi Krishna
     * This method is used to get the user for mentions onky for PrivateGroup.
     * @param: 'searchkey' is the string.
     */
    public function actiongetGroupMembersForPrivateGroups() {
        try {
            $result = array();
            if (isset($_REQUEST['searchkey'])) {

                $searchKey = $_REQUEST['searchkey'];
                $mentionArray = isset($_REQUEST['existingUsers']) ? json_decode($_REQUEST['existingUsers']) : array();
                $groupId=$_REQUEST['groupId'];
                $userId = $this->tinyObject['UserId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getGroupMembersForMentionsForPrivateGroup($searchKey, $groupId, $mentionArray);
            }
            $obj = $this->rendering($result);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("PostController:actiongetGroupMembersForPrivateGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

/**
     * @Author Vamsi Krishna
     * This method is used to get the user followers and following users list, It will search by 'Email'.
     * @param: 'searchkey' is the string.
     */
    public function actionGetroupMembersForPrivateGroupsForInvite() {
        try {
            $result = array();
            if (isset($_REQUEST['searchkey'])) {

                $searchKey = $_REQUEST['searchkey'];
                $categoryType = $_REQUEST['categoryType'];
                $groupId = $_REQUEST['groupId'];
                $postId = $_REQUEST['postId'];
                $mentionArray = isset($_REQUEST['existingUsers']) ? json_decode($_REQUEST['existingUsers']) : array();
                $userId = $this->tinyObject['UserId'];
                $result = ServiceFactory::getSkiptaGroupServiceInstance()->getFollowingFollowerUsersForInviteInPrivateGroup($searchKey, $userId, $postId, $categoryType, $mentionArray,$groupId);
            }
              $obj = $this->rendering($result);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetroupMembersForPrivateGroupsForInvite::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionFollowAllHashtags(){
        try {
            $userId = (int) (Yii::app()->session['NetworkAdminUserId']);
            echo $userId;
            $hashtagsObj = ServiceFactory::getSkiptaPostServiceInstance()->getHashtagsForCurbsidePost();
            $i=0;
            
            foreach ($hashtagsObj as $key => $hashtag) {echo $i.", ";
                $i++;
                $hashtagId = (string) $hashtag->_id;
                $result = ServiceFactory::getSkiptaPostServiceInstance()->followOrUnfollowHashTag($hashtagId, $userId, 'Follow');
            }
            echo $i." Hashtags followed";
        } catch (Exception $ex) {
            Yii::log("PostController:actionFollowAllHashtags::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionMobileStream(){
        try{
        $userId = Yii::app()->session['TinyUserCollectionObj']['UserId'];
        echo $this->rendering("success");
        } catch (Exception $ex) {
            Yii::log("PostController:actionMobileStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function actionMobileUnreadNotifications(){
      
//        $userId = Yii::app()->session['TinyUserCollectionObj']['UserId'];
//        $provider = new EMongoDocumentDataProvider('Notifications',                   
//           array(
//                'pagination' => FALSE,
//                'criteria' => array( 
//                   'conditions'=>array(                       
//                       'UserId'=>array('==' => (int) $userId),                       
//                       'isRead' => array('==' => (int) 0)
//                       ),
//                   'sort'=>array('CreatedOn'=>EMongoCriteria::SORT_DESC)
//                 )
//               ));    
//            $data = $provider->getData();
//           
//            if($provider->getItemCount() > 0){
//                $result = CommonUtility::prepareStringToNotification($data);
//                $obj = array("data"=>$result,"notificationCount"=>  sizeof( $provider->getData()));
//                
//            }else{
//                $obj = array('status' => 'success', 'data' => 0, 'error' => "");                
//            }
//            echo $this->rendering($obj);
    } 

    public function actiongetPostWidget(){
    try {
       $siteurl = YII::app()->getBaseUrl('true');
            if (isset($_REQUEST['postId'])) {

                $postId = $_REQUEST['postId'];
                $timezone = $_REQUEST['Timezone'];

                // $timezone='Asia/Kolkata';
                $groupsfollowing = ServiceFactory::getSkiptaPostServiceInstance()->getUserFollowingGroupsIDs((int) $this->tinyObject['UserId']);
                array_push($groupsfollowing, '');

                $condition = array(
                    'PostId' => array('in' => array(new MongoID($postId))),
                    'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                    'GroupId' => array('in' => $groupsfollowing),
                    'IsDeleted' => array('!=' => 1),
                    'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                    'IsAbused' => array('notIn' => array(1, 2)),
                    'CategoryType' => array('notIn' => array(7)),
                    //'IsNotifiable' => array('==' => (int) 1)
                );
                // }

                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'criteria' => array(
                        'conditions' => $condition,
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));
                ;


                $UserId = $this->tinyObject['UserId'];

                $dataArray = $provider->getData();
                $streamRes = (object) (CommonUtility::prepareStreamData($UserId, $dataArray, $this->userPrivileges, 0, Yii::app()->session['PostAsNetwork'], $timezone));
                $stream=(object)($streamRes->streamPostData);
                foreach ($stream as $data) {
                    $postType = $data->PostType;
                    $postId = $data->PostId;
                    $category = $data->CategoryType;
                    $gamename = $data->GameName;
                    $gamesheduledId = $data->CurrentGameScheduleId;
                }
                $loadedPage = "";
                if ($postType == '11' || $postType == '12') {
                    $loadedPage = 'game';
                } elseif ($postType == '2') {
                    $loadedPage = 'eventpost';
                } elseif ($postType == '3') {
                    $loadedPage = 'surveypost';
                } else {
                    $loadedPage = 'normalpost';
                }
                $loginUserId = Yii::app()->session['TinyUserCollectionObj']['UserId'];
                if ($postType == '12') {
                    // $url="$siteurl"."/".$gamename."/". $gamesheduledId."/detail/game";
                    $url = "$siteurl" . "/common/postdetail?postId=$gamesheduledId&categoryType=9&postType=$gamename&trfid=$loginUserId";
                } else {
                    $url = "$siteurl" . "/common/postdetail?postId=$postId&categoryType=$category&postType=$postType&trfid=$loginUserId";
                }


                $this->renderPartial($loadedPage, array('stream' => $stream, 'siteurl' => $siteurl, 'url' => $url));
            }

    } catch (Exception $ex) {
         Yii::log("PostController:actiongetPostWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
  }

  public function actionGetCurbsidePostsByCategory() {
      try{  
       $categoryId = $_REQUEST['categoryId'];
        $offset = $_REQUEST['offset'];
        $pageLength = $_REQUEST['pageLength'];
        $curbPostSearchResult = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsidePostsByCategory($categoryId, $offset, $pageLength,$this->tinyObject->UserId);
        $this->renderPartial('post_search', array('postSearchResult' => $curbPostSearchResult));
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetCurbsidePostsByCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGetPostsForHashtagSearch() {
        try{
        $hashtagId = $_POST['hashtagId'];
        $offset = $_POST['offset'];
        $pageLength = $_POST['pageLength'];
        $curbPostSearchResult = ServiceFactory::getSkiptaPostServiceInstance()->getPostsForHashtagSearch($hashtagId, $offset, $pageLength,$this->tinyObject->UserId);
       
        $this->renderPartial('post_search', array('postSearchResult' => $curbPostSearchResult));
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetPostsForHashtagSearch::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * @developer Kartheek V
     * @return type
     * @throws Exception
     * 
     */
    
     public function actionSaveRenderPostComment() {
        $obj = array();

        try {//throw new Exception('Division by zero.');
            if (isset($_REQUEST['postid'])) {
                $streamId = $_REQUEST['streamid'];
                $commentBean = new CommentBean();
                $commentBean->PostId = $_REQUEST['postid'];
                $commentBean->CommentText = $_REQUEST['comment'];
                $CategoryType = $_REQUEST['CategoryType'];
                $PageType = $_REQUEST['pageType'];
                if (trim($_REQUEST['commentArtifacts']) == "") {

                    $commentBean->Artifacts = array();
                } else {
                    $commentBean->Artifacts = explode(",", $_REQUEST['commentArtifacts']);
                }
                $commentBean->PostType = $_REQUEST['type'];
                $commentBean->UserId = Yii::app()->session['PostAsNetwork'] == 1 ? Yii::app()->session['NetworkAdminUserId'] : $this->tinyObject->UserId;
                //$commentBean->UserId = $this->tinyObject->UserId;
                $commenturls = array();
                $commenturls[0] = $_REQUEST['WebUrls'];
                $commentBean->WebUrls = $commenturls;
                // $commentBean->WebUrls = $_REQUEST['type'];
                if (isset($_REQUEST['IsWebSnippetExist'])) {
                    $commentBean->IsWebSnippetExist = $_REQUEST['IsWebSnippetExist'];
                }

                $commentBean->HashTags = CommonUtility::prepareHashTagsArray($_REQUEST['hashTags']);
                $commentBean->Mentions = CommonUtility::prepareAtMentionsArray($_REQUEST['atMentions']);
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveComment($commentBean, (int) $_REQUEST['NetworkId'], (int) $CategoryType);
//                $comments = ServiceFactory::getSkiptaPostServiceInstance()->getCommentObject($commentBean->PostId,$CategoryType);                
                if ($result == 'Exception') {
                    throw new Exception('Unable to save commment');
                } else if (is_array($result)) {
                    $commentUserBean = new CommentUserBean();
                    if (isset($result[0])) {
                       if($PageType=="postDetailed" || $PageType=="GroupDetail"){
                            $commentUserBean->Resource = $result;
                        }else{
                            $commentUserBean->Resource = $result[0];
                        }
                        
                    } else {
                        $commentUserBean->Resource = "";
                    }
                    $commentUserBean->CommentId = isset($result['CommentId'])?$result['CommentId']:"";
                    $userCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($commentBean->UserId);
                    $commentUserBean->UserId = $userCollectionObj->UserId;
                    $tagsFreeDescription = strip_tags(($commentBean->CommentText));
                    $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
                    $descriptionLength = strlen($tagsFreeDescription);
                    if ($descriptionLength > 240 && $PageType != "postDetailed") {

                        $postId = (isset($_REQUEST["postid"])) ? $_REQUEST["postid"] : '';
                        $PostType = (isset($_REQUEST["type"])) ? $_REQUEST["type"] : '';

                        $appendCommentData = ' <span class="postdetail"    data-id="' . $streamId . '" data-postid="' . $postId . '" data-categoryType="' . $CategoryType . '" data-postType="' . $PostType . '"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                        $stringArray = CommonUtility::truncateHtml($commentBean->CommentText, 240, 'Read more', true, true, $appendCommentData);
                        // $stringArray = str_split($commentBean->CommentText, 240);
                        $text = $stringArray;
                        $commentBean->CommentText = $text;
                    } else {

                        $commentBean->CommentText = $commentBean->CommentText;
                    }
                    $commentUserBean->CommentText = $commentBean->CommentText;
                    // $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn->sec);
                    if (count($commenturls) > 0) {
                        $parsed = parse_url($commenturls[0]);
                        if (empty($parsed['scheme'])) {
                            $commenturls[0] = 'http://' . ltrim($commenturls[0], '/');
                        }
                        $weburls = explode('&nbsp', $commenturls[0]);
                        $commenturls[0] = $weburls[0];

                        $WeburlObj = ServiceFactory::getSkiptaPostServiceInstance()->CheckWebUrlExist($commenturls[0]);

                        if ($WeburlObj != 'failure') {
                            $snippetData = $WeburlObj;
                        } else {

                            $snippetData = "";
                        }
                    } else {

                        $snippetData = "";
                    }

                    $commentUserBean->snippetdata = $snippetData;
                    if (isset($_REQUEST['IsWebSnippetExist'])) {
                        $commentUserBean->IsWebSnippetExist = $_REQUEST['IsWebSnippetExist'];
                        $commentUserBean->CommentText = CommonUtility::findUrlInStringAndMakeLink($commentUserBean->CommentText);
                    } else {
                        $commentUserBean->IsWebSnippetExist = "";
                    }

                    $commentUserBean->DisplayName = $userCollectionObj->DisplayName;
                    $commentUserBean->ProfilePic = $userCollectionObj->profile70x70;
                    $commentUserBean->CategoryType = $_REQUEST["CategoryType"];
                    $commentUserBean->PostId = $_REQUEST["postid"];
                    $commentUserBean->Type = $_REQUEST["type"];
                    $commentUserBean->ResourceLength = count($result);
                    $commentUserBean->streamId = $streamId;
                    $profile = "/profile/" . $userCollectionObj->uniqueHandle;
                    $commentUserBean->Profilename = $profile;

                    $obj = array("status" => "succes", "data" => $commentUserBean, "error" => "");
                    $isblocked = 0;
                } else if ($result == 'blocked') {
                    $obj = array("status" => "succes", "data" => "blocked", "error" => "");
                    $isblocked = 1;
                }
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in PostController->actionSaveRenderPostComment==". $ex->getMessage());
            Yii::log("PostController:actionSaveRenderPostComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $id = "commenterror_" . $_REQUEST['postid'];

            $translation = "Comment_Saving_Fail";
            $this->throwErrorMessage($id, $translation);
            return;
        }
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
        if($PageType=="postDetailed" || $PageType=="GroupDetail"){
             $this->renderPartial('detailCommentscript', array("comments" => $commentUserBean, "isBlocked" => $isblocked,"canMarkAsAbuse"=>$canMarkAsAbuse));
        }else{
             $this->renderPartial('commentscript', array("comments" => $commentUserBean, "isBlocked" => $isblocked,"canMarkAsAbuse"=>$canMarkAsAbuse));
        }
       
    }

    /**
     * @Author Haribabu
     * This method is used to get theCv interests list, .
     * @param: 'searchkey' is the string.
     */
    public function actionGetUserInterests() {
        try {
            $result = array();
            if (isset($_REQUEST['searchkey']) && $_REQUEST['searchkey']!="" ) {
                $searchKey = $_REQUEST['searchkey'];
                $mentionArray = isset($_REQUEST['existingInterests']) ? json_decode($_REQUEST['existingInterests']) : array();

              //  $userId = $this->tinyObject['UserId'];
                $mentionString = "'".implode("','",$mentionArray)."'";
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getUserInterests($searchKey,$mentionString);
            }
              $obj = $this->rendering($result);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("PostController:actionGetUserInterests::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionCommentManagement() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postId']) && isset($_REQUEST['commentId']) && isset($_REQUEST['actionType'])) {
                $commentId = $_REQUEST['commentId'];
                $postId = $_REQUEST['postId'];
                $actionType = $_REQUEST['actionType'];
                $networkId = $_REQUEST['networkId'];
                $userId = $this->tinyObject->UserId;
                $categoryType = (int)$_REQUEST['categoryType'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->commentManagement($commentId, $postId, $actionType, $categoryType, $networkId, $userId);
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("PostController:actionCommentManagement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
          $obj = $this->rendering($obj);
            echo $obj;
    }
    
        /**
     * @Author Haribabu
     * This method is used get the tiny user collection for group mentions
     * @return type
     */
    public function actionGetGroupUsers() {
       try {
             $result = array();
            if (isset($_REQUEST['searchKey'])) {
                $searchKey = $_REQUEST['searchKey'];
                $mentionArray = isset($_REQUEST['existingUsers']) ? json_decode($_REQUEST['existingUsers']) : array();
                $groupId=$_REQUEST['groupId'];
                $userId = $this->tinyObject['UserId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getGroupMembersForMentionsForPrivateGroup($searchKey, $groupId, $mentionArray);
            }
            $obj = $this->rendering($result);
            echo $obj;
       } catch (Exception $ex) {
           Yii::log("PostController:actionGetGroupUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
   }
   
   /**
    * @developer Kishore N
    * @usage use post for away digest. 
    */
 public function actionUseThisPostForAwayDigest() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postId']) && isset($_REQUEST['actionType'])) {
                $postId = $_REQUEST['postId'];
                $isUseForDigest=$_REQUEST['actionType']=='usefordigest'?1:0;
                
                $networkId = $_REQUEST['networkId'];
                $userId = $this->tinyObject->UserId;
                $categoryType = $_REQUEST['categoryType'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->markThisPostForAwayDigest($postId, $categoryType, $networkId,$isUseForDigest);
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("PostController:actionUseThisPostForAwayDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
          $obj = $this->rendering($obj);
            echo $obj;
    }     
    /**
    * @author vamsi krishna
    * This method is used to track the custom group tab click
    */
   
   public function actiontrackCustomTab() {
        try {
            $userId = $this->tinyObject['UserId'];
            $networkId = $this->tinyObject['NetworkId'];
            $categoryType=3;
            $postType="";
            $customPageId=$_REQUEST['id'];
            $page="Group";
            
            
            $urlArray = explode("/", $_REQUEST['url']);
            
             if(isset($urlArray[4]))
            {     
            $groupName = trim(urldecode($urlArray[4])); 
            }           
            $groupObj = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupIdByCustomGroupName($groupName);
            ServiceFactory::getSkiptaPostServiceInstance()->trackEngagementAction($userId,$page,"CustomGroupTab",  isset($groupObj->_id)?$groupObj->_id:'',$categoryType,$postType,$networkId,"",isset($groupObj->SegmentId)?$groupObj->SegmentId:'','','',$customPageId);
        } catch (Exception $ex) {
         Yii::log("PostController:actiontrackCustomTab::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }   
    

   
   public function actionGetNewUserJoyrideDetails() {
        try {
            try {
                if (isset($_POST['moduleName'])) {
                    $opportunityId = "";
                    $urlToLoad = "";
//                    Yii::app()->session['ContinuousTour'] = 'No';
                    $moduleName = $_REQUEST['moduleName'];
                    $result = array();
                    if ($moduleName == 'Next' ||$moduleName=='Previous' ) {
                        $opportunityId = $_POST['opportunityId'];
                        
                    }


                    if ($opportunityId != "") {
                         $obj = array("status" => "failure");
                        if($moduleName=="Next")
                        {
                            $result = ServiceFactory::getSkiptaPostServiceInstance()->getNewUserJoyrideDetailsByOpportunityId($this->tinyObject['UserId'], $opportunityId);
                             
                        }
                        else if($moduleName=="Previous")
                        {
                            $result = ServiceFactory::getSkiptaPostServiceInstance()->getJoyrideDetailsByOpportunityId($this->tinyObject['UserId'], $opportunityId);
                        }
                        Yii::app()->session['OpportunityToLoad'] = $opportunityId; 
                         if ($result != "failure" && sizeof($result) > 0) {
                                $urlToLoad = $result[0]['FromPage'];
                                if($result[0]['FromPage']=="streamSearch")
                                    $urlToLoad="stream";
                                $obj = array("status" => "success", 'urlToLoad' => $urlToLoad, 'loginUserUniqueHandle' => Yii::app()->session['TinyUserCollectionObj']['uniqueHandle'], 'opportunityId' => $opportunityId);
                            } 

                        $resultData = $this->rendering($obj);
                        echo $resultData;
                    }
                    else {
                        
                        if(Yii::app()->session['OpportunityToLoad']==5)
                            $moduleName="streamSearch";
                        $result = ServiceFactory::getSkiptaPostServiceInstance()->getNewUserJoyrideDetailsByModule($this->tinyObject['UserId'], $moduleName);
                         if ($result != "failure" && sizeof($result) > 0) {
                              Yii::app()->session['OpportunityToLoad']=$result[0]['OpportunityId'];
                         }
                       
                        $this->renderPartial('/common/newuserjoyride', array('joyrideInfo' => $result['info'], 'urlToLoad' => $urlToLoad, 'loginUserUniqueHandle' => Yii::app()->session['TinyUserCollectionObj']['uniqueHandle'], 'opportunityId' => 'zero', 'nextOpportunity' => $result['nextOpportunity']));
                    }
                }
            } catch (Exception $ex) {
               Yii::log("PostController:actionGetNewUserJoyrideDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
        } catch (Exception $ex) {
          Yii::log("PostController:actionGetNewUserJoyrideDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionSaveOrUpdateUserTourGuideState() {
        try {
            if (isset($_POST['opportunityId'])) {

                $joyRideDivId = $_POST['joyrideDivId'];
                $opportunityId = $_POST['opportunityId'];
                  $obj = array("status" => "failure");
                if ($joyRideDivId != '' && $opportunityId != '')
                {
                    $result = ServiceFactory::getSkiptaPostServiceInstance()->saveOrUpdateUserTourGuideState($this->tinyObject['UserId'], $opportunityId, $joyRideDivId);
                     $obj = array("status" => "success", 'goalReached' => $result);
                }
                 $resultData = $this->rendering($obj);
                        echo $resultData;
            }
        } catch (Exception $ex) {
            Yii::log("PostController:actionSaveOrUpdateUserTourGuideState::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function actioninvokeJoyrideByOpportunityId() {
        try {
            try {
                if (isset($_POST['opportunityType'])) {
                    error_log("___________-Testing".$_POST['opportunityId']);
                    $opportunityType = $_POST['opportunityType'];
                    $urlToLoad = "";
                
                  
                   
                    if ($opportunityType != "") {
                         $obj = array("status" => "failure");
                         $joyrideInfo=  TourGuide ::model()->getTourGuideByOpportunityType($opportunityType);
                          
                         if ($joyrideInfo != "failure" && sizeof($joyrideInfo) > 0) {
                                $opportunityId=$joyrideInfo[0]['OpportunityId'];
                                $resultValue= TourGuide_User::model()->saveOrUpdateUserTourGuideState($this->tinyObject['UserId'],$opportunityId,$joyrideInfo[0]['Id'],1);
                                $result = ServiceFactory::getSkiptaPostServiceInstance()->getNewUserJoyrideDetailsByModule($this->tinyObject['UserId'], $joyrideInfo[0]['FromPage']);
                                // error_log(print_r($result,true));
                                error_log(print_r($result,true));
                                if ($result != "failure" && sizeof($result) > 0) {
                                    $resultValue=$result['info'];
                                   
                                      $urlToLoad = $resultValue[0]['FromPage'];
                                    if($resultValue[0]['FromPage']=="streamSearch")
                                    $urlToLoad="stream";
                                  Yii::app()->session['UserStaticData']->disableJoyRide=0;
                                  $pageNavigation=$_POST['pageNavigation']; 
                                    if($pageNavigation=='yes')
                                    {
                                     $obj = array("status" => "success", 'urlToLoad' => $urlToLoad, 'loginUserUniqueHandle' => Yii::app()->session['TinyUserCollectionObj']['uniqueHandle'], 'opportunityId' => $opportunityId,'pageNavigation'=>$pageNavigation);
                                     $resultData = $this->rendering($obj);
                                         echo $resultData;
                                    }
                                    else {
                                        $this->renderPartial('/common/newuserjoyride', array('joyrideInfo' => $result['info'], 'urlToLoad' => $urlToLoad, 'loginUserUniqueHandle' => Yii::app()->session['TinyUserCollectionObj']['uniqueHandle'], 'opportunityId' => $opportunityId, 'nextOpportunity' => $result['nextOpportunity']));
                                    }
                                            
                                }
                 
                            } 

                    }
                  
                }
            } catch (Exception $e) {
               
                Yii::log("Exception Occurred in actionGetJoyrideDetails==" . $e->getMessage(), "error", "application");
            }
        } catch (Exception $e) {
          
             Yii::log("Exception Occurred in actionGetJoyrideDetailssss==" . $e->getMessage(), "error", "application");
        }
    }
    
     public function actionGetPictocvImages() {
         try{
             $userId = (int)$this->tinyObject['UserId'];
             $pictocvObj = PictocvCollection::model()->getPictocvObjectByUserId($userId);
             if($pictocvObj!=null){
                $tinyUser = UserCollection::model()->getTinyUserCollection((int) $userId);
                $controller = new CController('post');
                $resultantPreparedHtml = $controller->renderInternal(Yii::app()->basePath . '/views/post/userAchievementProgress.php',  array("pictocvObj" => $pictocvObj,'profilePicture'=>$tinyUser->profile250x250), 1);
                echo $resultantPreparedHtml;
             }else{
                echo "";
             }
         } catch (Exception $ex) {
             
            Yii::log("PostController:actionGetPictocvImages::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
         }
     }



}
 
