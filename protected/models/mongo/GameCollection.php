<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class GameCollection extends EMongoDocument {
     public $_id;
     public $GameName;
     public $GameDescription;
     public $Status;
     public $GameAdminUser;
     public $QuestionsCount=0;
     public $CreatedOn;
     public $UserId;
     public $Love=array();
     public $Share=array();     
     public $LastUpdatedBy;
     public $IsCurrentSchedule=0;
     public $PlayersCount=0;
     public $Players=array();
     public $GameBannerImage;
     public $GameHighestScore=0;
     public $HighestScoreUserId=0;
     public $CurrentScheduleId=0;
     
    public $Followers=array();
    public $Mentions=array();
    public $Comments=array();
    public $Resource=array();    
    public $HashTags=array();
    public $Invite=array(); 
    public $Type=12;
    public $Priority;    
    public $DisableComments = 0;
    public $IsAbused = 0; //0 - Default/Release, 1 - Abused, 2 - Blocked
    public $AbusedUserId;
    public $IsDeleted = 0;
    public $IsPromoted = 0;
    public $PromotedUserId;
    public $AbusedOn;
    public $IsBlockedWordExist = 0;
    public $IsFeatured = 0;
    public $FeaturedUserId;
    public $FeaturedOn;
    public $IsBlockedWordExistInComment = 0;
    public $IsWebSnippetExist = 0;
    public $WebUrls;
    public $Division = 0;
    public $District = 0;
    public $Region = 0;
    public $Store = 0;
    public $FbShare = array();
    public $TwitterShare = array();
    public $TopicImage='';
    public $Subject='';
    public $Questions=array();

    public $GameId; 

    public $Resources = array();

    public $CreatedBy=0;
    public $MigratedGameId = '';
    public $PromotedDate;
    public $IsCommentAbused=0;
    public $NetworkId = 1;
    public $SegmentId = 0;
    public $Language = 'en';
    public $IsAnonymous = 0;
    public $saveItForLaterUserIds = array();
    public $IsUseForDigest=0;
    public $IsSponsored;
    public $BrandName = "";
    public $BrandLogo = "";
    public $IsEnableSocialActions;

    public function getCollectionName() {
        return 'GameCollection';
    }
 public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
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
         'GameName'=>'GameName',
         'GameDescription'=>'GameDescription',
         'Status'=>'Status',
         'GameAdminUser'=>'GameAdminUser',
         'QuestionsCount'=>'QuestionsCount',
         "Questions"=>"Questions",
         "Players"=>'Players',
         'CreatedOn'=>'CreatedOn',
         'UserId'=>'UserId',

         'Followers'=>'Followers',
           

         'Love'=>'Love',
         'Share'=>'Share',
         'Invite'=>'Invite',
         'Comments'=>'Comments',         
         'LastUpdatedBy'=>'LastUpdatedBy',
         'IsCurrentSchedule'=>'IsCurrentSchedule',         
         'Questions'=>'Questions',
         'GameBannerImage'=>'GameBannerImage',
         'PlayersCount'=>'PlayersCount',
         'GameHighestScore'=>'GameHighestScore',
         'HighestScoreUserId'=>'HighestScoreUserId',
         'IsPromoted' => 'IsPromoted',
         'PromotedUserId' => 'PromotedUserId',
          'IsFeatured'=>'IsFeatured',
           'FeaturedUserId'=>'FeaturedUserId',
         'FeaturedOn'=>'FeaturedOn',

          'GameId'=>'GameId',
    
           'CurrentScheduleId' => 'CurrentScheduleId',
            'Resources' => 'Resources',
            'IsDeleted' => 'IsDeleted',
            'CreatedBy' => 'CreatedBy',
            'MigratedGameId' => 'MigratedGameId',
            'PromotedDate' => 'PromotedDate',
            'IsCommentAbused' => 'IsCommentAbused',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
            'saveItForLaterUserIds' => 'saveItForLaterUserIds',
         'IsUseForDigest'=>'IsUseForDigest',
         'BrandLogo' => 'BrandLogo',
         'BrandName'=>'BrandName',
         'IsSponsored'=>'IsSponsored',
         'IsEnableSocialActions' => 'IsEnableSocialActions',
        );

     }
     
  public function SaveGame($Gameobj){
      try {    
          $returnValue = 'failure';
          if($Gameobj->save()){
              
              $returnvalue=$Gameobj->_id;
          }
          return  $returnvalue;
          
      } catch (Exception $ex) {
          Yii::log("GameCollection:SaveGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in GameCollection->SaveGame==".$ex->getMessage());
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
         Yii::log("GameCollection:getGameDetailsByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            // $value = str_replace("%20", " ", $value);
             //$value = str_replace("%27", "'", $value);
             $value = urldecode($value);
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
         Yii::log("GameCollection:getGameDetailsObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
   /**
     * @author Vamsi Krishna
     * This method is used to  save the comment
     * @param type $postId
     * @param string $actionType
     * @return string
     */
  public function followOrUnfollowGame($gameId, $userId, $actionType){
      
        try
        {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow') {
                $mongoModifier->addModifier('Followers', 'push', $userId);
                $mongoCriteria->addCond('Followers', '!=', (int)$userId);
            } else if($actionType == 'UnFollow'){
                $mongoModifier->addModifier('Followers', 'pull', $userId);
            }

            $mongoCriteria->addCond('_id', '==', new MongoId($gameId));
            $returnValue = GameCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("GameCollection:followOrUnfollowGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
  
   /**
     * @author Vamsi Krishna
     * @param type $postId
     * @param type $userId
     * @return string
     */
  public function loveGame($gameId, $userId){
      try {
           
            $returnValue=FALSE;
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Love', 'push', (int) $userId);
            $mongoCriteria->addCond('_id', '==', new MongoId($gameId));
            $mongoCriteria->addCond('Love', '!=', (int) $userId);
            if(GameCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue=TRUE;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GameCollection:loveGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return FALSE;
        }
  }
     /**
     * @author Vamsi Krishna
     * This method is used to  save the comment
     * @param type $postId
     * @param string $actionType
     * @return string
     */
   public function saveComment($gameId, $comments) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Comments', 'push', $comments);
            $mongoCriteria->addCond('_id', '==', new MongoId($gameId));
            GameCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("GameCollection:saveComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
       /**
     * @author Vamsi Krishna
     * This method is used to  update Post When Comment is Abused/Blocked/Released
     * @param type $postId
     * @param string $actionType
     * @return string
     */
    public function updatePostWhenCommentAbused($postId, $actionType){
        try { 
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
             if($actionType=='Abuse'){
                 $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 1);
             }elseif ($actionType=="Block") {
                $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 2);
             }elseif ($actionType="Release") {
                $mongoModifier->addModifier('IsBlockedWordExistInComment', 'set', 0);
             }
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=GroupPostCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("GameCollection:updatePostWhenCommentAbused::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:getGamePostObjectFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:getInvitedUsersForPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:saveInvites::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:getGameCommentsByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:UpdateGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:UpdateGameQuestions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
          
          $modifier->addModifier('IsSponsored', 'set', (int) $Gameobj->IsSponsored);
          $modifier->addModifier('BrandName', 'set', $Gameobj->BrandName);
          $modifier->addModifier('BrandLogo', 'set', $Gameobj->BrandLogo);
          $modifier->addModifier('IsEnableSocialActions', 'set', (int) $Gameobj->IsEnableSocialActions);
          
            if(GameCollection::model()->updateAll($modifier, $criteria)){
                
                $returnValue="success";
            }
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("GameCollection:UpdateGameDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    

    public function CheckQuestionExist($gameId,$questionId){
        
        try{
            $returnvalue='failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($gameId));
            $criteria->addCond('Questions.QuestionId', '==', new MongoID($questionId));
            $Question = GameCollection::model()->find($criteria);
            if(count($Question)>0){
                $returnvalue='success';
            }
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("GameCollection:CheckQuestionExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:promoteGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function saveitforlaterPost($postId, $userId){
        try {          
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           
              $mongoModifier->addModifier('saveItForLaterUserIds', 'push', (int)$userId);
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=GameCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("GameCollection:saveitforlaterPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:markGameAsFeatured::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:deletePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:isUserCommented::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:getPostCommentsByPostId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function updateGameForIsCurrentSchedule($type,$value,$gameId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if($type == "IsCurrentSchedule")
            $mongoModifier->addModifier('IsCurrentSchedule', 'set', (int)$value);
            
           if($type == "CurrentScheduleId")
               if($value!=""){
             $mongoModifier->addModifier('CurrentScheduleId', 'set',new MongoId($value));
               }
            
            $mongoCriteria->addCond('_id', '==', new MongoId($gameId));
            $returnValue = GameCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("GameCollection:updateGameForIsCurrentSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:UpdateGameFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
         Yii::log("GameCollection:getAllGames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:getGameTotalPoints::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
         
    }
    public function getAllGamesForAnalytics($segmentId=0){
      try {
          $returnValue = 'failure';
          $criteria = new EMongoCriteria;
          if($segmentId!=0){
            $criteria->addCond('SegmentId', '==', (int)$segmentId);
          }
         $gameObj=GameCollection::model()->findAll($criteria);
            if(is_array($gameObj) || is_object($gameObj) ){
                $returnValue=$gameObj;
            }
            return $returnValue;
     } catch (Exception $ex) {
         Yii::log("GameCollection:getAllGamesForAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
         Yii::log("GameCollection:getGameName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GameCollection:getPostById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

 
       /**
     * @author suresh reddy
     * This method is used to  get Game Details By id
     * @param type $postId
     * @param string $actionType
     * @return string
     */
 public function isCurrentScheduleGame($gameId){
     try {
          $returnValue = 'failure';
    
           $criteria = new EMongoCriteria;

            $criteria->addCond('_id', '==', new MongoID($gameId));
            $criteria->addCond('IsCurrentSchedule', '==',(int) 1);

          //  $criteria->addCond('_id', '==', new MongoId($gameId));
            //GameCollection::model()->find($criteria);

            return GameCollection::model()->find($criteria);
     } catch (Exception $ex) {
         Yii::log("GameCollection:isCurrentScheduleGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }  
 public function suspendORReleaseGame($gameId,$suspendId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('IsCurrentSchedule', 'set', 0);
            $mongoModifier->addModifier('IsDeleted', 'set', $suspendId);
            $mongoCriteria->addCond('_id', '==', new MongoId($gameId));
            GameCollection::model()->updateAll($mongoModifier, $mongoCriteria);

            return "success";
        } catch (Exception $ex) {
            Yii::log("GameCollection:suspendORReleaseGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
                            $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
                            $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
                            if(!$IsBlockedWordExist && !$IsAbused){
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
            Yii::log("GameCollection:getPreparedDataByGameId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("GameCollection:updateStreamPostCountsFromNodeRequest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in GameCollection->actionIndex==".$ex->getMessage());
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
            Yii::log("GameCollection:UpdateGameResources::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getGamePostHashtagsById($postIdArray) {
        try {
            
            $returnValue = 'failure';
            $postsArray = array();

            for ($i = 0; $i < sizeof($postIdArray); $i++) {

                $criteria = new EMongoCriteria;
                $criteria->addCond('_id', '==', new MongoID($postIdArray[$i]));
                $postObj = GameCollection::model()->findAll($criteria);
                if (sizeof($postObj) > 0) {

                    foreach ($postObj as $post) {

                        $tagsFreeDescription = strip_tags(($post->GameDescription));
                        $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
                        $postLength = strlen($tagsFreeDescription);

                        if ($postLength > 240) {
                            $post->GameDescription = CommonUtility::truncateHtml($post->GameDescription, 240);
                            $post->GameDescription = $post->GameDescription . ' <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i>';
                        }

                        $user = UserCollection::model()->getTinyUserCollection($post->UserId);
                        array_push($postsArray, array($post, $user->DisplayName, "1"));
                    }
                }
            }

            return $postsArray;
        } catch (Exception $ex) {
            Yii::log("GameCollection:getGamePostHashtagsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getGamesForSearch($searchText, $offset, $pageLength) {
        try {

            $array = array(
                'conditions' => array(
                    'GameName' => array('or' => new MongoRegex('/' . $searchText . '.*/i')),
                    'Comments.CommentText' => array('or' => new MongoRegex('/' . $searchText . '.*/i')),
                    //'IsCurrentSchedule' => array("==" => (int) 1),
                    'IsDeleted' => array('!=' => (int) 1),
                ),
                'limit' => $pageLength,
                'offset' => $offset,
                'sort' => array('_id' => EMongoCriteria::SORT_DESC),
            );


            $posts = GameCollection::model()->findAll($array);            
            $postsArray = array();
            foreach ($posts as $post) {
                $schobj = ScheduleGameCollection::model()->getCurrentScheduleByScheduleId($post->_id);
                if(!empty($schobj)){                
                    $post->CreatedOn = $schobj->CreatedOn;
                }
                $tagsFreeDescription = strip_tags(($post->GameDescription));
                $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
                $postLength = strlen($tagsFreeDescription);

                if ($postLength > 240) {
                    $post->GameDescription = CommonUtility::truncateHtml($post->GameDescription, 240, 'Read more', true, true, ' <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i>');
                    $post->GameDescription = $post->GameDescription;
                }

                if (isset($post->UserId)) {
                    $user = UserCollection::model()->getTinyUserCollection($post->UserId);
                    array_push($postsArray, array($post, $user->DisplayName, "1"));
                }
            }
        } catch (Exception $ex) {
            Yii::log("GameCollection:getGamesForSearch::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in GameCollection->getGamesForSearch==".$ex->getMessage());
            return $postsArray;
        }

        return $postsArray;
    }
    public function commentManagement($commentId, $postId, $actionType, $userId=""){
        try { 
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $mongoCriteria->Comments->CommentId("==" ,new MongoID($commentId)); 
             
             $mongoModifier = new EMongoModifier;           
             if($actionType=='AbuseComment'){
                 $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 1);
                 $mongoModifier->addModifier('Comments.$.AbusedUserId', 'set', (int)$userId);
                 $mongoModifier->addModifier('AbusedOn','set',new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
                 $mongoModifier->addModifier('IsCommentAbused', 'set', 1);
              }elseif ($actionType=="BlockAbusedComment") {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 2);
             }elseif ($actionType=="ReleaseAbusedComment") {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 0);
             }
             elseif ($actionType=="AbuseCommentForSuspendedUser") {
                $mongoModifier->addModifier('Comments.$.IsAbused', 'set', 3);
             }
             $returnValue=GameCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             if($actionType=='AbuseComment'){
                 $returnValue = 'CommentAbused';
             }elseif($returnValue){
                $criteria = new EMongoCriteria;
                $criteria->addCond('_id', '==', new MongoId($postId));
                $criteria->Comments->IsAbused("==" ,1); 
                $obj = GameCollection::model()->find($criteria);
                if (!is_object($obj)) {//If posts have no abused comments
                    $criteria = new EMongoCriteria;
                    $criteria->addCond('_id', '==', new MongoId($postId));
                    $mongoModifier = new EMongoModifier;  
                    $mongoModifier->addModifier('IsCommentAbused', 'set', 0);
                    $returnValue=GameCollection::model()->updateAll($mongoModifier,$criteria);
                    if($returnValue){
                        $returnValue = 'PostReleased';
                    }
                }else{
                    $returnValue = 'CommentReleased';
                }
             }
             return $returnValue;
          } catch (Exception $ex) {
           Yii::log("GameCollection:commentManagement::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function getRecentGameDetailsObject($startDate,$endDate){
     try {
                  
          $returnValue = 'failure';
          $criteria = new EMongoCriteria;
        
           $criteria->addCond('IsCurrentSchedule', '==', (int)1);
           $criteria->addCond("CreatedOn", ">=", new MongoDate(strtotime($startDate)));
           $criteria->addCond("CreatedOn", "<=", new MongoDate(strtotime($endDate)));
                 
         $gameObj=GameCollection::model()->find($criteria);
            if(is_array($gameObj) || is_object($gameObj) ){
                $returnValue=$gameObj;
            }
            return $returnValue;
     } catch (Exception $ex) {         
         Yii::log("GameCollection:getRecentGameDetailsObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
  public function markThisPostForAwayDigest($postId, $isUseForDigest){
        try { 
             $returnValue='failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;           

             $mongoModifier->addModifier('IsUseForDigest', 'set', $isUseForDigest);
            
             $mongoCriteria->addCond('_id', '==', new MongoId($postId));  
             $returnValue=GameCollection::model()->updateAll($mongoModifier,$mongoCriteria);
             return 'success';

        } catch (Exception $ex) {
           Yii::log("GameCollection:markThisPostForAwayDigest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}
