<?php 
include 'pageAnalytics.php';
if(is_object($surveyObj)){  ?>
<script type="text/javascript">
    var QuestionIds = "";
    
    var dataGroupName = "";
    var dataSurveyId = "";
    var dataScheduleid = "";
</script>
<div class="padding10ltb">
  
     
     <div class="row-fluid">
         <div class="span12">
             <div class="span6"><h2 class="pagetitle"><?php echo Yii::t('translation', 'AdminMarketResearch'); ?></h2></div>             
             <div class="span1">
             <div class="s_analyticsexport s_analyticsexport_global">
              <ul class="anlt_datepic liststylenone">
              <li class="dropdown analytics_export_opt" style="cursor:pointer; position: relative">
                                    <a id="drop2" data-toggle="dropdown" class="tooltiplink analytics_export " data-placement="bottom" rel="tooltip" data-original-title="<?php echo Yii::t('translation', 'Advanced_Options'); ?>"><i><img src="/images/system/spacer.png"><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>

                                            <li class=""><a name="ActivityPdf" id="ActivityPdf" target="_blank" onclick="openAnalyticspdfforall()"><i><img class="pdf_doc" src="/images/system/spacer.png"></i> <?php echo Yii::t('translation', 'Export_as_PDF'); ?></a></li>
                                            <li class=""><a style="cursor:pointer" id="genereateXlsforAll"><i><img class="excel_doc" src="/images/system/spacer.png"></i> <?php echo Yii::t('translation', 'Export_as_Excel'); ?></a></li>

                                        </ul>

                                    </div>
                                  </li>
              </ul>
          </div>
             </div>
             
             <div class="span4">
                 <div class="pull-right">
                 <div class="networkmode" data-surveyid="<?php echo $surveyObj->_id; ?>" data-groupname="<?php echo $surveyObj->SurveyRelatedGroupName; ?>"> 
                   <input type="checkbox" id="analyticsswitch" data-on-label="Schedule Level" data-off-label="Bundle Level" />
                </div>
                 </div>
             </div>
             <div class="span1">
                 <div class="grouphomemenuhelp alignright tooltiplink"> <a  id="detailed_close_page_survey" class="detailed_close_page" rel="tooltip"  data-original-title="close" data-placement="bottom" data-toggle="tooltip"> <i class="fa fa-times"></i></a> </div>
             </div>
         </div>
     </div>   
    <div class="market_profile marginT10">
        
	<div class="m_profileicon">
            
            <div class="pull-left marginzero generalprofileicon  skiptaiconwidth190x190 generalprofileiconborder5 noBackGrUp">
                            
                            <div class="positionrelative editicondiv editicondivProfileImage no_border editicondivProfileImagelarge skiptaiconinner ">
                                
                                <div style="display: none;" class="edit_iconbg ">
                                    <div id="UserProfileImage"><div class="qq-uploader"><div class="qq-upload-button" style="position: relative; overflow: hidden; direction: ltr;">Upload a file<input type="file" multiple="multiple" capture="camera" name="file" style="position: absolute; right: 0px; top: 0px; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;"></div></div></div>


                                    
                                </div>
<!--                                <img id="profileImagePreviewId" src="" alt="" />-->
                               <img alt="" src="<?php echo $surveyObj->SurveyLogo; ?>" id="profileImagePreviewId">
                            </div>
                
                            <div><ul id="uploadlist_logo" class="qq-upload-list"></ul></div>
                        </div></div>
                        
	   	 <div class="row-fluid padding-bottom5 padding-top35 mobilepadding-top35 ">
                    <div class="span12">
                    <div class="ext_surveyTitle"><?php echo $surveyObj->SurveyTitle; ?></div>
                     <?php if($surveyObj->SurveyRelatedGroupName != "0"){?><div class="ext_groupTitle  padding8top"><?php echo $surveyObj->SurveyRelatedGroupName; ?></div> <?php } ?> 
                     <div class="extcontent padding8top"><?php echo $surveyObj->SurveyDescription; ?> </div>
                    </div>
                    </div>
        
               <div class="row-fluid">
            <div class="span12">
                <div class="span4" id="schedule_dates"><span class="g_scheduleDate g_scheduleDateGameWall s_scheduleDateGameWall"><?php echo $sdate; ?></span> </div>
                <div class="span8">
                    <div class="media-status_survey">
                        <ul >
                        <li class="detailed"><div class="statusminibox extquestionscount">
                                <span class="tooltiplink" data-original-title="<?php echo Yii::t('translation', 'Survey_TotalQuestions'); ?>" rel="tooltip" data-placement="bottom"><?php echo $surveyObj->QuestionsCount; ?></span>
                            </div>
                            </li>
                             <li class="detailed"><div class="statusminibox extuserscount">
                               <span class="tooltiplink" id="totaluserssurveytaken" data-original-title="<?php echo Yii::t('translation', 'Survey_TotalSurveyUsers'); ?>" rel="tooltip" data-placement="bottom"><?php echo (sizeof($scheduleObject->SurveyTakenUsers)+sizeof($scheduleObject->ResumeUsers)); ?></span>
                            </div></li>
                      
                            
                              <li class="detailed"><div class="statusminibox "  >
                              
                               <ul class="time_spent">
	<li class="total_timespent tooltiplink" data-original-title="<?php echo Yii::t('translation', 'Survey_TotalSurveySpentTime'); ?>" rel="tooltip" data-placement="bottom" id="totalTimeSpentMainDiv"><?php echo $totalTimeSpent?></li>
    <li class="avg_timespent tooltiplink" data-original-title="<?php echo Yii::t('translation', 'Survey_AvgSurveySpentTime'); ?>" rel="tooltip" data-placement="bottom" id="avgTimeSpentMainDiv"><?php echo $avgtimeSpent; ?></li>
</ul>
                            </div></li>
                            
                    </ul></div>
                </div>
                
          </div> 
        </div>            
    
     </div>
     
     
<!--     <div class="row-fluid groupseperator border-bottom">
     <div class="span12 "><h2 class="pagetitle paddingleft5">Market Research Survey </h2></div>
     </div>-->
     <div id="surveyviewspinner" style="position:relative;"></div>
       <div class="padding152010" style="">
         <div class="surveyquestionsbox" id="surveyquestionbox_-2" >
      
     <div class="surveyareaheader surveyareaheader_analytics" >
         <div class="s_analytics_numbers"></div>
         <div  class="positionrelative" ></div>
            <div id="quesiton_SurveyUsersPieChat" class="s_analytics_question" ><?php echo Yii::t('translation', 'Survey_UserChart'); ?></div>   
            <div id="spinner_analytics_SurveyUsersPieChat" class="positionrelative" ></div>
<div class="s_analyticsexport">
              <ul class="anlt_datepic liststylenone" >
              <li style="cursor:pointer; position: relative" class="dropdown analytics_export_opt">
                                    <a data-original-title="<?php echo Yii::t('translation', 'Advanced_Options'); ?>" rel="tooltip" data-placement="bottom" class="tooltiplink analytics_export " data-toggle="dropdown" id="drop2"><i><img src="/images/system/spacer.png" ><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>

                                            <li class="" ><a onclick="openAnalyticspdf(this,'','SurveyUsersPieChat', -2, 1)"  target="_blank"  id="ActivityPdf" name="ActivityPdf"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> <?php echo Yii::t('translation', 'Export_as_PDF'); ?></a></li>
                                            <li class="" ><a data-groupname="<?php echo $surveyObj->SurveyRelatedGroupName; ?>" data-surveyid="<?php echo $surveyObj->_id; ?>" data-questiontype="<?php echo $question['QuestionType']; ?>" data-scheduleid="<?php echo $scheduleId; ?>" data-questionid="<?php echo $question['QuestionId']; ?>" data-id="<?php echo $i; ?>" data-type="SurveyUsersPieChat" id="genereateXls" style="cursor:pointer" ><i><img src="/images/system/spacer.png" class="excel_doc"></i> <?php echo Yii::t('translation', 'Export_as_Excel'); ?></a></li>

                                        </ul>

                                    </div>
                                  </li>
              </ul>
          </div>
          
    
     </div>
     <div class="surveyanswerarea">
     <div class="paddingtblr1030">
     
     <div class="tab_1">
         <div class="row-fluid">
             
           
             <div class="span8">
                 <div class="answersection1 answersection1analytics" >
                    <div id="SurveyUsersPieChat" style="height: 400px"></div>
                </div>
             </div>
             <div class="span4">
                 <div class="customtable">
                     <div class="customheader">
                         <div class="customcolumns"><?php echo Yii::t('translation', 'Survey_Users') ?></div>
                          <div class="customcolumns aligncenter"><?php echo Yii::t('translation', 'Survey_Count') ?></div>
                         
                     </div>
                     <div  class="customgroup">
                     
                         <div class="customrows">
                                     <div class="customcolumns"><?php echo Yii::t('translation', 'SurveyCompletedUsers_Label') ?></div>                                     
                                     <div class="customcolumns" style="text-align: center">
                                         <div class="completedUsers boolean_followup tooltiplink" data-surveyid="<?php echo $surveyObj->_id; ?>" data-scheduleid="<?php echo $scheduleId; ?>" data-original-title="<?php echo Yii::t('translation', 'Survey_ClickCompletedUsers'); ?>" rel="tooltip" data-placement="bottom" id="completedusers_bu"><?php echo sizeof($scheduleObject->SurveyTakenUsers); ?></div>
                                     </div>
                        </div>
                         <div class="customrows">
                                     <div class="customcolumns"><?php echo Yii::t('translation', 'SurveyAbandonedUsers_Label') ?></div>
                             <div class="customcolumns" style="text-align: center">
                                 <div class="abandonedUsers boolean_followup tooltiplink" data-surveyid="<?php echo $surveyObj->_id; ?>" data-scheduleid="<?php echo $scheduleId; ?>" data-original-title="<?php echo Yii::t('translation', 'Survey_ClickAbondonedUsers'); ?>" rel="tooltip" data-placement="bottom" id="abandonedusers_bu"><?php echo sizeof($scheduleObject->ResumeUsers); ?></div>
                             </div>
                    </div>
                     
                      <div class="customrowsfooter" >
                           <div class="customcolumns">Total</div>
                    <div class="customcolumns" style="text-align: center" id="totalusersattempted"><?php echo (sizeof($scheduleObject->SurveyTakenUsers)+sizeof($scheduleObject->ResumeUsers)); ?></div>

                     </div>
                    
                 </div>
             </div>
           
         </div>
      
     
     
     
     </div>
     </div>
     </div>
          
     </div>
     
         </div> 
     
     
     
     <div class="padding152010" style="">
         <div class="surveyquestionsbox" id="surveyquestionbox_-1" >
      
     <div class="surveyareaheader surveyareaheader_analytics" >
         <div class="s_analytics_numbers"></div>
         <div  class="positionrelative" ></div>
            <div id="quesiton_SurveyPagesBarChat" class="s_analytics_question" ><?php echo Yii::t('translation', 'Survey_PageAnalytics'); ?></div> 
            <div id="spinner_analytics_SurveyPagesBarChat" class="positionrelative" ></div>
          <div class="s_analyticsexport">
              <ul class="anlt_datepic liststylenone" >
              <li style="cursor:pointer; position: relative" class="dropdown analytics_export_opt">
                                    <a data-original-title="<?php echo Yii::t('translation', 'Advanced_Options'); ?>" rel="tooltip" data-placement="bottom" class="tooltiplink analytics_export " data-toggle="dropdown" id="drop2"><i><img src="/images/system/spacer.png" ><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>

                                            <li class="" ><a onclick="openAnalyticspdf(this,'','SurveyPagesBarChat', -1, 1)"  target="_blank"  id="ActivityPdf" name="ActivityPdf"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> <?php echo Yii::t('translation', 'Export_as_PDF'); ?></a></li>
                                            <li class="" ><a data-groupname="<?php echo $surveyObj->SurveyRelatedGroupName; ?>" data-surveyid="<?php echo $surveyObj->_id; ?>" data-questiontype="<?php echo $question['QuestionType']; ?>" data-scheduleid="<?php echo $scheduleId; ?>" data-questionid="<?php echo $question['QuestionId']; ?>" data-id="<?php echo $i; ?>" data-type="SurveyPagesBarChat" id="genereateXls" style="cursor:pointer" ><i><img src="/images/system/spacer.png" class="excel_doc"></i> <?php echo Yii::t('translation', 'Export_as_Excel'); ?></a></li>

                                        </ul>

                                    </div>
                                  </li>
              </ul>
          </div>
          
    
     </div>
     <div class="surveyanswerarea">
     <div class="paddingtblr1030">
     
     <div class="tab_1">
         <div class="row-fluid">
             
           
             <div class="span8">
                 <div class="answersection1 answersection1analytics" >
                    <div id="SurveyPagesBarChat" style="height: 400px"></div>
                </div>
             </div>
             <div class="span4">
                 <div class="customtable">
                     <div class="customheader">
                         <div class="customcolumns"><?php echo Yii::t('translation', 'Survey_PageNumber'); ?></div>
                         <div class="customcolumns aligncenter"><?php echo Yii::t('translation', 'Survey_TimeSpent'); ?></div>
                      <div class="customcolumns"><?php echo Yii::t('translation', 'Survey_Percentage'); ?></div>
                        

                       
                         
                     </div>
                     <div  class="customgroup" id="pageAnalyticsDiv">
                     
                        
                         
                        <?php                        
                        foreach ($PagesAnalyticsNativeData["PagesAnalyticsData"] as $value) {
                                        // print_r($value)
                                     ?>
                         <div class="customrows">
                                     <div class="customcolumns"><?php echo $value["PageNumber"] ?></div>

                                     <div class="customcolumns aligncenter"><?php echo $value["timeSpentString"] ?></div>
                                      <div class="customcolumns" style="text-align: center"><?php
                                      
                        $percentage = ($value["PageTimeSpentInSeconds"]/$PagesAnalyticsNativeData["totalTimeSpent"])*100;
                       $percentage = round($percentage,2);
                                      
                                      
                                      echo $percentage."%" ?></div>
                        </div>
<?php } ?> 
                         
                         
                    </div>
                     
                      <div class="customrowsfooter" >

                         <div class="customcolumns"><?php echo Yii::t('translation', 'Survey_Total'); ?></div>                          
                         <div class="customcolumns aligncenter" id="totalTimeSpentDiv"><?php echo $PagesAnalyticsNativeData["totalTimeSpentString"] ?></div>
                         <div class="customcolumns"></div>
                     </div>
                    
                 </div>
             </div>
           
         </div>
      
     
     
     
     </div>
     </div>
     </div>
          
     </div>
     
         </div>
     
     
    
    
     <div class="padding152010" style="">
        <?php $i = 1; foreach($surveyObj->Questions as $question){ ?>
         <script type="text/javascript">
             var QuestionIds = QuestionIds+"<?php echo $question['QuestionId']; ?>_";
             var QuestionTypeVal = "<?php echo $question['QuestionType']; ?>";
             
             var dataGroupName = dataGroupName+"<?php echo $surveyObj->SurveyRelatedGroupName; ?>_";
             var dataSurveyId = dataSurveyId+"<?php echo $surveyObj->_id; ?>_";
             var dataScheduleid = dataScheduleid+"<?php echo $scheduleId; ?>_";            
             
             
         </script>
         <div class="surveyquestionsbox" id="surveyquestionbox_<?php echo $question['QuestionId']; ?>" >
      
     <div class="surveyareaheader surveyareaheader_analytics" >
         <div class="s_analytics_numbers" id="adminAna_qNo_<?php echo $question['QuestionId']; ?>"> <?php echo "$i)"; ?></div>
         <div id="spinner_analytics_<?php echo $question['QuestionId']; ?>" class="positionrelative" ></div>
         <div class="s_analytics_question" id="quesiton_<?php echo $question['QuestionId']; ?>"><?php echo $question['Question']; ?>  <?php if($question['IsMadatory']==1){ ?> <sup class="mandatory-red"><i class="fa fa-asterisk"></i></sup><?php }?></div>   
          <div class="s_analyticsexport">
         
          </div>
          
    
     </div>
     <div class="surveyanswerarea">
     <div class="paddingtblr1030">
     
     <div class="tab_1">
         <div class="row-fluid">
             
             <?php if ($question['QuestionType'] != 3 && $question['QuestionType'] != 4 && $question['QuestionType'] != 6){ ?>
             <div class="span8">
                 <div class="answersection1 answersection1analytics" >
                    <div id="surveyChart_<?php echo $question['QuestionId']; ?>" style='height: 400px;'></div>
                </div>
             </div>
             <div class="span4">
                 <div class="customtable">
                     <div class="customheader">
                         <div class="customcolumns aligncenter"><?php echo Yii::t('translation', 'Survey_OptionName'); ?></div>
                          <div class="customcolumns aligncenter"><?php echo Yii::t('translation', 'Survey_AnsweredCount'); ?></div>
                          <div class="customcolumns aligncenter"><?php echo Yii::t('translation', 'Survey_Percentage'); ?></div>
                          <?php if($question['QuestionType'] == 8) {?>
                           <div class="customcolumns">  </div>
                          <?php }?>
                         
                     </div>
                     <div id="table_row_<?php echo $question['QuestionId']; ?>" class="customgroup">
                     
                    </div>
                     
                      <div class="customrowsfooter" id="table_footer_<?php echo $question['QuestionId']; ?>">
                        
                     </div>
                    
                     
                     
                     
                
                     
                     
                     
                     
                     
                     
                 </div>
               
             </div>
             <?php } ?>
                 <?php if ($question['QuestionType'] == 6 ){ ?>
             <div class="span8">
                 <div class="answersection1 answersection1analytics" >
                    <div id="surveyChart_<?php echo $question['QuestionId']; ?>" style='height: 400px;'></div>
                </div>
             </div>
             <div class="span4">
                 <div class="customtable">
                     <div class="customheader">
                         <div class="customcolumns aligncenter"><?php echo Yii::t('translation', 'Survey_Users'); ?></div>
                          <div class="customcolumns aligncenter"><?php echo Yii::t('translation', 'Survey_Count'); ?></div>
                          <div class="customcolumns aligncenter"><?php echo Yii::t('translation', 'Survey_Percentage'); ?></div>
                          <?php if($question['QuestionType'] == 8) {?>
                           <div class="customcolumns">  </div>
                          <?php }?>
                         
                     </div>
                     <div id="table_row_<?php echo $question['QuestionId']; ?>" class="customgroup">
                     
                    </div>
                     
                      <div class="customrowsfooter" id="table_footer_<?php echo $question['QuestionId']; ?>">
                        
                     </div>
                    
                     
                     
                     
                
                     
                     
                     
                     
                     
                     
                 </div>
               
             </div>
             <?php } ?>
             
             
             
                </div>
         <?php if ($question['QuestionType'] == 3 || $question['QuestionType'] == 4){ ?>
         <div class="row-fluid">
         <div class="span10">
                 <div class="answersection1 answersection1analytics" >
                    <div id="surveyChart_<?php echo $question['QuestionId']; ?>" style='height: 400px;'></div>
                </div>
             </div>
             </div>
         <div class="row-fluid padding8top">             
             <div class="span8">
                 <div class="customtable customtable_ratrank">
                     <div class="customheader" id="table_head_<?php echo $question['QuestionId']; ?>">
                        
                         
                     </div>
                     <div  class="customgroup" id="table_tr_<?php echo $question['QuestionId']; ?>">
                     
                    </div>
                     
                      
                    
                 </div>
             </div>
         </div>
         <?php } ?>
     
     
     
     </div>
     </div>
     </div>
          
     </div>
     <?php $i++;} ?>  
     </div>
     
</div>




     <script type="text/javascript">  
        setTimeout(function(){
         drawUsersPieChart("<?php echo sizeof($scheduleObject->SurveyTakenUsers)?>","<?php echo sizeof($scheduleObject->ResumeUsers)?>");   
        },100)

     drawPagesBarChart(<?php echo $PagesAnalyticsData ?>);
     // google.setOnLoadCallback(drawChart);
      function drawUsersPieChart(surveyTakenUsers,resumeUsers) {          
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['<?php echo Yii::t('translation', 'SurveyCompletedUsers_Label') ?>',  Number(surveyTakenUsers)],
          ['<?php echo Yii::t('translation', 'SurveyAbandonedUsers_Label') ?>',  Number(resumeUsers)],
         
        ]);

        var options = {
              width: 600,
        height: 400,
          title: '',
           is3D: true,
           sliceVisibilityThreshold:0
        };

        var chart = new google.visualization.PieChart(document.getElementById('SurveyUsersPieChat'));

        chart.draw(data, options);
      }
         function drawPagesBarChart(data) {
        // alert(data.toSource());
        // alert(data.PagesAnalyticsData);
           var colorArray = ['red', 'green', 'blue', 'orange', 'yellow','#B8860B','#006400','#D2691E','#008B8B','#FF1493','#B22222','#FF00FF','#CD5C5C','#4B0082','#F08080','#20B2AA','#DA70D6','#800080','#F4A460','#EE82EE','#9ACD32','#A52A2A','#5F9EA0','#D2691E','#DAA520','#FF69B4','#191970','#FFA500']

           var dataArray = new Array();
           dataArray.push(['Element', 'Time',{role: 'style'},{role:'tooltip'}]);
           var colorArrayIndex = 0;
        var timeSpent,timeFlag;   
        $.each(data.PagesAnalyticsData, function(key1, value1) {
//           if(data.flag = "Hours"){
//               timeSpent = value1.TimeSpentInMinutes;
//               timeFlag = "mins";
//           }else{
//               timeSpent = value1.TimeSpentInHours;
//               timeFlag = "hours";
//           }
           var percentage = (value1.PageTimeSpentInSeconds/data.totalTimeSpent)*100;
           percentage = parseFloat(percentage.toFixed(2));
           var newarray = [value1.PageNumber, percentage,colorArray[colorArrayIndex],"Time: "+value1.timeSpentString+" ( "+percentage+"% )"];
           
            dataArray.push(newarray);  
            colorArrayIndex++;
           });
          // alert(dataArray.toSource());
//         
      var data = google.visualization.arrayToDataTable(dataArray);

      var options = {
        title: "",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
         
         hAxis: {format:'#\'%\'',title: '',  titleTextStyle: {color: '#FF0000'}},
        // vAxis: {title: 'Page',  titleTextStyle: {color: '#FF0000'}}
      };
      var chart = new google.visualization.BarChart(document.getElementById("SurveyPagesBarChat"));
      chart.draw(data, options);
  }
  </script>
    </script>

     <script type="text/javascript">         
         $("#surveysubmitbuttons").hide();   
         $('#analyticsswitch').bootstrapSwitch();
         $('#analyticsswitch').bootstrapSwitch('setState', true);
         $('label[for=analyticsswitch]').text("Bundle Level");
         $('#analyticsswitch').on('switch-change', function(e, data) {
            var groupName = $(this).closest("div.networkmode").attr("data-groupname");   
            var surveyId = $(this).closest("div.networkmode").attr("data-surveyid");
               var switchedValue = data.value ? 1 : 0;
               if (switchedValue == 1) {
                   $('label[for=analyticsswitch]').text("Bundle Level");
               } else {
                   $('label[for=analyticsswitch]').text('Schedule Level');
               }
               var scrollTp = $(window).scrollTop();
                scrollTp = Number(scrollTp);                
                $("#surveyviewspinner").css("top",scrollTp);
               loadSurveyAanlyticsByLevel(switchedValue,groupName,surveyId);

         });
        function loadSurveyAanlyticsByLevel(flag,gpName,surveyId){
            var queryString = "flag="+flag+"&groupName="+gpName+"&surveyId="+surveyId;     
            //alert(queryString)
            scrollPleaseWait('surveyviewspinner');
            if(flag == 0)
                ajaxRequest("/extendedSurvey/surveyAnalyticsByGroupName",queryString,loadSurveyAanlyticsByLevelHandler);
            else {
                ajaxRequest("/extendedSurvey/surveyAnalytics","ScheduleId=<?php echo $scheduleId; ?>&userId=<?php echo $userId; ?>",scheduleSurveyAnalticsHandler);
                
                $("#schedule_dates").html('<span class="g_scheduleDate g_scheduleDateGameWall s_scheduleDateGameWall"><?php echo $sdate; ?></span>');
            }
        }
        
        function loadSurveyAanlyticsByLevelHandler(data){
         //  alert(data.toSource())
            surveyAnalticsHandler(data);
            
            var sdatee = data.sdates;
            var totalTakenUsersCount = data.totalAnsweredUsersCount;
            var abandonedUsersCount = data.abandonedUsersCount;
           
            $("#completedusers_bu").text(totalTakenUsersCount);
            $("#abandonedusers_bu").text(abandonedUsersCount);
            var TotalUsersAttempted = Number(totalTakenUsersCount)+Number(abandonedUsersCount);
            $("#totalusersattempted,#totaluserssurveytaken").text(TotalUsersAttempted);
            setTimeout(function(){
                drawUsersPieChart(totalTakenUsersCount,abandonedUsersCount)
               // alert(data.PagesAnalyticsData.toSource());
               var PagesAnalyticsData =  data.PagesAnalyticsData;
               
                  drawPagesBarChart(data.PagesAnalyticsData);
                   var item = {
            'data': data.PagesAnalyticsData
        };
        $("#pageAnalyticsDiv").html(
                $("#pageAnalyticsTmpl").render(item)
                );  
                  
               $("#totalTimeSpentDiv,#avgTimeSpentMainDiv").text(data.PagesAnalyticsData.avgTimeSpent) 
                $("#totalTimeSpentDiv,#totalTimeSpentMainDiv").text(data.PagesAnalyticsData.totalTimeSpentString) 
                  
            },100);
            
            var htmlstr = "";
            for(var i=0; i<sdatee.length;i++){
                
                htmlstr += '<span class="g_scheduleDate g_scheduleDateGameWall s_scheduleDateGameWall">'+sdatee[i]+'</span>'
            }
            $("#schedule_dates").html(htmlstr);
        }

     </script>
     <script type="text/javascript">   

