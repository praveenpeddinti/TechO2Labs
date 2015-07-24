<script type="text/javascript">
var TotalTimerDivs={};
         var CategoryIdwithCategory={};
          var CategoryDivs=new Array();
          var CategoryIdArray=new Array();
          var qn = 0;
          var TimerDivs = "";
          var CategoryDivsID ="";
          var Totaltime = "";
</script>
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
         
    </div> <div class=" alignright" id="surveyviewspinner" style="position:relative;"></div> 
        <div id="pagenoforsurvey" style="display: none;text-align: right;padding-right:5px" class="pagination pagination-mini"></div>
        <div class="row-fluid surveybuttonarea">
            <div class="span8">
                
                <div id="userviewErrMessage" class="alert alert-error errorMessage" style="display: none;"></div>                
            </div>
            <div class="span4">
                
                <div class=" alignright" id="surveysubmitbuttons" style="display:none">
                    
                      <input type="button" value="Previous" name="previous" class="btn" id="prevQuestion" style="display: none"> 
                     <input type="button" value="Next" name="next" class="btn" id="nextQuestion" style="display: none"> 
                      <input type="button" value="I'm done" name="commit" class="btn" id="submitQuestion" style="display: none"> 

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
<div class="q_catogories" id="allcategories">
   
   
</div>
 <!-- question catogories end -->
</div>
</div></div>


</div>

    
     <script type="text/javascript">
        
        var closedCategory=new Array();
        var openCategory=new Array();
        var userTempId="";
         function expiryCategory(divid){
             if(divid=='timeisup'){
                 Garray = new Array();
             isValidate = 0;
             fromAutoSave = 0;
             fromNode = 1;
             fromPagiNation = 0;
             gQcnt = 0;
             notValidate = 0;
            
            savePresAnswersForQuestions(0,0)
             }else{
             closedCategory.push(divid)
           //  alert("I am done----"+divid)
             $('#'+divid+" .categorydivpadding" ).css('opacity',0.2);
             $('#'+divid).append("<div class='suspendcontentdiv'></div><div class='suspenddiv'></div>");
             
             openCategory=arr_diff(CategoryDivs,closedCategory);
             if(openCategory.length>0){
              //alert(openCategory[0]+"i am in");
          
               activeCategoryDiv(openCategory[0])
                stopandStartTimer(TotalTimerDivs[openCategory[0]]); 
                savePresAnswersForQuestions(1,1);
                getOpenCategoryQuestion(openCategory[0]);
                
             }else{
                  savePresAnswersForQuestions(0);
                 

             }
             
              
            
        }   
         }
         
   
         
         $(document).ready(function() {
             //main timer code
           
             //main timer end
           
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
            $("#streamsectionarea").show();   
                $("#questionviewarea").html(data);  
        }, "html");
             }
             function renderCategoriesView(html){
                 $("#allcategories").html(html);
                 //alert(html)
                 
             }
             renderSurveyView('<?php echo $userId; ?>','<?php echo $TestId; ?>')
             function renderSurveyView(UserId,testId){  
                 ajaxRequest("/outside/renderCategories", "UserId="+UserId+"&TestId="+testId, function(data) {
                    renderCategoriesView(data)
                     doAjax();
                }, "html");
                             
                
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
            
            
            $('#submitQuestion').attr('disabled','disabled');
           
        }
        var sureyQuestionPage=2;
        var fromPagiNation=0;
         var fromAutoSave=0;
          var fromAutoSave=0;
         var scheduleId = "";
         var finalDone = 0;
         $("#nextQuestion").live("click",function(){
             //alert("&&");
             openCategory=arr_diff(CategoryDivs,closedCategory);
             fromPagiNation=1;
             fromAutoSave=0;
             finalDone = 0;
             gotoNextPage();
             //alert("$$$$");
//           $("#submitQuestion").trigger("click");
          
           //  alert($("#QuestionsSurveyForm_ScheduleId").attr("value"));
            
         });
          var currentPage=0;   
         $(".questionnos").live("click",function(){   //question by number            
             var $this = $(this);
             //$("#"+questionActiveID).css("background-color", "");
//             if ($("#"+questionActiveID).css('background-color') == 'green') {
//              $("#"+questionActiveID).css("background-color", "green");   
//             }else{
//                $("#"+questionActiveID).css("background-color", ""); 
//             }
             $(".questionnos").removeClass("active");
                previousValidation();
                savePresAnswersForQuestions(1,1);
             //$this.addClass("active");
//              var activetimerdiv = $this.data("activetimer");
//              //alert(activetimerdiv);
//              stopandStartTimer(activetimerdiv);
             var scheduleid = $this.data("scheduleid");
             var catid = $this.data("catid");
             var qno = $this.data("qno");
             sureyQuestionPage = qno;
             $("#QuestionsSurveyForm_ScheduleId").val(scheduleid);
             $("#QuestionsSurveyForm_SurveyId").val(catid);
             qn = Number($("#q_categories_"+qno).attr("data-val"))+1;
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
   
         $("#prevQuestion").live("click",function(){
             fromPagiNation=1;
             finalDone = 0;
             previousValidation();
              savePresAnswersForQuestions(1,1)
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
      function activeCategoryDiv(div){

        $(CategoryDivsID).removeClass("q_catogories_progress_active");
        $('#'+div).addClass("q_catogories_progress_active"); 
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
             $("#qno_"+currentPage).addClass("completed");
//              ValidateQuestions(1, 1);
                      submitSurvey();
              
         }
         function sureyQuestionPaginationHandler(html){//alert("hand");
             sureyQuestionPage++;             
             scrollPleaseWaitClose('surveyviewspinner');
             $("#questionviewarea").html(html);
         }
         function gotoPreviousPage(){
             currentPage--;
             previousValidation();
             scrollPleaseWait('surveyviewspinner','previous');
              $("#qno_"+currentPage).addClass("completed");
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
         
         
         $(window).unload(function(){
     savePresAnswersForQuestions(1,1);
}); 
</script>
