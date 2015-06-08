<?php 


if(isset($canMarkAsAbuse) && $canMarkAsAbuse){ 
       $commentDisplayPage = isset($commentDisplayPage)?$commentDisplayPage:"";
      
        if($isPostManagement!=1 ){
    ?>
<div class="positionrelative padding-right30 streampostactions postmg_actions_div">
    <div class="postmg_actions">
        <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
        <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
        <div class="dropdown-menu ">
            <ul class="CommentManagementActions" data-commentId="<?php echo $commentId; ?>" data-streamId="<?php echo $streamId ?>"  data-postId="<?php echo $postId ?>" data-categoryType="<?php echo $categoryType ?>" data-networkId="<?php echo $networkId ?>" data-page="<?php echo $commentDisplayPage ?>">
                <li><a class="abuse"><span class="abuseicon"><img src="/images/system/spacer.png" /></span> Flag as abuse</a></li>
            </ul>
        </div>
    </div>
</div>
        <?php } } ?>