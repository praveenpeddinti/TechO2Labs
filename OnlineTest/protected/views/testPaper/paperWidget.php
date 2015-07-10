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
    <!--<input type="hidden" name="TestPaperForm[QuestionId][<?php //echo $CategoryId; ?>]" id="TestPaperForm_QuestionId_<?php //echo $CategoryId; ?>" />
    <input type="hidden" name="TestPaperForm[NoofQuestions]" id="TestPaperForm_NoofQuestions_<?php //echo $widgetCount; ?>" />
    <input type="hidden" name="TestPaperForm[CategoryTime]" id="TestPaperForm_CategoryTime_<?php //echo $widgetCount; ?>" />
    <input type="hidden" name="TestPaperForm[NoofPoints]" id="TestPaperForm_NoofPoints_<?php //echo $widgetCount; ?>" />-->
    <input type="hidden" name="TestPaperForm[CategoryName]" id="TestPaperForm_CategoryName_<?php echo $widgetCount; ?>" value="<?php echo $CategoryName;?>"/>
    <input type="hidden" name="TestPaperForm[ScheduleId]" id="TestPaperForm_ScheduleId_<?php echo $widgetCount; ?>" value="<?php echo $TestPaperForm->ScheduleId;?>"/>
    <input type="hidden" name="TestPaperForm[CategoryId]" id="TestPaperForm_CategoryId_<?php echo $widgetCount; ?>" value="<?php echo $TestPaperForm->CategoryId;?>"/> 
    <div class="divtable ">
           
    <div class="divrow">
        <div class="divcol1"> <label class="divtablelabel">
            <?php echo $CategoryName;?> <span rel="tooltip" data-original-title="TotalQuestion(s)">(<?php echo $QuestionsCount;?>)</span> <span rel="tooltip" data-original-title="ReviewQuestion(s)">(<?php echo $OtherQuestions;?>)</span><span rel="tooltip" data-original-title="SuspendedQuestion(s)">(<?php echo $SuspendedQuestions;?>)</span></label></div>
        <div class="divcol2">
           <?php echo $form->textField($TestPaperForm, 'NoofQuestions', array('id' => 'TestPaperForm_NoofQuestions_'.$widgetCount, 'maxlength' => 3, 'class' => 'form-control','onkeypress' => "return isNumberKey(event)" ,'onkeyup' => "return QuestionsValid(event,'$WithoutSupQuestions')",'onblur' => "return ScoreDiv(this.value,'$widgetCount')")); ?>
                        <div class="control-group controlerror">
                            <?php echo $form->error($TestPaperForm, 'NoofQuestions_'.$widgetCount); ?>
                        </div>

        </div>
        <div class="divcol3">
            <div class="positionrelative">
            <?php //echo $form->textField($TestPaperForm, 'CategoryTime', array('id' => 'TestTakerForm_CategoryTime_'.$widgetCount, 'maxlength' => 3, 'class' => 'span12','onkeypress' => "return isNumberKey(event)")); ?>
                        <select  name="TestPaperForm[CategoryTime]" class="styled" id="CategoryTime_<?php echo $widgetCount;?>" style="width: 100%;margin-bottom:0">
                        <option value="">Time</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        </select>
                        <div class="control-group controlerror">
                            <?php echo $form->error($TestPaperForm, 'CategoryTime_'.$widgetCount); ?>
                        </div>
            </div>

        </div>
        <div class="divcol4 ">
            <div class="positionrelative">
            <?php //echo $form->textField($TestPaperForm, 'NoofPoints', array('id' => 'TestTakerForm_NoofPoints_'.$widgetCount, 'maxlength' => 3, 'class' => 'span12','onkeypress' => "return isNumberKey(event)")); ?>
                <select  name="TestPaperForm[NoofPoints]" class="styled" id="NoofPoints_<?php echo $widgetCount;?>" style="width: 100%;margin-bottom:0">
                        <option value="">Score</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        </select>        
            
            <div class="control-group controlerror">
                            <?php echo $form->error($TestPaperForm, 'NoofPoints_'.$widgetCount); ?>
                        </div>
                </div>
        </div>
        <div class="divcol5" style="vertical-align: middle">
        <div class="reviewquestion" style="<?php if($OtherQuestions=='0'){echo "display:none";}else{echo "display:block";}?>">
            <input type="hidden" value="<?php if($OtherQuestions=='0'){echo "0";}else{echo "1";}?>" name="TestPaperForm[ReviewQuestion]" id="ReviewQuestion_<?php echo $widgetCount;?>" />
            <input type="checkbox"  <?php if(($Flag=='Edit') || ($Flag=='View')){ if($TestPaperForm->ReviewQuestion==1){?> checked="checked" <?php } }?>class="styled" data-qid="<?php echo $widgetCount; ?>" data-otherQ="<?php echo $OtherQuestions; ?>" />
            <div class="" style="line-height:25px;disable:none" id="reQues_<?php echo $widgetCount;?>"></div>
        </div>
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
       <?php if(($Flag=='Edit') || ($Flag=='View')){?>
               ScoreDiv('<?php echo $TestPaperForm->NoofQuestions;?>','<?php echo $widgetCount;?>');
             $("#CategoryTime_<?php echo $widgetCount;?>").val('<?php echo $TestPaperForm->CategoryTime;?>');
              $("#NoofPoints_<?php echo $widgetCount;?>").val('<?php echo $TestPaperForm->NoofPoints;?>');
              $("#ReviewQuestion_<?php echo $widgetCount;?>").val('<?php echo $TestPaperForm->ReviewQuestion;?>');
              
       <?php }?>
       
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
    
    function QuestionsValid(evt,totalQuestions){
    var id = evt.target.id;    
    var value = $("#"+id).val();
       if((Number(value) > Number(totalQuestions))){
           $("#"+id).val("");
           return false;
       }
    
    
    return true;
}
function ScoreDiv(value,no){
        
    $("#CategoryTime_"+no).find('option').remove();
    $("#NoofPoints_"+no).find('option').remove();

    $("#CategoryTime_"+no).append('<option value="">Time</option>');
    $("#NoofPoints_"+no).append('<option value="">Score</option>');
    Time=Number(value);
    

    for(i=1;i<=5;i++){
    $("#CategoryTime_"+no).append('<option value="'+Time+'">'+Time+'</option>');
    $("#NoofPoints_"+no).append('<option value="'+Time+'">'+Time+'</option>');
    Time=(Number(Time)+Number(value));
    }
    
}
   
</script>