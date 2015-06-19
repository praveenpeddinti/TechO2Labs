<?php for($i=0;$i<$thcount;$i++){ ?>
<input type="hidden" name="ExtendedSurveyForm[OptionName][<?php echo $i."_".$widgetCount; ?>]" id="ExtendedSurveyForm_OptionName_hid_<?php echo $i."_".$widgetCount; ?>" class="usergeneratedhidden"/>
<div class="normaloutersection normalouter_<?php echo $widgetCount; ?>">
        <div class="normalsection normalsection6">
    
     <div class="row-fluid">
     <div class="span12">   
     <div class="control-group controlerror">
         <!--<input type="text" placeholder="Option Name" class="textfield span5 userGeneratedOptions notallowed" name="OptionName_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_OptionName_hid_<?php //echo $i . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_userGRanking_<?php //echo $i . "_" . $widgetCount; ?>" maxlength="500">-->
         <input type="text" placeholder="Option Name" class="textfield span5 userGeneratedOptions notallowed" name="ExtendedSurveyForm[UserAnswerSelected][<?php echo $i ?>]" data-hiddenname="ExtendedSurveyForm_OptionName_hid_<?php echo $i . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_userGRanking_<?php echo $i . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
                <div style="display:none"  id="ExtendedSurveyForm_OptionName_<?php echo $i . "_" . $widgetCount; ?>_em_" class="errorMessage usergeneratederrorMsg"></div>
      </div>
     </div>
     </div>
     </div>
     </div>
<?php } ?>


