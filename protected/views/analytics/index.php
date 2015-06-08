<!--<script type="text/javascript" src="https://canvg.googlecode.com/svn/trunk/rgbcolor.js"></script> 
<script type="text/javascript" src="https://canvg.googlecode.com/svn/trunk/canvg.js"></script>-->
<div id="content">



    <div class="analytics_header">
        <div class="row-fluid">

            <div class="span12 positionrelative">
                <div class="analytics_title positionabsolutetitle">Analytics</div>
                <div class="analytics_menu "> 
                    <ul id="tabs" class="" data-tabs="tabs">

                        <li class="analytic_home active"  data-placement="bottom" rel="tooltip"  data-original-title="Analytics"><a href="#AnalyticsDashboard" data-toggle="tab"><img src="/images/system/spacer.png" /></a></li>
                        <li class="trafic" onclick="getTrafficDetails('default')"   data-placement="bottom" rel="tooltip"  data-original-title="Traffic" ><a href="#trafic" data-toggle="tab"><img src="/images/system/spacer.png" /></a></li>
                        <li class="usability" onclick="getUsabilityDetails('default')" data-placement="bottom" rel="tooltip"  data-original-title="Usability"   ><a href="#usability" data-toggle="tab"><img src="/images/system/spacer.png" /></a></li>
                        <li class="activity"  onclick="getActivityDetails('default')"   data-placement="bottom" rel="tooltip"  data-original-title="Activity" ><a href="#activity" data-toggle="tab"><img src="/images/system/spacer.png" /></a></li>
                        <li class="engagement" onclick="getEngagementDetails('default')" data-placement="bottom" rel="tooltip"  data-original-title="Engagement"><a href="#engagement" data-toggle="tab"><img src="/images/system/spacer.png" /></a></li>


                    </ul>
                </div>	


            </div>
        </div>
    </div>  
    <div >
        <div id="my-tab-content" class="tab-content tab-contentoverflow " style="border: 0px solid #CCCCCC;padding:0">
            <div class="tab-pane active" id="AnalyticsDashboard">
                <div class="analytics_title marginT10"><span class="">Stats </span></div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span4">
                            <div class=" stats_div ">
                                <div class=" users">
                                    <label><?php echo number_format($stats['registeredUsers']); ?></label>
                                    Users
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class=" stats_div ">
                                <div class=" groups">
                                    <label><?php echo $stats['groups']; ?></label>
                                    Groups
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="stats_div">
                                <div class="conversations">
                                    <label><?php echo number_format($stats['conversationsCount']); ?></label>
                                    Conversations
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="analytics_title marginT10"><span class="">Leaders </span></div>
                <div class="row-fluid">
                    <div class="sapn12">
                        <div class="analytics_topleaders_box">
                            <div class="analytics_widgettitle topusers">
                                <i><img src="/images/system/spacer.png" /></i>
                                <span class="">Top 10 Users	 <i class="cursor helpmanagement"  data-id="Top10Users_DivId"><img src="/images/system/spacer.png"  data-original-title="Top 10 Users" rel="tooltip" data-placement="bottom"/></i></span>
                            </div>

                            <div class="r_followersdiv r_newfollowers padding10 borderzero">
                                <ul style="border:0">
                                    <?php
                                    if (isset($Topleaders['TopHashtags']) && count($Topleaders['Topusers']) > 0) {
                                        for ($i = 0; $i < count($Topleaders['Topusers']); $i++) {
                                            ?>



                                            <li data-original-title="<?php echo $Topleaders['Topusers'][$i]['DisplayName']; ?>" rel="tooltip" data-placement="bottom" class="tooltiplink top_users ">
                                                 <div class="pull-left generalprofileicon  skiptaiconwidth25x25 generalprofileiconborder3 " >
                  <a  data-userid="2" class="skiptaiconinner miniprofileDetails" style="cursor:pointer">
                        <img src="<?php echo $Topleaders['Topusers'][$i]['ProfilePicture']; ?>">    
                  </a>
                     </div> &nbsp;&nbsp;<label style="float:left"><?php echo $Topleaders['Topusers'][$i]['DisplayName']; ?></label>
                                            </li>

                                        <?php
                                        }
                                    } else {
                                        echo "No Data Found";
                                    }
                                    ?>      
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
                                <span class="">Top 10 Search Terms <i class="cursor helpmanagement" data-id="Top10SearchTerms_DivId"><img src="/images/system/spacer.png"  data-original-title="Top 10 Search Terms" rel="tooltip" data-placement="bottom" /></i></span>
                            </div>
                            <div class="padding10 topserachterms">
                                <?php
                                // print_r($Topleaders['TopSearchItems']);
                                if (isset($Topleaders['TopHashtags']) && count($Topleaders['TopSearchItems']) > 0) {
                                    for ($j = 0; $j < count($Topleaders['TopSearchItems']); $j++) {
                                        ?>
                                        <?php echo $Topleaders['TopSearchItems'][$j];
                                        if ($j < count($Topleaders['TopSearchItems']) - 1) {
                                            echo ",";
                                        } ?>

                                    <?php
                                    }
                                } else {

                                    echo "No Data Found";
                                }
                                ?> 

                                </ul>
                            </div>



                        </div>
                    </div>

                    <div class="span6">
                        <div class="analytics_topleaders_box" style="min-height:118px;">
                            <div class="analytics_widgettitle topHashtags">
                                <i><img src="/images/system/spacer.png" /></i>
                                <span class="">Top 10 Hash Tags <i data-id="Top10HashTags_DivId" class="helpmanagement cursor"><img src="/images/system/spacer.png"  data-original-title="Top 10 hashtags " rel="tooltip" data-placement="bottom" /></i></span>
                            </div>
                            <div class="padding10">

                                <?php
                                // print_r($Topleaders['TopSearchItems']);
                                if (isset($Topleaders['TopHashtags']) && count($Topleaders['TopHashtags']) > 0) {
                                    for ($k = 0; $k < count($Topleaders['TopHashtags']); $k++) {
                                        ?>

                                        <span class="analyticsdd-tags hashtag"><b>#<?php echo $Topleaders['TopHashtags'][$k]; ?></b></span>
    <?php
    }
} else {
    echo "No Data Found";
}
?>

                            </div>

                        </div>
                    </div>
                </div>
