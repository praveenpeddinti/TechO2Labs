<div class=" stream_content positionrelative">
    <span id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></span>
    <ul>
        <li class="media">
            <?php if ($data->GroupImage != '') { ?>
                <a  class="pull-left img_single" ><img src="<?php echo $data->GroupImage ?>"  ></a>
            <?php } ?>
            <div class="media-body" >
                <p  data-postid="<?php echo $data->PostId; ?>">
                    <a><b><?php echo $data->CurbsideConsultCategory; ?></b></a>
                </p>
                <p></p>
            </div>
            <div class="social_bar" data-id="<?php echo $data->_id ?>" data-curbsidecategoryid="<?php echo $data->CurbsideCategoryId ?>" data-postid="<?php echo $data->CurbsideCategoryId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>">	
                <a style="cursor:pointer"><i><img src="/images/system/spacer.png"  class=" tooltiplink <?php echo $data->IsFollowingEntity ? 'follow' : 'unfollow' ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo $data->IsFollowingPost ? Yii::t('translation','UnFollow') : Yii::t('translation','Follow') ?>" ></i>
                <b class="streamFollowUnFollowCount"  data-actiontype='Followers' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->CurbsideCategoryId?>' data-count="<?php echo $data->CurbsidePostCount?>" data-categoryId="<?php  echo $data->CategoryType;?>" ><span id="curbside_followers_count_<?php echo $data->_id ?>"><?php echo $data->CurbsidePostCount ?></span>
                        <?php
// if($data->FollowCount>0){
   ?>
                            <div  class="userView" id="userFollowView_<?php  echo $data->CurbsideCategoryId; ?>"  data-postId='<?php echo $data->CurbsideCategoryId?>' data-count="<?php echo $data->CurbsidePostCount?>" style="display:none">
                         <?php 
                                 foreach ($data->followUsersArray as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if($data->CurbsidePostCount>10){
                                         echo "<div data-actiontype='Followers' data-postid='$data->CurbsideCategoryId' data-id='$data->_id' data-categoryId='$data->CategoryType' class='moreUsers'>more...</div>" ;
                                      } 
                                 ?>
                         </div>
                            <?php 
// } 
                            
                            ?>  
                    
                    </b>
                    </a>
            </div>
        </li>
    </ul>
</div>