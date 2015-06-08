<?php
$dateFormat =  CommonUtility::getDateFormat();
?>    
<div class="row-fluid marginT10" id="deviceUsabilityId">
        <div class="span12">
            <div id="deviceActivity_daterange_error" class="alert alert-error" style="display: none;padding-left: 100px;"></div>
            <div class="analytics_topleaders_box ">
                
               <div class="analytics_widgetheader">
                <div class="row-fluid">
                   
                    <div class="span12">
                        <div class="pull-left paddingtop12">
                        <div class="analytics_widgettitle pull-left analytics_widgetsub" style="padding:0">
                     <span >Usability-<b>Devices</b> <i class="cursor helpmanagement" data-id="UsabilityHelpDescription_DivId"><img src="/images/system/spacer.png" data-original-title="Usability Help" rel="tooltip" data-placement="bottom" /></i></span>
                    
                </div>
                         <div class="switch_mode pull-left " style="padding-left:10px">
                           
                	<ul>
                    	<li class="active" id="deviceLineChart"> <a  class="linechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="Line chart" src="/images/system/spacer.png" /></a></li>
                        <li  id="devicePieChart" ><a  class="piechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="Pie chart" src="/images/system/spacer.png" /></a></li>
                        </ul>
                </div> </div>
                        <div class="analytics_datepicker pull-right">
                            <ul class="anlt_datepic">
                                <li>
                                    
                                        <div class=" pull-right">


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left  " id="deviceUsability_dpd1">


                                                <label>Start Date</label>
                                                <input type="text"  id="DeviceUsability_StartDate" readonly="readonly" class="textfield " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left " id="deviceUsability_dpd2">


                                                <label>End Date</label>
                                                <input type="text"  id="DeviceUsability_EndDate"  readonly="readonly" class="textfield  " maxlength="20" value="">   
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                               
                                            </div>

                                        </div>
                                   
                                </li>
                                <!-- -->
                                <li style="cursor:pointer; position: relative" class="dropdown pull-left">
                                    <a data-original-title="Advanced Options" rel="tooltip" data-placement="bottom" class="tooltiplink analytics_export " data-toggle="dropdown" id="drop2"><i><img src="/images/system/spacer.png" ><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>
                                            
                                            <li class="" ><a onclick="openUsabilityActivitypdf(this,'DeviceUsability')" id="deviceActivityPdf" name="deviceActivityPdf"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> Export as PDF</a></li>
                                            <li class="" ><a onclick="openDeviceUsabilityActivityXls(this,'DeviceUsability')" id="deviceActivityXls"  target="_blank"><i><img src="/images/system/spacer.png" class="excel_doc"></i> Export as Excel</a></li>
                                        </ul>

                                    </div>
                                  </li>
                            </ul>
                        </div>
                    </div>
                </div>
               </div>
                <div id="deviceactivityimg_div" style="display: none;"></div>
                 <div id="deviceUsability_Reports" style="position: relative;"></div>
                <div class="row-fluid">
                    <div class="sapn12 positionrelative">
                        <div id="devicechart_div"></div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="row-fluid padding8top" id="locationUsabilityId">
        <div class="sapn12">
            <div id="locationActivity_daterange_error" class="alert alert-error" style="display: none;padding-left: 100px;"></div>
            <div class="analytics_topleaders_box">
                
               <div class="analytics_widgetheader">
                <div class="row-fluid">
                   
                    <div class="span12">
                        <div class="pull-left paddingtop12">
                        <div class="analytics_widgettitle pull-left analytics_widgetsub" style="padding:0">
                     <span >Usability-<b>Locations</b> <i class="cursor helpmanagement" data-id="UsabilityHelpDescription_DivId" ><img src="/images/system/spacer.png" data-original-title="Usability Help" rel="tooltip" data-placement="bottom" /></i></span>
                    
                </div>
                         <div class="switch_mode pull-left " style="padding-left:10px">
                           
                	<ul>
                                <li class="active" id="locationLineChart"> <a  class="linechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="Line chart" src="/images/system/spacer.png" /></a></li>
                                <li  id="locationPieChart" ><a  class="piechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="Pie chart" src="/images/system/spacer.png" /></a></li>
                            </ul>
                </div> </div>
                        
                        <div class="analytics_datepicker pull-right">
                            <ul class="anlt_datepic">
                                <li>
                                   
                                        <div class=" pull-right">


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left  " id="locationUsability_dpd1">


                                                <label>Start Date</label>
                                                <input type="text"  id="LocationUsability_StartDate" readonly="readonly" class="textfield " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>

                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left " id="locationUsability_dpd2">


                                                <label>End Date</label>
                                                <input type="text"  id="LocationUsability_EndDate"  readonly="readonly" class="textfield  " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                               
                                            </div>

                                        </div>
                                  
                                </li>
                                <!-- -->
                                <li style="cursor:pointer; position: relative" class="dropdown pull-left">
                                    <a data-original-title="Advanced Options" rel="tooltip" data-placement="bottom" class="tooltiplink analytics_export " data-toggle="dropdown" id="drop2"><i><img src="/images/system/spacer.png" ><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>
                                            
                                            <li class="" ><a onclick="openUsabilityActivitypdf(this,'LocationUsability')" id="locationActivityPdf" name="locationActivityPdf"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> Export as PDF</a></li>
                                            <li class="" ><a href="/analytics/GenerateXLS?startdate=1234&enddate=456"  onclick="openLocationUsabilityActivityXls(this,'LocationUsability')" id="locationActivityXls"  target="_blank"><i><img src="/images/system/spacer.png" class="excel_doc" onclick="openActivityXls()"></i> Export as Excel</a></li>
                                        </ul>

                                    </div>
                                  </li>
                            </ul>
                        </div>
                    </div>
                </div>
               </div>
                <div id="locationactivityimg_div" style="display: none;"></div>
                <div id="locationUsability_Reports" style="position: relative;"></div>
                <div class="row-fluid">
                    <div class="sapn12 positionrelative">
                        <div id="locationchart_div"></div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="row-fluid padding8top" id="browserUsabilityId">
        <div class="sapn12">
             <div id="browserActivity_daterange_error" class="alert alert-error" style="display: none;padding-left: 100px;"></div>
            <div class="analytics_topleaders_box">
               <div class="analytics_widgetheader">
                <div class="row-fluid">
                   
                    <div class="span12">
                          <div class="pull-left paddingtop12">
                        <div class="analytics_widgettitle pull-left analytics_widgetsub" style="padding:0;white-space: nowrap;margin-right:10px">
                     <span >Usability-<b>Browsers</b> <i class="cursor helpmanagement" data-id="UsabilityHelpDescription_DivId" ><img src="/images/system/spacer.png" data-original-title="Usability Help" rel="tooltip" data-placement="bottom" /></i></span>
                    
                </div>
                         <div class="switch_mode pull-left ">
                           
                	 <ul style="white-space: nowrap;">
                                <li class="active" id="browserLineChart"> <a  class="linechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="Line chart" src="/images/system/spacer.png" /></a></li>
                                <li  id="browserPieChart" ><a  class="piechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="Pie chart" src="/images/system/spacer.png" /></a></li>
                            </ul>
                </div> </div>
                       
                        <div class="analytics_datepicker pull-right">
                            <ul class="anlt_datepic">
                                <li>
                                   
                                        <div class=" pull-right">


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left  " id="browserUsability_dpd1">


                                                <label>Start Date</label>
                                                <input type="text"  id="BrowserUsability_StartDate" readonly="readonly" class="textfield " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left " id="browserUsability_dpd2">


                                                <label>End Date</label>
                                                <input type="text"  id="BrowserUsability_EndDate"  readonly="readonly" class="textfield  " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                               
                                            </div>

                                        </div>
                                   
                                </li>
                                <!-- -->
                                <li style="cursor:pointer; position: relative" class="dropdown pull-left">
                                    <a data-original-title="Advanced Options" rel="tooltip" data-placement="bottom" class="tooltiplink analytics_export " data-toggle="dropdown" id="drop2"><i><img src="/images/system/spacer.png" ><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>
                                            
                                            <li class="" ><a onclick="openUsabilityActivitypdf(this,'BrowserUsability')" id="browserActivityPdf" name="browserActivityPdf"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> Export as PDF</a></li>
                                            <li class="" ><a href="/analytics/GenerateXLS?startdate=1234&enddate=456"  onclick="openBrowserUsabilityActivityXls(this,'BrowserUsability')" id="browserActivityXls"  target="_blank"><i><img src="/images/system/spacer.png" class="excel_doc" onclick="openActivityXls()"></i> Export as Excel</a></li>
                                        </ul>

                                    </div>
                                  </li>
                            </ul>
                        </div>
                      </div>
                </div>
               </div>
                <div id="browseractivityimg_div" style="display: none;"></div>
                 <div id="browserUsability_Reports" style="position: relative;"></div>
                <div class="row-fluid">
                    <div class="sapn12 positionrelative">
                        <div id="browserchart_div"></div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>




