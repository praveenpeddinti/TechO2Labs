<input type="hidden" name="ExtendedSurveyForm[QuestionImage][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_QuestionImage_<?php echo $widgetCount; ?>" value="" /> <?php // /images/system/survey_img.png ?>
<div class="row-fluid">
    <div class="span12">
        <div id="error-message_<?php echo $widgetCount; ?>_error" class="alert alert-error" style="display:none;"></div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="span2">
            <div  style="display: table;margin-top:20px"id="uploadfile_<?php echo $widgetCount; ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Ex_BrandLogo'); ?>"></div>
            
        </div>
        <div class="span10 padding10">
            <!--<div class="qq-uploader"><div class="qq-upload-button" style="position: relative; overflow: hidden; direction: ltr;"><input type="file" multiple="multiple" capture="camera" name="file" style="position: absolute; right: 0px; top: 0px; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;"></div></div>-->
                    <div style="padding-left: 30px;display: none" id="brandimagelogodiv_<?php echo $widgetCount; ?>" data-qtnid="<?php echo $widgetCount; ?>">
                        <div style="" class="preview pull-left">
         
                        <ul >
                            <li class="">
                                <img alt="" src="" id="brandPreview_<?php echo $widgetCount; ?>" style="max-width: 600px;">
                            </li>
                        </ul>

                   </div>        
                    </div>
                       
                    <div id="appendlist_<?php echo $widgetCount; ?>"><ul class="qq-upload-list" id="uploadlist_<?php echo $widgetCount; ?>"></ul></div>
                    <div class="" style="padding:20px;"><div id="player_<?php echo $widgetCount; ?>" style="display: none;"></div></div>
                    
        </div>
    </div>
</div>    

                    
                     
                     
<script type="text/javascript">
     var extensions = '"jpg","jpeg", "gif", "png", "tiff","tif","TIF","mp3","mp4","MP3","MP4"';
initializeFileUploader('uploadfile_<?php echo $widgetCount; ?>', '/extendedSurvey/uploadImage?qId=<?php echo $widgetCount; ?>', '10*1024*1024', extensions, 1, 'error-message_<?php echo $widgetCount; ?>', '', BrandPreviewImage, displayErrorForBannerAndQuestion, "appendlist_<?php echo $widgetCount; ?>");
    </script>