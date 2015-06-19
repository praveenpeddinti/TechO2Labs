// common ajaxRequest function is used in the whole application...
var g_userid = ""; // used in miniprofile popup..
var g_type = ""; // used in miniprofile popup..
var g_postType = ""; //used in social action bar
var g_postId = ""; //used in social action bar
var g_groupId=""; //used in social action bar
var g_profileImage="";//used in profile image upload
var g_profileImageName = "";//used to profile image name
var inviteMentionArray=new Array();
var globalspace = new Object();
var intervalIdNewpost=0;
var intervalIdCurbpost=0;
var g_curbside_categoryID="";
var g_curbside_hashtagID="";
var notificationHistory = 0;
var startLimit=0;
var notificationAjax = false;
var checkNotificationStatus = false;
var postSocialStatsInterval = 0;
var curbSocialStatsInterval = 0;
var Global_ScrollHeight=0;
var gPage="";
var referenceUserId = 0;
var g_divId;
var g_maxFiles = 10*1024*1024;

  //var timezoneName = "Europe/Vienna";
  //var timezoneName = "EST";
var g_postIds = 0;
/** Please don't delete the below parameters **/
var pF1 = pF2 = pF3 = pF4 = pF5 = 0;
var socialActionIntervalTime,
    postIntervalTime,nodeSurveyTime,
    notificationTime;
    var hostName = location.hostname;
    var ObjectA;
    var clientRequestInterval= [];
var remoteAddress;
var jsonObject,use4storiesinsertedid=0,isThereReady = false;

var referralLinkId=0;
var referralUserEmail=0;
var topicPageDisaplay=0;
var leftMenuOriginalHeight =  '';
var isUserSessionValid="yes";

var impressions = new Object();
var TrackedAds = new Object();
var timezoneName=""
 if(jstz != undefined && jstz != 'undefined'){
      timezoneName = jstz.determine_timezone().name();
     }

if (!Array.prototype.map)
{
  Array.prototype.map = function(fun /*, thisp*/)
  {
    var len = this.length;
    if (typeof fun != "function")
      throw new TypeError();

    var res = new Array(len);
    var thisp = arguments[1];
    for (var i = 0; i < len; i++)
    {
      if (i in this)
        res[i] = fun.call(thisp, this[i], i, this);
    }

    return res;
  };
}

    var PostdetailArtifactSrc="";
    var PostdetailArtifactUri="";
    var NoOfPostdetailArtifacts=0;
    var CurrentArtifactpage=0;
    var PreviousCurrentArtifactpage=0;
   
   
   
  


function ajaxRequest(url, queryString,callback,dataType,beforeSendCallback) { 

    checkSession();
    var pathname = window.location.pathname;    
    if(isUserSessionValid=="yes" || pathname.toLowerCase().indexOf("site") >= 0 || pathname.toLowerCase().indexOf("common") >= 0 || pathname.toLowerCase().indexOf("marketresearchview") >= 0 ||pathname.toLowerCase().indexOf("profile") >= 0  ||pathname.toLowerCase().indexOf("invite") >= 0)
    {
    var data = queryString;
    //alert(queryString);
    if(dataType==null || dataType==undefined){
        dataType = "json";
    }
   
    if(typeof(data)=="object"){
        data.timezone = timezoneName;
    }else{
        if($.trim(queryString)==""){
          data = "timezone="+timezoneName;   
        }else{
         data = queryString +"&timezone="+timezoneName; 
        }
    }
 
    $.ajax({
        dataType: dataType,
        type: "POST",
        url: url,
        async: true,
        data: data,
        success: function(data) {  
       
             if(dataType == "json"){ 
            try{
                
                if(data != ""){                    
                    if(typeof data.code != "undefined" && data.code == 440){
                         
                        showSessonTimeoutPopup();
                     
                         return;
                    }
                }else{                    
                    return;
                }
                }catch(err){
                  //console.log("ajax request--"+err);
                }  
            }else if(dataType == "html"){ 
                try{
                    var jsonHtmlObj = JSON.parse(data);                        
                    if(jsonHtmlObj.code == 440){
               
                showSessonTimeoutPopup();
                return;
              }  
                    }catch(err){
            }
            }
          
            if(callback!="" && callback != null && callback != "undefined"){
                 callback(data);
            }
           
        },
        error: function(data) {     
         // console.log("in error Common method--"+data.toSource());
//alert("in error Common method--"+data.toSource());
        },
         beforeSend: function() {
             if(beforeSendCallback!=null && beforeSendCallback!=undefined){
                   beforeSendCallback();
             }
             
            }
        
    });
    }else{
       
     showSessonTimeoutPopup();
}
}
function  showSessonTimeoutPopup(){
    //alert(sessionStorage.globalSurveyFlag);
    if(sessionStorage.globalSurveyFlag == 1){
       unsetSpotFromNode();
       logoutSurveyPage();  
    }
    if(socketNotifications != null && socketNotifications != "undefined"){
        console.log("ckear inter");
          socketNotifications.emit("clearInterval", sessionStorage.old_key); 
          socketNotifications.emit("disconnect");
          socketNotifications.disconnect();
          
           if(typeof socketPost != null && typeof socketPost != "undefined"){
                socketPost.disconnect();
           }
           if(socketTrackNodeObject != null && socketTrackNodeObject != "undefined"){
                socketTrackNodeObject.disconnect();
           }
          
          
         
    }
  if(phpSessionTimeOut != null && phpSessionTimeOut != "undefined"){
   clearTimeout(phpSessionTimeOut); 
  }
     document.cookie = "r_u" + "=" + location.pathname+";path=/";
     $("#sessionTimeoutLabel").html(Translate_YourSessionTimedOut);
     $("#sessionTimeout_body").html(Translate_PleaseLoginToContinue);
     $("#sessionTimeoutModal").modal('show');
     $("#login_btn").live("click",function(){
        window.location="/";
     });
}
function setPageLength(pageLength, pageType) {
    scrollPleaseWait('spinner_admin');
    if (pageType == "usermanagement") {
        g_pageLength = pageLength;
        getUsermanagementDetails(0, $("#searchTextId").val());
    }
    if (pageType == "newCurbsideCategory") {
        g_pageLength = pageLength;
        getCurbsideCategorymanagementDetails(0, $("#searchTextId").val());
    }
    if (pageType == "newHelpDescription") {
        g_pageLength = pageLength;
        getHelpIconListmanagementDetails(0, $("#searchTextId").val());
    }
     if (pageType == "advertisement") {
        g_pageLength = pageLength;
        loadAdvertisementsForAdmin(0,$("#searchTextId").val());
    }else if (pageType == "surveyanalytics") {
        g_pageLength = pageLength;
        getSurveyAnalyticsDetails(0,$("#filterSurvey").val(), $("#searchTextId").val());
    }
     else if (pageType == "broadcastnotifications") {
        g_pageLength = pageLength;
         g_pageNumber =1;
        loadBroadCastNotificatonsForAdmin(1,$("#searchMsgId").val());
    }

}
//author: karteek.v
function getMiniProfile(userid,streamId) {
    scrollPleaseWait('stream_view_spinner_'+streamId);
    var queryString = "userid=" + userid;
    ajaxRequest("/user/getMiniProfile", queryString, function(data){getMiniProfileHandler(data,streamId)})
    
    //ajaxRequest("/user/trackMinMentionWindowOpen",queryString,function(data){});
}
//author: karteek.v
function getMiniProfileHandler(data,streamId) {
    scrollPleaseWaitClose('stream_view_spinner_'+streamId);
    var item = {
        'data': data
       
    };
    $("#myModal_body").html($("#miniProfileTmpl_render").render(item));
    $("#profile_aboutme").html($("#profile_aboutme").text());
    $("#myModalLabel").addClass("stream_title paddingt5lr10");
    $("#myModalLabel").html("Profile summary");
    $("#myModal_footer").hide();
    $("#myModal").modal('show');
    if(!detectDevices()){
      $("[rel=tooltip]").tooltip();
   }
}



/*
 * replaceString() is used to check for @mention not available in follower/following users list and replace the @mention with errored atmention
 * @author Sagar
 */
function replaceString(strVal, search,displaymention, type){
    var count=0;
    var index=strVal.indexOf(search);
    while(index!=-1){
        count++;
        var charBeforeString = strVal.substr(index-3,3);
        if(charBeforeString!='<b>' || index==0){
            strVal = strVal.substr(0, index) + '<span class="atmention_error dd-tags" contenteditable="false"><span style="position:relative;" onmouseover="getNetworkUsers(this,\''+displaymention+'\',\''+type+'\')"><b>'+search+'</b></span><i style="color:#B94A48" onclick="removeAtMentionError(this)">X</i></span>' + strVal.substr(index+search.length);
        }
        index=strVal.indexOf(search,index+1);
        
    }
    return strVal;
}

/*
 * displayErrorMessage() is used to display the error message
 * It will be called in validating the post (or) if any error will get on posting
 * @author Sagar
 */
function displayErrorMessage(key,val){
    $("#"+key+"_em_").text(val);                                                   
    $("#"+key+"_em_").show(); 
    $("#"+key+"_em_").fadeOut(7000);
    $("#"+key).parent().addClass('error');
}
function displayError(key,val){
    $("#"+key).text(val);                                                   
    $("#"+key).show(); 
    $("#"+key).fadeOut(7000);
   // $("#"+key).parent().addClass('error');
}
/*
 * removeErrorMessage() is used to remove the error message
 * It will be called after success of posting
 * @author Sagar
 */
function removeErrorMessage(key){
    $("#"+key+"_em_").text("");
    $("#"+key).parent().removeClass('error');
    $("#"+key+"_em_").hide();
}    
/*
 * replaceAtMentionErrors() is used to replace the atmention error span
 * It will be called after selecting on item of over data
 * @author Sagar
 */


function clearerrormessage(obj)
{    
    
$('#'+obj.id).siblings('div').fadeOut(2000);
$('#'+obj.id).parent('div').addClass('success');
$('#'+obj.id).parent('div').removeClass('error');

}



   

 function menuactive (obj){

        $(".sidebar-nav ul li ").removeClass('active');
        $("#"+obj.id).addClass('active');

        
    }
    function loadGroupDetailPage(groupId){
    var queryString = "groupId=" + groupId;
    ajaxRequest("/group/userFollowGroup", queryString, loadGroupDetailPageHandler);
}
function loadGroupDetailPageHandler(){
    
}

function bindGroupsFollowUnFollow(pageId){
     $("#followGroupInDetail img.followbig").live( "click",
        function(){ 
            var content=Translate_unfollowGroup_subgroupsUnfollowed;
            var groupId = $(this).closest('span.noborder').attr('data-groupid');        
            var param ={groupId:groupId,type:"UnFollow",obj:this};
            openModelBox("error_modal", "Group", content, Translate_NO, Translate_Yes, followOrUnfollowGroupFromDetail, param);
          
        }
    );
   $("#followGroupInDetail img.unfollowbig").live( "click",
        function(){
            var groupId = $(this).closest('span.noborder').attr('data-groupid');
            var category = $(this).closest('span.noborder').attr('data-category');
            followOrUnfollowGroup(groupId,"Follow");
            $("#GroupFollowers").attr("onclick","getUserFollowers('"+groupId+"','"+category+"');");
            $("#GroupImages").attr("onclick","getGroupImagesAndVideos('"+groupId+"','"+category+"');");
             $("#GroupDocs").attr("onclick","getGetGroupDocs('"+groupId+"','"+category+"');");
            $("#conversations").attr("onclick","loadGroupConversations('"+groupId+"','"+category+"');");           
            $("#groupFormDiv").show();
            $("#groupstreamMainDiv").show();
            $('#groupFollowersCount').html(Number($('#groupFollowersCount').text())+1)
             $("#UPF").show('');
                $(this).attr('data-original-title',Translate_Unfollow);
            $(this).attr({
               "class":"followbig"
            });
            
            trackViews($("#groupstreamMainDiv div.post.item.groupsDiv:not(.tracked)"), "GroupStream");
        }
    );
   }

/**
 * Description: To show the spinner before data in loaded
 * @author Praneeth
 * @returns shows spinner
 */
function scrollPleaseWait(spinnerId, divId){
    var loaderScript = '<div id="loader_'+spinnerId+'" style="z-index: 99999; left:0;right:0; text-align: center; top: 0;bottom:0; position: absolute;display: none" ><div id="cl_spiral_'+spinnerId+'" class="loader" ><div id="SpinLoader"><img src="/images/icons/loading_spinner.gif"></div></div></div>';
    $("#"+spinnerId).html(loaderScript);
    $("#loader_"+spinnerId).show();
   
    
    setSpinnerPosition(spinnerId, divId);
}
/**
 * Description: To hide the spinner after data in loaded
 * @author Praneeth
 * @returns hides spinner
 */
function scrollPleaseWaitClose(spinnerId){
    $("#loader_"+spinnerId).hide();
//     if($(".surveySavingRes").length>0){
//       $(".surveySavingRes").hide();
//    }
}

