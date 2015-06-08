      

<span id="loginSpinner"></span>
    <div class="row-fluid">
                <div class="span12">
                    
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
        'method'=>'post',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
                'validatOnChange'=>true,
      //      'afterValidate'=>'js:clearMessage',

	),
    'htmlOptions'=>array(
        
         'style'=>'margin: 0px; accept-charset=UTF-8','enctype' => 'multipart/form-data','class'=>'marginzero'
    )
)); ?>
                <div class="span5">
                    	
   
                    <div class="control-group controlerror">
                        <div class="lusername" style="display:table"><?php echo $form->textField($this->model,'email',array("placeholder"=>Yii::t('translation','userName'), 'maxlength' => 40, 'class' => 'span12 email')); ?>        
                            </div>
                   <?php echo $form->error($this->model,'email'); ?>
                    
                    <?php //echo $form->error($this->model, 'error'); ?> 
                    </div>              
  
                </div>
                <div class="span5"> 
                        <div class="control-group controlerror">
                    <div class="lpassword" style="display:table;"><?php echo $form->passwordField($this->model,'pword',array("placeholder"=>Yii::t('translation','password'), 'maxlength' => 40, 'class' => 'span12 pwd')); ?>        
                    </div>
                  <?php echo $form->error($this->model,'pword'); ?>
                        </div>  
                
                   <?php echo $form->hiddenField($this->model,'rememberMe',array('value'=>1)); ?>        
                </div>
                    
                <div class="span2"> 
                     <?php
                                            echo CHtml::ajaxSubmitButton('Login', array('site/login'),array(
                                                    'type'=>'POST',
                                                'dataType' => 'json',
                                                'error'=>'function(error){
                                                 
                                                   }',
                                                'beforeSend' => 'function(){
                                               
                                                 

                                                        if ($("#rememberMe_login").is(":checked")) {

                                                        $("#LoginForm_rememberMe").val(1);
                                                        }


                                                }',
                                                'complete' => 'function(){
                                                  
                                                    }',
                                                
                                                
                                                
                                                'success' => 'function(data,status,xhr) { logincallback(data,status,xhr);}'),
                                                    array('type' => 'submit','class'=>'btn btnlogin pull-right')
                                                    );
                                        ?>
                                                   
                   <?php //echo CHtml::submitButton('Login',array('class'=>'btn pull-right')); ?>
                                                   
                </div>
                    <?php $this->endWidget(); ?>
                </div>
                </div>
     <div class="row-fluid">
                <div class="span12 headerlink" >
                 <ul role="navigation" class="nav">
                    <li class="pull-left">
                        <input type="checkbox" id="rememberMe_login" name="rememberMe_login" class="styled" checked>
         
<b>Remember me</b>
</li>
 

<script type="text/javascript">
    $(".checkbox").live("click",function(){
         if ($("#rememberMe_login").is(":checked")) {

        $("#LoginForm_rememberMe").val(1);
       }else{
          $("#LoginForm_rememberMe").val(0);  
       }
    })
    if(navigator.appName=="Microsoft Internet Explorer"){
    $("#LoginForm_email").css( "width","160px" );
     $("#LoginForm_pword").css( "width","160px" );
    }
 $('input[type=text]').focus(function(){      
     if(navigator.appName=="Microsoft Internet Explorer"){
        $(this).css( "background","#fff");
        $(this).css( "padding-left","5px" );
        $(this).css( "width","160px" )
     }
  //clearerrormessage(this);
});
 $('input[type=text]').focusout(function(){ 
     setTimeout(function(){
         if($("#LoginForm_email").val() ==''){
            $("#LoginForm_email_em_").fadeOut(5000).show();
        }
         //$("#LoginForm_email_em_").parent().removeClass('error');
     },500);
     
    });
    $('input[type=password]').focusout(function(){  
     setTimeout(function(){
         if($("#LoginForm_pword").val() ==''){
            $("#LoginForm_pword_em_").fadeOut(5000).show(); 
        }
     },500);
     
    });
$('input[type=password]').focus(function(){
    if(navigator.appName=="Microsoft Internet Explorer"){
        $(this).css( "background","#fff" );
        $(this).css( "padding-left","5px" );
        $(this).css( "width","160px" )
     }
   clearerrormessage(this);
});

if(navigator.appName=="Microsoft Internet Explorer"){
$('input[type=text]').focusout(function(){ 
 if($("#LoginForm_email").val()==''){
     $(this).css( "background","");
        $(this).css( "padding-left","" );
 }
 
});
$('input[type=password]').focusout(function(){ 
 if($("#LoginForm_pword").val()==''){
     $(this).css( "background","");
       $(this).css( "padding-left","" );
 }

});
}
  $(document).ready(function(){
        var error=$('#login-form').find('.errorMessage');         
        $.each(error, function(key, val) {         
       
                $("#"+val.id).fadeOut(5000);
            
        });         
        })
         function logincallback(data, txtstatus, xhr) {
            
        var data = eval(data);
        if (data.status == 'success') {
            
            var joyrideToLoad=data.joyrideToLoad;
           // alert(joyrideToLoad);
            deleteCookie('Hds_user');
            
            var returnValue= 1;//trackBrowseDetails("http://localhost/");
            if(returnValue==1){
             if (getCookie('r_u') != "" && getCookie('r_u') !='<?php echo Yii::app()->params["ServerURL"]."/site";?>') {
                var returnUrl = getCookie('r_u');
               
                   window.location = returnUrl.replace(/%2F/g, "/");
           
            }
            else  if(joyrideToLoad!="failure")
            {
                getNewUserJoyrideDetailsNext(joyrideToLoad,"Next");
                return;
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
    
function registernow(){
    $('body, html').animate({scrollTop : 0}, 400,function(){
        $("#registrationdropdown").addClass("open");
    });
            
        }
    $(document).ready(function() {
        $('input[id=UserRegistrationForm_email]').tooltip({'trigger': 'hover'});
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
            $("#npinumberDiv,#studentOrresidentDiv").hide();
            $("#aboutMeDiv").closest('.row-fluid').hide();
            $('#registartion_country').find('span').text("Please Select country");
            $('#registration_primary').find('span').text("Choose One");
            $('#registartion_state').find('span').text("Please Select state");
            $('.checkbox').css('background-position', '0px 0px');
            $('.radio').css('background-position', '0px 0px');
            $("#sucmsg").fadeOut(5000,function(){
            $("#registrationdropdown").removeClass("open");
            }); 
           
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
     * Handler for requesting new pword
     */
    function forgotPwHandler(data, txtstatus, xhr) {        
        scrollPleaseWaitClose("forgotpwSpinLoader");
        var data = eval(data);
        if (data.status == 'success') {
            var msg = data.data;
            $("#sucmsgForForgot").html(msg);
            $("#errmsgForForgot").css("display", "none");
            $("#sucmsgForForgot").css("display", "block");
            $("#forgot-form")[0].reset();
             $("#sucmsgForForgot").fadeOut(5000,function(){
            $("#forgotPworddropdown").removeClass("open");
            }); 
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
    
 sessionStorage.clear();
    </script>