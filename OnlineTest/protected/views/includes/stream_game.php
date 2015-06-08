<!-- spinner -->
<div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
<div id="stream_view_detailed_spinner_<?php echo $data->PostId; ?>"></div>
<!-- end spinner -->
<div class=" stream_content positionrelative">
    <span id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></span>
    <ul>
        <li class="media">
            <a  href="/<?php echo $data->GameName ?>/<?php echo $data->CurrentGameScheduleId ?>/detail/game " class="pull-left img_single" ><img src="<?php if (isset($data->Resource)) {
    echo $data->Resource;
} else {
    echo $data->GameBannerImage;
} ?>"  ></a>

            <div class="media-body gameDesc"  >

                <p class="cursor" id="stream_gameName_<?php echo $data->_id ?>">
                    <?php echo $data->GameName ?>
                 </p >
                 <p class="cursor" id="stream_gameDescription_<?php echo $data->_id ?>"><?php echo $data->PostText;?></p>
                 <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
            </div>
            
            <div class="alignright clearboth eventButtonPosition"  > 
                <?php
                if ($data->GameStatus == "play") {
                    $class = "btn btnplay btnplaymini";
                    $label = Yii::t('translation','Play_Now')." <i class='fa fa-chevron-circle-right'></i>";
                } else if ($data->GameStatus == "resume") {
                    $class = "btn btnresume btnplaymini";
                    $label = Yii::t('translation','Resume')." <i class='fa fa-chevron-circle-right'></i>";
                } else if ($data->GameStatus == "view") {
                    $class = "btn btnviewanswers btnplaymini";
                    $label = Yii::t('translation','View')." <i class='fa fa-chevron-circle-right'></i>";
                }
                ?> <?php if ($data->GameStatus != "future") { ?>
                <a id="clickButton" data-gameName="<?php echo $data->GameName?>" data-scheduleId="<?php echo $data->CurrentGameScheduleId ?>" data-gameStatus="<?php echo $data->GameStatus?>"  class="group">
                        <button  class="<?php echo $class ?> " type="button"><?php echo $label ?> </button></a>
                <?php } ?>    
            </div>
            <div class="social_bar" data-id="<?php echo $data->_id ?>" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-networkId="<?php echo $data->NetworkId; ?>" data-iframemode="<?php echo $data->IsIFrameMode; ?>">	
                <a class="follow_a"><i ><img src="/images/system/spacer.png" class=" tooltiplink <?php echo $data->IsFollowingPost ? 'follow' : 'unfollow' ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $data->IsFollowingPost ? Yii::t('translation','UnFollow') : Yii::t('translation','Follow') ?>" ></i> <b class="streamFollowUnFollowCount"  data-actiontype='Followers' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo count($data->PostFollowers)?>" data-categoryId="<?php  echo $data->CategoryType;?>" ><span id="streamFollowUnFollowCount_<?php echo $data->PostId; ?>"><?php echo $data->FollowCount ?></span>
                    <?php 
                    $data->FollowCount = count($data->PostFollowers);
                    include Yii::app()->basePath.'/views/common/userFollowActionView.php'; ?>
                    </b></a>
                <?php if (!$data->DisableComments && $data->IsUseForDigest == 1) { ?>


                    <span><i ><a href="/<?php echo $data->GameName ?>/<?php echo $data->CurrentGameScheduleId ?>/detail/game "><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class=" cursor tooltiplink  <?php if ($data->PostType != 5) { ?><?php echo $data->IsCommented ? 'commented' : 'comments' ?><?php } else { ?>comments1 postdetail<?php } ?>" <?php if ($data->PostType == 5) { ?> data-id="<?php echo $data->PostId; ?>" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" <?php } ?> ></a></i><b id="commentCount_<?php echo $data->PostId; ?>"><?php echo $data->CommentCount ?></b></span>
                <?php } ?>
                <div id="socialactionsError_<?php echo $data->PostId ?>" class="alert alert-error displayn"></div>
            </div>
        </li>
    </ul>
</div>
<script type="text/javascript">
    
    $('#clickButton').live("click",function(){        
        var gameName=$(this).attr("data-gameName");
        var scheduleId=$(this).attr("data-scheduleId");
        var gameStatus=$(this).attr("data-gameStatus");
         window.location='/'+gameName+'/'+scheduleId+'/'+gameStatus+'/game';
    });
</script>