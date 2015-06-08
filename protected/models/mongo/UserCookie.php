<?php

/** This is the collection for tiny user where we get the user data to use user data 

 */

class UserCookie extends EMongoDocument {

    public $userId;
   public  $cookieRandomKey;
   

    public function getCollectionName() {
        try{
        return 'UserCookie';
        } catch (Exception $ex) {
            Yii::log("UserCookie:getCollectionName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function indexes() {
        try{
        return array(
            'index_userId' => array(
                'key' => array(
                    'userId' => EMongoCriteria::SORT_ASC
                ),
            )
        );
        } catch (Exception $ex) {
            Yii::log("UserCookie:indexes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function attributeNames() {
        try{
            return array(
            'userId' => 'userId',
            'cookieRandomKey' => 'cookieRandomKey',
        );
        } catch (Exception $ex) {
            Yii::log("UserCookie:attributeNames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function model($className = __CLASS__) {
        try{
            return parent::model($className);
        } catch (Exception $ex) {
            Yii::log("UserCookie:model::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   
    /** 
     
     * this method is used to save the user colletion (tiny user) it accepts the user collection object 
      * if saves to the userCollection it returns the userID 
          */
    public function saveCookieRandomKeyForUser($userId,$randomKey) {
        try {
             $criteria = new EMongoCriteria;
            $criteria->addCond('userId', '==',(int)$userId);
            $userCookie = UserCookie::model()->find($criteria);
             if (is_object($userCookie)) {
                 $mongoModifier = new EMongoModifier;           
                 $mongoModifier->addModifier('cookieRandomKey', 'push', $randomKey);
                 $criteria = new EMongoCriteria;
                 $criteria->addCond('userId', '==',(int)$userId);
                 $userCookie->updateAll($mongoModifier, $criteria);
                 $returnValue = 'true';
             }
            else{
            $userCookie = new UserCookie();
            $userCookie->userId=(int)$userId;
            $userCookie->cookieRandomKey = array($randomKey);
            $userCookie->insert();
              if (isset($userCookie->_id)) {
                $returnValue = 'true';
              }  
            }
           
           
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCookie:saveCookieRandomKeyForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
  public function checkCookieValidityForUser($userId,$randomKey){
        try{
        $criteria = new EMongoCriteria;
            $criteria->addCond('userId', '==',(int)$userId);
            $criteria->addCond('cookieRandomKey', 'in',array($randomKey));
            $userCookie = UserCookie::model()->find($criteria);
             if (is_object($userCookie)) {
                  $returnValue = 'true';
             }else{
                  $returnValue = 'false';
             }
              return $returnValue;
        } catch (Exception $ex) {
            Yii::log("UserCookie:checkCookieValidityForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
  }
   public function deleteCookieRandomKeyForUser($userId,$randomKey){
        try{ 
            $criteria = new EMongoCriteria;
            $criteria->addCond('userId', '==',(int)$userId);
            $mongoModifier = new EMongoModifier;           
            $mongoModifier->addModifier('cookieRandomKey', 'pop', $randomKey);
            UserCookie::model()->updateAll($mongoModifier, $criteria);
        } catch (Exception $ex) {
            Yii::log("UserCookie:deleteCookieRandomKeyForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
   }

}
