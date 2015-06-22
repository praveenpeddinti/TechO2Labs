<div class="alert alert-success" id="sucmsg" style='text-align:center;display:none;'></div>
<div class="padding10ltb">
    <div class="row-fluid groupseperator headermarginzero" id="dashboardtop">
    <div class="span12 paddingtop10 border-bottom">
        <div class="span12"><h2 class="pagetitle" id="pagetitle">New Test Paper</h2></div>
      
    </div>
  
</div>    
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
    
     <div class="questionmainpaddingtop" style="padding-top:20px">
    <div class="market_profile2 marginT102 paddin" id="testPaperDiv">
        
       
        
        <div class="row-fluid padding-bottom15">
            <div class="span12">
                <?php echo $form->textField($TestPaperForm, 'Title', array('maxlength' => '100', 'class' => 'span6 textfield notallowed', "placeholder" => "Test Name")); ?>    
                <div class="control-group controlerror"> 
                    <?php echo $form->error($TestPaperForm, 'Title'); ?>
                </div>


            </div>
        </div>
        <div class="row-fluid padding-bottom15">
            <div class="span12">
                <?php echo $form->textArea($TestPaperForm, 'Description', array('maxlength' => '500', 'style' =>'margin-bottom:0', 'class' => 'survey_profiletitleedit span8 notallowed_desc', "contenteditable" => "true", "placeholder" => "Test Description","onkeypress"=>"IsAlphaNumeric(this.id)","onblur"=>"IsAlphaNumeric(this.id)","max-height" => "200px")); ?>    
                    <?php //echo $form->textField($TestPaperForm, 'SurveyDescription', array('maxlength' => '100', 'class' => 'span8 notallowed', "placeholder" => "Test Description")); ?>    
                <div class="control-group controlerror" > 
                    <?php echo $form->error($TestPaperForm, 'Description'); ?>
                </div>


            </div>
        </div>
        <div class="row-fluid padding-bottom15">
            <div class="span4 positionrelative">
                <select style="width: 100%;margin-bottom:0" name="surveyGroupName" id="surveyGroupName" class="styled" >
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
          <div class="divtable" id="categoryHeaderDiv" style="display:none">
        <div class="divrow divtableheader">
       <div class="divcol1"> &nbsp;</div>
        <div class="divcol2"># Questions </div>
        <div class="divcol3">Time </div>
        <div class="divcol4">Score </div>
        <div class="divcol5">Review Question </div>
        <div class="divcol6"> </div>
        </div>
          </div>
    <div id="extendedSurveyWidgets" class="mainclass">
        
    </div> 
    
    <div class="row-fluid" id="surveyfooterids" style="display: none;">
        <div id="extededsurvey_spinner" style="position: relative"></div>
        <div class="alignright padding10 bggrey">
            <?php echo CHtml::Button('Save', array('onclick' => 'saveTestPaperForm();', 'class' => 'btn', 'id' => 'surveyFormButtonId')); ?> 

            <?php echo CHtml::resetButton('Cancel', array("id" => 'surveyResetId', 'onclick' => 'CancelTestPaperForm();', 'class' => 'btn btn_gray')); ?>
        </div>
    </div></div> 
    <?php $this->endWidget(); ?>
    
</div>

<script>
    Custom.init();
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

});
</script>

<script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.min.js"></script>


