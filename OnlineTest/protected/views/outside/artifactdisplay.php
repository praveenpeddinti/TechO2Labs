<input type="hidden" name="ExtendedSurveyForm[QuestionImage][<?php echo $i; ?>]" id="ExtendedSurveyForm_QuestionImage_<?php echo $i; ?>" value="" /> <?php // /images/system/survey_img.png  ?>

<div class="row-fluid"> 
    <div class="span12">
        <div class="span2">
        </div>
        <div class="span10 padding10">
            <div style="padding-left: 30px;display: none;" id="brandimagelogodiv_<?php echo $i; ?>" data-qtnid="<?php echo $i; ?>">
                <div style="" class="preview pull-left">

                    <ul >
                        <li class="">
                            <img alt=""  id="brandPreview_<?php echo ($i); ?>" style="max-width: 600px;">
                        </li>
                    </ul>

                </div>        
            </div>


            <div class="" style="border-radius:1px;"> <div id="player_<?php echo $i; ?>" style="display: none;"></div></div>
        </div>
    </div>


</div>

<script type="text/javascript">
<?php
if (sizeof($question['QuestionArtifact']) > 0) {
    $artifact = isset($question['QuestionArtifact'][0]) ? $question['QuestionArtifact'][0] : "";
    if (!empty($artifact)) {
        ?>
                             $("#ExtendedSurveyForm_QuestionImage_<?php echo $i; ?>").val("<?php echo $artifact['Uri']; ?>");
        <?php if ($artifact['Extension'] == "mp3" || $artifact['Extension'] == "mp4") { ?>
                                    openOverlay("<?php echo $artifact['Uri']; ?>","/images/system/video_new.png","player_<?php echo $i; ?>","",600);
        <?php } else { ?>
                                    $("#player_<?php echo $i; ?>_wrapper").html("").attr("id","player_<?php echo $i; ?>").hide();
                                    $("#brandimagelogodiv_<?php echo $i; ?>").show();
                                    $("#brandPreview_<?php echo $i; ?>").attr("src","<?php echo $artifact['Uri']; ?>");
        <?php
        }
    }
}
?>


</script>