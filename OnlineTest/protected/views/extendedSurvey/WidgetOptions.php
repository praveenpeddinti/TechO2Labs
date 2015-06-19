
<!-- Widgets -->
<div id="answerstabs_<?php echo $widgetCount; ?>" class="answerstabs positionrelative">
    
<div class="row-fluid mandatory positionabsolutediv positionabsolutediv m_positionabsolutediv"  id="mandatory_<?php echo $widgetCount; ?>" style="width:180px; right:0px;" >                            
    <div class="pull-right madatoryclass" data-questionno="<?php echo $widgetCount; ?>">
        <span style="vertical-align: middle; line-height: 23px;"><?php //echo Yii::t("translation","Is_it_mandatory"); ?></span>
        <!--<input type="checkbox" value="1" class="styled mandatorycheckbox" data-on-label="Off" data-off-label="On" name="ExtendedSurveyForm[IsMadatory][<?php //echo $widgetCount; ?>]" id="ExtendedSurveyForm_IsMadatory_<?php //echo $widgetCount; ?>"/>-->

    </div>
</div>
    
    <ul class="tabsselection" data-questionno="<?php echo $widgetCount; ?>">
        <li <?php echo $acitveIcon == "Radio"?"class='active'":''; ?> data-option="radio"><a class="surveyradio"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Radio"); ?>"/></a></li>
        <li <?php echo $acitveIcon == "Checkbox"?"class='active'":''; ?>  data-option="checkbox"><a  class="surveycheckbox"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Checkbox"); ?>"/></a></li>
        <li <?php echo $acitveIcon == "RR"?"class='active'":''; ?> data-option="rating"><a class="surveyratingranking"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Rating_Ranking"); ?>"/></a></li>
        <li <?php echo $acitveIcon == "Percent"?"class='active'":''; ?> data-option="percent"><a  class="surveypercent"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Percentage"); ?>"/></a></li>
        <li <?php echo $acitveIcon == "QandA"?"class='active'":''; ?> data-option="QandA"><a class="surveyQandA"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_QAndA"); ?>"/></a></li>
        <li <?php echo $acitveIcon == "UserGenerated"?"class='active'":''; ?> data-option="userRanking"><a  class="surveyuserranking"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Generated"); ?>"/></a></li>
        <li <?php echo $acitveIcon == "BooleanFollowup"?"class='active'":''; ?> data-option="booleanFollowup"><a  class="surveybooleanfollowup booleanFollowup"><img src="/images/system/spacer.png" data-placement="top" rel="tooltip"  data-original-title="<?php echo Yii::t("translation","Ex_Widget_Boolean"); ?>"/></a></li>
    </ul>
</div>
<!-- End -->
