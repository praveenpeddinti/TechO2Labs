
<div  id="editAd"  class="row-fluid editAdvertisement" >
        <div class="span12">            
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'advertisement-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                //'action'=>Yii::app()->createUrl('//user/forgot'),
                'htmlOptions' => array(
                    'style' => 'margin: 0px; accept-charset=UTF-8',
                ),
            ));
            ?>
            <div id="advertisementSpinner"></div>
                <div class="alert alert-error" id="errmsgForAd" style='display: none'></div>
                <div class="alert alert-success" id="sucmsgForAd" style='display: none'></div> 
                        
                
            <div class="row-fluid  " id="" >
                <div class="span4">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Advertisement Type')); ?>
                    <div class="chat_profileareasearch" >
                        <?php
                        echo $form->dropDownlist($advertisementForm, 'AdTypeId',$adTypes , array(
                            'class' => "",
                            'empty' => "Please select adtype",
                             'onchange'=>'loadAdType()',
                            'id'=>'AdTypeId',
                            'disabled'=> 'true'
                        
                        ));
                        ?>   
                    </div>
                     <?php echo $form->hiddenField($advertisementForm,"AdTypeId");?>
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
                 
                <div class="row-fluid " id="TimeAndDisPos" style="<?php echo $advertisements["AdTypeId"]=="1"?'display:block':'display:none'?>">
              <div class="span4">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Display_Position'),array('class' => '')); ?>
                    <div class="chat_profileareasearch" >
                        <?php
                        echo $form->dropDownlist($advertisementForm, 'DisplayPosition', array('Top' => 'Top', 'Middle' => 'Middle', 'Bottom' => 'Bottom'), array(
                            'class' => "",
                            'empty' => Yii::t('translation','Please_Select_Time_Interval'),

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
                            'empty' => Yii::t('translation','Please_Select_Position'),
                        ));
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'TimeInterval'); ?>
                    </div>
                </div>
                  
                
            </div>
            <div class="row-fluid  " id='isThisExternalParty' style="<?php echo $advertisements["AdTypeId"]!="1"?'display:block':'display:none'?>">
                <div class="span4" id='ExternalPartyDiv'>
                    Is this on behalf of an external party?
                    <?php echo $form->checkBox($advertisementForm, 'IsThisExternalParty', array('class' => 'styled', 'id' => 'isThisExternalPartyCB')) ?>
                   
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
             <div class="row-fluid  ">
                <div class="span4">

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Display_Page')); ?>
                    <div class="chat_profileareasearch" >
                        <?php $displaypage=array('Home' => 'Home', 'Curbside' => 'Curbside', 'Group' => 'Group', 'Group' => 'Group','News' => 'News','Games' => 'Games','Careers' => 'Careers');
                              
                        echo $form->dropDownlist($advertisementForm, 'DisplayPage', $displaypage, array(
                            'class' => "",
                            'empty' => Yii::t('translation','Please_Select_Page'),
                            'onchange'=>'checkToLoadGroups()',
                            'id'=>'DisplayPage'
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
                        <span class="add-on">
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
                        <span class="add-on">
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
                            'multiple' => 'multiple',
                             'empty' => Yii::t('translation','Please_Select_Group'),

                        ));
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($advertisementForm, 'GroupId'); ?>
                    </div>
                </div>
                </div>
                
            <div class="row-fluid  padding-bottom10">
                
            
                <div id="redirectUrl" class="span4" style="<?php echo $advertisements["SourceType"]=="StreamBundleAds"?'display:none':'display:block'?>">

                    <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Redirect_Url'),array('class' => '')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($advertisementForm, 'RedirectUrl', array('maxlength' => 150, 'class' => 'span12 textfield')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'RedirectUrl'); ?>
                    </div>
                </div>
                
                <div class="span4" id="StatusSpan" >

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
                <div class="span4" id="sourceFowWidgetAd" >

                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'SourceType')); ?>
                    <div class="chat_profileareasearch" >
                        <?php
                        $sourceArray=array('Upload' => 'Upload','AddServerAds' => 'Ad Server','StreamBundleAds'=>'Stream Bundle Ads');
                        
                        echo $form->dropDownlist($advertisementForm, 'SourceType',$sourceArray , array(
                            'class' => "",
                            'onchange'=>'loadOutSideUrlBox()',
                            'id'=>'SourceType'
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
                        <div class="chat_profileareasearch padding-bottom5" style="<?php echo $advertisements["Requestedparam1"]!=null?'display:block':'display:none'?>" id='requestedp1'>
                        <div class="row-fluid"  >
                            <div class="span4">
                                <label style="display: inline-block;padding-right:5px;" class="pull-right">UserId</label>
                            </div>
                            <div class="span8"><?php echo $form->textField($advertisementForm, 'Requestedparam1', array('maxlength' => 20, 'class' => 'span12 textfield')); ?> </div>
                        </div>
                       
                        
                        </div>
                        <div class="chat_profileareasearch padding-bottom5" style="<?php echo $advertisements["Requestedparam2"]!=null?'display:block':'display:none'?>" id='requestedp2'>
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
                              <div class="row-fluid" id="bannerTemplateDiv1" style="<?php echo $advertisements["AdTypeId"]!="1"?($advertisements["SourceType"]!='StreamBundleAds'?'display:block':'display:none'):'display:none'?>" >
                    <div class="span6 positionrelative">


                     
                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Banner Options')); ?>
                        <div class="chat_profileareasearch" >
                        <?php
                        echo $form->dropDownlist($advertisementForm, 'BannerOptions', array('OnlyImage' => 'Only Image','OnlyText' => 'Only Text','ImageWithText' => 'Image with Text'), array(
                            'class' => "",
                            'onchange'=>'loadbannerTemplates()',
                            'id'=>'bannerOptions'
                        ));
                        ?> 
                    </div>
                     <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'BannerOptions'); ?>
                    </div>
                  

                    </div>
                </div>
                <div class="row-fluid" id="bannerTemplateDiv2" style="<?php echo $advertisements["BannerOptions"]=="ImageWithText"?'display:block':'display:none'?>" >
                    <div class="span12 positionrelative">
                     
                        <?php echo $form->labelEx($advertisementForm, Yii::t('translation', 'Banner Template')); ?>
                        <div id="uploadBanner" class="control-group controlerror marginbottom20 " >
                         <?php echo $form->radioButtonList($advertisementForm,'BannerTemplate',array('1'=>'<img src="/images/system/ad_banner_theme3.png" data-original-title="Banner template text align bottom." rel="tooltip" data-placement="bottom" >', '2'=>'<img src="/images/system/ad_banner_theme5.png" data-original-title="Banner template text align top." rel="tooltip" data-placement="bottom">','3'=>'<img src="/images/system/ad_banner_theme1.png" data-original-title="Banner template text align left." rel="tooltip" data-placement="bottom">', '4'=>'<img src="/images/system/ad_banner_theme2.png" data-original-title="Banner template text align right." rel="tooltip" data-placement="bottom">', '5'=>'<img src="/images/system/ad_banner_theme4.png" data-original-title="Banner template text align center." rel="tooltip" data-placement="bottom">'),
                              array('uncheckValue'=>null,'id'=>'bannerTemplate',
                              'separator'=>'&nbsp; &nbsp; &nbsp;','class'=>'styled'), array('uncheckValue'=>null), array("id"=>"AdvertisementForm_BannerTemplate")); ?>

                           
                          <div class="control-group controlerror">
                        <?php echo $form->error($advertisementForm, 'BannerTemplate'); ?>
                    </div>
                 </div>  

                    </div>
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
            <div class="row-fluid " id="uplloadAdPreview" style="<?php echo $advertisements["BannerOptions"]!="ImageWithText" && $advertisements["BannerOptions"]!="OnlyText"?($advertisements["SourceType"]!='StreamBundleAds'?'display:block':'display:none'):'display:none'?>"  >
                    <div class="span6 positionrelative">

                        

                    
                    <?php 

                 
                     $pSrc=$advertisements['Url'];
                    if($advertisements['Type']=="swf"){
                        $pSrc="/images/system/swf.png";
                    }else if($advertisements['Type']=="mov" || $advertisements['Type']=="mp4"){
                        $pSrc="/images/system/video_img.png";
                    }

                    ?>
                        <div id="previewicon" style="padding-bottom:10px; <?php echo ($advertisements["SourceType"]!="StreamBundleAds")?'display:block':'display:none'?>">
                            <div class="preview previewhalf" >
                                <img id="groupIconPreviewId" name="AdvertisementForm[Url]"   src="<?php echo $pSrc;?>"  alt="" style="height: 100px;width: 100px;" /></div></div>

                          <div id="GroupLogo" class="uploadicon" style="<?php echo ($advertisements["SourceType"]!="StreamBundleAds")?'display:block':'display:none'?>"><img src="/images/system/spacer.png"></div>
                          <div class="control-group controlerror">
                    </div>
                          
                        </div>
                <div class="preview previewhalf" id="previewicon">        
                    <ul id="previewiconUL">
                        <?php echo $dynamicContent['previewLi']; ?>
                    </ul>
                </div>         
                  
                  
                <div class="span4" id="uploadIcons"  >
                    <?php echo $dynamicContent['uploadDivs']; ?>
                    <div class="control-group controlerror">
                        </div>
                 <i class="fa fa-question helpmanagement helpicon top10  tooltiplink" style="<?php echo ($advertisements["SourceType"]!="StreamBundleAds")?'display:block':'display:none'?>;font-weight: normal;z-index: 5" data-id="StreamAdDimension_DivId" data-placement="bottom" rel="tooltip"  data-original-title="Ad Dimentions" ></i>       
                </div>
                
                <?php echo $dynamicContent['uploadul']; ?>
                 
            </div>
  <div class="row-fluid" id="uplloadAdPreview" >
                 <?php include 'bannerPreview.php';?></div>
                        <ul class="qq-upload-list" id="uploadlistSchedule"></ul>
 <div class="alert alert-error" id="GroupLogoError" style="display: none"></div>
 <?php echo $form->hiddenField($advertisementForm, 'Url',array('class'=>'')); ?> 
  <?php echo $form->hiddenField($advertisementForm, 'ExternalPartyUrl',array('class'=>'')); ?>
 <?php echo $form->hiddenField($advertisementForm, 'Type',array('class'=>'')); ?>
 <?php echo $form->hiddenField($advertisementForm, 'id',array('class'=>'')); ?>
  <?php echo $form->hiddenField($advertisementForm, 'DoesthisAdrotateHidden',array('class'=>'','id'=>"DoesthisAdrotateHidden")); ?>
 <?php echo $form->hiddenField($advertisementForm, 'BannerTitle',array('class'=>'','id'=>"BannerTitleHidden")); ?>
 <?php echo $form->hiddenField($advertisementForm, 'BannerContent',array('class'=>'','id'=>"BannerContentHidden")); ?>
            <div class="groupcreationbuttonstyle alignright">

                <?php
                echo CHtml::ajaxSubmitButton('Update', array('/advertisements/newAdvertisement'), array(
                    'type' => 'POST',
                    'dataType' => 'json',
                    'error' => 'function(error){
                                        }',
                    'beforeSend' => 'function(){  alert("generateEditUrl")
                                scrollPleaseWait("advertisementSpinner","advertisement-form");
                                generateEditUrl();
                            }',
                    'complete' => 'function(){
                                                    }',
                    'success' => 'function(data,status,xhr) { advertisementHandler(data);}'), array('type' => 'submit', 'id' => 'newGroupId', 'class' => 'btn')
                );
                ?>
            <?php echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'NewAdReset', 'class' => 'btn btn_gray', 'onclick' => 'closeEditAdvertisement()')); ?>

            </div>
