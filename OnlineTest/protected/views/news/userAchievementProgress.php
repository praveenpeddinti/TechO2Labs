
<?php if(count($pictocvArray["Opportunities"])>0){ 
    foreach ($pictocvArray["Opportunities"] as $opportunity) {
         if($opportunity["OpportunityType"]=="News"){
            $imagUrl = Yii::app()->params['ServerURL']."/".Yii::app()->params['PictoCVImageSavePath'].$userId."_".$opportunity["OpportunityType"].".png";
            $base64Image = CommonUtility::data_uri($imagUrl,'image/png');
    ?>
<ul  class="listnone newsbox impressionUL" id="userAchievementProgress">
    <li class="woomarkLi"  >  
        <div class="customwidget_outer">
            <div style="padding-bottom:10px" class="customwidget customwidget impressionDiv">
                <div class="pagetitle pagetitlewordwrap">
                    <a target="_blank">Your achievement progress in the <?php echo Yii::app()->params['NetworkName']; ?></a>
                </div>
                <div class="custimage pictocv postdetail" style="cursor: pointer;"><img onclick="invokeJoyrideByOpportunityId('<?php echo $opportunity["OpportunityType"]?>','no')" style="width:auto;display:inline-block" src="<?php echo $base64Image ?>"></div>
            </div>
        </div>
    </li>
</ul>
<?php }}} ?>