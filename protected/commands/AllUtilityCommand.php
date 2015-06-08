<?php

/**
 * @author Reddy
 * @class 
 */
class AllUtilityCommand extends CConsoleCommand {

    public function actionRemoveGroups($postId = '', $searchKey = '',$id='') {


        try {
            $criteria = new EMongoCriteria;
            $criteria1 = new EMongoCriteria;
            $criteria2 = new EMongoCriteria;
            $GroupId = '';
 
            if($id!='')
            {
                $criteria->addCond('_id', '==', new MongoId($id));
            }
            if ($searchKey != '') {
                
                $criteria->GroupName = new MongoRegex('/' . $searchKey . '.*/i');
            }

            if ($postId != '') {
                $postId = $postId;
                $criteria->addCond('_id', '==', new MongoId($postId));
            }

            $data = GroupCollection::model()->findAll($criteria);



            foreach ($data as $obj) {

                $GroupId = $obj->_id;
                $displayNameArray = explode(" ", $obj->GroupName);


                for ($i = 0; $i < sizeof($obj->GroupMembers); $i++) {
                    $mongoCriteria = new EMongoCriteria;
                    $mongoModifier = new EMongoModifier;
                    $userId = $obj->GroupMembers[$i];
                    $mongoCriteria->addCond('UserId', '==', (int) $userId);
                    $mongoModifier->addModifier('groupsFollowing', 'pop', $obj->_id);
                    UserProfileCollection::model()->updateAll($mongoModifier, $mongoCriteria);
                }
            }
            /* Criteria for Deleting Group from Group collections */
            $criteria1->addCond('GroupId', '==', $GroupId);

            /* Criteria for Deleting Group related stuff from all the collections */
            $criteria2->addCond('_id', '==', $GroupId);
            UserInteractionCollection::model()->deleteAll($criteria1);
            UserActivityCollection::model()->deleteAll($criteria1);
            UserStreamCollection::model()->deleteAll($criteria1);
            FollowObjectStream::model()->deleteAll($criteria1);
            GroupPostCollection::model()->deleteAll($criteria1);
            GroupCollection::model()->deleteAll($criteria2);
        } catch (Exception $ex) {
            echo '_________Exception______________________' . $ex->getMessage();
            Yii::log("AllUtilityCommand:actionRemoveGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUpdateStreamGroupPost($postId) {
        try{
        $criteria = new EMongoCriteria;
        $criteria->addCond('_id', '==', new MongoId($postId));
        $data = GroupPostCollection::model()->find($criteria);
        CommonUtility::prepareStreamObject((int) $data->UserId, 'Post', $postId, (int) 3, '', '', '');
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionUpdateStreamGroupPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionUpdateStreamCurbsidePost($postId) {
        try{
        $criteria = new EMongoCriteria;
        $criteria->addCond('_id', '==', new MongoId($postId));
        $data = CurbsidePostCollection::model()->find($criteria);
        CommonUtility::prepareStreamObject((int) $data->UserId, 'Post', $postId, (int) 2, '', '', '');
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionUpdateStreamCurbsidePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUpdateStreamGames() {
        
    }

    public function actionUpdateUniqueHandles() {
        
    }

    public function actionMakeGroupAdmin() {
        try {

            //  $criteria->GroupName = new MongoRegex('/' . $searchKey . '.*/i');
            $data = GroupCollection::model()->findAll();

            foreach ($data as $obj) {

                $mongoCriteria = new EMongoCriteria;
                $mongoModifier = new EMongoModifier;
                if (isset(YII::app()->params['NetworkAdminEmail'])) {
                    $netwokAdminObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType(YII::app()->params['NetworkAdminEmail'], 'Email');
                    $mongoModifier->addModifier('GroupAdminUsers', 'push', (int) $netwokAdminObj->UserId);
                    $mongoCriteria->addCond('GroupAdminUsers', '!=', (int) $netwokAdminObj->UserId);
                    $mongoModifier->addModifier('CreatedUserId', 'set', (int) $netwokAdminObj->UserId);
                }
                $mongoCriteria->addCond('_id', '==', $obj->_id);

                $return = GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            }
        } catch (Exception $ex) {
            echo '_________Exception______________________' . $ex->getMessage() . $ex->getLine();
            Yii::log("AllUtilityCommand:actionMakeGroupAdmin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /* This method will Mark the User as the Admin for the Given Group and Auto Follow the Group */

    public function actionMakeGroupAdminGivenUser($userId = '', $groupName = '') {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->GroupName = new MongoRegex('/' . $groupName . '/i');
            $data = GroupCollection::model()->findAll($mongoCriteria);
            $mongoCriteriaG = new EMongoCriteria;
            $mongoModifierG = new EMongoModifier;

            $mongoCriteriaGM = new EMongoCriteria;
            $mongoModifierGM = new EMongoModifier;

            $mongoCriteriaU = new EMongoCriteria;
            $mongoModifierU = new EMongoModifier;

            $mongoCriteriaUG = new EMongoCriteria;


            if ($userId != '' && $groupName != '') {
                foreach ($data as $obj) {


                    $netwokAdminObj = User::model()->getUserDetailsByUserId($userId);
                    $mongoCriteriaUG->addCond('GroupMembers', '==', (int) $netwokAdminObj->UserId);
                    $mongoCriteriaUG->addCond('_id', '==', $obj->_id);
                    $userIsAMemberOfGroup = GroupCollection::model()->find($mongoCriteriaUG);
                    if (is_object($userIsAMemberOfGroup)) {

                        $mongoModifierG->addModifier('GroupAdminUsers', 'push', (int) $netwokAdminObj->UserId);
                        $mongoCriteriaG->addCond('GroupAdminUsers', '!=', (int) $netwokAdminObj->UserId);
                        $mongoCriteriaG->addCond('_id', '==', $obj->_id);
                        $return = GroupCollection::model()->updateAll($mongoModifierG, $mongoCriteriaG);
                    } else {

                        $mongoModifierG->addModifier('GroupAdminUsers', 'push', (int) $netwokAdminObj->UserId);
                        $mongoCriteriaG->addCond('GroupAdminUsers', '!=', (int) $netwokAdminObj->UserId);
                        $mongoCriteriaG->addCond('_id', '==', $obj->_id);
                        $returnG = GroupCollection::model()->updateAll($mongoModifierG, $mongoCriteriaG);

                        $mongoModifierGM->addModifier('GroupMembers', 'push', (int) $netwokAdminObj->UserId);
                        $mongoCriteriaGM->addCond('GroupMembers', '!=', (int) $netwokAdminObj->UserId);
                        $mongoCriteriaGM->addCond('_id', '==', $obj->_id);
                        $returnGM = GroupCollection::model()->updateAll($mongoModifierGM, $mongoCriteriaGM);

                        $mongoModifierU->addModifier('groupsFollowing', 'push', new MongoId($obj->_id));
                        $mongoCriteriaU->addCond('groupsFollowing', '!=', new MongoId($obj->_id));
                        $mongoCriteriaU->addCond('userId', '==', (int) $netwokAdminObj->UserId);
                        $returnU = UserProfileCollection::model()->updateAll($mongoModifierU, $mongoCriteriaU);
                    }
                }
            } else {
                echo "No supply to run.";
            }
        } catch (Exception $ex) {
            echo '_________Exception______________________' . $ex->getMessage() . $ex->getLine();
            Yii::log("AllUtilityCommand:actionMakeGroupAdminGivenUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /* This method will Clean up the inconsistencies between the following groups of a users */

    public function actionCleanUpUnMatchedGroupsFromUserProfile($userId = '') {
        try {
            $mongoCriteriaG = new EMongoCriteria;
            $mongoModifierU = new EMongoModifier;
            $mongoCriteriaU = new EMongoCriteria;
            $mongoCriteriaInitialU = new EMongoCriteria;
            if ($userId != '') {
                $mongoCriteriaInitialU->userId = (int) $userId;
                $userData = UserProfileCollection::model()->findAll($mongoCriteriaInitialU);
            } else {
                $userData = UserProfileCollection::model()->findAll();
            }

            foreach ($userData as $userIndividualData) {

                foreach ($userIndividualData->groupsFollowing as $groupFData) {
                    $mongoCriteriaG->addCond('_id', '==', new MongoId($groupFData));
                    $data = GroupCollection::model()->find($mongoCriteriaG);

                    if (is_object($data)) {
//                        echo "\n" . $userIndividualData->userId . "\n";
//                        echo "\n" . $data->GroupName . "\n";
                        continue;
                    } else {
//                        echo "\n" . "I am removed" . $groupFData . "\n";
                        $mongoModifierU->addModifier('groupsFollowing', 'pull', new MongoId($groupFData));
                        $mongoCriteriaU->addCond('userId', '==', (int) $userIndividualData->userId);
                        $data = UserProfileCollection::model()->updateAll($mongoModifierU, $mongoCriteriaU);
                    }
                }
            }
        } catch (Exception $ex) {
            echo '_________Exception______________________' . $ex->getMessage() . $ex->getLine();
            Yii::log("AllUtilityCommand:actionCleanUpUnMatchedGroupsFromUserProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionFixAllPostResource($typeOfPost = '') {
        try{
        $mongoCriteriaRC = new EMongoCriteria;
        $mongoModifierRC = new EMongoModifier;
        $mongoCriteriaPC = new EMongoCriteria;
        $mongoModifierPC = new EMongoModifier;
        $model = '';
        $postData = '';
        $ResourceArray = array();

        if ($typeOfPost == 'post') {
            $postData = PostCollection::model()->findAll($mongoCriteriaPC);
        } else if ($typeOfPost == 'curbside') {
            $postData = CurbsidePostCollection::model()->findAll($mongoCriteriaPC);
        } else if ($typeOfPost == 'group') {
            $postData = GroupPostCollection::model()->findAll($mongoCriteriaPC);
        }

        if (is_array($postData) && !empty($postData)) {


            foreach ($postData as $postIndData) {

                $mongoCriteriaRC->addCond('PostId', '==', new MongoId($postIndData->_id));
                $ResourseData = ResourceCollection::model()->findAll($mongoCriteriaRC);
                if (is_array($ResourseData)) {
                    foreach ($ResourseData as $ResourseIndData) {
                        array_push($ResourceArray, $ResourseIndData->attributes);
                    }
                    $mongoModifierPC->addModifier('Resource', 'set', $ResourceArray);
                    $mongoCriteriaPC->addCond('_id', '==', new MongoId($postIndData->_id));

                    if ($typeOfPost == 'post') {
                        $postData = PostCollection::model()->updateAll($mongoModifierPC,$mongoCriteriaPC);
                    } else if ($typeOfPost == 'curbside') {
                        $postData = CurbsidePostCollection::model()->updateAll($mongoModifierPC,$mongoCriteriaPC);
                    } else if ($typeOfPost == 'group') {
                        $postData = GroupPostCollection::model()->updateAll($mongoModifierPC,$mongoCriteriaPC);
                    }
                    $ResourceArray = array();
                }
                
            }
        } else {
            echo "Sorry We can't process $typeOfPost this action!";
        }
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionFixAllPostResource::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    function actionRestartNodeServices() {
        try{    
        $networkName = Yii::app()->params['WebrootPath'];
        $networkName = explode("/", $networkName);
        $networkName = $networkName[5];
        $ququeName = substr($networkName, 1);
        $firstChar = substr($networkName, 0, 1);
        $ququeName = "[" . $firstChar . "]" . $ququeName;    
            
//        echo "Proxy Node Not Running";
        $date = date("Y-m-d-H-i");
        $f1 = "/data/logs/node/" . $networkName ;
        if (!file_exists($f1)) {
            mkdir($f1, 0755, true);
        }
       
        $f1 = "/data/logs/node/" . $networkName . "/ProxyNode";
        if (!file_exists($f1)) {
            mkdir($f1, 0755, true);
        }
        $f1 = "/data/logs/node/" . $networkName . "/Chat";
        if (!file_exists($f1)) {
            mkdir($f1, 0755, true);
        }
        $f1 = "/data/logs/node/" . $networkName . "/Post";
        if (!file_exists($f1)) {
            mkdir($f1, 0755, true);
        }
        $f1 = "/data/logs/node/" . $networkName . "/Search";
        if (!file_exists($f1)) {
            mkdir($f1, 0755, true);
        }
        $f1 = "/data/logs/node/" . $networkName . "/Notification";
        if (!file_exists($f1)) {
            mkdir($f1, 0755, true);
        }
        shell_exec("touch /data/logs/node/" . $networkName . "/ProxyNode/" . $date . ".log");
        shell_exec("touch /data/logs/node/" . $networkName . "/Chat/" . $date . ".log");
        shell_exec("touch /data/logs/node/" . $networkName . "/Post/" . $date . ".log");
        shell_exec("touch /data/logs/node/" . $networkName . "/Search/" . $date . ".log");
        shell_exec("touch /data/logs/node/" . $networkName . "/Notification/" . $date . ".log");
        shell_exec("touch /data/logs/amqp/" . $networkName . "/" . $date . ".log");
        chdir("/opt/softwares/node/$networkName");
        shell_exec("nohup /usr/local/bin/node /opt/softwares/node/".$networkName."/proxyNode.js > /data/logs/node/" . $networkName . "/ProxyNode/" . $date . ".log & ");
        shell_exec("nohup /usr/local/bin/node /opt/softwares/node/".$networkName."/chat.js > /data/logs/node/" . $networkName . "/Chat/" . $date . ".log & ");
        shell_exec("nohup /usr/local/bin/node /opt/softwares/node/".$networkName."/search.js > /data/logs/node/" . $networkName . "/Search/" . $date . ".log & ");
        shell_exec("nohup /usr/local/bin/node /opt/softwares/node/".$networkName."/posts.js > /data/logs/node/" . $networkName . "/Post/" . $date . ".log & ");
        shell_exec("nohup /usr/local/bin/node /opt/softwares/node/".$networkName."/notification.js > /data/logs/node/" . $networkName . "/Notification/" . $date . ".log &");
        shell_exec(exit());
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionRestartNodeServices::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
  public function actionupdateNotificationMentions(){
       try {
            $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;
             $mongoCriteria->addCond('RecentActivity', '==', 'mention');
           $notifications=Notifications::model()->findAll($mongoCriteria);
           if(count($notifications)>0){
              foreach ($notifications as $notification){
                $mongoCriteriaIL = new EMongoCriteria;
                $mongoModifierIL = new EMongoModifier;
                if($notification['MentionedUserId']!=null){
                    $notiArray=array();
                    array_push($notiArray,(int)$notification['MentionedUserId']);
                    $mongoModifierIL->addModifier('MentionedUserId','set',$notiArray);                    
                    $mongoCriteriaIL->addCond('_id', '==', $notification['_id']);
                    Notifications::model()->updateAll($mongoModifierIL,$mongoCriteriaIL);
                }else{
                    $notiArray=array();                    
                    $mongoModifierIL->addModifier('MentionedUserId','set',$notiArray);
                    $mongoCriteriaIL->addCond('_id', '==', $notification['_id']);
                    Notifications::model()->updateAll($mongoModifierIL,$mongoCriteriaIL);
                }
                
             }     
           }
          
       } catch (Exception $ex) {
           echo $ex->getMessage();
           Yii::log("AllUtilityCommand:actionupdateNotificationMentions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
      /**
       * 
       * @param type $hecArray
       */
      
       public function actionProcessHecJob($hecArray) {
        try {
          
            $val=  urldecode($hecArray);
            $data=  json_decode($val);
//            echo "eeeeeeeeeeeeee2eeeeee".print_r($data,true);
            $return = Careers::model()->saveHecJobs($data);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            Yii::log("AllUtilityCommand:actionProcessHecJob::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionSampleTest($va){
        error_log("===value of v====$v");
    }
    
    public function actionGroupURLFormation(){
        try{
            $groups = GroupCollection::model()->getAllGroupIds();
            foreach($groups as $group){                
                if(!empty($group->GroupName)){                    
//                    $urlformation = str_replace(" ",".",$group->GroupName);
                    $urlformation = preg_replace('/[^\p{L}\p{N}]/u', '', str_replace(" ","",$group->GroupName));
                    $groups_new = GroupCollection::model()->getAllGroupIds();
                    $urlmatch = 0;
                    foreach($groups_new as $rw){
                        if($urlformation == $rw->GroupUniqueName){ 
                            $urlmatch = 1;                            
                        }
                        if($urlmatch == 1){
                            $urlformation = $urlformation.rand(1, 4);
                        }
                    }
                    $updatestatus = GroupCollection::model()->updateGroupUniqueName($group->_id,$urlformation);
                    if($updatestatus == "success")
                        error_log("GroupUniqueName has been updated.\n");
                    else
                        error_log("Error: GroupUniqueName failed to updated.\n");
                    
                }
            }
            $groups = SubGroupCollection::model()->getAllSubGroupIds();
            foreach($groups as $group){                
                if(!empty($group->SubGroupName)){                    
//                    $urlformation = str_replace(" ",".",$group->GroupName);
                    $urlformation = preg_replace('/[^\p{L}\p{N}]/u', '', str_replace(" ","",$group->SubGroupName));
                    $groups_new = SubGroupCollection::model()->getAllSubGroupIds();
                    $urlmatch = 0;
                    foreach($groups_new as $rw){
                        if($urlformation == $rw->SubGroupUniqueName){ 
                            $urlmatch = 1;                            
                        }
                        if($urlmatch == 1){
                            $urlformation = $urlformation.rand(1, 4);
                        }
                    }
                    $updatestatus = SubGroupCollection::model()->updateSubGroupUniqueName($group->_id,$urlformation);
                    if($updatestatus == "success")
                        error_log("SubGroupUniqueName has been updated.\n");
                    else
                        error_log("Error: SubGroupUniqueName failed to updated.\n");
                    
                }
            }
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionGroupURLFormation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in AllUtilityCommand->actionGroupURLFormation==".$ex->getMessage());
        }
    }

    public function actionUpdateFeaturedItemsSocialCount() {
        try{
            
           $featuredItemsCount = NewsCollection::model()->getTotalFeaturedItems();
            if ($featuredItemsCount >= 10) {
                $featuredItems = NewsCollection::model()->getTotalFeaturedItemsList();

                for ($i = sizeof($featuredItems); $i > 10; $i--) {
                    ServiceFactory::getSkiptaPostServiceInstance()->updatePostAsUnFeatured('', $featuredItems[($i - 1)]['PostId'], $featuredItems[($i - 1)]['CategoryType'], $featuredItems[($i - 1)]['NetworkId']);
                }
            }



            $featuredItems=NewsCollection::model()->getTotalFeaturedItemsList();
            foreach($featuredItems as $featuredItem){
                 $postId=$featuredItem->PostId;
                 $categoryId=$featuredItem->CategoryType;
                 if ((int) $categoryId == 2) {
                    $postObj = CurbsidePostCollection::model()->getPostById($postId);
                } else if ((int) $categoryId == 8) {
                    $postObj = CuratedNewsCollection::model()->getPostById($postId);
                } else if ((int) $categoryId == 9) {
                    $postObj = GameCollection::model()->getPostById($postId);
                } else {
                    $postObj = PostCollection::model()->getPostById($postId);
                }
                if (isset($postObj)) {
                    $mongoCriteria = new EMongoCriteria;
                    $mongoModifier = new EMongoModifier;
                    $mongoCriteria->addCond('PostId', '==', new MongoID($postId));
                    $mongoCriteria->addCond('CategoryType', '==', (int) $categoryId);
                    $mongoModifier->addModifier('LoveCount', 'set', (int) count($postObj->Love));
                    $mongoModifier->addModifier('InviteCount', 'set', (int) count($postObj->Invite));
                    $sharecount=isset($postObj->Share)?count(isset($postObj->Share)):0;
                    $mongoModifier->addModifier('ShareCount', 'set', (int) $sharecount);
                    $mongoModifier->addModifier('FollowCount', 'set', (int) count($postObj->Followers));
                    $mongoModifier->addModifier('CommentCount', 'set', (int) count($postObj->Comments));
                    NewsCollection::model()->updateAll($mongoModifier, $mongoCriteria);
                }
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
            Yii::log("AllUtilityCommand:actionUpdateFeaturedItemsSocialCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionUpdateExistingNotificationsOfTypesPost() {
        try{ 
           $posts = Notifications::model()->getAllNotificationsByRecentActivity("post");
           if(!is_string($posts) && count($posts)>0){
               foreach ($posts as $post) {
                   $notificationNote = $post["NotificationNote"];
                   $categoryType = (int)$post["CategoryType"];
                   $notificationId = (string)$post["_id"];
                   if($categoryType==2){
                        $pieces = explode(" posted a curbside consult using a ", $notificationNote);
                        if(count($pieces)>1){
                            $curbsideCategory = explode(" that you are following.", $pieces[1]);
                            $curbsideCategory = $curbsideCategory[0];
                            Notifications::model()->updateNotificationWithHashTagOrCurbsideCategory($notificationId, "", $curbsideCategory);
                        }
                   }else{
                       $pieces = explode(" made a post using a ", $notificationNote);
                       if(count($pieces)>1){
                            $hashtag = explode(" ", $pieces[1]);
                            $hashtag = substr($hashtag[0], 1);//removing #
                            Notifications::model()->updateNotificationWithHashTagOrCurbsideCategory($notificationId, $hashtag);
                       }
                   }
               }
           }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            Yii::log("AllUtilityCommand:actionUpdateExistingNotificationsOfTypesPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionRemoveOldNewsObjectsFromSystem(){
        try{
            $daysOrMonths = '-2 months';
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->CategoryType('==', 8);
            $mongoCriteria->Released('==', 1);
            $mongoCriteria->OriginalPostTime('lessEq', new MongoDate(strtotime($daysOrMonths)));
            $mongoCriteria->LoveCount('==', 0);
            $mongoCriteria->CommentCount('==', 0);
            $mongoCriteria->FollowCount('==', 1);
            $mongoCriteria->InviteCount('==', 0);
            $mongoCriteria->IsPromoted('==', 0);
            $mongoCriteria->IsDeleted('==', 0);
               
            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                'criteria' => $mongoCriteria
            ));
            if ($provider->getTotalItemCount() >= 0) {
                $postIds = array();
                foreach ($provider->getData() as $data) {
                    $postId = (string)$data->PostId;
                    array_push($postIds, new MongoId($postId));
                }
                if(count($postIds)>0){
                    UserStreamCollection::model()->activeOrInactiveOldNewsObjects(array_values($postIds), 2);
                }
            }
        }catch(Exception $ex){
            echo "==AllUtility===RemoveOldNewsObjectsFromSystem===".$ex->getMessage();
            Yii::log("AllUtilityCommand:actionRemoveOldNewsObjectsFromSystem::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionUpdateSubspecialityStringWithId(){
      CustomField::model()->updatePrimaryAffiliationWithId();
    }
    
    
    public  function actionUpdateCompletedPromotedPostsFlag() {
        try
        {
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;
             $mongoCriteria->addCond('IsPromoted', '==', (int)1);
             $startDate = date('Y-m-d');
           
              $startDate = trim($startDate) . " 00:00:00";
              $mongoCriteria->addCond("CreatedOn", "<", new MongoDate(strtotime($startDate)));
             $mongoModifier->addModifier('IsPromoted', 'set', (int) 0);
              UserStreamCollection::model()->updateAll($mongoModifier,$mongoCriteria);
          
            
        } catch (Exception $ex) {
                echo $ex->getMessage();
                Yii::log("AllUtilityCommand:actionUpdateCompletedPromotedPostsFlag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionrunCommandforUpdateAndRelease() {
        try {
            $db = UserStreamCollection::model()->getDb();
            $collection = $db->selectCollection('system.js');

            $proccode = 'function releaseSubDocumentForSuspendedUsers(userId,
  collectionName) {
    var collectionObj=db.getCollection(collectionName);
    collectionObj.find({
      "Comments" : { $elemMatch:{"UserId":NumberInt(userId),
"IsAbused":NumberInt(3)
        }}
    }).forEach( function(article) {
      for(var i in article.Comments){
        if(article.Comments[i        
        ].UserId==NumberInt(userId)){
    article.Comments[i         
          ].IsAbused=NumberInt(0)}
       collectionObj.save(article);} 
    
    }); return "success"
  }';

            $collection->save(
                    array(
                        '_id' => 'releaseSubDocumentForSuspendedUsers',
                        'value' => new MongoCode($proccode),
            ));
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionrunCommandforUpdateAndRelease::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in AllUtilityCommand->actionrunCommandforUpdateAndRelease==".$ex->getMessage());
        }
    }
    
    public function actionPushNotificationsToSurveyAbandonedUsers(){
        try{
            $this->GetAllSystemNotificaitonsForClosedSchedulesAndUpdateAsRead();
            $mongoCriteria = new EMongoCriteria;                           
            $mongoCriteria->addCond('IsCurrentSchedule', '==', (int) 1);
//            $mongoCriteria->addCond("MaxSpots", "!=", (int)0);
            $mongoCriteria->select(array("_id","SurveyTitle","ResumeUsers","MaxSpots","SurveyId","SurveyRelatedGroupName"));
            $scheduleArray = ScheduleSurveyCollection::model()->findAll($mongoCriteria);
            if(is_array($scheduleArray) && sizeof($scheduleArray) > 0){
                $pendingUsers = array();
                $i = 0;
                foreach($scheduleArray as $schedule){
                    $isSpotsAvailable = 0; // 0 = spots are not available...                    
                    if($schedule->MaxSpots > 0){
                        $surveyObject = ExtendedSurveyCollection::model()->getSurveyDetailsById('Id',$schedule->SurveyId);
                        $isSpotsAvailable = SurveyUsersSessionCollection::model()->checkSpotExist($schedule->SurveyId,"",$schedule);  
                        if($surveyObject->IsEnableNotification == 1 &&  sizeof($schedule->ResumeUsers) > 0 && $isSpotsAvailable > 0){   
                            foreach($schedule->ResumeUsers as $userId){    
                                if($userId != 0){
                                    $pendingUsers[$i]['UserId'] = $userId;     
                                    $http = Yii::app()->params['ServerURL'];
                                    $url = "<a href='$http/marketresearchview/1/$schedule->SurveyRelatedGroupName'><b>$schedule->SurveyTitle</b></a>";
                                    //$pendingUsers[$i]['Url'] = "<a href='$url'>$surveyObject->SurveyTitle</a>";
                                    $name = "System";
                                    /*
                                    * 1: Admin generated 
                                    * 2: System generated
                                    * 3: Application generated
                                    */
                                    $nTypeIndex = CommonUtility::getNotificationTypeByName($name);
                                    $pendingUsers[$i]['NType'] = $nTypeIndex;
                                    $pendingUsers[$i]['CategoryType'] = CommonUtility::getIndexBySystemCategoryType("SystemNotification");
                                    $pendingUsers[$i]['PostType'] = CommonUtility::sendPostType("SystemNotification");
                                    $pendingUsers[$i]['PostId'] = $schedule->SurveyId;
                                    $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);  
                                    $segmentId = isset($tinyUserCollectionObj['SegmentId'])?$tinyUserCollectionObj['SegmentId']:0;
                                    $pendingUsers[$i]['SegmentId'] = $segmentId;
                                    $pendingUsers[$i]['Language'] = $tinyUserCollectionObj['Language'];
                                    $pendingUsers[$i]['NetworkId'] = $tinyUserCollectionObj['NetworkId'];
                                    $pendingUsers[$i]['NotificationNote'] = $url;
                                    $pendingUsers[$i]['RecentActivity'] = "Survey";
                                }
                                $i++;
                            }                           
                        }else{
                            error_log("############# Notifications settings is not enabled to this bundle '$schedule->SurveyRelatedGroupName' or Spots are not available ($isSpotsAvailable) or no Resume users #################");
                        }
                    }else{
                        error_log("############# Spots are not available to this bundle '$schedule->SurveyRelatedGroupName' #################");
                    }  
                                        
                }
                if(!empty($pendingUsers)){                    
                    
                    CommonUtility::sendNotificationsToUsers($pendingUsers);
                }
            }else{
                error_log("############# No survey is available #################");
            }
            
            
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionPushNotificationsToSurveyAbandonedUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in AllUtilityCommand->actionPushNotificationsToSurveyAbandonedUsers==".$ex->getMessage());
        }
    }
    
    /*
     * 
     */
    public function GetAllSystemNotificaitonsForClosedSchedulesAndUpdateAsRead(){
        try{
            $column1 = "NotificationType";
            $column2 = "isRead";
            $value1 = "2";
            $value2 = "0";
            $object = Notifications::model()->getAllSystemNotifications($column1,$column2,$value1,$value2);
            if($object != "failure" && sizeof($object) > 0){
                foreach($object as $row){
                    $obj = ScheduleSurveyCollection::model()->getAllSchedulesBySurveyId($row->PostId);
                    if(sizeof($obj)>0){
                        $status = Notifications::model()->deleteSystemNotificaitonById($row->_id);
                    }else{
                       error_log("Survey is currently running and surveyId = $row->PostId"); 
                    }                    
                }
            }else{
              error_log("\nNo Data found");  
            }
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:GetAllSystemNotificaitonsForClosedSchedulesAndUpdateAsRead::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in AllUtilityCommand->GetAllSystemNotificaitonsForClosedSchedulesAndUpdateAsRead==".$ex->getMessage());
        }
    }


    
     public function actionActivateSurveyToNewlyRegisteredUsers() {
        try {
            
            $newUsersList = ServiceFactory::getSkiptaUserServiceInstance()->getAllNewUsersEligableForNewUserSurvey(YII::app()->params['NewRegisteredUserSurveyDays']);
            if (sizeof($newUsersList) > 0) {
                $this->insertNewUserSurvey($newUsersList);
            }
        } catch (Exception $ex) {
            echo "==AllUtility===actionActivateSurveyToNewlyRegisteredUsers===" . $ex->getMessage();
            Yii::log("AllUtilityCommand:actionActivateSurveyToNewlyRegisteredUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function insertNewUserSurvey($newUsersList){
    try {
        
            foreach ($newUsersList as $newUser) {
               // $to = $newUser['Email'];
                 $to = $newUser['Email'];
                $subject = Yii::app()->params['NetworkName'] . "New User Survey";
                $employerName = "Skipta Admin";
                //$employerEmail = "info@skipta.com"; 
                $messageview = "NewUserSurveyEmail";
                $params = array('FirstName' => $newUser['FirstName'], 'LastName' => $newUser['LastName']);
                $sendMailToUser = new CommonUtility;
                $mailSentStatus = $sendMailToUser->actionSendmail($messageview, $params, $subject, $to);
                $userId=$newUser['UserId'];
                $SurveyTitle= YII::app()->params['NewRegisteredUserSurveyBundle'];
                if($mailSentStatus){
                   $SaveUserNewSurevy= User::model()->SaveUserInNewUserSurveyEmailList($userId,$SurveyTitle);
                }
            }
        } catch (Exception $ex) {
            echo "==AllUtility===insertNewUserSurvey===" . $ex->getMessage();
            Yii::log("AllUtilityCommand:insertNewUserSurvey::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionActivateSurveyToExistingUsers() {
        try {
             
            $usersList = ServiceFactory::getSkiptaUserServiceInstance()->getAllSurveyEligableActiveUsers(YII::app()->params['NewRegisteredUserSurveyDays']);
            if (sizeof($usersList) > 0) {
                $this->insertNewUserSurvey($usersList);
            }
        } catch (Exception $ex) {
            echo "==AllUtility===insert survy===" . $ex->getMessage();
            Yii::log("AllUtilityCommand:actionActivateSurveyToExistingUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
    public function actionUpdateUserClassfication() {
        try {
            
                  $usersList = ServiceFactory::getSkiptaUserServiceInstance()-> getAllActiveUsers();
    
                if (sizeof($usersList) > 0) {
                    foreach ($usersList as $newUser) {
                      
                    
                        $date1 = date('Y-m-d', strtotime($newUser['RegistredDate']));
                    $currentdate = date('Y-m-d');


                    $d1 = new DateTime($date1);
                    $d2 = new DateTime($currentdate);
                  $classficationType=1;
                    if($d1->diff($d2)->days>60){
                        $classficationType=0;
                      
                    }
//                    echo $classficationType;
                      $usersList = ServiceFactory::getSkiptaUserServiceInstance()-> updateClassfication((int)$newUser['UserId'],$classficationType);  
                    
                }
                    }
        } catch (Exception $ex) {
            echo "==AllUtility===insert survy===" . $ex->getMessage();
            Yii::log("AllUtilityCommand:actionUpdateUserClassfication::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


    public function actionAcheivements() {
    try{
        $db = UserStreamCollection::model()->getDb();
        $collection = $db->selectCollection('system.js');
        $proccode = 'function updateUserAchievements(userId,collectionName) {var collectionObj=db.getCollection(collectionName);
    collectionObj.find({"Comments" :{$elemMatch:{"UserId":userId,"IsAbused":NumberInt(0)}}}).forEach( function(article) {for(var i in article.Comments){
    article.Comments[i].IsAbused=NumberInt(3)}
       collectionObj.save(article);}); return "success"}';

        $collection->save(
                array(
                    '_id' => 'updateUserAchievements',
                    'value' => new MongoCode($proccode),
        ));
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionAcheivements::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
 * @author Lakshman
 * This method is used to update SurveyTimeSpent with NumberLong   
 */
    public function actionUpdateSurveyTimeSpent() {
        try {
            
            $scheduleObj = SurveyInteractionCollection::model()->updateSurveyTimeSpent();            
        } catch (Exception $ex) {
            echo "==AllUtility===actionUpdateSurveyTimeSpent===" . $ex->getMessage();
            Yii::log("AllUtilityCommand:actionUpdateSurveyTimeSpent::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionUpdateExistingAds() {
        try{ echo "==========actionUpdateExistingAds=============\n";
            AdvertisementCollection::model()->updateExistingAds();
            echo "done\n";
        } catch (Exception $ex) {
            echo "=======================AllUtility/actionUpdateExistingAds======================".$ex->getTraceAsString();
            Yii::log("AllUtilityCommand:actionUpdateExistingAds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   public function actionUpdateExpiredAdsStatus() {
    try{
        Advertisements::model()->updateExpiredAdsStatus();
        AdvertisementCollection::model()->updateAdCollectionExpiredAdsStatus();
        UserStreamCollection::model()->updateUserStreamCollectionExpiredAdsStatus();
        }catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionUpdateExpiredAdsStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    } 
    public function actionUpdateAdsDate() {
    try{
        
        AdvertisementCollection::model()->updatedCollectionAdDatetoMongodate();
       
        UserStreamCollection::model()->updateUserCollectionAdDatetoMongodate();
        
        }catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionUpdateExpiredAdsStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    } 
    
    /**
     * @developer Reddy
     * @usage auto follow for specific group based on group id
     */
     public function actionAutoFollowGroup() {
        try{ echo "==========actionUpdateExistingAds=============\n";
            $userStreamBean=new UserStreamBean();
            $userStreamBean->ActionType='GroupAutoFollow';
            $userStreamBean->GroupId='541fae297f8b9a4a6c96f553';              
            Yii::app()->amqp->stream(json_encode($userStreamBean));
            echo "done\n";
        } catch (Exception $ex) {
             Yii::log("AllUtilityCommand:actionAutoFollowGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     /**
     * @developer Lakshman
     * @usage Insert Registered Users records in UserInteractionCollection
     */
     public function actionInsertRegisteredUsersCollection() {
        try{ 
            echo "==========actionInsertRegisteredUsersCollection=============\n";
            
            $allUsers = User::model()->getAllUsers();
            //print_r($allUsers);
            foreach ($allUsers as $user){
                //echo $user['UserId']."\n";
                $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($user['UserId']);
                $segmentId = isset($tinyUserCollectionObj->SegmentId)?(int)$tinyUserCollectionObj->SegmentId:0;
                $activityIndex = CommonUtility::getUserActivityIndexByActionType("Register");
                $activityContextIndex = CommonUtility::getUserActivityContextIndexByActionType("Register");
              
                UserInteractionCollection::model()->saveUserLoginActivity($user['UserId'],$activityIndex,$activityContextIndex, $segmentId, "Register", $user['RegistredDate'], $tinyUserCollectionObj->NetworkId);                
                
            }
            
            echo "done\n";
        } catch (Exception $ex) {
            Yii::log("AllUtilityCommand:actionInsertRegisteredUsersCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    
}
