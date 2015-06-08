<div id="g_mediapopup" class="g_mediapopup" style="clear:both">
    <div class="positionrelative paddingtop4"><div class="arrowdiv" id="arrowdiv"></div><div class="staticpopup noarrowafter">           
           <button aria-hidden="true" id="closeArtifact"  class="close" type="button">×</button>
            <div class="row-fluid">           
            <div class="span12">

                   
                <div class="span8">
                    <h2 class="pagetitle"> </h2>
                    <?php $ext =$postDetails->Extension; if($postDetails->Extension=="mp3" || $postDetails->Extension=="mp4" || $postDetails->Extension=="jpg" || $postDetails->Extension=="png" || $postDetails->Extension=="jpeg" || $postDetails->Extension=="gif" ||$postDetails->Extension=="tiff") {?>
                        <div id='playerad'> </div>
                        <div id='imageDiv' class="f_media_picture artifacts" > </div>
                        <?php  }else  if($ext == "pdf" || $ext == "txt" || $ext=='doc' || $ext=='xls' || $extType == "ppt" || $ext=='docx' || $ext=='xlsx'){                   
                    ?>
                                <div class="d_img_outer_video_play g_media_video" >
                                     <img style="width:160px;cursor: pointer" src="<?php  echo $postDetails->Resource ?>" data-uri="<?php   echo $postDetails->ResourceUri;?>" data-format="<?php  echo $ext;?>">
                                </div>  
                    <?php  }else { ?>
                    <div  class="g_media_video" > <a style="width:200px"  href="/post/fileopen/?file=<?php   echo $postDetails->ResourceUri;?>"  id="downloadArtifact"><img style="width:160px" src="<?php  echo $postDetails->Resource ?>"></a></div>
                        <?php }?>
                    </div>
                <div class="span4 stream_widget">
                    <div class="stream_msg_box_media paddingtop18">
                        <div class=" stream_content">
                            <div class="media-body">
                                <div class="media">
                                    <div id="stream_view_spinner_<?php echo $postDetails->PostId; ?>"></div>
                                     <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                                        <a   class="skiptaiconinner " style="cursor:pointer" data-userid="<?php  echo $postDetails->PostCreatedUserId;?>" >
                                            <img src="<?php  echo $postDetails->profile70x70 ?>"> 

                                        </a>
                                     </div>
                                    <div class="media-body profilesummary">
                                        <div class="m_title profileDetails"  style="cursor:pointer" data-userid="<?php  echo $postDetails->PostCreatedUserId;?>" data-id="<?php  echo $postDetails->PostId ?>"  data-name="<?php  echo $postDetails->UniqueHandle;?>"><?php  
                                            if($postDetails->isGroupAdmin == 1 ){
                                                echo html_entity_decode($postDetails->GroupName); 
                                            }else{
                                                echo $postDetails->DisplayName;                                                
                                            }
                                                ?></div>
                                        <span class="m_day"><?php  echo $postDetails->CreatedOn ?></span>
                                    </div>
                                </div>
                                <div class="toolTipWrap" id="post_content_total_<?php echo $postDetails->PostId; ?>" style="display: none"><?php  echo $postDetails->PostFullDescription ?></div>
                                <p class="toolTipWrap" id="post_content_<?php echo $postDetails->PostId; ?>"><?php  echo $postDetails->PostDescription ?></p>
                                
                            </div>
                            <?php 
                                $translate_fromLanguage = $postDetails->Language;
                                $postDetailClass = $postDetails->PostTextLength>=500?'postdetail':'';
                                $translate_class = "translatebutton ".$postDetailClass;
                                $translate_id = $postDetails->PostId;
                                $translate_postId = $postDetails->PostId;
                                $translate_postType = $postDetails->PostType;
                                $translate_categoryType = $postDetails->CategoryType;
                                include Yii::app()->basePath . '/views/common/translateButton.php'; 
                            ?>
                            <div class="social_bar" data-id="<?php  echo $postDetails->PostId ?>"  data-postid="<?php  echo $postDetails->PostId ?>" data-postType="<?php  echo $postDetails->PostType; ?>" data-categoryType="<?php   echo $postDetails->CategoryType;?>" data-networkId="<?php   echo $postDetails->NetworkId;?>">	                            
                                                        
                            
                            <a class="follow_a" ><i><img src="/images/system/spacer.png" class="tooltiplink cursor <?php  echo $postDetails->IsFollowingPost?'follow':'unfollow' ?>"  data-placement="bottom" rel="tooltip"  data-original-title="<?php  echo $postDetails->IsFollowingPost?'Unfollow':'Fofllow' ?>" ></i><b id="streamFollowUnFollowCount_<?php  echo $postDetails->PostId; ?>"><?php  echo $postDetails->FollowCount ?></b></a>
                            <a ><i><img src="/images/system/spacer.png" class="invite_frds tooltiplink cursor " data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Invite'); ?>" ></i></a>
                            <a ><i><img src="/images/system/spacer.png" style="display: none;" class=" share" ></i></a>
                            <span><i class="tooltiplink" ><img  class=" tooltiplink cursor  <?php echo $postDetails->IsLoved?'likes':'unlikes' ?>"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>" src="/images/system/spacer.png"></i><b id="streamLoveCount_<?php echo $postDetails->PostId; ?>"><?php echo $postDetails->LoveCount?></b></span>
                            <?php  if(!$postDetails->DisableComments){?>
                            <span><i><img src="/images/system/spacer.png" class=" tooltiplink <?php echo $postDetails->IsCommented?'commented':'comments'; ?> cursor " data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" ></i><b id="commentCount_<?php echo $postDetails->PostId; ?>"><?php echo $postDetails->CommentCount?></b></span>              
                            <?php }?>
                        </div>

                    </div>
                          <?php  if(!$postDetails->DisableComments){?>
                        <div class="commentbox" id="inviteBox_<?php  echo $postDetails->PostId; ?>"  style="display:none">
            <div id="invite_<?php  echo $postDetails->PostId; ?>" class="paddinglrtp5" >
                <div id="inviteTextArea_<?php  echo $postDetails->PostId; ?>" class="invite_inputor" contentEditable="true"></div>
                <div id="inviteTextAreaError_<?php  echo $postDetails->PostId; ?>" style="display: none;"></div>
                <div class="postattachmentarea alignright">
                    <button id="saveInviteButton_<?php   echo $postDetails->PostId; ?>" onclick="saveInvites('<?php   echo $postDetails->PostId; ?>','<?php   echo $postDetails->NetworkId; ?>','<?php   echo $postDetails->CategoryType; ?>','<?php   echo $postDetails->PostId; ?>');" class="btn" ><?php echo Yii::t('translation','Submit'); ?></button>
                </div> 
            </div>
        </div>
                    <div id="cId_<?php   echo $postDetails->PostId; ?>" class="commentbox" style="display:<?php  echo ($postDetails->CommentCount==0) ?'none':'block';?>">
                        
                             <div id="commentsAppend_<?php   echo $postDetails->PostId; ?>"></div>
                        <?php 
                        if(count($postDetails->CommentsArray)>0){
                        foreach($postDetails->CommentsArray as $comment){?>
                             
                            <div class="commentsection" id="comment_<?php echo $comment['CommentId']; ?>" style="position: relative">
                                <div id="commentSpinLoader_<?php  echo $comment['CommentId']; ?>"></div>
                                <?php 
                                    $commentId = $comment['CommentId'];
                                    $streamId = $postDetails->PostId;
                                    $postId = $postDetails->PostId;
                                    $categoryType = $postDetails->CategoryType;
                                    $networkId = $postDetails->NetworkId;
                                    include Yii::app()->basePath . '/views/includes/comment_management_actions.php'; 
                               ?>
                                <div class="row-fluid commenteddiv">
                                    <div class="span12">
                                        <div class="paddingt5lr10" id="post_content_total_<?php echo $comment['CommentId'];?>" style="display:none"><?php  echo $comment['CommentText']?></div>
                                        <div class="paddingt5lr10" id="post_content_<?php echo $comment['CommentId'];?>"><?php  echo $comment['CommentText']?></div>
                                    </div>
                                    
                                    
                                </div>
                                <?php 
                                    $translate_fromLanguage = $comment["Language"];
                                    $translate_class = "commenttranslatebutton";
                                    $translate_id = $comment['CommentId'];
                                    $translate_postId = $postDetails->PostId;
                                    $translate_postType = $postDetails->PostType;
                                    $translate_categoryType = $postDetails->CategoryType;
                                    include Yii::app()->basePath . '/views/common/translateButton.php'; 
                                ?>
                                <div class="row-fluid commenteddiv">
          <div class="span12">
                 <div class=" stream_content">
                <ul>
                    <li class="media">
                        
        
         <?php if($comment['resourceLength']!=0){
            $commentArtifacts=$comment['Artifacts'];

            $extension=$commentArtifacts[0]['Extension'];
                        if( $extension== 'mp4' ||  $extension == 'flv' || $extension == 'mov') {
                            $videoclassName = 'videoThumnailDisplay';

                      }else {
                          $videoclassName='videoThumnailNotDisplay';
                      }

             ?>                        
   <?php if($comment['resourceLength']>1){ ?>
                            <div class="pull-left multiple "> 
                                <div class="img_more1"></div>
                                <div class="img_more2"></div>
                           <a  class="pull-left img_more postdetail groupCommentMultiple clearboth" data-postid="<?php echo $postDetails->PostId; ?>" data-categoryType="<?php echo $postDetails->CategoryType; ?>" data-postType="<?php echo $postDetails->PostType; ?>"><img id="comment_new_photo" src="<?php echo $comment['ArtifactIcon'] ?>"  />          
                           </a>
                            </div>
   <?php }else{?>
 <a  class="pull-left img_single postdetail" data-postid="<?php echo $postDetails->PostId; ?>" data-categoryType="<?php   echo $postDetails->CategoryType;?>" data-postType="<?php   echo $postDetails->PostType;?>">
   
   <div id='img_streamVideoDiv<?php echo $postDetails->PostId; ?>' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img id="comment_new_photo" src="<?php echo $comment['ArtifactIcon'] ?>"  />                   
         </a><?php }?><?php }?>
                    </li>
                    </ul>
                     </div>
              </div></div>
                                    
                                <div class="media padding5">
                                    <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                                        <a   class="skiptaiconinner ">
                                            <img src="<?php  echo $comment['ProfilePicture']?>">

                                        </a>
                                    </div>
                                    
                                    <div class="media-body">
                                        <span class="m_day"><?php  echo $comment['CreatedOn']?></span>
                                        <div class="m_title profileDetails" style="cursor: pointer" data-userid="<?php  echo $comment['UserId'];?>" data-id="<?php  echo $postDetails->PostId ?>"><a ><?php  echo $comment['DisplayName']?></a></div>
                                    </div>
                                </div>
                            </div>
                            <?php  }?>
                            
                        <?php  }?>
                           
                      
                      
 
        <div id="newComment_<?php echo $postDetails->PostId; ?>" style="display:none" class="paddinglrtp5">
                       <div id="commentTextArea_<?php echo $postDetails->PostId; ?>" class="inputor commentplaceholder" contentEditable="true" <?php if($postDetails->DisableWebPreview==0){?> onkeyup="getsnipetForComment(event,this,'<?php echo $postDetails->PostId; ?>');" <?php }?> onclick="OpenCommentbuttonArea('<?php echo $postDetails->PostId; ?>','<?php  echo $postDetails->CategoryType;?>')" ontouchstart="OpenCommentbuttonArea('<?php echo $postDetails->PostId; ?>','<?php  echo $postDetails->CategoryType;?>')"></div>
        
        
            <div id="commentTextAreaError_<?php  echo $postDetails->PostId; ?>" style="display: none;"></div>
            <div class="alert alert-error" id="commentTextArea_<?php  echo $postDetails->PostId; ?>_Artifacts_em_" style="display: none;"></div>
            <input type="hidden" id="artifacts_<?php  echo $postDetails->PostId; ?>" value=""/>
            <div id="preview_commentTextArea_<?php  echo $postDetails->PostId; ?>" class="preview" style="display:none">
                     <ul id="previewul_commentTextArea_<?php  echo $postDetails->PostId;?>" class="imgpreview">
                         
                    </ul>

   
                 </div>
        
                                 
<div class="postattachmentarea" id="commentartifactsarea_<?php  echo $postDetails->PostId; ?>" style="display:none;">
        <div class="pull-left whitespace">
<div class="advance_enhancement">
<ul>
                <li class="dropdown pull-left ">
                  <div id="postupload_<?php  echo $postDetails->PostId?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Upload'); ?>">
                  </div>
                 
                     
               
                    </li>
                   
                     
                    </ul>
                        <div  id="snippet_main_<?php  echo $postDetails->PostId; ?>" class="snippetdiv" style="" >
           
      </div> 
    <a href="#" ></a> <a href="#" ><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
     </div>
    <div class="pull-right">
       
        <button id="savePostCommentButton_<?php  echo $postDetails->PostId; ?>" onclick="saveDetailedPostCommentByUserId('<?php  echo $postDetails->PostId; ?>','<?php  echo $postDetails->PostType;?>','<?php  echo $postDetails->CategoryType;?>','<?php  echo $postDetails->NetworkId;?>','<?php  echo $postDetails->PostId; ?>','GroupDetail');" class="btn" data-loading-text="Loading..."><?php echo Yii::t('translation','Comment'); ?></button>
        
        <button id="cancelPostCommentButton_<?php echo $postDetails->PostId; ?>" onclick="cancelPostCommentByUserIdDetailPage('<?php echo $postDetails->PostId; ?>')" class="btn btn_gray"> <?php echo Yii::t('translation','Cancel'); ?></button>

    </div></div>
            <div ><ul class="qq-upload-list" id="uploadlist_<?php echo $data->PostId ?>"></ul></div>
            <div style="display:<?php  echo count($postDetails->CommentsArray)>0?'block':'none';?>" class="postattachmentareaWithComments"> <img src="/images/system/spacer.png" />
                </div>
</div>
                    </div>
                          <?php }?>
                </div>    
            </div>

        </div>
    </div>
