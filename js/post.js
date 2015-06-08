var g_postIds = 0;
var g_postDT = 0;
var g_iv = 0;
var g_streamId = 0;
var g_pflag = 0;
var g_commentPage = 0;
var g_pageType = "";
var setActiveClassPage="";
var g_pageStream="";
/*
 * This method is used for Websnippet preview.
 */
function getsnipet(event, obj) {
    $(".atmention_popup").hide();
    if ($(obj).html().length > 0) {
        removeErrorMessage("NormalPostForm_Description");
    }
  // var urlPattern = "(((https?)\:\/\/)|(www\.))[A-Za-z0-9][A-Za-z0-9.-]+(:\d+)?(\/[^ ]*)?";
  var urlPattern = /\b((?:(http|https)|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[&nbsp;{};:'".,<>?«»“”‘’]|\]|\?))/ig

    var text = $(obj).text();
    var results = text.match(new RegExp(urlPattern));
    if (results && event.keyCode == '32') {
      
          var separators = ['&nbsp;',' ','</br>','<br>'];
var Weburl = results[0].split(new RegExp(separators.join('|'), 'g'));
var weburl=$.trim( Weburl[0] );
           var queryString = {data:weburl,Type:"post"}; 
          // var queryString = {data:Weburl[0],Type:"post"}; 
        ajaxRequest("/post/SnippetpriviewPage", queryString, getsnipetHandler);
    }

}
/*
 * WebSnippet preview handler.
 */
function getsnipetHandler(data) {
    if (data.status == 'success') {
        $('#snippet_main').show();
        var item = {
            'data': data
        };
        $("#snippet_main").html(
                $("#snippetDetailTmpl").render(item)
                );
        var sap=data.snippetdata;
        if(typeof globalspace['IsWebSnippetExistForPost'] == 'undefined' ||  globalspace['IsWebSnippetExistForPost']=='0' ){
            globalspace['IsWebSnippetExistForPost']=1;
        }
        if(typeof globalspace['weburls'] == 'undefined' ||  globalspace['weburls']=='' ||  globalspace['weburls']!='' ){
            globalspace['weburls']=data.snippetdata['Weburl'];
        }
    }

}


function getsnipetForComment(event, obj,commentId){
   
     $(".atmention_popup").hide();
    if ($(obj).html().length > 0) {
        removeErrorMessage("NormalPostForm_Description");
    }
    var urlPattern = /\b((?:(http|https)|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[{};:'".,<>?«»“”‘’]|\]|\?))/ig

    var text = $(obj).text();
    var results = text.match(new RegExp(urlPattern));
      
    if (results && event.keyCode == '32') {
          var separators = ['&nbsp;',' ','</br>','<br>'];
          var Weburl = results[0].split(new RegExp(separators.join('|'), 'g'));
          var weburl=$.trim( Weburl[0] );
          var queryString = 'data=' + weburl+'&CommentId=' + commentId+"&Type=comment";          
          ajaxRequest("/post/SnippetpriviewPage", queryString, function(data){getsnipetForCommentHandler(data,obj,commentId);});
    }

}

function getsnipetForCommentHandler(data,obj,commentId) {
    if (data.status == 'success') {
        $('#snippet_main_'+commentId).show();
        var item = {
            'data': data
        };
        $("#snippet_main_"+commentId).html(
                $("#snippetDetailTmpl").render(item)
                );
        if(typeof globalspace['IsWebSnippetExistForComment_'+commentId] == 'undefined' || globalspace['IsWebSnippetExistForComment_'+commentId]=='0' ){
        globalspace['IsWebSnippetExistForComment_'+commentId]=1;
    }
    
    if(typeof globalspace['CommentWeburls_'+commentId] == 'undefined' ||  globalspace['CommentWeburls_'+commentId]=='' ||  globalspace['CommentWeburls_'+commentId]!='' ){
            globalspace['CommentWeburls_'+commentId]=data.snippetdata['Weburl'];
        }
    
    }
    if($(obj).attr("data-categorytype") == 9 ){
         applyLayout();
    }
    else if( $(obj).attr("data-categorytype") == 8){
        applyLayoutContent();
    }

}

function closeSnippetDiv() {

    $('#snippet_main,#Groupsnippet_main').hide();
    $("#snippet_main,#Groupsnippet_main").html("");
    globalspace['IsWebSnippetExistForPost']=0;
    globalspace['weburls']="";
}

function closeCommentSnippetDiv(commentId) {

    $("#snippet_main_"+commentId).hide();
    $("#snippet_main_"+commentId).html("");
    globalspace['IsWebSnippetExistForComment_'+commentId]=0;
}

/*
 * This function loads in stream page document ready state
 * @author Sagar
 */
function initializationForArtifacts() {
    /**
     * The belo code is used for display the post widgets when click on post div area
     */
    $("#editable").click(function()
    { 
        $("#button_block").show();
        $(this).animate({"min-height": "50px", "max-height": "200px"}, "fast");
        $("#button_block").slideDown("fast");
        $(this).removeClass("placeholder");
        return false;
    });
    /**
     *  The below code is used for dropdown list of post type.
     */
    $("ul[id*=postType] li").click(function() {
        var postType = $(this).attr("data-postType");
        var res = postType.replace(" ", "_");

        var postType = $.trim(postType);
        if (postType == "Event") {
            $('#editable').hide();
            $('#surveydiv').hide();
            $('#eventdiv').show();
            $('#survey_header').hide();
            $("#surveypostdiv").addClass("surveypostdiv");
            $('#editable').show();
            $('#event_header').hide();
            $('#event_header').show();
            $(".timepicker-popup-hour").val('');
            $(".timepicker-popup-minute").val('');
            $('#surveyeventtitledescription').show();
        }
        if (postType == "Survey") {
            $('#editable').hide();
            $('#eventdiv').hide();
            $('#event_header').hide();
            $('#surveydiv').show();
            $('#editable').show();
            $("#surveypostdiv").addClass("surveypostdiv");
            $('#survey_header').hide();
            $('#survey_header').show();
           $('#surveyeventtitledescription').show();
        }
        $('#NormalPostForm_Type').val(postType);
        if (postType == 'Post As Anonymous') {
            $('#editable').hide();
            $('#surveydiv').hide();
            $('#survey_header').hide();
            $('#eventdiv').hide();
            $('#event_header').hide();
            $('#editable').show();
            $("#surveypostdiv").removeClass("surveypostdiv");
            $('#NormalPostForm_Type').val('Anonymous');
            $('#surveyeventtitledescription').hide();
        }
         $('#NormalPostForm_EndTime').val('');

    });
}
/**
 * This method is used for clear the post form when click on clear button
 *  actually we will use formname.rest for clear the form fields but in post form
 *   for post content we are using div.So  for remove inner html of div and artifacts array i used this method.
 * @returns {undefined}
 */
function ClearPostForm() {
    var editorObject = $("#editable.inputor");
    $("#editable").css("min-height", "");
    $("#editable").html(" ");
    $('.idisablecomments').val(0);
    $('.disablecomment').removeClass('enablecomments').addClass('disablecomments');
    $('.disablecomment').attr('data-original-title',Translate_DisableComments);
    $('.iisfeatured').val(0); 
    $('.isdfeatured').removeClass('featureditemenable').addClass('featureditemdisable');
    $('.isdfeatured').attr('data-original-title',Translate_MarkAsFeatured);
       
    $("#normalPost-form")[0].reset();
    clearFileUpload("NormalPostForm");
    $('#e_survey').hide();
    $('#editable').show();
    $('#postTypediv').show();
    $('#surveydiv').hide();
    $('#editable').addClass("placeholder");
    $("#editable").attr("placeholder", Translate_New_Post);
    $('#survey_header').hide();
    $('#eventdiv').hide();
    $('#event_header').hide();
    $("#surveypostdiv").removeClass("surveypostdiv");
    $('#NormalPostForm_Artifacts').val('');
    $('#preview_NormalPostForm').hide();
    $('#previewul_NormalPostForm').hide();
    $('#previewul_NormalPostForm').html('');
    $("#postType li").removeClass('selectpostactive');
    globalspace['hashtag_editable'] = new Array();
    globalspace['at_mention_editable'] = new Array();
    if (document.getElementById("snippet_main")) {
        document.getElementById('snippet_main').style.display = 'none';
        $("#snippet_main").html("");
        $('#postTypediv').hide();
        $('#location_error').html("");
        $('#NormalPostForm_Type').val('');
    }
    $("#button_block").hide();
    globalspace['IsWebSnippetExistForPost']=0;
    globalspace['weburls']="";
     $('#surveyeventtitledescription').hide();

}

/*
 * This function is used to bind the events for stream actions (love, follow, unfollow and comment)
 * @author Sagar
 */
function bindEventsForStream(divId) {

    
    g_pageStream=divId;
 
   
    $("#" + divId + " .moreUsers").live("click",function(){
          auPage = 0;
          auPopupAjax = false;
      //var postId =  $(this).attr("data-postid");
       var id =  $(this).attr("data-postId");
      var actionType =  $(this).attr("data-actiontype");
      var categoryId =  $(this).attr("data-categoryId");
      getActionUsers(id,actionType,'stream',categoryId);
     })
  
     
     
      $("#" + divId + " .streamFollowUnFollowCount,#" + divId + " .streamLoveCount").live("click",function(){
           auPage = 0;
          auPopupAjax = false;
        var id =  $(this).attr("data-postId");
        var count =  $(this).attr("data-count");
          var actionType =  $(this).attr("data-actiontype");
           var categoryId =  $(this).attr("data-categoryId");
         if(count>0){
                   getActionUsers(id,actionType,'stream',categoryId);
  
         }
     })
     
      var userActionTimeout;
        $("#" + divId + " .userView,#" + divId + " .streamFollowUnFollowCount").live("mouseover",function( event ) {
        clearTimeout(userActionTimeout) ;
            var postId =  $(this).attr("data-postId");
             var count =  $(this).attr("data-count");
        // console.log('mouseover');
         
       if(count>0 && $.trim($("#userFollowView_"+postId).html()).length!=0)   {
            if($("#userFollowView_"+postId).is(':visible') == false){
             $(".userView,.userLoveView").hide();
              $("#userFollowView_"+postId).show();
         }
     }
       
        });
     
       $("#" + divId + " .userLoveView,#" + divId + " .streamLoveCount").live("mouseover",function( event ) {
      //  alert('dd');
           clearTimeout(userActionTimeout) ;
           var postId =  $(this).attr("data-postId");
           var count =  $(this).attr("data-count");
        if(count>0 && $.trim($("#userLoveView_"+postId).html()).length!=0)   {
         if($("#userLoveView_"+postId).is(':visible') == false){
             $(".userView,.userLoveView").hide();
              $("#userLoveView_"+postId).show();
         }
     }
        });
   
        
        
             $("#" + divId + " .streamFollowUnFollowCount,#" + divId + " .streamLoveCount").live("mouseout",function( event ) { 
             userActionTimeout =  setTimeout(function(){
                 
                   $(".userView,.userLoveView").hide();
             },500);
         
        });
         $("#" + divId + " .userView,#" + divId + " .userLoveView").live("mouseout",function( event ) { 
           $(".userView,.userLoveView").hide();
        });
   
         

    $("#" + divId + " input.translatebutton").live("click",
        function() {
             if($(this).hasClass( "postdetail" )){
                 globalspace.translate = 1;
                 return false;
             }
            var obj = $(this);
            var postType = Number($.trim($(obj).attr('data-postType')));
            if(postType==12 && divId!="streamMainDiv"){
                translateGameData(obj);
            }else{
                translatePostData(obj);
            }
        }
    );
    $("#" + divId + " input.commenttranslatebutton").live("click",
        function() { 
            var obj = $(this);
            translateCommentData(obj);
        }
    );

    $("#" + divId + " img.follow").live("click",
            function() { 
                var categoryType = $(this).closest('div.social_bar').attr('data-categoryType');               
                var iframeMode = $(this).closest('div.social_bar').attr('data-iframemode');
                if(typeof iframeMode != 'undefined'){
                    if(iframeMode.length==1){
                        iframeMode = Number(iframeMode);
                    }
                }else{
                    iframeMode = 'iframeMode';
                }
                var followCnt = Number($(this).parent('i').parent('a').find('b').children("span").text());
                followCnt = Number(followCnt)-1;
                $(this).parent('i').parent('a').find('b').children("span").text(followCnt);
                $(this).attr({
                    "class": "unfollow",
                    "data-original-title": "Follow"
                });
                if (Number(categoryType) < 3 || iframeMode==1) {
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var postType = $(this).closest('div.social_bar').attr('data-postType');
                    followOrUnfollowPost(postType, postId, "UnFollow", categoryType,$(this));
                } 

                else if (Number(categoryType) == 3 ) 
                 {
                    if(divId=="streamMainDiv"){ 
                        var streamId = $(this).closest('div.social_bar').attr('data-id');
                        var groupId = $(this).closest('div.social_bar').attr('data-groupid');
//                        followOrUnfollowGroup(groupId, "UnFollow",$(this),$('#group_followers_count_' + streamId));
//                        var groupFollowersCount = Number($('#group_followers_count_' + streamId).text());
//                        groupFollowersCount--;
//                        $('#group_followers_count_' + streamId).text(groupFollowersCount);
                        var postId = $(this).closest('div.social_bar').attr('data-postid');
                        var postType = $(this).closest('div.social_bar').attr('data-postType');
                        followOrUnfollowPost(postType, postId, "UnFollow", categoryType,$(this));
                       //  var groupFollowersCount = Number($('#group_followers_count_' + streamId).text());
                       // groupFollowersCount--;
                       // $('#group_followers_count_' + streamId).text(groupFollowersCount); 
                    }else{
                        var postId = $(this).closest('div.social_bar').attr('data-postid');
                        var postType = $(this).closest('div.social_bar').attr('data-postType');
                        followOrUnfollowPost(postType, postId, "UnFollow", categoryType,$(this));
                    }
                } 
                 else if ( Number(categoryType) == 7) 
                 {
                    if(divId=="streamMainDiv"){ 
                        var streamId = $(this).closest('div.social_bar').attr('data-id');
                        var groupId = $(this).closest('div.social_bar').attr('data-groupid');
                        var subgroupId = $(this).closest('div.social_bar').attr('data-subgroupid');                        
                        followOrUnfollowSubGroup(groupId, "UnFollow",$(this),$('#group_followers_count_' + streamId),subgroupId);
                       // var groupFollowersCount = Number($('#group_followers_count_' + streamId).text());
                       // groupFollowersCount--;
                       // $('#group_followers_count_' + streamId).text(groupFollowersCount);
                    }else{
                        
                        var pageType=$(this).closest('div.social_bar').attr('data-pagetype');                        
                        
                        if(pageType=='Group'){
                            var streamId = $(this).closest('div.social_bar').attr('data-id');
                        var groupId = $(this).closest('div.social_bar').attr('data-groupid');
                        var subgroupId = $(this).closest('div.social_bar').attr('data-subgroupid');                           
                        followOrUnfollowSubGroup(groupId, "UnFollow",$(this),$('#group_followers_count_' + streamId),subgroupId);
                       // var groupFollowersCount = Number($('#group_followers_count_' + streamId).text());
                       // groupFollowersCount--;
                       // $('#group_followers_count_' + streamId).text(groupFollowersCount);
                        }else{
                        var postId = $(this).closest('div.social_bar').attr('data-postid');
                        var postType = $(this).closest('div.social_bar').attr('data-postType');
                        followOrUnfollowPost(postType, postId, "UnFollow", categoryType,$(this));
                        }
                        
                    }
                }
                  else if (Number(categoryType) == 6) 
                 {//curbside category 
                       var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var streamId = $(this).closest('div.social_bar').attr('data-id');
                    var catgoryId = $(this).closest('div.social_bar').attr('data-curbsidecategoryid');
                     followUnfollowCategoryStream(catgoryId, "UnFollow",$(this),$('#curbside_followers_count_' + streamId));
                   // var curbsideFollowersCount = Number($('#curbside_followers_count_' + streamId).text());
                   // curbsideFollowersCount--;
                   // $('#curbside_followers_count_' + streamId).text(curbsideFollowersCount);
                } 
                  else if (Number(categoryType) == 5) 
                 {
                     //hashtag follow
                       var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var streamId = $(this).closest('div.social_bar').attr('data-id');
                    var groupId = $(this).closest('div.social_bar').attr('data-curbsidecategoryid');
                    followUnfollowHashTagStream(groupId, "UnFollow",$(this),$('#hashtag_followers_count_' + streamId));
                    //var hashtagFollowersCount = Number($('#hashtag_followers_count_' + streamId).text());
                   // hashtagFollowersCount--;
                   // $('#hashtag_followers_count_' + streamId).text(hashtagFollowersCount);
                } 
                else if (Number(categoryType) == 8) 
                 {//curbside category 
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var postType = $(this).closest('div.social_bar').attr('data-postType');
                     followOrUnfollowPost(postType, postId, "UnFollow", categoryType,$(this));
                    
                } 
                else if (Number(categoryType) == 9) 
                 {//Game
                     
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var postType = $(this).closest('div.social_bar').attr('data-postType');
                     followOrUnfollowPost(postType, postId, "UnFollow", categoryType,$(this));
                    
                } else if (Number(categoryType) == 12) 
                 {//Game
                     
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var postType = $(this).closest('div.social_bar').attr('data-postType');
                     followOrUnfollowPost(postType, postId, "UnFollow", categoryType,$(this));
                    
                } 
                 var html = $("#userFollowView_" +postId).html();
                 html = html.replace("You<br>", ""); 
                 $("#userFollowView_" +postId).html(html);
                 
                  $(this).parent('i').next('b').attr("data-count",followCnt);
                 $("#userFollowView_" +postId).attr("data-count",followCnt);
                 
               //trackEngagementAction("UnFollow",postId,categoryType,postType); 
            }
    );
    $("#" + divId + " img.unfollow").live("click",
            function() { 
                var categoryType = $(this).closest('div.social_bar').attr('data-categoryType');
                var iframeMode = $(this).closest('div.social_bar').attr('data-iframemode');
               if(typeof iframeMode != 'undefined'){
                    if(iframeMode.length==1){
                        iframeMode = Number(iframeMode);
                    }
                }else{
                    iframeMode = 'iframeMode';
                }
                var followCnt = Number($(this).parent('i').parent('a').find('b').children("span").text());
                followCnt = Number(followCnt)+1;
                $(this).parent('i').parent('a').find('b').children("span").text(followCnt);
                 $(this).attr({
                    "class": "follow",
                   // "title": "Unfollow"
                   "data-original-title": "Unfollow"
                });
                if (Number(categoryType) < 3 || iframeMode==1) {
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var postType = $(this).closest('div.social_bar').attr('data-postType');
                    followOrUnfollowPost(postType, postId, "Follow", categoryType,$(this));
                } 
                    else if (Number(categoryType) == 3 ) 
                 {
                    if(divId=="streamMainDiv"){ 
                     var streamId = $(this).closest('div.social_bar').attr('data-id');
                    var groupId = $(this).closest('div.social_bar').attr('data-groupid');
//                   followOrUnfollowGroup(groupId, "Follow",$(this),$('#group_followers_count_' + streamId));
//                    var groupFollowersCount = Number($('#group_followers_count_' + streamId).text());
//                    groupFollowersCount++;
                 //   $('#group_followers_count_' + streamId).text(groupFollowersCount);
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                        var postType = $(this).closest('div.social_bar').attr('data-postType');
                        followOrUnfollowPost(postType, postId, "Follow", categoryType,$(this));
                      //  var groupFollowersCount = Number($('#group_followers_count_' + streamId).text());
                      // groupFollowersCount++;
                     // $('#group_followers_count_' + streamId).text(groupFollowersCount);
                    }else{
                        var postId = $(this).closest('div.social_bar').attr('data-postid');
                        var postType = $(this).closest('div.social_bar').attr('data-postType');
                        followOrUnfollowPost(postType, postId, "Follow", categoryType,$(this));
                    }
                }else if(Number(categoryType) == 7){  
                    if(divId=="streamMainDiv"){                         
                     var streamId = $(this).closest('div.social_bar').attr('data-id');
                    var groupId = $(this).closest('div.social_bar').attr('data-groupid');
                    var subgroupId = $(this).closest('div.social_bar').attr('data-subgroupid');                    
                    followOrUnfollowSubGroup(groupId, "Follow",$(this),$('#group_followers_count_' + streamId),subgroupId);
                    var groupFollowersCount = Number($('#group_followers_count_' + streamId).text());
                    groupFollowersCount++;
                    $('#group_followers_count_' + streamId).text(groupFollowersCount);
                    }else{
                        var pageType=$(this).closest('div.social_bar').attr('data-pagetype');
                        if(pageType=='Group'){
                            var streamId = $(this).closest('div.social_bar').attr('data-id');
                        var groupId = $(this).closest('div.social_bar').attr('data-groupid');
                        var subgroupId = $(this).closest('div.social_bar').attr('data-subgroupid');                        
                        followOrUnfollowSubGroup(groupId, "Follow",$(this),$('#group_followers_count_' + streamId),subgroupId);
                        var groupFollowersCount = Number($('#group_followers_count_' + streamId).text());
                        groupFollowersCount++;
                        $('#group_followers_count_' + streamId).text(groupFollowersCount);
                        }else{
                        var postId = $(this).closest('div.social_bar').attr('data-postid');
                        var postType = $(this).closest('div.social_bar').attr('data-postType');
                        followOrUnfollowPost(postType, postId, "Follow", categoryType,$(this));
                        }
                    }
                }  
                
                
                 else if (Number(categoryType) == 6) 
                 {//curbside category 
                        var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var streamId = $(this).closest('div.social_bar').attr('data-id');
                    var catgoryId = $(this).closest('div.social_bar').attr('data-curbsidecategoryid');
                     followUnfollowCategoryStream(catgoryId, "Follow",$(this),$('#curbside_followers_count_' + streamId));
                   // var curbsideFollowersCount = Number($('#curbside_followers_count_' + streamId).text());
                   // curbsideFollowersCount++;
                   // $('#curbside_followers_count_' + streamId).text(curbsideFollowersCount);
                } 
                  else if (Number(categoryType) == 5) 
                 {
                     //hashtag follow
                       var postId = $(this).closest('div.social_bar').attr('data-postId');
                    var streamId = $(this).closest('div.social_bar').attr('data-id');
                    var groupId = $(this).closest('div.social_bar').attr('data-curbsidecategoryid');
                    followUnfollowHashTagStream(groupId, "Follow",$(this),$('#hashtag_followers_count_' + streamId));
                   // var hashtagFollowersCount = Number($('#hashtag_followers_count_' + streamId).text());
                   // hashtagFollowersCount++;
                   // $('#hashtag_followers_count_' + streamId).text(hashtagFollowersCount);
                } 
                else if (Number(categoryType) == 8) 
                 {//curbside category 
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var postType = $(this).closest('div.social_bar').attr('data-postType');
                     followOrUnfollowPost(postType, postId, "Follow", categoryType,$(this));
                    
                } 
                else if (Number(categoryType) == 9) 
                 {//Game                     
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var postType = $(this).closest('div.social_bar').attr('data-postType');
                     followOrUnfollowPost(postType, postId, "Follow", categoryType,$(this));
                    
                }
                 else if (Number(categoryType) == 10) 
                 {//Game                     
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var postType = $(this).closest('div.social_bar').attr('data-postType');
                     followOrUnfollowPost(postType, postId, "Follow", categoryType,$(this));
                    
                }else if (Number(categoryType) == 12) 
                 {//Game                     
                    var postId = $(this).closest('div.social_bar').attr('data-postid');
                    var postType = $(this).closest('div.social_bar').attr('data-postType');
                     followOrUnfollowPost(postType, postId, "Follow", categoryType,$(this));
                    
                }
                  $("#userFollowView_" +postId).prepend("You<br/>");
                    $(this).parent('i').next('b').attr("data-count",followCnt);
                 $("#userFollowView_" +postId).attr("data-count",followCnt);
                 //trackEngagementAction("Follow",postId,categoryType,postType);
            }
    );
    
    $("#" + divId + " img.unlikes").live("click",
            function() { 
              
                var postId = $(this).closest('div.social_bar').attr('data-postid');
                var postType = $(this).closest('div.social_bar').attr('data-postType');
                var categoryType = $(this).closest('div.social_bar').attr('data-categoryType');
                var streamId = $(this).closest('div.social_bar').attr('data-id');
                $(this).closest('div.social_bar').attr({
                });
                var loveCnt = Number($(this).parent('i').next('b').children("span").text());
                 loveCnt++;
                $(this).parent('i').next('b').children("span").text(loveCnt);
                $(this).parent('i').next('b').attr("data-count",loveCnt);
                 $("#userLoveView_" +postId).attr("data-count",loveCnt);
                 $("#userLoveView_" +postId).prepend("You<br/>");
                
                
                 loveToPost(postType, postId, categoryType,streamId,$(this));
          $(this).attr({
                    "class": "likes"
                });
                 //trackEngagementAction("Love",postId,categoryType,postType);
            }
    );
    $("#" + divId + " img.comments,#" + divId + " img.commented").live("click",
            function() {                 
                var postId = $(this).closest('div.social_bar').attr('data-postid');
                var streamId = $(this).closest('div.social_bar').attr('data-id');
                  var postType = $(this).closest('div.social_bar').attr('data-postType');
                var categoryType = $(this).closest('div.social_bar').attr('data-categoryType');
                var cmntcnt = Number($("#commentCount_" +postId).html());
                
                if(categoryType!=3  ||categoryType!=7 ){                
                 initializationForHashtagsAtMentions('#commentTextArea_' + streamId);    
                }
                
                if($('#Invite_' + streamId).length>0){
                    $('#Invite_' + streamId).hide();
                }
                
                $('#commentTextArea_' + streamId).html('');
                $('#commentTextArea_' + streamId).show();
               
                clearFileUpload("commentTextArea_" + streamId);
                $('.imgpreview').each(function() {
                    $(this).html('');
                });
                var commentLeft = $(this).position().left;
                if(divId!='g_mediapopup'){
                    $('.commentbox').append('<style>.commentbox:before{left:'+commentLeft+'px}</style>');
                    $('.commentbox').append('<style>.commentbox:after{left:'+commentLeft+'px}</style>');
                }
                $('#cId_' + streamId).show();
                $('#newComment_' + streamId).show();
                
                if(cmntcnt >2){
                     $('#viewmorecomments_' + streamId).css('display','block');
                }else{
                    //$('#viewmorecomments_' + streamId).hide();
                    if(categoryType == 8 ){
                        applyLayoutContent();
                        OpenCommentbuttonArea(postId,categoryType);
                     }else if( categoryType == 9){
                         OpenCommentbuttonArea(streamId,categoryType);
                         applyLayout();
                     }else{
                      OpenCommentbuttonArea(postId,categoryType);   
                     }
                      
                     $('#viewmorecomments_' + streamId).css('display','none');
                }
                
                if(cmntcnt >0 && divId != "curbsidePostsDiv"){ //don't load for curbside... -- changes in the comment enhancements...
                   getPostRecentComments('/post/getpostRecentComments',postId,streamId,categoryType);  
                }
                if(divId == "curbsidePostsDiv"){ //changes in the comment enhancements...                    
                    OpenCommentbuttonArea(streamId,categoryType); 
                }
                 if(categoryType==9){
                    applyLayout();
                }
                $("#commentTextArea_"+streamId).focus();
                 //trackEngagementAction("Comment",postId,categoryType,postType);
            }
    );
    $("#" + divId + " img.invite_frds").live("click",
            function() {
                var StreamId = $(this).closest('div.social_bar').attr('data-id');
                var PostId = $(this).closest('div.social_bar').attr('data-postid');
                var NetworkId = $(this).closest('div.social_bar').attr('data-networkId');
                var CategoryType = $(this).closest('div.social_bar').attr('data-categoryType');
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
                $("#myModalLabel").html(Translate_Invite_Others);
                $("#myModal_footer").hide();
                $("#myModal").modal('show');
                
                if(CategoryType==3 || CategoryType==7){
                    var isPrivateGroup = $(this).closest('div.social_bar').attr('data-IsPrivate');
                    var groupId = $(this).closest('div.social_bar').attr('data-groupid');                    
                    if(Number(isPrivateGroup)){
                     initializeAtMentionsForPrivateGroup('#inviteTextBox_' + StreamId, PostId, Number(CategoryType),groupId)    
                    }
                    else{
                    initializeAtMentions('#inviteTextBox_' + StreamId, PostId, Number(CategoryType),groupId);    
                    }
                
                }else{
                  initializeAtMentions('#inviteTextBox_' + StreamId, PostId, Number(CategoryType));    
                }
                
                // this code is commented by  Haribabu for don't show the already invited members in invite other popup
               // getInvitedUsersForPost(PostId, CategoryType);
            }
    );
    $("#" + divId + " img.share, #" + divId + " img.sharedisable").live("click touchstart",
            function() {
                var postId = $(this).closest('div.social_bar').attr('data-postid');
                var shareLeft = $(this).position().left;
                var sharesectionWidth = $(this).closest('span.sharesection').find('div.actionmorediv').width()/2;
                $(this).closest('span.sharesection').find('div.actionmorediv').css('left',shareLeft-sharesectionWidth+14);
            }
    );

    //for user display names
    $("#" + divId + " .inputor").live("click",
            function() {
                var categoryType = $(this).data('categorytype');
                $(this).removeClass("commentplaceholder");
                $(this).removeClass("placeholder");
                if(categoryType != 8)
                    $(this).animate({"min-height": "50px", "max-height": "200px"}, "fast");
                else if(categoryType==9){
                    applyLayout()
                    $(this).attr({"min-height": "200px"});
                }else{
                     applyLayoutContent()
                    $(this).attr({"min-height": "200px"});
                }
            }
    );
    //for user display names
    $("#" + divId + " a.userprofilename").live("click",
            function() {
                var postId = $(this).attr('data-streamId');
                var userId = $(this).attr('data-id');
                getMiniProfile(userId,postId);
                trackEngagementAction("ProfileMinPopup",userId);
            }
    );
    //for mentions
    $("#" + divId + " span.at_mention").live("click",
            function() {                
                var streamId = $(this).closest('div').attr('data-id');
                var userId = $(this).attr('data-user-id');
                var postId = $(this).closest('div').attr('data-postid');
                var postType = $(this).closest('div').attr('data-posttype');
                var categoryType = $(this).closest('div').attr('data-categoryType');
                if (divId == 'streamMainDiv') {
                    if (categoryType != 2) {
                        getMiniProfile(userId, streamId);
                    } else {
                        g_streamId = streamId;
                        DetailPageDisplay(postId, categoryType, postType, divId);
                    }
                } else {
                    getMiniProfile(userId, streamId);
                }
                if(categoryType==3){
                    var dataId = $(this).closest('div').attr('data-groupid'); 
                }else if(categoryType==7){
                    var dataId = $(this).closest('div').attr('data-subgroupid'); 
                }else if(categoryType==8){
                    var dataId = $(this).closest('div').attr('data-id'); 
                }else{
                   var dataId = userId; 
                }
                
                trackEngagementAction("MentionMinPopup", dataId, categoryType);                
            }
    );


    //for mentions
    $("#" + divId + " a.curbsideCategory").live("click",
            function() {
                var categoryId = $(this).attr('data-id');
                var streamId = $(this).parent('span').attr('data-id');
                getMiniCurbsideCategoryProfile(categoryId,streamId);
                trackEngagementAction("CurbCategoryMinPopup",'',categoryId);
            }
    );

    //for hashtags
    $("#" + divId + " span.hashtag>b").live("click",
            function() {
                var streamId = $(this).closest('div').attr('data-id');
                var hashTagName = $(this).text();

                var parentTag = $( this ).parent().get(0).tagName;
                var postId = $(this).closest('div').attr('data-postid');
                var postType = $(this).closest('div').attr('data-posttype');                
                var categoryType = $(this).closest('div').attr('data-categoryType');               
                if (divId == 'streamMainDiv') {
                    if (categoryType != 2) {
                        getHashTagProfile(hashTagName,streamId,categoryType); 
                    } else {
                        g_streamId = streamId;
                        DetailPageDisplay(postId, categoryType, postType, divId);
                    }
                } else {
                    getHashTagProfile(hashTagName,streamId,categoryType); 
                }
            }
                  
    );
    $("button.eventAttend").die();
    $("button.eventAttend").live("click", function() {
        var postId = $(this).closest('div.post_widget').attr('data-postid');
        var streamId = $(this).closest('li.media').find('div.social_bar').attr('data-id');
        var categoryType = $(this).attr('data-categoryType');
        var actionType = $(this).attr('name');
        if (typeof streamId == 'undefined' || streamId == "") {
            streamId = postId;
        } 
        attendEvent(postId, actionType, categoryType, streamId);
    });
    $("#" + divId + " post item isotope-item").live("click", function() {
        $(this).css("padding-bottom", "20px");
    });

    $("#" + divId + " .PostManagementActions a.delete").live("click touchstart", function() {
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var modelType = 'error_modal';
        var title = Translate_Delete;
        var content = Translate_Are_you_sure_you_want_to_delete;
        var closeButtonText = Translate_NO;
        var okButtonText = Translate_Yes;
        var okCallback = deleteCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").show();
    });
     $("#" + divId + " .PostManagementActions a.suspend").live("click touchstart", function() {
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var modelType = 'error_modal';
        var title = Translate_Delete;
        var content = Translate_Are_you_sure_you_want_to_suspend_this_game;
        var closeButtonText = Translate_NO;
        var okButtonText = Translate_Yes;
        var okCallback = deleteCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").show();
    });
    $("#" + divId + " .PostManagementActions a.promote").live("click touchstart", function() {
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');        
        var modelType = 'info_modal';
        var title = Translate_Promote;
        var content = $('#promoteCalcDiv').clone().find('div.promoteCalc').attr('id', 'promoteCalc_' + streamId).end().find('input.promoteInput').attr('id', 'promoteInput_' + streamId).end().html();
        var closeButtonText = Translate_Close;
        var okButtonText = Translate_Promote;
        var okCallback = promoteCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").hide();
        $("#newModal_btn_primary").attr('disabled', 'disabled');
        $("#newModal_btn_primary").addClass('disabled');
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var expirydate = "";
        if ($(this).closest('.post_widget').find('li time.icon').length > 0) {
            var datesLength = $(this).closest('.post_widget').find('li time.icon').length;
            expirydate = $(this).closest('.post_widget').find('li:nth-child(' + datesLength + ') time.icon').attr('datetime');
            var dateArray = expirydate.split("-");
            expirydate = new Date(dateArray[0], dateArray[1] - 1, dateArray[2], 0, 0, 0, 0);
        }
        var checkin = $('#promoteCalc_' + streamId).datepicker({
            orientation: 'right',
            onRender: function(date) {
                $('.datepicker').css('z-index', 1060);
                return date.valueOf() < now.valueOf() ? 'disabled' : (expirydate != "" && date.valueOf() > expirydate.valueOf() ? 'disabled' : '');
            }
        }).on('changeDate', function(ev) {
            $('.datepicker').hide();
            $("#newModal_btn_primary").removeAttr('disabled');
            $("#newModal_btn_primary").removeClass('disabled');
        });
    });
     $("#" + divId + " .PostManagementActionsFooter .promoteicon").live("click", function() {
        var streamId = $(this).closest('ul.PostManagementActionsFooter').attr('data-streamId');        
        var postId = $(this).closest('ul.PostManagementActionsFooter').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActionsFooter').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActionsFooter').attr('data-networkId');        
        var modelType = 'info_modal';
        var title = Translate_Promote;
        var content = $('#promoteCalcDiv').clone().find('div.promoteCalc').attr('id', 'promoteCalc_' + streamId).end().find('input.promoteInput').attr('id', 'promoteInput_' + streamId).end().html();
        var closeButtonText = Translate_Close;
        var okButtonText = Translate_Promote;
        var okCallback = promoteCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").hide();
        $("#newModal_btn_primary").attr('disabled', 'disabled');
        $("#newModal_btn_primary").addClass('disabled');
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var expirydate = "";
        if ($(this).closest('.post_widget').find('li time.icon').length > 0) {
            var datesLength = $(this).closest('.post_widget').find('li time.icon').length;
            expirydate = $(this).closest('.post_widget').find('li:nth-child(' + datesLength + ') time.icon').attr('datetime');
            var dateArray = expirydate.split("-");
            expirydate = new Date(dateArray[0], dateArray[1] - 1, dateArray[2], 0, 0, 0, 0);
        }
        var checkin = $('#promoteCalc_' + streamId).datepicker({
            orientation: 'right',
            onRender: function(date) {
                $('.datepicker').css('z-index', 1060);
                return date.valueOf() < now.valueOf() ? 'disabled' : (expirydate != "" && date.valueOf() > expirydate.valueOf() ? 'disabled' : '');
            }
        }).on('changeDate', function(ev) {
            $('.datepicker').hide();
            $("#newModal_btn_primary").removeAttr('disabled');
            $("#newModal_btn_primary").removeClass('disabled');
        });
    });
    
     $("#" + divId + " .PostManagementActions a.saveitforlater").live("click", function() {
        
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');        
         var postType = $(this).closest('ul.PostManagementActions').attr('data-postType');
        var modelType = 'info_modal';
      
        var title = 'Save it for later';
        var content = "Are you sure you want to save it for later?";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var okCallback = saveitforlaterCallback;
        
       
        var param = '' + streamId + ',' + postId + ',' + categoryType +  ','+ networkId+ ',' + 'postDetail' + ',' + postType+'';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param,$(this));
        $("#newModal_btn_close").show();
    });
    
    $("#" + divId + " .PostManagementActions a.abuse").live("click touchstart", function() {
        var actionType = "Abuse";
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var modelType = 'error_modal';
        var title = Translate_Flag_as_abuse;
        var content = Translate_flag_this_message_as_inappropriate;
        var closeButtonText = Translate_NO;
        var okButtonText = Translate_Yes;
        var okCallback = abuseCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId + ',' + actionType + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").show();
    });
    $(".CommentManagementActions a.abuse").live("click touchstart", function() {
        var modelType = 'error_modal';
        var title = 'Flag as Abuse';
        var content = "Are you sure you want to flag this message as inappropriate?";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var okCallback = abuseComment;
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, $(this));
        $("#newModal_btn_close").show();
    });
    
    
        $("#" + divId + " .PostManagementActions a.suspend").live("click touchstart", function() {
        var actionType = "Suspend";
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var modelType = 'error_modal';
        var title = Translate_Suspend;
        var content = Translate_Are_you_sure_you_want_to_suspend_this_game;
        var closeButtonText = Translate_NO;
        var okButtonText = Translate_Yes;
        var okCallback = suspendCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId + ',' + actionType + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").show();
    });
    
         $("#" + divId + " .PostManagementActions a.release").live("click touchstart", function() {
        var actionType = "Release";
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var modelType = 'error_modal';
        var title = Translate_Release;
        var content = Translate_release_this_game;
        var closeButtonText = Translate_NO;
        var okButtonText = Translate_Yes;
        var okCallback = suspendCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId + ',' + actionType + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").show();
    });
    
       $("#" + divId + " .cancelschedule").live("click", function() {
        var actionType = "CancelSchedule";
        var streamId = $(this).attr('data-streamId');
        var postId = $(this).attr('data-postId');
        var categoryType = $(this).attr('data-categoryType');
        var scheduleId = $(this).attr('data-scheduleId');
        var modelType = 'error_modal';
        var title = Translate_Cancel_Schedule;
        var content = Translate_cancel_scheduling_game;
        var closeButtonText = Translate_NO;
        var okButtonText = Translate_Yes;
        var okCallback = cancelScheduleCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + scheduleId + ',' + actionType + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").show();
    });
    

    $("#" + divId + " .postdetail,  .postdetail_news").live("click touchstart",
        function() { 
            minimizeJoyride()
           var categoryType = $(this).attr('data-categoryType'); 
            if (categoryType != 12){
            if (Number(categoryType) == 9) {
                if(divId=="streamMainDiv"){
                    var gameName = $('#gameBtn').attr('data-gameName');
                    
                 var scheduleId = $('#gameBtn').attr('data-gameScheduleId');
                 var mode = $('#gameBtn').attr('data-mode');
                   window.location='/'+gameName+'/'+scheduleId+'/detail/game'; 
                }else{
               var gameId = $(this).attr('data-id');                
               var gameName = $('#gameName_'+gameId).text();
               var scheduleId = $('#gameBtnWall_'+gameId).attr('data-gameScheduleId');
                 window.location='/'+gameName+'/'+scheduleId+'/detail/game'; 
                }
                
                
                
                
                 
              
            }
            var streamId = $(this).data('id');
            g_streamId = streamId;
            g_pageType = divId;
            if(divId == "groupstreamMainDiv" || divId == "g_mediapopup" ){
                g_pageType = gType;
            }
            Global_ScrollHeight = $(document).scrollTop();
            //$('body, html').animate({scrollTop : 0}, 0);
            var postId = $(this).attr('data-postid');
            var categoryType = $(this).attr('data-categoryType');
            var postType = $(this).attr('data-postType');
            if(categoryType==8)
            {
                var newsId = $(this).data('id');
                var showDivId,
                    hiddenDivId;
                if(divId == "ProfileInteractionDivContent"){
                     showDivId = "streamDetailedDiv",
                     hiddenDivId = "ProfileInteractionDivContent";
                }else{
                    showDivId = "streamDetailedDiv",
                    hiddenDivId = "poststreamwidgetdiv";
                }      
                setActiveClassPage = "news";
                renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
            }
            else
            {
                DetailPageDisplay(postId, categoryType, postType,divId);
            }
            trackEngagementAction("PostDetailOpen",postId,categoryType,postType);
     

        }else if(categoryType == 12){
            var profileURL = $(this).data("profile");
            window.location.href = profileURL;
        }

    }
    );
    
     $("#"+divId+" .PostManagementActions a.featured").live("click touchstart",function(){ 
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var modelType = 'error_modal';  
        var type='Featured';
    var queryString = "postId="+postId+"&categoryType="+categoryType+"&networkId="+networkId+"&type="+type; 
        var modelType = 'info_modal';
        var title = 'Post Featured Item';
        var content = "<label>Featured Item Title<label><div class='row-fluid'> \
                       <input class='textfield span12' type='text' id='featured_"+postId+"' maxlength='100' /> </div>\n\
                       <div class='control-group controlerror'> <div style='display: none;' id='featured_error_"+postId+"' class='errorMessage'>Featured Item Title cannot be blank</div> </div>";
        var closeButtonText = 'Close';
        var okButtonText = 'Submit';
        var okCallback = featuredItemCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + queryString + ',MarkPostAsFeaturedtHandler'+'';
         openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);

    });
    $("#"+divId+" .PostManagementActionsFooter .featuredicon").live("click",function(){
        var streamId = $(this).closest('ul.PostManagementActionsFooter').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActionsFooter').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActionsFooter').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActionsFooter').attr('data-networkId');
        var modelType = 'error_modal';  
        var type='Featured';
    var queryString = "postId="+postId+"&categoryType="+categoryType+"&networkId="+networkId+"&type="+type;
            var modelType = 'info_modal';
        var title = 'Post Featured Item';
        var content = "<label>Featured Item Title<label> <div class='row-fluid'>\
                       <input class='textfield span12' type='text' id='featured_"+postId+"' maxlength='100' /></div>\n\
                       <div class='control-group controlerror'> <div style='display: none;' id='featured_error_"+postId+"' class='errorMessage'>Featured Item Title cannot be blank</div> </div>";
        var closeButtonText = 'Close';
        var okButtonText = 'Submit';
        var okCallback = featuredItemCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + queryString + ',MarkPostAsFeaturedtGameHandler'+'';
         openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
    });

    $("#" + divId + " .PostManagementActions.abusedPosts li>a").live("click", function() {
        var actionType = $(this).attr('name');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var isBlockedPost = $(this).closest('ul.PostManagementActions').attr('data-isBlocked'); 
        var modelType = 'error_modal';
        var title = actionType;
        var content = "Are you sure you want to "+actionType+" this post?";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var okCallback = blockOrReleaseCallback;
        var param = ''+postId+','+categoryType+','+networkId+','+actionType+','+isBlockedPost+'';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
    });
    
    $("ul.PostManagementActionsFilter li a").live("click", function() {
    var filterString = $(this).attr('class');
    scrollPleaseWait('postSpinLoader');
    $(window).unbind("scroll");
    $('ul.PostManagementActionsFilter li').removeClass('active');
    $(this).parent().addClass('active');
    page = 1;
    isDuringAjax=false;
    $('#streamMainDiv').empty();
    
    if(filterString!="Filter"){
        getCollectionData('/post/stream', 'filterString='+filterString+'&StreamPostDisplayBean', 'streamMainDiv', 'No Posts found.','That\'s all folks!');
    }else{
        getCollectionData('/post/stream', 'StreamPostDisplayBean', 'streamMainDiv', 'No Posts found.','That\'s all folks!');
    }
     
    });
    
    /** this is for Group DEtail page **/
    $("#groupShortDescription").live("click",
            function() {
                var groupName = $(this).attr('data-groupName');                
                window.location="/"+groupName;
            }
    );
    $(".videoimage").die();
    $(".videoimage").live('click touchstart',function(){
        var streamId = $(this).data('id');                
        var postId = $(this).attr('data-postid');
        var categoryType = $(this).attr('data-categoryType');
        var postType = $(this).attr('data-postType');
        var uri = $(this).attr('data-videoimage');
        var videoImage = $(this).data("vimage");
        if(detectDevices()){            
            $("#playerClose_"+streamId).removeClass("img_single").addClass("img_single_mobile").show();
        }else{
            $("#playerClose_"+streamId).removeClass().addClass("img_single pull-left img_single_mobile").show();
        }
        
        //scrollPleaseWait('stream_view_detailed_spinner_'+postId);
        $("#imageVideomp3_"+streamId).hide();        
        
        $(this).removeClass("img_single");
         if ($('#img_streamVideoDiv'+streamId).length > 0 ){
                $('#img_streamVideoDiv'+streamId).removeClass('videoThumnailDisplay');
               $('#img_streamVideoDiv'+streamId).addClass('videoThumnailNotDisplay');
             }
        //scrollPleaseWaitClose('stream_view_detailed_spinner_'+postId);
        var options = {height:140,
                        width:200,
                        autoplay:true,
                        callback:function(){
                           
                        }
                    };
            loadDocumentViewer("streamVideoDiv"+streamId, uri, options,videoImage,140,200);
         $("#streamVideoDiv"+streamId+" .document-viewer-wrapper").css('margin','0px');
         $("#streamVideoDiv"+streamId+" .document-viewer").css('padding','0px 20px');
    });
    $('.NDESC').live('click',function(){
            var postId = $(this).attr('data-postid');
            var categoryType = $(this).attr('data-categoryType');
            var postType = $(this).attr('data-postType');
            var newsId = $(this).data('id');
            var showDivId = "streamDetailedDiv",
            hiddenDivId = "poststreamwidgetdiv";
            renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
    });
    
       $("#" + divId + " .PostManagementActions a.copyurl").live("click", function() {
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        loadPostSnippetWidget(postId);
    }); 
    $(".cvupdate").live("click",function(){
        var profileURL = $(this).data("profile");
      window.location.href = profileURL;
    });
    $("#" + divId + " .PostManagementActions a.usefordigest").live("click touchstart", function() {
       useForDigest(this);
    });
   }
function featuredItemCallback(param){ 
    var paramArray = param.split(","); 
    $("#featured_error_"+paramArray[1]).hide();
    var callbackurl=paramArray[4];
    if($("#featured_"+paramArray[1]).val()==""){
        
        $("#featured_error_"+paramArray[1]).show();
        $("#featured_error_"+paramArray[1]).fadeOut(5000);
    }
    else{
        var qString=paramArray[3]+"&Title="+$("#featured_"+paramArray[1]).val();
        ajaxRequest("/post/MarkOrUnMarkPostAsFeatured",qString,function(data){MarkPostAsFeaturedtHandler(data,paramArray[0]);}); 
    }


}
function featuredItemGameCallback(param){
    var paramArray = param.split(","); 
    $("#featured_error_"+paramArray[1]).hide();
    var callbackurl=paramArray[4];
    if($("#featured_"+paramArray[1]).val()==""){
        
        $("#featured_error_"+paramArray[1]).show();
        $("#featured_error_"+paramArray[1]).fadeOut(5000);
    }
    else{
        var qString=paramArray[3]+"&Title="+$("#featured_"+paramArray[1]).val();
        ajaxRequest("/post/MarkOrUnMarkPostAsFeatured",qString,function(data){MarkPostAsFeaturedtGameHandler(data,paramArray[0]);}); 
    }


}
function showCommentartifactArea(divid) {
    $("#" + divid).slideDown();
}

function savePostCommentByUserId(postid, postType, categoryId, networkId, streamid) {
    if (typeof streamid == "undefined" || streamid == "") {
        streamid = postid;
    }
    var editorObject = $("#commentTextArea_" + streamid);
    if ($.trim(editorObject.text()).length > 0) {
        if (validateAtMentions(editorObject)) {
            var comment = getEditorText(editorObject);
            var atMentions = getAtMentions(editorObject);
            var hashtagString = getHashTags(editorObject);
            var commentArtifacts = "";
            if (typeof globalspace["commentTextArea_" + streamid + "_UploadedFiles"] != 'undefined') {
                commentArtifacts = globalspace["commentTextArea_" + streamid + "_UploadedFiles"];
            }
            var IsWebSnippetExistForComment=globalspace['IsWebSnippetExistForComment_'+streamid];
             var WebUrl= globalspace['CommentWeburls_'+streamid];
            var queryString = "streamid=" + streamid + "&postid=" + postid + "&comment=" + encodeURIComponent(comment) + "&artifacts=" + $("#artifacts_" + streamid).val() + "&type=" + postType + "&atMentions=" + encodeURIComponent(atMentions) + "&hashTags=" + encodeURIComponent(hashtagString) + "&commentArtifacts=" + encodeURIComponent(commentArtifacts) + "&CategoryType=" + categoryId + "&NetworkId=" + networkId+ "&IsWebSnippetExist=" + IsWebSnippetExistForComment+"&WebUrls="+WebUrl;
            scrollPleaseWait("commentSpinLoader_" + streamid);
            
            ajaxRequest("/post/saveRenderPostComment", queryString, function(data) {
                savePostCommentByUserIdHandler(data, streamid,categoryId,postid);
            },"html");
        } else {
            $("#commentTextAreaError_" + streamid).addClass("alert alert-error").show().text(getAtMentionErrorMessage(editorObject)).fadeOut(3000, "");
        }
    } else {
        $("#commentTextAreaError_" + streamid).addClass("alert alert-error").show().text("Comment cannot blank").fadeOut(3000, "");
    }
}
function savePostCommentByUserIdHandler(data, id,categoryType,postId) { 
    scrollPleaseWaitClose('stream_view_commentscript_spinner_'+data.PostId);
    scrollPleaseWaitClose("commentSpinLoader_" + id);
    clearFileUpload("commentTextArea_" + id);
//             if(data.status=="error"){
//        var error = [];
//        if (typeof (data.error) == 'string') {
//            var error = eval("(" + data.error.toString() + ")");
//        } else {
//            var error = eval(data.error);
//        }
//        $.each(error, function(key, val) { 
//            if ($("#" + key)) {
//                displayError(key, val);
//              
//            }
//        });
//      return;
//    }
        $('#artifacts_' + id).val('');
       // $('#newComment_' + id).hide();
        $("#commentbox_" + id).show();
        $("#commentartifactsarea_" + id).hide();
        $("#preview_commentTextArea_" + id).hide();
        $("#previewul_commentTextArea_" + id).html("");
        $("#previewul_commentTextArea_" + id).hide();
        $("#commentTextArea_" + id).html("");  
        globalspace['hashtag_commentTextArea_' + id] = new Array();
        globalspace['at_mention_commentTextArea_' + id] = new Array();
        $("#savePostCommentButton_" + id).removeClass().addClass("btn").html("Comment");
     if (document.getElementById("snippet_main_"+id)) {
          //  document.getElementById('snippet_main_'+id).style.display = 'none';
             $('#snippet_main_'+id).hide();
            $("#snippet_main_"+id).html("");
        }
        
    if(data != "Blocked"){
       
          var cmntcnt = Number($("#commentCount_" + postId).text());
        //window.location="/post/index";
        cmntcnt++;
        $("#commentCount_" + postId).text(cmntcnt);
        if($("#commentCount_"+postId).prev().find('img.commented').length<=0){
            $("#commentCount_"+postId).prev().find('img.comments').addClass('commented').removeClass('comments');
        }
//        $("#commentbox_" + id).append($("#commentTmpl_render").render(item));
        $("#commentbox_" + id).append(data);
        $('#comment_new_text').removeAttr('id');
        $("#commentTextArea_" + id).css("min-height","");
        var divheight = $("#CommentBoxScrollPane_" + id).height();
        if(categoryType == 8){
            
            applyLayoutContent();
        }

//        if (divheight > 250) {
//            $("#CommentBoxScrollPane_" + id).addClass("scroll-pane");
//            $("#CommentBoxScrollPane_" + id).jScrollPane({autoReinitialise: true, stickToBottom: true});
//        }
    }
   
        globalspace['IsWebSnippetExistForComment_'+id]=0;
        globalspace['CommentWeburls_'+id]="";
    
}

/*
 * validateDescription() is used to validate post description
 * It will be called in onblur() for description
 * @author Sagar
 */
function validateDescription(obj) {
    if ($(obj).text().length == 0) {
    }
}
/*
 * send() is used to send the post
 * @author Sagar
 */
function send() {
    var editorObject = $("#editable.inputor");
    var SurveyOptions_errorMessage="";

    if(validateAtMentions(editorObject)){
         if($.trim($('#editable').text()).length>0){
//          var pattern = /^[@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\?|_\s]+$/;
//        if (pattern.test($.trim($('#editable').text()))) {
//           // alert("Your Input is valid : ");
//            displayErrorMessage("NormalPostForm_Description", 'PLease enter valid characters');
//            return;
//        } 

             $("#NormalPostForm_Description").val(getEditorText(editorObject));
         }else{
           
           $("#NormalPostForm_Description").val('');
         }


        if ($("#NormalPostForm_Type").val() == "") {
            $("#NormalPostForm_Type").val('Normal Post');
        }
        
        var atMentions = getAtMentions(editorObject);
        $('#NormalPostForm_Mentions').val(atMentions);
        var artifacts = "";
        if (typeof globalspace["NormalPostForm_UploadedFiles"] != 'undefined') {
            artifacts = globalspace["NormalPostForm_UploadedFiles"];
        }
        $('#NormalPostForm_Artifacts').val(artifacts);
        $('#NormalPostForm_IsWebSnippetExist').val(globalspace['IsWebSnippetExistForPost']);
        $('#NormalPostForm_WebUrls').val($.trim(globalspace['weburls']));
       
        var hashtagString = getHashTags(editorObject);
        $('#NormalPostForm_HashTags').val(hashtagString);
        var data = $("#normalPost-form").serialize();
  ajaxRequest("/post/createpost",data,function(data){sendNormalPostHandler(data,$('#NormalPostForm_IsFeatured').val(),$("#NormalPostForm_Type").val())},"json",sendBeforeSend);


    } else {
        displayErrorMessage("NormalPostForm_Description", getAtMentionErrorMessage(editorObject));
    }
}
function sendBeforeSend(){
      scrollPleaseWait("postSpinLoader");
}
/*
 * sendNormalPostHandler() is used to display the success/error message when a post is posted
 * It will be called after posting the post
 * @author Sagar
 */
function sendNormalPostHandler(data,isFeatureType,PostType) { 
    scrollPleaseWaitClose("postSpinLoader");
    if (data.status == "success") {
        
        $('.idisablecomments').val(0);
        $(this).removeClass('enablecomments').addClass('disablecomments');
        $(this).attr('data-original-title', Translate_DisableComments);
        $('.iisfeatured').val(0);
        $('.iisAnonymous').val(0);
        $(this).removeClass('featureditemenable').addClass('featureditemdisable');
         $("#isAnonymousI").removeClass('anonymousenable').addClass('anonymousdisable');
         $("#anonymousId").attr("data-original-title","Post As Anonymous");

        $(this).attr('data-original-title', Translate_MarkAsFeatured);

    
        $("#postReset").click();
        $("#NormalPostForm_EndTime").val(" ");
        removeErrorMessage("NormalPostForm_Description");
        if(PostType=='Normal Post'){
            $("#sucmsgForStream").html(data.data);
        }else if(PostType=='Event'){
            getEventSignedUpActivities('userEventsActivity');
            $("#sucmsgForStream").html(data.data);
        }else if(PostType=='Survey'){
             $("#sucmsgForStream").html(data.data);
        }else if(PostType=='Anonymous') {
             $("#sucmsgForStream").html(data.data);
        }
        
        
       
        
        $("#sucmsgForStream").show();
        $("#sucmsgForStream").fadeOut(3000, "");
        $("#editable").html(" ");
        $("#editable").attr("placeholder", Translate_New_Post);
        $("#normalPost-form")[0].reset();
        clearFileUpload("NormalPostForm");
        $('#NormalPostForm_Artifacts').val('');
        $('#editable').show();
        $('#postTypediv').show();
        $('#surveydiv').hide();
        $('#editable').addClass("placeholder");
        $("#editable").attr("placeholder", Translate_New_Post);
        $('#survey_header').hide();
        $('#eventdiv').hide();
        $('#event_header').hide();
        $("#surveypostdiv").removeClass("surveypostdiv");
        $('#preview_NormalPostForm').hide();
        $('#previewul_NormalPostForm').hide();
        $('#previewul_NormalPostForm').html(" ");
        globalspace['hashtag_editable'] = new Array();
        globalspace['at_mention_editable'] = new Array();
         $('#surveyeventtitledescription').hide();
        // $('.postimgclose').css('display','none'); 
        if (document.getElementById("snippet_main")) {
            document.getElementById('snippet_main').style.display = 'none';
            $("#snippet_main").html("");
        }
        clearInterval(intervalIdNewpost);

    if(isFeatureType==1){
         getFeaturedItems();   
        }
        $("#postType li").removeClass('selectpostactive');
       setTimeout(function() { // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
           if(typeof socketPost !== "undefined"){
                isThereReady = true;
                socketPost.emit('getLatestPostsRequest', loginUserId, userTypeId, postAsNetwork,sessionStorage.old_key);
            }
//            socketPost.emit('getLatestPostRequest4All', loginUserId, userTypeId, postAsNetwork,sessionStorage.old_key,gPage);

        }, 500);  
        
    } else {

        var error = [];
        if (typeof (data.error) == 'string') {
            var error = eval("(" + data.error.toString() + ")");
        } else {
            var error = eval(data.error);
        }
        $.each(error, function(key, val) {
            if ($("#" + key + "_em_")) {
                displayErrorMessage(key, val);
            }
        });
    }
globalspace['IsWebSnippetExistForPost']=0;
globalspace['weburls']="";
}

function cancelPostCommentByUserId(postId,categoryType) {
    if(categoryType != undefined && categoryType != null && categoryType != "" && categoryType == 8)
        applyLayoutContent();
    clearFileUpload("commentTextArea_" + postId);
   // $("#commentTextArea_" + postId).html("");
 
    $('#commentArtifactsPreview_' + postId).hide();
    $('#previewul_commentTextArea_' + postId).hide();
    $('#previewul_commentTextArea_' + postId).html('');
    $('#artifacts_' + postId).val('');
    $("#commentartifactsarea_" + postId).hide();
    $("#commentTextArea_" + postId).css("min-height", "");
    $("#commentTextArea_" + postId).hide();
    $("#newComment_" + postId).hide();
    $("#newComment_" + postId).removeClass('paddinglrtp');
    
     if($('#commentbox_' + postId).height() >0){
         $('#cId_' + postId).show();
     }else{
         $('#cId_' + postId).hide();
     }
    $("#previewul_commentTextArea_" + postId).html("");  
    globalspace['hashtag_' + postId] = new Array();
    globalspace['at_mention_' + postId] = new Array();
     if (document.getElementById("snippet_main_"+postId)) {
            document.getElementById('snippet_main_'+postId).style.display = 'none';
            $("#snippet_main_"+postId).html("");
      }
        globalspace['IsWebSnippetExistForComment_'+postId]=0;
        globalspace['CommentWeburls_'+postId]="";
         $('#surveyeventtitledescription').hide();
}

function saveInvites(postid, networkId, categoryType, streamid) {

    if (typeof streamid == "undefined" || streamid == "") {
        streamid = postid;
    }
     var atMentions = '';
    $('#inviteTextBox_'+streamid+'_currentMentions span.dd-tags-close').each(function(index, element){
        var invitedUserId = $(element).attr('data-user-id');
        atMentions += ","+invitedUserId;
    });
    if (atMentions == "") {
        $("#InviteTextBox_"+streamid+"_em_").show().fadeOut(4000);
    }    
    if($("#inviteTextBox_"+streamid).val()=="" && $("#inviteTextBox_"+streamid).val()=="undefined")
    {    
         $("#InviteTextBox_"+streamid+"_em_propermention").show().fadeOut(4000); 
    }else{    
    var editorObject = $("#inviteTextArea_" + streamid);
    if (editorObject.text().length > 0) {
        if (atMentions != "") {
            var inviteText = editorObject.text();
            var queryString = "&postId=" + postid + "&inviteText=" + encodeURIComponent(inviteText) + "&atMentions=" + atMentions + '&networkId=' + networkId + '&categoryType=' + categoryType;
            ajaxRequest("/post/saveInvites", queryString, function(data) {
                saveInvitestByUserIdHandler(data, streamid);
                  //trackEngagementAction("Invite",postid,categoryType);
            });
            
        }
    } else {
        $("#InviteTextArea_"+streamid+"_em_").show().fadeOut(4000);
    }
    }
}
function saveInvitestByUserIdHandler(data, id) {
    //alert(data.toSource())
    if (data.status == "success") {
        var atMentions = '';
        var i=0;
        $('#inviteTextBox_'+id+'_currentMentions span.dd-tags-close').each(function(index, element){
            if(i<2){
                var invitedUser = $(element).find('b').text();
                atMentions += ","+invitedUser;
            }
            i++;
        });
        var msg="";
        atMentions=atMentions.substr(1);
        if (i == 1) {
            msg = atMentions + Translate_is_invited_successfully;
        } else if(i==2) {
            msg = atMentions + Translate_are_invited_successfully;
        } else{
            msg = atMentions + " "+Translate_and+" "+(i-2)+Translate_are_invited_successfully;
        }
        $("#inviteTextArea_" + id).html('');
        $("#inviteTextAreaSuccess_" + id).show().text(msg).fadeOut(4000, function(){$("#myModal").modal('hide');});
    } if(data.status=="error"){
        var error = [];
        if (typeof (data.error) == 'string') {
            var error = eval("(" + data.error.toString() + ")");
        } else {
            var error = eval(data.error);
    }
        $.each(error, function(key, val) { 
            if ($("#" + key)) {
                displayError(key, val);
              
}
        });
      return;
    }
}

function submitSurvey(postId, networkId, categoryType, OptionOneCount, OptionTwoCount, OptionThreeCount, OptionFourCount, streamId,optionDExist) {
    if (typeof streamId == 'undefined' || streamId == '') {
        streamId = postId;
    }
    var option = $('input[name=survey_' + postId + ']:checked').val();
    if (option != undefined && option != "") {
        if (option == 'OptionOne') {
            OptionOneCount++;
        } else if (option == 'OptionTwo') {
            OptionTwoCount++;
        } else if (option == 'OptionThree') {
            OptionThreeCount++;
        } else if (option == 'OptionFour') {
            OptionFourCount++;
        }
        scrollPleaseWait('stream_view_spinner_'+streamId);
        var queryString = "&postId=" + postId + "&option=" + option + '&networkId=' + networkId + '&categoryType=' + categoryType;
        $("#surveyDetailedImg").removeClass("survey_no").addClass("survey_yes");
                var surveyCount = Number($("#detailedSurveyCountSpan").html());
                surveyCount++;
                $("#detailedSurveyCountSpan").html(surveyCount);
                  $(".dSurvey").attr("data-count",surveyCount);
                  $("#userDetailSurveyView_" +postId).attr("data-count",surveyCount);
                 $("#userDetailSurveyView_" +postId).prepend("You<br/>"); 
        ajaxRequest("/post/submitSurvey", queryString, function(data) {
            submitSurveyHandler(data, streamId, OptionOneCount, OptionTwoCount, OptionThreeCount, OptionFourCount,optionDExist);
        });
        
  trackEngagementAction("SurveySubmit",postId,categoryType);
    } else {
        $("#surveyError_" + streamId).show().fadeOut(3000, "");
    }
}

function submitSurveyHandler(data, streamId, OptionOneCount, OptionTwoCount, OptionThreeCount, OptionFourCount,optionDExist) {
    scrollPleaseWaitClose('stream_view_spinner_'+streamId); 
      if(data.status=="error"){
        var error = [];
        if (typeof (data.error) == 'string') {
            var error = eval("(" + data.error.toString() + ")");
        } else {
            var error = eval(data.error);
        }
        $.each(error, function(key, val) { 
            if ($("#" + key)) {
                displayError(key, val);
              
            }
        });
      return;
    }
    if (data.status == "success") {
        var height = 250;
        var width = 300;
        if(detectDevices()){
            width = 230;
        }
        drawSurveyChart("surveyGraphArea_" + streamId, OptionOneCount, OptionTwoCount, OptionThreeCount, OptionFourCount,height,width,optionDExist);
        setTimeout(function() {
            $("#surveyArea_" + streamId).hide();
            $("#surveyTakenArea_" + streamId).show();
            $("#surveyConfirmation_" + streamId).show().fadeOut(3000, "");
        }, 1000);
    }
}


function setTimepicker(obj) {
    var offset = $("#" + obj.id).offset();
    $('#timepicker-popup').css("top", offset.top + "px");
    var timePickerPopup = $(".timepicker-popup");

    timePickerPopup
            .css("position", "absolute")
            .css("left", offset.left + "px")
            .css("top", offset.top + 30 + "px")

  
    $('#timepicker-popup').css("display", "block");
    $('#timepicker-popup').css({'z-index':'1060'});
    
}

function initializationEvents() {
    $("#post").addClass('active');


    $('#editable').click(function() {

        $('#NormalPostForm_Description_em_').fadeOut(2000);
        $('#NormalPostForm_Artifacts_em_').fadeOut(2000);
    });

    $('#NormalPostForm_OptionOne').focus(function() {
        $('#NormalPostForm_OptionOne_em_').fadeOut(2000);

    });
    $('#NormalPostForm_OptionTwo').focus(function() {
        $('#NormalPostForm_OptionTwo_em_').fadeOut(2000);

    });
    $('#NormalPostForm_OptionThree').focus(function() {
        $('#NormalPostForm_OptionThree_em_').fadeOut(2000);

    });
    $('#NormalPostForm_OptionFour').focus(function() {
        $('#NormalPostForm_OptionFour_em_').fadeOut(2000);

    });
    $('#NormalPostForm_ExpiryDate').focus(function() {
        $('#NormalPostForm_ExpiryDate_em_').fadeOut(2000);

    });
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    var surveycheckin = $('#dp3').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {


        $('.datepicker').hide();

    });

    var checkin = $('#dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if ((ev.date.valueOf() > checkout.date.valueOf()) || checkout.date.valueOf()!="") {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 0);
            checkout.setValue(newDate);
        }
        checkin.hide();
        $('#dpd2')[0].focus();
    }).data('datepicker');
    
    var checkout = $('#dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');



  $("#postType li").click(function(){
        $("#postType li").removeClass('selectpostactive'); 
        $(".open").each(function(){
           $(this).removeClass('open');
        });
       // $("#postType li").css('background','none');    
       // $(this).css("color","#ffffff");  
        $(this).addClass('selectpostactive');  
    });
}

