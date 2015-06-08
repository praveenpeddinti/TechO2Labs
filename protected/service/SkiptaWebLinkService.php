<?php

class SkiptaWebLinkService{
    public function saveWebLink($webLinkForm,$userId,$type) {
        try {
             $Xcol = rand(1, 2);
            
            $webLinkObj=new WebLinks();
            $webLinkObj->WebUrl=$webLinkForm->WebLink;
            $webLinkObj->Description=$webLinkForm->Description;
            $webLinkObj->Title = $webLinkForm->Title;
            $webLinkObj->OtherValue = $webLinkForm->OtherValue;                
            $webLinkObj->LinkGroup = $webLinkForm->LinkGroup;
            $snippetdata = WebSnippetCollection::model()->CheckWebUrlExist($webLinkForm->WebLink);
            if(is_object($snippetdata)){
                $webLinkObj->WebDescription=$snippetdata->Webdescription;
                $webLinkObj->WebImage=$snippetdata->WebImage;
                $webLinkObj->WebSnippetUrl=$snippetdata->WebLink;
                $webLinkObj->WebTitle=$snippetdata->WebTitle;                
                $webLinkObj->Title = $webLinkForm->Title;
                $webLinkObj->OtherValue = $webLinkForm->OtherValue;                
                $webLinkObj->LinkGroup = $webLinkForm->LinkGroup;
            }
            $webLinkObj->CreatedUserId=$userId;
            $webLinkObj->Xcol=$Xcol;
            $webLinkObj->CreatedOn=date('Y-m-d H:i:s', time());
            if($type=='new'){
                $x = rand(1, 2);
            }
            if($type=='edit'){
                $webLinkObj->id=$webLinkForm->id;
                $webLinkObj->Status=$webLinkForm->Status;
            }else{
                $webLinkObj->Status=1;
            }
            $returnValue=WebLinks::model()->saveNewWebLink($webLinkObj,$type);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaWebLinkService:saveWebLink::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaWebLinkService->saveWebLink### ".$ex->getMessage());
            return 'failure';
        }
    }
    
    public function loadWebLinkWall($pageSize, $pageLength,$isAdmin) {
        try {
            $returnValue=WebLinks::model()->getWebLinks($pageSize, $pageLength,$isAdmin);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaWebLinkService:loadWebLinkWall::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
    }
   public function getWebLinkDetails($WebLinkId){
       try {
          $webLinkDetails= WebLinks::model()->getWebLinksById($WebLinkId);
          return $webLinkDetails;
       } catch (Exception $ex) {
            Yii::log("SkiptaWebLinkService:getWebLinkDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
       }
      }
      public function buildDragData($dragdataa) {
        try {
            
            WebLinks::model()->buildDragData($dragdataa);
        } catch (Exception $ex) {
            Yii::log("SkiptaWebLinkService:buildDragData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in SkiptaWebLinkService->buildDragData### ".$ex->getMessage());
            return 'failure';
        }
    }

}
