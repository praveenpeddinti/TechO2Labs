<?php

class AdTrackingCollection extends EMongoDocument{
    
    public $_id;
    public $AdvertisementId;
    public $Users=array();
    public $CreatedOn;
    public function getCollectionName() {
        return 'AdTrackingCollection';
    }
     public static function model($className = __CLASS__) {
        return parent::model($className);
    }
     public function attributeNames() {
         return array(
             '_id'=>'_id',
             'AdvertisementId'=>'AdvertisementId',
             'Users'=>'Users',
             'CreatedOn'=>'CreatedOn',
         );
     }
     
    public function createAdTrackDocument($adId){
        $returnvalue='failure';
        try {
            $adTrack=new AdTrackingCollection();
            $adTrack->AdvertisementId=(int)$adId;
            $adTrack->Users=array();
            $adTrack->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            if($adTrack->save()){
                $returnValue='success';
            }
            return $returnValue;  
        } catch (Exception $ex) {          
            Yii::log("AdTrackingCollection:createAdTrackDocument::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return "failure";
        }
        } 
     public function trackAdClick($adId,$userId){
     try {
           $returnValue = 'failure';
           $mongoCriteria = new EMongoCriteria;
           $mongoModifier = new EMongoModifier;
           
           $userArray=array();
           $userArray['UserId']=(int)$userId;
           $userArray['ClickTime']=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
           
           $mongoCriteria->addCond('AdvertisementId', '==', (int)$adId);
           $mongoModifier->addModifier('Users', 'push', $userArray);   
           
           AdTrackingCollection::model()->updateAll($mongoModifier, $mongoCriteria);
           
     } catch (Exception $ex) {       
        Yii::log("AdTrackingCollection:trackAdClick::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return "failure";
     }
  }
}