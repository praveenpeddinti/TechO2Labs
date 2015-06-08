<?php
/**
 * DocCommand class file.
 *
 * @author Karteek V 
 *  @version 1.0
 */
class ExSurveyScheduleCommand extends CConsoleCommand {

    public function run($args) {
        $this->removeCurrentScheduleByEndDate();
        $this->updateCurrentSchedule();
    }
    
    function removeCurrentScheduleByEndDate() {
        try {
            
        $mongoModifier = new EMongoModifier;
        $mongoCriteria = new EMongoCriteria;  
     
        $mongoCriteria->addCond('EndDate', '<=',  new MongoDate());
        $mongoCriteria->addCond('IsCurrentSchedule','==',(int)1);
        $objects = ScheduleSurveyCollection::model()->findAll($mongoCriteria);         
        if(is_array($objects)){ 
            foreach($objects as $object){
                $mongoCriteria = new EMongoCriteria;
                $mongoCriteria->addCond('_id','==',new MongoId($object->SurveyId));
                $mongoModifier->addModifier('IsCurrentSchedule', 'set', (int) 0);
                ExtendedSurveyCollection::model()->updateAll($mongoModifier, $mongoCriteria);

                // this is for schedule collection...
                $mongoCriteria = new EMongoCriteria;            
                $mongoCriteria->addCond('_id','==',new MongoId($object->_id));
                $mongoModifier->addModifier('IsCurrentSchedule', 'set', (int)0);
                ScheduleSurveyCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            }

        }
        } catch (Exception $ex) {
            Yii::log("ExSurveyScheduleCommand:removeCurrentScheduleByEndDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExSurveyScheduleCommand->removeCurrentScheduleByEndDate==".$ex->getMessage());
        }
    }

    function updateCurrentSchedule() {
        try {
        $mongoCriteria = new EMongoCriteria;
        $modifier = new EMongoModifier;
        $criteria = new EMongoCriteria; 
       
         $mongoCriteria->addCond('StartDate', '<=',  new MongoDate());
         $mongoCriteria->addCond('EndDate', '>=',  new MongoDate());
      

        $objects = ScheduleSurveyCollection::model()->findAll($mongoCriteria);
        $groupArray = array();
        if (is_object($objects) || is_array($objects)) {
            foreach($objects as $object){                
                    $modifier = new EMongoModifier;
                    $criteria = new EMongoCriteria;
                    $criteria->addCond('_id', '==', new MongoId($object->_id));
                    $modifier->addModifier('IsCurrentSchedule', 'set', (int)0);
                    ScheduleSurveyCollection::model()->updateAll($modifier, $criteria);
                    
                    $modifier1 = new EMongoModifier;
                    $criteria1 = new EMongoCriteria;
                    
                    $criteria1->addCond('_id', '==', new MongoId($object->SurveyId));
                    $modifier1->addModifier('IsCurrentSchedule', 'set',(int)0);
                    ExtendedSurveyCollection::model()->updateAll($modifier1, $criteria1);
                if(!in_array($object->SurveyRelatedGroupName,$groupArray)){                    
                    $modifier = new EMongoModifier;
                    $criteria = new EMongoCriteria;
                    $criteria->addCond('_id', '==', new MongoId($object->_id));
                    $modifier->addModifier('IsCurrentSchedule', 'set', (int)1);
                    ScheduleSurveyCollection::model()->updateAll($modifier, $criteria);

                    $modifier1 = new EMongoModifier;
                    $criteria1 = new EMongoCriteria;
                    $criteria1->addCond('_id', '==', new MongoId($object->SurveyId));
                    $modifier1->addModifier('IsCurrentSchedule', 'set', (int)1);
                    ExtendedSurveyCollection::model()->updateAll($modifier1, $criteria1);
                    array_push($groupArray, $object->SurveyRelatedGroupName);
                }
               
            }
        } else {
            echo "not exist";            
        }
        
        } catch (Exception $ex) {
            echo $ex->getMessage(); 
            Yii::log("ExSurveyScheduleCommand:updateCurrentSchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

       
    }

}
