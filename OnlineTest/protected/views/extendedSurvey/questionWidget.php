<div class="QuestionWidget" data-questionId="<?php echo $widgetCount; ?>" style="padding:15px 20px 15px 10px" id="QuestionWidget_<?php echo $widgetCount; ?>">       
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'questionWidget_' . $widgetCount,
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'class' => "questionwidgetform",
            'style' => 'margin: 0px; accept-charset=UTF-8',
        ),
    ));
    ?>    
    <input type="hidden" name="ExtendedSurveyForm[WidgetType][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_WidgetType_<?php echo $widgetCount; ?>" value="1" />
    <input type="hidden" name="ExtendedSurveyForm[QuestionId][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_QuestionId_<?php echo $widgetCount; ?>" /> 
    
    <div style="display: none;" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo "$widgetCount"; ?>_em_" class="alert alert-error " data-questionno="<?php echo "$widgetCount"; ?>" >
                        
                        </div>
    <div class="surveyquestionsbox">
        <div class="surveyareaheader">
            <div class="subsectionremove" data-questionId="<?php echo $widgetCount; ?>">
                <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Remove question"/>
            </div>
            <div class="row-fluid">
                <div class="span12 questionwidget positionrelative">
                    <div class="control-group controlerror">
                        <div class="span1" style="width:0.1%">
                            <b class="child"><label class="" data-wid="<?php echo $widgetCount; ?>" style="cursor: pointer;"><b class="questionno_ex" data-wid="<?php echo $widgetCount; ?>" data-placement="bottom" rel="tooltip"  data-original-title="Question no."><?php echo $widgetCount; ?>)</b> </label></b>
                        </div>
                        <div class="span11">
                            <div class="control-group controlerror"> 
                                <div contenteditable="true" placeholder="Enter Question <?php echo $widgetCount; ?> here..." name="ExtendedSurveyForm[Question][<?php echo $widgetCount; ?>]" class="span12 textfield questionname notallowed divstyle" maxlength="20000" id="ExtendedSurveyForm_div_Question_<?php echo $widgetCount; ?>" onkeyup="copyquestion(this.id)" onblur="copyquestion(this.id)" data-hiddenname="ExtendedSurveyForm_Question_<?php echo ($widgetCount); ?>" ></div>
                                <input type="hidden"  value="<?php echo htmlspecialchars(addslashes($question['Question'])); ?>" type="text" name="ExtendedSurveyForm[Question][<?php echo ($i + 1); ?>]" class="span12 textfield notallowed" id="ExtendedSurveyForm_Question_<?php echo $widgetCount; ?>"/>
<!--                            <input type="text" placeholder="Enter Question <?php //echo $widgetCount; ?> here..." name="ExtendedSurveyForm[Question][<?php //echo $widgetCount; ?>]" class="span12 textfield questionname notallowed" maxlength="1000" id="ExtendedSurveyForm_Question_<?php //echo $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>-->
                        <div style="display:none" id="ExtendedSurveyForm_Question_<?php echo "$widgetCount"; ?>_em_" class="errorMessage questionserror" data-questionno="<?php echo "$widgetCount"; ?>" >
                        
                        </div>
                            </div>
                        </div>
                        <div class="questionlabel positionabsolutediv q_minimize" style=" "><i class="icon-minus-sign" style="font-size:18px;" data-placement="bottom" rel="tooltip"  data-original-title="minimize"></i> </div>
                    </div>
                </div>
            </div>
            <div id="spinner_<?php echo $widgetCount; ?>" style="position:relative;"></div>
        </div>
        
                        
        <div class="surveyanswerarea" id="surveyanswerarea_<?php echo $widgetCount; ?>" data-questionId="<?php echo $widgetCount; ?>">
            
            <?php include 'radioWidget.php' ?>
    </div>
                    


<?php $this->endWidget(); ?>
</div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        Custom.init();        
    });
    $("[rel=tooltip]").tooltip();
    <?php if(empty($surveyId) || $isAlreadySchedule == 0){ ?>
    $("#othersarea_<?php echo $widgetCount; ?> span").live('click', function() {
        var isChecked = 0;
        if ($('#othercheck_<?php echo $widgetCount; ?>').is(':checked')) {
            isChecked = 1;
            $("#otherTextdiv_<?php echo $widgetCount; ?>").show();
        } else {
            $("#otherTextdiv_<?php echo $widgetCount; ?>").hide();
        }
        $("#ExtendedSurveyForm_Other_<?php echo $widgetCount; ?>").val(isChecked);       

    }); 
    <?php } ?>

    $(".selectoptions").die().live('change',function(){
        var $this = $(this);
        var questionno = $this.attr("data-questionid");
        var value = $this.val();
       
        var sType = $this.attr("data-optionType");
        var totalOptions = 0;
        //var sType = "";
        $("input[name='" + sType + "_" + questionno + "']").each(function(key, value) {
            totalOptions++;
        });
        var optionstoberendered = value-totalOptions;
        
       var URL = "/extendedSurvey/addMoreOptions";
       var booleanTypeS = 0;
       if(sType == "boolean"){
           booleanTypeS = $("#booleantypes_"+questionno).val();
       }     
       scrollPleaseWait("questionspinner_"+questionno);
        if(optionstoberendered > 0 ){
            // increment options      
            ajaxRequest(URL, "questionNo=" + questionno+"&sType="+sType+"&oc="+optionstoberendered+"&totalOptions="+totalOptions+"&booleanTypeS="+booleanTypeS, function(data) {
                    renderOptionswidgetHandler(data, questionno, sType)
            }, "html");
            
        }else{
            // decrement options
            removeOptions(questionno,sType,value);
            
        }
        
    });
    
    function renderOptionswidgetHandler(html,questionno, optionType){
        scrollPleaseWaitClose("questionspinner_"+questionno);        
        if(optionType != "boolean"){            
            $(html).insertBefore("#othersarea_" + questionno);
        }
        else
            $("#section_"+questionno).append(html);
    }
    
    function removeOptions(qNo,sType,value){
        scrollPleaseWaitClose("questionspinner_"+qNo);
        var totOptions = 0;
        var hidId = 0;
        $("input[name='" + sType + "_" + qNo + "']").each(function(key, value) {
            totOptions++;
        });
        for(var iv = totOptions; iv>value; iv--){
            if(sType == "radio"){
                 hidId = $("#ExtendedSurveyForm_RadioOption_"+iv+"_"+qNo).attr("data-hiddenname");
                $("#ExtendedSurveyForm_RadioOption_"+iv+"_"+qNo).closest("div.normaloutersection").remove();    
                if(hidId != 0){                    
                    $("#"+hidId).remove();
                }
            }else if(sType == "checkbox"){
                 hidId = $("#ExtendedSurveyForm_CheckboxOption_"+iv+"_"+qNo).attr("data-hiddenname");
                $("#ExtendedSurveyForm_CheckboxOption_"+iv+"_"+qNo).closest("div.normaloutersection").remove();
                if(hidId != 0){                    
                    $("#"+hidId).remove();
                }
            }else{
                 hidId = $("#ExtendedSurveyForm_RadioOption_"+iv+"_"+qNo).attr("data-hiddenname");
                $("#ExtendedSurveyForm_RadioOption_"+iv+"_"+qNo).closest("div.normaloutersection").remove();
                if(hidId != 0){                    
                    $("#"+hidId).remove();
                }
            }
        }
    }
    //initializeplayer();
    
    
    
    
</script>