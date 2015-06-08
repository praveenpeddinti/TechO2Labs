<?php if(is_object($pictocvObj) && count($pictocvObj->Opportunities)>0){ ?>
<div style="width: 100%;" id="userAchievementProgress">
    <div class="stream_widget marginT10 positionrelative">
        <div class="profile_icon  "><img src="<?php echo $profilePicture; ?>"> </div>    
        <div class="post_widget impressionDiv">
            <div class="stream_msg_box">
                <div class="stream_title paddingt5lr10 stream_sectionheader" style="position: relative">
                    <a ><b>Your</b></a> achievement progress in the <?php echo Yii::app()->params['NetworkName']; ?>
                </div>
                <div class=" stream_content positionrelative stream_contentpaddingt5b0">
                    <ul class="streamPictocvarea">
                    <?php $i=0; foreach($pictocvObj->Opportunities as $opportunities){ ?>

                        <?php $pageNavigation='no';
                        if($opportunities["OpportunityType"]!='Search' && $opportunities["OpportunityType"]!='Follow')
                        {
                            $pageNavigation='yes';
                        }
                        $imagUrl = Yii::app()->params['ServerURL']."/".Yii::app()->params['PictoCVImageSavePath'].$pictocvObj->UserId."_".$opportunities["OpportunityType"].".png";
                        $base64Image = CommonUtility::data_uri($imagUrl,'image/png');
                        ?>

                        <?php  ?>
                        <li>
                            <div class="streamPicocvbox">
                                <div class="streamPicocvboximg">
                                    <img title="<?php echo $opportunities["OpportunityType"] ?>" onclick="invokeJoyrideByOpportunityId('<?php echo $opportunities["OpportunityType"]?>','<?php echo $pageNavigation?>')" src="<?php echo $base64Image ?>">
                            </div>
                                </div>
                        </li>
                    <?php $i++; } ?>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
}else{
    echo 0;
} ?>