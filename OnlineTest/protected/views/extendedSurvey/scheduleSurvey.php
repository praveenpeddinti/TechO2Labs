<div class="alert alert-error" id="errmsgForSurveySchedule" style='display: none'></div>
<div class="alert alert-success" id="sucmsgForSurveySchedule" style='display: none'></div> 
<div class="padding10">    
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'schedulesurvey-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'style' => 'margin: 0px; accept-charset=UTF-8',
        ),
    ));
    ?>
    <?php echo $form->hiddenField($scheduleForm, 'SurveyId'); ?>
    <?php echo $form->hiddenField($scheduleForm, 'ThankYouArtifact'); ?>  
    <?php echo $form->hiddenField($scheduleForm, 'InstreamAdArtifact'); ?> 
    <?php echo $form->hiddenField($scheduleForm, 'SurveyTitle',array("value"=>$surveyObj->SurveyTitle)); ?>      
    <?php echo $form->hiddenField($scheduleForm, 'QuestionView'); ?>
    <?php echo $form->hiddenField($scheduleForm, 'SurveyRelatedGroupName'); ?>
    <?php echo $form->hiddenField($scheduleForm, 'SurveyDescription'); ?>
    
    <div id="surveyScheduleSpinner"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="span4">
                <div style="padding-right: 16px" id="dpd1" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                    <label><?php echo Yii::t('translation', 'EventPost_Start_lable'); ?></label>
                    <?php echo $form->textField($scheduleForm, 'StartDate', array('maxlength' => '20', 'class' => 'textfield span11 ', 'readonly' => "true")); ?>    
                    <span class="add-on">
                        <i class="fa fa-calendar"></i>
                    </span>

                    <div class="control-group controlerror"> 
                        <?php echo $form->error($scheduleForm, 'StartDate'); ?>
                    </div>

                </div>
            </div>
            <div class="span4">
                <div id="dpd2" style="padding-right: 16px" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                    <label><?php echo Yii::t('translation', 'EventPost_Enddate_lable'); ?></label>
                    <?php echo $form->textField($scheduleForm, 'EndDate', array('maxlength' => '20', 'class' => 'textfield span11', 'readonly' => "true")); ?>    
                    <span class="add-on">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($scheduleForm, 'EndDate'); ?>
                    </div>

                </div>

            </div>
            <div class="span4">
                <label>Questions</label>
                <div class="positionrelative">
                    <select id="questionview" name="questionview"  class="styled">
                    <option value=""><?php echo Yii::t('translation', 'Questionsview_label'); ?></option>
                    <option value="0">All at once</option>
                    <?php for($i=1;$i<6;$i++){ ?>
                    <option value="<?php echo $i; ?>">At a time <?php echo $i; ?> Question<?php if($i > 1) echo "s"; ?></option>
                    <?php } ?>
                    </select>
                    <div class="control-group controlerror">
                        <?php echo $form->error($scheduleForm, 'QuestionView'); ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="row-fluid"  id="">
        <div class="span12 ">
           
            
 <div class="span6 radiobutton" id="maxSpots">
                 <?php echo $form->checkBox($scheduleForm, 'SelectMaxSpot', array('class' => 'styled')) ?>
                <label >Max Spots</label>
                <input type="file" id="fileupload" style="display: none;">
                        <div class="control-group controlerror">
                            <?php echo $form->error($scheduleForm, 'SelectMaxSpot'); ?>
                        </div>
                
            </div>

        </div>


    </div>
    <div class="row-fluid" style="display: none;" id="maxSpotInput">
        <div class="span12 ">
            <div class="span6">  
                  <?php echo $form->textField($scheduleForm, 'MaxSpots', array('maxlength' => '5', 'class' => 'textfield span11',"placeholder"=>"Max Spots")); ?>                    
                        <div class="control-group controlerror">
                            <?php echo $form->error($scheduleForm, 'MaxSpots'); ?>
                        </div>
            </div>
 

        </div>


    </div>
   <div class="row-fluid"  id="">
        <div class="span12 ">
            <div class="span6 radiobutton " id="showthankyoucheckboxid">  
                <?php echo $form->checkBox($scheduleForm, 'ShowThankYou', array('class' => 'styled')) ?>
                <label>Show Thank You Message</label>
                        <div class="control-group controlerror">
                            <?php echo $form->error($scheduleForm, 'ShowThankYou'); ?>
                        </div>
            </div>
            
 <div class="span6 radiobutton" id="renewscheduledivid">
                 <?php echo $form->checkBox($scheduleForm, 'ConvertInStreamAdd', array('class' => 'styled')) ?>
                <label >Convert into In-Stream Ad</label>
                <input type="file" id="fileupload" style="display: none;">
                        <div class="control-group controlerror">
                            <?php echo $form->error($scheduleForm, 'ConvertInStreamAdd'); ?>
                        </div>
                
            </div>

        </div>


    </div>
        
    <div class="row-fluid padding-bottom10" id="thankyoumessagediv" style="display: none;">
        <div class="span12">

            <?php //echo $form->labelEx($scheduleForm, Yii::t('translation', 'ThankYouMessage')); ?>
            <?php echo $form->textField($scheduleForm, 'ThankYouMessage', array("placeholder" => Yii::t('translation', ''), 'maxlength' => 500, 'class' => 'span12 textfield',"placeholder"=>Yii::t('translation', 'ThankYouMessage'))); ?> 
            <div class="control-group controlerror">
                <?php echo $form->error($scheduleForm, 'ThankYouMessage'); ?>
            </div>
        </div>
    </div>
      
    
    <div class="alert alert-error" id="SurveyLogoError" style="display: none"></div>
    <div id="updateAndCancelGroupIconUploadButtons" style="display: none">
    </div>
    <div class="row-fluid">
        <div class="span6" id="surveylogodivid" >
            <div id="SurveyLogo" class="uploadicon " style="display: none;"></div>
            <img id="SurveyLogoimg" style="display: none;" class=""  src="/images/system/spacer.png">
        </div>   
        
         <ul class="qq-upload-list" id="uploadlistSchedule"></ul>       
        <div class="span6" id="instreamadlogodivid" style="display: none;">
            <div id="instreamAdLogo" class="uploadicon"></div>
            <img id="instreamAdLogoimg"  src="/images/system/spacer.png">
            <div class="control-group controlerror"> 
                <?php echo $form->error($scheduleForm, 'InstreamAdArtifact'); ?>
            </div>
        </div>
        <ul class="qq-upload-list" id="uploadlistSchedule_instream"></ul>
        
    </div>
    <div class="padding8top" style="padding-bottom: 0">        
        <div class="groupcreationbuttonstyle">
            <div class="row-fluid">
                
                <div class="span12 alignright"> <?php
