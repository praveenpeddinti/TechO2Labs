<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SkiptaDataMigrationService{
    
     public function checkUserExist($email) {
         try {
              $result = UserMigration::model()->checkUserExist($email);
        return $result;
         } catch (Exception $ex) {
             Yii::log("SkiptaDataMigrationService:checkUserExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
    }
    
    public function SaveUserCollection($userProfileform,$customForm){
     try {
         $userCollectionModel=new UserCollectionMigration();
          $NetworkId= Network::model()->getNeworkId($userProfileform['country']);
           if(isset($NetworkId) && $NetworkId!='error'){
               $userProfileform['network']=$NetworkId;
               
            }else{
                $userProfileform['network']='US';
            }
         $MYuserId= UserMigration::model()->saveUser($userProfileform,$customForm);
         $userCollectionModel->UserId=$MYuserId;
         $userCollectionModel->DisplayName=$userProfileform['firstName'].$userProfileform['lastName'];
         $userCollectionModel->NetworkId=$NetworkId;
         $userCollectionModel->ProfilePicture='';
         $userId=UserCollectionMigration::model()->saveUserCollection($userCollectionModel);
         if(isset($userId) && $userId!='error'){
           $customfieldId=CustomFieldMigration::model()->saveCustomField($userProfileform,$MYuserId);
           $userprofileid=$this->saveUserProfile($userProfileform,$customForm,$MYuserId);
         }
         if(isset($userprofileid) && $userprofileid!='error'){
          
            return $userprofileid;
            
         }else{
             
             return 'error';
         }
         
     } catch (Exception $ex) {
         Yii::log("SkiptaDataMigrationService:SaveUserCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
  }
   public function saveUserProfile($userProfileform,$customForm,$userId){
    try {
        $userProfileCollection=new UserProfileCollection();
        $userid=UserProfileCollection::model()->saveUserProfileCollection($userProfileform,$customForm,$userId);
        return $userid;     
    } catch (Exception $ex) {
        Yii::log("SkiptaDataMigrationService:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }

}
