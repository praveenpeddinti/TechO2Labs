 <?php if(is_object($stream))
      {
    foreach($stream as $data){?>
<li id="groupId_<?php echo $data->_id; ?>" data-id="<?php echo $data->_id; ?>" data-categorytype="3" data-postid="<?php echo $data->_id; ?>">
<div class="post item impressionDiv" >  
 <span class="grouppostspinner" id="groupfollowSpinLoader_<?php echo $data->_id; ?>"></span>
    <?php $time=$data->CreatedOn?>

        <div  style="cursor: pointer" class="stream_title paddingt5lr10"> <b id="groupName" data-id="<?php echo $data->_id ?>"  data-name="<?php echo $data->GroupUniqueName ?>" class="group"><?php echo $data->GroupName ?></b> <i><?php echo CommonUtility::styleDateTime($time->sec); ?></i></div>
        <div class="mediaartifacts"><a href="/<?php echo $data->GroupUniqueName ?>" class="group"> <img style="height: auto;margin: auto;width: auto;" src="<?php echo $data->GroupProfileImage?>"  ></a></div>
        <div class="stream_content">
            <div id="followUnfollowSpinLoader_<?php echo $data->_id; ?>"></div>
                     <div class="media" data-id="<?php echo $data->_id ?>">
                            <div class="media-body">
                                
                           <?php
                                        if (strlen($data->GroupDescription) > 300) {
                                            echo substr($data->GroupDescription, 0, 300);
                                            ?><a href="/<?php echo $data->GroupUniqueName ?>" class="group">...</a>

                                            <?php
                                        } else {
                                            echo $data->GroupDescription;
                                        }
                                        ?>
                            </div>

                <?php if($data->RestrictedAccess == 1){ ?>
                         <a href="/<?php echo $data->GroupUniqueName ?>" ><div class="disabledelement"></div></a>
                <?php } ?>
                <div class="social_bar groups_view_actions" data-groupid="<?php echo $data->_id ?>" data-id="<?php echo $data->_id ?>" > 
                             <?php
                                //if($data->RestrictedAccess == 0 || in_array($lEmail,$emailsarray)){ ?>
                                <a class="follow_a"><i><img class="tooltiplink <?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $data->GroupMembers)?'follow':'unfollow' ?>" src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $data->GroupMembers)?Yii::t('translation','UnFollow'):Yii::t('translation','Follow') ?>"></i><b><?php echo count($data->GroupMembers) ?></b></a>
                          <?php //} ?>
             <span><i><img src="/images/system/spacer.png" class="g_posts" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Conversations'); ?>" ></i> <b><?php echo count($data->PostIds) ?></b></span>

             

                        </div>
        </div>
                    
                </div>
</div>
    </li>
<?php }
      }else{
          echo $stream;
      ?>
          
    <?php  }
      ?>
