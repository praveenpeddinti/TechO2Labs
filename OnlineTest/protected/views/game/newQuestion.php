
<div class="panel panel-default section1">
     <button  data-original-title="<?php echo Yii::t('translation','Delete'); ?>" rel="tooltip" data-placement="bottom" class="close plus minus pull-right gameactionsright"  onclick="closeNewQuestion('<?php echo ($QuestionId); ?>')" data-dismiss="alert" type="button"> <i class="fadelete">X</i> </button>
     <div class="panel-heading">
      <h4 class="panel-title">
          
        <a data-toggle="collapse" name="collapsQuestionId" class="questionClass" id="collapse_<?php echo ($QuestionId); ?>" data-parent="#accordion" href="#collapse<?php echo ($QuestionId+1); ?>">
          <?php echo Yii::t('translation','Question'); ?>  <?php echo ($QuestionId+1); ?>
        </a>
      </h4>
    </div>
        <div id="collapse<?php echo ($QuestionId+1); ?>" class="panel-collapse in collapse">
      <div class="panel-body">
<div class="">
   
    <div class="alert-error" style="display: none;" id="CorrectAnswer_<?php echo ($QuestionId); ?>"></div>
    <div class="alert-error" style="display: none;" id="UniqueOption_<?php echo ($QuestionId); ?>"></div>
   

    <div class="row-fluid">
        <div class="span11" style="margin:auto;float:none">
<div class="row-fluid padding8top">
<div class="span12">
    <div class="span8">
         <label id="label_<?php echo ($QuestionId); ?>"  name="QuestionLabel" ><?php echo Yii::t('translation','Question'); ?>   </label>
    </div>
    <div class="span4">
<!--        <div class="pull-right gameactionsright"><i class="fadelete">X</i></div>-->
<!--        <button  class="close plus minus" data-dismiss="alert" type="button"> - </button>-->
    </div>
