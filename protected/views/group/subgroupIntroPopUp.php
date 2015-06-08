<div class="profilesummary" >
        <div class="media " >
            <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a href="/<?php echo $subgroupDetails->SubGroupName?> "  class="skiptaiconinner profileDetails" style="cursor:pointer" data-userid="">
                      <img   src="<?php echo $subgroupDetails->SubGroupIcon?>">
                  
                  </a>
                     </div>
            <div class="media-body" data-maingroupName="<?php   echo $maingroupDetails->GroupName ?>" id="subgroupDescription" data-groupid="<?php   echo $subgroupDetails->SubGroupId ?> " data-groupName="<?php   echo $subgroupDetails->SubGroupName ?>">
                <div class="m_title" style="cursor:pointer" ><?php echo html_entity_decode($subgroupDetails->SubGroupName);?></div>
                <span class="m_day italicnormal" style="cursor:pointer" id="profile_aboutme"><?php echo $subgroupDetails->SubGroupDescription?></span>
            </div>
        </div>
        
        <div id="miniprofile_spinner_modal"></div>
        <div class="pop_socialworks">
            <div class="social_bar">
            
            
                  <span class="followSubGroup"  data-maingroupid="<?php   echo $maingroupDetails->_id ?>"  data-subgroupid="<?php   echo $subgroupDetails->SubGroupId ?>" >
                      <a class="bmzero"> 
                          <i  ><img class="tooltiplink cursor <?php   echo $subgroupDetails->IsFollowing?'followbig':'unfollowbig' ?>"  src="/images/system/spacer.png"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $subgroupDetails->IsFollowing?Yii::t('translation','UnFollow'):Yii::t('translation','Follow') ?>"  >
                          </i> 
                      </a>
                  </span>
            
            
            <span><i class="tooltiplink"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Conversations'); ?>"><img src="/images/system/spacer.png" class=" converstionbig" ></i><b><?php echo  $subgroupDetails->SubGroupPostsCount?></b></span>
            
                <span><i class="tooltiplink"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Following'); ?>"><img src="/images/system/spacer.png" class=" followingbig" ></i><b id="Subfollowingcntb_"><?php echo  $subgroupDetails->SubGroupMembersCount?></b></span>
                
            </div>
        </div>
        <div class="groupname" style="cursor:pointer" id="groupDescription" data-groupid="<?php   echo $maingroupDetails->_id ?> " data-groupName="<?php   echo $maingroupDetails->GroupName ?>"><span class="pull-right"><?php echo $maingroupDetails->GroupName?></span></div>
        
    </div>