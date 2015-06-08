<div class=" stream_content positionrelative">
    <span id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></span>
    <ul>
        <li class="media">
            <a onclick="trackEngagementAction('GroupDetail', '<?php echo $data->GroupId ?>')" class="pull-left img_single" href="/<?php echo $data->GroupUniqueName ?>"><img src="<?php echo $data->GroupImage ?>"  ></a>
            <div class="media-body" >
                <p  data-postid="<?php echo $data->PostId; ?>">
                    <a href="/<?php echo $data->GroupUniqueName ?>" ><b><?php echo html_entity_decode($data->GroupName); ?></b></a>
                </p>
                <p id='groupShortDescription' style="cursor: pointer" data-GroupId="<?php echo $data->GroupId ?>"  data-groupName="<?php echo $data->GroupName ?>" data-postid="<?php echo $data->PostId; ?>"><?php
                    echo $data->GroupDescription;
                    ?></p>
            </div>
            <div class="social_bar" data-id="<?php echo $data->_id ?>" data-groupid="<?php echo $data->GroupId ?>" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>">	
                <a class="follow_a" <?php if($data->RestrictedAccessGroup == 1){ ?> style="position: inherit;cursor: none;" <?php } ?> ><i><img src="/images/system/spacer.png"  class=" tooltiplink <?php echo $data->IsFollowingPost ? 'follow' : 'unfollow' ?>"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $data->IsFollowingPost ? Yii::t('translation','UnFollow') : Yii::t('translation','Follow') ?>"></i><b class="streamFollowUnFollowCount" data-actiontype='Followers' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo count($data->PostFollowers)?>" data-categoryId="<?php  echo $data->CategoryType;?>" ><span id="group_followers_count_<?php echo $data->_id ?>"><?php echo $data->GroupFollowersCount ?></span>

                 <?php 
                    $data->FollowCount = $data->GroupFollowersCount;
                    include Yii::app()->basePath.'/views/common/userFollowActionView.php'; ?>
                
                </b>
                    </a>
            </div>
        </li>
    </ul>
</div>