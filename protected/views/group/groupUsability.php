<?php
$dateFormat =  CommonUtility::getDateFormat();
?> 

<div class="row-fluid marginT10" id="groupDeviceUsabilityId">
        <?php require_once 'groupDeviceUsabilityAnalytics.php'; ?>
    </div>

<div class="row-fluid padding8top" id="groupLocationUsabilityId">
        <?php require_once 'groupLocationUsabilityAnalytics.php'; ?>
    </div>

<div class="row-fluid padding8top" id="groupBrowserUsabilityId">
         <?php require_once 'groupBrowserUsabilityAnalytics.php'; ?>
    </div>

<script type="text/javascript" >
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0); 
    var gGroupId;
    
    function getGroupUsabilityDetails(groupId){
     scrollPleaseWait('groupDeviceUsability_Reports');

     getGroupDevicesUsabilityLineGraph(groupId);
     getGroupLocationUsabilityLineGraph(groupId);
     getGroupBrowserUsabilityLineGraph(groupId);

}

function openGroupUsabilityActivitypdf(obj,analyticType){
    if(analyticType == 'GroupDeviceUsability')
    {
        usabilityAnalyticsCaptureImg(document.getElementById('groupDevicechart_div'), document.getElementById('groupDeviceactivityimg_div'),obj,analyticType);
    }
    if(analyticType == 'GroupLocationUsability')
    {
         usabilityAnalyticsCaptureImg(document.getElementById('groupLocationchart_div'), document.getElementById('groupLocationactivityimg_div'),obj,analyticType);
    }
    if(analyticType == 'GroupBrowserUsability')
    {
        usabilityAnalyticsCaptureImg(document.getElementById('groupBrowserchart_div'), document.getElementById('groupBrowseractivityimg_div'),obj,analyticType);
    }
    

}

    function usabilityAnalyticsCaptureImg(chartContainer, imgContainer,obj,analyticType) {
        var doc = chartContainer.ownerDocument;
        var img = doc.createElement('img');
        img.src = getImgData(chartContainer);
        saveAsImgUsability(chartContainer,obj,analyticType);
        img.id=chartContainer.id+"_img";
        while (imgContainer.firstChild) {
          imgContainer.removeChild(imgContainer.firstChild);
          
        }
        //imgContainer.appendChild(img);
       
      }
     function saveAsImgUsability(chartContainer, obj,analyticType) {
        var imgData = getImgData(chartContainer);
        saveImageFromBase64Usability(imgData, obj,analyticType);
      }
      
    function saveImageFromBase64Usability(imgData, obj,analyticType){
        var queryString = "imgData="+imgData;        
        ajaxRequest("/analytics/analyticsSaveImageFromBase64", queryString, function(data){saveImageFromBase64Usabilityhandler(data, obj,analyticType);});  
    }
    
        function saveImageFromBase64Usabilityhandler(data, obj, analyticType) {
             var g_datesA = $("#" + analyticType + "_StartDate").val() + " to " + $("#" + analyticType + "_EndDate").val();
             window.open("/analytics/Pdf?date=" + g_datesA + "&analyticType=" + analyticType,'_blank');
         }
      function openGroupUsabilityActivityXls(obj,analyticType){
    
        var chartType="";
         if(analyticType == '<?php echo Yii::t('translation','GroupDeviceUsability'); ?>')
         {
              if($('#groupDevicePieChart').attr('class') == 'active')
              {
                   chartType = '<?php echo Yii::t('translation','piechart'); ?>';
              }
              else
              {
                   chartType = '<?php echo Yii::t('translation','linechart'); ?>';
              }
         }
         
        if(analyticType == '<?php echo Yii::t('translation','GroupLocationUsability'); ?>')
          {
               if($('#groupLocationPieChart').attr('class') == 'active')
              {
                   chartType = '<?php echo Yii::t('translation','piechart'); ?>';
              }
              else
              {
                   chartType = '<?php echo Yii::t('translation','linechart'); ?>';
              }
          }
          if(analyticType == '<?php echo Yii::t('translation','GroupBrowserUsability'); ?>')
          {
               if($('#groupBrowserPieChart').attr('class') == 'active')
              {
                   chartType = '<?php echo Yii::t('translation','piechart'); ?>';
              }
              else
              {
                   chartType = '<?php echo Yii::t('translation','linechart'); ?>';
              }
          }
       
    //var theHref = $("#"+obj.id).attr("href");
    var g_datesA ="startdate="+$("#"+analyticType+"_StartDate").val()+"&enddate="+$("#"+analyticType+"_EndDate").val()+"&chartType="+chartType+"&groupId="+gGroupId+"&analyticType="+analyticType;
    $("#"+obj.id).attr("href", "/analytics/GroupUsabilityGenerateXLS?"+g_datesA);
    
}



</script>
