// Initialize variables with default values...
var g_filterValue = "";
var g_pageNumber = 1;
var g_searchText = "";
var g_startLimit = 0;
var g_pageLength = 10;
var g_page = 1;
var g_catId = 0;
var g_groupPicture="";
var g_groupIcon="";
 var globalspace = new Object();
 var g_keepConversations=0;
 
 var g_startDate = "";
 var g_enddate = "";

function getUsermanagementDetails(startLimit, filterValue, searchText) {
    if (filterValue == "" || filterValue == undefined) {
        filterValue = "all";
    }
    filterValue=$.trim(filterValue);
    g_filterValue = filterValue; // assgining filtervalue to global variable...
    if (startLimit == 0) {
        g_pageNumber = 1;
    }
    if(searchText=='search'){
        searchText="";
    }
    var queryString = "filterValue=" + filterValue + "&searchText=" + searchText + "&startLimit=" + startLimit + "&pageLength=" + g_pageLength;
    ajaxRequest("/admin/getUserManagementDetails", queryString, getMgmntHandler);
}
// handler for getUserManagementDetails...
function getMgmntHandler(data) {
    scrollPleaseWaitClose('spinner_admin');
    var item = {
        'data': data
    };
    $("#usermanagement_div").html(
            $("#contactlistTmp_render").render(item)
            );
    if (g_pageNumber == undefined) {
        g_page = 1;
    } else {
        g_page = g_pageNumber;
    }
    if (g_filterValue != undefined) {
        $("#filter").val(g_filterValue);
    } else {
        g_filterValue = "all";
    }
     $("#select").text($("#filter option:selected").text());
    if (data.total.totalCount == 0) {
        $("#pagination").hide();
        $("#noRecordsTR").show();
    }
    $("#pagination").pagination({
        currentPage: g_page,
        items: data.total.totalCount,
        itemsOnPage: g_pageLength,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber, event) {
            g_pageNumber = pageNumber;
            var startLimit = ((parseInt(pageNumber) - 1) * parseInt(g_pageLength));
            getUsermanagementDetails(startLimit, g_filterValue, g_searchText);
        }

    });
     
    if($.trim(data.searchText) != undefined && $.trim(data.searchText) != "undefined" ){  
        
        $('#searchTextId').val(data.searchText);
    }
     
    Custom.init();
}

function searchAUser(event) {
    
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        scrollPleaseWait('spinner_admin');
        if ($.trim($("#searchTextId").val()) != "") {
            var searchText = $.trim($("#searchTextId").val());
            g_searchText = searchText;
            getUsermanagementDetails(0, '', g_searchText);            
        } else {
            g_searchText = "";
            getUsermanagementDetails(0);
        }
        return false;

    }
}

$("#filter").live( "change", 
        function(){
    var value = $("#filter").val();
    var searchText = $("#searchTextId").val();
    g_searchText = searchText;
    g_filterValue = value;
    scrollPleaseWait('spinner_admin');
    getUsermanagementDetails(0, value, searchText);
        }
    );

function viewAUserDetailsById(userid) {
    scrollPleaseWait('spinner_admin');
    var queryString = "userId=" + userid;
    ajaxRequest('/admin/viewAUserDetailsById', queryString, viewAUserDetailsByIdHandler);
}



function viewAUserDetailsByIdHandler(data) {
  
    $(".modal-dialog").width("500px");
    scrollPleaseWaitClose('spinner_admin');
    var item = {
        'data':data
    };
    $("#myModal_body").html(
            $("#userView_render").render(item)
            );
    $("#myModalLabel").html("Test Taker Details");
    $("#myModal_footer").hide();
    $("#myModal").modal('show');
}

function changeStatus(userId) {
    var divId = "",
            selectDivId = "";
    divId = "usrMgmnt_" + userId;
    selectDivId = "usrMgmnt_edit_" + userId;

    if ($("#" + divId + ":visible").length > 0) {
        $("#" + divId).hide();

        $("#" + selectDivId).show();

    } else {
        $("#" + divId).show();
        $("#" + selectDivId).hide();
    }

}

function changeStatusType(userid,value) {
    scrollPleaseWait('spinner_admin');
    $("#usrMgmnt_edit_" + userid).hide();  
    $("#filter").val($("#filter").val());    
    var queryString = "userid=" + userid + "&value=" + value+"&keepConversations=" + g_keepConversations;    
    ajaxRequest('/admin/updateUserManagementStatus', queryString, changeStatusTypeHandler);

}

function changeStatusTypeHandler(data){
    scrollPleaseWaitClose('spinner_admin');
    var startLimit = ((parseInt(g_pageNumber) - 1) * parseInt(g_pageLength));
    getUsermanagementDetails(startLimit, g_filterValue, g_searchText);
}
// user privileges ...
function userPrivileges(userid){
    scrollPleaseWait('spinner_admin');
    var queryString = "userid="+userid;
    g_userid = userid;
    ajaxRequest("/admin/getUserPrivileges",queryString,userPrivilegesHandler);
}

function userPrivilegesHandler(data){
    scrollPleaseWaitClose('spinner_admin');
    var item = {
        'data':data
    };
    $("#myModalLabel").html("Advanced Options");
    $("#myModal_body").html($("#usersettings_render").render(item));
    $("#myModal_saveButton").attr({
       "onclick":"saveButtonClick()" 
    });
    $("#myModal_saveButton").html("Save");
    $("#myModal_footer").show();
    $("#myModal_message").hide();
    $("#myModal").modal('show');
    
}
function saveButtonClick(){
    var actionIds = 0;
     $("input[name='actionItem']:checked").each( function () {
        if(actionIds == 0){            
            actionIds = $(this).val();
        }else{            
            actionIds = actionIds+","+$(this).val();
        }  
    });
     scrollPleaseWait("advanceOptionsSpinner","usermanagement_div");
    var queryString = "userid="+g_userid+"&actionIds="+actionIds;
    ajaxRequest("/admin/saveUserSettings",queryString,settingsHandler);
}

function settingsHandler(data){
    scrollPleaseWaitClose("advanceOptionsSpinner");
    if(data.status == "success"){
        $("#myModal_message").addClass("alert alert-success");
        $("#myModal_message").html("User privileges updated successfully.");
        $("#myModal_message").show();
        $("#myModal_message").fadeOut(3000,function(){
            $("#myModal").modal('hide');
        });        
    }else{
        $("#myModal_message").addClass("alert alert-error");
        $("#myModal_message").html("Please try again");
        $("#myModal_message").show();
        $("#myModal_message").fadeOut(3000,"");
    }
    
}

 function getCurbsideCategorymanagementDetails(startLimit, filterValue, searchText) {
    if (filterValue == "" || filterValue == undefined) {
        filterValue = "all";
    }
    g_filterValue = filterValue; // assgining filtervalue to global variable...
    if (startLimit == 0) {
        g_pageNumber = 1;
    }
    var queryString = "filterValue=" + filterValue + "&searchText=" + searchText + "&startLimit=" + startLimit + "&pageLength=" + g_pageLength;
    ajaxRequest("/admin/getCurbsideCategorymanagementDetails", queryString, getCurbsideCategorytHandler);
 }

/** Author:Praneeth
 *  Method:getCurbsideCategories
 *  @param: get the list of curbside categories 
 */

 function getCurbsideCategorytHandler(data) {
    scrollPleaseWaitClose('spinner_admin');
    var item = {
        'data': data
    };
    
   
    $("#curbsidecategorymanagement_div").html(
            $("#curbsideCategoriesTmp_render").render(item)
            );
    if (g_pageNumber == undefined) {
        g_page = 1;
    } else {
        g_page = g_pageNumber;
    }    
    if (g_filterValue != undefined) {
        $("#filterCurbsideCategory").val(g_filterValue);
    } else {
        g_filterValue = "all";
    }
    if (data.total.totalCount == 0) {
        $("#pagination").hide();
        $("#noRecordsTR").show();
    }
    
    $("#pagination").pagination({
        currentPage: g_page,
        items: data.total.totalCount,
        itemsOnPage: g_pageLength,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber, event) {
            g_pageNumber = pageNumber;
            var startLimit = ((parseInt(pageNumber) - 1) * parseInt(g_pageLength));
            getCurbsideCategorymanagementDetails(startLimit, g_filterValue, g_searchText);
        }

    });
    if($.trim(data.searchText) != undefined && $.trim(data.searchText) != "undefined" ){  
        
        $('#searchTextId').val(data.searchText);
    }
    Custom.init();
 }

/** Author:Praneeth
 *  Method:changeCurbsideCategoryStatus
 *  @param: for selecting the status i.e, active to delete for category based on categoryId 
 */
 function changeCurbsideCategoryStatus(categoryId) {
    var divId = "",
            selectDivId = "";
    divId = "curbsideCategory_" + categoryId;
    selectDivId = "curbsideCategory_edit_" + categoryId;

    if ($("#" + divId + ":visible").length > 0) {
        $("#" + divId).hide();

        $("#" + selectDivId).show();

    } else {
        $("#" + divId).show();
        $("#" + selectDivId).hide();
    }

 }

/** Author:Praneeth
 *  Method:changeCurbsideCategoryStatusType
 *  @param: to update the status i.e, active to delete for category based on categoryId 
 */
 function changeCurbsideCategoryStatusType(categoryid,value) {
 
        scrollPleaseWaitClose('spinner_admin');
        var modelType = 'error_modal';
        var content = "Are you sure you want to change status of this category?";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var title = 'Status change confirmation';
        var param='';
//        var value =$('#curbsideCategoryselect_' + categoryid).find(":selected").val();
        var okCallback = changeCurbsideCategory;
            param = ''+categoryid+','+value+'';
            
            openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
            $('#newModal_btn_close').unbind('click');
            $('#newModal_btn_close').bind('click', function(){
                
                closeModelBox();
                $('#newModal_btn_close').unbind('click');
            });
 }
 

/** Author:Praneeth
 *  Method:filterCurbsideCategoryByValue
 *  @param: to display the categories based the status filter value
 */
$("#filterCurbsideCategory").live( "change", 
        function(){
    var value = $("#filterCurbsideCategory").val();
    var searchText = $("#searchTextId").val();
    g_searchText = searchText;
    g_filterValue = value;
    scrollPleaseWait('spinner_admin');
    getCurbsideCategorymanagementDetails(0, value, searchText);
        }
    );

/** Author:Praneeth
 *  Method:searchCurbsideCategory
 *  @param: to display the categories based the search value
 */
 function searchCurbsideCategory(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        scrollPleaseWait('spinner_admin');
        if ($.trim($("#searchTextId").val()) != "") {
            var searchText = $("#searchTextId").val();
            g_searchText = searchText;
            getCurbsideCategorymanagementDetails(0, '', g_searchText);
        } else {
            g_searchText = "";
            getCurbsideCategorymanagementDetails(0);
        }
        return false;

    }
 }


/** Author:Praneeth
 *  Method:createNewCurbsideCategory
 *  @param: to category, will open the form in the popup
 */
 function createNewCurbsideCategory()
  {
    $('#NewCurbsideCategoryReset').click();
    $("#CurbsidecategorycreationForm_id").val("");
    $("#errmsgForCategory,#sucmsgForCategory").hide();    
    $('#addNewCurbsideCategory').modal('show');
    $('#NewCurbsideCategoryLabel').show();
    $('#UpdateCurbsideCategoryLabel').hide();
    $("#newCurbsideCategoryId").val('Create');
  }


