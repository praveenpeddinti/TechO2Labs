<div class="alert alert-success" id="sucmsg" style='text-align:center;display:none;'></div>
<div class="padding10ltb">
    <h2 class="pagetitle" id="pagetitle_s">New Test Paper</h2>     
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'paperWidget',
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
 
    <?php echo $form->hiddenField($TestPaperForm, 'Questions'); ?>
    <?php //echo $form->hiddenField($TestPaperForm, 'SurveyRelatedGroupName', array("value"=>"")); ?>
    
    <div class="market_profile2 marginT102" id="testPaperDiv">
        
        

        <div class="row-fluid padding-bottom15">
            <div class="span12">
                <label>Test Name</label>
                <?php echo $form->textField($TestPaperForm, 'Title', array('maxlength' => '100', 'class' => 'span8 notallowed', "placeholder" => "Test Name")); ?>    
                <div class="control-group controlerror"> 
                    <?php echo $form->error($TestPaperForm, 'Title'); ?>
                </div>


            </div>
        </div>
        <div class="row-fluid padding-bottom15">
            <div class="span12">
                <label>Test Description</label>
                    <?php echo $form->textArea($TestPaperForm, 'Description', array('maxlength' => '500', 'class' => 'survey_profiletitleedit span12 notallowed_desc', "contenteditable" => "true", "placeholder" => "Test Description","onkeypress"=>"IsAlphaNumeric(this.id)","onblur"=>"IsAlphaNumeric(this.id)","max-height" => "200px")); ?>    
                    <?php //echo $form->textField($TestPaperForm, 'SurveyDescription', array('maxlength' => '100', 'class' => 'span8 notallowed', "placeholder" => "Test Description")); ?>    
                <div class="control-group controlerror"> 
                    <?php echo $form->error($TestPaperForm, 'Description'); ?>
                </div>


            </div>
        </div>
        <div class="row-fluid padding-bottom15">
            <div class="span8 positionrelative">
                <label>Category</label>
                <select name="surveyGroupName" id="surveyGroupName" class="span12" onchange="addCategory(this);">
                    <option value="Public">Select Category</option>
                    <?php 
                        foreach($surveyGroupNames as $rw){?>
                    <option value="<?php echo $rw->GroupName; ?>" data-url="<?php echo $rw->LogoPath; ?>"><?php echo $rw->GroupName; ?></option>                                      
                        <?php } ?>
                    </select>
                <div class="control-group controlerror">
                      <?php echo $form->error($TestPaperForm, 'SurveyRelatedGroupName'); ?>
                 </div>
            </div>
        </div>
        
        
       

    </div>
    <div id="extendedSurveyWidgets" class="mainclass">
        
    </div> 
    
    <div class="row-fluid" id="surveyfooterids" style="display: none;">
        <div id="extededsurvey_spinner" style="position: relative"></div>
        <div class="span12 alignright padding10 bggrey">
            <?php echo CHtml::Button('Done', array('onclick' => 'saveTestPaperForm();', 'class' => 'btn', 'id' => 'surveyFormButtonId')); ?> 

            <?php echo CHtml::resetButton('Cancel', array("id" => 'surveyResetId', 'onclick' => 'CancelSurveyForm();', 'class' => 'btn btn_gray')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    
</div>

<script>
$(document).ready(function(){
    
/*$('#TestPaperForm_SurveyDescription').focusin(function(){
   $(this).attr("style","height:150px;")
}).focusout(function(){
    $(this).attr("style","")
});*/
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

<script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.min.js"></script>


<script type="text/javascript">
    // $("#TestPaperForm_SurveyRelatedGroupName").val('<?php //echo $surveyObj->SurveyRelatedGroupName; ?>');
   /*$("#surveyGroupName").change(function(){alert("-ffff----");
        var val = $(this).val();
        alert("val--"+val);
        $("#TestPaperForm_SurveyRelatedGroupName").val(val); }  */
    var questionsCount = 0; 
    var CategoryName ='';
    var TotalQuestions = '<?php echo Yii::app()->params['TotalSurveyQuestions']; ?>';
    
    TotalQuestions = Number(TotalQuestions);
    var dumpCat = new Array(); 
    
    
    $("[rel=tooltip]").tooltip();    
    
    function renderQuestionwidgetHandler(html,type, qType,qNo,opCnt,noofchars) {       
        scrollPleaseWaitClose("extededsurvey_spinner")
        if (type == "add") {
            $("#extendedSurveyWidgets").append(html);
        } else {
            $("#extendedSurveyWidgets").html(html);
        }

    }
    
    function addCategory(obj){  
        //var val = $(this).val();
        //alert($("#category option:selected").val());
        //$("#TestPaperForm_SurveyRelatedGroupName").val($("#surveyGroupName option:selected").val()); 
        var CategoryName = $("#"+obj.id+" option:selected").text();
        var selectVal = $("#TestPaperForm_SurveyRelatedGroupName").val();
        if(selectVal == ""){
            selectVal = $("#surveyGroupName option:selected").text();
        }else{
            selectVal = selectVal+","+$("#surveyGroupName option:selected").text();
        }
        $("#TestPaperForm_SurveyRelatedGroupName").val(selectVal);
        alert("----"+selectVal);
                //$("#category option:selected").attr('disabled','disabled');
         /*if (selectVal == "ALL"){alert("--idf---");
                // cannot disable all the options in select box
             $("#category  option").attr("disabled","disabled");  

         }else{     alert("--else---");                 
             $("#category option[value='"+obj.value+"']").attr('disabled','disabled');
             $("#category option").attr('disabled','');
        }*/



    //alert(obj.value+"------1---"+questionsCount+"----"+TotalQuestions);
                questionsCount++; 
                
                
                scrollPleaseWait("extededsurvey_spinner");
                ajaxRequest("/testPaper/renderQuestionWidget", "questionNo=" + questionsCount+"&CategoryName=" +CategoryName+"&CategoryId=" +obj.value,function(data) {
                    renderQuestionwidgetHandler(data, "add")
                }, "html");
            }
    
    
    
    $(".subsectionremove").live('click', function() {
        //$("div .testPaperDiv #category option[value='2']").attr('disabled','');
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
    });
     
     var Garray = new Array();
    function saveTestPaperForm() {alert("---save----"+questionsCount);
        isValidate = 0;
        $("#surveyFormButtonId").attr("disabled",true);
        for (var i = 1; i <= questionsCount; i++) {
            saveQuestion(i, "radio",questionsCount);
            Garray[i -1] = $("#questionWidget_" + i).serialize();
        }

    }
     function saveQuestion(no, optionType,totalQuestions) {alert("---saveQues---"+no+"----"+optionType+"======"+totalQuestions);
        scrollPleaseWait("extededsurvey_spinner");
        var data = $("#questionWidget_" + no).serialize();
        alert("query-----"+data.toSource());
        var noofratings = "";        
//        if($("#ExtendedSurveyForm_NoofRatings_hid_"+no).length > 0){
//            noofratings = $("#ExtendedSurveyForm_NoofRatings_hid_"+no).val();
//        }
        $.ajax({
            type: 'POST',
            url: '/testPaper/validateSurveyQuestion?Title=' + $("#TestPaperForm_Title").val() + '&SurveyDescription=' + $("#TestPaperForm_Description").val()+ "&SurveyGroupName="+$("#TestPaperForm_SurveyRelatedGroupName").val(),
            data: data,
            async:true,
            success: function(data) {
                var data = eval(data);
                alert(data.toSource()) 
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
        alert("-----surveyHan---"+data.toSource());
        var data = eval(data);
        if (data.status == 'success') {  alert(totalQuestions+"---2--surveyHan---"+isValidate);          
              if(isValidate == totalQuestions){  alert("--3---surveyHan---");                  
                    isValidated = true;
                    surveyFinalSubmit();
                }

        } else {
            alert("==1");
            $("#surveyFormButtonId").attr("disabled",false);            
            isValidate = 0;
            isValidated = false;
            scrollPleaseWaitClose("extededsurvey_spinner");
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (typeof (data.error) == 'string') {alert("=data.error=2");

                var error = eval("(" + data.error.toString() + ")");

            } else {
                var error = eval(data.error);
            }
            
            if(typeof(data.oerror)=='string'){alert("=data.oerror=3");
                var errorStr=eval("("+data.oerror.toString()+")");
            }else{
                var errorStr=eval(data.oerror);
            }
            
//            $.each(errorStr, function(key, val) { 
//                
//                if($("#"+key+"_em_") && val != ""){                     
//                    $("#"+key+"_em_").text(val);                                                    
//                    $("#"+key+"_em_").show();   
//                    $("#"+key+"_em_").fadeOut(12000);
//                   // $("#"+key).parent().addClass('error');
//                }
//                
//                
//            }); 
            alert("==error=="+error.toSource());
            $.each(error, function(key, val) {
                
                if (key == "TestPaperForm_Title") {
                    if ($("#TestPaperForm_Title").val() == "") {
                        $("#TestPaperForm_Title_em_").text(val);
                        $("#TestPaperForm_Title_em_").show();
                        $("#TestPaperForm_Title_em_").fadeOut(12000);
                        $("#TestPaperForm_Title").parent().addClass('error');
                    }
                }  else if (key == "TestPaperForm_Description") {
                    if ($("#TestPaperForm_Description").val() == "") {
                        $("#TestPaperForm_Description_em_").text(val);
                        $("#TestPaperForm_Description_em_").show();
                        $("#TestPaperForm_Description_em_").fadeOut(12000);
                        $("#TestPaperForm_Description").parent().addClass('error');
                    }
                }else {
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
     
     
     
     
     
    function updateDivs(){alert("--ddddd-----");
        
        $(".subsectionremove").each(function(key) {
            $(this).attr("data-questionId", key + 1);
        });
        
        
        
       
       
        preq = 0;
        nextq = 0;
        i = 0;
        
        
        
        $(".QuestionWidget").each(function(key) {
            $(this).attr("data-questionId", (key + 1));
            $(this).attr("id", "QuestionWidget_" + (key + 1));

        });
       
      
       

        $(".questionwidgetform").each(function() {
            var $this = $(this);
            var qNo = $this.closest("div.QuestionWidget").attr("data-questionId");            
            $this.attr("id", "questionWidget_" + qNo);            
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
        
            
       
    } 
     
     
     function surveyFinalSubmit(){
         alert("-----final survey---"+JSON.stringify(Garray));exit();
        $("#TestPaperForm_Questions").val(JSON.stringify(Garray));
        if (isValidated == true) {
            var data = $("#paperWidget").serialize(); 
            
            $.ajax({
                type: 'POST',
                url: '/testPaper/SaveSurveyQuestion?Title=' + $("#TestPaperForm_Title").val() +"&surveyDescription="+$("#TestPaperForm_Description").val()+ '&questionsCount=' + questionsCount+"&SurveyGroupName="+$("#TestPaperForm_SurveyRelatedGroupName").val(),
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
                window.location.href = "/marketresearchwall";
            });
        }
    }
     
</script>