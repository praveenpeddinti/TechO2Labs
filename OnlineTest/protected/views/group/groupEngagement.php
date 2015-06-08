<?php
$dateFormat =  CommonUtility::getDateFormat();
    ?> 

        <div class="row-fluid marginT10">
            
        <div class="span12">
            <div id="engagement_daterange_error" class="alert alert-error" style="display: none;padding-left: 100px;"></div>
            <div class="analytics_topleaders_box">
                <div class="analytics_widgetheader">
                    

                <div class="row-fluid">
                   
                    <div class="span12">
                        <div class="span4">
                            <div class="analytics_widgettitle">
                     <span class=""><?php echo Yii::t('translation','Group_Engagement'); ?> <i class="cursor helpmanagement" data-id="GroupEngagementHelpDescription_DivId"><img src="/images/system/spacer.png" /></i></span>
                    
                </div>
                        </div><div class="span8">
                        <div class="analytics_datepicker pull-right">
                            <ul class="anlt_datepic">
                                <li>
<!--                                    <div class="row-fluid">-->
                                        <div class=" pull-right">

                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']?>" class="input-append date pull-left  " id="group_engDatePicker1">

                                                <label><?php echo Yii::t('translation','Start_Date'); ?></label>
                                                <input type="text"  id="GroupEngagement_StartDate" readonly="readonly" class="textfield " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>

                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']?>" class="input-append date pull-left " id="group_engDatePicker2">

                                                <label><?php echo Yii::t('translation','End_Date'); ?></label>
                                                <input type="text"  id="GroupEngagement_EndDate"  readonly="readonly" class="textfield  " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                               
                                            </div>

                                        </div>
<!--                                    </div>-->
                                </li>
                                <!-- -->
                                <li style="cursor:pointer; position: relative" class="dropdown pull-left">
                                    <a data-original-title="<?php echo Yii::t('translation','Advanced_Options'); ?>" rel="tooltip" data-placement="bottom" class="tooltiplink analytics_export " data-toggle="dropdown" id="drop2"><i><img src="/images/system/spacer.png" ><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>
                                            
                                            <li class="" ><a href="#"  target="_blank" onclick="openActivitypdf(this,'GroupEngagement')" id="groupEngagmentPdf" name="<?php echo Yii::t('translation','groupEngagmentPdf'); ?>"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> <?php echo Yii::t('translation','Export_as_PDF'); ?></a></li>
                                            <li class="" ><a href="#"  onclick="openActivityXls(this,'GroupEngagement')" id="groupEngagementXls"  target="_blank"><i><img src="/images/system/spacer.png" class="excel_doc"></i> <?php echo Yii::t('translation','Export_as_Excel'); ?></a></li>
                                        </ul>

                                    </div>
                                  </li>
                            </ul>
                        </div>
                        </div>
                        
                        
                        
                        
                    </div>
                    
                   
                </div>
                </div>
                <div id="group_engagementImg_div" style="display: none;"></div>
                 <div id="group_engagement_Reports" style="position: relative;"></div>
                <div class="row-fluid">
                    <div class="sapn12">
                        
                         
                        <div id="group_engagement_chart_div"></div>
                        
                        
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>


   <script type="text/javascript" language="javascript">
var engagmentCheckin;
var engagementCheckout;
var gGroupId;
var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0); 
    
  engagmentCheckin = $('#group_engDatePicker1').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if ((ev.date.valueOf() > engagementCheckout.date.valueOf()) || engagementCheckout.date.valueOf()!="") {
//            var newDate = new Date(ev.date)
//            newDate.setDate(newDate.getDate() + 0);
//            engagementCheckout.setValue(newDate);
        }
        engagmentCheckin.hide();
        $('#group_engDatePicker2')[0].focus();
    }).data('datepicker');
    
     engagementCheckout = $('#group_engDatePicker2').datepicker({
        onRender: function(date) {
           // return date.valueOf() < engagmentCheckin.date.valueOf() ? 'disabled' : '';
             return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        engagementCheckout.hide();
         if(engagmentCheckin.date.valueOf() > engagementCheckout.date.valueOf()){
          
            $('#engagement_daterange_error').show();
            $('#engagement_daterange_error').html("End Date should be greater than Start Date.");
            $('#engagement_daterange_error').fadeOut(3000);
        }else{
            $('#engagement_daterange_error').hide();
          getGroupEngagementDetails(gGroupId);
        }
        // getGroupEngagementDetails(gGroupId);
       // alert(gGroupId);
        
    }).data('datepicker');



function getGroupEngagementDetails(groupId){
    
    if($("#GroupEngagement_StartDate").val()=="" && $("#GroupEngagement_EndDate").val()==""){
     
     SetDatesForGroupAnalytics('GroupEngagement_StartDate','GroupEngagement_EndDate');  
 }
 gGroupId = groupId;
     scrollPleaseWait('group_engagement_Reports');
      var startDate ;
      var endDate;
      startDate = $("#GroupEngagement_StartDate").val();
      endDate = $("#GroupEngagement_EndDate").val();
    var queryString = "groupId="+groupId+"&startDate="+startDate+"&endDate="+endDate;
    //alert(queryString);
     ajaxRequest('/analytics/getGroupEngagementDetails',queryString,getGroupEngagementDetailsHandler);
}
function getGroupEngagementDetailsHandler(data1){ 
    scrollPleaseWaitClose('group_engagement_Reports'); 
   //alert("handler");
    var data = data1.data;
    var mapData = eval("("+data1.json+")");
      var heighestValue = data1.heighestValue;
    var item = {
               
        'data':data
    };
//    $( "#admin_content" ).html(
//        $( "#trafficTmpl").render(item)
//        );
//              
              
    var mapDataObject = new Array();
   // var xyArray =  ['Year', 'Stream', 'Posts','Curbside','Groups','Events','Surveys','Hashtags'];
    var xyArray =  ['Year', 'Stream','Posts','Sub Groups','Events','Quick Poll','Search','Hashtags'];
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
  var gheight=600;
   var slantedTextValue=true;
   var ticksValue="auto";
   var columns = [];
   var series = {};
if(heighestValue==0){
    gMax = 8;
   var  gCount=2;
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
         hAxis: {slantedText:slantedTextValue},
        //  legend:{position:'bottom'}
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

   

    var chart = new google.visualization.LineChart(document.getElementById('group_engagement_chart_div'));
    var view = new google.visualization.DataView(data);        
    view.setColumns(columns);
    chart.draw(view, options);
 $("#group_engagement_chart_div").css("height", gheight);
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
   analyticsCaptureImg(document.getElementById('group_engagement_chart_div'), document.getElementById('group_engagementImg_div'));

}






</script>             
                