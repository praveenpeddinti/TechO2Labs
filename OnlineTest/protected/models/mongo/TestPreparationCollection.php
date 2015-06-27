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
    public $TestTakenUsers =0;
    

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
         'TestInviteUsers'=>'TestInviteUsers',
        'TestTakenUsers'=>'TestTakenUsers',
        'CreatedOn'=>'CreatedOn',
        );
     }

     public function saveTestPrepair($FormModel,$UserId){
         try{             error_log($UserId."------mongo save---");
             $returnValue = "failed";
             $survey = new TestPreparationCollection();
             $survey->Title = $FormModel->Title;
             $survey->Description = $FormModel->Description;
             $survey->Category = $FormModel->Questions;
             $survey->CreatedOn = new MongoDate(strtotime(date('Y-m-d', time())));
             if($survey->save()){
                 $returnValue = "success";
                 //$returnValue = $survey->_id;
                 //TestPaperCollection::model()->saveTestPaper($returnValue,$UserId);
             }
             return $returnValue;
         } catch (Exception $ex) {
             Yii::log("TestPreparationCollection:saveTestPrepair::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             error_log("Exception Occurred in TestPreparationCollection->saveTestPrepair==".$ex->getMessage());
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
     
     //SaveInviteUserDetails
     
       public function updatedSaveInviteUserDetails($TestId,$total) {
      try{error_log($TestId."-----enter update function------".$total);
           
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('TestInviteUsers', 'push',(int)$total);
             $mongoModifier->addModifier('InviteUsers', 'inc',(int)1);
            $mongoCriteria->addCond('_id', '==',  new MongoID($TestId));
            TestPreparationCollection::model()->updateAll($mongoModifier, $mongoCriteria);
           error_log("-----enter update function---2---");
           
           
           
           

      } catch (Exception $ex) {
          Yii::log("TestPreparationCollection:updatedSaveInviteUserDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
  }
     
     
}
