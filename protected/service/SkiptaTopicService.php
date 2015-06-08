<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SkiptaTopicService{
   

      /**
      * @author Praneeth
      * Description: Method used to get the groups for which the user is a member
      * @param type $UserId
      * @return $groupsCollectionUserFollowing
      */
     public function getUserGroupsList($UserId,$startLimit, $pageLength)
     {
         try         
         { 
             $groupsCollectionUserFollowing='failure';
             $userFollowingGroups = UserProfileCollection::model()->getUserFollowingGroups($UserId);             
             $groupsCollectionUserFollowing = GroupCollection::model()->userGroupsList($userFollowingGroups,$startLimit,$pageLength);
         } catch (Exception $ex) {
            Yii::log("SkiptaTopicService:getUserGroupsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         
         return $groupsCollectionUserFollowing;
     }
     
     public function Trending($startDate,$endDate,$NetworkId,$limit,$offset){
          try         
         {

            $Resultsid = array(
                'PostId' => array('PostId' => '$PostId'),
            );
            $match = array("CategoryType" => array('$in' => array(2)),
                "PostId" => array('$ne' => null),
                "userActivityContext" => array('$in' => array(1,16,17,18,19,20,21,22)),
                //"NetworkId" => (int) $NetworkId,
                "CreatedOn" => array('$gte' => new MongoDate(strtotime($startDate)), '$lte' => new MongoDate(strtotime($endDate))));
            $c = UserInteractionCollection::model()->getCollection();
            $results = $c->aggregate(
                    array('$match' => $match
                    ), array('$group' => array(
                    '_id' => $Resultsid,
                    "count" => array('$sum' => 1),
                )), array(
                '$sort' => array('count' => -1)
                    ), array(
                '$limit' => $limit,
                    ), array(
                '$skip' => $offset,
                    )
            );

            return $results['result'];
        } catch (Exception $ex) {
            Yii::log("SkiptaTopicService:Trending::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     
 public function UpdateCategoriesLowerCategoryName(){
     try{
          CurbSideCategoryCollection::model()->UpdateCategoriesLowerCategoryName();
     } catch (Exception $ex) {
        Yii::log("SkiptaTopicService:UpdateCategoriesLowerCategoryName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
    
 }
 
 public function deleteNetworkStreamInvite($streamId)
 {
      try{
     $result=UserStreamCollection::model()->deleteNetworkStreamInvite($streamId);
     return $result;
      } catch (Exception $ex) {
        Yii::log("SkiptaTopicService:deleteNetworkStreamInvite::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
 }
    
    
    

}
