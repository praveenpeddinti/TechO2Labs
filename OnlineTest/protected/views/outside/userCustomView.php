<?php 
if(is_object($surveyObj)){ ?>
<input type="hidden" value="<?php echo $userId; ?>" name="QuestionsSurveyForm[UserId]" id="QuestionsSurveyForm_UserId"/>
<input type="hidden" value="<?php echo $scheduleId; ?>" name="QuestionsSurveyForm[ScheduleId]" id="QuestionsSurveyForm_ScheduleId"/>
<input type="hidden" name="QuestionsSurveyForm[SurveyId]" value="<?php echo $categoryId; ?>" id="QuestionsSurveyForm_SurveyId">
<input type="hidden" name="QuestionsSurveyForm[Questions]" value="" id="QuestionsSurveyForm_Questions">
<input type="hidden" name="QuestionsSurveyForm[QuestionTempId]" value="" id="QuestionsSurveyForm_QuestionTempId" data-tempid="">
<input type="hidden" name="QuestionsSurveyForm[Time]" value="" id="QuestionsSurveyForm_Time" >


<div class="padding8top">
   
     
     <div class="padding152010" style="" id="surveyQuestionArea">
         <?php 
         $i = 1; 
         //$sno = $iValue;
         foreach($surveyObj->Questions as $question){
             $userAnswer = array();
             ?>
         <input type="hidden" name="QuestionsSurveyForm[IsCompleted]" value="<?php echo $question['IsCompleted']; ?>" id="QuestionsSurveyForm_IsCompleted" >
            <input type="hidden" name="QuestionsSurveyForm[IsMadatory][IsMadatory]" value="<?php echo $question['IsMadatory']; ?>" id="QuestionsSurveyForm_IsMadatory_<?php echo $i; ?>">
            <?php if($question['QuestionType'] == 1){ ?>             
                    <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionviewWidget_' . ($i),
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
           // $userAnswer =  $bufferAnswers[$sno-1]["SelectedOption"];
            
             $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
             if(isset($userAnswerObj["SelectedOption"])){
                  $userAnswer =  $userAnswerObj["SelectedOption"]; 
             }
            
            
            //error_log("========userAnsser=====".print_r($userAnswer,1));
            ?>   
         <input type="hidden" name="QuestionsSurveyForm[IsReviewed][<?php echo ($i); ?>]" value="<?php echo $question['IsReviewed']; ?>">
         <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="1" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["Other"]?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["OtherValue"]?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if(isset($userAnswer) && sizeof($userAnswer) > 0){ echo implode(",", $userAnswer);} ?>"/>
                    <div class="surveyquestionsbox" data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                       
                                <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo ($sno); ?>_em_" class="errorMessage"></div>
                            
                     <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                         <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo stripslashes(stripslashes($question['Question'])); ?></div>
                      <?php  include 'artifactdisplay.php'; ?>
                        <div class="answersection">
                      <?php $j = 1;foreach($question['Options'] as $rw){ ?>   
                         <div class="normalsection ">
                             <div data-questionid="<?php echo ($i); ?>" class="surveyradiobutton  radiooption_first" data-optionid="<?php echo ($j."_".$i); ?>"> <input value="<?php echo ($j); ?>" <?php if(isset($userAnswer) && in_array($j,$userAnswer)) echo "checked"; else echo ""?> type="radio" class="styled " name="radio_<?php echo $i;?>" id="optionradio_<?php echo $j."_".$i;?>"></div>
                         <div class="answerview"><?php echo $rw; ?></div>
                        </div>
                      <?php $j++; } ?>
                         <?php if($question['Other'] == 1){ ?>
                             <div class="normalsection">
                            <div data-questionid="<?php echo ($i); ?>" class="surveyradiobutton  otherradio_first" data-optionvalue="<?php echo ($j); ?>"> <input type="radio" class="styled" name="radio_<?php echo $i;?>" <?php if(isset($userAnswer) && in_array($j,$userAnswer)) echo "checked"; else echo ""?>></div>
                             <div class="row-fluid">
                            <div class="span12">
                                <input  type="text" class="textfield span4" placeHolder="<?php //echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)" value="<?php echo $userAnswerObj["OtherValue"]?>"/>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            </div>
                            </div>
                            </div>
                            </div>
                         <?php } ?>
                     </div>
                     </div>
                     </div>
                    </div>
             <?php $this->endWidget(); ?>  
         
                  
         <?php }else if($question['QuestionType'] == 2){ ?>
             <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionviewWidget_' . ($i),
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
           // $userAnswer =  $bufferAnswers[$sno-1]["SelectedOption"];
            
             $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
          
            if(isset($userAnswerObj["SelectedOption"])){
                  $userAnswer =  $userAnswerObj["SelectedOption"]; 
             }
           // echo "ss-".print_r($userAnswer,true);
            ?> 
         <input type="hidden" name="QuestionsSurveyForm[IsReviewed][<?php echo ($i); ?>]" value="<?php echo $question['IsReviewed']; ?>">
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="2" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["Other"]?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["OtherValue"]?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if(isset($userAnswer) && sizeof($userAnswer) > 0){ echo implode(",", $userAnswer);} ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[SelectAll][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_SelectAll_<?php echo ($i); ?>" value="<?php echo $userAnswerObj['SelectAll'];?>"/>
            <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                 
                                <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $sno; ?>_em_" class="errorMessage"></div>
                            
                <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo stripslashes(stripslashes($question['Question'])); ?></div>
                        <?php  include 'artifactdisplay.php'; ?>
                     <div class="answersection">
                          <?php if($question['DisplayType'] == 1){ //Checkbox ?>
                         
                         <div class="normalsection ">
                             <div data-selType="checkboxselectall" data-questionid="<?php echo ($i); ?>" class="surveyradiobutton checkboxselectalldiv" data-questionid="<?php echo $i; ?>"><input <?php if(isset($userAnswerObj['SelectAll']) && $userAnswerObj['SelectAll'] == 1){ echo "checked"; }?> class="styled checkboxselectall" type="checkbox" name="selectall_<?php echo ($i); ?>" id="selectall_<?php echo ($i); ?>" /></div>
                             <div class="answerview"><?php echo Yii::t("translation","Checkbox_SelectAll"); ?></div>
                         </div>
                         <?php } ?>
                         <?php if($question['DisplayType'] == 1){ ?>
                      <?php $j=1;
                      foreach($question['Options'] as $rw){ 
                        
                          ?>  
                         
                         <div class="normalsection ">

                        <div data-questionid="<?php echo ($i); ?>" class="surveyradiobutton surveycheckboxbutton checkboxoption_<?php echo ($i); ?>" data-optionid="<?php echo ($j."_".$i); ?>"> <input <?php if(isset($userAnswer) && in_array($j,$userAnswer)) echo "checked"; else echo ""?> type="checkbox" class="styled " data-type="checkbox" name="checkbox_<?php echo $i;?>" value="<?php echo $j;?>" id="optioncheckbox_<?php echo $j."_".$i;?>"></div>

                         <div class="answerview"><?php echo $rw; ?></div>
                        </div>
                         
                         <?php $j++;}}else{  //Multi-Select dropdown... ?>
                             <div class="row-fluid ">
                                 <div class="span4">
                                     <select  multiple="true" id="chmultiselect_<?php echo ($i); ?>" class="minheight100 checkboxmultiselect" data-questionid="<?php echo ($i); ?>">
                                 <option <?php if(isset($userAnswer) && in_array('0',$userAnswer)) echo "selected='true'"?> value="0"><?php echo Yii::t("translation","Checkbox_SelectAll"); ?></option>
                                 <?php $iopt = 1; foreach($question['Options'] as $rw){ ?>
                                 <option <?php if(isset($userAnswer) && in_array($iopt,$userAnswer)) echo "selected='true'"?> value="<?php echo $iopt; ?>" ><?php echo $rw; ?></option>
                                 <?php $iopt++; } ?>
                                 <?php if($question['Other'] == 1){                                      
                                     ?>
                                 <option <?php if(isset($userAnswer) && in_array("other",$userAnswer)) echo "selected='true'"?> value="other" ><?php echo $question['OtherValue'];?></option>
                                 <?php } ?>
                             </select>
                                 </div>
                         </div>
                        
                         <div class="row-fluid" style="<?php if(isset($userAnswer) && in_array("other",$userAnswer)) { echo "";}else{ echo "display:none";}?>" id="othertextfield_<?php echo ($i); ?>">
                            <div class="span12">
                                <input  type="text" value="<?php echo $userAnswerObj["OtherValue"]?>" class="textfield span4" placeHolder="<?php //echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            </div>
                            </div>
                            </div>
                        
                         <?php }?>
                         
                         
                         <?php if($question['Other'] == 1 && $question['DisplayType'] == 1){ ?>
                             <div class="normalsection">

                            <div data-questionid="<?php echo ($i); ?>" class="surveyradiobutton surveycheckboxbutton othercheckbox_<?php echo ($i); ?>" data-optionid="<?php echo ($j."_".$i); ?>"> <input <?php if($userAnswerObj["Other"] == 1) echo "checked"; else echo "";?> type="checkbox" value="other" class="styled checkboxradio_<?php echo $i; ?>" data-type="othercheckbox" name="checkbox_<?php echo $i;?>" id="otherCheckbox_<?php echo ($j."_".$i); ?>"></div>

                             <div class="row-fluid">
                            <div class="span12">
                                <input  type="text" value="<?php echo $userAnswerObj["OtherValue"]?>" class="textfield span4" placeHolder="<?php //echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            </div>
                            </div>
                            </div>
                            </div>
                         <?php } ?>
                     </div>
                     </div>
                     </div>
            </div>
          <?php $this->endWidget(); ?>
          <script type="text/javascript"> 
            

          </script>
              
         <?php } else if($question['QuestionType'] == 3){ ?>
<?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionviewWidget_' . ($i),
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
           // $userAnswer =  $bufferAnswers[$sno-1]["Options"];
            //echo "ss-".print_r($userAnswer,TRUE);
            
             $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
            if(isset($userAnswerObj["Options"])){
              $userAnswer =  $userAnswerObj["Options"];
 
            }
            ?> 
          <input type="hidden" name="QuestionsSurveyForm[IsReviewed][<?php echo ($i); ?>]" value="<?php echo $question['IsReviewed']; ?>">
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="3" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php if($question['MatrixType'] == 3)echo ($sno) ;else echo ($i) ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if(isset($userAnswer) && sizeof($userAnswer) > 0){ echo implode(",", $userAnswer);} ?>"/>
                       <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                          
                           
                           <div class="alert alert-error" style="display:none"  id="QuestionSurveyForm_OptionsSelected_fill_1" class="errorMessage"></div>
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo stripslashes(stripslashes($question['Question'])); ?></div>
                         <?php  include 'artifactdisplay.php'; ?> 
                           <div class="answersection">
                       <div class="paddingtop12">
                           <div class="MR_view_table"> 
                        <table cellpadding="0" cellspacing="0" class="customsurvaytable customsurvaytableview">
                        <tr>
                        <th ></th>
                        <?php $ln = 0; foreach($question['LabelName'] as $rw){?>
                            <th <?php if($question['StylingOption'] == 1){?> class="col2" <?php }?>>
                                <div><?php echo $rw; ?></div>
                                <?php if(isset($question['LabelDescription'][$ln]) && !empty($question['LabelDescription'][$ln])){ ?>
                                <div class="info_color"><?php echo $question['LabelDescription'][$ln]; ?></div>
                                <?php $ln++;} ?> 
                            </th>                            
                        <?php } ?>
                            <?php if($question['Other'] == 1) { ?>
                                <th <?php if($question['StylingOption'] == 1){?> class="col2" <?php }?>>N/A</th>
                            <?php } ?>
                        </tr>
                        
                            <?php $anyOther = 0;$noofoptions=0; $k = 1;$optionsSize = sizeof($question['OptionName']);foreach($question['OptionName'] as $rw){ ?>
                        
                        <tr>                            
                        <?php if(trim($rw) != trim("")){ ?>
                            
                            <?php if($optionsSize != $k || $question['AnyOther'] == 0){ ?>
                            <input class="questionOptionhidden_<?php echo ($k."_".$i); ?> questionOptionhidden_<?php echo ($i); ?>" type="hidden" name="QuestionsSurveyForm[OptionValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValue_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswer[$k-1]?>"/>
                            <?php }else{ ?>
                            <input class="questionOptionhidden_<?php echo ($k."_".$i); ?> questionOptionhidden_<?php echo ($i); ?>" type="hidden" name="QuestionsSurveyForm[OptionValueOther][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValueOther_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswer[$k-1]?>"/>
                            
                            <?php } ?>
                        <td><?php if($optionsSize == $k && $question['AnyOther'] == 1){  ?>
                            <input type="hidden" name="QuestionsSurveyForm[OptionTextValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionTextValue_<?php echo ($k."_".$i); ?>" class="OptionTextValueclass_<?php echo $i; ?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
                            <div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionOtherValue_<?php echo $k."_".$i;?>">
                                <input maxlength="200" placeholder="<?php //echo $rw; ?>" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionOtherValue_<?php echo $k; ?>" id="OptionOtherValue_<?php echo $i; ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i; ?>_em_" class="errorMessage"></div>
                            </div>
                                    </div>
                            
                        <?php }else{ echo $rw; } ?></td>
                           
                            <?php 
                                 $ik = 0;  
                                 $totalOptions = $question['NoofOptions']+$question['AnyOther'];
                                 if($question['TextOptions'] ==1 || $question['TextOptions'] == 3) {
                                 for($j=1;$j<=($totalOptions);$j++){ ?>
                                    
                                    <?php if($optionsSize != $k ||  $question['AnyOther'] == 0){ ?>
                                    <td><div data-questionid="<?php echo $i; ?>" class="positionrelative displaytable radioTable_<?php echo $j."_".$i; ?>" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                        <input type="radio" <?php if(isset($userAnswer) && $userAnswer[$k-1]==$j) echo "checked"; else echo ""?> class="styled radiotype_<?php echo $i; ?>" name="ranking_<?php echo $k; ?>" id="rankingRadio_<?php echo $k; ?>" value="<?php echo $j;?>" data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswer[$k-1][$i] ?>"/>
                                    </div></td>
                                    <?php }else{ ?>
                                    <td>
                                        <div data-questionid="<?php echo $i; ?>" class="positionrelative displaytable radioTable_<?php echo $j."_".$i; ?>" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValueOther_<?php echo $k."_".$i;?>">
                                        <input type="radio" <?php if(isset($userAnswer) && $userAnswer[$k-1]==$j) echo "checked"; else echo ""?> class="styled radiotype_<?php echo $i; ?>" name="ranking_<?php echo $k; ?>" id="rankingRadio_<?php echo $k; ?>" value="<?php echo $j;?>" data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValueOther_<?php echo $k."_".$i;?>"/>
                                    </div>
                                    </td>
                                    <?php } ?>
                                
                                <script type="text/javascript">
                                    var prev = 0;
                                    var value = "";                                 
                                    
                                    
                                        $("div.radioTable_<?php echo $j."_".$i; ?> span.radio").live("click",function(){
                                            <?php $ik++; ?>
                                        
                                        $("div.radioTable_<?php echo $j."_".$i; ?> span.radio").each(function(key){                                         
                                            $(this).attr("style","background-position:0 0");                                            
                                            $(this).siblings('.radiotype_<?php echo $i; ?>').attr('checked',false);
                                        });                                        
                                         $(this).attr("style","background-position:0 -50px");
                                         $(this).siblings('.radiotype_<?php echo $i; ?>').attr('checked',true);

                                    });
                                    
                                   
                                    
                                     
                                </script>
                                <?php }  ?>
                                 <?php }else if($question['TextOptions'] == 2){ 
                                     
                                     for($j=1;$j<=$question['NoofOptions'];$j++){ ?>
                                    <td><div  class="positionrelative surveydeleteaction radioTable_<?php echo $j."_".$i; ?>" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                            <input maxlength="<?php echo $question['TextMaxlength']; ?>"  type="text" class="textfield textfieldtable radiotype_<?php echo $k; ?> radiotypecol_<?php echo $j; ?> textoption_<?php echo $i; ?>" name="ranking_<?php echo $k; ?>" id="rankingRadio_<?php echo $k; ?>" data-row="<?php echo $k; ?>" data-col="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswer[$k-1][$i] ?>"/>
                                    </div></td>
                                 <?php }  }?>
                                <?php if($question['Other'] == 1) { ?>
                                <!--<input type="hidden" name="QuestionsSurveyForm[OptionValue][<?php //echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValue_<?php //echo ($k."_".$i); ?>"/>-->
                                <td><div data-questionid="<?php echo $i; ?>" class="positionrelative displaytable radioTable_<?php echo $j; ?>" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                        <input type="radio" <?php if(isset($userAnswer) && $userAnswer[$k-1]==$j) echo "checked"; else echo ""?> placeholder="" class="styled radiotype_<?php echo $i; ?>" name="ranking_<?php echo $k; ?>" id="otherradioranking_<?php echo $k; ?>" value="<?php echo $j;?>" data-name="<?php echo $j ?>"/>
                                </div></td>
                                
                            <?php } 
                                if($question['TextOptions'] == 3){ ?>
                                <input class="questionOptionCommnetValue_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionCommnetValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionCommnetValue_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswerObj["OptionCommnets"][$k-1]?>"/>
                                        <td><div data-questionid="<?php echo $i; ?>"  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>" >
                                                <input placeholder="<?php //echo $question['JustificationPlaceholders'][$k-1]; ?>" maxlength="200" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionCommnetValue_<?php echo ($k."_".$i); ?>" id="OptionCommnetValue_<?php echo ($k."_".$i); ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionCommnets"][$k-1]?>"/>
                                    </div></td>
                                <?php } ?>
                                </tr>
                                
                                
                        <?php $k++; }
                            
                                } ?>
                                
                        

                        </table>
                           </div>

                      </div>
                        </div>
                        </div>
                        </div>
                     </div>
          <?php $this->endWidget(); ?>
         <script type="text/javascript">
             var prev = 0;
                   
//                 var col, el;
//                $("input[type=radio]").live('click',function() {
//                   el = $(this);
//                   col = el.data("col");
//                   alert("col==="+col)
//                   $("input[data-col=" + col + "]").prop("checked", false);
//                   el.prop("checked", true);
//                });
         </script>
         <?php } else if($question['QuestionType'] == 4){ ?>
          <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionviewWidget_' . $i,
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
            // $userAnswer =  $bufferAnswers[$sno-1]["Options"];
             
             $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
          
              if(isset($userAnswerObj["Options"])){
              $userAnswer =  $userAnswerObj["Options"];
 
            }
              //echo "ss-".print_r($userAnswer,TRUE)."array[0]==".$userAnswer[0];
            ?> 
         <input type="hidden" name="QuestionsSurveyForm[IsReviewed][<?php echo ($i); ?>]" value="<?php echo $question['IsReviewed']; ?>">
           <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="4" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>"/>
        
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php if($question['MatrixType'] == 3)echo ($sno) ;else echo ($i) ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if($question['MatrixType'] == 3){ if(isset($userAnswer[0]) && sizeof($userAnswer[0]) > 0 && $userAnswer[0] != ""){ echo "1";} }else{if(isset($userAnswer[0]) && sizeof($userAnswer[0]) > 0 && $userAnswer[0] != "") echo implode(",",$userAnswer);} ?>"/>
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                     
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php if($question['MatrixType'] == 3)echo ($sno) ;else echo ($i) ?>_em_" class="errorMessage"></div>                        
                    <div class="alert alert-error" style="display:none"  id="QuestionSurveyForm_OptionsSelected_fill_1" class="errorMessage"></div>
                    <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo stripslashes(stripslashes($question['Question'])); ?></div>
                        <?php  include 'artifactdisplay.php'; ?>
                           <div class="answersection">
                       <div class="paddingtop12">
                           <div class="MR_view_table"> 
                        <table cellpadding="0" cellspacing="0" class="customsurvaytable customsurvaytableview">
                        <tr>
                        <th ></th>
                        <?php $labelsSize = $question['NoofRatings']; $lb =1; $rv = 1; foreach($question['LabelName'] as $rw){
                            ?>
                        
                            <th <?php if($question['StylingOption'] == 1){?> class="col2" <?php }?>>
                            <div><?php echo $rw; ?></div>
                            <?php if(isset($question['LabelDescription'][$lb-1]) && !empty($question['LabelDescription'][$lb-1])){ ?>
                                <div  class="info_color"> <?php echo $question['LabelDescription'][$lb-1]; ?></div>
                            <?php } ?>   
                                
                        </th>
                        <?php $lb++; } ?>
                            <?php if($question['Other'] == 1) { ?>
                                <th <?php if($question['StylingOption'] == 1){?> class="col2" <?php }?>>N/A</th>
                            <?php } ?>
                        </tr>
                        
                            <?php $k = 1;$anyOther = 0;$noofoptions=0;$optionsSize = sizeof($question['OptionName']);foreach($question['OptionName'] as $rw){ ?>
                    
                        <tr>
                            <?php if(trim($rw) != trim("")){ ?>
                            <?php if($question['TextOptions'] != 2){ ?>
                                
                                <?php if($optionsSize != $k || $question['AnyOther'] == 0){ ?>
                                    <input type="hidden" name="QuestionsSurveyForm[OptionValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValue_<?php echo ($k."_".$i); ?>" class="optionvalueclass_<?php echo $i; ?>" value="<?php echo $userAnswer[$k-1]?>"/>
                            <?php }else{ ?>
                                    <input class="optionvalueclass_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionValueOther][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValueOther_<?php echo ($k."_".$i); ?>"  value="<?php echo $userAnswer[$k-1]?>"/>
                            <?php } ?>
                             <?php }else{
                                 if($optionsSize == $k && $question['AnyOther'] == 1){ ?>
                                     <input class="optionvalueclass_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionValueOther][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValueOther_<?php echo ($k."_".$i); ?>"  value="<?php echo $userAnswer[$k-1]?>"/>
                                 <?php }
                             } ?>
                                
                            <td><?php if($optionsSize == $k && $question['AnyOther'] == 1){  ?>
                                <input type="hidden" name="QuestionsSurveyForm[OptionTextValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionTextValue_<?php echo ($k."_".$i); ?>" class="OptionTextValueclass_<?php echo $i; ?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
                            <div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionOtherValue_<?php echo $k."_".$i;?>">
                                <input maxlength="200" placeholder="<?php //echo $rw; ?>" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionOtherValue_<?php echo $k; ?>" id="OptionOtherValue_<?php echo $i; ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i; ?>_em_" class="errorMessage"></div>
                            </div>
                                    </div>
                            
                        <?php }else{ echo $rw;} ?></td>
                                <?php 
                                    if($question['TextOptions'] ==1 || $question['TextOptions'] == 3) {
                                        for($j=1;$j<= $question['NoofRatings'];$j++){ ?>
                            <?php if($optionsSize != $k ||  $question['AnyOther'] == 0){ ?>
                                        <td><div data-questionid="<?php echo $i; ?>" class="positionrelative displaytable radioRatingTable" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                        <input type="radio" <?php if(isset($userAnswer) && $userAnswer[$k-1]==$j) echo "checked"; else echo ""?> class="styled radiotype_rat_<?php echo $i; ?>" name="rating_<?php echo $k; ?>" id="ratingRadio_<?php echo $k; ?>" value="<?php echo $j;?>" />
                                        </div></td>
                            <?php } else{ ?>
                                <td><div data-questionid="<?php echo $i; ?>" class="positionrelative displaytable radioRatingTable" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValueOther_<?php echo $k."_".$i;?>">
                                        <input type="radio" <?php if(isset($userAnswer) && $userAnswer[$k-1]==$j) echo "checked"; else echo ""?> class="styled radiotype_rat_<?php echo $i; ?>" name="rating_<?php echo $k; ?>" id="ratingRadio_<?php echo $k; ?>" value="<?php echo $j;?>" />
                                        </div></td>
                            <?php }?>
                                        <?php }
                                        
                                    }else if($question['TextOptions'] == 2){ $ratingsSize = $question['NoofRatings']; 
                           
                                    ?>
                                    
                                   
                                         <?php  for($j=0;$j<$question['NoofRatings'];$j++){ ?>
                                    <?php if($optionsSize != $k  || $question['AnyOther'] == 0){ ?>
                                    <td>
                                       
                                        <div data-questionid="<?php echo $i; ?>" class="positionrelative surveydeleteaction " data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                            <input type="text" onkeyup="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"  onkeydown="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')" class="textfield textfieldtable questionType4_matrix_<?php echo $i; ?>"  name="QuestionsSurveyForm[TextOptionValues][<?php if($question['MatrixType'] == 3) echo ($rv."_".$j."_".$sno); else echo ($rv."_".$j."_".$i); ?>]" value="<?php echo $userAnswer[$rv-1][$j] ?>" onblur="updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"/>
                                    </div>
                                    
                                        </td>
                                    <?php }else if($optionsSize == $k && $question['AnyOther'] == 1){?>
                                        
                                        <td>
                                       
                                        <div data-questionid="<?php echo $i; ?>" class="positionrelative surveydeleteaction ">
                                        <input data-hidname="QuestionsSurveyForm_OptionValueOther_<?php echo $k."_".$i;?>" class="optionvalueclass_<?php echo ($k."_".$i); ?> textfield textfieldtable"  type="text" name="QuestionsSurveyForm[OptionMatrixValueOther][<?php echo ($rv."_".$j); ?>]"   id="QuestionsSurveyForm_OptionValueOther_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswer[$rv-1][$j] ?>" onblur="updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')" onkeyup="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"  onkeydown="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')" value="<?php echo $userAnswer[$rv-1][$j] ?>"/>
                                        </div>
                                        </td>
                                    <?php } ?>
                                 <?php } $rv++; }?>
                                
                               
                                
                                <?php if($question['Other'] == 1) { ?>
                                <td><div data-questionid="<?php echo $i; ?>" class="positionrelative displaytable radioRatingTable" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                 <input type="radio" class="styled radiotype_rat_<?php echo $i; ?>" name="rating_<?php echo $k; ?>" id="ratingRadio_<?php echo $k; ?>" value="<?php echo $j;?>"/>
                                </div></td>
                            <?php } if($question['TextOptions'] == 3){ ?>
                                             <input class="questionOptionCommnetValue_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionCommnetValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionCommnetValue_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswerObj["OptionCommnets"][$k-1]?>"/>
                                        <td><div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>">
                                                <input placeholder="<?php //echo $question['JustificationPlaceholders'][$k-1]; ?>" maxlength="200" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionCommnetValue_<?php echo ($k."_".$i); ?>" id="OptionCommnetValue_<?php echo ($k."_".$i); ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionCommnets"][$k-1]?>" />
                                    </div></td>
                                        <?php } ?>
                                </tr>
                            <?php $k++; $m++; } 
                            
                                } ?>
                                

                        </table>
                           </div>

                      </div>
                        </div>
                        </div>
                        </div>
                     </div>
         <?php $this->endWidget(); ?>
         
         <?php } else if($question['QuestionType'] == 5){ ?>
         <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionviewWidget_' . ($i),
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
            //  $userAnswer =  $bufferAnswers[$sno-1]["DistributionValues"];
             $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
             
             
              if(isset($userAnswerObj["DistributionValues"])){
               $userAnswer =  $userAnswerObj["DistributionValues"];
 
            }
             
             
             // echo "ss-".print_r($userAnswerObj,TRUE);
            ?> 
         <input type="hidden" name="QuestionsSurveyForm[IsReviewed][<?php echo ($i); ?>]" value="<?php echo $question['IsReviewed']; ?>">
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="5" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if(is_array($userAnswer)){echo array_sum($userAnswer);}?>"/>
         <input type="hidden" name="QuestionsSurveyForm[TotalCalValue][<?php echo ($sno); ?>]"   id="QuestionsSurveyForm_TotalCalValue_<?php echo ($i); ?>" value="<?php if(is_array($userAnswer)){echo array_sum($userAnswer);}?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["Other"]?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["OtherValue"]?>"/>
         
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                     
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_TotalCalValue_<?php echo $sno; ?>_em_" class="errorMessage"></div>    
                  <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $sno; ?>_em_" class="errorMessage"></div> 

                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo stripslashes(stripslashes($question['Question'])); ?></div>
                           <?php  include 'artifactdisplay.php'; ?>
                               <?php $k = 1; foreach($question['OptionName'] as $rw){ ?>
                           <input type="hidden" name="QuestionsSurveyForm[DistValue][<?php echo ($k."_".$i); ?>]" id="QuestionsSurveyForm_DistValue_hid_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswer[$k-1]?>"/>
                       <div class="answersection">
                     <div class="normalsection ">
                     <div class="row-fluid">
                     <div class="span12">
                     <div class="span6">
                     <div class="surveyradiobutton top3"><?php echo $k; ?>)</div>
                     <div class="answerview"><?php echo $rw; ?> </div>
                     </div>
                     <div class="span2 total" data-num="<?php echo $question['TotalValue']; ?>">
                     <div class="positionrelative pricetype">
                     <div class="percentdiv"><?php if( $question['MatrixType'] == 1) echo "%"; else echo "$";?> </div>
                     <input type="text" class="textfield span12 distvalue_<?php echo $i; ?>" id="QuestionsSurveyForm_DistValue_<?php echo $k."_".$i; ?>" data-hiddenname="QuestionsSurveyForm_DistValue_hid_<?php echo $k."_".$i; ?>" onkeyup="insertText(this.id);" onblur="insertText(this.id);updateValues(this,'<?php echo $i; ?>')" onkeydown="allowNumerics(event,this,'<?php echo $i; ?>')" value="<?php if(empty($userAnswer[$k-1])) echo ""; else echo $userAnswer[$k-1]?>">
                     </div>
                     </div>

                     </div>
                     </div>

                    </div>

                    </div>
                           <?php $k++;} ?>
                       <?php if($question['Other'] == 1){ ?>
                           <input type="hidden" name="QuestionsSurveyForm[DistValue][<?php echo ($k."_".$i); ?>]" id="QuestionsSurveyForm_DistValue_hid_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswer[$k-1]?>"/>
                           <div class="answersection">
                             <div class="normalsection">                            
                             <div class="row-fluid">
                            <div class="span6">
                                <div class="surveyradiobutton top3"><?php echo $k; ?>)</div>
                                <div class="answerview"><input  type="text" class="textfield span4" placeHolder="<?php //echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)" value='<?php echo $userAnswerObj["OtherValue"]?>'/></div>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            </div>
                            </div>
                                 <div class="span2 total" data-num="<?php echo $question['TotalValue']; ?>">
                                <div class="positionrelative pricetype">
                                <div class="percentdiv"><?php if( $question['MatrixType'] == 1) echo "%"; else echo "$";?> </div>
                                <input type="text" class="textfield span12 distvalue_<?php echo $i; ?>" id="QuestionsSurveyForm_DistValue_<?php echo $k."_".$i; ?>" data-hiddenname="QuestionsSurveyForm_DistValue_hid_<?php echo $k."_".$i; ?>" onkeyup="insertText(this.id);" onblur="insertText(this.id);updateValues(this,'<?php echo $i; ?>')" onkeydown="allowNumerics(event,this,'<?php echo $i; ?>')" value="<?php if(empty($userAnswer[$k-1])) echo ""; else echo $userAnswer[$k-1]?>">
                                </div>
                                </div>
                            </div>
                            </div>
                               </div>
                         <?php } ?>
                    </div>
                           
                    </div>
                    </div>
         
                
         <?php $this->endWidget(); ?>
                    <script type="text/javascript">
                    function updateValues(obj,qno){
                        var totalvalue = $.trim($("#"+obj.id).closest('div.total').attr("data-num"));
                        var calValue = 0;
                        $(".distvalue_"+qno).each(function(){
                           var $this = $(this);
                           calValue = calValue+Number($this.val());                           
                        });
                        $("#QuestionsSurveyForm_OptionsSelected_"+qno).val(calValue);
                        if(calValue == totalvalue ){
                            $("#QuestionsSurveyForm_TotalCalValue_"+qno).val(calValue);
                            
                        }else{
                             $("#QuestionsSurveyForm_TotalCalValue_"+qno).val("");
                        }
                    }
                    </script>
         <?php } else if($question['QuestionType'] == 6){ ?>
         <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionviewWidget_' . ($i),
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
          
            $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
            $userAnswer = "";
             if(isset($userAnswerObj["UserAnswer"])){
               $userAnswer =  $userAnswerObj["UserAnswer"];
 
            }
            ?> 
                    <input type="hidden" name="QuestionsSurveyForm[IsReviewed][<?php echo ($i); ?>]" value="<?php echo $question['IsReviewed']; ?>">
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="6" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[UserAnswer][<?php echo ($sno); ?>]"  id="QuestionsSurveyForm_UserAnswer_hid_<?php echo ($i); ?>" value="<?php echo $userAnswer;?>"/>
                     <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                         
                         <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_UserAnswer_<?php echo $sno; ?>_em_" class="errorMessage"></div>    
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo stripslashes(stripslashes($question['Question'])); ?></div>
                        <?php  include 'artifactdisplay.php'; ?>
                           <div class="answersection">
                         <div class="normalsection paddingleftzero ">
                        <div class="row-fluid">
                         <div class="span12">
                         
                         <?php if($question['NoofChars'] <= 100){ ?>
                            <div class="answerview" id="100chars">
                                <input type="text" class="textfield span12"  id="userquestionanswer100_<?php echo $i; ?>" data-hiddenname="QuestionsSurveyForm_UserAnswer_hid_<?php echo $i; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="<?php echo $question['NoofChars']; ?>" value="<?php echo $userAnswer;?>"> 
                            </div>
                         <?php } else{ ?> 
                            
                         <div class="answerview" id="morethan500chars">
                             <textarea class="textfield span12" name="" id="userquestionanswer500_<?php echo $i; ?>" data-hiddenname="QuestionsSurveyForm_UserAnswer_hid_<?php echo $i; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="<?php echo $question['NoofChars']; ?>" ><?php echo $userAnswer;?></textarea>                             
                         </div>
                        <?php } ?>
                         </div>
                          

                         </div>
                         </div>

                        </div>


                        </div>


                        </div>
                        </div>
                      
         <?php $this->endWidget(); ?>         
         <?php } else if($question['QuestionType'] == 7){ ?>
          <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionviewWidget_' . ($i),
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
            // $userAnswer =  $bufferAnswers[$sno-1]["UsergeneratedRankingOptions"];
             
             $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
            
             if(isset($userAnswerObj["UsergeneratedRankingOptions"])){
              $userAnswer =  $userAnswerObj["UsergeneratedRankingOptions"];
 
            }
           
            ?> <input type="hidden" name="QuestionsSurveyForm[IsReviewed][<?php echo ($i); ?>]" value="<?php echo $question['IsReviewed']; ?>">
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="7" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"  id="QuestionsSurveyForm_OptionsSelected_hid_<?php echo ($i); ?>" value="<?php if(is_array($userAnswer) && sizeof($userAnswer)>0){echo "dummy";}?>"/>
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $sno; ?>_em_" class="errorMessage"></div>    
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo stripslashes(stripslashes($question['Question'])); ?></div>
                        
                           <div class="answersection">
                            <?php for($j=1; $j<=$question['NoofOptions']; $j++){?>
                               <input type="hidden" name="QuestionsSurveyForm[UsergeneratedRanking][<?php echo ($j."_".$i); ?>]" id="QuestionsSurveyForm_UsergeneratedRanking_hid_<?php echo ($j."_".$i); ?>" value="<?php echo $userAnswer[$j-1]?>"/>
                                <div class="normalsection ">
                                <div class="row-fluid">
                                <div class="span12">
                                <div class="span4">
                                <div class="surveyradiobutton top3 top8"><?php echo $j; ?> )</div>
                                <div class="answerview"><input type="text" class="textfield span12" id="QuestionsSurveyForm_OptionValue_<?php echo $j."_".$i; ?>" data-hiddenname="QuestionsSurveyForm_UsergeneratedRanking_hid_<?php echo $j."_".$i; ?>" onkeyup="insertText(this.id);updateValue('QuestionsSurveyForm_OptionsSelected_hid_<?php echo ($i); ?>',this.id);" onblur="insertText(this.id)" value="<?php echo $userAnswer[$j-1]?>"> </div>
                                </div>


                                </div>
                                </div>

                               </div>   
                            <?php } ?>

                        </div>


                        </div>
                        </div>
                        </div>
         <?php $this->endWidget(); ?>    
         <script type="text/javascript">
         function updateValue(id,resId){             
             $("#"+id).val($("#"+resId).val());
         }
         </script>
       <?php } else if($question['QuestionType'] == 8){ ?>             
                    <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'questionviewWidget_' . ($i),
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
             //$userAnswer =  $bufferAnswers[$sno-1]["SelectedOption"];
             //$otherValue =  $bufferAnswers[$sno-1]["OtherValue"];
             $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
            
            
              
               if(isset($userAnswerObj["SelectedOption"])){
              $userAnswer =  $userAnswerObj["SelectedOption"]; 
 
            }
            $otherValue = "";
             if(isset($userAnswerObj["OtherValue"])){
               $otherValue =  $userAnswerObj["OtherValue"];
 
            }
             
             
           // echo print_r($userAnswer,true);
            // echo $otherValue;
            ?>   
                    <input type="hidden" name="QuestionsSurveyForm[IsReviewed][<?php echo ($i); ?>]" value="<?php echo $question['IsReviewed']; ?>">
                    <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="1" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
                    <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
                    <input type="hidden" name="QuestionsSurveyForm[OtherJustification][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>" value="<?php if(!empty($userAnswerObj["OtherValue"])){ echo "1";}?>" />
                    <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["OtherValue"];?>"/>
                    <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($sno); ?>" value="<?php if($question['SelectionType'] == 1){ echo $userAnswer[0];}else{ if(sizeof($userAnswer)>0) echo implode(",",$userAnswer);}?>"/>
                    <div class="surveyquestionsbox" data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                        
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $sno; ?>_em_" class="errorMessage"></div>
                            
                     <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo stripslashes(stripslashes($question['Question'])); ?></div>
                      <?php  include 'artifactdisplay.php'; ?>
                        <div class="answersection">
                      <?php $j = 1;foreach($question['Options'] as $ky=>$rw){ ?>   
                         <div class="normalsection ">
                             <div data-justificationapplied="<?php echo $question['JustificationAppliedToAll']; ?>" data-justvalue="<?php  if(isset($question['Justification'][0]) && sizeof($question['Justification']) > 0){ echo implode(",",$question['Justification']); }  ?>" class="surveyradiobutton surveybooleanoptionsdiv confirmation_<?php echo ($i); ?>" data-sno="<?php echo ($sno); ?>" data-questionid="<?php echo ($i); ?>" data-stype="<?php echo $question['SelectionType']; ?>" data-optionid="<?php echo ($j."_".$i); ?>" data-value="<?php echo ($j); ?>"> 
                                 <?php if($question['SelectionType'] == 1){ ?>
                                 <input <?php if(is_array($userAnswer) && $j==$userAnswer[0]) {echo "checked";} else "";?> value="<?php echo ($j); ?>" type="radio" class="styled " name="radio_<?php echo $i;?>" id="optionradio_<?php echo $j."_".$i;?>">
                                 <?php }else{  ?>
                                 
                                 <input <?php if(is_array($userAnswer) && $j==$userAnswer[$ky]) {echo "checked";} else "";?> value="<?php echo ($j); ?>" type="checkbox" class="styled " name="checkbox_<?php echo ($i);?>" id="optioncheckbox_<?php echo $j."_".$i;?>">
                                 <?php } ?>
                                 
                                 
                             </div>
                         <div class="answerview"><?php echo $rw; ?></div>
                        </div>
                      <?php $j++; } ?>
                         <div class="normaloutersection">
                            <div class="normalsection normalsection5">

                                <div class="row-fluid booleanwidget_<?php echo ($i); ?>"  id="rowfluidChars_<?php echo ($i); ?>" style="<?php if($otherValue!="" || $question['JustificationAppliedToAll'] == 1) echo "display:block"; else echo "display:none"?>">
                                    <div class="span12">                               
                                        <textarea placeholder="<?php //echo $question['OtherValue']; ?>" class="span12" id="qAaTextarea_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"><?php echo $userAnswerObj["OtherValue"];?></textarea>  
                                        <div class="control-group controlerror">
                                            <div style="display:none"  id="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
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
         <script type="text/javascript">
              var ind =0;                  
                  
                  
          </script>
         <?php }
     $i++;
     $sno++;
                             } ?>
     
     
     
  

