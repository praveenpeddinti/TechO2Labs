

<section id="streamsection" class="streamsection1 network_specific">
    <div class="container">
        <div class="sidebar-nav" id="menu_bar">
            <ul  id="menu">
                <li class="" id="post" ><a class="left_home-icon" > <span>Home</span></a></li>
                <li class="" id="curbsidepost" ><a class="left_curbside-icon"><span>Curbside</span></a></li>
                <li class="" id="games" ><a class="left_games-icon" ><span>Games</span></a></li>
                <li class="" id="news" ><a class="left_news-icon" ><span>News</span></a></li>
                <li class="" id="careers" ><a class="left_career-icon" ><span>Career</span></a></li>
            </ul>
        </div>
         <div class="streamsectionarea">
        <div class="padding10">
            <div id="outerspinner"></div>
            <div id="outerDetailPage">
               
              
        <div class="padding10">
            <div id="outerspinner"><div style="z-index: 99999; left: 0px; right: 0px; text-align: center; top: 0px; bottom: 0px; position: absolute; display: none;" id="loader_outerspinner"><div class="loader" id="cl_spiral_outerspinner" style="padding-top: 0px;"><div id="SpinLoader"><img src="/images/icons/loading_spinner.gif"></div></div></div></div>
            <div id="outerDetailPage">    

    
                <div id="postDetailedwidget" class="stream_widget marginT10">
                    <div class="profile_icon"><img src="<?php echo $profilepic;?>"> </div>
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
        </div>
             <div class="sp_landingpage top_boder_landingpage">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8 sp_landingpage_l">
          	<div class="paddingleft20">
                    <div class="paddingleft20">
                    <h2 class="pagetitle"> What's <?php echo Yii::app()->params['PrimaryUser']; ?>? </h2>
            
                    </div>
                     <div class=" service-row ">
                <div class="row-fluid">
                <div class="span12">
                        <h3>Built by <?php echo Yii::app()->params['PrimaryUser']; ?>, for <?php echo Yii::app()->params['PrimaryUser']; ?>.</h3>
                        <p>When we set out to create a trusted online collaboration platform specifically for the likes of <?php echo Yii::app()->params['PrimaryUser']; ?>, we wanted to be sure that it met the highest expectations. With input from active <?php echo Yii::app()->params['PrimaryUser']; ?>, we were able to launch <?php echo Yii::app()->params['NetworkName']; ?> in 2012. </p>
                 </p>
                    </div>
                </div>
                <div class="row-fluid">
                <div class="span12">
                        <h3>From residency to retirement.</h3>
                        <p>Our goal is to provide a dynamic area for students and physicians alike to leverage the power of social media and gain useful knowledge into their field. We’re ready to make a positive impact!</p>
                    </div>
                </div>
                <div class="row-fluid">
                <div class="span12">
                        <h3>Unlock the power of collaboration with our verification process.</h3>
                        <p class="fontsize16">What sets us apart from the competition is our unique verification process. You can rest assured that users within <?php echo Yii::app()->params['NetworkName']; ?> are all verified by their student or physician credentials. See for yourself, get started here!  </p>
                        
                    </div>
                </div>
            </div>
                </div>
           </div>
               <div class="span4 sp_landingpage_r">
               <p>If you are interested in learning more </p>
               <h2 onclick="registernow();" style="cursor: pointer;">Register NOW</h2>	
               <a href="javascript:registernow();"><img width="72" height="72" src="/images/system/spL_go_img.png"></a>
               </div>

        </div>
    </div>
                 <?php if(Yii::app()->params['IsMobileAppexist']=='ON'){ 
                      include 'mobile.php';
                  } ?>
</div>
        
            </div>
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
   referralLinkId= '<?php echo $referralLinkId;?>';
referralUserEmail= '<?php echo $referenceUserEmail;?>';

    $("#gotologin").on('click',function(){
        $("#LoginForm_email,#LoginForm_pword").val("");
        $("#LoginForm_email").focus();
    });
function registernow(){
    $('body, html').animate({scrollTop : 0}, 800,function(){
        $("#registrationdropdown").addClass("open");
    });
            
        }
    $(document).ready(function() {
        $('input[id=UserRegistrationForm_email]').tooltip({'trigger': 'hover'});
       // renderOuterPostDetailPage('<?php echo $postId ?>', '<?php echo $categoryType ?>', '<?php echo $postType ?>');
        
    });
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
                $("#errmsg").fadeOut(5000);

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
            if (getCookie('r_u') != "") {
                var returnUrl = getCookie('r_u');
                window.location = returnUrl.replace(/%2F/g, "/");
            }
            else {
                window.location = '/';
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
    function getCookie(cname)
    {
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
 sessionStorage.clear();
 Custom.init();

</script>
<style type="style/css">
    #main-menu ul, #mainNav{display: none}
    
</style>
<script type="text/javascript">
$(document).ready(function(){
    $("div.logo a.brand").attr("href","/");
    $(".logo a,#logo a,div.logo a.brand ").live("click",function(){      
       window.location.href = "/";
    });
});
</script>

