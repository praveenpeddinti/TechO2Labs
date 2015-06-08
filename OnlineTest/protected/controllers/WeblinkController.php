<?php

class WeblinkController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function init() {
        try{
        parent::init();
        if(isset(Yii::app()->session['TinyUserCollectionObj'])){
                 $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];
                  $this->userPrivileges=Yii::app()->session['UserPrivileges'];
                $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
                $this->whichmenuactive=9;
             }else{
                  $this->redirect('/');
        }
        } catch (Exception $ex) {
            Yii::log("WeblinkController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionIndex() {
        try {
            $webLinkForm = new WebLinkForm();
            $linkgroupnames = LinkGroup::model()->getLinkGroups();
            $this->render('index', array('webLinkForm' => $webLinkForm,"linkGroups"=>$linkgroupnames));
        } catch (Exception $ex) {
            Yii::log("WeblinkController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actioncreateWebLink() {
        try {
            $webLinkForm = new WebLinkForm();
            if (isset($_POST['WebLinkForm'])) {
                $webLinkForm->attributes = $_POST['WebLinkForm'];
                $userId = $this->tinyObject['UserId'];                
                if($webLinkForm->LinkGroup == "other" && $webLinkForm->OtherValue == ""){
                    $common['WebLinkForm_OtherValue'] = "Link Group Name cannot be blank";
                        
                }else if($webLinkForm->LinkGroup ==""){
                    //$common['WebLinkForm_LinkGroup'] = "Please Choose Link Group";
                    
                }else{
                    $common['WebLinkForm_LinkGroup'] = "";
                    $common['WebLinkForm_OtherValue'] = "";
                }
                $errors = CActiveForm::validate($webLinkForm);                
                if ($errors != '[]' || !empty($common['WebLinkForm_OtherValue'])) {
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors,'oerror'=>$common);
                } else { 
                    
                    if(isset($webLinkForm->id)){
                     $returnValue = ServiceFactory::getSkiptaWebLinkServiceInstance()->saveWebLink($webLinkForm,$userId,'edit');    
                      if ($returnValue == 'success') {
                        $obj = array('status' => 'success', 'data' => 'WebLink is updated successfully', 'error' => '', 'page' => 'edit');
                    } else {
                        $obj = array('status' => 'failure', 'data' => 'Some thing went wrong please try again later', 'error' => '');
                    }
                    }else{
                     $returnValue = ServiceFactory::getSkiptaWebLinkServiceInstance()->saveWebLink($webLinkForm,$userId,'new');    
                      if ($returnValue == 'success') {
                        $obj = array('status' => 'success', 'data' => 'WebLink is created successfully', 'error' => '', 'page' => 'new');
                    } else {
                        $obj = array('status' => 'failure', 'data' => 'Some thing went wrong please try again later', 'error' => '');
                    }
                     
                    }
                    
                    
                }
            } else {
                $obj = array('status' => 'failure', 'data' => 'Some thing went wrong please try again later', 'error' => '');
            }
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            error_log("Exception Occurred in WeblinkController->actioncreateWebLink==".$ex->getMessage());
            Yii::log("WeblinkController:actioncreateWebLink::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionloadWebLinks() {
        try {
            if (isset($_GET['WebLinks_page'])) {
                $page=$_GET['WebLinks_page'];
                $WLPage=$_REQUEST['WLPage'];                 
                $page=$page-1;
                $limit=5;
                $offset = ($limit * $page);     
                $isAdmin=Yii::app()->session['IsAdmin'];                
                $webLinks=ServiceFactory::getSkiptaWebLinkServiceInstance()->loadWebLinkWall($limit,$offset,$isAdmin);
                if(is_array($webLinks)){
                    
                       
                }else{
                    if($page==0){
                      $webLinks=0;
                    }else{
                     $webLinks=-1;    
                    }
                    
                }
                if($WLPage=='DND'){
                    $streamData = $this->renderPartial('DNDwebLinkWall', array('webLinks' => $webLinks));
                }else{
                  $streamData = $this->renderPartial('webLinkWall', array('webLinks' => $webLinks));   
                }
                 
            } 
        } catch (Exception $ex) {
            Yii::log("WeblinkController:actionloadWebLinks::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
  public function actioneditWebLink(){
      try {
          $WebLink=$_REQUEST['WLID'];
          if(isset($WebLink)){
              $webLinkDetails=ServiceFactory::getSkiptaWebLinkServiceInstance()->getWebLinkDetails($WebLink);              
              if(is_array($webLinkDetails)){                  
                  $webLinkForm=new WebLinkForm();
                  $webLinkForm->id=$webLinkDetails['id'];
                  $webLinkForm->Description=$webLinkDetails['Description'];
                  $webLinkForm->WebDescription=$webLinkDetails['WebDescription'];
                  $webLinkForm->WebImage=$webLinkDetails['WebImage'];
                  $webLinkForm->WebLink=$webLinkDetails['WebUrl'];
                  $webLinkForm->WebSnippetUrl=$webLinkDetails['WebSnippetUrl'];
                  $webLinkForm->WebTitle=$webLinkDetails['WebTitle'];
                  $webLinkForm->Status=$webLinkDetails['Status'];
                  $webLinkForm->Title=$webLinkDetails['Title'];
                  $webLinkForm->LinkGroup=$webLinkDetails['LinkGroupId'];
                  $data = LinkGroup::model()->getLinkGroups();   
                  $htmlData = $this->renderPartial('editWebLink', array("webLink" => $webLinkDetails,'webLinkForm'=>$webLinkForm,"linkGroups"=>$data), "html");  
                  $obj = array("htmlData" => $htmlData);
                  $renderScript = $this->rendering($obj);
            echo $renderScript;
              }
          }
      } catch (Exception $ex) {          
         Yii::log("WeblinkController:actioneditWebLink::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
        
  }  
  public function actionupdateDrag(){
      try {         
          if(isset($_REQUEST['dragdata'])){
              $dragData=$_REQUEST['dragdata'];           
           ServiceFactory::getSkiptaWebLinkServiceInstance()->buildDragData($dragData);    
          }
          
      } catch (Exception $ex) {
            Yii::log("WeblinkController:actionupdateDrag::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
    }
    
    public function actionGetLinkGroups() {
        try{
            $data = LinkGroup::model()->getLinkGroups();        
        $result1 = array("data" => $data, "status" => 'success');
        echo $this->rendering($result1);
        } catch (Exception $ex) {
            Yii::log("WeblinkController:actionGetLinkGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}