function updatePostIds(flag, postid) {

}
/**
 * @author Karteek.V
 * @param {type} showDivId
 * @param {type} hideDivId
 * @param {type} postId
 * @param {type} categoryType
 * @returns {undefined}
 */
function renderPostDetailPage(showDivId, hideDivId, postId, categoryType, postType,recentActivity) {
    if(detectDevices()){
        $("#rightpanel").hide();
    } 
     var URL = "/post/renderPostDetailed?postId=" + postId + "&categoryType=" + categoryType + "&postType=" + postType+ "&recentActivity=" + recentActivity;
    if(globalspace.translate == 1){
        URL = URL+"&translate=1";
        globalspace.translate=0;
    }
    var data="";
    ajaxRequest(URL,data,function(data){renderPostDetailPageHandler(data,showDivId, hideDivId,categoryType,postId)},"html");

}
function renderPostDetailPageHandler(html,showDivId, hideDivId,categoryType,postId){ 
    scrollPleaseWaitClose("PostdetailSpinLoader_streamDetailedDiv_"+g_streamId);
     scrollPleaseWaitClose('stream_view_detailed_spinner_'+postId);
     scrollPleaseWaitClose('featureitemspinner');
            scrollPleaseWaitClose("eventattend_spinner");           
            $("#notificationHistory,#notificationHomediv,#nomorenotifications").hide();
            $("#contentDiv").show();
            $("#" + showDivId).removeAttr('style');
            if(showDivId=="admin_PostDetails"){
                $("#rightpanel").hide();
                 $("#" + showDivId).html(html).show();
                    $("#" + hideDivId).hide();
                    if(hideDivId == "GroupTotalPage"){
                        $(".group_admin_floatingMenu,#contentDiv").hide();
                        globalspace.groupsPage = "detailed_page";
                    }
                       bindUserActionView();
                    return;
            }
            if(categoryType == 3){
               // $("#groupFormDiv,#groupProfileDiv,#GroupBanner").hide();
            }
            if(categoryType == 1){
                if($("#curbsideStreamDetailedDiv").length > 0){ 
                    $("#curbsideStreamDetailedDiv").html(html).show();
                    $("#curbsidePostCreationdiv").hide();                   
                }
            }
            if($("#curbsidePostCreationdiv").is(':visible')){
                    $("#curbsideStreamDetailedDiv").html(html).show();
                    $("#curbsidePostCreationdiv").hide();
                }
            if($("#groupPostDetailedDiv").length > 0){ 
                    //globalspace.notification = "detailedpage";
                    //$("#admin_PostDetails").html(html).show();
                    //$("#groupPostDetailedDiv").html(html).show();
                    $('#GroupTotalPage').hide();
                }else{ 
                    $("#" + showDivId).html(html).show();
                    $("#" + hideDivId).hide();

                }
                bindUserActionView();
        $('body, html').animate({scrollTop : 0}, 0);
         $("[rel=tooltip]").tooltip();
}
function promoteCallback(param) {
    var paramArray = param.split(',');
    var streamId = paramArray[0];
    var postId = paramArray[1];
    var categoryType = paramArray[2];
    var networkId = paramArray[3];
    var promoteDate = $('#promoteInput_' + streamId).val();
    promotePost(streamId, postId, promoteDate, categoryType, networkId);
}
function deleteCallback(param) { 
    var paramArray = param.split(',');
    var streamId = paramArray[0];
    var postId = paramArray[1];
    var categoryType = paramArray[2];
    var networkId = paramArray[3];
    var deletingFrom=''; 
    if(paramArray[4]!=undefined){
       deletingFrom=paramArray[4]; 
    }
    deletePost(streamId, postId, categoryType, networkId,deletingFrom);
}

