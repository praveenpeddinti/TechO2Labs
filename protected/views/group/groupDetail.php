<?php if($groupStatistics->Status==1 || Yii::app()->session['IsAdmin']==1){?>
<?php   include 'miniProfileScript.php'; ?>
<?php   include 'hashTagProfileScript.php'; ?>
<?php   include 'commentscript.php'; ?>
<?php   include 'groupcommentscript.php'; ?>
<?php   include 'detailedcommentscript.php'; ?>
<?php   include 'commentscript_instant.php'; ?>
<?php   include 'inviteScript.php'; ?>
<?php include 'snippetDetails.php'?>
 <?php include 'userSubGroupsFollowing.php'; ?>
<?php include 'groupFloatingMenu.php'; ?>

<?php if($hybrid== 1){ ?> 
<?php $location = isset($_GET['location'])?$_GET['location']:""; 
    
?>
<?php if(isset($customGroupName) && !empty($customGroupName)){ 
    if(empty($location) || is_numeric($location)){
    ?>

 <div id="custommenu">   
 <?php  include "customgroups/$customGroupName/h_menu.php"; ?>
</div> 
    <?php } ?>
    <iframe scrolling="no" src="#" frameborder="0" width="100%" height="100%"
            id="bioiframe" style="display: none;"></iframe>
<?php }else{ ?>
     <div id="custommenu">   
 <?php  include "customgroups/underConstruction.php"; ?>
        
</div>
<?php } } ?>
<?php if(empty($location) || is_numeric($location)){ ?>
<div id="GroupTotalPage" class="paddingtop6" <?php if($hybrid== 1){ if((isset($customGroupName) && empty($customGroupName)) || $customGroupName == "" ){?> style="display:none;"<?php }}?>>
   
<div id="GroupBanner" class="collapse in">
  
     <div class="alert alert-error" id="GroupBannerError" style="display: none"></div>
     
<div  class="groupbanner positionrelative editicondiv" >    
    <?php if($groupStatistics->IsGroupAdmin==1 || Yii::app()->session['PostAsNetwork']==1){?>
    <div class="edit_iconbg tooltiplink cursor" data-original-title="<?php echo Yii::t('translation','Upload_1180x200_dimensions'); ?>" rel="tooltip" data-placement="bottom">
        <div id='GroupBannerImage' ></div>
                    

        <div id="updateAndCancelBannerUploadButtons" style="display: none">
        <i  id="updateGroupBanner" class="fa fa-floppy-o editable_icons editable_icons_big" onclick='saveGroupBannerAndIcon("<?php   echo $groupStatistics->GroupId?>","GroupBannerImage","Group")'></i>
        <i  id="updateGroupBanner" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor" onclick="cancelBannerOrIconUpload('<?php   echo $groupStatistics->GroupBannerImage?>','GroupBannerImage')"></i>
        </div>
    </div>
    <?php   }?>
<img style="max-width:100%" src="<?php   echo $groupStatistics->GroupBannerImage?>"  id="GroupBannerPreview"/>
</div>
     <div ><ul class="qq-upload-list" id="uploadlist"></ul></div>
</div>
 
   
 
 <div class="row-fluid" id="groupProfileDiv">
     <div class="span4">
     <div class="padding8top">
          <div class="alert alert-error" id="GroupLogoError" style="display: none"></div>
         <div class="grouplogo positionrelative editicondiv">

             <div class="edit_iconbg tooltiplink cursor" data-original-title="<?php echo Yii::t('translation','Upload_40x90_dimensions'); ?>" rel="tooltip" data-placement="bottom">
                 <div id='GroupLogo'></div>
               

                 <div id="updateAndCancelGroupIconUploadButtons" style="display: none">
              <i id="updateGroupIcon" class="fa fa-floppy-o editable_icons editable_icons_big" onclick='saveGroupBannerAndIcon("<?php   echo $groupStatistics->GroupId?>","GroupProfileImage","Group")'></i>
        <i id="cancelGroupIcon" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor" onclick="cancelBannerOrIconUpload('<?php   echo $groupStatistics->GroupIcon?>','GroupProfileImage')"></i>
             </div>
                 </div>
             <img id="groupIconPreviewId" src="<?php   echo $groupStatistics->GroupIcon?>" alt="<?php   echo $groupStatistics->GroupName?>" />
             
         
         </div>
          <div ><ul class="qq-upload-list" id="uploadlist_logo"></ul></div>
          
     <div class="collapse in" id="profile">
        <?php  $stringArray = str_split($groupStatistics->GroupDescription, 240);?>
     <div id="groupDescription" <?php  if($groupStatistics->IsGroupAdmin==1 || Yii::app()->session['PostAsNetwork']==1){?> onclick="editGroupDescription()" <?php  }?> class="groupabout"><div class="e_descriptiontext" id="descriptioToshow"><?php  echo $stringArray[0]?></div>
     </div>
         <div id="groupDescriptionTotal" style="display:none;padding: 5px"     <?php   if($groupStatistics->IsGroupAdmin==1 || Yii::app()->session['PostAsNetwork']==1){?> onclick="editGroupDescription()" <?php   }?> class="groupabout"><div class="e_descriptiontext" id="descriptioToshow"><?php   echo $groupStatistics->GroupDescription?></div>
     
     </div>
        
     
     <div id="editGroupDescription" style="display:none;">
          <div class="editable groupAboutEdit" style="padding: 8px;">
               <div id="editGroupDescriptionText" class="e_descriptiontext"  contentEditable="true" ><?php   echo $groupStatistics->GroupDescription?></div>
              
                    </div>
         <div  class="alignright padding5"> 
             <i id="updateGroupDescription" class="fa fa-floppy-o editable_icons editable_icons_big" onclick='saveEditGroupDescription("<?php   echo $groupStatistics->GroupId?>","GroupDescription","Group")'></i>
        <i id="closeEditGroupDescription" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor" onclick='closeEditGroupDescription()'></i></div>
          
      </div>
         <div class="alignright clearboth" id="g_descriptionMore" style="display:<?php echo strlen($groupStatistics->GroupDescription)>240?'block':'none'; ?>"> <a  class="more">more <i class="fa fa-chevron-circle-right"></i></a></div>
     <div class="alignright clearboth" > <a style="display:none" class="moreup">close <i class="fa fa-chevron-circle-up"></i></a></div>
     </div>
     </div>
     </div>
          <div class="span8 ">
          <div class="collapse in" id="groupmenu">
              <div class="grouphomemenuhelp alignright"></i></div>
         <div class="grouphomemenu">
     <ul>
     <li class="normal">
         <div class="menubox" id="GroupFollowers" <?php  if(($groupStatistics->IsFollowing==1 || Yii::app()->session['PostAsNetwork']==1) && $groupStatistics->Status==1){?> onclick="getUserFollowers('<?php  echo $groupStatistics->GroupId?>','Group') <?php  }?>">
             <div class="menuboxpopup"><span><?php echo Yii::t('translation','Followers'); ?></span></div>
     <div class="groupmenucount" id="groupFollowersCount"><?php   echo $groupStatistics->GroupMembersCount ?></div>
     <ul>
         
             <?php   $i=0?>
            <?php   if(count($groupStatistics->GroupMembersProfilePictures)>0){?>
                <?php   foreach ($groupStatistics->GroupMembersProfilePictures as $profilePicture) {?>
                   <?php   if($i<9){?>
                   <li >
                 <div class="menusubbox"><img src="<?php   echo $profilePicture?>" /></div>     
             </li>
            <?php   }else{
                break;
                
            }?>
             <?php   $i++ ?>
             <?php   }?>
            <?php   }?>
         <?php   for($j=1;$j<=9-$i;$j++){?>
              <li>
     <div class="menusubbox"></div>
     
     </li>
             <?php   }?>
     
    
     </ul>
     
     </div>
     
     </li>
         <li id="GroupImages" class="normal" <?php   if(count($groupStatistics->GroupImagesAndVideosCount)>0 && ($groupStatistics->IsFollowing==1  || Yii::app()->session['PostAsNetwork']==1) && $groupStatistics->Status==1){?> onclick="getGroupImagesAndVideos('<?php   echo $groupStatistics->GroupId?>','Group')" <?php   }?> >
     <div class="menubox" >
         <div class="menuboxpopup"><span><?php echo Yii::t('translation','Media'); ?></span></div>
     <div class="groupmenucount"><?php  
       if($groupStatistics->GroupImagesAndVideosCount==0) {
         echo $groupStatistics->GroupImagesAndVideosCount;
       
     }else{
          echo count($groupStatistics->GroupImagesAndVideosCount);
     }?></div>
     <ul>
         
             <?php   $i=0?>
       
          <?php   if(count($groupStatistics->GroupImagesAndVideos) >0 && $groupStatistics->GroupImagesAndVideos!='failure' )  {?>
                <?php   foreach ($groupStatistics->GroupImagesAndVideos as $artifacts) {?>
                   <?php   if($i<=9){?>
                   <li>
                 <div class="menusubbox"><img src="<?php   echo $artifacts ?>" /></div>     
             </li>
            <?php   }else{
                break;}?>
             <?php   $i++ ?>
             <?php   }?>
             <?php   }?>
         <?php   for($j=1;$j<=9-$i;$j++){?>
              <li>
     <div class="menusubbox"></div>
     
     </li>
             <?php   }?>
     
    
     </ul>
     
     </div>
     
     </li>
       <li id="GroupDocs" class="normal" <?php   if(count($groupStatistics->GroupArtifactsCount)>0 && ($groupStatistics->IsFollowing==1  || Yii::app()->session['PostAsNetwork']==1) && $groupStatistics->Status==1){?> onclick="getGetGroupDocs('<?php   echo $groupStatistics->GroupId?>','Group')" <?php   }?> >
     <div class="menubox" >
         <div class="menuboxpopup"><span><?php echo Yii::t('translation','Resources'); ?></span></div>
     <div class="groupmenucount">
         <?php  
       if($groupStatistics->GroupArtifactsCount==0) {
         echo $groupStatistics->GroupArtifactsCount;       
     }else{
          echo count($groupStatistics->GroupArtifactsCount);
     }?> 
        </div>
     <ul>
         
             <?php   $i=0?>
          <?php   if(count($groupStatistics->GroupArtifacts) >0 && $groupStatistics->GroupArtifacts!='failure' ){?>
                <?php   foreach ($groupStatistics->GroupArtifacts as $artifacts) {?>
       
                   <?php   if($i<=9){?>
                   <li>
                  <?php if(strtolower($artifacts) == 'mov' || strtolower($artifacts) == 'mp4'|| strtolower($artifacts) == 'flv'){
                                $videoclassName = 'videoThumnailDisplay';
                                    
                                }else {
                                    $videoclassName='videoThumnailNotDisplay';
                                }
?>
                 <div class="menusubbox"><div id='img_streamVideoDiv' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php   echo $artifacts; ?> " /></div>     
  
             </li>
            <?php   }else{
                break;}?>
             <?php   $i++ ?>
             <?php   }?>
             <?php   }?>
         <?php   for($j=1;$j<=9-$i;$j++){?>
              <li>
     <div class="menusubbox"></div>
     
     </li>
             <?php   }?>
     
    
     </ul>
     
     </div>     
           
     </li>
     
     <li id="conversations" class="normal" <?php   if(($groupStatistics->IsFollowing==1 || Yii::app()->session['PostAsNetwork']==1 ) && $groupStatistics->Status==1){?> onclick="loadGroupConversations('<?php echo $groupStatistics->GroupId ?>','Group')" <?php   }?>>
     <div class="menubox">
         <div class="menuboxpopup"><span><?php echo Yii::t('translation','Conversations'); ?></span></div>
     <div class="groupmenucount" id="GroupPostCount"><?php   echo $groupStatistics->GroupPostsCount?></div>
     <div class="conversationmenu"><img src="/images/system/conversation.png"></div>

     </div>

     </li>
     <?php if (Yii::app()->params['SubGroups'] == 'ON') { ?>
       <li id="SubGroups" class="normal" <?php   if(count($groupStatistics->SubgroupsCount)!=0 && $groupStatistics->Status==1) {?> onclick="getSubGroups('<?php   echo $groupStatistics->GroupId?>')" <?php   }?> >
     <div class="menubox" >
         <div class="menuboxpopup"><span><?php echo Yii::t('translation','SubGroups'); ?></span></div>
     <div class="groupmenucount">
        
          <?php echo $groupStatistics->SubgroupsCount;?>
    
        </div>
     <ul>
         
                <?php   $i=0?>
            <?php   if(count($groupStatistics->SubGroupLogo)>0){?>
                <?php   foreach ($groupStatistics->SubGroupLogo as $profilePicture) {?>
                   <?php   if($i<9){?>
                   <li >
                 <div class="menusubbox"><img src="<?php   echo $profilePicture?>" /></div>     
             </li>
            <?php   }else{
                break;
                
            }?>
             <?php   $i++ ?>
             <?php   }?>
            <?php   }?>
         <?php   for($j=1;$j<=9-$i;$j++){?>
              <li>
     <div class="menusubbox"></div>
     
     </li>
             <?php   }?>
     
    
     </ul>
     
     </div>     
           
     </li>
     <?php }?>
     </ul>
     </div>
          </div>
          <div class="alignright padding8top">
          <button data-target="#profile, #groupmenu, #Hide, #Show, #GroupBanner" data-toggle="collapse" class="btn btn_gray btn_toggle" type="button">
              <span class="collapse in" id="Hide"> <?php echo Yii::t('translation','Hide'); ?> <i class="fa fa-caret-up"></i></span>
   <span class="collapse " id="Show"><?php echo Yii::t('translation','Show'); ?> <i class="fa fa-caret-down"></i></span>
</button>
</div>
          </div>
     
     </div>
 
<!-- -->
<!--This is for creation of subGroup -->
<?php   if(($groupStatistics->IsGroupAdmin==1 || Yii::app()->session['PostAsNetwork']==1) && ($groupStatistics->IsFollowing==1 || Yii::app()->session['PostAsNetwork']==1)){?>      
<div id="createSubGroup" style="display: none">
    <div class="row-fluid" >
    <div class="span3"><h2 class="pagetitle"><?php echo Yii::t('translation','SubGroups'); ?>  </h2></div>
    <div class="span9 ">
        <!--replace class "fa fa-question" with  "fa fa-video-camera videohelpicon" if we have description and video remaining will be same-->
            
     
        <div class="searchgroups padding8top">
                
            <input class="btn " id='addSubGroup' name="commit" type="submit" data-toggle="dropdown" value="<?php echo Yii::t('translation','Add_Sub_Group'); ?>" /> 
             
<div id="addNewSubGroup" class="dropdown dropdown-menu actionmorediv actionmoredivtop newgrouppopup newgrouppopupdivtop" >
            
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
                        <span id="hiddengroupnamediv" style="display: none;"></span>                        
                        <span id="groupnamehtml" class="view_html" > <?php echo Yii::t('translation', 'Html_view'); ?></span>
                        <?php echo $form->textField($newGroupModel, 'SubGroupName', array("placeholder" => Yii::t('translation', ''), 'maxlength' => 65, 'class' => 'span12 textfield groupnamerelatedfield')); ?> 
                        <ul class="typeahead dropdown-menu" style="top:64px; left:0px;display: none " id="typeheadstyle">
                                    
                            </ul>
                        <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'SubGroupName'); ?>
                        </div>
                    </div>
                </div>
                
                   <?php   echo $form->hiddenField($newGroupModel,'GroupId',array('value'=>$groupStatistics->GroupId)); ?>
                <div class="row-fluid  ">
                    <div class="span12">

                    <?php echo $form->labelEx($newGroupModel, Yii::t('translation', 'SubGroupDescription')); ?>
                    <?php echo $form->textArea($newGroupModel, 'SubGroupDescription', array("placeholder" => Yii::t('translation', ''), 'class' => 'span12 textfield')); ?> 
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'SubGroupDescription'); ?>
                        </div>
                    </div>
                </div>
                <li class="pull-left">
                     <?php echo $form->checkBox($newGroupModel,'ShowPostInMainStream',array('class' => 'styled'))?>
                         <?php  echo  Yii::t('translation','Show_PostInStream_Label');?>
                </li>

                
                 <li class="pull-left">
                     <?php echo $form->checkBox($newGroupModel,'AddSocialActions',array('class' => 'styled'))?>
                         <?php  echo  Yii::t('translation','Show_SocialAction_Label');?>
                </li>
                 <li class="pull-left">
                     <?php echo $form->checkBox($newGroupModel,'DisableWebPreview',array('class' => 'styled'))?>
                          <?php  echo  Yii::t('translation','Disable_WebPreview_Label');?>
                </li>
                <li class="pull-left">
                     <?php echo $form->checkBox($newGroupModel,'DisableStreamConversation',array('class' => 'styled'))?>
                          <?php  echo  Yii::t('translation','Disable_StreamConversation_Label');?>
                </li>

                <div class="groupcreationbuttonstyle alignright">
                    
                        <?php
                        echo CHtml::ajaxSubmitButton('Create', array('/group/createSubGroup'), 
                                array(                                    
                            'type' => 'POST',
                            'dataType' => 'json',
                            
                            'error' => 'function(error){
                                        }',
                            'beforeSend' => 'function(){                                    
                                scrollPleaseWait("groupCreationSpinner","subgroupcreation-form");                }',
                            'complete' => 'function(){
                                                    }',
                            'success' => 'function(data,status,xhr) { createSubGroupHandler(data,status,xhr);}'), array('type' => 'submit', 'id' => 'newGroupId', 'class' => 'btn')
                        );
                        ?>
                        <?php echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'NewSubGroupReset', 'class' => 'btn btn_gray')); ?>

                </div>
            <?php $this->endWidget(); ?>
            </div>
             
                           <!--<i data-id="Groups_DivId" class="fa fa-video-camera videohelpicon helpicon helpmanagement helprelative pull-right pull-bottom tooltiplink" data-placement="bottom" rel="tooltip"  data-original-title="Groups" ></i>--> 
        </div>
           

    </div>
 </div>  
    </div> 

