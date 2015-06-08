<?php 

if(is_object($surveyObj)){ ?>
<input type="hidden" name="QuestionsSurveyForm[SurveyId]" value="<?php echo $surveyObj->_id; ?>" id="QuestionsSurveyForm_SurveyId">
 
   


                
  
<div class="padding10ltb">
    <div id="previewHeader" >
      <div class="row-fluid">
          <div class="span12">
              <div class="span8"> <h2 class="pagetitle">Market Research</h2></div> <div class="span3">
                              <label>Number of Questions Per Page</label>
                              <div class="positionrelative" style="width:200px">
    
                    <select id="preview_questionview"  name="questionview"  class="styled" style="width: 200px">
<option value="0" <?php if($QuestionViewType == 0) echo "selected";?>>All at once</option>
<option value="1" <?php if($QuestionViewType == 1) echo "selected";?>>At a time 1 Question</option>
<option value="2" <?php if($QuestionViewType == 2) echo "selected";?>>At a time 2 Questions</option>
<option value="3" <?php if($QuestionViewType == 3) echo "selected";?>>At a time 3 Questions</option>
<option value="4" <?php if($QuestionViewType == 4) echo "selected";?>>At a time 4 Questions</option>
<option value="5" <?php if($QuestionViewType == 5) echo "selected";?>>At a time 5 Questions</option>
</select>  
</div>
              </div>
              <div class="span1 pull-right">
               <div class="grouphomemenuhelp alignright tooltiplink"> <a  id="preview_survey_page" class="detailed_close_page" rel="tooltip"  data-original-title="close" data-placement="bottom" data-toggle="tooltip"> <i class="fa fa-times"></i></a> </div>
              </div>
              </div>

                
                 </div>
                </div>
     <?php if($surveyObj->IsBannerVisible == 1){ ?>
    <div id="userview_Bannerprofile"> 
    
    <div class="market_profile marginT10">
	<div class="m_profileicon">
            
            
            <div class="pull-left marginzero generalprofileicon  skiptaiconwidth190x190 generalprofileiconborder5 noBackGrUp">
                            <div class="positionrelative editicondiv editicondivProfileImage no_border editicondivProfileImagelarge skiptaiconinner ">
                                
                                <div style="display: none;" class="edit_iconbg">
                                    <div id="UserProfileImage"><div class="qq-uploader"><div class="qq-upload-button" style="position: relative; overflow: hidden; direction: ltr;">Upload a file<input type="file" multiple="multiple" capture="camera" name="file" style="position: absolute; right: 0px; top: 0px; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;"></div></div></div>


                                    
                                </div>
<!--                                <img id="profileImagePreviewId" src="" alt="" />-->
                               <img alt="" src="<?php echo $surveyObj->SurveyLogo; ?>" id="profileImagePreviewId">
                            </div>
                
                            <div><ul id="uploadlist_logo" class="qq-upload-list"></ul></div>
                        </div></div>
                        
	   	 <div class="row-fluid padding-bottom5 padding-top35 mobilepadding-top35 ">
                    <div class="span12">
                    <div class="ext_surveyTitle"><?php echo $surveyObj->SurveyTitle; ?></div>
                     <?php if($surveyObj->SurveyRelatedGroupName != "0"){?><div class="ext_groupTitle  padding8top"><?php echo $surveyObj->SurveyRelatedGroupName; ?></div> <?php } ?> 
                     <div class="extcontent padding8top wordwrap100" ><?php echo $surveyObj->SurveyDescription; ?> </div>
                    </div>
                    </div>
                                
    
     </div>
     </div>
     
<!--     <div class="row-fluid groupseperator border-bottom">
     <div class="span12 "><h2 class="pagetitle paddingleft5">Market Research Survey </h2></div>
     </div>-->
    <?php } ?>
     
     <div class="padding152010" style="" id="surveyQuestionArea">
<!--         <div id="userviewErrMessage" class="alert alert-error" style="display: none;"></div>-->
         <?php 
         $i = $QNumber; 
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
            ?>   

         <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="1" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>"/>
                    <div class="surveyquestionsbox" data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                        
                                <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            
                     <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                     <div class="answersection">
                      <?php $j = 1;foreach($question['Options'] as $rw){ ?>   
                         <div class="normalsection ">
                             <div class="surveyradiobutton radiooption_<?php echo ($i); ?>" data-optionid="<?php echo ($j."_".$i); ?>"> <input value="<?php echo ($j); ?>" type="radio" class="styled " name="radio_<?php echo $i;?>" id="optionradio_<?php echo $j."_".$i;?>"></div>
                         <div class="answerview"><?php echo $rw; ?></div>
                        </div>
                      <?php $j++; } ?>
                         <?php if($question['Other'] == 1){ ?>
                             <div class="normalsection">
                            <div class="surveyradiobutton otherradio_<?php echo ($i); ?>" data-optionvalue="<?php echo ($j); ?>"> <input type="radio" class="styled" name="radio_<?php echo $i;?>" ></div>
                             <div class="row-fluid">
                            <div class="span12">
                                <input  type="text" class="textfield span4" placeHolder="<?php echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
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
          
            ?> 
        
            <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                
                                <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $sno; ?>_em_" class="errorMessage"></div>
                            
                <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                        
                     <div class="answersection">
                          <?php if($question['DisplayType'] == 1){ //Checkbox ?>
                         
                         <div class="normalsection ">
                             <div data-selType="checkboxselectall" data-questionid="<?php echo ($i); ?>" class="surveyradiobutton checkboxselectalldiv" data-questionid="<?php echo $i; ?>"><input class="styled checkboxselectall" type="checkbox" name="selectall_<?php echo ($i); ?>" id="selectall_<?php echo ($i); ?>" /></div>
                             <div class="answerview"><?php echo Yii::t("translation","Checkbox_SelectAll"); ?></div>
                         </div>
                         <?php } ?>
                         <?php if($question['DisplayType'] == 1){ ?>
                      <?php $j=1;
                      foreach($question['Options'] as $rw){ 
                        
                          ?>  
                         
                         <div class="normalsection ">

                        <div data-questionid="<?php echo ($i); ?>" class="surveyradiobutton surveycheckboxbutton checkboxoption_<?php echo ($i); ?>" data-optionid="<?php echo ($j."_".$i); ?>"> <input  type="checkbox" class="styled " data-type="checkbox" name="checkbox_<?php echo $i;?>" value="<?php echo $j;?>" id="optioncheckbox_<?php echo $j."_".$i;?>"></div>

                         <div class="answerview"><?php echo $rw; ?></div>
                        </div>
                         
                         <?php $j++;}}else{  //Multi-Select dropdown... ?>
                             <div class="row-fluid ">
                                 <div class="span4">
                                     <select  multiple="true" id="chmultiselect_<?php echo ($i); ?>" class="minheight100 checkboxmultiselect" data-questionid="<?php echo ($i); ?>">
                                 <option  value="0"><?php echo Yii::t("translation","Checkbox_SelectAll"); ?></option>
                                 <?php $iopt = 1; foreach($question['Options'] as $rw){ ?>
                                 <option  value="<?php echo $iopt; ?>" ><?php echo $rw; ?></option>
                                 <?php $iopt++; } ?>
                                 <?php if($question['Other'] == 1){                                      
                                     ?>
                                 <option  value="other" ><?php echo $question['OtherValue'];?></option>
                                 <?php } ?>
                             </select>
                                 </div>
                         </div>
                        
                         <div class="row-fluid" style="display: none" id="othertextfield_<?php echo ($i); ?>">
                            <div class="span12">
                                <input  type="text" value="" class="textfield span4" placeHolder="<?php echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            </div>
                            </div>
                            </div>
                        
                         <?php }?>
                         
                         
                         <?php if($question['Other'] == 1 && $question['DisplayType'] == 1){ ?>
                             <div class="normalsection">

                            <div data-questionid="<?php echo ($i); ?>" class="surveyradiobutton surveycheckboxbutton othercheckbox_<?php echo ($i); ?>" data-optionid="<?php echo ($j."_".$i); ?>"> <input  type="checkbox" value="other" class="styled checkboxradio_<?php echo $i; ?>" data-type="othercheckbox" name="checkbox_<?php echo $i;?>" id="otherCheckbox_<?php echo ($j."_".$i); ?>"></div>

                             <div class="row-fluid">
                            <div class="span12">
                                <input  type="text" value="" class="textfield span4" placeHolder="<?php echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
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
    
              
         <?php } else if($question['QuestionType'] == 3){ // ranking...?>
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
            ?> 
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="3" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>"/>
                       <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                           <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $i; ?>_em_" class="errorMessage"></div>
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                        <div class="answersection">
                       <div class="paddingtop12">
                           <div class="MR_view_table"> 
                        <table cellpadding="0" cellspacing="0" class="customsurvaytable customsurvaytableview">
                        <tr>
                        <th class=""></th>
                        <?php $ln = 0; foreach($question['LabelName'] as $rw){?>
                        <th <?php if($question['StylingOption'] == 2){?> class="col2" <?php }?>>
                            <div><?php echo $rw; ?></div>
                            <?php if(isset($question['LabelDescription'][$ln]) && !empty($question['LabelDescription'][$ln])){ ?>
                            <div class="info_color"> <?php echo $question['LabelDescription'][$ln]; ?></div>
                            <?php $ln++;} ?>  
                        </th>
                        <?php } ?>
                            <?php if($question['Other'] == 1) { ?>
                                <th <?php if($question['StylingOption'] == 2){?> class="col2" <?php }?>>N/A</th>
                            <?php } ?>
                        </tr>
                        
                            <?php $anyOther = 0;$noofoptions=0; $k = 1;$optionsSize = sizeof($question['OptionName']);foreach($question['OptionName'] as $rw){ ?>
                        
                        <tr>                            
                        <?php if(trim($rw) != trim("")){ ?>
                            <?php if($optionsSize != $k || $question['AnyOther'] == 0){ ?>
                            <input class="questionOptionhidden_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValue_<?php echo ($k."_".$i); ?>"/>
                            <?php }else{ ?>
                            <input class="questionOptionhidden_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionValueOther][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValueOther_<?php echo ($k."_".$i); ?>"/>
                            
                            <?php } ?>
                            
                        <td><?php if($optionsSize == $k && $question['AnyOther'] == 1){  ?>
                            <input type="hidden" name="QuestionsSurveyForm[OptionTextValue][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_OptionTextValue_<?php echo ($k."_".$i); ?>" class="OptionTextValueclass_<?php echo $i; ?>"/>
                            <div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionOtherValue_<?php echo $k."_".$i;?>">
                                <input maxlength="200" placeholder="<?php echo $rw; ?>" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionOtherValue_<?php echo $k; ?>" id="OptionOtherValue_<?php echo $i; ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i;?>" />
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
                                    <?php if($optionsSize != $k || $question['AnyOther'] == 0){ ?>
                                    <td><div  class="positionrelative displaytable radioTable_<?php echo $j."_".$i; ?>" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                        <input type="radio" class="styled radiotype_<?php echo $i; ?>" name="ranking_<?php echo $k; ?>" id="rankingRadio_<?php echo $k; ?>" value="<?php echo $j;?>" data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>"/>
                                    </div></td>
                                    <?php }else{ ?>
                                    <td>
                                        <div  class="positionrelative displaytable radioTable_<?php echo $j."_".$i; ?>" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValueOther_<?php echo $k."_".$i;?>">
                                        <input type="radio" class="styled radiotype_<?php echo $i; ?>" name="ranking_<?php echo $k; ?>" id="rankingRadio_<?php echo $k; ?>" value="<?php echo $j;?>" data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValueOther_<?php echo $k."_".$i;?>"/>
                                    </div>
                                    </td>
                                    <?php } ?>
                                    
                                
                        
                                <?php } ?>
                                
                                
                                 <?php }else if($question['TextOptions'] == 2){ 
                                     
                                     for($j=1;$j<=$question['NoofOptions'];$j++){ ?>
                                    <td><div  class="positionrelative surveydeleteaction radioTable_<?php echo $j."_".$i; ?>" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                            <input maxlength="<?php echo $question['TextMaxlength']; ?>"  type="text" class="textfield textfieldtable radiotype_<?php echo $k; ?> radiotypecol_<?php echo $j; ?> textoption_<?php echo $i; ?>" name="ranking_<?php echo $k; ?>" id="rankingRadio_<?php echo $k; ?>" data-row="<?php echo $k; ?>" data-col="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>"/>
                                    </div></td>
                                 <?php }  }?>
                                <?php if($question['Other'] == 1) { ?>
                                <!--<input type="hidden" name="QuestionsSurveyForm[OptionValue][<?php //echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValue_<?php //echo ($k."_".$i); ?>"/>-->
                                <td><div class="positionrelative displaytable radioTable_<?php echo $j; ?>" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                        <input type="radio" placeholder="" class="styled radiotype_<?php echo $i; ?>" name="ranking_<?php echo $k; ?>" id="otherradioranking_<?php echo $k; ?>" value="<?php echo $j;?>" data-name="<?php echo $j ?>"/>
                                </div></td>
                            <?php }
                                 if($question['TextOptions'] == 3){ ?>
                                <input class="questionOptionCommnetValue_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionCommnetValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionCommnetValue_<?php echo ($k."_".$i); ?>"/>
                                        <td><div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>">
                                                <input placeholder="<?php echo $question['JustificationPlaceholders'][$k-1]; ?>" maxlength="200" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionCommnetValue_<?php echo ($k."_".$i); ?>" id="OptionCommnetValue_<?php echo ($k."_".$i); ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>" />
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
      
         <?php } else if($question['QuestionType'] == 4){ //rating... ?>
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
            ?> 
           <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="4" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>"/>
        
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>" />
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $i; ?>_em_" class="errorMessage"></div>                        
                    
                    <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                        <div class="answersection">
                       <div class="paddingtop12">
                        <div class="MR_view_table"> 
                        <table cellpadding="0" cellspacing="0" class="customsurvaytable customsurvaytableview">
                        <tr>
                        <th class=""></th>
                        <?php $labelsSize = $question['NoofRatings']; $lb =1; $rv = 1; foreach($question['LabelName'] as $rw){
                            ?>
                        
                            <th <?php if($question['StylingOption'] == 2){?> class="col2" <?php }?>>
                            <div><?php echo $rw; ?></div>
                            <?php if(isset($question['LabelDescription'][$lb-1]) && !empty($question['LabelDescription'][$lb-1])){ ?>
                                <div  class="info_color"> <?php echo $question['LabelDescription'][$lb-1]; ?></div>
                            <?php } ?>   
                                
                        </th>
                        <?php $lb++; } ?>
                            <?php if($question['Other'] == 1) { ?>
                                <th <?php if($question['StylingOption'] == 2){?> class="col2" <?php }?>>N/A</th>
                            <?php } ?>
                        </tr>
                        
                            <?php $k = 1;$anyOther = 0;$noofoptions=0;$optionsSize = sizeof($question['OptionName']);foreach($question['OptionName'] as $rw){ ?>
                    
                        <tr>
                            <?php if(trim($rw) != trim("")){ ?>
                            
                            <?php if($question['TextOptions'] != 2){ ?>
                                <?php if($optionsSize != $k || $question['AnyOther'] == 0){ ?>
                                    <input type="hidden" name="QuestionsSurveyForm[OptionValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValue_<?php echo ($k."_".$i); ?>" class="optionvalueclass_<?php echo $i; ?>"/>
                            <?php }else{ ?>
                                    <input class="optionvalueclass_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionValueOther][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionValueOther_<?php echo ($k."_".$i); ?>"/>
                            <?php } ?>
                             <?php } ?>                                
                             
                            <td><?php if($optionsSize == $k && $question['AnyOther'] == 1){  ?>
                                <input type="hidden" name="QuestionsSurveyForm[OptionTextValue][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_OptionTextValue_<?php echo ($k."_".$i); ?>" class="OptionTextValueclass_<?php echo $i; ?>" />
                            <div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionOtherValue_<?php echo $k."_".$i;?>">
                                <input maxlength="200" placeholder="<?php echo $rw; ?>" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionOtherValue_<?php echo $k; ?>" id="OptionOtherValue_<?php echo $i; ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionTextValue_<?php echo $k."_".$i;?>" />
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OptionTextValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            </div>
                                    </div>
                            
                        <?php }else{ echo $rw;} ?></td>
                                <?php 
                                    if($question['TextOptions'] ==1 || $question['TextOptions'] == 3) {
                                        for($j=1;$j<= $question['NoofRatings'];$j++){ ?>
                                        <?php if($optionsSize != $k || $question['AnyOther'] == 0){ ?>
                                        <td><div class="positionrelative displaytable radioRatingTable" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                        <input type="radio" class="styled radiotype_rat_<?php echo $i; ?>" name="rating_<?php echo $k; ?>" id="ratingRadio_<?php echo $k; ?>" value="<?php echo $j;?>" />
                                        </div></td>
                                        <?php }else if($optionsSize == $k && $question['AnyOther'] == 1){ ?>
                                         <td><div class="positionrelative displaytable radioRatingTable" data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValueOther_<?php echo $k."_".$i;?>">
                                        <input type="radio" class="styled radiotype_rat_<?php echo $i; ?>" name="rating_<?php echo $k; ?>" id="ratingRadio_<?php echo $k; ?>" value="<?php echo $j;?>" />
                                        </div></td>
                                        <?php }?>
                                            
                                        <?php }
                                        if($question['TextOptions'] == 3){ ?>
                                             
                                        <?php }
                                    }else if($question['TextOptions'] == 2){ $ratingsSize = $question['NoofRatings']; ?>
                                        <input type="hidden" name="QuestionsSurveyForm[OptionTextMValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionTextMValue_<?php echo ($k."_".$i); ?>" class="optionvalueclass_<?php echo $i; ?>"/>
                                    
                                    
                                   
                                         <?php  for($j=0;$j<$question['NoofRatings'];$j++){ ?>
                                    <?php if($optionsSize != $k  || $question['AnyOther'] == 0){ ?>
                                    <td>
                                       
                                        <div  class="positionrelative surveydeleteaction " data-optionid="<?php echo $k; ?>" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                            <input type="text" onkeyup="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"  onkeydown="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')" class="textfield textfieldtable questionType4_matrix_<?php echo $i; ?>"  name="QuestionsSurveyForm[TextOptionValues][<?php echo ($rv."_".$j."_".$i); ?>]"  onblur="updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"/>
                                    </div>
                                    
                                        </td>
                                    <?php }else if($optionsSize == $k && $question['AnyOther'] == 1){?>
                                        <td>
                                       
                                        <div  class="positionrelative surveydeleteaction ">
                                        <input class="optionvalueclass_<?php echo ($k."_".$i); ?> textfield textfieldtable"  type="text" name="QuestionsSurveyForm[OptionMatrixValueOther][<?php echo ($rv."_".$j); ?>]"   id="QuestionsSurveyForm_OptionValueOther_<?php echo ($k."_".$i); ?>" onkeyup="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"  onkeydown="allowNumericsAndCheckFields(event,this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>');updateTextRadiohiddenFields(this,'<?php echo $k; ?>','<?php echo $i; ?>','<?php echo $j; ?>','<?php echo $question['TextMaxlength']; ?>')"/>
                                        </div>
                                        </td>
                                    <?php } ?>
                                        
                                 <?php } $rv++; }?>
                                
                               
                                
                                <?php if($question['Other'] == 1) { ?>
                                <td><div class="positionrelative displaytable radioRatingTable" data-name="<?php echo $j ?>" data-hidname="QuestionsSurveyForm_OptionValue_<?php echo $k."_".$i;?>">
                                 <input type="radio" class="styled radiotype_rat_<?php echo $i; ?>" name="rating_<?php echo $k; ?>" id="ratingRadio_<?php echo $k; ?>" value="<?php echo $j;?>"/>
                                </div></td>
                            <?php } 
                                if($question['TextOptions'] == 3){ ?>
                                <input class="questionOptionCommnetValue_<?php echo ($k."_".$i); ?>" type="hidden" name="QuestionsSurveyForm[OptionCommnetValue][<?php echo ($k."_".$i); ?>]"   id="QuestionsSurveyForm_OptionCommnetValue_<?php echo ($k."_".$i); ?>"/>
                                        <td><div  class="positionrelative surveydeleteaction"   data-hidname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>">
                                                <input placeholder="<?php echo $question['JustificationPlaceholders'][$k-1]; ?>" maxlength="200" type="text" class="textfield textfieldtable" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" name="OptionCommnetValue_<?php echo ($k."_".$i); ?>" id="OptionCommnetValue_<?php echo ($k."_".$i); ?>"  data-name="<?php echo $j ?>" data-col="<?php echo $j ?>" data-hiddenname="QuestionsSurveyForm_OptionCommnetValue_<?php echo $k."_".$i;?>" />
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
            ?> 
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="5" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_OptionsSelected_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[TotalCalValue][<?php echo ($i); ?>]"   id="QuestionsSurveyForm_TotalCalValue_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[Other][<?php echo ($i); ?>]" id="QuestionsSurveyForm_Other_<?php echo ($i); ?>" />
         <input type="hidden" name="QuestionsSurveyForm[OtherValue][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OtherValue_<?php echo ($i); ?>" />
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_TotalCalValue_<?php echo $i; ?>_em_" class="errorMessage"></div> 
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $i; ?>_em_" class="errorMessage"></div> 
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                           <?php $k = 1; foreach($question['OptionName'] as $rw){ ?>
                           <input type="hidden" name="QuestionsSurveyForm[DistValue][<?php echo ($k."_".$i); ?>]" id="QuestionsSurveyForm_DistValue_hid_<?php echo ($k."_".$i); ?>" />
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
                     <input type="text" class="textfield span12 distvalue_<?php echo $i; ?>" id="QuestionsSurveyForm_DistValue_<?php echo $k."_".$i; ?>" data-hiddenname="QuestionsSurveyForm_DistValue_hid_<?php echo $k."_".$i; ?>" onkeyup="insertText(this.id);" onblur="insertText(this.id);updateValues(this,'<?php echo $i; ?>')" onkeydown="allowNumerics(event,this,'<?php echo $i; ?>')">
                     </div>
                     </div>

                     </div>
                     </div>

                    </div>

                    </div>
                           <?php $k++;} ?>
                        <?php if($question['Other'] == 1){ ?>
                           <input type="hidden" name="QuestionsSurveyForm[DistValue][<?php echo ($k."_".$i); ?>]" id="QuestionsSurveyForm_DistValue_hid_<?php echo ($k."_".$i); ?>" />
                           <div class="answersection">
                             <div class="normalsection">                            
                             <div class="row-fluid">
                            <div class="span6">
                                <div class="surveyradiobutton top3"><?php echo $k; ?>)</div>
                                <div class="answerview"><input  type="text" class="textfield span4" placeHolder="<?php echo $question['OtherValue'];?>"  id="othervalue_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)" /></div>
                                <div class="control-group controlerror">
                                <div style="display:none"  id="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>_em_" class="errorMessage"></div>
                            </div>
                            </div>
                                 <div class="span2 total" data-num="<?php echo $question['TotalValue']; ?>">
                                <div class="positionrelative pricetype">
                                <div class="percentdiv"><?php if( $question['MatrixType'] == 1) echo "%"; else echo "$";?> </div>
                                <input type="text" class="textfield span12 distvalue_<?php echo $i; ?>" id="QuestionsSurveyForm_DistValue_<?php echo $k."_".$i; ?>" data-hiddenname="QuestionsSurveyForm_DistValue_hid_<?php echo $k."_".$i; ?>" onkeyup="insertText(this.id);" onblur="insertText(this.id);updateValues(this,'<?php echo $i; ?>')" onkeydown="allowNumerics(event,this,'<?php echo $i; ?>')" >
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
            ?> 
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="6" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[UserAnswer][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_UserAnswer_hid_<?php echo ($i); ?>"/>
                     <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                         <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_UserAnswer_<?php echo $i; ?>_em_" class="errorMessage"></div>    
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                        
                           <div class="answersection">
                         <div class="normalsection paddingleftzero ">
                        <div class="row-fluid">
                         <div class="span12">
                         
                         <?php if($question['NoofChars'] <= 100){ ?>
                            <div class="answerview" id="100chars">
                                <input type="text" class="textfield span12" value="" id="userquestionanswer100_<?php echo $i; ?>" data-hiddenname="QuestionsSurveyForm_UserAnswer_hid_<?php echo $i; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="<?php echo $question['NoofChars']; ?>"> 
                            </div>
                         <?php } else{ ?> 
                            
                         <div class="answerview" id="morethan500chars">
                             <textarea class="textfield span12" name="" id="userquestionanswer500_<?php echo $i; ?>" data-hiddenname="QuestionsSurveyForm_UserAnswer_hid_<?php echo $i; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)" maxlength="<?php echo $question['NoofChars']; ?>"></textarea>                             
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
            ?> 
        <input type="hidden" name="QuestionsSurveyForm[WidgetType][<?php echo ($i); ?>]" value="7" id="QuestionsSurveyForm_WidgetType_<?php echo ($i); ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[QuestionId][<?php echo ($i); ?>]"  value="<?php echo $question['QuestionId']; ?>"/>
         <input type="hidden" name="QuestionsSurveyForm[OptionsSelected][<?php echo ($i); ?>]"  id="QuestionsSurveyForm_OptionsSelected_hid_<?php echo ($i); ?>"/>
                <div class="surveyquestionsbox"  data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $i; ?>_em_" class="errorMessage"></div>    
                        <div class="surveyanswerarea surveyanswerviewarea">
                        <div class="paddingtblr30">
                           <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                        
                           <div class="answersection">
                            <?php for($j=1; $j<=$question['NoofOptions']; $j++){?>
                               <input type="hidden" name="QuestionsSurveyForm[UsergeneratedRanking][<?php echo ($j."_".$i); ?>]" id="QuestionsSurveyForm_UsergeneratedRanking_hid_<?php echo ($j."_".$i); ?>" />
                                <div class="normalsection ">
                                <div class="row-fluid">
                                <div class="span12">
                                <div class="span4">
                                <div class="surveyradiobutton top3 top8"><?php echo $j; ?> )</div>
                                <div class="answerview"><input type="text" class="textfield span12" id="QuestionsSurveyForm_OptionValue_<?php echo $j."_".$i; ?>" data-hiddenname="QuestionsSurveyForm_UsergeneratedRanking_hid_<?php echo $j."_".$i; ?>" onkeyup="insertText(this.id);updateValue('QuestionsSurveyForm_OptionsSelected_hid_<?php echo ($i); ?>',this.id);" onblur="insertText(this.id)"> </div>
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
           
            ?>   

                   
                    <div class="surveyquestionsbox" data-questionId="<?php echo $question['QuestionId']; ?>" data-questionno="<?php echo $i; ?>">
                        
                    <div class="alert alert-error" style="display:none"  id="QuestionsSurveyForm_OptionsSelected_<?php echo $sno; ?>_em_" class="errorMessage"></div>
                            
                     <div class="surveyanswerarea surveyanswerviewarea">
                     <div class="paddingtblr30">
                        <div class="questionview"><div class="questionview_numbers"><?php echo $i; ?>)</div> <?php echo $question['Question']; ?></div>
                     <div class="answersection">
                      <?php $j = 1;foreach($question['Options'] as $ky=>$rw){ ?>   
                         <div class="normalsection ">
                             <div data-justificationapplied="<?php echo $question['JustificationAppliedToAll']; ?>" data-justvalue="<?php  if(isset($question['Justification'][0]) && sizeof($question['Justification']) > 0){ echo implode(",",$question['Justification']); }  ?>" class="surveyradiobutton surveybooleanoptionsdiv confirmation_<?php echo ($i); ?>" data-sno="<?php echo ($sno); ?>" data-questionid="<?php echo ($i); ?>" data-stype="<?php echo $question['SelectionType']; ?>" data-optionid="<?php echo ($j."_".$i); ?>" data-value="<?php echo ($j); ?>"> 
                                 <?php if($question['SelectionType'] == 1){ ?>
                                 <input value="<?php echo ($j); ?>" type="radio" class="styled " name="radio_<?php echo $i;?>" id="optionradio_<?php echo $j."_".$i;?>">
                                 <?php }else{  ?>
                                 
                                 <input  value="<?php echo ($j); ?>" type="checkbox" class="styled " name="checkbox_<?php echo ($i);?>" id="optioncheckbox_<?php echo $j."_".$i;?>">
                                 <?php } ?>
                                 
                                 
                             </div>
                         <div class="answerview"><?php echo $rw; ?></div>
                        </div>
                      <?php $j++; } ?>
                         <div class="normaloutersection">
                            <div class="normalsection normalsection5">

                                <div class="row-fluid booleanwidget_<?php echo ($i); ?>"  id="rowfluidChars_<?php echo ($i); ?>" style="<?php if($otherValue!="" || $question['JustificationAppliedToAll'] == 1) echo "display:block"; else echo "display:none"?>">
                                    <div class="span12">                               
                                        <textarea placeholder="<?php echo $question['OtherValue']; ?>" class="span12" id="qAaTextarea_<?php echo ($i); ?>" data-hiddenname="QuestionsSurveyForm_OtherValue_<?php echo $i; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"></textarea>  
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
                   
                    
     
         <?php }
     $i++;} ?>
     
  
     
  

<script type="text/javascript">

 $(document).ready(function() {
     Custom.init();
       
    });
    
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
  
var qCount = '<?php echo sizeof($surveyObj->Questions); ?>';

 if("TRUE" == "<?php echo $Flag; ?>"){
    $("#p_submitQuestion").show();  
      $("#p_nextQuestion").hide();
       if(0 == "<?php echo $Page; ?>" || 1 == "<?php echo $Page; ?>"){
             $("#p_prevQuestion").hide(); 
         }else{
              $("#p_prevQuestion").show();
         }
 }else{
     $("#p_submitQuestion").hide();  
      if(0 == "<?php echo $Page; ?>" || 1 == "<?php echo $Page; ?>"){
             $("#p_nextQuestion").show();
             $("#p_prevQuestion").hide();
         }else{
             $("#p_nextQuestion").show();
             $("#p_prevQuestion").show();
         }
 }

   $('body, html').animate({scrollTop : 0}, 800,function(){});
</script>

 

  <?php       }else{echo $errMessage; }
?>  
                  
                    
        <div class=" alignright" id="surveysubmitbuttons">
                    
                      <input type="button" value="Previous" name="previous" class="btn" id="p_prevQuestion" style="display: none"> 
                     <input type="button" value="Next" name="next" class="btn" id="p_nextQuestion" style="display: none"> 
                      <input type="button" value="Done" name="commit" class="btn" id="p_submitQuestion" style="display: none"> 

                </div>
</div>