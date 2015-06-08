<script type="text/javascript">
    var data_content = "";
    var g_streamId = 0;
    var loginUserId = '<?php echo $this->tinyObject->UserId; ?>';
    var userTypeId = '<?php echo Yii::app()->session['UserStaticData']->UserTypeId ?>';
    if (typeof io !== "undefined") {
        var socket4Game = io.connect('<?php echo Yii::app()->params['NodeURL']; ?>');
        var gameSocialStatsInterval;
        //socket connection is established...
        socket4Game.on("connect", function() {
           

            socket4Game.on('serverResponse4Game', function(content) {//alert('cleintserverResponse---'+content);
                var data1 = eval(content);
                pF1 = 2;
                if (data1 != undefined && data1 != "" && data1 != 0) {

                    for (var i = 0; i < data1.length; i++) {
                        $("#followCount_" + data1[i].PostId).html(data1[i].FollowCount);
                        $("#streamLoveCount_" + data1[i].PostId).html(data1[i].LoveCount);
                        $("#commentCount_" + data1[i].PostId).html(data1[i].CommentCount);
                    }
                }
            });

        });
// handling if socketPost is not connected to the server...
        socket4Game.on("error", function() {
            // Do stuff when we connect to the server
            clearInterval(gameSocialStatsInterval);
        });
    }
</script>