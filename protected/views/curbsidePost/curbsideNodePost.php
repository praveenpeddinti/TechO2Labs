<script type="text/javascript">
    var status = 0;
    var fort = 1;
    var ts = 0;
    var data_content = "";
    var g_streamId = 0;
    var loginUserId = '<?php echo $this->tinyObject->UserId; ?>';
    var userTypeId = '<?php echo Yii::app()->session['UserStaticData']->UserTypeId ?>';
    if (typeof io !== "undefined") {
        var socketCurbside = io.connect('<?php echo Yii::app()->params['NodeURL']; ?>');
        clearInterval(intervalIdNewpost);
        // socket connection is established...
//        socketCurbside.on("connect", function() {
            function sessionCurbAliveHandlerTen(data) {
                if (data.code == 440) {
                    socketCurbside.emit('clearInterval', remoteAddress);
                }
            }

            socketCurbside.on('CurbsidePostsResponse', function(content) {  //alert("===clientresp==="+content);          
                pF1 = 2;
                try{
                    if (content != undefined && content != "" && content != 0) {
                        var data1 = eval(content);
                        for (var i = 0; i < data1.length; i++) {
                            $("#streamLoveCount_" + data1[i].PostId).html(data1[i].LoveCount);
                            $("#commentCount_" + data1[i].PostId).html(data1[i].CommentCount);
                            $("#streamFollowUnFollowCount_" + data1[i].PostId).html(data1[i].FollowCount);

                        }
                      
                    }
                }catch(err){
                    ;
                }
            });
            socketCurbside.on('getNewCurbsidePostsResponse', function(content) { //alert("=====getNewCurb response==="+content);
                pF2 = 2;
                var noofstories = 0;
                var data;
                try{
                    data = eval("(" + content + ")");
                    noofstories = data.count;
                    data_content = data.object;
                }catch(err){
                    //alert(err);
                }

                if (noofstories > 0 && isThereReady === false) {
                    var renderHtml;
                    var s_text = "story";
                    $("#notificationsCount").html(noofstories);
                    if (noofstories > 1) {
                        s_text = "stories";
                    }
                    $("#notificationsTitle").html(s_text);
                    var scrollTp = $(window).scrollTop();
                    scrollTp = Number(scrollTp) + 200;
                    $("#notificationsdiv").css("top", scrollTp + "px");
                    $("#notificationsdiv").show();
                    $("#notificationsdiv").fadeOut(6000, "");
                    $("#notificationsdiv").unbind("click");
                    $("#notificationsdiv").click(function() {
                        $("#notificationsdiv").hide();
                        if(use4storiesinsertedid != 0){ 
                            data_content = "<div>"+data_content+"</div>";
                            $(data_content).find("div.post.item").each(function(key, val){
                                var postId = $(this).attr('data-postid');
                                if($("#curbsidePostsDiv div.post.item[data-postid="+postId+"]").length>0){
                                    data_content = $(data_content)
                                        .find("div.post.item[data-postid="+postId+"]")
                                            .remove()
                                        .end().html();
                                }
                            });
                            setTimeout(function(){
                                    $(data_content).insertAfter("#"+use4storiesinsertedid);
                                    $("div.item").fadeIn(500);
                            },1200);                       

                            setTimeout(function(){
                                   $('html, body').animate({
                                   scrollTop: $("#"+use4storiesinsertedid).offset().top
                               }, 800);
                            },1400);
                        
                        }else if(use4storiesinsertedid == 0){
                            $("#curbsidePostsDiv").prepend(data_content);
                        }
//                        $('.post').each(function(key, value) {
//                            var post = $(this);
//                            var positionTop = post.position().top;
//                            var positionBottom = positionTop + post.height();
//                            var windowScrollTop = $(window).scrollTop();
//                            if (positionTop < windowScrollTop && positionBottom > windowScrollTop) {
//                                if (status == 0) {
//                                    $(data_content).insertBefore('#' + post.attr('id'));
//                                    status = 1;
//                                    $("#notificationsdiv").hide();
//                                    fort = 0;
//                                    return false;
//                                }
//
//                            } else if (positionTop > windowScrollTop && positionBottom > windowScrollTop) {
//
//                                if (status == 0) {
//                                    $(data_content).insertBefore('#' + post.attr('id'));
//                                    status = 1;
//                                    $("#notificationsdiv").hide();
//                                    fort = 0;
//                                    return false;
//                                }
//
//                            } else if (positionTop == 0 && windowScrollTop == 0) {
//                                if (status == 0) {
//                                    $(data_content).insertBefore('#' + post.attr('id'));
//                                    status = 1;
//                                    $("#notificationsdiv").hide();
//                                    fort = 0;
//                                    return false;
//                                }
//
//                            }
//                            $("div.item").fadeIn(500);
//
//                        });



                    });

                }

            });

            socketCurbside.on('getLatestCurbsidePostRes', function(content) {
                if (content != 0) {
                    isThereReady = false;
                    var data = content.split("_((***&&***))_");
                    noofstories = data[1];
                    postId = data[2];
                    if ($("#postitem_" + postId).length == 0) {
                        data_content = data[0];
                        $("#curbsidePostsDiv").removeClass('NPF');
                        if ($(".ndm").is(':visible'))
                            $(".ndm").hide();
                        $("#curbsidePostsDiv").prepend(data_content);

                    }
                    pF1 = 1;
                    ObjectA = {PF1: pF1, PF2: pF2, sCountTime: socialActionIntervalTime, storiesTime: postIntervalTime, hostName: remoteAddress, pageName: gPage};
                    var jsonObject = JSON.stringify(ObjectA);
                    socketCurbside.emit('getNewCurbsidePostsRequest', g_postDT, loginUserId, userTypeId, jsonObject);
                }

            });
//        });

// handling if socketCurbside is not connected to the server...
        socketCurbside.on("error", function() {
            // Do stuff when we connect to the server
            clearInterval(curbSocialStatsInterval);
            clearInterval(intervalIdCurbpost);
        });
    }
</script>