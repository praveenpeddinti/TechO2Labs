<?php
$i = 0;
if(!empty($surveyObj) && sizeof($surveyObj)>0){    

    foreach ($surveyObj->Questions as $question) {
    if ($question['QuestionType'] == 1) {
        ?>

        <div class="QuestionWidget child" data-questionId="<?php echo ($i + 1); ?>" style="position:relative;padding:15px 20px 15px 10px;" id="QuestionWidget_<?php echo ($i + 1); ?>">       
           <?php if($question['IsSuspended']==1){?> 
            <div class='suspendcontentdiv' data-qid='<?php echo ($i + 1); ?>'>
                <div class='btn'>Click here to Resume</div>
            </div>
            <div class='suspenddiv' id='suspenddiv_<?php echo ($i + 1); ?>'></div>
            <?php } ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionWidget_' . ($i + 1),
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
            <!--<form name="questionWidget_<?php //echo ($i + 1); ?>" id="questionWidget_<?php //echo ($i + 1); ?>" >-->
            <input type="hidden" name="ExtendedSurveyForm[WidgetType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_WidgetType_<?php echo ($i + 1); ?>" value="1" />
            <input type="hidden" name="ExtendedSurveyForm[QuestionId][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_QuestionId_<?php echo ($i + 1); ?>" value="<?php echo $question['QuestionId']; ?>"/>
            <input type="hidden" name="ExtendedSurveyForm[AnswerSelected][<?php echo ($i + 1); ?>]"   id="ExtendedSurveyForm_answerSelected_<?php echo ($i + 1); ?>" value="<?php echo $question['Answers'][0]?>" />
            <input type="hidden" name="ExtendedSurveyForm[IsSuspend][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsSuspend_<?php echo ($i + 1); ?>" value="<?php echo $question['IsSuspended']; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>" value="1"/>
            <div class="surveyquestionsbox">
                 
                <div class="surveyareaheader">
                    <?php //if($isAlreadySchedule != 1){ ?>
                    <div class="subsectionremoveEdit" data-questionId="<?php echo ($i + 1); ?>">
                        <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Suspend question"/>
                    </div>
                    <?php //} ?>
                    
                    <?php include 'EditQuestionsWidget.php'; ?>
                    
                </div>

                <div class="surveyanswerarea" id="surveyanswerarea_<?php echo ($i + 1); ?>" >
                    
                    <div class="paddingtblr1030">                        
                        
                        <?php include 'EditWidgetOptions.php'; ?>
                        <?php  include 'fileuploaderdivs.php'; ?>
                        <div class="tab_1" style="margin-top:10px">

                            <div class="dropdownsectionarea dropdownmedium">
                                <div class="row-fluid ">
                                    <div class="span12 positionrelative" >
                                        <div class="span3 positionabsolutediv " style="right:0; ">
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> name="selectoptions_<?php echo ($i + 1); ?>" class="styled selectoptions" style="width:100%;" data-optionType="radio" data-questionid="<?php echo ($i + 1); ?>">
                                                <?php for($opt=1;$opt<=30;$opt++){ ?>
                                                <option value="<?php echo $opt; ?>" <?php if($opt == sizeof($question['Options'])) echo "selected"; ?>><?php echo $opt." option(s)"; ?></option>
                                                <?php }?>
                                            </select>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                            <div class="answersection1" id="answersection1_<?php echo ($i + 1); ?>" data-questionId="<?php echo ($i + 1); ?>" data-optionType="radio">
                                <?php $j = 0; 
                                //echo "<pre>", print_r($question,true),"</pre>";
                                foreach ($question['Options'] as $rw) { ?>
                                    <input type="hidden" name="ExtendedSurveyForm[RadioOption][<?php echo ($j + 1) . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_RadioOption_hid_<?php echo ($j + 1) . "_" . ($i + 1); ?>" class="radiohidden" value="<?php echo $rw; ?>"/>
                                    <div class="normaloutersection">
                                        
                                        <div class="normalsection">
                                            <div class="surveyradiobutton onlinetestradio"> <input value="<?php echo ($j+1) ?>" type="radio" class="styled " name="radioinput" <?php if($question['Answers'][0] == ($j+1)){?>checked="checked" <?php }?> ></div>                                            
                                            <div class="row-fluid">
                                                <div class="span12">

                                                    <input value="<?php echo $rw; ?>" placeholder="Option Name" type="text" class="textfield span12 radiotype notallowed" data-hiddenname="ExtendedSurveyForm_RadioOption_hid_<?php echo ($j + 1) . "_" . ($i + 1); ?>"  name="radio_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_RadioOption_<?php echo ($j + 1) . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)" />
                                                    <div class="control-group controlerror"> 
                                                        <div style="display:none" id="ExtendedSurveyForm_RadioOption_<?php echo ($j + 1) . "_" . ($i + 1); ?>_em_" class="errorMessage radioEmessage"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php $j++;
                            } ?>
                                <input type="hidden" name="ExtendedSurveyForm[Other][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_Other_<?php echo ($i + 1); ?>" class="otherhidden" value="<?php echo $question['Other']; ?>"/>
                                <input type="hidden" name="ExtendedSurveyForm[OtherValue][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_OtherValue_<?php echo ($i + 1); ?>" class="otherhiddenvalue" value="<?php echo $question['OtherValue']; ?>"/>
                                
                                
                                
                                <div class="normaloutersection">
                                <div class="normalsection othersarea" id="othersarea_<?php echo ($i + 1); ?>">
                                    <div class="surveyradiobutton"> <input value="<?php echo $question['Other']; ?>" <?php if($question['Other'] == 1) echo "checked='true'"; ?>  type="checkbox" class="styled othercheck" name="1" id="othercheck_<?php echo ($i + 1); ?>" /> Other  </div>  
                                    <div class="row-fluid otherTextdiv" <?php if($question['Other'] != 1){ ?> style="display: none;" <?php } ?> id="otherTextdiv_<?php echo ($i + 1); ?>">
                                        <div class="span12">
                                            <div class="control-group controlerror"> 
                                                <input type="text" placeholder="Other Value" id="otherText_<?php echo ($i + 1); ?>" class="span12 textfield othertext notallowed"  data-hiddenname="ExtendedSurveyForm_OtherValue_<?php echo ($i + 1); ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)" value="<?php echo $question['OtherValue']; ?>"/>
                                                <div class="control-group controlerror">
                                                    <div style="display:none"  id="ExtendedSurveyForm_OtherValue_<?php echo ($i + 1); ?>_em_" class="errorMessage othererr"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>

                            </div> 
                           </div> 

                        </div>
                    </div>
                </div>
            </div>


        <?php $this->endWidget(); ?>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                Custom.init();
            });
            $("[rel=tooltip]").tooltip();
            $("#othersarea_<?php echo ($i+1); ?> span").live('click', function() {
                    var isChecked = 0;     
                   
                    if ($('#othercheck_<?php echo ($i+1); ?>').is(':checked')) {
                        isChecked = 1;
                        $("#otherTextdiv_<?php echo ($i+1); ?>").show();
                    } else {
                        $("#otherTextdiv_<?php echo ($i+1); ?>").hide();
                    }
                    $("#ExtendedSurveyForm_Other_<?php echo ($i+1 ); ?>").val(isChecked);

                });
                
//                 $(".onlinetestradio").die().live("click",function(){ 
//       var $this = $(this);
//       var radiovalue = "";
//        var qId = $this.closest('div.answersection1').attr("data-questionId");
//        var qtype = $this.closest('div.answersection1').attr("data-qtype");
//         if(qtype == 3){
//            var i = $this.attr("data-info");
//            //radiovalue=$("input[name='radio_"+i+"_"+qId+"']:checked").val();
//            $(".radiotype_"+qId).each(function(){
//                      var $this = $(this);
//                           if($(this).is(":checked")){
//                               if(radiovalue == ""){
//                                   radiovalue = $this.val();
//                               }else{
//                                   radiovalue = radiovalue+","+$this.val();  
//                               }
//                           }
//                           
//                        }); 
//            
//           //alert(radiovalue) 
//                   
//        }else{
//            radiovalue=$("input[name='radioinput']:checked").val();
//           //alert(radiovalue) 
//        }
//        $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val(1);
//      $("#ExtendedSurveyForm_answerSelected_"+qId).val(radiovalue);
//    });
//    

        </script>

        <?php } else if ($question['QuestionType'] == 2) {
            ?>
        
        <div class="QuestionWidget child" data-questionId="<?php echo ($i + 1); ?>" style="position:relative; padding:15px 20px 15px 10px;" id="QuestionWidget_<?php echo ($i + 1); ?>">       
            
          <?php if($question['IsSuspended']==1){?> 
            <div class='suspendcontentdiv' data-qid='<?php echo ($i + 1); ?>'>
                <div class='btn'>Click here to Resume</div>
            </div>
            <div class='suspenddiv' id='suspenddiv_<?php echo ($i + 1); ?>'></div>
            <?php } ?>  
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionWidget_' . ($i + 1),
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
            <input type="hidden" name="ExtendedSurveyForm[WidgetType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_WidgetType_<?php echo ($i + 1); ?>" value="1" />
            <input type="hidden" name="ExtendedSurveyForm[QuestionId][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_QuestionId_<?php echo ($i + 1); ?>" value="<?php echo $question['QuestionId']; ?>"/>
            <input type="hidden" name="ExtendedSurveyForm[DisplayType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_DisplayType_<?php echo ($i + 1); ?>" value="<?php echo $question['DisplayType']; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[IsSuspend][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsSuspend_<?php echo ($i + 1); ?>" value="<?php echo $question['IsSuspended']; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>"  value="1"/>
            <input type="hidden" name="ExtendedSurveyForm[AnswerSelectedEdit][<?php echo ($i + 1); ?>]"   id="ExtendedSurveyForm_answerSelectedEdit_<?php echo ($i + 1); ?>" value="<?php echo $a = implode(',', $question['Answers']); ?>"/>
            <div style="display: none;" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>_em_" class="alert alert-error " data-questionno="<?php echo ($i + 1); ?>" ></div>
            <div class="surveyquestionsbox">
                
               <div class="surveyquestionsbox">
                  
                <div class="surveyareaheader">
                    <?php //if($isAlreadySchedule == 0){ ?>
                    <div class="subsectionremoveEdit" data-questionId="<?php echo ($i + 1); ?>">
                        <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Suspend question"/>
                    </div>
                    <?php //} ?>
                    <?php include 'EditQuestionsWidget.php'; ?>
                </div>

                <div class="surveyanswerarea" id="surveyanswerarea_<?php echo ($i + 1); ?>" >
                    <div class="paddingtblr1030">                        
                        <?php include 'EditWidgetOptions.php'; ?>
                        <?php  include 'fileuploaderdivs.php'; ?>
                        <div class="tab_1"  style="margin-top:10px">

                            <div class="dropdownsectionarea dropdownmedium">
                                <div class="row-fluid ">
                                    <div class="span12 positionrelative" >
                                        
                                            <div class="span9">

                                                <div class="span6">
                                                    <div class="pull-left labelalignment_c"><label class="rr_widget"><?php echo Yii::t("translation","Ex_DisplayType"); ?></label></div>
                                                    <div class="pull-left positionrelative">
                                                        <select <?php if($isAlreadySchedule != 0){ ?> disabled="true" <?php } ?> class="styled questionDisplayType" style="width:100%;" id="displaytype_<?php echo ($i + 1); ?>" name="displaytype_<?php echo ($i + 1); ?>" data-optionType="checkbox" data-questionid="<?php echo ($i + 1); ?>">
                                                    <option value="1" <?php if($question['DisplayType'] == 1) echo "selected='true'"; ?>><?php echo Yii::t("translation","Ex_DisplayType_Check"); ?></option>
                                                    <!--<option value="2" <?php //if($question['DisplayType'] == 2) echo "selected='true'"; ?>><?php //echo Yii::t("translation","Ex_DisplayType_Multi"); ?></option>-->
                                                </select>
                                                </div>

                                                </div>


                                            </div>
                                            
                                        <div class="span3 positionabsolutediv " style="right:0; ">
                                            <select name="selectoptions_<?php echo ($i + 1); ?>" <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> class="styled selectoptions" style="width:100%;"  data-optionType="checkbox" data-questionid="<?php echo ($i + 1); ?>" >
                                                <?php for($opt=1;$opt<=30;$opt++){ ?>
                                                <option value="<?php echo $opt; ?>" <?php if($opt == sizeof($question['Options'])) echo "selected"; ?>><?php echo $opt." option(s)"; ?></option>
                                                <?php }?>
                                            </select>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="answersection1" id="answersection1_<?php echo ($i + 1); ?>" data-questionId="<?php echo ($i + 1); ?>" data-optionType="checkbox">
        <?php $j = 0;        
        foreach ($question['Options'] as $rw) {
             ?>
                                    <input type="hidden" name="ExtendedSurveyForm[CheckboxOption][<?php echo ($j + 1) . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_CheckboxOption_hid_<?php echo ($j + 1) . "_" . ($i + 1); ?>" class="checkboxhidden" value="<?php echo $rw; ?>" />

                                    <div class="normaloutersection">                                        
                                        <div class="normalsection">
                                            <div class="surveyradiobutton"> 
                                                
                                                <div class="onlinetestcheckbox"><input type="checkbox" class="styled" name="answercheck_<?php echo $i + 1; ?>"<?php foreach($question['Answers'] as $a){if($a == ($j+1)){?>checked="checked" <?php }}?>></div></div>
                                            
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="control-group controlerror">
                                                        <input value="<?php echo $rw; ?>" placeholder="Option Name" type="text" class="textfield span12 checkboxtype notallowed"  name="checkbox_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_CheckboxOption_hid_<?php echo ($j + 1) . "_" . ($i + 1); ?>" id="ExtendedSurveyForm_CheckboxOption_<?php echo ($j + 1) . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)"/>
                                                        <div style="display:none"  id="ExtendedSurveyForm_CheckboxOption_<?php echo ($j + 1) . "_" . ($i + 1); ?>_em_" class="errorMessage radioEmessage checkboxEmessage"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            <?php $j++;
        } ?>
                                <input type="hidden" name="ExtendedSurveyForm[Other][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_Other_<?php echo ($i + 1); ?>" class="otherhidden" value="<?php echo $question['Other']; ?>"/>
                                <input type="hidden" name="ExtendedSurveyForm[OtherValue][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_OtherValue_<?php echo ($i + 1); ?>" class="otherhiddenvalue" value="<?php echo $question['OtherValue']; ?>"/>
                                
                                <div class="normaloutersection">
                                <div class="normalsection othersarea" id="othersarea_<?php echo ($i + 1); ?>">
                                    <div class="surveyradiobutton"> <input value="<?php echo $question['Other']; ?>" <?php if($question['Other'] == 1) echo "checked='true'"; ?>  type="checkbox" class="styled othercheck" name="1" id="othercheck_<?php echo ($i + 1); ?>" /> Other  </div>  
                                    <div class="row-fluid otherTextdiv" <?php if($question['Other'] != 1){ ?> style="display: none;" <?php } ?> id="otherTextdiv_<?php echo ($i + 1); ?>">
                                        <div class="span12">
                                            <div class="control-group controlerror"> 
                                                <input type="text" placeholder="Other Value" id="otherText_<?php echo ($i + 1); ?>" class="span12 textfield othertext notallowed"  data-hiddenname="ExtendedSurveyForm_OtherValue_<?php echo ($i + 1); ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)" value="<?php echo $question['OtherValue']; ?>"/>
                                                <div class="control-group controlerror">
                                                    <div style="display:none"  id="ExtendedSurveyForm_OtherValue_<?php echo ($i + 1); ?>_em_" class="errorMessage othererr"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>

                            </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>

        <?php $this->endWidget(); ?>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                Custom.init();
            });
            $("[rel=tooltip]").tooltip();
            // alert('<?php //echo ($i+1); ?>')