ajaxRequest("/extendedSurvey/surveyAnalytics","ScheduleId=<?php echo $scheduleId; ?>&userId=<?php echo $userId; ?>",scheduleSurveyAnalticsHandler);
function scheduleSurveyAnalticsHandler(data){
    surveyAnalticsHandler(data);
   
            var totalTakenUsersCount = data.totalAnsweredUsersCount;
            var abandonedUsersCount = data.abandonedUsersCount;
           
            $("#completedusers_bu").text(totalTakenUsersCount);
            $("#abandonedusers_bu").text(abandonedUsersCount);
            var TotalUsersAttempted = Number(totalTakenUsersCount)+Number(abandonedUsersCount);
            $("#totalusersattempted,#totaluserssurveytaken").text(TotalUsersAttempted);
            setTimeout(function(){ 
                drawUsersPieChart(totalTakenUsersCount,abandonedUsersCount)
              //  alert(data.PagesAnalyticsData.toSource());
               var PagesAnalyticsData =  data.PagesAnalyticsData;
               
                  drawPagesBarChart(data.PagesAnalyticsData);
                   var item = {
            'data': data.PagesAnalyticsData
        };
        $("#pageAnalyticsDiv").html(
                $("#pageAnalyticsTmpl").render(item)
                );  
                  
               $("#totalTimeSpentDiv,#avgTimeSpentMainDiv").text(data.PagesAnalyticsData.avgTimeSpent) 
                $("#totalTimeSpentDiv,#totalTimeSpentMainDiv").text(data.PagesAnalyticsData.totalTimeSpentString) 
                  
            },100);
    
}
function surveyAnalticsHandler(data){ 
    
    //alert(data.toSource());
     var PagesAnalyticsData =  data.PagesAnalyticsData;
              
                  drawPagesBarChart(data.PagesAnalyticsData);
                   var item = {
            'data': data.PagesAnalyticsData
        };
        $("#pageAnalyticsDiv").html(
                $("#pageAnalyticsTmpl").render(item)
                );  
                  
    
    
    data = data.data;
    //   alert(data.toSource())
    scrollPleaseWaitClose('surveyviewspinner');
     var inc = 1;   
     var colorArray = ['red', 'green', 'blue', 'orange', 'yellow','#B8860B','#006400','#D2691E','#008B8B','#FF1493','#B22222','#FF00FF','#CD5C5C','#4B0082','#F08080','#20B2AA','#DA70D6','#800080','#F4A460','#EE82EE','#9ACD32','#A52A2A','#5F9EA0','#D2691E','#DAA520','#FF69B4','#191970','#FFA500']
     var questionId = 0;
             $.each(data.Questions, function(key, value) {
                // alert(value.QuestionType);
                  var userAnnotationArray = value.UserAnnotationArray;
                  var htmlstroption = "";
                  var htmlstrvaluep = "";
                  var htmltrovalue = " ";
                  var htmlstrcnt = "";
                  var totalvalue = 0;
                  questionId = value.QuestionId.$id;
                 $("#allchartsmaindiv").append("<div id='surveyChart" + key + "' style='height: 500px;'></div>");
                 if (value.QuestionType == 1 || value.QuestionType == 2 || value.QuestionType == 5 || value.QuestionType == 8) {
                     var dataArray = new Array();
                     dataArray.push(['Element', 'Percentage', {role: 'style'}, {role: 'tooltip'},{role: 'annotation'}]);
                     //alert(value.OptionsNewArray);
                     var colorArrayIndex = 0;
                     
                     $.each(value.OptionsPercentageArray, function(key1, value1) {
                        var substr = key1.substr(0, 30);
                        if(key1.length > 30){
                            substr += "...";
                        }

                        htmlstroption += '<div class="customrows" >';
                        if(value.OtherValue == key1){
                           htmlstroption +='<div class="customcolumns"><a class="analyticsOtherR tooltiplink justification_followup" data-original-title="<?php echo Yii::t('translation', 'Survey_ClickSeeOtherData'); ?>" rel="tooltip" data-placement="bottom" data-qid="'+questionId+'" data-qtype="'+value.QuestionType+'">'+substr+'</a></div>';  
                        }else{
                            htmlstroption += '<div class="customcolumns">'+substr+'</div>'; 
                        }
                                        
                               htmlstroption += '<div class="customcolumns aligncenter">'+value.OptionsNewArray[key1]+'</div>'+'<div class="customcolumns" style="text-align:center;">'+value1+'%</div>';
                                           
                                  
                              htmlstroption += '</div>';

                                    totalvalue += Number(value.OptionsNewArray[key1]);
//                        htmlstrvaluep += '<div class="customcolumns">'+value1+'</div>';
                        
                         key1 = "" + key1 + "";
                        
                         //if(key1 != "Other value "){
                         var annotation = '';
                         if(userAnnotationArray.indexOf(key1)>=0 && value1>0){
                             annotation = '*';
                         }                         
                         var newarray = [key1, value1, colorArray[colorArrayIndex], "Value:" + value.OptionsNewArray[key1],annotation];
                         dataArray.push(newarray);
                         //  }

                         colorArrayIndex++;
                     });

                     var data = google.visualization.arrayToDataTable(dataArray);
                     var options = {
                         //title: value.Question,
                         legend: 'none',                         
                         hAxis: {format: '#\'%\''},
                         bar: {groupWidth: "55%"},
                           annotations:{
                              alwaysOutside:true,
                             textStyle: {
                                  fontName: 'Times-Roman',
                                  fontSize: 18,
                                  bold: true,
                                  italic: true,
                                  color: 'red',     // The color of the text.
                                  auraColor: 'red', // The color of the text outline.
                                  opacity: 0.8          // The transparency of the text.
                            }
                          }

                     };
                     
                        $("#table_row_"+questionId).html(htmlstroption);
                        $("#table_footer_"+questionId).html('<div class="customcolumns">Total</div><div class="customcolumns aligncenter">'+totalvalue+'</div><div class="customcolumns"></div>');
            
           
                      
           
                 }else if(value.QuestionType == 3 || value.QuestionType == 4){ 
                    // alert(value.JustificationPlaceholders.length);
      var userSelectedOptionsArray = value.userSelectedOptionsArray;
      //userSelectedOptionsArray[userId]
      var dataArray = new Array();
      //var labelArray = new Array();
      var labelArray =  new Array();
      labelArray.push('Genre');
      htmlstroption = '<div class="customcolumns" >Option&nbsp;Name</div>';
      var labelD = value.LabelDescription;      
       $.each(value.LabelName, function( key, value ) {           
           if($.trim(value).length == 0)
               value = labelD[key];
               
            htmlstroption += '<div class="customcolumns aligncenter" >'+value+'</div>';
           labelArray.push(value);
            labelArray.push({ role: 'tooltip' });
             labelArray.push({ role: 'annotation' });
       });
           /* var labelN = value.LabelName;
            var labelB = value.LabelDescription;
            for(var kkl = 0; kkl < labelN.length; kkl++){
                //alert($.trim(labelN[kkl])+"=="+labelB[kkl]);
                
                    value = $.trim(labelN[kkl]);
                
                alert(value);
                    
                htmlstroption += '<div class="customcolumns" >'+value+'</div>';
           labelArray.push(value);
            labelArray.push({ role: 'tooltip' });
             labelArray.push({ role: 'annotation' });
             
            }*/
       htmlstroption += '<div class="customcolumns aligncenter" ><?php echo Yii::t('translation', 'Survey_Total'); ?></div>';
        
       if(value.JustificationPlaceholders.length > 0){
            htmlstroption += '<div class="customcolumns justificationR justification_followup tooltiplink aligncenter" data-original-title="<?php echo Yii::t('translation', 'Survey_ClickSeeJustifications'); ?>" rel="tooltip" data-placement="bottom" data-qid="'+questionId+'" data-qtype="'+value.QuestionType+'">Justfication</div>';
       }
            dataArray.push(labelArray);
     
      //alert(dataArray);
      var i=0;
      htmltrovalue = '';
     // alert(value.OptionsCommentsPercentageArray.toSource());
        $.each(value.OptionsPercentageArray, function( key1, value1 ) {
             var substr = key1.substr(0, 30);
                        if(key1.length > 30){
                            substr += "...";
                        }
                        if(value.OtherValue == key1){
                            htmltrovalue += '<div class="customrows" ><div class="customcolumns"><a class="analyticsOtherR tooltiplink justification_followup" data-original-title="<?php echo Yii::t('translation', 'Survey_ClickSeeOtherData'); ?>" rel="tooltip" data-placement="bottom" data-qid="'+questionId+'" data-qtype="'+value.QuestionType+'">'+substr+'</a></div>'; 
                        }else{
                             htmltrovalue += '<div class="customrows" ><div class="customcolumns">'+substr+'</div>';
                        }
                       
                                        
//                         htmlstroption += '<div class="customrows" >'+
//                                            '<div class="customcolumns">'+substr+'</div>'+
//                                            '<div class="customcolumns">'+value1+'%</div>'+
//                                            '<div class="customcolumns">1</div>'+
//                                            '</div>';
              key1 = ""+key1+"";
             var selectedOption =  userSelectedOptionsArray[i];
            var newarray = new Array();
              newarray.push(key1); 
              var j=1;
             var totalValue = 0; 
             var avg = 0;
             $.each(value1, function( k, v ) {
                 totalValue += value.OptionsNewArray[key1][k];
                 htmltrovalue += '<div class="customcolumns aligncenter">'+v+'%</div>';
                 var annotation;
                 if(j == selectedOption){
                     annotation = "*";
                 }else{
                    annotation = ""; 
                 }
               newarray.push(v);
               
               newarray.push("Value:"+value.OptionsNewArray[key1][k]);
                newarray.push(annotation);
                j++;
            });
            avg = Number(totalValue/(j-1));
          
               htmltrovalue += '<div class="customcolumns aligncenter">'+totalValue+'</div>';             
              if(value.OptionsCommentsPercentageArray.length>0){
                   var justificationPercentage =  value.OptionsCommentsPercentageArray[i];
                    var justificationValue =  value.OptionsCommentsNewArray[i];
                   htmltrovalue += '<div class="customcolumns" style="text-align:center;">'+justificationValue+"  ("+justificationPercentage+'%)</div>';
              }
      
        
        htmltrovalue += "</div>";

               dataArray.push(newarray); 
           
            i++;  
         });


var data = google.visualization.arrayToDataTable(dataArray);
      var options = {
        //title: value.Question,
        width: 700,
        height: 400,
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '60%' },        
        isStacked: true,
         hAxis: {format:'#\'%\''},
          annotations:{
                              alwaysOutside:true,
                             textStyle: {
                                  fontName: 'Times-Roman',
                                  fontSize: 18,
                                  bold: true,
                                  italic: true,
                                  color: 'red',     // The color of the text.
                                  auraColor: 'red', // The color of the text outline.
                                  opacity: 0.8          // The transparency of the text.
                            }
                          }
      };
      
      $("#table_head_"+questionId).html(htmlstroption);
      $("#table_tr_"+questionId).html(htmltrovalue);
 }
 else if(value.QuestionType == 6 || value.QuestionType == 7){ 
     
     
     var dataArray = new Array();
       dataArray.push(['Task', 'Hours per Day']);
         //alert(value.OptionsNewArray);
       totalvalue = 0;
       $.each(value.OptionsPercentageArray,function(k,v){
      
           htmlstroption += '<div class="customrows" >'+
                                            '<div class="customcolumns">'+k+'</div>'+                                            
                                            '<div class="customcolumns aligncenter">'+value.OptionsNewArray[k]+'</div>'+
                                            '<div class="customcolumns">'+v.toFixed(2)+'%</div>'+
                                            '</div>';
                                    totalvalue += value.OptionsNewArray[k];
       })
         $.each(value.OptionsNewArray, function( key1, value1 ) {
//             alert("==key=="+key1+"==value==="+value1)
             
                     key1 = "" + key1 + "";
                     var newarray = [key1, value1];
                     dataArray.push(newarray);
                 });

                 var data = google.visualization.arrayToDataTable(dataArray);


                 var options = {
                     //title: 'My Daily Activities',
                     is3D: true,
                     sliceVisibilityThreshold: 0
                 };

                 $("#table_row_"+questionId).html(htmlstroption);
                        $("#table_footer_"+questionId).html('<div class="customcolumns">Total</div><div class="customcolumns aligncenter">'+totalvalue+'</div><div class="customcolumns"></div>');
    }
             if (value.QuestionType == 6 || value.QuestionType == 7) {
                 var chart = new google.visualization.PieChart(document.getElementById('surveyChart_' + questionId));
             } else {
                 var chart = new google.visualization.BarChart(document.getElementById('surveyChart_' + questionId));

             }
             $("#adminAna_qNo_"+questionId).html(inc+")");
             $("#surveyquestionbox_"+questionId).show();
             
             if(data.zf.length > 0){
                chart.draw(data, options);
             }else{
                 $('#surveyChart_' + questionId).prepend('<div style="text-align:center;"><img id="No Aalytics" src="images/system/noanalyticsfound.png" /></div>');//if the data is not found here we are showing dummy image.
             }
             inc++;
             
         });


