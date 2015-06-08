<?php include 'CategoriesAndHashtags.php'?> 
 <?php include 'miniProfileScript.php'; ?>
<?php include 'hashTagProfileScript.php'; ?>
<?php include 'snippetDetails.php'?>
<?php include 'commentscript.php'; ?>
<?php include 'detailedcommentscript.php'; ?>
<?php include 'inviteScript.php'; ?>

        
        <div id="curbsidePostCreationdiv">
             
     <div class="alert alert-error" id="errmsgForStream" style='padding-top: 5px;display: none'>  </div>
    <div class="alert alert-success" id="sucmsgForStream" style='padding-top: 5px;display: none'></div>      
     <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'curbsidePost-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),

        'htmlOptions' => array(
            'style' => 'margin: 0px; accept-charset=UTF-8',
        ),
    ));
    ?>
      
    <div  class="crubsidenew">
    <div class="row-fluid curbsidediv  padding-bottom10">
     <div class="span12">
     <div class="span7" id='numero1'><!-- This id numero1 is used for Joyride help -->
        
        <?php echo $form->textField($CurbsidePostModel, 'Subject', array("id" => "CurbsidePostForm_Subject", 'maxlength' => '50', 'class' => 'textfield span12', 'placeholder' =>Yii::t('translation','Curbside_Post_Subject'))); ?>    
        <div class="control-group controlerror"> 
 <?php echo $form->error($CurbsidePostModel, 'Subject'); ?>
    </div>
     </div>
     <div class="span5 positionrelative" id="curbsidedropdown">
          <?php  $name=Yii::t('translation', 'CurbsideConsultCategory');?>
         <select name="CurbsidePostForm[Category]"  id="CurbsidePostForm_Category" class="selectpicker remove-example styled span12 textfield tooltiplink" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $name?>">
              <option   value=""> <?php echo Yii::t('translation','Curbside_Post_Select_Category'); ?> </option>
                    <?php 
                        foreach ($categories as $key => $value) {
                                   echo '<option   value="'.$value['Id'].'">'.$value['CurbsideCategory'].'</option>';      
                                    }
                    ?>
                   </select>
          <div class="control-group controlerror">  
                <?php echo $form->error($CurbsidePostModel, 'Category'); ?>   
          </div> 
     </div>     
     </div>
     
     </div>
    
    <div id="curbsidepostSpinLoader"></div>
    <div id="ArtifactSpinLoader_uploadfile"></div>
    <div class="poststreamwidget ">
    	
    <div class="row-fluid">
    <div class="span12">
        
      <div id="editable"  name="curbsideEditablediv"  placeholder="<?php echo Yii::t('translation','New_Post'); ?>" class="placeholder inputor" contentEditable="true" onkeyup="getsnipet(event,this);" onblur="validateDescription(this)"> </div>
  <div class="control-group controlerror">  
    
   <?php echo $form->error($CurbsidePostModel, 'Description'); ?>
    </div>
    
    <?php echo $form->hiddenField($CurbsidePostModel, 'Description', array('value' => '')); ?>
    <?php echo $form->hiddenField($CurbsidePostModel, 'Type', array('value' => '')); ?>
    <?php echo $form->hiddenField($CurbsidePostModel, 'HashTags', array('value' => '')); ?>
    <?php echo $form->hiddenField($CurbsidePostModel, 'Mentions', array('value' => '')); ?>
     <div  id="snippet_main" style="display:none; padding-top: 10px;padding-bottom:10px;" >
           
      </div> 
      <div id="preview_CurbsidePostForm" class="preview" style="display:none">
         <ul id="previewul_CurbsidePostForm">

    </ul>
    </div>
 <div class="postattachmentarea" id="button_block" style="display:none;">
        <div class="pull-left whitespace">
        	<div class="advance_enhancement">
            <ul><li class="dropdown pull-left ">
                    <div id="uploadfile" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Upload'); ?>"></div>
                    </li>
                     <?php if($canFeatured==1){?>
                  <li class="pull-left">
                       <?php echo $form->hiddenField($CurbsidePostModel, 'IsFeatured',array('class'=>'iisfeatured')); ?>  
                       <?php echo $form->hiddenField($CurbsidePostModel, 'FeaturedTitle',array('id'=>'FeaturedTitleHidden')); ?>    
                      <i id="isfeaturedI" class="tooltiplink featureditemdisable isdfeatured"  data-placement="bottom" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Mark_As_Featured'); ?>"><img src="/images/system/spacer.png" /> </i>
                    </li>
                       <?php } ?>
                     <li><a><i><img class=" p_anonimous" src="/images/system/spacer.png"></i></a></li>
                    </ul>
            <?php echo $form->hiddenField($CurbsidePostModel,'Artifacts',array('value'=>'')); ?>
             <?php echo $form->hiddenField($CurbsidePostModel,'IsWebSnippetExist',array('value'=>'')); ?>
             <?php echo $form->hiddenField($CurbsidePostModel,'WebUrls',array('value'=>'')); ?>       
            <a></a> <a><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
        </div>
     <div class="control-group controlerror">  
    
   <?php echo $form->error($CurbsidePostModel, 'Artifacts'); ?>
    </div>
    <div class="pull-right">
         <?php echo CHtml::Button(Yii::t('translation', 'Post'),array('class' => 'btn','onclick'=>'CurbsidePostsend();')); ?> 
        <?php echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'forgotReset','class' => 'btn btn_gray','onclick'=>'ClearCurbPostForm();')); ?>
        </div></div>
      <div id="appendlist"><ul class="qq-upload-list" id="uploadlist"></ul></div>
    </div>
       
    </div>
    </div>
    </div>
    
     <?php $this->endWidget(); ?>
    <div class="groupseperator">
        <?php $name = Yii::t('translation', 'CurbsideConsult'); ?>
        <div class="pagetitle positionrelative" style="text-align: left"><?php echo $name ?>
            
            <div style=" display:none; top:-4px;" class="curbside_category curbsideTopicFilter" id="categoryClickedDiv">
               
            </div>
            
            <div class="filtericondiv" >
                <!-- This id numero2 is used for Joyride help --><div id="numero2" data-target="#crubsidefilter"  data-toggle="collapse" class="btn_toggle positionrelative"><i class="fa fa-chevron-down" id="c_filteractive" onclick="filtericonchange(this.id);" ></i><i style="display:none" class=" fa fa-chevron-up" id="c_filterinactive" onclick="filtericonchange(this.id);"></i></div>
            </div><i data-id="CurbsidePosts_DivId" class="fa fa-question helpicon helpmanagement top10  tooltiplink" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $name ?>"></i>
        </div>
    </div> 
    <div class="collapse " id="crubsidefilter">
    <div class="positionrelative padding-bottom5">
       
        <div id="categoriesandhashtagdiv">
 
    </div>
       <div class="categorymemenuhelp alignright tooltiplink" style="display:none;padding-top: 5px;"> <a  class="detailed_close " > <?php echo Yii::t('translation','REMOVE_FILTERS'); ?></a> </div>
    </div>
             </div>
    <div id="curbsidePostsDiv" style="display:block;margin-top:20px"></div>
    <div id="CategoryPostsDiv" style="display:none;margin-top:20px"></div>
    </div>
     <!-- curbside detailed page-->
    <div id="curbsideStreamDetailedDiv" style="display: none"></div>
    <!-- end curbside detailed -->
    <div id="promoteCalcDiv" style="display: none">    
        <div class="promoteCalc input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">
            <label><?php echo Yii::t('translation','Promote_till_this_date'); ?></label>
            <input type="text" class="promoteInput" readonly />
            <span class="add-on">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
