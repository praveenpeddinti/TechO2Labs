<?php

/*
 * Developer Suresh Reddy
 * on 8 th Jan 2014
 * all users actions need to add here
 */

class RestpostController extends Controller {

     /**
     * @author Sagar
     * This method is to get the stream details
     */
    
    public function init() {
         
    }

    public function actionStream() {
        try {

            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
            
               if (isset($_POST['Page'])) {
                    $_GET['StreamPostDisplayBean_page'] = (int) $_POST['Page'];
                } else {
                    $_GET['StreamPostDisplayBean_page'] = (int) $_POST['StreamPostDisplayBean_page'];
                }
            }

            if (isset($_GET['StreamPostDisplayBean_page'])) {
                $streamIdArray = array();
                $previousStreamIdArray = array();
                $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
                if(!empty($previousStreamIdString)){
                    $previousStreamIdArray = explode(",", $previousStreamIdString);
                }
                $UserId= (int)$_POST['loggedUserId'];
                $networkId = (int) 1;
                $networkIds = array($networkId);
                //$networkIds = array_map('intval', $networkIds);
                $timezone = $_REQUEST['timezone'];
                if (isset($_GET['filterString'])) {
                    if ($_GET['filterString'] == 'Division') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Division' => array('==' => (int) (Yii::app()->session['UserHierarchy']['Division'])),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if ($_GET['filterString'] == 'District') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'District' => array('==' => (int) (Yii::app()->session['UserHierarchy']['District'])),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if ($_GET['filterString'] == 'Region') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Region' => array('==' => (int) (Yii::app()->session['UserHierarchy']['Region'])),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if ($_GET['filterString'] == 'Store') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Store' => array('==' => (int) (Yii::app()->session['UserHierarchy']['Store'])),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if ($_GET['filterString'] == 'Corporate') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Division' => array('==' => 0),
                            'District' => array('==' => 0),
                            'Region' => array('==' => 0),
                            'Store' => array('==' => 0),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }
                } else {
                    $groupsfollowing = ServiceFactory::getSkiptaPostServiceInstance()->getUserFollowingGroupsIDs((int) $UserId);
                    array_push($groupsfollowing, '');
                    $condition = array(
                        'UserId' => array('in' => array($UserId, 0)),
                        'GroupId' => array('in' => $groupsfollowing),
                        'IsDeleted' => array('!=' => 1),
                        'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                        'IsAbused' => array('notIn' => array(1, 2)),
                        'CategoryType' => array('notIn' => array(9, 7)),
                        'IsNotifiable' => array('==' => (int) 1)
                    );
                }
                $pageSize = 10;
                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => $condition,
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));
                if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $UserId =$UserId;// Yii::app()->session['PostAsNetwork'] == 1 ? Yii::app()->session['NetworkAdminUserId'] : $this->tinyObject['UserId'];
                      $dataArray = array_merge($provider->getData(), $this->getDerivateObjectsStream($UserId));
