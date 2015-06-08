<?php include 'snippetDetails.php'?>
<div  class="poststreamwidget" id="groupFormDiv" >
        
        
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
   <?php if($DisableStreamConversation==0 || Yii::app()->session['IsAdmin'] == 1){?>
    <div id="editable"  placeholder="New Post" class="placeholder inputor" data-type="group" contentEditable="true" <?php if($DisableWebPreview==0){?> onkeyup="getsnipetForGroup(event,this);" <?php }?>  onblur="validateDescription(this)"></div><?php }?>
    <div class="control-group controlerror">  
        <?php   echo $form->error($groupPostModel, 'Description'); ?>
    </div>
    <?php   echo $form->hiddenField($groupPostModel, 'Description', array('class' => 'span12')); ?>
    <?php   echo $form->hiddenField($groupPostModel, 'Type', array('class' => 'span12')); ?>
    <?php   echo $form->hiddenField($groupPostModel, 'HashTags', array('class' => 'span12')); ?>
    <?php   echo $form->hiddenField($groupPostModel, 'Mentions', array('class' => 'span12')); ?>
    <?php   echo $form->hiddenField($groupPostModel, 'GroupId', array('class' => 'span12')); ?>
    <?php   echo $form->hiddenField($groupPostModel, 'UserId', array('class' => 'span12')); ?>
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
    
    <div id="kolpostdiv">
        <div class="row-fluid paddingtop6">
                <div class="span4 paddingtop6">            
                    <div class="positionrelative paddingL30 " id="kolcheckboxd"> 
                        <div class="positionabsolutediv" style="left:0;top:-2px">
                            <?php echo $form->hiddenField($groupPostModel,'Miscellaneous'); ?>
                        <input type="checkbox" id="kol_checkbox" class="styled" />
                        </div>
                        <label class="marginbottom10"><?php echo Yii::t('translation','KOL_POST'); ?></label>
                        
                        
                        
                </div>
                </div>
            <div class="span8" id="koluserdiv" style="display:none">
                <?php   echo $form->textField($groupPostModel, 'KOLUser', array("data-placement"=>"bottom","rel"=>"tooltip","data-original-title"=>Yii::t('translation','KOL_UserText'),'maxlength' => '5', 'class' => 'textfield span12',"placeholder" => Yii::t('translation','KOL_UserText'),"id"=>"koluser")); ?>    
                <div class="control-group controlerror marginbottom20 " >

                        <?php echo $form->error($groupPostModel,'KOLUser'); ?>

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
                <li id="<?php   echo $value['Action']; ?>" class=""><a ><i><img class="<?php    echo $class;?>" src="/images/system/spacer.png"></i> <?php   echo $value['Action'];?></a></li>
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
         <?php   echo CHtml::Button(Yii::t('translation', 'Post'),array('class' => 'btn','onclick'=>'groupsend('.$IsPrivateGroup.');')); ?> 
        <?php   echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'grouppostReset','class' => 'btn btn_gray','onclick'=>'ClearGroupPostForm();')); ?>
        </div></div>
    <div>
                    <ul class="qq-upload-list" id="uploadlist_iframe"></ul>
                </div>
     
<?php $this->endWidget(); ?>
    </div>
    </div>  
         </div>
<script type="text/javascript">
    $(document).ready(function(){
       Custom.init();
        $("[rel=tooltip]").tooltip();
        $("#kolcheckboxd span.checkbox").unbind("click").bind("click",function(){        
            var $this = $(this);
            var checked = 0;
            if($this.attr("style") == "background-position: 0px -50px;"){            
                checked = 1;
                $("#koluserdiv").show();
            }else{
                $("#koluserdiv").hide();
            }
            $("#GroupPostForm_Miscellaneous").val(checked);
        });        
        $("#koluser").bind("keyup",function(e){              
            if(IsUserExist == 0){
                $("#GroupPostForm_UserId").val("");
            }
            if(e.keyCode == 8){
                globalspace['at_mention_koluser']=new Array();  
                IsUserExist = 0;
                
            }            
        });
      
    });
    
    $("#editable").bind('paste', function (event) {
 var $this = $(this); //save reference to element for use laster
 setTimeout(function(){ //break the callstack to let the event finish
   //  var strippedText = strip_tags($this.html(),'<p><pre><span><i><b><li></li><ul></ul>');

if ($this.attr('name') == 'curbsideEditablediv') {
    var strippedText = strip_tags($this.html(), '<p><pre><span><i><b><li></li><ul></ul><u></u><strike></strike><ol></ol>');
} else {
    var strippedText = strip_tags($this.html(), '<p><pre><span><i><b>');
}
   
 $this.html(strippedText) ;
 $this.find('*').removeAttr('style');
 var result = $('#editable');
    result.focus();
    placeCaretAtEnd( document.getElementById("editable") );

},0); 
    });
     initializationForGroupArtifacts();
     initializationForAtMentionsForGroups('#koluser',"<?php echo $groupId?>");
     <?php if($IsPrivateGroup==0){?>
        initializationForHashtagsAtMentions('div#editable');
        <?php } else {?>
            var groupId='<?php echo $groupId?>';
            initializationForHashtagsAtMentionsForPrivateGroups('div#editable',groupId);
        <?php }?> 
       
         initializationForGroupCalender();
         $('.datepicker').css({'z-index':'9999'});
        
//         $('.timepicker-popup select').css({'z-index':'9999'});
//         $('.timepicker-popup-hour').css({'z-index':'999999'});
         
            $('#timepicker-popup').css({'z-index':'1060'});
           
         var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
     initializeFileUploader('uploadFile', '/group/upload', '10*1024*1024', extensions,4, 'GroupPostForm' ,'',GroupPreviewImage,appendErrorMessages,"uploadlist_iframe");
    </script>