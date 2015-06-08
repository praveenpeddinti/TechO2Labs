/*
 * @DeveloperName: Sagar Pathapelli
 * Used for posting the post and displaying the Stream
 */
var GroupconversationUploadedFiles = new Array();
var GroupuploadedArtifacts = new Array();
var GroupcommentUploadedFiles = new Array();
var GroupcommentGroupuploadedArtifacts = new Array();
var groupPostInterval = 0; // this is used for the node hookup
var IsUserExist = 0; // this is used for KOL Post
/*
 * This method is used for display the previe of uploaded artifact.
 */
function GroupPreviewImage(file, response, responseJSON) {
    $('#preview').show();
    $('#previewul').show();
    if (GroupconversationUploadedFiles.length < 4) {
        // if (GroupuploadedArtifacts.indexOf(response) < 0) { // doesn't exist
        if ($.inArray(response, GroupuploadedArtifacts) < 0) {

            $('.qq-upload-list').hide();
            var data = responseJSON;
            var filetype = responseJSON['extension'];
            var image = "";
            var imageid = responseJSON['savedfilename'];
            if (filetype == 'ppt' || filetype == 'pptx') {
                image = "/images/system/PPT-File-icon.png";
            } else if (filetype == 'pdf') {
                image = "/images/system/pdf.png";
            } else if (filetype == 'mp3') {
                image = "/images/system/audio_img.png";
            } else if (filetype == 'mp4' || filetype == 'flv' || filetype == 'mov') {
                image = "/images/system/video_img.png";
            } else if (filetype == 'doc' || filetype == 'docx') {
                image = "/images/system/MS-Word-2-icon.png";
            } else if (filetype == 'txt') {
                image = "/images/system/notepad-icon.png";
            } else if (filetype == 'exe' || filetype == 'xls' || filetype == 'ini' || filetype == 'xlsx') {
                image = "/images/system/Excel-icon.png";
            } else {
                image = responseJSON['filepath'];
            }
            GroupconversationUploadedFiles.push(responseJSON['filename']);
            GroupuploadedArtifacts.push(responseJSON['filename']);

            $('#previewul').append(' <li class="alert" ><i  id="' + imageid + '" ontouchstart="closeGrouppostimage(this,' + "'" + responseJSON['savedfilename'] + "'" + "," + "'" + responseJSON['fileremovedpath'] + "'" + "," + "'" + responseJSON['filename'] + "'" + ');" onclick="closeGrouppostimage(this,' + "'" + responseJSON['savedfilename'] + "'" + "," + "'" + responseJSON['fileremovedpath'] + "'" + "," + "'" + responseJSON['filename'] + "'" + ');"  class="fa fa-times-circle deleteicon mobiledeleteicon"  data-dismiss="alert" ></i><i style="display:none" class="fa fa-search-plus zoomicon" ></i><a  class="postimgclose mobilepostimgclose"   href="#"> </a>\n\
                <img src="' + image + '"></li>');

            // $('#GroupPostForm_Artifacts').val(GroupconversationUploadedFiles);
        }
        else { // does exist
            var message = response + Translate_Already_uploaded_please_upload_another_file;
            $('#GroupPostForm_Artifacts_em_').show();
            $('#GroupPostForm_Artifacts_em_').css("padding-top:20px;");
            $('#GroupPostForm_Artifacts_em_').html(message);

        }
    } else {
        var message = Translate_Already_uploaded_4_files;
        $('#GroupPostForm_Artifacts_em_').show();
        $('#GroupPostForm_Artifacts_em_').css("padding-top:20px;");
        $('#GroupPostForm_Artifacts_em_').html(message);

    }
}
/*
 * This method is used for remove the  uploaded artifact.
 */
function closeGrouppostimage(obj, filename, filepath, image) {
    var file = filepath;
    var queryString = "image=" + image + "&file=" + image + "&filepath=" + file;
    ajaxRequest("/group/removegroupartifacts", queryString, removeGroupArtifactHandler);
}
/*
 * Remove artifact handler.
 */
function removeGroupArtifactHandler(data) {

    if (data.status == 'success') {
        var filename = data.file;
        var vindex = GroupconversationUploadedFiles.indexOf(data.filename);
        if (vindex != -1) {
            GroupconversationUploadedFiles.splice(vindex, 1);
        }
        var vindex = GroupuploadedArtifacts.indexOf(data.image);
        if (vindex != -1) {
            GroupuploadedArtifacts.splice(vindex, 1);
        }
    } else {

        //  alert("fail");
    }
}
/*
 * This method is used for Websnippet preview.
 */
function getsnipetForGroup(event, obj) { 
    $(".atmention_popup").hide();
    if ($(obj).html().length > 0) {
        removeErrorMessage("GroupPostForm_Description");
    }
    var urlPattern = "(((https?)\:\/\/)|(www\.))[A-Za-z0-9][A-Za-z0-9.-]+(:\d+)?(\/[^ ]*)?";
    var text = $(obj).text();
    var results = text.match(new RegExp(urlPattern));

    if (results && event.keyCode == '32') {
        var Weburl = results[0].split("&nbsp");
        var queryString = {data: Weburl[0], Type: "post"};
        ajaxRequest("/post/SnippetpriviewPage", queryString, getForGroupsnipetHandler);
    }

}
/*
 * WebSnippet preview handler.
 */
function getForGroupsnipetHandler(data) {
    if (data.status == 'success') {
        $('#Groupsnippet_main').show();
        var item = {
            'data': data
        };
        $("#Groupsnippet_main").html(
                $("#snippetDetailTmpl").render(item)
                );
        if (typeof globalspace['IsWebSnippetExistForPost'] == 'undefined' || globalspace['IsWebSnippetExistForPost'] == '0') {
            globalspace['IsWebSnippetExistForPost'] = 1;
        }
        if (typeof globalspace['weburls'] == 'undefined' || globalspace['weburls'] == '' || globalspace['weburls'] != '') {
            globalspace['weburls'] = data.snippetdata['Weburl'];

        }

    }

}

function getsnipetForGroupComment(event, obj, commentId) {

    if (event.keyCode == '32') {
        $(".atmention_popup").hide();
        if ($(obj).html().length > 0) {
            removeErrorMessage("NormalPostForm_Description");
        }
        var urlPattern = "(((https?)\:\/\/)|(www\.))[A-Za-z0-9][A-Za-z0-9.-]+(:\d+)?(\/[^ ]*)?";
        var text = $(obj).text();
        var results = text.match(new RegExp(urlPattern));
        var Weburl = results[0].split("&nbsp");
        var queryString = 'data=' + Weburl[0] + '&CommentId=' + commentId + "&Type=comment";
        ajaxRequest("/post/SnippetpriviewPage", queryString, function(data) {
            getsnipetForGroupCommentHandler(data, commentId);
        });
    }

}

function getsnipetForGroupCommentHandler(data, commentId) {
    if (data.status == 'success') {
        $('#snippet_main_' + commentId).show();
        var item = {
            'data': data
        };
        $("#snippet_main_" + commentId).html(
                $("#snippetDetailTmpl").render(item)
                );
        if (typeof globalspace['IsWebSnippetExistForComment_' + commentId] == 'undefined' || globalspace['IsWebSnippetExistForComment_' + commentId] == '0') {
            globalspace['IsWebSnippetExistForComment_' + commentId] = 1;
        }

        if (typeof globalspace['CommentWeburls_' + commentId] == 'undefined' || globalspace['CommentWeburls_' + commentId] == '' || globalspace['CommentWeburls_' + commentId] != '') {
            globalspace['CommentWeburls_' + commentId] = data.snippetdata['Weburl'];
        }

    }

}

function closeGroupSnippetDiv() {

    $('#Groupsnippet_main').hide();
    $("#Groupsnippet_main").html("");
    globalspace['IsWebSnippetExistForPost'] = 0;
    globalspace['weburls'] = "";
}

function closeGroupCommentSnippetDiv(commentId) {

    $("#snippet_main_" + commentId).hide();
    $("#snippet_main_" + commentId).html("");
    globalspace['IsWebSnippetExistForComment_' + commentId] = 0;
}