/** Author:Praneeth
 *  Method:editCurbsideCategoryById
 *  @param: to edit already existing category based on the categoryId
 */
 function editCurbsideCategoryById(id) {
     $("#CurbsidecategorycreationForm_id").val("");
     $("#curbsideCategory_text_"+id).hide();
     $("#editButton_"+id).hide();
     $("#curbsideCategory_editText_"+id).show();
     $("#updateCategoryButton_"+id).show();
     
    var queryString = "Id="+id;
    g_catId = id;
    scrollPleaseWait('spinner_admin');
    ajaxRequest("/admin/editCurbsideCategory", queryString, editCurbsideCategoryIdHandler)
 }


/** Author:Praneeth
 *  Method:editCurbsideCategoryIdHandler
 *  @param: handler to edit already existing category based on the categoryId
 */
 function editCurbsideCategoryIdHandler(data) {
     scrollPleaseWaitClose('spinner_admin');
    var categoryList = data.data;    
    $("#curbsideCategory_inputText_"+g_catId).val(categoryList.CurbsideCategory);
    $("#CurbsidecategorycreationForm_id").val(categoryList.Id);
    $("#CurbsidecategorycreationForm_category").val(categoryList.CurbsideCategory);
    if(!detectDevices()){
      $("[rel=tooltip]").tooltip();
   }
 }
 function updateCurbsideCategoryTextById(id){
     $("#CurbsidecategorycreationForm_category").val($("#curbsideCategory_inputText_"+id).val());
     if( $.trim($("#curbsideCategory_inputText_"+id).val())!=""){
         $("#newCurbsideCategoryId").click();
     }else{
          $("#errmsgForCategoryId").show();
          $("#errmsgForCategoryId").html("Curbside Consult Category cannot be blank.");
          $('#errmsgForCategoryId').fadeOut(5000);
     }
     
 }
 
 function editGroupDescription() {    
    $("#editGroupDescription").show();
    $("#updateGroupDescription").show();
    $("#closeEditGroupDescription").show();
    $("#editGroupDescriptionText").show();  
    $("#groupDescription").hide();
    $("#groupDescriptionTotal").hide();
    $("#editButton").hide();
    $("#profile div a.more").hide();
}

