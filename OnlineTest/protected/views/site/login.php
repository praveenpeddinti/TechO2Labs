<section class="login_bg" style="clear:both; height:370px; "> </section >
<section style="clear:both;" >
    <div class="container"  >
<div class="customLoginform customLoginformwidth positionlogin " style=" padding-bottom:50px; margin-bottom:120px; " >
            <div class="customLoginbg marginlr0">
<div class=" pagetitlebg marginlr0 paddingbottom8 pagetitleloginbg" >
                    <div class="section_pagetitle_padding padgetitle">
                        <h4 class="padding-left12" style="padding-bottom:10px">Admin Login</h4>
                        
                    </div>


<div class="row">
                    <div class="col-xs-12 ">
                        <div class="reg_area">      
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
<div id="error" class="errorMessage" style="display: none;"> 
        
    </div>
<div class="form-group loginform" id="usernamediv">
    <label class="usernamelbl" for="userName" >User Name</label>
    <?php echo $form->textField($this->model,'email',array('maxlength' => 40, 'class' => 'form-control email')); ?>
    </div>
                            <div class="control-group controlerror"> 
        <?php echo $form->error($this->model, 'email'); ?>
    </div>
<div class="form-group loginform" id="passworddiv">
    <label for="password" class="passwordlbl">Password</label>
    <?php echo $form->passwordField($this->model,'pword',array('maxlength' => 40, 'class' => 'form-control pwd')); ?> 
    
</div>
                            <div class="control-group controlerror"> 
        <?php echo $form->error($this->model, 'pword'); ?>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
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
                        array('type' => 'submit','class'=>'btn btn-primary btn-raised btn-custom')
                    );
            ?> 
        </div><!--end .col -->
    </div><!--end .row -->
<?php $this->endWidget(); ?>
                        </div>
                    </div></div></div>
</div>
    </div>
</section>
<script type="text/javascript">
   /*$("#loginId").bind("click",function(){
       var data = $("#login-form").serialize();
        $.ajax({
                type: 'POST',
                url: 'site/login',
                data: data,
                success: logincallback,
                error: function(data) { // if error occured
                     
                    // alert(data.toSource());
                },
                dataType: 'json'
            });
   });*/
   
   
    function logincallback(data, txtstatus, xhr) {
        var data = eval(data);
        if (data.status == 'success') {
                    window.location = '/users';
        }else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {
                if (data.error == "Invalid User Name and Password") { 
                    $("#error").text(data.error);
                    $("#error").show();
                    $("#error").fadeOut(5000);
                    $("#error").parent().addClass('error');
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
    

    
 sessionStorage.clear();
    </script>