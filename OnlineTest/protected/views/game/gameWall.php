 <?php if(is_object($stream))  
 {
     try {$dateFormat =  CommonUtility::getDateFormat();
         foreach($stream as $data){
              $canMarkAsAbuse = isset($data->CanMarkAsAbuse)?$data->CanMarkAsAbuse:0;
            $translate_fromLanguage = $data->Language;
            $translate_class = "translatebutton";
            $translate_id = $data->_id;
            $translate_postId = $data->PostId;
            $translate_postType = $data->PostType;
            $translate_categoryType = $data->CategoryType;
            $translate_location = 'schedules';
        ?>
<div  class="post item streamactionsdiv " style="" id="postitem_<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>">  
    <li class="gamelist <?php echo (isset($data->IsPromoted) && $data->IsPromoted==1)?'gamepromoted':''; ?> " id="gameId_<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-posttype="<?php  echo $data->PostType;?>" data-categorytype="<?php  echo $data->CategoryType;?>">
        
        <div style="position: relative" class="gamewallpop">
        <div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
        <div id="schedule_<?php echo $data->_id; ?>" class='scheduleGameDiv' style="top:0px;position: relative;right: 0px;left: 0px;bottom:0;background-color: #e6e6e6;z-index: 9;display:none" ></div>
        <div id="game_<?php echo $data->_id; ?>" class="stream_widget">
        <div class="stream_title paddingt5lr10 " style="cursor: pointer;position:relative;padding-right:30px">
           
             <?php  $time=$data->CreatedOn?>
                  <a href="/<?php echo $data->GameName ?>/<?php echo $data->CurrentGameScheduleId ?>/detail/game " class="">
                    <b id="gameName_<?php echo $data->_id ?>" data-id="<?php echo $data->_id ?>"  data-name="<?php echo   $data->GameName ?>" class="group"><?php echo $data->GameName;   ?></b>
                  </a>
            
             <?php if(isset($data->AdType) && $data->AdType == 1){ ?>
            <span  class="brand_box"><?php echo $data->BannerTitle; ?></span> 
            <?php } ?> 
                <?php if(Yii::app()->session['IsAdmin']==1 || $data->CanDeletePost==1 ){?>
            <div style="position: absolute;right:5px;top:4px">        
            <div class="postmg_actions" style="margin-right:0;">
                    <i data-placement="right" data-toggle="dropdown" class="fa fa-chevron-down"></i>
                    <i data-placement="right" data-toggle="dropdown" class="fa fa-chevron-up"></i>
                  
                    <div class="dropdown-menu margindropdown ">
                        
                        <ul class="PostManagementActions" data-streamId="<?php echo $data->_id ?>"  data-postId="<?php echo $data->PostId ?>" data-categoryType="<?php echo $data->CategoryType ?>" data-networkId="<?php echo $data->NetworkId ?>" date-useForDigest="<?php echo $data->IsUseForDigest ?>">
                            
                           <?php if($data->IsDeleted == 0 && Yii::app()->session['IsAdmin']==1 ){?> <li><a href="/game/edit/<?php echo $data->PostId ?>" class="" id=""><span class="featuredicon"><img src="/images/system/spacer.png"></span> <?php echo Yii::t('translation','Edit'); ?></a></li><?php }?>
                           
                                        <?php if (Yii::app()->session['IsAdmin'] == 1) { ?>
                                                        <?php if ($data->IsDeleted == 1) { ?>                    <li><a class="release"><span class="releaseicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Release_Game'); ?></a></li><?php
                                                        } else {
                                                            ?>
                                                <li><a class="suspend"><span class="deleteicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Suspend_Game'); ?></a></li>
                                                <li><a class="usefordigest"><span class="<?php echo $data->IsUseForDigest==1?'notusefordigesticon':'usefordigesticon';?>"><img src="/images/system/spacer.png" /></span> <?php $digsetlable=$data->IsUseForDigest==1?'notusefordigest_label':'usefordigest_label'; echo Yii::t('translation',$digsetlable);  ?></a></li>
                                                    <?php
                                            }
                                        }
                                        ?>
                        
                        </ul>
                       
                        </div>
                   
                </div>  </div> <?php }?> 
                              </div>
    
        <div class="mediaartifacts positionrelative"><a href="/<?php echo $data->GameName ?>/<?php echo $data->CurrentGameScheduleId ?>/detail/game " class="group"> <img src="<?php echo $data->GameBannerImage ?>"></a>
        <div class="isFeatured" id="isFeatutedIcon_<?php  echo $data->_id ?>" <?php if($data->IsFeatured==1){?> style="display:block" <?php }else {?> style="display:none"<?php  }?> > </div></div>
        
            <div class="g_descriptiontext impressionDiv" style="word-wrap: break-word" id="gameDescription_<?php echo $data->_id ?>" data-id="<?php echo $data->_id ?>"  data-name="<?php echo $data->GameDescription ?>" class="group"><?php echo $data->GameDescription?>
        </div>
        <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
        
        <?php if (Yii::app()->session['IsAdmin']==1) { ?>
        <div class="row-fluid">
                        <div class="span12">
                            
                            
                          
                                            <?php if ($data->SchedulesArray != 'noschedules') { ?>

                                                <?php foreach ($data->SchedulesArray as $schedule) { ?>

                            <span id="scheduleId_<?php echo $schedule['_id'] ?>" class="g_scheduleDate g_scheduleDateGameWall"><?php echo date($dateFormat,CommonUtility::convert_date_zone($schedule['StartDate']->sec,Yii::app()->session['timezone'],  date_default_timezone_get()));  ?>  to  <?php echo date($dateFormat,CommonUtility::convert_date_zone($schedule['EndDate']->sec,Yii::app()->session['timezone'],  date_default_timezone_get()));  ?> 


                                                        <?php
                                                        if ($schedule['IsCurrentSchedule'] == 1) {

                                                           if ($schedule['EndDate']->sec >= time()) {
                               
                                                               ?>
                                
                                                                <span id="cancelscheduleid_<?php echo $schedule['_id'] ?>" style="padding-left: 10px" data-streamId="<?php echo $data->_id ?>"  data-postId="<?php echo $data->PostId ?>" data-categoryType="<?php echo $data->CategoryType ?>" data-scheduleId="<?php echo $schedule['_id'] ?>"  class="deleteicon  cancelschedule"><img src="/images/system/spacer.png" /></span>    


                                                                <?php
                                                            }
                                                        } else {
                                                            if ($schedule['EndDate']->sec >= time() && $schedule['IsCancelSchedule'] == 0) {
                                                                ?>
                                                                <span id="cancelscheduleid_<?php echo $schedule['_id'] ?>" style="padding-left: 10px" data-streamId="<?php echo $data->_id ?>"  data-postId="<?php echo $data->PostId ?>" data-categoryType="<?php echo $data->CategoryType ?>" data-scheduleId="<?php echo $schedule['_id'] ?>"  class="deleteicon  cancelschedule"><img src="/images/system/spacer.png" /></span>     


                                                                <?php
                                                            }
                                                        }
                                                        ?></span>  <?php
                                                }
                                            }
                                            ?>
                            
                      
                    </div>
                   
                </div>
        <?php }?> 
            
        <div class="stream_content" style="padding-bottom:0">
            
                     <div  class="media">
                           
 <div class="media-status">
     <ul>
         <li><div class="statusminibox GW_questions" id="GW_questions_<?php echo $data->PostId; ?>" data-mode="<?php echo $data->GameStatus?>" data-gameName="<?php echo $data->GameName; ?>" data-gameId="<?php echo $data->PostId; ?>" data-gameScheduleId="<?php  echo $data->CurrentGameScheduleId; ?>" data-isAdmin="<?php echo Yii::app()->session['IsAdmin']?>">
                 <div class="statustitle"># <?php echo Yii::t('translation','Questions'); ?></div>
                 <div class="statuscount"><?php  echo $data->QuestionsCount?></div>
             </div></li>
         <li><div class="statusminibox">
                 <div class="statustitle"># <?php echo Yii::t('translation','Players'); ?></div>
                 <div class="statuscount"><?php  echo $data->PlayersCount?></div>
             </div></li>
         <li><div class="statusminibox aligncenter">
                     <div class="padding-top35">
                <div class="gamebutton" id="gameWallButton" data-id="<?php echo $data->_id?>" >
             
            <?php
            
            
            if($data->GameStatus=="play"){
                $class = "btn btnplay";
                $label = Yii::t('translation','Play_Now')." <i class='fa fa-chevron-circle-right'></i>";
            }
            else if($data->GameStatus=="resume"){
                 $class = "btn btnresume";
                  $label = Yii::t('translation','Resume')." <i class='fa fa-chevron-circle-right'></i>";
            }
            else if($data->GameStatus=="view"){
               $class = "btn btnviewanswers";
                $label = Yii::t('translation','View')." <i class='fa fa-chevron-circle-right'></i>";
            }
                ?>
                    <?php if($data->GameStatus!="future" && $data->IsNotifiable==1){?>
              <button type="button" class="<?php echo $class?> " id="gameBtnWall_<?php echo $data->_id?>" data-mode="<?php echo $data->GameStatus?>" data-gameName="<?php echo $data->GameName; ?>" data-gameId="<?php echo $data->PostId; ?>" data-gameScheduleId="<?php  echo $data->CurrentGameScheduleId; ?>"><?php echo $label?> </button>
                    <?php }?>
          </div>
                     
                     
                     </div></li>
     </ul></div>
 </div>
                        
                          <div class="social_bar g_social_bar" style="border-bottom:0"  data-id="<?php  echo $data->_id ?>" data-postid="<?php  echo $data->PostId ?>" data-postType="<?php  echo $data->PostType;?>" data-categoryType="<?php  echo $data->CategoryType;?>" data-networkId="<?php  echo $data->NetworkId; ?>">
                 <?php if($data->IsNotifiable==1 && $data->IsDeleted == 0){?>             
                <a class="follow_a"><i><img class="tooltiplink <?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $data->PostFollowers)?'follow':'unfollow' ?>" src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php  echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $data->PostFollowers)?Yii::t('translation','UnFollow'):Yii::t('translation','Follow') ?>"></i><b class="streamFollowUnFollowCount"  data-actiontype='Followers' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo count($data->PostFollowers)?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="followCount_<?php echo $data->PostId; ?>"><?php echo count($data->PostFollowers) ?></span>
                                <?php //if(count($data->PostFollowers)>0){?>
                            <div  class="userView" id="userFollowView_<?php  echo $data->PostId; ?>"  data-postId='<?php echo $data->PostId?>' style="display:none">
                         <?php 
                                 foreach ($data->followUsersArray as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if(count($data->PostFollowers)>10){
                                         echo "<div data-actiontype='Followers' data-postid='$data->PostId' data-id='$data->_id' class='moreUsers'>more...</div>" ;
                                      } 
                                 ?>
                         </div>
                            <?php // } ?>      
                                  </b></a>
             <?php  if($data->IsUseForDigest == 1){ //IsUseForDigest -- this is used for enable notifications ?>
              <a><i><img data-original-title="<?php echo Yii::t('translation','Invite'); ?>" rel="tooltip" data-placement="bottom" class=" tooltiplink cursor invite_frds" src="/images/system/spacer.png"></i></a>
              <span class="cursor"><i><img  class=" tooltiplink cursor <?php  echo $data->IsLoved?'likes':'unlikes' ?>"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>" src="/images/system/spacer.png"></i><b class="streamLoveCount"  data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->LoveCount?>" data-actiontype='Love' data-categoryId="<?php  echo $data->CategoryType;?>"><span id="streamLoveCount_<?php  echo $data->PostId; ?>"><?php  echo $data->LoveCount?></span>
                   
                    <?php include Yii::app()->basePath.'/views/common/userLoveActionView.php'; ?>
                   </b></span>
               
             <span><i ><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class=" cursor tooltiplink  <?php  if($data->PostType!=5){?><?php echo $data->IsCommented?'commented':'comments'?><?php }else{?>comments1 postdetail<?php }?>" <?php  if($data->PostType ==5){?> data-id="<?php echo $data->_id;?>" data-postid="<?php  echo $data->PostId ?>" data-postType="<?php  echo $data->PostType;?>" data-categoryType="<?php  echo $data->CategoryType;?>" <?php } ?> ></i><b id="commentCount_<?php  echo $data->PostId; ?>" ><?php  echo $data->CommentCount?></b></span>
                 <?php } ?>
               <?php }?> 
             <?php if ($data->IsDeleted == 0 && Yii::app()->session['IsAdmin']==1) { ?>             
             <div class="gamefloatingmenu1 pull-right " >
                   <ul class="PostManagementActionsFooter" data-streamId="<?php echo $data->_id ?>"  data-postId="<?php echo $data->PostId ?>" data-categoryType="<?php echo $data->CategoryType ?>" data-networkId="<?php echo $data->NetworkId ?>">
                      <?php if($data->IsNotifiable==1 &&  $data->IsDeleted == 0   ){?> 
                          
                          <?php  if($data->CanFeaturePost==1 && $data->IsFeatured==0){?>
                       <li><span id="featuredicon_<?php  echo $data->_id ?>" rel="tooltip"  data-placement="bottom" data-original-title="<?php echo Yii::t('translation','Mark_As_Featured'); ?>" style="cursor: pointer"  class="featuredicon cursor"><img  class="tooltiplink" src="/images/system/spacer.png" /></span></li> 
                            <?php  }?>
                           <?php if ($data->CanPromotePost == 1) { ?><li><span style="cursor: pointer" class="promoteicon  cursor" ><img class="tooltiplink" rel="tooltip" data-placement="bottom"   data-original-title="<?php echo Yii::t('translation','Promote'); ?>" src="/images/system/spacer.png" /></span></li>
                               <?php } ?>
                            <?php } ?>               
                     <?php  if($data->CanScheduleGame==1){?>
                                <li id="openSchedule_<?php  echo $data->PostId ?>" class="openSchedule" data-postid="<?php  echo $data->PostId ?>"  data-streamId="<?php  echo $data->_id ?>" class="gamerightlist active"> 
                                    <a class="scheduleC_icon"  ><img id="schedule" class=" tooltiplink cursor" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','ScheduleGame'); ?>" src="/images/system/spacer.png" /></a>
                                </li>   
                            <?php } ?> 
                                  </ul>   </div>
                       
                        </div>
             <?php }?>     
                        
                      
                          <!--this is for schedule -->
                   
              <!--End of Schedule-->
        </div>
            <?php  if($data->IsUseForDigest == 1){ //IsUseForDigest -- this is used for enable notifications ?>
                      <div class="commentbox" id="cId_<?php  echo $data->_id; ?>"  style="display:<?php  echo ($data->CommentCount==0 || $data->RecentActivity=="Invite") ?'none':'block';?>">
            <div id="commentSpinLoader_<?php  echo $data->_id; ?>"></div>
           
           <?php  $comments=$data->Comments;
        $commentCount=sizeof($comments);
        ?>
           <div class="myClass" id="CommentBoxScrollPane_<?php echo $data->_id;?>"  >
    <div   id="commentbox_<?php  echo $data->_id ?>" style="display:<?php  echo $data->CommentCount>0?'block':'none';?>">
      <div id="commentsAppend_<?php  echo $data->_id; ?>"></div>
        <?php 
         $style="display:none";
        if(sizeof($data->Comments)>0){
         
            if(sizeof($data->Comments)>2){
                 $style="display:block";
            }
         $maxDisplaySize = sizeof($data->Comments)>2?2:sizeof($data->Comments);
  
            for($j=sizeof($data->Comments);$j>sizeof($data->Comments)-$maxDisplaySize;$j--){ 
             
                
                $comment=$data->Comments[$j-1];
                ?>
          <div class="commentsection" id="comment_<?php echo $comment['CommentId']; ?>" style="position: relative">
              <div id="commentSpinLoader_<?php  echo $comment['CommentId']; ?>"></div>
              <div class="row-fluid commenteddiv"  id="comment_<?php echo $comment['CommentId']; ?>" >
          <div class="span12">
              <?php 
                    $commentId = $comment['CommentId'];
                    $streamId = $data->_id;
                    $postId = $data->PostId;
                    $categoryType = $data->CategoryType;
                    $networkId = $data->NetworkId;
                    $commentDisplayPage = "gameScedule";
                    include Yii::app()->basePath . '/views/includes/comment_management_actions.php'; 
               ?>
                 <div class=" stream_content">
                <ul>
                    <li class="media">
              <?php  if($comment["NoOfArtifacts"]>0){
                  $commentID = $comment['CommentId'];
                  $extension = "";
                   $extension = strtolower($comment['Artifacts']["Extension"]);
                            $videoclassName="";
                             if($extension == 'mp4' || $extension == 'flv' || $extension == 'mov') {
                                      $videoclassName = 'videoThumnailDisplay';
                                    
                                }else {
                                    $videoclassName='videoThumnailNotDisplay';
                                }
                  
                  
              
              ?>
             
                        <?php  if($comment['NoOfArtifacts']==1){$commentID = $comment['CommentId'];
                            foreach($commentID as $id){
                                $commentID = $id;
                            }
                            ?>
                        <?php
                                $className = ""; 
                                $uri = "";
                                $extension = "";
                                $imageVideomp3Id = "";
                                $extension = strtolower($comment['Artifacts']["Extension"]);
                                if($extension == "mp4" || $extension == "avi" || $extension == "flv" || $extension == "mov" || $extension == "mp3" ){ 
                                    $className = "videoimage";
                                    $uri = $comment['Artifacts']["Uri"];
                                    $imageVideomp3Id = "imageVideomp3_$commentID";
                                }else{
                                    $className = "postdetail";                                
                                }
                                if($extension == 'mp4' || $extension == 'flv' || $extension == 'mov') {
                                      $videoclassName = 'videoThumnailDisplay';
                                    
                                }else {
                                    $videoclassName='videoThumnailNotDisplay';
                                }
                            ?>
                            <?php if(!empty($imageVideomp3Id)){ ?>
                            <div id="playerClose_<?php echo $commentID; ?>"  style="display: none;">
                                <div class="videoclosediv alignright"><button aria-hidden="true"  data-dismiss="modal" onclick="closeVideo('<?php echo $commentID; ?>');" class="videoclose" type="button">×</button></div>
                                <div class="clearboth"><div id="streamVideoDiv<?php echo $commentID; ?>"></div></div>
                            </div>
                            <?php } ?>  
                                <a id="imgsingle_<?php echo $commentID; ?>" class="pull-left img_single <?php echo $className; ?>" data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId;?>" data-categoryType="<?php echo $data->CategoryType;?>" data-postType="<?php echo $data->PostType;?>" data-videoimage="<?php echo $uri; ?>"><div id='img_streamVideoDiv<?php echo $commentID; ?>' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php  echo $comment["ArtifactIcon"] ?>" <?php if(!empty($imageVideomp3Id)){ echo "id=$imageVideomp3Id"; }?>  ></a>
                        <?php  }else{ ?>
                                
                                <div class="pull-left multiple "> 
                                    <div class="img_more1"></div>
                                    <div class="img_more2"></div>
                                    <a class="pull-left pull-left1 img_more  postdetail" data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>"><div id='img_streamVideoDiv<?php echo $commentID; ?>' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php echo $comment["ArtifactIcon"] ?>"></a>
                                </div>                                                
                          
                        <?php  } ?>
                             <?php   } ?> 
                            
                        <div class="media-body" >
                            <div class="bulletsShow" id="post_content_total_<?php echo $comment['CommentId']; ?>" style="display:none">

                            <?php  
                                  echo $comment["CommentFullText"];
                             ?>
                                </div>
                            <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>" data-id="<?php echo $data->_id;?>" id="post_content_<?php echo $comment['CommentId']; ?>" data-categoryType="<?php echo $data->CategoryType;?>">

                            <?php  
                                  echo $comment["CommentText"];
                             ?>
                                </div>
                            <?php 
                                $translate_fromLanguage = $comment["Language"];
                                $translate_class = "commenttranslatebutton";
                                $translate_id = $comment['CommentId'];
                                $translate_postId = $data->PostId;
                                $translate_postType = $data->PostType;
                                $translate_categoryType = $data->CategoryType;
                                include Yii::app()->basePath . '/views/common/translateButton.php';
                            ?>
                             <!-- Nested media object -->
                            <div class="media">
                                <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                                    <a   class="skiptaiconinner ">
                                        <img src="<?php  echo $comment['ProfilePicture'] ?>">

                                    </a>
                                </div>
                               
                                <div class="media-body">
                                    <span class="m_day"><?php  echo $comment["CreatedOn"]; ?></span>
                                    <div class="m_title"><a class="" data-streamId="<?php echo $data->_id;?>" data-id="<?php  echo $comment['UserId'] ?>"  style="cursor:pointer"><?php  echo $comment["DisplayName"] ?></a></div>
                                </div>
                            </div>
                        </div>
                                           <?php if(isset($comment['WebUrls']['Weburl'])){?>
               <?php if(isset($comment["IsWebSnippetExist"]) && $comment["IsWebSnippetExist"]=='1'){     ?>           

                <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;clear:both;">
                                 <div class="Snippet_div" style="position: relative">

                                        <a href="<?php echo $comment['WebUrls']['Weburl']; ?>" target="_blank">
                                            <?php if($comment['WebUrls']['WebImage']!=""){ ?>
                            <span  class=" pull-left img_single e_img" style="width:100px;" ><img src="<?php echo $comment['WebUrls']['WebImage']; ?>"></span>
                                            <?php } ?>
                            <div class="media-body">  </a>                                 
                                                    

                                                        <label class="websnipheading" ><?php echo $comment['WebUrls']['WebTitle']; ?></label>
                                                        <a   class="websniplink" href="<?php echo $comment['WebUrls']['Weburl']; ?>" target="_blank"> <?php echo $comment['WebUrls']['WebLink']; ?></a>
                                                        <p><?php echo $comment['WebUrls']['Webdescription']; ?></p>
                                                    
                                                </div>
                                       
                                    </div>
                           </div>
                      
    <?php } } ?>
                           </li>
                </ul>
            </div>
         
              
          
          </div>
          </div>
  
                </div>
            <?php  } ?>
     
        <?php  }else{
                 $style="display:none";
        } 
        if($data->CommentCount >2 && sizeof($data->Comments)==2){
             $style="display:block";
        }else if($data->CommentCount > sizeof($data->Comments)){
             $style="display:block";
        }
        
        ?>
   
        </div> 
               <script type="text/javascript">
            $(function(){
                var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
                initializeFileUploader("postupload_<?php  echo $data->_id?>", '/post/upload', '10*1024*1024', extensions,4, 'commentTextArea','<?php  echo $data->_id?>',previewImage,appendErrorMessages,"uploadlist_<?php  echo $data->_id?>");
            });
            
         </script>
    </div>
           <div class="viewmorecomments alignright">
                <span  id="viewmorecomments_<?php  echo $data->_id; ?>" style="<?php echo $style; ?>" onclick="viewmoreComments('/post/postComments','<?php  echo $data->PostId ?>','<?php  echo $data->_id ?>','<?php echo $data->CategoryType; ?>');">More Comments</span>
              </div>

             <div id="ArtifactSpinLoader_postupload_<?php  echo $data->_id?>"></div>
           <div id="newComment_<?php echo $data->_id; ?>" style="display:none" class="paddinglrtp5">
                       <div id="commentTextArea_<?php echo $data->_id; ?>" class="inputor commentplaceholder" contentEditable="true" onkeyup="getsnipetForComment(event,this,'<?php echo $data->_id; ?>');" onclick="OpenCommentbuttonArea('<?php echo $data->_id; ?>','<?php echo $data->CategoryType; ?>')" data-categorytype="<?php echo $data->CategoryType; ?>"></div>
                       <div id="commentTextAreaError_<?php echo $data->_id; ?>" style="display: none;"></div>
                       <div class="alert alert-error" id="commentTextArea_<?php echo $data->_id; ?>_Artifacts_em_" style="display: none;"></div>
                       <input type="hidden" id="artifacts_<?php echo $data->_id; ?>" value=""/>
                       <div id="preview_commentTextArea_<?php echo $data->_id; ?>" class="preview" style="display:none">
                           <ul id="previewul_commentTextArea_<?php echo $data->_id; ?>" class="imgpreview">

                           </ul>


                       </div>
                <div  id="snippet_main_<?php echo $data->_id; ?>" class="snippetdiv" style="" ></div> 
                       <div class="postattachmentarea" id="commentartifactsarea_<?php echo $data->_id; ?>" style="display:none;">
                         
                           <div class="pull-left whitespace">
                               <div class="advance_enhancement">
                                   <ul>
                                       <li class="dropdown pull-left ">
                                           <div id="postupload_<?php echo $data->_id ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Upload'); ?>">
                                           </div>

                                       </li>


                                   </ul>
                                   
                                   <a ></a> <a ><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
                           </div>
                          
                           <div class="pull-right">

                               <button id="savePostCommentButton_<?php echo $data->_id; ?>" onclick="savePostCommentByUserId('<?php echo $data->PostId; ?>','<?php echo $data->PostType; ?>','<?php echo $data->CategoryType; ?>','<?php echo $data->NetworkId; ?>','<?php echo $data->_id; ?>');" class="btn" data-loading-text="Loading..."><?php echo Yii::t('translation','Comment'); ?></button>
                               <button id="cancelPostCommentButton_<?php echo $data->_id; ?>" onclick="cancelPostCommentByUserId('<?php echo $data->_id; ?>','<?php echo $data->CategoryType; ?>')" class="btn btn_gray"> <?php echo Yii::t('translation','Cancel'); ?></button>

                           </div>
                           <div id="commenterror_<?php echo $data->PostId; ?>" class="alert alert-error displayn" style="margin-left: 30px;margin-right: 157px;"></div>

                       </div>
                       <div ><ul class="qq-upload-list" id="uploadlist_<?php echo $data->_id ?>"></ul></div>
                   </div>
        </div>   
         <?php } ?>
         </div>   </div>       
    
</li>
  </div>
        <script type="text/javascript">
            
            if(g_postIds == ""){
                g_postIds = '<?php echo $data->PostId; ?>';
            }else{
                g_postIds = g_postIds+","+'<?php echo $data->PostId; ?>';
            }
            function setCommentArrowPoition(){
            if($('#commentCount_<?php  echo $data->PostId; ?>').length>0){
            var commentArrowLeft = $('#commentCount_<?php  echo $data->PostId; ?>').prev().find('img').position().left;
           //alert(commentArrowLeft)
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:before{left:134px}</style>');
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:after{left:134px}</style>');
        }
        }
        setTimeout(setCommentArrowPoition,50);
        </script>
<?php  }
     } catch (Exception $exc) {     
         error_log("-------------message--------------------".$exc->getMessage());
     }

     
      }else{          
          echo $stream;
      ?>
          
    <?php  }
      ?>
