 <h2 class="pagetitle"><?php echo Yii::t('translation','Advertisements'); ?></h2> 
<div class="searchgroups" >  
<input class="btn " id='addGroup' name="commit" type="submit" data-toggle="dropdown" value="<?php echo Yii::t('translation','New_Advertisements'); ?>" /> 
<div id="addNewAd" class="dropdown dropdown-menu actionmorediv actionmoredivtop newgrouppopup newgrouppopupdivtop"  >
    
</div>
</div>
<div id="advertisementMgmt">
    
    
</div>
  



<script type="text/javascript">
    var g_filterValue = "";
    var g_pageNumber = 1;
    var g_searchText = "";
    var g_startLimit = 0;
    var g_pageLength = 10;
    var g_page = 1;
    $("[rel=tooltip]").tooltip();
    loadAdvertisementsForAdmin(0,"","");
    var selectedBanner=null;
    //ajaxRequest('/advertisements/EditAdvertisement',"",newAdHandler);
function PreviewUploadedFile(id, fileName, responseJSON, type)
    {
        var data = eval(responseJSON);
        var html= '&nbsp;<span class="label" onclick="deleteAppended(this)"><button data-placement="bottom" rel="tooltip"  data-original-title="remove" class="close deletefilefromlist" data-dismiss="closef" type="button">×</button> <b style="margin-left:2px;padding-right:6px;vertical-align: middle">'+data.filename+'</b></span>';
        $('#uploadedfileslist').html(html).show();
        $("#AdvertisementForm_FileName").val(data.filename);
//        var queryString = "groupId=<?php //echo $groupPostModel->GroupId ?>&fileName="+fileName+"&groupName=<?php //echo $groupStatistics->GroupName?>";        
//        ajaxRequest("/group/saveUploadedFile", queryString, function(data){fileuploadHandler(data);});
    }
    function fileuploadHandler(data){
        if(data.data == "error"){
           $("#AdvertisementForm_emailserros_em_").removeClass().addClass("alert alert-error").html(data.msg).show().fadeOut(7000);
        }else{
            $("#AdvertisementForm_emailserros_em_").removeClass().addClass("alert alert-success").html("Imported Success").show().fadeOut(7000);
        }
    }
    function displayErrorForFile(message, type) {
         $("#AdvertisementForm_emailserros_em_").removeClass().addClass("alert alert-error").html(message).show().fadeOut(7000);
    }
    $("span.label button.deletefilefromlist").on('click',function(){
       var $this = $(this);        
       var id = $this.attr("data-id");       
       var queryString = "fileId="+id;
       if(id != null && id != "undefined"){
           scrollPleaseWait('uploadspinner');
            ajaxRequest("/group/deleteFromList", queryString, function(data){deleteFromListHandler(data,id);});
        }
        
    });
    
    
    function deleteFromListHandler(data,id){ 
        scrollPleaseWaitClose('uploadspinner');
        if(data.status == "success"){            
            $("#label_deletespan_"+id).remove();
        }
    }
    
    function deleteAppended(obj){
        $(obj).remove();
        $("#uploadedfileslist").hide();
        $("#AdvertisementForm_FileName").val("");
    }
    $(".groupfiledownload").on("click",function(){
        var $this = $(this);
        var filename = $this.data("originalfilename");
        window.location.href = "/group/downloadFile?filename="+filename;
    })
       

    function setBannerTemplateData(){ 
    if($('#AdvertisementForm_Url').val()===""){ 
                 var g_adImage = '/images/system/ad_creation_defaultbanner'+selectedBanner+".jpg" ;  
                 $('#AdvertisementForm_Url').val(g_adImage);   
               }
    }
    
     $("#addGroup").bind( "click touchstart", 
        function(){
            if($.trim($('#addNewAd').text()).length<=0){
                var data = {};
                ajaxRequest('/advertisements/EditAdvertisement',data,newAdHandler);
            }
        }
    );
    function newAdHandler(data){
        $("#myModal_bodyAd").html("");
        $("#addNewAd").html(data.htmlData);
        $('#AutoModeDiv').hide(); 
        $('#adTitle').hide(); 
        $('#requestedFields').hide();
        $('#addNewAd').show();
    }
    var extensions ='"jpg","jpeg","gif","png","tiff","swf","tif","TIF"';
    var bannerextensions ='"jpg","jpeg","gif","png","tiff","tif","TIF"';
    function ExternalPartyDLPreviewImage(id, fileName, responseJSON, type)
{
    var data = eval(responseJSON);    
    var  g_adImage = '/upload/advertisements/' + data.savedfilename;
    $('#ExternalPartyLogoPreview').attr('src', g_adImage);    
    $('#AdvertisementForm_ExternalPartyUrl').val('/upload/advertisements/' + data.savedfilename);
}
    function AdvertisementDLPreviewImage(id, fileName, responseJSON, type)
{
    var data = eval(responseJSON);    
    g_adImage = '/upload/advertisements/' + data.savedfilename;
    var preferences='';
    if(type=='GroupLogoInPreferences'){
        preferences = 'InPreferences';
    }
    $('#updateAndCancelGroupIconUploadButtons'+preferences).show();
    $('#groupIconPreviewId'+preferences).val('/upload/advertisements/' + data.savedfilename);    
    if(data.extension=="swf"){
          $('#groupIconPreviewId'+preferences).attr('src', '/images/system/swf.png');    
      }
      else if(data.extension=="mp4" || data.extension=="mov"){
     $('#groupIconPreviewId'+preferences).attr('src', '/images/system/video_img.png');    
    }
    else{
     $('#groupIconPreviewId'+preferences).attr('src', g_adImage);    
    }
    
    $('#AdvertisementForm_Url').val('/upload/advertisements/' + data.savedfilename);
    $('#AdvertisementForm_Type').val(data.extension);
    $('#previewicon').show();
    

}
function BannerDLPreviewImage(id, fileName, responseJSON, type)
{
    var data = eval(responseJSON);    
    var g_adImage = '/upload/advertisements/' + data.savedfilename;
    $('#Preview_'+type).val('/upload/advertisements/' + data.savedfilename);    
    if(data.extension=="swf"){
        $('#Preview_'+type).attr('src', '/images/system/swf.png');    
    }
    else if(data.extension=="mp4" || data.extension=="mov"){
        $('#Preview_'+type).attr('src', '/images/system/video_img.png');    
    }
    else{
        $('#Preview_'+type).attr('src', g_adImage);    
    }
    $('#AdvertisementForm_Url').val('/upload/advertisements/' + data.savedfilename);
}
function displayErrorForBannerAndLogo(message,type){

     if(type=='GroupLogo'){
        $('#GroupLogoError').html(message);
        $('#GroupLogoError').css("padding-top:20px;");
        $('#GroupLogoError').show();
        $('#GroupLogoError').fadeOut(6000)
     }else if(type=='ExternalPartyLogo'){
        $('#AdvertisementForm_ExternalPartyUrl_em_').html(message);
        $('#AdvertisementForm_ExternalPartyUrl_em_').show();
        $('#AdvertisementForm_ExternalPartyUrl_em_').fadeOut(6000)
        }
     
        else if(type=='GroupLogoInPreferences'){
         $('#GroupLogoErrorInPreferences').html(message);
        $('#GroupLogoErrorInPreferences').css("padding-top:20px;");
        $('#GroupLogoErrorInPreferences').show();
        $('#GroupLogoErrorInPreferences').fadeOut(6000)
     } else{
         if($('#Error_'+type).length>0){
            $('#Error_'+type).html(message);
            $('#Error_'+type).show();
            $('#Error_'+type).fadeOut(6000)
         }else{
            $('#GroupLogoError').html(message);
            $('#GroupLogoError').css("padding-top:20px;");
            $('#GroupLogoError').show();
            $('#GroupLogoError').fadeOut(6000)
        }

     }  
}
function advertisementHandler(data){
    scrollPleaseWaitClose("advertisementSpinner");
          var data=eval(data);   

        if(data.status =='success'){
            
            var msg=data.data;
            $("#sucmsgForAd").html(msg);
            $("#sucmsgForAd").css("display", "block");
            $("#errmsgForAd").css("display", "none");

            $("#sucmsgForAd").fadeOut(3000).promise().done(function(){
                loadAdvertisementsForAdmin(0,'','');
                closeEditAdvertisement();
            });
        }
        else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {
                $("#errmsgForAd").html(msg);
                $("#errmsgForAd").css("display", "block");
                $("#sucmsgForAd").css("display", "none");
                $("#errmsgForAd").fadeOut(5000);

            } else {
                
                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {

                    var error = eval(data.error);
                }


                $.each(error, function(key, val) {
                    if (key == "popupMessage") {


                        var modelType = 'info_modal';
                        var title = 'Confirmation';
                        var customString = "adunit";                        
                        if($("#AdvertisementForm_PremiumTypeId").val() == 1){
                            customString = "Premium Ad";
                        }
                        var adpage = $("#AdvertisementForm_id").val() == undefined ? "created" : "updated";
                        var content = "<div class='c_confirmad'><div class='c_header'>Your ad will be " + adpage + " but marked inactive for now.</div><div class='c_subheader1'> The reason is either:</div><ul class='c_list'><li>There is already another ad setup for the same position during the same time</li><li>There is a rotating "+customString+" setup for the same position and time and your new ad is not setup to be part of the rotating "+customString+".You can make necessary adjustments later and make the ad active at a later point.</li></ul></div>";
                        var closeButtonText = 'No';
                        var okButtonText = 'Yes';
                        var param = '';
                        openModelBox(modelType, title, content, closeButtonText, okButtonText, function() {
                            $("#DoesthisAdrotateHidden").val("ok");
                            $("#newGroupId").click();
                            closeModelBox();
                        }, param);
                        $("#newModal_btn_close").show();
                        $('#newModal').css("z-index", "1100");
                        $('.info_modal').css("top", "10%");

                    }
                    else {
                        if ($("#" + key + "_em_")) {
                            $("#" + key + "_em_").text(val);
                            $("#" + key + "_em_").show();
                            $("#" + key + "_em_").fadeOut(5000);
                            // $("#"+key).parent().addClass('error');
                        }
                    }

                });
            }
        }
    }
