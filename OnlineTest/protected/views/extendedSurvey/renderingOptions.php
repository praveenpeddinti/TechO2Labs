<?php if($optionType == "radio"){ ?>
<?php for($i = 1; $i<= $noofoptions;$i++){ ?>
<input type="hidden" name="ExtendedSurveyForm[RadioOption][<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_RadioOption_hid_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>" class="radiohidden"/>
<div class="normaloutersection">                    
    <div class="normalsection">
        <div class="surveyradiobutton"> <input type="radio" class="styled"  disabled="true"></div>
        <div class="surveyremoveicon"><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="Delete option"/></div>
        <div class="row-fluid">
            <div class="span12">

                <input placeholder="Option Name" type="text" class="textfield span12 radiotype notallowed"  name="radio_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_RadioOption_hid_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_RadioOption_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                <div class="control-group controlerror">  
                    <div style="display:none" id="ExtendedSurveyForm_RadioOption_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>_em_" class="errorMessage radioEmessage"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php }else if($optionType == "checkbox") { ?>
<?php for($i = 1; $i<= $noofoptions;$i++){ ?>
<input type="hidden" name="ExtendedSurveyForm[CheckboxOption][<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_CheckboxOption_hid_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>" class="checkboxhidden"/>

<div class="normaloutersection">
    <div class="normalsection">
        <div class="surveyradiobutton">
            <div class="disabledelement"></div><input type="checkbox" class="styled"></div>
        <div class="surveyremoveicon"><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="Delete option"/></div>
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group controlerror">
                    <input placeholder="Option Name" value="" type="text" class="textfield span12 checkboxtype notallowed"  name="checkbox_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_CheckboxOption_hid_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_CheckboxOption_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                    <div style="display:none"  id="ExtendedSurveyForm_CheckboxOption_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>_em_" class="errorMessage radioEmessage checkboxEmessage"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php }else{ ?>
<!-- Booelan -->
<?php for ($i = 1; $i <= $noofoptions; $i++) { ?>
        

        <input type="hidden" name="ExtendedSurveyForm[BooleanRadioOption][<?php echo ($i+$totalOptions). "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_RadioOption_hid_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>" class="booleanoptionhidden"/>

        <div class="normaloutersection">                    
            <div class="normalsection">
                <?php if($type == 1){?>
                <div class="surveyradiobutton">
                    <input type="radio" class="styled"  disabled="true">
                </div>  
                <?php } else {?>
                    <div class="surveyradiobutton"> 
                         <div class="disabledelement"></div>
                        <input type="checkbox" class="styled "  readonly="true"></div>
                    
                <?php } ?>
                <div class="surveyradiofollowup confirmation_<?php echo $widgetCount; ?>" id="confirmation_<?php echo ($i+$totalOptions)."_".$widgetCount; ?>" data-quesitonid="<?php echo $widgetCount; ?>" data-value="<?php echo ($i+$totalOptions); ?>"><input id="needJust_<?php echo ($i+$totalOptions)."_".$widgetCount; ?>" type="checkbox"  name="confirmradio_<?php echo $widgetCount; ?>" class="styled confirmraido" value="<?php echo ($i+$totalOptions); ?>" /></div>
                <div class="row-fluid">
                    <div class="span12">
                        <input placeholder="Option Name" type="text" class="textfield span10 radiotype_boolean notallowed booelanType_<?php echo $widgetCount; ?>"  name="boolean_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_RadioOption_hid_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_RadioOption_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                        <div class="control-group controlerror">  
                            <div style="display:none" id="ExtendedSurveyForm_BooleanRadioOption_<?php echo ($i+$totalOptions) . "_" . $widgetCount; ?>_em_" class="errorMessage booleanradioEmessage"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<script type="text/javascript">
    Custom.init();
    $("[rel=tooltip]").tooltip();
</script>