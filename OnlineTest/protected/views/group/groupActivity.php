<?php
$dateFormat =  CommonUtility::getDateFormat();
    ?> 
<div class="row-fluid marginT10">
        <div class="span12">
            <div class="analytics_topleaders_box">
                <div class="analytics_widgetheader">
                <div id="activity_daterange_error" class="alert alert-error" style="display: none;padding-left: 100px;"></div>
                <div class="row-fluid">
                   
                    <div class="span12">
                        <div class="span4">
                            <div class="analytics_widgettitle">
                     <span class=""><?php echo Yii::t('translation','Group_Activity'); ?> <i class="cursor helpmanagement" data-id="GroupActivityHelpDescription_DivId" ><img src="/images/system/spacer.png" /></i></span>
                    
                </div>
                        </div><div class="span8">
                        <div class="analytics_datepicker pull-right">
                            <ul class="anlt_datepic">
                                <li>
<!--                                    <div class="row-fluid">-->
                                        <div class="pull-right">


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']?>" class="input-append date span6  " id="group_ActivityDatePicker1">


                                                <label><?php echo Yii::t('translation','Start_Date'); ?></label>
                                                <input type="text"  id="GroupActivity_StartDate" readonly="readonly" class="textfield " maxlength="20" value="">
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>

                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']?>" class="input-append date span6 " id="group_ActivityDatePicker2">


                                                <label><?php echo Yii::t('translation','End_Date'); ?></label>
                                                <input type="text"  id="GroupActivity_EndDate"  readonly="readonly" class="textfield  " maxlength="20" value="">     
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
                                            
                                            <li class="" ><a href="#"  target="_blank" onclick="openGroupActivitypdf(this,'GroupActivity')" id="groupActivityPdf" name="groupActivityPdf"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i><?php echo Yii::t('translation','Export_as_PDF'); ?></a></li>
                                            <li class="" ><a href="#"  onclick="openActivityXls(this,'GroupActivity')" id="groupActivityXls"  target="_blank"><i><img src="/images/system/spacer.png" class="excel_doc"></i><?php echo Yii::t('translation','Export_as_Excel'); ?></a></li>
                                        </ul>
                                    </div>
                                  </li>
                            </ul>
                        </div>
                    </div> </div>
                </div>
                </div>
                <div id="group_activityImg_div" style="display: none;"></div>
                 <div id="group_activity_Reports" style="position: relative;"></div>
                <div class="row-fluid">
                    <div class="sapn12 positionrelative">
                        <div id="group_activity_chart_div" style="width: 100%; height: 550px;"></div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" language="javascript">
var activityCheckin;
var activityCheckout;
var gGroupId;


function getGroupActivityDetails(groupId){
    
  if($("#GroupActivity_StartDate").val()=="" && $("#GroupActivity_EndDate").val()==""){
     
     SetDatesForGroupAnalytics('GroupActivity_StartDate','GroupActivity_EndDate');  
 }   
    
    
 gGroupId = groupId;
     scrollPleaseWait('group_activity_Reports');
      var startDate ;
      var endDate;
      startDate = $("#GroupActivity_StartDate").val();
      endDate = $("#GroupActivity_EndDate").val();
    var queryString = "groupId="+groupId+"&startDate="+startDate+"&endDate="+endDate;
     ajaxRequest('/analytics/getGroupActivityDetails',queryString,getGroupActivityDetailsHandler);
}
function getGroupActivityDetailsHandler(data1){ 
    scrollPleaseWaitClose('group_activity_Reports'); 
   //alert("handler");
    var data = data1.data;
    var mapData = eval("("+data1.json+")");
    var heighestValue = data1.heighestValue;
    var item = {
               
        'data':data
    };
              
    var mapDataObject = new Array();
    var xyArray =  ['Year', 'Posts','Event Posts','Quick Poll Posts','Follows', 'Active Users', 'Come back Users'];
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
        var  gCount=2;
        var gheight=300;

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
          series: {
            0: { color: '#950303' },
            1: { color: '#EA3CDB' },
            2: { color: '#933CEA' },
            3: { color: '#2233D4' },
            4: { color: '#22D4C2' },
            5: { color: '#43459d' },
            6: { color: '#2093F7' },
            7: { color: '#2AC63F' },
            8: { color: '#E5C822' },
            9: { color: '#E55C22' },
           
          },
        title: '',
        fontSize:'11',
        pointSize:'4',
        fontName:'museo_slab500',
        height: gheight,
        orientation: 'horizontal',
        vAxis:{viewWindow: {min: 0, max:gMax}},
        hAxis: {slantedText:slantedTextValue},
    };
    
         if(c == data.getNumberOfColumns()){
     // alert(firstValue+"---"+eval(lastDate));
        ticksValue = new Array(firstValue,eval(lastDate));
         options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
   }
        if(mapDataObject.length ==2){
            slantedTextValue=false;
            ticksValue = new Array(eval(lastDate));
            options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
        }
        
        else if(mapDataObject.length >2 && mapDataObject.length<5){
        slantedTextValue=false;
        options['hAxis']  = {slantedText:slantedTextValue};
       }

    var chart = new google.visualization.LineChart(document.getElementById('group_activity_chart_div'));
    var view = new google.visualization.DataView(data);        
    view.setColumns(columns);
    chart.draw(view, options);
    $("#group_activity_chart_div").css("height", gheight);
    
    
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
   groupActivityAnalyticsCaptureImg(document.getElementById('group_activity_chart_div'), document.getElementById('group_activityImg_div'));

}

