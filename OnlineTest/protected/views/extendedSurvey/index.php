<div class="alert alert-success" id="sucmsg" style='text-align:center;display:none;'></div>
<div class="padding10ltb">
    <div class="row-fluid groupseperator headermarginzero" id="dashboardtop">
    <div class="span12 paddingtop10 border-bottom">
        <div class="span12"><h2 class="pagetitle" >Question Bank</h2></div>
      
    </div>
  
</div>
    
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'questionWidget',
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
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'SurveyId'); ?>
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'Questions'); ?>
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'SurveyLogo',array("value"=>"/images/system/survey_img.png")); ?>
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'SurveyRelatedGroupName', array("value"=>"Public")); ?>
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'Status'); ?>
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'IsBannerVisible',array("value"=>"0")); ?>
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'IsAnalyticsShown',array("value"=>"0")); ?>  
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'IsAcceptUserInfo',array("value"=>0)); ?> 
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'ShowDerivative',array("value"=>0)); ?> 
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'IsEnableNotification',array("value"=>0)); ?>
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'IsBranded',array("value"=>"0")); ?>
    <?php echo $form->hiddenField($ExtendedSurveyForm, 'BrandLogo',array("value"=>"/images/system/survey_img.png")); ?>
    
    

    <div class="market_profile marginT10" id="survey_profilediv">
        
        <div class="questionmainpaddingtop">

        <div class="row-fluid padding-bottom15">
            <div class="span12">
                <?php 
                $isEditable = false;
                if(!empty($surveyId)){
                    $isEditable = true;
                }
                echo $form->textField($ExtendedSurveyForm, 'SurveyTitle', array('maxlength' => '100', 'class' => 'span6 textfield  notallowed', "placeholder" => "Title" , "readonly" => $isEditable)); ?>    
                <div class="control-group controlerror"> 
                    <?php echo $form->error($ExtendedSurveyForm, 'SurveyTitle'); ?>
                </div>


            </div>
        </div>
       
        <div class="row-fluid">
            <div class="span12">
                <?php echo $form->textArea($ExtendedSurveyForm, 'SurveyDescription', array('maxlength' => '500', 'class' => 'survey_profiletitleedit span8 notallowed_desc', "contenteditable" => "true", "placeholder" => "Description","onkeypress"=>"IsAlphaNumeric(this.id)","onblur"=>"IsAlphaNumeric(this.id)","max-height" => "200px")); ?>    

                <div class="control-group controlerror"> 
                    <?php echo $form->error($ExtendedSurveyForm, 'SurveyDescription'); ?>
                </div>
            </div>
        </div>
         <div class="row-fluid groupseperator border-bottom">
        
        <div class="span10 "><h2 class="pagetitle">Create Questions </h2></div>
               
        
    </div> 
</div>

    </div>
    
  
    <div id="surveySpinLoader" style="position:relative;"></div>
    <div class="questionmainpadding">
    <div id="extendedSurveyWidgets" class="mainclass">
        
    </div>   
    <div class="row-fluid " style="position: relative">            
            <div class="headeraddbuttonarea pull-right" id="newQuestion">
                <img src="/images/system/spacer.png" class="surveyaddbutton" data-placement="top" rel="tooltip"  data-original-title="Add one more question"/>
            </div>
    </div> 
    <div class="row-fluid" id="surveyfooterids" style="display: none;">
        <div id="extededsurvey_spinner" style="position: relative"></div>
        <div class="alignright padding10 bggrey">
            <?php echo CHtml::Button('Done', array('onclick' => 'saveSurveyForm();', 'class' => 'btn', 'id' => 'surveyFormButtonId')); ?> 

            <?php echo CHtml::resetButton('Cancel', array("id" => 'surveyResetId', 'onclick' => 'CancelSurveyForm();', 'class' => 'btn btn_gray')); ?>
        </div>
    </div>
        </div>
    <?php $this->endWidget(); ?>
    
</div>

