<?php 

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
       
?>

<div class="post item groupsDiv <?php  echo (isset($data->IsPromoted) && $data->IsPromoted==1)?'promoted':''; echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1) ?' saveitforlater' :'' ?>" style="width:100%;display:none" id="postitem_<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-posttype="<?php  echo $data->PostType;?>" data-categorytype="<?php  echo $data->CategoryType;?>">


<div class="stream_widget marginT10" >
    <?php include Yii::app()->basePath . '/views/includes/group_profile_image.php'; ?>
    <div class="post_widget impressionDiv" data-postid="<?php  echo $data->PostId ?>" data-postType="<?php  echo $data->PostType;?>">
        <div class="stream_msg_box">
            <?php include Yii::app()->basePath . '/views/includes/group_header.php'; ?>
            <div class=" stream_content">
               <!-- spinner -->
                <div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
                <div id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></div>
                <div id="detailed_followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></div>
               <!-- end Spinner -->
                <ul>
                    <li class="media">
                            
            
                        <?php  if($data->PostType!=3 && $data->CategoryType !=7){//not survey post 
                            include Yii::app()->basePath . '/views/includes/stream_artifacts.php'; ?>
                        
                        <div class="media-body" >
                            <?php  if($data->PostType==2){ 
                                include Yii::app()->basePath . '/views/includes/stream_event.php';
                            }else{ ?>

                                <div data-postid="<?php echo $data->PostId; ?>" id="post_content_total_<?php echo $data->_id; ?>" style="display:none">
                                    <?php
                                    echo $data->PostCompleteText;
                                    ?>
                                </div>
                            <div data-postid="<?php echo $data->PostId; ?>" data-groupid="<?php  echo $data->GroupId ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_<?php echo $data->_id; ?>">
                            <?php  
                                  echo $data->PostText;
                             ?>
                                </div>
                            <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
                             <?php  if($data->PostType!=4){?>
                            <!-- Nested media object -->
                               <?php if((int) $data->FirstUserId !=  (int)$data->OriginalUserId ){
                                   include Yii::app()->basePath . '/views/includes/stream_originalUser.php';
                               } }?>
                            
                            
                               <?php  }?> 
                            
                      <?php  if($data->PostType==2){ ?>      
                        </div>
                       <?php }
                       include Yii::app()->basePath . '/views/includes/stream_webSnippet.php';
                       if($data->PostType!=2){ ?>      
                        </div>
                       <?php }?>
            <?php  }else if($data->CategoryType !=7 ){
                 include Yii::app()->basePath . '/views/includes/stream_survey.php';
            }  if($data->CategoryType ==7){ ?>
            
                <span id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></span>
               
                        <a  class="pull-left img_single" href="/<?php echo $data->GroupUniqueName ?>/sg/<?php echo $data->SubGroupUniqueName ?>"><img src="<?php echo $data->SubGroupImage ?>"  ></a>
                        <div class="media-body" >
                            <p  data-postid="<?php echo $data->PostId; ?>">
                                <a href="/<?php echo $data->GroupUniqueName ?>/sg/<?php echo $data->SubGroupUniqueName ?>" ><b><?php echo html_entity_decode($data->SubGroupName);?></b></a>
                            </p>
                            <p id='groupShortDescription' style="cursor: pointer" data-GroupId="<?php echo $data->SubGroupId ?>"  data-groupName="<?php echo $data->SubGroupName ?>" data-postid="<?php echo $data->PostId; ?>"><?php
                                echo $data->GroupDescription;
                                ?></p>
                        </div>
                        <?php if(isset($data->AddSocialActions) && $data->AddSocialActions==1){ ?>
                        <div class="social_bar" data-id="<?php  echo $data->_id ?>" data-subgroupid="<?php  echo $data->SubGroupId ?>" data-groupid="<?php  echo $data->GroupId ?>" data-postid="<?php  echo $data->PostId ?>" data-postType="<?php  echo $data->PostType;?>" data-categoryType="<?php  echo $data->CategoryType;?>" data-pagetype="Group" data-IsPrivate="<?php  echo $data->IsPrivate;?>">	
                            <a class="follow_a"><i><img src="/images/system/spacer.png"  class=" tooltiplink <?php  echo $data->IsFollowingEntity?'follow':'unfollow' ?>"  data-placement="bottom" rel="tooltip"  data-original-title="<?php  echo $data->IsFollowingEntity?Yii::t('translation','UnFollow'):Yii::t('translation','Follow') ?>"></i><b class="streamFollowUnFollowCount"  data-actiontype='Followers'  data-postId='<?php echo $data->PostId?>' data-count="<?php echo $data->SubGroupFollowersCount?>" data-categoryId="<?php  echo $data->CategoryType;?>"><span id="group_followers_count_<?php  echo $data->_id ?>"><?php echo $data->SubGroupFollowersCount ?></span>
                            
                              <?php 
                              $data->FollowCount = $data->SubGroupFollowersCount;
                              include Yii::app()->basePath.'/views/common/userFollowActionView.php'; 
                              ?>
                            </b>
                                </a>
                        </div><?php } ?>
                  
           
            <?php           
               } ?><?php if(isset($data->AddSocialActions) && $data->AddSocialActions==1){
               if($data->CategoryType!=7 ){?>
                    <div class="social_bar" data-id="<?php echo $data->_id ?>" data-postid="<?php echo $data->PostId ?>" data-groupid="<?php echo $data->GroupId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>"  data-networkId="<?php echo $data->NetworkId; ?> " data-pagetype="Group" data-IsPrivate="<?php echo $data->IsPrivate; ?>">	
                   <?php include Yii::app()->basePath . '/views/includes/group_socialBar.php';?>
                    </div>
              <?php }}?>
                              </li>
                </ul>
            </div>
        </div>
    <?php if($data->CategoryType!=7 && (isset($data->AddSocialActions) && $data->AddSocialActions==1)){?>
        <?php if($data->RecentActivity=="Invite"){ ?>
        <div style="" id="Invite_<?php  echo $data->_id; ?>" class="commentbox  ">
            <div class="padding10"><?php echo $data->InviteMessage; ?></div>
            <style>#Invite_<?php  echo $data->_id; ?>.commentbox:before{left:4px}</style><style>#Invite_<?php  echo $data->_id; ?>.commentbox:after{left:4px}</style>
        </div>
        <?php } ?>
        <div id="PostdetailSpinLoader_groupPostDetailedDiv"></div>
        <div class="commentbox <?php if ($data->PostType == 5) { ?>commentbox2<?php } ?> " id="cId_<?php echo $data->_id; ?>"  style="display:<?php echo (count($data->Comments) == 0 || $data->RecentActivity == "Invite") ? 'none' : 'block'; ?>">
            <?php include Yii::app()->basePath . '/views/includes/stream_comments.php'; ?>
            <div class="viewmorecomments alignright" style="<?php echo $style; ?>">
                <span<?php  if($data->CommentCount > 10){?> class="postdetail" data-id="<?php echo $data->_id;?>" data-postid="<?php echo $data->PostId;?>" data-categoryType="<?php echo $data->CategoryType;?>" data-postType="<?php echo $data->PostType;?>" <?php } ?> id="viewmorecomments_<?php  echo $data->_id; ?>" style="<?php echo $style; ?>" <?php  if($data->CommentCount <= 10){?> onclick="viewmoreComments('/post/postComments','<?php  echo $data->PostId ?>','<?php  echo $data->_id ?>','<?php echo $data->CategoryType; ?>');" <?php } ?>>More Comments</span>
              </div>
            <div id="ArtifactSpinLoader_postupload_<?php echo $data->_id ?>"></div>
            <?php include Yii::app()->basePath . '/views/includes/stream_newComment.php'; ?>
          </div>
  
 <script type="text/javascript">
                        $(function(){
                            var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
                            initializeFileUploader("postupload_<?php  echo $data->_id?>", '/post/upload', '10*1024*1024', extensions,4, 'commentTextArea','<?php  echo $data->_id?>',previewImage,appendErrorMessages,"uploadlist_<?php echo $data->_id?>");
                        });
                        
               var postid='<?php echo $data->_id; ?>';
              var divheight=$("#CommentBoxScrollPane_"+ postid).height();

          if(divheight >250){
                 $("#CommentBoxScrollPane_"+ postid).addClass("scroll-pane"); 
                  $("#CommentBoxScrollPane_" + postid).jScrollPane({autoReinitialise: true, stickToBottom: true});
          }            
                     
                        
                     </script>
    <?php }?>
    </div>