function initializationForGroupArtifacts() {

    $("#editable").click(function()
    {
        $("#button_block").show();
        $(this).animate({"min-height": "50px", "max-height": "200px"}, "fast");
        $("#button_block").slideDown("fast");
        return false;
    });

    $("ul[id*=postType] li").click(function() {
        var postType = $(this).text();
        var res = postType.replace(" ", "_");
        postType = $.trim(postType);
        $("#GroupPostForm_StartTime,#GroupPostForm_EndTime").val(" ");
        if (postType == "Event") {
            $('#editable').hide();
            $('#surveydiv').hide();
            $('#eventdiv').show();
            $('#survey_header').hide();
            // $('#editable').html("");
            $("#surveypostdiv").addClass("surveypostdiv");
            $('#editable').show();
            $('#event_header').hide();
            $('#event_header').show();
            $(".timepicker-popup-hour").val('');
            $(".timepicker-popup-minute").val('');
            $('#surveyeventtitledescription').show();

        }        
        if ($.trim(postType) == $.trim("Quick Poll")) {
            $('#editable').hide();
            $('#eventdiv').hide();
            $('#event_header').hide();
            $('#surveydiv').show();
            $('#editable').show();
            $("#surveypostdiv").addClass("surveypostdiv");
            $('#survey_header').hide();
            $('#survey_header').show();
            // $('#editable').html("");
            $('#surveyeventtitledescription').show();
            postType = "Survey";
        }
        $('#GroupPostForm_Type').val(postType);
    });
}

function ClearPostForm() {
    $("#editable").html(" ");
    $("#normalPost-form")[0].reset();
    if (GroupconversationUploadedFiles.length > 0) {
        GroupconversationUploadedFiles.length = 0;
    }
    if (GroupuploadedArtifacts.length > 0) {
        GroupuploadedArtifacts.length = 0;
    }
    $('#e_survey').hide();
    $('#editable').show();
    $('#surveydiv').hide();
    $('#editable').addClass("placeholder");
    $("#editable").attr("placeholder", Translate_New_Post);
    $('#survey_header').hide();
    $('#eventdiv').hide();
    $('#event_header').hide();
    $("#surveypostdiv").removeClass("surveypostdiv");
    $('#GroupPostForm_Artifacts').val('');
    $('#preview').hide();
    $('#previewul').hide();
    $('#previewul').html('');
    if (document.getElementById("Groupsnippet_main")) {
        document.getElementById('Groupsnippet_main').style.display = 'none';
        $("#Groupsnippet_main").html("");
        $('#location_error').html("");
        $('#GroupPostForm_Type').val('');
    }
    $("#button_block").hide();
    $('#surveyeventtitledescription').hide();
}


function validateDescription(obj) {
    if ($(obj).text().length == 0) {
        //displayErrorMessage("GroupPostForm_Description","Description cannot be blank.");
    }
}

function groupsend(isPrivate) {
    var editorObject = $("#editable.inputor");
    var validate = true;
    var GroupId="";
    if($('#GroupPostForm_GroupId')){
         GroupId=$("#GroupPostForm_GroupId").val();
    }
    if (isPrivate == 0) {
       // validate = validateAtMentions(editorObject);
        validate = validateAtMentionsForGroupPost(editorObject,GroupId);
    } else {
        validate = validateAtMentionsForPrivateGroup(editorObject);

    }
    if (validate) {
        if ($.trim($("#editable").text()).length > 0) {
            $("#GroupPostForm_Description").val(getEditorText(editorObject));
        } else {

            $("#GroupPostForm_Description").val('');
        }
        if ($.trim($("#editable").text()).length > 0) {
            $("#GroupPostForm_Description").val(getEditorText(editorObject));
        } else {

            $("#GroupPostForm_Description").val('');
        }

        if ($("#GroupPostForm_Type").val() == "") {
            $("#GroupPostForm_Type").val('Normal Post');
        }

        $('#GroupPostForm_Artifacts').val(GroupconversationUploadedFiles);
        var atMentions = getAtMentions(editorObject);
        $('#GroupPostForm_Mentions').val(atMentions);
        var hashtagString = getHashTags(editorObject);
        $('#GroupPostForm_HashTags').val(hashtagString);
        $('#GroupPostForm_IsWebSnippetExist').val(globalspace['IsWebSnippetExistForPost']);
        $('#GroupPostForm_WebUrls').val(globalspace['weburls']);
        var data = $("#groupPost-form").serialize();
        // ajaxRequest('/group/creategrouppost', data, sendGroupPostHandler);
        ajaxRequest('/group/creategrouppost', data, function(data) {
            sendGroupPostHandler(data, $("#GroupPostForm_Type").val())
        });


    } else {
        displayErrorMessage("GroupPostForm_Description", getAtMentionErrorMessage(editorObject));
    }
}

function sendGroupPostHandler(data, PostType) {    
   if (data.status == "success") {
       globalspace['at_mention_koluser'] = new  Array();
        $("#GroupPostForm_Miscellaneous").val(0);
        $("#koluserdiv").hide();
        $("#kolcheckboxd span.checkbox").attr("style","background-position: 0px 0px;"); 
        $("#groupPost-form")[0].reset();
        removeErrorMessage("GroupPostForm_Description");
        var groupType = 'Group';

        if (data.subgroupId == 0) {
            groupType = 'Group';
        } else {
            groupType = "SubGroup";

        }

        
         if(PostType=='Normal Post'){
            $("#sucmsgForStream").html(data.data);
        }else if(PostType=='Event'){
            $("#sucmsgForStream").html(data.data);
        }else if(PostType=='Survey'){
             $("#sucmsgForStream").html(data.data);
        }

        $("#sucmsgForStream").show();
        $("#sucmsgForStream").fadeOut(3000, "");
        $("#editable").html(" ");
        $("#editable").attr("placeholder", Translate_New_Post);
        $("#postType li").removeClass('selectpostactive');
        globalspace['hashtag_editable'] = new Array();
        globalspace['at_mention_editable'] = new Array();
        if (GroupconversationUploadedFiles.length > 0) {
            GroupconversationUploadedFiles.length = 0;
        }
        $('#GroupPostForm_Artifacts').val('');
        $('#grouppostReset').click();
        $('#preview').hide();
        $('#previewul').hide();
        $('#previewul').html(" ");
        $('#editable').show();
        $('#postTypediv').show();
        $('#surveydiv').hide();
        $('#editable').addClass("placeholder");
        $("#editable").attr("placeholder", Translate_New_Post);
        $('#survey_header').hide();
        $('#eventdiv').hide();
        $('#event_header').hide();
        $("#surveypostdiv").removeClass("surveypostdiv");
        $('#location_error').html("");
        $('#GroupPostCount').html(Number($('#GroupPostCount').text()) + 1)
        $('#surveyeventtitledescription').hide();
        // $('.postimgclose').css('display','none'); 
        if (document.getElementById("Groupsnippet_main")) {
            document.getElementById('Groupsnippet_main').style.display = 'none';
            $("#Groupsnippet_main").html("");
        }
        if (groupPostInterval != 0) {
            clearInterval(groupPostInterval);
        }
        setTimeout(function() { // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
            var Id = 0;
            var type = "Group";
            if (data.subgroupId == 0) {
                Id = data.groupId;
            } else {
                type = "SubGroup";
                Id = data.subgroupId;
            }
            if (typeof socketGroup !== "undefined") {
                isThereReady = true;
                socketGroup.emit('getLatestGroupPostRequest', loginUserId, Id, userTypeId, type, postAsNetwork, sessionStorage.old_key);
            }
//                var subGroupId = data.subgroupId;
//                socketSubGroup.emit('getLatestGroupPostRequest', loginUserId,subGroupId,userTypeId);
        }, 1000);

        // window.location="/post/index";

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
        if (typeof (data.msgerr) == 'string') {
            var error = eval("(" + data.msgerr.toString() + ")");
        } else {
            var error = eval(data.msgerr);
        }
        $.each(error, function(key, val) {
            if ($("#" + key + "_em_")) {
                displayErrorMessage(key, val);
            }
        });
//        var msgr = data.msgerr;
//        alert(msgr.toSource());
    }
    globalspace['weburls'] = "";
    globalspace['IsWebSnippetExistForPost'] = 0;
}