<script type="text/javascript">
    
    $('#ReviewQuestion').bootstrapSwitch();

         $('#ReviewQuestion').on('switch-change', function(e, data) {           
               var switchedValue = data.value ? 1 : 0;               
               if (switchedValue == 1) {
                   $("#TestPaperForm_ReviewQuestion").val(0);
                   
               } else {
                   $("#TestPaperForm_ReviewQuestion").val(1);
                   
               }
               var scrollTp = $(window).scrollTop();
                scrollTp = Number(scrollTp);                
                $("#surveyviewspinner").css("top",scrollTp);                
                
         });
         
         
        
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
    $("#surveyGroupName").die().live("change",function(){
        addCategory('surveyGroupName',$(this).val());
    });
    function addCategory(id,val){ 
        
        $("#categoryHeaderDiv").show();
        var CategoryName = $("#"+id+" option:selected").text();
        var selectVal = $("#TestPaperForm_SurveyRelatedGroupName").val();
        if(selectVal == ""){
            selectVal = $("#surveyGroupName option:selected").text();
        }else{
            selectVal = selectVal+","+$("#surveyGroupName option:selected").text();
        }
        $("#TestPaperForm_SurveyRelatedGroupName").val(selectVal);
       
       
                //$("#category option:selected").attr('disabled','disabled');
         if (selectVal == "ALL"){
                // cannot disable all the options in select box
             $("#surveyGroupName  option").attr("disabled","disabled");  

         }else{                     
             $("#surveyGroupName option[value='"+CategoryName+"']").attr('disabled','disabled');
             //$("#surveyGroupName option").attr('disabled','');
        }

                
                if(CategoryName!="Select Category"){
                    questionsCount++; 
                    //alert("ques1-----"+questionsCount);
                scrollPleaseWait("extededsurvey_spinner");
                ajaxRequest("/testPaper/renderQuestionWidget", "questionNo=" + questionsCount+"&CategoryName=" +CategoryName+"&CategoryId=" +val,function(data) {
                    renderQuestionwidgetHandler(data, "add")
                }, "html");
            }
        }
    
    
    $(".subsectionremove").live('click', function() {
        var cqNo = $(this).parents('div.QuestionWidget').attr("data-questionId"); 
            //alert("---1-ddddd----"+cqNo); 
            
            //alert(cqNo+"---2---"+$("#TestPaperForm_CategoryName_"+cqNo).val());
            
            //var cc=$("#TestPaperForm_CategoryName_"+cqNo).val();
//            $("select option[value='B']").removeAttr("disabled");
            $("#surveyGroupName option[value='"+$("#TestPaperForm_CategoryName_"+cqNo).val()+"']").removeAttr("disabled");
        //$("div .testPaperDiv #category option[value='2']").attr('disabled','');
            questionsCount--;
            if(questionsCount==0){$("#categoryHeaderDiv").hide();};
        if (questionsCount >= 0) {//alert(questionsCount+"----");questionsCount--;
            $(this).parents('div.QuestionWidget').remove();
            //alert("fffffssss--3-"+$("#"+cqNo+" option:selected").text());
            if (questionsCount < TotalQuestions) {
                $("#newQuestion").show();
            }
        } else {//alert("rrcase ques1-----"+questionsCount);
            questionsCount = 1;
        }
        updateDivs();
    });
     
     var Garray = new Array();
    function saveTestPaperForm() {
        isValidate = 0;
        //alert("category------"+$("#surveyGroupName option:selected").val());
             
        if (($("#TestPaperForm_Title").val() == "") || ($("#TestPaperForm_Description").val() == "") || ($("#surveyGroupName option:selected").val() == "Public") ){      
                if ($("#TestPaperForm_Title").val() == "") {
                        $("#TestPaperForm_Title_em_").text("Title cannot be blank");
                        $("#TestPaperForm_Title_em_").show();
                        $("#TestPaperForm_Title_em_").fadeOut(12000);
                        $("#TestPaperForm_Title").parent().addClass('error');
                        
                    }
                if ($("#TestPaperForm_Description").val() == "") {
                     $("#TestPaperForm_Description_em_").text("Description cannot be blank");
                     $("#TestPaperForm_Description_em_").show();
                     $("#TestPaperForm_Description_em_").fadeOut(12000);
                     $("#TestPaperForm_Description").parent().addClass('error');

                 }
                 if ((questionsCount==0) && ($("#surveyGroupName option:selected").val() == "Public")) {
                     $("#TestPaperForm_SurveyRelatedGroupName_em_").text("Please select category");
                     $("#TestPaperForm_SurveyRelatedGroupName_em_").show();
                     $("#TestPaperForm_SurveyRelatedGroupName_em_").fadeOut(12000);
                     $("#TestPaperForm_SurveyRelatedGroupName").parent().addClass('error');

                 }
          return false;      
        }
        //alert("---ok----");
        
        $("#surveyFormButtonId").attr("disabled",true);
        for (var i = 1; i <= questionsCount; i++) {
            saveQuestion(i, "radio",questionsCount);
            Garray[i -1] = $("#questionWidget_" + i).serialize();
        }

    }
     function saveQuestion(no, optionType,totalQuestions) {//alert("---saveQues---"+no+"----"+optionType+"======"+totalQuestions);
        scrollPleaseWait("extededsurvey_spinner");
        var data = $("#questionWidget_" + no).serialize();
        //alert("query-----"+data.toSource());
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
                if (data.status == 'success') {//alert("------if---"+data.status);
                    isValidate++;                    
                }
                if(data.status == "error"){//alert("------esle---"+data.status);
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
        //alert("-----surveyHan---"+data.toSource());
        var data = eval(data);
        if (data.status == 'success') {  //alert(totalQuestions+"---2--surveyHan---"+isValidate);          
              if(isValidate == totalQuestions){  //alert("--3---surveyHan---");                  
                    isValidated = true;
                    surveyFinalSubmit();
                }

        } else {
            //alert("==1");
            $("#surveyFormButtonId").attr("disabled",false);            
            isValidate = 0;
            isValidated = false;
            scrollPleaseWaitClose("extededsurvey_spinner");
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (typeof (data.error) == 'string') {//alert("=data.error=2");

                var error = eval("(" + data.error.toString() + ")");

            } else {
                var error = eval(data.error);
            }
            
            if(typeof(data.oerror)=='string'){//alert("=data.oerror=3");
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
            
            
            
            $.each(error, function(key, val) {
                //alert("==error=last=");
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
                    if ($("#" + key +"_"+no+"_em_")) {
                        $("#" + key +"_"+no+"_em_").text(val);
                        $("#" + key +"_"+no+"_em_").show();
                        $("#" + key +"_"+no+"_em_").fadeOut(12000);
                        $("#" + key+"_"+no).parent().addClass('error');
                    }
                }
                
                
            });
        }
    }
     
     
     
     
     
    function updateDivs(){
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
         //alert("-----final survey---"+JSON.stringify(Garray));
        $("#TestPaperForm_Questions").val(JSON.stringify(Garray));
        if (isValidated == true) {
            var data = $("#paperWidget").serialize();
            //alert("data===="+data);exit();
            $.ajax({
                type: 'POST',
                url: '/testPaper/SaveSurveyQuestion?Title=' + $("#TestPaperForm_Title").val() +"&Description="+$("#TestPaperForm_Description").val()+ '&questionsCount=' + questionsCount+"&SurveyGroupName="+$("#TestPaperForm_SurveyRelatedGroupName").val(),
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
                window.location.href = "/testpaper";
            });
        }
    }
    
    $(".reviewquestion span").live("click",function(){        
        var $this = $(this);
        var qid = $(this).siblings("input[type=checkbox]").attr("data-qid");
        if($this.attr("style") == "background-position: 0px -50px;"){
            $("#ReviewQuestion_"+qid).val(1);
        }else{
            $("#ReviewQuestion_"+qid).val(0);
        }
    });
     
     function CancelTestPaperForm(){
        window.location.href = "/testpaper";
    }
</script>