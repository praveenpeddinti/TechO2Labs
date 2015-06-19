<input type="hidden" name="ExtendedSurveyForm[MatrixType][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_MatrixType_hid_<?php echo $widgetCount; ?>"/>
<input type="hidden" name="ExtendedSurveyForm[NoofOptions][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>" />
<input type="hidden" name="ExtendedSurveyForm[NoofRatings][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_NoofRatings_hid_<?php echo $widgetCount; ?>" />
<input type="hidden" name="ExtendedSurveyForm[TextOptions][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_TextOptions_hid_<?php echo $widgetCount; ?>" value="1"/>

<input type="hidden" name="ExtendedSurveyForm[TextMaxlength][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_TextMaxlength_hid_<?php echo $widgetCount; ?>" value="1"/>
<input type="hidden" name="ExtendedSurveyForm[Other][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_NA_hid_<?php echo $widgetCount; ?>" class=""/>
<input type="hidden" name="ExtendedSurveyForm[StylingOption][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_StylingOption_hid_<?php echo $widgetCount; ?>" value="1"/>
<input type="hidden" name="ExtendedSurveyForm[AnswerSelected][<?php echo ($widgetCount); ?>]"   id="ExtendedSurveyForm_answerSelected_<?php echo ($widgetCount); ?>" />
<input type="hidden" name="ExtendedSurveyForm[IsAnswerFilled][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_IsAnswerFilled_<?php echo $widgetCount; ?>" />
<div class="paddingtblr1030">
    
    <?php include 'WidgetOptions.php'; ?>
    <?php include 'newfileuploadscript.php';?>
    <div class="tab_3">
        <div class="dropdownsectionarea dropdownmedium answersection1" data-qtype="3" data-questionId="<?php echo $widgetCount; ?>" id="answersection1_<?php echo $widgetCount; ?>">
            <div class="row-fluid">
                <div class="span12">
                    <div class="span3">                        
                        <div class="pull-left positionrelative">
                            <label class="rr_widget"><?php echo Yii::t("translation","RR_TypeofQuestion"); ?></label>
                            <select  class="styled  stypeofquestion" id="loadwidgetType_<?php echo $widgetCount; ?>" name="loadwidgetType_<?php echo $widgetCount; ?>">
                                <option value="1">Ranking</option>
                                <option value="2">Rating</option>
                                <option value="3">Matrix</option>
                            </select>
                        </div>
                    </div>  
                    <div class="span3" >
                        
                        <div class="pull-left positionrelative">
                            <label class="rr_widget"><?php echo Yii::t("translation","Ex_RRWidget_Styling_Title"); ?></label>
                            <select  class="styled stylingoptions" data-error="ExtendedSurveyForm_StylingType_<?php echo $widgetCount; ?>_em_"   data-hiddenname="ExtendedSurveyForm_StylingOption_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_StylingType_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm_StylingType_<?php echo $widgetCount; ?>">                                
                                <option value="1"><?php echo Yii::t("translation","Ex_RRWidget_Static_Col"); ?></option>
                                <option value="2"><?php echo Yii::t("translation","Ex_RRWidget_OptionSize"); ?></option>

                            </select>
                            <div class="control-group controlerror">
                                <div style="display:none"  id="ExtendedSurveyForm_StylingType_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="span3"  id="OptionType_<?php echo $widgetCount; ?>">                        
                        <div class="pull-left positionrelative">
                            <label ><?php echo Yii::t("translation","ExOptionType");?> </label>
                            <select  class="styled stextoptions"   data-idname="ExtendedSurveyForm_TextOptions_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_TextOptions_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_TextOptions_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm_TextOptions_<?php echo $widgetCount; ?>">
                                <option value="1"><?php echo Yii::t("translation","Radio_Options_only");?> </option>                                
                                <!--<option value="2"><?php //echo Yii::t("translation","Text_Options_only");?> </option>-->
                                <option value="3"><?php echo Yii::t("translation","Radio_with_Other_option");?> </option>                                
                            </select>
                            <div class="control-group controlerror">
                                <div style="display:none"  id="ExtendedSurveyForm_TextOptions_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
                            </div>
                        </div>
                    </div>
                    <div class="span3" id="noofoptionsdiv_<?php echo $widgetCount; ?>" >                        
                        <div class="pull-left positionrelative">
                            <label class="rr_widget">No.of Options</label>
                            <select  class="styled  snofooptions"  data-error="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>">
                                <option value="">Please select</option>

                                <?php for($i=1;$i<=10;$i++){ ?>

                                     <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                     <?php } ?>
                            </select>
                            <div class="control-group controlerror">
                                <div style="display:none"  id="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="span3" id="TextMaxlengthdiv_<?php echo $widgetCount; ?>" style="display: none;">
                        
                        <div class="pull-left positionrelative">
                            <label class="rr_widget">Max Value</label>
                            
