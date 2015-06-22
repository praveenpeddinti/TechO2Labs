<div class=" pagetitlebg marginlr0 paddingbottom8 pagetitleloginbg" >
                    <div class="section_pagetitle_padding padgetitle">
                        <h4 class="padding-left12">Registration</h4>
                        <p>Register here to start your Online Test</p>
                    </div>
<div class="row">
                    <div class="col-xs-12 ">
                        <div class="reg_area">      
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form',
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
<div class="form-group loginform" id="fnamediv">
    <label class="usernamelbl" for="FirstName" >First Name</label>
    <?php echo $form->textField($model,'FirstName',array('maxlength' => 40, 'class' => 'form-control email')); ?>
    
</div>
                            <div class="control-group controlerror"> 
        <?php echo $form->error($model, 'FirstName'); ?>
    </div>
<div class="form-group loginform" id="lnamediv">
    <label class="lnamelbl" for="LastName" >Last Name</label>
    <?php echo $form->textField($model,'LastName',array('maxlength' => 40, 'class' => 'form-control email')); ?>
   
</div>
                             <div class="control-group controlerror"> 
        <?php echo $form->error($model, 'LastName'); ?>
    </div>
<div class="form-group loginform" id="emaildiv">
    <label class="emailbl" for="Email" >Email</label>
    <?php echo $form->textField($model,'Email',array('maxlength' => 40, 'class' => 'form-control email')); ?>
    <div class="control-group controlerror"> 
        <?php echo $form->error($model, 'Email'); ?>
    </div>
</div>
<div class="form-group loginform" id="phonediv">
    <label class="phonelbl" for="Phone" >Phone</label>
    <?php echo $form->textField($model,'Phone',array('maxlength' => 40, 'class' => 'form-control email')); ?>
    <div class="control-group controlerror"> 
        <?php echo $form->error($model, 'Phone'); ?>
    </div>
</div>
<div class="form-group loginform" id="pancarddiv">
    <label class="pancardlbl" for="Pancard" >Pancard</label>
    <?php echo $form->textField($model,'Pancard',array('maxlength' => 40, 'class' => 'form-control email')); ?>
    <div class="control-group controlerror"> 
        <?php echo $form->error($model, 'Pancard'); ?>
    </div>
</div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <?php
                echo CHtml::ajaxSubmitButton('Register', array('site/registration'),array(
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
                    'success' => 'function(data,status,xhr) { logincallbackre(data,status,xhr);}'),
                        array('type' => 'submit','class'=>'btn btn-primary btn-raised btn-custom')
                    );
            ?> 
        </div><!--end .col -->
    </div><!--end .row -->
<?php $this->endWidget(); ?>
                        </div>
                    </div></div>
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
   
   
    function logincallbackre(data, txtstatus, xhr) {
        var data = eval(data);
        if (data.status == 'success') {
                    window.location = '/site/privacyPolicy';
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