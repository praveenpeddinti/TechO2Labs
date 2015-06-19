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
    <input type="hidden" name="TestPaperForm[NoofQuestions][<?php echo $widgetCount; ?>]" id="TestPaperForm_NoofQuestions_<?php echo $widgetCount; ?>" value="1" />
    <input type="hidden" name="TestPaperForm[CategoryTime][<?php echo $widgetCount; ?>]" id="TestPaperForm_CategoryTime_<?php echo $widgetCount; ?>" />
    <input type="hidden" name="TestPaperForm[NoofPoints][<?php echo $widgetCount; ?>]" id="TestPaperForm_NoofPoints_<?php echo $widgetCount; ?>" />
    <input type="hidden" name="TestPaperForm[CategoryName]" id="TestPaperForm_CategoryName_<?php echo $widgetCount; ?>" value="<?php echo $CategoryName;?>"/>
    
    
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
                        <label># Questions</label>
                    </div>
                    <div class="span2">
                        <label>Time</label>
                    </div>
                    <div class="span2">
                        <label>Score</label>
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
                    <div class="span2 positionrelative">
                        <select  name="TestPaperForm[NoofQuestions]" class="" id="No_of_Questions_<?php echo $widgetCount;?>" class="span8">
                        <option value="">Questions</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        </select>
                        <div class="control-group controlerror">
                            <?php echo $form->error($TestPaperForm, 'NoofQuestions_'.$widgetCount); ?>
                        </div>
                    </div>
                    <div class="span2 positionrelative">
                        <select  name="TestPaperForm[CategoryTime]" class="" id="CategoryTime_<?php echo $widgetCount;?>" class="span8">
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
                    <div class="span2 positionrelative">
                        <select  name="TestPaperForm[NoofPoints]" class="" id="No_of_Points_<?php echo $widgetCount;?>" class="span8">
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
                    <div class="span2 reviewquestion">
                        <input type="hidden" value="0" name="TestPaperForm[ReviewQuestion]" id="ReviewQuestion_<?php echo $widgetCount;?>" />
                        <input  type="checkbox" class="styled" data-qid="<?php echo $widgetCount; ?>" />
                    </div>
                </div>
            </div>
            <div id="spinner_<?php echo $widgetCount; ?>" style="position:relative;"></div>
        </div>
        
        

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
    
</script>