</div>
    <div class="row-fluid ">
 <div class="control-group controlerror" id="GameQuestion_<?php echo ($QuestionId); ?>" >
                    <input type="text" id="GameQuestion_<?php echo ($QuestionId); ?>"  name="g_question"   class="span12 textfield " value="" maxlength="500"> 
                   <div id="GameQuestion_<?php echo ($QuestionId); ?>_error" name="Question"  class="errorMessage marginbottom10 error"  style="display:none"></div>
                </div>
            </div>             
        </div>
        <div class="row-fluid padding8top">
            <div class="span12">
                <label ><?php echo Yii::t('translation','Disclaimer'); ?></label>
                <div class="control-group controlerror">
                      <div id="editable_<?php echo $QuestionId; ?>"  class=" inputor editablediv"  contentEditable="true" > </div>   
                <div id="GameQuestion_editable_<?php echo $QuestionId; ?>" name="Question"  class="errorMessage marginbottom10 error"  style="display:none"></div>
                </div>
            </div>             
        </div>

        <div class="row-fluid padding8top">
            <div class="span12">
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="positionabsolutediv ">
                            <label > <?php echo Yii::t('translation','Correct_Answer'); ?></label>
                        </div>
                        <div class="marginleft110">&nbsp;</div>
                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="positionabsolutediv ">
                            <label > <?php echo Yii::t('translation','Correct_Answer'); ?></label>
                        </div>
                        <div class="marginleft110">&nbsp;</div>
                    </div>
                </div>
            </div>             
        </div>
        <div class="row-fluid padding8top">
            <div class="span12">
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="positionabsolutediv  alignright positionabsolutedivradio positionabsolutedivradio44 radioalignment">
                            <div class="control-group">
                                
                                    <input id="g_CorrectAnswer_1" class="styled " type="radio" name="g_CorrectAnswer_<?php echo $QuestionId; ?>" value="A">

                            </div>
                        </div>
                          <div class="marginleft110 marginleft50">
                              <label > <?php echo Yii::t('translation','Choice'); ?> 1</label>
                             <div class="control-group controlerror " id="GameQuestion_optionA_<?php echo $QuestionId; ?>">
                                 
                                <input type="text"   id="g_optionA__<?php echo $QuestionId; ?>"   name="g_optionA" class="span12 textfield" maxlength="500" > 
                                <div id="GameQuestion_optionA_<?php echo $QuestionId; ?>_error" name="Choice-1"  class="errorMessage marginbottom10 error" style="display:none"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="positionabsolutediv  alignright positionabsolutedivradio">
                            <div class="control-group">
                                <input id="g_CorrectAnswer_1" class="styled " type="radio" name="g_CorrectAnswer_<?php echo $QuestionId; ?>" value="B">

                            </div>
                        </div>
                        <div class="marginleft110 marginleft50">
                            <label > <?php echo Yii::t('translation','Choice'); ?> 2</label>
                           <div class="control-group controlerror " id="GameQuestion_optionB_<?php echo $QuestionId; ?>">
                                 
                                <input type="text"  id="g_optionB__<?php echo $QuestionId; ?>"  name="g_optionB" class="span12 textfield" maxlength="500" > 
                                <div id="GameQuestion_optionB_<?php echo $QuestionId; ?>_error" name="Choice-2" class="errorMessage marginbottom10 error"  style="display:none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>             
        </div>
        <div class="row-fluid padding8top">
            <div class="span12">
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="marginleft110 marginleft50">
                            <div class="control-group">
                                 <label > <?php echo Yii::t('translation','Choice'); ?> 1 <?php echo Yii::t('translation','Explanation'); ?></label>
                                <textarea class="span12 textfield" id="g_optionA_explanation"  name="g_optionA_explanation" cols=""   rows=""></textarea>
                            </diV>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                       <div class="marginleft110 marginleft50">
                            <div class="control-group">
                                 <label > <?php echo Yii::t('translation','Choice'); ?> 2 <?php echo Yii::t('translation','Explanation'); ?></label>
                                <textarea class="span12 textfield" id="g_optionB_explanation"  name="g_optionB_explanation"  cols="" rows=""></textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>             
        </div>
        <div class="dottedsplitter"><img src="/images/system/spacer.png"/></div>
        <div class="row-fluid padding8top">
            <div class="span12">
                <div class="span6">
                    <div class="positionrelative ">
                         <div class="positionabsolutediv  alignright positionabsolutedivradio positionabsolutedivradio44 radioalignment">
                            <div class="control-group">
                                <input id="g_CorrectAnswer_1" class="styled " type="radio" name="g_CorrectAnswer_<?php echo $QuestionId; ?>" value="C">

                            </div>
                        </div>
                        <div class="marginleft110 marginleft50">
                             <label > <?php echo Yii::t('translation','Choice'); ?> 3</label>
                            <div class="" id="GameQuestion_optionC_<?php echo $QuestionId; ?>">
                                
                                <input type="text"  id="g_optionC__<?php echo $QuestionId; ?>"  name="g_optionC" class="span12 textfield" maxlength="500" > 
<!--                                <div id="GameQuestion_optionC_<?php echo $QuestionId; ?>_error" name="Choice-3" class="errorMessage marginbottom10 error"  style="display:none"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="positionabsolutediv  alignright positionabsolutedivradio positionabsolutedivradio44 radioalignment">
                            <div class="control-group">
                                <input id="g_CorrectAnswer_1" class="styled " type="radio" name="g_CorrectAnswer_<?php echo $QuestionId; ?>" value="D">

                            </div>
                        </div>
                         <div class="marginleft110 marginleft50">
                             <label > <?php echo Yii::t('translation','Choice'); ?> 4</label>
                            <div class=" " id="GameQuestion_optionD_<?php echo $QuestionId; ?>">
                                 
                                <input type="text" id="g_optionD__<?php echo $QuestionId; ?>"  name="g_optionD"  class="span12 textfield" maxlength="500" > 