$("[rel=tooltip]").tooltip();
     }
     
    function usabilityAnalyticsCaptureImg(chartContainer, obj,questionType,qNo,ii) {
        var doc = chartContainer.ownerDocument;        
        saveAsImgUsability(chartContainer,obj,questionType,qNo,ii);
        var img = doc.createElement('img');
        img.src = getImgData(chartContainer);
        img.id=chartContainer.id+"_img";
//        while (imgContainer.firstChild) {
//          imgContainer.removeChild(imgContainer.firstChild);
//          
//        }
        //imgContainer.appendChild(img);
        
       
      }
     function getImgData(chartContainer) {  
         try{
    var chartArea = chartContainer.getElementsByTagName('svg')[0].parentNode;
    var svg = chartArea.innerHTML;
    var doc = chartContainer.ownerDocument;
    var canvas = doc.createElement('canvas');
    canvas.setAttribute('width', chartArea.offsetWidth);
    canvas.setAttribute('height', chartArea.offsetHeight);

    canvas.setAttribute(
        'style',
        'position: absolute; ' +
        'top: ' + (-chartArea.offsetHeight * 2) + 'px;' +
        'left: ' + (-chartArea.offsetWidth * 2) + 'px;');
    doc.body.appendChild(canvas);
    canvg(canvas, svg);
    var imgData = canvas.toDataURL("image/png");
    canvas.parentNode.removeChild(canvas);
         }catch(err){
            // alert("error--"+err);
         }
    return imgData;
  }    
 function saveAsImgUsability(chartContainer, obj,questionType,qNo,ii) {     
        var imgData = getImgData(chartContainer);
        saveImageFromBase64Usability(imgData, obj,questionType,qNo,ii);
      }
      
 function saveImageFromBase64Usability(imgData, obj,questionType,qNo,ii){
        var queryString = "imgData="+imgData+"&id="+ii;     
        
        ajaxRequest("/extendedSurvey/analyticsSaveImageFromBase64", queryString, function(data){saveImageFromBase64Usabilityhandler(data, obj,questionType,qNo,ii);});  
    }
    
