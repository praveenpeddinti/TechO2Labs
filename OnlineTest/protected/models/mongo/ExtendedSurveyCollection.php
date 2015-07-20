<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ExtendedSurveyCollection extends EMongoDocument {
     public $_id;
     public $SurveyTitle;
     public $SurveyDescription;
     public $Status=1;
     public $CreatedUserId;
     public $QuestionsCount=0;
     public $CreatedOn;
     public $UserId;
     public $IsCurrentSchedule=0;    
     public $SurveyLogo;
     public $CurrentScheduleId=0;
     public $SurveyRelatedGroupName="";
     public $SurveyTakenUsers=array();            
     public $IsDeleted = 0;         
     public $Questions=array();
     public $NetworkId;
     public $Resources = array();    
     public $SurveyTakenCount=0;    
     public $CreatedBy=0;
     public $IsBannerVisible =0;
     public $IsMadatory=0;
     public $IsAnalyticsShown=1;
     public $IsAcceptUserInfo;
     public $IsEnableNotification;
     public $Type;
     public $Love;
     public $HashTags;
    
    public $Followers;
    public $Mentions;
    public $Comments;    
    public $Invite;
        
    public $Share;
    
     public $Description;
     public $StartTime;
    public $EndTime;
    public $WebUrls;
  
   
    public $IsAbused=0;//0 - Default/Release, 1 - Abused, 2 - Blocked
    public $AbusedUserId;    
    public $IsPromoted=0;
    public $PromotedUserId;
    public $AbusedOn;
    public $SurveyTaken; 
    
    public $DisableComments=0;
    public $IsBlockedWordExist=0;
    public $IsFeatured = 0;
  
    public $FeaturedUserId;
    public $FeaturedOn;
    public $IsBlockedWordExistInComment=0;
    public $IsWebSnippetExist = 0;
    public $Division=0;
    public $District=0;
    public $Region=0;
    public $Store=0;
    public $FbShare;
    public $TwitterShare;
    public $Title;
    public $MigratedPostId='';
    //$postedBy is added by Sagar for PostAsNetwork
    public $PostedBy = 0;
    public $PromotedDate;
    public $IsCommentAbused = 0;
   
    public $Language = 'en';         
    public $SegmentId=0;
    public $saveItForLaterUserIds = array();
    public $ShowDerivative=1;
    public $Resource;
    public $BrandLogo = "";
    public $BrandName = "";
    public $IsBranded = 0;
    public  $LastUpdatedBy;

    public function getCollectionName() {
        return 'ExtendedSurveyCollection';
    }
 public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_survey' => array(
                'key' => array(
                    'SurveyRelatedGroupName' => EMongoCriteria::SORT_ASC,
                ),
                
            )
        );
    }
     public function attributeNames() {
     return array(
         '_id'=>'_id',
         'SurveyTitle'=>'SurveyTitle',
         'SurveyDescription'=>'SurveyDescription',
         'Status'=>'Status',
         'CreatedUserId'=>'CreatedUserId',
         'QuestionsCount'=>'QuestionsCount',
         "Questions"=>"Questions",
         'CreatedOn'=>'CreatedOn',
         'UserId'=>'UserId', 
         'LastUpdatedBy'=>'LastUpdatedBy',
         'IsCurrentSchedule'=>'IsCurrentSchedule',         
         'Questions'=>'Questions',
         'SurveyLogo'=>'SurveyLogo',
         'SurveyTakenCount'=>'SurveyTakenCount',
         'NetworkId'=>'NetworkId',
         'CurrentScheduleId' => 'CurrentScheduleId',
         'Resources'=>'Resources',
         'IsDeleted'=>'IsDeleted',
         'CreatedBy'=>'CreatedBy',
         'SurveyRelatedGroupName' => 'SurveyRelatedGroupName',  
         'IsBannerVisible' =>'IsBannerVisible',
         'IsMadatory' => 'IsMadatory',
         'IsAnalyticsShown' => 'IsAnalyticsShown',
         'IsAcceptUserInfo' => 'IsAcceptUserInfo',
         'IsEnableNotification' => 'IsEnableNotification',
         'ShowDerivative'=>'ShowDerivative',
         'BrandLogo' => 'BrandLogo',
         'BrandName' => 'BrandName',
         'IsBranded' => 'IsBranded',
     );
         
     }

     public function saveSurvey($FormModel,$NetworkId,$UserId){
         try{             
             $returnValue = "failed";
             $survey = new ExtendedSurveyCollection();
             $survey->Questions = $FormModel->Questions;
             $survey->SurveyTitle = $FormModel->SurveyTitle;
             $survey->SurveyDescription = $FormModel->SurveyDescription;
             $survey->CreatedBy = $FormModel->CreatedBy;
             $survey->QuestionsCount = (int) $FormModel->QuestionsCount;
             $survey->CreatedUserId = $UserId;
             $survey->UserId = (int) $UserId;
             $survey->NetworkId = (int) $NetworkId;
             $survey->SurveyLogo = $FormModel->SurveyLogo;
             $survey->CreatedOn = new MongoDate(strtotime(date('Y-m-d', time())));
             $survey->IsBannerVisible = (int) $FormModel->IsBannerVisible;
             $survey->IsAnalyticsShown = (int) $FormModel->IsAnalyticsShown;
             $survey->IsAcceptUserInfo = (int) $FormModel->IsAcceptUserInfo;
             $survey->IsEnableNotification = (int) $FormModel->IsEnableNotification;             
             $survey->ShowDerivative = (int) $FormModel->ShowDerivative;
             $survey->IsBranded = (int) $FormModel->IsBranded;
             $survey->BrandLogo = $FormModel->BrandLogo;
             $survey->BrandName = $FormModel->BrandName;

             /*if($FormModel->SurveyRelatedGroupName == "other"){
                 $survey->SurveyRelatedGroupName = $FormModel->SurveyOtherValue;
                 ExSurveyResearchGroup::model()->saveNewGroupName($FormModel->SurveyOtherValue,$UserId,$FormModel->SurveyLogo);
             }else{
                 $survey->SurveyRelatedGroupName = $FormModel->SurveyRelatedGroupName;
             }*/
             ExSurveyResearchGroup::model()->saveNewGroupName($FormModel->SurveyTitle,$UserId,$FormModel->SurveyLogo);
             if($survey->save()){
                 $returnValue = "success";
             }
             return $returnValue;
         } catch (Exception $ex) {
             Yii::log("ExtendedSurveyCollection:saveSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             error_log("Exception Occurred in ExtendedSurveyCollection->saveSurvey==".$ex->getMessage());
         }
     }
  public function SaveGame($Gameobj){
      try {    
          $returnValue = 'failure';
          if($Gameobj->save()){
              
              $returnvalue=$Gameobj->_id;
          }
          return  $returnvalue;
          
      } catch (Exception $ex) {
          Yii::log("ExtendedSurveyCollection:SaveGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in ExtendedSurveyCollection->SaveGame==".$ex->getMessage());
      }
    }
      /**
     * @author Vamsi Krishna
     * This method is used to  get Game Details By id
     * @param type $postId
     * @param string $actionType
     * @return string
     */
 public function getGameDetailsByType($type,$value){
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
         }elseif ($type=='MigratedGameId') {
                $criteria->addCond('MigratedGameId', '==', $value);
            }  
         $gameObj=GameCollection::model()->findAll($criteria);
            if(is_array($gameObj) || is_object($gameObj) ){
                $returnValue=$gameObj;
            }
            return $returnValue;
     } catch (Exception $ex) {
         Yii::log("ExtendedSurveyCollection:getGameDetailsByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
   /**
     * @author Vamsi Krishna
     * 
     * @param type $postId
     * @param string $actionType
     * @return string
     */
   public function getGameDetailsObject($type,$value){
     try {
                  
          $returnValue = 'failure';
          $criteria = new EMongoCriteria;
         if($type=='Id'){
             $criteria->addCond('_id', '==', new MongoID($value));
         }if($type=='GameName'){
             $value = str_replace("%20", " ", $value);
             $criteria->addCond('GameName', '==', $value);
         }         
          if($type=='IsCurrentSchedule'){
             $criteria->addCond('IsCurrentSchedule', '==', $value);
         }  
                 
         $gameObj=GameCollection::model()->find($criteria);
            if(is_array($gameObj) || is_object($gameObj) ){
                $returnValue=$gameObj;
            }
            return $returnValue;
     } catch (Exception $ex) {         
         Yii::log("ExtendedSurveyCollection:getGameDetailsObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
    
     /**
     * @author Vamsi Krishna
     * @param type $postId
     * @return type
     */
    public function getGamePostObjectFollowers($postId) {

        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('GamesFollowers' => true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = GameCollection::model()->find($criteria);
            if (isset($objFollowers->Followers)) {
                $returnValue = $objFollowers->Followers;
            }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getGamePostObjectFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    /**
     * @author Vamsi Krishna copied from Group Collection by Sagar 
     * @param type $postId
     * @return 
     */
    public function getInvitedUsersForPost($postId) {

        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('Invite' => true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $objFollowers = GameCollection::model()->find($criteria);
            if (isset($objFollowers->Invite)) {
                $returnValue = $objFollowers->Invite;
            }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getInvitedUsersForPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        return $returnValue;
    }
   /**
     * this method is used for save invites for group psot
     * @autho Vamsi Krishna
     * @param type $UserId
     * @param type $PostId
     * @param type $InviteText
     * @param type $Mentions
     * @return string
     */
    public function saveInvites($UserId, $PostId, $InviteText, $Mentions) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $inviteArray = array();
            array_push($inviteArray, (int) $UserId);
            array_push($inviteArray, array_unique($Mentions));
            array_push($inviteArray, $InviteText);
            $mongoModifier->addModifier('Invite', 'push', $inviteArray);
            $mongoCriteria->addCond('_id', '==', new MongoID($PostId));
            $return = GameCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:saveInvites::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author Vamsi Krishna
     * @Description this method is to get the comments for post
     * @param type $postId
     * @return success=> array failure=>String
     */
    
  public function getGameCommentsByPostId($postId){
    try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
          //  $criteria->setSelect(array('Comments='=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = GameCollection::model()->find($criteria);   
            if (isset($postObj->Comments)) {
                $returnValue =$postObj->Comments;
                }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getGameCommentsByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }  
  }
  
    public function UpdateGame($gameId,$Gameobj) {
        try {
            $returnValue = 'failure';

            $modifier = new EMongoModifier();
            $criteria = new EMongoCriteria();
                $criteria->addCond('_id', '==', new MongoID($gameId));
                    $criteria->addCond('Questions.QuestionId', '==', new MongoID($Gameobj->QuestionId));
                    $modifier->addModifier('Questions.$.Question', 'set', $Gameobj->Question);
                    $modifier->addModifier('Questions.$.QuestionDisclaimer', 'set', $Gameobj->QuestionDisclaimer);
                    $modifier->addModifier('Questions.$.OptionA', 'set', $Gameobj->OptionA);
                    $modifier->addModifier('Questions.$.OptionADisclaimer', 'set', $Gameobj->OptionADisclaimer);
                    $modifier->addModifier('Questions.$.OptionB', 'set', $Gameobj->OptionB);
                    $modifier->addModifier('Questions.$.OptionBDisclaimer', 'set', $Gameobj->OptionBDisclaimer);
                    $modifier->addModifier('Questions.$.OptionC', 'set', $Gameobj->OptionC);
                    $modifier->addModifier('Questions.$.OptionCDisclaimer', 'set', $Gameobj->OptionCDisclaimer);
                    $modifier->addModifier('Questions.$.OptionD', 'set', $Gameobj->OptionD);
                    $modifier->addModifier('Questions.$.OptionDDisclaimer', 'set', $Gameobj->OptionDDisclaimer);
                    $modifier->addModifier('Questions.$.Position', 'set', $Gameobj->Position);
                    $modifier->addModifier('Questions.$.Points', 'set', $Gameobj->Points);
                    $modifier->addModifier('Questions.$.QuestionImage', 'set', $Gameobj->QuestionImage);
                     $modifier->addModifier('Questions.$.Resources', 'set', $Gameobj->Resources);
                GameCollection::model()->updateAll($modifier, $criteria);
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:UpdateGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
     public function UpdateGameQuestions($gameId,$Gameobj) {
        try {
            $returnValue = 'failure';

            $modifier = new EMongoModifier();
            $criteria = new EMongoCriteria();
            $QuestionsArray = array();
                $QuestionsArray['QuestionId']=$Gameobj->QuestionId;
                $QuestionsArray['Question']=$Gameobj->Question;
                $QuestionsArray['QuestionDisclaimer'] = $Gameobj->QuestionDisclaimer;
                $QuestionsArray['OptionA'] = $Gameobj->OptionA;
                $QuestionsArray['OptionADisclaimer'] = $Gameobj->OptionADisclaimer;
                $QuestionsArray['OptionB'] = $Gameobj->OptionB;
                $QuestionsArray['OptionBDisclaimer'] = $Gameobj->OptionBDisclaimer;
                $QuestionsArray['OptionC'] = $Gameobj->OptionC;
                $QuestionsArray['OptionCDisclaimer'] = $Gameobj->OptionCDisclaimer;
                $QuestionsArray['OptionD'] = $Gameobj->OptionD;
                $QuestionsArray['OptionDDisclaimer'] = $Gameobj->OptionDDisclaimer;
                $QuestionsArray['Points'] = $Gameobj->Points;
                $QuestionsArray['Position'] = (int)$Gameobj->Position;
                $QuestionsArray['QuestionImage']= $Gameobj->QuestionImage;
                $QuestionsArray['CorrectAnswer'] = $Gameobj->CorrectAnswer;
                $QuestionsArray['Resources'] = $Gameobj->Resources;
            
            $criteria->addCond('_id', '==', new MongoID($gameId));
            $modifier->addModifier('Questions', 'push', $QuestionsArray);
            if(GameCollection::model()->updateAll($modifier, $criteria)){
                
                $returnValue="success";
            }
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:UpdateGameQuestions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function UpdateGameDetails($Gameobj) {
        try {
            $returnValue = 'failure';

            $modifier = new EMongoModifier();
            $criteria = new EMongoCriteria();
          $criteria->addCond('_id', '==', new MongoID($Gameobj->GameId));
          $modifier->addModifier('GameDescription', 'set', $Gameobj->GameDescription);
          $modifier->addModifier('GameName', 'set', $Gameobj->GameName);
          $modifier->addModifier('GameBannerImage', 'set', $Gameobj->GameBannerImage);
          $modifier->addModifier('QuestionsCount', 'set', count($Gameobj->Questions));
          
            if(GameCollection::model()->updateAll($modifier, $criteria)){
                
                $returnValue="success";
            }
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:UpdateGameDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    



  /**
     * @author Sagar Pathapelli
     * @Description promote the post
     * @param type $postId
     * @param type $userId
     * @param type $promoteDate
     * @param type $categoryId
     * @param type $networkId
     * @return string
     */
    public function promoteGame($postId, $userId, $promoteDate) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('IsPromoted', 'set', 1);
            $mongoModifier->addModifier('PromotedUserId', 'set', (int) $userId);
            $mongoModifier->addModifier('PromotedDate', 'set', new MongoDate(strtotime($promoteDate)));
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $returnValue = GameCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:promoteGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   /**
     * @author Vamsi Krishna
     * @param type $userId
     * @param type $postId
     * @return string
     */
    public function markGameAsFeatured($postId, $userId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;            
            $mongoModifier->addModifier('IsFeatured', 'set', 1);
            $mongoModifier->addModifier('FeaturedUserId', 'set', (int) $userId);
            $mongoModifier->addModifier('FeturedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $return = GameCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:markGameAsFeatured::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * @author Sagar Pathapelli
     * @param type $postId
     * @return string
     */
    public function deletePost($postId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('IsDeleted', 'set', 1);
            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            $returnValue = GameCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:deletePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function isUserCommented($userId,$gameId){
        try {
             $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('_id', '==', new MongoId($gameId));
             $mongoCriteria->addCond('Comments.UserId', '==', (int)$userId);
            $returnValue = GameCollection::model()->find($mongoCriteria);
            if(is_object($returnValue)){
                return "exist";
            }else{
                return "notexist";
            }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:isUserCommented::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    } 

 /**
     * @author Vamsi Krishna
     * @Description this method is to get the comments for post
     * @param type $postId
     * @return success=> array failure=>String
     */
    public function getPostCommentsByPostId($postId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            //    $criteria->setSelect(array('Comments='=>true));
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = GameCollection::model()->find($criteria);
            if (isset($postObj->Comments)) {
                $returnValue = $postObj->Comments;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getPostCommentsByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function updateSurveyForIsCurrentSchedule($type,$value,$_id) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if($type == "IsCurrentSchedule")
            $mongoModifier->addModifier('IsCurrentSchedule', 'set', (int) 0);
           if($type == "CurrentScheduleId")
               if($value!=""){
                    $mongoModifier->addModifier('CurrentScheduleId', 'set',new MongoId($value));
               }
            
            $mongoCriteria->addCond('_id', '==', new MongoId($_id));
            if(ExtendedSurveyCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:updateSurveyForIsCurrentSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function UpdateGameFields($gameId,$Gameobj,$Fieldvalue) {
        try {
            $returnValue = 'failure';
            $modifier = new EMongoModifier();
            $criteria = new EMongoCriteria();
            $criteria->addCond('_id', '==',new MongoId($gameId));
            $modifier->addModifier($Gameobj, 'set', $Fieldvalue);
            if(GameCollection::model()->updateAll($modifier, $criteria)){
                $returnValue=$Fieldvalue;
                
            }
            
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:UpdateGameFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

  public function getAllGames(){
      try {
          $returnValue = 'failure';
          $criteria = new EMongoCriteria;
                 
         
             $criteria->addCond('IsDeleted', '==', 0);
       
         $gameObj=GameCollection::model()->findAll($criteria);
            if(is_array($gameObj) || is_object($gameObj) ){
                $returnValue=$gameObj;
            }
            return $returnValue;
     } catch (Exception $ex) {
        Yii::log("ExtendedSurveyCollection:getAllGames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');

     }
    }
    public function getGameTotalPoints($gameId){
        try {
        $criteria = new EMongoCriteria;
        if($gameId!="AllGames"){
            $criteria->_id= new MongoId($gameId); 
        }
          $games=GameCollection::model()->findAll($criteria); 
          $gameTotalPoints=0;
          foreach($games as $game){
              $questions = $game->Questions;
              foreach ($questions as $question) {
                    $gameTotalPoints = $gameTotalPoints + $question['Points']; 
              }
          }
          return $gameTotalPoints;
        } catch (Exception $ex) {
           Yii::log("ExtendedSurveyCollection:getGameTotalPoints::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
         
    }
    public function getAllGamesForAnalytics(){
      try {
          $returnValue = 'failure';
         // $criteria = new EMongoCriteria;
          //$criteria->addCond('IsDeleted', '==', 0);
       
         $gameObj=GameCollection::model()->findAll();
            if(is_array($gameObj) || is_object($gameObj) ){
                $returnValue=$gameObj;
            }
            return $returnValue;
     } catch (Exception $ex) {
         Yii::log("ExtendedSurveyCollection:getAllGamesForAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
    }
 public function getGameName($id){
     try {
          $returnValue = 'failure';
          $criteria = new EMongoCriteria;
          $criteria->setSelect(array('GameName'=>true));
          $criteria->addCond('_id', '==', new MongoID($id));
          $gameObj=GameCollection::model()->find($criteria);
            if(is_array($gameObj) || is_object($gameObj) ){
                $returnValue=$gameObj;
            }
            return $returnValue->GameName;
     } catch (Exception $ex) {         
         Yii::log("ExtendedSurveyCollection:getGameName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }

    public function getPostById($postId) {
        try {
            
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = GameCollection::model()->find($criteria);
            if (is_object($postObj)) {
                $returnValue = $postObj;
            }
//            echo "ingamecollection";
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getPostById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

 

       public function isCurrentScheduleSurvey($surveyId) {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;

            $criteria->addCond('_id', '==', new MongoId($surveyId));
            $criteria->addCond('IsCurrentSchedule', '==', (int) 1);
            return ExtendedSurveyCollection::model()->find($criteria);
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:isCurrentScheduleSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function suspendORReleaseSurvey($surveyId,$suspendFlag) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('IsCurrentSchedule', 'set', (int) 0);
            $mongoModifier->addModifier('IsDeleted', 'set', (int) $suspendFlag);
            $mongoCriteria->addCond('_id', '==', new MongoId($surveyId));
            if(ExtendedSurveyCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:suspendORReleaseSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->suspendORReleaseSurvey==".$ex->getMessage());
        }
    }
    
        /**
     * @author karteek.v
     * @param type $postIdsArray
     * @return array
     */
    public function getPreparedDataByGameId($postIdsArray) {
        try {
            $postIdsArray = array_unique($postIdsArray);
            $returnValue = array();// only one time it will be flushed
            $i =0;            
            foreach ($postIdsArray as $rw) {
                $returnArr = array(); // each and every iteration it will be flushed
                $postObj = $this->getPostById($rw);
                if (sizeof($postObj)>0) {
                        foreach ($postObj->_id as $rw1) {
                            $returnArr['PostId'] = $rw1;                            
                        }
                        $returnArr['LoveUserId'] = $postObj->UserId;
                        $returnArr['Description'] = $postObj->GameDescription;
                        $returnArr['LoveCount'] = count($postObj->Love);
                        $count = 0;
                        foreach ($postObj->Comments as $key=>$value) {
                            if (!(isset($value ['IsBlockedWordExist']) && $value ['IsBlockedWordExist']==1)) {
                                $count++;
                            }
                        }
                        $returnArr['CommentCount'] =$count;
                        $returnArr['FollowCount'] = count($postObj->Followers);
                        array_push($returnValue, $returnArr);
//                    }
                }
            }// updating stream collection
            $this->updateStreamPostCountsFromNodeRequest($returnValue);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getPreparedDataByGameId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * @author Karteek.V
     * @param type $streamCountArray
     * Method is used to update the social actions
     * @return void
     */
    public function updateStreamPostCountsFromNodeRequest($streamCountArray){
        try{
            foreach($streamCountArray as $mrow){
                $userStreamObj = new UserStreamBean();
                $userStreamObj->LoveUserId = $mrow['LoveUserId'];
                $userStreamObj->PostId = $mrow['PostId'];
                $userStreamObj->LoveCount = $mrow['LoveCount'];
                $userStreamObj->CommentCount = $mrow['CommentCount'];
                $userStreamObj->FollowCount = $mrow['FollowCount'];
                $result = UserStreamCollection::model()->isThereByUserId($userStreamObj);
                echo $result;
                if(!$result){                    
                    UserStreamCollection::model()->updateStreamSocialActions($userStreamObj);
                }                
            }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:updateStreamPostCountsFromNodeRequest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->updateStreamPostCountsFromNodeRequest==".$ex->getMessage());
        }
    }
    public function UpdateGameResources($gameId,$Resources){
        try{
        $returnValue = 'failure';
        $mongoCriteria = new EMongoCriteria;
        $mongoModifier = new EMongoModifier;
        $mongoModifier->addModifier('Resources', 'set',$Resources);
        $mongoCriteria->addCond('_id', '==', new MongoId($gameId));
        $returnValue = GameCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        return 'success';
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:UpdateGameResources::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getSurveyDetailsById($columnName, $value) {
        try {
            
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            if ($columnName == 'Id') {
                
                $criteria->addCond('_id', '==', new MongoId($value));
            }else if ($columnName == 'GroupName') {
                
                $criteria->addCond('SurveyTitle', '==', $value);
            }
            
            $surveyObj = ExtendedSurveyCollection::model()->find($criteria);
            if (is_array($surveyObj) || is_object($surveyObj)) {
                $returnValue = $surveyObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getSurveyDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->getSurveyDetailsById==".$ex->getMessage());
        }
    }
    
    public function CheckQuestionExist($_id,$questionId){
        
        try{
            $returnvalue='failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($_id));
            $criteria->addCond('Questions.QuestionId', '==', new MongoID($questionId));
            $Question = ExtendedSurveyCollection::model()->find($criteria);
            if(count($Question)>0){
                $returnvalue= true;
            }
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:CheckQuestionExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->CheckQuestionExist==".$ex->getMessage());
        }
        
    }
    
    public function UpdateSurvey($_id,$model) {
        try {
            
            $returnValue = 'failure';            
            $modifier = new EMongoModifier();
            $criteria = new EMongoCriteria();
            $criteria->addCond('_id', '==', new MongoId($_id));
            $modifier->addModifier('SurveyTitle', 'set', $model->SurveyTitle);
            $modifier->addModifier('SurveyDescription', 'set', $model->SurveyDescription);
            $modifier->addModifier('SurveyRelatedGroupName', 'set', $model->SurveyRelatedGroupName);
            $modifier->addModifier('SurveyLogo', 'set', $model->SurveyLogo);            
            $modifier->addModifier('IsBannerVisible', 'set', (int) $model->IsBannerVisible);
            $modifier->addModifier('IsAnalyticsShown', 'set', (int) $model->IsAnalyticsShown);
            $modifier->addModifier('IsAcceptUserInfo', 'set', (int) $model->IsAcceptUserInfo);
            $modifier->addModifier('QuestionsCount', 'set', (int) $model->QuestionsCount);
            $modifier->addModifier('IsEnableNotification', 'set', (int) $model->IsEnableNotification);
            $modifier->addModifier('ShowDerivative', 'set', (int) $model->ShowDerivative);
//                    $criteria->addCond('Questions.QuestionId', '==', new MongoID($obj->QuestionId));
            $modifier->addModifier('Questions', 'set', $model->Questions);
            $modifier->addModifier('IsBranded', 'set', (int) $model->IsBranded);  
            $modifier->addModifier('BrandLogo', 'set', $model->BrandLogo);  
            $modifier->addModifier('BrandName', 'set', $model->BrandName);  
            if(ExtendedSurveyCollection::model()->updateAll($modifier, $criteria)){
                $returnvalue = "success";
            }
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:UpdateSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->UpdateSurvey==".$ex->getMessage());
        }
    }
    
    public function getSurveyDetailsObject($type,$value){
     try {
                  
          $returnValue = 'failure';
          $criteria = new EMongoCriteria;
         if($type=='Id'){
             $criteria->addCond('_id', '==', new MongoId($value));
         }else if($type=='IsCurrentSchedule'){
             $criteria->addCond('IsCurrentSchedule', '==', $value);
         }  
         $surveyObj = array();     
         $surveyObj=  ExtendedSurveyCollection::model()->find($criteria);
            if(is_array($surveyObj) || is_object($surveyObj) ){
                $returnValue = $surveyObj;
            }
            return $returnValue;
     } catch (Exception $ex) {         
         Yii::log("ExtendedSurveyCollection:getSurveyDetailsObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         error_log("Exception Occurred in ExtendedSurveyCollection->getSurveyDetailsObject==".$ex->getMessage());
     }
  }
  
  public function getSurveyDetailsByGroupName($columnName, $value) {
        try {
            
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('SurveyRelatedGroupName', '==', $value);
            $criteria->addCond('IsDeleted', '==', (int) 0);

            $surveyObj = ExtendedSurveyCollection::model()->findAll($criteria);
            if (is_array($surveyObj) || is_object($surveyObj)) {
                $returnValue = $surveyObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getSurveyDetailsByGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->getSurveyDetailsByGroupName==".$ex->getMessage());
        }
    }
    
    public function getSurveyAnalyticsData($pageLength,$offset,$searchText,$filterValue){
        try{
            $searchText = trim($searchText);
            $result = array();
            $searcha = array();
            $totalArray = array();
            $filtAr = array();
            if(!empty($searchText)){
                $searcha =  array('eq' => new MongoRegex('/' . $searchText . '.*/i'));
            }
//            if(!empty($filterValue)){
//                if($filterValue != "all")
//                    $filtAr = array('==',(int) 1);
//            }            
            $array = array(
                'conditions' => array(
                   'SurveyTitle' => $searcha,
                   //'IsDeleted' => $filtAr,               
                ),

                'limit' => $pageLength,
                'offset' => $offset,
                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
            );
             $result = ExtendedSurveyCollection::model()->findAll($array);
             foreach($result as $data){
                 $surveyBean = new SurveyAnalyticsDataBean;
                 $surveyTitle= strip_tags(($data->SurveyTitle));                 
                 $textLength =  strlen($surveyTitle);
                 if($textLength>240){
                    $data->SurveyTitle =  CommonUtility::truncateHtml($data->SurveyTitle, 240,'Read more',true,true,' <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i>'); 
                    $data->SurveyTitle = $data->SurveyTitle;
                    
                 }
                 $surveyBean->SurveyTitle = $data->SurveyTitle;
                 $textLength =  strlen($data->SurveyDescription);
                 $surveyDesc = strip_tags(($data->SurveyDescription));  
                 if($textLength>240){
                    $data->SurveyDescription =  CommonUtility::truncateHtml($data->SurveyDescription, 240,'Read more',true,true,' <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i>');                     
                 }
                 $surveyBean->SurveyDescription = $data->SurveyDescription;
                 $surveyBean->SurveyRelatedGroupName = $data->SurveyRelatedGroupName;
                 $surveyBean->QuestionsCount = $data->QuestionsCount;
                 
                 $criteria = new EMongoCriteria;
                 $criteria->addCond("SurveyId","==",new MongoId($data->_id));
                 $scheduleObj = ScheduleSurveyCollection::model()->find($criteria);
//                 foreach($scheduleObj as $rw){
//                     
//                 }
                 $surveyBean->StartDate = $scheduleObj->StartDate;
                 $surveyBean->EndDate = $scheduleObj->EndDate;
            
//                 break;
                 $surveyBean->SurveyId = $data->_id;
                 $surveyBean->ScheduleId = $scheduleObj->_id;
                 $surveyBean->IsCurrentSchedule = $scheduleObj->IsCurrentSchedule;
                 $surveyBean->SurveyedUsersCount = sizeof($scheduleObj->SurveyTakenUsers);
                 array_push($totalArray,$surveyBean);
            }
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getSurveyAnalyticsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->getSurveyAnalyticsData==".$ex->getMessage());
        }
        return $totalArray;
    }
    
    public function getSurveyAnalyticsDataCount($filterValue,$searchText){
        try{
            $searchText = trim($searchText);
            $result = array();
            $searcha = array();
            $filtAr = array();
            if(!empty($searchText)){
                $searcha =  array('eq' => new MongoRegex('/' . $searchText . '.*/i'));
            }
//            if(!empty($filterValue)){
//                if($filterValue != "all")
//                    $filtAr = array('==',(int) 1);
//            }            
            $array = array(
                'conditions' => array(
                   'SurveyTitle' => $searcha,
                   //'IsDeleted' => $filtAr,               
                ),

                'limit' => $pageLength,
                'offset' => $offset,
                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
            );
             $result = ExtendedSurveyCollection::model()->count($array);
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getSurveyAnalyticsDataCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->getSurveyAnalyticsDataCount==".$ex->getMessage());
        }
        return $result;
    }
    
public function getQuestionOfSurvey($surveyId,$questionId){
    try{
         $c = ExtendedSurveyCollection::model()->getCollection();
    $result = $c->aggregate(array('$match' => array('_id' =>new MongoID($surveyId))),array('$unwind' =>'$Questions'),array('$match' => array('Questions.QuestionId' =>new MongoID($questionId))));   
        $question = $result['result'][0]["Questions"];
   return $question;
    } catch (Exception $ex) {
        Yii::log("ExtendedSurveyCollection:getQuestionOfSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        error_log("Exception Occurred in ExtendedSurveyCollection->getQuestionOfSurvey==".$ex->getMessage());
    }
}
 public function getSurveyListByGroupName($groupName) {
        try {
            
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('SurveyRelatedGroupName', '==', $groupName);

            $surveyObj = ExtendedSurveyCollection::model()->findAll($criteria);
            if (is_array($surveyObj) || is_object($surveyObj)) {
                $returnValue = $surveyObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getSurveyListByGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->getSurveyDetailsByGroupName==".$ex->getMessage());
        }
    }
    
    public function updateSurveyBrands($id,$blogo,$bname){
        try{
            $returnvalue = "failure";
            $criteria = new EMongoCriteria;
            $modifier = new EMongoModifier();
            $criteria->addCond('_id', '==', new MongoId($id));
            $modifier->addModifier("BrandLogo", "set", $blogo);
            $modifier->addModifier("BrandName", "set", $bname);
            if(ExtendedSurveyCollection::model()->updateAll($modifier, $criteria)){
                $returnvalue = "success";
            }
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:updateBrands::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->updateBrands==".$ex->getMessage());
        }
    }

    
    /*
     * @praveen get Total questions for category start
    */
    public function getTotalQuestions($value) {
        try {
            
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('SurveyTitle', '==', trim($value));
            //$criteria->addCond('Questions.IsSuspended', '==', NumberLong(0));

            $surveyObj = ExtendedSurveyCollection::model()->findAll($criteria);
            error_log("-------".$value."----");
            if (is_array($surveyObj) || is_object($surveyObj)) {
                $returnValue = $surveyObj;
            }
            //error_log("-------".$value."--ss--".print_r($surveyObj,true));
            
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:getSurveyDetailsByGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->getSurveyDetailsByGroupName==".$ex->getMessage());
        }
    }
    /*
     * @praveen get Total questions for category end
    */
    /*
     * @praveen get technical questions for category start
    */
    public function getOtherQuestionsCount($_id){
        $c = ExtendedSurveyCollection::model()->getCollection();
        //$result = $c->aggregate(array('$match' => array('_id' =>new MongoID($_id))),array('$unwind' =>'$Questions'),array('$match' => array('Questions.Other' =>1)),array('$group' => array("_id" => '$_id',"SuspendedQuestions" => array('$push' => '$Questions.IsSuspended'))));   
        $result = $c->aggregate(array('$match' => array('_id' =>new MongoID($_id))),array('$unwind' =>'$Questions'),array('$match' => array('Questions.IsReviewed' =>1)),array('$group' => array("_id" => '$_id',"SuspendedQuestions" => array('$push' => '$Questions.IsSuspended'))));   
        $questionsArray = $result['result'];
        $re = 0;
            foreach($questionsArray as $res){
                $re = sizeof($res['SuspendedQuestions']);
             }
            return $re;
    }
    /*
     * @praveen get technical questions for category end
    */ 
    

        public function getSuspendedQuestionsCount($_id) {
        try {
            $c = ExtendedSurveyCollection::model()->getCollection();
            $result = $c->aggregate(array('$match' => array('_id' => new MongoID($_id))), array('$unwind' => '$Questions'), array('$match' => array('Questions.IsSuspended' => 1)), array('$group' => array("_id" => '$_id', "SuspendedQuestions" => array('$push' => '$Questions.IsSuspended'))));
            $questionsArray = $result['result'];
            $re = 0;
            foreach ($questionsArray as $res) {

                $re = sizeof($res['SuspendedQuestions']);
            }
            return $re;
        } catch (Exception $ex) {
            Yii::log("TestPreparationCollection:getTestDetails::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TestPreparationCollection->getTestDetails==" . $ex->getMessage());
        }
    }

    public function getCategoryDetails($catname,$catquestions,$offset=0) {
        try {
//            $questioncriteria = new EMongoCriteria;
//            $questioncriteria->addCond('SurveyTitle', '==', $catname);            
//            $questionsobj = ExtendedSurveyCollection::model()->find($questioncriteria);
            $pageLimit = $catquestions*4;
            
            $c = ExtendedSurveyCollection::model()->getCollection();
            $result = $c->aggregate(array('$match' => array('SurveyTitle' => "$catname")),array('$unwind' =>'$Questions'),array('$skip' => $offset),array('$limit' => $pageLimit),array('$group' => array("_id" => '$_id',"Questions" => array('$push' => '$Questions'))));   
            //error_log("=1111111111111=====getCategoryDetails==result=====".print_r($result,1));
            $returnarray = array();
            $returnarray['result'] = $result['result']; 
            $returnarray['offset'] = $offset+$pageLimit;
            return $returnarray;
        } catch (Exception $ex) {
            Yii::log(" ExtendedSurveyCollection:getCategoryDetails::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in  ExtendedSurveyCollection->getCategoryDetails==" . $ex->getMessage());
        }
    }
    
    public function getQuestionById($catId,$qid){
        try{
        $qstncriteria = new EMongoCriteria;
        $qstncriteria->addCond('_id', '==', new MongoId($catId));
        $qstncriteria->addCond('Questions.QuestionId', '==', new MongoId($qid));
        $questionobj = ExtendedSurveyCollection::model()->find($qstncriteria);
        $c = ExtendedSurveyCollection::model()->getCollection();
        $result = $c->aggregate(array('$match' => array('SurveyTitle' => $questionobj->SurveyTitle)), array('$unwind' => '$Questions'), array('$match' => array('Questions.QuestionId' => new MongoID($qid))), array('$group' => array("_id" => "_id", "Question" => array('$push' => '$Questions'))));
        $returnarray = array();
        $surveyobj = new ExtendedSurveyCollection;
        $surveyobj->SurveyTitle = $questionobj->SurveyTitle;
        $surveyobj->_id = $questionobj->_id;
        $surveyobj->SurveyDescription = $questionobj->SurveyDescription;
        $surveyobj->SurveyLogo = $questionobj->SurveyLogo;
        $surveyobj->IsMadatory = $questionobj->IsMadatory;        
        foreach($result as $rw){
            error_log("======result=========".print_r($rw[0]['Questions'][0],1));
            if(sizeof($rw[0])>0)
                $surveyobj->Questions = $rw[0]['Question'];
        }
      //  error_log("---".print_r($surveyobj->Questions,1));
        return $surveyobj;
        } catch (Exception $ex) {
             Yii::log(" ExtendedSurveyCollection:getQuestionById::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in  ExtendedSurveyCollection->getQuestionById==" . $ex->getMessage());
        }
    }
    
    public function getAnswersByQuestionId($catId,$qId){
        try{
            error_log("=@@@@@@@@@@@@@@@@@@@@==categoryId==$catId===questionId===$qId==");
            $c = ExtendedSurveyCollection::model()->getCollection();
            $result = $c->aggregate(array('$match' => array('_id' => new MongoID($catId))), array('$unwind' => '$Questions'), array('$match' => array('Questions.QuestionId' => new MongoId($qId))), array('$group' => array("_id" => '$_id', "QAnswers" => array('$push' => '$Questions.Answers'))));
            error_log("===getAnswersByQuestionId=Result====".print_r($result['result'][0]['QAnswers'][0],1));
            return isset($result['result'][0]['QAnswers'][0])?$result['result'][0]['QAnswers'][0]:array();
        } catch (Exception $ex) {

        }
    }

}
