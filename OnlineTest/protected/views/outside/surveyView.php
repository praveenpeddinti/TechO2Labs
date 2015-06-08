<?php 
if(is_object($surveyObj)){  ?>
<div class="padding10ltb">
     <?php if($surveyObj->IsBannerVisible == 1){ ?>
     <h2 class="pagetitle">Market Research</h2>
    <div class="market_profile marginT10">
	<div class="m_profileicon">
            
           <div class="pull-left marginzero generalprofileicon  skiptaiconwidth190x190 generalprofileiconborder5 noBackGrUp">
                            <div class="positionrelative editicondiv editicondivProfileImage no_border editicondivProfileImagelarge skiptaiconinner ">
                            
                                
                                <div style="display: none;" class="edit_iconbg">
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
                                
    
     </div>
     <?php } ?>
     
<!--     <div class="row-fluid groupseperator border-bottom">
     <div class="span12 "><h2 class="pagetitle paddingleft5">Market Research Survey </h2></div>
     </div>-->
     <div id="surveyviewspinner" style="position:relative;"></div>
     
     <div class="padding152010" style="">
         <?php $i = 1; foreach($surveyObj->Questions as $question){              
             ?>
         
         <div class="surveyquestionsbox" id="surveyquesitonbox_<?php echo $question['QuestionId']; ?>" >
     <div class="surveyanswerarea surveyanswerviewarea">
     <div class="paddingtblr30">
         
 	<div class="questionview"><div class="questionview_numbers" id="questionNo_<?php echo $question['QuestionId']; ?>"><?php echo "$i)"; ?></div> <?php echo $question['Question']; ?></div>
     <div class="answersection">
         <div class="row-fluid">
             <div class="span12">
                 <div class="span9">
                     <div id="surveyChart_<?php echo $question['QuestionId']; ?>" style='height: 400px;'></div>
                 </div>
                
                 <div class="span3">
                    <div class="customtable padding-top_30">
                        <div class="customheader">
                            <div class="customcolumns_s"> n = <span id="surveyed_<?php echo $question['QuestionId']; ?>">0</span></div>                         
                        </div>

                        <div class="customheader">
                            <div class="customcolumns_s"> * <?php echo Yii::t("translation","Denote_response"); ?></div>
                        </div>  
                        <?php if($question['AnyOther'] == 1  ){ ?>
<!--                        <div class="customheader" id="anyotherdiv_<?php //echo $question['QuestionId']; ?>" style="display: none;">
                                <div class="customcolumns_s"> <a class="btn btn-primary" id="anyothercommentbutton" data-question="<?php //echo $question['Question']; ?>" data-questionid="<?php //echo $question['QuestionId']; ?>" data-id="<?php //echo $surveyObj->_id; ?>">Any Other Comments</a></div>
                            </div> -->
                        <?php } ?>
                    </div>                     
                 </div>
                 
             </div>
         </div>
      
         
     </div>
         
     </div>
     </div>
         
     </div>
         <?php $i++;         
              } ?>  
         
     </div>
     
     
     
     
     <script type="text/javascript">         
         $("#surveysubmitbuttons,#userview_Bannerprofile").hide();         
     </script>
     <script type="text/javascript">    
         var queryString = "ScheduleId=<?php echo $scheduleId; ?>&userId=<?php echo $userId; ?>";
         $("#userviewErrMessage").hide();
ajaxRequest("/extendedSurvey/surveyAnalytics",queryString,surveyAnalticsHandler);
function surveyAnalticsHandler(data){     
    data = data.data;
     var inc = 1;        
    var colorArray = ['red', 'green', 'blue', 'orange', 'yellow','#B8860B','#006400','#D2691E','#008B8B','#FF1493','#B22222','#FF00FF','#CD5C5C','#4B0082','#F08080','#20B2AA','#DA70D6','#800080','#F4A460','#EE82EE','#9ACD32','#A52A2A','#5F9EA0','#D2691E','#DAA520','#FF69B4','#191970','#FFA500']
     var questionId = 0;
             $.each(data.Questions, function(key, value) { 
                 questionId = value.QuestionId.$id;
                  var userAnnotationArray = value.UserAnnotationArray;                 
                 if (value.QuestionType == 1 || value.QuestionType == 2 || value.QuestionType == 5 || value.QuestionType == 8) {
                     var dataArray = new Array();
                     dataArray.push(['Element', 'Percentage', {role: 'style'}, {role: 'tooltip'},{role: 'annotation'}]);
                     //alert(value.OptionsNewArray);
                     var colorArrayIndex = 0;
                     $.each(value.OptionsPercentageArray, function(key1, value1) {

                         key1 = "" + key1 + "";                        
//                         if(value.QuestionType == 5){
//                            alert(key1+"===="+value1)
//                        }
                         //if(key1 != "Other value "){
                         var annotation = '';
                         if(userAnnotationArray.indexOf(key1)>=0 && value1>0){
                             annotation = value1+"% * ";
                         }else if(value1 > 0){
                             annotation = value1+"% ";
                         } 
                         if(value1 > 0){
                              $("#surveyed_"+questionId).html(value.SurveyTakenUsers);
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
                         width: 600,
                         hAxis: {format: '#\'%\''},
                         bar: {groupWidth: "50%"},
                           annotations:{
                              alwaysOutside:true,
                             textStyle: {
                                  fontName: 'Times-Roman',
                                  fontSize: 12,
                                  //bold: true,
                                  italic: true,
                                  //color: 'red',     // The color of the text.
                                  //auraColor: 'red', // The color of the text outline.
                                  opacity: 0.8          // The transparency of the text.
                            }
                          }
       
                     };
                    
                 }else if(value.QuestionType == 3 || value.QuestionType == 4){ 
      var userSelectedOptionsArray = value.userSelectedOptionsArray;
      //userSelectedOptionsArray[userId]
      var dataArray = new Array();
      //var labelArray = new Array();
      var labelArray =  new Array();
      labelArray.push('Genre');
       $.each(value.LabelName, function( key, value ) {
           labelArray.push(value);
            labelArray.push({ role: 'tooltip' });
             labelArray.push({ role: 'annotation' });
       });
       dataArray.push(labelArray);
     
      //alert(dataArray);
      var i=0;
      var optionCommentText = "";
        $.each(value.OptionsPercentageArray, function( key1, value1 ) {
             
              key1 = ""+key1+"";
             var selectedOption =  userSelectedOptionsArray[i];
            var newarray = new Array();
              newarray.push(key1); 
              var j=1;
             $.each(value1, function( k, v ) {                 
                 var annotation;
                 if(j == selectedOption){
                     annotation = v+"% * ";
                 }else if(v > 0){
                    annotation = v+"% ";
                 }
               newarray.push(v);
               if(value.OptionCommnets[i] != undefined && value.OptionCommnets[i] != "undefined" && value.OptionCommnets[i] != "")
                   optionCommentText = ", "+value.OptionCommnets[i];
//                if(value.OptionsNewArray[key1][k] == 1){
//                    $("#anyotherdiv_"+questionId).show();
//                }
                newarray.push("Value:"+value.OptionsNewArray[key1][k]+""+optionCommentText);
                newarray.push(annotation);
                j++;
                if(v > 0){
                    $("#surveyed_"+questionId).html(value.SurveyTakenUsers);
                }
            });
               
               dataArray.push(newarray); 
           
            i++; 
         });


var data = google.visualization.arrayToDataTable(dataArray);
      var options = {
        //title: value.Question,
        width: 600,
        height: 400,
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '90%' },
        isStacked: true,
         hAxis: {format:'#\'%\''},
          annotations:{
                              alwaysOutside:true,
                             textStyle: {
                                  fontName: 'Times-Roman',
                                  fontSize: 12,
                                  //bold: true,
                                  italic: true,
                                  //color: 'red',     // The color of the text.
                                  //auraColor: 'red', // The color of the text outline.
                                  opacity: 0.8          // The transparency of the text.
                            }
                          }
      };
      
 }
 else if(value.QuestionType == 6 || value.QuestionType == 7){ 
     
     
     
     var dataArray = new Array();
       dataArray.push(['Task', 'Hours per Day']);
         //alert(value.OptionsNewArray);
       
         $.each(value.OptionsNewArray, function( key1, value1 ) {
                     key1 = "" + key1 + "";
                     var newarray = [key1, value1];
                     dataArray.push(newarray);
                     if(value1 > 0){
                         $("#surveyed_"+questionId).html(value.SurveyTakenUsers);
                     }
                 });

                 var data = google.visualization.arrayToDataTable(dataArray);


                 var options = {
                     //title: 'My Daily Activities',
                     is3D: true,
                     sliceVisibilityThreshold: 0
                 };
                 

    }
             if (value.QuestionType == 6 || value.QuestionType == 7) {
                 var chart = new google.visualization.PieChart(document.getElementById('surveyChart_' + questionId));
             } else {
                 
                 var chart = new google.visualization.BarChart(document.getElementById('surveyChart_' + questionId));

             }
             $("#questionNo_"+questionId).html(inc+")");
             $("#surveyquesitonbox_"+questionId).show();
             
          google.visualization.events.addListener(chart, 'ready', myReadyHandler);      
             
             chart.draw(data, options);
             inc++;

         });
     }
     
    
             
            function myReadyHandler(){
                 $(".charts-tooltip *").removeAttr("style")  ;
                 $(".charts-tooltip *").css("display","block") 
                     $('g text').mouseenter(function(e){

                                $(".charts-tooltip *").removeAttr("style")  ;
                                $(".charts-tooltip *").css("display","block") 


                       //  if($(this).text().indexOf('...')!= -1) return;
                       //  $('.charts-tooltip').hide();
                       //  $('body').append('<div style="position: absolute; visibility: visible; left: '+(e.pageX-50)+'px; top: '+(e.pageY+20)+'px;" class="charts-tooltip"><div style="background-color: red; padding: 1px; border: 1px solid infotext; font-size: 14px; margin: 14px; font-family: Arial; background-position: initial initial; background-repeat: initial initial;">'+$(this).text()+'</div></div>');
                     })
                     $('g').mouseleave(function(e){
                          $(".charts-tooltip *").removeAttr("style")  ;
                             $(".charts-tooltip *").css("display","block") 
                       //  $('.charts-tooltip').hide();
                     })
                 } 
    setTimeout(function(){
            $(".charts-tooltip *").removeAttr("style")  ;
           $(".charts-tooltip *").css("display","block")  }, 80000);
       var startlimit = 0;
       $("#anyothercommentbutton").live("click",function(){
           var questionId = $(this).attr("data-questionid");
           var srvyId = $(this).attr("data-id");
           var question = $(this).attr("data-question");
           
           var maxLength = 10;
           var queryString ="questionId="+questionId+"&srvyId="+srvyId+"&startlimit="+startlimit+"&maxLength="+maxLength+"&question="+question;           
           ajaxRequest("/extendedSurvey/getUserAnyOtherValuesForAnalytics",queryString,surveyAnalticsOtherValuesHandler, "html");
       });
          
        function surveyAnalticsOtherValuesHandler(html){
            $("#streamsectionarea,#contentDiv").hide();
            $("#anyothervaluespage").html(html).show();
        }
</script>
     
     
     
     
      

  <?php       }
?>
