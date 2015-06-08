<div class="group_admin_floatingMenu marginbottom10">
    <div class="row-fluid">
            <div class="span12">
            <div class="pull-left ">   
                <div id="groupfollowSpinLoader" style="position:relative;"></div>
                <div id="crumbs">
	<ul>
            <li><div class="b_Section"><a class="marginT9displayblock" href="/<?php   echo $groupStatistics->GroupUniqueName?>"><?php   echo html_entity_decode($groupStatistics->GroupName);?></a></div></li>
            <li>
            
                <?php if(Yii::app()->session['PostAsNetwork']==1){?>

                <div style="line-height:33px;" class="b_Section"><?php   echo html_entity_decode($groupStatistics->SubGroupName)?><span  class="social_bar noborder profile_bar" style="padding:0;margin:0" data-subgroupid="<?php   echo $groupStatistics->SubGroupId ?>" data-groupid="<?php   echo $groupStatistics->GroupId ?>"  data-category="SubGroup"></span></div></li><?php echo $groupStatistics->Status==0?'<label class="group_alert_info"> <i class="fa fa-info-circle"></i>'.Yii::t('translation', 'SubGroupInactive').'</label>':''?>

                <?php }else{?>

                <div style="line-height:33px;" class="b_Section"><?php   echo html_entity_decode($groupStatistics->SubGroupName)?><span class="social_bar noborder profile_bar" style="padding:0;margin:0" data-subgroupid="<?php   echo $groupStatistics->SubGroupId ?>" data-groupid="<?php   echo $groupStatistics->GroupId ?>"  data-category="SubGroup"></span></div></li><?php echo $groupStatistics->Status==0?'<label class="group_alert_info"> <i class="fa fa-info-circle"></i>'.Yii::t('translation', 'SubGroupInactive').'</label>':''?>
                <?php }?>
                
                
                
                
		
	</ul>