function saveImageFromBase64Usabilityhandler(data, obj,qType,qno,ii){    
    scrollPleaseWaitClose("spinner_analytics_"+qno);
    window.open("/extendedSurvey/Pdf?question="+$("#quesiton_"+qno).text()+"&ii="+ii,'_blank');
}

function openAnalyticspdfforall(){
    scrollPleaseWait("surveyviewspinner");
    QuestionIdsX = "-2_-1_"+QuestionIds;
    var QuestionId = QuestionIdsX.split("_");
    var questionText = "";
    for(var m = 0; m < QuestionId.length-1; m++){
        obj = "";
        questionType = QuestionTypeVal;
        id = QuestionId[m];
        if(m==0){
            qNo = "SurveyUsersPieChat";
            var idVal = "SurveyUsersPieChat";
        }else if(m==1){
            qNo =  "SurveyPagesBarChat";
            var idVal = "SurveyPagesBarChat";
        }else{
            qNo = id;
            var idVal = 'surveyChart_'+id;
        }
        
        chartContainer = document.getElementById(idVal);       
        var questionText = questionText + $("#quesiton_"+qNo).text()+"_";
        
        var imgData = getImgData(chartContainer);     
        var hh = m + 1;        
        var queryString = "imgData="+imgData+"&id="+hh;
        ajaxRequest("/extendedSurvey/analyticsSaveImageFromBase64", queryString, '');        
    }
    scrollPleaseWaitClose("surveyviewspinner");    
    
    window.open("/extendedSurvey/Pdf?type=all&surveyId=<?php echo $surveyObj->_id?>",'_blank'); 
    
    //window.open("/extendedSurvey/Pdf?question=&questionText="+questionText,'_blank');
    
}