function saveitforlaterCallback(param) { 
    var paramArray = param.split(',');
    var streamId = paramArray[0];
    var postId = paramArray[1];
    var categoryType = paramArray[2];
    var networkId = paramArray[3];
     var postType=''; 
    var deletingFrom=''; 
    if(paramArray[4]!=undefined){
       deletingFrom=paramArray[4]; 
}
     if(paramArray[5]!=undefined){
       postType=paramArray[5]; 
    }
    saveitforlaterPost(streamId, postId, categoryType, networkId,deletingFrom,postType);
}



function abuseCallback(param) {
    var paramArray = param.split(',');
    var streamId = paramArray[0];
    var postId = paramArray[1];
    var categoryType = paramArray[2];
    var networkId = paramArray[3];
    var actionType = paramArray[4];
    var abuseFrom=''; 
    if(paramArray[5]!=undefined){
       abuseFrom=paramArray[5]; 
    }
    abusePost(streamId, postId, actionType, categoryType, networkId,abuseFrom);
}
function suspendCallback(param) {
    var paramArray = param.split(',');
    var streamId = paramArray[0];
    var postId = paramArray[1];
    var categoryType = paramArray[2];
    var networkId = paramArray[3];
    var actionType = paramArray[4];
    suspendGame(streamId, postId, actionType, categoryType, networkId);
}
function cancelScheduleCallback(param) {
    var paramArray = param.split(',');
    var streamId = paramArray[0];
    var postId = paramArray[1];
    var categoryType = paramArray[2];
    var scheduleId = paramArray[3];
    var actionType = paramArray[4];
    cancelScheduleGame(streamId, postId, actionType, categoryType, scheduleId);
}


