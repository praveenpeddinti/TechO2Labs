<?php
$dateFormat =  CommonUtility::getDateFormat();
    ?> 

<div class="row-fluid marginT10">
        <div class="sapn12">
            <div class="analytics_topleaders_box">
                                      <div id="engagement_daterange_error" class="alert alert-error" style="display: none;padding-left: 100px;"></div>
<div class="analytics_widgetheader">
                <div class="row-fluid">
                   
                    <div class="span12">
                         <div class="span4">
                            <div class="analytics_widgettitle">
                     <span class="">Engagement <i  class="cursor helpmanagement" data-id="EngagementHelpDescription_DivId" ><img src="/images/system/spacer.png" data-original-title="Engagement Help" rel="tooltip" data-placement="bottom" /></i></span>
                    
                </div>
                        </div>
                        <div class="span8">
                        <div class="analytics_datepicker pull-right">
                            <ul class="anlt_datepic">
                                <li>
<!--                                    <div class="row-fluid">-->
                                        <div class="pull-right">

                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']?>" class="input-append date  pull-left " id="engDatePicker1">

                                                <label>Start Date</label>
                                                <input type="text"  id="Engagement_StartDate" readonly="readonly" class="textfield " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>

                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']?>" class="input-append date pull-left " id="engDatePicker2">

                                                <label>End Date</label>
                                                <input type="text"  id="Engagement_EndDate"  readonly="readonly" class="textfield  " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                               
                                            </div>

                                        </div>
<!--                                    </div>-->
                                </li>
                                <!-- -->
                                <li style="white-space:nowrap;cursor:pointer; position: relative" class="dropdown pull-left">
                                    <a data-original-title="Advanced Options" rel="tooltip" data-placement="bottom" class="tooltiplink analytics_export " data-toggle="dropdown" id="drop2"><i><img src="/images/system/spacer.png" ><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>
                                            
                                            <li class="" ><a href="#"  target="_blank" onclick="openActivitypdf(this,'Engagement')" id="engagmentPdf" name="engagmentPdf"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> Export as PDF</a></li>
                                            <li class="" ><a href="#"  onclick="openActivityXls(this,'Engagement')" id="engagementXls"  target="_blank"><i><img src="/images/system/spacer.png" class="excel_doc" onclick="openActivityXls()"></i> Export as Excel</a></li>
                                        </ul>

                                    </div>
                                  </li>
                            </ul>
                        </div>
                       
                        
                         </div>
                        
                        
                    </div>
                    
                   
                </div>
</div>
                <div id="engagementImg_div" style="display: none;"></div>
                 <div id="engagement_Reports" style="position: relative;"></div>
                <div class="row-fluid">
                    <div class="sapn12 positionrelative">
                        

                        <div id="engagement_chart_div"></div>

                        
                    </div>
                </div>

                
                
            </div>
        </div>
    </div>


   <script type="text/javascript" language="javascript">

var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0); 
    
 var engagmentCheckin = $('#engDatePicker1').datepicker({
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
        $('#engDatePicker2')[0].focus();
    }).data('datepicker');
    
    var engagementCheckout = $('#engDatePicker2').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        engagementCheckout.hide();
       // alert(new Date($("#Engagement_StartDate").val().valueOf())+"---"+new Date($("#Engagement_EndDate").val().valueOf()));
        if(new Date($("#Engagement_StartDate").val().valueOf()) > new Date($("#Engagement_EndDate").val().valueOf())){
          
            $('#engagement_daterange_error').show();
            $('#engagement_daterange_error').html("End Date should be greater than Start Date.");
            $('#engagement_daterange_error').fadeOut(3000);
        }else{
            $('#engagement_daterange_error').hide();
           getEngagementDetails('des');
          
        }
      
    }).data('datepicker');



function getEngagementDetails(flag){
    if($("#Engagement_StartDate").val()=="" && $("#Engagement_EndDate").val()==""){
     
    SetDatesForAnalytics('Engagement_StartDate','Engagement_EndDate');   
 }
    
     scrollPleaseWait('engagement_Reports');
      var startDate ;
      var endDate;
    
           startDate = $("#Engagement_StartDate").val();
           endDate = $("#Engagement_EndDate").val();

     
    var queryString = "startDate="+startDate+"&endDate="+endDate;
   //alert(queryString);
     ajaxRequest('/analytics/getEngagementDetails',queryString, getEngagementDetailsHandler);
}
function getEngagementDetailsHandler(data1){ 
    scrollPleaseWaitClose('engagement_Reports'); 
    var data = data1.data;
    var mapData = eval("("+data1.json+")");
   // alert(mapData.toSource());
     var heighestValue = data1.heighestValue;
    var item = {
               
        'data':data
    };
    var mapDataObject = new Array();
   // var xyArray =  ['Year', 'Stream', 'Posts','Curbside','Groups','Events','Surveys','Hashtags'];
//    if(data1.Gameavailable=='ON'){
//        var xyArray =  ['Year', 'Stream','Posts','Curbside','Events','Surveys','Groups','Hashtags','News','Games'];
//    }else{
//        var xyArray =  ['Year', 'Stream','Posts','Curbside','Events','Surveys','Groups','Hashtags','News'];
//    }
    var xyArray=data1.lablesArray
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
 
   var chart = new google.visualization.LineChart(document.getElementById('engagement_chart_div'));
   var view = new google.visualization.DataView(data);        
 
        view.setColumns(columns);
   chart.draw(view, options);
   $("#engagement_chart_div").css("height", gheight);               
                
                
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
    
   analyticsCaptureImg(document.getElementById('engagement_chart_div'), document.getElementById('engagementImg_div'));
}






</script>             
                