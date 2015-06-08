
<?php include 'miniProfileScript.php'; ?>
<?php include 'hashTagProfileScript.php'; ?>
<?php include 'snippetDetails.php'?>
<?php include 'commentscript.php'; ?>
<?php include 'detailedcommentscript.php'; ?>
<?php include 'commentscript_instant.php'; ?>
<?php include 'inviteScript.php'; ?>
<div id="fromoutside_spinner"></div>
<div id="postDetailedFromouter"></div>
<script type="text/javascript">

    $(document).ready(function() {
        sessionStorage.sharedURL = "";
        $('input[id=UserRegistrationForm_email]').tooltip({'trigger': 'hover'});
        renderOuterPostDetailPage('<?php echo $postId ?>', '<?php echo $categoryType ?>', '<?php echo $postType ?>', '<?php echo $outer; ?>');
    });
    
 function renderOuterPostDetailPage(postId, categoryType, postType,outer) {
        scrollPleaseWait('fromoutside_spinner');
        var URL;
        if(categoryType ==8){
        URL = "/news/renderPostDetailed?postId=" + postId + "&categoryType=" + categoryType + "&postType=" + postType + "&layout="+outer;
        }else if(categoryType ==9){

        URL = "/game/gamedetailed?postId=" + postId + "&categoryType=" + categoryType + "&postType=" + postType + "&layout="+outer;

        }else if(categoryType ==12){
        URL = "/career/renderPostDetailForCareer?id=" + postId + "&categoryType=" + categoryType + "&postType=" + postType + "&layout="+outer;

        }else{

        URL = "/post/renderPostDetailed?postId=" + postId + "&categoryType=" + categoryType + "&postType=" + postType + "&layout="+outer;

        }


        var data="";

        ajaxRequest(URL,data,function(data){renderOuterPostDetailPageHandler(data,categoryType,postId,'admin_PostDetails', 'contentDiv')},"html");

}
function renderOuterPostDetailPageHandler(html,categoryType,postId,showDivId,hideDivId){ 
    scrollPleaseWaitClose('fromoutside_spinner');
          scrollPleaseWaitClose("eventattend_spinner"); 
            if(showDivId=="admin_PostDetails"){
                 $("#" + showDivId).html(html).show();
                    $("#" + hideDivId).hide();
                    $("#rightpanel").hide();
                    return;
            }
        $('body, html').animate({scrollTop : 0}, 0);
}
</script>

