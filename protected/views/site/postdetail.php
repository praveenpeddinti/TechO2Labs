<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/publicprofile.css" rel="stylesheet" type="text/css" media="screen" />    
<section id="streamsection" class="streamsection network_specific" >
    <div class="container">
      <?php include_once(getcwd()."/protected/views/common/StaticSidebar.php");?>
       <div class="streamsectionarea">
        <div class="padding10"> 
            <div id="outerspinner"></div>
               <div id="outerDetailPage">
                      <?php if(isset($referralLinkId)&& $referralLinkId!="" && $referralLinkId != "marketResearch"){ ?>
             <div id="outerDetailPage">    
                <div id="postDetailedwidget" class="stream_widget marginT10">
                    <div class="generalprofileicon skiptaiconwidth80x80 generalzindex2 positionabsolutediv ">
     <div class="skiptaiconinner ">            
    <img src="<?php echo $profilepic!=""?$profilepic:Yii::app()->params['ServerURL']."/images/system/app_noimage.png";?>"> 
      </div> 
                     </div>
                    <div class="post_widget">
                        <div class="stream_msg_box">
                            <div style="position: relative" class="stream_title paddingt5lr10">  <a style="cursor:pointer"  class="userprofilename_detailed"> <b><?php echo $username; ?></b></a>  <span> has  </span>  Invited to join <?php echo $networkName ?> </div>
                            <div class=" stream_content">

                                <ul>
                                    <li class="media">

                                        <div  class="media-body postDetail bulletsShow">
                                            <p><?php echo $message; ?></p>

                                  </div>                            


                                    </li>
                                </ul>

                            </div>

                        </div>
                    </div>

                </div>

</div>
                <?php }?> 
                   <?php if(isset($studentVerification)  && $studentVerification == "true"){                        
                       ?>
                   <div id="studentMessage" style="display: none;"><?php echo $studentMessage; ?></div>
                       
                   <?php }?>
            </div>
        </div>
             <div class="sp_landingpage top_boder_landingpage">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8 sp_landingpage_l">
          	<div class="paddingleft20">
                    <div class="paddingleft20">
                    <h2 class="pagetitle"> What's <?php echo Yii::app()->params['NetworkName']; ?>? </h2>
            
                    </div>
                     <div class=" service-row ">
                <div class="row-fluid">
                <div class="span12">
                        <h3>Built by <?php echo Yii::app()->params['Specialists']; ?>, for <?php echo Yii::app()->params['Specialists']; ?>.</h3>
                        <p ><?php echo Yii::app()->params['NetworkName']; ?> is an online medical community, exclusively for verified <?php echo Yii::app()->params['Specialists']; ?>, enabling specialized consultation, communication, and information exchange within a private and secure platform.  </p>
               <p >Membership is exclusive to <?php echo Yii::app()->params['Specialists']; ?>, ensuring interactions occur among specialists within a focused area of expertise, fueling vibrant clinical collaboration. </p>
                <p>Utilizing advanced social networking technology,<?php echo Yii::app()->params['NetworkName']; ?> was created specifically for the needs of <?php echo Yii::app()->params['Specialists']; ?> and in full compliance with all industry regulations. <a href="#"  onclick="registernow();"> <b class="p_joinnow">Join now!</b></a>. </p>
                    </div>
                </div>
                
                
            </div>
                </div>
           </div>
               <div class="span4 sp_landingpage_r">
                                <p> <?php echo Yii::app()->params['NetworkName']; ?> is an online medical community, exclusively for <?php echo Yii::app()->params['Specialists']; ?>.
If you aren’t already a <?php echo Yii::app()->params['NetworkName']; ?> member,<b  style="cursor: pointer;" onclick="registernow();"> Join NOW! </b>	</p>
               <a href="#" onclick="registernow();" ><img src="/images/system/spL_go_img.png" width="72" height="72" /></a>
            
               </div>

        </div>
    </div>
              <?php 
              
             if(Yii::app()->params['IsMobileAppexist']=="ON"){
              include 'mobile.php';
             }?>
</div>
        </div>
<!--        <img src="/images/system/removalimg.png">-->
        
    </div>
</section>

