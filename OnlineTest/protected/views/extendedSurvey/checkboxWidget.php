<input type="hidden" name="ExtendedSurveyForm[DisplayType][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_DisplayType_<?php echo $widgetCount; ?>" value="1" />
<div class="paddingtblr1030">
    
    <?php include 'WidgetOptions.php'; ?>
    <div class="tab_1">
        
        <?php $type="checkbox"; include 'dynamicOptions.php'; ?> 

        <div class="answersection1" id="answersection1_<?php echo $widgetCount; ?>" data-questionId="<?php echo $widgetCount; ?>" data-optionType="checkbox">
            <?php for ($i = 1; $i <= $radioLength; $i++) { ?>
                <input type="hidden" name="ExtendedSurveyForm[CheckboxOption][<?php echo $i . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_CheckboxOption_hid_<?php echo $i . "_" . $widgetCount; ?>" class="checkboxhidden"/>

                <div class="normaloutersection">
                    <div class="normalsection">
                        <div class="surveyradiobutton">
                            <div class="disabledelement"></div><input type="checkbox" class="styled"></div>
                        <div class="surveyremoveicon"><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="Delete option"/></div>
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group controlerror">
                                    <input placeholder="Option Name" value="" type="text" class="textfield span12 checkboxtype notallowed"  name="checkbox_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_CheckboxOption_hid_<?php echo $i . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_CheckboxOption_<?php echo $i . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                                    <div style="display:none"  id="ExtendedSurveyForm_CheckboxOption_<?php echo $i . "_" . $widgetCount; ?>_em_" class="errorMessage radioEmessage checkboxEmessage"></div>
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
    $(document).ready(function() {
        Custom.init();
        $("[rel=tooltip]").tooltip();

    }); 
</script>