<?php }?>
<!--End for creation of subGroup -->
<div id="UPF"></div>
     
<div class="groupwithadds" style="position: relative">    
    <div <?php echo $advertisementsCount!=0?'class="groupMargin"':''?> id="groupMargin" >
           
<div  class="poststreamwidget" id="groupFormDiv" style="display:none">
         <h2 class="pagetitle"><?php   echo Yii::t('translation', 'Stream'); ?></h2>
    <div class="row-fluid">
    <div class="span12">
        
    <div class="alert alert-error" id="errmsgForStream" style='padding-top: 5px;display: none'>  </div>
    <div class="alert alert-success" id="sucmsgForStream" style='padding-top: 5px;display: none'></div>          
 <?php  
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'groupPost-form',
        'enableClientValidation' => true,
      //  'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),

        'htmlOptions' => array(
            'style' => 'margin: 0px; accept-charset=UTF-8',
        ),
    ));
    ?>
    <div  id="surveypostdiv" >
   <div class="headerpoptitle_white" style="display:none" id="survey_header"><?php   echo Yii::t('translation', 'SurveyPost_heading_lable');?> <i data-id="StreamSurvey_DivId" class="fa fa-question helpmanagement helpicon top10"></i></div>
   <div class="headerpoptitle_white" style="display:none" id="event_header"><?php   echo Yii::t('translation', 'EventPost_heading_lable');?> <i data-id="StreamEvent_DivId" class="fa fa-question helpmanagement helpicon top10"></i></div>
   <div id="GroupPostForm_Survey_Options_em_" class="alert alert-error " style="display: none;"></div>
   <div id="ArtifactSpinLoader_uploadFile"></div>
   
   <div id="surveyeventtitledescription" style="display:none">
   <div class="row-fluid padding8top padding-bottom10 customrow-fluid">
                  <div class="span12">
                     
                          <label><?php echo Yii::t('translation','Title'); ?></label>
                          <?php echo $form->textField($groupPostModel, 'Title', array('maxlength' => '40', 'class' => 'textfield span12')); ?>    
                          <div class="control-group controlerror"> 
                              <?php echo $form->error($groupPostModel, 'Title'); ?>
                          </div>

                  </div>
              </div>
 <div class="row-fluid  customrow-fluid" >
                  <div class="span12" style="min-height:25px">
                     
                         <label style="margin-bottom:0"><?php echo Yii::t('translation','Description'); ?></label>
                         

                  </div>
              </div>
    </div> 
   <?php if($groupStatistics->DisableStreamConversation==0 || Yii::app()->session['IsAdmin'] == 1){?>
   <div id="editable"  placeholder="<?php echo Yii::t('translation','New_Post'); ?>" class="placeholder inputor" data-type="group" isWebPreview="<?php echo $groupStatistics->DisableWebPreview?>" contentEditable="true" <?php if($groupStatistics->DisableWebPreview==0){?> onkeyup="getsnipetForGroup(event,this);" <?php }?> onblur="validateDescription(this)"></div><?php }?>
    <div class="control-group controlerror">  
        <?php   echo $form->error($groupPostModel, 'Description'); ?>
    </div>
    <?php   echo $form->hiddenField($groupPostModel, 'Description', array('class' => 'span12')); ?>
    <?php   echo $form->hiddenField($groupPostModel, 'Type', array('class' => 'span12')); ?>
    <?php   echo $form->hiddenField($groupPostModel, 'HashTags', array('class' => 'span12')); ?>
    <?php   echo $form->hiddenField($groupPostModel, 'Mentions', array('class' => 'span12')); ?>
    <?php   echo $form->hiddenField($groupPostModel, 'GroupId', array('class' => 'span12')); ?>
    <div  id="Groupsnippet_main" style="display:none; padding-top: 10px;padding-bottom:10px;" >
           
      </div>    
    
   <div class="row-fluid padding8top" id="surveydiv" style="display:none;">
    <div class="span12">
    <div  >
		 <div class="row-fluid ">
              <div class="span12">
              <div class="span6">
              <label><?php   echo Yii::t('translation', 'SurveyPost_OptionA_lable');?></label>
                      
              <?php   echo $form->textField($groupPostModel, 'OptionOne', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
              <div class="control-group controlerror"> 
                  <?php   echo $form->error($groupPostModel, 'OptionOne'); ?>
              </div>
              </div>
              <div class="span6">
              <label><?php   echo Yii::t('translation', 'SurveyPost_OptionB_lable');?></label>
              <?php   echo $form->textField($groupPostModel, 'OptionTwo', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
              <div class="control-group controlerror"> 
                  <?php   echo $form->error($groupPostModel, 'OptionTwo'); ?>
              </div>
              
              </div>
              </div>
              </div>
               <div class="row-fluid padding8top">
              <div class="span12">
              <div class="span6">
              <label><?php   echo Yii::t('translation', 'SurveyPost_OptionC_lable');?></label>
              <?php   echo $form->textField($groupPostModel, 'OptionThree', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
              <div class="control-group controlerror"> 
                  <?php   echo $form->error($groupPostModel, 'OptionThree'); ?>
              </div>
              
              </div>
              <div class="span6">
              <label><?php   echo Yii::t('translation', 'SurveyPost_OptionD_lable');?></label>
              <?php   echo $form->textField($groupPostModel, 'OptionFour', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
              <div class="control-group controlerror"> 
                  <?php   echo $form->error($groupPostModel, 'OptionFour'); ?>
              </div>
              
              </div>
              </div>
              </div>
              <div class="row-fluid padding8top customrow-fluid">
              <div class="span12">
                  <div id="surveyendate">
           
                <div id="dp3" class="input-append date span6" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                  <label><?php   echo Yii::t('translation', 'SurveyPost_Endtime_lable'); ?></label>
                  <?php   echo $form->textField($groupPostModel, 'ExpiryDate', array('maxlength' => '20', 'class' => 'textfield span11', 'readonly' => "true")); ?>    
                  <span class="add-on">
                      <i class="fa fa-calendar"></i>
                  </span>

                  <div class="control-group controlerror"> 
                      <?php   echo $form->error($groupPostModel, 'ExpiryDate'); ?>
                  </div>

              </div>       
                      
                  </div>
              </div>
              </div>
        
               </div>

    
    </div>
    </div>
     
    <div class="row-fluid" id="eventdiv" style="display:none" >
    <div class="span12">

         <div class="row-fluid padding8top customrow-fluid">
              <div class="span12">
               
              <div id="dpd1" class="input-append date span3" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                  <label><?php   echo Yii::t('translation', 'EventPost_Start_lable'); ?></label>
                  <?php   echo $form->textField($groupPostModel, 'StartDate', array('maxlength' => '20', 'class' => 'textfield span8', 'readonly' => "true")); ?>    
                  <span class="add-on">
                      <i class="fa fa-calendar"></i>
                  </span>

                  <div class="control-group controlerror"> 
                      <?php   echo $form->error($groupPostModel, 'StartDate'); ?>
                  </div>

              </div>

                  <div id="dpd2" class="input-append date span3" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                      <label><?php   echo Yii::t('translation', 'EventPost_Enddate_lable'); ?></label>
                      <?php   echo $form->textField($groupPostModel, 'EndDate', array('maxlength' => '20', 'class' => 'textfield span8 ', 'readonly' => "true")); ?>    
                      <span class="add-on">
                          <i class="fa fa-calendar"></i>
                      </span>
                      <div class="control-group controlerror"> 
                          <?php   echo $form->error($groupPostModel, 'EndDate'); ?>
                      </div>

                </div>
                 
                 
              
               
              <div class="input-append span3 " >
                  <span class="bootstrap-timepicker" >
                  <label><?php   echo Yii::t('translation', 'EventPost_StartTime_lable'); ?></label>
                  <?php   echo $form->textField($groupPostModel, 'StartTime', array('maxlength' => '20', 'class' => 'textfield span10  starttime', 'readonly' => "true", 'onclick' => 'setTimepicker(this);')); ?>    
                 <i class="icon-time add-on"  onclick="clickTimePicker('GroupPostForm_StartTime');" style="margin: 0px 0 0 -28.5px;cursor:pointer; position: relative;z-index:2;"></i>
                  </span>

                  <div class="control-group controlerror"> 
                      <?php   echo $form->error($groupPostModel, 'StartTime'); ?>
                  </div>

              </div>
               <div class="input-append span3 ">
                   
                   <label><?php   echo Yii::t('translation', 'EventPost_EndTime_lable'); ?></label>
                   <?php   echo $form->textField($groupPostModel, 'EndTime', array('maxlength' => '20', 'class' => 'textfield span10  endtime', 'readonly' => "true", 'onclick' => 'setTimepicker(this);')); ?>    
                   <i class="icon-time add-on"  onclick="clickTimePicker('GroupPostForm_EndTime');" style="margin: 0px 0 0 -27.5px;cursor:pointer; position: relative;z-index:2;"></i>
                   <div class="control-group controlerror"> 
                       <?php   echo $form->error($groupPostModel, 'EndTime'); ?>
                   </div>

               </div>
              </div>
              </div>
              <div class="row-fluid padding8top customrow-fluid">
                  <div class="span12">
                      <div class="span5">
                          <label><?php   echo Yii::t('translation', 'EventPost_Location_lable'); ?></label>
                          <?php   echo $form->textField($groupPostModel, 'Location', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
                          <div class="control-group controlerror"> 
                              <?php   echo $form->error($groupPostModel, 'Location'); ?>
                          </div>

                      </div>
                  </div>
              </div>

    
    </div>
    </div>
     
    </div>  
    
    
    
    <div id="preview" class="preview" style="display:none">
         <ul id="previewul">

    </ul>
    </div>
    <div class="postattachmentarea" id="button_block" style="display:none;">
        <div class="pull-left whitespace">
        	<div class="advance_enhancement">
            <ul><li class="dropdown pull-left ">
                    <div id='uploadFile' data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Upload'); ?>"></div>
                    </li>
                    <?php  if($showPostOption){?>
                   <li class="dropdown pull-left" style="white-space:nowrap">
                     <a id="drop2" style="cursor: pointer;" data-toggle="dropdown" class="tooltiplink actionmore " lass="tooltiplink" data-placement="bottom" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Advanced_Options'); ?>" ><i class="fa fa-gear"><span class="fa fa-caret-down"></span></i></a>
           <?php   $posttype= Yii::app()->session['UserPrivileges'];?>    
  <?php 
  
  if(count($posttype)>0){  ?>     
            <div class="dropdown-menu actionmorediv" >

                <ul id='postType'>
                 <?php   
                 
                  $active='0';
                     $inactive=0;
                     $class="";
                 foreach ($posttype as $key => $value) {
                   
                    
                     if($value['Status']==1){
                         $active=$active+1;
                  if($value['Action']=='Event' || $value['Action']=='Survey' ){      
                     if($value['Action']=='Event'){
                         $class="p_events";
                     }
                     else if($value['Action']=='Survey'){
                          $class="p_survey";
                     }
                     ?>
                <li id="<?php   echo $value['Action']; ?>" class=""><a ><i><img class="<?php    echo $class;?>" src="/images/system/spacer.png"></i> <?php echo Yii::t('translation',$value['Action']);?></a></li>
                     <?php    
                     }
                     } 
                 }
                  ?>
                
                </ul>

             </div>
  <?php   }?>
                    </li>
<?php  }?>
                   <?php if(Yii::app()->params['DisableComments']=='1'){?>
                    <li>
                        <?php  echo $form->hiddenField($groupPostModel, 'DisableComments',array('class'=>'idisablecomments')); ?>  
                        <i class="fa fa-comments disablecomments tooltiplink disablecomment" style="position:relative" lass="tooltiplink" data-placement="bottom" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Disable_Comment'); ?>" ></i> 
                    </li>
                    <?php }?>
                    
                    </ul>
            <?php   echo $form->hiddenField($groupPostModel,'Artifacts',array('value'=>'')); ?>
                      <?php echo $form->hiddenField($groupPostModel,'IsWebSnippetExist',array('value'=>'')); ?>
                    <?php echo $form->hiddenField($groupPostModel,'WebUrls',array('value'=>'')); ?>       
            <a ></a> <a ><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
        
        </div>
        <div class="control-group controlerror">  
    
   <?php   echo $form->error($groupPostModel, 'Artifacts'); ?>
    </div>
    <div class="pull-right">
         <?php   echo CHtml::Button(Yii::t('translation', 'Post'),array('class' => 'btn','onclick'=>'groupsend('.$groupStatistics->IsPrivate.');')); ?> 
        <?php   echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'grouppostReset','class' => 'btn btn_gray','onclick'=>'ClearGroupPostForm();')); ?>
        </div></div>
    <div ><ul class="qq-upload-list" id="uploadlist_file"></ul></div>
     
<?php $this->endWidget(); ?>
    </div>
    </div>      
         </div>
          <div id="groupstreamMainDiv" style="padding-bottom:10px;display: none;margin-top:20px" ></div> 
          
          <div id="promoteCalcDiv" style="display: none">    
            <div class="promoteCalc input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">
                <label><?php echo Yii::t('translation','Promote_till_this_date'); ?></label>
                <input type="text" class="promoteInput" readonly />
                <span class="add-on">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
          
    
   
    </div>
    <?php if($advertisementsCount!=0){?>
    <div class="sidebar-nav_right" id="groupSideBar" style="display: none" >
      <div class=""  style="text-align:center">
                <?php include 'rightSideLayoutForGroups.php'; ?>
        
            </div>
    </div>
    <?php }?>
</div>
<div>

 
</div>

   </div>
<?php } ?>
<div id="groupPostDetailedDiv" style="display: none"></div>
   <?php  include 'nodeGroupPost.php'; ?>
<script type="text/javascript">  
    <?php if($preferencesModel->RestrictedAccess == 1){ ?>
    <?php if($userAllowable == 0 && $IsnotAgroupMember == 1){ ?>
        $("#groupPostDetailedDiv").html('<ul class=" NPF"  style="height: 20px; "><center class="ndm"><?php   echo Yii::t('translation', 'Restrict_Group'); ?></center></ul>').show();
        $("#groupstreamMainDiv").hide();
        $("#SubGroups").removeAttr("onclick");
    <?php }else if($userAllowable == 1 && $IsnotAgroupMember == 1){ ?>
        $("#groupPostDetailedDiv").html('<ul class=" NPF"  style="height: 20px; "><center class="ndm"><?php   echo Yii::t('translation', 'Allowable_Restrict_Group_User'); ?></center></ul>').show();
   <?php  } ?>
    <?php } ?>
    // for mobile devices...
    $(function(){
        
        $(window).scrollEnd(function() {
            trackViews($("#groupstreamMainDiv div.post.item.groupsDiv:not(.tracked)"), "GroupStream");            
       }, 1000);
       
       
        if(detectDevices()){
           $('.menubox').each(function(){
               $(this).removeClass().addClass("menubox mobilemenubox");
           });
        }       
    });
 Custom.init();
</script>
 <script type='text/javascript'>   
    pF1 = 1;
    pF2 = 1;
//    if(typeof socketGroup !== "undefined")
//        socketGroup.emit('clearInterval',sessionStorage.old_key);
    gPage = "GroupStream";
    <?php if(empty($location) || is_numeric($location)){ ?>
     bindGroupsFollowUnFollow();
     bindClickForArtifact();   
     
     bindSubGroupsForStream();
     
       
       <?php   if(($groupStatistics->IsFollowing==1 || Yii::app()->session['PostAsNetwork']==1) && $groupStatistics->Status==1 ){?>
           $('#groupFormDiv').show();
           $('#groupstreamMainDiv').show();
           $('#conversations').show();
           $('#groupSideBar').show();
       <?php }?>           
          
      bindEventsForStream('g_mediapopup');
      bindEventsForStream('groupstreamMainDiv');
      var extensions ='"jpg","jpeg","gif","png","tiff","tif","TIF"';
    <?php   if($groupStatistics->IsGroupAdmin==1 || Yii::app()->session['PostAsNetwork']==1){?>      
      initializeFileUploader('GroupBannerImage', '/group/UploadBanner', '10*1024*1024', extensions, 1,'GroupBannerImage' ,'',GroupDBPreviewImage,displayErrorForBannerAndLogo,"uploadlist");
      initializeFileUploader('GroupLogo', '/group/UploadBanner', '10*1024*1024', extensions,1, 'GroupLogo' ,'',GroupDLPreviewImage,displayErrorForBannerAndLogo,"uploadlist_logo");
      
    <?php  }else{?>      
          $('.groupbanner.positionrelative.editicondiv').removeClass("editicondiv");
          $('.grouplogo.positionrelative.editicondiv').removeClass("editicondiv");
          
    <?php  }?>
     extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
     initializeFileUploader('uploadFile', '/group/upload', '10*1024*1024', extensions,4, 'GroupPostForm' ,'',GroupPreviewImage,appendErrorMessages,"uploadlist_file");

      getCollectionData('/group/groupStream', 'groupId=<?php   echo $groupPostModel->GroupId ?>&category=Group&StreamPostDisplayBean', 'groupstreamMainDiv', '<?php echo Yii::t('translation','No_Posts_found'); ?>',"<?php echo Yii::t('translation','Thas_all_folks'); ?>","<?php   echo $groupPostModel->GroupId ?>");


              
       
        $(document).ready(function(){    
               document.onreadystatechange = function (){
            
        if (document.readyState === "complete") {
                       var minH=$('#loadTopAds').height() + $('#loadMiddleAds').height() + $('#loadBottomAds').height()+$('#GroupBanner').height()+$('#groupProfileDiv').height()+$('.group_admin_floatingMenu').height()+100;
              var sideMenuHeight=$("#menu_bar").height();              
              if(minH!=0){
                  if(minH>sideMenuHeight){
                   $('#contentDiv').css('min-height', minH);    
                  }else{
                  $('#contentDiv').css('min-height', sideMenuHeight + 150);    
                  }
                  
              }      
            
                     }
                 }
                               
           
            
            $("#profile div a.more").click(function(){                
                 $('#groupDescription').hide();
                 $('#groupDescriptionTotal').show();
                 $("#profile div a.more").hide();
                 $("#profile div a.moreup").show();
                
            });
            $("#profile div a.moreup").click(function(){
                 $('#groupDescription').show();
                 $('#groupDescriptionTotal').hide();
                 $("#profile div a.more").show();
                 $("#profile div a.moreup").hide();
                
            });

         trackEngagementAction("Loaded","<?php   echo $groupPostModel->GroupId ?>"); 
         if(typeof io !== "undefined")
            trackBrowseDetails("http://localhost/","<?php   echo $groupPostModel->GroupId ?>"); 
        });


   
    $(function(){
        <?php if($groupStatistics->IsPrivate==0){?>
        initializationForHashtagsAtMentions('div#editable');
        <?php } else {?>
            var groupId='<?php echo $groupStatistics->GroupId?>';
            initializationForHashtagsAtMentionsForPrivateGroups('div#editable',groupId);
        <?php }?>  
        initializationForGroupArtifacts();
         initializationForGroupCalender();
         
 $("#g_mediapopup .close").live("click",     
            function() {
                $('#g_mediapopup').hide();
                if($('.jPlayer-container').length>0){
                    $('.jPlayer-container').jPlayer("destroy");
                }
            }
    );      
    });

    $("#g_mediapopup img.invite_frds").unbind( "click");
 $("#g_mediapopup img.invite_frds").bind( "click", 
        function(){
            
            var StreamId = $(this).closest('div.social_bar').attr('data-id');
            var PostId = $(this).closest('div.social_bar').attr('data-postid');
            var NetworkId = $(this).closest('div.social_bar').attr('data-networkId');
            var CategoryType = $(this).closest('div.social_bar').attr('data-categoryType');
            var item = {
                'id': StreamId,
                'PostId': PostId,
                'NetworkId': NetworkId,
                'CategoryType': CategoryType
            };
            $("#myModal_body").html($("#inviteTemplate_render").render(item));
            $("#myModalLabel").addClass("stream_title paddingt5lr10");
            $("#myModalLabel").html("Invite Others");
            $("#myModal_footer").hide();
            $("#myModal").modal('show');
            initializeAtMentions('#inviteTextArea_' + StreamId);
            
            
        });
//        $(window).bind("scroll", function()  
//       {
//           alert($(window).scrollTop())
//       });
//        
        
$("#grouphideshowid").on('click',function(){
    scrollSettoTop();
});
function scrollSettoTop(){  
          
             $("html,body").scrollTop(0);  
        }
        
   function createSubGroupHandler(data,txtstatus,xhr){       
     scrollPleaseWaitClose("groupCreationSpinner");
          var data=eval(data); 
        if(data.status =='success'){
            var msg=data.data;
            $("#sucmsgForGroupCreation").html(msg);
            $("#sucmsgForGroupCreation").css("display", "block");
            $("#errmsgForGroupCreation").css("display", "none");
            $("#subgroupcreation-form")[0].reset();
             $("#sucmsgForGroupCreation").fadeOut(3000,function(){
            $("#addNewSubGroup").hide();
        }); 
        groupsFollowing();
        }else{
            var lengthvalue=data.error.length;            
            var msg=data.data;
            var error=[];
            if(msg!=""){                
                    $("#errmsgForGroupCreation").html(msg);
                    $("#errmsgForGroupCreation").css("display", "block");
                    $("#sucmsgForGroupCreation").css("display", "none");
                    $("#errmsgForGroupCreation").fadeOut(5000);
       
            }else{
                
                if(typeof(data.error)=='string'){
                
                var error=eval("("+data.error.toString()+")");
                
            }else{
                
                var error=eval(data.error);
            }
            
            
            $.each(error, function(key, val) {
                if($("#"+key+"_em_")){  
                    $("#"+key+"_em_").text(val);                                                    
                    $("#"+key+"_em_").show();   
                    $("#"+key+"_em_").fadeOut(5000);
                   // $("#"+key).parent().addClass('error');
                }
                
            }); 
          }
        }
     }     
     function bindSubGroupsForStream(){  
    
        $("#UFSubGroup img.follow").live( "click", 
        function(){
            var groupId = $(this).closest('div.social_bar').attr('data-groupid');
            var subgroupId = $(this).closest('div.social_bar').attr('data-subgroupid');   
            followOrUnfollowSubGroup(groupId,"UnFollow",$(this),subgroupId,subgroupId);
            
             $("#groupId_"+groupId).remove();
           applyLayout();
             groupsFollowing();
          
           $(this).attr({
               "class":"unfollow" 
            });
            var groupFollowersCount = Number($('#group_followers_count_' + streamId).text());
                        groupFollowersCount--;
        }
    );
    $("#UFSubGroup img.unfollow").live( "click", 
        function(){
            var groupId = $(this).closest('div.social_bar').attr('data-groupid');
            var subgroupId = $(this).closest('div.social_bar').attr('data-subgroupid');           
            followOrUnfollowSubGroup(groupId,"Follow",$(this),subgroupId,subgroupId);
            groupsFollowing();            
            $("#subgroupId_"+subgroupId).remove();
           applyLayout();
            
            $(this).attr({
               "class":"follow" 
            });
        }
    );  
   }
   function loadIframeHeight(frameId){        
//        $('.vertical').removeClass("open");
        
        $('#'+frameId).load(function() {
                    this.style.height =
                    this.contentWindow.document.body.offsetHeight+Number(100) +'px';
            
                });
                
    }
    <?php } ?>
<?php if($hybrid== 1){?>
   $("#SubGroups").hide();
   <?php } ?>
       
   <?php if(empty($location) || is_numeric($location)){ ?>
       $("ul.topmenu li a").live("click",function(){ 
       var location = $(this).data('location');       
       <?php if($customGroupName == "ANPF"){ ?>
               $("#bioiframe").attr("style","height:1200px").show();
       <?php }else if($customGroupName == "Janssen"){?>           
           $("#bioiframe").attr("style","height:1200px").show(); 
        <?php }else if($customGroupName == "CRN"){?> 
            $("#bioiframe").attr("style","height:1300px").show();
       <?php }else{ ?>
           //$("#bioiframe").attr("style","height:1300px").show();
       <?php } ?> 
           loadIframeHeight("bioiframe");
           $("#bioiframe").show();
       $("#GroupTotalPage,#custommenu").hide();
       $("#bioiframe").attr("src","/customgroups/<?php echo $customGroupName;?>/"+location);
       
   });
   <?php }else{
       $location = str_replace(",$","",rtrim(strip_tags($location)));         
        if(strpos($location,'.')){
            $locArr = explode(".",$location);
            $location = $locArr[0];
        }else if(strpos($location,' ')){            
            $locArr = explode(" ",$location);
            $location = $locArr[0];
        } ?>
         $("#bioiframe").attr("style","height:1000px").show();
         $("#bioiframe").attr("src","/customgroups/<?php echo $customGroupName."/".$location.".php";?>");
        
      <?php } ?>  
   
   $("ul.topmenu li a").each(function(){
       
      var url = $(this).attr("href");
      $(this).attr("data-location",url);
      $(this).attr("href","#");
   });
   
    $("#SubGroupCreationForm_SubGroupName").bind('keypress',function(){
        var value = $(this).val();
        $("#hiddengroupnamediv").html(value);
        sessionStorage.GroupName = $("#hiddengroupnamediv").text();
    }).bind('blur',function(){
        var value = $(this).val();
        $("#hiddengroupnamediv").html(value);
        sessionStorage.GroupName = $("#hiddengroupnamediv").text();
    });
  $("#groupnamehtml").live('click',function(){
        var text = $("#GroupCreationForm_GroupName").val();
        sessionStorage.GroupName = text;
//        var html = $.parseHTML( text );   
        $("#hiddengroupnamediv").text(text);
        $("#hiddengroupnamediv").html($("#hiddengroupnamediv").text());        
        var html = $("#hiddengroupnamediv").text();
//        $("#GroupCreationForm_GroupName").val(html);
        if(text != "")
            $("#typeheadstyle").html('<li class="" data-value="Florida" style="cursor:pointer">'+html+'</li>').show();

  });
  $("#typeheadstyle").bind('click',function(){
    var hValue = $(this).html();
    var html = $("#hiddengroupnamediv").html($("#hiddengroupnamediv").text()).text();
    $("#SubGroupCreationForm_SubGroupName").val(html);
    $(this).hide();
});
$("#addNewSubGroup").bind("click",function(){
     $("#typeheadstyle").hide();
});
  </script>
         
<?php }else{?>
  <div class="row-fluid">
    <div class="span12" style="text-align:center;">
        <img src="/images/system/groupisinactive.png" />        
    </div>
</div>
  
<?php } ?>