function ClearGroupPostForm() {
    globalspace['at_mention_koluser'] = new  Array();
    $("#GroupPostForm_Miscellaneous").val(0);
    $("#koluserdiv").hide();
    $("#kolcheckboxd span.checkbox").attr("style","background-position: 0px 0px;"); 
    $("#editable").html(" ");
    $("#groupPost-form")[0].reset();
    if (GroupconversationUploadedFiles.length > 0) {
        GroupconversationUploadedFiles.length = 0;
    }
    if (GroupuploadedArtifacts.length > 0) {
        GroupuploadedArtifacts.length = 0;
    }
    $('#e_survey').hide();
    $('#editable').show();
    $('#surveydiv').hide();
    $("#editable").css("min-height", "");
    $('#editable').addClass("placeholder");
    $("#editable").attr("placeholder", Translate_New_Post);
    $('#survey_header').hide();
    $('#eventdiv').hide();
    $('#event_header').hide();
    $("#surveypostdiv").removeClass("surveypostdiv");
    $('#GroupPostForm_Artifacts').val('');
    $('#preview').hide();
    $('#previewul').hide();
    $('#previewul').html('');
    $("#postType li").removeClass('selectpostactive');
    globalspace['hashtag_editable'] = new Array();
    globalspace['at_mention_editable'] = new Array();
    if (document.getElementById("Groupsnippet_main")) {
        document.getElementById('Groupsnippet_main').style.display = 'none';
        $("#Groupsnippet_main").html("");
        $('#GroupPostForm_Type').val('');
    }
    $("#button_block").hide();
    globalspace['weburls'] = "";
    globalspace['IsWebSnippetExistForPost'] = 0;
    $('#surveyeventtitledescription').hide();
}

function initializationForGroupCalender() {
    $('#editable').on("click", function(event) {

        $(this).removeClass("placeholder");
    });

    $('.placeholder').on('input', function() {
        if ($(this).text().length > 0) {
            $(this).removeClass('placeholder');
        } else {
            $(this).addClass('placeholder');
        }
    });

    $('#editable').focus(function() {
        $('#GroupPostForm_Description_em_').fadeOut(2000);
        $('#GroupPostForm_Artifacts_em_').fadeOut(2000);
    });

    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    var surveycheckin = $('#dp3').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {


        $('.datepicker').hide();

    })

    var checkin = $('#dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if ((ev.date.valueOf() > checkout.date.valueOf()) || checkout.date.valueOf() != "") {
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


    $("#postType li").click(function() {
        $("#postType li").removeClass('selectpostactive');
        $(".open").each(function() {
            $(this).removeClass('open');
        });
        // $("#postType li").css('background','none');    
        // $(this).css("color","#ffffff");  
        $(this).addClass('selectpostactive');
    });
    $(".sidebar-nav ul li ").removeClass('active');
    $("#grouppost").addClass('active');
    $('.starttime').timepicker();
    $('.endtime').timepicker();
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
}
function cancelBannerOrIconUpload(oldImage, type) {

    if (type == 'GroupBannerImage') {
        $('#GroupBannerPreview').val(oldImage);
        $('#GroupBannerPreview').attr('src', oldImage);
        $('#updateAndCancelBannerUploadButtons').hide();
    }
    if (type == 'GroupProfileImage') {
        $('#groupIconPreviewId').val(oldImage);
        $('#groupIconPreviewId').attr('src', oldImage);
        $('#updateAndCancelGroupIconUploadButtons').hide();
        if ($('#groupIconPreviewIdInPreferences').length > 0) {
            $('#groupIconPreviewIdInPreferences').attr('src', oldImage);
            $('#updateAndCancelGroupIconUploadButtonsInPreferences').hide();
        }

    }
    g_groupPicture = '';

}
function editGroupDescription() {
    $('#editGroupDescriptionText').text($('#groupDescriptionTotal').text());
    $("#editGroupDescription").show();
    $("#updateGroupDescription").show();
    $("#closeEditGroupDescription").show();
    $("#editGroupDescriptionText").show();
    $("#groupDescription").hide();
    $("#groupDescriptionTotal").hide();
    $("#editButton").hide();
    $("#profile div a.more").hide();
    $("#profile div a.moreup").hide();
}
function editsSubGroupDescription() {
    $('#editGroupDescriptionText').text($('#groupDescriptionTotal').text());
    $("#editGroupDescription").show();
    $("#updateGroupDescription").show();
    $("#closeEditGroupDescription").show();
    $("#editGroupDescriptionText").show();
    $("#SubgroupDescription").hide();
    $("#SubgroupDescriptionTotal").hide();
    $("#editButton").hide();
    $("#profile div a.more").hide();
    $("#profile div a.moreup").hide();
}

function saveEditGroupDescription(groupId, type, category) {

    var groupDescription = $("#editGroupDescriptionText").html();

    var queryString = "groupDescription=" + groupDescription + "&groupId=" + groupId + "&type=" + type + "&category=" + category;
    ajaxRequest("/group/editGroupDetails", queryString, saveEditGroupDescriptionHandler)
}
function saveEditGroupDescriptionHandler(data) {
    if (data.status == 'success') {
        $("#editGroupDescription").hide();
        var description = $("#editGroupDescriptionText").html();
        $("#groupDescriptionTotal").html(description);
        if ($("#groupDescriptionTotalInPreferences").length > 0) {
            $("#groupDescriptionTotalInPreferences").html(description);
        }
        if (description.length > 240) {
            var des = $("#editGroupDescriptionText").text().substring(0, 240)
            $("#descriptioToshow").html(des);
            if ($("#descriptioToshowInPreferences").length > 0) {
                $("#descriptioToshowInPreferences").html(description);
            }
            $("#g_descriptionMore").show();
        } else {
            $("#descriptioToshow").html(description);
            if ($("#descriptioToshowInPreferences").length > 0) {
                $("#descriptioToshowInPreferences").html(description);
            }
            $("#g_descriptionMore").hide();
        }

        $("#descriptioToshow").show()
        $("#groupDescription").show();
        $("#groupDescriptionTotal").hide();
        $("#editButton").show();
        $("#profile div a.more").show();
        $("#updateGroupDescription").hide();
        $("#closeEditGroupDescription").hide();
        $("#profile div a.moreup").hide();
        $("#descriptioToshow").show();
    }


}

function closeEditGroupDescription() {
    $("#editGroupDescription").hide();
    $("#updateGroupDescription").hide();
    $("#closeEditGroupDescription").hide();
    $("#editGroupDescriptionText").hide();
    $("#groupDescriptionTotal").hide();
    $("#editButton").show();
    $("#profile div a.more").show();
    $("#groupDescription").show();
    $("#descriptioToshow").show();


}

function saveGroupBannerAndIcon(groupId, type, category) {
    var queryString = '';
    if (type == 'GroupBannerImage') {
        queryString = "bannerImage=" + g_groupPicture + "&groupId=" + groupId + "&type=" + type + "&category=" + category;
    } else {
        queryString = "bannerImage=" + g_groupIcon + "&groupId=" + groupId + "&type=" + type + "&category=" + category;
    }

    ajaxRequest("/group/editGroupDetails", queryString, saveGroupIconnHandler);

}
function saveGroupIconnHandler(responseJSON) {
    var data = eval(responseJSON);
    if (data.type == 'GroupBannerImage') {
        $('#updateAndCancelBannerUploadButtons').hide();
        g_groupPicture = '';
    } else {
        if (globalspace.preferences == "InPreferences") {
            globalspace.preferences = "";
            $('#updateAndCancelGroupIconUploadButtonsInPreferences').hide();
            $('#groupIconPreviewId').attr('src', $('#groupIconPreviewIdInPreferences').attr('src'));
        } else {
            $('#updateAndCancelGroupIconUploadButtons').hide();
            $('#groupIconPreviewIdInPreferences').attr('src', $('#groupIconPreviewId').attr('src'));
        }
        $('#cancelGroupIcon').attr('onclick', "cancelBannerOrIconUpload('" + $('#groupIconPreviewId').attr('src') + "','GroupProfileImage')");
        $('#cancelGroupIconInPreferences').attr('onclick', "cancelBannerOrIconUpload('" + $('#groupIconPreviewId').attr('src') + "','GroupProfileImage')");
        g_groupIcon = ''
    }



}

