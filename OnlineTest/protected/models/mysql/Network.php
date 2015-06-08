<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Network extends CActiveRecord {

    public $NetworkId;
    public $NetworkURL;
    public $NetworkName;
    public $Status;
    public $CreatedOn;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'NetWork';
    }

    public function getNeworkId($network){
        
         try {
             $query = "Select * from Countries C where C.Id=".$network;
             $network =  Yii::app()->db->createCommand($query)->queryRow();
            if(isset($network)){
                $result=$network;
            }else{
                $network ="Select * Countries C where C.Id=1";
                $result=$network;
            }  
        } catch (Exception $ex) {
            Yii::log("Network:getNeworkId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
        
        
    }   
    public function getNeworkDetails($urlORname='US'){
        
         try {
             
            
       if (filter_var($urlORname, FILTER_VALIDATE_URL)) 
           {
              $query = "Select * from NetWork where NetworkUrl ='".$urlORname."'";
             $result =  Yii::app()->db->createCommand($query)->queryRow();
            }
            else
            {
               $query = "Select * from NetWork where NetworkId =1";
                $result = Yii::app()->db->createCommand($query)->queryRow();
            }
            
        } catch (Exception $ex) {
            Yii::log("Network:getNeworkDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
        
        
    }
     public function getCuratedTopics($userId,$networkId) {  
       try{
       $query = "Select * from CuratedTopic where UserId =".$userId." and NetworkId=".$networkId;
       $result =  Yii::app()->db->createCommand($query)->queryAll();
       return $result;
       } catch (Exception $ex) {
            Yii::log("Network:getCuratedTopics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
}
