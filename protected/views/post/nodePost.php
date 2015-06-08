<script type="text/javascript">
    var status = 0;
    var g_post = 0;
    
    var fort = 1;
    var ts = 0;
    var data_content = "";
    var g_streamId = 0;
    var loginUserId = '<?php echo $this->tinyObject->UserId; ?>';
    var userTypeId = '<?php echo Yii::app()->session['UserStaticData']->UserTypeId?>';
    if(typeof io !== "undefined"){
    var socketPost = io.connect('<?php echo Yii::app()->params['NodeURL']; ?>',{ query: "timezoneName="+timezoneName });
    var postAsNetwork = Number('<?php echo Yii::app()->session['PostAsNetwork']?>');
    //socket connection is established...
       
        function sessionAliveHandlerTen(data){            
            if(data.code == 440){
                socketPost.emit('clearInterval',remoteAddress);
            }
        }        
        socketPost.on('serverResponse', function(content) {
            pF1 = 2;
        
            try{
                if (content != undefined && content != "" && content != 0) {
                    var data1 = eval(content);
                    for (var i = 0; i < data1.length; i++) { 
                        if(data1[i]!=""){
                         if( $("#spots_" + data1[i].PostId).length>0){
                        $("#spots_" + data1[i].PostId).html(data1[i].SpotMessage);
                    }else{
                        var htmlLoveString = "";
                         jQuery.each(data1[i].loveUsersArray, function(index, item) {
                          htmlLoveString = htmlLoveString+""+item+"<br/>"
                            });
                             var htmlFollowString = "";
                         jQuery.each(data1[i].followUsersArray, function(index, item) {
                          htmlFollowString = htmlFollowString+""+item+"<br/>"
                            });
                          //  alert(htmlFollowString);
                           // alert(data1[i].PostId+"---"+data1[i].FollowCount);
                        $("#userLoveView_" + data1[i].PostId).html(htmlLoveString);
                         $("#userFollowView_" + data1[i].PostId).html(htmlFollowString);
                        $("#streamLoveCount_" + data1[i].PostId).html(data1[i].LoveCount);
                        $("#commentCount_" + data1[i].PostId).html(data1[i].CommentCount);
                        $("#streamFollowUnFollowCount_" + data1[i].PostId).html(data1[i].FollowCount);
                    }
                }
                    }
                  
                }
            }catch(err){
                ;
            }
            
        });
        socketPost.on('getNewPostsResponse', function(content) {
            pF2 = 2;
            var noofstories = 0;
            var data;
            try{
                data = eval("(" + content + ")");
                noofstories = data.count;
                data_content = data.object;
            }catch(err){
                ;
            }
            
            if (noofstories > 0 && isThereReady == false) {                 
                
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
                setTimeout(function(){
                 $("#notificationsdiv").hide();   
                },5000);
                $("#notificationsdiv").unbind("click");
                $("#notificationsdiv").click(function(e) {
                    $("#notificationsdiv").hide();
                    if(use4storiesinsertedid != 0){ 
                        data_content = "<div>"+data_content+"</div>";
                        $(data_content).find("div.post.item").each(function(key, val){
                            var postId = $(this).attr('data-postid');
                            if($("#streamMainDiv div.post.item[data-postid="+postId+"]").length>0){
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
                        $("#streamMainDiv").prepend(data_content);
                    }
                    

                });

            }

        });

        socketPost.on('getLatestPostsRes', function(content) {
            if (content != 0) {
                isThereReady = false;
                var data = content.split("_((***&&***))_");
                noofstories = data[1];
                var streamId = data[2];                
                if ($("#postitem_" + streamId).length == 0) {
                    data_content = data[0];
                    $("#streamMainDiv").removeClass('NPF');
                    if($(".ndm").is(':visible'))
                    $(".ndm").hide();
                    $("#streamMainDiv").prepend(data_content);
                       $("[rel=tooltip]").tooltip();
                }
                pF1 = 1;
                ObjectA = {PF1:pF1,PF2:pF2,sCountTime:socialActionIntervalTime,storiesTime:postIntervalTime,hostName:remoteAddress,pageName:gPage};
                var jsonObject = JSON.stringify(ObjectA); 
                socketPost.emit('getNewPostsRequest', g_postDT, loginUserId,userTypeId,postAsNetwork,jsonObject);
            }

        });
// handling if socketPost is not connected to the server...
    socketPost.on("error", function() {
        // Do stuff when we connect to the server
        clearInterval(postSocialStatsInterval);
        clearInterval(intervalIdNewpost);
    });
    function renderStreamViewHandler(html){        
            setTimeout(function(){
                 $(html).insertAfter("#"+use4storiesinsertedid);
                 $("div.item").fadeIn(500);
            },1200);                       

            setTimeout(function(){
                $('html, body').animate({
                scrollTop: $("#"+use4storiesinsertedid).offset().top
            }, 800);
            },1400);
    }
    }
</script>