<!-- Modal -->
            <div class="modal fade" id="sessionTimeoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-session">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="sessionTimeoutLabel">Modal title</h4>
                        </div>
                        
                        <div class="modal-body" id="sessionTimeout_body">
    
                        </div>
                        <div class="modal-footer" id="sessionTimeout_footer">
                            <button type="button" class="btn btn-small" id="gotologin" data-dismiss="modal">Login</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
<script type="text/javascript">
   referenceUserId = '<?php echo $referenceUserId;?>';  
   referralLinkId= '<?php echo isset($referralLinkId)? $referralLinkId:'';?>';
   referralUserEmail= '<?php echo isset($referenceUserEmail)?$referenceUserEmail:'';?>'; 
   $("#gotologin").on('click',function(){
        $("#LoginForm_email,#LoginForm_pword").val("");
        $("#LoginForm_email").focus();
    });
 function registernow(){
    $('body, html').animate({scrollTop : 0}, 800,function(){
        $("#registrationdropdown").addClass("open");
    });
            
        }
    
 function registercallback(data, txtstatus, xhr) {
        scrollPleaseWaitClose('registrationSpinLoader');
        var data = eval(data);
        if (data.status == 'success') {
            var msg = data.data;
            $("#sucmsg").html(msg);
            $("#sucmsg").css("display", "block");
            $("#errmsg").css("display", "none");
            $("#userregistration-form")[0].reset();
            $('#registartion_country').find('span').text("Please Select country");
            $('#registration_primary').find('span').text("Choose One");
            $('#registartion_state').find('span').text("Please Select state");
            $("#sucmsg").fadeOut(5000);
            $('.checkbox').css('background-position', '0px 0px');
            $('.radio').css('background-position', '0px 0px');

            //$("form").serialize()
        } else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {

                $("#errmsg").html(msg);
                $("#errmsg").css("display", "block");
                $("#sucmsg").css("display", "none");
                $("#errmsg").fadeOut(5000);network_specific

            } else {

                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {
                    var error = eval(data.error);
                }


                $.each(error, function(key, val) {

                    if ($("#" + key + "_em_")) {

                        // alert(key);
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(5000);
                        $("#" + key).parent().addClass('error');
                    }

                });
            }
        }

    }
    /*
     * Handler for requesting new password
     */
 function forgotPasswordHandler(data, txtstatus, xhr) {
        scrollPleaseWaitClose("forgotpasswordSpinLoader");
        var data = eval(data);
        if (data.status == 'success') {
            var msg = data.data;
            $("#sucmsgForForgot").html(msg);
            $("#errmsgForForgot").css("display", "none");
            $("#sucmsgForForgot").css("display", "block");
            $("#sucmsgForForgot").fadeOut(5000);
            $("#forgot-form")[0].reset();
            //$("form").serialize()
        } else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {
                $("#errmsgForForgot").html(msg);
                $("#errmsgForForgot").css("display", "block");
                $("#sucmsgForForgot").css("display", "none");
                $("#errmsgForForgot").fadeOut(5000);

            } else {

                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {

                    var error = eval(data.error);
                }


                $.each(error, function(key, val) {

                    if ($("#" + key + "_em_")) {
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(5000);
                        //  $("#"+key).parent().addClass('error');
                    }

                });
            }
        }
    }
 function logincallback(data, txtstatus, xhr) {
        var data = eval(data);
        if (data.status == 'success') {

           if(sessionStorage.sharedURL != undefined && sessionStorage.sharedURL != "" && sessionStorage.sharedURL != null){
                window.location = sessionStorage.sharedURL;
            }else{
                if (getCookie('r_u') != "") {
                    var returnUrl = getCookie('r_u');
                    window.location = returnUrl.replace(/%2F/g, "/");
                }
                else {
                    window.location = '/';
                }
            }

        } else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {

                if (msg == "You have entered wrong password") {
                    $("#LoginForm_pword_em_").text(msg);
                    $("#LoginForm_pword_em_").show();
                    $("#LoginForm_pword_em_").fadeOut(5000);
                    $("#LoginForm_pword_em_").parent().addClass('error');
                } else {
                    $("#LoginForm_email_em_").text(msg);
                    $("#LoginForm_email_em_").show();
                    $("#LoginForm_email_em_").fadeOut(5000);
                    $("#LoginForm_email_em_").parent().addClass('error');
                }

            } else {

                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {
                    var error = eval(data.error);
                }


                $.each(error, function(key, val) {

                    if ($("#" + key + "_em_")) {
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(5000);
                        $("#" + key).parent().addClass('error');
                    }

                });
            }
        }
    }
 function getCookie(cname){
        var name = cname + "=";
        var ca = document.cookie.split(';');

        for (var i = 0; i < ca.length; i++)
        {

            var c = $.trim(ca[i]);
            if (c.indexOf(name) == 0)
                return c.substring(name.length, c.length);
        }
        return "";
    }
 function renderOuterPostDetailPage(postId, categoryType, postType) {
    scrollPleaseWait('outerspinner');
    sessionStorage.sharedURL = document.URL;
    var URL;
    var timezoneName = jstz.determine_timezone().name();
    if(categoryType ==8){
    URL = "/common/renderNewsDetailedPage?postId=" + postId + "&categoryType=" + categoryType + "&postType=" + postType + "&layout=outer"+"&timezone=timezoneName";
    }else if(categoryType ==9){

    URL = "/common/renderGameDetails?postId=" + postId + "&categoryType=" + categoryType + "&postType=" + postType + "&layout=outer"+"&timezone=timezoneName";
        }else if(categoryType ==12){

    URL = "/common/renderPostDetailForCareer?id=" + postId + "&categoryType=" + categoryType + "&postType=" + postType+"&timezone=timezoneName";

    }else{
    URL = "/common/renderPostDetailed?postId=" + postId + "&categoryType=" + categoryType + "&postType=" + postType + "&layout=outer"+"&timezone=timezoneName";
    }
    var data="";
    ajaxRequest(URL,data,function(data){renderOuterPostDetailPageHandler(data,categoryType,postId)},"html");

}
 function renderOuterPostDetailPageHandler(html,categoryType,postId){ 
    scrollPleaseWaitClose('outerspinner');
    $("#detailedclose").hide();
    $('#outerDetailPage').html(html);
    $('body, html').animate({scrollTop : 0}, 0);
}

