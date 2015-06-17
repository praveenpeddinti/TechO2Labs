<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ServiceFactory 
{
 private static $inst_user_service=null;   
 private static $inst_datamigration_service=null;   
 private static $inst_post_service=null; 
 private static $inst_chat_service=null; 
 private static $inst_group_service=null; 
 private static $inst_game_service=null;
 private static $inst_career_service=null;
 private static $inst_ad_service=null;
 private static $inst_topic_service=null;
 private static $inst_weblink_service=null;
 private static $inst_exsurvey_service=null;
 private static $inst_testpaper_service=null;
 

private function __construct() {
}

public static function getSkiptaUserServiceInstance() {
    try{
    if(!self::$inst_user_service) {
        self::$inst_user_service = new SkiptaUserService();
    }
    return self::$inst_user_service;
    } catch (Exception $ex) {
        Yii::log("ServiceFactory:getSkiptaUserServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}
 

    
public static function getSkiptaDataMigrationServiceInstance() {
    try{
        if(!self::$inst_datamigration_service) {
	    self::$inst_datamigration_service = new SkiptaDataMigrationService();
	}
	return self::$inst_datamigration_service;
    } catch (Exception $ex) {
        Yii::log("ServiceFactory:getSkiptaDataMigrationServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    } 
}
public static function getSkiptaPostServiceInstance() {
    try{
        if(!self::$inst_post_service) {
	            self::$inst_post_service = new SkiptaPostService();
	        }
	        return self::$inst_post_service;
    } catch (Exception $ex) {
        Yii::log("ServiceFactory:getSkiptaPostServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }            
    }
    public static function getSkiptaChatServiceInstance() {
    try{
        if(!self::$inst_chat_service) {
	            self::$inst_chat_service = new SkiptaChatService();
	        }
	        return self::$inst_chat_service;
        } catch (Exception $ex) {
        Yii::log("ServiceFactory:getSkiptaChatServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
    public static function getSkiptaGroupServiceInstance() {
    try{
        if(!self::$inst_group_service) {
	            self::$inst_group_service = new SkiptaGroupService();
	        }
	        return self::$inst_group_service;
        } catch (Exception $ex) {
        Yii::log("ServiceFactory:getSkiptaGroupServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }        
    }
     public static function getSkiptaGameServiceInstance()  {
     try{
         if(!self::$inst_group_service) {
	            self::$inst_game_service = new SkiptaGameService();
	        }
	        return self::$inst_game_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getSkiptaGameServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public static function getSkiptaCareerServiceInstance() {
        try{
        if(!self::$inst_career_service) {
	            self::$inst_career_service = new SkiptaCareerService();
	        }
	        return self::$inst_career_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getSkiptaCareerServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public static function getSkiptaAdServiceInstance()  {
        try{
         if(!self::$inst_ad_service) {
	            self::$inst_ad_service = new SkiptaAdService();
	        }
	        return self::$inst_ad_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getSkiptaAdServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
      public static function getSkiptaWebLinkServiceInstance() {
        try{
          if(!self::$inst_ad_service) {
	            self::$inst_weblink_service = new SkiptaWebLinkService();
	        }
	        return self::$inst_weblink_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getSkiptaWebLinkServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public static function getSkiptaTopicServiceInstance() {
        try{
         if(!self::$inst_topic_service) {
	            self::$inst_topic_service = new SkiptaTopicService();
	        }
	        return self::$inst_topic_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getSkiptaTopicServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public static function getSkiptaExSurveyServiceInstance() {
        try{
        if(!self::$inst_exsurvey_service) {
	            self::$inst_exsurvey_service = new SkiptaExSurveyService();
	        }
	        return self::$inst_exsurvey_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getSkiptaExSurveyServiceInstance::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
       public static function getSkiptaSegmentChangeService() {
        try{
           if(!self::$inst_topic_service) {
	            self::$inst_topic_service = new SkiptaSegmentChangeService();
	        }
	        return self::$inst_topic_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getSkiptaSegmentChangeService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public static function getSkiptaTranslatedDataService()  {
        try{
        if(!self::$inst_topic_service) {
	            self::$inst_topic_service = new SkiptaTranslatedDataService();
	        }
	    return self::$inst_topic_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getSkiptaTranslatedDataService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /*
     * @Praveen Test Preparation 
     */
    public static function getTO2TestPreparaService() {
        try{
        if(!self::$inst_testpaper_service) {
	            self::$inst_testpaper_service = new TO2TestPreparationService();
	        }
	        return self::$inst_testpaper_service;
        } catch (Exception $ex) {
            Yii::log("ServiceFactory:getTO2TestPreparaService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
 }