<script>
$(document).ready(function(){
$('#ExtendedSurveyForm_SurveyDescription').focusin(function(){
   $(this).attr("style","height:150px;")
}).focusout(function(){
    $(this).attr("style","")
});
$("#surveyfooterids").show();
	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
//	$(function () {
//		$(window).scroll(function () {
//			if ($(this).scrollTop() > 150) {
//				$('#back-top').fadeIn();
//			} else {
//				$('#back-top').fadeOut();
//			}
//		});
//
//		// scroll body to 0px on click
//		$('#back-top a').click(function () {
//			$('body,html').animate({
//				scrollTop: 0
//			}, 800);
//			return false;
//		});
//	});
bindToMandatory();
});
</script>
<?php if(empty($surveyId)){ ?>

<?php } ?>
<script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.min.js"></script>
<script type="text/javascript">
   $('#surveyBannerSettings,#analyticsviewcheckboxSettings,#IsCaptureUserInfo,#exNotification,#ShowDerivativecheckboxSettings,#isbranded').bootstrapSwitch();

         $('#surveyBannerSettings').on('switch-change', function(e, data) {           
               var switchedValue = data.value ? 1 : 0;               
               if (switchedValue == 1) {
                   $("#ExtendedSurveyForm_IsBannerVisible").val(0);
                   $('label[for=surveyBannerSettings]').text("On");
               } else {
                   $("#ExtendedSurveyForm_IsBannerVisible").val(1);
                   $('label[for=surveyBannerSettings]').text('Off');
               }
               var scrollTp = $(window).scrollTop();
                scrollTp = Number(scrollTp);                
                $("#surveyviewspinner").css("top",scrollTp);                
                
         });
         $('#analyticsviewcheckboxSettings').on('switch-change', function(e, data) {           
               var switchedValue = data.value ? 1 : 0;               
               if (switchedValue == 1) {
                   $("#ExtendedSurveyForm_IsAnalyticsShown").val(0);
                   $('label[for=analyticsviewcheckboxSettings]').text("On");
               } else {
                   $("#ExtendedSurveyForm_IsAnalyticsShown").val(1);
                   $('label[for=analyticsviewcheckboxSettings]').text('Off');
               }
               var scrollTp = $(window).scrollTop();
                scrollTp = Number(scrollTp);                
                $("#surveyviewspinner").css("top",scrollTp);                
                
         });         
         $('#IsCaptureUserInfo').on('switch-change', function(e, data) {           
               var switchedValue = data.value ? 1 : 0;               
               if (switchedValue == 1) {
                   $("#ExtendedSurveyForm_IsAcceptUserInfo").val(0);
                   $('label[for=IsCaptureUserInfo]').text("On");
               } else {
                   $("#ExtendedSurveyForm_IsAcceptUserInfo").val(1);
                   $('label[for=IsCaptureUserInfo]').text('Off');
               }
               var scrollTp = $(window).scrollTop();
                scrollTp = Number(scrollTp);                
                $("#surveyviewspinner").css("top",scrollTp);                
                
         });

         $('#exNotification').on('switch-change', function(e, data) {           
               var switchedValue = data.value ? 1 : 0;               
               if (switchedValue == 1) {
                   $("#ExtendedSurveyForm_IsEnableNotification").val(0);
                   $('label[for=exNotification]').text("On");
               } else {
                   $("#ExtendedSurveyForm_IsEnableNotification").val(1);
                   $('label[for=exNotification]').text('Off');
               }
               var scrollTp = $(window).scrollTop();
                scrollTp = Number(scrollTp);                
                $("#surveyviewspinner").css("top",scrollTp);                
                
         });

         $('#ShowDerivativecheckboxSettings').on('switch-change', function(e, data) {           
               var switchedValue = data.value ? 1 : 0;               
               if (switchedValue == 1) {
                   $("#ExtendedSurveyForm_ShowDerivative").val(0);
                   $('label[for=ShowDerivativecheckboxSettings]').text("On");
               } else {
                   $("#ExtendedSurveyForm_ShowDerivative").val(1);
                   $('label[for=ShowDerivativecheckboxSettings]').text('Off');
               }
               var scrollTp = $(window).scrollTop();
                scrollTp = Number(scrollTp);                
                $("#surveyviewspinner").css("top",scrollTp);                
                
         });
         
         $('#isbranded').on('switch-change', function(e, data) {           
               var switchedValue = data.value ? 1 : 0;   
               //alert(switchedValue)
               if (switchedValue == 1) {
                   $("#ExtendedSurveyForm_IsBranded").val(0);
                   $('label[for=isbranded]').text("On");
                   $("#brandrelateddiv").hide();
//                   $("#ExtendedSurveyForm_BrandName").val("");
//                   $("#ExtendedSurveyForm_BrandLogo").val("/images/system/survey_img.png");
               } else {
                   $("#ExtendedSurveyForm_IsBranded").val(1);
                   $('label[for=isbranded]').text('Off');
                   $("#brandrelateddiv").show();
               }               
               var scrollTp = $(window).scrollTop();
                scrollTp = Number(scrollTp);                
                $("#surveyviewspinner").css("top",scrollTp);                
                
         });
         

    var isValidate = 0;
    var isValidated = false;    
    var questionsCount = 1; 
    var timeOut = 200;
    <?php if(!empty($surveyId)){  ?>
        questionsCount = '<?php echo $surveyObj->QuestionsCount;?>';
        <?php if($isAlreadySchedule == 1){ ?>
        //$("#newQuestion").hide();  
        <?php } ?>
        $("#ExtendedSurveyForm_SurveyRelatedGroupName").val('<?php echo $surveyObj->SurveyRelatedGroupName; ?>');
        
       $("#surveyPreviewId").attr("src","<?php echo $logo ?>");
       
           <?php if($surveyObj->IsBranded == 1){ ?>
                $("#brandimagelogodiv").show();
                $("#ExtendedSurveyForm_BrandLogo").val("<?php echo $surveyObj->BrandLogo; ?>");
                $("#brandPreview").attr("src","<?php echo $surveyObj->BrandLogo; ?>");
           <?php } ?>
        
       ajaxRequest("/extendedSurvey/renderEditForm", "surveyId=<?php echo $surveyId; ?>", function(data)
       { var str = '<div class="row-fluid">'+
            '<div class="span12" style="text-align:center;font-family:\'exo_2.0medium\'">'+
                '<h3>Sorry, No data found.</h3>'+
            '</div>'+
        '</div>';
       if(data != 0) $("#extendedSurveyWidgets").html(data); else { $("#extendedSurveyWidgets").html(str);$("#surveyfooterids,#survey_profilediv,#pagetitle_s").hide()}
    }, "html");
    
    <?php if($surveyObj->IsBannerVisible == 1){  ?>
        $('#surveyBannerSettings').bootstrapSwitch('setState', false);
        $('label[for=surveyBannerSettings]').text("Off");
       
    <?php }else{ ?>
        $('#surveyBannerSettings').bootstrapSwitch('setState', true);
        $('label[for=surveyBannerSettings]').text("On");
        
    <?php } ?>
               
        <?php if($surveyObj->IsAnalyticsShown == 1){  ?>
        $('#analyticsviewcheckboxSettings').bootstrapSwitch('setState', false);
         $('label[for=analyticsviewcheckboxSettings]').text("Off");
       
    <?php }else{ ?>
        $('#analyticsviewcheckboxSettings').bootstrapSwitch('setState', true);
        $('label[for=analyticsviewcheckboxSettings]').text("On");
        
    <?php } ?>
        <?php if($surveyObj->IsAcceptUserInfo == 1){  ?>
        $('#IsCaptureUserInfo').bootstrapSwitch('setState', false);
        $('label[for=IsCaptureUserInfo]').text("Off");
       
    <?php }else{ ?>
        $('#IsCaptureUserInfo').bootstrapSwitch('setState', true);
        $('label[for=IsCaptureUserInfo]').text("On");
        
    <?php } ?>

         <?php if($surveyObj->IsEnableNotification == 1){  ?>
        $('#exNotification').bootstrapSwitch('setState', false);
        $('label[for=exNotification]').text("Off");
       
    <?php }else{ ?>
        $('#exNotification').bootstrapSwitch('setState', true);
        $('label[for=exNotification]').text("On");
        
    <?php } ?>

         <?php if($surveyObj->ShowDerivative == 1){  ?>
        $('#ShowDerivativecheckboxSettings').bootstrapSwitch('setState', false);
        $('label[for=ShowDerivativecheckboxSettings]').text("Off");
       
    <?php }else{ ?>
        $('#ShowDerivativecheckboxSettings').bootstrapSwitch('setState', true);
        $('label[for=ShowDerivativecheckboxSettings]').text("On");
        
    <?php } ?>
        
        <?php if($surveyObj->IsBranded == 1){  ?>
        $('#isbranded').bootstrapSwitch('setState', false);
        $('label[for=isbranded]').text("Off");
       
    <?php }else{ ?>
        $('#isbranded').bootstrapSwitch('setState', true);
        $('label[for=isbranded]').text("On");
        
    <?php } ?>

        var logo = '<?php echo Yii::app()->params['ServerURL'].$logo; ?>';
         $("#surveyPreviewId").attr("src",logo);
         $("#ExtendedSurveyForm_SurveyLogo").val('<?php echo $logo; ?>');
         $("#ExtendedSurveyForm_IsBannerVisible").val('<?php echo $surveyObj->IsBannerVisible; ?>');
         $("#ExtendedSurveyForm_IsAnalyticsShown").val('<?php echo $surveyObj->IsAnalyticsShown; ?>');
    <?php }else{?>
        $('#surveyBannerSettings').bootstrapSwitch('setState', false);
         $('label[for=surveyBannerSettings]').text("Off");
         $('#analyticsviewcheckboxSettings').bootstrapSwitch('setState', false);
         $('label[for=analyticsviewcheckboxSettings]').text("Off");
         $('#IsCaptureUserInfo').bootstrapSwitch('setState', false);
         $('label[for=IsCaptureUserInfo]').text("Off");

         $('#exNotification').bootstrapSwitch('setState', false);
         $('label[for=exNotification]').text("Off");

         $('#ShowDerivativecheckboxSettings').bootstrapSwitch('setState', false);
         $('label[for=ShowDerivativecheckboxSettings]').text("Off");
         $('#isbranded').bootstrapSwitch('setState', false);
         $('label[for=isbranded]').text("Off");

         //$("#ExtendedSurveyForm_IsAnalyticsShown").val(1);
        questionsCount = 1;
        
         
    <?php } ?>
    var radioOptionsCount = 4;
    var checkboxOptionsCount = 4;
    var TotalQuestions = '<?php echo Yii::app()->params['TotalSurveyQuestions']; ?>';
    TotalQuestions = Number(TotalQuestions);
 
    var preq = 0;
    var nextq = 0;
    var i = 0;
    $("[rel=tooltip]").tooltip();    
    <?php if(empty($surveyId)){ ?> 
    ajaxRequest("/extendedSurvey/renderQuestionWidget", "questionNo=" + questionsCount, function(data) {
        renderQuestionwidgetHandler(data,"new","","","")
    }, "html");
    <?php } ?>
    function renderQuestionwidgetHandler(html,type, qType,qNo,opCnt,noofchars) {       
        scrollPleaseWaitClose("extededsurvey_spinner")
        if (type == "add") {
            $("#extendedSurveyWidgets").append(html);
        } else {
            $("#extendedSurveyWidgets").html(html);
        }

    }
    <?php //if(empty($surveyId) || $isAlreadySchedule == 0){?>
    $(".surveyradio,.surveycheckbox,.surveyratingranking,.surveypercent,.surveyQandA,.surveyuserranking,.surveybooleanfollowup").live('click', function() {
        var $this = $(this);
       
        var questionNo = $this.closest("ul.tabsselection").data("questionno");
        scrollPleaseWait("spinner_"+questionNo);
        if ($.trim($this.attr("class")) == "surveyradio") {            
            var data = "";
            ajaxRequest("/extendedSurvey/renderRadioWidget", "questionNo=" + questionNo, function(data) {
                renderwidgetHandler(data, questionNo)
            }, "html");
//            customeAjaxRequestForSurvey("/extendedSurvey/renderRadioWidget",data,"","");
        } else if ($.trim($this.attr("class")) == "surveycheckbox") {             
            var data = "";            
            ajaxRequest("/extendedSurvey/renderCheckboxWidget", "questionNo=" + questionNo, function(data) {
                renderwidgetHandler(data, questionNo)
            }, "html");
        } else if ($.trim($this.attr("class")) == "surveyratingranking") {             
            var data = "";
            ajaxRequest("/extendedSurvey/renderRRWidget", "questionNo=" + questionNo, function(data) {
                renderwidgetHandler(data, questionNo)
            }, "html");
        } else if ($.trim($this.attr("class")) == "surveypercent") {             
            var data = "";
            ajaxRequest("/extendedSurvey/renderPercentageDist", "questionNo=" + questionNo, function(data) {
                renderwidgetHandler(data, questionNo)
            }, "html");
        } else if ($.trim($this.attr("class")) == "surveyQandA") {             
            var data = "";
            ajaxRequest("/extendedSurvey/renderQuestionAndAnswerWidget", "questionNo=" + questionNo, function(data) {
                renderwidgetHandler(data, questionNo)
            }, "html");
        } else if ($.trim($this.attr("class")) == "surveyuserranking") {            
            var data = "";
            ajaxRequest("/extendedSurvey/userGeneratedRankingWidget", "questionNo=" + questionNo, function(data) {
                renderwidgetHandler(data, questionNo)
            }, "html");
        } else if($.trim($this.attr("class") == "surveybooleanfollowup booleanFollowup")){
            ajaxRequest("/extendedSurvey/renderBooleanFollowup", "questionNo=" + questionNo, function(data) {
                renderwidgetHandler(data, questionNo)
            }, "html");
        }

    });
        
              
            
   <?php //}?>
       <?php //if($isAlreadySchedule == 0){ ?>
    $("#newQuestion").click(function() {
                questionsCount++;        
                if (questionsCount >= TotalQuestions) {
                    $("#newQuestion").hide();
                }
                scrollPleaseWait("extededsurvey_spinner");
                ajaxRequest("/extendedSurvey/renderQuestionWidget", "questionNo=" + questionsCount, function(data) {
                    renderQuestionwidgetHandler(data, "add")
                }, "html");
            });
            
        $(".subsectionremove").live('click', function() {
                var $this = $(this);
                 var qId = $this.attr("data-questionId");
//                 var isedt = <?php //echo $isEditable; ?>;
//                 if(isedt == 1){
//                     questionsCount--;
//                   $(this).parents('div.QuestionWidget').remove();
//               }
       <?php //if (empty($surveyId)) { ?>
                             
                        questionsCount--;
                       
                    if (questionsCount >= 1) {

                        $(this).parents('div.QuestionWidget').remove();

                        if (questionsCount < TotalQuestions) {
                            $("#newQuestion").show();
                        }
                    } else {
                        questionsCount = 1;
                    }
                    updateDivs();
       <?php //} else { ?>
//           $("#QuestionWidget_"+qId).append("<div class='suspendcontentdiv' data-qid='"+qId+"'><div class='btn'>Click here to Resume</div></div><div class='suspenddiv' id='suspenddiv_"+qId+"'></div>");
//                    // $(this).parents('div#QuestionWidget_'+qId).append("<div class='suspendcontentdiv' data-qid='"+qId+"'><div class='btn'>Click here to Resume</div></div><div class='suspenddiv' id='suspenddiv_"+qId+"'></div>")
//                    $("#ExtendedSurveyForm_IsSuspend_"+qId).val(1);
       <?php //} ?>
               
        });
        
        $(".suspendcontentdiv .btn").live('click',function(){ 
            var qId = $(this).parent(".suspendcontentdiv").attr("data-qid");
            $("#ExtendedSurveyForm_IsSuspend_"+qId).val(0);
            $(this).parent(".suspendcontentdiv").remove();
            $("#suspenddiv_"+qId).remove();
          }); 
   <?php //} ?>

    $(".questionlabel").live('click', function() {
        var $this = $(this);
        $this.parentsUntil('div.surveyareaheader').parent().parent().next().slideToggle();

    });

         $(".surveyremoveicon").live('click', function() {
        var $this = $(this);
        var questionno = $this.closest("div.answersection1").attr("data-questionId");
        var optionType = $this.closest("div.answersection1").attr("data-optionType");
        var totalOptions = 0;
        $("input[name='" + optionType + "_" + questionno + "']").each(function(key, value) {
            totalOptions++
        });
        //changed the options dropdown value....
        
        var optionsVal = totalOptions-1;
        if(optionsVal == 0)
            optionsVal = 1;
        if(optionsVal > 1){
            $("#selectselectoptions_"+questionno).html(optionsVal+" options");            
        }else{
            $("#selectselectoptions_"+questionno).html(optionsVal+" option");
        }
        
        $("#selectoptions_"+questionno).val(optionsVal);
        
        // End changed the options dropdown value....
        if (optionType == "radio") {
            if (totalOptions > 1) {
//                $(this).closest('tr').find('.cost_of_items')
                $(this).closest("div.normaloutersection").prev('input').remove();
                totalOptions--;
                $this.closest("div.normaloutersection").remove();
                if (totalOptions < 6) {
                    $("#surveyaddoption_" + questionno).show();
                }
            }
        } else if (optionType == "checkbox") {
            if (totalOptions > 1) {
                $(this).closest("div.normaloutersection").prev('input').remove();
                totalOptions--;
                $this.closest("div.normaloutersection").remove();
                if (totalOptions < 6) {
                    $("#surveyaddoption_" + questionno).show();
                }
            }
        }

        preq = 0;
        nextq = 0;
        i = 0;
       updateDivs();


    });
    $(".surveyaddoption").live('click', function() {
        var $this = $(this);
        var questionno = $this.closest("div.QuestionWidget").attr("data-questionId");                
        var optionType = $this.attr("data-optionType");
        var totalOptions = 0;
        var sType = "";
        $("input[name='" + optionType + "_" + questionno + "']").each(function(key, value) {
            totalOptions++;
        });
        var URL = "/extendedSurvey/addRadioOptionWidget";
        if (optionType == "checkbox") {
            URL = "/extendedSurvey/addCheckboxOptionWidget";
        } else if (optionType == "boolean") {
            URL = "/extendedSurvey/addBooleanOptionWidget";
        }
        totalOptions++;
        if(optionType != "boolean"){
            if (totalOptions > 5) {
                $(this).hide();
            }
        }else {
            sType = $this.attr("data-stype");
            if (totalOptions > 4) {
                $(this).hide();
            }
        }
        
        ajaxRequest(URL, "questionNo=" + questionno+"&sType="+sType, function(data) {
            renderOptionwidgetHandler(data, questionno, optionType,sType)
        }, "html");

    });
    function renderwidgetHandler(html, qNo,qType) {         
        scrollPleaseWaitClose("spinner_"+qNo);      
        $("#surveyanswerarea_" + qNo).html(html);                
    }
    function renderOptionwidgetHandler(html, qNo, opType,sType) {
        if(opType != "boolean"){
            $(html).insertBefore("#othersarea_" + qNo);
        }else {
            $("#section_"+qNo).append(html);
//             $(html).insertBefore("#boolean_other_" + qNo);
        }
        
        var top = 0;
        $("input[name='" + opType + "_" + qNo + "']").each(function(key, value) {
            top++;
        });
        if (opType == "radio") {
            $("#radio_hidden_" + qNo).attr("name", "ExtendedSurveyForm[RadioOption][" + top + "_" + qNo + "]");
            $("#radio_hidden_" + qNo).attr("id", "ExtendedSurveyForm_RadioOption_" + top + "_" + qNo)
            $("#radioid_" + qNo).attr("id", "ExtendedSurveyForm_RadioOption_" + top);
            $("#ExtendedSurveyForm_RadioOption_" + top).attr("data-hiddenname", "ExtendedSurveyForm_RadioOption_" + top + "_" + qNo);
            $("#ExtendedSurveyForm_RadioOption_" + top).attr({
                'onkeyup': "insertText('ExtendedSurveyForm_RadioOption_" + top + "');",
                'onblur' : "insertText('ExtendedSurveyForm_RadioOption_" + top + "');"
            });
            $("#radioEmessage_" + qNo).attr("id", "ExtendedSurveyForm_RadioOption_" + top + "_" + qNo + "_em_");
        } else
        if (opType == "checkbox") {
            $("#checkbox_hidden_" + qNo).attr("name", "ExtendedSurveyForm[CheckboxOption][" + top + "_" + qNo + "]");
            $("#checkbox_hidden_" + qNo).attr("id", "ExtendedSurveyForm_CheckboxOption_" + top + "_" + qNo)
            $("#checkboxid_" + qNo).attr("id", "ExtendedSurveyForm_CheckboxOption_" + top);
            $("#ExtendedSurveyForm_CheckboxOption_" + top).attr("data-hiddenname", "ExtendedSurveyForm_CheckboxOption_" + top + "_" + qNo);
            $("#ExtendedSurveyForm_CheckboxOption_" + top).attr({
                'onkeyup': "insertText('ExtendedSurveyForm_CheckboxOption_" + top + "');",
                'onblur' : "insertText('ExtendedSurveyForm_CheckboxOption_" + top + "');"
            });
            $("#checkboxEmessage_" + qNo).attr("id", "ExtendedSurveyForm_CheckboxOption_" + top + "_" + qNo + "_em_");
        } else {
                $("#radio_hidden_" + qNo).attr("name", "ExtendedSurveyForm[BooleanRadioOption][" + top + "_" + qNo + "]");
                $("#radio_hidden_" + qNo).attr("id", "ExtendedSurveyForm_RadioOption_hid_" + top + "_" + qNo)
                $("#radioid_" + qNo).attr("id", "ExtendedSurveyForm_RadioOption_" + top);
                $("#ExtendedSurveyForm_RadioOption_" + top).attr("data-hiddenname", "ExtendedSurveyForm_RadioOption_hid_" + top + "_" + qNo);
                $("#ExtendedSurveyForm_RadioOption_" + top).attr({
                    'onkeyup': "insertText(this.id);",
                    'onblur' : "insertText(this.id);"
                });
                $("#radioEmessage_" + qNo).attr("id", "ExtendedSurveyForm_BooleanRadioOption_" + top + "_" + qNo + "_em_");
                $("#confirmation_"+ qNo).attr("data-quesitonid",qNo);
                $("#confirmation_"+ qNo).attr("id","confirmation_" + top + "_" + qNo);                
                $("#confirmation_" + top + "_" + qNo).attr("data-value",top);
                $("#needJust_"+ qNo).attr("id","needJust_" + top + "_" + qNo);
                $("#needJust_"+ top + "_" + qNo).attr("data-value",top);
        }
        

    }
    function saveQuestion(no, optionType,totalQuestions) {
        scrollPleaseWait("extededsurvey_spinner");
        var data = $("#questionWidget_" + no).serialize();
        var noofratings = "";        
//        if($("#ExtendedSurveyForm_NoofRatings_hid_"+no).length > 0){
//            noofratings = $("#ExtendedSurveyForm_NoofRatings_hid_"+no).val();
//        }

        $.ajax({
            type: 'POST',
            url: '/extendedSurvey/validateSurveyQuestion?surveyTitle=' + $("#ExtendedSurveyForm_SurveyTitle").val() + '&SurveyDescription=' + $("#ExtendedSurveyForm_SurveyDescription").val()+"&SurveyGroupName="+$("#ExtendedSurveyForm_SurveyRelatedGroupName").val()+"&SurveyOtherValue="+$("#ExtendedSurveyForm_SurveyOtherValue").val()+"&SurveyLogo="+$("#ExtendedSurveyForm_SurveyLogo").val()+"&IsBranded="+$("#ExtendedSurveyForm_IsBranded").val()+"&BrandName="+$("#ExtendedSurveyForm_BrandName").val()+"&BrandLogo="+$("#ExtendedSurveyForm_BrandLogo").val()+"&isEditable=<?php echo $isEditable; ?>",
            data: data,
            async:true,
            success: function(data) { 
                var data = eval(data);
                //alert(data.status) 
                if (data.status == 'success') {
                    isValidate++;                    
                }
                if(data.status == "error"){
                    isValidate = 0;
                    isValidated = false;
                }
                
                surveyHandler(data,totalQuestions,no);
            },
            error: function(data) { // if error occured
                isValidated = false;
                isValidate = 0;
            },
            dataType: 'json'
        });
    }
    function surveyHandler(data,totalQuestions,no) {            
        var data = eval(data);
        if (data.status == 'success') {            
              if(isValidate == totalQuestions){                    
                    isValidated = true;
                    surveyFinalSubmit();
                }

        } else {
            $("#surveyFormButtonId").attr("disabled",false);            
            isValidate = 0;
            isValidated = false;
            scrollPleaseWaitClose("extededsurvey_spinner");
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (typeof (data.error) == 'string') {

                var error = eval("(" + data.error.toString() + ")");

            } else {
                var error = eval(data.error);
            }

            if(typeof(data.oerror)=='string'){
                var errorStr=eval("("+data.oerror.toString()+")");
            }else{
                var errorStr=eval(data.oerror);
            }
            $.each(errorStr, function(key, val) { 
                 if($("#"+key+"_em_") && val != ""){                     
                    $("#"+key+"_em_").text(val);                                                    
                    $("#"+key+"_em_").show();   
                    $("#"+key+"_em_").fadeOut(12000);
                   // $("#"+key).parent().addClass('error');
                }
                
                
            }); 
            $.each(error, function(key, val) {
                var strArr = key.split("_");  
                
                if($.trim(strArr[1]) == "MatrixAnswer"){                            
                    $("#ExtendedSurveyForm_IsAnswerFilled_"+strArr[2]+"_em_").text("Please fill all the fields");
                    $("#ExtendedSurveyForm_IsAnswerFilled_"+strArr[2]+"_em_").show();
                    $("#ExtendedSurveyForm_IsAnswerFilled_"+strArr[2]+"_em_").fadeOut(9000);
                    $("#ExtendedSurveyForm_IsAnswerFilled_"+strArr[2]+"_em_").addClass('error');

                }else
                if (key == "ExtendedSurveyForm_SurveyDescription") {
                    if ($("#ExtendedSurveyForm_SurveyDescription").val() == "") {
                        $("#ExtendedSurveyForm_SurveyDescription_em_").text(val);
                        $("#ExtendedSurveyForm_SurveyDescription_em_").show();
                        $("#ExtendedSurveyForm_SurveyDescription_em_").fadeOut(12000);
                        $("#ExtendedSurveyForm_SurveyDescription").parent().addClass('error');
                    }
                } else if (key == "ExtendedSurveyForm_SurveyTitle") {
                    if ($("#ExtendedSurveyForm_SurveyTitle").val() == "") {
                        $("#ExtendedSurveyForm_SurveyTitle_em_").text(val);
                        $("#ExtendedSurveyForm_SurveyTitle_em_").show();
                        $("#ExtendedSurveyForm_SurveyTitle_em_").fadeOut(12000);
                        $("#ExtendedSurveyForm_SurveyTitle").parent().addClass('error');
                    }
                } else if (key == "ExtendedSurveyForm_SurveyLogo") {
                    $('#surveyLogo_error').html("Please upload Research Logo ");
                    $('#surveyLogo_error').show();
                    $('#surveyLogo_error').fadeOut(12000);
                } 
                else {
                    if ($("#" + key + "_em_")) {
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(12000);
                        $("#" + key).parent().addClass('error');
                    }
                }
                

            });
        }
    }
    var Garray = new Array();
    function saveSurveyForm() {
        isValidate = 0;
        $("#surveyFormButtonId").attr("disabled",true);
        for (var i = 1; i <= questionsCount; i++) {
            saveQuestion(i, "radio",questionsCount);
            Garray[i - 1] = $("#questionWidget_" + i).serialize();
        }

    }
    function surveyFinalSubmit(){
        $("#ExtendedSurveyForm_Questions").val(JSON.stringify(Garray));
        if (isValidated == true) {
            var data = $("#questionWidget").serialize();    
            $.ajax({
                type: 'POST',
                url: '/extendedSurvey/SaveSurveyQuestion?surveyTitle=' + $("#ExtendedSurveyForm_SurveyTitle").val() + '&SurveyDescription=' + $("#ExtendedSurveyForm_SurveyDescription").val() + '&questionsCount=' + questionsCount+"&SurveyGroupName="+$("#ExtendedSurveyForm_SurveyRelatedGroupName").val()+"&SurveyOtherValue="+$("#ExtendedSurveyForm_SurveyOtherValue").val()+"&SurveyLogo="+$("#ExtendedSurveyForm_SurveyLogo").val()+"&IsBranded="+$("#ExtendedSurveyForm_IsBranded").val()+"&BrandName="+$("#ExtendedSurveyForm_BrandName").val()+"&BrandLogo="+$("#ExtendedSurveyForm_BrandLogo").val(),
                data: data,
                success: surveyFinalHandler,
                error: function(data) { // if error occured
                    // alert("Error occured.please try again==="+data.toSource());
                    // alert(data.toSource());
                },
                dataType: 'json'
            });
        }
    }
    function surveyFinalHandler(data){
        
        data = eval(data);          
        if(data.status == "success"){            
            $("#sucmsg").css("display", "block");
             <?php if(empty($surveyId)){ ?> 
                $("#sucmsg").html("Created Successfully. <?php echo Yii::t("translation","Ex_Success_Msg"); ?>");
             <?php }else {  ?>
                 $("#sucmsg").html("Updated Successfully. <?php echo Yii::t("translation","Ex_Success_Msg"); ?>");
             <?php } ?>
                 $("body,html").animate({scrollTop:0}, 1000,function(){})
            $("#sucmsg").fadeOut(9000,function(){
                $("#surveyFormButtonId").attr("disabled",false);
                scrollPleaseWaitClose("extededsurvey_spinner");
                window.location.href = "/inventory";
            });
        }
    }
    function insertText(id) {
        //IsAlphaNumeric(id);
      var pId = $("#" + id).attr("data-hiddenname"); 
       $("#" + pId).val($("#" + id).val());
    }

    <?php if(empty($surveyId)){?>
   
    <?php } ?>
        <?php if($isAlreadySchedule == 0){ ?>
//         $('.mainclass').sortable({
//            connectWith: '.child',
//            handle: 'b',
//            cursor: 'move',
//            opacity: 1.8,
//            start:function(){
//                scrollPleaseWait('surveySpinLoader');
//                updateDivs();
//            },
//            stop:function(){
//                updateDivs();
//                setTimeout(function(){
//                    scrollPleaseWaitClose('surveySpinLoader');
//                },1000);
//            },
//        });
        <?php } ?>
    function SurveyPreviewImage(id, fileName, responseJSON, type)
    {
        var data = eval(responseJSON);
        $('#ExtendedSurveyForm_SurveyLogo').val(data.filename);
        $('#surveyPreviewId').attr('src', data.filepath);

    }
    function displayErrorForBannerAndQuestion(message, type) {
        
        $('#' + type + '_error').html(message);
        // $('#'+type+'_error').css("padding-top:20px;");
        $('#' + type + '_error').show();
        $('#' + type + '_error').fadeOut(6000);
  
    }
    function updateDivs(){
        
        $(".subsectionremove").each(function(key) {
            $(this).attr("data-questionId", key + 1);
        });
        
        $(".surveyaddoption").each(function(key) {
            $(this).attr("data-questionno", key + 1);
            $(this).attr("id","surveyaddoption_"+(key + 1));
        });
        $(".answerstabs").each(function(key) {
            $(this).attr("id", "answerstabs_" + (key + 1));
        });
        $(".tabsselection").each(function(key) {
            $(this).attr("data-questionno", (key + 1));
        });
        var ikey = 1;
        $(".answersection1").each(function(key) {            
            $(this).attr("data-questionId", (ikey));            
            $(this).attr("id", "answersection1_" + (ikey));
            if($(this).attr("data-type") != undefined && $(this).attr("data-type") != "undefined" && $(this).attr("data-type") != "" && $(this).attr("data-type") == "percentage"){
                $(this).attr("id", "percentageWidget_" + (ikey));
            }
            ikey++;
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".checkboxtype").each(function(key) {
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
            $this.attr("name", "checkbox_" + ($this.closest("div.answersection1").attr("data-questionId")));
            $this.attr("data-hiddenname", "ExtendedSurveyForm_CheckboxOption_hid_" + (i) + "_" + qNo);
            $this.attr("id", "ExtendedSurveyForm_CheckboxOption_" + (i) + "_" + qNo);
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".radiotype").each(function(key) {
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

            $this.attr("name", "radio_" + (qNo))
            $this.attr("data-hiddenname", "ExtendedSurveyForm_RadioOption_hid_" + (i) + "_" + qNo);
            $this.attr("id", "ExtendedSurveyForm_RadioOption_" + (i) + "_" + qNo);            
            $this.attr({
               'onkeyup':'insertText(this.id)',
               'onblur':'insertText(this.id)'
            });
        });
        $(".othersarea").each(function(key) {
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            $this.attr("id", "othersarea_" + qNo);            
        });
        preq = 0;
        nextq = 0;
        i = 0;
        
        $(".othercheck").each(function(){
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
            $this.attr("id","othercheck_"+qNo);
        });
        $(".otherhidden").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            
            $this.attr("id","ExtendedSurveyForm_Other_"+qNo);
            $this.attr("name","ExtendedSurveyForm[Other]["+qNo+"]");
        });
        $(".otherhiddenvalue").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            
            $this.attr("id","ExtendedSurveyForm_OtherValue_"+qNo);
            $this.attr("name","ExtendedSurveyForm[OtherValue]["+qNo+"]");
        });
        $(".otherTextdiv").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            
            $this.attr("id","otherTextdiv_"+qNo);
        });
        $(".othertext").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            
            $this.attr("id","otherText_"+qNo);
            $this.attr("data-hiddenname","ExtendedSurveyForm_OtherValue_"+qNo);
            
        });
        $(".othererr").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");            
            $this.attr("id","ExtendedSurveyForm_OtherValue_"+qNo+"_em_");
        });
        $(".QuestionWidget").each(function(key) {
            $(this).attr("data-questionId", (key + 1));
            $(this).attr("id", "QuestionWidget_" + (key + 1));

        });
        $(".questionlabel").each(function(key) {
            $(this).attr("data-wid", (key + 1));
        });
        $(".surveyanswerarea").each(function(key) {
            $(this).attr("id", "surveyanswerarea_" + (key + 1));

        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".selectoptions").each(function(key){
            var $this = $(this);
            var qNo = $this.closest("div.surveyanswerarea").attr("data-questionId"); 
            $(this).attr({
                "data-questionid": qNo,
                "name":"selectoptions_"+(qNo),
                "id":"selectoptions_"+(qNo)
                
            });
            
        });
        $(".radiohidden").each(function(key) {
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
            $this.attr("id", "ExtendedSurveyForm_RadioOption_hid_" + (i) + "_" + $this.closest("div.answersection1").attr("data-questionId"))
            $this.attr("name", "ExtendedSurveyForm[RadioOption][" + (i) + "_" + qNo + "]");

        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".checkboxhidden").each(function(key) {
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

            $this.attr("id", "ExtendedSurveyForm_CheckboxOption_hid_" + (i) + "_" + $this.closest("div.answersection1").attr("data-questionId"))
            $this.attr("name", "ExtendedSurveyForm[CheckboxOption][" + (i) + "_" + qNo + "]");

        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".radioEmessage").each(function(key) {
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
            $this.attr("id", "ExtendedSurveyForm_RadioOption_" + (i) + "_" + qNo + "_em_");
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".checkboxEmessage").each(function(key) {
            var $this = $(this);
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
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            $this.attr("id", "ExtendedSurveyForm_CheckboxOption_" + (i) + "_" + qNo + "_em_");
        });

        $(".questionserror").each(function(key) {
            var $this = $(this);
            var qNo = $this.closest("div.QuestionWidget").attr("data-questionId");
            $this.attr("id", "ExtendedSurveyForm_Question_" + qNo + "_em_");
            $this.attr("data-questionno",qNo);
        });
        $(".questionwidgetform").each(function() {
            var $this = $(this);
            var qNo = $this.closest("div.QuestionWidget").attr("data-questionId");            
            $this.attr("id", "questionWidget_" + qNo);            
        });
        $(".questionname").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.QuestionWidget").attr("data-questionId");
            $this.attr("id", "ExtendedSurveyForm_Question_" + qNo); 
            $this.attr("name","ExtendedSurveyForm[Question][" + qNo + "]");
            $this.attr("placeholder","Enter Question " + qNo + " here...");
        });
        $(".tab_1").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.QuestionWidget").attr("data-questionId");
            $this.attr("data-questionno",qNo);            
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".questionno_ex").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.QuestionWidget").attr("data-questionId");
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
            $this.html(qNo+")");
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".mandatory,.analyticsview").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.QuestionWidget").attr("data-questionId");
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
            if($this.attr("class") == "row-fluid mandatory"){
                $this.attr("id","mandatory_"+qNo);
            }else{
                $this.attr("id","analyticsview_"+qNo);
            }
            
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".madatoryclass,.analyticsviewclass").each(function(){
             var $this = $(this);
            var qNo = $this.closest("div.QuestionWidget").attr("data-questionId");
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
            $this.attr("data-questionno",qNo);
        }); 
        preq = 0;
        nextq = 0;
        i = 0;
        $(".mandatorycheckbox,.analyticsviewcheckbox").each(function(){
             var $this = $(this);
            var qNo = $this.closest("div.QuestionWidget").attr("data-questionId");
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
            
            if($this.attr("class") == "styled mandatorycheckbox"){
                $this.attr("name","ExtendedSurveyForm[IsMadatory]["+qNo+"]");
                $this.attr("id","ExtendedSurveyForm_IsMadatory_"+qNo);
            }else{
                $this.attr("name","ExtendedSurveyForm[IsAnalyticsShown]["+qNo+"]");
                $this.attr("id","ExtendedSurveyForm_IsAnalyticsShown_"+qNo);
            }
            
        });
        
        preq = 0;
        nextq = 0;
        i = 0;
        $(".booleanoptionhidden").each(function(key) {
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
            $this.attr("id", "ExtendedSurveyForm_RadioOption_hid_" + (i) + "_" + qNo)
            $this.attr("name", "ExtendedSurveyForm[BooleanRadioOption][" + (i) + "_" + qNo + "]");

        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".booleanhidden").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            
            $this.attr("id", "ExtendedSurveyForm_Boolean_hid_" +  qNo)
            $this.attr("name", "ExtendedSurveyForm[BooleanValues][" + qNo + "]");
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".booleanradioEmessage").each(function(key) {
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
            $this.attr("id", "ExtendedSurveyForm_BooleanRadioOption_" + (i) + "_" + qNo + "_em_");
        });
        
        
        preq = 0;
        nextq = 0;
        i = 0;
        $(".radiotype_boolean").each(function(key) {
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
            $this.attr("id", "ExtendedSurveyForm_RadioOption_" + (i) + "_" + qNo );
            $this.attr("name", "boolean_" + qNo );
            $this.attr("data-hiddenname", "ExtendedSurveyForm_RadioOption_hid_" + (i) + "_" + qNo);
            
        });
        
        
        $(".booleantextareahidden").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            
            $this.attr("id", "ExtendedSurveyForm_BooleanPlaceholderValues_hid_" +  qNo)
            $this.attr("name", "ExtendedSurveyForm[BooleanPlaceholderValues][" + qNo + "]");
        });
        
        
        preq = 0;
        nextq = 0;
        i = 0;
        $(".booleantextarea").each(function(key) {
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            
            $this.attr("id", "qAaTextarea_" + qNo );
            $this.attr("name", "ExtendedSurveyForm[BooleanPlaceholderValues]["+ qNo+"]");
            
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".rr_justification_hidden").each(function(key) {
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
            $this.attr("id", "ExtendedSurveyForm_JustificationPlaceholders_" + (i) + "_" + qNo)                      
            $this.attr("name", "ExtendedSurveyForm[JustificationPlaceholders][" + (i) + "_" + qNo + "]");
            $this.attr("class", "rr_justification_hidden rr_justification_hidden_"+ qNo);
                

        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".rr_justification").each(function(key) {
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
            $this.attr("id", "ExtendedSurveyForm_JustificationPlaceholderstext_" + (i) + "_" + qNo)                      
            $this.attr("data-hiddenname", "ExtendedSurveyForm_JustificationPlaceholders_" + (i) + "_" + qNo)
             $this.attr("clas", "textfield textfieldtable rr_justification notallowed rr_justification_"+ qNo);
            

        });
        $(".allothersrankratings").each(function(key){
            var $this = $(this);    
            var qNo = $this.closest("div.answersection1").attr("data-questionId"); 
            $this.attr("id", "allothers_" + qNo);   
        })
        $(".rankratematrixwidgets").each(function(key) {
            var $this = $(this);            
            var qNo = $this.closest("div.answersection1").attr("data-questionId");            
            $this.attr("id", "rankingOrRating_" + qNo);           
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".surveyradiofollowup").each(function(k){
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
            $this.attr("id", "confirmation_" + (i) + "_" + qNo);                      
            $this.attr("class", "surveyradiofollowup confirmation_" + qNo);
            $this.attr("data-quesitonid",qNo);
        });
        
        $(".booleantextareadiv").each(function(){
            var $this = $(this);            
            var qNo = $this.closest("div.answersection1").attr("data-questionId");            
            $this.attr("id", "rowfluidBooleanChars_" + qNo);
        });
        $(".boolean_other").each(function(){
            var $this = $(this);            
            var qNo = $this.closest("div.answersection1").attr("data-questionId");            
            $this.attr("id", "boolean_other_" + qNo);
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".confirmraido").each(function(){
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
            $this.attr("name", "confirmradio_" + qNo);
            $this.attr("needJust_" + (i) + "_" + qNo);
        });
        $(".boolean_section").each(function(){
            var $this = $(this);            
            var qNo = $this.closest("div.answersection1").attr("data-questionId");  
            $this.attr("id","section_"+qNo);
        });
        $(".selectionType").each(function(){
            var $this = $(this);            
            var qNo = $this.closest("div.answersection1").attr("data-questionId");  
            $this.attr("data-quesitonid",qNo);
            $this.attr("name","loadwidgetType_"+qNo);
        });
        $(".selectiontype_hidden").each(function(){
            var $this = $(this);            
            var qNo = $this.closest("div.answersection1").attr("data-questionId");              
            $this.attr("id","ExtendedSurveyForm_SelectionType_hid_"+qNo);
            $this.attr("name","ExtendedSurveyForm[SelectionType]["+qNo+"]");
        });
        $(".questionDisplayType").each(function(key){
            var $this = $(this);
            var qNo = $this.closest("div.surveyanswerarea").attr("data-questionId"); 
            $(this).attr({
                "data-questionid": qNo,
                "name":"displaytype_"+(qNo),
                "id":"displaytype_"+(qNo)
                
            });
            
        });
    }
    <?php if(!empty($surveyId)){?>
            $('#surveyGroupName').val('<?php echo $surveyObj->SurveyRelatedGroupName;?>');
            $("#surveyGroupName").attr("disabled",true);              
    <?php } ?>
    $("#surveyGroupName").change(function(){
        var val = $(this).val();
        $("#ExtendedSurveyForm_SurveyRelatedGroupName").val(val);       
        if(val == "Public"){
             $("#ExtendedSurveyForm_SurveyLogo").val('');
           $("#surveyPreviewId").attr("src","<?php echo Yii::app()->params['ServerURL'];?>/images/system/survey_img.png");
        }
        if( val == "other"){
           $("#othervalue").show();
           $("#ExtendedSurveyForm_SurveyLogo").val('');
           $("#surveyPreviewId").attr("src","<?php echo Yii::app()->params['ServerURL'];?>/images/system/survey_img.png");
       }else{
           <?php foreach($surveyGroupNames as $rw){?> 
                if((val == '<?php echo $rw->GroupName;?>')){
                    
                    $("#surveyPreviewId").attr("src",'<?php echo Yii::app()->params['ServerURL'].$rw->LogoPath;?>');
                    $("#ExtendedSurveyForm_SurveyLogo").val('<?php echo $rw->LogoPath;?>');
                }
            <?php } ?>
           
//           $("#ExtendedSurveyForm_SurveyLogo").val($(this).attr("data-url"));
           $("#othervalue").hide();
           
       }        
    });
    
    function getSurveyGroups(){     
            ajaxRequest("/extendedSurvey/getSurveyGroups", '', function(data){getSurveyGroupsHandler(data);});
    }
    function getSurveyGroupsHandler(data){        
        $('#surveyGroupName option').remove();        
        var dataArr = data.data;        
        $('#surveyGroupName').append("<option value=''>Please Choose Group Name</option>");
        $.each(dataArr, function(i){           
            $('#'+id).append($("<option></option>")
            .attr("value",dataArr[i]['id'])
            .text(dataArr[i]['GroupName']));
        });        
           
        $('#surveyGroupName').append("<option value='other'>Other</option>");
    }
    function CancelSurveyForm(){
        window.location.href = "/inventory";
    }

        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        specialKeys.push(9); //Tab
        specialKeys.push(46); //Delete
        specialKeys.push(36); //Home
        specialKeys.push(35); //End
        specialKeys.push(37); //Left
        specialKeys.push(39); //Right
        specialKeys.push(127);//Question mark
        specialKeys.push(96); //Space
        function IsAlphaNumeric(id) {
//            var specials=/[*|\":<>[\]{}`\\()';@&$]/;            
//            var inputString = "~#^`{}|\"<>"+$("#"+id).val(),
//            outputString = inputString.replace(/([~#^`{}\|\\"<>])+/g, '').replace(/^()+|()+$/g,'');                 
//            $("#"+id).val(outputString);
            var charReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
            var inputVal = $("#"+id).val();
//            alert(charReg.test(inputVal))
            if (!charReg.test(inputVal)) {
                return false;
            }
            
        }
        
        $(".notallowed_other").live('keypress',function(e){           
            var keyCode =e.which;            
            if(keyCode == 94 || keyCode == 96 || keyCode == 35 ||  keyCode == 95 || keyCode == 126 || e.which == 60 || e.which == 62){
                return false;
            }
        }).blur(function(){
            var $this = $(this);
            var value = $this.val();            
            var inputString = "~#^`{}|\"<>"+value,
            outputString = inputString.replace(/([~#^`{}\|\\"<>])+/g, '').replace(/^()+|()+$/g,'');                 
            $this.val(outputString);
            //alert(outputString)
        });
        $(".notallowed").live('keypress',function(e){           
            var keyCode =e.which;            
            if(keyCode == 94 || keyCode == 96 || keyCode == 35 ||  keyCode == 95 || keyCode == 126 || e.which == 60 || e.which == 62){
                return false;
            }
        }).blur(function(){
            var $this = $(this);
            var value = $this.val();            
            var inputString = "~#^`{}|\"<>"+value,
            outputString = inputString.replace(/([~#^`{}\|\\"<>])+/g, '').replace(/^()+|()+$/g,'');                 
            $this.val(outputString);
            //alert(outputString)
        });
        
        $(".notallowed_desc").live('keypress',function(e){           
            var keyCode =e.which;
            if(keyCode == 94 || keyCode == 96 || keyCode == 35 || keyCode == 47 || keyCode == 95 || keyCode == 126 || e.which == 60 || e.which == 62){
                return false;
            }
        }).blur(function(){
            var $this = $(this);
            var value = $this.val();            
            var inputString = "~#^`{}|\"<>"+value,
            outputString = inputString.replace(/([~#^`{}\|\\"<>])+/g, '').replace(/^()+|()+$/g,'');                 
            $this.val(outputString);
            var snippethtml=$this.val();
            snippethtml=snippethtml.replace(/<br>/g, "&nbsp");
//            
            var strippedText = strip_tags($this.val(), '<p><pre><span><i><b><li></li><ul></ul><u></u><strike></strike><ol></ol>');
//            strippedText=strippedText.replace(/\s+/g, ' ');
            $this.val(strippedText) ;
            $this.find('*').removeAttr('style');
            //alert(outputString)
        });
//        $("#ExtendedSurveyForm_SurveyDescription").bind('paste', function (event) {
//            var $this = $(this); //save reference to element for use laster
//            alert($(this).html())
//            var snippethtml=$this.html();
//            
//            snippethtml=snippethtml.replace(/<br>/g, "&nbsp");
//            
//            var strippedText = strip_tags($this.html(), '<p><pre><span><i><b><li></li><ul></ul><u></u><strike></strike><ol></ol>');
////            strippedText=strippedText.replace(/\s+/g, ' ');
//            $this.html(strippedText) ;
//            $this.find('*').removeAttr('style');
//            var result = $('#ExtendedSurveyForm_SurveyDescription');
//            result.focus();
//            placeCaretAtEnd( document.getElementById("ExtendedSurveyForm_SurveyDescription") );
//        });
        function bindToMandatory(){
            $("div.mandatory div.span5 span.checkbox ").die().live("click",function(){
                var $this = $(this);
                var questionNo = $this.closest("div.madatoryclass").attr("data-questionno"); 
                if($("#ExtendedSurveyForm_IsMadatory_"+questionNo).is(":checked")){
                    $("#ExtendedSurveyForm_IsMadatory_"+questionNo).val(1);
                }else{
                    $("#ExtendedSurveyForm_IsMadatory_"+questionNo).val(0);
                }
            });
            
            $("div.analyticsview div.span5 span.checkbox ").die().live("click",function(){
                var $this = $(this);
                var questionNo = $this.closest("div.analyticsviewclass").attr("data-questionno"); 
                if($this.closest("span.checkbox").attr("style") == "background-position: 0px -50px;"){
                    $("#ExtendedSurveyForm_IsAnalyticsShown_"+questionNo).val(1);                    
                }else{
                    $("#ExtendedSurveyForm_IsAnalyticsShown_"+questionNo).val(0);
                }
            });
        }
        
        function bindtoanyother(qNo){ 
            $('#anyothervaluediv_'+qNo+' span.checkbox').live("click",
                function() {                      
                    var isChecked = 0;
                    if ($('#anyothervalue_'+qNo).is(':checked')) {
                        isChecked = 1;
                    }
                    $("#ExtendedSurveyForm_AnyOther_hid_"+qNo).val(isChecked);
                }
            );}
        $(".onlinetestradio").die().live("click",function(){  
            var $this = $(this); 
       var radiovalue = "";
        var qId = $this.closest('div.answersection1').attr("data-questionId");
        var qtype = $this.closest('div.answersection1').attr("data-qtype");
       //alert(qtype)
        if(qtype == 3 ){
              var noptions = $("#ExtendedSurveyForm_NoofOptions_"+qId).val();
              var norows =$("#ExtendedSurveyForm_NoofRows_"+qId).val();
            var i = $this.attr("data-info");
           if($("#anyothervaluediv_"+qId+" span").attr("style") =="background-position: 0px -50px;"){
              noptions++;
              norows++;
              
          }
          if($("#anyothersarea_"+qId+" span").attr("style") =="background-position: 0px -50px;"){
              noptions++;
              norows++;
              
          }
             //alert(noptions+"**"+norows)
            //radiovalue=$("input[name='radio_"+i+"_"+qId+"']:checked").val();
            var count=0;
            $(".radiotype_"+qId).each(function(){
                      var $this = $(this);
                      
                           if($this.is(":checked")){
                               if(radiovalue == ""){
                                   radiovalue = $this.val();
                               }else{
                                   radiovalue = radiovalue+","+$this.val();  
                               }
                            count++;                   
                            }
                           
                        }); 
           
          //alert(radiovalue)
          if(noptions == count || norows == count)
        $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val(1);
        else 
        $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val('');  
            
        }else{
            
            radiovalue=$this.find("input[name='radioinput']").val();
            $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val(1);
            //alert(radiovalue)
            if(qtype==8){
              $("#ExtendedSurveyForm_answerSelectedEdit_"+qId).val(radiovalue); 
           }
        }
        
      $("#ExtendedSurveyForm_answerSelected_"+qId).val(radiovalue);
    });
    
    $(".onlinetestcheckbox").die().live("click",function(){
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
                //alert(checkboxvalues);          
         });
         if(checkboxvalues=='')
          $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val('');
          else
              $("#ExtendedSurveyForm_IsAnswerFilled_"+qId).val(1);
         $("#ExtendedSurveyForm_answerSelectedEdit_"+qId).val(checkboxvalues);
         //alert(checkboxvalues)
         
    });
        
        
        <?php //if(empty($surveyId) || $isAlreadySchedule == 0){ ?>
        // boolean widget functions...
    $(".surveyradiofollowup").die().live("click",function(){ 
        var $this = $(this);        
        var qId = $this.attr("data-quesitonid");
        var checkedItems = "";   
        $("input[name='confirmradio_" + qId + "']").each(function(key, value) {            
            if($(this).is(":checked")){
                if(checkedItems == ""){
                    checkedItems = $(this).val();
                }else {
                    checkedItems = checkedItems+","+$(this).val();
                }
            }
        });
        var appliedJustification = $("input[name='applytoall_" + qId + "']:checked").length;
        if(checkedItems != "" || appliedJustification == 1){            
            $("#rowfluidBooleanChars_"+qId+",#rowfluidChars_"+qId).show();
            $("#ExtendedSurveyForm_Boolean_hid_"+qId).val(checkedItems);
        }else{
            $("#rowfluidBooleanChars_"+qId+",#rowfluidChars_"+qId).hide();
            $("#ExtendedSurveyForm_JustificationApplied_"+qId).val(0);
            $("#ExtendedSurveyForm_Boolean_hid_"+qId).val(0);
        }        
    });  
    var LabelsArray = new Array();
var OptionsArray = new Array();
var LabelsDescArray = new Array();
var OJustArray = new Array();
    $(".selectionType").die().live('change',function(){
        var $this = $(this);        
        var qId = $this.attr("data-quesitonid");
        var optscnt = $("#selectoptions_"+qId).val();
        var URL = "/extendedSurvey/renderBooleanRadioCheckbox"; 
        OptionsArray = new Array();
        $(".booelanType_"+qId).each(function(k,v){
            OptionsArray[k] = $(this).val();
        });
        var queryString = "questionNo="+qId+"&type="+$this.val()+"&optscnt="+optscnt;       
        $("#ExtendedSurveyForm_SelectionType_hid_"+qId).val($this.val());
        $("#surveyaddoption_"+qId).attr("data-stype",$this.val());
        ajaxRequest(URL, queryString, function(data) {
            renderBooleanHandler(data, qId)
        }, "html"); 
                           
    });
    function renderBooleanHandler(html,qId){        
        $("#surveyaddoption_"+qId).show();
        $("#section_"+qId).html(html);
        setTimeout(function(){
            $(".booleanType_"+qId).each(function(k,v){
             $(this).val(OptionsArray[k]);
        });
        },200)
         Custom.init();
    }
    
    $(".justapplied").die().live("click",function(){
    var $this = $(this);
    var qId = $this.attr("data-questionid");    
    var JustificationApplied = $("input[name='applytoall_" + qId + "']:checked").length;
    var checkedItems = "";    
    $("input[name='confirmradio_" + qId + "']").each(function(key, value) {            
        if($(this).is(":checked")){
            if(checkedItems == ""){
                checkedItems = $(this).val();
            }else {
                checkedItems = checkedItems+","+$(this).val();
            }
        }
    });
    if(JustificationApplied == 1 || checkedItems != ""){
        $("#rowfluidBooleanChars_"+qId+",#rowfluidChars_"+qId).show();
        if(JustificationApplied == 1)
            $("#ExtendedSurveyForm_JustificationApplied_"+qId).val(1);
        else
            $("#ExtendedSurveyForm_JustificationApplied_"+qId).val(0);
    }else{
        $("#rowfluidBooleanChars_"+qId+",#rowfluidChars_"+qId).hide();
        $("#ExtendedSurveyForm_JustificationApplied_"+qId).val(0);
    }
});

$(".stypeofquestion").die().live('change',function(){
    var $this = $(this);
    var widgetType = $this.val();
    var questionId = $this.closest("div.answersection1").attr("data-questionId");
    $("#ExtendedSurveyForm_MatrixType_hid_"+questionId).val(widgetType);
    $("#anyothersarea_"+questionId).hide();
    $('#anyothervalue_'+questionId).val("");
    $('#anyothervaluediv_'+questionId+' span.checkbox').removeAttr("style").attr("style","background-position: 0px 0px;"); 
            $('#anyothervalue_'+questionId).attr('checked',false); 
    if (widgetType == 2) {
            $("#noofrowsdiv_"+questionId+",#OptionType_"+questionId).show();
            $("#noofoptionsdiv_"+questionId+",#noofcolsdiv_"+questionId+",#TextMaxlengthdiv_"+questionId).hide();
            
        } else if(widgetType == 1 ){
            $("#noofoptionsdiv_"+questionId+",#OptionType_"+questionId).show();
            
            $("#noofratingsdiv_"+questionId+",#noofrowsdiv_"+questionId+",#noofcolsdiv_"+questionId+",#TextMaxlengthdiv_"+questionId).hide();
        } else if(widgetType == 3){
            $("#noofrowsdiv_"+questionId+",#TextMaxlengthdiv_"+questionId).show();
            //$("#noofcolsdiv_<?php //echo $widgetCount; ?>").attr("style","margin:auto");
            $("#OptionType_"+questionId+",#noofoptionsdiv_"+questionId+",#noofratingsdiv_"+questionId+",#othervaluediv_"+questionId).hide();
        }
        setToDefault(questionId);  
    
});

$(".snofooptions").die().live("change",function(){
    LabelsArray = [];
    LabelsDescArray = [];
    OptionsArray = [];
    OJustArray = [];
    var $this = $(this); 
    var questionId = $this.closest("div.answersection1").attr("data-questionId");
    var value = $("#ExtendedSurveyForm_NoofOptions_"+questionId).val();
    var widgetType = $("#loadwidgetType_"+questionId).val();
    $("#ExtendedSurveyForm_TextOptions_hid_"+questionId).val($("#ExtendedSurveyForm_TextOptions_"+questionId).val());
    $("#ExtendedSurveyForm_MatrixType_hid_"+questionId).val(widgetType);
    if(value > 0 && widgetType == 2){
        $("#noofratingsdiv_"+questionId).attr("style","margin:auto;margin-top:10px;");
        $("#allothers_"+questionId).show();
    }else{
        $("#noofratingsdiv_"+questionId).val("").hide();
        $("#allothers_"+questionId).hide();
    }
    $("#ExtendedSurveyForm_NoofOptions_hid_"+questionId).val(value);  
    var optionType = $("#ExtendedSurveyForm_TextOptions_hid_"+questionId).val();
    var renderV = 0;
    var renTemp = 0;
    $(".option_text").each(function(){
        renderV++;
    });
    if(widgetType == 1){
        var URL = "/extendedSurvey/renderRankingWidget";
        var queryString = "questionNo="+questionId+"&optionsCount=" + value+"&radioOptions="+value+"&optionType="+optionType;
        bufferLabelsAndOptions('.labelnamewid_'+questionId,'label','buffer',questionId);
        bufferLabelsAndOptions('.optionnamewid_'+questionId,'option','buffer',questionId);
        $(".label_lDesc_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            LabelsDescArray[k] = value;
        })
        $(".rr_justification_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            OJustArray[k] = value;
        })

            ajaxRequest(URL, queryString, function(data) {
               renderRRHandler(data, questionId)
           }, "html"); 

        }
        $("#ExtendedSurveyForm_MatrixType_hid_"+questionId).val(widgetType);
    if (value <= 0 || value > 10) {
        $("#rankingOrRating_"+questionId).empty();
        $("#othervaluediv_"+questionId).hide();  
        $("#allothers_"+questionId).hide();
    }else{
        $("#allothers_"+questionId).show();
    }
    
    
});

$(".ssoofRatings").die().live("change",function(){
    
    var $this = $(this);
    var questionId = $this.closest("div.answersection1").attr("data-questionId");
    var ratingsValue = $("#ExtendedSurveyForm_NoofRatings_"+questionId).val();
    $("#ExtendedSurveyForm_NoofRatings_hid_"+questionId).val(ratingsValue);
    var optionType = $("#ExtendedSurveyForm_TextOptions_hid_"+questionId).val();
    var URL = "/extendedSurvey/renderRatingWidget";
    var widgetType = $("#loadwidgetType_"+questionId).val();
    var optionValue = $("#ExtendedSurveyForm_NoofRows_"+questionId).val();
    $("#ExtendedSurveyForm_NoofOptions_hid_"+questionId).val(optionValue);  
    $("#ExtendedSurveyForm_MatrixType_hid_"+questionId).val(widgetType);
    if (1) {

        bufferLabelsAndOptions('.labelnamewid_'+questionId,'label','buffer',questionId);
        bufferLabelsAndOptions('.optionnamewid_'+questionId,'option','buffer',questionId);
        $(".label_lDesc_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            LabelsDescArray[k] = value;
        })
        $(".rr_justification_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            OJustArray[k] = value;
        })
        ajaxRequest(URL, "questionNo="+questionId+"&optionsCount=" + optionValue + "&ratingsCount=" + ratingsValue+"&optionType="+optionType, function(data) {
            renderRRHandler(data, questionId)
        }, "html");
    }

    if ((optionValue <= 0 || optionValue > 30) || (ratingsValue <= 0 || ratingsValue > 30)) {
        $("#rankingOrRating_"+questionId).empty();
        $("#othervaluediv_"+questionId).hide();
        $("#allothers_"+questionId).hide();
    }else{
         $("#allothers_"+questionId).show();
    }
    
    
    
    
});


$(".snoofrows").die().live("change",function(){
    var $this = $(this);
    var questionId = $this.closest("div.answersection1").attr("data-questionId");    
    var rowValue = $("#ExtendedSurveyForm_NoofRows_"+questionId).val();
    var optionType = $("#ExtendedSurveyForm_TextOptions_hid_"+questionId).val();
    var URL = "/extendedSurvey/renderRatingWidget";
    var widgetType = $("#loadwidgetType_"+questionId).val();  
    var noofcolumns = $("#ExtendedSurveyForm_NoofRatings_hid_"+questionId).val();
    if(widgetType == 2){
        $("#ExtendedSurveyForm_TextOptions_hid_"+questionId).val($("#ExtendedSurveyForm_TextOptions_"+questionId).val());
        if(rowValue > 0 ){
            $("#noofratingsdiv_"+questionId).show().attr("style","margin-top:10px;");
        }else{
            $("#noofratingsdiv_"+questionId).hide();
        }

    }else{
        if(rowValue > 0 ){
            $("#noofcolsdiv_"+questionId).show().attr("style","margin:auto;margin-top:10px;");;
        }else{
            $("#noofcolsdiv_"+questionId).hide();
        }
    }
     $("#ExtendedSurveyForm_NoofOptions_hid_"+questionId).val(rowValue);   
        bufferLabelsAndOptions('.labelnamewid_'+questionId,'label','buffer',questionId);
         bufferLabelsAndOptions('.optionnamewid_'+questionId,'option','buffer',questionId);
        $(".label_lDesc_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            LabelsDescArray[k] = value;
        })
        $(".rr_justification_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            OJustArray[k] = value;
        })
        var ratingsValue = $("#ExtendedSurveyForm_NoofCols_"+questionId).val();
     if(widgetType == 2 && noofcolumns != 0){


        ajaxRequest(URL, "questionNo="+questionId+"&optionsCount=" + rowValue + "&ratingsCount=" + noofcolumns+"&optionType="+optionType, function(data) {
               renderRRHandler(data, questionId)
           }, "html");
     }else if(widgetType == 3 && ratingsValue != 0){
            optionType = 2; // Text options only...
            ajaxRequest(URL, "questionNo="+questionId+"&optionsCount=" + rowValue + "&ratingsCount=" + noofcolumns+"&optionType="+optionType, function(data) {
                renderRRHandler(data, questionId)
            }, "html");
     }
    if (($this.val() <= 0 || $this.val() > 30) || ($this.val() <= 0 || $this.val() > 30)) {
        $("#rankingOrRating_"+questionId).empty();
        $("#othervaluediv_"+questionId).hide();
        $("#ExtendedSurveyForm_AnyOther_hid_"+questionId).val("");
    }
            
            
});

$(".snoofcols").live("change",function(){   
   
   var $this = $(this);
   var questionId = $this.closest("div.answersection1").attr("data-questionId");
    var ratingsValue = $this.val();    
    $("#ExtendedSurveyForm_TextOptions_hid_"+questionId).val(2);
    $("#ExtendedSurveyForm_NoofRatings_hid_"+questionId).val(ratingsValue);
    var optionType = 2; // Text options only...
    var URL = "/extendedSurvey/renderRatingWidget";
    var widgetType = $("#loadwidgetType_"+questionId).val();
    var optionValue = $("#ExtendedSurveyForm_NoofOptions_hid_"+questionId).val();
    $("#ExtendedSurveyForm_MatrixType_hid_"+questionId).val(widgetType);
    if (1) {
        bufferLabelsAndOptions('.labelnamewid_'+questionId,'label','buffer',questionId);
        bufferLabelsAndOptions('.optionnamewid_'+questionId,'option','buffer',questionId);
        $(".label_lDesc_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            LabelsDescArray[k] = value;
        })
        $(".rr_justification_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            OJustArray[k] = value;
        })
        ajaxRequest(URL, "questionNo="+questionId+"&optionsCount=" + optionValue + "&ratingsCount=" + ratingsValue+"&optionType="+optionType, function(data) {
            renderRRHandler(data, questionId)
        }, "html");
    }
    if (($this.val() <= 0 || $this.val() > 30) || ($this.val() <= 0 || $this.val() > 30)) {
        $("#rankingOrRating_"+questionId).empty();
        $("#othervaluediv_"+questionId).hide();
        $("#ExtendedSurveyForm_AnyOther_hid_"+questionId).val("");
    }
   
   
   
});
    
    $(".othersarea_rrwidget ").die().live("click",function(){
        var isChecked = 0;
        var $this = $(this);
        var questionId = $this.closest("div.answersection1").attr("data-questionId");        
        if ($('#othervalue_'+questionId).is(':checked')) {
            isChecked = 1;
        }
        $("#ExtendedSurveyForm_NA_hid_"+questionId).val(isChecked);
    });
    

    function renderRRHandler(html, questionno,type) {        
        $("#rankingOrRating_" + questionno).html(html);        
        setTimeout(function(){
            bufferLabelsAndOptions(".labelnamewid_"+questionno,'label','set',questionno);
            bufferLabelsAndOptions(".optionnamewid_"+questionno,'option','set',questionno);
         },200);
         setTimeout(function(){
            LabelsArray = [];
            LabelsDescArray = [];
            OptionsArray = [];
            OJustArray = [];
         },400);
        
        if(type != "other"){
            $('#anyothervaluediv_'+questionno+' span.checkbox').removeAttr("style").attr("style","background-position: 0px 0px;"); 
            $('#anyothervalue_'+questionno).attr('checked',false); 
            $("#anyothersarea_"+questionno).show();
        }
//        $("#othervaluediv_" + questionno+",#anyothervaluediv_" + questionno).show();
        var widtype = $("#loadwidgetType_"+questionno).val();
        if(widtype == 3){
             $("#othervaluediv_" + questionno).hide();
        }else{
            $("#othervaluediv_" + questionno).show();
        }
        
        $("#allothers_"+questionno+",#anyothervaluediv_" + questionno).show();
    }    
    
    $(".stextoptions").die().live("change",function(){
         var $this = $(this);
        var questionId = $this.closest("div.answersection1").attr("data-questionId");   
        var textoptionvalue = $("#ExtendedSurveyForm_TextOptions_"+questionId).val();
        var widgetType = $("#loadwidgetType_"+questionId).val();
        $("#ExtendedSurveyForm_TextMaxlength_hid_"+questionId).val(textoptionvalue);
        $("#ExtendedSurveyForm_TextOptions_hid_"+questionId).val(textoptionvalue);
        //setToDefault();
        if(textoptionvalue == 2){
            $("#TextMaxlengthdiv_"+questionId).show();
            if(widgetType == 1)
                $("#noofoptionsdiv_"+questionId).attr("style","margin:auto");
        }else{
            $("#TextMaxlengthdiv_"+questionId).hide();
             if(widgetType == 1)
                $("#noofoptionsdiv_"+questionId).removeAttr("style");
            
        }
    });
   

    function setToDefault(qno){
        $('#anyothervaluediv_'+qno+' span.checkbox').removeAttr("style").attr("style","background-position: 0px 0px;"); 
        $('#anyothervalue_'+qno).attr('checked',false);    
        $("#rankingOrRating_"+qno).empty();
        $("#allothers_"+qno).hide();
        $("#othervaluediv_"+qno+",#anyothervaluediv_"+qno).hide();
        $("#ExtendedSurveyForm_NoofOptions_"+qno).val("");
        $("#ExtendedSurveyForm_NoofOption_"+qno+",#ExtendedSurveyForm_NoofRatings_"+qno).val("");
        $("#selectExtendedSurveyForm_NoofOptions_"+qno).html("Please Select");
        $("#selectExtendedSurveyForm_NoofRatings_"+qno).html("Please Select");
        $("#selectExtendedSurveyForm_NoofRows_"+qno).html("Please Select");
        $("#selectExtendedSurveyForm_NoofCols_"+qno).html("Please Select");
        $("#ExtendedSurveyForm_TextOptions_hid_"+qno).val("");
        $("#ExtendedSurveyForm_NoofRatings_hid_"+qno).val("");
        $("#ExtendedSurveyForm_NoofOptions_"+qno).val("");
        $("#ExtendedSurveyForm_NoofRows_"+qno).val("");
        $("#ExtendedSurveyForm_NoofCols_"+qno).val("");
        
    }
//    bindtoanyother('<?php //echo $widgetCount; ?>');
    function allowNumericsAndCheckFields(e){           
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
    
    function checkvalid(v,id,qid){
        //var questionId = $this.closest("div.answersection1").attr("data-questionId");
        //alert(v);
        //var qid = $(this).attr("data.qid");
        //alert(id);
       var maxValue = $("#ExtendedSurveyForm_TextMaxlength_"+qid).val();
        //alert( maxValue);
       if(Number(v)>Number(maxValue)){ 
        $("#"+id).val('');
        }
       
    }
    function maxCheck(obj,qno){
        var calValue = 0;
        var totalvalue = $.trim($("#ExtendedSurveyForm_TotalValue_"+qno).val());
        var noptions = $("#ExtendedSurveyForm_NoofOptions_"+qno).val();
        //alert(noptions);
        //alert(totalvalue)
        //var totalvalue = $.trim($("#"+obj.id).closest('div.total').attr("data-num"));
        var count=0;
       $(".distvalue_"+qno).each(function(){
                           var $this = $(this);
                           calValue = calValue+Number($this.val()); 
                          count++;
                           if(count==noptions){
                                if(totalvalue != calValue){
                                    $this.val("");
                                 }
                               }else if(totalvalue < calValue){
                               $this.val("");
                           }
         });
                        
    }
   
    
    
    $(".anyothersarea_rrwidget").die().live("click",function(){
        
        var isChecked = 0;
        var $this = $(this);
        var questionId = $this.closest("div.answersection1").attr("data-questionId");         
        if ($('#anyothervalue_'+questionId).is(':checked')) {
            isChecked = 1;
        }   
        var qType = $("#loadwidgetType_"+questionId).val();
        var nOptions = $("#ExtendedSurveyForm_NoofOptions_"+questionId).val();
        var nRatings = $("#ExtendedSurveyForm_NoofRatings_"+questionId).val();
        var optionType = $("#ExtendedSurveyForm_TextOptions_hid_"+questionId).val();
        
        
        LabelsArray = [];
        LabelsDescArray = [];
        OptionsArray = [];
        OJustArray = [];
        bufferLabelsAndOptions('.optionnamewid_'+questionId,'option','buffer',questionId);
        bufferLabelsAndOptions('.labelnamewid_'+questionId,'label','buffer',questionId);

        $(".label_lDesc_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            LabelsDescArray[k] = value;
        })
        $(".rr_justification_"+questionId).each(function(k,v){
            var $this = $(this);
            var value = $this.val();
            OJustArray[k] = value;
        })
        $("#ExtendedSurveyForm_AnyOther_hid_"+questionId).val(isChecked);   
            var URL = "";
            var queryString = "";
        if(qType == 1 ){

            URL = "/extendedSurvey/renderRankingWidget";
            queryString = "questionNo="+questionId+"&optionsCount=" + (Number(nOptions)+1)+"&radioOptions="+(Number(nOptions)+1)+"&optionType="+optionType+"&other=1";
            if( isChecked == 0){                        
                queryString = "questionNo="+questionId+"&optionsCount=" + (Number(nOptions))+"&radioOptions="+(Number(nOptions))+"&optionType="+optionType;                        

           }    

        } 
        else if(qType == 2){
            URL = "/extendedSurvey/renderRatingWidget";
            queryString = "questionNo="+questionId+"&optionsCount=" + (Number($("#ExtendedSurveyForm_NoofRows_"+questionId).val())+1)+"&ratingsCount="+$("#ExtendedSurveyForm_NoofRatings_"+questionId).val()+"&optionType="+optionType+"&other=1";
            if( isChecked == 0){                        
                queryString = "questionNo="+questionId+"&optionsCount=" + (Number($("#ExtendedSurveyForm_NoofRows_"+questionId).val()))+"&ratingsCount="+(Number($("#ExtendedSurveyForm_NoofRatings_"+questionId).val()))+"&optionType="+optionType;                        

           }          


        } else  if(qType == 3){
            URL = "/extendedSurvey/renderRatingWidget";
            queryString = "questionNo="+questionId+"&optionsCount=" + (Number($("#ExtendedSurveyForm_NoofRows_"+questionId).val())+1)+"&ratingsCount="+$("#ExtendedSurveyForm_NoofCols_"+questionId).val()+"&optionType=2"+"&other=1";
            if( isChecked == 0){                        
                queryString = "questionNo="+questionId+"&optionsCount=" + (Number($("#ExtendedSurveyForm_NoofRows_"+questionId).val()))+"&ratingsCount="+(Number($("#ExtendedSurveyForm_NoofCols_"+questionId).val()))+"&optionType=2";                        

           }   

        }
        ajaxRequest(URL, queryString, function(data) {
                   renderRRHandler(data, questionId,'other')
               }, "html");
        
        
    });
    
    
    
    
    function bufferLabelsAndOptions(clsname,type,flag,questionno){    
        $(clsname).each(function(k,v){  
                    var $this = $(this);
                    var value = "";
                    
                    if(flag == "buffer")
                        value = $this.val();
                    else{
                        if(type == "label")
                            value = LabelsArray[k];
                        else
                            value = OptionsArray[k];
                    }                    
                    //if(value != "" && value != "undefined" && value != undefined && value != null){                        
                        if(type == "label"){
                            if(flag == "buffer"){
                                LabelsArray[k] = value;                                
                            }
                            else{
                                $this.val(LabelsArray[k]);
                                $(".label_hidden_"+questionno).each(function(k,v){  
                                    var $this = $(this);
                                    var value_l = LabelsArray[k];                    
                                    if(value_l != "" && value_l != "undefined" && value_l != undefined && value_l != null)
                                        $this.val(value_l);
                                 });
                                 $(".label_lDesc_"+questionno).each(function(k,v){  
                                    var $this = $(this);
                                    var value_ld = LabelsDescArray[k];                    
                                    if(value_ld != "" && value_ld != "undefined" && value_ld != undefined && value_ld != null){
                                        $this.val(value_ld);
                                    }
                                 });
                                 $(".rr_justification_"+questionno).each(function(k,v){  
                                    var $this = $(this);
                                    var value_ld = OJustArray[k];                    
                                    if(value_ld != "" && value_ld != "undefined" && value_ld != undefined && value_ld != null)
                                        $this.val(value_ld);
                                 });
                                 
//                                 LabelsArray = [];
//                                 LabelsDescArray = [];
                                 
                            }
                        }else{
                            if(flag == "buffer"){
                                OptionsArray[k] = value;
                            }else{
                                $this.val(OptionsArray[k]);
                                $(".option_hidden_"+questionno).each(function(k,v){  
                                    var $this = $(this);
                                    var value_op = OptionsArray[k];                    
                                    if(value_op != "" && value_op != "undefined" && value_op != undefined && value_op != null)
                                        $this.val(value_op);
                                 });
                                 
                            }
                        }
                 });
                 
    }

    $(".questionDisplayType").live("change",function(){
       var $this = $(this);
       var qId = $this.attr("data-questionid");
       $("#ExtendedSurveyForm_DisplayType_"+qId).val($this.val());
      
    });
    $(".stylingoptions").die().live('change',function(){
        var $this = $(this);
        var value = $this.val();
        var questionId = $this.closest("div.answersection1").attr("data-questionId");         
        $("#ExtendedSurveyForm_StylingOption_hid_"+questionId).val(value);
    });

function BrandPreviewImage(id, fileName, responseJSON, type)
    {
        var data = eval(responseJSON);
//        alert(responseJSON.toSource())
        var qid = data.qid;//alert(qid)
        var extension = data.extension;
        if(extension == "mp3" || extension == "mp4"){
            $("#player_"+qid).show();
            $('#brandPreview_'+qid).removeAttr("src");
            $("#brandimagelogodiv_"+qid).hide();
            openOverlay(data.filepath,"/images/system/video_new.png","player_"+qid,"",350);
             //$('#brandPreview_'+qid).attr('src', data.filepath);
        }else{
            $("#player_"+qid+"_wrapper").html("").attr("id","player_"+qid).hide();
             $("#brandimagelogodiv_"+qid).attr("style","padding-left:30px;");
             $('#brandPreview_'+qid).attr('src', data.filepath);
        }
       $('#ExtendedSurveyForm_QuestionImage_'+qid).val(data.filename);
      

    }
    
    
    
   
    
    
 
</script>   