function saveEditGroupDescription(groupId,type) {
      
    var groupDescription =$("#editGroupDescriptionText").html();    
    
    var queryString = "groupDescription=" + groupDescription + "&groupId=" + groupId+"&type="+type;
    ajaxRequest("/group/editGroupDetails", queryString, saveEditGroupDescriptionHandler)
}
function saveEditGroupDescriptionHandler(data) {
    if (data.status == 'success') {
        $("#editGroupDescription").hide();
        var description = $("#editGroupDescriptionText").html();         
        if(description.length>240){        
            $("#g_descriptionMore").show();       
        }     else{
            $("#g_descriptionMore").hide();    
        }   
        $("#descriptioToshow").html(description);
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

function closeEditGroupDescription(){
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

function saveGroupBannerAndIcon(groupId,type){ 
    var queryString = "bannerImage=" + g_groupPicture + "&groupId=" + groupId+"&type="+type;    
    ajaxRequest("/group/editGroupDetails", queryString, saveGroupIconnHandler);
    
}
function saveGroupIconnHandler(){
    g_groupPicture='';
    $('#updateAndCancelBannerUploadButtons').hide();
    $('#updateAndCancelGroupIconUploadButtons').hide();
}

function cancelBannerOrIconUpload(oldImage,type){
    
    if(type=='GroupBannerImage'){
     $('#GroupBannerPreview').val(oldImage); 
     $('#GroupBannerPreview').attr('src',oldImage);  
      $('#updateAndCancelBannerUploadButtons').hide();
    }
    if(type=='GroupProfileImage'){
     $('#groupIconPreviewId').val(oldImage); 
     $('#groupIconPreviewId').attr('src',oldImage);  
     $('#updateAndCancelGroupIconUploadButtons').hide();
    }
      g_groupPicture='';
     
}

  function getHelpIconListmanagementDetails(startLimit, filterValue, searchText) {
    if (filterValue == "" || filterValue == undefined) {
        filterValue = "all";
    }
    g_filterValue = filterValue; // assgining filtervalue to global variable...
    if (startLimit == 0) {
        g_pageNumber = 1;
    }
    var queryString = "filterValue=" + filterValue + "&searchText=" + searchText + "&startLimit=" + startLimit + "&pageLength=" + g_pageLength;
    ajaxRequest("/admin/getHelpIconManagementDetails", queryString, getHelpIconListHandler);
 }
 
 
/** Author:Praneeth
 *  Method:getCurbsideCategories
 *  @param: get the list of curbside categories 
 */

 function getHelpIconListHandler(data) {
     scrollPleaseWaitClose('spinner_admin');
    var item = {
        'data': data
    };
    $.templates({
        mytmpl: {
            markup: "#helpMangementTmp_render",
            helpers: {
                getSubString: getSubStringFunction
            }
        }
    });
    var html = $.render.mytmpl(item);
    $("#helpCreationManagement_div").html(html);
    if (g_pageNumber == undefined) {
        g_page = 1;
    } else {
        g_page = g_pageNumber;
    }
    if (g_filterValue != undefined) {
        $("#filterHelpIconDescriptionTitle").val(g_filterValue);
    } else {
        g_filterValue = "all";
    }
    if (data.total.totalCount == 0) {
        $("#pagination").hide();
        $("#noRecordsTR").show();
    }

    $("#pagination").pagination({
        currentPage: g_page,
        items: data.total.totalCount,
        itemsOnPage: g_pageLength,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber, event) {
            g_pageNumber = pageNumber;
            var startLimit = ((parseInt(pageNumber) - 1) * parseInt(g_pageLength));
            getHelpIconListmanagementDetails(startLimit, g_filterValue, g_searchText);
        }

    });


    if(g_searchText !="undefined" && g_searchText !=undefined){  
        $('#searchTextId').val(g_searchText);
    }
    Custom.init();
 }
 
 /** Author:Praneeth
 *  Method:searchHelpIconDescription
 *  @param: to display the categories based the search value
 */
 function searchHelpIconDescription(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        scrollPleaseWait('spinner_admin');
        if ($.trim($("#searchTextId").val()) != "") {
            var searchText = $("#searchTextId").val();
            g_searchText = searchText;
            getHelpIconListmanagementDetails(0, '', g_searchText);
        } else {
            g_searchText = "";
            getHelpIconListmanagementDetails(0);
        }
        return false;

    }
 }
 
 /** Author:Praneeth
 *  Method:createNewCurbsideCategory
 *  @param: to category, will open the form in the popup
 */
 function createNewHelpIconDescription()
  {
    $('.qq-upload-button').show();
    $('#NewHelpIconReset').click();
    $("#editableDescription").html('');
    $("#HelpIconcreationForm_id").val("");
    $("#sucmsgForHelpIcon,#errmsgForHelpIcon").hide();    
    $('#addNewHelpIcon').modal('show');
    $('#NewHelpIconLabel').show();
    $('#UpdateHelpIconLabel').hide();
    $('#previewul_HelpCreactionForm').val("");
    $('#preview_HelpCreactionForm').val("");
     $('#preview_HelpCreactionForm').hide("");
    $("#newHelpIconId").val('Create');
     $("#HelpIconcreationForm_name"). removeAttr('readonly');
  }
  
  /** Author:Praneeth
 *  Method:editCurbsideCategoryById
 *  @param: to edit already existing category based on the categoryId
 */

 function editHelpIconDescriptionById(id) {
    scrollPleaseWait('spinner_admin');
    var queryString = "Id="+id;
    ajaxRequest("/admin/editHelpIconDetails", queryString, editHelpIconDetailsHandler)
 }
/** Author:Praneeth
 *  Method:editCurbsideCategoryIdHandler
 *  @param: handler to edit already existing category based on the categoryId
 */
 function editHelpIconDetailsHandler(data) {
     scrollPleaseWaitClose('spinner_admin');
     globalspace["HelpCreactionForm_UploadedFiles"] = new Array();
     globalspace["HelpCreactionForm_Artifacts"] = new Array();
    var helpIconDetails = data.data;   
    $("#HelpIconcreationForm_name").attr('readonly','readonly');
     $("#HelpIconcreationForm_id").val(helpIconDetails.Id);
     $("#HelpIconcreationForm_name").val(helpIconDetails.Name);
      $("#editableDescription").html(helpIconDetails.Description);
     $("#cue").val(helpIconDetails.Cue);
      var videoLength=0;
     videoLength=$.trim(helpIconDetails.VideoPath);   
     if(videoLength.length!=0 )
     { 
         globalspace["HelpCreactionForm_UploadedFiles"].push(helpIconDetails.VideoPath);
         globalspace["HelpCreactionForm_Artifacts"].push(helpIconDetails.VideoPath);
        $("#previewul_HelpCreactionForm").html('');
        $("#preview_HelpCreactionForm").show();
        $("#previewul_HelpCreactionForm").show();
         image = "/images/system/video_img.png";
//         $("#previewul_HelpCreactionForm").append(' <li class="alert" ><i  id="1"  onclick="closeimage(this,' + "'" + data.basePath + "'" + "," + "'" + data.basePath + "'" + "," + "'" + data.basePath + "'" + "," + "' HelpIconcreationForm_artifacts'" + ');"  class="fa fa-times-circle deleteicon "  data-dismiss="alert" ></i><i style="display:none" class="fa fa-search-plus zoomicon" ></i><a  class="postimgclose"   href="#"> </a><img src="' + image + '"></li>');
        $("#previewul_HelpCreactionForm").append(' <li class="alert" ><i  data-basepath="'+data.basePath+'"    class="fa fa-times-circle deleteicon "  data-dismiss="alert" ></i><i style="display:none" class="fa fa-search-plus zoomicon" ></i><a  class="postimgclose"   href="#"> </a><img src="' + image + '"></li>');
        $("ul#previewul_HelpCreactionForm li i").unbind('click');
         $("ul#previewul_HelpCreactionForm li i").bind('click', function(){
           if($(this).closest('ul').find('li').length<=1){
               $('#preview_HelpCreactionForm').hide();
               $('#HelpIconcreationForm_artifacts').val('');
               $('.qq-upload-button').show();
               globalspace.removedFilePath=data.basePath;
               globalspace["HelpCreactionForm_UploadedFiles"] = new Array();
               globalspace["HelpCreactionForm_Artifacts"] = new Array();
           }
       });
    }
    else{
        $("#previewul_HelpCreactionForm").html('');
        $("#preview_HelpCreactionForm").hide();
    }
    $('#addNewHelpIcon').modal('show');
    $('#NewHelpIconLabel').hide();
    $('#UpdateHelpIconLabel').show();
    $("#newHelpIconId").val('Update');
   
    $('#errmsgForHelpIcon').hide();
    $('#sucmsgForHelpIcon').hide();
    if($('ul#previewul_HelpCreactionForm li').length>0){
        $('.qq-upload-button').hide();
    }else{
        $('.qq-upload-button').show();
    }
 }
 
 
 /**
 * @author Praneeth
 * @param {type} file
 * @param {type} response
 * @param {type} responseJSON
 * @param {type} postType
 * @returns {undefined}
 */
function previewVideo(file, response, responseJSON, postType) {
    $('#preview_' + postType).show();
    $('#previewul_' + postType).show();
    if (typeof globalspace[postType + "_UploadedFiles"] == 'undefined') {
        globalspace[postType + "_UploadedFiles"] = new Array();
        globalspace[postType + "_Artifacts"] = new Array();
    }
    if (globalspace[postType + "_UploadedFiles"].length == 0) {
      
        if ($.inArray(response, globalspace[postType + "_Artifacts"]) < 0) { // doesn't exist

            $('.qq-upload-list').hide();
            var data = responseJSON;
            var filetype = responseJSON['extension'];
            var imageid = responseJSON['savedfilename'];
            var image = "";
            if (filetype == 'mp4' || filetype == 'mov') {
                image = "/images/system/video_img.png";
            }
            if (image == "") {

                image = responseJSON['filepath'];
            }
            $("#HelpIconcreationForm_artifacts").val(responseJSON['filesavedpath']);
            globalspace[postType + "_UploadedFiles"].push(responseJSON['savedfilename']);
            globalspace[postType + "_Artifacts"].push(responseJSON['filesavedpath']);
//            $('#previewul_' + postType).html(' <li class="alert" ><i  id="' + imageid + '"  onclick="closeimage(this,' + "'" + responseJSON['savedfilename'] + "'" + "," + "'" + responseJSON['fileremovedpath'] + "'" + "," + "'" + responseJSON['filename'] + "'" + "," + "'" + postType + "'" + ');"  class="fa fa-times-circle deleteicon "  data-dismiss="alert" ></i><i style="display:none" class="fa fa-search-plus zoomicon" ></i><a  class="postimgclose"   href="#"> </a>\n\
//                <img src="' + image + '"></li>');
             $('#previewul_' + postType).html(' <li class="alert" ><i  id="' + imageid + '"  class="fa fa-times-circle deleteicon "  data-dismiss="alert" ></i><i style="display:none" class="fa fa-search-plus zoomicon" ></i><a  class="postimgclose"   href="#"> </a>\n\
                <img src="' + image + '"></li>');
             $('.qq-upload-button').hide();
            $("ul#previewul_HelpCreactionForm li i").unbind('click');
            $("ul#previewul_HelpCreactionForm li i").bind('click', function(){
           if($(this).closest('ul').find('li').length<=1){
                    $('#preview_HelpCreactionForm').hide();
                    $('#HelpIconcreationForm_artifacts').val('');
                    $('.qq-upload-button').show();
                    globalspace.removedFilePath=responseJSON['fileremovedpath'];
                    globalspace["HelpCreactionForm_UploadedFiles"] = new Array();
                    globalspace["HelpCreactionForm_Artifacts"] = new Array();
                }
            });
        }
          else { // does exist
            var message = response + "Duplicate found, Please upload a new file.";
            displayVideoErrorMessage(message);
        }
    } else {
        var message = "You can upload only one file.";
        displayVideoErrorMessage(message);
    }
}

function displayVideoErrorMessage(message){

    var res = message.match(/invalid extension/g);
    if(res =='invalid extension')
    {
        message ="Only video of formats mp4,mov are allowed.";
    }
    $('#errmsgForHelpIcon').show();
    $('#errmsgForHelpIcon').css("padding-top:20px;");
    $('#errmsgForHelpIcon').html(message);
    $('#errmsgForHelpIcon').fadeOut(5000);
}
 /*
 * This method is used for remove the  uploaded artifact.
 */
function closeimage(obj, filename, filepath, video, type) {
    var file = filepath;
    var queryString = "image=" + video + "&file=" + filename + "&filepath=" + file;
    ajaxRequest("/admin/removevideoartifacts", queryString, function(data) {
        removeArtifactVideoHandler(data, type);
    });
}
function removeArtifactVideoHandler(data, type) {
    if (data.status == 'success') {
        var filename = data.file;
        var vindex = globalspace[type + "_UploadedFiles"].indexOf(data.filename);
        if (vindex != -1) {
            globalspace[type + "_UploadedFiles"].splice(vindex, 1);
        }
        var vindex = globalspace[type + "_Artifacts"].indexOf(data.image);
        if (vindex != -1) {
            globalspace[type + "_Artifacts"].splice(vindex, 1);
        }
    }
}

function changeHelpIconDescriptionStatus(iconid) {
    var divId = "",
            selectDivId = "";
    divId = "helpIconDescriptionId_" + iconid;
    selectDivId = "helpIconDescription_edit_" + iconid;

    if ($("#" + divId + ":visible").length > 0) {
        $("#" + divId).hide();

        $("#" + selectDivId).show();

    } else {
        $("#" + divId).show();
        $("#" + selectDivId).hide();
    }

 }
 
 /** Author:Praneeth
 *  Method:changehelpIconDescriptionStatusType
 *  @param: to update the status i.e, active to delete for category based on categoryId 
 */
 function changehelpIconDescriptionStatusType(iconid,value) {
     scrollPleaseWait('spinner_admin');
    $("#helpIconDescription_edit_" + iconid).hide();    
    var queryString = "id="+iconid + "&value=" + value;
    
    ajaxRequest('/admin/updateHelpIconStatus', queryString, changeHelpIconStatusTypeHandler);

 }

/** Author:Praneeth
 *  Method:changeHelpIconStatusTypeHandler
 *  @param: handler after status changes for category
 */
 function changeHelpIconStatusTypeHandler(data){
     scrollPleaseWaitClose('spinner_admin');
    if(data.status == "success")
    {
        var startLimit = ((parseInt(g_pageNumber) - 1) * parseInt(g_pageLength));
           getHelpIconListmanagementDetails(startLimit, g_filterValue, g_searchText);
    }
    else{
        // update failed...
    }
 }
 
 $("#filterHelpIconDescriptionTitle").live( "change", 
        function(){
    var value = $("#filterHelpIconDescriptionTitle").val();
    var searchText = $("#searchTextId").val();
    g_searchText = searchText;
    g_filterValue = value;
    scrollPleaseWait('spinner_admin');
    getHelpIconListmanagementDetails(0, value, searchText);
        }
    );
function abusedOnReadyEvents() {
     $("#PostBlockOrRemove .PostManagementActions li>a").live("click", function() {   
        var actionType = $(this).attr('name');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var isBlockedPost = $(this).closest('ul.PostManagementActions').attr('data-isBlocked'); 
        var modelType = 'error_modal';
        var title = actionType;
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var callback='';
        var param='';
        var content = "";
        if(actionType=="Featured"){              
            okCallback = unMarkAsFeatured;
            content = "Are you sure you want to remove as featured?";
            param = ''+postId+','+categoryType+','+networkId+','+actionType+'';
        }else{  
            content = "Are you sure you want to "+actionType+" this post?";
            okCallback = blockOrReleaseCallback;    
            param = ''+postId+','+categoryType+','+networkId+','+actionType+','+isBlockedPost+'';
        }
        
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
    });
    $("#CommentBlockOrRemove .PostManagementActions li>a").live("click", function() {        
        var actionType = $(this).attr('name');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var commentId = $(this).closest('ul.PostManagementActions').attr('data-commentId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        //var isBlockedPost = $(this).closest('ul.PostManagementActions').attr('data-isBlocked'); 
        var modelType = 'error_modal';
        var title = actionType;
        var content = "Are you sure you want to "+actionType+" this post?";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var okCallback = blockOrReleaseCommentCallback;    
        var param = ''+postId+','+commentId+','+categoryType+','+networkId+','+actionType+'';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
    });
    $("#AbusedCommentBlockOrRemove .CommentManagementActions li>a").live("click", function() {        
        var actionType = $(this).attr('name');
        var title = $(this).text();
        var postId = $(this).closest('ul.CommentManagementActions').attr('data-postId');
        var commentId = $(this).closest('ul.CommentManagementActions').attr('data-commentId');
        var categoryType = $(this).closest('ul.CommentManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.CommentManagementActions').attr('data-networkId');
        var CommentCreatedUserId=$(this).closest('ul.CommentManagementActions').attr('data-CommentCreatedUserId');        
        //var isBlockedPost = $(this).closest('ul.PostManagementActions').attr('data-isBlocked'); 
        var modelType = 'error_modal';
        var content = "Are you sure you want to "+title+" this post?";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var okCallback = blockOrReleaseAbusedComment;    
        var param = {postId:postId,commentId:commentId,categoryType:categoryType,networkId:networkId,actionType:actionType,CommentCreatedUserId:CommentCreatedUserId};
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
    });
    /**********This is for abused posts**********/
    $('#AbusePostTabs a').click(function(e) {
        $('#postsDisplayDiv').empty();
        $(this).tab('show');
        $(window).unbind("scroll");
        page = 1;
        isDuringAjax=false;
        $('#postsDisplayDiv').empty();
        scrollPleaseWait('spinner_admin');
        $("#postDetailDiv").hide();
        $("#postsDisplayDiv").show();
        if ($(this).attr('id') == 'posts') {
            getCollectionData('/admin/getnormalabusedposts', 'AbusedPostDisplayBean', 'postsDisplayDiv', 'No Posts found.', 'That\'s all folks!');
        } else if ($(this).attr('id') == 'curbsidePosts') {
            getCollectionData('/admin/getcurbsideabusedposts', 'AbusedCurbsidePostDisplayBean', 'postsDisplayDiv', 'No Posts found.', 'That\'s all folks!');
        } else if ($(this).attr('id') == 'groupPosts') {
            getCollectionData('/admin/getgroupabusedposts', 'AbusedGroupPostDisplayBean', 'postsDisplayDiv', 'No Posts found.', 'That\'s all folks!');
        } else if ($(this).attr('id') == 'news') {
            getCollectionData('/admin/getnewsabusedposts', 'CuratedNewsCollectionBean', 'postsDisplayDiv', 'No News found.', 'That\'s all folks!');
        } else if ($(this).attr('id') == 'games') {
            getCollectionData('/admin/getgameabusedposts', 'AbusedGameCollectionBean', 'postsDisplayDiv', 'No Games found.', 'That\'s all folks!');
        } else if ($(this).attr('id') == 'featuredPosts') {                
            getCollectionData('/admin/GetAllFeaturedItemsForAdmin', 'FeaturedItemsBean', 'postsDisplayDiv', 'No Posts found.','That\'s all folks!');
        }
    });
    /**********This is for blocked posts**********/
    $('#AbusePostTabsB a').live('click',function(e) {
        $('#postsDisplayDiv').empty();
        $(this).tab('show');
        $(window).unbind("scroll");
        page = 1;
        isDuringAjax=false;
        $('#postsDisplayDiv').empty();
        if ($(this).attr('id') == 'posts') {
            getCollectionData('/admin/getnormalblockedposts', 'AbusedPostDisplayBean', 'postsDisplayDiv', 'No Posts found.', 'That\'s all folks!');
        } else if ($(this).attr('id') == 'curbsidePosts') {
            getCollectionData('/admin/getcurbsideblockedposts', 'AbusedCurbsidePostDisplayBean', 'postsDisplayDiv', 'No Posts found.', 'That\'s all folks!');
        } else if ($(this).attr('id') == 'groupPosts') {
            getCollectionData('/admin/getgroupblockedposts', 'AbusedGroupPostDisplayBean', 'postsDisplayDiv', 'No Posts found.', 'That\'s all folks!');
        }
    });
     $("#postsDisplayDiv a.userprofilename").live( "click", 
        function(){            
            var userId = $(this).attr('data-id');
            var streamId = $(this).attr('data-streamId');
            getMiniProfile(userId,streamId);
        }
    );
     //for mentions
     $("#postsDisplayDiv a.curbsideCategory").live( "click", 
        function(){
            var categoryId = $(this).attr('data-id');
            getMiniCurbsideCategoryProfile(categoryId);
        }
    );
    $('#AbuseScanHelpIcon').on('click', function(){
        $("#myModal_body").html("<code>1. When you edit or delete word, earlier posts with a block about that word should be released.<br/>2. Adding new words shouldn't apply the change to older posts.</code>");        
        $("#myModalLabel").addClass("stream_title paddingt5lr10");
        $("#myModalLabel").html("Abuse Scan");
        $("#myModal_footer").hide();
        $("#myModal").modal('show');
    });
    $("#postsDisplayDiv .postdetail").live("click touchstart",
       function() {
           Global_ScrollHeight = $(document).scrollTop();
           var categoryType = $(this).attr('data-categoryType');
           var postId = $(this).attr('data-postid');
           var postType = $(this).attr('data-postType');
               abusedPostDetailPage("postDetailDiv", "postsDisplayDiv", postId, categoryType, postType);
    });
}
function abusedPostDetailPage(showDivId, hideDivId, postId, categoryType, postType){
   var data={postId:postId,
             categoryType:categoryType,
             postType:postType,
             isPostManagement:1
         };
    var URL = "/post/renderPostDetailed";
    if(categoryType==8)
    {
        URL = "/news/renderPostDetailed";
    }else if (Number(categoryType) == 9) {
        URL = $("#postdetail_"+postId).val();
         window.location = URL;
    }else{
         scrollPleaseWait('spinner_admin');
         ajaxRequest(URL,data,function(data){abusedPostDetailPageHandler(data,showDivId, hideDivId,postId)},"html");
    }
}
function abusedPostDetailPageHandler(html,showDivId, hideDivId,postId){
   scrollPleaseWaitClose('spinner_admin');
   $("#"+hideDivId).hide();
   $("#"+showDivId).html(html).show();
   $( ".detailed_close_page" ).unbind( "click" );
   $("#"+showDivId+" .detailed_close_page").bind('click',function(){
       $("#"+showDivId).hide();
       scrollPleaseWait('spinner_admin');
       $("#"+hideDivId).show();
       scrollPleaseWaitClose('spinner_admin');
   });
   if(Number($("#det_commentCount_"+postId).text())==0){
      $("#CommentPost").remove(); 
   }
   else{
         $("#newComment").remove(); 
   }
   $("#socialactions").remove();
}
function createNewAbuseWordPopup()
  { $("#AbuseWordCreationForm_AbuseWord_em_").fadeOut(3000);
    $("#abuseWordCreation-form")[0].reset();
    $('#NewAbuseWordReset').click();
    $("#AbuseWordCreationForm_id").val(" ");
    $("#sucmsgForAbuseWord,#errmsgForAbuseWord").hide();
    $('input[type=text]').hide();
    $('input[type=text]').attr('name','');
    $('textarea').show();
    $('textarea').attr('name','AbuseWordCreationForm[AbuseWord]');
    $('#addNewAbuseWord').modal('show');
    $('#NewAbuseWordLabel').show();
    $('#UpdateAbuseWordLabel').hide();
    $("#newAbuseWordId").val('Create');
  }
  function openAbuseWordEditPopUp(id) {
    $("#AbuseWordCreationForm_AbuseWord_em_").fadeOut(3000);
    $("#AbuseWordCreationForm_id").val(id);
    $('textarea').hide();
    $('textarea').attr('name','');
    $('input[type=text]').show();
    $('input[type=text]').attr('name','AbuseWordCreationForm[AbuseWord]');
    $("#AbuseWordCreationForm_AbuseWord").val($.trim($('#abuseWord_'+id).text()));
    $('#addNewAbuseWord').modal('show');
    $('#NewAbuseWordLabel').hide();
    $('#UpdateAbuseWordLabel').show();
    $("#newAbuseWordId").val('Update');
    $('#errmsgForAbuseWord').hide();
    $('#sucmsgAbuseWord').hide();
 }
/*
* Handler for requesting new abuseWord
*/
function abuseWordCreationHandler(data,txtstatus,xhr){
   if(data.status =='created' || data.status == 'updated')
   {
       var msg=data.data;
       $("#sucmsgForCreateAbuseWord").html(msg);
       $("#sucmsgForCreateAbuseWord").css("display", "block");
       $("#errmsgForCreateAbuseWord").css("display", "none");
       if(data.status =='created'){
            $("#abuseWordCreation-form")[0].reset();
            // auto refresh the page...
            getCollectionDataWithPagination('/admin/getAbusedWords','AbuseKeywords', 'abusedWords_tbody',1,10, '');
        }else{
            var id = $("#AbuseWordCreationForm_id").val();
            $("#abuseWord_"+id).text($.trim($('#AbuseWordCreationForm_AbuseWord').val()));
            $("#abuseWordCreation-form")[0].reset();
        }
        $("#sucmsgForCreateAbuseWord").fadeOut(3000, function(){$('#addNewAbuseWord').modal('hide');});
   }else if(data.status=='exist'){
       var msg=data.data;
       $("#errmsgForCreateAbuseWord").html(msg);
       $("#sucmsgForCreateAbuseWord").css("display", "none");
       $("#errmsgForCreateAbuseWord").css("display", "block");
       $("#errmsgForCreateAbuseWord").fadeOut(3000);
   }else{
       var msg = data.data;
       $("#errmsgForCreateAbuseWord").html(msg);
       $("#sucmsgForCreateAbuseWord").css("display", "none");
       $("#errmsgForCreateAbuseWord").css("display", "block");
       $("#errmsgForCreateAbuseWord").fadeOut(3000);
   }
}
function getCollectionDataWithPagination(URL,CollectionName, MainDiv, CurrentPage, PageSize, callback){
   
    globalspace[MainDiv+'_page'] = Number(CurrentPage);
        globalspace[MainDiv+'_pageSize']=Number(PageSize);

        var newURL =  URL+"?"+CollectionName+"_page="+globalspace[MainDiv+'_page']+"&pageSize="+globalspace[MainDiv+'_pageSize'];
    var data = "";   
    ajaxRequest(newURL,data,function(data){getCollectionDataWithPaginationHandler(data,URL,CollectionName,MainDiv,callback)});
 
    }
    function getCollectionDataWithPaginationHandler(data,URL,CollectionName,MainDiv,callback){
          scrollPleaseWaitClose('spinner_admin');
        $("#"+MainDiv).html(data.html);

                $('#'+MainDiv+'_count').text(data.totalCount);
                $("#pagination").pagination({
                    currentPage: globalspace[MainDiv+'_page'],
                    items: data.totalCount,
                    itemsOnPage: globalspace[MainDiv+'_pageSize'],
                    cssStyle: 'light-theme',
                    onPageClick: function(pageNumber, event) {
                        globalspace[MainDiv+'_page'] = pageNumber;
                        getCollectionDataWithPagination(URL,CollectionName, MainDiv, globalspace[MainDiv+'_page'], globalspace[MainDiv+'_pageSize'], callback)
                    }

                });
                if(callback!=''){
                    callback();
                }
    }
function getDataByPageLength(pageLength) {
    scrollPleaseWait('spinner_admin');
   getCollectionDataWithPagination('/admin/getAbusedWords','AbuseKeywords', 'abusedWords_tbody',1,pageLength,'');
}    
function searchAbuseWords(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (Number(keycode) == 13) {
        var searchKey = $.trim($("#searchTextId").val());
        scrollPleaseWait('spinner_admin');
        getCollectionDataWithPagination('/admin/getAbusedWords','searchKey='+searchKey+'&AbuseKeywords', 'abusedWords_tbody',1,10,'');
    }
 }

 
function getRoleBasedAction(){   
     scrollPleaseWait('spinner_admin_');
    var selectedRole=$('#roles').find(":selected").val();

    var data = "selectedRole="+selectedRole;
     ajaxRequest("/admin/getRoleBasedActions",data,getActionsByRoleHandler,"html");

} 

function getActionsByRoleHandler(data){
    scrollPleaseWaitClose('spinner_admin_');
    $('#roleActionsList').html(data);
    
}

function  updateRoleActions(){
    var actionIds = 0;
    var selectedRoleId=$('#roles').find(":selected").val();
     $("input[name='actionItem']:checked").each( function (key, val) {
        if(actionIds == 0){            
            actionIds = $(val).val();
        }else{            
            actionIds = actionIds+","+$(val).val();
        }  
    });
    scrollPleaseWait('spinner_admin');
    var queryString = "selectedRoleId="+selectedRoleId + "&actionIds="+actionIds;
    ajaxRequest('/admin/UpdateRoleBasedActions', queryString, updateRoleBasedActionsHandler);
}
function updateRoleBasedActionsHandler(data){
    scrollPleaseWaitClose('spinner_admin');
     if(data.status=="success"){
     $("#successMessage").html("updated roles successfully");
     $("#successMessage").show();
     $("#successMessage").fadeOut(3000,"");
     }else{
          $("#errorMessage").html("please try again");
     $("#errorMessage").show();
     $("#errorMessage").fadeOut(3000,"");
     }
    
    
}
 
 /**
  * Function to limit the characters in the renderscript(in helpManagementScript for limiting help description)
  * @param {type} text
  * @param {type} length
  * @returns {String}
  */
function getSubStringFunction(text, length) {
    var res=text;
    if(text.length>length){
        res = text.substring(0,length)+"...";
    }
  return res;
}
function getUserPreveligesByType(UserId,UserTypeId){ 
    var queryString = "UserId="+UserId + "&UserTypeId="+UserTypeId;
    ajaxRequest("/admin/getUserActionsByUserType",queryString,function(data){getUserPreveligesByTypeHandler(data, UserId);},"html");
}

function getUserPreveligesByTypeHandler(data, userId){
     $("#myModal_body").html(data);
    $("#myModalLabel").html("Advanced options");
    $("#myModal_saveButton").unbind("click");
    $("#myModal_saveButton").bind("click", function(){
        saveUserPreveliges(userId);
    });
    $("#myModal_saveButton").html("Save");
    $("#myModal_footer").show();
    $("#myModal_message").hide();
    $("#myModal").modal('show');
}
function saveUserPreveliges(userId){
    var checkedActionIds = 0;
     $("input[name='actionItem']:checked").each( function () {
        if(checkedActionIds == 0){            
            checkedActionIds = $(this).val();
        }else{            
            checkedActionIds = checkedActionIds+","+$(this).val();
        }  
    });
    var allActionIds = 0;
     $("input[name='actionItem']").each( function () {
        if(allActionIds == 0){            
            allActionIds = $(this).val();
        }else{            
            allActionIds = allActionIds+","+$(this).val();
        }  
    });
    scrollPleaseWait("advanceOptionsSpinner","usermanagement_div");
    var queryString = "userId="+userId+"&checkedActionIds="+checkedActionIds+"&allActionIds="+allActionIds;
    ajaxRequest("/admin/updateRoleBasedUserPrivileges",queryString,saveUserPreveligesHandler);
}
function saveUserPreveligesHandler(data){
    scrollPleaseWaitClose("advanceOptionsSpinner");
    if(data.status == "success"){
        $("#myModal_message").addClass("alert alert-success");
        $("#myModal_message").html("User privileges updated successfully.");
        $("#myModal_message").show();
        $("#myModal_message").fadeOut(3000,function(){
            $("#myModal_saveButton").unbind("click");
            $("#myModal").modal('hide');
        });        
    }else{
        $("#myModal_message").addClass("alert alert-error");
        $("#myModal_message").html("Please try again");
        $("#myModal_message").show();
        $("#myModal_message").fadeOut(3000,"");
    }
}
function openAddRoleModelBox(){
     ajaxRequest("/admin/addRolePage","",openAddRoleModelBoxHandler,"html");

}
function openAddRoleModelBoxHandler(html){
    $( "#myModal_body" ).html(html);
     $("#myModalLabel").html("Add Role");
    $("#myModal_saveButton").unbind("click");
    $("#myModal_saveButton").bind("click", function(){
        saveRole();
    });
    $("#myModal_saveButton").html("Save");
    $("#myModal_footer").show();
    $("#myModal_message").hide();
    $("#myModal").modal('show'); 
}
function saveRole(){
    var role = $.trim($('#role').val());
    if(role!=""){
        var queryString = "role="+role;
        ajaxRequest("/admin/saveRole",queryString,function(data){saveRoleHandler(data, role);});
    }else{
        $('#errmsgForCreateRole').html("Role can not be blank").show().fadeOut(3000);
    }
}
function saveRoleHandler(data, role){
    if(data.status=="RoleExist"){
        $('#errmsgForCreateRole').html("Role already exist").show().fadeOut(3000);
    }else if($.isNumeric(data.status)){
        $('#sucmsgForCreateRole').html("Role created successfully").show().fadeOut(3000, function(){ 
            $("#myModal").modal('hide'); 
            $('#roles').append("<option value='"+data.status+"'> "+role+" </option>");
        });
    }else{
        $('#errmsgForCreateRole').html("Unable to create Role, Please try again").show().fadeOut(3000);
    }
}
function conformChangeRole(userId, roleId){
    var modelType = 'error_modal';
    var title = 'Change Role';
    var content = "Performing this operation will flush the user privileges.";
    var closeButtonText = 'Cancel';
    var okButtonText = 'Continue';
    var okCallback = changeUserRole;
    var param = '' + userId + ',' + roleId + '';
    openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
}
function changeUserRole(param){
    var paramArray = param.split(',');
    var userId = paramArray[0];
    var roleId = paramArray[1];
    var queryString = "userId="+Number(userId)+"&roleId="+Number(roleId);
    ajaxRequest("/admin/changeUserRole",queryString,function(data){changeUserRoleHandler(data, userId, roleId);});
}
function changeUserRoleHandler(data, userId, roleId){
   if(data.status=="success"){
       $('ul#ChangeRoleDropDown_'+userId+' li').removeClass('active');
       $('ul#ChangeRoleDropDown_'+userId+' li a[data-roleId='+roleId+']').parent().addClass('active');
       $('#usertype_'+userId).html($('ul#ChangeRoleDropDown_'+userId+' li a[data-roleId='+roleId+']').text());
       closeModelBox();
    }
}


function unMarkAsFeatured(param){
    var paramArray = param.split(',');
    var postId = paramArray[0];
    var categoryType = paramArray[1];
    var networkId = paramArray[2];
    var actionType = paramArray[3];
    var type = 'UnFeatured';               
    var modelType = 'error_modal';  

    var queryString = "postId="+postId+"&categoryType="+categoryType+"&networkId="+networkId+"&type="+type;
    
    ajaxRequest("/post/MarkOrUnMarkPostAsFeatured",queryString,function(data){UnMarkPostAsFeaturedHandler(data,postId);});

}
function UnMarkPostAsFeaturedHandler(data,postId){
    if(data.status=="success"){
        closeModelBox();
        $("#postitem_"+postId).animate({
        opacity: 0,
        }, 1500, function() {
            $("#postitem_"+postId).remove();
            $('#postsDisplayDiv').removeClass('NPF');
            if($('#postsDisplayDiv div.post.item').length<=0){
                $('#postsDisplayDiv').addClass('NPF');
                $('#postsDisplayDiv').html('<center>No posts found</center>');
            }
        });
    }
}
function blockOrReleaseCommentCallback(param){
    var paramArray = param.split(',');
    var postId = paramArray[0];
    var commentId = paramArray[1];
    var categoryType = paramArray[2];
    var networkId = paramArray[3];
    var actionType = paramArray[4];
    blockOrReleaseComment(postId, commentId, actionType, categoryType, networkId);
}
function blockOrReleaseComment(postId, commentId, actionType, categoryType, networkId){
    var queryString = "postId="+postId+"&commentId="+commentId+"&actionType="+actionType+"&categoryType="+categoryType+"&networkId="+networkId;
    ajaxRequest("/admin/blockOrReleaseComment",queryString,function(data){blockOrReleaseCommentHandler(data,postId, commentId);});
}
function blockOrReleaseCommentHandler(json, postId, commentId){
    closeModelBox();
    if(json.status=="CommentReleased"){
        var commentCount = Number($("#commentCount_"+postId).html());
        if(commentCount>0){
            $("#commentCount_"+postId).html(--commentCount);
        }
        $("#comment_"+postId+"_"+commentId+" div.postmg_actions").remove();
        abusedTagCloud();
    }else if(json.status=="PostReleased"){
        $("#postitem_"+postId).animate({
        opacity: 0,
        }, 1500, function() {
            $("#postitem_"+postId).remove();
            if($('#postsDisplayDiv div.post.item').length<=0){
                $('#postsDisplayDiv').addClass('NPF');
                $('#postsDisplayDiv').html('<center>No posts found</center>');
            }
            abusedTagCloud();
        });
    }
}

 
/** Author:Praneeth
 *  Method:changeCurbsideCategoryStatusTypeHandler
 *  @param: handler after status changes for category
 */
  function changeCurbsideCategory(param)
 {
    scrollPleaseWait('spinner_admin');
    $("#curbsideCategory_edit_" + categoryid).hide(); 
    var paramArray = param.split(',');
    var categoryid = paramArray[0];
    var categoryStatus = paramArray[1];
    var queryString = "id="+categoryid + "&value=" +categoryStatus;
    ajaxRequest('/admin/updateCurbsidecategoryStatus', queryString, function(data){changeCurbsideCategoryStatusTypeHandler(data);});
 }

/** Author:Praneeth
 *  Method:changeCurbsideCategoryStatusTypeHandler
 *  @param: handler after status changes for category
 */
 function changeCurbsideCategoryStatusTypeHandler(data){
     scrollPleaseWaitClose('spinner_admin');
    if(data.status == "success"){
         closeModelBox();
         var startLimit = ((parseInt(g_pageNumber) - 1) * parseInt(g_pageLength));
         getCurbsideCategorymanagementDetails(startLimit, g_filterValue, g_searchText);
    }
    else{
        // update failed...
    }
 }
function showAddBlockwordDiv(){
    $('#abusedWords_div').hide();
    $('#abusedWords_Edit_div').show();
}
function showEditBlockwordDiv(){
    ajaxRequest('/admin/getAllAbuseWords', "", function(data){showEditBlockwordDivHandler(data);});
}
function showEditBlockwordDivHandler(data){
    if(data.status=='success'){
        var blockwords="";
        if(data.data.length>0){
            $.each(data.data, function(key,val){
                blockwords=blockwords+','+val;
            });
        }
        if(blockwords.length>0){
            blockwords=blockwords.substr(1);
        }
        $('#editBlockWord').val(blockwords);
        showAddBlockwordDiv();    
    }
}
function cancelEditBlockwordDiv(){
    $('#editBlockWord').val('');
    $('#abusedWords_Edit_div').hide();
    $('#abusedWords_div').show();
}
function saveBlockWords(){
    var queryString = "blockwords="+$('#editBlockWord').val();
    ajaxRequest('/admin/saveBlockWords', queryString, function(data){saveBlockWordsHandler(data);});
}
function saveBlockWordsHandler(data){
    if(data.status=='success'){
        abusedTagCloud();
        var activeId = $('#AbusePostTabsB li.active a').attr('id');
        $('#postsDisplayDiv').empty();
        $(window).unbind("scroll");
        page = 1;
        isDuringAjax=false;
        $('#postsDisplayDiv').empty();
        if (activeId == 'posts') {
            getCollectionData('/admin/getnormalblockedposts', 'AbusedPostDisplayBean', 'postsDisplayDiv', 'No Posts found.', 'That\'s all folks!');
        } else if (activeId == 'curbsidePosts') {
            getCollectionData('/admin/getcurbsideblockedposts', 'AbusedCurbsidePostDisplayBean', 'postsDisplayDiv', 'No Posts found.', 'That\'s all folks!');
        } else if (activeId == 'groupPosts') {
            getCollectionData('/admin/getgroupblockedposts', 'AbusedGroupPostDisplayBean', 'postsDisplayDiv', 'No Posts found.', 'That\'s all folks!');
        }
        cancelEditBlockwordDiv();
    }
}
function abusedTagCloud(){
    ajaxRequest('/admin/getAbusedTagCloud', "", abusedTagCloudHandler,'html');
}
function abusedTagCloudHandler(data){
    $('#abusedWords_div').html(data);
}


    /*@author: Praneeth
     * Handler for requesting new category
     */
  
 function curbsideCategoryCreationHandler(data,txtstatus,xhr){
       scrollPleaseWaitClose("categoryCreationSpinLoader");
        if(data.status == 'updatesuccess')
        { 
            var msg=data.data;
           $("#sucmsgForCategoryId").html(msg);
           $("#errmsgForCategoryId").css("display", "none");  
           $("#sucmsgForCategoryId").css("display", "block");
                    $("#sucmsgForCategoryId").fadeOut(3000,function(){
        }); 
            var startLimit = ((parseInt(g_pageNumber) - 1) * parseInt(g_pageLength));
           getCurbsideCategorymanagementDetails(startLimit, g_filterValue, g_searchText);
        }
        if(data.status =='success'){
            var msg=data.data;
            $("#sucmsgForCategory").html(msg);
            $("#sucmsgForCategory").css("display", "block");
            $("#errmsgForCategory").css("display", "none");

            $("#curbsidecategorycreation-form")[0].reset();
             $("#sucmsgForCategory").fadeOut(3000,function(){
            $("#addNewCurbsideCategory").modal('hide');
        }); 

           var startLimit = ((parseInt(g_pageNumber) - 1) * parseInt(g_pageLength));
           getCurbsideCategorymanagementDetails(startLimit, g_filterValue, g_searchText);
           //$("form").serialize()
        }
        if(data.status == 'error'){
            var lengthvalue=data.error.length; 
            var msg=data.data;
            var error=[];
            if(msg!=""){  
                    $("#errmsgForCategory").html(msg);
                    $("#errmsgForCategory").css("display", "block");
                    $("#sucmsgForCategory").css("display", "none");
                    $("#errmsgForCategoryId").html(msg);
                    $("#errmsgForCategoryId").css("display", "block");
                    $("#sucmsgForCategoryId").css("display", "none");
       
            }else{
                if($("#CurbsidecategorycreationForm_id").val()!= ""){
                    $("#errmsgForCategoryId").text("Category already exists");
                    $("#errmsgForCategoryId").show();  
                    $("#errmsgForCategoryId").fadeOut(3000,"");
                }else{
                    if(typeof(data.error)=='string'){
                
                        var error=eval("("+data.error.toString()+")");

                    }else{

                        var error=eval(data.error);
                    }


                    $.each(error, function(key, val) {
                        if($("#"+key+"_em_")){  
                            $("#"+key+"_em_").text(val);                                                 
                            $("#"+key+"_em_").show();                        
                          //  $("#"+key).parent().addClass('error');
                        }

                    });
                }
                 
          }
        }
         if(!detectDevices()){
            $("[rel=tooltip]").tooltip();
         }
     }
     
      /*
     * Handler for requesting new category
     */
    function helpDescriptionIconCreationHandler(data)
    {
       scrollPleaseWaitClose("categoryCreationSpinLoader");
       globalspace["HelpCreactionForm_UploadedFiles"] = new Array();
       globalspace["HelpCreactionForm_Artifacts"]=new Array();
       $('#HelpIconcreationForm_artifacts').val('');
        if(data.status == 'updatesuccess')
        { 
            var msg=data.data;
           $("#sucmsgForHelpIcon").html(msg);
           $("#errmsgForHelpIcon").css("display", "none");  
           $("#sucmsgForHelpIcon").css("display", "block");
            $("#HelpIconcreationForm_name"). removeAttr('readonly');                    
           $("#sucmsgForHelpIcon").fadeOut(3000,function(){
          $("#addNewHelpIcon").modal('hide');
        }); 
           var startLimit = ((parseInt(g_pageNumber) - 1) * parseInt(g_pageLength));
           getHelpIconListmanagementDetails(startLimit, g_filterValue, g_searchText);
        }
        if(data.status == 'updatefail')
        {
            var msg=data.data;

            $("#sucmsgForHelpIcon").css("display", "none");
            $("#errmsgForHelpIcon").css("display", "block");
            $("#errmsgForHelpIcon").html(msg);
            

            //$("#helpIconCreation-form")[0].reset();
             $("#errmsgForHelpIcon").fadeOut(3000,function(){
            //$("#addNewHelpIcon").modal('hide');
        }); 
            //getHelpIconListmanagementDetails(0);
        }
        if(data.status =='success'){
            var msg=data.data;
            $("#sucmsgForHelpIcon").html(msg);
            $("#sucmsgForHelpIcon").css("display", "block");
            $("#errmsgForHelpIcon").css("display", "none");
            $("#editableDescription").html('');
            $("#previewul_HelpCreactionForm").html('');
            $("#preview_HelpCreactionForm").val("");
            $("#helpIconCreation-form")[0].reset();
            $("#preview_HelpCreactionForm").hide();
             $("#sucmsgForHelpIcon").fadeOut(3000,function(){
            $("#addNewHelpIcon").modal('hide');
        }); 
           var startLimit = ((parseInt(g_pageNumber) - 1) * parseInt(g_pageLength));
           getHelpIconListmanagementDetails(startLimit, g_filterValue, g_searchText);
           $('.qq-upload-button').show();
           //$("form").serialize()
        }
        if(data.status == 'error'){
            var lengthvalue=data.error.length; 
            var msg=data.data;
            var error=[];
            if(msg!=""){  
                    $("#errmsgForHelpIcon").html(msg);
                    $("#errmsgForHelpIcon").css("display", "block");
                    $("#sucmsgForHelpIcon").css("display", "none");
//                    $("#errmsgForHelpIcon").fadeOut(3000,function(){
//                     }); 
                    $("#errmsgForHelpId").html(msg);
                    $("#errmsgForHelpId").css("display", "block");
                    $("#sucmsgForHelpId").css("display", "none");
//                    $("#errmsgForHelpId").fadeOut(3000,function(){
//                     });
       
            }else{
                    if(typeof(data.error)=='string'){
                
                        var error=eval("("+data.error.toString()+")");

                    }else{

                        var error=eval(data.error);
                }
       

                    $.each(error, function(key, val) {
                        if($("#"+key+"_em_")){  
                            $("#"+key+"_em_").text(val);                                                 
                            $("#"+key+"_em_").show();     
                             $("#"+key+"_em_").fadeOut(5000);
                          //  $("#"+key).parent().addClass('error');
                           }

                    });
                }
            }
        }


function getConfigurationHandler(data){
    scrollPleaseWaitClose('spinner_admin');
    var item = {
        'data': data
    };
    $("#configuration_div").html(
            $("#configTmp_render").render(item)
            );
}

function getNetworkConfiguration(){
    ajaxRequest("/admin/getNetworkConfiguration","",getConfigurationHandler);
}

function newNetworkConfigHandler(data){
       scrollPleaseWaitClose("addNewNetworkParameterSpinLoader");
        if(data.status == 'Updated')
        { 
            var msg=data.data;
           $("#sucmsgForNewNetworkParameter").html(msg).show();
           $("#errmsgForNewNetworkParameter").hide();
           $("#sucmsgForNewNetworkParameter").fadeOut(3000,function(){
            $("#addNewNetworkParameter").modal('hide');
            getNetworkConfiguration();
            });
           
        }else if(data.status =='success'){
            var msg=data.data;
            $("#sucmsgForNewNetworkParameter").html(msg).show();
           $("#errmsgForNewNetworkParameter").hide();
           $("#sucmsgForNewNetworkParameter").fadeOut(3000,function(){
            $("#addNewNetworkParameter").modal('hide');
            getNetworkConfiguration();
        }); 
           //$("form").serialize()
           
        }else if(data.status == 'error'){
            var lengthvalue=data.error.length; 
            var msg=data.data;
            var error=[];
                    if(typeof(data.error)=='string'){
                
                        var error=eval("("+data.error.toString()+")");

                    }else{

                        var error=eval(data.error);
                    }


                    $.each(error, function(key, val) {
                        if($("#"+key+"_em_")){  
                            $("#"+key+"_em_").text(val);                                                 
                            $("#"+key+"_em_").show();                        
                          //  $("#"+key).parent().addClass('error');
                        }

                    });
              
                 
          
        }
         if(!detectDevices()){
            $("[rel=tooltip]").tooltip();
         }
     }
     
function refreshSettings(){
    var queryString = "";
scrollPleaseWait('spinner_admin');
    ajaxRequest("/admin/setUpConfig",queryString,setupHandler);
}
function setupHandler(data){
scrollPleaseWaitClose('spinner_admin');
    if(data.status == "success"){
        window.location = "/admin/networkConfig";
    }
}

 /** Author:Praneeth
 *  Method:getEmailConfigurationDetails
 *  @param: get the list of Email configured list
 */

   function getEmailConfigurationDetails() {
    ajaxRequest("/admin/getEmailConfigurationDetails", '', getEmailConfigurationDetailsHandler);
}
 function getEmailConfigurationDetailsHandler(data) {
     scrollPleaseWaitClose('spinner_admin');
    var item = {
        'data': data
    };
    
    $("#emailConfigurationManagement_div").html(
            $("#emailCongfigurationTmp_render").render(item)
            );

    if (data.total.totalCount == 0) {
        $("#pagination").hide();
        $("#noRecordsTR").show();
    }

 }
     
  

/*
     * Handler for requesting new category
     */
    function emailConfigurationCreationHandler(data)
    {
       scrollPleaseWaitClose("categoryCreationSpinLoader");
        if(data.status == 'updatesuccess')
        { 
            var msg=data.data;
           $("#sucmsgForEmailConfiguration").html(msg);
           $("#errmsgForEmailConfiguration").css("display", "none");  
           $("#sucmsgForEmailConfiguration").css("display", "block");
           $("#sucmsgForEmailConfiguration").fadeOut(3000,function(){
           $("#addNewEmailConfiguration").modal('hide');
        }); 
           getEmailConfigurationDetails();
        }
        if(data.status == 'updatefail')
        {
            var msg=data.data;

            $("#sucmsgForEmailConfiguration").css("display", "none");
            $("#errmsgForEmailConfiguration").css("display", "block");
            $("#errmsgForEmailConfiguration").html(msg);
            $("#errmsgForEmailConfiguration").fadeOut(3000,function(){
        }); 
        }
        if(data.status =='success'){
            var msg=data.data;
            $("#sucmsgForEmailConfiguration").html(msg);
            $("#sucmsgForEmailConfiguration").css("display", "block");
            $("#errmsgForEmailConfiguration").css("display", "none");
            $("#emailConfigurationCreation-form")[0].reset();
             $("#sucmsgForEmailConfiguration").fadeOut(3000,function(){
            $("#addNewEmailConfiguration").modal('hide');
        }); 
           getEmailConfigurationDetails();
        }
        if(data.status == 'error'){
            var lengthvalue=data.error.length; 
            var msg=data.data;
            var error=[];
            if(msg!=""){  
                    $("#errmsgForEmailConfiguration").html(msg);
                    $("#errmsgForEmailConfiguration").css("display", "block");
                    $("#sucmsgForEmailConfiguration").css("display", "none");
                    $("#errmsgForEmailConfiguration").html(msg);
                    $("#errmsgForEmailConfiguration").css("display", "block");
                    $("#sucmsgForEmailConfiguration").css("display", "none");
       
            }else{
                    if(typeof(data.error)=='string'){
                
                        var error=eval("("+data.error.toString()+")");

                    }else{

                        var error=eval(data.error);
                }
       

                    $.each(error, function(key, val) {
                        if($("#"+key+"_em_")){  
                            $("#"+key+"_em_").text(val);                                                 
                            $("#"+key+"_em_").show();     
                             $("#"+key+"_em_").fadeOut(5000);
                          //  $("#"+key).parent().addClass('error');
                           }

                    });
                }
            }
        }
        
       /** Author:Praneeth
 *  Method:createNewEmailConfiguration
 *  @param: to category, will open the form in the popup
 */
 function createNewEmailConfiguration()
  {
    $('#NewEmailConfigurationReset').click();
    $("#EmailConfigurationCreationForm_id").val("");
    $("#sucmsgForEmailConfiguration,#errmsgForEmailConfiguration").hide();    
    $('#addNewEmailConfiguration').modal('show');
    $('#NewEmailConfigurationLabel').show();
    $('#UpdateEmailConfigurationLabel').hide();
    $("#newEmailConfigurationId").val('Create');
    $("#EmailConfigurationCreationForm_email"). removeAttr('readonly');
  }
  
  
   /** Author:Praneeth
 *  Method:editEmailConfigurationDetailsById
 *  @param: to edit already existing category based on the emailConfigId
 */

 function editEmailConfigurationDetailsById(id) {
    scrollPleaseWait('spinner_admin');
    var queryString = "Id="+id;
    ajaxRequest("/admin/editEmailConfigurationDetails", queryString, editEmailConfigurationDetailsHandler)
 }
 
 /** Author:Praneeth
 *  Method:editEmailConfigurationDetailsHandler
 *  @param: handler to edit already existing category based on the emailConfigId
 */
 function editEmailConfigurationDetailsHandler(data) {
     scrollPleaseWaitClose('spinner_admin');
    $('#NewEmailConfigurationReset').click();
    
    var emailConfigurationDetails = data.data;   
    $("#EmailConfigurationCreationForm_id").val(emailConfigurationDetails.id);
    $("#EmailConfigurationCreationForm_email").val(emailConfigurationDetails.Email);
    $("#EmailConfigurationCreationForm_password").val(emailConfigurationDetails.Password);
    $("#EmailConfigurationCreationForm_smtpaddress").val(emailConfigurationDetails.SMTPAddress);
    $("#EmailConfigurationCreationForm_port").val(emailConfigurationDetails.Port);
    $("#EmailConfigurationCreationForm_host").val(emailConfigurationDetails.Host);
    $("#EmailConfigurationCreationForm_encryption").val(emailConfigurationDetails.Encryption);
    $('#addNewEmailConfiguration').modal('show');
    $('#NewEmailConfigurationLabel').hide();
    $('#UpdateEmailConfigurationLabel').show();
    $("#newEmailConfigurationId").val('Update');
    $("#EmailConfigurationCreationForm_email").attr('readonly','readonly');
   
    $('#errmsgForEmailConfiguration').hide();
    $('#sucmsgForEmailConfiguration').hide();
 }

/** Author:Praneeth
 *  Method:getTemplateConfigurationDetails
 *  @param: get the list of template configured list
 */

   function getTemplateConfigurationDetails() {
    ajaxRequest("/admin/getTemplateConfigurationDetails", '', getTemplateConfigurationHandler);
}
function getTemplateConfigurationHandler(data) {
     scrollPleaseWaitClose('spinner_admin');
    var item = {
        'data': data
    };
     
    $("#templateManagement_div").html(
            $("#templateCongfigurationTmp_render").render(item)
            );
    if (data.total.totalCount == 0) {
        $("#pagination").hide();
        $("#noRecordsFound").show();
    }
 }
 
       /** Author:Praneeth
 *  Method:createNewTemplateConfiguration
 *  @param: to category, will open the form in the popup
 */
 function createNewTemplateConfiguration()
  {
    $('#NewTemplateConfigurationReset').click();
    $("#templateConfigurationCreationForm").val("");
    $("#sucmsgForTemplateConfiguration,#errmsgForTemplateConfiguration").hide();   
    $('#addNewTemplateConfiguration').modal('show');
    $('#NewTemplateConfigurationLabel').show();
    $('#UpdateTemplateConfigurationLabel').hide();
    $("#newTemplateConfigurationId").val('Create');
    $("#TemplateConfigurationCreationForm_title"). removeAttr('readonly');
  }
  
  
    function templateConfigurationCreationHandler(data)
    {
       scrollPleaseWaitClose("categoryCreationSpinLoader");
        if(data.status == 'updatesuccess')
        { 
            var msg=data.data;
           $("#sucmsgForTemplateConfiguration").html(msg);
           $("#errmsgForTemplateConfiguration").css("display", "none");  
           $("#TemplateConfigurationCreationForm_title").removeAttr('readonly');    
           $("#sucmsgForTemplateConfiguration").css("display", "block");
           $("#sucmsgForTemplateConfiguration").fadeOut(3000,function(){
           $("#addNewTemplateConfiguration").modal('hide');
        }); 
           //var startLimit = ((parseInt(g_pageNumber) - 1) * parseInt(g_pageLength));
           getTemplateConfigurationDetails();
        }
        if(data.status == 'updatefail')
        {
            var msg=data.data;

            $("#sucmsgForTemplateConfiguration").css("display", "none");
            $("#errmsgForTemplateConfiguration").css("display", "block");
            $("#errmsgForTemplateConfiguration").html(msg);
            $("#errmsgForTemplateConfiguration").fadeOut(3000,function(){
        }); 
        }
        if(data.status =='success'){
            var msg=data.data;
            $("#sucmsgForTemplateConfiguration").html(msg);
            $("#sucmsgForTemplateConfiguration").css("display", "block");
            $("#errmsgForTemplateConfiguration").css("display", "none");
            $("#templateConfigurationCreation-form")[0].reset();
            $("#errmsgForTemplateConfiguration").fadeOut(3000,function(){
            $("#addNewTemplateConfiguration").modal('hide');
        }); 
           var startLimit = ((parseInt(g_pageNumber) - 1) * parseInt(g_pageLength));
           getTemplateConfigurationDetails();
        }
        if(data.status == 'error'){
            var lengthvalue=data.error.length; 
            var msg=data.data;
            var error=[];
            if(msg!=""){  
                    $("#errmsgForTemplateConfiguration").html(msg);
                    $("#errmsgForTemplateConfiguration").css("display", "block");
                    $("#sucmsgForTemplateConfiguration").css("display", "none");
                    $("#errmsgForTemplateConfiguration").html(msg);
                    $("#errmsgForTemplateConfiguration").css("display", "block");
                    $("#sucmsgForTemplateConfiguration").css("display", "none");
       
            }else{
                    if(typeof(data.error)=='string'){
                
                        var error=eval("("+data.error.toString()+")");

                    }else{

                        var error=eval(data.error);
                }
       

                    $.each(error, function(key, val) {
                        if($("#"+key+"_em_")){  
                            $("#"+key+"_em_").text(val);                                                 
                            $("#"+key+"_em_").show();     
                             $("#"+key+"_em_").fadeOut(5000);
                          //  $("#"+key).parent().addClass('error');
                           }

                    });
                }
            }
        }
        
         /** Author:Praneeth
 *  Method:editEmailConfigurationDetailsById
 *  @param: to edit already existing category based on the emailConfigId
 */

 function editTemplateConfigurationDetailsById(id) {
    scrollPleaseWait('spinner_admin');
    var queryString = "Id="+id;
    ajaxRequest("/admin/editTemplateConfigurationDetails", queryString, editTemplateConfigurationDetailsHandler)
 }
 
 /** Author:Praneeth
 *  Method:editEmailConfigurationDetailsHandler
 *  @param: handler to edit already existing category based on the emailConfigId
 */
 function editTemplateConfigurationDetailsHandler(data) {
     scrollPleaseWaitClose('spinner_admin');
    $('#NewTemplateConfigurationReset').click();
    var templateConfigurationDetails = data.data;   
    $("#TemplateConfigurationCreationForm_id").val(templateConfigurationDetails.id);
    $("#TemplateConfigurationCreationForm_title").attr('readonly','readonly');
    $("#TemplateConfigurationCreationForm_title").val(templateConfigurationDetails.Title);
    $("#TemplateConfigurationCreationForm_filename").val(templateConfigurationDetails.FileName);
    $('#Email_RelatedTo :selected').val(templateConfigurationDetails.EmailConfigured);
    $('#addNewTemplateConfiguration').modal('show');
    $('#NewTemplateConfigurationLabel').hide();
    $('#UpdateTemplateConfigurationLabel').show();
    $("#newTemplateConfigurationId").val('Update');
   
    $('#errmsgForTemplateConfiguration').hide();
    $('#sucmsgForTemplateConfiguration').hide();
 }
 
 
function getPreviewTemplateHandler(data) {
    $('#newModal_body').html(data);
 }
 
 function previewTemplate(templateType)
 {
     $('#newModal').modal('show');
     $('#newModal_btn_primary').hide();
     $('#newModalLabel').text('Preview');
     $('#newModal_btn_close').hide();
     if(templateType == 'DailyDigest')
     {
         $('.modal-content').addClass('modalwidth638');
     }
     var queryString = "templateType="+templateType;
     ajaxRequest("/admin/getPreviewTemplate", queryString, getPreviewTemplateHandler,'html');
 }
 
        /** Author:Praneeth
 *  Method:previewEmailConfigDetails
 *  @param:emailConfigId
 */

 function previewEmailConfigDetails(id) {
    scrollPleaseWait('spinner_admin');
    var queryString = "Id="+id;
    ajaxRequest("/admin/editEmailConfigurationDetails", queryString, getpreviewEmailConfigDetailsHandler)
 }
 
 /** Author:Praneeth
 *  Method:getpreviewEmailConfigDetailsHandler
 *  @description: to view the email config details based on the emailConfigId
 */
 function getpreviewEmailConfigDetailsHandler(data) {
     scrollPleaseWaitClose('spinner_admin');
    var item = {
        'data':data
    };
     $("#myModal_body").html(
            $("#emailConfigDetailsPreview_render").render(item)
            );
    $("#myModalLabel").html("Email Account Details");
    $("#myModal_footer").hide();
    $("#myModal").modal('show');
 }
 /* Author Rahul 
  *  Methods for Handling the News Objects in Content Management Section
  * */
 function saveEditorial(postId,text,hashtags,mentions) {
    var queryString = {postId:postId,EditorialCoverage:text,hashTagString:hashtags,mentions:mentions};    
    ajaxRequest("/admin/saveEditorial", queryString, function(data){saveEditorialHandler(data,queryString)});
    
}
function saveEditorialHandler(data,queryString)
{   
     $('.EC'+queryString.postId).hide();
     $('.EDCRO'+queryString.postId).fadeIn();
     var editorailCoverage=data.editorial;
     if(data.editorialLength>240)
     {
     
     editorailCoverage=data.editorial+'<a  class="showmore" data-id="'+queryString.postId+'">&nbsp<i class="fa  moreicon moreiconcolor">'+Translate_Readmore+'</i></a>';
     }
      
     $('.EDCRO'+queryString.postId).html(editorailCoverage);
     applyLayoutContent();
}

function manageCuratedPost(postId) {
  var data_p = postId.split('_');
  var title="";
  if(data_p[2]!="undefined"){
     title=data_p[2];
  }
    var queryString = {postId:data_p[1],operation:data_p[0],Title:title};
    ajaxRequest("/admin/managecuratedpost", queryString, function(data){manageCuratedPostHandler(postId)});
}
function manageCuratedPostHandler(data)
{
    var data_p = data.split('_');
    if(data_p[0]=='D')
    {
        closeModelBox();
        $("#"+data_p[1]).animate({
        opacity: 0,
        }, 1500, function() {
            $("#"+data_p[1]).remove();
            applyLayoutContent();  
        });
    }
    else if(data_p[0]=='R')
    {
        $("#E_"+data_p[1]).closest('.customicons').append(addStats(data_p[1]));
        $("#E_"+data_p[1]).parent('.cus_strip').append(addOperations(data_p[1]));
        $('#'+data).remove();
//        $("#E_"+data_p[1]).remove();
        $("#D_"+data_p[1]).remove();
        if(!detectDevices()){
            $("[rel=tooltip]").tooltip();
         }
    }
    else if(data_p[0]=='MASFI')
    {
        $("#MASFI_"+data_p[1]).removeClass('cursor').css({'background':'#ccc','margin-left':'3px'});
    }
     else if(data_p[0]=='N2S')
    {
        $("#N2S_"+data_p[1]).removeClass('cursor').css({'background':'#ccc','margin-left':'3px'});
    }
     else if(data_p[0]=='PB')
    {
      closeModelBox();
      $("#"+data_p[1]).animate({
        opacity: 0,
        }, 1500, function() {
            $("#"+data_p[1]).remove();
            applyLayoutContent();  
        });
    }
    else
    {
    applyLayoutContent();  
    
    }
}
$(".unfollown").live('click',function()
    { 
        getDetailsNewsPage($(this));
    });
$(".unlikesn").live('click',function()
    { 
        getDetailsNewsPage($(this));    
    });
$(".commentsn").live('click',function()
    { 
        getDetailsNewsPage($(this));
    });
$(".customcontentarea").live('click',function()
    { 
        getDetailsNewsPage($(this));
    });   
    $(".custimage").live('click',function()
    { 
        getDetailsNewsPage($(this));
    });
    
    $("#NDescription").live('click',function()
    { 
        getDetailsNewsPage($(this));
    }); 

    
        
function getDetailsNewsPage(obj)
{
            var postId = $(obj).attr('data-postid');
            var categoryType = $(obj).attr('data-categoryType');
            var postType = $(obj).attr('data-postType');
            var newsId = $(obj).data('id');
            var showDivId = "newdetaildiv",
            hiddenDivId = "newscontentdiv";
            renderNewsDetailedPage(showDivId,hiddenDivId,newsId,postId,categoryType,postType);
}

function addOperations(obj)
{
return '<a class="cursor"  id="N2S_'+obj+'" data-id="N2S_'+obj+'"><i data-placement="bottom" rel="tooltip"  data-original-title="Notify Users" class="fa fa-bullhorn" ></i></a><a class="cursor"  id="MASFI_'+obj+'" data-id="MASFI_'+obj+'"><i  data-placement="bottom" rel="tooltip"  data-original-title="Mark As Featured Item" class="fa fa-star"></i></a><a class="cursor"  id="PB_'+obj+'" data-id="PB_'+obj+'"><i data-placement="bottom" rel="tooltip"  data-original-title="Pullback News" class="fa fa-mail-reply"></i></a>';
}
function addStats(obj)
{
return '<div class="cus_strip" style="float:left" id="SGRAPH_'+obj+'"><div class="social_bar" style="border:0px;margin:0px" data-id="'+obj+'" data-postid="'+obj+'" data-postType="11" data-categoryType="8" ><span style="cursor:pointer"><i><img src="/images/system/spacer.png" class="tooltiplink unfollown" data-placement="bottom" rel="tooltip"  data-original-title="Followers Count" data-id="'+obj+'" data-postid="'+obj+'" data-postType="11" data-categoryType="8" ></i><b>0</b></span><span style="cursor:pointer"><i><img  class="tooltiplink unlikesn"   data-placement="bottom" rel="tooltip"  data-original-title="Love Count" src="/images/system/spacer.png" data-id="'+obj+'" data-postid="'+obj+'" data-postType="11" data-categoryType="8" ></i><b >0</b></span><span style="cursor:pointer"><i><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="Comments Count" class="tooltiplink commentsn " data-id="'+obj+'" data-postid="'+obj+'" data-postType="11" data-categoryType="8" ></i><b>0</b></span></div></div>';
}

$("#statusType").live("change", 
       function(){           
            var userId = $(this).data('userid');
            var value = $(this).find(":selected").val();
           
            if(value==2){
              showSuspendUserPopUp(userId,value);
            }else{
                 scrollPleaseWait('spinner_admin');   
             changeStatusType(userId,value);        
            }
            
    }
 );
 
 $("#curbsidecategoryStatus").live("change", 
       function(){           
            var id = $(this).data('id');
            var value = $(this).find(":selected").val();
            scrollPleaseWait('spinner_admin');            
            changeCurbsideCategoryStatusType(id,value)
    }
 );
 $("#helpIconStatus").live("change", 
       function(){           
            var id = $(this).data('id');
            var value = $(this).find(":selected").val();
            scrollPleaseWait('spinner_admin');            
            changehelpIconDescriptionStatusType(id,value)
    }
 );
 function getFeacturedItemNews(){
    var modelType = 'info_modal';
        var title = 'Post Featured Item';
      
        var content = "<label>Featured Item Title<label> \
                       <input class='textfield span3' type='text' id='featured_Item_title' maxlength='100' value="+$("#FeaturedTitleHidden").val()+" />\n\
                       <div class='control-group controlerror'> <div style='display: none;' id='featured_item_error' class='errorMessage'>Featured Item Title cannot be blank</div> </div>";
        var closeButtonText = 'Close';
        var okButtonText = 'Submit';
       
        var okCallback = setFeacturedItemNewsTitle;
         openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, '');
          $("#featured_Item_title").val($("#FeaturedTitleHidden").val());
}

function setFeacturedItemNewsTitle(){
     if($("#featured_Item_title").val()==""){
        
        $("#featured_item_error").show();
        $("#featured_item_error").fadeOut(5000);
    }
    else{
       $("#FeaturedTitleHidden").val($("#featured_Item_title").val());
       
        manageCuratedPost($("#FeaturedTitleHidden_id").val()+"_"+$("#FeaturedTitleHidden").val());
       
       closeModelBox();
    }
}


function changeUserType(UserId,UserTypeId){ 
 
    var queryString = "UserId="+UserId + "&UserTypeId="+UserTypeId;
    ajaxRequest("/admin/getUserType",queryString,function(data){getUserTypeHandler(data, UserId);},"html");
}

function getUserTypeHandler(data, userId){

     $("#myModal_body").html(data);
    $("#myModalLabel").html("Advanced options");
    $("#myModal_saveButton").unbind("click");
    $("#myModal_saveButton").bind("click", function(){
        saveUserType(userId);
    });
    $("#myModal_saveButton").html("Save");
    $("#myModal_footer").show();
    $("#myModal_message").hide();
    $("#myModal").modal('show');
}


function saveUserType(userId){
    var UserIdentityType = $.trim($('#UserIdentityType').val());
  //  scrollPleaseWait("advanceOptionsSpinner","usermanagement_div");
    var queryString = "userId="+userId+"&SelectedTypeValue="+UserIdentityType;
    ajaxRequest("/admin/updateUserType",queryString,saveUserTypePreveligesHandler);
}
function saveUserTypePreveligesHandler(data){
   
  //  scrollPleaseWaitClose("advanceOptionsSpinner");
    if(data.status == "success"){
        $("#myModal_message").addClass("alert alert-success");
        $("#myModal_message").html(data.message);
        $("#myModal_message").show();
        $("#myModal_message").fadeOut(3000,function(){
            $("#myModal_saveButton").unbind("click");
            $("#myModal").modal('hide');
        });        
    }else{
        $("#myModal_message").addClass("alert alert-error");
        $("#myModal_message").html(data.message);
        $("#myModal_message").show();
        $("#myModal_message").fadeOut(3000,"");
    }
}
function blockOrReleaseAbusedComment(input){
    var queryString = {postId:input.postId,commentId:input.commentId,actionType:input.actionType,categoryType:input.categoryType,networkId:input.networkId,CommentCreatedUserId:input.CommentCreatedUserId};
    ajaxRequest("/admin/blockOrReleaseAbusedComment",queryString,function(data){blockOrReleaseCommentHandler(data,input);});
}
function blockOrReleaseCommentHandler(json, input){
    closeModelBox();
    if(json.status=="CommentReleased"){
        $("#comment_"+input.postId+"_"+input.commentId).animate({
        opacity: 0,
        }, 1500, function() {
            $("#comment_"+input.postId+"_"+input.commentId).remove();
        });
    }else if(json.status=="PostReleased"){
        $("#postitem_"+input.postId).animate({
        opacity: 0,
        }, 1500, function() {
            $("#postitem_"+input.postId).remove();
            if($('#postsDisplayDiv div.post.item').length<=0){
                $('#postsDisplayDiv').addClass('NPF');
                $('#postsDisplayDiv').html('<center>No posts found</center>');
            }
        });
    }
}
function countryChangePopup(userId) {
    scrollPleaseWait('spinner_admin');
    var queryString = {
                        UserId:userId
                    };
    ajaxRequest('/admin/getCountryChangeData', queryString, countryChangePopupHandler);
}

function countryChangePopupHandler(data) {
    scrollPleaseWaitClose('spinner_admin');
    if(data.status=="success"){
        $("#myModal_body").html(data.data);
        $("#myModalLabel").html("Change Country");
        $("#myModal_footer").hide();
        $("#myModal").modal('show');
    }else{
        
    }
}
 function acceptCountryChange(userId, countryId) {
    scrollPleaseWait('spinner_admin');
    var queryString = {
                        UserId:userId,
                        CountryId:countryId
                    };
    ajaxRequest('/admin/acceptCountryChange', queryString, acceptCountryChangeHandler);
}

function acceptCountryChangeHandler(data) {
    scrollPleaseWaitClose('spinner_admin');
    if(data.status=="success"){
        $("#sucmsgForCountryChange").html(data.data).show().fadeOut(3000,function(){
             $("#countryChangeLink_"+data.userId).remove();
             $("#myModal").modal('hide');
        }); 
    }
}
function rejectCountryChange(userId){
    scrollPleaseWait('spinner_admin');
    var queryString = {
                        UserId:userId
                    };
    ajaxRequest('/admin/rejectCountryChange', queryString, rejectCountryChangeHandler);
}
function rejectCountryChangeHandler(data) {
    scrollPleaseWaitClose('spinner_admin');
    if(data.status=="success"){
        $("#sucmsgForCountryChange").html(data.data).show().fadeOut(3000,function(){
             $("#countryChangeLink_"+data.userId).remove();
             $("#myModal").modal('hide');
        }); 
    }
}


function showSuspendUserPopUp(userId,value){
    var modelType = 'info_modal';
        var title = 'Conversations for the user';
        var content = "Keep the Conversations by this user";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var okCallback = changeStatusType;
          var param ={ userId: userId,value:value};         
         openModelBoxForSuspendUser(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
}
function openModelBoxForSuspendUser(modelType, title, content, closeButtonText, okButtonText, okCallback, param){ 
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
            g_keepConversations=1;
            okCallback(param.userId,param.value);
            closeModelBox();
        });
         $("#newModal_btn_close").unbind("click");
        $("#newModal_btn_close").bind("click", function(){
            g_keepConversations=0;
            okCallback(param.userId,param.value);
            closeModelBox();
        });
        
    }
    function closeModelBox(){ 
    $("#newModal").modal('hide');
}
}

