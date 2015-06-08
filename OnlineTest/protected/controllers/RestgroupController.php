<?php

/*
 * Developer Sagar Pathapelli
 * on 17 th Sep 2014
 * all group related actions need to add here
 */

class RestgroupController extends Controller {
    
    public function init() {

    }

    public function actionGroupDetail() {
        try {
            if (isset($_REQUEST['groupId']) && !empty($_REQUEST['groupId'])) {
                $groupId = (string)$_REQUEST['groupId'];
                $userId = (int)$_REQUEST['userId'];
                $userTypeId = (int)$_REQUEST['userTypeId'];
                $groupStatistics = ServiceFactory::getSkiptaPostServiceInstance()->getGroupStatistics($groupId, $userId);

                $newGroupCreationModel = new GroupCreationForm();
                $groupDetails = ServiceFactory::getSkiptaGroupServiceInstance()->getGroupDetailsById($groupId);
                if ($groupDetails != 'failure') {
                    $IsIFrameMode = isset($groupDetails->IsIFrameMode) ? $groupDetails->IsIFrameMode : 0;
                    $newGroupCreationModel->GroupName = $groupDetails->GroupName;
                    $newGroupCreationModel->Description = $groupDetails->GroupDescription;
                    $newGroupCreationModel->IFrameMode = $groupDetails->IsIFrameMode;
                    $newGroupCreationModel->IFrameURL = $groupDetails->IFrameURL;
                    $newGroupCreationModel->AutoFollow = $groupDetails->AutoFollow;
                    $newGroupCreationModel->IsPrivate = $groupDetails->IsPrivate;
                    $groupMembers = $groupDetails->GroupMembers;
                    $isGroupFollower = 0;
                    if (in_array($userId, $groupMembers)) {
                        $isGroupFollower = 1;
                        ServiceFactory::getSkiptaUserServiceInstance()->updateUserProfileForGroupActivity($userId, $groupId);
                    }
                    $showPostOption = 0;
                    $userPrivileges = ServiceFactory::getSkiptaUserServiceInstance()->getUserActionsByUserType($userId, $userTypeId);
                    foreach ($userPrivileges as $privilege) {
                        if ($privilege['Status'] == 1) {
                            if ($privilege['Action'] == 'Survey' || $privilege['Action'] == 'Event'){
                                $showPostOption = 1;
                                break;
                            }
                        }
                    }
                    $groupStatistics->GroupBannerImage = Yii::app()->params['ServerURL'] . $groupStatistics->GroupBannerImage;
                    $groupStatistics->GroupIcon = Yii::app()->params['ServerURL'] . $groupStatistics->GroupIcon;
                    $customMenus = array();
                    //$groupDetails->CustomGroup=1;
                    $resMenus = array();
                    if($groupDetails->CustomGroup==1){
                        $resMenus = ServiceFactory::getSkiptaGroupServiceInstance()->GetCustomGroupMenusByGroupId($groupId);//"53ff00b67f8b9a242421948a"
                    }
                    $resMenus = (array)$resMenus;
                    foreach ($resMenus as $menu) {
                        $customMenu = array();
                        $customMenu["Id"] = $menu->Id;
//                        $customMenu["GroupId"] = $menu->GroupId;
                        $customMenu["IsHybridGroup"] = $menu->IsHybridGroup;
                        $customMenu["MenuName"] = $menu->MenuName;
                        $customMenu["MenuDisplayName"] = $menu->MenuDisplayName;
//                        $customMenu["MenuLevel"] = $menu->MenuLevel;
//                        $customMenu["ParentMenuId"] = $menu->ParentMenuId;
//                        $customMenu["MenuPosition"] = $menu->MenuPosition;
                        $customMenu["CssClass"] = $menu->CssClass;
                        $customMenu["URL"] = $menu->URL;
                        if((int)$menu->ParentMenuId!=0){
                            array_push($customMenus["$menu->ParentMenuId"]["ChildMenus"], $customMenu);
                        }else{
                          $customMenu["ChildMenus"] = array();
                          $customMenus["$menu->Id"] = $customMenu;  
                        }
                        
                    }
                   
                    $IsWebSnippetExist = 0;
                    $WebUrls = array();
                    if($IsIFrameMode == 1){
                        $IsWebSnippetExist = 1;
                        $WebUrls =  $this->getWebSnippet($groupDetails->IFrameURL);
                    }
                    $obj = array(
                                'status'=>"success",
                                "code"=>"",
                                "IsIFrameMode" => $IsIFrameMode, 
                               "IsWebSnippetExist" => $IsWebSnippetExist, 
                                "preferencesModel" => $newGroupCreationModel, 
                                "groupStatistics" => $groupStatistics, 
                                'showPostOption' => $showPostOption,
                                'isGroupFollower'=>$isGroupFollower,
                                'groupId'=>$groupId,
                                'isCustomGroup'=>$groupDetails->CustomGroup,
                                'IsIFrameMode'=>$groupDetails->IsIFrameMode,
                                'customMenus'=>array_values((array) $customMenus),
                                'WebUrls' => $WebUrls
                            );
                    echo json_encode($obj);
                }
                
            }else{
                echo json_encode(array('status'=>"failure","code"=>"",'message'=>"Invalid inputs given"));
            }
        } catch (Exception $ex) {
            echo json_encode(array('status'=>"failure","code"=>$ex->getCode(),'message'=>$ex->getMessage()));
            Yii::log("RestgroupController:actionGroupDetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getWebSnippet($text){
         // $text = str_replace('</a>', '', $text);
                 // $weburl=urlencode ($header['url']);
         try{
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
                $url = "https://api.embed.ly/1/oembed?key=a8d760462b7c4e4cbfc9d6cb2b5c3418&url=" . $text;
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
       $WebUrls['Weburl'] = trim($text);
            // $SnippetObj->Weburl=trim($text);
                $pattern = '~(?><(p|span|div)\b[^>]*+>(?>\s++|&nbsp;)*</\1>|<br/?+>|&nbsp;|\s++)+$~i';
                $WebUrls['WebTitle'] = preg_replace($pattern, '', $decode['title']); 
                $WebUrls['WebLink'] = preg_replace($pattern, '', $decode['provider_url']);
                  $WebUrls['Webdescription'] = $decode['description'];
                  
                  
                     if(isset($decode['thumbnail_url']) && $decode['thumbnail_url']!=""){
                $pattern = '~(http.*\.)(jpe?g|png|[tg]iff?|svg)~i';
                $m = preg_match_all($pattern,$decode['thumbnail_url'],$matches);

                     if(is_array($matches[0]) && sizeof($matches[0])>0){
                         
                          $webImage=$decode['thumbnail_url'];
                     }else{
                         $webimage="";
                     }
                
               
            }else{
                $webImage="";
            }
                  
                     $WebUrls['WebImage'] = $webImage;
                     return $WebUrls;
    }
    } catch (Exception $ex) {
            Yii::log("RestgroupController:getWebSnippet::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGetGroupFollowers() {
        try {
            $groupId = $_GET['groupId'];
            $category = $_GET['category'];
            $page = (int) $_REQUEST['Page'];
            $pageSize = 10;
            $startLimit = ($pageSize * ($page - 1));
            $groupFollowersCount = ServiceFactory::getSkiptaPostServiceInstance()->getGroupMembersCount($groupId, $category);
            $stream = -1;
            if ($groupFollowersCount == 0) {
                $stream = 0; //No Data
            } else if ($page <= ceil($groupFollowersCount / $pageSize)) {
                $stream = (object) (ServiceFactory::getSkiptaPostServiceInstance()->getGroupFollowers($groupId, $startLimit, $pageSize, $category));
                foreach ($stream as $follower) {
                    if($follower->profile250x250 == "/upload/profile/user_noimage.png"){
                        $follower->profile250x250 = Yii::app()->params['ServerURL'] . $follower->profile250x250;
                    }
                }
            }
            if ($stream == -1 || $stream == 0) {
                $x = json_encode(array('status'=>"success","code"=>"",'stream'=>$stream,'streamIdList'=>array()));
                } else {
                $x = json_encode(array('status'=>"success","code"=>"",'stream'=>array_values((array) $stream),'streamIdList'=>array()));
            }
            echo $x;  
        } catch (Exception $ex) {
            echo json_encode(array('status'=>"failure","code"=>$ex->getCode(),'message'=>$ex->getMessage()));
            Yii::log("RestgroupController:actionGetGroupFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGetGroupMedia() {
        try {

            $groupId = $_REQUEST['groupId'];
            $_GET['ResourceCollection_page'] = (int) $_REQUEST['Page'];
            $offset = $_GET['ResourceCollection_page'];
            $category = $_REQUEST['category'];
            $type = $_REQUEST['type'];
            $pageSize = 10;
            if ($type == 'Image') {
                $artifacts = array("jpg", "jpeg", "gif", "mov", "mp4", "avi", "flv", "mp3", "png");
            } else {
                $artifacts = array("txt", "doc", "pdf", "ppt", "xls", "docx", "pptx", "xlsx", "DOCX", "PPTX", "XLS", "PDF", "DOC", "DOCX", "PDF", "TXT", "XLSX");
            }
            $provider = "";
            if ($category == 'Group') {
                $provider = new EMongoDocumentDataProvider('ResourceCollection', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => array('GroupId' => array('==' => new MongoID($groupId)), 'Extension' => array('in' => $artifacts), 'IsDeleted' => array('==' => 0), 'SubGroupId' => array('==' => 0),),
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));
            } else {
                $provider = new EMongoDocumentDataProvider('ResourceCollection', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => array('SubGroupId' => array('==' => new MongoID($groupId)), 'Extension' => array('in' => $artifacts), 'IsDeleted' => array('==' => 0)),
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));
            }
            $stream = -1;
            if ($provider->getTotalItemCount() == 0) {
                $stream = 0; //No posts
            } else if ($_GET['ResourceCollection_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                $stream = (object) $provider->getData();
            }
            
            if ($stream == -1 || $stream == 0) {
                $x = json_encode(array('status'=>"success","code"=>"",'stream'=>$stream,'streamIdList'=>array()));
            } else {
                foreach($stream as $artifact){
                    $filename = Yii::app()->params['WebrootPath'].$artifact->ThumbNailImage;
                    if (!file_exists($filename)) {
                        $artifact->ThumbNailImage = "/images/system/video_img.png";
                    }
                    $artifact->ThumbNailImage = Yii::app()->params['ServerURL'] . $artifact->ThumbNailImage;
                    $artifact->Uri = Yii::app()->params['ServerURL'] . $artifact->Uri;
                    foreach($artifact->PostId as $postId){
                        $artifact->PostId = (string)$postId;
                        break;
                    }
                    foreach($artifact->_id as $id){
                        $artifact->_id = (string)$id;
                        break;
                    }
                    $object = ServiceFactory::getSkiptaPostServiceInstance()->getGroupPostObjectById($artifact->PostId);
                    $artifact->PostType = $object->Type;
                }
                $x = json_encode(array('status'=>"success","code"=>"",'stream'=>array_values((array) $stream),'streamIdList'=>array()));
            }
            echo $x;
        } catch (Exception $ex) {
            echo json_encode(array('status'=>"failure","code"=>$ex->getCode(),'message'=>$ex->getMessage()));
            Yii::log("RestgroupController:actionGetGroupMedia::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGroupStream() {
        try{
            $streamIdArray = array();
            $previousStreamIdArray = array();
            $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
            if(!empty($previousStreamIdString)){
                $previousStreamIdArray = explode(",", $previousStreamIdString);
            }
            $_GET['StreamPostDisplayBean_page'] = $_REQUEST["Page"];
            if (isset($_GET['StreamPostDisplayBean_page'])) {
                $pageSize = 10;
                $groupId = $_GET['groupId'];
                $category = $_GET['category'];
                $timezone = $_REQUEST['timezone'];
                $UserId = (int)$_REQUEST['loggedUserId'];
                if ($category == 'SubGroup') {
                    $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                        'pagination' => array('pageSize' => $pageSize),
                        'criteria' => array(
                            'conditions' => array(
                                'UserId' => array('in' => array($UserId, 0)),
                                'IsDeleted' => array('!=' => 1),
                                'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                                'IsAbused' => array('notIn' => array(1, 2)),
                                'CategoryType' => array('==' => 7),
                                'SubGroupId' => array('==' => new MongoId($groupId)),
                            ),
                            'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                        )
                    ));
                } else {
                    $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                        'pagination' => array('pageSize' => $pageSize),
                        'criteria' => array(
                            'conditions' => array(
                                'UserId' => array('in' => array($UserId, 0)),
                                'IsDeleted' => array('!=' => 1),
                                'IsBlockedWordExist' => array('notIn' => array(1, 2)),
                                'IsAbused' => array('notIn' => array(1, 2)),
                               // 'CategoryType' =>  array('or' =>13), //need to uncomment this  to get adds
                            'GroupId' => array('or' => new MongoId($groupId)),
                                'ShowPostInMainStream' => array('==' => (int) 1),
                              //  'GroupId' => array('==' => new MongoId($groupId)),
                            ),
                            'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                        )
                    ));
                }
                $stream = -1;
                if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $streamRes="";
                    if ($category == 'SubGroup') {
                        $streamRes = (object) (CommonUtility::prepareStreamDataForMobile_V3($UserId, $provider->getData(), '', 2, '', $timezone,$previousStreamIdArray));
                    } else {
                        $dataArray = array_merge($provider->getData(), $this->getDerivateObjectsStream($UserId, $groupId));
                        $streamRes = (object) (CommonUtility::prepareStreamDataForMobile_V3($UserId, $dataArray, '', 2, '', $timezone,$previousStreamIdArray));
                    }
                    $streamIdArray=$streamRes->streamIdArray;
                    $totalStreamIdArray=$streamRes->totalStreamIdArray;
                    $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                    $streamIdArray = array_values(array_unique($streamIdArray));
                    $stream=(object)($streamRes->streamPostData);
                }
                $streamIdString = implode(',', $streamIdArray);
                $x = json_encode(array('status'=>"success","code"=>""));
                if ($stream == -1 || $stream == 0) {
                    $x = json_encode(array('status'=>"success","code"=>"",'stream'=>$stream,'streamIdList'=>$streamIdString));
                    //  $x = json_encode($stream);
                    } else {
                    $x = json_encode(array('status'=>"success","code"=>"",'stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
                   // $x = json_encode(array_values((array) $stream));
                }
                echo $x;
            }
        }  catch (Exception $ex){
            echo json_encode(array('status'=>"failure","code"=>$ex->getCode(),'message'=>$ex->getMessage()));
            Yii::log("RestgroupController:actionGroupStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
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
            echo json_encode(array('status'=>"failure","code"=>$ex->getCode(),'message'=>$ex->getMessage()));
            Yii::log("RestgroupController:getDerivateObjectsStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionUserFollowGroup() {
        try {
            $result = "failure";
            $isFollowingGroup = '';
            if (isset($_REQUEST['groupId']) && isset($_REQUEST['actionType'])) {
                $userId = (int)$_REQUEST["userId"];
                if ($_REQUEST['actionType'] == 'Follow') {
                    $groupDetails = GroupCollection::model()->getGroupDetailsById($_REQUEST['groupId']);
                    $groupFollowers = $groupDetails->GroupMembers;
                    $isFollowingGroup = in_array($userId, $groupFollowers);
                    $isGroupAdmin = in_array($userId, $groupDetails->GroupAdminUsers);
                    if ($isFollowingGroup == 1) {
                        $result = 'success';
                    } else {
                        $result = ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToGroup($_REQUEST['groupId'], $userId, $_REQUEST['actionType']);
                    }
                } else {
                    $result = ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToGroup($_REQUEST['groupId'], $userId, $_REQUEST['actionType']);
                }




                if ($result == "failure") {
                    throw new Exception('Unable to follow or unfollow');
                }
                $userFollowingGroups = ServiceFactory::getSkiptaUserServiceInstance()->groupsUserFollowing($userId);
                //Yii::app()->session['UserFollowingGroups'] = $userFollowingGroups;
            }

            $obj = array("status" => $result, "data" => "", "error" => "", "actionType" => $_REQUEST['actionType'], "userId" => $userId, "IsGroupAdmin" => $isGroupAdmin);
            echo json_encode($obj);
        } catch (Exception $ex) {
           echo json_encode(array('status'=>"failure","code"=>$ex->getCode(),'message'=>$ex->getMessage()));
           Yii::log("RestgroupController:actionUserFollowGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   
      public function actionGetGroups() {
        try {
              if (isset($_POST['page'])) {
                    $_GET['GroupCollection_page'] = (int) $_POST['page'];
                } 
            if (isset($_GET['GroupCollection_page'])) {
                 $userId = $_POST['userId'];
                 $groupType = $_POST['groupType'];
                $pageSize = Yii::app()->params['MobilePageLength'];;
                $userGroupsFollowing = ServiceFactory::getSkiptaUserServiceInstance()->groupsUserNotFollowing($userId);
                if($groupType == "following"){
                                 $provider = new EMongoDocumentDataProvider('GroupCollection', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => array(
                            '_id' => array('in' => $userGroupsFollowing),
                           
                            ),
                        //'conditions'=>array('UserId'=>array('in' => array($this->tinyObject['UserId'],0))),
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));   
                }else{
                                 $provider = new EMongoDocumentDataProvider('GroupCollection', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => array(
                            '_id' => array('notin' => $userGroupsFollowing),
                            'IsPrivate' => array('!=' => 1)),
                        //'conditions'=>array('UserId'=>array('in' => array($this->tinyObject['UserId'],0))),
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));   
                }
              
                if ($provider->getTotalItemCount() == 0) {
                   $userGroups = 0; //No posts
                } else if ($_GET['GroupCollection_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $userGroups = (Object) $provider->getData();
                     foreach ($userGroups as $group) {
               if($group->GroupProfileImage == "" || $group->GroupProfileImage == null){
                  $group->GroupProfileImage =  Yii::app()->params['ServerURL']."/upload/group/profile/groupsnoimage.jpg";
  
               }else{
               $group->GroupProfileImage =  Yii::app()->params['ServerURL'].$group->GroupProfileImage;

               }
               $descriptionLength = strlen($group->GroupDescription);
                if ($descriptionLength > 240 && $descriptionLength < 500) {
                    $appendData = '<span class="seemore tooltiplink"   onclick="showFullDescription(' . "'" . $group->_id . "'" . ')"> <i class="fa moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                } else {

                    $appendData = ' <span class="postdetail tooltiplink" data-id=' . $data->_id . '  > <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                }
                if ($descriptionLength > 240) {
                    $description = CommonUtility::truncateHtml($group->GroupDescription, 240, 'Read more', true, true, $appendData);
                    $group->GroupShortDescription = $description;
                 
                }else{
                   $group->GroupShortDescription = $group->GroupDescription;  
                }
               
               
           }
                    
                    
                    
                } else {
                    $userGroups = -1; //No more posts
                }
                
                
                if ($userGroups == -1 || $userGroups == 0) {
                            $obj = array("status" => "success", "data" =>$userGroups, "error" => "","groupType"=>$groupType);
   
                } else{
                            $obj = array("status" => "success", "data" => array_values((array) $userGroups), "error" => "","groupType"=>$groupType);
   
                }
                
            echo $this->rendering($obj);
              //  $this->renderPartial('groups_view', array('stream' => $stream));
            }
        } catch (Exception $ex) {
            Yii::log("RestgroupController:actionGetGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

       public function actionMobileCreateGroupPost() {
       $normalPostModel = new GroupPostForm();
       
        try {
            $obj = array();
            $hashTagArray = array();
            $atMentionArray = array();
         
                parse_str($_POST["formData"], $values);
              //  $normalPostModel->attributes = $_POST['NormalPostForm'];
               $normalPostModel->Description =  $values['description'];
                  $normalPostModel->GroupId =  $values['groupId'];
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
                        $postObj = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupPost($normalPostModel, $hashTagArray);
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
            Yii::log("RestgroupController:actionMobileCreateGroupPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $id = "NormalPostForm_Description";
            $translation = "NormalPost_Saving_Fail";
            $this->throwErrorMessage($id,$translation);

        }
        
    }

    public function actionGetGroupById() {
        try {
                $groupId = $_REQUEST['groupId'];
                $userId = $_REQUEST['userId'];
                $provider = new EMongoDocumentDataProvider('GroupCollection', array(
                    'criteria' => array(
                        'conditions' => array(
                            '_id' => array('==' => new MongoID($groupId))
                            ),
                        'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                    )
                ));
                $userGroups = $provider->getData();
                $groupType = "";
                foreach ($userGroups as $group){
                    if($group->GroupProfileImage == "" || $group->GroupProfileImage == null){
                        $group->GroupProfileImage =  Yii::app()->params['ServerURL']."/upload/group/profile/groupsnoimage.jpg";
                    }else{
                        $group->GroupProfileImage =  Yii::app()->params['ServerURL'].$group->GroupProfileImage;
                    }
                    $descriptionLength = strlen($group->GroupDescription);
                    if ($descriptionLength > 240 && $descriptionLength < 500) {
                        $appendData = '<span class="seemore tooltiplink"  onclick="showFullDescription(' . "'" . $group->_id . "'" . ')"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                    } else {

                        $appendData = ' <span class="postdetail tooltiplink" data-id=' . $data->_id . '  > <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                    }
                    if ($descriptionLength > 240) {
                        $description = CommonUtility::truncateHtml($group->GroupDescription, 240, 'Read more', true, true, $appendData);
                        $group->GroupShortDescription = $description;

                    }else{
                       $group->GroupShortDescription = $group->GroupDescription;  
                    }
                    $IsFollowing = in_array($userId, $group->GroupMembers);
                    if($IsFollowing){
                        $groupType = "following";
                    }
                }
                $obj = array("status" => "success", "data" =>$userGroups, "error" => "","groupType"=>$groupType);
                echo $this->rendering($obj);
            
        } catch (Exception $ex) {
            echo json_encode(array('status'=>"failure","code"=>$ex->getCode(),'message'=>$ex->getMessage()));
            Yii::log("RestgroupController:actionGetGroupById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionGetGroupUserFollowers(){
        try{
            $pageLength = 5;
        $page = $_REQUEST['page'];
        
        $pageSize = 10;
        $startLimit = ($pageSize * ($page - 1)); 
        $groupId = Yii::app()->session['GroupId'];
        $stream = (ServiceFactory::getSkiptaPostServiceInstance()->getGroupFollowers($groupId, $startLimit, $pageSize, 'Group'));
        foreach ($stream as $follower) {
            if($follower->profile250x250 == "/upload/profile/user_noimage.png"){
                $follower->profile250x250 = Yii::app()->params['ServerURL'] . $follower->profile250x250;
            }
        }
        $html = $this->renderPartial("/group/restGroupFollowers",array('offset'=>$page,"groupFollowers"=>$stream),true);
        echo $html;
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestgroupController->actionGetGroupUserFollowers==".$ex->getMessage());           
            Yii::log("RestgroupController:actionGetGroupUserFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}

?>