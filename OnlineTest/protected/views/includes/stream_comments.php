<div id="commentSpinLoader_<?php echo $data->_id; ?>"></div>
<?php
$comments = $data->Comments;
$commentCount = sizeof($comments);
?>
<div class="myClass" id="CommentBoxScrollPane_<?php echo $data->_id; ?>"  >
    <div   id="commentbox_<?php echo $data->_id ?>" style="display:<?php echo $data->CommentCount > 0 ? 'block' : 'none'; ?>">
        <div id="commentsAppend_<?php echo $data->_id; ?>"></div>
        <?php include Yii::app()->basePath . '/views/includes/stream_commentBody.php'; ?>
    </div> 
</div>