<?php
include 'chatMessage.php';
?>



    <div class="g_mediapopup ">
    <div class="row-fluid chatcustomdiv">
    <div class="span12">
    <div class="span9">
         <div class="row-fluid ">
    <div class="span12 "><h2 class="pagetitle"><?php echo Yii::t('translation','Messaging'); ?></h2></div>
         
     </div>
    <div class="chatmessagearea" id="chatmessagearea" name="chatmessagearea" style="display: none">
    <div class="row-fluid">
    <div class="span12">
    <div class="span6">
     <div class="chat_subheader paddingtop4" id="recipientName"></div>
      <div id="typestatus"></div>
    </div>
        <div class="span6" style="display: none">
     <div class="pull-right"><input type="text" placeholder="<?php echo Yii::t('translation','Invite'); ?>..." size="40" name="q" id="inviteInput"></div>
    </div>
    </div>
    </div>
   
    <div class="chat_messagebox">
     <div class="scroll-pane" id="chatBoxScrollPane" style="min-height: 250px">
         <div id="chatData">
             
         </div>
          <div id="chatStatus" name="chatStatus" style="color: gray;display: none;">
            
         </div>
    </div>
    </div>
    <div class="padding8top messagetextarea" id="messagetextareadiv">
        <textarea name="" cols="" rows="" class="span12" id="mjmChatMessage" placeholder="<?php echo Yii::t('translation','Enter_message_here'); ?>..."></textarea>
    <div id="preview" class="preview" style="display:none">
    
   
   
    </div>
        <div class="postattachmentarea" style="display: none">
        <div class="pull-left whitespace">
        	<div class="advance_enhancement">
            <ul><li class="dropdown pull-left ">
                     
                   <div class="postupload">
                   <div id="uploadFile">
                   <div class="qq-uploader">
                   <div class="qq-upload-button" style="position: relative; overflow: hidden; direction: ltr;"><?php echo Yii::t('translation','Upload_a_file'); ?><input type="file" multiple="multiple" name="file" style="position: absolute; right: 0px; top: 0px; font-family: Arial; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;"></div>
                   </div>
                   </div>
                   </div>   
          
                    </li>
                   
                    </ul>
            
           </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <div class="span3 customdiv3">
        
        <div class="grouphomemenuhelp alignright "> 
            <a class="chat_minus positionabsolutediv right8" href="#" id="minChatWidget"> <i class="fa fa-minus"></i></a> </div>
    <div class="paddingleft10" >
        <div class="aligncenter chat_profileareasearch padding8top" id="chat_profilesearchtext">

            
           <div class="chatplacediv">
               <ul>
                   <li  class="active" id="liInbox">
                       <a href="#" id="inboxUsers"><?php echo Yii::t('translation','Inbox'); ?> <span style="" class="not_count " id="inboxCount"></span></a>
                   </li>
                   <li id="liFindUser">
                       <a href="#" id="findUsers"><?php echo Yii::t('translation','Find_Users'); ?></a>
                   </li>
               </ul>
           </div>
<div class="searchdivbox">
    <div class="search marginzero">
    <input type="text" class="marginzero span12" placeholder="<?php echo Yii::t('translation','Search'); ?>..." size="40" name="q" id="chatFriendsSearch" value="<?php echo Yii::t('translation','Search'); ?>..." >
<input type="text" class="marginzero span12" placeholder="<?php echo Yii::t('translation','Search'); ?>..." size="40" name="q" id="findFriendsSearch" value="<?php echo Yii::t('translation','Search'); ?>..." style="display: none">
</div> 


    </div>
            
            
            

    </div>
     <div class="chat_profilearea">
         <div class="scroll-pane" id="usersListScrollPane" style="min-height: 540px">
        <div id="chatUsersSpinner" class="loader" style="position: absolute;padding-left: 96px;display: none"><div>
        <img src="/images/icons/loading_spinner.gif">
        </div>
        </div>
              <div id="chatUsersList">

             </div>     
         </div> 
        <div class="scroll-pane" id="findUsersScrollPane" style="min-height: 540px;display: none">
        <div id="findUsersSpinner" class="loader" style="position: absolute;padding-left: 96px;display: none"><div>
        <img src="/images/icons/loading_spinner.gif">
        </div>
        </div>
            <div id="findUsersList">

