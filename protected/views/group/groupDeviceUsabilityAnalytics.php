<div class="span12">
            <div id="groupDeviceActivity_daterange_error" class="alert alert-error" style="display: none;padding-left: 100px;"></div>
            <div class="analytics_topleaders_box ">
                
               <div class="analytics_widgetheader">
                <div class="row-fluid">
                   
                    <div class="span12">
                        <div class="pull-left paddingtop12">
                        <div class="analytics_widgettitle pull-left analytics_widgetsub" style="padding:0">
                     <span ><?php echo Yii::t('translation','Usability'); ?>-<b><?php echo Yii::t('translation','Devices'); ?></b> <i class="cursor helpmanagement" data-id="GroupUsabilityHelpDescription_DivId"><img src="/images/system/spacer.png" /></i></span>
                    
                </div>
                         <div class="switch_mode pull-left " style="padding-left:10px">
                           
                	<ul>
                    	<li class="active" id="groupDeviceLineChart"> <a  class="linechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="Line chart" src="/images/system/spacer.png" /></a></li>
                        <li  id="groupDevicePieChart" ><a  class="piechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Pie_chart'); ?>" src="/images/system/spacer.png" /></a></li>
                        </ul>
                </div> </div>
                        <div class="analytics_datepicker pull-right">
                            <ul class="anlt_datepic">
                                <li>
                                    
                                        <div class=" pull-right">


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left  " id="groupDeviceUsability_dpd1">


                                                <label><?php echo Yii::t('translation','Start_Date'); ?></label>
                                                <input type="text"  id="GroupDeviceUsability_StartDate" readonly="readonly" class="textfield " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left " id="groupDeviceUsability_dpd2">


                                                 <label><?php echo Yii::t('translation','End_Date'); ?></label>
                                                <input type="text"  id="GroupDeviceUsability_EndDate"  readonly="readonly" class="textfield  " maxlength="20" value="">   
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                               
                                            </div>

                                        </div>
                                   
                                </li>
                                <!-- -->
                                <li style="cursor:pointer; position: relative" class="dropdown pull-left">
                                    <a data-original-title="<?php echo Yii::t('translation','Advanced_Options'); ?>" rel="tooltip" data-placement="bottom" class="tooltiplink analytics_export " data-toggle="dropdown" id="drop2"><i><img src="/images/system/spacer.png" ><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>
                                            
                                            <li class="" ><a onclick="openGroupUsabilityActivitypdf(this,'GroupDeviceUsability')" id="groupDeviceActivityPdf" name="<?php echo Yii::t('translation','groupEngagmentPdf'); ?>"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> <?php echo Yii::t('translation','Export_as_PDF'); ?></a></li>
                                            <li class="" ><a href="/analytics/GenerateXLS?startdate=1234&enddate=456"  onclick="openGroupUsabilityActivityXls(this,'GroupDeviceUsability')" id="groupDeviceActivityXls"  target="_blank"><i><img src="/images/system/spacer.png" class="excel_doc"></i> <?php echo Yii::t('translation','Export_as_Excel'); ?></a></li>
                                        </ul>

                                    </div>
                                  </li>
                            </ul>
                        </div>
                    </div>
                </div>
               </div>
                <div id="groupDeviceactivityimg_div" style="display: none;"></div>
                 <div id="groupDeviceUsability_Reports" style="position: relative;"></div>
                <div class="row-fluid">
                    <div class="sapn12 positionrelative">
                        <div id="groupDevicechart_div"></div>
                       
                    </div>
                </div>
            </div>
        </div>


