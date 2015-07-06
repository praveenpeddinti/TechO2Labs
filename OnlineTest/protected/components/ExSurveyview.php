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
    <?php error_log("==category===".print_r($CatName,1)); foreach($CatName as $row){ ?>
   <div class="q_catogories_progress_active position_R">
       <div class="headerbg_cat">
   	<h3 class="pull-left"><?php echo $row['CategoryName']; ?></h3> 
        <div class="subject_timer">00:30:60</div>
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
    
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
    	<tr>
        	<!--<td style=" text-align:right;padding-right:5px"><img src="/images/time_h.png" width="52" height="52"></td>
            <td style="text-align:left; padding-left:5px"><img src="/images/time_s.png" width="52" height="52"></td>-->
        </tr>
    </table>
   </div>
 <?php } ?>
   
</div>
 <!-- question catogories end -->
</div>
</div></div>


</div>
        
        
    
     <script type="text/javascript">
                     
//                     $(document).ready(function(){
//                         
//                     });
                     
         $(document).ready(function() {
           // alert('1')
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
//              scrollPleaseWaitClose('streamsectionarea_spinner');
//             var strArr = html.split("_"); 
//             if($.trim(strArr[0]) == "LoadReports" || $.trim(strArr[0]) == "NotScheduled"){ 
//                $("#questionviewwidget").hide();
//                $("#streamsectionarea_error").show();
//                if($.trim(strArr[0]) == "NotScheduled")
//                    $("#errorTitle").html('<?php echo Yii::t("translation","Ex_Msg_Noschedules"); ?>');
//                else{
//                    $("#streamsectionarea").show();
//                    $("#errorTitle").html("<?php echo $_GET['groupName']; ?> Analytics");
//                    var scheduleId = strArr[1];
//                    ajaxRequest("/extendedSurvey/surveyAnalytics","ScheduleId="+scheduleId,surveyAnalticsHandler)
//                }
//            } else if(!$.isNumeric(html)){            
//                 $("#questionviewwidget,#streamsectionarea,#surveysubmitbuttons").show();
//                 $("#streamsectionarea_error").hide();
                 $("#streamsectionarea").show();
                $("#questionviewarea").html(html);
               
   
//            }  else {
//                $("#questionviewwidget").hide();
//                $("#streamsectionarea_error").show();
//                $("#errorTitle").html("Sorry, Please check UserId or Group Name.")
//            }
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
              var scheduleId = $("#QuestionsSurveyForm_ScheduleId").attr("value");
              var surveyId = $("#QuestionsSurveyForm_SurveyId").attr("value");
              var queryString = {"userQuestionTempId":userTempId,"categoryId":categoryId,"scheduleId":scheduleId,"page":sureyQuestionPage,"action":"next"};
              ValidateQuestions(1, 1);
              ajaxRequest("/outside/sureyQuestionPagination1", queryString, sureyQuestionPaginationHandler,"html");
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
         
</script>