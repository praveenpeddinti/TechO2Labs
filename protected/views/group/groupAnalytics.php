
<div id="content">
<?php include 'groupFloatingMenu.php'; ?>
    
    
 <div class="analytics_header" style="padding-top:10px">
        <div class="row-fluid">

            <div class="span12 positionrelative">
         <div class="analytics_title positionabsolutetitle"><?php echo Yii::t('translation','Analytics'); ?></div>
                <div class="analytics_menu "> 
                     <ul id="tabs" class="" data-tabs="tabs">

                         <li class="analytic_home active"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Analytics'); ?>"><a href="#AnalyticsDashboard" data-toggle="tab"><img src="/images/system/spacer.png" /></a></li>
                        <li class="trafic"  onclick="getGroupTrafficDetails('<?php   echo $groupStatisticsData->_id ?>')"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Traffic'); ?>" ><a href="#trafic" data-toggle="tab"><img src="/images/system/spacer.png" /></a></li>
                        <li class="usability" onclick="getGroupUsabilityDetails('<?php   echo $groupStatisticsData->_id ?>')"  ><a href="#usability" data-toggle="tab"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Usability'); ?>"><img src="/images/system/spacer.png" /></a></li>
                        <li class="activity"  onclick="getGroupActivityDetails('<?php   echo $groupStatisticsData->_id ?>')"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Activity'); ?>" ><a href="#activity" data-toggle="tab"><img src="/images/system/spacer.png" /></a></li>
                        <li class="engagement" onclick="getGroupEngagementDetails('<?php   echo $groupStatisticsData->_id ?>')"><a href="#groupengagement" data-toggle="tab"><img src="/images/system/spacer.png" /></a></li>



                  </ul>
                </div>	
                
           
        </div>
        </div>
    </div>  

<div id="my-tab-content" class="tab-content" style="border: 0px solid #CCCCCC;padding:0">
<div class="tab-pane tab_content active" id="AnalyticsDashboard">
<div class="analytics_title marginT10"><span class=""><?php echo Yii::t('translation','Stats'); ?></span></div>
	<div class="row-fluid">
       <div class="span12">
       <div class="span4">
            <div class=" margin10 stats_div ">
            	<div class=" users">
                <label><?php  echo $groupAnalytics['GroupMembers']; ?></label>
                <?php echo Yii::t('translation','Users'); ?>                
                </div>
       		</div>
            </div>
       <div class="span4">
       	 <div class=" margin10 stats_div ">
            	<div class=" groups">
                <label><?php  echo $groupAnalytics['subgroups']; ?></label>
                <?php echo Yii::t('translation','SubGroups'); ?>               
                </div>
            </div>
       </div>
       <div class="span4">
       	 <div class="margin10 stats_div">
            	<div class="conversations">
                <label><?php  echo $groupAnalytics['Conversations']; ?></label>
                <?php echo Yii::t('translation','Conversations'); ?>                 
                </div>
            </div>
       </div>
        </div>
     </div>

