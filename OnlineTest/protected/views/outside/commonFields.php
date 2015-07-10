            <input type="hidden" name="QuestionsSurveyForm[IsReviewed][<?php echo ($i); ?>]" value="<?php echo $question['IsReviewed']; ?>">

<input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="1" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
<input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
<input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["Other"]?>"/>
<input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["OtherValue"]?>"/>
<input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if(isset($userAnswer) && sizeof($userAnswer) > 0){ echo implode(",", $userAnswer);} ?>"/>