<?php if ($NewsAvailable == 'ON') { ?>
                    <div class="row-fluid paddingtop12">
                        <div class="sapn12">
                            <div class="analytics_topleaders_box">
                                <div class="analytics_widgettitle topNewsSources">
                                    <i><img src="/images/system/spacer.png" /></i>
                                    <span class="">Top 10 News Sources <i class="cursor helpmanagement" data-id="TopNewsSearch_DivId" data-original-title="Top 10 News Sources" rel="tooltip" data-placement="bottom"><img src="/images/system/spacer.png" /></i></span>
                                </div>
                                <div class="padding10">
                                    <div class="row-fluid">
                                        <div class="span12 topnewssources">

                                                <?php
                                                if (isset($Topleaders['TopNews']) && count($Topleaders['TopNews']) > 0) {
                                                    for ($l = 0; $l < count($Topleaders['TopNews']); $l++) {
                                                        ?>
                                                    <span style="padding-right: 5px;">
                                                        <a data-userid="2"target="_blank" href="<?php echo $Topleaders['TopNews'][$l]['Url']; ?>" >  <?php echo $Topleaders['TopNews'][$l]['Source']; ?>   </a> 
                                                    <?php if ($l < count($Topleaders['TopNews']) - 1 && $Topleaders['TopNews'][$l + 1]['Source'] != "") {
                                                        echo ",";
                                                    } ?>
                                                    </span>

        <?php
        }
    } else {
        echo "No Data Found";
    }
    ?> 


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
<?php } ?>

            </div>
            <div class="tab-pane  tab_content " id="trafic">
                <?php require_once 'traffic.php'; ?>

            </div>
            <div class="tab-pane tab_content " id="usability">
                <?php require_once 'usability.php'; ?>
            </div>
            <div class="tab-pane  tab_content " id="activity" >
