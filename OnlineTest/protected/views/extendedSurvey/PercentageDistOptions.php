<?php for($i=0;$i<$optionsCnt;$i++){ ?>
<input type="hidden" name="ExtendedSurveyForm[OptionName][<?php echo $i."_".$widgetCount; ?>]" id="ExtendedSurveyForm_OptionName_hid_<?php echo $i."_".$widgetCount; ?>" class="percentagehidden"/>
<div class="normaloutersection normalouter_<?php echo $widgetCount; ?>">
        <div class="normalsection normalsection4">
   		
     <div class="row-fluid">
     <div class="span10">
     <div class="span6">
       <div class="control-group controlerror">
           <input placeholder="Option Name" type="text"  class="textfield span10 percentageOptionname notallowed" name="OptionName_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_OptionName_hid_<?php echo $i."_".$widgetCount; ?>" id="ExtendedSurveyForm_percentage_<?php echo $i."_".$widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
         <div style="display:none"  id="ExtendedSurveyForm_OptionName_<?php echo $i."_".$widgetCount; ?>_em_" class="errorMessage percentageOptionerr"></div>
         </div>     
     </div>
     <div class="span2 positionrelative labelpercent">
          <div class="control-group controlerror">
              <input  type="text" class="textfield span10 distvalue_<?php echo $widgetCount; ?>" name = "ExtendedSurveyForm[PercentageAnswer][<?php echo $i."_".$widgetCount; ?>]"  id ="ExtendedSurveyForm_PercentageAnswer_<?php echo $i."_".$widgetCount; ?>" onkeydown="allowNumericsAndCheckFields(event)" onblur="maxCheck(this,<?php echo $widgetCount; ?>)" size="8" maxlength="4"/> <label class="percentlbl perUnitType_<?php echo $widgetCount; ?>"  > <?php echo $unitType; ?></label>
        <div style="display:none"  id="ExtendedSurveyForm_PercentageAnswer_<?php echo $i."_".$widgetCount; ?>_em_" class="errorMessage PercentageAnswererr"></div>
          </div>
          </div>
     </div>
     </div>
     </div>
     </div>
<?php } ?>