<script type="text/javascript" > 
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0); 
    var gGroupId;
    
     $("#groupDeviceLineChart").live("click",
            function() {
                $( "#groupDeviceLineChart" ).addClass("active");
                $( "#groupDevicePieChart" ).removeClass("active");
                getGroupDevicesUsabilityLineGraph(gGroupId);
            }
    );
    
    $("#groupDevicePieChart").live("click",
            function() {
                $( "#groupDeviceLineChart" ).removeClass("active");
                $( "#groupDevicePieChart" ).addClass("active");
                getGroupDevicesUsabilityPieGraph(gGroupId);
            }
    );
    
    function getGroupDevicesUsabilityLineGraph(groupId)
{
    
      if($("#GroupDeviceUsability_StartDate").val()=="" && $("#GroupDeviceUsability_EndDate").val()==""){
     
     SetDatesForGroupAnalytics('GroupDeviceUsability_StartDate','GroupDeviceUsability_EndDate');  
 }
    
      gGroupId = groupId;
      scrollPleaseWait('groupDeviceUsability_Reports');
      var startDate ;
      var endDate;
      startDate = $("#GroupDeviceUsability_StartDate").val();
      endDate = $("#GroupDeviceUsability_EndDate").val();
      var queryString = "groupId="+groupId+"&startDate="+startDate+"&endDate="+endDate+"&UsabilityType=GroupDeviceUsability";
      ajaxRequest('/analytics/getGroupUsabilityDetails',queryString, getGroupDeviceLineGraphUsabilityDetailsHandler);
}
function getGroupDeviceLineGraphUsabilityDetailsHandler(data1){
    $("#groupDevicechart_div").val('');
    scrollPleaseWaitClose('groupDeviceUsability_Reports'); 
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
            width: 900,
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

        var chart = new google.visualization.LineChart(document.getElementById('groupDevicechart_div'));
        var view = new google.visualization.DataView(data);  
        //alert("--------"+columns);

       view.setColumns(columns);
       chart.draw(view, options);

         $("#groupDevicechart_div").css("height", gheight);  

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

 function getGroupDevicesUsabilityPieGraph(gGroupId)
    {
        scrollPleaseWait('groupDeviceUsability_Reports');
          var startDate ;
          var endDate;
//         if(flag!="default"){
               startDate = $("#GroupDeviceUsability_StartDate").val();
               endDate = $("#GroupDeviceUsability_EndDate").val();
//         }
             var queryString = "groupId="+gGroupId+"&startDate="+startDate+"&endDate="+endDate+"&UsabilityType=GroupDeviceUsability";
             
         ajaxRequest('/analytics/getGroupUsabilityPieChartDetails',queryString, getGroupDeviceUsabilityPieChartDetailsHandler);
    }


    function getGroupDeviceUsabilityPieChartDetailsHandler(dData)
    {
      scrollPleaseWaitClose('groupDeviceUsability_Reports'); 
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawGroupDevicePieChart(dData));
      
     
    }
    function drawGroupDevicePieChart(dData) {
        
        $("#groupDevicechart_div").val('');
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

        var chart = new google.visualization.PieChart(document.getElementById('groupDevicechart_div'));
        chart.draw(data, options);
        
      }
      
 /*
 * For display grap for different devices on date change----------------start----------------
 */
    
      var groupDeviceUsability_checkin = $('#groupDeviceUsability_dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        
        if ((ev.date.valueOf() > groupDeviceUsability_checkout.date.valueOf()) || groupDeviceUsability_checkout.date.valueOf()!="") {
//            var newDate = new Date(ev.date)
//            newDate.setDate(newDate.getDate() + 0);
//            groupDeviceUsability_checkout.setValue(newDate);
        }
        groupDeviceUsability_checkin.hide();
        $('#deviceUsability_dpd2')[0].focus();
    }).data('datepicker');
    
    var groupDeviceUsability_checkout = $('#groupDeviceUsability_dpd2').datepicker({
        onRender: function(date) {
           return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        groupDeviceUsability_checkout.hide();
        
        if($('#groupDevicePieChart').attr('class') == 'active')
        {
            if(groupDeviceUsability_checkin.date.valueOf() > groupDeviceUsability_checkout.date.valueOf()){
          
            $('#groupDeviceActivity_daterange_error').show();
            $('#groupDeviceActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#groupeDeviceActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#groupDeviceActivity_daterange_error').hide();
                 getGroupDevicesUsabilityPieGraph(gGroupId);
             }
            
        }
        else
        {
            if(new Date($("#GroupDeviceUsability_StartDate").val().valueOf()) > new Date($("#GroupDeviceUsability_EndDate").val().valueOf()))    
        {
          
            $('#groupDeviceActivity_daterange_error').show();
            $('#groupDeviceActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#groupDeviceActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#groupDeviceActivity_daterange_error').hide();
               getGroupDevicesUsabilityLineGraph(gGroupId);
             }
            
        }
        
    }).data('datepicker');
 /*
 * -----------------------------------Usablity graph for Device------------------end----------------
 */  

    </script>