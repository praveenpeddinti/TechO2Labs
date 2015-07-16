<div class="row-fluid">
    <div class="span12 questionwidget">
        <div class="control-group controlerror">
            <div class="span1" style="width:0.1%">
                <b class="child"><label class="questionlabel" data-wid="<?php echo ($i + 1); ?>" style="cursor: pointer;"><b class="questionno_ex" data-wid="<?php echo ($i + 1); ?>" data-placement="bottom" rel="tooltip"  data-original-title="minimize"><?php echo ($i + 1); ?>)</b> </label></b>                                    
            </div>

            <div class="span11">

                
                <div contenteditable="true" onkeyup="copyquestion(this.id)" onblur="copyquestion(this.id)" type="text"  class="span12 textfield divstyle divcontentwidget" maxlength="5000" id="ExtendedSurveyForm_div_Question_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_Question_<?php echo ($i + 1); ?>"><?php echo $question['Question']; ?></div>
                <input type="hidden"  value="<?php echo htmlspecialchars(addslashes($question['Question'])); ?>" type="text" name="ExtendedSurveyForm[Question][<?php echo ($i + 1); ?>]" class="span12 textfield notallowed" id="ExtendedSurveyForm_Question_<?php echo ($i + 1); ?>"/>

            </div>
            <div class="questionlabel positionabsolutediv q_minimize" style=" "><i class="icon-minus-sign" style="font-size:18px;" data-placement="bottom" rel="tooltip"  data-original-title="minimize"></i> </div>
            <div style="display:none" id="ExtendedSurveyForm_Question_<?php echo ($i + 1); ?>_em_" class="errorMessage questionserror" data-questionno="<?php echo ($i + 1); ?>" ></div>

        </div>
    </div>
</div>
<div id="spinner_<?php echo ($i + 1); ?>" style="position:relative;"></div>