function renderOuterSurveyPage(bundle) {
    scrollPleaseWait('outerspinner');
    var URL;
    URL = "/common/userCustomView";
    var queryString="bundle="+bundle;
    
    ajaxRequest(URL,queryString,function(data){renderOuterSurveyPageHandler(data)},"html");

}


 function renderOuterSurveyPageHandler(html){ 
    scrollPleaseWaitClose('outerspinner');
    $("#detailedclose").hide();
    $('#outerDetailPage').html(html);
    $('body, html').animate({scrollTop : 0}, 0);
}
$(document).ready(function(){
    
    $('input[id=UserRegistrationForm_email]').tooltip({'trigger': 'hover'});
    var stddivclass = "";
    if(referralLinkId==''){ 
        <?php if(!isset($studentVerification)){  ?>
        renderOuterPostDetailPage('<?php echo $postId ?>', '<?php echo $categoryType ?>', '<?php echo $postType ?>');
        <?php }else if(isset($studentVerification) && $studentVerification == "true"){ 
            if($isVerified == 1){
            ?>
                        stddivclass = "alert alert-success";
            <?php }else{  ?>
                stddivclass = "alert alert-error";    
                $("#outerDetailPage").die()
            <?php } ?>
                $("#studentMessage").removeClass().addClass(stddivclass).html("<?php echo $studentMessage; ?>").attr("style","text-align:center;").show();
                //$("#studentMessage").fadeOut(10000);
        <?php } ?>
     }else if(referralLinkId == "marketResearch"){
         
         renderOuterSurveyPage('<?php echo $bundle; ?>');
     }
     
      Custom.init();
});
$("#surveyQuestionArea").die().live("click",function(){
    sessionStorage.sharedURL = "/marketResearchView/1/<?php echo $bundle; ?>";
    $("#sessionTimeoutLabel").html("Login");
     $("#sessionTimeout_body").html("Please login to continue");
     $("#sessionTimeoutModal").modal('show'); 
});
$("#outerDetailPage").die().live("click",function(){
    $("#sessionTimeoutLabel").html("Login");
     $("#sessionTimeout_body").html("Please login to continue");
     $("#sessionTimeoutModal").modal('show'); 
});
    $(".unlogedProfile").on("click",function(){
        showLoginPopup();
        $("#login_btn").live("click",function(){
        window.location="/";
     });
    });
</script>

 <?php include_once(getcwd()."/protected/views/common/header_menu_script.php");?>