<!--                            <select style="width: 80px" class="styled span6"  data-idname="ExtendedSurveyForm_TextMaxlength_<?php echo $widgetCount; ?>" data-hiddenname="ExtendedSurveyForm_TextMaxlength_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_TextMaxlength_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm_TextMaxlength_<?php echo $widgetCount; ?>">
                                <option value="1">1</option>                                
                                <option value="2">2</option>
                                <option value="3">3</option>                                
                            </select>
                            <div class="control-group controlerror">
                                <div style="display:none"  id="ExtendedSurveyForm_TextOptions_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
                            </div>-->
                            <input type="text" placeholder="<?php echo Yii::t("translation","Max_length");?>" maxlength="2" onkeydown="allowNumericsAndCheckFields(event)" onblur="allowNumericsAndCheckFields(event)" data-hiddenname="ExtendedSurveyForm_TextMaxlength_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_TextMaxlength_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm[TextMaxlength][<?php echo $widgetCount; ?>]"></div>
                            <div class="control-group controlerror">
                                <div style="display:none"  id="ExtendedSurveyForm_TextMaxlength_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
                            </div>
                        </div>
                    
                    
                    <div class="span3" id="noofrowsdiv_<?php echo $widgetCount; ?>" style="display: none;">
                        <div class="pull-left positionrelative">
                            <label class="rr_widget">No.of Rows</label>
                            <select class="styled  snoofrows" data-error="ExtendedSurveyForm_NoofRows_<?php echo $widgetCount; ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_NoofRows_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm_NoofRows_<?php echo $widgetCount; ?>">
                                <option value="">Please select</option>

                                <?php for($i=1;$i<=30;$i++){ ?>

                                     <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                     <?php } ?>
                            </select>
                            <div class="control-group controlerror">
                                <div style="display:none"  id="ExtendedSurveyForm_NoofRows_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
                            </div>
                        </div>
                    </div>
                
                    
                    </div>
                </div>
                <div class="row-fluid" id="noofcolsdiv_<?php echo $widgetCount; ?>" style="display: none;">
                    <div class="span12">
                        <div class="span4" >                        
                        <div class="pull-left positionrelative">
                            <label class="rr_widget">No.of Columns</label>
                            <select class="styled  snoofcols" data-error="ExtendedSurveyForm_NoofCols_<?php echo $widgetCount; ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofRatings_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_NoofCols_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm_NoofCols_<?php echo $widgetCount; ?>">
                                <option value="">Please select</option>

                                <?php for($i=1;$i<=10;$i++){ ?>

                                     <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                     <?php } ?>
                            </select>
                            <div class="control-group controlerror">
                                <div style="display:none"  id="ExtendedSurveyForm_NoofCols_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                
                <div class="row-fluid" id="noofratingsdiv_<?php echo $widgetCount; ?>" style="display:none;">
                    <div class="span12">
                    <div class="span4" >
                        
                        <div class="pull-left positionrelative">
                            <label class="rr_widget">No.of Ratings</label>
                            <select class="styled  ssoofRatings" data-error="ExtendedSurveyForm_NoofRatings_<?php echo $widgetCount; ?>_em_" data-idname="ExtendedSurveyForm_NoofRatings_" data-hiddenname="ExtendedSurveyForm_NoofRatings_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_NoofRatings_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm_NoofRatings_<?php echo $widgetCount; ?>">
                                <option value="">Please select</option>

                                <?php for($i=1;$i<=10;$i++){ ?>
                                     <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                     <?php } ?>
                            </select>
                            <div class="control-group controlerror">
                                <div style="display:none"  id="ExtendedSurveyForm_NoofRatings_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                    
                   
                    
                

            <div class="paddingtop12 allothersrankratings" id="allothers_<?php echo $widgetCount; ?>" >
            <div id="rankingOrRating_<?php echo $widgetCount; ?>" class="rankratematrixwidgets">

            </div>
            <input type="hidden" name="ExtendedSurveyForm[AnyOther][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_AnyOther_hid_<?php echo $widgetCount; ?>" />
            <div class="anyothersarea padding8top anyothersarea_rrwidget" style="display: none;" id="anyothervaluediv_<?php echo $widgetCount; ?>">
                <input type="checkbox" class="styled" id="anyothervalue_<?php echo $widgetCount; ?>" name="1"  > <label>Other</label>
            </div>
            <div class="othersarea_rrwidget padding8top" style="display: none;" id="othervaluediv_<?php echo $widgetCount; ?>">
                <input type="checkbox" class="styled" id="othervalue_<?php echo $widgetCount; ?>" name="1"  ><label> N/A</label>
            </div>
        </div>
            </div>

        </div>        
        
    </div>
</div>  

<script type="text/javascript">
//    $("#surveyFormButtonId").hide();


//$("#noofratingsdiv_<?php //echo $widgetCount; ?>").hide();
$(document).ready(function() {
        Custom.init();
        $("[rel=tooltip]").tooltip();

    }); 

</script>