function saveDetailedPostCommentByUserId(postid, postType, categoryId, networkId, streamid, pageType) {
    if (typeof streamid == "undefined" || streamid == "") {
        streamid = postid;
    }
   
    var editorObject = $("#commentTextArea_" + streamid);
    if ($.trim(editorObject.text()).length > 0) {
        if (validateAtMentions(editorObject)) {
            var comment = getEditorText(editorObject);
            var atMentions = getAtMentions(editorObject);
            var hashtagString = getHashTags(editorObject);
            var commentArtifacts = "";
            if (typeof globalspace["commentTextArea_" + streamid + "_UploadedFiles"] != 'undefined') {
                commentArtifacts = globalspace["commentTextArea_" + streamid + "_UploadedFiles"];
            }
            var IsWebSnippetExistForComment=globalspace['IsWebSnippetExistForComment_'+streamid];
            var WebUrl= globalspace['CommentWeburls_'+streamid];
            var queryString = "streamid=" + streamid + "&postid=" + postid + "&comment=" + encodeURIComponent(comment) + "&artifacts=" + $("#artifacts_" + streamid).val() + "&type=" + postType + "&atMentions=" + encodeURIComponent(atMentions) + "&hashTags=" + encodeURIComponent(hashtagString) + "&commentArtifacts=" + encodeURIComponent(commentArtifacts) + "&CategoryType=" + categoryId + "&NetworkId=" + networkId+"&IsWebSnippetExist=" + IsWebSnippetExistForComment+"&WebUrls="+WebUrl+"&pageType="+pageType;
            
            scrollPleaseWait("commentSpinLoader_" + streamid);
            if (pageType == 'postDetailed'){
                ajaxRequest("/post/saveRenderPostComment", queryString, function(data) {
                    saveDetailedPostCommentByUserIdHandler(data, streamid, categoryId);
                },"html");
                 trackEngagementAction("Comment",postid,categoryId);
            }
            if (pageType == 'GroupDetail')
                ajaxRequest("/post/savePostComment", queryString, function(data) {
                    savePostCommentByUserIdForGroupDetailPageHandler(data, streamid);
                },"html");
        } else {
            $("#commentTextAreaError_" + streamid).addClass("alert alert-error").show().text(getAtMentionErrorMessage(editorObject)).fadeOut(3000, "");
        }
    } else {
        $("#commentTextAreaError_" + streamid).addClass("alert alert-error").show().text("Comment cannot blank").fadeOut(3000, "");
    }
}
function saveDetailedPostCommentByUserIdHandler(data, id, categoryType) {
    scrollPleaseWaitClose("commentSpinLoader_" + id);
    clearFileUpload("commentTextArea_" + id);
    $("#commentbox_" + id).show();
    $('#artifacts_' + id).val('');
    $("#commentTextArea_" + id).html("");
    $("#commentTextArea_" + id).css("min-height", "");
    $('#previewul_commentTextArea_' + id).hide();
    $("#commentartifactsarea_"+id).hide();
    $("#commentTextArea_"+id).addClass('commentplaceholder');
    $('#previewul_commentTextArea_' + id).html('');
      if (document.getElementById("snippet_main_"+id)) {
            document.getElementById('snippet_main_'+id).style.display = 'none';
            $("#snippet_main_"+id).html("");
        }
    if(data != "Blocked"){
//        var item = {
//        'data': data
//        };
        var cmntcnt = Number($("#det_commentCount_" + id).html());
        //window.location="/post/index";
        cmntcnt++;
        $('#newComment_' + id).hide();
        $("#det_commentCount_" + id).text(cmntcnt);
        $('#detailedComment').addClass('commented').removeClass('comments').removeClass('comments1');
//        $("#commentbox_" + id).prepend($("#commentTmpl_instant_render").render(item));
        $("#commentbox_" + id).prepend(data);
        $('#comment_new_text').removeAttr('id');
        $("#savePostCommentButton_" + id).removeClass().addClass("btn").html(Translate_Comment);
    }
    
       
         globalspace['IsWebSnippetExistForComment_'+id]=0;
         globalspace['CommentWeburls_'+id]="";
    
}

