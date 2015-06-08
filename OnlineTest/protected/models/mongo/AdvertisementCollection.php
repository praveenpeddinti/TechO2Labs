<?php

class AdvertisementCollection extends EMongoDocument{
    
    public $_id;
    public $AdvertisementId;
    public $Name;
    public $ExtensionType;
    public $Url;
    public $RedirectUrl;
    public $DisplayPage;
    public $Status;
    public $CreatedOn;
    public $StartDate;
    public $ExpiryDate;
    public $GroupId;
    public $OutsideUrl;
    public $SourceType;
    public $Height;
    public $Width;
    public $RequestedFields;
    public $Title;
    public $AdType;
    
    public $Type;
    public $UserId;
    public $Priority;
   
    public $Description;
    public $Followers = array();
    public $Mentions = array();
    public $Comments = array();
    public $Resource = array();
    public $Love = array();
    public $Invite = array();
    public $Share = array();
    public $Subject;
    public $CategoryId ;
    public $DisableComments = 0;
    public $IsAbused = 0; //0 - Default/Release, 1 - Abused, 2 - Blocked
    public $AbusedUserId;
    public $IsDeleted = 0;
    public $IsPromoted = 0;
    public $PromotedUserId;
    public $NetworkId;
    public $AbusedOn;
    public $IsBlockedWordExist = 0;
    public $IsFeatured = 0;
    public $FeaturedUserId;
    public $FeaturedOn;
    public $IsBlockedWordExistInComment = 0;
    public $WebUrls;
    public $Division = 0;
    public $District = 0;
    public $Region = 0;
    public $Store = 0;
    public $FbShare = array();
    public $TwitterShare = array();
    public $MigratedPostId = '';
    //$postedBy is added by Sagar for PostAsNetwork
    public $PostedBy = 0;
    public $PromotedDate;
    public $IsWebSnippetExist;
    public $HashTags;
    public $RequestedParams;

    public $BannerTemplate;
    public $BannerContent;
    public $BannerTitle;
    public $ImpressionTag;
    public $ClickTag;
    public $BannerOptions;
    public $IsThisExternalParty;
    public $ExternalPartyUrl;
    public $ExternalPartyName;
    public $StreamBundle;
    public $SegmentId=0;
    public $Language='en';
    public $Banners=array();
    public $Uploads=array();
    public $SubSpeciality;
    public $Country;
    public $State;
    public $Classification;
    public $IsPremiumAd;
    public $PTimeInterval;
 
    public function getCollectionName() {
        return 'AdvertisementCollection';
    }
     public static function model($className = __CLASS__) {
        return parent::model($className);
    }
     public function attributeNames() {
         return array(
                '_id'=>'_id',
                'AdvertisementId'=>'AdvertisementId',
                'Name'=>'Name',
                'ExtensionType'=>'ExtensionType',
                'Url'=>'Url',
                'RedirectUrl'=>'RedirectUrl',
                'DisplayPage'=>'DisplayPage',
                'Status'=>'Status',
                'CreatedOn'=>'CreatedOn',
                'StartDate'=>'StartDate',
                'ExpiryDate'=>'ExpiryDate',
                'GroupId'=>'GroupId',
                'OutsideUrl'=>'OutsideUrl',
                'SourceType'=>'SourceType',
                'Height'=>'Height',
                'Width'=>'Width',
                'RequestedFields'=>'RequestedFields',
                'Title'=>'Title',
                'AdType'=>'AdType',
                'Type'=>'Type',
                'CategoryId' =>'CategoryId',
                'RequestedParams' =>'RequestedParams',
                'BannerTemplate' =>'BannerTemplate',
                'BannerContent' =>'BannerContent',
                'BannerTitle' =>'BannerTitle',
                'StreamBundle' =>'StreamBundle',
                'ImpressionTag' =>'ImpressionTag',
                'ClickTag' =>'ClickTag',
                'BannerOptions' =>'BannerOptions',
                'IsThisExternalParty' =>'IsThisExternalParty',
                'ExternalPartyUrl' =>'ExternalPartyUrl',
                'ExternalPartyName' =>'ExternalPartyName',
                'SegmentId'=>'SegmentId',
                'Language'=>'Language',
                'Banners'=>'Banners',
                'Uploads'=>'Uploads',
                'SubSpeciality'=>'SubSpeciality',
                'Country'=>'Country',
                'State'=>'State',
                'Classification'=>'Classification',
             'IsPremiumAd' => 'IsPremiumAd',
             'PTimeInterval' => 'PTimeInterval'

         );
     }
     
