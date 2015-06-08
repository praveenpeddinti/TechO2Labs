<script>

    var enterChatRoom, inviteChatRoom, getUserFriendsList, getOfflineMessages, checkStatusOfUser;
    var offlineSenderId = null, offlineUsersId = new Array();
    var onlineUserIds = new Array();
    var myObj = {};
    var minChatObj = {};
    var maxChatArray = new Array(); //storing current active user window with User Id and name
    var minChatArray = new Array();
//$(function() {
    // get user
    var mjmChatConnect = false;
    var stoploadingusers = false;
    var chatStartLimit = 0;
    var searchUsersStartLimit = 0;
    var chatPageLength = 20;

    // connect to socket
    var mjmChatHostPort = '<?php echo Yii::app()->params['NodeURL']; ?>';
    if (typeof io !== "undefined") { 
        var socket = io.connect(mjmChatHostPort, {query: "timezoneName=" + timezoneName+"&userId="+loginUserId});
//        socket.on('connect', function()
//        {
        socket.emit('getUserId', loginUserId);
        socket.on('mjmChatMessage', function(senderId, profilePicture, data,displayName,room)
        {
            /* view message */
        // alert(loginUserId+"--"+senderId+"--"+room);
           
            if(loginUserId!=senderId){
            if ($("#chatmessagearea_" + loginUserId + "_" + senderId).is(":visible")) {
                buidMessage(profilePicture, data);
            } else if ($("#minchatUser_" + senderId).is(":visible")) {
                if (!$("#minBody_" + senderId).is(":visible")) {
                    minChatObj[senderId] = setInterval(function() {
                        //   alert('1');
                        // $("#m_c_header_" + senderId).removeClass('m_c_header_active');
                        // $("#offlineIcon_" + senderId).toggleClass('chatStatusGreen');
                        $("#m_c_header_" + senderId).toggleClass("m_c_header_active");
                        // $("#m_c_header_"+senderId).removeClass("m_c_header_active");

                    }, 500);

                    $("#minchatUser_" + senderId + ",#minichat_" + senderId + ",#m_c_header_" + senderId + ",#min_minChatHeader_" + senderId).bind("click", function() {
                        clearInterval(minChatObj[senderId]);
                        $("#m_c_header_" + senderId).removeClass("m_c_header_active");
                    })
                }
                buidMinMessage(profilePicture, data, senderId);
            }
            else if (!$("[name='chatmessagearea']").is(":visible")) {

                if ($("#chatOffCount").html() == "") {
                    var count = 1;
                } else {
                    var count = parseInt($("#chatOffCount").html()) + 1;
                }
                onlineUserIds.push(senderId);

                $("#chatOffCount").html(count);
                $("#chatOffCount").show();

                clearInterval(chatWidgetWatchId);
                var chatWidgetWatchId = setInterval(function() {
                    $(".closedchat").toggleClass("m_c_header_active");
                }, 500);
                $(".closedchat").bind("click", function() {
                    $(".closedchat").removeClass("m_c_header_active");
                    clearInterval(chatWidgetWatchId);
                    $("#chatOffCount").html("");
                    $("#chatOffCount").hide();
                });

            } else if($("#ul_"+senderId).length>0) {
                $("#offlineIcon_" + senderId).show();
                clearInterval(myObj[senderId]);
                myObj[senderId] = setInterval(function() {
                    $("#offlineIcon_" + senderId).removeClass('chatStatusGrey');
                    $("#offlineIcon_" + senderId).toggleClass('chatStatusGreen');
                }, 500);
            }else{
                var data = {"userId":senderId,"profilePicture":profilePicture,"displayName":displayName};
                var item={
                    'data':data
                }
                $("#chatUsersList").prepend($("#chatUserListTmpl").render(item));
                if($('#chatUsersList').children().length == 1){
                  
                    $("#showChatArea_"+senderId).trigger("click");
                }else{
                    $("#offlineIcon_" + senderId).show();
                clearInterval(myObj[senderId]);
                myObj[senderId] = setInterval(function() {
                    $("#offlineIcon_" + senderId).removeClass('chatStatusGrey');
                    $("#offlineIcon_" + senderId).toggleClass('chatStatusGreen');
                }, 500); 
                }
            }
        }else{
              var roomArray = room.split("-");
            
             if (roomArray[1] == loginUserId) {
                var senderId = roomArray[2];
            } else {
                var senderId = roomArray[1];
            }
             if ($("#chatmessagearea_" + loginUserId + "_" + senderId).is(":visible")) {
                 buidMessage(profilePicture, data);
             }
              
        }
            //mjmChatScrollDown();
        });
        socket.on('typingStatus', function(displayName, messageReceiverId, flag)
        {
            // alert('tyonstatus');
            if (flag == "typing") {

                if ($("#minchatUser_" + messageReceiverId).is(":visible")) {
                    $("#minChatStatus_" + messageReceiverId).html(displayName + " is typing...");
                    $("#minChatStatus_" + messageReceiverId).show();
                } else if ($("#chatStatus_" + messageReceiverId).length > 0) {
                    $("#chatStatus_" + messageReceiverId).html(displayName + " is typing...");
                    $("#chatStatus_" + messageReceiverId).show();
                }

            } else if (flag == "typed") {

                if ($("#minchatUser_" + messageReceiverId).is(":visible")) {
                    $("#minChatStatus_" + messageReceiverId).html(displayName + " has entered text");

                } else if ($("#chatStatus_" + messageReceiverId).length > 0) {
                    $("#chatStatus_" + messageReceiverId).html(displayName + " has entered text");
                    $("#chatStatus_" + messageReceiverId).show();
                }

            } else {
                if ($("#minchatUser_" + messageReceiverId).is(":visible")) {
                    $("#minChatStatus_" + messageReceiverId).html("");
                    $("#minChatStatus_" + messageReceiverId).hide();

                } else if ($("#chatStatus_" + messageReceiverId).length > 0) {
                    $("#chatStatus_" + messageReceiverId).html("");
                    $("#chatStatus_" + messageReceiverId).hide();
                }
            }

        });


//        });

        enterChatRoom = function(userId, recieverId, profilePicture)
        {

            if (parseInt(userId) < parseInt(recieverId)) {
                var roomName = "Room-" + userId + "-" + recieverId;
            } else {
                var roomName = "Room-" + recieverId + "-" + userId;
            }
            sessionStorage.roomName = roomName;
            socket.emit('mjmChatAddUser', userId, recieverId, roomName, profilePicture, function(status, offlineUserId) {
//            if (status == "offline") {
//               // offlineUsersId = offlineUserId;
//                 offlineUsersId.push(offlineUserId);
//            } else {
//                //offlineUsersId = "";
//            }
            });
            socket.on('mjmChatAddUserResponse', function(status, offlineUserId) {
                //  alert('mjmChatAddUserResponse--'+status+"---"+offlineUserId);
                if (status == "offline") {
                    // offlineUsersId = offlineUserId;
                    offlineUsersId.push(offlineUserId);
                } else {
                    //offlineUsersId = "";
                }
            });
            $('#mjmChatMessages').empty();
        }
        inviteChatRoom = function(userId, inviteUserId)
        {

            socket.emit('mjmChatAddUser', userId, inviteUserId, sessionStorage.roomName);


            $('#mjmChatMessages').empty();
            mjmChatConnect = true;
        }
        getUserFriendsList = function(userId,startLimit) {//alert('1');

            socket.emit('getUserFriends', userId, "",startLimit,chatPageLength,function(data) {

            });
        }
        socket.on('getOfflineMessagesResponse', function(data) {

            if ($.trim(data) != "") {
                data = eval("(" + data + ")");

                if (data.status == "success") {
                    data = data.data;
                    offlineSenderId = data.senderId;
                    if (offlineSenderId.length > 0) {
                        $("#chatOffCount").html(offlineSenderId.length);
                        $("#chatOffCount").show();
                    }

                } else {

                }
            }

        });
        socket.on('getUserFriendsResponse', function(data) {
            renderChatUserFriends(data);
        });
         socket.on('searchUsersResponse', function(data) {
            renderSearchUsers(data);
        });
        socket.on('imOnLine', function(userId) {
 //alert("imOnLine---"+userId);
            if ($("#chatProfileImg_" + userId).length > 0) {
                $("#chatProfileImg_" + userId).removeClass("chatprofilegrey");
                $("#chatProfileImg_" + userId).addClass("chatprofilegreen");
            }
            if ($("#m_c_header_" + userId).is(':visible')) {
                $("#minichat_" + userId).removeClass("minichat_offline");
                // $("#m_c_header_"+userId).addClass("m_c_header");
            }
           
             removeFromArray(offlineUsersId,userId);
        });
        socket.on('imOffLine', function(userId) {
//alert("imOffLine---"+userId);
            if ($("#chatProfileImg_" + userId).length > 0) {
                $("#chatProfileImg_" + userId).removeClass("chatprofilegreen");
                $("#chatProfileImg_" + userId).addClass("chatprofilegrey");
            }
            if ($("#m_c_header_" + userId).is(':visible')) {
                // $("#m_c_header_"+userId).removeClass("m_c_header");
                $("#minichat_" + userId).addClass("minichat_offline");
            }
             offlineUsersId.push(userId);
        });
        // sent message to socket
        var sendMessage = (function(chatBoxId) {
            var chatMessage = $.trim($('#mjmChatMessage').val());
            if (chatMessage != '')
            { 
                displayMyChat(chatMessage);
               
               
               
                saveChatConversation(sessionStorage.roomName, loginUserId, chatMessage);
                // if (offlineUsersId.indexOf(chatBoxId)!=-1) {
               // alert(chatBoxId+"---"+offlineUsersId);
                if (jQuery.inArray(chatBoxId, offlineUsersId) != -1) {
                    saveOfflineChatStatus(sessionStorage.roomName, loginUserId, chatBoxId);
                }else{
                   //alert(sessionStorage.roomName+"--"+loginUserId+"--"+chatMessage);
            socket.emit('mjmChatMessage', chatMessage, sessionStorage.roomName,displayName); 
                }
                $('#mjmChatMessage').val('');

            }
            $('#mjmChatMessage').focus();
        });
        var sendMinMessage = (function(message, chatBoxId) {
            var chatMessage = $.trim(message);

            if (chatMessage != '')
            {
                displayMyMinChat(chatMessage, chatBoxId);
               
                saveChatConversation(sessionStorage.roomName, loginUserId, chatMessage);
                // alert(chatBoxId+"--"+offlineUsersId);
                //if (offlineUsersId.indexOf(chatBoxId)!=-1) {
                if (jQuery.inArray(chatBoxId, offlineUsersId) != -1) {
                    saveOfflineChatStatus(sessionStorage.roomName, loginUserId, chatBoxId);

                }else{
                   socket.emit('mjmChatMessage', chatMessage, sessionStorage.roomName);  
                }
                $('#mjmMinChatMessage_' + chatBoxId).val("");

            }
            $('#mjmMinChatMessage_' + chatBoxId).focus();
        });
        var maxWatchId,minWatchId;

        $('#mjmChatMessage').live('click', function(e) {
            var recieverId = this.getAttribute("data-receiverId");
            if (parseInt(loginUserId) < parseInt(recieverId)) {
                var roomName = "Room-" + loginUserId + "-" + recieverId;
            } else {
                var roomName = "Room-" + recieverId + "-" + loginUserId;
            }
            sessionStorage.roomName = roomName;

        });


        $('#mjmChatMessage').live('keypress', function(e) {
            if (maxWatchId != undefined && maxWatchId != null) {
                clearTimeout(maxWatchId);
            }

            var messageReceiverId = loginUserId;
            if (e.which == 13) {
                socket.emit('typingStatus', sessionStorage.roomName, displayName, messageReceiverId, "enter");
                sendMessage(this.getAttribute("data-receiverid"));
                e.preventDefault();
            } else {
                socket.emit('typingStatus', sessionStorage.roomName, displayName, messageReceiverId, "typing");
                maxWatchId = setTimeout(function() {
                    socket.emit('typingStatus', sessionStorage.roomName, displayName, messageReceiverId, "typed");
                }, 5000)
            }

        });
        $('textarea[name=mjmMinChatMessage]').live('click', function(e) {
            var recieverId = this.getAttribute("data-id");
            if (parseInt(loginUserId) < parseInt(recieverId)) {
                var roomName = "Room-" + loginUserId + "-" + recieverId;
            } else {
                var roomName = "Room-" + recieverId + "-" + loginUserId;
            }
            sessionStorage.roomName = roomName;

        });
        $('textarea[name=mjmMinChatMessage]').live('keypress', function(e) {

            if (minWatchId != undefined && minWatchId != null) {
                clearTimeout(minWatchId);
            }
            var messageReceiverId = loginUserId;

            if (e.which == 13) {
                socket.emit('typingStatus', sessionStorage.roomName, displayName, messageReceiverId, "enter");
            sendMinMessage(this.value, this.getAttribute("data-id"));
                e.preventDefault();
            } else {

                socket.emit('typingStatus', sessionStorage.roomName, displayName, messageReceiverId, "typing");
                minWatchId = setTimeout(function() {
                    socket.emit('typingStatus', sessionStorage.roomName, displayName, messageReceiverId, "typed");
                }, 5000)
            }

        });


        var searchWatchId;
        $('#chatFriendsSearch').live("keyup", function(e) {
              $("#chatUsersList").empty();
                     if($.trim($('#findFriendsSearch').val())!=""){
                          $("#chatUsersSpinner").show();
                      }
                     
            if (searchWatchId != undefined && searchWatchId != null) {
                clearTimeout(searchWatchId);
            }
            searchWatchId = setTimeout(function() {
        chatStartLimit=0;
                socket.emit('getUserFriends', loginUserId, $.trim($('#chatFriendsSearch').val()),0,chatPageLength,function(data) {
                    // renderChatUserFriends(data);
                });
            }, 1000)

        });
        
                $('#findFriendsSearch').live("keyup", function(e) {
                     $("#findUsersList").empty();
                      if($.trim($('#findFriendsSearch').val())!=""){
                           $("#findUsersSpinner").show();
                      }
                    
            if (searchWatchId != undefined && searchWatchId != null) {
                clearTimeout(searchWatchId);
            }
            searchWatchId = setTimeout(function() {
             searchUsersStartLimit=0;
              if($.trim($('#findFriendsSearch').val())!=""){
                 
                   socket.emit('searchUsers', loginUserId, $.trim($('#findFriendsSearch').val()),0,chatPageLength,function(data) {
                    // renderChatUserFriends(data);
                }); 
              }else{
                     $("#findUsersSpinner").hide();
                  $("#findUsersList").empty();
                    $('#findUsersScrollPane').jScrollPane();
              }
              
            }, 1000)

        });

        checkStatusOfUser = function(minChatuserId) {

            socket.emit('checkStatusOfUser', minChatuserId);
        }
        socket.on('checkStatusOfUserResponse', function(data) {
            checkStatusOfUserResponse(data);
        });
        $("#logoutId").click(function() {
            sessionStorage.clear();
            socket.emit('logout', loginUserId);
        });
    }
    function  renderChatUserFriends(data) {
          $("#chatUsersSpinner").hide();
    var panHeight = $( window ).height()-205;
    $("#usersListScrollPane").css("min-height",panHeight);
        if ($.trim(data) != "") {
            data = eval("(" + data + ")");
           var searchText = $.trim(data.searchText);

 if(searchText == "" && chatStartLimit == 0){
     $("#inboxCount").html(data.totalChatUsers);
 }
            data = data.data;
            if (data.length > 0) {
                var item = {
                    "data": data
                };
                stoploadingusers = false;
               if(searchText == "" && chatStartLimit != 0){
                    $("#chatUsersList").append($("#chatUsersListTmpl").render(item));
               }else{
                   $("#chatUsersList").html($("#chatUsersListTmpl").render(item)); 
               }
                chatStartLimit = Number(chatStartLimit) + Number(chatPageLength);
               // alert(chatStartLimit)
                
               
                $('#usersListScrollPane').jScrollPane();
              //  alert(offlineSenderId+"---"+onlineUserIds);
                if (offlineSenderId != null && offlineSenderId != "" && offlineSenderId != undefined) {
                    offlineSenderId.forEach(function(entry) {
                        $("#offlineIcon_" + entry).show();
                        $("#offlineIcon_" + entry).addClass("chatStatusGrey");
                    });

                }
                if (onlineUserIds != null && onlineUserIds != "" && onlineUserIds != undefined) {
                    $.unique(onlineUserIds);
                    onlineUserIds.forEach(function(entry) {

                        $("#offlineIcon_" + entry).show();
                        myObj[entry] = setInterval(function() {

                            $("#offlineIcon_" + entry).toggleClass('chatStatusGreen');
                        }, 500);
                    });
                }
                if ($.trim($('#chatFriendsSearch').val()) == "") {
                    var uu = sessionStorage.gMinUserId;
                    var un = sessionStorage.gMinUserName;
                    if (uu != "undefined" && uu != null) {
                        var uuArray = uu.split(",");
                        var unArray = un.split(",");
                        delete unArray[jQuery.inArray($.trim(data[0].userObj.UserId), uuArray)];
                        delete uuArray[jQuery.inArray($.trim(data[0].userObj.UserId), uuArray)];

                        sessionStorage.gMinUserName = cleanArray(unArray);
                        sessionStorage.gMinUserId = cleanArray(uuArray);
                        minChatArray = [];
                        for (var i = 0; i <= uuArray.length; i++) {

                            if (uuArray[i] != "" && uuArray[i] != "undefined" && uuArray[i] != null) {

                                minChatArray.push(uuArray[i]);

                                createMinChatDiv(uuArray[i], unArray[i], "session");
                            }

                        }
                        if (unArray.length == 4) {
                            sessionStorage.fourMinWindow = "true";
                        } else {
                            sessionStorage.fourMinWindow = "false";
                        }
                    }
                }
                $("#minchatArea").html("");
                if(chatStartLimit == chatPageLength){
                $("#showChatArea_" + data[0].userObj.UserId).click();
                }
               
                sessionStorage.chatSearch = "true";

            } else if (data.length == 0) {
                stoploadingusers = true;
                if (chatStartLimit == 0) {
                    scrollPleaseWaitClose("chatSpinLoader");
                    $("#mjmChatMessage").attr('readonly', 'readonly');
                    //  $("#chatUsersList").html("<ul><li>No Users</li></ul>");
                    $("#chatData").html("");
                    $("#chatUsersList").html("");
                    $("[name='chatmessagearea']").show();
                     var panHeight = $( window ).height()-290;
                      $("#chatBoxScrollPane").css("min-height",panHeight);
                    $('#usersListScrollPane').jScrollPane();
                }
            }
        }
    }
     function  renderSearchUsers(data) {
           $("#findUsersSpinner").hide();
     var panHeight = $( window ).height()-205;
     $("#findUsersScrollPane").css("min-height",panHeight);
        if ($.trim(data) != "") {
            data = eval("(" + data + ")");
           var searchText = $.trim(data.searchText);

            data = data.data;
           // alert(data.toSource());
            if (data.length > 0) {
                var item = {
                    "data": data
                };
                stoploadingusers = false;
               if(searchUsersStartLimit != 0){
                    $("#findUsersList").append($("#searchUsersListTmpl").render(item));
               }else{
                   $("#findUsersList").html($("#searchUsersListTmpl").render(item)); 
               }
                searchUsersStartLimit = Number(searchUsersStartLimit) + Number(chatPageLength);
               // alert(chatStartLimit)
                
               
                $('#findUsersScrollPane').jScrollPane();
                $(".movetoinboxb").bind("click",function(){
                    var searchUserId = $(this).attr("data-id");
                   // alert(searchUserId);
                    $(this).attr("class","inboxb");
                    $(this).html("Inbox");
                    $(this).unbind("click");
                    if (parseInt(loginUserId) < parseInt(searchUserId)) { 
                         var roomName = "Room-" + loginUserId + "-" + searchUserId;
                   } else { 
                        var roomName = "Room-" + searchUserId + "-" + loginUserId;
                   }
                   //alert(roomName);
                   //return;
                   //$(".movetoinboxb").remove();
                  // $("#chatUsersList").prepend($("#ul_"+searchUserId));
                   $("#ul_"+searchUserId).clone().prependTo($("#chatUsersList"));
                    $("#inboxbutton_"+searchUserId).remove();
                    saveChatConversation(roomName, loginUserId, "");
                    $("#inboxCount").html(parseInt($("#inboxCount").html())+1);
                    
                })
                return;
                if (offlineSenderId != null && offlineSenderId != "" && offlineSenderId != undefined) {
                    offlineSenderId.forEach(function(entry) {
                        $("#offlineIcon_" + entry).show();
                        $("#offlineIcon_" + entry).addClass("chatStatusGrey");
                    });

                }
                if (onlineUserIds != null && onlineUserIds != "" && onlineUserIds != undefined) {
                    $.unique(onlineUserIds);
                    onlineUserIds.forEach(function(entry) {

                        $("#offlineIcon_" + entry).show();
                        myObj[entry] = setInterval(function() {

                            $("#offlineIcon_" + entry).toggleClass('chatStatusGreen');
                        }, 500);
                    });
                }
                if ($.trim($('#chatFriendsSearch').val()) == "") {
                    var uu = sessionStorage.gMinUserId;
                    var un = sessionStorage.gMinUserName;
                    if (uu != "undefined" && uu != null) {
                        var uuArray = uu.split(",");
                        var unArray = un.split(",");
                        delete unArray[jQuery.inArray($.trim(data[0].userObj.UserId), uuArray)];
                        delete uuArray[jQuery.inArray($.trim(data[0].userObj.UserId), uuArray)];

                        sessionStorage.gMinUserName = cleanArray(unArray);
                        sessionStorage.gMinUserId = cleanArray(uuArray);
                        minChatArray = [];
                        for (var i = 0; i <= uuArray.length; i++) {

                            if (uuArray[i] != "" && uuArray[i] != "undefined" && uuArray[i] != null) {

                                minChatArray.push(uuArray[i]);

                                createMinChatDiv(uuArray[i], unArray[i], "session");
                            }

                        }
                        if (unArray.length == 4) {
                            sessionStorage.fourMinWindow = "true";
                        } else {
                            sessionStorage.fourMinWindow = "false";
                        }
                    }
                }
                $("#minchatArea").html("");
                if(chatStartLimit == chatPageLength){
                $("#showChatArea_" + data[0].userObj.UserId).click();
                }
               
                sessionStorage.chatSearch = "true";

            } else if (data.length == 0) {
                stoploadingusers = true;
                if (searchUsersStartLimit == 0) {
                    scrollPleaseWaitClose("chatSpinLoader");
                   // $("#mjmChatMessage").attr('readonly', 'readonly');
                    //  $("#chatUsersList").html("<ul><li>No Users</li></ul>");
                    //$("#chatData").empty();
                    $("#findUsersList").empty();
                    $("[name='chatmessagearea']").show();
                    $('#findUsersScrollPane').jScrollPane();
                }
            }
        }
    }
    function saveChatConversation(roomName, loginUserId, chatMessage) {
        //var queryString = "roomName=" + roomName + "&loginUserId=" + loginUserId + "&chatMessage=" + chatMessage;
        var queryString = {"roomName": roomName, "loginUserId": loginUserId, "chatMessage": chatMessage};
        ajaxRequest("/chat/saveChatConversations", queryString, saveChatConversationHandler);
    }
    function saveChatConversationHandler(data) {

    }
    function saveOfflineChatStatus(roomName, loginUserId, offlineUserId) {
        //  var queryString = "roomName=" + roomName + "&loginUserId=" + loginUserId + "&offlineUserId=" + offlineUserId;
        var queryString = {"roomName": roomName, "loginUserId": loginUserId, "offlineUserId": offlineUserId};
        ajaxRequest("/chat/saveOfflineChatStatus", queryString, saveOfflineChatStatusHandler);
    }
    function saveOfflineChatStatusHandler(data) {
        //alert(data);
    }
    getOfflineMessages = function(loginUserId) {
        if (typeof socket !== "undefined")
            socket.emit('getOfflineMessages', loginUserId, function(data) {

            });

    }
    getOfflineMessages(loginUserId);

