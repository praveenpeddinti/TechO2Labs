<?php
/**
 * This collection is used to create a new group
 * @author Praneeth
 */
class SessionCollection extends EMongoDocument {

   
    public $SecurityToken;
    public $RequestURI;
    public $TimeStamp;
    public $AccessType;
    public $ClickType;
    public $UserId;
    public $IP;
  

    

    public function getCollectionName() {
        return 'SessionCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_SecurityToken' => array(
                'key' => array(
                    'SecurityToken' => EMongoCriteria::SORT_ASC
                ),
            )
        );
    }
    public function attributeNames() {
        return array(
            '_id'=>'_id',            
            'SecurityToken' => 'SecurityToken',
            'RequestURI' => 'RequestURI',
            'TimeStamp' => 'TimeStamp',
            'AccessType' => 'AccessType',
            'ClickType'=>'ClickType',            
            'IP'=>'IP'
          
           
        );
    }
/**
     * @author suresh reddy
     * @param type $sessionObj
     * @method TO 
     * @return object type id value
     */
public function saveNewSession($sessionObj,$clientIP) {
        try {
        $returnValue = false;
        $date = time() - 86400;
        $mongoCriteria = new EMongoCriteria;            
        $mongoCriteria->addCond('IP', '==', $clientIP);
        $mongoCriteria->addCond('TimeStamp', '>=', gmdate("Y-m-d H:i:s", $date));
        $sessionDetails = SessionCollection::model()->find($mongoCriteria);
        if(isset($sessionDetails)){
        }
            
          
            $sesObj = new SessionCollection();
            $sesObj->SecurityToken = $sessionObj->SecurityToken;
            $sesObj->RequestURI = $sessionObj->RequestURI;
            $sesObj->TimeStamp = gmdate("Y-m-d H:i:s", time());
            $sesObj->AccessType = $sessionObj->AccessType;
            $sesObj->ClickType = $sessionObj->ClickType;
            $sesObj->IP = $clientIP;
            if ($sesObj->save()) {
                
            }
             if(isset($sessionDetails)){
               return 1;
            }else{
                return 0;
            }
           
        } catch (Exception $ex) {
            Yii::log("SessionCollection:saveNewSession::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            $groupObj=GroupCollection::model()->find($criteria);
            if(is_object($groupObj)){
                $returnValue=$groupObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SessionCollection:getGroupDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }


    
        
    
    /**
     * @author Praneeth
     * Description: Method to get the groups in which user is a member
     * @param type $groupIdsArray
     * @return Groupsdetails
     */
    public function userFollowingGroupsList($groupIdsArray)
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
            $groupsFollowingObj = GroupCollection::model()->findAll($criteria);
        
        } catch (Exception $ex) {
            Yii::log("SessionCollection:userFollowingGroupsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       
        return $groupsFollowingObj;
    }
    
    /**
     * @author Praneeth
     * Description: Method to get more groups in which user is a member
     * @param type $groupIdsArray, $startLimit, $pageLength
     * @return Groupsdetails
     */

    public function userMoreFollowingGroupsList($groupIdsArray, $startLimit, $pageLength)
    {
        try
        {
            $array = array(
                'limit' => 8,
                'offset' => $startLimit,
                'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC),
            );
            $criteria = new EMongoCriteria($array);
            $criteria->_id('in',$groupIdsArray);
            $groupsFollowingObj = GroupCollection::model()->findAll($criteria);
            if (isset($groupsFollowingObj)) {
                    $returnValue =$groupsFollowingObj;
                }
        } catch (Exception $ex) {
                 Yii::log("SessionCollection:userMoreFollowingGroupsList::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
                
            $mongoModifier->addModifier($type, 'set', $value); 
            $mongoModifier->addModifier('LastUpdatedBy', 'set', $userId); 
            $mongoCriteria->addCond('_id', '==',  new MongoID($groupId)); 
           GroupCollection::model()->updateAll($mongoModifier,$mongoCriteria);
           $returnValue ="success";
           return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SessionCollection:updateGroupDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


    
    /**
     * 
     */
    public function followOrUnfollowGroup($groupId, $userId, $actionType)
    {
        try
        {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($actionType == 'Follow') {
                $mongoModifier->addModifier('GroupMembers', 'push', $userId);
            } else if($actionType == 'UnFollow'){
                $mongoModifier->addModifier('GroupMembers', 'pull', $userId);
            }

            $mongoCriteria->addCond('_id', '==', new MongoId($groupId));
            $returnValue = GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            return 'success';
        } catch (Exception $ex) {
                Yii::log("SessionCollection:followOrUnfollowGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function getUserGroupCount($userId) {
        try {
            $countValue = 'noGroups';
            $criteria = new EMongoCriteria();
            $criteria->_id('in', $groupIdsArray);
            $countValue = GroupCollection::model()->count($criteria);
        } catch (Exception $ex) {
            Yii::log("SessionCollection:getUserGroupCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            if($type=='GroupAdminUsers'){
              $mongoModifier->addModifier($type, 'push', new MongoId($value));    
            }           
            $mongoCriteria->addCond('_id', '==', new MongoId($groupId));
            $returnValue = GroupCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("SessionCollection:updateGroupCollectionForArrayType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
            Yii::log("SessionCollection:checkIfGroupExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
   
     public function getGroupIdByName($groupName) {
        try {
            $returnValue = 'failure';
            $groupName = str_replace("%20", " ", $groupName);
            $criteria = new EMongoCriteria;
             $criteria->setSelect(array('_id'=>true));
            $criteria->addCond('GroupName', '==', $groupName);
            $groupObj=GroupCollection::model()->find($criteria);
            if(is_object($groupObj)){
                $returnValue=$groupObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SessionCollection:getGroupIdByName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
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
           GroupCollection::model()->updateAll($mongoModifier,$mongoCriteria);
           $returnValue ="success";
           return $returnValue; 
        } catch (Exception $ex) {
            Yii::log("SessionCollection:updateGroupCollectionForDelete::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

 

}
