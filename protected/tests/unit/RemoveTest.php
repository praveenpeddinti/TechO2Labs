<?php

class RemoveTest extends CDbTestCase {

//    public function testRemoveUserProfileDependencies() {
//        try {
//           
//            UserCollection::model()->removeGroupsFollowing();
//            
//            
//        } catch (Exception $exc) {
//            Yii::log($exc->getMessage(), 'error', 'application');
//        }
//    }
    
        public function testSaveUserSettings() {
        try {
           
          
            $object = User::model()->findAll();
            foreach($object as $rw){
                echo "@@@@@@@@@@@@@";
                $userSettings = new UserNotificationSettingsCollection();
                $userSettings->UserId = $rw->UserId;
                $userSettings->Commented = 1;
                $userSettings->Loved = 0;
                $userSettings->ActivityFollowed = 0;
                $userSettings->Mentioned = 1;
                $userSettings->Invited = 1;
                $userSettings->UserFollowers = 0;
                $userSettings->NetworkId = $rw->NetworkId;
                UserNotificationSettingsCollection::model()->saveUserSettings($rw->UserId,(int)$rw->NetworkId);
            }
            
            
        } catch (Exception $exc) {
            echo "@#################".$exc->getMessage();
            Yii::log($exc->getMessage(), 'error', 'application');
        }
    }
    


}
