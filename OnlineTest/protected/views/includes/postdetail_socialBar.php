<div class="social_bar social_bar_detailed detailpage" data-id="<?php  echo $data->_id ?>" data-postid="<?php  echo $data->_id ?>" data-categoryType="<?php  echo $data->CategoryType;?>" data-networkId="<?php  echo $data->NetworkId; ?>">	
    <a class="follow_a"><i><img src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php  echo $data->IsFollowing? Yii::t('translation','UnFollow') : Yii::t('translation','Follow');?>" class="<?php  echo $data->IsFollowing?'follow':'unfollow';?>" id="detailedfolloworunfollow" data-postid="<?php  echo $data->_id ?>" data-catogeryId="<?php  echo $data->CategoryType;?>"></i><b class="dFollowers"  data-categoryId="<?php  echo $data->CategoryType;?>" data-actiontype='Followers' data-id='<?php echo $data->_id?>' data-count="<?php echo count($data->Followers)?>"><span id="streamFollowUnFollowCount_<?php  echo $data->_id; ?>"><?php  echo count($data->Followers) ?></span>
                    
                         <?php 
                  $lovefollowArray=$data->lovefollowArray;
                
                       ?>                      
            <div  class="userView userFollowView" id="userDetailFollowView_<?php  echo $data->_id; ?>" data-postId='<?php echo $data->_id?>' style="display: none">
                         <?php 
                         
                                 foreach ($lovefollowArray["followUsersArray"] as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if(count($data->Followers)>10){
                                         echo "<div data-actiontype='Followers' data-categoryId='$data->CategoryType' data-postid='$data->_id' data-id='$data->_id' class='detailMoreUsers'>more...</div>" ;
                                      } 
                                 ?>
                         </div>
               
                    </b></a>
                
              
                <?php if($data->CategoryType!=10){?>
                <a ><i><img  src="/images/system/spacer.png"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Invite'); ?>" class="tooltiplink cursor invite_frds" id="invitefriendsDetailed" data-postid="<?php  echo $data->_id ?>"></i></a>
                <?php }?>
                <span class="cursor"><i><img  class=" <?php if($data->IsLoved){ echo"likes";  }else{ echo"unlikes";};?> " data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>"  src="/images/system/spacer.png" id="detailedLove" data-postid="<?php  echo $data->_id ?>" data-catogeryId="<?php  echo $data->CategoryType;?>"></i><b class="dLoves"  data-actiontype='Love' data-id='<?php echo $data->_id?>' data-categoryId="<?php  echo $data->CategoryType;?>" data-count="<?php echo count($data->Love)?>"><span id="detailedLoveCountSpan"><?php  echo count($data->Love); ?></span>
                    
                    
                    
                                       
                <div  class="userLoveView" id="userDetailLoveView_<?php  echo $data->_id; ?>" data-postId='<?php echo $data->_id?>' data-count="<?php echo count($data->Love)?>">
                         <?php 
                                 foreach ($lovefollowArray["loveUsersArray"] as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if(count($data->Love)>10){
                                         echo "<div data-actiontype='Love' data-categoryId='$data->CategoryType' data-postid='$data->_id' data-id='$data->_id' class='detailMoreUsers'>more...</div>" ;
                                      } 
                                 ?>
                         </div>
             
                    </b></span>
                

                
                <?php if($data->CategoryType<3){
                    if(!$data->IsTwitterShare || !$data->IsFbShare){
                        ?>
                <span class="sharesection"><i class="tooltiplink" data-toggle="dropdown" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Share'); ?>" data-placement="bottom"><img src="/images/system/spacer.png"  class="<?php echo $data->ShareClass; ?>"  ></i><b id="streamShareCount_<?php  echo $data->_id; ?>"><?php  echo $data->ShareCount;?></b>
                    <div class="dropdown-menu actionmorediv">
                         <ul id="share_<?php echo $data->_id; ?>">
                             <?php if(!$data->IsFbShare){ ?>
                             <li class="shareFacebook"><a onclick="prepareWallPostData('<?php  echo $data->_id ?>','<?php  echo $data->CategoryType;?>','<?php  echo $data->Type;?>','<?php  echo $data->_id;?>','postDetail')"><i class="fa fa-facebook"></i> Facebook</a></li>
                             <?php }if(!$data->IsTwitterShare){ ?>
                             <li class="shareTwitter"><a onclick="getTweetLink('<?php  echo $data->_id ?>','<?php  echo $data->CategoryType;?>','<?php  echo $data->Type;?>','<?php  echo $data->_id;?>','postDetail')"><i class="fa fa-twitter"></i> Twitter</a></li>
                             <?php } ?>
                        </ul>
                    </div>
                 </span>
                <?php }else{?>
                    <span class="sharesection"><i class="tooltiplink" data-toggle="dropdown" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Share'); ?>" data-placement="bottom"><img src="/images/system/spacer.png"  class="sharedisable"  ></i><b id="streamShareCount_<?php  echo $data->_id; ?>"><?php  echo $data->ShareCount;?></b></span>
                <?php }} ?>
  <?php   if(!$data->DisableComments){?>
                <span><i><img src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class="detailedComment tooltiplink cursor  <?php   if($data->Type!=5){?><?php echo $data->IsCommented?'commented':'comments'?><?php  }else{?><?php echo $data->IsCommented?'commented':'comments1'?><?php  }?>"  id="detailedComment"  data-postid="<?php  echo $data->_id ?>"></i><b id="det_commentCount_<?php  echo $data->_id ?>"><?php  echo $data->CommentCount; ?></b></span>
                  <?php  }?>              
                
                
                            <?php //echo "bb--".$data->IsEventAttend."--ss--".$data->IsSurveyTaken; 
                            if($data->PostType==2){?>
                <a class=" "><i><img  src="/images/system/spacer.png"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Event_Attendies'); ?>" class="tooltiplink cursor <?php if($data->IsEventAttend ==1 ) echo "eventattend_yes";else echo "eventattend_no"?>" id="eventAttendDetailedImg" data-postid="<?php  echo $data->_id ?>"></i>
                <b class="dEventAttend positionrelative"  data-actiontype='EventAttend' data-id='<?php echo $data->_id?>' data-categoryId="<?php  echo $data->CategoryType;?>" data-count="<?php echo $data->EventAttendCount?>"><span id="detailedEventAttenCountSpan"><?php  echo ($data->EventAttendCount); ?></span>
                <div  class="userEventAttendView" id="userDetailEventAttenView_<?php  echo $data->_id; ?>" data-postId='<?php echo $data->_id?>' data-count="<?php echo $data->EventAttendCount?>">
                         <?php 
                                 foreach ($lovefollowArray["eventAttendUsersArray"] as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if($data->EventAttendCount>10){
                                         echo "<div data-actiontype='EventAttend' data-categoryId='$data->CategoryType' data-postid='$data->_id' data-id='$data->_id' class='detailMoreUsers'>more...</div>" ;
                                      } 
                                 ?>
</div> 
                
                </b>
                
                </a>
                <?php }?>
                
                <?php if($data->PostType==3){?>
                <a ><i><img  src="/images/system/spacer.png"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Survey_Users'); ?>" class="tooltiplink cursor <?php if($data->IsSurveyTaken ==1 ) echo "survey_yes";else echo "survey_no"?>" id="surveyDetailedImg" data-postid="<?php  echo $data->_id ?>"></i>
                <b class="dSurvey positionrelative"  data-actiontype='Survey' data-id='<?php echo $data->_id?>' data-categoryId="<?php  echo $data->CategoryType;?>" data-count="<?php echo $data->SurveyTakenCount?>"><span id="detailedSurveyCountSpan"><?php  echo $data->SurveyTakenCount; ?></span>
                <div  class="userSurveyView" id="userDetailSurveyView_<?php  echo $data->_id; ?>" data-postId='<?php echo $data->_id?>' data-count="<?php echo $data->SurveyTakenCount?>">
                         <?php 
                                 foreach ($lovefollowArray["surveyUsersArray"] as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if($data->SurveyTakenCount>10){
                                         echo "<div data-actiontype='Survey' data-categoryId='$data->CategoryType' data-postid='$data->_id' data-id='$data->_id' class='detailMoreUsers'>more...</div>" ;
                                      } 
                                 ?>
                         </div>
                
                </b>
                
                </a>
                <?php }?>
                                        
</div> 