<script type="text/javascript" >
    
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0); 
    
     $("#deviceLineChart").live("click",
            function() {
                $( "#deviceLineChart" ).addClass("active");
                $( "#devicePieChart" ).removeClass("active");
                getDevicesUsabilityLineGraph('default');
            }
    );
    
    $("#devicePieChart").live("click",
            function() {
                $( "#deviceLineChart" ).removeClass("active");
                $( "#devicePieChart" ).addClass("active");
                getDevicesUsabilityPieGraph('default');
            }
    );
    
    $("#browserLineChart").live("click",
            function() {
                $( "#browserLineChart" ).addClass("active");
                $( "#browserPieChart" ).removeClass("active");
                getBrowserUsabilityLineGraph('default');
            }
    );
    
    $("#browserPieChart").live("click",
            function() {
                $( "#browserLineChart" ).removeClass("active");
                $( "#browserPieChart" ).addClass("active");
                getBrowserUsabilityPieGraph('default');
            }
    );
    
     $("#locationLineChart").live("click",
            function() {
                $( "#locationLineChart" ).addClass("active");
                $( "#locationPieChart" ).removeClass("active");
                getLocationUsabilityLineGraph('default');
            }
    );
    
    $("#locationPieChart").live("click",
            function() {
                $( "#locationLineChart" ).removeClass("active");
                $( "#locationPieChart" ).addClass("active");
                getLocationUsabilityPieGraph('default');
            }
    );
    
    function getUsabilityDetails(flag){
    
     scrollPleaseWait('deviceUsability_Reports');

     getDevicesUsabilityLineGraph(flag);
     getLocationUsabilityLineGraph(flag);
     getBrowserUsabilityLineGraph(flag);

}