function GroupDBPreviewImage(id, fileName, responseJSON, type)
{
    var data = eval(responseJSON);
    g_groupPicture = '/upload/group/profile/' + data.savedfilename;
    $('#updateAndCancelBannerUploadButtons').show();
    $('#GroupBannerPreview').val('/upload/group/profile/' + data.savedfilename);
    $('#GroupBannerPreview').attr('src', g_groupPicture);

}
function GroupDLPreviewImage(id, fileName, responseJSON, type)
{
    var data = eval(responseJSON);
    g_groupIcon = '/upload/group/profile/' + data.savedfilename;
    var preferences = '';
    if (type == 'GroupLogoInPreferences') {
        preferences = 'InPreferences';
    }
    $('#updateAndCancelGroupIconUploadButtons' + preferences).show();
    $('#groupIconPreviewId' + preferences).val('/upload/group/profile/' + data.savedfilename);
    $('#groupIconPreviewId' + preferences).attr('src', g_groupIcon);

}

var vWidth, vOffsetArtifact, dataResource;


function bindClickForArtifact()
{
    $(".f_media_picture.artifacts").live('click', function() {
        $(".player").html("");
        var offsetArtifact = $(this).offset().left;
        var width = $(this).width();
        var postId = $(this).data("id");
        var format = $(this).data("format");
        if (postId == undefined && (format == "jpg" || format == "jpeg" || format == "png" || format == "png" || format == "giff")) {
            $("#myModal_old").modal('show');
        } else {
            var resource = $(this).data("resource");      
            resource = resource.replace("thumbnails","images");
            dataResource = resource;
            var offset = $(this).data("offset");
            vWidth = width;
            vOffsetArtifact = offsetArtifact;

            getArtifactDetailForGroup(postId, resource, offset, offsetArtifact, width, format);
        }

    });

}

function getArtifactDetailForGroup(postId, resource, offset, offsetArtifact, width, format) {
    // scrollPleaseWait('stream_view_spinner_'+postId);
    $(".poststreamwidget").hide();
    ajaxRequest("/group/GetArtifactDetail", {postId: postId, resource: resource}, function(data) {
        getArtifactDetailForGroupHandler(data, offset, offsetArtifact, width, postId, resource, format)
    }, "html");

}
function getArtifactDetailForGroupHandler(response, offset, offsetArtifact, width, postId, uri, format) {
    scrollPleaseWaitClose('stream_view_spinner_' + postId);
    if (format == "jpg" || format == "jpeg" || format == "png" || format == "png" || format == "giff") {
        $("#playerad_wrapper").removeAttr("style").hide();
        $("#showoriginalpicture").attr("src", uri).show();
        $("#myModal_old").modal('show');
    } else if (format == "doc" || format == "docx" || format == "pdf" || format == "xls" || format == "ppt") {
        $('#showoriginalpicture').hide();
        $("#showoriginalpicture").removeAttr("src");
        loadDocumentViewer('player', uri, '', '', 400, 500);
        $("#myModal_old").modal('show');

    }
    $('.g_mediapopup').remove();
    $('.artifactsshow' + offset).append(response);

    /** this is only for  rite aid */
    // var r=offsetArtifact - ((width/2)-30);

    /** this is for Skipta     */
    var r ; 
    if(screen.width > 1500)
        r = offsetArtifact - (width + 300);
    else
        r = offsetArtifact - (width + 40);
    
    $(".arrowdiv").css("left", r);
    if (!detectDevices()) {
        $("[rel=tooltip]").tooltip();
    }
}
function loadGroupConversations(groupId, type) {
    $('#createSubGroup').hide();
    Global_ScrollHeight = $('#groupstreamMainDiv').offset().top;
    $("html,body").scrollTop(Global_ScrollHeight);
//    $("#groupstreamMainDiv").empty();
    page = 1;
    isDuringAjax = false;
    $(window).unbind("scroll");
    if (type == 'SubGroup') {
        getCollectionData('/group/groupStream', 'groupId=' + groupId + '&category=SubGroup&StreamPostDisplayBean', 'groupstreamMainDiv', Translate_NoPostsFound,Translate_Thas_all_folks); 
    } else {
        $('#createSubGroup').hide();
        getCollectionData('/group/groupStream', 'groupId=' + groupId + '&category=Group&StreamPostDisplayBean', 'groupstreamMainDiv', Translate_NoPostsFound,Translate_Thas_all_folks);
    }
    
    $(".poststreamwidget,#groupstreamMainDiv").show();
    $('#UPF').hide();
}
/**
 * karteek .v
 * this is function is used to clear all interval which are not related to group stream...
 */
function ClearNodeIntervals() {
    clearInterval(postSocialStatsInterval);
    clearInterval(curbSocialStatsInterval);
    clearInterval(intervalIdNewpost);
    clearInterval(intervalIdCurbpost);
}
function resizeArtifactPointer() {
    vOffsetArtifact = $("[data-resource='" + dataResource + "']").offset().left;
    vWidth = $("[data-resource='" + dataResource + "']").width();
    var r = vOffsetArtifact - ((vWidth / 2) - 50);
    // var r=offsetArtifact - (width+40);
    $(".arrowdiv").css("left", r);
}

function getSubGroups(groupId) {
    $('#createSubGroup').show();
    scrollPleaseWait("groupfollowSpinLoader");
    Global_ScrollHeight = $('#UPF').offset().top;
    $("html,body").scrollTop(Global_ScrollHeight);
    $("#UPF").html('');
    $(".poststreamwidget,#groupstreamMainDiv,#groupPostDetailedDiv").hide();
    $("#UPF").show();
    $(".poststreamwidget").hide();
    page = 1;
    isDuringAjax = false;
    $(window).unbind("scroll");

    //  getCollectionData('/group/GetSubGroups', 'groupId='+groupId+'&ResourceCollection', 'UPF', 'No data found','No More Data');
    ajaxRequest("/group/GetSubGroups", {groupId: groupId}, function(data) {
        getSubGroupsHandler(data)
    }, "html");
}

function getSubGroupsHandler(data) {
    scrollPleaseWaitClose("groupfollowSpinLoader");
    $('#UPF').html(data);


}
/**
 * @author Vamsi 
 * @param {type} groupId
 * @param {type} userId
 * @param {type} actionType
 * @returns {object} json 
 */

function followOrUnfollowSubGroup(groupId, actionType, obj, countObj, subGroupId) {
    g_groupId = groupId;
    scrollPleaseWait("groupfollowSpinLoader");
    var queryString = "groupId=" + groupId + "&actionType=" + actionType + "&subGroupId=" + subGroupId;

    ajaxRequest("/group/UserFollowSubGroup", queryString, function(data) {
        followOrUnfollowGroupHandler(data, actionType, obj, countObj)
    });
}
function bindSubGroupsFollowUnFollow(pageId) {
    $("#followGroupInDetail img.followbig").live("click",
            function() {
                var groupId = $(this).closest('span.noborder').attr('data-groupid');
                var subgroupId = $(this).closest('span.noborder').attr('data-subgroupid');
                followOrUnfollowSubGroup(groupId, "UnFollow", '', '', subgroupId);
                $("#GroupFollowers").removeAttr("onclick");
                $("#GroupImages").removeAttr("onclick");
                $("#GroupDocs").removeAttr("onclick");
                $('#conversations').removeAttr("onclick");
                $("#groupFormDiv").hide();
                $("#groupstreamMainDiv").hide();
                $('#groupFollowersCount').html(Number($('#groupFollowersCount').text()) - 1)
                $("#UPF").html('');
                $("#UPF").hide('');
                $(this).attr('data-original-title', Translate_Follow);
                $(this).attr({
                    "class": "unfollowbig"
                });
            }
    );
    $("#followGroupInDetail img.unfollowbig").live("click",
            function() {
                var groupId = $(this).closest('span.noborder').attr('data-groupid');
                var subgroupId = $(this).closest('span.noborder').attr('data-subgroupid');
                var category = $(this).closest('span.noborder').attr('data-category');
                followOrUnfollowSubGroup(groupId, "Follow", '', '', subgroupId);
                $("#GroupFollowers").attr("onclick", "getUserFollowers('" + groupId + "');");
                $("#GroupImages").attr("onclick", "getGroupImagesAndVideos('" + groupId + "');");
                $("#GroupDocs").attr("onclick", "getGetGroupDocs('" + groupId + "');");
                $("#conversations").attr("onclick", "loadGroupConversations('" + subgroupId + "','" + category + "');");
                $("#groupFormDiv").show();
                $("#groupstreamMainDiv").show();
                $('#groupFollowersCount').html(Number($('#groupFollowersCount').text()) + 1)
                $("#UPF").show('');
                $(this).attr('data-original-title', Translate_Unfollow);
                $(this).attr({
                    "class": "followbig"
                });
            }
    );
}

