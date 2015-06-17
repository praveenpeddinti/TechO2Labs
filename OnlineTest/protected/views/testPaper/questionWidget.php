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
    <input type="hidden" name="TestPaperForm[WidgetType][<?php echo $widgetCount; ?>]" id="TestPaperForm_WidgetType_<?php echo $widgetCount; ?>" value="1" />
    <input type="hidden" name="TestPaperForm[QuestionId][<?php echo $CategoryId; ?>]" id="TestPaperForm_QuestionId_<?php echo $CategoryId; ?>" />
    <input type="hidden" name="CategoryId" id="CategoryId" value="<?echo $CategoryId;?>"/>
    
    <div class="surveyquestionsbox">
        <div class="surveyareaheader">
            <div class="subsectionremove" data-questionId="<?php echo $widgetCount; ?>">
                <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Remove Category"/>
            </div>
            
            <div class="row-fluid">
                <div class="span12">
                    <div class="span2">
                        <label></label>
                    </div>
                    <div class="span2">
                        <label>No of Questions</label>
                    </div>
                    <div class="span2">
                        <label>No of Time</label>
                    </div>
                    <div class="span2">
                        <label>No of Points</label>
                    </div>
                    <div class="span2">
                        <label>Review Question</label>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="span2">
                        <label><?php echo $CategoryName;?></label>
                    </div>
                    <div class="span2">
                        <input type="text" placeholder="No of Questions" name="TestPaperForm[Question][<?php echo $widgetCount; ?>]" class="span3" id="TestPaperForm_Question_<?php echo $widgetCount; ?>" />
                    </div>
                    <div class="span2">
                        <input type="text" placeholder="No of Time " name="TestPaperForm[Question][<?php echo $widgetCount; ?>]" class="span3" id="TestPaperForm_Question_<?php echo $widgetCount; ?>" />
                    </div>
                    <div class="span2">
                        <input type="text" placeholder="No of Points " name="TestPaperForm[Question][<?php echo $widgetCount; ?>]" class="span3" id="TestPaperForm_Question_<?php echo $widgetCount; ?>" />
                    </div>
                    <div class="span2">
                        <input type="checkbox" name="TestPaperForm[Question][<?php echo $widgetCount; ?>]" id="TestPaperForm_Question_<?php echo $widgetCount; ?>" />
                    </div>
                </div>
            </div>
            <div id="spinner_<?php echo $widgetCount; ?>" style="position:relative;"></div>
        </div>
        
        

<?php $this->endWidget(); ?>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        Custom.init();        
    });
    $("[rel=tooltip]").tooltip();
    

    
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
    
</script>