<script type="text/javascript">
Custom.init();
var qCount = '<?php echo sizeof($surveyObj->Questions); ?>';
sessionStorage.globalSurveyFlag =1; 
var autoSaveInterval ;
sessionStorage.sharedURL = "";
</script>
<script type="text/javascript">    
     $("input[type='text']").on('keypress', function(e) { return e.keyCode != 13; });
     $("div.checkboxselectalldiv span.checkbox").die().live('click',function(){
        var $this = $(this);
        var qId = $this.closest("div.checkboxselectalldiv").attr("data-questionid");
        //alert(qId)
        var isChecked = 0;
        var checkboxvalues = "";
        //alert($this.attr("style"))
        if($this.attr("style") == "background-position: 0px -50px;"){      
            $("#selectall_"+qId).attr("checked",true);
            $("input[name='checkbox_"+qId+"']").each(function(key, value) {
            var $this1 = $(this);  
            var id = "#"+$this1.attr("id");           
            $this1.prev('span.checkbox').attr("style","background-position: 0px -50px;");
            $this1.attr("checked",true);
            if(checkboxvalues == ""){
                checkboxvalues = $this1.val();
            }else{
                if(checkboxvalues.search($this1.val()) < 0){
                    checkboxvalues = checkboxvalues+","+$this1.val();
                }
            }  
//              
          });
          var arrayValue = checkboxvalues.split(',');            
          if($.inArray("other",arrayValue) >= 0){               
               $("#QuestionsSurveyForm_Other_"+qId).val(1); 
           }else{
               $("#QuestionsSurveyForm_Other_"+qId).val(0);
           }
          $("#QuestionsSurveyForm_SelectAll_"+qId).val(1);
        }else if($this.attr("style") == "background-position: 0px 0px;"){
            
           $("input[name='checkbox_"+qId+"']").each(function(key, value) {
              var $this1 = $(this);
              $this1.attr("checked",false);              
              $this1.prev('span.checkbox').attr("style","background-position: 0px 0px;");
              $this1.attr("checked",false);
          });
          checkboxvalues = "";
          $("#QuestionsSurveyForm_SelectAll_"+qId).val(0);
          $("#QuestionsSurveyForm_Other_"+qId).val(0);
        }
        //checkboxvalues = "0,"+checkboxvalues;
        
        $("#QuestionsSurveyForm_OptionsSelected_"+qId).val(checkboxvalues);        
    });
    
    $(".checkboxmultiselect").die().live("change",function(){
        var $this = $(this);
        var qId = $this.attr("data-questionid");
        var value = $this.val();
        var checkboxvalues = "";
        
        var multiselectLength = Number(($("#chmultiselect_"+qId+" option").length)-1);
        if(value == 0){
            $("#chmultiselect_"+qId+" option").attr("selected",true);                
        }else if(value == "other"){
            $("#othertextfield_"+qId).show();
            $("#QuestionsSurveyForm_Other_"+qId).val(1);   
        }else{
            var str = String(value);
            var arrayValue = str.split(',');            
            if(multiselectLength == arrayValue.length && $.inArray("0",arrayValue) != 0){
                $("#chmultiselect_"+qId+" option").attr("selected",true); 
                 $("#QuestionsSurveyForm_SelectAll_"+qId).val(1);
            }else{
                 $("#chmultiselect_"+qId+" option[value='0']").attr("selected",false); 
                 $("#QuestionsSurveyForm_SelectAll_"+qId).val(0);
            }             
           if($.inArray("other",arrayValue) < 0){
               $("#othertextfield_"+qId).hide();
               $("#QuestionsSurveyForm_Other_"+qId).val(0); 
           }else{
               $("#othertextfield_"+qId).show();
               $("#QuestionsSurveyForm_Other_"+qId).val(1); 
           }
        }  
        checkboxvalues = $this.val();
        var str = String($this.val());
            var arrayValue = str.split(','); 
            $("#QuestionsSurveyForm_SelectAll_"+qId).val(1);            
            if($.inArray("other",arrayValue) < 0){
               $("#othertextfield_"+qId).hide();
               $("#QuestionsSurveyForm_Other_"+qId).val(0); 
           }else{
               $("#othertextfield_"+qId).show();
               $("#QuestionsSurveyForm_Other_"+qId).val(1); 
           }
        $("#QuestionsSurveyForm_OptionsSelected_"+qId).val(checkboxvalues);
    });
     $('body, html').animate({scrollTop : 0}, 800,function(){});
    function allowNumerics(e,obj,qno){
       
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
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
        
    
    }
    
    