function getDevicesUsabilityLineGraph(flag)
{
    if($("#DeviceUsability_StartDate").val()=="" && $("#DeviceUsability_EndDate").val()==""){
     
    SetDatesForAnalytics('DeviceUsability_StartDate','DeviceUsability_EndDate');   
    }
      scrollPleaseWait('deviceUsability_Reports');
      var startDate ;
      var endDate;
      startDate = $("#DeviceUsability_StartDate").val();
      endDate = $("#DeviceUsability_EndDate").val();
      var queryString = "startDate="+startDate+"&endDate="+endDate+"&UsabilityType=Device";
         
      ajaxRequest('/analytics/getUsabilityDetails',queryString, getDeviceLineGraphUsabilityDetailsHandler);
}
function getDeviceLineGraphUsabilityDetailsHandler(data1){
    $("#devicechart_div").val('');
    scrollPleaseWaitClose('deviceUsability_Reports'); 
    var data = data1.data;
  
    var mapData = eval("("+data1.json+")");
    var heighestValue = data1.heighestValue;
    var item = {
               
        'data':data
    };
          
    var mapDataObject = new Array();
    var lastDate;
        $.each( mapData, function( key, value ) {
            lastDate = key;
         var gkey="";
        if(key=="Year"){
       
            gkey=  key;
        }else{
                 gkey=  eval(key);
        }
          var record = new Array(gkey);
          if(key=="Year" && value == ""){
              record.push("No Data"); 
          }else if(value==""){
              record.push(0); 
          }
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
        gMax =8;
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
            width:900,
            orientation: 'horizontal',
            vAxis:{viewWindow: {min: 0, max:gMax}},
            hAxis: {slantedText:slantedTextValue},
        };
       
          if(c == data.getNumberOfColumns()){
            ticksValue = new Array(firstValue,eval(lastDate));
             options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
        }
            else if(mapDataObject.length ==2){
                //alert("--------else if 1-----"+mapDataObject.length);
            slantedTextValue=false;
            ticksValue = new Array(eval(lastDate));
            options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
        }
            else if(mapDataObject.length >2 && mapDataObject.length<5){
                 //alert("--------else if 2-----"+mapDataObject.length);
              slantedTextValue=false;
              options['hAxis']  = {slantedText:slantedTextValue};
         }

        var chart = new google.visualization.LineChart(document.getElementById('devicechart_div'));
        var view = new google.visualization.DataView(data);  
        //alert("--------"+columns);

       view.setColumns(columns);
       chart.draw(view, options);

         $("#devicechart_div").css("height", gheight);  

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
   
}

/*
 * For display grap for different devices on date change----------------start----------------
 */
    
      var deviceUsability_checkin = $('#deviceUsability_dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        
        if ((ev.date.valueOf() > deviceUsability_checkout.date.valueOf()) || deviceUsability_checkout.date.valueOf()!="") {
//            var newDate = new Date(ev.date)
//            newDate.setDate(newDate.getDate() + 0);
//            deviceUsability_checkout.setValue(newDate);
        }
        deviceUsability_checkin.hide();
        $('#deviceUsability_dpd2')[0].focus();
    }).data('datepicker');
    
    var deviceUsability_checkout = $('#deviceUsability_dpd2').datepicker({
        onRender: function(date) {
           return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        deviceUsability_checkout.hide();
        
        if($('#devicePieChart').attr('class') == 'active')
        {
            if(deviceUsability_checkin.date.valueOf() > deviceUsability_checkout.date.valueOf()){
          
            $('#deviceActivity_daterange_error').show();
            $('#deviceActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#deviceActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#deviceActivity_daterange_error').hide();
                 getDevicesUsabilityPieGraph('des');
             }
            
        }
        else
        {
            if(new Date($("#DeviceUsability_StartDate").val().valueOf()) > new Date($("#DeviceUsability_EndDate").val().valueOf()))    
        {
          
            $('#deviceActivity_daterange_error').show();
            $('#deviceActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#deviceActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#deviceActivity_daterange_error').hide();
               getDevicesUsabilityLineGraph('des');
             }
            
        }
        
    }).data('datepicker');
    //---------------------end-------------------
    
    
    
     function getDevicesUsabilityPieGraph(flag)
    {
        scrollPleaseWait('deviceUsability_Reports');
          var startDate ;
          var endDate;
         if(flag!="default"){
               startDate = $("#DeviceUsability_StartDate").val();
               endDate = $("#DeviceUsability_EndDate").val();
         }
             var queryString = "startDate="+startDate+"&endDate="+endDate+"&UsabilityType=Device";
         ajaxRequest('/analytics/getUsabilityPieChartDetails',queryString, getDeviceUsabilityPieChartDetailsHandler);
    }


    function getDeviceUsabilityPieChartDetailsHandler(dData)
    {
        scrollPleaseWaitClose('deviceUsability_Reports'); 
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawDevicePieChart(dData));
      
     
    }
    function drawDevicePieChart(dData) {
        
        $("#devicechart_div").val('');
          dData = eval('('+dData.json+')');
        var deviceArray = new Array();
        deviceArray[0] = ['Device', 'Count'];
        var i=1;
        $.each( dData, function( key, value ) { 
                deviceArray[i] = [value.device,parseInt(value.count)];
                i++;
        });   
        var data = google.visualization.arrayToDataTable(deviceArray);

        var options = {
           pieHole: 0.4,


        };

        var chart = new google.visualization.PieChart(document.getElementById('devicechart_div'));
        chart.draw(data, options);
        
      }
            
