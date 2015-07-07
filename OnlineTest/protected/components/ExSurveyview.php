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
    <?php error_log("==category===".print_r($CatName,1)); $k = 0; foreach($CatName as $row){ ?>
   <div class="q_catogories_progress position_R" id="q_categories_<?php echo ($k+1); ?>" >
       <div class="headerbg_cat">
   	<h3 class="pull-left" onclick="timechange(<?php echo ($k+1); ?>,<?php echo $row['CategoryTime']; ?>)" data-info="<?php echo ($k+1); ?>"><?php echo $row['CategoryName']; ?></h3> 
        <div class="subject_timer" id="subject_timer_<?php echo ($k+1); ?>">
            <div class="timer"><span class="hour" id="hour_<?php echo ($k+1); ?>">00</span>:<span class="minute" id="minute_<?php echo ($k+1); ?>">00</span>:<span class="second" id="second_<?php echo ($k+1); ?>">00</span>
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
            <td class="questionnos" data-qno="<?php echo $i ?>" data-catid="<?php echo $row['CategoryId']; ?>" data-scheduleid="<?php echo $row['ScheduleId']; ?>"><?php echo ($i+1); ?></td>
            
        
        
            
       <?php   } ?>
        </tr>
     
    </table>
        </div>
    
    
   </div>
 <?php $k++; } ?>
   
</div>
 <!-- question catogories end -->
</div>
</div></div>


</div>
        
        
    
     <script type="text/javascript">
          var timer;
          var g_timer1;
          var g_timer2;
          var g_timer3;
           var timeleft = '600';
         $(document).ready(function() {
           // alert('1')
           $(".q_catogories div.q_catogories_progress").first().addClass("q_catogories_progress_active");
           $("#subject_timer_1").find("*").prop("disabled", false);
           //$(".q_catogories div.q_catogories_progress div.subject_timer span").first().attr("disabled":"false");
           timedisplay(1);
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
             var scheduleid = $this.data("scheduleid");
             var catid = $this.data("catid");
             var qno = $this.data("qno");
             sureyQuestionPage = qno;
             $("#QuestionsSurveyForm_ScheduleId").val(scheduleid);
             $("#QuestionsSurveyForm_SurveyId").val(catid);
             setGotoPageAjaxCall(scheduleid,catid,qno,"current");
         });
         $("#prevQuestion").live("click",function(){
             fromPagiNation=1;
             gotoPreviousPage();            
         });
         
         function gotoPage(){
             var scheduleId = $("#QuestionsSurveyForm_ScheduleId").attr("value");
              var surveyId = $("#QuestionsSurveyForm_SurveyId").attr("value");
              setGotoPageAjaxCall(scheduleId,surveyId,sureyQuestionPage,"next");
              
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
              ValidateQuestions(1, 1);
              
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
         
         //timer code
         function timechange(catno,qtime){
            var $this = $(this);
            var timer1;
            
            var timeleft1 = qtime;
            //alert($(this).class)
             $(".q_catogories div.q_catogories_progress").removeClass("q_catogories_progress_active");
             $("#q_categories_"+catno).addClass("q_catogories_progress_active");
            $("#q_categories_"+catno).parent("div.q_catogories_progress").addClass("q_catogories_progress_active");
            $("#subject_timer_"+catno).find("*").prop("disabled", true);
           // $("#q_categories_"+catno).next("div.subject_timer span").attr("disabled","false");
            // $("#q_categories_"+catno+" div.subject_timer").first().attr("disabled":"false");
           //$("#q_categories_"+catno).children("div.subject_timer").attr("disabled":false);
             timedisplay(catno);
         }
         function timedisplay1(qn,timer1,qtime){
        //   timer1 =    setInterval(function(){checktime1(qn,timer1,qtime)},1000);
          
         }
         
        function timedisplay(qn){
            setInterval(function(){checktime(qn)},1000);
          
         }
    function checktime(qn) {
        if(timeleft>=0){
            var seconds = Math.round(timeleft);
            var minutes = Math.floor(seconds/60);
            seconds = seconds - (minutes*60);
            var hours = Math.floor(minutes/60);
            minutes = minutes - (hours*60);
            
            if(seconds>=10){seconds = seconds;}else{seconds = '0'+seconds;};
            if(minutes>=10){minutes = minutes;}else{minutes = '0'+minutes;};
            if(hours>=10){hours = hours;}else{hours = '0'+hours;};

            $('#hour_'+qn).html(hours);
            $('#minute_'+qn).html(minutes);
            $('#second_'+qn).html(seconds);
            timeleft-=1;
            
        }else{
           clearInterval(timer);
           //alert('test has been completed');
           //alert('Your test time completed, test closed automatically');
           
        }
    } 
    
    function checktime1(qn,timer1,qtime) {
        if(qtime>=0){
          
            var seconds = Math.round(qtime);
            var minutes = Math.floor(seconds/60);
            seconds = seconds - (minutes*60);
            var hours = Math.floor(minutes/60);
            minutes = minutes - (hours*60);
            
            if(seconds>=10){seconds = seconds;}else{seconds = '0'+seconds;};
            if(minutes>=10){minutes = minutes;}else{minutes = '0'+minutes;};
            if(hours>=10){hours = hours;}else{hours = '0'+hours;};

            $('#hour_'+qn).html(hours);
            $('#minute_'+qn).html(minutes);
            $('#second_'+qn).html(seconds);
            qtime-=1;
            
        }else{
           clearInterval(timer1);
           //alert('test has been completed');
           //alert('Your test time completed, test closed automatically');
           
        }
    } 
         //timer end
         
</script>