//        Custom.init();
        var Garray = new Array();
            var isValidate = 0;
            var isValidated = false; 
            var options = "";
            var gQcnt = 0;
            var notValidate = 0;
            var errorInterval = 0;
             $("#submitQuestion").die("click"); 
        $("#submitQuestion").live("click",function(){ 
          var conf = confirm('Are you sure you want exit the test?');
          if(conf){
             Garray = new Array();
             isValidate = 0;
             fromAutoSave = 0;
             fromNode = 1;
             fromPagiNation = 0;
             gQcnt = 0;
             notValidate = 0;
             finalDone = 1;
             if(autoSaveInterval != null && autoSaveInterval != "undefined"){          
                     clearInterval(autoSaveInterval);
                }
           submitSurvey();
       }
        });
         
          function submitSurvey(){
//              if ($("#"+questionActiveID).css('background-color') == 'green') {
//              $("#"+questionActiveID).css("background-color", "green");   
//             }else{
//                $("#"+questionActiveID).css("background-color", ""); 
//             }
               $("#"+questionActiveID).css("background-color", "");
             //alert("==submitsurvey===="+fromAutoSave)
              
                if(fromAutoSave == 0){
                     scrollPleaseWait('surveyviewspinner');
               
               $(".errorMessage").hide();
            $(".alert-error,.errorMessage").each(function(){
                    $(this).hide();
                    $(this).html("");
                 });
            }
            for(var i =1; i<=qCount;i++){
                var isMandatory = $("#QuestionsSurveyForm_IsMadatory_"+i).val();
                if(isMandatory != 1){
                    notValidate++;
                }
            }
            
             for(var i =1; i<=1;i++){  
                 gQcnt++;
                var widtype = $("#QuestionsSurveyForm_WidgetType_"+i).val();
                var isMandatory = $("#QuestionsSurveyForm_IsMadatory_"+i).val(); 
                //alert(i+"isMandatory=for="+isMandatory);
             //   alert("isValidated=="+isValidated+"=isValidate="+isValidate+"==qCount==="+qCount+"=i=="+i)
                if(isMandatory == 1){//alert("isMandatory=="+isMandatory);

                     ValidateQuestions(1, 1);
                }else{
//                    if(widtype == 3 || widtype == 4 ){                       
//                       options = $("#QuestionsSurveyForm_OptionsSelected_"+i).val();
//                       if(options != "" && options != 0){                           
//                            ValidateQuestions(i, qCount);
//                        }else{
//                            Garray[i - 1] = $("#questionviewWidget_"+i).serialize();
//                        }
//                        if(isValidate <= qCount){
//                            isValidate++;      
//                        }
//                    }
 //ValidateQuestions(i, qCount);
                       if($(".booleanwidget_"+i).is(":visible")){//alert("-booleanwidget--fff--"+fromAutoSave);
                           ValidateQuestions(1, 1);
                       }else if($.trim($("#QuestionsSurveyForm_OptionsSelected_"+i).val()) != "" && $("#QuestionsSurveyForm_OptionsSelected_"+i).val() ){
                           //alert("-booleanwidget OptionsSelected--fff--"+fromAutoSave);
                               ValidateQuestions(i, qCount);                               
                        } else{//alert("-else 1--fff--"+fromAutoSave);
                          
                            ValidateQuestions(i, qCount);  
                            if(fromAutoSave == 0){//alert("-else 2 --fff--"+fromAutoSave);
                                Garray[i - 1] = $("#questionviewWidget_"+i).serialize(); 
                            }else{
                                 Garray[0] = $("#questionviewWidget_"+i).serialize();
                            }
                           
                            if(isValidate <= qCount){//alert(isValidate+"--else 3-fff--"+fromAutoSave);
                                isValidate++;      
                            }                                                                                

                             if(isValidate == qCount || fromAutoSave == 1){ //alert(" else 4---fff--"+fromAutoSave);
                                isValidated = true;
                                saveAnswersForQuestions();
                            } 
                        }

                    }
               
                                    
             }
          }  
        function insertText(id) {
            var pId = $("#" + id).attr("data-hiddenname"); 
            
            $("#" + pId).val($("#" + id).val());
        }
        
        function ValidateQuestions(qNo,qCnt){ //alert(qNo+"-VQ--fff--"+qCnt);
             $("#"+questionActiveID).css("background-color", ""); 
          //console.log("=ValidateQuestions=========fromAutoSave=="+fromAutoSave);
     
            
            var serializeddata = $("#questionviewWidget_"+qNo).serialize();
//            alert(data.toSource())
           // Garray[qNo - 1] = data;   
           // alert($("#QuestionsSurveyForm_OptionsSelected_"+qNo).val()+"===ValidateQuestions=========="+serializeddata.toSource())
                $.ajax({
                    type: 'POST',
                    url: '/outside/validateQuestions?surveyTitle=' + $("#QuestionsSurveyForm_SurveyTitle").val() + '&SurveyDescription=' + $("#QuestionsSurveyForm_SurveyDescription").val() + '&questionsCount=' + qCnt+"&SurveyGroupName="+$("#QuestionsSurveyForm_SurveyRelatedGroupName").val()+"&SurveyLogo="+$("#QuestionsSurveyForm_SurveyLogo").val(),
                    data: serializeddata,
                    async: false,
                    success: function(data) {
                        var data = eval(data);                    

                         if (data.status == 'success') {
                              Garray[qNo - 1] = serializeddata; 
                            //  alert("===")
                             if(fromAutoSave == 0){
                                  
                             }else{
                                 
                                  Garray[0] = serializeddata;   
                             }

                                if(isValidate <= qCount){

                                   isValidate++;  

                               }
                            }else{
                                Garray[qNo - 1] = serializeddata; 
                            }                

                       ValidateQuestionsHandler(data,qNo)

                    },
                    error: function(err) { 
                    },
                    dataType: 'json'
                });
            }
        function ValidateQuestionsHandler(data,qNo){
            var data = eval(data);
            if (data.status == 'success' || $("#QuestionsSurveyForm_WidgetType_"+qNo).val() == 5 || $("#QuestionsSurveyForm_WidgetType_"+qNo).val() == 6) {
             //alert(data.status+"--ValidateQuestionsHandler id--"+$("#QuestionsSurveyForm_WidgetType_"+qNo).val());
            $("#QuestionsSurveyForm_IsCompleted").val(1);   
               if(data.status == 'success')
                $("#"+questionActiveID).css("background-color", "green");
               isValidated = true;
               saveAnswersForQuestions();
                 if(isValidate == qCount || fromAutoSave == 1){ 
                    isValidated = true;
                    
                    
                }
                

            } else {   
                $("#QuestionsSurveyForm_IsCompleted").val(0); 
                
               
                 scrollPleaseWaitClose('surveyviewspinner');
                 
                   if(fromAutoSave == 0){
                isValidate = 0; 
                isValidated = false;                    
                //callSetIntervalForSurvey(); //set interval for survey answers...
                var error = [];
                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {
                    var error = eval(data.error);
                }
                $.each(error, function(key, val) { 
                    //alert(data.status+"--ValidateQuestionsHandler id-else-"+key+"---"+val);                       
                        var strArr = key.split("_");  
                        if($("#QuestionsSurveyForm_WidgetType_"+qNo).val() == 3 || $("#QuestionsSurveyForm_WidgetType_"+qNo).val() == 4){
                            saveAnswersForQuestions()
                            
                        }
                        else if ($("#" + key + "_em_")) {                            
                            $("#" + key + "_em_").text(val);
                            $("#" + key + "_em_").show();
                          //  $("#" + key + "_em_").fadeOut(9000);
                            $("#" + key).parent().addClass('error');
                        }
                        


                });
                
                
            }
             //console.log("count fo garray---"+Garray.length+"---"+isValidate);
            }
        

        /* Navigate to the top-most error message*/        
                if((gQcnt+Number(notValidate)) == qCount && fromAutoSave == 0){
                     
                    var flago = 0;
                    $(".alert-error,.errorMessage").each(function(key,va){
                        var $this = $(this);
                        if($this.text() != "" && flago == 0){                        
                            var id = $this.closest("form").attr("id");   
                            $('body, html').animate({scrollTop : $("#"+id).offset().top}, 800,function(){$("#surveySavingRes").hide();});
                            flago = 1;
                        }
                     });
                 }
             }
                    function getCurrentTimeCategory(id){
            var time=0;
           
                   time= parseInt(window['hours_HMS' + id])*3600;
                    time=time+(parseInt(window['minutes_HMS' + id])*60);
                      time=time+parseInt(window['seconds_HMS' + id]);
                     return time;
        }
        
        function saveAnswersForQuestions(){
           //alert("*p*");
           //console.log("after save next page---");
           if($("#surveySavingRes").length>0 && fromAutoSave == 0){
                $("#surveySavingRes").show();  
                $("#surveySavingRes").attr("style","margin-top:10px");
            }
            //console.log("saveAnswersForQuestions---"+Garray+"---");
           // alert(Garray)
         //  alert(CategoryIdwithCategory.toSource())
       var position=CategoryIdwithCategory[categoryId].split("_");
  
              $("#QuestionsSurveyForm_Time").val(parseInt(getCurrentTimeCategory("hms_timer"+position[2])));
            $("#QuestionsSurveyForm_Questions").val(JSON.stringify(Garray));
            $("#QuestionsSurveyForm_QuestionTempId").val('<?php echo $UserTempId?>');
            var data = $("#questionviewwidget").serialize(); 
            //alert("---dd---"+fromPagiNation+"--1--"+fromAutoSave+"--2--"+sureyQuestionPage);
//            if(isValidated == true){
                //alert("kin");
                isValidate = 0;
                isValidated = false;
                $.ajax({
                    type: 'POST',
                    url: '/outside/validateSurveyAnswersQuestion?fromPagination='+fromPagiNation+'&fromAutoSave='+fromAutoSave+'&Page='+sureyQuestionPage+'&finalDone='+finalDone+'&QuestionTempId=<?php echo $UserTempId?>',
                    data: data,
                    success: function(data) {
                        finalDone =0;
                        
                      $("#surveySavingRes").hide();
                       Garray = new Array();
                           if(fromAutoSave == 0){
                               //alert("---succes-1--");
                        if(data != "error"){
                           //alert(lastPage);
                             if(fromPagiNation == 1 &&  lastPage == "false"){
                             //gotoNextPage();
                               }else{
                            scrollPleaseWaitClose('surveyviewspinner');
                             $("#surveysubmitbuttons").hide(); 
//                                $("#surveyQuestionArea").html(data); 
                                window.location.href = "/outside/thankyouPage?done=done";
                        }
                 //console.log("after save next page---"+categoryId+"---"+scheduleId);
                       // alert(categoryId+"(("+sureyQuestionPage)
                            var queryString = {"userQuestionTempId":userTempId,"categoryId":categoryId,"scheduleId":scheduleId,"page":sureyQuestionPage,"action":"next"};                        
                           //console.log("after save next page-1--"+queryString); 
                ajaxRequest("/outside/sureyQuestionPagination1", queryString, sureyQuestionPaginationHandler,"html");
                        }else{
                            scrollPleaseWaitClose('surveyviewspinner');
                            $("#userviewErrMessage").text("Please choose at least one survey");
                            $("#userviewErrMessage").show();
                            $("#userviewErrMessage").fadeOut(100000,function(){
                                $("#userviewErrMessage").hide();
                            });                        
    //                        $('body, html').animate({scrollTop : 0}, 800,function(){});
                        }
                       
                       
                        setTimeout(setIframeHeightInSurveySubmit,500);
                           }else{
                               scrollPleaseWaitClose('surveyviewspinner');
                           }
                    },
                    error: function(data) { // if error occured
                        //alert(data.toSource())
                    },
                    dataType: 'html'
                });
//            }else {
//                isValidate = 0;
//                $("#userviewErrMessage").text("Please choose at least one survey");
//                $("#userviewErrMessage").show();
//                $("#userviewErrMessage").fadeOut(100000,function(){
//                    $("#userviewErrMessage").hide();
//                });                        
//            }
        }
        function callSetIntervalForSurvey(){
            if(autoSaveInterval != null && autoSaveInterval != "undefined"){
                        //console.log("from errors through ----claer interval--");
                         clearInterval(autoSaveInterval);
                    }
            autoSaveInterval  = setInterval(function(){
               //console.log("from errors through ----autoSaveInterval--");
                fromAutoSave = 1;
                Garray = new Array();
                  //submitSurvey();
              },'<?php echo Yii::app()->params['SurveyAutoSaveTime']?>');
        }
        function setIframeHeightInSurveySubmit(){
            var innerheight=1074;
            try{               
                
                var surveysubmitiframe = parent.document.getElementById("surveryId_iframe"),
                surveysubmitiframeWindow;
                surveysubmitiframeWindow = surveysubmitiframe.contentWindow || surveysubmitiframe.contentDocument.parentWindow;
                if(surveysubmitiframeWindow.document.body.offsetHeight != undefined && surveysubmitiframeWindow.document.body.offsetHeight != 'null'){
                    innerheight = surveysubmitiframeWindow.document.body.offsetHeight;
                    if(surveysubmitiframeWindow.document.body.offsetHeight <= 100){
                        innerheight = 306;
                    }
                }
                innerheight = Number(innerheight)+150;
                parent.document.getElementById("surveryId_iframe").setAttribute("style","height:"+innerheight+"px");
                var parentHeight = Number(innerheight)+100;
                parent.parent.document.getElementById("myIframeContent").setAttribute("style","height:"+parentHeight+"px");
//                parent.document.getElementById("surveyQuestionli").style.display = 'none';
//                parent.document.getElementById("sResults").className = 'active';          
                parent.document.getElementById("surveyQuestionli").className = 'active'; 
            }catch(err){

            }
        }
         function allowNumericsAndCheckFields(e,obj,rno,qno,col){       
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
    }

    function updateTexthiddenFields(obj,rno,qno,col){
        var value = obj.value;        
        $("#QuestionsSurveyForm_OptionValue_"+rno+"_"+qno).val(value);    
        $(".radiotype_"+rno).each(function(){
           if($(this).val() != value) {
               $(this).val("");
           }
        });

        $(".radiotypecol_"+col).each(function(){
           if($(this).val() != value) {
               $(this).val("");
           }
        });
    }