function closeAdvertisement(){
    $('#addNewAd').html("").hide();
}

function checkToLoadGroups(){
  
    var selectedValue=$('#DisplayPage :selected').text();
    if(selectedValue=='Group'){
        $('#GroupsList').show();
//        $('#StatusSpan').removeAttr("style");
    }else{
        $('#GroupsList').hide();
//        $('#StatusSpan').css("margin-left","2px");
    }
  
}
function displayRequestedFields(){
     $('#requestedParams').hide();
     $('#requestedp1').hide();
     $('#requestedp2').hide(); 
    var selectedValue=$('#RequestedFields :selected').each(function(i, selected){
     $('#requestedParams').show();
     if($(selected).text()=="UserId"){
        $('#requestedp1').show(); 
     }
     if($(selected).text()=="Display Name"){
        $('#requestedp2').show(); 
     } 
});

}
function loadAdvertisementsForAdmin(startLimit,filterValue,searchText){ 
         
         var queryString = 'startLimit='+startLimit+'&filterValue=' + filterValue+'&searchText=' + searchText+ "&pageLength=" + g_pageLength;
         
         ajaxRequest("/advertisements/GetAllAdvertisementsForAdmin",queryString,loadAdvertisementsForAdminHandler);
    
}

 function loadAdvertisementsForAdminHandler(data){
     
     $('#advertisementMgmt').html(data.htmlData);
     
     var totalCount=data.totalCount;
//     if(g_searchText!=undefined || !empty(g_searchText)){
//         $("#searchAdId").val()=g_searchText;
//     }else if(g_searchText==undefined){
//         $("#searchAdId").val()='';
//     }
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
    if (data.recordCount == 0) {
        $("#pagination").hide();
        $("#noRecordsTR").show();
    }
    $("#pagination").pagination({
        currentPage: g_page,
        items: totalCount,
        itemsOnPage: g_pageLength,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber, event) {            
            g_pageNumber = pageNumber;
            var startLimit = ((parseInt(pageNumber) - 1) * parseInt(g_pageLength));            
            loadAdvertisementsForAdmin(startLimit, g_filterValue, g_searchText);
        }

    });
    if($.trim(data.searchText) != undefined && $.trim(data.searchText) != "undefined" ){  
        
        $('#searchAdId').val(data.searchText);
    }
     
 }
 
 function searchAD(event) {
    
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        //scrollPleaseWait('spinner_admin');
        g_pageNumber=1;
        if ($.trim($("#searchAdId").val()) != "") {
            var searchText = $.trim($("#searchAdId").val());
            g_searchText = searchText;
            loadAdvertisementsForAdmin(0, '', g_searchText);            
        } else {
            g_searchText = "";
            loadAdvertisementsForAdmin(0,"","");
        }
        return false;

    }
}

