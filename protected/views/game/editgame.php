
<?php if(isset($gameDetails)){
    
     foreach ($gameDetails as $key => $value) {

   ?>      
   <script type="text/javascript">

    Custom.init();
    
    var id='<?php echo $QuestionId; ?>';
    
   initializeFileUploader('GameQuestionImage_'+id, '/game/UploadGameBannerImage', '10*1024*1024', Questionextensions,1, 'GameQuestionImage_'+id ,id,GameQuestionPreviewImage,displayErrorForBannerAndQuestion,"uploadlist_"+id);
    $('#editable_'+id).freshereditor({editable_selector: '#editable_'+id, excludes: ['removeFormat', 'insertheading4']});
    $('#editable_'+id).freshereditor("edit", true);
    $("#editor-toolbar-editable_"+id).addClass('editorbackground');
    $("#editor-toolbar-editable_"+id).show();
    $('#editable_'+id).css("min-height", "50px");
     $('#editable_'+id).removeClass("placeholder");
    $('#editable_'+id).click(function()
    {
        $('#editable_'+id).removeClass("Discemilarplaceholder");
        // $('#editable_'+id).focus();
    });
    
//        $('#editable_'+id).bind('paste', function (event) {
//      
// var $this = $(this); //save reference to element for use laster
// setTimeout(function(){ //break the callstack to let the event finish
//     var strippedText = strip_tags($this.html(),'<p><pre><span><i><b>');
//    
// $this.html(strippedText) ;
// $this.find('*').removeAttr('style');
// var result = $('#editable_'+id);
//    result.focus();
//    placeCaretAtEnd( document.getElementById("editable_"+id) );
//
//},0); 
//    });
    
    g_correctAnswer=g_correctAnswer+1;
    
    </script>  
<div class="panel panel-default section1">
    
     <div class="panel-heading">
      <h4 class="panel-title">
          
        <a data-toggle="collapse" name="collapsQuestionId"  id="collapse_<?php echo ($QuestionId); ?>" data-parent="#accordion" href="#collapse<?php echo ($QuestionId); ?>">
          Question  <?php echo ($QuestionId+1); ?>
        </a>
      </h4>
    </div>
        <div id="collapse<?php echo ($QuestionId); ?>" class="panel-collapse in collapse">
      <div class="panel-body">
<!--    <button  class="close plus minus pull-right gameactionsright"  onclick="closeNewQuestion('<?php echo ($QuestionId); ?>')" data-dismiss="alert" type="button"> <i class="fadelete">X</i> </button>-->
    <div class="row-fluid">
        <div class="span11" style="margin:auto;float:none">
<div class="row-fluid padding8top">
<div class="span12">
    <div class="span8">
         <label id="label_<?php echo ($QuestionId); ?>"  name="QuestionLabel" >Question  </label>
    </div>
    <div class="span4">
<!--        <div class="pull-right gameactionsright"><i class="fadelete">X</i></div>-->
        
    </div>
</div>
    <div class="row-fluid ">
  <div class="control-group controlerror" id="GameQuestion_<?php echo ($QuestionId); ?>" >
                    <input type="text" id="<?php echo (string)$value['QuestionId'];?>"  name="g_question" class="span12 textfield" value="<?php echo $value['Question']; ?>" maxlength="500"> 
               <div id="GameQuestion_<?php echo ($QuestionId); ?>_error" name="Question"  class="errorMessage marginbottom10 error"  style="display:none"></div>  
  </div>
            </div>             
        </div>
        <div class="row-fluid padding8top">
            <div class="span12">
                <label ><?php echo Yii::t('translation','Disclaimer'); ?></label>
               <div class="control-group controlerror">
                      <div id="editable_<?php echo $QuestionId; ?>" class="inputor editablediv"  contentEditable="true" ><?php echo $value['QuestionDisclaimer'] ?> </div>   
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
                                
                                    <input id="g_CorrectAnswer_1" class="styled " <?php if($value['CorrectAnswer']=='A'){ echo "checked";} ?> type="radio" disabled="disabled" name="g_CorrectAnswer_<?php echo $QuestionId; ?>" value="A">

                            </div>
                        </div>
                          <div class="marginleft110 marginleft50">
                              <label > <?php echo Yii::t('translation','Choice'); ?> 1</label>
                            <div class="control-group controlerror " id="GameQuestion_optionA_<?php echo $QuestionId; ?>">
                                 
                                <input type="text"   id="g_optionA_<?php echo $QuestionId; ?>"   name="g_optionA" class="span12 textfield"  value="<?php echo  htmlspecialchars(stripslashes($value['OptionA']));  ?>" maxlength="500" > 
                           <div id="GameQuestion_optionA_<?php echo $QuestionId; ?>_error" name="Choice-1"  class="errorMessage marginbottom10 error" style="display:none"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="positionabsolutediv  alignright positionabsolutedivradio">
                            <div class="control-group">
                                <input id="g_CorrectAnswer_1" class="styled "   type="radio"   <?php if($value['CorrectAnswer']=='B'){ echo "checked";} ?> name="g_CorrectAnswer_<?php echo $QuestionId; ?>" disabled="disabled" value="B">

                            </div>
                        </div>
                         <div class="marginleft110 marginleft50">
                              <label > <?php echo Yii::t('translation','Choice'); ?> 2</label>
                           <div class="control-group controlerror " id="GameQuestion_optionB_<?php echo $QuestionId; ?>">
                              
                                <input type="text"  id="g_optionB_<?php echo $QuestionId; ?>"  name="g_optionB" class="span12 " maxlength="500"  value="<?php echo htmlspecialchars(stripslashes($value['OptionB'])); ?>"  > 
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
                                <textarea class="span12 textfield" id="g_optionA_explanation"  name="g_optionA_explanation" cols=""  rows=""><?php echo $value['OptionADisclaimer']; ?></textarea>
                            </diV>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="marginleft110 marginleft50">
                            <div class="control-group">
                                <label > <?php echo Yii::t('translation','Choice'); ?> 2 <?php echo Yii::t('translation','Explanation'); ?></label>
                                <textarea class="span12 textfield" id="g_optionB_explanation"  name="g_optionB_explanation"  cols="" rows=""><?php echo $value['OptionBDisclaimer']; ?></textarea>
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
                                <input id="g_CorrectAnswer_1" class="styled disabled " type="radio"  <?php if($value['CorrectAnswer']=='C'){ echo "checked";} ?> name="g_CorrectAnswer_<?php echo $QuestionId; ?>"  disabled="disabled" value="C">

                            </div>
                        </div>
                         <div class="marginleft110 marginleft50">
                             <label > <?php echo Yii::t('translation','Choice'); ?> 3</label>
                             <div class=" " id="GameQuestion_optionC_<?php echo $QuestionId; ?>">
                                 
                                <input type="text"  id="g_optionC_<?php echo $QuestionId; ?>"  name="g_optionC" class="span12 textfield"  value="<?php echo  htmlspecialchars(stripslashes($value['OptionC'])); ?>" maxlength="500"> 
<!--                           <div id="GameQuestion_optionC_<?php echo $QuestionId; ?>_error" name="Choice-3" class="errorMessage marginbottom10 error"  style="display:none"></div>-->
                             </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                        <div class="positionabsolutediv  alignright positionabsolutedivradio positionabsolutedivradio44 radioalignment">
                            <div class="control-group">
                                <input id="g_CorrectAnswer_1" class="styled " type="radio"  <?php if($value['CorrectAnswer']=='D'){ echo "checked";} ?> name="g_CorrectAnswer_<?php echo $QuestionId; ?>"  disabled="disabled" value="D">

                            </div>
                        </div>
                         <div class="marginleft110 marginleft50">
                             <label > <?php echo Yii::t('translation','Choice'); ?> 4</label>
                             <div class="" id="GameQuestion_optionD_<?php echo $QuestionId; ?>">
                                 
                                <input type="text" id="g_optionD_<?php echo $QuestionId; ?>"  name="g_optionD"  class="span12 textfield"  value="<?php echo  htmlspecialchars(stripslashes($value['OptionD'])); ?>" maxlength="500"> 
<!--                            <div id="GameQuestion_optionD_<?php echo $QuestionId; ?>_error" name="Choice-4" class="errorMessage marginbottom10 error"  style="display:none"></div>-->
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
                                <textarea class="span12 textfield" id="g_optionC_explanation"  name="g_optionC_explanation" cols=""  rows=""><?php echo $value['OptionCDisclaimer']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="positionrelative ">
                       <div class="marginleft110 marginleft50">
                            <div class="control-group">
                                <label > <?php echo Yii::t('translation','Choice'); ?> 4 <?php echo Yii::t('translation','Explanation'); ?></label>
                                <textarea class="span12 textfield" id="g_optionD_explanation"  name="g_optionD_explanation"   cols="" rows=""><?php echo $value['OptionDDisclaimer']; ?></textarea>
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
                <div id='GameQuestionImage_<?php echo $QuestionId;?>' ></div>
                </div>
                <div class="span3">
                    <div id="QuestionPreviewdiv_<?php echo $QuestionId;?>" class="preview" style="<?php if($value['Resources']['ThumbNailImage']!=""){ echo "display:block;";}else{ echo "display:none;" ;  }?>" >

                        <img class="qpreview" id="QuestionPreview_<?php echo $QuestionId;?>" name="<?php echo $value['QuestionImage']; ?>"  src="<?php if($value['Resources']['Extension']=='mp4' || $value['Resources']['Extension']=='mp3'|| $value['Resources']['Extension']=='avi'){ echo '/images/system/video_img.png';}else{ echo $value['Resources']['ThumbNailImage']; } ?>"/>
                    </div>
                </div>
                <div class="control-group controlerror " >
                    <div id="GameQuestionImage_<?php echo $QuestionId; ?>_error"  class="errorMessage marginbottom10 error"  style="display:none"></div>

                </div>
                </div>
                <div ><ul class="qq-upload-list" id="uploadlist_<?php echo $QuestionId;?>"></ul></div>
                <div class="span6">
                    <div class="positionrelative ">
                <div class="marginleft110 marginleft50">
                    <div class="control-group">
                    <label><?php echo Yii::t('translation','Points'); ?></label>
                    <div class="control-group controlerror" id="GameQuestion_points_<?php echo $QuestionId; ?>">
                        <input type="text" readonly="true" id="g_points_<?php echo $QuestionId; ?>"  onkeypress="return isNumberKey(event)"  name="g_points" class="span4 textfield"  maxlength="2" value="<?php echo $value['Points']; ?>"  /> 
                    <div id="GameQuestion_points_<?php echo $QuestionId; ?>_error" name="Points" class="errorMessage marginbottom10 error"  style="display:none"></div>
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
     

<?php
$QuestionId=$QuestionId+1;
}
}
 ?>
<script type="text/javascript">

    $(document).ready(function(){
       //Custom.init();
       // $( ".draggable" ).sortable();
    });
   
        function restrictGameLength(){
        var gameNameText = $('#GameName').html();                 
        var mxlen = 10; 
  
        if(gameNameText.length> mxlen)  
         {
           return false;  
          }  
        else  
       {  
       return true;     
        }  

    }
//    $('.editablediv').bind('paste', function (event) {
//     
// var EditDivId=$(this).attr('id');
// var $this = $(this); //save reference to element for use laster
// setTimeout(function(){ //break the callstack to let the event finish
//     var strippedText = strip_tags($this.html(),'<p><pre><span><i><b>');
//   
// $this.html(strippedText) ;
// $this.find('*').removeAttr('style');
// var result = $('#'+EditDivId);
//    result.focus();
//    placeCaretAtEnd( document.getElementById(EditDivId) );
//
//},0); 
//    });
    </script>