var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0); 
    
  activityCheckin = $('#group_ActivityDatePicker1').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if ((ev.date.valueOf() > activityCheckout.date.valueOf()) || activityCheckout.date.valueOf()!="") {
//            var newDate = new Date(ev.date)
//            newDate.setDate(newDate.getDate() + 0);
//            activityCheckout.setValue(newDate);
        }
        activityCheckin.hide();
        $('#group_ActivityDatePicker2')[0].focus();
    }).data('datepicker');
    
     activityCheckout = $('#group_ActivityDatePicker2').datepicker({
        onRender: function(date) {
           return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        activityCheckout.hide();
        
        if(activityCheckin.date.valueOf() > activityCheckout.date.valueOf()){
          
            $('#activity_daterange_error').show();
            $('#activity_daterange_error').html("End Date should be greater than Start Date.");
            $('#activity_daterange_error').fadeOut(3000);
        }else{
            $('#activity_daterange_error').hide();
          getGroupActivityDetails(gGroupId);
        }
        
         //getGroupActivityDetails(gGroupId);
        
    }).data('datepicker');



function openGroupActivitypdf(obj,analyticType){
    var g_datesA = $("#"+analyticType+"_StartDate").val()+" to "+$("#"+analyticType+"_EndDate").val();
    $("#"+obj.id).attr("href", "/analytics/Pdf?date="+g_datesA+"&analyticType="+analyticType);

}


 function groupActivityAnalyticsCaptureImg(chartContainer, imgContainer) {
        var doc = chartContainer.ownerDocument;
        var img = doc.createElement('img');
        img.src = getImgDataGroupActivity(chartContainer);
        saveAsImgGroupActivity(chartContainer);
        img.id=chartContainer.id+"_img";
        while (imgContainer.firstChild) {
          imgContainer.removeChild(imgContainer.firstChild);
          
        }
        imgContainer.appendChild(img);
        
       
      }
     function getImgDataGroupActivity(chartContainer) {  
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
 function saveAsImgGroupActivity(chartContainer) { 
        var imgData = getImgDataGroupActivity(chartContainer);
        saveImageFromBase64(imgData);
        // Replacing the mime-type will force the browser to trigger a download
        // rather than displaying the image in the browser window.
//        window.location = imgData.replace("image/png", "image/octet-stream");
      }
      
 function saveImageFromBase64(imgData){ 
        var queryString = "imgData="+imgData;        
        ajaxRequest("/analytics/analyticsSaveImageFromBase64", queryString, saveImageFromBase64handler);  
    }
    
function saveImageFromBase64handler(data){
        //scrollPleaseWaitClose();
       // alert("in hnadlerrrrrrrrrrrrrrr");
}
</script>