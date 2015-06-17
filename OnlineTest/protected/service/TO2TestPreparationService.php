
<?php 
class TO2TestPreparationService {
    
    public function saveTestPrepair($FormModel,$UserId){
        try{
            $return = "failed";
            /*$FormModel->SurveyLogo = $this->savePublicationArtifacts($FormModel->SurveyLogo,'/upload/ExSurvey/');
            if($FormModel->IsBranded == 1)
                $FormModel->BrandLogo = $this->savePublicationArtifacts($FormModel->BrandLogo,'/upload/ExSurvey/Branded/');
            if(!empty($FormModel->SurveyId)){
                $return = $this->updateSurveyObject($FormModel);
            }else{*/
                $return = TestPreparationCollection::model()->saveTestPrepair($FormModel,$UserId);
                
            //}
        } catch (Exception $ex) {
            Yii::log("SkiptaExSurveyService:saveSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaExSurveyService->saveSurvey### ".$ex->getMessage());
        }
    }
    
    

}