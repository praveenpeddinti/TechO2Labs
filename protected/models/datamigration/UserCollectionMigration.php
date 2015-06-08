<?php

/* This is the collection for tiny user where we get the user data to use user data 

 */

class UserCollectionMigration extends EMongoDocument {

    public $UserId;
    public $DisplayName;
    public $ProfilePicture;
    public $AboutMe;
    public $NetworkId;
    public $aboutMe;

    public function getCollectionName() {
        return 'TinyUserCollection';
    }

    public function attributeNames() {
        return array(
            'UserId' => 'UserId',
            'DisplayName' => 'DisplayName',
            'ProflePicture' => 'ProfilePicture',
            'NetworkId' => 'NetworkId',
            'AboutMe' => 'AboutMe',
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
   
    /* this method is used to save the user colletion (tiny user) it accepts the user collection object 
      * if saves to the userCollection it returns the userID 
          */
    public function saveUserCollection($userModel) {
        try {
            $returnValue = 'false';
            $userCollection = new UserCollectionMigration();
            $userCollection->UserId=$userModel->UserId;
            $userCollection->DisplayName = isset($userModel->DisplayName)?$userModel->DisplayName:"";
            $userCollection->ProfilePicture = isset($userModel->ProfilePicture)?$userModel->ProfilePicture:"";
            $userCollection->NetworkId = isset($userModel->NetworkId)?$userModel->NetworkId:"";
            $userCollection->AboutMe = isset($userModel->AboutMe)?$userModel->AboutMe:"";
            $userCollection->insert();
            if (isset($userCollection->_id)) {
                $returnValue = 'true';
            }
            return $returnValue;
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), 'error', 'application');
        }
    }

}
