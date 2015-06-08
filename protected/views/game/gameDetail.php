<?php if($gameDetails->IsDeleted==0 || Yii::app()->session['IsAdmin'] == 1) {?>
<?php include 'miniProfileScript.php'; ?>
<?php include 'hashTagProfileScript.php'; ?>
<?php include 'commentscript.php'; ?>
<?php include 'detailedcommentscript.php'; ?>
<?php include 'commentscript_instant.php'; ?>
<?php include 'inviteScript.php'; ?>
<?php include 'snippetDetails.php'?>
<?php $count = 0;
if(!empty($gameDetails->_id)){
?>
<h2 class="pagetitle" ><?php echo Yii::t('translation','Games'); ?></h2>
 <div id="gameDetailSpinLoader"></div>
<div  class="paddingtop6" >
<div id="GameBanner" class="collapse in">
  <div  class="groupbanner positionrelative " > 
      <div class="gamebannerTitle">
          <div class="padding20">
          
          
          <div <?php if($gameDetails->IsDeleted==1) echo "style=display:none"?> class="gamebutton">
              
            <?php 
            
            if($mode == "play" && $gameBean->gameStatus=="play"){
               $class = "btn btnplay btndisable";
              // $label = "Playing";  
            }
             if($mode == "resume" && $gameBean->gameStatus=="resume"){
               $class = "btn btnresume btndisable";
              // $label = "Playing";  
            }
            else
            if($gameBean->gameStatus=="play"){
                $class = "btn btnplay";
                $label = Yii::t('translation','Play_Now')." <i class='fa fa-chevron-circle-right'></i>";
            }
            else if($gameBean->gameStatus=="resume"){
                 $class = "btn btnresume";
                  $label = Yii::t('translation','Resume')." <i class='fa fa-chevron-circle-right'></i>";
            }
           else if($gameBean->gameStatus=="view") {
               $class = "btn btnviewanswers"; 
                $label = Yii::t('translation','View')." <i class='fa fa-chevron-circle-right'></i>";
            }
            if($gameBean->gameStatus=="play" || $gameBean->gameStatus=="resume" || $gameBean->gameStatus=="view"){
               ?>
         <button type="button" class="<?php echo $class?> " id="gameBtn" data-gameId="<?php echo $gameDetails->_id; ?>" data-gameScheduleId="<?php echo $gameBean->gameScheduleId; ?>"><?php echo $label?> </button>
 
           <?php }?>
         <div style="display: none" id="gameDummyBtn" data-gameId="<?php echo $gameDetails->_id; ?>" data-gameScheduleId="<?php echo $gameBean->gameScheduleId; ?>"></div>
         
             
          </div>
          </div>
      </div>
<img style="max-width:100%" src="<?php echo $gameDetails->GameBannerImage?>">
</div>
</div>
    <div id="gameDetailDiv" class="row-fluid">
     <div class="span6">
           <div class="gameNameBold" id="header_gameName_<?php echo $gameDetails->_id ?>"><?php echo $gameDetails->GameName; ?>
           <?php if(isset($gameDetails->IsSponsored) && $gameDetails->IsSponsored == 1){ ?>
               <span  class="brand_box" style="font-weight:normal;"><?php echo $gameDetails->BrandName; ?></span> 
            <?php } ?>
           </div>
     <div class="padding8top">
         
          
     <div id="profile" class="collapse in">
             <div class="" id="gameShortDescription">
                 <div id="groupProfileDiv_spinner"></div>
                 <div id="descriptioToshow" class="e_descriptiontext">
                <?php echo $gameBean->shortDescription; ?>
                 </div>
     </div>
                 <div  style="display:none;padding: 5px" id="gameDetailDescription"><div id="detailDescriptioToshow" class="e_descriptiontext">
              <?php echo $gameDetails->GameDescription; ?>
             </div>
     
     </div>
          <div class="alignright clearboth" id="game_descriptionMore" style="display:<?php echo strlen($gameDetails->GameDescription)>240?'block':'none'; ?>"> <a id="more" class="more">more <i class="fa fa-chevron-circle-right"></i></a></div>
     <div class="alignright clearboth" > <a style="display:none"  class="moreup" id="moreup">close <i class="fa fa-chevron-circle-up"></i></a></div>
     </div>
    <?php 
        $translate_fromLanguage = $gameDetails->Language;
        $translate_class = "translatebutton";
        $translate_id = $gameDetails->_id;
        $translate_postId = $gameDetails->_id;
        $translate_postType = $gameDetails->Type;
        $translate_categoryType = $gameBean->CategoryType;
        $translate_location = 'header';
        include Yii::app()->basePath . '/views/common/translateButton.php'; 
    ?>
         <!-- comment -->
         <?php $data = $gameDetails; $categoryType=9;?>
         
     </div>
     </div>
          <div class="span6 ">
          <div id="gamemenu" class="collapse in">
              <div class="grouphomemenuhelp alignright"></div>
         <div class="grouphomemenu">
             
     <ul>
     <li class="normal">
         <div class="menubox leadingindividuals">
             <div class="menuboxpopupHeader"><?php echo Yii::t('translation','Leading_Individuals'); ?></div>
     
     <div class="media">
                                
                               
         <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner " style="cursor:pointer" id="gameprofileimage" data-name="<?php echo $gameBean->uniqueHandle; ?>" >
                       <img  src="<?php if(isset($gameBean->highestScoreUserPicture)) echo $gameBean->highestScoreUserPicture; else{echo '/upload/profile/user_noimage.png';}?>">
                  
                  </a>
                     </div> 
                                <div class="media-body">                                   
                                    
                                    <div class="m_title"><a style="cursor:pointer" data-id="<?php echo $gameBean->highestGameUserId; ?>" class="userprofilename" data-streamId="<?php  echo $data->_id; ?>" data-name="<?php echo $gameBean->uniqueHandle; ?>"><?php echo $gameBean->highestScoreUserName; ?></a></div>
                                    <div class="m_day"><?php echo $gameDetails->GameHighestScore; ?> <span>points</span></div>
                                </div>
                             </div>
     
     </div>
     
     </li>
         
       
     
     <li class="normal"  onclick="<?php if (Yii::app()->session['IsAdmin'] == 1) echo 'showQuestion()'?>">
     <div class="menubox">
         <div class="menuboxpopup"><span>#<?php echo Yii::t('translation','Questions'); ?></span></div>
     <div id="GroupPostCount" class="groupmenucount"><?php echo $gameDetails->QuestionsCount; ?></div>
     <div class="conversationmenu questionsmenu"><img src="/images/system/spacer.png"></div>

     </div>

     </li>
       <li class="normal" >
     <div class="menubox">
         <div class="menuboxpopup"><span>#<?php echo Yii::t('translation','Players'); ?></span></div>
     <div id="gamePlayersCount" class="groupmenucount"><?php if($gameDetails->PlayersCount!=null) echo $gameDetails->PlayersCount;else echo 0; ?></div>
     <div class="conversationmenu playersmenu"><img src="/images/system/spacer.png"></div>

     </div>

     </li>
     </ul>
     </div>
          </div>
              
<!--          <div class="alignright padding8top ">
          <button type="button" class="btn btn_gray btn_toggle" data-toggle="collapse" data-target="#profile, #gamemenu, #Hide, #Show, #GameBanner">
              <span id="Hide" class="collapse in"> Hide <i class="fa fa-caret-up"></i></span>
   <span id="Show" class="collapse ">Show <i class="fa fa-caret-down"></i></span>
</button>
</div>-->
          </div>
     
     </div>
    <div id="gameSocailActions" style="<?php if(!isset($gameBean->gameStatus)) echo "display:none"?>">
     <div <?php if($gameDetails->IsDeleted==1) echo "style=display:none"?> class="social_bar g_social_bar detailpage" data-id="<?php echo $gameDetails->_id; ?>" data-postid="<?php echo $gameDetails->_id; ?>" data-postType="<?php  echo $gameDetails->Type;?>" data-categoryType="<?php  echo $gameBean->CategoryType;?>" data-networkId="<?php  echo $gameDetails->NetworkId;?>">
         <a class="follow_a"><i><img class="tooltiplink <?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $gameDetails->Followers)?'follow':'unfollow' ?>" src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php  echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $gameDetails->Followers)?Yii::t('translation','UnFollow'):Yii::t('translation','Follow') ?>"></i><b class="dFollowers"  data-categoryId="<?php  echo $gameBean->CategoryType;?>" data-actiontype='Followers' data-id='<?php echo $gameDetails->_id?>' data-count="<?php echo count($gameDetails->Followers)?>"><span id="streamFollowUnFollowCount_<?php  echo $gameDetails->_id; ?>"><?php echo count($gameDetails->Followers) ?></span>
                    
                            <div class="userView userFollowView" id="userFollowView_<?php  echo $gameDetails->_id; ?>"  data-postId='<?php echo $gameDetails->_id?>' style="display:none" data-count="<?php echo count($gameDetails->Followers)?>">
                         <?php 
                                 foreach ($lovefollowArray["followUsersArray"] as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if(count($gameDetails->Followers)>10){
                                         echo "<div data-actiontype='Followers' data-postid='$gameDetails->_id' data-id='$gameDetails->_id' data-categoryId='$gameBean->CategoryType' class='detailMoreUsers'>more...</div>" ;
                                      } 
                                 ?>
                         </div>
                           
             </b></a>
<?php if($gameDetails->IsEnableSocialActions == 1){ ?>
 <a><i><img data-original-title="<?php echo Yii::t('translation','Invite'); ?>" rel="tooltip" data-placement="bottom" class=" tooltiplink cursor invite_frds" src="/images/system/spacer.png"></i></a>
 <span class="cursor"><i><img  class=" tooltiplink cursor <?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $gameDetails->Love)?'likes':'unlikes' ?>"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>" src="/images/system/spacer.png"></i><b class="dLoves"  data-actiontype='Love' data-id='<?php echo $gameDetails->_id?>' data-categoryId="<?php  echo $gameBean->CategoryType;?>" data-count="<?php echo count($gameDetails->Love)?>" ><span id="streamLoveCount_<?php  echo $gameDetails->_id; ?>"><?php  echo count($gameDetails->Love)?></span>
    
                <div  class="userLoveView" id="userLoveView_<?php  echo $gameDetails->_id; ?>" data-postId='<?php echo $gameDetails->_id?>' data-count="<?php echo count($gameDetails->Love)?>" >
                         <?php 
                                 foreach ($lovefollowArray["loveUsersArray"] as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if(count($gameDetails->Love)>10){
                                         echo "<div data-actiontype='Love' data-categoryId='$categoryType' data-postid='$gameDetails->_id' data-id='$gameDetails->_id' data-categoryId='$gameBean->CategoryType' class='detailMoreUsers'>more...</div>" ;
                                      } 
                                 ?>
                         </div>
                
     </b></span>
  
 <?php   if(!$gameDetails->DisableComments){
                
                if(count($gameDetails->Comments)>0){
                    foreach ($gameDetails->Comments as $key=>$value) {
                        $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
                        $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
                        if(!$IsBlockedWordExist && !$IsAbused){
                            $count++;
                        }
                    }
                }
      ?>
         <span><i ><img id="detailedComment" src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class=" cursor tooltiplink  <?php  if($gameDetails->Type!=5){?><?php echo $gameBean->isCommented?'commented':'comments'?><?php }else{?>comments1 postdetail<?php }?>" <?php  if($gameDetails->Type ==5){?> data-id="<?php echo $gameDetails->_id;?>" data-postid="<?php  echo $gameDetails->_id ?>" data-postType="<?php  echo $gameDetails->Type;?>" data-categoryType="<?php $gameBean->CategoryType?>" <?php } ?> ></i><b id="det_commentCount_<?php  echo $gameDetails->_id; ?>"><?php  echo $count; ?></b></span>
                
                  <?php  }?>

           
             
        </div>
    <div class="commentbox <?php  if($data->Type==5){?>commentbox2<?php  }?> " id="cId_<?php   echo $data->_id; ?>" >
              <div id="commentSpinLoader_<?php  echo $data->_id; ?>"></div>
            
              <div id="ArtifactSpinLoader_postupload_<?php echo $data->_id ?>"></div>
                  <div <?php if($gameDetails->IsDeleted==1) echo "style=display:none"?> id="newComment"  class="paddinglrtp5">
                      <div id="commentTextArea_<?php echo $data->_id; ?>" class="inputor commentplaceholder" contentEditable="true" onkeyup="getsnipetForComment(event,this,'<?php echo $data->_id; ?>');"  onclick="OpenCommentbuttonArea('<?php echo $data->_id; ?>')"></div>
                      <div id="commentTextAreaError_<?php echo $data->_id; ?>" style="display: none;"></div>
                      <div class="alert alert-error" id="commentTextArea_<?php echo $data->_id; ?>_Artifacts_em_" style="display: none;"></div>
                      <input type="hidden" id="artifacts" value=""/>
                      <div id="preview_commentTextArea_<?php echo $data->_id; ?>" class="preview" style="display:none">
                          <ul id="previewul_commentTextArea_<?php echo $data->_id; ?>" class="imgpreview">

                          </ul>


                      </div>
                      <div  id="snippet_main_<?php echo $data->_id; ?>" class="snippetdiv" style="" ></div>        
                      <div class="postattachmentarea" id="commentartifactsarea_<?php echo $data->_id; ?>" style="display:none">
                          <div class="pull-left whitespace">
                              <div class="advance_enhancement">
                                  <ul>
                                      <li class="dropdown pull-left ">
                                          <div id="postupload_<?php echo $data->_id; ?>">
                                          </div>

                                      </li>


                                  </ul>

                                  <a href="#" ></a> <a href="#" ><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
                          </div>
                          <div class="pull-right">

                              <button id="savePostCommentButton" onclick="saveDetailedPostCommentByUserId('<?php echo $data->_id; ?>','<?php echo $data->Type; ?>','<?php echo $categoryType; ?>','1','<?php echo $data->_id; ?>','postDetailed');" class="btn" data-loading-text="Loading..."><?php echo Yii::t('translation','Comment'); ?></button>
                              <button id="cancelPostCommentButton" data-postid="<?php echo $data->_id ?>"  class="btn btn_gray"> <?php echo Yii::t('translation','Cancel'); ?></button>

                          </div></div>
                      <div ><ul class="qq-upload-list" id="uploadlist_<?php echo $data->_id ?>"></ul></div>
                      <div style="display:<?php echo count($data->Comments) > 0 ? 'block' : 'none'; ?>" class="postattachmentareaWithComments"> <img src="/images/system/spacer.png" />
                      </div>
                  </div>

              <div  id="CommentBoxScrollPaneTest" >
              <div id="commentbox_<?php echo $data->_id; ?>" style="display:<?php   echo count($data->Comments)>0?'block':'none';?>">
      <div id="commentsAppend_<?php   echo $data->_id; ?>"></div>
              <?php  if(count($data->Comments)>0){ $commentsCnt = 0;?>
              
 <?php  foreach ($commentsdata as $key => $value) {
    ?>

    <div class="commentsection" id="comment_<?php  echo $value->PostId ?>_<?php  echo $value->CommentId ?>">
          <div class="row-fluid commenteddiv">
          <div class="span12">
              <?php $commentId = $value->CommentId;
                    $streamId = $gameDetails->_id;
                    $postId = $value->PostId;
                    $categoryType = $categoryType;
                    $networkId = $gameDetails->NetworkId;
                    include Yii::app()->basePath . '/views/includes/comment_management_actions.php'; 
                ?>
                 <div class=" stream_content">
                <ul>
                    <li class="media overfolw-inherit">

                       <?php   if(count($value->Resource) >0){?>
                        
                        <?php 
                         
                          $ResourceArray=array();
                          $ResourceUriArray=array();
                          $ResourceDetails=array();
                         foreach($value->Resource as $key => $res){
                             
                             if (isset($res['Extension'])) {
                                 $ext = strtolower($res['Extension']);

                                 if (isset($res['ThumbNailImage'])) {
                                     $image = $res['ThumbNailImage'];
                                 } else {
                                     $image = "";
                                 }
                                 
                             
                                if ($ext == "mp3") {

                                    $ResourceArray[$key] = "/images/system/audio_img.png";
                                     $ResourceUriArray[$key]=$res['Uri'];
                                } else if ($ext == "mp4" || $ext == 'flv' || $ext == 'mov') {

                                    $ResourceArray[$key] = $image;
                                     $ResourceUriArray[$key]=$res['Uri'];
                                } else if ($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif") {
                                    $ResourceArray[$key] = $res['Uri'];
                                     $ResourceUriArray[$key]=str_replace('/upload/public/thumbnails/','/upload/public/images/',$res['Uri']);
                                } else if ($ext == "pdf" || $ext == "txt" || $ext == 'doc' || $ext == 'xls' || $ext == "ppt" || $ext == 'docx' || $ext == 'xlsx') {
                                    $ResourceArray[$key] = $image;
                                     $ResourceUriArray[$key]=$res['Uri'];
                                } else {
                                    $ResourceArray[$key] = $image;
                                     $ResourceUriArray[$key]=$res['Uri'];
                                }
                               
                         }
                         }

                         ?>
                    
      <div class="padding5">  
        <div class="pull-left multiple "> 
            <?php   if (sizeof($value->Resource) > 1) { ?>
            <div class="img_more1"></div>
            <div class="img_more2"></div>
            <?php } ?>
            <a  class="pull-left pull-left1 img_more ">
              <?php                     
 
     if(isset($value->Resource[0]['Extension'])){
                $ext = strtolower($value->Resource[0]['Extension']);

                if(isset($res['ThumbNailImage'])){
                       $image=$value->Resource[0]['ThumbNailImage'];
                   }else{
                       $image="";
                   }

            if($ext == "mp3"){?>
                        <div class="d_img_outer_video_play_postdetail" >

                        <img style="cursor:pointer;" src="/images/system/audio_img.png" data-src="<?php echo implode(',', $ResourceArray); ?>" data-srcuri="<?php echo implode(',', $ResourceUriArray); ?>" data-uri="<?php  echo $value->Resource[0]['Uri'];?>" data-format="<?php  echo $ext;?>" id="videodivid" />
                    </div>
              <?php  }else if($ext == "mp4" || $ext == 'flv' || $ext == 'mov'){
                $videoclassName = 'PostdetailvideoThumnailDisplay';

                  ?>
                        <div class="d_img_outer_video_play_postdetail" style="cursor:pointer;" ><div  class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div>

                        <img style="cursor:pointer;"  data-src="<?php echo implode(',', $ResourceArray); ?>" data-srcuri="<?php echo implode(',', $ResourceUriArray); ?>" src='<?php echo $image; ?>' data-uri="<?php  echo $value->Resource[0]['Uri'];?>" data-format="<?php  echo $ext;?>" id="videodivid"/>
                    </div>
                  
                <?php  }else  if($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif"){?>
                  
                        <div class="d_img_outer_video_play_postdetail" >
                                      <img style="cursor:pointer;" src="<?php  echo $value->Resource[0]['Uri'];?>" data-src="<?php echo implode(',', $ResourceArray); ?>" data-srcuri="<?php echo implode(',', $ResourceUriArray); ?>" data-uri="<?php echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$value->Resource[0]['Uri']);?>" id="imageimgdivid" data-format="<?php  echo $ext;?>" class="imageimgdivid"/>
                        </div>
                   
            <?php  }else  if($ext == "pdf" || $ext == "txt" || $ext=='doc' || $ext=='xls' || $ext == "ppt" || $ext=='docx' || $ext=='xlsx'){                   
            ?>
                    
                        <div class="d_img_outer_video_play_postdetail" >
                             <img  style="cursor:pointer;" src="<?php echo $image;?>" data-src="<?php echo implode(',', $ResourceArray); ?>" data-srcuri="<?php echo implode(',', $ResourceUriArray); ?>" data-uri="<?php  echo $value->Resource[0]['Uri'];?>" data-format="<?php  echo $ext;?>" id="pdfdivid"/>

                        </div>  
                   
            <?php }else{ ?> 
                   
                        <div class="">
                             <a href="/post/fileopen/?file=<?php  echo $res['Uri'];?>"  id="downloadAE"><img  id="artifactOpen" style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $value->Resource[0]['Uri'];?>" data-format="<?php  echo $ext;?>" id="pdfdivid"/> </a>    

</div>
                <?php  }


                } ?>
  
            </a>
        </div>    
                        
                       
      
                        </div>
                        
                        
                             <?php    } ?> 
                            
                            
                            
                <div class="media-body overfolw-inherit" >
                    <div class="positionrelative padding-right30 streampostactions">
                        <?php if($value->IsBlockedWordExist==1){ ?>
                        <div class="postmg_actions">
                            <i data-placement="right" data-toggle="dropdown" class="fa fa-chevron-down"></i>
                            <i data-placement="right" data-toggle="dropdown" class="fa fa-chevron-up"></i>
                            <div id="CommentBlockOrRemove" class="dropdown-menu ">
                                <ul class="PostManagementActions abusedPosts" data-postId="<?php echo $value->PostId ?>" data-commentId="<?php echo $value->CommentId ?>" data-categoryType="<?php echo $value->CateogryType ?>" data-networkId="<?php echo $NetworkId ?>">
                                    <li><a name="Block" class="Block"><span class="blockicon"><img src="/images/system/spacer.png"></span> Block</a></li>
                                    <li><a name="Release" class="Release"><span class="releaseicon"><img src="/images/system/spacer.png"></span> Release</a></li>
                                </ul>

                            </div>
                        </div>
                        <?php } ?>
                        <div id="comment_text" data-id="<?php  echo $data->_id; ?>"><?php echo $value->CommentText; ?></div>

                        <div class="media">
                            <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <img   src="<?php echo $value->ProfilePic; ?> "> 
                  
                  </a>
                     </div>
                            
                            <div class="media-body">
                                <span class="m_day"><?php echo $value->PostOn; ?></span>
                                <div class="m_title"> <a class="userprofilename"  data-id="<?php echo $value->UserId; ?>" data-streamId="<?php  echo $data->_id; ?>" data-name="<?php echo $value->DisplayName; ?>" style="cursor:pointer"><?php echo $value->DisplayName; ?></a></div>
                            </div>
                        </div>
                        <?php if(isset($value->IsWebSnippetExist)&& $value->IsWebSnippetExist=='1'){     ?>           

                <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;">
                                 <div class="Snippet_div" style="position: relative">
                            <?php if(isset($value->snippetdata['Weburl'])&& ($value->snippetdata['Weburl']!="")){ ?>      
                                    <a href="<?php 
                                         echo $value->snippetdata['Weburl']; ?>" target="_blank">
                                            
                                        <?php if($value->snippetdata['WebImage']!=""){ ?>
                                             <span  class=" pull-left img_single e_img" style="width:100px;" ><img src="<?php echo $value->snippetdata['WebImage']; ?>"></span>
                                            <?php } ?>     
                                            <div class="media-body">                                   
                                                           <label class="websnipheading"> <?php echo $value->snippetdata['WebTitle'] ?> </label>
                                                     <a class="websniplink" href="<?php echo $value->snippetdata['Weburl']; ?>" target="_blank"> <?php echo $value->snippetdata['WebLink']; ?></a>
                                                            <p><?php echo $value->snippetdata['Webdescription']; ?></p>
                                                    
                                                </div>
                                        </a>  
                            <?php } ?>
                                   
                                    </div>
                           </div>
                      
              <?php } ?>
                    </div>
                </div>
              </li>
                </ul>
            </div>
              
              
              
                      
               
              
               
              
          
          </div>
          </div>
  
                </div>
<?php } ?>
       
          
          </div>
         
        <?php  } ?>
              </div>
               <?php  if($count >5){ ?>
           <div class="viewmorecomments alignright">
                <span  id="viewmorecommentsDetailed" onclick="viewmoreCommentsIndetailedPage('/post/postComments','<?php   echo $data->_id ?>','<?php   echo $data->_id ?>','Streampost','<?php  echo $categoryType; ?>',5);"><?php echo Yii::t('translation','More_Comments'); ?></span>
              </div>
      <?php   } ?>
                  
          </div>
<?php } ?>
</div>
</div>

    
       
<div id="questions" game-id="<?php echo $gameDetails->_id; ?>" schedule-id="<?php echo $gameBean->gameScheduleId; ?>">
  
</div>
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
    var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
    
     bindEventsForStream('gameSocailActions');
     bindgameEvents();
     <?php if($gameDetails->IsDeleted==0) {?>
     function bindgameEvents(){

        $("#gameDetailDiv input.translatebutton").unbind().bind("click",function(){
            var obj = $(this);
            translateGameData(obj);
        });
        $(".btnplay").unbind().bind("click",function(obj){
            showGame('play',$(this).attr("data-gameid"),$(this).attr("data-gamescheduleid"));
            $("#gameBtn").html("<?php echo Yii::t('translation', 'Play_Now'); ?> <i class='fa fa-chevron-circle-right'></i>");
            $("#gameBtn").attr("class","btn btnplay btndisable");
            $(".btnplay").unbind();
        });
   $("#CommentBoxScrollPaneTest input.commenttranslatebutton").unbind().bind("click",function(){ 
        var obj = $(this);
        translateCommentData(obj);
    }
    );



     $(".btnresume").unbind().bind("click",function(){
        showGame('resume',$(this).attr("data-gameid"),$(this).attr("data-gamescheduleid"));
       // $(this).hide();
        $("#gameBtn").html("<?php echo Yii::t('translation','Resume'); ?> <i class='fa fa-chevron-circle-right'></i>");
        $("#gameBtn").attr("class","btn btnresume btndisable");
        $(".btnresume").unbind();
       
    });
    $(".btnviewanswers").unbind().bind("click",function(){
          $("#gameBtn").html("<?php echo Yii::t('translation','View'); ?> <i class='fa fa-chevron-circle-right'></i>");
        $("#gameBtn").attr("class","btn btnviewanswers btndisable");
        $(".btnviewanswers").unbind();
        showGame('view',$(this).attr("data-gameid"),$(this).attr("data-gamescheduleid"));
    });
     }
     <?php }?>
    function showGame(type,gameId,gameScheduleId){
         scrollPleaseWait("gameDetailSpinLoader","contentDiv");
        var queryString = {type:type,gameId:gameId,gameScheduleId:gameScheduleId};
        ajaxRequest("/game/showGame",queryString,function(data){showGameHandler(data,type)},"html");
    }
    function showGameHandler(data,type){
         scrollPleaseWaitClose("gameDetailSpinLoader");
       $("#questions").html(data);
       $(".commentbox  ").hide();
      
       if(type == "play"){
                $("#gamePlayersCount").html(parseInt($("#gamePlayersCount").html())+1);
  
       }
    }
  
    if("<?php echo $mode?>"=="play" && "<?php echo $gameBean->gameStatus?>"=="play"){ 
      // $(".btnplay").trigger("click"); 
       $("#gameBtn").html("<?php echo Yii::t('translation','Play_Now'); ?> <i class='fa fa-chevron-circle-right'></i>");
       $("#gameBtn").attr("class","btn btnplay btndisable");
        $(".btnplaying").unbind();
        showGame('play',$("#gameBtn").attr("data-gameid"),$("#gameBtn").attr("data-gamescheduleid"));

    }
    else if("<?php echo $mode?>"=="resume" && "<?php echo $gameBean->gameStatus?>"=="resume"){ 
      // $(".btnresume").trigger("click"); 
      //Custom=null;
       $("#gameBtn").html("<?php echo Yii::t('translation','Resume'); ?> <i class='fa fa-chevron-circle-right'></i>");
       $("#gameBtn").attr("class","btn btnplay btndisable");
        $(".btnplaying").unbind();
        showGame('resume',$("#gameBtn").attr("data-gameid"),$("#gameBtn").attr("data-gamescheduleid"));
    }
    else if("<?php echo $mode?>"=="view" && "<?php echo $gameBean->gameStatus?>"=="view"){
         $("#gameBtn").html("<?php echo Yii::t('translation','View'); ?> <i class='fa fa-chevron-circle-right'></i>");
       $("#gameBtn").attr("class","btn btnviewanswers btndisable");
        $(".btnviewanswers").unbind();
       showGame('view',$("#gameBtn").attr("data-gameid"),$("#gameBtn").attr("data-gamescheduleid"));

    }else{
       //showGame('resume',$("#gameBtn").attr("data-gameid"),$("#gameBtn").attr("data-gamescheduleid"));
  
    }
    
     $(".btnplaying").unbind();
     function showQuestion(){
        
        if(<?php echo Yii::app()->session['IsAdmin']?>==1){
            $("#gameBtn").removeClass("btndisable");
             bindgameEvents();
              showGame('viewAdmin',$("#gameDummyBtn").attr("data-gameid"),$("#gameDummyBtn").attr("data-gamescheduleid"));

        }
  
     }
     $("#cancelPostCommentButton").bind('click',function(){
            $("#commentTextArea").html("");
             var postId = $(this).attr('data-postid');
            if($('#commentbox_' + postId).height() >0){
            $('#cId_' + postId).show();
            }else{
            $('#cId_' + postId).hide();
            }
            //$("#newComment,#commentDetailedBox").hide();
            $("#commentartifactsarea_"+postId).hide();
             $("#commentTextArea_"+postId).addClass('commentplaceholder');
             $("#commentartifactsarea_" + postId).css("min-height","20px");
             $("#commentTextArea_" + postId).css("min-height", "");
            
        });
        g_commentPage = 1;
        
        function setCommentArrowPoition(){
        var commentLeft = $('#detailedComment').position().left;
       
         $('.commentbox').append('<style>#postDetailedwidget .commentbox:before{left:'+commentLeft+'px}</style>');
         $('.commentbox').append('<style>#postDetailedwidget .commentbox:after{left:'+commentLeft+'px}</style>');
     }
      if($('#det_commentCount_<?php  echo $data->_id; ?>').length>0){
            var commentArrowLeft = $('#det_commentCount_<?php  echo $data->_id; ?>').prev().find('img').position().left;
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:before{left:'+commentArrowLeft+'px}</style>');
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:after{left:'+commentArrowLeft+'px}</style>');
        }
      
     if("<?php echo $mode?>"=="questions" && <?php echo Yii::app()->session['IsAdmin']?>=="1"){ 
        
             showQuestion();
           
        
     }
     $("#gameprofileimage").unbind().bind("click",function(){
           var displayName = $(this).attr('data-name');
           if(displayName!=null && displayName!="undefined" && displayName!=""){
             window.location = "/profile/"+displayName;

           }
     });
       $(".userprofilename").unbind().bind("click",function(){
           
           var postId = $(this).attr('data-streamId');
                var userId = $(this).attr('data-id');               
                getMiniProfile(userId,postId);
                trackEngagementAction("ProfileMinPopup",userId);

           
     });
     
//      $("#" + divId + " a.userprofilename").live("click",
//            function() {
//                var postId = $(this).attr('data-streamId');
//                var userId = $(this).attr('data-id');
//                getMiniProfile(userId,postId);
//                trackEngagementAction("ProfileMinPopup",userId);
//            }
//    );
      $(document).ready(function(){
          $("[rel=tooltip]").tooltip();
            $("#more").click(function(){             
                 $('#gameShortDescription').hide();
                 $('#gameDetailDescription').show();
                 $("#more").hide();
                 $("#moreup").show();
                
            });
            $("#moreup").click(function(){ 
                 $('#gameShortDescription').show();
                 $('#gameDetailDescription').hide();
                 $("#more").show();
                 $("#moreup").hide();
                
            });
        });
    bindUserActionView();
    initializeFileUploader("postupload_<?php   echo $data->_id?>", '/post/upload', '10*1024*1024', extensions,'4','commentTextArea','<?php   echo $data->_id?>',previewImage,appendErrorMessages,"uploadlist_<?php   echo $data->_id?>");
   initializationForHashtagsAtMentions('#commentTextArea_<?php   echo $data->_id?>');
    </script>
    <?php }else{
          $errMessage = Yii::t("translation","Ex_Msg_NoGame");  
        ?>
    <div  id="streamsectionarea_error" class="paddingtblr30" style="padding-bottom: 40px">
            <div class="ext_surveybox NPF lineheightsurvey">
                <center class="ndm" id="errorTitle" ><?php echo $errMessage; ?></center>
            </div>
        </div>
    <?php
    } }else{?>
    
      <div class="row-fluid">
    <div class="span12" style="text-align:center;">
        <img src="/images/system/groupisinactive.png" />        
    </div>
</div>
<?php } ?>