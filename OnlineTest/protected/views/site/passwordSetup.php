<style>
    body{padding-top:0}
</style>
<section id="Section_passwor_setup" class="streamsection network_specific">

    <div class="container">
        <div class="pad100">
                     <div class="alert-error" id="errmsgForPasswordSetUp" style='display: none;padding:2px 5px;margin-bottom:10px'></div>
                    <div class="alert-success" id="sucmsgForPasswordSetUp" style='display: none;padding:2px 5px;margin-bottom:10px'></div> 
                    
            <?php if($UserStatus!='Registered' && $UserStatus!='Duplicate' && $UsernotExistMessage=="" && $PasswordSetUpMessage==""){  ?>
            <div class="row-fluid">
                <div class="span8 ">
                    <div class="passwordsetup_content ">
                        <b><?php echo Yii::t('translation', 'Password_Setup_welcome'); ?></b> <br/>
                    <?php echo Yii::t('translation', 'Password_Setup_content'); ?><br/>
                    <?php echo Yii::t('translation','Password_Setup_content_part');?>
                    </div>
                </div>
                 <div class="span4">
                     <div>
                    <div class="alert-error" id="errmsgForPasswordSetUp_Mobile" style='display: none;padding:2px 5px;margin-bottom:10px'></div>
                    <div class="alert-success" id="sucmsgForPasswordSetUp_Mobile" style='display: none;padding:2px 5px;margin-bottom:10px'></div>   
                     </div>
                    <div class="passwordsetup_title"><?php echo Yii::t('translation', 'Password_Setup'); ?></div>
                 <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'paswordsetup-form',
                    'enableClientValidation' => true,
                    'enableAjaxValidation' => false,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                  <?php echo $form->hiddenField($PasswordSetUp, 'AccessKey'); ?> 
                <div id="passwordSetupSpinLoader"></div>
                <div class="signdiv">
                    <div class="control-group controlerror ">
                        <?php echo $form->labelEx($PasswordSetUp, Yii::t('translation', 'Password_Setup_Username')); ?>
                        <?php echo $form->textField($PasswordSetUp, 'UserName', array('maxlength' => 40, 'class' => 'span12 uneditable-input', 'autocomplete'=>"off", 'readonly'=>'readonly','onfocus'=>"this.blur()",'id' => 'PasswordSetUpForm_UserName','value'=>$UserEmail)); ?>

                    </div>

                    <div class="control-group controlerror">
                        <?php echo $form->labelEx($PasswordSetUp, Yii::t('translation', 'Password_Setup_Password')); ?>
                        <?php echo $form->passwordField($PasswordSetUp, 'password', array('maxlength' => 40, 'class' => 'span12 pwd', 'autocomplete'=>"off", 'id' => 'PasswordSetUpForm_password')); ?>



                        <?php echo $form->error($PasswordSetUp, 'password'); ?>
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->labelEx($PasswordSetUp, Yii::t('translation', 'confirmpassword')); ?>
                        <?php echo $form->passwordField($PasswordSetUp, 'ConfirmPassword', array('maxlength' => 40, 'class' => 'span12 pwd', 'autocomplete'=>"off", 'id' => 'PasswordSetUpForm_ConfirmPassword')); ?>



                        <?php echo $form->error($PasswordSetUp, 'ConfirmPassword'); ?>
                    </div>
                    <div class="headerbuttonpopup h_center padding8top">
                        <?php
                        echo CHtml::ajaxSubmitButton('Create Password', array('site/HDSUserRegistration'), array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'error' => 'function(error){
                                                         }',
                            'beforeSend' => 'function(){   
                                         scrollPleaseWait("passwordSetupSpinLoader","forgot-form");                         }',
                            'complete' => 'function(){
                                                                     }',
                            'success' => 'function(data,status,xhr) { PasswordSetupHandler(data,status,xhr);}'), array('type' => 'submit', 'class' => 'btn btn-2 btn-2a pull-right')
                        );
                        ?>
                    </div>
                    <?php echo CHtml::resetButton('Clear', array("id" => 'forgotReset', "style" => "display:none")); ?>

                </div>
                <?php $this->endWidget(); ?>
                </div>
            </div>
            <?php } else{?>
            <div class="row-fluid">
                <div class="passwordsetup_register_content">   <?php  if($PasswordSetUpMessage!=""){ echo $PasswordSetUpMessage; }else if($UsernotExistMessage!=""){ echo $UsernotExistMessage;} ?> </div>
            </div>
            
            <?php } ?>
        </div>
    </div>
</section>

<script type="text/javascript">

$('#loginarea').hide();
$('#mainNav').hide();
if('<?php echo Yii::app()->params['NetworkName'] ?>'=='Surgeon Nation'){
   $('#mainNav').css('visibility', 'hidden');
}
$('#PasswordSetUpForm_AccessKey').val('<?php echo $AccessKey;?>');
$('html, body').animate({scrollTop: $(document).height() },1500);
$('#logo a').attr('href','<?php echo Yii::app()->params['ServerURL']; ?>');
 document.cookie="Hds_user="+'<?php echo $AccessKey;?>';  

/*
* Handler for PasswordSetup
*/
function PasswordSetupHandler(data, txtstatus, xhr) {        
    scrollPleaseWaitClose("passwordSetupSpinLoader");
    var data = eval(data);
    if (data.status == 'success') {
        var msg = data.message;
        var SucId="";
        var ErrorId="";
        if($(document).width()<=360){
            SucId="sucmsgForPasswordSetUp_Mobile";
            ErrorId="errmsgForPasswordSetUp_Mobile";
        }else{
            SucId="sucmsgForPasswordSetUp";
            ErrorId="errmsgForPasswordSetUp";
        }
        $("#"+SucId).html(msg);
        $("#"+ErrorId).css("display", "none");
        $("#"+SucId).css("display", "block");
        $("#paswordsetup-form")[0].reset();
        $("#"+SucId).fadeOut(4000,function(){
        var userdata=data.data;
        if(!detectDevices()){                   
                 var queryString = "pword=" +userdata['Pwd'] + "&email=" +userdata['Email'];
             ajaxRequest("/site/HDSUserLogin", queryString,loginHandler);
          }else{
              deleteCookie('Hds_user');
              window.location = '/site'; 
          }
            
        }); 
        //$("form").serialize()
    } else {
        var lengthvalue = data.error.length;
        var msg = data.message;
       
        var error = [];
        if (msg != "") {
            $("#errmsgForPasswordSetUp").html(msg);
            $("#errmsgForPasswordSetUp").css("display", "block");
            $("#sucmsgForPasswordSetUp").css("display", "none");
            $("#errmsgForPasswordSetUp").fadeOut(5000);
             
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
                    $("#" + key + "_em_").fadeOut(9000);
                    //  $("#"+key).parent().addClass('error');
                }

            });
        }
    }
}
function loginHandler(data){
     var data = eval(data);
        if (data.status == 'success') {
            var returnValue= 1;//trackBrowseDetails("http://localhost/");
            if(returnValue==1){
                deleteCookie('Hds_user');
             if (getCookie('r_u') != "") {
                var returnUrl = getCookie('r_u');
               
                   window.location = returnUrl.replace(/%2F/g, "/");
           
            }
            else {
                    window.location = '/';
                         }   
            }
        } 
}
</script>
