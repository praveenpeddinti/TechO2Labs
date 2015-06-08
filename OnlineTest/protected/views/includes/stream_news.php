<!-- spinner -->
<div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
<div id="stream_view_detailed_spinner_<?php echo $data->PostId; ?>"></div>
<!-- end spinner -->
<div class=" stream_content positionrelative">
    <span id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></span>
    <ul>
        <li class="media">
            <?php if ($data->HtmlFragment != '') { ?>
                <a  class="pull-left img_single  postdetail" id='<?php echo $data->_id; ?>' data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>">
                    <?php $object = stristr($data->HtmlFragment, '<object');
                    if ($object != '') {
                        ?>
                        <div class="galleria-info" style="bottom:0px"><div class="galleria-info-text" style="border-radius:0px"><div class="galleria-info-description" style="height:132px"></div></div></div>
                    <?php } ?>
                    <?php
                    $pattern = '/(width)="[0-9]*"/';
                    $string = $data->HtmlFragment;
                    $string = preg_replace($pattern, "width='180'", $string);
                    $pattern = '/(height)="[0-9]*"/';
                    $string = preg_replace($pattern, "height='150'", $string);

                    echo $string;
                    ?>
                </a>
<?php } ?>
              <div class="media-body" >
                            <?php if(strlen($data->Editorial)>0){?>
                        <div class="clearboth ">                          
                        <div class="decorated " style="margin-top: 0px"><?php echo $data->Editorial?></div></div>      
                        <?php }?>
                            <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>"  data-id="<?php echo $data->_id; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_total_<?php echo $data->_id; ?>" style="display:none" >
                                <?php echo $data->PostCompleteText; ?>
                            </div>
                            <p class="cursor postdetail" id="post_content_<?php echo $data->_id; ?>" data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>" data-news='yes'>
                               <?php echo $data->PostText;?>
                            </p>
                            <p></p>
                        </div>
            <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
            <div class="social_bar" data-id="<?php echo $data->_id ?>" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-networkId="<?php echo $data->NetworkId; ?>" data-iframemode="<?php echo $data->IsIFrameMode; ?>">	
                <a class="follow_a"><i ><img src="/images/system/spacer.png" class=" tooltiplink <?php echo $data->IsFollowingPost ? 'follow' : 'unfollow' ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $data->IsFollowingPost ? Yii::t('translation','UnFollow') : Yii::t('translation','Follow') ?>" ></i><b class="streamFollowUnFollowCount"  data-actiontype='Followers' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->FollowCount?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="streamFollowUnFollowCount_<?php  echo $data->PostId; ?>"><?php  echo $data->FollowCount ?></span> <?php include Yii::app()->basePath.'/views/common/userFollowActionView.php'; ?></b></a>
                <?php if (!$data->DisableComments) { ?>
                    <span><i ><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class=" cursor tooltiplink comments1 postdetail" <?php if ($data->PostType == 11) { ?> data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" <?php } ?> ></i><b id="commentCount_<?php echo $data->_id; ?>"><?php echo $data->CommentCount ?></b></span>              
<?php } ?>
                <div id="socialactionsError_<?php echo $data->PostId ?>" class="alert alert-error displayn"></div>
            </div>
        </li>
    </ul>
</div>