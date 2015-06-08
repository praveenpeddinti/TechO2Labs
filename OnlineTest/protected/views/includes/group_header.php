<div class="stream_title paddingt5lr10 stream_sectionheader" style="position: relative"> 

    <a class="<?php if ($data->isGroupAdminPost == 'true' && $data->ActionType == 'Post') {
    echo 'grpIntro';
} else {
    echo 'userprofilename';
} ?> " data-id="<?php if ($data->isGroupAdminPost == 'true' && $data->ActionType == 'Post') {
                echo $data->MainGroupId;
            } else {
                echo $data->FirstUserId;
            } ?>" style="cursor:pointer">
        <b><?php
            if ($data->isGroupAdminPost == 'true' && $data->ActionType == 'Post') {
                echo html_entity_decode($data->GroupName);
            } else {
                echo $data->FirstUserDisplayName;
            }
?></b></a><?php echo $data->SecondUserData ?> 
                <?php echo $data->StreamNote  ?> 
  

    <div class="postmg_actions"  >
        <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
        <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
        <div class="dropdown-menu ">
            <ul class="PostManagementActions" data-streamId="<?php echo $data->_id ?>"  data-postId="<?php echo $data->PostId ?>" data-categoryType="<?php echo $data->CategoryType ?>" data-postType="<?php echo $data->PostType ?>" data-networkId="<?php echo $data->NetworkId ?>">
                <?php if($data->CanMarkAsAbuse==1){?>
                <li><a class="abuse"><span class="abuseicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','FlagAsAbuse_label'); ?></a></li>
                <?php } ?>
<?php if ($data->CanPromotePost == 1) { ?><li><a class="promote"><span class="promoteicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Promote_label'); ?></a>
                    </li><?php } ?>
                     <?php if (($data->CanSaveItForLater == 1 && (isset($data->IsSaveItForLater) && $data->IsSaveItForLater!=1) )) { ?><li><a class="saveitforlater"><span class="saveitforlatericon"><img src="/images/system/spacer.png" /></span>  <?php echo  Yii::t('translation','Can_SaveItForLater'); ?></a>
                            </li><?php } ?>
<?php if ($data->CanDeletePost == 1) { ?><li><a class="delete"><span class="deleteicon"><img src="/images/system/spacer.png" /></span> Delete</a></li><?php } ?>
            </ul>
        </div>
    </div>
</div>