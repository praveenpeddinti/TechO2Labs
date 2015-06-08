<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author Vamsi Krishna
 * This class is used write all the methods for Career Service 
 * 
 */
 class SkiptaCareerService {
     
   public function getAllJobs($page,$pageLength,$radius='',$userId=''){
         try
        {   $totalJobs=array();
             $userDetails=ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userId);
          //   $userCustomField=ServiceFactory::getSkiptaUserServiceInstance()->getUserProfileByUserId($userId);
             $latitude=0;
             $longitude=0;
             $subspeciality='';
             $jobs=array();
             $jobsWithRadius=array();
            $customMappingField=Yii::app()->params['GroupMappingField'];            
//            if(isset($customMappingField)){
//            $subspecialityArray= ServiceFactory::getSkiptaUserServiceInstance()->getUserSubspecialityByCustomField($userDetails['CfId'],$customMappingField);
//            }
            if(isset($userDetails['Value'])){                  
                $subspeciality=$userDetails['Value'];
            }
            if(!is_string($userDetails)){
                if(isset($userDetails['Latitude']) && isset($userDetails['Longitude'])){
                 $latitude=$userDetails['Latitude'];
                   $longitude=$userDetails['Longitude'];
                   
                    $jobsWithRadius= Careers::model()->getJobsByUserLatAndLongLesserThanRadius($latitude,$longitude,$radius,$page,$pageLength,$subspeciality);
          
                  if(sizeof($jobsWithRadius)<10){
                $pageLength=10-sizeof($jobsWithRadius);
                $jobs= Careers::model()->getJobsByUserLatAndLongGreaterThanRadius($latitude,$longitude,$radius,$page,$pageLength);
            }
                }else{
                    $jobs=Careers::model()->getJobsbyPagination($page,$pageLength);
                }
                
                
            }            
            //$jobs= Careers::model()->getJobsbyPagination($page,$pageLength);
           
          
            return array_merge($jobsWithRadius,$jobs);
        
       
      } catch (Exception $ex) {
          Yii::log("SkiptaCareerService:getAllJobs::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in SkiptaCareerService->getAllJobs### ".$ex->getMessage());
      }
   }
   
   public function getJobdetails($jobId){
       try {
           $jobDetails=Careers::model()->getJobDetails($jobId);
           return $jobDetails;
       } catch (Exception $ex) {
           Yii::log("SkiptaCareerService:getJobdetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in SkiptaCareerService->getJobdetails### ".$ex->getMessage());
       }
      }
  /**
 * @author Haribabu
 * This mehtod is used ot update the normal jobs status 
 * 
 */    
    public function UpdateJobsStatus(){
        try{
            
             $jobs=Careers::model()->updateJobsStatus();
             return $jobs;
        } catch (Exception $ex) {
              Yii::log("SkiptaCareerService:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function updateCareerGeoCoordinates($latitude,$longitude,$id){
         try{
         Careers::model()->updateCareerGeoCoordinates($latitude,$longitude,$id);
         } catch (Exception $ex) {
              Yii::log("SkiptaCareerService:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   public function getAllCareerJobs(){
       try {
           $jobDetails=Careers::model()->getAllCareerJobs();
           return $jobDetails;
       } catch (Exception $ex) {
          Yii::log("SkiptaCareerService:UpdateJobsStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
          error_log("Exception Occurred in SkiptaCareerService->UpdateJobsStatus### ".$ex->getMessage());
       }
      }
 
    public function updateCareerJobsLatLongById($lat, $long,$id){
        try{
            
             $jobs=Careers::model()->updateCareerJobsLatLongById($lat, $long,$id);
             return $jobs;
        } catch (Exception $ex) {
              Yii::log("SkiptaCareerService:updateCareerJobsLatLongById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }    
 }