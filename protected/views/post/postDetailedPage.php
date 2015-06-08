<?php 
try{

if(is_object($data)){

    $Status=1;
    if($data->CategoryType==3 ){
        $Status=$data->Status;
    }
    if($Status==1){
        $data->Description = CommonUtility::findUrlInStringAndMakeLink($data->Description); 
    $text = "has been deleted";
    if($data->IsAbused == 1) $text = "has been marked as abused";    
    $isPostManagement = isset($isPostManagement)?$isPostManagement:0;
    if(($isPostManagement==0 && $data->IsAbused == 1 &&   Yii::app()->session['IsAdmin']!='1') || $data->IsDeleted == 1 ||  $data->IsDeleted == 2 || $data->IsBlockedWordExist == 1){ 
        ?>
        <div class="row-fluid">
            <div class="span10" style="text-align:center;font-family:'exo_2.0medium'">
                <h3> <?php echo $text; ?>.
              
          <div class="grouphomemenuhelp alignright tooltiplink"> <a onclick="window.location.reload(true);" data-postType="<?php  echo $data->Type;?>" data-categoryId="<?php  echo $data->CategoryType; ?>" class="detailed_close_page" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','close'); ?>" data-placement="bottom" data-toggle="tooltip"> <i class="fa fa-times"></i></a> </div>
           </h3>
          </div>
           
        </div>

   <?php }else{
    
    $translate_fromLanguage = $data->Language;
    $translate_class = "translatebutton_postdetail";
    $translate_id = $data->_id;
    $translate_postId = $data->_id;
    $translate_postType = $data->Type;
    $translate_categoryType = $data->CategoryType;
?>
    
<div class="row-fluid " id="postDetailedTitle">
     <div class="span6 "><h2 class="pagetitle"><?php if($data->Type==5){ echo $data->Subject;} else{  echo Yii::t('translation','Normal_Post_Detail');}?></h2>
    
     </div>
          <div class="span6 ">
          <div class="grouphomemenuhelp alignright tooltiplink"> <a data-postType="<?php  echo $data->Type;?>" data-categoryId="<?php  echo $data->CategoryType; ?>" class="detailed_close_page" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','close'); ?>" data-placement="bottom" data-toggle="tooltip"> <i class="fa fa-times"></i></a> </div>
          </div>
     </div>
    
    <div class="stream_widget marginT10" id="postDetailedwidget">
   	 
<div class="generalprofileicon skiptaiconwidth80x80 generalzindex2 positionabsolutediv ">
     <div class="skiptaiconinner ">            
    <img src="<?php if($data->IsGroupPostAdmin == 'true') {
                           echo $data->GroupProfileImage; 
                        }else{

                          if($data->Type != 4 &&  $data->IsAnonymous == 0) {  echo $data->Profile250x250;} else{ echo "/images/icons/user_noimage.png";} } ?>" >
      </div> 
                     </div>
    	<div class="post_widget" data-postid="<?php  echo $data->_id ?>" data-postType="<?php  echo $data->Type;?>">
        <div class="stream_msg_box">
            
            <?php include Yii::app()->basePath . '/views/includes/postdetail_header.php'; ?>
             <div class=" stream_content">
                
            <ul>
            <li class="media">
                 <?php  if(sizeof($data->Resource)>0){   
                            include Yii::app()->basePath . '/views/includes/postdetail_artifacts.php';
                        } ?>
            <?php  if($data->Type!=3){  ?>
                <?php  if($data->Type==2 && isset($data->StartDate) && $data->EndDate){
                        include Yii::app()->basePath . '/views/includes/postdetail_event.php';
                }else{ ?>



                     <!-- spinner -->
<!--                      <div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>   
                      <span id="detailed_followUnfollowSpinLoader_<?php echo $data->_id; ?>"></span>-->
                 <!-- end spinner -->
                     
                    <div class="media-body postDetail bulletsShow" id="postDetailPage" data-id="<?php echo $data->_id; ?>">
                        <?php if($data->CategoryType==10) { ?>
                        <div class="pull-left multiple "> 
                                  
                            <a  class="pull-left pull-left1 img_more postdetail"   ><img src="<?php  echo $data->BadgeImagePath ?>"></a>
                                </div>       

                        <p id="postdetail_postText"> <?php echo $data->BadgeDescription; ?></p>

                        <?php } else{ ?>
                            
                            <p id="postdetail_postText">  <?php echo $data->Description;  ?></p>
                     
                                
                                
                        <?php } if($data->Type!=4 && $data->IsAnonymous == 0){?>
                            <!-- Nested media object -->
                                <div class="media">
                                        <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner "   >
                       <img src="<?php if($data->IsGroupPostAdmin == 'true') {
                           echo $data->GroupProfileImage; 
                        }else{
                            echo $data->Profile70x70; } ?>"> 
                  
                  </a>
                     </div>
                                    <div class="media-body">                                   
                                        <span class="m_day"><?php  echo $data->PostOn; ?></span>
                                        <div class="m_title">
                                            <a class="<?php if($data->IsGroupPostAdmin == 'true') { echo 'grpIntro'; } else { echo $data->DisplayName; } ?>" data-postId="<?php echo $data->_id;?>" data-id="<?php if($data->IsGroupPostAdmin == 'true') { echo $data->GroupId; } else { echo $data->UserId; } ?>"  style="cursor:pointer">
                                                <?php if($data->IsGroupPostAdmin == 'true') { echo html_entity_decode($data->GroupName); } else { echo $data->DisplayName;} ?>
                                            </a>
                                                <?php  if ($data->Type==5){ ?> 
                                            <div id="curbside_spinner_<?php echo $data->_id; ?>">
                                                </div>
                                            <span class="pull-right" >
                                                <a style='cursor:pointer'data-postId="<?php echo $data->_id; ?>" data-id='<?php  echo $data->CategoryId;?>' class='curbsideCategory'>
                                                    <b><?php  echo $data->CategoryName;?>
                                                    </b>
                                                </a>
                                            </span><?php  }?>
                                        </div>

                                    </div>
                                    <?php if($data->CategoryType==3 && $data->IsIFrameMode==1){ ?>
                                   <div class="media-body"> 
                                    <div class="m_title">
                                        <span class="pull-right" data-id="<?php echo $data->_id; ?>">
                                            <a class="grpIntro grpIntro_b" data-postId="<?php echo $data->_id;?>" data-id="<?php echo $data->GroupId; ?>" style="cursor:pointer"><b><?php echo html_entity_decode($data->GroupName); ?></b></a>
                                        </span>
                                    </div>
                                </div> 
                                   <?php } ?>
                                </div></div><?php }?>
                            
                            
                            
                               <?php  }?>
                 <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
                 <?php include Yii::app()->basePath . '/views/includes/stream_webSnippet.php'; ?>    
                 
                 
                
            <?php  }else{
                    include Yii::app()->basePath . '/views/includes/postdetail_survey.php';
                    include Yii::app()->basePath . '/views/includes/stream_webSnippet.php';
                }?>
                    
                   
                                                     
      
              

        
              </li>
              </ul>
                 <?php   if(!isset($data->AddSocialActions) || $data->AddSocialActions==1) {
                    include Yii::app()->basePath . '/views/includes/postdetail_socialBar.php';
                }?> 
             
          </div>
          
        </div> 
             <?php if($data->RecentActivity=="invite"){ ?>
        <div style="" id="Invite_<?php  echo $data->_id; ?>" class="invitebox">
            <div class="padding10"><?php echo $data->InviteMessage ?></div>
            <style>#Invite_<?php  echo $data->_id; ?>.commentbox:before{left:48px}</style><style>#Invite_<?php  echo $data->_id; ?>.commentbox:after{left:48px}</style>
        </div>
        <?php } ?>
         <?php   if(!isset($data->AddSocialActions) || $data->AddSocialActions==1) {?>
          <div  id="CommentPost" style="display:<?php echo $data->RecentActivity=="invite"?'none':'block' ?>" class="commentbox <?php  if($data->Type==5){?>commentbox2<?php  }?> " id="cId_<?php   echo $data->_id; ?>" >

              <div id="commentSpinLoader_<?php  echo $data->_id; ?>"></div>
            
              <div id="ArtifactSpinLoader_postupload_<?php echo $data->_id ?>"></div>

              <?php 
                    include Yii::app()->basePath . '/views/includes/postdetail_newComment.php';
                    include Yii::app()->basePath . '/views/includes/postdetail_comments.php';
              ?>

               <?php  if($data->CommentCount > 10){ ?>
           <div class="viewmorecomments alignright">
                <span  id="viewmorecommentsDetailed" onclick="viewmoreCommentsIndetailedPage('/post/postComments','<?php   echo $data->_id ?>','<?php   echo $data->_id ?>','Streampost','<?php  echo $data->CategoryType; ?>',10,'<?php  echo $data->IsPostManagement; ?>');">More Comments</span>
              </div>
      <?php   } ?>
                  
          </div> <?php  }?>
        </div>
    
    </div>
<script type="text/javascript">
    
     var IsSaveItForLater='<?php echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1)?1:0?>';
      
       if(IsSaveItForLater==1)
       {
           cancelSaveItForLater('<?php echo $data->CategoryType?>','<?php echo $data->Type?>','<?php echo $data->_id?>','')
           //do ajax call
       }
//    var PostdetailArtifactSrc="";
//    var PostdetailArtifactUri="";
//    var NoOfPostdetailArtifacts=0;
//    var CurrentArtifactpage=0;
//    var PreviousCurrentArtifactpage=0;
   if(!detectDevices())
            $("[rel=tooltip]").tooltip();
    $(function(){
        isDuringAjax = true;
        notificationAjax = true;
        var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
        //initializeFileUploader("postupload_<?php   echo $data->_id?>", '/post/upload', '10*1024*1024', extensions,'4','commentTextArea','<?php   echo $data->_id?>',previewImage,appendErrorMessages,4);
    <?php   if(!isset($mainGroupCollection->AddSocialActions) || $mainGroupCollection->AddSocialActions==1) {?>   
    initializeFileUploader("postupload_<?php   echo $data->_id?>", '/post/upload', '10*1024*1024', extensions,'4','commentTextArea','<?php   echo $data->_id?>',previewImage,appendErrorMessages,"uploadlist_<?php echo $data->_id ?>");    
    <?php   } ?>

    });
    
    <?php if ($this->whichmenuactive == 1) {?>
                    $("#homestream").removeClass("active");
            <?php }else if ($this->whichmenuactive == 2) { ?>
                $("#curbsidepost").removeClass("active");
            <?php }else if ($this->whichmenuactive == 3) { ?>
                 $("#groupmainmenu").removeClass("active");
            <?php } ?>
    $("#"+setActiveClassPage).removeClass("active").addClass("active");
 </script>
 <script type="text/javascript">
     gPage = "PostDetail";
     $('body, html').animate({scrollTop : 0}, 800,function(){});
      <?php   if(!isset($mainGroupCollection->AddSocialActions) || $mainGroupCollection->AddSocialActions==1) {?>
       setCommentArrowPoition();<?php } ?>
     function setCommentArrowPoition(){
        var commentLeft = $('#detailedComment').position().left;
        
        if(commentLeft == 0)
            commentLeft = 167;
         $('#postDetailedwidget .commentbox').append('<style>#postDetailedwidget .commentbox:before{left:'+commentLeft+'px}</style>');
         $('#postDetailedwidget .commentbox').append('<style>#postDetailedwidget .commentbox:after{left:'+commentLeft+'px}</style>');
     }
//    $(function(){ // by default commentbox setted  
        
//        clearInterval(intervalIdNewpost);
//        clearInterval(intervalIdCurbpost);
        g_commentPage = 1;
        $("#postDetailedTitle").trigger('click');
        $("#notificationsdiv").hide();
        Custom.init();
         <?php   if(!isset($mainGroupCollection->AddSocialActions) || $mainGroupCollection->AddSocialActions==1) {?>
        setTimeout(setCommentArrowPoition,100);<?php } ?>
        $("#detailedLove").unbind('click');
        $("#detailedLove").bind('click',function(){
            var postId = $(this).attr("data-postid");
            var categoryId = $(this).attr("data-catogeryId");
            var className = $("#detailedLove").attr('class');
            var pType = 0;
            if($.trim(className) == "unlikes"){
                $("#detailedLove").attr("style","");                
                $("#detailedLove").removeClass().addClass("likes");
                var loveCount = Number($("#detailedLoveCountSpan").html());
                
                loveCount++;
                $("#detailedLoveCountSpan").html(loveCount);
                  $(".dLoves").attr("data-count",loveCount);
                
                  $("#userDetailLoveView_" +postId).attr("data-count",loveCount);
                 $("#userDetailLoveView_" +postId).prepend("You<br/>");
                if(categoryId == 1){
                    pType = 'Normal';
                }
                if(categoryId == 2){
                    pType = 'Curbside';
                }
                if(categoryId == 3){
                    pType = 'Group';
                }
               
                loveToPost(pType, postId, categoryId,postId);
                trackEngagementAction("Love",postId,categoryId);
            }
        });
        $("#detailedComment").unbind('click');
        $(".detailedComment").bind('click',function(){
            var postId = $(this).attr('data-postid');
            var commentLeft = $(this).position().left;
            $('#postDetailedwidget .commentbox').append('<style>#postDetailedwidget .commentbox:before{left:'+commentLeft+'px}</style>');
            $('#postDetailedwidget .commentbox').append('<style>#postDetailedwidget .commentbox:after{left:'+commentLeft+'px}</style>');
            $("#commentTextArea").html("");
            $("#cId_"+postId).show();
            $("#newComment,#commentbox").show();
            $("#commentartifactsarea_" + postId).hide();
            $("#inviteBox,.invitebox").hide();
            initializationForHashtagsAtMentions('#commentTextArea_'+postId);
        });
        $("#cancelPostCommentButton").unbind('click');
        $("#cancelPostCommentButton").bind('click',function(){
            
             var postId = $(this).attr('data-postid');
             $("#commentTextArea_"+ postId).html("");
            if($('#commentbox_' + postId).height() >0){
            $('#cId_' + postId).show();
            }else{
            $('#cId_' + postId).hide();
            }
            //$("#newComment,#commentDetailedBox").hide();
            $("#commentartifactsarea_"+postId).hide();
            $("#commentTextArea_"+postId).html("");
             $("#commentTextArea_"+postId).addClass('commentplaceholder');
             $("#commentTextArea_"+postId).removeAttr("style");
             $("#commentartifactsarea_" + postId).css("min-height","");
            
        })
        $("#invitefriendsDetailed").unbind('click');
        $("#invitefriendsDetailed").bind('click',function(){
            var PostId = $(this).closest('div.social_bar_detailed').attr('data-postid');
            var StreamId = PostId;
            var NetworkId = $(this).closest('div.social_bar_detailed').attr('data-networkId');
            var CategoryType = $(this).closest('div.social_bar_detailed').attr('data-categoryType');
            var item = {
                'id': StreamId,
                'PostId': PostId,
                'NetworkId': NetworkId,
                'CategoryType': CategoryType
            };
            if($('#Invite_' + StreamId).length>0){
                $('#cId_' + StreamId).hide();
                $('#Invite_' + StreamId).show();
                $('#Invite_' + StreamId).find('style').remove();
                $('#Invite_' + StreamId).append('<style>#Invite_'+StreamId+'.commentbox:before{left:43px}</style>');
                $('#Invite_' + StreamId).append('<style>#Invite_'+StreamId+'.commentbox:after{left:43px}</style>');
            }
            $("#myModal_body").html($("#inviteTemplate_render").render(item));
            $("#myModalLabel").addClass("stream_title paddingt5lr10");
            $("#myModalLabel").html("<?php echo Yii::t('translation','Invite_Others'); ?>");
            $("#myModal_footer").hide();
            $("#myModal").modal('show');
            initializeAtMentions('#inviteTextBox_' + StreamId, PostId, Number(CategoryType));
            // this code is commented by  Haribabu for don't show the already invited members in invite other popup
           // getInvitedUsersForPost(PostId, CategoryType);
        });
        $("#postDetailedwidget .userprofilename_detailed,#postDetailedwidget .userprofilename").die("click");
        $("#postDetailedwidget .userprofilename_detailed,#postDetailedwidget .userprofilename").live("click",function(){
           var userId = $(this).attr('data-id'); 
           var postId = $(this).attr('data-postId');
           getMiniProfile(userId,postId);
        });
        $( ".detailed_close_page" ).unbind( "click" );
        $(".detailed_close_page").bind('click',function(){ 
            $("#"+setActiveClassPage).removeClass("active");
//            $("html,body").scrollTop(Global_ScrollHeight);
        if(Global_ScrollHeight  != undefined && Global_ScrollHeight != "" && Global_ScrollHeight != 0)
                $('body, html').animate({scrollTop : Global_ScrollHeight}, 1000,function(){});
            if(detectDevices()){
                $("#rightpanel").show();
            }
            <?php if ($this->whichmenuactive == 1) {?>
                    
                if($("#streamMainDiv").length>0){
                    $("#homestream").removeClass("active").addClass("active");
                }else if($("#curbsidePostsDiv").length>0){
                    $("#curbsidepost").removeClass("active").addClass("active");
                }else if($("#GroupTotalPage").length > 0){
                    $("#grouppost").removeClass("active").addClass("active");
                }
                    
            <?php }else if ($this->whichmenuactive == 2) { ?>
                $("#curbsidepost").removeClass("active").addClass("active");
            <?php }else if ($this->whichmenuactive == 3) { ?>
                 $("#groupmainmenu").removeClass("active").addClass("active");
            <?php } ?>
//            if($("#streamMainDiv").length > 0){
//                
//            }else if($("#curbsidePostsDiv").length > 0){
//                
//            }else if($("#curbsidePostsDiv").length > 0){
//                $("#curbsidepost").removeClass("active").addClass("active");
//            }else if($("#g_mediapopup").length > 0 || $("#groupstreamMainDiv").length > 0){
//               
//            }
            if(typeof io !== "undefined")
                updateSocketConnect();
              <?php  if(isset($_REQUEST['layout'])){ ?>
                window.location.href = "/";
                
            <?php unset($_REQUEST['layout']); }else{?> 
                
                if($.trim($("#notificationHistory").text()) != ""){
                                $("#notificationHomediv,#notificationHistory").show();
                                notificationAjax = false;
                    }else if($("#messagetextareadiv").length > 0){
                        if($("#minChatWidgetDiv").is(":visible") == false){
                            $("#chatDiv").show();
                        }else{
                            $("#contentDiv").show(); 
                        }
                    }else{
                        isDuringAjax = false;
                        $("#contentDiv").show(); 
                         $("#rightpanel").show();
                         $("#chatDiv").hide();
                    }
                if(globalspace.notification=="detailedpage"){
                            $('#admin_PostDetails').hide().html("");                    
                            if(fromHeaderNotifications == 2){
                                $('#notificationHistory').show();
                                $('#notificationHomediv').show();
                            }else{
                                if(($("#poststreamwidgetdiv").length>0) || $("#curbsidePostCreationdiv").length>0){
                                    //$("#rightpanel").show();
                                }
                                if($.trim($("#notificationHistory").text()) != ""){
                                    $("#contentDiv").hide();
                                }else{
                                     $("#contentDiv").show();
                                }
                                
                            }
                            globalspace.notification="";
                            notificationAjax = false;
                            checkNotificationStatus = false;
                            return;
                        }
                        if($.trim(globalspace.groupsPage) == "detailed_page" ){
                            $("#admin_PostDetails").hide().html("");
                            $("#GroupTotalPage").show();   
                           // $("#rightpanel").show();
                            $("#contentDiv").show();
                            $(".group_admin_floatingMenu").show();
                            globalspace.groupsPage ="";
                            return;
                        }
                         
                        $("#streamDetailedDiv").html("");
                    
                    if($('#postDetailsDivInProfile').length>0){ 
                        $('#postDetailsDivInProfile').hide();
                        $('#profileDetailsDiv').show();
                         if($("#admin_PostDetails").is(':visible')){
                            $("#admin_PostDetails").hide().html("");
                            
                            
                        }
                        return;
                    }
                    if($("#curbsideStreamDetailedDiv").is(':visible')){
                            $("#curbsideStreamDetailedDiv").hide();
                            $("#curbsidePostCreationdiv").show();
                            
                            return;
                        }
                    var categoryId = $(this).attr("data-categoryId");
                    var postType = $(this).attr("data-postType");  
                   
                    if (checkNotificationStatus == true){
                        notificationAjax = false;
                        $("#notificationHomediv,#notificationHistory").show();
                        $("#contentDiv").hide();
                        if($("#notificationText").text() != ""){
                            $("#nomorenotifications").show();
                        }
                        checkNotificationStatus = false;
                    }else{
//                        $("#poststreamwidgetdiv,#rightpanel").show();
                        $("#poststreamwidgetdiv").show();
                        $("#streamDetailedDiv,#groupPostDetailedDiv").hide();
                       // $("#groupFormDiv,#groupstreamMainDiv,#groupProfileDiv,#GroupBanner,#usergroupsfollowingdiv").show();
                    }
                 
                    if(categoryId == 1 && (postType != 5)){
                        
                        $("#streamDetailedDiv").hide();
                        $("#poststreamwidgetdiv").show(); 
                        
                        if($("#curbsideStreamDetailedDiv").is(':visible')){
                            $("#curbsideStreamDetailedDiv").hide();
                            $("#curbsidePostCreationdiv").show();
                        }
                        if($("#admin_PostDetails").is(':visible')){
                            $("#admin_PostDetails").hide().html("");
//                            $("#contentDiv").show();
                        }
                        $("#groupFormDiv,#groupProfileDiv,#GroupBanner").show();
                        if(globalspace.featuredItems!=undefined){
                            if(globalspace.featuredItems==1){
                                loadGalleria();
                            }
                        }
        //                intervalIdNewpost = setInterval(function() {
        //                    status = 0;
        //                    socketPost.emit('getNewPostsRequest', g_postDT,loginUserId, userTypeId);
        //                }, 15000);
                    }
                    if(categoryId == 2){ 
                        var showdivId="";
                        var hidedivId="";
                        /**
                         * this is used to manage in both curbside and Normal..
                         */ 
                        if($("#curbsidePostCreationdiv").length > 0){  
                            showdivId = "curbsidePostCreationdiv";
                            hidedivId = "curbsideStreamDetailedDiv";
                        } if($("#admin_PostDetails").is(':visible')){ 
                            $("#admin_PostDetails").hide().html("");
                            $("#contentDiv").show();
                             //hidedivId = "admin_PostDetails";
                            //showdivId = "contentDiv";
                        }
                        else{  
                            showdivId = "poststreamwidgetdiv";
                            hidedivId = "streamDetailedDiv";
                        }                
                        $("#"+hidedivId).hide();
                        $("#"+showdivId).show();
        //                intervalIdCurbpost = setInterval(function() {
        //                    status = 0;
        //                    socketCurbside.emit('getNewCurbsidePostsRequest', g_postDT,loginUserId, userTypeId);
        //                }, 15000);
                    }
                    if(categoryId == 3 || categoryId == 7){ 
                        var showdivId="";
                        var hidedivId="";
                        /**
                         * this is used to manage in both group and Normal..
                         */ 
                        if($("#groupstreamMainDiv").length > 0){ 
                           // showdivId = "groupstreamMainDiv";
                            hidedivId = "groupPostDetailedDiv";
                             $("#GroupTotalPage").show();
                           // $("#groupFormDiv,#groupProfileDiv,#GroupBanner,#GroupTotalPage").show();
                        }else{
                            showdivId = "poststreamwidgetdiv";
                            hidedivId = "streamDetailedDiv";
                        }
        //                groupPostInterval = setInterval(function() {
        //                    status = 0;
        //                    socketGroup.emit('GetNewGroupPostsRequest', g_postDT, loginUserId, userTypeId);
        //                }, 15000);
                        $("#"+hidedivId).hide();
                        $("#"+showdivId).show();
                    }
            $('.jspContainer').css('height','250px');
            <?php }?>
            $("html,body").scrollTop(Global_ScrollHeight);
             $("[rel=tooltip]").tooltip();
        });
        $("#detailedfolloworunfollow").unbind("click");
        $("#detailedfolloworunfollow").bind("click",function(){
            var postId = $(this).attr("data-postid");
            var categoryId = $(this).attr("data-catogeryId");
            var actionType = "";
            var pType ="";
            var className = $("#detailedfolloworunfollow").attr('class');
            var followCnt = Number($(this).parent('i').parent('a').find('b').children("span").text());
                
            if($.trim(className) == "unfollow"){
                actionType = "Follow";
                followCnt = Number(followCnt)+1;
                $(this).parent('i').parent('a').find('b').children("span").text(followCnt);
                $("#detailedfolloworunfollow").removeClass().addClass("follow");
                $("#detailedfolloworunfollow").attr("data-original-title","<?php echo Yii::t('translation','UnFollow'); ?>"); 
                
                 $("#userDetailFollowView_" +postId).prepend("You<br/>");
                    $(this).parent('i').next('b').attr("data-count",followCnt);
                 $("#userDetailFollowView_" +postId).attr("data-count",followCnt);
                
            }else if($.trim(className) == "follow"){
                followCnt = Number(followCnt)-1;
                $(this).parent('i').parent('a').find('b').children("span").text(followCnt);
                actionType = "UnFollow";
                $("#detailedfolloworunfollow").removeClass().addClass("unfollow");
                   $("#detailedfolloworunfollow").attr("data-original-title","<?php echo Yii::t('translation','Follow'); ?>"); 
                var html = $("#userDetailFollowView_" +postId).html();
                 html = html.replace("You<br>", ""); 
                 $("#userDetailFollowView_" +postId).html(html);
                 
                  $(this).parent('i').next('b').attr("data-count",followCnt);
                 $("#userDetailFollowView_" +postId).attr("data-count",followCnt);   
                   
            }
            if(categoryId == 1){
                    pType = 'Normal';
            }
            if(categoryId == 2){
                pType = 'Curbside';
            }
            if(categoryId == 3){
                pType = 'Group';
            }
            
            followOrUnfollowPost(pType, postId,actionType, categoryId,$(this))
             trackEngagementAction(actionType,postId,categoryId);
            
        });
        //for mentions
        $("#postDetailedwidget span.at_mention").die("click");
        $("#postDetailedwidget span.at_mention").live( "click", 
           function(){
               var streamId = $(this).closest('div').attr('data-id');
               var userId = $(this).attr('data-user-id');
               getMiniProfile(userId,streamId);
           }
       );

       //for hashtags
      $("#postDetailedwidget span.hashtag>b").die( "click");
       $("#postDetailedwidget span.hashtag>b").live( "click", 
           function(){
               var postId = $(this).closest('div').attr('data-id');

               var hashTagName = $(this).text(); 
               getHashTagProfile(hashTagName,postId);
           }
       );
        //for CurbsidecateogryProfile
        $("#postDetailedwidget a.curbsideCategory").unbind( "click");
     $("#postDetailedwidget a.curbsideCategory").bind( "click", 
        function(){
            var categoryId = $(this).attr('data-id');
            var postId = $(this).attr('data-postId');
            getMiniCurbsideCategoryProfile(categoryId,postId);
        }
    );
    $("#eventAttendDetailed").unbind("click");
    $("#eventAttendDetailed").bind("click",function(){
        var postId = $(this).closest('div.post_widget').attr('data-postid');        
        var categoryType = $(this).attr('data-categoryType');
        var actionType = $(this).attr('name');
        var streamId;
        if(typeof streamId=='undefined' || streamId==""){
            streamId = postId;
        }
                $("#eventAttendDetailedImg").removeClass("eventattend_no").addClass("eventattend_yes");
                var eventAttendCount = Number($("#detailedEventAttenCountSpan").html());
                eventAttendCount++;
                $("#detailedEventAttenCountSpan").html(eventAttendCount);
                  $(".dEventAttend").attr("data-count",eventAttendCount);
                  $("#userDetailEventAttenView_" +postId).attr("data-count",eventAttendCount);
                 $("#userDetailEventAttenView_" +postId).prepend("You<br/>"); 
       attendEvent(postId,actionType,categoryType, streamId);
    }); 
    
        
//    });

    if(!detectDevices()){
        $("[rel=tooltip]").tooltip();
    }
    $("#myModal_old").on("hidden",function(){
          if($('.jPlayer-container').length>0){
            $('.jPlayer-container').jPlayer("destroy");
        }
        $('#player').empty();
          $('#player').hide();
    });
    $("img.share, img.sharedisable").unbind("click");
    $("img.share, img.sharedisable").bind("click",
            function() {
                var postId = $(this).closest('div.social_bar').attr('data-postid');
                var shareLeft = $(this).position().left;
                var sharesectionWidth = $(this).closest('span.sharesection').find('div.actionmorediv').width()/2;
                $(this).closest('span.sharesection').find('div.actionmorediv').css('left',shareLeft-sharesectionWidth+14);
            }
    );
    
    $(".translatebutton_postdetail").unbind("click");
    $(".translatebutton_postdetail").bind("click",
            function() {
                var obj = $(this);
                var streamId = $.trim($(obj).attr('data-id'));
                var postId = $.trim($(obj).attr('data-postid'));
                var postType = Number($.trim($(obj).attr('data-postType')));
                var categoryType = $(obj).attr('data-categoryType');
                var text = $.trim($("#postdetail_postText").html());
                var fromLanguage = $(obj).attr('data-fromLanguage');
                var toLanguage = $(obj).attr('data-toLanguage');
                var queryString = {
                        postId:postId,
                        postType:postType,
                        categoryType:categoryType,
                        text:text,
                        fromLanguage:fromLanguage,
                        toLanguage:toLanguage
                    };
                if(postType==3){
                    queryString.title = "";
                    if($("#surveyTakenArea_"+streamId).is(":visible")){
                        queryString.optionOne = $.trim($("#GraphArea_OptionOne_"+streamId).text());
                        queryString.optionTwo = $.trim($("#GraphArea_OptionTwo_"+streamId).text());
                        queryString.optionThree = $.trim($("#GraphArea_OptionThree_"+streamId).text());
                        queryString.optionFour = $.trim($("#GraphArea_OptionFour_"+streamId).text());
                    }else if($("#surveyArea_"+streamId).is(":visible")){
                        queryString.optionOne = $("#OptionOne_"+streamId).text();
                        queryString.optionTwo = $("#OptionTwo_"+streamId).text();
                        queryString.optionThree = $("#OptionThree_"+streamId).text();
                        queryString.optionFour = $("#OptionFour_"+streamId).text();
                    }
                }else if(postType==2){
                    queryString.title = "";
                    queryString.location = $("#Location_"+streamId).text();
                }
                scrollPleaseWait('stream_view_spinner_'+streamId);
                ajaxRequest("/common/translateData", queryString, function(data){translatePostdetailDataHandler(data,obj, fromLanguage, toLanguage)});
            }
    );
    function translatePostdetailDataHandler(data, obj, fromLanguage, toLanguage){
        var streamId = $.trim($(obj).attr('data-id'));
        scrollPleaseWaitClose('stream_view_spinner_'+streamId);
        $("#postdetail_postText").html(data.bean.PostText);
        $(obj).val('Translate to '+fromLanguage);
        $(obj).attr('data-fromLanguage',toLanguage);
        $(obj).attr('data-toLanguage',fromLanguage);
        var postType = Number($.trim($(obj).attr('data-postType')));
        if(postType==3){
            if($("#surveyTakenArea_"+streamId).is(":visible")){
                $("#GraphArea_OptionOne_"+streamId).text(data.bean.OptionOne);
                $("#GraphArea_OptionTwo_"+streamId).text(data.bean.OptionTwo);
                $("#GraphArea_OptionThree_"+streamId).text(data.bean.OptionThree);
                $("#GraphArea_OptionFour_"+streamId).text(data.bean.OptionFour);
            }else if($("#surveyArea_"+streamId).is(":visible")){
                $("#OptionOne_"+streamId).text(data.bean.OptionOne);
                $("#OptionTwo_"+streamId).text(data.bean.OptionTwo);
                $("#OptionThree_"+streamId).text(data.bean.OptionThree);
                $("#OptionFour_"+streamId).text(data.bean.OptionFour);
            }
        }else if(postType==2){
            $("#Location_"+streamId).html('<i class="fa fa-map-marker"></i>'+data.bean.Location);
        }
    }
    $(".commenttranslatebutton_postdetail").unbind("click");
    $(".commenttranslatebutton_postdetail").bind("click",
            function() {
                var obj = $(this);
                var commentId = $.trim($(obj).attr('data-id'));
                var postId = $.trim($(obj).attr('data-postid'));
                var postType = Number($.trim($(obj).attr('data-postType')));
                var categoryType = $(obj).attr('data-categoryType');
                var text = $.trim($("#comment_text_"+commentId).html());
                var fromLanguage = $(obj).attr('data-fromLanguage');
                var toLanguage = $(obj).attr('data-toLanguage');
                var queryString = {
                        commentId:commentId,
                        postId:postId,
                        postType:postType,
                        categoryType:categoryType,
                        text:text,
                        fromLanguage:fromLanguage,
                        toLanguage:toLanguage
                    };
                scrollPleaseWait("commentSpinLoader_"+postId+"_"+ commentId, "comment_"+postId+"_"+ commentId);
                ajaxRequest("/common/translateCommentData", queryString, function(data){commentTranslatePostdetailDataHandler(data,obj, fromLanguage, toLanguage)});
            }
    );
    function commentTranslatePostdetailDataHandler(data, obj, fromLanguage, toLanguage){
        var commentId = $.trim($(obj).attr('data-id'));
        var postId = $.trim($(obj).attr('data-postid'));
        scrollPleaseWaitClose("commentSpinLoader_"+postId+"_"+ commentId);
        $("#comment_text_"+commentId).html(data.html);
        $(obj).val('Translate to '+fromLanguage);
        $(obj).attr('data-fromLanguage',toLanguage);
        $(obj).attr('data-toLanguage',fromLanguage);
    }
    $("#postDetailedwidget .commenttranslatebutton").live("click",
        function() { 
            var obj = $(this);
            var commentId = $.trim($(obj).attr('data-id'));
            var postId = $.trim($(obj).attr('data-postid'));
            var postType = Number($.trim($(obj).attr('data-postType')));
            var categoryType = $(obj).attr('data-categoryType');
            var text = $.trim($("#post_content_total_"+commentId).html());
            if(text.length<=0){
                text = $.trim($("#post_content_"+commentId).html());
            }
            var fromLanguage = $(obj).attr('data-fromLanguage');
            var toLanguage = $(obj).attr('data-toLanguage');
            var queryString = {
                    commentId:commentId,
                    postId:postId,
                    postType:postType,
                    categoryType:categoryType,
                    text:text,
                    fromLanguage:fromLanguage,
                    toLanguage:toLanguage
                };
                scrollPleaseWait("commentSpinLoader_" + commentId, "comment_" + commentId);
            ajaxRequest("/common/translateCommentData", queryString, function(data){commentTranslateDataMoreHandler(data,obj, fromLanguage, toLanguage)});
        }
    );
    
    function commentTranslateDataMoreHandler(data, obj, fromLanguage, toLanguage){
        var commentId = $.trim($(obj).attr('data-id'));
        scrollPleaseWaitClose("commentSpinLoader_" + commentId);
        $("#post_content_"+commentId).html(data.html);
        $(obj).val('Translate to '+fromLanguage);
        $(obj).attr('data-fromLanguage',toLanguage);
        $(obj).attr('data-toLanguage',fromLanguage);
    }
   $('.grpIntro').live("click",function(){
            var groupId=$(this).attr('data-id');
            getGroupIntroPopUp(groupId);             
                  
              });
              
   
                  
</script>
 
    <?php   }  
    }else{?>
        <div class="row-fluid">
    <div class="span12" style="text-align:center;">
        <img src="/images/system/groupisinactive.png" />        
    </div>
</div>
    <?php }
         
        }else{
?>
<div class="row-fluid">
    <div class="span12" style="text-align:center;">
          <h3><?php echo Yii::t('translation','Post_UnAvailable');?></h3>
    </div>
</div>
        <?php }

}catch(Exception $ex){
  error_log("exception------------".$ex->getMessage());
          }
        ?>

 

 
 