function savePostCommentByUserIdForGroupDetailPageHandler(data, id) {
    scrollPleaseWaitClose("commentSpinLoader_" + id);
    clearFileUpload("commentTextArea_" + id);
    $('#artifacts_' + id).val('');
    $("#commentTextArea_" + id).html("");
    $('#previewul_commentTextArea_' + id).hide();
    $('#previewul_commentTextArea_' + id).html('');
    if (document.getElementById("snippet_main_"+id)) {
            document.getElementById('snippet_main_'+id).style.display = 'none';
            $("#snippet_main_"+id).html("");
        }
        
        var cmntcnt = Number($("#commentCount_" + id).html());
        cmntcnt++;
        $("#commentCount_" + id).text(cmntcnt);
        $("#commentCount_" + id).prev().find('img').addClass('commented').removeClass('comments');
        $("#commentsAppend_" + id).prepend(data);
        //$('#comment_new_text').html(data.data.CommentText);
        $('#comment_new_text').removeAttr('id');
        $("#preview_commentTextArea_" + id).hide();
        $("#previewul_commentTextArea_" + id).html("");

        $("#savePostCommentButton_" + id).removeClass().addClass("btn").html(Translate_Comment);
        
 
        globalspace['IsWebSnippetExistForComment_'+id]=0;
        globalspace['CommentWeburls_'+id]="";
    
    
}
function cancelPostCommentByUserIdDetailPage(postId) {

    $("#commentTextArea_" + postId).html("");
    clearFileUpload("commentTextArea_" + postId);
    $('#commentArtifactsPreview_' + postId).hide();
    $('#previewul_commentTextArea_' + postId).hide();
    $('#previewul_commentTextArea_' + postId).html('');
    $('#artifacts_' + postId).val('');
    if (document.getElementById("snippet_main_"+postId)) {
            document.getElementById('snippet_main_'+postId).style.display = 'none';
            $("#snippet_main_"+postId).html("");
        }
     globalspace['IsWebSnippetExistForComment_'+postId]=0;
     globalspace['CommentWeburls_'+postId]="";
    if(Number($('#commentCount_' + postId).text()) >0){
        $('#cId_' + postId).show();
    }else{
        $('#cId_' + postId).hide();
    }
    $("#commentartifactsarea_" + postId).hide();
    $("#commentTextArea_" + postId).css("min-height", "");
    $("#commentTextArea_" + postId).hide();
    $("#newComment_" + postId).hide();
    $("#newComment_" + postId).removeClass('paddinglrtp');
}