/**
 * Description: To set the position of the spinner
 * @author Praneeth
 * @returns position of spinner
 */
function setSpinnerPosition(spinnerId, divId){
     var formHeight = $("#"+divId).height();
     var spinnerHeight = $("#canvasLoader_"+spinnerId).height();
     var totalHeight = $("#"+divId).height()+$("#canvasLoader_"+spinnerId).height();
     var spinnerPos=totalHeight/2;
     $("#cl_spiral_"+spinnerId).css("padding-top", spinnerPos-spinnerHeight);
}

//author: surehs reddy

function getMiniCurbsideCategoryProfile(categoryId,streamId) {
    scrollPleaseWait('curbside_spinner_'+streamId);
    var queryString = "categoryId=" + categoryId;
    ajaxRequest("/curbsidePost/getCurbsideMiniProfile", queryString, function(data){getMiniCurbsideCategoryProfileHandler(data,categoryId,streamId);})
}
//author suresh reddy
function getMiniCurbsideCategoryProfileHandler(data,categoryId,streamId) {
    scrollPleaseWaitClose('curbside_spinner_'+streamId);
    var item = {
        'data': data
    };
    $("#myModal_body").html($("#miniCurbsideCategoryProfileTmpl_render").render(item));
    $("#myModalLabel").addClass("stream_title paddingt5lr10");
    $("#myModalLabel").html(consultname + data.categorySummary);
    $("#myModal_footer").hide();
    $("#myModal").modal('show');
     $(".CurbsideCategorySearch").click(function(){ //alert('1');
         $(document).bind("click", function(e) { 
            $("#searchbox").addClass("open");
        });
         $("#myModal").modal('hide');
         var CurbsidecategorySearchText = $(this).attr('data-name');
       
        $('#SearchTextboxBt').val(CurbsidecategorySearchText);
          $("#searchbox").addClass("open");
          scrollPleaseWait("search_spinner","search");
        startProjectSearch();
        var queryString ={"page":"Curbsidecategory","action":"Curbsidecategory","dataId":CurbsidecategorySearchText,"categoryType":"","postType":""};
   ajaxRequest("post/trackEngagementAction",queryString,function(data){});
    }
    );
    if(!detectDevices()){
      $("[rel=tooltip]").tooltip();
   }
}



var page=1;
var isDuringAjax=false;
function getInfiniteScrollLoader(divId){
    return '<div id="'+divId+'_loading" class="infscr-loading" style="display: none;"><img src="/images/icons/loading_spinner.gif" ></div>';
} 
/**
 * @author Sagar Pathapelli
 * @param {type} URL
 * @param {type} CollectionName
 * @param {type} MainDiv
 * @param {type} NoDataMessage
 * @param {type} NoMoreDataMessage
 * @returns 
 */

function getCollectionData(URL, CollectionName, MainDiv, NoDataMessage, NoMoreDataMessage,id){

    if(typeof globalspace.previousStreamIds == "undefined" || page==1 ){
        globalspace.previousStreamIds = "";
    }
    var newURL = URL+"?"+CollectionName+"_page="+page; 
    var data = {previousStreamIds:globalspace.previousStreamIds};
    ajaxRequest(newURL,data,function(data){getCollectionDataHandler(data,URL,CollectionName,MainDiv,NoDataMessage,NoMoreDataMessage,id)},"html");
}
function getCollectionDataHandler(html,URL,CollectionName,MainDiv,NoDataMessage,NoMoreDataMessage,id){
           scrollPleaseWaitClose('spinner_admin');
           scrollPleaseWaitClose('categories_spinner');
            scrollPleaseWaitClose('postSpinLoader');
            scrollPleaseWaitClose("groupfollowSpinLoader");   
            var dataArray = html.split('[[{{BREAK}}]]');
            html = dataArray[0];
            globalspace.previousStreamIds = dataArray[1];
            if(MainDiv == "surveyDashboardWall"){
                $('#surveyDashboardWallDiv,#dashboardtop').show();
                $("#surveyChart1,#surveyChart2,#surveyChart3").hide();
                 applyLayout();
            }
            if(html==0){//No data found
                
                 $("#"+MainDiv).addClass('NPF');
                 $("#"+MainDiv).html('<center class="ndm">'+NoDataMessage+'</center>');
                 if(!detectDevices()){  
                    $("[rel=tooltip]").tooltip();
                }
                 $("#"+MainDiv).css("height",'');
            }
            
             else if(html==-2 ){//No data found
                page++; 
                 if(isDuringAjax==false){
                    initializeScrolling(URL, CollectionName, MainDiv, NoDataMessage, NoMoreDataMessage,id);
                }else{
                    isDuringAjax=false;
                    $("#"+MainDiv+"_loading").hide();
                }
                
                $("#"+MainDiv+"_loading").hide();
                     initializeScrolling(URL, CollectionName, MainDiv, NoDataMessage, NoMoreDataMessage,id);
            }
            else if(html==-1){//No more data                
                if(MainDiv=="ProfileInteractionDiv"){
                    $("#"+MainDiv).append(getInfiniteScrollLoader(MainDiv));
                    applyLayout();
                    initializeScrolling(URL, CollectionName, MainDiv, NoDataMessage, NoMoreDataMessage,id);
                }
                 if(MainDiv=="ProfileInteractionDivContent"){
                    $("#"+MainDiv).append(getInfiniteScrollLoader(MainDiv));
                    applyLayoutContent();                      
                     initializeScrolling(URL, CollectionName, MainDiv, NoDataMessage, NoMoreDataMessage,id);
                }
                 if(MainDiv=="ProfileInteractionDiv"){
                     if($('#ProfileInteractionDiv li').length<=0){
                        $("#"+MainDiv).html('<div class="NPF"><center class="ndm">'+NoDataMessage+'</center></div>');
                     }else{
                        $("#"+MainDiv+"_loading").html(NoMoreDataMessage);
                        $("#"+MainDiv+"_loading").fadeOut(2000);
                     }
                 } 
                 if(MainDiv=="jobsListIndex")
                 {
                      if($('#jobsListIndex li').length<=0){
                        $("#"+MainDiv).html('<div class="NPF"><center class="ndm">'+NoDataMessage+'</center></div>');
                     }else{
                        $("#"+MainDiv+"_loading").html(NoMoreDataMessage);
                        $("#"+MainDiv+"_loading").fadeOut(2000);
                     }
                 }
                 else{
                        $("#"+MainDiv+"_loading").html(NoMoreDataMessage);
                        $("#"+MainDiv+"_loading").fadeOut(2000);
                     }

                
                if(!detectDevices()){  
                    $("[rel=tooltip]").tooltip();
                }
            }
            else
            { 
                
                 if(isDuringAjax==false){
                    $("#"+MainDiv).removeClass('NPF');
                    $("#"+MainDiv).append(getInfiniteScrollLoader(MainDiv));
                    if(MainDiv=='MoreGroupsDiv' || MainDiv=="ProfileInteractionDiv"){
                      applyLayout();  
                    }
                    if(MainDiv=='ProfileInteractionDivContent'){
                      applyLayoutContent();  
                    }
                    initializeScrolling(URL, CollectionName, MainDiv, NoDataMessage, NoMoreDataMessage,id);
                }else{
                    isDuringAjax=false;
                    $("#"+MainDiv+"_loading").hide();
                }
                   page++; 
                   try{
                    var status = true;
                    var sessionstatus = JSON.parse(html);
                    if(typeof sessionstatus.code != "undefined" && sessionstatus.code == 440){
                        status = false;
                    }
                    }catch(err){
                       ;
                    }                    
                    if(status == true){
                        if(typeof globalspace.previousStreamIds !== "undefined"){
                        var strVale = globalspace.previousStreamIds;
                        var arr=[];
                     arr.push.apply(arr, strVale.split(",").map(String));
                    $.each(arr, function(key, postId){
                            if($("#"+MainDiv+" div.post.item[data-postid="+postId+"]").length>0){
                                html = "<div>"+html+"</div>";
                                html = $(html)
                                    .find("div.post.item[data-postid="+postId+"]")
                                        .remove()
                                    .end().html();
                            }
                        });
                    }
                        $("#"+MainDiv).append(html);
                    }
                   if(MainDiv=='MoreGroupsDiv' || MainDiv=="ProfileInteractionDiv" || MainDiv=="newsDiv" ||  MainDiv=="gameprofilebox" ||  MainDiv=="jobsListIndex" || MainDiv=="diseaseTopicsbox" || MainDiv=="WebLinkWD" ){
                      applyLayout();  
                    }
                   if(MainDiv=='ProfileInteractionDivContent'){
                      applyLayoutContent(); 
                    $('span.seemore,span.postdetail').each(function(){
                        $(this).html('');
                        $(this).removeAttr('onclick class');
                        editorialCoverageC=$(this).parent('.cust_content').html();
                        editorialCoverageC=editorialCoverageC+'<a  class="showmoreC" data-id="'+$(this).parent('.cust_content').data('id')+'">&nbsp<i class="fa  moreicon moreiconcolor">'+Translate_Readmore+'</i></a>';
                        $(this).parent('.cust_content').html(editorialCoverageC);
                    });
                     }
                    if(MainDiv=='streamMainDiv')
                    {
                        $('span.seemore,span.postdetail').each(function(){
                        if($(this).parent().data('news')=='yes')
                        {
                            var ref = $(this).closest("li.media").find('a.NOBJ');
                            $(this).html('');
                            $(this).removeAttr('onclick class');
                            editorialCoverageC= $(this).parent().html();
                            editorialCoverageC=editorialCoverageC+"<span class='NDESC' data-postid='"+ref.data("postid")+"' data-categoryType='"+ref.data("categorytype")+"' data-postType='"+ref.data("posttype")+"' data-id='"+ref.data("id")+"'  class='seemore tooltiplink'> <i class='fa  moreicon moreiconcolor'>"+Translate_Readmore+"</i></span>";
                            $(this).parent().html(editorialCoverageC);
                        }
                    });
                    }
                  $("div.item").fadeIn(500);
                  if(!detectDevices()){  
                    $("[rel=tooltip]").tooltip();
                }
            }
            if(page<=2){
                initializeTrackViews(URL);
            }
/** Please don't delete the below code **/            
        jsonObject = getJsonObjectForNode();         

}
/**
 * @author Sagar Pathapelli
 * @param {type} URL
 * @param {type} CollectionName
 * @param {type} MainDiv
 * @param {type} NoDataMessage
 * @param {type} NoMoreDataMessage
 * @returns {undefined}
 */
function initializeScrolling(URL, CollectionName, MainDiv, NoDataMessage, NoMoreDataMessage,id){

    $(window).bind("scroll", function()
  
    {
        if($(window).scrollTop() >= $(document).height() - $(window).height()-20)
        {
            if(!isDuringAjax)
            {
                isDuringAjax=true;
                $("#"+MainDiv+"_loading").show();
             
                getCollectionData(URL, CollectionName, MainDiv, NoDataMessage, NoMoreDataMessage,id);
                if(URL=="/post/stream"){
                      trackEngagementAction("Scroll","",1); 
                }
                else if(URL == "/curbsidePost/getcurbsideposts"){
                      trackEngagementAction("Scroll","",2); 
                }
                else if(URL == "/group/groupStream"){
                                 
                   trackEngagementAction("Scroll",id, 3); 
                }else if(URL == "/group/getJoinMoreGroups"){
                     trackEngagementAction("Scroll", "", 3); 
                }else if(URL == "/user/getprofileintractions"){
                     trackEngagementAction("Scroll",id,22); 
                }else if(URL=="/game/loadGameWall"){
                    trackEngagementAction("Scroll","",9); 
                }
                else if(URL=="/career/loadJobs"){
                    trackEngagementAction("Scroll","",15); 
                }else if(URL=="/weblink/loadWebLinks"){
                    trackEngagementAction("Scroll","",21); 
                }else if(URL=="/news/index"){
                    trackEngagementAction("Scroll","",8); 
                }
               
            }
        }
    });
}




 /**
 * @author Sagar Pathapelli
 * @param {type} divId 
 * @param {type} URL
 * @param {type} sizeLimit
 * @param {type} extensions
 * @param {type} previewImage (this is the callback method after completing the image upload)
 * @param {type} postId  (postId='' for posts and should give the PostId for comments)
 * @returns 
 */