function createBroadCastNotificationForm(){ 
   ajaxRequest("/admin/createBroadCastNotifications","",createBroadCastNotificationFormHandler);
}  
function createBroadCastNotificationFormHandler(data){

     $("#myModal_bodyAd").html(data.htmlData);
     $("#myModalLabelAd").html("Create BroadCast Notification");
     $('#myModelDialogAd').css("width","50%");
     $("#myModal_footerAd").hide();
     $("#myModalAd").modal('show');

}
function createBroadCastNotification(){ 
   scrollPleaseWait('advertisementSpinner');
   var queryString = $('form[id=bcastNotificationCreation-form]').serialize();
   ajaxRequest("/admin/createBroadCastNotifications",queryString,createBroadCastNotificationsHandler);
}  
function createBroadCastNotificationsHandler(data){
    scrollPleaseWaitClose("advertisementSpinner");
     var data=eval(data); 
      var error = [];
        if(data.status =='success'){
           var msg=data.data;
            $("#sucmsgForBD").html(msg);
            $("#sucmsgForBD").css("display", "block");
            $("#errmsgForBD").css("display", "none");
            $("#sucmsgForBD").fadeOut(3000).promise().done(function(){
                loadBroadCastNotificatonsForAdmin(0,"","");
                $("#myModalAd").modal('hide');
            });
        }
        else{
            var error = eval("(" + data.error.toString() + ")");
            $.each(error, function(key, val) {
                if ($("#" + key + "_em_")) {
                    $("#" + key + "_em_").text(val);
                    $("#" + key + "_em_").show();
                    $("#" + key + "_em_").fadeOut(5000);
            }

        });
        }

     

}