function displayErrorForBannerAndLogo(message, type) {
    if (type == 'GroupLogo') {
        $('#GroupLogoError').html(message);
        $('#GroupLogoError').css("padding-top:20px;");
        $('#GroupLogoError').show();
        $('#GroupLogoError').fadeOut(6000)
    } else if (type == 'GroupLogoInPreferences') {
        $('#GroupLogoErrorInPreferences').html(message);
        $('#GroupLogoErrorInPreferences').css("padding-top:20px;");
        $('#GroupLogoErrorInPreferences').show();
        $('#GroupLogoErrorInPreferences').fadeOut(6000)
    } else {
        $('#GroupBannerError').html(message);
        $('#GroupLogoError').css("padding-top:20px;");
        $('#GroupBannerError').show();
        $('#GroupBannerError').fadeOut(6000)
    }
}

/*******************************Start***********************************
 @author Sagar Pathapelli
 Methods for updating the group description in Group Preferences
 /**********************************************************************/
function saveEditGroupDescriptionInPreferences(groupId, type, category) {

    var groupDescription = $("#editGroupDescriptionTextInPreferences").text();

    var queryString = "groupDescription=" + groupDescription + "&groupId=" + groupId + "&type=" + type + "&category=" + category;
    ajaxRequest("/group/editGroupDetails", queryString, saveEditGroupDescriptionInPreferencesHandler)
}
function saveEditGroupDescriptionInPreferencesHandler(data) {
    if (data.status == 'success') {
        $("#editGroupDescriptionInPreferences").hide();
        var description = $("#editGroupDescriptionTextInPreferences").html();
        $("#groupDescriptionTotalInPreferences").html(description);
        if ($('#editGroupDescriptionText').length > 0) {
            $('#editGroupDescriptionText').html(description);
        }
        if ($("#groupDescriptionTotal").length > 0) {
            $("#groupDescriptionTotal").html(description);
        }
        if (description.length > 240) {
            var des = $("#editGroupDescriptionTextInPreferences").text().substring(0, 240)
            $("#descriptioToshowInPreferences").html(des);
            if ($("#descriptioToshow").length > 0) {
                $("#descriptioToshow").html(des);
            }
            $("#g_descriptionMore").show();
        } else {
            $("#descriptioToshowInPreferences").html(description);
            if ($("#descriptioToshow").length > 0) {
                $("#descriptioToshow").html(description);
            }
            $("#g_descriptionMore").hide();
        }

        closeEditGroupDescriptionInPreferences();
    }
}
function closeEditGroupDescriptionInPreferences() {
    $("#editGroupDescriptionInPreferences").hide();
    $("#updateGroupDescriptionInPreferences").hide();
    $("#closeEditGroupDescriptionInPreferences").hide();
    $("#editGroupDescriptionTextInPreferences").hide();
    $("#groupDescriptionTotalInPreferences").hide();
    $("#editButtonInPreferences").show();
    $("#profileInPreferences div a.more").show();
    $("#groupDescriptionInPreferences").show();
    $("#descriptioToshowInPreferences").show();
}
function editGroupDescriptionInPreferences() {
    $('#editGroupDescriptionTextInPreferences').text($('#groupDescriptionTotalInPreferences').text());
    $("#editGroupDescriptionInPreferences").show();
    $("#updateGroupDescriptionInPreferences").show();
    $("#closeEditGroupDescriptionInPreferences").show();
    $("#editGroupDescriptionTextInPreferences").show();
    $("#groupDescriptionInPreferences").hide();
    $("#groupDescriptionTotalInPreferences").hide();
    $("#editButtonInPreferences").hide();
    $("#profileInPreferences div a.more").hide();
    $("#profileInPreferences div a.moreup").hide();
}
/*******************************End***********************************
 Methods for updating the group description in Group Preferences
 /**********************************************************************/

/*******************************Start***********************************
 @author Sagar Pathapelli
 Methods for Changing the Group mode
 /**********************************************************************/
function changeModeCallback(obj) {
    var queryString = obj;
    ajaxRequest("/group/editGroupDetails", queryString, function(data) {
        changeModeHandler(data, obj);
    })
}
function changeModeHandler(data, obj) {
    closeModelBox();
    if (data.status == 'success') {
        window.location.reload();

    }
}
function changeModeIFrameCallback(obj) {
    closeModelBox();
    var IframeUrlForPopup = '<div id="IFrameURLDivForPopup" class="row-fluid  ">' +
            '<div class="span12">' +
            '<label for="GroupCreationForm_Url">Url</label>' +
            '<input type="text" id="Popup_IFrameURL" class="span12 textfield" maxlength="100" placeholder="Url" onkeyup="getsnipetIframe(this.id)">' +
            '<div class="control-group controlerror">' +
            '<div style="display: none;" id="Popup_IFrameURL_em_" class="errorMessage"></div>' +
            '</div>' +
            '<div  id="snippet_main" style="display:none; padding-top: 10px;padding-bottom:10px;" ></div>' +
            '</div>' +
            '</div> ';
    $("#myModal_body").html(IframeUrlForPopup);
    $("#myModalLabel").addClass("stream_title paddingt5lr10");
    $("#myModalLabel").html("IFrame URL");
    $("#myModal").modal('show');
    var existingUrl = $.trim($('#IFrameUrlToshowInPreferences').text());
    if (existingUrl.length <= 0) {
        $("#myModal_saveButton").val('Save');
    } else {
        $('#Popup_IFrameURL').val(existingUrl);
        getsnipetIframe("Popup_IFrameURL");
    }
    $("#myModal_saveButton").bind('click', function() {
        var url = $.trim($('#Popup_IFrameURL').val());
        var errorMessageObj = $('#Popup_IFrameURL_em_');
        if (validateUrl(url, errorMessageObj)) {
            var queryString = "IFrameURL=" + url + "&groupId=" + obj.groupId + "&type=IFrameURL&category=" + obj.category;
            ajaxRequest("/group/editGroupDetails", queryString, function() {
                changeModeCallback(obj);
            });
        }
    });
}
function validateUrl(url, errorMessageObj) {
    var pattern = /(https|http):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

    if (url.length <= 0) {
        $(errorMessageObj).text('Url can not be empty.').show().fadeOut(3000);
        return false;
    } else if (!(pattern.test(url))) {
        $(errorMessageObj).text('URL should start with https://.').show().fadeOut(3000);
        return false;
    }
    return true;
}

function setGroupMode(id) {
    if (id == 'GroupCreationForm_IFrameMode') {
        $('#GroupCreationForm_IFrameMode').removeAttr('checked');
        $('#GroupCreationForm_IFrameMode_radio>span.radio').css('background-position', '0px 0px');
        $('#GroupCreationForm_NormalMode').attr('checked', 'checked');
        $('#GroupCreationForm_NormalMode_radio>span.radio').css('background-position', '0px -50px');
    } else {
        $('#GroupCreationForm_NormalMode').removeAttr('checked');
        $('#GroupCreationForm_NormalMode_radio>span.radio').css('background-position', '0px 0px');
        $('#GroupCreationForm_IFrameMode').attr('checked', 'checked');
        $('#GroupCreationForm_IFrameMode_radio>span.radio').css('background-position', '0px -50px');
    }
}
/*******************************End***********************************
 Methods for Changing the Group mode
 /**********************************************************************/