/*
 * -----------------------------------Usablity graph for Device------------------end----------------
 */
      
/*
 * -----------------------------------Usablity graph for Locations------------------start----------------
 */
function getLocationUsabilityLineGraph(flag)
{
    if($("#LocationUsability_StartDate").val()=="" && $("#LocationUsability_EndDate").val()==""){
     
    SetDatesForAnalytics('LocationUsability_StartDate','LocationUsability_EndDate');   
    }
    scrollPleaseWait('locationUsability_Reports');
      var startDate ;
      var endDate;

        startDate = $("#LocationUsability_StartDate").val();
        endDate = $("#LocationUsability_EndDate").val();
         var queryString = "startDate="+startDate+"&endDate="+endDate+"&UsabilityType=Location";
     ajaxRequest('/analytics/getUsabilityDetails',queryString, getLocationLineGraphUsabilityDetailsHandler);
}
function getLocationLineGraphUsabilityDetailsHandler(data2){  

    $("#locationchart_div").val('');
    scrollPleaseWaitClose('locationUsability_Reports'); 
   
    var data = data2.data;
    var mapData = eval("("+data2.json+")");
    var heighestValue = data2.heighestValue;
    
    var item = {
               
        'data':data
    };
          
    var mapDataObject = new Array();
    var lastDate;
        $.each( mapData, function( key, value ) {
            lastDate = key;
         var gkey="";
        if(key=="Year"){
       
            gkey=  key;
        }else{
                 gkey=  eval(key);
        }
          var record = new Array(gkey);
          if(key=="Year" && value == ""){
              record.push("No Data"); 
          }else if(value==""){
              record.push(0); 
          }
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
        gMax =8;
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
            width:900,
            orientation: 'horizontal',
            vAxis:{viewWindow: {min: 0, max:gMax}},
            hAxis: {slantedText:slantedTextValue},
        };
       
          if(c == data.getNumberOfColumns()){
            ticksValue = new Array(firstValue,eval(lastDate));
             options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
        }
            else if(mapDataObject.length ==2){
                //alert("--------else if 1-----"+mapDataObject.length);
            slantedTextValue=false;
            ticksValue = new Array(eval(lastDate));
            options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
        }
            else if(mapDataObject.length >2 && mapDataObject.length<5){
                 //alert("--------else if 2-----"+mapDataObject.length);
              slantedTextValue=false;
              options['hAxis']  = {slantedText:slantedTextValue};
         }

        var chart = new google.visualization.LineChart(document.getElementById('locationchart_div'));
        var view = new google.visualization.DataView(data);  
        //alert("--------"+columns);

       view.setColumns(columns);
       chart.draw(view, options);

         $("#locationchart_div").css("height", gheight);  

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
   
}

  /*
 * For display grap for different locations on date change---------start---------------
 */
    
      var locationUsability_checkin = $('#locationUsability_dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        
        if ((ev.date.valueOf() > locationUsability_checkout.date.valueOf()) || locationUsability_checkout.date.valueOf()!="") {
//            var newDate = new Date(ev.date)
//            newDate.setDate(newDate.getDate() + 0);
//            deviceUsability_checkout.setValue(newDate);
        }
        locationUsability_checkin.hide();
        $('#locationUsability_dpd2')[0].focus();
    }).data('datepicker');
    
    var locationUsability_checkout = $('#locationUsability_dpd2').datepicker({
        onRender: function(date) {
           return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        locationUsability_checkout.hide();
        
        if($('#locationPieChart').attr('class') == 'active')
        {
            if(locationUsability_checkin.date.valueOf() > locationUsability_checkout.date.valueOf()){
          
            $('#locationActivity_daterange_error').show();
            $('#locationActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#locationActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#locationActivity_daterange_error').hide();
                 getLocationUsabilityPieGraph('des');
             }
            
        }
        else
        {
            if(new Date($("#LocationUsability_StartDate").val().valueOf()) > new Date($("#LocationUsability_EndDate").val().valueOf()))    
        {
          
            $('#locationActivity_daterange_error').show();
            $('#locationActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#locationActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#locationActivity_daterange_error').hide();
               getLocationUsabilityLineGraph('des');
             }
            
        }
        
    }).data('datepicker');
     //---------------------end------------------- 
     
       function getLocationUsabilityPieGraph(flag)
    {
           scrollPleaseWait('locationUsability_Reports');
            var startDate ;
            var endDate;
           if(flag!="default"){
                 startDate = $("#LocationUsability_StartDate").val();
                 endDate = $("#LocationUsability_EndDate").val();
           }
             var queryString = "startDate="+startDate+"&endDate="+endDate+"&UsabilityType=Location";
         ajaxRequest('/analytics/getUsabilityPieChartDetails',queryString, getLocationUsabilityPieChartDetailsHandler);
    }


    function getLocationUsabilityPieChartDetailsHandler(dData)
    {
      scrollPleaseWaitClose('locationUsability_Reports');
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawLocationPieChart(dData));
      
     
    }
    function drawLocationPieChart(dData) {
       
        $("#locationchart_div").val('');
        dData = eval('('+dData.json+')');
        var locationArray = new Array();
        locationArray[0] = ['Locations', 'Count'];
        var i=1;
        $.each( dData, function( key, value ) { 
                locationArray[i] = [value.locations,parseInt(value.count)];
                i++;
        });   
        var data = google.visualization.arrayToDataTable(locationArray);

        var options = {
           pieHole: 0.4,


        };

        var chart = new google.visualization.PieChart(document.getElementById('locationchart_div'));
        chart.draw(data, options);
      }
      
 /*
 * -----------------------------------Usablity graph for Locations------------------end----------------
 */

 /*
 * -----------------------------------Usablity graph for Browser------------------start----------------
 */
