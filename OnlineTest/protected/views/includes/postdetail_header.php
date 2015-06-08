<div class="stream_title paddingt5lr10 stream_sectionheader" style="position: relative">  
    <a class="<?php if($data->IsGroupPostAdmin == 'true') { echo 'grpIntro'; } else { echo 'userprofilename_detailed';} ?> " data-postId="<?php echo $data->_id;?>" data-id="<?php if($data->IsGroupPostAdmin == 'true') { echo $data->GroupId; } else { echo $data->UserId; } ?>" style="cursor:pointer"> 
        <b>
            <?php if($data->IsGroupPostAdmin == 'true') {
               echo html_entity_decode($data->GroupName); 
            }else{
                if($data->Type != 4 && $data->IsAnonymous == 0){
                   echo $data->DisplayName1; 
                }
            } ?>
        </b>
    </a>  
    <?php echo $data->StreamTitle; ?>
    <?php include 'postdetail_actions.php';?>
</div>