<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * @author Vamsi Krishna
 * This class is used write all the methods for Group Service 
 * 
 */
 class SkiptaGroupService {
/**
 * @author Vamsi Krishna
 * This method is used to get the group details by groupId
 * @param MongoId $groupId 
 * 
 */
    public function getGroupDetailsById($groupId) {
        try {
            $returnValue='failure';
            $groupDetails = GroupCollection::model()->getGroupDetailsById($groupId);
            if(is_object($groupDetails)){
                $returnValue= $groupDetails;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getGroupDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
 * @author Vamsi Krishna
 * This method is used to update Group with postid
 * @param MongoId $groupId 
 * @param MongoId $postId 
 * 
 */
  public function updateGroupForGroupPost($postId,$groupId,$categoryId){
      try {
          $returnValue='failure';
          
          if($categoryId==3){
           GroupCollection::model()->updateGroupCollectionForArrayType($groupId,$postId,"PostIds");    
          }else{
           SubGroupCollection::model()->updateGroupCollectionForArrayType($groupId,$postId,"PostIds");       
          }
          
      } catch (Exception $ex) {
          Yii::log("SkiptaGroupService:updateGroupForGroupPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    
  /**
   * @author Vamsi Krishna 
   *  This method is used to get Group Intro Popup
   *  @param MongoId GroupId
   */  
    
   public function getGroupIntroPopUp($groupId,$userId){
       $returnvalue='failure';
       
       try {
           $groupDetails=GroupCollection::model()->getGroupDetailsById($groupId);         
             if($groupDetails!='failure'){
                 $groupBean=new GroupBean();      
                 $groupBean->GroupName=$groupDetails->GroupName;
                 $groupBean->GroupDescription=$groupDetails->GroupDescription;
                 $groupBean->GroupIcon=$groupDetails->GroupProfileImage;
                 $groupBean->GroupId=$groupDetails->_id;
                 $groupBean->GroupMembersCount=count($groupDetails->GroupMembers);
                 $groupBean->GroupPostsCount=count($groupDetails->PostIds);
                 $groupBean->SubgroupsCount=count($groupDetails->SubGroups);
                 $groupBean->IsFollowing=in_array($userId,$groupDetails->GroupMembers);
                 $groupBean->GroupUniqueName = $groupDetails->GroupUniqueName;
                 $groupBean->RestrictedAccess = $groupDetails->RestrictedAccess;
                // $groupBean->IsGroupAdmin = $groupDetails->IsGroupAdmin;
                 $groupBean->UserId = $userId;
                 
                
                 
                 $IsGroupAdmin = GroupCollection::model()->checkIsGroupAdminById($groupBean);
                 if($IsGroupAdmin=='true'){
                     $groupBean->IsGroupAdmin=1;
                 }else{
                     $groupBean->IsGroupAdmin=0;
                 }
//                 $groupBean->AddSocialActions=$groupDetails->AddSocialActions;
               $returnvalue=$groupBean;
           }
           return $returnvalue; 
       } catch (Exception $ex) {          
            Yii::log("SkiptaGroupService:getGroupIntroPopUp::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnvalue;
       }
      } 
      /**
  * This method is used to create new group
  * @param type $groupObj
  * @return type string
  * @author Praneeth
  */   
    public function createNewSubGroup($groupObj,$UserId,$networkId,$networkAdminUserId) {
        try {
             $groupExists = $this->checkIfSubGroupExist($groupObj);
             $returnValue='failure';
             if($groupExists !='true')
             {
                          /**
             * added below peace for save networkid, segmentid, language of original
             * @developer reddy
             */
            $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($UserId);
            $groupObj->NetworkId = $tinyUserCollectionObj->NetworkId;
            $groupObj->SegmentId = $tinyUserCollectionObj->SegmentId;
            $groupObj->Language = $tinyUserCollectionObj->Language;
                 
                  $groupId = $groupObj->GroupId;
                  $subGroupId=SubGroupCollection::model()->saveSubGroup($groupObj,$UserId,$networkAdminUserId);     
                  $returnValue = UserProfileCollection::model()->followOrUnfollowSubGroup($groupId, $UserId, "Follow",$subGroupId);
                   if(Yii::app()->session['PostAsNetwork']!=1){
                       UserProfileCollection::model()->followOrUnfollowSubGroup($groupId, (int)Yii::app()->session['NetworkAdminUserId'], "Follow",$subGroupId);
                    }
                  GroupCollection::model()->updateGroupCollectionForArrayType($groupId,$subGroupId,'SubGroups');
                 if ($subGroupId != '') {
                    $returnValue = $subGroupId;
                 }
                  else {
                    $returnValue = 'failure';
                }
            }
             else 
             {
                 $returnValue = 'groupexists';
             }
             
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:createNewSubGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');        }
        
    }
    

        /**
     * 
     * @author:Vamsi 
     * @param type $model
     * @return $result
     * Checks whether the group exists or not
     */
    public function checkIfSubGroupExist($model) {       
        try {
            $result="";
            $result = SubGroupCollection::model()->checkIfGroupExist($model);
            
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:checkIfSubGroupExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    
         /**
 * 
 * @autho : Vamsi 
 * @param type $userID
 * @param type $groupId
 * @param type $postType 
 * @return type
 */
        public function saveFollowOrUnfollowToSubGroup($groupId, $userId,$actionType,$subGroupId)
    {
        try
        {
             $returnValue = 'failure';
             $groupDetails=GroupCollection::model()->getGroupDetailsById($groupId);
             $groupFollowers=$groupDetails->GroupMembers;
             $isFollowingGroup=in_array($userId, $groupFollowers);             
        if($actionType=='Follow'){
           if($isFollowingGroup!=true){                 
                 GroupCollection::model()->followOrUnfollowGroup($groupId, $userId, $actionType);
                 UserProfileCollection::model()->followOrUnfollowGroup($groupId, $userId,$actionType);
             } 
        }
        else{
//           if($isFollowingGroup==true){                 
//                 GroupCollection::followOrUnfollowGroup($groupId, $userId, $actionType);
//             } 
        }
             
             $returnValue = SubGroupCollection::model()->followOrUnfollowSubGroup($subGroupId, $userId,$actionType);  
             if($returnValue=="success"){
             $returnValueUserProfileCollection = UserProfileCollection::model()->followOrUnfollowSubGroup($groupId, $userId,$actionType,$subGroupId);
            
              if ($actionType == 'Follow') {
                  
              $actionType="SubGroupFollow";
              } else{
                $actionType="SubGroupUnFollow";   
              }
             
             
            $CategoryType = CommonUtility::getIndexBySystemCategoryType('SubGroup');
            $FollowEntity = CommonUtility::getIndexBySystemFollowingThing('SubGroup');
            CommonUtility::prepareStreamObjectForFollowEntity($userId,$actionType, $subGroupId, (int) $CategoryType, $FollowEntity);
               
             }
           
               
          return $returnValue;
             
        } catch (Exception $ex) {
                Yii::log("SkiptaGroupService:saveFollowOrUnfollowToSubGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          return "failure";
                
        }
       
    }
 

      /**
   * @author Praneeth 
   *  This method is used to get SubGroup Intro Popup
   *  @param MongoId SubGroupId
   */ 
 public function getSubGroupIntroPopUp($subgroupId,$userId){
       $returnvalue='failure';
       
       try {
           $subgroupDetails=SubGroupCollection::model()->getSubGroupDetailsById($subgroupId);   
             if($subgroupDetails!='failure'){
                 $subgroupBean=new SubGroupBean();      
                 $subgroupBean->SubGroupName=$subgroupDetails->SubGroupName;
                 $subgroupBean->SubGroupDescription=$subgroupDetails->SubGroupDescription;
                 $subgroupBean->SubGroupIcon=$subgroupDetails->SubGroupProfileImage;
                 $subgroupBean->SubGroupId=$subgroupDetails->_id;
                 $subgroupBean->ParentGroupId=$subgroupDetails->GroupId;
                 $subgroupBean->SubGroupMembersCount=count($subgroupDetails->SubGroupMembers);
                 $subgroupBean->SubGroupPostsCount=count($subgroupDetails->PostIds);
                 $subgroupBean->IsFollowing=in_array($userId,$subgroupDetails->SubGroupMembers);
               $returnvalue=$subgroupBean;
           }
           return $returnvalue; 
       } catch (Exception $ex) {          
            Yii::log("SkiptaGroupService:getSubGroupIntroPopUp::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnvalue;
       }
      }
      
  public function getSubGroupIdByName($subgroupName,$groupId){
         try {
            $result="failure";
            $subGroupId=SubGroupCollection::model()->getSubGroupIdByName($subgroupName,$groupId);
            if($subGroupId!="failure"){
             $result= $subGroupId;   
            }
            
        } catch (Exception $ex) {
           Yii::log("SkiptaGroupService:getSubGroupIdByName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
         return $result;
    }    
  /**
 * 
 * @autho : Vamsi 
 * @param type $groupId
 * @param type $userId 
 * @param type $subGroupId 
 * @return type
 */
    public function getSubGroupStatistics($groupId,$userId,$subGroupId) {
        try {            
            $returnValue = 'failure';
            $groupObj = SubGroupCollection::model()->getSubGroupDetailsById($subGroupId);
            if (is_object($groupObj)) {
                $groupBean = new SubGroupBean();
                $groupBean->GroupId=$groupId;
                $groupBean->SubGroupId = $groupObj->_id;
                $groupBean->SubGroupName = $groupObj->SubGroupName;                
                $groupBean->SubGroupDescription = $groupObj->SubGroupDescription;
                $groupBean->SubGroupIcon = $groupObj->SubGroupProfileImage;
                $groupBean->SubGroupBannerImage = $groupObj->SubGroupBannerImage;
                $groupBean->SubGroupPostsCount=Count($groupObj->PostIds);
                $groupBean->SubGroupMembers=$groupObj->SubGroupMembers; 
                $groupBean->DisableWebPreview=$groupObj->DisableWebPreview; 
                $groupBean->DisableStreamConversation=$groupObj->DisableStreamConversation; 
                $groupBean->IsSubGroupAdmin=in_array($userId,$groupObj->SubGroupAdminUsers);                                
                $groupBean->IsFollowing=in_array($userId,$groupObj->SubGroupMembers);
                $groupBean->SubGroupUniqueName = $groupObj->SubGroupUniqueName;
                $groupBean->Status=$groupObj->Status;
                $groupDetails=GroupCollection::model()->getGroupDetailsById($groupId);
                if(!is_string($groupDetails)){
                    $groupBean->IsGroupPrivate=$groupDetails->IsPrivate;
                    $groupBean->GroupName=$groupDetails->GroupName;
                    $groupBean->GroupUniqueName = $groupDetails->GroupUniqueName;
                }
                $groupArtifacts = ResourceCollection::model()->getGroupResources($groupObj->_id,'SubGroup');
              
               if ($groupArtifacts != 'failure') {   
                    // media Extensions "jpg","jpeg","gif","mov","mp4",,"avi","png","tiff"
                    //Doc Extensions  "txt","doc","pdf","ppt","xls"
                    $GroupImagesAndVideos = ResourceCollection::model()->getGroupImagesAndVideo($groupObj->_id, 'Image','SubGroup');
                    $GroupDocs = ResourceCollection::model()->getGroupArtifacts($groupObj->_id, 'Artifacts','SubGroup');
                    $GroupImagesAndVideosCount = ResourceCollection::model()->getGroupImagesAndVideo($groupObj->_id, 'Count','SubGroup');
                    $GroupArtifactsCount = ResourceCollection::model()->getGroupArtifacts($groupObj->_id, 'Count','SubGroup');
                    if ($GroupImagesAndVideosCount == 'failure') {
                        $groupBean->SubGroupImagesAndVideosCount = 0;
                    } else {
                        $groupBean->SubGroupImagesAndVideosCount = $GroupImagesAndVideosCount;
                    }
                    if ($GroupImagesAndVideos != 'failure') {
                        foreach ($GroupImagesAndVideos as $artifacts) {
                            if(strtolower($artifacts['Extension'])=='jpg' || strtolower($artifacts['Extension'])=='jpeg'|| strtolower($artifacts['Extension'])=='png' ||strtolower($artifacts['Extension'])=='tiff'){
                                array_push($groupBean->SubGroupImagesAndVideos, $artifacts['Uri']);
                            }else{
                             array_push($groupBean->SubGroupImagesAndVideos, '/images/system/video_img.png');    
                            }
                            
                        }
                    }


                    if ($GroupArtifactsCount == 'failure') {
                        $groupBean->SubGroupArtifactsCount = 0;
                    } else {
                        $groupBean->SubGroupArtifactsCount = $GroupArtifactsCount;
                    }

                    if ($GroupDocs != 'failure') {

                        foreach ($GroupDocs as $artifacts) {                            
                            array_push($groupBean->SubGroupArtifacts, $artifacts['ThumbNailImage']);
                        }
                    }
                }
                else{
                    $groupBean->SubGroupImagesAndVideosCount = 0;
                    $groupBean->SubGroupArtifactsCount = 0;
                }
                // this logic is to get the group members profile
                $groupBean->SubGroupMembersCount = count($groupObj->SubGroupMembers);
                if (count($groupObj->SubGroupMembers) > 0) {
                    foreach ($groupObj->SubGroupMembers as $members) {
                        $tinyUserObj = UserCollection::model()->getTinyUserObjByNetwork($members);
                        if (is_object($tinyUserObj)) {
                            array_push($groupBean->SubGroupMembersProfilePictures, $tinyUserObj->profile70x70);
                        }
                    }
                }
                $returnValue = $groupBean;
            } else {
                
            }
   
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getSubGroupStatistics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGroupService->getSubGroupStatistics### ".$ex->getMessage());
            
        }
    }
   public function getAllAutoFollowGroups($networkId,$segmentId){
       $returnValue='failure';
       try {
           $groups=GroupCollection::model()->getAllAutoFollowGroups($networkId,$segmentId);
           return $groups;
       } catch (Exception $ex) {
           Yii::log("SkiptaGroupService:getAllAutoFollowGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }
     public function AutoFollowGroupFromPreference($groupId){
         try {
//             $users=UserCollection::model()->getAllUsersIds();
//             if(!is_string($users)) {
//                foreach ($users as $user) {                    
//                    GroupCollection::model()->followOrUnfollowGroup($groupId, $user->UserId, "Follow");
//                    $returnValue = UserProfileCollection::model()->followOrUnfollowGroup($groupId, $user->UserId, "Follow");
//                }
//          }
            
            
            $userStreamBean=new UserStreamBean();
            $userStreamBean->ActionType='GroupAutoFollow';
            $userStreamBean->GroupId=$groupId;              
            Yii::app()->amqp->stream(json_encode($userStreamBean));
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:AutoFollowGroupFromPreference::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
          }
          
     public function isUserFollowsAGroup($userId,$groupId,$categoryType){
         try{
             return GroupPostCollection::model()->isUserFollowsAGroup($userId,$groupId,$categoryType);
             
         }catch(Exception $ex){
             Yii::log("SkiptaGroupService:isUserFollowsAGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             error_log("Exception Occurred in SkiptaGroupService->isUserFollowsAGroup### ".$ex->getMessage());
            
         }
     }
     /**
    * @Author Vamsi Krishna
    * This method is used get getFollowingFollowerUsersForInvie
    * @param type $searchKey
    * @param type $userId
    * @return type
    */
    public function getFollowingFollowerUsersForInviteInPrivateGroup($searchKey,$userId, $postId, $categoryType, $mentionArray=array(),$groupId) {
        $userDetails='failure';
        try {
               if(sizeof($mentionArray)>0){
                $mentionArray = array_map('intval', $mentionArray);    
               }
               // $users = UserProfileCollection::model()->getUserFollowersAndFollowingsById($userId);
                $groupDetails = GroupCollection::model()->getGroupDetailsById($groupId);
                if (sizeof($mentionArray) > 0) {
                     $users=$groupDetails->GroupMembers  ;
                    $users = array_diff($users, $mentionArray);
                }else{
                    $users=$groupDetails->GroupMembers  ;
                }                
                $invitedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getInvitedUsersForPost($postId, $categoryType);
                if(is_array($invitedUsers) && sizeof($invitedUsers)>0){
                    $users = array_diff($users, $invitedUsers);
                }                
                array_unique($users);
                $pos = array_search($userId, $users);
                if(is_int($pos) && $pos>=0){ 
                    unset($users[$pos]);
                }
                $userDetails = UserCollection::model()->getFollowingFollowerUsers($searchKey,$users);
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getFollowingFollowerUsersForInviteInPrivateGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $userDetails;
    }
    
   public function getSubGroupDetailsById($subGroupId){
       try {
           $subGroupDetails=SubGroupCollection::model()->getSubGroupDetailsById($subGroupId);
           return $subGroupDetails;
       } catch (Exception $ex) {           
           Yii::log("SkiptaGroupService:getSubGroupDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return "failure";
       }
      }
      
      public function getGroupDetailsByMigratedId($groupId) {
        try {
            $returnValue='failure';
            $groupDetails = GroupCollection::model()->getGroupDetailsByMigratedId($groupId);
            if(is_object($groupDetails)){
                $returnValue= $groupDetails;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getGroupDetailsByMigratedId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
   public function getGroupDetailsWithoutGroupMembersByGroupId($postId,$categoryType){
       try {
            $returnValue='failure';
            $GroupDetails=array();
             $groupPostDetails=GroupPostCollection::model()->getGroupPostById($postId);   
            
           if(isset($groupPostDetails)){
             $groupDetails = GroupCollection::model()->getGroupDetailsWithoutGroupMembersByGroupId($groupPostDetails->GroupId);
             if($categoryType==7){
               $subgroupDetails = SubGroupCollection::model()->getSubGroupDetailsWithoutGroupMembersByGroupId($groupPostDetails->SubGroupId);  
             }
            if(is_object($groupDetails)){
                $GroupDetails['GroupName']=$groupDetails->GroupName;
               if($categoryType==7){
                $GroupDetails['SubGroupName'] =$subgroupDetails->SubGroupName;  
               }   
                $returnValue= $GroupDetails;
            }   
           }
            
            return $returnValue;
       } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getGroupDetailsWithoutGroupMembersByGroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');

       }
      } 
   public function loadOnlyGroupNames(){
       $returnValue='failure';
       try {
           $GroupsArray=array();         
           $groupDetails=GroupCollection::model()->getAllNativeGroupIds();           
         
           if(is_object($groupDetails) || is_array($groupDetails)){
               $GroupsArray["AllGroups"]="All Groups";
               foreach($groupDetails as $group){   
                   if($group->IsIFrameMode==0){
                       $id=(String)$group->_id;
                   $GroupsArray[$id]=$group->GroupName;                
                   }
                   
               }
             $returnValue=$GroupsArray;  
           }
       
           return $returnValue;
       } catch (Exception $ex) {
           Yii::log("SkiptaGroupService:loadOnlyGroupNames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
       }
      }   
    public function GetCustomGroupMenusByGroupId($groupId){
      try {
          $menus=  CustomGroupMenu::model()->GetCustomGroupMenusByGroupId($groupId);
          return $menus;
      } catch (Exception $ex) {
           Yii::log("SkiptaGroupService:GetCustomGroupMenusByGroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    
    public function saveGroupFiles($userId,$filename, $groupId, $groupName,$newFileName){
      try {
          $returnValue = GroupAdminUploadedFiles::model()->saveUploadedFiles($userId,$filename, $groupId, $groupName,$newFileName);
          return $returnValue;
        } catch (Exception $ex) {
           Yii::log("SkiptaGroupService:saveGroupFiles::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in SkiptaGroupService->saveGroupFiles### ".$ex->getMessage());
            
        }
    }
    
    public function getFilesList($userId,$groupId){
        try{
            return GroupAdminUploadedFiles::model()->getFilesList($userId,$groupId);
          
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getFilesList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGroupService->getFilesList### ".$ex->getMessage());
            
        }
    }
    public function deleteAFileById($userId,$fileId){
        try{
            return GroupAdminUploadedFiles::model()->deleteAFileById($userId,$fileId);
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:deleteAFileById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getGroupAccessibleUsers($userId,$groupId){
        try{
            return GroupAccessibleUsers::model()->getGroupAccessibleUsers($userId,$groupId);
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getGroupAccessibleUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function saveGroupAccessibleUsersEmailsList($userId, $groupId, $groupName,$emailArrays){
        try{
            return GroupAccessibleUsers::model()->saveGroupAccessibleUsersEmailsList($userId, $groupId, $groupName,$emailArrays);
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:saveGroupAccessibleUsersEmailsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getAllGroupAccessibleUsers(){
        try{
            return GroupAccessibleUsers::model()->getAllGroupAccessibleUsers();
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getAllGroupAccessibleUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
    public function updateSubGroupObject($sugGroupObj) {
        try {
                $returnValue = 'failure';
                $returnValue = SubGroupCollection::model()->updateSubGroupDetailsById($sugGroupObj);
             if($returnValue='success'){                               
                   ServiceFactory::getSkiptaGroupServiceInstance()->updateDataForSubGroupInactiveActive($sugGroupObj->id,$sugGroupObj->Status);                    
                }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:updateSubGroupObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGroupService->updateSubGroupObject### ".$ex->getMessage());
            
        }
}
public function getSubSpeciality() {
        try {
            $subSpe = SubSpecialty::model()->getSubSpecialityDetails();
            $specialityArray = array();
            if (is_array($subSpe) || is_object($subSpe)) {
                $specialityArray['PleaseSelect'] = "Please Select";
                foreach ($subSpe as $spe) {
                    $id = (int) $spe['id'];
                    $specialityArray[$id] = Yii::t('subspecialty', $spe['Key']);
                }
            }
            return $specialityArray;
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getSubSpeciality::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGroupService->getSubSpeciality### ".$ex->getMessage());
        }
    }

    public function getGroupAccessibleUserStatusByGroupId($groupId,$lemail) {
        try {
            return GroupAccessibleUsers::model()->getGroupAccessibleUserStatusByGroupId($groupId,$lemail);
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getGroupAccessibleUserStatusByGroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function updateDataForGroupInactiveActive($groupId, $status) {
        try {
            $userStreamBean = new UserStreamBean();
            if ($status == 1) {
                $userStreamBean->ActionType = 'GroupInactive';
            } else {
                $userStreamBean->ActionType = 'GroupActive';
            }
            $userStreamBean->GroupId = $groupId;
            SubGroupCollection::model()->updateSubGroupStatus($groupId, $status);            
            Yii::app()->amqp->stream(json_encode($userStreamBean));
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:updateDataForGroupInactiveActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGroupService->updateDataForGroupInactiveActive### ".$ex->getMessage());
        }
    }

    public function getGroupsInactive() {
        try {
            $inactiveGroups = GroupCollection::model()->getGroupsInactive();
            return $inactiveGroups;
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getGroupsInactive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGroupService->getGroupsInactive### ".$ex->getMessage());
        }
    }

    public function updateDataForSubGroupInactiveActive($groupId, $status) {
        try {
            $userStreamBean = new UserStreamBean();
            if ($status == 1) {
                $userStreamBean->ActionType = 'SubGroupInactive';
            } else {
                $userStreamBean->ActionType = 'SubGroupActive';
            }
            $userStreamBean->GroupId = $groupId;
            //  SubGroupCollection::model()->updateSubGroupStatus($groupId,$status);
            Yii::app()->amqp->stream(json_encode($userStreamBean));
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:updateDataForSubGroupInactiveActive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGroupService->updateDataForSubGroupInactiveActive### ".$ex->getMessage());
        }
    }

    public function getGroupStatus($groupId) {
        try {
            $groupStatus = GroupCollection::model()->checkGroupStatus($groupId);
            return $groupStatus;
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getGroupStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGroupService->getGroupStatus### ".$ex->getMessage());
        }
    }
    public function getGroupIdByCustomGroupName($groupName) {
        try {
            $groupId = GroupCollection::model()->getCustomGroupDetails($groupName);
            return $groupId;
        } catch (Exception $ex) {
            Yii::log("SkiptaGroupService:getGroupIdByCustomGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaGroupService->getGroupIdByCustomGroupName### ".$ex->getMessage());
        }
    }

}
