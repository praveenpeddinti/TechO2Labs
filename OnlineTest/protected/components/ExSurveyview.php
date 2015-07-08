<div class="row-fluid" >  
<div class="span9" style="margin-right:0; padding-right:0px;">
   <div class="row" style="margin-right:0; padding-right:0px;">
  <div class="col-xs-12 col-md-12 col-sm-12 mobileview1" style="margin-right:0; padding-right:0px;">
      <div class="questions_area_left_outer">
      	<div class="questions_area_left_inner">
        <div class="question_options_div">
        	<div class="streamsectionarea" style="display:none" id="streamsectionarea">
    <form name="questionviewwidget" id="questionviewwidget">
        
        <div class="spotMessage" style="display: none">
            <span><i class="fa fa-info-circle"  ></i><b id="spotCount"></b>  </span>
        </div>
    <div  id="questionviewarea">
         
    </div>  
        <div id="pagenoforsurvey" style="display: none;text-align: right;padding-right:5px" class="pagination pagination-mini"></div>
        <div class="row-fluid surveybuttonarea">
            <div class="span8">
                <div id="userviewErrMessage" class="alert alert-error errorMessage" style="display: none;"></div>                
            </div>
            <div class="span4">
                <div id="surveyviewspinner" style="position:relative;"></div>
                <div class=" alignright" id="surveysubmitbuttons" style="display:none">
                    
                      <input type="button" value="Previous" name="previous" class="btn" id="prevQuestion" style="display: none"> 
                     <input type="button" value="Next" name="next" class="btn" id="nextQuestion" style="display: none"> 
                      <input type="button" value="Done" name="commit" class="btn" id="submitQuestion" style="display: none"> 

                </div>
                <div id="surveySavingRes" class="surveySavingRes alert alert-success" style="display:none;margin-top:10px"><?php echo Yii::t("translation","Survey_Save_Response"); ?></div>
            </div>
        </div>
    

    
    </form></div></div>
    <div class="row-fluid" style="position:relative" id="streamsectionarea_spinner"></div>
    <div style="display:none" id="streamsectionarea_error">
            <div class="ext_surveybox NPF lineheightsurvey">
                <center class="ndm" id="errorTitle" ></center>
            </div>
        </div>
	</div>
        <div class="streamsectionarea padding8" style="display:none" id="anyothervaluespage"></div>
        </div>
      
        </div>
      </div>
  </div>
 
  <div class="span3" style="margin-left:0; padding-left:0px;"><div class="dashboardbox dashboardboxrightpanel mobileview3">
 <div class="questions_area_left_outer">
 <!-- question catogories -->
<div class="q_catogories">
    <div><span id="hms_timer"></span><span style="display:none" id="hms_timer_hidden"></span><span style="display:none" id="hms_timer_stop"></span></div>
    <script type="text/javascript">
         var TotalTimerDivs={};
          var CategoryDivs=new Array();
        </script>
           <?php
           $Totaltime = 0;
 $k = 0; foreach($CatName as $row){ ?>
   <div class="q_catogories_progress position_R" id="q_categories_<?php echo ($k+1); ?>" data-val="<?php echo ($k+1); ?>" >
       <div class="headerbg_cat">
   	<h3 class="pull-left" data-info="<?php echo ($k+1); ?>"><?php echo $row['CategoryName']; ?></h3> 
        <div class="subject_timer" id="subject_timer_<?php echo ($k+1); ?>">
            <div class="timer"><span id="hms_timer<?php echo ($k+1); ?>"></span><span style="display:none" id="hms_timer<?php echo ($k+1); ?>_hidden"></span><span style="display:none" id="hms_timer<?php echo ($k+1); ?>_stop"></span>
            </div>
            </div>
       </div>
        <div class="clearboth categorydivpadding">
    <table cellpadding="0" cellspacing="0"  border="0" class="categoryQuestions">
       
        <tr>
        <?php //error_log("====noofquestions=====".print_r($row)); 
        for($i=0;$i <$row['NoofQuestions'];$i++){ ?>       
       <?php if($i%5==0){  ?>
        </tr><tr>
             <?php } ?>
            <td class="questionnos" data-activetimer="hms_timer<?php echo ($k+1); ?>_hidden" data-qno="<?php echo $i ?>" data-catid="<?php echo $row['CategoryId']; ?>" data-scheduleid="<?php echo $row['ScheduleId']; ?>"><?php echo ($i+1); ?></td>
            
        
        
            
       <?php   } ?>
        </tr>
     
    </table>
        </div>
    
    
   </div>
     <script type="text/javascript">
         
     $(function(){
                                    $('#hms_timer<?php echo ($k+1); ?>').countdowntimer({
                                        hours : 0,
                                        minutes :0,//<?php echo $row['CategoryTime']; ?>,
                                        seconds : 5,
                                        size : "lg",
					pauseButton : "hms_timer<?php echo ($k+1); ?>_hidden",
					stopButton : "hms_timer<?php echo ($k+1); ?>_stop",
                                        //timeUp:"hms_timer<?php echo ($k+1); ?>"
                                        timeUp : "q_categories_<?php echo ($k+1); ?>"
                                    });
                                    if('#hms_timer<?php echo ($k+1); ?>_stop'!="#hms_timer1_stop"){
                                        $('#hms_timer<?php echo ($k+1); ?>_stop').val("stop").trigger('click');
                                     }
                                    
                                });
                               var TimerDivs=TimerDivs+","+"#hms_timer<?php echo ($k+1); ?>_hidden";
                               var Totaltime = <?php echo $Totaltime = $Totaltime+$row['CategoryTime']; ?>;
                              
                               CategoryDivs.push("q_categories_<?php echo ($k+1); ?>");
                               TotalTimerDivs["q_categories_<?php echo ($k+1); ?>"]="hms_timer<?php echo ($k+1); ?>_hidden";
                              // alert(TotalTimerDivs)
                                </script>
 <?php $k++; } ?>
   