function openAnalyticspdf(obj,questionType,id,ii, type){
    
    var idval =  id;
    if(type != 1){
       var idval = 'surveyChart_'+id;
    }
    scrollPleaseWait("spinner_analytics_"+id)
    usabilityAnalyticsCaptureImg(document.getElementById(idval), obj,questionType,id, ii);
    
}


$("#genereateXls").die().live("click",function(){
   var surveyId = $(this).attr("data-surveyid");
   var scheduleId = $(this).attr("data-scheduleid");
   var qId = $(this).attr("data-questionid");
   var qType = $(this).attr("data-questiontype");
   var ii = $(this).attr("data-id");   
   var groupName = "";
   if($('label[for=analyticsswitch]').text() == "Schedule Level"){
       groupName = $(this).attr("data-groupname");
   }
   var type = "";
   if($(this).attr("data-type")){
       var type=$(this).attr("data-type");
   }
   
   window.open("/extendedSurvey/generateSurveyAnalyticsXLS?surveyId="+surveyId+"&scheduleId="+scheduleId+"&qType="+qType+"&qId="+qId+"&groupName="+groupName+"&ii="+ii+"&type="+type);
});


$("#genereateXlsforAll").die().live("click",function(){
    
    window.open("/extendedSurvey/generateSurveyAnalyticsXLS?surveyId=<?php echo $surveyObj->_id; ?>&scheduleId=<?php echo $scheduleId; ?>&analyticsswitch="+$('label[for=analyticsswitch]').text().replace(" ","")+"&type=all");
    //&qType="+QuestionTypeVal+"&qId=_"+QuestionIds+"&groupName=_"+dataGroupName+"
    //window.open("/extendedSurvey/generateSurveyAnalyticsXLS?surveyId=_"+dataSurveyId+"&scheduleId=_"+dataScheduleid+"&qType="+QuestionTypeVal+"&qId=_"+QuestionIds+"&groupName=_"+dataGroupName+"&analyticsswitch="+$('label[for=analyticsswitch]').text().replace(" ","")+"&type=all");
});


