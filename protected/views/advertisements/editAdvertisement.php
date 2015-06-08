
<div class="row-fluid editAdvertisement" >
        <div class="span12">            
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'advertisement-form',
        'enableClientValidation' => true,
      //  'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),

        'htmlOptions' => array(
            'style' => 'margin: 0px; accept-charset=UTF-8',
        ),
    ));
    $isNew = count($advertisements)<=0?true:false;
    
    if($isNew){
        $IsUserSpecific=1;
    }
    else{
       $IsUserSpecific=$advertisements['IsUserSpecific']; 
       $isMRearch=$advertisements['IsMarketRearchAd']=='1'?true:false;
       
    }
    
    ?>   
            
            <div id="advertisementSpinner"></div>
                
                        
                
            <div class="row-fluid  " id="" >
                <div class="span4">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Advertisement Type')); ?>
                    <div class="chat_profileareasearch" >
                        <?php $adTypeArray = array(
                            'class' => "",
                            'empty' => "Please select adtype",
                             'onchange'=>'loadAdType()',
                            'id'=>'AdTypeId'
                        );
                        if(!$isNew){
                            $adTypeArray['disabled']='true';
                            echo $form->hiddenField($advertisementForm,"AdTypeId");
                        }
                        echo $form->dropDownlist($advertisementForm, 'AdTypeId',$adTypes , $adTypeArray);
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'AdTypeId'); ?>
                    </div>
                </div>
                <div class="span4">

                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'AdName') ,array('class' => ' ')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($advertisementForm, 'Name', array('maxlength' => 50, 'class' => 'span12 textfield')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'Name'); ?>
                    </div>
                </div>
                <div class="span4" id="adTitle" style="<?php echo $advertisements["AdTypeId"]!="1"?'display:block':'display:none'?>">

                    <?php
                    $titleLabel=$advertisements['IsThisExternalParty']!='1'?'Title':'externalPartyTitle';
                    echo $form->labelEx($advertisementForm, Yii::t('translation', $titleLabel),array('id'=>'inlineTitle')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($advertisementForm, 'Title', array('maxlength' => 50, 'class' => 'span12 textfield')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'Title'); ?>
                    </div>
                </div>
             </div>
              <div class="row-fluid  " id="marketMainDiv" style="<?php echo $isMRearch==true?'display:block':'display:none'?>" >
                <div class="span4">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'MarketResearchBundle')); ?>
                    <div class="chat_profileareasearch" >
                        <?php $SurveyGroupArray = array(
                            'class' => "",
                            'empty' => "Please select",
                             'onchange'=>'loadGroupSurveys(this)',
                            'id'=>'SurveyGroupName',
                            'disabled'=>$isMRearch,
                        );
                       
                        echo $form->dropDownlist($advertisementForm, 'SurveyGroupName',$SurveyGroupNames , $SurveyGroupArray);
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'SurveyGroupName'); ?>
                    </div>
                </div>
                  <div class="span4">
                     <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'SurveyDetails')); ?> 
                  <div id="dynamicSurveys" >
                     <?php
                         $SurveyArray = array(
                            'class' => "",
                            'empty' => "Please select survey",
                             'onchange'=>'loadSurveySchedules(this)',
                            'disabled'=>$isMRearch,
                        );
                        echo $form->dropDownlist($advertisementForm,'SurveyName',$SurveyNames,$SurveyArray); ?>
  
                     </div>
                       <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'SurveyName'); ?>
                    </div>
                 </div>
                 <div class="span4">
                     <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'ScheduleDetails')); ?> 
                  <div id="dynamicScheduls" >
                     <?php
                         $SurveyArray = array(
                            'class' => "",
                            'empty' => "Please select schedule",
                             'onchange'=>'loadScheduleDetails(this)',
                            'disabled'=>$isMRearch,
                        );
                        echo $form->dropDownlist($advertisementForm,'ScheduleId',$Schedules,$SurveyArray); ?>
  
                     </div>
                       <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'ScheduleId'); ?>
                    </div>
                 </div>
             </div> 
              <div class="row-fluid " id="AdunitGroup" style="<?php echo ($advertisements['AdTypeId']==1)?'display:block':'display:none'?>">
              <div class="span4">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Display_Position'),array('class' => '')); ?>
                    <div class="chat_profileareasearch" >
                        <?php
                        echo $form->dropDownlist($advertisementForm, 'DisplayPosition', array('Top' => 'Top', 'Middle' => 'Middle', 'Bottom' => 'Bottom'), array(
                            'class' => "",
                            'empty' => "Please Select Position",
                        ));
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'DisplayPosition'); ?>
                    </div>
                </div>
                <div class="span4" id='AutoModeDiv'>
                    <label>Does this Ad rotate?</label>
                        <?php echo $form->checkBox($advertisementForm,'IsThisAdRotate',array('class' => 'styled','id'=>'isThisAdRotateCB'))?>
                        
                </div>
                <div class="span4" id="timeInterval" style="<?php echo $advertisements['IsAdRotate']=='1'?'display:block':'display:none'?>">
                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Time_Interval'),array('class' => '')); ?>
                    <div class="chat_profileareasearch" >
                        <?php
                        echo $form->dropDownlist($advertisementForm, 'TimeInterval', array(10 => '10 sec', 30 => '30 sec', 60 => '60 sec'), array(
                            'class' => "",
                            'empty' => "Please Select Time Interval",
                        ));
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'TimeInterval'); ?>
                    </div>
                </div>
                  
                
            </div>
            
            <div id="premiumAdDivs" style="display:none" class="row-fluid">
                <div class="span12">
                    <div class="span4"> 
                        
                        <div id='iPremiumAd' class="chat_profileareasearch" >
                            <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'IsPremiumAd')); ?>
                        <?php echo $form->checkBox($advertisementForm, 'IsPremiumAd', array('class' => 'styled','disabled'=>$isMRearch)) ?>
                        </div>
                    </div>
                    <?php echo $form->hiddenField($advertisementForm,"PremiumTypeId",array("value"=>1)); ?>
                    
                    <div class="span4" id="P_timeInterval" style="display: none;">
                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Time_Interval'),array('class' => '')); ?>
                        <div class="chat_profileareasearch" >
                            <?php
                            echo $form->dropDownlist($advertisementForm, 'PTimeInterval', array(10 => '10 sec', 30 => '30 sec', 60 => '60 sec'), array(
                                'class' => "",
                                'empty' => "Please Select Time Interval",
                            ));
                            ?>   
                        </div>
                        <div class="control-group controlerror">
                            <?php echo $form->error($advertisementForm, 'PTimeInterval'); ?>
                        </div>
                </div>
                    
                </div>
            </div>
            
            
            
            <div class="row-fluid  " id='isThisExternalParty' style="<?php echo $advertisements["AdTypeId"]!="1"?'display:block':'display:none'?>">
                <div class="span4" id='ExternalPartyDiv' style="position: relative;<?php echo $isMRearch==true && $advertisements["IsThisExternalParty"]!="1"?"display:none":"display:block"?>;">
                    
                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Isthisonbehalfofanexternalparty')); ?>
                    <div id='ExternalPartyDivCB' class="chat_profileareasearch" >
                    <?php echo $form->checkBox($advertisementForm, 'IsThisExternalParty', array('class' => 'styled', 'id' => 'isThisExternalPartyCB','disabled'=>$isMRearch)) ?>
                    </div>
                </div>
                 <div class="span4" id="externalPartyName" style="<?php echo $advertisements["IsThisExternalParty"]=="1"?'display:block':'display:none'?>">

                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'externalPartyName')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($advertisementForm, 'ExternalPartyName', array('maxlength' => 50, 'class' => 'span12 textfield')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'ExternalPartyName'); ?>
                    </div>
                </div>
                <div class="span4 positionrelative" id="externalPartyLogo" style="<?php echo $advertisements["IsThisExternalParty"]=="1"?'display:block':'display:none'?>">
                    <i id="StreamAdDimension"  class="fa fa-question helpmanagement helpicon top10  tooltiplink" style="font-weight: normal;z-index: 5;top: 13px;" data-id="ExternalLogoDimension_DivId" data-placement="bottom" rel="tooltip"  data-original-title="Logo Dimentions" ></i>
                           <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'externalPartyLogo')); ?>
                          <div class="row-fluid">
                               <div class="span4">
                               <div id="ExternalPartyLogo" class="uploadicon"><img src="/images/system/spacer.png">
                            </div>
                          </div>
                               <div class="span5">
                              <img id="ExternalPartyLogoPreview" name="AdvertisementForm[ExternalPartyUrl]"  src="<?php echo $advertisements['ExternalPartyUrl']?>" alt="" style="border:0;height:30px" />
                          </div>
                          </div>
                     <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'ExternalPartyUrl'); ?>
                </div>
                    
                
                    
                 </div>

            </div>
            
            <div class="row-fluid" id='userSpecificDiv2' style="<?php echo ($advertisements["AdTypeId"]!=''&& $advertisements["AdTypeId"]!="1")?'display:block':'display:none'?>">
                <div class="span4" id="IsUserSpecificDiv1" style="<?php echo ($advertisements['IsUserSpecific']=="1")?'display:block':'display:none'?>">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'IsUserSpecific')); ?>
                    <div id="IsUserSpecificCbDiv" class="chat_profileareasearch" >
                        <?php
                        
                        echo $form->checkBox($advertisementForm, 'IsUserSpecific', array('class' => 'styled', 'id' => 'IsUserSpecificCB',"disabled"=>(!$isNew))) ?>  
                    </div>
                    <div class="control-group controlerror">
                    <?php echo $form->error($advertisementForm, 'IsUserSpecific'); ?>
                    </div>
                </div>
                
                <div id="IsUserSpecificDiv2" class="span4" style="<?php echo ($advertisements['IsUserSpecific']=="1")?'display:block':'display:none'?>">
                   <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'UserSpecificcsv')); ?>
                    <div class="row-fluid" id="9">
                    <div class="span12">
                        <div class="span8">
                            <ul><li class="dropdown pull-left"  style="list-style: none">
                    <div id='uploadFile_csv' data-placement="bottom" rel="tooltip"  data-original-title="Upload"></div>
                    </li>
                        </ul>
                        </div>
                        <div class="span4 positionrelative">
                            <i class="fa fa-question helpmanagement  helpicon top10  tooltiplink" style="font-weight: normal" data-id="GroupRestrictedUploadFileType_DivId" data-placement="bottom" rel="tooltip"  data-original-title="upload .csv file type" ></i>
                        </div>
                        
                    </div>
                    <div ><ul class="qq-upload-list" id="uploadlist_files"></ul></div>
                    
                </div>
                    <div  id="uploadedfileslist" style=";display:none;"></div>
                 <div class="alert alert-error" id="AdvertisementForm_emailserros_em_" style="display:none"></div>
                </div>
                <div id="ClassificationDiv" class="span4" style="<?php echo ($advertisements['IsUserSpecific']!="1")?'display:block;margin:auto':'display:none'?>">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Classification')); ?>
                    <div class="chat_profileareasearch" >
                        <?php 
                              
                        echo $form->dropDownlist($advertisementForm, 'Classification', $UserClassifications, array());
                        ?>   
                    </div>
                    <div class="control-group controlerror">
                    <?php echo $form->error($advertisementForm, 'Classification'); ?>
                    </div>
                </div>
 
            </div>

            <div class="row-fluid" id='userSpecificDiv1' style="<?php echo ($advertisements["AdTypeId"]!='' && $advertisements["AdTypeId"]!="1" && $advertisements['IsUserSpecific']!="1")?'display:block':'display:none'?>">
                <div class="span4">

                        <?php echo  $form->labelEx($advertisementForm, Yii::t('translation', 'SubSpeciality')); ?>
                    <div class="chat_profileareasearch" >
                        <?php 
                              
                        echo $form->dropDownlist($advertisementForm, 'SubSpeciality', $subSpecialitys, array());
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'SubSpeciality'); ?>
                    </div>
                </div>
                
                 <div class="span4">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'User_Register_Country')); ?>
                      <?php   echo $form->dropDownList($advertisementForm, 'Country',CHtml::listData(Countries::model()->findAll(),'Id','Name'), array(
                        'empty'=>"Please Select country",
                            'onchange'=>'getStates(this)'));
                      ?>
                    <div class="control-group controlerror">
                    <?php echo $form->error($advertisementForm, 'Country'); ?>
                    </div>
                </div>  
                
                <div class="span4 divrelative"  id="registartion_state" style="<?php echo $advertisements["State"]!=""?'display:block':'display:none'?>">
                     <label><?php echo Yii::t('translation','User_Register_State'); ?></label>
                     <div id="dynamicstates" style="<?php echo $advertisements["Country"]=="1"?'display:block':'display:none'?>">
                     <?php 
                        echo $form->dropDownlist($advertisementForm, 'State',CHtml::listData(State::model()->findAllByAttributes(array("CountryId"=>$advertisementForm->Country)),'State','State'),array('selected'=>$stateId),array(
                        'empty'=>"Please Select state",
                            )); ?>
  
                     </div>
                     <div id="dynamicstatetextbox" style="<?php echo $advertisements["Country"]!="1"?'display:block':'display:none'?>">
                       <?php if($advertisements["Country"]!=""&& $advertisements["Country"]!=1){
                         echo $form->textField($advertisementForm, 'State', array('id' => 'AdvertisementForm_State',
                    'class' => 'span12 textfield','placeholder' => Yii::t('translation', 'User_Register_State'),'maxlength' => 30));
                       }?>
                     </div>
                        <div class="control-group controlerror marginbottom10">
                            <?php echo $form->error($advertisementForm,'State'); ?>
                     </div>

                </div>

              
            </div>
             <div class="row-fluid  ">
                <div class="span4">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Display_Page')); ?>
                    <div class="chat_profileareasearch" >
                        <?php $displaypage=array('Home' => 'Home', 'Curbside' => 'Curbside', 'Group' => 'Group', 'Group' => 'Group','News' => 'News','Games' => 'Games','Careers' => 'Careers');
                              
                        echo $form->dropDownlist($advertisementForm, 'DisplayPage', $displaypage, array(
                            'class' => "",
                            'empty' => "Please Select Page",
                            'onchange'=>'checkToLoadGroups()',
                            'id'=>'DisplayPage',
                            'disabled'=>$isMRearch,
                        ));
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'DisplayPage'); ?>
                    </div>
                </div>
                
                <div class="span4">
                    <div id="dpd2Edit" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                        <label><?php echo Yii::t('translation', 'Start_Date'); ?></label>