/*******************************Start***********************************
 @author Sagar Pathapelli
 Methods for Updating the IFrame Url In Group Preferences
 /**********************************************************************/

function editIFrameUrlInPreferences() {
    $("#editIFrameUrlInPreferences").show();
    $("#updateIFrameUrlInPreferences").show();
    $("#closeEditIFrameUrlInPreferences").show();
    $("#editIFrameUrlTextInPreferences").show();
    $("#IFrameUrlInPreferences").hide();
    $("#editButtonInPreferences").hide();
    $("#profileIFrameUrlInPreferences div a.more").hide();
    $("#profileIFrameUrlInPreferences div a.moreup").hide();
}
function saveEditIFrameUrlInPreferences(groupId, type, category) {
    var IFrameUrl = $.trim($('#editIFrameUrlTextInPreferences').text());
    var errorMessageObj = $('#IFrameUrlErrorInPreferences');
    if (validateUrl(IFrameUrl, errorMessageObj)) {
        var queryString = "IFrameURL=" + IFrameUrl + "&groupId=" + groupId + "&type=" + type + "&category=" + category;
        ajaxRequest("/group/editGroupDetails", queryString, saveEditIFrameURLInPreferencesHandler)
    }
}
function saveEditIFrameURLInPreferencesHandler(data) {
    if (data.status == 'success') {
        $("#editIFrameUrlInPreferences").hide();
        var description = $("#editIFrameUrlTextInPreferences").text();
        if (description.length > 240) {
            var des = $("#editIFrameUrlTextInPreferences").text().substring(0, 240)
            $("#IFrameUrlToshowInPreferences").html(des);
        } else {
            $("#IFrameUrlToshowInPreferences").html(description);
        }

        closeEditIFrameUrlInPreferences();
    }
}
function closeEditIFrameUrlInPreferences() {
    $("#editIFrameUrlTextInPreferences").text($("#IFrameUrlToshowInPreferences").text());
    $("#editIFrameUrlInPreferences").hide();
    $("#updateIFrameUrlInPreferences").hide();
    $("#closeEditIFrameUrlInPreferences").hide();
    $("#editIFrameUrlTextInPreferences").hide();
    $("#editButtonInPreferences").show();
    $("#profileIFrameUrlInPreferences div a.more").show();
    $("#IFrameUrlInPreferences").show();
    $("#IFrameUrlToshowInPreferences").show();
}

/*******************************End***********************************
 Methods for Updating the IFrame Url In Group Preferences
 /**********************************************************************/


/**
 * @author Sagar Pathapelli
 * This method is called while loading the group page for admin
 * @usage All initializations is available here
 * @returns 
 */
var gGroupId=null;
var gIframeMode=null;
function groupPreferencesInitializations(groupId) {
    gGroupId=groupId;
    var extensionspref = '"jpg","jpeg","gif","png","tiff","tif","TIF"';
    initializeFileUploader('GroupLogoInPreferences', '/group/UploadBanner', '10*1024*1024', extensionspref, 1, 'GroupLogoInPreferences', '', GroupDLPreviewImage, displayErrorForBannerAndLogo, "uploadlist_logoPreferences");


    Custom.init();
    $('#groupModeChangeButtons span.radio').bind("click",
            function() {
                var radioObj = $(this);
                var modeId = $(radioObj).next().attr('id');
                
//                if (modeId == 'GroupCreationForm_IFrameMode' && globalspace.groupMode == 1) {
//                    return;
//                }
//                if (modeId == 'GroupCreationForm_NormalMode' && globalspace.groupMode == 0) {
//                    return;
//                }
                
                if(modeId === 'GroupCreationForm_IFrameMode'){
                    gIframeMode=1;
                    $("#IFrameURLDiv").show();
                    $("#snippet_main").show();
                }
                if(modeId === 'GroupCreationForm_NormalMode'){
                    gIframeMode=0;
                    $("#IFrameURLDiv").hide();
                    $("#snippet_main").hide();
                }
                    

//                var mode = $(this).next().val();
//                var modelType = 'error_modal';
//                var title = 'Change Mode';
//                var content = "Are you sure you want to change group mode?";
//                var closeButtonText = 'No';
//                var okButtonText = 'Yes';
//                var okCallback = changeModeCallback;
//                if (modeId == 'GroupCreationForm_IFrameMode') {
//                    okCallback = changeModeIFrameCallback;
//                }
//                var param = {type: 'IsIFrameMode', IFrameMode: mode, groupId: groupId, category: "Group"};
//                openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
//                $("#newModal_btn_close").unbind('click');
//                $("#newModal_btn_close").bind('click', function() {
//                    var id = $(radioObj).next().attr('id');
//                    setGroupMode(id);
//                });
            }
    );
    $("#editGroupDescriptionTextInPreferences").bind('paste', function(event) {
        var self = $(this);
        var orig = self.html();//existing text in textarea
        setTimeout(function() {
            var selfhtml = $(self).html();//existing text with copied text in textarea
            var pasted = text_diff(orig, selfhtml);//this will return clipboard data
            var replaceText = $(pasted).text();//get only text from clipboard data
            if ($.trim(replaceText) == "") {//if clipboard data is plain text 
                replaceText = pasted;
            }
            var text = selfhtml.replace(pasted, replaceText);//replace clipboard html with clipboard text
            self.html('');
            self.html(text);
            var result = $("#editGroupDescriptionTextInPreferences");
            result.focus();
            placeCaretAtEnd(document.getElementById("editGroupDescriptionTextInPreferences"));
        });
    });
    $("#editGroupDescriptionText").bind('paste', function(event) {
        var self = $(this);
        var orig = self.html();//existing text in textarea
        setTimeout(function() {
            var selfhtml = $(self).html();//existing text with copied text in textarea
            var pasted = text_diff(orig, selfhtml);//this will return clipboard data
            var replaceText = $(pasted).text();//get only text from clipboard data
            if ($.trim(replaceText) == "") {//if clipboard data is plain text 
                replaceText = pasted;
            }
            var text = selfhtml.replace(pasted, replaceText);//replace clipboard html with clipboard text
            self.html('');
            self.html(text);
            var result = $("#editGroupDescriptionText");
            result.focus();
            placeCaretAtEnd(document.getElementById("editGroupDescriptionText"));
        });
    });


//    $('#AutoModeDiv span.checkbox').bind("click",
//            function() {
//                var isChecked = 0;
//                if ($('#GroupCreationForm_AutoFollow').is(':checked')) {
//                    isChecked = 1;
//                }
//                changeGroupAsAutoFollow(groupId, isChecked);
//            }
//
//    );

//    $('#groupConversations span.checkbox').bind("click",
//            function() {
//                var isChecked = 0;
//                if ($('#GroupCreationForm_ConversationVisibility').is(':checked')) {
//                    isChecked = 1;
//                }
//                changeGroupConversationsSettings(groupId, isChecked);
//            }
//
//    );

             
//    $('#AddSocialActions span.checkbox').bind("click",
//     function(){
//         var isChecked=0;
//         if($('#GroupCreationForm_AddSocialActions').is(':checked')){
//             isChecked=1;
//         }
//        changeAddSocialActions(groupId,isChecked);
//     });
    $('#DisableWebPreview span.checkbox').bind("click",
     function(){
         var isChecked=0;
         if($('#GroupCreationForm_DisableWebPreview').is(':checked')){
             isChecked=1;
             $('#GroupCreationForm_DisableWebPreview').val(1);
         }else{
             $('#GroupCreationForm_DisableWebPreview').val(0);
         }
        
     }); 
  $('#groupInactive span.checkbox').bind("click",
     function(){         
         if($('#GroupCreationForm_Status').is(':checked')){         
             $('#GroupCreationForm_Status').val(1);
         }else{
             $('#GroupCreationForm_Status').val(0);
         }
        
     });

}
/**
 * Vamsi Krishna
 * This function to get Post Widget
 */
