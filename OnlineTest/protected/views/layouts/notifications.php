<script type="text/javascript">
    pF3 = pF4 = pF5 = 1;
    var socketNotifications = io.connect('<?php echo Yii::app()->params['NodeURL']; ?>');
    var noofstories = 0;
// socket connection is established...
    socketNotifications.on("connect", function() {
        
        socketNotifications.on('getUnreadNotificationsRes', function(content) { //alert("getUnreadNotificationsRes---"+content);
            pF4 = 2;
            $("#notification_settings").text("Settings");            
            $("#renderNotification,#notificationsHeader,#scrollDiv").show();
            $("#settings").hide();  
            scrollPleaseWaitClose("notificationSpinLoader_"+g_notificationId);
            if (content != 0) {
                var data = content.split("_((***&&***))_");
                if((data[1] <= noofstories || data[1]> noofstories)  && data[1] != 0 && data[1] != ""){
                    noofstories = data[1];
                    var data_content = data[0];
                    if(noofstories != undefined && noofstories != 0 && noofstories != ""){
                        $(".markallasread_notification").show();
                        $("#notificationCount").text(noofstories).show();
                        $("#totalNotifications").text(noofstories + " Notifications");
                    }
                    if(data[0] != ""){
                        setTimeout(function(){
                            $("#renderNotification").html(data_content);
                            $(".scroll").jScrollPane({autoReinitialise: true, autoReinitialiseDelay: 200, stickToBottom: true,mouseWheelSpeed:200});
                            if(!detectDevices()){                   
                                $("[rel=tooltip]").tooltip();
                            }
                        },1000);
                    }
                    $("#notification_settings").text("Settings");
                    $("#settings").hide();
                }
                
            } else if(content == 0 && $.trim(content) != ""){
                $("#nomorenotifications").hide();
                $("#notificationCount").hide();
                $("#totalNotifications").text("");
                $(".markallasread_notification").hide(); //alert("===no notification here==="+content);
//                $("#scrollDiv").css("height","40px");
//$(".scroll").jScrollPane({autoReinitialise: false, autoReinitialiseDelay: 200, stickToBottom: true,mouseWheelSpeed:200});
                $("#renderNotification").html('<div class="padding10" ><div  class="notificationdata " ><div class="media-body" ><div class="m_title"></div><div class=" m_day fontnormal"><?php echo Yii::t('translation','You_have_no_notifications'); ?></div></div></div></div>');
                $("#settings").hide();
            }

        });
        
        socketNotifications.on("getAllNotificationByUserIdResponse", function(htmlResponse) { //alert(htmlResponse); 
            $("#contentDiv").hide();
            $("#rightpanel").hide();
            scrollPleaseWaitClose("history_spinner");
            if(!detectDevices())
               $("[rel=tooltip]").tooltip();
            $("#notificationHomediv,#notificationHistory").show();
            if (htmlResponse == 0 && $.trim(htmlResponse) != "") {
                notificationAjax = true;
                $("#notificationHistory").addClass("NPF").html("<?php echo Yii::t('translation','You_have_no_notifications'); ?>").show();
                $("#markallasreaddiv").hide();
                
            }
            if (startLimit == 0 && htmlResponse != 0 && htmlResponse != -1 && htmlResponse != "") {
             notificationAjax=false;    
            $("#notificationHistory").removeClass();
                $("#notificationHistory").html(htmlResponse).show();
                $("#notificationHistory_loading").show();
                startLimit = Number(startLimit) + 8;
            }else if (startLimit != 0 && htmlResponse != 0 && htmlResponse != -1 && htmlResponse != "") {
            $("#notificationHistory").append(htmlResponse).show();
             notificationAjax=false;
                 $("#notificationHistory").append(getInfiniteScrollLoader('notificationHistory'));
                 if(notificationAjax == false){
                    $("#notificationHistory_loading").show();
                    $("#notificationHistory_loading").fadeOut(2000);
                }else{
                    $("#notificationHistory_loading").hide();                    
                }
                startLimit = Number(startLimit) + 8;
            } else if(startLimit != 0 && htmlResponse == -1){
                notificationAjax = true;
                $("#notificationHistory").append(getInfiniteScrollLoader('notificationHistory'));
                $("#notificationHistory_loading").html("No more notifications").show();
                $("#notificationHistory_loading").fadeOut(2000);
            }
            
        });        
        socketNotifications.on('getPictocvImagesRes', function(data) {
            console.log("===getPictocvImagesRes===");
           if($.trim(data)!=""){
               if($("#userAchievementProgress").length<=0){
                    $("#streamMainDiv").prepend(data);
               }else{
                   $("#userAchievementProgress").replaceWith(data);
               }
           }
        });
        socketNotifications.on('getPictocvObjectByOppertunityRes', function(data) {
           if($.trim(data)!=""){
                if(gPage=="News"){
                    if($("#userAchievementProgress").length<=0){
                         $("#ProfileInteractionDivContent").prepend(data);
                    }else{
                        $("#userAchievementProgress").replaceWith(data);
                    }
                    console.log("==============News==============="+gPage);
                    applyLayoutContent();
                }else if(gPage=="Career"){
                    if($("#userAchievementProgress").length<=0){
                         $("#jobsListIndex").prepend(data);
                    }else{
                        $("#userAchievementProgress").replaceWith(data);
                    }
                    console.log("==============Career==============="+gPage);
                    applyLayout();
                }else if(gPage=="Profile" || gPage=="ProfileStream"){
                    if($("#userAchievementProgress").length<=0){
                         $("#ProfileInteractionDiv").prepend(data);
                    }else{
                        $("#userAchievementProgress").replaceWith(data);
                    }
                    console.log("==============Profile==============="+gPage);
                    applyLayout();
                }
            }

        });
    });
    
     socketNotifications.on('getBadgesUnlockedRes', function(content) { 
         pF3 = 2;
         try{
                if (content != 0) {
                    var data = content.split("_((***&&***))_");


                        var data_content = data[0];

                        if(data[0] != ""){

                               getBadginDetailsHandler(data_content);


                        }


                }
            }catch(err){
                ;
            }

        });
      
                        socketNotifications.on('getTopicsRes', function(content) {
                            try{
                                pF5 = 2;
                            if (content != 0) {
                                
                                var data1 = eval(content);
                                for (var i = 0; i < data1.length; i++) {
                                   
                                    var obj=data1[i].Followers;
                                    
                                    $("#leftmenuPostsCount_" + data1[i].CategoryId).html(JSON.stringify(data1[i].NumberOfPosts));
                                    $("#leftmenuFollowersCount_" + data1[i].CategoryId).html(obj.length);
                                    for(var j=0; j<obj.length;j++)
                                    {  
                                        if(loginUserId==obj[j])
                                        {
                                           
                                            
                                           $('#curbsideCategoryIdFollowUnFollowImg1_' +  data1[i].CategoryId).attr("class", "follow").attr("data-action", "unfollow");
                                            $('#curbsideCategoryIdFollowUnFollowImg1_' +  data1[i].CategoryId).attr("data-original-title", "<?php echo Yii::t('translation','UnFollow'); ?>") 
  
                                        }
                                        else
                                        {
                                            $('#curbsideCategoryIdFollowUnFollowImg1_' + data1[i].CategoryId).attr("class", "unfollow").attr("data-action", "follow");
                                            $('.curbsideCategoryIdFollowUnFollowImg1_' + data1[i].CategoryId).attr("data-original-title", "<?php echo Yii::t('translation','Follow'); ?>")
                                        }
                                    }
                                        if(obj.length==0)
                                        {
                                            $('#curbsideCategoryIdFollowUnFollowImg1_' + data1[i].CategoryId).attr("class", "unfollow").attr("data-action", "follow");
                                            $('#curbsideCategoryIdFollowUnFollowImg1_' + data1[i].CategoryId).attr("data-original-title", "<?php echo Yii::t('translation','Follow'); ?>")
                                        }
                                    }   
                            }
                          }catch(err){
                                ;
                            }  

                        });
                
    // handling if socket is not connected to the server...
    socketNotifications.on("error", function() {
        // Do stuff when we connect to the server
        socketNotifications.emit('clearInterval',sessionStorage.old_key);
    });
    
   $(function(){     
     $("#history_close").live("click",function(){ 
         notificationAjax = true;
         isDuringAjax = false;
            $("#notificationHistory").html("");
            $("#nomorenotifications,#notificationHomediv,#notificationHistory,#groupstreamMainDiv").hide();
            
            if($.trim($("#admin_PostDetails").text()) != ""){
               $("#admin_PostDetails").show();
            }else if($("#messagetextareadiv").length > 0){                
                if($("#minChatWidgetDiv").is(":visible") == false){
                    $("#chatDiv").show();
                }else{
                    $("#contentDiv").show(); 
                }
            }else{
                $("#admin_PostDetails,#chatDiv").hide();
                $("#contentDiv").show(); 
            }
            $("#notificationText").html("").hide();
            if(($("#poststreamwidgetdiv").length>0) || $("#curbsidePostCreationdiv").length>0){
                $("#rightpanel").show();
            }
  });
   });
   if(typeof socketNotifications !== "undefined")
        socketNotifications.emit('clearInterval',sessionStorage.old_key);
   jsonObject = getJsonObjectForNode();    
   socketNotifications.emit('getUnreadNotifications', loginUserId,jsonObject,"sSetInterval"); // by setting interval..
   socketNotifications.emit('getUnreadNotifications', loginUserId,jsonObject,"notSetInterval"); // by immediate action..
   <?php if(Yii::app()->params['IsDSN'] == 'ON'){ ?>
    setTimeout(function(){ // this was delayed by 10 secs...
           if($("#topicIds").val()!=undefined && $("#topicIds").val()!="undefined")
            {
                var ids=$("#topicIds").val();
                socketNotifications.emit('getTopicsRequest',ids,loginUserId,jsonObject);
            }
       }, 10000);
   <?php } ?>
</script>