<div class="analytics_title marginT10"><span class=""><?php echo Yii::t('translation','Leaders'); ?> </span></div>
    <div class="row-fluid">
        <div class="sapn12">
            <div class="analytics_topleaders_box">
            <div class="analytics_widgettitle topusers">
            <i><img src="/images/system/spacer.png" /></i>
            <span class="">
                 <?php echo Yii::t('translation','Top_10_Users'); ?>
                	 <i class="cursor helpmanagement"  data-id="GroupTop10Users_DivId"><img src="/images/system/spacer.png" data-original-title=" <?php echo Yii::t('translation','Group_Top_10_Users'); ?>" rel="tooltip" data-placement="bottom" /></i></span>
            </div>
             <div class="r_followersdiv r_newfollowers padding10 borderzero">
                 <ul style="border:0">
                     
                  <?php
                 if(isset($groupAnalytics['Topusers']) && count($groupAnalytics['Topusers'])>0){
                 for ($i = 0; $i < count($groupAnalytics['Topusers']); $i++) {
                     
                  ?>
                
       
            
                <li data-original-title="<?php echo $groupAnalytics['Topusers'][$i]['DisplayName']; ?>" rel="tooltip" data-placement="bottom" class="tooltiplink top_users ">
                    <div class="pull-left generalprofileicon  skiptaiconwidth25x25 generalprofileiconborder3 " >
                  <a  data-userid="2" class="skiptaiconinner miniprofileDetails" style="cursor:pointer">
                        <img src="<?php echo $Topleaders['Topusers'][$i]['ProfilePicture']; ?>">    
                  </a>
                     </div>
                    
                    &nbsp;&nbsp;<label style="float:left"><?php echo $groupAnalytics['Topusers'][$i]['DisplayName']; ?></label>
                </li>
                
                 <?php } }else{
                   echo "No Data Found";  
                 }
              ?>     
                </li>     
        </ul>
    </div>
            </div>
        </div>
    </div>
     <div class="row-fluid paddingtop12">        
        <div class="span6">
            <div class="analytics_topleaders_box" style="min-height:118px;">
                <div class="analytics_widgettitle topSerachTerms">
                <i><img src="/images/system/spacer.png" /></i>
                <span class=""><?php echo Yii::t('translation','Top_10_Search_Terms'); ?> <i class="cursor helpmanagement" data-id="GroupTop10SearchTerms_DivId"><img src="/images/system/spacer.png" data-original-title="<?php echo Yii::t('translation','Group_Top_10_Search_Terms'); ?>" rel="tooltip" data-placement="bottom" /></i></span>
                </div>
                <div class="padding10 topserachterms">
                     <?php
                   // print_r($Topleaders['TopSearchItems']);
                      if( isset($groupAnalytics['TopSearchItems']) && count($groupAnalytics['TopSearchItems'])>0){
                 for ($j=0; $j < count($groupAnalytics['TopSearchItems']); $j++) {
                     
                  ?>
                <?php echo $groupAnalytics['TopSearchItems'][$j];if( $j < count($groupAnalytics['TopSearchItems'])-1){ echo ",";} ?>
                
                      <?php }}else{
                          
                          echo "No Data Found";
                          
                      } ?> 
                </ul>
                </div>
            
            
           
            </div>
        </div>
         
         <div class="span6">
            <div class="analytics_topleaders_box" style="min-height:118px;">
            <div class="analytics_widgettitle topHashtags">
            <i><img src="/images/system/spacer.png" /></i>
            <span class=""><?php echo Yii::t('translation','Top_10_Hash_Tags'); ?> <i data-id="GroupTop10HashTags_DivId" class="helpmanagement cursor"><img src="/images/system/spacer.png" data-original-title="<?php echo Yii::t('translation','Group_Top_10_hashtags'); ?> " rel="tooltip" data-placement="bottom" /></i></span>
            </div>
            <div class="padding10">
           <?php
                   
             if(isset($groupAnalytics['TopHashtags']) && count($groupAnalytics['TopHashtags'])>0){
                 for ($k=0; $k < count($groupAnalytics['TopHashtags']); $k++) {
                     
                  ?>
            
            <span class="analyticsdd-tags hashtag"><b>#<?php echo $groupAnalytics['TopHashtags'][$k]; ?></b></span>
                 <?php } }else{
                     echo "No Data Found";
                 } ?>

            </div>
            
            </div>
        </div>
    </div>

</div>
<div class="tab-pane tab_content" id="trafic">
 <?php require_once 'groupTraffic.php'; ?>
          
</div>
<div class="tab-pane tab_content" id="usability">
<?php require_once 'groupUsability.php'; ?>
</div>
<div class="tab-pane tab_content" id="activity" >
<?php require_once 'groupActivity.php'; ?>
</div>
<div class="tab-pane tab_content" id="groupengagement">
<?php require_once 'groupEngagement.php'; ?>
     
</div>
    
</div>
</div>

 

