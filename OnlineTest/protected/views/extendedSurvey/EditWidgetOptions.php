
<!-- Widgets -->
<?php $quesitonType = $question['QuestionType']; ?>
<div id="answerstabs_<?php echo ($i + 1); ?>" class="answerstabs positionrelative"  >
    <div class="row-fluid mandatory positionabsolutediv"  id="mandatory_<?php echo ($i + 1); ?>"  style="width:310px; right:0px; top:10px;">
                            
    <div class="span5  pull-right madatoryclass" data-questionno="<?php echo ($i + 1); ?>" >
        <span style="vertical-align: middle; line-height: 23px;"><?php echo Yii::t("translation","Is_it_mandatory"); ?></span>
        <input type="checkbox" class="styled" data-on-label="Off" data-off-label="On" name="ExtendedSurveyForm[IsMadatory][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsMadatory_<?php echo ($i + 1); ?>" <?php if($question['IsMadatory'] == 1){?> checked="true" value="1"<?php }else{ ?> value="0" <?php } ?>/>

    </div>
</div>
    <ul class="tabsselection" data-questionno="<?php echo ($i + 1); ?>">
        <li <?php if($quesitonType == 1){ ?>  class="active" <?php } ?> data-option="radio"><a class="surveyradio"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Radio"); ?>"/></a></li>
        <li <?php if($quesitonType == 2){ ?>  class="active" <?php } ?> data-option="checkbox"><a  class="surveycheckbox"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Checkbox"); ?>"/></a></li>
        <li <?php if($quesitonType == 3 || $quesitonType == 4){ ?>  class="active" <?php } ?> data-option="rating"><a class="surveyratingranking"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Rating_Ranking"); ?>"/></a></li>
        <li <?php if($quesitonType == 5){ ?>  class="active" <?php } ?> data-option="percent"><a  class="surveypercent"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Percentage"); ?>"/></a></li>
        <li <?php if($quesitonType == 6){ ?>  class="active" <?php } ?> data-option="QandA"><a class="surveyQandA"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_QAndA"); ?>"/></a></li>
        <li <?php if($quesitonType == 7){ ?>  class="active" <?php } ?> data-option="userRanking"><a  class="surveyuserranking"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Generated"); ?>"/></a></li>
        <li <?php if($quesitonType == 8){ ?>  class="active" <?php } ?> data-option="booleanFollowup"><a  class="surveybooleanfollowup booleanFollowup"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Boolean"); ?>"/></a></li>
    </ul>
</div>
<!-- End -->
