

<?php
try{
$posttype = Yii::app()->session['UserPrivileges'];?>
<?php include 'miniProfileScript.php'; ?>
<?php include 'hashTagProfileScript.php'; ?>
<?php include 'snippetDetails.php'?>
<?php include 'commentscript.php'; ?>
<?php include 'commentscript_instant.php'; ?>
<?php include 'detailedcommentscript.php'; ?>
<?php include 'inviteScript.php'; ?>
   <div id="poststreamwidgetdiv">
<?php if(Yii::app()->params['Project']!='SkiptaNeo'){?>

 <?php if(isset($featuredItems) && $featuredItems!='failure'){?>
    <div id="GalleryDiv" style="display: none">
        <div class="galleria">
         <?php foreach($featuredItems as $featured){
                             if($featured['ArtifactIcon']!='') {?>
            <a style="display: none;cursor: pointer" href="<?php echo str_replace('/thumbnails','/images',$featured['ArtifactIcon'])?>" data-original="<?php echo Yii::app()->request->baseUrl; ?>/post/renderPostDetailed?load=<?php echo $featured['CategoryType']."_".$featured['PostId']."_".$featured['PostType']?>" data-thumb="<?php echo $featured['ArtifactIcon']?>" data-categoryType="<?php echo $featured['CategoryType']?>" data-postId="<?php echo $featured['PostId'] ?>" data-postType="<?php echo $featured['PostType']?>"><?php echo strip_tags($featured['PostText']);?></a>
                           <?php }} ?>
        </div>
    </div>
 <?php }?>

       <?php if(isset($featuredItems) && $featuredItems!='failure'){?>
     <div class="rightwidget  paddingt12 groupseperator padding-bottom30 margintopzero">

        <div class="rightwidgettitle paddingleft10 ">
            <div class="positionrelative"><div><i class="spriteicon"><img src="/images/system/spacer.png" class="r_featurednews"></i><span class="widgettitle"><?php echo Yii::t('translation','Featured_Items'); ?> </span></div> 
                 <!-- replace class "fa fa-question" with  "fa fa-video-camera videohelpicon" if we have description and video remaining will be same-->
                <i class="fa fa-question helpicon helpmanagement top6  tooltiplink" data-id="FeaturedItems_DivId" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Featured_Items'); ?>"></i></div>
            
        </div>
        <div class="border3">
            
            <div id="FeaturedItemsGallery">
                
            </div>

        </div> 
        </div>
<?php }?>
       
<?php }?>  
    
    <div class="poststreamwidget">
        <div id="postSpinLoader" style="position:relative;"></div>
        
    <div class="row-fluid">
    <div class="span12">
      
    <div class="alert alert-error" id="errmsgForStream" style='padding-top: 5px;display: none'>  </div>
    <div class="alert alert-success" id="sucmsgForStream" style='padding-top: 5px;display: none'></div> 
 <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'normalPost-form',
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
   <div class="headerpoptitle_white" style="display:none" id="survey_header"><?php echo Yii::t('translation', 'SurveyPost_heading_lable');?> <i data-id="StreamSurvey_DivId" class="fa fa-question helpmanagement helpicon top10"></i></div>
   <div class="headerpoptitle_white" style="display:none" id="event_header"><?php echo Yii::t('translation', 'EventPost_heading_lable');?> <i data-id="StreamEvent_DivId" class="fa fa-question helpmanagement helpicon top10"></i></div>
   <div id="NormalPostForm_Survey_Options_em_" class="alert alert-error " style="display: none;"></div>
   <div id="surveyeventtitledescription" style="display:none">
   <div class="row-fluid padding8top padding-bottom10 customrow-fluid">
                  <div class="span12">
                     
                          <label><?php echo Yii::t('translation','Title'); ?></label>
                          <?php echo $form->textField($normalPostModel, 'Title', array('maxlength' => '40', 'class' => 'textfield span12')); ?>    
                          <div class="control-group controlerror"> 
                              <?php echo $form->error($normalPostModel, 'Title'); ?>
                          </div>

                  </div>
              </div>
 <div class="row-fluid  customrow-fluid" >
                  <div class="span12" style="min-height:25px">
                     
                         <label style="margin-bottom:0"><?php echo Yii::t('translation','Description'); ?></label>
                         

                  </div>
              </div>
    </div> 
   <div id="numero2" > <div id="editable"  placeholder="<?php echo Yii::t('translation','new_post_placeholder'); ?>" class="placeholder inputor"  contentEditable="true" onkeyup="getsnipet(event,this);" onblur="validateDescription(this)"></div></div>
    <div class="control-group controlerror">  
        <?php echo $form->error($normalPostModel, 'Description'); ?>
    </div>
    <?php echo $form->hiddenField($normalPostModel, 'Description', array('class' => 'span12')); ?>
    <?php echo $form->hiddenField($normalPostModel, 'Type', array('class' => 'span12')); ?>
    <?php echo $form->hiddenField($normalPostModel, 'HashTags', array('class' => 'span12')); ?>
    <?php echo $form->hiddenField($normalPostModel, 'Mentions', array('class' => 'span12')); ?>
    <div  id="snippet_main" style="display:none; padding-top: 10px;padding-bottom:10px;" >
           
      </div>    
    
   <div class="row-fluid padding8top" id="surveydiv" style="display:none;">
    <div class="span12">
    <div  >
		 <div class="row-fluid ">
              <div class="span12">
              <div class="span6">
              <label><?php echo Yii::t('translation', 'SurveyPost_OptionA_lable');?></label>
                      
              <?php echo $form->textField($normalPostModel, 'OptionOne', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
              <div class="control-group controlerror"> 
                  <?php echo $form->error($normalPostModel, 'OptionOne'); ?>
              </div>
              </div>
              <div class="span6">
              <label><?php echo Yii::t('translation', 'SurveyPost_OptionB_lable');?></label>
              <?php echo $form->textField($normalPostModel, 'OptionTwo', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
              <div class="control-group controlerror"> 
                  <?php echo $form->error($normalPostModel, 'OptionTwo'); ?>
              </div>
              
              </div>
              </div>
              </div>
               <div class="row-fluid padding8top">
              <div class="span12">
              <div class="span6">
              <label><?php echo Yii::t('translation', 'SurveyPost_OptionC_lable');?></label>
              <?php echo $form->textField($normalPostModel, 'OptionThree', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
              <div class="control-group controlerror"> 
                  <?php echo $form->error($normalPostModel, 'OptionThree'); ?>
              </div>
              
              </div>
              <div class="span6">
              <label><?php echo Yii::t('translation', 'SurveyPost_OptionD_lable');?></label>
              <?php echo $form->textField($normalPostModel, 'OptionFour', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
              <div class="control-group controlerror"> 
                  <?php echo $form->error($normalPostModel, 'OptionFour'); ?>
              </div>
              
              </div>
              </div>
              </div>
              <div class="row-fluid padding8top customrow-fluid">
              <div class="span12">
                  <div id="surveyendate">
             
              
             
                      
               <div id="dp3" class="input-append date span6" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                  <label><?php echo Yii::t('translation', 'SurveyPost_Endtime_lable'); ?></label>
                  <?php echo $form->textField($normalPostModel, 'ExpiryDate', array('maxlength' => '20', 'class' => 'textfield span11', 'readonly' => "true")); ?>    
                  <span class="add-on">
                      <i class="fa fa-calendar"></i>
                  </span>

                  <div class="control-group controlerror"> 
                      <?php echo $form->error($normalPostModel, 'ExpiryDate'); ?>
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

                  <label><?php echo Yii::t('translation', 'EventPost_Start_lable'); ?></label>
                  <?php echo $form->textField($normalPostModel, 'StartDate', array('maxlength' => '20', 'class' => 'textfield span8', 'readonly' => "true")); ?>    
                  <span class="add-on">
                      <i class="fa fa-calendar"></i>
                  </span>

                  <div class="control-group controlerror"> 
                      <?php echo $form->error($normalPostModel, 'StartDate'); ?>
                  </div>

              </div>

                  <div id="dpd2" class="input-append date span3" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                      <label><?php echo Yii::t('translation', 'EventPost_Enddate_lable'); ?></label>
                      <?php echo $form->textField($normalPostModel, 'EndDate', array('maxlength' => '20', 'class' => 'textfield span8 ', 'readonly' => "true")); ?>    
                      <span class="add-on">
                          <i class="fa fa-calendar"></i>
                      </span>
                      <div class="control-group controlerror"> 
                          <?php echo $form->error($normalPostModel, 'EndDate'); ?>
                      </div>

                </div>
                 
                 
              
              <div class="input-append span3 " >
                  <span class="bootstrap-timepicker" >
                  <label><?php echo Yii::t('translation', 'EventPost_StartTime_lable'); ?></label>
                  <?php echo $form->textField($normalPostModel, 'StartTime', array('maxlength' => '20', 'class' => 'textfield span10  starttime', 'readonly' => "true", 'onclick' => 'setTimepicker(this);')); ?>    
                  <i class="icon-time add-on"  onclick="clickTimePicker('NormalPostForm_StartTime');" style="margin: 0px 0 0 -28.5px;cursor:pointer; position: relative;z-index:2"></i>
                  </span>

                  <div class="control-group controlerror"> 
                      <?php echo $form->error($normalPostModel, 'StartTime'); ?>
                  </div>

              </div>
               <div class="input-append span3 ">
                   
                   <label><?php echo Yii::t('translation', 'EventPost_EndTime_lable'); ?></label>
                   <?php echo $form->textField($normalPostModel, 'EndTime', array('maxlength' => '20', 'class' => 'textfield span10  endtime', 'readonly' => "true", 'onclick' => 'setTimepicker(this);')); ?>    
                    <i class="icon-time add-on"  onclick="clickTimePicker('NormalPostForm_EndTime');" style="margin: 0px 0 0 -27.5px;cursor:pointer; position: relative;z-index:2;"></i>
                   <div class="control-group controlerror"> 
                       <?php echo $form->error($normalPostModel, 'EndTime'); ?>
                   </div>

               </div>
              </div>
              </div>
              <div class="row-fluid padding8top customrow-fluid">
                  <div class="span12">
                      <div class="span5">
                          <label><?php echo Yii::t('translation', 'EventPost_Location_lable'); ?></label>
                          <?php echo $form->textField($normalPostModel, 'Location', array('maxlength' => '50', 'class' => 'textfield span12')); ?>    
                          <div class="control-group controlerror"> 
                              <?php echo $form->error($normalPostModel, 'Location'); ?>
                          </div>

                      </div>
                  </div>
              </div>

    
    </div>
    </div>
     
    </div>  
    
    
    <div id="ArtifactSpinLoader_uploadfile"></div>
    <div id="preview_NormalPostForm" class="preview" style="display:none">
         
         <ul id="previewul_NormalPostForm">

    </ul>
        
    </div>
    
<!--<div id="progress_stripped" style="display:none;">
    <div class="progress progress-success progress-striped"  >
<div class="bar" style="width: 0%" id="p_bar"></div>
</div>
    </div>-->


    <div class="postattachmentarea" id="button_block" style="display:none;">
        <div class="pull-left whitespace">
        	<div class="advance_enhancement">
            <ul><li class="dropdown pull-left ">
                    <div id="uploadfile" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Upload'); ?>"></div>
                    </li>
                     <?php  if($showPostOption){?>
                   <li class="dropdown pull-left" style="white-space:nowrap;cursor:pointer;">
                     <a id="drop2" data-toggle="dropdown" class="tooltiplink actionmore "  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Advanced_Options'); ?>" ><i class="fa fa-gear"><span class="fa fa-caret-down"></span></i></a>
                 <?php if(count($posttype)>0){?>     
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
                <li id="<?php echo $value['Action']; ?>" class="" data-postType="<?php echo $value['Action'];?>"><a><i><img class="<?php  echo $class;?>" src="/images/system/spacer.png"></i> <?php echo Yii::t('translation',$value['Action']);;?></a></li>
                     <?php  
                     }
                     } 
                 }
                  ?>
                <?php if(Yii::app()->params['Project']=='SkiptaNeo'){?>
<!--                   <li id="Anonymous Post" class=""><a href="#"><i><img class="p_anonymous" src="/images/system/spacer.png"></i> Post As Anonymous</a></li>-->
                <?php }?>
                </ul>

             </div>
                     <?php }?>
                    </li>
                     <?php }?>
                      <?php if(Yii::app()->params['DisableComments']=='1'){?>
                   <li class="pull-left">
                        <?php echo $form->hiddenField($normalPostModel, 'DisableComments',array('class'=>'idisablecomments')); ?>  
                        <i class="fa fa-comments disablecomments tooltiplink disablecomment" style="position:relative"  data-placement="bottom" rel="tooltip" data-original-title=" <?php echo Yii::t('translation','Disable_Comment'); ?>" ></i> 
                    </li>
                 <?php }?>
                   <?php if($canFeatured==1){?>
                    <li class="dropdown pull-left ">
                       <?php echo $form->hiddenField($normalPostModel, 'IsFeatured',array('class'=>'iisfeatured')); ?>
                       <?php echo $form->hiddenField($normalPostModel, 'FeaturedTitle',array('id'=>'FeaturedTitleHidden')); ?>  
                        <i id="isfeaturedI" class="featureditemdisable isdfeatured"  ><img class="tooltiplink" data-placement="bottom" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Mark_As_Featured'); ?>" src="/images/system/spacer.png" /> </i>
                    </li>
                   <?php } ?>
                     <?php //if($canFeatured==1){?>
                    <li>
                       <?php echo $form->hiddenField($normalPostModel, 'IsAnonymous',array('class'=>'iisAnonymous')); ?>                       
                        <i id="isAnonymousI" class="anonymousdisable isAnonymous"  ><img class="tooltiplink" id="anonymousId" data-placement="bottom" rel="tooltip" data-original-title="Post As Anonymous" src="/images/system/spacer.png" /> </i>
                    </li>
                   <?php //} ?>
                    </ul>
                    
            <?php echo $form->hiddenField($normalPostModel,'Artifacts',array('value'=>'')); ?>
            <?php echo $form->hiddenField($normalPostModel,'IsWebSnippetExist',array('value'=>'')); ?>
            <?php echo $form->hiddenField($normalPostModel,'WebUrls',array('value'=>'')); ?>
            <a></a> <a><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
        </div>
        
        <div class="control-group controlerror controlerrornowrap">  
    
   <?php echo $form->error($normalPostModel, 'Artifacts'); ?>
    </div>
        
    <div class="pull-right">
         <?php echo CHtml::Button(Yii::t('translation', 'Post'),array('class' => 'btn','onclick'=>'send();')); ?> 
        <?php echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'postReset','class' => 'btn btn_gray','onclick'=>'ClearPostForm();')); ?>
        </div>
        
    </div>
