var CurbsidepostUploadedFiles=new Array();
var g_postIds = 0;
var g_postDT = 0;
var g_iv = 0;
var g_streamId=0;
var g_pflag =0;
function CurbsidePostsend(){
    var editorObject = $("#editable.inputor");
    if(validateAtMentions(editorObject)){
        if($("#editable").text().length>0){
            if($.trim($('#editable').text()).length>0){
             $("#CurbsidePostForm_Description").val(getEditorText(editorObject)); 
         }else{
           
           $("#CurbsidePostForm_Description").val('');
         }
         var artifacts="";
            if(typeof globalspace["CurbsidePostForm_UploadedFiles"] != 'undefined'){
                artifacts = globalspace["CurbsidePostForm_UploadedFiles"];
            }
         
            $('#CurbsidePostForm_Artifacts').val(artifacts);
          
        var atMentions = getAtMentions(editorObject);
        $('#CurbsidePostForm_Mentions').val(atMentions);
        var hashtagString = getHashTags(editorObject);
        $('#CurbsidePostForm_HashTags').val(hashtagString);
        $('#CurbsidePostForm_IsWebSnippetExist').val(globalspace['IsWebSnippetExistForPost']);
         $('#CurbsidePostForm_WebUrls').val(globalspace['weburls']);
        var data = $("#curbsidePost-form").serialize();
        ajaxRequest('/curbsidePost/createCurbsidepost', data, function(data){sendCurbsidePostHandler(data,$('#CurbsidePostForm_IsFeatured').val())},"json",curbsidePostBeforesend);

        }else{
            displayErrorMessage("CurbsidePostForm_Description",Translate_Description_cannot_be_blank);
        }
    }else{
        displayErrorMessage("CurbsidePostForm_Description",getAtMentionErrorMessage(editorObject));
    }
}
function curbsidePostBeforesend(){
     scrollPleaseWait("curbsidepostSpinLoader","curbsidePost-form");
}
/*
 * sendCurbsidePostHandler() is used to display the success/error message when a post is posted
 * It will be called after posting the post
 * @author Haribabu
 */
function sendCurbsidePostHandler(data,isFeatureType){
    scrollPleaseWaitClose("curbsidepostSpinLoader");
    if (data.status == "success") {
        $('#editable').addClass('placeholder');
        $("#editable").html(" ");
        $("#editable").css("min-height","20px");
        $('.iisfeatured').val(0);
        $(this).removeClass('featureditemenable').addClass('featureditemdisable');
        $(this).attr('data-original-title', Translate_MarkAsFeatured);
        $('#curbsidedropdown').find('span').text(Translate_Curbside_Post_Select_Category);
        removeErrorMessage("CurbsidePostForm_Description");
        $("#sucmsgForStream").html(Translate_CurbsidePost_Saving_Success);
        $("#sucmsgForStream").show();
        $("#editor-toolbar-editable").hide();
        $("#sucmsgForStream").fadeOut(3000, "");        
        $("#forgotReset").trigger('click');
        clearFileUpload("CurbsidePostForm");
        $('#CurbsidePostForm_Category').val();
        $('#preview_CurbsidePostForm').hide();
        $('#previewul_CurbsidePostForm').hide();
        $('#previewul_CurbsidePostForm').html(" ");
        globalspace['hashtag_editable']=new Array();
        globalspace['at_mention_editable']=new Array();
        if (document.getElementById("snippet_main")) {
            document.getElementById('snippet_main').style.display = 'none';
            $("#snippet_main").html("");
        }

       $("#curbsidePostsDiv").show();
        $("#CategoryPostsDiv").hide();
        $('#CategoryPostsDiv').empty();
        $('#crubsidefilter').removeClass('in');
         $('#crubsidefilter').css('height','0');
        $('li.curbside_hashtag').removeClass('active');
        $('li.curbside_hashtag b').hide();
        $('li.curbside_category').removeClass('active');
        $('li.curbside_category b').hide();
     
         if(g_curbside_hashtagID!="" || g_curbside_categoryID!=""  ){
              $(window).unbind("scroll");
               page = 1;
               isDuringAjax=false;
               g_curbside_categoryID="";
        g_curbside_hashtagID="";
         getCollectionData('/curbsidePost/getcurbsideposts', 'StreamPostDisplayBean', 'curbsidePostsDiv', Translate_NoPostsFound,Translate_Thas_all_folks);
       
         }
       
//         if(isFeatureType==1){
//            getFeaturedItems();   
//        }
        setTimeout(function(){ // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
            if(typeof socketCurbside !== "undefined"){
                isThereReady = true;
                socketCurbside.emit('getLatestCurbsidePostRequest',loginUserId,userTypeId,postAsNetwork,sessionStorage.old_key);
            }
//            socketCurbside.emit('getLatestPostRequest4All',loginUserId,userTypeId,postAsNetwork,sessionStorage.old_key,gPage);

        },1000);

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
    }
    
}

