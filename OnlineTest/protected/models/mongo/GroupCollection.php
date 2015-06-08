<?php

/**
 * This collection is used to create a new group
 * @author Praneeth
 */
class GroupCollection extends EMongoDocument {

    public $_id;
    public $CreatedUserId;
    public $GroupName;
    public $CreatedOn;
    public $GroupBannerImage;
    public $GroupShortDescription;
    public $GroupDescription;
    public $GroupFollowers;
    public $GroupProfileImage;
    public $GroupMembers = array();
    public $LastUpdatedBy;
    public $GroupAdminUsers = array();
    public $PostIds = array();
    public $SubGroups = array();
    public $IsIFrameMode=0;
    public $IFrameURL='';
    public $IsPrivate = 0;
    public $AutoFollow = 0;
    public $MigratedGroupId;
    public $CustomGroup=0;
    public $GroupMenu=1;
    public $IsHybrid=0;
    public $CustomGroupName="";
    public $ConversationVisibility;
    public $AddSocialActions;
    public $DisableWebPreview=0;
    public $GroupUniqueName = "";
    public $DisableStreamConversation=0;
    public $SegmentId=0;
    public $NetworkId=1;

    public $Speciality=array();
    public $RestrictedAccess = 0;
    public $Status=1;
    
    public function getCollectionName() {
        return 'GroupCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_CreatedUserId' => array(
                'key' => array(
                    'CreatedUserId' => EMongoCriteria::SORT_DESC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                    'GroupName' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_CreatedOn' => array(
                'key' => array(
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                    'GroupName' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_GroupName' => array(
                'key' => array(
                    'GroupName' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            '_id' => '_id',
            'CreatedUserId' => 'CreatedUserId',
            'GroupName' => 'GroupName',
            'CreatedOn' => 'CreatedOn',
            'GroupShortDescription' => 'GroupShortDescription',
            'GroupDescription' => 'GroupDescription',
            'GroupFollowers' => 'GroupFollowers',
            'GroupProfileImage' => 'GroupProfileImage',
            'GroupMembers' => 'GroupMembers',
            'GroupBannerImage' => 'GroupBannerImage',
            'LastUpdatedBy' => 'LastUpdatedBy',
            'GroupAdminUsers' => 'GroupAdminUsers',
            'PostIds' => 'PostIds',
            'SubGroups' => 'SubGroups',
            'IsIFrameMode' => 'IsIFrameMode',
            'IFrameURL' => 'IFrameURL',
            'IsPrivate' => 'IsPrivate',
            'AutoFollow' => 'AutoFollow',
            'MigratedGroupId' => 'MigratedGroupId',
            /**********Custom group related fields********/
            'CustomGroup' => 'CustomGroup',
            'GroupMenu' => 'GroupMenu',
            'IsHybrid' => 'IsHybrid',
            'CustomGroupName' => 'CustomGroupName',
            'ConversationVisibility'=>'ConversationVisibility',
            'AddSocialActions'=>'AddSocialActions',
            'DisableWebPreview'=>'DisableWebPreview',
            'GroupUniqueName' => 'GroupUniqueName',
            'DisableStreamConversation'=>'DisableStreamConversation',
            'SegmentId'=>'SegmentId',
            'NetworkId'=>'NetworkId',
            'Speciality'=>'Speciality',
            'RestrictedAccess' => 'RestrictedAccess',
            'Status'=>'Status',
        );
    }

    /**
     * @author Praneeth
     * @param type $Groupid
     * @method TO Create a new group
     * @return object type id value
     */
    public function saveNewGroup($groupObj,$UserId,$networkAdminUserId) {
        try {
            $returnValue = 'failure';
            $NewGroupObj = new GroupCollection();
            $NewGroupObj->GroupName = trim($groupObj->GroupName);
            $NewGroupObj->CreatedUserId = (int) $groupObj->UserId;
            if (isset($groupObj->CreatedOn) && !empty($groupObj->CreatedOn)) {
                $NewGroupObj->CreatedOn = new MongoDate(strtotime($groupObj->CreatedOn));
            } else {
                $NewGroupObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            }
            // $NewGroupObj->GroupShortDescription = $groupObj->ShortDescription;
            $NewGroupObj->GroupDescription = $groupObj->Description;
            $NewGroupObj->GroupFollowers = array();
            $NewGroupObj->GroupMembers = array();
            array_push($NewGroupObj->GroupMembers, (int) $groupObj->UserId);
            array_push($NewGroupObj->GroupAdminUsers, (int) $groupObj->UserId);
            if($UserId != $networkAdminUserId){                
                array_push($NewGroupObj->GroupAdminUsers, (int) $networkAdminUserId);
                array_push($NewGroupObj->GroupMembers, (int) $networkAdminUserId);
            }
            $NewGroupObj->GroupAdminUsers =  array_unique(array_values($NewGroupObj->GroupAdminUsers));
            $NewGroupObj->GroupBannerImage = '/images/system/nogroup.png';
            if (isset($groupObj->GroupProfileImage) && !empty($groupObj->CreatedOn)) {
                $NewGroupObj->GroupProfileImage = $groupObj->GroupProfileImage;
            } else {
                $NewGroupObj->GroupProfileImage = '/images/system/grouplogo.png';
            }            
            if(isset($groupObj->IFrameMode) &&  $groupObj->IFrameMode == 2){
                $NewGroupObj->IsIFrameMode = (int) 0; // we can change it to 1 for normal custom groups
                $NewGroupObj->IsHybrid = (int) 0;
                //$NewGroupObj->ConversationVisibility = (int) 0;
            }else{
//                $NewGroupObj->ConversationVisibility = (int) 1;
                $NewGroupObj->IsIFrameMode = (int) $groupObj->IFrameMode;
            }              
            $NewGroupObj->ConversationVisibility = (int) $groupObj->ConversationVisibility;
            $NewGroupObj->IFrameURL = $groupObj->IFrameURL;
            $NewGroupObj->AutoFollow = (int) $groupObj->AutoFollow;
            $NewGroupObj->IsPrivate = (int) $groupObj->IsPrivate;

            $NewGroupObj->AddSocialActions = (int) $groupObj->AddSocialActions;
            $NewGroupObj->DisableWebPreview = (int) $groupObj->DisableWebPreview;
            $NewGroupObj->DisableStreamConversation = (int) $groupObj->DisableStreamConversation;

            $NewGroupObj->MigratedGroupId = isset($groupObj->MigratedGroupId) ? $groupObj->MigratedGroupId : "";
            // Add the Network Admin as the default follower of the group and also hardcoded the groupmember Id as 1. As the 
            //Network Admin will be created first and Jobs will be Run next.
            if (isset($groupObj->MigratedGroupId) && ($groupObj->MigratedGroupId != '')) {
                $admin = User::model()->checkUserExist(YII::app()->params['NetworkAdminEmail']);
                array_push($NewGroupObj->GroupMembers, (int) $admin->UserId);
            }            
            $NewGroupObj->CustomGroup = ($groupObj->IFrameMode   == 2)? (int)1 : (int)0;
            $NewGroupObj->GroupMenu = !empty($groupObj->GroupMenu)?(int)$groupObj->GroupMenu:(int)0;
            $NewGroupObj->GroupUniqueName = preg_replace('/[^\p{L}\p{N}]/u', '', str_replace(" ","",$groupObj->GroupName));
            $NewGroupObj->SegmentId = (int)(isset($groupObj->SegmentId) ? $groupObj->SegmentId : 0);
            $NewGroupObj->NetworkId = (int)(isset($groupObj->NetworkId) ? $groupObj->NetworkId : 1);
       
            if($groupObj->RestrictedAccess!=0 && $groupObj->IsPrivate!=0){
            if ($groupObj->SubSpeciality[0] != 'PleaseSelect') {
                if (count($groupObj->SubSpeciality) > 0) {
                    foreach ($groupObj->SubSpeciality as $spe) {
                        array_push($NewGroupObj->Speciality, (int) $spe);
                    }
                }
            }
            }
            $NewGroupObj->RestrictedAccess = (int) $groupObj->RestrictedAccess;
            if ($NewGroupObj->save()) {
                $returnValue = $NewGroupObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:saveNewGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in GroupCollection->saveNewGroup==".$ex->getMessage());
        }
    }

    /**
     * @author Vamsi Krishna
     * @param type $Groupid
     * @description This method is used to get the groupDetails
     * @return object type MongoId
     */
    public function getGroupDetailsById($groupId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($groupId));
            $groupObj = GroupCollection::model()->find($criteria);
            if (is_object($groupObj)) {
                $returnValue = $groupObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getGroupDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    /**
     * @author Praneeth
     * Description: Method to get the groups in which user is a member
     * @param type $groupIdsArray
     * @return Groupsdetails
     */
    public function userFollowingGroupsList($groupIdsArray, $segmentId=0) {
        try {
            $segmentIdArray = array(0);
            if($segmentId!=0){
                $segmentIdArray = array($segmentId,0);
            }
            $groupsFollowingObj = "";
            $resultArray = array();
            $returnValue = 'noGroups';
            $array = array(
                'limit' => 8,
                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
            );
            $criteria = new EMongoCriteria($array);
            // $criteria->setSelect(array('_id'=>true,'GroupName'=>true));
            $criteria->_id('in', $groupIdsArray);
            if($segmentId!=""){
                $criteria->SegmentId('in', $segmentIdArray);
            }
            $groupsFollowingObj = GroupCollection::model()->findAll($criteria);
        } catch (Exception $ex) {
            Yii::log("GroupCollection:userFollowingGroupsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $groupsFollowingObj;
    }

    /**
     * @author Praneeth
     * Description: Method to get more groups in which user is a member
     * @param type $groupIdsArray, $startLimit, $pageLength
     * @return Groupsdetails
     */
    public function userMoreFollowingGroupsList($groupIdsArray, $startLimit, $pageLength, $segmentId=0) {
        try {
            $segmentIdArray = array(0);
            if($segmentId!=0){
                $segmentIdArray = array($segmentId,0);
            }
            $array = array(
                'limit' => 8,
                'offset' => $startLimit,
                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
            );
            $criteria = new EMongoCriteria($array);
            $criteria->_id('in', $groupIdsArray);
            if($segmentId!=""){
                $criteria->SegmentId('in', $segmentIdArray);
            }
            $groupsFollowingObj = GroupCollection::model()->findAll($criteria);
            if (isset($groupsFollowingObj)) {
                $returnValue = $groupsFollowingObj;
            }
        } catch (Exception $ex) {
            Yii::log("GroupCollection:userMoreFollowingGroupsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }

    /**
     * author Vamsi Krishna 
     *  This method is used to update the Group Details
     * @param type $userId
     * @param type $type
     * @param type $value
     */
    public function updateGroupDetails($userId, $value, $type, $groupId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;

            $mongoModifier->addModifier($type, 'set', $value);
            $mongoModifier->addModifier('LastUpdatedBy', 'set', $userId);
            $mongoCriteria->addCond('_id', '==', new MongoID($groupId));
            GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:updateGroupDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * 
     */
    public function followOrUnfollowGroup($groupId, $userId, $actionType) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if (trim($actionType) == 'Follow') {
                $mongoModifier->addModifier('GroupMembers', 'push', (int) $userId);
                $mongoCriteria->addCond('GroupMembers', '!=', (int) $userId);
            } else if (trim($actionType) == 'UnFollow') {                
                $mongoModifier->addModifier('GroupMembers', 'pull', $userId);
            }

            $mongoCriteria->addCond('_id', '==', new MongoId($groupId));
            $returnValue = GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("GroupCollection:followOrUnfollowGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getUserGroupCount($userId) {
        try {
            $countValue = 'noGroups';
            $criteria = new EMongoCriteria();
            $criteria->_id('in', $groupIdsArray);
            $countValue = GroupCollection::model()->count($criteria);
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getUserGroupCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Vamsi Krishna
     * This method is used to update Group with Array Type
     * @param MongoId $groupId 
     * @param MongoId $value
     * @param MongoId $type
     */
    public function updateGroupCollectionForArrayType($groupId, $value, $type) {
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($type == 'PostIds') {
                $mongoModifier->addModifier($type, 'push', new MongoId($value));
            }
            if ($type == 'GroupAdminUsers') {
                $mongoModifier->addModifier($type, 'push', new MongoId($value));
            }
            if ($type == 'SubGroups') {
                $mongoModifier->addModifier($type, 'push', new MongoId($value));
            }
            $mongoCriteria->addCond('_id', '==', new MongoId($groupId));
            $returnValue = GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("GroupCollection:updateGroupCollectionForArrayType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /* This method checks whether the group exist or not
     */

    public function checkIfGroupExist($model) {
        try {
            $result = 'false';
            $groupName = trim($model->GroupName);
            $groupIsExists = GroupCollection::model()->findByAttributes(array("GroupName" => $groupName));
            if (isset($groupIsExists)) {
                $result = 'true';
            } else {
                $result = 'false';
            }
        } catch (Exception $ex) {
            Yii::log("GroupCollection:checkIfGroupExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }

    public function getGroupIdByName($groupName) {
        try {
            $returnValue = 'failure';
            $groupName = str_replace("%20", " ", $groupName);
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id' => true));
            $criteria->addCond('GroupUniqueName', '==', $groupName);
            $groupObj = GroupCollection::model()->find($criteria);
            if (is_object($groupObj)) {
                $returnValue = $groupObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getGroupIdByName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    public function updateGroupCollectionForDelete($obj, $groupId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;

            if ($obj->ActionType == 'Block' || $obj->ActionType == 'Abuse' || $obj->ActionType == 'Delete') {
                $mongoModifier->addModifier('PostIds', 'pop', $obj->PostId);
            } else if ($obj->ActionType == 'Release') {
                $mongoModifier->addModifier('PostIds', 'push', new MongoID($obj->PostId));
            }

            $mongoCriteria->addCond('_id', '==', new MongoID($groupId));
            GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:updateGroupCollectionForDelete::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getGroupObjectByName($groupName) {
        $returnValue = 'failure';
        try {
            $groupName = str_replace("%20", " ", $groupName);
            $criteria = new EMongoCriteria;
            $criteria->addCond('GroupUniqueName', '==', $groupName);
            $groupObj = GroupCollection::model()->find($criteria);
            if (is_object($groupObj)) {
                $returnValue = $groupObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getGroupObjectByName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    /**
     * @author Karteek V
     * This method is used to fetche the total no. of counts in the Group Collection
     * @return type
     */
    public function getGroupsCount($segmentId=0) {
        try {
            $criteria = new EMongoCriteria;
            if($segmentId!=0){
                $criteria->addCond('SegmentId', '==', $segmentId);
            }
            return GroupCollection::model()->count($criteria);
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getGroupsCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in GroupCollection->getGroupsCount==".$ex->getMessage());
        }
    }

    /**
     * ---------------------------Purpose: For DataMigration ---------------------
     * @Method:This method is used to get the group id by using group name
     * @param type $groupName
     * @return type object
     *  @author Praneeth
     */
    public function getGroupIdByGroupName($groupName) {
        try {
            $returnValue = 'Nogroup';
            $mongoCriteria = new EMongoCriteria;
         //   $mongoCriteria->addCond('GroupName', 'equals', $groupName);
              $mongoCriteria->GroupName = new MongoRegex('/' . $groupName . '/i');
            $groupObj = GroupCollection::model()->find($mongoCriteria);
            $returnValue = $groupObj;
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getGroupIdByGroupName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function checkIsGroupAdminById($groupostobject) {
        try {

            $returnValue = 'false';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($groupostobject->GroupId));
            $criteria->addCond('GroupAdminUsers', 'equals', $groupostobject->UserId);
            $groupObj = GroupCollection::model()->find($criteria);
            if (is_object($groupObj)) {
                $returnValue = 'true';
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:checkIsGroupAdminById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    public function getAllGroupIds() {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id' => true));
            $criteria->setSelect(array('GroupName' => true));
            $groupObj = GroupCollection::model()->findAll($criteria);
//            if(is_object($groupObj)){
//                $returnValue=$groupObj;
//            }
            return $groupObj;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getAllGroupIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    public function findGroupBySubgroupId($subgroupId) {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id' => true));
            $criteria->addCond('SubGroups', 'in', array(new MongoId($subgroupId)));
            $groupObj = GroupCollection::model()->find($criteria);
//            if(is_object($groupObj)){
//                $returnValue=$groupObj;
//            }
            return $groupObj->_id;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:findGroupBySubgroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in GroupCollection->findGroupBySubgroupId==".$ex->getMessage());
            return $returnValue;
        }
    }

    public function getAllAutoFollowGroups($networkId,$segmentId) {
        $returnValue = 'failure';
        try {
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id' => true));
            $criteria->addCond('AutoFollow', '==', (int) 1);
            $criteria->addCond('NetworkId', '==', (int) $networkId);
            $criteria->addCond('SegmentId', '==', (int) $segmentId);
            $groups = GroupCollection::model()->findAll($criteria);
            
            if (is_array($groups) || is_object($groups)) {
                $returnValue = $groups;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getAllAutoFollowGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
    public function checkUserFollowAgroup($userId, $object) {
        try {
            
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('GroupMembers' => true));
            $criteria->addCond("_id", "==", new MongoId($object->GroupId));
            $groupObj = GroupCollection::model()->find($criteria);
            if (isset($groupObj->GroupMembers)) {
                return in_array($userId, $groupObj->GroupMembers);
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            Yii::log("GroupCollection:checkUserFollowAgroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getGroupByIds($postId) {
        try {
            $returnArr = array();
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            $groupCollectionObj = GroupPostCollection::model()->find($criteria);
//            $criteria = new EMongoCriteria;
//            $criteria->addCond('_id', '==', new MongoID($groupCollectionObj->GroupId));
//            $postObj = GroupCollection::model()->find($criteria);
            if (is_object($groupCollectionObj)) {
                $returnArr['PostId'] = $postId;
                $returnArr['FollowCount'] = count($groupCollectionObj->Followers);
            }
            return $returnArr;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getGroupByIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function getGroupDetailsByMigratedId($groupId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('MigratedGroupId', '==', $groupId);
            $groupObj = GroupCollection::model()->find($criteria);
            if (is_object($groupObj)) {
                $returnValue = $groupObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getGroupDetailsByMigratedId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    public function getGroupDetailsWithoutGroupMembersByGroupId($groupId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id' => true, 'GroupName' => true));
            $criteria->addCond('_id', '==', new MongoID($groupId));
            $groupObj = GroupCollection::model()->find($criteria);
            if (is_object($groupObj)) {
                $returnValue = $groupObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getGroupDetailsWithoutGroupMembersByGroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function getAllNativeGroupIds() {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id' => true));
            $criteria->setSelect(array('GroupName' => true));
            $criteria->addCond('IsIFrameMode', '==', (int)0);
            $groupObj = GroupCollection::model()->findAll($criteria);
//            if(is_object($groupObj)){
//                $returnValue=$groupObj;
//            }
            return $groupObj;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getAllNativeGroupIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
     /**
     * @author swathi
     * Description: Method to get the groups in which user is a member
     * @param type $groupIdsArray
     * @return Groupsdetails
     */
    public function userGroupsList($groupIdsArray,$startLimit,$pageLength) {
        try {
            $groupsFollowingObj = "";
            $resultArray = array();
            $returnValue = 'noGroups';
            if($pageLength==0)
            {
                 $array = array(
               
               'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
            );
            }
            else {
                       $array = array(
                            'limit' =>5,
                           'offset' => $startLimit,
                           'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
                       );
            }
            $criteria = new EMongoCriteria($array);
            // $criteria->setSelect(array('_id'=>true,'GroupName'=>true));
            if(count($groupIdsArray)>0)
            $criteria->_id('in', $groupIdsArray);
            $groupsFollowingObj = GroupCollection::model()->findAll($criteria);
        } catch (Exception $ex) {
            Yii::log("GroupCollection:userGroupsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $groupsFollowingObj;
    }
  
    public function updateGroupUniqueName($id,$gname){
        try{
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;

            $mongoModifier->addModifier('GroupUniqueName', 'set', (string) $gname);
            $mongoCriteria->addCond('_id', '==', new MongoID($id));
            if(GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:updateGroupUniqueName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in GroupCollection->updateGroupUniqueName==".$ex->getMessage());
        }
    }
    
 public function updateGroupDetailsById($GroupObject) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('_id', '==', new MongoId($GroupObject->id));
            $mongoModifier->addModifier('GroupDescription', 'set', $GroupObject->Description);
            $mongoModifier->addModifier('ConversationVisibility', 'set', (int)$GroupObject->ConversationVisibility);
            $mongoModifier->addModifier('AutoFollow', 'set', (int)$GroupObject->AutoFollow);
            $mongoModifier->addModifier('AddSocialActions', 'set', (int)$GroupObject->AddSocialActions);
            $mongoModifier->addModifier('DisableWebPreview', 'set', (int)$GroupObject->DisableWebPreview);
            $mongoModifier->addModifier('DisableStreamConversation', 'set', (int)$GroupObject->DisableStreamConversation);
            $specialityArray=array();   
            if ($GroupObject->SubSpeciality[0] != 'PleaseSelect') {
                if (count($GroupObject->SubSpeciality) > 0) {
                    foreach ($GroupObject->SubSpeciality as $spe) {
                        array_push($specialityArray, (int) $spe);
                    }
                }
            }
            $mongoModifier->addModifier('Speciality', 'set', $specialityArray);

            
            if($GroupObject->Status==1)
            $mongoModifier->addModifier('Status', 'set', (int)0);
            else
                $mongoModifier->addModifier('Status', 'set', (int)1);
                


            if(!empty($GroupObject->GroupProfileImage)){
               $mongoModifier->addModifier('GroupProfileImage', 'set', $GroupObject->GroupProfileImage);  
            }
            
            if(isset($GroupObject->IFrameMode) &&  $GroupObject->IFrameMode == 0){
               $mongoModifier->addModifier('IsIFrameMode', 'set', (int)0);
               $mongoModifier->addModifier('IFrameURL', 'set', '');
//               $mongoModifier->addModifier('IsHybrid', 'set', (int)0);
            }else{
                $mongoModifier->addModifier('IsIFrameMode', 'set', (int) $GroupObject->IFrameMode);
                $mongoModifier->addModifier('IFrameURL', 'set', $GroupObject->IFrameURL);
            }
          $result=GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
          if(!isset($result['err']))              
            $returnValue="success";
          
            return $returnValue;
        } catch (Exception $ex) {
            return $returnValue;
            Yii::log("GroupCollection:updateGroupDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    


    /**
     * @author Reddy
     * Description: Method to get the groups in which user is a member
     * @param type $groupIdsArray
     * @return Groupsdetails
     */
    public function userUnfollowAllGroups($UserId) {
        try {
            $returnValue="failure";
            $followingList=  UserProfileCollection::model()->getUserFollowingGroups((int)$UserId);
     
                  for ($i = 0; $i < sizeof($followingList); $i++) {
                    $mongoCriteria = new EMongoCriteria;
                    $mongoModifier = new EMongoModifier;
                    $groupId = $followingList[$i];
                    $mongoCriteria->addCond('_id', '==',new MongoID($groupId));
                    $mongoCriteria->addCond('SegmentId', '!=',0);
                    $mongoModifier->addModifier('GroupMembers', 'pop', (int)$UserId);
                    GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
                }
                $mongoCriteria = new EMongoCriteria;
                $mongoModifier = new EMongoModifier;
                $mongoCriteria->addCond('userId', '==', (int)$UserId);
                $mongoModifier->addModifier('groupsFollowing', 'set', array());
                $mongoModifier->addModifier('userVisitedGroupIds', 'set', array());
                UserProfileCollection::model()->updateAll($mongoModifier,$mongoCriteria);
                $returnValue="success";
            
        } catch (Exception $ex) {
            Yii::log("GroupCollection:userUnfollowAllGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $returnValue;
    }
    public function userFollowingAllGroups($groupIdsArray, $segmentId="") {
        try {
            $groupsFollowing = array();
            $resultArray = array();
            $returnValue = 'noGroups';
            $criteria = new EMongoCriteria();
            $criteria->_id('in', $groupIdsArray);
            if($segmentId!=""){
                $criteria->SegmentId('==', (int)$segmentId);
            }
            $groupsFollowingObj = GroupCollection::model()->findAll($criteria);
            if (is_object($groupsFollowingObj) || is_array($groupsFollowingObj)) {
                $groupsFollowing = $groupsFollowingObj;
            }
        } catch (Exception $ex) {
            Yii::log("GroupCollection:userFollowingAllGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $groupsFollowing;
    }
    public function getGroupSpecialityById($groupId){
         try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id' => true, 'Speciality' => true,'Status'=>true));
            $criteria->addCond('_id', '==', new MongoID($groupId));
            $groupObj = GroupCollection::model()->find($criteria);
            if (is_object($groupObj)) {
                $returnValue = $groupObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getGroupSpecialityById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
   public function getGroupIdsBasedOnSpeciality($subSpecialityId,$segmentId=0){
       $returnValue='failure';
       try {
           $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id' => true));
            $criteria->addCond('Speciality', '==', (int)$subSpecialityId);
             $criteria->addCond('SegmentId', 'in', array(0,$segmentId));
            $groupIds = GroupCollection::model()->findAll($criteria);
            if(is_array($groupIds)){
               $returnValue =$groupIds;
            }
            return $returnValue;   
       } catch (Exception $ex) {
           Yii::log("GroupCollection:getGroupIdsBasedOnSpeciality::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      } 

   public function getGroupPostIds($groupId){
       $returnValue='failure';
       try {
           $mongoCriteria = new EMongoCriteria;
           $mongoCriteria->setSelect(array('PostIds' => true));
           $mongoCriteria->addCond('_id', '==', new MongoId($groupId));
           $groupObj = GroupCollection::model()->find($mongoCriteria);
           if(is_object($groupObj)){
               $returnValue =$groupObj;
           }
           
           return $returnValue;
       } catch (Exception $ex) {
           Yii::log("GroupCollection:getGroupPostIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in GroupCollection->getGroupPostIds==".$ex->getMessage());
       }
      }
      
   public function getGroupsInactive(){
       $returnValue='failure';
       try {
           $mongoCriteria = new EMongoCriteria;
           $mongoCriteria->addCond('Status', '==', (int)0);
           $groupObj = GroupCollection::model()->findAll($mongoCriteria);
           if(is_array($groupObj)){
               $returnValue=$groupObj;
           }
           
       } catch (Exception $ex) {
           Yii::log("GroupCollection:getGroupsInactive::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in GroupCollection->getGroupsInactive==".$ex->getMessage());
       }
      }   
      
   public function checkGroupStatus($groupId){
         $returnValue = 'failure';
       try {         
            $criteria = new EMongoCriteria;            
            $criteria->addCond('_id', '==', new MongoID($groupId));  
            $criteria->setSelect(array('Status'=>true));
            $groupObj = GroupCollection::model()->find($criteria);
            if (is_object($groupObj)) {
                $returnValue = $groupObj;
            }
            return $returnValue;
       } catch (Exception $ex) {
             $returnValue = 'failure';
             Yii::log("GroupCollection:checkGroupStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in GroupCollection->checkGroupStatus==".$ex->getMessage());
       }
      }
/**
    * @author vamsi krishna
    * This method is used to track the custom group tab click
    */
   
    public function getCustomGroupDetails($groupName) {
        try {
            $returnValue = 'failure';
            $groupName = str_replace("%20", " ", $groupName);
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id' => true,'SegmentId'=>true));
            $criteria->addCond('CustomGroupName', '==', $groupName);
            $groupObj = GroupCollection::model()->find($criteria);
            if (is_object($groupObj)) {
                $returnValue = $groupObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getCustomGroupDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }


   public function getPublicGroupsCount() {
        try {
            $count = 0;
            $criteria = new EMongoCriteria;
            $criteria->addCond('IsPrivate', '==', 0);
            $count = GroupCollection::model()->count($criteria);
            return $count;
        } catch (Exception $ex) {
            Yii::log("GroupCollection:getPublicGroupsCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
     /**
     * @author Praneeth
     * Description: Method to get the groups in which user is a member
     * @param type $groupIdsArray
     * @return Groupsdetails
     */
    public function userFollowingGroupsListWithOutFollowers($groupIdsArray, $segmentId=0) {
        try {
            $segmentIdArray = array(0);
            if($segmentId!=0){
                $segmentIdArray = array($segmentId,0);
            }
            $groupsFollowingObj = "";
            $resultArray = array();
            $returnValue = 'noGroups';
            $array = array(
                'limit' => 8,
                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
            );
            $criteria = new EMongoCriteria($array);
             $criteria->setSelect(array('_id'=>true,'GroupName'=>true,'GroupUniqueName'=>true,'GroupProfileImage'=>true));
            $criteria->_id('in', $groupIdsArray);
            if($segmentId!=""){
                $criteria->SegmentId('in', $segmentIdArray);
            }
            $groupsFollowingObj = GroupCollection::model()->findAll($criteria);
        } catch (Exception $ex) {
            Yii::log("GroupCollection:userFollowingGroupsListWithOutFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        return $groupsFollowingObj;
    }

}