</div> 



<script type="text/javascript" language="javascript">
bindGroupsFollowUnFollow();
var Global_date_Format='<?php echo Yii::app()->params['DateFormat']; ?>';
   var GID='<?php   echo $groupStatisticsData->_id ?>';
   
   $('#IFramePost').click(function(){ 
         var groupId='<?php   echo $groupStatisticsData->_id ?>';
         
                loadPostWidget(groupId);
 
            });
    function openActivitypdf(obj,analyticType){ 
      
    var g_datesA = $("#"+analyticType+"_StartDate").val()+" to "+$("#"+analyticType+"_EndDate").val();
    $("#"+obj.id).attr("href", "/analytics/Pdf?date="+g_datesA+"&analyticType="+analyticType);

}

function openActivityXls(obj,analyticType){

    var theHref = $("#"+obj.id).attr("href");
    var g_datesA ="startdate="+$("#"+analyticType+"_StartDate").val()+"&enddate="+$("#"+analyticType+"_EndDate").val()+"&groupId="+'<?php   echo $groupStatisticsData->_id ?>';
 
    $("#"+obj.id).attr('href', "/analytics/"+analyticType+"GenerateXLS?"+g_datesA);
    
}
function analyticsCaptureImg(chartContainer, imgContainer) {
        var doc = chartContainer.ownerDocument;
        var img = doc.createElement('img');
        img.src = getImgData(chartContainer);
        saveAsImg(chartContainer);
        img.id=chartContainer.id+"_img";
       // alert("image id"+img.id);
        while (imgContainer.firstChild) {
          imgContainer.removeChild(imgContainer.firstChild);
        }
        imgContainer.appendChild(img);
       
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
 function saveAsImg(chartContainer) { 
        var imgData = getImgData(chartContainer);
        saveImageFromBase64(imgData);
        // Replacing the mime-type will force the browser to trigger a download
        // rather than displaying the image in the browser window.
//        window.location = imgData.replace("image/png", "image/octet-stream");
      }


var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0); 
   // $('.datepicker').css(left:'690.967px');
    
         
    
      var Group_Traffic_checkin = $('#Group_Traffic_dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        
        if ((ev.date.valueOf() > Group_Traffic_checkout.date.valueOf()) || Group_Traffic_checkout.date.valueOf()!="") {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 0);
            //Group_Traffic_checkout.setValue(newDate);
        }
        Group_Traffic_checkin.hide();
        $('#Group_Traffic_dpd2')[0].focus();
    }).data('datepicker');
    
    var Group_Traffic_checkout = $('#Group_Traffic_dpd2').datepicker({
        onRender: function(date) {
           return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        Group_Traffic_checkout.hide();
        
        if(Group_Traffic_checkin.date.valueOf() > Group_Traffic_checkout.date.valueOf()){
            
            $('#GroupTraffic_daterange_error').show();
            $('#GroupTraffic_daterange_error').html("please Select End date should be greater than Start date.");
        }else{
            $('#GroupTraffic_daterange_error').hide();
            getGroupTrafficDetails(GID);
        }
       // getGroupTrafficDetails(GID);
      
    }).data('datepicker');
      

function getGroupTrafficDetails(groupId){
    var startDate ;
      var endDate;
      
  if($("#GroupTraffic_StartDate").val()=="" && $("#GroupTraffic_EndDate").val()==""){
     
     SetDatesForGroupAnalytics('GroupTraffic_StartDate','GroupTraffic_EndDate');  
 }     
 scrollPleaseWait('Group_Traffic_Reports');

      


//if($("#GroupTraffic_StartDate").val()=="" && $("#GroupTraffic_EndDate").val()==""){
//    
// var d = new Date();
//var curr_date = d.getDate();
//var tomo_date = d.getDate()+1;
//var seven_date = d.getDate()-7;
//var curr_month = d.getMonth();
//curr_month++;
//var curr_year = d.getFullYear();
//var tomorrowsDate =(curr_month + "/" + curr_date + "/" + curr_year);
//var weekDate =(curr_month + "/" + seven_date + "/" + curr_year);
//
//   $("#GroupTraffic_StartDate").val(weekDate);
//   
//   $("#GroupTraffic_EndDate").val(tomorrowsDate);
// }

     startDate = $("#GroupTraffic_StartDate").val();
           endDate = $("#GroupTraffic_EndDate").val();
    var queryString = "startDate="+startDate+"&endDate="+endDate+"&groupId="+groupId;

     ajaxRequest('/analytics/getTrafficDetails',queryString, getGroupTrafficDetailsHandler);
}

function getGroupTrafficDetailsHandler(data1){
  
  scrollPleaseWaitClose('Group_Traffic_Reports'); 
    var data = data1.data;
    var mapData = eval("("+data1.json+")");
   // alert(mapData.toSource());
     var heighestValue = data1.heighestValue;
    var item = {
               
        'data':data
    };
    var mapDataObject = new Array();
   // var xyArray =  ['Year', 'Stream', 'Posts','Curbside','Groups','Events','Surveys','Hashtags'];
 var xyArray =  ['Year','Pageviews','Pagevisits'];
    mapDataObject.push(xyArray);
    var lastDate;
    $.each( mapData, function( key, value ) {
        lastDate = key;
        var record = new Array(eval(key));
        $.each( value, function( k, v ) {
            record.push(v);
        });
        mapDataObject.push(record);
    });
          
    var firstValue = mapDataObject[1][0];    
   var data = google.visualization.arrayToDataTable(mapDataObject);
   var gMax = "auto";
   var gheight=500;
   var slantedTextValue=true;
   var ticksValue="auto";
   var columns = [];
   var series = {};
   
if(heighestValue==0){
    gMax = 8;
    var gCount=2;
    gheight=500;
   
}else{
    gMax = getHeighestNumber(heighestValue);
}
        var c=1;
   for (var i = 0; i < data.getNumberOfColumns(); i++) {
        columns.push(i);
        if (i > 0) {
            series[i - 1] = {};
        }
       if(data.getColumnRange(i).max==0){
            var src = columns[i];
           c++;
                columns[i] = {
                        label: data.getColumnLabel(src),
                        type: data.getColumnType(src),
                       // sourceColumn: src,
                        calc: function () {
                           // return null;
                        }
                    };  
           }
    }
   
                
     var options = {
        title: '',
        fontSize:'11',
        pointSize:'4',
        fontName:'museo_slab500',
        height: gheight,
        orientation: 'horizontal',
        vAxis:{viewWindow: {min: 0, max:gMax}},
        hAxis: {slantedText:slantedTextValue}
       // legend:{position:'bottom',maxLines:2},
       
         // explorer:{keepInBounds: true , maxZoomIn: .5 ,maxZoomOut: 5,zoomDelta:1.5}
    };
     if(c == data.getNumberOfColumns()){
     // alert(firstValue+"---"+eval(lastDate));
        ticksValue = new Array(firstValue,eval(lastDate));
         options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
   }
  else if(mapDataObject.length ==2){
    slantedTextValue=false;
    ticksValue = new Array(eval(lastDate));
    options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
}
 else if(mapDataObject.length >2 && mapDataObject.length<5){
       slantedTextValue=false;
       options['hAxis']  = {slantedText:slantedTextValue};
  }
 
   var chart = new google.visualization.LineChart(document.getElementById('Group_Traffic_chart_div'));
   var view = new google.visualization.DataView(data);        
 
        view.setColumns(columns);
   chart.draw(view, options);
   $("#Group_Traffic_chart_div").css("height", gheight);               
                
                
 google.visualization.events.addListener(chart, 'select', function () {
        var sel = chart.getSelection();
        // if selection length is 0, we deselected an element
          if (sel.length > 0) {
            // if row is null, we clicked on the legend
            if (sel[0].row == null) {
                var col = sel[0].column;
               // alert(col)
                if (columns[col] == col) {
                    // hide the data series
                    columns[col] = {
                        label: data.getColumnLabel(col),
                        type: data.getColumnType(col),
                        calc: function () {
                            return null;
                        }
                    };

                    // grey out the legend entry
                    series[col - 1].color = '#CCCCCC';
                }
                else {
                    // show the data series
                    columns[col] = col;
                    series[col - 1].color = null;
                }
                var view = new google.visualization.DataView(data);
                view.setColumns(columns);
                  options['series']  = series;
                chart.draw(view, options);
            }
        }
    });
    

   analyticsCaptureImg(document.getElementById('Group_Traffic_chart_div'), document.getElementById('Group_Trafficimg_div'));
 
  
  
}
      
 function saveImageFromBase64(imgData){ 
        var queryString = "imgData="+imgData;        
        ajaxRequest("/analytics/analyticsSaveImageFromBase64", queryString, saveImageFromBase64handler);  
    }
    
function saveImageFromBase64handler(data){
        //scrollPleaseWaitClose();
       // alert("in hnadlerrrrrrrrrrrrrrr");
}
function getHeighestNumber(number){ 
    while(true){
        if(number%4==0){ 
           var q = number/4;
           if(q%2 == 0){
               return number; 
           }else{
              number=number+1;  
           }
           
        }else{
            number=number+1;
        }
    }
    }
    
 function SetDatesForGroupAnalytics(StartdatId,EnddateId){

var d = new Date();
var curr_date = d.getDate();
var tomo_date = d.getDate()+1;
var seven_date = d.getDate()-7;
var curr_month = d.getMonth();
curr_month++;
var curr_year = d.getFullYear();
var tomorrowsDate =(curr_month + "/" + curr_date + "/" + curr_year);
var weekDate =(curr_month + "/" + seven_date + "/" + curr_year);

     var todayTimeStamp = +new Date; // Unix timestamp in milliseconds
var oneDayTimeStamp = 7*(1000 * 60 * 60 * 24); // Milliseconds in a day
var diff = todayTimeStamp - oneDayTimeStamp;
var yesterdayDate = new Date(diff);
var yesterdayString = yesterdayDate.getFullYear() + '-' + (yesterdayDate.getMonth() + 1) + '-' + yesterdayDate.getDate();
var startyear=yesterdayDate.getFullYear();
var startMonth=(yesterdayDate.getMonth() + 1);
var startDate=yesterdayDate.getDate();
   
 weekDate=formatDates(startyear,startMonth,startDate, Global_date_Format);
 tomorrowsDate=formatDates(curr_year,curr_month,curr_date, Global_date_Format);
 
$('#'+StartdatId).val(weekDate);
   
   $('#'+EnddateId).val(tomorrowsDate);

}
   
    
    
    
    
    
    
</script>
<script type="text/javascript">
    $("#grouppost").addClass('active');
$("[rel=tooltip]").tooltip();
jQuery(document).ready(function () {
$('#tabs').tab();
});
if(detectDevices()){
    $("#group_activity_chart_div,#groupDevicechart_div,#groupLocationchart_div,#groupBrowserchart_div,#group_engagement_chart_div").attr("style","width:550px;height:550px");
    $("#Group_Traffic_chart_div").attr("style","width:100%; height: 550px;");
    $(".dropdown-menu").live('touchstart',function(event){
          event.stopPropogation(); 
      });

}else{
    $("#group_activity_chart_div,#groupDevicechart_div,#groupLocationchart_div,#groupBrowserchart_div,#group_engagement_chart_div").attr("style","width: 900px; height: 550px;");
    $("#Group_Traffic_chart_div").attr("style","width:100%; height: 550px;");
}
</script>
<!--<script type="text/javascript" src="https://canvg.googlecode.com/svn/trunk/rgbcolor.js"></script> 
<script type="text/javascript" src="https://canvg.googlecode.com/svn/trunk/canvg.js"></script>-->


