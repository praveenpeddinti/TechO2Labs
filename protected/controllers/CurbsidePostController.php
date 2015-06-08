<?php

/**
 * Developer Name: Haribabu
 * CurbsidePost Controller  class,  all curbsidepost module realted actions here 
 *
 */
class CurbsidePostController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function init() {
        try{
            parent::init();
                if(isset(Yii::app()->session['TinyUserCollectionObj'])){
                     $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];
                    $this->userPrivileges=Yii::app()->session['UserPrivileges'];
                    $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
                    $this->whichmenuactive=2;
                 }else{
                      $this->redirect('/');
                 }
                 $this->sidelayout='yes';
            CommonUtility::registerClientScript('','curbside.js');
        } catch (Exception $ex) {
            Yii::log("CurbsidePostController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
        /**
 * suresh reddy  for gloabl erro page
 */
    public function actionError() {
        try{
            $cs = Yii::app()->getClientScript();
            $baseUrl=Yii::app()->baseUrl; 
            $cs->registerCssFile($baseUrl.'/css/error.css');
            if($error=Yii::app()->errorHandler->error)
                $this->render('error', $error);
        } catch (Exception $ex) {
            Yii::log("CurbsidePostController:actionError::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}
    /**
     * This method is index file of curbside post
     *  @author Haribabu
     */
 public function actionIndex(){
    try{ 
        $CurbsidePostModel = new CurbsidePostForm();
        $segmentId = isset(Yii::app()->session['TinyUserCollectionObj']['SegmentId'])?(int)Yii::app()->session['TinyUserCollectionObj']['SegmentId']:0;
        $categories = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsideCategoriesBySegment($segmentId);
        $categoriesObj = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsideCategoriesFromMongo();
        $hashtags = ServiceFactory::getSkiptaPostServiceInstance()->getHashtagsForCurbsidePostFilters();
       // print_r($hashtags);exit;
        $this->render('index', array('CurbsidePostModel'=>$CurbsidePostModel,'categories'=>$categories,'categoriesObj'=>$categoriesObj,'hashtagsObj'=>$hashtags,'canFeatured'=>$this->userPrivilegeObject->canFeature));
    } catch (Exception $ex) {
        Yii::log("CurbsidePostController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
 /**
  * CreateCurbsidepost() is used to save the curbside post and update the categories post count
  *  @author Haribabu
  */
 public function actionCreateCurbsidepost(){
     
        $CurbsidePostModel = new CurbsidePostForm();
        try {
            $obj = array();
            $hashTagArray=array();
            $atMentionArray=array();
            if (isset($_POST['CurbsidePostForm'])) {
             $CurbsidePostModel->attributes = $_POST['CurbsidePostForm'];
                $errors = CActiveForm::validate($CurbsidePostModel);
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    $CurbsidePostModel->Type="CurbsidePost";
                    $CurbsidePostModel->PostedBy = $this->tinyObject['UserId'];
                    $CurbsidePostModel->UserId = $this->tinyObject['UserId']; 
                    $CurbsidePostModel->NetworkId=$this->tinyObject['NetworkId'];
                    $explosion = explode("#", strstr($CurbsidePostModel->HashTags, '#'));
                    $count = count($explosion);
                    $hashtags="";
                     for($i = 0; $i < $count; $i++){
                         if(strlen($explosion[$i])>2){
                            $explosion2 = explode(" ", $explosion[$i]);
                            $explosion2 = explode(" ", $explosion2[0]);//it is a special character
                            $explosion2 = $explosion2[0];
                            $hashtags.=",".$explosion2;
                         }
                     }
                    $hashtags=substr($hashtags,1);
                    if(strlen($hashtags)>0){
                        $hashTagArray = explode(",", $hashtags);
                        $hashTagArray = array_unique($hashTagArray);
                    }
                    $atMentions = strlen($CurbsidePostModel->Mentions)>0?substr($CurbsidePostModel->Mentions,1):"";
                    if(strlen($atMentions)>0){
                        $atMentionArray = explode(",", $atMentions);
                    }
                    $CurbsidePostModel->Mentions=$atMentionArray;
                    $CurbsidePostModel->Subject=$CurbsidePostModel->Subject;
                  
                     $Artifactslengh=strlen($CurbsidePostModel->Artifacts);
                    if($Artifactslengh >0){
                       
                        $CurbsidePostModel->Artifacts= explode(",",$CurbsidePostModel->Artifacts);
                    }else{
                        $CurbsidePostModel->Artifacts=array();
                    }
                    $postObj = ServiceFactory::getSkiptaPostServiceInstance()->saveCurbidePost($CurbsidePostModel,$hashTagArray);
                    if ($postObj != 'failure') {
                        $message = Yii::t('translation', 'CurbsidePost_Saving_Success');
                        $obj = array('status' => 'success', 'data' => $message);
                    } else {
                        $message = Yii::t('translation', 'CurbsidePost_Saving_Fail');
                        $errorMessage = array('CurbsidePostForm_Description' => $message);
                        $obj = array("status" => 'error', 'data' => $message, "error" => $errorMessage);
                    }
                }     
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            }else{
            
                $this->render('index', array('CurbsidePostModel'=>$CurbsidePostModel));
            }
        } catch (Exception $ex) {
            Yii::log("CurbsidePostController:actionCreateCurbsidepost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     
     
     
 }
   
/**
 * This method is used for rendering categories and hashtags deatails
 *  @author Haribabu
 */
public function actionCategoriesdetails(){
    try{
        $obj=array();
        $userId = $this->tinyObject['UserId']; 
        $segmentId = isset(Yii::app()->session['TinyUserCollectionObj']['SegmentId'])?(int)Yii::app()->session['TinyUserCollectionObj']['SegmentId']:0;
        $categories = ServiceFactory::getSkiptaPostServiceInstance()->getCategoriesBySegmentId($userId, $segmentId);

        $hashtags = ServiceFactory::getSkiptaPostServiceInstance()->getHashtagsBySegmentId($userId, $segmentId);
        if($hashtags!="noHashTag"){
            $hashtagcount=count($hashtags);
        }else{
            $hashtagcount=0;
        }

        $categoriescount=count($categories);
        $obj = array("result" => "success", "categories" => $categories, "hashtags" => $hashtags, "categoriescount" => $categoriescount, "hashtagscount" => $hashtagcount);
        $renderScript = $this->rendering($obj);
            echo $renderScript;
    } catch (Exception $ex) {
            Yii::log("CurbsidePostController:actionCategoriesdetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}
    
  public function actionUpload(){
      try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            //  $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'];
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "exe", "mov", "mp4", "mp3", "txt", "doc", "docx", "pptx", "xlsx", "pdf", "ppt", "xls", "3gp", "php", "ini", "avi", "rar", "zip", "png", "tiff"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //$sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
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

            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
    } catch (Exception $ex) {
        Yii::log("CurbsidePostController:actionUpload::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }  

  public function actionRemoveArtifacts(){
        
        try {
             if(isset($_POST['filepath'])){
                $filepath=$_POST['filepath'];
            }else{
                $filepath="";
            }

            $f="'".$filepath."'";
            if (file_exists($filepath)) {
              
                if(unlink($filepath)){
                    $obj = array('status' => 'success', 'data' => '', 'error' => '','filename'=>$_POST['file'],'image'=>$_POST['image']);
                }else{
                     $obj = array('status' => 'failed', 'data' => '', 'error' => '','filename'=>$_POST['file'],'image'=>$_POST['image']);
                }
            }else{
                
            }
            $renderScript = $this->rendering($obj);
             echo $renderScript;  
             Yii::app()->end();
     } catch (Exception $ex) {
            Yii::log("CurbsidePostController:actionRemoveArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
        
  }   
       
   
        /**
         * @author suresh reddy
         * @param curbside categoryId,
         * @return curbside category object
         */
public function actionGetCurbsideMiniProfile(){
    try{
        if(isset($_REQUEST['categoryId'])){
            $categoryId = $_REQUEST['categoryId'];
            $result = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsideCategoryMiniProfile($categoryId,Yii::app()->session['TinyUserCollectionObj']->UserId);
        }
        $CurbsideProfileBean =new CurbsideProfileBean();
        if(isset($result->Followers) && $result->Followers!=null){
          $CurbsideProfileBean->FollowersCount=count($result->Followers);   
          $CurbsideProfileBean->IsUserFollowing=in_array(Yii::app()->session['TinyUserCollectionObj']->UserId, $result->Followers)?true:false;
        }else{
          $CurbsideProfileBean->FollowersCount=0; 
          $CurbsideProfileBean->IsUserFollowing=false;
        }
         $CurbsideProfileBean->CategoryName=$result->CategoryName; 
         $CurbsideProfileBean->CategoryId=$result->CategoryId; 
         $CurbsideProfileBean->NumberOfPosts=$result->NumberOfPosts; 
         $CurbsideProfileBean->ProfileImage=$result->ProfileImage; 
        
        
        $obj = array('status' => 'success', 'data' => $CurbsideProfileBean, 'error' => '','categorySummary'=>Yii::t('translation','CategorySummary'));        
        echo CJSON::encode($obj);
        
    } catch (Exception $ex) {
       Yii::log("CurbsidePostController:actionGetCurbsideMiniProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
}

/**
  * This method is used to update the user follow/unfollow on hashtag
  * @param type $actionType (Follow/Unfollow)
  * @author Sagar Pathapelli
  */          
    public function actionFollowOrUnfollowCurbsideCategory(){
         try {
            $result = "failure";
            if(isset($_REQUEST['categoryId'])){
                $actionType = $_REQUEST['actionType'];
                $categoryId = $_REQUEST['categoryId'];
                //$userId = $this->tinyObject['UserId'];
                $userId = $this->tinyObject->UserId;
                $result = ServiceFactory::getSkiptaPostServiceInstance()->followOrUnfollowCurbsideCategory($categoryId,$userId,$actionType);
            }
             if($result == "failure"){
                throw new Exception('Unable to follow or unfollow');
               }
            $obj = array('status' => 'success', 'data' => $result, 'error' => '','translate_follow'=>Yii::t('translation','Follow'),'translate_unFollow'=>Yii::t('translation','UnFollow'));        
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            Yii::log("CurbsidePostController:actionFollowOrUnfollowCurbsideCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $id = "socialactionsError_".$_REQUEST['categoryId'];
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
     * @author Sagar Pathapelli
     */
 public function actionGetcurbsideposts(){
       try {
            if (isset($_GET['StreamPostDisplayBean_page'])) {
                $networkId = (int) $this->tinyObject['NetworkId'];
                $networkIds = array($networkId);
                //$networkIds = array_map('intval', $networkIds);
                $streamIdArray = array();
                $previousStreamIdArray = array();
                $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
                if(!empty($previousStreamIdString)){
                    $previousStreamIdArray = explode(",", $previousStreamIdString);
                }
                $timezone = $_REQUEST['timezone'];
                
                $pageSize = 10;
                 $mongoCriteria = new EMongoCriteria;
                 $orCondition=array('$or' =>[array('UserId' => 0,'SegmentId' =>  array('$in'=>array((int) $this->tinyObject['SegmentId'],0)), ),array('UserId' => (int)$this->tinyObject['UserId'])],
                );
                  if(trim($this->tinyObject['Language'])!="en"){
                 array_push($orCondition['$or'], array("Language"=>$this->tinyObject['Language']));
                  }
                $mongoCriteria->setConditions($orCondition);
                
                  if (isset($_GET['CategoryId'])) {
                    $CategoryId = $_GET['CategoryId'];

                    if (is_numeric($CategoryId) && $CategoryId != "undefined") {
                        $mongoCriteria->CurbsideCategoryId('==', (int) $CategoryId);
                    }
                }
                if (isset($_GET['HashtagId'])) {
                    $HashtagId = $_GET['HashtagId'];
                    if ($HashtagId != "undefined" && $HashtagId != "") {

                        $mongoCriteria->HashTags('in', array(new MongoID($HashtagId)));
                    }
                }
                
               // $mongoCriteria->GroupId('in', $groupsfollowing);
                $mongoCriteria->IsDeleted('==', 0);
                $mongoCriteria->IsBlockedWordExist('notIn', array(1, 2));
                $mongoCriteria->IsAbused('notIn', array(1, 2));
                $mongoCriteria->CategoryType('in', array(2,13));
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

                    $UserId =  $this->tinyObject['UserId'];
                        $dataArray = array_merge($provider->getData(), array());
                     //$dataArray = array_merge($dataArray,CommonUtility::getUserSaveItForLaterStream($UserId,array(7,9,10,11,12,13),'stream'));
                    $streamRes = (object) (CommonUtility::prepareStreamData($UserId,$dataArray, $this->userPrivileges, 3, Yii::app()->session['PostAsNetwork'],$timezone, $previousStreamIdArray));
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
                $streamData = $this->renderPartial('curbside_view', array('stream' => $stream, 'streamIdArray'=>$streamIdArray,'totalStreamIdArray'=>$totalStreamIdArray,'userLanguage'=>Yii::app()->session['language']), true);
                $streamIdString = implode(',', $streamIdArray);
                echo $streamData."[[{{BREAK}}]]".$streamIdString;
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in CurbsidePostController->actionGetcurbsideposts==". $ex->getMessage());
            Yii::log("CurbsidePostController:actionGetcurbsideposts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    
    }
    /**
     * @author Sagar
     * This method is to get the stream details
     */
    public function actionAbusedposts(){
        try{
        if(isset($_GET['AbusedCurbsidePostDisplayBean_page']))
        {
           $pageSize=10;
           $provider = new EMongoDocumentDataProvider('AbusedCurbsidePostDisplayBean',
                   
           array(
                'pagination' => array('pageSize' => $pageSize),
                'criteria' => array( 
                   'conditions'=>array(
                            'IsAbused'=>array('==' => 1)
                       ),
                   'sort'=>array('AbusedOn'=>EMongoCriteria::SORT_DESC)
                 )
               ));
           if($provider->getTotalItemCount()==0){
               $abusedposts=0;//No posts
           }else if($_GET['AbusedCurbsidePostDisplayBean_page'] <= ceil($provider->getTotalItemCount()/$pageSize)){
               $UserId =  $this->tinyObject['UserId'];
               $streamRes = (object)(CommonUtility::prepareStreamData($UserId, $provider->getData(),$this->userPrivileges,0,Yii::app()->session['PostAsNetwork'])); 
               $abusedposts=(object)($streamRes->streamPostData);
           }else
            {
                $abusedposts=-1;//No more posts
            }
            $this->renderPartial('abused_posts_view',array('abusedposts'=>$abusedposts));
        }
        } catch (Exception $ex) {
            Yii::log("CurbsidePostController:actionAbusedposts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    function actionTrackFilterByHashtag(){
          try{              
              $networkId = $this->tinyObject['NetworkId'];
        if(isset($_REQUEST['hashtagId'])){
            $hashtagId = $_REQUEST['hashtagId'];
            ServiceFactory::getSkiptaPostServiceInstance()->trackFilterByHashtag(Yii::app()->session['TinyUserCollectionObj']->UserId,$hashtagId,$networkId);
        }
        
        $obj = array('status' => 'success', 'data' => "", 'error' => '');        
        echo CJSON::encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("CurbsidePostController:actionTrackFilterByHashtag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
      function actionTrackFilterByCategory(){
          try{              
              $networkId = $this->tinyObject['NetworkId'];
        if(isset($_REQUEST['categoryId'])){
            $categoryId = $_REQUEST['categoryId'];
            ServiceFactory::getSkiptaPostServiceInstance()->trackFilterByCategory(Yii::app()->session['TinyUserCollectionObj']->UserId,$categoryId,$networkId);
        }
        
        $obj = array('status' => 'success', 'data' => "", 'error' => '');        
        echo CJSON::encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("CurbsidePostController:actionTrackFilterByCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
      public function actionFollowAllCurbsideCategories(){
        try {
            $userId = (int) (Yii::app()->session['NetworkAdminUserId']);
            echo $userId;
            $categoriesObj = CurbSideCategoryCollection::model()->getCategories();
            $i=0;
            
            foreach ($categoriesObj as $key => $category) {echo $i.", ";
                $i++;
                $categoryId = (string) $category->CategoryId;
                $result = ServiceFactory::getSkiptaPostServiceInstance()->followOrUnfollowCurbsideCategory($categoryId,$userId,'Follow');
            }
            echo $i." Curbside Categories followed";
        } catch (Exception $ex) {
            Yii::log("CurbsidePostController:actionFollowAllCurbsideCategories::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}
