<?php

/**
 *  @author Vamsi Krishna 
 *  This is the service Method for all the Games 
 */
class SkiptaGameService {


    public function saveNewGame($newGameModel,$NetworkId,$userId) {

        try {            
            $returnvalue="failure";
            $gamesList=GameCollection::model()->getGameDetailsByType('GameName',$newGameModel->GameName);
            $Gamestatus="";
            $gameMode= $newGameModel->Iscreated;
            if(is_array($gamesList) && count($gamesList)>0 && $gameMode!=1){
                $returnvalue='Duplicate';
            }else{
            $gameCollectionObj = new GameCollection();
              $gameCollectionObj->NetworkId = (int)$NetworkId;
            $gameCollectionObj->GameName = $newGameModel->GameName;
            $gameCollectionObj->GameId = $newGameModel->GameId;
            // $gameId= $newGameModel->GameId;
           // = $newGameModel->GameBannerImage;
                    //'/upload/Game/Profle/featureditem.png';
            
            $gameCollectionObj->Language=CommonUtility::detectLanugage($newGameModel->GameDescription);
            $gameCollectionObj->GameDescription = $newGameModel->GameDescription;
            if(isset($newGameModel->CreatedOn) && !empty($newGameModel->CreatedOn)){
                $gameCollectionObj->CreatedOn = new MongoDate(strtotime($newGameModel->CreatedOn));
            }else{
                $gameCollectionObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d', time())));
            }
            $gameCollectionObj->UserId = (int) $userId;
            $gameCollectionObj->GameAdminUser = (int) $userId;
            $gameCollectionObj->CreatedBy = (int)(isset($newGameModel->CreatedBy)?$newGameModel->CreatedBy:0);
            $gameCollectionObj->Status = (int) 1;
            array_push($gameCollectionObj->Followers, (int)$userId);
            $Questions=array();
            if(isset($newGameModel->MigratedGameId) && !empty($newGameModel->MigratedGameId)){
                $gameCollectionObj->MigratedGameId = $newGameModel->MigratedGameId;
                $gameCollectionObj->GameBannerImage = $newGameModel->GameBannerImage;
                $arr = $newGameModel->Questions;
            }else{
               $gameCollectionObj->GameBannerImage=$this->saveGameArtifacts($newGameModel->GameBannerImage,$newGameModel->GameId);
               $questionsA = $newGameModel->Questions;
              $arr = CJSON::decode($questionsA);
            }       
            
           $gameCollectionObj->Resources =$this->saveResourceForGame($gameCollectionObj->GameBannerImage,$newGameModel->CreatedOn);
           $gameCollectionObj->QuestionsCount = count($arr);
           $questionIdArray = array();//key-migratedQuestionId, value-NewQuestionId
            for ($i = 0; $i < count($arr); $i++) {
               
                $question = $arr[$i];
               
                 $QuestionBean=new QuestionsBean(); 
                if(isset($newGameModel->MigratedGameId) && !empty($newGameModel->MigratedGameId)){
                    $QuestionBean->QuestionId=new MongoId();
                    $quesId = $question['questionId'];
                    $questionIdArray["$quesId"] = (string)$QuestionBean->QuestionId;
                }else{
                    $QuestionId=stripslashes($question['questionId']);
                    if($QuestionId==""){
                        $QuestionBean->QuestionId=new MongoId();
                    }else{
                        $QuestionBean->QuestionId=$QuestionId;
                    }
                }
                $QuestionBean->Question = stripslashes($question['question']);
                $QuestionBean->QuestionDisclaimer = stripslashes($question['question_disclaimer']);
                $QuestionBean->OptionA = stripslashes($question['optionA']);
                $QuestionBean->OptionADisclaimer = stripslashes($question['optionA_disclaimer']);
                $QuestionBean->OptionB = stripslashes($question['optionB']);
                $QuestionBean->OptionBDisclaimer = stripslashes($question['optionB_disclaimer']);
                $QuestionBean->OptionC = stripslashes($question['optionC']);
                $QuestionBean->OptionCDisclaimer = stripslashes($question['optionC_disclaimer']);
                $QuestionBean->OptionD = stripslashes($question['optionD']);
                $QuestionBean->OptionDDisclaimer = stripslashes($question['optionD_disclaimer']);
                $QuestionBean->Points = (int)stripslashes($question['points']);
                $QuestionBean->Position = (int)stripslashes($question['position']);
                  if($question['image']!=""){
                    if(isset($newGameModel->MigratedGameId) && !empty($newGameModel->MigratedGameId)){
                        $QuestionBean->QuestionImage = $question['image'];
                        $QuestionBean->Resources =$this->saveResourceForGame($QuestionBean->QuestionImage,$newGameModel->CreatedOn);
                    }else{
                         $QuestionBean->QuestionImage = $this->saveGameArtifacts(stripslashes($question['image']),stripslashes($question['questionId']));
                         $QuestionBean->Resources =$this->saveResourceForGame($QuestionBean->QuestionImage);
                    }
                }else{
                    
                }
             /**
             * added below peace for save networkid, segmentid, language of original
             * @developer reddy
             */
            $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
            
            $gameCollectionObj->NetworkId = (int) $tinyUserCollectionObj->NetworkId;
            $gameCollectionObj->SegmentId = (int) $tinyUserCollectionObj->SegmentId;
            
                  
                $QuestionBean->CorrectAnswer = stripslashes($question['answer']);
                array_push($Questions,$QuestionBean);
                
            } 
            
               $gameCollectionObj->Questions = $Questions;
               if(isset($newGameModel->IsSponsors) && $newGameModel->IsSponsors == 1){
                   
                    $gameCollectionObj->IsSponsored = (int) $newGameModel->IsSponsors;               
                    
               }
               
               $gameCollectionObj->IsEnableSocialActions  = (int) $newGameModel->IsEnableSocialActions;
                        
                $gameId= $newGameModel->GameId;   
                $gameCollectionObj->BrandName = Yii::app()->params['NetworkName'];
                $gameCollectionObj->BrandLogo = "/images/system/networkbg_logo.png";
                if($newGameModel->IsSponsors == 1)
                $gameCollectionObj->BrandLogo=$this->saveGameArtifacts($newGameModel->BrandLogo,$newGameModel->GameId);
                if($newGameModel->IsSponsors == 1 && $newGameModel->BrandName == "other"){
                    $gameCollectionObj->BrandName = $newGameModel->OtherValue;      
                    
                    GameSponsors::model()->saveNewGameSponsorName($newGameModel->OtherValue,$UserId,$gameCollectionObj->BrandLogo);
                }else{
                    if($newGameModel->IsSponsors == 1){
                        $gameCollectionObj->BrandName = $newGameModel->BrandName;
                    }
                }
               if($gameId==""){
                  
                    $gameId=GameCollection::model()->SaveGame($gameCollectionObj);
                    
                     $Gamestatus="create";
               }else{                    
                   $this->UpdateGame($gameCollectionObj);
                   $Gamestatus="update";
                   
               }
               
            
            if($gameId!="failure"){
               
                $returnvalue=$gameId;
               
                 $categoryId = CommonUtility::getIndexBySystemCategoryType('Game');
               
                $gameDetails = GameCollection::model()->getGameDetailsObject('Id',$gameId);
               
                    $createdDate=time();
                    if(isset($newGameModel->CreatedOn) && !empty($newGameModel->CreatedOn)){
                        $createdDate = strtotime($newGameModel->CreatedOn);
                    }
                  CommonUtility::prepareStreamObject((int)$gameDetails->UserId,"Post",$gameDetails->_id,$categoryId,"","", $createdDate);     
                  
                  if($Gamestatus=="update"){
                      $returnvalue="update";
                  }
                
            }
            if(isset($newGameModel->MigratedGameId) && !empty($newGameModel->MigratedGameId)){
                $returnvalue = array("GameId"=>(string)$gameId,"QuestionIdArray"=>$questionIdArray);
            }
            } 
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:saveNewGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function scheduleGame($scheduleGameFormObj) {
        try {
            $scheduleObject = new ScheduleGameCollection();
            $gameDetails = GameCollection::model()->getGameDetailsByType($type, $gameId);
            if (!is_string($gameDetails)) {
                $scheduleObject->GameName = $gameDetails->GameName;
                $scheduleObject->GameDescription = $gameDetails->GameDescription;
                $scheduleObject->GameId = $gameDetails->GameDescription;
            }
            $scheduleObject->ShowDisclaimer=$scheduleGameFormObj->ShowDisclaimer;
            $scheduleObject->ShowThankYou=$scheduleGameFormObj->ShowThankYou;
            $scheduleObject->ThankYouMessage=$scheduleGameFormObj->ThankYouMessage;
            $scheduleObject->ThankYouArtifact=$scheduleGameFormObj->ThankYouArtifact;
            $scheduleObject->StartDate=$scheduleGameFormObj->StartDate;
            $scheduleObject->EndDate=$scheduleGameFormObj->EndDate;
            $scheduleObject->IsPromoted=$scheduleGameFormObj->IsPromoted;
            
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:scheduleGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getGamesToSchedule() {
        try {
            $gamesList=GameCollection::model()->getAllGames();
            return $gamesList;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getGamesToSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     
    public function getGameDetailsById($gameId){
        try {
             $gamesList=GameCollection::model()->getGameDetailsByType('Id',$gameId);
            return $gamesList;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getGameDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
     public function getGameDetailsByIdObject($gameId){
        try {
             $gamesList=GameCollection::model()->getGameDetailsObject('Id',$gameId);
            return $gamesList;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getGameDetailsByIdObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
    
    
    public function loadGameWall() {
        try {
            
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:loadGameWall::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function checkForScheduleGame($startDate,$endDate,$scheduleId=0) {
        try {
            
            $isExists=ScheduleGameCollection::model()->checkGameScheduleForDates($startDate,$endDate,$scheduleId);
            
            return $isExists;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:checkForScheduleGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
   public function saveScheduleGame($newScheduleGame,$userId, $createdDate="") {
        try {
            $returnValue='failure';
            $previousSchedule = 0;
               $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
              
                $newScheduleGame->SegmentId = $tinyUserCollectionObj->SegmentId;
                $newScheduleGame->NetworkId = $tinyUserCollectionObj->NetworkId;
                $newScheduleGame->Language = $tinyUserCollectionObj->Language;
                
                               
                /**
                 * $newScheduleGame->GameName here game GAME NAME attribute notate per GAME ID
                 */
      
            $currentScheduleGame = 0;
            $sDate = strtotime($newScheduleGame->StartDate);
            $cDate = strtotime(date('m/d/y H:i:s'));

            $IsNotifiable=0;

            if ($sDate < $cDate) {
                $currentScheduleGame = (int) 1;
                $IsNotifiable=1;
            }
            $stream = $this->checkStreamExistsForGame($newScheduleGame->GameName, $newScheduleGame->StartDate, $newScheduleGame->EndDate,$newScheduleGame->SegmentId);
            $result = ScheduleGameCollection::model()->saveScheduleGame($newScheduleGame, $currentScheduleGame,$userId, $createdDate);
            
            $gameDetails = GameCollection::model()->getGameDetailsObject('Id', $newScheduleGame->GameName);            
            if($currentScheduleGame==1){
                if(!is_string($result)){
             GameCollection::model()->updateGameForIsCurrentSchedule("IsCurrentSchedule",1,$gameDetails->_id);
             GameCollection::model()->updateGameForIsCurrentSchedule("CurrentScheduleId",$result,$gameDetails->_id);
                }           
             
            }
             
            $categoryId = CommonUtility::getIndexBySystemCategoryType('Game');
          
           if ($stream == 'streamPartialUpdate') {

                $userStreamBean = new UserStreamBean();
                $userStreamBean->ActionType = 'GameSchedule';
                $userStreamBean->StartDate = $newScheduleGame->StartDate;

                $userStreamBean->SegmentId = $newScheduleGame->SegmentId;
                $userStreamBean->NetworkId = $newScheduleGame->NetworkId;
                $userStreamBean->Language = $newScheduleGame->Language;

                $userStreamBean->EndDate = $newScheduleGame->EndDate;
                $userStreamBean->PostId = $newScheduleGame->GameName;
                $userStreamBean->RecentActivity = $stream;
                 $userStreamBean->CategoryType = (int) $categoryId;
                $userStreamBean->CurrentGameScheduleId = (string) $result;
                $userStreamBean->CreatedOn = time();
                $userStreamBean->IsNotifiable = $IsNotifiable;
                if ($createdDate != "") {
                    $userStreamBean->CreatedOn = strtotime($createdDate);
                }
                Yii::app()->amqp->stream(json_encode($userStreamBean));
            } else if ($stream == 'streamTotalUpdate') {
                $pastSchedule = ScheduleGameCollection::model()->getPreviousOrFutureGameSchedule($newScheduleGame->GameName, $newScheduleGame->StartDate, $newScheduleGame->EndDate, "past");
                $userStreamBean = new UserStreamBean();
                $userStreamBean->PreviousGameScheduleId = (string) $pastSchedule->_id;
                $userStreamBean->PreviousSchedulePlayers = $pastSchedule->Players;
                $userStreamBean->PreviousScheduleResumePlayers = $pastSchedule->ResumePlayers;

                $userStreamBean->SegmentId = $newScheduleGame->SegmentId;
                $userStreamBean->NetworkId = $newScheduleGame->NetworkId;
                $userStreamBean->Language = $newScheduleGame->Language;

                $userStreamBean->CurrentGameScheduleId = (string) $result;
                $userStreamBean->CurrentScheduledPlayers = array();
                $userStreamBean->CurrentScheduleResumePlayers = array();
                $userStreamBean->IsNotifiable = $IsNotifiable;
                $userStreamBean->ActionType = 'GameSchedule';
                $userStreamBean->CategoryType = (int) $categoryId;
                $userStreamBean->PostId = $newScheduleGame->GameName;
                $userStreamBean->RecentActivity = $stream;
                $userStreamBean->CreatedOn = time();
                if ($createdDate != "") {
                    $userStreamBean->CreatedOn = strtotime($createdDate);
                }
                Yii::app()->amqp->stream(json_encode($userStreamBean));
                $returnValue = 'success';
            }


            if(isset($newScheduleGame->MigratedScheduleId) && !empty($newScheduleGame->MigratedScheduleId)){
                $returnValue = $result;//ScheduleId
            }
            return $returnValue;
        } catch (Exception $ex) {            
            Yii::log("SkiptaGameService:saveScheduleGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGameService->saveScheduleGame### ".$ex->getMessage());
            return $returnValue;
        }
    }

    public function getGameDetailsByName($userId,$gameName,$gameScheduleId){
        try {
            $gameBean = new GameDetailBean();
             $gameObj=GameCollection::model()->getGameDetailsObject('GameName',$gameName);
             if(is_object($gameObj)){
             if(GameCollection::model()->isUserCommented($userId,$gameObj->_id)=="exist"){
                $gameBean->isCommented = true;
            }else{
                $gameBean->isCommented = false;

            }
             
           
            if($gameScheduleId!=0){
             $scheduleGameObj=ScheduleGameCollection::model()->getScheduleGameDetailsObject('Id',$gameScheduleId);
             if($scheduleGameObj=="failure"){
                 return "failure";
             }
             $ResumePlayers = $scheduleGameObj->ResumePlayers;
             $Players = $scheduleGameObj->Players;
            $userGameStatus = ScheduleGameCollection::model()->findUserGameStatus($userId,$scheduleGameObj->_id,$scheduleGameObj->StartDate);
            $gameBean->gameStatus = $userGameStatus;
             $gameBean->gameScheduleId = $scheduleGameObj->_id;
           
             $userObj = UserCollection::model()->getTinyUserCollection($gameObj->HighestScoreUserId);
               $gameBean->highestScoreUserName = $userObj->DisplayName;
                 $gameBean->uniqueHandle = $userObj->uniqueHandle;
                 $gameBean->highestGameUserId = $userObj->UserId;
                 
                 if($userObj->profile70x70==""){
                         
                 $gameBean->highestScoreUserPicture = Yii::app()->params['ServerURL']."/images/system/user_noimage.png";  
                   }else{
                         $gameBean->highestScoreUserPicture = $userObj->profile70x70;
                   }
                 
                 
              
               $gameBean->CategoryType = 9;
                if($userId == $gameObj->GameAdminUser){
                    $gameBean->isGameAdmin =1;
                }else{
                      $gameBean->isGameAdmin =0;
                }
                 }
                 $gameBean->loveCount = count($gameObj->Love);
                  $gameBean->followCount = count($gameObj->Followers);
                  $commentCount = 0;
                  if (count($gameObj->Comments) > 0) {
                    foreach ($gameObj->Comments as $key => $value) {
                        $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
                        $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
                        if(!$IsBlockedWordExist && !$IsAbused){
                            $commentCount++;
                        }
                    }
                }
                  
                  
                    $gameBean->commentCount = $commentCount;     
                    if(count($gameObj->Love)>0){
                      $gameBean->isLoved = in_array($userId, $gameObj->Love);   
                    }else{
                      $gameBean->isLoved = 0;  
                    }
                    if(count($gameBean->isFollowed)>0){
                      $gameBean->isFollowed = in_array($userId, $gameObj->Followers);  
                    }else{
                      $gameBean->isFollowed = 0;  
                    }
                    
                      
                      //  $gameBean->isCommented = in_array($userId, $gameDetails->Followers);
                $shortDescription = CommonUtility::truncateHtml($gameObj->GameDescription, 240);
                 $gameBean->shortDescription =$shortDescription;
           
             return array($gameObj,$gameBean);
             }else{
                  return "failure";
             }
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getGameDetailsByName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGameService->getGameDetailsByName### ".$ex->getMessage());
        }
        }
          public function showGame($userId,$type,$gameId,$gameScheduleId){
           try {
               if($type == "play"){
                $gameObj=  ScheduleGameCollection::model()->startGame($userId,$gameId,$gameScheduleId);   
               }
           } catch (Exception $ex) {
            Yii::log("SkiptaGameService:showGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');

           }  
        }
        public function getQuestionsForGame($userId,$type,$gameId,$gameScheduleId){
           try {
               $ShowDisclaimer=1;
               if(!empty($gameScheduleId)){
                 $scheduleGameObj = ScheduleGameCollection::model()->getScheduleGameDetailsObject("Id",$gameScheduleId);  
                 $ShowDisclaimer=$scheduleGameObj->ShowDisclaimer;
               }
                $gameObj = GameCollection::model()->getGameDetailsObject("Id",$gameId);
                $questions = $gameObj->Questions;
               $questions=$this->actionsortArrayOfArray($questions,'Position',SORT_ASC);
               if($type == "play"){
              
                return array($questions,$ShowDisclaimer); 
               }
               else  if($type == "resume"){

               $finalQuestionArray = array();
                foreach ($questions as $question) {
               $answer = ScheduleGameCollection::model()->checkUserAnswered($userId,$gameId,$gameScheduleId,$question['QuestionId']);
                $questionAnswer = array();    
               if($answer!="notexist"){
                        $questionAnswer["question"] = $question;
                        $questionAnswer["answer"] = $answer;
                    }else{
                        $questionAnswer["question"] = $question;
                        $questionAnswer["answer"] = ""; 
                    }
                    array_push($finalQuestionArray, $questionAnswer);
                }
                return array($finalQuestionArray,$ShowDisclaimer); 
               }
                else  if($type == "view"){

               $finalQuestionArray = array();
                foreach ($questions as $question) {
               $answer = ScheduleGameCollection::model()->checkUserAnswered($userId,$gameId,$gameScheduleId,$question['QuestionId']);
                $questionAnswer = array();    
               if($answer!="notexist"){
                        $questionAnswer["question"] = $question;
                        $questionAnswer["answer"] = $answer;
                         $questionAnswer["correctAnswer"] = $question["CorrectAnswer"];
                    }else{
                        $questionAnswer["question"] = $question;
                        $questionAnswer["answer"] = ""; 
                        $questionAnswer["correctAnswer"] = $question["CorrectAnswer"];
                    }
                    array_push($finalQuestionArray, $questionAnswer);
                }
                return array($finalQuestionArray,$ShowDisclaimer); 
               }
                   else  if($type == "viewAdmin"){

               $finalQuestionArray = array();
                foreach ($questions as $question) {
                    $answer="notexist";
                    if(!empty($gameScheduleId)){
               $answer = ScheduleGameCollection::model()->checkUserAnswered($userId,$gameId,$gameScheduleId,$question['QuestionId']);
                    }
                $questionAnswer = array();    
               if($answer!="notexist"){
                        $questionAnswer["question"] = $question;
                        $questionAnswer["answer"] = "";
                         $questionAnswer["correctAnswer"] = $question["CorrectAnswer"];
                    }else{
                        $questionAnswer["question"] = $question;
                        $questionAnswer["answer"] = ""; 
                        $questionAnswer["correctAnswer"] = $question["CorrectAnswer"];
                    }
                    array_push($finalQuestionArray, $questionAnswer);
                }
                return array($finalQuestionArray,$ShowDisclaimer); 
               }
           } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getQuestionsForGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');

           }  
        }


        public function saveAnswer($userId,$gameId,$gameScheduleId,$questionId,$answer){
            try{
           ScheduleGameCollection::model()->saveAnswer($userId,$gameId,$gameScheduleId,$questionId,$answer);
            } catch (Exception $ex) {
             Yii::log("SkiptaGameService:saveAnswer::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
        }
         public function submitGame($userId,$gameId,$gameScheduleId, $totalTimeSpent=0, $createdDate=""){
           try{
               $createdDate=$createdDate==""?time():strtotime(date($createdDate, time()));
               
         $response =  ScheduleGameCollection::model()->submitGame($userId,$gameId,$gameScheduleId,$totalTimeSpent);
         $dataObj = array("UserId"=>(int)$userId,"TotalPoints"=>(int)$response['totalPoints']); 
         if(is_array($response)){
          CommonUtility::prepareStreamObject((int)$userId,"Play",$gameId,9,'',$dataObj,$createdDate);
  
         }
      return $response;
          
         } catch (Exception $ex) {
            Yii::log("SkiptaGameService:submitGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           }
        }


   public function getCurrentGameSchedule($userPrivileges,$userId){

       try {
           $returnValue='failure';
           $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
            $currentScheduleGameDetails = ScheduleGameCollection::model()->getScheduleGameDetailsObject('IsCurrentSchedule', (int) 1,$tinyUserCollectionObj->SegmentId);
           $currentScheduleGame=GameCollection::model()->getPostById($currentScheduleGameDetails->GameId);
          if(is_object($currentScheduleGame)){
              $gameObj=new GameBean();
              $gameObj->GameId=$currentScheduleGame->_id;
              $gameObj->GameName=$currentScheduleGame->GameName;
              $gameObj->Language=$currentScheduleGame->Language;
              $gameObj->GameDescription=$currentScheduleGame->GameDescription;
              $gameObj->GameBannerImage=$currentScheduleGame->GameBannerImage;             
              $gameObj->QuestionsCount=$currentScheduleGame->QuestionsCount;
              $gameObj->PlayersCount=$currentScheduleGame->PlayersCount;
              $gameObj->IsDeleted=$currentScheduleGame->IsDeleted;
              if($userId==$currentScheduleGame->GameAdminUser){
                $gameObj->GameAdminUser=1;
              }else{
                $gameObj->GameAdminUser=0;
              }
               $shortDescription = CommonUtility::truncateHtml($currentScheduleGame->GameDescription, 240);
                 $gameObj->ShortDescription =$shortDescription;
              $gameObj->Followers=$currentScheduleGame->Followers;
              $gameObj->FollowersCount=count($currentScheduleGame->Followers);
              $gameObj->CategoryType=9;
              
              $gameObj->PostType=$currentScheduleGame->Type;
              $gameObj->NetworkId=1;
              $gameObj->Love=Count($currentScheduleGame->Love);
              $gameObj->IsLoved=in_array($userId, $currentScheduleGame->Love);              
                $gameObj->IsCommented=in_array($userId, $currentScheduleGame->Comments);
                $count = 0;
                foreach ($currentScheduleGame->Comments as $comment) {
                    $IsBlockedWordExist = isset($comment['IsBlockedWordExist']) && $comment['IsBlockedWordExist']?true:false;
                    $IsAbused = isset($comment['IsAbused']) && $comment['IsAbused']?true:false;
                    if(!$IsBlockedWordExist && !$IsAbused){
                        $count++;
                        if($comment["UserId"] == $userId){
                            $gameObj->IsCommented=true;
                        }
                    }
                }
                $gameObj->CommentCount=$count;
                $gameObj->IsFollowed=in_array($userId, $currentScheduleGame->Followers);
              $schedule=ScheduleGameCollection::model()->getScheduleGameDetailsObject('IsCurrentSchedule',1);
              $gameObj->ScheduleId=$schedule->_id;
              $scheduleDetails=ScheduleGameCollection::model()->findUserGameStatus($userId,$schedule->_id);
              if(isset($scheduleDetails)){
                  $gameObj->GameStatus=$scheduleDetails;
                  $scheduleDetailsById=ScheduleGameCollection::model()->getGameScheduleById('Id',$schedule->_id);
                  if(isset($scheduleDetailsById)){                      
                  $gameObj->StartDate=$scheduleDetailsById->StartDate->sec;                  
                  $gameObj->EndDate=$scheduleDetailsById->EndDate->sec;
                  }
                  
                  
              }
              if($currentScheduleGame->GameHighestScore>0){
                  $HuserId=$currentScheduleGame->HighestScoreUserId;
                  $gameObj->HighestScore=$currentScheduleGame->GameHighestScore;
                  $userDetails=ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($HuserId);
                  if(isset($userDetails)){
                     $gameObj->HighestUserProfilePicture=$userDetails->ProfilePicture;
                     $gameObj->HUserName=$userDetails->DisplayName;
                     $gameObj->HighestUserId=$userDetails->UserId;
                     
                     
                  }
              }
              if($currentScheduleGame->IsEnableSocialActions  == 1){
                  $gameObj->IsEnableSocialActions = $currentScheduleGame->IsEnableSocialActions;
              }
              $gameObj->IsSponsored = $currentScheduleGame->IsSponsored;
              $gameObj->BrandName = $currentScheduleGame->BrandName;
              $gameObj->BrandLogo = $currentScheduleGame->BrandLogo;
              $returnValue =$gameObj;
          }
         return  $returnValue;
       } catch (Exception $ex) {
          Yii::log("SkiptaGameService:getCurrentGameSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in SkiptaGameService->getCurrentGameSchedule### ".$ex->getMessage());
       }
          
   }
   
  public function getScheduleGamesForGameWall(){
      try {
         $gameIds=array();
          $scheduleGames=ScheduleGameCollection::model()->getAllScheduleGames();
          if(!is_string($scheduleGames)){
              
              foreach($scheduleGames as $sGames){
                 array_push($gameIds,$sGames['GameId']); 
              }
          }
          return array_unique($gameIds);
      } catch (Exception $ex) {
          Yii::log("SkiptaGameService:getScheduleGamesForGameWall::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
        
  }
  
  
 public function saveGameArtifacts($Artifacts,$QuestionId) {
        try {
           
            $returnValue = 'failure';
            // $folder=Yii::getPathOfAlias('webroot'); 
            
             $folder=Yii::app()->params['WebrootPath'];
             $returnarry=array();
            if ($Artifacts!="") {
                
                   $ExistArtifact=$folder.'/'.$Artifacts;
                    /// $ExistMediaArtifact=$folder.'/upload/Game/Media/'.$Artifacts;
                     if(!file_exists($ExistArtifact) ){
                         $QuestionId="";
                         
                       
                         
                     }else{
                       
                     }
                
                
                if($QuestionId==""){
                    
                     
                      if (!file_exists($ExistArtifact) && !file_exists($ExistMediaArtifact) ) {
                //}
               
               // foreach ($Artifacts as $key => $artifact) {                    
                 
                    $imgArr = explode(".", $Artifacts);
                    $date = strtotime("now");
                    $finalImg_name = $imgArr[0] . '.' . end($imgArr);
                     $finalImage = trim($imgArr[0]) .'.'. end($imgArr);
                  
                     $fileNameTosave = $folder.'/temp/'. $imgArr[0] .'.'. end($imgArr);
                    $sourceArtifact=$folder.'/temp/'.$Artifacts;
                   rename($sourceArtifact, $fileNameTosave);
                    //  $filename=$result['filename'];
                    $extension = substr(strrchr($Artifacts, '.'), 1);
                    $extension=  strtolower($extension);
                   
                    if($extension=='mp4' || $extension=='mp3'|| $extension=='avi'){
                        $ext="video";
                        $path = 'Media';
                        
                   }else{
                       $path = 'Profile';
                   }                   
                          
                    $path = '/upload/Game/' . $path;
                   
                        if (!file_exists($folder . '/' . $path)) {
                          
                        mkdir($folder . '/' . $path, 0755, true);
                    }
                   
                    $sourcepath = $fileNameTosave;
                    $destination = $folder . $path . '/' . $finalImage;
                    if (file_exists($sourcepath)) {
                       
                        if (copy($sourcepath, $destination)) {
                            
                            $newfile = trim($imgArr[0]) . '_' . $date . '.' . end($imgArr);
                            //  $newfile=trim($imgArr[0]) .'.' . $imgArr[1];
                            $finalSaveImage = $folder . $path . '/' . $newfile;
                            rename($destination, $finalSaveImage);
                            $UploadedImage =$path . '/' . $newfile;
                            // unlink($sourcepath);


                            
                            $returnValue = "success";
                        }
                        
                        } else {
                            $UploadedImage =$path . '/' . $Artifacts;
                        }
                    }
                //}

            }else{
               $UploadedImage =$Artifacts; 
            }
            
            }
           return $UploadedImage;   
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:saveGameArtifacts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function UpdateGame($Gameobj) {
        try{
        $questions = $Gameobj->Questions;
        
        $Gameupdate = GameCollection::model()->UpdateGameDetails($Gameobj);
         UserStreamCollection::model()->UpdateGameDetails($Gameobj);
         
         ScheduleGameCollection::model()->UpdateScheduleGameById($Gameobj);
         UserActivityCollection::model()->updateStreamForGameDetails($Gameobj);
          UserInteractionCollection::model()->updateUserInteractionForGameDetails($Gameobj);
         FollowObjectStream::model()->updateFollowObjectForGameDetails($Gameobj);
         
         
        foreach ($Gameobj->Questions as $key => $value) {

          


            $QuestinExist = GameCollection::model()->CheckQuestionExist($Gameobj->GameId, $value->QuestionId);
            if ($QuestinExist == 'success') {
           

                $QuestinExist = GameCollection::model()->UpdateGame($Gameobj->GameId, $questions[$key]);
            } else {
               
                $QuestinExist = GameCollection::model()->UpdateGameQuestions($Gameobj->GameId, $questions[$key]);
            }
        }
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:UpdateGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getCurrentScheduleGameForRightsideWidget($userid) {
        try {
            $returnValue = 'failure';
            
             $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userid);
            
            $currentScheduleGameDetails = ScheduleGameCollection::model()->getScheduleGameDetailsObject('IsCurrentSchedule', (int) 1,$tinyUserCollectionObj->SegmentId);
            if (is_object($currentScheduleGameDetails)) {
           
                $currentScheduleGameStatus = ScheduleGameCollection::model()->findUserGameStatus($userid, $currentScheduleGameDetails->_id);
                $currentScheduleGame = GameCollection::model()->getGameDetailsObject('Id', $currentScheduleGameDetails->GameId);

                $gameObj = new GameBean();
                $gameObj->ScheduleId = $currentScheduleGameDetails->_id;
                $gameObj->GameId = $currentScheduleGameDetails->GameId;
                $gameObj->GameName = $currentScheduleGameDetails->GameName;
                $gameObj->GameDescription = $currentScheduleGameDetails->GameDescription;
                $gameObj->QuestionsCount = $currentScheduleGame->QuestionsCount;
                $gameObj->GameBannerImage = $currentScheduleGame->GameBannerImage;
                $gameObj->PlayersCount = $currentScheduleGame->PlayersCount;
                $gameObj->GameStatus = $currentScheduleGameStatus;
                
                $gameObj->IsSponsored = $currentScheduleGame->IsSponsored;
                $gameObj->BrandName = $currentScheduleGame->BrandName;
                $gameObj->BrandLogo = $currentScheduleGame->BrandLogo;
                $gameObj->IsDeleted=$currentScheduleGame->IsDeleted;

                $returnValue = $gameObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getCurrentScheduleGameForRightsideWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }
 public function checkStreamExistsForGame($gameId,$startDate,$endDate,$segmentId=0){
     try {
         $stream='false';
         $isPresent=ScheduleGameCollection::model()->getScheduleGameBetweenDatesByGameId($gameId,$startDate,$endDate,$segmentId);
         
         if(is_object($isPresent)){
          
            $stream='false';    
         }else{
            
            $pastSchedule= ScheduleGameCollection::model()->getPreviousOrFutureGameSchedule($gameId,$startDate,$endDate,"past",$segmentId);
            $futureSchedule=ScheduleGameCollection::model()->getPreviousOrFutureGameSchedule($gameId,$startDate,$endDate,"future",$segmentId);
            if(is_object($pastSchedule)){                
                
                 $stream='streamTotalUpdate';
             }else if(!is_object($pastSchedule) && is_object($futureSchedule)){
                    $stream='streamPartialUpdate';
             }else{
                  $stream='streamPartialUpdate';
             }
         }
       
         return $stream;
     } catch (Exception $ex) {
         Yii::log("SkiptaGameService:checkStreamExistsForGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in SkiptaGameService->checkStreamExistsForGame### ".$ex->getMessage());
     }
  }
 public function actionsortArrayOfArray($array, $on, $order=SORT_ASC) {
  try{ 
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }
    return $new_array;
    } catch (Exception $ex) {
        Yii::log("SkiptaGameService:actionsortArrayOfArray::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function UpdateGameFields($gameId,$Gameobj,$Fieldvalue){
        
        try{
            
            $returnValue = 'failure';
            if($Gameobj=='GameBannerImage'){
               
               $Fieldvalue= $this->saveGameArtifacts($Fieldvalue,$gameId);
            }
            $gameUpdatedFieldValue=GameCollection::model()->UpdateGameFields($gameId,$Gameobj,$Fieldvalue);
            if($gameUpdatedFieldValue!='failure'){
                 $returnValue=$gameUpdatedFieldValue;
            }
            
            return $returnValue;
            
        } catch (Exception $ex) {
            
            Yii::log("SkiptaGameService:UpdateGameFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
       
    }


  public function updatePartialStreamForGame($gameId,$startDate,$EndDate){
      $returnValue = 'failure';
      try {
          UserStreamCollection::model()->updatePartialUserStreamForGame($gameId,$startDate,$EndDate);
      } catch (Exception $ex) {
          Yii::log("SkiptaGameService:updatePartialStreamForGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }  
    



    
    
    public function saveResourceForGame($artifact,$createdDate='') {
        try {
            $returnValue = 'failure';
            $Resource = array();
            $res = new ResourceBean;
            // if ($Artifacts > 0) {
                //foreach ($Artifacts as $key => $artifact) {
                 $Artifacts=explode("/", $artifact);
            $Artifact=end($Artifacts);
            
                    $extension = substr(strrchr($Artifact, '.'), 1);
                     $extension=  strtolower($extension);
                    if($extension=='mp4' || $extension=='mp3'|| $extension=='avi'){
                        $ext="video";
                        $path = 'Media/' . $Artifact;
                   }else if($extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tiff'|| $extension=='png'){
                       $path = 'Profile/' . $Artifact;
                   }
                    $Resource['ResourceName'] = $Artifact;
                        $path = '/upload/Game/' . $path;
                    $thumbNailpath='/upload/Game/';
                    $ArtifactClassName=$this->getArtifactClassName($Artifact,$path,$thumbNailpath, $createdDate);
                     if($extension=='mp3'){
                        $ThumbnailImage="/images/system/audio_img.png";
                    }else if($extension=='mp4' || $extension=='flv'|| $extension=='mov'){
                        
                        $info = pathinfo($Artifact);
                        $image_name =  basename($Artifact,'.'.$info['extension']);
                        $image_name=$image_name.'.'.'jpg';
                        $folder=Yii::getPathOfAlias('webroot').'/upload/Game/thumbnails/'.$image_name;
                        $uploadfile=Yii::getPathOfAlias('webroot').$path;
                       //  exec("ffmpeg -itsoffset -0 -i $uploadfile -vcodec mjpeg -vframes 1 -an -f rawvideo scale=320:-1 $folder");
                        exec("ffmpeg -i $uploadfile -vf scale=320:-1 $folder");
                        $ThumbnailImage='/upload/Game/thumbnails/'.$image_name;
                    }else {
                        $ThumbnailImage=str_replace(" ", "", stripslashes(trim($ArtifactClassName['filepath'])));
                    }

                    
                    $Resource['StyleClas']=trim($ArtifactClassName['fileclass']);
                    $Resource['Uri'] = str_replace(" ", "", stripslashes(trim($ArtifactClassName['filepath'])));
                    $Resource['Extension'] = $extension;
                    $Resource['ThumbNailImage'] = $ThumbnailImage;
                   
                    
//                    $returnValue = ResourceCollection::model()->SaveResourceCollection($ResourceCollectionModel, $postId, $createdDate);
//                    if ($postType == 1 || $postType == 2 || $postType == 3|| $postType == 4) {
//                        PostCollection::model()->updatePostWithArtifacts($postId, $ResourceCollectionModel->attributes);
//                    }else if($postType == 5){
//                         CurbsidePostCollection::model()->updateCurbsidePostWithArtifacts($postId, $res->attributes);
//                    }
               // }

           //}
           return $Resource;   
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:saveResourceForGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getArtifactClassName($artifact,$path,$thumbNailpath, $createdDate='') {
        try {
            $className="";
             $className="img_small_250";
              $new_filepath=$path;
            $result=array();
            // $extension = end(explode(".", strtolower($artifact)));
             $imageExtension=explode(".", strtolower($artifact));
             $extension = end($imageExtension);
             if($createdDate==''){
                if($extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tiff'|| $extension=='png'){
                   $filepath=Yii::getPathOfAlias('webroot').$path;
                    if (file_exists($filepath) ) {
                      
                        list($width, $height) = getimagesize($filepath);
                           $newfolder=Yii::getPathOfAlias('webroot').$thumbNailpath.'thumbnails/';// folder for uploaded files
                           if (!file_exists($newfolder) ) {
                                 mkdir ($newfolder, 0755,true);
                                }
                           if($width >='250'){
                           $img = Yii::app()->simpleImage->load($filepath);
                           $img->resizeToWidth(250);
                           $img->save($newfolder.$artifact); 
                           $className="img_big_250";
                         $new_filepath=$thumbNailpath.'thumbnails/' . $artifact;
                       }else{
                           $destination=$newfolder.$artifact;
                           copy($filepath, $destination);
                           $className="img_small_250";
                           $new_filepath=$thumbNailpath.'thumbnails/' . $artifact;
                       }
                    }else{
                       $result['filepath']=$new_filepath;
                       $result['fileclass']=$className; 
                    }


               }
             }
            $result['filepath']=$new_filepath;
            $result['fileclass']=$className;
             return $result;
             
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getArtifactClassName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
 public function getGamesForAnalytics($segmentId=0) {
        try {
            $gamesList=GameCollection::model()->getAllGamesForAnalytics($segmentId);
            return $gamesList;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getGamesForAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
 public function getGameAnalytics($gameId, $segmentId=0) {
        try {
            if($gameId == "AllGames"){
                $gamesList=GameCollection::model()->getAllGamesForAnalytics($segmentId); 
            }
            else{
                 $gamesList=GameCollection::model()->getGameDetailsByType("Id",$gameId); 
            }
                $playersCount = 0;
                $totalTimeSpent = 0;
                $totalPoints = 0;
                 $gameTotalPoints = 0;
                $gameHighestScore = 0;
                foreach ($gamesList as $game) {
                   $playersCount = $playersCount + count($game->Players);
                   if($game->GameHighestScore > $gameHighestScore){
                      $gameHighestScore = $game->GameHighestScore;
                   }
                   $players = $game->Players;
                    $gameTotalPoints = GameCollection::model()->getGameTotalPoints($gameId); 
                   
                   foreach ($players as $player) {
                       $totalTimeSpent = $totalTimeSpent + $player['TotalTimeSpent'];
                       $totalPoints = $totalPoints + $player['TotalPoints'];
                   }
                }
                if($totalPoints>0){
                          $averagePoints = $totalPoints/$playersCount;
                       }else{
                           $averagePoints = 0;
                       }
                  if($totalTimeSpent>0){
                     $averageTime = $totalTimeSpent/$playersCount;// in secs
                /*convert sec to hours*/
                  $averageTime =  gmdate("H:i:s", $averageTime);  
                  }else{
                      $averageTime =0;
                  }
                $cumilativeData = array("playersCount" => $playersCount,"averageTime"=>$averageTime,"gameTotalPoints"=>$gameTotalPoints,"avgPoints" => $averagePoints);
            
            return $cumilativeData;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getGameAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGameService->getGameAnalytics### ".$ex->getMessage());
        }
    }
 public function getGameDetailAnalytics($gameId,$startLimit,$pageLength,$type="") {
        try {
            if($gameId!="AllGames"){
                 $gameName =  GameCollection::model()->getGameName($gameId);
            }else{
                $gameName = "All Games";
            }
             
               $totalScheduleCount =  ScheduleGameCollection::model()->getAllScheduleGamesCount($gameId);  
                $scheduleGamesList=  ScheduleGameCollection::model()->getAllScheduleGamesForAnalytics($gameId,$startLimit,$pageLength,$type);
                $scheduleGamesArray = array();
                $questions = $gameObj->Questions;
               
                foreach ($scheduleGamesList as $scheduleGame) {
                    $gameDetailBean = new GameDetailBean();
                    $playersCount = $playersCount + count($scheduleGame->Players);
                    //$gameDetailBean->startDate = $scheduleGame->StartDate;
                   // $gameDetailBean->endDate = $scheduleGame->EndDate;
                     $totalTimeSpent = 0;
                     $totalPoints = 0;
                      $players = $scheduleGame->Players;
                        $gameTotalPoints = GameCollection::model()->getGameTotalPoints($scheduleGame->GameId); 
                      foreach ($players as $player) {
                       $totalTimeSpent = $totalTimeSpent + $player['TotalTimeSpent'];
                       $totalPoints = $totalPoints + $player['TotalPoints'];
                   }
                       if($totalPoints>0){
                          $averagePoints = $totalPoints/$playersCount;
                       }else{
                           $averagePoints = 0;
                       }
                  if($totalTimeSpent>0){
                     $averageTime = $totalTimeSpent/$playersCount;// in secs
                /*convert sec to hours*/
                  $averageTime =  gmdate("H:i:s", $averageTime);  
                  }else{
                      $averageTime =0;
                  }
               
                $gameDetailBean->avgPoints =$averagePoints;
                 $gameDetailBean->gameTotalPoints =$gameTotalPoints;
                $gameDetailBean->averageTime =$averageTime;
                array_push($scheduleGamesArray, array($scheduleGame,$gameDetailBean));
                }
                return array($scheduleGamesArray,$totalScheduleCount,$gameName);
 
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getGameDetailAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGameService->getGameDetailAnalytics### ".$ex->getMessage());
        }
    }

        public function suspendGame($gameId,$actionType="Suspend") {
        try {
           $return="failure";
           if($actionType=="Suspend"){
          $return=ScheduleGameCollection::model()->removeFutureGameSchedule($gameId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())),'',"future");
           $currentScheduleGame= GameCollection::model()->isCurrentScheduleGame($gameId);
           GameCollection::model()->suspendORReleaseGame($gameId,1);
           error_log("___________before inside__________inside ________________");
           if(isset($currentScheduleGame) && is_object($currentScheduleGame)){
               error_log("_____________________inside ________________");
             $currentScheduleGame=  ScheduleGameCollection::model()->updateCurrentScheduleGameByToday($gameId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())));
           }
           
  
           $pastSchedule= ScheduleGameCollection::model()->getPreviousOrFutureGameSchedule($gameId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())),"","past"); 
            if(isset($pastSchedule) && is_object($pastSchedule)){
        
                $userStreamBean = new UserStreamBean();
                        $userStreamBean->PreviousGameScheduleId = '';
                        $userStreamBean->PreviousSchedulePlayers = array();
                        $userStreamBean->PreviousScheduleResumePlayers = array();
                        $userStreamBean->CurrentGameScheduleId = (string)$pastSchedule->_id;
                        $userStreamBean->CurrentScheduledPlayers = $pastSchedule->Players;
                        $userStreamBean->CurrentScheduleResumePlayers = $pastSchedule->ResumePlayers;
                        $userStreamBean->IsNotifiable = 0;
                        $userStreamBean->ActionType = "SuspendGame";
                        $userStreamBean->PostId = $gameId;
                        $userStreamBean->StartDate = $pastSchedule->StartDate->sec;
                        $userStreamBean->EndDate = $pastSchedule->EndDate->sec;
                        $userStreamBean->CategoryType = 9;
                         $userStreamBean->RecentActivity = "PullUpdate";

          
           }else{
                GameCollection::model()->suspendORReleaseGame($gameId,0);
               
                $userStreamBean = new UserStreamBean();
                        $userStreamBean->PreviousGameScheduleId = '';
                        $userStreamBean->PreviousSchedulePlayers = array();
                        $userStreamBean->PreviousScheduleResumePlayers = array();
                        $userStreamBean->CurrentGameScheduleId = "";
                        $userStreamBean->CurrentScheduledPlayers = array();
                        $userStreamBean->CurrentScheduleResumePlayers =array();
                        $userStreamBean->IsNotifiable = 0;
                        $userStreamBean->ActionType = "SuspendGame";
                        $userStreamBean->PostId = $gameId;
                        $userStreamBean->StartDate ="";
                        $userStreamBean->EndDate = "";
                        $userStreamBean->CategoryType = 9;
                         $userStreamBean->RecentActivity = "PartialUpdate";

                       
           }
             GameCollection::model()->updateGameForIsCurrentSchedule("CurrentScheduleId",$userStreamBean->CurrentGameScheduleId,$userStreamBean->PostId);
            }  else {
                $userStreamBean = new UserStreamBean();
                GameCollection::model()->suspendORReleaseGame($gameId,0);
                $pastSchedule = ScheduleGameCollection::model()->getPreviousOrFutureGameSchedule($gameId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())), "", "past");
                if (isset($pastSchedule) && is_object($pastSchedule)) {
                    $userStreamBean->IsNotifiable = 1;
                } else {
                    $userStreamBean->IsNotifiable = 0;
                }
                $userStreamBean->CategoryType = 9;

                $userStreamBean->ActionType = "ReleaseGame";
                $userStreamBean->PostId = $gameId;
            }
          
            Yii::app()->amqp->stream(json_encode($userStreamBean));
             return "success";
             
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:suspendGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function cancelSchedule($gameId, $scheduleId) {
        try {
            $return = "failure";
         

                $iscurrentSchedule = ScheduleGameCollection::model()->isCurrentScheduleByScheduleId($gameId, $scheduleId);
                if ($iscurrentSchedule == true) {
                    /**
                     * if schedule is current schedule , then we need to update that schedule today date
                     */
                    $currentScheduleGame = ScheduleGameCollection::model()->updateCurrentScheduleGameByToday($gameId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())));
                } else {
                    $currentScheduleGame = ScheduleGameCollection::model()->removeScheduleByScheduleId($scheduleId);
                }
               //  return;
                $obj = ScheduleGameCollection::model()->getPreviousOrFutureGameSchedule($gameId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())), "", "past");
                $iscontainSchedule = false;
                if (isset($obj) && is_object($obj)) {
                    $iscontainSchedule = true;
                } else {
                    $obj = ScheduleGameCollection::model()->getPreviousOrFutureGameSchedule($gameId, date("Y-m-d H:i:s",CommonUtility::currentSpecifictime_timezone(date_default_timezone_get())), "", "future");

                    $iscontainSchedule = true;
                }
                if ($iscontainSchedule == true) {
                    $userStreamBean = new UserStreamBean();
                    $userStreamBean->PreviousGameScheduleId = '';
                    $userStreamBean->PreviousSchedulePlayers = array();
                    $userStreamBean->PreviousScheduleResumePlayers = array();
                    $userStreamBean->CurrentGameScheduleId = (string) $obj->_id;
                    $userStreamBean->CurrentScheduledPlayers = $obj->Players;
                    $userStreamBean->CurrentScheduleResumePlayers = $obj->ResumePlayers;
                    $userStreamBean->IsNotifiable = 1;
                    $userStreamBean->ActionType = "CancelScheduleGame";
                    $userStreamBean->PostId = $gameId;
                    $userStreamBean->StartDate = $obj->StartDate->sec;
                    $userStreamBean->EndDate = $obj->EndDate->sec;
                    $userStreamBean->CategoryType = 9;
                    $userStreamBean->RecentActivity = "PullUpdate";
                } else {
                    $userStreamBean = new UserStreamBean();
                    $userStreamBean->PreviousGameScheduleId = '';
                    $userStreamBean->PreviousSchedulePlayers = array();
                    $userStreamBean->PreviousScheduleResumePlayers = array();
                    $userStreamBean->CurrentGameScheduleId = "";
                    $userStreamBean->CurrentScheduledPlayers = array();
                    $userStreamBean->CurrentScheduleResumePlayers = array();
                    $userStreamBean->IsNotifiable = 0;
                    $userStreamBean->ActionType = "CancelScheduleGame";
                    $userStreamBean->PostId = $gameId;
                    $userStreamBean->StartDate = "";
                    $userStreamBean->EndDate = "";
                    $userStreamBean->CategoryType = 9;
                     $userStreamBean->RecentActivity = "PartialUpdate";
                }
               GameCollection::model()->updateGameForIsCurrentSchedule("CurrentScheduleId",$userStreamBean->CurrentGameScheduleId,$userStreamBean->PostId);
                $userStreamBean->CategoryType = 9;
               Yii::app()->amqp->stream(json_encode($userStreamBean));

            return "success";
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:cancelSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGameService->cancelSchedule### ".$ex->getMessage());
        }
    }
    public function getGameByMigratedId($migratedGameId){
        try {
            $gameDetails=GameCollection::model()->getGameDetailsByType('MigratedGameId',$migratedGameId);
            return $gameDetails;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getGameByMigratedId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGameService->getGameByMigratedId### ".$ex->getMessage());
        }
    }
    
 //This method is used to convert the game banner image to resource in game collection
    
     public function UpdateGamaResourceswithThumbnailImage(){
        try {
          
            $gameDetails=GameCollection::model()->getAllGamesForAnalytics();
           // $date = new MongoDate(strtotime(date('Y-m-d', time())));
            $date = "";
            
            foreach ($gameDetails as $key => $value) {
       
                $Resources = $this->saveResourceForGame($value['GameBannerImage'],$date);
                $gameDetails=GameCollection::model()->UpdateGameResources($value['_id'],$Resources);
              
                
            }
            
            return $gameDetails;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:UpdateGamaResourceswithThumbnailImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGameService->UpdateGamaResourceswithThumbnailImage### ".$ex->getMessage());
            
        }
    }
    
//This method is used to update game resource in userstream collection 
    
     public function UpdateGameResourceswithThumbnailImageInStream(){
        try {
          
            
            $gamepostscount=UserStreamCollection::model()->getAllGamePostsCount();
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:UpdateGameResourceswithThumbnailImageInStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGameService->UpdateGameResourceswithThumbnailImageInStream### ".$ex->getMessage());
        }
    }
     public function getGameById($gameId){
         try{
           $gameObject =  GameCollection::model()->getGameDetailsObject('Id', $gameId);
           return $gameObject;
         } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getGameById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }  
    }
    
    public function getCurrentScheduleByScheduleId($gameId){
        try{
            return ScheduleGameCollection::model()->getCurrentScheduleByScheduleId($gameId);
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getCurrentScheduleByScheduleId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function getCurrentScheduleGameForDSN() {
        try {
            $returnValue = 'failure';
            $currentScheduleGameDetails = ScheduleGameCollection::model()->getScheduleGameDetailsObject('IsCurrentSchedule', (int) 1);
            if (is_object($currentScheduleGameDetails)) {

               
                $currentScheduleGame = GameCollection::model()->getGameDetailsObject('Id', $currentScheduleGameDetails->GameId);

                $gameObj = new GameBean();
                $gameObj->ScheduleId = $currentScheduleGameDetails->_id;
                $gameObj->GameId = $currentScheduleGameDetails->GameId;
                $gameObj->GameName = $currentScheduleGameDetails->GameName;
                $gameObj->GameDescription = $currentScheduleGameDetails->GameDescription;
                $gameObj->QuestionsCount = $currentScheduleGame->QuestionsCount;
                $gameObj->GameBannerImage = $currentScheduleGame->GameBannerImage;
                $gameObj->PlayersCount = $currentScheduleGame->PlayersCount;
               

                $returnValue = $gameObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaGameService:getCurrentScheduleGameForDSN::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }
    
    
}
