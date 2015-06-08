<div id='PD<?php echo $data->_id?>'></div>
<div class="customwidget_outer">
    
    <div class="customwidget <?php echo $data->Alignment?> impressionDiv" style="padding-bottom:10px">

<div class="pagetitle pagetitlewordwrap"><a href="<?php echo $data->PublisherSourceUrl?>" target="_blank"><?php echo $data->Title?></a>
<div class="postmg_actions">
                    <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
                    <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
                    <div class="dropdown-menu ">
                         <ul class="PostManagementActions" data-streamId="<?php echo $data->_id ?>"  data-postId="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType ?>" data-categoryType="<?php echo $data->CategoryType ?>" data-networkId="<?php echo $data->NetworkId ?>" date-useForDigest="<?php echo $data->IsUseForDigest ?>">
                             <?php if ($data->CanCopyURL == 1) { ?><li><a class="copyurl"><span class="copyicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','CopyUrl_label'); ?></a></li><?php } ?>
                              <?php if (($data->CanSaveItForLater == 1 && (isset($data->IsSaveItForLater) && $data->IsSaveItForLater!=1) )) { ?><li><a class="saveitforlater"><span class="saveitforlatericon"><img src="/images/system/spacer.png" /></span> <?php echo  Yii::t('translation','Can_SaveItForLater'); ?></a></li><?php } ?>
                              <?php if (isset($data->CanPromotePost) && $data->CanPromotePost == 1) { ?><li><a class="promote"><span class="promoteicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Promote_label'); ?></a></li><?php } ?>
                              <?php if (isset($data->Digest_Use) && $data->Digest_Use == 1) { ?><li><a class="usefordigest"><span class="<?php echo $data->IsUseForDigest==1?'notusefordigesticon':'usefordigesticon';?>"><img src="/images/system/spacer.png" /></span> <?php $digsetlable=$data->IsUseForDigest==1?'notusefordigest_label':'usefordigest_label'; echo Yii::t('translation',$digsetlable);  ?></a></li><?php } ?>
                         </ul>
                        </div>
                </div>
</div>




<div style="cursor: pointer;" class="custimage postdetail" id='<?php echo $data->_id; ?>' data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>"><?php echo $data->HtmlFragment?></div>
<?php if($data->Editorial!=''){?>
<div class="row-fluid">

    <div  class=" padding10 decorated EDCRO<?php echo $data->PostId?>" style="margin-top: 0px">
<?php
           $tagsFreeDescription = strip_tags(($data->Editorial));
           $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
           $descriptionLength = strlen($tagsFreeDescription);                      
           $editorial=$data->Editorial;
           if($descriptionLength>240)
           {
             $editorial=CommonUtility::truncateHtml($data->Editorial, 240);     
             $editorial=$editorial.'<a  class="showmore" data-id="'.$data->PostId.'">&nbsp<i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></a>';
             echo $editorial;
           }
           else
           {
               echo $editorial;
           }
?>
</div>
</div>

 <div class="row-fluid">
      <div  class="decorated span12 EDCROT<?php echo $data->PostId?>" style="display: none" data-id="<?php echo $data->PostId;?>" data-postid="<?php  echo $data->PostId ?>" data-postType="11" data-categoryType="8">
          <div>
</div>
</div>
     </div>
<?php }?>
<div style="cursor: pointer;" class="customcontentarea postdetail" id='<?php echo $data->_id; ?>' data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>">
    
    <div class="cust_content HTMLC<?php echo $data->PostId?>" data-id='<?php echo $data->PostId?>'><?php echo $data->PostText;?></div>
      <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
</div>

<div class="customcontentarea">
<div class="custfrom "><a href="<?php echo $data->PublisherSourceUrl?>" target="_blank"><?php echo $data->PublisherSource?></a> - <a class="ntime" style="cursor:default;text-decoration:none"><?php echo CommonUtility::styleDateTime(strtotime($data->PublicationDate));?></a>
<div style="text-align:right" class="nright">via <a style="cursor:default;text-decoration:none">Scoop.it!</a></div>
</div>
</div>
</div>

</div>
<div class="social_bar" style="padding:10px" data-id="<?php  echo $data->_id ?>" data-postid="<?php  echo $data->PostId ?>" data-postType="<?php  echo $data->PostType;?>" data-categoryType="<?php  echo $data->CategoryType;?>" data-networkId="<?php  echo $data->NetworkId; ?>">	
 
    <a class="follow_a"><i ><img src="/images/system/spacer.png" class=" tooltiplink <?php echo $data->IsFollowingPost?'follow':'unfollow' ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php  echo $data->IsFollowingPost? Yii::t('translation','UnFollow') : Yii::t('translation','Follow') ?>" ></i> <b class="streamFollowUnFollowCount"  data-actiontype='Followers' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->FollowCount?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="streamFollowUnFollowCount_<?php  echo $data->PostId; ?>"><?php  echo $data->FollowCount ?></span>
                                <?php include Yii::app()->basePath.'/views/common/userFollowActionView.php'; ?>
                                </b></a>
   
                            <a ><i><img src="/images/system/spacer.png" class=" tooltiplink cursor invite_frds" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Invite'); ?>" ></i></a>
                            <span class="cursor"><i><img  class=" tooltiplink cursor <?php  echo $data->IsLoved?'likes':'unlikes' ?>"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>" src="/images/system/spacer.png"></i><b class="streamLoveCount"  data-actiontype='Love' data-id='<?php echo $data->_id?>' data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->LoveCount?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="streamLoveCount_<?php  echo $data->PostId; ?>"><?php  echo $data->LoveCount?></span>
                                <?php include Yii::app()->basePath.'/views/common/userLoveActionView.php'; ?>
                                </b></span>
 
                            <span><i ><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class=" cursor tooltiplink  <?php  if($data->PostType!=5){?><?php echo $data->IsCommented?'commented':'comments'?><?php }else{?>comments1 postdetail<?php }?>" <?php  if($data->PostType ==5){?> data-id="<?php echo $data->_id;?>" data-postid="<?php  echo $data->PostId ?>" data-postType="<?php  echo $data->PostType;?>" data-categoryType="<?php  echo $data->CategoryType;?>" <?php } ?> ></i><b id="commentCount_<?php  echo $data->PostId; ?>"><?php  echo $data->CommentCount?></b></span>              
                        </div>
<!-- spinner -->
 <div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
 <?php if($data->RecentActivity=="Invite"){ ?>
        <div style="" id="Invite_<?php  echo $data->_id; ?>" class="commentbox  ">
            <div class="padding10"><?php echo $data->InviteMessage; ?></div>
            <style>#Invite_<?php  echo $data->_id; ?>.commentbox:before{left:48px}</style><style>#Invite_<?php  echo $data->_id; ?>.commentbox:after{left:48px}</style>
        </div>
        <?php } ?>
<div id="PostdetailSpinLoader_streamDetailedDiv"></div>
<!-- End spinner -->
        <div class="commentbox" id="cId_<?php  echo $data->_id; ?>"  style="display:<?php  echo (count($data->Comments)==0 || $data->RecentActivity=="Invite") ?'none':'block';?>">
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
                 $style="";
            }
         $maxDisplaySize = sizeof($data->Comments)>2?2:sizeof($data->Comments);
  
            for($j=sizeof($data->Comments);$j>sizeof($data->Comments)-$maxDisplaySize;$j--){ 
             
                
                $comment=$data->Comments[$j-1];
                ?>
          <div class="commentsection">
              <div id="commentSpinLoader_<?php  echo $comment['CommentId']; ?>"></div>
          <div class="row-fluid commenteddiv"  id="comment_<?php echo $comment['CommentId']; ?>" >
          <div class="span12">
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

                    <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>" data-id="<?php echo $data->_id;?>" id="post_content_<?php echo $comment['CommentId']; ?>" data-categoryType="<?php echo $data->CategoryType;?>">

                            <?php  
                                 
                                  echo $comment["CommentText"];
                             ?>
                                </div>
                             <!-- Nested media object -->
                            <div class="media">
                                <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                                <a   class="skiptaiconinner ">
                                    <img src="<?php  echo $comment['ProfilePicture'] ?>">

                                </a>
                                 </div>
                                
                                <div class="media-body">
                                    <span class="m_day"><?php  echo $comment["CreatedOn"]; ?></span>
                                    <div class="m_title"><a class="userprofilename" data-streamId="<?php echo $data->_id;?>" data-id="<?php  echo $comment['UserId'] ?>"  style="cursor:pointer"><?php  echo $comment["DisplayName"] ?></a></div>
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
             $style="";
        }else if($data->CommentCount > sizeof($data->Comments)){
             $style="";
        }
        
        ?>
   
        </div> 
    </div>
           <div class="viewmorecomments alignright">
               <span<?php  if($data->CommentCount > 10){?> class="postdetail_news" data-id="<?php echo $data->_id;?>" data-postid="<?php echo $data->PostId;?>" data-categoryType="<?php echo $data->CategoryType;?>" data-postType="<?php echo $data->PostType;?>" <?php } ?> id="viewmorecomments_<?php  echo $data->_id; ?>" style="<?php echo $style; ?>" <?php  if($data->CommentCount <= 10){?> onclick="viewmoreComments('/post/postComments','<?php  echo $data->PostId ?>','<?php  echo $data->_id ?>','<?php echo $data->CategoryType; ?>');" <?php } ?>>More Comments</span>
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
                                           <div  id="postupload_<?php echo $data->_id ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Upload'); ?>">
                                           </div>

                                       </li>


                                   </ul>
                                   
                                   <a ></a> <a ><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
                           </div>
                          
                           <div class="pull-right">

                               <button id="savePostCommentButton_<?php echo $data->_id; ?>" onclick="savePostCommentByUserId('<?php echo $data->PostId; ?>','<?php echo $data->PostType; ?>','<?php echo $data->CategoryType; ?>','<?php echo $data->NetworkId; ?>','<?php echo $data->_id; ?>');" class="btn" data-loading-text="Loading...">Comment</button>
                               <button id="cancelPostCommentButton_<?php echo $data->_id; ?>" onclick="cancelPostCommentByUserId('<?php echo $data->_id; ?>','<?php echo $data->CategoryType; ?>')" class="btn btn_gray"> Cancel</button>

                           </div>
                           <div id="commenterror_<?php echo $data->PostId; ?>" class="alert alert-error displayn" style="margin-left: 30px;margin-right: 157px;"></div>

                       </div>
                       <div ><ul class="qq-upload-list" id="uploadlist_<?php echo $data->_id ?>"></ul></div>
                   </div>
        </div>

<script type="text/javascript">
    
    
    
     $("#<?php echo $data->_id; ?> .moreiconcolor").bind("click",function(){
       
         var IsSaveItForLater='<?php echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1)?1:0?>';
      
       if(IsSaveItForLater==1)
       {
           cancelSaveItForLater('<?php echo $data->CategoryType?>','<?php echo $data->PostType?>','<?php echo $data->PostId?>','<?php echo $data->_id?>')
           //do ajax call
       }
    });
//    $("#postitem_<?php  echo $data->_id; ?>").show(); 
    if(g_pflag == 0){
        g_pflag = 1;    
        g_postIds = '<?php  echo $data->PostId; ?>';
        }else{
               g_postIds = g_postIds+','+'<?php  echo $data->PostId; ?>';
               g_pflag = 1;
        }
       
     var postid='<?php echo $data->_id; ?>';
     //var divheight=$("#CommentBoxScrollPane_"+ postid).height();    
</script>

<script type="text/javascript">
    $(function(){
        var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
        initializeFileUploader("postupload_<?php  echo $data->_id?>", '/post/upload', '10*1024*1024', extensions,4, 'commentTextArea','<?php  echo $data->_id?>',previewImageNews,appendErrorMessages,"uploadlist_<?php echo $data->_id ?>");
    });         
</script>
         <script type="text/javascript">
         if($('#commentCount_<?php  echo $data->PostId; ?>').length>0){
            var commentArrowLeft = $('#commentCount_<?php  echo $data->PostId; ?>').prev().find('img').position().left;
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:before{left:'+commentArrowLeft+'px}</style>');
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:after{left:'+commentArrowLeft+'px}</style>');
        }
        $('#post_content_<?php  echo $data->_id; ?> span.postdetail').prevAll().each(function(key,ele){
            if($(ele).prop("tagName")=='p' || $(ele).prop("tagName")=='P'){
                if($(ele).text().length==0){
                    $(ele).remove();
                }else{
                     return false;
                }
            }else{
                 return false;
            }
        });
      
         </script>
