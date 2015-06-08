
function translatePostData(obj){
    var streamId = $.trim($(obj).attr('data-id'));
    var postId = $.trim($(obj).attr('data-postid'));
    var postType = Number($.trim($(obj).attr('data-postType')));
    var categoryType = $(obj).attr('data-categoryType');
    var text = $.trim($("#post_content_total_"+streamId).html());
    if(text.length<=0){
        text = $.trim($("#post_content_"+streamId).html());
    }
    var fromLanguage = $(obj).attr('data-fromLanguage');
    var toLanguage = $(obj).attr('data-toLanguage');
    var queryString = {
            postId:postId,
            postType:postType,
            categoryType:categoryType,
            text:text,
            fromLanguage:fromLanguage,
            toLanguage:toLanguage,
            page:gPage
        };
    var url = "/common/translateData";
    if(postType==3){//Survey
        queryString.title = "";
        if($("#surveyTakenArea_"+streamId).is(":visible")){
            queryString.optionOne = $.trim($("#GraphArea_OptionOne_"+streamId).text());
            queryString.optionTwo = $.trim($("#GraphArea_OptionTwo_"+streamId).text());
            queryString.optionThree = $.trim($("#GraphArea_OptionThree_"+streamId).text());
            queryString.optionFour = $.trim($("#GraphArea_OptionFour_"+streamId).text());
        }else if($("#surveyArea_"+streamId).is(":visible")){
            queryString.optionOne = $("#OptionOne_"+streamId).text();
            queryString.optionTwo = $("#OptionTwo_"+streamId).text();
            queryString.optionThree = $("#OptionThree_"+streamId).text();
            queryString.optionFour = $("#OptionFour_"+streamId).text();
        }
    }else if(postType==2){//Event
        queryString.title = "";
        queryString.location = $("#Location_"+streamId).text();
    }else if(postType==11){
        queryString.title = "";
        if($("#newsTitle_"+streamId).length>0){
            queryString.title = $("#newsTitle_"+streamId).text();
        }
    }else if(postType==12){//Game
        var gameId = $.trim($(obj).attr('data-postid'));
        queryString.gameId = gameId;
        queryString.gameName = $.trim($("#stream_gameName_"+streamId).text());
        queryString.gameDescription = $.trim($("#stream_gameDescription_"+streamId).text());
        url = "/common/TranslateGameData";
    }
    scrollPleaseWait('stream_view_spinner_'+streamId);
    ajaxRequest(url, queryString, function(data){translateDataHandler(data,obj, fromLanguage, toLanguage)});
}

function translateDataHandler(data, obj, fromLanguage, toLanguage){
    var streamId = $.trim($(obj).attr('data-id'));
    scrollPleaseWaitClose('stream_view_spinner_'+streamId);
    $("#post_content_"+streamId).html(data.bean.PostText);
    $(obj).val('Translate to '+fromLanguage);
    $(obj).attr('data-fromLanguage',toLanguage);
    $(obj).attr('data-toLanguage',fromLanguage);
    var postType = Number($.trim($(obj).attr('data-postType')));
    if(postType==3){
        if($("#surveyTakenArea_"+streamId).is(":visible")){
            $("#GraphArea_OptionOne_"+streamId).text(data.bean.OptionOne);
            $("#GraphArea_OptionTwo_"+streamId).text(data.bean.OptionTwo);
            $("#GraphArea_OptionThree_"+streamId).text(data.bean.OptionThree);
            $("#GraphArea_OptionFour_"+streamId).text(data.bean.OptionFour);
        }else if($("#surveyArea_"+streamId).is(":visible")){
            $("#OptionOne_"+streamId).text(data.bean.OptionOne);
            $("#OptionTwo_"+streamId).text(data.bean.OptionTwo);
            $("#OptionThree_"+streamId).text(data.bean.OptionThree);
            $("#OptionFour_"+streamId).text(data.bean.OptionFour);
        }
    }else if(postType==2){
        $("#Location_"+streamId).html('<i class="fa fa-map-marker"></i>'+data.bean.Location);
    }else if(postType==11){
        if($("#newsTitle_"+streamId).length>0){
            $("#newsTitle_"+streamId).html(data.bean.Title);
        }
    }else if(postType==12){//Game
        $("#stream_gameName_"+streamId).html(data.bean.GameName);
        $("#stream_gameDescription_"+streamId).html(data.bean.GameDescription);
    }
}