function cancelInvite(id) {
    globalspace['invite_at_mention_inviteTextArea_' + id] = new Array();
    $("#myModal").modal('hide');
}
function viewmoreComments(URL, postid, commentAppendId, categoryType, isBlockedPost) {
//    $("#CommentBoxScrollPane_" + commentAppendId).addClass("scroll-pane");
//    $("#CommentBoxScrollPane_" + commentAppendId).jScrollPane({autoReinitialise: true, stickToBottom: true});
//    
    if(typeof globalspace['comment_'+commentAppendId] == 'undefined' ){
        globalspace['comment_'+commentAppendId]=0;
    }

    var URL = URL + "?postId=" + postid + "&CategoryType=" + categoryType + "&Page=" +  globalspace['comment_'+commentAppendId]+ "&PageType=stream&streamId="+commentAppendId;
    if(typeof isBlockedPost != 'undefined'){
        URL = URL +"&isBlockedPost="+isBlockedPost;
    }
    scrollPleaseWait("commentSpinLoader_" + commentAppendId, "cId_" + commentAppendId);
   var data="";
    ajaxRequest(URL,data,function(data){viewmoreCommentsHandler(data,commentAppendId,postid,categoryType)},"html");

}
function viewmoreCommentsHandler(html,commentAppendId,postid,categoryType){
    if(categoryType == 8){applyLayoutContent();}
    if(categoryType == 9){applyLayout();}
     $("#cId_" + commentAppendId).show();
              $("#newComment_" + commentAppendId).show();
              $("#commentbox_" + commentAppendId).show();
            scrollPleaseWaitClose("commentSpinLoader_" + commentAppendId);
            if (globalspace['comment_'+commentAppendId] == '0') {
              $("#commentbox_" + commentAppendId).html(html);
            } else {
                   var api = $("#CommentBoxScrollPane_" + commentAppendId).data('jsp');
                   
                   var divHeight=api.getContentHeight();
                   
                $("#commentbox_" + commentAppendId).append(html);
                $.unique($("#commentbox_" + commentAppendId).get())
                   // var div="commentbox_"+commentAppendId;
                 
                 
//                setTimeout(function(){
//                    api.scrollByY(divHeight);
//                },500)  
                
                    
            }

            globalspace['comment_'+commentAppendId]=Number(globalspace['comment_'+commentAppendId])+1;
 //            g_commentPage++;
 
            var totalcomments = Number($("#commentCount_" +postid).html());
            var rendercomments = globalspace['comment_'+commentAppendId]*10;
            if(rendercomments >= totalcomments){
                 $("#viewmorecomments_"+commentAppendId).hide();
                   globalspace['comment_'+commentAppendId]=0;
            }

            if (html == "") {
                $("#viewmorecomments_"+commentAppendId).hide();
                globalspace['comment_'+commentAppendId]=0;
            } else {
            }

              //$("#CommentBoxScrollPane_" + commentAppendId).addClass("scroll-pane");
              //$("#CommentBoxScrollPane_" + commentAppendId).jScrollPane({autoReinitialise: true,mouseWheelSpeed:200});
}

function viewmoreCommentsIndetailedPage(URL, postid, streamid, Collectionname, categoryType, noOfComments,isPostManagement) {
    if(typeof noOfComments=='undefined'){
        noOfComments = 10;
    }
   var URL = URL + "?postId=" + postid + "&Collectionname=" + Collectionname + "&Page=" + g_commentPage + "&CategoryType=" + categoryType+ "&streamId=" + streamid+ "&PageType=postdetail"+ "&noOfComments="+noOfComments+ "&isPostManagement="+isPostManagement;
   var data="";   
   scrollPleaseWait("commentSpinLoader_" + streamid);
    ajaxRequest(URL,data,function(data){viewmoreCommentsIndetailedPageHandler(data,streamid)},"html");

}
function viewmoreCommentsIndetailedPageHandler(html,streamid){
     if (g_commentPage == 0) {
                if($("#postDetailDiv").length>0){
                    $("#postDetailDiv #commentbox_" + streamid).html(html);
                }else{
                    $("#commentbox_" + streamid).html(html);
                }
            } else {
                if($("#postDetailDiv").length>0){
                    $("#postDetailDiv #commentbox_" + streamid).append(html);
                }else{
                    $("#commentbox_"+streamid).append(html);
                }
            }

            g_commentPage++;
            scrollPleaseWaitClose("commentSpinLoader_" + streamid);
            var totalcomments = Number($("#det_commentCount_" +streamid).html());
            var rendercomments=g_commentPage*10;
            if(rendercomments >= totalcomments){
                 $("#viewmorecommentsDetailed").hide();
            }
            if (html == "") {
                $("#viewmorecommentsDetailed").hide();
            }
}
function OpenCommentbuttonArea(postId,categoryType) { 
    if(categoryType != undefined && categoryType != "" && categoryType != null && categoryType == 8){
        
            applyLayoutContent();
        $("#newComment_"+postId).css("min-height","80px");
    }else if(categoryType==9){
        applyLayout();
        $("#newComment_"+postId).css("min-height","80px");
    }
    if(categoryType!=3 || categoryType!=7){     
   // initializationForHashtagsAtMentions('#commentTextArea_'+postId);
     }
    $("#commentartifactsarea_" + postId).show();
    $("#commentTextArea_" + postId).removeClass("commentplaceholder");
    $("#commentartifactsarea_" + postId).animate({"min-height": "30px", "max-height": "200px"}, "fast");
    $("#commentTextArea_" + postId).animate({"min-height": "50px", "max-height": "200px"}, "fast");
    $("#commentartifactsarea_" + postId).slideDown("fast");   
    CommentEditableText(postId);
    if($("#postDetailedTitle").is(":visible")){ 
        $("#commentTextArea").html("");
        $("#cId_"+postId).show();
        $("#newComment,#commentbox").show();
      
        $("#inviteBox,.invitebox").hide();
        initializationForHashtagsAtMentions('#commentTextArea_'+postId);
    }
    return false;

}

