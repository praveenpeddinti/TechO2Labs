<div class="QuestionWidget" data-questionId="<?php echo $widgetCount; ?>" style="padding:0px" id="QuestionWidget_<?php echo $widgetCount; ?>">       
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
    <input type="hidden" name="TestPaperForm[NoofQuestions]" id="TestPaperForm_NoofQuestions_<?php echo $widgetCount; ?>" />
    <input type="hidden" name="TestPaperForm[CategoryTime]" id="TestPaperForm_CategoryTime_<?php echo $widgetCount; ?>" />
    <input type="hidden" name="TestPaperForm[NoofPoints]" id="TestPaperForm_NoofPoints_<?php echo $widgetCount; ?>" />
    <input type="hidden" name="TestPaperForm[CategoryName]" id="TestPaperForm_CategoryName_<?php echo $widgetCount; ?>" value="<?php echo $CategoryName;?>"/>
    
    <div class="divtable ">
           
    <div class="divrow">
        <div class="divcol1"> <label class="divtablelabel"><?php echo $CategoryName;?> (<?php echo $QuestionsCount;?>)</label></div>
        <div class="divcol2">
           <?php echo $form->textField($TestPaperForm, 'NoofQuestions', array('id' => 'TestTakerForm_NoofQuestions_'.$widgetCount, 'maxlength' => 3, 'class' => 'span12','onkeypress' => "return isNumberKey(event)" ,'onkeyup' => "return QuestionsValid(event,'$QuestionsCount')")); ?>
                        <div class="control-group controlerror">
                            <?php echo $form->error($TestPaperForm, 'NoofQuestions_'.$widgetCount); ?>
                        </div>

        </div>
        <div class="divcol3">
            <?php echo $form->textField($TestPaperForm, 'CategoryTime', array('id' => 'TestTakerForm_CategoryTime_'.$widgetCount, 'maxlength' => 3, 'class' => 'span12','onkeypress' => "return isNumberKey(event)")); ?>
                        <div class="control-group controlerror">
                            <?php echo $form->error($TestPaperForm, 'CategoryTime_'.$widgetCount); ?>
                        </div>

        </div>
        <div class="divcol4">
            <?php echo $form->textField($TestPaperForm, 'NoofPoints', array('id' => 'TestTakerForm_NoofPoints_'.$widgetCount, 'maxlength' => 3, 'class' => 'span12','onkeypress' => "return isNumberKey(event)")); ?>
                        <div class="control-group controlerror">
                            <?php echo $form->error($TestPaperForm, 'NoofPoints_'.$widgetCount); ?>
                        </div>
        </div>
        <div class="divcol5">
            <input type="hidden" value="0" name="TestPaperForm[ReviewQuestion]" id="ReviewQuestion_<?php echo $widgetCount;?>" />
                        <input  type="checkbox" class="styled" data-qid="<?php echo $widgetCount; ?>" />
        </div>
        <div class="divcol6"> <div class="subsectionremove subsectionremoveintable" data-questionId="<?php echo $widgetCount; ?>">
                <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Remove Category"/>
            </div></div>
   
            
          
            <div id="spinner_<?php echo $widgetCount; ?>" style="position:relative;"></div>
       
        
        

<?php $this->endWidget(); ?>

        </div>
         
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
    
    function QuestionsValid(evt,totalQuestions)
{
    var id = evt.target.id;    
    var value = $("#"+id).val();
       
       if((Number(value) > Number(totalQuestions))){
           $("#"+id).val("");
           return false;
       }
    
    
    return true;
}
    
</script>