//        echo CHtml::ajaxSubmitButton('Schedule', array('game/saveScheduleGame'), array(
//            'type' => 'POST',
//            'dataType' => 'json',
//            'error' => 'function(error){
//                                        }',
//            'beforeSend' => 'function(){                                                   
//                                scrollPleaseWait("gameScheduleSpinner","schedulegame-form");}',
//            'complete' => 'function(){
//                                                    }',
//            'success' => 'function(data,status,xhr) { gameScheduleHandler(data,status,xhr);}'), array('type' => 'submit', 'id' => 'newGameId', 'class' => 'btn')
//        );
        ?>
                    <?php 
                         echo CHtml::button('Schedule',array("id"=>"scheduleSurvey",'class' => 'btn')); 
                          echo "&nbsp;";
                         echo CHtml::resetButton('Cancel', array("id" => 'ScheduleSurveyReset', 'class' => 'btn btn_gray'," data-dismiss"=>"modal")); ?>
                </div>
            </div>



        </div>
    </div>
    <?php $this->endWidget(); ?>

</div>
<script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        Custom.init();
        loadEvents();
    });
    $("#renewscheduledivid span.checkbox").die().live("click",function(){
       
       if ($('#ScheduleSurveyForm_ConvertInStreamAdd').is(':checked')) {
           if($("#instreamAdLogoimg").attr("src") != "/images/system/spacer.png"){                        
                $("#instreamAdLogoimg").attr("style","width:120px;");
            }
           $("#instreamadlogodivid").show();
       }else{
           if($("#instreamAdLogoimg").attr("src") != "/images/system/spacer.png"){                        
                $("#instreamAdLogoimg").attr("style","width:120px;");
            }else{
                $("#instreamAdLogoimg").removeAttr("style");
            }
           $("#instreamadlogodivid").hide();
           $('#ScheduleSurveyForm_InstreamAdArtifact').val("");
       }
    });
     $("#maxSpots span.checkbox").die().live("click",function(){
       
       if ($('#ScheduleSurveyForm_SelectMaxSpot').is(':checked')) {
           $("#maxSpotInput").show();
       }else{
           $("#maxSpotInput").hide();
           $('#ScheduleSurveyForm_InstreamAdArtifact').val("");
       }
    });
//    $("#fileupload").change(function(e){
//       alert(e.toSource()) 
//    });
    $("#showthankyoucheckboxid span.checkbox").live("click",function() {
                var isChecked = 0;
                if ($('#ScheduleSurveyForm_ShowThankYou').is(':checked')) {
                    isChecked = 1;
                    if($("#SurveyLogoimg").attr("src") != "/images/system/spacer.png"){                        
                        $("#SurveyLogoimg").attr("style","width:120px;");
                    }
                    $("#thankyoumessagediv,#SurveyLogo").show();
                }else{
                    if($("#SurveyLogoimg").attr("src") != "/images/system/spacer.png"){                        
                        $("#SurveyLogoimg").attr("style","width:120px;");
                    }else{
                        $("#SurveyLogoimg").removeAttr("style");
                    }
                    $("#thankyoumessagediv,#SurveyLogoimg,#SurveyLogo").hide();
                }
            });
    
