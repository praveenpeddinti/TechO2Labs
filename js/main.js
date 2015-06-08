var loginUserId;
function divrender(divid,url){
    $('#totalMainArea').hide();
    $('#contentDiv').hide();
    $('#menu_bar').hide();
    $('#'+divid).load(url,function() {
Custom.init();
});

}
function divrenderget(divid,url){
    /**
     * reddy wrote this line to hide  news detail page. 
     */
 //  $("#admin_PostDetails").hide();
   chatStartLimit = 0;
    $.get(url,function(data) {
        $('#'+divid).html(data);
});
if($("#minTourGuideDiv").css("display")=="block"){
     
    }
    else
        minimizeJoyride();
trackEngagementAction("ChatClick","",0);
}

function openFooterTabs(type){
  $('.modal').on('show', function () {$('body').css('overflow','hidden');});
$('.modal').on('hidden', function () {$('body').css('overflow','auto');});

     $("#footerlinksModal_body").load("/common/getFooterTabsData",{type:type},viewFooterTabsDataHandler);  
  $("#footerlinksModal").addClass("stream_title paddingt5lr10");

if(type =='termsOfServices' || type =='/common/termsOfServices')
{
     $("#footerlinksModalLabel").html('Terms Of Service');
}
if(type =='privacyPolicy' || type =='/common/privacyPolicy')
{
     $("#footerlinksModalLabel").html('Privacy Policy');
}
    $("#footerlinksModal").modal('show');




}
function viewFooterTabsDataHandler(data) {

}