<?php echo $form->textField($advertisementForm, 'StartDate', array('maxlength' => '20', 'class' => 'textfield span8 ', 'readonly' => "true")); ?>    
                        <span id="startdates" class="add-on" style="<?php echo $isMRearch==true?'display:none':''?>">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <div class="control-group controlerror"> 
<?php echo $form->error($advertisementForm, 'StartDate'); ?>
                        </div>

                    </div>

                </div>  
                
                <div class="span4">
                    <div id="dpd1Edit" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                        <label><?php echo Yii::t('translation', 'Expiry_Date'); ?></label>
<?php echo $form->textField($advertisementForm, 'ExpiryDate', array('maxlength' => '20', 'class' => 'textfield span8 ', 'readonly' => "true")); ?>    
                        <span class="add-on" style="<?php echo $isMRearch==true?'display:none':''?>">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <div class="control-group controlerror"> 
<?php echo $form->error($advertisementForm, 'ExpiryDate'); ?>
                        </div>

                    </div>

                </div>
                  
               
              
            </div>
                <div class="row-fluid customrowfluidad " >
                
                <div class="span12" id="GroupsList" style="<?php echo $advertisements["DisplayPage"]=="Group"?'display:block':'display:none'?>">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Groups')); ?>
                    <div class="chat_profileareasearch" >
                        <?php
                        echo $form->dropDownlist($advertisementForm, 'GroupId',$groupNames , array(
                            'class' => "span12",
                            'multiple' => 'multiple'
                        ));
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'GroupId'); ?>
                    </div>
                </div>
                </div>
                
            <div class="row-fluid  padding-bottom10">
                
            
                <div id="redirectUrl" class="span4" style="<?php echo $advertisements["SourceType"]=="StreamBundleAds"||$isMRearch==true?'display:none':'display:block'?>">

                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Redirect_Url'),array('class' => '')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($advertisementForm, 'RedirectUrl', array('maxlength' => 150, 'class' => 'span12 textfield')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'RedirectUrl'); ?>
                    </div>
                </div>

                <div class="span4" id="StatusSpan" style="<?php echo $advertisements["SourceType"]=="StreamBundleAds"||$isMRearch==true?'margin:auto':''?>">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Status')); ?>
                    <div class="chat_profileareasearch" >
                        <?php
                        echo $form->dropDownlist($advertisementForm, 'Status', array('1' => 'Active', '0' => 'InActive'), array(
                            'class' => "",                                                        
                            'id'=>'Status'
                        ));
                        ?>   
                    </div>                    
                </div>
                <div class="span4" id="sourceFowWidgetAd" style="<?php echo $isNew?'display:none':'display:block' ?>">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'SourceType')); ?>
                    <div class="chat_profileareasearch" >
                        <?php
                        $sourceArray=array('Upload' => 'Upload','AddServerAds' => 'Ad Server','StreamBundleAds'=>'Stream Bundle Ads');
                        
                        echo $form->dropDownlist($advertisementForm, 'SourceType',$sourceArray , array(
                            'class' => "",
                            'onchange'=>'loadOutSideUrlBox()',
                            'id'=>'SourceType',
                            'disabled'=>$isMRearch,
                        ));
                        ?>   
                    </div>
                     
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'SourceType'); ?>
                    </div>
                </div>      
            </div>
            
          
                <?php if($advertisements["DisplayPage"]=="Group"){
                   $style="display:block" ;
                }else{
                   $style="display:none" ; 
                }?>
                
                    <div class="row-fluid  " > 
               
                <div class="span6 positionrelative" id="requestedFields" style="<?php echo $advertisements["AdTypeId"]=="3"?'display:block':'display:none'?>">

                <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Requested Fields')); ?>
                    <div class="chat_profileareasearch" >
                        
                        <?php
                        echo $form->dropDownlist($advertisementForm, 'RequestedFields',$adRequestedFields , array(
                            'class' => "",
                            'id'=>'RequestedFields',
                            'multiple' => 'multiple',
                            'onclick'=>'displayRequestedFields()'
                        ));
                        ?>   
                    </div>
                    <span class="authortext" ><i data-original-title="Select custom requested query param names." rel="tooltip" data-placement="bottom" data-id="id" style="font-weight: normal;top:5px" class="fa fa-question helpmanagement helpicon top10 tooltiplink" ></i> </span>  
                    <div class="control-group controlerror">
                    <?php echo $form->error($advertisementForm, 'RequestedFields'); ?>
                    </div>
                </div>
            
                       
                 <div class="span6" id="requestedParams" style="<?php echo $advertisements["AdTypeId"]=="3"?'display:block':'display:none'?>" >
                         <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Alias Names For Requested Fields')); ?>
                        <div class="chat_profileareasearch padding-bottom5" style="<?php echo $advertisements["Requestedparam1"]==null?'display:none':'display:block'?>" id='requestedp1'>
                        <div class="row-fluid"  >
                            <div class="span4">
                                <label style="display: inline-block;padding-right:5px;" class="pull-right">UserId</label>
                            </div>
                            <div class="span8"><?php echo $form->textField($advertisementForm, 'Requestedparam1', array('maxlength' => 20, 'class' => 'span12 textfield')); ?> </div>
                        </div>
                       
                        
                        </div>
                        <div class="chat_profileareasearch padding-bottom5" style="<?php echo $advertisements["Requestedparam2"]==null?'display:none':'display:block'?>" id='requestedp2'>
                            <div class="row-fluid"  >
                            <div class="span4">
                                <label style="display: inline-block;text-align: right;">Display Name</label>
                            </div>
                            <div class="span8"><?php echo $form->textField($advertisementForm, 'Requestedparam2', array('maxlength' => 20, 'class' => 'span12 textfield')); ?> </div>
                        </div>
                            
                            
                            
                            
                        </div>
                         
                     </div>
             </div>
                <div class="row-fluid"  >
                    
                    <div class="span15  positionrelative" id="streamBundleAds" style="<?php echo $advertisements["SourceType"]=="StreamBundleAds"?'display:block':'display:none'?>">

                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'StreamBundleAds')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textArea($advertisementForm, 'StreamBundleAds', array( 'class' => 'span15, stream_bundle_textarea')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'StreamBundleAds'); ?>
                    </div>
                   <i id="StreamAdDimension1"  class="fa fa-question helpmanagement helpicon top10  tooltiplink" style="font-weight: normal;z-index: 5" data-id="HintsforRandamNumbergenration_DivId" data-placement="bottom" rel="tooltip"  data-original-title="Hints for RandomNumber Generation" ></i>
                </div>          
                    </div>
                <div class="row-fluid customrowfluidad  " id="addServerAds1"  style="<?php echo $advertisements["SourceType"]=="AddServerAds"?'display:block':'display:none'?>" >
                    <div class="span12 positionrelative" >

                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Impression Tags')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textArea($advertisementForm, 'ImpressionTags', array('maxlength' => 1000, 'class' => 'span12 textarea')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'ImpressionTags'); ?>
                    </div>
                     <i id="StreamAdDimension2"  class="fa fa-question helpmanagement helpicon top10  tooltiplink" style="font-weight: normal;z-index: 5" data-id="HintsforRandamNumbergenration_DivId" data-placement="bottom" rel="tooltip"  data-original-title="Hints for RandomNumber Generation" ></i>
                    </div>
               
              
                 </div> 
                 <div class="row-fluid customrowfluidad  " id="addServerAds2"  style="<?php echo $advertisements["SourceType"]=="AddServerAds"?'display:block':'display:none'?>" >

                    <div class="span12">

                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Click Tag')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($advertisementForm, 'ClickTag', array('maxlength' => 1000, 'class' => 'span12 textfield')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'ClickTag'); ?>
                    </div>
                    </div>
               
              
                 </div>
                <?php $displayBannerOptions = $advertisements["AdTypeId"]!="1"?($advertisements["SourceType"]!='StreamBundleAds'?'display:block':'display:none'):'display:none'; ?>
                              <div class="row-fluid" id="bannerTemplateDiv1" style="<?php echo $isNew?'display:none':$displayBannerOptions ?>" >
                    <div class="span6 positionrelative">


                     
                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Banner Options')); ?>
                        <div class="chat_profileareasearch" >
                        <?php
                        echo $form->dropDownlist($advertisementForm, 'BannerOptions', array('OnlyImage' => 'Only Image','OnlyText' => 'Only Text','ImageWithText' => 'Image with Text'), array(
                            'class' => "",
                            'onchange'=>'loadbannerTemplates()',
                            'id'=>'bannerOptions',
                            'disabled'=>$isMRearch,
                        ));
                        ?> 
                    </div>
                     <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'BannerOptions'); ?>
                    </div>
                  

                    </div>
                </div>
                <?php 
           
                    $displayLanguages = "none";
           
                    if(!$isNew &&  Yii::app()->params['IsMultipleSegment']==1){
                        if($advertisements["AdTypeId"]==1 && $advertisements["SourceType"]!="StreamBundleAds"){
                            $displayLanguages = "block";
                        }else if(($advertisements["AdTypeId"]==2 || $advertisements["AdTypeId"]==3) && $advertisements["BannerOptions"]!='OnlyText'){
                            $displayLanguages = "block";
                        }
                    }
                ?>
                <div class="row-fluid customrowfluidad" id="LanguageList" style="display:<?php echo $displayLanguages ?>">
                    <div class="span12">

                          <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Languages')); ?>
                      <div class="chat_profileareasearch"  style="margin:0px">
                          <?php
                          if($isNew){
                            echo $form->dropDownlist($advertisementForm, 'Languages',CHtml::listData($languages, 'Language', 'Name') , array(
                                'class' => "span12",
                                'multiple' => 'multiple',
                            ));
                          }else{
                            echo $form->dropDownlist($advertisementForm, 'Languages',CHtml::listData($languages, 'Language', 'Name') , array(
                                'class' => "span12",
                                'multiple' => 'multiple',
                                'options' => $dynamicContent['selectedArray']
                            ));
                          }
                          ?>  
                      </div>
                      <div class="control-group controlerror">
                          <?php echo $form->error($advertisementForm, 'Languages'); ?>
                      </div>
                  </div>
              </div>
                <div class="row-fluid" id="uplloadBannerPreview" style="<?php echo $advertisements["BannerOptions"]=="ImageWithText"?'display:block':'display:none'?>" >
                    <?php include "bannerPreview.php"; ?>
                </div>
                <div class="row-fluid" id="onlyTextTitle" style="<?php echo $advertisements["BannerOptions"]=="OnlyText"?'display:block':'display:none'?>" >
                    
                    <div class="span15 positionrelative"  >

                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Banner_Title')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textArea($advertisementForm, 'BannerTitleForTextOnly', array('maxlength' => 200, 'class' => 'span12 textfield')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'BannerTitleForTextOnly'); ?>
                    </div>
                        
                </div>
                    
                </div>
                <div class="row-fluid" id="onlyTextContent" style="<?php echo $advertisements["BannerOptions"]=="OnlyText"?'display:block':'display:none'?>">
                    
                    <div class="span15 positionrelative"  >

                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Banner_Content')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textArea($advertisementForm, 'BannerContentForTextOnly', array( 'class' => 'span15, stream_bundle_textarea')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'BannerContentForTextOnly'); ?>
                    </div>
                        
                </div>
                    
                </div>
            <div class="row-fluid " id="" style="display:none"  >
                    <div class="span6 positionrelative">

                        

                    
                    <?php 

                 
                     $pSrc=$advertisements['Url'];
                    if($advertisements['Type']=="swf"){
                        $pSrc="/images/system/swf.png";
                    }else if($advertisements['Type']=="mov" || $advertisements['Type']=="mp4"){
                        $pSrc="/images/system/video_img.png";
                    }

                    ?>
                        <div id="previewicon" style="display:none; padding-bottom:10px; <?php echo $advertisements["SourceType"]!="StreamBundleAds"?'display:block':'display:none'?>">
                            <div class="preview previewhalf" >
                                <img id="groupIconPreviewId" name="AdvertisementForm[Url]"   src="<?php echo $pSrc;?>"  alt="" style="height: 100px;width: 100px;" />
                            </div>
                        </div>
 <div >
                          <div id="GroupLogo" class="uploadicon" style="<?php echo $advertisements["SourceType"]!="StreamBundleAds"?'display:block':'display:none'?>"><img src="/images/system/spacer.png"></div>
                          <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'Url'); ?>
                    </div>
                        </div>
                 <i class="fa fa-question helpmanagement helpicon top10  tooltiplink" style="<?php echo $advertisements["SourceType"]!="StreamBundleAds"?'display:block':'display:none'?>;font-weight: normal;z-index: 5" data-id="StreamAdDimension_DivId" data-placement="bottom" rel="tooltip"  data-original-title="Ad Dimentions" ></i>       
                </div>
                
                 
            </div>
                <div class="row-fluid" id="uplloadAdPreview" >
                </div>
                <ul class="qq-upload-list" id="uploadlistSchedule"></ul>
                        
                <div class="preview previewhalf" id="previewiconNew">        
                    <ul id="previewiconUL">
                        
                        <?php if(isset($dynamicContent['previewLi'])){echo $dynamicContent['previewLi'];} ?>
                    </ul>
                </div>         
                  
                  
                
                <?php if(isset($dynamicContent['uploadul'])){echo $dynamicContent['uploadul'];} ?>
 <div class="alert alert-error" id="GroupLogoError" style="display: none"></div>
 <?php echo $form->hiddenField($advertisementForm, 'Url',array('class'=>'')); ?> 
  <?php echo $form->hiddenField($advertisementForm, 'ExternalPartyUrl',array('class'=>'')); ?>
 <?php echo $form->hiddenField($advertisementForm, 'Type',array('class'=>'')); ?>
 <?php echo $form->hiddenField($advertisementForm, 'id',array('class'=>'')); ?>
  <?php echo $form->hiddenField($advertisementForm, 'DoesthisAdrotateHidden',array('class'=>'','id'=>"DoesthisAdrotateHidden")); ?>
 <?php echo $form->hiddenField($advertisementForm, 'BannerTitle',array('class'=>'','id'=>"BannerTitleHidden")); ?>
 <?php echo $form->hiddenField($advertisementForm, 'BannerContent',array('class'=>'','id'=>"BannerContentHidden")); ?>
 <?php echo $form->hiddenField($advertisementForm, 'Banners',array('class'=>'','id'=>"Banners")); ?>
 <?php echo $form->hiddenField($advertisementForm, 'Uploads',array('class'=>'','id'=>"Uploads")); ?>
  <?php echo $form->hiddenField($advertisementForm, 'FileName'); ?>    
 <?php echo $form->hiddenField($advertisementForm, 'IsUserSpecific'); ?>
 <?php echo $form->hiddenField($advertisementForm, 'IsThisExternalPartyhidden'); ?>
 <?php echo $form->hiddenField($advertisementForm, 'SurveyIdHidden'); ?>
 
            <div class="alert alert-error" id="errmsgForAd" style='display: none'></div>
            <div class="alert alert-success" id="sucmsgForAd" style='display: none'></div> 
            <div class="groupcreationbuttonstyle alignright">
                <?php echo CHtml::Button($isNew ? 'Create' : 'Update',array('class' => 'btn', 'id' => 'newGroupId','onclick'=>'saveAd();')); ?>
            <?php echo CHtml::resetButton('Cancel', array("id" => 'NewAdReset', 'class' => 'btn btn_gray', 'onclick' => 'closeEditAdvertisement()')); ?>

            </div>
