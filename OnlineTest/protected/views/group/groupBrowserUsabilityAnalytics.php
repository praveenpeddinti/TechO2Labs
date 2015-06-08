<div class="sapn12">
             <div id="groupBrowserActivity_daterange_error" class="alert alert-error" style="display: none;padding-left: 100px;"></div>
            <div class="analytics_topleaders_box">
               <div class="analytics_widgetheader">
                <div class="row-fluid">
                   
                    <div class="span12">
                          <div class="pull-left paddingtop12">
                        <div class="analytics_widgettitle pull-left analytics_widgetsub" style="padding:0;white-space: nowrap;margin-right:10px">
                     <span ><?php echo Yii::t('translation','Usability'); ?>-<b><?php echo Yii::t('translation','Browsers'); ?></b> <i class="cursor helpmanagement" data-id="GroupUsabilityHelpDescription_DivId"><img src="/images/system/spacer.png"  /></i></span>
                    
                </div>
                         <div class="switch_mode pull-left ">
                           
                	 <ul style="white-space: nowrap;">
                                <li class="active" id="groupBrowserLineChart"> <a  class="linechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Line_chart'); ?>" src="/images/system/spacer.png" /></a></li>
                                <li  id="groupBrowserPieChart" ><a  class="piechart"><img class=" tooltiplink cursor" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Pie_chart'); ?>" src="/images/system/spacer.png" /></a></li>
                            </ul>
                </div> </div>
                       
                        <div class="analytics_datepicker pull-right">
                            <ul class="anlt_datepic">
                                <li>
                                   
                                        <div class=" pull-right">


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left  " id="groupBrowserUsability_dpd1">


                                                <label><?php echo Yii::t('translation','Start_Date'); ?></label>
                                                <input type="text"  id="GroupBrowserUsability_StartDate" readonly="readonly" class="textfield " maxlength="20" value="">    
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>


                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left " id="groupBrowserUsability_dpd2">


                                                <label><?php echo Yii::t('translation','End_Date'); ?></label>
                                                <input type="text"  id="GroupBrowserUsability_EndDate"  readonly="readonly" class="textfield  " maxlength="20" value="">    
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
                                            
                                            <li class="" ><a onclick="openGroupUsabilityActivitypdf(this,'GroupBrowserUsability')" id="groupBrowserActivityPdf" name="browserActivityPdf"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> <?php echo Yii::t('translation','Export_as_PDF'); ?></a></li>
                                            <li class="" ><a href="/analytics/GenerateXLS?startdate=1234&enddate=456"  onclick="openGroupUsabilityActivityXls(this,'GroupBrowserUsability')" id="groupBrowserActivityXls"  target="_blank"><i><img src="/images/system/spacer.png" class="excel_doc" onclick="openActivityXls()"></i> <?php echo Yii::t('translation','Export_as_Excel'); ?></a></li>
                                        </ul>

                                    </div>
                                  </li>
                            </ul>
                        </div>
                      </div>
                </div>
               </div>
                <div id="groupBrowseractivityimg_div" style="display: none;"></div>
                 <div id="groupBrowserUsability_Reports" style="position: relative;"></div>
                <div class="row-fluid">
                    <div class="sapn12 positionrelative">
                        <div id="groupBrowserchart_div"></div>
                     
                    </div>
                </div>
            </div>
        </div>

