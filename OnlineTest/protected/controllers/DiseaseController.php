<?php

/**
 * Developer Name: Haribabu
 * CurbsidePost Controller  class,  all curbsidepost module realted actions here 
 *
 */
class DiseaseController extends Controller {

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
            $this->whichmenuactive = 2;
        } else {
            $this->redirect('/');
        }
        $this->sidelayout = 'yes';
        CommonUtility::registerClientScript('', 'curbside.js');
        }catch(Exception $ex) {
            Yii::log("DiseaseController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
        }catch(Exception $ex) {
            Yii::log("DiseaseController:actionError::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * This method is index file of curbside post
     *  @author Haribabu
     */
    public function actionIndex() {
    try{
        $this->render('index', array());
        }catch(Exception $ex) {
            Yii::log("DiseaseController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * This method is used for rendering categories and hashtags deatails
     *  @author Haribabu
     */
    public function actionCategoriesdetails() {
        try
        {
        $obj = array();
        $categories = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsideCategoriesFromMongo();
        $categoriescount = count($categories);
        $userFollowingCategories = array();
      $userNonFollwoingCategories=array();
        foreach ($categories as $rw) {
            if (in_array((int) Yii::app()->session['UserStaticData']->UserId, $rw->Followers) > 0) {
            
                array_push($userFollowingCategories, $rw);
                
            }
            else{
                array_push($userNonFollwoingCategories,$rw);
            }
        }
      
        if (count($userFollowingCategories) > 0 ) {
            if(count($userFollowingCategories)<5 && $categoriescount>count($userFollowingCategories) )
            {
                       
                            foreach ($userNonFollwoingCategories as $ufc)
                            {
                                 if(count($userFollowingCategories)>5)
                                 break;
                                  if(count($userFollowingCategories)<=5)
                                  {
                                        array_push($userFollowingCategories, $ufc);
                                     
                                  }
                               
                                
                                
                            }
            }
           
            $categories = $userFollowingCategories;
        }
      
        $hashtags = ServiceFactory::getSkiptaPostServiceInstance()->getHashtagsForCurbsidePost();
        if ($hashtags != "noHashTag") {
            $hashtagcount = count($hashtags);
        } else {
            $hashtagcount = 0;
        }

      
        $obj = array("result" => "success", "categories" => $categories, "hashtags" => $hashtags, "categoriescount" => $categoriescount, "hashtagscount" => $hashtagcount,loginUserId=>(int) Yii::app()->session['UserStaticData']->UserId);
        $this->renderPartial('/curbsidePost/diseaseLeftMenuTopics', $obj);
        }
        catch(Exception $ex)
        {
            error_log("Exception Occurred in DiseaseController->actionCategoriesdetails==". $ex->getMessage());
            Yii::log("DiseaseController:actionCategoriesdetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetUserGroupsLeftMenu() {
        try {
            $startLimit = $_REQUEST['startLimit'];
            if (!isset($startLimit)) {
                $startLimit = 0;
            }
            $pageLength = 5;
            $userFollowingGroups = ServiceFactory::getSkiptaTopicServiceInstance()->getUserGroupsList(Yii::app()->session['UserStaticData']->UserId, $startLimit, $pageLength);
            $userFollowingGroupsCount = ServiceFactory::getSkiptaTopicServiceInstance()->getUserGroupsList(Yii::app()->session['UserStaticData']->UserId, 0, 0);
            $obj = array("result" => "success", "groups" => $userFollowingGroups, "groupsCount" => count($userFollowingGroupsCount));

            $this->renderPartial('/curbsidePost/diseaseLeftMenuGroups', $obj);
        } catch (Exception $ex) {
            Yii::log("DiseaseController:actionGetUserGroupsLeftMenu::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar Pathapelli
     */
    public function actionGetcurbsideposts() {
        try{
        Yii::app()->session['categoryId']="";
        Yii::app()->session['categoryName']="";
        $streamIdArray = array();
        $previousStreamIdArray = array();
        $previousStreamIdString = isset($_POST['previousStreamIds']) ? $_POST['previousStreamIds'] : "";
        if (!empty($previousStreamIdString)) {
            $previousStreamIdArray = explode(",", $previousStreamIdString);
        }
      
        if (isset($_GET['StreamPostDisplayBean_page'])) {
              
            $pageSize = 10;
            $groupsfollowing = ServiceFactory::getSkiptaPostServiceInstance()->getUserFollowingGroupsIDs((int) $this->tinyObject['UserId']);
            array_push($groupsfollowing, '');

            $conditionalArray = array(
                'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                'CategoryType' => array('in' => array(2, 3,13)),
                'IsDeleted' =>  array('notIn' => array(1, 2)),
                'IsAbused' => array('notIn' => array(1, 2)),
                'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                'GroupId' => array('in' => $groupsfollowing),
            );
            if (isset($_GET['CategoryId'])) {
                $CategoryId = $_GET['CategoryId'];
                $CategoryName = $_GET['CategoryName'];
                Yii::app()->session['categoryId']=$CategoryId;
                 Yii::app()->session['categoryName']=$CategoryName;
                if (is_numeric($CategoryId) && $CategoryId != "undefined") {
                    $conditionalArray = array(
                        'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                        'CategoryType' => array('in' => array(2, 3,13)),
                        'CurbsideCategoryId' => array('==' => (int) $CategoryId),
                        'IsDeleted' =>  array('notIn' => array(1, 2)),
                        'IsAbused' => array('notIn' => array(1, 2)),
                        'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                        'GroupId' => array('in' => $groupsfollowing),
                    );
                }
            }
            if (isset($_GET['HashtagId'])) {
                $HashtagId = $_GET['HashtagId'];
                if ($HashtagId != "undefined" && $HashtagId != "") {
                    $conditionalArray = array(
                        'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                        'CategoryType' => array('in' => array(2,3,13)),
                        'HashTags' => array('in' => array(new MongoID($HashtagId))),
                        'IsDeleted' =>  array('notIn' => array(1, 2)),
                        'IsAbused' => array('notIn' => array(1, 2)),
                        'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                        'GroupId' => array('in' => $groupsfollowing),
                    );
                }
            }

            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                'pagination' => array('pageSize' => $pageSize),
                'criteria' => array(
                    'conditions' => $conditionalArray,
                    //'conditions'=>array('UserId'=>array('in' => array($this->tinyObject['UserId'],0))),
                    'sort' => array('IsPromoted'=>EMongoCriteria::SORT_DESC,'IsSaveItForLater'=>EMongoCriteria::SORT_DESC,'CreatedOn' => EMongoCriteria::SORT_DESC),
                )
            ));
            $timezone = $_REQUEST['timezone'];
            

            if ($provider->getTotalItemCount() == 0) {

                $stream = 0; //No posts
            } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {

                $UserId = $this->tinyObject['UserId'];
                $streamRes = (object) (CommonUtility::prepareStreamData($UserId, $provider->getData(), $this->userPrivileges, 0, Yii::app()->session['PostAsNetwork'], $timezone, $previousStreamIdArray));
                $streamIdArray = $streamRes->streamIdArray;
                $totalStreamIdArray = $streamRes->totalStreamIdArray;
                $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                $streamIdArray = array_values(array_unique($streamIdArray));

                $stream = (object) ($streamRes->streamPostData);
            } else {

                $stream = -1; //No more posts
            }

            $streamData = $this->renderPartial('/curbsidePost/topicposts', array('stream' => $stream, 'streamIdArray' => $streamIdArray, 'totalStreamIdArray' => $totalStreamIdArray), true);
            $streamIdString = implode(',', $streamIdArray);
            echo $streamData . "[[{{BREAK}}]]" . $streamIdString;
        }
        }catch(Exception $ex) {
            Yii::log("DiseaseController:actionGetcurbsideposts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionGetTopics() {
        try{
        $streamIdArray = array();
        $previousStreamIdArray = array();
        $finalarray = array();
        $TopicIdArray = array();
        $previousStreamIdString = isset($_POST['previousStreamIds']) ? $_POST['previousStreamIds'] : "";
        if (!empty($previousStreamIdString)) {
            $previousStreamIdArray = explode(",", $previousStreamIdString);
        }
        //$page="";
        $pazeSize = 6;
        $streamIdArray = array();
        $previousStreamIdArray = array();
        $previousStreamIdString = isset($_POST['previousStreamIds']) ? $_POST['previousStreamIds'] : "";
        if (!empty($previousStreamIdString)) {
            $previousStreamIdArray = explode(",", $previousStreamIdString);
        }
//        if(!isset($_GET['StreamPostDisplayBean_page']))
//        { 
        if (isset($_GET['StreamPostDisplayBean_page'])) {
            $page = $_GET['StreamPostDisplayBean_page'];
        }
        // $page=1;
        $limit = $page * $pazeSize;

        if ($page == 1) {
            $offset = 0;
        } else {
            $offset = (int) $limit - $pazeSize;
        }



        $conditionalArray = array(
            'Status' => array('==' => 1),
        );
        $streamPostData = CurbSideCategoryCollection::model()->getCategoriesForStream($pazeSize, $offset);

        if ($page == 1 && sizeof($streamPostData) == 0) {
            $stream = 0; //No posts
            $streamData = $this->renderPartial('topics_view', array('stream' => $stream));
        } else if ($page != 1 && sizeof($streamPostData) == 0) {
            $stream = -1; //No more posts
            $streamData = $this->renderPartial('topics_view', array('stream' => $stream));
        } else {

            foreach ($streamPostData as $key => $data) {
                $streamRes = "";
                if (!in_array($data['CategoryId'], $previousStreamIdArray)) {
                    $topicDetails = new TopicDetailsBean();
                    if (is_array($data['Post']) && sizeof($data['Post']) > 0) {
                        $postId = end($data['Post']);


                        $conditionalArray = array(
                            'UserId' => array('in' => array($this->tinyObject['UserId'], 0)),
                            'CategoryType' => array('in' => array(2)),
                            'IsDeleted' => array('!=' => 1),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'PostId' => array('==' => new MongoId($postId))
                        );


                        $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                            'pagination' => array('pageSize' => $pageSize),
                            'criteria' => array(
                                'conditions' => $conditionalArray,
                                //'conditions'=>array('UserId'=>array('in' => array($this->tinyObject['UserId'],0))),
                                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                            )
                        ));
                        $streamRes = (object) (CommonUtility::prepareStreamData($UserId, $provider->getData(), $this->userPrivileges, 0, Yii::app()->session['PostAsNetwork'], "", $previousStreamIdArray));
                        $streamIdArray = $streamRes->streamIdArray;
                        $totalStreamIdArray = $streamRes->totalStreamIdArray;
                        $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                        $streamIdArray = array_values(array_unique($streamIdArray));
                        $stream = $streamRes->streamPostData[0];
                        $topicDetails->Post = $stream;
                    } else {
                        $topicDetails->Post = "";
                    }

                    $topicDetails->TopicId = $data['CategoryId'];
                    $topicDetails->TopicName = $data['CategoryName'];
                    $topicDetails->ProfileImage = $data['ProfileImage'];
                    $topicDetails->Followers = sizeof($data['Followers']);
                    $topicDetails->NumberOfPosts = $data['NumberOfPosts'];

                    if (in_array($this->tinyObject['UserId'], $data['Followers'])) {
                        $topicDetails->IsFollow = 1;
                    } else {
                        $topicDetails->IsFollow = 0;
                    }

                    array_push($finalarray, $topicDetails);
                    array_push($TopicIdArray, $data['CategoryId']);
                }
            }
            $streamData = $this->renderPartial('topics_view', array('stream' => $finalarray));
        }
//            }else{
//                $stream=-1;
//                $streamData=$this->renderPartial('topics_view', array('stream'=>$stream));
//            }
        $streamIdString = implode(',', $TopicIdArray);
        echo $streamData . "[[{{BREAK}}]]" . $streamIdString;
        //}
        }catch(Exception $ex) {
            Yii::log("DiseaseController:actionGetTopics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actiontopics() {
        try{
            $this->render('topic');
        }catch(Exception $ex) {
            Yii::log("DiseaseController:actiontopics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }        
    }

    public function actionTrending() {
        try{
        $this->render('trending');
        }catch(Exception $ex) {
            Yii::log("DiseaseController:actionTrending::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actiongetTrendingDetails() {
        try{
        $data = gmdate('m/d/Y', strtotime("-30 days"));
        $startDate = date('Y-m-d', strtotime($data));
        $endDate = date('Y-m-d');
        $endDate = trim($endDate) . " 23:59:59";
        $startDate = trim($startDate) . " 00:00:00";
        $networkId = $this->tinyObject['NetworkId'];
        $streamIdArray = array();
        $previousStreamIdArray = array();
        $ordered = array();
        $previousStreamIdString = isset($_POST['previousStreamIds']) ? $_POST['previousStreamIds'] : "";
        if (!empty($previousStreamIdString)) {
            $previousStreamIdArray = explode(",", $previousStreamIdString);
        }
        if (isset($_GET['StreamPostDisplayBean_page'])) {


            $pageSize = 6;
            $page = $_GET['StreamPostDisplayBean_page'];

            $limit = $page * $pageSize;

            if ($page == 1) {
                $offset = 0;
            } else {
                $offset = (int) $limit - $pageSize;
            }
            $result = ServiceFactory::getSkiptaTopicServiceInstance()->Trending($startDate, $endDate, $networkId, $limit, $offset);

            $posts = array();
            foreach ($result as $key => $value) {
                $postId = new MongoID($value['_id']['PostId']['PostId']);
                array_push($posts, $postId);
            }

            $UserId = $this->tinyObject['UserId'];
            $conditionalArray = array(
               'PostId' => array('in' => $posts),
                'UserId' => array('==' => 0)
               
            );

            $timezone = $_REQUEST['timezone'];
            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                //'pagination' => array('pageSize' => $pageSize),
                'criteria' => array(
                    'conditions' => $conditionalArray,
                    //'conditions'=>array('UserId'=>array('in' => array($this->tinyObject['UserId'],0))),
                    //'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                )
            ));
           
            if ($page == 1 && sizeof($result) == 0) {
                $stream = 0; //No posts
            } else if ($page != 1 && sizeof($result) == 0) {
                $stream = -1; //No more posts
            } else if ($offset <= 24) {

                $UserId = $this->tinyObject['UserId'];
                $streamRes = (object) (CommonUtility::prepareStreamData($UserId,$provider->getData(), $this->userPrivileges, 0, Yii::app()->session['PostAsNetwork'], $timezone, $previousStreamIdArray));
                $streamIdArray = $streamRes->streamIdArray;
                $totalStreamIdArray = $streamRes->totalStreamIdArray;
                $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                $streamIdArray = array_values(array_unique($streamIdArray));
                $streamarray = ($streamRes->streamPostData);
                
                 
                for($j=0;$j< sizeof($posts);$j++){
                
                foreach ($streamarray as $key => $value) {
                   
                    if ($posts[$j] == $value['PostId']) {
                        $ordered[$j]=$streamarray[$key];
                    }
                }
                }
                $stream=(object)$ordered;
                
            } else {
                $stream = -1; //No more posts
            }

            $streamData = $this->renderPartial('/curbsidePost/topicposts', array('stream' => $stream, 'streamIdArray' => $streamIdArray, 'totalStreamIdArray' => $totalStreamIdArray), true);
            $streamIdString = implode(',', $streamIdArray);
            echo $streamData . "[[{{BREAK}}]]" . $streamIdString;
        }
        }catch(Exception $ex) {
            Yii::log("DiseaseController:actiongetTrendingDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
   public function actionDeleteNeteworkInvite()
    {
        try
        {
           
            if(isset($_REQUEST['streamId']))
            {
               $result= ServiceFactory::getSkiptaTopicServiceInstance()->deleteNetworkStreamInvite($_REQUEST['streamId']);
            
               echo $result;
            }
            
        } catch (Exception $ex) {
            Yii::log("DiseaseController:actionDeleteNeteworkInvite::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}