function translateCommentData(obj){
    var commentId = $.trim($(obj).attr('data-id'));
    var postId = $.trim($(obj).attr('data-postid'));
    var postType = Number($.trim($(obj).attr('data-postType')));
    var categoryType = $(obj).attr('data-categoryType');
    var text = $.trim($("#post_content_total_"+commentId).html());
    if(text.length<=0){
        text = $.trim($("#post_content_"+commentId).html());
    }
    var fromLanguage = $(obj).attr('data-fromLanguage');
    var toLanguage = $(obj).attr('data-toLanguage');
    var queryString = {
            commentId:commentId,
            postId:postId,
            postType:postType,
            categoryType:categoryType,
            text:text,
            fromLanguage:fromLanguage,
            toLanguage:toLanguage,
            page:gPage
        };
        scrollPleaseWait("commentSpinLoader_" + commentId, "comment_" + commentId);
    ajaxRequest("/common/translateCommentData", queryString, function(data){commentTranslateDataHandler(data,obj, fromLanguage, toLanguage)});
}
function commentTranslateDataHandler(data, obj, fromLanguage, toLanguage){
    var commentId = $.trim($(obj).attr('data-id'));
    scrollPleaseWaitClose("commentSpinLoader_" + commentId);
    $("#post_content_"+commentId).html(data.html);
    $(obj).val('Translate to '+fromLanguage);
    $(obj).attr('data-fromLanguage',toLanguage);
    $(obj).attr('data-toLanguage',fromLanguage);
    var postType = Number($.trim($(obj).attr('data-postType')));
    if(postType==12){
        if($('#gameprofilebox').length>0){
            applyLayout();
        }
    }
}

function translateGameData(obj){
    //header_gameName_54869cb5c95dbb0d058b456f
    var gameId = $.trim($(obj).attr('data-postId'));
    var postType = Number($.trim($(obj).attr('data-postType')));
    var categoryType = Number($(obj).attr('data-categoryType'));
    var fromLanguage = $(obj).attr('data-fromLanguage');
    var toLanguage = $(obj).attr('data-toLanguage');
    var location = $(obj).attr('data-location');
    
    var queryString = {
            gameId:gameId,
            postType:postType,
            categoryType:categoryType,
            fromLanguage:fromLanguage,
            toLanguage:toLanguage,
            page:gPage
        };
    var url = "/common/TranslateGameData";
    if(location=="header"){
        scrollPleaseWait('groupProfileDiv_spinner');
        queryString.gameName = $.trim($("#header_gameName_"+gameId).text());
        queryString.gameDescription = $.trim($("#detailDescriptioToshow").text());
        $("#game_descriptionMore").hide();
        $("#moreup").hide();
    }else if(location=="schedules"){
        var streamId = $.trim($(obj).attr('data-id'));
        queryString.gameName = $.trim($("#gameName_"+streamId).text());
        queryString.gameDescription = $.trim($("#gameDescription_"+streamId).text());
        scrollPleaseWait('stream_view_spinner_'+streamId);
    }
    ajaxRequest(url, queryString, function(data){
        translateGameDataHandler(data,obj, fromLanguage, toLanguage);
    });
}

function translateGameDataHandler(data,obj, fromLanguage, toLanguage){
    var gameId = $.trim($(obj).attr('data-postId'));
    var location = $(obj).attr('data-location');
    if(location=="header"){
        scrollPleaseWaitClose('groupProfileDiv_spinner');
        $("#header_gameName_"+gameId).text(data.bean.GameName);
        $("#descriptioToshow").text(data.bean.GameDescription);
        $("#detailDescriptioToshow").text(data.bean.GameDescription);
    }else if(location=="schedules"){
        var streamId = $.trim($(obj).attr('data-id'));
        scrollPleaseWaitClose('stream_view_spinner_'+streamId);
        $.trim($("#gameName_"+streamId).text(data.bean.GameName));
        $.trim($("#gameDescription_"+streamId).text(data.bean.GameDescription));
    }
    $(obj).val('Translate to '+fromLanguage);
    $(obj).attr('data-fromLanguage',toLanguage);
    $(obj).attr('data-toLanguage',fromLanguage);
}

function translateGameQuestions(){
    
}