//            $("#othersarea_<?php echo ($i+1); ?> span").live('click', function() {
//                    var isChecked = 0;                         
//                    if ($('#othercheck_<?php echo ($i+1); ?>').is(':checked')) {
//                        isChecked = 1;
//                        $("#otherTextdiv_<?php echo ($i+1); ?>").show();
//                    } else {
//                        $("#otherTextdiv_<?php echo ($i+1); ?>").hide();
//                    }
//                    $("#ExtendedSurveyForm_Other_<?php echo ($i+1 ); ?>").val(isChecked);
//
//                });
//                
//                $(".onlinetestcheckbox").die().live("click",function(){
//                            var $this1 = $(this);
//                                   var checkboxvalues = "";
//                                     var qId = $this1.closest('div.answersection1').attr("data-questionId");
//                                      $("input[name='answercheck_" + qId + "']").each(function(key, value) {
//                                          var $this = $(this);
//                                          if($this.is(":checked")){ 
//                                              if(checkboxvalues == ""){
//                                                 checkboxvalues = key+1;
//                                             }else{
//                                                 checkboxvalues = checkboxvalues+","+(key+1);
//                                                 }
//                                                
//                                         }
//                          
//         });
//          //alert(checkboxvalues)
//          $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val(1);
//         $("#ExtendedSurveyForm_answerSelectedEdit_"+qId).val(checkboxvalues);
//         //alert(checkboxvalues)
//         
//    });
        </script>

        <?php } else if ($question['QuestionType'] == 3) { ?>
        
        <div class="QuestionWidget child" data-questionId="<?php echo ($i + 1); ?>" style="position:relative; padding:15px 20px 15px 10px;" id="QuestionWidget_<?php echo ($i + 1); ?>">       
            <?php if($question['IsSuspended']==1){?> 
            <div class='suspendcontentdiv' data-qid='<?php echo ($i + 1); ?>'>
                <div class='btn'>Click here to Resume</div>
            </div>
            <div class='suspenddiv' id='suspenddiv_<?php echo ($i + 1); ?>'></div>
            <?php } ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionWidget_' . ($i + 1),
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
            <input type="hidden" name="ExtendedSurveyForm[WidgetType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_WidgetType_<?php echo ($i + 1); ?>" value="1" />
            <input type="hidden" name="ExtendedSurveyForm[QuestionId][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_QuestionId_<?php echo ($i + 1); ?>" value="<?php echo $question['QuestionId']; ?>"/>
            <input type="hidden" name="ExtendedSurveyForm[IsSuspend][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsSuspend_<?php echo ($i + 1); ?>" value="<?php echo $question['IsSuspended']; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[AnswerSelected][<?php echo ($i + 1); ?>]"   id="ExtendedSurveyForm_answerSelected_<?php echo ($i + 1); ?>" value="<?php echo $a = implode(',', $question['Answers']); ?>"/>
            <input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>" value="1"/>
            <div class="surveyquestionsbox">
                
                 <div class="surveyquestionsbox">
                 
                <div class="surveyareaheader">
                   <?php //if($isAlreadySchedule == 0){ ?>
                    <div class="subsectionremoveEdit" data-questionId="<?php echo ($i + 1); ?>">
                        <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Suspend question"/>
                    </div>
                    <?php //} ?>
                    <?php include 'EditQuestionsWidget.php'; ?>
                </div>

                <div class="surveyanswerarea" id="surveyanswerarea_<?php echo ($i + 1); ?>" >
                    
                    <input type="hidden" name="ExtendedSurveyForm[MatrixType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_MatrixType_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['MatrixType']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[NoofOptions][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['NoofOptions']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[NoofRatings][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_NoofRatings_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['NoofRatings']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[TextOptions][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_TextOptions_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['TextOptions']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[Other][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_NA_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['Other']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[AnyOther][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_AnyOther_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['AnyOther']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[StylingOption][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_StylingOption_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['StylingOption']; ?>"/>
                    <div class="paddingtblr1030">
                        <?php include 'EditWidgetOptions.php'; ?>  
                        <?php  include 'fileuploaderdivs.php'; ?>
                        
                        <div class="tab_3">
                            <div class="dropdownsectionarea dropdownmedium answersection1" data-questionId="<?php echo ($i + 1); ?>">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span3">                                            
                                            <div class="pull-left positionrelative">
                                                <label class="rr_widget"><?php echo Yii::t("translation","RR_TypeofQuestion"); ?></label>
                                                <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> class="styled stypeofquestion" id="loadwidgetType_<?php echo ($i + 1); ?>" name="loadwidgetType_<?php echo ($i + 1); ?>" >
                                                    <option value="1" <?php if ($question['MatrixType'] == 1) echo "Selected" ?>>Ranking</option>
                                                    <option value="2" <?php if ($question['MatrixType'] == 2) echo "Selected" ?>>Rating</option>
                                                    <option value="3" <?php if ($question['MatrixType'] == 3) echo "Selected" ?>>Matrix</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="span3" id="stylingoptions_<?php echo ($i + 1); ?>" >
                                        
                                        <div class="pull-left positionrelative">
                                            <div class="pull-left labelalignment"></div>
                                            <label class="rr_widget">Styling option</label>
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?>  class="styled span6 stylingoptions" data-error="ExtendedSurveyForm_StylingType_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_StylingOption_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofCols_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_StylingType_<?php echo ($i + 1); ?>">
                                                <option value="1" <?php if($question['StylingOption'] == 1) echo "selected='true'"; ?>><?php echo Yii::t("translation","Ex_RRWidget_Static_Col"); ?></option>
                                                <option value="2" <?php if($question['StylingOption'] == 2) echo "selected='true'"; ?>><?php echo Yii::t("translation","Ex_RRWidget_OptionSize"); ?></option>
                                            </select>
                                            <div class="control-group controlerror">
                                                <div style="display:none"  id="ExtendedSurveyForm_StylingType_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="span3" <?php if($question['MatrixType'] == 3){ ?> style="display: none"<?php }?> id="OptionType_<?php echo ($i + 1); ?>">
                                            
                                            <div class="pull-left positionrelative">
                                                <label ><?php echo Yii::t("translation","ExOptionType");?></label>
                                                <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> class="styled stextoptions" style="width:184px"   data-idname="ExtendedSurveyForm_TextOptions_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_TextOptions_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_TextOptions_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_TextOptions_<?php echo ($i + 1); ?>">
                                                    <option value="1" <?php if ($question['TextOptions'] == 1) echo "Selected" ?>><?php echo Yii::t("translation","Radio_Options_only");?></option>

                                                    <option value="3" <?php if ($question['TextOptions'] == 3) echo "Selected" ?>><?php echo Yii::t("translation","Radio_with_Other_option");?></option>
                                                </select>
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="span3" id="TextMaxlengthdiv_<?php echo ($i + 1); ?>" <?php if($question['MatrixType'] != 3){ ?> style="display: none" <?php }?>>
                                        
                                        <div class="pull-left positionrelative">
                                            <label ><?php echo Yii::t("translation","Max_length");?></label>

                                            <input  class="textfield span12" placeholder="<?php echo Yii::t("translation","Max_length");?>"  type="text" maxlength="2" onkeydown="allowNumericsAndCheckFields(event)" onblur="allowNumericsAndCheckFields(event)" data-hiddenname="ExtendedSurveyForm_TextMaxlength_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_TextMaxlength_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm[TextMaxlength][<?php echo ($i + 1); ?>]" value="<?php echo $question['TextMaxlength']; ?>"></div>
                                        </div>
                                        <div class="span3" style="<?php if($question['MatrixType'] == 1){ echo 'margin:auto'; }else{ echo "display:none";}?>" id="noofoptionsdiv_<?php echo ($i + 1); ?>">
                                            
                                            <div class="pull-left positionrelative">
                                                <label class="rr_widget">No.of Options</label>
                                                <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?>  class="styled w150 snofooptions" data-error="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>">
                                                    <option value="">Please select</option>
        <?php for ($k = 1; $k <= 10; $k++) { ?>
                                                        <option value="<?php echo $k; ?>" <?php if ($question['NoofOptions'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
        <?php } ?>
                                                </select>
                                                <div class="control-group controlerror">
                                                    <div style="display:none"  id="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        
                                        
                                    
                                        
                                        
                                        <div class="span3" id="noofrowsdiv_<?php echo ($i + 1); ?>" <?php if($question['MatrixType'] == 1){ ?> style="display:none" <?php }  ?>>
                                        
                                        <div class="pull-left positionrelative">
                                            <label class="rr_widget">No.of Rows</label>
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?>  class="styled span6 snoofrows" data-error="ExtendedSurveyForm_NoofRows_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofRows_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofRows_<?php echo ($i + 1); ?>">
                                                <option value="">Please select</option>

                                                <?php for ($k = 1; $k <= 30; $k++) { ?>

                                                     <option value="<?php echo $k; ?>" <?php if ($question['NoofRatings'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
                                                     <?php } ?>
                                            </select>
                                            <div class="control-group controlerror">
                                                <div style="display:none"  id="ExtendedSurveyForm_NoofRows_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                        </div>
                                    </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        
                                        <div class="span3"  id="noofratingsdiv_<?php echo ($i + 1); ?>"  style="<?php if($question['MatrixType'] != 2) echo "display:none;"?>margin-top:5px">
                                            
                                            <div class="pull-left positionrelative">
                                                <label class="rr_widget">No.of Ratings</label>
                                                <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> style="width:150px" class="styled span6 ssoofRatings" data-error="ExtendedSurveyForm_NoofRatings_<?php echo ($i + 1); ?>_em_" data-idname="ExtendedSurveyForm_NoofRatings_" data-hiddenname="ExtendedSurveyForm_NoofRatings_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofRatings_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofRatings_<?php echo ($i + 1); ?>">
                                                    <option value="">Please select</option>
        <?php for ($k = 1; $k <= 10; $k++) { ?>
                                                        <option value="<?php echo $k; ?>" <?php if ($question['NoofRatings'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
        <?php } ?>
                                                </select>
                                                <div class="control-group controlerror">
                                                    <div style="display:none"  id="ExtendedSurveyForm_NoofRatings_<?php echo ($i + 1); ?>_em_" class="errorMessage">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php //if($question['MatrixType'] == 3){ ?>
                                    
                                    
                                    <div class="span3" id="noofcolsdiv_<?php echo ($i + 1); ?>" style="<?php if($question['MatrixType'] != 3) echo "display:none;"?>margin:auto;margin-top: 10px;">
                                        
                                        <div class="pull-left positionrelative">
                                            <label class="rr_widget">No.of Columns</label>
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?>  class="styled span6 snoofcols" data-error="ExtendedSurveyForm_NoofCols_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofRatings_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofCols_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofCols_<?php echo ($i + 1); ?>">
                                                <option value="">Please select</option>

                                                <?php for ($k = 1; $k <= 10; $k++) { ?>

                                                     <option value="<?php echo $k; ?>" <?php if ($question['NoofRatings'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
                                                     <?php } ?>
                                            </select>
                                            <div class="control-group controlerror">
                                                <div style="display:none"  id="ExtendedSurveyForm_NoofCols_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    
                                        
                                        </div>
                                    </div> 

                            
                            <div class="paddingtop12" >
                                <div id="rankingOrRating_<?php echo ($i + 1); ?>">
                                    <table cellpadding="0" cellspacing="0" class="customsurvaytable">
                                        <tr>
                                            <th class="col1"></th>
        <?php $j = 0;
        
        foreach ($question['LabelName'] as $rw) {
             ?>
                                            <input value="<?php echo $rw; ?>" type="hidden" name="ExtendedSurveyForm[LabelName][<?php echo ($j) . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_LabelName_hid_<?php echo ($j) . "_" . ($i + 1); ?>" class="label_hidden label_hidden_<?php echo ($i + 1); ?>"/>
                                            <th id="th_labelname_<?php echo ($j) . "_" . ($i + 1); ?>">
                                            <div class="surveydeleteaction positionrelative">             
                                                <input  value="<?php echo $rw; ?>" type="text" class="textfield textfieldtable notallowed labelnamewid_<?php echo ($i + 1); ?>" placeHolder="Label Name" name="LabelName_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_LabelName_hid_<?php echo ($j) . "_" . ($i + 1); ?>" id="ExtendedSurveyForm_LabelName_<?php echo ($j) . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
                                                <div class="control-group controlerror">
                                                    <div style="display:none"  id="ExtendedSurveyForm_LabelName_<?php echo ($j) . "_" . ($i + 1); ?>_em_" class="errorMessage" style="font-weight:normal"></div>
                                                </div>
                                            </div>
                                            <div class="surveydeleteaction pad_top10">             
                                                <input value="<?php echo $question['LabelDescription'][$j]; ?>" type="text" name="ExtendedSurveyForm[LabelDesc][<?php echo ($j) . "_" . ($i + 1); ?>]" class="textfield textfieldtable notallowed label_lDesc_<?php echo ($i + 1); ?>" placeHolder="Label Description" name="LabelName_<?php echo ($i + 1); ?>"  id="ExtendedSurveyForm_lDesc_<?php echo ($j) . "_" . ($i + 1); ?>"  maxlength="500">            
                                            </div>
                                            </th>  
            <?php $j++;
        } ?>
                                        <th></th>
                                        </tr>

        <?php $j = 0;
        
        foreach ($question['OptionName'] as $rw) {
            ?>

                                            <input value="<?php echo $rw; ?>" type="hidden" name="ExtendedSurveyForm[OptionName][<?php echo $j . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_OptionName_hid_<?php echo $j . "_" . ($i + 1); ?>" class="option_hidden option_hidden_<?php echo ($i + 1); ?>"/>
                                            <tr>
                                                <td>
                                                    <div class="control-group controlerror">
                                                        <input value="<?php echo $rw; ?>" type="text" placeholder="Option Name" class="textfield textfieldtable option_text notallowed optionnamewid_<?php echo ($i + 1); ?>" name="OptionName_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_OptionName_hid_<?php echo $j . "_" . ($i + 1); ?>" id="ExtendedSurveyForm_Ranking_<?php echo $j . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
                                                        <div style="display:none"  id="ExtendedSurveyForm_OptionName_<?php echo $j . "_" . ($i + 1); ?>_em_" class="errorMessage ranking_errmsg"></div>
                                                    </div>
                                                </td>
                                                    <?php if($question['TextOptions'] ==1 || $question['TextOptions'] == 3) {for ($k = 0; $k < sizeof($question['OptionName']); $k++) { ?>
                                                    <td>
                                                        <div class="answersection1" data-qtype="3" data-questionId="<?php echo ($i+1); ?>" id="answersection1_<?php echo ($i+1); ?>">
                                                        <div class="positionrelative displaytable onlinetestradio radioTable_<?php echo $k."_".($i+1); ?>" data-info="<?php echo $j; ?>">
                                                            <input type="radio" value="<?php echo ($k+1); ?>" class="styled ranking_radio radiotype_<?php echo ($i+1); ?>" <?php if($question['Answers'][$k] == ($j+1)){?>checked="checked" <?php }?> name="radio_<?php echo $j . "_" . ($i+1); ?>" data-qid="<?php echo ($i + 1); ?>" id="radio_<?php echo $j. "_" . ($i+1); ?>" />
                                                        </div>
                                                        </div>
                                                    </td>
                                                    <script type="text/javascript">
                                                                 
                                    
                                    
                                        $("div.radioTable_<?php echo $k."_".($i+1); ?> span.radio").live("click",function(){
                                            <?php //$ik++; ?>
                                        
                                        $("div.radioTable_<?php echo $k."_".($i+1); ?> span.radio").each(function(key){                                         
                                            $(this).attr("style","background-position:0 0");                                            
                                            $(this).siblings('.radiotype_<?php echo ($i+1); ?>').attr('checked',false);
                                        });                                        
                                         $(this).attr("style","background-position:0 -50px");
                                         $(this).siblings('.radiotype_<?php echo ($i+1); ?>').attr('checked',true);

                                    });
                                    
                                   
                                    
                                     
                                </script>
                            <?php } ?>
                                                    <?php if($question['TextOptions'] == 3){ ?>
                                                    <td>
                                                        <div class="positionrelative surveydeleteaction ">
                                                            <input type="hidden"  value="<?php echo $question['JustificationPlaceholders'][$j]; ?>" maxlength="50" class="rr_justification_hidden rr_justification_hidden_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm[JustificationPlaceholders][<?php echo $j . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_JustificationPlaceholders_<?php echo $j . "_" . ($i + 1); ?>" />
                                                            <input type="text" id="ExtendedSurveyForm_JustificationPlaceholderstext_<?php echo $j . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" data-hiddenname="ExtendedSurveyForm_JustificationPlaceholders_<?php echo $j . "_" . ($i + 1); ?>" class="textfield textfieldtable rr_justification notallowed rr_justification_<?php echo ($i + 1); ?>"  placeholder="Justification placeholder" value="<?php echo $question['JustificationPlaceholders'][$j]; ?>"/>
                                                        </div>
                                                   </td> 
                                                    <?php } ?>
            <?php }else if($question['TextOptions'] ==2){ for ($k = 0; $k < sizeof($question['OptionName']); $k++) {  ?> 
                                   <td>
                                                        <div class="positionrelative surveydeleteaction ">
                                                        <input type="text" class="textfield textfieldtable"  disabled="true" />
                                                        </div>
                                                   </td>                 
            <?php } } ?>
            


                                            </tr>
            <?php $j++;
        } ?>
                                    </table>
                                </div>                                
                                
                                
                                
                                
                                <div class="anyothersarea anyothersarea_rrwidget" id="anyothersarea_<?php echo ($i + 1); ?>" <?php if($question['AnyOther'] == 0) echo "style='display:none;'"; ?>>

                                    <input value="<?php echo $question['AnyOther']; ?>" <?php if($question['AnyOther'] == 1) echo "checked='true'"; ?>  type="checkbox" class="styled anyothercheck" id="anyothervalue_<?php echo ($i + 1); ?>"/> Other     
                                </div>
                               
                                <div class="othersarea othersarea_rrwidget padding8top" <?php if($question['Other'] == 0) echo "style='display:none;'" ?> id="othervaluediv_<?php echo ($i + 1); ?>">
                                    <input type="checkbox" class="styled" id="othervalue_<?php echo ($i + 1); ?>" name="1"  value="<?php echo $question['Other']; ?>"  <?php if($question['Other'] == 1) echo "checked='true'"; ?> > N/A
                                </div>

                            </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        <?php $this->endWidget(); ?>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                Custom.init();
            });
            
        <?php if (empty($surveyId) || $isAlreadySchedule == 0) { ?>
                $("#othersarea_<?php echo ($i + 1); ?> span").live('click', function() {
                    var isChecked = 0;
                    if ($('#othercheck_<?php echo ($i + 1); ?>').is(':checked')) {
                        isChecked = 1;
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").show();
                    } else {
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").hide();
                    }
                    $("#ExtendedSurveyForm_Other_<?php echo ($i + 1); ?>").val(isChecked);

                });
        <?php } ?>
            $("[rel=tooltip]").tooltip();        
            // alert('<?php //echo ($i+1); ?>')

        </script>
    <?php } else if ($question['QuestionType'] == 4) { ?>
        
        <div class="QuestionWidget child" data-questionId="<?php echo ($i + 1); ?>" style="position:relative; padding:15px 20px 15px 10px;" id="QuestionWidget_<?php echo ($i + 1); ?>">       
       <?php if($question['IsSuspended']==1){?> 
            <div class='suspendcontentdiv' data-qid='<?php echo ($i + 1); ?>'>
                <div class='btn'>Click here to Resume</div>
            </div>
            <div class='suspenddiv' id='suspenddiv_<?php echo ($i + 1); ?>'></div>
            <?php } ?>
            <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'questionWidget_' . ($i + 1),
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
            <input type="hidden" name="ExtendedSurveyForm[WidgetType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_WidgetType_<?php echo ($i + 1); ?>" value="1" />
            <input type="hidden" name="ExtendedSurveyForm[QuestionId][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_QuestionId_<?php echo ($i + 1); ?>" value="<?php echo $question['QuestionId']; ?>"/>
             <input type="hidden" name="ExtendedSurveyForm[IsSuspend][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsSuspend_<?php echo ($i + 1); ?>" value="<?php echo $question['IsSuspended']; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>" value="1"/>
             <div class="surveyquestionsbox">
                  <div class="surveyquestionsbox">
                  
                <div class="surveyareaheader">
                    <?php //if($isAlreadySchedule == 0){ ?>
                    <div class="subsectionremoveEdit" data-questionId="<?php echo ($i + 1); ?>">
                        <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Suspend question"/>
                    </div>
                    <?php //} ?>
                    <?php include 'EditQuestionsWidget.php'; ?>
                </div>

                <div class="surveyanswerarea" id="surveyanswerarea_<?php echo ($i + 1); ?>" >
                   
                    <input type="hidden" name="ExtendedSurveyForm[MatrixType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_MatrixType_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['MatrixType']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[NoofOptions][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['NoofOptions']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[NoofRatings][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_NoofRatings_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['NoofRatings']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[TextOptions][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_TextOptions_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['TextOptions']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[Other][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_NA_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['Other']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[AnyOther][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_AnyOther_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['AnyOther']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[StylingOption][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_StylingOption_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['StylingOption']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[AnswerSelected][<?php echo ($i + 1); ?>]"   id="ExtendedSurveyForm_answerSelected_<?php echo ($i + 1); ?>" value="<?php echo implode(",",$question['Answers']); ?>"/>
                    <div style="display: none;" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>_em_" class="alert alert-error " data-questionno="<?php echo ($i + 1); ?>" >
                        
                        </div>
                    <div class="paddingtblr1030">
                        <?php include 'EditWidgetOptions.php'; ?>  
                         <?php  include 'fileuploaderdivs.php'; ?>
                        <div class="tab_3">
                            <div class="dropdownsectionarea dropdownmedium answersection1" data-questionId="<?php echo ($i + 1); ?>">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span3">                                            
                                            <div class="pull-left positionrelative">
                                                <label class="rr_widget"><?php echo Yii::t("translation","RR_TypeofQuestion"); ?></label>
                                                <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> class="styled stypeofquestion" id="loadwidgetType_<?php echo ($i + 1); ?>" name="loadwidgetType_<?php echo ($i + 1); ?>" >
                                                    <option value="1" <?php if ($question['MatrixType'] == 1) echo "Selected" ?>>Ranking</option>
                                                    <option value="2" <?php if ($question['MatrixType'] == 2) echo "Selected" ?>>Rating</option>
                                                    <option value="3" <?php if ($question['MatrixType'] == 3) echo "Selected" ?>>Matrix</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="span3" id="stylingoptions_<?php echo ($i + 1); ?>">
                                        
                                        <div class="pull-left positionrelative">
                                            <label class="rr_widget"><?php echo Yii::t("translation","Ex_RRWidget_Styling_Title"); ?></label>
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?>  class="styled  stylingoptions" data-error="ExtendedSurveyForm_StylingType_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_StylingOption_hid_<?php echo ($i + 1); ?>"  name="ExtendedSurveyForm_StylingType_<?php echo ($i + 1); ?>">
                                                <option value="1" <?php if($question['StylingOption'] == 1) echo "selected='true'"; ?>><?php echo Yii::t("translation","Ex_RRWidget_Static_Col"); ?></option>
                                                <option value="2" <?php if($question['StylingOption'] == 2) echo "selected='true'"; ?>><?php echo Yii::t("translation","Ex_RRWidget_OptionSize"); ?></option>
                                            </select>
                                            <div class="control-group controlerror">
                                                <div style="display:none"  id="ExtendedSurveyForm_StylingType_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="span3" <?php if($question['MatrixType'] == 3){ ?> style="display: none"<?php }?> id="OptionType_<?php echo ($i + 1); ?>">
                                            <div class="pull-left positionrelative">
                                                <label ><?php echo Yii::t("translation","ExOptionType");?></label>
                                                <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> class="styled stextoptions"   data-idname="ExtendedSurveyForm_TextOptions_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_TextOptions_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_TextOptions_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_TextOptions_<?php echo ($i + 1); ?>">
                                                    <option value="1" <?php if ($question['TextOptions'] == 1) echo "Selected" ?>><?php echo Yii::t("translation","Radio_Options_only");?></option>

                                                    <option value="3" <?php if ($question['TextOptions'] == 3) echo "Selected" ?>><?php echo Yii::t("translation","Radio_with_Other_option");?></option>
                                                </select>
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="span3" id="TextMaxlengthdiv_<?php echo ($i + 1); ?>" <?php if($question['MatrixType'] != 3){ ?> style="display: none" <?php }?>>
                                        
                                        <div class="pull-left positionrelative">

                                            <label ><?php echo Yii::t("translation","Max_length");?></label>
                                            <input  class="textfield span12" placeholder="<?php echo Yii::t("translation","Max_length");?>"  type="text" maxlength="2" onkeydown="allowNumericsAndCheckFields(event)" onblur="allowNumericsAndCheckFields(event)" data-hiddenname="ExtendedSurveyForm_TextMaxlength_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_TextMaxlength_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm[TextMaxlength][<?php echo ($i + 1); ?>]" value="<?php echo $question['TextMaxlength']; ?>"></div>
                                        </div>
                                        <div class="span3" style="<?php if($question['MatrixType'] == 1){ echo 'margin:auto'; }else{ echo "display:none";}?>" id="noofoptionsdiv_<?php echo ($i + 1); ?>">
                                            <div class="pull-left positionrelative">
                                                <label class="rr_widget">No.of Options</label>
                                                <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?>  class="styled snofooptions" data-error="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>">
                                                    <option value="">Please select</option>
        <?php for ($k = 1; $k <= 10; $k++) { ?>
                                                        <option value="<?php echo $k; ?>" <?php if ($question['NoofOptions'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
        <?php } ?>
                                                </select>
                                                <div class="control-group controlerror">
                                                    <div style="display:none"  id="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        
                                        
                                    
                                        
                                        
                                        <div class="span3" id="noofrowsdiv_<?php echo ($i + 1); ?>" <?php if($question['MatrixType'] == 1){ ?> style="display:none" <?php }  ?>>
                                        
                                        <div class="pull-left positionrelative">
                                            <label class="rr_widget">No.of Rows</label>
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?>  class="styled snoofrows" data-error="ExtendedSurveyForm_NoofRows_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofRows_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofRows_<?php echo ($i + 1); ?>">
                                                <option value="">Please select</option>

                                                <?php for ($k = 1; $k <= 30; $k++) { ?>

                                                     <option value="<?php echo $k; ?>" <?php if ($question['NoofRatings'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
                                                     <?php } ?>
                                            </select>
                                            <div class="control-group controlerror">
                                                <div style="display:none"  id="ExtendedSurveyForm_NoofRows_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                        </div>
                                    </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        
                                        <div class="span3"  id="noofratingsdiv_<?php echo ($i + 1); ?>"  style="<?php if($question['MatrixType'] != 2) echo "display:none;"?>margin-top:10px">
                                            
                                            <div class="pull-left positionrelative">
                                                <label class="rr_widget">No.of Ratings</label>
                                                <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> class="styled  ssoofRatings" data-error="ExtendedSurveyForm_NoofRatings_<?php echo ($i + 1); ?>_em_" data-idname="ExtendedSurveyForm_NoofRatings_" data-hiddenname="ExtendedSurveyForm_NoofRatings_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofRatings_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofRatings_<?php echo ($i + 1); ?>">
                                                    <option value="">Please select</option>
        <?php for ($k = 1; $k <= 10; $k++) { ?>
                                                        <option value="<?php echo $k; ?>" <?php if ($question['NoofRatings'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
        <?php } ?>
                                                </select>
                                                <div class="control-group controlerror">
                                                    <div style="display:none"  id="ExtendedSurveyForm_NoofRatings_<?php echo ($i + 1); ?>_em_" class="errorMessage">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php //if($question['MatrixType'] == 3){ ?>
                                    
                                    
                                    <div class="span3" id="noofcolsdiv_<?php echo ($i + 1); ?>" style="<?php if($question['MatrixType'] != 3) echo "display:none;"?>margin:auto;margin-top: 10px;">
                                        <div class="pull-left positionrelative">
                                            <label class="rr_widget">No.of Columns</label>
                                            
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?>  class="styled snoofcols" data-error="ExtendedSurveyForm_NoofCols_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofRatings_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofCols_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofCols_<?php echo ($i + 1); ?>">
                                                <option value="">Please select</option>

                                                <?php for ($k = 1; $k <= 10; $k++) { ?>

                                                     <option value="<?php echo $k; ?>" <?php if ($question['NoofRatings'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
                                                     <?php } ?>
                                            </select>
                                            <div class="control-group controlerror">
                                                <div style="display:none"  id="ExtendedSurveyForm_NoofCols_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                        </div>
                                    </div> 
                                        
                                        
                                        


                            <div class="paddingtop12" >
                                <div id="rankingOrRating_<?php echo ($i + 1); ?>">
                                    <table cellpadding="0" cellspacing="0" class="customsurvaytable">
                                        <tr>
                                            <th class="col1"></th>
        <?php $j = 0;
        foreach ($question['LabelName'] as $rw) { ?>
                                            <input value="<?php echo $rw; ?>" type="hidden" name="ExtendedSurveyForm[LabelName][<?php echo ($j) . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_LabelName_hid_<?php echo ($j) . "_" . ($i + 1); ?>" class="label_hidden label_hidden_<?php echo ($i + 1); ?>"/>
                                            <th id="th_labelname_<?php echo ($j) . "_" . ($i + 1); ?>">
                                            <div class="surveydeleteaction positionrelative">             
                                                <input  value="<?php echo $rw; ?>" type="text" class="textfield textfieldtable notallowed labelnamewid_<?php echo ($i + 1); ?>" placeHolder="Label Name" name="LabelName_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_LabelName_hid_<?php echo ($j) . "_" . ($i + 1); ?>" id="ExtendedSurveyForm_LabelName_<?php echo ($j) . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
                                                <div class="control-group controlerror">
                                                    <div style="display:none"  id="ExtendedSurveyForm_LabelName_<?php echo ($j) . "_" . ($i + 1); ?>_em_" class="errorMessage" style="font-weight:normal"></div>
                                                </div>
                                            </div>
                                            <div class="surveydeleteaction pad_top10">             
                                                <input value="<?php echo $question['LabelDescription'][$j]; ?>" type="text" name="ExtendedSurveyForm[LabelDesc][<?php echo ($j) . "_" . ($i + 1); ?>]" class="textfield textfieldtable notallowed label_lDesc_<?php echo ($i + 1); ?>" placeHolder="Label Description" name="LabelName_<?php echo ($i + 1); ?>"  id="ExtendedSurveyForm_lDesc_<?php echo ($j) . "_" . ($i + 1); ?>"  maxlength="500">            
                                            </div>
                                            </th>  
                                                <?php $j++;
                                            } ?>
                                        </tr>

        <?php $j = 0;$mi = 0;
        foreach ($question['OptionName'] as $rw) { ?>   

                                            <input value="<?php echo $rw; ?>" type="hidden" name="ExtendedSurveyForm[OptionName][<?php echo $j . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_OptionName_hid_<?php echo $j . "_" . ($i + 1); ?>" class="option_hidden option_hidden_<?php echo ($i + 1); ?>"/>
                                            <tr>
                                                <td>
                                                    <div class="positionrelative surveydeleteaction ">
                                                    <div class="control-group controlerror">
                                                        <input value="<?php echo $rw; ?>" type="text" placeholder="Option Name" class="textfield textfieldtable option_text notallowed optionnamewid_<?php echo ($i + 1); ?>" name="OptionName_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_OptionName_hid_<?php echo $j . "_" . ($i + 1); ?>" id="ExtendedSurveyForm_Ranking_<?php echo $j . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
                                                        <div style="display:none"  id="ExtendedSurveyForm_OptionName_<?php echo $j . "_" . ($i + 1); ?>_em_" class="errorMessage ranking_errmsg"></div>
                                                    </div>
                                                        </div>
                                                </td>


            <?php if($question['TextOptions'] ==1 || $question['TextOptions'] == 3) {for ($k = 0; $k < sizeof($question['LabelName']); $k++) { ?>

                                                    <td><div class="answersection1" data-qtype="3" data-questionId="<?php echo ($i+1); ?>" id="answersection1_<?php echo ($i+1); ?>">
                                                            <div class="positionrelative displaytable onlinetestradio" data-info="<?php echo ($i + 1); ?>">
                                                            <input type="radio" class="styled ranking_radio radiotype_<?php echo ($i + 1); ?>" data-qid="<?php echo ($i + 1); ?>" value="<?php echo $k+1; ?>" id="radio_<?php echo $j . "_" . ($k + 1); ?>" <?php  if($question['Answers'][$j] == ($k+1)){?>checked="checked" <?php }?> name="radio_<?php echo $j . "_" . ($i + 1); ?>" />
                                                        </div>
                                                        </div>
                                                    </td>
                            <?php } ?>
                                                    <?php if($question['TextOptions'] == 3){ ?>
                                                    <td>
                                                        <div class="positionrelative surveydeleteaction ">
                                                            <input type="hidden" class="rr_justification_hidden rr_justification_hidden_<?php echo ($i + 1); ?>" maxlength="50" name="ExtendedSurveyForm[JustificationPlaceholders][<?php echo $j . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_JustificationPlaceholders_<?php echo $j . "_" . ($i + 1); ?>" value="<?php echo $question['JustificationPlaceholders'][$j]; ?>"/>
                                                            <input type="text" id="ExtendedSurveyForm_JustificationPlaceholderstext_<?php echo $j . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" data-hiddenname="ExtendedSurveyForm_JustificationPlaceholders_<?php echo $j . "_" . ($i + 1); ?>" class="textfield textfieldtable rr_justification notallowed rr_justification_<?php echo ($i + 1); ?>"  placeholder="Justification placeholder" value="<?php echo $question['JustificationPlaceholders'][$j]; ?>"/>
                                                        </div>
                                                   </td> 
                                                    <?php } ?>
            <?php }else if($question['TextOptions'] ==2){  for ($k = 0; $k < sizeof($question['LabelName']); $k++,$mi++) {       ?> 
                                   <td><input value="<?php echo $question['Answers'][$j][$k]; ?>" type="hidden" name="ExtendedSurveyForm[MatrixAnswer][<?php echo $j . "_" . $k . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_MatrixAnswer_hid_<?php echo $j . "_" . $k . "_" . ($i + 1); ?>" />
                                                        <div class="positionrelative surveydeleteaction ">
                                                            
                                                        <input type="text" class="textfield textfieldtable notallowed"  value="<?php echo $question['Answers'][$j][$k]; ?>"  maxlength ="2" onkeyup="checkvalid(this.value,this.id,<?php echo ($i+1); ?>),insertText(this.id)" onblur="checkvalid(this.value,this.id,<?php echo ($i+1); ?>),insertText(this.id)" id="ExtendedSurveyForm_MatrixAnswer_<?php echo $j . "_" . $k . "_" . ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_MatrixAnswer_hid_<?php echo $j . "_" . $k . "_" .($i + 1); ?>" onkeydown="allowNumericsAndCheckFields(event)" data-qid = "<?php echo ($i+1); ?>"/>
                                                        </div>
                                                   </td>                 
            <?php } } ?>

                                            </tr> 
            <?php $j++;
        } ?>     
                                    </table>
                                </div>
                                <div class="anyothersarea anyothersarea_rrwidget" id="anyothersarea_<?php echo ($i + 1); ?>" <?php if($question['AnyOther'] == 0) echo "style='display:none;'"; ?>>

                                    <input value="<?php echo $question['AnyOther']; ?>" <?php if($question['AnyOther'] == 1) echo "checked='true'"; ?>  type="checkbox" class="styled anyothercheck" id="anyothervalue_<?php echo ($i + 1); ?>"/> Other     
                                </div>
                               
                                <div class="othersarea othersarea_rrwidget padding8top" <?php if($question['Other'] == 0) echo "style='display:none;'" ?> id="othervaluediv_<?php echo ($i + 1); ?>">
                                    <input type="checkbox" class="styled" id="othervalue_<?php echo ($i + 1); ?>" name="1"  value="<?php echo $question['Other']; ?>"  <?php if($question['Other'] == 1) echo "checked='true'"; ?> > N/A
                                </div>

                            </div>
                        </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <?php $this->endWidget(); ?>
        </div>



        <script type="text/javascript">
            $(document).ready(function() {
                Custom.init();
            });
            $("[rel=tooltip]").tooltip();
            <?php if (empty($surveyId) || $isAlreadySchedule == 0) { ?>
                $("#othersarea_<?php echo ($i + 1); ?> span").live('click', function() {
                    var isChecked = 0;
                    if ($('#othercheck_<?php echo ($i + 1); ?>').is(':checked')) {
                        isChecked = 1;
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").show();
                    } else {
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").hide();
                    }
                    $("#ExtendedSurveyForm_Other_<?php echo ($i + 1); ?>").val(isChecked);

                });
        <?php } ?>
//        $("#anyothersarea_<?php //echo ($i + 1); ?> span.checkbox").live("click",function(){
//            if($("#AnyOther_<?php //echo ($i + 1); ?>").is(":checked")){
//                $("#ExtendedSurveyForm_AnyOther_hid_<?php //echo ($i + 1); ?>").val(1);
//            }else{
//                $("#ExtendedSurveyForm_AnyOther_hid_<?php //echo ($i + 1); ?>").val(0);
//            }            
//        });
            // alert('<?php //echo ($i+1);  ?>')

        </script>
    <?php } else if ($question['QuestionType'] == 5) { ?>
        
        <div class="QuestionWidget child" data-questionId="<?php echo ($i + 1); ?>" style="position:relative; padding:15px 20px 15px 10px;" id="QuestionWidget_<?php echo ($i + 1); ?>">       
       <?php if($question['IsSuspended']==1){?> 
            <div class='suspendcontentdiv' data-qid='<?php echo ($i + 1); ?>'>
                <div class='btn'>Click here to Resume</div>
            </div>
            <div class='suspenddiv' id='suspenddiv_<?php echo ($i + 1); ?>'></div>
        <?php } ?>
            <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'questionWidget_' . ($i + 1),
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
            <input type="hidden" name="ExtendedSurveyForm[WidgetType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_WidgetType_<?php echo ($i + 1); ?>" value="1" />
            <input type="hidden" name="ExtendedSurveyForm[QuestionId][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_QuestionId_<?php echo ($i + 1); ?>" value="<?php echo $question['QuestionId']; ?>"/>
            <input type="hidden" name="ExtendedSurveyForm[IsSuspend][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsSuspend_<?php echo ($i + 1); ?>" value="<?php echo $question['IsSuspended']; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>" value="1"/>
            <div class="surveyquestionsbox">
                <div class="surveyquestionsbox">
                  
                <div class="surveyareaheader">
                    <?php //if($isAlreadySchedule == 0){ ?>
                    <div class="subsectionremoveEdit" data-questionId="<?php echo ($i + 1); ?>">
                        <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Suspend question"/>
                    </div>
                    <?php //} ?>
                    <?php include 'EditQuestionsWidget.php'; ?>
                </div>

                <div class="surveyanswerarea" id="surveyanswerarea_<?php echo ($i + 1); ?>" >
                    <input type="hidden" name="ExtendedSurveyForm[NoofOptions][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['NoofOptions']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[MatrixType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_MatrixType_hid_<?php echo ($i + 1); ?>"  value="<?php echo $question['MatrixType']; ?>"/>
                    <input type="hidden" name="ExtendedSurveyForm[TotalValue][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_TotalValue_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['TotalValue']; ?>"/>
                    <div class="paddingtblr1030">
                        <?php include 'EditWidgetOptions.php'; ?>  
                        <?php  include 'fileuploaderdivs.php'; ?>
                        <div class="tab_5">
                            <div class="dropdownsectionarea dropdownsmall">
                                <div class="row-fluid">
                                    <div class="span3">
                                        <div class="pull-left labelalignment"><label>Total Value:</label></div>
                                        <div class="pull-left positionrelative">
                                            <input value="<?php echo $question['TotalValue']; ?>" type="text" class="span9 textfield" data-error="ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>_em_"  maxlength="4" size="8" data-hiddenname="ExtendedSurveyForm_TotalValue_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)">
                                            <div class="control-group controlerror">
                                                <div style="display:none"  id="ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span5">
                                        <div class="pull-left labelalignment"><label>No.of Options:</label></div>
                                        <div class="pull-left positionrelative">
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> style="width:170px" class="styled span6" data-error="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>">
                                                <option value="">Please select</option>
        <?php for ($k = 2; $k < 10; $k++) { ?>
                                                    <option value="<?php echo $k; ?>" <?php if ($question['NoofOptions'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
        <?php } ?>
                                            </select>
                                            <div class="control-group controlerror">
                                                <div style="display:none"  id="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="pull-left labelalignment"><label>Unit type:</label></div>     
                                        <div class="pull-left positionrelative">
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> style="width:120px" class="styled" id="unitypeddn_<?php echo ($i + 1); ?>" name="unittype_<?php echo ($i + 1); ?>">          
                                                <option value="1" <?php if ($question['MatrixType'] == 1) echo "Selected"; ?>>%</option>
                                                <option value="2" <?php if ($question['MatrixType'] == 2) echo "Selected"; ?>>$</option>               
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="answersection1" id="percentageWidget_<?php echo ($i + 1); ?>" data-questionId="<?php echo ($i + 1); ?>">
        <?php $j = 0;
        foreach ($question['OptionName'] as $rw) {
             ?>
                                    <input value="<?php echo $rw; ?>" type="hidden" name="ExtendedSurveyForm[OptionName][<?php echo $j . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_OptionName_hid_<?php echo $j . "_" . ($i + 1); ?>" class="percentagehidden"/>
                                    <div class="normaloutersection normalouter_<?php echo ($i + 1); ?>">
                                        <div class="normalsection normalsection4">
                                            <div class="row-fluid">
                                                <div class="span10">
                                                    <div class="span6">
                                                        <div class="control-group controlerror">
                                                            <input placeholder="Option Name" value="<?php echo $rw; ?>" type="text"  class="textfield span10 percentageOptionname notallowed" name="OptionName_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_OptionName_hid_<?php echo $j . "_" . ($i + 1); ?>" id="ExtendedSurveyForm_percentage_<?php echo $j . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="500">
                                                            <div style="display:none"  id="ExtendedSurveyForm_OptionName_<?php echo $j . "_" . ($i + 1); ?>_em_" class="errorMessage percentageOptionerr"></div>
                                                        </div>     
                                                    </div>
                                                    <div class="span2 positionrelative labelpercent">
                                                        <input value="<?php echo $question['Answers'][$j]  ?>" type="text" onblur="maxCheck(this,<?php echo ($i + 1); ?>)" onkeydown="allowNumericsAndCheckFields(event)" size="8" maxlength="4" class="textfield span10 distvalue_<?php echo ($i + 1);?>" name = "ExtendedSurveyForm[PercentageAnswer][<?php echo $j . "_" . ($i + 1); ?>]"/> <label class="percentlbl perUnitType_<?php echo ($i + 1); ?>" > <?php if ($question['MatrixType'] == 1) {
                echo "%";
            } else {
                echo "$";
            } ?></label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        <?php $j++;} ?>
                                    <input type="hidden" name="ExtendedSurveyForm[Other][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_Other_<?php echo ($i + 1); ?>" class="otherhidden" value="<?php echo $question['Other']; ?>"/>
                                <input type="hidden" name="ExtendedSurveyForm[OtherValue][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_OtherValue_<?php echo ($i + 1); ?>" class="otherhiddenvalue" value="<?php echo $question['OtherValue']; ?>"/>
                                
                                <div class="normaloutersection" id="percentotherdiv_<?php echo ($i + 1); ?>">
                                <div class="normalsection othersarea" id="othersarea_<?php echo ($i + 1); ?>">
                                    <div class="surveyradiobutton"> <input value="<?php echo $question['Other']; ?>" <?php if($question['Other'] == 1) echo "checked='true'"; ?>  type="checkbox" class="styled othercheck" name="1" id="othercheck_<?php echo ($i + 1); ?>" /> Other  </div>  
                                    <div class="row-fluid otherTextdiv" <?php if($question['Other'] != 1){ ?> style="display: none;" <?php } ?> id="otherTextdiv_<?php echo ($i + 1); ?>">
                                        <div class="span12">
                                            <div class="control-group controlerror"> 
                                                <input type="text" placeholder="Other Value" id="otherText_<?php echo ($i + 1); ?>" class="span12 textfield othertext notallowed"  data-hiddenname="ExtendedSurveyForm_OtherValue_<?php echo ($i + 1); ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)" value="<?php echo $question['OtherValue']; ?>"/>
                                                <div class="control-group controlerror">
                                                    <div style="display:none"  id="ExtendedSurveyForm_OtherValue_<?php echo ($i + 1); ?>_em_" class="errorMessage othererr"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>

                            </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>

        <?php $this->endWidget(); ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                Custom.init();
            });
            $("[rel=tooltip]").tooltip();
        <?php if (empty($surveyId) || $isAlreadySchedule == 0) { ?>
                $("#othersarea_<?php echo ($i + 1); ?> span").live('click', function() {
                    var isChecked = 0;
                    if ($('#othercheck_<?php echo ($i + 1); ?>').is(':checked')) {
                        isChecked = 1;
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").show();
                    } else {
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").hide();
                    }
                    $("#ExtendedSurveyForm_Other_<?php echo ($i + 1); ?>").val(isChecked);

                });
                $("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>").keydown(function(e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A
                                    (e.keyCode == 65 && e.ctrlKey === true) ||
                                    // Allow: home, end, left, right
                                            (e.keyCode >= 35 && e.keyCode <= 39)) {
                                // let it happen, don't do anything
                                return;
                            }
                            // Ensure that it is a number and stop the keypress
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });
                        
                        $("#ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>").change(function(){
    var $this = $(this);
    $("#ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>").val($this.val());
    var TotalValue = $("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>").val();
    var optionValue = $this.val();
    var URL = "/extendedSurvey/renderPercentageOptions";
    var renderV = 0;
    var renTemp = 0,
            preq = 0,
            i=0;
    
    $(".normalouter_<?php echo ($i + 1); ?>").each(function(key){
            renderV++;
        }); 
      if(TotalValue == "" || TotalValue == 0){
          $("#selectExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>").html("Please select");
          $("#ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>").val("");
          $("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>_em_").text("Total Value cannot be blank");
          $("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>_em_").show();
          $("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>_em_").fadeOut(7000);    
          
      }
    if(optionValue > renderV){
        optionValue = optionValue - renderV;
        if(optionValue != 0 && TotalValue != 0){        
            $("#ExtendedSurveyForm_TotalValue_hid_<?php echo ($i + 1); ?>").val(TotalValue);
            ajaxRequest(URL, "questionNo=<?php echo ($i + 1); ?>&optionsCount="+optionValue+"&unitType="+$("#unitypeddn_<?php echo ($i + 1); ?>").val() , function(data) {
                renderPerHandler(data, '<?php echo ($i + 1); ?>')
            }, "html");
        }
    }else if(optionValue < renderV){
            preq = 0;
            renTemp = renderV;
            i = 0;
            $(".percentagehidden").each(function(key){
                var $this = $(this);
                var qNo = $this.closest("div.answersection1").attr("data-questionId");
                if (preq == 0) {
                    i = 0;
                    preq = qNo;
                }
                if (preq == qNo) {
                    i++;
                } else {
                    preq = qNo;
                    i = 1;
                }                               
                if(renTemp != optionValue){                    
                    $("#ExtendedSurveyForm_OptionName_hid_" + (renTemp) + "_<?php echo ($i + 1); ?>").remove();                    
                    renTemp--;
                } 
            });
            preq = 0;            
            renTemp = renderV;
            i = 0;
            $(".percentageOptionname").each(function(){
                var $this = $(this);
                var qNo = $this.closest("div.answersection1").attr("data-questionId");
                if (preq == 0) {
                    i = 0;
                    preq = qNo;
                }
                if (preq == qNo) {
                    i++;
                } else {
                    preq = qNo;
                    i = 1;
                }
                
                if(renTemp != optionValue){  
                    $("#ExtendedSurveyForm_percentage_" + (renTemp) + "_<?php echo ($i + 1); ?>").closest("div.normaloutersection").remove();
                    renTemp--;
                }                    
                
            });
            preq = 0;
            nextq = 0;
            renTemp = renderV;
            i = 0;
            $(".percentageOptionerr").each(function(){
                var $this = $(this);
                var qNo = $this.closest("div.answersection1").attr("data-questionId");
                if (preq == 0) {
                    i = 0;
                    preq = qNo;
                }
                if (preq == qNo) {
                    i++;
                } else {
                    preq = qNo;
                    i = 1;
                }
                
                if(renTemp != optionValue){  
                    $("#ExtendedSurveyForm_OptionName_" + (renTemp) + "_<?php echo ($i + 1); ?>_em_").remove();
                    renTemp--;
                }               

            });
    }
});
$("#unitypeddn_<?php echo ($i + 1); ?>").change(function(){
    var $this = $(this);
    $("#ExtendedSurveyForm_MatrixType_hid_<?php echo ($i + 1); ?>").val($this.val()); 
    var TotalValue = $("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>").val();
    var optionValue = $("#ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>").val();
    var errmsgTV="",errmsgOp="";
    var erridop,erridtv;
    var URL = "/extendedSurvey/renderPercentageOptions";
    erridtv = $("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>").attr("data-error");
    if(TotalValue == ""){
        errmsgTV = "Total value cann't be blank";
    }else if(!$.isNumeric(TotalValue) || TotalValue == 0){
        errmsgTV = "Total value is in between 2 and 10";
    }
    if(errmsgTV != ""){
        $("#"+erridtv).show();
        $("#"+erridtv).text(errmsgTV);
        $("#"+erridtv).fadeOut(7000,function(){errmsgTV = "";});

    }
    erridop = $("#ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>").attr("data-error");
    
    if(optionValue == ""){
        errmsgOp = "No of Options cann't be blank";
    }else if(!$.isNumeric(optionValue) || optionValue == 0){
        errmsgOp = "Options value is in between 2 and 10";
    }
    if(errmsgOp != ""){
        $("#"+erridop).show();
        $("#"+erridop).text(errmsgOp);
        $("#"+erridop).fadeOut(7000,function(){errmsgOp = "";});

    }
    var renderV = 0;
    $(".normalouter_<?php echo ($i + 1); ?>").each(function(){
        renderV++;
    });
    if(optionValue > renderV){
        optionValue = optionValue - renderV;
        if(optionValue != 0 && TotalValue != 0){        
            $("#ExtendedSurveyForm_TotalValue_hid_<?php echo ($i + 1); ?>").val(TotalValue);
            ajaxRequest(URL, "questionNo=<?php echo($i + 1); ?>&optionsCount="+optionValue+"&unitType="+$this.val() , function(data) {
                renderPerHandler(data, '<?php echo ($i + 1); ?>')
            }, "html");
        }
    }else if(optionValue == renderV){
        $(".perUnitType_<?php echo ($i + 1); ?>").each(function(){
            var unitType = $("#unitypeddn_<?php echo ($i + 1); ?>").val();
            if(unitType == 1 ){
                $(this).html("%");
            }else if(unitType == 2){
                $(this).html("$");
            }    
            
        });
    }
    
     
});
    function renderPerHandler(html,questionno){    
        $(html).insertBefore("#percentotherdiv_"+questionno);

       var preq = 0;
       var nextq = 0;
       var i = 0;
        $(".percentagehidden").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            if (preq == 0) {
                i = 0;
                preq = qNo;
            }
            if (preq == qNo) {
                i++;
            } else {
                preq = qNo;
                i = 1;
            }
            $this.attr("id", "ExtendedSurveyForm_OptionName_hid_" + (i) + "_" + qNo);
            $this.attr("name", "ExtendedSurveyForm[OptionName][" + (i) + "_" + qNo+"]");
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".percentageOptionname").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            if (preq == 0) {
                i = 0;
                preq = qNo;
            }
            if (preq == qNo) {
                i++;
            } else {
                preq = qNo;
                i = 1;
            }
            $this.attr("id", "ExtendedSurveyForm_percentage_" + (i) + "_" + qNo);
            $this.attr("data-hiddenname", "ExtendedSurveyForm_OptionName_hid_" + (i) + "_" + qNo);
            
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".percentageOptionerr").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            if (preq == 0) {
                i = 0;
                preq = qNo;
            }
            if (preq == qNo) {
                i++;
            } else {
                preq = qNo;
                i = 1;
            }
            $this.attr("id", "ExtendedSurveyForm_OptionName_" + (i) + "_" + qNo+"_em_");            
        });
        
        
        
    }
$("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
                        
        <?php } ?>
            // alert('<?php //echo ($i+1);  ?>')

        </script>
    <?php } else if ($question['QuestionType'] == 6) { ?>
        
        <div class="QuestionWidget child" data-questionId="<?php echo ($i + 1); ?>" style="position:relative; padding:15px 20px 15px 10px;" id="QuestionWidget_<?php echo ($i + 1); ?>">       
        
          <?php if($question['IsSuspended']==1){?> 
            <div class='suspendcontentdiv' data-qid='<?php echo ($i + 1); ?>'>
                <div class='btn'>Click here to Resume</div>
            </div>
            <div class='suspenddiv' id='suspenddiv_<?php echo ($i + 1); ?>'></div>
        <?php } ?>   
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'questionWidget_' . ($i + 1),
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
            <input type="hidden" name="ExtendedSurveyForm[WidgetType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_WidgetType_<?php echo ($i + 1); ?>" value="1" />
            <input type="hidden" name="ExtendedSurveyForm[QuestionId][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_QuestionId_<?php echo ($i + 1); ?>" value="<?php echo $question['QuestionId']; ?>"/>
            <input type="hidden" name="ExtendedSurveyForm[IsSuspend][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsSuspend_<?php echo ($i + 1); ?>" value="<?php echo $question['IsSuspended']; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>" value="1"/>
            <div class="surveyquestionsbox">
               <div class="surveyquestionsbox">
                 
                <div class="surveyareaheader">
                    <?php //if($isAlreadySchedule == 0){ ?>
                    <div class="subsectionremoveEdit" data-questionId="<?php echo ($i + 1); ?>">
                        <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Suspend question"/>
                    </div>
                    <?php// } ?>
                    <?php include 'EditQuestionsWidget.php'; ?>
                </div>

                <div class="surveyanswerarea" id="surveyanswerarea_<?php echo ($i + 1); ?>" >
                    <input value="<?php echo $question['NoofChars']; ?>" type="hidden" name="ExtendedSurveyForm[NoofChars][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_NoofChars_hid_<?php echo ($i + 1); ?>"/>
                    <div class="paddingtblr1030">
                        <?php include 'EditWidgetOptions.php'; ?>  
                        <?php  include 'fileuploaderdivs.php'; ?>
                        <div class="tab_5">
                            <div class="dropdownsectionarea dropdownsmall">
                                <div class="pull-left labelalignment"><label>No.of Characters:</label></div>
                                <div class="pull-left positionrelative">
                                    <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> class="styled span6" id="noofchars_<?php echo ($i + 1); ?>" name="noofchars_<?php echo ($i + 1); ?>">
                                        <option value="">Please select</option>
                                        <option value="100" <?php if ($question['NoofChars'] == "100") echo "Selected"; ?>>100</option>
                                        <option value="500" <?php if ($question['NoofChars'] == "500") echo "Selected"; ?>>500</option>
                                        <option value="1000" <?php if ($question['NoofChars'] == "1000") echo "Selected"; ?>>1000</option>
                                    </select>
                                    <div class="control-group controlerror">
                                        <div style="display:none"  id="ExtendedSurveyForm_NoofChars_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="answersection1">
                                <div class="normaloutersection">
                                    <div class="normalsection normalsection5">

                                        <div class="row-fluid" id="rowfluidChars_<?php echo ($i + 1); ?>">
                                            <div class="span12"> 
                                                <div class="control-group controlerror">
                                                <input value="<?php echo $question['Answers'][0] ?>" type="text" class="textfield span12 notallowed" id="qAaTextField_<?php echo ($i + 1); ?>" <?php if ($question['NoofChars'] > "100") echo "style='display:none;'"; ?> name="ExtendedSurveyForm[QuestionAnswerTextSelected][<?php echo ($i + 1); ?>]" onblur="insertText(this.id)" data-hiddenname="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>"/>
                                                <textarea class="span12 notallowed" id="qAaTextarea_<?php echo ($i + 1); ?>"  <?php if ($question['NoofChars'] <= "100") echo "style='display:none;'"; ?> name="ExtendedSurveyForm[QuestionAnswerSelected][<?php echo ($i + 1); ?>]" onkeyup="insertText(this.id)" onblur="insertText(this.id)" data-hiddenname="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>"><?php echo $question['Answers'][0]; ?></textarea>     
                                            <div style="display:none"  id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

 </div>
        <?php $this->endWidget(); ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                Custom.init();
            });
            $("[rel=tooltip]").tooltip();
        <?php if (empty($surveyId) || $isAlreadySchedule == 0) { ?>
                $("#othersarea_<?php echo ($i + 1); ?> span").live('click', function() {
                    var isChecked = 0;
                    if ($('#othercheck_<?php echo ($i + 1); ?>').is(':checked')) {
                        isChecked = 1;
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").show();
                    } else {
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").hide();
                    }
                    $("#ExtendedSurveyForm_Other_<?php echo ($i + 1); ?>").val(isChecked);

                });
                $("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>").keydown(function(e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A
                                    (e.keyCode == 65 && e.ctrlKey === true) ||
                                    // Allow: home, end, left, right
                                            (e.keyCode >= 35 && e.keyCode <= 39)) {
                                // let it happen, don't do anything
                                return;
                            }
                            // Ensure that it is a number and stop the keypress
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });
                        $("#noofchars_<?php echo ($i + 1); ?>").change(function() {
        var $this = $(this);
        $("#qAaTextarea_<?php echo ($i + 1); ?>").val("");
        $("#qAaTextField_<?php echo ($i + 1); ?>").val("");
        if ($this.val() == 100){            
            $("#qAaTextarea_<?php echo ($i + 1); ?>").hide();
            $("#qAaTextField_<?php echo ($i + 1); ?>").show();
        }else if($this.val() > 100){            
            $("#qAaTextarea_<?php echo ($i + 1); ?>").show();
            $("#qAaTextField_<?php echo ($i + 1); ?>").hide();
        }
        if($this.val() >= 1){
            $("#rowfluidChars_<?php echo ($i + 1); ?>").show();
            $("#ExtendedSurveyForm_NoofChars_hid_<?php echo ($i + 1); ?>").val($this.val());
        }
        if($this.val() == ""){
            $("#surveyFormButtonId").hide();
        }else{
            $("#surveyFormButtonId").show();
        }
    });
                        
        <?php } ?>
            // alert('<?php //echo ($i+1);  ?>')

        </script>
    <?php } else if ($question['QuestionType'] == 7) { ?>
        
        <div class="QuestionWidget child" data-questionId="<?php echo ($i + 1); ?>" style="position:relative; padding:15px 20px 15px 10px;"  id="QuestionWidget_<?php echo ($i + 1); ?>">       
        <?php if($question['IsSuspended']==1){?> 
            <div class='suspendcontentdiv' data-qid='<?php echo ($i + 1); ?>'>
                <div class='btn'>Click here to Resume</div>
            </div>
            <div class='suspenddiv' id='suspenddiv_<?php echo ($i + 1); ?>'></div>
        <?php } ?>
            
            <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'questionWidget_' . ($i + 1),
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
            <input type="hidden" name="ExtendedSurveyForm[WidgetType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_WidgetType_<?php echo ($i + 1); ?>" value="1" />
            <input type="hidden" name="ExtendedSurveyForm[QuestionId][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_QuestionId_<?php echo ($i + 1); ?>" value="<?php echo $question['QuestionId']; ?>"/>
            <input type="hidden" name="ExtendedSurveyForm[IsSuspend][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsSuspend_<?php echo ($i + 1); ?>" value="<?php echo $question['IsSuspended']; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>" value="1"/>
            <div class="surveyquestionsbox">
               <div class="surveyquestionsbox">
                  
                <div class="surveyareaheader">
                    <?php //if($isAlreadySchedule == 0){ ?>
                    <div class="subsectionremoveEdit" data-questionId="<?php echo ($i + 1); ?>">
                        <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Suspend question"/>
                    </div>
                    <?php //} ?>
                    <?php include 'EditQuestionsWidget.php'; ?>
                </div>

                <div class="surveyanswerarea" id="surveyanswerarea_<?php echo ($i + 1); ?>" >
                    <input type="hidden" name="ExtendedSurveyForm[NoofOptions][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['NoofOptions']; ?>"/>
                    <div class="paddingtblr1030">
                        <?php include 'EditWidgetOptions.php'; ?>  
                        <?php  include 'fileuploaderdivs.php'; ?>
                        <div class="tab_6">        
                            <div class="dropdownsectionarea dropdownsmall">
                                <div class="row-fluid">
                                    <div class="span4">
                                        <div class="pull-left labelalignment"><label>No.of Options:</label></div>

                                        <div class="pull-left positionrelative">
                                            <select <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> style="width:180px;" class="styled span6" data-error="ExtendedSurveyForm_NoofOption_<?php echo ($i + 1); ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>" name="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>">
                                                <option value="">Please select</option>
        <?php for ($k = 2; $k < 10; $k++) { ?>
                                                    <option value="<?php echo $k; ?>" <?php if ($question['NoofOptions'] == $k) echo "Selected" ?>><?php echo $k; ?></option>
        <?php } ?>
                                            </select>
                                            <div class="control-group controlerror">
                                                <div style="display:none"  id="ExtendedSurveyForm_NoofOptions_<?php echo ($i + 1); ?>_em_" class="errorMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="answersection1" id="userGeneratedRankingwidget_<?php echo ($i + 1); ?>" data-questionId="<?php echo ($i + 1); ?>" data-optionType="usergeneratedRanking">
        <?php 
        for ($k = 0; $k < ($question['NoofOptions']); $k++) {
             ?>
                                    <div class="normaloutersection normalouter_<?php echo ($i + 1); ?>">
                                        <div class="normalsection normalsection6">
                                            <div class="row-fluid">
                                                <div class="span12">   
                                                    <div class="control-group controlerror">
                                                        <input type="text" placeholder="Option Name" class="textfield span5 userGeneratedOptions notallowed"  value = "<?php echo $question['Answers'][$k] ?>" name="ExtendedSurveyForm[UserAnswerSelected][<?php echo $k ?>]" data-hiddenname="ExtendedSurveyForm_OptionName_hid_<?php echo $k . "_" . ($i + 1); ?>" id="ExtendedSurveyForm_userGRanking_<?php echo $k . "_" . ($i + 1); ?>"  maxlength="500">
                                                        <div style="display:none"  id="ExtendedSurveyForm_OptionName_<?php echo $k . "_" . ($i + 1); ?>_em_" class="errorMessage usergeneratederrorMsg"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        <?php } ?>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
                </div>

        <?php $this->endWidget(); ?>
        </div>



        <script type="text/javascript">
            $(document).ready(function() {
                Custom.init();
            });
            $("[rel=tooltip]").tooltip();
        <?php if (empty($surveyId)|| $isAlreadySchedule == 0) { ?>
                $("#othersarea_<?php echo ($i + 1); ?> span").live('click', function() {
                    var isChecked = 0;
                    if ($('#othercheck_<?php echo ($i + 1); ?>').is(':checked')) {
                        isChecked = 1;
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").show();
                    } else {
                        $("#otherTextdiv_<?php echo ($i + 1); ?>").hide();
                    }
                    $("#ExtendedSurveyForm_Other_<?php echo ($i + 1); ?>").val(isChecked);

                });
                $("#ExtendedSurveyForm_TotalValue_<?php echo ($i + 1); ?>").keydown(function(e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A
                                    (e.keyCode == 65 && e.ctrlKey === true) ||
                                    // Allow: home, end, left, right
                                            (e.keyCode >= 35 && e.keyCode <= 39)) {
                                // let it happen, don't do anything
                                return;
                            }
                            // Ensure that it is a number and stop the keypress
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });
                
                        
        <?php } ?>
             
            
        </script>
    <?php
    } else if ($question['QuestionType'] == 8) { ?>
        
        <div class="QuestionWidget child" data-questionId="<?php echo ($i + 1); ?>" style="position:relative; padding:15px 20px 15px 10px;" id="QuestionWidget_<?php echo ($i + 1); ?>">
            <?php if($question['IsSuspended']==1){?> 
            <div class='suspendcontentdiv' data-qid='<?php echo ($i + 1); ?>'>
                <div class='btn'>Click here to Resume</div>
            </div>
            <div class='suspenddiv' id='suspenddiv_<?php echo ($i + 1); ?>'></div>
                <?php } ?>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'questionWidget_' . ($i + 1),
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
         
            <input type="hidden" name="ExtendedSurveyForm[WidgetType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_WidgetType_<?php echo ($i + 1); ?>" value="1" />
            <input type="hidden" name="ExtendedSurveyForm[QuestionId][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_QuestionId_<?php echo ($i + 1); ?>" value="<?php echo $question['QuestionId']; ?>"/>
            <input type="hidden" name="ExtendedSurveyForm[SelectionType][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_SelectionType_hid_<?php echo ($i + 1); ?>" value="<?php echo $question['SelectionType']; ?>"/>
            <input type="hidden" name="ExtendedSurveyForm[IsSuspend][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsSuspend_<?php echo ($i + 1); ?>" value="<?php echo $question['IsSuspended']; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo ($i + 1); ?>" value="1"/>
            <input type="hidden" name="ExtendedSurveyForm[AnswerSelected][<?php echo ($i + 1); ?>]"   id="ExtendedSurveyForm_answerSelected_<?php echo ($i + 1); ?>" value="<?php echo $question['Answers'][0]; ?>" />
            <input type="hidden" name="ExtendedSurveyForm[AnswerSelectedEdit][<?php echo ($i + 1); ?>]"   id="ExtendedSurveyForm_answerSelectedEdit_<?php echo ($i + 1); ?>" value="<?php echo $a = implode(',', $question['Answers']); ?>"/>
           
               
                    <div class="surveyquestionsbox">
                  
                <div class="surveyareaheader">
                    <?php //if($isAlreadySchedule != 1){ ?>
                    <div class="subsectionremoveEdit" data-questionId="<?php echo ($i + 1); ?>">
                        <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="bottom" rel="tooltip"  data-original-title="Suspend question"/>
                    </div>
                    <?php //} ?>
                    <?php include 'EditQuestionsWidget.php'; ?>
                </div>

                <div class="surveyanswerarea" id="surveyanswerarea_<?php echo ($i + 1); ?>" >
                   
                    <div class="paddingtblr1030">                        
                        
                        <?php include 'EditWidgetOptions.php'; ?>
                        <?php  include 'fileuploaderdivs.php'; ?>
                        <div class="tab_1" style="margin-top: 10px;">
                            
                            <div class="dropdownsectionarea dropdownmedium">
                                <div class="row-fluid">
                                    <div class="span12">
                                        
                                        <div class="span8">
                                            <div class="span3">
                                                <div class="labelalignment"><label class=""><?php echo Yii::t("translation","Ex_TypeofSelection"); ?></label></div>
                                            </div>
                                            <div class="span4" style="margin: auto">
                                                <div class="positionrelative">
                                                    <select id="booleantypes_<?php echo ($i + 1); ?>" <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> style="width:184px" class="styled selectionType" data-quesitonid="<?php echo ($i + 1); ?>" name="loadwidgetType_<?php echo ($i + 1); ?>">
                                                    <option value="1" <?php if ($question['SelectionType'] == 1) echo "Selected"; ?>>Single</option>
                                                    <option value="2" <?php if ($question['SelectionType'] == 2) echo "Selected"; ?>>Multiple</option>                
                                                </select>
                                            </div>
                                            </div>


                                        </div>
                                        <div class="span3 positionrelative " style="right:0; ">
                                                <select id="selectoptions_<?php echo ($i + 1); ?>" name="boolean_<?php echo ($i + 1); ?>" <?php if(!empty($surveyId) || $isAlreadySchedule != 0){ echo "disabled='true'"; } ?> class="styled selectoptions" style="width:150px;" data-optionType="boolean" data-questionid="<?php echo ($i + 1); ?>">
                                                <?php for($opt=1;$opt<=30;$opt++){ ?>
                                                <option value="<?php echo $opt; ?>" <?php if($opt == sizeof($question['Options'])) echo "selected"; ?>><?php echo $opt." option(s)"; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                             </div>
                            <div class="answersection1" id="answersection1_<?php echo ($i + 1); ?>" data-questionId="<?php echo ($i + 1); ?>" data-optionType="radio" data-qtype="8"> 
                                <div id="section_<?php echo ($i + 1); ?>"  class="boolean_section"> 
                                <input type="hidden" name="ExtendedSurveyForm[BooleanValues][<?php echo ($i + 1); ?>]" id="ExtendedSurveyForm_Boolean_hid_<?php echo ($i + 1); ?>" class="booleanhidden" value="<?php echo implode(",",$question['Justification']); ?>"/>
                                <?php $j = 0;   $mt = 0;                             
                                foreach ($question['Options'] as $rw) { ?>
                                    <input type="hidden" name="ExtendedSurveyForm[BooleanRadioOption][<?php echo ($j + 1) . "_" . ($i + 1); ?>]" id="ExtendedSurveyForm_RadioOption_hid_<?php echo ($j + 1) . "_" . ($i + 1); ?>" class="booleanoptionhidden" value="<?php echo $rw; ?>"/>
                                    <div class="normaloutersection">
                                        
                                        <div class="normalsection">
                                            <div class="surveyradiobutton"> 
                                                <?php if ($question['SelectionType'] == 1){ ?>
                                                <div class="onlinetestradio"><input type="radio" value="<?php echo ($j+1) ?>" class="styled "  name="radioinput" <?php if($question['Answers'][0]== $j+1){?> checked="checked" <?php } ?>></div>
                                           <?php } else{ ?>
                                                     <div class=""></div>
                                                     <div class="onlinetestcheckbox"><input type="checkbox" value="<?php echo ($j+1) ?>" class="styled " name="answercheck_<?php echo $i + 1; ?>" <?php foreach($question['Answers'] as $a){if($a == ($j+1)){?>checked="checked" <?php }}?>></div>
                                                <?php } ?>
                                            </div>
                                            
                                            <div class="surveyradiofollowup confirmation_<?php echo ($i + 1); ?>" id="confirmation_<?php echo ($i + 1); ?>" data-value="<?php echo $j+1; ?>" data-quesitonid="<?php echo ($i + 1); ?>"><input  type="checkbox"  name="confirmradio_<?php echo ($i + 1); ?>" class="styled" value="<?php echo $j+1; ?>" <?php if($question['Justification'][$mt] == $j+1){ $mt++;?> checked="true" <?php } ?>/></div>
                                            <div class="row-fluid">
                                                <div class="span12">

                                                    <input value="<?php echo $rw; ?>" placeholder="Option Name" type="text" class="textfield span10 radiotype notallowed booelanType_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_RadioOption_hid_<?php echo ($j + 1) . "_" . ($i + 1); ?>"  name="boolean_<?php echo ($i + 1); ?>" id="ExtendedSurveyForm_RadioOption_<?php echo ($j + 1) . "_" . ($i + 1); ?>" onkeyup="insertText(this.id)" />
                                                    <div class="control-group controlerror"> 
                                                        <div style="display:none" id="ExtendedSurveyForm_BooleanRadioOption_<?php echo ($j + 1) . "_" . ($i + 1); ?>_em_" class="errorMessage booleanradioEmessage"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php $j++;
                            } ?>
                                </div>    
                                <input type="hidden" name="ExtendedSurveyForm[JustificationApplied][<?php echo ($i + 1); ?>]" value="<?php echo $question['JustificationAppliedToAll']; ?>" id="ExtendedSurveyForm_JustificationApplied_<?php echo ($i + 1); ?>"/>
                                <div id="appliedtoAll_<?php echo ($i + 1); ?>" class="padding-bottom10 justapplied" data-questionid="<?php echo ($i + 1); ?>">
                                    <input <?php if($question['JustificationAppliedToAll'] == 1) echo "checked='true'"; ?> class="styled" type="checkbox" name="applytoall_<?php echo ($i + 1); ?>" data-questionid="<?php echo ($i + 1); ?>" /> <label> <?php echo Yii::t("translation","Ex_BJustification_Apply"); ?></label>
                                </div>
                                  <div class="normaloutersection">
                                    <div class="normalsection normalsection5">

                                        <div class="row-fluid"  id="rowfluidChars_<?php echo ($i + 1); ?>"   <?php if($question['JustificationAppliedToAll'] == 0 && in_array(0,$question['Justification'])){ ?> style="display: none"<?php } ?>>
                                            <div class="span12">                               
                                                
                                                <textarea name="ExtendedSurveyForm[BooleanPlaceholderValues][<?php echo ($i + 1); ?>]" placeholder="Enter Placeholder's value" class="span12 booleantextarea notallowed" id="qAaTextarea_<?php echo ($i + 1); ?>" data-hiddenname="ExtendedSurveyForm_BooleanPlaceholderValues_hid_<?php echo ($i + 1); ?>" ><?php echo $question['OtherValue']; ?></textarea>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                
                                 
                           </div> 

                        </div>
                    </div>
                </div>
            </div>


        <?php $this->endWidget(); ?>
        </div>

        <script type="text/javascript">
            
            $(document).ready(function() {
                Custom.init();
                
            });
            $("[rel=tooltip]").tooltip();
            $(".confirmation_<?php echo ($i+1); ?>").unbind('click').bind("click",function(){ 
                var $this = $(this);        
                $("#ExtendedSurveyForm_Boolean_hid_<?php echo ($i+1); ?>").val($this.attr("data-value"));
                $("#rowfluidChars_<?php echo ($i+1); ?>").show();
            });
             $(".confirmation_<?php echo ($i + 1); ?>").unbind('click').bind("click",function(){ 
                var $this = $(this);                   
                $("#ExtendedSurveyForm_Boolean_hid_<?php echo ($i + 1); ?>").val($this.attr("data-value"));
                $("#rowfluidChars_<?php echo ($i + 1); ?>").show();
            });
            
            

       
    
    
            
            </script>
    <?php } $i++; ?>
        
        <script type="text/javascript">
            
        bindtoanyother('<?php echo ($i); ?>');    
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
    
     $(".onlinetestcheckbox").die().live("click",function(){ //alert('hai')
                            var $this1 = $(this);
                                   var checkboxvalues = "";
                                     var qId = $this1.closest('div.answersection1').attr("data-questionId");
                                      $("input[name='answercheck_" + qId + "']").each(function(key, value) {
                                          var $this = $(this);
                                          if($this.is(":checked")){ 
                                              if(checkboxvalues == ""){
                                                 checkboxvalues = key+1;
                                             }else{
                                                 checkboxvalues = checkboxvalues+","+(key+1);
                                                 }
                                                
                                         }
                          
         });
          //alert(checkboxvalues)
          if(checkboxvalues=='')
          $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val('');
          else
              $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val(1);
          
         $("#ExtendedSurveyForm_answerSelectedEdit_"+qId).val(checkboxvalues);
         //alert(checkboxvalues)
         
    });
     $(".onlinetestradio").die().live("click",function(){ 
       var $this = $(this);
       var radiovalue = "";
        var qId = $this.closest('div.answersection1').attr("data-questionId");
        var qtype = $this.closest('div.answersection1').attr("data-qtype");
        
        if(qtype == 3){
            var i = $this.attr("data-info");
            var noptions = $("#ExtendedSurveyForm_NoofOptions_"+qId).val();
            var norows =$("#ExtendedSurveyForm_NoofRows_"+qId).val();
            
            //radiovalue=$("input[name='radio_"+i+"_"+qId+"']:checked").val();
            var count=0;
            $(".radiotype_"+qId).each(function(){
                      var $this = $(this);
                           if($(this).is(":checked")){
                               if(radiovalue == ""){
                                   radiovalue = $this.val();
                               }else{
                                   radiovalue = radiovalue+","+$this.val();  
                               }
                               count++;  
                           }
                           
                        }); 
                        if($("#anyothersarea_"+qId+" span").attr("style") =="background-position: 0px -50px;"){
              noptions++;
              norows++;
              
          }
          if($("#anyothervaluediv_"+qId+" span").attr("style") =="background-position: 0px -50px;"){
              noptions++;
              norows++;
              
          }
           
            
           //alert(radiovalue) 
           if(noptions == count || norows == count)
        $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val(1);
        else 
        $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val('');  
                   
        }else{
            //radiovalue=$("input[name='radioinput']:checked").val();
            radiovalue=$this.find("input[name='radioinput']").val();
            $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val(1);
           if(qtype==8){
              $("#ExtendedSurveyForm_answerSelectedEdit_"+qId).val(radiovalue); 
           } 
        }
        //$("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val(1);
      $("#ExtendedSurveyForm_answerSelected_"+qId).val(radiovalue);
    });
    
       
        </script>
<?php }

 }else{echo 0;}
?>
        <script type="text/javascript">
         $(".subsectionremoveEdit").live('click', function() {
                var $this = $(this);
                 var qId = $this.attr("data-questionId");
    $("#QuestionWidget_"+qId).append("<div class='suspendcontentdiv' data-qid='"+qId+"'><div class='btn'>Click here to Resume</div></div><div class='suspenddiv' id='suspenddiv_"+qId+"'></div>");
                    // $(this).parents('div#QuestionWidget_'+qId).append("<div class='suspendcontentdiv' data-qid='"+qId+"'><div class='btn'>Click here to Resume</div></div><div class='suspenddiv' id='suspenddiv_"+qId+"'></div>")
                    $("#ExtendedSurveyForm_IsSuspend_"+qId).val(1);
                     });
                     
                     
        </script>