function initializeFileUploader(divId, URL, sizeLimit, extensions,maxFiles, postType, postId,callback,errorcallback,listE,multiple){ 
   multiple = (typeof multiple == 'undefined')?true:false;
  
    new qq.FileUploader({
        // pass the dom node (ex. $(selector)[0] for jQuery users)
        element:document.getElementById(divId),
        action: URL,
        sizeLimit:30* 1024 * 1024,// maximum file size in bytes
        allowedExtensions:JSON.parse("[" + extensions + "]"),        
        debug: false,
        multiple: multiple,
        maxConnections: maxFiles,
        listElement:document.getElementById(listE),
        // events         
        // you can return false to abort submit
        onSubmit: function(id, fileName){ if($.browser.msie){    scrollPleaseWait("ArtifactSpinLoader_"+divId, postId);$("#appendlist").hide();}g_postId = postId; g_divId = divId; g_maxFiles = maxFiles; g_postType = postType; },
        onProgress: function(id, fileName, loaded, total){   //scrollPleaseWait("ArtifactSpinLoader_"+divId, postId);
},
        onComplete: function(id, fileName, responseJSON){
            //$("#p_bar").attr("style","width:0%");
           // $("#progress_stripped").hide();
               if(responseJSON['success']==true){
                   
            var type=postId==''?postType:postType+'_'+postId;
            callback(id, fileName, responseJSON, type);
            
        }else if(responseJSON['success']!=false){
            errorcallback("File is too large, max file upload size is 10M.", postType, postId);            
        }
            scrollPleaseWaitClose("ArtifactSpinLoader_"+divId);
        },
        onCancel: function(id, fileName){},
        messages: {          
             typeError: Translate_file_typeError,
                    sizeError: Translate_file_sizeError,
                    minSizeError: Translate_file_minSizeError,
                    maxFileSizeError: Translate_file_maxFileSizeError,
                    emptyError: Translate_file_emptyError,
                    onLeave: Translate_file_onLeave
        },
        showMessage: function(message){ 
            errorcallback(message, postType, postId);
             scrollPleaseWaitClose("ArtifactSpinLoader_"+divId);
        
        }
     });  
}
/**
 * @author Sagar Pathapelli
 * @param {type} file
 * @param {type} response
 * @param {type} responseJSON
 * @param {type} postType
 * @returns {undefined}
 */
function previewImage(file, response, responseJSON, postType){
   $('#preview_'+postType).show();
    $('#previewul_'+postType).show();
    if(typeof globalspace[postType+"_UploadedFiles"] == 'undefined'){
        globalspace[postType+"_UploadedFiles"]=new Array();
        globalspace[postType+"_Artifacts"]=new Array();
    }
    $(".bar").each(function(key,value){        
//        if($(this).attr("style") == "width:100%"){
//            $(this).closest('li.qq-upload-success').hide();
//            
//        }
    })
    if(globalspace[postType+"_UploadedFiles"].length < 4){
        
          if($.inArray(responseJSON['filename'],globalspace[postType+"_Artifacts"]) < 0){ // doesn't exist
          
            //$('.qq-upload-list').hide(); 
           var data=responseJSON;
           var filetype=responseJSON['extension'];
           var imageid=responseJSON['savedfilename'];
           var image="";
           image = getImageIconByType(filetype);
           if(image==""){
                image=responseJSON['filepath'];
           }
           globalspace[postType+"_UploadedFiles"].push(responseJSON['filename']);
           globalspace[postType+"_Artifacts"].push(responseJSON['filename']);
           $('#previewul_'+postType).append('<li class="alert" ><i  id="'+imageid+'" ontouchstart="closeimages(this,'+"'"+responseJSON['savedfilename']+"'"+","+"'"+responseJSON['fileremovedpath']+"'"+","+"'"+responseJSON['filename']+"'"+","+"'"+postType+"'"+');"  onclick="closeimages(this,'+"'"+responseJSON['savedfilename']+"'"+","+"'"+responseJSON['fileremovedpath']+"'"+","+"'"+responseJSON['filename']+"'"+","+"'"+postType+"'"+');"  class="fa fa-times-circle deleteicon mobiledeleteicon "  data-dismiss="alert" ></i><i style="display:none" class="fa fa-search-plus zoomicon" ></i><a  class="postimgclose mobilepostimgclose "   href=""> </a>\n\
                <img src="'+image+'"></li>');
       }
        else { // does exist
             var message=response+ " "+Translate_Already_uploaded_please_upload_another_file;
             displayFileErrorMessage(postType, message);
        }
    }else{
         var message=" "+Translate_Already_uploaded_4_files;
         displayFileErrorMessage(postType, message);
     }
 }
 /*
 * This method is used for remove the  uploaded artifact.
 */
 function closeimages(obj,filename,filepath,image, type){
     var file=filepath;
     var queryString = "image="+image+"&file="+image+"&filepath="+file;
     ajaxRequest("/post/removeartifacts", queryString, function(data){removeArtifactHandler(data, type);}); 
 }
 function removeArtifactHandler(data, type){
    if(data.status=='success'){
      var filename=data.file;      
      var vindex = $.inArray(data.filename,globalspace[type+"_UploadedFiles"]);
        if(vindex != -1) {
                globalspace[type+"_UploadedFiles"].splice(vindex, 1);
        }
        var vindex = $.inArray(data.image,globalspace[type+"_Artifacts"]);
        if(vindex != -1) {
                globalspace[type+"_Artifacts"].splice(vindex, 1);
        }
    }
}
/**
 * @author Sagar Pathapelli
 * @param {type} filetype
 * @returns {String}
 */
function getImageIconByType(filetype) {
    var image="";
    if (filetype == 'ppt'||filetype=='pptx') {
        image = "/images/system/PPT-File-icon.png";
    } else if (filetype == 'pdf') {
        image = "/images/system/pdf.png";
    }  else if (filetype == 'mp3') {
        image = "/images/system/audio_img.png";
    } else if (filetype == 'mp4' || filetype == 'flv' || filetype == 'mov') {
        image = "/images/system/video_img.png";
    } else if (filetype == 'doc' || filetype == 'docx') {
        image = "/images/system/MS-Word-2-icon.png";
    } else if (filetype == 'txt') {
        image = "/images/system/notepad-icon.png";
    } else if (filetype == 'exe' || filetype == 'xls' || filetype == 'ini' || filetype == 'xlsx') {
        image = "/images/system/Excel-icon.png";
    } 
    return image;
}
function displayFileErrorMessage(postType, message){
    $('#'+postType+'_Artifacts_em_').show();
    $('#'+postType+'_Artifacts_em_').css("padding-top:20px;");
    $('#'+postType+'_Artifacts_em_').html(message);
    $('#'+postType+'_Artifacts_em_').fadeOut(4000);
}

function clearFileUpload(type){
    if(typeof globalspace[type+"_UploadedFiles"] != 'undefined'){
        if ((globalspace[type+"_UploadedFiles"]).length > 0) {
            globalspace[type+"_UploadedFiles"] = new Array();
        }
    }
    if(typeof globalspace[type+"_Artifacts"] != 'undefined'){
        if ((globalspace[type+"_Artifacts"]).length > 0) {
            globalspace[type+"_Artifacts"] = new Array();
        }
    }    
}

$(".helpmanagement").live("click", function() {
    var helpIconId = $(this).attr('data-id');
    var queryString = "helpIconId=" + helpIconId;
    ajaxRequest("/user/getHelpDescription", queryString, getHelpDescriptionHandler);
}
);

function getHelpDescriptionHandler(data) {    
    var item = {
        'data': data.data
    };
    
    if (data.data.Status == 1)
    {
        $("#myModal_body").html("<code>"+data.data.Description+"</code>");        
        $("#myModalLabel").addClass("stream_title paddingt5lr10");
        $("#myModalLabel").html(data.data.Name);
        $("#myModal_footer").hide();
        $("#myModal_body").append("<div class='playerH'/>");
        data.data.VideoPath=$.trim(data.data.VideoPath);
        if (data.data.VideoPath != null && data.data.VideoPath != ''){
             var options = '';
             loadDocumentViewer('playerH', data.data.VideoPath, options,"",360,550);
          }
          $("#myModal").modal('show');
            
        trackEngagementAction("HelpManagement",data.data.Id,0);     
       
    }
}
function blockOrReleaseCallback(param){
    var paramArray = param.split(',');
    var postId = paramArray[0];
    var categoryType = paramArray[1];
    var networkId = paramArray[2];
    var actionType = paramArray[3];
    var isBlockedPost = paramArray[4];
    blockOrReleasePost(postId, actionType, categoryType, networkId, isBlockedPost);
}
function blockOrReleasePost(postId, actionType, categoryType, networkId, isBlockedPost){
    var queryString = "postId="+postId+"&actionType="+actionType+"&categoryType="+categoryType+"&networkId="+networkId+"&isBlockedPost="+isBlockedPost;
    ajaxRequest("/post/abusePost",queryString,function(data){blockOrReleasePostHandler(data,postId, isBlockedPost);});
}
function abusePost(streamId, postId, actionType, categoryType, networkId,abuseFrom){
    var queryString = "postId="+postId+"&actionType="+actionType+"&categoryType="+categoryType+"&networkId="+networkId;
    ajaxRequest("/post/abusePost",queryString,function(data){abusePostHandler(data,streamId,abuseFrom);});
}
function suspendGame(streamId, postId, actionType, categoryType, networkId){
    var queryString = "postId="+postId+"&actionType="+actionType+"&categoryType="+categoryType+"&networkId="+networkId;
    ajaxRequest("/game/suspendGame",queryString,function(data){suspendGameHandler(data,streamId);});
}

function cancelScheduleGame(streamId, postId, actionType, categoryType, scheduleId){
    var queryString = "postId="+postId+"&actionType="+actionType+"&categoryType="+categoryType+"&scheduleId="+scheduleId;
    ajaxRequest("/game/cancelSchedule",queryString,function(data){cancelScheduleGameHandler(data,scheduleId);});
}


function blockOrReleasePostHandler(json, id, isBlockedPost){
    if(json.status=="success"){
        closeModelBox();
        $("#postitem_"+id).animate({
        opacity: 0,
        }, 1500, function() {
            $("#postitem_"+id).remove();
            
            $('#postsDisplayDiv').removeClass('NPF');
            
            if($('#postsDisplayDiv div.post.item').length<=0){
                $('#postsDisplayDiv').addClass('NPF');
                $('#postsDisplayDiv').html('<center>'+Translate_NoPostsFound+'</center>');
            }
            if(Number(isBlockedPost)==1){
                abusedTagCloud();
            }
        });
    }
}
function abusePostHandler(json, id,abuseFrom){
    if(json.status=="success"){
        animateAndRemovePost(id);
    }
}

function animateAndRemovePost(id){
        closeModelBox();
        $("#streamDetailedDiv").hide().html('');
        $("#poststreamwidgetdiv").show(); 
        var obj = $("#postitem_"+id);
        if($("#postitem_"+id).length===0){
            obj = $('.post.item[data-postid='+id+']');
        }
        $(obj).animate({
            opacity: 0,
        }, 1500, function() {
            $(obj).remove();
        });
}

function suspendGameHandler(json, id){
    if(json.status=="success"){
        closeModelBox();
        $("#postitem_"+id).animate({
        opacity: 0,
        }, 1500, function() {
            $("#postitem_"+id).remove();
            applyLayout();
        });
    }
}
function cancelScheduleGameHandler(json, id){
    if(json.status=="success"){
        closeModelBox();
      $("#cancelscheduleid_"+id).remove();
    }
}

/**
 * @author Sagar Pathapelli
 * @param {type} modelType
 * @param {type} title
 * @param {type} content
 * @param {type} closeButtonText
 * @param {type} okButtonText
 * @param {type} okCallback
 * @param {type} param (info_modal / alert_modal / error_modal)
 * @returns {undefined}
 */
function openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param,currentObj){ 
    $("#newModal .modal-dialog").removeClass('info_modal');
    $("#newModal .modal-dialog").removeClass('alert_modal');
    $("#newModal .modal-dialog").removeClass('error_modal');
    $("#newModal .modal-dialog").addClass(modelType);
    $("#newModalLabel").html(title);
    $("#newModal_body").html(content);
    $("#newModal_footer").show();
    $("#newModal_btn_close").html(closeButtonText);
    $("#newModal_btn_primary").show();
   if(okButtonText=='Nodisplay'){
        $("#newModal_btn_primary").html(okButtonText);
        $("#newModal_btn_primary").hide();
   } else{
        $("#newModal_btn_primary").html(okButtonText);
   }
   
    $("#newModal").modal('show');
    $("#newModal_btn_primary").removeAttr("disabled");
    $("#newModal_btn_primary").removeClass("disabled");
    if(typeof okCallback != 'undefined' && okCallback!=""){
       
        $("#newModal_btn_primary").unbind("click");
        $("#newModal_btn_primary").bind("click", function(){
            if(param instanceof Object){
                //
            }else{
                var paramArray = param.split(","); 
            
            if(title == Translate_Delete){
                  trackEngagementAction("PostDelete",paramArray[1],paramArray[2]);                  
            }
            else if(title == Translate_Promote){                
                 trackEngagementAction("PostPromote",paramArray[1],paramArray[2]);
            }
            else if(title == Translate_Flag_as_abuse){
                 trackEngagementAction("PostFlagAbuse",paramArray[1],paramArray[2]);
            }
            else if(title == Translate_file_postFeaturedItem){
                 trackEngagementAction("PostFeatured",paramArray[1],paramArray[2]);
            } 
            else if(title == Translate_Save_it_for_later){
                 trackEngagementAction("PostSaveItForLater",paramArray[1],paramArray[2]);
            } 
            }
              
           
            if(currentObj!='undefined' && currentObj!=undefined &&  currentObj!='' &&  currentObj!='null' &&   currentObj!=null)
             currentObj.hide();
            okCallback(param);
        });
    }
}
function closeModelBox(){ 
    $("#newModal").modal('hide');
}
function getGroupImagesAndVideos(groupId,category){
    $('.followersprofile').die('click');
 //    scrollPleaseWait("groupfollowSpinLoader");
   Global_ScrollHeight=$('#UPF').offset().top;
      $("html,body").scrollTop(Global_ScrollHeight);
      $("#UPF").html('');
       $(".poststreamwidget,#groupstreamMainDiv,#groupPostDetailedDiv").hide();
      //$(".poststreamwidget").hide();
      $("#UPF").show();
      $('#groupSideBar').hide();
      page=1;
      isDuringAjax=false;
     $(window).unbind("scroll");
     if(category=='Group'){
            $('#createSubGroup').hide();
      }
     getCollectionData('/group/GetGroupImages', 'groupId='+groupId+'&category='+category+'&ResourceCollection', 'UPF', Translate_NoDataFound,Translate_NoMoreData);
     //alert($("#GroupTotalPage div#UPF .followersprofile:not(.tracked)").length);
     setTimeout(function(){
     trackViews($("#GroupTotalPage div#UPF .followersprofile:not(.tracked)"), "Media");
 }, 500);
     
}
 function getGetGroupDocs(groupId,category){
     $('.followersprofile').die('click');
  //    scrollPleaseWait("groupfollowSpinLoader");
       Global_ScrollHeight=$('#UPF').offset().top;
      $("html,body").scrollTop(Global_ScrollHeight);
      $("#UPF").html('');
       $(".poststreamwidget,#groupstreamMainDiv,#groupPostDetailedDiv").hide();
      $("#UPF").show();
      $(".poststreamwidget").hide();
      $('#groupSideBar').hide();
      page=1;
      isDuringAjax=false;
      $(window).unbind("scroll");
      if(category=='Group'){
            $('#createSubGroup').hide();
      }
     getCollectionData('/group/GetGroupDocs', 'groupId='+groupId+'&category='+category+'&ResourceCollection', 'UPF', Translate_NoDataFound,Translate_NoMoreData);
     
     setTimeout(function(){
     trackViews($("#GroupTotalPage div#UPF .followersprofile:not(.tracked)"), "Resources");
 }, 500);
 

}
function openOverlay(url,image,div,height,width,atStart){ 
    if(height == undefined || height == "" || height == 0){
        height = 230;
    }
    if(width == undefined || width == "" || width == 0){
        width = 230;
    }
    jwplayer(div).setup({
        file:url,
        image:image,
        width:width,
        height:height,  
        aspectratio:'16:9',
        autostart:atStart
    });
}

var lastScroll = 0;
$(window).scroll(scrollEvent);
function scrollEvent()
{
    //Sets the current scroll position
    var st = $(this).scrollTop();
    //Determines up-or-down scrolling
    if (st > lastScroll){
       //alert("DOWN");
       if ($(this).scrollTop() > 260) {
            var leftMenuOriginalHeight = $('#menu_bar>ul#menu').height();
            leftMenuOriginalHeight = Number(leftMenuOriginalHeight)<800?800:leftMenuOriginalHeight;
            $('#menu_bar').addClass("fixed");
            var windowHeight = $(window.top).height();
           // alert(leftMenuOriginalHeight+"==="+windowHeight);
            var footerHeight = Number($("#footer").height());
            var visibleContentHeight = windowHeight - footerHeight;
            var leftMenuTop = leftMenuOriginalHeight - visibleContentHeight+100;
            $('#menu_bar').css("top","-"+leftMenuTop+"px");
        }
        else{
            $('#menu_bar').removeAttr("style");
            $('#menu_bar').removeClass("fixed");
        }
    }
    else {
       //alert("UP");
       var top = Number($("#header").height())+10;
       if ($(this).scrollTop() < top) {
           $('#menu_bar').removeClass("fixed");
       }
       $('#menu_bar').css("top","0px");
    }
    //Updates scroll position
    lastScroll = st;
}
function appendErrorMessages(message, formId ,id){
    if(typeof id != 'undefined' && id!=""){
        id="_"+id;
    }
    $('#'+formId+id+'_Artifacts_em_').show();
    $('#'+formId+id+'_Artifacts_em_').css("padding-top:20px;");
    $('#'+formId+id+'_Artifacts_em_').html(message).fadeOut(3000);
}

function removeAtMention(obj, type){
     if($(obj).closest("span.atwho-view-flag").parent().is("span")){
        $(obj).closest("span.atwho-view-flag").unwrap();
    }
    $(obj).closest("span.atwho-view-flag").remove();
    var id = $(obj).closest("span.atwho-view-flag").find("span.at_mention").attr('data-user-id');
    array_pop(globalspace[type], Number(id));
}

function findAndReplaceHashtagsNotInSystem(editorData){
    var isValidate=false;
    var mentionString = editorData.clone().find("span").remove().end().html();
    if(mentionString.indexOf("#")>=0){
        var myString = mentionString.substr(mentionString.indexOf("#")+ 1);           
        var type = 'hashtag_'+editorData.attr('id');
        var myArray = myString.split('#');
        for(var i=0;i<myArray.length;i++){
            if(myArray[i].length>1){
                var hashtagData = "";
                if(myArray[i].indexOf(' ')>=0){
                    hashtagData = myArray[i].substr(0, myArray[i].indexOf(' ')); 
                    hashtagData = $.trim(hashtagData);
                    if(hashtagData.length >1){
                      
                        if(hashtagData.indexOf('<')>0){
                            hashtagData = hashtagData.substr(0, hashtagData.indexOf('<')); 
                        }
                       var resultString = replaceHashtagString(editorData.html(), '#'+hashtagData,hashtagData, type);
                    editorData.html(resultString);  
                    }
                   
                    
                }else{
                    if(myArray[i].indexOf('<')>0){
                        hashtagData = myArray[i].substr(0, myArray[i].indexOf('<')); 
                    }else{
                        hashtagData = myArray[i];//alert(hashtagData);
                    }
                    var resultString = replaceHashtagString(editorData.html(), '#'+hashtagData,hashtagData, type);
                    editorData.html(resultString); 
                }
            }
       // }
        }
    }
    return isValidate;
}
/*
 * @author Sagar
 */
function replaceHashtagString(strVal, search,displayhashtag, type){
    var count=0;
    var index=strVal.indexOf(search);
    while(index!=-1){
        count++;
        var prevStr = strVal.substr(0, index-1);
        var spaceIndex = prevStr.lastIndexOf(" ");
        var reqStr;
        if(spaceIndex!=-1){
            reqStr = prevStr.substr(spaceIndex);
        }else{
            reqStr = prevStr;
        }
        var urlPattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/
        if(!urlPattern.test(reqStr)){
            var charBeforeString = strVal.substr(index-3,3);
            if(charBeforeString!='<b>' || index==0){
                strVal = strVal.substr(0, index) + '<span contenteditable="false" class="atwho-view-flag atwho-view-flag-#"><span class="dd-tags hashtag"><b>#'+displayhashtag+'</b><i onclick="removeHashTag(this,\'hashtag_editable\')">X</i></span><span contenteditable="false">&nbsp;<span></span></span></span>' + strVal.substr(index+search.length);
            }
        }
        
        index=strVal.indexOf(search,index+1);
    }
    return strVal;
}



function editProfileFirstNameDetails() { 
    $("#editProfileFirstName").show();
    $("#updateAndCancelFirstNameIconUploadButtons").show();
    $("#editProfileFirstNameDescriptionText").show();  
    $("#profileFirstName").hide();
}
function closeEditProfileFirstNameDescription(){
    
    $('body, html').animate({scrollTop : 0}, 0);
    //$("#editProfileFirstNameDescriptionText").html(''); 
    $("#editProfileFirstName").hide();
    $("#updateAndCancelFirstNameIconUploadButtons").hide();
    $("#editProfileFirstNameDescriptionText").html($("#profileFirstName").text()).show();  
    $("#profileFirstName").show();
}
function closeEditProfileLastNameDescription(){
    //$("#editProfileLastNameDescriptionText").html('');
    $("#editProfileLastName").hide();
    $("#updateAndCancelLastNameIconUploadButtons").hide();
    $("#editProfileLastNameDescriptionText").hide(); 
    $("#profileLastName").show();
}
function closeEditProfileAboutMeDescription()
{
    $("#editProfileAboutMe").hide();
    $("#closeEditGroupDescription").hide();
    $("#editProfileAboutMeDescriptionText").hide();  
    $("#updateAndCancelAboutMeUploadButtons1").css("display","none"); 
    $("#profile_AboutMe").show();
}
   

function editProfileLastNameDetails() {    
    $("#editProfileLastName").show();
    $("#updateAndCancelLastNameIconUploadButtons").show();
    $("#editProfileLastNameDescriptionText").html($("#profileLastName").text()).show();  
    $("#profileLastName").hide();
}
function saveEditProfileFirstName(userId,valueType,Invalid_characters_in_First_Name,First_name_cannot_blank) {
      
    var profileFirstName = $.trim($("#editProfileFirstNameDescriptionText").text());
   
    if (profileFirstName != '') {
        if (!profileFirstName.match(/^[a-zA-Z_-]+$/) && profileFirstName!="")
               {
                   
                $('#ProfileUpdateError').html(Invalid_characters_in_First_Name);
                $("#ProfileUpdateError").css("display", "block");
                $("#ProfileUpdateError").fadeOut(5000);
               }
        else {
            var queryString = "profileFirstName=" + profileFirstName + "&UserId=" + userId + "&type=" + valueType;
            ajaxRequest("/user/editprofilenamedetails", queryString, editProfileFirstNameDetailsHandler);
        }
    }

    else
    {
        $('#ProfileUpdateError').html(First_name_cannot_blank);
        $("#ProfileUpdateError").css("display", "block");
        $("#ProfileUpdateError").fadeOut(5000);
    }
    
}
function saveEditProfileLastName(userId,valueType,Invalid_characters_in_last_Name,last_name_cannot_blank) {
      
    var profileLastName = $.trim($("#editProfileLastNameDescriptionText").html());      
    if(profileLastName != '' && profileLastName != 0)
    {    
         if (!profileLastName.match(/^[a-zA-Z_-]+$/) && profileLastName!="")
               {
                   
                $('#ProfileUpdateError').html(Invalid_characters_in_last_Name);
                $("#ProfileUpdateError").css("display", "block");
                $("#ProfileUpdateError").fadeOut(5000);
               }
               else
               {
                 var queryString ="&profileLastName=" + profileLastName+ "&UserId=" + userId+"&type="+valueType;
                 ajaxRequest("/user/editprofilenamedetails", queryString, editProfileLastNameDetailsHandler);  
               }
        
    }
    else
    {
            $('#ProfileUpdateError').html(last_name_cannot_blank);
            $("#ProfileUpdateError").css("display", "block");
            $("#ProfileUpdateError").fadeOut(5000);
    }
    
}
function editProfileFirstNameDetailsHandler()
    {
        $("#profileFirstName").html($("#editProfileFirstNameDescriptionText").html());   
    $("#editProfileFirstName").hide();
    $("#updateAndCancelFirstNameIconUploadButtons").hide();
    $("#editProfileFirstNameDescriptionText").hide(); 
    $("#profileFirstName").show();
        }
function editProfileLastNameDetailsHandler()
    {
    $("#profileLastName").html($("#editProfileLastNameDescriptionText").html());   
    $("#editProfileLastName").hide();
    $("#updateAndCancelLastNameIconUploadButtons").hide();
    $("#editProfileLastNameDescriptionText").hide(); 
    $("#profileLastName").show();

        }
        

    
    function editProfileAboutMeDetails() {    
    $("#editProfileAboutMe").show();
    $("#closeEditGroupDescription").show();
    $("#editProfileAboutMeDescriptionText").show();  
    $('#editProfileAboutMeDescriptionText').focus();
    $("#updateAndCancelAboutMeUploadButtons1").show();  
    $("#profile_AboutMe").hide();    
}

function saveEditProfileAboutMe(userId,valueType) {
      
    var profileAboutMe =$("#editProfileAboutMeDescriptionText").val();    
    var queryString = "profileAboutMe=" + profileAboutMe + "&UserId=" + userId+"&type="+valueType;
    ajaxRequest("/user/editprofileaboutmedetails", queryString, editProfileAboutMeDetailsHandler);
}