$(".analyticsOtherR").die().live("click",function(){
    var qId = $(this).attr("data-qid");
    var qType = $(this).attr("data-qtype");
    var data = {"ScheduleId":'<?php echo $scheduleId; ?>',"userId":'<?php echo $userId; ?>',"questionId":qId,"questionType":qType};
    ajaxRequest("/extendedSurvey/getOtherDataForQuestion",data,otherDataAnalyticsHandler,"html");
    
})
function otherDataAnalyticsHandler(html){
    // alert(html);
    $("#tagCloudLabel").html("<?php echo Yii::t('translation', 'OtherTagCloud_Label') ?>");
    $("#tagCloud_body").html(html);
    $("#tagCloudModal").modal("show"); 
    $('#tagCloud_body').height(function() {
        return $(window).height() * 0.7;
    });
}

function  showSeeAnswers(qId,qType){
      //  alert("showJustfication----"+justificationPage);
        
     var data = {"SurveyId":'<?php echo $surveyObj->_id?>',"ScheduleId":'<?php echo $scheduleId; ?>',"questionId":qId,"questionType":qType,"Page":seeAnswersPage};
    ajaxRequest("/extendedSurvey/getAnswersDataForQuestion",data,
    function(html){
        seeAnswersHandler(html,qId,qType);
    }
    ,"html");
    }