<div id="appendlist"><ul class="qq-upload-list" id="uploadlist"></ul></div>

     </div>
<?php $this->endWidget(); ?>
    </div>
    </div> 

  <div class="groupseperator">
      
   <div id="numero1"><!-- This id numero1 is used for Joyride help -->
    <h2 class="pagetitle positionrelative searchfiltericon"><?php echo Yii::t('translation','Stream'); ?>   
         <?php if(Yii::app()->params['Project']!='SkiptaNeo'){?>
        <div class="filter_actions">
            <i data-placement="right" data-toggle="dropdown" class="fa fa-chevron-down"></i>
            <i data-placement="right" data-toggle="dropdown" class="fa fa-chevron-up"></i>
            <div class="dropdown-menu ">
                <?php if(Yii::app()->params['Project']=='RiteChat'){?>
                 <ul class="PostManagementActionsFilter">
                   <li><a class="Filter"><?php echo Yii::t('translation', 'Filter'); ?></a></li> 
                   <?php if($userHierarchy['Division']!=0 || $userHierarchy['Region']!=0 || $userHierarchy['District']!=0 || $userHierarchy['Store']!=0){ ?>
                        <?php if($userHierarchy['Division']!=0){ ?> 
                             <li><a class="Division" ><?php echo Yii::t('translation', 'Division'); ?></a></li>        
                        <?php } ?>
                        <?php if($userHierarchy['Region']!=0){ ?> 
                             <li><a class="Region"><?php echo Yii::t('translation', 'Region'); ?> </a></li>  
                        <?php } ?>
                        <?php if($userHierarchy['District']!=0){ ?> 
                             <li><a class="District"><?php echo Yii::t('translation', 'District'); ?></a></li>
                        <?php } ?>
                        <?php if($userHierarchy['Store']!=0){ ?> 
                             <li><a class="Store"><?php echo Yii::t('translation', 'Store'); ?></a></li>
                        <?php } ?>
                    <?php } ?>
                    <li><a class="Corporate"><?php echo Yii::t('translation', 'Corporate'); ?></a></li>
                      </ul>
                <?php }?>
                 <?php if(Yii::app()->params['Project']=='Trinity'){?>
                 <ul class="PostManagementActionsFilter">
                   <li><a class="Filter"><?php echo Yii::t('translation', 'Filter'); ?></a></li> 
                   <?php if($userHierarchy['Division']!=0 || $userHierarchy['Region']!=0 || $userHierarchy['District']!=0 || $userHierarchy['Store']!=0){ ?>
                        <?php if($userHierarchy['Division']!=0){ ?> 
                             <li><a class="Division" ><?php echo "Show My ".$userHierarchy['Type'] ?></a></li>        
                        <?php } ?>
                        <?php } ?>
                    <li><a class="Corporate"><?php echo Yii::t('translation', 'Corporate'); ?></a></li>
                 </ul>
                 <?php }?>
               
            </div>
        </div>
         <?php }?>
         <!--replace class "fa fa-question" with  "fa fa-video-camera videohelpicon" if we have description and video remaining will be same-->
         <i class="fa fa-question helpmanagement helpicon top10  tooltiplink" style="font-weight: normal" data-id="Stream_DivId" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Stream'); ?>" ></i></h2>
    </div>
      
  </div>
    <!-- stream -->
     
    <div id="streamMainDiv" style="padding-bottom:10px;margin-top:20px"></div>
    <!-- end stream -->
    </div>
    <!-- post detailed page-->
    <div id="streamDetailedDiv" style="display: none"></div>
    <!-- end post detailed -->
     <div id="promoteCalcDiv" style="display: none">    
        <div class="promoteCalc input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">
            <label><?php echo Yii::t('translation','Promote_till_this_date'); ?></label>
            <input type="text" class="promoteInput" readonly />
            <span class="add-on">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
  