    public function createAdvertisementDocument($AdvertisementObj){
        $returnvalue='failure';
        try {
            $adObject=new AdvertisementCollection();
            $adObject->AdvertisementId=(int)$AdvertisementObj->id;  
            $adObject->SegmentId = (int)$AdvertisementObj->SegmentId;
            $adObject=$this->setAdvertisementData($adObject,$AdvertisementObj);
            $adObject->CreatedOn=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            if($adObject->save()){
                $returnValue=$adObject->_id;
            }
            return $returnValue;  
        } catch (Exception $ex) {  
            Yii::log("AdvertisementCollection:createAdvertisementDocument::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           return "failure";
        }
        } 
        
        public function updateAdvertisementDocument($AdvertisementObj) {
        try {

            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;

            $mongoCriteria->addCond('AdvertisementId', '==', (int) $AdvertisementObj->id);
            $mongoModifier->addModifier('Name', 'set', $AdvertisementObj->Name);
            $mongoModifier->addModifier('Title', 'set', $AdvertisementObj->Title);
            $mongoModifier->addModifier('ExtensionType', 'set', $AdvertisementObj->Type);
            $mongoModifier->addModifier('Url', 'set', $AdvertisementObj->Url);
            $mongoModifier->addModifier('RedirectUrl', 'set', $AdvertisementObj->RedirectUrl);
            $mongoModifier->addModifier('DisplayPage', 'set', $AdvertisementObj->DisplayPage);
            $mongoModifier->addModifier('Status', 'set', $AdvertisementObj->Status);
            $mongoModifier->addModifier('StartDate', 'set', new MongoDate(strtotime($AdvertisementObj->StartDate)));
            $mongoModifier->addModifier('ExpiryDate', 'set', new MongoDate(strtotime($AdvertisementObj->ExpiryDate)));
            $mongoModifier->addModifier('GroupId', 'set', $AdvertisementObj->GroupId);
            if($AdvertisementObj->DisplayPage!="Group"){
               $mongoModifier->addModifier('GroupId', 'set', ""); 
            }
             
            $mongoModifier->addModifier('Banners', 'set', $AdvertisementObj->Banners);
            $mongoModifier->addModifier('Uploads', 'set', $AdvertisementObj->Uploads);
            $mongoModifier->addModifier('OutsideUrl', 'set', $AdvertisementObj->OutsideUrl);
            $mongoModifier->addModifier('SourceType', 'set', $AdvertisementObj->SourceType);
            $mongoModifier->addModifier('Height', 'set', $AdvertisementObj->Height);
            $mongoModifier->addModifier('Width', 'set', $AdvertisementObj->Width);
            $mongoModifier->addModifier('RequestedFields', 'set', $AdvertisementObj->RequestedFields);
            $mongoModifier->addModifier('AdType', 'set', $AdvertisementObj->AdTypeId);
            $mongoModifier->addModifier('RequestedParams', 'set', $AdvertisementObj->RequestedParams);
            $mongoModifier->addModifier('BannerTemplate', 'set', $AdvertisementObj->BannerTemplate);
            $mongoModifier->addModifier('BannerContent', 'set', $AdvertisementObj->BannerContent);
            $mongoModifier->addModifier('BannerTitle', 'set', $AdvertisementObj->BannerTitle);
            $mongoModifier->addModifier('ImpressionTag', 'set', $AdvertisementObj->ImpressionTag);
            $mongoModifier->addModifier('StreamBundle', 'set', $AdvertisementObj->StreamBundle);
            $mongoModifier->addModifier('ClickTag', 'set', $AdvertisementObj->ClickTag);
            $mongoModifier->addModifier('BannerOptions', 'set', $AdvertisementObj->BannerOptions);
            $mongoModifier->addModifier('IsThisExternalParty', 'set', (int)$AdvertisementObj->IsThisExternalParty);
            $mongoModifier->addModifier('ExternalPartyUrl', 'set', $AdvertisementObj->ExternalPartyUrl);
            $mongoModifier->addModifier('ExternalPartyName', 'set', $AdvertisementObj->ExternalPartyName);
            $mongoModifier->addModifier('SubSpeciality', 'set', $AdvertisementObj->SubSpeciality);
            $mongoModifier->addModifier('Country', 'set', (int)$AdvertisementObj->Country);
            $mongoModifier->addModifier('State', 'set', $AdvertisementObj->State);
            $mongoModifier->addModifier('Classification', 'set', $AdvertisementObj->Classification);
            AdvertisementCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            $postId=$this->getAdvertisementDetailsByAdvertisementId($AdvertisementObj->id);
            $returnValue = $postId;

            return $returnValue;
        } catch (Exception $ex) {
            return $returnValue;
            Yii::log("AdvertisementCollection:updateAdvertisementDocument::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function setAdvertisementData($adObject,$AdvertisementObj){
        try{    
            $adObject->Name=$AdvertisementObj->Name;
            $adObject->ExtensionType=$AdvertisementObj->Type;
            $adObject->Url=$AdvertisementObj->Url;
            $adObject->RedirectUrl=$AdvertisementObj->RedirectUrl;
            $adObject->DisplayPage=$AdvertisementObj->DisplayPage;
            $adObject->Status=$AdvertisementObj->Status;
            $adObject->StartDate=new MongoDate(strtotime($AdvertisementObj->StartDate));
            $adObject->ExpiryDate=new MongoDate(strtotime($AdvertisementObj->ExpiryDate));
            $adObject->GroupId=$AdvertisementObj->GroupId;
            if($AdvertisementObj->DisplayPage!="Group"){
            $adObject->GroupId="";
             }
            $adObject->OutsideUrl=$AdvertisementObj->OutsideUrl;
            $adObject->SourceType=$AdvertisementObj->SourceType;
            $adObject->Height=$AdvertisementObj->Height;
            $adObject->Width=$AdvertisementObj->Width;
            $adObject->RequestedFields=$AdvertisementObj->RequestedFields;
            $adObject->Title=$AdvertisementObj->Title;
            $adObject->AdType=$AdvertisementObj->AdTypeId;
            $adObject->RequestedParams=$AdvertisementObj->RequestedParams;
            $categoryId = CommonUtility::getIndexBySystemCategoryType('Advertisement');
            $adObject->CategoryId=(int)$categoryId;
            $adObject->Type=CommonUtility::sendPostType('Advertisement');
            $adObject->BannerTemplate=(int)$AdvertisementObj->BannerTemplate;
            $adObject->Banners= $AdvertisementObj->Banners;
            $adObject->Uploads= $AdvertisementObj->Uploads;
            $adObject->BannerTitle= $AdvertisementObj->BannerTitle;
            $adObject->ImpressionTag= $AdvertisementObj->ImpressionTag;
            $adObject->StreamBundle= $AdvertisementObj->StreamBundle;
            $adObject->ClickTag= $AdvertisementObj->ClickTag;
            $adObject->BannerOptions= $AdvertisementObj->BannerOptions;
            $adObject->IsThisExternalParty= (int)$AdvertisementObj->IsThisExternalParty;
            $adObject->ExternalPartyUrl= $AdvertisementObj->ExternalPartyUrl;
            $adObject->ExternalPartyName= $AdvertisementObj->ExternalPartyName;
            $adObject->SubSpeciality= $AdvertisementObj->SubSpeciality;
            $adObject->Country = $AdvertisementObj->Country;
            $adObject->State= $AdvertisementObj->State;
            $adObject->Classification= $AdvertisementObj->Classification;
            $adObject->IsPremiumAd = (int) $AdvertisementObj->IsPremiumAd;
            $adObject->PTimeInterval = $AdvertisementObj->PTimeInterval;
            return $adObject;
            } catch (Exception $ex) {
          Yii::log("AdvertisementCollection:setAdvertisementData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
      }
      
  public function getAdvertisementDetailsById($postId){
             try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($postId));
            $postObj = AdvertisementCollection::model()->find($criteria);
            $returnValue = $postObj;
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("AdvertisementCollection:getAdvertisementDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 
  }
  
   public function getAdvertisementDetailsByAdvertisementId($advertisementId){
             try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('AdvertisementId', '==', (int) $advertisementId);
            $postObj = AdvertisementCollection::model()->find($criteria);
            $returnValue = $postObj->_id;
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("AdvertisementCollection:getAdvertisementDetailsByAdvertisementId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 
  }
  public function updateExistingAds() {
      try{
            $ads = AdvertisementCollection::model()->findAll();
            
            if(is_array($ads)){
                $updateCount = 0;
                foreach ($ads as $ad) {
                    $bannersCount = isset($ad->Banners) && is_array($ad->Banners)?count($ad->Banners):0;
                    $uploadsCount = isset($ad->Uploads) && is_array($ad->Uploads)?count($ad->Uploads):0;
                    if($bannersCount==0 && $uploadsCount==0){
                        $adId=$ad->AdvertisementId;
                        if($ad->AdType=="1"){
                            $uploadArray = array();
                            $uploadArray["Language"]="en";
                            $uploadArray["Type"] = $ad->ExtensionType;
                            $uploadArray["Url"] = $ad->Url;
                            $this->updateExistingAd($adId, $uploadArray);
                        }else{
                             if(isset($ad->BannerOptions) && $ad->BannerOptions=="ImageWithText"){
                                $bannerArray = array();
                                $bannerArray["Language"]="en";
                                $bannerArray["BannerTemplate"]="$ad->BannerTemplate";
                                $bannerArray["Url"] = $ad->Url;
                                $bannerArray["BannerTitle"] = $ad->BannerTitle;
                                $bannerArray["BannerContent"]=$ad->BannerContent;
                                $bannerArray["BannerOptions"] = $ad->BannerOptions;
                                $this->updateExistingAd($adId, $bannerArray, 1);
                             }else if(!isset($ad->BannerOptions) || $ad->BannerOptions=="OnlyImage"){
                                $uploadArray = array();
                                $uploadArray["Language"]="en";
                                $uploadArray["Type"] = $ad->ExtensionType;
                                $uploadArray["Url"] = $ad->Url;
                                $this->updateExistingAd($adId, $uploadArray);
                             }     
                        }
                        $updateCount++;
                    }
                }
                echo "Updated ads = ".$updateCount."\n";
            }else{
                echo "No ads found";
            }
            
      } catch (Exception $ex) {
          Yii::log("AdvertisementCollection:updateExistingAds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
  }  
  public function updateExistingAd($adId, $uploadArray, $isBanner=0) {
      try{
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if($isBanner){
                $mongoModifier->addModifier('Banners', 'push', $uploadArray);
            }else{
                $mongoModifier->addModifier('Uploads', 'push', $uploadArray);
            }
            $mongoCriteria->addCond('AdvertisementId', '==', (int)$adId);
            AdvertisementCollection::model()->updateAll($mongoModifier, $mongoCriteria);
            UserStreamCollection::model()->updateAll($mongoModifier, $mongoCriteria);
      } catch (Exception $ex) {
          Yii::log("AdvertisementCollection:updateExistingAd::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
  } 
 public function updateAdCollectionExpiredAdsStatus() {
      try{
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Status', 'set', (int)0);
            $mongoCriteria->addCond('Status', '==', (int)1);
            $today =  date('Y-m-d');
            error_log($today);
            $mongoCriteria->addCond('ExpiryDate', '<',  new MongoDate(strtotime($today)));
            AdvertisementCollection::model()->updateAll($mongoModifier, $mongoCriteria);
             error_log($today);
      } catch (Exception $ex) {
          Yii::log("AdvertisementCollection:updateAdCollectionExpiredAdsStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
 } 
       public function updatedCollectionAdDatetoMongodate() {
      try{
           $ads = AdvertisementCollection::model()->findAll();
            
            if(is_array($ads)){
                $updateCount = 0;
                foreach ($ads as $ad) {
                    if(!is_object($ad->StartDate)){
                         $mongoCriteria = new EMongoCriteria;
                         $mongoModifier = new EMongoModifier;
                         $mongoModifier->addModifier('StartDate', 'set', new MongoDate(strtotime($ad->StartDate)));
                         $mongoModifier->addModifier('ExpiryDate', 'set',new MongoDate(strtotime($ad->ExpiryDate)));
                         $mongoCriteria->addCond('_id', '==',  $ad->_id);
                         AdvertisementCollection::model()->updateAll($mongoModifier, $mongoCriteria);
                    }
                    
                }
                
            }

      } catch (Exception $ex) {
          Yii::log("AdvertisementCollection:updateAdCollectionExpiredAdsStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
      }
  } 
}