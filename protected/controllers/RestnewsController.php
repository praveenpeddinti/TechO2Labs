<?php

/*
 * Developer Sagar
 * on 20th AUG 2014
 * all news related actions need to add here
 */

class RestnewsController extends Controller {

    /**
     * @author Sagar
     * This method is to get the stream details
     */
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
            Yii::log("RestnewsController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar Pathapelli
     */
    public function actionIndex() {
        try {
            
            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                $_GET['StreamPostDisplayBean_page'] = $_POST['Page'];
            }
            if (isset($_GET['StreamPostDisplayBean_page'])) {
                $UserId= (int)$_POST['loggedUserId'];
                $streamIdArray = array();
                $previousStreamIdArray = array();
                $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
                if(!empty($previousStreamIdString)){
                    $previousStreamIdArray = explode(",", $previousStreamIdString);
                }
                if (isset($_GET['filterString'])) {
                    
                } else {
                    $condition = array(
                       'NetworkId' => array('==' => (Int) Yii::app()->params['NetWorkId']),
                       'UserId'=>array('in' => array(0,$UserId)),
                       'Released' => array('==' => (Int) 1),
                       'IsDeleted' => array('==' => (Int) 0),
                       'IsAbused' => array('==' => (Int) 0),
                       'CategoryType' => array('==' => (Int) 8),
                    );
                }
                  $pageSize = Yii::app()->params['MobilePageLength'];
                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => $condition,
                        //'sort' => array('PublicationTime' => EMongoCriteria::SORT_DESC,'UserId'=>EMongoCriteria::SORT_DESC),
                         'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC,'UserId'=>EMongoCriteria::SORT_DESC),
                    )
                ));
                if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $streamRes = (object) (CommonUtility::prepareStreamDataForMobile($UserId, $provider->getData(), "", 0, 0, $timezone, $previousStreamIdArray));
                    $streamIdArray=$streamRes->streamIdArray;
                    $totalStreamIdArray=$streamRes->totalStreamIdArray;
                    $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                    $streamIdArray = array_values(array_unique($streamIdArray));
                    $stream=(object)($streamRes->streamPostData);
//                    $streamIdArray=$streamRes->streamIdArray;
//                    $totalStreamIdArray=$streamRes->totalStreamIdArray;
//                    $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
//                    $streamIdArray = array_values(array_unique($streamIdArray));
//                    $stream=(object)($streamRes->streamPostData);
                } else {
                    $stream = -1; //No more posts
                }
                if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                    $streamIdString = implode(',', $streamIdArray);
                    if ($stream == -1 || $stream == 0) {

                           $x = json_encode($stream);
                       // $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));

                        $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));
                    } else {

                         $x = json_encode(array_values((array) $stream));
                       // $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));

                        $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
                    }
                    echo $x;
                } else {
                    $this->renderPartial('stream_view', array('stream' => $stream));
                }
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestnewsController->actionIndex==".$ex->getMessage());
            Yii::log("RestnewsController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
   
    
       public function actionIndex_V3() {
        try {
            
            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                $_GET['StreamPostDisplayBean_page'] = $_POST['Page'];
            }
            if (isset($_GET['StreamPostDisplayBean_page'])) {
                $UserId= (int)$_POST['loggedUserId'];
                $streamIdArray = array();
                $previousStreamIdArray = array();
                $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
                if(!empty($previousStreamIdString)){
                    $previousStreamIdArray = explode(",", $previousStreamIdString);
                }
                if (isset($_GET['filterString'])) {
                    
                } else {
                    $condition = array(
                       'NetworkId' => array('==' => (Int) Yii::app()->params['NetWorkId']),
                       'UserId'=>array('in' => array(0,$UserId)),
                       'Released' => array('==' => (Int) 1),
                       'IsDeleted' => array('==' => (Int) 0),
                       'IsAbused' => array('==' => (Int) 0),
                       'CategoryType' => array('==' => (Int) 8),
                    );
                }
                $pageSize = 10;
                $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                    'pagination' => array('pageSize' => $pageSize),
                    'criteria' => array(
                        'conditions' => $condition,
                        //'sort' => array('PublicationTime' => EMongoCriteria::SORT_DESC,'UserId'=>EMongoCriteria::SORT_DESC),
                         'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC,'UserId'=>EMongoCriteria::SORT_DESC),
                    )
                ));
                if ($provider->getTotalItemCount() == 0) {
                    $stream = 0; //No posts
                } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                    $streamRes = (object) (CommonUtility::prepareStreamDataForMobile_V3($UserId, $provider->getData(), "", 0, 0, $timezone, $previousStreamIdArray));
                    $streamIdArray=$streamRes->streamIdArray;
                    $totalStreamIdArray=$streamRes->totalStreamIdArray;
                    $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                    $streamIdArray = array_values(array_unique($streamIdArray));
                    $stream=(object)($streamRes->streamPostData);
                } else {
                    $stream = -1; //No more posts
                }
                if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                    $streamIdString = implode(',', $streamIdArray);
                    if ($stream == -1 || $stream == 0) {
                        $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));
                    } else {
                        $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
                    }
                    echo $x;
                } else {
                    $this->renderPartial('stream_view', array('stream' => $stream));
                }
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in RestnewsController->actionIndex_V3==".$ex->getMessage());
            Yii::log("RestnewsController:actionIndex_V3::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionGetcurbsideposts() {
        try{
        if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
            $_GET['StreamPostDisplayBean_page'] = $_POST['Page'];
        }
        if (isset($_GET['StreamPostDisplayBean_page'])) {
            $pageSize = 10;
            $UserId= (int)$_POST['loggedUserId'];
            $conditionalArray = array(
                'UserId' => array('in' => array($UserId, 0)),
                'CategoryType' => array('==' => 2),
                'IsDeleted' => array('!=' => 1),
                'IsAbused' => array('notIn' => array(1, 2)),
                'IsBlockedWordExist' => array('notIn' => array(1, 2)),
            );
            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                'pagination' => array('pageSize' => $pageSize),
                'criteria' => array(
                    'conditions' => $conditionalArray,
                    'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
                )
            ));
            if ($provider->getTotalItemCount() == 0) {
                $stream = 0; //No posts
            } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
                $streamRes = (object) (CommonUtility::prepareStreamDataForMobile_V3($UserId, $provider->getData(), "", 0, 0, $timezone));
                $stream=(object)($streamRes->streamPostData);
            } else {
                $stream = -1; //No more posts
            }
            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                if ($stream == -1 || $stream == 0) {
                    $x = json_encode($stream);
                } else {
                    $x = json_encode(array_values((array) $stream));
                }
                echo $x;
            } else {
                $this->renderPartial('curbside_view', array('stream' => $stream));
            }
        }
        } catch (Exception $ex) {
            Yii::log("RestnewsController:actionGetcurbsideposts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


}

?>