</div>
             </div>     
       </div> 
     </div>
      
        
    </div>   
     </div>    
    </div>
    </div>
 
  <div class="chatoverdiv" >
    <div class="m_chatarea" >
    <div class="container ">
    <div class="pull-right">
        <div id="minchatArea"></div>
           </div>

    </div>
</div>
    </div>

<!--<div class="chatoverdiv">
    <div class="m_chatarea" >
    <div class="container ">
    <div class="pull-right">
    <div class="minchatbox">
    <div class="minichat">
    <div >
    <div class="m_c_header">
   <div class="m_c_header_text">sreeni Jakka ...</div>
   <div class="m_c_header_icons"><i class="fa fa-plus"></i><i class="fa fa-times"></i></div>
    </div>
   <div class="m_c_chatdisplay">
   <div class="row-fluid paddingtop4">
    <div class="span12">

    <div class="media">
      <a href="#" class="pull-left  miniprofileicon">
        <img src="/upload/profile/user_noimage.png">                 </a>
      <div class="media-body">
       Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis Cras sit amet nibh libero, in gravida nulla.
       </div>
    </div>

    <div class="chat_time"><i class="fa fa-comment"></i> 3/26/2014 5:15:39 AM</div>
    </div>
    </div>
   </div>
   <div class="m_c_chatwrite">
   <div class="row-fluid">
   <div class="span12">
   <textarea class="span12"></textarea>
   </div></div></div>
   </div>
    </div>
    </div>
    <div class="minchatbox">
    <div class="minichat">
    <div class="m_c_header m_c_header_active">
    <div class="m_c_header_text">sreeni Jakka ...</div>
   <div class="m_c_header_icons"><i class="fa fa-plus"></i><i class="fa fa-times"></i></div>
    </div>


    </div>
    </div>
    </div>

    </div>
</div>
    </div>-->
<?php
$userId = Yii::app()->session['TinyUserCollectionObj']['UserId'];
$profilePicture = Yii::app()->session['TinyUserCollectionObj']['profile70x70'];
?>

 <script type="text/javascript">
      if(sessionStorage.globalSurveyFlag == 1){
        logoutSurveyPage();
    }
    
    
     notificationAjax = true;
     $("#admin_PostDetails").hide();
     $("#chatFriendsSearch,#findFriendsSearch").on('click',function(){
         if($.trim($(this).val()) == "Search..."){
            $(this).val("");
         }
     });
     $("#chatFriendsSearch,#findFriendsSearch").on('blur',function(){
         if($.trim($(this).val()) == "Search..." || $.trim($(this).val()) == ""){
            $(this).attr("style","font-color:#ccc").val("Search...");
         }
         
     });
     if($.browser.msie && $.browser.version<10){
        loadPlaceholders('mjmChatMessage','mjmChatMessage');
    }

     var gMinUserId = new Array();
var gMinUserName = new Array();
sessionStorage.minChatWidget = true;


if('<?php echo $this->sidelayout ?>' == "no")
{
    $("#rightpanel").hide();
}
        showChatWidget();
      
         $("#chatOffCount").html("");
        $("#chatOffCount").hide();
        //getOfflineMessages(loginUserId); 
        $('#contentDiv').hide();
      var queryString = {"from":"Chat"};
       trackActivities("/post/trackPageLoad",queryString);
   
    
function removeFromArray(array,search_term){      
        
    for (var i=array.length-1; i>=0; i--) {   
   if (array[i] == search_term) {  //alert('if');       
       array.splice(i, 1);
    return array;
   }

 
}  
  return array; 
    }
    function removeSearchFlag(){
       
        sessionStorage.removeItem("chatSearch");
    }
  
