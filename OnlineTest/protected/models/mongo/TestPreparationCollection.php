<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TestPreparationCollection extends EMongoDocument {
    public $_id;
    public $Title;
    public $Description;
    public $NoofQuestions;
    public $Category;
    public $CreatedOn;
    public $InviteUsers =0;
    public $TestInviteUsers =array();
    public $TestTakenUsers =array();
    public $TestTakenUsersCount =0;
   
    

    public function getCollectionName() {
        return 'TestPreparationCollection';
    }
 public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_survey' => array(
                'key' => array(
                    'Title' => EMongoCriteria::SORT_ASC,
                ),
                
            )
        );
    }
     public function attributeNames() {
     return array(
        '_id'=>'_id',
        'Title'=>'Title',
        'Description'=>'Description',
        'Category'=>'Category',
        'InviteUsers'=>'InviteUsers',
        'NoofQuestions'=>'NoofQuestions', 
        'TestInviteUsers'=>'TestInviteUsers',
        'TestTakenUsers'=>'TestTakenUsers',
        'CreatedOn'=>'CreatedOn',
        'TestTakenUsers'=>'TestTakenUsers',
        );
     }
     
     
     
     public function getTestDetailsById($columnName, $value) {
        try {
            
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            if ($columnName == 'Id') {
                
                $criteria->addCond('_id', '==', new MongoId($value));
            }else if ($columnName == 'Title') {
                $criteria->addCond('Title', '==', trim($value));
            }
            
            $TestPaperObj = TestPreparationCollection::model()->find($criteria);
            //if(count($TestPaperObj)>0){error_log("---if-get data----tess---".count($TestPaperObj));
                $returnValue= $TestPaperObj;
            //}
            
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("TestPreparationCollection:getTestDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TestPreparationCollection->getTestDetailsById==".$ex->getMessage());
        }
    }

     public function saveTestPrepair($FormModel,$UserId){
         try{             
             $returnValue = "failed";
             $survey = new TestPreparationCollection();
             $survey->Title = $FormModel->Title;
             $survey->Description = $FormModel->Description;
             $survey->Category = $FormModel->Questions;
             $survey->NoofQuestions = $FormModel->QuestionsCount;
             $survey->CreatedOn = new MongoDate(strtotime(date('Y-m-d', time())));
             if($survey->save()){
                 $returnValue = "success";
                 $questionprepareObj = $this->getTestDetails($survey->_id);
                 foreach($questionprepareObj->Category as $testarray){
                     $criteria = new EMongoCriteria;
                     $criteria->addCond("_id","==",new MongoId($testarray['ScheduleId']));
                     $scheduleObj = ScheduleSurveyCollection::model()->find($criteria);
                     $scheduleObj->TestId = $survey->_id;
                     if($scheduleObj->update()){
                         error_log("===Schedule ===++Update===$survey->_id=");
                     }
                 }
             }
             return $returnValue;
         } catch (Exception $ex) {
             Yii::log("TestPreparationCollection:saveTestPrepair::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             error_log("Exception Occurred in TestPreparationCollection->saveTestPrepair==".$ex->getMessage());
         }
     }
     
     public function updateTestPrepair($model,$_id) {
        try {
            
            $returnValue = 'failure';            
            $modifier = new EMongoModifier();
            $criteria = new EMongoCriteria();
            $criteria->addCond('_id', '==', new MongoId($_id));
            $modifier->addModifier('Title', 'set', $model->Title);
            $modifier->addModifier('Description', 'set', $model->Description);
            $modifier->addModifier('Category', 'set', $model->Questions);
            $modifier->addModifier('NoofQuestions', 'set', $model->QuestionsCount);
            $modifier->addModifier('CreatedOn', 'set', new MongoDate(strtotime(date('Y-m-d', time()))));            
              
            if(TestPreparationCollection::model()->updateAll($modifier, $criteria)){
                $returnvalue = "success";
            }
           
            return $returnvalue;
        } catch (Exception $ex) {
            Yii::log("ExtendedSurveyCollection:UpdateSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in ExtendedSurveyCollection->UpdateSurvey==".$ex->getMessage());
        }
    }
     
     public function getTestPreparationCollection(){
         try{
             $criteria = new EMongoCriteria;
             $criteria->setSelect(array("Category"=>true));
             return TestPreparationCollection::model()->findAll($criteria);
         } catch (Exception $ex) {
             Yii::log("TestPreparationCollection:getTestPreparationCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             error_log("Exception Occurred in TestPreparationCollection->getTestPreparationCollection==".$ex->getMessage());
         }
     }
     

     public function getTestDetails($testId){
         try{
          $criteria = new EMongoCriteria;
          
        $criteria->addCond('_id', '==', new MongoId($testId));
        return TestPreparationCollection::model()->find($criteria);
         
     }catch (Exception $ex) {
             Yii::log("TestPreparationCollection:getTestDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             error_log("Exception Occurred in TestPreparationCollection->getTestDetails==".$ex->getMessage());
         }
     }   

     //SaveInviteUserDetails
     
       public function updatedSaveInviteUserDetails($TestId,$total) {
      try{
           
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('TestInviteUsers', 'push',(int)$total);
             $mongoModifier->addModifier('InviteUsers', 'inc',(int)1);
            $mongoCriteria->addCond('_id', '==',  new MongoID($TestId));
            TestPreparationCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            

      } catch (Exception $ex) {
          Yii::log("TestPreparationCollection:updatedSaveInviteUserDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
  }
  
  public function getTestScheduleIdByCategory($catname,$testId){
      try{
         $criteria = new EMongoCriteria;         
         $criteria->addCond('Category.CategoryName', '==', (string)$catname);
        $object = TestPreparationCollection::model()->find($criteria);
        
        $c = TestPreparationCollection::model()->getCollection();
        $result = $c->aggregate(array('$match' => array('_id' => new MongoId($testId))), array('$unwind' => '$Category'), array('$match' => array('Category.CategoryName' => (string)$catname)), array('$skip' => 0), array('$limit' => 1), array('$group' => array("_id" => "_id", "CategoryObj" => array('$push' => '$Category'))));
//        error_log("===getTestScvhedul====".print_r($result,1));
        $scheduleId = 0;
        foreach($result as $rr){
            if(isset($rr[0]['CategoryObj'][0]['ScheduleId']))
                $scheduleId = $rr[0]['CategoryObj'][0]['ScheduleId'];
            //error_log("==rr====".print_r($rr[0]['CategoryObj'][0]['ScheduleId'],1));
        }
        return $scheduleId;
      } catch (Exception $ex) {

      }
  }

}