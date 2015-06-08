<?php if (!isset($data->AddSocialActions) || $data->AddSocialActions == 1) { ?>          
<?php if($data->RestrictedAccessGroup == 1){ ?>
                        <a href="/<?php echo $data->GroupUniqueName ?>" ><div class="disabledelement"></div></a>
                        <?php } ?>
    <div  <?php if ($data->CategoryType == 11) echo "style= 'display:none;'" ?> <?php echo $joyride == 0 ? "id='numero3'" : ""; ?> class="social_bar" data-id="<?php echo $data->_id ?>" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-networkId="<?php echo $data->NetworkId; ?>" data-iframemode="<?php echo $data->IsIFrameMode; ?>">	


        <?php $joyride = $joyride + 1; //if($this->tinyObject->UserId != $tinyOriginalUser['UserId']){?>
        <a class="follow_a"  <?php if($data->RestrictedAccessGroup == 1){ ?> style="position: inherit;cursor: none;" <?php } ?>><i ><img src="/images/system/spacer.png" class=" tooltiplink <?php echo $data->IsFollowingPost ? 'follow' : 'unfollow' ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $data->IsFollowingPost ? Yii::t('translation','UnFollow') : Yii::t('translation','Follow') ?>" ></i> <b class="streamFollowUnFollowCount"  data-actiontype='Followers' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->FollowCount?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="streamFollowUnFollowCount_<?php  echo $data->PostId; ?>"><?php  echo $data->FollowCount ?></span > <?php include Yii::app()->basePath.'/views/common/userFollowActionView.php'; ?></b></a>

         
            <?php //} ?>  
        <?php if ($data->PostType != 5 && $data->PostType != 13 && $data->CategoryType != 3) { ?>
            <a ><i><img src="/images/system/spacer.png" class=" tooltiplink cursor invite_frds" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Invite'); ?>" ></i></a>
        <?php } ?>  
        <?php if ($data->PostType != 5 && $data->CategoryType != 3) { ?>
            <span class="cursor"><i><img  class=" tooltiplink cursor <?php echo $data->IsLoved ? 'likes' : 'unlikes' ?>"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>" src="/images/system/spacer.png"></i><b class="streamLoveCount"  data-actiontype='Love' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->LoveCount?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="streamLoveCount_<?php echo $data->PostId; ?>"><?php echo $data->LoveCount?></span> <?php include Yii::app()->basePath.'/views/common/userLoveActionView.php'; ?></b></span>
   
        <?php } ?> 
        <?php
        if ($data->CategoryType == 1) {
            if (!$data->TwitterShare || !$data->FbShare) {
                $shareCount = (isset($data->ShareCount) && is_int($data->ShareCount)) ? $data->ShareCount : 0;
                $shareClass = ($data->TwitterShare || $data->FbShare) ? 'sharedisable' : 'share';
                ?>
                <span class="sharesection" ><i class="tooltiplink" data-toggle="dropdown" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Share'); ?>" data-placement="bottom"><img src="/images/system/spacer.png"  class="<?php echo $shareClass; ?>"  ></i><b id="streamShareCount_<?php echo $data->_id; ?>"><?php echo $shareCount; ?></b>
                    <div class="dropdown-menu actionmorediv">

                        <ul id="share_<?php echo $data->_id; ?>">
                            <?php if (!$data->FbShare) { ?>
                                <li class="shareFacebook"><a onclick="prepareWallPostData('<?php echo $data->PostId ?>', '<?php echo $data->CategoryType; ?>', '<?php echo $data->PostType; ?>', '<?php echo $data->_id; ?>')"><i class="fa fa-facebook"></i> Facebook</a></li>
                            <?php }if (!$data->TwitterShare) { ?>
                                <li class="shareTwitter"><a onclick="getTweetLink('<?php echo $data->PostId ?>', '<?php echo $data->CategoryType; ?>', '<?php echo $data->PostType; ?>', '<?php echo $data->_id; ?>')"><i class="fa fa-twitter"></i> Twitter</a></li>
            <?php } ?>
                        </ul>

                    </div>

                </span><?php } else { ?>
                <span class="sharesection"><i class="tooltiplink" data-toggle="dropdown" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Share'); ?>" data-placement="bottom"><img src="/images/system/spacer.png"  class="sharedisable"  ></i><b id="streamShareCount_<?php echo $data->_id; ?>"><?php echo (isset($data->ShareCount) && is_int($data->ShareCount)) ? $data->ShareCount : 0 ?></b></span>
            <?php }
        } ?>

        <?php if (!$data->DisableComments && $data->CategoryType != 3) { ?>
            <span><i ><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class=" cursor tooltiplink  <?php if ($data->PostType != 5) { ?><?php echo $data->IsCommented ? 'commented' : 'comments' ?><?php } else { ?><?php echo $data->IsCommented ? 'commented1' : 'comments1' ?> postdetail<?php } ?>" <?php if ($data->PostType == 5) { ?> data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" <?php } ?> ></i><b id="commentCount_<?php echo $data->PostId; ?>" data-postId="commentCount_<?php echo $data->PostId; ?>"><?php echo $data->CommentCount ?></b></span>              
    <?php } ?>
        <div id="socialactionsError_<?php echo $data->PostId ?>" class="alert alert-error displayn"></div>
    </div>
<?php
}?>