function  getCategories(){
    var queryString = "";
    ajaxRequest("/curbsidePost/categoriesdetails", queryString, CategoriesResultHandler);   
}
function CategoriesResultHandler(data){
    var item = {
        'categories':data.categories,
        'hashtags':data.hashtags,
        'hashtagscount':data.hashtagscount,
        'categoriescount':data.categoriescount
        
    };

    $( "#categoriesandhashtagdiv" ).html(
    $("#categoriesTmpl").render(item)
); 

}

function ClearCurbPostForm(){
    $("#editable").html(" ");
    $("#editable").css("min-height","20px");
    $("#curbsidePost-form")[0].reset();
    $('#curbsidedropdown').find('span').text(Translate_Curbside_Post_Select_Category);
    $('.iisfeatured').val(0);
    $('.isfeatured').removeClass('featureditemenable').addClass('featureditemdisable');
    $('.isfeatured').attr('data-original-title',Translate_MarkAsFeatured);
    clearFileUpload("CurbsidePostForm");
    $('#CurbsidePostForm_Artifacts').val('');
    $('#CurbsidePostForm_Category').val("XX");
    $('#preview_CurbsidePostForm').hide();
    $('#previewul_CurbsidePostForm').hide();
    $('#previewul_CurbsidePostForm').html(" ");
    globalspace['hashtag_editable']=new Array();
    globalspace['at_mention_editable']=new Array();
    if (document.getElementById("snippet_main")) {
        document.getElementById('snippet_main').style.display = 'none';
        $("#snippet_main").html("");
    }
    $('#editable').addClass('placeholder');
    $("#button_block").hide();
    $("#editor-toolbar-editable").hide();
   globalspace['IsWebSnippetExistForPost']=0;
}

