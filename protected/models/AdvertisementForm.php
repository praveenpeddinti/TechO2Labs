<?php

class AdvertisementForm extends CFormModel {
    public $id;    
    public $Name;    
    public $Type;    
    public $RedirectUrl;
    public $DisplayPage;
    public $Status;
    public $DisplayPosition;        
    public $TimeInterval;
    public $ExpiryDate;        
    public $GroupId;
    public $Url;
    public $OutsideUrl;
    public $SourceType;
    public $AdTypeId;
    public $StartDate;
    public $RequestedFields;
    public $Title;
    public $Requestedparam1;
    public $Requestedparam2;
    public $IsThisAdRotate;
    public $DoesthisAdrotateHidden;
    public $StreamBundleAds;
    public $ImpressionTags;
    public $ClickTag;
    public $BannerTemplate;
    public $BannerOptions;
    public $BannerContent;
    public $BannerTitle;
    public $BannerContentForTextOnly;
    public $BannerTitleForTextOnly;
    public $IsThisExternalParty;
    public $ExternalPartyName;
    public $ExternalPartyUrl;
    public $ExternalReferenceId;
    public $Languages;
    public $Banners;
    public $Uploads;
    public $ScheduleId;
    public $SubSpeciality;
    public $Country;
    public $State;
    public $Classification;
    public $FileName;
    public $IsUserSpecific=0;
    public $SurveyGroupName;
    public $SurveyName;
    public $IsMarketRearchAd=0;
    public $IsThisExternalPartyhidden=0;
    public $SurveyIdHidden;
    public $IsPremiumAd = 0;
    public $PremiumTypeId;
    public $PTimeInterval;
    public function rules() {
        return array(
            

            array('PremiumTypeId,PTimeInterval,IsPremiumAd,id,Name,RedirectUrl,Url,DisplayPage,Status,DisplayPosition,TimeInterval,ExpiryDate,GroupId,Type,SourceType,OutsideUrl,AdTypeId,Title,RequestedFields,StartDate,Requestedparam1,Requestedparam2,IsThisAdRotate,DoesthisAdrotateHidden,StreamBundleAds,ImpressionTags,ClickTag,BannerTemplate,BannerOptions,BannerContent,BannerTitle,BannerContentForTextOnly,BannerTitleForTextOnly,IsThisExternalParty,ExternalPartyName,ExternalPartyUrl,Languages,Banners,Uploads,ScheduleId,SubSpeciality,Country,State,Classification,FileName,IsUserSpecific,SurveyGroupName,SurveyName,IsMarketRearchAd,IsThisExternalPartyhidden,SurveyIdHidden', 'safe'),



           
             array(
                                'RedirectUrl',
                                'match', 'pattern' => '/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/',
                                'message' => Yii::t('translation','URL_should_start_with').' http:// or https://',
                            ),
        
                 array('SourceType', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                  'if' => array(
                             array('SourceType', 'compare', 'compareValue'=>"Upload"),
                ),
                'then' => array(

                   array('Languages','customRequiredForUpload' ),

                            
                    ),
               
                
            ),
             array('SourceType', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                  'if' => array(
                             array('SourceType', 'compare', 'compareValue'=>"StreamBundleAds"),
                ),
                'then' => array(

                   array('StreamBundleAds','customRequiredForStreamBundilAd'),

                            
                    ),
               
                
            ),
             array('SourceType', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                  'if' => array(
                             array('SourceType', 'compare', 'compareValue'=>"AddServerAds"),
                ),
                'then' => array(
                   array('ImpressionTags,ClickTag,Languages','customRequiredForAdserverAd'),
                            
                    ),
               
                
            ),
            array('DisplayPage', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                'if' => array(
                             array('DisplayPage', 'compare', 'compareValue'=>"Group"),
                ),
                'then' => array(
                     array('GroupId', 'required'),    
                            
                    ),
                   
            ), 
            
            
             array('AdTypeId', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                'if' => array(
                             array('AdTypeId', 'compare', 'compareValue'=>"1"),
                ),
                'then' => array(
                     array('DisplayPosition,IsThisAdRotate', 'customRequiredForWidget'),    
                            
            ),
            ),
            array('AdTypeId', 'ext.YiiConditionalValidator.YiiConditionalValidator',
               
                  'if' => array(
                             array('AdTypeId', 'compare', 'compareValue'=>"2"),
                ),
                'then' => array(

                     array('Title,SourceType,Languages,BannerTitleForTextOnly,BannerContentForTextOnly,ExternalPartyName,ExternalPartyUrl,FileName', 'customRequired'),    

                            
                    ),

                
            ),
            array('AdTypeId', 'ext.YiiConditionalValidator.YiiConditionalValidator',
               
                'if' => array(
                             array('AdTypeId', 'compare', 'compareValue'=>"3"),
                ),
                'then' => array(

                     array('Title,RequestedFields,Languages,BannerTitleForTextOnly,BannerContentForTextOnly,ExternalPartyName,ExternalPartyUrl,FileName', 'customRequiredR'),    

                            
                    ),    
            ),
            
            array('AdTypeId', 'ext.YiiConditionalValidator.YiiConditionalValidator',
               
                  'if' => array(
                             array('AdTypeId', 'compare', 'compareValue'=>"4"),
                ),
                'then' => array(

                     array('Title,SurveyGroupName,SurveyName,ScheduleId,ExternalPartyName,ExternalPartyUrl,Languages,FileName', 'customRequiredMarketResearch'),    

                            
                    ),

                
            ),
            array('id', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                'if' => array(
                             array('id', 'compare', 'compareValue'=>""),
                ),
                'then' => array(
                     array('AdTypeId', 'required'),    
                            
                    ),
                   
            ), 
           
            array('AdTypeId', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                'if' => array(
                             array('AdTypeId', 'compare', 'compareValue'=>"2"),
                ),
                'then' => array(
                     array('IsPremiumAd', 'customRequiredForWidget'),    
                            
            ),
            ),
                
          array('Name,ExpiryDate,StartDate', 'required'),  
            
            
        );
}


public function customRequired($attribute_name,$params){
    try{
       if($attribute_name == "Title" && $this->Title == ""){
            $title=$this->IsThisExternalParty==1?"External Party Context":"Title";
            $this->addError('Title',$title.' cannot be blank.');
        }
//        if(($this->BannerOptions=="OnlyImage" || $this->BannerOptions=="ImageWithText") && $attribute_name == "Languages" && $this->Languages == "" && $this->SourceType!="StreamBundleAds" ){
//            $this->addError('Languages','Please select atleast one language.');
//        }
        if($this->BannerOptions=="OnlyText" && $attribute_name == "BannerTitleForTextOnly"&& $this->BannerTitleForTextOnly == ""){
            $this->addError('BannerTitleForTextOnly','Please select banner title.');
        }
        if($this->BannerOptions=="OnlyText" && $attribute_name == "BannerContentForTextOnly"&& $this->BannerContentForTextOnly == ""){
            $this->addError('BannerContentForTextOnly','Please select banner content.');
        }
        if($this->IsThisExternalParty==1 && $attribute_name == "ExternalPartyName"&& $this->ExternalPartyName == ""){
            $this->addError('ExternalPartyName','External Party Name cannot be blank.');
        }
        if($this->IsThisExternalParty==1 && $attribute_name == "ExternalPartyUrl"&& $this->ExternalPartyUrl == ""){
            $this->addError('ExternalPartyUrl','Please upload External Party Logo.');
        }
        if (empty($this->id)) {
          if ($this->IsUserSpecific == 1 && $attribute_name == "FileName" && $this->FileName == "") {
                $this->addError('emailserros', 'Please upload User specific .csv file.');
          }
        }
    } catch (Exception $ex) {
	Yii::log("AdvertisementForm:customRequired::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }    
}
    public function customRequiredR($attribute_name,$params){        
    try{    
        if($attribute_name == "Title" && $this->Title == ""){
            $title=$this->IsThisExternalParty==1?"External Party Context":"Title";
            $this->addError('Title',$title.' cannot be blank.'); 
        }
        if($attribute_name == "RequestedFields" && $this->RequestedFields == ""){

            $this->addError('RequestedFields','Please select Requested Field.');
        }
//        if(($this->BannerOptions=="OnlyImage" || $this->BannerOptions=="ImageWithText") && $attribute_name == "Languages" && $this->Languages == ""  && $this->SourceType!="StreamBundleAds"){
//            $this->addError('Languages','Please select atleast one language.');
//        }
        if($this->BannerOptions=="OnlyText" && $attribute_name == "BannerTitleForTextOnly"&& $this->BannerTitleForTextOnly == ""){
            $this->addError('BannerTitleForTextOnly','Please select banner title.');
        }
        if($this->BannerOptions=="OnlyText" && $attribute_name == "BannerContentForTextOnly"&& $this->BannerContentForTextOnly == ""){
            $this->addError('BannerContentForTextOnly','Please select banner content.');
        }
        if($this->IsThisExternalParty==1 && $attribute_name == "ExternalPartyName"&& $this->ExternalPartyName == ""){
            $this->addError('ExternalPartyName','External Party Name cannot be blank.');
        }
        if($this->IsThisExternalParty==1 && $attribute_name == "ExternalPartyUrl"&& $this->ExternalPartyUrl == ""){
            $this->addError('ExternalPartyUrl','Please upload External Party Logo.');
        }
        if (empty($this->id)) {
                if ($this->IsUserSpecific == 1 && $attribute_name == "FileName" && $this->FileName == "") {

                    $this->addError('emailserros', 'Please upload User specific .csv file.');
                }
        }
        } catch (Exception $ex) {
	Yii::log("AdvertisementForm:customRequiredR::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
    public function customRequiredMarketResearch($attribute_name,$params){        
    try{  
        if (empty($this->id)) {
             if($attribute_name == "Title" && $this->Title == ""){
            $title=$this->IsThisExternalParty==1?"External Party Context":"Title";
            $this->addError('Title',$title.' cannot be blank.'); 
        }
        if($attribute_name == "SurveyGroupName" && $this->SurveyGroupName == ""){

            $this->addError('SurveyGroupName','Please select Market Research Bundle.');
        }
        if($attribute_name == "SurveyName" && $this->SurveyName == ""){

            $this->addError('SurveyName','Please select Market Research Survey.');
        }
        if($attribute_name == "ScheduleId" && $this->ScheduleId == ""){

            $this->addError('ScheduleId','Please select Market Research Survey Schedule.');
        } 
        
        if($this->IsUserSpecific==1 && $attribute_name == "FileName" && $this->FileName == ""){

            $this->addError('emailserros','Please upload User specific .csv file.');
        }
         }
        if($this->IsThisExternalPartyhidden==1 && $attribute_name == "ExternalPartyName"&& $this->ExternalPartyName == ""){
            $this->addError('ExternalPartyName','External Party Name cannot be blank.');
        }
         if($attribute_name == "Languages" && $this->Languages == ""){
            $this->addError('Languages','Please select atleast one language.');
        }
       
       
    } catch (Exception $ex) {
	Yii::log("AdvertisementForm:customRequiredR::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
public function customRequiredForUrl($attribute_name,$params){       
    try{
    if($attribute_name == "OutsideUrl" && $this->OutsideUrl == "")
            $this->addError('OutsideUrl','Outside Url cannot be blank.');
    } catch (Exception $ex) {
	Yii::log("AdvertisementForm:customRequiredForUrl::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
public function customRequiredForUpload($attribute_name,$params){ 
    try{
    if($attribute_name == "Languages" && $this->Languages == ""){
            $this->addError('Languages','Please select atleast one language.');
        }
    } catch (Exception $ex) {
	Yii::log("AdvertisementForm:customRequiredForUpload::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
//        if($attribute_name == "Url" && $this->Url == "" && $this->AdTypeId==1)
//            $this->addError('Url','Please upload ad image.');
    }
public function customRequiredForStreamBundilAd($attribute_name,$params){   
    try{
    if($attribute_name == "StreamBundleAds" && $this->StreamBundleAds == ""){
            $this->addError('StreamBundleAds','StreamBundleAds cannot be blank.');
        }
        } catch (Exception $ex) {
	Yii::log("AdvertisementForm:customRequiredForStreamBundilAd::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
public function customRequiredForAdserverAd($attribute_name,$params){   
    try{
    if($attribute_name == "ImpressionTags" && $this->ImpressionTags == "")
            $this->addError('ImpressionTags','ImpressionTags cannot be blank.');
        if($attribute_name == "ClickTag" && $this->ClickTag == "")
            $this->addError('ClickTag','ClickTag cannot be blank.');
        
        if($this->BannerOptions=="OnlyImage" && $attribute_name == "Languages" && $this->Languages == ""){
            $this->addError('Languages','Please select atleast one language.');
        }
        } catch (Exception $ex) {
	Yii::log("AdvertisementForm:customRequiredForAdserverAd::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }

 public function customRequiredForWidget($attribute_name,$params){ 
    try{
     if($attribute_name == "IsPremiumAd" && $this->IsPremiumAd==1 && $this->PTimeInterval==""){
            $this->addError('PTimeInterval','Please select TimeInterval.');
        }
       
    } catch (Exception $ex) {
	Yii::log("AdvertisementForm:customRequiredForWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }    
         
    }

     public function customsRequiredForWidget($attribute_name,$params){ 
    try{
     if($attribute_name == "IsThisAdRotate" && $this->IsThisAdRotate==1 && $this->TimeInterval==""){
            $this->addError('TimeInterval','Please select TimeInterval.');
        }
        if($attribute_name == "DisplayPosition" && $this->DisplayPosition == ""){
            $this->addError('DisplayPosition','Please select DisplayPosition.');
        }
    } catch (Exception $ex) {
	Yii::log("AdvertisementForm:customRequiredForWidget::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }    
         
    }
}