//                    $streamRes = (object) (CommonUtility::prepareStreamDataForMobile($UserId, $dataArray, '', 1, '', $timezone,$previousStreamIdArray));
//                    $streamIdArray=$streamRes->streamIdArray;
//                    $totalStreamIdArray=$streamRes->totalStreamIdArray;
//                    $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
//                    $streamIdArray = array_values(array_unique($streamIdArray));
//                    $stream=(object)($streamRes->streamPostData);
                    
                        $stream = (object) (CommonUtility::prepareStreamDataForMobile($UserId, $provider->getData(), "", 0, '', $timezone));
                    
                } else {
                    $stream = -1; //No more posts
                }
                if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                    $streamIdString = implode(',', $streamIdArray);
                    if ($stream == -1 || $stream == 0) {
                       // $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));
                          $x = json_encode($stream);

                        } else {
                        //$x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
                        $x = json_encode(array_values((array) $stream));

                    }
                    echo $x;
                } else {
                    $this->renderPartial('stream_view', array('stream' => $stream));
                }
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestpostController->actionStream==".$ex->getMessage());
            Yii::log("RestpostController:actionStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
       public function actionStream_V3() {
        try {


            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
            
               if (isset($_POST['Page'])) {
                    $_GET['StreamPostDisplayBean_page'] = (int) $_POST['Page'];
                } else {
                    $_GET['StreamPostDisplayBean_page'] = (int) $_POST['StreamPostDisplayBean_page'];
                }
            }

            if (isset($_GET['StreamPostDisplayBean_page'])) {
                $streamIdArray = array();
                $previousStreamIdArray = array();
                $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
                if(!empty($previousStreamIdString)){
                    $previousStreamIdArray = explode(",", $previousStreamIdString);
                }
                $UserId= (int)$_POST['loggedUserId'];
                $networkId = (int) 1;
                $networkIds = array($networkId);
                //$networkIds = array_map('intval', $networkIds);
                $timezone = $_REQUEST['timezone'];
                if (isset($_GET['filterString'])) {
                    if ($_GET['filterString'] == 'Division') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Division' => array('==' => (int) (Yii::app()->session['UserHierarchy']['Division'])),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if ($_GET['filterString'] == 'District') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'District' => array('==' => (int) (Yii::app()->session['UserHierarchy']['District'])),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if ($_GET['filterString'] == 'Region') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Region' => array('==' => (int) (Yii::app()->session['UserHierarchy']['Region'])),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if ($_GET['filterString'] == 'Store') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Store' => array('==' => (int) (Yii::app()->session['UserHierarchy']['Store'])),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }if ($_GET['filterString'] == 'Corporate') {
                        $condition = array(
                            'UserId' => array('in' => array($UserId, 0)),
                            'IsDeleted' => array('!=' => 1),
                            'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                            'IsAbused' => array('notIn' => array(1, 2)),
                            'Division' => array('==' => 0),
                            'District' => array('==' => 0),
                            'Region' => array('==' => 0),
                            'Store' => array('==' => 0),
                            'IsNotifiable' => array('==' => (int) 1),
                            'CategoryType' => array('notIn' => array(7)),
                        );
                    }
                } else {
                    $groupsfollowing = ServiceFactory::getSkiptaPostServiceInstance()->getUserFollowingGroupsIDs((int) $UserId);
                    array_push($groupsfollowing, '');
                    $condition = array(
                        'UserId' => array('in' => array(0,$UserId)),
                        'GroupId' => array('in' => $groupsfollowing),
                        'IsDeleted' => array('!=' => 1),
                        'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                        'IsAbused' => array('notIn' => array(1, 2)),
                        'CategoryType' => array('notIn' => array(7)),
                        'IsNotifiable' => array('==' => (int) 1)
                    );
                }
                $pageSize = Yii::app()->params['MobilePageLength'];
                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => $condition,
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));
                if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {

                    $UserId =$UserId;// Yii::app()->session['PostAsNetwork'] == 1 ? Yii::app()->session['NetworkAdminUserId'] : $this->tinyObject['UserId'];
                  if(isset($_POST['userTypeId'])){
                     $userTypeId= (int)$_POST['userTypeId'];
                     $userPrivileges = ServiceFactory::getSkiptaUserServiceInstance()->getUserActionsByUserType($UserId, $userTypeId);   
                  }else{
                      $userPrivileges = '';
                  }
                 
                    $dataArray = array_merge($provider->getData(), $this->getDerivateObjectsStream($UserId));
                    $streamRes = (object) (CommonUtility::prepareStreamDataForMobile_V3($UserId, $dataArray, $userPrivileges, 1, '', $timezone,$previousStreamIdArray));
                    $streamIdArray=$streamRes->streamIdArray;
                    $totalStreamIdArray=$streamRes->totalStreamIdArray;
                    $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                    $streamIdArray = array_values(array_unique($streamIdArray));
                    $stream=(object)($streamRes->streamPostData);
                    
                       // $stream = (object) (CommonUtility::prepareStreamDataForMobile($UserId, $provider->getData(), "", 0, '', $timezone));
                    
                } else {
                    $stream = -1; //No more posts
                }
                if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                    $streamIdString = implode(',', $streamIdArray);
                    if ($stream == -1 || $stream == 0) {
                        $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));
                        //  $x = json_encode($stream);

                        } else {
                        $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
                       // $x = json_encode(array_values((array) $stream));

                    }
                    echo $x;
                } else {
                    $this->renderPartial('stream_view', array('stream' => $stream));
                }
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestpostController->actionStream_V3==".$ex->getMessage());
            Yii::log("RestpostController:actionStream_V3::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar Pathapelli
     * This is the common render partial function for all detailed pages
     * @param $postId, $categoryType, $postType
     * @return type html
     */
  public function actionRenderPostDetailed() {
        try { 
            $postId = $_REQUEST['postId'];
            $categoryType = (int)$_REQUEST['categoryType'];
            $postType = (int)$_REQUEST['postType'];
            $timezone = $_REQUEST['timezone'];
            $mainGroupCollection="";
            $isGroupAdmin="false";
            $curbsideCategory = array();
            $MoreCommentsArray = array();
            $tinyUserProfileObject = array();
            $object = array();
            $badgeObj = array();
            $isGroupPostAdmin = 'false';
            /* code to stop 20 type notificaiotns */
             if($categoryType == 20){
                 $data=array("data" => "",);
             echo  json_encode((array)$data);
                return;
            }
            
            if ($categoryType == 1 && $postType != 5) {
                $object = ServiceFactory::getSkiptaPostServiceInstance()->getPostObjectById($postId);
            } else if ($postType == 5) {
                $object = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsidePostObjectById($postId);
                $curbsideCategory = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId($object->CategoryId);
               
            } else if ($postType == 2 || $categoryType == 3 || $categoryType == 7) {
                $object = ServiceFactory::getSkiptaPostServiceInstance()->getGroupPostObjectById($postId);
                $isGroupPostAdmin = ServiceFactory::getSkiptaPostServiceInstance()->checkIsGroupAdminById($object);
                  $groupNameObject =  ServiceFactory::getSkiptaPostServiceInstance()->getGroupNameById($object->GroupId);

                if($isGroupPostAdmin == 'true')
                {
                   if($groupNameObject != 'failure')
                   {
                       $mainGroupCollection = $groupNameObject;
                    }
                }
               
            } else if($categoryType == 8){     
                $object = ServiceFactory::getSkiptaPostServiceInstance()->getNewsObjectById($postId);
            } else if($categoryType == 9){     
                $object =  GameCollection::model()->getGameDetailsObject('Id',$postId);
                $object->GameBannerImage = Yii::app()->params['ServerURL'].$object->GameBannerImage;
                
                
            }
            else if($categoryType == 10){     
                $object = ServiceFactory::getSkiptaPostServiceInstance()->getUserBadgeCollectionById($postId);
                $badgeObj = ServiceFactory::getSkiptaPostServiceInstance()->getBadgeById($object->BadgeId);
                $object->Type=13;
            }
            $object = (array)$object;
            $object['AddSocialActions']=1;
             if($categoryType == 9){  
                $userObj = UserCollection::model()->getTinyUserCollection($object["HighestScoreUserId"]);
                $object['HighestScoreUserPicture'] = $userObj->profile70x70;
                 $object['HighestScoreUserName'] = $userObj->DisplayName;
                   $object['IsFollowed']=in_array($_REQUEST['userId'], $object['Followers']);
            }
            $postTime = $object['CreatedOn'];
            $object['CreatedOn'] = CommonUtility::styleDateTime($postTime->sec,"mobile");
            $this->tinyObject['UserId'] = (int)$_REQUEST['userId'];
            $currentUser = $this->tinyObject['UserId'];
            if(isset($object) && !empty($object)){
                $UserId = $object['UserId'];
                $object['CategoryId']=(int)$categoryType;
                $object['PostId']=$postId;
                $object['PostType']=(int)$object['Type'];
                $tinyUserProfileObject = UserCollection::model()->getTinyUserCollection($UserId);
                $object['profile45x45'] = $tinyUserProfileObject->profile45x45;
                $object['DisplayName'] = ((string)$this->tinyObject['UserId']==(string)$object['UserId'])?"You":$tinyUserProfileObject->DisplayName;
                $object['PostTypeString'] = CommonUtility::postTypebyIndex($object['Type']);    
                $object['actionText'] = CommonUtility::actionTextbyActionType($object['Type']);
                $object['isGroupAdminPost']=$isGroupPostAdmin;
                if($categoryType == 3){
                    $object['PostTypeString'] = "Group ".$object['PostTypeString'];
                      $object['AddSocialActions'] = $groupNameObject['AddSocialActions'];
                    if($isGroupPostAdmin == 'true'){
                        $object['GroupName'] = $mainGroupCollection->GroupName;
                        $object['GroupImage'] = Yii::app()->params['ServerURL'] . $mainGroupCollection->GroupProfileImage;
                    }
                }else if($categoryType == 8){
                   
                     $pattern = '/object/';
                    if(preg_match($pattern, $object['HtmlFragment'])){
                      
                         $object['IsVideo']= 1;
                    }else{
                       
                          $object['IsVideo'] = 0;
                       
                    }
                   
                     $pattern = '/(width)="[0-9]*"/';
                    $string=$object['HtmlFragment'];
                    $string = preg_replace($pattern, "width='250'", $string);
                    $pattern = '/(height)="[0-9]*"/';
                    $string = preg_replace($pattern, "height='250'", $string);
                   
                     $object['HtmlFragment'] = $string;
                    $object['PostText']=$object['Description'];
                    $object['PublicationDate'] = CommonUtility::styleDateTime(strtotime($object['PublicationDate']), "mobile");
                    if ($object['Editorial'] != '') {
                        $editorial = $object['Editorial'];
                        if (strlen($object['Editorial']) > 240) {
                            $editorial = substr($editorial, 0, 240);
                            $editorial = $editorial . '<a  class="showmore postdetail" data-id="' . $object['PostId'] . '">&nbsp<i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></a>';
                        }
                        $object['Editorial'] = $editorial;
                    }
                }else if($categoryType == 10){
                    $object['PostTypeString'] = $badgeObj->badgeName." badge";
                    $object['Description'] = $badgeObj->description;
                    $object['BadgeImage']=Yii::app()->params['ServerURL'] . $badgeObj->image_path;
                }
               
               
                if($postType==2){
                 
                   $eventStartDate = CommonUtility::convert_time_zone($object['StartDate']->sec,$timezone,'','sec');
                    $eventEndDate = CommonUtility::convert_time_zone($object['EndDate']->sec,$timezone,'','sec');
                    $object['StartDate'] = date("Y-m-d", $eventStartDate);
                    $object['EndDate'] = date("Y-m-d", $eventEndDate);
                    $object['EventStartDay'] = date("d", $eventStartDate);
                    $object['EventStartDayString'] = date("l", $eventStartDate);
                    $object['EventStartMonth'] = date("M", $eventStartDate);
                    $object['EventStartYear'] = date("Y", $eventStartDate);
                    $object['EventEndDay'] = date("d", $eventEndDate);
                    $object['EventEndDayString'] = date("l", $eventEndDate);
                    $object['EventEndMonth'] = date("M", $eventEndDate);
                    $object['EventEndYear'] = date("Y", $eventEndDate);
                    $object['StartTime'] =  date("h:i A", $eventStartDate);
                    $object['EndTime'] =  date("h:i A", $eventEndDate);
                    if($eventEndDate<=CommonUtility::currentSpecifictime_timezone($timezone)){
                        $object['CanPromotePost']=0;
                        $object['IsEventAttend'] = 1;
                    }else{
                        $object['IsEventAttend'] = in_array($currentUser,$object['EventAttendes']);
                    }
                }  elseif ($postType==3) {
                    $surveyExpiryDate = $object['ExpiryDate'];
                    if (isset($surveyExpiryDate->sec) && $surveyExpiryDate->sec <= time()) {
                        $object['CanPromotePost'] = 0;
                        $object['ExpiryDate'] = date("Y-m-d", $surveyExpiryDate->sec);
                    }
                    $object['IsSurveyTaken'] = false;
                    if(isset($object['SurveyTaken'])){
                        foreach($object['SurveyTaken'] as $surveyTaken){
                            if($surveyTaken['UserId']==$currentUser){
                                $object['IsSurveyTaken'] = true;
                            }
                        }
                    }
                    $surveyExpiryDate_tz = CommonUtility::convert_date_zone($surveyExpiryDate->sec, $timezone);
                    $currentDate_tz = CommonUtility::currentdate_timezone($timezone);
                    if ($surveyExpiryDate_tz < $currentDate_tz) {
                        $object['IsSurveyTaken'] = true; //expired
                    }
                    $object['IsOptionDExist'] = -1;
                    if(isset($object['OptionFour']) && !empty($object['OptionFour'])){
                        $object['IsOptionDExist'] = 0;
                    }
                }else if ($postType == 5) {
                    $object['CategoryName'] = $curbsideCategory->CategoryName;
                }
               
                $object['IsFollowingPost']=in_array($currentUser, $object['Followers']);
                $object['IsLoved']=in_array($currentUser, $object['Love']);
                $object['FollowCount']=count($object['Followers']);
                $object['CommentCount']=count($object['Comments']);
                $object['LoveCount']=count($object['Love']);
                $object['ResourceCount']=0;
                 $commentCount=0;
            if (!$object["DisableComments"]) {
                if (count($object["Comments"]) > 0) {
                    foreach ($object["Comments"] as $key => $value) {
                        $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
                        $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
                        if(!$IsBlockedWordExist && !$IsAbused){
                            $commentCount++;
                        }
                    }
                }
            }
            $object["CommentCount"] = $commentCount;
                
                
                if(isset($object['Resource'])){
                    $object['ResourceCount']=count($object['Resource']);
                    foreach ($object['Resource'] as $key => $resource) {
                        $filetype = strtolower($resource["Extension"]);
                        $object['Resource'][$key]['VideoImageExist'] = 1;
                        $object['Resource'][$key]['Uri'] = Yii::app()->params['ServerURL'].$resource['Uri'];
                        if ($filetype == 'mp4' || $filetype == 'mov' || $filetype == 'flv') {
                            $filename = "/images/system/video_img.png";
                            if (file_exists($resource["ThumbNailImage"])) {
                                $filename = $resource["ThumbNailImage"];
                            }else{
                                $object['Resource'][$key]['VideoImageExist'] = 0;
                            }
                            $object['Resource'][$key]['ThumbNailImage'] = Yii::app()->params['ServerURL'] . $filename;
                        } else if ($filetype == 'mp3') {
                            $filename = "/images/system/audio_img.png";
                            if (file_exists($resource["ThumbNailImage"])) {
                                $filename = $resource["ThumbNailImage"];
                            }else{
                                $object['Resource'][$key]['VideoImageExist'] = 0;
                            }
                            $object['Resource'][$key]['ThumbNailImage'] = Yii::app()->params['ServerURL'] . $filename;
                        }else{
                            $object['Resource'][$key]['ThumbNailImage'] = Yii::app()->params['ServerURL'].$resource['ThumbNailImage'];
                        }
                    }
                }
               
                if(isset($object['WebUrls'])){
                    if(isset($object['IsWebSnippetExist'])&& $object['IsWebSnippetExist']=='1'){           
                         $snippetdata = WebSnippetCollection::model()->CheckWebUrlExist($object['WebUrls'][0]);
                         $object['WebUrls']=$snippetdata;
                    }else{
                         $object['WebUrls']="";
                    }
                }
         
                $pageSize = 0;//not using
                $MinpageSize = 0;//not using
                $categoryType = (int) $categoryType;
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getRecentCommentsforPost($pageSize, $MinpageSize, $postId, (int) $categoryType);
       
                $rs=array_reverse($result);
                $commentDisplayCount = 5;
                $MoreCommentsArray = CommonUtility::prepareCommentObject($rs, $commentDisplayCount);
                $object['comments'] = $MoreCommentsArray;
                $object['commentCount'] = count($object['comments']);
                if($object['commentCount']>0){
                    $commentedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getCommentedUsersForPost($postId, (int)($this->tinyObject['UserId']));
                    $object['IsCommented'] = in_array((int)($this->tinyObject['UserId']), $commentedUsers);
                }
        }else{
            $object = 0;           
        }
        $commentedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getCommentedUsersForPost($postId, (int)($this->tinyObject['UserId']));
        $IsUserCommented = in_array((int)($this->tinyObject['UserId']), $commentedUsers);
               $userId =  $_REQUEST['userId']; 
               $networkId = Yii::app()->params['NetWorkId'];
               ServiceFactory::getSkiptaPostServiceInstance()->trackEngagementAction($userId,"Post","PostDetailOpen",$postId,$categoryType,$postType,$networkId);

         $data=array("data" => $object, "tinyObject" => $tinyUserProfileObject, "categoryType" => $categoryType, "curbsideCategory" => $curbsideCategory,'commentsdata'=>$MoreCommentsArray,'IsCommented'=>$IsUserCommented,'isGroupPostAdmin' =>$isGroupPostAdmin,'mainGroupCollection'=>$mainGroupCollection);
          echo  json_encode((array)$data);
         
            
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionRenderPostDetailed::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGetCurbsideCategories(){
        try{  
        $categories = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsideCategories();
            $obj = array('status' => 'success', 'data' => $categories);
           $renderScript = $this->rendering($obj);
             echo $renderScript;
             } catch (Exception $ex) {
            Yii::log("RestpostController:actionGetCurbsideCategories::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionMobileCreateCurbsidePost(){
     
         $CurbsidePostModel = new CurbsidePostForm();
        try {
            $obj = array();
            $hashTagArray=array();
            $atMentionArray=array();
                parse_str($_POST["formData"], $values);
                  $CurbsidePostModel->Description =  $values['description'];
                $CurbsidePostModel->Artifacts =  $values['postArtifactsList'];
                    $CurbsidePostModel->Type="CurbsidePost";
                    $CurbsidePostModel->PostedBy = '';
                    $CurbsidePostModel->UserId = $_POST['userId'];
                    $CurbsidePostModel->NetworkId=$this->tinyObject['NetworkId'];
                    $hashTagArray = CommonUtility::prepareHashTagsArray(trim($values['HashTags']));
                    $atMentionArray = CommonUtility::prepareAtMentionsArray($CurbsidePostModel->Mentions);
                    $CurbsidePostModel->Mentions=$atMentionArray;
                    $CurbsidePostModel->Subject=$values['subject'];
                    $CurbsidePostModel->Category=$values['category'];
                    $CurbsidePostModel->WebUrls =  isset($values['WebUrls'])?$values['WebUrls']:"";
                    $CurbsidePostModel->IsWebSnippetExist =  (int)(isset($values['IsWebSnippetExist'])?$values['IsWebSnippetExist']:0);
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
                   
                $renderScript = $this->rendering($obj);
                echo $renderScript;
           
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionMobileCreateCurbsidePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     
     
     
 }
      public function actionMobileCreatePost() {
        $normalPostModel = new NormalPostForm();
        try {
            $obj = array();
            $hashTagArray = array();
            $atMentionArray = array();
           
                parse_str($_POST["formData"], $values);
              //  $normalPostModel->attributes = $_POST['NormalPostForm'];
               $normalPostModel->Description =  $values['description'];
                $normalPostModel->Artifacts =  $values['postArtifactsList'];
                $normalPostModel->Type =  isset($values['Type'])?$values['Type']:"";
                    if ($normalPostModel->Type == "") {
                        $normalPostModel->Type = "Normal Post";
                    } else {
                        $normalPostModel->Type = $normalPostModel->Type;
                    }
                    if (trim($normalPostModel->Type) == "Event") {
                        if ($values['StartDate'] == "" || $values['EndDate'] == "") {
                            $errormessage = Yii::t('translation', 'EventPost_Error_Message');
                        } else {
                            $timezone = $_REQUEST['timezone'];
                            $normalPostModel->StartDate = $values['StartDate'];
                            $normalPostModel->EndDate = $values['EndDate'];
                            $normalPostModel->StartTime = $values['StartTime'];
                            $normalPostModel->EndTime = $values['EndTime'];
                            $normalPostModel->Location = $values['Location'];
                            $normalPostModel->Title = $values["Title"];
                            $eventstarttime = explode(" ", $normalPostModel->StartTime);
                            $eventendtime = explode(" ", $normalPostModel->EndTime);
                            $starttime = trim(strtotime($normalPostModel->StartTime));
                            $endtime = trim(strtotime($normalPostModel->EndTime));
                            $startdate = trim(strtotime($normalPostModel->StartDate));
                            $enddate = trim(strtotime($normalPostModel->EndDate));
                            $startDateTime =  $normalPostModel->StartDate." ".$normalPostModel->StartTime;
                            $endDateTime =  $normalPostModel->EndDate." ".$normalPostModel->EndTime;
                            $startEndTime =  $normalPostModel->StartDate." ".$normalPostModel->EndTime;
                            $startDateTime = CommonUtility::convert_time_zone(strtotime($startDateTime),date_default_timezone_get(),$timezone);
                            $endDateTime =  CommonUtility::convert_time_zone(strtotime($endDateTime),date_default_timezone_get(),$timezone);             
                            $startEndTime =  CommonUtility::convert_time_zone(strtotime($startEndTime),date_default_timezone_get(),$timezone);             
                            $currentTime=  CommonUtility::currentSpecifictime_timezone(date_default_timezone_get());
                            if ($starttime == "" && $endtime != "") {
                                $errormessage = Yii::t('translation', 'EventPost_Starttime_Error_Message');
                            } else if ($starttime != "" && $endtime == "") {
                                $errormessage = Yii::t('translation', 'EventPost_Endtime_Error_Message');
                            } else if ($starttime!="" && $endtime!="" && strtotime ($startDateTime) >= strtotime ($startEndTime)) {
                                $errormessage = Yii::t('translation', 'EventPost_time_Error_Message');
                            }else if ($starttime!="" && $endtime!="" && strtotime ($startDateTime) < $currentTime) {
                                $errormessage = Yii::t('translation', 'EventPost_Start_time_Error_Message');
                            }
                        }
                    }
                    if ($normalPostModel->Type == "Survey") {
                        $normalPostModel->OptionOne = $values['OptionOne'];
                        $normalPostModel->OptionTwo = $values['OptionTwo'];
                        $normalPostModel->OptionThree = $values['OptionThree'];
                        $normalPostModel->OptionFour = $values['OptionFour'];
                        $normalPostModel->ExpiryDate = $values['ExpiryDate'];
                        $normalPostModel->Status = 1;

                        $Optionsarray = array(trim($normalPostModel->OptionOne), trim($normalPostModel->OptionTwo), trim($normalPostModel->OptionThree), trim($normalPostModel->OptionFour));

                        $counts = array_count_values($Optionsarray);
                        foreach ($counts as $name => $count) {
                            if ($count > 1) {
                                $errormessage = Yii::t('translation', 'SurveyPost_Options_Error_Message');
                            }
                        }
                    }
                    $normalPostModel->WebUrls =  isset($values['WebUrls'])?$values['WebUrls']:"";
                    $normalPostModel->IsWebSnippetExist =  (int)(isset($values['IsWebSnippetExist'])?$values['IsWebSnippetExist']:0);
                    $normalPostModel->Type = $normalPostModel->Type;
                    $normalPostModel->PostedBy = '';
                    $normalPostModel->UserId = (int)$_POST['userId'];
                    $normalPostModel->NetworkId = (int)$this->tinyObject['NetworkId'];
                    $hashTagArray = CommonUtility::prepareHashTagsArray(trim($values['HashTags']));
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
                                $Message = array('msg' => $errormessage);
                            } else {
                                $Message = array('msg' => $errormessage);
                            }
                        }
                        if ($normalPostModel->Type == "Survey") {
                            $Message = array('msg' => $errormessage);
                        }
                        $obj = array("status" => 'error', 'data' => '',"type"=>  strtolower($normalPostModel->Type), "error" => $Message);
                    } else {
                        $postObj = ServiceFactory::getSkiptaPostServiceInstance()->savePost($normalPostModel, $hashTagArray);
                        if ($postObj != 'failure') {
                            $message = Yii::t('translation', 'NormalPost_Saving_Success');
                            $obj = array('status' => 'success', 'data' => $message, 'success' => '');
                        } else {
                            $message = Yii::t('translation', 'NormalPost_Saving_Fail');
                            $errorMessage = array('NormalPostForm_Description' => $message);
                            $obj = array("status" => 'error', 'data' => $message, "error" => $errorMessage);
                        }
                    }
                $renderScript = $this->rendering($obj);
                echo $renderScript;
            
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionMobileCreatePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $id = "NormalPostForm_Description";
            $translation = "NormalPost_Saving_Fail";
            $this->throwErrorMessage($id,$translation);

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
                        'IsDeleted' => array('!=' => 1),
                        'IsAbused' => array('notIn' => array(1, 2)),
                        'IsEngage' => array('==' => 0),
                        'Priority' => array('>' => 1)
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
            Yii::log("RestpostController:getDerivateObjectsStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionFileUpload() {
        try {
              $userId = $_GET['userId']; 
              $mobile = $_GET['mobile'];
              $fileName = $_FILES['postFile']['name'];
             $extension = $this->getExtension($fileName);
              $fileName = str_replace("%3A", "", $fileName);
           //  Yii::import("ext.EAjaxUpload.qqFileUploader");
            //  $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'];
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "exe", "mov", "mp4", "mp3", "txt", "doc", "docx", "pptx", "xlsx", "pdf", "ppt", "xls", "3gp", "php", "ini", "avi", "rar", "zip", "png", "tiff"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //$sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
             $sizeLimit= Yii::app()->params['UploadMaxFilSize'];
//            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
//            $result = $uploader->handleUpload($folder);
               if($extension=='mp4' || $extension=='MOV') {
                   $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
                
                   $fileName = $filename."_".strtotime("now").".".$extension;
                  move_uploaded_file($_FILES["postFile"]["tmp_name"], $folder . "".$fileName);  
               }else{
               $img = Yii::app()->simpleImage->load($_FILES['postFile']['tmp_name']);                            
              $img->resizeToWidth(250);
              $img->save($folder . ''. $fileName);
               }
            
               
//            if(isset($_FILES['postFile']['name'])){
//            $fileSize=filesize($folder.$_FILES['postFile']['name']);//GETTING FILE SIZE
//            $fileName=$_FILES['postFile']['name'];//GETTING FILE NAME
//             $result["filepath"]= Yii::app()->getBaseUrl(true).'/temp/'.$fileName;
//             $result["fileremovedpath"]= $folder.$fileName; 
//            }else{
//              $result['success']=false;  
//            }

           // $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            //echo $return; // it's array  
              
             echo $this->rendering($folder . ''. $fileName);
        }
        catch (Exception $ex) {
                echo $ex->getTraceAsString();
                Yii::log("RestpostController:actionFileUpload::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
 }
 
  public function actionFileUpload_V3() {
        try {
              $userId = $_GET['userId']; 
              $mobile = $_GET['mobile'];
              $fileName = $_FILES['postFile']['name'];
             $extension = $this->getExtension($fileName);
              $fileName = str_replace("%3A", "", $fileName);
           //  Yii::import("ext.EAjaxUpload.qqFileUploader");
            //  $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'];
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "exe", "mov", "mp4", "mp3", "txt", "doc", "docx", "pptx", "xlsx", "pdf", "ppt", "xls", "3gp", "php", "ini", "avi", "rar", "zip", "png", "tiff"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //$sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
             $sizeLimit= Yii::app()->params['UploadMaxFilSize'];
//            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
//            $result = $uploader->handleUpload($folder);
               if($extension=='mp4' || $extension=='MOV') {
                   $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
                
                   $fileName = $filename."_".strtotime("now").".".$extension;
                  move_uploaded_file($_FILES["postFile"]["tmp_name"], $folder . "".$fileName);  
               }else{
               $img = Yii::app()->simpleImage->load($_FILES['postFile']['tmp_name']);                            
              $img->resizeToWidth(250);
              $img->save($folder . ''. $fileName);
               }
            
               
//            if(isset($_FILES['postFile']['name'])){
//            $fileSize=filesize($folder.$_FILES['postFile']['name']);//GETTING FILE SIZE
//            $fileName=$_FILES['postFile']['name'];//GETTING FILE NAME
//             $result["filepath"]= Yii::app()->getBaseUrl(true).'/temp/'.$fileName;
//             $result["fileremovedpath"]= $folder.$fileName; 
//            }else{
//              $result['success']=false;  
//            }

           // $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            //echo $return; // it's array  
              
             echo $this->rendering($folder . ''. $fileName);
        }
        catch (Exception $ex) {
                echo $ex->getTraceAsString();
                Yii::log("RestpostController:actionFileUpload_V3::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
 }
 public function actionFileUpload_V4() {
        try {
              $userId = $_GET['userId']; 
              $mobile = $_GET['mobile'];
              $fileName = $_FILES['postFile']['name'];
             $extension = $this->getExtension($fileName);
              $fileName = str_replace("%3A", "", $fileName);
           //  Yii::import("ext.EAjaxUpload.qqFileUploader");
            //  $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'];
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "exe", "mov", "mp4", "mp3", "txt", "doc", "docx", "pptx", "xlsx", "pdf", "ppt", "xls", "3gp", "php", "ini", "avi", "rar", "zip", "png", "tiff"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //$sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
             $sizeLimit= Yii::app()->params['UploadMaxFilSize'];
             if(empty($_FILES) && empty($_POST) && isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post'){ //catch file overload error...
        //$postMax = ini_get('post_max_size'); //grab the size limits...
               echo $this->rendering(array("code"=>"440","error"=>"File is too large, max file upload size is 30M"));
            }else{
           
//            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
//            $result = $uploader->handleUpload($folder);
               if($extension=='mp4' || $extension=='MOV') {
                   $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
                
                   $fileName = $filename."_".strtotime("now").".".$extension;
                  move_uploaded_file($_FILES["postFile"]["tmp_name"], $folder . "".$fileName);  
               }else{
                   $img = Yii::app()->simpleImage->load($_FILES['postFile']['tmp_name']);                            
                   $img->resizeToWidth(250);
                   $img->save($folder . ''. $fileName);
               }
              echo $this->rendering(array("code"=>"200","absoluteFilePath"=>$folder . ''. $fileName));
             }
        }
        catch (Exception $ex) {
            error_log("Exception Occurred in RestpostController->actionFileUpload_V4==".$ex->getMessage());
               echo $this->rendering(array("code"=>"500","error"=>"Unable to upload File"));
               Yii::log("RestpostController:actionFileUpload_V4::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
 }

 function getExtension($str) {
  try{
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }

    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    //$ext .= '_'.$_SESSION['user']->id;
    return $ext;
    } catch (Exception $ex) {
            Yii::log("RestpostController:getExtension::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}
     public function actionRemoveArtifacts() {
        try {
            if (isset($_POST['filepath'])) {
                $filepath = $_POST['filepath'];
            } else {
                $filepath = "";
            }
           $filepath = stripslashes($filepath);
            $f = "'" . $filepath . "'";
            if (file_exists($filepath)) {
                if (unlink($filepath)) {
                    $obj = array('status' => 'success', 'data' => '', 'error' => '');
                } else {
                    $obj = array('status' => 'failed', 'data' => '', 'error' => '');
                }
            } else {
                
            }
            $renderScript = $this->rendering($obj);
            echo $renderScript;
            Yii::app()->end();
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionRemoveArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionUserFollowPost() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postType']) && isset($_REQUEST['postId']) && isset($_REQUEST['actionType'])) {
                //$UserId =  Yii::app()->session['PostAsNetwork']==1?Yii::app()->session['NetworkAdminUserId']:$this->tinyObject->UserId;
                $UserId = (int)$_REQUEST['userId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToPost((int)$_REQUEST['postType'], $_REQUEST['postId'], $UserId, trim($_REQUEST['actionType']), (int)$_REQUEST['categoryType']);
            }
            if ($result == "failure") {
                throw new Exception('Unable to follow or unfollow');
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
            echo $this->rendering($obj);
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionUserFollowPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $id = "socialactionsError_" . $_REQUEST['postId'];
            $actionType = $_REQUEST['actionType'];
            if ($actionType == "Follow") {
                $translation = "Follow_Action_Fail";
            } else {
                $translation = "UnFollow_Action_Fail";
            }

            $this->throwErrorMessage($id, $translation);
        }
    }
    public function actionUserLoveToPost() {
        try {
            $result = FALSE;
             
            if (isset($_REQUEST['postType']) && isset($_REQUEST['postId'])) {
                //$UserId =  Yii::app()->session['PostAsNetwork']==1?Yii::app()->session['NetworkAdminUserId']:$this->tinyObject->UserId;
                $UserId = (int)$_REQUEST['userId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveLoveToPost($_REQUEST['postType'], $_REQUEST['postId'], $UserId, $_REQUEST['categoryType']);
            }
            if($result==TRUE){
            $obj = array("status" => $result, "data" => "", "error" => "");
            }else{
                throw new Exception('Unable to save love');
            }
            echo $this->rendering($obj);
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $id = "socialactionsError_".$_REQUEST['postId'];
           error_log("Exception Occurred in RestpostController->actionUserLoveToPost==".$ex->getMessage());
            $translation = "Love_Action_Fail";
            $this->throwErrorMessage($id,$translation);
            return;
        }
       
    }
    
    
      /**
     * @Author suresh reddy
     * This method is used GetHashTagProfile summary
     * @return type HashTagProfileBean 
     */
    public function actionGetHashTagProfile() {
        try {
            $result = array();
            if (isset($_REQUEST['hashTagName'])) {
                $hashTagName = $_REQUEST['hashTagName'];
                $userId = $_REQUEST['loggedUserId'];
                $hashtagSummery = ServiceFactory::getSkiptaPostServiceInstance()->getHashTagProfile($hashTagName, $userId);
                $result = $hashtagSummery;
            }
            $obj = array('status' => 'success', 'data' => $result, 'error' => '');
            $obj =  json_encode($obj);
            echo $obj;
        } catch (Exception  $ex) {
            Yii::log("RestpostController:actionGetHashTagProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
       /**
         * @author suresh reddy
         * @param curbside categoryId,
         * @return curbside category object
         */
        public function actionGetCurbsideMiniProfile() {
        try {
            if (isset($_REQUEST['categoryId'])) {
                $categoryId = $_REQUEST['categoryId'];
                $userId = $_REQUEST['loggedUserId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsideCategoryMiniProfile($categoryId, $userId);
            }
            $CurbsideProfileBean = new CurbsideProfileBean();
            if (isset($result->Followers) && $result->Followers != null) {
                $CurbsideProfileBean->FollowersCount = count($result->Followers);
                $CurbsideProfileBean->IsUserFollowing = in_array($userId, $result->Followers) ? true : false;
            } else {
                $CurbsideProfileBean->FollowersCount = 0;
                $CurbsideProfileBean->IsUserFollowing = false;
            }
            $CurbsideProfileBean->CategoryName = $result->CategoryName;
            $CurbsideProfileBean->CategoryId = $result->CategoryId;
            $CurbsideProfileBean->NumberOfPosts = $result->NumberOfPosts;



            $obj = array('status' => 'success', 'data' => $CurbsideProfileBean, 'error' => '');
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionGetCurbsideMiniProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
                $userId =  $userId = $_REQUEST['loggedUserId'];// Yii::app()->session['PostAsNetwork']==1?Yii::app()->session['NetworkAdminUserId']:$this->tinyObject->UserId;
                $result = ServiceFactory::getSkiptaPostServiceInstance()->followOrUnfollowCurbsideCategory($categoryId,$userId,$actionType);
            }
             if($result == "failure"){
                throw new Exception('Unable to follow or unfollow');
               }
            $obj = array('status' => 'success', 'data' => $result, 'error' => '');        
            echo CJSON::encode($obj);
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionFollowOrUnfollowCurbsideCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $id = "socialactionsError_".$_REQUEST['categoryId'];
             $actionType =  $_REQUEST['actionType'];
           error_log("Exception Occurred in RestpostController->actionFollowOrUnfollowCurbsideCategory==".$ex->getMessage());
           if($actionType == "Follow"){
               $translation = "Follow_Action_Fail"; 
           }else{
                $translation = "UnFollow_Action_Fail";
        }
           
            $this->throwErrorMessage($id,$translation);
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
                $userId = $userId = $_REQUEST['loggedUserId'];//Yii::app()->session['PostAsNetwork']==1?Yii::app()->session['NetworkAdminUserId']:$this->tinyObject->UserId;
                //$userId = $this->tinyObject['UserId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->followOrUnfollowHashTag($hashTagId, $userId, $actionType);
            }
            $obj = array('status' => 'success', 'data' => $result, 'error' => '');
            echo json_encode($obj);
        } catch (Exception  $ex) {
            Yii::log("RestpostController:actionFollowOrUnfollowHashTag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             $id = "socialactionsError_".$_REQUEST['hashTagId'];
             $actionType =  $_REQUEST['actionType'];
           error_log("Exception Occurred in RestpostController->actionFollowOrUnfollowHashTag==".$ex->getMessage());
           if($actionType == "Follow"){
               $translation = "Follow_Action_Fail"; 
           }else{
                $translation = "UnFollow_Action_Fail";
        }
           
            $this->throwErrorMessage($id,$translation);
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
            echo $this->rendering("success");
    }
    public function actionSavePostComment() {
        $obj=array();
        try {//throw new Exception('Division by zero.');
            if (isset($_REQUEST['postid'])) {
                $streamId = $_REQUEST['streamid'];
                $commentBean = new CommentBean();
                $commentBean->PostId = $_REQUEST['postid'];
                $commentBean->CommentText = str_replace("&nbsp;"," ",$_REQUEST['comment']);
                $CategoryType = $_REQUEST['CateogryType'];
                if (trim($_REQUEST['commentArtifacts']) == "") {
                    $commentBean->Artifacts = array();
                } else {
                    $commentBean->Artifacts = explode(",", $_REQUEST['commentArtifacts']);
                }
                $commentBean->PostType = $_REQUEST['type'];
                //$commentBean->UserId = Yii::app()->session['PostAsNetwork']==1?Yii::app()->session['NetworkAdminUserId']:$this->tinyObject->UserId;
                $commentBean->UserId = (int)$_REQUEST['userId'];
                $commenturls = array();
                $commenturls[0] = $_REQUEST['WebUrls'];
                $commentBean->WebUrls=$commenturls;
               // $commentBean->WebUrls = $_REQUEST['type'];
               if(isset($_REQUEST['IsWebSnippetExist'])){
                    $commentBean->IsWebSnippetExist = $_REQUEST['IsWebSnippetExist'];
               }
               
                $commentBean->HashTags = CommonUtility::prepareHashTagsArray($_REQUEST['hashTags']);
                $commentBean->Mentions = CommonUtility::prepareAtMentionsArray($_REQUEST['atMentions']);
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveComment($commentBean, (int) $_REQUEST['NetworkId'], (int) $_REQUEST['CateogryType']);
//                $comments = ServiceFactory::getSkiptaPostServiceInstance()->getCommentObject($commentBean->PostId,$CategoryType);                
               if($result=='Exception'){
                   throw new Exception('Unable to save commment');
               }
              else if(is_array($result)){
                    $commentUserBean = new CommentUserBean();
                    $resLength = count($result);
                    $commentUserBean->CommentId = trim($result['CommentId']);
                    $resourceArray = array();
                    if (isset($result[0])) {
                        for($i=0;$i<count($result)-1;$i++){
                            $result[$i]['ThumbNailImage'] = Yii::app()->params['ServerURL'].$result[$i]['ThumbNailImage'];
                              $result[$i]['Uri'] = Yii::app()->params['ServerURL'].$result[$i]['Uri'];
                            array_push($resourceArray, $result[$i]);
                            
                        }
                        
                        $commentUserBean->Resource = $resourceArray;
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
                        $CategoryType = (isset($_REQUEST["CateogryType"])) ? $_REQUEST["CateogryType"] : '';
                        $PostType = (isset($_REQUEST["type"])) ? $_REQUEST["type"] : '';

                    $appendCommentData = ' <span class="postdetail"   data-id="'.$streamId.'" data-postid="' . $postId . '" data-categoryType="' . $CategoryType . '" data-postType="' . $PostType . '"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                     $stringArray = CommonUtility::truncateHtml($commentBean->CommentText, 240,'Read more',true,true,$appendCommentData);
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
                    }else{
                         $commentUserBean->IsWebSnippetExist ="";
                    }
                   
                    $commentUserBean->DisplayName = $userCollectionObj->DisplayName;
                    $commentUserBean->ProfilePic = $userCollectionObj->profile70x70;
                    $commentUserBean->CateogryType = $_REQUEST["CateogryType"];
                    $commentUserBean->PostId = $_REQUEST["postid"];
                    $commentUserBean->Type = $_REQUEST["type"];
                    $commentUserBean->ResourceLength = count($result)-1;
                    $commentUserBean->streamId = $streamId;
                    $commentUserBean->PostOn = CommonUtility::styleDateTime(time(),$type="mobile");
                    
                    
                    $obj = array("status" => "success", "data" => $commentUserBean, "error" => "");
                } else if($result=='blocked'){
                    $obj = array("status" => "success", "data" => "blocked", "error" => "");
                }
                
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestpostController->actionSavePostComment==".$ex->getMessage());
            Yii::log("RestpostController:actionSavePostComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           $id = "commenterror_".$_REQUEST['postid'];
            $translation = "Comment_Saving_Fail";
            $this->throwErrorMessage($id,$translation);
            return;
        }
          $obj = $this->rendering($obj);
            echo $obj;
    }
    
    public function actionSavePostComment_V3() {
        $obj=array();
        try {//throw new Exception('Division by zero.');
            if (isset($_REQUEST['postid'])) {
                $streamId = $_REQUEST['streamid'];
                $commentBean = new CommentBean();
                $commentBean->PostId = $_REQUEST['postid'];
                $commentBean->CommentText = str_replace("&nbsp;"," ",$_REQUEST['comment']);
                $CategoryType = $_REQUEST['CateogryType'];
                if (trim($_REQUEST['commentArtifacts']) == "") {
                    $commentBean->Artifacts = array();
                } else {
                    $commentBean->Artifacts = explode(",", $_REQUEST['commentArtifacts']);
                }
                $commentBean->PostType = $_REQUEST['type'];
                //$commentBean->UserId = Yii::app()->session['PostAsNetwork']==1?Yii::app()->session['NetworkAdminUserId']:$this->tinyObject->UserId;
                $commentBean->UserId = (int)$_REQUEST['userId'];
                $commenturls = array();
                $commenturls[0] = $_REQUEST['WebUrls'];
                $commentBean->WebUrls=$commenturls;
               // $commentBean->WebUrls = $_REQUEST['type'];
               if(isset($_REQUEST['IsWebSnippetExist'])){
                    $commentBean->IsWebSnippetExist = $_REQUEST['IsWebSnippetExist'];
               }
               
                $commentBean->HashTags = CommonUtility::prepareHashTagsArray($_REQUEST['hashTags']);
                $commentBean->Mentions = CommonUtility::prepareAtMentionsArray($_REQUEST['atMentions']);
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveComment($commentBean, (int) $_REQUEST['NetworkId'], (int) $_REQUEST['CateogryType']);
//                $comments = ServiceFactory::getSkiptaPostServiceInstance()->getCommentObject($commentBean->PostId,$CategoryType);                
               if($result=='Exception'){
                   throw new Exception('Unable to save commment');
               }
              else if(is_array($result)){
                    $commentUserBean = new CommentUserBean();
                    $resLength = count($result);
                    $commentUserBean->CommentId = trim($result['CommentId']);
                    $resourceArray = array();
                    if (isset($result[0])) {
                        for($i=0;$i<count($result)-1;$i++){
                            $result[$i]['ThumbNailImage'] = Yii::app()->params['ServerURL'].$result[$i]['ThumbNailImage'];
                              $result[$i]['Uri'] = Yii::app()->params['ServerURL'].$result[$i]['Uri'];
                            array_push($resourceArray, $result[$i]);
                            
                        }
                        
                        $commentUserBean->Resource = $resourceArray;
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
                        $CategoryType = (isset($_REQUEST["CateogryType"])) ? $_REQUEST["CateogryType"] : '';
                        $PostType = (isset($_REQUEST["type"])) ? $_REQUEST["type"] : '';

                    $appendCommentData = ' <span class="postdetail"  data-id="'.$streamId.'" data-postid="' . $postId . '" data-categoryType="' . $CategoryType . '" data-postType="' . $PostType . '"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                     $stringArray = CommonUtility::truncateHtml($commentBean->CommentText, 240,'Read more',true,true,$appendCommentData);
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
                    }else{
                         $commentUserBean->IsWebSnippetExist ="";
                    }
                   
                    $commentUserBean->DisplayName = $userCollectionObj->DisplayName;
                    $commentUserBean->ProfilePic = $userCollectionObj->profile70x70;
                    $commentUserBean->CateogryType = $_REQUEST["CateogryType"];
                    $commentUserBean->PostId = $_REQUEST["postid"];
                    $commentUserBean->Type = $_REQUEST["type"];
                    $commentUserBean->ResourceLength = count($result)-1;
                    $commentUserBean->streamId = $streamId;
                    $commentUserBean->PostOn = CommonUtility::styleDateTime(time(),$type="mobile");
                    
                    
                    $obj = array("status" => "success", "data" => $commentUserBean, "error" => "");
                } else if($result=='blocked'){
                    $obj = array("status" => "success", "data" => "blocked", "error" => "");
                }
                
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestpostController->actionSavePostComment_V3==".$ex->getMessage());
            Yii::log("RestpostController:actionSavePostComment_V3::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           $id = "commenterror_".$_REQUEST['postid'];
            $translation = "Comment_Saving_Fail";
            $this->throwErrorMessage($id,$translation);
            return;
        }
          $obj = $this->rendering($obj);
            echo $obj;
    }
    public function actionGetMoreComments() {
        try {
            if (isset($_REQUEST['postId'])) {
                $postId = $_REQUEST['postId'];
            }
            $MinpageSize = 5;
            $streamId = $_REQUEST['streamId'];
            $page = (int) $_REQUEST['Page'];
            //$page=0;
            $pageSize = ($MinpageSize * $page);
            $categoryType = (int) $_REQUEST['CategoryType'];
            $result = ServiceFactory::getSkiptaPostServiceInstance()->getCommentsforPost($pageSize, $MinpageSize, $postId, (int) $categoryType);
            $MoreCommentsArray = CommonUtility::prepareCommentObject($result);
            $obj = "";
            if ($result != 'failure') {
                $totalrecords = count($MoreCommentsArray);
                $obj = array("status" => "success", "data" => $MoreCommentsArray, "count" => $totalrecords);
            } else {
                $obj = array("status" => "fail", "data" => "",);
            }
            $obj = $this->rendering($obj);
            echo $obj;
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionGetMoreComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            $obj = "";
            if (isset($_REQUEST['postId'])) {
                $result = "failure";
                $PostId = $_REQUEST['postId'];
                $Option = $_REQUEST['option'];
                $NetworkId = $_REQUEST['networkId'];
                //$UserId = Yii::app()->session['PostAsNetwork']==1?Yii::app()->session['NetworkAdminUserId']:$this->tinyObject->UserId;
                $UserId = (int)$_REQUEST['userId'];
                $CategoryType = $_REQUEST['categoryType'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->submitSurvey($UserId, $PostId, $Option, $NetworkId, $CategoryType);
                if($result == "failure"){
                   $obj = array("status" => "failure", "data" => "", "error" => "");
                }else{
                    $obj = array("status" => "success", "data" => $result, "error" => "");
                }
            }
             echo $this->rendering($obj);
        } catch (Exception $ex) {
            $obj = array("status" => "exception", "data" => $ex->getMessage(), "error" => "");
            echo $this->rendering($obj);
            Yii::log("RestpostController:actionSubmitSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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

                $userId =(int) $_REQUEST['loggedUserId'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->getFollowingFollowerUsers($searchKey, $userId, $mentionArray);
            }
            $obj = json_encode($result);
            
             
            echo $obj;
        } catch (Exception  $ex) {
            Yii::log("RestpostController:actionGetUserFollowingAndFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
             $obj = json_encode($result);
            echo $obj;
        } catch (Exception  $ex) {
            Yii::log("RestpostController:actionGetHashTagsBySearchKey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
                $networkId =1;
                 $offset=$_REQUEST['offset'];
                $mentionArray = isset($_REQUEST['existingUsers']) ? json_decode($_REQUEST['existingUsers']) : array();
                array_push($mentionArray, $_REQUEST['userId']);
                $result = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollectionForNetworkBySearchKey($networkId, $searchKey, $mentionArray,$offset);
            }
             $obj = json_encode($result);
             
            echo $obj;
        } catch (Exception  $ex) {
            Yii::log("RestpostController:actionGetNetworkUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            $obj="";
            $result = "failure";
            if (isset($_REQUEST['postId'])) {
                $postId = $_REQUEST['postId'];
                $actionType = $_REQUEST['actionType'];
                $userId = (int)$_REQUEST['userId'];
                $categoryType = $_REQUEST['categoryType'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->saveOrRemoveEventAttende($postId, $userId, $actionType, $categoryType);
            }
            if($result != "failure"){
                $obj = array('status' => $result, 'data' => "", 'error' => '');
            }else{
                $obj = array('status' => 'success', 'data' => $result, 'error' => '');
            }
            echo $this->rendering($obj);
        } catch (Exception $ex) {
            $obj = array("status" => "exception", "data" => $ex->getMessage(), "error" => "");
            echo $this->rendering($obj);
            Yii::log("RestpostController:actionAttendEvent::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGetStreamById() {
        try {
            $streamId = $_REQUEST['streamId'];
            $userId = $_REQUEST['userId'];
            $timezone = $_REQUEST['timezone'];
            $isHomeStream = (int)$_REQUEST['isHomeStream'];
            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                'pagination' => FALSE,
                'criteria' => array(
                    'conditions' => array(
                        '_id' => array('==' => new MongoId($streamId)),
                    ),
                )
            ));
            $dataArray = $provider->getData();
            $streamRes = (object) (CommonUtility::prepareStreamDataForMobile_V3($userId, $dataArray, '', $isHomeStream, 0, $timezone));
             $stream=(object)($streamRes->streamPostData);
            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
               // $stream=(object)($streamRes->streamPostData);
                echo json_encode(array_values((array) $stream));
            }
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
            Yii::log("RestpostController:actionGetStreamById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function actionGetStreamById_V3() {
        try {
            $streamId = $_REQUEST['streamId'];
            $userId = $_REQUEST['userId'];
            $timezone = $_REQUEST['timezone'];
            $isHomeStream = (int)$_REQUEST['isHomeStream'];
            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                'pagination' => FALSE,
                'criteria' => array(
                    'conditions' => array(
                        '_id' => array('==' => new MongoId($streamId)),
                    ),
                )
            ));
            $dataArray = $provider->getData();
            $streamRes = (object) (CommonUtility::prepareStreamDataForMobile_V3($userId, $dataArray, '', $isHomeStream, 0, $timezone));
            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                $stream=(object)($streamRes->streamPostData);
                echo json_encode(array_values((array) $stream));
            }
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
            Yii::log("RestpostController:actionGetStreamById_V3::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGetFeaturedItemsToDisplay() {
        try{
        if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
            $_GET['NewsCollection_page'] = $_POST['Page'];
        }
        if (isset($_GET['NewsCollection_page'])) {
            $streamIdArray = array();
            $previousStreamIdArray = array();
            $pageSize = 10;
            $UserId= (int)$_POST['loggedUserId'];
            $conditionalArray = array(
                'IsFeatured' => array('==' => 1), 
                'CategoryType' => array('notIn' => array(9)),
                'IsAbused' => array('==' => (int) 0), 
                'IsDeleted' => array('==' => (int) 0), 
                'IsBlockedWordExist' => array('==' => (int) 0)
            );
            $provider = new EMongoDocumentDataProvider('NewsCollection', array(
                'pagination' => array('pageSize' => $pageSize),
                'criteria' => array(
                    'conditions' => $conditionalArray,
                    'sort' => array('FeaturedOn' => EMongoCriteria::SORT_DESC)
                )
            ));
            $stream=0;
            if ($provider->getTotalItemCount() == 0) {
                $stream = 0; //No posts
            } else if ($_GET['NewsCollection_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                $stream = (object) (CommonUtility::prepareFeaturedItemsForMobile($provider->getData()));
            } else {
                $stream = -1; //No more posts
            }
            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                if ($stream == -1 || $stream == 0) {
                    $x = json_encode(array('stream'=>$stream,'streamIdList'=>""));
                } else {
                    $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>""));
                }
                echo $x;
            } else {
                //$this->renderPartial('curbside_view', array('stream' => $stream));
            }
        }
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionGetFeaturedItemsToDisplay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function actionSnippetpriviewPage() {
        try {
            $text = trim($_POST['data']);
            $type=$_POST['Type'];
            $obj = array('status' => 'failure');
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
                 $obj = array('status' => 'success', 'WebUrls' => $WeburlObj,'type'=>$type,'CommentId'=>$commentId);
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
                //var_dump($data);
               if(strlen($content)==0){
                    $decode['provider_url']=$parsed['host'];
                    $decode['description']="";
                    $decode['title']="";
               }else{
                  $weburl=urlencode ($header['url']);
                    $url = "https://api.embed.ly/1/oembed?key=a8d760462b7c4e4cbfc9d6cb2b5c3418&url=" . $weburl;
                    $details = @file_get_contents($url);
                    $decode = CJSON::decode($details);
               
                if(!is_array($decode) && !count($decode)>0){
                   
                    $doc = new DOMDocument();
                    @$doc->loadHTML($content);
                    $nodes = $doc->getElementsByTagName('title');


                    $base_url = substr($text,0, strpos($text, "/",8));
                    $relative_url = substr($text,0, strrpos($text, "/")+1);


                    //get and display what you need:
                    $title = $nodes->item(0)->nodeValue;
                    $metas = $doc->getElementsByTagName('meta');

                    for ($i = 0; $i < $metas->length; $i++)
                    {
                        $meta = $metas->item($i);
                        if($meta->getAttribute('name') == 'description')
                        $description = $meta->getAttribute('content');
                    }



                    //fetch images
                    $image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
                     $a=preg_match_all($image_regex, $html, $img, PREG_PATTERN_ORDER);

                    $images_array = $img[0];
                   
                    if(strstr($images_array[0],'http')) {
                            $image=$images_array[0];

                    }else{
                        $image=$relative_url.$images_array[0];

                    }
                   
                   $decode['provider_url']=$text;
                   $decode['description']=$description;
                   $decode['title']=$title;
                   $decode['thumbnail_url']=$image;
                  
                  
                  
                  
                  
                }
              
                
               }
               
              
                $SnippetObj = ServiceFactory::getSkiptaPostServiceInstance()->SaveWebSnippet($text, $decode);
                $SnippetObj->Weburl=trim($text);
                $pattern = '~(?><(p|span|div)\b[^>]*+>(?>\s++|&nbsp;)*</\1>|<br/?+>|&nbsp;|\s++)+$~i';
                $SnippetObj->WebTitle = preg_replace($pattern, '', $SnippetObj->WebTitle);
                $SnippetObj->WebLink = preg_replace($pattern, '', $SnippetObj->WebLink);
                $obj = array('status' => 'success', 'WebUrls' => $SnippetObj,'type'=>$type,'CommentId'=>$commentId);
            }
            $renderScript = json_encode($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            $obj = array("status" => "exception", "data" => $ex->getMessage(), "error" => "");
            echo $this->rendering($obj);
            Yii::log("RestpostController:actionSnippetpriviewPage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionGetLoggedUserId(){
        try{      
            $groupName = $_REQUEST['groupType'];
            
            if(isset(Yii::app()->session['TinyUserCollectionObj'])){
                $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
                $userId = $this->tinyObject['UserId'];
            }else{
                $userId = "";
            }            
            $result = ServiceFactory::getSkiptaExSurveyServiceInstance()->isAlreadyDoneByUser($userId,$groupName);
            $resultsArr = explode("_",$result);
            $sFlag = "notdone";
            if(isset($resultsArr[0])){
                $sFlag = $resultsArr[0];
            }
            $uri = str_replace("https","http",Yii::app()->params['ServerURL']);
            $obj = array("cURL"=> $uri,"surveyFlag"=>$sFlag);
            echo $this->rendering($obj);
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionGetLoggedUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
       public function actionAbusePost() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postId']) && isset($_REQUEST['actionType'])) {
                $postId = $_REQUEST['postId'];
                $actionType = $_REQUEST['actionType'];
                $networkId = $_REQUEST['networkId'];
                $userId = $_REQUEST['userId'];
                //$userId = $this->tinyObject['UserId'];
                $categoryType = $_REQUEST['categoryType'];
                $isBlockedPost = isset($_REQUEST['isBlockedPost']) ? (int) $_REQUEST['isBlockedPost'] : 0;
                $result = ServiceFactory::getSkiptaPostServiceInstance()->abusePost($postId, $actionType, $categoryType, $networkId, $userId, $isBlockedPost);
            }
            $obj = array("status" => $result, "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionAbusePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
          $obj = $this->rendering($obj);
            echo $obj;
    }
      public function actionCommentManagement() {
        try {
            $result = "failure";
            if (isset($_REQUEST['postId']) && isset($_REQUEST['commentId']) && isset($_REQUEST['actionType'])) {
                $commentId = $_REQUEST['commentId'];
                $postId = $_REQUEST['postId'];
                $actionType = $_REQUEST['actionType'];
                $networkId = $_REQUEST['networkId'];
                 $userId = $_REQUEST['userId'];
                $categoryType = (int)$_REQUEST['categoryType'];
                $result = ServiceFactory::getSkiptaPostServiceInstance()->commentManagement($commentId, $postId, $actionType, $categoryType, $networkId, $userId);
            }
            $obj = array("status" => "CommentAbused", "data" => "", "error" => "");
        } catch (Exception $ex) {
            Yii::log("RestpostController:actionCommentManagement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
          $obj = $this->rendering($obj);
            echo $obj;
    }
}

?>