function showChatArea(recipientId,name){ 
    $("#mjmChatMessage").removeAttr('readonly');
   // alert($( window ).height()-290);
     var panHeight = $( window ).height()-290;
    $("#chatBoxScrollPane").css("min-height",panHeight);
    //$("#usersListScrollPane,#findUsersScrollPane").css("min-height",panHeight+85);
     $("[name='chatmessagearea']").attr("id","chatmessagearea_"+<?php echo $userId ?>+"_"+recipientId);
    $("[name=chatStatus]").attr("id","chatStatus_"+recipientId);
     $("#chatData,#chatStatus").html("");
     $("[name=chatStatus]").hide();
     $("#mjmChatMessage").val("");
      $("#mjmChatMessage").attr("data-receiverId",recipientId);
     sessionStorage.removeItem("roomName");
     $("#offlineIcon_"+recipientId).hide(); 
  
     if(onlineUserIds!=undefined){ 
          $.unique(onlineUserIds);
                   if(onlineUserIds.length>0){
               onlineUserIds = removeFromArray(onlineUserIds,recipientId);
          }
         
     }
   
    $("#recipientName").html(name);
      $("[name='li_showChatArea']").each(function(){
        
          $(this).attr("class","");
      });
     $("#li_showChatArea_"+recipientId).attr("class","active");
      $("#offlineIcon_"+recipientId).hide();
    
    var queryString = "userId=<?php echo $userId ?>&recipientId="+recipientId;
    ajaxRequest("/chat/getChatConversations", queryString, function(data){showChatAreaHandler(data,recipientId,name)}); 
    enterChatRoom('<?php echo $userId ?>',recipientId,'<?php echo $profilePicture ?>');
}
function L_replaceAll(id)
{$(id).html(function(i, currenthtml){
          return    currenthtml.replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace("?<=<[^>]*)&nbsp'", ' ').replace("&amp;nbsp;", ' ').replace(/&nbsp;/g, ' ');
          
            });
    
}
function showChatAreaHandler(data,recipientId,name){   
     scrollPleaseWaitClose("chatSpinLoader");
    if(offlineSenderId!="" && offlineSenderId!=null && offlineSenderId!="undefined"){ 
       removeFromArray(offlineSenderId,data.offlineUserId)
    }
     
    var data = data.data;
    if(data!=null){
          var item = {
                        "data": data.conversations
                    };
      $("#chatData").html($("#chatMessageTmpl").render(item));
       L_replaceAll('#chatData');
    }
      $("[name='chatmessagearea']").show();
      $('#chatBoxScrollPane').jScrollPane({ autoReinitialise: true,stickToBottom:true }); 
      var api = $('#chatBoxScrollPane').data('jsp');
     api.scrollToBottom(false);
   
      popFromMinChatArray(recipientId);
      pushToMinChatArray();
      pushToMaxChatArray(recipientId,name);
}
$("#minChatWidget").bind("click",function(){
  
    if(sessionStorage.globalSurveyFlag == 1){
        loginSurveyPage();
    }
    
          isDuringAjax=false;
          $("#chatDiv").hide();
          $("#minChatWidgetDiv").show();
          if($("#minTourGuideDiv").css("display")=="block"){
         
    
    }
          if($.trim($("#admin_PostDetails").text()) != ""){
              $("#admin_PostDetails").show();
          }else if($.trim($("#notificationHistory").text()) != ""){
              $("#notificationHomediv").show();
              notificationAjax = false;
          }else{
            $("#contentDiv").show();
            $("#rightpanel").show();
          }
          if(globalspace.featuredItems!=undefined){
                            if(globalspace.featuredItems==1){
                                loadGalleria();
                            }
                        }
        $("#minChatWidgetDiv").unbind().bind("click",function(){ 
     $(".closedchat").removeClass("m_c_header_active");
        stoploadingusers = false;
        chatStartLimit = 0;
         if($("#minTourGuideDiv").css("display")=="block"){
     
    }else
         minimizeJoyride();
     divrenderget('chatDiv','/chat/index');
//     $("#chatDiv").show();
//       $("#contentDiv,#minChatWidgetDiv,#notificationHomediv").hide();
//       $('#chatBoxScrollPane,#usersListScrollPane').jScrollPane();
});
          sessionStorage.minChatWidget = true;
});
$('#inviteInput').keypress(function(e) { 
                if(e.which == 13) { 
                        //$('#mjmChatSend').focus().click();
                       inviteUser('1','Sreeni Jakka');
                       e.preventDefault();
                }
 });

function showChatWidget(){
   
    scrollPleaseWait("chatSpinLoader","chatDiv");
    chatStartLimit=0;
       getUserFriendsList('<?php echo $userId ?>',chatStartLimit);
       $("#chatDiv").show();
       $("#contentDiv,#minChatWidgetDiv,#notificationHomediv").hide();
       $('#usersListScrollPane').jScrollPane();
   }
function inviteUser(inviteUserId, inviteUserDisplayName) {
            }
function displayMyChat(message) {
                buidMessage('<?php echo $profilePicture ?>', message);
            }
 function displayMyMinChat(message,chatBoxId) {
        buidMinMessage('<?php echo $profilePicture ?>', message,chatBoxId);
 }
 function  popFromMinChatArray(userId){
     if(minChatArray.length>0){
            // if(minChatArray.indexOf(userId)!=-1){
             if(jQuery.inArray(userId,minChatArray)!=-1){
              minChatArray = removeFromArray(minChatArray,userId);
              removeMinChatDiv(userId);
         } 
      
     }
      
}

