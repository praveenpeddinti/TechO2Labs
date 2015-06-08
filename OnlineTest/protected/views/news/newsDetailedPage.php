<?php 
$count = 0;
if(isset($this->tinyObject->UserId))
    $UserId = $this->tinyObject->UserId;
else
    $UserId = 0;
 if(is_object($data)){
     $isPostManagement = isset($data->IsPostManagement)?$data->IsPostManagement:0;
    if(($isPostManagement==0 && $data->IsAbused == 1) || $data->IsDeleted == 1 || $data->IsBlockedWordExist == 1){ ?>
        <div class="row-fluid">
            <div class="span12" style="text-align:center;font-family:'exo_2.0medium'">
                <h3><?php echo Yii::t('translation','news_item_cannot_be_shown'); ?></h3>
            </div>
        </div>
   <?php }else{
?>


<div class="row-fluid " id="postDetailedTitle">
     <div class="span10 "><h2 class="pagetitle"><?php echo $data->TopicName?></h2>
    
     </div>
          <div class="span2 pull-right ">
          <div class="grouphomemenuhelp alignright tooltiplink"> <a  class="detailed_close_page" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','close'); ?>" data-placement="bottom" data-toggle="tooltip"> <i class="fa fa-times"></i></a> </div>
          </div>
</div>
<div class="woomarkLi" id="newsDetailedwidget">

<div class="customwidget_outer">
<div class="customwidget <?php echo $data->Alignment?> customwidgetdetail">
<div class="pagetitle newsdetailpagetitlewordwrap"><a href="<?php echo $data->PublisherSourceUrl?>" target="_blank"><?php echo $data->Title?></a>
<?php include Yii::app()->basePath.'/views/includes/postdetail_actions.php';?>  
</div>
<div class="custimage"><?php echo $data->HtmlFragment?></div>
<div class="customcontentarea customwidgetdetailcontent">
<div class="cust_content" data-id="<?php echo $data->_id?>"><?php echo $data->Description?></div>

<?php if($data->Editorial!=''){?>
<div class="row-fluid">
<div class="span12">
<div  class="decorated span12 EDCRO<?php echo $data->_id?>"><?php echo $data->Editorial?></div>
</div>
</div>
<?php }?>
<div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
<div class="customcontentarea">
<div class="custfrom "><a href="<?php echo $data->PublisherSourceUrl?>" target="_blank"><?php echo $data->PublisherSource?></a> - <a class="ntime" style="cursor:default;text-decoration:none"><?php echo CommonUtility::styleDateTime(strtotime($data->PublicationDate));?></a>
    <div class="nright" style="text-align:right">via <a style="cursor:default;text-decoration:none">Scoop.it!</a></div>
</div>
</div>
<?php  if(sizeof($data->Resource)>0){  
         include Yii::app()->basePath . '/views/includes/postdetail_artifacts.php';
       } ?>
 </div>
<?php
  include Yii::app()->basePath . '/views/includes/postdetail_socialBar.php';
?>
</div>
<div class="commentbox <?php  if($data->Type==5){?>commentbox2<?php  }?> " id="cId_<?php   echo $data->_id; ?>" >
              <div id="commentSpinLoader_<?php  echo $data->_id; ?>"></div>
            <div id="ArtifactSpinLoader_postupload_<?php  echo $data->_id?>"></div>
             <?php
                    include Yii::app()->basePath . '/views/includes/postdetail_newComment.php';
                    include Yii::app()->basePath . '/views/includes/postdetail_comments.php';
                    ?>
               <?php  if($data->CommentCount >5){ ?>
           <div class="viewmorecomments alignright">
                <span  id="viewmorecommentsDetailed" onclick="viewmoreCommentsIndetailedPage('/post/postComments','<?php   echo $data->_id ?>','<?php   echo $data->_id ?>','Streampost','<?php  echo $categoryType; ?>');"><?php echo Yii::t('translation','More_Comments'); ?></span>
              </div>
      <?php   } ?>
                        
          </div>
</div>

</div>
<script type="text/javascript">
$(function(){
      $('body, html').animate({scrollTop : 0}, 800,function(){
        //$("#registrationdropdown").addClass("open");
    });
    if($("#streamMainDiv").length > 0){
            $("#homestream").removeClass("active");
    }
    $("#news").removeClass("active").addClass("active");
    notificationAjax = true;
    isDuringAjax = true;
    
      var IsSaveItForLater='<?php echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1)?1:0?>';
       if(IsSaveItForLater==1)
       {
           cancelSaveItForLater('<?php echo $data->CategoryType?>','<?php echo $data->Type?>','<?php echo $data->_id?>','')
           //do ajax call
       }
    
    var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
        initializeFileUploader("postupload_<?php   echo $data->_id?>", '/post/upload', '10*1024*1024', extensions,'4','commentTextArea','<?php   echo $data->_id?>',previewImage,appendErrorMessages,"uploadlist_<?php echo $data->_id ?>");
    $(".detailed_close_page").bind('click',function(){
        notificationAjax = false;
         $("[rel=tooltip]").tooltip();
        if(typeof io !== "undefined")
            updateSocketConnect();
        $("#news").removeClass("active");
        if($("#streamMainDiv").length > 0){
            $("#homestream").addClass("active");
        }
        if(fromHeaderNotifications == 2){
             $('#notificationHistory').show();
             $('#notificationHomediv').show();
             if($("#admin_PostDetails").is(':visible')){
                 $("#admin_PostDetails").hide();
                $("#admin_PostDetails").html("");
             }
        }else{   
            if($("#ProfileInteractionDivContent").length > 0){
                $("#streamDetailedDiv").hide();
                $("#ProfileInteractionDivContent").show();
            }
            if($("#admin_PostDetails").is(':visible')){                
               $("#admin_PostDetails").hide();
               $("#admin_PostDetails").html("");
               $("#contentDiv").show();                    
            }
            if($("#newdetaildiv").is(':visible')){
               $("#newdetaildiv").hide();
               $("#newscontentdiv").show();  
               applyLayoutContent();
            }
            if($("#curbsideStreamDetailedDiv").is(":visible")){
                $('#curbsideStreamDetailedDiv').hide();
                $("#curbsidePostCreationdiv").show();
           }
           if($("#streamDetailedDiv").is(":visible"))
           {
               $("#poststreamwidgetdiv").show();
               $("#streamDetailedDiv").hide();
           }
        }
           <?php  if(isset($_REQUEST['layout'])){ ?>
                window.location.href = "/";
              <?php } ?>
                   $("html,body").scrollTop(Global_ScrollHeight);
                   $("[rel=tooltip]").tooltip();
    });
    g_commentPage = 1;
        $("#postDetailedTitle").trigger('click');
         $('.commentbox').append('<style>.commentbox:before{left:126px}</style>');
         $('.commentbox').append('<style>.commentbox:after{left:126px}</style>');
        $("#notificationsdiv").hide();
        Custom.init();
      
        $("#detailedLove").unbind('click');
        $("#detailedLove").bind('click',function(){
            var postId = $(this).attr("data-postid");
            var categoryId = $(this).attr("data-catogeryId");
            var className = $("#detailedLove").attr('class');
            var pType = 0;
            if($.trim(className) == "unlikes"){
                $("#detailedLove").attr("style","");                
                $("#detailedLove").removeClass().addClass("likes");
                var loveCount = Number($("#detailedLoveCount").html());
                loveCount++;
                $("#detailedLoveCount").html(loveCount);
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
//                loveToNewsPost(pType, postId, categoryId,postId);
            }
        });
     $("#news_detailedComment").unbind('click');
        $("#news_detailedComment").bind('click',function(){
            var postId = $(this).attr('data-postid');
            $('.commentbox').append('<style>.commentbox:before{left:126px}</style>');
            $('.commentbox').append('<style>.commentbox:after{left:126px}</style>');
            $("#commentTextArea").html("");
            $("#cId_"+postId).show();
            $("#newComment,#commentbox").show();
            $("#commentartifactsarea_" + postId).hide();
            $("#inviteBox").hide();
            initializationForHashtagsAtMentions('#commentTextArea_'+postId);
        });
    $("#cancelPostCommentButton").unbind('click');
        $("#cancelPostCommentButton").bind('click',function(){
            $("#commentTextArea").html("");
             var postId = $(this).attr('data-postid');
            if($('#commentbox_' + postId).height() >0){
            $('#cId_' + postId).show();
            }else{
            $('#cId_' + postId).show();
            }
            //$("#newComment,#commentDetailedBox").hide();
            $("#commentartifactsarea_"+postId).hide();
            $("#commentTextArea_"+postId).html("");
             $("#commentTextArea_"+postId).addClass('commentplaceholder');
             $("#commentTextArea_"+postId).removeAttr("style");
             $("#commentartifactsarea_" + postId).css("min-height","");
        });
        
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
        $("#newsDetailedwidget .userprofilename_detailed,#newsDetailedwidget .userprofilename").die("click");
        $("#newsDetailedwidget .userprofilename_detailed,#newsDetailedwidget .userprofilename").live("click",function(){
           var userId = $(this).attr('data-id'); 
           var postId = $(this).attr('data-postId');
           getMiniProfile(userId,postId);
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
            }else if($.trim(className) == "follow"){
                followCnt = Number(followCnt)-1;
                $(this).parent('i').parent('a').find('b').children("span").text(followCnt);
                actionType = "UnFollow";
                $("#detailedfolloworunfollow").removeClass().addClass("unfollow");
                   $("#detailedfolloworunfollow").attr("data-original-title","<?php echo Yii::t('translation','Follow'); ?>"); 
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
            followOrUnfollowPost(pType, postId,actionType, categoryId)
        });
        $("#newsDetailedwidget span.at_mention").die("click");
        $("#newsDetailedwidget span.at_mention").live( "click", 
           function(){
               var streamId = $(this).closest('div').attr('data-id');
               var userId = $(this).attr('data-user-id');
               getMiniProfile(userId,streamId);
           }
       );
   //for hashtags
      $("#newsDetailedwidget span.hashtag>b").die( "click");
       $("#newsDetailedwidget span.hashtag>b").live( "click", 
           function(){
               var postId = $(this).closest('div').attr('data-id');

               var hashTagName = $(this).text(); 
               getHashTagProfile(hashTagName,postId);
           }
       );
   
   //for CurbsidecateogryProfile
        $("#newsDetailedwidget a.curbsideCategory").unbind( "click");
     $("#newsDetailedwidget a.curbsideCategory").bind( "click", 
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
        attendEvent(postId,actionType,categoryType, streamId);
    });
    $("#artifactOpen").unbind("click");
      $("#artifactOpen").bind("click",function(){
       
            var postId = $(this).attr("data-uri");
            artifactDownload(postId);
        });
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
   
});
</script>

 <?php } } ?>

