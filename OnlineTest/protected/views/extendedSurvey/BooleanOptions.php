    
<input type="hidden" name="ExtendedSurveyForm[BooleanValues][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_Boolean_hid_<?php echo $widgetCount; ?>" class="booleanhidden"/>

<div class="answersection1" id="answersection1_<?php echo $widgetCount; ?>" data-questionId="<?php echo $widgetCount; ?>" data-optionType="checkbox">
    <?php for ($i = 1; $i <= $radioLength; $i++) { ?>
        <input type="hidden" name="ExtendedSurveyForm[BooleanRadioOption][<?php echo $i . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_RadioOption_hid_<?php echo $i . "_" . $widgetCount; ?>" class="booleanoptionhidden"/>

        <div class="normaloutersection">                    
            <div class="normalsection">
                <?php if($type == 1){?>
                <div class="surveyradiobutton">
                    <div class="onlinetestradio"><input type="radio" class="styled"  name="booleanradio"></div>
                </div>  
                <?php } else {?>
                
                    <div class="surveyradiobutton"> 
                         <div class=""></div>
                         <div class="onlinetestcheckbox"> <input type="checkbox" class="styled "  readonly="true" name="answercheck_<?php echo $widgetCount; ?>"></div></div>
                    
                <?php } ?>
                <div class="surveyradiofollowup confirmation_<?php echo $widgetCount; ?>" id="confirmation_<?php echo $i."_".$widgetCount; ?>" data-quesitonid="<?php echo $widgetCount; ?>" data-value="<?php echo $i; ?>"><input id="needJust_<?php echo $i."_".$widgetCount; ?>" type="checkbox"  name="confirmradio_<?php echo $widgetCount; ?>" class="styled confirmraido" value="<?php echo $i; ?>" /></div>
                <div class="row-fluid">
                    <div class="span12">
                        <input placeholder="Option Name" type="text" class="textfield span10 radiotype_boolean notallowed"  name="boolean_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_RadioOption_hid_<?php echo $i . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_RadioOption_<?php echo $i . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                        <div class="control-group controlerror">  
                            <div style="display:none" id="ExtendedSurveyForm_BooleanRadioOption_<?php echo $i . "_" . $widgetCount; ?>_em_" class="errorMessage booleanradioEmessage"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>