<?php  include 'curbsideNodePost.php';?>
<script type="text/javascript">
    pF1 = 1;
    pF2 = 1;
//    if(typeof socketCurbside !== "undefined")
//        socketCurbside.emit('clearInterval',sessionStorage.old_key);
    $(function(){
       $(window).scrollEnd(function() {
            trackViews($("#curbsidePostsDiv div.post.item:not(.tracked)"), "Curbside"); 
       }, 1000);
   });
    gPage = "CurbStream";
    getCollectionData('/curbsidePost/getcurbsideposts', 'StreamPostDisplayBean', 'curbsidePostsDiv', '<?php echo Yii::t('translation','No_Posts_found'); ?>',"<?php echo Yii::t('translation','Thas_all_folks'); ?>");
    initializationForHashtagsAtMentions('div#editable');
    initializationForArtifacts();    
    if(!detectDevices()){ // only for web
        curbsideOnloadEvents();
    }
     trackEngagementAction("Loaded"); 
    getCategories();
    bindEventsForStream('curbsidePostsDiv');
    bindEventsForStream('CategoryPostsDiv');
    bingGroupsIntroPopUp();
    var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
    initializeFileUploader('uploadfile', '/post/upload', '10*1024*1024', extensions,4, 'CurbsidePostForm' ,'',previewImage,appendErrorMessages,'uploadlist');
  function CloseFilterData(activeid,divid){
     
       $('#'+divid).css('display', 'none');
       $("#curbsidePostsDiv").show();
        $("#CategoryPostsDiv").hide();
        $('#CategoryPostsDiv').empty();
        globalspace.previousStreamIds = "";
        $('#'+activeid).removeClass('active');
        g_curbside_categoryID="";
        g_curbside_hashtagID="";
         $(window).unbind("scroll");
        page = 1;
        isDuringAjax=false;
        $("#categoryClickedDiv").hide();
        $("#categoryClickedDiv").html("");
        $("#c_filteractive").show();
        $("#c_filterinactive").hide();
        $('#crubsidefilter').removeClass('in');
        $('#crubsidefilter').css('height', '0px');
         getCollectionData('/curbsidePost/getcurbsideposts', 'StreamPostDisplayBean', 'curbsidePostsDiv', 'No Posts found.','That\'s all folks!');
        //$('.categorymemenuhelp').css('display','none');
         if(!detectDevices())
               $("[rel=tooltip]").tooltip();
            
  }      
        
        ClearPostNodeIntervals();
        
         if(!detectDevices())
              $("[rel=tooltip]").tooltip();
         else{
            //$("#CurbsidePostForm_Category").attr("style","width:200px");
         }
     Custom.init();  
     
 </script>    