function closeEditAdvertisement(){
    $('#addNewAd').html("").hide();
    $("#myModal_bodyAd").html('');
    $("#myModalAd").modal('hide');
}
$("#filter").live( "change", 
        function(){
    var value = $("#filter").val();
    var searchText = $("#searchAdId").val();
    g_searchText = searchText;
    g_filterValue = value;
    scrollPleaseWait('spinner_admin');
    g_pageNumber=1;
    loadAdvertisementsForAdmin(0, value, searchText);
    
        }
    );
    function showPreviewNew(){
    var displayPosition=$.trim($('#AdvertisementForm_DisplayPosition').val());
    var displayPage=$('#DisplayPage').val();
    var url=$('#AdvertisementForm_Url').val();
    var type=$('#AdvertisementForm_Type').val();
    
    if(displayPosition=="" || displayPage=="" || url==""){
        $("#errmsgForAd").html("please select position ,display page and artifact to check the preview");
        $("#errmsgForAd").css("display", "block");
        $("#sucmsgForAd").css("display", "none");
        $("#errmsgForAd").fadeOut(5000);
    }else {
        showPreview('',url,type,displayPosition,displayPage);
       
    }   
    }
    
   function loadOutSideUrlBox(){       
    var selectedValue=$('#SourceType :selected').text();
    $('#addServerAds1').hide();
    $('#addServerAds2').hide();
    $('#streamBundleAds').hide();
    $('#bannerTemplateDiv1').hide();
    $('#bannerTemplateDiv2').hide();
    $('#GroupLogo').hide();
    $('#uplloadAdPreview').hide();
    $("#imageWithTextDiv").hide();
    $('#LanguageList').hide();
    var selectedType=$('#AdTypeId :selected').val();  
    reloadLanguages();
    if(selectedValue=='Upload'){
        $('#GroupLogo').show();
        $('#redirectUrl').show();
        if(selectedType!='1'){
            $('#bannerTemplateDiv1').show();
        }
        $('#LanguageList').show();
        $('#uplloadAdPreview').show();
        if($('#groupIconPreviewId').attr('src')!=''){
          $('#previewicon').show();
         }
    }else if(selectedValue=='Stream Bundle Ads'){
        $('#streamBundleAds').show();
        $('#previewicon').hide();
        $('#redirectUrl').hide();
        $('#LanguageList').hide();
        $('#bannerOptions option[value=OnlyImage]').attr('selected','selected');        
    }else if(selectedValue=='Ad Server'){
        $('#addServerAds1').show();
        $('#addServerAds2').show();
        $('#LanguageList').show();
        if($('#groupIconPreviewId').attr('src')!=''){
          $('#previewicon').show();
         }
        $('#GroupLogo').show();
        $('#redirectUrl').show();
        if(selectedType!='1'){
          $('#bannerTemplateDiv1').show();
         }
        $('#uplloadAdPreview').show();
    }
   } 
   function loadAdType(){
        var selectedValue=$('#AdTypeId :selected').val();   
        $('#AutoModeDiv').hide(); 
         $('#adTitle').hide(); 
         $('#requestedFields').hide();
         $('#StreamAdDimension').hide();
         $('#addServerAds1').hide();
         $('#addServerAds2').hide();
         $('#streamBundleAds').hide();
         $('#requestedParams').hide();
         $('#timeInterval').hide();
         $('#AdunitGroup').hide();
         $('#isThisAdRotateCB').attr('checked',false);
         $('#redirectUrl').show();
         $('#bannerTemplateDiv1').hide();
         $('#bannerTemplateDiv2').hide();
         $('#uplloadAdPreview').hide();
         $('#SourceType option[value=Upload]').attr('selected','selected');
         $('#bannerOptions option[value=OnlyImage]').attr('selected','selected');
         $('#onlyTextContent').hide();
         $('#onlyTextTitle').hide();
         $('#externalPartyName').hide();
         $('#externalPartyLogo').hide();
         $('#isThisExternalParty').hide();
         $('#inlineTitle').html("Title");
         $('#isThisExternalPartyCB').attr('checked',false);
         $('#DisplayPage option[value=Home]').attr('selected','selected');
         $("#imageWithTextDiv").hide(); 
         $('#LanguageList').show();
         $('#sourceFowWidgetAd').show();
         $('#userSpecificDiv1').hide();
         $('#userSpecificDiv2').hide();
         $('#IsUserSpecificDiv1').hide();
         $('#IsUserSpecificDiv2').hide();
         $('#ClassificationDiv').hide();
         $('#dpd2Edit span.add-on').show();
         $('#dpd1Edit span.add-on').show();
         $("#AdvertisementForm_StartDate").val("");
         $("#AdvertisementForm_EndDate").val("");
         $('#DisplayPage').attr('disabled',false);
         $('#SourceType').attr('disabled',false);
         $('#bannerOptions').attr('disabled',false);
         $('#marketMainDiv').hide();
         $('#ClassificationDiv').css("margin", "");
         $('#StatusSpan').css("margin", "");
         $('#ExternalPartyDivCB span.checkbox').attr("style","background-position: 0px -50px;"); 
         $('#ExternalPartyCheckDiv').remove();         
         reloadLanguages();
        if(selectedValue=='1'){
         $('#AdunitGroup').show();
         $('#GroupLogo').show();
         $('#AutoModeDiv').show(); 
         $('#uplloadAdPreview').show();
         $('#premiumAdDivs').hide();
        }
        else if(selectedValue=='2'){ 
            $('#adTitle').show();
            $('#GroupLogo').show();
            $('#StreamAdDimension').show();
            $('#bannerTemplateDiv1').show();
            $('#GroupLogo').show();
            $('#uplloadAdPreview').show();
            $('#isThisExternalParty').show();
            $('#IsUserSpecificDiv1').show();
            if($('#AdvertisementForm_IsUserSpecific').val()==1){
                 $('#userSpecificDiv2').show();
                 $('#IsUserSpecificDiv2').show();
                
             }
             else{
               $('#userSpecificDiv1').show();
                $('#ClassificationDiv').show();
                 $('#userSpecificDiv2').show();
            }

         }
        else if(selectedValue=='3'){ 
            $('#adTitle').show();
            $('#GroupLogo').show();
             $('#requestedFields').show();
             $('#StreamAdDimension').show();
             $('#bannerTemplateDiv1').show();
             $('#GroupLogo').show();
             $('#uplloadAdPreview').show();
             $('#isThisExternalParty').show();
              $('#IsUserSpecificDiv1').show();
              if($('#AdvertisementForm_IsUserSpecific').val()==1){
                 $('#userSpecificDiv2').show();
                 $('#IsUserSpecificDiv2').show();
                
             }
             else{
               $('#userSpecificDiv1').show();
                $('#ClassificationDiv').show();
                 $('#userSpecificDiv2').show();
            }

        } else if(selectedValue=='4'){
            $('#adTitle').show();
            $('#dpd2Edit span.add-on').hide();
            $('#dpd1Edit span.add-on').hide();
            $('#DisplayPage option[value=Home]').attr('selected','selected');
            $('#DisplayPage').attr('disabled',true);
            $('#SourceType option[value=Uplaod]').attr('selected','selected');
            $('#SourceType').attr('disabled',true);
            $('#bannerOptions option[value=OnlyImage]').attr('selected','selected');
            $('#bannerOptions').attr('disabled',true);
            $('#bannerTemplateDiv1').show();
            $('#redirectUrl').hide();
            $('#marketMainDiv').show();
            $('#IsUserSpecificDiv1').show();
            if($('#AdvertisementForm_IsUserSpecific').val()==1){
                 $('#userSpecificDiv2').show();
                 $('#IsUserSpecificDiv2').show();
                
             }
             else{
               $('#userSpecificDiv1').show();
               $('#ClassificationDiv').show();
               $('#userSpecificDiv2').show();
            }
            $('#StatusSpan').css("margin", "auto");
        }
        if(selectedValue == 2){
            $("#premiumAdDivs").show();
        }else{
            $('#premiumAdDivs').hide();
        }
        
   }
   
   function loadbannerTemplates(){
       var selectedValue=$('#bannerOptions :selected').val(); 
        $('#bannerTemplateDiv2').hide();
        $('#GroupLogo').hide();
        $('#uplloadAdPreview').hide();
        $('#onlyTextContent').hide();
        $('#onlyTextTitle').hide();
        $("#imageWithTextDiv").hide(); 
        $('#previewiconUL').html("");
        $('#uplloadBannerPreview').html("");
        reloadLanguages();
       if(selectedValue==="ImageWithText"){
           $('#bannerTemplateDiv2').show();
           $('#LanguageList').show();
           if(selectedBanner!=null){
                $("#imageWithTextDiv").show(); 
           }
         }
       else if(selectedValue==="OnlyImage"){
           $('#GroupLogo').show();
           $('#uplloadAdPreview').show();
           $('#LanguageList').show();
       }
       else{
           $('#onlyTextContent').show();
           $('#onlyTextTitle').show();
           $('#LanguageList').hide();
        }
     }
    $('#AutoModeDiv span.checkbox').bind("click",
     function(){
         $('#timeInterval').hide();
         if($('#isThisAdRotateCB').is(':checked')){
             $('#timeInterval').show();
         }
     }
    
     );
     $('#ExternalPartyDivCB span.checkbox').bind("click",
     function(){
         $('#externalPartyName').hide();
         $('#externalPartyLogo').hide();
         $('#inlineTitle').html("Title");
         
         if($('#isThisExternalPartyCB').is(':checked')){
            $('#externalPartyName').show();
            $('#externalPartyLogo').show();
            $('#inlineTitle').html("External Party Context");
         }
     }
    
     );
  $('#titleBanner45').live('click', function() {
      $("#contentBanner45").removeClass('addbannerpadding_active');
      $("#titleBanner45").removeClass('addbannerpadding_active');
      $('.demo2').minicolors({
          hide: function() {}
});
          
  });

 $('#AdBannerTitle').bind("cut copy paste", function(e) {
            var $this = $(this); //save reference to element for use laster
            setTimeout(function() { //break the callstack to let the event finish
               $this.html($this.text());
        }, 10); 
       });
    function AdvertisementPreviewImage(id, fileName, responseJSON, type)
    {
        var data = eval(responseJSON);
        $('#previewLi_GroupLogo_'+type).show();
        $('#updateAndCancelGroupIconUploadButtons').show();
        var filepath='/upload/advertisements/' + data.savedfilename;
        $("#Advertisement_Url_"+type).val(filepath);
        $("#Advertisement_Url_"+type).attr('data-ext',data.extension);
        $("#Advertisement_Url_"+type).attr('data-lang',type);
        if(data.extension=="swf"){
            filepath='/images/system/swf.png';
        }else if(data.extension=="mp4" || data.extension=="mov"){
            filepath='/images/system/video_img.png';
        }
        $('#language_upload_'+type+' div.language_img>img').attr('src', filepath);    
        $('#Url_'+type).val(filepath);    
        var url = type+'@@'+data.extension+'@@' + filepath;
        var adVal = $('#AdvertisementForm_Url').val();
        $('#AdvertisementForm_Url').val(adVal+','+url);
        $('#language_upload_'+type+' div.language_img>img').attr('data-lang',type);
        $('#groupIconPreviewId_GroupLogo_'+type).attr('data-ext',data.extension);
        //$('#AdvertisementForm_Type').val(data.extension);
        $('#previewiconNew').show();
        generateUrl();
    }
    function generateUrl(){
        $('#AdvertisementForm_Url').val("");
        $('#previewiconUL li div.language_img img').each(function() {
            var lang = $(this).attr('data-lang');
            var ext = $(this).attr('data-ext');
            var filepath = $('#Url_'+lang).val();
            var url = lang+'@@'+ext+'@@' + filepath;
            var adVal = $('#AdvertisementForm_Url').val();
            $('#AdvertisementForm_Url').val(adVal+','+url);
        });
    }
    function showPreviewNew(lang){
        var displayPosition=$.trim($('#AdvertisementForm_DisplayPosition').val());
        var displayPage=$('#DisplayPage').val();
        var url=$('#groupIconPreviewId_GroupLogo_'+lang).attr('src');
        var type=$('#groupIconPreviewId_GroupLogo_'+lang).attr('data-ext');
		
        if(displayPosition=="" || displayPage=="" || url==""){
            $("#errmsgForAd").html("<?php echo Yii::t('translation','please_select_position_displaypage_artifact_to_check_the_preview');?>");
            $("#errmsgForAd").css("display", "block");
            $("#sucmsgForAd").css("display", "none");
            $("#errmsgForAd").fadeOut(5000);
        }else {
            showPreview('',url,type,displayPosition,displayPage);

        }   
    }
    
    
    function reloadLanguages(){
        $('#AdvertisementForm_Languages option').each(function(){
            var lang = $(this).val();
            if($('#GroupLogo_'+lang).length>0){
                $('#GroupLogo_'+lang).remove();
            }
            if($('#uploadlistSchedule_'+lang).length>0){
                $('#uploadlistSchedule_'+lang).remove();
            }
            if($('#previewLi_GroupLogo_'+lang).length>0){
                $('#previewLi_GroupLogo_'+lang).remove();
            }
            if($('#language_upload_'+lang).length>0){
                $('#language_upload_'+lang).remove();
            }
            if($('#imageWithTextDiv_'+lang).length>0){
                $('#imageWithTextDiv_'+lang).remove();
            }
            $(this).removeAttr('selected');
        });
    }
	
    function generateAttchment(lang){
        if($('#GroupLogo_'+lang).length==0){
            var language = $("#AdvertisementForm_Languages option[value='"+lang+"']").text();
            var previewLi = '<li class="language_prv_li" id="language_upload_'+lang+'">'+
                '<div class="positionrelative language_img">'+
                    '<span class="span_language" style="padding-left: 12px; color: rgb(153, 153, 153);">'+language+'</span>'+
                    '<div class=" positionabsolutediv" id="uploadIcons_'+lang+'" style="right:3px; top:3px" >'+
                    '</div>'+
                    '<img style="border:0;" alt="" src="/images/system/language_img.png" >'+
                    '<input type="hidden" data-lang="'+lang+'" value="/images/system/language_img.png" data-ext="png" class="Advertisement_Url" id="Advertisement_Url_'+lang+'" \>'+
                '</div>'+
            '</li>';
    
            $('#previewiconUL').append($(previewLi));
            var uploadDivs = '<div id="GroupLogo_'+lang+'" class="uploadicon"><img src="/images/system/spacer.png"></div>';
            $('#uploadIcons_'+lang).append($(uploadDivs));
            
            if($('#uploadlistSchedule_'+lang).length>0){
                $('#uploadlistSchedule_'+lang).remove();
            }
            var uploadul = '<ul class="qq-upload-list" id="uploadlistSchedule_'+lang+'"></ul>';
            $(uploadul).insertBefore("#GroupLogoError");
            if($('#previewLi_GroupLogo_'+lang).length>0){
                $('#previewLi_GroupLogo_'+lang).remove();
            }
            
            initializeFileUploader('GroupLogo_'+lang, '/advertisements/UploadAdvertisementImage', '10*1024*1024', extensions,1, lang ,'',AdvertisementPreviewImage,displayErrorForBannerAndLogo,"uploadlistSchedule_"+lang);
        }
    }
    function loadBannerTemplate(lang){
        var queryString = {language:lang,bannerTemplate:1,bannerId:1};
        ajaxRequest("/advertisements/LoadBannerTemplate",queryString,loadBannerTemplateHandler, 'html');
    }
    function loadBannerTemplateHandler(data){
        $('#uplloadBannerPreview').append(data);
        $('#uplloadBannerPreview').show();
        bannerTemplateEvents();
        
    }
    function bannerTemplateEvents(){
        $('.bannerTemplateDiv2 span.radio').unbind('click');
        $('.bannerTemplateDiv2 span.radio').bind('click', function() {
            var lang = $(this).closest('.bannerTemplateDiv2').attr('data-language');
            var selectedRadio = $(this).next().val();
            if($('#imageWithTextBanner_'+lang).css('display')=="none"){
                $("#templateBannerChangeClass_"+lang).attr('class','addbanner');
                $("#templateBannerChangeClass_"+lang).addClass('addbannersection'+selectedRadio);
                var g_adImage = '/images/system/ad_creation_defaultbanner'+selectedRadio+".jpg" ;  
                $('#Preview_BannerImage_'+lang).attr('src', g_adImage);
                $("#imageWithTextBanner_"+lang).show(); 
                initializeFileUploader('BannerImage_'+lang, '/advertisements/UploadAdvertisementImage', '10*1024*1024', bannerextensions,1, 'BannerImage_'+lang ,'',BannerDLPreviewImage,displayErrorForBannerAndLogo,"Upload_BannerImage_"+lang);
            }else{
                $("#templateBannerChangeClass_"+lang).attr('class','addbanner');
                $("#templateBannerChangeClass_"+lang).addClass('addbannersection'+selectedRadio);
            }
            $('#titleBanner45_'+lang).unbind('click');
            $('#titleBanner45_'+lang).bind('click', function() {
                $("#contentBanner45_"+lang).removeClass('addbannerpadding_active');
                $("#titleBanner45_"+lang).removeClass('addbannerpadding_active');
                $('.demo2_'+lang).minicolors({
                    hide: function() {}
                });

            });
            $('#contentBanner45_'+lang).unbind('click');
            $('#contentBanner45_'+lang).bind('click', function() {
                    $("#titleBanner45_"+lang).removeClass('addbannerpadding_active');
                    $("#contentBanner45_"+lang).removeClass('addbannerpadding_active');
                    $('.demo1_'+lang).minicolors({
                        hide: function() {}
                });
            });


              $('.demo1_'+lang).minicolors({
                      change: function(hex, opacity) { 
                              var log;
                              try {
                                      log = hex ? hex : 'transparent';
                                      if( opacity ) log += ', ' + opacity;
                                      $("#templateBannerChangeClass_"+lang+" .addbannaertitle").css("color",log); 
                              } catch(e) {}
                      },
                     hide: function() {

                          }
              });

              $('.demo2_'+lang).minicolors({
                      change: function(hex, opacity) { 
                              var log;
                              try {
                                      log = hex ? hex : 'transparent';
                                      if( opacity ) log += ', ' + opacity;
                                      $("#templateBannerChangeClass_"+lang+" .addbannerdescription").css("color",log); 
                              } catch(e) {}
                      },
                      hide: function() {

                          }
              });
        });
    }
    function getBannerData(lang){
        var Banner = new Object();
        Banner.Language = lang;
        Banner.BannerTemplate = $("input[name=AdvertisementForm_BannerTemplate_"+lang+"]:checked").val();
        Banner.Url = $("#Preview_BannerImage_"+lang).attr('src');

        var bTitle = $("#AdBannerTitle_"+lang).clone().removeAttr("contentEditable");
        var bcontent = $("#AdBannerContent_"+lang).clone().removeAttr("contentEditable");

        Banner.BannerTitle = bTitle.wrap('<p>').parent().html();
        Banner.BannerContent = bcontent.wrap('<p>').parent().html();
        Banner.BannerOptions = "ImageWithText";
        return Banner;
    }
    function getUploadsData(lang){
        var Upload = new Object();
        Upload.Language = lang;
        Upload.Type = $("#Advertisement_Url_"+lang).attr('data-ext');
        Upload.Url = $("#Advertisement_Url_"+lang).val();
        return Upload;
    }
    function saveAd(){
        var BannerData = new Array();
        var UploadData = new Array();
        var i=0;
        $('#AdvertisementForm_Languages :selected').each(function(){
            var lang = $(this).val();
            if($("#bannerOptions").val()=="ImageWithText"){
                BannerData[i] = getBannerData(lang);
                i++;
            }else{
                if($("li.language_prv_li").length>0){
                    UploadData[i] = getUploadsData(lang);
                    i++;
                }
            }
        });
        $('#Banners').val(JSON.stringify(BannerData));
        $('#Uploads').val(JSON.stringify(UploadData));
        var queryString = $('form[id=advertisement-form]').serialize();
        ajaxRequest("/advertisements/newAdvertisement",queryString,advertisementHandler);
    }

    function loadGroupSurveys(obj){
      if(obj.value!=''){
        var queryString = 'groupname='+obj.value;  
        ajaxRequest("/advertisements/GetSurveysByGroupName",queryString,loadGroupSurveysHandler);
     
     }else{
         $("#AdvertisementForm_SurveyName").empty();
         $("#AdvertisementForm_SurveyName").find("span").text("Please select survey");
     }

    }
    function loadGroupSurveysHandler(data){
       data=data.data.toString();
       if (data.indexOf("<option") !=-1){
                $("#AdvertisementForm_SurveyName").empty();
                 $("#AdvertisementForm_SurveyName").find("span").text("Please select survey");
                       $("#AdvertisementForm_SurveyName").append(data);
                       $("#AdvertisementForm_SurveyName").trigger("liszt:updated");

        }else{
            
            $("#AdvertisementForm_SurveyName_em_").removeClass().addClass("alert alert-error").html(data).show().fadeOut(7000);
            $("#AdvertisementForm_SurveyName").empty();
            $("#AdvertisementForm_SurveyName").find("span").text("Please select survey");
        }
    }
    function loadSurveySchedules(obj){
       if(obj.value!=''){
        var queryString = 'surveyId='+obj.value;  
        $("#AdvertisementForm_SurveyIdHidden").val(obj.value);
        ajaxRequest("/advertisements/GetSchedules",queryString,loadSurveySchedulsHandler);
     
     }else{
         $("#AdvertisementForm_ScheduleId").empty();
         $("#AdvertisementForm_ScheduleId").find("span").text("Please select schedule");
         
     }
    }
    function loadSurveySchedulsHandler(response){
       var data=response.data.toString();
       $("#AdvertisementForm_Title").val(response.SurveyTitle);
       if(response.IsBranded==1){
           $("#isThisExternalParty").show();
           $('#externalPartyName').show();
           $('#externalPartyLogo').show();
           $('#ExternalPartyDivCB span.checkbox').removeAttr("style").attr("style","background-position: 0px -50px;"); 
           $('#isThisExternalPartyCB').attr('checked',true);
           $("#isThisExternalParty span").addClass("checkbox disabled");
           $('#isThisExternalPartyCB').attr('disabled','disabled');
           $("#ExternalPartyDivCB").prepend('<div id="ExternalPartyCheckDiv" style="position:absolute;width:30px;height:25px;z-index:2;top:35px"></div>')
           $('#inlineTitle').html("External Party Context");
           $("#AdvertisementForm_IsThisExternalPartyhidden").val(1);
           $("#AdvertisementForm_ExternalPartyName").val(response.BrandName);
           $('#ExternalPartyLogoPreview').attr('src', response.BrandLogo);    
           $('#AdvertisementForm_ExternalPartyUrl').val(response.BrandLogo);
       }
       else{
         $('#ExternalPartyDivCB span.checkbox').attr("style","background-position: 0px -50px;"); 
         $('#ExternalPartyCheckDiv').remove();
        }
       if (data.indexOf("<option") !=-1){
                $("#AdvertisementForm_ScheduleId").empty();
                 $("#AdvertisementForm_ScheduleId").find("span").text("Please select schedule");
                       $("#AdvertisementForm_ScheduleId").append(data);
                       $("#AdvertisementForm_ScheduleId").trigger("liszt:updated");

        }else{
             $("#AdvertisementForm_ScheduleId").empty();
             $("#AdvertisementForm_ScheduleId").find("span").text("Please select schedule");
             $("#AdvertisementForm_ScheduleId_em_").removeClass().addClass("alert alert-error").html(data).show().fadeOut(7000);
            
        }
    }
    
    function loadScheduleDetails(obj){
        var selectedValue=$('#AdvertisementForm_ScheduleId :selected').text(); 
       if(selectedValue!='' && selectedValue!="Please select schedule"){
           var dataString=selectedValue;
           dataString=dataString.split(" to "); 
           $("#AdvertisementForm_StartDate").val(dataString[0]);
           $("#AdvertisementForm_ExpiryDate").val(dataString[1]);

       }  
       else{
         $("#AdvertisementForm_StartDate").val("");
           $("#AdvertisementForm_ExpiryDate").val("");  
      }
  }
</script>   