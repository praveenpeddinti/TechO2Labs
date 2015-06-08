<?php include 'snippetDetails.php'?>
<div class="group_admin_floatingMenu marginbottom10">
    <div class="row-fluid">
            <div class="span12">
            <div id="numero1" class="pull-left ">  <!-- This id numero1 is used for Joyride help --> 
                
                <?php if(Yii::app()->session['PostAsNetwork']==1){?>

       
                <div  class="grouplogoheading padding8top" ><a href="/<?php   echo $groupStatistics->GroupUniqueName?>"><?php   echo html_entity_decode($groupStatistics->GroupName)?></a><?php echo $groupStatistics->Status==0?'<label class="group_alert_info"> <i class="fa fa-info-circle"></i>'.Yii::t('translation', 'GroupInactive').'</label>':''?></div>

                <?php }else{?>

                <div  class="grouplogoheading padding8top" ><a href="/<?php   echo $groupStatistics->GroupUniqueName?>"><?php   echo html_entity_decode($groupStatistics->GroupName)?></a><?php echo $groupStatistics->Status==0?'<label class="group_alert_info"> <i class="fa fa-info-circle"></i>'.Yii::t('translation', 'GroupInactive').'</label>':''?></div>
                <?php }?>
            </div>
            <?php  $floatingMenuStyle='display:none';
            $displayPreferences='display:none';
            $displayAnaltics='display:none';
            if(count($groupStatistics->GroupMembers)>0){
            if($groupStatistics->IsGroupAdmin==1 && in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->GroupMembers)){
                        $floatingMenuStyle='display:block';
                        $displayPreferences='display:block';
                        $displayDiv='yes';
                    } 
            }
                if (Yii::app()->session['IsAdmin'] == 1 || Yii::app()->session['PostAsNetwork']==1) {
                
                    $displayAnaltics = 'display:block';
                    $displayPreferences = 'display:block';
                    if (in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->GroupMembers)) {
                        $floatingMenuStyle = 'display:block';
                    }
                }

                  if (Yii::app()->session['IsAdmin'] == 1 && $this->userPrivilegeObject->canViewAnalytics==1 || $groupStatistics->IsGroupAdmin==1) { 
                      $displayAnaltics='display:block';

                 if (in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->GroupMembers)) {
                        $floatingMenuStyle = 'display:block';
                    }
                }?>

                <?php //if($customGroup == 0){?>
                <div class="floatingMenu pull-right padding8top" id='GroupAdminMenu' style='<?php echo $floatingMenuStyle ?>'>
                    
                    <ul>
                        <li style="<?php echo $displayPreferences?>" class="radioalign active"> <a href="#" class="preferences" data-toggle="dropdown" ><img id="preferences" class=" tooltiplink cursor" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Preferences'); ?>" src="/images/system/spacer.png" /></a>
                             <div id="updatePreferences" class="dropdown dropdown-menu actionmorediv actionmoredivtop newgrouppopup newgrouppopupdivtop preferences_popup" >
                        <div id="groupfollowSpinLoader" style="position:relative;"></div>
			<div class="headerpoptitle_white"><?php echo "Preferences";?></div>
                        <div class="" id="streamSettingsMessage" style="display: none;"></div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'groupcreation-form',
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
                        <?php echo $form->error($preferencesModel, 'FileName'); ?>
                        <div id="groupCreationSpinner"></div>
                <div class="alert alert-error" id="errmsgForGroupCreation" style='display: none'></div>
                <div class="alert alert-success" id="sucmsgForGroupCreation" style='display: none'></div> 
                
                <div class="row-fluid  ">
                    <div class="span12">

                       <?php echo $form->labelEx($preferencesModel, Yii::t('translation', 'GroupName')); ?>
                        <div class="e_descriptiontext" style="min-height: 20px;"><?php  echo $preferencesModel->GroupName?></div>
                        <div class="control-group controlerror">
                            <?php echo $form->error($preferencesModel, 'GroupName'); ?>
                        </div>
                    </div>
                </div>
                <div class="row-fluid  ">
                    <div class="span12">
                        
                    <?php echo $form->labelEx($preferencesModel, Yii::t('translation', 'GroupDescription')); ?>
                    <div class="collapse in" id="profileInPreferences">
                        <?php  $stringArray = str_split($groupStatistics->GroupDescription, 240);?>
                        <div id="groupDescriptionInPreferences" onclick="editGroupDescriptionInPreferences()" class="groupabout"><div class="e_descriptiontext" id="descriptioToshowInPreferences"><?php  echo $stringArray[0]?></div>
                        </div>
                            <div id="groupDescriptionTotalInPreferences" style="display:none;padding: 5px"     <?php   if($groupStatistics->IsGroupAdmin==1){?> onclick="editGroupDescriptionInPreferences()" <?php   }?> class="groupabout"><div class="e_descriptiontext" id="descriptioToshowInPreferences"><?php   echo $groupStatistics->GroupDescription?></div>

                        </div>


                        <div id="editGroupDescriptionInPreferences" style="display:none;">
                             <div class="editable groupAboutEdit" style="padding: 8px;">
                                  <div id="editGroupDescriptionTextInPreferences" class="e_descriptiontext"  contentEditable="true" ><?php   echo $groupStatistics->GroupDescription?></div>
                                  
                                       </div>
                            

                         </div>
                         
                        </div>
                        <div class="control-group controlerror">
                            <?php echo $form->error($preferencesModel, 'Description'); ?>
                         </div>
                     </div>
                </div>
                <div class="row-fluid  ">
                    <div class="span12">
                        <?php echo $form->labelEx($preferencesModel, Yii::t('translation','Group_Logo')); ?>
                        <div class="alert alert-error" id="GroupLogoErrorInPreferences" style="display: none"></div>
                        <div class="grouplogo positionrelative editicondiv">

                            <div class="edit_iconbg tooltiplink cursor" data-original-title="<?php echo Yii::t('translation','Upload_40x90_dimensions'); ?>" rel="tooltip" data-placement="bottom">
                                <div id='GroupLogoInPreferences'></div>


                                <div id="updateAndCancelGroupIconUploadButtonsInPreferences" style="display: none">
                            
                       <i id="cancelGroupIconInPreferences" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor" onclick="cancelBannerOrIconUpload('<?php   echo $groupStatistics->GroupIcon?>','GroupProfileImage')"></i>
                            </div>
                                </div>
                            <img id="groupIconPreviewIdInPreferences" src="<?php   echo $groupStatistics->GroupIcon?>" alt="<?php   echo $groupStatistics->GroupName?>" />


                        </div>
                        <div ><ul class="qq-upload-list" id="uploadlist_logoPreferences"></ul></div>
                    </div>
                </div>
                <?php if($customGroup == 0){?>
                <div class="row-fluid padding8top" id="groupModeChangeButtons">
                     <?php echo $form->labelEx($preferencesModel, Yii::t('translation','Group_Mode')); ?>
                    <div class="span12">
                       
                        <div class="span6" id="GroupCreationForm_NormalMode_radio">
                        <?php 
                            echo $form->radioButton($preferencesModel,'IFrameMode',array("value"=>0,"id"=>"GroupCreationForm_NormalMode",'uncheckValue'=>null,'class'=>'styled', 'onclick'=>'changeGroupMode("Native")'));     
                        ?>
                           <?php echo Yii::t('translation','Native_Mode'); ?> 
                        </div>
                        <div class="span6" id="GroupCreationForm_IFrameMode_radio">
                        <?php 
                            echo $form->radioButton($preferencesModel,'IFrameMode',array("value"=>1,"id"=>"GroupCreationForm_IFrameMode",'uncheckValue'=>null,'class'=>'styled', 'onclick'=>'changeGroupMode("IFrame")'));     
                        ?>
                            <?php echo Yii::t('translation','IFrame_Mode'); ?> 
                        </div>
                      </div>
                  </div>
                <?php } ?>
                <?php if(count($subSpe)>0){ ?>
<div class="row-fluid customrowfluidad  "  >
                  <div class="span12" id="SubSpecialityList">

                        <?php echo $form->labelEx($preferencesModel, Yii::t('translation', 'User_Register_Urology_What_is_Primary')); ?>
                    <div class="chat_profileareasearch"  style="margin:0px">
                        <?php
                        echo $form->dropDownlist($preferencesModel, 'SubSpeciality',$subSpe , array(
                            'class' => "span12",
                            'multiple' => 'multiple'
                        ));
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($preferencesModel, 'SubSpeciality'); ?>
                    </div>
                </div>
            </div>
<?php }?>
                <div class="row-fluid  " id="IFrameURLDiv" style="display: <?php echo (isset($preferencesModel->IFrameMode) && $preferencesModel->IFrameMode==1)?'block':'none'; ?>">
                    <div class="span12">

                       <?php echo $form->labelEx($preferencesModel, Yii::t('translation', 'IFrameURL')); ?>
                        <div class="alert alert-error" id="IFrameUrlErrorInPreferences" style="display: none"></div>
                        <div class="collapse in" id="profileIFrameUrlInPreferences">
                            <div id="IFrameUrlInPreferences" onclick="editIFrameUrlInPreferences()" class="groupabout"><div class="e_descriptiontext " id="IFrameUrlToshowInPreferences"><?php echo isset($preferencesModel->IFrameURL)?$preferencesModel->IFrameURL:"" ?></div>
                            </div>
                            <div id="editIFrameUrlInPreferences" style="display:none;">
                                <div class="editable groupAboutEdit" style="padding: 8px;">
                                    <div id="editIFrameUrlTextInPreferences" class="e_descriptiontext"  contentEditable="true" onkeyup="getsnipetIframe(this.id)"><?php echo isset($preferencesModel->IFrameURL)?$preferencesModel->IFrameURL:"" ?></div>

                                </div>

                            </div>

                        </div>
                        <div class="control-group controlerror">
                            <?php echo $form->error($preferencesModel, 'IFrameURL'); ?>
                        </div>
                    </div>
                </div>
                <div  id="snippet_main" style="display:none; padding-top: 10px;padding-bottom:10px;" ></div>
                <?php if($preferencesModel->IsPrivate==0){
                    if($preferencesModel->AutoFollow==1){?>
                <div class="row-fluid " id='AutoModeDiv'>
                 <div class="span12">                  
               
                    
                   <?php echo $form->checkBox($preferencesModel,'AutoFollow',array('class' => 'styled','onclick'=>'changeGroupAsAutoFollow("IFrame")'))?>
                   <?php  echo  Yii::t('translation','Show_AutoFollowGroup_Label');?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($preferencesModel, 'AutoFollow'); ?>
                        </div>
                
                 
                 </div>
                    </div><?php } ?>

                <div class="row-fluid "  id='AddSocialActions'>
                            <div class="span12">                  


                                <?php echo $form->checkBox($preferencesModel, 'AddSocialActions', array('class' => 'styled')) ?>
                                <?php  echo  Yii::t('translation','Show_SocialAction_Label');?>
                                <div class="control-group controlerror">
                                    <?php echo $form->error($preferencesModel, 'AddSocialActions'); ?>
                                </div>


                           </div>
                 </div>
     <div class="row-fluid "  id='DisableWebPreview'>
                            <div class="span12">                  


                                <?php echo $form->checkBox($preferencesModel, 'DisableWebPreview', array('class' => 'styled')) ?>
                                  <?php  echo  Yii::t('translation','Disable_WebPreview_Label');?>
                                <div class="control-group controlerror">
                                    <?php echo $form->error($preferencesModel, 'DisableWebPreview'); ?>
                                </div>


                           </div>
                 </div>

                <?php if($IsIFrameMode == 0){ ?>
                
                <div class="row-fluid "  id='groupConversations'>
                 <div class="span12">                  
               
                    
                   <?php echo $form->checkBox($preferencesModel,'ConversationVisibility',array('class' => 'styled'))?>
                         <?php  echo  Yii::t('translation','Show_ConversationsGroup_Label');?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($preferencesModel, 'ConversationVisibility'); ?>
                        </div>
                
                 
                 </div>
                </div>
                
                <?php } ?>
                <?php if($customGroup != 0 ){?>
                <div class="row-fluid "  id='DisableStreamConversation'>
                        <div class="span12">                  


                            <?php echo $form->checkBox($preferencesModel, 'DisableStreamConversation', array('class' => 'styled')) ?>
                            <?php  echo  Yii::t('translation','Disable_StreamConversation_Label');?> 
                            <div class="control-group controlerror">
                                <?php echo $form->error($preferencesModel, 'DisableStreamConversation'); ?>
                            </div>


                        </div>
                    </div>
                
 <?php }?>   
                       <div class="row-fluid "  id='groupInactive'>
                 <div class="span12">                  
               
                    
                   <?php echo $form->checkBox($preferencesModel,'Status',array('class' => 'styled'))?>
                         <?php  echo  Yii::t('translation','Make_Group_Inactive');?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($preferencesModel, 'Status'); ?>
                        </div>
                
                 
                 </div>
                </div> 
                
                <?php if($preferencesModel->RestrictedAccess == 1){ ?>
                <?php echo $form->hiddenField($preferencesModel, 'FileName'); ?>         
                <div class="alert alert-error" id="emailserros" style="display:none"></div>
                <div id="uploadspinner" class="positionrelative"></div>
                <div class="groupcreationbuttonstyle " style="overflow:auto;max-height: 80px" id="previousfiles">
                    <?php foreach($filesArray as $row){ ?>
                    <span class="label group_filename" id="label_deletespan_<?php echo $row->Id; ?>"><button data-placement="bottom" rel="tooltip"  data-original-title="remove" data-id="<?php echo $row->Id; ?>" class="close deletefilefromlist" data-dismiss="closef" type="button">×</button> <b style="margin-left:2px;padding-right:6px;vertical-align: middle"><?php echo $row->FileName; ?></b><a class="groupfiledownload" data-originalfilename="<?php echo $row->ModifiedFileName; ?>"><i class="icon-download-alt"></i></a></span>
                    <?php } ?>
                </div>
                <div  id="uploadedfileslist" style=";display:none;">

                </div>
                
                <div class="row-fluid" id="fileuploadforgroup">
                    <div class="span12">
                        <div class="span8">
                            <ul><li class="dropdown pull-left ">
                    <div id='uploadFile_csv' data-placement="bottom" rel="tooltip"  data-original-title="Upload"></div>
                    </li>
                        </ul>
                        </div>
                        <div class="span4 positionrelative">
                            <i class="fa fa-question helpmanagement  helpicon top10  tooltiplink" style="font-weight: normal" data-id="GroupRestrictedUploadFileType_DivId" data-placement="bottom" rel="tooltip"  data-original-title="upload file type" ></i>
                        </div>
                        
                    </div>
                    <div ><ul class="qq-upload-list" id="uploadlist_files"></ul></div>
                    
                </div>
                
                <?php } ?>
 <?php }?>    
            
                <div class="groupcreationbuttonstyle alignright" id="groupeditsubmit">
                     <?php echo $form->hiddenField($preferencesModel, 'id',array('class'=>'')); ?>
                    <?php echo $form->hiddenField($preferencesModel, 'Description',array('class'=>'','id'=>'DescriptionHidden')); ?>
                    <?php echo $form->hiddenField($preferencesModel, 'GroupName',array('class'=>'','id'=>'GroupNameHidden')); ?>
                    <?php echo $form->hiddenField($preferencesModel, 'GroupProfileImage',array('class'=>'','id'=>'GroupProfileImageHidden')); ?>
                    <?php echo $form->hiddenField($preferencesModel, 'IFrameURL',array('class'=>'','id'=>'IFrameURLHidden')); ?>
                    
                      <?php echo CHtml::Button('Save',array('class' => 'btn pull-right','onclick'=>'saveGroupSettings();')); ?> 

                </div>
            <?php $this->endWidget(); ?>
            </div>
                        </li>
                        <li style="<?php echo $displayAnaltics?>" class=""><a href="/<?php   echo $groupStatistics->GroupUniqueName?>/analytics" class="analytics" ><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="Analytics" src="/images/system/spacer.png" /></a></li>
                        <?php if($groupStatistics->Status==1){?>
                        <?php if(((Yii::app()->session['IsAdmin']==1 || $groupStatistics->IsGroupAdmin==1 || Yii::app()->session['PostAsNetwork'] == 1) && $IsIFrameMode == 1 ) || (Yii::app()->session['IsAdmin']==1 || $groupStatistics->IsGroupAdmin==1 || Yii::app()->session['PostAsNetwork'] == 1) &&  ( ($hybrid == 0 && $customGroup == 1) )){ ?>

                            <li><a  id='IFramePost' class="post"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Post'); ?>" src="/images/system/spacer.png" /></a></li>
                        <?php } } ?>
                    </ul>
                </div>
               
               <?php if(($preferencesModel->RestrictedAccess == 0 && $groupStatistics->IsGroupAdmin!=1) || ($groupStatistics->IsGroupAdmin!=1 && $preferencesModel->RestrictedAccess == 1 && $userAllowable == 1)){ ?>
                     <div class="pull-right" style="padding-top:8px">
                   <?php if(Yii::app()->session['PostAsNetwork']==1){?>
                <span id="followGroupInDetail" style="padding: 0px" class="social_bar noborder profile_bar groupdetailfollow" data-groupid="<?php   echo $groupStatistics->GroupId ?>"  data-category="Group"> <a><i  ><img class=" tooltiplink  <?php   echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->GroupMembers)?'Networkfollowbig':'Networkunfollowbig' ?>"  src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php   echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->GroupMembers)?'Unfollow':'Follow' ?>"></i></a> </span>
                <?php }else{?>
                <?php if(is_array($groupStatistics->GroupMembers)){?>
               <span id="followGroupInDetail" style="padding: 0px" class="social_bar noborder profile_bar groupdetailfollow" data-groupid="<?php   echo $groupStatistics->GroupId ?>"  data-category="Group"> <a><i  ><img class=" tooltiplink cursor <?php   echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->GroupMembers)?'followbig':'unfollowbig' ?>"  src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php   echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->GroupMembers)?'Unfollow':'Follow' ?>"></i></a> </span>
                <?php } }?>
                </div>
        
               <?php } ?>
               
                <?php //}else{ ?>