<!--                                <div id="GameQuestion_optionD_<?php echo $QuestionId; ?>_error" name="Choice-4" class="errorMessage marginbottom10 error"  style="display:none"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>             
        </div>
        <div class="row-fluid padding8top">
            <div class="span12">
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="marginleft110 marginleft50">
                            <div class="control-group">
                                 <label > <?php echo Yii::t('translation','Choice'); ?> 3 <?php echo Yii::t('translation','Explanation'); ?></label>
                                <textarea class="span12 textfield" id="g_optionC_explanation"  name="g_optionC_explanation" cols=""  rows=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="marginleft110 marginleft50">
                            <div class="control-group">
                                 <label > <?php echo Yii::t('translation','Choice'); ?> 4 <?php echo Yii::t('translation','Explanation'); ?></label>
                                <textarea class="span12 textfield" id="g_optionD_explanation"  name="g_optionD_explanation"   cols="" rows=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>             
        </div>

        
        <div class="row-fluid padding8top">
            <div class="span12">
                <div class="span6">
                    <div class="span2">
                        <label><?php echo Yii::t('translation','Upload_Image_OR_Video'); ?></label>
                        <div id='GameQuestionImage_' ></div>
                    </div>
                    <div class="span3">
                        <div id="QuestionPreviewdiv_" class="preview" style="display:none;" >

                            <img class="qpreview" id="QuestionPreview_" name=""  src=""/>
                        </div>
                    </div>
                    <div ><ul class="qq-upload-list" id="uploadlist_"></ul></div>
                    <div class="control-group controlerror " >
                        <div id="GameQuestionImage_<?php echo $QuestionId; ?>_error"  class="errorMessage marginbottom10 error"  style="display:none"></div>

                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                <div class="marginleft110 marginleft50">
                    <div class="control-group">
                    <label><?php echo Yii::t('translation','Points'); ?></label>
                    <div class="control-group controlerror" id="GameQuestion_points_<?php echo $QuestionId; ?>">
                        <input type="text" id="g_points__<?php echo $QuestionId; ?>"  onkeypress="return isNumberKey(event)" name="g_points" class="span4 textfield" maxlength="2" /> 
                        <div id="GameQuestion_points_<?php echo $QuestionId; ?>_error" name="Points" class="errorMessage marginbottom10 error"  style="display:none"></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>    
        </div>
   <div class="row-fluid padding8top">
<div class="span12">

</div>
</div>
<!--          <span class="radio" style="background-position: 0px -50px;"></span>
<input id="UserRegistrationForm_isPharmacist_1" class="styled" type="radio" name="UserRegistrationForm[isPharmacist]" value="0">-->
<!--<label for="UserRegistrationForm_isPharmacist_1">No</label>  -->
            
            
            
        </div>
      </div>
    </div>
    </div>
</div>
<script type="text/javascript">
 Custom.init();    
    var id='<?php echo $QuestionId; ?>';
  
    $('#editable_'+id).freshereditor({editable_selector: '#editable_'+id, excludes: ['removeFormat', 'insertheading4']});
    $('#editable_'+id).freshereditor("edit", true);
    $("#editor-toolbar-editable_"+id).addClass('editorbackground');
    $("#editor-toolbar-editable_"+id).show();
    $('#editable_'+id).css("min-height", "50px");
    $('#editable_'+id).click(function()
    {
        $(this).removeClass("Discemilarplaceholder");
        $(this).focus();
    });
        $('.editablediv').bind('paste', function (event) {
     
 var EditDivId=$(this).attr('id');
 var $this = $(this); //save reference to element for use laster
 setTimeout(function(){ //break the callstack to let the event finish
     var strippedText = strip_tags($this.html(),'<p><pre><span><i><b>');
   strippedText=strippedText.replace(/\s+/g, ' ');
 $this.html(strippedText) ;
 $this.find('*').removeAttr('style');
 var result = $('#'+EditDivId);
    result.focus();
    placeCaretAtEnd( document.getElementById(EditDivId) );

},0); 
    }); 

    </script>