/*
 * @Praveen add New Test taker 
 */
    function newEmployersPopup(){
        scrollPleaseWait("spinner_survey_5");
        ajaxRequest("/user/loadSurveySchedule", "surveyId=5", function(data) {
            renderLoadSurveyScheduleHandler(data, '556ee4d3900cecfe048b456b')
        }, "html");
    }
    function renderLoadSurveyScheduleHandler(html, surveyId) {
        scrollPleaseWaitClose("spinner_survey_" + surveyId);
        $("#newModal .modal-dialog").removeClass('info_modal');
        $("#newModal .modal-dialog").removeClass('alert_modal');
        $("#newModal .modal-dialog").removeClass('error_modal');
        $("#newModalLabel").html("New Test Taker");
        $("#newModal_footer").hide();
        $("#newModal_body").html(html);
        $("#newModal").modal('show');
    }
    
    /*
     * @Invite users for test paper start
     */
    function testPaperForInvite(){
        //scrollPleaseWait("spinner_survey_5");
        //ajaxRequest("/testPaper/inviteUsers", "", function(data) {
        //    renderInviteUsersHandler(data, '')
        //}, "html");
        $("#newModal .modal-dialog").removeClass('info_modal');
        $("#newModal .modal-dialog").removeClass('alert_modal');
        $("#newModal .modal-dialog").removeClass('error_modal');
        $("#newModalLabel").html("Invite Test taker");
        $("#newModal_footer").hide();
        $("#newModal_body").html("data here");
        $("#newModal").modal('show');
    }
    function renderInviteUsersHandler(html) {
        $("#newModal .modal-dialog").removeClass('info_modal');
        $("#newModal .modal-dialog").removeClass('alert_modal');
        $("#newModal .modal-dialog").removeClass('error_modal');
        $("#newModalLabel").html("Invite Test taker");
        $("#newModal_footer").hide();
        $("#newModal_body").html("data here");
        $("#newModal").modal('show');
    }
    
    /*
     * @Invite users for test paper end
     */
    
    