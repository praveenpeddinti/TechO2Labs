

        
    <div class="profilesummary" >
        <div class="media " >
            <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a  href="/<?php  echo $groupDetails->GroupUniqueName ?>" class="skiptaiconinner profileDetails " style="cursor:pointer" data-userid="">
                      <img   src="<?php echo $groupDetails->GroupIcon?>">
                  
                  </a>
                     </div>
            <div class="media-body" id="groupDescription" data-groupid="<?php   echo $groupDetails->GroupId ?> " data-groupName="<?php   echo $groupDetails->GroupUniqueName ?>">
                <div class="m_title" style="cursor:pointer" ><?php echo html_entity_decode($groupDetails->GroupName);?></div>
                <span class="m_day italicnormal" style="cursor:pointer" id="profile_aboutme"><?php echo $groupDetails->GroupDescription?></span>
            </div>
        </div>
        
        <div id="miniprofile_spinner_modal"></div>
        <div class="pop_socialworks">
            <div class="social_bar">

                <?php if ($groupDetails->IsGroupAdmin != 1 && $groupDetails->IsAccessGroup == 0) { ?>
               
                  <span class="followGroup"  data-groupid="<?php   echo $groupDetails->GroupId ?>" ><a class="bmzero"> <i  ><img class="tooltiplink cursor <?php   echo $groupDetails->IsFollowing?'followbig':'unfollowbig' ?>"  src="/images/system/spacer.png"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $groupDetails->IsFollowing?'UnFollow':'Follow' ?>"  ></i> </a></span>
                   
                <?php } ?>
            <span><i class="tooltiplink"  data-placement="bottom" rel="tooltip"  data-original-title=" <?php echo Yii::t('translation','Conversations'); ?> "><img src="/images/system/spacer.png" class=" converstionbig" ></i><b><?php echo  $groupDetails->GroupPostsCount?></b></span>

                <span><i class="tooltiplink"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Following'); ?>"><img src="/images/system/spacer.png" class=" followingbig" ></i><b id="followingcntb_"><?php echo  $groupDetails->GroupMembersCount?></b></span>
                <span><i class="tooltiplink"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','SubGroups'); ?>"><img src="/images/system/spacer.png" class=" subgroups" ></i><b><?php echo  $groupDetails->SubgroupsCount?></b></span>


            </div>

        </div>
    </div>

  

