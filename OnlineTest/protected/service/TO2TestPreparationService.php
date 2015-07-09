
<?php 
class TO2TestPreparationService {
    
    public function saveTestPrepair($FormModel,$UserId){
        try{            
            $return = TestPreparationCollection::model()->saveTestPrepair($FormModel,$UserId);
        } catch (Exception $ex) {
            Yii::log("TO2TestPreparationService:saveTestPrepair::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TO2TestPreparationService->saveTestPrepair### ".$ex->getMessage());
        }
    }
    
    public function saveQuestionsToCollection($userQuestionsObj){
        try{
            return UserQuestionsCollection::model()->saveQuestionsToCollection($userQuestionsObj);
        } catch (Exception $ex) {
            Yii::log("TO2TestPreparationService:saveQuestionsToCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in TO2TestPreparationService->saveQuestionsToCollection### ".$ex->getMessage());
        }
    }
    
    public function getQuestionFromCollection($questionsObj,$pageno){
        try {
            $result = array();
            $categoryname = $categoryid = $questionid = "";
            if(sizeof($questionsObj)>0){
                    $categoryid = $questionsObj[0]['CategoryId'];
                    $categoryname = $questionsObj[0]['CategoryName'];
                    $questionid = $questionsObj[0]['CategoryQuestions'][$pageno];
                    $scheduleId = $questionsObj[0]['ScheduleId'];
                    error_log("@@@@@@@@@@@@@@@@@".$categoryid);
                $result = ExtendedSurveyCollection::model()->getQuestionById($categoryid,$questionid);
            }
            $resultArray = array("data"=>$result,"categoryId"=>$categoryid,"scheduleId"=>$scheduleId);
            return $resultArray;
        } catch (Exception $ex) {
            
        }
    }
    

    public function updateTestPrepair($FormModel,$TestId){
        try{
            $return = "failed";
            $return = TestPreparationCollection::model()->updateTestPrepair($FormModel,$TestId);
            
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:saveSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->saveSurvey### ".$ex->getMessage());
        }
    }

 
    
    
    public function getScheduleIdByCatName($catname,$testId){
        try{
            return TestPreparationCollection::model()->getTestScheduleIdByCategory($catname,$testId);
        } catch (Exception $ex) {

        }
    }

    
    public function getTestIdByUserId($userId){
        try{
            return TestRegister::model()->getTestIdByUserId($userId);
        } catch (Exception $ex) {

        }
    }
    public function getUserTestObjectByUserIdTestId($userId,$testId){
        try{
            return TestRegister::model()->getUserTestObjectByUserIdTestId($userId,$testId);
        } catch (Exception $ex) {

        }
    }
    

}