function pushToMinChatArray(){
   //var divPos="prepend";
   if(maxChatArray.length>0){
        var minChatuserId = maxChatArray[0];
    var minChatuserName = maxChatArray[1];
  
  if(!$("#chatmessagearea_"+<?php echo $userId ?>+"_"+minChatuserId).is(':visible')){
    if(minChatArray.length>=4){
         
       if(sessionStorage.fourMinWindow=="undefined" || sessionStorage.fourMinWindow==null || sessionStorage.fourMinWindow=="false"){
             
                var poppedUserId = minChatArray.shift();
        // alert('before--'+ sessionStorage.gMinUserId);
          removeMinChatDiv(poppedUserId);
          
           var uu =  sessionStorage.gMinUserId;
         var un =  sessionStorage.gMinUserName;
          if(uu!="undefined" && uu!=null){ 
              gMinUserId = uu.split(",");
              gMinUserName = un.split(",");
         }
          
          // delete gMinUserName[gMinUserId.indexOf(poppedUserId)];
          // delete gMinUserId[gMinUserId.indexOf(poppedUserId)];
           
           delete gMinUserName[jQuery.inArray(poppedUserId,gMinUserId)];
           delete gMinUserId[jQuery.inArray(poppedUserId,gMinUserId)];
         
        sessionStorage.gMinUserId = cleanArray(gMinUserId);
        sessionStorage.gMinUserName =cleanArray(gMinUserName);
         //  alert('after--'+ sessionStorage.gMinUserId);
          //divPos = "append";
       }
          sessionStorage.removeItem("fourMinWindow");
    }
     
    minChatArray.push(minChatuserId);
     maxChatArray=[];//clear max chat array
   //alert(sessionStorage.chatSearch);
   
     if(sessionStorage.chatSearch == null || sessionStorage.chatSearch == "undefined" ){
         var uu =  sessionStorage.gMinUserId;
         var un =  sessionStorage.gMinUserName;
          if(uu!="undefined" && uu!=null){ 
              gMinUserId = uu.split(",");
              gMinUserName = un.split(",");
         }
         gMinUserId.push(minChatuserId);
         gMinUserName.push(minChatuserName);
        
        sessionStorage.gMinUserId = cleanArray(gMinUserId);
        sessionStorage.gMinUserName =  cleanArray(gMinUserName);
         createMinChatDiv(minChatuserId,minChatuserName,"main");
     }
      

    }
   
   }
   
   }
   function pushToMaxChatArray(recipientId,name){
      maxChatArray.push(recipientId);
      maxChatArray.push(name);
   }
   
   function createMinChatDiv(minChatuserId,minChatuserName,flag){
     
   var queryString = "userId=<?php echo $userId ?>&recipientId="+minChatuserId;
    ajaxRequest("/chat/getChatConversations", queryString, function(data){createMinChatDivHandler(data,minChatuserId,minChatuserName,flag)}); 
   }
   function createMinChatDivHandler(jsonData,minChatuserId,minChatuserName,flag){
       var conversations;
      var recentChatTime;
         if(jsonData.data!=null){
             conversations =  jsonData.data.conversations;
             recentChatTime =  jsonData.recentChatTime;
         }else{
             conversations = new Array();
         }
        // alert(recentChatTime);
        //  alert(flag);
         
       if(flag=="main" || (recentChatTime !="undefined" && recentChatTime !=null && recentChatTime<60)){
        
            var minChatUserMinName = minChatuserName;
         if(minChatuserName.length>15){
             minChatUserMinName = minChatuserName.substring(0,13)+"...";
         }
        data= {"userId":minChatuserId,"userName":minChatuserName,"minUserName": minChatUserMinName,"jsonData":conversations};
        if(data!=null){
          var item = {
                        "data": data,
                      
                    };
                   // if(divPos == "prepend"){
          $("#minchatArea").prepend($("#minchatFullTmpl").render(item));
            L_replaceAll("#minchatArea");
                   // }else{
                    //    $("#minchatArea").append($("#minchatFullTmpl").render(item));
                   // }
     checkStatusOfUser(minChatuserId);
$('#min_minChatHeader_'+minChatuserId).bind('click', function(){ 
    var dataId = this.getAttribute("data-id");
   
    var userId = dataId.split("_")[1];
    if(!$("#minBody_"+userId).is(':visible')){ 
     $("#minBody_"+userId+",#minWrite_"+userId).show();
     $('#minchatScrollPane_'+userId).jScrollPane({ autoReinitialise: true,stickToBottom:true });
     var api = $('#minchatScrollPane_'+userId).data('jsp');
     api.scrollToBottom(false);
         
      var recieverId = userId;
      if (parseInt(loginUserId) < parseInt(recieverId)) { 
            var roomName = "Room-" + loginUserId + "-" + recieverId;
        } else { 
            var roomName = "Room-" + recieverId + "-" + loginUserId;
        }
        sessionStorage.roomName = roomName;
    }else{
       $("#minBody_"+userId+",#minWrite_"+userId).hide();  
    }
    
    return false;
});
             
       //$('#minchatScrollPane').jScrollPane({ autoReinitialise: true,stickToBottom:true }); 
       
    }
    }else{
        sessionStorage.removeItem("fourMinWindow");
        
         delete minChatArray[jQuery.inArray(minChatuserId,minChatArray)];
         minChatArray = cleanArray(minChatArray);
         
        removeMinChatDiv(minChatuserId);
        
    }
   }
   function checkStatusOfUserResponse(data){
      // alert(data[1]);
       if(data[1]==-1){
           $("#minichat_"+data[0]).addClass("minichat_offline");
       }else{
            //$("#m_c_header_"+data[0]).attr("class","m_c_header");
       }
           
   }
