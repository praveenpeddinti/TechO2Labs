<?php

/**
 * Developer Name: Swarna Rahul M
 * News Controller will be used for Content Management from Curators API and Release Management.
 * 
 */
class NewsController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function init() {
        try{
        parent::init();
        if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            CommonUtility::reloadUserPrivilegeAndData($this->tinyObject->UserId);
            $this->userPrivileges = Yii::app()->session['UserPrivileges'];
            $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
            $this->whichmenuactive = 5;
        } else {
            $this->redirect('/');
        }
        $this->sidelayout = 'no';
        } catch (Exception $ex) {
            Yii::log("NewsController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * suresh reddy here
     */
    public function actionError() {
        try{
        $cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->baseUrl;
        $cs->registerCssFile($baseUrl . '/css/error.css');
        if ($error = Yii::app()->errorHandler->error) {
            $this->render('error', $error);
        }
        } catch (Exception $ex) {
            Yii::log("NewsController:actionError::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex() {
        try {
            $streamIdArray = array();
            $previousStreamIdArray = array();
            $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
            if(!empty($previousStreamIdString)){
                $previousStreamIdArray = explode(",", $previousStreamIdString);
            }
            if (isset($_GET['StreamPostDisplayBean_page'])) {

                
                $pageSize = 10;
                $mongoCriteria = new EMongoCriteria;
                
            $orCondition=array(
                            '$or' =>[
                         
                                array(
                                        'CategoryType' => 8, 'Released'=>1
                                    )
                                    ,
                                array(
                                    'CategoryType' => 13,
                                     'DisplayPage' => 'News'
                                ),
                            
                    ],
                );

               $mongoCriteria->setConditions($orCondition);
               $mongoCriteria->UserId('in', array(0,$this->tinyObject->UserId));
               
               $mongoCriteria->IsDeleted('==', 0);
               $mongoCriteria->IsAbused('==', 0);
               $mongoCriteria->sort('IsSaveItForLater', EMongoCriteria::SORT_DESC);
               $mongoCriteria->sort('IsPromoted', EMongoCriteria::SORT_DESC);
               $mongoCriteria->sort('IsSaveItForLater', EMongoCriteria::SORT_DESC);
               $mongoCriteria->sort('CreatedOn', EMongoCriteria::SORT_DESC);
               $mongoCriteria->sort('UserId', EMongoCriteria::SORT_DESC);
               
               $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                   'pagination' => array('pageSize' => $pageSize),
                   'criteria' => $mongoCriteria
               ));
                if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                   $UserId =  $this->tinyObject['UserId'];
                 //  $dataArray = array_merge(CommonUtility::getUserSaveItForLaterNewsStream($this->tinyObject['UserId']),$provider->getData());
                   $streamRes = (object) (CommonUtility::prepareStreamData($UserId, $provider->getData(), $this->userPrivileges, 0, Yii::app()->session['PostAsNetwork'],'',$previousStreamIdArray));
                   $streamIdArray=$streamRes->streamIdArray;
                   $totalStreamIdArray=$streamRes->totalStreamIdArray;
                   $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                   $streamIdArray = array_values(array_unique($streamIdArray));
                   $stream=(object)($streamRes->streamPostData);
                 
                  
                } else {
                    $stream = -1; //No more posts
                }
                $streamData = $this->renderPartial('stream_view', array('stream' => $stream,'userLanguage'=>Yii::app()->session['language']), true);
                $streamIdString = implode(',', $streamIdArray);
                echo $streamData."[[{{BREAK}}]]".$streamIdString;
            }
            else{
            //    $stream=$this->loadAdsOnload();
//               $this->render('index', array('stream'=>$stream));
               $this->render('index');
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in NewsController->actionIndex==". $ex->getMessage());
            Yii::log("NewsController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
                                 'DisplayPage' => 'News'
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
        } catch (Exception $ex) {
            Yii::log("NewsController:loadAdsOnload::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }  
    public function actionRenderNewsDetailedPage(){
        try{
            $id = $_REQUEST['id'];
            $condition = array(
                       '_id' => array('==' => new MongoId($id)),
                    );
            $provider = new EMongoDocumentDataProvider('CuratedNewsCollection', array(
                    'pagination' => FALSE,
                    'criteria' => array(
                       'conditions' => $condition,
                        )
                    
                ));
            if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else {
                    $stream = (object) $provider->getData();
                }
            $canMarkAsAbuse = 0;
            $UserPrivileges = $this->userPrivileges;
            if (is_array($UserPrivileges)) {
                foreach ($UserPrivileges as $value) {
                    if ($value['Status'] == 1) {
                        if ($value['Action'] == 'Mark_As_Abuse') {
                            $canMarkAsAbuse = 1;
                        }
                        else if ($value['Action'] == 'Save_It_For_Later') {
                                
                                $CanSaveItForLater=1;
                        }
                        
                    }
                }
            }
            $this->renderPartial('newsDetailedPage', array('stream' => $stream,"canMarkAsAbuse"=>$canMarkAsAbuse));
        } catch (Exception $ex) {
            error_log("Exception Occurred in NewsController->actionRenderNewsDetailedPage==". $ex->getMessage());
            Yii::log("NewsController:actionRenderNewsDetailedPage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionRenderPostDetailed() {
        try {  
            $postId = $_REQUEST['postId'];
            $categoryType = $_REQUEST['categoryType'];
            $postType = $_REQUEST['postType'];    
            $id = $_REQUEST['id'];
            $mainGroupCollection="";
            $MoreCommentsArray = array();
            $tinyUserProfileObject = array();
            $recentActivity='';
            $inviteMessage='';
            $object = array();
//            $object = ServiceFactory::getSkiptaPostServiceInstance()->getNewsObjectById($postId);
            $timezone = Yii::app()->session['timezone'];
            $IsLoadRequest = isset($_REQUEST['load']) ? 1 : 0;
            $loggedInUserId =  $this->tinyObject['UserId'];
            $UserPrivileges = $this->userPrivileges;
            $isPostManagement = 0;
            if (isset($_REQUEST['isPostManagement'])) {
                $isPostManagement = 1;
            }
            $object = CommonUtility::preparePostDetailData($postId, $postType, $categoryType, $loggedInUserId, $IsLoadRequest,$UserPrivileges, '', $timezone, $isPostManagement);
            $networkId = $this->tinyObject['NetworkId'];
            $segmentId = (int) $this->tinyObject['SegmentId'];
            ServiceFactory::getSkiptaPostServiceInstance()->trackEngagementAction($loggedInUserId, "Post", "PostDetailOpen", $postId, $categoryType, $postType, $networkId, "", $segmentId); 
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
           if(isset($_REQUEST['recentActivity']) &&  $_REQUEST['recentActivity']!="undefined" ){
                   $recentActivity =$_REQUEST['recentActivity'];
                }
                 if ($_REQUEST['recentActivity'] == "invite") {
                    $inviteArray = $object->Invite;
                    $userId = $this->tinyObject['UserId'];

                    foreach ($inviteArray as $n) {
                        $isPresent = in_array($userId, $n[1]);
                        if ($isPresent) {
                            $inviteMessage = $n[2];
                            break;
                        }
                    }
                }


         //This code is for get post all comment and prepare comments data with web snippets  
            
             $MinpageSize = 10;
        $page=0;
        $pageSize = ($MinpageSize * $page);
        $categoryType = (int) $categoryType;
        
         $MoreCommentsArray = CommonUtility::prepareComments($pageSize, $MinpageSize, $postId, $categoryType, "",$MinpageSize);
        }else{
            $object = 0;            
        }
        $commentedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getCommentedUsersForPost($postId, (int)($this->tinyObject['UserId']));
        $IsUserCommented = in_array((int)($this->tinyObject['UserId']), $commentedUsers);
       
         $lovefollowArray =  CommonUtility::getLoveAndFollowUsers($this->tinyObject['UserId'],$object->Love, $object->Followers);
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
        $this->renderPartial("newsDetailedPag"
                . "e", array("data" => $object, "tinyObject" => $tinyUserProfileObject, "categoryType" => $categoryType,'commentsdata'=>$MoreCommentsArray,'IsCommented'=>$IsUserCommented,"lovefollowArray"=>$lovefollowArray,"canMarkAsAbuse"=>$canMarkAsAbuse));
        $userId = $this->tinyObject['UserId'];  
        //ServiceFactory::getSkiptaPostServiceInstance()->trackEngagementAction($userId,"Post","PostDetailOpen",$postId,$categoryType,$postType);

        } catch (Exception $ex) {
            Yii::log("NewsController:actionRenderPostDetailed::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionGeteditorial() {
        try{
        $data = ServiceFactory::getSkiptaPostServiceInstance()->GetEditorialService($_POST['postId']);
        $result = array("code" => 200, "status" => "",'data' => $data);
        echo $this->rendering($result);
        } catch (Exception $ex) {
            Yii::log("NewsController:actionGeteditorial::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
      /**
     * @author Moin Hussain
     * This method is used to search posts
     */
    public function actionGetNewsForSearch() {
        try{
        $searchText = $_POST['search'];
        $offset = $_POST['offset'];
        $pageLength = $_POST['pageLength'];
        $postSearchResult = ServiceFactory::getSkiptaPostServiceInstance()->getNewsForSearch($searchText, $offset, $pageLength);
        $this->renderPartial('game_search', array('postSearchResult' => $postSearchResult));
        //echo CJSON::encode($result);
        } catch (Exception $ex) {
            Yii::log("NewsController:actionGetNewsForSearch::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionPostdetail(){
     try{
         $postId = $_REQUEST['postId'];
        $categoryType = $_REQUEST['categoryType'];
        $postType = $_REQUEST['postType'];
        $out = $_REQUEST['outer'];
         $this->render('/post/postdetail',array('postId'=>$postId,'categoryType'=>$categoryType,'postType'=>$postType,'outer'=>$out));
     } catch (Exception $ex) {
         Yii::log("NewsController:actionPostdetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
 }
    
}
