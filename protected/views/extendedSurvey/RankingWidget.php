<table cellpadding="0" cellspacing="0" class="customsurvaytable">
    <tr>
        <th class="col1"></th>
        <?php for ($i = 0; $i < ($thcount); $i++) { ?>
        <input type="hidden" name="ExtendedSurveyForm[LabelName][<?php echo $i . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_LabelName_hid_<?php echo $i . "_" . $widgetCount; ?>" class="label_hidden label_hidden_<?php echo $widgetCount; ?>"/>
        <th id="th_labelname_<?php echo $i . "_" . $widgetCount; ?>">
        <div class="surveydeleteaction positionrelative">             
            <input  type="text" class="textfield textfieldtable notallowed labelnamewid_<?php echo $widgetCount; ?>" placeHolder="Label Name" name="LabelName_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_LabelName_hid_<?php echo $i . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_LabelName_<?php echo $i . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
            <div class="control-group controlerror">
                <div style="display:none"  id="ExtendedSurveyForm_LabelName_<?php echo $i . "_" . $widgetCount; ?>_em_" class="errorMessage" style="font-weight:normal"></div>
            </div>
        </div>
        <div class="surveydeleteaction pad_top10">             
            <input  type="text" name="ExtendedSurveyForm[LabelDesc][<?php echo $i . "_" . $widgetCount; ?>]" class="textfield textfieldtable notallowed label_lDesc label_lDesc_<?php echo $widgetCount; ?>" placeHolder="Label Description"   id="ExtendedSurveyForm_lDesc_<?php echo $i . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">            
        </div>


    </th>  
<?php } ?>
<th></th>
</tr>

<?php for ($i = 0; $i < $thcount; $i++) { ?>

    <input type="hidden" name="ExtendedSurveyForm[OptionName][<?php echo $i . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_OptionName_hid_<?php echo $i . "_" . $widgetCount; ?>" class="option_hidden option_hidden_<?php echo $widgetCount; ?>"/>
    <tr>
        <td>
            <div class="control-group controlerror">
                <?php if($i == ($thcount-1) && $other == 1){ ?>
                    <input type="text" placeholder="Other Value" class="textfield textfieldtable option_text notallowed optionnamewid_<?php echo $widgetCount; ?>" name="OptionName_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_OptionName_hid_<?php echo $i . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_Ranking_<?php echo $i . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
                <?php }else{ ?>
                    <input type="text" placeholder="Option Name" class="textfield textfieldtable option_text notallowed optionnamewid_<?php echo $widgetCount; ?>" name="OptionName_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_OptionName_hid_<?php echo $i . "_" . $widgetCount; ?>" id="ExtendedSurveyForm_Ranking_<?php echo $i . "_" . $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
                <?php }?>
                
                <div style="display:none"  id="ExtendedSurveyForm_OptionName_<?php echo $i . "_" . $widgetCount; ?>_em_" class="errorMessage ranking_errmsg"></div>
            </div>
        </td>
        <?php if($optionsType == 1 || $optionsType == 3){  for ($j = 0; $j < $radioOpCnt; $j++) { ?>
            
            <td><div class="positionrelative displaytable ">
                    <input type="radio" class="styled ranking_radio" id="radio_<?php echo $i . "_" . $widgetCount; ?>" name="radio_<?php echo $i . "_" . $widgetCount; ?>" disabled="true"/>
                    
                </div>
            </td> 
        <?php } ?>
            <?php if($optionsType == 3){ ?>
    <input type="hidden"  maxlength="50" class="rr_justification_hidden rr_justification_hidden_<?php echo $widgetCount; ?> " name="ExtendedSurveyForm[JustificationPlaceholders][<?php echo $i . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_JustificationPlaceholders_<?php echo $i . "_" . $widgetCount; ?>" />
            <td><div class="positionrelative surveydeleteaction ">
                    <input type="text" class="textfield textfieldtable rr_justification notallowed rr_justification_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_JustificationPlaceholderstext_<?php echo $i . "_" . $widgetCount; ?>" placeholder="Justification placeholder" onkeyup="insertText(this.id)" onblur="insertText(this.id)" data-hiddenname="ExtendedSurveyForm_JustificationPlaceholders_<?php echo $i . "_" . $widgetCount; ?>" />
            </div>
            </td> 
            <?php } ?>
        <?php  }else if($optionsType == 2){  for ($j = 0; $j < $radioOpCnt; $j++) {?>
            <td><div class="positionrelative surveydeleteaction ">
                 <input type="text" class="textfield textfieldtable"  disabled="true" />
            </div>
            </td> 
        <?php } }?>

    </tr>
<?php } ?>
</table>
<script type="text/javascript">
    Custom.init();     
</script>