</div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
       var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
        initializeFileUploader("postupload_<?php  echo $postDetails->PostId?>", '/post/upload', '10*1024*1024', extensions,4, 'commentTextArea','<?php  echo $postDetails->PostId?>',previewImage,appendErrorMessages,"uploadlist_<?php echo $data->PostId ?>");
        
         <?php if($postDetails->IsPrivate==0){?>        
         initializationForHashtagsAtMentions('#commentTextArea_<?php  echo $postDetails->PostId?>');
        <?php } else {?>     
    var groupId='<?php echo $postDetails->GroupId?>';
    
            initializationForHashtagsAtMentionsForPrivateGroups('#commentTextArea_<?php  echo $postDetails->PostId?>',groupId);
           
        <?php }?>  
        
    });
 </script>
 <script type="text/javascript">
     
     $(".profileDetails").live("click",
            function() {                
                var postId = $(this).attr('data-id');                
                var userId = $(this).attr('data-userid');                
                getMiniProfile(userId,postId);
            }
    );
    $(window).resize(function(){
 
 resizeArtifactPointer();
}); 
    <?php  
    $format = strtolower($postDetails->Extension); 
    if($format=="mp3" || $format=="mp4" || $format=="tiff"  || $format=="mov") {?>
        var playeradoptions = {height:760,
            width:700,
            autoplay:true,
            callback:function(){
                //alert('document loaded');
            }
        };
     loadDocumentViewer("playerad", '<?php   echo $postDetails->ResourceUri;?>', playeradoptions,'',360,600);
     $('.document-viewer-wrapper').css('float','left');
    <?php }else if($format =="jpg" ||  $format=="png" || $format=="jpeg" || $format=="gif"){?>
         $("#playerad,#playerad_wrapper").removeAttr("style").hide();
        $("#imageDiv").html('<img src="<?php   echo $postDetails->ResourceUri;?>" />').show();
        $("#imageDiv").attr({
            "data-resource":"<?php echo str_replace("thumbnails","images",$postDetails->ResourceUri);?>",
            "data-format":"<?php echo $format; ?>"
        });
    <?php } ?>
    if(!detectDevices())
          $("[rel=tooltip]").tooltip();
</script>