<?php if (Yii::app()->session['IsAdmin'] == 1) { ?>
        var extensions = '"jpg","jpeg","gif","png","tiff","tif","TIF"';
       initializeFileUploader('SurveyLogo', '/extendedSurvey/uploadThankYouImage', '10*1024*1024', extensions,1, 'SurveyLogo' ,'',SurveyDLPreviewImage,displayErrorForBannerAndLogo,"uploadlistSchedule");
       initializeFileUploader('instreamAdLogo', '/extendedSurvey/uploadThankYouImage', '10*1024*1024', extensions,1, 'instreamAdLogo' ,'',InstreamAdDLPreviewImage,displayErrorForBannerAndLogo,"uploadlistSchedule_instream");
       
<?php } ?>
    function loadEvents() {
        
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var checkin = $('#dpd1').datepicker({
            onRender: function(date) { 
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            if ((ev.date.valueOf() > checkout.date.valueOf()) || checkout.date.valueOf() != "") {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 0);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('#dpd2')[0].focus();
        }).data('datepicker');

        var checkout = $('#dpd2').datepicker({
            onRender: function(date) {
                return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');

    }
    $("#questionview").change(function(){
       var $this = $(this);
       $("#ScheduleSurveyForm_QuestionView").val($this.val());
    });
    $("#scheduleSurvey").click(function(){
        var data = $("#schedulesurvey-form").serialize();        
        scrollPleaseWait("surveyScheduleSpinner");
        $("#scheduleSurvey").attr("disabled",true);
        $.ajax({
            type: 'POST',
            url: '/extendedSurvey/scheduleASurvey',
            data: data,
            success: scheduleSurveyHandler,
            error: function(data) { // if error occured
                // alert("Error occured.please try again==="+data.toSource());
                // alert(data.toSource());
            },
            dataType: 'json'
        });
    });
    
    function scheduleSurveyHandler(data){
        scrollPleaseWaitClose("surveyScheduleSpinner");
        data = eval(data);          
        if (data.status == 'success') {
            var msg = data.data;           
            var surveyId = data.surveyId;           
            $("#sucmsgForSurveySchedule").html(msg);
            $("#sucmsgForSurveySchedule").show();
            $("#sucmsgForSurveySchedule").fadeOut(4000,function(){
                $("#newModal").modal('hide');
                $("#scheduleSurvey").removeAttr("disabled");
                 page = 1;
                 isDuringAjax=false;
                  $('#surveyDashboardWall').empty();
               getCollectionData('/extendedSurvey/LoadSurveyWall', 'ExtendedSurveyBean', 'surveyDashboardWall', 'No data found', 'No more data ');
            });
        } else if(data.status == 'Exists'){   
            $("#scheduleSurvey").removeAttr("disabled");
            $("#errmsgForSurveySchedule").html(data.data);
            $("#errmsgForSurveySchedule").show();
            $("#sucmsgForSurveySchedule").hide();
            $("#errmsgForSurveySchedule").fadeOut(4000);
        } else {
            $("#scheduleSurvey").removeAttr("disabled");
            scrollPleaseWaitClose("extededsurvey_spinner");
            var lengthvalue = data.error.length;            
            var error = [];
            if (typeof (data.error) == 'string') {

                var error = eval("(" + data.error.toString() + ")");

            } else {
                var error = eval(data.error);
            }
            $.each(error, function(key, val) {                
                    if ($("#" + key + "_em_")) {
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(6000);
                        $("#" + key).parent().addClass('error');
                    }
            });
        }
    }
    function SurveyDLPreviewImage(id, fileName, responseJSON, type)
    {
        var data = eval(responseJSON);
        var ThankyouIconPath = '/upload/ExSurvey/Thankyou/' + data.savedfilename;
        $('#SurveyLogoimg').attr('src', ThankyouIconPath);
        $('#ScheduleSurveyForm_ThankYouArtifact').val(ThankyouIconPath);
        $("#ScheduleSurveyReset").removeClass("btn-gray");
        $("#SurveyLogoimg").attr("style","width:120px;");
        $("#ScheduleSurveyReset").addClass("btn-gray");
    }
    function displayErrorForBannerAndLogo(message,type){
        if(type=='SurveyLogo'){
           $('#SurveyLogoError').html(message);
           $('#SurveyLogoError').css("padding-top:20px;");
           $('#SurveyLogoError').show();
           $('#SurveyLogoError').fadeOut(5000)
        }
    }
    
    function InstreamAdDLPreviewImage(id, fileName, responseJSON, type)
    {
        var data = eval(responseJSON);
        var ThankyouIconPath = '/upload/ExSurvey/Thankyou/' + data.savedfilename;
        $('#instreamAdLogoimg').attr('src', ThankyouIconPath);
        $('#instreamAdLogoimg').attr("style","width:120px;");
        $('#ScheduleSurveyForm_InstreamAdArtifact').val(ThankyouIconPath);
        $("#ScheduleSurveyReset").removeClass("btn-gray");
        $("#ScheduleSurveyReset").addClass("btn-gray");
    }
</script>
