<?php if(is_array($result)){?>
<div  class="paddingtop6"  >
        <div class="row-fluid">
            <div class="span8 congratulations" style="margin:auto;float:none">
                <div class="congratulationsTitle"><?php echo Yii::t('translation','Congratulations'); ?></div>
                <div class="congratulationsIcon">
                    <?php if($result['gameName']->ShowThankYou==1 && $result['gameName']->ThankYouImage!=""){
                        $thankuImage = $result['gameName']->ThankYouImage;
                    }else{
                        $thankuImage = "/images/system/game_completed_icon.png"; 
                    }
                          
                   ?>
                    <img src="<?php echo $thankuImage;?>" width="250px">
                </div>
                <div class="congratulationsMessage"><?php if($result['gameName']->ShowThankYou==1)echo $result['gameName']->ThankYouMessage; else echo 'Successfully Completed';?></div>
                <div class="congratulationsGameinfo">
                    <div class="c_gamename"><?php echo $result['gameName']->GameName;?></div>
                    <div class="c_gamepoints">
                        <div class="c_gamepointslabel"><?php echo Yii::t('translation','Your_Points'); ?>
                            </div>
                        <div class="c_gamepointscount"><?php echo $result['totalPoints']?></div>
                    </div>
                    <div class="c_viewanswers">
                        
                        <a href="#" id="viewCorrectAnswers">
                            <?php echo Yii::t('translation','View_Correct_Answers'); ?>
                             <i class="fa fa-chevron-right"></i></a>
                    </div>
                    
                </div>
                
            </div>
        </div>
        
    </div>

<script type="text/javascript">
$("#viewCorrectAnswers").unbind().bind("click",function(){
      $("#gameBtn").html("View <i class='fa fa-chevron-circle-right'></i>");
        $("#gameBtn").attr("class","btn btnviewanswers btndisable");
        $(".btnviewanswers").unbind();
    showGame('view',$("#questions").attr("game-id"),$("#questions").attr("schedule-id"));
})
</script>
<?php
}else{?>

<?php }
?>