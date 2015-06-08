<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ScheduleGameCollection extends EMongoDocument {
    
    public $_id;
    public $GameId;
    public $Status;
    public $GameDescription;
    public $GameName;
    public $Players=array();
    public $ResumePlayers=array();
    public $PreviousSchedule=array();
    public $StartDate;
    public $EndDate;
    public $CreatedOn;
    public $UserAnswers=array();
    public $ThankYouMessage;
    public $ThankYouImage;
    public $ShowThankYou;
    public $ShowDisclaimer;
    public $IsCurrentSchedule=0;
    public $PreviousSchedulePlayers;
    public $PreviousScheduleResumePlayers;
    public $IsCancelSchedule=0;
    public $CreatedUserId;
   public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';
    
    public function getCollectionName() {
        return 'ScheduleGameCollection';
    }
 public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_EndDate' => array(
                'key' => array(
                    'EndDate' => EMongoCriteria::SORT_DESC,
                    'GameName' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_GameName' => array(
                'key' => array(
                    'GameName' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            ),
        );
    }
     public function attributeNames() {
     return array(
         '_id'=>'_id',
         'GameId'=>'GameId',
         'Status'=>'Status',
         'GameDescription'=>'GameDescription',
         'GameName'=>'GameName',
         'Players'=>'Players',
         'ResumePlayers'=>'ResumePlayers',
         'PreviousSchedulePlayers'=>'PreviousSchedulePlayers',
         'PreviousScheduleResumePlayers'=>'PreviousScheduleResumePlayers',
         'StartDate'=>'StartDate',
         'EndDate'=>'EndDate',
         'CreatedOn'=>'CreatedOn',
         'UserAnswers'=>'UserAnswers',
         'ThankYouMessage'=>'ThankYouMessage',
         'ThankYouImage'=>'ThankYouImage',
         'ShowThankYou'=>'ShowThankYou',
         'ShowDisclaimer'=>'ShowDisclaimer',
         'IsCurrentSchedule'=>'IsCurrentSchedule',
         'PreviousSchedulePlayers'=>'PreviousSchedulePlayers',
         'PreviousScheduleResumePlayers'=>'PreviousScheduleResumePlayers',
         'IsCancelSchedule'=>'IsCancelSchedule',
         'CreatedUserId'=>'CreatedUserId',
          'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
    
         
         
     );
     
     
     }
     
   public function saveScheduleGame($newScheduleGameObj,$currentScheduleGame,$userId, $createdDate=""){
       try {
           $returnValue='failure';
           $scheduleGameObj=new ScheduleGameCollection();
            $gameDetails = GameCollection::model()->getGameDetailsObject('Id', $newScheduleGameObj->GameName);
           if (!is_string($gameDetails)) {
                 $scheduleGameObj->GameDescription=$gameDetails->GameDescription;
           $scheduleGameObj->GameName=$gameDetails->GameName;
           $scheduleGameObj->GameId=$gameDetails->_id;
            }
             
           
           $scheduleGameObj->StartDate=new MongoDate(strtotime($newScheduleGameObj->StartDate));
           $scheduleGameObj->EndDate=new MongoDate(strtotime($newScheduleGameObj->EndDate));
           $scheduleGameObj->Players=array();
           $scheduleGameObj->ShowDisclaimer=(int)$newScheduleGameObj->ShowDisclaimer;
           $scheduleGameObj->ShowThankYou=(int)$newScheduleGameObj->ShowThankYou;
           $scheduleGameObj->ThankYouMessage=$newScheduleGameObj->ThankYouMessage;
           $scheduleGameObj->ThankYouImage=$newScheduleGameObj->ThankYouArtifact;
           $scheduleGameObj->UserAnswers=array();
           $scheduleGameObj->Status=(int)1;
           $scheduleGameObj->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
           if(isset($createdDate) && !empty($createdDate)){
                $scheduleGameObj->CreatedOn=new MongoDate(strtotime(date($createdDate, time())));
           }
           $scheduleGameObj->IsCurrentSchedule=$currentScheduleGame;
           $scheduleGameObj->CreatedUserId=(int)$userId;
           $scheduleGameObj->SegmentId = (int) $newScheduleGameObj->SegmentId;
            $scheduleGameObj->NetworkId = (int) $newScheduleGameObj->NetworkId;
            $scheduleGameObj->Language = $newScheduleGameObj->Language;
            if($scheduleGameObj->save()){
               $returnValue=$scheduleGameObj->_id;
           }
           return $returnValue;
       } catch (Exception $ex) {
           Yii::log("ScheduleGameCollection:saveScheduleGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in ScheduleGameCollection->saveScheduleGame==".$ex->getMessage());
       }
      }  
     
   public function checkGameScheduleForDates($startDate,$endDate,$scheduleId=0){
       try {
          $returnValue='failure';
          
          $criteria = new EMongoCriteria;
          $criteria->addCond('StartDate', '<=', new MongoDate(strtotime($startDate)));
          $criteria->addCond('EndDate', '>=', new MongoDate(strtotime($startDate)));
          $criteria->addCond('IsCancelSchedule', '==',(int)0);        
          $criteria->addCond('SegmentId', '==',(int)$scheduleId);
          $isGameExists1=ScheduleGameCollection::model()->find($criteria);   
         
          if(is_object($isGameExists1) || is_array($isGameExists1) ){
              $returnValue=$isGameExists1;
          }else{
          $criteria = new EMongoCriteria;
          $criteria->addCond('StartDate', '<=', new MongoDate(strtotime($endDate)));
          $criteria->addCond('EndDate', '>=',new MongoDate(strtotime($endDate)));
          $criteria->addCond('IsCancelSchedule', '==',(int)0);          
          $criteria->addCond('SegmentId', '==',(int)$scheduleId);
          $isGameExists2=ScheduleGameCollection::model()->find($criteria); 
          if(is_object($isGameExists2) || is_array($isGameExists2) ){
              $returnValue=$isGameExists2;
          }else{
              $returnValue='false'; 
          }
              
          }
          return $returnValue;
       } catch (Exception $ex) {
           Yii::log("ScheduleGameCollection:checkGameScheduleForDates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }

      
      public function getAllScheduleGames(){
          try {
              $returnValue='failure';
              $criteria = new EMongoCriteria;
              $scheduleGames=ScheduleGameCollection::model()->findAll($criteria);
              if(is_array($scheduleGames)){
                  $returnValue=$scheduleGames;
              }
             return $returnValue;
          } catch (Exception $ex) {
              Yii::log("ScheduleGameCollection:getAllScheduleGames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                return $returnValue;
          }
            }

      public function getScheduleGameDetailsObject($type,$value,$segmentId=0){
               try {
          $returnValue = 'failure';
          $criteria = new EMongoCriteria;
         if($type=='Id'){
             $criteria->addCond('_id', '==', new MongoID($value));
         }if($type=='GameName'){
             $criteria->addCond('GameName', '==', $value);
         }         
          if($type=='IsCurrentSchedule'){
             $criteria->addCond('IsCurrentSchedule', '==', $value);
         } 
          if($type=='GameId'){
             $criteria->addCond('GameId', '==', new MongoID($value));
         }
           $criteria->addCond('SegmentId', '==', (int) $segmentId);
         $scheduleGameObj=ScheduleGameCollection::model()->find($criteria);
            if(is_array($scheduleGameObj) || is_object($scheduleGameObj) ){
                $returnValue=$scheduleGameObj;
            }
            return $returnValue;
     } catch (Exception $ex) {
        
         Yii::log("ScheduleGameCollection:getScheduleGameDetailsObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         return $returnValue;
     }
      }
      
      /**
       * @author vamsi
       * @param type $userId
       * @param type $gameId
       * @param type $gameScheduleId
       */
      
            public function getScheduleGameDetailsObjectForStream($type,$value){
               try {
          $returnValue = 'failure';
          $criteria = new EMongoCriteria;
       
          if($type=='GameId'){
             $criteria->addCond('GameId', '==', new MongoID($value));
              $criteria->addCond('EndDate', '<=', new date("Y-m-d",time()));
         }
          
         $scheduleGameObj=ScheduleGameCollection::model()->find($criteria);
            if(is_array($scheduleGameObj) || is_object($scheduleGameObj) ){
                $returnValue=$scheduleGameObj;
            }
            return $returnValue;
     } catch (Exception $ex) {
         Yii::log("ScheduleGameCollection:getScheduleGameDetailsObjectForStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
      }
      
      
    public function startGame($userId,$gameId,$gameScheduleId){
          try {
             
              $criteria = new EMongoCriteria;
              $criteria->addCond('_id', '==', new MongoID($gameScheduleId));
              $modifier = new EMongoModifier();
              $modifier->addModifier('ResumePlayers', 'addToSet', array("UserId"=>(int)$userId,"StartTime"=>new MongoDate(time())));
              ScheduleGameCollection::model()->updateAll($modifier, $criteria);
              
              
               $criteria = new EMongoCriteria;
              $criteria->addCond('_id', '==', new MongoID($gameId));
              $modifier = new EMongoModifier();
              $modifier->addModifier('PlayersCount', 'inc', 1);
              GameCollection::model()->updateAll($modifier, $criteria);
             CommonUtility::prepareStreamObject((int)$userId,"Playing",$gameId,9,'',"",time());

          } catch (Exception $ex) {
            
             Yii::log("ScheduleGameCollection:startGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          }  
      }
 
      public function saveAnswer($userId,$gameId,$gameScheduleId,$questionId,$answer){
          try{
           $gameObj = GameCollection::model()->getGameDetailsObject("Id",$gameId);
            $questions = $gameObj->Questions;
              
              foreach ($questions as $question) {
              if($question["QuestionId"] == $questionId ){
                 $correctAnswer =  $question["CorrectAnswer"];
                 $points = $question["Points"];
                 break;
              }
              }
              if($correctAnswer != $answer){
                  $points = 0;
              }
           $result = ScheduleGameCollection::model()->checkUserAnswered($userId,$gameId,$gameScheduleId,$questionId);
  if($result=="notexist"){
             $qArray = array();
             $qArray["UserId"] = (int)$userId;
             $qArray["QuestionId"] = new MongoId($questionId);
             $qArray["Answer"] = $answer;
             $qArray["CorrectAnswer"] = $correctAnswer;
             $qArray["Points"] = (int)$points;
             $criteria = new EMongoCriteria;
             $criteria->addCond('_id', '==', new MongoID($gameScheduleId));
             $modifier = new EMongoModifier();
             $modifier->addModifier('UserAnswers', 'addToSet', $qArray);
             ScheduleGameCollection::model()->updateAll($modifier, $criteria);
  }else{
              $modifier = new EMongoModifier();
              $criteria = new EMongoCriteria();
//              $criteria->addCond('_id', '==', new MongoID($gameScheduleId));
//                $criteria->addCond('UserAnswers.UserId', '==', (int)$userId);
//                  // $criteria->addCond('UserAnswers.QuestionId', '==', new MongoID($questionId));
//              $modifier->addModifier('UserAnswers.$.Answer', 'set', $answer);
//              $modifier->addModifier('UserAnswers.$.CorrectAnswer', 'set', $correctAnswer);
//              $modifier->addModifier('UserAnswers.$.Points', 'set', (int)$points);
               $criteria->addCond('_id', '==', new MongoID($gameScheduleId));
              $popArray["UserId"] = (int)$userId;
               $popArray["QuestionId"] = new MongoID($questionId);
               $modifier->addModifier('UserAnswers', 'pull', $popArray);
              ScheduleGameCollection::model()->updateAll($modifier, $criteria); 
              
              
              $qArray = array();
             $qArray["UserId"] = $userId;
             $qArray["QuestionId"] = new MongoId($questionId);
             $qArray["Answer"] = $answer;
             $qArray["CorrectAnswer"] = $correctAnswer;
             $qArray["Points"] = (int)$points;
             $criteria = new EMongoCriteria;
             $criteria->addCond('_id', '==', new MongoID($gameScheduleId));
             $modifier = new EMongoModifier();
             $modifier->addModifier('UserAnswers', 'addToSet', $qArray);
             ScheduleGameCollection::model()->updateAll($modifier, $criteria);
  }
             
             
          } catch (Exception $ex) {
             
             Yii::log("ScheduleGameCollection:saveAnswer::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          }
      }
      public function checkUserAnswered($userId,$gameId,$gameScheduleId,$questionId){
         try{
            $criteria = new EMongoCriteria();
            $criteria->setSelect(array('UserAnswers'=>true));
            $criteria->addCond('_id', '==', new MongoID($gameScheduleId));
            $criteria->addCond('UserAnswers.UserId', '==', (int)$userId);
            $criteria->addCond('UserAnswers.QuestionId', '==', new MongoID($questionId));
             $obj = ScheduleGameCollection::model()->find($criteria);  
            if(is_object($obj)){
             $userAnswers = $obj->UserAnswers;
             $answer="";
             foreach ($userAnswers as $value) {
              if($value['UserId'] == $userId && $value['QuestionId']==$questionId){
                  $answer = $value['Answer'];
                  break;
              }
                 }
                return $answer;
            }else{
                return "notexist";
            }
         } catch (Exception $ex) {
           Yii::log("ScheduleGameCollection:checkUserAnswered::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         } 
      }
     public function submitGame($userId,$gameId,$gameScheduleId, $totalTimeSpent=0){
         try{
               $criteria = new EMongoCriteria();
            //$criteria->setSelect(array('GameName'=>true,'UserAnswers'=>true));
            $criteria->addCond('_id', '==', new MongoID($gameScheduleId));
            $scheduleGameObject = ScheduleGameCollection::model()->find($criteria);
            if(!isset($scheduleGameObject) && empty($scheduleGameObject)){
                return "failure";
            }
            $userAnswers = $scheduleGameObject->UserAnswers;
            $totalPoints;
             foreach ($userAnswers as $value) {
                 if($value['UserId'] == $userId){
                  $totalPoints =$totalPoints + $value['Points'];
                 
              } 
             }
              $resumePlayers = $scheduleGameObject->ResumePlayers;
              $timeSpent=$totalTimeSpent;
              if($timeSpent==0){
                  foreach ($resumePlayers as $value) {
                    if ($value['UserId'] == $userId) {
                        $timeSpent = time() - $value['StartTime']->sec;
                        break;
                    }
                }
            }
           $modifier = new EMongoModifier();
           $criteria = new EMongoCriteria();
           $popArray["UserId"] = (int)$userId;
           $criteria->addCond('_id', '==', new MongoID($gameScheduleId));
           $modifier->addModifier('ResumePlayers', 'pull', $popArray);
           $modifier->addModifier('Players', 'addToSet', array("UserId"=>(int)$userId,"TotalPoints"=>(int)$totalPoints,"TotalTimeSpent"=>(int)$timeSpent));
           ScheduleGameCollection::model()->updateAll($modifier, $criteria);
           
           
              $criteria = new EMongoCriteria;
              $criteria->addCond('_id', '==', new MongoID($gameId));
              $modifier = new EMongoModifier();
              $modifier->addModifier('Players', 'push', array("UserId"=>(int)$userId,"TotalPoints"=>(int)$totalPoints,"TotalTimeSpent"=>(int)$timeSpent));
              GameCollection::model()->updateAll($modifier, $criteria); 
           
             $criteria = new EMongoCriteria();
              $criteria->addCond('_id', '==', new MongoID($gameId));
              $criteria->addCond('GameHighestScore', '<', (int)$totalPoints);
             $modifier = new EMongoModifier();
             $modifier->addModifier('GameHighestScore', 'set', (int)$totalPoints);
             $modifier->addModifier('HighestScoreUserId', 'set', (int)$userId);

            GameCollection::model()->updateAll($modifier, $criteria);  
            
           return array("gameName"=>$scheduleGameObject,"totalPoints"=>$totalPoints);
         } catch (Exception $ex) {
                Yii::log("ScheduleGameCollection:submitGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         } 
      }
      public function findUserGameStatus($userId,$scheduleGameId,$startDate=''){
          try{
              if(!empty($startDate)){
               if($startDate->sec > time()){
                  return "future";  
               }
              }
              
            
           $criteria = new EMongoCriteria();
           
           // $criteria->setSelect(array('UserAnswers'=>true));
            $criteria->addCond('_id', '==', new MongoID($scheduleGameId));
            $criteria->addCond('ResumePlayers.UserId', '==',(int)$userId);
            $obj = ScheduleGameCollection::model()->find($criteria);  
            if(is_object($obj)){                
                return "resume";
            }else{
                
             $criteria = new EMongoCriteria();
            $criteria->addCond('_id', '==', new MongoID($scheduleGameId));
            $criteria->addCond('Players.UserId', '==', (int)$userId);
            $obj = ScheduleGameCollection::model()->find($criteria); 
             if(is_object($obj)){
                   
                return "view";
            }else{
                  
                return "play"; 
            }
            }
          } catch (Exception $ex) {              
             Yii::log("ScheduleGameCollection:findUserGameStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');

          }
      }
      
       public function findUserGameStatusForPreviousSchedule($userId,$scheduleGameId,$startDate=''){
          try{
//              if(!empty($startDate)){
//               if(strtotime($startDate) > strtotime(date('m/d/y'))){
//                  return "future";  
//               }
//              }
              
            
//           $criteria = new EMongoCriteria();
//           
//           // $criteria->setSelect(array('UserAnswers'=>true));
//            $criteria->addCond('_id', '==', new MongoID($scheduleGameId));
//            $criteria->addCond('PreviousScheduleResumePlayers.UserId', '==',(int)$userId);
//            $obj = ScheduleGameCollection::model()->find($criteria);  
//            if(is_object($obj)){                
//                return "resume";
//            }else{
                
             $criteria = new EMongoCriteria();
            $criteria->addCond('_id', '==', new MongoID($scheduleGameId));
            $criteria->addCond('PreviousSchedulePlayers.UserId', '==', (int)$userId);
            $obj = ScheduleGameCollection::model()->find($criteria); 
             if(is_object($obj)){
                   
                return "view";
            }else{
                return "No";
            }
           // }
          } catch (Exception $ex) {
              Yii::log("ScheduleGameCollection:findUserGameStatusForPreviousSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
              error_log("Exception Occurred in ScheduleGameCollection->findUserGameStatusForPreviousSchedule==".$ex->getMessage());

          }
      }
      
   public function getScheduleGameBetweenDatesByGameId($gameId,$startDate,$endDate,$segmentId){
       $returnValue = 'failure';
       try {
            
           $criteria = new EMongoCriteria();
            $criteria->addCond('GameId', '==', new MongoID($gameId));
            $criteria->addCond('EndDate', '>=', new MongoDate(time()));
            $criteria->addCond('EndDate', '<=', new MongoDate(strtotime($startDate)));
           $criteria->addCond('SegmentId', '==',(int)$segmentId);
            // $criteria->addCond('EndDate', '<=', new MongoDate(strtotime($startDate)));
            
            $obj=ScheduleGameCollection::model()->find($criteria); 
            if(is_object($obj)){
                $returnValue=$obj;
            }
            return $returnValue;
       } catch (Exception $ex) {
            Yii::log("ScheduleGameCollection:getScheduleGameBetweenDatesByGameId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
       }
      }
      
      public function getPreviousOrFutureGameSchedule($gameId, $startDate, $endDate, $type, $segmentId = 0) {
        try {
            $returnValue = "failure";
            $criteria = new EMongoCriteria();
            $criteria->addCond('GameId', '==', new MongoID($gameId));
            $criteria->addCond('SegmentId', '==', $segmentId);


            if ($type == 'past') {
                $criteria->addCond('StartDate', '<=', new MongoDate(strtotime($startDate)));
                $criteria->sort('StartDate', 'desc');
            } else {
                $criteria->addCond('StartDate', '>=', new MongoDate(strtotime($startDate)));
                $criteria->sort('StartDate', 'asc');
            }

            $criteria->limit(1);


            $obj = ScheduleGameCollection::model()->find($criteria);
            if (is_object($obj)) {
                $returnValue = $obj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ScheduleGameCollection:getPreviousOrFutureGameSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getAllScheduleGamesForAnalytics($gameId,$startLimit, $pageLength,$type){
          try {
              $returnValue='failure';
              $criteria = new EMongoCriteria;
              if($type!="xls"){
                 $criteria->limit($pageLength);
                $criteria->offset($startLimit);  
              }
              $criteria->sort("StartDate",EMongoCriteria::SORT_ASC);  
            if($gameId != "AllGames"){
              $criteria->GameId = new MongoId($gameId);
            }
//              $array = array(
//                'conditions'=>array(
//                  
//                    'GameId'=>array('==' => new MongoId()), // Or 'FieldName1'=>array('>=' => 10)
//            //        'FieldName2'=>array('in' => array(1, 2, 3)),
//            //        'FieldName3'=>array('exists'),
//                ),
//                'limit'=>$pageLength,
//                'offset'=>$startLimit,
//                //'sort'=>array('fieldName1' => EMongoCriteria::SORT_ASC, 'fieldName4' => EMongoCriteria::SORT_DESC),
//             );
              $scheduleGames=ScheduleGameCollection::model()->findAll($criteria);
              if(is_array($scheduleGames)){
                  $returnValue=$scheduleGames;
              }
             return $returnValue;
          } catch (Exception $ex) {
              Yii::log("ScheduleGameCollection:getAllScheduleGamesForAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                return $returnValue;
          }
            }
     public function getAllScheduleGamesCount($gameId){
          try {
              $returnValue='failure';
              $criteria = new EMongoCriteria;
               if($gameId != "AllGames"){
                $criteria->GameId = new MongoId($gameId);
              }
               $count=ScheduleGameCollection::model()->count($criteria);
              return $count;
          } catch (Exception $ex) {
              Yii::log("ScheduleGameCollection:getAllScheduleGamesCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                return $returnValue;
          }
            }
            
     public function getSchedulesForGame($gameId,$segmentId=0){
             $returnValue = 'failure';
         try {
            
          $criteria = new EMongoCriteria;       
          $criteria->setSelect(array('StartDate'=>true,'EndDate'=>true,'_id'=>true,'GameId'=>true,'IsCurrentSchedule'=>true,'IsCancelSchedule'=>true));
          $criteria->addCond('GameId', '==', new MongoID($gameId));
           $criteria->addCond('SegmentId', '==', (int)$segmentId);
          //$criteria->addCond('IsCancelSchedule', '==', (int)0);
          $criteria->sort('StartDate', 'asc');
          
          $gameSchedules=ScheduleGameCollection::model()->findAll($criteria);
          
          if(count($gameSchedules)>0 ){
              $returnValue=$gameSchedules;
          }
         return $returnValue;
         } catch (Exception $ex) {
             Yii::log("ScheduleGameCollection:getSchedulesForGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             return $returnValue;
         }
          }


            
        public function removeFutureGameSchedule($gameId, $startDate) {
        try {
            $criteria = new EMongoCriteria();
            $criteria->addCond('GameId', '==', new MongoID($gameId));
            $criteria->addCond('StartDate', '>', new MongoDate(strtotime($startDate)));
            $return = ScheduleGameCollection::model()->deleteAll($criteria);
            return $return;
        } catch (Exception $ex) {
            Yii::log("ScheduleGameCollection:removeFutureGameSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function updateCurrentScheduleGameByToday($gameId, $date) {
        try {
            $returnValue = "failure";
            $criteria = new EMongoCriteria();
            $criteria->addCond('GameId', '==', new MongoID($gameId));
             $criteria->addCond('IsCurrentSchedule', '==', 1);
            $modifier = new EMongoModifier();
            $modifier->addModifier('IsCurrentSchedule', 'set', (int) 0);
            $modifier->addModifier('EndDate', 'set', new MongoDate(strtotime($date)));
            $modifier->addModifier('IsCancelSchedule', 'set', (int)1);

            ScheduleGameCollection::model()->updateAll($modifier, $criteria);

            $criteria = new EMongoCriteria();
            $criteria->addCond('_id', '==', new MongoID($gameId));
            $modifier = new EMongoModifier();
            $modifier->addModifier('IsCurrentSchedule', 'set', (int) 0);
            GameCollection::model()->updateAll($modifier, $criteria);

            return "success";
        } catch (Exception $ex) {
            Yii::log("ScheduleGameCollection:updateCurrentScheduleGameByToday::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
       public function isCurrentScheduleByScheduleId($gameId, $scheduleId) {
        try {
            $returnValue = false;
            $criteria = new EMongoCriteria();
            $criteria->addCond('_id', '==', new MongoID($scheduleId));
            $criteria->addCond('IsCurrentSchedule', '==', 1);


            $obj = ScheduleGameCollection::model()->find($criteria);
            if (is_object($obj)) {

                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            Yii::log("ScheduleGameCollection:isCurrentScheduleByScheduleId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return false;
        }
    }
    
      public function removeScheduleByScheduleId($scheduleId) {
        try {
            $criteria = new EMongoCriteria();
            $criteria->addCond('_id', '==', new MongoID($scheduleId));
              $return = ScheduleGameCollection::model()->deleteAll($criteria);
            return $return;
        } catch (Exception $ex) {
            Yii::log("ScheduleGameCollection:removeScheduleByScheduleId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getGameScheduleById($type, $value) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            if ($type == 'Id') {
                $criteria->addCond('_id', '==', new MongoID($value));
            }
            if ($type == 'IsCurrentSchedule') {
                $criteria->addCond('IsCurrentSchedule', '==', $value);
            }

            $gameObj = ScheduleGameCollection::model()->find($criteria);
            if (is_array($gameObj) || is_object($gameObj)) {
                $returnValue = $gameObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ScheduleGameCollection:getGameScheduleById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ScheduleGameCollection->getGameScheduleById==".$ex->getMessage());
        }
    }
    
    public function UpdateScheduleGameById($Gameobj){
        
        try {
           
            $criteria = new EMongoCriteria();
            //$criteria->addCond('GameId', '==', new MongoID($gameId));

            $modifier = new EMongoModifier();
            $criteria->addCond('GameId', '==', new MongoID($Gameobj->GameId));
            $modifier->addModifier('GameDescription', 'set', $Gameobj->GameDescription);
            $modifier->addModifier('GameName', 'set', $Gameobj->GameName);

            ScheduleGameCollection::model()->updateAll($modifier, $criteria);
               
                ;
        } catch (Exception $ex) {
            Yii::log("ScheduleGameCollection:UpdateScheduleGameById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ScheduleGameCollection->UpdateScheduleGameById==".$ex->getMessage());
        }
    }
    
    public function getCurrentScheduleByScheduleId($gameId) {
        try {
            $returnValue = false;
            $criteria = new EMongoCriteria();
            $criteria->addCond('GameId', '==', new MongoID($gameId));
            $criteria->addCond('IsCurrentSchedule', '==', 1);


            $obj = ScheduleGameCollection::model()->find($criteria);
            if (is_object($obj)) {

                return $obj;
            } else {
                return array();
            }
        } catch (Exception $ex) {
            Yii::log("ScheduleGameCollection:getCurrentScheduleByScheduleId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return false;
        }
    }

}

          