</div>
       <?php }else{

              include Yii::app()->basePath.'/views/post/advertisement_view.php';
 
          } ?>
</div>    
<script type="text/javascript">
     Custom.init();
       if(!detectDevices())
            $("[rel=tooltip]").tooltip();
    
     $("#postitem_<?php echo $data->_id; ?> .moreiconcolor").bind("click",function(){
       
         var IsSaveItForLater='<?php echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1)?1:0?>';
      
       if(IsSaveItForLater==1)
       {
           cancelSaveItForLater('<?php echo $data->CategoryType?>','<?php echo $data->PostType?>','<?php echo $data->PostId?>','<?php echo $data->_id?>')
           //do ajax call
       }
    });
    function setCommentArrowPoition(){
       if($('#commentCount_<?php  echo $data->PostId; ?>').length>0){
            var commentArrowLeft = $('#commentCount_<?php  echo $data->PostId; ?>').prev().find('img').position().left;
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:before{left:'+commentArrowLeft+'px}</style>');
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:after{left:'+commentArrowLeft+'px}</style>');
        }
     }
    <?php if($data->CategoryType !=7){?> 
     setTimeout(setCommentArrowPoition,50);
    <?php }?> 
    var createdon = '<?php  echo $data->CreatedOn->sec; ?>';
    $("#postitem_<?php  echo $data->_id; ?>").show(); 
    if(g_pflag == 0){
        g_pflag = 1;    
            g_postIds = '<?php  echo $data->PostId; ?>';
        }else{
               g_postIds = g_postIds+','+'<?php  echo $data->PostId; ?>';
                g_pflag = 1;
        }
        <?php if(($data->SubGroupId == ""|| $data->SubGroupId == "0")){ ?>
            gType = "Group"
        <?php }else{ ?>
            gType = "SubGroup"
        <?php } ?>
            groupId = '<?php echo $data->GroupId;?>';
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
//            socketGroup.emit('updateGlobalDateValue', g_postDT,g_postIds);
</script>


  <script type="text/javascript">
    $(function(){
        if(detectDevices()){
           $('.postmg_actions').removeClass().addClass("postmg_actions postmg_actions_mobile");
        }       
    });
    
        $('.grpIntro').live("click",function(){
            var groupId=$(this).attr('data-id');
            getGroupIntroPopUp(groupId);             
                  
              });
        $('#postitem_'+'<?php echo $data->_id; ?>').mousemove(function( event ) {
          var id = $(this).prop('id');
          use4storiesinsertedid = id;
          
          
        });
        
       
    </script>

<?php  }?>
                    
<script>
    
   
     
</script>
    <?php
      }else{
          echo $stream;
      }
?>

