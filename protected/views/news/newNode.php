<script type="text/javascript">
    var status = 0;
    var g_post = 0;
    var g_postIds = 0;
    var fort = 1;
    var ts = 0;
    var data_content = "";
    var g_streamId = 0;
    var socketNewsPost;
    //var loginUserId = '<?php //echo $this->tinyObject->UserId;  ?>';
    //var userTypeId = '<?php //echo Yii::app()->session['UserStaticData']->UserTypeId ?>';
    if (typeof io !== "undefined") { 
         socketNewsPost = io.connect('<?php echo Yii::app()->params['NodeURL']; ?>');
        //socket connection is established...
        socketNewsPost.on("connect", function() {


            socketNewsPost.on('serverResponse4news', function(content) { //alert(content)
                pF1 = 2;
                var data1 = eval(content);
                if (data1 != undefined && data1 != "" && data1 != 0) {
                    for (var i = 0; i < data1.length; i++) {
                        $("#streamLoveCount_" + data1[i].PostId).html(data1[i].LoveCount);
                        $("#commentCount_" + data1[i].PostId).html(data1[i].CommentCount);
                    }
                  
                }
            });

        });
// handling if socketPost is not connected to the server...
        socketNewsPost.on("error", function() {
            socketNewsPost.emit('clearInterval', sessionStorage.old_key);
        });
    }
</script>