<?php

/**
 * DocCommand class file.
 *
 * @author Suresh Reddy
 * @usage amqp server version
 *  @version 1.0
 */
require_once(getcwd() . '/extensions/amqp/lib/php-amqplib/amqp.inc');

class AMQPCommand extends CConsoleCommand {
    public function actionActivities($args) {
        try{
        $connection = new AMQPConnection(Yii::app()->params['AMQPSTREAMIP'], 5672, Yii::app()->params['AMQPSTREAMUNAME'], Yii::app()->params['AMQPSTREAMPASSWORD']);
        $channel = $connection->channel();

        $channel->queue_declare(Yii::app()->params['AMQPSTREAM'], false, false, false, false);


        echo ' [*] Waiting for Activities. To exit press CTRL+C', "\n";
  

        $callback = function($msg) {
                echo "===============activities=================\n";
            $obj = json_decode($msg->body, TRUE);
            $obj = (object) $obj;
            $this->activities($obj);
        };

        $channel->basic_consume(Yii::app()->params['AMQPSTREAM'], '', false, true, false, false, $callback);

        while (count($channel->callbacks)) {

            $channel->wait();
        }


        $channel->close();
        $connection->close();



       }catch(Exception $ex){
           Yii::log("AMQPCommand:run::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    
     public function actionAchievements($args) {
        try{
            $connection = new AMQPConnection(Yii::app()->params['AMQPSTREAMIP'], 5672, Yii::app()->params['AMQPSTREAMUNAME'], Yii::app()->params['AMQPSTREAMPASSWORD']);
            $channel = $connection->channel();
            $channel->queue_declare(Yii::app()->params['AMQPSTREAM']."achievements", false, false, false, false);
            echo ' [*] Waiting for Achievements. To exit press CTRL+C', "\n";
            $callback = function($msg) {
                echo "===============achievements=================\n";
                $obj = json_decode($msg->body, TRUE);
                $obj = (object) $obj;
                if(isset($obj->QueueType) && $obj->QueueType=="achievements"){
                    $this->achievements($obj);
                }
            };
            $channel->basic_consume(Yii::app()->params['AMQPSTREAM']."achievements", '', false, true, false, false, $callback);

            while (count($channel->callbacks)) {
                $channel->wait();
            }


            $channel->close();
            $connection->close();
        }catch (Exception $ex){
            
        }
    }
    public function actionGeolocation($args) {
        try{
            $connection = new AMQPConnection(Yii::app()->params['AMQPSTREAMIP'], 5672, Yii::app()->params['AMQPSTREAMUNAME'], Yii::app()->params['AMQPSTREAMPASSWORD']);
            $channel = $connection->channel();
            $channel->queue_declare(Yii::app()->params['AMQPSTREAM']."geolocation", false, false, false, false);
            echo ' [*] Waiting for geolocation. To exit press CTRL+C', "\n";
            $callback = function($msg) {
                $obj = json_decode($msg->body, TRUE);
                $obj = (object) $obj;
                if(isset($obj->ActionType) && $obj->ActionType == "GeoLocation"){
                    CommonUtility::updateGeoCoordinates($obj->Obj,$obj->Type);
                
                }
                if(isset($obj->ActionType) && $obj->ActionType == "UserRecommendation"){
                    CommonUtility::triggerRecommendationsForUser($obj->Obj["UserId"]);
                
                }
            };
            $channel->basic_consume(Yii::app()->params['AMQPSTREAM']."geolocation", '', false, true, false, false, $callback);

            while (count($channel->callbacks)) {
                $channel->wait();
            }


            $channel->close();
            $connection->close();
        }catch (Exception $ex){
           echo "===============Exception =================".$ex->getMessage();  
        }
    }
   public function activities($obj) {
        try{
            if($obj->ActionType == "GeoLocation"){
                 CommonUtility::updateGeoCoordinates($obj->Obj,$obj->Type);
                  return;
            }
             if($obj->ActionType == "UserRecommendation"){
             CommonUtility::triggerRecommendationsForUser($obj->Obj["UserId"]);
                  return;
            }
           
          
            $obj->FollowOn = '';
            if (isset($obj->CreatedOn) && !empty($obj->CreatedOn)) {
                $obj->CreatedOn = new MongoDate($obj->CreatedOn);
                $obj->FollowOn = $obj->CreatedOn;
            } else {
                $obj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                $obj->FollowOn = $obj->CreatedOn;
            }$craddd = $obj->CreatedOn;
            
           
           CommonUtility::initiatePushNotification($obj,true);
           if($obj->ActionType!='SaveItForLater')
           $this->saveOrUpdateNotifications($obj);
          
            if ($obj->ActionType == 'Follow' || $obj->ActionType == "UnFollow" || $obj->ActionType == 'UserFollow' || $obj->ActionType == 'UserUnFollow' || $obj->ActionType == 'GroupFollow' || $obj->ActionType == 'GroupUnFollow' || $obj->ActionType == 'SubGroupFollow' || $obj->ActionType == 'SubGroupUnFollow' || $obj->ActionType == 'HashTagFollow' || $obj->ActionType == "HashTagUnFollow" || $obj->ActionType == "CurbsideCategoryFollow" || $obj->ActionType == "CurbsideCategoryUnFollow") {

               $this->saveUserActivity($obj);
            }
            
            if ($obj->ActionType == "Love" || $obj->ActionType == "Invite"|| $obj->ActionType == "Comment"|| $obj->ActionType == "FbShare" || $obj->ActionType == "TwitterShare" || $obj->ActionType == "Follow" || $obj->ActionType == "UnFollow" || $obj->ActionType == 'GroupFollow' || $obj->ActionType == 'GroupUnFollow' || $obj->ActionType == 'SubGroupFollow' || $obj->ActionType == 'SubGroupUnFollow' || $obj->ActionType == 'HashTagFollow' || $obj->ActionType == "HashTagUnFollow" || $obj->ActionType == "CurbsideCategoryFollow" || $obj->ActionType == "CurbsideCategoryUnFollow")
            {
                $this->cancelSaveItForLater($obj);
            }

            if ($obj->ActionType == "Comment") {
                $obj->Comments['CreatedOn'] = new MongoDate($obj->Comments['CreatedOn']);
               $this->saveUserActivity($obj);
               $this->distributeStreamForComment($obj);
            } else if ($obj->ActionType == "Post") {
                if($obj->CategoryType!=11 && $obj->CategoryType!=14)
                {
               $this->saveUserActivity($obj);
                }
               $this->distributeStreamObj($obj);
            } else if ($obj->ActionType == "Follow" || $obj->ActionType == "UnFollow" || $obj->ActionType == 'GroupFollow' || $obj->ActionType == 'GroupUnFollow' || $obj->ActionType == 'SubGroupFollow' || $obj->ActionType == 'SubGroupUnFollow' || $obj->ActionType == 'HashTagFollow' || $obj->ActionType == "HashTagUnFollow" || $obj->ActionType == "CurbsideCategoryFollow" || $obj->ActionType == "CurbsideCategoryUnFollow") {
               $this->distributeStreamForFollowObject($obj);
            } else if ($obj->ActionType == "FbShare") {
               $this->saveUserActivity($obj);
               $this->derivativeStreamForLoveAction($obj);
            } else if ($obj->ActionType == "TwitterShare") {
               $this->saveUserActivity($obj);
               $this->derivativeStreamForLoveAction($obj);
            } else if ($obj->ActionType == "Love") {
               $this->saveUserActivity($obj);
               $this->derivativeStreamForLoveAction($obj);
            } else if ($obj->ActionType == "EventAttend") {
               $this->saveUserActivity($obj);
               $this->distributeStreamForEventAttend($obj);
            } else if ($obj->ActionType == "Survey") {
               $this->saveUserActivity($obj);
               $this->distributeStreamForSurvey($obj);
            } else if ($obj->ActionType == "Invite") {
               $this->saveUserActivity($obj);
               $this->distributeStreamForInviteUsers($obj);
            } else if ($obj->ActionType == "Abuse") {
               $this->updatePostManagementActions($obj);
            } else if ($obj->ActionType == "Block") {
               $this->updatePostManagementActions($obj);
            } else if ($obj->ActionType == "Release") {
               $this->updatePostManagementActions($obj);
            } else if ($obj->ActionType == "Delete") {
               $this->updatePostManagementActions($obj);
            } else if ($obj->ActionType == "Promote") {
               $this->updatePostManagementActions($obj);
            } else if ($obj->ActionType == "Featured") {
               $this->updatePostManagementActions($obj);
            }else if ($obj->ActionType == "SaveItForLater") {
               $this->updatePostManagementActions($obj); 
            }
            else if ($obj->ActionType == "SaveItForLaterCancel") {
               $this->updatePostManagementActions($obj); 
            }
            else if ($obj->ActionType == "AbuseComment") {
               $this->updateCommentManagementActions($obj);
            } else if ($obj->ActionType == "CommentBlock" || $obj->ActionType == "BlockAbusedComment") {
               $this->updateCommentManagementActions($obj);
            } else if ($obj->ActionType == "CommentRelease" || $obj->ActionType == "ReleaseAbusedComment" || $obj->ActionType == "AbuseCommentForSuspendedUser" ) {
               $this->updateCommentManagementActions($obj);
            } else if ($obj->ActionType == "NewsNotify") {
               $this->upateNewsToNotifyInStream($obj);
            } else if ($obj->ActionType == "PullbackNews") {
                $obj->ActionType = 'Abuse';
               $this->upateNewsToNotifyInStream($obj);
            } else if ($obj->ActionType == "Play") {
                $obj->ActionType = 'Play';
                $obj->StreamNote = CommonUtility::actionTextbyActionType("Play");
               $this->saveUserActivity($obj);
               $this->distributeStreamForPlay($obj);
            } else if ($obj->ActionType == "Newgame") {

            }
            else if ($obj->ActionType == "GroupFollowForSpeciality") {
               $this->GroupFollowForSpeciality($obj);
            }
            if ($obj->ActionType == 'GroupAutoFollow') {
               $this->groupAutoFollow($obj);
            } else if ($obj->ActionType == "Playing") {
               $obj->ActionType = 'Playing';
               $obj->StreamNote = CommonUtility::actionTextbyActionType("Resume");                 
               $this->saveUserActivity($obj);
               $this->updateStreamSocialActionsCount($obj);
            } else if ($obj->ActionType == "GroupAutoFollow") {
                $obj->ActionType = 'Abuse';
               $this->upateNewsToNotifyInStream($obj);
            } else if ($obj->ActionType == "SuspendGame" || $obj->ActionType == "ReleaseGame" || $obj->ActionType == "CancelScheduleGame") {
               $this->suspendOrReleaseGame($obj);
            } else if ($obj->ActionType == "GameSchedule") {
               $this->ScheduleGame($obj);
            }else if($obj->ActionType == "GroupInactive" || $obj->ActionType == "GroupActive"){
                 $this->updateDataForGroupActiveAndInactive($obj);
            }
            else if($obj->ActionType == "SubGroupInactive" || $obj->ActionType == "SubGroupActive"){
                 $this->updateDataForSubGroupActiveAndInactive($obj);
            }
            else if ($obj->ActionType == "UseForDigest") {
               $this->updateUseForDigest($obj);
            }
            else if ($obj->ActionType == "ExtendedSurveyFinished") {
               $this->saveFollowObjectStreamForExtendeSurveyFollowers($obj);
            }
            if ( isset($obj->CategoryType) && (int) $obj->CategoryType != 10 && $obj->CategoryType != 11 && $obj->CategoryType != 14) {
              CommonUtility::startBadging($obj,$obj->UserId);
            }
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:activities::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }
   public function achievements($userAchievementsObj) {
        try{
            echo "===============achievements=====method============\n";
            $userClassification = (int)$userAchievementsObj->UserClassification;
            if($userClassification>0){
                echo $userClassification."===============userClassification>0=================\n";
                error_log(print_r($userAchievementsObj, true));
                if($userAchievementsObj->OpportunityType==""){
                    $this->updateEngagementDriversAvailabilityForUser($userAchievementsObj);
                }else{
                    $this->saveUserAchievements($userAchievementsObj);
                    $this->updateTourGuideStatus($userAchievementsObj);
                }
            }
        }catch (Exception $ex){
           Yii::log("AMQPCommand:achievements::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }
    public function saveUserAchievements($userAchievementsObj) {
        try {
            $userId = (int)$userAchievementsObj->UserId;
            $userClassification = (int)$userAchievementsObj->UserClassification;
            $opportunityType = $userAchievementsObj->OpportunityType;
            $engagementDriverType = $userAchievementsObj->EngagementDriverType;
            $increasedValue = (float)$userAchievementsObj->Value;
            $isUpdate = (int)$userAchievementsObj->IsUpdate;
            if($userClassification==1){
                $userAchievements = UserAchievementsCollection::model()->getUserAchievements($userId, $userClassification);
                if(sizeof($userAchievements)<=0)
                {//insert
                    $this->saveNewUserAchievements($userAchievementsObj);
                }
                $db = UserAchievementsCollection::model()->getDb(); 
                $toexec = 'function(userId,userClassification,opportunityType,engagementDriverType, increasedValue, isUpdate) { return updateUserAchievements(userId,userClassification,opportunityType,engagementDriverType, increasedValue, isUpdate) }';
                $args=array($userId, $userClassification, $opportunityType,$engagementDriverType, $increasedValue, $isUpdate);
                $db->execute($toexec, $args);
                if(Yii::app()->params['Pictocv']=='ON'){
                    $this->sendPictocvRequest($userAchievementsObj);
                }
            }
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:saveUserAchievements::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function saveNewUserAchievements($userAchievementsObj) {
        try {
            $userId = (int)$userAchievementsObj->UserId;
            $userClassification = (int)$userAchievementsObj->UserClassification;
            $opportunitiesObj = OpportunitiesCollection::model()->getOpportunitiesByUserClassification($userClassification);
            if(isset($opportunitiesObj) && isset($opportunitiesObj->UserClassification)){
                $opportunitiesArray = (array) $opportunitiesObj;
                $opportunitiesArray["UserClassification"] = (int)$opportunitiesArray["UserClassification"];
                $opportunitiesArray["SegmentId"] = (int)$userAchievementsObj->SegmentId;
                $opportunitiesArray["NetworkId"] = (int)$userAchievementsObj->NetworkId;
                for($i=0; $i<sizeof($opportunitiesArray["Opportunities"]); $i++){
                    $opportunitiesArray["Opportunities"][$i]["OpportunityGoal"] = (int)$opportunitiesArray["Opportunities"][$i]["OpportunityGoal"];
                    
                    for($j=0; $j<sizeof($opportunitiesArray["Opportunities"][$i]["EngagementDrivers"]); $j++){
                        $opportunitiesArray["Opportunities"][$i]["EngagementDrivers"][$j]["Available"] = "";
                        $opportunitiesArray["Opportunities"][$i]["EngagementDrivers"][$j]["Achieved"] = (float)0;
                        unset($opportunitiesArray["Opportunities"][$i]["EngagementDrivers"][$j]["Goal"]);
                        unset($opportunitiesArray["Opportunities"][$i]["EngagementDrivers"][$j]["Weight"]);
                        unset($opportunitiesArray["Opportunities"][$i]["EngagementDrivers"][$j]["IsGoalInPercentage"]);
                    }
                }
                $userAchievements = (object) $opportunitiesArray;
                UserAchievementsCollection::model()->saveUserAchievements($userId, $userAchievements);
            }
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:saveNewUserAchievements::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function updateEngagementDriversAvailabilityForUser($userAchievementsObj) {
        try {
            $userId = (int)$userAchievementsObj->UserId;
            $userClassification = (int)$userAchievementsObj->UserClassification;
            
            if($userClassification==1){
                $userAchievements = UserAchievementsCollection::model()->getUserAchievements($userId, $userClassification);
                if(sizeof($userAchievements)<=0)
                {//insert
                    $this->saveNewUserAchievements($userAchievementsObj);
                    $userAchievements = UserAchievementsCollection::model()->getUserAchievements($userId, $userClassification);
                }
                
               if(sizeof($userAchievements)>0)
               {
                   $userAchievements->UserId = (int)$userId;
                   $userAchievements->UserClassification = (int)$userClassification;
                   for($i=0;$i<sizeof($userAchievements->Opportunities); $i++){
                       $opportunityType = $userAchievements->Opportunities[$i]["OpportunityType"];
                       $userAchievements->Opportunities[$i]["OpportunityGoal"] = (int)$userAchievements->Opportunities[$i]["OpportunityGoal"];
                       for($j=0;$j<sizeof($userAchievements->Opportunities[$i]["EngagementDrivers"]); $j++){
                           $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Achieved"] = (float)$userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Achieved"];
                           if($opportunityType=="Profile"){

                               if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Profile_Picture"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)1;
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Profile_Professional_Information"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)1;
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Profile_Practice_Information"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)1;
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "User_Location"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)1;
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "User_Bio"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)1;
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "User_Interest"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)1;
                               }
                           }else if($opportunityType=="Follow"){
                               if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Follow_Posts"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = "";
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Follow_Users"){
                                   //Get the user count based on Interests and Location
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)UserRecommendations::model()->getUserRecommendationCount($userId);
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Follow_Groups"){
                                   //Count of public groups in segment
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)GroupCollection::model()->getPublicGroupsCount();
                               }
                           }else if($opportunityType=="Career"){
                               $userDetails=ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userId);
                               $subspeciality="";
//                               if($userDetails->CustomFieldId!=null){
//                                   $subspecialityArray= ServiceFactory::getSkiptaUserServiceInstance()->getUserSubspecialityByCustomField($userDetails->CustomFieldId);
//                                   if(sizeof($subspecialityArray)>0){                  
//                                       $subspeciality=$subspecialityArray['Value'];
//                                   }
//                               }
                               
                               if(isset($userDetails['Value'])){
                                   $subspeciality=$userDetails['Value'];
                               }
                               $latitude = "";
                               $longitude = "";
                               if(isset($userDetails['Latitude']) && isset($userDetails['Longitude'])){
                                   $latitude=$userDetails['Latitude'];
                                   $longitude=$userDetails['Longitude'];
                               }      
                               $radius = Yii::app()->params['RecomendedJobsRadius'];
                               $jobsCount=0;
                               if($latitude!="" && $longitude!=""){
                                $jobsCount= Careers::model()->getRecommondedJobsCount($latitude,$longitude,$radius,$subspeciality);
                                $jobsCount = $jobsCount>0?$jobsCount:1;
                               }
                               if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Career_ViewJobs"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)$jobsCount;
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Career_RespondedToJob"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = (int)$jobsCount;
                               }
                           }else if($opportunityType=="Search"){
                               if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Searches_Performed"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = "";
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Objects_Types_Discovered"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = "";
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Objects_Discovered"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = "";
                               }
                           }else if($opportunityType=="News"){
                               if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "News_Views"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = "";
                               }else if($userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Type"] == "Conversations_Participated"){
                                   $userAchievements->Opportunities[$i]["EngagementDrivers"][$j]["Available"] = "";
                               }
                           }
                       }
                   }
                   $userAchievements->update();
               }
            }
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:updateEngagementDriversAvailabilityForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function updateTourGuideStatus($userAchievementsObj)  {
        try
        {
           
            $userId = (int)$userAchievementsObj->UserId;
            $userClassification = (int)$userAchievementsObj->UserClassification;
            $opportunityType = $userAchievementsObj->OpportunityType;
            $opportunityObj=  TourGuideOpportunities::model()->getOpportunityByType($opportunityType,$userClassification);
            
            if(sizeof($opportunityObj)>0)
            {
                $tourguideData=  TourGuide::model()->getTourGuideOfNextOpportunity($opportunityObj['Id']);
                if(sizeof($tourguideData)>0)
                {
                   foreach($tourguideData as $tourGuide)
                   {
                      
                      $goalStatus=ServiceFactory::getSkiptaPostServiceInstance()->saveOrUpdateUserTourGuideState($userId,$opportunityObj['Id'],$tourGuide['DivId']);    
                  
                   }
               
                }
               
            }
           
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:updateTourGuideStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * author : suresh reddy 
     * Updated by Vamsi Krishna #260 Mar/2/14
     * save all user activity
     * @Param $obj  
     * return void
     */
     function saveUserActivity($obj) {
        try {
            $obj = (object) $obj;
            $obj->ActionType = $obj->ActionType;
            $obj->RecentActivity = $obj->ActionType;
            $obj->Title = $obj->Title;

            if ($obj->ActionType == 'Follow' || $obj->ActionType == "UnFollow" || $obj->ActionType == "UserFollow" || $obj->ActionType == "UserUnFollow" || $obj->ActionType == "CurbsideCategoryFollow" || $obj->ActionType == "CurbsideCategoryUnFollow" || $obj->ActionType == "HashTagFollow" || $obj->ActionType == "HashTagUnFollow" || $obj->ActionType == "GroupFollow" || $obj->ActionType == "GroupUnFollow") {

                if ($obj->ActionType == "UserFollow" || $obj->ActionType == "UserUnFollow") {
                    $isUserActivityPresent = UserActivityCollection::model()->getUserActivityByType($obj->UserId, $obj->UserFollowers, '', '', '', $obj->ActionType);
                    if ($isUserActivityPresent != 'failure') {
                        UserActivityCollection::model()->updateUserActivityForUserFollow($isUserActivityPresent->_id, $obj->ActionType, $obj->FollowOn);
                    } else {
                        UserActivityCollection::model()->userFollowUnFollowActivity($obj);
                    }
                }
                if ($obj->ActionType == "CurbsideCategoryFollow" || $obj->ActionType == "CurbsideCategoryUnFollow") {
                    $isUserActivityPresent = UserActivityCollection::model()->getUserActivityByType($obj->UserId, '', $obj->CurbsideCategoryId, '', '', $obj->ActionType, '', '');
                    if ($isUserActivityPresent != 'failure') {
                        UserActivityCollection::model()->updateUserActivityForUserFollow($isUserActivityPresent->_id, $obj->ActionType, $obj->FollowOn);
                    } else {
                        UserActivityCollection::model()->userFollowUnFollowActivity($obj);
                    }
                }
                if ($obj->ActionType == "HashTagFollow" || $obj->ActionType == "HashTagUnFollow") {
                    $isUserActivityPresent = UserActivityCollection::model()->getUserActivityByType($obj->UserId, '', '', $obj->HashTagId, '', $obj->ActionType);
                    if ($isUserActivityPresent != 'failure') {
                        UserActivityCollection::model()->updateUserActivityForUserFollow($isUserActivityPresent->_id, $obj->ActionType, $obj->FollowOn);
                    } else {
                        UserActivityCollection::model()->userFollowUnFollowActivity($obj);
                    }
                }
                if ($obj->ActionType == "GroupFollow" || $obj->ActionType == "GroupUnFollow") {
                    $isUserActivityPresent = UserActivityCollection::model()->getUserActivityByType($obj->UserId, '', '', '', $obj->GroupId, $obj->ActionType, '', '');
                    if ($isUserActivityPresent != 'failure') {
                        UserActivityCollection::model()->updateUserActivityForUserFollow($isUserActivityPresent->_id, $obj->ActionType, $obj->FollowOn);
                    } else {
                        UserActivityCollection::model()->userFollowUnFollowActivity($obj);
                    }
                  
                }
                // THis is for post follow and Unfollow

                if (trim($obj->ActionType) == "Follow" || $obj->ActionType == "UnFollow") {
                    $obj->StreamNote = CommonUtility::actionTextbyActionType("Follow");
                    $activityObj = UserActivityCollection::model()->getActvityObjbyPostId($obj->PostId, (int) $obj->UserId, $obj->CategoryType);
                    /* @var $activityObj type */
                    if (isset($activityObj->UserId)) {
                        UserActivityCollection::model()->updatePostActvityObject($obj, $activityObj->_id, (int) $obj->UserId, $obj->ActionType);
                    } else {
                        UserActivityCollection::model()->saveUserActivityForPost($obj);
                    }
                }
                  UserInteractionCollection::model()->saveUserActivityForPost($obj);
            } else {
                if ($obj->ActionType == 'Post') {
                    $obj->PostFollowers = (int) $obj->UserId;
                    $obj->StreamNote = CommonUtility::actionTextbyActionType((int) $obj->PostType);
                }

                if ($obj->ActionType == 'Comment') {
                    $obj->StreamNote = CommonUtility::actionTextbyActionType('Comment');
                }
                if ($obj->ActionType == 'Survey') {
                    $obj->StreamNote = CommonUtility::actionTextbyActionType('Survey');
                }
                if ($obj->ActionType == 'EventAttend') {
                    $obj->StreamNote = CommonUtility::actionTextbyActionType('EventAttend');
                }
                if ($obj->ActionType == 'Love') {
                    $obj->StreamNote = CommonUtility::actionTextbyActionType('Love');
                }
                if ($obj->ActionType == 'FbShare') {
                    $obj->StreamNote = CommonUtility::actionTextbyActionType('FbShare');
                }
                if ($obj->ActionType == 'TwitterShare') {
                    $obj->StreamNote = CommonUtility::actionTextbyActionType('TwitterShare');
                }
                if ($obj->ActionType == 'Invite') {
                    $obj->StreamNote = ' has invited to ';
                }
                
                $activityObj = UserActivityCollection::model()->getActvityObjbyPostId($obj->PostId, (int) $obj->UserId, $obj->CategoryType);
                /* @var $activityObj type */
                if (isset($activityObj->UserId)) {
                    UserActivityCollection::model()->updatePostActvityObject($obj, $activityObj->_id, (int) $obj->UserId, $obj->ActionType);
                } else {

                    UserActivityCollection::model()->saveUserActivityForPost($obj);
                }

                UserInteractionCollection::model()->saveUserActivityForPost($obj);
            }
        } catch (Exception $ex) {
            echo "Excepiton occured at save activity in amqp command" . $ex->getMessage();
            Yii::log("AMQPCommand:saveUserActivity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * autho: suresh reddy
     * @method is used for distibute active objects stream
     * @param type $obj
     */
     function distributeStreamObj($obj) {
        try {
            $obj = (object) $obj;
            $UserId = $obj->UserId;
            $obj->CategoryType = $obj->CategoryType;
            $skiptapostService = new SkiptaPostService;
            $obj->PostFollowers = (int) $obj->UserId;
            if ($obj->ActionType == 'Post') {

                if ($obj->CategoryType == 2) {
                    $categoryObj = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId($obj->CurbsideCategoryId);
                    if (isset($categoryObj->Followers)) {
                        foreach ($categoryObj->Followers as $follower) {
//                            $notifiObj = new Notifications();
//                            $this->savePostNotifications($obj, ' posted a curbside consult using a ' . $categoryObj->CategoryName .' that you are following.',"", 'post', $notifiObj,$follower);
                            $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($follower);
                            if ($userSettings != "failure") {
                                if ($userSettings->CurbsidePostFollowing == 1) {
                                    $notificationObj = new Notifications();
                                    $notificationObj->UserId = $follower;
                                    $notificationObj->CurbsideCategory = $categoryObj->CategoryName;
                                    $this->saveNotifications($obj, ' posted a curbside consult using a ' . $categoryObj->CategoryName .' that you are following.',"", 'post', $notificationObj, $userSettings->NetworkId);
                                }
                            }
                        }
                    }
                }

                $obj->RecentActivity = 'Post';
                 if($obj->PostType!=17)
                $obj->StreamNote = CommonUtility::actionTextbyActionType($obj->PostType);


                if ($obj->PostType == 12 && $obj->CategoryType == 9 && $obj->PreviousGameScheduleId != 0 && $obj->ActionType == "Post") {

                    UserStreamCollection::model()->updateStreamForGameSchedule($obj);
                } else {
                  
                        if($obj->CategoryType !=13 || $obj->UserId==0){
                            $this->saveStreamforNetworkUsers($obj);
                        }
                          
                    $hashTagIdArray = $obj->HashTags;
                    for ($j = 0; $j < count($hashTagIdArray); $j++) {
                        //Here added logic for saving the Hashtag usage actiontype in the userInteractionCollection.
                        $actionTypeValue=$obj->ActionType;
                        $saveHashTagUsageObj=$obj;
                        $saveHashTagUsageObj->ActionType="HashTagUsage";
                        UserInteractionCollection::model()->saveUserActivityForPost($saveHashTagUsageObj);
                        $saveHashTagUsageObj->ActionType=$actionTypeValue;
                      
                        $hashObj = $hashTagIdArray[$j];
                        $hashTagObject = $skiptapostService->getHashTagFollowers($hashObj['$id']);
                        if (is_object($hashTagObject)) {
                            $obj->Priority = (int) 1;
                            $obj->RecentActivity = 'Post';
                            $obj->StreamNote1 = "on a #" . $hashTagObject->HashTagName;
                            foreach ($hashTagObject->HashTagFollowers as $hashTagFollower) {                
                                //$notifiObj = new Notifications();
                                //$this->savePostNotifications($obj, ' made a post using a #' . $hashTagObject->HashTagName .' that you are following. ',"", 'post',$notifiObj,$hashTagFollower);
                                if($hashTagFollower !=$UserId){
                                 $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($hashTagFollower);
                                if ($userSettings != "failure") {
                                    if ($userSettings->HashTagFollowingYou == 1) {
                                        $notificationObj = new Notifications();
                                        $notificationObj->UserId = $hashTagFollower;
                                        $notificationObj->Hashtag = $hashTagObject->HashTagName;
                                        $this->saveNotifications($obj, ' made a post using a #' . $hashTagObject->HashTagName . ' that you are following. ', "", 'post', $notificationObj, $userSettings->NetworkId);
                                    }
                                }
                                }
                                
  
                                $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), $hashTagFollower);
                                $obj->StreamUserId = $hashTagFollower;
                                $obj->HashTagPostUserId = (int) $obj->UserId;

                                if (isset($streamObj->UserId)) {
                                    UserStreamCollection::model()->updateStreamObject($obj, $streamObj->_id, $hashTagFollower, $obj->RecentActivity);
                                } else {
                                    UserStreamCollection::model()->saveUserStream($obj);
                                }
                            }
                        }
                    }
                    /**
                     * User followers stream generate
                     */

                    if($obj->CategoryType!=11 && $obj->CategoryType!=9 && $obj->CategoryType!=14 && $obj->CategoryType!=13)
                    {
                    $obj->HashTagPostUserId = "";
                    if($obj->NetworkAdminUserId!=(string)$UserId){
                        $followerUsers = $skiptapostService->getFollowersOfUser($UserId);
                        for ($i = 0; $i < sizeof($followerUsers); $i++) {
                            $obj->Priority = (int) 1;
                            $obj->StreamUserId = (int) $followerUsers[$i];
                            $obj->RecentActivity = 'Post';
                            $obj->UserFollowers = (int) $obj->UserId;
                            $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i]);
                            if (isset($streamObj->UserId)) {
                                UserStreamCollection::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity);
                            } else {
                                UserStreamCollection::model()->saveUserStream($obj);
                            }
                        }
                    }
                    }
                    $obj->HashTagPostUserId = "";
                    $obj->MentionUserId = "";
                    if($obj->CategoryType!=9)
                    {
                    $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), $obj->UserId);
                    $obj->StreamUserId = (int) $obj->UserId;
                    $obj->Priority = (int) 2;
                    if (isset($streamObj->UserId)) {
                        UserStreamCollection::model()->updateStreamObject($obj, $streamObj->_id, $obj->UserId, $obj->RecentActivity);
                    } else {
                        UserStreamCollection::model()->saveUserStream($obj);
                    }
                    }
                  
                }
                $obj->StreamNote = CommonUtility::actionTextbyActionType('UserMention');
                $mentionArray = $obj->MentionArray;
                for ($i = 0; $i < sizeof($mentionArray); $i++) {
                    $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), $mentionArray[$i]);
                    $obj->StreamUserId = (int) $mentionArray[$i];
                    $obj->Priority = (int) 2;
                    $obj->RecentActivity = 'UserMention';
                    $obj->MentionUserId = (int) $obj->UserId;
                    if (isset($streamObj->UserId)) {
                        UserStreamCollection::model()->updateStreamObject($obj, $streamObj->_id, $mentionArray[$i], $obj->RecentActivity);
                    } else {
                        UserStreamCollection::model()->saveUserStream($obj);
                    }

                    $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($mentionArray[$i]);
                    if ($userSettings != "failure") {
                        if ($userSettings->Mentioned == 1) {
                            try {
                                $notificationObj = new Notifications();
                                $notificationObj->UserId = (int) $mentionArray[$i];
                                $notificationObj->NotificationNote = 'mentioned';
                                $notificationObj->NotificationNoteTwo = 'on a Post';
                                $notificationObj->RecentActivity = 'mention';
                                $notificationObj->MentionedUserId = $obj->UserId;
                                $notificationObj->PostId = $obj->PostId;
                                $notificationObj->CategoryType = $obj->CategoryType;
                                $notificationObj->NetworkId = $userSettings->NetworkId;
                                $notificationObj->isRead = 0;
                                $notificationObj->PostType = $obj->PostType;
                                $notificationObj->CreatedOn = $obj->CreatedOn;
                                $notificationObj->SegmentId = $obj->SegmentId;
                                $notificationObj->Language  = $obj->Language;
                                $notificationObj->IsAnonymous  = $obj->IsAnonymous;

                              $userNotifications = Notifications::model()->getNotificationsForUserWithPost($mentionArray[$i], $obj->PostId, $userSettings->NetworkId, $obj->CategoryType, 'mention');
                                if ($userNotifications != 'failure') {
                                    Notifications::model()->updateNotificationsForUser($userNotifications->_id, $obj->ActionType, $notificationObj);
                                } else {
                                     $obj->ActionType = "Mention";
                                     $obj->OriginalUserId = (int) $mentionArray[$i];
                                     CommonUtility::initiatePushNotification($obj,false);
                                    Notifications::model()->saveNotifications($notificationObj);
                                }
                            } catch (Exception $ex) {
                                
                            }
                        }
                         if ($userSettings->ActivityInvolvesYou == 1) {
                           //need explanation  
                         }
                    }
                }
            }
        } catch (Exception $ex) {
            echo "Excepiton occured at save user stream in amqp command" . $ex->getMessage();
            Yii::log("AMQPCommand:distributeStreamObj::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     function distributeStreamForInviteUsers($obj) {
        try {
            $obj = (object) $obj;
            $UserId = $obj->UserId;

            $postType = CommonUtility::postTypebyIndex($obj->PostType);

            $skiptapostService = new SkiptaPostService;


            if ($obj->ActionType == 'Invite') {
                $obj->RecentActivity = 'Invite';

                /**
                 * put stram for Comment userid
                 */
                $obj->StreamNote = CommonUtility::actionTextbyActionType('Invite');
                $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), $obj->UserId);
                $obj->StreamUserId = (int) $obj->UserId;
                $obj->CommentUserId = (int) $obj->UserId;

                $obj->Priority = (int) 2;


                $invitedUserId = $obj->UserId;
                foreach ($obj->InviteUsers as $user) {
                    $obj->StreamUserId = $user;
                    $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), $user);
                    $obj->InviteUsers = (int) $invitedUserId;
                    if (isset($streamObj->UserId)) {
                        UserStreamCollection::model()->updateStreamObject($obj, $streamObj->_id, $user, $obj->RecentActivity);
                    } else {
                        UserStreamCollection::model()->saveUserStream($obj);
                    }
             
                    $userSettings = UserNotificationSettingsCollection::model()->getUserSettings((int) $user);
                    if ($userSettings != "failure") {
                        if ($userSettings->Invited == 1) {
                            try {
                                $this->saveUserInviteNotifications($obj, $userSettings->NetworkId, $user,$invitedUserId);
                                  $obj->ActionType = "Invite";
                                   $obj->UserId = (int) $invitedUserId;
                                  $obj->OriginalUserId = (int) $user;
                                   CommonUtility::initiatePushNotification($obj,false);
                            } catch (Exception $ex) {
                                echo " EXCEPTION rised at save invite notifcation " . $ex->getMessage();
                                Yii::log("AMQPCommand:distributeStreamForInviteUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                            }
                        }
                        if ($userSettings->ActivityInvolvesYou == 1) {
                           //need explanation  
                         }
                    }
                    $obj->UserId = $obj->StreamUserId;
                    $activityObj = UserActivityCollection::model()->getActvityObjbyPostId($obj->PostId, $obj->ActionType, $obj->CategoryType);
                    if (isset($activityObj->UserId)) {
                        UserActivityCollection::model()->updatePostActvityObject($obj, $activityObj->_id, (int) $obj->StreamUserId, $obj->ActionType);
                    } else {
                        UserActivityCollection::model()->saveUserActivityForPost($obj);
                    }
                }
            }
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:distributeStreamForInviteUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     public function saveUserInviteNotifications($obj, $NetworkId, $userId,$invitedUserId) {

        try {
            $notificationObj = new Notifications();
            $notificationObj->UserId = (int) $userId;
            $notificationObj->NotificationNote = 'invited';
            $notificationObj->RecentActivity = 'invite';
            $notificationObj->InviteUserId = (int) $invitedUserId;
            $notificationObj->PostId = $obj->PostId;
            $notificationObj->CategoryType = $obj->CategoryType;
            $notificationObj->NetworkId = (int) $NetworkId;
            $notificationObj->isRead = 0;
            $notificationObj->PostType = $obj->PostType;
            $notificationObj->CreatedOn = $obj->CreatedOn;
            $notificationObj->SegmentId = $obj->SegmentId;
            $notificationObj->Language = $obj->Language;
            $userNotifications = Notifications::model()->getNotificationsForUserWithPost($userId, $obj->PostId, $NetworkId, $obj->CategoryType, 'Invite');

            if ($userNotifications != 'failure') {
                Notifications::model()->updateNotificationsForUser($userNotifications->_id, $obj->ActionType, $notificationObj);
            } else {
                Notifications::model()->saveNotifications($notificationObj);
            }
        } catch (Exception $ex) {
            echo '_________1 exception__________' .  $ex->getMessage();
            Yii::log("AMQPCommand:saveUserInviteNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    function distributeStreamForComment($obj) {
        try {
            $obj = (object) $obj;
            $UserId = $obj->UserId;
            $skiptapostService = new SkiptaPostService;


            if ($obj->ActionType == 'Comment') {
                $obj->RecentActivity = 'Comment';
                $obj->CommentUserId = (int) $obj->UserId;
                $obj->StreamNote = CommonUtility::actionTextbyActionType('Comment');



                $OriginalUserId = array($obj->UserId);
                $PostOriginalUserId = array($obj->OriginalUserId);
                /* this is to get the hash tags details if any  */
                $hashTagIdArray = $obj->HashTags;
                if(isset($hashTagIdArray)){
                for ($j = 0; $j < count($hashTagIdArray); $j++) {
                        $hashObj = $hashTagIdArray[$j];
                        $hashTagObject = $skiptapostService->getHashTagFollowers($hashObj['$id']);
                        if (is_object($hashTagObject)) {
                            foreach ($hashTagObject->HashTagFollowers as $hashTagFollower) {                
                                //$notifiObj = new Notifications();
                                //$this->savePostNotifications($obj, ' made a post using a #' . $hashTagObject->HashTagName .' that you are following. ',"", 'post',$notifiObj,$hashTagFollower);
                                
                                 $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($hashTagFollower);
                                if ($userSettings != "failure") {
                                    if ($userSettings->HashTagFollowingYou == 1) {
                                        $notificationObj = new Notifications();
                                        $notificationObj->UserId = $hashTagFollower;
                                        $notificationObj->Hashtag = $hashTagObject->HashTagName;
                                        $this->saveNotifications($obj, ' made a comment using #' . $hashTagObject->HashTagName . ' that you are following. ', "", 'comment', $notificationObj, $userSettings->NetworkId);
                                    }
                                }
                                
  
                                                            }
                        }
                    }
                }
                /**
                 * prepare user list to distribute comment 
                 */
                $PostObjFollowers = ServiceFactory::getSkiptaPostServiceInstance()->getObjectFollowers($obj->PostId, $obj->PostType, $obj->CategoryType);
                 $PostObjsavedUsers=ServiceFactory::getSkiptaPostServiceInstance()->getObjectSaveItForLaterUsers($obj->PostId, $obj->PostType, $obj->CategoryType);
                $followerUsers = array();
                if($obj->NetworkAdminUserId!=(string)($obj->UserId)){
                    $followerUsers = ServiceFactory::getSkiptaPostServiceInstance()->getFollowersOfUser($obj->UserId);
                }
                $originalPostUserFollowers = array();
                if($obj->NetworkAdminUserId!=(string)($obj->OriginalUserId)){
                    $originalPostUserFollowers = ServiceFactory::getSkiptaPostServiceInstance()->getFollowersOfUser($obj->OriginalUserId);
                }
                $mentionArray = $obj->MentionArray;
                if (count($mentionArray) > 0) {
                    for ($i = 0; $i < sizeof($mentionArray); $i++) {
                        $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($mentionArray[$i]);
                        if ($userSettings != "failure") {
                            if ($userSettings->Mentioned == 1) {
                                try {
                                    $notificationObj = new Notifications();
                                    $notificationObj->UserId = (int) $mentionArray[$i];
                                    $notificationObj->NotificationNote = 'mentioned';
                                    $notificationObj->NotificationNoteTwo = 'on a Post';
                                    $notificationObj->RecentActivity = 'mention';
                                    $notificationObj->MentionedUserId = $obj->UserId;
                                    $notificationObj->PostId = $obj->PostId;
                                    $notificationObj->CategoryType = $obj->CategoryType;
                                    $notificationObj->NetworkId = $userSettings->NetworkId;
                                    $notificationObj->isRead = 0;
                                    $notificationObj->PostType = $obj->PostType;
                                    $notificationObj->CommentUserId = (int) $mentionArray[$i];
                                    $notificationObj->CreatedOn = $obj->CreatedOn;
                                    $notificationObj->SegmentId = $obj->SegmentId;
                                    $notificationObj->Language  = $obj->Language;
                                    $notificationObj->IsAnonymous  = $obj->IsAnonymous;
                                    
                                    $userNotifications = Notifications::model()->getNotificationsForUserWithPost($mentionArray[$i], $obj->PostId, $userSettings->NetworkId, $obj->CategoryType, 'mention');
                                    if ($userNotifications != 'failure') {
                                        Notifications::model()->updateNotificationsForUser($userNotifications->_id, 'mention', $notificationObj);
                                    } else {
                                        Notifications::model()->saveNotifications($notificationObj);
                                    }
                                     $obj->ActionType = "Mention";
                                     $obj->OriginalUserId = (int) $mentionArray[$i];
                                     CommonUtility::initiatePushNotification($obj,false);
                                } catch (Exception $ex) {
                                    
                                }
                            }
                           if ($userSettings->ActivityInvolvesYou == 1) {
                           //need explanation  
                            }
                        }
                    }
                }

                if (!is_array($PostObjFollowers)) {
                    $PostObjFollowers = array();
                }
                if (!is_array($followerUsers)) {
                    $followerUsers = array();
                }
                if (!is_array($originalPostUserFollowers)) {
                    $originalPostUserFollowers = array();
                }
                if (!is_array($PostObjsavedUsers)) {
                    $PostObjsavedUsers = array();
                }

                $usersList = array_values(array_unique(array_merge(array(0), $OriginalUserId, $PostOriginalUserId, $PostObjFollowers, $followerUsers, $originalPostUserFollowers)));
                for ($i = 0; $i < sizeof($usersList); $i++) {

                    $obj->StreamUserId = (int) $usersList[$i];
                    $obj->RecentActivity = 'Comment';
                    $obj->CommentUserId = (int) $obj->UserId;
                     $obj->StreamNote = CommonUtility::actionTextbyActionType('Comment');

                    $isEngageObj = UserActivityCollection::model()->getEngageObjbyPostId(new MongoId($obj->PostId), (int) $usersList[$i], (int) $obj->CategoryType);



                    $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int) $usersList[$i]);
                    if (!isset($isEngageObj->UserId)) {
                        if (isset($streamObj->UserId)) {
                            if ($streamObj->RecentActivity == "Invite") {
                                $obj->ActionType = 'Invite';
                                $obj->StreamNote = CommonUtility::actionTextbyActionType('Invite');
                                $obj->RecentActivity = 'Invite';
                                $obj->InviteUsers = 0;
                            }
                        }
                    }
                    if (isset($streamObj->UserId)) {
                        UserStreamCollection::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity);
                    } else {
                        UserStreamCollection::model()->saveUserStream($obj);
                    }
                }
               $this->updateIsEngage($obj->PostId, $UserId);
            }
               
                     $obj->RecentActivity = 'Comment';
                     $obj->ActionType = 'Comment';
                     $obj->CommentUserId = (int) $obj->UserId;
                     $obj->StreamNote = CommonUtility::actionTextbyActionType('Comment');



            /**
             * update social count  for user id =0
             */
            UserStreamCollection::model()->updateStreamSocialActions($obj);
            UserActivityCollection::model()->updateActvitySocialActions($obj);
            FollowObjectStream::model()->updateStreamSocialActions($obj);
            //update social count for featured Items
            NewsCollection::model()->updateStreamSocialActions($obj);
        } catch (Exception $ex) {
            echo "distributeStreamForComment" .  $ex->getMessage();
            Yii::log("AMQPCommand:distributeStreamForComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     function distributeStreamForPlay($obj) {
        try {
            $obj = (object) $obj;
            $UserId = $obj->UserId;



            if ($obj->ActionType == 'Play') {
                $obj->RecentActivity = 'Play';

                $obj->StreamNote = CommonUtility::actionTextbyActionType('Play');



                $OriginalUserId = array($obj->UserId);
                $PostOriginalUserId = array($obj->OriginalUserId);
                /* this is to get the hash tags details if any  */


                /**
                 * prepare user list to distribute comment 
                 */
                $PostObjFollowers = ServiceFactory::getSkiptaPostServiceInstance()->getObjectFollowers($obj->PostId, $obj->PostType, $obj->CategoryType);
                $followerUsers = array();
                if ($obj->NetworkAdminUserId != (string) ($obj->UserId)) {
                    $followerUsers = ServiceFactory::getSkiptaPostServiceInstance()->getFollowersOfUser($obj->UserId);
                }
                $originalPostUserFollowers = array();
                if ($obj->NetworkAdminUserId != (string) ($obj->OriginalUserId)) {
                    $originalPostUserFollowers = ServiceFactory::getSkiptaPostServiceInstance()->getFollowersOfUser($obj->OriginalUserId);
                }


                if (!is_array($PostObjFollowers)) {
                    $PostObjFollowers = array();
                }
                if (!is_array($followerUsers)) {
                    $followerUsers = array();
                }
                if (!is_array($originalPostUserFollowers)) {
                    $originalPostUserFollowers = array();
                }

                $usersList = array_values(array_unique(array_merge($OriginalUserId, $PostOriginalUserId, $PostObjFollowers, $followerUsers, $originalPostUserFollowers)));

                for ($i = 0; $i < sizeof($usersList); $i++) {

                    $obj->StreamUserId = (int) $usersList[$i];
                    $obj->RecentActivity = 'Play';
                    $obj->CommentUserId = (int) $obj->UserId;

                    $isEngageObj = UserActivityCollection::model()->getEngageObjbyPostId(new MongoId($obj->PostId), (int) $usersList[$i], (int) $obj->CategoryType);



                    $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int) $usersList[$i]);

                    if (isset($streamObj->UserId)) {
                        UserStreamCollection::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity);
                    } else {
                        UserStreamCollection::model()->saveUserStream($obj);
                    }
                }
               $this->updateIsEngage($obj->PostId, $UserId);
            }



            /**
             * update social count  for user id =0
             */
            UserStreamCollection::model()->updateStreamSocialActions($obj);
            UserActivityCollection::model()->updateActvitySocialActions($obj);
            FollowObjectStream::model()->updateStreamSocialActions($obj);
            //update social count for featured Items
            NewsCollection::model()->updateStreamSocialActions($obj);
        } catch (Exception $ex) {
            echo "distributeStreamForComment" .  $ex->getMessage();
            Yii::log("AMQPCommand:distributeStreamForPlay::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     function distributeStreamForSurvey($obj) {
        try {
            $obj = (object) $obj;
            $UserId = (int) $obj->UserId;
            $skiptapostService = new SkiptaPostService;
            if ($obj->ActionType == 'Survey') {
                $obj->RecentActivity = 'Survey';
                $obj->StreamNote = CommonUtility::actionTextbyActionType('Survey');
                $obj->UserFollowers = "";
                $obj->SurveyTaken = "";
                $obj->Priority = (int) 1;
                $obj->FollowEntity = CommonUtility::getIndexBySystemFollowingThing('Post');
                if ($obj->NetworkAdminUserId != (string) ($obj->UserId)) {
                    $followerUsers = $skiptapostService->getFollowersOfUser($obj->UserId);
                    for ($i = 0; $i < sizeof($followerUsers); $i++) {
                        $obj->StreamUserId = (int) $followerUsers[$i];
                        $obj->SurveyTaken = (int) $obj->UserId;
                        if ((int) $obj->UserId != $followerUsers[$i]) {
                            $isEngageObj = UserActivityCollection::model()->getActvityObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i], (int) $obj->CategoryType);
                            if (!is_object($isEngageObj)) {

                                $streamObj = FollowObjectStream::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i], (int) $obj->FollowEntity);
                                if (isset($streamObj->UserId)) {
                                    FollowObjectStream::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity);
                                } else {

                                    FollowObjectStream::model()->saveFollowObjectStream($obj);
                                }
                            }
                        }
                    }
                }
                UserStreamCollection::model()->saveSurvey($obj);
               $this->updateIsEngage($obj->PostId, $UserId);
            }
        } catch (Exception $ex) {
            echo "exception at survery taken " .  $ex->getMessage();
           Yii::log("AMQPCommand:distributeStreamForSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     function distributeStreamForEventAttend($obj) {
        try {
            $obj = (object) $obj;
            $UserId = (int) $obj->UserId;
            $skiptapostService = new SkiptaPostService;
            if ($obj->ActionType == 'EventAttend') {
                $obj->RecentActivity = 'EventAttend';
                $obj->StreamNote = CommonUtility::actionTextbyActionType('EventAttend');
                
                $obj->FollowEntity = CommonUtility::getIndexBySystemFollowingThing('Post');
                $obj->Priority = (int) 1;


            if ($obj->NetworkAdminUserId != (string) $UserId) {
                $followerUsers = $skiptapostService->getFollowersOfUser($UserId);
                for ($i = 0; $i < sizeof($followerUsers); $i++) {
                    $obj->StreamUserId = (int) $followerUsers[$i];
                    $obj->RecentActivity = 'EventAttend';
                    $obj->EventAttendes = (int) $obj->UserId;
                    if ((int) $obj->UserId != $followerUsers[$i]) {
                        $isEngageObj = UserActivityCollection::model()->getActvityObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i], (int) $obj->CategoryType);
                        if (!is_object($isEngageObj)) {
                            $streamObj = FollowObjectStream::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i], (int) $obj->FollowEntity);
                            if (isset($streamObj->UserId)) {
                                FollowObjectStream::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity);
                            } else {
                                FollowObjectStream::model()->saveFollowObjectStream($obj);
                            }
                        }
                    }
                }
            }
                UserStreamCollection::model()->attendEvent($obj);
               $this->updateIsEngage($obj->PostId, $UserId);
            }
        } catch (Exception $ex) {
            echo "excepiton occured at event attend" .  $ex->getMessage();
            Yii::log("AMQPCommand:distributeStreamForEventAttend::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     function saveStreamforNetworkUsers($obj) {
        try{ 
        if (isset($obj->CategoryType) && $obj->CategoryType != 10 && $obj->CategoryType!=11 &&  $obj->CategoryType != 12 && $obj->CategoryType!=14) {
            $obj->StreamUserId = 0;
            //$obj->StreamNote = CommonUtility::actionTextbyActionType('Post') . " ";
            UserStreamCollection::model()->saveUserStream($obj);
        }
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:saveStreamforNetworkUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    function updateStreamSocialActionsCount($obj) {
        try {
            UserStreamCollection::model()->updateStreamSocialActions($obj);
            //update social count for featured Items
            NewsCollection::model()->updateStreamSocialActions($obj);
        } catch (Exception $ex) {
            echo "distributeStreamForComment" .  $ex->getMessage();
            Yii::log("AMQPCommand:updateStreamSocialActionsCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * derivative stream for actions  love, event attend, submit survery, game play
     * @param type $obj  stream obj
     */
     function derivativeStreamForLoveAction($obj) {
        try {

            $obj = (object) $obj;
            $UserId = (int) $obj->UserId;
            $skiptapostService = new SkiptaPostService;


            if ($obj->ActionType == 'Love') {
                $obj->RecentActivity = 'Love';
                $obj->StreamNote = CommonUtility::actionTextbyActionType('Love');
                $obj->FollowEntity = CommonUtility::getIndexBySystemFollowingThing('Post');
                $obj->Priority = (int) 1;
                if ($obj->NetworkAdminUserId != (string) $UserId) {
                    $followerUsers = $skiptapostService->getFollowersOfUser($UserId);
                    for ($i = 0; $i < sizeof($followerUsers); $i++) {
                        $obj->StreamUserId = (int) $followerUsers[$i];
                        $obj->LoveUserId = (int) $obj->UserId;
                        if ((int) $obj->UserId != $followerUsers[$i]) {
                            $isEngageObj = UserActivityCollection::model()->getActvityObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i], (int) $obj->CategoryType);
                            if (!is_object($isEngageObj)) {
                                $streamObj = FollowObjectStream::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i], (int) $obj->FollowEntity);
                                if (isset($streamObj->UserId)) {
                                    FollowObjectStream::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity);
                                } else {
                                    FollowObjectStream::model()->saveFollowObjectStream($obj);
                                }
                            }
                        }
                    }
                }
            }
            if ($obj->ActionType == 'TwitterShare' || $obj->ActionType == 'FbShare') {
                $obj->RecentActivity = 'Share';
                $obj->StreamNote = CommonUtility::actionTextbyActionType($obj->ActionType);
                $obj->FollowEntity = CommonUtility::getIndexBySystemFollowingThing('Post');
                $obj->Priority = (int) 1;
                if ($obj->NetworkAdminUserId != (string) $UserId) {
                    $followerUsers = $skiptapostService->getFollowersOfUser($UserId);
                    for ($i = 0; $i < sizeof($followerUsers); $i++) {
                        $obj->StreamUserId = (int) $followerUsers[$i];
                        if ($obj->ActionType == 'FbShare') {
                            $obj->TwitterShare = (int) $obj->UserId;
                        }
                        if ($obj->ActionType == 'TwitterShare') {
                            $obj->FbShare = (int) $obj->UserId;
                        }
                        if ((int) $obj->UserId != $followerUsers[$i]) {
                            $isEngageObj = UserActivityCollection::model()->getActvityObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i], (int) $obj->CategoryType);
                            if (!is_object($isEngageObj)) {

                                $streamObj = FollowObjectStream::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i], (int) $obj->FollowEntity);
                                if (isset($streamObj->UserId)) {
                                    FollowObjectStream::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity);
                                } else {
                                    FollowObjectStream::model()->saveFollowObjectStream($obj);
                                }
                            }
                        }
                    }
                }
            }

            UserStreamCollection::model()->updateStreamSocialActions($obj);
            //update social count for featured Items
            NewsCollection::model()->updateStreamSocialActions($obj);
            UserActivityCollection::model()->updateActvitySocialActions($obj);
           $this->updateIsEngage($obj->PostId, $UserId);
        } catch (Exception $ex) {
            echo "distributeStreamForComment" .  $ex->getMessage();
            Yii::log("AMQPCommand:derivativeStreamForLoveAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     function distributeStreamForFollowObject($obj) {
        try {
            $obj = (object) $obj;
            $obj->FollowOn = $obj->CreatedOn;
            $UserId = (int) $obj->UserId;
            $obj->PostType = (int) $obj->PostType;
            if ($obj->ActionType == "HashTagFollow") {
                $obj->HashTagFollowers = (int) $UserId;
                $obj->StreamNote = CommonUtility::actionTextbyActionType($obj->ActionType);
                $obj->HashTagId = (int) $obj->HashTagId;
                $obj->HashTagName = $obj->HashTagName;
                $obj->HashTagPostCount = (int) $obj->HashTagPostCount;
                $obj->RecentActivity = $obj->ActionType;
            } else if ($obj->ActionType == "CurbsideCategoryFollow") {
                $obj->CurbsideCategoryFollowers = (int) $UserId;
                $obj->CurbsideConsultCategory = $obj->CurbsideConsultCategory;
                $obj->CurbsideCategoryId = $obj->CurbsideCategoryId;
                $obj->StreamNote = CommonUtility::actionTextbyActionType($obj->ActionType);
                $obj->CurbsidePostCount = $obj->CurbsidePostCount;
                $obj->RecentActivity = $obj->ActionType;
            } else if ($obj->ActionType == "GroupFollow") {

                $obj->StreamNote = CommonUtility::actionTextbyActionType($obj->ActionType);
                $obj->GroupFollowers = (int) $UserId;
                $obj->GroupId = (String) $obj->GroupId;
                $obj->RecentActivity = 'GroupFollow';
            } else if ($obj->ActionType == "SubGroupFollow") {

                $obj->StreamNote = CommonUtility::actionTextbyActionType($obj->ActionType);
                $obj->SubGroupFollowers = (int) $UserId;
                $obj->SubGroupId = (String) $obj->SubGroupId;
                $obj->RecentActivity = 'SubGroupFollow';
            } else if ($obj->ActionType == "Follow") {
                $obj->PostFollowers = (int) $UserId;
                $obj->RecentActivity = 'PostFollow';
                $obj->StreamNote = CommonUtility::actionTextbyActionType('Follow');
                $obj->FollowEntity = CommonUtility::getIndexBySystemFollowingThing('Post');
            }
            if ($obj->ActionType == "GroupFollow" || $obj->ActionType == "SubGroupFollow" || $obj->ActionType == "Follow" || $obj->ActionType == "CurbsideCategoryFollow" || $obj->ActionType == "HashTagFollow") {
                $followerUsers = array();
                if($obj->NetworkAdminUserId!=(string)$UserId){
                    $followerUsers = ServiceFactory::getSkiptaPostServiceInstance()->getFollowersOfUser($UserId);
                    $obj->Priority = (int) 1;
                    for ($i = 0; $i < sizeof($followerUsers); $i++) {
                        $obj->StreamUserId = (int) $followerUsers[$i];

                        if ($obj->CategoryType == 3 && $obj->IsPrivate == 0 || $obj->CategoryType == 7) {
                            $streamObj = FollowObjectStream::model()->getStreamObjbyPostId(new MongoId((String) $obj->PostId), (int) $followerUsers[$i], (int) $obj->FollowEntity);

                            if (isset($streamObj->UserId)) {
                                FollowObjectStream::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity, $obj->FollowOn);
                            } else {
                                FollowObjectStream::model()->saveFollowObjectStream($obj);
                            }
                        } else {
                            $streamObj = FollowObjectStream::model()->getStreamObjbyPostId(new MongoId((String) $obj->PostId), (int) $followerUsers[$i], (int) $obj->FollowEntity);

                            if (isset($streamObj->UserId)) {
                                FollowObjectStream::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity, $obj->FollowOn);
                            } else {
                                FollowObjectStream::model()->saveFollowObjectStream($obj);
                            }
                        }
                    }
                }
               $this->updateIsEngage((String) $obj->PostId, $UserId);
            }

            if ($obj->ActionType == "UnFollow") {
                UserStreamCollection::model()->unFollowObject($obj);
            }


            if (isset($obj->RecentActivity) && $obj->RecentActivity == 'PostFollow') {

                UserStreamCollection::model()->followObject($obj);
               $this->updateIsEngage((String) $obj->PostId, $UserId);
                UserActivityCollection::model()->followObject($obj);
            }
        } catch (Exception $ex) {
            echo "***EXCEPTION**" .  $ex->getTraceAsString();
            Yii::log("AMQPCommand:distributeStreamForFollowObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar Pathapelli updated by suresh reddy 8/3/14  , need to same functionality in derivative stream.
     * @Description Updating Post management actions
     * @param type $obj
     */
    public  function updatePostManagementActions($obj) {
        try {
            if ($obj->ActionType=='SaveItForLater')
            {  
                $this->saveObjForSaveItForLater($obj);
             
            }
            else if($obj->ActionType=='SaveItForLaterCancel')
            {
                UserStreamCollection::model()->updatePostManagementActions($obj); 
            }
            else
            {
            UserStreamCollection::model()->updatePostManagementActions($obj);
            /**
             * block and release delete in derivative stream.
             */
            $postObj = '';
            FollowObjectStream::model()->updatePostManagementActions($obj);
            UserActivityCollection::model()->updatePostManagementActions($obj);
            UserInteractionCollection::model()->updatePostManagementActions($obj);

            /** Updated by Vamsi 
             * This block is to update 
             * 1)GroupCollection
             * 2)CurbsideCategory 
             * 3)HashTagCollection
             */
            if ($obj->ActionType == 'Block' || $obj->ActionType == 'Abuse' || $obj->ActionType == 'Delete') {
                if ($obj->CatagoryId == 3 || $obj->CatagoryId == 7) {
                    $postObj = GroupPostCollection::model()->getGroupPostById($obj->PostId);
                    if ($obj->CatagoryId == 7) {
                        SubGroupCollection::model()->updateGroupCollectionForDelete($obj, $postObj->SubGroupId);
                    } else {
                        GroupCollection::model()->updateGroupCollectionForDelete($obj, $postObj->GroupId);
                    }
                }
                if ($obj->CatagoryId == 2) {
                    $postObj = CurbsidePostCollection::model()->getPostById($obj->PostId);
                    if (isset($postObj->CategoryId)) {
                        CurbSideCategoryCollection::model()->updateCurbSideCategoryCollectionForDelete($obj, $postObj->CategoryId);
                    }
                    if ($postObj->IsFeatured == 1) {
                        NewsCollection::model()->updateNewsCollection($obj->PostId, $obj->CatagoryId, $obj->ActionType);
                    }
                }if ($obj->CatagoryId == 1) {
                    $postObj = PostCollection::model()->getPostById($obj->PostId);
                    if ($postObj->IsFeatured == 1) {
                        NewsCollection::model()->updateNewsCollection($obj->PostId, $obj->CatagoryId, $obj->ActionType);
                    }
                }

                ResourceCollection::model()->updateResourceCollectionForDelete($obj);
                if (isset($postObj) && $postObj!='' && count($postObj->HashTags) > 0) {
                    foreach ($postObj->HashTags as $hashtag) {
                        HashTagCollection::model()->updateHashTagCollectionForDelete($obj, $hashtag);
                    }
                }
                // Notifications::model()->updateNotificationsDelete($obj);
            } else if ($obj->ActionType == 'Release') {
                if ($obj->CatagoryId == 3 || $obj->CatagoryId == 7) {
                    $postObj = GroupPostCollection::model()->getGroupPostById($obj->PostId);
                    if ($obj->CatagoryId == 7) {
                        SubGroupCollection::model()->updateGroupCollectionForDelete($obj, $postObj->SubGroupId);
                    } else {
                        GroupCollection::model()->updateGroupCollectionForDelete($obj, $postObj->GroupId);
                    }
                }
                if ($obj->CatagoryId == 2) {
                    $postObj = CurbsidePostCollection::model()->getPostById($obj->PostId);
                    if (isset($postObj->CategoryId)) {
                        CurbSideCategoryCollection::model()->updateCurbSideCategoryCollectionForDelete($obj, $postObj->CategoryId);
                    }

                    if ($postObj->IsFeatured == 1) {
                        NewsCollection::model()->updateNewsCollection($obj->PostId, $obj->CatagoryId, $obj->ActionType);
                    }
                }if ($obj->CatagoryId == 1) {
                    $postObj = PostCollection::model()->getPostById($obj->PostId);
                    if ($postObj->IsFeatured == 1) {
                        NewsCollection::model()->updateNewsCollection($obj->PostId, $obj->CatagoryId, $obj->ActionType);
                    }
                }
                if ($obj->CatagoryId == 9) {
                    $postObj = GameCollection::model()->getPostById($obj->PostId);
                    if ($postObj->IsFeatured == 1) {
                        NewsCollection::model()->updateNewsCollection($obj->PostId, $obj->CatagoryId, $obj->ActionType);
                    }
                }

                ResourceCollection::model()->updateResourceCollectionForDelete($obj);
                if (count($postObj->HashTags) > 0) {
                    foreach ($postObj->HashTags as $hashtag) {
                        HashTagCollection::model()->updateHashTagCollectionForDelete($obj, $hashtag);
                    }
                }
            }
            }
            /** Block End */
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:updatePostManagementActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function cancelSaveItForLater($obj) {
       try{
        $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), $obj->UserId);  
       if(sizeof($streamObj)>0 && $streamObj->IsSaveItForLater==1)
       {
           $promoteUserBean = new PostManagementActionBean();
                $promoteUserBean->PostId = $obj->PostId;
                $promoteUserBean->ActionType = 'SaveItForLaterCancel';
                $promoteUserBean->CatagoryId = $obj->CategoryType;
              
                $promoteUserBean->UserId = $obj->UserId;
                $promoteUserBean->PostType= $obj->PostType;
                $promoteUserBean->IsSaveItForLater =0;
            UserStreamCollection::model()->updatePostManagementActions($promoteUserBean);
       }
       } catch (Exception $ex) {
            Yii::log("AMQPCommand:cancelSaveItForLater::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function saveObjForSaveItForLater($obj)  {
        try{
                $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), $obj->UserId); 
                 if (sizeof($streamObj)==0) {
                       $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int)0); 
                       $streamObj->IsSaveItForLater=1;
                        $streamObj->UserId=(int)$obj->UserId;
                        $streamObj->_id=new MongoId();
                       $streamObj->saveItForLaterUserIds=array();
                        $streamObj->saveItForLaterUserIds = array((int) $obj->UserId);
                      
                       $streamObj->save();
                    }
               UserStreamCollection::model()->updatePostManagementActions($obj);
                $obj->IsSaveItForLater=1; 
                $streamObj->ActionType='SaveItForLater';
                $streamObj->StreamNote = 'has saved it for later ';
                
//              for later purpose not saving in activity collection for now
//                
//                $activityObj = UserActivityCollection::model()->getActvityObjbyPostId($streamObj->PostId, (int) $streamObj->UserId,$streamObj->CategoryType);
//                /* @var $activityObj type */
//              
//                if (isset($activityObj->UserId)) {
//                    UserActivityCollection::model()->updatePostActvityObject($streamObj, $activityObj->_id, (int) $streamObj->UserId, $obj->ActionType);
//                } else {
//
//                    UserActivityCollection::model()->saveUserActivityForPost($streamObj);
//                }
//                

           

                UserInteractionCollection::model()->saveObjForPostManagementActions($streamObj); 
               // $this->saveOrUpdateNotifications($streamObj);
                } catch (Exception $ex) {
            Yii::log("AMQPCommand:saveObjForSaveItForLater::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
             
    }
    public function savePostNotifications($obj, $notificationNote, $notificationNoteTwo, $recentActivity, $notificationObj, $follower) {
        try{
        $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($follower);
        if ($userSettings != "failure") {
            if ($userSettings->CurbsidePostFollowing == 1) {

                $notificationObj->UserId = $follower;
                $this->saveNotifications($obj, $notificationNote, $notificationNoteTwo, $recentActivity, $notificationObj, $userSettings->NetworkId);
            }
        }
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:savePostNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function saveNotificationsForActivityInvolvesYou($obj, $notificationNote, $notificationNoteTwo, $recentActivity, $notificationObj) {
        try{
        $UserIdList = UserInteractionCollection::model()->getDistinctUserIdListByPostId($obj->PostId, $obj->OriginalUserId, $obj->UserId);
        foreach ($UserIdList as $postUserId) {
            if ($obj->OriginalUserId != $postUserId && $obj->UserId != $postUserId) {
                $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($postUserId);
                if ($userSettings != "failure") {
                    if ($userSettings->ActivityInvolvesYou == 1) {
                        $notificationObj->UserId = $postUserId;
                        $this->saveNotifications($obj, $notificationNote, $notificationNoteTwo, $recentActivity, $notificationObj, $userSettings->NetworkId);
                    }
                }
            }
        }
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:saveNotificationsForActivityInvolvesYou::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }

    public function saveNotifications($obj, $notificationNote,$notificationNoteTwo, $recentActivity,$notificationObj,$networkId){

    try {            
        
                        $notificationObj->OriginalUserId=$obj->OriginalUserId;
                        $notificationObj->NotificationNote = $notificationNote;
                        $notificationObj->NotificationNoteTwo = $notificationNoteTwo;
                        $notificationObj->RecentActivity = $recentActivity;
                        $notificationObj->PostId = $obj->PostId;
                        $notificationObj->CategoryType = $obj->CategoryType;
                        $notificationObj->NetworkId = $networkId;
                        $notificationObj->isRead = 0;
                        $notificationObj->PostType = $obj->PostType;
                        $notificationObj->CreatedOn = $obj->CreatedOn;

                        $notificationObj->SegmentId = $obj->SegmentId;
                        $notificationObj->Language = $obj->Language;
            $isFollowing = 0;

                        $notificationObj->IsAnonymous=  isset($obj->IsAnonymous)?$obj->IsAnonymous:0;

                        if ($obj->CategoryType == 3) {
                            $groupDetails = GroupCollection::model()->getGroupDetailsById($obj->GroupId);
                            if (!is_string($groupDetails)) {
                                if (in_array($notificationObj->UserId, $groupDetails->GroupMembers)) {
                                    $userNotifications = Notifications::model()->getNotificationsForUserWithPost($notificationObj->UserId, $obj->PostId, $networkId, $obj->CategoryType, $recentActivity);
                                    if (isset($userNotifications->UserId)) {
                                        Notifications::model()->updateNotificationsForUser($userNotifications->_id, $obj->ActionType, $notificationObj);
                                    } else {
                                        Notifications::model()->saveNotifications($notificationObj);
                                    }
                                } else {
                                    if ($obj->ActionType == 'Comment') {
                                    $obj->FollowEntity = CommonUtility::getIndexBySystemFollowingThing('Post');
                                    }
                                    $this->saveFollowObjectForNotificationsFromGroupAndSubGroup($obj);
                                }
                            }
                        } else if ($obj->CategoryType == 7) {
                            $groupDetails = SubGroupCollection::model()->getSubGroupDetailsById($obj->SubGroupId);
                             
                            if (!is_string($groupDetails)) {
                                if (in_array($notificationObj->UserId, $groupDetails->SubGroupMembers)) {
                                    $userNotifications = Notifications::model()->getNotificationsForUserWithPost($notificationObj->UserId, $obj->PostId, $networkId, $obj->CategoryType, $recentActivity);
                                    if (isset($userNotifications->UserId)) {
                                        Notifications::model()->updateNotificationsForUser($userNotifications->_id, $obj->ActionType, $notificationObj);
                                    } else {
                                        Notifications::model()->saveNotifications($notificationObj);
                                    }
                                } else {
                                    if ($obj->ActionType == 'Comment') {
                                      $obj->FollowEntity = CommonUtility::getIndexBySystemFollowingThing('Post');  
                                    }
                                    $this->saveFollowObjectForNotificationsFromGroupAndSubGroup($obj);
                                }
                            }
                        } else {
                            $userNotifications = Notifications::model()->getNotificationsForUserWithPost($notificationObj->UserId, $obj->PostId, $networkId, $obj->CategoryType, $recentActivity);
                            if (isset($userNotifications->UserId)) {
                                Notifications::model()->updateNotificationsForUser($userNotifications->_id, $obj->ActionType, $notificationObj);
                            } else {
                                Notifications::model()->saveNotifications($notificationObj);
                            }
                        }
                    } catch (Exception $ex) {
                        echo '_________SAVE NOTIFICATION_____' .  $ex->getMessage();
                        Yii::log("AMQPCommand:saveNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                    }
}
    
    
    public  function saveOrUpdateNotifications($obj) {
        try {
            
            if ($obj->ActionType == 'Comment') {
                $notifiObj = new Notifications();
                $notifiObj->CommentUserId = $obj->UserId;
                $this->saveNotificationsForActivityInvolvesYou($obj, 'commented on','post','comment',$notifiObj);
                if ($obj->IsBlockedWordExist != 1) {
                    if ($obj->OriginalUserId != $obj->UserId) {
                        $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($obj->OriginalUserId);              
                        if ($userSettings != "failure") {
                            if ($userSettings->Commented == 1) {
                                $notificationObj = new Notifications();
                                $notificationObj->CommentUserId = $obj->UserId;
                                $notificationObj->UserId = $obj->OriginalUserId;
                                $this->saveNotifications($obj, 'commented on','post', 'comment',$notificationObj,$userSettings->NetworkId);

                            }
                        }
                    }
                }
            }
            if (isset($obj->ActionType) && $obj->ActionType == 'Love') {
                $notifiObj = new Notifications();
                $notifiObj->Love = $obj->LoveUserId;
                $this->saveNotificationsForActivityInvolvesYou($obj, 'loved','post', 'love',$notifiObj);

                if ($obj->OriginalUserId != $obj->LoveUserId) {
                    $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($obj->OriginalUserId);
                    if ($userSettings != "failure") {
                        if ($userSettings->Loved == 1) {
                            $notificationObj = new Notifications();
                            $notificationObj->Love = $obj->LoveUserId;
                            $notificationObj->UserId = $obj->OriginalUserId;
                            $this->saveNotifications($obj, 'loved','post', 'love',$notificationObj,$userSettings->NetworkId);
                        }
                    }
                }
            }
            if ($obj->ActionType == 'Follow' ) {
                
                $notifiObj = new Notifications();
                $notifiObj->PostFollowers = $obj->UserId;
                $this->saveNotificationsForActivityInvolvesYou($obj, 'following','post', 'follow',$notifiObj);
                if ($obj->OriginalUserId != $obj->UserId) {
                    $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($obj->OriginalUserId);

                    if ($userSettings != "failure") {
                        if ($userSettings->ActivityFollowed == 1) {
                            $notificationObj = new Notifications();
                            $notificationObj->PostFollowers = $obj->UserId;
                            $notificationObj->UserId = $obj->OriginalUserId;
                            $notificationObj->IsAnonymous=  isset($obj->IsAnonymous)?$obj->IsAnonymous:0;
                            $this->saveNotifications($obj, 'following','post', 'follow',$notificationObj,$userSettings->NetworkId);
//    
                        }
                    }
                }
            }
            if ($obj->ActionType == 'UserFollow') {
                $UserIdList = UserInteractionCollection::model()->getDistinctUserIdListByPostId($obj->PostId, $obj->OriginalUserId, $obj->UserId);
                foreach ($UserIdList as $postUserId) {
                    $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($postUserId);
                    if ($userSettings != "failure") {
                        if ($userSettings->ActivityInvolvesYou == 1) {
                            $notificationObj->UserId = $postUserId;
                            $this->saveUserFollowNotifications($obj, $userSettings->NetworkId,$postUserId);
                        }
                    }
                }
                $userSettings = UserNotificationSettingsCollection::model()->getUserSettings((int) $obj->UserFollowers);
                if ($userSettings != "failure") {
                    if ($userSettings->UserFollowers == 1) {
                        try {
                            $this->saveUserFollowNotifications($obj, $userSettings->NetworkId,$obj->UserFollowers);

                        } catch (Exception $ex) {
                            echo '________Exception__________' .  $ex->getMessage();
                            Yii::log("AMQPCommand:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            echo '_______Exception NOTification__________' .  $ex->getMessage();
            Yii::log("AMQPCommand:saveOrUpdateNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function saveUserFollowNotifications($obj, $NetworkId,$userId) {

        try {
            $notificationObj = new Notifications();
            $notificationObj->UserId = $userId;
            $notificationObj->NotificationNote = 'followed';
            $notificationObj->NotificationNoteTwo = 'you';
            $notificationObj->RecentActivity = 'UserFollow';
            $notificationObj->NewFollowers = $obj->UserId;
            $notificationObj->NetworkId = $NetworkId;
            $notificationObj->isRead = 0;
            $notificationObj->PostType = $obj->PostType;
            $notificationObj->CreatedOn = $obj->CreatedOn;
            $notificationObj->IsAnonymous=  isset($obj->IsAnonymous)?$obj->IsAnonymous:0;
            $userNotifications = Notifications::model()->getUserNotificationForFollower((int) $userId, 'UserFollow');
            if (isset($userNotifications->UserId)) {
                Notifications::model()->updateNotificationsForUser($userNotifications->_id, $obj->ActionType, $notificationObj);
            } else {
                Notifications::model()->saveNotifications($notificationObj);
            }
        } catch (Exception $ex) {
            echo '_________ UserFollowNotifications_______' .  $ex->getMessage();
            Yii::log("AMQPCommand:saveUserFollowNotifications::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    /**
     * @author suresh reddy
     * @Description Updating Post management actions
     * @param type $obj
     */
     function updateIsEngage($userId, $postId) {
        try {
            FollowObjectStream::model()->updateIsEngage($userId, $postId);
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:updateIsEngage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar Pathapelli
     * @Description Updating Comment management actions
     * @param type $obj
     */
    public  function updateCommentManagementActions($obj) {
        try {
            UserStreamCollection::model()->updateCommentManagementActions($obj);
            UserActivityCollection::model()->updateCommentManagementActions($obj);
            UserInteractionCollection::model()->updateCommentManagementActions($obj);
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:updateCommentManagementActions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public  function modifyDate() {
        //  $criteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
//         $criteria = new EMongoCriteria;  
//          $modifier = new EMongoModifier;
//          $criteria->UserId = (int)1;
//        $criteria->addCond('pageIndex','in',array((int)9));
//         $allposts = UserInteractionCollection::model()->findAll($criteria);  
//        // $criteria = new EMongoCriteria;  
//         foreach ($allposts as $value) {
//             $modifier->addModifier('CreatedOn', 'set', new MongoDate(time()));
//         $modifier->addModifier('CreatedDate', 'set', date('Y-m-d', time()));
//        $criteria->addCond('_id', '==', $value['_id']);
//         $value->updateAll($modifier,$criteria);  
//         }
    }

    public  function modifyGroupCollectionDate() {
    try{
        //  $criteria->CreatedOn = array('$gt' => new MongoDate(strtotime($startDate)),'$lt' => new MongoDate(strtotime($endDate)));
        $criteria = new EMongoCriteria;
        $modifier = new EMongoModifier;
        //$criteria->UserId = (int)1;
        // $criteria->addCond('pageIndex','in',array((int)9));
        $allposts = GroupPostCollection::model()->findAll($criteria);
        // $criteria = new EMongoCriteria;  
        foreach ($allposts as $value) {
            // $modifier->addModifier('CreatedOn', 'set', new MongoDate(time()));
            $modifier->addModifier('CreatedDate', 'set', date('Y-m-d', $value['CreatedOn']->sec));
            $criteria->addCond('_id', '==', $value['_id']);
            $value->updateAll($modifier, $criteria);
        }
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:modifyGroupCollectionDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Vamsi Krishna
     * Description : this method is used to save the Follow object Stream 
     * if the user posted or performaed any activity and unfollowed the Group or SubGroup
     * Then we do not send them the notifications but we will show them a derivative object 
     * 
     * @param type $obj
     */
    public  function saveFollowObjectForNotificationsFromGroupAndSubGroup($obj) {
        try {

            $streamObj = FollowObjectStream::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int) $obj->OriginalUserId, (int) $obj->FollowEntity);

            if (isset($streamObj->UserId)) {
                $obj->Priority = $streamObj->Priority;
                FollowObjectStream::model()->updateStreamObject($obj, $streamObj->_id, $obj->OriginalUserId, $obj->ActionType);
            } else {
                $obj->StreamUserId = $obj->OriginalUserId;
                $obj->Priority = (int) 1;
                FollowObjectStream::model()->saveFollowObjectStream($obj);
            }
        } catch (Exception $ex) {
            echo "EXCEPTION saveFollowObjectForNotificationsFromGroupAndSubGroup " .  $ex->getMessage(); 
            Yii::log("AMQPCommand:saveFollowObjectForNotificationsFromGroupAndSubGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public  function upateNewsToNotifyInStream($obj) {
        try {
            UserStreamCollection::model()->updatePostManagementActions($obj);
            FollowObjectStream::model()->updatePostManagementActions($obj);
            UserActivityCollection::model()->updatePostManagementActions($obj);
            UserInteractionCollection::model()->updatePostManagementActions($obj);
        } catch (Exception $ex) {
            echo "EXCEPTION upateNewsToNotifyInStream " .  $ex->getMessage(); 
            Yii::log("AMQPCommand:upateNewsToNotifyInStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public  function groupAutoFollow($obj) {
        try {
            $groupdetail= GroupCollection::model()->getGroupDetailsById($obj->GroupId);
              $users = UserCollection::model()->getSelectedUsersIds($groupdetail->GroupMembers);
            if (!is_string($users)) {
                /**
                 * change logic for auto follow group. we have some flaw for group follow of user. -Reddy
                 */
                foreach ($users as $user) {
//                    $returnValue = GroupCollection::model()->followOrUnfollowGroup($obj->GroupId, $user->UserId, "Follow");
//                  //  $returnValue = UserProfileCollection::model()->followOrUnfollowGroup($obj->GroupId, $user->UserId, "Follow");
                     $skiptapostService = new SkiptaPostService;
                     $skiptapostService->saveFollowOrUnfollowToGroup($obj->GroupId, $user->UserId, "Follow");
                }
            }
        } catch (Exception $ex) {
            echo "EXCEPTION GROUP Auoto follow " .  $ex->getMessage(); 
            Yii::log("AMQPCommand:groupAutoFollow::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Suresh 
     * @usage  game suspend, and previous game scheduleid, previous  players count need to update
     * 
     */
    public  function suspendOrReleaseGame($obj) {
        try {
            $returnValue = UserStreamCollection::model()->suspendorReleaseGame($obj);
            $returnValue = FollowObjectStream::model()->suspendorReleaseGame($obj);
            $returnValue = UserActivityCollection::model()->suspendorReleaseGame($obj);

            NewsCollection::model()->updateNewsCollection($obj->PostId, $obj->CategoryType, $obj->ActionType);
        } catch (Exception $ex) {
            echo "exception suspendOrReleaseGame" .  $ex->getMessage();
            Yii::log("AMQPCommand:suspendOrReleaseGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author M Vamsi KRishna
     * @usage  This game is used whemn the game is scheduled
     * 
     */
    public  function ScheduleGame($obj) {
        try {
            if ($obj->RecentActivity == 'streamTotalUpdate') {
                $returnValue = UserStreamCollection::model()->updateStreamForGameSchedule($obj);
                $returnValue = FollowObjectStream::model()->updateStreamForGameSchedule($obj);
                $returnValue = UserActivityCollection::model()->updateStreamForGameSchedule($obj);
            } else if ($obj->RecentActivity == 'streamPartialUpdate') {
                $returnValue = UserStreamCollection::model()->updatePartialUserStreamForGame($obj);
                $returnValue = FollowObjectStream::model()->updatePartialUserStreamForGame($obj);
                $returnValue = UserActivityCollection::model()->updatePartialUserStreamForGame($obj);
            }
        } catch (Exception $ex) {
            echo "exception ScheduleGame" .  $ex->getMessage();
            Yii::log("AMQPCommand:ScheduleGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author M Vamsi Krishna
     * @usage  This method is used to save the groupmembers based on their speciality
     * 
     */
    public function GroupFollowForSpeciality($obj){
        try {
            if(count($obj->GroupSpecialities)>0 ){
                            $subSpeValueArray=SubSpecialty::model()->getSubSpecialityValuesById($obj->GroupSpecialities);
                            if(is_array($subSpeValueArray)){
                                $speValue=array();
                                foreach($subSpeValueArray as $speV){
                                    array_push($speValue,$speV['Value']);
                                }
                                $MappingCustomField=Yii::app()->params['GroupMappingField'];
                                if(isset($MappingCustomField)){
                                     $userIds=CustomField::model()->getUserCustomFieldMappingUsers($speValue,$MappingCustomField);
                                if(count($userIds)>0){
                                    foreach($userIds as $userId){
                                          GroupCollection::model()->followOrUnfollowGroup($obj->GroupId, $userId, "Follow");
                                          UserProfileCollection::model()->followOrUnfollowGroup($obj->GroupId, $userId, "Follow");
                                    } 
                                }
                              
                    
                                    
//                                   $groupDetails=GroupCollection::model()->getGroupDetailsById($obj->GroupId);
//                                if(is_array($groupDetails)){
//                                  $groupMembers=$groupDetails->GroupMembers;
//                                  $userIdsAfterDiff=array_diff($userIds,$groupMembers);
//                                  if(count($userIdsAfterDiff)>0){
//                                      
//                                  }
//                                 }    
                                }
                                
                                
                            }
                        
                        }
        } catch (Exception $ex) {
            echo  $ex->getMessage();
            Yii::log("AMQPCommand:GroupFollowForSpeciality::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
    

    
    public function updateDataForGroupActiveAndInactive($obj){
        try {
            if($obj->ActionType=='GroupInactive'){
                UserProfileCollection::model()->updateUsersForGroupInactive($obj->GroupId);
                HashTagCollection::model()->updateHashTagCollectionForGroupActive($obj);
            }else{                 
                 UserProfileCollection::model()->updateUsersForGroupActive($obj->GroupId); 
                 $this->updateGroupActiveForHashtags($obj);
            }            
            UserStreamCollection::model()->updateStreamForGroupInactiveAndActive($obj);
            UserInteractionCollection::model()->updateStreamForGroupInactiveAndActive($obj);           
            UserActivityCollection::model()->updateStreamForGroupInactiveAndActive($obj);
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:updateDataForGroupActiveAndInactive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        public function updateDataForSubGroupActiveAndInactive($obj){
        try {
            if($obj->ActionType=='SubGroupInactive'){
                UserProfileCollection::model()->updateUsersForSubGroupInactive($obj->SubGroupId);                
            }else{
                 UserProfileCollection::model()->updateUsersForGroupActive($obj->SubGroupId); 
            }            
            UserStreamCollection::model()->updateStreamForGroupInactiveAndActive($obj);
            UserInteractionCollection::model()->updateStreamForGroupInactiveAndActive($obj);           
            UserActivityCollection::model()->updateStreamForGroupInactiveAndActive($obj);
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:updateDataForSubGroupActiveAndInactive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
      public function updateGroupActiveForHashtags($obj){
          try {
              $groupDetails=  GroupPostCollection::model()->getPostsByGroupId($obj->GroupId);
              if(is_object($groupDetails) || is_array($groupDetails)){
                  if(count($groupDetails)>0){
                      foreach($groupDetails as $group){
                          if(count($group->HashTags)>0){
                              foreach($group->HashTags as $hashTag)
                              HashTagCollection::model()->updatePostsForHashTags($hashTag,$group->_id);
                          }
                      }
                  }
              }
          } catch (Exception $ex) {
              echo  $ex->getMessage();
              Yii::log("AMQPCommand:updateGroupActiveForHashtags::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          }
      
      }  
public  function updateUseForDigest($obj) {
        try {
            UserStreamCollection::model()->updateUseForDigest($obj);
        } catch (Exception $ex) {
            Yii::log("AMQPCommand:updateUseForDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          }
    }
    
  public function saveFollowObjectStreamForExtendeSurveyFollowers($obj){
      try {        
           $followerUsers = ServiceFactory::getSkiptaPostServiceInstance()->getFollowersOfUser($obj->UserId);
        
                    for ($i = 0; $i < sizeof($followerUsers); $i++) {
                        $obj->StreamUserId = (int) $followerUsers[$i];
                        $obj->SurveyTaken = (int) $obj->UserId;
                        $obj->StreamNote = CommonUtility::actionTextbyActionType("ExtendedSurveyFinished"); 
                        $obj->CreatedOn  = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                        
                        if ((int) $obj->UserId != $followerUsers[$i]) {                           

                                $streamObj = FollowObjectStream::model()->getStreamObjbyPostId(new MongoId($obj->PostId), (int) $followerUsers[$i], (int) $obj->FollowEntity);
                                if (isset($streamObj->UserId)) {
                                    FollowObjectStream::model()->updateStreamObject($obj, $streamObj->_id, $streamObj->UserId, $obj->RecentActivity);
                                } else {

                                    FollowObjectStream::model()->saveFollowObjectStream($obj);
                                }
                            
                        }
                    }
      } catch (Exception $ex) {
          Yii::log("AMQPCommand:saveFollowObjectStreamForExtendeSurveyFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }  

    public function sendPictocvRequest($userAchievementsObj) {
        try {
            $userId = (int)$userAchievementsObj->UserId;
            $userClassification = (int)$userAchievementsObj->UserClassification;
            
            if($userClassification==1){
                $userAchievements = UserAchievementsCollection::model()->getUserAchievements($userId, $userClassification);
                if(sizeof($userAchievements)>0)
                {
                   $userAchievements = (array)$userAchievements;
                   $userAchievements["UserId"] = (int)$userId;
                   $userAchievements["UserClassification"] = (int)$userClassification;
                   $userAchievements["SegmentId"] = (int)$userAchievements["SegmentId"];
                   $userAchievements["NetworkId"] = (int)$userAchievements["NetworkId"];
                   $opportunitiesObj = OpportunitiesCollection::model()->getOpportunitiesByUserClassification($userClassification);
                   
                   for($i=0;$i<sizeof($userAchievements["Opportunities"]); $i++){
                       $opportunityType = $userAchievements["Opportunities"][$i]["OpportunityType"];
                       
                       //if($userAchievementsObj->OpportunityType==$opportunityType){
                            $userAchievements["Opportunities"][$i]["ImageUrl"] = "";
                            $userAchievements["Opportunities"][$i]["OpportunityGoal"] = (int)$userAchievements["Opportunities"][$i]["OpportunityGoal"];
                            $userAchievements["Opportunities"][$i]["PictureType"] = $userAchievements["Opportunities"][$i]["PictureType"][0];
                            for($j=0;$j<sizeof($userAchievements["Opportunities"][$i]["EngagementDrivers"]); $j++){
                                $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Achieved"] = (float)$userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Achieved"];
                                if($opportunityType=="Profile"){
                                    $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"] = (int)$userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"];
                                }else if($opportunityType=="Follow"){
                                    if($userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Type"] == "Follow_Posts"){
                                        $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"] = $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"];
                                    }else {
                                        $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"] = (int)$userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"];
                                    }
                                }else if($opportunityType=="Career"){
                                    $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"] = (int)$userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"];
                                }else if($opportunityType=="Search"){
                                    $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"] = $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"];
                                }else if($opportunityType=="News"){
                                    $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"] = $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Available"];
                                }

                                /************************Need to add from Opportunities Collection*********************/
                                $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Goal"] = (int)$opportunitiesObj->Opportunities[$i]["EngagementDrivers"][$j]["Goal"];
                                $userAchievements["Opportunities"][$i]["EngagementDrivers"][$j]["Weight"] = (int)$opportunitiesObj->Opportunities[$i]["EngagementDrivers"][$j]["Weight"];
                                /************************Need to add from Opportunities Collection***********end**********/
                            }
//                            $userOpp = $userAchievements["Opportunities"][$i];
//                            $userAchievements["Opportunities"] = array();
//                            $userAchievements["Opportunities"][0] = $userOpp;
//                            break;
                       //}
                       
                   }
                   $pictocvObject = (object)$userAchievements;
                   //error_log("==============".print_r($userAchievements, true));
                   $requestId = PictocvCollection::model()->savePictoCVObject($pictocvObject);
                   if($requestId!="failure"){
                        $pictocvRequestObject = $this->preparePictocvRequestObject($requestId, $userAchievements);
                        $this->sendRequestToPictoCV($pictocvRequestObject);
                   }
               }
            }
        } catch (Exception $exc) {
            Yii::log("=====AMQPCommand/sendPictocvRequest=====".$exc->getMessage(), 'error', 'application');
        }
    }
    public function preparePictocvRequestObject($requestId, $userAchievements){
         try{
             
             $pictocvRequestObject = new PictocvRequestBean();
             $pictocvRequestObject->RequestId = $requestId;
             $pictocvRequestObject->ResponseUrl = Yii::app()->params['PictocvResponseUrl'];
             $pictocvRequestObject->CommunityId = Yii::app()->params['NetWorkId'];
             $pictocvRequestObject->Opportunities = array();
             
             foreach($userAchievements["Opportunities"] as $oppertunity){
                 $oppertunityObj = new OpportunityBean();
                 $oppertunityObj->OpportunityType = $oppertunity["OpportunityType"];
                 $oppertunityObj->OpportunityGoal = (int)$oppertunity["OpportunityGoal"];
                 $pictureType=$oppertunity["PictureType"];
                 //$oppertunityObj->PictureType = $pictureType[array_rand($pictureType,1)];
                 $oppertunityObj->PictureType = $pictureType;
                 $oppertunityObj->EngagementDrivers = array();
                 $oppertunityObj->Available = "";
                 $isAvailableEmpty="";
                 $availableCount = 0;
                 $isAvailableZero = 1;
                 foreach($oppertunity["EngagementDrivers"] as $engagementDriver){
                    // if($engagementDriver["Available"]!=0){
                        $engagementDriverBean = new EngagementDriverBean();
                        $engagementDriverBean->Achieved = $engagementDriver["Achieved"];
                        $engagementDriverBean->Available = $engagementDriver["Available"];
                        $engagementDriverBean->Goal = $engagementDriver["Goal"];
                        $engagementDriverBean->Type = Yii::t('pictocv', $engagementDriver["Type"]);
                        $engagementDriverBean->Weight = $engagementDriver["Weight"];
                        array_push($oppertunityObj->EngagementDrivers, $engagementDriverBean);
                        if($engagementDriver["Available"]==""){
                            $isAvailableEmpty="empty";
                            $availableCount = "";
                        }else if($isAvailableEmpty!="empty"){
                            $availableCount = $availableCount+$engagementDriver["Available"];
                        }
//                     }else{
//                         $isAvailableZero = 0;
//                     }
                 }
                 if($isAvailableEmpty!="empty"){
                     $oppertunityObj->Available = $availableCount;
                 }
                 if($isAvailableZero!=0){
                    array_push($pictocvRequestObject->Opportunities, $oppertunityObj);
                 }
             }
             return $pictocvRequestObject;
       }catch(Exception $exc){
             Yii::log("=====AMQPCommand/preparePictocvRequestObject=====".$exc->getMessage(), 'error', 'application');
       }
    }
    public function sendRequestToPictoCV($pictocvObject){
         try{
            $pictocvUrl = Yii::app()->params['PictocvRequestUrl'];
            
            $data = (array)$pictocvObject;
            $test = array();
            array_push($test, $data);
            $data = json_encode($test);
            echo "PICTO CV REQUEST **********************".$data;
            
            $ch = curl_init($pictocvUrl);            
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            # Return response instead of printing.
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            # Send request.
            $result = curl_exec($ch);
            echo $result;
            curl_close($ch);
            $responseObj = json_decode($result);
            if(isset($responseObj->RequestId) && isset($responseObj->Status)){
                PictocvCollection::model()->updatePictoCVStatusByRequestId($responseObj->RequestId,$responseObj->Status);
            }
       }catch(Exception $exc){
             Yii::log("=====AMQPCommand/sendRequestToPictoCV=====".$exc->getMessage(), 'error', 'application');
       }
    }
}
