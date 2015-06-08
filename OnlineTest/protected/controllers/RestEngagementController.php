<?php

class RestEngagementController extends Controller {
    
    public function init() {
         
    }
    public function actionTrackEngagementAction(){
      try{
      $page = $_REQUEST['page'];
      $action = $_REQUEST['action'];
      $userId =  $_REQUEST['userId'];
      $dataId = "";
      $id = "";
      if(isset($_REQUEST['dataId'])){
         $dataId= $_REQUEST['dataId'];
      }
      if(isset($_REQUEST['id'])){
         $id= $_REQUEST['id'];
      }
    
      $networkId = Yii::app()->params['NetWorkId'];
      $categoryType = $_REQUEST['categoryType'];
      $postType = $_REQUEST['postType'];
      ServiceFactory::getSkiptaPostServiceInstance()->trackEngagementAction($userId,$page,$action,$dataId,$categoryType,$postType,$networkId, $id);
      $result = array("code"=>200,"status"=>"");
      echo $this->rendering($result);
      } catch (Exception $ex) {
          Yii::log("RestEngagementController:actionTrackEngagementAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
 }
  public function actionTrackSearchEngagementAction(){
      try{
      $page = $_REQUEST['page'];
      $action = $_REQUEST['action'];
      $searchType = $_REQUEST['searchType'];
      $searchText = $_REQUEST['searchText'];
      $userId =  $_REQUEST['userId'];
      $dataId = "";
      if(isset($_REQUEST['dataId'])){
          $dataId= $_REQUEST['dataId'];
      }
      $networkId = Yii::app()->params['NetWorkId'];
      ServiceFactory::getSkiptaPostServiceInstance()->trackSearchEngagementAction($userId,$page,$action,$dataId,$searchText,$searchType,$networkId);
      $result = array("code"=>200,"status"=>"");
      echo $this->rendering($result);
      } catch (Exception $ex) {
          Yii::log("RestEngagementController:actionTrackSearchEngagementAction::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
 } 
}