<?php require_once 'activity.php'; ?>
            </div>
            <div class="tab-pane adding10 tab_content " id="engagement">
<?php require_once 'engagement.php'; ?>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#tabs').tab();
    });
</script>
</div> 



<script type="text/javascript" language="javascript">

    var Global_date_Format = '<?php echo Yii::app()->params['DateFormat']; ?>';

    SetDatesForAnalytics('Traffic_StartDate', 'Traffic_EndDate');
    $("#analytics").addClass('active');
    $("[rel=tooltip]").tooltip();
    var g_cnt = 0;

    var checkin = $('#dpd1').datepicker({
        onRender: function(date) {
            //  $('.datepicker').css({left:'690.967px'});
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if ((ev.date.valueOf() > checkout.date.valueOf()) || checkout.date.valueOf() != "") {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 0);
            //checkout.setValue(newDate);
        }
        checkin.hide();
        $('#dpd2')[0].focus();


    }).data('datepicker');

    var checkout = $('#dpd2').datepicker({
        onRender: function(date) {

            // $('.datepicker').css({left:'880.88px'});
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        checkout.hide();
        getActivityDetails('des');
    }).data('datepicker');




    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    // $('.datepicker').css(left:'690.967px');



    var Traffic_checkin = $('#Traffic_dpd1').datepicker({
        // startDate: '01/01/2012',
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {

        if ((ev.date.valueOf() > Traffic_checkout.date.valueOf()) || Traffic_checkout.date.valueOf() != "") {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 0);
            // Traffic_checkout.setValue(newDate);
        }
        Traffic_checkin.hide();
        $('#Traffic_dpd2')[0].focus();
    }).data('datepicker');

    var Traffic_checkout = $('#Traffic_dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        Traffic_checkout.hide();
        if (Traffic_checkin.date.valueOf() > Traffic_checkout.date.valueOf()) {

            $('#Traffic_daterange_error').show();
            $('#Traffic_daterange_error').html("please Select End date should be greater than Start date.");
        } else {
            $('#Traffic_daterange_error').hide();
            getTrafficDetails('des');
        }
        // alert(Traffic_checkin.date.valueOf());

    }).data('datepicker');


    function getActivityDetails(flag) {

        if ($("#Activity_StartDate").val() == "" && $("#Activity_EndDate").val() == "") {

            SetDatesForAnalytics('Activity_StartDate', 'Activity_EndDate');
        }

        scrollPleaseWait('Activity_Reports');
        var startDate;
        var endDate;

        startDate = $("#Activity_StartDate").val();
        endDate = $("#Activity_EndDate").val();
        var queryString = "startDate=" + startDate + "&endDate=" + endDate;

        ajaxRequest('/analytics/getActivityDetails', queryString, getActivityDetailsHandler);
    }
    function getActivityDetailsHandler(data1) {

        scrollPleaseWaitClose('Activity_Reports');
        var data = data1.data;
        var mapData = eval("(" + data1.json + ")");

        var heighestValue = data1.heighestValue;
        var item = {
            'data': data
        };
        var mapDataObject = new Array();
        var xyArray = data1.lablesArray
        mapDataObject.push(xyArray);
        var lastDate;
        $.each(mapData, function(key, value) {
            lastDate = key;
            var record = new Array(eval(key));
            $.each(value, function(k, v) {
                record.push(v);
            });
            mapDataObject.push(record);
        });
        var firstValue = mapDataObject[1][0];
        var data = google.visualization.arrayToDataTable(mapDataObject);
        var gMax = "auto";
        var gheight = 500;
        var slantedTextValue = true;
        var ticksValue = "auto";
        var columns = [];
        var series = {};
        if (heighestValue == 0) {
            gMax = 8;
            var gCount = 2;
            var gheight = 300;

        } else {
            gMax = getHeighestNumber(heighestValue);
        }

        var c = 1;
        for (var i = 0; i < data.getNumberOfColumns(); i++) {
            columns.push(i);
            if (i > 0) {
                series[i - 1] = {};
            }
            if (data.getColumnRange(i).max == 0) {
                var src = columns[i];
                c++;
                columns[i] = {
                    label: data.getColumnLabel(src),
                    type: data.getColumnType(src),
                    // sourceColumn: src,
                    calc: function() {
                        // return null;
                    }
                };
            }
        }
        var options = {
            series: {
                0: {color: '#950303'},
                1: {color: '#EA3CDB'},
                2: {color: '#933CEA'},
                3: {color: '#2233D4'},
                4: {color: '#22D4C2'},
                5: {color: '#43459d'},
                6: {color: '#2093F7'},
                7: {color: '#2AC63F'},
                8: {color: '#E5C822'},
                9: {color: '#E55C22'},
            },
            title: '',
            fontSize: '11',
            pointSize: '4',
            fontName: 'museo_slab500',
            height: gheight,
            orientation: 'horizontal',
            vAxis: {viewWindow: {min: 0, max: gMax}},
            hAxis: {slantedText: slantedTextValue},
            //legend:{position:'bottom'}
            // explorer:{keepInBounds: true , maxZoomIn: .5 ,maxZoomOut: 5,zoomDelta:1.5}


        };
        if (data1.Gameavailable == 'ON') {
            options['series'] = {10: {color: '#FF0066'}};
        }

        if (c == data.getNumberOfColumns()) {
            // alert(firstValue+"---"+eval(lastDate));
            ticksValue = new Array(firstValue, eval(lastDate));
            options['hAxis'] = {slantedText: slantedTextValue, ticks: ticksValue};
        }
        else if (mapDataObject.length == 2) {
            slantedTextValue = false;
            ticksValue = new Array(eval(lastDate));
            options['hAxis'] = {slantedText: slantedTextValue, ticks: ticksValue};
        }
        else if (mapDataObject.length > 2 && mapDataObject.length < 5) {
            slantedTextValue = false;
            options['hAxis'] = {slantedText: slantedTextValue};
        }

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        var view = new google.visualization.DataView(data);

        view.setColumns(columns);
        chart.draw(view, options);
        $("#chart_div").css("height", gheight);


        google.visualization.events.addListener(chart, 'select', function() {
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
                            calc: function() {
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
                    options['series'] = series;
                    chart.draw(view, options);
                }
            }
        });

        analyticsCaptureImg(document.getElementById('chart_div'), document.getElementById('activityimg_div'));


    }


    function getTrafficDetails(flag) {
        var startDate;
        var endDate;

        if ($("#Traffic_StartDate").val() == "" && $("#Traffic_EndDate").val() == "") {

            SetDatesForAnalytics('Traffic_StartDate', 'Traffic_EndDate');
        }
        scrollPleaseWait('Traffic_Reports');

        startDate = $("#Traffic_StartDate").val();
        endDate = $("#Traffic_EndDate").val();
        var queryString = "startDate=" + startDate + "&endDate=" + endDate;


        ajaxRequest('/analytics/getTrafficDetails', queryString, getTrafficDetailsHandler);
    }

    function getTrafficDetailsHandler(data1) {

        scrollPleaseWaitClose('Traffic_Reports');
        var data = data1.data;


        var mapData = eval("(" + data1.json + ")");
        // alert(mapData.toSource());
        var heighestValue = data1.heighestValue;
        var item = {
            'data': data
        };
        var mapDataObject = new Array();
        // var xyArray =  ['Year', 'Stream', 'Posts','Curbside','Groups','Events','Surveys','Hashtags'];
        var xyArray = ['Year', 'Page Views', 'Page Visits'];
        mapDataObject.push(xyArray);
        var lastDate;
        $.each(mapData, function(key, value) {
            lastDate = key;
            var record = new Array(eval(key));
            $.each(value, function(k, v) {
                record.push(v);
            });
            mapDataObject.push(record);
        });
        var firstValue = mapDataObject[1][0];
        var data = google.visualization.arrayToDataTable(mapDataObject);
        var gMax = "auto";
        var gheight = 600;
        var slantedTextValue = true;
        var ticksValue = "auto";
        var columns = [];
        var series = {};
        if (heighestValue == 0) {
            gMax = 8;
            var gCount = 2;
            var gheight = 500;

        } else {
            gMax = getHeighestNumber(heighestValue);
        }

        var c = 1;
        for (var i = 0; i < data.getNumberOfColumns(); i++) {
            columns.push(i);
            if (i > 0) {
                series[i - 1] = {};
            }
            if (data.getColumnRange(i).max == 0) {
                var src = columns[i];
                c++;
                columns[i] = {
                    label: data.getColumnLabel(src),
                    type: data.getColumnType(src),
                    // sourceColumn: src,
                    calc: function() {
                        // return null;
                    }
                };
            }
        }
        var options = {
            title: '',
            fontSize: '11',
            pointSize: '4',
            fontName: 'museo_slab500',
            height: gheight,
            orientation: 'horizontal',
            vAxis: {viewWindow: {min: 0, max: gMax}},
            hAxis: {slantedText: slantedTextValue},
            //legend:{position:'bottom'}
            // explorer:{keepInBounds: true , maxZoomIn: .5 ,maxZoomOut: 5,zoomDelta:1.5}


        };
        if (c == data.getNumberOfColumns()) {
            // alert(firstValue+"---"+eval(lastDate));
            ticksValue = new Array(firstValue, eval(lastDate));
            options['hAxis'] = {slantedText: slantedTextValue, ticks: ticksValue};
        }
        else if (mapDataObject.length == 2) {
            slantedTextValue = false;
            ticksValue = new Array(eval(lastDate));
            options['hAxis'] = {slantedText: slantedTextValue, ticks: ticksValue};
        }
        else if (mapDataObject.length > 2 && mapDataObject.length < 5) {
            slantedTextValue = false;
            options['hAxis'] = {slantedText: slantedTextValue};
        }

        var chart = new google.visualization.LineChart(document.getElementById('Traffic_chart_div'));

        var view = new google.visualization.DataView(data);

        view.setColumns(columns);

        chart.draw(view, options);

        $("#Traffic_chart_div").css("height", gheight);


        google.visualization.events.addListener(chart, 'select', function() {
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
                            calc: function() {
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
                    options['series'] = series;
                    chart.draw(view, options);
                }
            }
        });


        $("#Traffic_chart_div").css("height", gheight);

        analyticsCaptureImg(document.getElementById('Traffic_chart_div'), document.getElementById('Trafficimg_div'));



    }
    function getActivityDetailsHandler1(data1) {
        scrollPleaseWaitClose('Traffic_Reports');
        var data = data1.data;
        // alert(data1.json);
        var mapData = eval("(" + data1.json + ")");
        var item = {
            'data': data
        };

        var mapDataObject = new Array();
        var xyArray = ['Year', 'Posts', 'Curnside Posts', 'Event Posts', 'Quick Poll Posts', 'Promoted Posts', 'Featured Posts', 'Registrations', 'Activity Users', 'Come back Users'];
        mapDataObject.push(xyArray);
        $.each(mapData, function(key, value) {
            var record = new Array(key);
            $.each(value, function(k, v) {
                record.push(v);
            });
            mapDataObject.push(record);
        });

        var data = google.visualization.arrayToDataTable(mapDataObject);

        var options = {
            title: '',
            fontSize: '11',
            pointSize: '4',
            fontName: 'museo_slab500'
        };

        var chart = new google.visualization.LineChart(document.getElementById('Traffic_chart_div'));

        chart.draw(data, options);
    }

    function openActivitypdf(obj, analyticType) {
        var theHrefs = $("#" + obj.id).attr("href");

        var g_datesA = $("#" + analyticType + "_StartDate").val() + " to " + $("#" + analyticType + "_EndDate").val();

        $("#" + obj.id).attr("href", "/analytics/Pdf?date=" + g_datesA + "&analyticType=" + analyticType);
        var theHref = $("#" + obj.id).attr("href");


    }

    function openActivityXls(obj, analyticType) {

        var theHref = $("#" + obj.id).attr("href");
        var g_datesA = "startdate=" + $("#" + analyticType + "_StartDate").val() + "&enddate=" + $("#" + analyticType + "_EndDate").val();
        $("#" + obj.id).attr('href', "/analytics/" + analyticType + "GenerateXLS?" + g_datesA);

    }

    function analyticsCaptureImg(chartContainer, imgContainer) {
        var doc = chartContainer.ownerDocument;
        var img = doc.createElement('img');
        img.src = getImgData(chartContainer);
        saveAsImg(chartContainer);
        img.id = chartContainer.id + "_img";
        while (imgContainer.firstChild) {
            imgContainer.removeChild(imgContainer.firstChild);
        }
        imgContainer.appendChild(img);

    }
    function getImgData(chartContainer) {
        try {
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
        } catch (err) {
            // alert("error--"+err);
        }
        return imgData;
    }
    function saveAsImg(chartContainer) {
        var imgData = getImgData(chartContainer);
        saveImageFromBase64(imgData);
    }

    function saveImageFromBase64(imgData) {
        var queryString = "imgData=" + imgData;
        ajaxRequest("/analytics/analyticsSaveImageFromBase64", queryString, saveImageFromBase64handler);
    }

    function saveImageFromBase64handler(data) {

    }
    function getHeighestNumber(number) {
        while (true) {
            if (number % 4 == 0) {
                var q = number / 4;
                if (q % 2 == 0) {
                    return number;
                } else {
                    number = number + 1;
                }

            } else {
                number = number + 1;
            }
        }
    }

    function SetDatesForAnalytics(StartdatId, EnddateId) {

        var d = new Date();
        var curr_date = d.getDate();
        var tomo_date = d.getDate() + 1;
        var seven_date = d.getDate() - 7;
        var curr_month = d.getMonth();
        curr_month++;
        var curr_year = d.getFullYear();
        var tomorrowsDate = (curr_month + "/" + curr_date + "/" + curr_year);
        var weekDate = (curr_month + "/" + seven_date + "/" + curr_year);



        var todayTimeStamp = +new Date; // Unix timestamp in milliseconds
        var oneDayTimeStamp = 7 * (1000 * 60 * 60 * 24); // Milliseconds in a day
        var diff = todayTimeStamp - oneDayTimeStamp;
        var yesterdayDate = new Date(diff);
        var yesterdayString = yesterdayDate.getFullYear() + '-' + (yesterdayDate.getMonth() + 1) + '-' + yesterdayDate.getDate();
        var startyear = yesterdayDate.getFullYear();
        var startMonth = (yesterdayDate.getMonth() + 1);
        var startDate = yesterdayDate.getDate();

        weekDate = formatDates(startyear, startMonth, startDate, Global_date_Format);
        tomorrowsDate = formatDates(curr_year, curr_month, curr_date, Global_date_Format);

        $('#' + StartdatId).val(weekDate);

        $('#' + EnddateId).val(tomorrowsDate);

    }
    if (detectDevices()) {
        $("#chart_div,#devicechart_div,#browserchart_div,#locationchart_div,#engagement_chart_div").attr("style", "width:550px;height:550px");
        $("#Traffic_chart_div").attr("style", "min-width:100%; height: 550px;");
        $(".dropdown-menu").live('touchstart', function(event) {
            event.stopPropogation();
        });

    } else {
        $("#chart_div,#devicechart_div,#browserchart_div,#locationchart_div").attr("style", "width: 100%; height: 550px;");
        $("#engagement_chart_div").attr("style", "width: 100%; height: 550px;");
        $("#Traffic_chart_div").attr("style", "min-width:100%; height: 550px;");
    }

</script>

