<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class RestCareersController extends Controller {
    
      public function init() {
        try{
        if (isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])) {
            $this->tinyObject = Yii::app()->session['TinyUserCollectionObj'];
            CommonUtility::reloadUserPrivilegeAndData($this->tinyObject->UserId);
            $this->userPrivileges = Yii::app()->session['UserPrivileges'];
            $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
        } else {
            
        }
        } catch (Exception $ex) {
            Yii::log("RestCareersController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionloadJobs() {
        try {
          
            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                $_GET['StreamPostDisplayBean_page'] = $_POST['Page'];
            }
            if (isset($_GET['StreamPostDisplayBean_page'])) {

                $page = $_GET['StreamPostDisplayBean_page'];
                $pageLength = Yii::app()->params['MobilePageLength'];
                if ($page == 1) {
                    $offset = $page - 1;
                    $limit = $pageLength;
                } else {

                    $offset = ($page - 1) * $pageLength;
                    $limit = $page * $pageLength;
                }

   $recomdedJobsRadius=Yii::app()->params['RecomendedJobsRadius'];
   $UserId = (int)$_REQUEST['userId'];
                $jobs = ServiceFactory::getSkiptaCareerServiceInstance()->getAllJobs($offset, $limit,$recomdedJobsRadius,$UserId);
               
                if (!is_string($jobs)) {
                        $jobsArray = array();
                   foreach ($jobs as $job) {
                       $job["JobDescription"] = strip_tags($job["JobDescription"]);
                         $job["SnippetDescription"] = $job["SnippetDescription"];
                         $job["PoweredbyHec"] = Yii::app()->params['ServerURL']."/images/system/poweredbyhec.png";
                         
                 $descriptionLength = strlen($job["SnippetDescription"]);
               
                 if ($descriptionLength > 240) {
                    $description = CommonUtility::truncateHtml($job["SnippetDescription"], 240, 'Read more', true, true, '<span> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>');
                    $job["SnippetDescription"] = $description;
                 
                }
                       
                      $job['CreatedDate'] =  CommonUtility::styleDateTime(strtotime($job['PostedDate']), "mobile");
                   $location = "";
                  if(!empty($job['City'])){
                      $location = $job['City'];
                  }
                  if(!empty($job['State'])){
                      if(!empty($location))
                          $location = "$location, ".$job['State'];
                      else
                          $location = $job['State'];
                  }
                  if(!empty($job['Zip'])){
                      if(!empty($location))
                          $location = "$location, ".$job['Zip'];
                      else
                          $location = $job['Zip'];
                  } 
                  $job['location'] = $location;
                                     
                    $appendData = ' <span class="careerpostdetail tooltiplink" data-id=' .  $job['id']. '  data-postid="' . $job['JobId'] . '" data-categoryType="12" data-postType="12"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';



                if (strlen($job['JobDescription']) > 330) {
                    $description = CommonUtility::truncateHtml(htmlspecialchars_decode($job['JobDescription']), 330, 'Read more', true, true, $appendData);

                     $job['JobDescription'] = $description;
                   
                  
                }else{
                   $job['JobDescription'] =  htmlspecialchars_decode($job['JobDescription']); 
                }
                  
                      array_push($jobsArray, $job);
                   }
                 
                   

                   
                   
                       $jobsData = $jobsArray;
                } else {
                    if($_GET['StreamPostDisplayBean_page'] == 1){
                        $jobsData = 0;
                    }else{
                        $jobsData = -1;
                    }
                    
                }
                $obj = array("stream"=>$jobsData);
               echo $this->rendering($obj);
               // $this->renderPartial('loadJobs', array('jobs' => $jobsData));
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestCareersController->actionloadJobs==".$ex->getMessage());
            Yii::log("RestCareersController:actionloadJobs::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
        public function actionRenderPostDetailForCareer() {
        try {
            $jobId = $_REQUEST['id']; 
                $jobDetails = ServiceFactory::getSkiptaCareerServiceInstance()->getJobdetails($jobId);
                  $jobsArray = array();
                foreach ($jobDetails as $job) {
                      $job['CreatedDate'] = CommonUtility::styleDateTime(strtotime($job['CreatedDate']), "mobile"); 
                    $job["PoweredbyHec"] = Yii::app()->params['ServerURL']."/images/system/poweredbyhec.png";
                    
                    
                       $location = "";
                  if(!empty($job['City'])){
                      $location = $job['City'];
                  }
                  if(!empty($job['State'])){
                      if(!empty($location))
                          $location = "$location, ".$job['State'];
                      else
                          $location = $job['State'];
                  }
                  if(!empty($job['Zip'])){
                      if(!empty($location))
                          $location = "$location, ".$job['Zip'];
                      else
                          $location = $job['Zip'];
                  } 
                      $job['location'] = $location;
                    array_push($jobsArray, $job);
                      
                }
             
            if (!is_string($jobDetails)) {
                $obj = array("status"=>"success",'data' => $jobsArray,'error'=>"");
                echo $this->rendering($obj);
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestCareersController->actionloadJobs==".$ex->getMessage());
            Yii::log("RestCareersController:actionloadJobs::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}

