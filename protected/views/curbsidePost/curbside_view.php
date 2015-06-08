<?php 
try{
 if(is_object($stream))
      {
     $style="";
    foreach($stream as $data){
                  $canMarkAsAbuse = isset($data->CanMarkAsAbuse)?$data->CanMarkAsAbuse:0;
    if($data->CategoryType!=13){
        $translate_fromLanguage = $data->Language;
        $postDetailClass = $data->PostTextLength>=500?'postdetail':'';
        $translate_class = "translatebutton ".$postDetailClass;
        $translate_id = $data->_id;
        $translate_postId = $data->PostId;
        $translate_postType = $data->PostType;
        $translate_categoryType = $data->CategoryType;
        $PostId=$data->PostId;$fromSTream=true;
?>
<div class="post item <?php echo (isset($data->IsPromoted) && $data->IsPromoted==1)?'promoted':'';
echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1) ?' saveitforlater' :''?>" style="width:100%;display:none" id="postitem_<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-posttype="<?php  echo $data->PostType;?>" data-categorytype="<?php  echo $data->CategoryType;?>">
    
<div class="stream_widget marginT10" >
        <div  class="generalprofileicon skiptaiconwidth80x80 generalzindex2 positionabsolutediv ">
     <div class="skiptaiconinner ">            
    <img src="<?php echo $data->FirstUserProfilePic ?>" >
      </div> 
                     </div>
    <div class="post_widget" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType;?>">
        <div class="stream_msg_box">
            
            <div class="stream_title paddingt5lr10 stream_sectionheader" style="position: relative"> <a class="userprofilename" data-streamId="<?php echo $data->_id;?>" data-id="<?php echo $data->FirstUserId ?>" style="cursor:pointer"><b><?php echo $data->FirstUserDisplayName?></b></a><?php echo $data->SecondUserData?> <?php echo $data->StreamNote ?> 
               <?php $PostId=$data->PostId;
                 include Yii::app()->basePath.'/views/includes/postdetail_actions.php'; ?>
                    </div>
            <div class=" stream_content positionrelative">
                <ul>
                    <li class="media">
                        
                        
                            <?php include Yii::app()->basePath . '/views/includes/stream_artifacts.php'; ?>
                               
                       
                            
                            <!-- spinner -->
                            <span id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></span>
                                    <div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
                            <!-- end spinner -->
                        <div class="media-body">
                            <div class="isFeatured" id="isFeatutedIcon_<?php  echo $data->_id ?>" <?php if($data->IsFeatured==1){?> style="display:block" <?php }else {?> style="display:none"<?php  }?> > </div>
            
            
              <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>" data-id="<?php echo $data->_id;?>" id="post_content_total_<?php echo $data->_id; ?>" style="display:none">
                                    <?php
                                    echo $data->PostCompleteText;
                                    ?>
                                </div>
           
                            <div class="bulletsShow impressionDiv" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-id="<?php echo $data->_id;?>" id="post_content_<?php echo $data->_id; ?>">
                            <?php  
                                  echo $data->PostText;
                             ?>
                                </div>
                            <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
                             </div>
                            <?php include Yii::app()->basePath . '/views/includes/stream_webSnippet.php'; ?>       

                            <!-- Nested media object -->
                                <?php if((int) $data->FirstUserId !=  (int)$data->OriginalUserId ){
                                  include Yii::app()->basePath . '/views/includes/stream_originalUser.php';
                                } else if($data->PostType==5){ ?>
                                 <div class="media-body"> 
                                     <div id="curbside_spinner_<?php echo $data->_id; ?>"></div>
                                    <div class="m_title"><span class="pull-right" data-id="<?php echo $data->_id; ?>"><?php echo $data->CurbsideConsultCategory?></span></div>
                                </div>
                             <?php }?>
                            <?php include Yii::app()->basePath . '/views/includes/curbside_socialBar.php'; ?>
                        
                              </li>
                </ul>
            </div>
        </div>
        <?php if($data->RecentActivity=="Invite"){ ?>
        <div style="" id="Invite_<?php  echo $data->_id; ?>" class="commentbox  ">
            <div class="padding10"><?php echo $data->InviteMessage; ?></div>
            <style>#Invite_<?php  echo $data->_id; ?>.commentbox:before{left:4px}</style><style>#Invite_<?php  echo $data->_id; ?>.commentbox:after{left:4px}</style>
        </div>
        <?php } ?>
        <div id="PostdetailSpinLoader_curbsideStreamDetailedDiv"></div>
       <div class="commentbox" id="cId_<?php  echo $data->_id; ?>"  style="display:<?php  echo (count($data->Comments)==0 || $data->RecentActivity=="Invite")?'none':'block';?>">
           <?php include Yii::app()->basePath . '/views/includes/stream_comments.php'; ?>
           <?php  if($data->CommentCount > 1){?>
             <div class="viewmorecomments alignright">
                <span  class="postdetail" data-id="<?php echo $data->_id;?>" data-postid="<?php echo $data->PostId;?>" data-categoryType="<?php echo $data->CategoryType;?>" data-postType="<?php echo $data->PostType;?>" id="viewmorecomments_<?php  echo $data->_id; ?>" style="<?php echo $style; ?>"     >More Comments</span>
              </div>

           <?php } ?>
             <div id="ArtifactSpinLoader_postupload_<?php  echo $data->_id?>"></div>
             <?php include Yii::app()->basePath . '/views/includes/stream_newComment.php'; ?>
        </div>
      
    </div>
</div>
   

</div>
 <?php
        } else {

            include Yii::app()->basePath.'/views/post/advertisement_view.php';
        }
        ?>
    
<script type="text/javascript">
    var createdon = '<?php echo $data->CreatedOn->sec; ?>';
    
    
     $("#postitem_<?php echo $data->_id; ?> .moreiconcolor").bind("click",function(){
        
         var IsSaveItForLater='<?php echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1)?1:0?>';
      
       if(IsSaveItForLater==1)
       {
           cancelSaveItForLater('<?php echo $data->CategoryType?>','<?php echo $data->PostType?>','<?php echo $data->PostId?>','<?php echo $data->_id?>')
           //do ajax call
       }
    });
    $("#postitem_<?php echo $data->_id; ?>").show();
    if(g_pflag == 0){
        g_pflag = 1;    
            g_postIds = '<?php echo $data->PostId; ?>';
        }else{
               g_postIds = g_postIds+','+'<?php echo $data->PostId; ?>';
                g_pflag = 1;
        }
        <?php if($data->IsPromoted == 0){?>
    if(g_postDT != undefined && g_postDT != null){        
        if(g_postDT < createdon){            
            g_postDT = createdon;
            g_iv = 1;
            status = 0;
        }else if(g_iv == 0){            
            g_postDT = createdon;            
            g_iv = 1;
            status = 0;
        }   
    }
        <?php } ?>
  var postid='<?php echo $data->_id; ?>';
  
</script>
 <script type="text/javascript">
                        $(function(){
                            var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
                            initializeFileUploader("postupload_<?php echo $data->_id?>", '/post/upload', '10*1024*1024', extensions, 4,'commentTextArea','<?php echo $data->_id?>',previewImage,appendErrorMessages,"uploadlist_<?php echo $data->_id?>");
                        });
                     </script>
<script type="text/javascript">
    $(function(){
        if(detectDevices()){
           $('.postmg_actions').removeClass().addClass("postmg_actions postmg_actions_mobile");
        }       
    });
    
    $('#postitem_'+'<?php echo $data->_id; ?>').mousemove(function( event ) {
          var id = $(this).prop('id');
          use4storiesinsertedid = id;
          
          
        });
    
</script>
    <?php
     }
      }else{
          echo $stream;
      }
          } catch (Exception $exc) {
     
}
?>
