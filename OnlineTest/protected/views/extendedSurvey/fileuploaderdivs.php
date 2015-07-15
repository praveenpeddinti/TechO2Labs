 <input type="hidden" name="ExtendedSurveyForm[QuestionImage][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_QuestionImage_<?php echo ($i + 1); ?>" value="" /> <?php // /images/system/survey_img.png ?>
<div class="row-fluid">
    <div class="span12">
        <div id="error-message_<?php echo ($i + 1); ?>_error" class="alert alert-error" style="display:none;"></div>
    </div>
</div>
<div class="row-fluid"> 
    <div class="span12">
        <div class="span2">
            <div  style="display: table;"id="uploadfile_<?php echo ($i + 1); ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Ex_BrandLogo'); ?>"></div>
            
            
        </div>
        <div class="span10 padding10">
            <div style="padding-left: 30px;display: none;" id="brandimagelogodiv_<?php echo ($i + 1); ?>" data-qtnid="<?php echo ($i + 1); ?>">
                        <div style="" class="preview pull-left">
         
                        <ul >
                            <li class="">
                                <img alt=""  id="brandPreview_<?php echo ($i + 1); ?>" style="max-width: 600px;">
                            </li>
                        </ul>

                   </div>        
                    </div>
                       
                    <div id="appendlist_<?php echo ($i + 1); ?>"><ul class="qq-upload-list" id="uploadlist_<?php echo ($i + 1); ?>"></ul></div>
                    <div class="" style="border-radius:1px;"> <div id="player_<?php echo ($i + 1); ?>" style="display: none;"></div></div>
        </div>
    </div>

                    
</div>
                    
<script type="text/javascript">
var extensions = '"jpg","jpeg", "gif", "png", "tiff","tif","TIF","mp3","mp4","MP3","MP4"';
                initializeFileUploader('uploadfile_<?php echo ($i + 1); ?>', '/extendedSurvey/uploadImage?qId=<?php echo ($i + 1); ?>', '10*1024*1024', extensions, 1, 'error-message_<?php echo ($i + 1); ?>', '', BrandPreviewImage, displayErrorForBannerAndQuestion, "appendlist_<?php echo ($i + 1); ?>");
            // alert('<?php  $artifact = "";//echo ($i+1); ?>')
           
             <?php if(sizeof($question['QuestionArtifact'])>0){ 
                 $artifact = isset($question['QuestionArtifact'][0])?$question['QuestionArtifact'][0]:"";
                 if(!empty($artifact)){ ?>
                     $("#ExtendedSurveyForm_QuestionImage_<?php echo ($i+1); ?>").val("<?php echo $artifact['Uri']; ?>");
                    <?php if($artifact['Extension'] == "mp3" || $artifact['Extension'] == "mp4"){ ?>
                        openOverlay("<?php echo $artifact['Uri']; ?>","/images/system/video_new.png","player_<?php echo ($i+1); ?>","",600);
                    <?php }else{ ?>
                        $("#player_<?php echo ($i+1); ?>_wrapper").html("").attr("id","player_<?php echo ($i+1); ?>").hide();
                        $("#brandimagelogodiv_<?php echo ($i+1); ?>").show();
                        $("#brandPreview_<?php echo ($i+1); ?>").attr("src","<?php echo $artifact['Uri']; ?>");
                    <?php } 
                 }
             }?>


</script>