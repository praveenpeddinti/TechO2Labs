function PublicationAuthors(event, obj,Type){
     var keyCode = event.keyCode || event.which;
    if (keyCode == 13 || keyCode==188 || keyCode==9){
        var inputorId = $(obj).attr('id');        
        var authorsCount = $("#"+inputorId+"_currentMentions>span.dd-tags").length;
        if(authorsCount<100){
            if(typeof globalspace['cv_custom_mention_'+inputorId] == 'undefined'){
                globalspace['cv_custom_mention_'+inputorId]=new Array();
            }
            var textValdata = $.trim($(obj).val());
            
           var  textValarray=textValdata.split(",")
           if(textValarray.length>0){
               for(var i=0;i<textValarray.length;i++){
           var  textVal=textValarray[i];
           if(textVal!=""){
           // textVal = textVal.substring(0, textVal.length-1);
            var isElementExists = $.inArray( textVal, globalspace['cv_custom_mention_'+inputorId]);
            if(isElementExists ==-1){
                globalspace['cv_custom_mention_'+inputorId].push(textVal);
                var arrayVal='cv_custom_mention_'+inputorId;
                //var htmlVal = "<span data-user-id='' class='at_mention dd-tags  dd-tags-close'><b>"+textVal+"</b><i id='"+arrayVal+"' >X</i></span>";
                var htmlVal = "<span class='dd-tags hashtag'><b>"+textVal+"</b><i class='"+arrayVal+"'id='"+arrayVal+"' data-name='"+textVal+"' >X</i></span></span>";
                        
                $("#"+inputorId+'_currentMentions').append(htmlVal);
                $(obj).val("");
                $("#"+inputorId+'_currentMentions .'+arrayVal).unbind("click");
                $("#"+inputorId+'_currentMentions .'+arrayVal).bind("click", function(){
                    deleteInvitedAtMentionForCV_Custom(this,textVal,arrayVal);
                });
            }else{
                $('.interests').css('height','130px');
                $("#"+inputorId+"_error").html(textVal+" "+Translate_already_exist+".").show();
               $("#"+inputorId+"_error").html(textVal+" "+Translate_already_exist+".").fadeOut(10000);
                
                
                    setTimeout(function() { // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
                        $('.interests').css('height', '');

                    }, 8000);
            }
        }
           }}
        }else{
            $(obj).val("");
             $('.interests').css('height','130px');

            $("#"+inputorId+"_error").html(Translate_You_can_enter_maximum_of_5+" "+Type+ ".").show().fadeOut(10000);
             setTimeout(function() { // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
                        $('.interests').css('height', '');

                    }, 8000);
        }
    } 
}
 function CVInterests(obj,Type){
      var textValdata = $.trim($(obj).val());
      if(textValdata!=""){
          var inputorId = $(obj).attr('id');        
        var authorsCount = $("#"+inputorId+"_currentMentions>span.dd-tags").length;
        if(authorsCount<100){
            if(typeof globalspace['cv_custom_mention_'+inputorId] == 'undefined'){
                globalspace['cv_custom_mention_'+inputorId]=new Array();
            }
           var  textValarray=textValdata.split(",")
           if(textValarray.length>0){
               for(var i=0;i<textValarray.length;i++){
           var  textVal=textValarray[i];
           if(textVal!=""){
           // textVal = textVal.substring(0, textVal.length-1);
            var isElementExists = $.inArray( textVal, globalspace['cv_custom_mention_'+inputorId]);
            if(isElementExists ==-1){
                globalspace['cv_custom_mention_'+inputorId].push(textVal);
                var arrayVal='cv_custom_mention_'+inputorId;
                //var htmlVal = "<span data-user-id='' class='at_mention dd-tags  dd-tags-close'><b>"+textVal+"</b><i id='"+arrayVal+"' >X</i></span>";
                var htmlVal = "<span class='dd-tags hashtag'><b>"+textVal+"</b><i class='"+arrayVal+"'id='"+arrayVal+"' data-name='"+textVal+"' >X</i></span></span>";
                        
                $("#"+inputorId+'_currentMentions').append(htmlVal);
                $(obj).val("");
                $("#"+inputorId+'_currentMentions .'+arrayVal).unbind("click");
                $("#"+inputorId+'_currentMentions .'+arrayVal).bind("click", function(){
                    deleteInvitedAtMentionForCV_Custom(this,textVal,arrayVal);
                });
            }else{
                $('.interests').css('height','130px');
                $("#"+inputorId+"_error").html(textVal+" already exist.").show();
               $("#"+inputorId+"_error").html(textVal+" already exist.").fadeOut(10000);
                
                
                    setTimeout(function() { // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
                        $('.interests').css('height', '');

                    }, 8000);
            }
        }
           }}
        }else{
            $(obj).val("");
             $('.interests').css('height','130px');
            $("#"+inputorId+"_error").html("You can enter maximum of 100 "+Type+ ".").show().fadeOut(10000);
             setTimeout(function() { // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
                        $('.interests').css('height', '');

                    }, 8000);
        }
      }
      
 }

