<!-- spinner -->
<div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
<div id="stream_view_detailed_spinner_<?php echo $data->PostId; ?>"></div>
<!-- end spinner -->
<div class="alert alert-error" id="<?php echo "surveyError_" . $data->_id ?>" style='padding-top: 5px;display: none'> Please select an option </div>
<div class="alert alert-success" id="<?php echo "surveyConfirmation_" . $data->_id ?>" style='padding-top: 5px;display: none'><?php echo Yii::t('translation', 'Survey_Completed'); ?></div>
<div id="<?php echo "surveyArea_" . $data->_id ?>">
    <?php
    if (!$data->IsSurveyTaken) {
        include Yii::app()->basePath . '/views/includes/stream_artifacts.php'; 
        ?>

        <div class="media-body">
            <?php include Yii::app()->basePath . '/views/includes/stream_postText.php';  ?>
            <div class="row-fluid "> 
                <div class="span12 customradioanswers">
                    <div class="customradioanswersdiv">
                        <div class="c_prefix">A)</div>
                        <div class="c_suffix"><input type="radio" class="styled" name="<?php echo "survey_" . $data->PostId ?>" value="OptionOne"></div> 
                    </div>
                    <div class="c_options"><?php echo $data->OptionOne ?></div>
                </div>
            </div>
            <div class="row-fluid "> 
                <div class="span12 customradioanswers">
                    <div class="customradioanswersdiv">
                        <div class="c_prefix">B)</div>
                        <div class="c_suffix"><input type="radio" class="styled" name="<?php echo "survey_" . $data->PostId ?>" value="OptionTwo"></div> 
                    </div>
                    <div class="c_options"><?php echo $data->OptionTwo ?></div>
                </div>
            </div>
            <div class="row-fluid "> 
                <div class="span12 customradioanswers">
                    <div class="customradioanswersdiv">
                        <div class="c_prefix">C)</div>
                        <div class="c_suffix"><input type="radio" class="styled" name="<?php echo "survey_" . $data->PostId ?>" value="OptionThree"></div> 
                    </div>
                    <div class="c_options"><?php echo $data->OptionThree ?></div>
                </div>
            </div>     
    <?php if (isset($data->OptionFour) && !empty($data->OptionFour)) { ?>
                <div class="row-fluid "> 
                    <div class="span12 customradioanswers">
                        <div class="customradioanswersdiv">
                            <div class="c_prefix">D)</div>
                            <div class="c_suffix"><input type="radio" class="styled" name="<?php echo "survey_" . $data->PostId ?>" value="OptionFour"></div> 
                        </div>
                        <div class="c_options"><?php echo $data->OptionFour ?></div>
                    </div>
                </div>
    <?php } ?>
            <div class="alignright paddingtb">

                <input class="btn " name="commit" type="button" value="Submit" onclick="submitSurvey('<?php echo $data->PostId ?>', '<?php echo $data->NetworkId; ?>', '<?php echo $data->CategoryType; ?>',<?php echo $data->OptionOneCount; ?>,<?php echo $data->OptionTwoCount; ?>,<?php echo $data->OptionThreeCount ?>,<?php echo $data->OptionFourCount; ?>, '<?php echo $data->_id ?>',<?php echo $data->IsOptionDExist; ?>)" />
            </div>

        </div>
    <?php if ((int) $data->FirstUserId != (int) $data->OriginalUserId) { ?>
            <div class="media-body"> <div class="media">
                     <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <img src="<?php echo $data->OriginalUserProfilePic ?>">
                  
                  </a>
                     </div>   
                    <div class="media-body">                                   
                        <span class="m_day"><?php echo $data->OriginalPostPostedOn; ?></span>
                        <div class="m_title"><a class="userprofilename" data-streamId="<?php echo $data->_id; ?>" data-id="<?php echo $data->OriginalUserId ?>"  style="cursor:pointer"><?php echo $data->OriginalUserDisplayName; ?></a><?php if ($data->PostType == 5) { ?><div id="curbside_spinner_<?php echo $data->_id; ?>"></div><span class="pull-right" data-id="<?php echo $data->_id; ?>"><?php echo $data->CurbsideConsultCategory ?></span><?php } ?></div>

                    </div>
                </div>
            </div>
    <?php } ?>
    <?php if ($data->CategoryType == 3 && $data->IsIFrameMode == 1 && isset($isStream) && $isStream==true) { ?>
            <div class="media-body"> 
                <div class="m_title">
                    <span class="pull-right" data-id="<?php echo $data->_id; ?>">
                        <a class="grpIntro grpIntro_b" data-streamId="<?php echo $data->_id; ?>" data-id="<?php echo $data->MainGroupId; ?>" style="cursor:pointer"><b><?php echo html_entity_decode($data->GroupName); ?></b></a>
                    </span>
                </div>
            </div> 
        <?php } 
         include Yii::app()->basePath . '/views/includes/stream_webSnippet.php'; 
     } ?>
</div>
<div class="media-body" id="<?php echo "surveyTakenArea_" . $data->_id ?>" style="display:<?php echo $data->IsSurveyTaken ? 'block' : 'none' ?>">
    <div class="surveyquestion" data-postid="<?php echo $data->PostId; ?>"> 
        <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>"  data-id="<?php echo $data->_id; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_total_<?php echo $data->_id; ?>" style="display:none" >

<?php
echo $data->PostCompleteText;
?>
        </div>
        <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>"  data-id="<?php echo $data->_id; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_<?php echo $data->_id; ?>" <?php if ($data->PostType == 5) { ?> class="postdetail" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>" <?php } ?> >

<?php
echo $data->PostText;
?>
        </div>
    </div>
    <div class="media-body custommedia-body">
        <div class="row-fluid">
            <div class="span12">
                <div class="span7" id="<?php echo "surveyGraphArea_" . $data->_id ?>" ></div>
                <div class="span5 surveyresults" >
                    <div class="row-fluid ">
                        <div class="span12">
<?php echo "A) " . $data->OptionOne ?>
                        </div>
                    </div>
                    <div class="row-fluid ">
                        <div class="span12">
<?php echo "B) " . $data->OptionTwo ?>
                        </div>
                    </div>
                    <div class="row-fluid ">
                        <div class="span12">
                    <?php echo "C) " . $data->OptionThree ?>
                        </div>
                    </div>
                            <?php if (isset($data->OptionFour) && !empty($data->OptionFour)) { ?>
                        <div class="row-fluid ">
                            <div class="span12">
                        <?php echo "D) " . $data->OptionFour; ?>
                            </div>
                        </div>
<?php } ?>
                </div>
            </div>
        </div>
    </div>
    
     <?php if((int) $data->FirstUserId !=  (int)$data->OriginalUserId ){
                                  include Yii::app()->basePath . '/views/includes/stream_originalUser.php';
                                } ?>
    <?php include Yii::app()->basePath . '/views/includes/stream_webSnippet.php'; ?>


<?php
if ($data->IsSurveyTaken) {
    ?>
        <script type="text/javascript">
            $(function() {
                var height = 250;
                var width = 300;
                if (detectDevices()) {
                    width = 230;
                }
                drawSurveyChart('<?php echo "surveyGraphArea_" . $data->_id ?>', <?php echo $data->OptionOneCount ?>, <?php echo $data->OptionTwoCount ?>,<?php echo $data->OptionThreeCount ?>,<?php echo $data->OptionFourCount ?>, height, width,<?php echo $data->IsOptionDExist; ?>);
            });
        </script>
<?php } ?>
</div>