function expandpostDiv(postId) { 
    $("#post_content_total_" + postId).show();
    $("#post_content_total_" + postId).slideDown("fast");
    $("#post_content_" + postId).hide();
    
    return false;
}
function getStreamByFilter(obj){
    var filterString = $(obj).val();
    if($('#AbusedPostsFilterDiv').length>0){
        $('#AbusedPostsFilterDiv').hide();
    }
    $(window).unbind("scroll");
    page = 1;
    isDuringAjax=false;
    $('#streamMainDiv').empty();
    if(filterString=='ManagePosts'){
        getCollectionData('/admin/getnormalabusedposts', 'AbusedPostDisplayBean', 'streamMainDiv', Translate_NoPostsFound,Translate_Thas_all_folks);
    }else if(filterString!=""){
        getCollectionData('/post/stream', 'filterString='+filterString+'&StreamPostDisplayBean', 'streamMainDiv', Translate_NoPostsFound,Translate_Thas_all_folks);
    }else{
        getCollectionData('/post/stream', 'StreamPostDisplayBean', 'streamMainDiv', Translate_NoPostsFound,Translate_Thas_all_folks);
    }
}
function getAbusedPostsByFilter(obj){
    $('#postsDisplayDiv').empty();
    $(window).unbind("scroll");
    page = 1;
    isDuringAjax=false;
    $('#streamMainDiv').empty();
    var filterString = $(obj).val();
    if (filterString == 'Curbside_Posts') {
        getCollectionData('/admin/getcurbsideabusedposts', 'AbusedCurbsidePostDisplayBean', 'streamMainDiv', 'No Posts found.', 'That\'s all folks!');
    } else if (filterString == 'Group_Posts') {
        getCollectionData('/admin/getgroupabusedposts', 'AbusedGroupPostDisplayBean', 'streamMainDiv', 'No Posts found.', 'That\'s all folks!');
    }else{
        getCollectionData('/admin/getnormalabusedposts', 'AbusedPostDisplayBean', 'streamMainDiv', 'No Posts found.', 'That\'s all folks!');
    }

}

 /**
 * karteek .v
 * this is function is used to clear all interval which are not related to group stream...
 */
function ClearCurbsideNodeIntervals(){
    clearInterval(curbSocialStatsInterval);
    clearInterval(intervalIdCurbpost);

}

function MarkPostAsFeaturedtHandler(data,streamId){ 

    if(data.status=='success'){        
      $('#MarkAsFeatured_'+streamId).hide();   
      $('#isFeatutedIcon_'+streamId).show();   
      getFeaturedItems();
      closeModelBox();
    }else{
        
    }    
}
function MarkPostAsFeaturedtGameHandler(data,streamId){      
    if(data.status=='success'){        
      $('#featuredicon_'+streamId).hide();   
      $('#isFeatutedIcon_'+streamId).show();   
      getFeaturedItems();
      closeModelBox();
    }else{
        
    }    
}
function getInvitedUsersForPost(PostId, CategoryType){
   var queryString = "PostId="+PostId+"&CategoryType="+CategoryType;
   ajaxRequest("/post/getInvitedUsers", queryString, getInvitedUsersForPostHandler);   
}
function getInvitedUsersForPostHandler(json){
    if(json.status=="success"){
        if(json.count>0){
            var invitedUsersData="";
            $.each(json.data, function(id, value){
                invitedUsersData+="<span class='at_mention dd-tags' data-user-id="+id+"><b>"+value+"</b></span>";
            });
            $("#invitedUsersDiv").html(invitedUsersData);
            $("#invitedUsersDiv").show();
        }
    }
}
function removeInvitedUser(obj, id){
    $(obj).closest('span.at_mention').remove();
}

function clickTimePicker(id){
$('.endtime').timepicker();
$('.starttime').timepicker();

$('#'+id).click();
$('#'+id).focus();
$('#timepicker-popup').css({'z-index':'9999'});
}
function getPostRecentComments(URL, postid, commentAppendId, categoryType) {
    var URL = URL + "?postId=" + postid + "&CategoryType=" + categoryType+ "&StreamId=" + commentAppendId+"&PageType=stream";
    scrollPleaseWait("commentSpinLoader_" + commentAppendId, "cId_" + commentAppendId);
    ajaxRequest(URL, "", function(data){getPostRecentCommentsHandler(data, commentAppendId,categoryType);}, 'html');
}
function getPostRecentCommentsHandler(html, commentAppendId,categoryType){
    if(categoryType == 8){
       applyLayoutContent();
    }
    scrollPleaseWaitClose("commentSpinLoader_" + commentAppendId);
    $("#commentbox_" + commentAppendId).html(html);
    $("#commentbox_" + commentAppendId).show();
}

function DetailPageDisplay(postId, categoryType, postType,divId) {
    $("#homestream").removeClass("class");
  //  scrollPleaseWait('stream_view_detailed_spinner_' + postId);
    if (postId != undefined && postId != "" && (categoryType == 1 && postType != 5) || categoryType==10) {
        scrollPleaseWait("PostdetailSpinLoader_streamDetailedDiv_"+g_streamId);
        renderPostDetailPage('streamDetailedDiv', 'poststreamwidgetdiv', postId, categoryType, postType);
        //scrollPleaseWaitClose("PostdetailSpinLoader_streamDetailedDiv_"+g_streamId);
        setActiveClassPage = "homestream";
    } else if (categoryType == 2) {
        var showdivId = "";
        var hidedivId = "";
        setActiveClassPage = "curbsidepost";
        /**
         * this is used to manage in both curbside and Normal..
         */
        if ($("#curbsideStreamDetailedDiv").length > 0) {
            showdivId = "curbsideStreamDetailedDiv";
            hidedivId = "curbsidePostCreationdiv";
        } else {
            showdivId = "streamDetailedDiv";
            hidedivId = "poststreamwidgetdiv";
        }
        scrollPleaseWait("PostdetailSpinLoader_" + showdivId, showdivId);
        renderPostDetailPage(showdivId, hidedivId, postId, categoryType, postType);
        scrollPleaseWaitClose("PostdetailSpinLoader_" + showdivId);
    } else if (categoryType == 3 || categoryType == 7) {
        setActiveClassPage = "grouppost";
        var showdivId = "";
        var hidedivId = "";
        /**
         * this is used to manage in both group and Normal..
         */
        if ($("#groupPostDetailedDiv").length > 0) {
            showdivId = "groupPostDetailedDiv";
            hidedivId = "groupstreamMainDiv";

        } else {
            showdivId = "streamDetailedDiv";
            hidedivId = "poststreamwidgetdiv";
        }

        scrollPleaseWait("PostdetailSpinLoader_" + showdivId, showdivId);

        renderPostDetailPage('admin_PostDetails', 'GroupTotalPage', postId, categoryType, postType);
        scrollPleaseWaitClose("PostdetailSpinLoader_" + showdivId);
    }
    $("[rel=tooltip]").tooltip();
}

function loadGalleria(){
    $('#FeaturedItemsGallery').empty();
    $("#GalleryDiv div.galleria").clone().appendTo("#FeaturedItemsGallery"); 
      Galleria.run('#FeaturedItemsGallery div.galleria', {
            dataSelector: "a",
            dataConfig: function(a) { 
                // a is now the anchor element
                // the function should return an object with the new data
                return {
                    image: $(a).attr('href'), // tell Galleria that the href is the main image,
                    description: $(a).text(), // use the anchor text for title
                    thumb:$(a).attr('data-thumb'),
                    original:$(a).attr('data-original'),
                    categoryType:$(a).attr('data-categoryType'),
                    postId:$(a).attr('data-postId'),
                    postType:$(a).attr('data-postType'),
                };
            },
           extend: function() {               
                this.bind('image', function(e) {  
                    $('.galleria-errors').hide();
                    $('.galleria-info-text').unbind('click');
                    var postId = e.galleriaData.postId;
                    var categoryType = e.galleriaData.categoryType;
                    var postType = e.galleriaData.postType;  
                    if(detectDevices()){
                        $(".galleria-layer").on("touchstart",function() {
                            $("#streamDetailedDiv").empty();                            
                            g_pageType = 'streamMainDiv';
                            Global_ScrollHeight=$(document).scrollTop();                            
                            if(postType!=11)
                            {
                                DetailPageDisplay(postId,categoryType,postType);
                             }
                            else if(postType==11)
                        {
                            var newsId=postId;
                            var showDivId = "streamDetailedDiv",
                            hiddenDivId = "poststreamwidgetdiv";
                            renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
                        }
                         else if(postType==12)
                        {
                            var newsId=postId;
                            var showDivId = "streamDetailedDiv",
                            hiddenDivId = "poststreamwidgetdiv";
                            renderGameDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
                        }
                        });
                    }else{
                        $(e.imageTarget).click(function() {                                              
                        g_pageType = 'streamMainDiv';
                        Global_ScrollHeight=$(document).scrollTop();
                        if(postType!=11 && postType!=12)
                        {
                            DetailPageDisplay(postId,categoryType,postType);
                         }
                        else if(postType==11)
                        {
                            var newsId=postId;
                            var showDivId = "streamDetailedDiv",
                            hiddenDivId = "poststreamwidgetdiv";
                            renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
                        }
                         else if(postType==12)
                        {
                            var newsId=postId;
                            var showDivId = "streamDetailedDiv",
                            hiddenDivId = "poststreamwidgetdiv";
                            renderGameDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
                        }
                    });

                    $('.galleria-info-text').click(function(ev) {   
                        scrollPleaseWait('featureitemspinner');
//                        var postId = e.galleriaData.postId;                       
//                        var categoryType = e.galleriaData.categoryType;
//                        var postType = e.galleriaData.postType;
                        g_pageType = 'streamMainDiv';
                        Global_ScrollHeight=$(document).scrollTop();                        
                        if(postType!=11)
                        {
                            DetailPageDisplay(postId,categoryType,postType);
                         }
                        else if(postType==11)
                        {
                            var newsId=postId;
                            var showDivId = "streamDetailedDiv",
                            hiddenDivId = "poststreamwidgetdiv";
                            renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
                        }
                         else if(postType==12)
                        {
                            var newsId=postId;
                            var showDivId = "streamDetailedDiv",
                            hiddenDivId = "poststreamwidgetdiv";
                            renderGameDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
                        }
                    });
                    
                    }
                    
                    
                });
                 this.bind('title', function(e) {
                    $('.galleria-errors').hide();
                    if(detectDevices()){
                        $(".galleria-layer").on("touchstart",function() {
                            $("#streamDetailedDiv").empty();
                            var postId = e.galleriaData.postId;
                            var categoryType = e.galleriaData.categoryType;
                            var postType = e.galleriaData.postType;
                            g_pageType = 'streamMainDiv';
                            Global_ScrollHeight=$(document).scrollTop();                            
                            if(postType!=11)
                            {
                                DetailPageDisplay(postId,categoryType,postType);
                             }
                            else
                            {
                               var newsId=postId;
                               var showDivId = "streamDetailedDiv",
                               hiddenDivId = "poststreamwidgetdiv";
                               renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
                            }
                        });
                    }
                    
                    
                });
            }
        });
//        Galleria.ready(function() { 
//
//    this.bind("thumbnail", function(e) { alert(e.toSource())
//        Galleria.log(this); // the gallery scope
//        Galleria.log(e) // the event object
//    });
//
//    this.bind("loadstart", function(e) {
//        if ( !e.cached ) {
//            Galleria.log(e.target + ' is not cached. Begin preload...');
//        }
//    });
//});
        $('.galleria-errors').hide();
}
function trackEngagementAction(action,dataId,categoryType,postType,id){   
   if(dataId==null || dataId=="undefined"){
       dataId="";
   }
   if(categoryType==null || categoryType=="undefined"){
       categoryType="";
   }
   if(postType==null || postType=="undefined"){
       postType="";
   }
    var queryString ={"page":gPage,"action":action,"dataId":dataId,"categoryType":categoryType,"postType":postType,"id":id};
    ajaxRequest("/post/trackEngagementAction",queryString,function(data){});
}


$('.NOBJ').live("click",
        function() { 
            var newsId = $(this).data('id');
            var postId = $(this).attr('data-postid');
            var categoryType = $(this).attr('data-categoryType');
            var postType = $(this).attr('data-postType');
            var showDivId = "streamDetailedDiv",
            hiddenDivId = "poststreamwidgetdiv";
            renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
        }
    );
function renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType,recentActivity){
    try{
        scrollPleaseWait('commentSpinLoader_'+newsId);
        var URL = "/news/renderPostDetailed?postId=" + postId + "&categoryType=" + categoryType + "&postType=" + postType+"&id="+newsId+"&recentActivity="+recentActivity;
        var data="";
        ajaxRequest(URL,data,function(data){renderNewsDetailedPageHandler(data,showDivId, hiddenDivId,newsId)},"html");
        
    }catch(err){
        console.log("Exception occurred in the View=="+err);
    }
}

