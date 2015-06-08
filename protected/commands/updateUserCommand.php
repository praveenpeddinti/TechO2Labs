<?php

class updateUserCommand extends CConsoleCommand {

    public function run($args) {
        $this->updateUser();
    }
    


    public function updateUser() {
        try {
            $criteria = new EMongoCriteria();
            $searchKey = "University";
            $criteria->GroupName = new MongoRegex('/' . $searchKey . '.*/i');
            $data = GroupCollection::model()->findAll($criteria);

            foreach ($data as $obj) {
                $displayNameArray = explode(" ", $obj->GroupName);

                for ($i = 0; $i < sizeof($obj->GroupMembers); $i++) {
                    $mongoCriteria = new EMongoCriteria;
                    $mongoModifier = new EMongoModifier;
                    $userId = $obj->GroupMembers[$i];
                    $mongoCriteria->addCond('UserId', '==', (int) $userId);
                    
                    
                  //  $mongoModifier->addModifier('groupsFollowing', 'pop', $obj->_id);
                }

                $criteria->addCond('_id', '==', $obj->_id);

               // $return = GroupCollection::model()->deleteAll($criteria);
            }
        } catch (Exception $ex) {
            echo '_________Exception______________________' . $ex->getMessage();
            Yii::log("updateUserCommand:updateUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

 
    public function updateUsdfer() {
        try {
            $criteria = new EMongoCriteria();
            $searchKey = "University";
            $criteria->GroupName = new MongoRegex('/' . $searchKey . '.*/i');
            $data = GroupCollection::model()->findAll($criteria);

            foreach ($data as $obj) {
                $displayNameArray = explode(" ", $obj->GroupName);

                for ($i = 0; $i < sizeof($obj->GroupMembers); $i++) {
                    $mongoCriteria = new EMongoCriteria;
                    $mongoModifier = new EMongoModifier;
                    $userId = $obj->GroupMembers[$i];
                    $mongoCriteria->addCond('UserId', '==', (int) $userId);
                    $mongoModifier->addModifier('groupsFollowing', 'pop', $obj->_id);
                }

                $criteria->addCond('_id', '==', $obj->_id);

                $return = GroupCollection::model()->deleteAll($criteria);
            }
        } catch (Exception $ex) {
            echo '_________Exception______________________' . $ex->getMessage();
            Yii::log("updateUserCommand:updateUsdfer::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }   
    }
}