</div>
 <!-- question catogories end -->
</div>
</div></div>


</div>
        
        
    
     <script type="text/javascript">
        //alert(TotalTimerDivs['q_categories_1'])
        var closedCategory=new Array();
        var openCategory=new Array();
         function expiryCategory(divid){
             closedCategory.push(divid)
           //  alert("I am done----"+divid)
             $('#'+divid).css('opacity',0.2);
             $('#'+divid).append("<div class='suspendcontentdiv'></div><div class='suspenddiv'></div>");
             $('#'+divid).removeClass('q_catogories_progress_active');
             openCategory=arr_diff(CategoryDivs,closedCategory);
             if(openCategory.length>0){
              //alert(openCategory[0]+"i am in");
                stopandStartTimer(TotalTimerDivs[openCategory[0]]); 
                getOpenCategoryQuestion(openCategory[0]);
             }else{
                 //alert('timeup')
                //getDone(); 
             }
            
              
         }
         $(document).ready(function() {
             //main timer code
             $(function(){
                                    $('#hms_timer').countdowntimer({
                                        hours : 0,
                                        minutes :Totaltime,//<?php //echo $row['CategoryTime']; ?>,
                                        seconds : 0,
                                        size : "lg",
					pauseButton : "hms_timer_hidden",
					stopButton : "hms_timer_stop",
                                       // timeUp : "q_categories_<?php echo ($k+1); ?>"
                                    });
                                    
                                    
                                });
             //main timer end
           $(".q_catogories div.q_catogories_progress").first().addClass("q_catogories_progress_active");
           doAjax();
             var UserId = 0;
                 var Groupname = "";
                 var isOuter = false;
                 var viewType = 1;
             function doAjax(){     
                 UserId = 0;
                 Groupname = "";
                 
                UserId = '<?php echo $userId; ?>';
                Groupname = '<?php echo $groupName; ?>';
                 isOuter = '<?php echo $outerFlag; ?>';
                viewType = '<?php echo $vType; ?>';
                var sessionTime = '<?php echo $sessionTime?>';
                var testId = '<?php echo $TestId; ?>';
               
                if(isOuter == true || isOuter == 'true'){
                    $("#streamsectionarea").removeClass();
                }
                    // scrollPleaseWait('streamsectionarea_spinner');
                    //alert("UserId="+UserId+"&GroupName="+Groupname+"&viewType="+viewType+"&TestId="+testId)
                 ajaxRequest("/outside/renderQuestionView", "UserId="+UserId+"&GroupName="+Groupname+"&viewType="+viewType+"&TestId="+testId, function(data) {
            renderSurveyView(data)
        }, "html");
             }
             function renderSurveyView(html){  
                $("#streamsectionarea").show();
                $("#questionviewarea").html(html);
        }
            <?php if(isset($this->tinyObject)){ ?>
                $(".streamsectionarea").each(function(){
                    if($(this).attr("id") == "streamsectionarea"){
                        $(this).removeClass("streamsectionarea");
                    }
                });
            <?php } ?>
         });
          <?php 
                $uri = $_SERVER['REQUEST_URI'];
                $uriarr = explode("&",$uri);                
                if(isset($uriarr[2]) && $uriarr[2] == "isOuter=true"){                    
                
            ?>
                    $("#cancelsurveyquestions").hide();
                <?php }else{ ?>
                   $("#cancelsurveyquestions").show();
                <?php } ?>
        function timeisUp(){
           // alert('timeup');
            $('#submitQuestion').attr('disabled','disabled');
        }
        var sureyQuestionPage=2;
        var fromPagiNation=0;
         var fromAutoSave=0;
         var scheduleId = "";
         $("#nextQuestion").live("click",function(){
             fromPagiNation=1;
             fromAutoSave=0;
             gotoNextPage();
//           $("#submitQuestion").trigger("click");
          
           //  alert($("#QuestionsSurveyForm_ScheduleId").attr("value"));
            
         })
          var currentPage=0;   
         $(".questionnos").live("click",function(){   //question by number            
             var $this = $(this);
             
              var activetimerdiv = $this.data("activetimer");
              //alert(activetimerdiv);
              stopandStartTimer(activetimerdiv);
             var scheduleid = $this.data("scheduleid");
             var catid = $this.data("catid");
             var qno = $this.data("qno");
             sureyQuestionPage = qno;
             $("#QuestionsSurveyForm_ScheduleId").val(scheduleid);
             $("#QuestionsSurveyForm_SurveyId").val(catid);
             setGotoPageAjaxCall(scheduleid,catid,qno,"current");
         });
         
         function getOpenCategoryQuestion(divid){
        //  $(".q_catogories div.q_catogories_progress").first().addClass("q_catogories_progress_active");
             //alert("#"+divid+"  .questionnos")
            $("#"+divid+" .questionnos").first().trigger("click",function(){   //question by number            
             var $this = $(this);
              var activetimerdiv = $this.data("activetimer");
               stopandStartTimer(activetimerdiv);
             var scheduleid = $this.data("scheduleid");
             var catid = $this.data("catid");
             var qno = $this.data("qno");
             sureyQuestionPage = qno;
             $("#QuestionsSurveyForm_ScheduleId").val(scheduleid);
             $("#QuestionsSurveyForm_SurveyId").val(catid);
             setGotoPageAjaxCall(scheduleid,catid,qno,"current");
         });
     }
     function getDone(){
         
         $("#submitQuestion").live("click",function(){ alert('--2')
             Garray = new Array();
             isValidate = 0;
             fromAutoSave = 0;
             fromNode = 1;
             fromPagiNation = 0;
             gQcnt = 0;
             notValidate = 0;
             if(autoSaveInterval != null && autoSaveInterval != "undefined"){          
                     clearInterval(autoSaveInterval);
                }
           submitSurvey();
          
        });
     }
         $("#prevQuestion").live("click",function(){
             fromPagiNation=1;
             gotoPreviousPage();            
         });
         
         function gotoPage(){
             var scheduleId = $("#QuestionsSurveyForm_ScheduleId").attr("value");
              var surveyId = $("#QuestionsSurveyForm_SurveyId").attr("value");
              setGotoPageAjaxCall(scheduleId,surveyId,sureyQuestionPage,"next");
              
    }
    function stopandStartTimer(div){
       
        $(TimerDivs).val("pause").trigger('click');
        $('#'+div).val("resume").trigger('click'); 
    }
    function startnext(divid){
        alert(divid+'----'+TimerDivs)
    }
    
    function arr_diff(a1, a2)
{
  var a=[], diff=[];
  for(var i=0;i<a1.length;i++)
    a[a1[i]]=true;
  for(var i=0;i<a2.length;i++)
    if(a[a2[i]]) delete a[a2[i]];
    else a[a2[i]]=true;
  for(var k in a)
    diff.push(k);
  return diff;
}
    function setGotoPageAjaxCall(scheduleid,catid,qno,actiontype){
        var queryString = {"userQuestionTempId":userTempId,"categoryId":catid,"scheduleId":scheduleid,"page":qno,"action":actiontype};
            //ValidateQuestions(1, 1);
              ajaxRequest("/outside/sureyQuestionPagination1", queryString, sureyQuestionPaginationHandler,"html");
    }
              
         function gotoNextPage(){ 
              currentPage++;
              scheduleId = $("#QuestionsSurveyForm_ScheduleId").attr("value");
              var surveyId = $("#QuestionsSurveyForm_SurveyId").attr("value");
//              ValidateQuestions(1, 1);
submitSurvey();
              
         }
         function sureyQuestionPaginationHandler(html){
             sureyQuestionPage++;             
             scrollPleaseWaitClose('surveyviewspinner');
             $("#questionviewarea").html(html);
         }
         function gotoPreviousPage(){
             currentPage--;
             scrollPleaseWait('surveyviewspinner','previous');
             sureyQuestionPage = sureyQuestionPage-2;
              var scheduleId = $("#QuestionsSurveyForm_ScheduleId").attr("value");
              var surveyId = $("#QuestionsSurveyForm_SurveyId").attr("value");
             var queryString = {"userQuestionTempId":userTempId,"categoryId":categoryId,"surveyId":surveyId,"scheduleId":scheduleId,"page":sureyQuestionPage,"action":"previous"};
             ajaxRequest("/outside/sureyQuestionPagination1", queryString, sureyQuestionPaginationHandler,"html");
         }
         
      
         //timer end
         $('#pauseBtnhms1').on('click', function() {
  //  hasTimer = true;
  
        $('#hms_timer_hidden,#hms_timer_hidden1').val("pause").trigger('click');
        $('#hms_timer_hidden1').val("resume").trigger('click');
        // $('#timer1').timer('resume');
         
 });
         
</script>