function getBrowserUsabilityLineGraph(flag)
{
   
    if($("#BrowserUsability_StartDate").val()=="" && $("#BrowserUsability_EndDate").val()==""){
     
    SetDatesForAnalytics('BrowserUsability_StartDate','BrowserUsability_EndDate');   
 }
    
    scrollPleaseWait('browserUsability_Reports');
      var startDate ;
      var endDate;
   
           startDate = $("#BrowserUsability_StartDate").val();
           endDate = $("#BrowserUsability_EndDate").val();
         var queryString = "startDate="+startDate+"&endDate="+endDate+"&UsabilityType=Browser";
     ajaxRequest('/analytics/getUsabilityDetails',queryString, getBrowserLineGraphUsabilityDetailsHandler);
}
function getBrowserLineGraphUsabilityDetailsHandler(data1){

    $("#browserchart_div").val('');
    scrollPleaseWaitClose('browserUsability_Reports'); 
  
    var data = data1.data;
    var heighestValue = data1.heighestValue;
    var mapData = eval("("+data1.json+")");
    var item = {
               
        'data':data
    };
          
    var mapDataObject = new Array();
    var lastDate;
        $.each( mapData, function( key, value ) {
            lastDate = key;
         var gkey="";
        if(key=="Year"){
       
            gkey=  key;
        }else{
                 gkey=  eval(key);
        }
          var record = new Array(gkey);
          if(key=="Year" && value == ""){
              record.push("No Data"); 
          }else if(value==""){
              record.push(0); 
          }
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
        gMax =8;
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
            hAxis: {slantedText:slantedTextValue},
        };
       
          if(c == data.getNumberOfColumns()){
            ticksValue = new Array(firstValue,eval(lastDate));
             options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
        }
            else if(mapDataObject.length ==2){
                //alert("--------else if 1-----"+mapDataObject.length);
            slantedTextValue=false;
            ticksValue = new Array(eval(lastDate));
            options['hAxis'] = {slantedText:slantedTextValue,ticks:ticksValue};
        }
            else if(mapDataObject.length >2 && mapDataObject.length<5){
                 //alert("--------else if 2-----"+mapDataObject.length);
              slantedTextValue=false;
              options['hAxis']  = {slantedText:slantedTextValue};
         }

        var chart = new google.visualization.LineChart(document.getElementById('browserchart_div'));
        var view = new google.visualization.DataView(data);  
        //alert("--------"+columns);

       view.setColumns(columns);
       chart.draw(view, options);

         $("#browserchart_div").css("height", gheight);  

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
}

/*
 * For display grap for different browser on date change---------start---------------
 */
    
      var browserUsability_checkin = $('#browserUsability_dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        
        if ((ev.date.valueOf() > browserUsability_checkout.date.valueOf()) || browserUsability_checkout.date.valueOf()!="") {
//            var newDate = new Date(ev.date)
//            newDate.setDate(newDate.getDate() + 0);
//            browserUsability_checkout.setValue(newDate);
        }
        browserUsability_checkin.hide();
        $('#browserUsability_dpd2')[0].focus();
    }).data('datepicker');
    
    var browserUsability_checkout = $('#browserUsability_dpd2').datepicker({
        onRender: function(date) {
           return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        browserUsability_checkout.hide();
        
        
       
        if($('#browserPieChart').attr('class') == 'active')
        {
            if(browserUsability_checkin.date.valueOf() > browserUsability_checkout.date.valueOf()){
          
            $('#browserActivity_daterange_error').show();
            $('#browserActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#browserActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#browserActivity_daterange_error').hide();
                getBrowserUsabilityPieGraph('des');
             }
            
        }
        else
        {
            if(new Date($("#BrowserUsability_StartDate").val().valueOf()) > new Date($("#BrowserUsability_EndDate").val().valueOf())){
          
            $('#browserActivity_daterange_error').show();
            $('#browserActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#browserActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#browserActivity_daterange_error').hide();
                getBrowserUsabilityLineGraph('des');
             }
            
        }
         
    }).data('datepicker');
     //---------------------end------------------- 
     
      function getBrowserUsabilityPieGraph(flag)
    {
            scrollPleaseWait('browserUsability_Reports');
            var startDate ;
            var endDate;
           if(flag!="default"){
                 startDate = $("#BrowserUsability_StartDate").val();
                 endDate = $("#BrowserUsability_EndDate").val();
           }
             var queryString = "startDate="+startDate+"&endDate="+endDate+"&UsabilityType=Browser";
         ajaxRequest('/analytics/getUsabilityPieChartDetails',queryString, getBrowserUsabilityPieChartDetailsHandler);
    }


    function getBrowserUsabilityPieChartDetailsHandler(dData)
    {
      scrollPleaseWaitClose('browserUsability_Reports');
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawBrowserPieChart(dData));
      
     
    }
    function drawBrowserPieChart(dData) {
       
        $("#browserchart_div").val('');
        dData = eval('('+dData.json+')');
        var browserArray = new Array();
        browserArray[0] = ['Browser', 'Count'];
        var i=1;
        $.each( dData, function( key, value ) { 
                browserArray[i] = [value.browser,parseInt(value.count)];
                i++;
        });   
        var data = google.visualization.arrayToDataTable(browserArray);

        var options = {
           pieHole: 0.4,


        };

        var chart = new google.visualization.PieChart(document.getElementById('browserchart_div'));
        chart.draw(data, options);
        
      }

 /*
 * -----------------------------------Usablity graph for Browser------------------end----------------
 */

    
      function usabilityAnalyticsCaptureImg(chartContainer, imgContainer, obj,analyticType) {
        var doc = chartContainer.ownerDocument;
        saveAsImgUsability(chartContainer,obj,analyticType);
        var img = doc.createElement('img');
        img.src = getImgData(chartContainer);
        img.id=chartContainer.id+"_img";
        while (imgContainer.firstChild) {
          imgContainer.removeChild(imgContainer.firstChild);
          
        }
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
 function saveAsImgUsability(chartContainer, obj,analyticType) {
        var imgData = getImgData(chartContainer);
        saveImageFromBase64Usability(imgData, obj,analyticType);
      }
      
 function saveImageFromBase64Usability(imgData, obj,analyticType){
        var queryString = "imgData="+imgData;        
        ajaxRequest("/analytics/analyticsSaveImageFromBase64", queryString, function(data){saveImageFromBase64Usabilityhandler(data, obj,analyticType);});  
    }
    
function saveImageFromBase64Usabilityhandler(data, obj,analyticType){
    var g_datesA = $("#"+analyticType+"_StartDate").val()+" to "+$("#"+analyticType+"_EndDate").val();
    //$("#"+obj.id).attr("href", "/analytics/Pdf?date="+g_datesA+"&analyticType="+analyticType);
    window.open("/analytics/Pdf?date=" + g_datesA + "&analyticType=" + analyticType,'_blank');
}

function openDeviceUsabilityActivityXls(obj,analyticType){
    
        var chartType="";
        if($('#devicePieChart').attr('class') == 'active')
        {
             chartType = 'piechart';
        }
        else
        {
             chartType = 'linechart';
        }
    var theHref = $("#"+obj.id).attr("href");
    var g_datesA ="startdate="+$("#"+analyticType+"_StartDate").val()+"&enddate="+$("#"+analyticType+"_EndDate").val()+"&chartType="+chartType;
    $("#"+obj.id).attr("href", "/analytics/"+analyticType+"GenerateXLS?"+g_datesA);
    
}

function openUsabilityActivitypdf(obj,analyticType){
    if(analyticType == 'DeviceUsability')
    {
        usabilityAnalyticsCaptureImg(document.getElementById('devicechart_div'), document.getElementById('deviceactivityimg_div'), obj,analyticType);
    }
    if(analyticType == 'LocationUsability')
    {
         usabilityAnalyticsCaptureImg(document.getElementById('locationchart_div'), document.getElementById('locationactivityimg_div'), obj,analyticType);
    }
    if(analyticType == 'BrowserUsability')
    {
        usabilityAnalyticsCaptureImg(document.getElementById('browserchart_div'), document.getElementById('browseractivityimg_div'), obj,analyticType);
    }
}

function openLocationUsabilityActivityXls(obj,analyticType){
    
        var chartType="";
        if($('#locationPieChart').attr('class') == 'active')
        {
             chartType = 'piechart';
        }
        else
        {
             chartType = 'linechart';
        }
    var theHref = $("#"+obj.id).attr("href");
    var g_datesA ="startdate="+$("#"+analyticType+"_StartDate").val()+"&enddate="+$("#"+analyticType+"_EndDate").val()+"&chartType="+chartType;
    $("#"+obj.id).attr("href", "/analytics/"+analyticType+"GenerateXLS?"+g_datesA);
    
}

function openBrowserUsabilityActivityXls(obj,analyticType){
    
        var chartType="";
        if($('#browserPieChart').attr('class') == 'active')
        {
             chartType = 'piechart';
        }
        else
        {
             chartType = 'linechart';
        }
    var theHref = $("#"+obj.id).attr("href");
    var g_datesA ="startdate="+$("#"+analyticType+"_StartDate").val()+"&enddate="+$("#"+analyticType+"_EndDate").val()+"&chartType="+chartType;
    $("#"+obj.id).attr("href", "/analytics/"+analyticType+"GenerateXLS?"+g_datesA);
    
}

</script>