<?php $this->endWidget(); ?>
        </div>
    </div>

<script type="text/javascript">
    //loadEvents();
     var extensions ='"jpg","jpeg","gif","png","tiff","swf","tif","TIF"';
    initializeFileUploader('ExternalPartyLogo', '/advertisements/UploadAdvertisementImage', '10*1024*1024', extensions,1, 'ExternalPartyLogo' ,'',ExternalPartyDLPreviewImage,displayErrorForBannerAndLogo,"uploadlistSchedule");
    initializeFileUploader('uploadFile_csv', '/group/FileUpload', '10*1024*1024', '"csv"',4, 'AdvertisementForm' ,'',PreviewUploadedFile,displayErrorForFile,"uploadlist_files");
     <?php if(isset($dynamicContent['fileInitializer'])){echo $dynamicContent['fileInitializer'];} ?>
    Custom.init();
    //$isNew
   <?php 
        $isDisable=!$isNew?true:false;
       if($isDisable){?>
           loadEvents();
       <?php }else{ ?>
          loadEvents1(); 
       <?php } ?>
    <?php if(!$isNew){?>
            $('#AdvertisementForm_Languages :selected').each(function(){
                var lang = $(this).val();
                if($("#language_upload_"+lang+" div.language_img span.span_language").length>0){
                    var language = $("#AdvertisementForm_Languages option[value='"+lang+"']").text();
                    $("#language_upload_"+lang+" div.language_img span.span_language").text(language);
                }
            });
    <?php } ?>
     $('#AdBannerTitle').bind('blur',function(){
        var bTitle = $(this).clone().removeAttr("contentEditable"); 
                     $('#AdvertisementForm_BannerTitle').val(bTitle.wrap('<p>').parent().html());

    });
    $('#AdBannerContent').bind('blur',function(){
        var bcontent=$('#AdBannerContent').clone().removeAttr("contentEditable"); 
                $('#BannerContentHidden').val(bcontent.wrap('<p>').parent().html()); 
    });
    var SourceType="<?php echo $sourceType ?>"; 
    var selectedBanner="<?php echo (isset($advertisements["BannerTemplate"])) ? $advertisements['BannerTemplate']:null ?>"; 
