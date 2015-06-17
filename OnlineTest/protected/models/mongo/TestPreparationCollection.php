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
    public $InviteUsers;
    

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
     
     
     
}