<script type="text/javascript">
    
  $("#groupBrowserLineChart").live("click",
            function() {
                $( "#groupBrowserLineChart" ).addClass("active");
                $( "#groupBrowserPieChart" ).removeClass("active");
                getGroupBrowserUsabilityLineGraph(gGroupId)
            }
    );
    
    $("#groupBrowserPieChart").live("click",
            function() {
                $( "#groupBrowserLineChart" ).removeClass("active");
                $( "#groupBrowserPieChart" ).addClass("active");
                getGroupBrowserUsabilityPieGraph(gGroupId)
            }
    );
    
    function getGroupBrowserUsabilityLineGraph(groupId)
{
  if($("#GroupBrowserUsability_StartDate").val()=="" && $("#GroupBrowserUsability_EndDate").val()==""){
     
     SetDatesForGroupAnalytics('GroupBrowserUsability_StartDate','GroupBrowserUsability_EndDate');  
 }
      gGroupId = groupId;
      scrollPleaseWait('groupBrowserUsability_Reports');
      var startDate ;
      var endDate;
      startDate = $("#GroupBrowserUsability_StartDate").val();
      endDate = $("#GroupBrowserUsability_EndDate").val();
      var queryString = "groupId="+groupId+"&startDate="+startDate+"&endDate="+endDate+"&UsabilityType=GroupBrowserUsability";
      ajaxRequest('/analytics/getGroupUsabilityDetails',queryString, getGroupBrowserLineGraphUsabilityDetailsHandler);

}
function getGroupBrowserLineGraphUsabilityDetailsHandler(data1){

    $("#groupBrowserchart_div").val('');
    scrollPleaseWaitClose('groupBrowserUsability_Reports'); 
  
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

        var chart = new google.visualization.LineChart(document.getElementById('groupBrowserchart_div'));
        var view = new google.visualization.DataView(data);  
        //alert("--------"+columns);

       view.setColumns(columns);
       chart.draw(view, options);

         $("#groupBrowserchart_div").css("height", gheight);  

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

function getGroupBrowserUsabilityPieGraph(gGroupId)
    {
        scrollPleaseWait('groupBrowserUsability_Reports');
          var startDate ;
          var endDate;
//         if(flag!="default"){
               startDate = $("#GroupBrowserUsability_StartDate").val();
               endDate = $("#GroupBrowserUsability_EndDate").val();
//         }
             var queryString = "groupId="+gGroupId+"&startDate="+startDate+"&endDate="+endDate+"&UsabilityType=GroupBrowserUsability";
             
         ajaxRequest('/analytics/getGroupUsabilityPieChartDetails',queryString, getGroupBrowserUsabilityPieChartDetailsHandler);
    }


    function getGroupBrowserUsabilityPieChartDetailsHandler(dData)
    {
      scrollPleaseWaitClose('groupBrowserUsability_Reports'); 
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawGroupBrowserPieChart(dData));
      
     
    }
    function drawGroupBrowserPieChart(dData) {
        
        $("#groupBrowserchart_div").val('');
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

        var chart = new google.visualization.PieChart(document.getElementById('groupBrowserchart_div'));
        chart.draw(data, options);
        
      }
      
           /*
 * For display grap for different locations on date change---------start---------------
 */
    
      var groupBrowserUsability_checkin = $('#groupBrowserUsability_dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        
        if ((ev.date.valueOf() > groupBrowserUsability_checkout.date.valueOf()) || groupBrowserUsability_checkout.date.valueOf()!="") {
//            var newDate = new Date(ev.date)
//            newDate.setDate(newDate.getDate() + 0);
//            groupBrowserUsability_checkout.setValue(newDate);
        }
        groupBrowserUsability_checkin.hide();
        $('#groupBrowserUsability_dpd2')[0].focus();
    }).data('datepicker');
    
    var groupBrowserUsability_checkout = $('#groupBrowserUsability_dpd2').datepicker({
        onRender: function(date) {
           return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        groupBrowserUsability_checkout.hide();
         
        if($('#groupBrowserPieChart').attr('class') == 'active')
        {
            if(groupBrowserUsability_checkin.date.valueOf() > groupBrowserUsability_checkout.date.valueOf()){
          
            $('#groupBrowserActivity_daterange_error').show();
            $('#groupBrowserActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#groupBrowserActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#groupBrowserActivity_daterange_error').hide();
                getGroupBrowserUsabilityPieGraph(gGroupId);
             }
            
        }
        else
        {
            if(new Date($("#GroupBrowserUsability_StartDate").val().valueOf()) > new Date($("#GroupBrowserUsability_EndDate").val().valueOf())) {
          
            $('#groupBrowserActivity_daterange_error').show();
            $('#groupBrowserActivity_daterange_error').html("End Date should be greater than Start Date.");
            $('#groupBrowserActivity_daterange_error').fadeOut(3000);
            }else{
                 $('#groupBrowserActivity_daterange_error').hide();
                 getGroupBrowserUsabilityLineGraph(gGroupId);
             }
            
        }
         
    }).data('datepicker');
     //---------------------end------------------- 
      
        
</script>