</div>
       
            </div>
            <?php  $floatingMenuStyle='display:none';
            if(($groupStatistics->IsSubGroupAdmin==1 && in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->SubGroupMembers))||Yii::app()->session['IsAdmin'] == 1){
                        $floatingMenuStyle='display:block';
                    } ?>
                <div class="floatingMenu pull-right padding8top" id='GroupAdminMenu' style='<?php echo $floatingMenuStyle ?>'>
                    
                    <ul>
                    	<li class="radioalign active"> <a href="#" class="preferences" data-toggle="dropdown" ><img id="preferences" class=" tooltiplink cursor" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Preferences'); ?>" src="/images/system/spacer.png" /></a>
                             <div id="updatePreferences" class="dropdown dropdown-menu actionmorediv actionmoredivtop newgrouppopup newgrouppopupdivtop preferences_popup" >
            
			<div class="headerpoptitle_white"><?php echo Yii::t('translation', 'Sub_Group_Creation');?></div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'subgroupcreation-form',
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
                        <div id="groupCreationSpinner"></div>
                <div class="alert alert-error" id="errmsgForGroupCreation" style='display: none'></div>
                <div class="alert alert-success" id="sucmsgForGroupCreation" style='display: none'></div> 
                <div class="row-fluid  ">
                    <div class="span12">

                       <?php echo $form->labelEx($newGroupModel, Yii::t('translation', 'SubGroupName')); ?>
                        <div  class="grouplogoheading padding8top" ><?php   echo html_entity_decode($groupStatistics->SubGroupName);?>
                    </div>
                </div>
                
                   <?php   echo $form->hiddenField($newGroupModel,'GroupId',array('value'=>$groupStatistics->GroupId)); ?>
                <div class="row-fluid  ">
                    <div class="span12">

                    <?php echo $form->labelEx($newGroupModel, Yii::t('translation', 'SubGroupDescription')); ?>
                      <?php  $stringArray = str_split($groupStatistics->SubGroupDescription, 240);?>
                        <div id="groupDescriptionInPreferences" <?php  if($groupStatistics->IsSubGroupAdmin==1){?> onclick="editGroupDescriptionInPreferences()" <?php  }?> class="groupabout"><div class="e_descriptiontext" id="descriptioToshowInPreferences"><?php  echo $stringArray[0]?></div>
     </div>
         <div id="groupDescriptionTotalInPreferences" style="display:none;padding: 5px"     <?php   if($groupStatistics->IsSubGroupAdmin==1){?> onclick="editGroupDescriptionInPreferences()" <?php   }?> class="groupabout"><div class="e_descriptiontext" id="descriptioToshowInPreferences"><?php   echo $groupStatistics->SubGroupDescription?></div>
     
     </div>
        
     
     <div id="editGroupDescriptionInPreferences" style="display:none;">
          <div class="editable groupAboutEdit" style="padding: 8px;">
               <div id="editGroupDescriptionTextInPreferences" class="e_descriptiontext"  contentEditable="true" ><?php   echo $groupStatistics->SubGroupDescription?></div>
              
                    </div>
         <div  class="alignright padding5"> 
            
        <i id="closeEditGroupDescriptionInPreferences" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor" onclick='closeEditGroupDescriptionInPreferences()'></i></div>
          
      </div>
                    </div>
                </div>
                <div class="alert alert-error" id="GroupLogoError" style="display: none"></div>
         <div class="grouplogo positionrelative editicondiv">

                            <div class="edit_iconbg tooltiplink cursor" data-original-title="<?php echo Yii::t('translation','Upload_40x90_dimensions'); ?>" rel="tooltip" data-placement="bottom">
                                <div id='GroupLogoInPreferences'></div>


                                <div id="updateAndCancelGroupIconUploadButtonsInPreferences" style="display: none">
                             
                       <i id="cancelGroupIconInPreferences" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor" onclick="cancelBannerOrIconUpload('<?php   echo $groupStatistics->SubGroupIcon?>','GroupProfileImage')"></i>
                            </div>
                                </div>
                            <img id="groupIconPreviewIdInPreferences" src="<?php   echo $groupStatistics->SubGroupIcon?>" alt="<?php   echo $groupStatistics->SubGroupName?>" />


                        </div>
                <div ><ul class="qq-upload-list" id="uploadlist_logo"></ul></div>
                <div class="row-fluid " id='ShowPostInMainStream'>
                 <div class="span12">   
                     <?php echo $form->checkBox($newGroupModel,'ShowPostInMainStream',array('class' => 'styled'))?>
                    <?php  echo  Yii::t('translation','Show_PostInStream_Label');?>
                </div></div>

                 <div class="row-fluid " id='AddSubGroupSocialActions'>
                 <div class="span12">   
                     <?php echo $form->checkBox($newGroupModel,'AddSocialActions',array('class' => 'styled'))?>
                    <?php  echo  Yii::t('translation','Show_SocialAction_Label');?>
                </div></div>
                 <div class="row-fluid " id='SubGroupDisableWebPreview'>
                 <div class="span12">   
                     <?php echo $form->checkBox($newGroupModel,'DisableWebPreview',array('class' => 'styled'))?>
                   <?php  echo  Yii::t('translation','Disable_WebPreview_Label');?>
                </div></div>
                <div class="row-fluid " id='SubGroupDisableWebPreview'>
                 <div class="span12">   
                     <?php echo $form->checkBox($newGroupModel,'DisableStreamConversation',array('class' => 'styled'))?>
                   <?php  echo  Yii::t('translation','Disable_StreamConversation_Label');?> 
                </div></div>
                
                <div class="row-fluid "  id='groupInactive'>
                    <?php echo $groupStatus==0?Yii::t('translation','Parent_Group_Active'):''?>
                 <div class="span12">                  
               
                  <?php $va='';
                          if($groupStatus==0){
                              $va='disabled=>disabled';
                          }else{
                              $va='';
                          }
                                  ?>
                   <?php echo $form->checkBox($newGroupModel,'Status',array('class' => 'styled','disabled=>disabled'))?>
                         <?php  echo  Yii::t('translation','Make_SubGroup_Inactive');?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'Status'); ?>
                        </div>
                
                 
                 </div>
                </div>
                
             <div class="groupcreationbuttonstyle alignright" id="groupeditsubmit">
                     <?php echo $form->hiddenField($newGroupModel, 'id',array('class'=>'')); ?>
                    <?php echo $form->hiddenField($newGroupModel, 'SubGroupDescription',array('class'=>'','id'=>'DescriptionHidden')); ?>
                    <?php echo $form->hiddenField($newGroupModel, 'SubGroupName',array('class'=>'','id'=>'GroupNameHidden')); ?>
                    <?php echo $form->hiddenField($newGroupModel, 'GroupProfileImage',array('class'=>'','id'=>'GroupProfileImageHidden')); ?>
                    
                      <?php echo CHtml::Button('Save',array('class' => 'btn pull-right','onclick'=>'saveSubGroupSettings();')); ?> 

                </div>   
            <?php $this->endWidget(); ?>
            </div>
                        </li>
                       
                    </ul>
                </div>
                            
               
                    <div class="pull-right" style="padding-top:8px">
                <?php if(Yii::app()->session['PostAsNetwork']==1){?>
                <span id="followGroupInDetail" class="social_bar noborder profile_bar groupdetailfollow" style="padding:0;margin:0" data-subgroupid="<?php   echo $groupStatistics->SubGroupId ?>" data-groupid="<?php   echo $groupStatistics->GroupId ?>"  data-category="SubGroup"><img class=" tooltiplink  <?php   echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->SubGroupMembers)?'Networkfollowbig':'Networkunfollowbig' ?>"  src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php   echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->SubGroupMembers)?'Unfollow':'Follow' ?>"></span>
                <?php }else{?>
                <span id="followGroupInDetail" class="social_bar noborder profile_bar groupdetailfollow" style="padding:0;margin:0" data-subgroupid="<?php   echo $groupStatistics->SubGroupId ?>" data-groupid="<?php   echo $groupStatistics->GroupId ?>"  data-category="SubGroup"><img class=" tooltiplink cursor <?php   echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->SubGroupMembers)?'followbig':'unfollowbig' ?>"  src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php   echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $groupStatistics->SubGroupMembers)?'Unfollow':'Follow' ?>"></span>
                <?php }?>
                      </div>      
            </div>
     </div>
</div>
    
    <script type="text/javascript">
      
      if(!detectDevices()){
            $("[rel=tooltip]").tooltip();
        }
     subGroupPreferencesInitializations('<?php echo $groupPostModel->SubGroupId ?>');
     $(document).ready(function(){
           $("#updatePreferences").on("click touchstart",function(e){
               e.stopPropagation();
           })
           });
    </script>
