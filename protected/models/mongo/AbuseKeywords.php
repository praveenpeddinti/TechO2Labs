<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AbuseKeywords extends EMongoDocument {
    public $_id;
    public $AbuseWord;
    public $CreatedOn;
    public $Status=0;
    public $BlockedPosts=array();//{PostId, CategoryId, NetworkId}
    public $BlockedComments=array();//{PostId, CommentId, CategoryId, NetworkId}
    
    public function getCollectionName() {
        return 'AbuseKeywords';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    
    public function rules()
    {
        return array(
        );
    }
    public function indexes() {
        return array(
            'index_AbuseWord' => array(
                'key' => array(
                    'AbuseWord' => EMongoCriteria::SORT_ASC,
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            ),);
    }
     public function attributeNames() {
        return array(
            '_id'=>'_id',
            'AbuseWord' => 'AbuseWord',
            'CreatedOn' => 'CreatedOn',
            'Status' => 'Status',
            'BlockedPosts'=>'BlockedPosts',
            'BlockedComments'=>'BlockedComments'
        );
    }
    /**
     * @author Sagar Pathapelli
     * This method is used to create/update the abuse word
     * @param type $model (if $model['id'] is exist then update else create)
     * @return string
     * 
     * This is Old Method before implementing tag cloud, New method is saveBlockWords
     */
     public function saveAbuseWord($model)
    {
        try{
            $returnValue = 'failure';
            $AbuseWords = explode(",", $model['AbuseWord']);
            $savedWords = array();
            $existingWords = array();
            if(sizeof($AbuseWords)>0){
                foreach ($AbuseWords as $AbuseWord) {
                    $isexist = $this->checkBlockWordExist($AbuseWord);
                    if(isset($isexist) && !empty($isexist)){
                        $isexist = $isexist==$model['id']?false:true;
                    }
                    if(!$isexist){
                        $criteria = new EMongoCriteria;
                        $criteria->AbuseWord = strtolower($AbuseWord); 
                        if(isset($model['id']) && $model['id'] != 0 && !empty($model['id'])){
                            $criteria->addCond('_id', '!=', new MongoId($model['id']));
                            $obj = AbuseKeywords::model()->find($criteria);            
                        }
                        if(!isset($obj) && empty($obj)){
                            if(isset($model['id']) && !empty($model['id']) && $model['id'] != 0){ //If id is exist then update
                                $mongoCriteria = new EMongoCriteria;
                                $mongoModifier = new EMongoModifier;
                                $mongoModifier->addModifier('AbuseWord', 'set', strtolower($AbuseWord));
                                $mongoModifier->addModifier('CreatedOn', 'set', new MongoDate(strtotime(date('Y-m-d H:i:s', time()))));
                                $mongoCriteria->addCond('_id', '==', new MongoId($model['id']));
                                $res = AbuseKeywords::model()->updateAll($mongoModifier, $mongoCriteria);
                                $returnValue = "updated";
                            }else{//If id is not exist then save
                                $abuseKeywords = new AbuseKeywords();
                                $abuseKeywords->AbuseWord = strtolower($AbuseWord);
                                $abuseKeywords->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time()))); 
                                $abuseKeywords->Status = 0;
                                if ($abuseKeywords->save()) {
                                    $returnValue = "created";
                                }
                                array_push($savedWords, $AbuseWord);
                            }
                        }
                    }else{
                        array_push($existingWords, $AbuseWord);
                    }
                }
                if($returnValue!="updated"){
                    $returnValue=array("savedWords"=>$savedWords, "existingWords"=>$existingWords);
                }
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:saveAbuseWord::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
    * @Author Sagar Pathapelli
    * This method is used get getAllAbuseWords
    * @return type
    */
    public function getAllAbuseWords() {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('AbuseWord'=>true));
            $criteria->addCond('Status', '==', 0);
            $abuseWordsObj = AbuseKeywords::model()->findAll($criteria);
            $abuseWords = array();
            if (isset($abuseWordsObj)) {
                if(is_array($abuseWordsObj)){
                    foreach ($abuseWordsObj as $abuseword) {
                        array_push($abuseWords, $abuseword->AbuseWord);
                    }
                    $returnValue =$abuseWords;
                }
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:getAllAbuseWords::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function checkBlockWordExist($word){       
        try {
            $res = AbuseKeywords::model()->findByAttributes(array('AbuseWord' => strtolower($word)));
            if (isset($res)) {
                return $res->_id;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:checkBlockWordExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in AbuseKeywords->checkBlockWordExist==".$ex->getMessage());
        }
    }
    /**
     * @author Sagar
     * @usage push the blocked post id's into respected blockwords 
     * @param type $blockWordArray
     * @param type $postId
     * @param type $categoryId
     * @param type $networkId
     * @return 
     */
    public function PushBlockedPost($blockWordArray,$postId, $categoryId, $networkId){       
        try {
            $return = "failure";
            foreach ($blockWordArray as $blockWord) {
                $pushArray = array();
                $pushArray['PostId'] = new MongoId($postId);
                $pushArray['CategoryId'] = (int)$categoryId;
                $pushArray['NetworkId'] = (int)$networkId;
                $mongoCriteria = new EMongoCriteria;
                $mongoModifier = new EMongoModifier;
                $mongoModifier->addModifier('BlockedPosts', 'push', $pushArray);
                $mongoCriteria->addCond('AbuseWord', '==', $blockWord);
                AbuseKeywords::model()->updateAll($mongoModifier, $mongoCriteria);
                $return = "success";
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:PushBlockedPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in AbuseKeywords->PushBlockedPost==".$ex->getMessage());
        }
    }
    /**
     * @author Sagar
     * @usage push the blocked post and comment id's into respected blockwords 
     * @param type $blockWordArray
     * @param type $postId
     * @param type $commentId
     * @param type $categoryId
     * @param type $networkId
     * @return 
     */
    public function PushBlockedComment($blockWordArray,$postId, $commentId, $categoryId, $networkId){       
        try {
            foreach ($blockWordArray as $blockWord) {
                $pushArray = array();
                $pushArray['PostId'] = new MongoId($postId);
                $pushArray['CommentId'] = new MongoId($commentId);
                $pushArray['CategoryId'] = (int)$categoryId;
                $pushArray['NetworkId'] = (int)$networkId;
                $mongoCriteria = new EMongoCriteria;
                $mongoModifier = new EMongoModifier;
                $mongoModifier->addModifier('BlockedComments', 'push', $pushArray);
                $mongoCriteria->addCond('AbuseWord', '==', $blockWord);
                $mongoCriteria->addCond('Status', '==', 0);
                AbuseKeywords::model()->updateAll($mongoModifier, $mongoCriteria);
            }
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:PushBlockedComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in AbuseKeywords->PushBlockedComment==".$ex->getMessage());
        }
    }
    /**
     * @author Sagar
     * @usage pop the blocked post id's into respected blockwords 
     * @param type $blockWord
     * @param type $postId
     * @param type $categoryId
     * @param type $networkId
     * @return 
     */
    public function PopBlockedPost($blockWord,$postId, $categoryId, $networkId){       
        try {
            $return = "failure";
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->BlockedPosts->PostId("==" ,new MongoId($postId)); 
            $mongoCriteria->BlockedPosts->CategoryId("==" ,(int)$categoryId); 
            $mongoCriteria->BlockedPosts->NetworkId("==" ,(int)$networkId);
            $popArray = array();
            $popArray['PostId'] = new MongoId($postId);
            $popArray['CategoryId'] = (int)$categoryId;
            $popArray['NetworkId'] = (int)$networkId;
            $mongoModifier->addModifier('BlockedPosts', 'pull', $popArray);
            $mongoCriteria->addCond('AbuseWord', '==', $blockWord);
            $return = AbuseKeywords::model()->updateAll($mongoModifier, $mongoCriteria);
            return $return;
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:PopBlockedPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in AbuseKeywords->PopBlockedPost==".$ex->getMessage());
        }
    }
    /**
     * @author Sagar
     * @usage pop the blocked post and comment id's from respected blockwords 
     * @param type $blockWord
     * @param type $postId
     * @param type $commentId
     * @param type $categoryId
     * @param type $networkId
     * @return 
     */
    public function PopBlockedComment($blockWord,$postId, $commentId, $categoryId, $networkId){       
        try {
            $return = "failure";
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoCriteria->BlockedComments->PostId("==" ,new MongoId($postId)); 
            $mongoCriteria->BlockedComments->CommentId("==" ,new MongoId($commentId)); 
            $mongoCriteria->BlockedComments->CategoryId("==" ,(int)$categoryId); 
            $mongoCriteria->BlockedComments->NetworkId("==" ,(int)$networkId);
            $popArray = array();
            $popArray['PostId'] = new MongoId($postId);
            $popArray['CommentId'] = new MongoId($commentId);
            $popArray['CategoryId'] = (int)$categoryId;
            $popArray['NetworkId'] = (int)$networkId;
            $mongoModifier->addModifier('BlockedComments', 'pull', $popArray);
            $mongoCriteria->addCond('AbuseWord', '==', $blockWord);
            $mongoCriteria->addCond('Status', '==', 0);
            $return = AbuseKeywords::model()->updateAll($mongoModifier, $mongoCriteria);
            return $return;
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:PopBlockedComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in AbuseKeywords->PopBlockedComment==".$ex->getMessage());
        }
    }
    /**
    * @Author Sagar Pathapelli
    * This method is used get AbuseWord Collection
    * @return type
    */
    public function getAbuseWordCollection() {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('Status', '==', 0);
            $abuseWordsObj = AbuseKeywords::model()->findAll($criteria);
            return $abuseWordsObj;
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:getAbuseWordCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @author Sagar
     * @usage used to save the array of block words
     * @param array $blockWords
     * @return 
     */
    public function saveBlockWords($blockWords)
    {
        try{
            $returnValue = 'failure';
            if(sizeof($blockWords)>0){
                foreach ($blockWords as $AbuseWord) {
                    $AbuseWord = trim($AbuseWord);
                    if(strlen($AbuseWord)>0){
                        $criteria = new EMongoCriteria;
                        $criteria->addCond('AbuseWord', '==', $AbuseWord);
                        $Obj = AbuseKeywords::model()->find($criteria);
                        if (is_object($Obj)) {
                            $Obj->Status=0;
                            $Obj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time()))); 
                            if ($Obj->update()) {
                                $returnValue = "success";
                            }
                        }else{
                            $abuseKeywords = new AbuseKeywords();
                            $abuseKeywords->AbuseWord = strtolower($AbuseWord);
                            $abuseKeywords->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time()))); 
                            $abuseKeywords->Status = 0;
                            if ($abuseKeywords->save()) {
                                $returnValue = "success";
                            }
                        }
                    }
                }
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:saveBlockWords::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'exception';
        }
    }
    /**
     * @author Sagar
     * @usage used to delete array of block words
     * @param array $blockWords
     * @return 
     */
    public function deleteBlockWords($blockWords)
    {
        try{
            $returnValue = 'failure';
            if(sizeof($blockWords)>0){
                foreach ($blockWords as $AbuseWord) {
                    $mongoCriteria = new EMongoCriteria;
                    $mongoModifier = new EMongoModifier;
                    $abuseKeywords = new AbuseKeywords();
                    $mongoModifier->addModifier('Status', 'set', 1);
                    $mongoCriteria->addCond('AbuseWord', '==', $AbuseWord);
                    $res = AbuseKeywords::model()->updateAll($mongoModifier, $mongoCriteria);
                }
            }
            $returnValue = "success";
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:deleteBlockWords::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'exception';
        }
    }
    /**
     * @author Sagar
     * @usage get abuse word object by name
     * @param type $abuseWord
     * @return array
     */
    public function getAbuseWordObjByName($abuseWord) {
        try {
            $returnValue = 'failure';
            $attributes = array('AbuseWord'=>$abuseWord, 'Status'=>0);
            $returnValue = AbuseKeywords::model()->findByAttributes($attributes);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("AbuseKeywords:getAbuseWordObjByName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
}