<?php $this->endWidget(); ?>
        </div>
    </div>

<script type="text/javascript">
     var extensions ='"jpg","jpeg","gif","png","tiff","swf","mp4","mov"';
    <?php echo $dynamicContent['fileInitializer']; ?>
    initializeFileUploader('ExternalPartyLogo', '/advertisements/UploadAdvertisementImage', '10*1024*1024', extensions,1, 'ExternalPartyLogo' ,'',ExternalPartyDLPreviewImage,displayErrorForBannerAndLogo,"uploadlistSchedule");
    initializeFileUploader('BannerImage', '/advertisements/UploadAdvertisementImage', '10*1024*1024', extensions,1, 'BannerImage' ,'',BannerDLPreviewImage,displayErrorForBannerAndLogo,"uploadlistSchedule");
    Custom.init();
   <?php $date = date('Y-m-d');
                        $sdate = new DateTime($advertisementForm->StartDate);
                        $sdate=$sdate->format('Y-m-d');
                        $isDisable=($sdate<=$date?true:false);
       if($isDisable){?>
           loadEvents();
       <?php }else{ ?>
          loadEvents1(); 
       <?php } ?>
     $('#AdBannerTitle').bind('blur',function(){  alert("===1");
        var bTitle = $(this).clone().removeAttr("contentEditable"); 
                     $('#AdvertisementForm_BannerTitle').val(bTitle.wrap('<p>').parent().html());

    });
    $('#AdBannerContent').bind('blur',function(){
        var bcontent=$('#AdBannerContent').clone().removeAttr("contentEditable"); 
                $('#BannerContentHidden').val(bcontent.wrap('<p>').parent().html()); 
    });
    var SourceType="<?php echo $sourceType ?>"; 
    var selectedBanner="<?php echo $advertisements['BannerTemplate'] ?>"; 
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
          $('#ExternalPartyDiv span.checkbox').bind("click",
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
      $('#titleBanner45').live('click', function() {
      $("#contentBanner45").removeClass('addbannerpadding_active');
      $("#titleBanner45").removeClass('addbannerpadding_active');
      $('.demo2').minicolors({
          hide: function() {}
});
          
  });
  $('#contentBanner45').live('click', function() {
      $("#titleBanner45").removeClass('addbannerpadding_active');
      $("#contentBanner45").removeClass('addbannerpadding_active');
      $('.demo1').minicolors({
          hide: function() {}
  });
});


$('.demo1').minicolors({
        change: function(hex, opacity) { 
                var log;
                try {
                        log = hex ? hex : 'transparent';
                        if( opacity ) log += ', ' + opacity;
                        $(".addbannaertitle").css("color",log); 
                } catch(e) {}
        },
       hide: function() {

            }
});

$('.demo2').minicolors({
        change: function(hex, opacity) { 
                var log;
                try {
                        log = hex ? hex : 'transparent';
                        if( opacity ) log += ', ' + opacity;
                        $(".addbannerdescription").css("color",log); 
                } catch(e) {}
        },
        hide: function() {

            }
});

 $('#AdBannerTitle').bind("cut copy paste", function(e) {
            var $this = $(this); //save reference to element for use laster
            setTimeout(function() { //break the callstack to let the event finish
               $this.html($this.text());
        }, 10); 
       });
       function generateEditUrl(){
        $('#editAd #AdvertisementForm_Url').val("");
        $('#editAd #previewiconUL li img').each(function() {
            var lang = $(this).attr('data-lang');
            var ext = $(this).attr('data-ext');
            var filepath = $('#editAd #Url_'+lang).val();
            var url = lang+'@@'+ext+'@@' + filepath;
            var adVal = $('#editAd #AdvertisementForm_Url').val();
            $('#editAd #AdvertisementForm_Url').val(adVal+','+url);
        });
    }
     $('#editAd #AdvertisementForm_Languages option').bind("click", function(){
        $('#editAd #AdvertisementForm_Languages option').each(function() {
            var lang = $(this).val();
            if ($(this).is(':selected')) { 
                if($('#editAd #SourceType').val()=="Upload"){
                    if($('#uploadlistSchedule_'+lang).length<=0){
                        var uploadul = '<ul class="qq-upload-list" id="uploadlistSchedule_'+lang+'"></ul>';
                        $(uploadul).insertBefore("#GroupLogoError");
                    }
                    if($('#previewLi_GroupLogo_'+lang).length<=0){
                        var previewLi = '<li class="alert" id="previewLi_GroupLogo_'+lang+'" style="display:none">'+
                        '<i data-dismiss="alert" class="fa fa-times-circle deleteiconhalf mobiledeleteicon " style="display:none"></i>'+
                        '<i class="fa fa-search-plus zoomiconhalf" onclick=\'showPreviewNew("'+lang+'")\'></i><a href="" class="postimgclose mobilepostimgclose "> </a>'+
                        '<img id="groupIconPreviewId_GroupLogo_'+lang+'" name="AdvertisementForm[Url]"  src="" alt="" style="border:0;" />'+
                        '<input type="hidden" value="" id="Url_'+lang+'" />'+
                        '</li>';
                        $('#previewiconUL').append($(previewLi));
                    }
                    if($('#GroupLogo_'+lang).length<=0){
                        var uploadDivs = '<div id="GroupLogo_'+lang+'" class="uploadicon"><img src="/images/system/spacer.png"></div>';
                        $(uploadDivs).insertBefore("#uploadIcons div:last");
                        initializeFileUploader('GroupLogo_'+lang, '/advertisements/UploadAdvertisementImage', '10*1024*1024', extensions,1, lang ,'',AdvertisementPreviewImage,displayErrorForBannerAndLogo,"uploadlistSchedule_"+lang);
                    }
                }
            }else{
                if($('#GroupLogo_'+lang).length>0){
                    $('#GroupLogo_'+lang).remove();
                }
                if($('#uploadlistSchedule_'+lang).length>0){
                    $('#uploadlistSchedule_'+lang).remove();
                }
                if($('#previewLi_GroupLogo_'+lang).length>0){
                    $('#previewLi_GroupLogo_'+lang).remove();
                }
            }
            generateEditUrl();
            generateUrl();
        });
   });
   </script> 