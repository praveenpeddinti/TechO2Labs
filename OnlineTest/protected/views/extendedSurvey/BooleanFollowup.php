<input type="hidden" name="ExtendedSurveyForm[AnswerSelected][<?php echo ($widgetCount); ?>]"   id="ExtendedSurveyForm_answerSelected_<?php echo ($widgetCount); ?>" />
<input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo $widgetCount; ?>" />
<input type="hidden" name="ExtendedSurveyForm[AnswerSelectedEdit][<?php echo ($widgetCount); ?>]"   id="ExtendedSurveyForm_answerSelectedEdit_<?php echo ($widgetCount); ?>" />
<div class="paddingtblr1030">
    
    <?php include 'WidgetOptions.php'; ?>
    <?php include 'newfileuploadscript.php';?>
    <div class="tab_1" style="margin-top: 10px;">
        
        
        <div class="answersection1" id="answersection1_<?php echo $widgetCount; ?>" data-questionId="<?php echo $widgetCount; ?>" data-optionType="radio">
            <input class="selectiontype_hidden" type="hidden" name="ExtendedSurveyForm[SelectionType][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_SelectionType_hid_<?php echo $widgetCount; ?>" value="1" />
            <div class="dropdownsectionarea dropdownmedium">
        <div class="row-fluid">
            <div class="span12">
                
                <div class="span8">
                    <div class="span3">
                        <div class="labelalignment"><label class=""><?php echo Yii::t("translation","Ex_TypeofSelection"); ?></label></div>
                    </div>
                    <div class="span4" style="margin: auto">
                        <div class="positionrelative">
                            <select style="width:184px" id="booleantypes_<?php echo $widgetCount; ?>" class="styled selectionType" data-quesitonid="<?php echo $widgetCount; ?>" name="loadwidgetType_<?php echo $widgetCount; ?>">
                            <option value="1">Single</option>
                            <option value="2">Multiple</option>                
                        </select>
                    </div>
                    </div>
                    </div>
                    <div class="span2 positionrelative pull-right" style="right:0; ">
                    <select class="styled selectoptions" style="width:130px;" id="selectoptions_<?php echo $widgetCount; ?>" name="selectoptions_<?php echo $widgetCount; ?>" data-optionType="boolean" data-questionid="<?php echo $widgetCount; ?>">
                        <?php for($opt=1;$opt<=30;$opt++){ ?>
                        <option value="<?php echo $opt; ?>" <?php if($opt == 2) echo "selected"; ?>><?php $str = "option"; if($opt > 1){
                    $str = $str."s";
                } echo $opt." ".$str; ?></option>
                        <?php }?>
                    </select>
                    
                </div>
                    
                
            </div>
        </div>
        </div>
            
            <div id="section_<?php echo $widgetCount; ?>"  class="boolean_section">
        <input type="hidden" name="ExtendedSurveyForm[BooleanValues][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_Boolean_hid_<?php echo $widgetCount; ?>" class="booleanhidden"/>
            <?php for ($i = 1; $i <= $radioLength; $i++) { ?>
                <input type="hidden" name="ExtendedSurveyForm[BooleanRadioOption][<?php echo $i . "_" . $widgetCount; ?>]" id="ExtendedSurveyForm_RadioOption_hid_<?php echo $i . "_" . $widgetCount; ?>" class="booleanoptionhidden"/>
                
                <div class="normaloutersection">                    
                    <div class="normalsection">
                        <div class="surveyradiobutton"> <div class="onlinetestradio"><input type="radio" class="styled" name="radioinput" value="<?php echo $i ?>"></div></div>                        
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
            <input type="hidden" name="ExtendedSurveyForm[JustificationApplied][<?php echo $widgetCount; ?>]" value="0" id="ExtendedSurveyForm_JustificationApplied_<?php echo $widgetCount; ?>"/>
            <div id="appliedtoAll_<?php echo $widgetCount; ?>" class="padding-bottom10 justapplied" data-questionid="<?php echo $widgetCount; ?>">
                <input class="styled" type="checkbox" name="applytoall_<?php echo $widgetCount; ?>" data-questionid="<?php echo $widgetCount; ?>" /> <label> <?php echo Yii::t("translation","Ex_BJustification_Apply"); ?></label>
            </div>
                <div class="normaloutersection boolean_other" id="boolean_other_<?php echo $widgetCount; ?>">
                <div class="normalsection normalsection5">

                    <div class="row-fluid booleantextareadiv" style="display:none" id="rowfluidBooleanChars_<?php echo $widgetCount; ?>">
                        <div class="span12">     
                            
                            <textarea name="ExtendedSurveyForm[BooleanPlaceholderValues][<?php echo $widgetCount; ?>]" placeholder="Enter Placeholder's value" class="span12 booleantextarea notallowed" id="qAaTextarea_<?php echo $widgetCount; ?>" data-hname="ExtendedSurveyForm_BooleanPlaceholderValues_hid_<?php echo $widgetCount; ?>" ></textarea>     
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
    $("input:radio[name=theme]").click(function() {
    var value = $(this).val();
});


    
</script>