function updateTextRadiohiddenFields(obj,rno,qno,col,maxValue){
        var value = obj.value;    
        
        if(Number(value) < 1 || Number(value) > maxValue){            
            obj.value = "";
        }else{

            if(value != ""){
                $("#QuestionsSurveyForm_OptionsSelected_"+qno).val(value);
                var hidId = $(obj).attr("data-hidname");                
                if(hidId != undefined && hidId != "" && hidId != "undefined")
                    $("#"+hidId).val(value);
            }else{
                var cnt=0;
                $(".questionType4_matrix_"+qno).each(function(){
                   var $this = $(this);
                   if($this.val() != ""){
                      cnt++; 
                  }
                });
                
                if(cnt == 0){
                    $("#QuestionsSurveyForm_OptionsSelected_"+qno).val("");
                }
            }
        }
        
    }
    function checkFieldValue(obj,maxValue){        
        if(Number(obj.value) < 1 || Number(obj.value) > maxValue){            
            obj.value = "";
        }
    }
   var lastPage = "false";
   var pageStr = "";  
   sureyQuestionPage = "<?php echo $page; ?>";
     var  sureyTotalPage = "<?php echo $totalpages; ?>";
  
   

       <?php if($page == 1){ ?>
          
       <?php } ?>
         if(currentPage == 0){             
              $("#surveysubmitbuttons,#nextQuestion").show();

             //$("#prevQuestion").hide(); 
         }else{
              $("#prevQuestion").show();
         }
         pageStr = "Page <b><?php echo $page; ?></b> of <b><?php echo $totalpages; ?></b>"

         
