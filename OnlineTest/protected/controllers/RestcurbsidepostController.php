<?php

/*
 * Developer Sagar
 * on 20th AUG 2014
 * all curbside related actions need to add here
 */

class RestcurbsidepostController extends Controller {

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
            Yii::log("RestWeblinkController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar Pathapelli
     */
    public function actionGetcurbsideposts() {
        try{
        if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
            $_GET['StreamPostDisplayBean_page'] = $_POST['Page'];
        }
        if (isset($_GET['StreamPostDisplayBean_page'])) {
            $streamIdArray = array();
            $previousStreamIdArray = array();
            $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
            if(!empty($previousStreamIdString)){
                $previousStreamIdArray = explode(",", $previousStreamIdString);
            }
             $pageSize = Yii::app()->params['MobilePageLength'];
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
                $streamRes = (object) (CommonUtility::prepareStreamDataForMobile($UserId, $provider->getData(), "", 0, '', $timezone, $previousStreamIdArray));
                $streamIdArray=$streamRes->streamIdArray;
                $totalStreamIdArray=$streamRes->totalStreamIdArray;
                $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                $streamIdArray = array_values(array_unique($streamIdArray));
                $stream=(object)($streamRes->streamPostData);
//                $streamIdArray=$streamRes->streamIdArray;
//                $totalStreamIdArray=$streamRes->totalStreamIdArray;
//                $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
//                $streamIdArray = array_values(array_unique($streamIdArray));
//                $stream=(object)($streamRes->streamPostData);
            } else {
                $stream = -1; //No more posts
            }
            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                $streamIdString = implode(',', $streamIdArray);
                if ($stream == -1 || $stream == 0) {
                    $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));
                   // $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));
                } else {
                    $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
                   // $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
                }
                echo $x;
            } else {
                $this->renderPartial('curbside_view', array('stream' => $stream));
            }
        }
        } catch (Exception $ex) {
            Yii::log("RestWeblinkController:actionGetcurbsideposts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
       public function actionGetcurbsideposts_V3() {
           try{
        if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
            $_GET['StreamPostDisplayBean_page'] = $_POST['Page'];
        }

        if (isset($_GET['StreamPostDisplayBean_page'])) {
            $streamIdArray = array();
            $previousStreamIdArray = array();
            $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
            if(!empty($previousStreamIdString)){
                $previousStreamIdArray = explode(",", $previousStreamIdString);
            }
            $pageSize = Yii::app()->params['MobilePageLength'];
            $UserId= (int)$_POST['loggedUserId'];
            $conditionalArray = array(
                'UserId' => array('in' => array($UserId, 0)),
                'CategoryType'=>array('in' => array(2,13)),
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
                $streamRes = (object) (CommonUtility::prepareStreamDataForMobile_V3($UserId, $provider->getData(), "", 3, '', $timezone, $previousStreamIdArray));
                $streamIdArray=$streamRes->streamIdArray;
                $totalStreamIdArray=$streamRes->totalStreamIdArray;
                $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
                $streamIdArray = array_values(array_unique($streamIdArray));
                $stream=(object)($streamRes->streamPostData);
//                $streamIdArray=$streamRes->streamIdArray;
//                $totalStreamIdArray=$streamRes->totalStreamIdArray;
//                $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
//                $streamIdArray = array_values(array_unique($streamIdArray));
//                $stream=(object)($streamRes->streamPostData);
            } else {
                $stream = -1; //No more posts
            }
            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
                $streamIdString = implode(',', $streamIdArray);
                if ($stream == -1 || $stream == 0) {
                    $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));
                   // $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));
                } else {
                    $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
                   // $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
                }
                echo $x;
            } else {
                $this->renderPartial('curbside_view', array('stream' => $stream));
            }
        }
        } catch (Exception $ex) {
            Yii::log("RestWeblinkController:actionGetcurbsideposts_V3::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
//       public function actionGetcurbsideposts_V3() {
//        if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
//            $_GET['StreamPostDisplayBean_page'] = $_POST['Page'];
//        }
//        if (isset($_GET['StreamPostDisplayBean_page'])) {
//            $streamIdArray = array();
//            $previousStreamIdArray = array();
//            $previousStreamIdString = isset($_POST['previousStreamIds'])?$_POST['previousStreamIds']:"";
//            if(!empty($previousStreamIdString)){
//                $previousStreamIdArray = explode(",", $previousStreamIdString);
//            }
//            $pageSize = 10;
//            $UserId= (int)$_POST['loggedUserId'];
//            $conditionalArray = array(
//                'UserId' => array('in' => array($UserId, 0)),
//                'CategoryType' => array('==' => 2),
//                'IsDeleted' => array('!=' => 1),
//                'IsAbused' => array('notIn' => array(1, 2)),
//                'IsBlockedWordExist' => array('notIn' => array(1, 2)),
//            );
//            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
//                'pagination' => array('pageSize' => $pageSize),
//                'criteria' => array(
//                    'conditions' => $conditionalArray,
//                    'sort' => array('CreatedOn' => EMongoCriteria::SORT_DESC)
//                )
//            ));
//            if ($provider->getTotalItemCount() == 0) {
//                $stream = 0; //No posts
//            } else if ($_GET['StreamPostDisplayBean_page'] <= ceil($provider->getTotalItemCount() / $pageSize)) {
//                $streamRes = (object) (CommonUtility::prepareStreamDataForMobile_V3($UserId, $provider->getData(), "", 0, '', $timezone, $previousStreamIdArray));
//                $streamIdArray=$streamRes->streamIdArray;
//                $totalStreamIdArray=$streamRes->totalStreamIdArray;
//                $totalStreamIdArray = array_values(array_unique($totalStreamIdArray));
//                $streamIdArray = array_values(array_unique($streamIdArray));
//                $stream=(object)($streamRes->streamPostData);
//            } else {
//                $stream = -1; //No more posts
//            }
//            if (isset($_POST["mobile"]) && $_POST["mobile"] == 1) {
//                $streamIdString = implode(',', $streamIdArray);
//                if ($stream == -1 || $stream == 0) {
//                    $x = json_encode(array('stream'=>$stream,'streamIdList'=>$streamIdString));
//                } else {
//                    $x = json_encode(array('stream'=>array_values((array) $stream),'streamIdList'=>$streamIdString));
//                }
//                echo $x;
//            } else {
//                $this->renderPartial('curbside_view', array('stream' => $stream));
//            }
//        }
//    }

}

?>