$(".seeAnswers").die().live("click",function(){
    var qId = $(this).attr("data-qid");
    var qType = $(this).attr("data-qtype");
    sjPopupAjax=false;
    seeAnswersPage = 0;
    showSeeAnswers(qId,qType);
     
})
function seeAnswersHandler(html){
    var jscroll = $('#tagCloud_body').jScrollPane({});
    var api = jscroll.data('jsp');
    api.destroy();
    $("#tagCloudLabel").html("<?php echo Yii::t('translation', 'See_Answers_Label') ?>");
    if(html != 0){
        $("#tagCloud_body").addClass("scroll").html(html);
        $("#tagCloud_body").jScrollPane({autoReinitialise: true, autoReinitialiseDelay: 500}); 

        $("#tagCloud_body").bind('jsp-scroll-y', function(event, scrollPositionY, isAtTop, isAtBottom)
        {
            if (isAtBottom && sjPopupAjax == false) {      
                seeAnswersPage++;
                  sjPopupAjax=true;
               showSeeAnswers(qId,qType)
            }
        });

    }
    else{
         $("#tagCloud_body").html("<center><?php echo Yii::t('translation', 'Ex_NoData_Title') ?></center>"); 
    }
    $("#tagCloudModal").modal("show");
    $('#tagCloud_body').height(function() {
          return $(window).height() * 0.7;
    });
}

 var justificationPage = 0;
 var sjPopupAjax = false;