<!--                <div ><a href="#" onclick="setMenuStyles('H');"> switch Horizontal</a></div>
                <div><a href="#" onclick="setMenuStyles('V');"> switch vertical</a></div>-->
                <?php //} ?>
            </div>
     </div>
</div>
    
    <script type="text/javascript">        
        
        globalspace.groupMode = <?php echo (isset($preferencesModel->IFrameMode) && $preferencesModel->IFrameMode==1)?1:0; ?>;
      if(!detectDevices()){
            $("[rel=tooltip]").tooltip();
        }       
        <?php if($conversationVisibilitySettings == 1){ ?> 
            $("#GroupCreationForm_ConversationVisibility").attr("checked","checked");
        <?php }
        if($preferencesModel->RestrictedAccess == 1){ ?>
            $("#AutoModeDiv").hide();
            $("#GroupCreationForm_RestrictedAccess").attr("checked","checked");
        <?php } ?>
            
            
      groupPreferencesInitializations('<?php echo $groupPostModel->GroupId ?>');
        sessionStorage.pageName = "group/groupdetail";//<!-- This is used to load joyride help for the selected group-->
        $(document).ready(function(){
           $("#updatePreferences").on("click touchstart",function(e){
               e.stopPropagation();
           })
           });
        var extensions='"csv"';
     initializeFileUploader('uploadFile_csv', '/group/FileUpload', '10*1024*1024', extensions,4, 'GroupPostForm' ,'',PreviewUploadedFile,displayErrorForFile,"uploadlist_files");
        $('#restrictedaccessdiv span.checkbox').bind("click",
        function() {            
            if ($('#GroupCreationForm_RestrictedAccess').is(':checked')) {
                $("#uploadedfileslist,#fileuploadforgroup,#previousfiles").show();
                $("#AutoModeDiv").hide();
            }else {
                $("#uploadedfileslist,#fileuploadforgroup,#previousfiles").hide();
                $("#AutoModeDiv").show();
            }                
        }

    );
       
    function PreviewUploadedFile(id, fileName, responseJSON, type)
    {
        var data = eval(responseJSON);
        var html= '&nbsp;<span class="label" onclick="deleteAppended(this)"><button data-placement="bottom" rel="tooltip"  data-original-title="remove" class="close deletefilefromlist" data-dismiss="closef" type="button">×</button> <b style="margin-left:2px;padding-right:6px;vertical-align: middle">'+data.filename+'</b></span>';
        $('#uploadedfileslist').html(html).show();
        $("#GroupCreationForm_FileName").val(data.filename);
//        var queryString = "groupId=<?php //echo $groupPostModel->GroupId ?>&fileName="+fileName+"&groupName=<?php //echo $groupStatistics->GroupName?>";        
//        ajaxRequest("/group/saveUploadedFile", queryString, function(data){fileuploadHandler(data);});
    }
    function fileuploadHandler(data){
        if(data.data == "error"){
           $("#emailserros").removeClass().addClass("alert alert-error").html(data.msg).show().fadeOut(7000);
        }else{
            $("#emailserros").removeClass().addClass("alert alert-success").html("Imported Success").show().fadeOut(7000);
        }
    }
    function displayErrorForFile(message, type) {
         $("#emailserros").removeClass().addClass("alert alert-error").html(message).show().fadeOut(7000);
    }
    $("span.label button.deletefilefromlist").on('click',function(){
       var $this = $(this);        
       var id = $this.attr("data-id");       
       var queryString = "fileId="+id;
       if(id != null && id != "undefined"){
           scrollPleaseWait('uploadspinner');
            ajaxRequest("/group/deleteFromList", queryString, function(data){deleteFromListHandler(data,id);});
        }
        
    });
    
    
    function deleteFromListHandler(data,id){ 
        scrollPleaseWaitClose('uploadspinner');
        if(data.status == "success"){            
            $("#label_deletespan_"+id).remove();
        }
    }
    
    function deleteAppended(obj){
        $(obj).remove();
        $("#uploadedfileslist").hide();
        $("#GroupCreationForm_FileName").val("");
    }
    $(".groupfiledownload").on("click",function(){
        var $this = $(this);
        var filename = $this.data("originalfilename");
        window.location.href = "/group/downloadFile?filename="+filename;
    })
    </script>
