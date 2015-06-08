<div class=" stream_content positionrelative">
    <span id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></span>
    <ul>
        <li class="media">
            <?php if ($data->GroupImage != '') { ?>
                <a  class="pull-left img_single" ><img src="<?php echo $data->GroupImage ?>"  ></a>
            <?php } ?>
            <div class="media-body" >
                <p  data-postid="<?php echo $data->PostId; ?>">
                    <a><b><?php echo $data->HashTagName; ?></b></a>
                </p>
                <p><?php
                    echo $data->GroupDescription;
                    ?></p>
            </div>
            <div class="social_bar" data-id="<?php echo $data->_id ?>" data-curbsidecategoryid="<?php echo $data->PostId ?>" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>">	
                <a style="cursor:pointer"><i><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $data->IsFollowingEntity ? Yii::t('translation','UnFollow') : Yii::t('translation','Follow') ?>" class=" tooltiplink <?php echo $data->IsFollowingEntity ? 'follow' : 'unfollow' ?>" ></i>
                <b class="streamFollowUnFollowCount"  data-actiontype='Followers' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->HashTagPostCount?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="hashtag_followers_count_<?php echo $data->_id ?>"><?php echo $data->HashTagPostCount ?></span>
                <?php 
                
                $data->FollowCount = $data->HashTagPostCount;
                include Yii::app()->basePath.'/views/common/userFollowActionView.php';
                
                ?>                      
                </b></a>
            </div>
        </li>
    </ul>
</div>