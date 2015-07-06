<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserQuestionsCollection extends EMongoDocument {

    public $_id;
    public $UserId;
    public $Testid;
    public $Questions = array();
    public $CategoryTime;
    public $CategoryScore;
    public $ReviewQuestion;
    public $CreatedOn;

    public function getCollectionName() {
        return 'UserQuestionsCollection';
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
            '_id' => '_id',
            'UserId' => 'UserId',
            'Testid' => 'Testid',
            'Questions' => 'Questions',
            'CategoryTime' => 'CategoryTime',
            'CategoryScore' => 'CategoryScore',
            'ReviewQuestion' => 'ReviewQuestion',
            'CreatedOn' => 'CreatedOn',
        );
    }

    public function getPreparedTest($testId) {
        try {
            $preparecriteria = new EMongoCriteria;
            $preparecriteria->addCond('_id', '==', new MongoId($testId));
            $testquestionObj = UserQuestionsCollection::model()->find($preparecriteria);
            return $testquestionObj;
        } catch (Exception $ex) {
            Yii::log("UserQuestionsCollection:getPreparedTest::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserQuestionsCollection->getPreparedTest==" . $ex->getMessage());
        }
    }
    
    public function getUserTest($testId) {
        try {
            $preparecriteria = new EMongoCriteria;
            $preparecriteria->addCond('Testid', '==', new MongoId($testId));
            $testquestionObj = UserQuestionsCollection::model()->findAll($preparecriteria);
            return $testquestionObj;
        } catch (Exception $ex) {
            Yii::log("UserQuestionsCollection:getPreparedTest::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserQuestionsCollection->getPreparedTest==" . $ex->getMessage());
        }
    }
    
    
    public function saveQuestionsToCollection($userQuestionsObj){
        try{
            $returnValue = "failure";
            if(isset($userQuestionsObj) && sizeof($userQuestionsObj) > 0){
                $userQuestionsObj->save($userQuestionsObj);
                $returnValue = "success";
            }
            return $userQuestionsObj;
        } catch (Exception $ex) {
            Yii::log("UserQuestionsCollection:saveQuestionsToCollection::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserQuestionsCollection->saveQuestionsToCollection==" . $ex->getMessage());
            return $returnValue;
        }
    }
       public function getQuestionFromCollectionForPagination($id,$categoryId,$page,$action){
        try {
            $nocategories = $nonextCategoryIdExist = "false";
            $catIndex = 0;
            error_log("getQuestionFromCollectionForPagination--".$id."---".$categoryId."--".$page);
           // $categoryQuestions = $this->getQuestionsByCategoryId($id,$categoryId);
             
        $catIdsArray = array();
       
          $categoryQuestions = $this->getQuestionsByCategoryId($id,$categoryId);
     
        $totalQuesitonArray = array();
        
       // error_log($page."--------------------".sizeof($categoryQuestions[0]));
        if($action != "current"){            
        if($page == -1){
            $catIdsArray = UserQuestionsCollection::model()->getNextCategoryId($id,$categoryId);
            $inc = 0;
            foreach($catIdsArray as $rw){               
                if((string)$rw == $categoryId){
                    $categoryId = isset($catIdsArray[($inc-1)])?(string)$catIdsArray[($inc-1)]:"";
                    break;
                }
                $inc++;
            }
          
            if(isset($categoryId) && !empty($categoryId)){                
                $page = 0;
            }
            error_log($page."-----preve dat----------------".$categoryId);
            $categoryQuestions = $this->getQuestionsByCategoryId($id,$categoryId);
             $page = sizeof($categoryQuestions[0])-1;
        }
        
        
          else if($page == sizeof($categoryQuestions[0]) || $page == sizeof($categoryQuestions[0])-1){            
          
            $catIdsArray = UserQuestionsCollection::model()->getNextCategoryId($id,$categoryId);
            $in = 0;
            foreach($catIdsArray as $rw){               
                if((string)$rw == $categoryId){                    
                    $newcategoryId = isset($catIdsArray[($in+1)])?(string)$catIdsArray[($in+1)]:"";                                        
                    break;
                }
                $in++;
            }
            //error_log($newcategoryId."====$newcategoryId   ===!!!!!!!!!@@@@@@@@@@@@@@@=======page===$page==categquesitons size===".sizeof($categoryQuestions[0]));
          if($page == sizeof($categoryQuestions[0])){
              $categoryId = $newcategoryId;
               if(isset($categoryId) && !empty($categoryId)){                
                    $page = 0;
                }
             $categoryQuestions = $this->getQuestionsByCategoryId($id,$categoryId);
          }else if($newcategoryId == ""){
              $nocategories = "true";
              error_log("===not--------------------".$nocategories);
          }
           
            error_log($page."-----next dat----------------".$categoryId);
             
        }
      }
      $sam = $categoryQuestions[0];
      
            error_log("categoryAQuestions=-===".print_r($categoryQuestions[0][$page],1));
        $totalQuesitonArray['questionId'] = isset($categoryQuestions[0][$page])?$categoryQuestions[0][$page]:"";
        $totalQuesitonArray['categoryId'] = $categoryId;
        error_log("=====befor 444444444 ===categoryId===$categoryId");
        $totalQuesitonArray['scheduleId'] = $this->getScheduleIdByUQuestionId($id,$totalQuesitonArray['categoryId']);
        error_log("no of cat--(((-".$nocategories);
        $totalQuesitonArray['nocategories'] = $nocategories;
        $totalQuesitonArray['page'] = $page;
        $totalQuesitonArray['catIdsArray'] = $catIdsArray;
        $totalQuesitonArray['totalpages'] = isset($categoryQuestions[0])?sizeof(array_filter($categoryQuestions[0])):0;
        error_log("====sizeoftotalpages==@@@@@@@@@@@@@@@@@@@@@@@=======".$totalQuesitonArray['totalpages']);
        return $totalQuesitonArray;
        } catch (Exception $ex) {
            error_log("exceoitn---".$ex->getMessage())     ;
        }
    }
    public function getAllCategoriesforTest($id){
        try{
            
             $c = UserQuestionsCollection::model()->getCollection();
        $result = $c->aggregate(array('$match' => array('_id' =>new MongoID($id))), array('$unwind' => '$Questions'), array('$group' => array("_id" => "_id", "CategoryIds" => array('$push' => '$Questions.CategoryId')))); 
        
        foreach($result as $rw){
//            error_log("======result=========".print_r($rw[0]['Questions'][0],1));
            if(sizeof($rw[0])>0)
               $categoryIds = $rw[0]['CategoryIds'];
        } 
         error_log("get categorir---".print_r($categoryIds,1));
        } catch (Exception $ex) {

        }
        return $categoryIds;
    }
        public function getNextCategoryId($id,$categoryId){
        try{
           return UserQuestionsCollection::model()->getAllCategoriesforTest($id);           
         
        } catch (Exception $ex) {

        }
    }
    public function getTestAvailable($UserId,$testId){
        try{
            error_log("getTestAvailable---------".$UserId."---".$testId);
            $returnValue = "failure";
             $preparecriteria = new EMongoCriteria;
             $preparecriteria->addCond('UserId', '==', (int)$UserId);
            $preparecriteria->addCond('Testid', '==', new MongoId($testId));
            $testquestionObj = UserQuestionsCollection::model()->find($preparecriteria);
            if(is_object($testquestionObj)){
               $returnValue = $testquestionObj; 
            }
            return $returnValue; 
        } catch (Exception $ex) {

        }
    }
    
    public function getQuestionsByCategoryId($id,$categoryId){
        try{
            $c = UserQuestionsCollection::model()->getCollection();
                $result = $c->aggregate(array('$match' => array('_id' =>new MongoID($id))), array('$unwind' => '$Questions'), array('$match' => array('Questions.CategoryId' => new MongoID($categoryId))),array('$group' => array("_id" => "_id", "CategoryQuestions" => array('$push' => '$Questions.CategoryQuestions')))); 

            foreach($result as $rw){
                if(sizeof($rw[0])>0)
                   $categoryQuestions = $rw[0]['CategoryQuestions'];
            } 
            return $categoryQuestions;
        } catch (Exception $ex) {

        }
    }
    
public function getScheduleIdByUQuestionId($id,$categoryId){
    try{
//        $preparecriteria = new EMongoCriteria;
//        $preparecriteria->addCond('Questions.CategoryId', '==', new MongoId($categoryId));
//        $preparecriteria->addCond('_id', '==', new MongoId($id));
//        $testquestionObj = UserQuestionsCollection::model()->find($preparecriteria);
        $c = UserQuestionsCollection::model()->getCollection();
        $result = $c->aggregate(array('$match' => array('_id' =>new MongoId($id))), array('$unwind' => '$Questions'), array('$match' => array('Questions.CategoryId' => new MongoID($categoryId))),array('$group' => array("_id" => "_id", "ScheduleId" => array('$push' => '$Questions.ScheduleId')))); 
        error_log("=======testQuestion===schedl===".print_r($result['result'][0]['ScheduleId'],1));
        $scheduleId = 0;
        if(isset($result['result'][0]['ScheduleId'])){
            $scheduleId = (string)$result['result'][0]['ScheduleId'][0];
        }
        return $scheduleId;
    } catch (Exception $ex) {

    }
}

}