<?php if($totalpages > 1){?>
$("#pagenoforsurvey").html(pageStr).show();
<?php }else{ ?>
    $("#pagenoforsurvey").hide().html("");
    $("#nextQuestion").hide();
    $("#submitQuestion").show();
<?php } ?>
  

  
    </script>
    <script type="text/javascript">
                  $(".radiooption_first").die().live('click',function(){
                      
                      var oid = $(this).attr("data-optionid");
                      var value = $("#optionradio_"+oid).val();
                      var qid = $(this).attr("data-questionid");
                      $("#QuestionsSurveyForm_Other_"+qid+",#QuestionsSurveyForm_OtherValue_"+qid).val("");
                      $("#QuestionsSurveyForm_OptionsSelected_"+qid).val(value);
                  });
                  $(".otherradio_first").die().live('click',function(){
                      var value = $(this).attr("data-optionvalue");
                      var qid = $(this).attr("data-questionid");
                      $("#QuestionsSurveyForm_OptionsSelected_"+qid).val(value);
                      $("#QuestionsSurveyForm_Other_"+qid).val(1);
                  });
                  
                  $(".othercheckbox_scnd").die().live('click',function(){
                    var oid = $(this).attr("data-optionid");
                   //alert('ss');
                   var qid = $(this).attr("data-questionid");
                    if($("#otherCheckbox_"+oid).is(":checked")){
                        $("#QuestionsSurveyForm_Other_"+qid).val(1);
                    }else{
                     
                        $("#QuestionsSurveyForm_OtherValue_"+qid+",#othervalue_"+qid+",#QuestionsSurveyForm_Other_"+qid).val("");
                        
                    }                     
                  });
                  
                  
                  $(".surveycheckboxbutton").die().live('click',function(){
                      var qid = $(this).attr("data-questionid");
                      var checkboxvalues = "";
                      var selType = $(this).attr("data-selType");
                      var checkboxLength = $("input[name='checkbox_"+qid+"']").length;
                      var carray = [];
                      $("input[name='checkbox_"+qid+"']").each(function(key, value) {
                          var $this = $(this);                         
                            if($this.is(":checked")){                                
                                if(checkboxvalues == ""){
                                    checkboxvalues = $this.val();
                                }else{
                                    if(checkboxvalues.search($this.val()) < 0){
                                        checkboxvalues = checkboxvalues+","+$this.val();
                                    }
                                    
                                }                                
                            }else if(selType != "checkboxselectall"){
                                $("#selectall_"+qid).prev('span.checkbox').attr("style","background-position: 0px 0px;");
                                $("#selectall_"+qid).attr("checked",false);
                                $("#QuestionsSurveyForm_SelectAll_"+qid).val(0)
                            }
                            //alert(checkboxvalues.split(","))
                            if(checkboxvalues != "")
                                carray = checkboxvalues.split(",");
                            if(carray.length == checkboxLength){
                                $("#selectall_"+qid).prev('span.checkbox').attr("style","background-position: 0px -50px;");
                                $("#selectall_"+qid).attr("checked",true);
                                $("#QuestionsSurveyForm_SelectAll_"+qid).val(1)
                            }
                            if($.inArray("other",carray) >= 0){               
                                 $("#QuestionsSurveyForm_Other_"+qid).val(1); 
                             }else{
                                 $("#QuestionsSurveyForm_Other_"+qid).val(0);
                             }
                            
                        });
                       // if(checkboxvalues != 0 && checkboxvalues != ""){
                            $("#QuestionsSurveyForm_OptionsSelected_"+qid).val(checkboxvalues);
                       //}
                        
                  });
                  // boolean function....
                  $(".surveybooleanoptionsdiv").die().live("click",function(){
                      var checkedItems = "";
                      var $this = $(this);
                      var justf = $this.attr("data-justvalue");
                      var justarray = justf.split(",");
                      var qId = $this.attr("data-questionid");   
                      var sno = $this.attr("data-sno");
                      var valueExist = false;                      
                      var isJustificationAppliedToAll = $this.attr("data-justificationapplied");                    
                      var stype = $this.attr("data-stype");                     
                      if(stype == 2){
                            $("input[name='checkbox_" + qId + "']").each(function(key, value) {            
                              if($(this).is(":checked")){
                                  if(checkedItems == ""){
                                      checkedItems = $(this).val();
                                  }else {
                                      checkedItems = checkedItems+","+$(this).val();
                                  }
                                  if($.inArray($(this).val(), justarray ) >= 0){
                                      valueExist = true;
                                  }
                              }
                          });
                      }else{                    
                          $("input[name='radio_" + qId + "']").each(function(key, value) {            
                                if($(this).is(":checked")){
                                    if(checkedItems == ""){
                                        checkedItems = $(this).val();
                                    }else {
                                        checkedItems = checkedItems+","+$(this).val();
                                    }                                    
                                    if($.inArray($(this).val(), justarray ) >= 0){
                                        valueExist = true;
                                    }
                                }
                            });
                        } 
                        if(valueExist == true || isJustificationAppliedToAll == 1){
                              $("#rowfluidChars_"+qId).show();
                              if(valueExist == true)
                                $("#QuestionsSurveyForm_Other_"+qId).val(1);
                              else
                                  $("#QuestionsSurveyForm_Other_"+qId).val(0);
                        }else{
                            $("#rowfluidChars_"+qId).hide();
                            $("#QuestionsSurveyForm_Other_"+qId).val(0);
                        }
                       $("#QuestionsSurveyForm_OptionsSelected_"+sno).val(checkedItems);
                  });
                  
                // rating/ranking/matrix ...
                  
                  $(".displaytable").die().live('click',function(){                 
 
                        var oid = $(this).attr("data-optionid");
                        var hidId = $(this).attr("data-hidname"); 
                        //alert(hidId+"===="+$(this).attr("data-name"))
                        $("#"+hidId).val($(this).attr("data-name"));
                         var checkboxvalues = "";    
                         var qid = $(this).attr("data-questionid");
                        $(".radiotype_"+qid).each(function(){
                            var $this = $(this);
                           if($(this).is(":checked")){
                               if(checkboxvalues == ""){
                                   checkboxvalues = $this.val();
                               }else{
                                   checkboxvalues = checkboxvalues+","+$this.val();  
                               }
                           }
                           
                        });     
                       if(checkboxvalues != 0 && checkboxvalues != ""){
                           $("#QuestionsSurveyForm_OptionsSelected_"+qid).val(checkboxvalues);
                       } 


                    }); 
                    
            $(".radioRatingTable").die().live('click',function(){
                 var oid = $(this).attr("data-optionid");
                 
                 var hidId = $(this).attr("data-hidname");
                 
                  $("#"+hidId).val($(this).attr("data-name"));
                  var checkboxvalues = "";                        
                 var value = $("#rankingRadio_"+oid).val();
                
                 var qid = $(this).attr("data-questionid");
                  
                 $(".radiotype_rat_"+qid).each(function(){
                     var $this = $(this);
                     
                    if($(this).is(":checked")){
                        if(checkboxvalues == ""){
                            checkboxvalues = $this.val();
                        }else{
                            checkboxvalues = checkboxvalues+","+$this.val();  
                        }
                    }
                 });     
                 
                if(checkboxvalues != 0 && checkboxvalues != ""){
                    $("#QuestionsSurveyForm_OptionsSelected_"+qid).val(checkboxvalues);
                }
             });   
             $(".surveydeleteaction").die().live("blur",function(){
                     var checkboxvalues = ""; 
                     var qid = $(this).attr("data-questionid");
                        $(".textoption_"+qid).each(function(){
                            var $this = $(this);
                            if($this.val() != "" && $this.val() != 0){
                                if(checkboxvalues == ""){
                                   checkboxvalues = $this.val();
                               }else{
                                   checkboxvalues = checkboxvalues+","+$this.val();  
                               }
                            }
                        });
                        
                        if(checkboxvalues != 0 && checkboxvalues != ""){
                           $("#QuestionsSurveyForm_OptionsSelected_"+qid).val(checkboxvalues);
                       } 
                    });
                    
          </script>
     <script type="text/javascript"> 
         var fromNode=0; //this flag is used to stop doing logout in 2 cases 1.call from node 2.submit pressed
        var categoryId = '<?php echo $categoryId?>';

        var nocategories = '<?php echo $nocategories?>';
        openCategory=arr_diff(CategoryDivs,closedCategory);
