<div class="stream_title paddingt5lr10 stream_sectionheader"   style="position: relative"  >
              <?php  $isPostManagement = isset($isPostManagement)?$isPostManagement:0; ?>
                <?php if ($data->IsAnonymous == 1 && $data->RecentActivity=="UserMention") {?>
                    <b class="graytext"><?php echo $data->FirstUserDisplayName;
                    ?></b><?php }else{ ?><a  <?php if($data->CategoryType==11 || $data->CategoryType==14)echo "style= 'display:none;'"?> class="<?php if($data->isGroupAdminPost == 'true' && $data->ActionType=='Post') { echo 'grpIntro';} else if($data->CategoryType==9 && $data->ActionType=='Post' ) { echo '';}else{echo 'userprofilename';} ?> " <?php if($data->CategoryType==9 && $data->ActionType=='Post') { echo 'style="text-decoration:none;"';} ?> data-groupname="<?php echo $data->GroupUniqueName; ?>" data-streamId="<?php echo $data->_id;?>" data-id="<?php if($data->isGroupAdminPost == 'true' && $data->ActionType=='Post') { echo $data->MainGroupId; } else { echo $data->FirstUserId; } ?>" style="cursor:pointer"><b><?php if($data->isGroupAdminPost == 'true' && $data->ActionType=='Post') {
                           echo html_entity_decode($data->GroupName);
                        }else{
                            echo $data->FirstUserDisplayName; }?></b></a><?php }?><?php echo $data->SecondUserData?> 
    <?php  echo $data->StreamNote;  ?>   
               <?php $PostId=$data->PostId;$fromSTream=true;
               include Yii::app()->basePath.'/views/includes/postdetail_actions.php';
                ?>
    
   <?php if(isset($data->SpotsMessage) && !empty($data->SpotsMessage) && $data->CategoryType==16 ){?>
    <div class="stream_spots_message" >
            <span><i class="fa fa-info-circle"  ></i><b id="spots_<?php echo $data->PostId?>"><?php echo $data->SpotsMessage?></b>  </span>
        </div>
    <?php } ?>  
                        </div>
