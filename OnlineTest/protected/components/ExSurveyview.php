


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
    </div>

    </div>
    </form>
    <div class="row-fluid" style="position:relative" id="streamsectionarea_spinner"></div>
    <div style="display:none" id="streamsectionarea_error">
            <div class="ext_surveybox NPF lineheightsurvey">
                <center class="ndm" id="errorTitle" ></center>
            </div>
        </div>
	</div>
        <div class="streamsectionarea padding10" style="display:none" id="anyothervaluespage"></div>
        
        
        
        
    
     <script type="text/javascript">
                     
         $(document).ready(function() {
            
            doAjax();
             var UserId = 0;
                 var Groupname = "";
                 var isOuter = false;
                 var viewType = 2;
             function doAjax(){     
                 UserId = 0;
                 Groupname = "";
                 
                UserId = '<?php echo $userId; ?>';
                Groupname = '<?php echo $groupName; ?>';
                 isOuter = '<?php echo $outerFlag; ?>';
                viewType = '<?php echo $vType; ?>';
                var sessionTime = '<?php echo $sessionTime?>';
                
                if(isOuter == true || isOuter == 'true'){
                    $("#streamsectionarea").removeClass();
                }
                     scrollPleaseWait('streamsectionarea_spinner');
                 ajaxRequest("/outside/renderQuestionView", "UserId="+UserId+"&GroupName="+Groupname+"&viewType="+viewType, function(data) {
            renderSurveyView(data)
        }, "html");
             }
             function renderSurveyView(html){  
              scrollPleaseWaitClose('streamsectionarea_spinner');
             var strArr = html.split("_"); 
             if($.trim(strArr[0]) == "LoadReports" || $.trim(strArr[0]) == "NotScheduled"){ 
                $("#questionviewwidget").hide();
                $("#streamsectionarea_error").show();
                if($.trim(strArr[0]) == "NotScheduled")
                    $("#errorTitle").html('<?php echo Yii::t("translation","Ex_Msg_Noschedules"); ?>');
                else{
                    $("#streamsectionarea").show();
                    $("#errorTitle").html("<?php echo $_GET['groupName']; ?> Analytics");
                    var scheduleId = strArr[1];
                    ajaxRequest("/extendedSurvey/surveyAnalytics","ScheduleId="+scheduleId,surveyAnalticsHandler)
                }
            } else if(!$.isNumeric(html)){            
                 $("#questionviewwidget,#streamsectionarea,#surveysubmitbuttons").show();
                 $("#streamsectionarea_error").hide();
                 
                $("#questionviewarea").html(html);
               
   
            }  else {
                $("#questionviewwidget").hide();
                $("#streamsectionarea_error").show();
                $("#errorTitle").html("Sorry, Please check UserId or Group Name.")
            }
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
            $("#submitQuestion").trigger("click");
          
           //  alert($("#QuestionsSurveyForm_ScheduleId").attr("value"));
            
         })
         $("#prevQuestion").live("click",function(){
             fromPagiNation=1;
          gotoPreviousPage();
           //  alert($("#QuestionsSurveyForm_ScheduleId").attr("value"));
            
         })
         function gotoNextPage(){ 
              if(autoSaveInterval != null && autoSaveInterval != "undefined"){
                     clearInterval(autoSaveInterval);
                }
             scrollPleaseWait('surveyviewspinner');
             scrollPleaseWait('surveyviewspinner');   
              var scheduleId = $("#QuestionsSurveyForm_ScheduleId").attr("value");
              var surveyId = $("#QuestionsSurveyForm_SurveyId").attr("value");
             var queryString = {"surveyId":surveyId,"scheduleId":scheduleId,"page":sureyQuestionPage,"action":"next"};
       // alert(queryString);      
              ajaxRequest("/outside/sureyQuestionPagination", queryString, sureyQuestionPaginationHandler,"html");
         }
         function sureyQuestionPaginationHandler(html){
             //alert(data);                
             sureyQuestionPage++;
             scrollPleaseWaitClose('surveyviewspinner');
             $("#questionviewarea").html(html);
         }
         function gotoPreviousPage(){
             scrollPleaseWait('surveyviewspinner','previous');
             sureyQuestionPage = sureyQuestionPage-2;
              var scheduleId = $("#QuestionsSurveyForm_ScheduleId").attr("value");
              var surveyId = $("#QuestionsSurveyForm_SurveyId").attr("value");
             var queryString = {"surveyId":surveyId,"scheduleId":scheduleId,"page":sureyQuestionPage,"action":"previous"};
              ajaxRequest("/outside/sureyQuestionPagination", queryString, sureyQuestionPaginationHandler,"html");
         }
         
</script>