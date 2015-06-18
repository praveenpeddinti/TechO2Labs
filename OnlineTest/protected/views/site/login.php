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

			<div class="form-group loginform" id="usernamediv">
                            <label class="usernamelbl" for="userName" >User Name</label>
                            <?php echo $form->textField($this->model,'email',array('maxlength' => 40, 'class' => 'form-control email')); ?> 
			</div>
			<div class="form-group loginform" id="passworddiv">
                            <label for="password" class="passwordlbl">Password</label>
								
                            <?php echo $form->passwordField($this->model,'pword',array('maxlength' => 40, 'class' => 'form-control pwd')); ?> 
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

    
                    

               
 
      
 

<script type="text/javascript">
   
         function logincallback(data, txtstatus, xhr) {
            
        var data = eval(data);
        if (data.status == 'success') {alert("fffff");
            
          
                    window.location = '/users';
                    
            }
   
         else {
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
    

    
 sessionStorage.clear();
    </script>