<?php  include 'nodePost.php';?>
    <style>
    .galleria{height: 400px;}
</style>
<script type="text/javascript">   
    pF1 = 1;
    pF2 = 1;    
    gPage = "HomeStream";    
      var timeS = [];
      var tIndex = i = 0;
      var isScriptAdded = 0;
      var pauseLength = 0;
      var slideQty = 0;
      
    $(function(){
    <?php if(Yii::app()->params['Pictocv']=='ON'){?>
        var pictocvTime = 30000;
        var pivtocvObj = {uniquekey:sessionStorage.old_key,pageName:gPage,pictocvTime:pictocvTime};
        socketNotifications.emit('getPictocvImages', loginUserId,JSON.stringify(pivtocvObj),"sSetInterval");
        loadUserAchievementProgress();
    <?php } ?>
        getCollectionData('/post/stream', 'StreamPostDisplayBean', 'streamMainDiv', "<?php echo Yii::t('translation','No_Posts_found'); ?>","<?php echo Yii::t('translation','Thas_all_folks'); ?>");
       $(window).scrollEnd(function() {
            trackViews($("#streamMainDiv div.post.item:not(.tracked)"), "Stream"); 
       }, 1000);
        if(!detectDevices()){
            if(sessionStorage.sharedURL != undefined && sessionStorage.sharedURL != "" && sessionStorage.sharedURL != null){
                var shareurl=sessionStorage.sharedURL;
                sessionStorage.sharedURL="";
                window.location = shareurl;
           
            }
            $("[rel=tooltip]").tooltip();
        }
        <?php if(Yii::app()->params['Project']!='SkiptaNeo'){?>
          <?php if(isset($featuredItems) && $featuredItems!='failure'){?>
    <?php if(isset($featuredItems) && $featuredItems!='failure'){?>
            Galleria.loadTheme('<?php echo Yii::app()->request->baseUrl; ?>/js/galleria.classic.min.js'); 
            globalspace.featuredItems=1;
            loadGalleria();

    <?php }}?>
        <?php }?>
        var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","TIF","tif"';
        initializeFileUploader('uploadfile', '/post/upload', '10*1024*1024', extensions,'4', 'NormalPostForm' ,'',previewImage,appendErrorMessages,"uploadlist");
        initializationForHashtagsAtMentions('div#editable');
        initializationForArtifacts();
        bindEventsForStream('streamMainDiv');
        bingGroupsIntroPopUp();
        
    if(!detectDevices())
            $("[rel=tooltip]").tooltip();
    initializationEvents();
   
     
        trackEngagementAction("Loaded","",1); 
    });
    $(document).ready(function(){
        var settingsOps;
        var slider;
    });
</script>
<?php }catch(Exception $e){
     error_log("@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@".$e->getMessage()) ;   
} ?>