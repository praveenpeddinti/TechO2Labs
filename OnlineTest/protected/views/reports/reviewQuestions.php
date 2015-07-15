<?php  $i = 1;

if(count($surveyObjArray)>0){ 
foreach ($surveyObjArray as $surveyObject) {
    $surveyObj = $surveyObject["question"];
    $userAnswerObj = $surveyObject["answer"];
    $categoryId = $surveyObject["categoryId"];
    $categoryName = $surveyObject["categoryName"];
    //echo $categoryName;
   // echo $surveyObj->Questions[0]['QuestionType']."---".$userAnswerObj["IsReviewed"];
    $testId = $surveyObject["testId"];
    $uniqueId= $surveyObject["uniqueId"];
    if($userAnswerObj["IsReviewed"]=="2"){$countQObj++;}

if(is_object($surveyObj)){ 
    
    ?>

<div class="padding8top">
   
     
     <div class="padding152010" style="" id="surveyQuestionArea">
         <?php 
         
         //$i = $iValue;
         foreach($surveyObj->Questions as $question){
             $userAnswer = array();
             ?>
            <input type="hidden" name="QuestionsSurveyForm[IsMadatory][<?php echo ($i); ?>]" value="<?php echo $question['IsMadatory']; ?>" id="QuestionsSurveyForm_IsMadatory_<?php echo $i; ?>">
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
           // $userAnswer =  $bufferAnswers[$i-1]["SelectedOption"];
            
            // $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
             if(isset($userAnswerObj["SelectedOption"])){
                  $userAnswer =  $userAnswerObj["SelectedOption"]; 
             }
            //  echo "ss---".print_r($question['Answers']);
              $correctAnswers = implode(",", $question['Answers']);
             // echo "oter---".$question['Other'];
              $otherValue = "";
              if($question['Other'] == 1){
                 $otherValue =  $question["OtherValue"];
               
              }
            
         //   error_log("========Answer=====".print_r($question->Answer,1));
            ?>   

       
                    <div class="surveyquestionsbox" data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                        
                                <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>_em_" class="errorMessage"></div>
                            
                     <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                        <div style="float:right"><?php echo $categoryName?></div>
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
                                <input  type="text" class="textfield span4" placeHolder="<?php echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)" value="<?php echo $userAnswerObj["OtherValue"]?>"/>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            </div>
                            </div>
                            </div>
                            </div>
                         <?php } ?>
                     </div>
                     </div>
                         <div style="color:grey">
                        Correct Answers : <?php echo $correctAnswers;?>
                        <?php if($otherValue!=""){
                           echo "<br/>Other Option : ". $otherValue;                            
                        } ?>
                       
                        
                    </div>  
                         
                         <div style="float:right"><span class="label label-warning record_size">Actual marks for this Question <b>(<?php echo $userAnswerObj['ActualScore'];?>)</b></span>
                               <!--<label>Total Marks:</label>--><input type="text" style="width: 20px" name="reviewQuestions" data-qid="<?php echo $question['QuestionId']; ?>" data-categoryId="<?php echo $categoryId ?>" data-testId="<?php echo $testId ?>" onkeypress="return isNumberKey(event)" onkeyup="return validAnswer(event,this.value,'<?php echo $userAnswerObj['ActualScore'];?>')" id="reviewQuestions_<?php echo $uniqueId ?>" onkeyup="return validAnswer(event,this.value,'<?php echo $userAnswerObj['ActualScore'];?>')" data-uniqueId="<?php echo $uniqueId ?>" value="<?php echo $userAnswerObj["Score"]?>" <?php if($userAnswerObj["IsReviewed"]=="2") echo "readonly"?>/>
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
           // $userAnswer =  $bufferAnswers[$i-1]["SelectedOption"];
            
            // $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
          
            if(isset($userAnswerObj["SelectedOption"])){
                  $userAnswer =  $userAnswerObj["SelectedOption"]; 
             }
            
            ?> 
      
            <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                
                                <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            
                <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                         <div style="float:right"><?php echo $categoryName?></div>
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
                                <input  type="text" value="<?php echo $userAnswerObj["OtherValue"]?>" class="textfield span4" placeHolder="<?php echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
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
                                <input  type="text" value="<?php echo $userAnswerObj["OtherValue"]?>" class="textfield span4" placeHolder="<?php echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
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
           // $userAnswer =  $bufferAnswers[$i-1]["Options"];
            //echo "ss-".print_r($userAnswer,TRUE);
            
            // $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
            if(isset($userAnswerObj["Options"])){
              $userAnswer =  $userAnswerObj["Options"];
 
            }
             $correctAnswers = implode(",", $question['Answers']);
             // echo "oter---".$question['Other'];
              $otherValue = "";
              if($question['Other'] == 1){
                 $otherValue =  $question["OtherValue"];
               
              }
            ?> 
      
                       <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                           <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php if($question['MatrixType'] == 3)echo ($i) ;else echo ($i)  ?>_em_" class="errorMessage"></div>
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                        <div style="float:right"><?php echo $categoryName?></div>
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
                            <input class="questionOptionhidden_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValue_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswer[$k-1]?>"/>
                            <?php }else{ ?>
                            <input class="questionOptionhidden_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionValueOther][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValueOther_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswer[$k-1]?>"/>
                            
                            <?php } ?>
                        <td><?php if($optionsSize == $k && $question['AnyOther'] == 1){  ?>
                            <input type="hidden" name="QuestionsSurveyForm[OptionTextValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionTextValue_<?php echo ($k."_".$i); ?>" class="OptionTextValueclass_<?php echo $i; ?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
                            <div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionOtherValue_<?php echo $k."_".$i;?>">
                                <input maxlength="200" placeholder="<?php echo $rw; ?>" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionOtherValue_<?php echo $k; ?>" id="OptionOtherValue_<?php echo $i; ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
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
                                                <input placeholder="<?php echo $question['JustificationPlaceholders'][$k-1]; ?>" maxlength="200" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionCommnetValue_<?php echo ($k."_".$i); ?>" id="OptionCommnetValue_<?php echo ($k."_".$i); ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionCommnets"][$k-1]?>"/>
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
                             <div style="color:grey">
                        Correct Answers : <?php echo $correctAnswers;?>
                        <?php if($otherValue!=""){
                           echo "<br/>Other Option : ". $otherValue;                            
                        } ?>
                       
                        
                    </div> 
                             <div style="float:right"><span class="label label-warning record_size">Actual marks for this Question <b>(<?php echo $userAnswerObj['ActualScore'];?>)</b></span>
                               <!--<b>Total Marks</b>--><input type="text" style="width: 20px" name="reviewQuestions" data-qid="<?php echo $question['QuestionId']; ?>" data-categoryId="<?php echo $categoryId ?>" data-testId="<?php echo $testId ?>" data-uniqueId="<?php echo $uniqueId ?>" onkeypress = "return isNumberKey(event)" id="reviewQuestions_<?php echo $uniqueId ?>" onkeyup="return validAnswer(event,this.value,'<?php echo $userAnswerObj['ActualScore'];?>')" value="<?php echo $userAnswerObj["Score"]?>" <?php if($userAnswerObj["IsReviewed"]=="2") echo "readonly"?>/>
                         </div>
                        </div>
                     </div>
          <?php $this->endWidget(); ?>
         
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
            // $userAnswer =  $bufferAnswers[$i-1]["Options"];
             
             //$userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
          
              if(isset($userAnswerObj["Options"])){
              $userAnswer =  $userAnswerObj["Options"];
 
            }
              //echo "ss---".print_r($question['Answers']);
              $correctAnswers = implode(",", $question['Answers']);
             // echo "oter---".$question['AnyOther'];
              $otherValue = "";
              if($question['AnyOther'] == 1){
                 $optionName =  $question["OptionName"];
                 $otherValue =  array_pop($optionName);
              }
              
            ?> 
          
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php if($question['MatrixType'] == 3)echo ($i) ;else echo ($i) ?>_em_" class="errorMessage"></div>                        
                    
                    <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                         <div style="float:right"><?php echo $categoryName?></div>
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
                                <input maxlength="200" placeholder="<?php echo $rw; ?>" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionOtherValue_<?php echo $k; ?>" id="OptionOtherValue_<?php echo $i; ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
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
                                            <input type="text" onkeyup="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"  onkeydown="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')" class="textfield textfieldtable questionType4_matrix_<?php echo $i; ?>"  name="QuestionsSurveyForm[TextOptionValues][<?php if($question['MatrixType'] == 3) echo ($rv."_".$j."_".$i); else echo ($rv."_".$j."_".$i); ?>]" value="<?php echo $userAnswer[$rv-1][$j] ?>" onblur="updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"/>
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
                                                <input placeholder="<?php echo $question['JustificationPlaceholders'][$k-1]; ?>" maxlength="200" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionCommnetValue_<?php echo ($k."_".$i); ?>" id="OptionCommnetValue_<?php echo ($k."_".$i); ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionCommnets"][$k-1]?>" />
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
                         <div style="color:grey">
                        Correct Answers : <?php echo $correctAnswers;?>
                        <?php if($otherValue!=""){
                           echo "<br/>Other Option : ". $otherValue;                            
                        } ?>
                       
                        
                    </div>
                          <div style="float:right"><span class="label label-warning record_size">Actual marks for this Question <b>(<?php echo $userAnswerObj['ActualScore'];?>)</b></span>
                               <!--<b>Total Marks</b>--><input type="text" style="width: 20px" name="reviewQuestions" data-qid="<?php echo $question['QuestionId']; ?>" data-categoryId="<?php echo $categoryId ?>" data-testId="<?php echo $testId ?>" data-uniqueId="<?php echo $uniqueId ?>" onkeypress = "return isNumberKey(event)" id="reviewQuestions_<?php echo $uniqueId ?>" onkeyup="return validAnswer(event,this.value,'<?php echo $userAnswerObj['ActualScore'];?>')" value="<?php echo $userAnswerObj["Score"]?>" <?php if($userAnswerObj["IsReviewed"]=="2") echo "readonly"?>/>
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
            //  $userAnswer =  $bufferAnswers[$i-1]["DistributionValues"];
            // $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
             
             
              if(isset($userAnswerObj["DistributionValues"])){
               $userAnswer =  $userAnswerObj["DistributionValues"];
 
            }
              
              //echo "ss---".print_r($question['Answers']);
              $correctAnswers = implode(",", $question['Answers']);
             // echo "oter---".$question['Other'];
              $otherValue = "";
              if($question['Other'] == 1){
                 $otherValue =  $question["OtherValue"];
                
              }
             
             // echo "ss-".print_r($userAnswerObj,TRUE);
            ?> 
      
         
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_TotalCalValue_<?php echo $i; ?>_em_" class="errorMessage"></div>    
                  <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $i; ?>_em_" class="errorMessage"></div> 

                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
 <div style="float:right"><?php echo $categoryName?></div>                          
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
                                <div class="answerview"><input  type="text" class="textfield span4" placeHolder="<?php echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)" value='<?php echo $userAnswerObj["OtherValue"]?>'/></div>
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
                          <div style="color:grey">
                        Correct Answers : <?php echo $correctAnswers;?>
                        <?php if($otherValue!=""){
                           echo "<br/>Other Option : ". $otherValue;                            
                        } ?>
                       
                        
                    </div>  
                              <div style="float:right"><span class="label label-warning record_size">Actual marks for this Question <b>(<?php echo $userAnswerObj['ActualScore'];?>)</b></span>
                               <!--<b>Total Marks</b>--><input type="text" style="width: 20px" name="reviewQuestions" data-qid="<?php echo $question['QuestionId']; ?>" data-categoryId="<?php echo $categoryId ?>" data-testId="<?php echo $testId ?>" data-uniqueId="<?php echo $uniqueId ?>" onkeypress = "return isNumberKey(event)" id="reviewQuestions_<?php echo $uniqueId ?>" onkeyup="return validAnswer(event,this.value,'<?php echo $userAnswerObj['ActualScore'];?>')" value="<?php echo $userAnswerObj["Score"]?>" <?php if($userAnswerObj["IsReviewed"]=="2") echo "readonly"?>/>
                         </div>
                    </div>
                    </div>
         
                
         <?php $this->endWidget(); ?>
                  
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
          
           // $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
            $userAnswer = "";
             if(isset($userAnswerObj["UserAnswer"])){
               $userAnswer =  $userAnswerObj["UserAnswer"];
 
            }
             // echo "ss---".print_r($question['Answers']);
              $correctAnswers = implode(",", $question['Answers']);
              //echo "oter---".$question['AnyOther'];
              $otherValue = "";
              if($question['AnyOther'] == 1){
                 $optionName =  $question["OptionName"];
                 $otherValue =  array_pop($optionName);
              }
            ?> 
        
                     <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                         <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_UserAnswer_<?php echo $i; ?>_em_" class="errorMessage"></div>    
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                         <div style="float:right"><?php echo $categoryName?></div>
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
                           <div style="color:grey">
                        Correct Answers : <?php echo $correctAnswers;?>
                        <?php if($otherValue!=""){
                           echo "<br/>Other Option : ". $otherValue;                            
                        } ?>
                       
                        
                    </div>  
                           <div style="float:right"><span class="label label-warning record_size">Actual marks for this Question <b>(<?php echo $userAnswerObj['ActualScore'];?>)</b></span>
                               <!--<b>Total Marks</b>--><input type="text" style="width: 20px" name="reviewQuestions" data-qid="<?php echo $question['QuestionId']; ?>" data-categoryId="<?php echo $categoryId ?>" data-testId="<?php echo $testId ?>" data-uniqueId="<?php echo $uniqueId ?>" onkeypress = "return isNumberKey(event)" id="reviewQuestions_<?php echo $uniqueId ?>" onkeyup="return validAnswer(event,this.value,'<?php echo $userAnswerObj['ActualScore'];?>')" value="<?php echo $userAnswerObj["Score"]?>" <?php if($userAnswerObj["IsReviewed"]=="2") echo "readonly"?>/>
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
            // $userAnswer =  $bufferAnswers[$i-1]["UsergeneratedRankingOptions"];
             
             //$userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
            
             if(isset($userAnswerObj["UsergeneratedRankingOptions"])){
              $userAnswer =  $userAnswerObj["UsergeneratedRankingOptions"];
 
            }
            // echo "ss---".print_r($question['Answers']);
              $correctAnswers = implode(",", $question['Answers']);
              //echo "oter---".$question['AnyOther'];
              $otherValue = "";
              if($question['AnyOther'] == 1){
                 $optionName =  $question["OptionName"];
                 $otherValue =  array_pop($optionName);
              }
           
            ?> 
       
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $i; ?>_em_" class="errorMessage"></div>    
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                         <div style="float:right"><?php echo $categoryName?></div>
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
                               <div style="color:grey">
                        Correct Answers : <?php echo $correctAnswers;?>
                        <?php if($otherValue!=""){
                           echo "<br/>Other Option : ". $otherValue;                            
                        } ?>
                       
                        
                    </div> 
                           <div style="float:right"><span class="label label-warning record_size">Actual marks for this Question <b>(<?php echo $userAnswerObj['ActualScore'];?>)</b></span>
                               <!--<span class="tooltiplink cursor" rel="tooltip"  data-original-title="Marks"><label>Total Marks</label></span>--><input type="text" style="width: 20px" name="reviewQuestions" data-qid="<?php echo $question['QuestionId']; ?>" data-categoryId="<?php echo $categoryId ?>" data-testId="<?php echo $testId ?>" data-uniqueId="<?php echo $uniqueId ?>" onkeypress = "return isNumberKey(event)" id="reviewQuestions_<?php echo $uniqueId ?>" onkeyup="return validAnswer(event,this.value,'<?php echo $userAnswerObj['ActualScore'];?>')" value="<?php echo $userAnswerObj["Score"]?>" <?php if($userAnswerObj["IsReviewed"]=="2") echo "readonly"?>/>
                         </div>
                        </div>
                        </div>
         <?php $this->endWidget(); ?>    
         
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
             //$userAnswer =  $bufferAnswers[$i-1]["SelectedOption"];
             //$otherValue =  $bufferAnswers[$i-1]["OtherValue"];
            // $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
            
            
              
               if(isset($userAnswerObj["SelectedOption"])){
              $userAnswer =  $userAnswerObj["SelectedOption"]; 
 
            }
            $otherValue = "";
             if(isset($userAnswerObj["OtherValue"])){
               $otherValue =  $userAnswerObj["OtherValue"];
 
            }
             
             // echo "ss---".print_r($question['Answers']);
              $correctAnswers = implode(",", $question['Answers']);
             
             
              
                 $otherValue =  $question["OtherValue"];
                
             
           // echo print_r($userAnswer,true);
            // echo $otherValue;
            ?>   

                   
                    <div class="surveyquestionsbox" data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                        
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            
                     <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                    <div style="float:right"><?php echo $categoryName?></div>
                        <div class="answersection">
                      <?php $j = 1;foreach($question['Options'] as $ky=>$rw){ ?>   
                         <div class="normalsection ">
                             <div data-justificationapplied="<?php echo $question['JustificationAppliedToAll']; ?>" data-justvalue="<?php  if(isset($question['Justification'][0]) && sizeof($question['Justification']) > 0){ echo implode(",",$question['Justification']); }  ?>" class="surveyradiobutton surveybooleanoptionsdiv confirmation_<?php echo ($i); ?>" data-sno="<?php echo ($i); ?>" data-questionid="<?php echo ($i); ?>" data-stype="<?php echo $question['SelectionType']; ?>" data-optionid="<?php echo ($j."_".$i); ?>" data-value="<?php echo ($j); ?>"> 
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
                                        <textarea placeholder="<?php echo $question['OtherValue']; ?>" class="span12" id="qAaTextarea_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"><?php echo $userAnswerObj["OtherValue"];?></textarea>  
                                        <div class="control-group controlerror">
                                            <div style="display:none"  id="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                     </div>
                     </div>
                     <div style="color:grey">
                        Correct Answers : <?php echo $correctAnswers;?>
                        <?php if($otherValue!=""){
                           echo "<br/>Other Option : ". $otherValue;                            
                        } ?>
                       
                        
                    </div> 
                            <div style="float:right"><span class="label label-warning record_size">Actual marks for this Question <b>(<?php echo $userAnswerObj['ActualScore'];?>)</b></span>
                               <!--<b>8Total Marks</b>--><input type="text" style="width: 20px" name="reviewQuestions" data-qid="<?php echo $question['QuestionId']; ?>" data-categoryId="<?php echo $categoryId ?>" data-testId="<?php echo $testId ?>" data-uniqueId="<?php echo $uniqueId ?>" onkeypress = "return isNumberKey(event)" id="reviewQuestions_<?php echo $uniqueId ?>" onkeyup="return validAnswer(event,this.value,'<?php echo $userAnswerObj['ActualScore'];?>')" value="<?php echo $userAnswerObj["Score"]?>" <?php if($userAnswerObj["IsReviewed"]=="2") echo "readonly"?>/>
                         </div>
                     </div>
                    </div>
             <?php $this->endWidget(); ?>  
        
         <?php }
         
     $i++;
    } ?>
  
<script type="text/javascript">

var qCount = '<?php echo sizeof($surveyObj->Questions); ?>';
$("input.textfield").prop('readonly', true);
$("input:radio").attr('disabled',true);
$("input:checkbox").attr('disabled',true);
Custom.init();$("[rel=tooltip]").tooltip();
</script>

  <?php  }
      }
      ?>
<div class="row-fluid" >
        <div class="span12">
            <div class="span10">
                
            </div>
            <div class="span2">
                 <label>&nbsp;&nbsp;</label>
                    <input type="button" value="Submit"  class="btn" id="submitReviewAnswers"> 
            </div>
               
        </div>
    </div>
<?php 

}else{?>


<span class="text-error">
<b>No review questions found</b>
</span>
<?php    
}
      
?>
 
