<?php //if($this->tinyObject->UserId != $tinyOriginalUser['UserId']){?>
<a class="follow_a"><i ><img src="/images/system/spacer.png"  class="tooltiplink cursor <?php echo $data->IsFollowingPost ? 'follow' : 'unfollow' ?>"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $data->IsFollowingPost ? Yii::t('translation','UnFollow') : Yii::t('translation','Follow') ?>" ></i><b class="streamFollowUnFollowCount"  data-actiontype='Followers'  data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->FollowCount?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="streamFollowUnFollowCount_<?php  echo $data->PostId; ?>"><?php  echo $data->FollowCount ?></span>
      <?php include Yii::app()->basePath.'/views/common/userFollowActionView.php'; ?>
    </b></a>
 
<?php //} ?>
<?php if ($data->PostType != 5) { ?>
    <a ><i><img src="/images/system/spacer.png" class="tooltiplink cursor invite_frds" data-placement="bottom" rel="tooltip"  data-original-title="Invite"  ></i></a>
    
<?php } ?>

<?php if ($data->PostType != 5) { ?>
    <a ><i><img src="/images/system/spacer.png" style="display: none;" class=" share" ></i></a>
    <span><i><img class=" tooltiplink cursor <?php echo $data->IsLoved ? 'likes' : 'unlikes' ?>"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>" src="/images/system/spacer.png"></i><b class="streamLoveCount"  data-actiontype='Love' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->LoveCount?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="streamLoveCount_<?php  echo $data->PostId; ?>"><?php  echo $data->LoveCount?></span>
         <?php include Yii::app()->basePath.'/views/common/userLoveActionView.php'; ?>
        </b></span>
    

<?php } ?> 
<?php if (!$data->DisableComments) { ?>
    <span><i><img src="/images/system/spacer.png"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class="tooltiplink cursor <?php if ($data->PostType != 5) { ?><?php echo $data->IsCommented ? 'commented' : 'comments' ?><?php } else { ?><?php echo $data->IsCommented ? 'commented' : 'comments1' ?><?php } ?>" ></i><b id="commentCount_<?php echo $data->PostId; ?>"><?php echo $data->CommentCount ?></b></span>              
<?php } ?>