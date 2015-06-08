  <?php 
  $NetworkName = Yii::app()->params['NetworkName'];
   $platform =  $deviceInfo["platform"];
   if($platform == "iOS" || $platform == "PC"){
        $url = Yii::app()->params['appStoreURL'];
        $urlLabel ="Go to Appstore";
   }else{
        $url = Yii::app()->params['googlePlayURL'];
        $urlLabel ="Go to Googleplay";
   }
    if($appStatus=="deprecated"){
        $message = "New Version of ". $NetworkName." Available";
        $title = "Warning";
        $className = "warningdialog";
        $iClassName = "fa fa-warning";
        $cancelText = "Remind me Later";
        $okLabel = $urlLabel;
        $okDataValue = $url;
         
    }
     else if($appStatus=="expired"){
       $message = "New Version of ". $NetworkName." Available";
       $title = "Error";
       $className = "errordialog";
       $iClassName = "fa fa-times";
       $okLabel = $urlLabel;
       $okDataValue = $url;
     }
      else{
       $message = "New Version available ";
       $title = "Info";
       $className = "infodialog";
       $iClassName = "fa fa-exclamation";
       $cancelText = "Remind me Later";
       $okLabel = "Ok";
       $okDataValue="ok";
     }
     ?>


<div class="modal-dialog statusdialog <?php echo $className?>">
<div class="modal-content ">

<div class="modal-body modal-bodyintropop">
<!-- profile popup start here -->

<div class="streamtitlearea">
<div class="padding10">
    
    <div class="statustexttitle">
<div class="statusicon">
<i class="<?php echo $iClassName?>"></i>
<!--<i class="fa fa-check"></i>-->
</div>
<span> <?php echo $message?>    
</span>
</div> 
   

</div>
</div>

<div class="buttonarea statusbutton text-right ">
<div class="padding5">
<button class="btn btn-primary btnstatus marginright5" id="appStoreBtn" data-value="<?php echo $okDataValue;?>"><?php echo $okLabel;?></button>
<?php
if($appStatus!="expired" && $appStatus!="info"){
    ?>
<button class="btn btnstatuscancel" id="cancelBtn" ><?php echo $cancelText?></button>
<?php
}
?>


</div> </div>


<!-- end -->


</div>

</div>
</div> 
   
<script type="text/javascript">
            $("#appStoreBtn").off("click").on("click",function(){
                   var ref = window.open($(this).attr("data-value"), '_blank', 'location=yes');
            })
             $("#cancelBtn").off("click").on("click",function(){ 
                sessionStorage.remindmeLater = "true";
                $("#AppStatus_Model_Popup").modal("hide"); 
             })
    </script>