//    if(SourceType!='Upload'){
//        $('#OutSideUrlDiv').show();
//        $('#GroupLogo').hide();
//    }else{       
//        $('#GroupLogo').show();
//         $('#OutSideUrlDiv').hide();
//    }
   $("[rel=tooltip]").tooltip();
   function loadEvents() {
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd1Edit').datepicker({
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {

            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 0);
            // checkout.setValue(newDate);

            checkin.hide();
            //$('#dpd2')[0].focus();
        }).data('datepicker');


        }
function loadEvents1() {
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd2Edit').datepicker({
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {

            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 0);
             checkout.setValue(newDate);

            checkin.hide();
            $('#dpd1')[0].focus();
        }).data('datepicker');


    var checkout = $('#dpd1Edit').datepicker({
        onRender: function(date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');

    }
        
     $('.datepicker').css({'z-index':'9999'});         
     $('#timepicker-popup').css({'z-index':'1060'});
     
     $('#AutoModeDiv span.checkbox').bind("click",
     function(){
         $('#timeInterval').hide();
         if($('#isThisAdRotateCB').is(':checked')){
             $('#timeInterval').show();
         }
     }
    
     );
   $('#ExternalPartyDivCB span.checkbox').bind("click",
     function(){
         $('#externalPartyName').hide();
         $('#externalPartyLogo').hide();
         $('#inlineTitle').html("Title");
         
         if($('#isThisExternalPartyCB').is(':checked')){
            $('#externalPartyName').show();
            $('#externalPartyLogo').show();
            $('#inlineTitle').html("External Party Context");
         }
     }
    
     );
    $('#IsUserSpecificCbDiv span.checkbox').bind("click",
     function(){
         $('#IsUserSpecificDiv2').hide();
         $('#userSpecificDiv1').hide();
         $('#ClassificationDiv').hide();
         
         
         if($('#IsUserSpecificCB').is(':checked')){
             $('#AdvertisementForm_IsUserSpecific').val(1);
            $('#IsUserSpecificDiv2').show();
            
         }
         else{
             $('#AdvertisementForm_IsUserSpecific').val(0);
             $('#userSpecificDiv1').show();
             $('#ClassificationDiv').show();
         }
     }
    
     );

 $('#AdBannerTitle').bind("cut copy paste", function(e) {
            var $this = $(this); //save reference to element for use laster
            setTimeout(function() { //break the callstack to let the event finish
               $this.html($this.text());
        }, 10); 
       });
       $(document).ready(function(){
          $("#addNewAd").on("click touchstart", function(event){
              event.stopPropagation();
          });           
          <?php if($advertisementForm->IsPremiumAd == 1 || $advertisementForm->AdTypeId == 2){ ?>
              <?php if($advertisementForm->AdTypeId == 2 && $advertisementForm->IsPremiumAd == 0){ ?>
                  $("#premiumAdDivs").show();
              <?php }else{ ?>
                  $("#premiumAdDivs,#P_timeInterval").show();
              <?php } ?>
               $("#AdvertisementForm_PTimeInterval").val("<?php echo $advertisementForm->PTimeInterval; ?>");
          <?php }else if($advertisementForm->AdTypeId != 2){?>
              $("#premiumAdDivs").hide();
              $("#AdvertisementForm_PTimeInterval").val("");
          <?php } ?>
       });
       $("#AdvertisementForm_Languages").click(function(){
        $('#AdvertisementForm_Languages :selected').each(function(){
            var isBannerOptionVisible = $('#bannerTemplateDiv1').css('display') == 'none'?0:1;    
            var bannerOption = $('#bannerOptions').val();
            var lang = $(this).val();
            if(isBannerOptionVisible && bannerOption == "ImageWithText"){
                if($('#imageWithTextDiv_'+lang).length==0){
                    loadBannerTemplate(lang);
                }
                
            }else{
                generateAttchment(lang);
            }
        });
        $('#AdvertisementForm_Languages option:not(:selected)').each(function(){
            var lang = $(this).val();
            if($('#GroupLogo_'+lang).length>0){
                $('#GroupLogo_'+lang).remove();
            }
            if($('#uploadlistSchedule_'+lang).length>0){
                $('#uploadlistSchedule_'+lang).remove();
            }
            if($('#language_upload_'+lang).length>0){
                $('#language_upload_'+lang).remove();
            }
            if($('#previewLi_GroupLogo_'+lang).length>0){
                $('#previewLi_GroupLogo_'+lang).remove();
            }
            if($('#imageWithTextDiv_'+lang).length>0){
                $('#imageWithTextDiv_'+lang).remove();
            }
        });
    });
 function getStates(obj){
     if(obj.value!=''){
        $("#registartion_state").show();
        var queryString = 'country='+obj.value;  
        ajaxRequest("/user/GetStatesByCountry",queryString,getStatesHandler);
     
     }else{
       $("#AdvertisementForm_State").empty();
       $("#dynamicstatetextbox").html();
       $("#registartion_state").hide();
     }

    }
    function getStatesHandler(data){
       data=data.data.toString();
       if (data.indexOf("<option") !=-1){
            $("#dynamicstates").show();
            $("#dynamicstatetextbox").hide();
             $("#dynamicstatetextbox").html("");
                $("#AdvertisementForm_State").empty();
                 $("#AdvertisementForm_State").find("span").text("Please Select state");
                       $("#AdvertisementForm_State").append(data);
                       $("#AdvertisementForm_State").trigger("liszt:updated");

        }else{
             $("#dynamicstates").hide();
            $("#dynamicstatetextbox").show();
            $("#dynamicstatetextbox").html();
            $("#dynamicstatetextbox").html(data);
        }
    }


$('#iPremiumAd span.checkbox').bind("click",
     function(){
         $('#P_timeInterval').hide();
//         $('#externalPartyName').hide();
//         $('#externalPartyLogo').hide();
         $('#inlineTitle').html("Title");
         
         if($('#AdvertisementForm_IsPremiumAd').is(':checked')){            
            $('#P_timeInterval').show();
            $('#inlineTitle').html("External Party Context");
         }
     }
    
     );
   </script> 