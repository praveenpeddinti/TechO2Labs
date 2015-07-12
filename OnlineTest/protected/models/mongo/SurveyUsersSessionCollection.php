<?php

/** This is the collection for saving Chat Conversations

 */

class SurveyUsersSessionCollection extends EMongoDocument {
    public $UserId;
    public $SurveyId; 
    public $ScheduleId; 
    public $UserAnswers; 
    public $Status;
    public $Page;
    public $LastUpdateDate;
    public $CreatedDate;
    
   
   

    public function getCollectionName() {
        return 'SurveyUsersSessionCollection';
    }
    public function indexes() {
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC,
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
             'UserId' => 'UserId',
             'SurveyId' => 'SurveyId',
            'ScheduleId' => 'ScheduleId',
            'UserAnswers' => 'UserAnswers',
             'Status' => 'Status',
             'Page' => 'Page',
             'CreatedDate' => 'CreatedDate',
             'LastUpdateDate' => 'LastUpdateDate'
           
           
            
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function manageSurveyUserSession($surveyId,$userId,$obj) {
    try{
                error_log("Exception Occurred in SurveyUsersSessionCollection->manageSurveyUserSession==");

        $returnValue = 'false';
            $criteria = new EMongoCriteria;
            $criteria->addCond('UserId', '==',(int)$userId);
            $criteria->addCond('ScheduleId', '==',new MongoId($obj->_id));
             $criteria->addCond('SurveyId', '==',new MongoId($surveyId));
            $surveySessionObj = SurveyUsersSessionCollection::model()->find($criteria);
             if (is_object($surveySessionObj) ) {
                      
             $criteria = new EMongoCriteria;
             $criteria->addCond('UserId', '==',(int)$userId);
             $criteria->addCond('ScheduleId', '==',new MongoId($obj->_id));
             $criteria->addCond('SurveyId', '==',new MongoId($surveyId));
              $modifier = new EMongoModifier();
              $modifier->addModifier('Status', 'set',(int)1);
               $modifier->addModifier('LastUpdateDate', 'set',new MongoDate());
            $surveySessionObj = SurveyUsersSessionCollection::model()->updateAll($modifier,$criteria);
             }else{
               return $this->saveSurveyUserSession($surveyId,$userId,$obj);   
             }
             
             
    }catch(Exception $ex){
        Yii::log("SurveyUsersSessionCollection:manageSurveyUserSession::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        error_log("Exception Occurred in SurveyUsersSessionCollection->manageSurveyUserSession==".$ex->getMessage());
    }
         return $returnValue;
    }
    public function checkSpotExist($surveyId,$userId,$obj) {
       try{
        if($obj->MaxSpots>0){
           $criteria = new EMongoCriteria;
            $criteria->addCond('ScheduleId', '==',new MongoId($obj->_id));
             $criteria->LastUpdateDate = array('$gte' =>new MongoDate(strtotime('2 hours ago')),'$lte' => new MongoDate());
              $criteria->addCond('Status', '==',(int)1);
            $spots = SurveyUsersSessionCollection::model()->findAll($criteria);
            $surveyTakenUsers = ScheduleSurveyCollection::model()->getSurveyTakenUsers($obj->_id);
          
            if(($surveyTakenUsers+sizeof($spots))< $obj->MaxSpots){
                return true;
            }  else {
                return false;
            }
        }else{
          return true;  
        }
        } catch (Exception $ex) {
                Yii::log("SurveyUsersSessionCollection:checkSpotExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
            
    }
    public function saveSurveyUserSession($surveyId,$userId,$obj){
        try{
//        if($this->checkSpotExist($surveyId,$userId,$obj)){
            $surveyUsersSessionCollection = new SurveyUsersSessionCollection();
          //  $offlineChatCollection->roomName=$roomName;
            $surveyUsersSessionCollection->UserId = (int)$userId;
             $surveyUsersSessionCollection->ScheduleId = new MongoId($obj->_id);
            $surveyUsersSessionCollection->SurveyId = new MongoId($surveyId);
            $surveyUsersSessionCollection->UserAnswers = array();
            $surveyUsersSessionCollection->Page = (int)1;
            $surveyUsersSessionCollection->CreatedDate = new MongoDate();
            $surveyUsersSessionCollection->LastUpdateDate = $surveyUsersSessionCollection->CreatedDate;
          
          $surveyUsersSessionCollection->Status = (int)1;
            $surveyUsersSessionCollection->insert();
              if (isset($surveyUsersSessionCollection->_id)) {
                 return "success";
            }
           
//           }else{
//                 return "nospots";
//          }
        } catch (Exception $ex) {
                Yii::log("SurveyUsersSessionCollection:saveSurveyUserSession::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
        
        
    }
      public function unsetSpotForUser($userId,$scheduleId,$flag=""){
          try{
             
            $criteria = new EMongoCriteria;
             $criteria->addCond('UserId', '==',(int)$userId);
              $criteria->addCond('ScheduleId', '==',new MongoId($scheduleId));
            // $criteria->addCond('Status', '==',(int)0);
           //  $criteria->addCond('ScheduleId', '==',new MongoId($obj->_id));
           //  $criteria->addCond('SurveyId', '==',new MongoId($surveyId));
              
             
            if($flag == "Done"){
                
            $surveySessionObj = SurveyUsersSessionCollection::model()->deleteAll($criteria); 
            }else{
            $modifier = new EMongoModifier();
            $modifier->addModifier('Status', 'set',(int)0);
            $modifier->addModifier('LastUpdateDate', 'set',new MongoDate());
            $surveySessionObj = SurveyUsersSessionCollection::model()->updateAll($modifier, $criteria); 
            }
             
            
          } catch (Exception $ex) {
              Yii::log("SurveyUsersSessionCollection:unsetSpotForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
              error_log("Exception Occurred in SurveyUsersSessionCollection->unsetSpotForUser==".$ex->getMessage());
          }
      }
       
    public function updateSurveyAnswer2($model,$NetworkId,$UserId,$flag="",$fromAutoSave,$fromPage,$qTempId){
        try{        
          
            $returnValue = "failed";
            $scheduleObj = new SurveyUsersSessionCollection();
            $scheduleObj->UserAnswers = $model->UserAnswers;     
            if($fromAutoSave == 0){
                 $criteria = new EMongoCriteria();
               error_log("===@@@@@@@@@@@@@@@=======scheduleId====$model->ScheduleId===Userid=$UserId");
                $criteria->addCond('ScheduleId', '==', new MongoId($model->ScheduleId)); 
                $criteria->addCond('UserId', '==', (int)$UserId);
                $obj = SurveyUsersSessionCollection::model()->find($criteria);
                error_log("=1111111111111!!!!!!11=obj page==$obj->Page==from page=====$fromPage======");
                if(isset($obj)){
                   if($obj->Page < $fromPage){
                        $modifier = new EMongoModifier();
                        $modifier->addModifier('Page', 'set',(int)$fromPage );
                        $obj = SurveyUsersSessionCollection::model()->updateAll($modifier,$criteria);
                    } 
                }
                
            }
            //error_log("=1111111111111!!!!!!11=obj page==$obj->Page==from page=====$fromPage======");
            foreach ($scheduleObj->UserAnswers as $answers) {
                error_log("@@@@@@@@@@@@@@@@@@@@111@@@@@asdfasdfasdf@@@@sdf");
                $answers->UniqueId = new MongoId();
                $criteria = new EMongoCriteria();
               
                $criteria->addCond('ScheduleId', '==', new MongoId($model->ScheduleId)); 
                $criteria->addCond('UserId', '==', (int)$UserId);
                $criteria->addCond('UserAnswers.QuestionId', '==', new MongoId($answers->QuestionId));
                $obj = SurveyUsersSessionCollection::model()->find($criteria);
                
                $c = SurveyUsersSessionCollection::model()->getCollection();
                $result = $c->aggregate(array('$match' => array('ScheduleId' =>new MongoId($model->ScheduleId))), array('$unwind' => '$UserAnswers'), array('$match' => array('UserId' => (int)$UserId)), array('$match' => array('UserAnswers.QuestionId' => new MongoID($answers->QuestionId))), array('$group' => array("_id" => "_id", "QuestionIds" => array('$push' => '$UserAnswers.QuestionId')))); 
                //error_log("=========result=====2222222222222222===".print_r($result,1));
                
                  if(sizeof($result['result'])>0){
                   error_log("====@@@@@@@@@@@@@========collection object exist=========@@@@@@@@@@@@@@@@@===questionid===$answers->QuestionId");
                      $criteria = new EMongoCriteria();
                      $modifier = new EMongoModifier();
                     
                      $criteria->addCond('ScheduleId', '==', new MongoId($model->ScheduleId)); 
                      $criteria->addCond('UserId', '==', (int)$UserId);
                      $criteria->addCond('UserAnswers.QuestionId', '==', new MongoId($answers->QuestionId));
                      $modifier = new EMongoModifier();
                      // $modifier1 = new EMongoModifier();
                      $modifier->addModifier('UserAnswers.$.Other', 'set',$answers->Other );
                    //  $modifier1->addModifier('UserAnswers.$.Other', 'set',$answers->Other );
                       $modifier->addModifier('UserAnswers.$.OtherValue', 'set',$answers->OtherValue );
                       $modifier->addModifier('UserAnswers.$.Score', 'set',$answers->Score );
                       $modifier->addModifier('UserAnswers.$.IsReviewed', 'set',$answers->IsReviewed );
                       
                      //   $modifier1->addModifier('UserAnswers.$.OtherValue', 'set',$answers->OtherValue );
                         if($answers->QuestionType == 2 ){
                             $modifier->addModifier('UserAnswers.$.SelectAll', 'set',$answers->SelectAll );
                         }
                       if($answers->QuestionType == 3 || $answers->QuestionType == 4 ){
                            $modifier->addModifier('UserAnswers.$.Options', 'set',$answers->Options );
                             $modifier->addModifier('UserAnswers.$.OptionCommnets', 'set',$answers->OptionCommnets );
                              $modifier->addModifier('UserAnswers.$.OptionOtherTextValue', 'set',$answers->OptionOtherTextValue );
                              
                             //  $modifier1->addModifier('UserAnswers.$.Options', 'set',$answers->Options );
                             //$modifier1->addModifier('UserAnswers.$.OptionCommnets', 'set',$answers->OptionCommnets );
                             // $modifier1->addModifier('UserAnswers.$.OptionOtherTextValue', 'set',$answers->OptionOtherTextValue );
                       }else if($answers->QuestionType == 5){
                           $modifier->addModifier('UserAnswers.$.DistributionValues', 'set',$answers->DistributionValues );  
                          // $modifier1->addModifier('UserAnswers.$.DistributionValues', 'set',$answers->DistributionValues ); 
                       }
                       else if($answers->QuestionType == 6){
                           $modifier->addModifier('UserAnswers.$.UserAnswer', 'set',$answers->UserAnswer );  
                             // $modifier1->addModifier('UserAnswers.$.UserAnswer', 'set',$answers->UserAnswer );
                       }
                       else if($answers->QuestionType == 7){
                           $modifier->addModifier('UserAnswers.$.UsergeneratedRankingOptions', 'set',$answers->UsergeneratedRankingOptions );  
                           //$modifier1->addModifier('UserAnswers.$.UsergeneratedRankingOptions', 'set',$answers->UsergeneratedRankingOptions );  
                       }
                       
                       else{
                            $modifier->addModifier('UserAnswers.$.SelectedOption', 'set',$answers->SelectedOption );
                            // $modifier1->addModifier('UserAnswers.$.SelectedOption', 'set',$answers->SelectedOption );
                       }
                      $modifier->addModifier('LastUpdateDate', 'set', new MongoDate());
                      $obj = SurveyUsersSessionCollection::model()->updateAll($modifier,$criteria);
//                      $criteria = new EMongoCriteria();
//                       $criteria->addCond('_id', '==', new MongoId($model->ScheduleId));
//                        $criteria->addCond('UserAnswers.UserId', '==', (int)$UserId);
//                      $criteria->addCond('UserAnswers.QuestionId', '==', new MongoId($answers->QuestionId));
//                       ScheduleSurveyCollection::model()->updateAll($modifier1, $criteria);    
                      
                  }else{
                      $criteria = new EMongoCriteria();
                     $modifier = new EMongoModifier();
                     $criteria->addCond('UserId', '==',(int)$UserId);
                     $criteria->addCond('ScheduleId', '==',new MongoId($model->ScheduleId));
                    $modifier->addModifier('LastUpdateDate', 'set', new MongoDate());
                     $modifier->addModifier('UserAnswers', 'pushAll', array($answers));
                     if(SurveyUsersSessionCollection::model()->updateAll($modifier, $criteria)){
                                      $returnValue = "success";
                     }
                     
                  }
            
            }
                    if($flag == "Done"){
                        $criteria = new EMongoCriteria;
                        $criteria->addCond("_id","==",new MongoId($qTempId));
                        $userQuestionObj = UserQuestionsCollection::model()->find($criteria);
                        if(isset($userQuestionObj)){
                            $criteria = new EMongoCriteria;
                            $criteria->addCond("_id","==", new MongoId($userQuestionObj->Testid));
                            $testPrepareObj = TestPreparationCollection::model()->find($criteria);
                            $modifier = new EMongoModifier;
                            $modifier->addModifier("TestTakenUsers", "push", (int)$UserId);
                            $modifier->addModifier("TestTakenUsersCount", "inc", (int)1);
                            if($testPrepareObj->updateAll($modifier, $criteria)){
                                ;
                            }
                        }
                        
                        $co = UserQuestionsCollection::model()->getCollection();                        
                        $result = $co->aggregate(array('$match' => array('_id' =>new MongoId($qTempId))), array('$unwind' => '$Questions'),array('$group' => array("_id" => "_id", "ScheduleIds" => array('$push' => '$Questions.ScheduleId')))); 
                        $scheduleIdArray = $result['result'][0]['ScheduleIds'];                         
                        foreach($scheduleIdArray as $rr){
                            $sscheduleId = (string)$rr;
                            $criteria = new EMongoCriteria();
                                $modifier = new EMongoModifier();
                                $criteria->addCond('ScheduleId', '==', new MongoId($sscheduleId)); 
                                $criteria->addCond('UserId', '==', (int)$UserId);
                                $obj = SurveyUsersSessionCollection::model()->find($criteria);
                                error_log("data----".print_r($obj->UserAnswers,1));
                                $criteria = new EMongoCriteria();
                                $modifier = new EMongoModifier();
                                $criteria->addCond('_id', '==', new MongoId($sscheduleId));
                                $scheduleSurveyObj = ScheduleSurveyCollection::model()->find($criteria);
                                $resumeUsers = $scheduleSurveyObj->ResumeUsers;
                                $SurveyTakenUsers = "";
                               $modifier->addModifier('SurveyTakenUsers', 'push', (int)$UserId);
                                $modifier->addModifier('ResumeUsers', 'pull',(int)$UserId);
                                 $modifier->addModifier('UserAnswers', 'pushAll', $obj->UserAnswers);
                                if(ScheduleSurveyCollection::model()->updateAll($modifier, $criteria)){
                                     SurveyUsersSessionCollection::model()->unsetSpotForUser($UserId,$sscheduleId,"Done");
                                    $returnValue = $scheduleSurveyObj;
                               }
                        }
                         
                }
      
                return $returnValue;
          
        } catch (Exception $ex) {
            Yii::log("SurveyUsersSessionCollection:updateSurveyAnswer::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SurveyUsersSessionCollection->updateSurveyAnswer==".$ex->getMessage());
        }
    }
   
    public function getAnswersForSurvey($userId,$scheduleId){
        try{
            error_log("===UserId===$userId===scheduleId-===$scheduleId=");
         $criteria = new EMongoCriteria();
          $criteria->addCond('ScheduleId', '==', new MongoId($scheduleId)); 
           $criteria->addCond('UserId', '==', (int)$userId); 
         $obj = SurveyUsersSessionCollection::model()->find($criteria);
          //error_log("===UserId===$userId===scheduleId-===$scheduleId=");
         if(is_object($obj)){
           
             return  $obj->UserAnswers;
         }else{
           
             return array();
         }
         } catch (Exception $ex) {
                Yii::log("SurveyUsersSessionCollection:getAnswersForSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
         
    }
    public function getSpotsAvailabeForScheduledSurvey($obj,$surveyId){
        try{
          $criteria = new EMongoCriteria();
          $criteria->addCond('ScheduleId', '==', new MongoId($obj->_id)); 
           $criteria->LastUpdateDate = array('$gte' =>new MongoDate(strtotime('2 hours ago')),'$lte' => new MongoDate());
            $criteria->addCond('Status', '==', (int)1); 
          $result = SurveyUsersSessionCollection::model()->findAll($criteria);  
          $surveyTakenUsers = ScheduleSurveyCollection::model()->getSurveyTakenUsers($obj->_id);
          //get survey taken uses
         
          $spotsCount = $obj->MaxSpots -(sizeof($result)+$surveyTakenUsers);
          
          if($spotsCount>=0){
             return $spotsCount; 
          }else{
             return 0; 
          }
          
        } catch (Exception $ex) {
            Yii::log("SurveyUsersSessionCollection:getSpotsAvailabeForScheduledSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SurveyUsersSessionCollection->getSpotsAvailabeForScheduledSurvey==".$ex->getMessage());
        }
    }
    public function nodeCallForSpots($postId){
        try{            
            $returnArr = array();
            $streamObject = UserStreamCollection::model()->getStreamZeroObjectByPostId($postId);
            $advertisementId = $streamObject->AdvertisementId;
            $advertisementObj = Advertisements::model()->getAdvertisementsById($advertisementId);
             if ($advertisementObj != "failure") {                
                if (isset($advertisementObj->ScheduleId)) {
                    $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id", $advertisementObj->ScheduleId);
                      if(is_object($obj) && $obj->MaxSpots>0){
                        $spotsCount = SurveyUsersSessionCollection::model()->getSpotsAvailabeForScheduledSurvey($obj, $obj->SurveyId);                        

                        if ($spotsCount == 0) {
                            $spotMessage = "There are no more spot left to take this survey";
                        } else if ($spotsCount == 1) {
                            $spotMessage = "There is " . $spotsCount . " spot left to take this survey act now";
                        } else {
                            $spotMessage = "There are " . $spotsCount . " spots left to take this survey act now";
                        }
                        $returnArr['PostId'] = $postId;
                        $returnArr['SpotMessage'] = $spotMessage;
                        $returnArr['SpotsCount'] = $spotsCount;
                    }
                }
            }

                       return $returnArr;
        } catch (Exception $ex) {
            Yii::log("SurveyUsersSessionCollection:nodeCallForSpots::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SurveyUsersSessionCollection->nodeCallForSpots==".$ex->getMessage());
        }
    }
    public function getLastAnsweredPage($UserId,$scheduleId,$surveyId){
        try {
            $position = 0;
            $page = 0;
               $scheduleObj = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject("Id", $scheduleId);
if($scheduleObj->QuestionView>0){
  
    
             $useranswers = SurveyUsersSessionCollection::model()->getAnswersForSurvey($UserId,$scheduleId);
                   if(is_array($useranswers)){
                       $lastAnswer = end($useranswers);
                       $lastQuestionId = $lastAnswer["QuestionId"];
                      
}
                   
                 $surveyDetails = ExtendedSurveyCollection::model()->getSurveyDetailsById("Id", $surveyId);  
                 $questions = $surveyDetails->Questions;
                 foreach ($questions as $q) {
                    
                     if($q["QuestionId"] == $lastQuestionId){
                         $position = $q["QuestionPosition"];
                         break;
                     }
                 }
               
               
                 $page = ceil($position/$scheduleObj->QuestionView);
                 $rem = $position % $scheduleObj->QuestionView;
//                         if($rem == 0){
//                             $page = $page +1;
//                         }
                 
        }
                 return $page;
            
        } catch (Exception $ex) {
            Yii::log("SurveyUsersSessionCollection:getLastAnsweredPage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SurveyUsersSessionCollection->getLastAnsweredPage==".$ex->getMessage());
        }
    }
     public function getUserAnsweredPage($UserId,$scheduleId,$surveyId){
        try {
           $criteria = new EMongoCriteria();
               
                $criteria->addCond('ScheduleId', '==', new MongoId($scheduleId)); 
                $criteria->addCond('UserId', '==', (int)$UserId);
                $obj = SurveyUsersSessionCollection::model()->find($criteria);
                return $obj->Page;
            
        } catch (Exception $ex) {
            Yii::log("SurveyUsersSessionCollection:getUserAnsweredPage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SurveyUsersSessionCollection->getUserAnsweredPage==".$ex->getMessage());
        }
    }
        public function getAllAnswersForSchedule($scheduleId){
            try{
            $returnArray = array();
             $c = SurveyUsersSessionCollection::model()->getCollection();
            $result = $c->aggregate(array('$match' => array('ScheduleId' =>new MongoID($scheduleId))),array('$group' => array("_id" => '$ScheduleId',"UserAnswers" => array('$push' => '$UserAnswers'))));   
             if(is_array($result['result'])&& sizeof($result['result'])>0 ){
                  $userAnswers =  $result['result'][0]["UserAnswers"];
                  if(is_array($userAnswers)&& sizeof($userAnswers)>0 ){
                       $returnArray = $userAnswers;
                  }
            }
            return $returnArray;
            } catch (Exception $ex) {
                Yii::log("SurveyUsersSessionCollection:getAllAnswersForSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
            }
            
    public function getSurveyAnswersByScheduleId($scheduleId){
        try{
            $userAnswersArray = array();
            $criteria = new EMongoCriteria();  
            if(!empty($scheduleId)){
                $criteria->addCond('ScheduleId', '==', new MongoId($scheduleId));             
                $obj = SurveyUsersSessionCollection::model()->findAll($criteria);
                $i = 0;
                foreach($obj as $rwObj){
                    if(!empty($rwObj->UserAnswers) && sizeof($rwObj->UserAnswers)>0){
                        $userAnswersArray = array_merge($userAnswersArray,$rwObj->UserAnswers);
                    }
                }           
            }
            return $userAnswersArray;
        } catch (Exception $ex) {
            Yii::log("SurveyUsersSessionCollection:getSurveyAnswersByScheduleId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SurveyUsersSessionCollection->getSurveyAnswersByScheduleId==".$ex->getMessage());
        }
            
    }
    
    
  
    
}