function loadPostWidget(groupId) {
    $("#myModal_body").load("/group/getGroupPostWidget", {groupId: groupId}, getPostWidgetHandler);
    $("#myModalLabel").addClass("stream_title paddingt5lr10");
    $("#myModalLabel").html("Post");
    $("#myModal_footer").hide();
    $("#myModal").modal('show');
    $("#myModal").removeAttr('tabindex');

}
function getPostWidgetHandler(data) {

}
function changeGroupAsAutoFollow(groupId, isChecked) {
    var queryString = "groupId=" + groupId + "&isChecked=" + isChecked;
    ajaxRequest("/group/AutoFollowGroup", queryString, function() {
        changeToAutoFollow(data);
    });
}
function checkPrivateAndAutoFollow() {    
    $('div#GroupCreationAutoPrivateMode span.checkbox').bind("click",
            function() {
                var obj = $(this).next();
                var id = $(obj).attr('id');
                if (id == 'GroupCreationForm_IsPrivate') {
//                    $('#GroupCreationForm_IsPrivate').prev().css('background-position', '0px -50px');
                    $('#GroupCreationForm_AutoFollow').prev().css('background-position', '0px 0px');
                    $('#GroupCreationForm_AutoFollow').removeAttr('checked');
                }
                if (id == 'GroupCreationForm_AutoFollow') {
//                    $('#GroupCreationForm_AutoFollow').prev().css('background-position', '0px -50px');
                    $('#GroupCreationForm_IsPrivate').prev().css('background-position', '0px 0px');
                    $('#GroupCreationForm_IsPrivate').removeAttr('checked');

                    //$('#GroupCreationForm_IsPrivate').removeAttr('checked');
                }
            }

    );
}

/**
 * @author Vamsi Krishna
 * This method is called while loading the sub group page for admin
 * @usage All initializations is available here
 * @returns 
 */
function subGroupPreferencesInitializations(subGroupId) {
    var extensionspref = '"jpg","jpeg","gif","png","tiff","tif","TIF"';
    initializeFileUploader('GroupLogoInPreferences', '/group/UploadBanner', '10*1024*1024', extensionspref, 1, 'GroupLogoInPreferences', '', GroupDLPreviewImage, displayErrorForBannerAndLogo, "uploadlist_logo");
   /* $('#ShowPostInMainStream div.span12').bind("click",
            function() {
                var isChecked = 0;
                if ($('#SubGroupCreationForm_ShowPostInMainStream').is(':checked')) {
                    isChecked = 1;
                }
                changeSubGroupShowInStream(subGroupId, isChecked);
            }

    );


    
    $('#AddSubGroupSocialActions div.span12').bind("click",
     function(){
         var isChecked=0;
         if($('#SubGroupCreationForm_AddSocialActions').is(':checked')){
             isChecked=1;
         }
        changeSubGroupAddSocialActions(subGroupId,isChecked);
     });
     
      $('#SubGroupDisableWebPreview div.span12').bind("click",
     function(){
         var isChecked=0;
         if($('#SubGroupCreationForm_DisableWebPreview').is(':checked')){
             isChecked=1;
         }
        changeSubGroupDisableWebPreview(subGroupId,isChecked);
     }); */


}
function changeSubGroupAddSocialActions(subGroupId, isChecked) {
    var queryString = "subGroupId=" + subGroupId + "&isChecked=" + isChecked;
    ajaxRequest("/group/ChangeSubGroupAddSocialActions", queryString, function() {
        changeSubGroupShowInStreamHandler();
    });
}
function changeSubGroupShowInStream(subGroupId, isChecked) {
    var queryString = "subGroupId=" + subGroupId + "&isChecked=" + isChecked;
    ajaxRequest("/group/changeSubGroupShowInStream", queryString, function() {
        changeSubGroupShowInStreamHandler();
    });
}
function changeSubGroupDisableWebPreview(subGroupId, isChecked) {
    var queryString = "subGroupId=" + subGroupId + "&isChecked=" + isChecked;
    
    ajaxRequest("/group/changeSubGroupDisableWebPreview", queryString, function() {
        if(isChecked==true){
            $('#editable').removeAttr("onkeyup"); 
        }
        else{
           $('#editable').attr("onkeyup",'getsnipetForGroup(event,this)');  
        }
        changeSubGroupShowInStreamHandler();
    });
}
function changeSubGroupShowInStreamHandler() {

}


/**
 * author: Praneeth
 * Method: To preview the web snippet for edit or creating an iFrame group
 * @param {type} id
 * @returns {web snippet}
 * 
 */
function getsnipetIframe(id) {
    var iFrametext = "";
    var urlPattern = "(((https?)\:\/\/)|(www\.))[A-Za-z0-9][A-Za-z0-9.-]+(:\d+)?(\/[^ ]*)?";
    if (id == 'editIFrameUrlTextInPreferences')
    {
        iFrametext = $("#" + id).text();
    }
    else {
        iFrametext = $("#" + id).val();
    }
    var results = iFrametext.match(new RegExp(urlPattern));

    if (results) {
        var Weburl = results[0].split("&nbsp");

        var queryString = {data: Weburl[0], Type: "post"};
        ajaxRequest("/post/SnippetpriviewPage", queryString, getIframesnipetHandler);
    }

}
/*
 * iFrame group WebSnippet preview handler.
 */
function getIframesnipetHandler(data) {
    //alert("------handler------"+data.toSource());
    if (data.status == 'success') {
        $('#snippet_main').show();
        var item = {
            'data': data
        };
        $("#snippet_main").html(
                $("#snippetDetailTmpl").render(item)
                );
        var sap = data.snippetdata;
        if (typeof globalspace['IsWebSnippetExistForPost'] == 'undefined' || globalspace['IsWebSnippetExistForPost'] == '0') {
            globalspace['IsWebSnippetExistForPost'] = 1;
        }
        if (typeof globalspace['weburls'] == 'undefined' || globalspace['weburls'] == '' || globalspace['weburls'] != '') {
            globalspace['weburls'] = data.snippetdata['Weburl'];
        }
    }

}
function changeGroupConversationsSettings(groupId, isChecked) {
    var queryString = "groupId=" + groupId + "&isChecked=" + isChecked;
    ajaxRequest("/group/updateGroupConversationsSettings", queryString,
            function(data) {
                ;
            });
}