$(".justificationR").die().live("click",function(){
     var qId = $(this).attr("data-qid");
     var qType = $(this).attr("data-qtype");
     justificationPage = 0;
     showJustfication(qId,qType)

    })

function  showJustfication(qId,qType){
      //  alert("showJustfication----"+justificationPage);
        
    var data = {"SurveyId":'<?php echo $surveyObj->_id?>',"ScheduleId":'<?php echo $scheduleId; ?>',"userId":'<?php echo $userId; ?>',"questionId":qId,"questionType":qType,"Page":justificationPage};
    ajaxRequest("/extendedSurvey/getJustificationDataForQuestion",data,
    function(html){
        showJustficationHandler(html,qId,qType);
    }
    ,"html");
    }
    
    function showJustficationHandler(html,qId,qType){
        
    if(justificationPage == 0){
         var jscroll = $('#tagCloud_body').jScrollPane({});
        var api = jscroll.data('jsp');
        api.destroy();
        if(qType == 8 ){
              $("#tagCloudLabel").html("<?php echo Yii::t('translation', 'Followup_Label') ?>");
        } else{
             $("#tagCloudLabel").html("<?php echo Yii::t('translation', 'Justification_Label') ?>"); 
        }
   
    // $("#tagCloud_body").html(html);
     $("#tagCloudModal").modal("show"); 
      if(html != 0){
     $("#tagCloud_body").addClass("scroll").html(html);   
        $("#tagCloud_body").jScrollPane({autoReinitialise: true, autoReinitialiseDelay: 500});
 

        $("#tagCloud_body").bind('jsp-scroll-y', function(event, scrollPositionY, isAtTop, isAtBottom)
        {
            if (isAtBottom && sjPopupAjax == false) {      
                justificationPage++;
                  sjPopupAjax=true;
               showJustfication(qId,qType);
            }


        }
        );
     
    }else{
         $("#tagCloud_body").html("<center><?php echo Yii::t('translation', 'Ex_NoData_Title') ?></center>"); 
    }
      $('#tagCloud_body').height(function() {
            return $(window).height() * 0.7;
        });

    }else{
         if(html==0){  
           auPopupAjax =true;
        }else{
            
         $(".jspPane").append(html);
         sjPopupAjax =false;
     }
    }
 
}


///////////

$(".completedUsers").die().live("click",function(){
    sjPopupAjax1 = false;    
    
    var usersSurveyId = $(this).attr("data-surveyid");
    var userScheduleId = $(this).attr("data-scheduleid");
    var userType = "Completed";
    var completedUsersIdsArraySize = '<?php echo sizeof($scheduleObject->SurveyTakenUsers); ?>';
    
    surveyUsersPage = 0;
    showSurveyUsers(usersSurveyId, userScheduleId, "<?php echo Yii::t('translation', 'SurveyCompletedUsers_Label') ?>", userType, completedUsersIdsArraySize);
});

$(".abandonedUsers").die().live("click",function(){   
    sjPopupAjax1 = false;
   var usersSurveyId = $(this).attr("data-surveyid");
    var userScheduleId = $(this).attr("data-scheduleid");
    var userType = "Abandoned";
    var completedUsersIdsArraySize = '<?php echo sizeof($scheduleObject->ResumeUsers); ?>';
    surveyUsersPage = 0;
    showSurveyUsers(usersSurveyId, userScheduleId, "<?php echo Yii::t('translation', 'SurveyAbandonedUsers_Label') ?>", userType, completedUsersIdsArraySize);
});

function  showSurveyUsers(usersSurveyId, userScheduleId, title, userType, completedUsersIdsArraySize){

    if($('label[for=analyticsswitch]').closest('.has-switch').hasClass('switch-off')){
       var surveyType = 0; //0 means Bundle level
    }else{
       var surveyType = 1;//0 means Schedule level
    }
    var data = {"usersSurveyId":usersSurveyId,"userScheduleId":userScheduleId,"surveyType":surveyType,"userType":userType,"Page":surveyUsersPage};
    ajaxRequest("/extendedSurvey/getSurveyUsers",data,
    function(html){
        showSurveyUsersHandler(html, usersSurveyId, userScheduleId, title, userType, completedUsersIdsArraySize);
    }
    ,"html");
    }
    
function showSurveyUsersHandler(html, usersSurveyId, userScheduleId, title, userType, completedUsersIdsArraySize){
        
    if(surveyUsersPage == 0){
        var jscroll = $('#tagCloud_body').jScrollPane({});
        var api = jscroll.data('jsp');
        api.destroy();
       
        $("#tagCloudLabel").html(title); 
    
        $("#tagCloudModal").modal("show"); 
        if(html != 0){
            $("#tagCloud_body").addClass("scroll").html(html);
            //completedUsersIdsArraySize = 31;
            //alert(completedUsersIdsArraySize);
            if(completedUsersIdsArraySize >= 9)
                $("#tagCloud_body").jScrollPane({autoReinitialise: true, autoReinitialiseDelay: 150, stickToBottom: false});

            $("#tagCloud_body").bind('jsp-scroll-y', function(event, scrollPositionY, isAtTop, isAtBottom)
            {
                if (isAtBottom && sjPopupAjax1 == false) {
                    surveyUsersPage++;
                      sjPopupAjax1=true;
                   showSurveyUsers(usersSurveyId, userScheduleId, title, userType, completedUsersIdsArraySize);
                }
            });

        }else{
            $("#tagCloud_body").html("<center><?php echo Yii::t('translation', 'Ex_NoData_Title') ?></center>"); 
        }

        $('#tagCloud_body').height(function() {
            return $(window).height() * 0.3;
        });

    }else{
         if(html==0){  
           auPopupAjax =true;
        }else{
            
         $(".jspPane").append(html);
         sjPopupAjax1 =false;
     }
    }
 
}
    
</script>      

  <?php } ?>