function renderNewsDetailedPageHandler(html,showDivId,hiddenDivId,newsId){
      $("html,body").scrollTop(0);
    scrollPleaseWaitClose('commentSpinLoader_'+newsId);
    scrollPleaseWaitClose('featureitemspinner');
    if($("#notificationHomediv").is(":visible")){
        $("#notificationHomediv").hide();
    }
   $("#"+showDivId).css('list-style','none outside none');
   $("#"+showDivId).css('padding','5px');
   if($("#"+showDivId).length>0)
   {
   $("#"+showDivId).html(html).show();
   $("#"+hiddenDivId).hide();
   }
   else
   {
   $('#curbsideStreamDetailedDiv').html(html).show();
   $("#curbsidePostCreationdiv").hide();
   }
   bindUserActionView();
}
function bindUserActionView(){ 
     var ww;
              $('.userFollowView,.dFollowers').live("mouseover",function(){ 
              clearTimeout(ww) ;
                var count =  $(this).attr("data-count");
                if(count>0){
                if($(".detailpage .userFollowView").is(':visible') == false){
                      $(".detailpage .userView,.detailpage .userLoveView").hide();
                     $(".detailpage .userFollowView").show();
                }         
            }
              });
              
                     $('.detailpage .userLoveView,.detailpage .dLoves').live("mouseover",function(){ 
              clearTimeout(ww) ;
               var count =  $(this).attr("data-count");
                if(count>0){
                if($(".detailpage .userLoveView").is(':visible') == false){
                      $(".detailpage .userView,.detailpage .userLoveView").hide();
                     $(".detailpage .userLoveView").show();
                }         
            }
              });
              
              
              
                        $('.userEventAttendView,.dEventAttend').live("mouseover",function(){ 
              clearTimeout(ww) ;
               var count =  $(this).attr("data-count");
                if(count>0){
                if($(".userEventAttendView").is(':visible') == false){
                      $(".userView,.userLoveView,.userEventAttendView").hide();
                     $(".userEventAttendView").show();
                }         
            }
              });   
              
                $('.userSurveyView,.dSurvey').live("mouseover",function(){ 
              clearTimeout(ww) ;
               var count =  $(this).attr("data-count");
                if(count>0){
                if($(".userSurveyView").is(':visible') == false){
                      $(".userView,.userLoveView,.userEventAttendView,.userSurveyView").hide();
                     $(".userSurveyView").show();
                }         
            }
              });   
              
              
              
              
              
            $(".detailpage .dFollowers").live("mouseout",function(){ 
             ww =  setTimeout(function(){
                 $(".detailpage .userFollowView").hide();
             },500);
         
        });
         $(".detailpage .dLoves").live("mouseout",function(){ 
             ww =  setTimeout(function(){
                 $(".detailpage .userLoveView").hide();
             },500);
         
        });
        
          $(".dEventAttend").live("mouseout",function(){ 
             ww =  setTimeout(function(){
                 $(".userEventAttendView").hide();
             },500);
         
        });
          $(".dSurvey").live("mouseout",function(){ 
             ww =  setTimeout(function(){
                 $(".userSurveyView").hide();
             },500);
         
        });
        
        $(".detailpage .userFollowView").live("mouseout",function(){ 
          $(".detailpage .userFollowView").hide();
        });
         $(".detailpage .userLoveView").live("mouseout",function(){ 
          $(".detailpage .userLoveView").hide();
        });   
       
        $(".detailpage .dFollowers,.detailpage .dLoves,.dEventAttend,.dSurvey").click(function( event ) { 
           auPage = 0;
          auPopupAjax = false;
          var id =  $(this).attr("data-id");
          var actionType =  $(this).attr("data-actiontype");
            var categoryId =  $(this).attr("data-categoryId");
         var count =  $(this).attr("data-count");
               if(count>0){
                   getActionUsers(id,actionType,"post",categoryId); 
               }
         
        });
         $(".detailMoreUsers").live("click",function(){
          auPage = 0;
          auPopupAjax = false;
      //var postId =  $(this).attr("data-postid");
       var id =  $(this).attr("data-id");
      var actionType =  $(this).attr("data-actiontype");
       var categoryId =  $(this).attr("data-categoryId");
         var count =  $(this).attr("data-count");
      getActionUsers(id,actionType,'post',categoryId);
     })
}
function IsUserFollowAGroup(userId,postId,categoryType,postType){
    try{        
        var URL = "/group/isUserFollowAGroup?userId="+userId+"&postId="+postId+"&categoryType="+categoryType;
        var data="";
        ajaxRequest(URL,data,function(data){IsUserFollowAGroupHandler(data,userId,postId,categoryType,postType)},"json");
    }catch(err){
        console.log("Exception occurred in the IsUserFollowAGroup=="+err);
    }
}

function IsUserFollowAGroupHandler(data,userId,postId,categoryType,postType){
    if(data.data == true)
        renderPostDetailPage('admin_PostDetails','contentDiv',postId,categoryType,postType);
    else{
        if(categoryType==3){
         window.location.href = "/"+data.groupName;   
        }else if(categoryType==7){
         window.location.href = "/"+data.groupName+"/sg/"+data.subgroupName;   
        }
         
    }
        
}

function renderGameDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType){
    try{
        scrollPleaseWait('commentSpinLoader_'+postId);
        var URL = "/game/rendergGameDetailed?postId=" + postId + "&categoryType=" + categoryType + "&postType=" + postType+"&id="+newsId;
        var data="";
        ajaxRequest(URL,data,function(data){renderGameDetailedPageHandler(data,showDivId, hiddenDivId,postId)},"json");
        
    }catch(err){
        console.log("Exception occurred in the View=="+err);
    }
}

function renderGameDetailedPageHandler(data,showDivId, hiddenDivId,postId){
    try{ 
     if(data.status=='success'){        
        window.location.href="/"+data.gameName+"/"+data.currentScheduleId+"/detail/game";   
    }else if(data.status=='failure'){
        
    }   
    }catch(err){
        console.log("Exception occurred in the View=="+err);
    }
    bindUserActionView();
}


 function loadPostSnippetWidget(PostId,from){ 
     var timezone=  jstz.determine_timezone().name();
     if(typeof from !== "undefined"){         
         var URL = "/career/getJobdetail?id=" +PostId +"&Timezone=" +timezone;
     }else{
         var URL = "/post/getPostWidget?postId="+PostId +"&Timezone="+timezone;
     }   
        var data="";
        ajaxRequest(URL,data,function(data){getPostSnippetWidgetHandler(data)},"html");
 
  }
function getPostSnippetWidgetHandler(data){
   
    $("#myModal_body").html(data);
     $("#myModalLabel").addClass("stream_title paddingt5lr10");
    $("#myModalLabel").html(Translate_Post);
    $("#myModal_footer").hide();
    $("#myModal").modal('show');
    $("#myModal").removeAttr('tabindex');
    setTimeout(function(){
        var elem = document.getElementById ("postwidgetContent");

    $('#copyurl').zclip({     
     path:'/js/ZeroClipboard.swf',
    copy:function(){return elem.innerHTML;}
    });
    },300);

}
function copypostwidget(siteurl){
     var elem = document.getElementById ("postwidgetContent");
    $('#copyurl').zclip({     
     path:'/js/ZeroClipboard.swf',
    copy:function(){return elem.innerHTML;}
    });
    
}
function treackAdUser(postId){
     var URL = "/advertisements/treackAdUser?PostId="+postId;
     var data="";

     ajaxRequest(URL,data,function(data){}); 
}

function featuredItemDetailPage(divId){
    
    $("#" + divId + " .postdetail").live("click touchstart",
        function() { 
            minimizeJoyride();
           var categoryType = $(this).attr('data-categoryType');  
        
            var streamId = $(this).data('id');
          
            g_streamId = streamId;
            g_pageType = divId;
            
            if(divId == "groupstreamMainDiv" || divId == "g_mediapopup" ){
                g_pageType = gType;
            }
            Global_ScrollHeight = $(document).scrollTop();
            //$('body, html').animate({scrollTop : 0}, 0);
            var postId = $(this).attr('data-postid');

            var categoryType = $(this).attr('data-categoryType');

            var postType = $(this).attr('data-postType');
            var newsId=postId;
                        g_pageType = 'streamMainDiv';
                        Global_ScrollHeight=$(document).scrollTop();
                        if(postType!=11 && postType!=12)
                        {
                            DetailPageDisplay(postId,categoryType,postType);
                         }
                        else if(postType==11)
                        {
                           
                            var showDivId = "streamDetailedDiv",
                            hiddenDivId = "poststreamwidgetdiv";
                            var newsId=postId;
                            renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
                        }
                         else if(postType==12)
                        {
                         
                            var showDivId = "streamDetailedDiv",
                            hiddenDivId = "poststreamwidgetdiv";
                            renderGameDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
                        }
       
       
       
       
            trackEngagementAction("PostDetailOpen",postId,categoryType,postType);
     
       
    });
}

function abuseComment(obj){
    var actionType = "AbuseComment";
    var streamId = $(obj).closest('ul.CommentManagementActions').attr('data-streamId');
    var commentId = $(obj).closest('ul.CommentManagementActions').attr('data-commentId');
    var postId = $(obj).closest('ul.CommentManagementActions').attr('data-postId');
    var categoryType = $(obj).closest('ul.CommentManagementActions').attr('data-categoryType');
    var networkId = $(obj).closest('ul.CommentManagementActions').attr('data-networkId');
     var queryString = {
            streamId:streamId,
            commentId:commentId,
            postId:postId,
            categoryType:categoryType,
            networkId:networkId,
            actionType:actionType
        };
    ajaxRequest("/post/commentManagement",queryString,function(data){abuseCommentHandler(data,obj);});
}
function abuseCommentHandler(json, obj){
    closeModelBox();
    if(json.status=="CommentAbused"){
        var streamId = $(obj).closest('ul.CommentManagementActions').attr('data-streamId');
        var postId = $(obj).closest('ul.CommentManagementActions').attr('data-postId');
        if($(obj).closest("div.stream_widget").find("#commentCount_"+postId).length>0){
            var commentCount = Number($(obj).closest("div.stream_widget").find("#commentCount_"+postId).text());
            if(commentCount==1 && $(obj).closest("div.stream_widget").find(".social_bar img.commented").length>0){
                $(obj).closest("div.stream_widget").find(".social_bar img.commented").addClass("comments");
                $(obj).closest("div.stream_widget").find(".social_bar img.commented").removeClass("commented");
            }
            $(obj).closest("div.stream_widget").find("#commentCount_"+postId).text(commentCount-1);//decreasing comment count
        }else if($(obj).closest("div.stream_widget").find("#det_commentCount_"+postId).length>0){
            var commentCount = Number($(obj).closest("div.stream_widget").find("#det_commentCount_"+postId).text());
            if(commentCount==1 && $(obj).closest("div.stream_widget").find(".social_bar img.commented").length>0){
                $(obj).closest("div.stream_widget").find(".social_bar img.commented").addClass("comments");
                $(obj).closest("div.stream_widget").find(".social_bar img.commented").removeClass("commented");
            }
            $(obj).closest("div.stream_widget").find("#det_commentCount_"+postId).text(commentCount-1);//decreasing comment count
        }else if($(obj).closest("div.customwidget_outer").find("#det_commentCount_"+postId).length>0){
            var commentCount = Number($(obj).closest("div.customwidget_outer").find("#det_commentCount_"+postId).text());
            if(commentCount==1 && $(obj).closest("div.customwidget_outer").find(".social_bar img.commented").length>0){
                $(obj).closest("div.customwidget_outer").find(".social_bar img.commented").addClass("comments");
                $(obj).closest("div.customwidget_outer").find(".social_bar img.commented").removeClass("commented");
            }
            $(obj).closest("div.customwidget_outer").find("#det_commentCount_"+postId).text(commentCount-1);//decreasing comment count
        }else if($(obj).closest("div#gameSocailActions").find("#det_commentCount_"+postId).length>0){
            var commentCount = Number($(obj).closest("div#gameSocailActions").find("#det_commentCount_"+postId).text());
            if(commentCount==1 && $(obj).closest("div#gameSocailActions").find(".social_bar img.commented").length>0){
                $(obj).closest("div#gameSocailActions").find(".social_bar img.commented").addClass("comments");
                $(obj).closest("div#gameSocailActions").find(".social_bar img.commented").removeClass("commented");
            }
            $(obj).closest("div#gameSocailActions").find("#det_commentCount_"+postId).text(commentCount-1);//decreasing comment count
        }else if($(obj).closest("li.woomarkLi").find("#commentCount_"+postId).length>0){
            var commentCount = Number($(obj).closest("li.woomarkLi").find("#commentCount_"+postId).text());
            if(commentCount==1 && $(obj).closest("li.woomarkLi").find(".social_bar img.commented").length>0){
                $(obj).closest("li.woomarkLi").find(".social_bar img.commented").addClass("comments");
                $(obj).closest("li.woomarkLi").find(".social_bar img.commented").removeClass("commented");
            }
            $(obj).closest("li.woomarkLi").find("#commentCount_"+postId).text(commentCount-1);//decreasing comment count
        }
        $(obj).closest("div.commentsection").animate({
            opacity: 0,
        }, 1500, function() {
            $(this).remove();//removing current comment
            if ($("#viewmorecomments_"+streamId).css('display') == 'none') {//If view more comments link is hidden
                var commentsDisplayed = $("#commentbox_"+streamId+" div.commentsection").length;
                if(commentsDisplayed==0){
                    if ($("#newComment_"+streamId).css('display') == 'none') {//If new comment area box is hidden then hide complete comment area
                        $("#cId_"+streamId).hide();
                    }else{//hide comments display box but the new comment area is visible
                        $("#commentbox_"+streamId).hide();
                    }
                }
            }else{//If view more comments link is visible
                var commentsDisplayed = $("#commentbox_"+streamId+" div.commentsection").length;
                if(commentsDisplayed==0){//If no comments are displayed then call the view more comments method
                    var categoryType = $(obj).closest('ul.CommentManagementActions').attr('data-categoryType');
                    viewmoreComments('/post/postComments',postId,streamId,categoryType);
                }
            }
            var page = $(obj).closest('ul.CommentManagementActions').attr("page");
            if(page=="gameScedule"){
                applyLayout();
            }
            
        });
        
        
    }
}