function changeAddSocialActions(groupId, isChecked) {
    var queryString = "groupId=" + groupId + "&isChecked=" + isChecked;
    ajaxRequest("/group/AddSocialActions", queryString, function() {
    });
}
function changeDisableWebPreview(groupId, isChecked) {
    var queryString = "groupId=" + groupId + "&isChecked=" + isChecked;
    ajaxRequest("/group/DisableWebPreview", queryString, function() {
        if(isChecked==true){
            $('#editable').removeAttr("onkeyup"); 
        }
        else{
           $('#editable').attr("onkeyup",'getsnipetForGroup(event,this)');  
        }
    });
}
function saveGroupSettings(){
      
     scrollPleaseWait("groupfollowSpinLoader");
     $("#DescriptionHidden").val($("#editGroupDescriptionTextInPreferences").text());  
     $("#IFrameURLHidden").val($("#editIFrameUrlTextInPreferences").text());  
     if (typeof g_groupIcon !== 'undefined') {
       $("#GroupProfileImageHidden").val(g_groupIcon);    
     }


     var data = $("#groupcreation-form").serialize();
     ajaxRequest("/group/UpdateGroupSettings", data, saveGroupSettingsHandler);
 
}
function saveGroupSettingsHandler(data) {
    scrollPleaseWaitClose("groupfollowSpinLoader");
    if (data.status == "success") {
        var isChecked = $('#GroupCreationForm_DisableWebPreview').val();
            if(isChecked==1){
                $('#editable').removeAttr("onkeyup"); 
            }
            else{
               $('#editable').attr("onkeyup",'getsnipetForGroup(event,this)');  
            }
          if (typeof g_groupIcon !== 'undefined'&& g_groupIcon!=='') {
            $('#updateAndCancelGroupIconUploadButtonsInPreferences').hide();
            $('#groupIconPreviewId').attr('src', $('#groupIconPreviewIdInPreferences').attr('src'));
            $('#cancelGroupIcon').attr('onclick', "cancelBannerOrIconUpload('" + $('#groupIconPreviewId').attr('src') + "','GroupProfileImage')");
            $('#cancelGroupIconInPreferences').attr('onclick', "cancelBannerOrIconUpload('" + $('#groupIconPreviewId').attr('src') + "','GroupProfileImage')");
            g_groupIcon='';
        }
        if(gIframeMode!==null){
           var param = {type: 'IsIFrameMode', IFrameMode: gIframeMode, groupId: gGroupId, category: "Group"}; 
        changeModeCallback(param); 
        }
        
        var status =0;
        if($('#GroupCreationForm_Status').is(':checked')){         
            status=1;
         }       
        if(status==1){
            //Inactive group
            $('#groupstreamMainDiv').hide();
            $('#groupFormDiv').hide();
            $('#groupSideBar').hide();
              $("#GroupFollowers").removeAttr("onclick");
                $("#GroupImages").removeAttr("onclick");
                $("#GroupDocs").removeAttr("onclick");
                $('#conversations').removeAttr("onclick");
                
            
        }else{
            $('#groupstreamMainDiv').show();
            $('#groupFormDiv').show();
            $('#groupSideBar').show();
            $("#GroupFollowers").attr("onclick","getUserFollowers('"+gGroupId+"','Group');");
            $("#GroupImages").attr("onclick","getGroupImagesAndVideos('"+gGroupId+"','Group');");
             $("#GroupDocs").attr("onclick","getGetGroupDocs('"+gGroupId+"','Group');");
            $("#conversations").attr("onclick","loadGroupConversations('"+gGroupId+"','Group');");       
        }
        $("#streamSettingsMessage").show();
        $("#streamSettingsMessage").html("Preferences updated successfully").removeClass().addClass("alert alert-success").fadeOut(4000, "");
        
    }else{
      $("#GroupCreationForm_FileName").val("");
        $(".deletefilefromlist").each(function(key,v){
            var $this = $(this);
            if($this.data("id") == undefined || $this.data("id") == "undefined" || $this.data("id") == ""){                
                $this.closest("span.label").remove();
                $("#uploadedfileslist").hide();
                }
        })
         var error=eval("("+data.error.toString()+")"); 
       $.each(error, function(key, val){
        if($("#"+key+"_em_")){
            
                    $("#"+key+"_em_").text(val);                                                    
                    $("#"+key+"_em_").show();   
                    $("#"+key+"_em_").fadeOut(5000);
                }
     });
     if($.trim(data.data)!="")
        $("#streamSettingsMessage").html(data.data).removeClass().addClass("alert alert-error").show().fadeOut(7000);
    }
}
function saveSubGroupSettings(){
      
     scrollPleaseWait("groupfollowSpinLoader");
     $("#DescriptionHidden").val($("#editGroupDescriptionTextInPreferences").text());    
     if (typeof g_groupIcon !== 'undefined') {
       $("#GroupProfileImageHidden").val(g_groupIcon);    
     }
   

     var data = $("#subgroupcreation-form").serialize();
     ajaxRequest("/group/UpdateSubGroupSettings", data, saveSubGroupSettingsHandler);
 
}
function saveSubGroupSettingsHandler(data) {
    scrollPleaseWaitClose("groupfollowSpinLoader");
    if (data.status == "success") {
          if (typeof g_groupIcon !== 'undefined'&& g_groupIcon!=='') {
            $('#updateAndCancelGroupIconUploadButtonsInPreferences').hide();
            $('#groupIconPreviewId').attr('src', $('#groupIconPreviewIdInPreferences').attr('src'));
            $('#cancelGroupIcon').attr('onclick', "cancelBannerOrIconUpload('" + $('#groupIconPreviewId').attr('src') + "','GroupProfileImage')");
            $('#cancelGroupIconInPreferences').attr('onclick', "cancelBannerOrIconUpload('" + $('#groupIconPreviewId').attr('src') + "','GroupProfileImage')");
            g_groupIcon='';
        }
       
         var status = $('#GroupCreationForm_Status').val();
        var subGroupId=$("#SubGroupCreationForm_id").val();
        if(status==1){
            //Inactive group
            $('#groupstreamMainDiv').hide();
            $('#groupFormDiv').hide();
            $("#GroupFollowers").removeAttr("onclick");
            $("#GroupImages").removeAttr("onclick");
            $("#GroupDocs").removeAttr("onclick");
            $('#conversations').removeAttr("onclick");
            
        }else{
            $('#groupstreamMainDiv').show();
            $('#groupFormDiv').show();
            $("#GroupFollowers").attr("onclick","getUserFollowers('"+subGroupId+"','SubGroup');");
            $("#GroupImages").attr("onclick","getGroupImagesAndVideos('"+subGroupId+"','SubGroup');");
            $("#GroupDocs").attr("onclick","getGetGroupDocs('"+subGroupId+"','SubGroup');");
            $("#conversations").attr("onclick","loadGroupConversations('"+subGroupId+"','SubGroup');");       
        }
        $("#sucmsgForGroupCreation").show();
        $("#sucmsgForGroupCreation").html("Preferences updated successfully").removeClass().addClass("alert alert-success").fadeOut(4000, "");
        
    }else{
      var error=eval("("+data.error.toString()+")"); 
       $.each(error, function(key, val){
        if($("#"+key+"_em_")){
            
                    $("#"+key+"_em_").text(val);                                                    
                    $("#"+key+"_em_").show();   
                    $("#"+key+"_em_").fadeOut(5000);
                }
     }); 
//     $("#streamSettingsMessage").show();
//     $("#streamSettingsMessage").html("Preferences not updated").removeClass().addClass("alert alert-error").fadeOut(4000, "");
    }
}
$('#restrictedGroupdiv span.checkbox').live("click",
    function() {
        if ($('#GroupCreationForm_RestrictedAccess').is(':checked')) {
            $("#autofollowdiv").hide();
            $('#SubSpecialityList').hide();
        }else {
            $("#autofollowdiv").show();
             $('#SubSpecialityList').show();
        }                
    });
    
    $('#autofollowdiv span.checkbox').live("click",
            function() {                
                if ($('#GroupCreationForm_AutoFollow').is(':checked')) {
                    $('#restrictedGroupdiv').hide();
                    $('#SubSpecialityList').hide();
                    
                }else{
                    $('#restrictedGroupdiv').show();
                     $('#SubSpecialityList').show();
                }
                
            }
    );
    $('#isPrivate span.checkbox').live("click",
    function() {
        if ($('#GroupCreationForm_IsPrivate').is(':checked')) {
           $('#SubSpecialityList').hide();
        }else {
             $('#SubSpecialityList').show();
        }                
    });
    
    function initializationForAtMentionsForGroups(inputor,groupId){
     var inputorId = $(inputor).attr('id');     
    globalspace['hashtag_'+inputorId]=new Array();
    globalspace['at_mention_'+inputorId]=new Array();
    /*
    * at_mention_config is used to initialize the atmentions
    * @author Vamsi
    */
   
      var at_mention_config = {
           at: "@",
           callbacks: {
                 remote_filter: function (query, callback) {
                     if(typeof globalspace['at_mention_'+inputorId] == 'undefined'){
                        globalspace['at_mention_'+inputorId]=new Array();
                     }
        var data = {searchkey:query,existingUsers:JSON.stringify(globalspace['at_mention_'+inputorId]),groupId:groupId};
         ajaxRequest("/post/getGroupMembersForPrivateGroups",data,callback);
                  
                 },
                 before_insert: function(value, $li){                     
                     $("#koluser").val("");
                     $("#GroupPostForm_UserId").val($li.attr('data-user-id'));
                     if($li.attr('data-user-id') != "")
                        IsUserExist = 1;
                     globalspace['at_mention_'+inputorId].push(Number($li.attr('data-user-id')));
                    return value;
                 }
             },
           tpl:"<li data-value='@${DisplayName}' data-user-id=${UserId}><div class='d_name'>${DisplayName}</div> <i class='d_n_border'><img src='${profile45x45}'  /></i></li>",      
           insert_tpl: "@${DisplayName}",
           search_key: "DisplayName",
           show_the_at: true,
           limit: 50
       }
      
 
    $(inputor).atwho(at_mention_config);
}