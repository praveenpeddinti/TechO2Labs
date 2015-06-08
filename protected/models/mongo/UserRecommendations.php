<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserRecommendations extends EMongoDocument {
    
    public $_id;
    public $UserId;
    public $CreatedOn;
    public $Recommendations = array();
   
     public function getCollectionName() {

        return 'UserRecommendations';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_UserId' => array(
                'key' => array(
                    'UserId' => EMongoCriteria::SORT_ASC
                ),
            ),
          
        );
    }
    public function attributeNames() {
        return array(
            '_id' => '_id',
            'UserId' => 'UserId',
            'CreatedOn' => 'CreatedOn',
            'Recommendations' => 'Recommendations',
           
        );
    }
    public function pushToRecommendation($userId,$recommendedUserId,$recommendationItem,$recommendationType){
        try{
        // $userRecommendation = new UserRecommendations;
         $criteria = new EMongoCriteria;
         $criteria->addCond('UserId', '==',(int)$userId);
         $recommendationObj = UserRecommendations::model()->find($criteria);
         if(is_object($recommendationObj)){
          
        $criteriaObj = new EMongoCriteria;
        $criteriaObj->addCond('UserId', '==',(int)$userId);   
         $criteriaObj->addCond('Recommendations.UserId', '==',(int)$recommendedUserId); 
         $recommendationObj = UserRecommendations::model()->find($criteriaObj);
            if(isset($recommendationObj)){
        
             
         //  $recommendationItem = "ss"   ;  
         //  $recommendationType = 1   ;
//         $criteriaObj = new EMongoCriteria;
//        $criteriaObj->addCond('UserId', '==',(int)$userId);   
//         $criteriaObj->addCond('Recommendations.UserId', '==',(int)$recommendedUserId);
//         $criteriaObj->addCond('Recommendations.RecommendedBy.Item', '==',$recommendationItem);
//         $criteriaObj->addCond('Recommendations.RecommendedBy.Type', '==',(int)$recommendationType);
//         $recommendationSubObj = UserRecommendations::model()->find($criteriaObj);
        
         $c = UserRecommendations::model()->getCollection();
           $result = $c->aggregate(array('$match' => array('UserId' =>(int)$userId)),array('$unwind' =>'$Recommendations'),array('$match' => array('Recommendations.UserId' =>(int)$recommendedUserId,'Recommendations.RecommendedBy.Item' =>$recommendationItem,'Recommendations.RecommendedBy.Type' =>(int)$recommendationType)),array('$group' => array("_id" => '$UserId',"Recommendations" => array('$push' => '$Recommendations'))));   
           
         
           if(is_array($result['result'])&& sizeof($result['result'])>0 ){
              
         }else{
             error_log("data des not iext esit--") ; 
         }
         if(is_array($result['result'])&& sizeof($result['result'])>0){
           
              $mongoModifier = new EMongoModifier;  
                $mongoCriteria = new EMongoCriteria; 
                 $mongoCriteria->addCond('UserId', '==',(int)$userId);
                $mongoCriteria->addCond('Recommendations.UserId', '==', (int) $recommendedUserId);
                 $mongoModifier->addModifier('Recommendations.$.UpdatedOn', 'set', new MongoDate());
                UserRecommendations::model()->updateAll($mongoModifier, $mongoCriteria);
         }else{
                $mongoModifier = new EMongoModifier;  
                $mongoCriteria = new EMongoCriteria; 
              
                $mongoCriteria->addCond('UserId', '==',(int)$userId);
                $mongoCriteria->addCond('Recommendations.UserId', '==', (int) $recommendedUserId);
                $recommendateByObject = array("Item" => $recommendationItem, "Type" => $recommendationType);
                $mongoModifier->addModifier('Recommendations.$.RecommendedBy', 'push', $recommendateByObject);
                $mongoModifier->addModifier('Recommendations.$.UpdatedOn', 'set', new MongoDate());
                UserRecommendations::model()->updateAll($mongoModifier, $mongoCriteria);
            } 
             
             
             
             
         }else{
           
              $mongoModifier = new EMongoModifier;  
              $mongoCriteria = new EMongoCriteria; 
              
              $mongoCriteria->addCond('UserId', '==',(int)$userId);
              $recommendateByObject = array("Item" => $recommendationItem, "Type" => $recommendationType);
             
            
                
              $recommendationArray = array();
             $recommendationArray["UserId"] = (int)$recommendedUserId;
             $recommendationArray["CreatedOn"] = new MongoDate();
             $recommendationArray["UpdatedOn"] = new MongoDate();
             $recommendationArray["FollowStatus"] = (int)0;
             $recommendationArray["RecommendedBy"] = array(array("Item"=>$recommendationItem,"Type"=>$recommendationType));
              $mongoModifier->addModifier('Recommendations', 'push', $recommendationArray);
               
              UserRecommendations::model()->updateAll($mongoModifier, $mongoCriteria);
             
         }  
          
         }else{
           
             $userRecommendation = new UserRecommendations;
             $userRecommendation->UserId = (int)$userId;
             $userRecommendation->CreatedOn = new MongoDate();
             $recommendationArray = array();
             $recommendationArray["UserId"] = (int)$recommendedUserId;
             $recommendationArray["CreatedOn"] = new MongoDate();
             $recommendationArray["UpdatedOn"] = new MongoDate();
             $recommendationArray["FollowStatus"] = (int)0;
             $recommendationArray["RecommendedBy"] = array(array("Item"=>$recommendationItem,"Type"=>$recommendationType));
           
              
             $userRecommendation->Recommendations = array($recommendationArray);
             $userRecommendation->save();
         }
         } catch (Exception $ex) {
             Yii::log("UserRecommendations:pushToRecommendation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
    * @Author Lakshman
    * This method is used to get Recommended Users
    * @param type $userId, $limit
    * @return type tiny user collection object
    */
    public function getUserRecommendationsMembersList($userId, $limit)
    {       
        try
        {            
            $c = UserRecommendations::model()->getCollection();            
            
            $result = $c->aggregate(array('$match' => array('UserId' =>(int)($userId))),array('$unwind' =>'$Recommendations'),array('$match' => array('Recommendations.FollowStatus' =>(int)0)),array('$sort' => array('Recommendations.UpdatedOn' =>1)),array('$limit' => $limit),array('$group' => array("_id" => '$UserId',"UserArray" => array('$push' => '$Recommendations.UserId'))));        
            
            return $result;
            
        } catch (Exception $ex) {
             Yii::log("UserRecommendations:getUserRecommendationsMembersList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
    * @Author Lakshman
    * This method is used to update the FollowStatus
    * @param type $userId
    * @return type tiny user collection object
    */
    public function followStatusAction($userId, $followId, $value){
       try{
           $result = "failed";
           $i = 0;
           $modifier = new EMongoModifier();
           $criteria = new EMongoCriteria();          
           
           $criteria->addCond('UserId', '==', (int)$userId);
           $criteria->addCond('Recommendations.UserId', '==', (int)$followId);
           
           $modifier->addModifier("Recommendations.$.FollowStatus", 'set', (int)$value);
           UserRecommendations::model()->updateAll($modifier, $criteria);           
          
           $result = "success";
           
       }catch(Exception $ex){
           Yii::log("UserRecommendations:followStatusAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return "failure";
       }
       return $result;
   }
   public function getUserRecommendationCount($userId)
    {
        try {
            $count = 0;
            $criteria = new EMongoCriteria;
            $criteria->addCond('UserId', '==', (int)$userId);
            $userRecommendations = UserRecommendations::model()->find($criteria);
            if(is_object($userRecommendations) && count($userRecommendations)>0){
                if (isset($userRecommendations->Recommendations)) {
                    $count =count($userRecommendations->Recommendations);
                }
            }
            return $count;
        } catch (Exception $ex) {
            Yii::log("UserRecommendations:getUserRecommendationCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return FALSE;
        }
    }
}
