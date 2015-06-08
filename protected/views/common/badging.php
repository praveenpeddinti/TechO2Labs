<!-- Pop up  Content -->

<?php
try {
    ?>
   

           
          <div class=" stream_content positionrelative">
                <ul>
                    <li class="media">
                                <div  class="pull-left postdetail" >
				  <img src="<?php echo Yii::app()->params['ServerURL']; ?>/images/badges/<?php echo $badgingInfo->badgeName."_128x152.png ";?>" />				
				</div>
                                                <div class="media-body">
                                                    <!-- if($badgingInfo->has_level) echo "Level ". $badgeCollectionInfo->BadgeLevelValue -->
                                                     <div class="badgingheader <?php echo $badgingInfo->context?>Badgeheader"><?php echo Yii::t('translation','You_just_unlocked_the'); ?><?php echo " $badgingInfo->badgeName "; echo " ".Yii::t('translation','Badge')."!" ?></div>
                                                    
                                		 <p><?php echo $badgingInfo->description ?></p>
                       				 </div>
                              </li>
                </ul>
              <input type='hidden' value='<?php echo $badgeCollectionInfo->_id?>' id='BadgeShownToUser' />
            </div>
        

    <?php
} catch (Exception $exc) {
    
}
?>