var questionActiveID="qno_"+CategoryIdArray.indexOf(categoryId)+"_"+'<?php echo $page;?>';
$("#"+questionActiveID).css("background-color", "orange");     
 
        <?php if($catPosition == "first" && $page == 1 && $totalpages == 1 && $nocategories == "true"){ ?>
          
            $("#prevQuestion,#nextQuestion").hide();
            $('#submitQuestion').show();
            <?php }
            else if(($catPosition == "first") && $page == 1){  ?>

             $("#prevQuestion").hide(); 
             $("#nextQuestion").show();
             $('#submitQuestion').hide();
        <?php }else if(($catPosition == "last" && $page == $totalpages) || $nocategories == "true"){?>
            $("#nextQuestion").hide();            
            $('#submitQuestion,#prevQuestion').show();
        <?php }else{ //if($page==1){?>
            //if()
            $("#prevQuestion").show();
            $("#nextQuestion").show();
            $("#submitQuestion").hide();
        <?php } ?>



          userTempId = '<?php echo $UserTempId?>';
         
      var loginUserId = '<?php echo $this->tinyObject->UserId; ?>';
   
    var scheduleId = "<?php echo $scheduleId; ?>";
     sessionStorage.userId = loginUserId;
     sessionStorage.scheduleId = scheduleId;
        window.onbeforeunload = function (e) {
                 if(fromNode == 0){
                      logoutSurveyPage();
                   
                 }
           
      };

 function logoutSurveyPage(){
     fromNode = 1;
     var surveyId = $("#QuestionsSurveyForm_SurveyId").attr("value");
     var data = {"Page":sureyQuestionPage-1,"ScheduleId":sessionStorage.scheduleId,"SurveyId" :surveyId,"UserId": loginUserId};
     ajaxRequest("/outside/logoutSurveyPage",data,function(){});
 }
 function loginSurveyPage(){
     var surveyId = $("#QuestionsSurveyForm_SurveyId").attr("value");
     var data = {"Page":sureyQuestionPage-1,"ScheduleId":sessionStorage.scheduleId,"SurveyId" :surveyId,"UserId": loginUserId};
     ajaxRequest("/outside/loginSurveyPage",data,function(){});
 }

 function previousValidation(){
               $("#"+questionActiveID).css("background-color", "")
             //alert("==submitsurvey===="+fromAutoSave)
              
                if(fromAutoSave == 0){
                     scrollPleaseWait('surveyviewspinner');
               
               $(".errorMessage").hide();
            $(".alert-error,.errorMessage").each(function(){
                    $(this).hide();
                    $(this).html("");
                 });
            }
            //alert(qCount)
            for(var i =1; i<=qCount;i++){
                var isMandatory = $("#QuestionsSurveyForm_IsMadatory_"+i).val();
                if(isMandatory != 1){
                    notValidate++;
                }
            }
            
             for(var i =1; i<=1;i++){  
                 gQcnt++;
                var widtype = $("#QuestionsSurveyForm_WidgetType_"+i).val();
                var isMandatory = $("#QuestionsSurveyForm_IsMadatory_"+i).val(); 
             //   alert("isValidated=="+isValidated+"=isValidate="+isValidate+"==qCount==="+qCount+"=i=="+i)
                 PreviousValidateQuestions(i, qCount);  
               
                                    
             }
          }
          function PreviousValidateQuestions(qNo,qCnt){ 
             $("#"+questionActiveID).css("background-color", ""); 
          //console.log("=ValidateQuestions=========fromAutoSave=="+fromAutoSave);
     
            
            var serializeddata = $("#questionviewWidget_"+qNo).serialize();
            
//            alert(data.toSource())
           // Garray[qNo - 1] = data;   
           // alert($("#QuestionsSurveyForm_OptionsSelected_"+qNo).val()+"===ValidateQuestions=========="+serializeddata.toSource())
                $.ajax({
                    type: 'POST',
                    url: '/outside/validateQuestions?surveyTitle=' + $("#QuestionsSurveyForm_SurveyTitle").val() + '&SurveyDescription=' + $("#QuestionsSurveyForm_SurveyDescription").val() + '&questionsCount=' + qCnt+"&SurveyGroupName="+$("#QuestionsSurveyForm_SurveyRelatedGroupName").val()+"&SurveyLogo="+$("#QuestionsSurveyForm_SurveyLogo").val(),
                    data: serializeddata,
                    async: false,
                    success: function(data) {
                        var data = eval(data);                    

                         if (data.status == 'success') {
                              Garray[qNo - 1] = serializeddata; 
                            //  alert("===")
                             if(fromAutoSave == 0){
                                  
                             }else{
                                 
                                  Garray[0] = serializeddata;   
                             }

                                if(isValidate <= qCount){

                                   isValidate++;  

                               }
                            }                

                       previousValidateQuestionsHandler(data,qNo)

                    },
                    error: function(err) { 
                    },
                    dataType: 'json'
                });
            }
           
  function previousValidateQuestionsHandler(data,qNo){
            var data = eval(data);  
           $("#"+questionActiveID).css("background-color", "")
           if (data.status == 'success' || $("#QuestionsSurveyForm_WidgetType_"+qNo).val() == 5) {
               $("#QuestionsSurveyForm_IsCompleted").val(1);   
               if(data.status == 'success')
                $("#"+questionActiveID).css("background-color", "green")
            }
        }
 
     //  alert("**")
                
       stopandStartTimer(TotalTimerDivs[CategoryIdwithCategory[categoryId]]);  
    
        activeCategoryDiv(CategoryIdwithCategory[categoryId]);
      
   
          function buttonhideing(categoryId){

               openCategory=arr_diff(CategoryDivs,closedCategory);
       
               if(CategoryIdArray.indexOf(categoryId)==0 && sureyQuestionPage==1){
                    $("#prevQuestion").hide(); 
               }
              else if(CategoryIdArray.indexOf(categoryId)>0 && sureyQuestionPage==1 ){
              //    alert("asdfasdf")
              //   alert(closedCategory.indexOf(CategoryIdwithCategory[CategoryIdArray[CategoryIdArray.indexOf(categoryId)-1]])) 
                 if(closedCategory.indexOf(CategoryIdwithCategory[CategoryIdArray[CategoryIdArray.indexOf(categoryId)-1]])>=0){
               //      alert("**")
                    $("#prevQuestion").hide();   
                 }
        }
        
               if(CategoryIdArray.indexOf(categoryId)==CategoryIdArray.length-1 && sureyQuestionPage==sureyTotalPage){
                  
                    $("#nextQuestion").hide();
                   $("#submitQuestion").show();
               }
                if(sureyQuestionPage!=sureyTotalPage){
                  
                    $("#nextQuestion").show();
                   $("#submitQuestion").hide();
               }
              
               
             //  alert(CategoryIdArray.toSource()+CategoryIdArray[CategoryIdArray.indexOf(categoryId)]+CategoryIdArray.indexOf(categoryId))
               var ar2 = CategoryIdArray.slice(CategoryIdArray.indexOf(categoryId)+1,CategoryIdArray.length );
             //  alert(ar2.toSource())
                 var arr3 = new Array();
               for(var i=0; i<ar2.length;i++){
                   
                   arr3.push(CategoryIdwithCategory[ar2[i]])
               }
          
               var intersetarray= $.arrayIntersect(arr3, closedCategory);
              
              // alert(intersetarray.toSource())
               //  alert(intersetarray.toSource())
               if(intersetarray.length==arr3.length && sureyQuestionPage==sureyTotalPage){
                  $("#nextQuestion").hide();
                    $("#submitQuestion").show(); 
               }
      
        
//              alert(CategoryIdArray[CategoryIdArray.indexOf(categoryId)-1])
////               alert(openCategory)
////               alert(CategoryDivs)
////               alert(openCategory.length+"**"+CategoryDivs.length)
//               if(closedCategory.indexOf(categoryId) && sureyQuestionPage==1){
//          // alert(openCategory.indexOf(CategoryIdwithCategory[CategoryIdArray[CategoryIdArray.indexOf(categoryId)-1]]));
//           if(openCategory.indexOf(CategoryIdwithCategory[CategoryIdArray[CategoryIdArray.indexOf(categoryId)-1]])>=0){
//               $("#prevQuestion").show(); 
//           }else{
//               $("#prevQuestion").hide(); 
//           }
//       }
       }