function  removeMinChatDiv(userId){
  
   $("#minchatUser_"+userId).remove();
    var uu =sessionStorage.gMinUserId;
    var un =sessionStorage.gMinUserName;
   
    if(uu!="undefined" && uu!==null){
        var uuArray =  uu.split(",");
        
         var unArray =  un.split(",");
       // alert("before---"+uuArray+"-----"+unArray);
        
//        delete unArray[uuArray.indexOf(userId)];
//          delete uuArray[uuArray.indexOf(userId)];
          
           delete unArray[jQuery.inArray(userId,uuArray)];
            delete uuArray[jQuery.inArray(userId,uuArray)];
         //alert("after---"+uuArray+"-----"+unArray);
         sessionStorage.gMinUserName = cleanArray(unArray);
         sessionStorage.gMinUserId =cleanArray(uuArray);
    }
      
}
$('i[name="minChatClose"]').live('click', function(){
    var dataId = this.getAttribute("data-id");
    var userId = dataId.split("_")[1];
    popFromMinChatArray(userId);
    return false;
});
$('i[name="minChatEnlarge"]').live('click', function(){ 
    var dataId = this.getAttribute("data-id");
    var userId = dataId.split("_")[1];
    var userName = dataId.split("_")[2];
     $("#minchatUser_"+userId).remove();
     maxChatArray = []
     showChatArea(userId,userName);
    return false;
});
$("#usersListScrollPane").unbind('jsp-scroll-y');
$("#usersListScrollPane").bind('jsp-scroll-y', function(event, scrollPositionY, isAtTop, isAtBottom){           
    if (isAtBottom && stoploadingusers === false) {   
        stoploadingusers = true;
        loadMoreChatUsers(chatStartLimit,'<?php echo $userId ?>');
    }
});
$("#findUsersScrollPane").unbind('jsp-scroll-y');
$("#findUsersScrollPane").bind('jsp-scroll-y', function(event, scrollPositionY, isAtTop, isAtBottom){           
    if (isAtBottom && stoploadingusers === false) {   
        stoploadingusers = true;
        loadMoreSearchUsers(searchUsersStartLimit,'<?php echo $userId ?>');
    }
});
$("#inboxUsers").bind("click",function(){
//$("#chatFriendsSearch").val("");
$("#liFindUser").attr("class","");
$("#liInbox").attr("class","active");
$("#findUsersScrollPane,#findFriendsSearch").hide();
$("#usersListScrollPane,#chatFriendsSearch").show();

})
$("#findUsers").bind("click",function(){
//$("#findFriendsSearch").val("");
$("#liInbox").attr("class","");
$("#liFindUser").attr("class","active");
$("#usersListScrollPane,#chatFriendsSearch").hide();
$("#findUsersScrollPane,#findFriendsSearch").show();
trackEngagementAction("ChatFindUsers");
})
 gPage = "Chat";
trackEngagementAction("Loaded","",0); 
</script>
    
       