function editProfileAboutMeDetailsHandler()
        {   
     $("#profile_AboutMe").html($("#editProfileAboutMeDescriptionText").val()); 
     var descLength=$.trim($("#editProfileAboutMeDescriptionText").val()).length;
     if(descLength>200){
         var decToShow=$("#editProfileAboutMeDescriptionText").val().substring(0, 200);
        $("#profile_AboutMe").html(decToShow); 
        $("#displayTotalAboutMe").show();
     }
      if(descLength!=0){
      $('#profile_AboutMe').removeClass('Descriptionplaceholder');
     }else{
      $('#profile_AboutMe').addClass('Descriptionplaceholder');   
     }
     $("#editProfileAboutMe").hide();
     $("#closeEditGroupDescription").hide();
     $("#editProfileAboutMeDescriptionText").hide();
     $("#updateAndCancelAboutMeUploadButtons1").hide();
     $("#profile_AboutMe").show();
        }
        
     
function ProfilePreviewImage(id, fileName, responseJSON, type)
{
    var data = eval(responseJSON);     
    g_profileImageName = data.savedfilename;
    g_profileImage = '/upload/profile/' + data.savedfilename;
    $('#updateAndCancelProfileImageUploadButtons').show();
    $('#profileImagePreviewId').val('/upload/profile/' + data.savedfilename);
    $('#profileImagePreviewDisplay').val('/upload/profile/' + data.savedfilename);
    $('#profileImagePreviewDisplay').attr('src', g_profileImage);
    
    $('#profileImagePreviewId').attr('src', g_profileImage);
    $('#previewDiv').show();

}
function cancelProfileImageUpload(oldImage,type){
    
  
     $('#profileImagePreviewId').val(oldImage); 
     $('#profileImagePreviewId').attr('src',oldImage);  
     $('#updateAndCancelProfileImageUploadButtons').hide();
     $('#profileImagePreviewDisplay').attr('src', '');
         $('#previewDiv').hide();
     bindMouseEvents();
      g_profileImage='';
     
}

function saveUserProfileImage(userId, type){
    var queryString='';
    
       queryString = "profileImage=" + g_profileImage +"&profileImageName="+g_profileImageName+ "&UserId=" + userId+"&type="+type;   
    ajaxRequest("/user/saveProfileImage", queryString, saveProfileImageHandler);
    
}

function saveProfileImageHandler(responseJSON){
    var data = eval(responseJSON);
    var imageSrc70 = data.imagePath70+data.imageName;
    var imageSrc250 = data.imagePath250+data.imageName;
        $('#updateAndCancelProfileImageUploadButtons').hide();
        $('#profileImagePreviewId').attr('src',imageSrc250);
        $("#profileImage_header").attr('src',imageSrc70);
        $("#businessProfileImage").attr('src',imageSrc70);
        $('#profileImagePreviewDisplay').attr('src', '');
         $('#previewDiv').hide();
        g_profileImage='';
}



    function  viewProfileDetails()
    {
        $('#viewPersonalInfoId').show();
        $("#editableProfileDiv").hide();
        $("#profileViewDiv").show();
        
    }
        function editInformation()
    {
        $("#editableProfileDiv").show();
        $("#profileViewDiv").hide();
        globalspace.inlineEdit = true;
        $('#editableProfileDiv input.textfield').on('blur', function(event){
            globalspace.currentDiv = $(event.target).attr('id');
                $('#editProfileSave').click();
        });
    }
    $("#CancelEdit").unbind( "click");
    $("#CancelEdit").bind( "click", 
        function(){            
            $("#editButtonId").show();
            //var userId = $(this).attr('data-id');
            viewProfileDetails();
        }
    );
    
function bindEditForProfile(){
    $("#CancelEdit").unbind( "click");
     $("#CancelEdit").bind( "click", 
        function(){       
             $('body, html').animate({scrollTop : 0}, 0);
            //var userId = $(this).attr('data-id');
            viewProfileDetails();
        }
    );
   $("#profile_AboutMe").unbind( "click");
     $("#profile_AboutMe").bind( "click", 
        function(){      
            //var userId = $(this).attr('data-id');
            editProfileAboutMeDetails();
        }
    );
    $(".editProfileLastName").unbind( "click");
    $(".editProfileLastName").bind( "click", 
        function(){            
            //var userId = $(this).attr('data-id');
            editProfileLastNameDetails();
        }
    );
    $(".editProfileFirstName").unbind( "click");
    $(".editProfileFirstName").bind( "click", 
        function(){            
            //var userId = $(this).attr('data-id');
            editProfileFirstNameDetails();
        }
    );
    
       $(".editProfileSpeciality").unbind( "click");
    $(".editProfileSpeciality").bind( "click", 
        function(){   
            //var userId = $(this).attr('data-id');
            editPersonalInformationDiv('Speciality');
        }
    );
     $(".editProfilePosition").unbind( "click");
    $(".editProfilePosition").bind( "click", 
        function(){
            editPersonalInformationDiv('Position');
        }
    );
     $(".editProfileCompany").unbind( "click");
    $(".editProfileCompany").bind( "click", 
        function(){    
            editPersonalInformationDiv('Company');
        }
    );
     $(".editProfileDisplayName").unbind( "click");
    $(".editProfileDisplayName").bind( "click", 
        function(){    
            editPersonalInformationDiv('DisplayName');
        }
    );
}

function profileErrorMessage(){

           $('#ProfileUpdateError').html("Cannot be blank");
            $("#ProfileUpdateError").css("display", "block");
            $("#ProfileUpdateError").fadeOut(5000);

    }
    
/*
 * to redirect to profile page when a user click on Name in miniprofile popup
 * author: Praneeth
 */    
$("div.profilesummary div.profileDetails,a.profileDetails,div.justificationUser").live( "click", 
        function(){           
            var displayName = $(this).attr('data-name');
            window.location.href ="/profile/"+displayName;
        }
 );
 
 /*
 * to redirect to group page when a user click on rightside widget in group activity
 * author: Praneeth
 */ 
// $(".rightWidgetGroupDetailPage").live( "click", 
//        function(){            
//             window.location.href = '/group/index';
//        }
// );
 
   $("div[name=GroupDetailInRightWidget]").live( "click", function(){
            var groupName=$(this).attr('data-name');           
            window.location="/"+groupName;
          // loadGroupDetailPage($(this).attr('data-id'));
        } );
 $('.d_img_outer_video_play').live( "click",function(){ 
     $('#showoriginalpicture').hide();
     $("#showoriginalpicture").removeAttr("src");
     var uri = $(this).find('>img').data('uri');
     var id = 'player';
     var videoImage = $(this).find('>img').attr('src');
     var options = {height:400,
        width:500,
        autoplay:true,
        callback:function(){
            //alert('document loaded');
    }
    };
     loadDocumentViewer(id, uri, options,videoImage,400,500);
   $("#myModal_old").modal('show');
 });
 
//  $('.d_img_outer_video_play_postdetail').live( "click",function(){ 
//     $('#showoriginalpicture').hide();
//     $("#showoriginalpicture").removeAttr("src");
//     var uri = $(this).find('>img').data('uri');
//     var id = 'player';
//     var videoImage = $(this).find('>img').attr('src');
//     var options = {height:400,
//        width:500,
//        autoplay:true,
//        callback:function(){
//            //alert('document loaded');
//    }
//    };
//     loadDocumentViewer(id, uri, options,videoImage,400,500);
//   $("#myModal_old").modal('show');
// });
// 
 
 $('.disablecomment').live( "click", 
        function(){        
             if($('.idisablecomments').val()==0)
             {
             $('.idisablecomments').val(1);
             $(this).removeClass('disablecomments').addClass('enablecomments');
             $(this).attr('data-original-title',Translate_EnableComments);
         }else{
             $('.idisablecomments').val(0);
             $(this).removeClass('enablecomments').addClass('disablecomments');
             $(this).attr('data-original-title',Translate_EnableComments);
         }
        }
 );

  $('.isdfeatured').live( "click", 
        function(){  
             if($('.iisfeatured').val()==0)
             {
             getFeacturedItemTitle();
             $('.iisfeatured').val(1);
             $(this).removeClass('featureditemdisable').addClass('featureditemenable');
            $(this).attr('data-original-title',Translate_RemoveFeatured);
         }else{
             $('.iisfeatured').val(0);
             $(this).removeClass('featureditemenable').addClass('featureditemdisable');
             $(this).attr('data-original-title',Translate_MarkAsFeatured);
         }
        }
 );
   $('.isAnonymous').live( "click", 
        function(){        
             if($('.iisAnonymous').val()==0)
             {
             $('.iisAnonymous').val(1);
             $(this).removeClass('anonymousdisable').addClass('anonymousenable');
            $("#anonymousId").attr('data-original-title','Remove Anonymous');
         }else{
             $('.iisAnonymous').val(0);
             $(this).removeClass('anonymousenable').addClass('anonymousdisable');
             $("#anonymousId").attr('data-original-title','Post As Anonymous');
         }
        }
 );
 
 /**
  * @author Karteek V
  * This method is used to get user stream settings
  * @returns html
  */
 function getUserSettings() {
    var URL = "/user/getUserStreamSettings?UserId=" + loginUserId;
    var data = "";
   ajaxRequest(URL,data,getUserSettingsHandler,"html");
}
function getUserSettingsHandler(html){             
            $("#settings").html(html).show();
            $("#renderNotification,#scrollDiv").hide();
            $("#notification_settings").text("Notifications");
}
function saveSettings() {
    var settingIds = 0;
    $("input[name='settings']:checked").each(function() {
        if (settingIds == 0) {
            settingIds = $(this).val();
        } else {
            settingIds = settingIds + "," + $(this).val();
        }
    });
    scrollPleaseWait("streamSettingsLoader");
    var queryString = "UserId=" + loginUserId + "&settingIds=" + settingIds;
    ajaxRequest("/user/saveStreamSettings", queryString, saveSettingsHandler);
}
function saveSettingsHandler(data) {
    scrollPleaseWaitClose("streamSettingsLoader");
    if (data.status == "success") {
        $("#streamSettingsMessage").show();
        $("#streamSettingsMessage").html("Settings updated successfully").removeClass().addClass("alert alert-success").fadeOut(4000, "");
    }else{
     $("#streamSettingsMessage").show();
        $("#streamSettingsMessage").html("Settings not saved").removeClass().addClass("alert alert-error").fadeOut(4000, "");
    }
}

function displayTextBox(obj){
    $(obj).hide();
    $('#editableProfileDiv div.profilefield.editicondiv').each(function(key, val){
        var divId = $(val).attr('id');
        $("#ProfileDetailsForm_"+divId).val($("#"+divId).html());
    });
    var id = $(obj).attr('id');
    $('#ProfileDetailsForm_'+id).show().focus();
    $('#ProfileDetailsForm_'+id).removeClass('hiddenprofile');
}


 function getFeaturedItems(){
     ajaxRequest("/post/getFeaturedItemsToDisplay","",getFeaturedItemsHandler,"html");
            
  }
