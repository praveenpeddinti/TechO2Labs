    

<input type="hidden" name="ExtendedSurveyForm[BooleanValues][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_Boolean_hid_<?php echo $widgetCount; ?>" class="booleanhidden"/>
        <?php for ($i = 1; $i <= $radioLength; $i++) { ?>
                <input type="hidden" name="ExtendedSurveyForm[BooleanRadioOption][<?php echo $i . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_RadioOption_hid_<?php echo $i . "_" . $widgetCount; ?>" class="booleanoptionhidden"/>
                
            <div class="normaloutersection">                    
                <div class="normalsection">
                    <div class="surveyradiobutton"> 
                        <div class="disabledelement"></div>
                        <input type="checkbox" class="styled"  >
                    </div>                        
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