$.arrayIntersect = function(a, b)
{
    return $.grep(a, function(i)
    {
        return $.inArray(i, b) > -1;
    });
};


 
        function submitPreSurvey(){
            $("#"+questionActiveID).css("background-color", "");

        
            
             for(var i =1; i<=1;i++){
            
                isValidated = true;
                savePresAnswersForQuestions();

                
               
                                    
             }
 }
 
  function savePresAnswersForQuestions(fromAutoSave,fromPagiNation){//alert(fromPagiNation+"----final---"+fromAutoSave)
    
           var serializeddata = $("#questionviewWidget_1").serialize();
             Garray[0] = serializeddata;   
   
            var position=CategoryIdwithCategory[categoryId].split("_");
  
              $("#QuestionsSurveyForm_Time").val(parseInt(getCurrentTimeCategory("hms_timer"+position[2])));
            $("#QuestionsSurveyForm_Questions").val(JSON.stringify(Garray));
            $("#QuestionsSurveyForm_QuestionTempId").val('<?php echo $UserTempId?>');
            var data = $("#questionviewwidget").serialize();   
            
    
            isValidated = true;
            //alert("isValidated=="+isValidated+"=isValidate="+isValidate+"==qCount==="+qCount+"===="+data.toSource())
            if(isValidated == true){
          
                //alert("kin");
                isValidate = 0;
                isValidated = false;
               
               
               
                $.ajax({
                    type: 'POST',
                    url: '/outside/validateSurveyAnswersQuestion?fromPagination='+fromPagiNation+'&fromAutoSave='+fromAutoSave+'&Page='+sureyQuestionPage+'&QuestionTempId=<?php echo $UserTempId?>',
                    data: data,
                    success: function(data) {
                      $("#surveySavingRes").hide();
                       
                           if(fromAutoSave == 0){
                        if(data != "error"){
                      {
                            scrollPleaseWaitClose('surveyviewspinner');
                             $("#surveysubmitbuttons").hide(); 
//                                $("#surveyQuestionArea").html(data); 
                                window.location.href = "/outside/thankyouPage?done=done";
                        }
                       

                         }else{
                            scrollPleaseWaitClose('surveyviewspinner');
                            $("#userviewErrMessage").text("Please choose at least one survey");
                            $("#userviewErrMessage").show();
                            $("#userviewErrMessage").fadeOut(100000,function(){
                                $("#userviewErrMessage").hide();
                            });                        
    //                        $('body, html').animate({scrollTop : 0}, 800,function(){});
                        }
                       
                  
                           }else{
                               scrollPleaseWaitClose('surveyviewspinner');
                           }
                    },
                    error: function(data) { // if error occured
                        //alert(data.toSource())
                    },
                    dataType: 'html'
                });
            }else {
                isValidate = 0;
                $("#userviewErrMessage").text("Please choose at least one survey");
                $("#userviewErrMessage").show();
                $("#userviewErrMessage").fadeOut(100000,function(){
                    $("#userviewErrMessage").hide();
                });                        
            }
        }
       buttonhideing(categoryId)
    </script>


  <?php       }else{echo $errMessage; }
?>