function curbsideOnloadEvents(){
    $('#editable').freshereditor({editable_selector: "#editable", excludes: ['removeFormat', 'insertheading4']});
    $("#editable").freshereditor("edit", true);
    $('#editor-toolbar-editable').addClass('editorbackground');
    
    $('input[type=text]').focus(function() {

        $('#' + this.id + '_em_').fadeOut(2000);
    });

    $("#curbsidepost").addClass('active');
    $("#editable").click(function()
    {
        $('#CurbsidePostForm_Description_em_').fadeOut(2000);

        $('#CurbsidePostForm_Artifacts_em_').fadeOut(2000);

        $("#button_block").show();
        $(this).animate({"min-height": "50px"}, "fast");
        $("#button_block").slideDown("fast");
        $("#editor-toolbar-editable").show();
        $(this).removeClass("Curbsideplaceholder");
        return false;
    });
    $('.placeholder').on('input', function() {
        if ($(this).text().length > 0) {
            $(this).removeClass('placeholder');
        } else {
            $(this).addClass('placeholder');
        }
    });    
}
 function getCategoryPosts(categoryId){
     scrollPleaseWait('categories_spinner');
      globalspace.previousStreamIds = "";
    $(window).unbind("scroll");
    /* reinitializing the left menu adjustment scroll*/
    lastScroll=0;
    $(window).scroll(scrollEvent);
    /* reinitializing the left menu adjustment scroll*/
    page = 1;
    isDuringAjax = false;
    g_curbside_categoryID = categoryId;
    $('#curbsidePostsDiv').empty();
    $('#CategoryPostsDiv').empty();
//    $('li.curbside_category').removeClass('active');
//    $('li.curbside_category b').hide();
//     $('li.curbside_hashtag').removeClass('active');
//    $('li.curbside_hastag b').hide();
//     $('#curside_category_'+categoryId).css('display', '');
//     $('#curside_category_list_'+categoryId).addClass('active');
     var categoryName=$.trim($('#curbsideFilter_category_'+categoryId).html());
    getCollectionData('/curbsidePost/getcurbsideposts', 'CategoryId='+g_curbside_categoryID+'&StreamPostDisplayBean', 'CategoryPostsDiv', Translate_NoPostsFound,Translate_Thas_all_folks);
    $("#curbsidePostsDiv").hide();
    $("#CategoryPostsDiv").show();
    
    var ondata = "CloseFilterData('curside_category_list_" + categoryId + "','curside_category_" + categoryId + "')";
    var href = "";
    var onclckdata = "getCategoryPosts('" +categoryId+ "')";
    if ($("#categoryClickedDiv") != null && categoryName != null && categoryName != "undefined" && categoryName != "")
    {
        $("#categoryClickedDiv").show();
        $("#categoryClickedDiv").html("<a onclick= " + onclckdata + ">" + categoryName + "</a><i onclick=" + ondata + " >X</i>");
     
     }
    
    $("#c_filteractive").show();
    $("#c_filterinactive").hide();
    $('#crubsidefilter').removeClass('in');
    $('#crubsidefilter').css('height', '0px');
    
    
    
    // var queryString = "categoryId="+categoryId;
  // ajaxRequest("/curbsidePost/trackFilterByCategory",queryString,function(data){});

 }
 function getHashtagsPosts(hashtagId){
     scrollPleaseWait('categories_spinner');
      globalspace.previousStreamIds = "";
     $(window).unbind("scroll");
     /* reinitializing the left menu adjustment scroll*/
    lastScroll=0;
    $(window).scroll(scrollEvent);
    /* reinitializing the left menu adjustment scroll*/
    page = 1;
    isDuringAjax = false;
    g_curbside_hashtagID = hashtagId;
    $('#curbsidePostsDiv').empty();
    $('#CategoryPostsDiv').empty();
//       $('li.curbside_hashtag').removeClass('active');
//    $('li.curbside_hashtag b').hide();
//     $('li.curbside_category').removeClass('active');
//    $('li.curbside_category b').hide();
// 
//      $('#curside_hashtag_'+hashtagId).css('display', '');
//     $('#curbside_hashtag_list_'+hashtagId).addClass('active');
   // $('.categorymemenuhelp').css('display', 'block');
    getCollectionData('/curbsidePost/getcurbsideposts','HashtagId='+g_curbside_hashtagID+'&StreamPostDisplayBean', 'CategoryPostsDiv', Translate_NoPostsFound,Translate_Thas_all_folks);
    $("#curbsidePostsDiv").hide();
    $("#CategoryPostsDiv").show();

    var hashtagName=$.trim($('#curbside_hashtag_list_'+hashtagId).attr('data-hashtag'));
    var ondata = "CloseFilterData('curbside_hashtag_list_" + hashtagId + "','curside_hashtag_" + hashtagId + "')";
    var href = "";
    var onclckdata = "getHashtagsPosts('" + hashtagId + "')";
    if ($("#categoryClickedDiv") != null && hashtagName != null && hashtagName != "undefined" && hashtagName != "")
    {
        $("#categoryClickedDiv").show();
        $("#categoryClickedDiv").html("<a onclick= " + onclckdata + ">" + hashtagName + "</a><i onclick=" + ondata + " >X</i>");
     
     }
    
    $("#c_filteractive").show();
    $("#c_filterinactive").hide();
    $('#crubsidefilter').removeClass('in');
    $('#crubsidefilter').css('height', '0px');
    
    
    
    
    var queryString = "hashtagId="+hashtagId;
   ajaxRequest("/curbsidePost/trackFilterByHashtag",queryString,function(data){});
 }
 
 /**
 * karteek .v
 * this is function is used to clear all interval which are not related to group stream...
 */
function ClearPostNodeIntervals(){
    clearInterval(postSocialStatsInterval);
    clearInterval(intervalIdNewpost);
}