function getFeaturedItemsHandler(html){
    $("#FeaturedItemsDisplay").html(html);
      $("#FeaturedItemsDisplay").show();
}
function featuredItemsHandler(data){    
    
        $("#FeaturedItemsDisplay").html(data);
        $("#FeaturedItemsDisplay").show();
     
}
function deleteInvitedAtMention(obj, arrayId, userId){
    $(obj).parent('span.dd-tags-close').remove();
    array_pop(globalspace[arrayId], userId);
}
$('.detailed_image_close').live('click',function(){
  if($('.jPlayer-container').length>0){
    $('.jPlayer-container').jPlayer("destroy");
  }
  $('#player').empty();
  $('#player').hide();
});
function strip_tags(str, allow) {
  // making sure the allow arg is a string containing only tags in lowercase (<a><b><c>)
  allow = (((allow || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return str.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
  });
}


$(function(){
    $.fn.scrollEnd = function(callback, timeout) {
        $(this).scroll(function() {
            var $this = $(this);
            if ($this.data('scrollTimeout')) {
                clearTimeout($this.data('scrollTimeout'));
            }
            $this.data('scrollTimeout', setTimeout(callback, timeout));
        });
    };

$("#editable").bind('paste', function (event) {
 var $this = $(this); //save reference to element for use laster
 setTimeout(function(){ //break the callstack to let the event finish
   //  var strippedText = strip_tags($this.html(),'<p><pre><span><i><b><li></li><ul></ul>');
   var posttype=$this.attr('data-type');
   var snippethtml=$this.html()+" &nbsp;";
   snippethtml=snippethtml.replace(/<br>/g, "&nbsp;");
if ($this.attr('name') == 'curbsideEditablediv') {
    var strippedText = strip_tags(snippethtml, '<p><pre><span><i><b><li></li><ul></ul><u></u><strike></strike><ol></ol>');
} else {
    var strippedText = strip_tags($this.html(), '<p><pre><span><i><b><br><br/>');
}
 var urlPattern = /\b((?:(http|https)|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[&nbsp;{};:'".,<>?«»“”‘’]|\]|\?))/ig

    var text = strippedText;
    var results = text.match(new RegExp(urlPattern));
 if(results!=null){
    if($this.attr('isWebPreview')!=1){
    
     
var separators = ['&nbsp;',' ','</br>','<br>'];
var Weburl = results[0].split(new RegExp(separators.join('|'), 'g'));
       var weburl=$.trim( Weburl[0] );
       var queryString = {data:weburl,Type:"post"}; 
          // var queryString = {data:Weburl[0],Type:"post"}; 
          var div="";
       
          if(posttype=='group'){
               div='Groupsnippet_main';
          }else{
              div='snippet_main';
          }
          
        ajaxRequest("/post/SnippetpriviewPage", queryString, function(data){rendersnipetdetailsHandler(data,div);});
    } }
   
    
 strippedText=strippedText.replace(/\s+/g, ' ');
 $this.html(strippedText) ;
 $this.find('*').removeAttr('style');
// $this.find('*').removeAttr('class');
 var result = $('#editable');
    result.focus();
    placeCaretAtEnd( document.getElementById("editable") );

},0); 
    });
 
});

/*
 * WebSnippet preview handler.
 */
function rendersnipetdetailsHandler(data,div) {

    if (data.status == 'success') {
        $('#'+div).show();
        var item = {
            'data': data
        };
       
        $("#"+div).html(
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
function text_diff(first, second) {
        var start = 0;
        while (start < first.length && first[start] == second[start]) {
            ++start;
        }
        var end = 0;
        while (first.length - end > start && first[first.length - end - 1] == second[second.length - end - 1]) {
            ++end;
        }
        end = second.length - end;
        return second.substr(start, end - start);
}
/**
 * @author: Haribau
 * This method is used to place the cursor at end position when past the content in the post text area.
 */
function placeCaretAtEnd(el) {
    el.focus();
    if (typeof window.getSelection != "undefined"
            && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}
/**
 * @author: Vamsi krishna 
 * @param {type} userid
 * @param {type} type
 * @returns {object} json
 */
function userFollowUnfollowActionsFromProfile(userid, type) {    
    var queryString = "userid=" + userid + "&type=" + type;
    g_userid = userid;
    g_type = type;  
    scrollPleaseWait('popup_userFollow_spinner');
    ajaxRequest("/user/userFollowUnfollowActions", queryString, userFollowUnfollowActionsFromProfileHandler)
}
//author: vamsi krishna
function userFollowUnfollowActionsFromProfileHandler(data) {
 scrollPleaseWaitClose('popup_userFollow_spinner');
    var followingCnt = Number($("#followerscntb_" + g_userid).html());

    if (g_type == "follow") {
//        $("#userFollowunfollowa_" + g_userid).attr({
//            "class": "unfollow"
//        }); 
        $('#userFollowunfollowa_'+ g_userid).closest('i').attr("data-original-title",data.translate_unFollow);
    } else if (g_type == "unfollow") { 
//         $("#userFollowunfollowa_" + g_userid).attr({
//            "class": "follow"
//        }); 
        $('#userFollowunfollowa_'+ g_userid).closest('i').attr("data-original-title",data.translate_follow);
    }
}
/**
 * @author Karteek.V
 * @returns {Boolean}
 */
function detectDevices() {
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };
    if (isMobile.any()) {
        return true;
    } else {
        return false;
    }
}
/**
 * @Author Sateesh
 */
function filtericonchange(id){
    if(id =="c_filteractive"){
        $("#c_filteractive").hide();
        $("#c_filterinactive").show();
                
    }else{
                
        $("#c_filteractive").show();
        $("#c_filterinactive").hide();
    }
            
            
}
/**
 * @author Karteek.V
 */
function jScrollPaneInitialize(){
    
$('.scroll').jScrollPane(
    {
            showArrows: false,
            animateScroll: true,
            animateDuration: 500,
            mouseWheelSpeed: 200,
            keyboardSpeed: 120,
            /* This next parameter is new to jScrollpane-custom */
            animateSteps: true
    });
}
 /**
   * Vamsi Krishna
   * This function to get group Intro Pop up 
   */
 function getGroupIntroPopUp(groupId){  
    $("#myModal_body").load("/group/getGroupIntroPopUp",{groupId:groupId},groupIntroHandler);    
    $("#myModalLabel").addClass("stream_title paddingt5lr10");
    $("#myModalLabel").html(Translate_GroupProfile);
    $("#myModal_footer").hide();
    $("#myModal").modal('show');
  }
  
 function groupIntroHandler(){
     if(!detectDevices())
      $("[rel=tooltip]").tooltip();
          
 } 
 function bingGroupsIntroPopUp(){
     
        $(".followGroup img.followbig").live( "click", 
        function(){
            var groupId = $(this).closest('span.followGroup').attr('data-groupid');              
          followOrUnfollowGroup(groupId,"UnFollow");    
                  $(".followGroup img").removeClass("followbig");
                  $(".followGroup img").addClass("unfollowbig");
                   $(".followGroup img").attr("data-original-title",Translate_Follow);
                 $('#followingcntb_').html(Number($('#followingcntb_').text())-1);  
        }
    );
    $(".followGroup img.unfollowbig").live( "click", 
        function(){
             var groupId = $(this).closest('span.followGroup').attr('data-groupid'); 
            followOrUnfollowGroup(groupId,"Follow");
           $(".followGroup img").removeClass("unfollowbig");
                  $(".followGroup img").addClass("followbig");
                   $(".followGroup img").attr("data-original-title",Translate_Unfollow);
                   $('#followingcntb_').html(Number($('#followingcntb_').text())+1)  
        }
    );
    $("#groupDescription").live( "click", 
        function(){
             var groupName =$("#groupDescription").attr('data-groupName');    
             
            window.location="/"+groupName;
         
        }
    );
 }
 
 function setNiceScrollToDiv(divId,height,color,isZoom,innerDivId){
        $("#"+divId).attr("style","overflow:auto;height:"+height+"px;");
	$("#"+divId).niceScroll();
        if(typeof color != undefined && color != ""){
            $("#"+divId).niceScroll("#"+innerDivId,{cursorcolor:""+color});
        }
        if(typeof isZoom != undefined && isZoom != ""){
            $("#"+divId).niceScroll("#"+innerDivId,{boxzoom:""+isZoom});
        }
        
 }
 /**
  * @author Karteek.V
  * @param {type} divId
  * @param {type} uri
  * @param {type} postId
  * @returns {undefined}
  */
 function playAVideoAudio(divId,uri,postId){
     scrollPleaseWaitClose('stream_view_detailed_spinner_'+postId);
     
     jwplayer(divId).setup({
               file: uri,
                height: 200,
                width: 200,
                autostart:true
            }); 
 }
 
 function closeVideo(id){
      if(typeof id != undefined && id != ""){
         jwplayer('streamVideoDiv'+id).stop();
         $("#imgsingle_"+id).addClass("img_single");
         $("#imageVideomp3_"+id).show();
         $('#img_streamVideoDiv'+id).removeClass('videoThumnailNotDisplay');
         $('#img_streamVideoDiv'+id).addClass('videoThumnailDisplay');
         $("#playerClose_"+id).hide();
         //jwplayer("streamVideoDiv"+id).stop(); 
         if($('.jPlayer-container').length>0){
            $('.jPlayer-container').jPlayer("destroy");
          if (('#img_streamVideoDiv'+id).length > 0 ){
            $('#img_streamVideoDiv'+id).removeClass('videoThumnailNotDisplay');
            $('#img_streamVideoDiv'+id).addClass('videoThumnailDisplay');
        }
     }
 }
 }
$(document).ready(function() {
    /**
     * funtion to strip the script tags in a text field throughout the application on cut copy paste
     */
    $('input').bind("cut copy paste", function(e) {
     
            var $this = $(this); //save reference to element for use laster
            setTimeout(function() { //break the callstack to let the event finish
            var strippedText = strip_tags($this.val(), '');
            $this.val($.trim(strippedText));
            $this.focus();
            placeCaretAtEnd($this.get(0));

        }, 10); 
       });
    $('input').keypress(function(e) {
        var className = $(this).attr("class");          
        if ((e.which == 3 || e.which == 22 || (className != "span12 textfield groupnamerelatedfield" && e.which == 60) || (className != "span12 textfield groupnamerelatedfield" && e.which == 62))) {
            return false;
        }
    });

    $("#myModal").on("hidden", function() {
        if($.trim($('#myElement').html()).length>0){        
            jwplayer("myElement").stop();  
        }        
    });
    $("span.sharesection>i").live("click",function(){
        var $socialBar = $(this).closest('div.social_bar');
        var postId = $socialBar.attr('data-postId');
        var categoryType = $socialBar.attr('data-categoryType');
        var postType = $socialBar.attr('data-postType');
        var uri=sharePostUrl+"?postId="+postId+"&categoryType="+categoryType+"&postType="+postType+"&trfid="+loginUserId;
        bit_url(uri);
    });
    //*******This is used to share a post to FB*******start*****/
     window.fbAsyncInit = function() {
        FB.init({appId: fb_api_key, status: true, cookie: true, xfbml: true});
    };
    if($('#fb-root').length>0){
        var e = document.createElement('script');
        e.async = true;
        //e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        //document.getElementById('fb-root').appendChild(e);
        //*******This is used to share a post to FB*******end*****/
//        twttr.events.bind('tweet', function( event ) {
//            var queryString = {postId:globalspace.postId,
//                categoryType:globalspace.categoryType,
//                shareType : 'TwitterShare'
//            };
//            ajaxRequest("/post/savesharedlist", queryString,twitterSharedListCallback);
//        });
    }
});

function CommentEditableText(commentId) {
    $("#commentTextArea_" + commentId).unbind('paste');
    $("#commentTextArea_" + commentId).bind('paste', function(event) {
        var self = $(this);
        var orig = self.html();//existing text in textarea

        var $this = $(this); //save reference to element for use laster
        setTimeout(function() { //break the callstack to let the event finish
            //  var strippedText = strip_tags($this.html(),'<p><pre><span><i><b><li></li><ul></ul>');

            var strippedText = strip_tags($this.html(), '<p><pre><span><i><b><br><br/>');
            strippedText=strippedText.replace(/\s+/g, ' ');
            $this.html(strippedText);
            $this.find('*').removeAttr('style');
            var result = $("#commentTextArea_" + commentId);
            result.focus();
            //applyLayoutContent();
            
            var urlPattern = "(((https?)\:\/\/)|(www\.))[A-Za-z0-9][A-Za-z0-9.-]+(:\d+)?(\/[^ ]*)?";
    var text = strippedText;
    var results = text.match(new RegExp(urlPattern));
    if(results!=null){
      if($this.attr('isWebPreview')!=1){
         var Weburl = results[0].split("&nbsp");
         var weburl=$.trim( Weburl[0] );
        var queryString = 'data=' + weburl+'&CommentId=' + commentId+"&Type=comment";
          //var queryString = {data:Weburl[0],Type:"comment"}; 
        ajaxRequest("/post/SnippetpriviewPage", queryString, function(data){rendersnipetForCommentsHandler(data,commentId);});
    }
   }  
            
            
            placeCaretAtEnd(document.getElementById("commentTextArea_" + commentId));
        }, 0); 
    });
}
function rendersnipetForCommentsHandler(data,commentId) {
 
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

}
function loadDocumentViewer(id, uri, options,videoImage,height,width){ 
    $('.'+id).empty();
    var format = (/[.]/.exec(uri)) ? /[^.]+$/.exec(uri) : undefined;
    format = format.toString().toLowerCase();
     uri=location.protocol+"//"+window.location.host+uri;
     var style="style='width:1000px; height:480px;'";
      if(detectDevices()){ 
      style="style='width:300px; height:480px;'";
      }
    if(format == "pdf" || format == "ppt" || format == "txt" || format == "doc" || format == "docx" || format == "xls" || format == "xlsx"){ 
        var url = '<iframe src="https://docs.google.com/gview?url='+uri+'&embedded=true" '+style+' frameborder="0"></iframe>';
        $('.'+id).html(url);
     }else{
         if(videoImage != undefined && videoImage != ""){
                 videoImage = videoImage;
             }else{
                 videoImage = "";
             }
             var autostart = 'false';
         if(detectDevices()){ 
             if(format == "jpg" || format == "JPG" || format == "png" || format == "PNG" || format == "gif" || format == "GIF" || format == "jpeg"){
                uri  = uri.replace('/upload/public/thumbnails/','/upload/public/images/'); 
                uri  = uri.replace('/upload/group/thumbnails/','/upload/group/images/');
                $('.'+id).html('<img id="showoriginalpicture" src="'+uri+'"  style="max-width:100%;border: 12px solid #FFFFFF;">');
                 }else{
                  $('.'+id).html('<div id="player"></div>');
                 openOverlay(uri,videoImage,id,350,450,autostart);
             }
        }else{

            if(format == "jpg" || format == "JPG" || format == "png" || format == "PNG" || format == "gif" || format == "GIF" || format == "jpeg"){
          
           uri  = uri.replace('/upload/public/thumbnails/','/upload/public/images/'); 
           uri  = uri.replace('/upload/group/thumbnails/','/upload/group/images/');
           $('.'+id).html('<img id="showoriginalpicture" src="'+uri+'"  style="max-width:100%;border: 12px solid #FFFFFF;">');
            }else{
                autostart = 'true';
                $('.'+id).html('<div id="'+id+'"></div>');
                openOverlay(uri,videoImage,id,height,width,autostart);
            }
            
        }
     }
} 


     /**
   * Praneeth
   * This function to get subgroup Intro Pop up 
   */
 function getSubGroupIntroPopUp(subgroupId){  
    $("#myModal_body").load("/group/getSubGroupIntroPopUp",{subgroupId:subgroupId},subgroupIntroHandler);    
    $("#myModalLabel").addClass("stream_title paddingt5lr10");
    $("#myModalLabel").html(Translate_SubGroupProfile);
    $("#myModal_footer").hide();
    $("#myModal").modal('show');
  }
  
 function subgroupIntroHandler(){
     if(!detectDevices())
      $("[rel=tooltip]").tooltip();
          
 } 
 
 
 function bingSubGroupsIntroPopUp(){
     
        $(".followSubGroup img.followbig").live( "click", 
        function(){
            var maingroupId = $(this).closest('span.followSubGroup').attr('data-maingroupid'); 
            var subgroupId = $(this).closest('span.followSubGroup').attr('data-subgroupid'); 
             followOrUnfollowSubGroup(maingroupId,"UnFollow",'','',subgroupId); 
                  $(".followSubGroup img").removeClass("followbig");
                  $(".followSubGroup img").addClass("unfollowbig");
                   $(".followSubGroup img").attr("data-original-title",Translate_Follow);                  
                 $('#Subfollowingcntb_').html(Number($('#Subfollowingcntb_').text())-1);  
        }
    );
    $(".followSubGroup img.unfollowbig").live( "click", 
        function(){
             var maingroupId = $(this).closest('span.followSubGroup').attr('data-maingroupid'); 
            var subgroupId = $(this).closest('span.followSubGroup').attr('data-subgroupid'); 
            followOrUnfollowSubGroup(maingroupId,"Follow",'','',subgroupId);
           $(".followSubGroup img").removeClass("unfollowbig");
                  $(".followSubGroup img").addClass("followbig");
                   $(".followSubGroup img").attr("data-original-title",Translate_Unfollow);                   
                   $('#Subfollowingcntb_').html(Number($('#Subfollowingcntb_').text())+1)  
        }
    );
    $("#subgroupDescription").live( "click", 
        function(){
             var maingroupName =$("#subgroupDescription").attr('data-maingroupName'); 
             var subgroupName =$("#subgroupDescription").attr('data-groupName'); 
             window.location="/"+maingroupName+"/sg/"+subgroupName;
         
        }
    );
 }
    

   function showLoginPopup(){
     sessionStorage.sharedURL = document.URL;
    // alert(sessionStorage.sharedURL);
     $("#sessionTimeoutLabel").html(Translate_Login);
     $("#sessionTimeout_body").html(Translate_PleaseLoginToContinue);
     $("#sessionTimeoutModal").modal('show');     
}







function formatDates(year,month,date, formatString) {

	//if(formatDate instanceof Date) {

		var months = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		var yyyy = year;
		var yy = yyyy.toString().substring(2);
		var m = month;
		var mm = m < 10 ? "0" + m : m;
		var mmm = months[m];
		var d = date;
		var dd = d < 10 ? "0" + d : d;
		
//		var h = formatDate.getHours();
//		var hh = h < 10 ? "0" + h : h;
//		var n = formatDate.getMinutes();
//		var nn = n < 10 ? "0" + n : n;
//		var s = formatDate.getSeconds();
//		var ss = s < 10 ? "0" + s : s;

		formatString = formatString.replace(/yyyy/i, yyyy);
		formatString = formatString.replace(/yy/i, yy);
		formatString = formatString.replace(/mmm/i, mmm);
		formatString = formatString.replace(/mm/i, mm);
		formatString = formatString.replace(/m/i, m);
		formatString = formatString.replace(/dd/i, dd);
		formatString = formatString.replace(/d/i, d);
//		formatString = formatString.replace(/hh/i, hh);
//		formatString = formatString.replace(/h/i, h);
//		formatString = formatString.replace(/nn/i, nn);
//		formatString = formatString.replace(/n/i, n);
//		formatString = formatString.replace(/ss/i, ss);
//		formatString = formatString.replace(/s/i, s);
		return formatString;

}

   
   
    function checkDuplicate (reportRecipients) {
        var recipientsArray = reportRecipients,
            textHash = {};
        for(var i=0; i<recipientsArray.length;i++){
            var key = $.trim(recipientsArray[i].toLowerCase());
          //  console.log("lower:" + key);
            if(textHash[key]){
                //alert("duplicated:" + key);
                return true;
            }else{
                textHash[key] = true;
            }
        }
       // alert("no duplicate");
        return false;
    }
function CleanArray(actual)
{
    var newArray = new Array();
    for(var i = 0; i<actual.length; i++)
    {
        if ($.trim(actual[i]))
        {
            newArray.push($.trim(actual[i]));
        }
    }
    return newArray;
}
function expanddiv(id){
   // alert(id
    var message= $.trim($('#userReferral_message').text())
    if(message.length>0){
        $("#"+id).animate({"min-height": "70px", "max-height": "200px"}, "fast");
       // $("#button_block").slideDown("fast");
        $("#"+id).removeClass("referrerplaceholder");
    }else{
         $("#"+id).addClass("referrerplaceholder");
    }
    
        return false;

}
//end referral js

//DSN -related start
function  getTopics(){//alert("hello");
    var queryString = {topics:true};
    ajaxRequest("/disease/categoriesdetails", queryString, TopicsResultHandler,"html");   
}
function TopicsResultHandler(data){//alert(data);
    $( "#topicsListDiv" ).html(
   data
); 

}

function  getGroups(startLimit)
{
    var queryString = {startLimit:startLimit};
    ajaxRequest("/disease/GetUserGroupsLeftMenu", queryString, groupsLeftResultHandler,"html");   
}

function groupsLeftResultHandler(data){
    $( "#groupsListDiv" ).append(
   data
); 

}
function activateMenu(obj)
{

sessionStorage.objclicked=obj;
//alert('activate'+obj);
//var objclicked=getLocalStorage('objclicked');obj=objclicked;
//alert(localStorageObj);
    $(".topicsClassAdmin").removeClass("disease_topicssectiondiv_active");
    //$(".topicsClass").removeClass("disease_topicssectiondiv_active");
     //$(this).removeClass("disease_topicssectiondiv");
   if(obj!='undefined')
    $("#"+obj).addClass("disease_topicssectiondiv_active"); 
    //sessionStorage.objclicked='';
}


 
 
 function getOauthNetworks()
 {
    ajaxRequest("/common/GetOauthNetworks", "", getOauthNetworksHandler,"html");    
 }
 
 function getOauthNetworksHandler(data)
 {
   
     if(data!=0)
     {
         $("#oauthNetworksUL").html(data);
     }
 }
 
 function showNetworks(){
     // $("#networks").removeClass("networks_arrow_down").addClass("networks_arrow_up");

    $("#networks").toggleClass("networks_arrow_up");
    $("#network_logos").toggle();
  }
  
  function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function loginOauthOnProvider(fromNetwork,providerLink,redirectUrl,streamId)
 {
     if(streamId!='')
     {
    var queryString='streamId='+streamId;
          
    ajaxRequest("/disease/DeleteNeteworkInvite",queryString,function(data){
     
   },'');
     }
    var split=redirectUrl.split("/site");
   window.open(split[0]+"?fromNetwork="+fromNetwork+"&providerLink="+providerLink,'_blank');
   
   //   window.open( url+"&fromNetwork="+fromNetwork+"&providerLink="+providerLink,'_blank');
     //localStorage.providerLink=providerLink;
   //  var queryString={fromNetwork:fromNetwork,providerLink:providerLink};
    
     //ajaxRequest(url,queryString,function(data){});
         }



 function setLocalStorage(k,v){

 var win = document.getElementById('localStorageIFrame').contentWindow;
    var obj = {
       key: k,
       value:v
    };
    // save obj in subdomain localStorage

    win.postMessage(JSON.stringify({key: k, method: "set", data: obj}), "*");

}

function getLocalStorage(k){

 var win = document.getElementById('localStorageIFrame').contentWindow;
    win.postMessage(JSON.stringify({key: k, method: "get"}), "*");
 
    window.onmessage = function(e) {
	
      if(e && e.data)
	{
            if(IsJsonString(e.data) && typeof (JSON.parse(e.data).name))
            {
               var key =JSON.parse(e.data).key;
    var value =JSON.parse(e.data).value;
   
    localStorage.setItem(key,value);
    if(key=='categoryName')
    {
      loadTopicsFromLocalStorage();  
    }   
    else if(key!='categoryId' && key!='categoryName' )
    {
      //  alert('before'+value);
     $("#"+value).addClass("disease_topicssectiondiv_active"); 
     activateMenu(value);
    }
		// sessionStorage.k=JSON.parse(e.data);
		 
		
            }
	}
	    };
           
            return localStorage.getItem(k);



}
function removeLocalStorage(k)
{ localStorage.k=''; 
 var win = document.getElementById('localStorageIFrame').contentWindow;
    win.postMessage(JSON.stringify({key:k, method: "remove"}), "*");


}


  

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}



    
  function showPreview(id,url,type,position,displayPage){
     var queryString = 'id='+id+'&url='+url+'&type='+type+'&position='+position+'&displayPage='+displayPage;        
         ajaxRequest("/advertisements/showPreview",queryString,showPreviewHandler);
  } 
  
  function showPreviewHandler(data){ 
      var type=data.type;
      var position =data.position;      
      $("#myModal_body").html(data.htmlData);          
      if(type=="swf"){
          $('#swfTopDiv').show(); 
          $('#imgDiv_'+position).hide(); 
      }
      if(type=="mp4" || type=="mov"){
          $('#swfTopDiv').hide(); 
          $('#imgDiv_'+position).hide();
           openOverlay(data.url,'videoPlay_'+position,'videoPlay_'+position,'','','');  
           $('#videoPlay_'+position).show(); 
      }
      $("#myModalLabel").html(data.translate_AdvertisementPreview);
      $('#myModelDialog').css("width","auto");
     $("#myModal").modal('show');
     
      $("#myModal_footer").hide();
  }
  

  function showStreamAdPreview(id){
     var queryString = '&id='+id; 
         ajaxRequest("/advertisements/getaddview",queryString,showStreamAdPreviewHandler);
  } 
  
  function showStreamAdPreviewHandler(data){ 
      $("#myModal_body").html(data.htmlData);          
//      if(type=="swf"){
//          $('#swfTopDiv').show(); 
//          $('#imgDiv_'+position).hide(); 
//      }
//      if(type=="mp4" || type=="mov"){
//          $('#swfTopDiv').hide(); 
//          $('#imgDiv_'+position).hide();
//           openOverlay(data.url,'videoPlay_'+position,'videoPlay_'+position,'','','');  
//           $('#videoPlay_'+position).show(); 
//      }
      $("#myModalLabel").html("Advertisement Preview")
      $('#myModelDialog').css("width","auto");
     $("#myModal").modal('show');
     
      $("#myModal_footer").hide();
  }
  
  function trackAd(obj){   
      //alert("---");   
      var adId=$(obj).data('adid');  
      var queryString = 'adId='+adId;  
      var href=$(obj).attr('href');  
      var type=$(obj).data('type');
      var target=$(obj).attr('target');        
      if(type=="swf"){
      // window.open(href,target);      
      }
    
         ajaxRequest("/advertisements/trackAdvertisement",queryString,showPreviewHandler);
      
  }




  function editPersonalInformationDiv(type){      
     $('.editProfile'+type).hide();   
     $('#editProfile'+type).show();   
     $('#editProfile'+type+'Text').focus();
  }
 function saveEditPersonalInformation(field){         
   var value= $.trim($("#editProfile"+field+"Text").val());          
   var queryString = "value=" + value +  "&field=" + field;
   ajaxRequest("/user/updatePersonalInformationByType", queryString, saveEditPersonalInformationHandler);
 } 
 
 function saveEditPersonalInformationHandler(data){
     var type=data.type;
     var value=data.value;
     $('.editProfile'+type).html(value);
     $('.editProfile'+type).show();       
     $('#editProfile'+type).hide();
     if(value!=''){
      $('.editProfile'+type).removeClass(type+'placeholder');
     }else{
      $('.editProfile'+type).addClass(type+'placeholder');   
     }
     if(type=='DisplayName'){         
         $('.cvtitle').html(value+"'s CV");
         $('#ProfileInteractionsDisplayName').html(value+"'s "+Translate_Recent_Interactions);
         
     }
 }
 
 function closeEditPersonalInformation(type){
     $('.editProfile'+type).show();   
     $('.editProfile'+type).html($('.editProfile'+type).text());
     $("#editProfile"+type+"Text").val($('.editProfile'+type).text());
     $('#editProfile'+type).hide();   
 }
 
function initializationAtMentionsForCV(inputor){
    var inputorId = $(inputor).attr('id');
    
    if(!globalspace['cv_mention_'+inputorId]){
        globalspace['cv_mention_'+inputorId]=new Array();
         globalspace['cv_mention_Username_'+inputorId]=new Array();
    }
    var cv_at_mention_config = {
         at: "@",
         callbacks: {
               remote_filter: function (query, callback) {
                    if(typeof globalspace['cv_mention_'+inputorId] == 'undefined'){
                        
                        globalspace['cv_mention_'+inputorId]=new Array();
                         globalspace['cv_mention_Username_'+inputorId]=new Array();
                     }
                  var data = {searchKey:query,existingUsers:JSON.stringify(globalspace['cv_mention_'+inputorId])};
                  ajaxRequest("/post/getnetworkusers",data,callback);
               },
                 before_insert: function(value, $li){
                     
                     
                     var InvitedUserId = Number($li.attr('data-user-id'));
                     var authorsCount = $("#"+inputorId+"_currentMentions>span.dd-tags").length;
                if(authorsCount<5){
                     globalspace['cv_mention_'+inputorId].push(InvitedUserId);
                     var name=$li.attr('data-value').split(',');
                   //  var UserName=name[0].substring(1);
                  
                       globalspace['cv_mention_Username_'+inputorId].push(name[0]);
                     $(inputor+'_currentMentions').append("<span class='dd-tags hashtag' data-user-id="+InvitedUserId+"><b>"+$li.attr('data-value')+"</b><i data-name='"+name[0]+"' onclick='deleteInvitedAtMentionForCV(this, \"cv_mention_Username_"+inputorId+"\", "+InvitedUserId+")'>X</i></span>")
                 }else{
           
                    $('.interests').css('height','130px');
                   $("#"+inputorId+"_error").html(Translate_YouCanEnterMaximumOfFiveAuthors).show().fadeOut(10000);
                    setTimeout(function() { // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
                               $('.interests').css('height', '');

                           }, 8000);
               }                
                     return "";
                 },
                  matcher: function(flag, subtex) {
                    flag = '@';
                    subtex = flag+$.trim(subtex);
                    var match, regexp;
                    flag = flag.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
                    
                    regexp = new RegExp(flag + '([A-Za-z0-9_\+\-]*)$|' + flag + '([^\\x00-\\xff]*)$', 'gi');
                    match = regexp.exec(subtex);
                    if (match) {
                      return match[1].length>=3?match[1]:null;
                    } else {
                      return null;
                    }
                  }
             
           },
           
         tpl:"<li data-value='${DisplayName}' data-user-id=${UserId}><div class='d_name'>${DisplayName}</div> <i class='d_n_border'><img src='${profile45x45}'  /></i></li>",      
         //insert_tpl: "<span class='at_mention dd-tags' data-user-id=${UserId}><b>@${DisplayName}</b><i onclick='removeAtMentionForCV(this)'>X</i></span>",
         search_key: "DisplayName",
         show_the_at: true,
         limit: 50
     }
    $(inputor).atwho(cv_at_mention_config);
    
}
function deleteInvitedAtMentionForCV(obj, arrayId, userId){

  $(obj).parent('span.dd-tags').remove();
//    var i =  globalspace[arrayId].indexOf($(obj).attr('data-name'));
//
//        if(i > -1) {
//                globalspace[arrayId].splice(i, 1);
//                 
//        }
        
       globalspace[arrayId] = $.grep(globalspace[arrayId], function(value) {
  return value != $(obj).attr('data-name');
});   
    
}
  function loadExternalDocumentViewer(id, uri, options,videoImage,height,width){ 
    $('.'+id).empty();
    var format = (/[.]/.exec(uri)) ? /[^.]+$/.exec(uri) : undefined;
    format = format.toString().toLowerCase();
     uri=uri;
     var style="style='width:1000px; height:480px;'";
      if(detectDevices()){ 
      style="style='width:300px; height:480px;'";
      }
    if(format == "pdf" || format == "ppt" || format == "txt" || format == "doc" || format == "docx" || format == "xls" || format == "xlsx"){ 
        var url = '<iframe src="https://docs.google.com/gview?url='+uri+'&embedded=true" '+style+' frameborder="0"></iframe>';
        $('.'+id).html(url);
     }
     }


function setFooterPosition(){
    if (Number($('#sidebarnavrightId').height()) > 800) {
        $('#contentDiv').css('min-height', Number($('#sidebarnavrightId').height()) + 100);
    }else if(Number($('#menu_bar>ul#menu').height()) > 800){
        $('#contentDiv').css('min-height', Number($('#menu_bar>ul#menu').height()) + 100);
    }
}

function checkSession()
{  
    $.ajax({
        dataType: 'json',    
        type: "POST",
        url: "/user/checkSession",   
        async: false,
        success: function(data) {       
        checksessioncallback(data);
     
          
        }});
 
}
function checksessioncallback(data){
     if(data.code==440){
         isUserSessionValid= "no";  
       }         
       else{
           isUserSessionValid= "yes";
       } 
}



function getActionUsersHandler(html,streamId,actionType){
    scrollPleaseWaitClose('userFollow_spinner');
  if(auPage == 0){
   var jscroll = $('#userFollowersFollowings_body').jScrollPane({});
        var api = jscroll.data('jsp');
        api.destroy();
    isDuringAjax=true;
    $(".NPF,.ndm").remove();
    $("#userFollowersFollowingsLabel").addClass("stream_title paddingt5lr10");
    var label = "";
    if(actionType == "Followers"){
       var label =  "People Who Followed This";
    } else if(actionType == "EventAttend"){
       var label =  "People Who Attend This Event";
    } 
    else{
      var label =  "People Who Loved This";  
    }
    $("#userFollowersFollowingsLabel").html(label);
    $("#userFollowersFollowings_footer").hide();
    $(".modal-content").attr({'style':'max-height:400px'});
    $("#userFollowersFollowings").modal('show');

    if(html != 0){
        $("#userFollowersFollowings_body").addClass("scroll").html(html).attr({'style':'max-height:230px;'});   
  
    }
    if($('#userFollowUnfollowid div.span4').length >= 14){
     $("#userFollowersFollowings_body").jScrollPane({autoReinitialise: true, autoReinitialiseDelay: 200, stickToBottom: true});

        $("#userFollowersFollowings_body").bind('jsp-scroll-y', function(event, scrollPositionY, isAtTop, isAtBottom)
        {
            if (isAtBottom && auPopupAjax == false) {      
                auPage++;
                auPopupAjax=true;
               getActionUsers(streamId,actionType);
            }


        }
        );
    }   
  }else{
      scrollPleaseWaitClose('userFollow_spinner');
    isDuringAjax=true;
        if(html==0){  
           auPopupAjax =true;
        }else{
         $(".jspPane").append(html); 
         auPopupAjax =false;
        } 
  }
     
}


function changeSegmentOverley(){
    ajaxRequest("/user/changeSegmentPageLoad", "", changeSegmentOverleyHandler);   
}
function changeSegmentOverleyHandler(data){
    var modelType = 'error_modal';
    var title = data.title;
    var content = data.content;
    var closeButtonText = 'Close';
    var okButtonText = data.okButtonText;
    var okCallback = changeAdminSegment;
    var param = '';
    openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
    $("#newModal_btn_close").hide();
}
function changeAdminSegment(segmentId){
    var inputData = {segmentId:segmentId};
    ajaxRequest("/user/changeAdminSegment", inputData, changeAdminSegmentHandler);
}
function changeAdminSegmentHandler(data){
    if(data.status=="success"){
        window.location.reload();
    }
}
function changeLanguage(){
    var language = $("#LanguageId").val();
    var inputData = {language:language};
    ajaxRequest("/user/changeLanguage", inputData, changeLanguageHandler);
}
function changeLanguageHandler(data){
    if(data.status=="success"){
        window.location.reload();
    }
}

/* joyride highlight functionalites end */

/*@Author Haribabu
 * This method is used get cookie value by using cookie name 
 * This method is already existing in Login.php page .Now i removed form login.php page.
 */

 function getCookie(cname)
    {
        var name = cname + "=";
        var ca = document.cookie.split(';');

        for (var i = 0; i < ca.length; i++)
        {

            var c = $.trim(ca[i]);
            if (c.indexOf(name) == 0)
                return c.substring(name.length, c.length);
        }
        return "";
    }
    
/*@Author Haribabu
 * This method is used delete cookie value by using cookie name 
 * 
 */  
 function deleteCookie(name) {
  // If the cookie exists
  if (getCookie(name))
    createCookie(name,"",-1);
}
/*@Author Haribabu
 * This method is used create cookie value by using cookie name 
 * 
 */
function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function loadUserAchievementProgress(){
    ajaxRequest("/post/GetPictocvImages","",function(data){
        if($.trim(data)!=""){
           if($("#userAchievementProgress").length<=0){
                $("#streamMainDiv").prepend(data);
           }else{
               $("#userAchievementProgress").replaceWith(data);
           }
       }
    },"html");
}
function loadUserAchievementProgressByOppertunityType(oppertunityType, partialViewPath){
    var obj = {oppertunityType:oppertunityType,partialViewPath:partialViewPath};
    ajaxRequest("/common/GetPictocvImagesByOppertunityType",obj,function(data){
        userAchievementDisplayHandler(oppertunityType, data);
    },"html");
}




/*Joyride load from stream pages start*/


function invokeJoyrideByOpportunityId(opportunityType,pageNavigation)
{
   
    // alert(opportunityType+","+pageNavigation);
     var queryString ={opportunityType:opportunityType,pageNavigation:pageNavigation};
     if(pageNavigation=='yes')
       ajaxRequest("/post/invokeJoyrideByOpportunityId",queryString,invokeJoyrideByOpportunityIdHandler);
     else 
        ajaxRequest("/post/invokeJoyrideByOpportunityId",queryString,invokeJoyrideByOpportunityIdHandler,'html');
}

function invokeJoyrideByOpportunityIdHandler(data)
{
  // alert(data);
     $("#newUserJoyRideTipContent").html("");
      $(".joyride-tip-guide").remove();
      $("#minTourGuideDiv").hide();
   
    if(data.pageNavigation=='yes')
    {
         getNewUserJoyrideDetailsNextHandler(data);
      
    }
    else
    {
         getNewUserJoyrideDetailsHandler(data);
    }
  }
    
    
    





/*Joyride load from stream pages end*/

function userAchievementDisplayHandler(oppertunityType, data){
    if($.trim(data)!=""){
        if(oppertunityType=="News"){
            if($("#userAchievementProgress").length<=0){
                 $("#ProfileInteractionDivContent").prepend(data);
            }else{
                $("#userAchievementProgress").replaceWith(data);
            }
            applyLayoutContent();
        }else if(oppertunityType=="Career"){
            if($("#userAchievementProgress").length<=0){
                 $("#jobsListIndex").prepend(data);
            }else{
                $("#userAchievementProgress").replaceWith(data);
            }
            applyLayout();
        }else if(oppertunityType=="Profile"){
            if($("#userAchievementProgress").length<=0){
                 $("#ProfileInteractionDiv").prepend(data);
            }else{
                $("#userAchievementProgress").replaceWith(data);
            }
        }
    }
}




function GetFileSize(fileid) {
    
    try {
        var fileSize = 0;
        var errMsg = "";
        //for IE
        if ($.browser.msie) {
            //before making an object of ActiveXObject, 
            //please make sure ActiveX is enabled in your IE browser
            var objFSO = new ActiveXObject("Scripting.FileSystemObject");
            var filePath = $("#" + fileid)[0].value;
            var objFile = objFSO.getFile(filePath);
            var fileSize = objFile.size; //size in kb
            fileSize = fileSize / 1048576; //size in mb 
        }
        //for FF, Safari, Opeara and Others
        else {
            fileSize = $("#" + fileid)[0].files[0].size //size in kb            
            fileSize = fileSize / 1048576; //size in mb 
        }        
        if(fileSize > 2){
            errMsg = "file size is too large";            
        }else if(fileSize < 0){
            errMsg = "file size is too large";
        }
    }
    catch (e) {
        errMsg = "Error MSG: "+e;
    }
    return errMsg;
}
function setErrorMsg(id,errId,msg){
    //    $('.fileupload').fileupload('reset');
    $("#"+id).val("");
    $("#"+errId).text(msg);                                    
    $("#"+errId).show();
    $("#"+id).parent().addClass('error'); 
}