function deleteInvitedAtMentionForCV_Custom(obj, textVal, arrayId){
  $(obj).parent('span.dd-tags').remove(); 

//   var i =  globalspace[obj.id].indexOf($(obj).attr('data-name'));
//
//        if(i > -1) {
//                globalspace[obj.id].splice(i, 1);
//        }
      globalspace[obj.id] = $.grep(globalspace[obj.id], function(value) {
  return value != $(obj).attr('data-name');
});
}

function initializeEditor(id,div){
    if( $("#editor-toolbar-"+div+"_"+id).length ==0){
    $('#'+div+'_'+id).freshereditor({editable_selector: '#'+div+'_'+id, excludes: ['removeFormat', 'insertheading4']});
    $('#'+div+'_'+id).freshereditor("edit", true);
    $("#editor-toolbar-"+div+"_"+id).addClass('editorbackground');
    $("#editor-toolbar-"+div+"_"+id).show();
    $('#'+div+'_'+id).css("min-height", "50px");
    $('#'+div+'_'+id).click(function()
    {
        $(this).removeClass("Discemilarplaceholder");
        $(this).focus();
    });
}
}

function initializeEditorNew(div){
     $('#'+div).freshereditor({editable_selector: '#'+div, excludes: ['removeFormat', 'insertheading4']});
    $('#'+div).freshereditor("edit", true);
    $("#editor-toolbar-"+div).addClass('editorbackground');
    $("#editor-toolbar-"+div).show();
    $('#'+div).css("min-height", "50px");
    $('#'+div).unbind('click').bind("click",function()
    {
      //  $(this).removeClass("Discemilarplaceholder");
        $(this).focus();
    });
}

function removeEditor(){
        $('.editorbackground').remove();
}



function publicationscallback(data, txtstatus, xhr) {
        scrollPleaseWaitClose('registrationSpinLoader');
        var data = eval(data);
        
        if (data.status == 'success') {
            $("#UserCV-form")[0].reset();
            var msg = data.data;
            $("#sucmsg").html(msg);
            $("#sucmsg").css("display", "block");
            $("#errmsg").css("display", "none");
            $("#sucmsg").fadeOut(5000);
            $('.checkbox').css('background-position', '0px 0px');
            $('.radio').css('background-position', '0px 0px');
//            window.location="/user/userCV";
            if(data.message!=""){
                
               $("#sucmsg").html(data.message);
                $("#sucmsg").focus();

            }
             setTimeout(function() { // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
                  var url = window.location.pathname.substr(1);
                  var urlArr = url.split("/");
                  window.location.href = "/userCVView/"+urlArr[1];
            }, 900);

           
            
            //$("form").serialize()
        } else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
                       
       for (var i = 0; i < g_Interests.length; i++){ 
        
         $('#UserCVForm_UserInterests_'+g_Interests[i]).val("");
       }
            if (msg != "") {

                $("#errmsg").html(msg);
                $("#errmsg").css("display", "block");
                $("#sucmsg").css("display", "none");
                $("#errmsg").fadeOut(5000);

            } else {

                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {
                    var error = eval(data.error);
                }
                $('.collapse').css('overflow','visible');
//                $('.experience').css('height','130px');
//                $('.achievements').css('height','130px');
//                $('.interests').css('height','130px');
//                $('.education').css('padding','20px');
                
                $.each(error, function(key, val) {

                    if ($("#" + key + "_em_")) {

                        // alert(key);
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(5000);
                        $("#" + key).parent().addClass('error');
                    }

                });
                  setTimeout(function() { // waiting for 1 sec ... because it is very fast, so that's why we have to forcely wait for a sec.
                      $('.collapse').css('overflow','hidden');
                   
                }, 8000);
            }
        }

    }
    
 
function cancel(){
  var url = window.location.pathname.substr(1);
    var urlArr = url.split("/");
    sessionStorage.userProfile = urlArr[1];
    window.location.href = "/profile/"+urlArr[1];
  
}