<?php

class SkiptaAdService {
 public function saveNewAdService($adObj,$userId,$type){
    $returnValue='failure';
     try {
          $advertisementsObj=new Advertisements();
          $advertisementsObj->AdTypeId=$adObj->AdTypeId;
          if($adObj->AdTypeId==4){
            $advertisementsObj->AdTypeId=2; 
            $advertisementsObj->IsMarketRearchAd=1;
            $advertisementsObj->SurveyGroupName=$adObj->SurveyGroupName;
            $advertisementsObj->SurveyName=$adObj->SurveyName; 
            $adObj->DisplayPage="Home"; 
            $adObj->SourceType="Upload"; 
            $adObj->BannerOptions="OnlyImage"; 
            if($adObj->IsThisExternalPartyhidden==1){
               $adObj->IsThisExternalParty=1;  
            }
             if($type!="edit"){
                 $adObj->RedirectUrl = Yii::app()->params['ServerURL']."/marketresearchview/1/$adObj->SurveyGroupName";
             }
             
          }
          
          $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
             $advertisementsObj->SegmentId = (int)$tinyUserCollectionObj->SegmentId;
           $advertisementsObj->ScheduleId=$adObj->ScheduleId;
             $advertisementsObj->Name=$adObj->Name;
             $advertisementsObj->Type="";
             $advertisementsObj->Url="";
             
             $advertisementsObj->DisplayPage=$adObj->DisplayPage;
             if($advertisementsObj->AdTypeId=="1"){
                $advertisementsObj->DisplayPosition=$adObj->DisplayPosition;
                 
                if ($adObj->IsThisAdRotate == 1) {
                    $advertisementsObj->TimeInterval = $adObj->TimeInterval;
                } else {
                    $advertisementsObj->TimeInterval = null;
                }

                $advertisementsObj->IsAdRotate = $adObj->IsThisAdRotate;
  
            }
            
             
             $advertisementsObj->StartDate=date('Y-m-d H:i:s', strtotime($adObj->StartDate)); 
             if($advertisementsObj->AdTypeId == 2){
                 // for Premium ads...
                  if($adObj->IsPremiumAd == 1){
                    $advertisementsObj->IsPremiumAd = $adObj->IsPremiumAd; 
                    $advertisementsObj->PremiumTypeId = $adObj->PremiumTypeId; 
                    $advertisementsObj->PTimeInterval = $adObj->PTimeInterval; 
                  }
             }
             if($advertisementsObj->AdTypeId!="1"){
               $advertisementsObj->Title=$adObj->Title;  
//                $advertisementsObj->BannerTemplate=$adObj->BannerTemplate;
                $advertisementsObj->BannerOptions=$adObj->BannerOptions;
//                $advertisementsObj->BannerContent=$adObj->BannerContent;
//                $advertisementsObj->BannerTitle=$adObj->BannerTitle;
//                if($adObj->Url==""){
//                  if($adObj->BannerOptions=="ImageWithText"){
//                     $advertisementsObj->Url='/images/system/ad_creation_defaultbanner'.$adObj->BannerTemplate.".jpg";
//                     $adObj->Url='/images/system/ad_creation_defaultbanner'.$adObj->BannerTemplate.".jpg";  
//                  }
//                 
//                }
                if($adObj->BannerOptions=="OnlyText"){
                       $advertisementsObj->BannerContent=$adObj->BannerContentForTextOnly;
                       $advertisementsObj->BannerTitle=$adObj->BannerTitleForTextOnly;
                       $advertisementsObj->Url=null;
                       $adObj->Url=null;  
                  }
                     $advertisementsObj->IsUserSpecific= $adObj->IsUserSpecific;
                  if($adObj->IsThisExternalParty==1){
                      $advertisementsObj->ExternalPartyName=$adObj->ExternalPartyName;
                      $advertisementsObj->ExternalPartyUrl=$adObj->ExternalPartyUrl;
                      $advertisementsObj->IsThisExternalParty=1; 
                      
                      if($adObj->IsThisExternalParty==1 && $advertisementsObj->IsMarketRearchAd == 1){
                          ExtendedSurveyCollection::model()->updateSurveyBrands($adObj->SurveyIdHidden,$advertisementsObj->ExternalPartyUrl,$advertisementsObj->ExternalPartyName);
                      }
                      
                  }
                  else{
                      $advertisementsObj->ExternalPartyName=null;
                      $advertisementsObj->ExternalPartyUrl=null;
                      $advertisementsObj->IsThisExternalParty=0;  
                  }
                  if($advertisementsObj->IsUserSpecific==0){
                                        if($adObj->SubSpeciality!="PleaseSelect"){
                      $advertisementsObj->SubSpeciality=$adObj->SubSpeciality;
                  }
                  else{
                      $advertisementsObj->SubSpeciality==null;
                  }
                  if($adObj->Classification!="PleaseSelect"){
                     $advertisementsObj->Classification=$adObj->Classification;
                  }else{
                     $advertisementsObj->Classification=null; 
                  }
                  if($adObj->Country!=""){
                     $advertisementsObj->Country=$adObj->Country;
                      if($adObj->State!=""){
                        $advertisementsObj->State=$adObj->State;    
                      }else{
                          $advertisementsObj->State=null;   
                      }
                     
                   }
                   else{
                     $advertisementsObj->Country=null; 
                     $advertisementsObj->State=null;    
                   }
                  }else{
                    $advertisementsObj->SubSpeciality==null;
                    $advertisementsObj->Classification=null; 
                    $advertisementsObj->Country=null; 
                    $advertisementsObj->State=null;      
                  }
                  
             }
             else{
                $advertisementsObj->Title=null;  
//                $advertisementsObj->BannerTemplate=null;
//                $advertisementsObj->BannerOptions=null;
//                $advertisementsObj->BannerContent=null;
//                $advertisementsObj->BannerTitle=null; 
             }
             if($adObj->SourceType=="StreamBundleAds"){
                  $advertisementsObj->StreamBundle = $adObj->StreamBundleAds;
                  $advertisementsObj->BannerOptions=null;
               } 
               else{
                   $advertisementsObj->StreamBundle =null;
               }
            if($adObj->SourceType=="AddServerAds"){
                  $advertisementsObj->ImpressionTag = $adObj->ImpressionTags;
                  $advertisementsObj->ClickTag = $adObj->ClickTag; 
               }else{
                  $advertisementsObj->ImpressionTag = null;
                  $advertisementsObj->ClickTag = null;  
               }
             if($advertisementsObj->AdTypeId=="3"){
                $advertisementsObj->RequestedFields= implode(', ',$adObj->RequestedFields);
                $requestedParams=null;
                if(!empty($adObj->Requestedparam1) && stristr($advertisementsObj->RequestedFields,"UserId")!=""){
                  $requestedParams= "UserId:".$adObj->Requestedparam1; 
                }
                 
                if(!empty($adObj->Requestedparam2) && stristr($advertisementsObj->RequestedFields,"Display Name")!=""){
                    $requestedParams.=$requestedParams==null?null:',';
                  $requestedParams.= "Display Name:".$adObj->Requestedparam2; 
                }
                $advertisementsObj->RequestedParams=$requestedParams;
             }
             else{
                 $advertisementsObj->RequestedFields=null;
                 $advertisementsObj->RequestedParams=null;
             }
             if($type=="edit"){
                $advertisementsObj->Status= $adObj->Status;
             }else{
               $advertisementsObj->Status=$adObj->Status;    
             }
             
             $advertisementsObj->CreatedUserId=$userId;
             $advertisementsObj->SourceType=$adObj->SourceType;
               
             if($adObj->SourceType=='OutsideSource'){
                $advertisementsObj->Url=$adObj->OutsideUrl; 
                $advertisementsObj->OutsideUrl=$adObj->OutsideUrl; 
             }else{
                $advertisementsObj->OutsideUrl=null; 
             }
             
             
             if(!empty($adObj->RedirectUrl)){
              $advertisementsObj->RedirectUrl=$adObj->RedirectUrl;           
             }else{
                 if($adObj->SourceType=='OutsideSource'){
                     $advertisementsObj->RedirectUrl=null; 
                 }else{
                   $advertisementsObj->RedirectUrl=null;       
                 }
              
             }             
             $advertisementsObj->ExpiryDate=date('Y-m-d H:i:s', strtotime($adObj->ExpiryDate));     
             if($adObj->DisplayPage=='Group'){
                  $groupString='AllGroups';
                if($adObj->GroupId[0]!='AllGroups'){
                  $groupString=  implode(', ', $adObj->GroupId);  
                } 

              $advertisementsObj->GroupId=$groupString;    
             }else{
                 $advertisementsObj->GroupId=0;
             }
             
             $advertisementsObj->CreatedOn=date('Y-m-d H:i:s', time());
             $advertisementsObj->ExternalReferenceId = $adObj->ExternalReferenceId;
             if($type=='edit'){
               $advertisementsObj->id=  $adObj->id;
             }
             $adId=Advertisements::model()->saveAdvertisements($advertisementsObj,$type); 
             $categoryId = CommonUtility::getIndexBySystemCategoryType('Advertisement');
             if($type!='edit'){
                $advertisementsObj->id=$adId;
             }
             $advertisementsObj->Uploads = array();
             $advertisementsObj->Banners = array();
            if($advertisementsObj->BannerOptions != "ImageWithText"){
                $adObj->Uploads = CJSON::decode($adObj->Uploads, true);
               if(is_array($adObj->Uploads) && count($adObj->Uploads)>0){
                   $advertisementsObj->Uploads = $adObj->Uploads;
                   $advertisementSource=AdSourceTypeData::model()->saveAdSourceType($advertisementsObj->id, $adObj->Uploads);
               }
            }else if($advertisementsObj->BannerOptions == "ImageWithText"){
                $adObj->Banners = CJSON::decode($adObj->Banners, true);
                if(is_array($adObj->Banners) && count($adObj->Banners)>0){
                    $advertisementsObj->Banners = $adObj->Banners;
                    AdSourceTypeData::model()->saveBanners($advertisementsObj->id, $adObj->Banners);
                }
            }
             if(is_int($adId)){
                 AdTrackingCollection::model()->createAdTrackDocument($adId);
                 if($advertisementsObj->AdTypeId==3 || $advertisementsObj->AdTypeId==2){
                    if($type!='edit'){
                       $advertisementsObj->id=$adId;
                      
                      $adId=AdvertisementCollection::model()->createAdvertisementDocument($advertisementsObj); 
                      
                      if($advertisementsObj->IsUserSpecific==1){
                          $userIdList=User::model()->getUserIdsByEmails($adObj->FileName);
                          UserSpecificAds::model()->saveUserSpecificAdsDetails($userIdList,$advertisementsObj->id);
                          foreach($userIdList as $uid){
                             CommonUtility::prepareStreamObject((int)$uid['UserId'],"Post",$adId,$categoryId,"","", "");   
                          }
                          
                      }
                      else{
                         CommonUtility::prepareStreamObject((int)0,"Post",$adId,$categoryId,"","", "");     
                      }
                      $returnValue='success';
                    }

                 }
                 else{
                   $returnValue='success';  
                 }
                
             }  else {
                
                if ($adId = "success") {
                    if ($advertisementsObj->AdTypeId == 3 || $advertisementsObj->AdTypeId == 2) {
                        $postId=AdvertisementCollection::model()->updateAdvertisementDocument($advertisementsObj);
                        
                        if ($advertisementsObj->IsUserSpecific==1) {
                           
                            if($adObj->FileName!=""){
                                $userIdList=User::model()->getUserIdsByEmails($adObj->FileName);
                                UserSpecificAds::model()->saveUserSpecificAdsDetailsForEdit($userIdList,$advertisementsObj->id);
                            }
                            
                            $userIdList=UserSpecificAds::model()->getUserListByAdvertisementId($advertisementsObj->id);
                            foreach ($userIdList as $uid) {
                                $isStreamExist = UserStreamCollection::model()->getStreamForAdvertisementByAdvertisementId($advertisementsObj->id, (int) $uid->UserId);
                                if(!$isStreamExist){
                                    CommonUtility::prepareStreamObject((int) $uid->UserId, "Post", $postId, $categoryId, "", "", "");
                                }else{
                                   UserStreamCollection::model()->updateStreamForAdvertisement($categoryId,$postId,$advertisementsObj,(int) $uid->UserId); 
                                }
                                
                            }
                        }
                        else{
                           UserStreamCollection::model()->updateStreamForAdvertisement($categoryId,$postId,$advertisementsObj,0);
                           $returnValue='success'; 
                        }   
                    }
                else{
                   $returnValue = 'success';
                    }
                }
               
            }
            return $returnValue;
     } catch (Exception $ex) {
        Yii::log("SkiptaAdService:saveNewAdService::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        error_log("Exception Occurred in SkiptaAdService->saveNewAdService### ".$ex->getMessage());
        return $returnValue;
     }
  }
  
public function loadAds($position,$page,$groupId='', $segmentId=0, $userLanguage='en'){
    $returnValue='failure';
    try {
        if($page=='curbsidePost'){
            $page="Curbside";
        }else if($page=="post"){
            $page="Home";
        }
        else if($page=="group"){
            $page="Group";
        }
        $loadAds=Advertisements::model()->loadAds($position,$page,$groupId, $segmentId);
        if($loadAds!="failure" && (is_array($loadAds) || is_object($loadAds))){
            for($i=0; $i<count($loadAds);$i++){
                if($loadAds[$i]["SourceType"]=="Upload" || $loadAds[$i]["SourceType"]=="AddServerAds"){
                    $conditions = array('AdId'=>(int)$loadAds[$i]['id'], 'Language'=>$userLanguage);
                    $sourceType = AdSourceTypeData::model()->getAdSourceTypeObject($conditions);
                    if(isset($sourceType->Url)){
                        $loadAds[$i]['Url'] = $sourceType->Url;
                        $loadAds[$i]['Type'] = $sourceType->Type;
                        $loadAds[$i]['Width'] = $sourceType->Width;
                        $loadAds[$i]['Height'] = $sourceType->Height;
                        
                    }else{
                        $conditions = array('AdId'=>(int)$loadAds[$i]['id'], 'Language'=>"en");
                        $sourceType = AdSourceTypeData::model()->getAdSourceTypeObject($conditions);
                        if(isset($sourceType->Url)){
                            $loadAds[$i]['Url'] = $sourceType->Url;
                            $loadAds[$i]['Type'] = $sourceType->Type;
                                $loadAds[$i]['Width'] = $sourceType->Width;
                                $loadAds[$i]['Height'] = $sourceType->Height;
                        }
                    }
                }
            }
         }
        return $loadAds;
    } catch (Exception $ex) {
        Yii::log("SkiptaAdService:loadAds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
} 

public function getAllAdvertisementsForAdmin($searchText='',$startLimit='',$pageLength='',$filterValue='', $segmentId=0){
    $returnValue='failure';
    try {
        $advertisements=Advertisements::model()->GetAllAdvertisementsForAdmin($searchText, $startLimit, $pageLength,$filterValue, $segmentId);
        if(is_array($advertisements) || is_object($advertisements)){
            for($i=0;$i<sizeof($advertisements);$i++) {
                $conditions = array('AdId'=>(int)$advertisements[$i]['id']);
                $sourceType = AdSourceTypeData::model()->getAdSourceTypeObject($conditions);
                if(isset($sourceType->Url)){
                    $advertisements[$i]['Url'] = $sourceType->Url;
                    $advertisements[$i]['Type'] = $sourceType->Type;
                }
            }
        }
        
        return $advertisements;
    } catch (Exception $ex) {
        Yii::log("SkiptaAdService:getAllAdvertisementsForAdmin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        return 'failure';
        
    }
}
public function getTotalCountForAdvertisements($searchText,$filterValue, $segmentId=0){
    $returnValue='failure';
    try {
        $totalCount=Advertisements::model()->getTotalCountForAdvertisements($searchText,$filterValue, $segmentId);
        return $totalCount;
    } catch (Exception $ex) {
        Yii::log("SkiptaAdService:getTotalCountForAdvertisements::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        return 'failure';
    }
}

public function getAdvertisementByType($type,$value){
    try {
        $returnValue=Advertisements::model()->getAdvertisementsByType($type,$value);
        return $returnValue;
    } catch (Exception $ex) {
        Yii::log("SkiptaAdService:getAdvertisementByType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        return 'failure';
    }
}

public function trackAdClick($adId,$userId){
    try {        
        AdTrackingCollection::model()->trackAdClick($adId,$userId);
    } catch (Exception $ex) {
       Yii::log("SkiptaAdService:trackAdClick::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        return 'failure';
    }
}

public function getAdsCountForGroup($groupId){
    try {        
        $advertisementCount=Advertisements::model()->getGroupAdsCount($groupId);
        return $advertisementCount;
    } catch (Exception $ex) {
       Yii::log("SkiptaAdService:getAdsCountForGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
}

public function getAdTypes(){
    try {
        $AdTypesArray=array();
        $adTypes=AdType::model()->getAdTypes();
         if(is_object($adTypes) || is_array($adTypes)){               
               foreach($adTypes as $adType){                      
                   $id=$adType['id'];
                   $AdTypesArray[$id]=$adType['Type'];                
                   
                   
               }
             $returnValue=$AdTypesArray;  
           }
        return $AdTypesArray;
    } catch (Exception $ex) {
        Yii::log("SkiptaAdService:getAdTypes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
}}

    public function getAdSourceTypeData($conditions){
        try {        
            $advertisementSource=AdSourceTypeData::model()->getAdSourceTypeData($conditions);
            return $advertisementSource;
        } catch (Exception $ex) {
           Yii::log("SkiptaAdService:getAdSourceTypeData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

    }


public function getAdRequestedFields(){
    try {
        $adRequestedFieldsArray=array();
        
        $adRequestedFields=AdRequestedFields::model()->getAdRequestedFields();
         if(is_object($adRequestedFields) || is_array($adRequestedFields)){               
               foreach($adRequestedFields as $adRequestedField){                      
                   $id=$adRequestedField['FieldName'];
                   $adRequestedFieldsArray[$id]=$adRequestedField['FieldName'];                
                   
                   
               }

           }
        return $adRequestedFieldsArray;
    } catch (Exception $ex) {
        Yii::log("SkiptaAdService:getAdRequestedFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}
public function saveUserAdTrack($userId, $postId) {
        try {
            $isExist = UserAdTrack::model()->isUserAdTrackExist($userId, $postId);
            $postObj = AdvertisementCollection::model()->getAdvertisementDetailsById($postId);
            if (!$isExist) {
                         UserAdTrack::model()->saveUserAdTrack($postObj, $userId);
            }
            AdTrackingCollection::model()->trackAdClick($postObj->AdvertisementId, $userId);
        } catch (Exception $ex) {
            Yii::log("SkiptaAdService:saveUserAdTrack::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
    }
    
public function getAdCollectionByAdvertisementId($adId) {
    $returnValue='failure';
        try {
            
            $returnValue = UserStreamCollection::model()->getStreamForAdvertisementByAdvertisementId($adId);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaAdService:getAdCollectionByAdvertisementId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
public function isAnyAdsConfiguredWithThisDisplayPosition($DisplayPosition, $adTypeId,$displayPage,$startDate,$exDate,$isThisAdRotate,$adId,$status, $segmentId=0) {
       $returnValue='failure';
        try {
            $result = Advertisements::model()->isAnyAdsConfiguredWithThisDisplayPosition($DisplayPosition, $adTypeId,$displayPage,$startDate,$exDate,$isThisAdRotate, $segmentId);
            if(sizeof($result)>0){
                if(empty($adId)){
                   $returnValue=true; 
                }
                else if($status==1){
                    $newList=array();
                  foreach($result as $obj){
                    if($adId!=$obj['id']){
                       array_push($newList,$obj); 
                    }
                  }
                  if(sizeof($newList)>0){
                      $returnValue=true; 
                  }
                  else{
                    $returnValue=false;  
                  }
                }
                else{
                  $returnValue=false;  
                }
            
            }
            else{
                $returnValue=false;
            }
             
          return $returnValue;  
        } catch (Exception $ex) {
            Yii::log("SkiptaAdService:isAnyAdsConfiguredWithThisDisplayPosition::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
    }
    
public function inActivateWidgetAds($DisplayPosition, $adTypeId,$displayPage,$startDate,$exDate){
     $returnValue='failure';
        try {
            $result = Advertisements::model()->isAnyAdsConfiguredWithThisDisplayPosition($DisplayPosition, $adTypeId,$displayPage,$startDate,$exDate);
            $ids='';
            foreach($result as $obj){
               $ids.=($ids!=''?','.$obj['id']:$obj['id']);  

            }
           $returnValue = Advertisements::model()->inActivateWidgetAds($ids);
             
          return $returnValue;  
        } catch (Exception $ex) {
            Yii::log("SkiptaAdService:inActivateWidgetAds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
}
public function getAdvertisementsById($id){
     $returnValue='failure';
        try {
            $returnValue = Advertisements::model()->getAdvertisementsById($id);
           
             
          return $returnValue;  
        } catch (Exception $ex) {
            Yii::log("SkiptaAdService:getAdvertisementsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
}
public function loadPageAds($pageType){
    $returnValue='failure';
    try {
        $loadAds=Advertisements::model()->loadPageAds($pageType);
        return $loadAds;
    } catch (Exception $ex) {
        Yii::log("SkiptaAdService:loadPageAds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}

public function getSurveyAdvertisementByScheduleId($scheduleId){
     $returnValue='failure';
        try {
            $returnValue = Advertisements::model()->getSurveyAdvertisementByScheduleId($scheduleId);
           
             
          return $returnValue;  
        } catch (Exception $ex) {
            Yii::log("SkiptaAdService:getSurveyAdvertisementByScheduleId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
}
public function getUserClassifications(){
     $returnValue=array();
        try {
            $userClassifications = UserClassification::model()->getUserClassifications();
            $classificationArray = array();
            if (is_array($userClassifications) || is_object($userClassifications)) {
                $classificationArray['PleaseSelect'] = "Please Select";
                
                foreach ($userClassifications as $spe) {
                    $id = (int) $spe->Id;
                    $classificationArray[$id] = Yii::t('Classification', $spe->ClassificationName);
                }
                $returnValue=$classificationArray;
            }
             
          return $returnValue;  
        } catch (Exception $ex) {
           Yii::log("SkiptaAdService:getSurveyAdvertisementByScheduleId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return 'failure';
        }
}
public function getStreamForAdvertisementPreivewByAdvertisementId($adId) {
    $returnValue='failure';
        try {
            
            $returnValue = UserStreamCollection::model()->getStreamForAdvertisementPreivewByAdvertisementId($adId);
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("SkiptaAdService:getStreamForAdvertisementPreivewByAdvertisementId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
/* presently not useful ...    
 public function getPremiumAds(){
    try {
        $premiumAdsArr = array();
        $premiumAds = PremiumAd::model()->getPremiumAds();        
         if(is_object($premiumAds)){               
               foreach($premiumAds as $type){   
                   
//                   $id = $type->id;
//                   $premiumAdsArr[$id] = $type->Type;                   
               }
             $returnValue = $premiumAdsArr;  
           }
        return $returnValue;
    } catch (Exception $ex) {
        Yii::log("SkiptaAdService:getPremiumAds::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }

}
 * */
 
    public function isPremiumAdSlotFilled($slots,$adType,$displayPage,$startDate,$ExpiryDate,$adId,$status,$segmentId){
        try{
            return Advertisements::model()->isPremiumAdSlotFilled($slots,$adType,$displayPage,$startDate,$ExpiryDate,$adId,$status,$segmentId);
        } catch (Exception $ex) {
            error_log("SkiptaAdService:isPremiumAdSlotFilled::".$ex->getMessage()."--".$ex->getTraceAsString());
            Yii::log("SkiptaAdService:isPremiumAdSlotFilled::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
}
