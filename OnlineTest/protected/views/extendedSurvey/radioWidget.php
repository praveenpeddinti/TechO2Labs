<input type="hidden" name="ExtendedSurveyForm[AnswerSelected][<?php echo ($widgetCount); ?>]"   id="ExtendedSurveyForm_answerSelected_<?php echo ($widgetCount); ?>" />
<input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo $widgetCount; ?>" />
<div class="paddingtblr1030">
    
    <?php include 'WidgetOptions.php'; ?>
    <?php include 'newfileuploadscript.php';?>
    <div class="tab_1">
        
        <?php $type="radio"; include 'dynamicOptions.php'; ?>
        <div class="answersection1" id="answersection1_<?php echo $widgetCount; ?>" data-questionId="<?php echo $widgetCount; ?>" data-optionType="radio">

            <?php for ($i = 1; $i <= $radioLength; $i++) { ?>
                <input type="hidden" name="ExtendedSurveyForm[RadioOption][<?php echo $i . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_RadioOption_hid_<?php echo $i . "_" . $widgetCount; ?>" class="radiohidden"/>
                <div class="normaloutersection">                    
                    <div class="normalsection">
                        <div class="surveyradiobutton">  <div class="onlinetestradio"><input type="radio" class="styled ranking_radio"  name="radioinput" value="<?php echo $i ?>"/></div></div>
                        <div class="surveyremoveicon"><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="Delete option"/></div>
                        <div class="row-fluid">
                            <div class="span12">

                                <input placeholder="Option Name" type="text" class="textfield span12 radiotype notallowed"  name="radio_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_RadioOption_hid_<?php echo $i . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_RadioOption_<?php echo $i . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                                <div class="control-group controlerror">  
                                    <div style="display:none" id="ExtendedSurveyForm_RadioOption_<?php echo $i . "_" . $widgetCount; ?>_em_" class="errorMessage radioEmessage"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


                <input type="hidden" name="ExtendedSurveyForm[Other][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_Other_<?php echo $widgetCount; ?>" class="otherhidden"/>
            <input type="hidden" name="ExtendedSurveyForm[OtherValue][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_OtherValue_<?php echo $widgetCount; ?>" class="otherhiddenvalue"/>
            <div class="normaloutersection">
                <div class="normalsection othersarea" id="othersarea_<?php echo $widgetCount; ?>">
                    <div class="surveyradiobutton"> <input type="checkbox" class="styled othercheck" name="1" id="othercheck_<?php echo $widgetCount; ?>" /> <i>Others</i> </div>  
                    <div class="row-fluid otherTextdiv" style="display: none;" id="otherTextdiv_<?php echo $widgetCount; ?>">
                        <div class="span12">
                            <div class="control-group controlerror"> 
                                <input type="text" placeholder="Other Value" id="otherText_<?php echo $widgetCount; ?>" class="span12 textfield othertext notallowed"  data-hiddenname="ExtendedSurveyForm_OtherValue_<?php echo $widgetCount; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                                <div class="control-group controlerror">
                                    <div style="display:none"  id="ExtendedSurveyForm_OtherValue_<?php echo $widgetCount; ?>_em_" class="errorMessage othererr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
            </div>            
        </div>     

    </div>
</div>



<script type="text/javascript">
    function showmore(id) {
        document.getElementById(id).style.overflow = "visible";
        document.getElementById(id).style.height = " ";

    }
    $(document).ready(function() {
        Custom.init();
        $("[rel=tooltip]").tooltip();

    });   
    bindToMandatory('<?php echo $widgetCount; ?>');
    
</script>