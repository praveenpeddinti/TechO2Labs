 
<?php 
try {
    if(is_object($stream))
      {
    foreach($stream as $data){ ?>
    
<li id="subgroupId_<?php echo $data->_id; ?>">
<div class="post item" >  
 <span class="grouppostspinner" id="groupfollowSpinLoader_<?php echo $data->_id; ?>"></span>
    <?php $time=$data->CreatedOn?>

 <div  style="cursor: pointer" class="stream_title paddingt5lr10"> <b id="groupName" data-id="<?php echo $data->_id ?>"  data-name="<?php echo $data->SubGroupName ?>" class="group"><?php echo html_entity_decode($data->SubGroupName); ?></b> <i><?php echo CommonUtility::styleDateTime($time->sec); ?></i></div>
        <div class="mediaartifacts"><a href="<?php echo $groupName?>/sg/<?php echo $data->SubGroupUniqueName ?>" class="group"> <img src="<?php echo $data->SubGroupProfileImage?>"  ></a></div>
        <div class="" id="UFSubGroup">
            <div id="followUnfollowSpinLoader_<?php echo $data->_id; ?>"></div>
                     <div class="media" data-id="<?php echo $data->_id ?>">
                            <div class="media-body">
                           <?php echo $data->SubGroupDescription?>
                            </div>

                         <div class="social_bar" data-subgroupid="<?php echo $data->_id ?>" data-groupid="<?php echo $data->GroupId ?>" data-id="<?php echo $data->_id ?>">    
              <a class="follow_a"><i><img class="tooltiplink <?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $data->SubGroupMembers)?'follow':'unfollow' ?>" src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $data->SubGroupMembers)?Yii::t('translation','UnFollow'):Yii::t('translation','Follow') ?>"></i><b><?php echo count($data->SubGroupMembers) ?></b></a>
             <span><i><img src="/images/system/spacer.png" class="g_posts" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Conversations'); ?>" ></i> <b><?php echo count($data->PostIds) ?></b></span>
             

                        </div>
        </div>
                    
                </div>
        
    </li>
<?php }
      }else{
          echo $stream;
      ?>
          
    <?php  }
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}


  
      ?>
