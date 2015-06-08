<?php 
if(is_object($surveyObj)){ ?>
<input type="hidden" value="<?php echo $userId; ?>" name="QuestionsSurveyForm[UserId]" id="QuestionsSurveyForm_UserId"/>
<input type="hidden" value="<?php echo $scheduleId; ?>" name="QuestionsSurveyForm[ScheduleId]" id="QuestionsSurveyForm_ScheduleId"/>
<input type="hidden" name="QuestionsSurveyForm[SurveyId]" value="<?php echo $surveyObj->_id; ?>" id="QuestionsSurveyForm_SurveyId">
<input type="hidden" name="QuestionsSurveyForm[SurveyTitle]" value="<?php echo $surveyObj->SurveyTitle; ?>" id="QuestionsSurveyForm_SurveyTitle">
<input type="hidden" name="QuestionsSurveyForm[SurveyDescription]" value="<?php echo $surveyObj->SurveyDescription; ?>" id="QuestionsSurveyForm_SurveyDescription">
<input type="hidden" name="QuestionsSurveyForm[SurveyLogo]" value="<?php echo $surveyObj->SurveyLogo; ?>" id="QuestionsSurveyForm_SurveyLogo">
<input type="hidden" name="QuestionsSurveyForm[Questions]" value="" id="QuestionsSurveyForm_Questions">
<input type="hidden" name="QuestionsSurveyForm[SurveyRelatedGroupName]" value="<?php echo $surveyObj->SurveyRelatedGroupName; ?>" id="QuestionsSurveyForm_SurveyRelatedGroupName">

<div class="padding10ltb">
     <?php if($surveyObj->IsBannerVisible == 1){ ?>
    <div id="userview_Bannerprofile"> 
     <h2 class="pagetitle">Market Research</h2>
    <div class="market_profile marginT10">
        <div class="m_profileicon" >
            
<div  class="pull-left marginzero generalprofileicon  skiptaiconwidth190x190 generalprofileiconborder5 skiptaiconwidth120x120tablet" >
                  <a   class="skiptaiconinner " >
                      <img alt="" src="<?php echo $surveyObj->SurveyLogo; ?>">
                  
                  </a>
                     </div>
           
        </div>
	   	 <div class="row-fluid padding-bottom5 padding-top35 mobilepadding-top35 ">
                    <div class="span12">
                    <div class="ext_surveyTitle"><?php echo $surveyObj->SurveyTitle; ?></div>
                     <?php if($surveyObj->SurveyRelatedGroupName != "0"){?><div class="ext_groupTitle  padding8top"><?php echo $surveyObj->SurveyRelatedGroupName; ?></div> <?php } ?> 
                     <div class="extcontent padding8top"><?php echo $surveyObj->SurveyDescription; ?> </div>
                    </div>
                    </div>
                                
    
     </div>
     </div>
<!--     <div class="row-fluid groupseperator border-bottom">
     <div class="span12 "><h2 class="pagetitle paddingleft5">Market Research Survey </h2></div>
     </div>-->
    <?php } ?>
     
     <div class="padding152010" style="" id="surveyQuestionArea">
         <?php 
         $i = 1; 
         $sno = $iValue;
         foreach($surveyObj->Questions as $question){ ?>
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
           // $userAnswer =  $bufferAnswers[$sno-1]["SelectedOption"];
            
             $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
             $userAnswer =  $userAnswerObj["SelectedOption"]; 
            
            //error_log("========userAnsser=====".print_r($userAnswer,1));
            ?>   

         <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="1" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["Other"]?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["OtherValue"]?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if(isset($userAnswer) && sizeof($userAnswer) > 0){ echo implode(",", $userAnswer);} ?>"/>
                    <div class="surveyquestionsbox" data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                        
                                <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo ($sno); ?>_em_" class="errorMessage"></div>
                            
                     <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo $question['Question']; ?></div>
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
             $userAnswer =  $userAnswerObj["SelectedOption"]; 
            
           // echo "ss-".print_r($userAnswer,true);
            ?> 
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="2" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["Other"]?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["OtherValue"]?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if(isset($userAnswer) && sizeof($userAnswer) > 0){ echo implode(",", $userAnswer);} ?>"/>
            <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                
                                <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $sno; ?>_em_" class="errorMessage"></div>
                            
                <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo $question['Question']; ?></div>
                     <div class="answersection">
                      <?php $j=1;
                      foreach($question['Options'] as $rw){ 
                        
                          ?>  
                         
                         <div class="normalsection ">
                        <div data-questionid="<?php echo $i; ?>" class="surveyradiobutton surveycheckboxbutton checkboxoption_<?php echo ($i); ?>" data-optionid="<?php echo ($j."_".$i); ?>"> <input <?php if(isset($userAnswer) && in_array($j,$userAnswer)) echo "checked"; else echo ""?> type="checkbox" class="styled " data-type="checkbox" name="checkbox_<?php echo $i;?>" value="<?php echo $j;?>" id="optioncheckbox_<?php echo $j."_".$i;?>"></div>
                         <div class="answerview"><?php echo $rw; ?></div>
                        </div>
                      <?php $j++;} ?>
                         <?php if($question['Other'] == 1){ ?>
                             <div class="normalsection">
                            <div data-questionid="<?php echo $i; ?>" class="surveyradiobutton surveycheckboxbutton othercheckbox_scnd" data-optionid="<?php echo ($j."_".$i); ?>"> <input <?php if($userAnswerObj["Other"] == 1) echo "checked"; else echo "";?> type="checkbox" value="other" class="styled checkboxradio_<?php echo $i; ?>" data-type="othercheckbox" name="checkbox_<?php echo $i;?>" id="otherCheckbox_<?php echo ($j."_".$i); ?>"></div>
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
           // $userAnswer =  $bufferAnswers[$sno-1]["Options"];
            //echo "ss-".print_r($userAnswer,TRUE);
            
             $userAnswerObj = CommonUtility::getAnswerForQuestion($question['QuestionId'],$bufferAnswers);
             $userAnswer =  $userAnswerObj["Options"];
            ?> 
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="3" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php if($question['MatrixType'] == 3)echo ($sno) ;else echo ($i) ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if(isset($userAnswer) && sizeof($userAnswer) > 0){ echo implode(",", $userAnswer);} ?>"/>
                       <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                           <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php if($question['MatrixType'] == 3)echo ($sno) ;else echo ($i)  ?>_em_" class="errorMessage"></div>
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo $question['Question']; ?></div>
                        <div class="answersection">
                       <div class="paddingtop12">
                           <div class="MR_view_table"> 
                        <table cellpadding="0" cellspacing="0" class="customsurvaytable customsurvaytableview">
                        <tr>
                        <th ></th>
                        <?php $ln = 0; foreach($question['LabelName'] as $rw){?>
                            <th class="col2">
                                <div><?php echo $rw; ?></div>
                                <?php if(isset($question['LabelDescription'][$ln]) && !empty($question['LabelDescription'][$ln])){ ?>
                                <div class="info_color"><?php echo $question['LabelDescription'][$ln]; ?></div>
                                <?php $ln++;} ?> 
                            </th>                            
                        <?php } ?>
                            <?php if($question['Other'] == 1) { ?>
                                <th class="col2">N/A</th>
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
                            <input type="hidden" name="QuestionsSurveyForm[OptionTextValue][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_OptionTextValue_<?php echo ($k."_".$i); ?>" class="OptionTextValueclass_<?php echo $i; ?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
                            <div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionOtherValue_<?php echo $k."_".$i;?>">
                                <input maxlength="200" placeholder="<?php echo $rw; ?>" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionOtherValue_<?php echo $k; ?>" id="OptionOtherValue_<?php echo $i; ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OptionTextValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
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
                                    
                                    <?php //if($ik == 0 ){ ?> 
                                        $("div.radioTable_<?php echo $j."_".$i; ?> span.radio").live("click",function(){
                                            <?php $ik++; ?>
                                        
                                        $("div.radioTable_<?php echo $j."_".$i; ?> span.radio").each(function(key){                                         
                                            $(this).attr("style","background-position:0 0");
//                                            alert($(this).siblings('.radiotype_<?php echo $i; ?>').val())
                                            if($(this).siblings('.radiotype_<?php echo $i; ?>').is(':checked') == false){
                                                var idd = $(this).siblings('.radiotype_<?php echo $i; ?>').attr('data-hidname')

//                                                $("#"+idd).val("");
                                                
                                            }
                                            if($(this).siblings('.radiotype_<?php echo $i; ?>').val() != ""){
                                                
                                            }
                                            $(this).siblings('.radiotype_<?php echo $i; ?>').attr('checked',false);
                                        });                                        
                                         $(this).attr("style","background-position:0 -50px");
                                         $(this).siblings('.radiotype_<?php echo $i; ?>').attr('checked',true);
//                                         $(".questionOptionhidden_<?php //echo ($k."_".$i); ?>").each(function(){
//                                             var value = $(this).val();
//                                             var $thisq = $(this);
//                                             $("div.radioTable_<?php //echo $j."_".$i; ?> span.radio").each(function(){                                         
//                                            $("#QuestionsSurveyForm_OptionValue_<?php //echo ($k."_".$i); ?>").val("")
//                                                if($(this).attr("style") == "background-position:0 0"){
////                                                    $thisq.val("");
//                                                }
//                                            });  
//                                         });
//                                        ik = 0;
                                    });
                                    
                                    <?php // } ?>
                                    
                                     
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
             $userAnswer =  $userAnswerObj["Options"];
             
              //echo "ss-".print_r($userAnswer,TRUE)."array[0]==".$userAnswer[0];
            ?> 
           <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="4" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>"/>
        
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php if($question['MatrixType'] == 3)echo ($sno) ;else echo ($i) ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" value="<?php if($question['MatrixType'] == 3){ if(isset($userAnswer[0]) && sizeof($userAnswer[0]) > 0 && $userAnswer[0] != ""){ echo "1";} }else{if(isset($userAnswer[0]) && sizeof($userAnswer[0]) > 0 && $userAnswer[0] != "") echo implode(",",$userAnswer);} ?>"/>
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php if($question['MatrixType'] == 3)echo ($sno) ;else echo ($i) ?>_em_" class="errorMessage"></div>                        
                    
                    <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo $question['Question']; ?></div>
                        <div class="answersection">
                       <div class="paddingtop12">
                           <div class="MR_view_table"> 
                        <table cellpadding="0" cellspacing="0" class="customsurvaytable customsurvaytableview">
                        <tr>
                        <th ></th>
                        <?php $labelsSize = $question['NoofRatings']; $lb =1; $rv = 1; foreach($question['LabelName'] as $rw){
                            ?>
                        
                            <th class="col2">
                            <div><?php echo $rw; ?></div>
                            <?php if(isset($question['LabelDescription'][$lb-1]) && !empty($question['LabelDescription'][$lb-1])){ ?>
                                <div  class="info_color"> <?php echo $question['LabelDescription'][$lb-1]; ?></div>
                            <?php } ?>   
                                
                        </th>
                        <?php $lb++; } ?>
                            <?php if($question['Other'] == 1) { ?>
                                <th class="col2">N/A</th>
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
                             <?php } ?>
                                
                            <td><?php if($optionsSize == $k && $question['AnyOther'] == 1){  ?>
                                <input type="hidden" name="QuestionsSurveyForm[OptionTextValue][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_OptionTextValue_<?php echo ($k."_".$i); ?>" class="OptionTextValueclass_<?php echo $i; ?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
                            <div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionOtherValue_<?php echo $k."_".$i;?>">
                                <input maxlength="200" placeholder="<?php echo $rw; ?>" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionOtherValue_<?php echo $k; ?>" id="OptionOtherValue_<?php echo $i; ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i;?>" value="<?php echo $userAnswerObj["OptionOtherTextValue"]?>"/>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OptionTextValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            </div>
                                    </div>
                            
                        <?php }else{ echo $rw;} ?></td>
                                <?php 
                                    if($question['TextOptions'] ==1 || $question['TextOptions'] == 3) {
                                        for($j=1;$j<= $question['NoofRatings'];$j++){ ?>
                                        <td><div data-questionid="<?php echo $i; ?>" class="positionrelative displaytable radioRatingTable" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                        <input type="radio" <?php if(isset($userAnswer) && $userAnswer[$k-1]==$j) echo "checked"; else echo ""?> class="styled radiotype_rat_<?php echo $i; ?>" name="rating_<?php echo $k; ?>" id="ratingRadio_<?php echo $k; ?>" value="<?php echo $j;?>" />
                                        </div></td>
                                            
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
                                        <input class="optionvalueclass_<?php echo ($k."_".$i); ?> textfield textfieldtable"  type="text" name="QuestionsSurveyForm[OptionMatrixValueOther][<?php echo ($rv."_".$j); ?>]"   id="QuestionsSurveyForm_OptionValueOther_<?php echo ($k."_".$i); ?>" value="<?php echo $userAnswer[$rv-1][$j] ?>" onblur="updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')" onkeyup="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"  onkeydown="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')" value="<?php echo $userAnswer[$rv-1][$j] ?>"/>
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
             $userAnswer =  $userAnswerObj["DistributionValues"];
             // echo "ss-".print_r($userAnswerObj,TRUE);
            ?> 
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
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo $question['Question']; ?></div>
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
             $userAnswer =  $userAnswerObj["UserAnswer"];
           
            ?> 
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="6" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[UserAnswer][<?php echo ($sno); ?>]"  id="QuestionsSurveyForm_UserAnswer_hid_<?php echo ($i); ?>" value="<?php echo $userAnswer;?>"/>
                     <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                         <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_UserAnswer_<?php echo $sno; ?>_em_" class="errorMessage"></div>    
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo $question['Question']; ?></div>
                        
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
             $userAnswer =  $userAnswerObj["UsergeneratedRankingOptions"];
            //echo print_r($userAnswer,true);
            ?> 
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="7" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"  id="QuestionsSurveyForm_OptionsSelected_hid_<?php echo ($i); ?>" value="<?php if(is_array($userAnswer)){echo "dummy";}?>"/>
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $sno; ?>_em_" class="errorMessage"></div>    
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo $question['Question']; ?></div>
                        
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
             $userAnswer =  $userAnswerObj["SelectedOption"]; 
             $otherValue =  $userAnswerObj["OtherValue"];
              
           // echo print_r($userAnswer,true);
            // echo $otherValue;
            ?>   

                    <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="1" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
                    <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
                    <input type="hidden" name="QuestionsSurveyForm[OtherJustification][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>" />
                    <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>" value="<?php echo $userAnswerObj["OtherValue"];?>"/>
                    <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($sno); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($sno); ?>" value="<?php if($question['SelectionType'] == 1){ echo $userAnswer[0];}else{ if(sizeof($userAnswer)>0) echo implode(",",$userAnswer);}?>"/>
                    <div class="surveyquestionsbox" data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                        
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $sno; ?>_em_" class="errorMessage"></div>
                            
                     <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $sno; ?>)</div> <?php echo $question['Question']; ?></div>
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
                     </div>
                    </div>
             <?php $this->endWidget(); ?>  
         <script type="text/javascript">
              var ind =0;                  
                  
                  
          </script>
         <?php }
     $i++;
     $sno++;
     break;
                             } ?>
     
     
     </div>   
</div>
  

<script type="text/javascript">
   
Custom.init();

</script>



  <?php       }else{ ?>
<div  id="streamsectionarea_error" class="" style="padding-bottom: 40px">
            <div class="ext_surveybox NPF_outside lineheightsurvey">
                <center class="ndm" id="errorTitle" ><?php echo $errMessage; ?></center>
            </div>
        </div>
      <?php  }
?>