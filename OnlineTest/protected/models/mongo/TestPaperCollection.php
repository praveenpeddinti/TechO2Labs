<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TestPaperCollection extends EMongoDocument {
    public $_id;
    public $TestPreparationId;
//    public $NoofQuestions;
//    public $CategoryTime;
//    public $CategoryScore; 
    public $CreatedOn;
    public $UserId;
//    public $Category;

    public function getCollectionName() {
        return 'TestPaperCollection';
    }
 public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_survey' => array(
                'key' => array(
                    'TestPreparationId' => EMongoCriteria::SORT_ASC,
                ),
                
            )
        );
    }
     public function attributeNames() {
     return array(
        '_id'=>'_id',
        'TestPreparationId'=>'TestPreparationId',       
         'UserId' => 'UserId',
        'CreatedOn'=>'CreatedOn',        
        );
     }

     public function saveTestPaper($preparationid,$UserId){
         try{             error_log($UserId."----@@@@@@@@@@@@@@@@@@@-saveTestPaper==--mongo save---");
             $returnValue = "failed";
             $TestPaper = new TestPaperCollection();
             $TestPaper->TestPreparationId = $preparationid;
             $TestPaper->UserId = $UserId;
             $TestPaper->CreatedOn = new MongoDate(strtotime(date('Y-m-d', time())));
             if($TestPaper->save()){
                 error_log("=#####################3=Test Paper saved success $$$$$$$$$$$$$###################=====");
                 $returnValue = "success";
             }
             return $returnValue;
         } catch (Exception $ex) {
             Yii::log("TestPaperCollection:saveTestPaper::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
             error_log("Exception Occurred in TestPaperCollection->saveTestPaper==".$ex->getMessage());
         }
     }
  
}
