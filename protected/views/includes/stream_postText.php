<!-- spinner -->
<div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
<div id="stream_view_detailed_spinner_<?php echo $data->PostId; ?>"></div>
<!-- end spinner -->
<div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>"  data-id="<?php echo $data->_id; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_total_<?php echo $data->_id; ?>" style="display:none" >
    <?php echo $data->PostCompleteText; ?>
</div>
<div class="bulletsShow <?php if ($data->PostType == 15) { ?> postdetail <?php } ?>" data-postid="<?php echo $data->PostId; ?>" <?php if ($data->PostType == 15) { ?>data-profile="<?php echo $data->PostCompleteText;
    } ?>"  data-id="<?php echo $data->_id; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_<?php echo $data->_id; ?>" <?php if ($data->PostType == 5) { ?> class="postdetail" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>" <?php } ?> >
    <?php
    if ($data->CategoryType == 11) {//NetworkInvite
        include Yii::app()->basePath . '/views/includes/stream_networkInvite.php';
    } else {
        echo $data->PostText;
    }
    ?>
</div>
