<?php
/**
 * This collection is used to create a new group
 * @author Praneeth
 */
class SubGroupCollection extends EMongoDocument {

    public $_id;    
    public $CreatedUserId;
    public $SubGroupName;
    public $CreatedOn;
    public $GroupId;
    public $SubGroupBannerImage;  
    public $SubGroupDescription;
    public $SubGroupFollowers;
    public $SubGroupProfileImage;
    public $SubGroupMembers=array();
    public $LastUpdatedBy;
    public $SubGroupAdminUsers=array();
    public $PostIds=array();
    public $Status=1;
    public $ShowPostInMainStream=0;
    public $AddSocialActions;
    public $DisableWebPreview;
    public $SubGroupUniqueName = "";
    public $DisableStreamConversation=0;
   public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';
    
 

    public function getCollectionName() {
        return 'SubGroupCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_CreatedUserId' => array(
                'key' => array(
                    'CreatedUserId' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                    'SubGroupName' => EMongoCriteria::SORT_ASC,
                ),
            ),
            'index_SubGroupName' => array(
                'key' => array(
                    'SubGroupName' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            '_id'=>'_id',            
            'CreatedUserId' => 'CreatedUserId',
            'SubGroupName' => 'SubGroupName',
            'CreatedOn' => 'CreatedOn',
            'SubGroupDescription' => 'SubGroupDescription',
            'SubGroupFollowers'=>'SubGroupFollowers',            
            'SubGroupProfileImage' => 'SubGroupProfileImage',  
            'SubGroupMembers'=>'SubGroupMembers',
            'SubGroupBannerImage'=>'SubGroupBannerImage',
            'LastUpdatedBy'=>'LastUpdatedBy',
            'SubGroupAdminUsers'=>'SubGroupAdminUsers',
            'PostIds'=>'PostIds',
            'GroupId'=>'GroupId',
            'ShowPostInMainStream'=>'ShowPostInMainStream',
            'AddSocialActions'=>'AddSocialActions',
             'DisableWebPreview'=>'DisableWebPreview',
            'SubGroupUniqueName' => 'SubGroupUniqueName',
            'DisableStreamConversation'=>'DisableStreamConversation',
            'NetworkId' => 'NetworkId',
            'SegmentId' => 'SegmentId',
            'Language' => 'Language',
            'Status'=>'Status',
        );
    }
/**
     * @author Vamsi Krishna
     * @param type SubGroupObj
     * @method TO Create a new Subgroup
     * @return object type MongoId value
     */
public function saveSubGroup($groupObj,$UserId,$networkAdminUserId) {
        try {
            $returnValue = 'failure';
            $NewGroupObj = new SubGroupCollection();
            $NewGroupObj->SubGroupName = trim($groupObj->SubGroupName);
            $NewGroupObj->CreatedUserId = (int)$groupObj->UserId;
            $NewGroupObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));           
            $NewGroupObj->SubGroupDescription = $groupObj->SubGroupDescription;
            $NewGroupObj->GroupId=new MongoId($groupObj->GroupId);
            $NewGroupObj->SubGroupFollowers = array();
            $NewGroupObj->SubGroupMembers = array();
            array_push($NewGroupObj->SubGroupMembers,(int)$groupObj->UserId);
            if(Yii::app()->session['PostAsNetwork']!=1){
                array_push($NewGroupObj->SubGroupMembers,(int)(Yii::app()->session['NetworkAdminUserId']));
            }
            
            array_push($NewGroupObj->SubGroupAdminUsers,(int)$groupObj->UserId);
            if($UserId != $networkAdminUserId){
                array_push($NewGroupObj->SubGroupAdminUsers,(int) $networkAdminUserId);                
            }
            $NewGroupObj->SubGroupBannerImage='/images/system/nogroup.png';
            $NewGroupObj->SubGroupProfileImage='/images/system/grouplogo.png';
            $NewGroupObj->ShowPostInMainStream=(int)$groupObj->ShowPostInMainStream;

            $NewGroupObj->AddSocialActions=(int)$groupObj->AddSocialActions;
            $NewGroupObj->DisableWebPreview=(int)$groupObj->DisableWebPreview;
            $NewGroupObj->SubGroupUniqueName = preg_replace('/[^\p{L}\p{N}]/u', '', str_replace(" ","",$groupObj->SubGroupName));
            $NewGroupObj->DisableStreamConversation = (int) $groupObj->DisableStreamConversation;
            $NewGroupObj->NetworkId=(int)$groupObj->NetworkId;
            $NewGroupObj->SegmentId=(int)$groupObj->SegmentId;
            $NewGroupObj->Language=$groupObj->Language;
            
            if ($NewGroupObj->save()) {
                $returnValue = $NewGroupObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:saveSubGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /**
     * @author Praneeth
     * Description: Method to get the groups in which user is a member
     * @param type $groupIdsArray
     * @return Groupsdetails
     */
    public function userFollowingGroupsList($groupIdsArray,$groupId)
    {
        try
        {
            $groupsFollowingObj="";
            $resultArray= array();
            $returnValue = 'noGroups';
            $array = array(
                'limit' => 8,
                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
                
            );
            $criteria = new EMongoCriteria($array);
            $criteria->_id('in',$groupIdsArray);
            $criteria->addCond("Status", '==', (int)1);
            $groupsFollowingObj = SubGroupCollection::model()->findAll($criteria);
        
        } catch (Exception $ex) {           
            Yii::log("SubGroupCollection:userFollowingGroupsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       
        return $groupsFollowingObj;
    }
    
    /**
     * @author Praneeth
     * Description: Method to get more groups in which user is a member
     * @param type $groupIdsArray, $startLimit, $pageLength
     * @return Groupsdetails
     */

    public function userMoreFollowingGroupsList($SubGroupIdsArray, $startLimit, $pageLength)
    {
        try
        {
            $array = array(
                'limit' => 8,
                'offset' => $startLimit,
                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
            );
            $criteria = new EMongoCriteria($array);
            $criteria->_id('in',$SubGroupIdsArray);
            $groupsFollowingObj = SubGroupCollection::model()->findAll($criteria);
            if (isset($groupsFollowingObj)) {
                    $returnValue =$groupsFollowingObj;
                }
        } catch (Exception $ex) {
        Yii::log("SubGroupCollection:userMoreFollowingGroupsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
    public function updateGroupDetails($userId,$value,$type,$groupId) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
             if($type=='GroupProfileImage'){
                 $type='SubGroupProfileImage';
             }else if($type=='GroupBannerImage'){
                 $type="SubGroupBannerImage";
             }
             else if($type=='GroupDescription'){
                 $type="SubGroupDescription";
             }
             else if($type=='ShowPostInMainStream'){
                 $type="ShowPostInMainStream";
             }
            $mongoModifier->addModifier($type, 'set', $value); 
            $mongoModifier->addModifier('LastUpdatedBy', 'set', $userId); 
            $mongoCriteria->addCond('_id', '==',  new MongoID($groupId)); 
           SubGroupCollection::model()->updateAll($mongoModifier,$mongoCriteria);
           $returnValue ="success";
           return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:updateGroupDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


    
    /**
     * 
     */
    public function followOrUnfollowSubGroup($subGroupId, $userId, $actionType)
    {
        try
        {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow') {
                $mongoModifier->addModifier('SubGroupMembers', 'push', $userId);
            } else if($actionType == 'UnFollow'){
                $mongoModifier->addModifier('SubGroupMembers', 'pull', $userId);
            }

            $mongoCriteria->addCond('_id', '==', new MongoId($subGroupId));
            $returnValue = SubGroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:followOrUnfollowSubGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getUserGroupCount($userId) {
        try {
            $countValue = 'noGroups';
            $criteria = new EMongoCriteria();
            $criteria->_id('in', $groupIdsArray);
            $countValue = SubGroupCollection::model()->count($criteria);
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:getUserGroupCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
       /**
 * @author Vamsi Krishna
 * This method is used to update Group with Array Type
 * @param MongoId $groupId 
 * @param MongoId $value
 * @param MongoId $type
 */
    public function updateGroupCollectionForArrayType($groupId,$value,$type){
        try {
            
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if($type=='PostIds'){
              $mongoModifier->addModifier($type, 'push', new MongoId($value));    
            }
            if($type=='SubGroupAdminUsers'){
              $mongoModifier->addModifier($type, 'push', new MongoId($value));    
            }           
            $mongoCriteria->addCond('_id', '==', new MongoId($groupId));
            $returnValue = SubGroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:updateGroupCollectionForArrayType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        
         /* This method checks whether the group exist or not
     */

    public function checkIfGroupExist($model) {
        try {
            $result = 'false';
            $groupName = trim($model->SubGroupName);
              $mongoCriteria = new EMongoCriteria;
              
             $mongoCriteria->addCond('SubGroupName', '==', $groupName);
             $mongoCriteria->addCond('GroupId', '==', new MongoId($model->GroupId));            
            $groupIsExists = SubGroupCollection::model()->find($mongoCriteria);
            
            if (isset($groupIsExists)) {
                $result = 'true';
            } else {
                $result = 'false';
            }
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:checkIfGroupExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
   
     public function getSubGroupIdByName($subgroupName,$groupId) {
        try {
            $returnValue = 'failure';
            $subgroupName = str_replace("%20", " ", $subgroupName);
            $criteria = new EMongoCriteria;
             $criteria->setSelect(array('_id'=>true));
            $criteria->addCond('SubGroupUniqueName', '==', $subgroupName);
            $criteria->addCond('GroupId', '==', new MongoId($groupId)); 
            $groupObj=SubGroupCollection::model()->find($criteria);
            if(is_object($groupObj)){
                $returnValue=$groupObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:getSubGroupIdByName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

    
    public function updateGroupCollectionForDelete($obj,$groupId) {
        try {
            $returnValue = 'failure';            
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            
               if($obj->ActionType=='Block' || $obj->ActionType=='Abuse' || $obj->ActionType=='Delete' ){
           $mongoModifier->addModifier('PostIds', 'pop', $obj->PostId);  
           
           }else if($obj->ActionType=='Release'){
             $mongoModifier->addModifier('PostIds', 'push', new MongoID($obj->PostId));      
           }  
            
           $mongoCriteria->addCond('_id', '==',  new MongoID($groupId)); 
           SubGroupCollection::model()->updateAll($mongoModifier,$mongoCriteria);
           $returnValue ="success";
           return $returnValue; 
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:updateGroupCollectionForDelete::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
 /**
     * @author Vamsi Krishna
     * @param type $userId
     * @description This method is used to user following sub groups
     * @return object type groupsList array
     */
 public function getUserFollowingSubGroups($userId)
    {
     $returnValue="failure";
        try
        {
            
            $groupsFollowingObj="";
            $groupsFollowingObj = SubGroupCollection::model()->findAllByAttributes(array("SubGroupMembers"=>$userId));
            if (isset($groupsFollowingObj)) {
                    $returnValue =$groupsFollowingObj;
                }
        } catch (Exception $ex) {
            return $returnValue;
                 Yii::log("SubGroupCollection:getUserFollowingSubGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $returnValue;
    }
    
     /**
     * @authorPraneeth
     * @param type $SubGroupid
     * @description This method is used to get the subgroupDetails
     * @return object type MongoId
     */
    public function getSubGroupDetailsById($subgroupId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($subgroupId));
            $subgroupObj=SubGroupCollection::model()->find($criteria);
            if(is_object($subgroupObj)){
                $returnValue=$subgroupObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:getSubGroupDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    /**
     * @author Vamsi Krishna
     * @param $groupId ,$userId,$actiontype
     * @description This method is used to remove or add user in all the subGroups for a particular Group
     * 
     */
    public function removeOrAddUserInAllSubGroupsByGroupId($groupId,$userId,$actionType){
        try {
            $returnValue = 'failure';
             $mongoCriteria = new EMongoCriteria;
             $mongoModifier = new EMongoModifier;
              if($actionType=='UnFollow' ){
           $mongoModifier->addModifier('SubGroupMembers', 'pull', $userId);             
           }
            if($actionType=='Follow' ){
           $mongoModifier->addModifier('SubGroupMembers', 'push', $userId);  
           
           }
            
           $mongoCriteria->addCond('GroupId', '==',  new MongoID($groupId)); 
           SubGroupCollection::model()->updateAll($mongoModifier,$mongoCriteria);
           $returnValue ="success";
           return $returnValue; 
            
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:removeOrAddUserInAllSubGroupsByGroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
        }
    

    public function getAllSubGroupIds() {
        try {
            $returnValue = 'failure';
            
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id'=>true,'GroupId'=>true,'SubGroupName'=>true));
            $SubgroupObj=SubGroupCollection::model()->findAll($criteria);

            return $SubgroupObj;
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:getAllSubGroupIds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }    
    
    public function checkUserFollowAgroup($userId,$object){
        try{
           
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('SubGroupMembers'=>true));
            $criteria->addCond("_id","==", new MongoId($object->SubGroupId));
            $SubgroupObj=SubGroupCollection::model()->find($criteria);
           
            if(isset($SubgroupObj->SubGroupMembers)){
                return in_array($userId, $SubgroupObj->SubGroupMembers);
            }else{
                return 0;
            }            
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:checkUserFollowAgroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SubGroupCollection->checkUserFollowAgroup==".$ex->getMessage());
        }
    }
    
 public function getSubGroupDetailsWithoutGroupMembersByGroupId($subgroupId){
        try {
            $returnValue = 'failure';            
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('_id'=>true,'SubGroupName'=>true));
            $criteria->addCond('_id', '==', new MongoID($subgroupId));
            $groupObj=SubGroupCollection::model()->find($criteria);
            if(is_object($groupObj)){
                $returnValue=$groupObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
           Yii::log("SubGroupCollection:getSubGroupDetailsWithoutGroupMembersByGroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

        
    }    
    
    public function updateSubGroupUniqueName($id,$gname){
        try{
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;

            $mongoModifier->addModifier('SubGroupUniqueName', 'set', (string) $gname);
            $mongoCriteria->addCond('_id', '==', new MongoID($id));
            if(SubGroupCollection::model()->updateAll($mongoModifier, $mongoCriteria)){
                $returnValue = "success";
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:updateSubGroupUniqueName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SubGroupCollection->updateSubGroupUniqueName==".$ex->getMessage());
        }
    }
  public function updateSubGroupDetailsById($subGroupObject) {
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;

            $mongoCriteria->addCond('_id', '==', new MongoId($subGroupObject->id));
            $mongoModifier->addModifier('SubGroupDescription', 'set', $subGroupObject->SubGroupDescription);
            $mongoModifier->addModifier('ShowPostInMainStream', 'set', (int)$subGroupObject->ShowPostInMainStream);
            $mongoModifier->addModifier('AddSocialActions', 'set', (int)$subGroupObject->AddSocialActions);
            $mongoModifier->addModifier('DisableWebPreview', 'set', (int)$subGroupObject->DisableWebPreview);
            $mongoModifier->addModifier('DisableStreamConversation', 'set', (int)$subGroupObject->DisableStreamConversation);
            
            if($subGroupObject->Status==1)
            $mongoModifier->addModifier('Status', 'set', (int)0);
            else
                $mongoModifier->addModifier('Status', 'set', (int)1);

            if(!empty($subGroupObject->GroupProfileImage)){
               $mongoModifier->addModifier('SubGroupProfileImage', 'set', $subGroupObject->GroupProfileImage);  
            }
            
           
            $result=SubGroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            if(!isset($result['err']))              
            $returnValue="success";
            
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SubGroupCollection:updateSubGroupDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
           
        }
    } 
    
  public function updateSubGroupStatus($groupId,$status){
      $returnValue = 'failure';
      try {          
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->addCond('GroupId', '==',  new MongoID($groupId));
            if($status==1){
            $mongoModifier->addModifier('Status', 'set', (int)0);
            }else{
            $mongoModifier->addModifier('Status', 'set', (int)1);     
            }
            SubGroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
      } catch (Exception $ex) {
          Yii::log("SubGroupCollection:updateSubGroupStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in SubGroupCollection->updateSubGroupStatus==".$ex->getMessage());
      }
    }
        
}