//});
    function buidMessage(profilePicture, data) {
        //alert(data);
       data =  data.replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace("?<=<[^>]*)&nbsp'", ' ').replace("&amp;nbsp;", ' ').replace(/&nbsp;/g, ' ')
       // data = data.replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, '"');
        var dataObj = new Object();
        dataObj.message = data;
        dataObj.profilePicture = profilePicture;
        dataObj.createdOn = '<?php echo Yii::t('translation', 'Time_Few')." ".Yii::t('translation', 'Time_Sec')." ".Yii::t('translation', 'Time_Ago');?>';
        var item = {
            "data": dataObj
        };
         $('#content_hide').html($("#chatMessageTmpl").render(item));
          L_replaceAll('#content_hide');
        $("#chatData").append($('#content_hide').html());
        // $("#chatData").html( $("#chatData").text());
        var api = $('#chatBoxScrollPane').data('jsp');
        try{
        api.scrollToBottom(false);
            
        }catch(err){
            
        }
    }
    function buidMinMessage(profilePicture, data, chatBoxId) {
        data =  data.replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace("?<=<[^>]*)&nbsp'", ' ').replace("&amp;nbsp;", ' ').replace(/&nbsp;/g, ' ')


        var dataObj = new Object();
        dataObj.message = data;
        dataObj.profilePicture = profilePicture;
        dataObj.createdOn = "few secs ago";
        var item = {
            "data": dataObj
        };
          $('#content_hide').html($("#minChatMessageTmpl").render(item));
          L_replaceAll('#content_hide');
        $("#minChatData_" + chatBoxId).append($('#content_hide').html());
        var api = $('#minchatScrollPane_' + chatBoxId).data('jsp');
       try{
        api.scrollToBottom(false);
            
        }catch(err){
            
        }
    }
    function cleanArray(actual)
    {
        var newArray = new Array();
        for (var i = 0; i < actual.length; i++)
        {
            if (actual[i])
            {
                newArray.push(actual[i]);
            }
        }
        return newArray;
    }
    function loadMoreChatUsers(startLimit, userId) {
        if (typeof socket != "undefined") {
            socket.emit('getUserFriends',userId, "",startLimit,chatPageLength);
        }
    }
     function loadMoreSearchUsers(startLimit, userId) { 
        if (typeof socket != "undefined") {
          //  socket.emit('getUserFriends',userId, "",startLimit,chatPageLength);
            socket.emit('searchUsers', loginUserId, $.trim($('#findFriendsSearch').val()),startLimit,chatPageLength)
         }
    }
    socket.on('loadMoreChatUsersResponse', renderChatUserFriends);
    function removeFromArray(array,search_term){      
        
    for (var i=array.length-1; i>=0; i--) {   
   if (array[i] == search_term) {  //alert('if');       
       array.splice(i, 1);
    return array;
   }

 
}  
  return array; 
    }
</script>


